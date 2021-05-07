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
//        $data = DB::table('tbmaster_access_migrasi')
//            ->orderBy('acc_group')
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

        return view('ADMINISTRATION.access');
    }

    public function getData(){
        $data = DB::table('tbmaster_access_migrasi')
            ->orderBy('acc_group')
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
            DB::table('tbmaster_access_migrasi')
                ->insert([
                    'acc_group' => $request->group,
                    'acc_subgroup1' => $request->subgroup1,
                    'acc_subgroup2' => $request->subgroup2,
                    'acc_subgroup3' => $request->subgroup3,
                    'acc_name' => $request->name,
                    'acc_level' => $request->level,
                    'acc_url' => $request->url
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
            ->where('acc_group','=',$request->oldgroup)
            ->where('acc_subgroup1','=',$request->oldsubgroup1)
            ->where('acc_subgroup2','=',$request->oldsubgroup2)
            ->where('acc_subgroup3','=',$request->oldsubgroup3)
            ->where('acc_name','=',$request->oldname)
            ->first();

        if($temp){
            DB::table('tbmaster_access_migrasi')
                ->where('acc_group','=',$request->oldgroup)
                ->where('acc_subgroup1','=',$request->oldsubgroup1)
                ->where('acc_subgroup2','=',$request->oldsubgroup2)
                ->where('acc_subgroup3','=',$request->oldsubgroup3)
                ->where('acc_name','=',$request->oldname)
                ->update([
                    'acc_group' => $request->group,
                    'acc_subgroup1' => $request->subgroup1,
                    'acc_subgroup2' => $request->subgroup2,
                    'acc_subgroup3' => $request->subgroup3,
                    'acc_name' => $request->name,
                    'acc_level' => $request->level,
                    'acc_url' => $request->url
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
            ->where('acc_group','=',$request->group)
            ->where('acc_subgroup1','=',$request->subgroup1)
            ->where('acc_subgroup2','=',$request->subgroup2)
            ->where('acc_subgroup3','=',$request->subgroup3)
            ->where('acc_name','=',$request->name)
            ->first();

        if($temp){
            DB::table('tbmaster_access_migrasi')
                ->where('acc_group','=',$request->group)
                ->where('acc_subgroup1','=',$request->subgroup1)
                ->where('acc_subgroup2','=',$request->subgroup2)
                ->where('acc_subgroup3','=',$request->subgroup3)
                ->where('acc_name','=',$request->name)
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
