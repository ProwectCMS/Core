<?php

namespace ProwectCMS\Core\Tests\API\Account;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use ProwectCMS\Core\Models\Account;
use ProwectCMS\Core\Models\AccountCredential;
use ProwectCMS\Core\Tests\TestCase;
use Ramsey\Uuid\Uuid;

class CreateAccountCredentialTest extends TestCase
{
    use DatabaseMigrations;

    public function testCreateAccountCredentialTokenSuccess()
    {
        $account = Account::createWithAttributes([
            'type' => Account::TYPE_USER
        ]);

        $response = $this->postJson("api/accounts/$account->id/credentials/token" , [
            'token' => 'T3ST'
        ]);
        $response->assertOk();
        $response->assertJson([
            'status' => 'ok',
            'key' => 'account.credential.create.success',
            'account_credentials' => [
                'account_id' => $account->id,
                'type' => AccountCredential::TYPE_TOKEN,
                'username' => 'T3ST'
            ]
        ]);
    }

    public function testCreateAccountCredentialUsernameSuccess()
    {
        $account = Account::createWithAttributes([
            'type' => Account::TYPE_USER
        ]);

        $response = $this->postJson("api/accounts/$account->id/credentials/username" , [
            'username' => 'test',
            'password' => 'test123'
        ]);
        $response->assertOk();
        $response->assertJson([
            'status' => 'ok',
            'key' => 'account.credential.create.success',
            'account_credentials' => [
                'account_id' => $account->id,
                'type' => AccountCredential::TYPE_USERNAME,
                'username' => 'test'
            ]
        ]);
    }

    public function testCreateAccountCredentialEmailSuccess()
    {
        $account = Account::createWithAttributes([
            'type' => Account::TYPE_USER
        ]);

        $response = $this->postJson("api/accounts/$account->id/credentials/email" , [
            'username' => 'test@prowect.com',
            'password' => 'test123'
        ]);
        $response->assertOk();
        $response->assertJson([
            'status' => 'ok',
            'key' => 'account.credential.create.success',
            'account_credentials' => [
                'account_id' => $account->id,
                'type' => AccountCredential::TYPE_EMAIL,
                'username' => 'test@prowect.com'
            ]
        ]);
    }
}