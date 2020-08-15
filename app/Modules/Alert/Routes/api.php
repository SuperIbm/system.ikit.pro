<?php

Route::group([
    'middleware' => ['locale', 'ajax', 'school'],
    'prefix' => 'private/alert/alert/',
    "as" => "private.alert.alert"
], function() {
    Route::get('read/', 'AlertController@read')->middleware('auth.api', 'auth.user:section,alerts,read');
    Route::post('toRead/{id}', 'AlertController@toRead')->middleware('auth.api', 'auth.user:section,alerts,update');
    Route::delete('destroy/', 'AlertController@destroy')->middleware('auth.api', 'auth.user:section,alerts,destroy');
});
