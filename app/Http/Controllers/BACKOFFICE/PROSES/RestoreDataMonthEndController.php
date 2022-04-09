<?php
namespace App\Http\Controllers\BACKOFFICE\PROSES;

use App\Http\Controllers\Auth\loginController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller; use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class RestoreDataMonthEndController extends Controller
{
    public function index(){
        return view('BACKOFFICE.PROSES.restore-data-month-end');
    }

    public function restoreNow(Request $request){
        try{
            $kodeigr= Session::get('kdigr');
            $userid = Session::get('usid');
            $month = $request->month;
            $year = $request->year;

            $isRunning = $this->cekProcedure("'SP_PROSES_LPP2','SP_RESTORE_STOCK2'");

            if ($isRunning > 0) {
                $message = 'Procedure Proses LPP / Restore Data Month End sedang berjalan!';
                $status = 'info';
                return compact(['status', 'message']);
            }

            $p_sukses = 'FALSE';
            $errtxt = "";
            $namaf = "TBMASTER_STOCK_".$year."_".$month;
            $data = DB::connection(Session::get('connection'))
                ->select("SELECT LAST_DAY(TO_DATE('01-' || CASE WHEN (TO_NUMBER(PRS_BULANBERJALAN) -1) = 0 THEN 12 ELSE (TO_NUMBER(PRS_BULANBERJALAN) -1) END || '-' || CASE WHEN (TO_NUMBER(PRS_BULANBERJALAN) -1) = 0 THEN TO_NUMBER(PRS_TAHUNBERJALAN)-1 ELSE TO_NUMBER(PRS_TAHUNBERJALAN) END , 'DD-MM-YYYY')) a,
                                TO_CHAR( TO_DATE(CASE WHEN (TO_NUMBER(PRS_BULANBERJALAN) -1) = 0 THEN TO_NUMBER(PRS_TAHUNBERJALAN)-1 ELSE TO_NUMBER(PRS_TAHUNBERJALAN) END || '-' || CASE WHEN (TO_NUMBER(PRS_BULANBERJALAN) -1) = 0 THEN 12 ELSE (TO_NUMBER(PRS_BULANBERJALAN) -1) END,'YYYY-MM'),'YYYYMM') b
                        FROM TBMASTER_PERUSAHAAN
                        WHERE PRS_KODEIGR = ".$kodeigr);

            $txtPeriode = $data[0]->a;
            $parameterPeriode = $data[0]->b;

            DB::connection(Session::get('connection'))->beginTransaction();
            if($year.$month != $parameterPeriode){
                return response()->json(['kode' => 2, 'msg' => "Periode Restore Data Salah !!"]);
            }else{
                $connect = loginController::getConnectionProcedure();
                $query = oci_parse($connect, "BEGIN SP_RESTORE_STOCK2 ('$kodeigr', '$namaf', :P_SUKSES, :ERR_TXT); END;");
                oci_bind_by_name($query, ':P_SUKSES', $p_sukses, 32);
                oci_bind_by_name($query, ':ERR_TXT', $errtxt, 32);
                oci_execute($query);

                //masih gagal disini

                if($p_sukses == 'TRUE'){
                    $errtxt = "Proses Restore Data Berhasil !";

                    $cek = DB::connection(Session::get('connection'))
                        ->select("select count(1) count FROM user_tables WHERE table_name = 'TBHISTORY_STOCK'")[0]->count;
                    if($cek>0){
                        DB::connection(Session::get('connection'))->statement('drop table TBHISTORY_STOCK');
                    }

                    $cek = DB::connection(Session::get('connection'))
                        ->select("select count(1) count FROM user_tables WHERE table_name = 'TBMASTER_STOCK_CAB_ANAK'")[0]->count;
                    if($cek>0){
                        DB::connection(Session::get('connection'))->statement('drop table TBMASTER_STOCK_CAB_ANAK');
                    }

                    $cek = DB::connection(Session::get('connection'))
                        ->select("select count(1) count FROM user_tables WHERE table_name = 'TBTR_LPP'")[0]->count;
                    if($cek>0){
                        DB::connection(Session::get('connection'))->statement('drop table TBTR_LPP');
                    }

                    $cek = DB::connection(Session::get('connection'))
                        ->select("select count(1) count FROM user_tables WHERE table_name = 'TBTR_LPPRT'")[0]->count;
                    if($cek>0){
                        DB::connection(Session::get('connection'))->statement('drop table TBTR_LPPRT');
                    }

                    $cek = DB::connection(Session::get('connection'))
                        ->select("select count(1) count FROM user_tables WHERE table_name = 'TBTR_LPPRS'")[0]->count;
                    if($cek>0){
                        DB::connection(Session::get('connection'))->statement('drop table TBTR_LPPRS');
                    }

                    $cek = DB::connection(Session::get('connection'))
                        ->select("select count(1) count FROM user_tables WHERE table_name = 'TBTR_SALESBULANAN'")[0]->count;
                    if($cek>0){
                        DB::connection(Session::get('connection'))->statement('drop table TBTR_SALESBULANAN');
                    }

                    $cek = DB::connection(Session::get('connection'))
                        ->select("select count(1) count FROM user_tables WHERE table_name = 'TBTR_REKAPSALESBULANAN'")[0]->count;
                    if($cek>0){
                        DB::connection(Session::get('connection'))->statement('drop table TBTR_REKAPSALESBULANAN');
                    }

//                    Schema::dropIfExists('TBHISTORY_STOCK');
//                    Schema::dropIfExists('TBMASTER_STOCK_CAB_ANAK');
//                    Schema::dropIfExists('TBTR_LPP');
//                    Schema::dropIfExists('TBTR_LPPRT');
//                    Schema::dropIfExists('TBTR_LPPRS');
//                    Schema::dropIfExists('TBTR_SALESBULANAN');
//                    Schema::dropIfExists('TBTR_REKAPSALESBULANAN');

//                    Schema::create('TBHISTORY_STOCK', function (Blueprint $table) {
//                        $table->id();
//                        $table->string('name');
//                        $table->string('airline');
//                        $table->timestamps();
//                    });

                    $query = oci_parse($connect, "CREATE TABLE TBHISTORY_STOCK AS ( SELECT * FROM TBHISTORY_STOCK_".$year."_".$month.")");
                    oci_execute($query);
                    DB::connection(Session::get('connection'))->statement('CREATE INDEX HST_IDX1 ON TBHISTORY_STOCK (ST_KODEIGR, ST_PRDCD, ST_LOKASI, ST_PERIODE)');

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

                    DB::connection(Session::get('connection'))->table("TBMASTER_PERUSAHAAN")
                        ->where('PRS_KODEIGR','=',$kodeigr)
                        ->update(['PRS_BULANBERJALAN' => $month, 'PRS_TAHUNBERJALAN' => $year, 'PRS_FMFLCS' => 'Y']);
                    DB::connection(Session::get('connection'))->commit();
                    return response()->json(['kode' => 1, 'msg' => $errtxt]);
                }else{
                    $errtxt = 'Proses Restore Data GAGAL! --> '.$errtxt;
                    return response()->json(['kode' => 2, 'msg' => $errtxt]);
                }

            }
        }catch (\Exception $e){
            //dd($e->getMessage());
            return response()->json(['kode' => 2, 'msg' => $e->getMessage()]);
        }
    }
}
