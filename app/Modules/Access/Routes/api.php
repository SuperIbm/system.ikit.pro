<?php

Route::group([
    'middleware' => ['locale', 'ajax'],
    'prefix' => 'private/access/access/',
    "as" => "private.access.access"
], function()
{
    Route::get('gate/', 'AccessController@gate')->middleware('auth.api', 'auth.user')->name('gate');
    Route::post('logout/', 'AccessController@logout')->middleware('auth.api', 'auth.user')->name('logout');
    Route::post('social/', 'AccessController@social')->name('social');
    Route::post('sign_up/', 'AccessController@signUp')->name('signUp');
    Route::post('sign_in/', 'AccessController@signIn')->name('signIn');
    Route::post('verify', 'AccessController@verify')->middleware('auth.api', 'auth.user')->name('verify');
    Route::post('verified/{id}', 'AccessController@verified')->name('verified');
    Route::post('forget', 'AccessController@forget')->name('forget');
    Route::get('reset_check/{id}', 'AccessController@resetCheck')->name('resetCheck');
    Route::post('reset/{id}', 'AccessController@reset')->name('reset');

    Route::put('update', 'AccessController@update')
        ->middleware('auth.api', 'auth.user')
        ->name('update');

    Route::put('password', 'AccessController@password')
        ->middleware('auth.api', 'auth.user')
        ->name('password');
});

Route::group([], function()
{
    Route::post('client', 'AccessApiController@client')->name('client');
    Route::post('token', 'AccessApiController@token')->name('token');
    Route::post('refresh', 'AccessApiController@refresh')->name('refresh');
});
