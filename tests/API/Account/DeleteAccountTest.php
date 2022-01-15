<?php

namespace ProwectCMS\Core\Tests\API\Account;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Sanctum\Sanctum;
use ProwectCMS\Core\Events\Account\AccountCreated;
use ProwectCMS\Core\Models\Account;
use ProwectCMS\Core\Tests\TestCaseWithDatabase;
use Ramsey\Uuid\Uuid;

class DeleteAccountTest extends TestCaseWithDatabase
{
     public function testDeleteAccountUnauthenticated()
     {
         $response = $this->json('DELETE', 'api/accounts/prowectcms-admin-user');
         $response->assertStatus(401);
     }

     public function testDeleteAccountUnauthorized()
     {
         $account = Account::findOrFail('frontend-user');

         Sanctum::actingAs($account, ['*'], 'prowectcms_api');

         $response = $this->json('DELETE', 'api/accounts/prowectcms-admin-user');
         $response->assertStatus(403);
     }

     public function testDeleteAccountSuccess()
     {
         $account = Account::findOrFail('prowectcms-admin-user');

         Sanctum::actingAs($account, ['*'], 'prowectcms_api');

         $response = $this->json('DELETE', 'api/accounts/prowectcms-admin-user');
         $response->assertOk();
         $response->assertJson([
             'status' => 'ok',
             'key' => 'account.delete.success'
         ]);
     }
}