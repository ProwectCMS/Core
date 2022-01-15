<?php

namespace ProwectCMS\Core\Tests\API\Account;

use Laravel\Sanctum\Sanctum;
use ProwectCMS\Core\Models\Account;
use ProwectCMS\Core\Models\AccountCredential;
use ProwectCMS\Core\Tests\TestCaseWithDatabase;

class CreateAccountCredentialTest extends TestCaseWithDatabase
{
    public function testCreateAccountCredentialTokenUnauthenticated()
    {
        $account = Account::findOrFail('prowectcms-admin-user');

        $response = $this->json('POST', "api/accounts/$account->id/credentials/token" , [
            'token' => 'T3ST'
        ]);
        $response->assertStatus(401);
    }

    public function testCreateAccountCredentialTokenUnauthorized()
    {
        $account = Account::findOrFail('frontend-user');

        Sanctum::actingAs($account, ['*'], 'prowectcms_api');

        $account = Account::findOrFail('prowectcms-admin-user');

        $response = $this->json('POST', "api/accounts/$account->id/credentials/token" , [
            'token' => 'T3ST'
        ]);
        $response->assertStatus(403);
    }

    public function testCreateAccountCredentialTokenSuccess()
    {
        $account = Account::findOrFail('prowectcms-admin-user');

        Sanctum::actingAs($account, ['*'], 'prowectcms_api');

        $response = $this->json('POST', "api/accounts/$account->id/credentials/token" , [
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
        $account = Account::findOrFail('prowectcms-admin-user');

        Sanctum::actingAs($account, ['*'], 'prowectcms_api');

        $response = $this->json('POST', "api/accounts/$account->id/credentials/username" , [
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
        $account = Account::findOrFail('prowectcms-admin-user');

        Sanctum::actingAs($account, ['*'], 'prowectcms_api');

        $response = $this->json('POST', "api/accounts/$account->id/credentials/email" , [
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