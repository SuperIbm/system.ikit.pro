<?php

Route::group([
    'middleware' => ['ajax'],
    'prefix' => 'api/ajax/location/location/',
    "as" => "api.ajax.location.location"
], function()
{
    Route::get('countries/', 'LocationController@countries')->middleware('auth.api');
    Route::get('regions/{country}', 'LocationController@regions')->middleware('auth.api');
});
