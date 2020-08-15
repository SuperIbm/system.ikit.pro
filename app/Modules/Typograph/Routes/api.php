<?php

Route::group([
    'middleware' => ['locale', 'ajax', 'school'],
    'prefix' => 'private/typograph/typograph/',
    "as" => "private.typograph.typograph"
], function() {
    Route::get('get/', 'TypographAdminController@get')->middleware('auth.api', 'auth.user');
});

