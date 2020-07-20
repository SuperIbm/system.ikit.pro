<?php

Route::group([

], function() {
    Route::get('/img/read/{school}/{name}', 'ImageController@read');
    Route::post('/img/{school}/create/', 'ImageController@create');
    Route::post('/img/{school}/update/', 'ImageController@update');
    Route::post('/img/{school}/destroy/', 'ImageController@destroy');
});
