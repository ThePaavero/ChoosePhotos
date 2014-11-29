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

            $files = scandir($dir);

            $zipPath = '';

            foreach($files as $file)
            {
                // Get our ZIP file
                if(strstr($file, '.zip'))
                {
                    $zipPath = $dir . $file;
                }

                echo $zipPath;
            }
        }

        return $projects;
    }
}