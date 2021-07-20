<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::user()->is_active == 0) {

            // Auth::logout();

            $request->session()->invalidate();

            $request->session()->regenerateToken();

            abort(403, "Your account has been disabled.");
        }

        return $next($request);
    }
}
