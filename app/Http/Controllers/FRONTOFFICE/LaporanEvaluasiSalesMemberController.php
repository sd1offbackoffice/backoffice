<?php

namespace App\Http\Controllers\FRONTOFFICE;

use App\Http\Controllers\Auth\loginController;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Mockery\Exception;
use PDF;
use Yajra\DataTables\DataTables;

class LaporanEvaluasiSalesMemberController extends Controller
{
    public function index(){
        $outlet = DB::connection(Session::get('connection'))
            ->table('tbmaster_outlet')
            ->select('out_kodeoutlet','out_namaoutlet')
            ->orderBy('out_kodeoutlet')
            ->get();

        $suboutlet = DB::connection(Session::get('connection'))
            ->table('tbmaster_suboutlet')
            ->orderBy('sub_kodeoutlet')
            ->orderBy('sub_kodesuboutlet')
            ->get();

        $group = DB::connection(Session::get('connection'))
            ->table('tbmaster_jenismember')
            ->select('jm_kode','jm_keterangan')
            ->orderBy('jm_kode')
            ->get();

        $segmentasi = DB::connection(Session::get('connection'))->table('tbmaster_segmentasi')
            ->orderBy('seg_id')
            ->get();

        $monitoringMember = DB::connection(Session::get('connection'))
            ->table('tbtr_monitoringmember')
            ->select('mem_namamonitoring')
            ->whereNotNull('mem_namamonitoring')
            ->groupBy('mem_namamonitoring')
            ->orderBy('mem_namamonitoring')
            ->get();

        $monitoringPLU = DB::connection(Session::get('connection'))
            ->table('tbtr_monitoringplu')
            ->select('mpl_kodemonitoring','mpl_namamonitoring')
            ->whereNotNull('mpl_kodemonitoring')
            ->groupBy(['mpl_kodemonitoring','mpl_namamonitoring'])
            ->orderBy('mpl_namamonitoring')
            ->get();

        return view('FRONTOFFICE.laporan-evaluasi-sales-member')
            ->with(compact(['outlet','suboutlet','group','segmentasi','monitoringMember','monitoringPLU']));
    }

