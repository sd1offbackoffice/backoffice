<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TestController extends Controller {
    public function menu(){
        $menus = DB::connection('igrsmg')->table('tbmaster_access_migrasi')
            ->where('acc_group', 'OMI')->get();

        foreach ($menus as $data){
            DB::connection('simtgr')->table('tbmaster_access_migrasi')
                ->insert(['acc_group' => $data->acc_group, 'acc_subgroup1' => $data->acc_subgroup1, 'acc_name' => $data->acc_name,
                    'acc_level' => $data->acc_level, 'acc_url' => $data->acc_url, 'acc_id' => $data->acc_id,
                    'acc_create_by' => $data->acc_create_by, 'acc_create_dt' => $data->acc_create_dt, 'acc_status' => $data->acc_status]);
        }

        $simtgr = DB::connection('simtgr')->table('tbmaster_access_migrasi')->orderBy('acc_group')->get();

        dd($simtgr);
    }
}
