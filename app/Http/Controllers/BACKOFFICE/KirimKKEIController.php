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
        $kodeigr = '22';

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
            DB::connection(Session::get('connection'))->beginTransaction();

//            $upload = DB::connection(Session::get('connection'))->table('temp_kkei')
//                ->whereIn('kke_periode', $request->periode)
//                ->update(['kke_upload' => 'Y']);
//
//            foreach($request->periode as $p){
//                $c = loginController::getConnectionProcedure();
//                $s = oci_parse($c, "BEGIN SP_UPD_KKEI ( :kodeigr,
//                            :periode,
//                            :user,
//                            :status,
//                            :message); END;");
//                oci_bind_by_name($s, ':kodeigr', $kodeigr, 32);
//                oci_bind_by_name($s, ':periode', $p, 32);
//                oci_bind_by_name($s, ':user', $user, 32);
//                oci_bind_by_name($s, ':status', $status, 32);
//                oci_bind_by_name($s, ':message', $message, 32);
//                oci_execute($s);
//            }

//            if($status == 'TRUE'){
//                DB::connection(Session::get('connection'))->commit();
//
//                return response()->json([
//                    'message' => 'Berhasil upload data KKEI!'
//                ], 200);
//            }
//            else{
//                DB::connection(Session::get('connection'))->rollBack();
//
//                return response()->json([
//                    'message' => $message
//                ], 500);
//            }
        }
        catch (\Exception $e) {
            DB::connection(Session::get('connection'))->rollBack();

            return response()->json([
                'message' => 'Gagal upload data KKEI!'
            ], 500);
        }
    }

    public function refresh(){
        $kodeigr = Session::get('kdigr');

        $kkei = DB::connection(Session::get('connection'))->table('temp_kkei')
            ->select('kke_periode')
            ->whereRaw("nvl(kke_upload,'N') <> 'Y'")
            ->distinct()
            ->orderBy('kke_periode')
            ->get();

        foreach($kkei as $k){
            $k->kke_periode = substr_replace($k->kke_periode, '/', 2, 0);
            $k->kke_periode = substr_replace($k->kke_periode, '/', 5, 0);
        }

        $query1 = DB::connection(Session::get('connection'))->table('tbupload_kkei')
            ->select('kki_periode')
            ->distinct()
            ->toSql();

        $query2 = DB::connection(Session::get('connection'))->table(DB::connection(Session::get('connection'))->raw('tbtr_pb_d@igrgij'))
            ->join(DB::connection(Session::get('connection'))->raw('tbtr_pb_h@igrgij'),'pbd_nopb','pbh_nopb')
            ->leftJoin(DB::connection(Session::get('connection'))->raw('tbtr_po_h@igrgij'),'pbd_nopo','tpoh_nopo')
            ->select('pbd_nopb','pbh_tglpb','pbd_nopo','tpoh_tglpo','pbh_cab_penerima')
            ->distinct()
            ->toSql();

        $query3 = DB::connection(Session::get('connection'))->table(DB::connection(Session::get('connection'))->raw('tbtr_mstran_h@igrgij'))
            ->select('msth_nodoc','msth_tgldoc','msth_nopo','msth_typetrn')
            ->toSql();

        $data = DB::connection(Session::get('connection'))->table(DB::connection(Session::get('connection'))->raw('tbdownload_kkei@igrgij'))
            ->join(DB::connection(Session::get('connection'))->raw('('.$query1.')'),'kke_periode','kki_periode')
            ->leftJoin(DB::connection(Session::get('connection'))->raw('('.$query2.')'),'kke_nomorpb','pbd_nopb')
            ->leftJoin(DB::connection(Session::get('connection'))->raw('('.$query3.')'),'pbd_nopo','msth_nopo')
            ->where('pbh_cab_penerima',$kodeigr)
            ->where('msth_typetrn','B')
            ->whereRaw("TO_CHAR (kki_periode, 'yyyyMM') >= TO_CHAR (SYSDATE - 90, 'yyyyMM')")
            ->where('kke_cabang',$kodeigr)
            ->distinct()
            ->limit(10)
            ->get();

        return compact(['kkei','data']);
    }

}
