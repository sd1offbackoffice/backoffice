<?php

namespace App\Http\Controllers\BACKOFFICE\LPP;

use App\Http\Controllers\ExcelController;
use Carbon\Carbon;
use Dompdf\Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
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
        $tgl1 = $request->periode1;
        $tgl2 = $request->periode2;
        $filename = '';
        $title = '';
        $data = '';
        $perusahaan = DB::connection(Session::get('connection'))->table('tbmaster_perusahaan')
            ->select('prs_namaperusahaan', 'prs_namacabang', 'prs_namawilayah')
            ->first();

        if ($menu == 'detail') {
            $data = DB::connection(Session::get('connection'))->select("SELECT  ab.* FROM (
                    SELECT prs_namaperusahaan, prs_namacabang, bth_nonrb, bth_tglnrb, tko_kodeomi, bth_kodemember, bth_nodoc, bth_tgldoc, btd_prdcd, prd_deskripsipanjang,
            ((btd_price * btd_qty) + btd_ppn) nilai
            FROM TBTR_BATOKO_H, TBTR_BATOKO_D, TBMASTER_TOKOIGR, TBMASTER_PRODMAST, TBMASTER_PERUSAHAAN
            WHERE TRUNC(bth_tgldoc) BETWEEN to_date('" . $tgl1 . "','dd/mm/yyyy') AND to_date('" . $tgl2 . "','dd/mm/yyyy')
            AND BTD_ID = BTH_ID
                AND tko_kodecustomer = bth_kodemember
                AND prd_kodeigr = " . Session::get('kdigr') . "
                AND prd_prdcd = btd_prdcd
                AND prs_kodeigr = " . Session::get('kdigr') . "
            ORDER BY bth_nonrb ) ab");
            $title = 'Rincian BA Klaim atas NRB Proforma Toko IDM';
            $filename = 'nrb-ba-detail-laporan';
        }
        else if ($menu == 'rekap') {
            $data = DB::connection(Session::get('connection'))->select("SELECT ROWNUM ||  '.' nomor, ab.* FROM (
                SELECT prs_namaperusahaan, prs_namacabang, bth_nonrb, bth_tglnrb, tko_kodeomi, bth_kodemember, bth_nodoc, bth_tgldoc,
                SUM(((btd_price * btd_qty) + btd_ppn)) nilai, SUM(((btd_price * 0.97) * btd_qty)) dpp, SUM(((btd_price * 0.03) * btd_qty) ) tigapersen,
                SUM(btd_ppn) btd_ppn
                FROM TBTR_BATOKO_H, TBTR_BATOKO_D, TBMASTER_TOKOIGR, TBMASTER_PERUSAHAAN
                WHERE TRUNC(bth_tgldoc) BETWEEN to_date('" . $tgl1 . "','dd/mm/yyyy') AND to_date('" . $tgl2 . "','dd/mm/yyyy')
                AND BTD_ID = BTH_ID
                AND tko_kodecustomer = bth_kodemember
                AND prs_kodeigr =  " . Session::get('kdigr') . "
                GROUP BY prs_namaperusahaan, prs_namacabang, bth_nonrb, bth_tglnrb, tko_kodeomi, bth_kodemember, bth_nodoc, bth_tgldoc
                ORDER BY bth_nonrb ) ab");
            $title = 'Rekapitulasi BA Klaim atas NRB Proforma Toko IDM';
            $filename = 'nrb-ba-rekap-laporan';
        }
//        return view('BACKOFFICE.LPP.'.$filename, compact(['title', 'perusahaan', 'data', 'tgl1', 'tgl2']));

        //Excel
        $view = view('BACKOFFICE.LPP.'.$filename.'-xlxs',compact(['title', 'perusahaan', 'data', 'tgl1', 'tgl2']))->render();
        $filename = $title.'_'.Carbon::now()->format('dmY_His').'.xlsx';
        $keterangan = '';
        $subtitle = 'TANGGAL :'. strtoupper(\DateTime::createFromFormat('d/m/Y', $tgl1)->format('d-M-Y')) .' s/d '. strtoupper(\DateTime::createFromFormat('d/m/Y', $tgl1)->format('d-M-Y'));
        ExcelController::create($view,$filename,$title,$subtitle,$keterangan);

        return response()->download(storage_path($filename))->deleteFileAfterSend(true);
    }
}
