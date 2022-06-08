<?php

namespace App\Http\Controllers\BACKOFFICE\LAPORAN;

use App\Http\Controllers\ExcelController;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;
use PDF;
use Yajra\DataTables\DataTables;
use ZipArchive;
use File;

class DaftarPembelianController extends Controller
{
    public function index()
    {
        return view('BACKOFFICE.LAPORAN.daftar-pembelian');
    }

    public function getDataLovDiv(Request $request)
    {
        if (is_null($request->div))
            $div = 1;
        else $div = $request->div;

        $data = DB::connection(Session::get('connection'))->table('tbmaster_divisi')
            ->select('div_kodedivisi', 'div_namadivisi')
            ->where('div_kodeigr', '=', Session::get('kdigr'))
            ->whereRaw('div_kodedivisi >= ' . $div)
            ->get();

        return DataTables::of($data)->make(true);
    }

    public function getDataLovDep(Request $request)
    {
        $data = DB::connection(Session::get('connection'))->table('tbmaster_departement')
            ->select('dep_kodedepartement', 'dep_namadepartement', 'dep_kodedivisi')
            ->where('dep_kodeigr', '=', Session::get('kdigr'))
            ->where('dep_kodedivisi', '=', $request->div)
            ->get();

        return DataTables::of($data)->make(true);
    }

    public function getDataLovKat(Request $request)
    {
        $data = DB::connection(Session::get('connection'))->table("tbmaster_kategori")
            ->join('tbmaster_departement', 'dep_kodedepartement', '=', 'kat_kodedepartement')
            ->select('kat_namakategori', 'kat_kodekategori', 'kat_kodedepartement', 'dep_kodedivisi')
            ->where('kat_kodeigr', '=', Session::get('kdigr'))
            ->where('kat_kodedepartement', '=', $request->dep)
            ->where('dep_kodedivisi', '=', $request->div)
            ->orderBy('kat_kodedepartement')
            ->orderBy('kat_kodekategori')
            ->get();

        return DataTables::of($data)->make(true);
    }

    public function getDataLovMtr()
    {
        $data = DB::connection(Session::get('connection'))->table('tbtr_monitoringplu')
            ->select('mpl_namamonitoring', 'mpl_kodemonitoring')
            ->where('mpl_kodeigr', '=', Session::get('kdigr'))
//            ->where('mpl_kodemonitoring','=',$request->mtr)
            ->distinct()
            ->get();

        return DataTables::of($data)->make(true);
    }

    public function getDataLovSup(Request $request)
    {
        if (is_null($request->sup))
            $sup = 1;
        else $sup = $request->sup;

        $data = DB::connection(Session::get('connection'))->table('tbmaster_supplier')
            ->select('sup_namasupplier', 'sup_kodesupplier')
            ->where('sup_kodeigr', '=', Session::get('kdigr'))
            ->where('sup_kodesupplier', '>=', $sup)
            ->orderBy('sup_kodesupplier')
            ->distinct()
            ->get();

        return DataTables::of($data)->make(true);
    }

