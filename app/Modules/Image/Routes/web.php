<?php

Route::group([

], function() {
    Route::get('/img/read/{school}/{name}', 'ImageController@read');
    Route::post('/img/create/{school}', 'ImageController@create');
    Route::post('/img/update/{school}', 'ImageController@update');
    Route::post('/img/destroy/{school}', 'ImageController@destroy');
});
