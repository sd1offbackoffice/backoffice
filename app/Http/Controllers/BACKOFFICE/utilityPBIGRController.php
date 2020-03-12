<?php

namespace App\Http\Controllers\BACKOFFICE;

use App\AllModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class utilityPBIGRController extends Controller
{
    /*
     * NOTEE
        SEMUA PROCEDURE DIUBAH PARAMETER DARI BOOLEAN KE VARCHAR2
     * */

    public $connection;
    public function __construct()
    {
        $model      = new AllModel();
        $this->connection = $model->connectionProcedure();
    }

    public function index(){
        $model      = new AllModel();
        $this->model = $model->connectionProcedure();

        return view('BACKOFFICE.utilityPBIGR');
    }

    public function cekTableServieceLevel(){
        $date       = date('Ym', strtotime(date('Y-m-d') . '- 1 month'));
        $search     = DB::table('tbtr_servicelevel')->where('slv_periode', $date)->get()->toArray();

        return $search;
    }

    public function callProc1(){
        $search     = $this->cekTableServieceLevel();
        $v_param    = date('Ym');
        $v_sukses   = '';
        $v_errtxt   = '';

        if (!$search){
             return response()->json(['kode' => '0', 'return' => "Data Service Level Kosong !!"]);
        }

        $connection = $this->connection;

        try{
            $exec = oci_parse($connection, "BEGIN  sp_hitung_mplusi2(:param,:sukses,:errtxt); END;");
            oci_bind_by_name($exec, ':param',$v_param);
            oci_bind_by_name($exec, ':sukses', $v_sukses,10);
            oci_bind_by_name($exec, ':errtxt', $v_errtxt,1000);
            oci_execute($exec);

            if (!$v_sukses){
                return response()->json(['kode' => '0', 'return' => $v_errtxt]);
            } else {
                $msg = 'Data M PLUS.I Periode '.date('m-Y'). ' Sudah di Proses !!';
                return response()->json(['kode' => '1', 'return' => $msg]);
            }
        } catch (\Exception $catch){
            return response()->json(['kode' => '0', 'return' => "Call Procedure Failed"]);

        }
    }

    public function callProc2(){
        $connection = $this->connection;

        try{
            $exec = oci_parse($connection, "BEGIN  sp_tarik_seasonalomi2(:sukses,:errtxt); END;");
            oci_bind_by_name($exec, ':sukses', $v_sukses,10);
            oci_bind_by_name($exec, ':errtxt', $v_errtxt,1000);
            oci_execute($exec);

            if (!$v_sukses){
                return response()->json(['kode' => '0', 'return' => $v_errtxt]);
            } else {
                $msg = 'arikan Data Bulan Seasonal Sudah di Proses !!';
                return response()->json(['kode' => '1', 'return' => $msg]);
            }
        } catch (\Exception $catch){
            return response()->json(['kode' => '0', 'return' => "Call Procedure Failed"]);
        }
    }

    public function callProc3(){
        $search     = $this->cekTableServieceLevel();
        $v_param    = date('Ym');

        $connection = $this->connection;

        if (!$search){
            return response()->json(['kode' => '0', 'return' => "Data Service Level Kosong !!"]);
        }

        try{
            $exec = oci_parse($connection, "BEGIN  sp_hitung_mpluso2(:param,:sukses,:errtxt); END;");
            oci_bind_by_name($exec, ':param',$v_param);
            oci_bind_by_name($exec, ':sukses', $v_sukses,10);
            oci_bind_by_name($exec, ':errtxt', $v_errtxt,1000);
            oci_execute($exec);

            if (!$v_sukses){
                return response()->json(['kode' => '0', 'return' => $v_errtxt]);
            } else {
                $msg = 'Data M PLUS.O Periode '.date('m-Y'). ' Sudah di Proses !!';
                return response()->json(['kode' => '1', 'return' => $msg]);
            }
        } catch (\Exception $catch){
            return response()->json(['kode' => '0', 'return' => "Call Procedure Failed"]);

        }

    }

    public function callProc4(Request $request){
        $date   = $request->date;
        $date   = date('Ym', strtotime($date));
        $kodeigr= '22';

        $search = DB::table('tbtr_hitung_pb')->where('thp_periode', $date)->get()->toArray();

        if (!$search){
            return response()->json(['kode' => '0', 'return' => 'Data MPLUS-I Tidak Ada !!']);
        }

        $report = $this->isiLaporan($date,$kodeigr);

        dd($report);
    }

    public function isiLaporan($periode, $kodeigr){



//        $data   = DB::table('tbtr_hitung_pb a')
//            ->selectRaw("prs_namaperusahaan,
//                                   prs_namacabang,
//                                   thp_prdcd,
//                                   prc_pluidm,
//                                   prd_deskripsipanjang,
//                                   NVL (kphold, 0) kphold,
//                                   NVL (minold, 0) minold,
//                                   kph.ksl_mean kph1,
//                                   (kph.ksl_mean * 3) kph3,
//                                   (kph.ksl_mean * 4) kph4,
//                                   case when nvl(kph.minor, 0) <> 0 then kph.minor else to_number(minorder_omi, 9999 ) end minor,
//                                   prd_kodetag,
//                                   prc_kodetag,
//                                   prd_frac
//                                 case when nvl(thp_sl_mplusi, 0) <> 0 then thp_sl_mplusi else thp_sl_mpluso end thp_sl_mplusi,
//                                   NVL (mplusiex, 0) mplusiex,
//                                   NVL (ROUND (minold / prd_frac, 2), 0) minfracold,
//                                   NVL (ROUND (case when nvl(kph.minor, 0) <> 0 then kph.minor else to_number(minorder_omi, 99999 ) end / prd_frac, 2), 0) minfrac,
//                                   CASE
//                                      WHEN NVL (ROUND (minold / prd_frac, 2), 0) <
//                                              NVL (ROUND (case when nvl(kph.minor, 0) <> 0 then kph.minor else to_number(minorder_omi, 99999 ) end / prd_frac, 2), 0)
//                                      THEN
//                                         'NAIK'
//                                      ELSE
//                                         CASE
//                                            WHEN NVL (ROUND (minold / prd_frac, 2), 0) >
//                                                    NVL (ROUND (case when nvl(kph.minor, 0) <> 0 then kph.minor else to_number(minorder_omi, 99999 ) end / prd_frac, 2), 0)
//                                            THEN
//                                               'TURUN'
//                                            ELSE
//                                               'TETAP'
//                                         END
//                                   END
//                                      minfracket,
//                                   case when nvl(thp_n_mplusi, 0) <> 0 then thp_n_mplusi else thp_n_mpluso end thp_n_mplusi,
//                                   NVL (pkmp_mplusi, 0) mplusnow,
//                                   thp_mplusi,
//                                   CASE
//                                      WHEN prdcdb IS NOT NULL AND prdcdc IS NOT NULL
//                                      THEN
//                                         'FRAC-BULKY'
//                                      ELSE
//                                         CASE
//                                            WHEN prdcdb IS NOT NULL AND prdcdc IS NULL
//                                            THEN
//                                               'BULKY'
//                                            ELSE
//                                               CASE
//                                                  WHEN prdcdb IS NULL AND prdcdc IS NOT NULL THEN 'FRAC'
//                                                  ELSE ''
//                                               END
//                                         END
//                                   END
//                                      keterangan,
//                                   THP_AVGPB_OMI,
//                                   thp_n_mpluso,
//                                   THP_MPLUSO,
//                                   NVL (mplusoex, 0) mplusoex
//                                   ")
//            ->leftJoin('tbmaster_perusahaan b', 'b.prs_kodeigr', 'a.thp_kodeigr')
//            ->leftJoin('tbmaster_prodcrm c','c.prc_pluigr','a.thp_prdcd')
//            ->leftJoin('tbmaster_prodmast d','d.prd_prdcd','a.thp_prdcd')
//            ->leftJoin('tbmaster_pkmplus e','e.pkmp_prdcd','a.thp_prdcd')

//            ->where('a.thp_periode',$periode)
//            ->where('b.prs_kodeigr', $kodeigr)
//            ->whereRaw('(NVL (a.thp_mplusi, 0) <> 0  or  NVL (a.thp_mpluso, 0) <> 0)')
//            ->where('c.prc_group','I')
//            ->where('c.prc_plu','a.thp_prdcd')
//            ->first();

        $prcomi = DB::table('tbmaster_prodcrm')->select('prc_pluigr as prcplu', 'prc_minorder as minorder_omi')->where('prc_group', 'O')->get()->toArray();

        $kphold = DB::select("SELECT pid,
                                           prdcd pluold,
                                           NVL (ksl_mean, 0) kphold,
                                           NVL (minor, 0) minold
                                      FROM (SELECT ROW_NUMBER ()
                                                   OVER (PARTITION BY PRDCD
                                                         ORDER BY TO_DATE (LPAD (pid, 6, '0'), 'mmYYYY') DESC)
                                                      AS RN,
                                                   pid,
                                                   prdcd,
                                                   ksl_mean,
                                                   minor
                                              FROM tbmaster_kph)
                                     WHERE rn = 2");

        $kph    = DB::select("SELECT pid,
                                    prdcd,
                                    ksl_mean,
                                    minor
                                   FROM (SELECT ROW_NUMBER ()
                                                OVER (
                                                   PARTITION BY PRDCD
                                                   ORDER BY
                                                      TO_DATE (LPAD (pid, 6, '0'), 'mmYYYY') DESC)
                                                   AS RN,
                                                pid,
                                                prdcd,
                                                ksl_mean,
                                                minor
                                           FROM tbmaster_kph)
                                  WHERE rn = 1");

        $lokB   = DB::table('tbmaster_lokasi')->selectRaw('DISTINCT lks_prdcd prdcdB, lks_noid')->where('lks_noid', 'LIKE', '%B')->get()->toArray();

        $lokC   = DB::table('tbmaster_lokasi')->selectRaw('DISTINCT lks_prdcd prdcdC, lks_noid')->where('lks_noid', 'NOT LIKE', '%B')->get()->toArray();

        $period = DB::table('tbtr_hitung_pb')->selectRaw('DISTINCT thp_periode')->where('thp_periode', '<', $periode)->orderByDesc('thp_periode')->first();

        $mplus2 = DB::table('tbtr_hitung_pb')->select('thp_prdcd as prdcdex', 'thp_mplusi as mplusiex')->where('thp_periode',$period->thp_periode)->get()->toArray();

        $mplus3 = DB::table('tbtr_hitung_pb')->select('thp_prdcd as prdcdex2', 'thp_mplusi as mplusoex')->where('thp_periode',$period->thp_periode)->get()->toArray();

        $data   = DB::table('tbtr_hitung_pb a')
            ->select('*')
            ->leftJoin('tbmaster_perusahaan b', 'b.prs_kodeigr', 'a.thp_kodeigr')
            ->leftJoin('tbmaster_prodcrm c','c.prc_pluigr','a.thp_prdcd')
            ->leftJoin('tbmaster_prodmast d','d.prd_prdcd','a.thp_prdcd')
            ->leftJoin('tbmaster_pkmplus e','e.pkmp_prdcd','a.thp_prdcd')
            ->where('a.thp_periode', $periode)
            ->where('b.prs_kodeigr', $kodeigr)
            ->whereRaw('(NVL (a.thp_mplusi, 0) <> 0 OR NVL (a.thp_mpluso, 0) <> 0')
            ->where('c.prc_group', 'I')
            ->where('a.thp_prdcd', $prcomi[]->prcplu)
            ->where('c.prc_pluidm', $kphold[]->pluold)
            ->where('a.thp_prdcd', $mplus2[]->prdcdex)
            ->where('a.thp_prdcd', $mplus3[]->prdcdex2)
            ->get()->toArray();


        return $data;

    }

}




/*
 ->

 * */
