<?php

namespace App\Http\Controllers\BACKOFFICE\TRANSAKSI\PENERIMAAN;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class pembatalanController extends Controller
{
    public function index(){
        return view('BACKOFFICE/TRANSAKSI/PENERIMAAN.pembatalan');
    }

    public function viewBTB(Request $request){
        $kodeigr = $_SESSION['kdigr'];
        $typeTrn    = $request->typeTrn;

        $data = DB::select("SELECT msth_nodoc, trunc(msth_tgldoc) as msth_tgldoc
                                    FROM tbtr_mstran_h
                                   WHERE     msth_kodeigr = '$kodeigr'
                                         AND msth_typetrn = '$typeTrn'
                                         AND nvl(msth_recordid,' ')<>'1'
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

    public function batalBPB(Request $request){
        $noDoc = $request->noDoc;
        $kodeigr = $_SESSION['kdigr'];
        $typeTrn    = $request->typeTrn;


        return response()->json($noDoc);
    }

}

