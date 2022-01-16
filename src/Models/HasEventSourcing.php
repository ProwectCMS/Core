<?php

namespace ProwectCMS\Core\Models;

use ProwectCMS\Core\Facades\Snowflake;

trait HasEventSourcing
{    
    public static function createWithAttributes(...$params)
    {
        $id = Snowflake::next();

        $aggregate = static::$aggregate::retrieve($id);
        call_user_func_array([$aggregate, 'create'], $params);
        $aggregate->persist();

        return static::find($id);
    }
}