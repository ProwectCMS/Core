<?php

namespace ProwectCMS\Core\Tests\Feature\Account;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use ProwectCMS\Core\Library\Account\Credentials\Token;
use ProwectCMS\Core\Models\Account;
use ProwectCMS\Core\Models\AccountCredential;
use ProwectCMS\Core\Tests\TestCase;

class AccountCredentialsTokenTest extends TestCase
{
    use DatabaseMigrations;

    public function testCreateCredentialForAccountWithCustomToken()
    {
        $account = Account::createWithAttributes([
            'type' => Account::TYPE_USER
        ]);

        $token = 'T3ST';

        $accountCredential = Token::create($account, $token);

        $this->assertInstanceOf(Token::class, $accountCredential);
        $this->assertEquals('TOKEN', $accountCredential->type);
        $this->assertEquals($account->id, $accountCredential->account_id);
        $this->assertEquals($token, $accountCredential->username);
        $this->assertNull($accountCredential->password);
        $this->assertEmpty($accountCredential->meta);
    }

    public function testCreateCredentialForAccountWithGeneratedToken()
    {
        $account = Account::createWithAttributes([
            'type' => Account::TYPE_USER
        ]);

        $accountCredential = Token::create($account);

        $this->assertInstanceOf(Token::class, $accountCredential);
        $this->assertEquals('TOKEN', $accountCredential->type);
        $this->assertEquals($account->id, $accountCredential->account_id);
        $this->assertNotNull($accountCredential->username);
        $this->assertNull($accountCredential->password);
        $this->assertEmpty($accountCredential->meta);
    }

    public function testModifyCredentialForAccount()
    {
        $account = Account::createWithAttributes([
            'type' => Account::TYPE_USER
        ]);

        $accountCredential = AccountCredential::createWithAttributes([
            'account_id' => $account->id,
            'type' => AccountCredential::TYPE_TOKEN,
            'username' => 'T3ST'
        ]);

        $this->assertEquals('T3ST', $accountCredential->username);

        $token = new Token($accountCredential);
        $token->setToken('T0K3N');
        $token->save();

        $this->assertEquals('T0K3N', $accountCredential->username);

        $this->assertDatabaseHas('account_credentials', [
            'account_id' => $account->id,
            'type' => AccountCredential::TYPE_TOKEN,
            'username' => 'T0K3N',
        ]);

        return response()->json([
            'status' => 'ok',
            'key' => 'account.credential.create.success',
            'message' => 'Account credentials has successfully been created',

            'account_credentials' => $accountCredential
        ]);
    }
}