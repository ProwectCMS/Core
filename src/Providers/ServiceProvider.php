<?php

namespace ProwectCMS\Core\Providers;

use Composer\InstalledVersions;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use ProwectCMS\Core\Console\Account\CreateAdminAccount;
use ProwectCMS\Core\Models\Account;

class ServiceProvider extends BaseServiceProvider
{
    const PACKAGE_PREFIX = 'prowectcms';

    // const CONFIG_PATH = '/../../config/prowectcms.php';
    // const CONFIG_NAME = 'prowectcms';

    // const ROUTES_WEB_PATH = '/..å/../routes/web.php';
    const ROUTES_API_PATH = '/../../routes/api.php';
    const ROUTES_ADMIN_PATH = '/../../routes/admin.php';

    const RESOURCES_PATH = '/../../resources';
    const MIGRATIONS_PATH = '/../../database/migrations';
    
    // const TRANSLATIONS_PATH = '/../resources/lang';
    const VIEWS_PATH = '/../../resources/views';
    const PUBLIC_PATH = '/../../public';
    
    const PACKAGE_SETTINGS_MIGRATIONS_PATH = '/../../database/settings';
    const PACKAGE_SETTINGS_CONFIG_PATH = '/../../config/settings.php';
    const PACKAGE_SETTINGS_CONFIG_NAME = 'settings';

    const PACKAGE_EVENT_SOURCING_CONFIG_PATH = '/../../config/event-sourcing.php';
    const PACKAGE_EVENT_SOURCING_CONFIG_NAME = 'event-sourcing';

    public function boot()
    {
        if ($this->app->runningInConsole()) {
             $this->publishes([
                __DIR__ . static::RESOURCES_PATH => public_path(static::PACKAGE_PREFIX),
            ], 'assets');

            $this->publishes([
                __DIR__ . static::PUBLIC_PATH => public_path('vendor/' . static::PACKAGE_PREFIX),
            ], ['prowectcms-assets', 'laravel-assets']);

            $this->registerCommands();
            $this->registerCronjobs();
        }
        // $this->publishes([
        //     __DIR__ . static::CONFIG_PATH => config_path(static::CONFIG_NAME . '.php')
        // ]);

        // Load routes
        // $this->loadRoutesFrom(__DIR__ . static::ROUTES_WEB_PATH);
        $this->loadRoutesFrom(__DIR__ . static::ROUTES_API_PATH);
        $this->loadRoutesFrom(__DIR__ . static::ROUTES_ADMIN_PATH);

        // Load migrations
        $this->loadMigrationsFrom(__DIR__ . static::MIGRATIONS_PATH);
        $this->loadMigrationsFrom(__DIR__ . static::PACKAGE_SETTINGS_MIGRATIONS_PATH);

        // Load translations
        // $this->loadTranslationsFrom(__DIR__ . static::TRANSLATIONS_PATH, static::PACKAGE_PREFIX);

        // Load views
        $this->loadViewsFrom(__DIR__ . static::VIEWS_PATH, static::PACKAGE_PREFIX);

        // Load components
        // $this->loadViewComponentsAs(static::PACKAGE_PREFIX, [
        //     Alert::class,
        //     Button::class,
        // ]);
        
        // if ($this->app->runningInConsole()) {
        //     $this->commands([
        //         InstallCommand::class,
        //         NetworkCommand::class,
        //     ]);
        // }

        // register Projectors within a service provider (instead of settings)
        // Projectionist::addProjector(TransactionCountProjector::class);

        Relation::enforceMorphMap([
            'account' => Account::class,
        ]);
    }

    public function register()
    {
        // $this->mergeConfigFrom(__DIR__ . static::CONFIG_PATH, static::CONFIG_NAME);
        $this->mergeConfigFrom(__DIR__ . static::PACKAGE_SETTINGS_CONFIG_PATH, static::PACKAGE_SETTINGS_CONFIG_NAME);        
        $this->mergeConfigFrom(__DIR__ . static::PACKAGE_EVENT_SOURCING_CONFIG_PATH, static::PACKAGE_EVENT_SOURCING_CONFIG_NAME);
    }

    protected function registerCommands()
    {
        $this->commands([
            CreateAdminAccount::class
        ]);
    }

    protected function registerCronjobs()
    {
        $this->app->booted(function () {
            $schedule = $this->app->make(Schedule::class);

            // f.e. $schedule->command('some:command')-> etc.
        });
    }
}