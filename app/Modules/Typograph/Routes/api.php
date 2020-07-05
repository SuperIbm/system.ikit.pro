<?php

Route::group([
    'middleware' => ['ajax'],
    'prefix' => 'api/ajax/typograph/typograph/'
], function() {
    Route::get('get/', 'TypographAdminController@get')->middleware('auth.api');
});

