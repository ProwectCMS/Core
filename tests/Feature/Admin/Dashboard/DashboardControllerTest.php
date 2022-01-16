<?php

namespace ProwectCMS\Core\Tests\Feature\Admin\Dashboard;

use Illuminate\Foundation\Testing\RefreshDatabase;
use ProwectCMS\Core\Database\Seeders\Test\TestSeeder;
use ProwectCMS\Core\Models\Account;
use ProwectCMS\Core\Models\AccountCredential;
use ProwectCMS\Core\Tests\TestCase;

class DashboardControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testViewDashboardUnauthenticated()
    {
        $response = $this->get(route('prowectcms.admin.dashboard'));
        $response->assertRedirect(route('prowectcms.admin.login'));
    }

    public function testViewDashboardSuccess()
    {
        $this->seed(TestSeeder::class);

        $account = Account::findOrFail(10000);

        $this->actingAs($account, 'prowectcms');

        $response = $this->get(route('prowectcms.admin.dashboard'));
        $response->assertOk();
    }
}