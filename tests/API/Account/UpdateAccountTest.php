<?php

namespace ProwectCMS\Core\Tests\API\Account;

use Laravel\Sanctum\Sanctum;
use ProwectCMS\Core\Models\Account;
use ProwectCMS\Core\Tests\TestCaseWithDatabase;

class UpdateAccountTest extends TestCaseWithDatabase
{
    public function testUpdateAccountUnauthenticated()
    {
        $response = $this->json('PATCH', 'api/accounts/10000');
        $response->assertStatus(401);
    }

    public function testUpdateAccountUnauthorized()
    {
        $account = Account::findOrFail(20000);

        Sanctum::actingAs($account, ['*'], 'prowectcms_api');

        $response = $this->json('PATCH', 'api/accounts/10000');
        $response->assertStatus(403);
    }

    public function testUpdateAccountSuccess()
    {
        $account = Account::findOrFail(10000);

        Sanctum::actingAs($account, ['*'], 'prowectcms_api');

        $this->assertEmpty($account->meta);

        $payload = [
            'meta' => [
                'example' => 'bla'
            ]
        ];

        $response = $this->json('PATCH', 'api/accounts/10000', $payload);
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