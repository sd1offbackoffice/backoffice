<?php

namespace App\Http\Controllers\MASTER;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;


class inquerySuppProdController extends Controller
{
    public function index()
    {
        $plu = DB::table('tbmaster_prodmast')
            ->select('*')
            ->where('prd_kodeigr','=','22')
            ->orderBy('prd_prdcd')
            ->get();

        return view('MASTER.inquerySuppProd')->with(compact('plu'));
    }

    public function suppProd(Request $request)
    {
        $kodeplu = $request->kodeplu;

        $result = DB::table('tbmaster_prodmast')
            ->join('temp_inqsup', 'prd_prdcd','=','kodeplu')
            ->select('prd_deskripsipanjang','kodesup', 'namasup', 'qty', 'nobpb', 'tglbpb', 'term', 'hpp')
            ->where('prd_kodeigr','=','22')
            ->where('prd_prdcd','=',$kodeplu)
            ->get();

        return response()
            ->json(['kodeplu' => $kodeplu, 'data' => $result]);
    }

    public function helpSelect(Request $request){
        $result = DB::table('tbmaster_prodmast')
            ->select('prd_prdcd','prd_deskripsipanjang')
            ->where('prd_prdcd',$request->value)
            ->first();

        if(!result)
            return not-found;
        else
            return response()->json($result);

    }
}
