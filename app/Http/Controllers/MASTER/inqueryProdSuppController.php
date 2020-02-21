<?php

namespace App\Http\Controllers\MASTER;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;


class inqueryProdSuppController extends Controller
{
    public function index()
    {

        return view('MASTER.inqueryProdSupp');
    }

    public function prodSupp(Request $request){
        $kodesupp = $request->kodesupp;

        $result = DB::table('tbtr_mstran_d')
            ->join('tbmaster_supplier',function($join){
                $join->on('sup_kodeigr', '=', 'mstd_kodeigr')
                    ->on('sup_kodesupplier', '=', 'mstd_kodesupplier');
            })
            ->join('tbmaster_prodmast',function($join){
                $join->on('prd_kodeigr', '=', 'mstd_kodeigr')
                    ->on('prd_prdcd', '=', 'mstd_prdcd');
            })
            ->join('tbmaster_stock',function($join){
                $join->on('st_kodeigr', '=', 'mstd_kodeigr')
                    ->on('st_prdcd', '=', 'mstd_prdcd');
            })
            ->join('tbmaster_kkpkm',function($join){
                $join->on('pkm_kodeigr', '=' , 'mstd_kodeigr')
                    ->on('pkm_prdcd', '=', 'mstd_prdcd');
            })
            ->leftJoin('tbtr_gondola',function($join){
                $join->on('gdl_kodeigr', '=', 'mstd_kodeigr')
                    ->on('gdl_prdcd', '=', 'mstd_prdcd');
            })
            ->leftJoin('tbtr_pkmgondola',function($join){
                $join->on('pkmg_prdcd', '=', 'mstd_prdcd')
                    ->on('pkmg_kodeigr', '=', 'mstd_kodeigr');
            })
            ->SELECT("mstd_prdcd", "prd_deskripsipendek", "st_sales", "st_saldoakhir", "pkm_pkmt", "prd_lastcost", "prd_kodetag")
            ->where('mstd_kodesupplier','=',$kodesupp)
            ->where('st_lokasi','=','01')
            ->distinct()
            ->orderBy('mstd_prdcd')
            ->get();

//        dd($result);

        $count = $result->count();
//dd($count);
        return response()
            ->json(['kodesupp' => strtoupper($kodesupp), 'data' => $result, 'count'=>$count]);

//        return view('MASTER.inqueryProdSupp', compact('result', 'count'));
    }
}
