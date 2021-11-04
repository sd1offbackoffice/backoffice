<?php

namespace App\Http\Controllers\MASTER;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;


class inquerySuppProdController extends Controller
{
    public function index()
    {
        $plu = DB::connection($_SESSION['connection'])->table('tbmaster_prodmast')
            ->select('prd_prdcd','prd_deskripsipanjang')
            ->where(DB::RAW('SUBSTR(prd_prdcd,7,1)'),'=','0')
            ->orderBy('prd_prdcd')
            ->limit(1000)
            ->get();

        return view('MASTER.inquerySuppProd')->with(compact('plu'));
    }

    public function suppProd(Request $request)
    {
        $getKodeigr = DB::connection($_SESSION['connection'])->table('tbmaster_prodmast')->select('prd_kodeigr')->first();
        $kodeigr    = $getKodeigr->prd_kodeigr;
        $kodeplu = $request->kodeplu;

        $connection = loginController::getConnectionProcedure();

        $s = oci_parse($connection, "BEGIN  sp_inqsupprod(:kodeigr,:kodeplu,:value); END;");
        oci_bind_by_name($s, ':kodeigr',$kodeigr,100);
        oci_bind_by_name($s, ':kodeplu', $kodeplu,1000);
        oci_bind_by_name($s, ':value', $result,1000);
        oci_execute($s);

        $result = DB::connection($_SESSION['connection'])->table('temp_inqsup a')
            ->join('tbmaster_prodmast b', 'b.prd_prdcd', '=', 'a.kodeplu' )
            ->select('b.prd_prdcd','b.prd_deskripsipanjang','a.kodesup','a.namasup', 'a.qty', 'a.nobpb', 'a.tglbpb', 'a.term', 'a.hpp' )
            ->where('b.prd_kodeigr', '=', '22')
            ->where('b.prd_prdcd', '=', $kodeplu)
            ->get()->toArray();

        return response()
            ->json(['kodeplu' => $kodeplu, 'data' => $result]);
    }

    public function helpSelect(Request $request){
        $result = DB::connection($_SESSION['connection'])->table('tbmaster_prodmast')
            ->select('prd_prdcd','prd_deskripsipanjang')
            ->where('prd_prdcd',$request->value)
            ->first();

        if(!result)
            return not-found;
        else
            return response()->json($result);
    }
}
