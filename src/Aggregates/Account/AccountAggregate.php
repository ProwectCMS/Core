<?php

namespace ProwectCMS\Core\Aggregates\Account;

use ProwectCMS\Core\Commands\Account\CreateAccount;
use ProwectCMS\Core\Commands\Account\UpdateAccount;
use ProwectCMS\Core\Events\Account\AccountCreated;
use ProwectCMS\Core\Events\Account\AccountDeleted;
use ProwectCMS\Core\Events\Account\AccountUpdated;
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

    public function update(array $attributes) : self
    {
        return $this->recordThat(new AccountUpdated($attributes));
    }

    public function updateCommand(UpdateAccount $updateAccount) : self
    {
        return $this->update($updateAccount->attributes);
    }

    public function delete()
    {
        $this->recordThat(new AccountDeleted());

        return $this;
    }
}