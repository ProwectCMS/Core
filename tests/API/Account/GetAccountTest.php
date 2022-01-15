<?php

namespace ProwectCMS\Core\Tests\API\Account;

use Laravel\Sanctum\Sanctum;
use ProwectCMS\Core\Models\Account;
use ProwectCMS\Core\Tests\TestCaseWithDatabase;

class GetAccountTest extends TestCaseWithDatabase
{
    public function testListAccountsUnauthenticated()
    {
        $response = $this->json('GET', 'api/accounts');
        $response->assertStatus(401);
    }

    public function testListAccountsUnauthorized()
    {
        $account = Account::findOrFail('frontend-user');

        Sanctum::actingAs($account, ['*'], 'prowectcms_api');

        $response = $this->json('GET', 'api/accounts');
        $response->assertStatus(403);
    }

    public function testListAccountsSuccess()
    {
        $account = Account::findOrFail('prowectcms-admin-user');

        Sanctum::actingAs($account, ['*'], 'prowectcms_api');

        $response = $this->json('GET', 'api/accounts');
        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id', 'type', 'meta'
                ]
            ]
        ]);
    }

    public function testShowAccountUnauthenticated()
    {
        $response = $this->json('GET', 'api/accounts/prowectcms-admin-user');
        $response->assertStatus(401);
    }

    public function testShowAccountUnauthorized()
    {
        $account = Account::findOrFail('frontend-user');

        Sanctum::actingAs($account, ['*'], 'prowectcms_api');

        $response = $this->json('GET', 'api/accounts/prowectcms-admin-user');
        $response->assertStatus(403);
    }

    public function testShowAccountSuccess()
    {
        $account = Account::findOrFail('prowectcms-admin-user');

        Sanctum::actingAs($account, ['*'], 'prowectcms_api');

        $response = $this->json('GET', 'api/accounts/prowectcms-admin-user');
        $response->assertOk();
        $response->assertJson([
            'id' => $account->id
        ]);
    }
}