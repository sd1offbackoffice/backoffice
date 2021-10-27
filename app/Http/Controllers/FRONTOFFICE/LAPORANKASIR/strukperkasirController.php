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

class strukperkasirController extends Controller
{

    public function index()
    {
        return view('FRONTOFFICE\LAPORANKASIR.strukperkasir');
    }

    public function printstruk(Request $request)
    {
        $kodeigr = $_SESSION['kdigr'];
        $dateA = $request->date1;
        $dateB = $request->date2;
        $sDate = DateTime::createFromFormat('d-m-Y', $dateA)->format('d-m-Y');
        $eDate = DateTime::createFromFormat('d-m-Y', $dateB)->format('d-m-Y');
        $typeTransaksi = $request->type;

        if($typeTransaksi == 'S'){
            $datas = DB::select("SELECT prs_namaperusahaan, prs_namacabang, prs_namawilayah, TRUNC(jh_transactiondate) jh_transactiondate, jh_cashierstation, jh_cashierid||'-'||username jh_cashier, jh_transactionno, jh_transactionamt
FROM TBTR_JUALHEADER, TBMASTER_PERUSAHAAN, TBMASTER_USER
WHERE jh_kodeigr = prs_kodeigr
  AND prs_kodeigr = '$kodeigr'
  AND jh_cashierid = userid(+)
  AND TRUNC(jh_transactiondate) between TO_DATE('$sDate','DD-MM-YYYY') AND TO_DATE('$eDate', 'DD-MM-YYYY')
  AND jh_transactiontype = 'S'
  AND jh_recordid IS NULL
ORDER BY jh_transactiondate, jh_cashierstation, jh_cashierid, jh_transactionno");
        }else{ //type R dan lain lain
            $datas = DB::select("SELECT prs_namaperusahaan, prs_namacabang, prs_namawilayah, TRUNC(jh_transactiondate) jh_transactiondate, jh_cashierstation, jh_cashierid||'-'||us1.username jh_cashier, jh_transactionno, jh_transactionamt,
	   jh_referencedate, jh_referencecashierid||'-'||us2.username jh_referencecashierid, jh_referenceno
FROM TBTR_JUALHEADER, TBMASTER_PERUSAHAAN, TBMASTER_USER us1, TBMASTER_USER us2
WHERE jh_kodeigr = prs_kodeigr
  AND prs_kodeigr = '$kodeigr'
  AND jh_cashierid = us1.userid
  AND jh_referencecashierid = us2.USERID
  AND TRUNC(jh_transactiondate)  between TO_DATE('$sDate','DD-MM-YYYY') AND TO_DATE('$eDate', 'DD-MM-YYYY')
  AND jh_transactiontype = 'R'
  AND jh_recordid IS NULL
ORDER BY jh_transactiondate, jh_cashierstation, jh_cashierid, jh_transactionno");
        }

//        if(sizeof($datas) == 0){
//            return "**DATA TIDAK ADA**";
//        }

        //PRINT
        $perusahaan = DB::table("tbmaster_perusahaan")->first();
        $today = date('d-m-Y');
        $time = date('H:i:s');

        if($typeTransaksi == 'S') {
            return view('FRONTOFFICE\LAPORANKASIR\lap_strk_perkasir_s-pdf',
                ['kodeigr' => $kodeigr, 'date1' => $dateA, 'date2' => $dateB, 'data' => $datas, 'perusahaan' =>$perusahaan,
                    'today' => $today, 'time' => $time]);
        }else{ //type R dan lain lain
            $pdf = PDF::loadview('FRONTOFFICE\LAPORANKASIR\lap_strk_perkasir_r-pdf',
                ['kodeigr' => $kodeigr, 'date1' => $dateA, 'date2' => $dateB, 'data' => $datas, 'perusahaan' =>$perusahaan,
                    'today' => $today, 'time' => $time]);
            $pdf->setPaper('A4', 'potrait');
            $pdf->output();
            $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);

            $canvas = $dompdf ->get_canvas();
            $canvas->page_text(511, 78, "{PAGE_NUM} / {PAGE_COUNT}", null, 7, array(0, 0, 0));

            return $pdf->stream('FRONTOFFICE\LAPORANKASIR\lap_strk_perkasir_r-pdf');
        }
    }

    public function printwaktu(Request $request){
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

        $datas = DB::select("SELECT prs_namaperusahaan,
         prs_namacabang,
         TRUNC (jh_transactiondate) jh_transactiondate,
         TO_CHAR (jh_create_dt, 'HH24:MI:SS') waktu,
         jh_cashierstation,
         jh_cashierid || '-' || username jh_cashier,
         jh_transactionno,
         jh_transactionamt
    FROM TBTR_JUALHEADER, TBMASTER_PERUSAHAAN, TBMASTER_USER
   WHERE     jh_kodeigr = prs_kodeigr
         AND prs_kodeigr = '$kodeigr'
         AND jh_cashierid = userid(+)
         AND to_char(jh_transactiondate, 'yyyyMMdd') BETWEEN TO_DATE('$sDate','DD-MM-YYYY') AND TO_DATE('$eDate', 'DD-MM-YYYY')
         AND jh_transactiontype = 'S'
         AND jh_recordid IS NULL
ORDER BY jh_transactiondate,
         waktu,
         jh_cashierstation,
         jh_cashierid,
         jh_transactionno");


        //PRINT
        $perusahaan = DB::table("tbmaster_perusahaan")->first();
        $today = date('d-m-Y');
        $time = date('H:i:s');
        return view('FRONTOFFICE\LAPORANKASIR\lap_strk_waktu-pdf',
            ['kodeigr' => $kodeigr, 'date1' => $dateA, 'date2' => $dateB, 'data' => $datas, 'perusahaan' =>$perusahaan,
                'periode' => $periode, 'today' => $today, 'time' => $time]);
    }
}
