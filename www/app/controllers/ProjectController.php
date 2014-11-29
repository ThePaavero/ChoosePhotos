<?php

class ProjectController extends \BaseController
{
    public function project($slug)
    {
        $project = new Project;
        $data = [
            'slug' => $slug,
            'title' => ucfirst($slug),
            'images' => $project->getSingleInstance($slug)
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

//        die($imageFilename);
        return 'ok';
    }
}
