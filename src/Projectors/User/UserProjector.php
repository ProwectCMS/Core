<?php

namespace ProwectCMS\Core\Projectors\User;

use ProwectCMS\Core\Events\User\UserCreated;
use ProwectCMS\Core\Models\User;
use ProwectCMS\Core\Projectors\EloquentProjector;

class UserProjector extends EloquentProjector
{
    protected function getModelClass()
    {
        return User::class;
    }

    public function onUserCreated(UserCreated $event)
    {
        $this->onCreated($event);
    }
}