<?php

namespace App\Http\Controllers\ADMINISTRATION;

use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;
use PDF;
use Yajra\DataTables\DataTables;

class AccessController extends Controller
{
    public function index(){
        $group = DB::table('tbmaster_access_migrasi')
            ->selectRaw('acc_group, count(1) total')
            ->orderBy('acc_group')
            ->groupBy('acc_group')
            ->get();

        $menu = DB::table('tbmaster_access_migrasi')
            ->orderBy('acc_id')
            ->orderBy('acc_group')
            ->orderBy('acc_subgroup1')
            ->orderBy('acc_subgroup2')
            ->orderBy('acc_subgroup3')
            ->orderBy('acc_name')
            ->get();

        return view('ADMINISTRATION.access')->with(compact(['group','menu']));
    }

    public function getLovUser(){
        $data = DB::table('tbmaster_user')
            ->whereRaw("recordid is null")
            ->orderBy('userid')
            ->get();

        return DataTables::of($data)->make(true);
    }

    public function getData(Request $request){
        $temp = DB::table('tbmaster_user')
            ->where('userid','=',$request->userid)
            ->first();

        if(!$temp){
            return response()->json([
                'title' => 'Data user tidak ditemukan!'
            ], 500);
        }
        else{
            $data = DB::table('tbmaster_useraccess_migrasi')
                ->select('uac_acc_id')
                ->where('uac_userid','=',$request->userid)
                ->get();

            return $data;
        }
    }

    public function save(Request $request){
        $temp = DB::table('tbmaster_user')
            ->where('userid','=',$request->userid)
            ->first();

        if(!$temp){
            return response()->json([
                'title' => 'Data user tidak ditemukan!'
            ], 500);
        }
        else{
            DB::table('tbmaster_useraccess_migrasi')
                ->where('uac_userid','=',$request->userid)
                ->delete();

            foreach($request->menu as $m){
                DB::table('tbmaster_useraccess_migrasi')
                    ->insert([
                        'uac_userid' => $request->userid,
                        'uac_acc_id' => $m,
                        'uac_create_by' => $_SESSION['usid'],
                        'uac_create_dt' => DB::RAW("SYSDATE")
                    ]);
            }

            return response()->json([
                'title' => 'Data berhasil disimpan!'
            ], 200);
        }
    }

    public function clone(){
//        $data = DB::table('tbmaster_useraccess_migrasi')->get();
//
//        DB::connection('igrsmg')
//            ->table('tbmaster_useraccess_migrasi')
//            ->insert(json_decode(json_encode($data), true));
    }
}
