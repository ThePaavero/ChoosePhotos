<?php

class ProjectController extends \BaseController
{
    private $project;

    public function __construct()
    {
        $this->project = new Project;
    }


    public function project($slug)
    {
        $data = [
            'slug' => $slug,
            'title' => ucfirst($slug),
            'images' => $this->project->getSingleInstance($slug)
        ];

        return View::make('maintemplate', [
            'title' => $data['title'],
            'page' => 'project',
            'data' => $data
        ]);
    }

    public function updatePictureStatus()
    {
        $projectSlug = Input::get('project_slug');
        $imageFilename = Input::get('filename');

        if ($this->project->updatePictureStatus($projectSlug, $imageFilename))
        {
            return 'ok';
        }

        return 'error';
    }
}
