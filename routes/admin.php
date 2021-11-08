<?php

$routeConfig = [
    'as' => 'prowectcms.admin.', 
    'middleware' => 'web', 
    'prefix' => 'admin', 
    'namespace' => '\\ProwectCMS\\Core\\Http\\Controllers\\Admin'
];

Route::group($routeConfig, function() {
    Route::get('/login', 'AuthController@viewLogin')->name('login');

    // TODO: protected -> only for authorized admin users
    Route::get('/', 'DashboardController@index')->name('dashboard');
});