<?php

namespace App\Http\Controllers\FRONTOFFICE\LAPORANSALESPERDIVDEPKAT;

use App\Http\Controllers\Auth\ResetPasswordController;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;
use PDF;
use Yajra\DataTables\DataTables;
use File;

class LaporanSalesPerDepKatController extends Controller
{
    public function index(Request $request)
    {
        $selected_dep = $request->departemen;
        $group = DB::connection($_SESSION['connection'])->table('tbmaster_jenismember')
            ->orderBy('jm_kode')
            ->get();

        $outlet = DB::connection($_SESSION['connection'])->table('tbmaster_outlet')
            ->orderBy('out_kodeoutlet')
            ->get();

        $suboutlet = DB::connection($_SESSION['connection'])->table('tbmaster_suboutlet')
            ->orderBy('sub_kodeoutlet')
            ->orderBy('sub_kodesuboutlet')
            ->get();

        $segmentasi = DB::connection($_SESSION['connection'])->table('tbmaster_segmentasi')
            ->orderBy('seg_id')
            ->get();

        $divisi = DB::connection($_SESSION['connection'])->table('tbmaster_divisi')
            ->orderBy('div_kodedivisi')
            ->get();

        $departement = DB::connection($_SESSION['connection'])->table('tbmaster_departement')
            ->orderBy('dep_kodedepartement')
            ->get();

        return view('FRONTOFFICE.LAPORANSALESPERDIVDEPKAT.laporan-sales-per-departemen-kategori', compact(['group', 'outlet', 'suboutlet', 'segmentasi','divisi','departement','selected_dep']));
    }

