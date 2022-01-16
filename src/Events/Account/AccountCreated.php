<?php

namespace ProwectCMS\Core\Events\Account;

use ProwectCMS\Core\Facades\Snowflake;

class AccountCreated extends Event
{
    public function __construct(public array $attributes = [], public array $credentials = [])
    {
        for ($i = 0; $i < count($this->credentials); $i++) {
            if (empty($this->credentials[$i]['id'])) {
                $this->credentials[$i]['id'] = Snowflake::next();
            }
        }
    }
}