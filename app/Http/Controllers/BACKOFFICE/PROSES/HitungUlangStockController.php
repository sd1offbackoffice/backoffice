<?php

namespace App\Http\Controllers\BACKOFFICE\PROSES;

use App\Http\Controllers\Auth\loginController;
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

class HitungUlangStockController extends Controller
{
    public function index()
    {
        return view('BACKOFFICE.PROSES.hitungulangstock');
    }

    public function getDataLov(Request $request)
    {
        $search = $request->search;

        $lov = DB::connection(Session::get('connection'))->table('tbmaster_prodmast')
            ->select('prd_prdcd', 'prd_deskripsipanjang')
            ->where('prd_kodeigr', '=', Session::get('kdigr'))
            ->WhereRaw("(prd_deskripsipanjang LIKE '%" . $search . "%' or prd_prdcd LIKE '%" . $search . "%')")
            ->orderBy('prd_prdcd')
            ->limit(100)
            ->get();
        return DataTables::of($lov)->make(true);
    }

    public function cekStatusHitungUlangStock(Request $request)
    {
        $periode1 = $request->periode1;
        $periode2 = $request->periode2;
        $status = '';
        $message = '';
        $data = '';

        $temp = DB::connection(Session::get('connection'))->table('tblog_laravel_ias')
            ->select('menu', 'submenu', 'status')
            ->where('menu', '=', 'HitungUlangStock_' . $periode1 . '_' . $periode2)
            ->count();

        if ($temp == 0) {
            try {
                DB::connection(Session::get('connection'))->beginTransaction();
                DB::connection(Session::get('connection'))->table('tblog_laravel_ias')
                    ->insert([
                        [
                            'menu' => 'HitungUlangStock_' . $periode1 . '_' . $periode2,
                            'submenu' => '1_Hitung Ulang Stock',
                            'start_time' => '',
                            'end_time' => '',
                            'status' => 'EXEC',
                        ],
                        [
                            'menu' => 'HitungUlangStock_' . $periode1 . '_' . $periode2,
                            'submenu' => '2_Hitung Ulang Stock CMO',
                            'start_time' => '',
                            'end_time' => '',
                            'status' => 'Waiting',
                        ],
                    ]);
                DB::connection(Session::get('connection'))->commit();



            } catch (Exception $e) {
                DB::connection(Session::get('connection'))->rollBack();
                $status = 'error';
                $message = $e->getMessage();
            }
        }
        $data = DB::connection(Session::get('connection'))->table('tblog_laravel_ias')
            ->select('menu', 'submenu', 'status')
            ->where('menu', '=', 'HitungUlangStock_' . $periode1 . '_' . $periode2)
            ->orderBy('submenu')
            ->get();
        return compact(['status', 'message', 'data']);
    }
    public function ProsesHitungUlangStock(Request $request)
    {
        $periode1 = $request->periode1;
        $periode2 = $request->periode2;
        $plu1 = $request->plu1;
        $plu2 = $request->plu2;

        if ($plu1 == '' || !isset($plu1)) {
            $plu1 = '0000000';
        }
        if ($plu2 == '' || !isset($plu2)) {
            $plu2 = '9999999';
        }
        $status = '';
        $err_txt = 'a';

        $p_sukses = false;



        $menu = 'HitungUlangStock_' . $periode1 . '_' . $periode2;
        $submenu = '1_Hitung Ulang Stock';
        $next_submenu = '2_Hitung Ulang Stock CMO';

        $c = loginController::getConnectionProcedure();
//            $sql = "BEGIN SP_HITUNG_STOCK2('" . Session::get('kdigr') . "',to_date('" . $periode1 . "','dd/mm/yyyy'),to_date('" . $periode2 . "','dd/mm/yyyy'),:plu1,:plu2,:p_sukses,:err_txt); END;";
        $sql = "BEGIN sp_hitung_stock_log('" . Session::get('kdigr') . "',to_date('" . $periode1 . "','dd/mm/yyyy'),to_date('" . $periode2 . "','dd/mm/yyyy'),:plu1,:plu2,'" . $menu . "','" . $submenu . "','" . $next_submenu . "',:p_sukses,:err_txt); END;";
        $s = oci_parse($c, $sql);

        oci_bind_by_name($s, ':plu1', $plu1);
        oci_bind_by_name($s, ':plu2', $plu2);
        oci_bind_by_name($s, ':p_sukses', $p_sukses, 200);
        oci_bind_by_name($s, ':err_txt', $err_txt, 200);
        oci_execute($s);


        if ($p_sukses == 'TRUE') {
            $status = 'success';
            $err_txt = 'Proses Hitung Stock Berhasil !';
        } else {
            $status = 'error';
            $err_txt = 'Proses Hitung Stock GAGAL! --> ' . $err_txt;
        }

        return compact([ 'status', 'err_txt']);
    }

