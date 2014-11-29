<?php

class ProjectController extends \BaseController
{
    public function project($slug)
    {
        $project = new Project;
        $data = [
            'title' => ucfirst($slug),
            'images' => $project->getSingleInstance($slug)
        ];

        return View::make('maintemplate', [
            'title' => 'Project',
            'page' => 'project',
            'data' => $data
        ]);
    }
}