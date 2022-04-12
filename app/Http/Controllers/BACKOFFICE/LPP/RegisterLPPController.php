<?php

namespace App\Http\Controllers\BACKOFFICE\LPP;

use Carbon\Carbon;
use Dompdf\Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Excel;
use PDF;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Yajra\DataTables\DataTables;
use File;


class RegisterLPPController extends Controller
{
    public function index()
    {
        return view('BACKOFFICE.LPP.register-lpp');
    }

    public function getPLU(Request $request)
    {
        $search = $request->value;

        $data = DB::connection(Session::get('connection'))->table('tbmaster_prodmast')
            ->where('prd_prdcd', 'LIKE', '%' . $search . '%')
            ->orWhere('prd_deskripsipanjang', 'LIKE', '%' . $search . '%')
            ->orderBy('prd_prdcd')
            ->limit(100)
            ->get();

        return Datatables::of($data)->make(true);
    }

    public function getDep(Request $request)
    {
        $search = $request->value;

        $data = DB::connection(Session::get('connection'))->table('tbmaster_divisi')
            ->join('tbmaster_departement', 'div_kodedivisi', '=', 'dep_kodedivisi')
            ->select('div_namadivisi', 'div_kodedivisi', 'dep_namadepartement',
                'dep_kodedepartement')
            ->where('dep_kodedepartement', 'LIKE', '%' . $search . '%')
            ->orWhere('dep_namadepartement', 'LIKE', '%' . $search . '%')
            ->Where('div_kodeigr', Session::get('kdigr'))
            ->orderBy('div_kodedivisi')
            ->orderBy('dep_kodedepartement')
            ->limit(100)
            ->get();

        return Datatables::of($data)->make(true);

    }

    public function getKat(Request $request)
    {
        $search = $request->value;

        $data = DB::connection(Session::get('connection'))->table('tbmaster_departement')
            ->join('tbmaster_kategori', 'dep_kodedepartement', '=', 'kat_kodedepartement')
            ->select('dep_namadepartement', 'dep_kodedepartement', 'kat_namakategori',
                'kat_kodekategori')
            ->where('kat_kodekategori', 'LIKE', '%' . $search . '%')
            ->orWhere('kat_namakategori', 'LIKE', '%' . $search . '%')
            ->Where('dep_kodeigr', Session::get('kdigr'))
            ->orderBy('dep_kodedepartement')
            ->orderBy('kat_kodekategori')
            ->limit(100)
            ->get();

        return Datatables::of($data)->make(true);
    }

    public function getMtr(Request $request)
    {
        $search = $request->value;

        $data = DB::connection(Session::get('connection'))->table('tbtr_monitoringplu')
            ->select('mpl_kodemonitoring', 'mpl_namamonitoring', 'mpl_prdcd')
            ->where('mpl_namamonitoring', 'LIKE', '%' . $search . '%')
            ->orWhere('mpl_kodemonitoring', 'LIKE', '%' . $search . '%')
            ->Where('mpl_kodeigr', Session::get('kdigr'))
            ->orderBy('mpl_kodemonitoring')
            ->limit(100)
            ->get();

        return Datatables::of($data)->make(true);
    }

    public function getSup(Request $request)
    {
        $search = $request->value;

        $data = DB::connection(Session::get('connection'))->table('tbmaster_supplier')
            ->select('sup_kodesupplier', 'sup_namasupplier')
            ->where('sup_kodesupplier', 'LIKE', '%' . $search . '%')
            ->orWhere('sup_namasupplier', 'LIKE', '%' . $search . '%')
            ->Where('sup_kodeigr', Session::get('kdigr'))
            ->orderBy('sup_kodesupplier')
            ->limit(100)
            ->get();

        return Datatables::of($data)->make(true);
    }

