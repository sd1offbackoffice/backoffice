<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;


class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function cekProcedure($sp){
        return DB::connection(Session::get('connection'))
            ->select("select  count(1) count
                              from  " . 'gv$access' . "
                              where type = 'PROCEDURE'
                              and object in (".$sp.")
                                and (inst_id,sid) in (
                                                      select  inst_id,
                                                              sid
                                                        from  " . 'gv$session' . "
                                                        where type = 'USER'
                                                     )")[0]->count;
    }
}



