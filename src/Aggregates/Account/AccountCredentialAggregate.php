<?php

namespace ProwectCMS\Core\Aggregates\Account;

use ProwectCMS\Core\Events\Account\AccountCredentialCreated;
use ProwectCMS\Core\Events\Account\AccountCredentialDeleted;
use ProwectCMS\Core\Events\Account\AccountCredentialUpdated;
use Spatie\EventSourcing\AggregateRoots\AggregateRoot;

class AccountCredentialAggregate extends AggregateRoot
{
    public function create(string $accountId, array $attributes)
    {
        $this->recordThat(new AccountCredentialCreated($accountId, $attributes));

        return $this;
    }

    public function update(array $attributes)
    {
        $this->recordThat(new AccountCredentialUpdated($attributes));

        return $this;
    }

    public function delete()
    {
        $this->recordThat(new AccountCredentialDeleted());

        return $this;
    }
}