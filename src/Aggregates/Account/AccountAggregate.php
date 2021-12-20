<?php

namespace ProwectCMS\Core\Aggregates\Account;

use ProwectCMS\Core\Events\Account\AccountCreated;
use Spatie\EventSourcing\AggregateRoots\AggregateRoot;

class AccountAggregate extends AggregateRoot
{
    public function create(array $attributes)
    {
        $this->recordThat(new AccountCreated($attributes));

        return $this;
    }
}