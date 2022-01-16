<?php

namespace ProwectCMS\Core\Models;

use Kra8\Snowflake\HasSnowflakePrimary;
use Spatie\EventSourcing\Snapshots\EloquentSnapshot;

class Snapshot extends EloquentSnapshot
{
    use HasSnowflakePrimary;
}