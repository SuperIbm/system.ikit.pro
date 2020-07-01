<?php
Route::group([
    'middleware' => 'web'
], function() {
    Route::get('/doc/read/{name}', 'DocumentController@read');
    Route::post('/doc/create/', 'DocumentController@create');
    Route::post('/doc/update/', 'DocumentController@update');
    Route::post('/doc/destroy/', 'DocumentController@destroy');
});
