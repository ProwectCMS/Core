<?php

namespace ProwectCMS\Core\Tests\API\Account;

use Laravel\Sanctum\Sanctum;
use ProwectCMS\Core\Models\Account;
use ProwectCMS\Core\Tests\TestCaseWithDatabase;

class UpdateAccountTest extends TestCaseWithDatabase
{
    public function testUpdateAccountUnauthenticated()
    {
        $response = $this->json('PATCH', 'api/accounts/prowectcms-admin-user');
        $response->assertStatus(401);
    }

    public function testUpdateAccountUnauthorized()
    {
        $account = Account::findOrFail('frontend-user');

        Sanctum::actingAs($account, ['*'], 'prowectcms_api');

        $response = $this->json('PATCH', 'api/accounts/prowectcms-admin-user');
        $response->assertStatus(403);
    }

    public function testUpdateAccountSuccess()
    {
        $account = Account::findOrFail('prowectcms-admin-user');

        Sanctum::actingAs($account, ['*'], 'prowectcms_api');

        $this->assertEmpty($account->meta);

        $payload = [
            'meta' => [
                'example' => 'bla'
            ]
        ];

        $response = $this->json('PATCH', 'api/accounts/prowectcms-admin-user', $payload);
        $response->assertOk();
        $response->assertJson([
           'status' => 'ok',
           'key' => 'account.update.success'
        ]);

        $account->refresh();

        $this->assertNotEmpty($account->meta);
        $this->assertEquals($payload['meta'], $account->meta);
    }
}