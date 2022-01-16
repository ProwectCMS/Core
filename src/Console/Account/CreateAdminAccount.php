<?php

namespace ProwectCMS\Core\Console\Account;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;
use Kra8\Snowflake\Snowflake;
use ProwectCMS\Core\Commands\Account\CreateAccount;
use ProwectCMS\Core\Commands\User\CreateUser;
use ProwectCMS\Core\Models\Account;
use ProwectCMS\Core\Models\AccountCredential;
use Ramsey\Uuid\Uuid;
use Spatie\EventSourcing\Commands\CommandBus;

class CreateAdminAccount extends Command
{
    protected $signature = 'admin:create';

    protected $description = 'Creates a new admin user - to be able to login to ProwectCMS Admin';


    public function handle(CommandBus $commandBus, Snowflake $snowflake)
    {
        $name = $this->ask('Name');
        $email = $this->ask('Email');
        $password = $this->secret('Password');

        $validator = Validator::make([
            'name' => $name,
            'email' => $email,
            'password' => $password
        ], [
            'name' => 'required|filled',
            'email' => 'required|filled|email|unique:account_credentials,username',
            'password' => 'required|filled'
        ]);

        if ($validator->fails()) {
            $this->error('Invalid data: ' . print_r($validator->errors()->first(), true));

            return 422;
        }

        $userId = $snowflake->next();
        $userAttributes = [
            'name' => $name,
            'email' => $email
        ];
        $accountUuid = Uuid::uuid4();
        $attributes = [
            'type' => Account::TYPE_USER,
            'user_id' => $userId
        ];
        $credentials = [
            [
                'type' => AccountCredential::TYPE_EMAIL,
                'username' => $email,
                'password' => bcrypt($password)
            ]
        ];

        $commandBus->dispatch(new CreateUser($userId, $userAttributes));
        $commandBus->dispatch(new CreateAccount($accountUuid, $attributes, $credentials));

        $this->info('Admin user: ' . $name . ' (' . $email . ') has successfully been created.');
    }
}