<?php

namespace ProwectCMS\Core\Library\Sanctum\Models;

use Laravel\Sanctum\PersonalAccessToken as BasePersonalAccessToken;
use Ramsey\Uuid\Uuid;

class PersonalAccessToken extends BasePersonalAccessToken
{
    // disable auto incrementing -> because we are using UUIDs
    public $incrementing = false;
    protected $keyType = 'string';

    public static function boot()
    {
        parent::boot();

        static::creating(function($model) {
            if (empty($model->id)) {
                $model->id = (string)Uuid::uuid4();
            }
        });
    }
}