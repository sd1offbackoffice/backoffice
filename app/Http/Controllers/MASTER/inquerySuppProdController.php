<?php

namespace App\Http\Controllers\MASTER;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;


class inquerySuppProdController extends Controller
{
    public function index()
    {
        return view('MASTER.inquerySuppProd');
    }

    public function suppProd(Request $request)
    {
        $kodeplu = $request->kodeplu;
//
//        $deskripsi = DB::table('tbmaster_prodmast')
//            ->select('prd_deskripsipanjang')
//            ->where('kodeigr','=','22')
//            ->where('kodeplu','=',$kodeplu)
//            ->get();

       // DB::table('tbmaster_prodmast')
//            ->leftJoin('temp_inqsup',function($join){
//                $join->on('prd_kodeigr', '=', 'kodeigr');
//            })
        
        $result = DB::table('temp_inqsup')
            ->select('kodesup','namasup','qty','nobpb', 'tglbpb', 'term', 'hpp')
           // ->join('temp_inqsup','kodeigr','=','prd_kodeigr')
            ->where('kodeigr','=','22')
            ->where('kodeplu','=',$kodeplu)
            ->get();

        return response()
            ->json(['kodeplu' => $kodeplu, 'data' => $result]);

    }
}
