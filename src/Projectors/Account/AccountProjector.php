<?php

namespace ProwectCMS\Core\Projectors\Account;

use ProwectCMS\Core\Events\Account\AccountCreated;
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

    // TODO: onAccountUpdated
    // TODO: onAccountDeleted
}