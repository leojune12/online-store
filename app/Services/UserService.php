<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;

class UserService
{
    public static function userIsActive()
    {
        if (Auth::user()->status == 0) {

            // Auth::logout();
            auth('web')->logout();
            // auth('api')->logout();

            return redirect('/login')->with('errors', [
                'Your account has been disabled.'
            ]);
        }
    }
}
