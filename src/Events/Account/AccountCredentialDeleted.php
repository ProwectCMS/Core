<?php

namespace ProwectCMS\Core\Events\Account;

use ProwectCMS\Core\Models\AccountCredential;

class AccountCredentialDeleted extends Event
{
    protected AccountCredential $accountCredential;

    public function __construct(AccountCredential $accountCredential)
    {
        $this->accountCredential = $accountCredential;
    }

    public function getAccountCredential() : AccountCredential
    {
        return $this->accountCredential;
    }
}