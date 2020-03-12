<?php

namespace App\Http\Controllers\MASTER;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Psr\Log\NullLogger;


class inqueryProdSuppController extends Controller
{
    public function index()
    {
//        $supplier = DB::table('tbtr_mstran_d')
//            ->join('tbmaster_supplier', function ($join) {
//                $join->on('sup_kodeigr', '=', 'mstd_kodeigr')
//                    ->on('sup_kodesupplier', '=', 'mstd_kodesupplier');
//            })
//            ->selectRaw("NVL (COUNT (1), 0)")
//            ->get();
//
//        if($supplier==NULL) {
//            return 'not-found';
//        }else{

            $supplier = DB::table('tbmaster_supplier')
                ->select('sup_kodesupplier', 'sup_namasupplier')
                ->where('sup_kodeigr', '=', '22')
                ->orderBy('sup_kodesupplier')
                ->limit(100)
                ->get();

        return view('MASTER.inqueryProdSupp')->with(compact('supplier'));
    }

    public function prodSupp(Request $request)
    {
        $kodesupp = $request->kodesupp;

        $result = DB::table('tbtr_mstran_d')
            ->join('tbmaster_supplier', function ($join) {
                $join->on('sup_kodeigr', '=', 'mstd_kodeigr')
                    ->on('sup_kodesupplier', '=', 'mstd_kodesupplier');
            })
            ->join('tbmaster_prodmast', function ($join) {
                $join->on('prd_kodeigr', '=', 'mstd_kodeigr')
                    ->on('prd_prdcd', '=', 'mstd_prdcd');
            })
            ->join('tbmaster_stock', function ($join) {
                $join->on('st_kodeigr', '=', 'mstd_kodeigr')
                    ->on('st_prdcd', '=', 'mstd_prdcd');
            })
            ->join('tbmaster_kkpkm', function ($join) {
                $join->on('pkm_kodeigr', '=', 'mstd_kodeigr')
                    ->on('pkm_prdcd', '=', 'mstd_prdcd');
            })
            ->leftJoin('tbtr_gondola', function ($join) {
                $join->on('gdl_kodeigr', '=', 'mstd_kodeigr')
                    ->on('gdl_prdcd', '=', 'mstd_prdcd');
            })
            ->leftJoin('tbtr_pkmgondola', function ($join) {
                $join->on('pkmg_prdcd', '=', 'mstd_prdcd')
                    ->on('pkmg_kodeigr', '=', 'mstd_kodeigr');
            })
            ->selectRaw("mstd_prdcd, prd_deskripsipendek, st_sales, st_saldoakhir, pkm_pkmt, prd_lastcost, prd_kodetag,
          CASE WHEN (sysdate >= TRUNC(gdl_tglawal) - 2 AND sysdate <= TRUNC(gdl_tglawal) + 2) THEN
                   pkmg_nilaigondola
           ELSE
                  0
           END ngdl,
           CASE WHEN SUBSTR(prd_prdcd, 7, 1) <> '1'  AND prd_unit <> 'KG' THEN
                   prd_frac
           ELSE
                  1
           END nfrac,
          mstd_kodesupplier, sup_namasupplier")
            ->where('mstd_kodesupplier', '=', $kodesupp)
            ->where('st_lokasi', '=', '01')
            ->distinct()
            ->orderBy('mstd_prdcd')
            ->get();

        $count = $result->count();

        return response()
            ->json(['kodesupp' => strtoupper($kodesupp), 'data' => $result, 'count' => $count]);
    }

    public function helpSelect(Request $request)
    {
        $result = DB::table('tbmaster_supplier')
            ->select('*')
            ->where('sup_kodesupplier', $request->value)
            ->first();

        return response()->json($result);
    }
}
