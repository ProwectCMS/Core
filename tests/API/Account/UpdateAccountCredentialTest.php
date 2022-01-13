<?php

namespace ProwectCMS\Core\Tests\API\Account;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use ProwectCMS\Core\Models\Account;
use ProwectCMS\Core\Models\AccountCredential;
use ProwectCMS\Core\Tests\TestCase;
use Ramsey\Uuid\Uuid;

class UpdateAccountCredentialTest extends TestCase
{
    use DatabaseMigrations;

    public function testUpdateAccountCredentialTokenSuccess()
    {
        $account = Account::createWithAttributes([
            'type' => Account::TYPE_USER
        ]);

        $accountCredential = AccountCredential::createWithAttributes($account->id, [
            'type' => AccountCredential::TYPE_TOKEN,
            'username' => 'T3ST'
        ]);

        $this->assertDatabaseHas('account_credentials', [
            'id' => $accountCredential->id,
            'type' => accountCredential::TYPE_TOKEN,
            'username' => 'T3ST'
        ]);
        $this->assertDatabaseMissing('account_credentials', [
            'id' => $accountCredential->id,
            'type' => accountCredential::TYPE_TOKEN,
            'username' => 'N3WT0K3N'
        ]);

        $payload = [
            'token' => 'N3WT0K3N'
        ];

        $response = $this->patch("api/accounts/$account->id/credentials/token/$accountCredential->id", $payload);
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