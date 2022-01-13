<?php

namespace ProwectCMS\Core;

use Illuminate\Support\ServiceProvider;
use Spatie\EventSourcing\Facades\Projectionist;

class ProwectCmsEventSourcingServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Projectionist::addProjectors([
            Projectors\Account\AccountProjector::class,
            Projectors\Account\AccountCredentialProjector::class,
        ]);
    }
}