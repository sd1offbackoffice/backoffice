<?php

namespace App\Http\Controllers\BACKOFFICE;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class KirimKKEIController extends Controller
{
    //

    public function index(){
//        $qqq = DB::SELECT('SELECT *
//    FROM tbdownload_kkei@igrgij
//         INNER JOIN "TBUPLOAD_KKEI" ON "KKE_PERIODE" = "KKI_PERIODE"
//         RIGHT JOIN
//         (SELECT "PBD_NOPB",
//                 "PBH_TGLPB",
//                 "PBD_NOPO",
//                 "TPOH_TGLPO",
//                 "MSTH_NODOC",
//                 "MSTH_TGLDOC",
//                 "MSTH_NOPO"
//            FROM (SELECT DISTINCT "PBD_NOPB",
//                                  "PBH_TGLPB",
//                                  "PBD_NOPO",
//                                  "TPOH_TGLPO"
//                    FROM tbtr_pb_d@igrgij
//                         INNER JOIN tbtr_pb_h@igrgij ON "PBD_NOPB" = "PBH_NOPB"
//                         RIGHT JOIN tbtr_po_h@igrgij
//                            ON "TPOH_NOPO" = "PBD_NOPO"
//                   WHERE pbh_cab_penerima = 22)
//                 RIGHT JOIN tbtr_mstran_h@igrgij ON "MSTH_NOPO" = "PBD_NOPO"
//           WHERE "MSTH_TYPETRN" = \'B\')
//            ON "PBD_NOPO" = "KKE_NOMORPB"
//   WHERE     TO_CHAR (kki_periode, \'yyyyMM\') >=
//                TO_CHAR (SYSDATE - 90, \'yyyyMM\')
//         AND "KKE_CABANG" = 22
//ORDER BY "KKE_PERIODE" DESC');
//        dd($qqq);
        $kodeigr = '22';

//        $kkei = DB::table('temp_kkei')
//            ->select('kke_periode')
//            ->whereRaw("NVL(kke_upload,'N') <> 'Y'")
//            ->distinct()
//            ->orderBy('kke_periode')
//            ->get();
//
//        foreach($kkei as $k){
//            $k->kke_periode = substr_replace($k->kke_periode, '/', 2, 0);
//            $k->kke_periode = substr_replace($k->kke_periode, '/', 5, 0);
//        }

//        $subquery1 = DB::table('tbupload_kkei')
//            ->select('kki_periode')
//            ->distinct();
//        $q = $query = DB::table(DB::RAW('tbdownload_kkei@igrgij'))
//            ->select("*")
//        ->get();
//        dd($q);

        $subquery2 = DB::table(DB::RAW('tbtr_pb_d@igrgij'))
            ->join(DB::RAW('tbtr_pb_h@igrgij'),'pbd_nopb','=','pbh_nopb')
            ->rightJoin(DB::RAW('tbtr_po_h@igrgij'),function($join){
                $join->on('tpoh_nopo','pbd_nopo');
            })
            ->select('pbd_nopb','pbh_tglpb','pbd_nopo','tpoh_tglpo')
            ->whereRaw('pbh_cab_penerima = '.$kodeigr)
            ->distinct();

//        $subquery3 = DB::table(DB::RAW('tbtr_mstran_h@igrgij'))
//            ->select('msth_nodoc','msth_tgldoc','msth_nopo')
//            ->where('msth_typetrn','B');

        $subquery23 = DB::table(DB::raw("({$subquery2->toSql()})"))
            ->rightJoin(DB::RAW('tbtr_mstran_h@igrgij'),function($join){
                $join->on('msth_nopo','pbd_nopo');
            })
            ->select('pbd_nopb','pbh_tglpb','pbd_nopo','tpoh_tglpo','msth_nodoc','msth_tgldoc','msth_nopo')
            ->where('msth_typetrn','B');

//        dd($subquery23);

        $query = DB::table(DB::RAW('tbdownload_kkei@igrgij'))
            ->join('tbupload_kkei','kke_periode','kki_periode')
            ->rightJoin(DB::raw("({$subquery23->toSql()})"),function($join){
                $join->on('pbd_nopo','kke_nomorpb');
            })
            ->selectRaw("kke_periode, 
                   TRUNC (kke_create_dt) kke_create_dt,
                   kke_nomorpb || ' - ' || TO_CHAR (pbh_tglpb, 'dd/MM/yyyy')
                      kke_nomorpb,
                   pbd_nopo || ' - ' || TO_CHAR (tpoh_tglpo, 'dd/MM/yyyy')
                      pbd_nopo,
                   msth_nodoc || ' - ' || TO_CHAR (msth_tgldoc, 'dd/MM/yyyy')
                      msth_nodoc")
            ->whereRaw("TO_CHAR (kki_periode, 'yyyyMM') >= TO_CHAR (SYSDATE - 90, 'yyyyMM')")
            ->where('kke_cabang',$kodeigr)
            ->orderBy('kke_periode','desc');

        $q = DB::connection('simkmy')->table(DB::raw("({$query->toSql()})"))->get();

        dd($q);

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
//
//        dd($q);



        return view('BACKOFFICE.kirimKKEI')->with(compact(['kkei']));
    }

    public function upload(Request $request){
//        dd($request->periode);
//        DB::table('temp_kkei')
//            ->whereIn('kke_periode',$request->periode)
//            ->update('kke_upload','Y');

        if($upload){
            $status = 'success';
            $message = 'Berhasil';
        }

        return compact(['status','message']);
    }


}
