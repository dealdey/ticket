<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RegistrationMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if(Auth::guard($guard)->guest()) {
            return redirect()->guest('login');
        }
        elseif($request->user()->can(['create-user'])){
            return $next($request);
        }
        return redirect('/ticket');

    }
}
