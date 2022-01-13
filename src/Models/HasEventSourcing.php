<?php

namespace ProwectCMS\Core\Models;

use Ramsey\Uuid\Uuid;

trait HasEventSourcing
{    
    public static function createWithAttributes(...$params)
    {
        $id = (string) Uuid::uuid4();

        $aggregate = static::$aggregate::retrieve($id);
        call_user_func_array([$aggregate, 'create'], $params);
        $aggregate->persist();

        return static::find($id);
    }
}