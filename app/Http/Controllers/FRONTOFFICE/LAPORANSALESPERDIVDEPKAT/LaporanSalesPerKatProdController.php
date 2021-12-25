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

class LaporanSalesPerKatProdController extends Controller
{
    public function index(Request $request)
    {
        $selected_kat = $request->kategori;
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

        $kategori = DB::connection(Session::get('connection'))->table('tbmaster_kategori')
            ->orderBy('kat_kodekategori')
            ->get();

        return view('FRONTOFFICE.LAPORANSALESPERDIVDEPKAT.laporan-sales-per-kategori-produk', compact(['group', 'outlet', 'suboutlet', 'segmentasi','divisi','departement','kategori','selected_kat','selected_tanggal1','selected_tanggal2']));
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
        $kategori = $request->kategori;


        $p_member = '';
        $p_group = '';
        $p_segmentasi = '';
        $p_outlet = '';
        $p_suboutlet = '';
        $p_divisi = '';
        $p_departemen = '';
        $p_kategori = '';

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
        if ($kategori != 'ALL') {
            $p_kategori = " AND kat_kodekategori = '" . $kategori . "'";
        }

        $dataPLUGroup = DB::connection(Session::get('connection'))
            ->select("select kodekategori,namakategori nama,round(sum(margin)/sum(sales)*100,2) marginpersen ,sum(qty) qty,sum(sales) sales,sum(margin) margin,sum(jmlmember) jmlmember from (
                                select a.*
                                from(
                                    select kat_kodekategori kodekategori, kat_namakategori namakategori, prd_prdcd||'-'||prd_deskripsipanjang plu,
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
                                        inner join tbmaster_kategori on dep_kodedepartement = kat_kodedepartement and kat_kodekategori = prd_kodekategoribarang
                                    where trunc(trjd_transactiondate) between to_date('" . $tanggal1 . "','dd/mm/yyyy') and to_date('" . $tanggal2 . "','dd/mm/yyyy')
                                    " . $p_member . "
                                    " . $p_group . "
                                    " . $p_segmentasi . "
                                    " . $p_outlet . "
                                    " . $p_suboutlet . "
                                    " . $p_divisi . "
                                    " . $p_departemen . "
                                    " . $p_kategori . "
                                    group by kat_kodekategori, kat_namakategori, prd_prdcd||'-'||prd_deskripsipanjang
                                    order by kat_kodekategori, kat_namakategori, prd_prdcd||'-'||prd_deskripsipanjang
                                ) a
                            )
                            group by kodekategori, namakategori
                            order by kodekategori
        ");

        $dataPLU = DB::connection(Session::get('connection'))
            ->select("select a.*,round(margin/sales*100,2) marginpersen
                            from(
                                select kat_kodekategori kodekategori, kat_namakategori namakategori, prd_prdcd||'-'||prd_deskripsipanjang nama,
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
                                    inner join tbmaster_kategori on dep_kodedepartement = kat_kodedepartement and kat_kodekategori = prd_kodekategoribarang
                                where trunc(trjd_transactiondate) between to_date('" . $tanggal1 . "','dd/mm/yyyy') and to_date('" . $tanggal2 . "','dd/mm/yyyy')
                                " . $p_member . "
                                " . $p_group . "
                                " . $p_segmentasi . "
                                " . $p_outlet . "
                                " . $p_suboutlet . "
                                " . $p_divisi . "
                                " . $p_departemen . "
                                " . $p_kategori . "
                                group by kat_kodekategori, kat_namakategori, prd_prdcd||'-'||prd_deskripsipanjang
                                order by kat_kodekategori, kat_namakategori, prd_prdcd||'-'||prd_deskripsipanjang
                            ) a
        ");

        $totalsales = 0;
        $totalmargin = 0;
        $totalsalesgroup = 0;
        $totalmargingroup = 0;

        $data = array();
        for ($i = 0; $i < sizeof($dataPLUGroup); $i++) {
            $totalsalesgroup += $dataPLUGroup[$i]->sales;
            $totalmargingroup += $dataPLUGroup[$i]->margin;
        }
        for ($i = 0; $i < sizeof($dataPLU); $i++) {
            $totalsales += $dataPLU[$i]->sales;
            $totalmargin += $dataPLU[$i]->margin;
        }

        for ($i = 0; $i < sizeof($dataPLUGroup); $i++) {
            $dataPLUGroup[$i]->constsales = round($dataPLUGroup[$i]->sales / $totalsalesgroup * 100, 2);
            $dataPLUGroup[$i]->constmargin = round($dataPLUGroup[$i]->margin / $totalsalesgroup * 100, 2);
            $dataPLUGroup[$i]->children = array();
            for ($j = 0; $j < sizeof($dataPLU); $j++) {
                if ($dataPLUGroup[$i]->kodekategori == $dataPLU[$j]->kodekategori) {
                    $dataPLU[$j]->constsales = round($dataPLU[$j]->sales / $totalsales * 100, 2);
                    $dataPLU[$j]->constmargin = round($dataPLU[$j]->margin / $totalmargin * 100, 2);
                    array_push($dataPLUGroup[$i]->children, $dataPLU[$j]);
                }
            }
            array_push($data, $dataPLUGroup[$i]);
        }

        return DataTables::of($data)->make(true);
    }

    public function cetak(Request $request)
    {
        $jenislaporan = $request->jenislaporan;
        $member = $request->member;
        $group = $request->group;
        $segmentasi = $request->segmentasi;
        $outlet = $request->outlet;
        $suboutlet = $request->suboutlet;
        $tanggal1 = $request->tanggal1;
        $tanggal2 = $request->tanggal2;
        $divisi = $request->divisi;
        $departemen = $request->departemen;
        $kategori = $request->kategori;


        $p_member = '';
        $p_group = '';
        $p_segmentasi = '';
        $p_outlet = '';
        $p_suboutlet = '';
        $p_divisi = '';
        $p_departemen = '';
        $p_kategori = '';

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
        if ($kategori != 'ALL') {
            $p_kategori = " AND kat_kodekategori = '" . $kategori . "'";
        }

        $data = DB::connection(Session::get('connection'))
            ->select("select a.*,round(margin/sales*100,2) marginpersen
                            from(
                                select kat_kodekategori kodekategori, kat_namakategori namakategori, prd_prdcd||'-'||prd_deskripsipanjang plu,
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
                                    inner join tbmaster_kategori on dep_kodedepartement = kat_kodedepartement and kat_kodekategori = prd_kodekategoribarang
                                where trunc(trjd_transactiondate) between to_date('" . $tanggal1 . "','dd/mm/yyyy') and to_date('" . $tanggal2 . "','dd/mm/yyyy')
                                " . $p_member . "
                                " . $p_group . "
                                " . $p_segmentasi . "
                                " . $p_outlet . "
                                " . $p_suboutlet . "
                                " . $p_divisi . "
                                " . $p_departemen . "
                                " . $p_kategori . "
                                group by kat_kodekategori, kat_namakategori, prd_prdcd||'-'||prd_deskripsipanjang
                                order by kat_kodekategori, kat_namakategori, prd_prdcd||'-'||prd_deskripsipanjang
                            ) a
        ");
        $filename = 'laporan-sales-per-kategori-produk';
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

            return view('FRONTOFFICE.LAPORANSALESPERDIVDEPKAT.' . $filename . '-pdf', compact(['perusahaan', 'data', 'tanggal1', 'tanggal2']));

        } else {

            $filename = $filename . '.csv';
            $columnHeader = [
                'KATEGORI',
                'PLU',
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
                    $d->kodekategori . '-' . $d->namakategori,
                    $d->plu,
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
