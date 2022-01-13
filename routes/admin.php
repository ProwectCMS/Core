<?php

$routeConfig = [
    'as' => 'prowectcms.admin.', 
    'middleware' => 'web', 
    'prefix' => 'admin', 
    'namespace' => '\\ProwectCMS\\Core\\Http\\Controllers\\Admin'
];

Route::group($routeConfig, function() {
    Route::get('/login', 'AuthController@viewLogin')->name('login');
    Route::post('/login', 'AuthController@login')->name('login.auth');

    Route::group(['middleware' => \ProwectCMS\Core\Http\Middleware\Authenticate::class], function() {
        Route::match(['GET', 'POST'], '/logout', 'AuthController@logout')->name('logout');

        Route::get('/', 'DashboardController@index')->name('dashboard');
    });
});