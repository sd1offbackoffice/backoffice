<?php

namespace App\Http\Controllers\BACKOFFICE;

use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller; use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;
use PDF;
use Yajra\DataTables\DataTables;

class KertasKerjaStatusController extends Controller
{
    public function index(){
        return view('BACKOFFICE.KERTASKERJASTATUS.kertas-kerja-status');
    }

    public function getLovKodeRak(){
        $data = DB::connection(Session::get('connection'))->select("SELECT DISTINCT lks_koderak koderak
                FROM tbmaster_lokasi
                WHERE (lks_koderak LIKE 'R%' OR lks_koderak LIKE 'O%')
                AND lks_jenisrak IN ('D','N')
                ORDER BY replace(lks_koderak,'O','Z')");

        return DataTables::of($data)->make(true);
    }

    public function print(Request $request){
        $periode = $request->periode;
        $koderak = $request->koderak;
        $rowsb = $request->rowsb;
        $rowsk = $request->rowsk;

        $perusahaan = DB::connection(Session::get('connection'))->table("tbmaster_perusahaan")->first();

        $data = DB::connection(Session::get('connection'))->select("SELECT LKS_KODERAK RAK, LKS_KODESUBRAK SR, LKS_TIPERAK TR,
         LKS_SHELVINGRAK SH, LKS_NOURUT NU, PRD_KODEDIVISI DIV, PRD_KODEDEPARTEMENT DEP,
         PRD_KODEKATEGORIBARANG KAT, LKS_PRDCD PLU, PRD_DESKRIPSIPENDEK DESKRIPSI, PRD_KODETAG TAG,
         PRD_FRAC FRAC, SLS_QTYIGR IGR, SLS_QTYOMI OMI, SLS_HARI, HARIIGR, HARIOMI,
         CASE
             WHEN NVL (PRD_MINORDER, 0) = 0
                 THEN PRD_ISIBELI
             ELSE PRD_MINORDER
         END MINOR, MINDISPLAY, LT_LEADTIME LT, SL, PKM_KOEFISIEN KOEF, PKM_PKM PKM, PKM_MPKM MPKM,
         PKMP_QTYMINOR MPLUS, PKM_PKMT PKMT, LKS_MAXDISPLAY MAXDISPLAY,
         MPT_MAXQTY * PRD_FRAC MAXPALLET, PLN_STS, ' ' ADJ_STS,
         CASE
             WHEN PRC_PLUIGR IS NOT NULL
                 THEN 'Y'
         END J_OMI_IDM, PLO_MAXPLANO MAXPLANO_OMI, PLT_MAXPLANO MAXPLANO_TOKO, LKS_MAXPLANO,
         PCO_MIN_PCT MINPCT_OMI, PCT_MIN_PCT MINPCT_TOKO, ROUND (PRD_DIMENSIPANJANG) P,
         ROUND (PRD_DIMENSILEBAR) L, ROUND (PRD_DIMENSITINGGI) T,
         ROUND (PRD_DIMENSIPANJANG) * ROUND (PRD_DIMENSILEBAR) * ROUND (PRD_DIMENSITINGGI) VOLUME,
         TRANSLATE (LKS_KODERAK, 'OD', 'YZ') LKS_KODERAK,
         CASE WHEN tempcpprt > 0 THEN '--V--' ELSE '' END cp_prt
    FROM TBMASTER_LOKASI,
         TBMASTER_PRODMAST,
         (SELECT   LKS_PRDCD MIND_PRDCD,
                   SUM (LKS_TIRKIRIKANAN * LKS_TIRDEPANBELAKANG * LKS_TIRATASBAWAH) MINDISPLAY
              FROM TBMASTER_LOKASI
             WHERE LKS_KODERAK NOT LIKE 'X%'
               AND LKS_KODERAK NOT LIKE 'A%'
               AND LKS_KODERAK NOT LIKE 'G%'
               AND LKS_JENISRAK <> 'S'
          GROUP BY LKS_PRDCD),
         (SELECT HGB_PRDCD LT_PRDCD, SUP_JANGKAWAKTUKIRIMBARANG LT_LEADTIME
            FROM TBMASTER_HARGABELI, TBMASTER_SUPPLIER
           WHERE HGB_TIPE = '2' AND HGB_KODEIGR = SUP_KODEIGR
                 AND HGB_KODESUPPLIER = SUP_KODESUPPLIER),
         TBMASTER_KKPKM,
         TBMASTER_PKMPLUS,
         TBMASTER_MAXPALET,
         TBMASTER_PRODCRM,
         (SELECT   LKS_PRDCD PLO_PRDCD, SUM (LKS_MAXPLANO) PLO_MAXPLANO
              FROM TBMASTER_LOKASI
             WHERE LKS_KODERAK LIKE 'D%' AND LKS_JENISRAK <> 'S'
          GROUP BY LKS_PRDCD),
         (SELECT   LKS_PRDCD PLT_PRDCD, SUM (LKS_MAXPLANO) PLT_MAXPLANO
              FROM TBMASTER_LOKASI
             WHERE (((LKS_KODERAK LIKE 'R%' OR LKS_KODERAK LIKE 'O%')) AND LKS_JENISRAK <> 'S')
                OR LKS_TIPERAK = 'Z'
          GROUP BY LKS_PRDCD),
         (SELECT   LKS_PRDCD PCO_PRDCD, SUM (LKS_MINPCT) PCO_MIN_PCT
              FROM TBMASTER_LOKASI
             WHERE LKS_KODERAK LIKE 'D%' AND LKS_JENISRAK <> 'S'
          GROUP BY LKS_PRDCD),
         (SELECT   LKS_PRDCD PCT_PRDCD, SUM (LKS_MINPCT) PCT_MIN_PCT
              FROM TBMASTER_LOKASI
             WHERE (LKS_KODERAK LIKE 'R%' OR LKS_KODERAK LIKE 'O%') AND LKS_JENISRAK <> 'S'
          GROUP BY LKS_PRDCD),
         (SELECT   SUM (SLS_QTYOMI) SLS_QTYOMI, SUM (SLS_QTYNOMI) SLS_QTYIGR,
                   COUNT (DISTINCT CASE
                              WHEN SLS_QTYOMI + SLS_QTYNOMI > 0
                                  THEN TRUNC (SLS_PERIODE)
                              ELSE NULL
                          END
                         ) SLS_HARI,
                   SUM (CASE
                            WHEN SLS_QTYOMI > 0
                                THEN 1
                            ELSE 0
                        END) HARIOMI, SUM (CASE
                                               WHEN SLS_QTYNOMI > 0
                                                   THEN 1
                                               ELSE 0
                                           END) HARIIGR, SLS_PRDCD
              FROM TBTR_SUMSALES
             WHERE TRUNC (SLS_PERIODE) BETWEEN ADD_MONTHS (TO_DATE ('01' || '".$periode."',
                                                                    'ddmmyyyy'
                                                                   ),
                                                           -3
                                                          )
                                           AND LAST_DAY (ADD_MONTHS (TO_DATE (   '01'
                                                                              || '".$periode."',
                                                                              'ddmmyyyy'
                                                                             ),
                                                                     -1
                                                                    )
                                                        )
          GROUP BY SLS_PRDCD),
         (SELECT PLN_PRDCD, PLN_JENISRAK, PLA_KODERAK,
                 CASE
                     WHEN PLN_JENISRAK = 'D'
                         THEN CASE
                                 WHEN PLA_KODERAK LIKE '%C'
                                     THEN 'SK'
                                 ELSE 'S'
                             END
                     ELSE 'NS'
                 END PLN_STS
            FROM TBMASTER_PLUPLANO, TBMASTER_PLANO
           WHERE PLN_PRDCD = PLA_PRDCD(+) AND PLA_NOURUT(+) = 1),
         (SELECT TPOD_PRDCD,
                 CASE
                     WHEN QTYPO <> 0 AND KUANB <> 0
                         THEN ROUND (KUANB / QTYPO * 100)
                     ELSE 0
                 END SL
            FROM (SELECT   TPOD_PRDCD, SUM (TPOD_QTYPO) QTYPO, SUM (KUANB) KUANB, SUM (KUANA) KUANA
                      FROM (SELECT TPOD_PRDCD, TPOD_QTYPO,
                                   (  NVL (MSTD_QTY, 0)                   --                 + NVL (MSTD_QTYBONUS1, 0)                                    + NVL (MSTD_QTYBONUS2, 0)
                                   ) KUANB,
                                   NVL (MSTD_QTY, 0) KUANA
                              FROM TBTR_PO_D, TBTR_MSTRAN_D, TBMASTER_PRODMAST
                             WHERE TPOD_KODEIGR = '".Session::get('kdigr')."'
                               AND NVL (TPOD_RECORDID, '9') <> '1'
                               AND TRUNC (TPOD_TGLPO)
                                       BETWEEN TRUNC (ADD_MONTHS (TO_DATE ('01' || '".$periode."',
                                                                           'ddmmyyyy'
                                                                          ),
                                                                  -3
                                                                 ),
                                                      'MM'
                                                     )
                                           AND LAST_DAY
                                                      (TRUNC (ADD_MONTHS (TO_DATE (   '01'
                                                                                   || '".$periode."',
                                                                                   'ddmmyyyy'
                                                                                  ),
                                                                          -1
                                                                         )
                                                             )
                                                      )
                               AND MSTD_TYPETRN(+) = 'B'
                               AND MSTD_KODEIGR(+) = TPOD_KODEIGR
                               AND NVL (MSTD_RECORDID(+), '9') <> '1'
                               AND MSTD_PRDCD(+) = TPOD_PRDCD
                               AND MSTD_NOPO(+) = TPOD_NOPO
                               AND MSTD_TGLPO(+) = TPOD_TGLPO
                               AND PRD_KODEIGR(+) = TPOD_KODEIGR
                               AND NVL (PRD_RECORDID(+), '9') <> '1'
                               AND PRD_PRDCD(+) = TPOD_PRDCD)
                  GROUP BY TPOD_PRDCD)),
                  (SELECT count(1) tempcpprt, mpl_prdcd
        FROM tbtr_monitoringplu
        WHERE mpl_kodemonitoring IN('SM','SJMF','SJMNF','SPVF','SPVNF','SPVGMS')
        group by mpl_prdcd)
   WHERE LKS_KODEIGR = '".Session::get('kdigr')."'
     AND LKS_PRDCD = PRD_PRDCD
     AND LKS_PRDCD = MIND_PRDCD(+)
     AND LKS_PRDCD = LT_PRDCD(+)
     AND LKS_PRDCD = PKM_PRDCD(+)
     AND LKS_PRDCD = PKMP_PRDCD(+)
     AND LKS_PRDCD = MPT_PRDCD(+)
     AND LKS_PRDCD = PRC_PLUIGR(+)
     AND LKS_PRDCD = PLO_PRDCD(+)
     AND LKS_PRDCD = PLT_PRDCD(+)
     AND LKS_PRDCD = PCO_PRDCD(+)
     AND LKS_PRDCD = PCT_PRDCD(+)
     AND LKS_PRDCD = SLS_PRDCD(+)
     AND LKS_PRDCD = PLN_PRDCD(+)
     AND LKS_PRDCD = TPOD_PRDCD(+)
     AND LKS_PRDCD = MPL_PRDCD(+)
     --AND (LKS_KODERAK LIKE 'R%' OR LKS_KODERAK LIKE 'O%')
     AND LKS_JENISRAK IN ('D', 'N')
     AND (   (LKS_KODERAK LIKE 'R%' OR LKS_KODERAK LIKE 'O%')
          OR (    LKS_KODERAK LIKE 'D%'
              AND EXISTS (
                        SELECT 1
                          FROM TBMASTER_PRODMAST, TBMASTER_PRODCRM
                         WHERE PRD_PRDCD = PRC_PLUIGR AND PRD_FLAGIDM = 'Y'
                               AND LKS_PRDCD = PRD_PRDCD)
             )
         )
AND lks_koderak = '".$koderak."'
ORDER BY TRANSLATE (RAK, 'OD', 'YZ'), SR, TR, SH, NU");

//        dd($data);



    }
}
