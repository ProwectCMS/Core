<?php

namespace ProwectCMS\Core\Library\Account\Managers;

use Illuminate\Http\Request;
use ProwectCMS\Core\Library\Account\Credentials\ICredential;
use ProwectCMS\Core\Models\Account;

class CredentialManager extends BaseManager
{
    const VALIDATION_USERNAME_MIN = 3;
    const VALIDATION_USERNAME_MAX = 255;
    const VALIDATION_PASSWORD_MIN = 3;

    protected ICredential $accountCredential;

    public function __construct(ICredential $accountCredential)
    {
        parent::__construct($accountCredential);
    }

    public function getCreateValidationRules() : array
    {
        $rules = [
            'username' => 'required|filled|min:' . static::VALIDATION_USERNAME_MIN . '|max:' . static::VALIDATION_USERNAME_MAX . '|unique:account_credentials,username',
            'password' => 'required|filled|min:' . static::VALIDATION_PASSWORD_MIN,
        ];

        return array_merge($rules, $this->getAdditionalCreateValidationRules());
    }

    public function getUpdateValidationRules() : array
    {
        $rules = [
            'username' => 'min:' . static::VALIDATION_USERNAME_MIN . '|max:' . static::VALIDATION_USERNAME_MAX . '|unique:account_credentials,username,' . $this->accountCredential->id,
            'password' => 'min:' . static::VALIDATION_PASSWORD_MIN,
        ];

        return array_merge($rules, $this->getAdditionalUpdateValidationRules());
    }

    public function handleCreateRequest(Account $account, Request $request) : ICredential
    {
        $username = $request->input('username');
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
        $username = $request->input('username');
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