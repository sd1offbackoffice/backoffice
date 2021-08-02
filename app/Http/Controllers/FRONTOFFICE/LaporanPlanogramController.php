<?php

namespace App\Http\Controllers\FRONTOFFICE;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use PDF;
use DateTime;

class LaporanPlanogramController extends Controller
{

    public function index()
    {
        return view('FRONTOFFICE.LAPORANPLANOGRAM.laporanPlanogram');
    }

    public function cetak(Request $request)
    {
        $filename = '';
        $cw = '';
        $ch = '';
        $data1 = '';
        $tipe = $request->tipe;
        if ($tipe == '1') {
            $p_rak1 = '';
            $p_rak2 = '';
            $cw = 700;
            $ch = 45;
//            IF :P_ORDER ='PLU'
//  THEN
//  :P_ORDER := 'ORDER BY LKS_PRDCD';
//  ELSIF :P_ORDER ='RAK'
//  THEN
//  :P_ORDER := 'ORDER BY LOKASI';
//  ELSIF :P_ORDER ='QTY'
//  THEN
//  :P_ORDER := 'ORDER BY LKS_QTY';
//  END IF;
            $data1 = DB::select("SELECT prs_namacabang,
                                           prs_namaperusahaan,
                                           lks_koderak || '.' || lks_kodesubrak || '.'
                                           || lks_tiperak || '.' || lks_shelvingrak || '.'
                                           || lks_nourut lokasi,
                                           nvl(lks_prdcd,'-') lks_prdcd,
                                           prd_deskripsipanjang,
                                           lks_qty
                                      FROM tbmaster_perusahaan, tbmaster_lokasi, tbmaster_prodmast
                                     WHERE prs_kodeigr = '" . $_SESSION['kdigr'] . "' AND prs_kodeigr = lks_kodeigr AND lks_prdcd = prd_prdcd(+)
                                           AND lks_koderak between '" . $p_rak1. "' and '" . $p_rak2. "'
                                           AND lks_qty < 0 " . $p_order);
            $filename = 'lap-qty-planogram-minus-pdf';
        } else {
//            IF :P_ORDER ='PLU'
//          THEN
//          :P_ORDER := 'ORDER BY SPB_PRDCD';
//          ELSIF :P_ORDER ='RAK'
//          THEN
//          :P_ORDER := 'ORDER BY SPB_LOKASITUJUAN';
//          ELSIF :P_ORDER ='TGL'
//          THEN
//          :P_ORDER := 'ORDER BY SPB_CREATE_DT DESC';
//          END IF;
            $cw = 700;
            $ch = 45;
            $data1 = DB::select("SELECT   ROWNUM NUMB, CASE
                                             WHEN SPB_RECORDID = '1'
                                                 THEN 'SUDAH'
                                             ELSE 'BELUM'
                                         END REALISASI, SPB_PRDCD, SPB_LOKASIASAL, SPB_LOKASITUJUAN,
                                            TO_CHAR (SPB_CREATE_DT, 'DD-MM-RR')
                                         || ' '
                                         || TO_CHAR (SPB_CREATE_DT, 'HH24:MI:SS') SPB_CREATE_DT,
                                         SPB_CREATE_BY, SPB_MINUS, PRD_DESKRIPSIPANJANG, PRD_UNIT || '/' || PRD_FRAC SATUAN
                                    FROM TBTR_ANTRIANSPB, TBMASTER_PRODMAST
                                   WHERE SPB_PRDCD = PRD_PRDCD AND SPB_JENIS = 'MANUAL'
                                AND TRUNC(SPB_CREATE_DT) BETWEEN to_date('" . $p_tgl1 . "','dd/mm/yyyy') AND to_date('" . $p_tgl2 . "','dd/mm/yyyy')
                                AND NVL(SPB_RECORDID,'ZZ') LIKE '" . $p_recid . "' " . $p_order);
            $filename = 'lap-spb-manual-pdf';
        }
        $perusahaan = DB::table('tbmaster_perusahaan')
            ->first();


        if (sizeof($data1) != 0) {
            $data = [
                'perusahaan' => $perusahaan,
                'data1' => $data1,
                'data2' => $data2,
                'tgl1' => $tgl1,
                'tgl2' => $tgl2
            ];

            $dompdf = new PDF();

            $pdf = PDF::loadview('BACKOFFICE.CETAKDOKUMEN.' . $filename . '-pdf', $data);

            error_reporting(E_ALL ^ E_DEPRECATED);

            $pdf->output();
            $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);

            $canvas = $dompdf->get_canvas();
            $canvas->page_text($cw, $ch, "{PAGE_NUM} dari {PAGE_COUNT}", null, 7, array(0, 0, 0));

            $dompdf = $pdf;

            file_put_contents($filename . '.pdf', $pdf->output());

            return $filename . '.pdf';
        }
    }
