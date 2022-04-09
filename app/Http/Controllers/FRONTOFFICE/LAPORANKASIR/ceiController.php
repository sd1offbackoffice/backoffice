<?php


namespace App\Http\Controllers\FRONTOFFICE\LAPORANKASIR;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
// use PDF;
use DateTime;

class ceiController extends Controller
{
    /**
     * Created by PhpStorm.
     * User: ryan
     * Date: 1/12/2021
     * Time: 3:25 PM
     */
    public function index()
    {
        return view('FRONTOFFICE.LAPORANKASIR.cei');
    }

    public function getNmr(Request $request)
    {
        $search = $request->val;
        $kodeigr = Session::get('kdigr');

        $datas = DB::connection(Session::get('connection'))->table('tbmaster_supplier')
            ->selectRaw('distinct sup_kodesupplier as sup_kodesupplier')
            ->selectRaw('sup_namasupplier')
            ->where('sup_kodesupplier','LIKE', '%'.$search.'%')
            ->where('sup_kodeigr','=',$kodeigr)
            ->orderBy('sup_namasupplier')
            ->limit(100)
            ->get();

        return response()->json($datas);
    }

    public function CheckData(Request $request){
        $kodeigr = Session::get('kdigr');
        $dateA = $request->dateA;
        $dateB = $request->dateB;
        $sDate = DateTime::createFromFormat('d-m-Y', $dateA)->format('d-m-Y');
        $eDate = DateTime::createFromFormat('d-m-Y', $dateB)->format('d-m-Y');
        $event1 = $request->event1;
        $event2 = $request->event2;
        if($event1 == "nodata"){
            $event1 = '';
        }
        if($event2 == "nodata"){
            $event2 = '';
        }
        $and_even = "";
        if($event1 != '' && $event2 != ''){
            $and_even = " and dtl.kd_promosi between '".$event1."' and '".$event2."'";
        }
        $cursor = DB::connection(Session::get('connection'))->select("SELECT A.PLU, A.CBH_KODEPROMOSI,A.CBH_NAMAPROMOSI, A.CBH_KODEPERJANJIAN, A.CBH_TGLAWAL,
         A.CBH_TGLAKHIR, SUM(A.qtyref) qtyref, SUM(A.qtysls) qtysls, SUM(A.nilref) nilref,
         SUM(A.nilsls) nilsls, PRD_DESKRIPSIPANJANG, SUP_KODESUPPLIER, SUP_NAMASUPPLIER,
         PRS_NAMAPERUSAHAAN, PRS_NAMACABANG, PRS_NAMAWILAYAH
  FROM (SELECT  '1111111' PLU, CBH_KODEPROMOSI, CBH_NAMAPROMOSI, CBH_KODEPERJANJIAN,
                 CBH_TGLAWAL, CBH_TGLAKHIR,
	 CASE WHEN H.TIPE = 'R' THEN
         	       H.KELIPATAN
	 END QTYREF,
	 CASE WHEN H.TIPE = 'S' THEN
                       H.KELIPATAN
                 END QTYSLS,
        	 CASE WHEN H.TIPE = 'R' THEN
                       H.CASHBACK
	 END NILREF,
        	 CASE WHEN H.TIPE = 'S' THEN
                       H.CASHBACK
                 END NILSLS
            FROM M_PROMOSI_H H, TBTR_CASHBACK_HDR HDR
           WHERE H.KD_IGR = '$kodeigr'
	 AND trunc(H.TGL_TRANS) BETWEEN TO_DATE('$sDate','DD-MM-YYYY') AND TO_DATE('$eDate', 'DD-MM-YYYY')
	 AND H.KD_PROMOSI = HDR.CBH_KODEPROMOSI
	 AND CBH_JENISPROMOSI IN ('1', '2', '6')
        UNION ALL
            SELECT SUBSTR(DTL.KD_PLU,1,6)||'1' PLU,
	 CBH_KODEPROMOSI, CBH_NAMAPROMOSI, CBH_KODEPERJANJIAN, CBH_TGLAWAL, CBH_TGLAKHIR,
        	 CASE WHEN HDR.TIPE = 'R'  AND DTL.CASHBACK < 0 THEN
         	       DTL.KELIPATAN
       	 END QTYREF,
         	 CASE WHEN HDR.TIPE = 'S' AND DTL.CASHBACK > 0 THEN
                       DTL.KELIPATAN
	 END QTYSLS,
        	 CASE WHEN HDR.TIPE = 'R' AND DTL.CASHBACK < 0 THEN
               	       DTL.CASHBACK
	 END NILREF,
        	 CASE WHEN HDR.TIPE = 'S' AND DTL.CASHBACK > 0 THEN
                       DTL.CASHBACK
                 END NILSLS
            FROM M_PROMOSI_H HDR, M_PROMOSI_D DTL, TBTR_CASHBACK_HDR
           WHERE HDR.KD_IGR = '$kodeigr'
                 AND trunc(HDR.TGL_TRANS) BETWEEN TO_DATE('$sDate','DD-MM-YYYY') AND TO_DATE('$eDate', 'DD-MM-YYYY')
	 AND HDR.KD_PROMOSI = DTL.KD_PROMOSI
                 AND HDR.PROMOSI_ID = DTL.PROMOSI_ID
                 AND HDR.TRANS_NO = DTL.TRANS_NO
                 AND HDR.KD_PROMOSI = CBH_KODEPROMOSI
                 AND CBH_JENISPROMOSI NOT IN ('1', '2', '6')
        ) A, TBMASTER_PRODMAST, TBMASTER_SUPPLIER, TBMASTER_PERUSAHAAN
 WHERE a.plu = prd_prdcd(+)
     AND PRD_KODESUPPLIER = SUP_KODESUPPLIER(+)
     AND PRS_KODEIGR = '$kodeigr'
GROUP BY A.plu, prd_deskripsipanjang, sup_kodesupplier,
         sup_namasupplier, A.CBH_KODEPROMOSI, A.CBH_NAMAPROMOSI, A.CBH_KODEPERJANJIAN,
         A.CBH_TGLAWAL, A.CBH_TGLAKHIR, PRS_NAMAPERUSAHAAN,
         PRS_NAMACABANG, PRS_NAMAWILAYAH
ORDER BY A.CBH_KODEPROMOSI, A.PLU");
        if(!$cursor){
            return response()->json(['kode' => 0]);
        }else{
            return response()->json(['kode' => 1]);
        }
    }
    public function printDocument(Request $request){
        $kodeigr = Session::get('kdigr');
        $dateA = $request->date1;
        $dateB = $request->date2;
        $sDate = DateTime::createFromFormat('d-m-Y', $dateA)->format('d-m-Y');
        $eDate = DateTime::createFromFormat('d-m-Y', $dateB)->format('d-m-Y');
        $event1 = $request->event1;
        $event2 = $request->event2;
        if($event1 == "nodata"){
            $event1 = '';
        }
        if($event2 == "nodata"){
            $event2 = '';
        }
        $and_even = "";
        if($event1 != '' && $event2 != ''){
            $and_even = " and dtl.kd_promosi between '".$event1."' and '".$event2."'";
        }
        $datas = DB::connection(Session::get('connection'))
                    ->select("SELECT A.PLU,
         A.CBH_KODEPROMOSI,
         A.CBH_NAMAPROMOSI,
         A.CBH_KODEPERJANJIAN,
         A.CBH_TGLAWAL,
         A.CBH_TGLAKHIR,
         NILSLS_BKP,
         NILSLS_BTKP,
         NILREF_BKP,
         NILREF_BTKP,
         SLS_DPP,
         SLS_PPN,
         REF_DPP,
         REF_PPN,
         /*ROUND ( (NVL (NILSLS_BKP, 0) / (1+(COALESCE(PRD_PPN, 0)/100)) ) + NVL (NILSLS_BTKP, 0), 2) SLS_DPP,
         ROUND ( ( (NVL (NILSLS_BKP, 0) / (1+(COALESCE(PRD_PPN, 0)/100)) ) * (PRD_PPN/100)), 2) SLS_PPN,
         ROUND ( (NVL (NILREF_BKP, 0) / (1+(COALESCE(PRD_PPN, 0)/100)) ) + NVL (NILREF_BTKP, 0), 2) REF_DPP,
         ROUND ( ( (NVL (NILREF_BKP, 0) / (1+(COALESCE(PRD_PPN, 0)/100))) * (PRD_PPN/100)), 2) REF_PPN,*/
         PRD_DESKRIPSIPANJANG,
         SUP_KODESUPPLIER,
         SUP_NAMASUPPLIER,
         PRS_NAMAPERUSAHAAN,
         PRS_NAMACABANG,
         PRS_NAMAWILAYAH
    FROM (  SELECT '1111111' PLU,
                   CBH_KODEPROMOSI,
                   CBH_NAMAPROMOSI,
                   CBH_KODEPERJANJIAN,
                   CBH_TGLAWAL,
                   CBH_TGLAKHIR,
                   SUM (
                      CASE
                         WHEN TRP_TRANSACTIONTYPE = 'R' AND TRP_FLAGBKP = 'Y'
                         THEN
                            TRP_CASHBACK
                      END)
                      NILREF_BKP,
                   SUM (
                      CASE
                         WHEN TRP_TRANSACTIONTYPE = 'R' AND TRP_FLAGBKP <> 'Y'
                         THEN
                            TRP_CASHBACK
                      END)
                      NILREF_BTKP,
                   SUM (
                      CASE
                         WHEN TRP_TRANSACTIONTYPE = 'S' AND TRP_FLAGBKP = 'Y'
                         THEN
                            TRP_CASHBACK
                      END)
                      NILSLS_BKP,
                   SUM (
                      CASE
                         WHEN TRP_TRANSACTIONTYPE = 'S' AND TRP_FLAGBKP <> 'Y'
                         THEN
                            TRP_CASHBACK
                      END)
                      NILSLS_BTKP,
         ROUND ( (NVL (SUM (CASE WHEN TRP_TRANSACTIONTYPE = 'S' AND TRP_FLAGBKP = 'Y' THEN TRP_CASHBACK END), 0) / (1+(COALESCE((PRD_PPN), 0)/100)) ) + NVL (SUM (CASE WHEN TRP_TRANSACTIONTYPE = 'S' AND TRP_FLAGBKP <> 'Y' THEN TRP_CASHBACK END), 0), 2) SLS_DPP,
                      ROUND ( ( (NVL (SUM (CASE WHEN TRP_TRANSACTIONTYPE = 'S' AND TRP_FLAGBKP = 'Y' THEN TRP_CASHBACK END), 0) / (1+(COALESCE((PRD_PPN), 0)/100)) ) * ((PRD_PPN)/100)), 2) SLS_PPN,
                      ROUND ( (NVL (SUM (CASE WHEN TRP_TRANSACTIONTYPE = 'R' AND TRP_FLAGBKP = 'Y' THEN TRP_CASHBACK END), 0) / (1+(COALESCE((PRD_PPN), 0)/100)) ) + NVL (SUM (CASE WHEN TRP_TRANSACTIONTYPE = 'R' AND TRP_FLAGBKP <> 'Y' THEN TRP_CASHBACK END), 0), 2) REF_DPP,
                      ROUND ( ( (NVL (SUM (CASE WHEN TRP_TRANSACTIONTYPE = 'R' AND TRP_FLAGBKP = 'Y' THEN TRP_CASHBACK END), 0) / (1+(COALESCE((PRD_PPN), 0)/100))) * ((PRD_PPN)/100)), 2) REF_PPN
              FROM tbtr_transaksi_promosi, TBTR_CASHBACK_HDR HDR, tbmaster_prodmast
             WHERE     TRP_KODEIGR = '$kodeigr'
                   AND TRUNC (TRP_TRANSACTIONDATE) BETWEEN TO_DATE('$sDate','DD-MM-YYYY') AND TO_DATE('$eDate', 'DD-MM-YYYY')
                   AND TRP_KODEPROMOSI = HDR.CBH_KODEPROMOSI
                   AND CBH_JENISPROMOSI IN ('1', '2', '6')
                   AND PRD_PRDCD = TRP_PRDCD
          GROUP BY 1111111, CBH_KODEPROMOSI, CBH_NAMAPROMOSI, CBH_KODEPERJANJIAN, CBH_TGLAWAL, CBH_TGLAKHIR, PRD_PPN
--          ROUND ( (NVL (NILSLS_BKP, 0) / (1+(COALESCE(PRD_PPN, 0)/100)) ) + NVL (NILSLS_BTKP, 0), 2), ROUND ( ( (NVL (NILSLS_BKP, 0) / (1+(COALESCE(PRD_PPN, 0)/100)) ) * (PRD_PPN/100)), 2), ROUND ( (NVL (NILREF_BKP, 0) / (1+(COALESCE(PRD_PPN, 0)/100)) ) + NVL (NILREF_BTKP, 0), 2), ROUND ( ( (NVL (NILREF_BKP, 0) / (1+(COALESCE(PRD_PPN, 0)/100))) * (PRD_PPN/100)), 2)
          UNION ALL
            SELECT SUBSTR (TRP_PRDCD, 1, 6) || '1' PLU,
                   CBH_KODEPROMOSI,
                   CBH_NAMAPROMOSI,
                   CBH_KODEPERJANJIAN,
                   CBH_TGLAWAL,
                   CBH_TGLAKHIR,
                   SUM (
                      CASE
                         WHEN TRP_TRANSACTIONTYPE = 'R' AND TRP_FLAGBKP = 'Y'
                         THEN
                            TRP_CASHBACK
                      END)
                      NILREF_BKP,
                   SUM (
                      CASE
                         WHEN TRP_TRANSACTIONTYPE = 'R' AND TRP_FLAGBKP <> 'Y'
                         THEN
                            TRP_CASHBACK
                      END)
                      NILREF_BTKP,
                   SUM (
                      CASE
                         WHEN TRP_TRANSACTIONTYPE = 'S' AND TRP_FLAGBKP = 'Y'
                         THEN
                            TRP_CASHBACK
                      END)
                      NILSLS_BKP,
                   SUM (
                      CASE
                         WHEN TRP_TRANSACTIONTYPE = 'S' AND TRP_FLAGBKP <> 'Y'
                         THEN
                            TRP_CASHBACK
                      END)
                      NILSLS_BTKP,
                      ROUND ( (NVL (SUM (CASE WHEN TRP_TRANSACTIONTYPE = 'S' AND TRP_FLAGBKP = 'Y' THEN TRP_CASHBACK END), 0) / (1+(COALESCE((PRD_PPN), 0)/100)) ) + NVL (SUM (CASE WHEN TRP_TRANSACTIONTYPE = 'S' AND TRP_FLAGBKP <> 'Y' THEN TRP_CASHBACK END), 0), 2) SLS_DPP,
                      ROUND ( ( (NVL (SUM (CASE WHEN TRP_TRANSACTIONTYPE = 'S' AND TRP_FLAGBKP = 'Y' THEN TRP_CASHBACK END), 0) / (1+(COALESCE((PRD_PPN), 0)/100)) ) * ((PRD_PPN)/100)), 2) SLS_PPN,
                      ROUND ( (NVL (SUM (CASE WHEN TRP_TRANSACTIONTYPE = 'R' AND TRP_FLAGBKP = 'Y' THEN TRP_CASHBACK END), 0) / (1+(COALESCE((PRD_PPN), 0)/100)) ) + NVL (SUM (CASE WHEN TRP_TRANSACTIONTYPE = 'R' AND TRP_FLAGBKP <> 'Y' THEN TRP_CASHBACK END), 0), 2) REF_DPP,
                      ROUND ( ( (NVL (SUM (CASE WHEN TRP_TRANSACTIONTYPE = 'R' AND TRP_FLAGBKP = 'Y' THEN TRP_CASHBACK END), 0) / (1+(COALESCE((PRD_PPN), 0)/100))) * ((PRD_PPN)/100)), 2) REF_PPN
              FROM tbtr_transaksi_promosi, TBTR_CASHBACK_HDR HDR, tbmaster_prodmast
             WHERE     TRP_KODEIGR = '$kodeigr'
                   AND TRUNC (TRP_TRANSACTIONDATE) BETWEEN TO_DATE('$sDate','DD-MM-YYYY') AND TO_DATE('$eDate', 'DD-MM-YYYY')
                   AND TRP_KODEPROMOSI = HDR.CBH_KODEPROMOSI
                   AND CBH_JENISPROMOSI NOT IN ('1', '2', '6')
                   AND PRD_PRDCD = TRP_PRDCD
          GROUP BY SUBSTR (TRP_PRDCD, 1, 6) || '1',
                   CBH_KODEPROMOSI,
                   CBH_NAMAPROMOSI,
                   CBH_KODEPERJANJIAN,
                   CBH_TGLAWAL,
                   CBH_TGLAKHIR, PRD_PPN) A,
         TBMASTER_PRODMAST,
         TBMASTER_SUPPLIER,
         TBMASTER_PERUSAHAAN
   WHERE     substr(a.plu,1,6) ||'0' = prd_prdcd(+)
         AND PRD_KODESUPPLIER = SUP_KODESUPPLIER(+)
         AND PRS_KODEIGR = '$kodeigr'
ORDER BY A.CBH_KODEPROMOSI, A.PLU");



        if(sizeof($datas) == 0){
            return "**DATA TIDAK ADA**";
        }
        //PRINT
        $perusahaan = DB::connection(Session::get('connection'))->table("tbmaster_perusahaan")->first();
        $today = date('d-m-Y');
        $time = date('H:i:s');
        $dateA = str_replace("-","/",$dateA);
        $dateB = str_replace("-","/",$dateB);

//        $pdf = PDF::loadview('FRONTOFFICE\LAPORANKASIR\csi-pdf',
//            ['kodeigr' => $kodeigr, 'judul' => $judul ,'date1' => $dateA, 'date2' => $dateB, 'datas' => $datas, 'today' => $today, 'time' => $time]);
//        $pdf->setPaper('A4', 'potrait');
//        $pdf->output();
//        $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);
//
//        $canvas = $dompdf ->get_canvas();
//        $canvas->page_text(514, 24, "PAGE {PAGE_NUM} of {PAGE_COUNT}", null, 8, array(0, 0, 0));
//
//        return $pdf->stream('FRONTOFFICE\LAPORANKASIR\csi-pdf');








        return view('FRONTOFFICE.LAPORANKASIR.cei-pdf',['kodeigr' => $kodeigr,'date1' => $dateA, 'date2' => $dateB, 'data' => $datas,'perusahaan' => $perusahaan ,'today' => $today, 'time' => $time]);

    }

    public function downloadCsv(Request $request) {
        $kodeigr = Session::get('kdigr');
        $dateA = $request->date1;
        $dateB = $request->date2;
        $sDate = DateTime::createFromFormat('d-m-Y', $dateA)->format('d-m-Y');
        $eDate = DateTime::createFromFormat('d-m-Y', $dateB)->format('d-m-Y');
        $event1 = $request->event1;
        $event2 = $request->event2;
        if($event1 == "nodata"){
            $event1 = '';
        }
        if($event2 == "nodata"){
            $event2 = '';
        }
        $and_even = "";
        if($event1 != '' && $event2 != ''){
            $and_even = " and dtl.kd_promosi between '".$event1."' and '".$event2."'";
        }

        $csvDatas = DB::connection(Session::get('connection'))
            ->select("SELECT CAB,
                CBH_KODEPROMOSI,
                CBH_KODEPERJANJIAN,
                CBH_NAMAPROMOSI,
                SUP_KODESUPPLIER,
                SUM (SLS_DPP) SLS_DPP,
                SUM (SLS_PPN) SLS_PPN,
                SUM (REF_DPP) REF_DPP,
                SUM (REF_PPN) REF_PPN,
                SUM (SLS_DPP + REF_DPP) TTL_DPP,
                SUM (SLS_PPN + REF_PPN) TTL_PPN
            FROM (SELECT prs_namacabang cab,
                        A.CBH_KODEPROMOSI,
                        A.CBH_KODEPERJANJIAN,
                        A.CBH_NAMAPROMOSI,
                        A.CBH_TGLAWAL,
                        A.CBH_TGLAKHIR,
                        A.PLU,
                        PRD_PPN,
                        PRD_DESKRIPSIPANJANG,
                        SUP_KODESUPPLIER,
                        SUP_NAMASUPPLIER,
                        ROUND (
                            (NVL (NILSLS_BKP, 0) / NVL ((1 + ( NVL (PRD_PPN, 10) / 100)), 1.1)) + NVL (NILSLS_BTKP, 0),
                            2)
                            SLS_DPP,
                        ROUND ( ( (NVL (NILSLS_BKP, 0) / NVL ((1 + ( NVL (PRD_PPN, 10) / 100)), 1.1)) * NVL ((NVL (PRD_PPN, 10) / 100), 0.1)), 2) SLS_PPN,
                        ROUND (
                            (NVL (NILREF_BKP, 0) / NVL ((1 + ( NVL (PRD_PPN, 10) / 100)), 1.1)) + NVL (NILREF_BTKP, 0),
                            2)
                            REF_DPP,
                        ROUND ( ( (NVL (NILREF_BKP, 0) / NVL ((1 + ( NVL (PRD_PPN, 10) / 100)), 1.1)) * NVL ((NVL (PRD_PPN, 10) / 100), 0.1)), 2) REF_PPN
                    FROM (  SELECT '1111111' PLU,
                                    CBH_KODEPROMOSI,
                                    CBH_NAMAPROMOSI,
                                    CBH_KODEPERJANJIAN,
                                    CBH_TGLAWAL,
                                    CBH_TGLAKHIR,
                                    SUM (
                                        CASE
                                        WHEN     TRP_TRANSACTIONTYPE = 'R'
                                                AND TRP_FLAGBKP = 'Y'
                                        THEN
                                            TRP_CASHBACK
                                        END)
                                        NILREF_BKP,
                                    SUM (
                                        CASE
                                        WHEN     TRP_TRANSACTIONTYPE = 'R'
                                                AND TRP_FLAGBKP <> 'Y'
                                        THEN
                                            TRP_CASHBACK
                                        END)
                                        NILREF_BTKP,
                                    SUM (
                                        CASE
                                        WHEN     TRP_TRANSACTIONTYPE = 'S'
                                                AND TRP_FLAGBKP = 'Y'
                                        THEN
                                            TRP_CASHBACK
                                        END)
                                        NILSLS_BKP,
                                    SUM (
                                        CASE
                                        WHEN     TRP_TRANSACTIONTYPE = 'S'
                                                AND TRP_FLAGBKP <> 'Y'
                                        THEN
                                            TRP_CASHBACK
                                        END)
                                        NILSLS_BTKP
                                FROM tbtr_transaksi_promosi, TBTR_CASHBACK_HDR HDR
                            WHERE     TRP_KODEIGR = '$kodeigr'
                                    AND TRUNC (TRP_TRANSACTIONDATE) BETWEEN TO_DATE('$sDate','DD-MM-YYYY')
                                                                        AND TO_DATE('$eDate','DD-MM-YYYY')
                                    AND TRP_KODEPROMOSI = HDR.CBH_KODEPROMOSI
                                    AND CBH_JENISPROMOSI IN ('1', '2', '6')
                            GROUP BY CBH_KODEPROMOSI,
                                    CBH_NAMAPROMOSI,
                                    CBH_KODEPERJANJIAN,
                                    CBH_TGLAWAL,
                                    CBH_TGLAKHIR
                            UNION ALL
                            SELECT SUBSTR (TRP_PRDCD, 1, 6) || '1' PLU,
                                    CBH_KODEPROMOSI,
                                    CBH_NAMAPROMOSI,
                                    CBH_KODEPERJANJIAN,
                                    CBH_TGLAWAL,
                                    CBH_TGLAKHIR,
                                    SUM (
                                        CASE
                                        WHEN     TRP_TRANSACTIONTYPE = 'R'
                                                AND TRP_FLAGBKP = 'Y'
                                        THEN
                                            TRP_CASHBACK
                                        END)
                                        NILREF_BKP,
                                    SUM (
                                        CASE
                                        WHEN     TRP_TRANSACTIONTYPE = 'R'
                                                AND TRP_FLAGBKP <> 'Y'
                                        THEN
                                            TRP_CASHBACK
                                        END)
                                        NILREF_BTKP,
                                    SUM (
                                        CASE
                                        WHEN     TRP_TRANSACTIONTYPE = 'S'
                                                AND TRP_FLAGBKP = 'Y'
                                        THEN
                                            TRP_CASHBACK
                                        END)
                                        NILSLS_BKP,
                                    SUM (
                                        CASE
                                        WHEN     TRP_TRANSACTIONTYPE = 'S'
                                                AND TRP_FLAGBKP <> 'Y'
                                        THEN
                                            TRP_CASHBACK
                                        END)
                                        NILSLS_BTKP
                                FROM tbtr_transaksi_promosi, TBTR_CASHBACK_HDR HDR
                            WHERE     TRP_KODEIGR = '$kodeigr'
                                    AND TRUNC (TRP_TRANSACTIONDATE) BETWEEN TO_DATE('$sDate','DD-MM-YYYY')
                                                                        AND TO_DATE('$eDate','DD-MM-YYYY')
                                    AND TRP_KODEPROMOSI = HDR.CBH_KODEPROMOSI
                                    AND CBH_JENISPROMOSI NOT IN ('1', '2', '6')
                            GROUP BY SUBSTR (TRP_PRDCD, 1, 6) || '1',
                                    CBH_KODEPROMOSI,
                                    CBH_NAMAPROMOSI,
                                    CBH_KODEPERJANJIAN,
                                    CBH_TGLAWAL,
                                    CBH_TGLAKHIR) A,
                        TBMASTER_PRODMAST,
                        TBMASTER_SUPPLIER,
                        TBMASTER_PERUSAHAAN
                    WHERE     SUBSTR (a.plu, 1, 6) || '0' = prd_prdcd(+)
                        AND PRD_KODESUPPLIER = SUP_KODESUPPLIER(+)
                        AND PRS_KODEIGR = '$kodeigr')
        GROUP BY CAB,
                CBH_KODEPROMOSI,
                CBH_KODEPERJANJIAN,
                CBH_NAMAPROMOSI,
                SUP_KODESUPPLIER
        ORDER BY CBH_KODEPROMOSI");

        $columnHeader = [
            'NO',
            'CBG',
            'KODE_PROMO',
            'SKP',
            'DEKSRIPSI',
            'KODE_SUPPLIER',

            'SALES_DPP',
            'SALES_PPN',

            'REFUND_DPP',
            'REFUND_PPN',

            'TOTAL_DPP',
            'TOTAL_PPN',
        ];
        $lineBuffs = array();

        $i = 1;
        foreach ($csvDatas as $csvData) {
            $tempData = [
                $i,
                $csvData->cab,
                $csvData->cbh_kodepromosi,
                $csvData->cbh_kodeperjanjian,
                $csvData->cbh_namapromosi,
                $csvData->sup_kodesupplier,
                $csvData->sls_dpp,
                $csvData->sls_ppn,
                $csvData->ref_dpp,
                $csvData->ref_ppn,
                $csvData->ttl_dpp,
                $csvData->ttl_ppn
            ];
            $i++;
            array_push($lineBuffs, $tempData);
        }
        $filename = 'laporan-cashback-per-event-promosi-per-item.csv';
        $headers = [
            "Content-type" => "text/csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $file = fopen(storage_path($filename), 'w');

        fputcsv($file, $columnHeader, '|');
        foreach ($lineBuffs as $lineBuff) {
            fputcsv($file, $lineBuff, '|');
        }
        fclose($file);

        return response()->download(storage_path($filename))->deleteFileAfterSend(true);
    }
}





//SELECT A.PLU, A.CBH_KODEPROMOSI,A.CBH_NAMAPROMOSI, A.CBH_KODEPERJANJIAN, A.CBH_TGLAWAL,
//         A.CBH_TGLAKHIR, SUM(A.qtyref) qtyref, SUM(A.qtysls) qtysls, SUM(A.nilref) nilref,
//         SUM(A.nilsls) nilsls, PRD_DESKRIPSIPANJANG, SUP_KODESUPPLIER, SUP_NAMASUPPLIER,
//         PRS_NAMAPERUSAHAAN, PRS_NAMACABANG, PRS_NAMAWILAYAH
//  FROM (SELECT  '1111111' PLU, CBH_KODEPROMOSI, CBH_NAMAPROMOSI, CBH_KODEPERJANJIAN,
//                 CBH_TGLAWAL, CBH_TGLAKHIR,
//	 CASE WHEN H.TIPE = 'R' THEN
//         	       H.KELIPATAN
//	 END QTYREF,
//	 CASE WHEN H.TIPE = 'S' THEN
//                       H.KELIPATAN
//                 END QTYSLS,
//        	 CASE WHEN H.TIPE = 'R' THEN
//                       H.CASHBACK
//	 END NILREF,
//        	 CASE WHEN H.TIPE = 'S' THEN
//                       H.CASHBACK
//                 END NILSLS
//            FROM M_PROMOSI_H H, TBTR_CASHBACK_HDR HDR
//           WHERE H.KD_IGR = '$kodeigr'
//AND trunc(H.TGL_TRANS) BETWEEN TO_DATE('$sDate','DD-MM-YYYY') AND TO_DATE('$eDate', 'DD-MM-YYYY')
//AND H.KD_PROMOSI = HDR.CBH_KODEPROMOSI
//AND CBH_JENISPROMOSI IN ('1', '2', '6')
//        UNION ALL
//            SELECT SUBSTR(DTL.KD_PLU,1,6)||'1' PLU,
//	 CBH_KODEPROMOSI, CBH_NAMAPROMOSI, CBH_KODEPERJANJIAN, CBH_TGLAWAL, CBH_TGLAKHIR,
//        	 CASE WHEN HDR.TIPE = 'R'  AND DTL.CASHBACK < 0 THEN
//         	       DTL.KELIPATAN
//       	 END QTYREF,
//         	 CASE WHEN HDR.TIPE = 'S' AND DTL.CASHBACK > 0 THEN
//                       DTL.KELIPATAN
//	 END QTYSLS,
//        	 CASE WHEN HDR.TIPE = 'R' AND DTL.CASHBACK < 0 THEN
//               	       DTL.CASHBACK
//	 END NILREF,
//        	 CASE WHEN HDR.TIPE = 'S' AND DTL.CASHBACK > 0 THEN
//                       DTL.CASHBACK
//                 END NILSLS
//            FROM M_PROMOSI_H HDR, M_PROMOSI_D DTL, TBTR_CASHBACK_HDR
//           WHERE HDR.KD_IGR = '$kodeigr'
//AND trunc(HDR.TGL_TRANS) BETWEEN TO_DATE('$sDate','DD-MM-YYYY') AND TO_DATE('$eDate', 'DD-MM-YYYY')
//AND HDR.KD_PROMOSI = DTL.KD_PROMOSI
//AND HDR.PROMOSI_ID = DTL.PROMOSI_ID
//AND HDR.TRANS_NO = DTL.TRANS_NO
//AND HDR.KD_PROMOSI = CBH_KODEPROMOSI
//AND CBH_JENISPROMOSI NOT IN ('1', '2', '6')
//        ) A, TBMASTER_PRODMAST, TBMASTER_SUPPLIER, TBMASTER_PERUSAHAAN
// WHERE a.plu = prd_prdcd(+)
//AND PRD_KODESUPPLIER = SUP_KODESUPPLIER(+)
//AND PRS_KODEIGR = '$kodeigr'
//GROUP BY A.plu, prd_deskripsipanjang, sup_kodesupplier,
//         sup_namasupplier, A.CBH_KODEPROMOSI, A.CBH_NAMAPROMOSI, A.CBH_KODEPERJANJIAN,
//         A.CBH_TGLAWAL, A.CBH_TGLAKHIR, PRS_NAMAPERUSAHAAN,
//         PRS_NAMACABANG, PRS_NAMAWILAYAH
//ORDER BY A.CBH_KODEPROMOSI, A.PLU
