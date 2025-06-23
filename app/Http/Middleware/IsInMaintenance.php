<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

class IsInMaintenance
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check()) {
            if (isCustomerUserGroup()) {
                if (getSetting('enable_maintenance_mode') == 1) {
                    abort(503);
                }
            }
        }else{
            if (!in_array(Route::currentRouteAction(), [
                'App\Http\Controllers\Auth\LoginController@showLoginForm',
                'App\Http\Controllers\Auth\LoginController@login',
                'App\Http\Controllers\Auth\LoginController@logout',
            ])) {
                if (getSetting('enable_maintenance_mode') == 1) {
                    abort(503);
                }
            }
        }
        return $next($request);
    }
}
