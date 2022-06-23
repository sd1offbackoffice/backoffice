<?php

namespace App\Http\Controllers\BACKOFFICE\TRANSAKSI\PENERIMAAN;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Auth\loginController;
use Carbon\Carbon;

class NPDBKController extends Controller
{
    public function index()
    {
        return view('BACKOFFICE.TRANSAKSI.PENERIMAAN.npdbk');
    }

    public function download()
    {
        $connect = loginController::getConnectionProcedureKMY();
        $query = oci_parse($connect, "BEGIN sp_proses_trf_rte_npd_php(:p_sukses, :hasil); END;");
        oci_bind_by_name($query, ':p_sukses', $p_sukses, 32);
        oci_bind_by_name($query, ':hasil', $hasil, 32);
        oci_execute($query);

        if ($p_sukses == 'N') { //FALSE
            return response()->json(['kode' => '1', 'message' => $hasil, 'p_sukses' => $p_sukses]);
        } else {
            return response()->json(['kode' => '0', 'message' => 'Data NPD sudah di download', 'p_sukses' => $p_sukses]);
        }
    }

    public function upload(Request $request)
    {
        $tgl = $request->tgl;
        $tgl = date("d-m-Y", strtotime($tgl));
        if (!(isset($tgl))) {
            $tgl = Carbon::now()->format('d-m-Y');
        }
        $connect = loginController::getConnectionProcedureKMY();
        $query = oci_parse($connect, "BEGIN SP_RTE_BASK_PHP(to_date(:tgl_proses, 'DD-MM-YYYY HH24:MI:SS'), :p_sukses, :hasil); END;");
        oci_bind_by_name($query, ':tgl_proses', $tgl);
        oci_bind_by_name($query, ':p_sukses', $p_sukses, 32);
        oci_bind_by_name($query, ':hasil', $hasil, 100);
        oci_execute($query);

        if ($p_sukses == 'N') { //FALSE
            return response()->json(['kode' => '1', 'message' => $hasil, 'p_sukses' => $p_sukses]);
        } else {
            $query = oci_parse($connect, "BEGIN SP_RTE_BASK_FAD_PHP(to_date(:tgl_proses, 'DD-MM-YYYY HH24:MI:SS'), :p_sukses, :hasil); END;");
            oci_bind_by_name($query, ':tgl_proses', $tgl);
            oci_bind_by_name($query, ':p_sukses', $p_sukses, 32);
            oci_bind_by_name($query, ':hasil', $hasil, 100);
            oci_execute($query);
            if ($p_sukses == 'N') { //FALSE
                return response()->json(['kode' => '1', 'message' => $hasil, 'p_sukses' => $p_sukses]);
            } else {
                return response()->json(['kode' => '0', 'message' => 'Data BK berhasil diupload', 'p_sukses' => $p_sukses]);
            }
        }
    }
}
