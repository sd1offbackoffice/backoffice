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


class MonthEndController extends Controller
{
    public function index()
    {
        return view('BACKOFFICE.PROSES.monthend');
    }

    public function getStatus(Request $request)
    {
        set_time_limit(0);
        $txt_tahun = $request->tahun;
        $txt_bulan = $request->bulan;
        $status = '';
        $message = '';
        $data = '';

        $temp = DB::connection(Session::get('connection'))->table('tblog_laravel_ias')
            ->select('menu', 'submenu', 'status','start_time','end_time')
            ->where('menu', '=', 'MonthEnd_' . $txt_bulan . '_' . $txt_tahun)
            ->count();

        if ($temp == 0) {
            try {
                DB::connection(Session::get('connection'))->beginTransaction();
                DB::connection(Session::get('connection'))->table('tblog_laravel_ias')
                    ->insert([
                        [
                            'menu' => 'MonthEnd_' . $txt_bulan . '_' . $txt_tahun,
                            'submenu' => '1_Cek Proses Awal',
                            'start_time' => '',
                            'end_time' => '',
                            'status' => 'EXEC',
                        ],
                        [
                            'menu' => 'MonthEnd_' . $txt_bulan . '_' . $txt_tahun,
                            'submenu' => '2_Proses Hitung Stock',
                            'start_time' => '',
                            'end_time' => '',
                            'status' => 'WAITING',
                        ],
                        [
                            'menu' => 'MonthEnd_' . $txt_bulan . '_' . $txt_tahun,
                            'submenu' => '3_Proses Hitung Stock CMO',
                            'start_time' => '',
                            'end_time' => '',
                            'status' => 'WAITING',
                        ],
                        [
                            'menu' => 'MonthEnd_' . $txt_bulan . '_' . $txt_tahun,
                            'submenu' => '4_Proses Sales Rekap',
                            'start_time' => '',
                            'end_time' => '',
                            'status' => 'WAITING',
                        ],
                        [
                            'menu' => 'MonthEnd_' . $txt_bulan . '_' . $txt_tahun,
                            'submenu' => '5_Proses Sales LPP',
                            'start_time' => '',
                            'end_time' => '',
                            'status' => 'WAITING',
                        ],
                        [
                            'menu' => 'MonthEnd_' . $txt_bulan . '_' . $txt_tahun,
                            'submenu' => '6_Delete Data BackOffice',
                            'start_time' => '',
                            'end_time' => '',
                            'status' => 'WAITING',
                        ],
                        [
                            'menu' => 'MonthEnd_' . $txt_bulan . '_' . $txt_tahun,
                            'submenu' => '7_Proses Copy Stock',
                            'start_time' => '',
                            'end_time' => '',
                            'status' => 'WAITING',
                        ],
                        [
                            'menu' => 'MonthEnd_' . $txt_bulan . '_' . $txt_tahun,
                            'submenu' => '8_Proses Copy Stock CMO',
                            'start_time' => '',
                            'end_time' => '',
                            'status' => 'WAITING',
                        ],
                        [
                            'menu' => 'MonthEnd_' . $txt_bulan . '_' . $txt_tahun,
                            'submenu' => '9_Proses Hitung Stock Tahap 2',
                            'start_time' => '',
                            'end_time' => '',
                            'status' => 'WAITING',
                        ],
                        [
                            'menu' => 'MonthEnd_' . $txt_bulan . '_' . $txt_tahun,
                            'submenu' => '10_Proses Hitung Stock CMO Tahap 2',
                            'start_time' => '',
                            'end_time' => '',
                            'status' => 'WAITING',
                        ],
                        [
                            'menu' => 'MonthEnd_' . $txt_bulan . '_' . $txt_tahun,
                            'submenu' => '11_Proses LPP Point',
                            'start_time' => '',
                            'end_time' => '',
                            'status' => 'WAITING',
                        ],
                        [
                            'menu' => 'MonthEnd_' . $txt_bulan . '_' . $txt_tahun,
                            'submenu' => '12_Cek Proses Akhir',
                            'start_time' => '',
                            'end_time' => '',
                            'status' => 'WAITING',
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
            ->select('menu', 'submenu', 'status','start_time','end_time')
            ->where('menu', '=', 'MonthEnd_' . $txt_bulan . '_' . $txt_tahun)
            ->orderBy('submenu')
            ->get();


        return compact(['status', 'message', 'data']);
    }

    public function proses(Request $request)
    {
        set_time_limit(0);
        $txt_tahun = $request->tahun;
        $txt_bulan = $request->bulan;
        DB::connection(Session::get('connection'))->table('tblog_laravel_ias')
            ->where('menu', '=', 'MonthEnd_' . $txt_bulan . '_' . $txt_tahun)
            ->where('submenu', '=', '1_Cek Proses Awal')
            ->update(
                [
                    'start_time' => Carbon::now(),
                    'status' => 'LOADING',
                ]
            );

        $data = DB::connection(Session::get('connection'))->table('TBMASTER_PERUSAHAAN')
            ->select('prs_kodeigr', 'prs_bulanberjalan', 'prs_tahunberjalan', 'prs_fmflcs')
            ->first();
        $copyacost = $data->prs_fmflcs;
        $txt_bulanold = $data->prs_bulanberjalan;
        $txt_tahunold = $data->prs_tahunberjalan;

        if ($txt_tahunold . $txt_bulanold == $txt_tahun . $txt_bulan) {
            if (!isset($copyacost) || $copyacost == '') {
                $message = 'Data Average Cost Akhir Bulan belum di Copy';
                $status = 'info';

                DB::connection(Session::get('connection'))->table('tblog_laravel_ias')
                    ->where('menu', '=', 'MonthEnd_' . $txt_bulan . '_' . $txt_tahun)
                    ->where('submenu', '=', '1_Cek Proses Awal')
                    ->update(
                        [
                            'start_time' => '',
                            'end_time' => '',
                            'status' => 'EXEC',
                        ]
                    );


                return compact(['status', 'message']);
            }
        }
        DB::connection(Session::get('connection'))->table('tblog_laravel_ias')
            ->where('menu', '=', 'MonthEnd_' . $txt_bulan . '_' . $txt_tahun)
            ->where('submenu', '=', '1_Cek Proses Awal')
            ->update(
                [
                    'end_time' => Carbon::now(),
                    'status' => 'DONE',
                ]
            );
        DB::connection(Session::get('connection'))->table('tblog_laravel_ias')
            ->where('menu', '=', 'MonthEnd_' . $txt_bulan . '_' . $txt_tahun)
            ->where('submenu', '=', '2_Proses Hitung Stock')
            ->update(
                [
                    'status' => 'EXEC',
                ]
            );
        $message = 'Lanjut';
        $status = 'success';
        return compact(['status', 'message']);
    }

    public function prosesHitungStock(Request $request)
    {
        set_time_limit(0);
        $txt_tahun = $request->tahun;
        $txt_bulan = $request->bulan;

        $p_sukses = '';
        $err_txt = '';

        $p_awal = "to_date('" . $txt_bulan . "/01/" . $txt_tahun . "','MM/DD/YYYY')";
        $p_akhir = "add_months("."$p_awal".", 1) - 1";

        $menu = 'MonthEnd_' . $txt_bulan . '_' . $txt_tahun;
        $submenu = '2_Proses Hitung Stock';
        $next_submenu = '3_Proses Hitung Stock CMO';

//        ----->>>> Hitung Ulang Stock Untuk Bulan Proses <<<<-----
        $c = loginController::getConnectionProcedure();
        $sql = "BEGIN sp_hitung_stock_log('" . Session::get('kdigr') . "'," . $p_awal . "," . $p_akhir . ",' ','ZZZZZZZ','" . $menu . "','" . $submenu . "','" . $next_submenu . "',:p_sukses,:err_txt); END;";
        $s = oci_parse($c, $sql);

        oci_bind_by_name($s, ':p_sukses', $p_sukses, 200);
        oci_bind_by_name($s, ':err_txt', $err_txt, 200);
        oci_execute($s);

        if ($p_sukses == 'TRUE') {
            $status = 'success';
            $message = $err_txt;
            return compact(['status', 'message']);
        } else {
            $status = 'error';
            $message = $err_txt;
            return compact(['status', 'message']);
        }

    }

    public function prosesHitungStockCMO(Request $request)
    {
        set_time_limit(0);

        $txt_tahun = $request->tahun;
        $txt_bulan = $request->bulan;

        $p_sukses = '';
        $err_txt = '';

        $menu = 'MonthEnd_' . $txt_bulan . '_' . $txt_tahun;
        $submenu = '3_Proses Hitung Stock CMO';
        $next_submenu = '4_Proses Sales Rekap';

        $p_awal = "to_date('" . $txt_bulan . "/01/" . $txt_tahun . "','MM/DD/YYYY')";
        $p_akhir = "add_months("."$p_awal".", 1) - 1";

        $c = loginController::getConnectionProcedure();
        $sql = "BEGIN SP_HITUNG_STOCKCMO_log('" . Session::get('kdigr') . "'," . $p_awal . "," . $p_akhir . ",'" . $menu . "','" . $submenu . "','" . $next_submenu . "',:p_sukses,:err_txt); END;";
        $s = oci_parse($c, $sql);

        oci_bind_by_name($s, ':p_sukses', $p_sukses, 200);
        oci_bind_by_name($s, ':err_txt', $err_txt, 200);
        oci_execute($s);

        if ($p_sukses == 'TRUE') {
            $status = 'success';
            $message = $err_txt;
            return compact(['status', 'message']);
        } else {
            $status = 'error';
            $message = $err_txt;
            return compact(['status', 'message']);
        }
    }

    public function prosesSalesRekap(Request $request)
    {
        set_time_limit(0);

        $txt_tahun = $request->tahun;
        $txt_bulan = $request->bulan;

        $p_sukses = '';
        $err_txt = '';

        $p_awal = "to_date('" . $txt_bulan . "/01/" . $txt_tahun . "','MM/DD/YYYY')";
        $p_akhir = "add_months("."$p_awal".", 1) - 1";

        $menu = 'MonthEnd_' . $txt_bulan . '_' . $txt_tahun;
        $submenu = '4_Proses Sales Rekap';
        $next_submenu = '5_Proses Sales LPP';

        $c = loginController::getConnectionProcedure();
        $sql = "BEGIN SP_HITUNG_SLREKAP_LOG('" . Session::get('kdigr') . "'," . $p_awal . "," . $p_akhir . ",'" . Session::get('usid') . "','" . $menu . "','" . $submenu . "','" . $next_submenu . "',:p_sukses,:err_txt); END;";
        $s = oci_parse($c, $sql);

        oci_bind_by_name($s, ':p_sukses', $p_sukses, 200);
        oci_bind_by_name($s, ':err_txt', $err_txt, 200);
        oci_execute($s);

        if ($p_sukses == 'TRUE') {
            $status = 'success';
            $message = $err_txt;
            return compact(['status', 'message']);
        } else {
            $status = 'error';
            $message = $err_txt;
            return compact(['status', 'message']);
        }
    }

    public function prosesLPP(Request $request)
    {
        set_time_limit(0);

        $txt_tahun = $request->tahun;
        $txt_bulan = $request->bulan;

        $p_sukses = '';
        $err_txt = '';

        $p_awal = "to_date('" . $txt_bulan . "/01/" . $txt_tahun . "','MM/DD/YYYY')";
        $p_akhir = "add_months("."$p_awal".", 1) - 1";

        $menu = 'MonthEnd_' . $txt_bulan . '_' . $txt_tahun;
        $submenu = '5_Proses Sales LPP';
        $next_submenu = '6_Delete Data BackOffice';

        $c = loginController::getConnectionProcedure();
        $sql = "BEGIN Sp_Proses_Lpp_log('" . Session::get('kdigr') . "'," . $p_awal . "," . $p_akhir . ",true,'" . $menu . "','" . $submenu . "','" . $next_submenu . "',:p_sukses,:err_txt); END;";
        $s = oci_parse($c, $sql);

        oci_bind_by_name($s, ':p_sukses', $p_sukses, 200);
        oci_bind_by_name($s, ':err_txt', $err_txt, 200);
        oci_execute($s);

        if ($p_sukses == 'TRUE') {
            $status = 'success';
            $message = $err_txt;
            return compact(['status', 'message']);
        } else {
            $status = 'error';
            $message = $err_txt;
            return compact(['status', 'message']);
        }
    }

    public function deleteData(Request $request)
    {
        set_time_limit(0);

        $txt_tahun = $request->tahun;
        $txt_bulan = $request->bulan;
        $status = '';
        $message = '';
        DB::connection(Session::get('connection'))->table('tblog_laravel_ias')
            ->where('menu', '=', 'MonthEnd_' . $txt_bulan . '_' . $txt_tahun)
            ->where('submenu', '=', '6_Delete Data BackOffice')
            ->update(
                [
                    'start_time' => Carbon::now(),
                    'status' => 'LOADING',
                ]
            );
        try {
            DB::connection(Session::get('connection'))->beginTransaction();
            DB::connection(Session::get('connection'))->delete("delete from tbtr_backoffice where trbo_kodeigr='" . Session::get('kdigr') . "' and nvl(trbo_recordid,' ')='2' and nvl(trbo_nonota,' ')<>' '");

            $status = 'success';
            $message = '';
            DB::connection(Session::get('connection'))->table('tblog_laravel_ias')
                ->where('menu', '=', 'MonthEnd_' . $txt_bulan . '_' . $txt_tahun)
                ->where('submenu', '=', '6_Delete Data BackOffice')
                ->update(
                    [
                        'end_time' => Carbon::now(),
                        'status' => 'DONE',
                    ]
                );
            DB::connection(Session::get('connection'))->table('tblog_laravel_ias')
                ->where('menu', '=', 'MonthEnd_' . $txt_bulan . '_' . $txt_tahun)
                ->where('submenu', '=', '7_Proses Copy Stock')
                ->update(
                    [
                        'status' => 'EXEC',
                    ]
                );
            DB::connection(Session::get('connection'))->commit();
        } catch (Exception $e) {
            DB::connection(Session::get('connection'))->rollBack();
            $status = 'error';
            $message = $e->getMessage();

            DB::connection(Session::get('connection'))->table('tblog_laravel_ias')
                ->where('menu', '=', 'MonthEnd_' . $txt_bulan . '_' . $txt_tahun)
                ->where('submenu', '=', '6_Delete Data BackOffice')
                ->update(
                    [
                        'end_time' => Carbon::now(),
                        'status' => 'ERROR',
                        'message' => $message
                    ]
                );

        }
        return compact(['status', 'message']);


    }

    public function prosesCopyStock(Request $request)
    {
        set_time_limit(0);

        $txt_tahun = $request->tahun;
        $txt_bulan = $request->bulan;

        $p_sukses = '';
        $err_txt = '';

        $p_awal = "to_date('" . $txt_bulan . "/01/" . $txt_tahun . "','MM/DD/YYYY')";
        $p_akhir = "add_months("."$p_awal".", 1) - 1";

        $menu = 'MonthEnd_' . $txt_bulan . '_' . $txt_tahun;
        $submenu = '7_Proses Copy Stock';
        $next_submenu = '8_Proses Copy Stock CMO';

        $c = loginController::getConnectionProcedure();
        $sql = "BEGIN SP_COPY_STOCK_LOG('" . Session::get('kdigr') . "','" . $txt_tahun . $txt_bulan . "','" . $menu . "','" . $submenu . "','" . $next_submenu . "',:p_sukses,:err_txt); END;";
        $s = oci_parse($c, $sql);


        oci_bind_by_name($s, ':p_sukses', $p_sukses, 200);
        oci_bind_by_name($s, ':err_txt', $err_txt, 200);
        oci_execute($s);

        if ($p_sukses == 'TRUE') {
            $status = 'success';
            $message = $err_txt;
            return compact(['status', 'message']);
        } else {
            $status = 'error';
            $message = $err_txt;
            return compact(['status', 'message']);
        }
    }

    public function prosesCopyStockCMO(Request $request)
    {
        set_time_limit(0);

        $txt_tahun = $request->tahun;
        $txt_bulan = $request->bulan;

        $p_sukses = '';
        $err_txt = '';

        $p_awal = "to_date('" . $txt_bulan . "/01/" . $txt_tahun . "','MM/DD/YYYY')";
        $p_akhir = "add_months("."$p_awal".", 1) - 1";

        $menu = 'MonthEnd_' . $txt_bulan . '_' . $txt_tahun;
        $submenu = '8_Proses Copy Stock CMO';
        $next_submenu = '9_Proses Hitung Stock Tahap 2';

        $c = loginController::getConnectionProcedure();
        $sql = "BEGIN sp_copy_stock_cmo_log('" . Session::get('kdigr') . "','" . $txt_tahun . $txt_bulan . "','" . $menu . "','" . $submenu . "','" . $next_submenu . "',:p_sukses,:err_txt); END;";
        $s = oci_parse($c, $sql);

        oci_bind_by_name($s, ':p_sukses', $p_sukses, 200);
        oci_bind_by_name($s, ':err_txt', $err_txt, 200);
        oci_execute($s);

        if ($p_sukses == 'TRUE') {
            $status = 'success';
            $message = $err_txt;
            return compact(['status', 'message']);
        } else {
            $status = 'error';
            $message = $err_txt;
            return compact(['status', 'message']);
        }
    }

    public function prosesHitungStock2(Request $request)
    {
        set_time_limit(0);

        $txt_tahun = $request->tahun;
        $txt_bulan = $request->bulan;

        $p_sukses = '';
        $err_txt = '';

        $p_awal = "to_date('" . $txt_bulan . "/01/" . $txt_tahun . "','MM/DD/YYYY')";
        $p_akhir = "add_months("."$p_awal".", 1) - 1";

        $menu = 'MonthEnd_' . $txt_bulan . '_' . $txt_tahun;
        $submenu = '9_Proses Hitung Stock Tahap 2';
        $next_submenu = '10_Proses Hitung Stock CMO Tahap 2';

        $p_awal = $p_akhir . ' + 1';

        $re = DB::connection(Session::get('connection'))->select("select to_char(" . $p_awal . ",'YYYYMM') value from dual");

        if ($re[0]->value == Carbon::now()->format('Ym')) {
            $p_akhir = 'trunc(sysdate)';
        } else {
            $p_akhir = $p_awal;
        }
//        ----->>>> Hitung Ulang Stock Untuk Bulan Proses <<<<-----
        $c = loginController::getConnectionProcedure();
        $sql = "BEGIN sp_hitung_stock_log('" . Session::get('kdigr') . "'," . $p_awal . "," . $p_akhir . ",' ','ZZZZZZZ','" . $menu . "','" . $submenu . "','" . $next_submenu . "',:p_sukses,:err_txt); END;";
        $s = oci_parse($c, $sql);

        oci_bind_by_name($s, ':p_sukses', $p_sukses, 200);
        oci_bind_by_name($s, ':err_txt', $err_txt, 200);
        oci_execute($s);

        if ($p_sukses == 'TRUE') {
            $status = 'success';
            $message = $err_txt;
        } else {
            $status = 'error';
            $message = $err_txt;
            return compact(['status', 'message']);
        }

    }

    public function prosesHitungStockCMO2(Request $request)
    {
        set_time_limit(0);

        $txt_tahun = $request->tahun;
        $txt_bulan = $request->bulan;

        $p_sukses = '';
        $err_txt = '';

        $menu = 'MonthEnd_' . $txt_bulan . '_' . $txt_tahun;
        $submenu = '10_Proses Hitung Stock CMO Tahap 2';
        $next_submenu = '11_Proses LPP Point';

        $p_awal = "to_date('" . $txt_bulan . "/01/" . $txt_tahun . "','MM/DD/YYYY')";
        $p_akhir = "add_months("."$p_awal".", 1) - 1";
        $p_awal = $p_akhir . ' + 1';

        $re = DB::connection(Session::get('connection'))->select("select to_char(" . $p_awal . ",'YYYYMM') value from dual");

        if ($re[0]->value == Carbon::now()->format('Ym')) {
            $p_akhir = 'trunc(sysdate)';
        } else {
            $p_akhir = $p_awal;
        }

        $c = loginController::getConnectionProcedure();
        $sql = "BEGIN SP_HITUNG_STOCKCMO_log('" . Session::get('kdigr') . "'," . $p_awal . "," . $p_akhir . ",'" . $menu . "','" . $submenu . "','" . $next_submenu . "',:p_sukses,:err_txt); END;";
        $s = oci_parse($c, $sql);

        oci_bind_by_name($s, ':p_sukses', $p_sukses, 200);
        oci_bind_by_name($s, ':err_txt', $err_txt, 200);
        oci_execute($s);

        if ($p_sukses == 'TRUE') {
            $status = 'success';
            $message = $err_txt;
        } else {
            $status = 'error';
            $message = $err_txt;
            return compact(['status', 'message']);
        }

    }

    public function prosesLPPPoint(Request $request)
    {
        set_time_limit(0);

        $txt_tahun = $request->tahun;
        $txt_bulan = $request->bulan;

        $p_sukses = '';
        $err_txt = '';

        $p_awal = "to_date('" . $txt_bulan . "/01/" . $txt_tahun . "','MM/DD/YYYY')";
        $p_akhir = "add_months("."$p_awal".", 1) - 1";

        $menu = 'MonthEnd_' . $txt_bulan . '_' . $txt_tahun;
        $submenu = '11_Proses LPP Point';
        $next_submenu = '12_Cek Proses Akhir';


        $c = loginController::getConnectionProcedure();

        $sql = "BEGIN sp_lpp_point_log('" . $txt_tahun . $txt_bulan . "','" . Session::get('usid') . "'||'Y','" . $menu . "','" . $submenu . "','" . $next_submenu . "',:err_txt); END;";
        $s = oci_parse($c, $sql);

        oci_bind_by_name($s, ':err_txt', $err_txt, 200);
        oci_execute($s);

        if (isset($err_txt)) {
            $status = 'error';
            $message = $err_txt;
            return compact(['status', 'message']);
        }


    }

    public function prosesAkhir(Request $request)
    {
        set_time_limit(0);

        $txt_tahun = $request->tahun;
        $txt_bulan = $request->bulan;

        $submenu = '12_Cek Proses Akhir';
        $next_submenu = '';
        DB::connection(Session::get('connection'))->table('tblog_laravel_ias')
            ->where('menu', '=', 'MonthEnd_' . $txt_bulan . '_' . $txt_tahun)
            ->where('submenu', '=', $submenu)
            ->update(
                [
                    'start_time' => Carbon::now(),
                    'status' => 'LOADING',
                ]
            );
        $data = DB::connection(Session::get('connection'))->table('TBMASTER_PERUSAHAAN')
            ->select('prs_kodeigr', 'prs_bulanberjalan', 'prs_tahunberjalan', 'prs_fmflcs')
            ->first();
        $copyacost = $data->prs_fmflcs;
        $txt_bulanold = $data->prs_bulanberjalan;
        $txt_tahunold = $data->prs_tahunberjalan;

        $p_awal = "to_date('" . $txt_bulan . "/01/" . $txt_tahun . "','MM/DD/YYYY')";
        $p_akhir = "add_months("."$p_awal".", 1) - 1";
        $p_awal = $p_akhir . ' + 1';

        $re = DB::connection(Session::get('connection'))->select("select to_char(" . $p_awal . ",'YYYYMM') value from dual");

        if ($re[0]->value == Carbon::now()->format('Ym')) {
            $p_akhir = 'trunc(sysdate)';
        } else {
            $p_akhir = $p_awal;
        }

        $c = loginController::getConnectionProcedure();
        if ($txt_tahunold . $txt_bulanold == $txt_tahun . $txt_bulan) {
            $sql = "BEGIN UPDATE tbMaster_Perusahaan SET PRS_BULANBERJALAN = to_char(" . $p_awal . ", 'MM'), PRS_TAHUNBERJALAN = to_char(" . $p_awal . ", 'YYYY'), PRS_FMFLCS = '' WHERE PRS_KODECABANG = '" . Session::get('kdigr') . "'; END;";
            $s = oci_parse($c, $sql);
            oci_execute($s);
        }
        DB::connection(Session::get('connection'))->table('tblog_laravel_ias')
            ->where('menu', '=', 'MonthEnd_' . $txt_bulan . '_' . $txt_tahun)
            ->where('submenu', '=', $submenu)
            ->update(
                [
                    'end_time' => Carbon::now(),
                    'status' => 'DONE',
                ]
            );
    }

    public function prosesUlang(Request $request)
    {
        set_time_limit(0);

        $txt_tahun = $request->tahun;
        $txt_bulan = $request->bulan;
        $status = '';
        $message = '';
        $data = '';
        try {

            DB::connection(Session::get('connection'))->table('tblog_laravel_ias')
                ->where('menu', '=', 'MonthEnd_' . $txt_bulan . '_' . $txt_tahun)
                ->update(
                    [
                        'start_time' => '',
                        'end_time' => '',
                        'status' => 'WAITING',
                    ]
                );

            DB::connection(Session::get('connection'))->table('tblog_laravel_ias')
                ->where('menu', '=', 'MonthEnd_' . $txt_bulan . '_' . $txt_tahun)
                ->where('submenu', '=', '1_Cek Proses Awal')
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
}
