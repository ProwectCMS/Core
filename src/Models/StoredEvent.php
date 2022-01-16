<?php

namespace ProwectCMS\Core\Models;

use Kra8\Snowflake\HasSnowflakePrimary;
use Spatie\EventSourcing\StoredEvents\Models\EloquentStoredEvent;

class StoredEvent extends EloquentStoredEvent
{
    use HasSnowflakePrimary;
}