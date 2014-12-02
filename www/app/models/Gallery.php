<?php

use Intervention\Image\ImageManager;

class Gallery extends Eloquent
{
    protected $table = 'galleries';
    protected $fillable = ['dir', 'token'];
    public $rootDir;

    public function __construct()
    {
        $this->rootDir = __DIR__ . '/../../public/projects/';
    }

}
