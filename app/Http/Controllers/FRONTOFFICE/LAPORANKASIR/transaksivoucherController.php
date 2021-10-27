<?php
/**
 * Created by PhpStorm.
 * User: ryan
 * Date: 1/12/2021
 * Time: 3:25 PM
 */

namespace App\Http\Controllers\FRONTOFFICE\LAPORANKASIR;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use PDF;
use DateTime;
//use Yajra\DataTables\DataTables;

class transaksivoucherController extends Controller
{

    public function index()
    {
        return view('FRONTOFFICE\LAPORANKASIR.transaksivoucher');
    }

    public function print(Request $request)
    {
        $kodeigr = $_SESSION['kdigr'];
        $dateA = $request->date1;
        $dateB = $request->date2;
        $sDate = DateTime::createFromFormat('d-m-Y', $dateA)->format('d-m-Y');
        $eDate = DateTime::createFromFormat('d-m-Y', $dateB)->format('d-m-Y');
        if($dateA != $dateB){
            $periode = 'PERIODE: '.$dateA.' s/d '.$dateB;
        }else{
            $periode = 'TANGGAL: '.$dateA;
        }

        $datas = DB::select("SELECT   PRS_NAMAPERUSAHAAN, PRS_NAMACABANG, TRNDATE, KODEVOUCHER, PLATINUM, GOLD,
         SILVER, REGULER, BIRU, GIFT_VCR*NILAIVOUCHER GIFT_VCR
    FROM (SELECT   POT_KODEIGR KODEIGR, TRNDATE, KODEVOUCHER, NILAIVOUCHER,
                   SUM (CASE
                            WHEN SEGMENTASI = 'PLATINUM'
                                THEN POT_TUKARPOINT
                            ELSE 0
                        END) PLATINUM,
                   SUM (CASE
                            WHEN SEGMENTASI LIKE 'GOLD%'
                                THEN POT_TUKARPOINT
                            ELSE 0
                        END) GOLD,
                   SUM (CASE
                            WHEN SEGMENTASI = 'SILVER'
                                THEN POT_TUKARPOINT
                            ELSE 0
                        END) SILVER,
                   SUM (CASE
                            WHEN NVL(SEGMENTASI,'REGULER') = 'REGULER'
                                THEN POT_TUKARPOINT
                            ELSE 0
                        END) REGULER,
                   SUM (CASE
                            WHEN SEGMENTASI LIKE 'BIRU%'
                                THEN POT_TUKARPOINT
                            ELSE 0
                        END) BIRU,
                   NULL GIFT_VCR
              FROM (SELECT POT_KODEIGR, TRUNC (JH_TRANSACTIONDATE) TRNDATE,
                           (SELECT DISTINCT SEG_NAMA
                                       FROM TBMASTER_CUSTOMERCRM, TBMASTER_SEGMENTASI
                                      WHERE SEG_ID = CRM_IDSEGMENT
                                        AND CRM_KODEMEMBER = JH_CUS_KODEMEMBER) SEGMENTASI,
                           'IGR RETAIL' KODEVOUCHER,
                           (SELECT VCS_NILAIVOUCHER
                              FROM TBTABEL_VOUCHERSUPPLIER
                             WHERE VCS_NAMASUPPLIER = 'IGR RETAIL') NILAIVOUCHER,
                           (POT_PENUKARANPOINT + POT_REDEEMPOINT) POT_TUKARPOINT
                      FROM TBTR_JUALHEADER A, TBTR_PENUKARANMYPOIN
                     WHERE TRUNC (JH_TRANSACTIONDATE) BETWEEN TO_DATE('$sDate','DD-MM-YYYY') AND TO_DATE('$eDate', 'DD-MM-YYYY')
                       AND JH_VOUCHERQTY > 0
                       AND JH_TRANSACTIONTYPE = 'S'
                       AND    TO_CHAR (JH_TRANSACTIONDATE, 'yyyymmdd')
                           || JH_CASHIERID
                           || JH_CASHIERSTATION
                           || JH_TRANSACTIONNO
                           || JH_TRANSACTIONTYPE = POT_KODETRANSAKSI
                       AND JH_CUS_KODEMEMBER = POT_KODEMEMBER)
          GROUP BY POT_KODEIGR, TRNDATE, KODEVOUCHER, NILAIVOUCHER
          UNION ALL
          SELECT   VCR_KODEIGR, TRUNC (VCR_TGLTRANSAKSI) TGLTRANSAKSI, VCR_KODEVOUCHER, VCR_NOMINAL,
                   NULL PLATINUM, NULL GOLD, NULL SILVER, NULL REGULER, NULL BIRU, SUM (VCR_QTY) GIFT_VCR
              FROM TBTR_PEMBAYARANVOUCHER
             WHERE TRUNC (VCR_TGLTRANSAKSI) BETWEEN TO_DATE('$sDate','DD-MM-YYYY') AND TO_DATE('$eDate', 'DD-MM-YYYY') AND VCR_QTY > 0
          GROUP BY VCR_KODEIGR, TRUNC (VCR_TGLTRANSAKSI), VCR_KODEVOUCHER, VCR_NOMINAL),
         TBMASTER_PERUSAHAAN
   WHERE PRS_KODEIGR = KODEIGR AND PRS_KODEIGR = '$kodeigr'
ORDER BY TRNDATE, REPLACE (KODEVOUCHER, 'R', '0')");
//        if(sizeof($datas) == 0){
//            return "**DATA TIDAK ADA**";
//        }

        $val['platinum'] = 0; $val['gold'] = 0;$val['silver'] = 0; $val['reguler'] = 0; $val['biru'] = 0; $val['gift_vcr'] = 0;

        for($i=0;$i<sizeof($datas);$i++){
            $val['platinum'] = $val['platinum'] + $datas[$i]->platinum;
            $val['gold'] = $val['gold'] + $datas[$i]->gold;
            $val['silver'] = $val['silver'] + $datas[$i]->silver;
            $val['reguler'] = $val['reguler'] + $datas[$i]->reguler;
            $val['biru'] = $val['biru'] + $datas[$i]->biru;
            $val['gift_vcr'] = $val['gift_vcr'] + $datas[$i]->gift_vcr;
        }

        //PRINT
        $perusahaan = DB::table("tbmaster_perusahaan")->first();
        $today = date('d-m-Y');
        $time = date('H:i:s');

        $pdf = PDF::loadview('FRONTOFFICE\LAPORANKASIR\lap_trn_vcr-pdf',
            ['kodeigr' => $kodeigr, 'date1' => $dateA, 'date2' => $dateB, 'data' => $datas, 'perusahaan' => $perusahaan ,'val' => $val,
                'periode' => $periode, 'today' => $today, 'time' => $time]);
        $pdf->setPaper('A4', 'potrait');
        $pdf->output();
        $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);

        $canvas = $dompdf ->get_canvas();
        $canvas->page_text(511, 78, "{PAGE_NUM} / {PAGE_COUNT}", null, 7, array(0, 0, 0));

        return $pdf->stream('FRONTOFFICE\LAPORANKASIR\lap_trn_vcr-pdf');

    }

}
