<?php
/**
 * Created by PhpStorm.
 * User: ryan
 * Date: 1/12/2021
 * Time: 3:25 PM
 */

namespace App\Http\Controllers\BACKOFFICE\LAPORAN;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use PDF;
use DateTime;
use Yajra\DataTables\DataTables;

class ServiceLevelItemParetoController extends Controller
{

    public function index()
    {
        return view('BACKOFFICE.LAPORAN.ServiceLevelItemPareto');
    }

    public function ModalNmr(Request $request)
    {

        $datas = DB::table('TBTR_MONITORINGPLU')
            ->selectRaw('distinct MPL_KODEMONITORING as MPL_KODEMONITORING')
            ->selectRaw('MPL_NAMAMONITORING')
            ->orderByDesc('MPL_KODEMONITORING')
            ->get();

        return Datatables::of($datas)->make(true);
    }

    public function getNmr(Request $request)
    {
        $search = $request->val;

        $datas = DB::table('TBTR_MONITORINGPLU')
            ->selectRaw('distinct MPL_KODEMONITORING as MPL_KODEMONITORING')
            ->selectRaw('MPL_NAMAMONITORING')
            ->where('MPL_KODEMONITORING','=', $search)
            ->orderByDesc('MPL_KODEMONITORING')
            ->first();

        return response()->json($datas);
    }

