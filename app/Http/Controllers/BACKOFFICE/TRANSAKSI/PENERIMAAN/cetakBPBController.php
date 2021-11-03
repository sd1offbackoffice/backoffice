<?php

namespace App\Http\Controllers\BACKOFFICE\TRANSAKSI\PENERIMAAN;

use PDF;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\DataTables;

class cetakBPBController extends Controller {
    public function index(){
        return view('BACKOFFICE.TRANSAKSI.PENERIMAAN.cetakBPB');
    }

    public function showPO(){
        $kodeigr = $_SESSION['kdigr'];

        $data = DB::select("SELECT tpoh_nopo, sup_kodesupplier || '-' || sup_namasupplier supplier
                                  FROM tbtr_po_h, tbmaster_supplier
                                 WHERE     tpoh_kodeigr = '$kodeigr'
                                       AND NVL (tpoh_recordid, '9') <> '1'
                                       AND sup_kodesupplier = tpoh_kodesupplier
                                       AND sup_kodeigr = tpoh_kodeigr
                                       AND tpoh_tglpo > to_date('01042021','ddmmyyyy')");

        return DataTables::of($data)->make(true);
    }

    public function searchPO(Request  $request){
        $kodeigr = $_SESSION['kdigr'];
        $value  = $request->value;

        $data = DB::select("SELECT tpoh_nopo, sup_kodesupplier || '-' || sup_namasupplier supplier
                                  FROM tbtr_po_h, tbmaster_supplier
                                 WHERE     tpoh_kodeigr = '$kodeigr'
                                       AND NVL (tpoh_recordid, '9') <> '1'
                                       AND sup_kodesupplier = tpoh_kodesupplier
                                       AND sup_kodeigr = tpoh_kodeigr
                                       AND tpoh_nopo = '$value'");

        return response()->json($data);
    }

    public function cetakLaporan(Request  $request){ // 1 => Draf || 2 => Rincian
        $kodeigr    = $_SESSION['kdigr'];
        $typeTrn    = $request->typeTrn;
        $startDate  = $request->startDate;
        $endDate    = $request->endDate;
        $typeLaporan   = $request->typeLaporan;
        $noPO       = $request->noPO;
        $formatLaporan = $request->formatLaporan;
        $ukuranLaporan = $request->ukuranLaporan;

        if ($typeLaporan != 'P1'){
            $result = $this->print_ctk_bpb($kodeigr, $startDate, $endDate, $typeTrn,$typeLaporan);
            Session::put('penerimaan-report-data', $result);

            return response()->json($result);
        } else {
            $result = $this->print_ctk_bpb1($formatLaporan,$ukuranLaporan,$noPO, $kodeigr, $typeTrn);
            Session::put('penerimaan-report-data', $result);

            return response()->json($result);
        }
    }

    public function print_ctk_bpb($kodeigr, $date1, $date2, $typeTrn, $typeLaporan){
        $startDate  = date('Y-m-d', strtotime($date1));
        $endDate    = date('Y-m-d', strtotime($date2));

        if ($typeLaporan == 'B1'){
            $temp = DB::select("SELECT *
                                        FROM TBTR_BACKOFFICE
                                        WHERE TRBO_KODEIGR = '$kodeigr'
                                        AND TRBO_TYPETRN = '$typeTrn'
                                        --AND TRBO_TGLDOC BETWEEN to_date('','yyyy-dd-mm') AND to_date('','yyyy-dd-mm')
                                        AND TRBO_TGLDOC BETWEEN '$startDate' and '$endDate'
                                        AND TRBO_RECORDID <> '2'");

            if (!$temp){
                return ['kode' => 0, 'msg' => "Data Tidak Ditemukan!!", 'data' => ''];
            } else {
                $data = ['url' => 'IGR_BO_BLMPRSBPB', 'kodeigr' => $kodeigr, 'startDate' => $startDate, 'endDate' => $endDate, 'typeTrn' => $typeTrn, 'typeLaporan' => $typeLaporan];
                return ['kode' => 1, 'msg' => "Cetak Laporan", 'data' => $data];
            }
        } else if ($typeLaporan == 'B2'){
            $temp = DB::select("SELECT *
                                        FROM TBTR_MSTRAN_H
                                        WHERE MSTH_KODEIGR = '$kodeigr'
                                        AND MSTH_TYPETRN = '$typeTrn'
                                        AND MSTH_TGLDOC BETWEEN '$startDate' AND '$endDate' ");

            if (!$temp){
                return ['kode' => 0, 'msg' => "Data Tidak Ditemukan!!", 'data' => ''];
            } else {
                $data = ['url' => 'IGR_BO_MONITORBPB', 'kodeigr' => $kodeigr, 'startDate' => $startDate, 'endDate' => $endDate, 'typeTrn' => $typeTrn, 'typeLaporan' => $typeLaporan];
                return ['kode' => 1, 'msg' => "Cetak Laporan", 'data' => $data];
            }
        } else if ($typeLaporan == 'B2'){
            return ['kode' => 1, 'msg' => "Cetak Laporan", 'data' => 'url'];
            //CETAK_BLMPRS_PB (kdoeigr, date1, date2, p_prog:IGR031E, typetrn)
        }
    }

    public function print_ctk_bpb1($formatLaporan, $ukuranLaporan, $noPO, $kodeigr, $typeTrn){
        if ($formatLaporan == 1){
            //CETAK_LIFTDRAF_PO1(KDOEIGR,NOPO,'IGR031G')
            $data = ['url' => 'CETAK_LIFTDRAF_PO1', 'kodeigr' => $kodeigr, 'typeTrn' => $typeTrn, 'noPO' => $noPO];
            return ['kode' => 1, 'msg' => "Cetak Laporan", 'data' => $data];
        } else {
            if ($ukuranLaporan == 'K'){
                $data = ['url' => 'CETAK_LIFTDRAF_PO2', 'kodeigr' => $kodeigr, 'typeTrn' => $typeTrn, 'noPO' => $noPO];
                return ['kode' => 1, 'msg' => "Cetak Laporan", 'data' => $data];
            } else {
                $data = ['url' => 'CETAK_LIFTDRAF_PO3', 'kodeigr' => $kodeigr, 'typeTrn' => $typeTrn, 'noPO' => $noPO];
                return ['kode' => 1, 'msg' => "Cetak Laporan", 'data' => $data];
            }
        }
    }

    public function viewReport(Request $request){
        $data = Session::get('penerimaan-report-data');
        $data = $data['data'];
        $report = $data['url'];

        if ($report == 'IGR_BO_BLMPRSBPB'){
            $datas = $this->IGR_BO_BLMPRSBPB($data);

            $pdf = PDF::loadview('BACKOFFICE.TRANSAKSI.PENERIMAAN.igr_bo_blmprsbpb', ['datas' => $datas])->setPaper('a4', 'landscape');
            $pdf->output();
            $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);
            $canvas = $dompdf ->get_canvas();
            $canvas->page_text(764, 10, "Page {PAGE_NUM} of {PAGE_COUNT}", null, 10, array(0, 0, 0));

            return $pdf->stream('igr_bo_blmprsbpb.pdf');
        }   else if ($report == 'IGR_BO_MONITORBPB'){
            $datas = $this->IGR_BO_MONITORBPB($data);

            foreach ($datas as $value){
                $nqty = $value->qty * $value->mstd_frac + $value->qtyk + $value->mstd_qtybonus1;
                $nlcost = ($nqty > 0) ?  (($value->mstd_gross - $value->mstd_discrph + $value->mstd_ppnbmrph + $value->mstd_ppnbtlrph) / $nqty) * $value->mstd_frac : 0;
                $value->nlcost = $nlcost;
                $value->namt = $value->mstd_gross - $value->mstd_discrph + $value->mstd_ppnbmrph + $value->mstd_ppnbtlrph + $value->mstd_ppnrph;

                if ($value->prd_hrgjual > 0){
                    if ($value->mstd_bkp == 'Y') {
                        $value->nmargin_aktual = ($value->prd_hrgjual != 0) ? (1 - 1.1 * $nlcost / $value->prd_hrgjual) * 100 : 0;
                    } else {
                        $value->nmargin_aktual = ($value->prd_hrgjual != 0) ? (1 -  $nlcost / $value->prd_hrgjual) * 100 : 0;
                    }
                } else {
                    $value->nmargin_aktual = 0;
                }
            }

            $pdf = PDF::loadview('BACKOFFICE.TRANSAKSI.PENERIMAAN.igr_bo_monitorbpb', ['datas' => $datas])->setPaper('a4', 'potrait');
            $pdf->output();
            $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);
            $canvas = $dompdf ->get_canvas();
            $canvas->page_text(518, 10, "Page {PAGE_NUM} of {PAGE_COUNT}", null, 10, array(0, 0, 0));

            return $pdf->stream('igr_bo_monitorbpb.pdf');
        }  else if ($report == 'CETAK_LIFTDRAF_PO1'){
            $datas = $this->IGR_BO_LISTDRAFT_PO1($data);

            foreach ($datas as $value){
                $satjual = DB::select(" select LISTAGG( '[ ' || substr(prd_prdcd,-1) || ' : ' || prd_unit||' / '||prd_frac || ']', ' ') WITHIN GROUP (ORDER BY prd_prdcd) as satjual
                                            from tbmaster_prodmast
                                            where substr(prd_prdcd,1,6)= substr('$value->prd_prdcd',1,6)
                                            and prd_kodeigr = '$value->prs_kodecabang'");

                $value->satjual = $satjual[0]->satjual;
            }

            $pdf = PDF::loadview('BACKOFFICE.TRANSAKSI.PENERIMAAN.igr_bo_listdraft_po1', ['datas' => $datas])->setPaper('a4', 'potrait');
            $pdf->output();
            $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);
            $canvas = $dompdf ->get_canvas();
            $canvas->page_text(518, 10, "Page {PAGE_NUM} of {PAGE_COUNT}", null, 10, array(0, 0, 0));

            return $pdf->stream('igr_bo_listdraft_po1.pdf');
        } else if ($report == 'CETAK_LIFTDRAF_PO2'){
            $datas = $this->IGR_BO_LISTDRAFT_PO2($data);

            foreach ($datas as $value){
                $satjual = DB::select(" select LISTAGG( '[ ' || substr(prd_prdcd,-1) || ' : ' || prd_unit||' / '||prd_frac || ']', ' ') WITHIN GROUP (ORDER BY prd_prdcd) as satjual
                                            from tbmaster_prodmast
                                            where substr(prd_prdcd,1,6)= substr('$value->tpod_prdcd',1,6)
                                            and prd_kodeigr = '$value->prs_kodecabang'");

                $value->satjual = $satjual[0]->satjual;
            }

            $pdf = PDF::loadview('BACKOFFICE.TRANSAKSI.PENERIMAAN.igr_bo_listdraft_po2', ['datas' => $datas])->setPaper('a5', 'potrait');
            $pdf->output();
            $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);
            $canvas = $dompdf ->get_canvas();
            $canvas->page_text(518, 10, "Page {PAGE_NUM} of {PAGE_COUNT}", null, 10, array(0, 0, 0));

            return $pdf->stream('igr_bo_listdraft_po2.pdf');
        } else if ($report == 'CETAK_LIFTDRAF_PO3'){
            $datas = $this->IGR_BO_LISTDRAFT_PO2($data);

            foreach ($datas as $value){
                $satjual = DB::select(" select LISTAGG( '[ ' || substr(prd_prdcd,-1) || ' : ' || prd_unit||' / '||prd_frac || ']', ' ') WITHIN GROUP (ORDER BY prd_prdcd) as satjual
                                            from tbmaster_prodmast
                                            where substr(prd_prdcd,1,6)= substr('$value->tpod_prdcd',1,6)
                                            and prd_kodeigr = '$value->prs_kodecabang'");

                $value->satjual = $satjual[0]->satjual;
            }

            $pdf = PDF::loadview('BACKOFFICE.TRANSAKSI.PENERIMAAN.igr_bo_listdraft_po3', ['datas' => $datas])->setPaper('a4', 'potrait');
            $pdf->output();
            $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);
            $canvas = $dompdf ->get_canvas();
            $canvas->page_text(518, 10, "Page {PAGE_NUM} of {PAGE_COUNT}", null, 10, array(0, 0, 0));

            return $pdf->stream('igr_bo_listdraft_po3.pdf');
        }

        return 0;
    }

    public function IGR_BO_BLMPRSBPB($data){
        $kodeigr = $data['kodeigr'];
        $startDate = $data['startDate'];
        $endDate = $data['endDate'];
        $typeTrn = $data['typeTrn'];

        $datas = DB::select(" SELECT trbo_nodoc,
                                     trbo_tgldoc,
                                     jkwkt,
                                     status,
                                     supplier,
                                     top,
                                     prs_namaperusahaan,
                                     prs_namacabang,
                                     SUM (gross) gross,
                                     SUM (pot) pot,
                                     SUM (ppn) ppn,
                                     SUM (bm) bm,
                                     SUM (btl) btl,
                                     SUM (total) total,
                                    '$startDate' as startdate,
                                    '$endDate' as enddate
                                FROM (SELECT trbo_nodoc,
                                             trbo_tgldoc,
                                             trbo_tgldoc + sup_top jkwkt,
                                             CASE WHEN NVL (trbo_recordid, 9) = 1 THEN 'BATAL' ELSE '' END
                                                status,
                                             NVL (trbo_gross, 0) gross,
                                             NVL (trbo_discrph, 0) pot,
                                             NVL (trbo_ppnrph, 0) ppn,
                                             NVL (trbo_ppnbmrph, 0) bm,
                                             NVL (trbo_ppnbtlrph, 0) btl,
                                               NVL (trbo_gross, 0)
                                             - NVL (trbo_discrph, 0)
                                             + NVL (trbo_ppnrph, 0)
                                             + NVL (trbo_ppnbmrph, 0)
                                             + NVL (trbo_ppnbtlrph, 0)
                                                total,
                                             sup_kodesupplier || '-' || sup_namasupplier supplier,
                                             sup_top top,
                                             prs_namaperusahaan,
                                             prs_namacabang
                                        FROM tbtr_backoffice, tbmaster_supplier, tbmaster_perusahaan
                                       WHERE     trbo_kodeigr = '$kodeigr'
                                             AND trbo_typetrn = '$typeTrn'
                                             AND trbo_tgldoc BETWEEN '$startDate' and '$endDate'
                                             AND NVL (trbo_recordid, '0') <> '2'
                                             AND sup_kodesupplier(+) = trbo_kodesupplier
                                             AND sup_kodeigr(+) = trbo_kodeigr
                                             AND prs_kodeigr = trbo_kodeigr)
                            GROUP BY trbo_nodoc,
                                     trbo_tgldoc,
                                     jkwkt,
                                     status,
                                     supplier,
                                     top,
                                     prs_namaperusahaan,
                                     prs_namacabang      ");

        return $datas;
    }

    public function IGR_BO_MONITORBPB($data){
        $kodeigr = $data['kodeigr'];
        $startDate = $data['startDate'];
        $endDate = $data['endDate'];
        $typeTrn = $data['typeTrn'];

        $datas = DB::select(" SELECT    mstd_nodoc
                                             || ' '
                                             || CASE WHEN msth_flagdoc = 'Y' THEN '(REPRINT)' ELSE '' END
                                                nomor,
                                             mstd_tgldoc,
                                             mstd_nopo,
                                             mstd_tglpo,
                                             mstd_frac,
                                             mstd_cterm,
                                             mstd_tgldoc + msth_cterm jth_tempo,
                                             mstd_qty,
                                             mstd_nofaktur,
                                             mstd_tglfaktur,
                                             mstd_prdcd,
                                             mstd_bkp,
                                             mstd_unit || '/' || mstd_frac satuan,
                                             mstd_gross,
                                             mstd_discrph,
                                             mstd_ppnbmrph,
                                             mstd_ppnrph,
                                             mstd_ppnbtlrph,
                                             mstd_avgcost,
                                             msth_cterm,
                                             FLOOR (mstd_qty / mstd_frac) qty,
                                             MOD (mstd_qty, mstd_frac) qtyk,
                                             mstd_qtybonus1,
                                             mstd_qtybonus2,
                                                sup_kodesupplier
                                             || ' - '
                                             || sup_namasupplier
                                             || CASE
                                                   WHEN sup_singkatansupplier IS NOT NULL
                                                   THEN
                                                      '/' || sup_singkatansupplier
                                                   ELSE
                                                      ''
                                                END
                                                supplier,
                                             sup_alamatsupplier1,
                                             sup_alamatsupplier2,
                                             sup_kotasupplier3,
                                             sup_telpsupplier,
                                             sup_npwp,
                                             sup_contactperson,
                                             prd_deskripsipanjang,
                                             prd_hrgjual,
                                             prd_markupstandard,
                                             prd_kodetag,
                                             prs_namaperusahaan,
                                             prs_namacabang
                                        FROM tbtr_mstran_h,
                                             tbtr_mstran_d,
                                             tbmaster_supplier,
                                             tbmaster_prodmast,
                                             tbmaster_perusahaan
                                       WHERE     msth_kodeigr = '$kodeigr'
                                             AND msth_typetrn = '$typeTrn'
                                             AND msth_tgldoc  BETWEEN '$startDate' AND '$endDate'
                                             AND mstd_kodeigr = msth_kodeigr
                                             AND mstd_nodoc = msth_nodoc
                                             AND mstd_tgldoc = msth_tgldoc
                                             AND sup_kodesupplier(+) = msth_kodesupplier
                                             AND sup_kodeigr(+) = msth_kodeigr
                                             AND prd_prdcd = mstd_prdcd
                                             AND prd_kodeigr = mstd_kodeigr
                                             AND prs_kodeigr = msth_kodeigr
                                             AND prd_kodetag = 'L' --sementara(dilimit)
                                             -- and mstd_nodoc = '02125351'
                                    ORDER BY nomor DESC");

        return $datas;
    }

    public function IGR_BO_LISTDRAFT_PO1($data){
        $kodeigr = $data['kodeigr'];
        $noPO   = $data['noPO'];

        $datas = DB::select("SELECT TPOH_NOPO,
                                           TPOH_TGLPO,
                                           TPOH_KODESUPPLIER,
                                           TPOH_NOPO,
                                           tpod_prdcd,
                                           FLOOR (tpod_qtypo / prd_isibeli) qty,
                                           MOD (tpod_qtypo, prd_isibeli) qtyk,
                                           tpod_hrgsatuan,
                                           tpod_gross,
                                           tpod_rphttldisc,
                                           tpod_ppn,
                                           tpod_ppnbm,
                                           tpod_ppnbotol,
                                           CASE
                                              WHEN NVL (tpod_persentasedisc1, 0) <> 0
                                              THEN
                                                 '% ' || TO_CHAR (tpod_persentasedisc1, '99d90')
                                              ELSE
                                                    TRIM (tpod_flagdisc1)
                                                 || ' '
                                                 || TO_CHAR (tpod_rphdisc1, '999g999g999g999d90')
                                           END
                                              discount1,
                                           CASE
                                              WHEN NVL (tpod_persentasedisc2, 0) <> 0
                                              THEN
                                                 '% ' || TO_CHAR (tpod_persentasedisc2, '99d90')
                                              ELSE
                                                    TRIM (tpod_flagdisc2)
                                                 || ' '
                                                 || TO_CHAR (tpod_rphdisc2, '999g999g999g999d90')
                                           END
                                              discount2,
                                           CASE
                                              WHEN NVL (tpod_persentasedisc3, 0) <> 0
                                              THEN
                                                 '% ' || TO_CHAR (tpod_persentasedisc3, '99d90')
                                              ELSE
                                                    TRIM (tpod_flagdisc3)
                                                 || ' '
                                                 || TO_CHAR (tpod_rphdisc3, '999g999g999g999d90')
                                           END
                                              discount3,
                                           tpod_bonuspo1,
                                           tpod_bonuspo2,
                                           tpod_bonusbpb1,
                                           tpod_bonusbpb2,
                                           pbd_NOPO,
                                           prd_deskripsipanjang,
                                           prd_unit || '/' || prd_isibeli konversi,
                                           prd_kodetag,
                                           prd_prdcd,
                                           prs_kodecabang,
                                           prs_namaperusahaan,
                                           prs_namacabang,
                                           prs_namawilayah,
                                              sup_kodesupplier
                                           || ' - '
                                           || sup_namasupplier
                                           || CASE
                                                 WHEN sup_singkatansupplier IS NOT NULL
                                                 THEN
                                                    '/' || sup_singkatansupplier
                                                 ELSE
                                                    ''
                                              END
                                              supplier
                                      FROM tbtr_po_h,
                                           tbtr_po_d,
                                           tbtr_pb_d,
                                           tbmaster_prodmast,
                                           tbmaster_perusahaan,
                                           tbmaster_supplier
                                     WHERE     tpoh_kodeigr = '$kodeigr'
                                           AND tpoh_nopo = '$noPO'
                                           AND NVL (tpoh_recordid, '9') <> 1
                                           AND tpod_nopo = tpoh_nopo
                                           AND tpod_kodeigr = tpoh_kodeigr
                                           AND pbd_nopo(+) = tpod_nopo
                                           AND pbd_kodeigr(+) = tpod_kodeigr
                                           AND pbd_prdcd(+) = tpod_prdcd
                                           AND prd_prdcd = tpod_prdcd
                                           AND prd_kodeigr = tpod_kodeigr
                                           AND prs_kodeigr = tpoh_kodeigr
                                           AND sup_kodesupplier(+) = tpoh_kodesupplier
                                           AND sup_kodeigr(+) = tpoh_kodeigr");

        return $datas;
    }

    public function IGR_BO_LISTDRAFT_PO2($data){
        $kodeigr = $data['kodeigr'];
        $noPO   = $data['noPO'];

        $datas = DB::select(" SELECT tpoh_nopo,
                                         tpoh_tglpo,
                                         tpod_prdcd,
                                         tpod_satuanbeli || '/' || tpod_isibeli satuan,
                                         tpod_bonuspo1,
                                         tpod_bonuspo2,
                                         pbh_nopb,
                                         pbh_tglpb,
                                         pbh_nopb,
                                         sup_kodesupplier || '-' || sup_namasupplier supplier,
                                         prd_deskripsipanjang,
                                         prd_flagbarcode1,
                                         prs_namaperusahaan,
                                         prs_namacabang,
                                         prs_kodecabang,
                                         prs_namasbu
                                    FROM tbtr_po_h,
                                         tbtr_po_d,
                                         tbtr_pb_d,
                                         tbtr_pb_h,
                                         tbmaster_supplier,
                                         tbmaster_prodmast,
                                         tbmaster_perusahaan
                                   WHERE     tpoh_nopo = '$noPO'
                                         AND tpoh_kodeigr = '$kodeigr'
                                         AND tpod_nopo = tpoh_nopo
                                         AND tpod_kodeigr = tpoh_kodeigr
                                         AND pbd_prdcd(+) = tpod_prdcd
                                         AND pbd_nopo(+) = tpod_nopo
                                         AND pbd_kodeigr(+) = tpod_kodeigr
                                         AND pbh_nopb(+) = pbd_nopb
                                         AND pbh_kodeigr(+) = pbd_kodeigr
                                         AND sup_kodesupplier(+) = tpoh_kodesupplier
                                         AND sup_kodeigr(+) = tpoh_kodeigr
                                         AND prd_prdcd = tpod_prdcd
                                         AND prd_kodeigr = tpod_kodeigr
                                         AND prs_kodeigr = tpoh_kodeigr
                                ORDER BY tpod_nourut");

        return $datas;
    }

}
