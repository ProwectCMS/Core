<?php

namespace ProwectCMS\Core\Events\Account;

class AccountUpdated extends Event
{
    public function __construct(public array $attributes = [])
    {

    }
}