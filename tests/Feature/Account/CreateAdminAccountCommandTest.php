<?php

namespace ProwectCMS\Core\Tests\Feature\Account;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use ProwectCMS\Core\Models\Account;
use ProwectCMS\Core\Models\AccountCredential;
use ProwectCMS\Core\Tests\TestCase;

class CreateAdminAccountCommandTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @dataProvider adminAccountSuccessDataProvider
     */
    public function testCreateAdminAccountSuccess($email, $password)
    {
        $command = $this->artisan('admin:create');

        $command->expectsQuestion('Email', $email);
        $command->expectsQuestion('Password', $password);
        $command->expectsOutput('Admin user: ' . $email . ' has successfully been created.');
        $command->assertExitCode(0);
    }

    public function adminAccountSuccessDataProvider()
    {
        return [
            [
                'email' => 'admin@prowect.com',
                'password' => 'password'
            ]
        ];
    }

    /**
     * @dataProvider adminAccountFailedDataProvider
     */
    public function testCreateAdminAccountFailed($email, $password)
    {
        $command = $this->artisan('admin:create');

        $command->expectsQuestion('Email', $email);
        $command->expectsQuestion('Password', $password);
        $command->assertExitCode(422);
    }

    public function adminAccountFailedDataProvider()
    {
        return [
            [
                'email' => 'not-an-email',
                'password' => 'password'
            ],
            [
                'email' => null,
                'password' => null
            ]
        ];
    }
}