<?php

namespace Tests;

use Artisan;
use Cache;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, DatabaseMigrations, DatabaseTransactions;

    public function setUp(): void
    {
        parent::setUp();

        $this->artisan('db:seed');
        $this->artisan('module:seed');
    }

    protected function tearDown(): void
    {
        Cache::flush();
        Artisan::call("view:clear");
        Artisan::call("config:cache");
    }
}
