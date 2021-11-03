<?php

namespace App\Http\Controllers\BACKOFFICE\TRANSAKSI\PENERIMAAN;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class InqueryController extends Controller
{
    public function index(){
        return view('BACKOFFICE.TRANSAKSI.PENERIMAAN.inquery');
    }

    public function viewBTB(Request $request){
        $kodeigr = $_SESSION['kdigr'];
        $typeTrn    = $request->typeTrn;

        $data = DB::select("SELECT msth_nodoc, trunc(msth_tgldoc) as msth_tgldoc
                                    FROM tbtr_mstran_h
                                   WHERE     msth_kodeigr = '$kodeigr'
                                         AND msth_typetrn = '$typeTrn'
                                         AND NVL (msth_recordid, 9) <> 1
                                         and trunc(msth_tgldoc) between trunc(sysdate-5) and trunc(sysdate)
                                ORDER BY msth_tgldoc DESC");

        return DataTables::of($data)->make(true);
    }

    public function viewData(Request $request){
        $noDoc = $request->noDoc;
        $kodeigr = $_SESSION['kdigr'];
        $typeTrn    = $request->typeTrn;

        $data = DB::select("select mstd_nodoc, mstd_tgldoc, mstd_prdcd, mstd_nofaktur, mstd_tglfaktur,
			              mstd_cterm, mstd_discrph, mstd_dis4cr, mstd_ppnbmrph, mstd_ppnbtlrph, mstd_ppnrph,
			              prd_deskripsipanjang barang, mstd_unit||'/'||mstd_frac satuan, prd_frac,
										(nvl(mstd_qty,0) + nvl(mstd_qtybonus1,0)) qty,  mstd_hrgsatuan, mstd_gross, mstd_nopo, mstd_tglpo,
										sup_kodesupplier||' - '||sup_namasupplier || '/' || sup_singkatansupplier supplier, sup_pkp, sup_top,
										(((mstd_gross - nvl(mstd_discrph,0) +  nvl(mstd_ppnrph,0) + nvl(mstd_ppnbmrph,0) + nvl(mstd_ppnbtlrph,0)) * prd_frac)  / (nvl(mstd_qty,0) + nvl(mstd_qtybonus1,0)) ) as hpp,
										(mstd_gross - nvl(mstd_discrph,0) +  nvl(mstd_ppnrph,0) + nvl(mstd_ppnbmrph,0) + nvl(mstd_ppnbtlrph,0)) as ppntot
									from tbtr_mstran_d, tbmaster_prodmast, tbmaster_supplier
									where mstd_nodoc='$noDoc'
											and mstd_kodeigr= '$kodeigr'
											and mstd_typetrn = '$typeTrn'
											and prd_prdcd=mstd_prdcd
											and prd_kodeigr=mstd_kodeigr
											and sup_kodesupplier(+) = mstd_kodesupplier
											and sup_kodeigr(+)=mstd_kodeigr");

        return response()->json($data);
    }

    public function viewDetailPlu(Request $request){
        $noDoc = $request->noDoc;
        $kodeigr = $_SESSION['kdigr'];
        $typeTrn    = $request->typeTrn;
        $prdcd  = $request->prdcd;

        $data = DB::select("SELECT mstd_prdcd || ' - ' || prd_deskripsipanjang splu,
                                           mstd_unit || '/' || mstd_frac skemasan, mstd_hrgsatuan shrgbeli,
                                           FLOOR (mstd_qty / mstd_frac) sqty, mstd_unit sunit,
                                           MOD (mstd_qty, mstd_frac) sqtyk, mstd_frac frac, mstd_unit unit,
                                           mstd_discrph discrp, mstd_persendisc1 persendisc1, mstd_rphdisc1 rphdisc1,
                                           mstd_flagdisc1 satdisc1, mstd_persendisc4 persendisc4,
                                           mstd_rphdisc4 rphdisc4, mstd_flagdisc4 satdisc4,
                                           mstd_persendisc2 persendisc2, mstd_rphdisc2 rphdisc2,
                                           mstd_persendisc2ii persendisc2ii, mstd_rphdisc2ii rphdisc2ii,
                                           mstd_persendisc2iii persendisc2iii, mstd_rphdisc2iii rphdisc2iii,
                                           mstd_flagdisc2 satdisc2, mstd_persendisc3 persendisc3,
                                           mstd_rphdisc3 rphdisc3, mstd_flagdisc3 satdisc3, mstd_ppnrph ppn,
                                           mstd_ppnbmrph bm, mstd_ppnbtlrph btl, mstd_keterangan ket,
                                           mstd_qtybonus1 sbns1, mstd_qtybonus2 sbns2, mstd_gross rpbns,
                                           prd_kodetag stag, prd_flagbkp1 || '/' || prd_flagbkp2 sbkp,
                                           prd_flagbandrol sbandrol, prd_lastcost slcost,
                                           NVL (st_avgcost, 0) * CASE
                                               WHEN prd_unit = 'KG'
                                                   THEN 1
                                               ELSE prd_frac
                                           END sacost,
                                           (mstd_gross - mstd_discrph + mstd_ppnrph + mstd_ppnbmrph + mstd_ppnbtlrph) as namt
                                      FROM tbtr_mstran_d, tbmaster_prodmast, tbmaster_stock
                                     WHERE mstd_nodoc = '$noDoc'
                                       AND mstd_kodeigr = '$kodeigr'
                                       AND mstd_prdcd = '$prdcd'
                                       AND mstd_typetrn = '$typeTrn'
                                       AND prd_prdcd = mstd_prdcd
                                       AND prd_kodeigr = mstd_kodeigr
                                       AND st_prdcd = SUBSTR (prd_prdcd, 1, 6) || '0'
                                       AND st_kodeigr = prd_kodeigr
                                       AND st_lokasi = '01'");

        return response()->json($data);
    }

}