    public function getData(Request $request)
    {
        $member = $request->member;
        $group = $request->group;
        $segmentasi = $request->segmentasi;
        $outlet = $request->outlet;
        $suboutlet = $request->suboutlet;
        $tanggal1 = $request->tanggal1;
        $tanggal2 = $request->tanggal2;


        $p_member = '';
        $p_group = '';
        $p_segmentasi = '';
        $p_outlet = '';
        $p_suboutlet = '';

        if ($member != 'ALL') {
            if ($member == 'Y') {
                $p_member = " AND cus_flagmemberkhusus = '" . $member . "'";
            } else {
                $p_member = " AND cus_flagmemberkhusus is null";
            }
        }
        if ($group != 'ALL') {
            $p_group = " AND cus_jenismember = '" . $group . "'";
        }
        if ($segmentasi != 'ALL') {
            $p_segmentasi = " AND crm_idsegment = '" . $segmentasi . "'";
        }
        if ($outlet != 'ALL') {
            $p_outlet = " AND cus_kodeoutlet = '" . $outlet . "'";
        }
        if ($suboutlet != 'ALL') {
            $p_suboutlet = " AND cus_kodesuboutlet = '" . $suboutlet . "'";
        }

        $dataDivGroup = DB::connection($_SESSION['connection'])
            ->select("select kodedivisi,namadivisi nama,sum(round(margin/sales*100,2)) marginpersen ,sum(qty) qty,sum(sales) sales,sum(margin) margin,sum(jmlmember) jmlmember from (
                                select a.*
                                from(
                                    select div_kodedivisi kodedivisi,div_namadivisi namadivisi,dep_kodedepartement kodedepartement,dep_namadepartement namadepartement,
                                          SUM (
                                            CASE
                                               WHEN prd_unit = 'KG' THEN trjd_quantity
                                               ELSE trjd_quantity * prd_frac
                                            END
                                          * CASE
                                               WHEN trjd_transactiontype = 'R' THEN -1
                                               ELSE 1
                                            END) qty,
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
                                                                                     TRUNC (trjd_transactiondate)
                                                                             THEN
                                                                                (trjd_nominalamt / 1.1)
                                                                             ELSE
                                                                                trjd_nominalamt
                                                                          END
                                                                    END
                                                                  * CASE
                                                                       WHEN trjd_transactiontype = 'R' THEN -1
                                                                       ELSE 1
                                                                    END)
                                                                  sales,
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
                                                                                        TRUNC (trjd_transactiondate)
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
                                                                       WHEN trjd_transactiontype = 'R' THEN -1
                                                                       ELSE 1
                                                                    END)
                                                                  margin,
                                                                  count(distinct cus_kodemember) jmlmember
                                    from tbmaster_divisi
                                        inner join tbmaster_prodmast on div_kodedivisi = prd_kodedivisi
                                        inner join tbtr_jualdetail on prd_prdcd = trjd_prdcd
                                        left join tbmaster_tokoigr on tko_kodecustomer= trjd_cus_kodemember
                                        inner join tbmaster_customer on trjd_cus_kodemember = cus_kodemember
                                        left join TBMASTER_CUSTOMERCRM ON crm_kodemember = cus_kodemember
                                        inner join tbmaster_departement on div_kodedivisi = dep_kodedivisi and dep_kodedepartement = prd_kodedepartement
                                    where trunc(trjd_transactiondate) between to_date('" . $tanggal1 . "','dd/mm/yyyy') and to_date('" . $tanggal2 . "','dd/mm/yyyy')
                                    " . $p_member . "
                                    " . $p_group . "
                                    " . $p_segmentasi . "
                                    " . $p_outlet . "
                                    " . $p_suboutlet . "
                                    group by div_kodedivisi,div_namadivisi,dep_kodedepartement,dep_namadepartement
                                    order by div_kodedivisi,div_namadivisi,dep_kodedepartement,dep_namadepartement
                                ) a
                            )
                            group by kodedivisi,namadivisi
                            order by kodedivisi

        ");

        $dataDiv = DB::connection($_SESSION['connection'])
            ->select("select a.*,round(margin/sales*100,2) marginpersen
                            from(
                                select div_kodedivisi kodedivisi,div_namadivisi namadivisi,dep_kodedepartement kode,dep_namadepartement nama,
                                      SUM (
                                        CASE
                                           WHEN prd_unit = 'KG' THEN trjd_quantity
                                           ELSE trjd_quantity * prd_frac
                                        END
                                      * CASE
                                           WHEN trjd_transactiontype = 'R' THEN -1
                                           ELSE 1
                                        END) qty,
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
                                                                                 TRUNC (trjd_transactiondate)
                                                                         THEN
                                                                            (trjd_nominalamt / 1.1)
                                                                         ELSE
                                                                            trjd_nominalamt
                                                                      END
                                                                END
                                                              * CASE
                                                                   WHEN trjd_transactiontype = 'R' THEN -1
                                                                   ELSE 1
                                                                END)
                                                              sales,
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
                                                                                    TRUNC (trjd_transactiondate)
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
                                                                   WHEN trjd_transactiontype = 'R' THEN -1
                                                                   ELSE 1
                                                                END)
                                                              margin,
                                                              count(distinct cus_kodemember) jmlmember
                                from tbmaster_divisi
                                    inner join tbmaster_prodmast on div_kodedivisi = prd_kodedivisi
                                    inner join tbtr_jualdetail on prd_prdcd = trjd_prdcd
                                    left join tbmaster_tokoigr on tko_kodecustomer= trjd_cus_kodemember
                                    inner join tbmaster_customer on trjd_cus_kodemember = cus_kodemember
                                    left join TBMASTER_CUSTOMERCRM ON crm_kodemember = cus_kodemember
                                    inner join tbmaster_departement on div_kodedivisi = dep_kodedivisi and dep_kodedepartement = prd_kodedepartement
                                where trunc(trjd_transactiondate) between to_date('" . $tanggal1 . "','dd/mm/yyyy') and to_date('" . $tanggal2 . "','dd/mm/yyyy')
                                " . $p_member . "
                                " . $p_group . "
                                " . $p_segmentasi . "
                                " . $p_outlet . "
                                " . $p_suboutlet . "
                                group by div_kodedivisi,div_namadivisi,dep_kodedepartement,dep_namadepartement
                                order by div_kodedivisi,div_namadivisi,dep_kodedepartement,dep_namadepartement
                            ) a
        ");

        $totalsales = 0;
        $totalmargin = 0;
        $totalsalesgroup = 0;
        $totalmargingroup = 0;

        $data = array();
        $childrenData = array();
        for ($i = 0; $i < sizeof($dataDivGroup); $i++) {
            $totalsalesgroup += $dataDivGroup[$i]->sales;
            $totalmargingroup += $dataDivGroup[$i]->margin;
        }
        for ($i = 0; $i < sizeof($dataDiv); $i++) {
            $totalsales += $dataDiv[$i]->sales;
            $totalmargin += $dataDiv[$i]->margin;
        }
        $tempdiv = 0;

        for ($i = 0; $i < sizeof($dataDivGroup); $i++) {
            $dataDivGroup[$i]->constsales = round($dataDivGroup[$i]->sales / $totalsalesgroup * 100, 2);
            $dataDivGroup[$i]->constmargin = round($dataDivGroup[$i]->margin / $totalsalesgroup * 100, 2);
            $dataDivGroup[$i]->children = array();
            for ($j = 0; $j < sizeof($dataDiv); $j++) {
                if ($dataDivGroup[$i]->kodedivisi == $dataDiv[$j]->kodedivisi) {
                    $dataDiv[$j]->constsales = round($dataDiv[$j]->sales / $totalsales * 100, 2);
                    $dataDiv[$j]->constmargin = round($dataDiv[$j]->margin / $totalmargin * 100, 2);
                    array_push($dataDivGroup[$i]->children, $dataDiv[$j]);
                }
            }
            array_push($data, $dataDivGroup[$i]);
        }

        return DataTables::of($data)->make(true);
    }

    public function cetak(Request $request)
    {
        $member = $request->member;
        $group = $request->group;
        $segmentasi = $request->segmentasi;
        $outlet = $request->outlet;
        $suboutlet = $request->suboutlet;
        $tanggal1 = $request->tanggal1;
        $tanggal2 = $request->tanggal2;
        $jenislaporan = $request->jenislaporan;

        $p_member = '';
        $p_group = '';
        $p_segmentasi = '';
        $p_outlet = '';
        $p_suboutlet = '';

        if ($member != 'ALL') {
            if ($member == 'Y') {
                $p_member = " AND cus_flagmemberkhusus = '" . $member . "'";
            } else {
                $p_member = " AND cus_flagmemberkhusus is null";
            }
        }
        if ($group != 'ALL') {
            $p_group = " AND cus_jenismember = '" . $group . "'";
        }
        if ($segmentasi != 'ALL') {
            $p_segmentasi = " AND crm_idsegment = '" . $segmentasi . "'";
        }
        if ($outlet != 'ALL') {
            $p_outlet = " AND cus_kodeoutlet = '" . $outlet . "'";
        }
        if ($suboutlet != 'ALL') {
            $p_suboutlet = " AND cus_kodesuboutlet = '" . $suboutlet . "'";
        }

        $data = DB::connection($_SESSION['connection'])
            ->select("select a.*,round(margin/sales*100,2) marginpersen
                            from(
                                select div_kodedivisi kodedivisi,div_namadivisi namadivisi,dep_kodedepartement kodedepartement,dep_namadepartement namadepartement,
                                      SUM (
                                        CASE
                                           WHEN prd_unit = 'KG' THEN trjd_quantity
                                           ELSE trjd_quantity * prd_frac
                                        END
                                      * CASE
                                           WHEN trjd_transactiontype = 'R' THEN -1
                                           ELSE 1
                                        END) qty,
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
                                                                                 TRUNC (trjd_transactiondate)
                                                                         THEN
                                                                            (trjd_nominalamt / 1.1)
                                                                         ELSE
                                                                            trjd_nominalamt
                                                                      END
                                                                END
                                                              * CASE
                                                                   WHEN trjd_transactiontype = 'R' THEN -1
                                                                   ELSE 1
                                                                END)
                                                              sales,
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
                                                                                    TRUNC (trjd_transactiondate)
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
                                                                   WHEN trjd_transactiontype = 'R' THEN -1
                                                                   ELSE 1
                                                                END)
                                                              margin,
                                                              count(distinct cus_kodemember) jumlahmember
                                from tbmaster_divisi
                                    inner join tbmaster_prodmast on div_kodedivisi = prd_kodedivisi
                                    inner join tbtr_jualdetail on prd_prdcd = trjd_prdcd
                                    left join tbmaster_tokoigr on tko_kodecustomer= trjd_cus_kodemember
                                    inner join tbmaster_customer on trjd_cus_kodemember = cus_kodemember
                                    left join TBMASTER_CUSTOMERCRM ON crm_kodemember = cus_kodemember
                                    inner join tbmaster_departement on div_kodedivisi = dep_kodedivisi and dep_kodedepartement = prd_kodedepartement
                                where trunc(trjd_transactiondate) between to_date('" . $tanggal1 . "','dd/mm/yyyy') and to_date('" . $tanggal2 . "','dd/mm/yyyy')
                                " . $p_member . "
                                " . $p_group . "
                                " . $p_segmentasi . "
                                " . $p_outlet . "
                                " . $p_suboutlet . "
                                group by div_kodedivisi,div_namadivisi,dep_kodedepartement,dep_namadepartement
                                order by div_kodedivisi,div_namadivisi,dep_kodedepartement,dep_namadepartement
                            ) a
        ");
        $filename = 'laporan-sales-per-divisi-departemen';
        $perusahaan = DB::connection($_SESSION['connection'])->table('tbmaster_perusahaan')
            ->first();

        $totalsales = 0;
        $totalmargin = 0;

        for ($i = 0; $i < sizeof($data); $i++) {
            $totalsales += $data[$i]->sales;
            $totalmargin += $data[$i]->margin;
        }

        for ($j = 0; $j < sizeof($data); $j++) {
            $data[$j]->constsales = round($data[$j]->sales / $totalsales * 100, 2);
            $data[$j]->constmargin = round($data[$j]->margin / $totalmargin * 100, 2);
        }

        if ($jenislaporan == 'pdf') {

            return view('FRONTOFFICE.LAPORANSALESPERDIVDEPKAT.' . $filename . '-pdf', compact(['perusahaan', 'data', 'tanggal1', 'tanggal2']));

        } else {

            $filename = $filename . '.csv';
            $columnHeader = [
                'DIVISI',
                'DEPARTEMENT',
                'QTY',
                'SALES',
                'MARGIN',
                'MARGIN %',
                'CONST. SLS',
                'CONST. MRG',
                'JUMLAH MEMBER',
            ];
            $linebuffs = array();
            foreach ($data as $d) {
                $tempdata = [
                    $d->kodedivisi . '-' . $d->namadivisi,
                    $d->kodedepartement . '-' . $d->namadepartement,
                    number_format($d->qty, 0, ".", ","),
                    number_format($d->sales, 0, ".", ","),
                    number_format($d->margin, 0, ".", ","),
                    $d->marginpersen,
                    $d->constsales,
                    $d->constmargin,
                    number_format($d->jumlahmember, 0, ".", ","),
                ];
                array_push($linebuffs, $tempdata);
            }

            $headers = [
                "Content-type" => "text/csv",
                "Pragma" => "no-cache",
                "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
                "Expires" => "0"
            ];
            $file = fopen($filename, 'w');

            fputcsv($file, $columnHeader, '|');
            foreach ($linebuffs as $linebuff) {
                fputcsv($file, $linebuff, '|');
            }
            fclose($file);

            return response()->download(public_path($filename))->deleteFileAfterSend(true);
        }

    }

}
