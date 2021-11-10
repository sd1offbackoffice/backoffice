<?php

namespace App\Http\Middleware;

use App\Http\Controllers\ADMINISTRATION\AccessController;
use Closure;
use Illuminate\Support\Facades\DB;

if (!isset($_SESSION)) {
    session_start();
}

class CheckLogin
{
    public function handle($request, Closure $next)
    {
        if (isset($_SESSION['usid']) && $_SESSION['usid']!='') {

            $isChanged = false;

            $_SESSION['menu'] = AccessController::getListMenu($_SESSION['usid']);

            if(!in_array($_SESSION['usid'], ['DEV','SUP'])) {
                if(!AccessController::isAccessible(\Request::getPathInfo())){
                    abort(403);
                }
            }


//            if(count($menu) == count($_SESSION['menu'])){
//                for($i=0;$i<count($menu);$i++){
//                    if($menu[$i]->acc_id != $_SESSION['menu'][$i]->acc_id){
//                        $isChanged = true;
//                        break;
//                    }
//                }
//            }
//            else $isChanged = true;

//            if($isChanged)
//                return redirect('/logout-access');
//            else{
//                return $next($request);
//            }
            return $next($request);
        }
        else return redirect('/login');
    }
}
