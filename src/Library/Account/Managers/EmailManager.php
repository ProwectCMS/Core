<?php

namespace ProwectCMS\Core\Library\Account\Managers;

use Illuminate\Http\Request;
use ProwectCMS\Core\Library\Account\Credentials\ICredential;
use ProwectCMS\Core\Models\Account;

class EmailManager extends CredentialManager
{
    public function getCreateValidationRules() : array
    {
        $overrideRules = [
            'email' => 'required_without:username|email|min:' . static::VALIDATION_USERNAME_MIN . '|max:' . static::VALIDATION_USERNAME_MAX . '|unique:account_credentials,username',
            'username' => 'required_without:email|email|min:' . static::VALIDATION_USERNAME_MIN . '|max:' . static::VALIDATION_USERNAME_MAX . '|unique:account_credentials,username',
        ];

        $rules = parent::getCreateValidationRules();

        return array_merge($rules, $overrideRules);
    }

    public function getUpdateValidationRules() : array
    {
        $overrideRules = [
            'email' => 'min:' . static::VALIDATION_USERNAME_MIN . '|max:' . static::VALIDATION_USERNAME_MAX . '|unique:account_credentials,username,' . $this->accountCredential->id,
            'username' => 'min:' . static::VALIDATION_USERNAME_MIN . '|max:' . static::VALIDATION_USERNAME_MAX . '|unique:account_credentials,username,' . $this->accountCredential->id,
        ];

        $rules = parent::getUpdateValidationRules();

        return array_merge($rules, $overrideRules);
    }

    public function handleCreateRequest(Account $account, Request $request) : ICredential
    {
        $username = $request->input('email');
        if (!$username) {
            $username = $request->input('username');
        }
        $password = bcrypt($request->input('password'));

        $attributes = [
            'username' => $username,
            'password' => $password
        ];

        $this->createAccountCredential($account, $attributes, $request);

        return $this->accountCredential;
    }

    public function handleUpdateRequest(Request $request)
    {
        $username = $request->input('email');
        if (!$username) {
            $username = $request->input('username');
        }
        $password = $request->input('password');

        $attributes = [
            'username' => $username,
            'password' => $password
        ];

        $this->updateAccountCredential($attributes, $request);
    }

    public function handleDeleteRequest(Request $request)
    {
        $this->deleteAccountCredential();
    }
}