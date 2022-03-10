<?php

namespace App\Http\Controllers\FRONTOFFICE\LAPORANSALESPERDIVDEPKAT;

use App\Http\Controllers\Auth\ResetPasswordController;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;
use PDF;
use Yajra\DataTables\DataTables;
use File;

class LaporanSalesPerDepKatController extends Controller
{
    public function index(Request $request)
    {
        $selected_dep = isset($request->departemen)?explode('-',$request->departemen)[1]:'';
        $selected_tanggal1 = $request->tanggal1;
        $selected_tanggal2 = $request->tanggal2;

        $group = DB::connection(Session::get('connection'))->table('tbmaster_jenismember')
            ->orderBy('jm_kode')
            ->get();

        $outlet = DB::connection(Session::get('connection'))->table('tbmaster_outlet')
            ->orderBy('out_kodeoutlet')
            ->get();

        $suboutlet = DB::connection(Session::get('connection'))->table('tbmaster_suboutlet')
            ->orderBy('sub_kodeoutlet')
            ->orderBy('sub_kodesuboutlet')
            ->get();

        $segmentasi = DB::connection(Session::get('connection'))->table('tbmaster_segmentasi')
            ->orderBy('seg_id')
            ->get();

        $divisi = DB::connection(Session::get('connection'))->table('tbmaster_divisi')
            ->orderBy('div_kodedivisi')
            ->get();

        $departement = DB::connection(Session::get('connection'))->table('tbmaster_departement')
            ->orderBy('dep_kodedepartement')
            ->get();

        return view('FRONTOFFICE.LAPORANSALESPERDIVDEPKAT.laporan-sales-per-departemen-kategori', compact(['group', 'outlet', 'suboutlet', 'segmentasi','divisi','departement','selected_dep','selected_tanggal1','selected_tanggal2']));
    }
    public function getDataSubOutlet(Request $request)
    {
        $outlet = $request->outlet;
        if($outlet=='ALL'){
            $outlet='';
        }
        $suboutlet = DB::connection(Session::get('connection'))->table('tbmaster_suboutlet')
            ->where("sub_kodeoutlet",'=',$outlet)
            ->orderBy('sub_kodeoutlet')
            ->orderBy('sub_kodesuboutlet')
            ->get();

        return $suboutlet;
    }
    public function getDataDepartement(Request $request)
    {
        $divisi = $request->divisi;
        if($divisi=='ALL'){
            $divisi='';
        }
        $departemen = DB::connection(Session::get('connection'))->table('tbmaster_departement')
            ->where("dep_kodedivisi",'=',$divisi)
            ->orderBy('dep_kodedepartement')
            ->get();

        return $departemen;
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
        $divisi = $request->divisi;
        $departemen = $request->departemen;


        $p_member = '';
        $p_group = '';
        $p_segmentasi = '';
        $p_outlet = '';
        $p_suboutlet = '';
        $p_divisi = '';
        $p_departemen = '';

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
        if ($divisi != 'ALL') {
            $p_divisi = " AND div_kodedivisi = '" . $divisi . "'";
        }
        if ($departemen != 'ALL') {
            $p_departemen = " AND dep_kodedepartement = '" . $departemen . "'";
        }

        $dataDepGroup = DB::connection(Session::get('connection'))
            ->select("select kodedepartement,namadepartement nama,round(sum(margin)/sum(sales)*100,2) marginpersen ,sum(qty) qty,sum(sales) sales,sum(margin) margin,sum(jmlmember) jmlmember from (
                                select a.*
                                from(
                                    select dep_kodedepartement kodedepartement,dep_kodedepartement||'-'||dep_namadepartement namadepartement, kat_kodekategori kodekategori, kat_namakategori namakategori,
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
                                                                          (trjd_nominalamt / 1+(prd_ppn/100))
                                                                       ELSE
                                                                          CASE
                                                                             WHEN TRUNC (tko_tgltutup) <=
                                                                                     TRUNC (trjd_transactiondate)
                                                                             THEN
                                                                                (trjd_nominalamt / 1+(prd_ppn/100))
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
                                                                             (trjd_nominalamt / 1+(prd_ppn/100))
                                                                          ELSE
                                                                             CASE
                                                                                WHEN TRUNC (tko_tgltutup) <=
                                                                                        TRUNC (trjd_transactiondate)
                                                                                THEN
                                                                                   (trjd_nominalamt / 1+(prd_ppn/100))
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
                                        inner join tbmaster_kategori on dep_kodedepartement = kat_kodedepartement and kat_kodekategori = prd_kodekategoribarang
                                    where trunc(trjd_transactiondate) between to_date('" . $tanggal1 . "','dd/mm/yyyy') and to_date('" . $tanggal2 . "','dd/mm/yyyy')
                                    " . $p_member . "
                                    " . $p_group . "
                                    " . $p_segmentasi . "
                                    " . $p_outlet . "
                                    " . $p_suboutlet . "
                                    " . $p_divisi . "
                                    " . $p_departemen . "
                                    group by dep_kodedepartement,dep_namadepartement,kat_kodekategori,kat_namakategori
                                    order by dep_kodedepartement,dep_namadepartement,kat_kodekategori,kat_namakategori
                                ) a
                            )
                            group by kodedepartement,namadepartement
                            order by kodedepartement

        ");

        $dataDep = DB::connection(Session::get('connection'))
            ->select("select a.*,round(margin/sales*100,2) marginpersen
                            from(
                                select dep_kodedepartement kodedepartement,dep_namadepartement namadepartement, kat_kodekategori kodekategori, kat_kodekategori||'-'||kat_namakategori nama,
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
                                                                      (trjd_nominalamt / 1+(prd_ppn/100))
                                                                   ELSE
                                                                      CASE
                                                                         WHEN TRUNC (tko_tgltutup) <=
                                                                                 TRUNC (trjd_transactiondate)
                                                                         THEN
                                                                            (trjd_nominalamt / 1+(prd_ppn/100))
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
                                                                         (trjd_nominalamt / 1+(prd_ppn/100))
                                                                      ELSE
                                                                         CASE
                                                                            WHEN TRUNC (tko_tgltutup) <=
                                                                                    TRUNC (trjd_transactiondate)
                                                                            THEN
                                                                               (trjd_nominalamt / 1+(prd_ppn/100))
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
                                    inner join tbmaster_kategori on dep_kodedepartement = kat_kodedepartement and kat_kodekategori = prd_kodekategoribarang
                                where trunc(trjd_transactiondate) between to_date('" . $tanggal1 . "','dd/mm/yyyy') and to_date('" . $tanggal2 . "','dd/mm/yyyy')
                                " . $p_member . "
                                " . $p_group . "
                                " . $p_segmentasi . "
                                " . $p_outlet . "
                                " . $p_suboutlet . "
                                " . $p_divisi . "
                                " . $p_departemen . "
                                group by dep_kodedepartement,dep_namadepartement,kat_kodekategori,kat_namakategori
                                order by dep_kodedepartement,dep_namadepartement,kat_kodekategori,kat_namakategori
                            ) a
        ");

        $totalsales = 0;
        $totalmargin = 0;
        $totalsalesgroup = 0;
        $totalmargingroup = 0;

        $data = array();
        for ($i = 0; $i < sizeof($dataDepGroup); $i++) {
            $totalsalesgroup += $dataDepGroup[$i]->sales;
            $totalmargingroup += $dataDepGroup[$i]->margin;
        }
        for ($i = 0; $i < sizeof($dataDep); $i++) {
            $totalsales += $dataDep[$i]->sales;
            $totalmargin += $dataDep[$i]->margin;
        }

        for ($i = 0; $i < sizeof($dataDepGroup); $i++) {
            $dataDepGroup[$i]->constsales = round($dataDepGroup[$i]->sales / $totalsalesgroup * 100, 2);
            $dataDepGroup[$i]->constmargin = round($dataDepGroup[$i]->margin / $totalsalesgroup * 100, 2);
            $dataDepGroup[$i]->children = array();
            for ($j = 0; $j < sizeof($dataDep); $j++) {
                if ($dataDepGroup[$i]->kodedepartement == $dataDep[$j]->kodedepartement) {
                    $dataDep[$j]->constsales = round($dataDep[$j]->sales / $totalsales * 100, 2);
                    $dataDep[$j]->constmargin = round($dataDep[$j]->margin / $totalmargin * 100, 2);
                    array_push($dataDepGroup[$i]->children, $dataDep[$j]);
                }
            }
            array_push($data, $dataDepGroup[$i]);
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
        $divisi = $request->divisi;
        $departemen = $request->departemen;

        $p_member = '';
        $p_group = '';
        $p_segmentasi = '';
        $p_outlet = '';
        $p_suboutlet = '';
        $p_divisi = '';
        $p_departemen = '';

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
        if ($divisi != 'ALL') {
            $p_divisi = " AND div_kodedivisi = '" . $divisi . "'";
        }
        if ($departemen != 'ALL') {
            $p_departemen = " AND dep_kodedepartement = '" . $departemen . "'";
        }

        $data = DB::connection(Session::get('connection'))
            ->select("select a.*,round(margin/sales*100,2) marginpersen
                            from(
                                select dep_kodedepartement kodedepartement,dep_namadepartement namadepartement, kat_kodekategori kodekategori, kat_namakategori namakategori,
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
                                                                      (trjd_nominalamt / 1+(prd_ppn/100))
                                                                   ELSE
                                                                      CASE
                                                                         WHEN TRUNC (tko_tgltutup) <=
                                                                                 TRUNC (trjd_transactiondate)
                                                                         THEN
                                                                            (trjd_nominalamt / 1+(prd_ppn/100))
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
                                                                         (trjd_nominalamt / 1+(prd_ppn/100))
                                                                      ELSE
                                                                         CASE
                                                                            WHEN TRUNC (tko_tgltutup) <=
                                                                                    TRUNC (trjd_transactiondate)
                                                                            THEN
                                                                               (trjd_nominalamt / 1+(prd_ppn/100))
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
                                    inner join tbmaster_kategori on dep_kodedepartement = kat_kodedepartement and kat_kodekategori = prd_kodekategoribarang
                                where trunc(trjd_transactiondate) between to_date('" . $tanggal1 . "','dd/mm/yyyy') and to_date('" . $tanggal2 . "','dd/mm/yyyy')
                                " . $p_member . "
                                " . $p_group . "
                                " . $p_segmentasi . "
                                " . $p_outlet . "
                                " . $p_suboutlet . "
                                " . $p_divisi . "
                                " . $p_departemen . "
                                group by dep_kodedepartement,dep_namadepartement,kat_kodekategori,kat_namakategori
                                order by dep_kodedepartement,dep_namadepartement,kat_kodekategori,kat_namakategori
                            ) a
        ");
        $filename = 'laporan-sales-per-departemen-kategori';
        $perusahaan = DB::connection(Session::get('connection'))->table('tbmaster_perusahaan')
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

            return view('FRONTOFFICE.LAPORANSALESPERDIVDEPKAT.' . $filename . '-pdf', compact(['perusahaan', 'data', 'tanggal1', 'tanggal2','member','group','segmentasi','outlet','suboutlet','divisi','departemen']));

        } else {

            $filename = $filename . '.csv';
            $columnHeader = [
                'DEPARTEMENT',
                'KATEGORI',
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
                    $d->kodedepartement . '-' . $d->namadepartement,
                    $d->kodekategori . '-' . $d->namakategori,
                    $d->qty,
                    $d->sales,
                    $d->margin,
                    $d->marginpersen,
                    $d->constsales,
                    $d->constmargin,
                    $d->jumlahmember,
                ];
                array_push($linebuffs, $tempdata);
            }

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

}
