<?php

class Project
{
    public $rootDir;

    public function __construct()
    {
        $this->rootDir = __DIR__ . '/../../projects/';
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
        $formats = ['jpg', 'png', 'gif'];

        $images = [];
        $myDir = $this->rootDir . $slug . '/';
        $files = scandir($myDir);

        foreach ($files as $file)
        {
            $fullPath = $myDir . $file;

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

            $images[] = [
                'fullPath' => $fullPath,
                'filename' => $file
            ];
        }

        return $images;
    }
}