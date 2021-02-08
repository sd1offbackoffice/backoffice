<?php

namespace App\Http\Controllers\BACKOFFICE\PKM;

use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
        $data = DB::select("SELECT prd_deskripsipanjang deskripsi, PLN_prdcd plu
            FROM TBMASTER_BARANGBARU, TBMASTER_PRODMAST
            WHERE PLN_PRDCD = PRD_PRDCD (+)
            ORDER BY deskripsi");

        return DataTables::of($data)->make(true);
    }

    public function getData(Request $request){
        $plu = DB::table('tbmaster_barangbaru')
            ->select('pln_prdcd')
            ->whereBetween('pln_prdcd',[$request->prdcd1, $request->prdcd2])
            ->orderBy('pln_prdcd','asc')
            ->get();

        if(count($plu) == 0){
            return [
                'status' => 'error',
                'title' => 'Tidak ada data yang diproses!'
            ];
        }

//        $recs = DB::select("SELECT PLN_PRDCD, PLN_TGLAKTIF, PRD_TGLDAFTAR
//                  FROM TBMASTER_BARANGBARU, TBMASTER_PRODMAST
//                  WHERE PLN_PRDCD = PRD_PRDCD(+)");
//
//        foreach($recs as $rec){
//            if($rec->pln_tglaktif == null){
//                DB::table('tbmaster_barangbaru')
//                    ->where('pln_prdcd','=',$rec->pln_prdcd)
//                    ->update([
//                        'pln_tglaktif' => $rec->prd_tgldaftar
//                    ]);
//            }
//        }
//
//        $recs = DB::select("SELECT PLN_PRDCD, PLN_TGLBPB, TGLBPB
//                  FROM TBMASTER_BARANGBARU,
//                       (SELECT   MSTD_PRDCD PLU, MIN (MSTD_TGLDOC) TGLBPB
//                            FROM TBTR_MSTRAN_D
//                           WHERE NVL (MSTD_RECORDID, 'zz') = 'zz' AND MSTD_TYPETRN = 'B'
//                        GROUP BY MSTD_PRDCD)
//                 WHERE PLN_PRDCD = PLU(+)");
//
//        foreach($recs as $rec){
//            if($rec->pln_tglbpb == null){
//                DB::table('tbmaster_barangbaru')
//                    ->where('pln_prdcd','=',$rec->pln_prdcd)
//                    ->update([
//                        'pln_tglbpb' => $rec->tglbpb
//                    ]);
//            }
//        }

        $data = DB::select("SELECT DISTINCT PLN_PRDCD FMKPLU, TO_CHAR(PRD_TGLDAFTAR, 'DD/MM/YYYY') FMTGLD, TO_CHAR(PLN_TGLBPB, 'DD/MM/YYYY') TGLBPB,
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

    public function deleteData(Request $request){
        try{
            DB::beginTransaction();

            DB::table('tbmaster_barangbaru')
                ->where('pln_prdcd','=',$request->plu)
                ->delete();

            DB::commit();

            return [
                'status' => 'success',
                'title' => 'Berhasil menghapus PLU '.$request->plu.' !'
            ];
        }
        catch (QueryException $e){
            DB::rollBack();

            return [
                'status' => 'error',
                'title' => 'Gagal menghapus PLU '.$request->plu.' !'
            ];
        }
    }
}