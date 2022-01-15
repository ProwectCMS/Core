<?php

namespace ProwectCMS\Core\Library\Account;

use ProwectCMS\Core\Library\Account\Credentials\ICredential;
use ProwectCMS\Core\Models\AccountCredential;

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
        $type = strtoupper($type);
        if (!isset($this->availableAccountCredentials[$type])) {
            throw new AccountCredentialNotFoundException("Account Credential Type: $type is not registered or was not found!");
        }

        return $this->availableAccountCredentials[$type];
    }

    public function getAvailableNames()
    {
        return array_keys($this->availableAccountCredentials);
    }

    public function create($type, ?AccountCredential $accountCredential = null)
    {
        $type = strtoupper($type);
        $class = $this->getClassForType($type);

        if (!is_null($accountCredential)) {
            return new $class($accountCredential);
        }

        return new $class;
    }
}