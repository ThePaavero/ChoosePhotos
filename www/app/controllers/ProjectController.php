<?php

class ProjectController extends \BaseController
{
    private $project;

    public function __construct()
    {
        $this->project = new Project;
    }


    public function project($slug = '', $token = '')
    {
        $gallery = Gallery::where('dir', '=', $slug)->get();

        if (is_null($gallery))
        {
            return Response::make(View::make('maintemplate', [
                'title' => 'Project not found',
                'page' => 'project_404'
            ]), 404);
        }

        $gallery = $gallery->first();

        // Check the token
        $correctToken = $gallery->token;

        if($token !== $correctToken)
        {
            App::abort(403, 'Faulty token.');
        }

        $images = $this->project->getPhotosUnderProject($slug);

        $data = [
            'slug' => $slug,
            'title' => ucfirst($slug),
            'images' => $images
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

    public function notifyOfUpdate($slug)
    {
        // Figure out the URL for this project
        $data = [
            'url' => URL::to('project/' . $slug)
        ];

        // Send an email about it
        Mail::send('emails.update', ['data' => $data], function ($message)
        {
            $to = Config::get('mail.sendNotificationsTo');
            $message->to($to)->subject('A client updated a photoshoot');
        });

        return 'ok';
    }
}
