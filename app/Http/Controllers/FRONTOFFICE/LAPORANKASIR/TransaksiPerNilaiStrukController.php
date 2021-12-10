<?php

namespace App\Http\Controllers\FRONTOFFICE\LAPORANKASIR;

use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller; use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;
use PDF;
use Yajra\DataTables\DataTables;
use ZipArchive;
use File;

class TransaksiPerNilaiStrukController extends Controller
{
    public function index()
    {
        return view('FRONTOFFICE.LAPORANKASIR.TRANSAKSIPERNILAISTRUK.transaksipernilaistruk');
    }

    public function cetak(Request $request)
    {
        $startDate = $request->tanggal1;
        $endDate = $request->tanggal2;
        $bb1 = $request->bb1;
        $ba1 = $request->ba1;
        $bb2 = $request->bb2;
        $ba2 = $request->ba2;
        $bb3 = $request->bb3;
        $ba3 = $request->ba3;
        $bb4 = $request->bb4;
        $ba4 = $request->ba4;
        $bb5 = $request->bb5;
        $ba5 = $request->ba5;
        $bb6 = $request->bb6;
        $ba6 = $request->ba6;
        $bb7 = $request->bb7;
        $ba7 = $request->ba7;
        $bb8 = $request->bb8;
        $ba8 = $request->ba8;
        $bb9 = $request->bb9;
        $ba9 = $request->ba9;
        $bb10 = $request->bb10;
        $ba10 = $request->ba10;
        $member = $request->member;

        $p_memb='';

        $perusahaan = DB::connection(Session::get('connection'))->table('tbmaster_perusahaan')
            ->first();

        $periode = 'DARI TANGGAL: ' . $startDate . ' S/D ' . $endDate;
        if ($member == 'BIRU') {
            $p_memb = " and nvl(cus_flagmemberkhusus, 'N') <> 'Y'";
        } else if ($member == 'MERAH') {
            $p_memb = " and nvl(cus_flagmemberkhusus, 'N') = 'Y'";
        }

        $data = DB::connection(Session::get('connection'))->select("SELECT prs_namaperusahaan, prs_namacabang, jh_transactiondate,
	   SUM(aAmount1) sa1, SUM(aAmount2) sa2, SUM(aAmount3) sa3, SUM(aAmount4) sa4, SUM(aAmount5) sa5,
	   SUM(aAmount6) sa6, SUM(aAmount7) sa7, SUM(aAmount8) sa8, SUM(aAmount9) sa9, SUM(aAmount10) sa10,
	   SUM(aNum1) sn1, SUM(aNum2) sn2, SUM(aNum3) sn3, SUM(aNum4) sn4, SUM(aNum5) sn5,
	   SUM(aNum6) sn6, SUM(aNum7) sn7, SUM(aNum8) sn8, SUM(aNum9) sn9, SUM(aNum10) sn10
FROM TBMASTER_PERUSAHAAN,
(	SELECT jh_kodeigr kodeigr, TRUNC(jh_transactiondate) jh_transactiondate, jh_cus_kodemember,
		   CASE WHEN JH_TRANSACTIONAMT BETWEEN " . $bb1 . "   AND " . $ba1 . "   THEN JH_TRANSACTIONAMT ELSE 0 END aAmount1,
		   CASE WHEN JH_TRANSACTIONAMT BETWEEN " . $bb2 . "   AND " . $ba2 . "  THEN JH_TRANSACTIONAMT ELSE 0 END aAmount2,
		   CASE WHEN JH_TRANSACTIONAMT BETWEEN " . $bb3 . "   AND " . $ba3 . "  THEN JH_TRANSACTIONAMT ELSE 0 END aAmount3,
		   CASE WHEN JH_TRANSACTIONAMT BETWEEN " . $bb4 . "   AND " . $ba4 . "  THEN JH_TRANSACTIONAMT ELSE 0 END aAmount4,
		   CASE WHEN JH_TRANSACTIONAMT BETWEEN " . $bb5 . "   AND " . $ba5 . "  THEN JH_TRANSACTIONAMT ELSE 0 END aAmount5,
		   CASE WHEN JH_TRANSACTIONAMT BETWEEN " . $bb6 . "   AND " . $ba6 . "  THEN JH_TRANSACTIONAMT ELSE 0 END aAmount6,
		   CASE WHEN JH_TRANSACTIONAMT BETWEEN " . $bb7 . "   AND " . $ba7 . "  THEN JH_TRANSACTIONAMT ELSE 0 END aAmount7,
		   CASE WHEN JH_TRANSACTIONAMT BETWEEN " . $bb8 . "   AND " . $ba8 . "  THEN JH_TRANSACTIONAMT ELSE 0 END aAmount8,
		   CASE WHEN JH_TRANSACTIONAMT BETWEEN " . $bb9 . "   AND " . $ba9 . "  THEN JH_TRANSACTIONAMT ELSE 0 END aAmount9,
		   CASE WHEN JH_TRANSACTIONAMT BETWEEN " . $bb10 . "  AND " . $ba10 . " THEN JH_TRANSACTIONAMT ELSE 0 END aAmount10,
		   CASE WHEN JH_TRANSACTIONAMT BETWEEN " . $bb1 . "   AND " . $ba1 . "  THEN 1 ELSE 0 END aNum1,
		   CASE WHEN JH_TRANSACTIONAMT BETWEEN " . $bb2 . "   AND " . $ba2 . "  THEN 1 ELSE 0 END aNum2,
		   CASE WHEN JH_TRANSACTIONAMT BETWEEN " . $bb3 . "   AND " . $ba3 . "  THEN 1 ELSE 0 END aNum3,
		   CASE WHEN JH_TRANSACTIONAMT BETWEEN " . $bb4 . "   AND " . $ba4 . "  THEN 1 ELSE 0 END aNum4,
		   CASE WHEN JH_TRANSACTIONAMT BETWEEN " . $bb5 . "   AND " . $ba5 . "  THEN 1 ELSE 0 END aNum5,
		   CASE WHEN JH_TRANSACTIONAMT BETWEEN " . $bb6 . "   AND " . $ba6 . "  THEN 1 ELSE 0 END aNum6,
		   CASE WHEN JH_TRANSACTIONAMT BETWEEN " . $bb7 . "   AND " . $ba7 . "  THEN 1 ELSE 0 END aNum7,
		   CASE WHEN JH_TRANSACTIONAMT BETWEEN " . $bb8 . "   AND " . $ba8 . "  THEN 1 ELSE 0 END aNum8,
		   CASE WHEN JH_TRANSACTIONAMT BETWEEN " . $bb9 . "   AND " . $ba9 . "  THEN 1 ELSE 0 END aNum9,
		   CASE WHEN JH_TRANSACTIONAMT BETWEEN " . $bb10 . "  AND " . $ba10 . " THEN 1 ELSE 0 END aNum10
	FROM TBTR_JUALHEADER, tbmaster_customer
	WHERE TRUNC(jh_transactiondate) BETWEEN to_date('" . $startDate . "','dd/mm/yyyy') AND to_date('" . $endDate . "','dd/mm/yyyy')
	  AND jh_recordid IS NULL
	  AND jh_transactiontype = 'S'
                  AND cus_kodemember = jh_cus_kodemember
                  " . $p_memb . "
)
WHERE prs_kodeigr = '" . Session::get('kdigr') . "'
  AND kodeigr = prs_kodeigr
GROUP BY prs_namaperusahaan, prs_namacabang, jh_transactiondate
ORDER BY jh_transactiondate");

        $dompdf = new PDF();

        $pdf = PDF::loadview('FRONTOFFICE.LAPORANKASIR.TRANSAKSIPERNILAISTRUK.transaksipernilaistruk-pdf', compact(['perusahaan', 'data', 'periode','member','bb1','ba1','bb2','ba2','bb3','ba3','bb4','ba4','bb5','ba5','bb6','ba6','bb7','ba7','bb8','ba8','bb9','ba9','bb10','ba10']));

        error_reporting(E_ALL ^ E_DEPRECATED);

        $pdf->output();
        $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);

        $canvas = $dompdf->get_canvas();
        $canvas->page_text(755, 77.5, "{PAGE_NUM} dari {PAGE_COUNT}", null, 7, array(0, 0, 0));

        $dompdf = $pdf;

        return $dompdf->stream('Laporan Transaksi Per Nilai Struk - ' . $startDate . '-' . $endDate . '.pdf');
//        return $dompdf->generate('http://www.google.com', '/tmp/testPdf.pdf');


    }
}
