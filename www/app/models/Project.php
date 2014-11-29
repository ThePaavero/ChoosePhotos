<?php

use Intervention\Image\ImageManager;

class Project
{
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

                if ($res === true)
                {
                    $zip->extractTo($dir);
                    $zip->close();

                    // We don't want the ZIP file to exist anymore, delete it
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

    public function getSingleInstance($slug)
    {
        $manager = new ImageManager(array ('driver' => 'GD'));

        $formats = ['jpg', 'png', 'gif'];

        $images = [];
        $myDir = $this->rootDir . $slug . '/';
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

            // Create thumbnails if they don't exist yet
            $thumbNailPath = $myDir . 'small/' . $file;
            $gallerySizePath = $myDir . 'large/' . $file;

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

            $images[] = [
                'fullPath' => $fullPath,
                'filename' => $file,
                'fullUrl' => $fullUrl
            ];
        }

        return $images;
    }
}