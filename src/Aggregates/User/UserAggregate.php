<?php

namespace ProwectCMS\Core\Aggregates\User;

use ProwectCMS\Core\Commands\User\CreateUser;
use ProwectCMS\Core\Events\User\UserCreated;
use Spatie\EventSourcing\AggregateRoots\AggregateRoot;

class UserAggregate extends AggregateRoot
{
    public function create(array $attributes) : self
    {
        $this->recordThat(new UserCreated($attributes));

        return $this;
    }

    public function createCommand(CreateUser $createUser) : self
    {
        return $this->create($createUser->attributes);
    }
}