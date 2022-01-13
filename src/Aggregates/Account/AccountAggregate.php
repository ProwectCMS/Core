<?php

namespace ProwectCMS\Core\Aggregates\Account;

use ProwectCMS\Core\Commands\Account\CreateAccount;
use ProwectCMS\Core\Events\Account\AccountCreated;
use Spatie\EventSourcing\AggregateRoots\AggregateRoot;

class AccountAggregate extends AggregateRoot
{
    public function create(array $attributes, array $credentials = []) : self
    {
        $this->recordThat(new AccountCreated($attributes, $credentials));

        return $this;
    }

    public function createCommand(CreateAccount $createAccount) : self
    {
        return $this->create($createAccount->attributes, $createAccount->credentials);
    }
}