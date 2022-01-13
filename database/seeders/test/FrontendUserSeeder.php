<?php

namespace ProwectCMS\Core\Database\Seeders\Test;

use Illuminate\Database\Seeder;
use ProwectCMS\Core\Commands\Account\CreateAccount;
use ProwectCMS\Core\Models\Account;
use ProwectCMS\Core\Models\AccountCredential;
use Spatie\EventSourcing\Commands\CommandBus;

class FrontendUserSeeder extends AdminUserSeeder
{
    protected function getData()
    {
        $data = [];

        $data[] = [
            'id' => 'frontend-user',

            'attributes' => [
                'type' => Account::TYPE_USER,
            ],

            'credentials' => [
                [
                    'type' => AccountCredential::TYPE_EMAIL,
                    'username' => 'frontend@prowect.com',
                    'password' => bcrypt('frontend')
                ]
            ],
        ];

        $data[] = [
            'id' => 'token-user',

            'attributes' => [
                'type' => Account::TYPE_USER,
            ],

            'credentials' => [
                [
                    'type' => AccountCredential::TYPE_TOKEN,
                    'username' => 'T0K3NU53R',
                ]
            ],
        ];

        return $data;
    }
}