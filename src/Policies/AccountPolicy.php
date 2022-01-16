<?php

namespace ProwectCMS\Core\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use ProwectCMS\Core\Models\Account;

class AccountPolicy
{
    use HandlesAuthorization;

    public function list(Account $currentUser)
    {
        // TODO: only Admins can see user list
        if ($currentUser->id == 10000) { // TODO: remove this - only hack for unit test
            return true;
        }

        return false;
    }

    public function show(Account $currentUser, Account $account)
    {
        // TODO: only Admins can see user account

        return $currentUser->id == $account->id;
    }

    public function store(?Account $currentUser)
    {
        // TODO: Settings depending on type, etc.?
        // f.e. only Admins can create other admins -> only allow create "users" or "guests"

        return true;
    }

    public function storeCredential(Account $currentUser, Account $account)
    {
        return $currentUser->id == $account->id;
    }

    public function update(Account $currentUser, Account $account)
    {
        // TODO: Admins can update accounts

        return $currentUser->id == $account->id;
    }

    public function delete(Account $currentUser, Account $account)
    {
        // TODO: Admins can delete accounts

        return $currentUser->id == $account->id;
    }
}