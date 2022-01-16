<?php

namespace ProwectCMS\Core\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Kra8\Snowflake\HasSnowflakePrimary;

class User extends Model
{
    use HasSnowflakePrimary, SoftDeletes;

    protected $table = 'users';

    protected $fillable = [
        'id', 'name', 'email'
    ];
}