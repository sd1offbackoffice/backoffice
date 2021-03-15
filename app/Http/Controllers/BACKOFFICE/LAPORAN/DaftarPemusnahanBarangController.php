<?php

namespace App\Http\Controllers\BACKOFFICE\LAPORAN;

use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;
use PDF;
use Yajra\DataTables\DataTables;
use ZipArchive;
use File;

class DaftarPemusnahanBarangController extends Controller
{
    public function index()
    {
        return view('BACKOFFICE.LAPORAN.daftar-pemusnahan-barang');
    }

    public function getDataLovDiv(Request $request)
    {
        if (is_null($request->div))
            $div = 1;
        else $div = $request->div;

        $data = DB::table('tbmaster_divisi')
            ->select('div_kodedivisi', 'div_namadivisi')
            ->where('div_kodeigr', '=', $_SESSION['kdigr'])
            ->whereRaw('div_kodedivisi >= ' . $div)
            ->get();

        return DataTables::of($data)->make(true);
    }

    public function getDataLovDep(Request $request)
    {
        $data = DB::table('tbmaster_departement')
            ->select('dep_kodedepartement', 'dep_namadepartement', 'dep_kodedivisi')
            ->where('dep_kodeigr', '=', $_SESSION['kdigr'])
            ->where('dep_kodedivisi', '=', $request->div)
            ->get();

        return DataTables::of($data)->make(true);
    }

