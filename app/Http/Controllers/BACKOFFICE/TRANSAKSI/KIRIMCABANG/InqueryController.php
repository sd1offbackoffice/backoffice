<?php

namespace App\Http\Controllers\BACKOFFICE\TRANSAKSI\KIRIMCABANG;

use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller; use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;
use PDF;
use Yajra\DataTables\DataTables;

class InqueryController extends Controller
{
    public function index(){
        return view('BACKOFFICE.TRANSAKSI.KIRIMCABANG.inquery');
    }

    public function getDataLov(){
        $lov = DB::connection(Session::get('connection'))->table('tbtr_mstran_h')
            ->selectRaw("msth_nodoc no, TO_CHAR(msth_tgldoc, 'DD/MM/YYYY') tgl")
            ->where('msth_kodeigr',Session::get('kdigr'))
            ->whereRaw("nvl(msth_recordid,'9') <> '1'")
            ->where('msth_typetrn','=','O')
            ->orderBy('msth_nodoc','desc')
            ->get();

        return DataTables::of($lov)->make(true);
    }

    public function getData(Request $request){
//        select mstd_prdcd plu, prd_deskripsipanjang barang, mstd_unit||'/'||mstd_frac kemasan,
//										prd_kodetag tag, prd_flagbandrol bandrol, mstd_bkp bkp, prd_lastcost lastcost,
//										st_avgcost * case when prd_unit ='KG' then 1 else prd_frac end avgcost,
//										mstd_hrgsatuan hrgsat, floor(mstd_qty/prd_frac) qty, prd_unit unit, mod(mstd_qty,prd_frac) qtyk,
//										mstd_gross gross, nvl(mstd_discrph,0) discrph, mstd_ppnrph ppnrph, mstd_keterangan ket
//								from tbtr_mstran_d, tbmaster_prodmast, tbmaster_stock
//								where mstd_nodoc = :no_sj
//        and mstd_prdcd =plu
//        and mstd_kodeigr=:parameter.kodeigr
//        and mstd_typetrn = 'O'
//        and prd_prdcd=mstd_prdcd
//        and prd_kodeigr=mstd_kodeigr
//        and st_kodeigr(+)=prd_kodeigr
//        and st_prdcd(+)=prd_prdcd
//        and st_lokasi(+)='01'

        $data = DB::connection(Session::get('connection'))->select("select msth_nodoc, to_char(msth_tgldoc,'dd/mm/yyyy') msth_tgldoc, msth_istype, msth_invno, msth_noref3,msth_tgref3,
	                   mstd_nopo, mstd_tglpo, msth_loc,msth_loc2, msth_tglinv, mstd_unit||'/'||mstd_frac satuan,
	                   mstd_frac,mstd_prdcd, floor(mstd_qty/case when mstd_unit='KG' then 1 else mstd_frac end) mstd_qty,
	                   case when mstd_unit='KG' then 0 else mod(mstd_qty,mstd_frac) end mstd_qtyk, mstd_gross,
	                   mstd_ppnrph, mstd_discrph,((mstd_gross - nvl(mstd_discrph,0)) * mstd_frac) / (floor(mstd_qty/mstd_frac) * mstd_frac + mod(mstd_qty,mstd_frac))nPrice,
                        mstd_gross - nvl(mstd_discrph,0) nAmt, prd_deskripsipanjang,
                        sup_kodesupplier||'-'||sup_namasupplier supp, sup_pkp, cab_namacabang,
                        prd_kodetag tag, prd_flagbandrol bandrol, mstd_bkp bkp, prd_lastcost lastcost,
                        st_avgcost * case when prd_unit ='KG' then 1 else prd_frac end avgcost,
                        mstd_hrgsatuan hrgsat, floor(mstd_qty/prd_frac) qty, prd_unit unit, mod(mstd_qty,prd_frac) qtyk,
						mstd_gross gross, nvl(mstd_discrph,0) discrph, mstd_ppnrph ppnrph, mstd_keterangan ket
                from tbtr_mstran_h, tbtr_mstran_d, tbmaster_prodmast, tbmaster_supplier, tbmaster_cabang, tbmaster_stock
                where msth_kodeigr='".Session::get('kdigr')."'
                        and msth_typetrn='O'
                        and msth_nodoc='".$request->no."'
                        and mstd_nodoc=msth_nodoc
                        and mstd_kodeigr=msth_kodeigr
                        and prd_prdcd(+)=mstd_prdcd
                        and prd_kodeigr(+)=mstd_kodeigr
                        and sup_kodesupplier(+)=msth_kodesupplier
                        and sup_kodeigr(+)=msth_kodeigr
                        and cab_kodecabang = msth_loc
                        and st_kodeigr(+)=prd_kodeigr
                        and st_prdcd(+)=prd_prdcd
                        and st_lokasi(+)='01'
                order by mstd_seqno");

        return $data;
    }
}
