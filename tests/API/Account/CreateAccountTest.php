<?php

namespace ProwectCMS\Core\Tests\API\Account;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use ProwectCMS\Core\Events\Account\AccountCreated;
use ProwectCMS\Core\Models\Account;
use ProwectCMS\Core\Tests\TestCase;
use Ramsey\Uuid\Uuid;

class CreateAccountTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @dataProvider accountSuccessDataProvider  
     */
    public function testCreateAccountSuccess(array $attributes, array $expectedResult)
    {
        $payload = $attributes;

        $response = $this->postJson('api/accounts', $payload);
        $response->assertOk();
        $response->assertJson([
            'status' => 'ok',
            'key' => 'account.create.success',
            'account' => $expectedResult
        ]);

        $this->assertDatabaseHas('stored_events', [
            'event_class' => AccountCreated::class
        ]);

        $responseData = $response->getData();
        $account = $responseData->account;

        $this->assertTrue(Uuid::isValid($account->id), "Account-ID: $account->id is not a valid UUID");
    }

    public function accountSuccessDataProvider()
    {
        return [
            [
                [
                    'type' => 'GUEST'
                ],
                [
                    'type' => Account::TYPE_GUEST,
                    'meta' => []
                ]
            ],

            [
                [
                    'type' => 'USER'
                ],
                [
                    'type' => Account::TYPE_USER,
                    'meta' => []
                ]
            ],

            [
                [
                    'type' => 'GUEST',
                    'meta' => [
                        'test' => 123
                    ]
                ],
                [
                    'type' => Account::TYPE_GUEST,
                    'meta' => [
                        'test' => 123
                    ]
                ]
            ]
        ];
    }
}