    public function ProsesHitungUlangStockCMO(Request $request)
    {
        $periode1 = $request->periode1;
        $periode2 = $request->periode2;
        $plu1 = $request->plu1;
        $plu2 = $request->plu2;

        if ($plu1 == '' || !isset($plu1)) {
            $plu1 = '0000000';
        }
        if ($plu2 == '' || !isset($plu2)) {
            $plu2 = '9999999';
        }
        $err_txt = 'a';

        $p_sukses = false;

        $menu = 'HitungUlangStock_' . $periode1 . '_' . $periode2;
        $submenu = '2_Hitung Ulang Stock CMO';
        $next_submenu = '';

        $c = loginController::getConnectionProcedure();
//        $sql = "BEGIN SP_HITUNG_STOCKCMO2('" . Session::get('kdigr') . "', to_date('" . $periode1 . "','dd/mm/yyyy') , to_date('" . $periode2 . "','dd/mm/yyyy'),:p_sukses,:err_txt); END;";
        $sql = "BEGIN SP_HITUNG_STOCKCMO_log('" . Session::get('kdigr') . "',to_date('" . $periode1 . "','dd/mm/yyyy') , to_date('" . $periode2 . "','dd/mm/yyyy'),'" . $menu . "','" . $submenu . "','" . $next_submenu . "',:p_sukses,:err_txt); END;";
        $s = oci_parse($c, $sql);

        oci_bind_by_name($s, ':p_sukses', $p_sukses, 100);
        oci_bind_by_name($s, ':err_txt', $err_txt, 100);
        oci_execute($s);

        if ($p_sukses == 'TRUE') {
            $status = 'success';
            $err_txt = 'Proses Hitung Stock CMO Berhasil !';
        } else {
            $status = 'error';
            $err_txt = 'Proses Hitung Stock CMO GAGAL! --> ' . $err_txt;
        }

        $akhir = Date('H:i:s');
        return compact(['status', 'err_txt']);
    }
    public function prosesUlang(Request $request)
    {

        $periode1 = $request->periode1;
        $periode2 = $request->periode2;
        $status = '';
        $message = '';
        $data = '';
        try {

            DB::connection(Session::get('connection'))->table('tblog_laravel_ias')
                ->where('menu', '=', 'HitungUlangStock_' . $periode1 . '_' . $periode2)
                ->update(
                    [
                        'start_time' => '',
                        'end_time' => '',
                        'status' => 'WAITING',
                    ]
                );

            DB::connection(Session::get('connection'))->table('tblog_laravel_ias')
                ->where('menu', '=', 'HitungUlangStock_' . $periode1 . '_' . $periode2)
                ->where('submenu', '=', '1_Hitung Ulang Stock')
                ->update(
                    [
                        'start_time' => '',
                        'end_time' => '',
                        'status' => 'EXEC',
                    ]
                );
            $status = 'success';
            $message = '';
        } catch (Exception $e) {
            $status = 'success';
            $message = $e->getMessage();
        }

        return compact(['status', 'message']);
    }

