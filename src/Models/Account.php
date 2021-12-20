<?php

namespace ProwectCMS\Core\Models;

use ProwectCMS\Core\Events\Account\AccountCreated;

class Account extends Model
{
    const TYPE_GUEST = 'GUEST';
    const TYPE_USER = 'USER';
    const TYPE_API = 'API';

    protected $table = 'accounts';

    protected static $createdEvent = AccountCreated::class;

    protected $fillable = [
        'id', 'type', 'meta'
    ];

    protected $casts = [
        'meta' => 'array'
    ];

    public static function getAvailableTypes()
    {
        return [
            static::TYPE_GUEST,
            static::TYPE_USER,
            static::TYPE_API
        ];
    }
}