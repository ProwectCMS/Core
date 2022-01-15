<?php

namespace ProwectCMS\Core\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use ProwectCMS\Core\Aggregates\Account\AccountCredentialAggregate;

class AccountCredential extends Model
{
    use SoftDeletes;

    const TYPE_TOKEN = 'TOKEN';
    const TYPE_EMAIL = 'EMAIL';
    const TYPE_USERNAME = 'USERNAME';

    // TODO: const TYPE_API = 'API';
    // TODO: const TYPE_OAUTH = 'OAUTH';
    // const TYPE_GOOGLE = 'GOOGLE';
    // const TYPE_TWITTER = 'TWITTER';
    // const TYPE_FACEBOOK = 'FACEBOOK';

    protected $table = 'account_credentials';

    protected static $aggregate = AccountCredentialAggregate::class;

    protected $fillable = [
        'id', 'type', 'account_id', 'username', 'password', 'meta'
    ];

    protected $casts = [
        'meta' => 'array'
    ];

    protected $hidden = [
        'password'
    ];

    public static function getAvailableTypes()
    {
        return [
            static::TYPE_TOKEN,
            static::TYPE_EMAIL,
            static::TYPE_USERNAME,
        ];
    }

    public function account()
    {
        return $this->belongsTo(Account::class);
    }
}