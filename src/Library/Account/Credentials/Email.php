<?php

namespace ProwectCMS\Core\Library\Account\Credentials;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use ProwectCMS\Core\Library\Account\Managers\EmailManager;
use ProwectCMS\Core\Library\Account\Managers\IManager;
use ProwectCMS\Core\Models\Account;
use ProwectCMS\Core\Models\AccountCredential;

class Email extends Credential
{
    public static function getTypeName() : string
    {
        return AccountCredential::TYPE_EMAIL;
    }

    public function getManager() : IManager
    {
        return new EmailManager($this);
    }
}