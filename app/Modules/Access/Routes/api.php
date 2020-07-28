<?php

Route::group([
    'middleware' => ['ajax'],
    'prefix' => 'inside/access/access/',
    "as" => "inside.access.access"
], function()
{
    Route::post('gate/', 'AccessController@gate')/*->middleware('auth.api')*/->name('gate');
    Route::post('logout/', 'AccessController@logout')->middleware('auth.api')->name('logout');
    Route::post('social/', 'AccessController@social')->name('social');
    Route::post('sign_up/', 'AccessController@signUp')->name('signUp');
    Route::post('verified/{id}', 'AccessController@verified')->name('verified');
    Route::get('verify', 'AccessController@verify')->middleware('auth.api')->name('verify');
    Route::get('verify/{email}', 'AccessController@verify')->name('verify');
    Route::post('forget', 'AccessController@forget')->name('forget');
    Route::get('reset_check/{id}', 'AccessController@resetCheck')->name('resetCheck');
    Route::post('reset/{id}', 'AccessController@reset')->name('reset');

    Route::put('update', 'AccessController@update')
        ->middleware('auth.api')
        ->name('update');

    Route::put('password', 'AccessController@password')
        ->middleware('auth.api')
        ->name('password');
});

Route::group([], function()
{
    Route::post('client', 'AccessApiController@client')->name('client');
    Route::post('token', 'AccessApiController@token')->name('token');
    Route::post('token/refresh', 'AccessApiController@refresh')->name('refresh');
});
