<?php

namespace ProwectCMS\Core\Events\Account;

use ProwectCMS\Core\Models\AccountCredential;

class AccountCredentialUpdated extends Event
{
    protected AccountCredential $accountCredential;
    protected array $updatedAttributes;

    public function __construct(AccountCredential $accountCredential, array $updatedAttributes)
    {
        $this->accountCredential = $accountCredential;
        $this->updatedAttributes = $updatedAttributes;
    }

    public function getAccountCredential() : AccountCredential
    {
        return $this->accountCredential;
    }

    public function getUpdatedAttributes() : array
    {
        return $this->updatedAttributes;
    }
}