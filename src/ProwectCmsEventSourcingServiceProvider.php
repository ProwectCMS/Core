<?php

namespace ProwectCMS\Core;

use Illuminate\Support\ServiceProvider;
use Spatie\EventSourcing\Facades\Projectionist;

class ProwectCmsEventSourcingServiceProvider extends ServiceProvider
{
    public function register()
    {
        Projectionist::addProjectors([
            Projectors\Account\AccountProjector::class,
            Projectors\Account\AccountCredentialProjector::class,
        ]);
    }
}