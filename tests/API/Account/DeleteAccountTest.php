<?php

namespace ProwectCMS\Core\Tests\API\Account;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use ProwectCMS\Core\Events\Account\AccountCreated;
use ProwectCMS\Core\Models\Account;
use ProwectCMS\Core\Tests\TestCaseWithDatabase;
use Ramsey\Uuid\Uuid;

class DeleteAccountTest extends TestCaseWithDatabase
{
    // public function testDeleteAccountUnauthenticated()
    // {
    //     $response = $this->delete('api/accounts/prowectcms-admin-user');
    //     $response->assertStatus(401);
    // }

    // public function testDeleteAccountUnauthorized()
    // {
    //     $account = Account::findOrFail('frontend-user');

    //     $this->actingAs($account);
    //     $response = $this->delete('api/accounts/prowectcms-admin-user');
    //     $response->assertStatus(403);
    // }

    // public function testDeleteAccountSuccess()
    // {
    //     $account = Account::findOrFail('prowectcms-admin-user');

    //     $this->actingAs($account);
    //     $response = $this->delete('api/accounts/prowectcms-admin-user');
    //     $response->assertOk();
    //     $response->assertJson([
    //         'status' => 'ok',
    //         'key' => 'account.delete.success'
    //     ]);   
    // }
}