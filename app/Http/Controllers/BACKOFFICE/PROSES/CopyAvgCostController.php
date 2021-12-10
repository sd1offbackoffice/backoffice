<?php

namespace App\Http\Controllers\BACKOFFICE\PROSES;

use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller; use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Mockery\Exception;
use PDF;
use Yajra\DataTables\DataTables;

class CopyAvgCostController extends Controller
{
    public function index(){
        $data = DB::connection(Session::get('connection'))
            ->table('tbmaster_perusahaan')
            ->selectRaw("prs_bulanberjalan || '/' || prs_tahunberjalan periode,prs_fmflcs copyacost,prs_periodeterakhir periodeaktif")
            ->first();

        return view('BACKOFFICE.PROSES.copy-avg-cost')->with(compact(['data']));
    }

    public function copyData(){
        try{
            DB::connection(Session::get('connection'))->beginTransaction();

            $periode = DB::connection(Session::get('connection'))
                ->table('tbmaster_perusahaan')
                ->selectRaw("prs_bulanberjalan bulan, prs_tahunberjalan tahun")
                ->first();

            $bulan = $periode->bulan;
            $tahun = $periode->tahun;

            DB::connection(Session::get('connection'))
                ->update("UPDATE TBMASTER_STOCK
                                SET ST_AVGCOSTMONTHEND = ST_AVGCOST
                                WHERE ST_KODEIGR = '".Session::get('kdigr')."'");

            DB::connection(Session::get('connection'))
                ->table('tbmaster_perusahaan')
                ->update([
                    'prs_fmflcs' => 'Y'
                ]);

            $tglAwal = $bulan.'-'.$tahun;

            $tglTabel = $tahun.'_'.$bulan;

            $table = [
                'TBHISTORY_STOCK_',
                'TBMASTER_STOCK_',
                'TBMASTER_STOCK_CABANAK_',
                'TBTR_LPP_',
                'TBTR_LPPRT_',
                'TBTR_LPPRS_',
                'TBTR_SALESBULANAN_',
                'TBTR_REKAPSALESBULANAN_'
            ];

            foreach($table as $t){
                $temp = DB::connection(Session::get('connection'))
                    ->table('user_tables')
                    ->where('table_name','=',$t.$tglTabel)
                    ->first();

                if($temp){
                    DB::connection(Session::get('connection'))
                        ->statement("DROP TABLE ".$t.$tglTabel);
                }
            }

            DB::connection(Session::get('connection'))
                ->statement("CREATE TABLE TBHISTORY_STOCK_".$tglTabel."
                AS ( SELECT * FROM TBHISTORY_STOCK WHERE ST_PERIODE <> '".$tahun.$bulan."')");

            DB::connection(Session::get('connection'))
                ->statement("CREATE TABLE TBMASTER_STOCK_".$tglTabel."
                AS ( SELECT * FROM TBMASTER_STOCK)");

            DB::connection(Session::get('connection'))
                ->statement("CREATE TABLE TBMASTER_STOCK_CABANAK_".$tglTabel."
                AS ( SELECT * FROM TBMASTER_STOCK_CAB_ANAK)");

            DB::connection(Session::get('connection'))
                ->statement("CREATE TABLE TBTR_LPP_".$tglTabel."
                AS ( SELECT * FROM TBTR_LPP
                WHERE TO_CHAR(LPP_TGL1, 'MM-YYYY') <> '".$tglAwal."')");

            DB::connection(Session::get('connection'))
                ->statement("CREATE TABLE TBTR_LPPRT_".$tglTabel."
                AS ( SELECT * FROM TBTR_LPPRT
                WHERE TO_CHAR(LRT_TGL1, 'MM-YYYY') <>  '".$tglAwal."')");

            DB::connection(Session::get('connection'))
                ->statement("CREATE TABLE TBTR_LPPRS_".$tglTabel."
                AS ( SELECT * FROM TBTR_LPPRS
                WHERE TO_CHAR(LRS_TGL1, 'MM-YYYY') <>  '".$tglAwal."')");

            DB::connection(Session::get('connection'))
                ->statement("CREATE TABLE TBTR_SALESBULANAN_".$tglTabel."
                AS ( SELECT * FROM TBTR_SALESBULANAN)");

            DB::connection(Session::get('connection'))
                ->statement("CREATE TABLE TBTR_REKAPSALESBULANAN_".$tglTabel."
                AS ( SELECT * FROM TBTR_REKAPSALESBULANAN)");

            DB::connection(Session::get('connection'))->commit();

            return response()->json([
                'message' => 'Copy Average Cost untuk Month End berhasil!'
            ], 200);
        }
        catch (\Exception $e){
            DB::connection(Session::get('connection'))->rollBack();

            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