    public function cetak(Request $request)
    {
        set_time_limit(0);
        $menu = $request->menu;
        $tgl1 = $request->periode1;
        $tgl2 = $request->periode2;
        $prdcd1 = $request->prdcd1;
        $prdcd2 = $request->prdcd2;
        $dep1 = $request->dep1;
        $dep2 = $request->dep2;
        $kat1 = $request->kat1;
        $kat2 = $request->kat2;
        $mtr1 = $request->mtr1;
        $mtr2 = $request->mtr2;
        $sup1 = $request->sup1;
        $sup2 = $request->sup2;
        $tipe = $request->tipe;
        $banyakitem = $request->banyakitem == '' ? 99999 : $request->banyakitem;

        $and_tipe = '';
        $and_plu = '';
        $and_div = '';
        $and_dep = '';
        $and_kat = '';
        $and_mtr = '';
        $and_sup = '';
        $p_order = '';

        if (isset($prdcd1) && isset($prdcd2)) {
            $and_plu = " and lpp_prdcd between '" . $prdcd1 . "' and '" . $prdcd2 . "'";
        }
        if (isset($div1) && isset($div2)) {
            $and_div = " and div_kodedivisi between '" . $div1 . "' and '" . $div2 . "'";
        }
        if (isset($dep1) && isset($dep2)) {
            $and_dep = " and dep_kodedepartement between '" . $dep1 . "' and '" . $dep2 . "'";
        }
        if (isset($kat1) && isset($kat1)) {
            $and_kat = " and kat_kodekategori between '" . $kat1 . "' and '" . $kat2 . "'";
        }

        if (isset($tipe)) {
            switch ($tipe) {
                case '1':
                    $and_tipe = ' and lpp_rphakhir < 0';
                    break;
                case '2':
                    $and_tipe = ' and lpp_rphakhir >= 0';
                    break;
                default :
                    $and_tipe = '';
                    break;
            }
        }

        if (isset($mtr1) && isset($mtr2)) {
            $and_mtr = " and mpl_kodemonitoring between '" . $mtr1 . "' and '" . $mtr2 . "'";
        }

        $perusahaan = DB::connection(Session::get('connection'))->table('tbmaster_perusahaan')
            ->select('prs_namaperusahaan', 'prs_namacabang', 'prs_namawilayah')
            ->first();

        if ($menu == 'LPP01') {
            $p_prog = 'LPP01';
            $repid = 'RPT_LPP01';
            $rep_name = 'IGR_BO_LPPRDDK.jsp';

            $p_nilaiidmacost = DB::connection(Session::get('connection'))->select("SELECT SUM (NILAI) rph
      FROM (SELECT BTD_PRDCD, ST_LOKASI, ((BTD_PRICE * 0.97) * BTD_QTY) NILAI
              FROM TBTR_BATOKO_H, TBTR_BATOKO_D, TBMASTER_STOCK
             WHERE TRUNC (BTH_TGLDOC) BETWEEN TRUNC (to_date('" . $tgl1 . "','dd/mm/yyyy')) AND TRUNC (to_date('" . $tgl2 . "','dd/mm/yyyy'))
               AND BTD_ID = BTH_ID
            AND ST_PRDCD = SUBSTR (BTD_PRDCD, 1, 6) || '0'
            AND ST_LOKASI = '01') A")[0]->rph;

            $p_nilaiidmprice = DB::connection(Session::get('connection'))->select("SELECT SUM (NILAI) rph
      FROM (SELECT BTD_PRDCD, ST_LOKASI, ((BTD_PRICE * BTD_QTY) + BTD_PPN) NILAI FROM TBTR_BATOKO_H, TBTR_BATOKO_D, TBMASTER_STOCK
             WHERE TRUNC (BTH_TGLDOC) BETWEEN TRUNC (to_date('" . $tgl1 . "','dd/mm/yyyy')) AND TRUNC (to_date('" . $tgl2 . "','dd/mm/yyyy'))
               AND BTD_ID = BTH_ID
            AND ST_PRDCD = SUBSTR (BTD_PRDCD, 1, 6) || '0'
            AND ST_LOKASI = '01') A")[0]->rph;

            $p_nilaihbvtrfin = DB::connection(Session::get('connection'))->select("SELECT SUM (rph) rph FROM (SELECT trjd_PRDCD, CASE WHEN TRJD_TRANSACTIONTYPE = 'S' THEN TRJD_QUANTITY ELSE TRJD_QUANTITY * -1 END QTY,
CASE WHEN TRJD_TRANSACTIONTYPE = 'S' THEN (TRJD_QUANTITY * TRJD_BASEPRICE) ELSE (TRJD_QUANTITY * TRJD_BASEPRICE) * -1 END RPH
FROM TBTR_JUALDETAIL, TBMASTER_PRODMAST WHERE TRJD_KODEIGR = " . Session::get('kdigr') . " AND TRUNC (TRJD_TRANSACTIONDATE) BETWEEN TRUNC (to_date('" . $tgl1 . "','dd/mm/yyyy')) AND TRUNC (to_date('" . $tgl2 . "','dd/mm/yyyy'))
AND (   TRJD_DIVISIONCODE <> '5' OR SUBSTR (TRJD_DIVISION, 1, 2) <> '39') AND TRJD_RECORDID IS NULL AND PRD_KODEIGR = TRJD_KODEIGR AND PRD_PRDCD = TRJD_PRDCD AND NVL (prd_flaghbv, 'N') = 'Y') aa")[0]->rph;

            $p_nilaihbvtrfout = DB::connection(Session::get('connection'))->select("SELECT SUM (nilai) rph FROM (SELECT trjd_prdcd, qty, hbv_prdcd_brd, hbv_qty_gram, hbv_qty_gram * qty, st_avgcost, ( (NVL (hbv_qty_gram * qty, 0) * st_avgcost) / 1000) nilai
FROM ( SELECT trjd_prdcd, SUM (trjd_quantity) qty FROM TBTR_JUALDETAIL, TBMASTER_PRODMAST
WHERE TRJD_KODEIGR = " . Session::get('kdigr') . " AND TRUNC (TRJD_TRANSACTIONDATE) BETWEEN TRUNC (to_date('" . $tgl1 . "','dd/mm/yyyy')) AND TRUNC (to_date('" . $tgl2 . "','dd/mm/yyyy'))
AND ( TRJD_DIVISIONCODE <> '5' OR SUBSTR (TRJD_DIVISION, 1, 2) <> '39') AND TRJD_RECORDID IS NULL AND PRD_KODEIGR = TRJD_KODEIGR
            AND PRD_PRDCD = TRJD_PRDCD AND NVL (prd_flaghbv, 'N') = 'Y' GROUP BY trjd_prdcd) aa, tbmaster_formula_hbv, tbmaster_stock
WHERE SUBSTR (hbv_prdcd_brj, 1, 6) = SUBSTR (trjd_prdcd, 1, 6) AND st_prdcd = hbv_prdcd_brd AND st_lokasi = '01') bb")[0]->rph;

            $data = DB::connection(Session::get('connection'))->select("SELECT lpp_kodedivisi,
         div_namadivisi,
         lpp_kodedepartemen,
         dep_namadepartement,
         lpp_kategoribrg,
         kat_namakategori,
         prs_namaperusahaan,
         prs_namacabang,
         prs_namawilayah,
         SUM (lpp_qtybegbal) sawalqty,
         SUM (lpp_rphbegbal) sawalrph,
         SUM (lpp_rphbeli) beli,
         SUM (lpp_rphbonus) bonus,
         SUM (lpp_rphtrmcb) trmcb,
         SUM (lpp_rphretursales) retursales,
         SUM (lpp_rphrafak) rafak,
         SUM (lpp_rphrepack) repack,
         SUM (lpp_rphlainin) lainin,
         SUM (lpp_rphsales) SALES,
         SUM (lpp_rphkirim) kirim,
         SUM (lpp_rphprepacking) prepack,
         SUM (lpp_rphhilang) hilang,
         SUM (lpp_rphlainout) lainout,
         SUM (lpp_rphintransit) intrst,
         SUM (adj) adj,
         SUM (koreksi) koreksi,
         SUM (lpp_rphakhir) akhir,
         SUM (lpp_qtyakhir) akhirq,
         SUM (lpp_qty_selisih_so + lpp_qty_selisih_soic) sel_so,
         SUM (lpp_rph_selisih_so + lpp_rph_selisih_soic) rph_sel_so
    FROM (  SELECT lpp_kodedivisi,
                   div_namadivisi,
                   lpp_kodedepartemen,
                   dep_namadepartement,
                   lpp_kategoribrg,
                   kat_namakategori,
                   lpp_prdcd,
                   prd_deskripsipanjang,
                   lpp_qtybegbal,
                   lpp_rphbegbal,
                   lpp_rphbeli,
                   lpp_rphbonus,
                   lpp_rphtrmcb,
                   lpp_rphretursales,
                   lpp_rphrafak,
                   lpp_rphrepack,
                   lpp_rphlainin,
                   lpp_rphsales,
                   lpp_rphkirim,
                   lpp_rphprepacking,
                   lpp_rphhilang,
                   lpp_rphlainout,
                   lpp_rphintransit,
                   (NVL (lpp_rphadj, 0) + NVL (lpp_soadj, 0)) adj,
                   NVL (lpp_rphakhir, 0) lpp_rphakhir,
                   NVL (lpp_qtyakhir, 0) lpp_qtyakhir,
                     NVL (lpp_rphakhir, 0)
                   - (  NVL (lpp_rphbegbal, 0)
                      + NVL (lpp_rphbeli, 0)
                      + NVL (lpp_rphbonus, 0)
                      + NVL (lpp_rphtrmcb, 0)
                      + NVL (lpp_rphretursales, 0)
                      + NVL (lpp_rph_selisih_so, 0)
                      + NVL (lpp_rph_selisih_soic, 0)
                      + NVL (lpp_rphrepack, 0)
                      + NVL (lpp_rphlainin, 0)
                      - NVL (lpp_rphrafak, 0)
                      - NVL (lpp_rphsales, 0)
                      - NVL (lpp_rphkirim, 0)
                      - NVL (lpp_rphprepacking, 0)
                      - NVL (lpp_rphhilang, 0)
                      - NVL (lpp_rphlainout, 0)
                      + NVL (lpp_rphintransit, 0)
                      + NVL (lpp_rphadj, 0)
                      + NVL (lpp_soadj, 0))
                      koreksi,
                   NVL (lpp_qty_selisih_so, 0) lpp_qty_selisih_so,
                   NVL (lpp_rph_selisih_so, 0) lpp_rph_selisih_so,
                   NVL (lpp_qty_selisih_soic, 0) lpp_qty_selisih_soic,
                   NVL (lpp_rph_selisih_soic, 0) lpp_rph_selisih_soic,
                   prs_namaperusahaan,
                   prs_namacabang,
                   prs_namawilayah
              FROM tbtr_lpp,
                   tbmaster_prodmast,
                   tbmaster_divisi,
                   tbmaster_departement,
                   tbmaster_kategori,
                   tbmaster_perusahaan
             WHERE     lpp_kodeigr = " . Session::get('kdigr') . "
                   AND lpp_tgl1 >= to_date('" . $tgl1 . "','dd/mm/yyyy')
                   AND lpp_tgl2 <= to_date('" . $tgl2 . "','dd/mm/yyyy')
                   AND prd_kodeigr(+) = lpp_kodeigr
                   AND prd_prdcd(+) = lpp_prdcd
                   AND div_kodeigr(+) = lpp_kodeigr
                   AND div_kodedivisi(+) = lpp_kodedivisi
                   AND dep_kodeigr(+) = lpp_kodeigr
                   AND dep_kodedivisi(+) = lpp_kodedivisi
                   AND dep_kodedepartement(+) = lpp_kodedepartemen
                   AND kat_kodeigr(+) = lpp_kodeigr
                   AND kat_kodedepartement(+) = lpp_kodedepartemen
                   AND kat_kodekategori(+) = lpp_kategoribrg
                   AND prs_kodeigr = lpp_kodeigr
            ORDER BY div_kodedivisi, dep_kodedepartement, kat_kodekategori)
            GROUP BY lpp_kodedivisi,
                     div_namadivisi,
                     lpp_kodedepartemen,
                     dep_namadepartement,
                     lpp_kategoribrg,
                     kat_namakategori,
                     prs_namaperusahaan,
                     prs_namacabang,
                     prs_namawilayah
            ORDER BY lpp_kodedivisi, lpp_kodedepartemen, lpp_kategoribrg");

            $title = '** POSISI & MUTASI PERSEDIAAN BARANG BAIK **';

            return view('BACKOFFICE.LPP.' . $repid, compact(['title', 'perusahaan', 'data', 'tgl1', 'tgl2', 'p_nilaiidmacost', 'p_nilaiidmprice', 'p_nilaihbvtrfin', 'p_nilaihbvtrfout']));
        } else if ($menu == 'LPP02') {
            $p_prog = 'LPP02';
            $repid = 'RPT_LPP02';
            $rep_name = 'IGR_BO_LPPRCDDK.jsp';

            $data = DB::connection(Session::get('connection'))
                ->select("SELECT lpp_kodedivisi,
         div_namadivisi,
         lpp_kodedepartemen,
         dep_namadepartement,
         lpp_kategoribrg,
         kat_namakategori,
         lpp_prdcd,
         prd_deskripsipanjang,
         kemasan,
         judul,
         prs_namaperusahaan,
         prs_namacabang,
         prs_namawilayah,
         SUM (lpp_qtybegbal) sawalqty,
         SUM (lpp_rphbegbal) sawalrph,
         SUM (lpp_qtybeli) beliqty,
         SUM (lpp_rphbeli) belirph,
         SUM (lpp_qtybonus) bonusqty,
         SUM (lpp_rphbonus) bonusrph,
         SUM (lpp_qtytrmcb) trmcbqty,
         SUM (lpp_rphtrmcb) trmcbrph,
         SUM (lpp_qtyretursales) retursalesqty,
         SUM (lpp_rphretursales) retursalesrph,
         SUM (lpp_rphrafak) rafakrph,
         SUM (lpp_qtyrepack) repackqty,
         SUM (lpp_rphrepack) repackrph,
         SUM (lpp_qtylainin) laininqty,
         SUM (lpp_rphlainin) laininrph,
         SUM (lpp_qtysales) salesqty,
         SUM (lpp_rphsales) salesrph,
         SUM (lpp_qtykirim) kirimqty,
         SUM (lpp_rphkirim) kirimrph,
         SUM (lpp_qtyprepacking) prepackqty,
         SUM (lpp_rphprepacking) prepackrph,
         SUM (lpp_qtyhilang) hilangqty,
         SUM (lpp_qty_selisih_so + lpp_qty_selisih_soic) sel_so,
         SUM (lpp_rph_selisih_so + lpp_rph_selisih_soic) rph_sel_so,
         SUM (lpp_rphhilang) hilangrph,
         SUM (lpp_qtylainout) lainoutqty,
         SUM (lpp_rphlainout) lainoutrph,
         SUM (lpp_qtyintransit) intrstqty,
         SUM (lpp_rphintransit) intrstrph,
         SUM (lpp_qtyadj) adjqty,
         SUM (lpp_rphadj) adjrph,
         SUM (adj) adj,
         SUM (sadj) sadj,
         SUM (lpp_qtyakhir) akhirqty,
         SUM (lpp_rphakhir) akhirrph,
         SUM (lpp_supplierservq) servqsup,
         SUM (lpp_tokoservq) servqtok,
         SUM (saldotoko) saldotoko
    FROM (SELECT lpp_kodedivisi,
                 div_namadivisi,
                 lpp_kodedepartemen,
                 dep_namadepartement,
                 lpp_kategoribrg,
                 kat_namakategori,
                 lpp_prdcd,
                 prd_deskripsipanjang,
                 prd_unit || '/' || prd_frac kemasan,
                 CASE
                    WHEN " . $tipe . " = '1'
                    THEN
                       'POSISI & MUTASI PERSEDIAAN BARANG BAIK (MINUS)'
                    ELSE
                       CASE
                          WHEN " . $tipe . " = '2'
                          THEN
                             'POSISI & MUTASI PERSEDIAAN BARANG BAIK (PLUS)'
                          ELSE
                             ' POSISI & MUTASI PERSEDIAAN BARANG BAIK'
                       END
                 END
                    judul,
                 lpp_qtybegbal,
                 lpp_rphbegbal,
                 lpp_qtybeli,
                 lpp_rphbeli,
                 lpp_qtybonus,
                 lpp_rphbonus,
                 lpp_qtytrmcb,
                 lpp_rphtrmcb,
                 lpp_qtyretursales,
                 lpp_rphretursales,
                 lpp_rphrafak,
                 lpp_qtyrepack,
                 lpp_rphrepack,
                 lpp_qtylainin,
                 lpp_rphlainin,
                 lpp_qtysales,
                 lpp_rphsales,
                 lpp_qtykirim,
                 lpp_rphkirim,
                 lpp_qtyprepacking,
                 lpp_rphprepacking,
                 lpp_qtyhilang,
                 lpp_rphhilang,
                 lpp_qtylainout,
                 lpp_rphlainout,
                 lpp_qtyintransit,
                 lpp_rphintransit,
                 lpp_qtyadj,
                 lpp_rphadj,
                 lpp_soadj,
                 (NVL (lpp_rphadj, 0) + NVL (lpp_soadj, 0)) adj,
                 NVL (lpp_qtyakhir, 0) lpp_qtyakhir,
                 NVL (lpp_rphakhir, 0) lpp_rphakhir,
                 NVL (lpp_qty_selisih_so, 0) lpp_qty_selisih_so,
                 NVL (lpp_rph_selisih_so, 0) lpp_rph_selisih_so,
                 NVL (lpp_qty_selisih_soic, 0) lpp_qty_selisih_soic,
                 NVL (lpp_rph_selisih_soic, 0) lpp_rph_selisih_soic,
                   NVL (lpp_rphakhir, 0)
                 - (  NVL (lpp_rphbegbal, 0)
                    + NVL (lpp_rphbeli, 0)
                    + NVL (lpp_rphbonus, 0)
                    + NVL (lpp_rphtrmcb, 0)
                    + NVL (lpp_rphretursales, 0)
                    + NVL (lpp_rph_selisih_so, 0)
                    + NVL (lpp_rph_selisih_soic, 0)
                    + NVL (lpp_rphrepack, 0)
                    + NVL (lpp_rphlainin, 0)
                    - NVL (lpp_rphrafak, 0)
                    - NVL (lpp_rphsales, 0)
                    - NVL (lpp_rphkirim, 0)
                    - NVL (lpp_rphprepacking, 0)
                    - NVL (lpp_rphhilang, 0)
                    - NVL (lpp_rphlainout, 0)
                    + NVL (lpp_rphintransit, 0)
                    + NVL (lpp_rphadj, 0)
                    + NVL (lpp_soadj, 0))
                    sadj,
                 lpp_supplierservq,
                 lpp_tokoservq,
                 lpp_avgcost1,
                 lpp_avgcost,
                   NVL (lpp_qtyakhir, 0)
                 - NVL (lpp_supplierservq, 0)
                 - NVL (lpp_tokoservq, 0)
                    saldotoko,
                 prs_namaperusahaan,
                 prs_namacabang,
                 prs_namawilayah
            FROM tbtr_lpp,
                 tbmaster_prodmast,
                 tbmaster_divisi,
                 tbmaster_departement,
                 tbmaster_kategori,
                 tbmaster_perusahaan
           WHERE lpp_kodeigr = " . Session::get('kdigr') . "
        AND lpp_tgl1 >= to_date('" . $tgl1 . "','dd/mm/yyyy')
        AND lpp_tgl2 <= to_date('" . $tgl2 . "','dd/mm/yyyy')
        AND prd_kodeigr(+) = lpp_kodeigr
        AND prd_prdcd(+) = lpp_prdcd
        AND div_kodeigr(+) = lpp_kodeigr
        AND div_kodedivisi(+) = lpp_kodedivisi
        AND dep_kodeigr(+) = lpp_kodeigr
        AND dep_kodedivisi(+) = lpp_kodedivisi
        AND dep_kodedepartement(+) = lpp_kodedepartemen
        " . $and_dep . "
        AND kat_kodeigr(+) = lpp_kodeigr
        AND kat_kodedepartement(+) = lpp_kodedepartemen
        AND kat_kodekategori(+) = lpp_kategoribrg
        " . $and_kat . "
        AND prs_kodeigr = lpp_kodeigr
                " . $and_plu . " )
GROUP BY lpp_kodedivisi,
         div_namadivisi,
         lpp_kodedepartemen,
         dep_namadepartement,
         lpp_kategoribrg,
         kat_namakategori,
         lpp_prdcd,
         prd_deskripsipanjang,
         kemasan,
         judul,
         prs_namaperusahaan,
         prs_namacabang,
         prs_namawilayah
ORDER BY lpp_kodedivisi,
         lpp_kodedepartemen,
         lpp_kategoribrg,
         lpp_prdcd");
            set_time_limit(0);
            $title = '** POSISI & MUTASI PERSEDIAAN BARANG BAIK **';

//            $pdf = PDF::loadview('BACKOFFICE.LPP.' . $repid,compact(['title', 'perusahaan', 'data', 'tgl1', 'tgl2']));
//            $pdf->setPaper('A4', 'landscape');
//            $pdf->output();
//            $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);

//            $canvas = $dompdf ->get_canvas();
//            $canvas->page_text(465, 77, "{PAGE_NUM} / {PAGE_COUNT}", null, 8, array(0, 0, 0));
//            $dompdf->render();

//            return $pdf->download('laporan2.pdf');

//            dom
//            $pdf = PDF::loadView('BACKOFFICE.LPP.' . $repid,compact(['title', 'perusahaan', 'data', 'tgl1', 'tgl2']));
//            return $pdf->stream('test.pdf');


//            $view = \View::make('BACKOFFICE.LPP.' . $repid,compact(['title', 'perusahaan', 'data', 'tgl1', 'tgl2']));
//            $html = $view->render();
//
//            $pdf = new TCPDF();
//            $pdf::SetTitle('Hello World');
//            $pdf::AddPage();
//            $pdf::writeHTML($html, true, false, true, false, '');
//            $pdf::Output('hello_world.pdf');
//return 'oke';



            //excel
            $filename = 'aa.xlsx';
            $view = view('BACKOFFICE.LPP.' . $repid . '_xlxs', compact(['title', 'perusahaan', 'data', 'tgl1', 'tgl2']))->render();
            $maxColumn = 'U';
            $subtitle = 'RINCIAN PER DIVISI (UNIT/RUPIAH)';
            $this->createExcel($view,$filename,$maxColumn,$title,$subtitle);

            return response()->download(storage_path($filename))->deleteFileAfterSend(true);

//html
//            return view('BACKOFFICE.LPP.' . $repid.'_xlxs', compact(['title', 'perusahaan', 'data', 'tgl1', 'tgl2']));
            return view('BACKOFFICE.LPP.' . $repid, compact(['title', 'perusahaan', 'data', 'tgl1', 'tgl2']));


//csv
//            $filename = 'LAPORAN EVALUASI SALES MEMBER.csv';

//            $columnHeader = [
//                'SALDO AWAL',
//                'MURNI',
//                'BONUS',
//                'TRANSFER IN',
//                'RETUR PENJUALAN',
//                'REPACK IN (REPACK)',
//                'LAIN-LAIN',
//                'PENJUALAN',
//                'TRANSFER OUT',
//                'REPACK OUT (PREPACK)',
//                'HILANG',
//                'LAIN-LAIN',
//                'SO',
//                'INTRANSIT',
//                'PENYESUAIAN',
//                'KOREKSI',
//                'SALDO AKHIR',
//                'GUDANG-X SRV. SUP',
//                'SERV TOKO',
//                'SALDO TOKO',
//            ];
//
//            $linebuffs = array();
//
//            for ($i = 0; $i < 2;$i++){
//                foreach ($data as $d) {
//                    $tempdata = [
//                        $d->sawalqty,
//                        $d->beliqty,
//                        $d->bonusqty,
//                        $d->trmcbqty,
//                        $d->retursalesqty,
//                        $d->repackqty,
//                        $d->laininqty,
//                        $d->salesqty,
//                        $d->kirimqty,
//                        $d->prepackqty,
//                        $d->hilangqty,
//                        $d->lainoutqty,
//                        $d->rph_sel_so,
//                        $d->intrstqty,
//                        $d->adjqty,
//                        0,
//                        $d->akhirqty,
//                        $d->servqsup,
//                        $d->servqtok,
//                        $d->saldotoko,
//                    ];
//
//                    array_push($linebuffs, $tempdata);
//                }
//            }
//            return [
//                (new DownloadExcel)->withHeadings('#', 'Name', 'E-mail'),
//            ];
//            $headers = [
//                "Content-type" => "text/csv",
//                "Pragma" => "no-cache",
//                "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
//                "Expires" => "0"
//            ];
//
//            $file = fopen(storage_path($filename), 'w');
//
//            fputcsv($file, $columnHeader, '|');
//            foreach ($linebuffs as $linebuff) {
//                fputcsv($file, $linebuff, '|');
//            }
//            fclose($file);
//
//            return response()->download(storage_path($filename))->deleteFileAfterSend(true);

        } else if ($menu == 'LPP03') {
            $p_prog = 'LPP03';
            $repid = 'RPT_LPP03';
            $rep_name = 'IGR_BO_LPPBAIKRCDDK.jsp';

            $data = DB::connection(Session::get('connection'))->select("SELECT lpp_kodedivisi, div_namadivisi,
        lpp_kodedepartemen, dep_namadepartement,
        lpp_kategoribrg, kat_namakategori, lpp_prdcd, prd_deskripsipanjang, kemasan,
        judul, prs_namaperusahaan, prs_namacabang, prs_namawilayah,
        SUM(lpp_qtybegbal) sawalqty, SUM(lpp_rphbegbal) sawalrph, SUM(lpp_qtybeli) beliqty,
        SUM(lpp_rphbeli) belirph, SUM(lpp_qtybonus) bonusqty, SUM(lpp_rphbonus) bonusrph,
        SUM(lpp_qtytrmcb) trmcbqty, SUM(lpp_rphtrmcb) trmcbrph, SUM(lpp_qtyretursales) retursalesqty,
        SUM(lpp_rphretursales) retursalesrph, SUM(lpp_rphrafak) rafakrph, SUM(lpp_qtyrepack) repackqty,
        SUM(lpp_rphrepack) repackrph, SUM(lpp_qtylainin) laininqty, SUM(lpp_rphlainin) laininrph,
        SUM(lpp_qtysales) salesqty, SUM(lpp_rphsales) salesrph, SUM(lpp_qtykirim) kirimqty, SUM(lpp_rphkirim) kirimrph,
        SUM(lpp_qtyprepacking) prepackqty, SUM(lpp_rphprepacking) prepackrph, SUM(lpp_qtyhilang) hilangqty,
        SUM(lpp_rphhilang) hilangrph, SUM(lpp_qtylainout) lainoutqty, SUM(lpp_rphlainout) lainoutrph, SUM(lpp_qtyintransit) intrstqty,
        SUM(lpp_rphintransit) intrstrph, SUM(lpp_qtyadj) adjqty, SUM(lpp_rphadj) adjrph, SUM(adj) adj, SUM(sadj) sadj,
        SUM(lpp_qtyakhir) akhirqty, SUM(lpp_rphakhir) akhirrph, SUM(lpp_supplierservq) servqsup, SUM(lpp_tokoservq) servqtok, SUM(saldotoko) saldotoko
FROM (SELECT lpp_kodedivisi, div_namadivisi, lpp_kodedepartemen, dep_namadepartement,
        lpp_kategoribrg, kat_namakategori, lpp_prdcd, prd_deskripsipanjang, prd_unit||'/'||prd_frac kemasan,
        CASE WHEN " . $tipe . " = '1' then 'POSISI & MUTASI PERSEDIAAN BARANG BAIK (MINUS)' ELSE
        CASE WHEN " . $tipe . " = '2' then 'POSISI & MUTASI PERSEDIAAN BARANG BAIK (PLUS)' ELSE
        ' POSISI & MUTASI PERSEDIAAN BARANG BAIK' END
        END judul,
        lpp_qtybegbal, lpp_rphbegbal, lpp_qtybeli, lpp_rphbeli, lpp_qtybonus, lpp_rphbonus,
        lpp_qtytrmcb, lpp_rphtrmcb, lpp_qtyretursales, lpp_rphretursales, lpp_rphrafak, lpp_qtyrepack, lpp_rphrepack,
        lpp_qtylainin, lpp_rphlainin, lpp_qtysales, lpp_rphsales, lpp_qtykirim, lpp_rphkirim, lpp_qtyprepacking, lpp_rphprepacking,
        lpp_qtyhilang, lpp_rphhilang, lpp_qtylainout, lpp_rphlainout, lpp_qtyintransit, lpp_rphintransit, lpp_qtyadj, lpp_rphadj, lpp_soadj,
        (NVL(lpp_rphadj,0) + NVL(lpp_soadj,0)) adj, NVL(lpp_qtyakhir,0) lpp_qtyakhir, NVL(lpp_rphakhir,0) lpp_rphakhir,
        NVL(lpp_rphakhir,0) - (NVL(lpp_rphbegbal,0) + NVL(lpp_rphbeli,0) + NVL(lpp_rphbonus,0) + NVL(lpp_rphtrmcb,0) + NVL(lpp_rphretursales,0) +
        NVL(lpp_rphrepack,0) + NVL(lpp_rphlainin,0) - NVL(lpp_rphrafak,0) - NVL(lpp_rphsales,0) - NVL(lpp_rphkirim,0) - NVL(lpp_rphprepacking,0) -
        NVL(lpp_rphhilang,0) - NVL(lpp_rphlainout,0) + NVL(lpp_rphintransit,0) + NVL(lpp_rphadj, 0) + NVL(lpp_soadj, 0)) sadj,
        lpp_supplierservq, lpp_tokoservq, lpp_avgcost1, lpp_avgcost, NVL(lpp_qtyakhir,0)-NVL(lpp_supplierservq,0)-NVL(lpp_tokoservq,0) saldotoko,
        prs_namaperusahaan, prs_namacabang, prs_namawilayah
FROM tbtr_lpp, tbmaster_prodmast, tbmaster_divisi,
        tbmaster_departement,tbmaster_kategori, tbmaster_perusahaan
WHERE lpp_kodeigr = " . Session::get('kdigr') . "
        AND lpp_tgl1 >= to_date('" . $tgl1 . "','dd/mm/yyyy')
        AND lpp_tgl2 <= to_date('" . $tgl2 . "','dd/mm/yyyy')
        AND prd_kodeigr(+) = lpp_kodeigr
        AND prd_prdcd(+) = lpp_prdcd
        AND div_kodeigr(+) = lpp_kodeigr
        AND div_kodedivisi(+) = lpp_kodedivisi
        AND dep_kodeigr(+) = lpp_kodeigr
        AND dep_kodedivisi(+) = lpp_kodedivisi
        AND dep_kodedepartement(+) = lpp_kodedepartemen
        " . $and_dep . "
        AND kat_kodeigr(+) = lpp_kodeigr
        AND kat_kodedepartement(+) = lpp_kodedepartemen
        AND kat_kodekategori(+) = lpp_kategoribrg
        " . $and_kat . "
        " . $and_tipe . "
        " . $and_plu . "
        AND prs_kodeigr = lpp_kodeigr
        ORDER BY div_kodedivisi, dep_kodedepartement, kat_kodekategori, lpp_prdcd)
GROUP BY lpp_kodedivisi, div_namadivisi,
        lpp_kodedepartemen, dep_namadepartement,
        lpp_kategoribrg, kat_namakategori,
        lpp_prdcd, prd_deskripsipanjang, kemasan, judul,
        prs_namaperusahaan, prs_namacabang, prs_namawilayah
ORDER BY lpp_kodedivisi, lpp_kodedepartemen, lpp_kategoribrg, lpp_prdcd");

            $title = '** POSISI & MUTASI PERSEDIAAN BARANG BAIK **';
            return view('BACKOFFICE.LPP.' . $repid, compact(['title', 'perusahaan', 'data', 'tgl1', 'tgl2']));
        } else if ($menu == 'LPP04') {
            $p_prog = 'LPP04';
            $repid = 'RPT_LPP04';
            $rep_name = 'IGR_BO_LPPBAIKRCPPB.jsp';


            $data = DB::connection(Session::get('connection'))
                ->select("SELECT lpp_kodedivisi, div_namadivisi,
        lpp_kodedepartemen, dep_namadepartement,
        lpp_kategoribrg, kat_namakategori, lpp_prdcd, prd_deskripsipanjang, kemasan,
        judul, prs_namaperusahaan, prs_namacabang, prs_namawilayah,
        SUM(lpp_qtybegbal) sawalqty, SUM(lpp_rphbegbal) sawalrph, SUM(lpp_qtybeli) beliqty,
        SUM(lpp_rphbeli) belirph, SUM(lpp_qtybonus) bonusqty, SUM(lpp_rphbonus) bonusrph,
        SUM(lpp_qtytrmcb) trmcbqty, SUM(lpp_rphtrmcb) trmcbrph, SUM(lpp_qtyretursales) retursalesqty,
        SUM(lpp_rphretursales) retursalesrph, SUM(lpp_rphrafak) rafakrph, SUM(lpp_qtyrepack) repackqty,
        SUM(lpp_rphrepack) repackrph, SUM(lpp_qtylainin) laininqty, SUM(lpp_rphlainin) laininrph,
        SUM(lpp_qtysales) salesqty, SUM(lpp_rphsales) salesrph, SUM(lpp_qtykirim) kirimqty, SUM(lpp_rphkirim) kirimrph,
        SUM(lpp_qtyprepacking) prepackqty, SUM(lpp_rphprepacking) prepackrph, SUM(lpp_qtyhilang) hilangqty,
        SUM(lpp_rphhilang) hilangrph, SUM(lpp_qtylainout) lainoutqty, SUM(lpp_rphlainout) lainoutrph, SUM(lpp_qtyintransit) intrstqty,
        SUM(lpp_rphintransit) intrstrph, SUM(lpp_qtyadj) adjqty, SUM(lpp_rphadj) adjrph, SUM(adj) adj, SUM(sadj) sadj, SUM(lpp_qty_selisih_so) sel_so, SUM(lpp_rph_selisih_so) rph_sel_so,
        SUM(lpp_qtyakhir) akhirqty, SUM(lpp_rphakhir) akhirrph, SUM(lpp_supplierservq) servqsup, SUM(lpp_tokoservq) servqtok, SUM(saldotoko) saldotoko
FROM (SELECT lpp_kodedivisi, div_namadivisi, lpp_kodedepartemen, dep_namadepartement,
        lpp_kategoribrg, kat_namakategori, lpp_prdcd, prd_deskripsipanjang, prd_unit||'/'||prd_frac kemasan,
        CASE WHEN " . $tipe . " = '1' then 'LPP RINCIAN PRODUK YG TERDAPAT PENYESUAIAN BARANG BAIK (MINUS)' ELSE
        CASE WHEN " . $tipe . " = '2' then 'LPP RINCIAN PRODUK YG TERDAPAT PENYESUAIAN BARANG BAIK (PLUS)' ELSE
        ' LPP RINCIAN PRODUK YG TERDAPAT PENYESUAIAN BARANG BAIK' END
        END judul,
        lpp_qtybegbal, lpp_rphbegbal, lpp_qtybeli, lpp_rphbeli, lpp_qtybonus, lpp_rphbonus,
        lpp_qtytrmcb, lpp_rphtrmcb, lpp_qtyretursales, lpp_rphretursales, lpp_rphrafak, lpp_qtyrepack, lpp_rphrepack,
        lpp_qtylainin, lpp_rphlainin, lpp_qtysales, lpp_rphsales, lpp_qtykirim, lpp_rphkirim, lpp_qtyprepacking, lpp_rphprepacking,
        lpp_qtyhilang, lpp_rphhilang, lpp_qtylainout, lpp_rphlainout, lpp_qtyintransit, lpp_rphintransit, lpp_qtyadj, lpp_rphadj, lpp_soadj,
        (NVL(lpp_rphadj,0) + NVL(lpp_soadj,0)) adj, NVL(lpp_qtyakhir,0) lpp_qtyakhir, NVL(lpp_rphakhir,0) lpp_rphakhir,
        NVL(lpp_rphakhir,0) - (NVL(lpp_rphbegbal,0) + NVL(lpp_rphbeli,0) + NVL(lpp_rphbonus,0) + NVL(lpp_rphtrmcb,0) + NVL(lpp_rphretursales,0) +
        NVL(lpp_rphrepack,0) + NVL(lpp_rphlainin,0) - NVL(lpp_rphrafak,0) - NVL(lpp_rphsales,0) - NVL(lpp_rphkirim,0) - NVL(lpp_rphprepacking,0) -
        NVL(lpp_rphhilang,0) - NVL(lpp_rphlainout,0) + NVL(lpp_rphintransit,0) + NVL(lpp_rph_selisih_so, 0)  + NVL(lpp_rphadj, 0) + NVL(lpp_soadj, 0)) sadj,  NVL(lpp_qty_selisih_so, 0) lpp_qty_selisih_so, NVL(lpp_rph_selisih_so, 0) lpp_rph_selisih_so,
        lpp_supplierservq, lpp_tokoservq, lpp_avgcost1, lpp_avgcost, NVL(lpp_qtyakhir,0)-NVL(lpp_supplierservq,0)-NVL(lpp_tokoservq,0) saldotoko,
        prs_namaperusahaan, prs_namacabang, prs_namawilayah
FROM tbtr_lpp, tbmaster_prodmast, tbmaster_divisi,
        tbmaster_departement,tbmaster_kategori, tbmaster_perusahaan
WHERE lpp_kodeigr = " . Session::get('kdigr') . "
        AND lpp_tgl1 >= to_date('" . $tgl1 . "','dd/mm/yyyy')
        AND lpp_tgl2 <= to_date('" . $tgl2 . "','dd/mm/yyyy')
        AND (lpp_qtyadj <> 0 OR lpp_rphadj <> 0)
        AND prd_kodeigr(+) = lpp_kodeigr
        AND prd_prdcd(+) = lpp_prdcd
        AND div_kodeigr(+) = lpp_kodeigr
        AND div_kodedivisi(+) = lpp_kodedivisi
        AND dep_kodeigr(+) = lpp_kodeigr
        AND dep_kodedivisi(+) = lpp_kodedivisi
        AND dep_kodedepartement(+) = lpp_kodedepartemen
        " . $and_dep . "
        AND kat_kodeigr(+) = lpp_kodeigr
        AND kat_kodedepartement(+) = lpp_kodedepartemen
        AND kat_kodekategori(+) = lpp_kategoribrg
         " . $and_kat . "
        AND prs_kodeigr = lpp_kodeigr
        " . $and_tipe . "
        ORDER BY div_kodedivisi, dep_kodedepartement, kat_kodekategori, lpp_prdcd)
GROUP BY lpp_kodedivisi, div_namadivisi,
        lpp_kodedepartemen, dep_namadepartement,
        lpp_kategoribrg, kat_namakategori,
        lpp_prdcd, prd_deskripsipanjang, kemasan, judul,
        prs_namaperusahaan, prs_namacabang, prs_namawilayah
ORDER BY lpp_kodedivisi, lpp_kodedepartemen, lpp_kategoribrg, lpp_prdcd");

            $title = '';
            return view('BACKOFFICE.LPP.' . $repid, compact(['title', 'perusahaan', 'data', 'tgl1', 'tgl2']));
        } else if ($menu == 'LPP05') {
            $p_prog = 'LPP05';
            $title = '';
            $data = '';

            if (trim($tipe) == '1') {
                $repid = 'RPT_LPP05A';
                $rep_name = 'IGR_BO_LPPBAIKPKOR_MIN.jsp';
                $title = 'LPP RINCIAN PRODUK YG TERDAPAT KOREKSI BARANG BAIK (MINUS)';

                $data = DB::connection(Session::get('connection'))->select("SELECT   A.*
    FROM (SELECT LPP_KODEDIVISI, DIV_NAMADIVISI, LPP_KODEDEPARTEMEN, DEP_NAMADEPARTEMENT,
                 LPP_KATEGORIBRG, KAT_NAMAKATEGORI, LPP_PRDCD, PRD_DESKRIPSIPANJANG,
                 PRD_UNIT || '/' || PRD_FRAC KEMASAN, LPP_QTYBEGBAL, LPP_RPHBEGBAL, LPP_QTYBELI,
                 LPP_RPHBELI, LPP_QTYBONUS, LPP_RPHBONUS, LPP_QTYTRMCB, LPP_RPHTRMCB,
                 LPP_QTYRETURSALES, LPP_RPHRETURSALES, LPP_RPHRAFAK, LPP_QTYREPACK, LPP_RPHREPACK,
                 LPP_QTYLAININ, LPP_RPHLAININ, LPP_QTYSALES, LPP_RPHSALES, LPP_QTYKIRIM,
                 LPP_RPHKIRIM, LPP_QTYPREPACKING, LPP_RPHPREPACKING, LPP_QTYHILANG, LPP_RPHHILANG,
                 LPP_QTYLAINOUT, LPP_RPHLAINOUT, LPP_QTYINTRANSIT, LPP_RPHINTRANSIT, LPP_QTYADJ,
                 LPP_RPHADJ, LPP_SOADJ, (NVL (LPP_RPHADJ, 0) + NVL (LPP_SOADJ, 0)) ADJ,
                 NVL (LPP_QTYAKHIR, 0) LPP_QTYAKHIR, NVL (LPP_RPHAKHIR, 0) LPP_RPHAKHIR, (NVL(lpp_qty_selisih_so, 0) + NVL(lpp_qty_selisih_soic, 0)) lpp_qty_selisih_so, (NVL(lpp_rph_selisih_so, 0) + NVL(lpp_rph_selisih_soic, 0)) lpp_rph_selisih_so,
                   NVL (LPP_RPHAKHIR, 0)
                 - (  NVL (LPP_RPHBEGBAL, 0)
                    + NVL (LPP_RPHBELI, 0)
                    + NVL (LPP_RPHBONUS, 0)
                    + NVL (LPP_RPHTRMCB, 0)
                    + NVL (LPP_RPHRETURSALES, 0)
                    + NVL (LPP_RPHREPACK, 0)
                    + NVL (LPP_RPHLAININ, 0)
                    - NVL (LPP_RPHRAFAK, 0)
                    - NVL (LPP_RPHSALES, 0)
                    - NVL (LPP_RPHKIRIM, 0)
                    - NVL (LPP_RPHPREPACKING, 0)
                    - NVL (LPP_RPHHILANG, 0)
                    - NVL (LPP_RPHLAINOUT, 0)
                    + NVL (LPP_RPHINTRANSIT, 0)
                    + NVL (LPP_RPHADJ, 0)
                    + NVL (LPP_SOADJ, 0)
                   ) SADJ,
                 (  NVL (LPP_RPHAKHIR, 0)
                  - (  NVL (LPP_RPHBEGBAL, 0)
                     + NVL (LPP_RPHBELI, 0)
                     + NVL (LPP_RPHBONUS, 0)
                     + NVL (LPP_RPHTRMCB, 0)
                     + NVL (LPP_RPHRETURSALES, 0)
                     + NVL (LPP_RPHREPACK, 0)
                     + NVL (LPP_RPHLAININ, 0)
                     - NVL (LPP_RPHRAFAK, 0)
                     - NVL (LPP_RPHSALES, 0)
                     - NVL (LPP_RPHKIRIM, 0)
                     - NVL (LPP_RPHPREPACKING, 0)
                     - NVL (LPP_RPHHILANG, 0)
                     - NVL (LPP_RPHLAINOUT, 0)
                     + NVL (LPP_RPHINTRANSIT, 0)
                     + NVL (LPP_RPHADJ, 0)
                     + NVL(lpp_rph_selisih_so, 0)  + NVL(lpp_rph_selisih_soic, 0)
                     + NVL (LPP_SOADJ, 0)
                    )
                 ) KOREKSI,
                 LPP_SUPPLIERSERVQ, LPP_TOKOSERVQ, LPP_AVGCOST1, LPP_AVGCOST,
                   NVL (LPP_QTYAKHIR, 0)
                 - NVL (LPP_SUPPLIERSERVQ, 0)
                 - NVL (LPP_TOKOSERVQ, 0) SALDOTOKO, PRS_NAMAPERUSAHAAN, PRS_NAMACABANG,
                 PRS_NAMAWILAYAH
            FROM TBTR_LPP,
                 TBMASTER_PRODMAST,
                 TBMASTER_DIVISI,
                 TBMASTER_DEPARTEMENT,
                 TBMASTER_KATEGORI,
                 TBMASTER_PERUSAHAAN
           WHERE LPP_KODEIGR = " . Session::get('kdigr') . "
             AND LPP_TGL1 >= to_date('" . $tgl1 . "','dd/mm/yyyy')
             AND LPP_TGL2 <= to_date('" . $tgl2 . "','dd/mm/yyyy')
             AND PRD_KODEIGR(+) = LPP_KODEIGR
             AND PRD_PRDCD(+) = LPP_PRDCD
             AND DIV_KODEIGR(+) = LPP_KODEIGR
             AND DIV_KODEDIVISI(+) = LPP_KODEDIVISI
             " . $and_dep . "
             AND DEP_KODEIGR(+) = LPP_KODEIGR
             AND DEP_KODEDIVISI(+) = LPP_KODEDIVISI
             AND DEP_KODEDEPARTEMENT(+) = LPP_KODEDEPARTEMEN
             " . $and_kat . "
             AND KAT_KODEIGR(+) = LPP_KODEIGR
             AND KAT_KODEDEPARTEMENT(+) = LPP_KODEDEPARTEMEN
             AND KAT_KODEKATEGORI(+) = LPP_KATEGORIBRG
             AND PRS_KODEIGR = LPP_KODEIGR
             AND (  NVL (LPP_RPHAKHIR, 0)
                  - (  NVL (LPP_RPHBEGBAL, 0)
                     + NVL (LPP_RPHBELI, 0)
                     + NVL (LPP_RPHBONUS, 0)
                     + NVL (LPP_RPHTRMCB, 0)
                     + NVL (LPP_RPHRETURSALES, 0)
                     + NVL (LPP_RPHREPACK, 0)
                     + NVL (LPP_RPHLAININ, 0)
                     - NVL (LPP_RPHRAFAK, 0)
                     - NVL (LPP_RPHSALES, 0)
                     - NVL (LPP_RPHKIRIM, 0)
                     - NVL (LPP_RPHPREPACKING, 0)
                     - NVL (LPP_RPHHILANG, 0)
                     - NVL (LPP_RPHLAINOUT, 0)
                     + NVL (LPP_RPHINTRANSIT, 0)
                     + NVL (LPP_RPHADJ, 0)
                     + NVL(lpp_rph_selisih_so, 0)
                     + NVL (LPP_SOADJ, 0)
                    )
                 ) < 0
	 ORDER BY KOREKSI ASC) A
WHERE ROWNUM <= " . $banyakitem . "
ORDER BY lpp_kodedivisi, lpp_kodedepartemen, lpp_kategoribrg, lpp_prdcd");

            } else if (trim($tipe) == '2') {
//                $repid = 'RPT_LPP05B';
                $repid = 'RPT_LPP05A';
                $rep_name = 'IGR_BO_LPPBAIKPKOR_PLUS.jsp';

                $title = 'LPP RINCIAN PRODUK YG TERDAPAT KOREKSI BARANG BAIK (PLUS)';

                $data = DB::connection(Session::get('connection'))->select("SELECT   A.*
    FROM (SELECT LPP_KODEDIVISI, DIV_NAMADIVISI, LPP_KODEDEPARTEMEN, DEP_NAMADEPARTEMENT,
                 LPP_KATEGORIBRG, KAT_NAMAKATEGORI, LPP_PRDCD, PRD_DESKRIPSIPANJANG,
                 PRD_UNIT || '/' || PRD_FRAC KEMASAN, LPP_QTYBEGBAL, LPP_RPHBEGBAL, LPP_QTYBELI,
                 LPP_RPHBELI, LPP_QTYBONUS, LPP_RPHBONUS, LPP_QTYTRMCB, LPP_RPHTRMCB,
                 LPP_QTYRETURSALES, LPP_RPHRETURSALES, LPP_RPHRAFAK, LPP_QTYREPACK, LPP_RPHREPACK,
                 LPP_QTYLAININ, LPP_RPHLAININ, LPP_QTYSALES, LPP_RPHSALES, LPP_QTYKIRIM,
                 LPP_RPHKIRIM, LPP_QTYPREPACKING, LPP_RPHPREPACKING, LPP_QTYHILANG, LPP_RPHHILANG,
                 LPP_QTYLAINOUT, LPP_RPHLAINOUT, LPP_QTYINTRANSIT, LPP_RPHINTRANSIT, LPP_QTYADJ,
                 LPP_RPHADJ, LPP_SOADJ, (NVL (LPP_RPHADJ, 0) + NVL (LPP_SOADJ, 0)) ADJ, (NVL(lpp_qty_selisih_so, 0) + NVL(lpp_qty_selisih_soic, 0)) lpp_qty_selisih_so, (NVL(lpp_rph_selisih_so, 0) + NVL(lpp_rph_selisih_soic, 0)) lpp_rph_selisih_so,
                 NVL (LPP_QTYAKHIR, 0) LPP_QTYAKHIR, NVL (LPP_RPHAKHIR, 0) LPP_RPHAKHIR,
                   NVL (LPP_RPHAKHIR, 0)
                 - (  NVL (LPP_RPHBEGBAL, 0)
                    + NVL (LPP_RPHBELI, 0)
                    + NVL (LPP_RPHBONUS, 0)
                    + NVL (LPP_RPHTRMCB, 0)
                    + NVL (LPP_RPHRETURSALES, 0)
                    + NVL (LPP_RPHREPACK, 0)
                    + NVL (LPP_RPHLAININ, 0)
                    - NVL (LPP_RPHRAFAK, 0)
                    - NVL (LPP_RPHSALES, 0)
                    - NVL (LPP_RPHKIRIM, 0)
                    - NVL (LPP_RPHPREPACKING, 0)
                    - NVL (LPP_RPHHILANG, 0)
                    - NVL (LPP_RPHLAINOUT, 0)
                    + NVL (LPP_RPHINTRANSIT, 0)
                    + NVL (LPP_RPHADJ, 0)
                    + NVL (LPP_SOADJ, 0)
                   ) SADJ,
                 (  NVL (LPP_RPHAKHIR, 0)
                  - (  NVL (LPP_RPHBEGBAL, 0)
                     + NVL (LPP_RPHBELI, 0)
                     + NVL (LPP_RPHBONUS, 0)
                     + NVL (LPP_RPHTRMCB, 0)
                     + NVL (LPP_RPHRETURSALES, 0)
                     + NVL (LPP_RPHREPACK, 0)
                     + NVL (LPP_RPHLAININ, 0)
                     - NVL (LPP_RPHRAFAK, 0)
                     - NVL (LPP_RPHSALES, 0)
                     - NVL (LPP_RPHKIRIM, 0)
                     - NVL (LPP_RPHPREPACKING, 0)
                     - NVL (LPP_RPHHILANG, 0)
                     - NVL (LPP_RPHLAINOUT, 0)
                     + NVL (LPP_RPHINTRANSIT, 0)
                     + NVL (LPP_RPHADJ, 0)
                     + NVL(lpp_rph_selisih_so, 0)  + NVL(lpp_rph_selisih_soic, 0)
                     + NVL (LPP_SOADJ, 0)
                    )
                 ) KOREKSI,
                 LPP_SUPPLIERSERVQ, LPP_TOKOSERVQ, LPP_AVGCOST1, LPP_AVGCOST,
                   NVL (LPP_QTYAKHIR, 0)
                 - NVL (LPP_SUPPLIERSERVQ, 0)
                 - NVL (LPP_TOKOSERVQ, 0) SALDOTOKO, PRS_NAMAPERUSAHAAN, PRS_NAMACABANG,
                 PRS_NAMAWILAYAH
            FROM TBTR_LPP,
                 TBMASTER_PRODMAST,
                 TBMASTER_DIVISI,
                 TBMASTER_DEPARTEMENT,
                 TBMASTER_KATEGORI,
                 TBMASTER_PERUSAHAAN
           WHERE LPP_KODEIGR = " . Session::get('kdigr') . "
             AND LPP_TGL1 >= to_date('" . $tgl1 . "','dd/mm/yyyy')
             AND LPP_TGL2 <= to_date('" . $tgl2 . "','dd/mm/yyyy')
             AND PRD_KODEIGR(+) = LPP_KODEIGR
             AND PRD_PRDCD(+) = LPP_PRDCD
             AND DIV_KODEIGR(+) = LPP_KODEIGR
             AND DIV_KODEDIVISI(+) = LPP_KODEDIVISI
             AND DEP_KODEIGR(+) = LPP_KODEIGR
             AND DEP_KODEDIVISI(+) = LPP_KODEDIVISI
             AND DEP_KODEDEPARTEMENT(+) = LPP_KODEDEPARTEMEN
             " . $and_dep . "
             AND KAT_KODEIGR(+) = LPP_KODEIGR
             AND KAT_KODEDEPARTEMENT(+) = LPP_KODEDEPARTEMEN
             AND KAT_KODEKATEGORI(+) = LPP_KATEGORIBRG
              " . $and_kat . "
             AND PRS_KODEIGR = LPP_KODEIGR
             AND (  NVL (LPP_RPHAKHIR, 0)
                  - (  NVL (LPP_RPHBEGBAL, 0)
                     + NVL (LPP_RPHBELI, 0)
                     + NVL (LPP_RPHBONUS, 0)
                     + NVL (LPP_RPHTRMCB, 0)
                     + NVL (LPP_RPHRETURSALES, 0)
                     + NVL (LPP_RPHREPACK, 0)
                     + NVL (LPP_RPHLAININ, 0)
                     - NVL (LPP_RPHRAFAK, 0)
                     - NVL (LPP_RPHSALES, 0)
                     - NVL (LPP_RPHKIRIM, 0)
                     - NVL (LPP_RPHPREPACKING, 0)
                     - NVL (LPP_RPHHILANG, 0)
                     - NVL (LPP_RPHLAINOUT, 0)
                     + NVL (LPP_RPHINTRANSIT, 0)
                     + NVL (LPP_RPHADJ, 0)
                     + NVL (LPP_SOADJ, 0)
                    )
                 ) > 0
	 ORDER BY KOREKSI DESC) A
WHERE ROWNUM <= " . $banyakitem . "
ORDER BY lpp_kodedivisi, lpp_kodedepartemen, lpp_kategoribrg, lpp_prdcd");
            } else {
//                $repid = 'RPT_LPP05C';
                $repid = 'RPT_LPP05A';
                $rep_name = 'IGR_BO_LPPBAIKPKOR.jsp';

                $title = 'LPP RINCIAN PRODUK YG TERDAPAT KOREKSI BARANG BAIK';

                $data = DB::connection(Session::get('connection'))->select("SELECT   A.*
    FROM (SELECT LPP_KODEDIVISI, DIV_NAMADIVISI, LPP_KODEDEPARTEMEN, DEP_NAMADEPARTEMENT,
                 LPP_KATEGORIBRG, KAT_NAMAKATEGORI, LPP_PRDCD, PRD_DESKRIPSIPANJANG,
                 PRD_UNIT || '/' || PRD_FRAC KEMASAN, LPP_QTYBEGBAL, LPP_RPHBEGBAL, LPP_QTYBELI,
                 LPP_RPHBELI, LPP_QTYBONUS, LPP_RPHBONUS, LPP_QTYTRMCB, LPP_RPHTRMCB,
                 LPP_QTYRETURSALES, LPP_RPHRETURSALES, LPP_RPHRAFAK, LPP_QTYREPACK, LPP_RPHREPACK,
                 LPP_QTYLAININ, LPP_RPHLAININ, LPP_QTYSALES, LPP_RPHSALES, LPP_QTYKIRIM,
                 LPP_RPHKIRIM, LPP_QTYPREPACKING, LPP_RPHPREPACKING, LPP_QTYHILANG, LPP_RPHHILANG,
                 LPP_QTYLAINOUT, LPP_RPHLAINOUT, LPP_QTYINTRANSIT, LPP_RPHINTRANSIT, LPP_QTYADJ,
                 LPP_RPHADJ, LPP_SOADJ, (NVL (LPP_RPHADJ, 0) + NVL (LPP_SOADJ, 0)) ADJ, (NVL(lpp_qty_selisih_so, 0) + NVL(lpp_qty_selisih_soic, 0))lpp_qty_selisih_so, (NVL(lpp_rph_selisih_so, 0) + NVL(lpp_rph_selisih_soic, 0) ) lpp_rph_selisih_so,
                 NVL (LPP_QTYAKHIR, 0) LPP_QTYAKHIR, NVL (LPP_RPHAKHIR, 0) LPP_RPHAKHIR,
                 (  NVL (LPP_RPHAKHIR, 0)
                  - (  NVL (LPP_RPHBEGBAL, 0)
                     + NVL (LPP_RPHBELI, 0)
                     + NVL (LPP_RPHBONUS, 0)
                     + NVL (LPP_RPHTRMCB, 0)
                     + NVL (LPP_RPHRETURSALES, 0)
                     + NVL (LPP_RPHREPACK, 0)
                     + NVL (LPP_RPHLAININ, 0)
                     - NVL (LPP_RPHRAFAK, 0)
                     - NVL (LPP_RPHSALES, 0)
                     - NVL (LPP_RPHKIRIM, 0)
                     - NVL (LPP_RPHPREPACKING, 0)
                     - NVL (LPP_RPHHILANG, 0)
                     - NVL (LPP_RPHLAINOUT, 0)
                     + NVL (LPP_RPHINTRANSIT, 0)
                     + NVL (LPP_RPHADJ, 0)
                     + NVL(lpp_rph_selisih_so, 0) + NVL(lpp_rph_selisih_soic, 0)
                     + NVL (LPP_SOADJ, 0)
                    )
                 ) KOREKSI,
                 LPP_SUPPLIERSERVQ, LPP_TOKOSERVQ, LPP_AVGCOST1, LPP_AVGCOST,
                   NVL (LPP_QTYAKHIR, 0)
                 - NVL (LPP_SUPPLIERSERVQ, 0)
                 - NVL (LPP_TOKOSERVQ, 0) SALDOTOKO, PRS_NAMAPERUSAHAAN, PRS_NAMACABANG,
                 PRS_NAMAWILAYAH
            FROM TBTR_LPP,
                 TBMASTER_PRODMAST,
                 TBMASTER_DIVISI,
                 TBMASTER_DEPARTEMENT,
                 TBMASTER_KATEGORI,
                 TBMASTER_PERUSAHAAN
           WHERE LPP_KODEIGR = '" . Session::get('kdigr') . "'
             AND LPP_TGL1 >= to_date('" . $tgl1 . "','dd/mm/yyyy')
             AND LPP_TGL2 <= to_date('" . $tgl2 . "','dd/mm/yyyy')
             AND PRD_KODEIGR(+) = LPP_KODEIGR
             AND PRD_PRDCD(+) = LPP_PRDCD
             AND DIV_KODEIGR(+) = LPP_KODEIGR
             AND DIV_KODEDIVISI(+) = LPP_KODEDIVISI
             " . $and_dep . "
             AND DEP_KODEIGR(+) = LPP_KODEIGR
             AND DEP_KODEDIVISI(+) = LPP_KODEDIVISI
             AND DEP_KODEDEPARTEMENT(+) = LPP_KODEDEPARTEMEN
             " . $and_kat . "
             AND KAT_KODEIGR(+) = LPP_KODEIGR
             AND KAT_KODEDEPARTEMENT(+) = LPP_KODEDEPARTEMEN
             AND KAT_KODEKATEGORI(+) = LPP_KATEGORIBRG
             AND PRS_KODEIGR = LPP_KODEIGR
             AND ((  NVL (LPP_RPHAKHIR, 0)
                  - (  NVL (LPP_RPHBEGBAL, 0)
                     + NVL (LPP_RPHBELI, 0)
                     + NVL (LPP_RPHBONUS, 0)
                     + NVL (LPP_RPHTRMCB, 0)
                     + NVL (LPP_RPHRETURSALES, 0)
                     + NVL (LPP_RPHREPACK, 0)
                     + NVL (LPP_RPHLAININ, 0)
                     - NVL (LPP_RPHRAFAK, 0)
                     - NVL (LPP_RPHSALES, 0)
                     - NVL (LPP_RPHKIRIM, 0)
                     - NVL (LPP_RPHPREPACKING, 0)
                     - NVL (LPP_RPHHILANG, 0)
                     - NVL (LPP_RPHLAINOUT, 0)
                     + NVL (LPP_RPHINTRANSIT, 0)
                     + NVL (LPP_RPHADJ, 0)
                     + NVL (LPP_SOADJ, 0)
                    )
                 ) < -0.5  OR
                     (  NVL (LPP_RPHAKHIR, 0)
                  - (  NVL (LPP_RPHBEGBAL, 0)
                     + NVL (LPP_RPHBELI, 0)
                     + NVL (LPP_RPHBONUS, 0)
                     + NVL (LPP_RPHTRMCB, 0)
                     + NVL (LPP_RPHRETURSALES, 0)
                     + NVL (LPP_RPHREPACK, 0)
                     + NVL (LPP_RPHLAININ, 0)
                     - NVL (LPP_RPHRAFAK, 0)
                     - NVL (LPP_RPHSALES, 0)
                     - NVL (LPP_RPHKIRIM, 0)
                     - NVL (LPP_RPHPREPACKING, 0)
                     - NVL (LPP_RPHHILANG, 0)
                     - NVL (LPP_RPHLAINOUT, 0)
                     + NVL (LPP_RPHINTRANSIT, 0)
                     + NVL (LPP_RPHADJ, 0)
                     + NVL (LPP_SOADJ, 0)
                    )
                 ) > 0.5)
	 ) A
WHERE ROWNUM <= " . $banyakitem . "
ORDER BY lpp_kodedivisi, lpp_kodedepartemen, lpp_kategoribrg, lpp_prdcd");

            }

            return view('BACKOFFICE.LPP.' . $repid, compact(['title', 'perusahaan', 'data', 'tgl1', 'tgl2']));
        } else if ($menu == 'LPP06') {
            Self::PROSES_LPP06();

            $p_prog = 'LPP06';
            $repid = 'RPT_LPP06';
            $rep_name = 'IGR_BO_LPPREKONSLD.jsp';

            $title = '** REKONSILIASI SALDO AWAL VS SALDO AKHIR **';

            $data = DB::connection(Session::get('connection'))->select("Select
                            prs_namaperusahaan,
                            prs_namacabang,
                            prs_namawilayah,
                            div, DIV_NamaDivisi,
                            dept, DEP_NamaDepartement,
                            katb, KAT_NamaKategori,
                            prdcd, PRD_DeskripsiPanjang,
                            begbal_rp, akhir_rp
                        From temp_lpp06, tbmaster_divisi, tbmaster_departement, tbmaster_kategori, tbmaster_prodmast, tbmaster_perusahaan
                        where abs(nvl(begbal_rp,0) - nvl(akhir_rp,0)) > 0
                        AND prs_kodeigr = " . Session::get('kdigr') . "
                        AND prd_kodeigr = " . Session::get('kdigr') . "
                        and prd_prdcd = prdcd
                        and kat_kodedepartement = prd_kodedepartement
                        and kat_kodekategori = prd_kodekategoribarang
                        and dep_kodedepartement = prd_kodedepartement
                        and div_kodedivisi = prd_kodedivisi
                        ORDER BY DIV,DEPT,KATB");
//dd($data);
            return view('BACKOFFICE.LPP.' . $repid, compact(['title', 'perusahaan', 'data', 'tgl1', 'tgl2']));

        } else if ($menu == 'LPP07') {
            $p_prog = 'LPP07';
            $repid = 'RPT_LPP07';
            $rep_name = 'IGR_BO_LPPMONP.jsp';

            $data = DB::connection(Session::get('connection'))->select("SELECT mpl_kodemonitoring, mpl_namamonitoring, mpl_prdcd, prd_deskripsipanjang, kemasan,
        judul, prs_namaperusahaan, prs_namacabang, prs_namawilayah,
        SUM(lpp_qtybegbal) sawalqty, SUM(lpp_rphbegbal) sawalrph, SUM(lpp_qtybeli) beliqty,
        SUM(lpp_rphbeli) belirph, SUM(lpp_qtybonus) bonusqty, SUM(lpp_rphbonus) bonusrph,
        SUM(lpp_qtytrmcb) trmcbqty, SUM(lpp_rphtrmcb) trmcbrph, SUM(lpp_qtyretursales) retursalesqty,
        SUM(lpp_rphretursales) retursalesrph, SUM(lpp_rphrafak) rafakrph, SUM(lpp_qtyrepack) repackqty,
        SUM(lpp_rphrepack) repackrph, SUM(lpp_qtylainin) laininqty, SUM(lpp_rphlainin) laininrph,
        SUM(lpp_qtysales) salesqty, SUM(lpp_rphsales) salesrph, SUM(lpp_qtykirim) kirimqty, SUM(lpp_rphkirim) kirimrph,
        SUM(lpp_qtyprepacking) prepackqty, SUM(lpp_rphprepacking) prepackrph, SUM(lpp_qtyhilang) hilangqty,
        SUM(lpp_rphhilang) hilangrph, SUM(lpp_qtylainout) lainoutqty, SUM(lpp_rphlainout) lainoutrph, SUM(lpp_qtyintransit) intrstqty,
        SUM(lpp_rphintransit) intrstrph, SUM(lpp_qtyadj) adjqty, SUM(lpp_rphadj) adjrph, SUM(adj) adj, SUM(sadj) sadj,
        SUM(lpp_qtyakhir) akhirqty, SUM(lpp_rphakhir) akhirrph
FROM (SELECT mpl_kodemonitoring, mpl_namamonitoring, mpl_prdcd, prd_deskripsipanjang, prd_unit||'/'||prd_frac kemasan,
        CASE WHEN " . $tipe . " = '1' then 'MONITORING PRODUK (UNIT/RUPIAH) (MINUS)' ELSE
        CASE WHEN " . $tipe . " = '2' then 'MONITORING PRODUK (UNIT/RUPIAH) (PLUS)' ELSE
        ' MONITORING PRODUK (UNIT/RUPIAH)' END
        END judul,
        lpp_qtybegbal, lpp_rphbegbal, lpp_qtybeli, lpp_rphbeli, lpp_qtybonus, lpp_rphbonus,
        lpp_qtytrmcb, lpp_rphtrmcb, lpp_qtyretursales, lpp_rphretursales, lpp_rphrafak, lpp_qtyrepack, lpp_rphrepack,
        lpp_qtylainin, lpp_rphlainin, lpp_qtysales, lpp_rphsales, lpp_qtykirim, lpp_rphkirim, lpp_qtyprepacking, lpp_rphprepacking,
        lpp_qtyhilang, lpp_rphhilang, lpp_qtylainout, lpp_rphlainout, lpp_qtyintransit, lpp_rphintransit, lpp_qtyadj, lpp_rphadj, lpp_soadj,
        (NVL(lpp_rphadj,0) + NVL(lpp_soadj,0)) adj, NVL(lpp_qtyakhir,0) lpp_qtyakhir, NVL(lpp_rphakhir,0) lpp_rphakhir,
        NVL(lpp_rphakhir,0) - (NVL(lpp_rphbegbal,0) + NVL(lpp_rphbeli,0) + NVL(lpp_rphbonus,0) + NVL(lpp_rphtrmcb,0) + NVL(lpp_rphretursales,0) +
        NVL(lpp_rphrepack,0) + NVL(lpp_rphlainin,0) - NVL(lpp_rphrafak,0) - NVL(lpp_rphsales,0) - NVL(lpp_rphkirim,0) - NVL(lpp_rphprepacking,0) -
        NVL(lpp_rphhilang,0) - NVL(lpp_rphlainout,0) + NVL(lpp_rphintransit,0) + NVL(lpp_rphadj, 0) + NVL(lpp_soadj, 0)) sadj,
        prs_namaperusahaan, prs_namacabang, prs_namawilayah
FROM tbtr_lpp, tbmaster_prodmast, tbtr_monitoringplu, tbmaster_perusahaan
WHERE lpp_kodeigr = " . Session::get('kdigr') . "
         AND lpp_tgl1 >= to_date('" . $tgl1 . "','dd/mm/yyyy')
         AND lpp_tgl2 <= to_date('" . $tgl2 . "','dd/mm/yyyy')
        AND (lpp_qtyadj <> 0 OR lpp_rphadj <> 0)
        AND prd_kodeigr(+) = lpp_kodeigr
        AND prd_prdcd(+) = lpp_prdcd
         " . $and_plu . "
        AND mpl_kodeigr = lpp_kodeigr
        AND mpl_prdcd(+) = lpp_prdcd
         " . $and_mtr . "
        AND prs_kodeigr = lpp_kodeigr
         " . $and_tipe . "        )
GROUP BY mpl_kodemonitoring, mpl_namamonitoring, mpl_prdcd, prd_deskripsipanjang, kemasan, judul,
        prs_namaperusahaan, prs_namacabang, prs_namawilayah
ORDER BY mpl_kodemonitoring, mpl_prdcd");

            $title = $data[0]->judul;

            return view('BACKOFFICE.LPP.' . $repid, compact(['title', 'perusahaan', 'data', 'tgl1', 'tgl2']));

        } else if ($menu == 'LPP08') {
            $p_prog = 'LPP08';
            $repid = 'RPT_LPP08';
            $rep_name = 'IGR_BO_LPPRETURKAT.jsp';

            $data = DB::connection(Session::get('connection'))->select("SELECT lrt_kodedivisi, div_namadivisi,
        lrt_kodedepartemen, dep_namadepartement,
        lrt_kategoribrg, kat_namakategori,
        prs_namaperusahaan, prs_namacabang, prs_namawilayah,
        SUM(lrt_rphbegbal) sawalrph, SUM(lrt_rphbaik) baikrph, SUM(lrt_rphrusak) rusakrph,
        SUM(lrt_rphsupplier) supplierrph, SUM(lrt_rphhilang) hilangrph, SUM(lrt_rphlbaik) lbaikrph,
        SUM(lrt_rphlrusak) lrusakrph, SUM(lrt_rphadj) adjrph, SUM(koreksi) koreksi, SUM(lrt_rphakhir) akhirrph,
        SUM(lrt_qty_selisih_so) sel_so, SUM(lrt_rph_selisih_so) rph_sel_so
FROM (SELECT lrt_kodedivisi, div_namadivisi, lrt_kodedepartemen, dep_namadepartement,
        lrt_kategoribrg, kat_namakategori, lrt_rphbegbal, lrt_rphbaik, lrt_rphrusak, lrt_rphsupplier,
        lrt_rphhilang, lrt_rphlbaik, lrt_rphlrusak, lrt_rphadj, lrt_rphakhir,
        NVL(lrt_rphakhir,0) - (NVL(lrt_rphbegbal,0) + NVL(lrt_rphbaik,0) + NVL(lrt_rphrusak,0) + NVL(lrt_rph_selisih_so, 0)  + NVL(lrt_rphadj,0) -
        NVL(lrt_rphsupplier,0) - NVL(lrt_rphlbaik,0) - NVL(lrt_rphhilang,0) - NVL(lrt_rphlrusak,0)) koreksi,   NVL(lrt_qty_selisih_so, 0) lrt_qty_selisih_so, NVL(lrt_rph_selisih_so, 0) lrt_rph_selisih_so,
        prs_namaperusahaan, prs_namacabang, prs_namawilayah
FROM tbtr_lpprt, tbmaster_divisi, tbmaster_departement,tbmaster_kategori, tbmaster_perusahaan
WHERE lrt_kodeigr = " . Session::get('kdigr') . "
         AND lrt_tgl1 >= to_date('" . $tgl1 . "','dd/mm/yyyy')
         AND lrt_tgl2 <= to_date('" . $tgl2 . "','dd/mm/yyyy')
        AND div_kodeigr(+) = lrt_kodeigr
        AND div_kodedivisi(+) = lrt_kodedivisi
        AND dep_kodeigr(+) = lrt_kodeigr
        AND dep_kodedivisi(+) = lrt_kodedivisi
        AND dep_kodedepartement(+) = lrt_kodedepartemen
        AND kat_kodeigr(+) = lrt_kodeigr
        AND kat_kodedepartement(+) = lrt_kodedepartemen
        AND kat_kodekategori(+) = lrt_kategoribrg
        AND prs_kodeigr = lrt_kodeigr
        ORDER BY div_kodedivisi, dep_kodedepartement, kat_kodekategori)
GROUP BY lrt_kodedivisi, div_namadivisi,
        lrt_kodedepartemen, dep_namadepartement,
        lrt_kategoribrg, kat_namakategori,
        prs_namaperusahaan, prs_namacabang, prs_namawilayah
ORDER BY lrt_kodedivisi, lrt_kodedepartemen, lrt_kategoribrg");

            $title = "** POSISI & MUTASI PERSEDIAAN BARANG RETUR **";

            return view('BACKOFFICE.LPP.' . $repid, compact(['title', 'perusahaan', 'data', 'tgl1', 'tgl2']));

        } else if ($menu == 'LPP09') {
            $p_prog = 'LPP09';
            $repid = 'RPT_LPP09';
            $rep_name = 'IGR_BO_LPPRETURRCDDK.jsp';
            if (isset($prdcd1) && isset($prdcd2)) {
                $and_plu = " and lrt_prdcd between '" . $prdcd1 . "' and '" . $prdcd2 . "'";
            }

            if ($tipe == '1') {
                $and_tipe = ' and lrt_rphakhir < 0';
            } else if ($tipe == '2') {
                $and_tipe = ' and lrt_rphakhir >= 0';
            } else {
                $and_tipe = ' ';
            }

            $data = DB::connection(Session::get('connection'))
                ->select("SELECT lrt_kodedivisi, div_namadivisi,
        lrt_kodedepartemen, dep_namadepartement,
        lrt_kategoribrg, kat_namakategori, lrt_prdcd, prd_deskripsipanjang, kemasan,
        judul, prs_namaperusahaan, prs_namacabang, prs_namawilayah,
        SUM(lrt_qtybegbal) sawalqty, SUM(lrt_rphbegbal) sawalrph, SUM(lrt_qtybaik) baikqty,
        SUM(lrt_rphbaik) baikrph, SUM(lrt_qtyrusak) rusakqty, SUM(lrt_rphrusak) rusakrph,
        SUM(lrt_qtysupplier) supplierqty, SUM(lrt_rphsupplier) supplierrph, SUM(lrt_qtyhilang) hilangqty,
        SUM(lrt_rphhilang) hilangrph, SUM(lrt_qtylbaik) lbaikqty, SUM(lrt_rphlbaik) lbaikrph, SUM(lrt_qtylrusak) lrusakqty,
        SUM(lrt_rphlrusak) lrusakrph, SUM(lrt_qtyadj) adjqty, SUM(lrt_rphadj) adjrph, SUM(koreksi) koreksi,  SUM(lrt_qty_selisih_so) sel_so, SUM(lrt_rph_selisih_so) rph_sel_so,
        SUM(mpp) mpp, SUM(lrt_qtyakhir) akhirqty, SUM(lrt_rphakhir) akhirrph
FROM (SELECT lrt_kodedivisi, div_namadivisi, lrt_kodedepartemen, dep_namadepartement,
        lrt_kategoribrg, kat_namakategori, lrt_prdcd, prd_deskripsipanjang, prd_unit||'/'||prd_frac kemasan,
        CASE WHEN " . $tipe . " = '1' then 'POSISI & MUTASI PERSEDIAAN BARANG RETUR (MINUS)' ELSE
        CASE WHEN " . $tipe . " = '2' then 'POSISI & MUTASI PERSEDIAAN BARANG RETUR (PLUS)' ELSE
        ' POSISI & MUTASI PERSEDIAAN BARANG RETUR' END
        END judul,
        lrt_qtybegbal, lrt_rphbegbal, lrt_qtybaik, lrt_rphbaik, lrt_qtyrusak, lrt_rphrusak,
        lrt_qtysupplier, lrt_rphsupplier, lrt_qtyhilang, lrt_rphhilang, lrt_qtylbaik, lrt_rphlbaik,
        lrt_qtylrusak, lrt_rphlrusak, lrt_qtyadj, lrt_rphadj, (NVL(lrt_rphadj,0) + NVL(lrt_soadj,0)) mpp,
        NVL(lrt_rphakhir,0) - (NVL(lrt_rphbegbal,0) + NVL(lrt_rphbaik,0) + NVL(lrt_rphrusak,0) + NVL(lrt_rphadj,0) + NVL(lrt_rph_selisih_so, 0) + NVL(lrt_soadj, 0) -
        NVL(lrt_rphsupplier,0) - NVL(lrt_rphhilang,0) - NVL(lrt_rphlbaik,0) - NVL(lrt_rphlrusak,0)) koreksi,
        lrt_avgcost1, lrt_avgcost, NVL(lrt_qtyakhir,0) lrt_qtyakhir, NVL(lrt_rphakhir,0) lrt_rphakhir,
        NVL(lrt_qty_selisih_so, 0) lrt_qty_selisih_so, NVL(lrt_rph_selisih_so, 0) lrt_rph_selisih_so,
        prs_namaperusahaan, prs_namacabang, prs_namawilayah
FROM tbtr_lpprt, tbmaster_prodmast, tbmaster_divisi,
        tbmaster_departement, tbmaster_kategori, tbmaster_perusahaan
WHERE lrt_kodeigr = " . Session::get('kdigr') . "
         AND lrt_tgl1 >= to_date('" . $tgl1 . "','dd/mm/yyyy')
         AND lrt_tgl2 <= to_date('" . $tgl2 . "','dd/mm/yyyy')
        AND prd_kodeigr(+) = lrt_kodeigr
        AND prd_prdcd(+) = lrt_prdcd
        AND div_kodeigr(+) = lrt_kodeigr
        AND div_kodedivisi(+) = lrt_kodedivisi
        AND dep_kodeigr(+) = lrt_kodeigr
        AND dep_kodedivisi(+) = lrt_kodedivisi
        AND dep_kodedepartement(+) = lrt_kodedepartemen
        " . $and_dep . "
        AND kat_kodeigr(+) = lrt_kodeigr
        AND kat_kodedepartement(+) = lrt_kodedepartemen
        AND kat_kodekategori(+) = lrt_kategoribrg
        " . $and_kat . "
        " . $and_tipe . "
        AND prs_kodeigr = lrt_kodeigr
        " . $and_plu . "
        )
GROUP BY lrt_kodedivisi, div_namadivisi,
        lrt_kodedepartemen, dep_namadepartement,
        lrt_kategoribrg, kat_namakategori,
        lrt_prdcd, prd_deskripsipanjang, kemasan, judul,
        prs_namaperusahaan, prs_namacabang, prs_namawilayah
ORDER BY lrt_kodedivisi, lrt_kodedepartemen, lrt_kategoribrg, lrt_prdcd");

            $title = $data[0]->judul;

            return view('BACKOFFICE.LPP.' . $repid, compact(['title', 'perusahaan', 'data', 'tgl1', 'tgl2']));

        } else if ($menu == 'LPP10') {
            $p_prog = 'LPP10';
            $repid = 'RPT_LPP10';
            $rep_name = 'IGR_BO_LPPRUSAKKAT.jsp';

            $data = DB::connection(Session::get('connection'))->select("SELECT lrs_kodedivisi, div_namadivisi,
    lrs_kodedepartemen, dep_namadepartement,
    lrs_kategoribrg, kat_namakategori,
    prs_namaperusahaan, prs_namacabang, prs_namawilayah,
    SUM(lrs_rphbegbal) sawalrph, SUM(lrs_rphbaik) baikrph, SUM(lrs_rphretur) returrph,
    SUM(lrs_rphmusnah) musnahrph, SUM(lrs_rphhilang) hilangrph, SUM(lrs_rphlbaik) lbaikrph,
    SUM(lrs_rphlretur) lreturrph, SUM(adj) adjrph, SUM(koreksi) koreksi, SUM(lrs_rphakhir) akhirrph,
    SUM(lrs_qty_selisih_so) sel_so, SUM(lrs_rph_selisih_so) rph_sel_so
FROM (SELECT lrs_kodedivisi, div_namadivisi, lrs_kodedepartemen, dep_namadepartement,
    lrs_kategoribrg, kat_namakategori, lrs_rphbegbal, lrs_rphbaik, lrs_rphretur, lrs_rphmusnah,
    lrs_rphhilang, lrs_rphlbaik, lrs_rphlretur, lrs_rphadj, lrs_rphakhir, NVL(lrs_rphadj,0) + NVL(lrs_soadj,0) adj,
    NVL(lrs_qty_selisih_so, 0) lrs_qty_selisih_so, NVL(lrs_rph_selisih_so, 0) lrs_rph_selisih_so,
    NVL(lrs_rphakhir,0) - (NVL(lrs_rphbegbal,0) + NVL(lrs_rphbaik,0) + NVL(lrs_rphretur,0) + NVL(lrs_rphadj,0) +  NVL(lrs_rph_selisih_so, 0)  + NVL(lrs_soadj,0) -
    NVL(lrs_rphmusnah,0) - NVL(lrs_rphlbaik,0) - NVL(lrs_rphhilang,0) - NVL(lrs_rphlretur,0)) koreksi,
    prs_namaperusahaan, prs_namacabang, prs_namawilayah
FROM tbtr_lpprs, tbmaster_divisi, tbmaster_departement,tbmaster_kategori, tbmaster_perusahaan
WHERE lrs_kodeigr = " . Session::get('kdigr') . "
     AND lrs_tgl1 >= to_date('" . $tgl1 . "','dd/mm/yyyy')
     AND lrs_tgl2 <= to_date('" . $tgl2 . "','dd/mm/yyyy')
    AND div_kodeigr(+) = lrs_kodeigr
    AND div_kodedivisi(+) = lrs_kodedivisi
    AND dep_kodeigr(+) = lrs_kodeigr
    AND dep_kodedivisi(+) = lrs_kodedivisi
    AND dep_kodedepartement(+) = lrs_kodedepartemen
    AND kat_kodeigr(+) = lrs_kodeigr
    AND kat_kodedepartement(+) = lrs_kodedepartemen
    AND kat_kodekategori(+) = lrs_kategoribrg
    AND prs_kodeigr = lrs_kodeigr
    ORDER BY div_kodedivisi, dep_kodedepartement, kat_kodekategori)
GROUP BY lrs_kodedivisi, div_namadivisi,
    lrs_kodedepartemen, dep_namadepartement,
    lrs_kategoribrg, kat_namakategori,
    prs_namaperusahaan, prs_namacabang, prs_namawilayah
ORDER BY lrs_kodedivisi, lrs_kodedepartemen, lrs_kategoribrg");

            $title = "** POSISI & MUTASI PERSEDIAAN BARANG RUSAK **";

            return view('BACKOFFICE.LPP.' . $repid, compact(['title', 'perusahaan', 'data', 'tgl1', 'tgl2']));

        } else if ($menu == 'LPP11') {
            $p_prog = 'LPP11';
            $repid = 'RPT_LPP11';
            $rep_name = 'IGR_BO_LPPRUSAKRCDDK.jsp';
            if ($tipe == '1') {
                $and_tipe = ' and lrs_rphakhir < 0';
            } else if ($tipe == '2') {
                $and_tipe = ' and lrs_rphakhir >= 0';
            } else {
                $and_tipe = ' ';
            }
            if (isset($prdcd1) && isset($prdcd2)) {
                $and_plu = " and lrs_prdcd between '" . $prdcd1 . "' and '" . $prdcd2 . "'";
            }
            $data = DB::connection(Session::get('connection'))->select("SELECT lrs_kodedivisi, div_namadivisi,
    lrs_kodedepartemen, dep_namadepartement,
    lrs_kategoribrg, kat_namakategori, lrs_prdcd, prd_deskripsipanjang, kemasan,
    judul, prs_namaperusahaan, prs_namacabang, prs_namawilayah,
    SUM(lrs_qtybegbal) sawalqty, SUM(lrs_rphbegbal) sawalrph, SUM(lrs_qtybaik) baikqty,
    SUM(lrs_rphbaik) baikrph, SUM(lrs_qtyretur) returqty, SUM(lrs_rphretur) returrph,
    SUM(lrs_qtymusnah) musnahqty, SUM(lrs_rphmusnah) musnahrph, SUM(lrs_qtyhilang) hilangqty,
    SUM(lrs_rphhilang) hilangrph, SUM(lrs_qtylbaik) lbaikqty, SUM(lrs_rphlbaik) lbaikrph, SUM(lrs_qtylretur) lreturqty,
    SUM(lrs_rphlretur) lreturrph, SUM(lrs_qtyadj) adjqty, SUM(lrs_rphadj) adjrph, SUM(koreksi) koreksi,
    SUM(mpp) mpp, SUM(lrs_qtyakhir) akhirqty, SUM(lrs_rphakhir) akhirrph,
    SUM(lrs_qty_selisih_so) sel_so, SUM(lrs_rph_selisih_so) rph_sel_so
FROM (SELECT lrs_kodedivisi, div_namadivisi, lrs_kodedepartemen, dep_namadepartement,
    lrs_kategoribrg, kat_namakategori, lrs_prdcd, prd_deskripsipanjang, prd_unit||'/'||prd_frac kemasan,
    CASE WHEN " . $tipe . " = '1' then 'POSISI & MUTASI PERSEDIAAN BARANG RUSAK (MINUS)' ELSE
    CASE WHEN " . $tipe . " = '2' then 'POSISI & MUTASI PERSEDIAAN BARANG RUSAK(PLUS)' ELSE
    ' POSISI & MUTASI PERSEDIAAN BARANG RUSAK' END
    END judul,
    lrs_qtybegbal, lrs_rphbegbal, lrs_qtybaik, lrs_rphbaik, lrs_qtyretur, lrs_rphretur,
    lrs_qtymusnah, lrs_rphmusnah, lrs_qtyhilang, lrs_rphhilang, lrs_qtylbaik, lrs_rphlbaik,
    lrs_qtylretur, lrs_rphlretur, lrs_qtyadj, lrs_rphadj, (NVL(lrs_rphadj,0) + NVL(lrs_soadj,0)) mpp,
    NVL(lrs_rphakhir,0) - (NVL(lrs_rphbegbal,0) + NVL(lrs_rphbaik,0) + NVL(lrs_rphretur,0) + NVL(lrs_rphadj,0) + NVL(lrs_rph_selisih_so, 0)  + NVL(lrs_soadj, 0) -
    NVL(lrs_rphmusnah,0) - NVL(lrs_rphhilang,0) - NVL(lrs_rphlbaik,0) - NVL(lrs_rphlretur,0)) koreksi,
    lrs_avgcost1, lrs_avgcost, NVL(lrs_qtyakhir,0) lrs_qtyakhir, NVL(lrs_rphakhir,0) lrs_rphakhir,
    NVL(lrs_qty_selisih_so, 0) lrs_qty_selisih_so, NVL(lrs_rph_selisih_so, 0) lrs_rph_selisih_so,
    prs_namaperusahaan, prs_namacabang, prs_namawilayah
FROM tbtr_lpprs, tbmaster_prodmast, tbmaster_divisi,
    tbmaster_departement,tbmaster_kategori, tbmaster_perusahaan
WHERE lrs_kodeigr =  " . Session::get('kdigr') . "
    AND lrs_tgl1 >= to_date('" . $tgl1 . "','dd/mm/yyyy')
    AND lrs_tgl2 <= to_date('" . $tgl2 . "','dd/mm/yyyy')
    AND prd_kodeigr(+) = lrs_kodeigr
    AND prd_prdcd(+) = lrs_prdcd
    AND div_kodeigr(+) = lrs_kodeigr
    AND div_kodedivisi(+) = lrs_kodedivisi
    AND dep_kodeigr(+) = lrs_kodeigr
    AND dep_kodedivisi(+) = lrs_kodedivisi
    AND dep_kodedepartement(+) = lrs_kodedepartemen
    " . $and_dep . "
    AND kat_kodeigr(+) = lrs_kodeigr
    AND kat_kodedepartement(+) = lrs_kodedepartemen
    AND kat_kodekategori(+) = lrs_kategoribrg
    " . $and_kat . "
    " . $and_tipe . "
    AND prs_kodeigr = lrs_kodeigr
    " . $and_plu . "
    ORDER BY div_kodedivisi, dep_kodedepartement, kat_kodekategori, lrs_prdcd)
GROUP BY lrs_kodedivisi, div_namadivisi,
    lrs_kodedepartemen, dep_namadepartement,
    lrs_kategoribrg, kat_namakategori,
    lrs_prdcd, prd_deskripsipanjang, kemasan, judul,
    prs_namaperusahaan, prs_namacabang, prs_namawilayah
ORDER BY lrs_kodedivisi, lrs_kodedepartemen, lrs_kategoribrg, lrs_prdcd");

            $title = $data[0]->judul;

            return view('BACKOFFICE.LPP.' . $repid, compact(['title', 'perusahaan', 'data', 'tgl1', 'tgl2']));

        } else if ($menu == 'LPP12') {
            $p_prog = 'LPP12';
            $repid = 'RPT_LPP12';
            $rep_name = 'IGR_BO_LPPGAB.jsp';
            $data = DB::connection(Session::get('connection'))->select("SELECT lpp_kodedivisi, div_namadivisi,
    lpp_kodedepartemen, dep_namadepartement,
    lpp_kategoribrg, kat_namakategori,
    prs_namaperusahaan, prs_namacabang, prs_namawilayah,
    SUM(lpp_rphbegbal) sawal, SUM(lpp_rphbeli) beli, SUM(lpp_rphbonus) bonus,
    SUM(lpp_rphtrmcb) trmcb, SUM(lpp_rphretursales) retursales, SUM(lpp_rphrafak) rafak,
    SUM(lpp_rphrepack) repack, SUM(lpp_rphlainin) lainin, SUM(lpp_rphsales) SALES,
    SUM(lpp_rphkirim) kirim, SUM(lpp_rphprepacking) prepack, SUM(lpp_rphhilang) hilang,
    SUM(lpp_rphlainout) lainout, SUM(lpp_rphintransit) intrst, SUM(adj) adj, SUM(koreksi) koreksi,
    SUM(lpp_rphakhir) akhir, SUM(lrt_rphbegbal) lrtbegbal, SUM(lrt_rphbaik) lrtbaik,
    SUM(lrt_rphrusak) lrtrusak, SUM(lrt_rphsupplier) lrtsuppl, SUM(lrt_rphhilang) lrthilang,
    SUM(lrt_rphlbaik) lrtlbaik, SUM(lrt_rphlrusak) lrtlrusak, SUM(lrt_rphadj) lrtadjrph,
    SUM(lrt_soadj) lrtsoadj, SUM(lrtadj) lrtadj, SUM(lrtakhir) lrtakhir,
    SUM(lrs_rphbegbal) lrsbegbal, SUM(lrs_rphbaik) lrsbaik, SUM(lrs_rphretur) lrsretur,
    SUM(lrs_rphmusnah) lrsmusnah, SUM(lrs_rphhilang) lrshilang, SUM(lrs_rphlbaik) lrslbaik,
    SUM(lrs_rphlretur) lrslretur, SUM(lrs_rphadj) lrsadjrph, SUM(lrs_soadj) lrssoadj, SUM(lrsadj) lrsadj,
    SUM(lrsakhir) lrsakhir, SUM(nBegbal) nbegbal, SUM(nlainin) nlainin, SUM(nadj) nadj,
    SUM(nlainout) nlainout, SUM(nakhir) nakhir
FROM (SELECT lpp_kodedivisi, div_namadivisi,
    lpp_kodedepartemen, dep_namadepartement,
    lpp_kategoribrg, kat_namakategori,
    lpp_prdcd, prd_deskripsipanjang, lpp_rphbegbal, lpp_rphbeli, lpp_rphbonus,
    lpp_rphtrmcb, lpp_rphretursales, lpp_rphrafak, lpp_rphrepack, lpp_rphlainin, lpp_rphsales,
    lpp_rphkirim, lpp_rphprepacking, lpp_rphhilang, lpp_rphlainout, lpp_rphintransit,
    (NVL(lpp_rphadj,0) + NVL(lpp_soadj,0)) adj, NVL(lpp_rphakhir,0) lpp_rphakhir,
    NVL(lpp_rphakhir,0) - (NVL(lpp_rphbegbal,0) + NVL(lpp_rphbeli,0) + NVL(lpp_rphbonus,0) + NVL(lpp_rphtrmcb,0) + NVL(lpp_rphretursales,0) +
    NVL(lpp_rphrepack,0) + NVL(lpp_rphlainin,0) - NVL(lpp_rphrafak,0) - NVL(lpp_rphsales,0) - NVL(lpp_rphkirim,0) - NVL(lpp_rphprepacking,0) -
    NVL(lpp_rphhilang,0) - NVL(lpp_rphlainout,0) + NVL(lpp_rphintransit,0) + NVL(lpp_rphadj, 0) + NVL(lpp_soadj, 0)) koreksi,
    lrt_rphbegbal, lrt_rphbaik, lrt_rphrusak, lrt_rphsupplier, lrt_rphhilang, lrt_rphlbaik, lrt_rphlrusak, lrt_rphadj, lrt_soadj,
    NVL(lrt_rphadj,0) + NVL(lrt_soadj,0) lrtadj, (NVL(lrt_rphbegbal,0) + NVL(lrt_rphbaik,0) + NVL(lrt_rphrusak,0) + NVL(lrt_rphadj,0) +
    NVL(lrt_soadj,0) - NVL(lrt_rphsupplier,0) - NVL(lrt_rphlbaik,0) - NVL(lrt_rphhilang,0) - NVL(lrt_rphlrusak,0)) lrtakhir,
    lrs_rphbegbal, lrs_rphbaik, lrs_rphretur, lrs_rphmusnah, lrs_rphhilang, lrs_rphlbaik, lrs_rphlretur, lrs_rphadj, lrs_soadj,
    NVL(lrs_rphadj,0) + NVL(lrs_soadj,0) lrsadj, (NVL(lrs_rphbegbal,0) + NVL(lrs_rphbaik,0) + NVL(lrs_rphretur,0) + NVL(lrs_rphadj,0) +
    NVL(lrs_soadj,0) - NVL(lrs_rphmusnah,0) - NVL(lrs_rphlbaik,0) - NVL(lrs_rphhilang,0) - NVL(lrs_rphlretur,0)) lrsakhir,
    NVL(lpp_rphbegbal,0) + NVL(lrt_rphbegbal,0) + NVL(lrs_rphbegbal,0) nbegbal,
    NVL(lpp_rphlainin,0) + NVL(lrt_rphbaik,0) + NVL(lrt_rphrusak,0) + NVL(lrs_rphbaik,0) + NVL(lrs_rphretur,0) nlainin,
    NVL(lpp_rphadj,0) + NVL(lpp_soadj,0) + NVL(lrt_rphadj,0) + NVL(lrt_soadj,0) + NVL(lrs_rphadj,0) + NVL(lrs_soadj,0) nadj,
    NVL(lpp_rphlainout,0) + NVL(lrt_rphsupplier,0) + NVL(lrt_rphhilang,0) + NVL(lrt_rphrusak,0) + NVL(lrt_rphlbaik,0) +
    NVL(lrs_rphhilang,0) + NVL(lrs_rphmusnah,0) + NVL(lrs_rphlbaik,0) + NVL(lrs_rphlretur,0) nlainout,
    (NVL(lpp_rphakhir,0) + NVL(lrt_rphbegbal,0) + NVL(lrt_rphbaik,0) + NVL(lrt_rphrusak,0) + NVL(lrt_rphadj,0) +
    NVL(lrt_soadj,0) - NVL(lrt_rphsupplier,0) - NVL(lrt_rphlbaik,0) - NVL(lrt_rphhilang,0) - NVL(lrt_rphlrusak,0) +
    NVL(lrs_rphbegbal,0) + NVL(lrs_rphbaik,0) + NVL(lrs_rphretur,0) + NVL(lrs_rphadj,0) +
    NVL(lrs_soadj,0) - NVL(lrs_rphmusnah,0) - NVL(lrs_rphlbaik,0) - NVL(lrs_rphhilang,0) - NVL(lrs_rphlretur,0)) nakhir,
    prs_namaperusahaan, prs_namacabang, prs_namawilayah
FROM tbtr_lpp, tbtr_lpprt, tbtr_lpprs, tbmaster_prodmast, tbmaster_divisi,
    tbmaster_departement,tbmaster_kategori, tbmaster_perusahaan
WHERE lpp_kodeigr = " . Session::get('kdigr') . "
    AND lpp_tgl1 >= to_date('" . $tgl1 . "','dd/mm/yyyy')
    AND lpp_tgl2 <= to_date('" . $tgl2 . "','dd/mm/yyyy')
    AND prd_kodeigr = lpp_kodeigr
    AND prd_prdcd = lpp_prdcd
    AND div_kodeigr = prd_kodeigr
    AND div_kodedivisi = prd_kodedivisi
    AND dep_kodeigr = prd_kodeigr
    AND dep_kodedivisi = prd_kodedivisi
    AND dep_kodedepartement = prd_kodedepartement
    AND kat_kodeigr = prd_kodeigr
    AND kat_kodedepartement = prd_kodedepartement
    AND kat_kodekategori = prd_kodekategoribarang
    AND lrt_kodeigr = lpp_kodeigr
    AND lrt_prdcd = lpp_prdcd
    AND lrs_kodeigr = lpp_kodeigr
    AND lrs_prdcd = lpp_prdcd
    AND prs_kodeigr = lpp_kodeigr
    ORDER BY div_kodedivisi, dep_kodedepartement, kat_kodekategori)
GROUP BY lpp_kodedivisi, div_namadivisi,
    lpp_kodedepartemen, dep_namadepartement,
    lpp_kategoribrg, kat_namakategori,
    prs_namaperusahaan, prs_namacabang, prs_namawilayah
ORDER BY lpp_kodedivisi, lpp_kodedepartemen, lpp_kategoribrg");

            $title = "** POSISI & MUTASI PERSEDIAAN BARANG GABUNGAN **";

            return view('BACKOFFICE.LPP.' . $repid, compact(['title', 'perusahaan', 'data', 'tgl1', 'tgl2']));

        } else if ($menu == 'LPP13') {
            $p_prog = 'LPP13';
            $repid = 'RPT_LPP13';
            $rep_name = 'IGR_BO_LPPSUPBAIK.jsp';
            $data = DB::connection(Session::get('connection'))->select("SELECT sup_kodesupplier, sup_namasupplier, lpp_prdcd, prd_deskripsipanjang, kemasan,
    prs_namaperusahaan, prs_namacabang, prs_namawilayah,
    SUM(lpp_qtybegbal) sawalqty, SUM(lpp_rphbegbal) sawalrph, SUM(lpp_qtybeli) beliqty,
    SUM(lpp_rphbeli) belirph, SUM(lpp_qtybonus) bonusqty, SUM(lpp_rphbonus) bonusrph,
    SUM(lpp_qtytrmcb) trmcbqty, SUM(lpp_rphtrmcb) trmcbrph, SUM(lpp_qtyretursales) retursalesqty,
    SUM(lpp_rphretursales) retursalesrph, SUM(lpp_rphrafak) rafakrph, SUM(lpp_qtyrepack) repackqty,
    SUM(lpp_rphrepack) repackrph, SUM(lpp_qtylainin) laininqty, SUM(lpp_rphlainin) laininrph,
    SUM(lpp_qtysales) salesqty, SUM(lpp_rphsales) salesrph, SUM(lpp_qtykirim) kirimqty, SUM(lpp_rphkirim) kirimrph,
    SUM(lpp_qtyprepacking) prepackqty, SUM(lpp_rphprepacking) prepackrph, SUM(lpp_qtyhilang) hilangqty,
    SUM(lpp_rphhilang) hilangrph, SUM(lpp_qtylainout) lainoutqty, SUM(lpp_rphlainout) lainoutrph, SUM(lpp_qtyintransit) intrstqty,
    SUM(lpp_rphintransit) intrstrph, SUM(lpp_qtyadj) adjqty, SUM(lpp_rphadj) adjrph, SUM(adj) adj, SUM(sadj) sadj,
    SUM(lpp_qtyakhir) akhirqty, SUM(lpp_rphakhir) akhirrph
FROM (SELECT sup_kodesupplier, sup_namasupplier, lpp_prdcd, prd_deskripsipanjang, prd_unit||'/'||prd_frac kemasan,
    lpp_qtybegbal, lpp_rphbegbal, lpp_qtybeli, lpp_rphbeli, lpp_qtybonus, lpp_rphbonus,
    lpp_qtytrmcb, lpp_rphtrmcb, lpp_qtyretursales, lpp_rphretursales, lpp_rphrafak, lpp_qtyrepack, lpp_rphrepack,
    lpp_qtylainin, lpp_rphlainin, lpp_qtysales, lpp_rphsales, lpp_qtykirim, lpp_rphkirim, lpp_qtyprepacking, lpp_rphprepacking,
    lpp_qtyhilang, lpp_rphhilang, lpp_qtylainout, lpp_rphlainout, lpp_qtyintransit, lpp_rphintransit, lpp_qtyadj, lpp_rphadj, lpp_soadj,
    (NVL(lpp_rphadj,0) + NVL(lpp_soadj,0)) adj, NVL(lpp_qtyakhir,0) lpp_qtyakhir, NVL(lpp_rphakhir,0) lpp_rphakhir,
    NVL(lpp_rphakhir,0) - (NVL(lpp_rphbegbal,0) + NVL(lpp_rphbeli,0) + NVL(lpp_rphbonus,0) + NVL(lpp_rphtrmcb,0) + NVL(lpp_rphretursales,0) +
    NVL(lpp_rphrepack,0) + NVL(lpp_rphlainin,0) - NVL(lpp_rphrafak,0) - NVL(lpp_rphsales,0) - NVL(lpp_rphkirim,0) - NVL(lpp_rphprepacking,0) -
    NVL(lpp_rphhilang,0) - NVL(lpp_rphlainout,0) + NVL(lpp_rphintransit,0) + NVL(lpp_rphadj, 0) + NVL(lpp_soadj, 0)) sadj,
    prs_namaperusahaan, prs_namacabang, prs_namawilayah
FROM tbtr_lpp, tbmaster_prodmast, tbmaster_perusahaan, tbmaster_supplier
WHERE lpp_kodeigr = " . Session::get('kdigr') . "
    AND lpp_tgl1 >= to_date('" . $tgl1 . "','dd/mm/yyyy')
    AND lpp_tgl2 <= to_date('" . $tgl2 . "','dd/mm/yyyy')
    AND prd_kodeigr(+) = lpp_kodeigr
    AND prd_prdcd(+) = lpp_prdcd
    AND prs_kodeigr = lpp_kodeigr
    AND sup_kodesupplier(+) = prd_kodesupplier
    AND sup_kodeigr = lpp_kodeigr
    " . $and_sup . "
)
GROUP BY sup_kodesupplier, sup_namasupplier,
    lpp_prdcd, prd_deskripsipanjang, kemasan,
    prs_namaperusahaan, prs_namacabang, prs_namawilayah
ORDER BY sup_kodesupplier, lpp_prdcd");

            $title = "POSISI DAN MUTASI PERSEDIAAN BARANG BAIK PER SUPPLIER";

            return view('BACKOFFICE.LPP.' . $repid, compact(['title', 'perusahaan', 'data', 'tgl1', 'tgl2']));

        } else if ($menu == 'LPP14') {
            $p_prog = 'LPP14';
            $repid = 'RPT_LPP14';
            $rep_name = 'IGR_BO_LPPSUPRETR.jsp';
            $data = DB::connection(Session::get('connection'))->select("SELECT sup_kodesupplier, sup_namasupplier, lrt_prdcd, prd_deskripsipanjang, kemasan,
    prs_namaperusahaan, prs_namacabang, prs_namawilayah,
    SUM(lrt_qtybegbal) sawalqty, SUM(lrt_rphbegbal) sawalrph, SUM(lrt_qtybaik) baikqty,
    SUM(lrt_rphbaik) baikrph, SUM(lrt_qtyrusak) rusakqty, SUM(lrt_rphrusak) rusakrph,
    SUM(lrt_qtysupplier) supplierqty, SUM(lrt_rphsupplier) supplierrph,
    SUM(lrt_qtyhilang) hilangqty, SUM(lrt_rphhilang) hilangrph, SUM(lrt_qtylbaik) lbaikqty,
    SUM(lrt_rphlbaik) lbaikrph, SUM(lrt_qtylrusak) lrusakqty, SUM(lrt_rphlrusak) lrusakrph,
    SUM(lrt_qtyadj) adjqty, SUM(lrt_rphadj) adjrph, SUM(adj) adj, SUM(sakhir) sakhir,
    SUM(lrt_qtyakhir) akhirqty, SUM(lrt_rphakhir) akhirrph
FROM (SELECT sup_kodesupplier, sup_namasupplier, lrt_prdcd, prd_deskripsipanjang, prd_unit||'/'||prd_frac kemasan,
    lrt_qtybegbal, lrt_rphbegbal, lrt_qtybaik, lrt_rphbaik, lrt_qtyrusak, lrt_rphrusak, lrt_qtysupplier, lrt_rphsupplier,
    lrt_qtyhilang, lrt_rphhilang, lrt_qtylbaik, lrt_rphlbaik, lrt_qtylrusak, lrt_rphlrusak, lrt_qtyadj, lrt_rphadj, lrt_soadj,
    (NVL(lrt_rphadj,0) + NVL(lrt_soadj,0)) adj, NVL(lrt_qtyakhir,0) lrt_qtyakhir, NVL(lrt_rphakhir,0) lrt_rphakhir,
    (NVL(lrt_rphbegbal,0) + NVL(lrt_rphbaik,0) + NVL(lrt_rphrusak,0) + NVL(lrt_rphadj,0) + NVL(lrt_soadj,0) -
    NVL(lrt_rphlbaik,0) - NVL(lrt_rphlrusak,0) - NVL(lrt_rphsupplier,0) - NVL(lrt_rphhilang,0)) sakhir,
    prs_namaperusahaan, prs_namacabang, prs_namawilayah
FROM tbtr_lpprt, tbmaster_prodmast, tbmaster_perusahaan, tbmaster_supplier
WHERE lrt_kodeigr = " . Session::get('kdigr') . "
    AND lrt_tgl1 >= to_date('" . $tgl1 . "','dd/mm/yyyy')
    AND lrt_tgl2 <= to_date('" . $tgl2 . "','dd/mm/yyyy')
    AND prd_kodeigr(+) = lrt_kodeigr
    AND prd_prdcd(+) = lrt_prdcd
    AND prs_kodeigr = lrt_kodeigr
    AND sup_kodesupplier(+) = prd_kodesupplier
    AND sup_kodeigr = lrt_kodeigr
            " . $and_sup . "
)
GROUP BY sup_kodesupplier, sup_namasupplier,
    lrt_prdcd, prd_deskripsipanjang, kemasan,
    prs_namaperusahaan, prs_namacabang, prs_namawilayah
ORDER BY sup_kodesupplier, lrt_prdcd");

            $title = "POSISI DAN MUTASI PERSEDIAAN BARANG RETUR PER SUPPLIER";

            return view('BACKOFFICE.LPP.' . $repid, compact(['title', 'perusahaan', 'data', 'tgl1', 'tgl2']));

        } else if ($menu == 'LPP15') {
            $p_prog = 'LPP15';
            $repid = 'RPT_LPP15';
            $rep_name = 'IGR_BO_LPPSUPRUSK.jsp';
            $data = DB::connection(Session::get('connection'))->select("SELECT sup_kodesupplier, sup_namasupplier, lrs_prdcd, prd_deskripsipanjang, kemasan,
        prs_namaperusahaan, prs_namacabang, prs_namawilayah,
        SUM(lrs_qtybegbal) sawalqty, SUM(lrs_rphbegbal) sawalrph, SUM(lrs_qtybaik) baikqty,
        SUM(lrs_rphbaik) baikrph, SUM(lrs_qtyretur) returqty, SUM(lrs_rphretur) returrph,
        SUM(lrs_qtymusnah) musnahqty, SUM(lrs_rphmusnah) musnahrph,
        SUM(lrs_qtyhilang) hilangqty, SUM(lrs_rphhilang) hilangrph, SUM(lrs_qtylbaik) lbaikqty,
        SUM(lrs_rphlbaik) lbaikrph, SUM(lrs_qtylretur) lreturqty, SUM(lrs_rphlretur) lreturrph,
        SUM(lrs_qtyadj) adjqty, SUM(lrs_rphadj) adjrph, SUM(adj) adj, SUM(sakhir) sakhir,
        SUM(lrs_qtyakhir) akhirqty, SUM(lrs_rphakhir) akhirrph
FROM (SELECT sup_kodesupplier, sup_namasupplier, lrs_prdcd, prd_deskripsipanjang, prd_unit||'/'||prd_frac kemasan,
        lrs_qtybegbal, lrs_rphbegbal, lrs_qtybaik, lrs_rphbaik, lrs_qtyretur, lrs_rphretur, lrs_qtymusnah, lrs_rphmusnah,
        lrs_qtyhilang, lrs_rphhilang, lrs_qtylbaik, lrs_rphlbaik, lrs_qtylretur, lrs_rphlretur, lrs_qtyadj, lrs_rphadj, lrs_soadj,
        (NVL(lrs_rphadj,0) + NVL(lrs_soadj,0)) adj, NVL(lrs_qtyakhir,0) lrs_qtyakhir, NVL(lrs_rphakhir,0) lrs_rphakhir,
        (NVL(lrs_rphbegbal,0) + NVL(lrs_rphbaik,0) + NVL(lrs_rphretur,0) + NVL(lrs_rphadj,0) + NVL(lrs_soadj,0) -
        NVL(lrs_rphlbaik,0) - NVL(lrs_rphlretur,0) - NVL(lrs_rphmusnah,0) - NVL(lrs_rphhilang,0)) sakhir,
        prs_namaperusahaan, prs_namacabang, prs_namawilayah
FROM tbtr_lpprs, tbmaster_prodmast, tbmaster_perusahaan, tbmaster_supplier
WHERE lrs_kodeigr = " . Session::get('kdigr') . "
        AND lrs_tgl1 >= to_date('" . $tgl1 . "','dd/mm/yyyy')
        AND lrs_tgl2 <= to_date('" . $tgl2 . "','dd/mm/yyyy')
        AND prd_kodeigr(+) = lrs_kodeigr
        AND prd_prdcd(+) = lrs_prdcd
        AND prs_kodeigr = lrs_kodeigr
        AND sup_kodesupplier(+) = prd_kodesupplier
        AND sup_kodeigr = lrs_kodeigr
        " . $and_sup . "
 )
GROUP BY sup_kodesupplier, sup_namasupplier,
        lrs_prdcd, prd_deskripsipanjang, kemasan,
        prs_namaperusahaan, prs_namacabang, prs_namawilayah
ORDER BY sup_kodesupplier, lrs_prdcd");

            $title = "POSISI DAN MUTASI PERSEDIAAN BARANG RUSAK PER SUPPLIER";

            return view('BACKOFFICE.LPP.' . $repid, compact(['title', 'perusahaan', 'data', 'tgl1', 'tgl2']));

        }


    }

    function cetak_bagian_2(Request $request)
    {
        $menu = $request->menu;
        $tgl1 = $request->periode1;
        $tgl2 = $request->periode2;
        $prdcd1 = $request->prdcd1;
        $prdcd2 = $request->prdcd2;
        $dep1 = $request->dep1;
        $dep2 = $request->dep2;
        $kat1 = $request->kat1;
        $kat2 = $request->kat2;
        $mtr1 = $request->mtr1;
        $mtr2 = $request->mtr2;
        $sup1 = $request->sup1;
        $sup2 = $request->sup2;
        $tipe = $request->tipe;
        $banyakitem = $request->banyakitem;

        $and_tipe = '';
        $and_plu = '';
        $and_div = '';
        $and_dep = '';
        $and_kat = '';
        $and_mtr = '';
        $and_sup = '';
        $p_order = '';

        if (isset($prdcd1) && isset($prdcd2)) {
            $and_plu = " and lpp_prdcd between '" . $prdcd1 . "' and '" . $prdcd2 . "'";
        }
        if (isset($div1) && isset($div2)) {
            $and_div = " and div_kodedivisi between '" . $div1 . "' and '" . $div2 . "'";
        }
        if (isset($dep1) && isset($dep2)) {
            $and_dep = " and dep_kodedepartement between '" . $dep1 . "' and '" . $dep2 . "'";
        }
        if (isset($kat1) && isset($kat1)) {
            $and_kat = " and kat_kodekategori between '" . $kat1 . "' and '" . $kat2 . "'";
        }

        if (isset($tipe)) {
            switch ($tipe) {
                case '1':
                    $and_tipe = ' and lpp_rphakhir < 0';
                    break;
                case '2':
                    $and_tipe = ' and lpp_rphakhir >= 0';
                    break;
                default :
                    $and_tipe = '';
                    break;
            }
        }

        if (isset($mtr1) && isset($mtr2)) {
            $and_mtr = " and mpl_kodemonitoring between '" . $mtr1 . "' and '" . $mtr2 . "'";
        }

        $perusahaan = DB::connection(Session::get('connection'))->table('tbmaster_perusahaan')
            ->select('prs_namaperusahaan', 'prs_namacabang', 'prs_namawilayah')
            ->first();

        if ($menu == 'LPP01') {
            $p_prog = 'LPP01';
            $repid = 'RPT_LPP01A';
            $rep_name = 'IGR_BO_LPPRDDK_SO.jsp';
            $data = DB::connection(Session::get('connection'))
                ->select("SELECT prd_kodedivisi,
         div_namadivisi,
         prd_kodedepartement,
         dep_namadepartement,
         prd_kodekategoribarang,
         kat_namakategori,
         prs_namaperusahaan,
         prs_namacabang,
         prs_namawilayah,
         SUM (qty_soic) qty_soic,
         SUM (rph_soic) rph_soic,
         SUM (qty_so) qty_so,
         SUM (rph_so) rph_so,
         (SUM (qty_soic) + SUM (qty_so)) qty_total,
         (SUM (rph_soic) + SUM (rph_so)) rph_total
    FROM (  SELECT rso_Prdcd,
                   SUM (qty_soic) qty_soic,
                   SUM (rph_soic) rph_soic,
                   SUM (qty_so) qty_so,
                   SUM (rph_so) rph_so
              FROM (SELECT rso_Prdcd,
                           rso_qtyreset qty_soic,
                           (rso_qtyreset * rso_avgcostreset) rph_soic,
                           0 qty_so,
                           0 rph_so
                      FROM tbtr_reset_soic
                     WHERE     TRUNC (rso_tglso) BETWEEN TRUNC ( to_date('" . $tgl1 . "','dd/mm/yyyy'))
                                                     AND TRUNC ( to_date('" . $tgl2 . "','dd/mm/yyyy'))
                           AND NVL (rso_qtyreset, 0) <> 0
                    UNION ALL
                    SELECT SUBSTR (SOP_PRDCD, 1, 6) || '0' rso_prdcd,
                           0 qty_soic,
                           0 rph_soic,
                           ( (sop_qtyso + NVL (adj_qty, 0)) - NVL (sop_qtylpp, 0))
                              QTY_SO,
                             ( (  (sop_qtyso + NVL (adj_qty, 0))
                                - NVL (sop_qtylpp, 0)))
                           / CASE WHEN PRD_UNIT = 'KG' THEN 1000 ELSE 1 END
                           * sop_newavgcost
                              RPH_SO
                      FROM tbtr_ba_stockopname,
                           (  SELECT adj_prdcd,
                                     adj_lokasi,
                                     adj_tglso,
                                     SUM (NVL (adj_qty, 0)) adj_qty
                                FROM tbtr_adjustso
                               WHERE adj_lokasi = '01'
                            GROUP BY adj_prdcd, adj_lokasi, adj_tglso),
                           TBMASTER_PRODMAST
                     WHERE     sop_tglso =
                                  (SELECT MAX (sop_tglso)
                                     FROM tbtr_ba_stockopname
                                    WHERE TO_CHAR (sop_tglso, 'MMyyyy') =
                                             TO_CHAR ( to_date('" . $tgl2 . "','dd/mm/yyyy'), 'MMyyyy'))
                           AND sop_lokasi = '01'
                           AND TRUNC (adj_tglso(+)) = TRUNC (sop_tglso)
                           AND adj_lokasi(+) = sop_lokasi
                           AND adj_prdcd(+) = sop_prdcd
                           AND PRD_KODEIGR = SOP_KODEIGR
                           AND PRD_PRDCD = SOP_PRDCD
                           AND (   PRD_KODEDIVISI <> '5'
                                OR PRD_KODEDEPARTEMENT <> '39')) aa
          GROUP BY rso_prdcd) b,
         tbmaster_Prodmast,
         tbmaster_divisi,
         tbmaster_departement,
         tbmaster_kategori,
         tbmaster_perusahaan
   WHERE     prd_prdcd(+) = rso_prdcd
         AND div_kodedivisi(+) = prd_kodedivisi
         AND dep_kodedivisi(+) = prd_kodedivisi
         AND dep_kodedepartement(+) = prd_kodedepartement
         AND kat_kodedepartement(+) = prd_kodedepartement
         AND kat_kodekategori(+) = prd_kodekategoribarang
         AND prs_kodeigr = " . Session::get('kdigr') . "
GROUP BY prd_kodedivisi,
         div_namadivisi,
         prd_kodedepartement,
         dep_namadepartement,
         prd_kodekategoribarang,
         kat_namakategori,
         prs_namaperusahaan,
         prs_namacabang,
         prs_namawilayah
order by prd_kodedivisi,
         prd_kodedepartement,
         prd_kodekategoribarang");

            $title = "LAPORAN REKAP ADJUSTMENT STOCK OPNAME";

            return view('BACKOFFICE.LPP.' . $repid, compact(['title', 'perusahaan', 'data', 'tgl1', 'tgl2']));

        } else if ($menu == 'LPP02') {
            $p_prog = 'LPP02';
            $repid = 'RPT_LPP02A';
            $rep_name = 'IGR_BO_LPPRCDDK_SO.jsp';

            if (isset($prdcd1) && isset($prdcd2)) {
                $and_plu = " and rso_prdcd between '" . $prdcd1 . "' and '" . $prdcd2 . "'";
            }

            $data = DB::connection(Session::get('connection'))->select("SELECT
         prd_kodedepartement,
         dep_namadepartement,
         prd_kodekategoribarang,
         kat_namakategori,
         prs_namaperusahaan,
         prs_namacabang,
         prs_namawilayah,
         rso_prdcd, prd_deskripsipanjang || ' - ' || prd_unit || '/' || prd_frac prd_deskripsipanjang,
         tgl_soic,
         SUM (qty_soic) qty_soic,
         SUM (rph_soic) rph_soic,
         tgl_so,
         SUM (qty_so) qty_so,
         SUM (rph_so) rph_so,
         (SUM (qty_soic) + SUM (qty_so)) qty_total,
         (SUM (rph_soic) + SUM (rph_so)) rph_total
    FROM (  SELECT rso_Prdcd, tgl_soic,
                   SUM (qty_soic) qty_soic,
                   SUM (rph_soic) rph_soic, tgl_so,
                   SUM (qty_so) qty_so,
                   SUM (rph_so) rph_so
              FROM (SELECT rso_Prdcd,
              trunc(rso_create_dt) tgl_soic,
                           rso_qtyreset qty_soic,
                           (rso_qtyreset * rso_avgcostreset) rph_soic,
                           null tgl_so,
                           0 qty_so,
                           0 rph_so
                      FROM tbtr_reset_soic
                     WHERE     TRUNC (rso_tglso) BETWEEN TRUNC ( to_date('" . $tgl1 . "','dd/mm/yyyy'))
                                                     AND TRUNC ( to_date('" . $tgl2 . "','dd/mm/yyyy'))
                           AND NVL (rso_qtyreset, 0) <> 0
                    UNION all
                    SELECT SUBSTR (SOP_PRDCD, 1, 6) || '0' rso_prdcd, null tgl_soic,
                           0 qty_soic,
                           0 rph_soic, trunc(sop_createdt) tgl_so,
                           ( (sop_qtyso + NVL (adj_qty, 0)) - NVL (sop_qtylpp, 0))
                              QTY_SO,
                             ( (  (sop_qtyso + NVL (adj_qty, 0))
                                - NVL (sop_qtylpp, 0)))
                           / CASE WHEN PRD_UNIT = 'KG' THEN 1000 ELSE 1 END
                           * sop_newavgcost
                              RPH_SO
                      FROM tbtr_ba_stockopname,
                           (  SELECT adj_prdcd,
                                     adj_lokasi,
                                     adj_tglso,
                                     SUM (NVL (adj_qty, 0)) adj_qty
                                FROM tbtr_adjustso
                               WHERE adj_lokasi = '01'
                            GROUP BY adj_prdcd, adj_lokasi, adj_tglso),
                           TBMASTER_PRODMAST
                     WHERE     sop_tglso =
                                  (SELECT MAX (sop_tglso)
                                     FROM tbtr_ba_stockopname
                                    WHERE TO_CHAR (sop_tglso, 'MMyyyy') =
                                             TO_CHAR ( to_date('" . $tgl2 . "','dd/mm/yyyy'), 'MMyyyy'))
                           AND sop_lokasi = '01'
                           AND TRUNC (adj_tglso(+)) = TRUNC (sop_tglso)
                           AND adj_lokasi(+) = sop_lokasi
                           AND adj_prdcd(+) = sop_prdcd
                           AND PRD_KODEIGR = SOP_KODEIGR
                           AND PRD_PRDCD = SOP_PRDCD
                           AND (   PRD_KODEDIVISI <> '5'
                                OR PRD_KODEDEPARTEMENT <> '39')) aa
          GROUP BY rso_prdcd, tgl_soic, tgl_so) b,
         tbmaster_Prodmast,
         tbmaster_divisi,
         tbmaster_departement,
         tbmaster_kategori,
         tbmaster_perusahaan
   WHERE     prd_prdcd = rso_prdcd
        " . $and_plu . "
        " . $and_dep . "
        " . $and_kat . "
         AND div_kodedivisi(+) = prd_kodedivisi
         AND dep_kodedivisi(+) = prd_kodedivisi
         AND dep_kodedepartement(+) = prd_kodedepartement
         AND kat_kodedepartement(+) = prd_kodedepartement
         AND kat_kodekategori(+) = prd_kodekategoribarang
         AND prs_kodeigr = " . Session::get('kdigr') . "
GROUP BY prd_kodedivisi,
         div_namadivisi,
         prd_kodedepartement,
         dep_namadepartement,
         prd_kodekategoribarang,
         kat_namakategori,
         prs_namaperusahaan,
         prs_namacabang,
         prs_namawilayah, rso_prdcd, prd_deskripsipanjang || ' - ' || prd_unit || '/' || prd_frac , tgl_soic, tgl_so
order by prd_kodedivisi,
         prd_kodedepartement,
         prd_kodekategoribarang,
         rso_prdcd   ");

            $title = "LAPORAN RINCIAN ADJUSTMENT STOCK OPNAME";

            return view('BACKOFFICE.LPP.' . $repid, compact(['title', 'perusahaan', 'data', 'tgl1', 'tgl2']));

        }
    }

    function PROSES_LPP06()
    {
        $nrec = 0;

        DB::connection(Session::get('connection'))->table('TEMP_LPP06')->truncate();

        $datas = DB::connection(Session::get('connection'))
            ->select("SELECT st_prdcd, prd_kodedivisi, prd_kodedepartement,
                             prd_kodekategoribarang, nvl(st_rpsaldoawal,0) st_rpsaldoawal
                        FROM tbmaster_stock, tbmaster_prodmast
                       WHERE st_kodeigr = " . Session::get('kdigr') . "
                            AND prd_kodeigr = st_kodeigr
                            AND prd_prdcd = st_prdcd
                            AND st_prdcd IS NOT NULL
                            AND NVL (prd_kodedivisi, '0') <> '5'
                            AND NVL (prd_kodedepartement, '00') <> '39'
                            AND prd_kodedivisi IS NOT NULL
                            AND prd_kodedepartement IS NOT NULL
                            AND prd_kodekategoribarang IS NOT NULL
                            AND NVL (st_recordid, '0') <> '1'
                            AND st_lokasi = '01'
                            ORDER BY st_prdcd");

        if (isset($datas)) {
            foreach ($datas as $data) {

                $nrec = $nrec + 1;

                $JUM = DB::connection(Session::get('connection'))->table('TEMP_LPP06')
                    ->selectRaw('NVL(COUNT(1),0) count')
                    ->where('Prdcd', '=', $data->st_prdcd)
                    ->Where('DIV', '=', $data->prd_kodedivisi)
                    ->Where('DEPT', '=', $data->prd_kodedepartement)
                    ->Where('KATB', '=', $data->prd_kodekategoribarang)
                    ->first()->count;


                if ($JUM > 0) {
                    DB::connection(Session::get('connection'))->table('TEMP_LPP06')
                        ->where('Prdcd', '=', $data->st_prdcd)
                        ->Where('DIV', '=', $data->prd_kodedivisi)
                        ->Where('DEPT', '=', $data->prd_kodedepartement)
                        ->Where('KATB', '=', $data->prd_kodekategoribarang)
                        ->update(['BEGBAL_RP' => DB::connection(Session::get('connection'))->raw('NVL(begbal_rp, 0) + NVL(' . isset($data->st_rpsaldoawal) ? $data->st_rpsaldoawal : 0 . ', 0)')]);
                } else {
                    DB::connection(Session::get('connection'))->table('TEMP_LPP06')->insert([
                        'PRDCD' => $data->st_prdcd,
                        'DIV' => $data->prd_kodedivisi,
                        'DEPT' => $data->prd_kodedepartement,
                        'KATB' => $data->prd_kodekategoribarang,
                        'BEGBAL_RP' => isset($data->st_rpsaldoawal) ? $data->st_rpsaldoawal : 0
                    ]);
                }
            }
        }

        $NREC = 0;

        $recs2 = DB::connection(Session::get('connection'))
            ->select("SELECT lpp_prdcd, prd_kodedivisi, prd_kodedepartement, prd_kodekategoribarang, nvl(lpp_rphakhir,0) lpp_rphakhir
                FROM tbtr_lpp, tbmaster_prodmast
               WHERE lpp_kodeigr = " . Session::get('kdigr') . "
                and prd_kodeigr = lpp_kodeigr
                and prd_prdcd = lpp_prdcd
                and lpp_prdcd IS NOT NULL
                and NVL(prd_kodedivisi, '0') <> '5'
                and NVL(prd_kodedepartement, '00') <> '39'
                and prd_kodedivisi IS NOT NULL
                and prd_kodedepartement IS NOT NULL
                and prd_kodekategoribarang IS NOT NULL
                    ORDER BY lpp_prdcd");

        if ($recs2) {
            foreach ($recs2 as $rec2) {
                $NREC = $NREC + 1;

                $JUM = DB::connection(Session::get('connection'))->table("TEMP_LPP06")
                    ->SelectRaw('NVL(COUNT(1), 0) count')
                    ->where('Prdcd', '=', $rec2->lpp_prdcd)
                    ->Where('DIV', '=', $rec2->prd_kodedivisi)
                    ->Where('DEPT', '=', $rec2->prd_kodedepartement)
                    ->Where('KATB', '=', $rec2->prd_kodekategoribarang)
                    ->first()->count;

                if ($JUM > 0) {
                    DB::connection(Session::get('connection'))->table('TEMP_LPP06')
                        ->where('Prdcd', '=', $rec2->lpp_prdcd)
                        ->Where('DIV', '=', $rec2->prd_kodedivisi)
                        ->Where('DEPT', '=', $rec2->prd_kodedepartement)
                        ->Where('KATB', '=', $rec2->prd_kodekategoribarang)
                        ->update(['AKHIR_RP' => DB::connection(Session::get('connection'))->raw('NVL(AKHIR_RP, 0) + NVL(' . isset($rec2->lpp_rphakhir) ? $rec2->lpp_rphakhir : 0 . ', 0)')]);
                } else {
                    DB::connection(Session::get('connection'))->table('TEMP_LPP06')->insert([
                        'PRDCD' => $rec2->lpp_prdcd,
                        'DIV' => $rec2->prd_kodedivisi,
                        'DEPT' => $rec2->prd_kodedepartement,
                        'KATB' => $rec2->prd_kodekategoribarang,
                        'AKHIR_RP' => isset($rec2->lpp_rphakhir) ? $rec2->lpp_rphakhir : 0,
                    ]);

                }
            }
        }
    }

    function createExcel($view,$filename,$maxColumn,$title,$subtitle){
        $perusahaan = DB::connection(Session::get('connection'))->table('tbmaster_perusahaan')
            ->select('prs_namaperusahaan', 'prs_namacabang', 'prs_namawilayah')
            ->first();
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Html();
        $spreadsheet = $reader->loadFromString($view);
        $spreadsheet->getActiveSheet()->getProtection()->setSheet(true);
        $sheet = $spreadsheet->getActiveSheet();

        $column = [];
        foreach (range('A', $maxColumn) as $columnID) {
            $column[] = $columnID;
        }
        foreach (range('A', $maxColumn) as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
            $sheet->getColumnDimension($columnID)->setAutoSize(false);
        }
        $sheet->insertNewRowBefore(1);
        $sheet->insertNewRowBefore(1);
        $sheet->insertNewRowBefore(1);
        $sheet->insertNewRowBefore(1);
        $sheet->insertNewRowBefore(1);
        $sheet->setCellValue('A1', $perusahaan->prs_namaperusahaan);
        $sheet->setCellValue('A2', $perusahaan->prs_namacabang);
        $sheet->setCellValue('B1', $title);
        $sheet->getStyle('B1')->getAlignment()->setHorizontal('center')->setVertical('center');
        $sheet->mergeCells('B1:'.$column[sizeof($column)-2].'2');
        $sheet->setCellValue($maxColumn.'1', 'Tgl. Cetak : ' . date("d/m/Y"));
        $sheet->setCellValue($maxColumn.'2', 'Jam Cetak : ' . date('H:i:s'));
        $sheet->setCellValue($maxColumn.'3', 'User ID : ' . Session::get('usid'));
        $sheet->setCellValue($maxColumn.'4', $subtitle);
        $sheet->getStyle('A1:'.$maxColumn.'4')->getFont()->setBold(true);
        $sheet->getStyle('A1');
        $writer = new Xlsx($spreadsheet);
        $writer->save(storage_path($filename));    }
}
