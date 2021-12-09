<?php

namespace App\Http\Controllers\FRONTOFFICE;

use App\Http\Controllers\ADMINISTRATION\AccessController;
use App\Http\Controllers\Auth\loginController;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;
use PDF;
use Yajra\DataTables\DataTables;
use ZipArchive;
use File;

class FakturPajakStandardController extends Controller
{
    public function index(){
        return view('FRONTOFFICE.faktur-pajak-standard');
    }

    public function createCSV(Request $request){
        $temp = DB::connection($_SESSION['connection'])
            ->selectOne("SELECT *
FROM tbtr_jualdetail
WHERE TRUNC (trjd_transactiondate)
BETWEEN TRUNC (to_date('".$request->periode."','mm/yyyy'), 'mm') AND LAST_DAY(to_date('".$request->periode."','mm/yyyy'))
AND TRJD_FLAGTAX1 = 'Y' AND trjd_cus_kodemember IN
(SELECT cus_kodemember
FROM tbmaster_customer
WHERE cus_flagmemberkhusus = 'Y'
AND NVL (cus_flagpkp, 'z') <> 'Y'
AND NVL (cus_jenismember, 'N') <> 'T'
AND cus_kodeigr = '".$_SESSION['kdigr']."')
AND trjd_cus_kodemember NOT IN
(SELECT fkt_kodemember
FROM tbmaster_faktur_nonpkp
WHERE fkt_tglfaktur = LAST_DAY(to_date('".$request->periode."','mm/yyyy')))
AND ROWNUM <= 1");

        if($temp){
            return response()->json([
                'message' => 'Ada member yang belum ada nomor FP, silahkan proses terlebih dahulu!',
            ], 500);
        }
        else{
            $connect = loginController::getConnectionProcedure();

            $query = oci_parse($connect, "BEGIN sp_csv_fk_mm_nonpkp('".$_SESSION['kdigr']."', to_date('".$request->periode."','mm/yyyy')); END;");
            oci_execute($query);

            return response()->json([
                'message' => 'CSV berhasil dibuat!',
            ], 200);
        }
    }

    public function getCSV(Request $request){
        $tipe = $request->tipe;
        $periode = explode('/',$request->periode);

        $filename = $request->tipe.$_SESSION['kdigr'].'_'.$periode[1].$periode[0].'.CSV';

        $data = DB::connection($_SESSION['connection'])
            ->table('documents')
            ->where('doc_name','=',$filename)
            ->first();

        return response($data->doc_blob)
            ->header('Cache-Control', 'no-cache private')
            ->header('Content-Description', 'File Transfer')
            ->header('Content-Type', 'application/octet-stream')
            ->header('Content-length', strlen($data->doc_blob))
            ->header('Content-Disposition', 'attachment; filename=' . $filename)
            ->header('Content-Transfer-Encoding', 'binary');
    }
}
