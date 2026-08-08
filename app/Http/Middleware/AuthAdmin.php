<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthAdmin
{
    public function handle(Request $request, Closure $next)
    {
        $userType = Auth::user() ? Auth::user()->utype : null;

        if (in_array($userType, ['ADM', 'OPT', 'PNJ', 'PBN'])) {
            return $next($request);
        }

        abort(403);
    }
}
