<?php

namespace ProwectCMS\Core\Providers;

use Illuminate\Support\ServiceProvider;
use ProwectCMS\Core\Projectors\Account\AccountCredentialProjector;
use ProwectCMS\Core\Projectors\Account\AccountProjector;
use Spatie\EventSourcing\Facades\Projectionist;

class EventSourcingServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Projectionist::addProjectors([
            AccountProjector::class,
            AccountCredentialProjector::class,
        ]);
    }
}