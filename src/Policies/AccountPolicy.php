<?php

namespace ProwectCMS\Core\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use ProwectCMS\Core\Models\Account;

class AccountPolicy
{
    use HandlesAuthorization;

    public function store(?Account $account)
    {
        return true;
    }
}