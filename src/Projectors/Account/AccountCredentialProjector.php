<?php

namespace ProwectCMS\Core\Projectors\Account;

use ProwectCMS\Core\Aggregates\Account\AccountCredentialAggregate;
use ProwectCMS\Core\Events\Account\AccountCreated;
use ProwectCMS\Core\Events\Account\AccountCredentialCreated;
use ProwectCMS\Core\Events\Account\AccountCredentialDeleted;
use ProwectCMS\Core\Events\Account\AccountCredentialUpdated;
use ProwectCMS\Core\Models\AccountCredential;
use Ramsey\Uuid\Uuid;
use Spatie\EventSourcing\EventHandlers\Projectors\Projector;

class AccountCredentialProjector extends Projector
{
    public function onAccountCreated(AccountCreated $event)
    {
        foreach ($event->credentials as $credential) {
            $uuid = Uuid::uuid4();
            AccountCredentialAggregate::retrieve($uuid)->create($event->aggregateRootUuid(), $credential)->persist();
        }
    }

    public function onAccountCredentialCreated(AccountCredentialCreated $event)
    {
        $attributes = $event->attributes;
        $attributes['id'] = $event->aggregateRootUuid();
        $attributes['account_id'] = $event->accountId;

        AccountCredential::create($attributes);
    }

    public function onAccountCredentialUpdated(AccountCredentialUpdated $event)
    {
        AccountCredential::query()->where('id', $event->aggregateRootUuid())->update($event->attributes);
    }

    public function onAccountCredentialDeleted(AccountCredentialDeleted $event)
    {
        AccountCredential::query()->where('id', $event->aggregateRootUuid())->delete();
    }
}