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

class rkprefundksrController extends Controller
{

    public function index()
    {
        return view('FRONTOFFICE.LAPORANKASIR.rkprefundksr');
    }

    public function print(Request $request)
    {
        $kodeigr = $_SESSION['kdigr'];
        $dateA = $request->date1;
        $dateB = $request->date2;
        $sDate = DateTime::createFromFormat('d-m-Y', $dateA)->format('d-m-Y');
        $eDate = DateTime::createFromFormat('d-m-Y', $dateB)->format('d-m-Y');

        $datas = DB::connection($_SESSION['connection'])->select("SELECT tanggal, jh_transactionno,jh_referenceno, tglrefund,
      jh_referencecashierid, username, SUM(jh_transactionamt) nilai,
      prs_namaperusahaan, prs_namacabang, prs_namawilayah
FROM
(    SELECT TRUNC(jh_transactiondate) tanggal, jh_transactionno,
          jh_referenceno, TRUNC(jh_referencedate) tglrefund,
          jh_referencecashierid, jh_transactionamt, username,
          prs_namaperusahaan, prs_namacabang, prs_namawilayah
    FROM TBTR_JUALHEADER, TBMASTER_USER,TBMASTER_PERUSAHAAN
    WHERE jh_kodeigr = '$kodeigr'
    AND TRUNC(jh_transactiondate) BETWEEN TO_DATE('$sDate','DD-MM-YYYY') AND TO_DATE('$eDate', 'DD-MM-YYYY')
    AND NVL(jh_recordid,'9') <> '1'
    AND jh_transactiontype = 'R'
    AND kodeigr(+) = jh_kodeigr
    AND userid(+) = jh_referencecashierid
    AND prs_kodeigr = jh_kodeigr
)
GROUP BY tanggal, jh_transactionno,jh_referenceno, tglrefund,
                  jh_referencecashierid, username,
                  prs_namaperusahaan, prs_namacabang, prs_namawilayah
ORDER BY tglrefund, tanggal, jh_referencecashierid");
        if(sizeof($datas) == 0){
            return "**DATA TIDAK ADA**";
        }

        //mengisi array val untuk disort manual
        for($i=0;$i<sizeof($datas);$i++){
            $val['tgl_refund'][$i] = $datas[$i]->tanggal;
            $val['cashierid'][$i] = $datas[$i]->jh_referencecashierid;
            $val['cashiername'][$i] = $datas[$i]->username;
            $val['no_trn'][$i] = $datas[$i]->jh_referenceno;
            $val['tgl_trn'][$i] = $datas[$i]->tglrefund;
            $val['nilai'][$i] = $datas[$i]->nilai;
        }

        // Algoritma Insertion Sort
        for($i=0;$i<sizeof($datas);$i++){
            $fixer = new DateTime($datas[$i]->tanggal);
            for($j=$i;$j<sizeof($datas);$j++){
                $comparer = new DateTime($datas[$j]->tanggal);
                if($fixer > $comparer){
                    $fixer = $comparer;
                    $swap = $val['tgl_refund'][$i];
                    $val['tgl_refund'][$i] = $val['tgl_refund'][$j];
                    $val['tgl_refund'][$j] = $swap;

                    $swap = $val['cashierid'][$i];
                    $val['cashierid'][$i] = $val['cashierid'][$j];
                    $val['cashierid'][$j] = $swap;

                    $swap = $val['cashiername'][$i];
                    $val['cashiername'][$i] = $val['cashiername'][$j];
                    $val['cashiername'][$j] = $swap;

                    $swap = $val['no_trn'][$i];
                    $val['no_trn'][$i] = $val['no_trn'][$j];
                    $val['no_trn'][$j] = $swap;

                    $swap = $val['tgl_trn'][$i];
                    $val['tgl_trn'][$i] = $val['tgl_trn'][$j];
                    $val['tgl_trn'][$j] = $swap;

                    $swap = $val['nilai'][$i];
                    $val['nilai'][$i] = $val['nilai'][$j];
                    $val['nilai'][$j] = $swap;
                }
            }
        }


        //PRINT
        $today = date('d-m-Y');
        $time = date('H:i:s');
        $perusahaan = DB::connection($_SESSION['connection'])->table("tbmaster_perusahaan")->first();

        $pdf = PDF::loadview('FRONTOFFICE.LAPORANKASIR.rkprefundksr-pdf',
            ['kodeigr' => $kodeigr, 'date1' => $dateA, 'date2' => $dateB, 'data' => $datas, 'perusahaan' => $perusahaan, 'val' => $val,
                'today' => $today, 'time' => $time]);
        $pdf->setPaper('A4', 'potrait');
        $pdf->output();
        $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);

        $canvas = $dompdf->get_canvas();
        $canvas->page_text(511, 78, "{PAGE_NUM} / {PAGE_COUNT}", null, 7, array(0, 0, 0));

        return $pdf->stream('FRONTOFFICE.LAPORANKASIR.rkprefundksr-pdf');

    }

}
