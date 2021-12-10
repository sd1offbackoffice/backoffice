<?php

namespace App\Http\Controllers\OMI;

use App\Http\Controllers\Auth\loginController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller; use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use XBase\TableReader;
use ZipArchive;
use File;
use PDF;

class ProsesBKLDalamKotaController extends Controller
{
    public function index(){
        return view('OMI.proses-bkl-dalam-kota');
    }

    public function prosesFile(Request  $request){
        $userId     = Session::get('usid');
        $kodeigr    = Session::get('kdigr');
        $ip         = Session::get('ip');
        $file       = $request->file('file');
        $filename   = '';
        $list = [];
        $tempReportId = [];
        $sesiproc = rand(11,99).date('His');

        DB::connection(Session::get('connection'))->table('temp_cetak_tolakanbkldalamkota')->delete();
        DB::connection(Session::get('connection'))->table('temp_list_bkldalamkota')->delete();

        $stat = DB::connection(Session::get('connection'))->table('tbmaster_computer')->where('ip', $ip)->where('kodeigr', $kodeigr)->get()->toArray();
        $station = ($stat)? $stat[0]->station : '';

        if (strtolower($file->getClientOriginalExtension()) == 'zip'){
            $zip = new ZipArchive;

            if ($zip->open($file) === TRUE) {
                for ($i = 0; $i < $zip->numFiles; $i++) {
                    $entry = $zip->getNameIndex($i);
                    $list[] = $entry;
                }

                $filename = substr($file->getClientOriginalName(), 0, strpos($file->getClientOriginalName(),'.'));
                $filename = $filename.'.DBF';

                $zip->extractTo(public_path('DBF'));
                $zip->close();
            } else {
                $status = 'error';
                $alert = 'Terjadi kesalahan!';
                $message = 'Mohon pastikan file zip berasal dari program Transfer SJ - IAS!';

                return compact(['status', 'alert', 'message']);
            }
        } else {
            $filename = $file->getClientOriginalName();

            $file->move(public_path("/DBF"), $filename);
        }

        $table = new TableReader(public_path('/DBF/'.$filename));

        while ($record = $table->nextRecord()) {
            DB::connection(Session::get('connection'))->table('temp_bkl_dalamkota')->insert([ 'recid' => 5, 'gudang' => $record->get('gudang'),
                    'id' => $record->get('id'), 'lokasi' => $record->get('lokasi'), 'rtype' => $record->get('rtype'),
                    'bukti_no' => $record->get('bukti_no'), 'bukti_tgl' => $record->get('bukti_tgl'), 'supco' => $record->get('supco'),
                    'cr_term' => $record->get('cr_term'), 'prdcd' => $record->get('prdcd'), 'qty' => $record->get('qty'),
                    'bonus' => $record->get('bonus'), 'price' => $record->get('price'), 'gross' => $record->get('gross'),
                    'ppn' => $record->get('ppn'), 'fmdfee' => $record->get('fmdfee'), 'ppnfee' => $record->get('ppnfee'),
                    'ppnbm' => $record->get('ppnbm'), 'hrg_botol' => $record->get('hrg_botol'), 'disc1' => $record->get('disc1'),
                    'disc2' => $record->get('disc2'), 'disc3' => $record->get('disc3'), 'disc4cr' => $record->get('disc4cr'),
                    'disc4rr' => $record->get('disc4rr'), 'disc4jr' => $record->get('disc4jr'), 'invno' => $record->get('invno'),
                    'inv_date' => $record->get('inv_date'), 'po_no' => $record->get('po_no'), 'po_date' => $record->get('po_date'),
                    'istype' => $record->get('istype'), 'bkl' => $record->get('bkl'), 'jam' => $record->get('jam'),
                    'keter' => $record->get('keter'), 'nosph' => $record->get('nosph') ?? ' ',
                    'sessid' => $sesiproc, 'namafile' => $filename,
                ]);
        }

        $moveData = DB::connection(Session::get('connection'))->insert("INSERT INTO temp_bkl_dalamkota_full
                  (SELECT bkl.*, SYSDATE
                     FROM temp_bkl_dalamkota bkl
                    WHERE sessid = $sesiproc AND namafile = '$filename')");

        //testing report
//        DB::connection(Session::get('connection'))->insert("INSERT INTO temp_cetak_tolakanbkldalamkota
//                  (SELECT gudang, bukti_no, bukti_tgl, supco,prdcd,qty, bonus, keter, sessid, namafile
//                     FROM temp_bkl_dalamkota bkl
//                    WHERE sessid = $sesiproc AND namafile = '$filename')");
//
//        DB::connection(Session::get('connection'))->insert("INSERT INTO temp_list_bkldalamkota
//                  (SELECT gudang, bukti_no, bukti_tgl, supco,prdcd,qty, bonus, price, gross, 12345, inv_date, istype, sessid, namafile
//                     FROM temp_bkl_dalamkota bkl
//                    WHERE sessid = $sesiproc AND namafile = '$filename')");

        $connect = loginController::getConnectionProcedure();

        $exec = oci_parse($connect, "BEGIN  SP_PROSES_DATA_BKL_OMI_WEB(:sesiproc, :namafiler, :stat, :kodeigr, :userid, :param_proses, :result_kode, :result_msg, :param_all_kasir); END;");
        oci_bind_by_name($exec, ':sesiproc', $sesiproc,100);
        oci_bind_by_name($exec, ':namafiler', $filename,100);
        oci_bind_by_name($exec, ':stat', $station,100);
        oci_bind_by_name($exec, ':kodeigr', $kodeigr,100);
        oci_bind_by_name($exec, ':userid', $userId,100);
        oci_bind_by_name($exec, ':param_proses', $param_proses,100);
        oci_bind_by_name($exec, ':result_kode', $res_kode,100);
        oci_bind_by_name($exec, ':result_msg', $res_msg,1000);
        oci_bind_by_name($exec, ':param_all_kasir', $param_all_kasir,1000);
        oci_execute($exec);

//        Testing report
//        $param_proses = 1;
//        $res_kode = 1;
//        $res_msg = 'oke';
//        $param_all_kasir = "000015";

        if ($param_proses == 1){
            $temp = DB::connection(Session::get('connection'))->table('temp_list_bkldalamkota')->where('sessid', $sesiproc)
                ->where('namafile', $filename)->get()->toArray();

            if ($temp){
                array_push($tempReportId,'1','2','3','4');
            }

            $temp = DB::connection(Session::get('connection'))->table('temp_cetak_tolakanbkldalamkota')->where('sessid', $sesiproc)
                ->where('namafile', $filename)->get()->toArray();

            if ($temp){
                array_push($tempReportId,'5');
            }
        }

//        DB::connection(Session::get('connection'))->table('temp_bkl_dalamkota')->where('sessid', $sesiproc)->where('namafile', $filename)->delete();

        $data = ['sesiproc' => $sesiproc, 'namafiler' => $filename, 'report_id' => $tempReportId, 'param_all_kasir' => $param_all_kasir];
        return response()->json(['kode' => $res_kode, 'msg' => $res_msg, 'data' => $data]);
    }

    public function cetakLaporan(Request $request){
        $report_id  = $request->report_id;
        $size       = $request->size;
        $filename   = $request->filename;
        $sesiproc   = $request->sesiproc;
        $kasir      = $request->kasir;
        $kodeigr    = Session::get('kdigr');
        $userId     = Session::get('usid');
        $ip         = Session::get('ip');
        $bladeName  = '';
        $paperFormat= 'potrait';
        $pageNum1   = -10;
        $pageNum2   = -10;
        $result     = '';

        if ($report_id == 1){
            $result     = ($size == 'K') ? $this->laporanList($filename,$sesiproc,$kodeigr) : $this->laporanListDetail($filename,$sesiproc,$kodeigr);
            $bladeName  = ($size == 'K') ? "OMI.proses-bkl-list-pdf" : "OMI.proses-bkl-list-detail-pdf";
            $paperFormat = ($size == 'K') ? "potrait" : "landscape";
            $pageNum1   = ($size == 'K') ? 507 : 507; // list detail yg lama menggunakan landsacpe di koor : 756
            $pageNum2   = 77.75;
        } elseif ($report_id == 2){
            $noPO = DB::connection(Session::get('connection'))->select("SELECT *
                                          FROM (SELECT DISTINCT no_bukti, kodetoko, tgl_bukti,  msth_nodoc
                                                  FROM temp_list_bkldalamkota, TBTR_MSTRAN_H
                                                 WHERE     TRIM (NAMAFILE) LIKE '%$filename%'
                                                       AND sessid = '$sesiproc'
                                                       AND MSTH_KODEIGR = '$kodeigr'
                                                       AND TRIM (MSTH_NOFAKTUR) = TRIM (kodetoko || no_bukti)
                                                       AND MSTH_TGLFAKTUR = tgl_bukti) A");

            $result     = $this->laporanBpb($kodeigr, $noPO[0]->msth_nodoc ?? '00000');
            $bladeName  = "OMI.proses-bkl-bpb-pdf";
        } elseif ($report_id == 3){
            $result     = $this->laporanStruk($kodeigr, $kasir);
            $bladeName  = "OMI.proses-bkl-struk-pdf";
        } elseif ($report_id == 4){
            $connect = loginController::getConnectionProcedure();
            $execute = oci_parse($connect, "BEGIN :ret := F_IGR_GET_NOMOR('".Session::get('kdigr')."','RST','Nomor Reset Kasir','R' || TO_CHAR(SYSDATE, 'yy'),5,TRUE); END;");
            oci_bind_by_name($execute, ':ret', $noDoc, 32);
            oci_execute($execute);

            $stat = DB::connection(Session::get('connection'))->table('tbmaster_computer')->select('station')
                ->where('ip', $ip)->where('kodeigr', $kodeigr)->get()->first();
            $stat = $stat->station ?? '...';

            $result     = $this->laporanReset($noDoc, $kodeigr, $stat, $userId);
            $jmlh_trans = DB::connection(Session::get('connection'))->select("select nvl(count(*),0) as total from (
                                              SELECT DISTINCT trjd_transactionno
                                              FROM tbtr_jualdetail
                                              WHERE trjd_kodeigr = '$kodeigr'
                                              AND trjd_create_by = 'BKL'
                                              AND TRUNC(trjd_transactiondate) = TRUNC(sysdate)
                                              AND trjd_cashierstation =  $stat) a");

            $result[0]->jmlh_trans = $jmlh_trans[0]->total;
            $bladeName  = "OMI.prosesBKL-reset-pdf";
        } elseif ($report_id == 5){
            $result     = $this->laporanTolakan($filename,$sesiproc,$kodeigr);
            $pageNum1   = 507;
            $pageNum2   = 77.75;
            $bladeName  = "OMI.proses-bkl-tolakan-pdf";
        }

        $perusahaan = DB::connection(Session::get('connection'))->table('tbmaster_perusahaan')->first();

        $pdf = PDF::loadview("$bladeName",[ 'data' => $result, 'perusahaan' => $perusahaan]);
        $pdf->setPaper('A4', $paperFormat);
        $pdf->output();
        $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);

        $canvas = $dompdf ->get_canvas();
        $canvas->page_text($pageNum1, $pageNum2, "{PAGE_NUM} dari {PAGE_COUNT}", null, 7, array(0, 0, 0));


        return $pdf->stream("$bladeName");
    }

    public function laporanList($filename,$sesiproc,$kodeigr){
        return DB::connection(Session::get('connection'))->select(" SELECT no_bukti, tgl_bukti, kodetoko, cus_kodemember, cus_namamember, kodesupplier, sup_namasupplier, no_tran, TRUNC (tgl_tran) as tgl_tran, prs_namaperusahaan,
                                            prs_namacabang, prs_namawilayah, SUM (harga) harga, SUM (gross) gross
                                        FROM (SELECT bkl.no_bukti, bkl.tgl_bukti, bkl.kodetoko, cus_kodemember, cus_namamember, bkl.kodesupplier, sup_namasupplier, bkl.no_tran,
                                                     bkl.tgl_tran, bkl.harga, bkl.gross, prs_namaperusahaan, prs_namacabang, prs_namawilayah
                                                FROM temp_list_bkldalamkota bkl,
                                                     tbmaster_tokoigr,
                                                     tbmaster_Customer,
                                                     tbmaster_supplier,
                                                     tbmaster_perusahaan
                                               WHERE     bkl.sessid = '$sesiproc'
                                                     AND bkl.namafile = '$filename'
                                                     AND tko_kodeigr = '$kodeigr'
                                                     AND tko_kodeomi = bkl.kodetoko
                                                     AND cus_kodeigr = '$kodeigr'
                                                     AND cus_kodemember = tko_kodecustomer
                                                     AND sup_kodeigr = '$kodeigr'
                                                     AND sup_kodesupplier = bkl.kodesupplier
                                                     AND prs_kodeigr = '$kodeigr') a
                                    GROUP BY no_bukti,
                                             tgl_bukti,
                                             kodetoko,
                                             cus_kodemember,
                                             cus_namamember,
                                             kodesupplier,
                                             sup_namasupplier,
                                             no_tran,
                                             TRUNC (tgl_tran),
                                             prs_namaperusahaan,
                                             prs_namacabang,
                                             prs_namawilayah
                                    ORDER BY no_bukti, tgl_bukti, kodetoko");


    }

    public function laporanListDetail($filename,$sesiproc,$kodeigr){
        return DB::connection(Session::get('connection'))->select("SELECT no_bukti, trunc(tgl_bukti) tgl_bukti, kodetoko, cus_kodemember,
                                    kodesupplier, sup_namasupplier, no_tran, trunc(tgl_tran) tgl_tran, prdcd,  qty, bonus,
                                    prd_deskripsipendek, prd_unit || '/' || prd_frac satuan, harga, gross, gross total,
                                    prs_namaperusahaan, prs_namacabang, prs_namawilayah
                                    FROM temp_list_bkldalamkota, tbmaster_tokoigr, tbmaster_Customer, tbmaster_supplier, tbmaster_prodmast, tbmaster_perusahaan
                                    WHERE sessid = '$sesiproc' AND namafile = '$filename'
                                    AND tko_kodeigr = '$kodeigr' AND tko_kodeomi = kodetoko
                                    AND cus_kodeigr = '$kodeigr' AND cus_kodemember = tko_kodecustomer
                                    AND sup_kodeigr = '$kodeigr' AND sup_kodesupplier = kodesupplier
                                    AND prd_kodeigr = '$kodeigr' AND prd_prdcd = prdcd
                                    AND prs_kodeigr = '$kodeigr'
                                    --and prd_deskripsipendek like '%SOFTEX PL DS NP 50%'
                                    ");


    }

    public function laporanBpb($kodeigr, $no_po){
        return DB::connection(Session::get('connection'))->select("SELECT  msth_nodoc, msth_tgldoc, msth_nopo, msth_tglpo, msth_nofaktur, msth_tglfaktur, msth_cterm, msth_flagdoc, (TRUNC (mstd_tgldoc) + msth_cterm) tgljt,
                                           mstd_cterm, mstd_typetrn, prs_namaperusahaan, prs_namacabang, prs_npwp, prs_alamatfakturpajak1, prs_alamatfakturpajak2, prs_alamatfakturpajak3,
                                           sup_kodesupplier || ' ' || sup_namasupplier || '/' || sup_singkatansupplier supplier,
                                           sup_npwp,
                                           sup_alamatsupplier1 || '   ' || sup_alamatsupplier2 alamat_supplier,
                                           sup_telpsupplier,
                                           sup_contactperson contact_person,
                                           sup_kotasupplier3,
                                           mstd_prdcd || ' ' || prd_deskripsipanjang plu,
                                           mstd_unit || '/' || mstd_frac kemasan,
                                           FLOOR (mstd_qty / mstd_frac) qty,
                                           MOD (mstd_qty, mstd_frac) qtyk,
                                           mstd_hrgsatuan, mstd_ppnrph, mstd_ppnbmrph, mstd_ppnbtlrph,
                                           NVL (mstd_gross, 0) - NVL (mstd_discrph, 0) + NVL (mstd_dis4cr, 0) + NVL (mstd_dis4rr, 0) + NVL (mstd_dis4jr, 0) jumlah,
                                           ROUND (NVL (mstd_gross, 0) - NVL (mstd_discrph, 0) + NVL (mstd_dis4cr, 0) + NVL (mstd_dis4rr, 0) + NVL (mstd_dis4jr, 0)) JML,
                                           NVL (mstd_rphdisc1, 0) rphdisc1,
                                           (NVL (mstd_rphdisc2, 0) + NVL (mstd_rphdisc2ii, 0) + NVL (mstd_rphdisc2iii, 0)) disc2,
                                           NVL (mstd_rphdisc3, 0) rphdisc3,
                                           NVL (mstd_qtybonus1, 0) qtybonus1,
                                           NVL (mstd_qtybonus2, 0) qtybonus2,
                                           NVL (mstd_keterangan, 'OO') keterangan,
                                           (NVL (mstd_dis4cr, 0) + NVL (mstd_dis4rr, 0) + NVL (mstd_dis4jr, 0)) dis4,
                                           CASE
                                              WHEN NVL (mstd_kodesupplier, '11111') <> '11111' THEN '( PROFORMA)'
                                              ELSE '( LAIN - LAIN )'
                                           END
                                              judul
                                      FROM tbtr_mstran_h,
                                           tbmaster_perusahaan,
                                           tbmaster_supplier,
                                           tbtr_mstran_d,
                                           tbmaster_prodmast
                                     WHERE     msth_kodeigr = '$kodeigr'
                                           AND prs_kodeigr = msth_kodeigr
                                           AND sup_kodesupplier(+) = msth_kodesupplier
                                           AND sup_kodeigr(+) = msth_kodeigr
                                           AND mstd_nodoc = msth_nodoc
                                           AND mstd_kodeigr = msth_kodeigr
                                           AND prd_kodeigr = msth_kodeigr
                                           AND prd_prdcd = mstd_prdcd
                                           --&p_and
                                           AND msth_nodoc = '$no_po'");
    }

    public function laporanStruk($kodeigr, $kasir){
        return DB::connection(Session::get('connection'))->select("SELECT 'NPWP : ' || prs_npwp prs_npwp,  prs_namaperusahaan, prs_namacabang, prs_alamat1, prs_alamat2||' '||prs_alamat3 alamat, 'Telp : ' || prs_telepon PRS_TELEPON,
                                        trjd_create_by, trjd_cashierstation, trjd_transactionno, prd_deskripsipendek, '( ' || trjd_prdcd || ')' TRJD_PRDCD, trjd_quantity,
                                        trjd_baseprice, nvl(trjd_discount,0) trjd_discount, trjd_nominalamt,
                                        trjd_admfee, trjd_cus_kodemember, cus_namamember, SUBSTR(jh_kmmcode,1, INSTR(jh_kmmcode,' ')-1) nobukti, tko_namaomi,
                                        prs_kodemto || '.BKL.' || trjd_cashierstation || '.' || trjd_transactionno nomor,
                                        TO_CHAR(SYSDATE, 'dd-MM-yy hh:mm:ss') TANGGAL, round(tko_persendistributionfee) || ' %' fee
                                        FROM tbtr_jualdetail, tbtr_jualheader, tbmaster_prodmast, tbmaster_customer, tbmaster_tokoigr, tbmaster_perusahaan
                                        WHERE prs_kodeigr = '$kodeigr' and trjd_kodeigr = '$kodeigr'
                                        AND trjd_create_by = 'BKL'
                                        AND TRUNC(trjd_transactiondate) = trunc(sysdate)
                                        AND jh_kodeigr = '$kodeigr'
                                        AND jh_cashierid = 'BKL'
                                        AND jh_transactionno = trjd_transactionno
                                        AND jh_cashierstation = trjd_cashierstation
                                        AND TRUNC(jh_transactiondate) = TRUNC(trjd_transactiondate)
                                        AND prd_kodeigr = '$kodeigr'  AND prd_prdcd = trjd_prdcd
                                        AND cus_kodeigr = '$kodeigr'
                                        AND cus_kodemember = trjd_cus_kodemember
                                        AND tko_kodeigr = '$kodeigr'
                                        AND tko_kodecustomer = trjd_cus_kodemember
                                        and trjd_transactionno || trjd_cashierstation IN (''||'$kasir'||'')");
    }

    public function laporanReset($noDoc, $kodeigr, $station, $userId){
        return DB::connection(Session::get('connection'))->select("SELECT js_totcreditsalesamt, prs_kodecabang, js_cashierstation, prs_namaperusahaan, prs_namacabang, 'No. Reset : ' || '$noDoc' nomor, TO_CHAR(SYSDATE,'dd-MM-yy') tgl, TO_CHAR(SYSDATE, 'hh:mm:ss') jam, 0 void, userid,  username
                                FROM TBTR_JUALSUMMARY, TBMASTER_PERUSAHAAN, TBMASTER_USER
                                WHERE js_kodeigr = '$kodeigr'
                                AND js_cashierid = 'BKL'
                                AND js_cashierstation = '$station'
                                AND TRUNC(js_transactiondate) = TRUNC(SYSDATE)
                                AND KODEIGR(+) = '$kodeigr'
                                AND userid(+) = '$userId'
                                AND prs_kodeigr = '$kodeigr'");
    }

    public function laporanTolakan($filename,$sesiproc, $kodeigr){
        return DB::connection(Session::get('connection'))->select("SELECT kodetoko, tko_namaomi, no_bukti, tgl_bukti, kodesupplier, prdcd, qty, bonus, keterangan,
                                        prd_deskripsipendek, prd_unit || '/' || prd_frac satuan, prs_namaperusahaan, prs_namacabang, prs_namawilayah
                                  FROM temp_cetak_tolakanbkldalamkota,
                                       tbmaster_perusahaan,
                                       tbmaster_prodmast,
                                       tbmaster_tokoigr
                                 WHERE     sessid = '$sesiproc'
                                       AND namafile = '$filename'
                                       AND prd_kodeigr(+) = '$kodeigr'
                                       AND prd_prdcd(+) = prdcd
                                       AND tko_kodeigr(+) = '$kodeigr'
                                       AND tko_kodeomi(+) = kodetoko
                                       AND prs_kodeigr = '$kodeigr'");
    }





}
