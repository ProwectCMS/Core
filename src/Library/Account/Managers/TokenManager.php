<?php

namespace ProwectCMS\Core\Library\Account\Managers;

use Illuminate\Http\Request;
use ProwectCMS\Core\Library\Account\Credentials\ICredential;
use ProwectCMS\Core\Library\Account\Credentials\Token;
use ProwectCMS\Core\Models\Account;

class TokenManager extends CredentialManager
{
    const VALIDATION_USERNAME_MIN = 4;

    public function __construct(Token $accountCredential)
    {
        parent::__construct($accountCredential);
    }

    public function getCreateValidationRules() : array
    {
        $rules = [
            'username' => 'required_without:token|min:' . static::VALIDATION_USERNAME_MIN . '|max:' . static::VALIDATION_USERNAME_MAX . '|unique:account_credentials,username',
            'token' => 'required_without:username|min:' . static::VALIDATION_USERNAME_MIN . '|max:' . static::VALIDATION_USERNAME_MAX . '||unique:account_credentials,username',
        ];

        return array_merge($rules, $this->getAdditionalCreateValidationRules());
    }

    public function getUpdateValidationRules() : array
    {
        $rules = [
            'username' => 'min:' . static::VALIDATION_USERNAME_MIN . '|max:' . static::VALIDATION_USERNAME_MAX . '||unique:account_credentials,username,' . $this->accountCredential->id,
            'token' => 'min:' . static::VALIDATION_USERNAME_MIN . '|max:' . static::VALIDATION_USERNAME_MAX . '||unique:account_credentials,username,' . $this->accountCredential->id,
        ];

        return array_merge($rules, $this->getAdditionalUpdateValidationRules());
    }

    public function handleCreateRequest(Account $account, Request $request) : ICredential
    {
        $token = $request->input('token');
        if (!$token) {
            $token = $request->input('username');
        }

        $attributes = [
            'username' => $token
        ];

        $this->createAccountCredential($account, $attributes, $request);

        return $this->accountCredential;
    }

    public function handleUpdateRequest(Request $request)
    {
        $token = $request->input('token');
        if (!$token) {
            $token = $request->input('username');
        }

        $this->updateAccountCredential(['username' => $token], $request);
    }

    public static function create(Account $account, ?string $token = null)
    {
        $manager = new static(new Token);

        if (empty($token)) {
            $token = Token::generateToken();
        }

        $manager->createAccountCredential($account, [
            'username' => $token
        ]);

        return $manager->getAccountCredential();
    }
}