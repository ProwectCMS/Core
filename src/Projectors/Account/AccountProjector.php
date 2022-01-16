<?php

namespace ProwectCMS\Core\Projectors\Account;

use ProwectCMS\Core\Events\Account\AccountCreated;
use ProwectCMS\Core\Events\Account\AccountDeleted;
use ProwectCMS\Core\Events\Account\AccountUpdated;
use ProwectCMS\Core\Models\Account;
use ProwectCMS\Core\Projectors\EloquentProjector;

class AccountProjector extends EloquentProjector
{
    public function getModelClass()
    {
        return Account::class;
    }

    public function onAccountCreated(AccountCreated $event)
    {
        $this->onCreated($event);
    }

    public function onAccountUpdated(AccountUpdated $event)
    {
        $this->onUpdated($event);
    }

    public function onAccountDeleted(AccountDeleted $event)
    {
        $this->onDeleted($event);
    }
}