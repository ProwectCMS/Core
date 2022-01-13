<?php

namespace ProwectCMS\Core\Database\Seeders\Test;

use Illuminate\Database\Seeder;
use ProwectCMS\Core\Commands\Account\CreateAccount;
use ProwectCMS\Core\Models\Account;
use ProwectCMS\Core\Models\AccountCredential;
use Spatie\EventSourcing\Commands\CommandBus;

class AdminUserSeeder extends Seeder
{
    public function __construct(public CommandBus $commandBus)
    {
    }

    public function run()
    {
        foreach ($this->getData() as $data) {
            $this->seed($data);
        }
    }

    protected function getData()
    {
        $data = [];

        $data[] = [
            'id' => 'prowectcms-admin-user',

            'attributes' => [
                'type' => Account::TYPE_USER,
            ],

            'credentials' => [
                [
                    'type' => AccountCredential::TYPE_EMAIL,
                    'username' => 'admin@prowect.com',
                    'password' => bcrypt('admin')
                ],

                [
                    'type' => AccountCredential::TYPE_USERNAME,
                    'username' => 'admin',
                    'password' => bcrypt('admin')
                ],

                [
                    'type' => AccountCredential::TYPE_TOKEN,
                    'username' => '4DM1N',
                ],
            ]
        ];

        return $data;
    }

    protected function seed(array $data)
    {
        return $this->commandBus->dispatch(new CreateAccount($data['id'], $data['attributes'], $data['credentials']));
    }
}