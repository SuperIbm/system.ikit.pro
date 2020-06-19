<?php
Route::group([
    'middleware' => ['ajax'],
    'prefix' => 'api/ajax/location/location_controller/',
    "as" => "api.ajax.location.location_controller"
], function()
{
    Route::get('countries/', 'LocationController@countries');
    Route::get('regions/{country}', 'LocationController@regions');
});
