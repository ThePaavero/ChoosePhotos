<?php

Route::get('/', 'HomeController@index');
Route::get('/project/{slug?}', 'ProjectController@project');
Route::post('/project/{slug}/update-status', 'ProjectController@updatePictureStatus');
