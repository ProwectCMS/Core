<?php

namespace ProwectCMS\Core\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use ProwectCMS\Core\Models\Account;

class AccountPolicy
{
    use HandlesAuthorization;

    public function store(?Account $currentUser)
    {
        // TODO: Settings depending on type, etc.?
        return true;
    }

    public function delete(Account $currentUser, Account $account)
    {
        // TODO: Admins can delete accounts

        return $currentUser->id == $account->id;
    }
}