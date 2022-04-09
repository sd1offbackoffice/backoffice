<?php

namespace App\Http\Controllers\BACKOFFICE\LPP;

use Carbon\Carbon;
use Dompdf\Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Auth\loginController;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use PDF;
use Yajra\DataTables\DataTables;
use File;

class ProsesLPPController extends Controller
{
    public function index()
    {
        return view('BACKOFFICE.LPP.proses-lpp');
    }

    public function getStatus(Request $request)
    {
        set_time_limit(0);
        $periode1 = $request->periode1;
        $periode2 = $request->periode2;
        $status = '';
        $message = '';
        $data = '';

        $temp = DB::connection(Session::get('connection'))->table('tblog_laravel_ias')
            ->select('menu', 'submenu', 'status','start_time','end_time')
            ->where('menu', '=', 'ProsesLPP_' . $periode1 . '_' . $periode2)
            ->count();

        if ($temp == 0) {
            try {
                DB::connection(Session::get('connection'))->beginTransaction();
                DB::connection(Session::get('connection'))->table('tblog_laravel_ias')
                    ->insert([
                        [
                            'menu' => 'ProsesLPP_' . $periode1 . '_' . $periode2,
                            'submenu' => '1',
                            'start_time' => '',
                            'end_time' => '',
                            'status' => 'EXEC',
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
            ->where('menu', '=', 'ProsesLPP_' . $periode1 . '_' . $periode2)
            ->first();


        return compact(['status', 'message', 'data']);
    }

    public function proses(Request $request)
    {
        set_time_limit(0);
        $periode1 = $request->periode1;
        $periode2 = $request->periode2;

        $p_sukses = false;
        $err_txt = '';


        $isRunning = $this->cekProcedure("'SP_PROSES_LPP2','SP_RESTORE_STOCK2'");
        if ($isRunning > 0) {
            $message = 'Procedure Proses LPP / Restore Data Month End sedang berjalan!';
            $status = 'info';
            return compact(['status', 'message']);
        } else {
            $menu = 'ProsesLPP_' . $periode1 . '_' . $periode2;
            $submenu = '1';

            $c = loginController::getConnectionProcedure();
            $sql = "BEGIN Sp_Proses_Lpp_log('" . Session::get('kdigr') . "',to_date('" . $periode1 . "','dd/mm/yyyy'),to_date('" . $periode2 . "','dd/mm/yyyy'),false,'" . $menu . "','" . $submenu . "','',:p_sukses,:err_txt); END;";
//            $sql = "BEGIN SP_PROSES_LPP2('" . Session::get('kdigr') . "',to_date('" . $periode1 . "','dd/mm/yyyy'),to_date('" . $periode2 . "','dd/mm/yyyy'),false,:p_sukses,:err_txt); END;";
            $s = oci_parse($c, $sql);

            oci_bind_by_name($s, ':p_sukses', $p_sukses, 200);
            oci_bind_by_name($s, ':err_txt', $err_txt, 200);
            oci_execute($s);

            $status = '';
            if ($p_sukses == 'TRUE') {
                $err_txt = 'Proses LPP Sudah Selesai !';
                $status = 'success';
            } else {
                $err_txt = 'Proses LPP GAGAL! --> ' . $err_txt;
                $status = 'error';
            }
            $message = $err_txt;
            return compact(['status', 'message']);
        }
    }

    public function prosesUlang(Request $request)
    {
        set_time_limit(0);

        $periode1 = $request->periode1;
        $periode2 = $request->periode2;
        $status = '';
        $message = '';
        $data = '';
        try {

            DB::connection(Session::get('connection'))->table('tblog_laravel_ias')
                ->where('menu', '=', 'ProsesLPP_' . $periode1 . '_' . $periode2)
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
