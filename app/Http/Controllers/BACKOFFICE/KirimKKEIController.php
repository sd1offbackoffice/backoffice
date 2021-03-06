<?php

namespace App\Http\Controllers\BACKOFFICE;

use App\Http\Controllers\Auth\loginController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller; use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class KirimKKEIController extends Controller
{
    //

    public function index(){
        $kodeigr = Session::get('kdigr');

        $kkei = DB::connection(Session::get('connection'))->table('temp_kkei')
            ->select('kke_periode')
            ->whereRaw("nvl(kke_upload,'N') <> 'Y'")
            ->distinct()
            ->orderBy(DB::connection(Session::get('connection'))->raw("to_date(kke_periode,'ddMMyyyy')"),'desc')
            ->get();

        foreach($kkei as $k){
            $k->kke_periode = substr_replace($k->kke_periode, '/', 2, 0);
            $k->kke_periode = substr_replace($k->kke_periode, '/', 5, 0);
        }

        $data = DB::connection(Session::get('connection'))->select("SELECT DISTINCT
                   kke_periode,
                   TRUNC (kke_create_dt) kke_create_dt,
                   kke_nomorpb || ' - ' || TO_CHAR (pbh_tglpb, 'dd/MM/yyyy')
                      kke_nomorpb,
                   pbd_nopo || ' - ' || TO_CHAR (tpoh_tglpo, 'dd/MM/yyyy')
                      pbd_nopo,
                   msth_nodoc || ' - ' || TO_CHAR (msth_tgldoc, 'dd/MM/yyyy')
                      msth_nodoc
              FROM tbdownload_kkei@igrgij,
                   (SELECT DISTINCT kki_periode FROM tbupload_kkei),
                   (SELECT DISTINCT pbd_nopb,
                                    pbh_tglpb,
                                    pbd_nopo,
                                    tpoh_tglpo
                      FROM tbtr_pb_d@igrgij, tbtr_pb_h@igrgij, tbtr_po_h@igrgij
                     WHERE     pbd_nopb = pbh_nopb
                           AND pbh_cab_penerima = '".Session::get('kdigr')."'
                           AND tpoh_nopo(+) = pbd_nopo),
                   (SELECT msth_nodoc, msth_tgldoc, msth_nopo
                      FROM tbtr_mstran_h@igrgij
                     WHERE msth_typetrn = 'B')
             WHERE     TO_CHAR (kki_periode, 'yyyyMM') >=
                          TO_CHAR (SYSDATE - 90, 'yyyyMM')
                   AND kke_periode = kki_periode
                   AND kke_cabang = '".Session::get('kdigr')."'
                   AND pbd_nopb(+) = kke_nomorpb
                   AND msth_nopo(+) = pbd_nopo
          ORDER BY kke_periode DESC");

        return view('BACKOFFICE.kirimKKEI')->with(compact(['kkei','data']));
    }

    public function upload(Request $request){
        try{
            $kodeigr = Session::get('kdigr');
            $p = $request->periode;
            $user = Session::get('usid');

            foreach($request->periode as $p){
                $c = loginController::getConnectionProcedure();
                $s = oci_parse($c, "BEGIN SP_UPD_KKEI_MIGRASI ( :kodeigr,
                            :periode,
                            :user,
                            :status,
                            :message); END;");
                oci_bind_by_name($s, ':kodeigr', $kodeigr, 32);
                oci_bind_by_name($s, ':periode', $p, 32);
                oci_bind_by_name($s, ':user', $user, 32);
                oci_bind_by_name($s, ':status', $status, 32);
                oci_bind_by_name($s, ':message', $message, 255);
                oci_execute($s);
            }

            if($status == 'TRUE'){
                DB::connection(Session::get('connection'))->commit();

                return response()->json([
                    'message' => (__('Berhasil upload data KKEI!'))
                ], 200);
            }
            else{
                DB::connection(Session::get('connection'))->rollBack();

                return response()->json([
                    'message' => $message
                ], 500);
            }
        }
        catch (\Exception $e) {
            DB::connection(Session::get('connection'))->rollBack();

            return response()->json([
                'message' => (__('Gagal upload data KKEI!')),
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
