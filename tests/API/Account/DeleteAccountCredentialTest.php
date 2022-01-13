<?php

namespace ProwectCMS\Core\Tests\API\Account;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use ProwectCMS\Core\Models\Account;
use ProwectCMS\Core\Models\AccountCredential;
use ProwectCMS\Core\Tests\TestCase;
use Ramsey\Uuid\Uuid;

class DeleteAccountCredentialTest extends TestCase
{
    use DatabaseMigrations;

    public function testDeleteAccountCredentialTokenSuccess()
    {
        $account = Account::createWithAttributes([
            'type' => Account::TYPE_USER
        ]);

        $accountCredential = AccountCredential::createWithAttributes($account->id, [
            'type' => AccountCredential::TYPE_TOKEN,
            'username' => 'T3ST'
        ]);

        $this->assertDatabaseHas('account_credentials', [
            'id' => $accountCredential->id
        ]);

        $response = $this->delete("api/accounts/$account->id/credentials/token/$accountCredential->id");
        $response->assertOk();
        $response->assertJson([
            'status' => 'ok',
            'key' => 'account.credential.delete.success',
        ]);

        $this->assertDatabaseMissing('account_credentials', [
            'id' => $accountCredential->id
        ]);
    }
}