    public function getDataLovKat(Request $request)
    {
        $data = DB::table("tbmaster_kategori")
            ->join('tbmaster_departement', 'dep_kodedepartement', '=', 'kat_kodedepartement')
            ->select('kat_namakategori', 'kat_kodekategori', 'kat_kodedepartement', 'dep_kodedivisi')
            ->where('kat_kodeigr', '=', $_SESSION['kdigr'])
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

        $data = DB::table('tbmaster_supplier')
            ->select('sup_namasupplier', 'sup_kodesupplier')
            ->where('sup_kodeigr', '=', $_SESSION['kdigr'])
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

        $perusahaan = DB::table('tbmaster_perusahaan')
            ->select('prs_namaperusahaan', 'prs_namacabang')
            ->first();

        if ($tipe === '1') {
            $data = DB::select("select mstd_kodedivisi, div_namadivisi,
        mstd_kodedepartement, dep_namadepartement,
        mstd_kodekategoribrg, kat_namakategori,
        prs_namaperusahaan, prs_namacabang,
        sum(mstd_gross) total
from (select mstd_kodedivisi, div_namadivisi,
        mstd_kodedepartement, dep_namadepartement,
        mstd_kodekategoribrg, kat_namakategori,
        mstd_prdcd, prd_deskripsipanjang, mstd_gross,
        nvl(mstd_rphdisc1,0)+nvl(mstd_rphdisc2,0)+nvl(mstd_rphdisc3,0)+nvl(mstd_rphdisc4,0) mstd_pot,
        nvl(mstd_ppnrph,0) mstd_ppn, nvl(mstd_ppnbmrph,0) mstd_bm, nvl(mstd_ppnbtlrph,0) mstd_btl,
        (nvl(mstd_gross,0 )+ nvl(mstd_ppnrph,0) + nvl(mstd_ppnbmrph,0) + nvl(mstd_ppnbtlrph,0)) -
        (nvl(mstd_rphdisc1,0)+nvl(mstd_rphdisc2,0)+nvl(mstd_rphdisc3,0)+nvl(mstd_rphdisc4,0)) totrp,
        prs_namaperusahaan, prs_namacabang
        from tbmaster_divisi, tbmaster_departement, tbmaster_kategori, tbmaster_prodmast,
                tbtr_mstran_d, tbmaster_perusahaan
where mstd_typetrn = 'F'
        and mstd_kodeigr = '".$_SESSION['kdigr']."'
        and NVL(mstd_recordid, '9') <> '1'
        and mstd_tgldoc between TO_DATE('" . $tgl1 . "','dd/mm/yyyy') and TO_DATE('" . $tgl2 . "','dd/mm/yyyy')
        and prd_prdcd(+) = mstd_prdcd
        and prd_kodeigr(+) = mstd_kodeigr
        and div_kodeigr(+) = mstd_kodeigr
        and div_kodedivisi(+) = mstd_kodedivisi
        and dep_kodeigr(+) = mstd_kodeigr
        and dep_kodedivisi(+) = mstd_kodedivisi
        and dep_kodedepartement(+) = mstd_kodedepartement
        and kat_kodeigr(+) = mstd_kodeigr
        and kat_kodedepartement(+) = mstd_kodedepartement
        and kat_kodekategori(+) = mstd_kodekategoribrg
        and prs_kodeigr=mstd_kodeigr
        and mstd_kodedivisi||mstd_kodedepartement||mstd_kodekategoribrg between '" . $div1 . "'||'" . $dep1 . "'||'" . $kat1 . "' and '" . $div2 . "'||'" . $dep2 . "'||'" . $kat2 . "'
        order by div_kodedivisi, dep_kodedepartement, kat_kodekategori, prd_prdcd)
group by mstd_kodedivisi, div_namadivisi,
        mstd_kodedepartement, dep_namadepartement,
        mstd_kodekategoribrg, kat_namakategori,
        prs_namaperusahaan, prs_namacabang
order by mstd_kodedivisi, mstd_kodedepartement, mstd_kodekategoribrg");

            $dompdf = new PDF();

            $pdf = PDF::loadview('BACKOFFICE.LAPORAN.daftar-pemusnahan-ringkasan-divdepkat-pdf', compact(['perusahaan', 'data', 'tgl1', 'tgl2']));

            error_reporting(E_ALL ^ E_DEPRECATED);

            $pdf->output();
            $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);

            $canvas = $dompdf->get_canvas();
            $canvas->page_text(625, 80.75, "{PAGE_NUM} dari {PAGE_COUNT}", null, 7, array(0, 0, 0));

            $dompdf = $pdf;

            return $dompdf->stream('LAPORAN DAFTAR RETUR PEMBELIAN RINGKASAN DIVISI/DEPT/KATEGORI.pdf');
        } else if ($tipe === '2') {
            $data = DB::select("select plu, barang, kemasan,
        mstd_kodedivisi, div_namadivisi,
        mstd_kodedepartement, dep_namadepartement,
        mstd_kodekategoribrg, kat_namakategori,
        prs_namaperusahaan, prs_namacabang,
        keterangan,
        hrg_satuan,
        floor(sum(mstd_qty)/mstd_frac) qty, mod(sum(mstd_qty),mstd_frac) qtyk,
        sum(total) total
from (
        select  mstd_prdcd plu, prd_deskripsipanjang barang, prd_unit||'/'||mstd_frac kemasan, mstd_kodedivisi, div_namadivisi,
                mstd_kodedepartement, dep_namadepartement,
                mstd_kodekategoribrg, kat_namakategori,
                mstd_keterangan keterangan,
                mstd_prdcd, prd_deskripsipanjang,
                prs_namaperusahaan, prs_namacabang,
                nvl(mstd_hrgsatuan,0) hrg_satuan,
                nvl(mstd_qty,0) mstd_qty, mstd_frac,
                nvl(mstd_gross,0) total
        from tbtr_mstran_d,tbmaster_prodmast,
        tbmaster_divisi, tbmaster_departement,tbmaster_kategori, tbmaster_perusahaan
where mstd_typetrn='F'
        and mstd_kodeigr='".$_SESSION['kdigr']."'
        and NVL(mstd_recordid, '9') <> '1'
        and mstd_tgldoc between TO_DATE('" . $tgl1 . "','dd/mm/yyyy') and TO_DATE('" . $tgl2 . "','dd/mm/yyyy')
        and prd_prdcd(+) = mstd_prdcd
        and prd_kodeigr(+) = mstd_kodeigr
        and div_kodeigr(+) = mstd_kodeigr
        and div_kodedivisi(+) = mstd_kodedivisi
        and dep_kodeigr(+) = mstd_kodeigr
        and dep_kodedivisi(+) = mstd_kodedivisi
        and dep_kodedepartement(+) = mstd_kodedepartement
        and kat_kodeigr(+) = mstd_kodeigr
        and kat_kodedepartement(+) = mstd_kodedepartement
        and kat_kodekategori(+) = mstd_kodekategoribrg
        and prs_kodeigr=mstd_kodeigr
        and mstd_kodedivisi||mstd_kodedepartement||mstd_kodekategoribrg between '" . $div1 . "'||'" . $dep1 . "'||'" . $kat1 . "' and '" . $div2 . "'||'" . $dep2 . "'||'" . $kat2 . "'
        order by div_kodedivisi, dep_kodedepartement, kat_kodekategori, prd_prdcd)
group by plu, barang, kemasan,   hrg_satuan, mstd_frac,
        mstd_kodedivisi, div_namadivisi,
        mstd_kodedepartement, dep_namadepartement,
        mstd_kodekategoribrg, kat_namakategori, keterangan,
        prs_namaperusahaan, prs_namacabang
order by mstd_kodedivisi, mstd_kodedepartement, mstd_kodekategoribrg, mstd_prdcd");

//            dd($data);
            $dompdf = new PDF();

            $pdf = PDF::loadview('BACKOFFICE.LAPORAN.daftar-pemusnahan-rekap-produk-per-divdepkat-pdf', compact(['perusahaan', 'data', 'tgl1', 'tgl2']));

            error_reporting(E_ALL ^ E_DEPRECATED);

            $pdf->output();
            $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);

            $canvas = $dompdf->get_canvas();
            $canvas->page_text(745, 80.75, "{PAGE_NUM} dari {PAGE_COUNT}", null, 7, array(0, 0, 0));

            $dompdf = $pdf;

            return $dompdf->stream('LAPORAN DAFTAR RETUR PEMBELIAN RINCIAN PRODUK PER DIVISI/DEPT/KATEGORI.pdf');
        } else if ($tipe === '3') {
            $data = DB::select("select plu, barang, kemasan,
        mstd_nodoc, mstd_tgldoc,
        mstd_kodedivisi, div_namadivisi,
        mstd_kodedepartement, dep_namadepartement,
        mstd_kodekategoribrg, kat_namakategori,
        prs_namaperusahaan, prs_namacabang,
        keterangan,
        sum(hrg_satuan) hrg_satuan,
        sum(qty) qty, sum(qtyk) qtyk,
        sum(total) total
from (
        select  mstd_prdcd plu, prd_deskripsipanjang barang, prd_unit||'/'||prd_frac kemasan,
                mstd_nodoc, mstd_tgldoc,
                mstd_kodedivisi, div_namadivisi,
                mstd_kodedepartement, dep_namadepartement,
                mstd_kodekategoribrg, kat_namakategori,
                mstd_keterangan keterangan,
                mstd_prdcd, prd_deskripsipanjang,
                prs_namaperusahaan, prs_namacabang,
                (nvl(mstd_hrgsatuan,0)) hrg_satuan,
                nvl(floor(mstd_qty/mstd_frac),0) qty,
                nvl(mod(mstd_qty,mstd_frac),0) qtyk,
                (nvl(mstd_gross,0) ) total
        from tbtr_mstran_d,tbmaster_prodmast, tbmaster_divisi,
                tbmaster_departement,tbmaster_kategori, tbmaster_perusahaan
        where mstd_typetrn = 'F'
        and mstd_kodeigr ='".$_SESSION['kdigr']."'
        and NVL(mstd_recordid, '9') <> '1'
        and TRUNC(mstd_tgldoc) between TO_DATE('" . $tgl1 . "','dd/mm/yyyy') and TO_DATE('" . $tgl2 . "','dd/mm/yyyy')
        and prd_prdcd(+) = mstd_prdcd
        and prd_kodeigr(+) = mstd_kodeigr
        and div_kodeigr(+) = mstd_kodeigr
        and div_kodedivisi(+) = mstd_kodedivisi
        and dep_kodeigr(+) = mstd_kodeigr
        and dep_kodedivisi(+) = mstd_kodedivisi
        and dep_kodedepartement(+) = mstd_kodedepartement
        and kat_kodeigr(+) = mstd_kodeigr
        and kat_kodedepartement(+) = mstd_kodedepartement
        and kat_kodekategori(+) = mstd_kodekategoribrg
        and prs_kodeigr = mstd_kodeigr
        and mstd_kodedivisi||mstd_kodedepartement||mstd_kodekategoribrg between '" . $div1 . "'||'" . $dep1 . "'||'" . $kat1 . "' and '" . $div2 . "'||'" . $dep2 . "'||'" . $kat2 . "'
        order by div_kodedivisi, dep_kodedepartement, kat_kodekategori, prd_prdcd)
group by plu, barang, kemasan,
         mstd_nodoc, mstd_tgldoc,
         mstd_kodedivisi, div_namadivisi,
         mstd_kodedepartement, dep_namadepartement,
         mstd_kodekategoribrg, kat_namakategori, keterangan,
         prs_namaperusahaan, prs_namacabang
order by mstd_kodedivisi, mstd_kodedepartement, mstd_kodekategoribrg, mstd_prdcd");

//            dd($data);
            $dompdf = new PDF();

            $pdf = PDF::loadview('BACKOFFICE.LAPORAN.daftar-pemusnahan-rincian-produk-per-divdepkat-pdf', compact(['perusahaan', 'data', 'tgl1', 'tgl2']));

            error_reporting(E_ALL ^ E_DEPRECATED);

            $pdf->output();
            $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);

            $canvas = $dompdf->get_canvas();
            $canvas->page_text(1115, 80.75, "{PAGE_NUM} dari {PAGE_COUNT}", null, 7, array(0, 0, 0));

            $dompdf = $pdf;

            return $dompdf->stream('LAPORAN DAFTAR RETUR PEMBELIAN RINCIAN PRODUK PER SUPPLIER.pdf');
        }
    }
}
