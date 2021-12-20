<?php

namespace ProwectCMS\Core\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

class AccountCredentialPolicy
{
    use HandlesAuthorization;

    public function store(Account $account)
    {
        return true;
    }   
}