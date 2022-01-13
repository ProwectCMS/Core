<?php

namespace ProwectCMS\Core\Tests\Unit\Account;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use ProwectCMS\Core\Models\Account;
use ProwectCMS\Core\Models\AccountCredential;
use ProwectCMS\Core\Tests\TestCaseWithDatabase;

class AccountProviderTest extends TestCaseWithDatabase
{
    public function testLoginViaEmailSuccess()
    {
        $auth = Auth::guard('prowectcms');

        $credentials = [
            'type' => AccountCredential::TYPE_EMAIL,
            'username' => 'admin@prowect.com',
            'password' => 'admin'
        ];

        $result = $auth->attempt($credentials);
        $this->assertTrue($result, 'Login failed');

        $user = $auth->user();

        $this->assertInstanceOf(Account::class, $user);
        $this->assertEquals('prowectcms-admin-user', $user->id);
    }

    public function testLoginViaEmailWithWrongEmail()
    {
        $auth = Auth::guard('prowectcms');

        $credentials = [
            'type' => AccountCredential::TYPE_EMAIL,
            'username' => 'wrong-email@prowect.com',
            'password' => 'admin'
        ];

        $result = $auth->attempt($credentials);
        $this->assertFalse($result, 'Login was successful but should fail');

        $user = $auth->user();

        $this->assertNull($user);
    }

    public function testLoginViaEmailWithWrongPassword()
    {
        $auth = Auth::guard('prowectcms');

        $credentials = [
            'type' => AccountCredential::TYPE_EMAIL,
            'username' => 'admin@prowect.com',
            'password' => 'wrong-password'
        ];

        $result = $auth->attempt($credentials);
        $this->assertFalse($result, 'Login was successful but should fail');

        $user = $auth->user();

        $this->assertNull($user);
    }

    public function testLoginViaUsernameSuccess()
    {
        $auth = Auth::guard('prowectcms');

        $credentials = [
            'type' => AccountCredential::TYPE_USERNAME,
            'username' => 'admin',
            'password' => 'admin'
        ];

        $result = $auth->attempt($credentials);
        $this->assertTrue($result, 'Login failed');

        $user = $auth->user();

        $this->assertInstanceOf(Account::class, $user);
        $this->assertEquals('prowectcms-admin-user', $user->id);
    }

    public function testLoginViaUsernameWithWrongUsername()
    {
        $auth = Auth::guard('prowectcms');

        $credentials = [
            'type' => AccountCredential::TYPE_USERNAME,
            'username' => 'wrong-username',
            'password' => 'admin'
        ];

        $result = $auth->attempt($credentials);
        $this->assertFalse($result, 'Login was successful but should fail');

        $user = $auth->user();

        $this->assertNull($user);
    }

    public function testLoginViaUsernameWithWrongPassword()
    {
        $auth = Auth::guard('prowectcms');

        $credentials = [
            'type' => AccountCredential::TYPE_USERNAME,
            'username' => 'admin',
            'password' => 'wrong-password'
        ];

        $result = $auth->attempt($credentials);
        $this->assertFalse($result, 'Login was successful but should fail');

        $user = $auth->user();

        $this->assertNull($user);
    }

    public function testLoginViaTokenSuccess()
    {
        $auth = Auth::guard('prowectcms');

        $credentials = [
            'type' => AccountCredential::TYPE_TOKEN,
            'username' => '4DM1N',
        ];

        $result = $auth->attempt($credentials);
        $this->assertTrue($result, 'Login failed');

        $user = $auth->user();

        $this->assertInstanceOf(Account::class, $user);
        $this->assertEquals('prowectcms-admin-user', $user->id);
    }

    public function testLoginViaTokenWithWrongToken()
    {
        $auth = Auth::guard('prowectcms');

        $credentials = [
            'type' => AccountCredential::TYPE_TOKEN,
            'username' => 'WR0N6',
        ];

        $result = $auth->attempt($credentials);
        $this->assertFalse($result, 'Login was successful but should fail');

        $user = $auth->user();

        $this->assertNull($user);
    }

    public function testLoginViaRememberTokenSuccess()
    {
        $auth = Auth::guard('prowectcms');

        $credentials = [
            'type' => AccountCredential::TYPE_EMAIL,
            'username' => 'admin@prowect.com',
            'password' => 'admin'
        ];

        $result = $auth->attempt($credentials, true);
        $this->assertTrue($result, 'Login failed');
    }
}