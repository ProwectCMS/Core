<?php

namespace ProwectCMS\Core\Models;

use Illuminate\Auth\Authenticatable as Auth;
use Illuminate\Contracts\Auth\Authenticatable;
use ProwectCMS\Core\Aggregates\Account\AccountAggregate;
use ProwectCMS\Core\Models\AccountCredential;

class Account extends Model implements Authenticatable
{
    use Auth;

    const TYPE_GUEST = 'GUEST';
    const TYPE_USER = 'USER';
    const TYPE_API = 'API';

    protected $table = 'accounts';

    protected static $aggregate = AccountAggregate::class;

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

    public function credentials()
    {
        return $this->hasMany(AccountCredential::class);
    }

    public function getAuthPasswordForType($type)
    {
        $accountCredential = $this->credentials()
            ->where('type', $type)
            ->latest()
            ->first();

        if ($accountCredential) {
            return $accountCredential->password;
        }

        return null;
    }

    public function setRememberToken($value)
    {
        if (!empty($this->getRememberTokenName())) {
            $this->credentials()->update([
                $this->getRememberTokenName() => $value
            ]);
        }
    }
}