<?php

Route::group([
    'middleware' => ['locale', 'school', 'ajax'],
    'prefix' => 'api/ajax/location/location/',
    "as" => "api.ajax.location.location"
], function()
{
    Route::get('countries/', 'LocationController@countries')->middleware('auth.api', 'auth.user');
    Route::get('regions/{country}', 'LocationController@regions')->middleware('auth.api', 'auth.user');
});
