<?php

namespace ProwectCMS\Core;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use ProwectCMS\Core\Library\Account\AccountCredentialFactory;

class ProwectCmsAuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Models\Account::class => Policies\AccountPolicy::class,
        Models\AccountCredential::class => Policies\AccountCredentialPolicy::class,
    ];

    protected $accountCredentialTypes = [
        Library\Account\Credentials\Token::class,
        Library\Account\Credentials\Username::class,
        Library\Account\Credentials\Email::class
    ];

    protected function getAccountCredentialTypes()
    {
        return $this->accountCredentialTypes;
    }

    public function register()
    {
        $this->app->singleton(AccountCredentialFactory::class, function() {
            $accountCredentialFactory = new AccountCredentialFactory();

            return $accountCredentialFactory;
        });

        // Register Account Credential Types
        $accountCredentialFactory = $this->app->make(AccountCredentialFactory::class);
        foreach ($this->getAccountCredentialTypes() as $accountCredentialType) {
            $accountCredentialFactory->register($accountCredentialType);
        }
    }

    public function boot()
    {
        $this->registerPolicies();
    }
}