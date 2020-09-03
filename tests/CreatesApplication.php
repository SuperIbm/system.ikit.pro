<?php

namespace Tests;

use Artisan;
use Cache;
use Illuminate\Contracts\Console\Kernel;

trait CreatesApplication
{
    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make(Kernel::class)->bootstrap();

        Cache::flush();
        Artisan::call("view:clear");
        Artisan::call("config:cache");

        return $app;
    }
}
