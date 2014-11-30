<?php

Route::group(array ('before' => 'auth.basic'), function ()
{
    Route::get('/', 'HomeController@index');
});

Route::get('/project/{slug?}', 'ProjectController@project');
Route::post('/project/{slug}/update-status', 'ProjectController@updatePictureStatus');
Route::get('/notify-of-update/{slug}', 'ProjectController@notifyOfUpdate');
