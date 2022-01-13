<?php

namespace ProwectCMS\Core\Events\Account;

class AccountCreated extends Event
{
    public function __construct(public array $attributes = [], public array $credentials = [])
    {
    }
}