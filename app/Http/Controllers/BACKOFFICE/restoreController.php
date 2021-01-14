<?php
namespace App\Http\Controllers\BACKOFFICE;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class restoreController extends Controller
{
    public function index(){
        return view('BACKOFFICE.restore');
    }

    public function restoreNow(Request $request){
        try{
            $kodeigr= $_SESSION['kdigr'];
            $userid = $_SESSION['usid'];
            $month = $request->month;
            $year = $request->year;

            $p_sukses = 'FALSE';
            $errtxt = "";
            $namaf = "TBMASTER_STOCK_".$year."_".$month;
            $data = DB::SELECT("SELECT LAST_DAY(TO_DATE('01-' || CASE WHEN (TO_NUMBER(PRS_BULANBERJALAN) -1) = 0 THEN 12 ELSE (TO_NUMBER(PRS_BULANBERJALAN) -1) END || '-' || CASE WHEN (TO_NUMBER(PRS_BULANBERJALAN) -1) = 0 THEN TO_NUMBER(PRS_TAHUNBERJALAN)-1 ELSE TO_NUMBER(PRS_TAHUNBERJALAN) END , 'DD-MM-YYYY')) a, TO_CHAR( TO_DATE(CASE WHEN (TO_NUMBER(PRS_BULANBERJALAN) -1) = 0 THEN TO_NUMBER(PRS_TAHUNBERJALAN)-1 ELSE TO_NUMBER(PRS_TAHUNBERJALAN) END || '-' || CASE WHEN (TO_NUMBER(PRS_BULANBERJALAN) -1) = 0 THEN 12 ELSE (TO_NUMBER(PRS_BULANBERJALAN) -1) END,'YYYY-MM'),'YYYYMM') b FROM TBMASTER_PERUSAHAAN WHERE PRS_KODEIGR = ".$kodeigr);

            $txtPeriode = $data[0]->a;
            $parameterPeriode = $data[0]->b;

            DB::beginTransaction();
            if($year.$month != $parameterPeriode){
                return response()->json(['kode' => 2, 'msg' => "Periode Restore Data Salah !!"]);
            }else{
                $connect = oci_connect('SIMSMG', 'SIMSMG', '192.168.237.193:1521/SIMSMG');
                $query = oci_parse($connect, "BEGIN SP_RESTORE_STOCK2 ('$kodeigr', '$namaf', :P_SUKSES, :ERR_TXT); END;");
                oci_bind_by_name($query, ':P_SUKSES', $p_sukses, 32);
                oci_bind_by_name($query, ':ERR_TXT', $errtxt, 32);
                oci_execute($query);

                //masih gagal disini

                if($p_sukses == 'TRUE'){
                    $errtxt = "Proses Restore Data Berhasil !";

                    Schema::dropIfExists('TBHISTORY_STOCK');
                    Schema::dropIfExists('TBMASTER_STOCK_CAB_ANAK');
                    Schema::dropIfExists('TBTR_LPP');
                    Schema::dropIfExists('TBTR_LPPRT');
                    Schema::dropIfExists('TBTR_LPPRS');
                    Schema::dropIfExists('TBTR_SALESBULANAN');
                    Schema::dropIfExists('TBTR_REKAPSALESBULANAN');

//                    Schema::create('TBHISTORY_STOCK', function (Blueprint $table) {
//                        $table->id();
//                        $table->string('name');
//                        $table->string('airline');
//                        $table->timestamps();
//                    });
                    $query = oci_parse($connect, "CREATE TABLE TBHISTORY_STOCK AS ( SELECT * FROM TBHISTORY_STOCK_".$year."_".$month.")");
                    oci_execute($query);
                    $query = oci_parse($connect, "CREATE TABLE TBMASTER_STOCK_CAB_ANAK AS ( SELECT * FROM TBMASTER_STOCK_CABANAK_".$year."_".$month.")");
                    oci_execute($query);
                    $query = oci_parse($connect, "CREATE TABLE TBTR_LPP AS ( SELECT * FROM TBTR_LPP_".$year."_".$month.")");
                    oci_execute($query);
                    $query = oci_parse($connect, "CREATE TABLE TBTR_LPPRT AS ( SELECT * FROM TBTR_LPPRT_".$year."_".$month.")");
                    oci_execute($query);
                    $query = oci_parse($connect, "CREATE TABLE TBTR_LPPRS AS ( SELECT * FROM TBTR_LPPRS_".$year."_".$month.")");
                    oci_execute($query);
                    $query = oci_parse($connect, "CREATE TABLE TBTR_SALESBULANAN AS ( SELECT * FROM TBTR_SALESBULANAN_".$year."_".$month.")");
                    oci_execute($query);
                    $query = oci_parse($connect, "CREATE TABLE TBTR_REKAPSALESBULANAN AS ( SELECT * FROM TBTR_REKAPSALESBULANAN_".$year."_".$month.")");
                    oci_execute($query);

                    DB::table("TBMASTER_PERUSAHAAN")
                        ->where('PRS_KODEIGR','=',$kodeigr)
                        ->update(['PRS_BULANBERJALAN' => $month, 'PRS_TAHUNBERJALAN' => $year, 'PRS_FMFLCS' => 'Y']);
                    DB::commit();
                    return response()->json(['kode' => 1, 'msg' => $errtxt]);
                }else{
                    $errtxt = 'Proses Restore Data GAGAL! --> '.$errtxt;
                    return response()->json(['kode' => 2, 'msg' => $errtxt]);
                }

            }
        }catch (\Exception $e){
            dd($e->getMessage());
            //return response()->json(['kode' => 2, 'msg' => $e->getMessage()]);
        }
    }
}
