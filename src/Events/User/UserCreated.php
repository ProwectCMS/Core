<?php

namespace ProwectCMS\Core\Events\User;

class UserCreated extends Event
{
    public function __construct(public array $attributes = [])
    {
    }
}