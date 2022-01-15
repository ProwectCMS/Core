<?php

namespace ProwectCMS\Core\Tests\API\Account;

use Laravel\Sanctum\Sanctum;
use ProwectCMS\Core\Models\Account;
use ProwectCMS\Core\Models\AccountCredential;
use ProwectCMS\Core\Tests\TestCaseWithDatabase;
use Ramsey\Uuid\Uuid;

class UpdateAccountCredentialTest extends TestCaseWithDatabase
{
    public function testUpdateAccountCredentialTokenUnauthenticated()
    {
        $account = Account::findOrFail('prowectcms-admin-user');
        $accountCredential = $account->credentials()->where('type', AccountCredential::TYPE_TOKEN)->first();

        $payload = [
            'token' => 'N3WT0K3N'
        ];

        $response = $this->json('PATCH', "api/accounts/$account->id/credentials/token/$accountCredential->id", $payload);
        $response->assertStatus(401);
    }

    public function testUpdateAccountCredentialTokenUnauthorized()
    {
        $account = Account::findOrFail('frontend-user');

        Sanctum::actingAs($account, ['*'], 'prowectcms_api');

        $account = Account::findOrFail('prowectcms-admin-user');
        $accountCredential = $account->credentials()->where('type', AccountCredential::TYPE_TOKEN)->first();

        $payload = [
            'token' => 'N3WT0K3N'
        ];

        $response = $this->json('PATCH', "api/accounts/$account->id/credentials/token/$accountCredential->id", $payload);
        $response->assertStatus(403);
    }

    public function testUpdateAccountCredentialTokenSuccess()
    {
        $account = Account::findOrFail('prowectcms-admin-user');
        $accountCredential = $account->credentials()->where('type', AccountCredential::TYPE_TOKEN)->first();

        Sanctum::actingAs($account, ['*'], 'prowectcms_api');

        $payload = [
            'token' => 'N3WT0K3N'
        ];

        $response = $this->json('PATCH', "api/accounts/$account->id/credentials/token/$accountCredential->id", $payload);
        $response->assertOk();
        $response->assertJson([
            'status' => 'ok',
            'key' => 'account.credential.update.success',
        ]);

        $this->assertDatabaseMissing('account_credentials', [
            'id' => $accountCredential->id,
            'type' => accountCredential::TYPE_TOKEN,
            'username' => 'T3ST'
        ]);
        $this->assertDatabaseHas('account_credentials', [
            'id' => $accountCredential->id,
            'type' => accountCredential::TYPE_TOKEN,
            'username' => 'N3WT0K3N'
        ]);
    }
}