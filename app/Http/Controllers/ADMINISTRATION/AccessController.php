<?php

namespace App\Http\Controllers\ADMINISTRATION;

use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;
use PDF;
use Yajra\DataTables\DataTables;

class AccessController extends Controller
{
    public function index(){
        $group = DB::connection(Session::get('connection'))->table('tbmaster_access_migrasi')
            ->selectRaw('acc_group, count(1) total')
            ->where('acc_status','=',0)
            ->where('acc_group','<>','Administration')
            ->orderBy('acc_group')
            ->groupBy('acc_group')
            ->get();

        $menu = DB::connection(Session::get('connection'))->table('tbmaster_access_migrasi')
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
        $data = DB::connection(Session::get('connection'))->table('tbmaster_user')
            ->whereRaw("recordid is null")
            ->orderBy('userid')
            ->get();

        return DataTables::of($data)->make(true);
    }

    public function getData(Request $request){
        $temp = DB::connection(Session::get('connection'))->table('tbmaster_user')
            ->where('userid','=',$request->userid)
            ->first();

        if(!$temp){
            return response()->json([
                'title' => 'Data user tidak ditemukan!'
            ], 500);
        }
        else{
            $data = DB::connection(Session::get('connection'))->table('tbmaster_useraccess_migrasi')
                ->join('tbmaster_access_migrasi','uac_acc_id','=','acc_id')
                ->select('uac_acc_id','acc_group')
                ->where('uac_userid','=',$request->userid)
                ->where('acc_status','=',0)
                ->get();

            $group = DB::connection(Session::get('connection'))->table('tbmaster_access_migrasi')
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
        try{
            DB::connection(Session::get('connection'))->beginTransaction();

            $temp = DB::connection(Session::get('connection'))->table('tbmaster_user')
                ->where('userid','=',$request->userid)
                ->first();

            if(!$temp){
                return response()->json([
                    'title' => 'Data user tidak ditemukan!'
                ], 500);
            }
            else{
                DB::connection(Session::get('connection'))->table('tbmaster_useraccess_migrasi')
                    ->where('uac_userid','=',$request->userid)
                    ->delete();

                if($request->menu){
                    foreach($request->menu as $m){
                        DB::connection(Session::get('connection'))->table('tbmaster_useraccess_migrasi')
                            ->insert([
                                'uac_userid' => $request->userid,
                                'uac_acc_id' => $m,
                                'uac_create_by' => Session::get('usid'),
                                'uac_create_dt' => Carbon::now()
                            ]);
                    }
                }

                DB::connection(Session::get('connection'))->commit();

                return response()->json([
                    'title' => 'Data berhasil disimpan!'
                ], 200);
            }
        }
        catch(\Exception $e){
            DB::connection(Session::get('connection'))->rollBack();

            return response()->json([
                'title' => 'Terjadi kesalahan!',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function clone(){
        dd('sudah otomatis, tidak perlu clone manual lagi :)');
    }

    public static function getListMenu(){
        $table = Schema::connection(Session::get('connection'))
            ->hasTable('tbmaster_access_migrasi');

        if(!$table){
            self::createBaseTable();
        }

        $menu = DB::connection(Session::get('connection'))
            ->table('tbmaster_access_migrasi')
            ->first();

        if(!$menu){
            self::insertBaseMenu();
        }

        if(in_array(Session::get('usid'), ['ADM','DEV','SUP','DV1','DV2','DV3','SP1','SP2','SP3','JEF'])){
//        if(Session::get('usid') == 'ADM' || Session::get('usid') == 'JEF'){
//            $listMenu = DB::connection(Session::get('connection'))->table('tbmaster_access_migrasi')
//                ->join('tbmaster_useraccess_migrasi','uac_acc_id','=','acc_id')
//                ->selectRaw("acc_id, acc_group, acc_subgroup1, acc_subgroup2, acc_subgroup3, acc_name, acc_url")
//                ->where('uac_userid','=',Session::get('usid'))
//                ->where('acc_status','=',0)
////            ->orderBy('acc_id')
//                ->orderBy('acc_group')
//                ->orderBy('acc_subgroup1')
//                ->orderBy('acc_subgroup2')
//                ->orderBy('acc_subgroup3')
//                ->orderBy('acc_order')
//                ->orderBy('acc_name')
//                ->get();
            $listMenu = DB::connection(Session::get('connection'))->table('tbmaster_access_migrasi')
                ->selectRaw("acc_id, acc_group, acc_subgroup1, acc_subgroup2, acc_subgroup3, acc_name, acc_url")
                ->where('acc_status','=',0)
                ->orderBy('acc_group')
                ->orderBy('acc_subgroup1')
                ->orderBy('acc_subgroup2')
                ->orderBy('acc_subgroup3')
                ->orderBy('acc_order')
                ->orderBy('acc_name')
                ->get();
        }
        else if(in_array(Session::get('usid'), ['DEV','SUP','DV1','DV2','DV3','DV4','DV5','DV6'])){
            $listMenu = DB::connection(Session::get('connection'))->table('tbmaster_access_migrasi')
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
            $listMenu = DB::connection(Session::get('connection'))->table('tbmaster_access_migrasi')
                ->join('tbmaster_useraccess_migrasi','uac_acc_id','=','acc_id')
                ->selectRaw("acc_id, acc_group, acc_subgroup1, acc_subgroup2, acc_subgroup3, acc_name, acc_url")
                ->where('uac_userid','=',Session::get('usid'))
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

        return $listMenu;
    }

    public static function createBaseTable(){
        Schema::connection(Session::get('connection'))
            ->create('tbmaster_access_migrasi', function($table)
            {
                $table->string('acc_group',50);
                $table->string('acc_subgroup1',50)->nullable();
                $table->string('acc_subgroup2',50)->nullable();
                $table->string('acc_subgroup3',50)->nullable();
                $table->string('acc_name',75);
                $table->integer('acc_level');
                $table->string('acc_url',255);
                $table->string('acc_id',10);
                $table->string('acc_create_by',3);
                $table->dateTime('acc_create_dt');
                $table->string('acc_modify_by',3)->nullable();
                $table->dateTime('acc_modify_dt')->nullable();
                $table->string('acc_status',1);
                $table->integer('acc_order')->nullable();
            });

        Schema::connection(Session::get('connection'))
            ->create('tbmaster_useraccess_migrasi', function($table)
            {
                $table->string('uac_userid',3);
                $table->string('uac_acc_id',10);
                $table->string('uac_create',1)->nullable();
                $table->string('uac_read',1)->nullable();
                $table->string('uac_update',1)->nullable();
                $table->string('uac_delete',1)->nullable();
                $table->string('uac_create_by',3);
                $table->dateTime('uac_create_dt');
                $table->string('uac_modify_by',3)->nullable();
                $table->dateTime('uac_modify_dt')->nullable();
            });
    }

    public static function insertBaseMenu(){
        DB::connection(Session::get('connection'))
            ->table('tbmaster_access_migrasi')
            ->insert([
                'acc_group' => 'Administration',
                'acc_subgroup1' => null,
                'acc_subgroup2' => null,
                'acc_subgroup3' => null,
                'acc_name' => 'Access Menu',
                'acc_level' => 2,
                'acc_url' => '/administration/menu',
                'acc_id' => 'A000',
                'acc_create_by' => 'DEV',
                'acc_create_dt' => Carbon::now(),
                'acc_status' => 0,
                'acc_order' => null
            ]);

        DB::connection(Session::get('connection'))
            ->table('tbmaster_access_migrasi')
            ->insert([
                'acc_group' => 'Administration',
                'acc_subgroup1' => null,
                'acc_subgroup2' => null,
                'acc_subgroup3' => null,
                'acc_name' => 'User',
                'acc_level' => 2,
                'acc_url' => '/administration/user',
                'acc_id' => 'A001',
                'acc_create_by' => 'DEV',
                'acc_create_dt' => Carbon::now(),
                'acc_status' => 0,
                'acc_order' => null
            ]);

        DB::connection(Session::get('connection'))
            ->table('tbmaster_access_migrasi')
            ->insert([
                'acc_group' => 'Administration',
                'acc_subgroup1' => null,
                'acc_subgroup2' => null,
                'acc_subgroup3' => null,
                'acc_name' => 'User Access',
                'acc_level' => 2,
                'acc_url' => '/administration/access',
                'acc_id' => 'A002',
                'acc_create_by' => 'DEV',
                'acc_create_dt' => Carbon::now(),
                'acc_status' => 0,
                'acc_order' => null
            ]);

        DB::connection(Session::get('connection'))
            ->table('tbmaster_access_migrasi')
            ->insert([
                'acc_group' => 'Administration',
                'acc_subgroup1' => null,
                'acc_subgroup2' => null,
                'acc_subgroup3' => null,
                'acc_name' => 'Show / Hide Menu',
                'acc_level' => 2,
                'acc_url' => '/administration/dev',
                'acc_id' => 'A003',
                'acc_create_by' => 'DEV',
                'acc_create_dt' => Carbon::now(),
                'acc_status' => 0,
                'acc_order' => null
            ]);
    }

    public static function isAccessible($url){
        $hasAccess = false;

        if($url == '/')
            $hasAccess = true;

        foreach(Session::get('menu') as $m){
            if($m->acc_url == substr($url,0,strlen($m->acc_url))){
                if(strlen($m->acc_url) == strlen($url)){
                    self::insertMenuLog($m->acc_id);
                }
                $hasAccess = true;
                break;
            }
        }

        return $hasAccess;

//        $data = DB::connection(Session::get('connection'))->table('tbmaster_access_migrasi')
//            ->join('tbmaster_useraccess_migrasi','uac_acc_id','=','acc_id')
//            ->where('uac_userid','=',Session::get('usid'))
//            ->where('acc_url','=',$url)
//            ->first();
//
//        return $data ? true : false;
    }

    public static function insertMenuLog($menu){
        try{
            DB::connection(Session::get('connection'))->beginTransaction();

            $last = DB::connection(Session::get('connection'))
                ->table('tblog_oracleform_migrasi')
                ->orderBy('lom_id','desc')
                ->first();

            $id = $last ? intval($last->lom_id) + 1 : 1;

            DB::connection(Session::get('connection'))
                ->table('tblog_oracleform_migrasi')
                ->insert([
                    'lom_id' => $id,
                    'lom_kodeigr' => Session::get('kdigr'),
                    'lom_userid' => Session::get('usid'),
                    'lom_acc_id' => $menu,
                    'lom_accessdate' => Carbon::now()
                ]);

            DB::connection(Session::get('connection'))->commit();
        }
        catch(\Exception $e){
            DB::connection(Session::get('connection'))->rollBack();
        }
    }

    public function cloneMenu(Request $request){
        $source = $request->source;
        $target = $request->target;

        DB::connection($target)
            ->table('tbmaster_access_migrasi')
            ->delete();

        $menu = DB::connection($source)
            ->table('tbmaster_access_migrasi')
            ->get();

        $menu = json_decode(json_encode($menu), true);

        DB::connection($target)
            ->table('tbmaster_access_migrasi')
            ->insert($menu);

        dd('Berhasil clone menu dari '.$source.' ke '.$target);
    }
}
