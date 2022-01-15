<?php

namespace ProwectCMS\Core\Projectors\Account;

use ProwectCMS\Core\Events\Account\AccountCreated;
use ProwectCMS\Core\Events\Account\AccountDeleted;
use ProwectCMS\Core\Events\Account\AccountUpdated;
use ProwectCMS\Core\Models\Account;
use Spatie\EventSourcing\EventHandlers\Projectors\Projector;

class AccountProjector extends Projector
{
    public function onAccountCreated(AccountCreated $event)
    {
        $attributes = $event->attributes;
        $attributes['id'] = $event->aggregateRootUuid();

        $account = Account::create($attributes);
    }

    public function onAccountUpdated(AccountUpdated $event)
    {
        Account::findOrFail($event->aggregateRootUuid())->update($event->attributes);
    }

    public function onAccountDeleted(AccountDeleted $event)
    {
        Account::findOrFail($event->aggregateRootUuid())->delete();
    }
}