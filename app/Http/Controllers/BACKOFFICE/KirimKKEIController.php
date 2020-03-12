<?php

namespace App\Http\Controllers\BACKOFFICE;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class KirimKKEIController extends Controller
{
    //

    public function index(){
        $kodeigr = '22';

        $kkei = DB::table('temp_kkei')
            ->select('kke_periode')
            ->whereRaw("nvl(kke_upload,'N') <> 'Y'")
            ->distinct()
            ->orderBy(DB::RAW("to_date(kke_periode,'ddMMyyyy')"),'desc')
            ->get();

        foreach($kkei as $k){
            $k->kke_periode = substr_replace($k->kke_periode, '/', 2, 0);
            $k->kke_periode = substr_replace($k->kke_periode, '/', 5, 0);
        }

        $query1 = DB::table('tbupload_kkei')
            ->select('kki_periode')
            ->distinct()
            ->toSql();

        $query2 = DB::table(DB::RAW('tbtr_pb_d@igrgij'))
            ->join(DB::RAW('tbtr_pb_h@igrgij'),'pbd_nopb','pbh_nopb')
            ->leftJoin(DB::RAW('tbtr_po_h@igrgij'),'pbd_nopo','tpoh_nopo')
            ->select('pbd_nopb','pbh_tglpb','pbd_nopo','tpoh_tglpo','pbh_cab_penerima')
            ->distinct()
            ->toSql();

        $query3 = DB::table(DB::RAW('tbtr_mstran_h@igrgij'))
            ->select('msth_nodoc','msth_tgldoc','msth_nopo','msth_typetrn')
            ->toSql();

        $data = DB::table(DB::RAW('tbdownload_kkei@igrgij'))
            ->join(DB::RAW('('.$query1.')'),'kke_periode','kki_periode')
            ->leftJoin(DB::RAW('('.$query2.')'),'kke_nomorpb','pbd_nopb')
            ->leftJoin(DB::RAW('('.$query3.')'),'pbd_nopo','msth_nopo')
            ->where('pbh_cab_penerima',$kodeigr)
            ->where('msth_typetrn','B')
            ->whereRaw("TO_CHAR (kki_periode, 'yyyyMM') >= TO_CHAR (SYSDATE - 90, 'yyyyMM')")
            ->where('kke_cabang',$kodeigr)
            ->distinct()
            ->limit(10)
            ->get();

//        dd($data);

        return view('BACKOFFICE.kirimKKEI')->with(compact(['kkei','data']));
    }

    public function upload(Request $request){
        $upload = true;

//        $upload = DB::table('temp_kkei')
//            ->whereIn('kke_periode', $request->periode)
//            ->update(['kke_upload' => 'Y']);

//        foreach($request->periode as $p){
//            $c = oci_connect('simsmg', 'simsmg', '192.168.237.190:1521/SIMSMG');
//            $s = oci_parse($c, "BEGIN SP_UPD_KKEI ( :kodeigr,
//                            :periode,
//                            :user,
//                            :status,
//                            :message); END;");
//            oci_bind_by_name($s, ':kodeigr', $kodeigr, 32);
//            oci_bind_by_name($s, ':periode', $p, 32);
//            oci_bind_by_name($s, ':user', $user, 32);
//            oci_bind_by_name($s, ':status', $status, 32);
//            oci_bind_by_name($s, ':message', $message, 32);
//            oci_execute($s);
//        }

        if($upload){
            $status = 'success';
            $message = 'Berhasil';
        }

        return compact(['status','message']);
    }

    public function refresh(){
        $kodeigr = '22';

        $kkei = DB::table('temp_kkei')
            ->select('kke_periode')
            ->whereRaw("nvl(kke_upload,'N') <> 'Y'")
            ->distinct()
            ->orderBy('kke_periode')
            ->get();

        foreach($kkei as $k){
            $k->kke_periode = substr_replace($k->kke_periode, '/', 2, 0);
            $k->kke_periode = substr_replace($k->kke_periode, '/', 5, 0);
        }

        $query1 = DB::table('tbupload_kkei')
            ->select('kki_periode')
            ->distinct()
            ->toSql();

        $query2 = DB::table(DB::RAW('tbtr_pb_d@igrgij'))
            ->join(DB::RAW('tbtr_pb_h@igrgij'),'pbd_nopb','pbh_nopb')
            ->leftJoin(DB::RAW('tbtr_po_h@igrgij'),'pbd_nopo','tpoh_nopo')
            ->select('pbd_nopb','pbh_tglpb','pbd_nopo','tpoh_tglpo','pbh_cab_penerima')
            ->distinct()
            ->toSql();

        $query3 = DB::table(DB::RAW('tbtr_mstran_h@igrgij'))
            ->select('msth_nodoc','msth_tgldoc','msth_nopo','msth_typetrn')
            ->toSql();

        $data = DB::table(DB::RAW('tbdownload_kkei@igrgij'))
            ->join(DB::RAW('('.$query1.')'),'kke_periode','kki_periode')
            ->leftJoin(DB::RAW('('.$query2.')'),'kke_nomorpb','pbd_nopb')
            ->leftJoin(DB::RAW('('.$query3.')'),'pbd_nopo','msth_nopo')
            ->where('pbh_cab_penerima',$kodeigr)
            ->where('msth_typetrn','B')
            ->whereRaw("TO_CHAR (kki_periode, 'yyyyMM') >= TO_CHAR (SYSDATE - 90, 'yyyyMM')")
            ->where('kke_cabang',$kodeigr)
            ->distinct()
            ->limit(10)
            ->get();

        return compact(['kkei','data']);
    }

