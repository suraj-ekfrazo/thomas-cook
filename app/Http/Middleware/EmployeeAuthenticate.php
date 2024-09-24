<?php

namespace App\Http\Middleware;

use Closure;

class EmployeeAuthenticate
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
        if (!$request->session()->exists('agent_code')) {
            return redirect()->route('employee.login');
        }
        return $next($request);
    }
}
