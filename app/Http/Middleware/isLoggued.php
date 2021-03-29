<?php

namespace App\Http\Middleware;

use App\Http\Controllers\LoginController;
use Closure;
use Session;

class isLoggued
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(session()->get('status') != 1)
            LoginController::logout();

        return $next($request);
    }
}
