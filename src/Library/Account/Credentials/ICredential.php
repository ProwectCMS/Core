<?php

namespace ProwectCMS\Core\Library\Account\Credentials;

use ProwectCMS\Core\Models\Account;
use ProwectCMS\Core\Models\AccountCredential;

interface ICredential
{
    public static function getTypeName() : string;

    public static function createAccountCredential(Account $account, string $username = null, string $password = null, array $meta = []) : ICredential;

    public function __construct(AccountCredential $accountCredential);
}