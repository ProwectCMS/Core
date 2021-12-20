<?php

namespace ProwectCMS\Core\Library\Account\Credentials;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use ProwectCMS\Core\Models\Account;
use ProwectCMS\Core\Models\AccountCredential;

class Username extends Credential
{
    public static function getTypeName() : string
    {
        return AccountCredential::TYPE_USERNAME;
    }
}