<?php

namespace App\Http\Controllers\BACKOFFICE;

use Dompdf\Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use PDF;

class CetakTolakanPBController extends Controller
{
    //

    public function index(){
        $divisi = DB::table('tbmaster_divisi')
            ->select('div_kodedivisi','div_namadivisi')
            ->where('div_kodeigr',$_SESSION['kdigr'])
            ->get();

        $departement = DB::table('tbmaster_departement')
            ->select('dep_kodedepartement','dep_namadepartement','dep_kodedivisi')
            ->where('dep_kodeigr',$_SESSION['kdigr'])
            ->orderBy('dep_kodedepartement')
            ->get();

        return view('BACKOFFICE.CetakTolakanPB')->with(compact(['divisi','departement']));
    }

    public function cek_divisi(Request $request){
        $cek = DB::table('tbmaster_divisi')
            ->where('div_kodeigr',$_SESSION['kdigr'])
            ->where('div_kodedivisi',$request->kodedivisi)
            ->get();

        if(count($cek) > 0)
            return 'true';
        else return 'false';
    }
}
