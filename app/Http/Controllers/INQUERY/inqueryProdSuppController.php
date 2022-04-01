<?php

namespace App\Http\Controllers\INQUERY;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Psr\Log\NullLogger;


class inqueryProdSuppController extends Controller
{
    public function index()
    {
        return view('INQUERY.inqueryProdSupp');
    }

    public function prodSupp(Request $request)
    {
        $kodesupp = strtoupper($request->kodesupp);
        $kodeigr = Session::get('kdigr');

        $result = DB::connection(Session::get('connection'))->table('tbtr_mstran_d')
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
            ->where('mstd_kodeigr', '=', $kodeigr)
            ->where('st_lokasi', '=', '01')
            ->distinct()
            ->orderBy('mstd_prdcd')
            ->get();

            $count = $result->count();

            return response()->json(['kodesupp' => $kodesupp, 'data' => $result, 'count' => $count]);
    }

    public function suppLOV(Request $request)
    {
        $search = strtoupper($request->search);
        $kodeigr = Session::get('kdigr');

        $result = DB::connection(Session::get('connection'))->table('tbmaster_supplier')
            ->select('sup_kodesupplier', 'sup_namasupplier','sup_kodesuppliermcg')
            ->whereRaw("sup_kodesupplier LIKE '%". $search."%' or sup_namasupplier LIKE '%". $search."%' or sup_kodesuppliermcg LIKE '%". $search."%'")
            ->where('sup_kodeigr', '=', $kodeigr)
            ->orderBy('sup_kodesupplier')
            ->limit(100)
            ->get();

        return response()->json($result);
    }
}
