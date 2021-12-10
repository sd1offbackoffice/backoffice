<?php

namespace App\Http\Controllers\FRONTOFFICE\LAPORANKASIR\KARTUKREDIT;

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

class KKPerNamaController extends Controller
{
    public function index(){
        return view('FRONTOFFICE.LAPORANKASIR.KARTUKREDIT.kk-per-nama');
    }

    public function cetak(Request $request){
        $tgl1 = $request->tgl1;
        $tgl2 = $request->tgl2;

        $perusahaan = DB::connection(Session::get('connection'))->table('tbmaster_perusahaan')
            ->first();

        $data = DB::connection(Session::get('connection'))->select("SELECT to_char(tglt,'dd/mm/yyyy') tglt, nmcard, ccno, jh_transactionno, jh_cashierid, mesin,
            sum(ccadmfee) ccadmfee, sum(ccamt) ccamt, kasir, memb
        FROM
        (
            SELECT TRUNC(jh_transactiondate) tglt, jh_transactionno, jh_cashierid,
                jh_ccno1 ccno, jh_ccamt1 ccamt,  jh_ccadmfee1 ccadmfee,
                CASE WHEN jh_ccamt1 <> 0 THEN
                       CASE WHEN SUBSTR(jh_ccno1,1,1) = '1' THEN
                               ' BCA'
                       ELSE
                             CASE WHEN SUBSTR(jh_ccno1,1,1) = '5' THEN
                                   ' MASTER'
                             ELSE
                                   CASE WHEN SUBSTR(jh_ccno1,1,1) = '4' THEN
                                          'VISA'
                                    END
                             END
                       END
                ELSE
                       ' '
                END nmcard,
                CASE WHEN jh_cus_kodemember is not null THEN
                          'Y'
                ELSE
                          ' '
                END Memb,
                jh_cashierid||' - '||username kasir, edc_bankname mesin
            FROM TBTR_JUALHEADER, TBMASTER_USER, TBMASTER_EDCMACHINE
            WHERE jh_kodeigr = '".Session::get('kdigr')."'
            AND nvl(trim(jh_recordid),'9') <> '1'
            AND TRUNC(jh_transactiondate) BETWEEN to_date('".$tgl1."','dd/mm/yyyy') AND to_date('".$tgl2."','dd/mm/yyyy')
            AND jh_transactiontype = 'S'
            AND jh_ccno1 IS NOT NULL
            AND kodeigr(+) = jh_kodeigr
            AND userid(+) = jh_cashierid
            AND edc_kodeigr = jh_kodeigr
            AND edc_code = jh_cccode1
        )
        GROUP BY  tglt, ccno, nmcard, jh_transactionno,
                 jh_cashierid, kasir, memb, mesin
        UNION
        SELECT to_char(tglt,'dd/mm/yyyy') tglt, nmcard, ccno, jh_transactionno, jh_cashierid, mesin,
            sum(ccadmfee) ccadmfee, sum(ccamt) ccamt, kasir, memb
        FROM
        (
            SELECT TRUNC(jh_transactiondate) tglt, jh_transactionno, jh_cashierid,
                jh_ccno2 ccno, jh_ccamt2 ccamt, jh_ccadmfee2 ccadmfee,
                CASE WHEN jh_ccamt2 <> 0 THEN
                       CASE WHEN SUBSTR(jh_ccno2,1,1) = '1' THEN
                              ' BCA'
                       ELSE
                             CASE WHEN SUBSTR(jh_ccno2,1,1) = '5' THEN
                                   ' MASTER'
                             ELSE
                                   CASE WHEN SUBSTR(jh_ccno2,1,1) = '4' THEN
                                          'VISA'
                                   END
                             END
                      END
                ELSE
                       ' '
                END nmcard,
                CASE WHEN jh_cus_kodemember is not null THEN
                          'Y'
                ELSE
                          ' '
                END Memb,
                jh_cashierid||' - '||username kasir, edc_bankname mesin
            FROM TBTR_JUALHEADER, TBMASTER_USER, TBMASTER_EDCMACHINE
            WHERE jh_kodeigr = '".Session::get('kdigr')."'
            AND nvl(trim(jh_recordid),'9') <> '1'
            AND TRUNC(jh_transactiondate) BETWEEN to_date('".$tgl1."','dd/mm/yyyy') AND to_date('".$tgl2."','dd/mm/yyyy')
            AND jh_transactiontype = 'S'
            AND jh_ccno2 IS NOT NULL
            AND kodeigr(+) = jh_kodeigr
            AND userid(+) = jh_cashierid
            AND edc_kodeigr = jh_kodeigr
            AND edc_code = jh_cccode2
        )
        GROUP BY  tglt, ccno, nmcard, jh_transactionno,
                 jh_cashierid, kasir, memb, mesin
        ORDER BY tglt, mesin, nmcard, ccno, jh_transactionno");

//        dd($data);

        $dompdf = new PDF();

        $pdf = PDF::loadview('FRONTOFFICE.LAPORANKASIR.KARTUKREDIT.kk-per-nama-pdf',compact(['perusahaan','data','tgl1','tgl2']));

        error_reporting(E_ALL ^ E_DEPRECATED);

        $pdf->output();
        $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);

        $canvas = $dompdf ->get_canvas();
        $canvas->page_text(507, 75.50, "{PAGE_NUM} dari {PAGE_COUNT}", null, 7, array(0, 0, 0));

        $dompdf = $pdf;

        return $dompdf->stream('Laporan Transaksi Kartu Kredit per Nama '.$tgl1.' - '.$tgl2.'.pdf');
    }
}
