<?php

namespace ProwectCMS\Core\Aggregates\Account;

use ProwectCMS\Core\Events\Account\AccountCredentialCreated;
use ProwectCMS\Core\Events\Account\AccountCredentialDeleted;
use ProwectCMS\Core\Models\AccountCredential;
use Spatie\EventSourcing\AggregateRoots\AggregateRoot;

class AccountCredentialAggregate extends AggregateRoot
{
    public function create(array $attributes)
    {
        $this->recordThat(new AccountCredentialCreated($attributes));

        return $this;
    }

    public function update(AccountCredential $accountCredential, array $attributes)
    {
        $this->recordThat(new AccountCredentialUpdated($accountCredential, $attributes));

        return $this;
    }

    public function delete(AccountCredential $accountCredential)
    {
        $this->recordThat(new AccountCredentialDeleted($accountCredential));

        return $this;
    }
}