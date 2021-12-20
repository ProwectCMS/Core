<?php

namespace ProwectCMS\Core\Library\Account\Credentials;

use Illuminate\Http\Request;
use ProwectCMS\Core\Aggregates\Account\AccountCredentialAggregate;
use ProwectCMS\Core\Events\Account\AccountCredentialUpdated;
use ProwectCMS\Core\Models\Account;
use ProwectCMS\Core\Models\AccountCredential;

abstract class Credential implements ICredential
{
    protected AccountCredential $accountCredential;

    public static function createAccountCredential(Account $account, string $username = null, string $password = null, array $meta = []) : ICredential
    {
        $accountCredential = AccountCredential::createWithAttributes([
            'account_id' => $account->id,
            'type' => static::getTypeName(),
            'username' => $username,
            'password' => $password,
            'meta' => $meta
        ]);

        return new static($accountCredential);
    }

    public function __construct(AccountCredential $accountCredential)
    {
        $this->accountCredential = $accountCredential;
    }

    public function __call($name, $arguments)
    {
        return $this->accountCredential->$name(...$arguments);
    }

    public function __get($name)
    {
        return $this->accountCredential->{$name};
    }

    public function __set($name, $value)
    {
        $this->accountCredential->{$name} = $value;
    }

    public static function getCreateValidationRules()
    {
        return [
            'username' => 'required|filled|min:3|max:255|unique:account_credentials,username',
            'password' => 'required|filled|min:3',
            'meta' => 'array'
        ];
    }

    public function getUpdateValidationRules()
    {
        return [
            'username' => 'min:3|max:255|unique:account_credentials,username,' . $this->accountCredential->id,
            'password' => 'min:3',
            'meta' => 'array'
        ];
    }

    public static function handleCreateRequest(Account $account, Request $request)
    {
        $username = $request->input('username');
        $password = bcrypt($request->input('password'));
        $meta = $request->input('meta', []);

        return static::createAccountCredential($account, $username, $password, $meta);
    }

    public function update(string $username = null, string $password = null, array $meta = null)
    {
        $updatedAttributes = [];

        if (!is_null($username)) {
            $updatedAttributes['username'] = $username;
        }

        if (!is_null($password)) {
            $updatedAttributes['password'] = $password;
        }

        if (!is_null($meta)) {
            $updatedAttributes['meta'] = $meta;
        }

        event(new AccountCredentialUpdated($this->accountCredential, $updatedAttributes));

        $this->accountCredential->refresh();
    }

    public function handleUpdateRequest(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');
        $meta = $request->input('meta');

        $this->update($username, $password, $meta);
    }
}