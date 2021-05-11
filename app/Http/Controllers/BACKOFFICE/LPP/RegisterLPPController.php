<?php

namespace App\Http\Controllers\BACKOFFICE\LPP;

use Carbon\Carbon;
use Dompdf\Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use PDF;
use Yajra\DataTables\DataTables;
use File;

class RegisterLPPController extends Controller
{
    public function index()
    {
        return view('BACKOFFICE.LPP.registerlpp');
    }

    public function proses(Request $request)
    {

        $periode1 = $request->periode1;
        $periode2 = $request->periode2;

        $p_sukses = false;
        $err_txt = '';


        $c = oci_connect($_SESSION['conUser'], $_SESSION['conPassword'], $_SESSION['conString']);
        $sql = "BEGIN SP_PROSES_LPP2('" . $_SESSION['kdigr'] . "',to_date('" . $periode1 . "','dd/mm/yyyy'),to_date('" . $periode2 . "','dd/mm/yyyy'),false,:p_sukses,:err_txt); END;";
        $s = oci_parse($c, $sql);

        oci_bind_by_name($s, ':p_sukses', $p_sukses, 200);
        oci_bind_by_name($s, ':err_txt', $err_txt, 200);
        oci_execute($s);

        $status = '';
        if ($p_sukses == 'TRUE') {
            $err_txt = 'Proses LPP Sudah Selesai !';
            $status = 'success';
        } else {
            $err_txt = 'Proses LPP GAGAL! --> '. $err_txt;
            $status = 'error';
        }
        $message = $err_txt;
        return compact(['status', 'message']);

    }
}
