<?php

namespace App\Http\Controllers\BACKOFFICE\TRANSAKSI\BARANGHILANG;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class pembatalanNBHController extends Controller
{
    public function index(){
        $kodeigr = $_SESSION['kdigr'];

        $result = DB::table('tbtr_mstran_h')
            ->select('msth_nodoc', 'msth_tgldoc')
            ->where('msth_kodeigr','=',$kodeigr)
            ->where('msth_typetrn','=','H')
            ->whereRaw("nvl(msth_recordid,9)<>1")
            ->limit('100')
            ->get();

        return view('BACKOFFICE/TRANSAKSI/BARANGHILANG.pembatalanNBH', compact('result'));
    }

    public function lov_NBH(Request $request){

        $search = $request->search;
        $kodeigr = $_SESSION['kdigr'];

        $result = DB::table('tbtr_mstran_h')
            ->select('msth_nodoc', 'msth_tgldoc')
            ->where('msth_nodoc','=','%'.$search.'%')
            ->where('msth_kodeigr','=',$kodeigr)
            ->where('msth_typetrn','=','H')
            ->whereRaw("nvl(msth_recordid,9)<>1")
            ->limit('100')
            ->get();

        return response()->json($result);
    }

    public function showData(Request $request){

        $nonbh = $request->nonbh;
        $kodeigr = $_SESSION['kdigr'];

        $result = DB::select(" select mstd_prdcd, prd_deskripsipanjang barang, mstd_unit||'/'||mstd_frac satuan, 
											floor(mstd_qty/mstd_frac) qty, mod(mstd_qty, mstd_frac) qtyk, mstd_hrgsatuan, mstd_gross
									from tbtr_mstran_d, tbmaster_prodmast
									where mstd_nodoc = '$nonbh'
											and mstd_kodeigr = '$kodeigr'
											and mstd_typetrn = 'H'
											and prd_prdcd = mstd_prdcd
											and prd_kodeigr = mstd_kodeigr ");

        return response()->json($result);
    }

}
