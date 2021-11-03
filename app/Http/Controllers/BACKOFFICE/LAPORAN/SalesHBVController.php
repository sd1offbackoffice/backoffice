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

class SalesHBVController extends Controller
{

    public function index()
    {
        return view('BACKOFFICE.LAPORAN.SalesHBV');
    }
    public function CheckData(Request $request){
        $kodeigr = $_SESSION['kdigr'];
        $dateA = $request->dateA;
        $dateB = $request->dateB;
        $sDate = DateTime::createFromFormat('d-m-Y', $dateA)->format('d-m-Y');
        $eDate = DateTime::createFromFormat('d-m-Y', $dateB)->format('d-m-Y');
        $cursor = DB::select("SELECT   PRD_KODEDEPARTEMENT, DEP_NAMADEPARTEMENT, TRJD_PRDCD, DESC_JADI, HBV_PRDCD_BRD,
         PRD_DESKRIPSIPANJANG, UNIT_JADI, PRD_UNIT, TRJD_QUANTITY, HBV_QTY_GRAM,
         (TRJD_QUANTITY * HBV_QTY_GRAM) QTY, TRJD_UNITPRICE, round((ST_AVGCOST / 1000),0) HRG_DASAR,
         (TRJD_QUANTITY * TRJD_UNITPRICE) NILAI_JADI,
         round((( (TRJD_QUANTITY * HBV_QTY_GRAM) * ST_AVGCOST ) / 1000) , 0) NILAI_DASAR, PRS_NAMAPERUSAHAAN,
         PRS_NAMACABANG
    FROM (SELECT   TRJD_PRDCD, PRD_DESKRIPSIPANJANG DESC_JADI, PRD_UNIT UNIT_JADI,
                   SUM (TRJD_QUANTITY) TRJD_QUANTITY, TRJD_UNITPRICE
              FROM TBTR_JUALDETAIL, TBMASTER_PRODMAST
             WHERE TRUNC (TRJD_TRANSACTIONDATE) BETWEEN TO_DATE('$sDate','DD-MM-YYYY') AND TO_DATE('$eDate', 'DD-MM-YYYY')
               AND PRD_PRDCD = TRJD_PRDCD
               AND NVL (PRD_FLAGHBV, 'N') = 'Y'
          GROUP BY TRJD_PRDCD, PRD_DESKRIPSIPANJANG, PRD_UNIT, TRJD_UNITPRICE) A,
         TBMASTER_FORMULA_HBV,
         TBMASTER_PRODMAST,
         TBMASTER_DEPARTEMENT,
         TBMASTER_STOCK,
         TBMASTER_PERUSAHAAN
   WHERE HBV_PRDCD_BRJ(+) = SUBSTR (TRJD_PRDCD, 1, 6) || '0'
     AND PRD_PRDCD = SUBSTR (HBV_PRDCD_BRD, 1, 6) || '0'
     AND DEP_KODEDEPARTEMENT = PRD_KODEDEPARTEMENT
     AND ST_PRDCD = SUBSTR (HBV_PRDCD_BRD, 1, 6) || '0'
     AND ST_LOKASI = '01'
     AND PRS_KODEIGR = '$kodeigr'
ORDER BY TRJD_PRDCD");
        if(!$cursor){
            return response()->json(['kode' => 0]);
        }else{
            return response()->json(['kode' => 1]);
        }
    }
    public function printDocument(Request $request){
        $kodeigr = $_SESSION['kdigr'];
        $dateA = $request->date1;
        $dateB = $request->date2;
        $today = date('d-m-Y');
        $time = date('H:i:s');
        $sDate = DateTime::createFromFormat('d-m-Y', $dateA)->format('d-m-Y');
        $eDate = DateTime::createFromFormat('d-m-Y', $dateB)->format('d-m-Y');

    $datas = DB::select("SELECT   PRD_KODEDEPARTEMENT, DEP_NAMADEPARTEMENT, TRJD_PRDCD, DESC_JADI, HBV_PRDCD_BRD,
         PRD_DESKRIPSIPANJANG, UNIT_JADI, PRD_UNIT, TRJD_QUANTITY, HBV_QTY_GRAM,
         (TRJD_QUANTITY * HBV_QTY_GRAM) QTY, TRJD_UNITPRICE, round((ST_AVGCOST / 1000),0) HRG_DASAR,
         (TRJD_QUANTITY * TRJD_UNITPRICE) NILAI_JADI,
         round((( (TRJD_QUANTITY * HBV_QTY_GRAM) * ST_AVGCOST ) / 1000) , 0) NILAI_DASAR, PRS_NAMAPERUSAHAAN,
         PRS_NAMACABANG
    FROM (SELECT   TRJD_PRDCD, PRD_DESKRIPSIPANJANG DESC_JADI, PRD_UNIT UNIT_JADI,
                   SUM (TRJD_QUANTITY) TRJD_QUANTITY, TRJD_UNITPRICE
              FROM TBTR_JUALDETAIL, TBMASTER_PRODMAST
             WHERE TRUNC (TRJD_TRANSACTIONDATE) BETWEEN TO_DATE('$sDate','DD-MM-YYYY') AND TO_DATE('$eDate', 'DD-MM-YYYY')
               AND PRD_PRDCD = TRJD_PRDCD
               AND NVL (PRD_FLAGHBV, 'N') = 'Y'
          GROUP BY TRJD_PRDCD, PRD_DESKRIPSIPANJANG, PRD_UNIT, TRJD_UNITPRICE) A,
         TBMASTER_FORMULA_HBV,
         TBMASTER_PRODMAST,
         TBMASTER_DEPARTEMENT,
         TBMASTER_STOCK,
         TBMASTER_PERUSAHAAN
   WHERE HBV_PRDCD_BRJ(+) = SUBSTR (TRJD_PRDCD, 1, 6) || '0'
     AND PRD_PRDCD = SUBSTR (HBV_PRDCD_BRD, 1, 6) || '0'
     AND DEP_KODEDEPARTEMENT = PRD_KODEDEPARTEMENT
     AND ST_PRDCD = SUBSTR (HBV_PRDCD_BRD, 1, 6) || '0'
     AND ST_LOKASI = '01'
     AND PRS_KODEIGR = '$kodeigr'
ORDER BY TRJD_PRDCD");

        $datas2 = DB::select("SELECT   HBV_PRDCD_BRD PLU_DSR, PRD_DESKRIPSIPANJANG DESC_DSR, PRD_UNIT UNIT_DSR, SUM (QTY) QTY_DSR,
         HRG_DASAR HRG_DSR, SUM (NILAI_DASAR) NILAI_DSR
    FROM (SELECT   TRJD_PRDCD, DESC_JADI, HBV_PRDCD_BRD, PRD_DESKRIPSIPANJANG, UNIT_JADI, PRD_UNIT,
                   TRJD_QUANTITY, HBV_QTY_GRAM, (TRJD_QUANTITY * HBV_QTY_GRAM) QTY, TRJD_UNITPRICE,
                   ROUND ((ST_AVGCOST / 1000), 0) HRG_DASAR,
                   (TRJD_QUANTITY * TRJD_UNITPRICE) NILAI_JADI,
                   ROUND ((((TRJD_QUANTITY * HBV_QTY_GRAM) * ST_AVGCOST) / 1000), 0) NILAI_DASAR
              FROM (SELECT   TRJD_PRDCD, PRD_DESKRIPSIPANJANG DESC_JADI, PRD_UNIT UNIT_JADI,
                             SUM (TRJD_QUANTITY) TRJD_QUANTITY, TRJD_UNITPRICE
                        FROM TBTR_JUALDETAIL, TBMASTER_PRODMAST
                       WHERE TRUNC (TRJD_TRANSACTIONDATE) BETWEEN TO_DATE('$sDate','DD-MM-YYYY') AND TO_DATE('$eDate', 'DD-MM-YYYY')
                         AND PRD_PRDCD = TRJD_PRDCD
                         AND NVL (PRD_FLAGHBV, 'N') = 'Y'
                    GROUP BY TRJD_PRDCD, PRD_DESKRIPSIPANJANG, PRD_UNIT, TRJD_UNITPRICE) A,
                   TBMASTER_FORMULA_HBV,
                   TBMASTER_PRODMAST,
                   TBMASTER_STOCK
             WHERE HBV_PRDCD_BRJ(+) = SUBSTR (TRJD_PRDCD, 1, 6) || '0'
               AND PRD_PRDCD = SUBSTR (HBV_PRDCD_BRD, 1, 6) || '0'
               AND ST_PRDCD = SUBSTR (HBV_PRDCD_BRD, 1, 6) || '0'
               AND ST_LOKASI = '01'
          ORDER BY TRJD_PRDCD) A
GROUP BY HBV_PRDCD_BRD, PRD_DESKRIPSIPANJANG, PRD_UNIT, HRG_DASAR
ORDER BY HBV_PRDCD_BRD");

        //PRINT
        $pdf = PDF::loadview('BACKOFFICE.LAPORAN.SalesHBV-pdf',
            ['kodeigr' => $kodeigr, 'date1' => $dateA, 'date2' => $dateB, 'datas' => $datas, 'datas2' => $datas2,'today' => $today]);
        $pdf->setPaper('A4', 'landscape');
        $pdf->output();
        $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);

        $canvas = $dompdf ->get_canvas();
        $canvas->page_text(780, 24, "PAGE {PAGE_NUM} of {PAGE_COUNT}", null, 8, array(0, 0, 0));

        return $pdf->stream('SalesHBV.pdf');
    }
}
