<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserAccess
{
    public function handle(Request $request, Closure $next, $userType)
    {
        return Auth::user() && Auth::user()->user_type == $userType ? $next($request) : abort(401);
    }
}
