<?php

namespace App\Http\Controllers\BACKOFFICE\LAPORAN;

use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller; use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;
use PDF;
use Yajra\DataTables\DataTables;
use ZipArchive;
use File;

class DaftarReturPembelianController extends Controller
{
    public function index()
    {
        return view('BACKOFFICE.LAPORAN.daftar-retur-pembelian');
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
        $and_div = '';
        $and_dep = '';
        $and_kat = '';
        $and_sup = '';

        $perusahaan = DB::connection(Session::get('connection'))->table('tbmaster_perusahaan')
            ->select('prs_namaperusahaan', 'prs_namacabang')
            ->first();

        if (isset($div1) && isset($div2)) {
            $and_div = " AND mstd_kodedivisi BETWEEN '" . $div1 . "' AND '" . $div2 . "'";
        }
        if (isset($dep1) && isset($dep2)) {
            $and_dep = " AND mstd_kodedepartement BETWEEN '" . $dep1 . "' AND '" . $dep2 . "'";
        }
        if (isset($kat1) && isset($kat2)) {
            $and_kat = " AND mstd_kodekategoribrg BETWEEN '" . $kat1 . "' AND '" . $kat2 . "'";
        }
        if (isset($sup1) && isset($sup2)) {
            $and_sup = " and mstd_kodesupplier(+) between '" . $sup1 . "' and '" . $sup2 . "'";
        }

        if ($tipe === '1') {
            $data = DB::connection(Session::get('connection'))
                ->select("select mstd_kodedivisi, div_namadivisi,
                mstd_kodedepartement, dep_namadepartement,
                mstd_kodekategoribrg, kat_namakategori,
                prs_namaperusahaan, prs_namacabang,
                sum(gross) gross, sum(mstd_pot) pot,
                sum(mstd_ppn) ppn, sum(mstd_bm) bm, sum(mstd_btl) btl,
                sum(total) total, sum(avg) avg
        from (select mstd_kodedivisi, div_namadivisi,
                mstd_kodedepartement, dep_namadepartement,
                mstd_kodekategoribrg, kat_namakategori,
                CASE WHEN NVL(mstd_recordid,'9') = '1' THEN mstd_gross * -1 ELSE mstd_gross END gross,
        CASE WHEN NVL(mstd_recordid,'9') = '1' THEN
                       CASE WHEN mstd_unit = 'KG' THEN
                             ((mstd_qty / 1000) * (mstd_avgcost / 1000)) * -1
                       ELSE
                             (mstd_qty* (mstd_avgcost / mstd_frac)) * -1
                       END
                ELSE
                CASE WHEN mstd_unit = 'KG' THEN
                             (mstd_qty / 1000) * (mstd_avgcost / 1000)
                       ELSE
                             mstd_qty* (mstd_avgcost / mstd_frac)
                       END
                END avg,
                CASE WHEN NVL(mstd_recordid,'9') = '1' THEN nvl(mstd_discrph,0) * -1 ELSE nvl(mstd_discrph,0) END mstd_pot,
                CASE WHEN NVL(mstd_recordid,'9') = '1' THEN nvl(mstd_ppnrph,0) * -1 ELSE nvl(mstd_ppnrph,0) END mstd_ppn,
                CASE WHEN NVL(mstd_recordid,'9') = '1' THEN nvl(mstd_ppnbmrph,0) * -1 ELSE nvl(mstd_ppnbmrph,0) END mstd_bm,
                CASE WHEN NVL(mstd_recordid,'9') = '1' THEN nvl(mstd_ppnbtlrph,0) * -1 ELSE nvl(mstd_ppnbtlrph,0) END mstd_btl,
                CASE WHEN NVL(mstd_recordid,'9') = '1' THEN
                       (nvl(mstd_gross,0 )+ nvl(mstd_ppnrph,0) + nvl(mstd_ppnbmrph,0) + nvl(mstd_ppnbtlrph,0)) - (nvl(mstd_discrph,0)) * -1
                ELSE
                       (nvl(mstd_gross,0 )+ nvl(mstd_ppnrph,0) + nvl(mstd_ppnbmrph,0) + nvl(mstd_ppnbtlrph,0)) - (nvl(mstd_discrph,0))
                END total,
                prs_namaperusahaan, prs_namacabang
                from tbmaster_divisi, tbmaster_departement, tbmaster_kategori,
                tbtr_mstran_h, tbtr_mstran_d, tbmaster_perusahaan
                where msth_typetrn='K'
                and msth_kodeigr='" . Session::get('kdigr') . "'
                and msth_tgldoc between TO_DATE('" . $tgl1 . "','dd/mm/yyyy') and TO_DATE('" . $tgl2 . "','dd/mm/yyyy')
                and mstd_nodoc=msth_nodoc
                and TRUNC(mstd_tgldoc) = TRUNC(msth_tgldoc)
                ".$and_div."
                ".$and_dep."
                ".$and_kat."
                and mstd_kodeigr=msth_kodeigr
                and NVL(mstd_recordid,'9') <> '1'
                and prs_kodeigr=msth_kodeigr
                and div_kodedivisi(+)=mstd_kodedivisi
                and div_kodeigr(+) = mstd_kodeigr
                and dep_kodedivisi (+)= mstd_kodedivisi
                and dep_kodedepartement (+)= mstd_kodedepartement
                and dep_kodeigr(+)=mstd_kodeigr
                and kat_kodedepartement(+)=mstd_kodedepartement
                and kat_kodekategori(+)=mstd_kodekategoribrg
                and kat_kodeigr(+)=mstd_kodeigr
        )
        group by mstd_kodedivisi, div_namadivisi,
                mstd_kodedepartement, dep_namadepartement,
                mstd_kodekategoribrg, kat_namakategori,
                prs_namaperusahaan, prs_namacabang
        order by mstd_kodedivisi, mstd_kodedepartement, mstd_kodekategoribrg");

            return view('BACKOFFICE.LAPORAN.daftar-retur-pembelian-ringkasan-divdepkat-pdf', compact(['perusahaan', 'data', 'tgl1', 'tgl2']));

        } else if ($tipe === '2') {
            $data = DB::connection(Session::get('connection'))->select("select msth_nodoc, msth_tgldoc, plu, prd_deskripsipanjang, mstd_hrgsatuan, mstd_keterangan,
    kemasan, prs_namaperusahaan, prs_namacabang, mstd_bkp,
    mstd_kodedivisi, div_namadivisi, frac,
    mstd_kodedepartement, dep_namadepartement,
    mstd_kodekategoribrg, kat_namakategori,
    sum(bonus) bonus, sum(gross) gross, sum(potongan) potongan,
    sum(bm) bm, sum(btl) btl, sum(ppn) ppn, sum(acost) acost, sum(ctn) ctn,  sum(pcs) pcs,
    sum(total) total, sum(lcost) lcost,
    SUM(bkpgross) bkpgross,  SUM(btkpgross) btkpgross,SUM(bkppot) bkppot,
    SUM(btkppot) btkppot,SUM(bkpppn) bkpppn, SUM(btkpppn) btkpppn,
    SUM(bkpbm) bkpbm, SUM(btkpbm) btkpbm, SUM(bkpbtl) bkpbtl, SUM(btkpbtl) btkpbtl,
    SUM(bkptotal) bkptotal, SUM(btkptotal) btkptotal, SUM(bkpavg) bkpavg, SUM(btkpavg) btkpavg
from (
    select msth_nodoc, msth_tgldoc, mstd_prdcd plu, prd_deskripsipanjang, mstd_hrgsatuan, mstd_keterangan, case when mstd_unit = 'KG' then mstd_avgcost / 1000 else mstd_avgcost end acost,
        floor(mstd_qty/prd_frac) ctn, mod(mstd_qty,prd_frac) pcs, prd_unit||'/'||prd_frac kemasan, mstd_bkp, prd_frac frac,
        prs_namaperusahaan, prs_namacabang,
        mstd_kodedivisi, div_namadivisi,
        mstd_kodedepartement, dep_namadepartement,
        mstd_kodekategoribrg, kat_namakategori,
        CASE WHEN nvl(mstd_recordid,'9') = '1' THEN (nvl(mstd_qtybonus1,0)+nvl(mstd_qtybonus2,0)) * -1
        ELSE (nvl(mstd_qtybonus1,0)+nvl(mstd_qtybonus2,0))
        END bonus,
        CASE WHEN nvl(mstd_recordid,'9') = '1' THEN nvl(mstd_gross,0) * -1 ELSE nvl(mstd_gross,0) END gross,
        CASE WHEN nvl(mstd_recordid,'9') = '1' THEN nvl(mstd_discrph,0) * -1 ELSE nvl(mstd_discrph,0) END potongan,
        CASE WHEN nvl(mstd_recordid,'9') = '1' THEN nvl(mstd_ppnbmrph,0) * -1 ELSE nvl(mstd_ppnbmrph,0) END bm,
        CASE WHEN nvl(mstd_recordid,'9') = '1' THEN nvl(mstd_ppnbtlrph,0) * -1 ELSE nvl(mstd_ppnbtlrph,0) END btl,
        CASE WHEN nvl(mstd_recordid,'9') = '1' THEN nvl(mstd_ppnrph,0) * -1 ELSE nvl(mstd_ppnrph,0) END ppn,
        CASE WHEN nvl(mstd_recordid,'9') = '1' THEN
               (nvl(mstd_gross,0) + nvl(mstd_ppnbmrph,0) + nvl(mstd_ppnbtlrph,0)+nvl(mstd_ppnrph,0))-(nvl(mstd_discrph,0)) * -1
        ELSE
               (nvl(mstd_gross,0) + nvl(mstd_ppnbmrph,0) + nvl(mstd_ppnbtlrph,0)+nvl(mstd_ppnrph,0))-(nvl(mstd_discrph,0))
        END total,
        CASE WHEN nvl(mstd_recordid,'9') = '1' THEN
               CASE WHEN mstd_unit = 'KG' THEN
                     ((mstd_qty / 1000) * (mstd_avgcost / 1000)) * -1
               ELSE
                     (mstd_qty * (mstd_avgcost / mstd_frac)) * -1
               END
         ELSE
                CASE WHEN mstd_unit = 'KG' THEN
                     (mstd_qty / 1000) * (mstd_avgcost / 1000)
               ELSE
                     mstd_qty * (mstd_avgcost / mstd_frac)
               END
         END lcost,
        CASE WHEN mstd_pkp = 'Y' THEN NVL(mstd_gross, 0) END bkpgross,
        CASE WHEN mstd_pkp <> 'Y' THEN NVL(mstd_gross, 0) END btkpgross,
        CASE WHEN mstd_pkp = 'Y' THEN
             CASE WHEN mstd_unit = 'KG' THEN
                   (mstd_qty / 1000) * (mstd_avgcost / 1000)
             ELSE
                   mstd_qty* (mstd_avgcost / mstd_frac)
             END
        END bkpavg,
        CASE WHEN mstd_pkp <> 'Y' THEN
             CASE WHEN mstd_unit = 'KG' THEN
                   (mstd_qty / 1000) * (mstd_avgcost / 1000)
             ELSE
                   mstd_qty* (mstd_avgcost / mstd_frac)
             END
        END btkpavg,
        CASE WHEN mstd_pkp = 'Y' THEN NVL(mstd_discrph,0) END bkppot,
        CASE WHEN mstd_pkp <> 'Y' THEN NVL(mstd_discrph,0) END btkppot,
        CASE WHEN mstd_pkp = 'Y' THEN NVL(mstd_ppnrph,0) END bkpppn,
        CASE WHEN mstd_pkp <> 'Y' THEN NVL(mstd_ppnrph,0) END btkpppn,
        CASE WHEN mstd_pkp = 'Y' THEN NVL(mstd_ppnbmrph,0) END bkpbm,
        CASE WHEN mstd_pkp <> 'Y' THEN NVL(mstd_ppnbmrph,0) END btkpbm,
        CASE WHEN mstd_pkp = 'Y' THEN NVL(mstd_ppnbtlrph,0) END bkpbtl,
        CASE WHEN mstd_pkp <> 'Y' THEN NVL(mstd_ppnbtlrph,0) END btkpbtl,
        CASE WHEN mstd_pkp = 'Y' THEN (NVL(mstd_gross,0 )+ NVL(mstd_ppnrph,0) + NVL(mstd_ppnbmrph,0) + NVL(mstd_ppnbtlrph,0)) - (NVL(mstd_discrph,0)) END bkptotal,
        CASE WHEN mstd_pkp <> 'Y' THEN (NVL(mstd_gross,0 )+ NVL(mstd_ppnrph,0) + NVL(mstd_ppnbmrph,0) + NVL(mstd_ppnbtlrph,0)) - (NVL(mstd_discrph,0)) END btkptotal
    from tbtr_mstran_h, tbtr_mstran_d, tbmaster_prodmast, tbmaster_perusahaan,
    tbmaster_divisi, tbmaster_departement, tbmaster_kategori
    where  msth_typetrn='K'
        and msth_kodeigr='" . Session::get('kdigr') . "'
        and msth_tgldoc between TO_DATE('" . $tgl1 . "','dd/mm/yyyy') and TO_DATE('" . $tgl2 . "','dd/mm/yyyy')
        and mstd_nodoc=msth_nodoc
        ".$and_div."
        ".$and_dep."
        ".$and_kat."
        and mstd_kodeigr=msth_kodeigr
        and prd_prdcd(+)=mstd_prdcd
        and prd_kodeigr(+)=mstd_kodeigr
        and prs_kodeigr=msth_kodeigr
        and div_kodedivisi(+)=mstd_kodedivisi
        and div_kodeigr(+) = mstd_kodeigr
        and dep_kodedivisi (+)= mstd_kodedivisi
        and dep_kodedepartement (+)= mstd_kodedepartement
        and dep_kodeigr(+)=mstd_kodeigr
        and kat_kodedepartement(+)= mstd_kodedepartement
        and kat_kodekategori(+)=mstd_kodekategoribrg
        and kat_kodeigr(+)=mstd_kodeigr
       )
group by msth_nodoc, msth_tgldoc, plu, prd_deskripsipanjang, mstd_hrgsatuan, mstd_keterangan, acost, lcost,
    kemasan, prs_namaperusahaan, prs_namacabang,
    mstd_kodedivisi, div_namadivisi,mstd_bkp, frac,
    mstd_kodedepartement, dep_namadepartement,
    mstd_kodekategoribrg, kat_namakategori
order by mstd_kodedivisi, mstd_kodedepartement, mstd_kodekategoribrg, msth_nodoc, plu");

            return view('BACKOFFICE.LAPORAN.daftar-retur-pembelian-rincian-produk-per-divdepkat-pdf', compact(['perusahaan', 'data', 'tgl1', 'tgl2']));

        } else if ($tipe === '3') {
            $data = DB::connection(Session::get('connection'))->select("select msth_nodoc, msth_tgldoc, plu, prd_deskripsipanjang, mstd_hrgsatuan, mstd_keterangan, acost, lcost,
    kemasan, prs_namaperusahaan, prs_namacabang, mstd_bkp, frac,
    mstd_kodesupplier, sup_namasupplier,
    sum(bonus) bonus, sum(gross) gross, sum(potongan) potongan,
    sum(bm) bm, sum(btl) btl, sum(ppn) ppn,
    sum(total) total, sum(avgcost) avgcost, sum(ctn) ctn, sum(pcs) pcs
from (
    select msth_nodoc, msth_tgldoc, mstd_prdcd plu, prd_deskripsipanjang, mstd_hrgsatuan, mstd_keterangan, case when mstd_unit = 'KG' then mstd_avgcost / 1000 else mstd_avgcost end acost, mstd_ocost lcost,
        floor(mstd_qty/prd_frac) ctn, mod(mstd_qty,prd_frac) pcs, prd_unit||'/'||prd_frac kemasan, mstd_bkp,  mstd_frac frac,
        prs_namaperusahaan, prs_namacabang, mstd_kodesupplier, sup_namasupplier,
        CASE WHEN NVL(mstd_recordid,'9') = '1' THEN (nvl(mstd_qtybonus1,0)+nvl(mstd_qtybonus2,0)) * -1 ELSE (nvl(mstd_qtybonus1,0)+nvl(mstd_qtybonus2,0)) END bonus,
        CASE WHEN NVL(mstd_recordid,'9') = '1' THEN nvl(mstd_gross,0) * -1 ELSE nvl(mstd_gross,0) END gross,
        CASE WHEN NVL(mstd_recordid,'9') = '1' THEN nvl(mstd_discrph,0) * -1 ELSE nvl(mstd_discrph,0) END potongan,
        CASE WHEN NVL(mstd_recordid,'9') = '1' THEN nvl(mstd_ppnbmrph,0) * -1 ELSE nvl(mstd_ppnbmrph,0) END bm,
        CASE WHEN NVL(mstd_recordid,'9') = '1' THEN nvl(mstd_ppnbtlrph,0) * -1 ELSE nvl(mstd_ppnbtlrph,0) END btl,
        CASE WHEN NVL(mstd_recordid,'9') = '1' THEN nvl(mstd_ppnrph,0) * -1 ELSE nvl(mstd_ppnrph,0) END ppn,
        CASE WHEN NVL(mstd_recordid,'9') = '1' THEN
               (nvl(mstd_gross,0) + nvl(mstd_ppnbmrph,0) + nvl(mstd_ppnbtlrph,0)+nvl(mstd_ppnrph,0))-(nvl(mstd_discrph,0)) * -1
        ELSE
               (nvl(mstd_gross,0) + nvl(mstd_ppnbmrph,0) + nvl(mstd_ppnbtlrph,0)+nvl(mstd_ppnrph,0))-(nvl(mstd_discrph,0))
        END total,
        CASE WHEN NVL(mstd_recordid,'9') = '1' THEN
               CASE WHEN mstd_unit = 'KG' THEN
                     ((mstd_qty / 1000) * (mstd_avgcost / 1000)) * -1
               ELSE
                     (mstd_qty * (mstd_avgcost / mstd_frac)) * -1
               END
        ELSE
               CASE WHEN mstd_unit = 'KG' THEN
                     (mstd_qty / 1000) * (mstd_avgcost / 1000)
               ELSE
                     mstd_qty * (mstd_avgcost / mstd_frac)
               END
        END avgcost
    from tbtr_mstran_h, tbtr_mstran_d, tbmaster_prodmast, tbmaster_perusahaan,
        tbmaster_supplier
    where msth_kodeigr='" . Session::get('kdigr') . "'
        and msth_tgldoc between TO_DATE('" . $tgl1 . "','dd/mm/yyyy') and TO_DATE('" . $tgl2 . "','dd/mm/yyyy')
        and msth_typetrn='K'
        " . $and_sup . "
        and mstd_nodoc=msth_nodoc
        and mstd_kodeigr=msth_kodeigr
        and prd_prdcd(+)=mstd_prdcd
        and prd_kodeigr(+)=mstd_kodeigr
        and prs_kodeigr=msth_kodeigr
        and sup_kodesupplier(+)= mstd_kodesupplier
        and sup_kodeigr(+)=mstd_kodeigr
        )
group by msth_nodoc, msth_tgldoc, plu, prd_deskripsipanjang,
    mstd_hrgsatuan, mstd_keterangan, acost, lcost, frac,
    mstd_kodesupplier, sup_namasupplier,
    kemasan, prs_namaperusahaan, prs_namacabang,mstd_bkp
order by mstd_kodesupplier, msth_nodoc, plu");

            return view('BACKOFFICE.LAPORAN.daftar-retur-pembelian-rincian-produk-per-supplier-pdf', compact(['perusahaan', 'data', 'tgl1', 'tgl2']));
        }else if ($tipe === '4') {
            $data = DB::connection(Session::get('connection'))->select("select msth_nodoc, msth_tgldoc, plu, prd_deskripsipanjang, mstd_hrgsatuan, mstd_keterangan, acost, lcost,
    ctn, pcs, kemasan, prs_namaperusahaan, prs_namacabang, mstd_bkp,
    mstd_kodesupplier, sup_namasupplier,mstd_nodoc, mstd_tgldoc, frac,
    sum(bonus) bonus, sum(gross) gross, sum(potongan) potongan,
    sum(bm) bm, sum(btl) btl, sum(ppn) ppn,
    sum(total) total, sum(avgcost) avgcost
from (
    select msth_nodoc, msth_tgldoc, mstd_prdcd plu, prd_deskripsipanjang, mstd_hrgsatuan, mstd_keterangan, case when mstd_unit = 'KG' then mstd_avgcost / 1000 else mstd_avgcost end acost, mstd_ocost lcost,
        floor(mstd_qty/prd_frac) ctn, mod(mstd_qty,prd_frac) pcs, prd_unit||'/'||prd_frac kemasan, mstd_bkp,  mstd_frac frac,
        prs_namaperusahaan, prs_namacabang, mstd_kodesupplier, sup_namasupplier, mstd_nodoc, mstd_tgldoc,
        CASE WHEN NVL(mstd_recordid,'9') = '1' THEN (nvl(mstd_qtybonus1,0)+nvl(mstd_qtybonus2,0)) * -1 ELSE (nvl(mstd_qtybonus1,0)+nvl(mstd_qtybonus2,0)) END bonus,
        CASE WHEN NVL(mstd_recordid,'9') = '1' THEN nvl(mstd_gross,0) * -1 ELSE nvl(mstd_gross,0) END gross,
        CASE WHEN NVL(mstd_recordid,'9') = '1' THEN nvl(mstd_discrph,0) * -1 ELSE nvl(mstd_discrph,0) END potongan,
        CASE WHEN NVL(mstd_recordid,'9') = '1' THEN nvl(mstd_ppnbmrph,0) * -1 ELSE nvl(mstd_ppnbmrph,0) END bm,
        CASE WHEN NVL(mstd_recordid,'9') = '1' THEN nvl(mstd_ppnbtlrph,0) * -1 ELSE nvl(mstd_ppnbtlrph,0) END btl,
        CASE WHEN NVL(mstd_recordid,'9') = '1' THEN nvl(mstd_ppnrph,0) * -1 ELSE nvl(mstd_ppnrph,0) END ppn,
        CASE WHEN NVL(mstd_recordid,'9') = '1' THEN
               (nvl(mstd_gross,0) + nvl(mstd_ppnbmrph,0) + nvl(mstd_ppnbtlrph,0)+nvl(mstd_ppnrph,0))-(nvl(mstd_discrph,0)) * -1
        ELSE
               (nvl(mstd_gross,0) + nvl(mstd_ppnbmrph,0) + nvl(mstd_ppnbtlrph,0)+nvl(mstd_ppnrph,0))-(nvl(mstd_discrph,0))
        END total,
        CASE WHEN NVL(mstd_recordid,'9') = '1' THEN
               CASE WHEN mstd_unit = 'KG' THEN
                     ((mstd_qty / 1000) * (mstd_avgcost / 1000)) * -1
               ELSE
                     (mstd_qty* (mstd_avgcost / mstd_frac)) * -1
               END
        ELSE
        CASE WHEN mstd_unit = 'KG' THEN
                     (mstd_qty / 1000) * (mstd_avgcost / 1000)
               ELSE
                     mstd_qty* (mstd_avgcost / mstd_frac)
               END
        END avgcost
    from tbtr_mstran_h, tbtr_mstran_d, tbmaster_prodmast, tbmaster_perusahaan,
         tbmaster_supplier
    where msth_kodeigr='" . Session::get('kdigr') . "'
        and msth_tgldoc between TO_DATE('" . $tgl1 . "','dd/mm/yyyy') and TO_DATE('" . $tgl2 . "','dd/mm/yyyy')
        and msth_typetrn='K'
        " . $and_sup . "
        and mstd_nodoc=msth_nodoc
        and mstd_kodeigr=msth_kodeigr
        and prd_prdcd(+)=mstd_prdcd
        and prd_kodeigr(+)=mstd_kodeigr
        and prs_kodeigr=msth_kodeigr
        and sup_kodesupplier(+) = mstd_kodesupplier
        and sup_kodeigr(+)=mstd_kodeigr
        )
group by msth_nodoc, msth_tgldoc, plu, prd_deskripsipanjang,
    mstd_hrgsatuan, mstd_keterangan, acost, lcost, frac,
    mstd_kodesupplier, sup_namasupplier,mstd_nodoc, mstd_tgldoc,
    ctn, pcs, kemasan, prs_namaperusahaan, prs_namacabang,mstd_bkp
order by mstd_kodesupplier, msth_nodoc, plu");
            return view('BACKOFFICE.LAPORAN.daftar-retur-pembelian-rincian-produk-per-supplier-per-dokumen-pdf', compact(['perusahaan', 'data', 'tgl1', 'tgl2']));

        }
        else if ($tipe === '5') {
            $data = DB::connection(Session::get('connection'))->select("select msth_nodoc, msth_tgldoc, noretur, tglretur,mstd_kodesupplier,
supplier,prs_namaperusahaan, prs_namacabang,  mstd_bkp,
sum(gross) gross, sum(potongan) potongan, sum(bm) bm, sum(btl) btl,
sum(dpp) dpp, sum(ppn) ppn, sum(total) total, sum(avgcost) avgcost
from (
    select msth_nodoc, msth_tgldoc, mstd_kodesupplier,
    mstd_bkp, mstd_noref3 noretur, mstd_tgref3 tglretur,
    CASE WHEN nvl(mstd_recordid,'9') = '1' THEN nvl(mstd_gross,0) * -1 ELSE nvl(mstd_gross,0) END gross,
    CASE WHEN nvl(mstd_recordid,'9') = '1' THEN nvl(mstd_discrph,0) * -1 ELSE nvl(mstd_discrph,0) END potongan,
    CASE WHEN nvl(mstd_recordid,'9') = '1' THEN nvl(mstd_ppnbmrph,0) * -1 ELSE nvl(mstd_ppnbmrph,0) END bm,
    CASE WHEN nvl(mstd_recordid,'9') = '1' THEN nvl(mstd_ppnbtlrph,0) * -1 ELSE nvl(mstd_ppnbtlrph,0) END btl,
    CASE WHEN nvl(mstd_recordid,'9') = '1' THEN nvl(mstd_ppnrph,0) * -1 ELSE nvl(mstd_ppnrph,0) END ppn,
    CASE WHEN nvl(mstd_recordid,'9') = '1' THEN
           (nvl(mstd_gross,0) + nvl(mstd_ppnbmrph,0) + nvl(mstd_ppnbtlrph,0))-(nvl(mstd_discrph,0)) * -1
    ELSE
           (nvl(mstd_gross,0) + nvl(mstd_ppnbmrph,0) + nvl(mstd_ppnbtlrph,0))-(nvl(mstd_discrph,0))
    END dpp,
    CASE WHEN nvl(mstd_recordid,'9') = '1' THEN
           (nvl(mstd_gross,0) + nvl(mstd_ppnbmrph,0) + nvl(mstd_ppnbtlrph,0)+nvl(mstd_ppnrph,0))-(nvl(mstd_discrph,0)) * -1
    ELSE
           (nvl(mstd_gross,0) + nvl(mstd_ppnbmrph,0) + nvl(mstd_ppnbtlrph,0)+nvl(mstd_ppnrph,0))-(nvl(mstd_discrph,0))
    END total,
    CASE WHEN nvl(mstd_recordid,'9') = '1' THEN
           CASE WHEN mstd_unit = 'KG' THEN
                 ((mstd_qty / 1000 ) * (mstd_avgcost / 1000)) * -1
           ELSE
                 (mstd_qty * (mstd_avgcost / mstd_frac)) * -1
           END
    ELSE
           CASE WHEN mstd_unit = 'KG' THEN
                 (mstd_qty / 1000) * (mstd_avgcost / 1000 )
           ELSE
                 mstd_qty * (mstd_avgcost / mstd_frac)
           END
    END avgcost,
    sup_kodesupplier||' - '||sup_namasupplier supplier,
    prs_namaperusahaan, prs_namacabang
    from tbtr_mstran_h, tbtr_mstran_d, tbmaster_supplier,
         tbmaster_perusahaan, tbmaster_prodmast
    where msth_typetrn='K'
    and msth_kodeigr='" . Session::get('kdigr') . "'
    and msth_tgldoc between TO_DATE('" . $tgl1 . "','dd/mm/yyyy') and TO_DATE('" . $tgl2 . "','dd/mm/yyyy')
    " . $and_sup . "
    and mstd_nodoc=msth_nodoc
    and mstd_kodeigr=msth_kodeigr
    and sup_kodeigr(+)=mstd_kodeigr
    and sup_kodesupplier(+) = mstd_kodesupplier
    and prd_prdcd(+)=mstd_prdcd
    and prd_kodeigr(+)=mstd_kodeigr
    and prs_kodeigr=msth_kodeigr
)
group by msth_nodoc, msth_tgldoc, noretur, tglretur, mstd_kodesupplier,
supplier,prs_namaperusahaan, prs_namacabang, mstd_bkp
order by mstd_kodesupplier, msth_nodoc");

            return view('BACKOFFICE.LAPORAN.daftar-retur-pembelian-rincian-dokumen-per-supplier-pdf', compact(['perusahaan', 'data', 'tgl1', 'tgl2']));
        }
    }
}
