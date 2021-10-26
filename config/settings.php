<?php

$defaultSettingsPath = Composer\InstalledVersions::getInstallPath('spatie/laravel-settings') . '/config/settings.php';
$defaultSettings = include($defaultSettingsPath);

return array_merge($defaultSettings ,[

    /*
     * Each settings class used in your application must be registered, you can
     * put them (manually) here.
     */
    'settings' => [
        \ProwectCMS\Core\Settings\GeneralSettings::class
    ],
]);