    public function test(){
//        $subquery2 = DB::table(DB::RAW('tbtr_pb_d@igrgij'))
//            ->join(DB::RAW('tbtr_pb_h@igrgij'),'pbd_nopb','=','pbh_nopb')
//            ->rightJoin(DB::RAW('tbtr_po_h@igrgij'),function($join){
//                $join->on('tpoh_nopo','pbd_nopo');
//            })
//            ->select('pbd_nopb','pbh_tglpb','pbd_nopo','tpoh_tglpo')
//            ->whereRaw('pbh_cab_penerima = '.$kodeigr)
//            ->distinct();

//        $subquery3 = DB::table(DB::RAW('tbtr_mstran_h@igrgij'))
//            ->select('msth_nodoc','msth_tgldoc','msth_nopo')
//            ->where('msth_typetrn','B');

//        $subquery23 = DB::table(DB::raw("({$subquery2->toSql()})"))
//            ->rightJoin(DB::RAW('tbtr_mstran_h@igrgij'),function($join){
//                $join->on('msth_nopo','pbd_nopo');
//            })
//            ->select('pbd_nopb','pbh_tglpb','pbd_nopo','tpoh_tglpo','msth_nodoc','msth_tgldoc','msth_nopo')
//            ->where('msth_typetrn','B');

//        dd($subquery23);

//        $query = DB::table(DB::RAW('tbdownload_kkei@igrgij'))
//            ->join('tbupload_kkei','kke_periode','kki_periode')
//            ->rightJoin(DB::raw("({$subquery23->toSql()})"),function($join){
//                $join->on('pbd_nopo','kke_nomorpb');
//            })
//            ->selectRaw("kke_periode,
//                   TRUNC (kke_create_dt) kke_create_dt,
//                   kke_nomorpb || ' - ' || TO_CHAR (pbh_tglpb, 'dd/MM/yyyy')
//                      kke_nomorpb,
//                   pbd_nopo || ' - ' || TO_CHAR (tpoh_tglpo, 'dd/MM/yyyy')
//                      pbd_nopo,
//                   msth_nodoc || ' - ' || TO_CHAR (msth_tgldoc, 'dd/MM/yyyy')
//                      msth_nodoc")
//            ->whereRaw("TO_CHAR (kki_periode, 'yyyyMM') >= TO_CHAR (SYSDATE - 90, 'yyyyMM')")
//            ->where('kke_cabang',$kodeigr)
//            ->orderBy('kke_periode','desc');
//
//        $q = DB::connection('simkmy')->table(DB::raw("({$query->toSql()})"))->get();
//
//        dd($q);


        //        $subquery2 = DB::table(DB::RAW('tbtr_pb_d@igrgij'))
//            ->join(DB::RAW('tbtr_pb_h@igrgij'),'pbd_nopb','=','pbh_nopb')
//            ->rightJoin(DB::RAW('tbtr_po_h@igrgij'),function($join){
//                $join->on('tpoh_nopo','pbd_nopo');
//            })
//            ->select('pbd_nopb','pbh_tglpb','pbd_nopo','tpoh_tglpo')
//            ->whereRaw('pbh_cab_penerima = '.$kodeigr)
//            ->distinct();

//        dd($subquery2->get());

//        $subquery3 = DB::table(DB::RAW('tbtr_mstran_h@igrgij'))
//            ->select('msth_nodoc','msth_tgldoc','msth_nopo')
//            ->where('msth_typetrn','B');

//        $subquery23 = DB::table(DB::raw("(".$subquery2->toSql().")"))
//            ->rightJoin(DB::RAW('tbtr_mstran_h@igrgij'),function($join){
//                $join->on('msth_nopo','pbd_nopo');
//            })
//            ->select('pbd_nopb','pbh_tglpb','pbd_nopo','tpoh_tglpo','msth_nodoc','msth_tgldoc','msth_nopo')
//            ->where('msth_typetrn','=','B');

//        dd($subquery23);

//        $query = DB::table(DB::RAW('tbdownload_kkei@igrgij'))
//            ->join('tbupload_kkei','kke_periode','kki_periode')
//            ->rightJoin(DB::raw("({$subquery23->toSql()})"),function($join){
//                $join->on('pbd_nopo','kke_nomorpb');
//            })
//            ->selectRaw("kke_periode,
//                   TRUNC (kke_create_dt) kke_create_dt,
//                   kke_nomorpb || ' - ' || TO_CHAR (pbh_tglpb, 'dd/MM/yyyy')
//                      kke_nomorpb,
//                   pbd_nopo || ' - ' || TO_CHAR (tpoh_tglpo, 'dd/MM/yyyy')
//                      pbd_nopo,
//                   msth_nodoc || ' - ' || TO_CHAR (msth_tgldoc, 'dd/MM/yyyy')
//                      msth_nodoc")
//            ->whereRaw("TO_CHAR (kki_periode, 'yyyyMM') >= TO_CHAR (SYSDATE - 90, 'yyyyMM')")
//            ->where('kke_cabang',$kodeigr)
//            ->orderBy('kke_periode','desc');
//
//        $q = DB::connection('simkmy')->table(DB::raw("({$query->toSql()})"))->get();
//
//        dd($q);

//        $q = DB::select("SELECT DISTINCT
//                   kke_periode,
//                   TRUNC (kke_create_dt) kke_create_dt,
//                   kke_nomorpb || ' - ' || TO_CHAR (pbh_tglpb, 'dd/MM/yyyy')
//                      kke_nomorpb,
//                   pbd_nopo || ' - ' || TO_CHAR (tpoh_tglpo, 'dd/MM/yyyy')
//                      pbd_nopo,
//                   msth_nodoc || ' - ' || TO_CHAR (msth_tgldoc, 'dd/MM/yyyy')
//                      msth_nodoc
//              FROM tbdownload_kkei@igrgij,
//                   (SELECT DISTINCT kki_periode FROM tbupload_kkei),
//                   (SELECT DISTINCT pbd_nopb,
//                                    pbh_tglpb,
//                                    pbd_nopo,
//                                    tpoh_tglpo
//                      FROM tbtr_pb_d@igrgij, tbtr_pb_h@igrgij, tbtr_po_h@igrgij
//                     WHERE     pbd_nopb = pbh_nopb
//                           AND pbh_cab_penerima = '22'
//                           AND tpoh_nopo(+) = pbd_nopo),
//                   (SELECT msth_nodoc, msth_tgldoc, msth_nopo
//                      FROM tbtr_mstran_h@igrgij
//                     WHERE msth_typetrn = 'B')
//             WHERE     TO_CHAR (kki_periode, 'yyyyMM') >=
//                          TO_CHAR (SYSDATE - 90, 'yyyyMM')
//                   AND kke_periode = kki_periode
//                   AND kke_cabang = '22'
//                   AND pbd_nopb(+) = kke_nomorpb
//                   AND msth_nopo(+) = pbd_nopo
//          ORDER BY kke_periode DESC");

//        dd($q);


//        $qq = DB::select("SELECT DISTINCT
//                                     kke_periode,
//                                     TRUNC (kke_create_dt) kke_create_dt,
//                                     kke_nomorpb || ' - ' || TO_CHAR (pbh_tglpb, 'dd/MM/yyyy') kke_nomorpb,
//                                     pbd_nopo || ' - ' || TO_CHAR (tpoh_tglpo, 'dd/MM/yyyy') pbd_nopo,
//                                     msth_nodoc || ' - ' || TO_CHAR (msth_tgldoc, 'dd/MM/yyyy') msth_nodoc
//                                FROM tbdownload_kkei@igrgij
//                                     JOIN (SELECT DISTINCT kki_periode FROM tbupload_kkei)
        //                                        ON kke_periode = kki_periode
        //                                     LEFT JOIN (QUERY1 SELECT DISTINCT pbd_nopb,
//                                                                pbh_tglpb,
//                                                                pbd_nopo,
//                                                                tpoh_tglpo
//                                                  FROM tbtr_pb_d@igrgij
//                                                       JOIN tbtr_pb_h@igrgij ON pbd_nopb = pbh_nopb
//                                                       LEFT JOIN tbtr_po_h@igrgij ON pbd_nopo = tpoh_nopo
//                                                 WHERE pbh_cab_penerima = :KODEIGR)
//                                        ON kke_nomorpb = pbd_nopb
//                                     LEFT JOIN (SELECT msth_nodoc, msth_tgldoc, msth_nopo
//                                                  FROM tbtr_mstran_h@igrgij
//                                                 WHERE msth_typetrn = 'B')
//                                        ON pbd_nopo = msth_nopo
//                               WHERE TO_CHAR (kki_periode, 'yyyyMM') >=
//                                    TO_CHAR (SYSDATE - 90, 'yyyyMM')
//                                    AND kke_cabang = '22'
//                            ORDER BY kke_periode DESC");
    }

}
