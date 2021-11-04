<?php

namespace App\Http\Controllers\FRONTOFFICE\LAPORANKASIR\KARTUKREDIT;

use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;
use PDF;
use Symfony\Component\VarDumper\Cloner\Data;
use Yajra\DataTables\DataTables;
use ZipArchive;
use File;

class KKPerKasirController extends Controller
{
    public function index(){
        return view('FRONTOFFICE.LAPORANKASIR.KARTUKREDIT.kk-per-kasir');
    }

    public function getLov(){
        $data = DB::connection($_SESSION['connection'])->table("tbmaster_user")
            ->select('userid','username')
            ->where('kodeigr','=',$_SESSION['kdigr'])
            ->orderBy('userid')
            ->get();

        return DataTables::of($data)->make(true);
    }

    public function cetak(Request $request){
        $tgl1 = $request->tgl1;
        $tgl2 = $request->tgl2;

        if(!$request->kasir1 && !$request->kasir2)
            $kasir = '';
        else $kasir = "AND USERID BETWEEN '".$request->kasir1."' AND '".$request->kasir2."'";

        $perusahaan = DB::connection($_SESSION['connection'])->table('tbmaster_perusahaan')
            ->first();

        $data = DB::connection($_SESSION['connection'])->select("SELECT to_char(tanggal, 'dd/mm/yyyy') tanggal, kasir, jh_cashierstation, jh_transactionno, tipekartu,
      mesin, nokartu, SUM(nilai) nilai, SUM(admfee) admfee, memb, kt_cardname
FROM
(    SELECT TRUNC(jh_transactiondate) tanggal, jh_cashierstation, jh_transactionno,
          jh_cccode1 tipekartu, jh_ccno1 nokartu, jh_ccamt1 nilai, jh_ccadmfee1 admfee,
          kt_cardname, edc_bankname mesin, jh_cashierid||' - '||username kasir,
           CASE WHEN jh_cus_kodemember IS NULL THEN
                  ''
           ELSE
                  'Y'
           END memb
    FROM TBTR_JUALHEADER, TBMASTER_KARTU, TBMASTER_USER,
               TBMASTER_EDCMACHINE
    WHERE jh_kodeigr = '".$_SESSION['kdigr']."'
    AND TRUNC(jh_transactiondate) BETWEEN to_date('".$tgl1."','dd/mm/yyyy') AND to_date('".$tgl2."','dd/mm/yyyy')
    AND NVL(jh_recordid,'9') <> '1'
    AND jh_transactiontype = 'S'
    AND jh_ccamt1 > 0
    ".$kasir."
    AND kt_kodeigr = jh_kodeigr
    AND kt_initialcardno = SUBSTR(jh_ccno1,1,1)
    AND edc_kodeigr(+) = jh_kodeigr
    AND edc_code(+) = jh_cccode1
    AND kodeigr(+) = jh_kodeigr
    AND userid(+) = jh_cashierid
)
GROUP BY tanggal, jh_transactionno, kasir, jh_cashierstation,
                  tipekartu, mesin, nokartu, memb, kt_cardname
UNION
SELECT to_char(tanggal, 'dd/mm/yyyy') tanggal, kasir, jh_cashierstation, jh_transactionno, tipekartu,
      mesin, nokartu, SUM(nilai) nilai, SUM(admfee) admfee, memb, kt_cardname
FROM
(    SELECT TRUNC(jh_transactiondate) tanggal, jh_cashierstation, jh_transactionno,
          jh_cccode2 tipekartu, jh_ccno2 nokartu, jh_ccamt2 nilai, jh_ccadmfee2 admfee,
          kt_cardname, username, edc_bankname mesin, jh_cashierid||' - '||username kasir,
          CASE WHEN jh_cus_kodemember IS NULL THEN
                  ''
           ELSE
                  'Y'
           END memb
    FROM TBTR_JUALHEADER, TBMASTER_KARTU, TBMASTER_USER,
               TBMASTER_EDCMACHINE
    WHERE jh_kodeigr = '".$_SESSION['kdigr']."'
    AND TRUNC(jh_transactiondate) BETWEEN to_date('".$tgl1."','dd/mm/yyyy') AND to_date('".$tgl2."','dd/mm/yyyy')
    AND NVL(jh_recordid,'9') <> '1'
    AND jh_transactiontype = 'S'
    AND jh_ccamt2 > 0
    ".$kasir."
    AND kt_kodeigr = jh_kodeigr
    AND kt_initialcardno = SUBSTR(jh_ccno2,1,1)
    AND edc_kodeigr(+) = jh_kodeigr
    AND edc_code(+) = jh_cccode2
    AND kodeigr(+) = jh_kodeigr
    AND userid(+) = jh_cashierid
)
GROUP BY tanggal, jh_transactionno, kasir, jh_cashierstation,
                  tipekartu, mesin, nokartu, memb, kt_cardname
    ORDER BY tanggal, kasir, kt_cardname, jh_transactionno");

//        dd($data);

        $dompdf = new PDF();

        $pdf = PDF::loadview('FRONTOFFICE.LAPORANKASIR.KARTUKREDIT.kk-per-kasir-pdf',compact(['perusahaan','data','tgl1','tgl2']));

        error_reporting(E_ALL ^ E_DEPRECATED);

        $pdf->output();
        $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);

        $canvas = $dompdf ->get_canvas();
        $canvas->page_text(507, 75.50, "{PAGE_NUM} dari {PAGE_COUNT}", null, 7, array(0, 0, 0));

        $dompdf = $pdf;

        return $dompdf->stream('Laporan Transaksi Kartu Kredit per Kasir '.$tgl1.' - '.$tgl2.'.pdf');
    }
}
