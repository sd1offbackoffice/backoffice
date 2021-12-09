<?php

namespace App\Http\Controllers\FRONTOFFICE;

use App\Http\Controllers\Auth\loginController;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Mockery\Exception;
use PDF;
use Yajra\DataTables\DataTables;

class LaporanEvaluasiSalesMemberController extends Controller
{
    public function index(){
        $outlet = DB::connection($_SESSION['connection'])
            ->table('tbmaster_outlet')
            ->select('out_kodeoutlet','out_namaoutlet')
            ->orderBy('out_kodeoutlet')
            ->get();

        $suboutlet = DB::connection($_SESSION['connection'])
            ->table('tbmaster_suboutlet')
            ->orderBy('sub_kodeoutlet')
            ->orderBy('sub_kodesuboutlet')
            ->get();

        $group = DB::connection($_SESSION['connection'])
            ->table('tbmaster_jenismember')
            ->select('jm_kode','jm_keterangan')
            ->orderBy('jm_kode')
            ->get();

        $segmentasi = DB::connection($_SESSION['connection'])->table('tbmaster_segmentasi')
            ->orderBy('seg_id')
            ->get();

        $monitoringMember = DB::connection($_SESSION['connection'])
            ->table('tbtr_monitoringmember')
            ->select('mem_namamonitoring')
            ->whereNotNull('mem_namamonitoring')
            ->groupBy('mem_namamonitoring')
            ->orderBy('mem_namamonitoring')
            ->get();

        $monitoringPLU = DB::connection($_SESSION['connection'])
            ->table('tbtr_monitoringplu')
            ->select('mpl_kodemonitoring','mpl_namamonitoring')
            ->whereNotNull('mpl_kodemonitoring')
            ->groupBy(['mpl_kodemonitoring','mpl_namamonitoring'])
            ->orderBy('mpl_namamonitoring')
            ->get();

        return view('FRONTOFFICE.laporan-evaluasi-sales-member')
            ->with(compact(['outlet','suboutlet','group','segmentasi','monitoringMember','monitoringPLU']));
    }

