<?php

$defaultSettingsPath = Composer\InstalledVersions::getInstallPath('spatie/laravel-event-sourcing') . '/config/event-sourcing.php';
$defaultSettings = include($defaultSettingsPath);

return array_merge($defaultSettings ,[
    /*
     * Projectors are classes that build up projections. You can create them by performing
     * `php artisan event-sourcing:create-projector`. When not using auto-discovery,
     * Projectors can be registered in this array or a service provider.
     */
    'projectors' => [
        // App\Projectors\YourProjector::class
    ],

    /*
     * Reactors are classes that handle side-effects. You can create them by performing
     * `php artisan event-sourcing:create-reactor`. When not using auto-discovery
     * Reactors can be registered in this array or a service provider.
     */
    'reactors' => [
        // App\Reactors\YourReactor::class
    ],

    'stored_event_model' => \ProwectCMS\Core\Models\StoredEvent::class,
    'snapshot_model' => \ProwectCMS\Core\Models\Snapshot::class,
]);