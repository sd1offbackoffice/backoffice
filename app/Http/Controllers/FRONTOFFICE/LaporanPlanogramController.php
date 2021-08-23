<?php

namespace App\Http\Controllers\FRONTOFFICE;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use PDF;
use DateTime;
use Yajra\DataTables\DataTables;

class LaporanPlanogramController extends Controller
{

    public function index()
    {


        return view('FRONTOFFICE.LAPORANPLANOGRAM.laporanPlanogram');
    }

    public function lovKodeRak(Request $request)
    {
        $search = $request->value;
        $data = DB::table('tbmaster_lokasi')
            ->select('lks_koderak')
            ->Where('lks_koderak','LIKE', '%'.$search.'%')
            ->orderBy('lks_koderak')
            ->limit(100)
            ->distinct()
            ->get();
        return DataTables::of($data)->make(true);
    }
    public function cetak(Request $request)
    {
        $filename = '';
        $cw = '';
        $ch = '';
        $data1 = '';
        $p_order = '';
        $menu = $request->menu;
        $rak1 = $request->rak1;
        $rak2 = $request->rak2;
        $tgl1 = $request->tgl1;
        $tgl2 = $request->tgl2;
        $realisasi = $request->realisasi;
        $orderby = $request->orderby;

        if ($menu == '1') {
            $cw = 700;
            $ch = 35;

            if ($orderby == 'PLU') {
                $p_order = 'ORDER BY LKS_PRDCD';
            } else if ($orderby == 'RAK') {
                $p_order = 'ORDER BY LOKASI';
            } else if ($orderby == 'QTY') {
                $p_order = 'ORDER BY LKS_QTY';
            }

            $data = DB::select("SELECT prs_namacabang,
                                           prs_namaperusahaan,
                                           lks_koderak || '.' || lks_kodesubrak || '.'
                                           || lks_tiperak || '.' || lks_shelvingrak || '.'
                                           || lks_nourut lokasi,
                                           nvl(lks_prdcd,'-') lks_prdcd,
                                           prd_deskripsipanjang,
                                           lks_qty
                                      FROM tbmaster_perusahaan, tbmaster_lokasi, tbmaster_prodmast
                                     WHERE prs_kodeigr = '" . $_SESSION['kdigr'] . "' AND prs_kodeigr = lks_kodeigr AND lks_prdcd = prd_prdcd(+)
                                           AND lks_koderak between '" . $rak1 . "' and '" . $rak2 . "'
                                           AND lks_qty < 0 " . $p_order);
            $filename = 'lap-qty-planogram-minus';
        } else {

            if ($orderby == 'PLU') {
                $p_order = 'ORDER BY SPB_PRDCD';
            } else if ($orderby == 'RAK') {
                $p_order = 'ORDER BY SPB_LOKASITUJUAN';
            } else if ($orderby == 'TGL') {
                $p_order = 'ORDER BY SPB_CREATE_DT DESC';
            }
            if ($realisasi == 'Y') {
                $p_recid = '1';
            } else if ($realisasi == 'N') {
                $p_recid = 'ZZ';
            } else if ($realisasi == 'Z') {
                $p_recid = '%';
            }

            $cw = 700;
            $ch = 35;
            $data = DB::select("SELECT   ROWNUM NUMB, CASE
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
                                AND TRUNC(SPB_CREATE_DT) BETWEEN to_date('" . $tgl1 . "','dd/mm/yyyy') AND to_date('" . $tgl2 . "','dd/mm/yyyy')
                                AND NVL(SPB_RECORDID,'ZZ') LIKE '" . $p_recid . "' " . $p_order);
            $filename = 'lap-spb-manual';
        }
        $perusahaan = DB::table('tbmaster_perusahaan')
            ->first();

        if (sizeof($data) != 0) {
            $data = [
                'perusahaan' => $perusahaan,
                'data' => $data,
                'tgl1' => $tgl1,
                'tgl2' => $tgl2,
                'p_order' => $p_order
            ];

            $dompdf = new PDF();

            $pdf = PDF::loadview('FRONTOFFICE.LAPORANPLANOGRAM.' . $filename . '-pdf', $data);

            error_reporting(E_ALL ^ E_DEPRECATED);

            $pdf->output();
            $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);

            $canvas = $dompdf->get_canvas();
            $canvas->page_text($cw, $ch, "{PAGE_NUM} dari {PAGE_COUNT}", null, 7, array(0, 0, 0));

            $dompdf = $pdf;


            return $dompdf->stream($filename.'_'.$tgl1.' - '.$tgl2.'.pdf');
        }
        else{
            return 'Tidak Ada Data!';
        }
    }
}
