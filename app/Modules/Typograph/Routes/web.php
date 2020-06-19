<?php
Route::group
(
    [
        'middleware' => ['ajax'],
        'prefix' => 'api/ajax/typograph/typograph_admin_controller/'
    ],
    function()
    {
        Route::get('get/', 'TypographAdminController@get')
            ->middleware('auth.admin');
    }
);
