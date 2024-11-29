<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Http\Request;
use Redirect;
use Symfony\Component\HttpFoundation\Response;

class UserCanLoginMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $Fadly_request, Closure $Fadly_next): Response
    {
        if (Auth::check() && Auth::user()->verified == 0) {
            Auth::logout();
            return redirect()->route('login')
                ->withErrors(['email' => 'Akun Anda belum diverifikasi.']);
        }

        return $Fadly_next($Fadly_request);
    }
}
