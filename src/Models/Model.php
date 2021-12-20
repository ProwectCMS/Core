<?php

namespace ProwectCMS\Core\Models;

use Illuminate\Database\Eloquent\Model as BaseModel;

abstract class Model extends BaseModel
{
    use HasEventSourcing;

    // disable auto incrementing -> because we are using UUIDs
    public $incrementing = false;
    protected $keyType = 'string';

}