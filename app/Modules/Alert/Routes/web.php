<?php
Route::group([
    'middleware' => ['ajax'],
    'prefix' => 'api/ajax/alert/alert_admin_controller/'
], function()
{
    Route::get('read/', 'AlertAdminController@read')->middleware('auth.api', 'auth.admin:section,alerts,read');
    Route::post('toRead/{id}', 'AlertAdminController@toRead')->middleware('auth.api', 'auth.admin:section,alerts,update');
    Route::delete('destroy/', 'AlertAdminController@destroy')->middleware('auth.api');
});
