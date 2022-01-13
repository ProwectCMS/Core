<?php

namespace ProwectCMS\Core\Events\Account;

use ProwectCMS\Core\Models\AccountCredential;

class AccountCredentialUpdated extends Event
{
    public function __construct(public array $attributes)
    {

    }
}