<?php

namespace ProwectCMS\Core\Library\Account;

use ProwectCMS\Core\Library\Account\Credentials\ICredential;

class AccountCredentialFactory
{
    protected $availableAccountCredentials = [];

    public function register($accountCredentialClass)
    {
        $this->availableAccountCredentials[$accountCredentialClass::getTypeName()] = $accountCredentialClass;
    }

    public function deregister($accountCredentialClass)
    {
        $typeName = $accountCredentialClass->getTypeName();

        unset($this->availableAccountCredentials[$typeName]);
    }

    public function getClassForType($type)
    {
        if (!isset($this->availableAccountCredentials[$type])) {
            throw new AccountCredentialNotFoundException("Account Credential Type: $type is not registered or was not found!");
        }

        return $this->availableAccountCredentials[$type];
    }

    public function getAvailableNames()
    {
        return array_keys($this->availableAccountCredentials);
    }
}