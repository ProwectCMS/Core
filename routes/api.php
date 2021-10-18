<?php

$routeConfig = [
    'as' => 'api.', 
    'middleware' => 'api', 
    'prefix' => 'api', 
    'namespace' => '\\ProwectCMS\\Core\\Http\\Controllers\\API'
];

Route::group($routeConfig, function() {
    Route::get('health', 'HealthController@index')->name('health');
    Route::get('version', 'VersionController@index')->name('version');
});