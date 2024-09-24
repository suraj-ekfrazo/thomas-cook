<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    // public function handle($request, Closure $next, $guard = null)
    // {
    //     if (Auth::guard($guard)->check()) {
    //         return redirect('/home');
    //     }
    //     return $next($request);
    // }
    public function handle($request, Closure $next, $guard = null)
    {
        if ($guard == "admin" && Auth::guard($guard)->check()) {
            return redirect('/dashboard');
        }
        if ($guard == "agent" && Auth::guard($guard)->check()) {
            return redirect('/agent/dashboard');
        }
	if ($guard == "tcuser" && Auth::guard($guard)->check()) {
            return redirect('/tcuser/dashboard');
        }

        if (Auth::guard($guard)->check()) {
            session()->forget(['agent_id', 'agent_code']);
            return redirect(RouteServiceProvider::HOME);
        }

        return $next($request);
    }
}
