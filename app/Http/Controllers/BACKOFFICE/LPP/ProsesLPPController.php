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

    public function proses(Request $request)
    {
        set_time_limit(0);
        $periode1 = $request->periode1;
        $periode2 = $request->periode2;

        $p_sukses = false;
        $err_txt = '';


        $isRunning = DB::connection(Session::get('connection'))
            ->select("select  count(1) count
                              from  " . 'gv$access' . "
                              where type = 'PROCEDURE'
                              and (object = 'SP_PROSES_LPP2'
                              or object = 'SP_RESTORE_STOCK2')
                                and (inst_id,sid) in (
                                                      select  inst_id,
                                                              sid
                                                        from  " . 'gv$session' . "
                                                        where type = 'USER'
                                                     )")[0]->count;
        if ($isRunning > 0) {
            $message = 'Procedure Proses LPP / Restore Data Month End sedang berjalan!';
            $status = 'info';
            return compact(['status', 'message']);
        } else {
            $c = loginController::getConnectionProcedure();
            $sql = "BEGIN SP_PROSES_LPP2('" . Session::get('kdigr') . "',to_date('" . $periode1 . "','dd/mm/yyyy'),to_date('" . $periode2 . "','dd/mm/yyyy'),false,:p_sukses,:err_txt); END;";
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
}
