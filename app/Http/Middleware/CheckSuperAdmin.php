<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class CheckSuperAdmin
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
        if(Auth::user()) {
            if(Auth::user()->role_id != 1) {
                return abort(403, 'Unauthorize Access');
            }
        }
        else {
            return redirect()->route('login')->with('error', 'Login First!');
        }

        return $next($request);
    }
}
