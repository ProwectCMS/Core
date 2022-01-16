<?php

namespace ProwectCMS\Core\Facades;

use Illuminate\Support\Facades\Facade;

class Snowflake extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Kra8\Snowflake\Snowflake::class;
    }
}