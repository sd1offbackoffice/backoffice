<?php

namespace App\Http\Controllers\BACKOFFICE\TRANSAKSI\PENYESUAIAN;

use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;
use PDF;
use Yajra\DataTables\DataTables;

class InqueryMPPController extends Controller
{
    public function index(){
        return view('BACKOFFICE.TRANSAKSI.PENYESUAIAN.inquerympp');
    }

    public function getDataLov(){
        $lov = DB::table('tbtr_mstran_h')
            ->selectRaw("msth_nodoc, TO_CHAR(msth_tgldoc,'DD/MM/YYYY') msth_tgldoc")
            ->where('msth_kodeigr',$_SESSION['kdigr'])
            ->where('msth_typetrn','X')
            ->whereRaw("NVL(msth_recordid,'0') <> '1'")
            ->orderBy('msth_nodoc','desc')
            ->get();

        return DataTables::of($lov)->make(true);
    }

    public function getData(Request $request){
        $nompp = $request->nompp;

        $data = DB::table('tbtr_mstran_h')
            ->join('tbtr_mstran_d','mstd_nodoc','=','msth_nodoc')
            ->join('tbmaster_prodmast','prd_prdcd','=','mstd_prdcd')
            ->selectRaw("mstd_tgldoc, mstd_nopo, mstd_tglpo, mstd_prdcd, prd_deskripsipanjang,
					prd_unit, mstd_qty, mstd_hrgsatuan, mstd_gross,
					msth_noref3, msth_tgref3")
            ->where('mstd_typetrn','X')
            ->where('msth_nodoc',$nompp)
            ->orderBy('mstd_prdcd')
            ->get();

        return $data;
    }

    public function getDetail(Request $request){
        $nompp = $request->nompp;
        $prdcd = $request->prdcd;

        $data = DB::select("select mstd_prdcd plu, prd_deskripsipanjang barang, mstd_unit||'/'||mstd_frac kemasan, 
										prd_kodetag tag, prd_flagbandrol bandrol, mstd_bkp bkp, prd_lastcost lastcost, 
										st_avgcost * case when prd_unit ='KG' then 1 else prd_frac end avgcost,
										mstd_hrgsatuan hrgsat, TRUNC(mstd_qty/prd_frac) qty, prd_unit unit, mod(mstd_qty,prd_frac) qtyk,
										mstd_gross gross, mstd_discrph discrph, mstd_ppnrph ppnrph, mstd_keterangan ket,
											CASE 
								  		WHEN PRD_UNIT = 'PCS' 
								  		THEN NVL(ST_SaldoAkhir,0) 
											ELSE  trunc(NVL(ST_SaldoAkhir,0) / NVL(PRD_FRAC,0)) 
											END as Persediaan,
										CASE 
								  		WHEN PRD_UNIT = 'PCS' 
								  		THEN 0
											ELSE MOD(NVL(ST_SaldoAkhir,0), PRD_FRAC) 
										END as Persediaan2,
											mstd_seqno
								from tbtr_mstran_d, tbmaster_prodmast, tbmaster_stock
								where mstd_nodoc = '".$nompp."'
								    and mstd_prdcd ='".$prdcd."'
								    and mstd_kodeigr='".$_SESSION['kdigr']."'
										and mstd_typetrn = 'X'
										and prd_prdcd=mstd_prdcd
										and prd_kodeigr=mstd_kodeigr
										and st_kodeigr(+)=prd_kodeigr
										and st_prdcd(+)=prd_prdcd
										and st_lokasi(+)='01'
								Order By mstd_seqno");

        return $data;
    }
}