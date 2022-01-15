<?php

namespace ProwectCMS\Core\Providers;

use Laravel\Sanctum\Sanctum;
use Laravel\Sanctum\SanctumServiceProvider as BaseServiceProvider;
use ProwectCMS\Core\Library\Sanctum\Models\PersonalAccessToken;

class SanctumServiceProvider extends BaseServiceProvider
{
    public function register()
    {
        parent::register();

        Sanctum::ignoreMigrations();
    }

    public function boot()
    {
        parent::boot();

        Sanctum::usePersonalAccessTokenModel(PersonalAccessToken::class);
    }
}