<?php
Route::group([
    'middleware' => ['ajax'],
    'prefix' => 'api/ajax/cache/cache_controller/',
    "as" => "api.ajax.cache.cache_controller"
], function()
{
    Route::post('clean/', 'CacheController@clean')->middleware('auth.api', 'auth.admin')->name('clean');
});
