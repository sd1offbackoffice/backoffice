<?php

namespace App\Http\Controllers\ADMINISTRATION;

use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller; use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;
use PDF;
use Yajra\DataTables\DataTables;

class DevController extends Controller
{
    public function index(){
        $group = DB::connection(Session::get('connection'))->table('tbmaster_access_migrasi')
            ->selectRaw('acc_group, count(1) total')
            ->orderBy('acc_group')
            ->groupBy('acc_group')
            ->get();

        $menu = DB::connection(Session::get('connection'))->table('tbmaster_access_migrasi')
            ->orderBy('acc_group')
            ->orderBy('acc_subgroup1')
            ->orderBy('acc_subgroup2')
            ->orderBy('acc_subgroup3')
            ->orderBy('acc_name')
            ->get();

        return view('ADMINISTRATION.dev')->with(compact(['group','menu']));
    }

    public function getData(){
        $data = DB::connection(Session::get('connection'))->table('tbmaster_access_migrasi')
            ->select('acc_id','acc_group')
            ->where('acc_status','=',0)
            ->get();

        $group = DB::connection(Session::get('connection'))->table('tbmaster_access_migrasi')
            ->selectRaw('acc_group, count(1) total')
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

    public function save(Request $request){
        try{
            DB::connection(Session::get('connection'))->beginTransaction();

            DB::connection(Session::get('connection'))->table('tbmaster_access_migrasi')
                ->update([
                    'acc_status' => 1,
                    'acc_modify_by' => Session::get('usid'),
                    'acc_modify_dt' => Carbon::now()
                ]);

            if($request->menu){
                foreach($request->menu as $m){
                    DB::connection(Session::get('connection'))->table('tbmaster_access_migrasi')
                        ->where('acc_id','=',$m)
                        ->update([
                            'acc_status' => 0,
                            'acc_modify_by' => Session::get('usid'),
                            'acc_modify_dt' => Carbon::now()
                        ]);
                }
            }

            DB::connection(Session::get('connection'))->commit();

            return response()->json([
                'title' => 'Data berhasil disimpan!',
            ], 200);
        }
        catch (\Exception $e){
            DB::connection(Session::get('connection'))->rollBack();

            return response()->json([
                'title' => 'Terjadi kesalahan!',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
