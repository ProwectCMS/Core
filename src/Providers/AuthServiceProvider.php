<?php

namespace ProwectCMS\Core\Providers;

use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use ProwectCMS\Core\Library\Account\AccountCredentialFactory;
use ProwectCMS\Core\Library\Account\Auth\AccountProvider;
use ProwectCMS\Core\Library\Account\Credentials\Email;
use ProwectCMS\Core\Library\Account\Credentials\Token;
use ProwectCMS\Core\Library\Account\Credentials\Username;
use ProwectCMS\Core\Models\Account;
use ProwectCMS\Core\Models\AccountCredential;
use ProwectCMS\Core\Policies\AccountCredentialPolicy;
use ProwectCMS\Core\Policies\AccountPolicy;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Account::class => AccountPolicy::class,
        AccountCredential::class => AccountCredentialPolicy::class,
    ];

    protected $accountCredentialTypes = [
        Token::class,
        Username::class,
        Email::class
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
            'provider' => 'prowectcms'
        ]);

        Config::set('auth.guards.prowectcms_api', [
            'driver' => 'sanctum',
            'provider' => 'prowectcms'
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