<?php

namespace App\Http\Controllers\MASTER;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class departementController extends Controller
{
    //

    public function index(){
        $divisi = DB::table('tbmaster_divisi')
            ->select('div_kodedivisi','div_namadivisi')
            ->orderBy('div_kodedivisi')
            ->get();

        $departement = DB::table('tbmaster_departement')
            ->select('dep_kodedepartement','dep_namadepartement','dep_singkatandepartement','dep_kodemanager','dep_kodesecurity','dep_kodesupervisor')
            ->where('dep_kodedivisi','1')
            ->orderBy('dep_kodedepartement')
            ->get();

        return view('MASTER.departement')->with(compact(['divisi', 'departement']));
    }

    public function divisi_select(Request $request){
        $departement = DB::table('tbmaster_departement')
            ->select('dep_kodedepartement','dep_namadepartement','dep_singkatandepartement','dep_kodemanager','dep_kodesecurity','dep_kodesupervisor')
            ->where('dep_kodedivisi',$request->value)
            ->orderBy('dep_kodedepartement')
            ->get();

        return $departement;
    }


}
