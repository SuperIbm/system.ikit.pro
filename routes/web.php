<?php

use App\Modules\User\Models\User;

Route::group([
], function() {
    Route::get('/', function()
    {
        print_r(config("database.default"));
    });
});