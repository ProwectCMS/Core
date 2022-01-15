<?php

namespace ProwectCMS\Core\Library\Account\Auth;

use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Auth\UserContract;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Hashing\Hasher as HasherContract;
use ProwectCMS\Core\Library\Account\AccountCredentialFactory;
use ProwectCMS\Core\Models\Account;
use ProwectCMS\Core\Models\AccountCredential;

class AccountProvider extends EloquentUserProvider
{
    protected AccountCredentialFactory $accountCredentialFactory;

    public function __construct(HasherContract $hasher, $model, AccountCredentialFactory $accountCredentialFactory)
    {
        parent::__construct($hasher, $model);
        $this->accountCredentialFactory = $accountCredentialFactory;
    }

    protected function getAccountCredential(Authenticatable $user, $type)
    {
        $type = strtoupper($type);
        $class = $this->accountCredentialFactory->getClassForType($type);

        $accountCredential = $user->credentials()->where('type', $type)->first();

        if ($accountCredential) {
            return new $class($accountCredential);
        }

        return null;
    }

    public function retrieveByCredentials(array $credentials)
    {
        if (isset($credentials['type'], $credentials['username'])) {
            $type = strtoupper($credentials['type']);
            $username = $credentials['username'];

            $accountCredential = AccountCredential::query()
                ->where([
                    'type' => $type,
                    'username' => $username
                ])->first();

            if ($accountCredential) {
                // TODO: type specific check -> f.e. password correct?
                
                return $accountCredential->account;
            }
        }

        return null;
    }

    public function validateCredentials(Authenticatable $user, array $credentials)
    {
        $type = $credentials['type'];

        $accountCredential = $this->getAccountCredential($user, $type);

        if ($accountCredential) {
            return $accountCredential->check($credentials);
        }

        return false;
    }

    public function retrieveByToken($identifier, $token)
    {
        $model = $this->createModel();

        $retrievedModel = $this->newModelQuery($model)->where($model->getAuthIdentifierName(), $identifier)->first();

        if ($retrievedModel) {
            foreach($retrievedModel->credentials as $credential) {
                if ($credential->remember_token) {
                    if (hash_equals($credential->remember_token, $token)) {
                        return $retrievedModel;
                    }
                }
            }
        }

        return null;
    }
}