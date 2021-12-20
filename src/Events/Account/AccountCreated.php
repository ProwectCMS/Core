<?php

namespace ProwectCMS\Core\Events\Account;

use Ramsey\Uuid\Uuid;

class AccountCreated extends Event
{
    public $attributes;

    public function __construct(array $attributes = [])
    {
        $this->attributes = $attributes;
    }
}