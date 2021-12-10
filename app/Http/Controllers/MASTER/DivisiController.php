<?php

namespace App\Http\Controllers\MASTER;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller; use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class DivisiController extends Controller
{
    //

    public function index(){
        $divisi = DB::connection(Session::get('connection'))->table('tbmaster_divisi')
            ->select('div_kodedivisi','div_namadivisi','div_divisimanager','div_singkatannamadivisi')
            ->orderBy('div_kodedivisi')
            ->get();

        return view('MASTER.divisi')->with(compact('divisi'));
    }

    public function divisi_select(Request $request){
        $departement = DB::connection(Session::get('connection'))->table('tbmaster_departement')
            ->select('dep_kodedepartement','dep_namadepartement','dep_singkatandepartement','dep_kodemanager','dep_kodesecurity','dep_kodesupervisor')
            ->where('dep_kodedivisi',$request->value)
            ->orderBy('dep_kodedepartement')
            ->get();

        return $departement;
    }


}
