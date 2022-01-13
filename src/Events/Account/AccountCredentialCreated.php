<?php

namespace ProwectCMS\Core\Events\Account;

class AccountCredentialCreated extends Event
{
    public function __construct(public string $accountId, public array $attributes = [])
    {
    }
}