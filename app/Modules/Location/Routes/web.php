<?php
Route::group([
    'middleware' => ['ajax'],
    'prefix' => 'api/ajax/location/location/',
    "as" => "api.ajax.location.location"
], function()
{
    Route::get('countries/', 'LocationController@countries');
    Route::get('regions/{country}', 'LocationController@regions');
});
