<?php

namespace ProwectCMS\Core\Library\Account\Credentials;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use ProwectCMS\Core\Models\Account;
use ProwectCMS\Core\Models\AccountCredential;

class Token extends Credential
{
    public static function getTypeName() : string
    {
        return AccountCredential::TYPE_TOKEN;
    }

    public static function create(Account $account, string $token = null, array $meta = []) : Token
    {
        if (is_null($token)) {
            $token = static::generateToken();
        }

        return static::createAccountCredential($account, $token, null, $meta);
    }

    public static function generateToken($length = 6)
    {
        return strtoupper(Str::random($length));
    }

    public function getToken()
    {
        return $this->accountCredential->username;
    }

    public function setToken(string $token = null)
    {
        if (is_null($token)) {
            $token = static::generateToken();
        }

        $this->accountCredential->username = $token;
    }

    public static function getCreateValidationRules()
    {
        return [
            'username' => 'required_without:token|min:4|max:255|unique:account_credentials,username',
            'token' => 'required_without:username|min:4|max:255|unique:account_credentials,username',
            'meta' => 'array'
        ];
    }

    public function getUpdateValidationRules()
    {
        return [
            'username' => 'min:4|max:255|unique:account_credentials,username,' . $this->accountCredential->id,
            'token' => 'min:4|max:255|unique:account_credentials,username,' . $this->accountCredential->id,
            'meta' => 'array'
        ];
    }

    public static function handleCreateRequest(Account $account, Request $request)
    {
        $token = $request->input('token');
        if (!$token) {
            $token = $request->input('username');
        }

        $meta = $request->input('meta', []);

        return static::create($account, $token, $meta);
    }

    public function handleUpdateRequest(Request $request)
    {
        $token = $request->input('token');
        if (!$token) {
            $token = $request->input('username');
        }
        $meta = $request->input('meta');

        $this->update($token, null, $meta);
    }
}