<?php

namespace ProwectCMS\Core\Library\Account\Managers;

use Illuminate\Http\Request;
use ProwectCMS\Core\Aggregates\Account\AccountCredentialAggregate;
use ProwectCMS\Core\Library\Account\Credentials\ICredential;
use ProwectCMS\Core\Models\Account;
use ProwectCMS\Core\Models\AccountCredential;

abstract class BaseManager implements IManager
{
    protected ICredential $accountCredential;

    public function __construct(ICredential $accountCredential)
    {
        $this->accountCredential = $accountCredential;
    }

    public function getAccountCredential() : ICredential
    {
        return $this->accountCredential;
    }

    public function getAdditionalCreateValidationRules() : array
    {
         return [
            'meta' => 'array'
        ];
    }

    public function getAdditionalUpdateValidationRules() : array
    {
        return [
            'meta' => 'array'
        ];
    }

    public function createAccountCredential(Account $account, array $attributes, Request $request = null)
    {
        $attributes['type'] = $this->accountCredential::getTypeName();

        if ($request) {
            $attributes['meta'] = $request->input('meta', []);
        }

        $accountCredential = AccountCredential::createWithAttributes($account->id, $attributes);

        $class = get_class($this->accountCredential);

        $this->accountCredential = new $class($accountCredential);
    }

    public function updateAccountCredential(array $attributes, Request $request = null)
    {
        if ($request) {
            if ($request->has('meta')) {
                $attributes['meta'] = $request->input('meta');
            }
        }

        AccountCredentialAggregate::retrieve($this->accountCredential->id)
            ->update($attributes)
            ->persist();

        $this->accountCredential->refresh();   
    }

    public function deleteAccountCredential()
    {
        AccountCredentialAggregate::retrieve($this->accountCredential->id)->delete()
            ->persist();
    }
}