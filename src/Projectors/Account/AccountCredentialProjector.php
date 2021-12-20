<?php

namespace ProwectCMS\Core\Projectors\Account;

use ProwectCMS\Core\Events\Account\AccountCredentialCreated;
use ProwectCMS\Core\Events\Account\AccountCredentialDeleted;
use ProwectCMS\Core\Events\Account\AccountCredentialUpdated;
use ProwectCMS\Core\Models\AccountCredential;
use Spatie\EventSourcing\EventHandlers\Projectors\Projector;

class AccountCredentialProjector extends Projector
{
    public function onAccountCredentialCreated(AccountCredentialCreated $event)
    {
        AccountCredential::create($event->attributes);
    }

    public function onAccountCredentialUpdated(AccountCredentialUpdated $event)
    {
        $event->getAccountCredential()->update($event->getUpdatedAttributes());
    }

    public function onAccountCredentialDeleted(AccountCredentialDeleted $event)
    {
        $event->getAccountCredential()->delete();
    }
}