<?php
/**
 * Created by PhpStorm.
 * User: ryan
 * Date: 1/12/2021
 * Time: 3:25 PM
 */

namespace App\Http\Controllers\FRONTOFFICE;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use PDF;

class PromosiHoKeCabController extends Controller
{

    public function index()
    {
        return view('FRONTOFFICE.PromosiHoKeCab');
    }
    public function DownBaru(Request $request){
        $kodeigr = $_SESSION['kdigr'];
        $p_sukses = "false";
        $err_txt = "";
        $connect = oci_connect('SIMSMG', 'SIMSMG', '192.168.237.193:1521/SIMSMG');
        $query = oci_parse($connect, "BEGIN IGR_IMPORT_DATA_PROMOSI2 (
       '$kodeigr',
       :err_txt,
       :p_sukses
    ); END;");
        oci_bind_by_name($query, ':err_txt', $err_txt, 32);
        oci_bind_by_name($query, ':p_sukses', $p_sukses, 32);
        oci_execute($query);

        if($p_sukses == "TRUE"){
            $msg = "Proses Tarik Data Berhasil";
        }else{
            $msg = "Proses Tarik Data GAGAL! --> ".$err_txt;
        }
        return response()->json($msg);
    }
    public function DownEdit(Request $request){
        $kodeigr = $_SESSION['kdigr'];
        $p_sukses = "false";
        $err_txt = "";
        $connect = oci_connect('SIMSMG', 'SIMSMG', '192.168.237.193:1521/SIMSMG');
        $query = oci_parse($connect, "BEGIN IGR_UPDATE_DATA_PROMOSI2 (
       '$kodeigr',
       :err_txt,
       :p_sukses
    ); END;");
        oci_bind_by_name($query, ':err_txt', $err_txt, 32);
        oci_bind_by_name($query, ':p_sukses', $p_sukses, 32);
        oci_execute($query);

        if($p_sukses == "TRUE"){
            $msg = "Proses Tarik Data Berhasil";
        }else{
            $msg = "Proses Tarik Data GAGAL! --> ".$err_txt;
        }
        return response()->json($msg);
    }
}
