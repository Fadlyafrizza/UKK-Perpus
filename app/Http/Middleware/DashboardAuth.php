<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DashboardAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $Fadly_request, Closure $Fadly_next): Response
    {
        if (Auth::check()) {
            if (Auth::user()->hasRole()) {
                return to_route('dashboard');
            }
        }

        return $Fadly_next($Fadly_request);
    }
}