    public static function getData($request){
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

        if($monitoringPLU != 'ALL') {
            $whereMonitoringPLU = " AND mpl_kodemonitoring   = '" . $monitoringPLU . "'";
        }

        if($member == 'KHUSUS')
            $whereMember = " AND cus_flagmemberkhusus = 'Y'";
        else if($member == 'BIASA')
            $whereMember = " AND nvl(cus_flagmemberkhusus,'N') <> 'Y'";

        switch($sort){
            case 'NAMAMEMBER' : $whereSort = 'ORDER BY a.cus_namamember';break;
            case 'KUNJUNGAN' : $whereSort = 'ORDER BY a.kunj';break;
            case 'STRUK' : $whereSort = 'ORDER BY a.struk';break;
            case 'PRODUK' : $whereSort = 'ORDER BY a.qty';break;
            case 'SALESNET' : $whereSort = 'ORDER BY a.sales';break;
            case 'SALESGROSS' : $whereSort = 'ORDER BY a.salesgross';break;
            case 'MARGIN' : $whereSort = 'ORDER BY a.margin';break;
            default : $whereSort = 'ORDER BY a.cus_kodemember';break;
        }

//        return DB::connection(Session::get('connection'))
//            ->select(" SELECT trjd_cus_kodemember,
//         SUM (qty) qty,
//         SUM (SALES) sales,
//         SUM (HPP) hpp,
//         SUM (margin) margin,
//         SUM (margin_nonpromo) marginnonpromo,
//         SUM (sales_nonpromo) salesnonpromo,
//         SUM (trjd_nominalamt) salesgross,
//         SUM (qty) qty,
//         cus_namamember,
//         count(distinct tanggal) kunj,
//         count(distinct trjd_transactionno) struk
//    FROM (SELECT trjd_kodeigr,
//                 trjd_transactionno,
//                 trjd_create_by,
//                 trjd_cashierstation,
//                 trjd_transactiondate,
//                 trjd_transactiontype,
//                 trjd_cus_kodemember,
//                 crm_idsegment,
//                 trjd_prdcd,
//                 TANGGAL,
//                 qty,
//                 SALES,
//                 HPP,
//                 margin,
//                 margin_nonpromo,
//                 sales_nonpromo,
//                 trjd_nominalamt,
//                 cus_namamember
//            FROM (  SELECT trjd_kodeigr,
//                           trjd_transactionno,
//                           trjd_create_by,
//                           trjd_cashierstation,
//                           trjd_transactiondate,
//                           trjd_transactiontype,
//                           trjd_cus_kodemember,
//                           crm_idsegment,
//                           trjd_prdcd,
//                           TANGGAL,
//                           ROUND (SUM (qty), 2) qty,
//                           ROUND (SUM (SALES), 2) SALES,
//                           ROUND (SUM (HPP), 2) HPP,
//                           ROUND (SUM (margin), 2) margin,
//                           ROUND (SUM (margin_nonpromo), 2) margin_nonpromo,
//                           ROUND (SUM (sales_nonpromo), 2) sales_nonpromo,
//                           sum(trjd_nominalamt) trjd_nominalamt,
//                           cus_namamember
//                      FROM (  SELECT trjd_kodeigr,
//                                     trjd_transactionno,
//                                     trjd_create_by,
//                                     trjd_cashierstation,
//                                     trjd_transactiondate,
//                                     trjd_transactiontype,
//                                     trjd_cus_kodemember,
//                                     sum(trjd_nominalamt) trjd_nominalamt,
//                                     CASE
//                                        WHEN TKO_KODECUSTOMER IS NOT NULL
//                                        THEN
//                                           CASE
//                                              WHEN TKO_KODESBU = 'O' THEN 9
//                                              ELSE 10
//                                           END
//                                        WHEN TKO_KODECUSTOMER IS NULL
//                                        THEN
//                                           CASE
//                                              WHEN NVL (CUS_FLAGMEMBERKHUSUS, 'T') =
//                                                      'Y'
//                                              THEN
//                                                 CASE
//                                                    WHEN NVL (CRM_IDSEGMENT, 7) >=
//                                                            7
//                                                    THEN
//                                                       1
//                                                    ELSE
//                                                       CRM_IDSEGMENT
//                                                 END
//                                              ELSE
//                                                 CASE
//                                                    WHEN NVL (CRM_IDSEGMENT, 1) < 7
//                                                    THEN
//                                                       7
//                                                    ELSE
//                                                       CRM_IDSEGMENT
//                                                 END
//                                           END
//                                        ELSE
//                                           7
//                                     END
//                                        AS crm_idsegment,
//                                     trjd_prdcd,
//                                     TRUNC (TRJD_TRANSACTIONDATE) tanggal,
//                                     SUM (
//                                          CASE
//                                             WHEN prd_unit = 'KG'
//                                             THEN
//                                                trjd_quantity
//                                             ELSE
//                                                trjd_quantity * prd_frac
//                                          END
//                                        * CASE
//                                             WHEN trjd_transactiontype = 'R'
//                                             THEN
//                                                -1
//                                             ELSE
//                                                1
//                                          END)
//                                        qty,
//                                     SUM (
//                                          CASE
//                                             WHEN     trjd_flagtax1 = 'Y'
//                                                  AND trjd_flagtax2 = 'Y'
//                                                  AND tko_kodecustomer IS NULL
//                                                  AND NVL (trjd_admfee, 0) = 0
//                                             THEN
//                                                (trjd_nominalamt / (1+(nvl(prd_ppn,10)/100)))
//                                             ELSE
//                                                CASE
//                                                   WHEN TRUNC (tko_tgltutup) <=
//                                                           TRUNC (
//                                                              trjd_transactiondate)
//                                                   THEN
//                                                      (trjd_nominalamt / (1+(nvl(prd_ppn,10)/100)))
//                                                   ELSE
//                                                      trjd_nominalamt
//                                                END
//                                          END
//                                        * CASE
//                                             WHEN trjd_transactiontype = 'R'
//                                             THEN
//                                                -1
//                                             ELSE
//                                                1
//                                          END)
//                                        SALES,
//                                     SUM (
//                                          (  CASE
//                                                WHEN     trjd_flagtax1 = 'Y'
//                                                     AND trjd_flagtax2 = 'Y'
//                                                     AND tko_kodecustomer IS NULL
//                                                     AND NVL (trjd_admfee, 0) = 0
//                                                THEN
//                                                   (trjd_nominalamt / (1+(nvl(prd_ppn,10)/100)))
//                                                ELSE
//                                                   CASE
//                                                      WHEN TRUNC (tko_tgltutup) <=
//                                                              TRUNC (
//                                                                 trjd_transactiondate)
//                                                      THEN
//                                                         (trjd_nominalamt / (1+(nvl(prd_ppn,10)/100)))
//                                                      ELSE
//                                                         trjd_nominalamt
//                                                   END
//                                             END
//                                           - (  trjd_baseprice
//                                              * CASE
//                                                   WHEN prd_unit = 'KG'
//                                                   THEN
//                                                      trjd_quantity / prd_frac
//                                                   ELSE
//                                                      trjd_quantity
//                                                END))
//                                        * CASE
//                                             WHEN trjd_transactiontype = 'R'
//                                             THEN
//                                                -1
//                                             ELSE
//                                                1
//                                          END)
//                                        margin,
//                                     SUM (
//                                          (trjd_baseprice * trjd_quantity)
//                                        * CASE
//                                             WHEN trjd_transactiontype = 'R'
//                                             THEN
//                                                -1
//                                             ELSE
//                                                1
//                                          END)
//                                        hpp,
//                                     SUM (
//                                        CASE
//                                           WHEN non_prdcd IS NOT NULL
//                                           THEN
//                                              (  CASE
//                                                    WHEN     trjd_flagtax1 = 'Y'
//                                                         AND trjd_flagtax2 = 'Y'
//                                                         AND tko_kodecustomer
//                                                                IS NULL
//                                                         AND NVL (trjd_admfee, 0) =
//                                                                0
//                                                    THEN
//                                                       (trjd_nominalamt / (1+(nvl(prd_ppn,10)/100)))
//                                                    ELSE
//                                                       CASE
//                                                          WHEN TRUNC (tko_tgltutup) >=
//                                                                  TRUNC (
//                                                                     trjd_transactiondate)
//                                                          THEN
//                                                             (trjd_nominalamt / (1+(nvl(prd_ppn,10)/100)))
//                                                          ELSE
//                                                             trjd_nominalamt
//                                                       END
//                                                 END
//                                               * CASE
//                                                    WHEN trjd_transactiontype = 'R'
//                                                    THEN
//                                                       -1
//                                                    ELSE
//                                                       1
//                                                 END)
//                                           ELSE
//                                              0
//                                        END)
//                                        sales_nonpromo,
//                                     SUM (
//                                        CASE
//                                           WHEN non_prdcd IS NOT NULL
//                                           THEN
//                                              (  (  CASE
//                                                       WHEN     trjd_flagtax1 = 'Y'
//                                                            AND trjd_flagtax2 = 'Y'
//                                                            AND tko_kodecustomer
//                                                                   IS NULL
//                                                            AND NVL (trjd_admfee,
//                                                                     0) = 0
//                                                       THEN
//                                                          (trjd_nominalamt / (1+(nvl(prd_ppn,10)/100)))
//                                                       ELSE
//                                                          CASE
//                                                             WHEN TRUNC (
//                                                                     tko_tgltutup) >=
//                                                                     TRUNC (
//                                                                        trjd_transactiondate)
//                                                             THEN
//                                                                (  trjd_nominalamt
//                                                                 / (1+(nvl(prd_ppn,10)/100)))
//                                                             ELSE
//                                                                trjd_nominalamt
//                                                          END
//                                                    END
//                                                  - (  trjd_baseprice
//                                                     * CASE
//                                                          WHEN prd_unit = 'KG'
//                                                          THEN
//                                                               trjd_quantity
//                                                             / prd_frac
//                                                          ELSE
//                                                             trjd_quantity
//                                                       END))
//                                               * CASE
//                                                    WHEN trjd_transactiontype = 'R'
//                                                    THEN
//                                                       -1
//                                                    ELSE
//                                                       1
//                                                 END)
//                                           ELSE
//                                              0
//                                        END)
//                                        margin_nonpromo,
//                                        cus_namamember
//                                FROM TBTR_JUALDETAIL,
//                                     tbmaster_prodmast,
//                                     tbmaster_customer,
//                                     tbmaster_customercrm,
//                                     tbmaster_tokoigr,
//                                     tbmaster_plunonpromo,
//                                     tbtr_monitoringmember,
//                                     tbtr_monitoringplu
//                                WHERE TRUNC (trjd_transactiondate) BETWEEN TO_DATE (
//                                                                                 '".$tgl1."',
//                                                                                 'dd/mm/yyyy')
//                                                                          AND TO_DATE (
//                                                                                 '".$tgl2."',
//                                                                                 'dd/mm/yyyy')
//                                     AND prd_kodeigr = trjd_kodeigr
//                                     AND prd_prdcd = trjd_prdcd
//                                     AND cus_kodeigr(+) = trjd_kodeigr
//                                     AND cus_kodemember(+) = trjd_cus_kodemember
//                                     AND crm_kodemember(+) = trjd_cus_kodemember
//                                     AND tko_kodeigr(+) = trjd_kodeigr
//                                     AND tko_kodecustomer(+) = trjd_cus_kodemember
//                                     AND non_kodeigr(+) = trjd_kodeigr
//                                     AND non_prdcd(+) =
//                                            SUBSTR (trjd_prdcd, 1, 6) || '0'
//                                     AND trjd_recordid IS NULL
//                                     AND trjd_kodeigr = '".Session::get('kdigr')."'
//                                     ".$whereGroup."
//                                     ".$whereSegmentasi."
//                                     ".$whereOutlet."
//                                     ".$whereSuboutlet."
//                                     AND cus_kodemember = mem_kodemember(+)
//                                     ".$whereMonitoringMember."
//                                     AND trjd_prdcd = mpl_prdcd(+)
//                                     ".$whereMonitoringPLU."
//                            GROUP BY trjd_kodeigr,
//                                     trjd_transactionno,
//                                     trjd_create_by,
//                                     trjd_cashierstation,
//                                     trjd_transactiondate,
//                                     trjd_transactiontype,
//                                     trjd_cus_kodemember,
//                                     cus_namamember,
//                                     CASE
//                                        WHEN TKO_KODECUSTOMER IS NOT NULL
//                                        THEN
//                                           CASE
//                                              WHEN TKO_KODESBU = 'O' THEN 9
//                                              ELSE 10
//                                           END
//                                        WHEN TKO_KODECUSTOMER IS NULL
//                                        THEN
//                                           CASE
//                                              WHEN NVL (CUS_FLAGMEMBERKHUSUS,
//                                                        'T') = 'Y'
//                                              THEN
//                                                 CASE
//                                                    WHEN NVL (CRM_IDSEGMENT, 7) >=
//                                                            7
//                                                    THEN
//                                                       1
//                                                    ELSE
//                                                       CRM_IDSEGMENT
//                                                 END
//                                              ELSE
//                                                 CASE
//                                                    WHEN NVL (CRM_IDSEGMENT, 1) <
//                                                            7
//                                                    THEN
//                                                       7
//                                                    ELSE
//                                                       CRM_IDSEGMENT
//                                                 END
//                                           END
//                                        ELSE
//                                           7
//                                     END,
//                                     trjd_prdcd,
//                                     TRUNC (TRJD_TRANSACTIONDATE))
//                  GROUP BY trjd_kodeigr,
//                           trjd_transactionno,
//                           trjd_create_by,
//                           trjd_cashierstation,
//                           trjd_transactiondate,
//                           trjd_transactiontype,
//                           trjd_cus_kodemember,
//                           crm_idsegment,
//                           trjd_prdcd,
//                           TANGGAL,
//                           cus_namamember) detail)
//GROUP BY trjd_cus_kodemember,cus_namamember
//".$whereSort);

        return DB::connection(Session::get('connection'))
            ->select("select a.*
                            from(
                                select cus_kodemember,cus_namamember,
                                      SUM (
                                        CASE
                                           WHEN prd_unit = 'KG' THEN trjd_quantity
                                           ELSE trjd_quantity * prd_frac
                                        END
                                      * CASE
                                           WHEN trjd_transactiontype = 'R' THEN -1
                                           ELSE 1
                                        END) qty,
                                        SUM (trjd_nominalamt) salesgross,
                                        SUM(CASE WHEN trjd_divisioncode = '5' AND trjd_divisioncode = '39' THEN
                                             trjd_nominalamt
                                          ELSE
                                             CASE WHEN  tko_kodeSBU = 'O' OR tko_kodeSBU = 'I' THEN
                                                trjd_nominalamt
                                             ELSE
                                                trjd_nominalamt-(CASE WHEN trjd_flagtax1 = 'Y' THEN (trjd_nominalamt-(trjd_nominalamt/(1+(nvl(prd_ppn,10)/100)))) ELSE 0 END)
                                             END
                                          END) sales,
                                        SUM (
                                            CASE
                                               WHEN     trjd_flagtax1 = 'Y'
                                                    AND trjd_flagtax2 = 'Y'
                                                    AND tko_kodecustomer IS NULL
                                                    AND NVL (trjd_admfee, 0) = 0
                                               THEN
                                                  (trjd_nominalamt / (1+(nvl(prd_ppn,10)/100)))
                                               ELSE
                                                  CASE
                                                     WHEN TRUNC (tko_tgltutup) <=
                                                             TRUNC (trjd_transactiondate)
                                                     THEN
                                                        (trjd_nominalamt / (1+(nvl(prd_ppn,10)/100)))
                                                     ELSE
                                                        trjd_nominalamt
                                                  END
                                            END
                                          * CASE
                                               WHEN trjd_transactiontype = 'R' THEN -1
                                               ELSE 1
                                            END)
                                          salesxx,
                                          (SUM (trjd_nominalamt) - (SUM (
                                            CASE
                                               WHEN     trjd_flagtax1 = 'Y'
                                                    AND trjd_flagtax2 = 'Y'
                                                    AND tko_kodecustomer IS NULL
                                                    AND NVL (trjd_admfee, 0) = 0
                                               THEN
                                                  (trjd_nominalamt / (1+(nvl(prd_ppn,10)/100)))
                                               ELSE
                                                  CASE
                                                     WHEN TRUNC (tko_tgltutup) <=
                                                             TRUNC (trjd_transactiondate)
                                                     THEN
                                                        (trjd_nominalamt / (1+(nvl(prd_ppn,10)/100)))
                                                     ELSE
                                                        trjd_nominalamt
                                                  END
                                            END
                                          * CASE
                                               WHEN trjd_transactiontype = 'R' THEN -1
                                               ELSE 1
                                            END))) ppnxxx,
                                            sum(CASE WHEN trjd_divisioncode = '5' AND trjd_divisioncode = '39' THEN
                                                 0
                                              ELSE
                                                 CASE WHEN tko_kodeSBU = 'O' OR tko_kodeSBU = 'I' THEN
                                                   CASE WHEN trjd_flagtax1 = 'Y' THEN ((trjd_nominalamt*(1+(nvl(prd_ppn,10)/100)))-trjd_nominalamt) ELSE 0 END
                                                 ELSE
                                                   CASE WHEN trjd_flagtax1 = 'Y' THEN (trjd_nominalamt-(trjd_nominalamt/(1+(nvl(prd_ppn,10)/100)))) ELSE 0 END
                                                 END
                                              END) ppn,
                                          SUM (
                                            (  CASE
                                                  WHEN     trjd_flagtax1 = 'Y'
                                                       AND trjd_flagtax2 = 'Y'
                                                       AND tko_kodecustomer IS NULL
                                                       AND NVL (trjd_admfee, 0) = 0
                                                  THEN
                                                     (trjd_nominalamt / (1+(nvl(prd_ppn,10)/100)))
                                                  ELSE
                                                     CASE
                                                        WHEN TRUNC (tko_tgltutup) <=
                                                                TRUNC (trjd_transactiondate)
                                                        THEN
                                                           (trjd_nominalamt / (1+(nvl(prd_ppn,10)/100)))
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
                                               WHEN trjd_transactiontype = 'R' THEN -1
                                               ELSE 1
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
                                                       (trjd_nominalamt / (1+(nvl(prd_ppn,10)/100)))
                                                    ELSE
                                                       CASE
                                                          WHEN TRUNC (tko_tgltutup) >=
                                                                  TRUNC (
                                                                     trjd_transactiondate)
                                                          THEN
                                                             (trjd_nominalamt / (1+(nvl(prd_ppn,10)/100)))
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
                                                          (trjd_nominalamt / (1+(nvl(prd_ppn,10)/100)))
                                                       ELSE
                                                          CASE
                                                             WHEN TRUNC (
                                                                     tko_tgltutup) >=
                                                                     TRUNC (
                                                                        trjd_transactiondate)
                                                             THEN
                                                                (  trjd_nominalamt
                                                                 / (1+(nvl(prd_ppn,10)/100)))
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
                                        count(distinct cus_kodemember) jumlahmember,
                                        count(distinct trunc(TRJD_TRANSACTIONDATE)) kunj,
                                        count(distinct trjd_transactionno) struk
                                from tbmaster_divisi
                                    inner join tbmaster_prodmast on div_kodedivisi = prd_kodedivisi
                                    inner join tbtr_jualdetail on prd_prdcd = trjd_prdcd
                                    left join tbmaster_tokoigr on tko_kodecustomer= trjd_cus_kodemember
                                    inner join tbmaster_customer on trjd_cus_kodemember = cus_kodemember
                                    left join TBMASTER_CUSTOMERCRM ON crm_kodemember = cus_kodemember
                                    inner join tbmaster_departement on div_kodedivisi = dep_kodedivisi and dep_kodedepartement = prd_kodedepartement
                                    left join tbmaster_plunonpromo on non_kodeigr = trjd_kodeigr and non_prdcd = SUBSTR (trjd_prdcd, 1, 6) || '0'
                                where trunc(trjd_transactiondate) BETWEEN TO_DATE ('".$tgl1."','dd/mm/yyyy') AND TO_DATE ('".$tgl2."','dd/mm/yyyy')
                                ".$whereGroup."
                                ".$whereSegmentasi."
                                ".$whereOutlet."
                                ".$whereSuboutlet."
                                ".$whereMonitoringMember."
                                ".$whereMonitoringPLU."
                                ".$whereMember."
                                group by cus_kodemember,cus_namamember
                                order by cus_namamember,cus_kodemember
                            ) a
                            ".$whereSort);
    }

    public function viewReport(Request $request){
        $perusahaan = DB::connection(Session::get('connection'))
            ->table("tbmaster_perusahaan")
            ->first();

        $data = self::getData($request);

        return DataTables::of($data)->make(true);
    }

    public function print(Request $request){
        $perusahaan = DB::connection(Session::get('connection'))
            ->table("tbmaster_perusahaan")
            ->first();

        $data = self::getData($request);

        $tgl1 = $request->tgl1;
        $tgl2 = $request->tgl2;
        $sort = $request->sort;

        return view('FRONTOFFICE.laporan-evaluasi-sales-member-pdf',compact(['perusahaan','data','tgl1','tgl2','sort']));
    }

    public function getCSV(Request $request){
        $data = self::getData($request);

        $filename = 'LAPORAN EVALUASI SALES MEMBER.csv';

        $columnHeader = [
            'KODE',
            'MEMBER',
            'KUNJ',
            'STRUK',
            'PRODUK',
            'SALES GROSS',
            'SALES NET',
            'PPN',
            'MARGIN',
            '%'
        ];

        $linebuffs = array();
        $kunj = 0;
        $struk = 0;
        $qty = 0;
        $salesgross = 0;
        $salesnet = 0;
        $ppn = 0;
        $margin = 0;

        foreach ($data as $d) {
            $tempdata = [
                $d->cus_kodemember,
                $d->cus_namamember,
                $d->kunj,
                $d->struk,
                number_format($d->qty, 0, '.', ','),
                number_format($d->salesgross, 0, '.', ','),
                number_format($d->sales, 0, '.', ','),
                number_format($d->ppn, 0, '.', ','),
                number_format($d->margin, 0, '.', ','),
                number_format($d->sales == 0 ? 0 : ($d->margin / $d->sales) * 100, 2, '.', ',')
            ];

            array_push($linebuffs, $tempdata);

            $kunj += $d->kunj;
            $struk += $d->struk;
            $qty += $d->qty;
            $salesgross += $d->salesgross;
            $salesnet += $d->sales;
            $ppn += $d->ppn;
            $margin += $d->margin;
        }

        $total = [
            '',
            'TOTAL',
            $kunj,
            $struk,
            number_format($qty, 0, '.', ','),
            number_format($salesgross, 0, '.', ','),
            number_format(ceil($salesnet), 0, '.', ','),
            number_format($ppn, 0, '.', ','),
            number_format($margin, 0, '.', ','),
            number_format($salesnet == 0 ? 0 : ($margin / $salesnet * 100), 2, '.', ',')
        ];

        array_push($linebuffs, $total);

        $headers = [
            "Content-type" => "text/csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $file = fopen(storage_path($filename), 'w');

        fputcsv($file, $columnHeader, '|');
        foreach ($linebuffs as $linebuff) {
            fputcsv($file, $linebuff, '|');
        }
        fclose($file);

        return response()->download(storage_path($filename))->deleteFileAfterSend(true);
    }
}
