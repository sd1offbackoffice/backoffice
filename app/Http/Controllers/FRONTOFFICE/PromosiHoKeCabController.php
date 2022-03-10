<?php
/**
 * Created by PhpStorm.
 * User: ryan
 * Date: 1/12/2021
 * Time: 3:25 PM
 */

namespace App\Http\Controllers\FRONTOFFICE;

use App\Http\Controllers\Auth\loginController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller; use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use PDF;

class PromosiHoKeCabController extends Controller
{

    public function index()
    {
        return view('FRONTOFFICE.PromosiHoKeCab');
    }
    public function DownBaru(Request $request){
        try{
            set_time_limit(0);

            $kodeigr = Session::get('kdigr');
            $p_sukses = "false";
            $err_txt = "";
            $connect = loginController::getConnectionProcedure();
            $query = oci_parse($connect, "BEGIN IGR_IMPORT_DATA_PROMOSI2 (
       '$kodeigr',
       :err_txt,
       :p_sukses
    ); END;");
            oci_bind_by_name($query, ':err_txt', $err_txt,512);
            oci_bind_by_name($query, ':p_sukses', $p_sukses,512);
            oci_execute($query);


            if($p_sukses == "TRUE"){
                $msg = "Proses Tarik Data Berhasil";
            }else{
                $msg = "Proses Tarik Data GAGAL! --> ".$err_txt;
            }
            return response()->json($msg);
        }catch (\Exception $e){
            $msg = "Proses Tarik Data GAGAL!!! --> ".$e->getMessage();

            return response()->json($msg);
        }
    }
    public function DownEdit(Request $request){
        try{
            set_time_limit(0);
            $kodeigr = Session::get('kdigr');
            $p_sukses = "false";
            $err_txt = "";
            $connect = loginController::getConnectionProcedure();
            $query = oci_parse($connect, "BEGIN IGR_UPDATE_DATA_PROMOSI2 (
       '$kodeigr',
       :err_txt,
       :p_sukses
    ); END;");
            oci_bind_by_name($query, ':err_txt', $err_txt,512);
            oci_bind_by_name($query, ':p_sukses', $p_sukses,512);
            oci_execute($query);

            if($p_sukses == "TRUE"){
                $msg = "Proses Tarik Data Berhasil";
            }else{
                $msg = "Proses Tarik Data GAGAL! --> ".$err_txt;
            }
            return response()->json($msg);
        }catch (\Exception $e){
            $msg = "Proses Tarik Data GAGAL!!! --> ".$e->getMessage();

            return response()->json($msg);
        }
    }

    public function Status(){
        $new = DB::connection(Session::get('connection'))->table("tblog_laravel_ias")
            ->selectRaw("to_char(start_time, 'dd/mm/yyyy hh:mi:ss') start_time, to_char(end_time, 'dd/mm/yyyy hh:mi:ss') end_time, status, message")
            ->where("menu",'=',"DWLD DATA PROMOSI HO")
            ->where("submenu",'=',"DATA BARU")
            ->first();
        $edit = DB::connection(Session::get('connection'))->table("tblog_laravel_ias")
            ->selectRaw("to_char(start_time, 'dd/mm/yyyy hh:mi:ss') start_time, to_char(end_time, 'dd/mm/yyyy hh:mi:ss') end_time, status, message")
            ->where("menu",'=',"DWLD DATA PROMOSI HO")
            ->where("submenu",'=',"DATA EDIT")
            ->first();
        return response()->json(['new' => $new, 'edit' => $edit]);
    }
}
