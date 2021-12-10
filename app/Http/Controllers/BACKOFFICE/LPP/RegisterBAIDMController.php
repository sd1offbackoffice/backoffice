<?php

namespace App\Http\Controllers\BACKOFFICE\LPP;

use Carbon\Carbon;
use Dompdf\Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller; use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use PDF;
use Yajra\DataTables\DataTables;
use File;

class RegisterBAIDMController extends Controller
{
    public function index()
    {
        return view('BACKOFFICE.LPP.register-ba-idm');
    }

    public function getPLU(Request $request)
    {
        $search = $request->value;

        $data = DB::connection(Session::get('connection'))->table('tbmaster_prodmast')
            ->where('prd_prdcd', 'LIKE', '%' . $search . '%')
            ->orWhere('prd_deskripsipanjang', 'LIKE', '%' . $search . '%')
            ->orderBy('prd_prdcd')
            ->limit(100)
            ->get();

        return Datatables::of($data)->make(true);
    }


    public function cetak(Request $request)
    {
        $menu = $request->menu;
        $periode1 = $request->periode1;
        $periode2 = $request->periode2;

        $perusahaan = DB::connection(Session::get('connection'))->table('tbmaster_perusahaan')
            ->select('prs_namaperusahaan', 'prs_namacabang', 'prs_namawilayah')
            ->first();

        if ($menu == 'detail') {
            $datas = DB::connection(Session::get('connection'))->select("SELECT  ab.* FROM (
                    SELECT prs_namaperusahaan, prs_namacabang, bth_nonrb, bth_tglnrb, tko_kodeomi, bth_kodemember, bth_nodoc, bth_tgldoc, btd_prdcd, prd_deskripsipanjang,
            ((btd_price * btd_qty) + btd_ppn) nilai
            FROM TBTR_BATOKO_H, TBTR_BATOKO_D, TBMASTER_TOKOIGR, TBMASTER_PRODMAST, TBMASTER_PERUSAHAAN
            WHERE TRUNC(bth_tgldoc) BETWEEN to_date('" . $periode1 . "','dd/mm/yyyy') AND to_date('" . $periode2 . "','dd/mm/yyyy')
            AND BTD_ID = BTH_ID
                AND tko_kodecustomer = bth_kodemember
                AND prd_kodeigr = " . Session::get('kdigr') . "
                AND prd_prdcd = btd_prdcd
                AND prs_kodeigr = " . Session::get('kdigr') . "
            ORDER BY bth_nonrb ) ab");
            $title = 'Rincian BA Klaim atas NRB Proforma Toko IDM';
            $data = [
                'title' => $title,
                'perusahaan' => $perusahaan,
                'datas' => $datas,
                'tgl1' => $periode1,
                'tgl2' => $periode2
            ];

            $now = Carbon::now('Asia/Jakarta');
            $now = date_format($now, 'd-m-Y H-i-s');

            $dompdf = new PDF();

            $pdf = PDF::loadview('BACKOFFICE.LPP.nrb-ba-detail-laporan', $data);

            error_reporting(E_ALL ^ E_DEPRECATED);
            $pdf->output();

            $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);
            $canvas = $dompdf->get_canvas();
            $canvas->page_text(825, 10, "Page {PAGE_NUM} of {PAGE_COUNT}", null, 8, array(0, 0, 0));

            $dompdf = $pdf;

            return $dompdf->stream($title . ' ' . $periode1 . ' - ' . $periode2 . '.pdf');
        }
        else if ($menu == 'rekap') {
            $datas = DB::connection(Session::get('connection'))->select("SELECT ROWNUM ||  '.' nomor, ab.* FROM (
                SELECT prs_namaperusahaan, prs_namacabang, bth_nonrb, bth_tglnrb, tko_kodeomi, bth_kodemember, bth_nodoc, bth_tgldoc,
                SUM(((btd_price * btd_qty) + btd_ppn)) nilai, SUM(((btd_price * 0.97) * btd_qty)) dpp, SUM(((btd_price * 0.03) * btd_qty) ) tigapersen,
                SUM(btd_ppn) btd_ppn
                FROM TBTR_BATOKO_H, TBTR_BATOKO_D, TBMASTER_TOKOIGR, TBMASTER_PERUSAHAAN
                WHERE TRUNC(bth_tgldoc) BETWEEN to_date('" . $periode1 . "','dd/mm/yyyy') AND to_date('" . $periode2 . "','dd/mm/yyyy')
                AND BTD_ID = BTH_ID
                AND tko_kodecustomer = bth_kodemember
                AND prs_kodeigr =  " . Session::get('kdigr') . "
                GROUP BY prs_namaperusahaan, prs_namacabang, bth_nonrb, bth_tglnrb, tko_kodeomi, bth_kodemember, bth_nodoc, bth_tgldoc
                ORDER BY bth_nonrb ) ab");
            $title = 'Rekapitulasi BA Klaim atas NRB Proforma Toko IDM';
            $data = [
                'title' => $title,
                'perusahaan' => $perusahaan,
                'datas' => $datas,
                'tgl1' => $periode1,
                'tgl2' => $periode2
            ];

            $now = Carbon::now('Asia/Jakarta');
            $now = date_format($now, 'd-m-Y H-i-s');

            $dompdf = new PDF();

            $pdf = PDF::loadview('BACKOFFICE.LPP.nrb-ba-rekap-laporan', $data);

            error_reporting(E_ALL ^ E_DEPRECATED);
            $pdf->output();

            $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);
            $canvas = $dompdf->get_canvas();
            $canvas->page_text(825, 10, "Page {PAGE_NUM} of {PAGE_COUNT}", null, 8, array(0, 0, 0));

            $dompdf = $pdf;

            return $dompdf->stream($title . ' ' . $periode1 . ' - ' . $periode2 . '.pdf');
        }
    }
}
