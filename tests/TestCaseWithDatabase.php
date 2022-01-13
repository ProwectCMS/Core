<?php

namespace ProwectCMS\Core\Tests;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use ProwectCMS\Core\Database\Seeders\Test\TestSeeder;
use ProwectCMS\Core\ProwectCmsAuthServiceProvider;
use ProwectCMS\Core\ProwectCmsEventSourcingServiceProvider;
use ProwectCMS\Core\ProwectCmsServiceProvider;
use Spatie\EventSourcing\EventSourcingServiceProvider;
use Spatie\LaravelSettings\LaravelSettingsServiceProvider;

class TestCaseWithDatabase extends TestCase
{
    use DatabaseMigrations, RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed(TestSeeder::class);
    }
}