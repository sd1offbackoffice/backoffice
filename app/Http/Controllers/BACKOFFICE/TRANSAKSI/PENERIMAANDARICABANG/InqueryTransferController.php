<?php

namespace App\Http\Controllers\BACKOFFICE\TRANSAKSI\PENERIMAANDARICABANG;

use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;
use PDF;
use Yajra\DataTables\DataTables;

class InqueryTransferController extends Controller
{
    public function index(){
        return view('BACKOFFICE.TRANSAKSI.PENERIMAANDARICABANG.inquery-transfer');
    }

    public function getDataLov(){
        $lov = DB::table('tbtr_mstran_h')
            ->selectRaw("msth_nodoc no, TO_CHAR(msth_tgldoc, 'DD/MM/YYYY') tgl")
            ->where('msth_typetrn','=','I')
            ->where('msth_kodeigr','=',$_SESSION['kdigr'])
            ->whereRaw("NVL(msth_recordid,0) <> 1")
            ->orderBy('msth_tgldoc','desc')
            ->get();

        return DataTables::of($lov)->make(true);
    }

    public function getData(Request $request){
        $nosj = $request->nosj;

//        $data = DB::select("select mstd_nodoc, TO_CHAR(mstd_tgldoc,'DD/MM/YYYY') mstd_tgldoc, mstd_prdcd, prd_deskripsipanjang, mstd_unit||'/'||mstd_frac satuan,
//										floor(mstd_qty/mstd_frac) qty, mod(mstd_qty, mstd_frac) qtyk, mstd_hrgsatuan, mstd_gross, mstd_nopo, TO_CHAR(mstd_tglpo,'DD/MM/YYYY') mstd_tglpo, mstd_loc2
//									from tbtr_mstran_d, tbmaster_prodmast
//									where mstd_nodoc='".$nosj."'
//											and mstd_kodeigr='".$_SESSION['kdigr']."'
//											and mstd_typetrn = 'I'
//											and prd_prdcd=mstd_prdcd
//											and prd_kodeigr=mstd_kodeigr");

        $data = DB::select("select mstd_nodoc, TO_CHAR(mstd_tgldoc,'DD/MM/YYYY') mstd_tgldoc, mstd_nopo, TO_CHAR(mstd_tglpo,'DD/MM/YYYY') mstd_tglpo, mstd_loc2,
                                    mstd_prdcd, prd_deskripsipanjang, mstd_unit||'/'||mstd_frac satuan, mstd_qty, prd_frac,
									prd_kodetag tag, prd_flagbandrol bandrol, mstd_bkp bkp,  case when st_lastcost is null or st_lastcost =0 then  prd_lastcost else st_lastcost * case when prd_unit='KG' then 1 else prd_frac end end lcost, 
									st_avgcost * case when prd_unit='KG' then 1 else prd_frac end acost,  nvl(st_saldoakhir,0) st_qty,
									mstd_hrgsatuan, floor(mstd_qty/mstd_frac) qty, mod(mstd_qty, mstd_frac) qtyk, mstd_gross, mstd_keterangan ket,
									mstd_noref3, mstd_tgref3, floor(st_saldoakhir/prd_frac) prs1, mod(st_saldoakhir,prd_frac) prs2 
							from tbtr_mstran_d, tbmaster_prodmast, tbmaster_stock
							where MSTD_NODOC = '".$nosj."'
									and mstd_kodeigr='".$_SESSION['kdigr']."'
									and mstd_typetrn='I'
									and prd_prdcd=mstd_prdcd
									and prd_kodeigr = mstd_kodeigr
									and st_prdcd = substr(prd_prdcd,1,6)||'0'
									and st_kodeigr=prd_kodeigr
									and st_lokasi='01'");

        return $data;
    }
}