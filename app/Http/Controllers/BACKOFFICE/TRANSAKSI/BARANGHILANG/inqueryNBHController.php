<?php

namespace App\Http\Controllers\BACKOFFICE\TRANSAKSI\BARANGHILANG;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller; use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class inqueryNBHController extends Controller
{
    public function index(){

        $kodeigr = Session::get('kdigr');

        $result = DB::connection(Session::get('connection'))->table('tbtr_mstran_h')
            ->select('msth_nodoc', 'msth_tgldoc')
            ->where('msth_typetrn','=','H')
            ->where('msth_kodeigr','=',$kodeigr)
            ->whereRaw('nvl(msth_recordid,0) <>1')
            ->limit(100)
            ->orderBy('msth_nodoc')
            ->get();

        return view('BACKOFFICE.TRANSAKSI.BARANGHILANG.inqueryNBH', compact('result'));
    }

    public function lov_NBH(Request $request){

        $search = $request->search;
        $kodeigr = Session::get('kdigr');

        $result = DB::connection(Session::get('connection'))->table('tbtr_mstran_h')
            ->select('msth_nodoc', 'msth_tgldoc')
            ->where('msth_typetrn','=','H')
            ->where('msth_kodeigr','=',$kodeigr)
            ->whereRaw('nvl(msth_recordid,0) <>1')
            ->whereRaw("msth_nodoc LIKE '%".$search."%'")
            ->limit(100)
            ->orderBy('msth_nodoc')
            ->get();

        return response()->json($result);

    }

    public function showDoc(Request $request){

        $kodeigr = Session::get('kdigr');
        $nonbh = $request->nonbh;

        $result = DB::connection(Session::get('connection'))->select("select mstd_nodoc, mstd_tgldoc, mstd_prdcd, prd_deskripsipanjang, mstd_unit, mstd_frac,
										mstd_qty, mstd_hrgsatuan, mstd_gross, mstd_nopo, mstd_tglpo
									from tbtr_mstran_d, tbmaster_prodmast
									where mstd_nodoc='$nonbh'
											and mstd_kodeigr='$kodeigr'
											and mstd_typetrn = 'H'
											and prd_prdcd=mstd_prdcd
											and prd_kodeigr=mstd_kodeigr");

        return response()->json($result);

    }

    public function detail_Plu(Request $request){

        $kodeigr = Session::get('kdigr');
        $nonbh = $request->nonbh;
        $plu    = $request->plu;

        $result = DB::connection(Session::get('connection'))->select("select mstd_prdcd plu, prd_deskripsipanjang barang, mstd_unit unit, mstd_frac frac,
									prd_kodetag tag, prd_flagbandrol bandrol, mstd_bkp bkp,
									st_lastcost*case when prd_unit='KG' then 1 else nvl(prd_frac,1) end lcost,
									nvl(st_avgcost,0) st_avgcost ,  nvl(st_saldoakhir,0) st_qty,
									mstd_hrgsatuan hrgsatuan, mstd_qty qty, mstd_gross gross, mstd_keterangan keter
							from tbtr_mstran_d, tbmaster_prodmast, tbmaster_stock
							where MSTD_NODOC = '$nonbh'
									and mstd_kodeigr='$kodeigr'
									and mstd_prdcd = '$plu'
									and prd_prdcd=mstd_prdcd
									and prd_kodeigr = mstd_kodeigr
									and st_prdcd = substr(prd_prdcd,1,6)||'0'
									and st_kodeigr=prd_kodeigr
									and st_lokasi='01'");

        if ($result){
            if($result[0]->unit == 'KG'){
                $tempAcost = $result[0]->st_avgcost * 1;
            } else {
                $tempAcost = $result[0]->st_avgcost * $result[0]->frac;
            }

            $tempQty    = floor( $result[0]->st_qty/ $result[0]->frac);
            $tempQtyk   = $result[0]->st_qty %  $result[0]->frac;

            $result[0]->tempAcost   = $tempAcost;
            $result[0]->tempQty     = $tempQty;
            $result[0]->tempQtyk    = $tempQtyk;
        }

        return response()->json($result);
    }


}
