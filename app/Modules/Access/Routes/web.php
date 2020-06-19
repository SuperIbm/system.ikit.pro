<?php
Route::group([
    'middleware' => ['ajax'],
    'prefix' => 'api/ajax/access/access_admin_controller/',
    "as" => "api.ajax.access.access_admin_controller"
], function()
{
    Route::post('gate/', 'AccessAdminController@gate')->middleware('auth.api')->name('gate');
    Route::post('logout/', 'AccessAdminController@logout')->middleware('auth.api')->name('logout');
});

Route::group([
    'middleware' => ['ajax'],
    'prefix' => 'api/ajax/access/access_site_controller/',
    "as" => "api.ajax.access.access_site_controller"
], function()
{
    Route::post('social/', 'AccessSiteController@social')->name('social');
    Route::post('sign_up/', 'AccessSiteController@signUp')->name('signUp');
    Route::post('verified/{id}', 'AccessSiteController@verified')->name('verified');
    Route::get('verify', 'AccessSiteController@verify')->middleware('auth.api', 'auth.user')->name('verify');
    Route::get('verify/{email}', 'AccessSiteController@verify')->name('verify');
    Route::post('forget', 'AccessSiteController@forget')->name('forget');
    Route::get('reset_check/{id}', 'AccessSiteController@resetCheck')->name('resetCheck');
    Route::post('reset/{id}', 'AccessSiteController@reset')->name('reset');

    Route::put('update', 'AccessSiteController@update')
        ->middleware('auth.api', 'auth.user')
        ->name('update');

    Route::put('password', 'AccessSiteController@password')
        ->middleware('auth.api', 'auth.user')
        ->name('password');
});

Route::group([
    "prefix" => "api/",
    "as" => "api."
], function()
{
    Route::post('client', 'AccessApiController@client')->name('client');
    Route::post('token', 'AccessApiController@token')->name('token');
    Route::post('token/refresh', 'AccessApiController@refresh')->name('refresh');
});