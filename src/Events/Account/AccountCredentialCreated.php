<?php

namespace ProwectCMS\Core\Events\Account;

class AccountCredentialCreated extends Event
{
    public $attributes;

    public function __construct(array $attributes = [])
    {
        $this->attributes = $attributes;
    }
}