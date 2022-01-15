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

    Route::group(['prefix' => 'auth', 'as' => 'auth.'], function() {
        Route::post('login', 'AuthController@login')->name('login');
        Route::group(['middleware' => 'auth:prowectcms_api'], function() {
            Route::get('user', 'AuthController@user')->name('user');
            Route::post('logout', 'AuthController@logout')->name('logout');
        });
    });

    Route::apiResource('accounts', 'AccountController'); // required Auth -> handled by Controller

    Route::group(['middleware' => 'auth:prowectcms_api'], function() {
        Route::post('accounts/{account}/credentials/{type}', 'AccountCredentialController@store')->name('accounts.credentials.store');
        Route::patch('accounts/{account}/credentials/{type}/{credential}', 'AccountCredentialController@update')->name('accounts.credentials.update');
        Route::delete('accounts/{account}/credentials/{type}/{credential}', 'AccountCredentialController@destroy')->name('accounts.credentials.delete');
    });
});