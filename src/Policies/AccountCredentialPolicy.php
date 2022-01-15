<?php

namespace ProwectCMS\Core\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use ProwectCMS\Core\Models\Account;
use ProwectCMS\Core\Models\AccountCredential;

class AccountCredentialPolicy
{
    use HandlesAuthorization;

    public function store(Account $currentUser)
    {
        return true;
    }

    public function update(Account $currentUser, AccountCredential $accountCredential)
    {
        return $currentUser->id == $accountCredential->account_id;
    }

    public function delete(Account $currentUser, AccountCredential $accountCredential)
    {
        $credentials = $currentUser->credentials;
        if (count($credentials) > 0) {
            return $currentUser->id == $accountCredential->account_id;
        }

        return false;
    }
}