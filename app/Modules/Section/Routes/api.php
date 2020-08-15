<?php

Route::group([
    'middleware' => ['ajax'],
    'prefix' => 'private/section/section/',
    "as" => "private.section.section"
], function()
{
    Route::get('sections/', 'SectionController@sections')
        ->middleware('auth.api')->name("sections");
});

