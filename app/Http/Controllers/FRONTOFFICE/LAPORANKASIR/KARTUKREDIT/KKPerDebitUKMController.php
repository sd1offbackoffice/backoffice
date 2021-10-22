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

class KKPerDebitUKMController extends Controller
{
    public function index(){
        return view('FRONTOFFICE.LAPORANKASIR.KARTUKREDIT.kk-per-debit-ukm');
    }

    public function getLov(){
        $data = DB::table("tbmaster_user")
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

        $perusahaan = DB::table('tbmaster_perusahaan')
            ->first();

        $data = DB::select("SELECT to_char(TANGGAL, 'dd/mm/yyyy') TANGGAL, IDTRANS, KODE, CARDCODE, SUM (NILAI) NILAI, SUM (JH_CASHADVANCE) TUNAI, NAMAKARTU,
         JENIS
    FROM (SELECT TRUNC (JH_TRANSACTIONDATE) TANGGAL, JH_CASHADVANCE,
                 JH_CASHIERSTATION || '.' || JH_TRANSACTIONNO || '.' || JH_CASHIERID || '-' || USERNAME IDTRANS,
                 JH_DEBITCARDAMT NILAI, SUBSTR (REPLACE (JH_DEBITCARDNO, '-', ''), 1, 6) KODE,
                 JH_DEBITCARDNO CARDCODE, '0' JENIS,
                 CASE
                     WHEN JH_DEBITCARDNO IS NOT NULL
                         THEN CASE
                                 WHEN LENGTH (JH_DEBITCARDNO) = 4
                                     THEN NVL ((SELECT KKR_NAMAKARTU
                                                  FROM TBTABEL_KARTUKREDIT B
                                                 WHERE A.JH_DEBITCARDNO = B.KKR_TIPEKARTU),
                                               'TIDAK TERDAFTAR'
                                              )
                                 ELSE CASE
                                 WHEN SUBSTR (JH_DEBITCARDNO, 6, 2) = '00'
                                     THEN NVL ((SELECT KKR_NAMAKARTU
                                                  FROM TBTABEL_KARTUKREDIT B
                                                 WHERE (SUBSTR (A.JH_DEBITCARDNO, 1, 4) = B.KKR_TIPEKARTU
                                                       OR SUBSTR(REPLACE (A.JH_DEBITCARDNO, '-', ''), 1, 6) = b.kkr_tipekartu)
                                                       AND ROWNUM = 1),
                                               'TIDAK TERDAFTAR'
                                              )
                                 ELSE NVL ((SELECT KKR_NAMAKARTU
                                              FROM TBTABEL_KARTUKREDIT B
                                             WHERE SUBSTR (REPLACE (A.JH_DEBITCARDNO, '-', ''), 1, 6) = B.KKR_TIPEKARTU),
                                           'TIDAK TERDAFTAR'
                                          )
                             END
                             END
                 END NAMAKARTU
            FROM TBTR_JUALHEADER A, TBMASTER_USER
            WHERE jh_kodeigr = '".$_SESSION['kdigr']."'
            AND TRUNC(jh_transactiondate) BETWEEN to_date('".$tgl1."','dd/mm/yyyy') AND to_date('".$tgl2."','dd/mm/yyyy')
             AND NVL (JH_RECORDID, '9') <> '1'
             AND JH_TRANSACTIONTYPE = 'S'
             AND JH_DEBITCARDNO IS NOT NULL
             --AND JH_KMMCODE IS NULL
             AND KODEIGR(+) = JH_KODEIGR
             AND USERID(+) = JH_CASHIERID)
GROUP BY TANGGAL, KODE, IDTRANS, NAMAKARTU, JENIS, CARDCODE
UNION ALL
SELECT to_char(TANGGAL, 'dd/mm/yyyy') TANGGAL, IDTRANS, KODE, CARDCODE, SUM (NILAI) NILAI, 0 TUNAI, NAMAKARTU,
         JENIS
    FROM (SELECT TRUNC (JH_TRANSACTIONDATE) TANGGAL, JH_CASHADVANCE,
                    JH_CASHIERSTATION
                 || '.'
                 || JH_TRANSACTIONNO
                 || '.'
                 || JH_CASHIERID
                 || '-'
                 || USERNAME IDTRANS,
                 JH_KMMAMT NILAI, JH_KMMCODE KODE,
                 JH_KMMVERIFICATION CARDCODE, '0' JENIS,
                 CASE
                     WHEN JH_KMMCODE = '01'
                         THEN 'UKM MANDIRI'
                     WHEN JH_KMMCODE = '02'
                         THEN 'KREDIT BANK INA'
                 END NAMAKARTU
            FROM TBTR_JUALHEADER A, TBMASTER_USER
           WHERE jh_kodeigr = '".$_SESSION['kdigr']."'
            AND TRUNC(jh_transactiondate) BETWEEN to_date('".$tgl1."','dd/mm/yyyy') AND to_date('".$tgl2."','dd/mm/yyyy')
             AND NVL (JH_RECORDID, '9') <> '1'
             AND JH_TRANSACTIONTYPE = 'S'
             AND JH_KMMCODE IS NOT NULL
             --AND JH_DEBITCARDNO IS NULL
             AND JH_KMMAMT<> 0
             AND KODEIGR(+) = JH_KODEIGR
             AND USERID(+) = JH_CASHIERID)
GROUP BY TANGGAL, KODE, IDTRANS, NAMAKARTU, JENIS, CARDCODE
ORDER BY TANGGAL, NAMAKARTU, KODE, IDTRANS");

//        dd($data);

        $dompdf = new PDF();

        $pdf = PDF::loadview('FRONTOFFICE.LAPORANKASIR.KARTUKREDIT.kk-per-debit-ukm-pdf',compact(['perusahaan','data','tgl1','tgl2']));

        error_reporting(E_ALL ^ E_DEPRECATED);

        $pdf->output();
        $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);

        $canvas = $dompdf ->get_canvas();
        $canvas->page_text(507, 75.50, "{PAGE_NUM} dari {PAGE_COUNT}", null, 7, array(0, 0, 0));

        $dompdf = $pdf;

        return $dompdf->stream('Laporan Transaksi Kartu Kredit per Kasir '.$tgl1.' - '.$tgl2.'.pdf');
    }
}
