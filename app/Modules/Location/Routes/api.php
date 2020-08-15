<?php

Route::group([
    'middleware' => ['locale', 'ajax', 'school'],
    'prefix' => 'private/location/location/',
    "as" => "private.location.location"
], function()
{
    Route::get('countries/', 'LocationController@countries')->middleware('auth.api', 'auth.user');
    Route::get('regions/{country}', 'LocationController@regions')->middleware('auth.api', 'auth.user');
});
