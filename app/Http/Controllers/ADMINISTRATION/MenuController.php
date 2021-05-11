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

class MenuController extends Controller
{
    public function index(){
//        $data = DB::table('tbmaster_access_migrasi')
//            ->orderBy('acc_group')
//            ->orderBy('acc_subgroup1')
//            ->orderBy('acc_subgroup2')
//            ->orderBy('acc_subgroup3')
//            ->orderBy('acc_name')
//            ->get();
//
//        $array = json_decode(json_encode($data), true);
//
//        DB::connection('igrsmg')
//            ->table('tbmaster_access_migrasi')
//            ->delete();
//
//        DB::connection('igrsmg')
//            ->table('tbmaster_access_migrasi')
//            ->insert($array);

//        $temp = '';
//        $i = 0;
//
//        foreach($data as $d){
//            $groups = explode(" ", $d->acc_group);
//            $acronym = "";
//
//            foreach ($groups as $g) {
//                $acronym .= $g[0];
//            }
//
//            if($temp != $acronym){
//                $temp = $acronym;
//                $i = 1;
//            }
//            else{
//                $i++;
//            }
//
//            $id = $acronym.substr(('000'.$i),-3);
//
//            DB::table('tbmaster_access_migrasi')
//                ->where('acc_group','=',$d->acc_group)
//                ->where('acc_subgroup1','=',$d->acc_subgroup1)
//                ->where('acc_subgroup2','=',$d->acc_subgroup2)
//                ->where('acc_subgroup3','=',$d->acc_subgroup3)
//                ->where('acc_name','=',$d->acc_name)
//                ->update([
//                    'acc_id' => $id
//                ]);
//        }

        return view('ADMINISTRATION.menu');
    }

    public function getData(){
        $data = DB::table('tbmaster_access_migrasi')
            ->selectRaw("acc_id, acc_group, acc_subgroup1, acc_subgroup2,
            acc_name, acc_url, acc_level, acc_create_by, to_char(acc_create_dt, 'dd/mm/yyyy hh24:mi:ss') acc_create_dt,
            acc_modify_by, to_char(acc_modify_dt, 'dd/mm/yyyy hh24:mi:ss') acc_modify_dt")
            ->orderBy('acc_id')
            ->orderBy('acc_group')
            ->orderBy('acc_subgroup1')
            ->orderBy('acc_subgroup2')
            ->orderBy('acc_subgroup3')
            ->orderBy('acc_name')
            ->get();

        return DataTables::of($data)->make(true);
    }

    public function add(Request $request){
        $temp = DB::table('tbmaster_access_migrasi')
            ->where('acc_group','=',$request->group)
            ->where('acc_subgroup1','=',$request->subgroup1)
            ->where('acc_subgroup2','=',$request->subgroup2)
            ->where('acc_subgroup3','=',$request->subgroup3)
            ->where('acc_name','=',$request->name)
            ->first();

        if(!$temp){
            $groups = explode(" ", $request->group);
            $acronym = "";

            foreach ($groups as $g) {
                $acronym .= $g[0];
            }


            $temp = DB::table('tbmaster_access_migrasi')
                ->whereRaw("acc_id like '".$acronym."%'")
                ->orderBy('acc_id','desc')
                ->first();


            if($temp){
                $i = intval(substr($temp->acc_id,-3));
            }
            else $i = 0;

            $id = $acronym.substr('000'.($i+1),-3);

            DB::table('tbmaster_access_migrasi')
                ->insert([
                    'acc_id' => $id,
                    'acc_group' => $request->group,
                    'acc_subgroup1' => $request->subgroup1,
                    'acc_subgroup2' => $request->subgroup2,
                    'acc_subgroup3' => $request->subgroup3,
                    'acc_name' => $request->name,
                    'acc_level' => $request->level,
                    'acc_url' => $request->url,
                    'acc_create_by' => $_SESSION['usid'],
                    'acc_create_dt' => DB::RAW("SYSDATE")
                ]);

            return response()->json([
                'title' => 'Data berhasil ditambahkan!'
            ], 200);
        }
        else{
            return response()->json([
                'title' => 'Data sudah ada!'
            ], 500);
        }
    }

    public function edit(Request $request){
        $temp = DB::table('tbmaster_access_migrasi')
            ->where('acc_id','=',$request->id)
            ->first();

        if($temp){
            DB::table('tbmaster_access_migrasi')
                ->where('acc_id','=',$request->id)
                ->update([
                    'acc_group' => $request->group,
                    'acc_subgroup1' => $request->subgroup1,
                    'acc_subgroup2' => $request->subgroup2,
                    'acc_subgroup3' => $request->subgroup3,
                    'acc_name' => $request->name,
                    'acc_level' => $request->level,
                    'acc_url' => $request->url,
                    'acc_modify_by' => $_SESSION['usid'],
                    'acc_modify_dt' => DB::RAW("SYSDATE")
                ]);

            return response()->json([
                'title' => 'Data berhasil diubah!'
            ], 200);
        }
        else{
            return response()->json([
                'title' => 'Data tidak ditemukan!'
            ], 500);
        }
    }

    public function delete(Request $request){
        $temp = DB::table('tbmaster_access_migrasi')
            ->where('acc_id','=',$request->id)
            ->first();

        if($temp){
            DB::table('tbmaster_access_migrasi')
                ->where('acc_id','=',$request->id)
                ->delete();

            return response()->json([
                'title' => 'Data berhasil dihapus!'
            ], 200);
        }
        else{
            return response()->json([
                'title' => 'Data tidak ditemukan!'
            ], 500);
        }
    }
}
