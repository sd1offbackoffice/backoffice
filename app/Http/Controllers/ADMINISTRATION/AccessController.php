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
        $group = DB::connection($_SESSION['connection'])->table('tbmaster_access_migrasi')
            ->selectRaw('acc_group, count(1) total')
            ->where('acc_status','=',0)
            ->where('acc_group','<>','Administration')
            ->orderBy('acc_group')
            ->groupBy('acc_group')
            ->get();

        $menu = DB::connection($_SESSION['connection'])->table('tbmaster_access_migrasi')
            ->where('acc_status','=',0)
            ->where('acc_group','<>','Administration')
            ->orderBy('acc_group')
            ->orderBy('acc_subgroup1')
            ->orderBy('acc_subgroup2')
            ->orderBy('acc_subgroup3')
            ->orderBy('acc_order')
            ->orderBy('acc_name')
            ->get();

        return view('ADMINISTRATION.access')->with(compact(['group','menu']));
    }

    public function getLovUser(){
        $data = DB::connection($_SESSION['connection'])->table('tbmaster_user')
            ->whereRaw("recordid is null")
            ->orderBy('userid')
            ->get();

        return DataTables::of($data)->make(true);
    }

    public function getData(Request $request){
        $temp = DB::connection($_SESSION['connection'])->table('tbmaster_user')
            ->where('userid','=',$request->userid)
            ->first();

        if(!$temp){
            return response()->json([
                'title' => 'Data user tidak ditemukan!'
            ], 500);
        }
        else{
            $data = DB::connection($_SESSION['connection'])->table('tbmaster_useraccess_migrasi')
                ->join('tbmaster_access_migrasi','uac_acc_id','=','acc_id')
                ->select('uac_acc_id','acc_group')
                ->where('uac_userid','=',$request->userid)
                ->where('acc_status','=',0)
                ->get();

            $group = DB::connection($_SESSION['connection'])->table('tbmaster_access_migrasi')
                ->selectRaw('acc_group, count(1) total')
                ->where('acc_status','=',0)
                ->orderBy('acc_group')
                ->groupBy('acc_group')
                ->get();

            $checkedAll = [];

            for($i=0;$i<count($group);$i++){
                $total = 0;
                foreach($data as $d){
                    if($group[$i]->acc_group === $d->acc_group)
                        $total++;
                }
                if($group[$i]->total == $total)
                    $checkedAll[] = str_replace(' ','_',$group[$i]->acc_group);
            }

            return compact(['data','checkedAll']);
        }
    }

    public function save(Request $request){
        $temp = DB::connection($_SESSION['connection'])->table('tbmaster_user')
            ->where('userid','=',$request->userid)
            ->first();

        if(!$temp){
            return response()->json([
                'title' => 'Data user tidak ditemukan!'
            ], 500);
        }
        else{
            DB::connection($_SESSION['connection'])->table('tbmaster_useraccess_migrasi')
                ->where('uac_userid','=',$request->userid)
                ->delete();

            if($request->menu){
                foreach($request->menu as $m){
                    DB::connection($_SESSION['connection'])->table('tbmaster_useraccess_migrasi')
                        ->insert([
                            'uac_userid' => $request->userid,
                            'uac_acc_id' => $m,
                            'uac_create_by' => $_SESSION['usid'],
                            'uac_create_dt' => DB::RAW("SYSDATE")
                        ]);
                }
            }

            return response()->json([
                'title' => 'Data berhasil disimpan!'
            ], 200);
        }
    }

    public function clone(){
        dd('sudah otomatis, tidak perlu clone manual lagi :)');
    }

    public static function getListMenu($usid){
        if($usid == 'ADM'){
            return DB::connection($_SESSION['connection'])->table('tbmaster_access_migrasi')
                ->join('tbmaster_useraccess_migrasi','uac_acc_id','=','acc_id')
                ->selectRaw("acc_id, acc_group, acc_subgroup1, acc_subgroup2, acc_subgroup3, acc_name, acc_url")
                ->where('uac_userid','=',$usid)
                ->where('acc_status','=',0)
//            ->orderBy('acc_id')
                ->orderBy('acc_group')
                ->orderBy('acc_subgroup1')
                ->orderBy('acc_subgroup2')
                ->orderBy('acc_subgroup3')
                ->orderBy('acc_order')
                ->orderBy('acc_name')
                ->get();
        }
        else if(in_array($usid, ['DEV','SUP'])){
            return DB::connection($_SESSION['connection'])->table('tbmaster_access_migrasi')
                ->selectRaw("acc_id, acc_group, acc_subgroup1, acc_subgroup2, acc_subgroup3, acc_name, acc_url")
                ->orderBy('acc_group')
                ->orderBy('acc_subgroup1')
                ->orderBy('acc_subgroup2')
                ->orderBy('acc_subgroup3')
                ->orderBy('acc_order')
                ->orderBy('acc_name')
                ->get();
        }
        else{
            return DB::connection($_SESSION['connection'])->table('tbmaster_access_migrasi')
                ->join('tbmaster_useraccess_migrasi','uac_acc_id','=','acc_id')
                ->selectRaw("acc_id, acc_group, acc_subgroup1, acc_subgroup2, acc_subgroup3, acc_name, acc_url")
                ->where('uac_userid','=',$usid)
                ->where('acc_status','=',0)
                ->where('acc_group','<>','Administration')
//            ->orderBy('acc_id')
                ->orderBy('acc_group')
                ->orderBy('acc_subgroup1')
                ->orderBy('acc_subgroup2')
                ->orderBy('acc_subgroup3')
                ->orderBy('acc_order')
                ->orderBy('acc_name')
                ->get();
        }
    }
    public static function isAccessible($url){
        $hasAccess = false;

        if($url == '/')
            $hasAccess = true;

        foreach($_SESSION['menu'] as $m){
            if($m->acc_url == substr($url,0,strlen($m->acc_url))){
                if(strlen($m->acc_url) == strlen($url)){
                    self::insertMenuLog($m->acc_id);
                }
                $hasAccess = true;
                break;
            }
        }

        return $hasAccess;

//        $data = DB::connection($_SESSION['connection'])->table('tbmaster_access_migrasi')
//            ->join('tbmaster_useraccess_migrasi','uac_acc_id','=','acc_id')
//            ->where('uac_userid','=',$_SESSION['usid'])
//            ->where('acc_url','=',$url)
//            ->first();
//
//        return $data ? true : false;
    }

    public static function insertMenuLog($menu){
        try{
            DB::connection($_SESSION['connection'])->beginTransaction();

            $last = DB::connection($_SESSION['connection'])
                ->table('tblog_oracleform_migrasi')
                ->orderBy('lom_id','desc')
                ->first();

            $id = $last ? intval($last->lom_id) + 1 : 1;

            DB::connection($_SESSION['connection'])
                ->table('tblog_oracleform_migrasi')
                ->insert([
                    'lom_id' => $id,
                    'lom_kodeigr' => $_SESSION['kdigr'],
                    'lom_userid' => $_SESSION['usid'],
                    'lom_acc_id' => $menu,
                    'lom_accessdate' => Carbon::now()
                ]);

            DB::connection($_SESSION['connection'])->commit();
        }
        catch(\Exception $e){
            DB::connection($_SESSION['connection'])->rollBack();
        }
    }
}
