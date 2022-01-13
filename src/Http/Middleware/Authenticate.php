<?php

namespace ProwectCMS\Core\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    public function handle($request, Closure $next, ...$guards)
    {
        $this->authenticate($request, ['prowectcms']);

        return $next($request);
    }

    protected function redirectTo($request)
    {
        return route('prowectcms.admin.login');
    }
}