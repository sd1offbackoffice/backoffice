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

class OutsScanController extends Controller
{

    public function index()
    {
        return view('BACKOFFICE.LAPORAN.outsscan');
    }
    public function CheckData(Request $request){
        $kodeigr = $_SESSION['kdigr'];
        $date = $request->date;
        $theDate = DateTime::createFromFormat('d-m-Y', $date)->format('d-m-Y');

        $cursor = DB::connection($_SESSION['connection'])->select("select rownum nomor, prs_namaperusahaan, prs_Namacabang, PRD_PRDCD, PRD_DESKRIPSIPANJANG, UNIT, Periode, qty from (
SELECT   prs_namaperusahaan, prs_Namacabang, PRD_PRDCD, PRD_DESKRIPSIPANJANG, UNIT, Periode, SUM (PBO_QTYREALISASI) qty
    FROM (SELECT PBO_KODEOMI, PBO_NOPB, PBO_TGLPB, PRD_PRDCD, PRD_DESKRIPSIPANJANG,  'Periode s/d : ' || to_char(TO_DATE('$theDate','dd-MM-YYYY'), 'dd-MM-yyyy') Periode,
                 PRD_UNIT || '/' || PRD_FRAC UNIT, PBO_QTYREALISASI, PBO_TTLNILAI, PBO_TTLPPN
            FROM TBMASTER_PBOMI, TBTR_REALPB, TBMASTER_PRODMAST
           WHERE PBO_NOPB = RPB_NODOKUMEN(+)
             AND PBO_TGLPB = RPB_TGLDOKUMEN(+)
             AND PBO_KODEOMI = RPB_KODEOMI(+)
             AND PBO_NOKOLI = RPB_NOKOLI(+)
             AND SUBSTR (PBO_PLUIGR, 1, 6) || '0' = PRD_PRDCD
             AND PBO_KODEIGR = PRD_KODEIGR
             AND RPB_IDSURATJALAN IS NULL
             AND TRUNC(PBO_CREATE_DT) >= TRUNC (TO_DATE('$theDate','dd-MM-YYYY')) - 7
             AND PBO_NOKOLI IS NOT NULL) A, tbmaster_perusahaan
GROUP BY prs_namaperusahaan, prs_Namacabang, PRD_PRDCD, PRD_DESKRIPSIPANJANG, UNIT, periode
order by prd_prdcd ) b");
        if(!$cursor){
            return response()->json(['kode' => 0]);
        }else{
            return response()->json(['kode' => 1]);
        }
    }
    public function printDocument(Request $request){
        $kodeigr = $_SESSION['kdigr'];
        $today = date('d-m-Y');
        $date = $request->date;
        $theDate = DateTime::createFromFormat('d-m-Y', $date)->format('d-m-Y');

    $datas = DB::connection($_SESSION['connection'])->select("select rownum nomor, prs_namaperusahaan, prs_Namacabang, PRD_PRDCD, PRD_DESKRIPSIPANJANG, UNIT, Periode, qty from (
SELECT   prs_namaperusahaan, prs_Namacabang, PRD_PRDCD, PRD_DESKRIPSIPANJANG, UNIT, Periode, SUM (PBO_QTYREALISASI) qty
    FROM (SELECT PBO_KODEOMI, PBO_NOPB, PBO_TGLPB, PRD_PRDCD, PRD_DESKRIPSIPANJANG,  'Periode s/d : ' || to_char(TO_DATE('$theDate','dd-MM-YYYY'), 'dd-MM-yyyy') Periode,
                 PRD_UNIT || '/' || PRD_FRAC UNIT, PBO_QTYREALISASI, PBO_TTLNILAI, PBO_TTLPPN
            FROM TBMASTER_PBOMI, TBTR_REALPB, TBMASTER_PRODMAST
           WHERE PBO_NOPB = RPB_NODOKUMEN(+)
             AND PBO_TGLPB = RPB_TGLDOKUMEN(+)
             AND PBO_KODEOMI = RPB_KODEOMI(+)
             AND PBO_NOKOLI = RPB_NOKOLI(+)
             AND SUBSTR (PBO_PLUIGR, 1, 6) || '0' = PRD_PRDCD
             AND PBO_KODEIGR = PRD_KODEIGR
             AND RPB_IDSURATJALAN IS NULL
             AND TRUNC(PBO_CREATE_DT) >= TRUNC (TO_DATE('$theDate','dd-MM-YYYY')) - 7
             AND PBO_NOKOLI IS NOT NULL) A, tbmaster_perusahaan
GROUP BY prs_namaperusahaan, prs_Namacabang, PRD_PRDCD, PRD_DESKRIPSIPANJANG, UNIT, periode
order by prd_prdcd ) b");
        //PRINT
        $pdf = PDF::loadview('BACKOFFICE.LAPORAN.outsscan-pdf',
            ['kodeigr' => $kodeigr, 'p_tgl' => $date, 'datas' => $datas, 'today' => $today]);
        $pdf->setPaper('A4', 'potrait');
        $pdf->output();
        $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);

        $canvas = $dompdf ->get_canvas();
        $canvas->page_text(546, 10, "Hal {PAGE_NUM} / {PAGE_COUNT}", null, 8, array(0, 0, 0));

        return $pdf->stream('outsscan.pdf');
    }
}
