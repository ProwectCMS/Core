<?php

namespace ProwectCMS\Core\Tests;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use ProwectCMS\Core\Database\Seeders\Test\TestSeeder;

class TestCaseWithDatabase extends TestCase
{
    use DatabaseMigrations, RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed(TestSeeder::class);
    }
}