    public function CheckData(Request $request){
        $kodeigr = $_SESSION['kdigr'];
        $dateA = $request->dateA;
        $dateB = $request->dateB;
        $kmp = $request->kmp;
        $rad_order = $request->rad_order;
        $sDate = DateTime::createFromFormat('d-m-Y', $dateA)->format('d-m-Y');
        $eDate = DateTime::createFromFormat('d-m-Y', $dateB)->format('d-m-Y');
        $p_and = " AND NVL(PRD_FLAGBARANGORDERTOKO, 'N') = 'Y' ";

        if($kmp != 'zonk-zonk'){
            $temp = DB::table("TBTR_MONITORINGPLU")
                ->selectRaw("NVL (COUNT (1), 0) counter")
                ->where("MPL_KODEIGR",'=',$kodeigr)
                ->where("MPL_KODEMONITORING",'=',$kmp)
                ->first();
            if($temp->counter == 0){
                return response()->json(['kode' => 2]);
            }else{
                $p_and = " AND EXISTS ( SELECT 1 FROM TBTR_MONITORINGPLU WHERE MPL_KODEIGR = '".$kodeigr."' AND MPL_KODEMONITORING = '".$kmp."' AND MPL_PRDCD = TPOD_PRDCD) ";
            }
        }

        if($rad_order == "Supplier" || $kmp == 'zonk-zonk'){
            //SL_PARETO_BYSUP
            $cursor = DB::select("SELECT   case when '$kmp' = 'zonk-zonk' then ' ** SERVICE LEVEL ITEM BKL ** ' else ' ** SERVICE LEVEL ITEM PARETO ** ' end judul,
         TPOD_PRDCD, TPOH_KODESUPPLIER, SUM (TPOD_QTYPO) QTYPO, SUM (GROSS) GROSS, SUM (BM) BM,
         SUM (BTL) BTL, SUM (NILAIA) NILAIA, SUM (KUANB) KUANB, SUM (NILAIB) NILAIB,
         SUM (KUANA) KUANA, SUM (MSTD_QTYBONUS1) QTYBNS1, SUM (MSTD_QTYBONUS2) QTYBNS2,
         SUM (GROSSRP) GROSSRP, SUM (POTONGAN) POTONGAN, SUM (BMRP) BMRP, SUM (BTLRP) BTLRP,
         PRD_KODETAG, PRD_DESKRIPSIPANJANG, SUP_NAMASUPPLIER, PRS_NAMAPERUSAHAAN, PRS_NAMACABANG,
         PRS_NAMAWILAYAH, SUM(nvl(qty_PO_outs,0)) qty_PO_outs, SUM(nvl(rph_PO_outs,0)) rph_PO_outs
    FROM (SELECT TPOD_PRDCD, TPOH_KODESUPPLIER, (tpod_qtypo + nvl(tpod_bonuspo1, 0) + nvl(tpod_bonuspo2, 0))  TPOD_QTYPO, NVL (TPOD_GROSS, 0) GROSS,
                 NVL (TPOD_PPNBM, 0) BM, NVL (TPOD_PPNBOTOL, 0) BTL,
                 (  NVL (TPOD_GROSS, 0)
                  + NVL (TPOD_PPN, 0)
                  + NVL (TPOD_PPNBM, 0)
                  + NVL (TPOD_PPNBOTOL, 0)
                 ) NILAIA,
                 (NVL (MSTD_QTY, 0) + NVL (MSTD_QTYBONUS1, 0) + NVL (MSTD_QTYBONUS2, 0)) KUANB,
                 (  NVL (MSTD_GROSS, 0)
                  - NVL (MSTD_DISCRPH, 0)
                  + NVL (MSTD_PPNRPH, 0)
                  + NVL (MSTD_PPNBMRPH, 0)
                  + NVL (MSTD_PPNBTLRPH, 0)
                 ) NILAIB,
                 NVL (MSTD_QTY, 0) KUANA, MSTD_QTYBONUS1, MSTD_QTYBONUS2,
                 NVL (MSTD_GROSS, 0) GROSSRP, NVL (MSTD_DISCRPH, 0) POTONGAN,
                 NVL (MSTD_PPNBMRPH, 0) BMRP, NVL (MSTD_PPNBTLRPH, 0) BTLRP, PRD_DESKRIPSIPANJANG,
                 PRD_KODETAG, SUP_NAMASUPPLIER, PRS_NAMAPERUSAHAAN, PRS_NAMACABANG, PRS_NAMAWILAYAH,
                 CASE WHEN mstd_prdcd is null  and trunc(tpoh_tglpo + tpoh_jwpb) >= trunc(sysdate) THEN (tpod_qtypo + nvl(tpod_bonuspo1, 0) + nvl(tpod_bonuspo2, 0))  ELSE 0 END qty_PO_outs,
                 CASE WHEN mstd_prdcd is null  and trunc(tpoh_tglpo + tpoh_jwpb) >= trunc(sysdate) THEN
           (NVL(tpod_gross,0) + NVL(tpod_ppn,0) + NVL(tpod_ppnbm,0) + NVL(tpod_ppnbotol,0)) ELSE 0 END rph_PO_outs
            FROM TBTR_PO_D,
                 TBTR_PO_H,
                 TBTR_MSTRAN_D,
                 TBMASTER_PRODMAST,
                 TBMASTER_SUPPLIER,
                 TBMASTER_PERUSAHAAN
           WHERE TPOD_KODEIGR = '$kodeigr'
             AND TRUNC (TPOD_TGLPO) BETWEEN TO_DATE('$sDate','DD-MM-YYYY') AND TO_DATE('$eDate', 'DD-MM-YYYY')
             AND NVL (tpoh_recordid, '0') <> '1'
             AND tpoh_nopo = tpod_nopo
             AND trunc(tpoh_tglpo) = trunc(tpod_tglpo)
             AND MSTD_TYPETRN(+) = 'B'
             AND MSTD_KODEIGR(+) = TPOD_KODEIGR
             AND NVL (MSTD_RECORDID(+), '9') <> '1'
             AND MSTD_PRDCD(+) = TPOD_PRDCD
             AND MSTD_NOPO(+) = TPOD_NOPO
             AND MSTD_TGLPO(+) = TPOD_TGLPO
             AND PRD_KODEIGR(+) = TPOD_KODEIGR
             AND NVL (PRD_RECORDID(+), '9') <> '1'
             AND PRD_PRDCD(+) = TPOD_PRDCD
             AND TPOH_KODESUPPLIER = SUP_KODESUPPLIER(+)
             AND PRS_KODEIGR(+) = TPOD_KODEIGR
             $p_and)
GROUP BY TPOD_PRDCD,
         TPOH_KODESUPPLIER,
         PRD_KODETAG,
         PRD_DESKRIPSIPANJANG,
         SUP_NAMASUPPLIER,
         PRS_NAMAPERUSAHAAN,
         PRS_NAMACABANG,
         PRS_NAMAWILAYAH
ORDER BY TPOH_KODESUPPLIER, TPOD_PRDCD");
        }else{
            //SL_PARETO_BYDDK
            $cursor = DB::select("SELECT   TPOD_PRDCD, TPOD_KODEDIVISI, TPOD_KODEDEPARTEMEN, TPOD_KATEGORIBARANG, DIV_NAMADIVISI,
         DEP_NAMADEPARTEMENT, KAT_NAMAKATEGORI, SUM (TPOD_QTYPO) QTYPO, SUM (GROSS) GROSS,
         SUM (BM) BM, SUM (BTL) BTL, SUM (NILAIA) NILAIA, SUM (KUANB) KUANB, SUM (NILAIB) NILAIB,
         SUM (KUANA) KUANA, SUM (MSTD_QTYBONUS1) QTYBNS1, SUM (MSTD_QTYBONUS2) QTYBNS2,
         SUM (GROSSRP) GROSSRP, SUM (POTONGAN) POTONGAN, SUM (BMRP) BMRP, SUM (BTLRP) BTLRP,
         PRD_KODETAG, PRD_DESKRIPSIPANJANG, PRS_NAMAPERUSAHAAN, PRS_NAMACABANG, PRS_NAMAWILAYAH,
         SUM(nvl(qty_PO_outs,0)) qty_PO_outs, SUM(nvl(rph_PO_outs,0)) rph_PO_outs
    FROM (SELECT TPOD_PRDCD, TPOD_KODEDIVISI, TPOD_KODEDEPARTEMEN, TPOD_KATEGORIBARANG,
                 DIV_NAMADIVISI, DEP_NAMADEPARTEMENT, KAT_NAMAKATEGORI, (tpod_qtypo + nvl(tpod_bonuspo1, 0) + nvl(tpod_bonuspo2, 0)) tpod_qtypo,
                 NVL (TPOD_GROSS, 0) GROSS, NVL (TPOD_PPNBM, 0) BM, NVL (TPOD_PPNBOTOL, 0) BTL,
                 (  NVL (TPOD_GROSS, 0)
                  + NVL (TPOD_PPN, 0)
                  + NVL (TPOD_PPNBM, 0)
                  + NVL (TPOD_PPNBOTOL, 0)
                 ) NILAIA,
                 (NVL (MSTD_QTY, 0) + NVL (MSTD_QTYBONUS1, 0) + NVL (MSTD_QTYBONUS2, 0)) KUANB,
                 (  NVL (MSTD_GROSS, 0)
                  - NVL (MSTD_DISCRPH, 0)
                  + NVL (MSTD_PPNRPH, 0)
                  + NVL (MSTD_PPNBMRPH, 0)
                  + NVL (MSTD_PPNBTLRPH, 0)
                 ) NILAIB,
                 NVL (MSTD_QTY, 0) KUANA, MSTD_QTYBONUS1, MSTD_QTYBONUS2,
                 NVL (MSTD_GROSS, 0) GROSSRP, NVL (MSTD_DISCRPH, 0) POTONGAN,
                 NVL (MSTD_PPNBMRPH, 0) BMRP, NVL (MSTD_PPNBTLRPH, 0) BTLRP, PRD_DESKRIPSIPANJANG,
                 PRD_KODETAG, PRS_NAMAPERUSAHAAN, PRS_NAMACABANG, PRS_NAMAWILAYAH,
           CASE WHEN mstd_prdcd is null  and trunc(tpoh_tglpo + tpoh_jwpb) >= trunc(sysdate) THEN (tpod_qtypo + nvl(tpod_bonuspo1, 0) + nvl(tpod_bonuspo2, 0))  ELSE 0 END qty_PO_outs,
           CASE WHEN mstd_prdcd is null  and trunc(tpoh_tglpo + tpoh_jwpb) >= trunc(sysdate) THEN
           (NVL(tpod_gross,0) + NVL(tpod_ppn,0) + NVL(tpod_ppnbm,0) + NVL(tpod_ppnbotol,0)) ELSE 0 END rph_PO_outs
            FROM TBTR_PO_D,
                 TBTR_PO_H,
                 TBTR_MSTRAN_D,
                 TBMASTER_PRODMAST,
                 TBMASTER_PERUSAHAAN,
                 TBMASTER_DIVISI,
                 TBMASTER_DEPARTEMENT,
                 TBMASTER_KATEGORI
           WHERE TPOD_KODEIGR = '$kodeigr'
             AND TRUNC (TPOD_TGLPO) BETWEEN TO_DATE('$sDate','DD-MM-YYYY') AND TO_DATE('$eDate', 'DD-MM-YYYY')
             AND NVL (tpoh_recordid, '0') <> '1'
             AND tpoh_nopo = tpod_nopo
             AND trunc(tpoh_tglpo) = trunc(tpod_tglpo)
             AND MSTD_TYPETRN(+) = 'B'
             AND MSTD_KODEIGR(+) = TPOD_KODEIGR
             AND NVL (MSTD_RECORDID(+), '9') <> '1'
             AND MSTD_PRDCD(+) = TPOD_PRDCD
             AND MSTD_NOPO(+) = TPOD_NOPO
             AND MSTD_TGLPO(+) = TPOD_TGLPO
             AND PRD_KODEIGR(+) = TPOD_KODEIGR
             AND NVL (PRD_RECORDID(+), '9') <> '1'
             AND PRD_PRDCD(+) = TPOD_PRDCD
             AND DIV_KODEDIVISI(+) = TPOD_KODEDIVISI
             AND DIV_KODEIGR(+) = TPOD_KODEIGR
             AND DEP_KODEDIVISI(+) = TPOD_KODEDIVISI
             AND DEP_KODEDEPARTEMENT(+) = TPOD_KODEDEPARTEMEN
             AND DEP_KODEIGR(+) = TPOD_KODEIGR
             AND KAT_KODEDEPARTEMENT(+) = TPOD_KODEDEPARTEMEN
             AND KAT_KODEKATEGORI(+) = TPOD_KATEGORIBARANG
             AND KAT_KODEIGR(+) = TPOD_KODEIGR
             AND PRS_KODEIGR(+) = TPOD_KODEIGR
             AND EXISTS (
                     SELECT 1
                       FROM TBTR_MONITORINGPLU
                      WHERE MPL_KODEIGR = '$kodeigr'
                        AND MPL_KODEMONITORING = '$kmp'
                        AND MPL_PRDCD = TPOD_PRDCD))
GROUP BY TPOD_KODEDIVISI,
         TPOD_KODEDEPARTEMEN,
         TPOD_KATEGORIBARANG,
         TPOD_PRDCD,
         DIV_NAMADIVISI,
         DEP_NAMADEPARTEMENT,
         KAT_NAMAKATEGORI,
         PRD_KODETAG,
         PRD_DESKRIPSIPANJANG,
         PRS_NAMAPERUSAHAAN,
         PRS_NAMACABANG,
         PRS_NAMAWILAYAH
ORDER BY TPOD_KODEDIVISI, TPOD_KODEDEPARTEMEN, TPOD_KATEGORIBARANG, TPOD_PRDCD");
        }


        if(!$cursor){
            return response()->json(['kode' => 0]);
        }else{
            return response()->json(['kode' => 1]);
        }
    }

    public function printDocumentddk(Request $request){
        $kodeigr = $_SESSION['kdigr'];
        $dateA = $request->date1;
        $dateB = $request->date2;
        $today = date('d-m-Y');
        $time = date('H:i:s');
        $kmp = $request->kodemon;
        $sDate = DateTime::createFromFormat('d-m-Y', $dateA)->format('d-m-Y');
        $eDate = DateTime::createFromFormat('d-m-Y', $dateB)->format('d-m-Y');

        $mon = DB::table('TBTR_MONITORINGPLU')
            ->selectRaw('distinct MPL_KODEMONITORING as MPL_KODEMONITORING')
            ->selectRaw('MPL_NAMAMONITORING')
            ->where('MPL_KODEMONITORING','=', $kmp)
            ->orderByDesc('MPL_KODEMONITORING')
            ->first();
        $kdmon = $mon->mpl_kodemonitoring;
        $nmon =$mon->mpl_namamonitoring;

    $datas = DB::select("SELECT   TPOD_PRDCD, TPOD_KODEDIVISI, TPOD_KODEDEPARTEMEN, TPOD_KATEGORIBARANG, DIV_NAMADIVISI,
         DEP_NAMADEPARTEMENT, KAT_NAMAKATEGORI, SUM (TPOD_QTYPO) QTYPO, SUM (GROSS) GROSS,
         SUM (BM) BM, SUM (BTL) BTL, SUM (NILAIA) NILAIA, SUM (KUANB) KUANB, SUM (NILAIB) NILAIB,
         SUM (KUANA) KUANA, SUM (MSTD_QTYBONUS1) QTYBNS1, SUM (MSTD_QTYBONUS2) QTYBNS2,
         SUM (GROSSRP) GROSSRP, SUM (POTONGAN) POTONGAN, SUM (BMRP) BMRP, SUM (BTLRP) BTLRP,
         PRD_KODETAG, PRD_DESKRIPSIPANJANG, PRS_NAMAPERUSAHAAN, PRS_NAMACABANG, PRS_NAMAWILAYAH,
         SUM(nvl(qty_PO_outs,0)) qty_PO_outs, SUM(nvl(rph_PO_outs,0)) rph_PO_outs
    FROM (SELECT TPOD_PRDCD, TPOD_KODEDIVISI, TPOD_KODEDEPARTEMEN, TPOD_KATEGORIBARANG,
                 DIV_NAMADIVISI, DEP_NAMADEPARTEMENT, KAT_NAMAKATEGORI, (tpod_qtypo + nvl(tpod_bonuspo1, 0) + nvl(tpod_bonuspo2, 0)) tpod_qtypo,
                 NVL (TPOD_GROSS, 0) GROSS, NVL (TPOD_PPNBM, 0) BM, NVL (TPOD_PPNBOTOL, 0) BTL,
                 (  NVL (TPOD_GROSS, 0)
                  + NVL (TPOD_PPN, 0)
                  + NVL (TPOD_PPNBM, 0)
                  + NVL (TPOD_PPNBOTOL, 0)
                 ) NILAIA,
                 (NVL (MSTD_QTY, 0) + NVL (MSTD_QTYBONUS1, 0) + NVL (MSTD_QTYBONUS2, 0)) KUANB,
                 (  NVL (MSTD_GROSS, 0)
                  - NVL (MSTD_DISCRPH, 0)
                  + NVL (MSTD_PPNRPH, 0)
                  + NVL (MSTD_PPNBMRPH, 0)
                  + NVL (MSTD_PPNBTLRPH, 0)
                 ) NILAIB,
                 NVL (MSTD_QTY, 0) KUANA, MSTD_QTYBONUS1, MSTD_QTYBONUS2,
                 NVL (MSTD_GROSS, 0) GROSSRP, NVL (MSTD_DISCRPH, 0) POTONGAN,
                 NVL (MSTD_PPNBMRPH, 0) BMRP, NVL (MSTD_PPNBTLRPH, 0) BTLRP, PRD_DESKRIPSIPANJANG,
                 PRD_KODETAG, PRS_NAMAPERUSAHAAN, PRS_NAMACABANG, PRS_NAMAWILAYAH,
           CASE WHEN mstd_prdcd is null  and trunc(tpoh_tglpo + tpoh_jwpb) >= trunc(sysdate) THEN (tpod_qtypo + nvl(tpod_bonuspo1, 0) + nvl(tpod_bonuspo2, 0))  ELSE 0 END qty_PO_outs,
           CASE WHEN mstd_prdcd is null  and trunc(tpoh_tglpo + tpoh_jwpb) >= trunc(sysdate) THEN
           (NVL(tpod_gross,0) + NVL(tpod_ppn,0) + NVL(tpod_ppnbm,0) + NVL(tpod_ppnbotol,0)) ELSE 0 END rph_PO_outs
            FROM TBTR_PO_D,
                 TBTR_PO_H,
                 TBTR_MSTRAN_D,
                 TBMASTER_PRODMAST,
                 TBMASTER_PERUSAHAAN,
                 TBMASTER_DIVISI,
                 TBMASTER_DEPARTEMENT,
                 TBMASTER_KATEGORI
           WHERE TPOD_KODEIGR = '$kodeigr'
             AND TRUNC (TPOD_TGLPO) BETWEEN TO_DATE('$sDate','DD-MM-YYYY') AND TO_DATE('$eDate', 'DD-MM-YYYY')
             AND NVL (tpoh_recordid, '0') <> '1'
             AND tpoh_nopo = tpod_nopo
             AND trunc(tpoh_tglpo) = trunc(tpod_tglpo)
             AND MSTD_TYPETRN(+) = 'B'
             AND MSTD_KODEIGR(+) = TPOD_KODEIGR
             AND NVL (MSTD_RECORDID(+), '9') <> '1'
             AND MSTD_PRDCD(+) = TPOD_PRDCD
             AND MSTD_NOPO(+) = TPOD_NOPO
             AND MSTD_TGLPO(+) = TPOD_TGLPO
             AND PRD_KODEIGR(+) = TPOD_KODEIGR
             AND NVL (PRD_RECORDID(+), '9') <> '1'
             AND PRD_PRDCD(+) = TPOD_PRDCD
             AND DIV_KODEDIVISI(+) = TPOD_KODEDIVISI
             AND DIV_KODEIGR(+) = TPOD_KODEIGR
             AND DEP_KODEDIVISI(+) = TPOD_KODEDIVISI
             AND DEP_KODEDEPARTEMENT(+) = TPOD_KODEDEPARTEMEN
             AND DEP_KODEIGR(+) = TPOD_KODEIGR
             AND KAT_KODEDEPARTEMENT(+) = TPOD_KODEDEPARTEMEN
             AND KAT_KODEKATEGORI(+) = TPOD_KATEGORIBARANG
             AND KAT_KODEIGR(+) = TPOD_KODEIGR
             AND PRS_KODEIGR(+) = TPOD_KODEIGR
             AND EXISTS (
                     SELECT 1
                       FROM TBTR_MONITORINGPLU
                      WHERE MPL_KODEIGR = '$kodeigr'
                        AND MPL_KODEMONITORING = '$kmp'
                        AND MPL_PRDCD = TPOD_PRDCD))
GROUP BY TPOD_KODEDIVISI,
         TPOD_KODEDEPARTEMEN,
         TPOD_KATEGORIBARANG,
         TPOD_PRDCD,
         DIV_NAMADIVISI,
         DEP_NAMADEPARTEMENT,
         KAT_NAMAKATEGORI,
         PRD_KODETAG,
         PRD_DESKRIPSIPANJANG,
         PRS_NAMAPERUSAHAAN,
         PRS_NAMACABANG,
         PRS_NAMAWILAYAH
ORDER BY TPOD_KODEDIVISI, TPOD_KODEDEPARTEMEN, TPOD_KATEGORIBARANG, TPOD_PRDCD");

        //PRINT
        $pdf = PDF::loadview('BACKOFFICE.LAPORAN.ServiceLevelItemParetoDDK-pdf',
            ['kodeigr' => $kodeigr, 'date1' => $dateA, 'date2' => $dateB, 'datas' => $datas,'today' => $today, 'time' => $time, 'p_kdmon' => $kdmon, 'p_nmon'=> $nmon]);
        $pdf->setPaper('A4', 'potrait');
        $pdf->output();
        $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);

        $canvas = $dompdf ->get_canvas();
        $canvas->page_text(546, 10, "Hal {PAGE_NUM} / {PAGE_COUNT}", null, 8, array(0, 0, 0));

        return $pdf->stream('ServiceLevelItemParetoDDK.pdf');
    }

    public function printDocumentSupplier(Request $request){
        $kodeigr = $_SESSION['kdigr'];
        $dateA = $request->date1;
        $dateB = $request->date2;
        $kmp = $request->kodemon;
        $today = date('d-m-Y');
        $time = date('H:i:s');
        $p_and = " AND NVL(PRD_FLAGBARANGORDERTOKO, 'N') = 'Y' ";
        $kdmon = '';
        $nmon = '';
        $sDate = DateTime::createFromFormat('d-m-Y', $dateA)->format('d-m-Y');
        $eDate = DateTime::createFromFormat('d-m-Y', $dateB)->format('d-m-Y');

        if($kmp != 'zonk-zonk'){
            $mon = DB::table('TBTR_MONITORINGPLU')
                ->selectRaw('distinct MPL_KODEMONITORING as MPL_KODEMONITORING')
                ->selectRaw('MPL_NAMAMONITORING')
                ->where('MPL_KODEMONITORING','=', $kmp)
                ->orderByDesc('MPL_KODEMONITORING')
                ->first();
            $kdmon = $mon->mpl_kodemonitoring;
            $nmon = $mon->mpl_namamonitoring;

            $p_and = " AND EXISTS ( SELECT 1 FROM TBTR_MONITORINGPLU WHERE MPL_KODEIGR = '".$kodeigr."' AND MPL_KODEMONITORING = '".$kmp."' AND MPL_PRDCD = TPOD_PRDCD) ";

        }

        $datas = DB::select("SELECT   case when '$kmp' = 'zonk-zonk' then ' ** SERVICE LEVEL ITEM BKL ** ' else ' ** SERVICE LEVEL ITEM PARETO ** ' end judul,
         TPOD_PRDCD, TPOH_KODESUPPLIER, SUM (TPOD_QTYPO) QTYPO, SUM (GROSS) GROSS, SUM (BM) BM,
         SUM (BTL) BTL, SUM (NILAIA) NILAIA, SUM (KUANB) KUANB, SUM (NILAIB) NILAIB,
         SUM (KUANA) KUANA, SUM (MSTD_QTYBONUS1) QTYBNS1, SUM (MSTD_QTYBONUS2) QTYBNS2,
         SUM (GROSSRP) GROSSRP, SUM (POTONGAN) POTONGAN, SUM (BMRP) BMRP, SUM (BTLRP) BTLRP,
         PRD_KODETAG, PRD_DESKRIPSIPANJANG, SUP_NAMASUPPLIER, PRS_NAMAPERUSAHAAN, PRS_NAMACABANG,
         PRS_NAMAWILAYAH, SUM(nvl(qty_PO_outs,0)) qty_PO_outs, SUM(nvl(rph_PO_outs,0)) rph_PO_outs
    FROM (SELECT TPOD_PRDCD, TPOH_KODESUPPLIER, (tpod_qtypo + nvl(tpod_bonuspo1, 0) + nvl(tpod_bonuspo2, 0))  TPOD_QTYPO, NVL (TPOD_GROSS, 0) GROSS,
                 NVL (TPOD_PPNBM, 0) BM, NVL (TPOD_PPNBOTOL, 0) BTL,
                 (  NVL (TPOD_GROSS, 0)
                  + NVL (TPOD_PPN, 0)
                  + NVL (TPOD_PPNBM, 0)
                  + NVL (TPOD_PPNBOTOL, 0)
                 ) NILAIA,
                 (NVL (MSTD_QTY, 0) + NVL (MSTD_QTYBONUS1, 0) + NVL (MSTD_QTYBONUS2, 0)) KUANB,
                 (  NVL (MSTD_GROSS, 0)
                  - NVL (MSTD_DISCRPH, 0)
                  + NVL (MSTD_PPNRPH, 0)
                  + NVL (MSTD_PPNBMRPH, 0)
                  + NVL (MSTD_PPNBTLRPH, 0)
                 ) NILAIB,
                 NVL (MSTD_QTY, 0) KUANA, MSTD_QTYBONUS1, MSTD_QTYBONUS2,
                 NVL (MSTD_GROSS, 0) GROSSRP, NVL (MSTD_DISCRPH, 0) POTONGAN,
                 NVL (MSTD_PPNBMRPH, 0) BMRP, NVL (MSTD_PPNBTLRPH, 0) BTLRP, PRD_DESKRIPSIPANJANG,
                 PRD_KODETAG, SUP_NAMASUPPLIER, PRS_NAMAPERUSAHAAN, PRS_NAMACABANG, PRS_NAMAWILAYAH,
                 CASE WHEN mstd_prdcd is null  and trunc(tpoh_tglpo + tpoh_jwpb) >= trunc(sysdate) THEN (tpod_qtypo + nvl(tpod_bonuspo1, 0) + nvl(tpod_bonuspo2, 0))  ELSE 0 END qty_PO_outs,
                 CASE WHEN mstd_prdcd is null  and trunc(tpoh_tglpo + tpoh_jwpb) >= trunc(sysdate) THEN
           (NVL(tpod_gross,0) + NVL(tpod_ppn,0) + NVL(tpod_ppnbm,0) + NVL(tpod_ppnbotol,0)) ELSE 0 END rph_PO_outs
            FROM TBTR_PO_D,
                 TBTR_PO_H,
                 TBTR_MSTRAN_D,
                 TBMASTER_PRODMAST,
                 TBMASTER_SUPPLIER,
                 TBMASTER_PERUSAHAAN
           WHERE TPOD_KODEIGR = '$kodeigr'
             AND TRUNC (TPOD_TGLPO) BETWEEN TO_DATE('$sDate','DD-MM-YYYY') AND TO_DATE('$eDate', 'DD-MM-YYYY')
             AND NVL (tpoh_recordid, '0') <> '1'
             AND tpoh_nopo = tpod_nopo
             AND trunc(tpoh_tglpo) = trunc(tpod_tglpo)
             AND MSTD_TYPETRN(+) = 'B'
             AND MSTD_KODEIGR(+) = TPOD_KODEIGR
             AND NVL (MSTD_RECORDID(+), '9') <> '1'
             AND MSTD_PRDCD(+) = TPOD_PRDCD
             AND MSTD_NOPO(+) = TPOD_NOPO
             AND MSTD_TGLPO(+) = TPOD_TGLPO
             AND PRD_KODEIGR(+) = TPOD_KODEIGR
             AND NVL (PRD_RECORDID(+), '9') <> '1'
             AND PRD_PRDCD(+) = TPOD_PRDCD
             AND TPOH_KODESUPPLIER = SUP_KODESUPPLIER(+)
             AND PRS_KODEIGR(+) = TPOD_KODEIGR
             $p_and)
GROUP BY TPOD_PRDCD,
         TPOH_KODESUPPLIER,
         PRD_KODETAG,
         PRD_DESKRIPSIPANJANG,
         SUP_NAMASUPPLIER,
         PRS_NAMAPERUSAHAAN,
         PRS_NAMACABANG,
         PRS_NAMAWILAYAH
ORDER BY TPOH_KODESUPPLIER, TPOD_PRDCD");

        //PRINT
        $pdf = PDF::loadview('BACKOFFICE.LAPORAN.ServiceLevelItemParetoSupplier-pdf',
            ['kodeigr' => $kodeigr, 'date1' => $dateA, 'date2' => $dateB, 'datas' => $datas,'today' => $today, 'time' => $time, 'p_kdmon' => $kdmon, 'p_nmon'=> $nmon]);
        $pdf->setPaper('A4', 'potrait');
        $pdf->output();
        $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);

        $canvas = $dompdf ->get_canvas();
        $canvas->page_text(546, 10, "Hal {PAGE_NUM} / {PAGE_COUNT}", null, 8, array(0, 0, 0));

        return $pdf->stream('ServiceLevelItemParetoSupplier.pdf');
    }
}
