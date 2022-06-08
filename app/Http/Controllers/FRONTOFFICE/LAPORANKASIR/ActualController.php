<?php

namespace App\Http\Controllers\FRONTOFFICE\LAPORANKASIR;

use App\Http\Controllers\Auth\loginController;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller; use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;
use PDF;
use PhpOffice\PhpSpreadsheet\Reader\Html;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Yajra\DataTables\DataTables;
use ZipArchive;
use File;

class ActualController extends Controller
{
    public function index(){
        return view('FRONTOFFICE.LAPORANKASIR.ACTUAL.actual');
    }

    public function prosesSales($tanggal){
        try{
            DB::connection(Session::get('connection'))->beginTransaction();

            $nilait = 0;
            $taxt = 0;
            $nett = 0;
            $hppt = 0;
            $margint = 0;
            $pmargint = 0;
            $nilait_tepung = 0;
            $taxt_tepung = 0;
            $nett_tepung = 0;
            $hppt_tepung = 0;
            $margint_tepung = 0;

            $totalCounter = DB::connection(Session::get('connection'))->select("SELECT NVL(SUM(NILAI),0) NILAI, NVL(SUM(TAX),0) TAX, NVL(SUM(NET),0) NET,
	NVL(SUM(HPP),0) HPP, NVL(SUM(MARGIN),0) MARGIN,
	CASE WHEN NVL(SUM(NET),0) <> 0 THEN ((NVL(SUM(MARGIN),0) * 100 ) / NVL(SUM(NET),0)) ELSE
	CASE WHEN NVL(SUM(MARGIN),0) <> 0 THEN 100 ELSE 0 END END PMARGIN FROM (
	SELECT SLS_FLAGBKP, (SLS_NILAIOMI + SLS_NILAINOMI + SLS_NILAIIDM) NILAI, (SLS_TAXOMI + SLS_TAXNOMI + SLS_TAXIDM) TAX,
	(SLS_NETOMI + SLS_NETNOMI + SLS_NETIDM) NET, (SLS_HPPOMI + SLS_HPPNOMI + SLS_HPPIDM) HPP,
	(SLS_MARGINOMI + SLS_MARGINNOMI + SLS_MARGINIDM) MARGIN FROM TBTR_SUMSALES
	WHERE SLS_KODEIGR = '".Session::get('kdigr')."' AND TRUNC(SLS_PERIODE) = to_date('".$tanggal."','dd/mm/yyyy')
	AND SLS_KODEDIVISI = '5' AND SLS_KODEDEPARTEMENT IN ('39', '43') ) A")[0];

            $totalCounter->keterangan = 'TOTAL COUNTER';

            DB::connection(Session::get('connection'))->table('cetak_sums')
                ->insert(json_decode(json_encode($totalCounter), true));

            $nilait += $totalCounter->nilai;
            $taxt += $totalCounter->tax;
            $nett += $totalCounter->net;
            $hppt += $totalCounter->hpp;
            $margint += $totalCounter->margin;
            $pmargint += $totalCounter->pmargin;

            $kenaPajak = DB::connection(Session::get('connection'))->select("SELECT NVL(SUM(NILAI),0) NILAI, NVL(SUM(TAX),0) TAX, NVL(SUM(NET),0) NET,
	NVL(SUM(HPP),0) HPP, NVL(SUM(MARGIN),0) MARGIN,
	CASE WHEN NVL(SUM(NET),0) <> 0 THEN ((NVL(SUM(MARGIN),0) * 100 ) / NVL(SUM(NET),0)) ELSE
	CASE WHEN NVL(SUM(MARGIN),0) <> 0 THEN 100 ELSE 0 END END PMARGIN FROM (
	SELECT SLS_FLAGBKP, (SLS_NILAIOMI + SLS_NILAINOMI + SLS_NILAIIDM) NILAI, (SLS_TAXOMI + SLS_TAXNOMI + SLS_TAXIDM) TAX,
	(SLS_NETOMI + SLS_NETNOMI + SLS_NETIDM) NET, (SLS_HPPOMI + SLS_HPPNOMI + SLS_HPPIDM) HPP,
	(SLS_MARGINOMI + SLS_MARGINNOMI + SLS_MARGINIDM) MARGIN FROM TBTR_SUMSALES
	WHERE SLS_KODEIGR = '".Session::get('kdigr')."' AND TRUNC(SLS_PERIODE) = to_date('".$tanggal."','dd/mm/yyyy')
	AND SLS_KODEDIVISI <>  '5' AND SLS_KODEDEPARTEMENT NOT IN ('39', '40', '43')
	AND SLS_FLAGBKP = 'Y' ) A")[0];

            $kenaPajak->keterangan = 'TOTAL BARANG KENA PAJAK';

            DB::connection(Session::get('connection'))->table('cetak_sums')
                ->insert(json_decode(json_encode($kenaPajak), true));

            $nilait += $kenaPajak->nilai;
            $taxt += $kenaPajak->tax;
            $nett += $kenaPajak->net;
            $hppt += $kenaPajak->hpp;
            $margint += $kenaPajak->margin;
            $pmargint += $kenaPajak->pmargin;

            $nonPajak = DB::connection(Session::get('connection'))->select("SELECT NVL(SUM(NILAI),0) NILAI, NVL(SUM(TAX),0) TAX, NVL(SUM(NET),0) NET,
	NVL(SUM(HPP),0) HPP, NVL(SUM(MARGIN),0) MARGIN,
	CASE WHEN NVL(SUM(NET),0) <> 0 THEN ((NVL(SUM(MARGIN),0) * 100 ) / NVL(SUM(NET),0)) ELSE
	CASE WHEN NVL(SUM(MARGIN),0) <> 0 THEN 100 ELSE 0 END END PMARGIN FROM (
	SELECT * FROM (
	SELECT SLS_PRDCD, EXP_PRDCD, (SLS_NILAIOMI + SLS_NILAINOMI + SLS_NILAIIDM) NILAI, (SLS_TAXOMI + SLS_TAXNOMI + SLS_TAXIDM) TAX,
	(SLS_NETOMI + SLS_NETNOMI + SLS_NETIDM) NET, (SLS_HPPOMI + SLS_HPPNOMI + SLS_HPPIDM) HPP,
	(SLS_MARGINOMI + SLS_MARGINNOMI + SLS_MARGINIDM) MARGIN FROM TBTR_SUMSALES, TBMASTER_BARANGEXPORT
	WHERE SLS_KODEIGR = '".Session::get('kdigr')."' AND TRUNC(SLS_PERIODE) = to_date('".$tanggal."','dd/mm/yyyy')
	AND SLS_KODEDIVISI <>  '5' AND SLS_KODEDEPARTEMENT NOT IN ('39', '40', '43')
	AND SLS_FLAGBKP NOT IN ('P', 'G', 'W', 'Y', 'C')
	AND EXP_KODEIGR(+) = '05' AND EXP_PRDCD(+) = SLS_PRDCD ) A
	WHERE EXP_PRDCD IS NULL ) B")[0];

            $nonPajak->keterangan = 'TOTAL BARANG TIDAK KENA PAJAK';

            DB::connection(Session::get('connection'))->table('cetak_sums')
                ->insert(json_decode(json_encode($nonPajak), true));

            $nilait += $nonPajak->nilai;
            $taxt += $nonPajak->tax;
            $nett += $nonPajak->net;
            $hppt += $nonPajak->hpp;
            $margint += $nonPajak->margin;
            $pmargint += $nonPajak->pmargin;

            $cukai = DB::connection(Session::get('connection'))->select("SELECT NVL(SUM(NILAI),0) NILAI, NVL(SUM(TAX),0) TAX, NVL(SUM(NET),0) NET,
	NVL(SUM(HPP),0) HPP, NVL(SUM(MARGIN),0) MARGIN,
	CASE WHEN NVL(SUM(NET),0) <> 0 THEN ((NVL(SUM(MARGIN),0) * 100 ) / NVL(SUM(NET),0)) ELSE
	CASE WHEN NVL(SUM(MARGIN),0) <> 0 THEN 100 ELSE 0 END END PMARGIN FROM (
	SELECT SLS_FLAGBKP, (SLS_NILAIOMI + SLS_NILAINOMI + SLS_NILAIIDM) NILAI, (SLS_TAXOMI + SLS_TAXNOMI + SLS_TAXIDM) TAX,
	(SLS_NETOMI + SLS_NETNOMI + SLS_NETIDM) NET, (SLS_HPPOMI + SLS_HPPNOMI + SLS_HPPIDM) HPP,
	(SLS_MARGINOMI + SLS_MARGINNOMI + SLS_MARGINIDM) MARGIN FROM TBTR_SUMSALES
	WHERE SLS_KODEIGR = '".Session::get('kdigr')."' AND TRUNC(SLS_PERIODE) = to_date('".$tanggal."','dd/mm/yyyy') AND SLS_KODEDIVISI <>  '5' AND SLS_KODEDEPARTEMENT NOT IN ('39', '40', '43')
	AND SLS_FLAGBKP = 'C' ) A")[0];

            $cukai->keterangan = 'TOTAL BARANG KENA CUKAI';

            DB::connection(Session::get('connection'))->table('cetak_sums')
                ->insert(json_decode(json_encode($cukai), true));

            $nilait += $cukai->nilai;
            $taxt += $cukai->tax;
            $nett += $cukai->net;
            $hppt += $cukai->hpp;
            $margint += $cukai->margin;
            $pmargint += $cukai->pmargin;

            $nonPpn = DB::connection(Session::get('connection'))->select("SELECT NVL(SUM(NILAI),0) NILAI, NVL(SUM(TAX),0) TAX, (NVL(SUM(NET),0) - NVL(SUM(TAX),0)) NET,
	NVL(SUM(HPP),0) HPP, NVL(SUM(MARGIN),0) MARGIN,
	CASE WHEN NVL(SUM(NET),0) <> 0 THEN ((NVL(SUM(MARGIN),0) * 100 ) / NVL(SUM(NET),0)) ELSE
	CASE WHEN NVL(SUM(MARGIN),0) <> 0 THEN 100 ELSE 0 END END PMARGIN FROM (
	SELECT SLS_FLAGBKP, (SLS_NILAIOMI + SLS_NILAINOMI + SLS_NILAIIDM) NILAI, (SLS_TAXOMI + SLS_TAXNOMI + SLS_TAXIDM) TAX,
	(SLS_NETOMI + SLS_NETNOMI + SLS_NETIDM) NET, (SLS_HPPOMI + SLS_HPPNOMI + SLS_HPPIDM) HPP,
	(SLS_MARGINOMI + SLS_MARGINNOMI + SLS_MARGINIDM) MARGIN FROM TBTR_SUMSALES
	WHERE SLS_KODEIGR = '".Session::get('kdigr')."' AND TRUNC(SLS_PERIODE) = to_date('".$tanggal."','dd/mm/yyyy') AND SLS_KODEDIVISI <>  '5' AND SLS_KODEDEPARTEMENT NOT IN ('39', '40', '43')
	AND SLS_FLAGBKP = 'P' ) A")[0];

            $nonPpn->keterangan = 'TOTAL BARANG BEBAS PPN';

            DB::connection(Session::get('connection'))->table('cetak_sums')
                ->insert(json_decode(json_encode($nonPpn), true));

            $nilait += $nonPpn->nilai;
            $taxt += $nonPpn->tax;
            $nett += $nonPpn->net;
            $hppt += $nonPpn->hpp;
            $margint += $nonPpn->margin;
            $pmargint += $nonPpn->pmargin;

            $export = DB::connection(Session::get('connection'))->select("SELECT NVL(SUM(NILAI),0) NILAI, NVL(SUM(TAX),0) TAX, NVL(SUM(NET),0) NET, NVL(SUM(HPP),0) HPP, NVL(SUM(MARGIN),0) MARGIN,
	CASE WHEN NVL(SUM(NET),0) <> 0 THEN ((NVL(SUM(MARGIN),0) * 100 ) / NVL(SUM(NET),0)) ELSE
	CASE WHEN NVL(SUM(MARGIN),0) <> 0 THEN 100 ELSE 0 END END PMARGIN FROM (
	SELECT * FROM (
	SELECT SLS_PRDCD, EXP_PRDCD, (SLS_NILAIOMI + SLS_NILAINOMI + SLS_NILAIIDM) NILAI, (SLS_TAXOMI + SLS_TAXNOMI + SLS_TAXIDM) TAX,
	(SLS_NETOMI + SLS_NETNOMI + SLS_NETIDM) NET, (SLS_HPPOMI + SLS_HPPNOMI + SLS_HPPIDM) HPP,
	(SLS_MARGINOMI + SLS_MARGINNOMI + SLS_MARGINIDM) MARGIN FROM TBTR_SUMSALES, TBMASTER_BARANGEXPORT
	WHERE SLS_KODEIGR = '".Session::get('kdigr')."' AND TRUNC(SLS_PERIODE) = to_date('".$tanggal."','dd/mm/yyyy') AND SLS_KODEDIVISI <>  '5' AND SLS_KODEDEPARTEMENT NOT IN ('39', '40', '43')
	AND SLS_FLAGBKP NOT IN ('P', 'G', 'W', 'Y', 'C')
	AND EXP_KODEIGR(+) = '05' AND EXP_PRDCD(+) = SLS_PRDCD ) A
	WHERE EXP_PRDCD IS NOT NULL ) B")[0];

            $export->keterangan = 'TOTAL BARANG EXPORT';

            DB::connection(Session::get('connection'))->table('cetak_sums')
                ->insert(json_decode(json_encode($export), true));

            $nilait += $export->nilai;
            $taxt += $export->tax;
            $nett += $export->net;
            $hppt += $export->hpp;
            $margint += $export->margin;
            $pmargint += $export->pmargin;

            $ppnMinyak = DB::connection(Session::get('connection'))->select("SELECT NVL(SUM(NILAI),0) NILAI, NVL(SUM(TAX),0) TAX, (NVL(SUM(NET),0) - NVL(SUM(TAX),0)) NET,
	NVL(SUM(HPP),0) HPP, NVL(SUM(MARGIN),0) MARGIN,
	CASE WHEN NVL(SUM(NET),0) <> 0 THEN ((NVL(SUM(MARGIN),0) * 100 ) / NVL(SUM(NET),0)) ELSE
	CASE WHEN NVL(SUM(MARGIN),0) <> 0 THEN 100 ELSE 0 END END PMARGIN FROM (
	SELECT SLS_FLAGBKP, (SLS_NILAIOMI + SLS_NILAINOMI + SLS_NILAIIDM) NILAI, (SLS_TAXOMI + SLS_TAXNOMI + SLS_TAXIDM) TAX,
	(SLS_NETOMI + SLS_NETNOMI + SLS_NETIDM) NET, (SLS_HPPOMI + SLS_HPPNOMI + SLS_HPPIDM) HPP,
	(SLS_MARGINOMI + SLS_MARGINNOMI + SLS_MARGINIDM) MARGIN FROM TBTR_SUMSALES
	WHERE SLS_KODEIGR = '".Session::get('kdigr')."' AND TRUNC(SLS_PERIODE) = to_date('".$tanggal."','dd/mm/yyyy')
	AND SLS_KODEDIVISI <>  '5' AND SLS_KODEDEPARTEMENT NOT IN ('39', '40', '43')
	AND SLS_FLAGBKP = 'G' ) A")[0];


    $ppnTepung = DB::connection(Session::get('connection'))->select("SELECT NVL(SUM(NILAI),0) NILAI, NVL(SUM(TAX),0) TAX, (NVL(SUM(NET),0) - NVL(SUM(TAX),0)) NET,
	NVL(SUM(HPP),0) HPP, NVL(SUM(MARGIN),0) MARGIN,
	CASE WHEN NVL(SUM(NET),0) <> 0 THEN ((NVL(SUM(MARGIN),0) * 100 ) / NVL(SUM(NET),0)) ELSE
	CASE WHEN NVL(SUM(MARGIN),0) <> 0 THEN 100 ELSE 0 END END PMARGIN FROM (
	SELECT SLS_FLAGBKP, (SLS_NILAIOMI + SLS_NILAINOMI + SLS_NILAIIDM) NILAI, (SLS_TAXOMI + SLS_TAXNOMI + SLS_TAXIDM) TAX,
	(SLS_NETOMI + SLS_NETNOMI + SLS_NETIDM) NET, (SLS_HPPOMI + SLS_HPPNOMI + SLS_HPPIDM) HPP,
	(SLS_MARGINOMI + SLS_MARGINNOMI + SLS_MARGINIDM) MARGIN FROM TBTR_SUMSALES
	WHERE SLS_KODEIGR = '".Session::get('kdigr')."' AND TRUNC(SLS_PERIODE) = to_date('".$tanggal."','dd/mm/yyyy') AND SLS_KODEDIVISI <>  '5' AND SLS_KODEDEPARTEMENT NOT IN ('39', '40', '43')
	AND SLS_FLAGBKP IN ('W','G') ) A")[0];

            // $nilait_tepung += $ppnTepung->nilai;
            // $taxt_tepung += $ppnTepung->tax;
            // $nett_tepung += $ppnTepung->net;
            // $hppt_tepung += $ppnTepung->hpp;
            // $margint_tepung += $ppnTepung->margin;

            $nilait += $ppnTepung->nilai;
            $taxt += $ppnTepung->tax;
            $nett += $ppnTepung->net;
            $hppt += $ppnTepung->hpp;
            $margint += $ppnTepung->margin;

            if($nett_tepung != 0)
                $pmargint_tepung = ($margint_tepung * 100) / $nett_tepung;
            else if($margint_tepung != 0)
                $pmargint_tepung = 100;
            else $pmargint_tepung = 0;

            // dd($ppnTepung);

            $ppnTepung->keterangan = 'TOTAL BARANG PPN DIBAYAR PEMERINTAH';

            DB::connection(Session::get('connection'))->table('cetak_sums')
                ->insert(json_decode(json_encode($ppnTepung), true));

            // $nilait += ($ppnMinyak->nilai + $nilait_tepung);
            // // dd($nilait += ($ppnMinyak->nilai + $nilait_tepung));
            // $taxt += ($ppnMinyak->tax + $taxt_tepung);
            // $nett += ($ppnMinyak->net + $nett_tepung);
            // $hppt += ($ppnMinyak->hpp + $hppt_tepung);
            // $margint += ($ppnMinyak->margin + $margint_tepung);
            // $pmargint += ($ppnMinyak->pmargin + $pmargint_tepung);

            // dd($nilait,$taxt,$nett,$hppt,$margint,$pmargint);

            $nilai40 = DB::connection(Session::get('connection'))->select("SELECT NVL(SUM(NILAI),0) NILAI, NVL(SUM(TAX),0) TAX, NVL(SUM(NET),0) NET,
	NVL(SUM(HPP),0) HPP, NVL(SUM(MARGIN),0) MARGIN,
	CASE WHEN NVL(SUM(NET),0) <> 0 THEN ((NVL(SUM(MARGIN),0) * 100 ) / NVL(SUM(NET),0)) ELSE
	CASE WHEN NVL(SUM(MARGIN),0) <> 0 THEN 100 ELSE 0 END END PMARGIN FROM (
	SELECT SLS_FLAGBKP, (SLS_NILAIOMI + SLS_NILAINOMI + SLS_NILAIIDM) NILAI, (SLS_TAXOMI + SLS_TAXNOMI + SLS_TAXIDM) TAX,
	(SLS_NETOMI + SLS_NETNOMI + SLS_NETIDM) NET, (SLS_HPPOMI + SLS_HPPNOMI + SLS_HPPIDM) HPP,
	(SLS_MARGINOMI + SLS_MARGINNOMI + SLS_MARGINIDM) MARGIN FROM TBTR_SUMSALES
	WHERE SLS_KODEIGR = '".Session::get('kdigr')."' AND TRUNC(SLS_PERIODE) = to_date('".$tanggal."','dd/mm/yyyy') AND SLS_KODEDIVISI = '5' AND SLS_KODEDEPARTEMENT IN ('40') ) A")[0];

            DB::connection(Session::get('connection'))->table('cetak_sums')
                ->insert([
                    'keterangan' => 'GRAND TOTAL (TANPA DEPT 40)',
                    'nilai' => $nilait,
                    'tax' => $taxt,
                    'net' => $nett,
                    'hpp' => $hppt,
                    'margin' => $margint,
                    'pmargin' => $pmargint
                ]);

            DB::connection(Session::get('connection'))->table('cetak_sums')
                ->insert([
                    'keterangan' => 'GRAND TOTAL (+ DEPT 40)',
                    'nilai' => $nilait + $nilai40->nilai,
                    'tax' => $taxt + $nilai40->tax,
                    'net' => $nett + $nilai40->net,
                    'hpp' => $hppt + $nilai40->hpp,
                    'margin' => $margint + $nilai40->margin,
                    'pmargin' => $pmargint + $nilai40->pmargin
                ]);

            DB::connection(Session::get('connection'))->commit();
        }
        catch(QueryException $e){
            DB::connection(Session::get('connection'))->rollBack();

            return $e->getMessage();
        }
    }

    public function cashback(){
        return response()->json([
            'message' => 'Procedure sp_job_lpt_cashback berhasil dijalankan!'
        ], 200);
        set_time_limit(0);
        $isRunning = $this->cekProcedure("'sp_job_lpt_cashback'");

        if ($isRunning > 0) {
            return response()->json([
                'message' => 'Procedure sp_job_lpt_cashback sedang berjalan!'
            ], 500);
            $result =  new \stdClass();
            $result->message = 'Procedure sp_job_lpt_cashback sedang berjalan!';
            $result->status = 'info';
            return $result;
        } else {
            try {
                $c = loginController::getConnectionProcedure();
//                $sql = "BEGIN sp_job_lpt_cashback(to_date('" . $tanggal . "','dd/mm/yyyy'),to_date('" . $tanggal . "','dd/mm/yyyy'),'" . Session::get('usid') . "'); END;";
            $sql = "BEGIN sp_job_lpt_cashback(); END;";
                $s = oci_parse($c, $sql);
                oci_execute($s);

                return response()->json([
                    'message' => 'Procedure sp_job_lpt_cashback berhasil dijalankan!'
                ], 200);
                return null;
            } catch (\Exception $e) {
                return response()->json([
                    'message' => $e->getMessage()
                ], 500);

                return $e->getMessage();
            }
        }
    }

    public function cetakSales(Request $request){
        set_time_limit(0);

        try{
            DB::connection(Session::get('connection'))->table('cetak_sums')->truncate();

//        $result = $this->cashback();
//
//        if($result){
//            return response()->json([
//                'message' => $result->message,
//                'error' => $result->status
//            ], 500);
//        }

            $data = DB::connection(Session::get('connection'))->table('tbtr_sumsales')
                ->where('sls_kodeigr','=',Session::get('kdigr'))
                ->whereRaw("sls_periode = to_date('".$request->tanggal."','dd/mm/yyyy')")
                ->first();

            if($data){
                $result = $this->prosesSales($request->tanggal);
                if(!is_null($result)){
                    return response()->json([
                        'message' => 'Terjadi kesalahan!',
                        'error' => $result
                    ], 500);
                }
            }

            $tanggal = $request->tanggal;

            $perusahaan = DB::connection(Session::get('connection'))->table('tbmaster_perusahaan')
                ->first();

            $data = DB::connection(Session::get('connection'))->select("SELECT js_cashierstation,
         js_cashierid,
            js_cashierstation
         || '.'
         || js_cashierid
         || '.'
         || SUBSTR (username, 1, 5)
            kassa,
         CASE
            WHEN js_cashierid = 'BKL' OR js_cashierid = 'SMP' THEN 0
            ELSE js_cashstartamt
         END
            awal,
         js_totsalesamt penj,
         js_totkmmamt debukm,
         js_totcc1amt + js_totcc2amt kkredit,
         js_totdebitamt kdebit,
         js_totvoucheramt voucher,
         js_totcreditsalesamt kredit,
         js_totcashrefundamt refundtunai,
         js_totcreditrefundamt refundkredit,
         nvl(nilai_in, 0) nilai_in,
         js_totremainvouchervalue lbh_vch,
         (  js_totsalesamt
          - 0
          - js_totcreditsalesamt
          - js_totcc1amt
          - js_totcc2amt
          - js_totdebitamt
          - js_totkmmamt
          - js_totvoucheramt)
            tunai,
         0 pot,
         js_totcashadvanceamt + nvl(nilai_out, 0) tunaibca,
           (  js_totcashsalesamt
            - js_totcashrefundamt
            - js_totcashadvanceamt
            - nvl(nilai_out, 0)
            + 0
            + nvl(nilai_in, 0))
         - NVL (pls_nominalamt, 0)
            fisik,
         js_cashdrawalamt ambil,
         NVL (
            CASE
               WHEN js_cashierid NOT IN ('BKL', 'SMP')
               THEN
                  (  js_resetamt
                   - (  (  js_totcashsalesamt
                         - js_totcashrefundamt
                         - js_totcashadvanceamt
                         - nvl(nilai_out, 0)
                         + 0
                         + nvl(nilai_in, 0))
                      + js_cashstartamt
                      - js_cashdrawalamt))
               ELSE
                  (  js_totcashsalesamt
                   - js_cashdrawalamt
                   - js_totcashadvanceamt
                   - js_totcashrefundamt
                   - 0)
            END,
            0)
            var,
         CASE
            WHEN js_cashierid = 'BKL' OR js_cashierid = 'SMP' THEN 0
            ELSE js_resetamt
         END
            actual
    FROM tbtr_jualsummary,
         tbmaster_user,
         (  SELECT TRUNC (pls_tgltransaksi) pls_tgltransaksi,
                   pls_kasir,
                   pls_station,
                   SUM (pls_nominalamt) pls_nominalamt
              FROM tbtr_pemakaianplastik
             WHERE     TRUNC (pls_tgltransaksi) = TO_DATE('".$tanggal."','dd/mm/yyyy')
                   AND pls_kodeigr(+) = '".Session::get('kdigr')."'
          GROUP BY TRUNC (pls_tgltransaksi), pls_kasir, pls_station),
         (  SELECT vir_transactiondate,
                   vir_cashierid,
                   vir_cashierstation,
                   SUM (nvl(nilai_in, 0)) nilai_in,
                   SUM (nvl(nilai_out, 0)) nilai_out
              FROM (SELECT TRUNC (vir_transactiondate) vir_transactiondate,
                           vir_transactiontype,
                           vir_cashierid,
                           vir_cashierstation,
                           CASE
                              WHEN vir_transactiontype = 'CI' THEN vir_total
                              ELSE 0
                           END
                              nilai_in,
                           CASE
                              WHEN vir_transactiontype = 'CO' THEN vir_amount
                              ELSE 0
                           END
                              nilai_out
                      FROM tbtr_virtual
                     WHERE     TRUNC (vir_transactiondate) = TO_DATE('".$tanggal."','dd/mm/yyyy')
                           AND vir_transactiontype IN ('CI', 'CO')) aa
          GROUP BY vir_transactiondate, vir_cashierid, vir_cashierstation)
   WHERE     js_kodeigr = '".Session::get('kdigr')."'
         AND TRUNC (js_transactiondate) = TO_DATE('".$tanggal."','dd/mm/yyyy')
         AND kodeigr(+) = '".Session::get('kdigr')."'
         AND userid(+) = js_cashierid
         AND pls_tgltransaksi(+) = TRUNC (js_transactiondate)
         AND pls_kasir(+) = js_cashierid
         AND pls_station(+) = js_cashierstation
         AND vir_transactiondate(+) = TRUNC (js_transactiondate)
         AND vir_cashierid(+) = js_cashierid
         AND vir_cashierstation(+) = js_cashierstation
         ORDER BY js_cashierstation, js_cashierid");

            $ppn_perushaan = DB::connection(Session::get('connection'))->table('tbmaster_perusahaan')
                ->selectRaw('COALESCE(prs_nilaippn,10) prs_ppn')->first()->prs_ppn;
            foreach($data as $d){
                $temp = DB::connection(Session::get('connection'))->table('tbtr_jualheader')
                    ->select('jh_transactionno')
                    ->where('jh_cashierid','=',$d->js_cashierid)
                    ->where('jh_cashierstation','=',$d->js_cashierstation)
                    ->where('jh_kodeigr','=',Session::get('kdigr'))
                    ->whereRaw("trunc(jh_transactiondate) = TO_DATE('".$tanggal."','dd/mm/yyyy')")
                    ->orderBy('jh_transactionno','desc')
                    ->first();

                $d->struk = $temp ? $temp->jh_transactionno : '00000';

                if(substr($d->js_cashierid,0,2) == 'OM' || $d->js_cashierid == 'BKL'){
                    $fee = DB::connection(Session::get('connection'))->select("SELECT NVL((SUM(FEE) * (1+($ppn_perushaan/100) )),0) FEE FROM (
		SELECT TRJD_CASHIERSTATION , TRJD_CREATE_BY, (CASE WHEN TRJD_TRANSACTIONTYPE = 'S' THEN 1 ELSE -1 END * TRJD_ADMFEE) FEE
		FROM TBTR_JUALDETAIL, TBMASTER_TOKOIGR
		WHERE TRJD_KODEIGR = '".Session::get('kdigr')."' AND TRUNC(TRJD_TRANSACTIONDATE) = TO_DATE('".$tanggal."','dd/mm/yyyy')
		AND NVL(TRJD_RECORDID,'0') <> '1'
		AND TRJD_CASHIERSTATION = '".$d->js_cashierstation."' AND TRJD_CREATE_BY = '".$d->js_cashierid."'
		AND TKO_KODEIGR = '".Session::get('kdigr')."' AND TKO_KODECUSTOMER = TRJD_CUS_KODEMEMBER
		AND ( TKO_KODESBU IN ( 'O', 'I' ) OR NVL(TKO_TIPEOMI,'AA') IN ('HG' , 'HE')) )");

                    $d->distfee = $fee[0]->fee;
                }
                else $d->distfee = 0;

                $cb = DB::connection(Session::get('connection'))->select("SELECT NVL(SUM(CASHBACK),0) CB FROM M_PROMOSI_H
	WHERE KD_IGR = '".Session::get('kdigr')."' AND TRUNC(TGL_TRANS) = TO_DATE('".$tanggal."','dd/mm/yyyy')
	AND KODE_STATION = '".$d->js_cashierstation."' AND CREATE_BY = '".$d->js_cashierid."'
	AND TIPE = 'S'");

                $nk = DB::connection(Session::get('connection'))->select("SELECT NVL(SUM(NKH_TOTALNK),0) NK FROM M_NK_H
	WHERE NKH_KDIGR = '".Session::get('kdigr')."' AND TRUNC(NKH_TGLTRANS) = TO_DATE('".$tanggal."','dd/mm/yyyy')
	AND NKH_STATION = '".$d->js_cashierstation."' AND NKH_CASHIERID = '".$d->js_cashierid."'");

                $d->cb = $cb[0]->cb + $nk[0]->nk;

                $d->rcb = DB::connection(Session::get('connection'))->select("SELECT (NVL(SUM(CASHBACK),0) * -1) CB FROM M_PROMOSI_H
	WHERE KD_IGR = '".Session::get('kdigr')."' AND TRUNC(TGL_TRANS) = TO_DATE('".$tanggal."','dd/mm/yyyy')
	AND KODE_STATION = '".$d->js_cashierstation."' AND CREATE_BY = '".$d->js_cashierid."'
	AND TIPE = 'R'")[0]->cb;

                $vcr = DB::connection(Session::get('connection'))->select("SELECT NVL(SUM(DPS_JUMLAHDEPOSIT),0) NILAI
              FROM TBTR_DEPOSITSIMPATINDO
              WHERE DPS_KODEIGR = '".Session::get('kdigr')."' AND DPS_STATIONKASIR = '".$d->js_cashierstation."' || '".$d->js_cashierid."'
              AND DPS_TGLTRANSAKSI = TO_CHAR(TO_DATE('".$tanggal."','dd/mm/yyyy'), 'YYYYMMDD')")[0]->nilai;

                $topup = DB::connection(Session::get('connection'))->select("SELECT NVL(SUM(DPP_JUMLAHDEPOSIT),0) NILAI
              FROM TBTR_DEPOSIT_MITRAIGR
              WHERE DPP_KODEIGR = '".Session::get('kdigr')."' AND DPP_STATIONKASIR = '".$d->js_cashierstation."' || '".$d->js_cashierid."'
              AND DPP_TGLTRANSAKSI = TO_CHAR(TO_DATE('".$tanggal."','dd/mm/yyyy'), 'YYYYMMDD')")[0]->nilai;

                $d->fisik += $vcr + $topup;

                $d->var -= ($vcr + $topup);

                $d->titip = $vcr + $topup;
            }

            $sums = DB::connection(Session::get('connection'))->table('cetak_sums')->get();

    //    dd($sums);

            return view('FRONTOFFICE.LAPORANKASIR.ACTUAL.sales-pdf',compact(['perusahaan','data','sums','tanggal']));
        }
        catch (\Exception $e){
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function cetakIsaku(Request $request){
        $tanggal = $request->tanggal;

        $perusahaan = DB::connection(Session::get('connection'))->table('tbmaster_perusahaan')
            ->first();

        $data = DB::connection(Session::get('connection'))->select("SELECT    vir_cashierstation
               || '.'
               || vir_cashierid
               || '.'
               || SUBSTR (username, 1, 5)
                  kassa,
               sum(fee_in) fee_in,
               sum(nilai_in) nilai_in,
               sum(fee_out) fee_out,
               sum(nilai_out) nilai_out,
               sum(nilai_buy) nilai_buy
          FROM (  SELECT vir_cashierstation,
                         vir_cashierid,
                         SUM (fee_in) fee_in,
                         SUM (nilai_in) nilai_in,
                         SUM (fee_out) fee_out,
                         SUM (nilai_out) nilai_out, sum(nilai_buy) nilai_buy
                    FROM (SELECT vir_cashierstation,
                                 vir_cashierid,
                                 CASE
                                    WHEN vir_transactiontype = 'CI' THEN vir_fee
                                    ELSE 0
                                 END
                                    fee_in,
                                 CASE
                                    WHEN vir_transactiontype = 'CI' THEN vir_amount
                                    ELSE 0
                                 END
                                    nilai_in,
                                 CASE
                                    WHEN vir_transactiontype = 'CO' THEN vir_fee
                                    ELSE 0
                                 END
                                    fee_out,
                                 CASE
                                    WHEN vir_transactiontype = 'CO' THEN vir_amount
                                    ELSE 0
                                 END
                                    nilai_out,
                                 0 nilai_buy
                            FROM tbtr_virtual
                           WHERE     TRUNC (vir_transactiondate) = TO_DATE('".$tanggal."','dd/mm/yyyy')
                                 AND vir_kodeigr = '".Session::get('kdigr')."'
                                 AND vir_transactiontype IN ('CI', 'CO')) aa
                GROUP BY vir_cashierstation, vir_cashierid
                UNION
                  SELECT jh_cashierstation vir_cashierstation,
                         jh_cashierid vir_cashierid,
                         0 fee_in,
                         0 nilai_in,
                         0 fee_out,
                         0 nilai_out,
                         SUM (NVL (jh_isaku_amt, 0)) nilai_buy
                    FROM tbtr_jualheader
                   WHERE     NVL (jh_isaku_amt, 0) <> 0
                         AND TRUNC (jh_transactiondate) = TO_DATE('".$tanggal."','dd/mm/yyyy')
                GROUP BY jh_cashierstation, jh_cashierid) bb,
               tbmaster_user
         WHERE     kodeigr(+) = '".Session::get('kdigr')."'
               AND userid(+) = vir_cashierid
               group by     vir_cashierstation
               || '.'
               || vir_cashierid
               || '.'
               || SUBSTR (username, 1, 5)
        order by      vir_cashierstation
               || '.'
               || vir_cashierid
               || '.'
               || SUBSTR (username, 1, 5)");

        $dompdf = new PDF();

        $title = 'Transaksi i-Saku - '.$tanggal;

        if(count($data) == 0){

            $pdf = PDF::loadview('pdf-no-data', compact(['title']));

            error_reporting(E_ALL ^ E_DEPRECATED);

            $pdf->output();
            $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);
        }
        else{
            $pdf = PDF::loadview('FRONTOFFICE.LAPORANKASIR.ACTUAL.isaku-pdf',compact(['perusahaan','data','tanggal']));

            error_reporting(E_ALL ^ E_DEPRECATED);

            $pdf->output();
            $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);

            $canvas = $dompdf ->get_canvas();
            $canvas->page_text(507, 77.75, "{PAGE_NUM} dari {PAGE_COUNT}", null, 7, array(0, 0, 0));
        }

        $dompdf = $pdf;

        return $dompdf->stream($title.'.pdf');
    }

    public function cetakVirtual(Request $request){
        $tanggal = $request->tanggal;

        $perusahaan = DB::connection(Session::get('connection'))->table('tbmaster_perusahaan')
            ->first();

        $data = DB::connection(Session::get('connection'))->select("select vir_type, sum(vir_amount) ttl, sum(vir_fee) fee
                from tbtr_virtual
                where vir_method = 'KLIKIGR'
                 and TRUNC (vir_transactiondate) = TO_DATE('".$tanggal."','dd/mm/yyyy')
                 AND vir_kodeigr = '".Session::get('kdigr')."'
                group by vir_type");

//        dd($data);

        $dompdf = new PDF();

        $title = 'Transaksi Virtual Untuk Kasir Online - '.$tanggal;

        if(count($data) == 0){

            $pdf = PDF::loadview('pdf-no-data', compact(['title']));

            error_reporting(E_ALL ^ E_DEPRECATED);

            $pdf->output();
            $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);
        }
        else{
            $pdf = PDF::loadview('FRONTOFFICE.LAPORANKASIR.ACTUAL.virtual-pdf',compact(['perusahaan','data','tanggal']));

            error_reporting(E_ALL ^ E_DEPRECATED);

            $pdf->output();
            $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);

            $canvas = $dompdf ->get_canvas();
            $canvas->page_text(507, 77.75, "{PAGE_NUM} dari {PAGE_COUNT}", null, 7, array(0, 0, 0));
        }

        $dompdf = $pdf;

        return $dompdf->stream($title.'.pdf');
    }

    public function cetakCbNk(Request $request){
        $tanggal = $request->tanggal;

//        $result = $this->cashback();
//        if($result){
//            return response()->json([
//                'message' => 'Terjadi kesalahan!',
//                'error' => $result
//            ], 500);
//        }

        $perusahaan = DB::connection(Session::get('connection'))->table('tbmaster_perusahaan')
            ->first();

        $data = DB::connection(Session::get('connection'))->select("SELECT   JS_CASHIERSTATION, JS_CASHIERID, SUBSTR (USERNAME, 1, 5) KASSA, NVL (SUM (CB), 0) CB, NVL (SUM (NK), 0) NK,
         (NVL (SUM (CB), 0) + NVL (SUM (NK), 0)) TOTAL
    FROM TBTR_JUALSUMMARY,
         TBMASTER_USER,
         (SELECT   KODE_STATION, CREATE_BY, TRUNC (TGL_TRANS), SUM (CASHBACK) CB
              FROM M_PROMOSI_H
             WHERE KD_IGR = '".Session::get('kdigr')."' AND TRUNC (TGL_TRANS) = TO_DATE('".$tanggal."','dd/mm/yyyy') AND TIPE(+) = 'S'
          GROUP BY KODE_STATION, CREATE_BY, TRUNC (TGL_TRANS)) AA,
         (SELECT   NKH_STATION, NKH_CASHIERID, TRUNC (NKH_TGLTRANS), SUM (NKH_TOTALNK) NK
              FROM M_NK_H
             WHERE NKH_KDIGR(+) = '".Session::get('kdigr')."' AND TRUNC (NKH_TGLTRANS(+)) = TO_DATE('".$tanggal."','dd/mm/yyyy')
          GROUP BY NKH_STATION, NKH_CASHIERID, TRUNC (NKH_TGLTRANS))
   WHERE JS_KODEIGR = '".Session::get('kdigr')."'
     AND TRUNC (JS_TRANSACTIONDATE) = TO_DATE('".$tanggal."','dd/mm/yyyy')
     AND KODEIGR(+) = '".Session::get('kdigr')."'
     AND USERID(+) = JS_CASHIERID
     AND KODE_STATION(+) = JS_CASHIERSTATION
     AND AA.CREATE_BY(+) = JS_CASHIERID
     AND NKH_STATION(+) = JS_CASHIERSTATION
     AND NKH_CASHIERID(+) = JS_CASHIERID
GROUP BY JS_CASHIERSTATION,
         JS_CASHIERID,
         SUBSTR (USERNAME, 1, 5)
ORDER BY JS_CASHIERSTATION, JS_CASHIERID");

//        dd($data);

        $dompdf = new PDF();

        $title = 'Laporan Potongan Pada Sales Harian Kasir / Actual - '.$tanggal;

        if(count($data) == 0){

            $pdf = PDF::loadview('pdf-no-data', compact(['title']));

            error_reporting(E_ALL ^ E_DEPRECATED);

            $pdf->output();
            $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);
        }
        else{
            $pdf = PDF::loadview('FRONTOFFICE.LAPORANKASIR.ACTUAL.cb-nk-pdf',compact(['perusahaan','data','tanggal']));

            error_reporting(E_ALL ^ E_DEPRECATED);

            $pdf->output();
            $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);

            $canvas = $dompdf ->get_canvas();
            $canvas->page_text(507, 77.75, "{PAGE_NUM} dari {PAGE_COUNT}", null, 7, array(0, 0, 0));
        }

        $dompdf = $pdf;

        return $dompdf->stream($title.'.pdf');
    }

    public function cetakTransfer(Request $request){
        $tanggal = $request->tanggal;

        $perusahaan = DB::connection(Session::get('connection'))->table('tbmaster_perusahaan')
            ->first();

        $data = DB::connection(Session::get('connection'))->select("select trunc(rfr_transactiondate) rfr_transactiondate, rfr_transactionno || '-' || rfr_station || '-' || rfr_cashierid kassa,
rfr_transferamt, rfr_koderk, rfr_nilairk, rfr_paymentrk, rfr_kodemember, rfr_attr1, cus_namamember, 0 voucher, 0 nk, 0 CB
from tbtr_rek_koran_refstruk, tbmaster_customer
where rfr_kodeigr = '".Session::get('kdigr')."' and trunc(rfr_transactiondate) = TO_DATE('".$tanggal."','dd/mm/yyyy') and cus_kodemember = rfr_kodemember
ORDER BY rfr_kodemember, rfr_transactionno, rfr_station, rfr_cashierid");

//        dd($data);

        $dompdf = new PDF();

        $title = 'Laporan Rincian Transaksi Transfer - '.$tanggal;

        if(count($data) == 0){

            $pdf = PDF::loadview('pdf-no-data', compact(['title']));

            error_reporting(E_ALL ^ E_DEPRECATED);

            $pdf->output();
            $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);
        }
        else{
            $pdf = PDF::loadview('FRONTOFFICE.LAPORANKASIR.ACTUAL.transfer-pdf',compact(['perusahaan','data','tanggal']));

            error_reporting(E_ALL ^ E_DEPRECATED);

            $pdf->output();
            $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);

            $canvas = $dompdf ->get_canvas();
            $canvas->page_text(507, 77.75, "{PAGE_NUM} dari {PAGE_COUNT}", null, 7, array(0, 0, 0));
        }

        $dompdf = $pdf;

        return $dompdf->stream($title.'.pdf');
    }

    public function cetakPlastik(Request $request){
        $tanggal = $request->tanggal;

        $perusahaan = DB::connection(Session::get('connection'))->table('tbmaster_perusahaan')
            ->first();

        $data = DB::connection(Session::get('connection'))->select("select pls_kasir, pls_station, pls_notransaksi, pls_tgltransaksi,
            pls_prdcd, pls_qty, pls_nominalamt
            from tbtr_pemakaianplastik
            where pls_kodeigr = '".Session::get('kdigr')."'
            and trunc(pls_tgltransaksi) = TO_DATE('".$tanggal."','dd/mm/yyyy')
            order by pls_kasir, pls_station");

//        dd($data);

        $dompdf = new PDF();

        $title = 'Laporan Pemakaian Kantong Plastik - '.$tanggal;

        if(count($data) == 0){

            $pdf = PDF::loadview('pdf-no-data', compact(['title']));

            error_reporting(E_ALL ^ E_DEPRECATED);

            $pdf->output();
            $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);
        }
        else{
            $pdf = PDF::loadview('FRONTOFFICE.LAPORANKASIR.ACTUAL.plastik-pdf',compact(['perusahaan','data','tanggal']));

            error_reporting(E_ALL ^ E_DEPRECATED);

            $pdf->output();
            $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);

            $canvas = $dompdf ->get_canvas();
            $canvas->page_text(507, 77.75, "{PAGE_NUM} dari {PAGE_COUNT}", null, 7, array(0, 0, 0));
        }

        $dompdf = $pdf;

        return $dompdf->stream($title.'.pdf');
    }

    public function cetakMerchant(Request $request){
        $tanggal = $request->tanggal;

        $perusahaan = DB::connection(Session::get('connection'))->table('tbmaster_perusahaan')
            ->first();

        $data = DB::connection(Session::get('connection'))->select("select substr(DPP_STATIONKASIR, 1, 2) || '-' || substr(DPP_STATIONKASIR, 3,3 ) kasir, to_date(dpp_tgltransaksi, 'yyyyMMdd') tgl,
        dpp_nohp, dpp_kodemember, cus_namamember, dpp_jumlahdeposit
        from tbtr_deposit_mitraigr, tbmaster_customer
        where to_date(dpp_tgltransaksi, 'yyyyMMdd') = TO_DATE('".$tanggal."','dd/mm/yyyy')
        and cus_kodemember = dpp_kodemember
        order by substr(DPP_STATIONKASIR, 1, 2), substr(DPP_STATIONKASIR, 3,3 ), dpp_kodemember");

//        dd($data);

        $dompdf = new PDF();

        $title = 'Laporan Pengisian Top Up Merchant Apps - '.$tanggal;

        if(count($data) == 0){
            $pdf = PDF::loadview('pdf-no-data', compact(['title']));

            error_reporting(E_ALL ^ E_DEPRECATED);

            $pdf->output();
            $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);
        }
        else{
            $pdf = PDF::loadview('FRONTOFFICE.LAPORANKASIR.ACTUAL.merchant-pdf',compact(['perusahaan','data','tanggal']));

            error_reporting(E_ALL ^ E_DEPRECATED);

            $pdf->output();
            $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);

            $canvas = $dompdf ->get_canvas();
            $canvas->page_text(507, 77.75, "{PAGE_NUM} dari {PAGE_COUNT}", null, 7, array(0, 0, 0));
        }

        $dompdf = $pdf;

        return $dompdf->stream($title.'.pdf');
    }

    public function cetakKredit(Request $request){
        $tanggal = $request->tanggal;

        $perusahaan = DB::connection(Session::get('connection'))->table('tbmaster_perusahaan')
            ->first();

        $data = DB::connection(Session::get('connection'))->select("SELECT trpt_cus_kodemember, trpt_type, kasir, cus_namamember,
          cus_alamatmember1, cus_alamatmember2, cus_alamatmember3,
          cus_alamatmember4, SUM(trpt_salesvalue) kredit
     FROM
     (    SELECT trpt_cus_kodemember,  trpt_type, trpt_salesvalue,
               cus_namamember, cus_alamatmember1, cus_alamatmember2,
               cus_alamatmember3, cus_alamatmember4,
               CASE WHEN trpt_cashierid = 'OMI' THEN
                     'BKL'
               ELSE
                     CASE WHEN trpt_cashierid = 'BKL' THEN
                           'BKL'
                     ELSE
                            trpt_cashierid
                     END
               END kasir
         FROM TBTR_PIUTANG, TBMASTER_CUSTOMER
         WHERE trpt_kodeigr = '".Session::get('kdigr')."'
              AND TRUNC(trpt_salesinvoicedate) = TO_DATE('".$tanggal."','dd/mm/yyyy')
              AND trpt_type <> 'D'
              AND NVL(trpt_recordid, '9') <> '1'
              --AND cus_kodeigr(+) = trpt_kodeigr
              AND cus_kodemember(+) = trpt_cus_kodemember)
GROUP BY trpt_cus_kodemember, trpt_type, kasir,
                    cus_namamember, cus_alamatmember1,
                    cus_alamatmember2, cus_alamatmember3, cus_alamatmember4
ORDER BY trpt_cus_kodemember");

        foreach($data as $d){
            $temp = DB::connection(Session::get('connection'))->selectOne("SELECT trjd_cashierstation FROM tbtr_jualdetail
              WHERE TRUNC(trjd_transactiondate) = TO_DATE('".$tanggal."','dd/mm/yyyy')
                AND trjd_cus_kodemember = '".$d->trpt_cus_kodemember."'
                AND trjd_kodeigr = '".Session::get('kdigr')."'
              ORDER BY trjd_cashierstation");

            if($temp){
                $d->stat = $temp->trjd_cashierstation;
            }
            else $d->stat = null;
        }

//        dd($data);

        $dompdf = new PDF();

        $title = 'Perincian Kredit - '.$tanggal;

        return view('FRONTOFFICE.LAPORANKASIR.ACTUAL.kredit-pdf',compact(['perusahaan','data','tanggal']));

        if(count($data) == 0){
            $pdf = PDF::loadview('pdf-no-data', compact(['title']));

            error_reporting(E_ALL ^ E_DEPRECATED);

            $pdf->output();
            $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);
        }
        else{
            $pdf = PDF::loadview('FRONTOFFICE.LAPORANKASIR.ACTUAL.kredit-pdf',compact(['perusahaan','data','tanggal']));

            error_reporting(E_ALL ^ E_DEPRECATED);

            $pdf->output();
            $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);

            $canvas = $dompdf ->get_canvas();
            $canvas->page_text(755, 77.75, "{PAGE_NUM} dari {PAGE_COUNT}", null, 7, array(0, 0, 0));
        }

        $dompdf = $pdf;

        return $dompdf->stream($title.'.pdf');
    }

    public function cetakOmi(Request $request){
        $tanggal = $request->tanggal;

        $perusahaan = DB::connection(Session::get('connection'))->table('tbmaster_perusahaan')
            ->first();

        $data = DB::connection(Session::get('connection'))->select("SELECT trjd_cus_kodemember, tko_namaomi,
          SUM(trjd_admfee) dfee, SUM(dppomi) dppomi,
          SUM(gross) grsomi, SUM(ppnomi) ppnomi
         FROM
         (    SELECT trjd_cus_kodemember, tko_namaomi,
                   CASE WHEN trjd_transactiontype = 'R' THEN -1 ELSE 1 END * (trjd_admfee * (1 + (coalesce(prd_ppn,10)/100))) trjd_admfee,
                   (CASE WHEN trjd_transactiontype = 'R' THEN -1 ELSE 1 END *
                        (CASE WHEN prd_unit = 'KG' THEN
                              (trjd_quantity / 1000) * trjd_baseprice
                        ELSE
                              trjd_quantity * trjd_baseprice
                        END)) dppomi,
                   (CASE WHEN trjd_transactiontype = 'R' THEN -1 ELSE 1 END *
                        (CASE WHEN trjd_flagtax1 = 'Y' THEN
                              trjd_nominalamt * (1 + (coalesce(prd_ppn,10)/100))
                        ELSE
                              trjd_nominalamt
                        END)) gross,
                   (CASE WHEN trjd_transactiontype = 'R' THEN -1 ELSE 1 END *
                        (CASE WHEN trjd_flagtax1 = 'Y' THEN
                              (trjd_nominalamt * (1 + (coalesce(prd_ppn,10)/100))) - trjd_nominalamt
                        ELSE
                              0
                        END)) ppnomi
             FROM TBTR_JUALDETAIL, TBMASTER_TOKOIGR, TBMASTER_PRODMAST
             WHERE trjd_kodeigr = '".Session::get('kdigr')."'
                  AND TRUNC(trjd_transactiondate) = TO_DATE('".$tanggal."','dd/mm/yyyy')
                  AND tko_kodeigr = trjd_kodeigr
                  AND tko_kodecustomer = trjd_cus_kodemember
                  AND tko_kodesbu IN ('O','I')
                  AND (tko_tipeomi NOT IN('HE','HG') OR tko_tipeomi IS NULL)
                  AND prd_kodeigr = trjd_kodeigr
                  AND prd_prdcd = trjd_prdcd
    )
    GROUP BY trjd_cus_kodemember, tko_namaomi
    ORDER BY trjd_cus_kodemember");

//        dd($data)

        $dompdf = new PDF();

        $title = 'Rekap Penjualan OMI - '.$tanggal;

        if(count($data) == 0){
            $pdf = PDF::loadview('pdf-no-data', compact(['title']));

            error_reporting(E_ALL ^ E_DEPRECATED);

            $pdf->output();
            $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);
        }
        else{
            $pdf = PDF::loadview('FRONTOFFICE.LAPORANKASIR.ACTUAL.omi-pdf',compact(['perusahaan','data','tanggal']));

            error_reporting(E_ALL ^ E_DEPRECATED);

            $pdf->output();
            $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);

            $canvas = $dompdf ->get_canvas();
            $canvas->page_text(755, 77.75, "{PAGE_NUM} dari {PAGE_COUNT}", null, 7, array(0, 0, 0));
        }

        $dompdf = $pdf;

        return $dompdf->stream($title.'.pdf');
    }

    public function cetakStruk(Request $request){
        $tanggal = $request->tanggal;

        $perusahaan = DB::connection(Session::get('connection'))->table('tbmaster_perusahaan')
            ->first();

        $data = DB::connection(Session::get('connection'))->select("SELECT TO_DATE(dps_tgltransaksi,'yyyymmdd') tanggal, dps_kodemember, dps_jumlahdeposit, SUBSTR(dps_stationkasir,1,2)||'.'||SUBSTR(dps_stationkasir,3,3)||'.'||dps_notransaksi nostruk, cus_namamember
        FROM TBTR_DEPOSITSIMPATINDO, TBMASTER_CUSTOMER
        WHERE dps_kodeigr = '".Session::get('kdigr')."'
              AND to_date(dps_tgltransaksi,'yyyymmdd') = TO_DATE('".$tanggal."','dd/mm/yyyy')
              AND cus_kodeigr = dps_kodeigr
              AND cus_kodemember = dps_kodemember
        ORDER BY dps_kodemember, dps_notransaksi");

//        dd($data);

        $dompdf = new PDF();

        $title = 'Rincian Struk Titipan - '.$tanggal;

        if(count($data) == 0){
            $pdf = PDF::loadview('pdf-no-data', compact(['title']));

            error_reporting(E_ALL ^ E_DEPRECATED);

            $pdf->output();
            $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);
        }
        else{
            $pdf = PDF::loadview('FRONTOFFICE.LAPORANKASIR.ACTUAL.struk-pdf',compact(['perusahaan','data','tanggal']));

            error_reporting(E_ALL ^ E_DEPRECATED);

            $pdf->output();
            $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);

            $canvas = $dompdf ->get_canvas();
            $canvas->page_text(507, 77.75, "{PAGE_NUM} dari {PAGE_COUNT}", null, 7, array(0, 0, 0));
        }

        $dompdf = $pdf;

        return $dompdf->stream($title.'.pdf');
    }

    public function cetakShopeepayOld(Request $request){
        $tanggal = $request->tanggal;

        $perusahaan = DB::connection(Session::get('connection'))->table('tbmaster_perusahaan')
            ->first();

        $data = DB::connection(Session::get('connection'))
            ->select("  SELECT    vir_cashierstation
         || '.'
         || vir_cashierid
         || '.'
         || SUBSTR (username, 1, 5)
            kassa,
         SUM (fee_in) fee_in,
         SUM (nilai_in) nilai_in,
         SUM (fee_out) fee_out,
         SUM (nilai_out) nilai_out,
         SUM (nilai_buy) nilai_buy
    FROM (  SELECT vir_cashierstation,
                   vir_cashierid,
                   SUM (fee_in) fee_in,
                   SUM (nilai_in) nilai_in,
                   SUM (fee_out) fee_out,
                   SUM (nilai_out) nilai_out,
                   SUM (nilai_buy) nilai_buy
              FROM (SELECT vir_cashierstation,
                           vir_cashierid,
                           CASE
                              WHEN vir_transactiontype = 'CI' THEN vir_fee
                              ELSE 0
                           END
                              fee_in,
                           CASE
                              WHEN vir_transactiontype = 'CI' THEN vir_amount
                              ELSE 0
                           END
                              nilai_in,
                           CASE
                              WHEN vir_transactiontype = 'CO' THEN vir_fee
                              ELSE 0
                           END
                              fee_out,
                           CASE
                              WHEN vir_transactiontype = 'CO' THEN vir_amount
                              ELSE 0
                           END
                              nilai_out,
                           CASE
                              WHEN vir_transactiontype = 'S' THEN vir_amount
                              ELSE 0
                           END
                              nilai_buy
                      FROM tbtr_virtual
                     WHERE     TRUNC (vir_transactiondate) = to_date('".$tanggal."','dd/mm/yyyy')
                           AND vir_kodeigr = '".Session::get('kdigr')."'
                           AND vir_method = 'SHOPEEPAY'
                           AND vir_transactiontype IN ('CI', 'CO', 'S')) aa
          GROUP BY vir_cashierstation, vir_cashierid) bb,
         tbmaster_user
   WHERE     kodeigr(+) = '".Session::get('kdigr')."'
         AND userid(+) = vir_cashierid
GROUP BY    vir_cashierstation
         || '.'
         || vir_cashierid
         || '.'
         || SUBSTR (username, 1, 5)
ORDER BY    vir_cashierstation
         || '.'
         || vir_cashierid
         || '.'
         || SUBSTR (username, 1, 5)");

//        dd($data);

        return view('FRONTOFFICE.LAPORANKASIR.ACTUAL.shopeepay-pdf',compact(['perusahaan','data','tanggal']));
    }

    public function cetakShopeepay(Request $request){
        $tanggal = $request->tanggal;

        $perusahaan = DB::connection(Session::get('connection'))->table('tbmaster_perusahaan')
            ->first();

        $data = DB::connection(Session::get('connection'))
            ->select("  SELECT    vir_cashierstation
         || '.'
         || vir_cashierid
         || '.'
         || SUBSTR (username, 1, 5)
            kassa,
         SUM (fee_in) fee_in,
         SUM (nilai_in) nilai_in,
         SUM (fee_out) fee_out,
         SUM (nilai_out) nilai_out,
         SUM (nilai_buy) nilai_buy
    FROM (  SELECT vir_cashierstation,
                   vir_cashierid,
                   SUM (fee_in) fee_in,
                   SUM (nilai_in) nilai_in,
                   SUM (fee_out) fee_out,
                   SUM (nilai_out) nilai_out,
                   SUM (nilai_buy) nilai_buy
              FROM (SELECT vir_cashierstation,
                           vir_cashierid,
                           CASE
                              WHEN vir_transactiontype = 'CI' THEN vir_fee
                              ELSE 0
                           END
                              fee_in,
                           CASE
                              WHEN vir_transactiontype = 'CI' THEN vir_amount
                              ELSE 0
                           END
                              nilai_in,
                           CASE
                              WHEN vir_transactiontype = 'CO' THEN vir_fee
                              ELSE 0
                           END
                              fee_out,
                           CASE
                              WHEN vir_transactiontype = 'CO' THEN vir_amount
                              ELSE 0
                           END
                              nilai_out,
                           CASE
                              WHEN vir_transactiontype = 'S' THEN vir_amount
                              ELSE 0
                           END
                              nilai_buy
                      FROM tbtr_virtual
                     WHERE     TRUNC (vir_transactiondate) = to_date('".$tanggal."','dd/mm/yyyy')
                           AND vir_kodeigr = '".Session::get('kdigr')."'
                           AND vir_method = 'SHOPEEPAY'
                           AND vir_transactiontype IN ('CI', 'CO', 'S')) aa
          GROUP BY vir_cashierstation, vir_cashierid) bb,
         tbmaster_user
   WHERE     kodeigr(+) = '".Session::get('kdigr')."'
         AND userid(+) = vir_cashierid
GROUP BY    vir_cashierstation
         || '.'
         || vir_cashierid
         || '.'
         || SUBSTR (username, 1, 5)
ORDER BY    vir_cashierstation
         || '.'
         || vir_cashierid
         || '.'
         || SUBSTR (username, 1, 5)");

//        dd($data);

        return view('FRONTOFFICE.LAPORANKASIR.ACTUAL.shopeepay-pdf',compact(['perusahaan','data','tanggal']));

        $filename = 'aa.xlsx';
//        $spreadsheet = new Spreadsheet();
//        $spreadsheet->getActiveSheet()->getProtection()->setSheet(true);
//        $sheet = $spreadsheet->getActiveSheet();
//
//            //Header
//        $sheet->setCellValue('A1', $perusahaan->prs_namaperusahaan);
//        $sheet->setCellValue('A2', $perusahaan->prs_namacabang);
//        $sheet->setCellValue('B1', 'Laporan Transaksi dengan ShopeePay');
//        $sheet->getStyle('B1')->getAlignment()->setHorizontal('center')->setVertical('middle');
//        $sheet->mergeCells('B1:J2');
//        $sheet->setCellValue('K1', 'Tgl. Cetak : ' . date("d/m/Y"));
//        $sheet->setCellValue('K2', 'Jam Cetak : ' . date('H:i:s'));
//        $sheet->setCellValue('K3', 'User ID : ' . Session::get('usid'));
//        $sheet->setCellValue('K4', 'RINCIAN PER DIVISI (UNIT/RUPIAH)');
//        $sheet->getColumnDimension('A')->setAutoSize(true);
//        $sheet->getColumnDimension('K')->setAutoSize(true);

        //Body
        $htmlString = view('FRONTOFFICE.LAPORANKASIR.ACTUAL.shopeepay-table',compact(['perusahaan','data','tanggal']))->render();
        $reader = new Html();
        $spreadsheet = $reader->loadFromString($htmlString);
        $spreadsheet->getActiveSheet()->getProtection()->setSheet(true);
        $sheet = $spreadsheet->getActiveSheet();

//        foreach(range('A','G') as $columnID) {
//            $sheet->getColumnDimension($columnID)->setAutoSize(true);
//        }

        foreach (range('A', $spreadsheet->getActiveSheet()->getHighestDataColumn()) as $col) {
            $spreadsheet
                ->getActiveSheet()
                ->getColumnDimension($col)
                ->setAutoSize(true);
        }

//        foreach (range('A', $spreadsheet->getActiveSheet()->getHighestDataColumn()) as $col) {
//            $spreadsheet->getActiveSheet()
//                ->getColumnDimension($col)
//                ->setAutoSize(true);
//        }
//
//        $spreadsheet->getActiveSheet()->calculateColumnWidths();
//
//// Set setAutoSize(false) so that the widths are not recalculated
//        foreach(range('A', 'E') as $columnID) {
//            $spreadsheet->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(false);
//        }

// Merge cells
//        $spreadsheet->getActiveSheet()->mergeCells("A1:B1");
//        $spreadsheet->getActiveSheet()->mergeCells("A2:B2");
//        $spreadsheet->getActiveSheet()->mergeCells("A3:B3");
//
//        $spreadsheet->getActiveSheet()->mergeCells("C1:E1");
//        $spreadsheet->getActiveSheet()->mergeCells("C2:E2");
//        $spreadsheet->getActiveSheet()->mergeCells("C3:E3");
//
//        $spreadsheet->getActiveSheet()->mergeCells("F1:G1");
//        $spreadsheet->getActiveSheet()->mergeCells("F2:G2");
//        $spreadsheet->getActiveSheet()->mergeCells("F3:G3");

//        $sheet->getColumnDimension('A')->setAutoSize(true);
//        $sheet->getColumnDimension('B')->setAutoSize(true);

//        for ($i = 0; $i < sizeof($data); $i++) {
//            $sheet->setCellValue('A'.(6+$i), 'Tgl. Cetak : ' . date("d/m/Y"));
//        }

        $writer = new Xlsx($spreadsheet);
        $writer->save(storage_path($filename));
        return response()->download(storage_path($filename))->deleteFileAfterSend(true);
    }
}
