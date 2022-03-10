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

class LaporanSalesPerProdMemController extends Controller
{
    public function index(Request $request)
    {
        $selected_plu = $request->plu;
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

        return view('FRONTOFFICE.LAPORANSALESPERDIVDEPKAT.laporan-sales-per-produk-member', compact(['group', 'outlet', 'suboutlet', 'segmentasi', 'divisi', 'departement', 'kategori', 'selected_plu', 'selected_tanggal1', 'selected_tanggal2']));
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
    public function getDataKategori(Request $request)
    {
        $departemen = $request->departemen;
        if($departemen=='ALL'){
            $departemen='';
        }
        $kategori = DB::connection(Session::get('connection'))->table('tbmaster_kategori')
            ->where("kat_kodedepartement",'=',$departemen)
            ->orderBy('kat_kodekategori')
            ->get();

        return $kategori;
    }
    public function lovPLU(Request $request)
    {
        $search = $request->value;
        $div = $request->div;
        $dep = $request->dep;
        $kat = $request->kat;
        if($div=='ALL'){
            $div='';
        }
        if($dep=='ALL'){
            $dep='';
        }
        if($kat=='ALL'){
            $kat='';
        }
        $data = DB::connection(Session::get('connection'))->table('tbmaster_prodmast')
            ->select('prd_prdcd', 'prd_deskripsipanjang')
            ->where('prd_kodedivisi', 'LIKE', '%' . $div . '%')
            ->where('prd_kodedepartement', 'LIKE', '%' . $dep . '%')
            ->where('prd_kodekategoribarang', 'LIKE', '%' . $kat . '%')
            ->whereRaw("(prd_prdcd LIKE '%" . $search . "%' or prd_deskripsipanjang LIKE '%" . $search . "%')")
//            ->where("prd_prdcd', 'LIKE', '%' . $search . '%')
//            ->orWhere('prd_deskripsipanjang', 'LIKE', '%' . $search . '%')
            ->orderBy('prd_prdcd')
            ->limit(100)
            ->get();
        return Datatables::of($data)->make(true);
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
        $plu = $request->plu;

        $p_member = '';
        $p_group = '';
        $p_segmentasi = '';
        $p_outlet = '';
        $p_suboutlet = '';
        $p_divisi = '';
        $p_departemen = '';
        $p_kategori = '';
        $p_plu = '';

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
        if ($plu != '') {
            $p_plu = " AND trjd_prdcd = '" . $plu . "'";
        }

        $dataMemberGroup = DB::connection(Session::get('connection'))
            ->select("select prd_prdcd,plu nama, round(sum(margin)/sum(sales)*100,2) marginpersen,
                                    sum(qty) qty,sum(sales) sales,sum(margin) margin
                            from (
                                select a.*
                                from(
                                    select prd_prdcd,prd_prdcd||'-'||prd_deskripsipanjang plu,
                                           cus_kodemember kodemember, cus_kodemember||'-'||cus_namamember nama, nvl(cus_flagmemberkhusus,'') memberkhusus,
                                           nvl(cus_jenismember,'') membergroup, nvl(out_namaoutlet,'') outlet,nvl(sub_namasuboutlet,'') suboutlet,
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
                                                                  margin
                                    from tbmaster_divisi
                                        inner join tbmaster_prodmast on div_kodedivisi = prd_kodedivisi
                                        inner join tbtr_jualdetail on prd_prdcd = trjd_prdcd
                                        left join tbmaster_tokoigr on tko_kodecustomer= trjd_cus_kodemember
                                        inner join tbmaster_customer on trjd_cus_kodemember = cus_kodemember
                                        left join TBMASTER_CUSTOMERCRM ON crm_kodemember = cus_kodemember
                                        inner join tbmaster_departement on div_kodedivisi = dep_kodedivisi and dep_kodedepartement = prd_kodedepartement
                                        inner join tbmaster_kategori on dep_kodedepartement = kat_kodedepartement and kat_kodekategori = prd_kodekategoribarang
                                        left join tbmaster_outlet on cus_kodeoutlet = out_kodeoutlet
                                        left join tbmaster_suboutlet on cus_kodeoutlet = sub_kodeoutlet and cus_kodesuboutlet = sub_kodesuboutlet
                                    where trunc(trjd_transactiondate) between to_date('" . $tanggal1 . "','dd/mm/yyyy') and to_date('" . $tanggal2 . "','dd/mm/yyyy')
                                    " . $p_member . "
                                    " . $p_group . "
                                    " . $p_segmentasi . "
                                    " . $p_outlet . "
                                    " . $p_suboutlet . "
                                    " . $p_divisi . "
                                    " . $p_departemen . "
                                    " . $p_kategori . "
                                    " . $p_plu . "
                                    group by prd_prdcd,prd_prdcd||'-'||prd_deskripsipanjang,
                                           cus_kodemember, cus_kodemember||'-'||cus_namamember, cus_flagmemberkhusus,
                                           cus_jenismember, out_namaoutlet,sub_namasuboutlet
                                    order by prd_prdcd, cus_kodemember
                                ) a
                            )
                            group by prd_prdcd, plu
                            order by prd_prdcd
        ");

        $dataMember = DB::connection(Session::get('connection'))
            ->select("select a.*,round(margin/sales*100,2) marginpersen
                            from(
                                select prd_prdcd,prd_prdcd||'-'||prd_deskripsipanjang plu,
                                           cus_kodemember kodemember, cus_kodemember||'-'||cus_namamember nama, nvl(cus_flagmemberkhusus,'') memberkhusus,
                                           nvl(cus_jenismember,'') membergroup, nvl(out_namaoutlet,'') outlet,nvl(sub_namasuboutlet,'') suboutlet,
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
                                    left join tbmaster_outlet on cus_kodeoutlet = out_kodeoutlet
                                    left join tbmaster_suboutlet on cus_kodeoutlet = sub_kodeoutlet and cus_kodesuboutlet = sub_kodesuboutlet
                                    where trunc(trjd_transactiondate) between to_date('" . $tanggal1 . "','dd/mm/yyyy') and to_date('" . $tanggal2 . "','dd/mm/yyyy')
                                " . $p_member . "
                                " . $p_group . "
                                " . $p_segmentasi . "
                                " . $p_outlet . "
                                " . $p_suboutlet . "
                                " . $p_divisi . "
                                " . $p_departemen . "
                                " . $p_kategori . "
                                " . $p_plu . "
                                group by prd_prdcd,prd_prdcd||'-'||prd_deskripsipanjang,
                                           cus_kodemember, cus_kodemember||'-'||cus_namamember, cus_flagmemberkhusus,
                                           cus_jenismember, out_namaoutlet,sub_namasuboutlet
                                order by prd_prdcd, cus_kodemember
                            ) a
        ");

        $totalsales = 0;
        $totalmargin = 0;
        $totalsalesgroup = 0;
        $totalmargingroup = 0;

        $data = array();
        for ($i = 0; $i < sizeof($dataMemberGroup); $i++) {
            $totalsalesgroup += $dataMemberGroup[$i]->sales;
            $totalmargingroup += $dataMemberGroup[$i]->margin;
        }
        for ($i = 0; $i < sizeof($dataMember); $i++) {
            $totalsales += $dataMember[$i]->sales;
            $totalmargin += $dataMember[$i]->margin;
        }

        for ($i = 0; $i < sizeof($dataMemberGroup); $i++) {
            $dataMemberGroup[$i]->memberkhusus = '';
            $dataMemberGroup[$i]->membergroup = '';
            $dataMemberGroup[$i]->outlet = '';
            $dataMemberGroup[$i]->suboutlet = '';
            $dataMemberGroup[$i]->constsales = round($dataMemberGroup[$i]->sales / $totalsalesgroup * 100, 2);
            $dataMemberGroup[$i]->constmargin = round($dataMemberGroup[$i]->margin / $totalsalesgroup * 100, 2);
            $dataMemberGroup[$i]->children = array();
            for ($j = 0; $j < sizeof($dataMember); $j++) {
                if ($dataMemberGroup[$i]->prd_prdcd == $dataMember[$j]->prd_prdcd) {
                    $dataMember[$j]->constsales = round($dataMember[$j]->sales / $totalsales * 100, 2);
                    $dataMember[$j]->constmargin = round($dataMember[$j]->margin / $totalmargin * 100, 2);
                    array_push($dataMemberGroup[$i]->children, $dataMember[$j]);
                }
            }
            array_push($data, $dataMemberGroup[$i]);
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
        $plu = $request->plu;


        $p_member = '';
        $p_group = '';
        $p_segmentasi = '';
        $p_outlet = '';
        $p_suboutlet = '';
        $p_divisi = '';
        $p_departemen = '';
        $p_kategori = '';
        $p_plu = '';

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
        if ($plu != '') {
            $p_plu = " AND trjd_prdcd = '" . $plu . "'";
        }

        $data = DB::connection(Session::get('connection'))
            ->select("select a.*,round(margin/sales*100,2) marginpersen
                            from(
                                select prd_prdcd,prd_prdcd||'-'||prd_deskripsipanjang plu,
                                           cus_kodemember kodemember, cus_kodemember||'-'||cus_namamember nama, nvl(cus_flagmemberkhusus,'') memberkhusus,
                                           nvl(cus_jenismember,'') membergroup, nvl(out_namaoutlet,'') outlet,nvl(sub_namasuboutlet,'') suboutlet,
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
                                    left join tbmaster_outlet on cus_kodeoutlet = out_kodeoutlet
                                    left join tbmaster_suboutlet on cus_kodeoutlet = sub_kodeoutlet and cus_kodesuboutlet = sub_kodesuboutlet
                                where trunc(trjd_transactiondate) between to_date('" . $tanggal1 . "','dd/mm/yyyy') and to_date('" . $tanggal2 . "','dd/mm/yyyy')
                                " . $p_member . "
                                " . $p_group . "
                                " . $p_segmentasi . "
                                " . $p_outlet . "
                                " . $p_suboutlet . "
                                " . $p_divisi . "
                                " . $p_departemen . "
                                " . $p_kategori . "
                                " . $p_plu . "
                                group by prd_prdcd,prd_prdcd||'-'||prd_deskripsipanjang,
                                           cus_kodemember, cus_kodemember||'-'||cus_namamember, cus_flagmemberkhusus,
                                           cus_jenismember, out_namaoutlet,sub_namasuboutlet
                                order by prd_prdcd||'-'||prd_deskripsipanjang, cus_kodemember
                            ) a
        ");
        $filename = 'laporan-sales-per-produk-member';
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

            return view('FRONTOFFICE.LAPORANSALESPERDIVDEPKAT.' . $filename . '-pdf', compact(['perusahaan', 'data', 'tanggal1', 'tanggal2','member','group','segmentasi','outlet','suboutlet','divisi','departemen','kategori','plu']));

        } else {

            $filename = $filename . '.csv';
            $columnHeader = [
                'PLU',
                'MEMBER',
                'QTY',
                'KHUSUS',
                'GROUP',
                'OUTLET',
                'SUBOUTLET',
                'SALES',
                'MARGIN',
                'MARGIN %',
                'CONST. SLS',
                'CONST. MRG',
            ];
            $linebuffs = array();
            foreach ($data as $d) {
                $tempdata = [
                    $d->plu,
                    $d->nama,
                    $d->memberkhusus,
                    $d->membergroup,
                    $d->outlet,
                    $d->suboutlet,
                    $d->qty,
                    $d->sales,
                    $d->margin,
                    $d->marginpersen,
                    $d->constsales,
                    $d->constmargin,
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
