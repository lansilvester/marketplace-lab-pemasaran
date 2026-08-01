<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthAdmin
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && in_array(Auth::user()->utype, ['ADM', 'PNJ', 'OPT', 'PBN'])) {
            return $next($request);
        }

        session()->flush();

        return redirect()->route('login');
    }
}
