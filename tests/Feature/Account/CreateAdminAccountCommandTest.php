<?php

namespace ProwectCMS\Core\Tests\Feature\Account;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use ProwectCMS\Core\Models\Account;
use ProwectCMS\Core\Models\AccountCredential;
use ProwectCMS\Core\Models\User;
use ProwectCMS\Core\Tests\TestCase;

class CreateAdminAccountCommandTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @dataProvider adminAccountSuccessDataProvider
     */
    public function testCreateAdminAccountSuccess($name, $email, $password)
    {
        $command = $this->artisan('admin:create');

        $command->expectsQuestion('Name', $name);
        $command->expectsQuestion('Email', $email);
        $command->expectsQuestion('Password', $password);
        $command->expectsOutput('Admin user: ' . $name . ' (' . $email . ') has successfully been created.');
        $command->assertExitCode(0);
    }

    public function adminAccountSuccessDataProvider()
    {
        return [
            [
                'name' => 'Admin',
                'email' => 'admin@prowect.com',
                'password' => 'password'
            ]
        ];
    }

    /**
     * @dataProvider adminAccountFailedDataProvider
     */
    public function testCreateAdminAccountFailed($name, $email, $password)
    {
        $command = $this->artisan('admin:create');

        $command->expectsQuestion('Name', $name);
        $command->expectsQuestion('Email', $email);
        $command->expectsQuestion('Password', $password);
        $command->assertExitCode(422);
    }

    public function adminAccountFailedDataProvider()
    {
        return [
            [
                'name' => 'Invalid name',
                'email' => 'not-an-email',
                'password' => 'password'
            ],
            [
                'name' => null,
                'email' => null,
                'password' => null
            ]
        ];
    }
}