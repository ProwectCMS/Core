<?php

namespace ProwectCMS\Core\Tests\Feature\Admin\Auth;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use ProwectCMS\Core\Models\Account;
use ProwectCMS\Core\Models\AccountCredential;
use ProwectCMS\Core\Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function testViewLogin()
    {
        $this->get(route('prowectcms.admin.login'))
            ->assertOk()
            ->assertViewIs('prowectcms::admin.page.auth.login')
            ->assertSee('ProwectCMS');
    }

    /**
     * @dataProvider loginSuccessDataProvider
     */
    public function testLoginSuccess(array $credentials)
    {
        $account = Account::createWithAttributes([
            'type' => Account::TYPE_USER
        ]);

        $accountCredential = AccountCredential::createWithAttributes($account->id ,[
            'type' => AccountCredential::TYPE_EMAIL,
            'username' => 'admin@prowect.com',
            'password' => bcrypt('password')
        ]);

        $response = $this->post(route('prowectcms.admin.login.auth'), $credentials);
        $response->assertRedirect(route('prowectcms.admin.dashboard'));

        $this->assertAuthenticated('prowectcms');
        $this->assertAuthenticatedAs($account, 'prowectcms');
    }

    public function loginSuccessDataProvider()
    {
        return [
            [
                'credentials' => [
                    'username' => 'admin@prowect.com',
                    'password' => 'password'
                ]
            ]
        ];
    }

    /**
     * @dataProvider loginFailedDataProvider
     */
    public function testLoginFailed(array $credentials)
    {
        $account = Account::createWithAttributes([
            'type' => Account::TYPE_USER
        ]);

        $accountCredential = AccountCredential::createWithAttributes($account->id, [
            'type' => AccountCredential::TYPE_EMAIL,
            'username' => 'admin@prowect.com',
            'password' => bcrypt('password')
        ]);

        $response = $this->post(route('prowectcms.admin.login.auth'), $credentials);
        $response->assertRedirect(route('prowectcms.admin.login'));

        $this->assertGuest('prowectcms');
    }

    public function loginFailedDataProvider()
    {
        return [
            [
                'credentials' => [
                    'username' => 'wrong@email.com',
                    'password' => 'password'
                ]
            ],
            [
                'credentials' => [
                    'username' => 'admin@prowect.com',
                    'password' => 'wrong-password'
                ]
            ]
        ];
    }
}