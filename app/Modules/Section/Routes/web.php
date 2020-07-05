<?php
Route::group([
    'middleware' => ['ajax'],
    'prefix' => 'api/ajax/section/section/',
    "as" => "api.ajax.section.section"
], function()
{
    Route::get('sections/', 'SectionController@sections')
        ->middleware('auth.api')->name("sections");
});
