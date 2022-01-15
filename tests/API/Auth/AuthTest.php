<?php

namespace ProwectCMS\Core\Tests\API\Auth;

use Laravel\Sanctum\Sanctum;
use ProwectCMS\Core\Models\Account;
use ProwectCMS\Core\Tests\TestCaseWithDatabase;

class AuthTest extends TestCaseWithDatabase
{
    public function testLoginSuccess()
    {
        $payload = [
            'type' => 'email',

            'username' => 'admin@prowect.com',
            'password' => 'admin'
        ];

        $response = $this->json('POST', 'api/auth/login', $payload);
        $response->assertOk();
        $response->assertJsonStructure(['status', 'key', 'message', 'token']);
        $response->assertJson([
            'status' => 'ok',
            'key' => 'auth.login.success'
        ]);
    }

    public function testLoginFailed()
    {
        $payload = [
            'type' => 'email',

            'username' => 'admin@prowect.com',
            'password' => 'wrong-password'
        ];

        $response = $this->json('POST', 'api/auth/login', $payload);
        $response->assertStatus(400);
        $response->assertJson([
            'status' => 'error',
            'key' => 'auth.login.failed'
        ]);
    }

    public function testGetUserSuccess()
    {
        $account = Account::findOrFail('prowectcms-admin-user');

        Sanctum::actingAs($account, ['*'], 'prowectcms_api');

        $response = $this->json('GET', 'api/auth/user');
        $response->assertOk();
        $response->assertJson([
            'id' => $account->id
        ]);
        $response->assertJsonStructure(['id', 'type', 'meta', 'created_at', 'updated_at', 'deleted_at']);
    }

    public function testLogoutSuccess()
    {
        $account = Account::findOrFail('prowectcms-admin-user');

        Sanctum::actingAs($account, ['*'], 'prowectcms_api');

        $response = $this->json('POST', 'api/auth/logout');
        $response->assertOk();
    }
}