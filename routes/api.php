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

    Route::apiResource('accounts', 'AccountController');

    Route::post('accounts/{account}/credentials/{type}', 'AccountCredentialController@store')->name('accounts.credentials.store');
    Route::patch('accounts/{account}/credentials/{type}/{credential}', 'AccountCredentialController@update')->name('accounts.credentials.update');
    Route::delete('accounts/{account}/credentials/{type}/{credential}', 'AccountCredentialController@destroy')->name('accounts.credentials.delete');
});