<?php

namespace App\Http\Controllers\INQUERY;

use Illuminate\Http\Request;
use App\Http\Controllers\Auth\loginController;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;


class inquerySuppProdController extends Controller
{
    public function index()
    {
//        $plu = DB::connection(Session::get('connection'))->table('tbmaster_prodmast')
//            ->select('prd_prdcd','prd_deskripsipanjang')
////            ->whereRaw('SUBSTR(prd_prdcd,7,1) = '0'')
//            ->orderBy('prd_prdcd')
//            ->limit(1000)
//            ->get();

        return view('INQUERY.inquerySuppProd');
    }

    public function suppProd(Request $request)
    {

        $kodeigr = Session::get('kdigr');
        $kodeplu = $request->kodeplu;

        $c = loginController::getConnectionProcedure();

        $s = oci_parse($c, "BEGIN  sp_inqsupprod(:kodeigr,:kodeplu,:value); END;");
        oci_bind_by_name($s, ':kodeigr',$kodeigr,100);
        oci_bind_by_name($s, ':kodeplu', $kodeplu,1000);
        oci_bind_by_name($s, ':value', $result,1000);
        oci_execute($s);

        $result = DB::connection(Session::get('connection'))->table('temp_inqsup a')
            ->join('tbmaster_prodmast b', 'b.prd_prdcd', '=', 'a.kodeplu' )
            ->select('b.prd_prdcd','b.prd_deskripsipanjang','a.kodesup','a.namasup', 'a.qty', 'a.nobpb', 'a.tglbpb', 'a.term', 'a.hpp' )
            ->where('b.prd_kodeigr', '=', $kodeigr)
            ->where('b.prd_prdcd', '=', $kodeplu)
            ->get()
            ->toArray();

        return response()->json(['kodeplu' => $kodeplu, 'data' => $result]);
    }

    public function showLOV(Request $request){

        $search = strtoupper($request->search);
        $kodeigr = Session::get('kdigr');

        $result = DB::connection(Session::get('connection'))->table('tbmaster_prodmast')
            ->select('prd_prdcd', 'prd_deskripsipanjang')
            ->where('prd_kodeigr', '=', $kodeigr)
            ->whereRaw("SUBSTR(PRD_PRDCD,7,1)='0'")
            ->whereRaw("(prd_deskripsipanjang LIKE '%". $search."%' or prd_prdcd LIKE '%". $search."%')")
            ->orderBy('prd_prdcd')
            ->limit(100)
            ->get();

        return response()->json($result);
    }
}
