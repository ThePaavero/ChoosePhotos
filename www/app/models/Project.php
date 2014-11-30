<?php

use Intervention\Image\ImageManager;

class Project extends Eloquent
{
    protected $table = 'photos';
    public $rootDir;

    public function __construct()
    {
        $this->rootDir = __DIR__ . '/../../public/projects/';
    }

    public function getAllProjects()
    {
        $projects = [];

        $directories = scandir($this->rootDir);

        foreach ($directories as $dir)
        {
            $rawDir = $dir;
            $dir = $this->rootDir . $dir . '/';

            if ( ! is_dir($dir) || in_array($rawDir, ['.', '..']))
            {
                continue;
            }

            $projects[] = $rawDir;

            $files = scandir($dir);

            $zipPath = '';

            // See if we have a zip file
            foreach ($files as $file)
            {
                if (strstr($file, '.zip'))
                {
                    $zipPath = $dir . $file;
                }
            }

            if ($zipPath !== '')
            {
                // Yes we do, unzip it
                $zip = new ZipArchive;
                $res = $zip->open($zipPath);

                // Make sure we have directories for our resized images
                $dirForSmall = $dir . 'small';
                $dirForLarge = $dir . 'large';

                if ( ! is_dir($dirForSmall))
                {
                    mkdir($dirForSmall);
                }

                if ( ! is_dir($dirForLarge))
                {
                    mkdir($dirForLarge);
                }

                if ($res === true)
                {
                    $zip->extractTo($dir);
                    $zip->close();

                    // We don't want the ZIP file to exist anymore; delete it
                    unlink($zipPath);
                }
                else
                {
                    throw new Exception('ZIP file found, but could not unzip it!');
                }
            }
        }

        return $projects;
    }

    public function getPhotosUnderProject($slug)
    {
        $manager = new ImageManager(array ('driver' => 'GD'));

        $formats = ['jpg', 'png', 'gif', 'JPG', 'PNG', 'GIF'];

        $images = [];
        $myDir = $this->rootDir . $slug . '/';

        if ( ! is_dir($myDir))
        {
            return false;
        }

        $files = scandir($myDir);

        foreach ($files as $file)
        {
            $fullPath = $myDir . $file;
            $fullUrl = URL::to('projects/' . $slug . '/' . $file);

            if ( ! file_exists($fullPath) || is_dir($fullPath))
            {
                continue;
            }

            $bits = explode('.', $file);
            $fileFormat = end($bits);

            if ( ! in_array($fileFormat, $formats))
            {
                continue;
            }

            $dirForSmall = $myDir . 'small';
            $dirForLarge = $myDir . 'large';

            // Create thumbnails if they don't exist yet
            $thumbNailPath = $dirForSmall . '/' . $file;
            $gallerySizePath = $dirForLarge . '/' . $file;

            $thumbNailUrl = URL::to('projects/' . $slug . '/small/' . $file);
            $gallerySizeUrl = URL::to('projects/' . $slug . '/large/' . $file);

            if ( ! file_exists($thumbNailPath))
            {
                $image = $manager->make($fullPath)->resize(300, null, function ($constraint)
                {
                    $constraint->aspectRatio();
                });

                $image->save($thumbNailPath, 80);
            }

            if ( ! file_exists($gallerySizePath))
            {
                $image = $manager->make($fullPath)->resize(1280, null, function ($constraint)
                {
                    $constraint->aspectRatio();
                });

                $image->save($gallerySizePath, 90);
            }

            $photoHash = md5($slug . '/' . $file);

            $images[] = [
                'fullPath' => $fullPath,
                'filename' => $file,
                'fullUrl' => $fullUrl,
                'thumbnail' => $thumbNailUrl,
                'large' => $gallerySizeUrl,
                'accepted' => $this->getAcceptedStatusForPhoto($photoHash)
            ];
        }

        return $images;
    }

    public function updatePictureStatus($projectSlug, $imageFilename)
    {
        $hashThis = $projectSlug . '/' . $imageFilename;
        $photoHash = md5($hashThis);

        // Do we have a database row?
        $rowObject = self::where('hash', '=', $photoHash)->first();

        if ( ! is_null($rowObject))
        {
            // Yes, get our current status
            $accepted = $rowObject->accepted;

            // Flip it
            $newStatus = ! $accepted;

            $rowObject->accepted = $newStatus;
            $rowObject->save();

            return true;
        }

        // No? Create one with a default status of false
        $instance = new self;
        $instance->hash = $photoHash;
        $instance->accepted = true;
        $instance->save();

        return true;
    }

    public function getAcceptedStatusForPhoto($photoHash)
    {
        $accepted = false; // Default

        // Do we have a row in our database?
        $exists = self::where('hash', '=', $photoHash)->first();

        if ( ! is_null($exists))
        {
            $accepted = $exists->accepted;
        }

        return $accepted ? 'yes' : 'no';
    }
}