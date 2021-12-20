<?php

namespace ProwectCMS\Core\Library\Account\Credentials;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use ProwectCMS\Core\Models\Account;
use ProwectCMS\Core\Models\AccountCredential;

class Email extends Credential
{
    public static function getTypeName() : string
    {
        return AccountCredential::TYPE_EMAIL;
    }

    public static function getCreateValidationRules()
    {
        return [
            'email' => 'required_without:username|email|min:3|max:255|unique:account_credentials,username',
            'username' => 'required_without:email|email|min:3|max:255|unique:account_credentials,username',
            'password' => 'required|filled|min:3',
            'meta' => 'array'
        ];
    }

    public function getUpdateValidationRules()
    {
        return [
            'email' => 'email|min:3|max:255|unique:account_credentials,username,' . $this->accountCredential->id,
            'username' => 'email|min:3|max:255|unique:account_credentials,username,' . $this->accountCredential->id,
            'password' => 'min:3',
            'meta' => 'array'
        ];
    }

    public static function handleCreateRequest(Account $account, Request $request)
    {
        $username = $request->input('email');
        if (!$username) {
            $username = $request->input('username');
        }
        $password = bcrypt($request->input('password'));
        $meta = $request->input('meta', []);

        return static::createAccountCredential($account, $username, $password, $meta);
    }

    public function handleUpdateRequest(Request $request)
    {
        $username = $request->input('email');
        if (!$username) {
            $username = $request->input('username');
        }
        $password = $request->input('password');
        $meta = $request->input('meta');

        $this->update($username, $password, $meta);
    }
}