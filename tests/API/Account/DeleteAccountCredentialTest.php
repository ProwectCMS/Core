<?php

namespace ProwectCMS\Core\Tests\API\Account;

use Laravel\Sanctum\Sanctum;
use ProwectCMS\Core\Models\Account;
use ProwectCMS\Core\Models\AccountCredential;
use ProwectCMS\Core\Tests\TestCaseWithDatabase;
use Ramsey\Uuid\Uuid;

class DeleteAccountCredentialTest extends TestCaseWithDatabase
{
    public function testDeleteAccountCredentialUnauthenticated()
    {
        $account = Account::findOrFail(10000);
        $accountCredential = $account->credentials()->where('type', AccountCredential::TYPE_TOKEN)->first();

        $response = $this->json('DELETE', "api/accounts/$account->id/credentials/token/$accountCredential->id");
        $response->assertStatus(401);
    }

    public function testDeleteAccountCredentialUnauthorized()
    {
        $account = Account::findOrFail(20000);

        Sanctum::actingAs($account, ['*'], 'prowectcms_api');

        $account = Account::findOrFail(10000);
        $accountCredential = $account->credentials()->where('type', AccountCredential::TYPE_TOKEN)->first();

        $response = $this->json('DELETE', "api/accounts/$account->id/credentials/token/$accountCredential->id");
        $response->assertStatus(403);
    }

    public function testDeleteAccountCredentialTokenSuccess()
    {
        $account = Account::findOrFail(10000);
        $accountCredential = $account->credentials()->where('type', AccountCredential::TYPE_TOKEN)->first();

        Sanctum::actingAs($account, ['*'], 'prowectcms_api');

        $response = $this->json('DELETE', "api/accounts/$account->id/credentials/token/$accountCredential->id");
        $response->assertOk();
        $response->assertJson([
            'status' => 'ok',
            'key' => 'account.credential.delete.success',
        ]);

        $this->assertDatabaseMissing('account_credentials', [
            'id' => $accountCredential->id,
            'deleted_at' => null
        ]);
    }
}