    public function cetak(Request $request)
    {
        $tipe = $request->tipe;
        $tgl1 = $request->tgl1;
        $tgl2 = $request->tgl2;
        $div1 = $request->div1;
        $div2 = $request->div2;
        $dep1 = $request->dep1;
        $dep2 = $request->dep2;
        $kat1 = $request->kat1;
        $kat2 = $request->kat2;
        $sup1 = $request->sup1;
        $sup2 = $request->sup2;
        $mtr = $request->mtr;
        $sort = $request->sort;

        $perusahaan = DB::connection(Session::get('connection'))->table('tbmaster_perusahaan')
            ->select('prs_namaperusahaan', 'prs_namacabang')
            ->first();
        $and_doc = '';
        $and_plu = '';
        $and_div = '';
        $and_dep = '';
        $and_kat = '';
        $and_sup = '';
        $p_order = '';
        if ($sort == 1) {
            $and_doc = " and mstd_nodoc = msth_nodoc and TRUNC(mstd_tgldoc) BETWEEN TO_DATE('" . $tgl1 . "','dd/mm/yyyy') AND TO_DATE('" . $tgl2 . "','dd/mm/yyyy') and TRUNC(msth_tgldoc) BETWEEN TO_DATE('" . $tgl1 . "','dd/mm/yyyy') AND TO_DATE('" . $tgl2 . "','dd/mm/yyyy')";
            $p_order = 'order by msth_kodesupplier,msth_nodoc,msth_tgldoc';
        } else {
            $and_doc = " and mstd_nopo = msth_nopo and mstd_nodoc = msth_nodoc and TRUNC(mstd_tglpo) between TO_DATE('" . $tgl1 . "','dd/mm/yyyy') and TO_DATE('" . $tgl2 . "','dd/mm/yyyy') AND TRUNC(msth_tglpo) BETWEEN TO_DATE('" . $tgl1 . "','dd/mm/yyyy') AND TO_DATE('" . $tgl2 . "','dd/mm/yyyy')";
            $p_order = 'order by msth_kodesupplier, msth_nopo, msth_tglpo';
        }
        if (isset($sup1) && isset($sup2)) {
            $and_sup = " and sup_kodeigr = '" . Session::get('kdigr') . "' and sup_kodesupplier between '" . $sup1 . "' and '" . $sup2 . "'";
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

        if ($tipe === '1') {

            if (isset($mtr) && $mtr != '') {
                $and_plu = " and mstd_prdcd in (select mpl_prdcd from tbtr_monitoringplu
                where mpl_kodeigr = '" . Session::get('kdigr') . "' and TRIM(mpl_kodemonitoring) = TRIM('" . $mtr . "'))";
            }
            $data = DB::connection(Session::get('connection'))->select("select mstd_kodedivisi, div_namadivisi,
        mstd_kodedepartement, dep_namadepartement, 
        mstd_kodekategoribrg, kat_namakategori, prd_flagbkp1, prd_flagbkp2, prd_prdcd,
        prs_namaperusahaan, prs_namacabang, prs_namawilayah,
        sum(mstd_gross) gross, sum(mstd_discrph) pot, sum(disc4) disc4,
        sum(mstd_ppn) ppn, sum(mstd_bm) bm, sum(mstd_btl) btl,
        sum(total) total,
        sum(GROSS_BKP) sum_gross_bkp, sum(GROSS_BTKP) sum_gross_btkp,
        sum(POT_BKP)sum_potongan_bkp, sum(POT_BTKP) sum_potongan_btkp,
        sum(DISC4_BKP) sum_disc4_bkp, sum(DISC4_BTKP) sum_disc4_btkp,
        sum(PPN_BKP) sum_ppn_bkp, sum(PPN_BTKP) sum_ppn_btkp,
        sum(BM_BKP) sum_bm_bkp, sum(BM_BTKP) sum_bm_btkp,
        sum(BTL_BKP) sum_btl_bkp, sum(BTL_BTKP) sum_btl_btkp,
        sum(TOTAL_BKP) sum_total_bkp, sum(TOTAL_BTKP) sum_total_btkp
from (select mstd_kodedivisi, div_namadivisi, prd_flagbkp1, prd_flagbkp2,
        mstd_kodedepartement, dep_namadepartement, prd_prdcd,
        mstd_kodekategoribrg, kat_namakategori,
        CASE WHEN mstd_ppnrph <> 0 THEN
                nvl(mstd_gross,0)
        END GROSS_BKP,
        CASE WHEN mstd_ppnrph = 0 THEN
                nvl(mstd_gross,0)
        END GROSS_BTKP,
        CASE WHEN mstd_ppnrph <> 0 THEN
                nvl(mstd_discrph,0)
        END POT_BKP,
        CASE WHEN mstd_ppnrph = 0 THEN
                nvl(mstd_discrph,0)
        END POT_BTKP,
        CASE WHEN mstd_ppnrph <> 0 THEN
                (nvl(mstd_dis4cr,0) + nvl(mstd_dis4rr,0) + nvl(mstd_dis4jr,0))
        END DISC4_BKP,
        CASE WHEN mstd_ppnrph = 0 THEN
                 (nvl(mstd_dis4cr,0) + nvl(mstd_dis4rr,0) + nvl(mstd_dis4jr,0))
        END DISC4_BTKP,
        CASE WHEN mstd_ppnrph <> 0 THEN
                nvl(mstd_ppnrph,0)
        END PPN_BKP,
        CASE WHEN mstd_ppnrph = 0 THEN
                nvl(mstd_ppnrph,0)
        END PPN_BTKP,
        CASE WHEN mstd_ppnrph <> 0 THEN
                nvl(mstd_ppnbmrph,0)
        END BM_BKP,
        CASE WHEN mstd_ppnrph = 0 THEN
                nvl(mstd_ppnbmrph,0)
        END BM_BTKP,
        CASE WHEN mstd_ppnrph <> 0 THEN
                nvl(mstd_ppnbtlrph,0)
        END BTL_BKP,
        CASE WHEN mstd_ppnrph = 0 THEN
                nvl(mstd_ppnbtlrph,0)
        END BTL_BTKP,
        CASE WHEN mstd_ppnrph <> 0 THEN
                (nvl(mstd_gross,0 )+ nvl(mstd_ppnrph,0) + nvl(mstd_ppnbmrph,0) + nvl(mstd_ppnbtlrph,0)) -
                (nvl(mstd_discrph,0))
        END TOTAL_BKP,
        CASE WHEN mstd_ppnrph = 0 THEN
                (nvl(mstd_gross,0 )+ nvl(mstd_ppnrph,0) + nvl(mstd_ppnbmrph,0) + nvl(mstd_ppnbtlrph,0)) -
                (nvl(mstd_discrph,0))
        END TOTAL_BTKP,
        nvl(mstd_avgcost,0)*nvl(mstd_qty,0) avg,
        mstd_prdcd, mstd_gross, mstd_discrph,
        (nvl(mstd_dis4cr,0) + nvl(mstd_dis4rr,0) + nvl(mstd_dis4jr,0))  disc4,
        nvl(mstd_ppnrph,0) mstd_ppn, nvl(mstd_ppnbmrph,0) mstd_bm, nvl(mstd_ppnbtlrph,0) mstd_btl,
        (nvl(mstd_gross,0 )+ nvl(mstd_ppnrph,0) + nvl(mstd_ppnbmrph,0) + nvl(mstd_ppnbtlrph,0)) - nvl(mstd_discrph,0) total,
        prs_namaperusahaan, prs_namacabang, prs_namawilayah
from tbtr_mstran_h, tbtr_mstran_d,tbmaster_divisi, tbmaster_prodmast,
        tbmaster_departement,tbmaster_kategori, tbmaster_perusahaan
where msth_typetrn='B'
        and msth_kodeigr = '" . Session::get('kdigr') . "'
        and mstd_kodeigr = '" . Session::get('kdigr') . "'
        and nvl(msth_recordid, '9') <> '1'
        and nvl(mstd_recordid, '9') <> '1'
        " . $and_doc . "
        and prs_kodeigr = msth_kodeigr
        and mstd_prdcd = prd_prdcd
        and div_kodedivisi(+) = mstd_kodedivisi
        and div_kodeigr(+) = mstd_kodeigr
        and dep_kodedivisi(+) = mstd_kodedivisi
        and dep_kodedepartement(+) = mstd_kodedepartement
        and dep_kodeigr(+) = mstd_kodeigr
        and kat_kodedepartement(+) = mstd_kodedepartement
        and kat_kodekategori (+) = mstd_kodekategoribrg
        and kat_kodeigr (+) = mstd_kodeigr
        " . $and_plu . "
        " . $and_div . "
        " . $and_dep . "
        " . $and_kat . "
        order by div_kodedivisi, dep_kodedepartement, kat_kodekategori)
group by mstd_kodedivisi, div_namadivisi, prd_flagbkp1, prd_flagbkp2,
        mstd_kodedepartement, dep_namadepartement, prd_prdcd,
        mstd_kodekategoribrg, kat_namakategori,
        prs_namaperusahaan, prs_namacabang, prs_namawilayah
order by mstd_kodedivisi, mstd_kodedepartement, mstd_kodekategoribrg");
            return view('BACKOFFICE.LAPORAN.daftar-pembelian-ringkasan-divdepkat-pdf', compact(['perusahaan', 'data', 'tgl1', 'tgl2']));

        }
        else if ($tipe === '2') {
            $and_sup = ' ';
            if (isset($mtr) && $mtr <> '') {
                $and_sup = " and mstd_kodemonitoring in (select msu_kodemonitoring from tbtr_monitoringsupplier
   		                    where msu_kodeigr = '" . Session::get('kdigr') . "' and msu_kodemonitoring = '" . $mtr . "')";
            }
            if (isset($sup1)) {
                $and_sup = " and sup_kodeigr = '" . Session::get('kdigr') . "' and sup_kodesupplier between '" . $sup1 . "' and '" . $sup2 . "'";
            }
            $data = DB::connection(Session::get('connection'))->select("select mstd_kodesupplier, sup_namasupplier,
        prs_namaperusahaan, prs_namacabang, prs_namawilayah,
        sum(mstd_gross) gross, sum(mstd_pot) pot, prd_flagbkp1, prd_flagbkp2, prd_prdcd,
        sum(mstd_ppn) ppn, sum(mstd_bm) bm, sum(mstd_btl) btl,
        sum(total) total,
        sum(GROSS_BKP) sum_gross_bkp, sum(GROSS_BTKP) sum_gross_btkp,
        sum(POT_BKP)sum_potongan_bkp, sum(POT_BTKP) sum_potongan_btkp,
        sum(PPN_BKP) sum_ppn_bkp, sum(PPN_BTKP) sum_ppn_btkp,
        sum(BM_BKP) sum_bm_bkp, sum(BM_BTKP) sum_bm_btkp,
        sum(BTL_BKP) sum_btl_bkp, sum(BTL_BTKP) sum_btl_btkp,
        sum(TOTAL_BKP) sum_total_bkp, sum(TOTAL_BTKP) sum_total_btkp
from (select mstd_kodesupplier, prd_flagbkp1, prd_flagbkp2, prd_prdcd, sup_namasupplier, nvl(mstd_avgcost,0)*nvl(mstd_qty,0) avg,
        CASE WHEN mstd_ppnrph <> 0 THEN
                nvl(mstd_gross,0)
        END GROSS_BKP,
        CASE WHEN mstd_ppnrph = 0 THEN
                nvl(mstd_gross,0)
        END GROSS_BTKP,
        CASE WHEN mstd_ppnrph <> 0 THEN
                nvl(mstd_discrph,0)
        END POT_BKP,
        CASE WHEN mstd_ppnrph = 0 THEN
                nvl(mstd_discrph,0)
        END POT_BTKP,
        CASE WHEN mstd_ppnrph <> 0 THEN
                nvl(mstd_ppnrph,0)
        END PPN_BKP,
        CASE WHEN mstd_ppnrph = 0 THEN
                nvl(mstd_ppnrph,0)
        END PPN_BTKP,
        CASE WHEN mstd_ppnrph <> 0 THEN
                nvl(mstd_ppnbmrph,0)
        END BM_BKP,
        CASE WHEN mstd_ppnrph = 0 THEN
                nvl(mstd_ppnbmrph,0)
        END BM_BTKP,
        CASE WHEN mstd_ppnrph <> 0 THEN
                nvl(mstd_ppnbtlrph,0)
        END BTL_BKP,
        CASE WHEN mstd_ppnrph = 0 THEN
                nvl(mstd_ppnbtlrph,0)
        END BTL_BTKP,
        CASE WHEN mstd_ppnrph <> 0 THEN
                (nvl(mstd_gross,0 )+ nvl(mstd_ppnrph,0) + nvl(mstd_ppnbmrph,0) + nvl(mstd_ppnbtlrph,0)) -
                (nvl(mstd_discrph,0))
        END TOTAL_BKP,
        CASE WHEN mstd_ppnrph = 0 THEN
                (nvl(mstd_gross,0 )+ nvl(mstd_ppnrph,0) + nvl(mstd_ppnbmrph,0) + nvl(mstd_ppnbtlrph,0)) -
                (nvl(mstd_discrph,0))
        END TOTAL_BTKP,
        mstd_prdcd, mstd_gross, nvl(mstd_discrph,0) mstd_pot,
        nvl(mstd_ppnrph,0) mstd_ppn, nvl(mstd_ppnbmrph,0) mstd_bm, nvl(mstd_ppnbtlrph,0) mstd_btl,
        (nvl(mstd_gross,0 )+ nvl(mstd_ppnrph,0) + nvl(mstd_ppnbmrph,0) + nvl(mstd_ppnbtlrph,0)) - (nvl(mstd_discrph,0)) total,
        prs_namaperusahaan, prs_namacabang, prs_namawilayah
from tbtr_mstran_h, tbtr_mstran_d, tbmaster_perusahaan, tbmaster_supplier, tbmaster_prodmast
where msth_typetrn='B'
        and msth_kodeigr='" . Session::get('kdigr') . "'
        " . $and_doc . "
        and nvl(msth_recordid, '9') <> '1'
        and mstd_kodeigr=msth_kodeigr
        and mstd_prdcd = prd_prdcd
        and prs_kodeigr=msth_kodeigr
       " . $and_sup . "
        and sup_kodesupplier = mstd_kodesupplier
        and sup_kodeigr = mstd_kodeigr
        order by sup_kodesupplier)
group by mstd_kodesupplier, sup_namasupplier, prd_flagbkp1, prd_flagbkp2, prd_prdcd,
        prs_namaperusahaan, prs_namacabang, prs_namawilayah
order by mstd_kodesupplier");

            return view('BACKOFFICE.LAPORAN.daftar-pembelian-ringkasan-per-supplier-pdf', compact(['perusahaan', 'data', 'tgl1', 'tgl2']));

        //ada tambahan flagbkp1 dan 2
        }
        else if ($tipe === '3') {
            $data = DB::connection(Session::get('connection'))->select("select no_doc, tgl_doc, plu, prd_deskripsipanjang, mstd_hrgsatuan, mstd_keterangan, acost, lcost, prd_flagbkp1, prd_flagbkp2,
        sum(ctn) ctn, sum(pcs) pcs, kemasan, prs_namaperusahaan, prs_namacabang, prs_namawilayah,
        mstd_kodedivisi, div_namadivisi,
        mstd_kodedepartement, dep_namadepartement,
        mstd_kodekategoribrg, kat_namakategori,
        sum(bonus) bonus, sum(gross) gross, sum(potongan) potongan,
        sum(bm) bm, sum(btl) btl, sum(ppn) ppn,
        sum(total) total,
        sum(GROSS_BKP) sum_gross_bkp, sum(GROSS_BTKP) sum_gross_btkp,
        sum(POT_BKP)sum_potongan_bkp, sum(POT_BTKP) sum_potongan_btkp,
        sum(PPN_BKP) sum_ppn_bkp, sum(PPN_BTKP) sum_ppn_btkp,
        sum(BM_BKP) sum_bm_bkp, sum(BM_BTKP) sum_bm_btkp,
        sum(BTL_BKP) sum_btl_bkp, sum(BTL_BTKP) sum_btl_btkp,
        sum(TOTAL_BKP) sum_total_bkp, sum(TOTAL_BTKP) sum_total_btkp
from (select
         CASE WHEN " . $sort . " = 1 THEN
                 msth_nodoc
         ELSE
                 msth_nopo
         END no_doc,
         CASE WHEN " . $sort . " = 1 THEN
                 msth_tgldoc
         ELSE
                 msth_tglpo
         END tgl_doc,
        mstd_prdcd plu, prd_deskripsipanjang, prd_flagbkp1, prd_flagbkp2, mstd_hrgsatuan, mstd_keterangan, mstd_avgcost acost,
        (((nvl(mstd_gross,0)-nvl(mstd_discrph,0)+nvl(mstd_ppnbmrph,0)+nvl(mstd_ppnbtlrph,0)) * nvl(mstd_frac,0)) /
        ((nvl(mstd_qty,0)*nvl(mstd_frac,0))+(mod(mstd_qty,mstd_frac))+nvl(mstd_qtybonus1,0))) lcost,
        floor(mstd_qty/prd_frac) ctn, mod(mstd_qty,prd_frac) pcs, prd_unit||'/'||prd_frac kemasan,
        CASE WHEN mstd_ppnrph <> 0 THEN
                nvl(mstd_gross,0)
        END GROSS_BKP,
        CASE WHEN mstd_ppnrph = 0 THEN
                nvl(mstd_gross,0)
        END GROSS_BTKP,
        CASE WHEN mstd_ppnrph <> 0 THEN
                nvl(mstd_discrph,0)
        END POT_BKP,
        CASE WHEN mstd_ppnrph = 0 THEN
                nvl(mstd_discrph,0)
        END POT_BTKP,
        CASE WHEN mstd_ppnrph <> 0 THEN
                nvl(mstd_ppnrph,0)
        END PPN_BKP,
        CASE WHEN mstd_ppnrph = 0 THEN
                nvl(mstd_ppnrph,0)
        END PPN_BTKP,
        CASE WHEN mstd_ppnrph <> 0 THEN
                nvl(mstd_ppnbmrph,0)
        END BM_BKP,
        CASE WHEN mstd_ppnrph = 0 THEN
                nvl(mstd_ppnbmrph,0)
        END BM_BTKP,
        CASE WHEN mstd_ppnrph <> 0 THEN
                nvl(mstd_ppnbtlrph,0)
        END BTL_BKP,
        CASE WHEN mstd_ppnrph = 0 THEN
                nvl(mstd_ppnbtlrph,0)
        END BTL_BTKP,
        CASE WHEN mstd_ppnrph <> 0 THEN
                (nvl(mstd_gross,0 )+ nvl(mstd_ppnrph,0) + nvl(mstd_ppnbmrph,0) + nvl(mstd_ppnbtlrph,0)) - nvl(mstd_discrph,0)
        END TOTAL_BKP,
        CASE WHEN mstd_ppnrph = 0 THEN
                (nvl(mstd_gross,0 )+ nvl(mstd_ppnrph,0) + nvl(mstd_ppnbmrph,0) + nvl(mstd_ppnbtlrph,0)) - nvl(mstd_discrph,0)
        END TOTAL_BTKP,
        prs_namaperusahaan, prs_namacabang, prs_namawilayah,
        mstd_kodedivisi, div_namadivisi,
        mstd_kodedepartement, dep_namadepartement,
        mstd_kodekategoribrg, kat_namakategori,
        (nvl(mstd_qtybonus1,0)+nvl(mstd_qtybonus2,0)) bonus,
        nvl(mstd_gross,0) gross, nvl(mstd_discrph,0) potongan,
        nvl(mstd_ppnbmrph,0) bm, nvl(mstd_ppnbtlrph,0) btl,
        nvl(mstd_ppnrph,0) ppn,
        (nvl(mstd_gross,0 )+ nvl(mstd_ppnrph,0) + nvl(mstd_ppnbmrph,0) + nvl(mstd_ppnbtlrph,0)) - nvl(mstd_discrph,0) total
from tbtr_mstran_h, tbtr_mstran_d, tbmaster_prodmast, tbmaster_perusahaan,
        tbmaster_divisi, tbmaster_departement, tbmaster_kategori
where msth_typetrn='B'
        and msth_kodeigr='" . Session::get('kdigr') . "'
        and mstd_kodeigr='" . Session::get('kdigr') . "'
        and nvl(msth_recordid, '9') <> '1'
        and nvl(mstd_recordid, '9') <> '1'
        " . $and_doc . "
        and prd_prdcd(+) = mstd_prdcd
        and prs_kodeigr=msth_kodeigr
        and prd_kodeigr(+)=mstd_kodeigr
        and div_kodeigr(+) = mstd_kodeigr
        and div_kodedivisi(+) = mstd_kodedivisi
        and dep_kodeigr(+) = mstd_kodeigr
        and dep_kodedivisi(+) = mstd_kodedivisi
        and dep_kodedepartement(+) = mstd_kodedepartement
        and kat_kodeigr(+) = mstd_kodeigr
        and kat_kodedepartement(+) = mstd_kodedepartement
        and kat_kodekategori(+) = mstd_kodekategoribrg
       " . $and_plu . "
       " . $and_div . "
        " . $and_dep . "
        " . $and_kat . "
        order by mstd_kodedivisi, mstd_kodedepartement, mstd_kodekategoribrg, no_doc, tgl_doc)
group by
        no_doc, tgl_doc,
        prd_flagbkp1, prd_flagbkp2,
        plu, prd_deskripsipanjang, mstd_hrgsatuan, mstd_keterangan, acost, lcost,
        ctn, pcs, kemasan, prs_namaperusahaan, prs_namacabang, prs_namawilayah,
        mstd_kodedivisi, div_namadivisi,
        mstd_kodedepartement, dep_namadepartement,
        mstd_kodekategoribrg, kat_namakategori
order by mstd_kodedivisi, mstd_kodedepartement, mstd_kodekategoribrg, no_doc, tgl_doc");
            set_time_limit(0);

            //excel
            $title = 'Daftar Pembelian Rincian Produk Per Divisi / Departemen / Kategori';
            $subtitle = '';
            $keterangan = 'Tanggal :  ' . $tgl1 . '  -  ' . $tgl2;
            $filename = str_replace('/', ' ', $title) . '_' . Carbon::now()->format('dmY_His') . '.xlsx';
            $view = view('BACKOFFICE.LAPORAN.daftar-pembelian-rincian-per-divdepkat-xlxs', compact(['perusahaan', 'data', 'tgl1', 'tgl2']))->render();
            ExcelController::create($view, $filename, $title, $subtitle, $keterangan);
            return response()->download(storage_path($filename))->deleteFileAfterSend(true);

//            return view('BACKOFFICE.LAPORAN.daftar-pembelian-rincian-per-divdepkat-pdf', compact(['perusahaan', 'data', 'tgl1', 'tgl2']));

        //ada tambah flagbkp1 dan flagbkp2
        } else if ($tipe === '4') {
            $data = DB::connection(Session::get('connection'))->select("select no_doc, tgl_doc, msth_tglpo, plu, prd_deskripsipanjang, mstd_hrgsatuan, mstd_keterangan, acost, lcost, prd_flagbkp1, prd_flagbkp2,
        ctn, pcs, kemasan, prs_namaperusahaan, prs_namacabang, prs_namawilayah,
        mstd_kodesupplier, sup_namasupplier,
        sum(bonus) bonus, sum(gross) gross, sum(potongan) potongan,
        sum(bm) bm, sum(btl) btl, sum(ppn) ppn,
        sum(total) total,
        sum(GROSS_BKP) sum_gross_bkp, sum(GROSS_BTKP) sum_gross_btkp,
        sum(POT_BKP)sum_potongan_bkp, sum(POT_BTKP) sum_potongan_btkp,
        sum(PPN_BKP) sum_ppn_bkp, sum(PPN_BTKP) sum_ppn_btkp,
        sum(BM_BKP) sum_bm_bkp, sum(BM_BTKP) sum_bm_btkp,
        sum(BTL_BKP) sum_btl_bkp, sum(BTL_BTKP) sum_btl_btkp,
        sum(TOTAL_BKP) sum_total_bkp, sum(TOTAL_BTKP) sum_total_btkp
from (select
         CASE WHEN  " . $sort . " = 1 THEN
                   msth_nodoc
         ELSE
                   msth_nopo
         END no_doc,
         CASE WHEN  " . $sort . " = 1 THEN
                 msth_tgldoc
         ELSE
                 msth_tglpo
         END tgl_doc,
        msth_tglpo, mstd_prdcd plu, prd_flagbkp1, prd_flagbkp2, prd_deskripsipanjang, mstd_hrgsatuan, mstd_keterangan, mstd_avgcost acost,
        (((nvl(mstd_gross,0)-nvl(mstd_discrph,0)+nvl(mstd_ppnbmrph,0)+nvl(mstd_ppnbtlrph,0)) * nvl(mstd_frac,0)) /
        ((nvl(mstd_qty,0)*nvl(mstd_frac,0))+(mod(mstd_qty,mstd_frac))+nvl(mstd_qtybonus1,0))) lcost,
        floor(mstd_qty/prd_frac) ctn, mod(mstd_qty,prd_frac) pcs, prd_unit||'/'||prd_frac kemasan,
        CASE WHEN mstd_ppnrph <> 0 THEN
                nvl(mstd_gross,0)
        END GROSS_BKP,
        CASE WHEN mstd_ppnrph = 0 THEN
                nvl(mstd_gross,0)
        END GROSS_BTKP,
        CASE WHEN mstd_ppnrph <> 0 THEN
                nvl(mstd_discrph,0)
        END POT_BKP,
        CASE WHEN mstd_ppnrph = 0 THEN
                nvl(mstd_discrph,0)
        END POT_BTKP,
        CASE WHEN mstd_ppnrph <> 0 THEN
                nvl(mstd_ppnbmrph,0)
        END BM_BKP,
        CASE WHEN mstd_ppnrph = 0 THEN
                nvl(mstd_ppnbmrph,0)
        END BM_BTKP,
        CASE WHEN mstd_ppnrph <> 0 THEN
                nvl(mstd_ppnbtlrph,0)
        END BTL_BKP,
        CASE WHEN mstd_ppnrph = 0 THEN
                nvl(mstd_ppnbtlrph,0)
        END BTL_BTKP,
        CASE WHEN mstd_ppnrph <> 0 THEN
                nvl(mstd_ppnrph,0)
        END PPN_BKP,
        CASE WHEN mstd_ppnrph = 0 THEN
                nvl(mstd_ppnrph,0)
        END PPN_BTKP,
        CASE WHEN mstd_ppnrph <> 0 THEN
                (nvl(mstd_gross,0 )+ nvl(mstd_ppnrph,0) + nvl(mstd_ppnbmrph,0) + nvl(mstd_ppnbtlrph,0)) - nvl(mstd_discrph,0)
        END TOTAL_BKP,
        CASE WHEN mstd_ppnrph = 0 THEN
                (nvl(mstd_gross,0 )+ nvl(mstd_ppnrph,0) + nvl(mstd_ppnbmrph,0) + nvl(mstd_ppnbtlrph,0)) - nvl(mstd_discrph,0)
        END TOTAL_BTKP,
        prs_namaperusahaan, prs_namacabang, prs_namawilayah, mstd_kodesupplier, sup_namasupplier,
        (nvl(mstd_qtybonus1,0)+nvl(mstd_qtybonus2,0)) bonus,
        nvl(mstd_gross,0) gross,
        nvl(mstd_discrph,0) potongan,
        nvl(mstd_ppnbmrph,0) bm, nvl(mstd_ppnbtlrph,0) btl,
        nvl(mstd_ppnrph,0) ppn,
        (nvl(mstd_gross,0) + nvl(mstd_ppnbmrph,0) + nvl(mstd_ppnbtlrph,0)+nvl(mstd_ppnrph,0))-nvl(mstd_discrph,0) total
   from tbtr_mstran_h, tbtr_mstran_d, tbmaster_prodmast, tbmaster_perusahaan,
        tbmaster_supplier
   where msth_kodeigr='" . Session::get('kdigr') . "'
        and msth_typetrn='B'
        " . $and_doc . "
        and nvl(msth_recordid, '9') <> '1'
        and nvl(mstd_recordid, '9') <> '1'
        " . $and_sup . "
        and mstd_kodeigr=msth_kodeigr
        and prd_prdcd(+)=mstd_prdcd
        and prd_kodeigr(+)=mstd_kodeigr
        and prs_kodeigr=msth_kodeigr
        and sup_kodesupplier = msth_kodesupplier
        and sup_kodeigr=msth_kodeigr
        )
group by no_doc, tgl_doc, msth_tglpo, plu, prd_deskripsipanjang,
    mstd_hrgsatuan, mstd_keterangan, acost, lcost,
    mstd_kodesupplier, sup_namasupplier,prd_flagbkp1, prd_flagbkp2,
    ctn, pcs, kemasan, prs_namaperusahaan, prs_namacabang, prs_namawilayah
order by mstd_kodesupplier, no_doc, tgl_doc");
            set_time_limit(0);

            //excel
            $title = 'Daftar Pembelian Rincian Produk Per Supplier';
            $subtitle = '';
            $keterangan = 'Tanggal :  ' . $tgl1 . '  -  ' . $tgl2;
            $filename = $title . '_' . Carbon::now()->format('dmY_His') . '.xlsx';
            $view = view('BACKOFFICE.LAPORAN.daftar-pembelian-rincian-produk-per-supplier-xlxs', compact(['perusahaan', 'data', 'tgl1', 'tgl2']))->render();
            ExcelController::create($view, $filename, $title, $subtitle, $keterangan);
            return response()->download(storage_path($filename))->deleteFileAfterSend(true);

//            return view('BACKOFFICE.LAPORAN.daftar-pembelian-rincian-produk-per-supplier-pdf', compact(['perusahaan', 'data', 'tgl1', 'tgl2']));

        } else if ($tipe === '5') {

            $data = DB::connection(Session::get('connection'))
                ->select("select no_doc, tgl_doc, plu, prd_deskripsipanjang, mstd_hrgsatuan, mstd_keterangan, acost, lcost,
        ctn, pcs, kemasan, prs_namaperusahaan, prs_namacabang, prs_namawilayah, prd_flagbkp1, prd_flagbkp2,
        mstd_kodedivisi, div_namadivisi,
        mstd_kodedepartement, dep_namadepartement,
        mstd_kodekategoribrg, kat_namakategori,
        sum(bonus) bonus, sum(gross) gross, sum(potongan) potongan,
        sum(bm) bm, sum(btl) btl, sum(ppn) ppn,
        sum(total) total, sum(avgcost) avgcost,
        sum(GROSS_BKP) sum_gross_bkp, sum(GROSS_BTKP) sum_gross_btkp,
        sum(POT_BKP)sum_potongan_bkp, sum(POT_BTKP) sum_potongan_btkp,
        sum(PPN_BKP) sum_ppn_bkp, sum(PPN_BTKP) sum_ppn_btkp,
        sum(BM_BKP) sum_bm_bkp, sum(BM_BTKP) sum_bm_btkp,
        sum(BTL_BKP) sum_btl_bkp, sum(BTL_BTKP) sum_btl_btkp,
        sum(TOTAL_BKP) sum_total_bkp, sum(TOTAL_BTKP) sum_total_btkp
from (select
         CASE WHEN " . $sort . " = 1 THEN
                 msth_nodoc
         ELSE
                 msth_nopo
         END no_doc,
         CASE WHEN " . $sort . " = 1 THEN
                 msth_tgldoc
         ELSE
                 msth_tglpo
         END tgl_doc,
        mstd_prdcd plu, prd_deskripsipanjang, prd_flagbkp1, prd_flagbkp2, mstd_hrgsatuan, mstd_keterangan, mstd_avgcost acost, mstd_ocost lcost,
        floor(mstd_qty/prd_frac) ctn, mod(mstd_qty,prd_frac) pcs, prd_unit||'/'||prd_frac kemasan,
        CASE WHEN mstd_ppnrph <> 0 THEN
                nvl(mstd_gross,0)
        END GROSS_BKP,
        CASE WHEN mstd_ppnrph = 0 THEN
                nvl(mstd_gross,0)
        END GROSS_BTKP,
        CASE WHEN mstd_ppnrph <> 0 THEN
                nvl(mstd_discrph,0)
        END POT_BKP,
        CASE WHEN mstd_ppnrph = 0 THEN
                nvl(mstd_discrph,0)
        END POT_BTKP,
        CASE WHEN mstd_ppnrph <> 0 THEN
                nvl(mstd_ppnrph,0)
        END PPN_BKP,
        CASE WHEN mstd_ppnrph = 0 THEN
                nvl(mstd_ppnrph,0)
        END PPN_BTKP,
        CASE WHEN mstd_ppnrph <> 0 THEN
                nvl(mstd_ppnbmrph,0)
        END BM_BKP,
        CASE WHEN mstd_ppnrph = 0 THEN
                nvl(mstd_ppnbmrph,0)
        END BM_BTKP,
        CASE WHEN mstd_ppnrph <> 0 THEN
                nvl(mstd_ppnbtlrph,0)
        END BTL_BKP,
        CASE WHEN mstd_ppnrph = 0 THEN
                nvl(mstd_ppnbtlrph,0)
        END BTL_BTKP,
        CASE WHEN mstd_ppnrph <> 0 THEN
                (nvl(mstd_gross,0 )+ nvl(mstd_ppnrph,0) + nvl(mstd_ppnbmrph,0) + nvl(mstd_ppnbtlrph,0)) - nvl(mstd_discrph,0)
        END TOTAL_BKP,
        CASE WHEN mstd_ppnrph = 0 THEN
                (nvl(mstd_gross,0 )+ nvl(mstd_ppnrph,0) + nvl(mstd_ppnbmrph,0) + nvl(mstd_ppnbtlrph,0)) - nvl(mstd_discrph,0)
        END TOTAL_BTKP,
        prs_namaperusahaan, prs_namacabang, prs_namawilayah,
        mstd_kodedivisi, div_namadivisi,
        mstd_kodedepartement, dep_namadepartement,
        mstd_kodekategoribrg, kat_namakategori,
        (nvl(mstd_qtybonus1,0)+nvl(mstd_qtybonus2,0)) bonus,
        nvl(mstd_gross,0) gross, nvl(mstd_discrph,0) potongan,
        nvl(mstd_ppnbmrph,0) bm, nvl(mstd_ppnbtlrph,0) btl,
        nvl(mstd_ppnrph,0) ppn,
        (nvl(mstd_gross,0) + nvl(mstd_ppnbmrph,0) + nvl(mstd_ppnbtlrph,0)+nvl(mstd_ppnrph,0))-nvl(mstd_discrph,0) total,
        ((floor(mstd_qty/mstd_frac) + mod(mstd_qty,mstd_frac))* nvl(mstd_avgcost,0)) avgcost
from tbtr_mstran_h, tbtr_mstran_d, tbmaster_prodmast, tbmaster_perusahaan,
        tbmaster_divisi, tbmaster_departement, tbmaster_kategori
where msth_typetrn = 'B'
        and msth_kodeigr='" . Session::get('kdigr') . "'
        and mstd_kodeigr='" . Session::get('kdigr') . "'
        and nvl(msth_recordid, '9') <> '1'
        and nvl(mstd_recordid, '9') <> '1'
        " . $and_doc . "
        and prd_prdcd(+)=mstd_prdcd
        and prd_kodeigr(+)=mstd_kodeigr
        and prs_kodeigr=msth_kodeigr
        and div_kodedivisi(+) = mstd_kodedivisi
        and div_kodeigr(+) = mstd_kodeigr
        " . $and_div . "
        and dep_kodedivisi(+) = mstd_kodedivisi
        and dep_kodedepartement(+) = mstd_kodedepartement
        and dep_kodeigr(+) = mstd_kodeigr
        " . $and_dep . "
        and kat_kodedepartement(+) = mstd_kodedepartement
        and kat_kodekategori(+) = mstd_kodekategoribrg
        and kat_kodeigr(+) = mstd_kodeigr
         " . $and_kat . "
         order by tgl_doc)
group by no_doc, tgl_doc, plu, prd_deskripsipanjang, prd_flagbkp1, prd_flagbkp2, mstd_hrgsatuan, mstd_keterangan, acost, lcost,
    ctn, pcs, kemasan, prs_namaperusahaan, prs_namacabang, prs_namawilayah,
    mstd_kodedivisi, div_namadivisi,
    mstd_kodedepartement, dep_namadepartement,
    mstd_kodekategoribrg, kat_namakategori
order by mstd_kodedivisi,mstd_kodedepartement,mstd_kodekategoribrg,tgl_doc");
            set_time_limit(0);

//            return view('BACKOFFICE.LAPORAN.daftar-penerimaan-produk-divdepkat-pdf', compact(['perusahaan', 'data', 'tgl1', 'tgl2']));

            $title = 'Daftar Penerimaan Lain-lain';
            $filename = str_replace('/', '', $title) . '_' . Carbon::now()->format('dmY_His') . '.xlsx';
            $subtitle = "Tanggal : " . $tgl1 . '-' . $tgl2;
            $view = view('BACKOFFICE.LAPORAN.daftar-penerimaan-produk-divdepkat-xlxs', compact(['perusahaan', 'data', 'tgl1', 'tgl2']))->render();
            $keterangan = "";
            ExcelController::create($view, $filename, $title, $subtitle, $keterangan);
            return response()->download(storage_path($filename))->deleteFileAfterSend(true);


        } else if ($tipe === '6') {
            $data = DB::connection(Session::get('connection'))->select("select msth_nodoc, msth_tgldoc, msth_nopo, msth_tglpo, plu, prd_deskripsipanjang, prd_flagbkp1, prd_flagbkp2, mstd_hrgsatuan, mstd_keterangan, acost, lcost,
        ctn, pcs, kemasan, prs_namaperusahaan, prs_namacabang, prs_namawilayah,
        msth_kodesupplier, sup_namasupplier,mstd_nodoc, mstd_tgldoc,
        sum(bonus) bonus, sum(gross) gross, sum(potongan) potongan,
        sum(bm) bm, sum(btl) btl, sum(ppn) ppn,
        sum(total) total,
        sum(GROSS_BKP) sum_gross_bkp, sum(GROSS_BTKP) sum_gross_btkp,
        sum(POT_BKP)sum_potongan_bkp, sum(POT_BTKP) sum_potongan_btkp,
        sum(PPN_BKP) sum_ppn_bkp, sum(PPN_BTKP) sum_ppn_btkp,
        sum(BM_BKP) sum_bm_bkp, sum(BM_BTKP) sum_bm_btkp,
        sum(BTL_BKP) sum_btl_bkp, sum(BTL_BTKP) sum_btl_btkp,
        sum(TOTAL_BKP) sum_total_bkp, sum(TOTAL_BTKP) sum_total_btkp
from (select msth_nodoc, msth_tgldoc, msth_nopo, msth_tglpo, mstd_prdcd plu, prd_deskripsipanjang, mstd_hrgsatuan, mstd_keterangan, mstd_avgcost acost, prd_flagbkp1, prd_flagbkp2,
        (((nvl(mstd_gross,0)-nvl(mstd_discrph,0)+nvl(mstd_ppnbmrph,0)+nvl(mstd_ppnbtlrph,0)) * nvl(mstd_frac,0)) /
        ((nvl(mstd_qty,0)*nvl(mstd_frac,0))+(mod(mstd_qty,mstd_frac))+nvl(mstd_qtybonus1,0))) lcost,
        floor(mstd_qty/prd_frac) ctn, mod(mstd_qty,prd_frac) pcs, prd_unit||'/'||prd_frac kemasan,
        CASE WHEN mstd_ppnrph <> 0 THEN
                nvl(mstd_gross,0)
        END GROSS_BKP,
        CASE WHEN mstd_ppnrph = 0 THEN
                nvl(mstd_gross,0)
        END GROSS_BTKP,
        CASE WHEN mstd_ppnrph <> 0 THEN
                nvl(mstd_discrph,0)
        END POT_BKP,
        CASE WHEN mstd_ppnrph = 0 THEN
                nvl(mstd_discrph,0)
        END POT_BTKP,
        CASE WHEN mstd_ppnrph <> 0 THEN
                nvl(mstd_ppnrph,0)
        END PPN_BKP,
        CASE WHEN mstd_ppnrph = 0 THEN
                nvl(mstd_ppnrph,0)
        END PPN_BTKP,
        CASE WHEN mstd_ppnrph <> 0 THEN
                nvl(mstd_ppnbmrph,0)
        END BM_BKP,
        CASE WHEN mstd_ppnrph = 0 THEN
                nvl(mstd_ppnbmrph,0)
        END BM_BTKP,
        CASE WHEN mstd_ppnrph <> 0 THEN
                nvl(mstd_ppnbtlrph,0)
        END BTL_BKP,
        CASE WHEN mstd_ppnrph = 0 THEN
                nvl(mstd_ppnbtlrph,0)
        END BTL_BTKP,
        CASE WHEN mstd_ppnrph <> 0 THEN
                (nvl(mstd_gross,0 )+ nvl(mstd_ppnrph,0) + nvl(mstd_ppnbmrph,0) + nvl(mstd_ppnbtlrph,0)) - nvl(mstd_discrph,0)
        END TOTAL_BKP,
        CASE WHEN mstd_ppnrph = 0 THEN
                (nvl(mstd_gross,0 )+ nvl(mstd_ppnrph,0) + nvl(mstd_ppnbmrph,0) + nvl(mstd_ppnbtlrph,0)) - nvl(mstd_discrph,0)
        END TOTAL_BTKP,
        prs_namaperusahaan, prs_namacabang, prs_namawilayah,
        msth_kodesupplier, sup_namasupplier, mstd_nodoc, mstd_tgldoc,
        (nvl(mstd_qtybonus1,0)+nvl(mstd_qtybonus2,0)) bonus,
        nvl(mstd_gross,0) gross,
        nvl(mstd_discrph,0) potongan,
        nvl(mstd_ppnbmrph,0) bm, nvl(mstd_ppnbtlrph,0) btl,
        nvl(mstd_ppnrph,0) ppn,
        (nvl(mstd_gross,0) + nvl(mstd_ppnbmrph,0) + nvl(mstd_ppnbtlrph,0)+nvl(mstd_ppnrph,0))-nvl(mstd_discrph,0) total
    from tbtr_mstran_h, tbtr_mstran_d, tbmaster_prodmast, tbmaster_perusahaan,
        tbmaster_supplier
    where msth_kodeigr='" . Session::get('kdigr') . "'
        and msth_typetrn='B'
        and nvl(msth_recordid, '9') <> '1'
        " . $and_doc . "
        " . $and_sup . "
        and mstd_kodeigr=msth_kodeigr
        and prd_prdcd(+)=mstd_prdcd
        and prd_kodeigr(+)=mstd_kodeigr
        and prs_kodeigr=msth_kodeigr
        and sup_kodesupplier = mstd_kodesupplier
        and sup_kodeigr=mstd_kodeigr
        " . $p_order . ")
group by msth_nodoc, msth_tgldoc, msth_nopo, msth_tglpo, plu, prd_deskripsipanjang,
    mstd_hrgsatuan, mstd_keterangan, acost, lcost, prd_flagbkp1, prd_flagbkp2,
    msth_kodesupplier, sup_namasupplier,mstd_nodoc, mstd_tgldoc,
    ctn, pcs, kemasan, prs_namaperusahaan, prs_namacabang, prs_namawilayah
" . $p_order);

//            return view('BACKOFFICE.LAPORAN.daftar-pembelian-rincian-produk-per-supplier-per-dokumen-pdf', compact(['perusahaan', 'data', 'tgl1', 'tgl2']));
            set_time_limit(0);

            $title = '    Daftar Pembelian Rincian Produk Per Supplier Per Dokumen';
            $filename = str_replace('/', '', $title) . '_' . Carbon::now()->format('dmY_His') . '.xlsx';
            $subtitle = "Tanggal : " . $tgl1 . '-' . $tgl2;
            $view = view('BACKOFFICE.LAPORAN.daftar-pembelian-rincian-produk-per-supplier-per-dokumen-xlxs', compact(['perusahaan', 'data', 'tgl1', 'tgl2']))->render();
            $keterangan = "";
            ExcelController::create($view, $filename, $title, $subtitle, $keterangan);
            return response()->download(storage_path($filename))->deleteFileAfterSend(true);

        } else if ($tipe === '7') {
            $data = DB::connection(Session::get('connection'))->select("select msth_nodoc, msth_tgldoc,  top, jth_tempo, msth_nopo, msth_tglpo, msth_nofaktur, msth_tglfaktur,prd_flagbkp1, prd_flagbkp2, prd_prdcd,
        supplier,prs_namaperusahaan, prs_namacabang, prs_namawilayah, msth_kodesupplier,
        sum(gross) gross, sum(potongan) potongan, sum(bm) bm, sum(btl) btl,
        sum(dpp) dpp, sum(ppn) ppn, sum(total) total,
        sum(GROSS_BKP) sum_gross_bkp, sum(GROSS_BTKP) sum_gross_btkp,
        sum(POT_BKP)sum_potongan_bkp, sum(POT_BTKP) sum_potongan_btkp,
        sum(PPN_BKP) sum_ppn_bkp, sum(PPN_BTKP) sum_ppn_btkp,
        sum(BM_BKP) sum_bm_bkp, sum(BM_BTKP) sum_bm_btkp,
        sum(BTL_BKP) sum_btl_bkp, sum(BTL_BTKP) sum_btl_btkp,
        sum(DPP_BKP) sum_dpp_bkp, sum(DPP_BTKP) sum_dpp_btkp,
        sum(TOTAL_BKP) sum_total_bkp, sum(TOTAL_BTKP) sum_total_btkp
from (select msth_nodoc, msth_tgldoc, msth_cterm top, msth_tgldoc+msth_cterm jth_tempo,
        msth_nopo, msth_tglpo, msth_nofaktur, msth_tglfaktur, prd_flagbkp1, prd_flagbkp2, prd_prdcd,
        CASE WHEN mstd_ppnrph <> 0 THEN
                nvl(mstd_gross,0)
        END GROSS_BKP,
        CASE WHEN mstd_ppnrph = 0 THEN
                nvl(mstd_gross,0)
        END GROSS_BTKP,
        CASE WHEN mstd_ppnrph <> 0 THEN
                nvl(mstd_discrph,0)
        END POT_BKP,
        CASE WHEN mstd_ppnrph = 0 THEN
                nvl(mstd_discrph,0)
        END POT_BTKP,
        CASE WHEN mstd_ppnrph <> 0 THEN
                nvl(mstd_ppnrph,0)
        END PPN_BKP,
        CASE WHEN mstd_ppnrph = 0 THEN
                nvl(mstd_ppnrph,0)
        END PPN_BTKP,
        CASE WHEN mstd_ppnrph <> 0 THEN
                nvl(mstd_ppnbmrph,0)
        END BM_BKP,
        CASE WHEN mstd_ppnrph = 0 THEN
                nvl(mstd_ppnbmrph,0)
        END BM_BTKP,
        CASE WHEN mstd_ppnrph <> 0 THEN
                nvl(mstd_ppnbtlrph,0)
        END BTL_BKP,
        CASE WHEN mstd_ppnrph = 0 THEN
                nvl(mstd_ppnbtlrph,0)
        END BTL_BTKP,
        CASE WHEN mstd_ppnrph <> 0 THEN
                (nvl(mstd_gross,0) + nvl(mstd_ppnbmrph,0) + nvl(mstd_ppnbtlrph,0))-nvl(mstd_discrph,0)
        END DPP_BKP,
        CASE WHEN mstd_ppnrph = 0 THEN
                (nvl(mstd_gross,0) + nvl(mstd_ppnbmrph,0) + nvl(mstd_ppnbtlrph,0))-nvl(mstd_discrph,0)
        END DPP_BTKP,
        CASE WHEN mstd_ppnrph <> 0 THEN
                (nvl(mstd_gross,0 )+ nvl(mstd_ppnrph,0) + nvl(mstd_ppnbmrph,0) + nvl(mstd_ppnbtlrph,0)) - nvl(mstd_discrph,0)
        END TOTAL_BKP,
        CASE WHEN mstd_ppnrph = 0 THEN
                (nvl(mstd_gross,0 )+ nvl(mstd_ppnrph,0) + nvl(mstd_ppnbmrph,0) + nvl(mstd_ppnbtlrph,0)) - nvl(mstd_discrph,0)
        END TOTAL_BTKP,
        msth_kodesupplier,
        nvl(mstd_gross,0) gross, nvl(mstd_discrph,0) potongan,
        nvl(mstd_ppnbmrph,0) bm, nvl(mstd_ppnbtlrph,0) btl,
        (nvl(mstd_gross,0) + nvl(mstd_ppnbmrph,0) + nvl(mstd_ppnbtlrph,0))-nvl(mstd_discrph,0) dpp,
        nvl(mstd_ppnrph,0) ppn,
        (nvl(mstd_gross,0) + nvl(mstd_ppnbmrph,0) + nvl(mstd_ppnbtlrph,0)+nvl(mstd_ppnrph,0))-nvl(mstd_discrph,0) total,
        sup_kodesupplier||' - '||sup_namasupplier supplier,
        prs_namaperusahaan, prs_namacabang, prs_namawilayah
from tbtr_mstran_h, tbtr_mstran_d, tbmaster_supplier, tbmaster_perusahaan, tbmaster_prodmast
where msth_kodeigr='" . Session::get('kdigr') . "'
        and msth_typetrn='B'
        and nvl(msth_recordid, '9') <> '1'
        " . $and_doc . "
        and mstd_kodeigr=msth_kodeigr
        and mstd_prdcd = prd_prdcd
        and sup_kodesupplier = msth_kodesupplier
        and sup_kodeigr=msth_kodeigr
      " . $and_sup . "
        and prs_kodeigr=msth_kodeigr
       " . $p_order . ")
group by msth_nodoc, msth_tgldoc, prd_flagbkp1, prd_flagbkp2, prd_prdcd,  top, jth_tempo, msth_nopo, msth_tglpo, msth_nofaktur, msth_tglfaktur, 
        supplier,prs_namaperusahaan, prs_namacabang, prs_namawilayah, msth_kodesupplier
" . $p_order);
            set_time_limit(0);

//            return view('BACKOFFICE.LAPORAN.daftar-pembelian-rincian-dokumen-per-supplier-pdf', compact(['perusahaan', 'data', 'tgl1', 'tgl2']));
//            return view('BACKOFFICE.LAPORAN.daftar-pembelian-rincian-dokumen-per-supplier-xlxs', compact(['perusahaan', 'data', 'tgl1', 'tgl2']))->render();

            $title = 'Daftar Pembelian Rincian Dokumen Per Supplier';
            $filename = str_replace('/', '', $title) . '_' . Carbon::now()->format('dmY_His') . '.xlsx';
            $subtitle = "Tanggal : " . $tgl1 . '-' . $tgl2;
            $view = view('BACKOFFICE.LAPORAN.daftar-pembelian-rincian-dokumen-per-supplier-xlxs', compact(['perusahaan', 'data', 'tgl1', 'tgl2']))->render();
            $keterangan = "";
            ExcelController::create($view, $filename, $title, $subtitle, $keterangan);
            return response()->download(storage_path($filename))->deleteFileAfterSend(true);
        }
    }
}
