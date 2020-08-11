<?php

Route::group([
    'middleware' => ['locale', 'ajax', 'school'],
    'prefix' => 'api/ajax/typograph/typograph/'
], function() {
    Route::get('get/', 'TypographAdminController@get')->middleware('auth.api', 'auth.user');
});

