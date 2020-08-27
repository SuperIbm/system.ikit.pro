<?php
Route::group([
    'middleware' => ['locale', 'ajax', 'school'],
    'prefix' => 'private/user/user/',
    "as" => "private.user.user"
], function() {
    Route::get('read/', 'UserController@read')
        ->middleware('auth.api', 'auth.user:section,users,read')
        ->name("read");

    Route::get('get/{id}', 'UserController@get')
        ->middleware('auth.api', 'auth.user:section,users,read')
        ->name("get");

    Route::post('create/', 'UserController@create')
        ->middleware('auth.api', 'auth.user:section,users,create')
        ->name("create");

    Route::put('update/{id}', 'UserController@update')
        ->middleware('auth.api', 'auth.user:section,users,update')
        ->name("update");

    Route::put('password/{id}', 'UserController@password')
        ->middleware('auth.api', 'auth.user:section,users,update')
        ->name("password");

    Route::delete('destroy/', 'UserController@destroy')
        ->middleware('auth.api', 'auth.user:section,users,destroy')
        ->name("destroy");
});

Route::group([
    'middleware' => ['locale', 'ajax', 'school'],
    'prefix' => 'private/user/config/',
    "as" => "private.user.config"
], function() {
    Route::get('get', 'UserConfigController@get')
        ->middleware('auth.api', 'auth.user')
        ->name("get");

    Route::put('update', 'UserConfigController@update')
        ->middleware('auth.api', 'auth.user')
        ->name("update");
});

Route::group([
    'middleware' => ['locale', 'ajax', 'school'],
    'prefix' => 'private/user/image/',
    "as" => "private.user.image"
], function() {
    Route::get('get/{id}', 'UserImageController@read')
        ->middleware('auth.api', 'auth.user:section,users,read')
        ->name("read");

    Route::put('update/{id}', 'UserImageController@update')
        ->middleware('auth.api', 'auth.user:section,users,update')
        ->name("update");

    Route::delete('destroy/{id}', 'UserImageController@destroy')
        ->middleware('auth.api', 'auth.user:section,users,destroy')
        ->name("destroy");
});
