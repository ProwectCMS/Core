<?php

namespace ProwectCMS\Core\Library\Account\Credentials;

use ProwectCMS\Core\Library\Account\Managers\IManager;
use ProwectCMS\Core\Models\Account;
use ProwectCMS\Core\Models\AccountCredential;

interface ICredential
{
    public static function getTypeName() : string;

    public function getManager() : IManager;

    public function __construct(AccountCredential $accountCredential);

    public function check(array $credentials) : bool;
}