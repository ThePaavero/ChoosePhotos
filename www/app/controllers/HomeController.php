<?php

class HomeController extends BaseController
{
    public function index()
    {
        $project = new Project;
        $projects = $project->getAllProjects();

        return View::make('maintemplate', [
            'title' => 'ChoosePhotos',
            'page' => 'home',
            'projects' => $projects
        ]);
    }

}
