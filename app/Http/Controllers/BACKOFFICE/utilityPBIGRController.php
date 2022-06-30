<?php

namespace App\Http\Controllers\BACKOFFICE;

use App\AllModel;
use App\Http\Controllers\Auth\loginController;
use Dompdf\Exception;
use PDF;
use function foo\func;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller; use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

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
        $this->connection = loginController::getConnectionProcedure();
    }

    public function index(){
        $model      = new AllModel();
        $this->model = loginController::getConnectionProcedure();;

        return view('BACKOFFICE.utilityPBIGR');
    }

    public function cekTableServieceLevel(){
        $date       = date('Ym', strtotime(date('Y-m-d') . '- 1 month'));
        $search     = DB::connection(Session::get('connection'))->table('tbtr_servicelevel')->where('slv_periode', $date)->get()->toArray();

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
            $exec = oci_parse($connection, "BEGIN  sp_hitung_mplusi_web(:param,:sukses,:errtxt); END;"); // ganti 2 pakai _web
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
            return response()->json(['kode' => '0', 'return' => $catch->getMessage()]);
        }
    }

    public function callProc2(){
        $connection = $this->connection;

        try{
            $exec = oci_parse($connection, "BEGIN  sp_tarik_seasonalomi_web(:sukses,:errtxt); END;"); // ganti 2 pakai _web
            oci_bind_by_name($exec, ':sukses', $v_sukses,10);
            oci_bind_by_name($exec, ':errtxt', $v_errtxt,1000);
            oci_execute($exec);

            if (!$v_sukses){
                return response()->json(['kode' => '0', 'return' => $v_errtxt]);
            } else {
                $msg = 'Tarikan Data Bulan Seasonal Sudah di Proses !!';
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
            $exec = oci_parse($connection, "BEGIN  sp_hitung_mpluso_web(:param,:sukses,:errtxt); END;"); // ganti 2 pakai _web
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

    public function checkProc4(Request $request){
        $date   = $request->date;
//        $date2   = date('m/Y', strtotime($date));
        $kodeigr= Session::get('kdigr');

        $search = DB::connection(Session::get('connection'))->table('tbtr_hitung_pb')->where('thp_periode', $date)->get()->toArray();

        if (!$search){
            return response()->json(['kode' => '0', 'return' => 'Data MPLUS-I Tidak Ada !!']);
        } else {
            return response()->json(['kode' => '1', 'return' => 'Cetak !!']);
        }
    }

    public function callProc4(Request $request){
        $date   = $request->date;
        $periode   = date('Ym', strtotime($date));
        $kodeigr= Session::get('kdigr');

        $search = DB::connection(Session::get('connection'))->table('tbtr_hitung_pb')->where('thp_periode', $periode)->get()->toArray();

        if (!$search){
            return response()->json(['kode' => '0', 'return' => 'Data MPLUS-I Tidak Ada !!']);
        }


        $data = $this->isiLaporan($periode,$kodeigr);

        $perusahaan = DB::connection(Session::get('connection'))->table('tbmaster_perusahaan')->first();

        return view('BACKOFFICE.utilityPBIGR-laporan', compact(['perusahaan', 'data', 'periode']));

//        $pdf = PDF::loadview('BACKOFFICE.utilityPBIGR-laporan',['data' =>$report, 'periode' => $date, 'perusahaan' => $perusahaan]);
//        $pdf->output();
//        $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);
//
//        $canvas = $dompdf ->get_canvas();
//        $canvas->page_text(1000, 10, "Page {PAGE_NUM} of {PAGE_COUNT}", null, 10, array(0, 0, 0));
//
//
//        return $pdf->stream('utilityPBIGR-laporan.pdf');

    }

    public function isiLaporan($periode, $kodeigr){
        $data = DB::connection(Session::get('connection'))->select("SELECT prs_namaperusahaan,
                                           prs_namacabang,
                                           thp_prdcd,
                                           prc_pluidm,
                                           prd_deskripsipanjang,
                                           NVL (kphold, 0) kphold,
                                           NVL (minold, 0) minold,
                                           kph.ksl_mean kph1,
                                           (kph.ksl_mean * 3) kph3,
                                           (kph.ksl_mean * 4) kph4,
                                           case when nvl(kph.minor, 0) <> 0 then kph.minor else to_number(minorder_omi, 9999 ) end minor,
                                           prd_kodetag,
                                           prc_kodetag,
                                           prd_frac,
                                           case when nvl(thp_sl_mplusi, 0) <> 0 then thp_sl_mplusi else thp_sl_mpluso end thp_sl_mplusi,
                                           NVL (mplusiex, 0) mplusiex,
                                           NVL (ROUND (minold / prd_frac, 2), 0) minfracold,
                                           NVL (ROUND (case when nvl(kph.minor, 0) <> 0 then kph.minor else to_number(minorder_omi, 99999 ) end / prd_frac, 2), 0) minfrac,
                                           CASE
                                              WHEN NVL (ROUND (minold / prd_frac, 2), 0) <
                                                      NVL (ROUND (case when nvl(kph.minor, 0) <> 0 then kph.minor else to_number(minorder_omi, 99999 ) end / prd_frac, 2), 0)
                                              THEN
                                                 'NAIK'
                                              ELSE
                                                 CASE
                                                    WHEN NVL (ROUND (minold / prd_frac, 2), 0) >
                                                            NVL (ROUND (case when nvl(kph.minor, 0) <> 0 then kph.minor else to_number(minorder_omi, 99999 ) end / prd_frac, 2), 0)
                                                    THEN
                                                       'TURUN'
                                                    ELSE
                                                       'TETAP'
                                                 END
                                           END
                                              minfracket,
                                           case when nvl(thp_n_mplusi, 0) <> 0 then thp_n_mplusi else thp_n_mpluso end thp_n_mplusi,
                                           NVL (pkmp_mplusi, 0) mplusnow,
                                           thp_mplusi,
                                           CASE
                                              WHEN prdcdb IS NOT NULL AND prdcdc IS NOT NULL
                                              THEN
                                                 'FRAC-BULKY'
                                              ELSE
                                                 CASE
                                                    WHEN prdcdb IS NOT NULL AND prdcdc IS NULL
                                                    THEN
                                                       'BULKY'
                                                    ELSE
                                                       CASE
                                                          WHEN prdcdb IS NULL AND prdcdc IS NOT NULL THEN 'FRAC'
                                                          ELSE ''
                                                       END
                                                 END
                                           END
                                              keterangan,
                                           THP_AVGPB_OMI,
                                           thp_n_mpluso,
                                           THP_MPLUSO,
                                           NVL (mplusoex, 0) mplusoex
                                      FROM tbtr_hitung_pb,
                                           tbmaster_prodcrm,
                                           (select prc_pluigr prcplu, prc_minorder minorder_omi from tbmaster_prodcrm where prc_group = 'O') prcomi,
                                           tbmaster_prodmast,
                                           ((SELECT pid,
                                                    prdcd pluold,
                                                    NVL (ksl_mean, 0) kphold,
                                                    NVL (minor, 0) minold
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
                                              WHERE rn = 2)) kphold,
                                           ((SELECT pid,
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
                                              WHERE rn = 1)) kph,
                                           (SELECT DISTINCT lks_prdcd prdcdB
                                              FROM tbmaster_lokasi
                                             WHERE lks_noid LIKE '%B') lokB,
                                           (SELECT DISTINCT lks_prdcd prdcdC
                                              FROM tbmaster_lokasi
                                             WHERE lks_noid NOT LIKE '%B') lokC,
                                           (SELECT thp_prdcd prdcdex, thp_mplusi mplusiex
                                              FROM tbtr_hitung_pb
                                             WHERE thp_periode = (SELECT thp_periode
                                                                    FROM (  SELECT DISTINCT thp_periode
                                                                              FROM tbtr_hitung_pb
                                                                             WHERE thp_periode <  '$periode'
                                                                          ORDER BY thp_periode DESC) aa
                                                                   WHERE ROWNUM = 1)) mplus2,
                                           (SELECT thp_prdcd prdcdex2, thp_mpluso mplusoex
                                              FROM tbtr_hitung_pb
                                             WHERE thp_periode = (SELECT thp_periode
                                                                    FROM (  SELECT DISTINCT thp_periode
                                                                              FROM tbtr_hitung_pb
                                                                             WHERE thp_periode <  '$periode'
                                                                          ORDER BY thp_periode DESC) aa
                                                                   WHERE ROWNUM = 1)) mplus3,
                                           tbmaster_pkmplus,
                                           tbmaster_perusahaan
                                     WHERE     thp_periode = '$periode'
                                           AND  (NVL (thp_mplusi, 0) <> 0  or  NVL (thp_mpluso, 0) <> 0)
                                           AND prc_pluigr(+) = thp_prdcd
                                           AND prc_group(+) = 'I'
                                           AND prcplu(+) = thp_prdcd
                                           AND prd_prdcd(+) = thp_prdcd
                                           AND pluold(+) = prc_pluidm
                                           AND prdcdex(+) = thp_prdcd
                                           AND prdcdex2(+) = thp_prdcd
                                           AND kph.prdcd(+) = prc_pluidm
                                           AND pkmp_prdcd(+) = thp_prdcd
                                           AND prs_kodeigr(+) = '$kodeigr'
                                           AND lokb.prdcdB(+) = thp_prdcd
                                           AND lokc.prdcdC(+) = thp_Prdcd
                                            ");

//        dd($data);
        return $data;

    }

}


//and ( prd_kodetag = 'D' or
//    prd_kodetag = 'L' )



/*
 case when nvl(thp_sl_mplusi, 0) <> 0 then thp_sl_mplusi else thp_sl_mpluso end thp_sl_mplusi,
                                   NVL (mplusiex, 0) mplusiex,
                                   NVL (ROUND (minold / prd_frac, 2), 0) minfracold,
                                   NVL (ROUND (case when nvl(kph.minor, 0) <> 0 then kph.minor else to_number(minorder_omi, 99999 ) end / prd_frac, 2), 0) minfrac,
                                   CASE
                                      WHEN NVL (ROUND (minold / prd_frac, 2), 0) <
                                              NVL (ROUND (case when nvl(kph.minor, 0) <> 0 then kph.minor else to_number(minorder_omi, 99999 ) end / prd_frac, 2), 0)
                                      THEN
                                         'NAIK'
                                      ELSE
                                         CASE
                                            WHEN NVL (ROUND (minold / prd_frac, 2), 0) >
                                                    NVL (ROUND (case when nvl(kph.minor, 0) <> 0 then kph.minor else to_number(minorder_omi, 99999 ) end / prd_frac, 2), 0)
                                            THEN
                                               'TURUN'
                                            ELSE
                                               'TETAP'
                                         END
                                   END
                                      minfracket,
                                   case when nvl(thp_n_mplusi, 0) <> 0 then thp_n_mplusi else thp_n_mpluso end thp_n_mplusi,
                                   NVL (pkmp_mplusi, 0) mplusnow,
                                   thp_mplusi,
                                   CASE
                                      WHEN prdcdb IS NOT NULL AND prdcdc IS NOT NULL
                                      THEN
                                         'FRAC-BULKY'
                                      ELSE
                                         CASE
                                            WHEN prdcdb IS NOT NULL AND prdcdc IS NULL
                                            THEN
                                               'BULKY'
                                            ELSE
                                               CASE
                                                  WHEN prdcdb IS NULL AND prdcdc IS NOT NULL THEN 'FRAC'
                                                  ELSE ''
                                               END
                                         END
                                   END
                                      keterangan,



-*-*-*-**-*-*-*-

//        $param = '202002';
//
//        $datas = $this->isiLaporan($param,'22');
////        return view('BACKOFFICE.utilityPBIGR-laporan', compact('datas'));
//
//
//        $dompdf = new PDF();
////        $dompdf->set('isPhpEnabled', TRUE);
//        $data = ['a'=>1];
////        $pdf = PDF::loadview('BACKOFFICE.jefftest',['datas' =>$datas]);
//        $pdf = PDF::loadview('BACKOFFICE.utilityPBIGR-laporan',['datas' =>$datas, 'periode' => $param]);
//        $pdf->output();
//        $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);
//
//        $canvas = $dompdf ->get_canvas();
//        $canvas->page_text(1000, 10, "Page {PAGE_NUM} of {PAGE_COUNT}", null, 10, array(0, 0, 0));
//
//
//
//
//        return $pdf->stream('BACKOFFICE.utilityPBIGR-laporan');
//        return $dompdf->download('laporan.pdf');
-*-*-*-**-*-*-*-
  $data   = DB::connection(Session::get('connection'))->table('tbtr_hitung_pb a')
            ->selectRaw("prs_namaperusahaan,
                                   prs_namacabang,
                                   thp_prdcd,
                                   prc_pluidm,
                                   prd_deskripsipanjang
                                   ")
            ->leftJoin('tbmaster_perusahaan b', 'b.prs_kodeigr', 'a.thp_kodeigr')
            ->leftJoin('tbmaster_prodcrm c','c.prc_pluigr','a.thp_prdcd')
            ->leftJoin('tbmaster_prodmast d','d.prd_prdcd','a.thp_prdcd')
            ->leftJoin('tbmaster_pkmplus e','e.pkmp_prdcd','a.thp_prdcd')
            ->join(DB::connection(Session::get('connection'))->raw(" ((SELECT pid,
                                            prdcd pluold,
                                            NVL (ksl_mean, 0) kphold,
                                            NVL (minor, 0) minold
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
                                      WHERE rn = 2)) kphold"), function ($join){
                $join->on('pluold', '=', 'c.prc_pluidm');
            })
            ->join(DB::connection(Session::get('connection'))->raw("((SELECT pid,
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
                                      WHERE rn = 1)) kph"), function ($join){
                $join->on('prdcd', '=','c.prc_pluidm');
            })
            ->join(DB::connection(Session::get('connection'))->raw("(SELECT DISTINCT lks_prdcd prdcdB
                                      FROM tbmaster_lokasi
                                     WHERE lks_noid LIKE '%B') lokB"), function($join){
                $join->on('prdcdB', '=', 'a.thp_prdcd');
            })
            ->join(DB::connection(Session::get('connection'))->raw("(SELECT DISTINCT lks_prdcd prdcdC
                                      FROM tbmaster_lokasi
                                     WHERE lks_noid NOT LIKE '%B') lokC"), function($join){
                $join->on('prdcdC', '=', 'a.thp_prdcd');
            })
            ->join(DB::connection(Session::get('connection'))->raw("((SELECT thp_prdcd prdcdex, thp_mplusi mplusiex
                                      FROM tbtr_hitung_pb
                                     WHERE thp_periode = (SELECT thp_periode
                                                            FROM (  SELECT DISTINCT thp_periode
                                                                      FROM tbtr_hitung_pb
                                                                     WHERE thp_periode < '$periode;
                                                                  ORDER BY thp_periode DESC) aa
                                                           WHERE ROWNUM = 1)) mplus2"), function($join){
                $join->on('prdcdex', 'a.thp_prdcd');
            })
            ->join(DB::connection(Session::get('connection'))->raw("((SELECT thp_prdcd prdcdex2, thp_mpluso mplusoex
                                      FROM tbtr_hitung_pb
                                     WHERE thp_periode = (SELECT thp_periode
                                                            FROM (  SELECT DISTINCT thp_periode
                                                                      FROM tbtr_hitung_pb
                                                                     WHERE thp_periode < '$periode'
                                                                  ORDER BY thp_periode DESC) aa
                                                           WHERE ROWNUM = 1)) mplus3"), function($join){
                $join->on('prdcdex2','=', 'a.thp_prdcd');
            })
            ->where('a.thp_periode',$periode)
            ->where('b.prs_kodeigr', $kodeigr)
            ->whereRaw('(NVL (a.thp_mplusi, 0) <> 0  or  NVL (a.thp_mpluso, 0) <> 0)')
            ->where('c.prc_group','I')
            ->where('prcplu','a.thp_prdcd')
            ->first();

        $prcomi = DB::connection(Session::get('connection'))->table('tbmaster_prodcrm')->select('prc_pluigr as prcplu', 'prc_minorder as minorder_omi')->where('prc_group', 'O')->get()->toArray();

        $kphold = DB::connection(Session::get('connection'))->select("SELECT pid,
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

        $kph    = DB::connection(Session::get('connection'))->select("SELECT pid,
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

        $lokB   = DB::connection(Session::get('connection'))->table('tbmaster_lokasi')->selectRaw('DISTINCT lks_prdcd prdcdB, lks_noid')->where('lks_noid', 'LIKE', '%B')->get()->toArray();

        $lokC   = DB::connection(Session::get('connection'))->table('tbmaster_lokasi')->selectRaw('DISTINCT lks_prdcd prdcdC, lks_noid')->where('lks_noid', 'NOT LIKE', '%B')->get()->toArray();

        $period = DB::connection(Session::get('connection'))->table('tbtr_hitung_pb')->selectRaw('DISTINCT thp_periode')->where('thp_periode', '<', $periode)->orderByDesc('thp_periode')->first();

        $mplus2 = DB::connection(Session::get('connection'))->table('tbtr_hitung_pb')->select('thp_prdcd as prdcdex', 'thp_mplusi as mplusiex')->where('thp_periode',$period->thp_periode)->get()->toArray();

        $mplus3 = DB::connection(Session::get('connection'))->table('tbtr_hitung_pb')->select('thp_prdcd as prdcdex2', 'thp_mplusi as mplusoex')->where('thp_periode',$period->thp_periode)->get()->toArray();

        $data   = DB::connection(Session::get('connection'))->table('tbtr_hitung_pb a')
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

 * */
