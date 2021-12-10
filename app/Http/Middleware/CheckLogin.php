<?php

namespace App\Http\Middleware;

use App\Http\Controllers\ADMINISTRATION\AccessController;
use Closure;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller; use Illuminate\Support\Facades\Session;


class CheckLogin
{
    public function handle($request, Closure $next)
    {
        if (Session::get('usid')!=null && Session::get('usid')!='') {

            $isChanged = false;

            Session::put('menu', AccessController::getListMenu(Session::get('usid')));

            if(!in_array(Session::get('usid'), ['DEV','SUP'])) {
                if(!AccessController::isAccessible(\Request::getPathInfo())){
                    abort(403);
                }
            }


//            if(count($menu) == count(Session::get('menu'))){
//                for($i=0;$i<count($menu);$i++){
//                    if($menu[$i]->acc_id != Session::get('menu')[$i]->acc_id){
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
