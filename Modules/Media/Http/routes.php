<?php

Route::group(['middleware' => 'web', 'prefix' => 'media', 'namespace' => 'Modules\Media\Http\Controllers'], function()
{
    Route::get('/', 'MediaController@index');
    Route::post('/', 'MediaController@addmedia');
    Route::get('/data', 'MediaController@data');
});