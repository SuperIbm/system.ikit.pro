<?php
Route::group([

], function() {
    Route::get('/doc/read/{school}/{name}', 'DocumentController@read');
    Route::post('/doc/create/{school}', 'DocumentController@create');
    Route::post('/doc/update/{school}', 'DocumentController@update');
    Route::post('/doc/destroy/{school}', 'DocumentController@destroy');
});
