<?php

namespace ProwectCMS\Core\Projectors\Account;

use ProwectCMS\Core\Aggregates\Account\AccountCredentialAggregate;
use ProwectCMS\Core\Events\Account\AccountCreated;
use ProwectCMS\Core\Events\Account\AccountCredentialCreated;
use ProwectCMS\Core\Events\Account\AccountCredentialDeleted;
use ProwectCMS\Core\Events\Account\AccountCredentialUpdated;
use ProwectCMS\Core\Models\AccountCredential;
use ProwectCMS\Core\Projectors\EloquentProjector;
use Ramsey\Uuid\Uuid;

class AccountCredentialProjector extends EloquentProjector
{
    protected function getModelClass()
    {
        return AccountCredential::class;
    }

    public function onAccountCreated(AccountCreated $event)
    {
        foreach ($event->credentials as $credential) {
            AccountCredentialAggregate::retrieve($credential['id'])->create($event->aggregateRootUuid(), $credential)->persist();
        }
    }

    public function onAccountCredentialCreated(AccountCredentialCreated $event)
    {
        $this->onCreated($event, function($model, $event) {
           $model->account_id = $event->accountId;
        });
    }

    public function onAccountCredentialUpdated(AccountCredentialUpdated $event)
    {
        $this->onUpdated($event);
    }

    public function onAccountCredentialDeleted(AccountCredentialDeleted $event)
    {
        $this->onDeleted($event);
    }
}