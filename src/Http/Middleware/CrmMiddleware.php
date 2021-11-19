<?php

namespace Esatic\Suitecrm\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CrmMiddleware
{

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        return $next($request);
    }

}
