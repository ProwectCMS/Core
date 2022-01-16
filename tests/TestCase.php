<?php

namespace ProwectCMS\Core\Tests;

use Kra8\Snowflake\Providers\LaravelServiceProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;
use ProwectCMS\Core\Providers\AuthServiceProvider;
use ProwectCMS\Core\Providers\SanctumServiceProvider;
use ProwectCMS\Core\Providers\ServiceProvider;
use ProwectCMS\Core\Providers\EventSourcingServiceProvider as ProwectCmsEventSourcingServiceProvider;
use Spatie\EventSourcing\EventSourcingServiceProvider;
use Spatie\LaravelSettings\LaravelSettingsServiceProvider;

class TestCase extends BaseTestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    protected function getPackageProviders($app)
    {
        return [
            // Other packages
            LaravelSettingsServiceProvider::class,
            EventSourcingServiceProvider::class,
            LaravelServiceProvider::class,

            // ProwectCMS
            ServiceProvider::class,
            AuthServiceProvider::class,
            ProwectCmsEventSourcingServiceProvider::class,
            SanctumServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        // perform environment setup
    }
}