    public function viewReport(Request $request){
        $tgl1 = $request->tgl1;
        $tgl2 = $request->tgl2;
        $group = $request->group;
        $outlet = $request->outlet;
        $suboutlet = $request->suboutlet;
        $segmentasi = $request->segmentasi;
        $monitoringMember = $request->monitoringMember;
        $monitoringPLU = $request->monitoringPLU;
        $member = $request->member;
        $sort = $request->sort;

        $whereGroup = '';
        $whereOutlet = '';
        $whereSuboutlet = '';
        $whereSegmentasi = '';
        $whereMonitoringMember = '';
        $whereMonitoringPLU = '';
        $whereMember = '';
        $whereSort = '';

        if($group != 'ALL')
            $whereGroup = " and cus_jenismember = '".$group."'";

        if($segmentasi != 'ALL') {
            $whereSegmentasi = " AND crm_idsegment = '" . $segmentasi . "'";
        }

        if($outlet != 'ALL') {
            $whereOutlet = " AND cus_kodeoutlet = '" . $outlet . "'";
        }
        if($suboutlet != 'ALL') {
            $whereSuboutlet = " AND cus_kodesuboutlet = '" . $suboutlet . "'";
        }

        if($monitoringMember != 'ALL') {
            $whereMonitoringMember = " AND mem_kodemonitoring = '" . $monitoringMember . "'";
        }

        if($monitoringMember != 'ALL') {
            $whereMonitoringPLU = " AND mpl_kodemonitoring   = '" . $monitoringPLU . "'";
        }

        $perusahaan = DB::connection($_SESSION['connection'])
            ->table("tbmaster_perusahaan")
            ->first();

        $query = " SELECT trjd_cus_kodemember,
         SUM (qty) qty,
         SUM (SALES) sales,
         SUM (HPP) hpp,
         SUM (margin) margin,
         SUM (margin_nonpromo) marginnonpromo,
         SUM (sales_nonpromo) salesnonpromo,
         SUM (trjd_nominalamt) salesgross,
         SUM (qty) qty,
         cus_namamember,
         count(distinct tanggal) kunj,
         count(distinct trjd_transactionno) struk
    FROM (SELECT trjd_kodeigr,
                 trjd_transactionno,
                 trjd_create_by,
                 trjd_cashierstation,
                 trjd_transactiondate,
                 trjd_transactiontype,
                 trjd_cus_kodemember,
                 crm_idsegment,
                 trjd_prdcd,
                 TANGGAL,
                 qty,
                 SALES,
                 HPP,
                 margin,
                 margin_nonpromo,
                 sales_nonpromo,
                 trjd_nominalamt,
                 cus_namamember
            FROM (  SELECT trjd_kodeigr,
                           trjd_transactionno,
                           trjd_create_by,
                           trjd_cashierstation,
                           trjd_transactiondate,
                           trjd_transactiontype,
                           trjd_cus_kodemember,
                           crm_idsegment,
                           trjd_prdcd,
                           TANGGAL,
                           ROUND (SUM (qty), 2) qty,
                           ROUND (SUM (SALES), 2) SALES,
                           ROUND (SUM (HPP), 2) HPP,
                           ROUND (SUM (margin), 2) margin,
                           ROUND (SUM (margin_nonpromo), 2) margin_nonpromo,
                           ROUND (SUM (sales_nonpromo), 2) sales_nonpromo,
                           sum(trjd_nominalamt) trjd_nominalamt,
                           cus_namamember
                      FROM (  SELECT trjd_kodeigr,
                                     trjd_transactionno,
                                     trjd_create_by,
                                     trjd_cashierstation,
                                     trjd_transactiondate,
                                     trjd_transactiontype,
                                     trjd_cus_kodemember,
                                     sum(trjd_nominalamt) trjd_nominalamt,
                                     CASE
                                        WHEN TKO_KODECUSTOMER IS NOT NULL
                                        THEN
                                           CASE
                                              WHEN TKO_KODESBU = 'O' THEN 9
                                              ELSE 10
                                           END
                                        WHEN TKO_KODECUSTOMER IS NULL
                                        THEN
                                           CASE
                                              WHEN NVL (CUS_FLAGMEMBERKHUSUS, 'T') =
                                                      'Y'
                                              THEN
                                                 CASE
                                                    WHEN NVL (CRM_IDSEGMENT, 7) >=
                                                            7
                                                    THEN
                                                       1
                                                    ELSE
                                                       CRM_IDSEGMENT
                                                 END
                                              ELSE
                                                 CASE
                                                    WHEN NVL (CRM_IDSEGMENT, 1) < 7
                                                    THEN
                                                       7
                                                    ELSE
                                                       CRM_IDSEGMENT
                                                 END
                                           END
                                        ELSE
                                           7
                                     END
                                        AS crm_idsegment,
                                     trjd_prdcd,
                                     TRUNC (TRJD_TRANSACTIONDATE) tanggal,
                                     SUM (
                                          CASE
                                             WHEN prd_unit = 'KG'
                                             THEN
                                                trjd_quantity
                                             ELSE
                                                trjd_quantity * prd_frac
                                          END
                                        * CASE
                                             WHEN trjd_transactiontype = 'R'
                                             THEN
                                                -1
                                             ELSE
                                                1
                                          END)
                                        qty,
                                     SUM (
                                          CASE
                                             WHEN     trjd_flagtax1 = 'Y'
                                                  AND trjd_flagtax2 = 'Y'
                                                  AND tko_kodecustomer IS NULL
                                                  AND NVL (trjd_admfee, 0) = 0
                                             THEN
                                                (trjd_nominalamt / 1.1)
                                             ELSE
                                                CASE
                                                   WHEN TRUNC (tko_tgltutup) <=
                                                           TRUNC (
                                                              trjd_transactiondate)
                                                   THEN
                                                      (trjd_nominalamt / 1.1)
                                                   ELSE
                                                      trjd_nominalamt
                                                END
                                          END
                                        * CASE
                                             WHEN trjd_transactiontype = 'R'
                                             THEN
                                                -1
                                             ELSE
                                                1
                                          END)
                                        SALES,
                                     SUM (
                                          (  CASE
                                                WHEN     trjd_flagtax1 = 'Y'
                                                     AND trjd_flagtax2 = 'Y'
                                                     AND tko_kodecustomer IS NULL
                                                     AND NVL (trjd_admfee, 0) = 0
                                                THEN
                                                   (trjd_nominalamt / 1.1)
                                                ELSE
                                                   CASE
                                                      WHEN TRUNC (tko_tgltutup) <=
                                                              TRUNC (
                                                                 trjd_transactiondate)
                                                      THEN
                                                         (trjd_nominalamt / 1.1)
                                                      ELSE
                                                         trjd_nominalamt
                                                   END
                                             END
                                           - (  trjd_baseprice
                                              * CASE
                                                   WHEN prd_unit = 'KG'
                                                   THEN
                                                      trjd_quantity / prd_frac
                                                   ELSE
                                                      trjd_quantity
                                                END))
                                        * CASE
                                             WHEN trjd_transactiontype = 'R'
                                             THEN
                                                -1
                                             ELSE
                                                1
                                          END)
                                        margin,
                                     SUM (
                                          (trjd_baseprice * trjd_quantity)
                                        * CASE
                                             WHEN trjd_transactiontype = 'R'
                                             THEN
                                                -1
                                             ELSE
                                                1
                                          END)
                                        hpp,
                                     SUM (
                                        CASE
                                           WHEN non_prdcd IS NOT NULL
                                           THEN
                                              (  CASE
                                                    WHEN     trjd_flagtax1 = 'Y'
                                                         AND trjd_flagtax2 = 'Y'
                                                         AND tko_kodecustomer
                                                                IS NULL
                                                         AND NVL (trjd_admfee, 0) =
                                                                0
                                                    THEN
                                                       (trjd_nominalamt / 1.1)
                                                    ELSE
                                                       CASE
                                                          WHEN TRUNC (tko_tgltutup) >=
                                                                  TRUNC (
                                                                     trjd_transactiondate)
                                                          THEN
                                                             (trjd_nominalamt / 1.1)
                                                          ELSE
                                                             trjd_nominalamt
                                                       END
                                                 END
                                               * CASE
                                                    WHEN trjd_transactiontype = 'R'
                                                    THEN
                                                       -1
                                                    ELSE
                                                       1
                                                 END)
                                           ELSE
                                              0
                                        END)
                                        sales_nonpromo,
                                     SUM (
                                        CASE
                                           WHEN non_prdcd IS NOT NULL
                                           THEN
                                              (  (  CASE
                                                       WHEN     trjd_flagtax1 = 'Y'
                                                            AND trjd_flagtax2 = 'Y'
                                                            AND tko_kodecustomer
                                                                   IS NULL
                                                            AND NVL (trjd_admfee,
                                                                     0) = 0
                                                       THEN
                                                          (trjd_nominalamt / 1.1)
                                                       ELSE
                                                          CASE
                                                             WHEN TRUNC (
                                                                     tko_tgltutup) >=
                                                                     TRUNC (
                                                                        trjd_transactiondate)
                                                             THEN
                                                                (  trjd_nominalamt
                                                                 / 1.1)
                                                             ELSE
                                                                trjd_nominalamt
                                                          END
                                                    END
                                                  - (  trjd_baseprice
                                                     * CASE
                                                          WHEN prd_unit = 'KG'
                                                          THEN
                                                               trjd_quantity
                                                             / prd_frac
                                                          ELSE
                                                             trjd_quantity
                                                       END))
                                               * CASE
                                                    WHEN trjd_transactiontype = 'R'
                                                    THEN
                                                       -1
                                                    ELSE
                                                       1
                                                 END)
                                           ELSE
                                              0
                                        END)
                                        margin_nonpromo,
                                        cus_namamember
                                FROM TBTR_JUALDETAIL,
                                     tbmaster_prodmast,
                                     tbmaster_customer,
                                     tbmaster_customercrm,
                                     tbmaster_tokoigr,
                                     tbmaster_plunonpromo,
                                     tbtr_monitoringmember,
                                     tbtr_monitoringplu
                                WHERE TRUNC (trjd_transactiondate) BETWEEN TO_DATE (
                                                                                 '".$tgl1."',
                                                                                 'dd/mm/yyyy')
                                                                          AND TO_DATE (
                                                                                 '".$tgl2."',
                                                                                 'dd/mm/yyyy')
                                     AND prd_kodeigr = trjd_kodeigr
                                     AND prd_prdcd = trjd_prdcd
                                     AND cus_kodeigr(+) = trjd_kodeigr
                                     AND cus_kodemember(+) = trjd_cus_kodemember
                                     AND crm_kodemember(+) = trjd_cus_kodemember
                                     AND tko_kodeigr(+) = trjd_kodeigr
                                     AND tko_kodecustomer(+) = trjd_cus_kodemember
                                     AND non_kodeigr(+) = trjd_kodeigr
                                     AND non_prdcd(+) =
                                            SUBSTR (trjd_prdcd, 1, 6) || '0'
                                     AND trjd_recordid IS NULL
                                     AND trjd_kodeigr = '".$_SESSION['kdigr']."'
                                     ".$whereGroup."
                                     ".$whereSegmentasi."
                                     ".$whereOutlet."
                                     ".$whereSuboutlet."
                                     AND cus_kodemember = mem_kodemember(+)
                                     ".$whereMonitoringMember."
                                     AND trjd_prdcd = mpl_prdcd(+)
                                     ".$whereMonitoringPLU."
                            GROUP BY trjd_kodeigr,
                                     trjd_transactionno,
                                     trjd_create_by,
                                     trjd_cashierstation,
                                     trjd_transactiondate,
                                     trjd_transactiontype,
                                     trjd_cus_kodemember,
                                     cus_namamember,
                                     CASE
                                        WHEN TKO_KODECUSTOMER IS NOT NULL
                                        THEN
                                           CASE
                                              WHEN TKO_KODESBU = 'O' THEN 9
                                              ELSE 10
                                           END
                                        WHEN TKO_KODECUSTOMER IS NULL
                                        THEN
                                           CASE
                                              WHEN NVL (CUS_FLAGMEMBERKHUSUS,
                                                        'T') = 'Y'
                                              THEN
                                                 CASE
                                                    WHEN NVL (CRM_IDSEGMENT, 7) >=
                                                            7
                                                    THEN
                                                       1
                                                    ELSE
                                                       CRM_IDSEGMENT
                                                 END
                                              ELSE
                                                 CASE
                                                    WHEN NVL (CRM_IDSEGMENT, 1) <
                                                            7
                                                    THEN
                                                       7
                                                    ELSE
                                                       CRM_IDSEGMENT
                                                 END
                                           END
                                        ELSE
                                           7
                                     END,
                                     trjd_prdcd,
                                     TRUNC (TRJD_TRANSACTIONDATE))
                  GROUP BY trjd_kodeigr,
                           trjd_transactionno,
                           trjd_create_by,
                           trjd_cashierstation,
                           trjd_transactiondate,
                           trjd_transactiontype,
                           trjd_cus_kodemember,
                           crm_idsegment,
                           trjd_prdcd,
                           TANGGAL,
                           cus_namamember) detail)
GROUP BY trjd_cus_kodemember,cus_namamember";

//        return $query;

        $data = DB::connection($_SESSION['connection'])
            ->select($query);

//        dd($data);

        return DataTables::of($data)->make(true);
    }
}
