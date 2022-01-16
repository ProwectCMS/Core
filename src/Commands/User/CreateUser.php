<?php

namespace ProwectCMS\Core\Commands\User;

use ProwectCMS\Core\Aggregates\User\UserAggregate;
use Spatie\EventSourcing\Commands\AggregateUuid;
use Spatie\EventSourcing\Commands\HandledBy;

#[HandledBy(UserAggregate::class)]
class CreateUser
{
    public function __construct(#[AggregateUuid] public int $id, public array $attributes)
    {

    }
}