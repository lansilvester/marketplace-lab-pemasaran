<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AuthAdmin
{

    // public function handle(Request $request, Closure $next){
    //     if(session('utype') === 'ADM' ||
    //        session('utype') === 'PNJ' ||
    //        session('utype') === 'OPT' ||
    //        session('utype') === 'PBN'){
    //         return $next($request);
    //     }else{
    //         session()->flush();
    //         return redirect()->route('login');
    //     }
    //     return $next($request);
    // }
    public function handle(Request $request, Closure $next)
    {
        $userType = session('utype');
        Log::info('Checking user type in AuthAdmin middleware:', ['utype' => $userType]);

        if (in_array($userType, ['ADM', 'PNJ', 'OPT', 'PBN'])) {
            return $next($request);
        } else {
            session()->flush();
            return redirect()->route('login');
        }
    }
}
