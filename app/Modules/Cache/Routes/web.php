<?php
Route::group([
    'middleware' => ['ajax'],
    'prefix' => 'api/ajax/cache/cache/',
    "as" => "api.ajax.cache.cache"
], function()
{
    Route::post('clean/', 'CacheController@clean')->middleware('auth.api')->name('clean');
});
