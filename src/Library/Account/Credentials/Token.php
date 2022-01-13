<?php

namespace ProwectCMS\Core\Library\Account\Credentials;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use ProwectCMS\Core\Aggregates\Account\AccountCredentialAggregate;
use ProwectCMS\Core\Library\Account\Managers\IManager;
use ProwectCMS\Core\Library\Account\Managers\TokenManager;
use ProwectCMS\Core\Models\Account;
use ProwectCMS\Core\Models\AccountCredential;

class Token implements ICredential
{
    use HasAccountCredential;

    const TOKEN_LENGTH = 6;

    public static function getTypeName() : string
    {
        return AccountCredential::TYPE_TOKEN;
    }

    public function getManager() : IManager
    {
        return new TokenManager($this);
    }

    public static function generateToken($length = self::TOKEN_LENGTH)
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

    public function check(array $attributes) : bool
    {
        return true;
    }
}