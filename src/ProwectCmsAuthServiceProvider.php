<?php

namespace ProwectCMS\Core;

use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use ProwectCMS\Core\Library\Account\AccountCredentialFactory;
use ProwectCMS\Core\Library\Account\Auth\AccountProvider;
use ProwectCMS\Core\Models\Account;
use ProwectCMS\Core\Models\AccountCredential;

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
        $this->registerAuth();
        $this->registerPolicies();
    }

    protected function registerAuth()
    {
        Config::set('auth.guards.prowectcms', [
            'driver' => 'session',
            'provider' => 'prowectcms',
        ]);

        Config::set('auth.providers.prowectcms', [
            'driver' => 'prowectcms',
            'model' => Account::class,
        ]);

        Auth::provider('prowectcms', function ($app, array $config) {
            return new AccountProvider($app->make(Hasher::class), $config['model'], $app->make(AccountCredentialFactory::class));
        });
    }
}