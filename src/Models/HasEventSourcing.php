<?php

namespace ProwectCMS\Core\Models;

use Ramsey\Uuid\Uuid;

trait HasEventSourcing
{    
    protected static $idColumnName = 'id';

    public static function createWithAttributes(array $attributes)
    {
        $attributes[static::$idColumnName] = (string) Uuid::uuid4();

        event(new static::$createdEvent($attributes));

        return static::find($attributes[static::$idColumnName]);
    }
}