<?php

namespace ProwectCMS\Core\Commands\Account;

use ProwectCMS\Core\Aggregates\Account\AccountAggregate;
use Spatie\EventSourcing\Commands\AggregateUuid;
use Spatie\EventSourcing\Commands\HandledBy;

#[HandledBy(AccountAggregate::class)]
class UpdateAccount
{
    public function __construct(#[AggregateUuid] public string $id, public array $attributes)
    {

    }
}