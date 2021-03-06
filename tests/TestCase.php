<?php

namespace ProwectCMS\Core\Tests;

use Orchestra\Testbench\TestCase as BaseTestCase;
use ProwectCMS\Core\ProwectCmsServiceProvider;
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
            LaravelSettingsServiceProvider::class,
            EventSourcingServiceProvider::class,
            ProwectCmsServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        // perform environment setup
    }
}