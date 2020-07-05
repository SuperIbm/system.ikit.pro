<?php

Route::get('{uri}', '\\' . App\Modules\Core\Http\Controllers\CoreController::class)->where('uri', '(((?!api/).)[a-zA-Z0-9-_/]*)|(/?)');