    public function ProsesHitungUlangPoint(Request $request)
    {
        $status = '';
        $err_txt = '';

        DB::connection(Session::get('connection'))->beginTransaction();
        $mulai = Date('H:i:s');

        $c = loginController::getConnectionProcedure();
        $sql = "BEGIN SP_LPP_POINT(to_char(sysdate,'yyyyMM'),'HIT',:err_txt); END;";
        $s = oci_parse($c, $sql);

        oci_bind_by_name($s, ':err_txt', $err_txt, 200);
        oci_execute($s);

        $status = 'success';
        $err_txt = 'Data Sudah di Proses !!' . $err_txt;

        DB::connection(Session::get('connection'))->commit();

        $akhir = Date('H:i:s');
        return compact(['mulai', 'akhir', 'status', 'err_txt']);
    }

    public
    function ProsesHapusPoint(Request $request)
    {
        if (Date('mm') != 12) {
            $status = 'error';
            $err_txt = 'Penghapusan Point dan Star harus dilakukan di 31 Desember !!';
            return compact(['status', 'err_txt']);
        } else {
            $status = '';
            $err_txt = '';

            $mulai = Date('H:i:s');

            DB::connection(Session::get('connection'))->beginTransaction();
            $c = loginController::getConnectionProcedure();
            $sql = "BEGIN SP_LPP_POINT(to_char(sysdate,'yyyyMM'),'HITY',:err_txt); END;";
            $s = oci_parse($c, $sql);

            oci_bind_by_name($s, ':err_txt', $err_txt, 200);
            oci_execute($s);

            $akhir = Date('H:i:s');

            $status = 'success';
            $err_txt = 'Data Penghapusan Akhir Tahun Sudah di Lakukan !! ' . $err_txt;
            // report hapus?
            DB::connection(Session::get('connection'))->commit();

            return compact(['mulai', 'akhir', 'status', 'err_txt']);
        }

    }

    public
    function PrintHapus(Request $request)
    {
        $kdsup = $request->kdsup;
        $perusahaan = DB::connection(Session::get('connection'))->table('tbmaster_perusahaan')
            ->select('prs_namaperusahaan', 'prs_namacabang')
            ->where('prs_kodeigr', '=', Session::get('kdigr'))
            ->first();

        $data = DB::connection(Session::get('connection'))->select("select prs_namaperusahaan, prs_namacabang, prs_namawilayah, a.* from ( select 'S A L D O     P O I N T' jenis, lpp_kodemember kd_member, cus_namamember nm_member, lpp_saldoawal sebelum, lpp_saldoakhir sesudah, lpp_hapustahun hapus from tbtr_lpppoint, tbmaster_customer where lpp_periode = to_char(sysdate, 'yyyyMM') and nvl(lpp_hapustahun, 0) <> 0    and cus_kodemember(+) = lpp_kodemember union select 'S A L D O     S T A R' jenis, lps_kodemember kd_member, cus_namamember nm_member, lps_saldoawal sebelum, lps_saldoakhir sesudah, lps_hapustahun hapus from tbtr_lppstar, tbmaster_customer where lps_periode = to_char(sysdate, 'yyyyMM') and nvl(lps_hapustahun, 0) <> 0 and cus_kodemember(+) = lps_kodemember )a, tbmaster_perusahaan where prs_kodeigr = " . Session::get('kdigr') . " order by jenis, kd_member");

        $pdf = PDF::loadview('BACKOFFICE.PROSES.hapustahun-cetak', compact(['data', 'perusahaan']));
        $pdf->output();
        $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);

        $canvas = $dompdf->get_canvas();
        $canvas->page_text(514, 10, "Page {PAGE_NUM} of {PAGE_COUNT}", null, 10, array(0, 0, 0));

        return $pdf->stream('hapustahun-cetak.pdf');

    }
}
