<?php

Route::group([
    'middleware' => ['locale', 'ajax', 'school'],
    'prefix' => 'private/cache/cache/',
    "as" => "private.cache.cache"
], function()
{
    Route::post('clean/', 'CacheController@clean')->middleware('auth.api', 'auth.user')->name('clean');
});

