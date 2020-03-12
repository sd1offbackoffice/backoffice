<?php

namespace App\Http\Middleware;

use Closure;

if (!isset($_SESSION)) {
    session_start();
}

class CheckLogin
{
    public function handle($request, Closure $next)
    {
//        dd($_SESSION['usid']);
        if (isset($_SESSION['usid']) && $_SESSION['usid']!='') {
            return $next($request);
        } else return redirect('/login');

    }
}