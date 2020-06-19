<?php
Route::group
(
    [
        'middleware' => 'web'
    ],
    function()
    {
        Route::get('/img/read/{name}', 'ImageController@read');
        Route::post('/img/create/', 'ImageController@create');
        Route::post('/img/update/', 'ImageController@update');
        Route::post('/img/destroy/', 'ImageController@destroy');
    }
);
