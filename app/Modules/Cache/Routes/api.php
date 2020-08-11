<?php

Route::group([
    'middleware' => ['locale', 'school', 'ajax'],
    'prefix' => 'api/ajax/cache/cache/',
    "as" => "api.ajax.cache.cache"
], function()
{
    Route::post('clean/', 'CacheController@clean')->middleware('auth.api', 'auth.user')->name('clean');
});

