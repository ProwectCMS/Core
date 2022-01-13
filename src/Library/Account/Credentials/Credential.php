<?php

namespace ProwectCMS\Core\Library\Account\Credentials;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use ProwectCMS\Core\Aggregates\Account\AccountCredentialAggregate;
use ProwectCMS\Core\Library\Account\Managers\CredentialManager;
use ProwectCMS\Core\Library\Account\Managers\IManager;
use ProwectCMS\Core\Models\Account;
use ProwectCMS\Core\Models\AccountCredential;

abstract class Credential implements ICredential
{
    use HasAccountCredential;

    public function getManager() : IManager
    {
        return new CredentialManager($this);
    }

    public function check(array $credentials) : bool
    {
        return Hash::check($credentials['password'], $this->password);
    }
}