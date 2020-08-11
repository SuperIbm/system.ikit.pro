<?php

Route::group([
    'middleware' => ['locale', 'ajax', 'school'],
    'prefix' => 'api/ajax/alert/alert/',
    "as" => "api.ajax.alert.alert"
], function() {
    Route::get('read/', 'AlertController@read')->middleware('auth.api', 'auth.user:section,alerts,read');
    Route::post('toRead/{id}', 'AlertController@toRead')->middleware('auth.api', 'auth.user:section,alerts,update');
    Route::delete('destroy/', 'AlertController@destroy')->middleware('auth.api', 'auth.user:section,alerts,destroy');
});
