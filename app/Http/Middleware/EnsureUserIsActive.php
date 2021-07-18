<?php

namespace App\Http\Middleware;

use App\Services\UserService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureUserIsActive
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
        // UserService::userIsActive();

        if (Auth::user()->status == 0) {

            // Auth::logout();
            auth('web')->logout();
            // auth('api')->logout();

            return redirect('/login')->with('errors', [
                'Your account has been disabled.'
            ]);
        } else {

            return $next($request);
        }
    }
}
