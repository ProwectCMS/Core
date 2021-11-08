<?php

namespace ProwectCMS\Core;

use Composer\InstalledVersions;
use Illuminate\Support\ServiceProvider;

class ProwectCmsServiceProvider extends ServiceProvider
{
    const PACKAGE_PREFIX = 'prowectcms';

    // const CONFIG_PATH = '/../config/prowectcms.php';
    // const CONFIG_NAME = 'prowectcms';

    // const ROUTES_WEB_PATH = '/../routes/web.php';
    const ROUTES_API_PATH = '/../routes/api.php';
    const ROUTES_ADMIN_PATH = '/../routes/admin.php';

    const RESOURCES_PATH = '/../resources';
    const MIGRATIONS_PATH = '/../database/migrations';
    
    // const TRANSLATIONS_PATH = '/../resources/lang';
    const VIEWS_PATH = '/../resources/views';
    const PUBLIC_PATH = '/../public';
    
    const PACKAGE_SETTINGS_MIGRATIONS_PATH = '/../database/settings';
    const PACKAGE_SETTINGS_CONFIG_PATH = '/../config/settings.php';
    const PACKAGE_SETTINGS_CONFIG_NAME = 'settings';

    public function boot()
    {
        if ($this->app->runningInConsole()) {
             $this->publishes([
                __DIR__ . static::RESOURCES_PATH . '/assets' => public_path(static::PACKAGE_PREFIX),
            ], 'assets');

            $this->publishes([
                __DIR__ . static::PUBLIC_PATH => public_path('vendor/' . static::PACKAGE_PREFIX),
            ], ['prowectcms-assets', 'laravel-assets']);
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
        
    }

    public function register()
    {
        // $this->mergeConfigFrom(__DIR__ . static::CONFIG_PATH, static::CONFIG_NAME);
        $this->mergeConfigFrom(__DIR__ . static::PACKAGE_SETTINGS_CONFIG_PATH, static::PACKAGE_SETTINGS_CONFIG_NAME);        
    }
}