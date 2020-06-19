<?php
Route::group
(
    [
        'middleware' => ['ajax'],
        'prefix' => 'api/ajax/user/block_ip_admin_controller/',
        "as" => "api.ajax.user.block_admin_controller"
    ],
    function()
    {
        Route::get('read/', 'BlockIpAdminController@read')
            ->middleware('auth.api', 'auth.admin:section,users,read')
            ->name("read");

        Route::get('get/{id}', 'BlockIpAdminController@get')
            ->middleware('auth.api', 'auth.admin:section,users,read')
            ->name("get");

        Route::post('create/', 'BlockIpAdminController@create')
            ->middleware('auth.api', 'auth.admin:section,users,create')
            ->name("create");

        Route::put('update/{id}', 'BlockIpAdminController@update')
            ->middleware('auth.api', 'auth.admin:section,users,update')
            ->name("update");

        Route::delete('destroy/', 'BlockIpAdminController@destroy')
            ->middleware('auth.api', 'auth.admin:section,users,destroy')
            ->name("destroy");
    }
);

Route::group
(
    [
        'middleware' => ['ajax'],
        'prefix' => 'api/ajax/user/user_group_admin_controller/',
        "as" => "api.ajax.user.user_group_admin_controller"
    ],
    function()
    {
        Route::get('read/', 'UserGroupAdminController@read')
            ->middleware('auth.api', 'auth.admin:section,users,read')
            ->name("read");

        Route::get('get/{id}', 'UserGroupAdminController@get')
            ->middleware('auth.api', 'auth.admin:section,users,read')
            ->name("get");

        Route::post('create/', 'UserGroupAdminController@create')
            ->middleware('auth.api', 'auth.admin:section,users,create')
            ->name("create");

        Route::put('update/{id}', 'UserGroupAdminController@update')
            ->middleware('auth.api', 'auth.admin:section,users,update')
            ->name("update");

        Route::delete('destroy/', 'UserGroupAdminController@destroy')
            ->middleware('auth.api', 'auth.admin:section,users,destroy')
            ->name("destroy");
    }
);

Route::group
(
    [
        'middleware' => ['ajax'],
        'prefix' => 'api/ajax/user/user_role_admin_controller/',
        "as" => "api.ajax.user.user_role_admin_controller"
    ],
    function()
    {
        Route::get('read/', 'UserRoleAdminController@read')
            ->middleware('auth.api', 'auth.admin:section,users,read')
            ->name("read");

        Route::get('get/{id}', 'UserRoleAdminController@get')
            ->middleware('auth.api', 'auth.admin:section,users,read')
            ->name("get");

        Route::post('create/', 'UserRoleAdminController@create')
            ->middleware('auth.api', 'auth.admin:section,users,create')
            ->name("create");

        Route::put('update/{id}', 'UserRoleAdminController@update')
            ->middleware('auth.api', 'auth.admin:section,users,update')
            ->name("update");

        Route::delete('destroy/', 'UserRoleAdminController@destroy')
            ->middleware('auth.api', 'auth.admin:section,users,destroy')
            ->name("destroy");
    }
);

Route::group
(
    [
        'middleware' => ['ajax'],
        'prefix' => 'api/ajax/user/user_admin_controller/',
        "as" => "api.ajax.user.user_admin_controller"
    ],
    function()
    {
        Route::get('read/', 'UserAdminController@read')
            ->middleware('auth.api', 'auth.admin:section,users,read')
            ->name("read");

        Route::get('get/{id}', 'UserAdminController@get')
            ->middleware('auth.api', 'auth.admin')
            ->name("get");

        Route::post('create/', 'UserAdminController@create')
            ->middleware('auth.api', 'auth.admin:section,users,create')
            ->name("create");

        Route::put('update/{id}', 'UserAdminController@update')
            ->middleware('auth.api', 'auth.admin')
            ->name("update");

        Route::put('password/{id}', 'UserAdminController@password')
            ->middleware('auth.api', 'auth.admin')
            ->name("password");

        Route::delete('destroy/', 'UserAdminController@destroy')
            ->middleware('auth.api', 'auth.admin:section,users,destroy')
            ->name("destroy");
    }
);

Route::group
(
    [
        'middleware' => ['ajax'],
        'prefix' => 'api/ajax/user/user_config_admin_controller/',
        "as" => "api.ajax.user.user_config_admin_controller"
    ],
    function()
    {
        Route::get('get/{id}', 'UserConfigAdminController@get')
            ->middleware('auth.api', 'auth.admin')
            ->name("get");

        Route::put('update/{id}', 'UserConfigAdminController@update')
            ->middleware('auth.api', 'auth.admin')
            ->name("update");
    }
);

Route::group
(
    [
        'middleware' => ['ajax'],
        'prefix' => 'api/ajax/user/user_image_admin_controller/',
        "as" => "api.ajax.user.user_image_admin_controller"
    ],
    function()
    {
        Route::get('get/{id}', 'UserImageAdminController@read')
            ->middleware('auth.api', 'auth.admin:section,users,read')
            ->name("read");

        Route::put('update/{id}', 'UserImageAdminController@update')
            ->middleware('auth.api', 'auth.admin')
            ->name("update");

        Route::delete('destroy/{id}', 'UserImageAdminController@destroy')
            ->middleware('auth.api', 'auth.admin:section,users,destroy')
            ->name("destroy");
    }
);

Route::group
(
    [
        'middleware' => ['ajax'],
        'prefix' => 'api/ajax/user/user_image_site_controller/',
        "as" => "api.ajax.user.user_image_site_controller"
    ],
    function()
    {
        Route::put('update', 'UserImageSiteController@update')
            ->middleware('auth.api', 'auth.user')
            ->name("update");

        Route::delete('destroy', 'UserImageSiteController@destroy')
            ->middleware('auth.api', 'auth.user')
            ->name("destroy");
    }
);