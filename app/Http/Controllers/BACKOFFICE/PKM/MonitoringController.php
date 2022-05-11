<?php

namespace App\Http\Controllers\BACKOFFICE\PKM;

use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller; use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;
use PDF;
use Yajra\DataTables\DataTables;
use ZipArchive;
use File;

class MonitoringController extends Controller
{
    public function index(){
        return view('BACKOFFICE.PKM.monitoring');
    }

    public function getLovPrdcd(){
        $data = DB::connection(Session::get('connection'))->select("SELECT prd_deskripsipanjang deskripsi, prd_prdcd plu, prd_frac || '/' || prd_unit satuan
            FROM TBMASTER_PRODMAST
            WHERE prd_prdcd like '%0'
            AND prd_prdcd not in (select pln_prdcd from tbmaster_barangbaru)
            ORDER BY prd_prdcd");

        return DataTables::of($data)->make(true);
    }

    public function getLovPrdcdNew(){
        $data = DB::connection(Session::get('connection'))->select("SELECT prd_deskripsipanjang deskripsi, PLN_prdcd plu
            FROM TBMASTER_BARANGBARU, TBMASTER_PRODMAST
            WHERE PLN_PRDCD = PRD_PRDCD (+)
            ORDER BY deskripsi");

        return DataTables::of($data)->make(true);
    }

    public function getData(Request $request){
        $plu = DB::connection(Session::get('connection'))->table('tbmaster_barangbaru')
            ->select('pln_prdcd')
            ->whereBetween('pln_prdcd',[$request->prdcd1, $request->prdcd2])
            ->orderBy('pln_create_dt','asc')
            ->orderBy('pln_prdcd','asc')
            ->get();

        if(count($plu) == 0){
            return [
                'status' => 'error',
                'title' => 'Tidak ada data yang diproses!'
            ];
        }

//        $recs = DB::connection(Session::get('connection'))->select("SELECT PLN_PRDCD, PLN_TGLAKTIF, PRD_TGLDAFTAR
//                  FROM TBMASTER_BARANGBARU, TBMASTER_PRODMAST
//                  WHERE PLN_PRDCD = PRD_PRDCD(+)");
//
//        foreach($recs as $rec){
//            if($rec->pln_tglaktif == null){
//                DB::connection(Session::get('connection'))->table('tbmaster_barangbaru')
//                    ->where('pln_prdcd','=',$rec->pln_prdcd)
//                    ->update([
//                        'pln_tglaktif' => $rec->prd_tgldaftar
//                    ]);
//            }
//        }
//
//        $recs = DB::connection(Session::get('connection'))->select("SELECT PLN_PRDCD, PLN_TGLBPB, TGLBPB
//                  FROM TBMASTER_BARANGBARU,
//                       (SELECT   MSTD_PRDCD PLU, MIN (MSTD_TGLDOC) TGLBPB
//                            FROM TBTR_MSTRAN_D
//                           WHERE NVL (MSTD_RECORDID, 'zz') = 'zz' AND MSTD_TYPETRN = 'B'
//                        GROUP BY MSTD_PRDCD)
//                 WHERE PLN_PRDCD = PLU(+)");
//
//        foreach($recs as $rec){
//            if($rec->pln_tglbpb == null){
//                DB::connection(Session::get('connection'))->table('tbmaster_barangbaru')
//                    ->where('pln_prdcd','=',$rec->pln_prdcd)
//                    ->update([
//                        'pln_tglbpb' => $rec->tglbpb
//                    ]);
//            }
//        }

        $data = DB::connection(Session::get('connection'))->select("SELECT DISTINCT PLN_PRDCD FMKPLU, TO_CHAR(PRD_TGLDAFTAR, 'DD/MM/YYYY') FMTGLD, TO_CHAR(PLN_TGLBPB, 'DD/MM/YYYY') TGLBPB,
                CASE
                    WHEN NVL(PLN_PKMT, 0) = 0
                        THEN CASE
                                WHEN PKM_PKMT IS NOT NULL
                                    THEN PKM_PKMT
                            END
                    ELSE PLN_PKMT
                END FMPKMT,
                pkm_pkmt,
                CASE
                    WHEN PRD_FLAGGUDANG = 'Y'
                        THEN CASE
                                WHEN MIN_MINORDER IS NOT NULL
                                    THEN TO_NUMBER (MIN_MINORDER)
                                WHEN PRD_MINORDER IS NOT NULL
                                    THEN PRD_MINORDER
                                ELSE PRD_ISIBELI
                            END
                    ELSE CASE
                    WHEN PRD_MINORDER IS NOT NULL
                        THEN PRD_MINORDER
                    ELSE PRD_ISIBELI
                END
                END MINOR,
                CASE
                    WHEN PLN_PRDCD IN (SELECT PRC_PLUIGR
                                         FROM TBMASTER_PRODCRM)
                        THEN 'Y'
                    ELSE 'T'
                END FOMI, PRD_DESKRIPSIPANJANG, PRD_KODETAG,
                PRD_UNIT || '/' || PRD_FRAC PRD_SATUAN, PRD_FLAGGUDANG FLAG,
                '1' FLAGREC
           FROM TBMASTER_BARANGBARU, TBMASTER_PRODMAST, TBMASTER_MINIMUMORDER, TBMASTER_KKPKM
          WHERE PLN_PRDCD = PRD_PRDCD
            AND MIN_PRDCD(+) = PRD_PRDCD
            AND PLN_PRDCD = PKM_PRDCD(+)
            AND NVL (PRD_KODETAG, '_') NOT IN ('X', 'N', 'O', 'H')
            AND PLN_PRDCD BETWEEN '".$request->prdcd1."' AND '".$request->prdcd2."'
            ORDER BY PLN_PRDCD ASC");

        return DataTables::of($data)->make(true);
    }

    public function getDataAdded(Request $request){
        $plu = $request->plu;

        try{
            $data = new \stdClass();

            $temp = DB::connection(Session::get('connection'))->table('tbmaster_kkpkm')
                ->select("pkm_pkmt")
                ->where('pkm_kodeigr','=',Session::get('kdigr'))
                ->where('pkm_prdcd','=',$plu)
                ->first();

            if($temp){
                $data->pkmt = $temp->pkm_pkmt;
            }
            else{
                $data->pkmt = 0;
            }

            $temp = DB::connection(Session::get('connection'))->select("SELECT TO_CHAR(FMTGLD,'dd/mm/yyyy') FMTGLD, TGLBPB, PRD_KODETAG, MINOR, FLAG, FOMI, PRD_DESKRIPSIPANJANG, PRD_SATUAN
                                FROM (SELECT DISTINCT PRD_PRDCD PLU, PRD_TGLDAFTAR FMTGLD, PLN_TGLBPB TGLBPB,
                                        CASE
                                            WHEN NVL (PLN_PKMT, 0) = 0
                                                THEN CASE
                                                        WHEN PKM_PKMT IS NOT NULL
                                                            THEN PKM_PKMT
                                                    END
                                            ELSE PLN_PKMT
                                        END FMPKMT,
                                        CASE
                                            WHEN PRD_FLAGGUDANG = 'Y'
                                                THEN CASE
                                                        WHEN MIN_MINORDER IS NOT NULL
                                                            THEN TO_NUMBER (MIN_MINORDER)
                                                        WHEN PRD_MINORDER IS NOT NULL
                                                            THEN PRD_MINORDER
                                                        ELSE PRD_ISIBELI
                                                    END
                                            ELSE CASE
                                            WHEN PRD_MINORDER IS NOT NULL
                                                THEN PRD_MINORDER
                                            ELSE PRD_ISIBELI
                                        END
                                        END MINOR,
                                        CASE
                                            WHEN PLN_PRDCD IN (SELECT PRC_PLUIGR
                                                                 FROM TBMASTER_PRODCRM)
                                                THEN 'Y'
                                            ELSE 'T'
                                        END FOMI, PRD_DESKRIPSIPANJANG, PRD_KODETAG,
                                        PRD_UNIT || '/' || LPAD (PRD_FRAC, 4, ' ') PRD_SATUAN,
                                        PRD_FLAGGUDANG FLAG, '1' FLAGREC
                                        FROM TBMASTER_BARANGBARU,
                                             TBMASTER_PRODMAST,
                                             TBMASTER_MINIMUMORDER,
                                             TBMASTER_KKPKM
                                        WHERE PLN_PRDCD(+) = PRD_PRDCD AND MIN_PRDCD(+) = PRD_PRDCD
                                        AND PLN_PRDCD = PKM_PRDCD(+))
                          WHERE PLU = '".$plu."'")[0];

            $data->tgldaftar = $temp->fmtgld;
            $data->tglbpb = $temp->tglbpb;
            $data->tag = $temp->prd_kodetag;
            $data->minor = $temp->minor;
            $data->flag = $temp->flag;
            $data->omi = $temp->fomi;

            return response()->json($data);
        }
        catch (QueryException $e){
            abort(500);
        }
    }

    public function addData(Request $request){
        try{
            $temp = DB::connection(Session::get('connection'))->table('tbmaster_barangbaru')
                ->where('pln_prdcd','=',$request->plu)
                ->first();

            if($temp){
                return [
                    'status' => 'error',
                    'title' => 'PLU sudah ada!'
                ];
            }

            DB::connection(Session::get('connection'))->table('tbmaster_barangbaru')
                ->insert([
                    'pln_kodeigr' => Session::get('kdigr'),
                    'pln_prdcd' => $request->plu,
                    'pln_pkmt' => $request->pkmt,
                    'pln_flagtag' => $request->tag,
                    'pln_tglbpb' => DB::connection(Session::get('connection'))->raw("TO_DATE('".$request->tglbpb."', 'dd/mm/yy')"),
                    'pln_tglaktif' => DB::connection(Session::get('connection'))->raw("TO_DATE('".$request->tgldaftar."', 'dd/mm/yy')"),
                    'pln_create_by' => Session::get('usid'),
                    'pln_create_dt' => Carbon::now()
                ]);

            return [
                'status' => 'success',
                'title' => 'Berhasil menambahkan data!'
            ];
        }
        catch (QueryException $e){
            return [
                'status' => 'error',
                'title' => 'Gagal menambahkan data!'
            ];
        }
    }

    public function changePKM(Request $request){
        try{
            $plu = $request->plu;
            $pkmt = $request->pkmt;

            DB::connection(Session::get('connection'))->beginTransaction();

            $temp = DB::connection(Session::get('connection'))->table('tbmaster_kkpkm')
                ->where('pkm_prdcd','=',$plu)
                ->first();

            $date = date_format(Carbon::now(),'mY');

            if(!$temp){
                $data = DB::connection(Session::get('connection'))->table('tbmaster_prodmast')
                    ->select('prd_kodedivisi','prd_kodedepartement','prd_kodekategoribarang')
                    ->where('prd_kodeigr','=',Session::get('kdigr'))
                    ->where('prd_prdcd','=',$plu)
                    ->first();

                DB::connection(Session::get('connection'))->table('tbmaster_kkpkm')
                    ->insert([
                        'PKM_KODEIGR' => Session::get('kdigr'),
                        'PKM_PRDCD' => $plu,
                        'PKM_KODEDIVISI' => $data->prd_kodedivisi,
                        'PKM_KODEDEPARTEMENT' => $data->prd_kodedepartement,
                        'PKM_KODEKATEGORIBARANG' => $data->prd_kodekategoribarang,
                        'PKM_PKMT' => $pkmt,
                        'PKM_PERIODEPROSES' => $date,
                        'PKM_PERIODE1' => $date,
                        'PKM_PERIODE2' => $date,
                        'PKM_PERIODE3' => $date,
                        'PKM_CREATE_BY' => Session::get('usid'),
                        'PKM_CREATE_DT' => Carbon::now()
                    ]);
            }
            else{
                DB::connection(Session::get('connection'))->table('tbmaster_kkpkm')
                    ->where('pkm_prdcd','=',$plu)
                    ->update([
                        'PKM_PKMT' => $pkmt,
                        'PKM_PERIODEPROSES' => $date,
                        'PKM_PERIODE1' => $date,
                        'PKM_PERIODE2' => $date,
                        'PKM_PERIODE3' => $date,
                        'PKM_MODIFY_BY' => Session::get('usid'),
                        'PKM_MODIFY_DT' => Carbon::now()
                    ]);
            }

            DB::connection(Session::get('connection'))->table('tbmaster_barangbaru')
                ->where('pln_kodeigr','=',Session::get('kdigr'))
                ->where('pln_prdcd','=',$plu)
                ->update([
                    'pln_pkmt' => $pkmt
                ]);

            DB::connection(Session::get('connection'))->commit();

            return [
                'status' => 'success',
                'title' => 'Berhasil mengubah nilai PKMT!'
            ];
        }
        catch (QueryException $e){
            DB::connection(Session::get('connection'))->rollBack();

            return [
                'status' => 'error',
                'title' => 'Gagal mengubah nilai PKMT!'
            ];
        }
    }

    public function deleteData(Request $request){
        try{
            DB::connection(Session::get('connection'))->beginTransaction();

            DB::connection(Session::get('connection'))->table('tbmaster_barangbaru')
                ->where('pln_prdcd','=',$request->plu)
                ->delete();

            DB::connection(Session::get('connection'))->commit();

            return [
                'status' => 'success',
                'title' => 'Berhasil menghapus PLU '.$request->plu.' !'
            ];
        }
        catch (QueryException $e){
            DB::connection(Session::get('connection'))->rollBack();

            return [
                'status' => 'error',
                'title' => 'Gagal menghapus PLU '.$request->plu.' !'
            ];
        }
    }

    public function print(Request $request){
        $perusahaan = DB::connection(Session::get('connection'))->table('tbmaster_perusahaan')
            ->first();

        $data = DB::connection(Session::get('connection'))->select("SELECT FMKPLU, DESKRIPSI, FMTGLD, TGLBPB, FMPKMT
                    FROM (SELECT PLN_KODEIGR, PLN_PRDCD FMKPLU, TO_CHAR(PRD_TGLDAFTAR,'DD/MM/YYYY') FMTGLD, TO_CHAR(PLN_TGLBPB,'DD/MM/YYYY') TGLBPB,
                        CASE
                          WHEN NVL (PLN_PKMT, 0) = 0
                            THEN CASE
                              WHEN PKM_PKMT IS NOT NULL
                                THEN PKM_PKMT
                              END
                            ELSE PLN_PKMT
                        END FMPKMT,
                        PRD_DESKRIPSIPANJANG || ' - ' || PRD_UNIT || '/' || PRD_FRAC DESKRIPSI
                        FROM TBMASTER_BARANGBARU, TBMASTER_PRODMAST, TBMASTER_MINIMUMORDER, TBMASTER_KKPKM
                        WHERE PLN_PRDCD = PRD_PRDCD AND MIN_PRDCD(+) = PRD_PRDCD AND PLN_PRDCD = PKM_PRDCD(+))
                    WHERE PLN_KODEIGR = '".Session::get('kdigr')."'
                    AND NVL (FMPKMT, 0) = 0
                    AND FMKPLU BETWEEN '".$request->prdcd1."' AND '".$request->prdcd2."'
                    ORDER BY FMKPLU");

        return view('BACKOFFICE.PKM.monitoring-pdf',compact(['perusahaan','data']));
    }
}
