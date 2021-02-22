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

    public function getDataLovMtr()
    {
        $data = DB::table('tbtr_monitoringplu')
            ->select('mpl_namamonitoring', 'mpl_kodemonitoring')
            ->where('mpl_kodeigr', '=', $_SESSION['kdigr'])
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
        $sup1 = $request->sup1;
        $sup2 = $request->sup2;
        $mtr = $request->mtr;

        $perusahaan = DB::table('tbmaster_perusahaan')
            ->select('prs_namaperusahaan', 'prs_namacabang')
            ->first();

        if ($tipe === '1') {
//            $data = DB::select("select mstd_kodedivisi, div_namadivisi,
//                    mstd_kodedepartement, dep_namadepartement,
//                    mstd_kodekategoribrg, kat_namakategori,
//                    prs_namaperusahaan, prs_namacabang, prs_namawilayah,
//                    sum(mstd_gross) gross, sum(mstd_discrph) pot, sum(disc4) disc4,
//                    sum(mstd_ppn) ppn, sum(mstd_bm) bm, sum(mstd_btl) btl,
//                    sum(total) total,
//                    sum(GROSS_BKP), sum(GROSS_BTKP),
//                    sum(POT_BKP), sum(POT_BTKP),
//                    sum(DISC4_BKP), sum(DISC4_BTKP),
//                    sum(PPN_BKP), sum(PPN_BTKP),
//                    sum(BM_BKP), sum(BM_BTKP),
//                    sum(BTL_BKP), sum(BTL_BTKP),
//                    sum(TOTAL_BKP), sum(TOTAL_BTKP)
//            from (select mstd_kodedivisi, div_namadivisi,
//                    mstd_kodedepartement, dep_namadepartement,
//                    mstd_kodekategoribrg, kat_namakategori,
//                    CASE WHEN mstd_ppnrph <> 0 THEN
//                            nvl(mstd_gross,0)
//                    END GROSS_BKP,
//                    CASE WHEN mstd_ppnrph = 0 THEN
//                            nvl(mstd_gross,0)
//                    END GROSS_BTKP,
//                    CASE WHEN mstd_ppnrph <> 0 THEN
//                            nvl(mstd_discrph,0)
//                    END POT_BKP,
//                    CASE WHEN mstd_ppnrph = 0 THEN
//                            nvl(mstd_discrph,0)
//                    END POT_BTKP,
//                    CASE WHEN mstd_ppnrph <> 0 THEN
//                            (nvl(mstd_dis4cr,0) + nvl(mstd_dis4rr,0) + nvl(mstd_dis4jr,0))
//                    END DISC4_BKP,
//                    CASE WHEN mstd_ppnrph = 0 THEN
//                             (nvl(mstd_dis4cr,0) + nvl(mstd_dis4rr,0) + nvl(mstd_dis4jr,0))
//                    END DISC4_BTKP,
//                    CASE WHEN mstd_ppnrph <> 0 THEN
//                            nvl(mstd_ppnrph,0)
//                    END PPN_BKP,
//                    CASE WHEN mstd_ppnrph = 0 THEN
//                            nvl(mstd_ppnrph,0)
//                    END PPN_BTKP,
//                    CASE WHEN mstd_ppnrph <> 0 THEN
//                            nvl(mstd_ppnbmrph,0)
//                    END BM_BKP,
//                    CASE WHEN mstd_ppnrph = 0 THEN
//                            nvl(mstd_ppnbmrph,0)
//                    END BM_BTKP,
//                    CASE WHEN mstd_ppnrph <> 0 THEN
//                            nvl(mstd_ppnbtlrph,0)
//                    END BTL_BKP,
//                    CASE WHEN mstd_ppnrph = 0 THEN
//                            nvl(mstd_ppnbtlrph,0)
//                    END BTL_BTKP,
//                    CASE WHEN mstd_ppnrph <> 0 THEN
//                            (nvl(mstd_gross,0 )+ nvl(mstd_ppnrph,0) + nvl(mstd_ppnbmrph,0) + nvl(mstd_ppnbtlrph,0)) -
//                            (nvl(mstd_discrph,0))
//                    END TOTAL_BKP,
//                    CASE WHEN mstd_ppnrph = 0 THEN
//                            (nvl(mstd_gross,0 )+ nvl(mstd_ppnrph,0) + nvl(mstd_ppnbmrph,0) + nvl(mstd_ppnbtlrph,0)) -
//                            (nvl(mstd_discrph,0))
//                    END TOTAL_BTKP,
//                    nvl(mstd_avgcost,0)*nvl(mstd_qty,0) avg,
//                    mstd_prdcd, mstd_gross, mstd_discrph,
//                    (nvl(mstd_dis4cr,0) + nvl(mstd_dis4rr,0) + nvl(mstd_dis4jr,0))  disc4,
//                    nvl(mstd_ppnrph,0) mstd_ppn, nvl(mstd_ppnbmrph,0) mstd_bm, nvl(mstd_ppnbtlrph,0) mstd_btl,
//                    (nvl(mstd_gross,0 )+ nvl(mstd_ppnrph,0) + nvl(mstd_ppnbmrph,0) + nvl(mstd_ppnbtlrph,0)) - nvl(mstd_discrph,0) total,
//                    prs_namaperusahaan, prs_namacabang, prs_namawilayah
//            from tbtr_mstran_h, tbtr_mstran_d,tbmaster_divisi,
//                    tbmaster_departement,tbmaster_kategori, tbmaster_perusahaan
//            where msth_typetrn='B'
//                    and msth_kodeigr ='" . $_SESSION['kdigr'] . "'
//                    and mstd_kodeigr ='" . $_SESSION['kdigr'] . "'
//                    and nvl(msth_recordid, '9') <> '1'
//                    and nvl(mstd_recordid, '9') <> '1'
//                    and prs_kodeigr = msth_kodeigr
//                    and div_kodedivisi(+) = mstd_kodedivisi
//                    and div_kodeigr(+) = mstd_kodeigr
//                    and dep_kodedivisi(+) = mstd_kodedivisi
//                    and dep_kodedepartement(+) = mstd_kodedepartement
//                    and dep_kodeigr(+) = mstd_kodeigr
//                    and kat_kodedepartement(+) = mstd_kodedepartement
//                    and kat_kodekategori (+) = mstd_kodekategoribrg
//                    and kat_kodeigr (+) = mstd_kodeigr
//                    and mstd_kodedivisi||mstd_kodedepartement||mstd_kodekategoribrg between '" . $div1 . "'||'" . $dep1 . "'||'" . $kat1 . "' and '" . $div2 . "'||'" . $dep2 . "'||'" . $kat2 . "'
//                    order by div_kodedivisi, dep_kodedepartement, kat_kodekategori)
//            group by mstd_kodedivisi, div_namadivisi,
//                    mstd_kodedepartement, dep_namadepartement,
//                    mstd_kodekategoribrg, kat_namakategori,
//                    prs_namaperusahaan, prs_namacabang, prs_namawilayah
//            order by mstd_kodedivisi, mstd_kodedepartement, mstd_kodekategoribrg");

            $data = $perusahaan;

            $dompdf = new PDF();

            $pdf = PDF::loadview('BACKOFFICE.LAPORAN.daftarpembelian-ringkasan-divdepkat-pdf', compact(['perusahaan', 'data', 'tgl1', 'tgl2']));

            error_reporting(E_ALL ^ E_DEPRECATED);

            $pdf->output();
            $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);

            $canvas = $dompdf->get_canvas();
            $canvas->page_text(507, 80.75, "{PAGE_NUM} dari {PAGE_COUNT}", null, 7, array(0, 0, 0));

            $dompdf = $pdf;

            return $dompdf->stream('LAPORAN DaftarPembelian ANTAR CABANG RINGKASAN DIVISI/DEPT/KATEGORI.pdf');
        } else if ($tipe === '2') {
            $data = DB::select("select mstd_kodedivisi, div_namadivisi,FRAC, BONUS,
                    mstd_kodedepartement, dep_namadepartement,
                    mstd_kodekategoribrg, kat_namakategori,
                    prs_namaperusahaan, prs_namacabang, prs_namawilayah,
                    mstd_nodoc, mstd_tgldoc, unit,
                    hg_beli, ctn, pcs, mstd_keterangan,
                    mstd_prdcd, prd_deskripsipanjang,
                    sum(mstd_gross) gross, sum(mstd_ocost) lcost , sum(mstd_avgcost) acost ,sum(mstd_pot) pot,
                    sum(mstd_ppn) ppn, sum(mstd_bm) bm, sum(mstd_btl) btl,  
                    sum(total) total,
                    sum(GROSS_BKP) grossbkp, sum(GROSS_BTKP) grossbtkp,
                    sum(POT_BKP) potbkp, sum(POT_BTKP) potbtkp,
                    sum(PPN_BKP) ppnbkp, sum(PPN_BTKP) ppnbtkp,
                    sum(BM_BKP) bmbkp, sum(BM_BTKP) bmbtkp,
                    sum(BTL_BKP) btlbkp, sum(BTL_BTKP) btlbtkp,
                    sum(TOTAL_BKP) totalbkp, sum(TOTAL_BTKP) totalbtkp
            from (
                    select  mstd_kodedivisi, div_namadivisi,
                            mstd_kodedepartement, dep_namadepartement, MSTD_FRAC FRAC, 
                            mstd_kodekategoribrg, kat_namakategori,mstd_keterangan,MSTD_QTYBONUS1 BONUS,
                            CASE WHEN mstd_bkp = 'Y' THEN
                                    nvl(mstd_gross,0)
                            END GROSS_BKP,
                            CASE WHEN NVL(mstd_bkp,'N') = 'N' THEN
                                    nvl(mstd_gross,0)
                            END GROSS_BTKP,
                            CASE WHEN mstd_bkp = 'Y' THEN
                                    nvl(mstd_discrph,0)
                            END POT_BKP,
                            CASE WHEN NVL(mstd_bkp,'N') = 'N' THEN
                                    nvl(mstd_discrph,0)
                            END POT_BTKP,        
                            CASE WHEN mstd_bkp = 'Y' THEN
                                    nvl(mstd_ppnrph,0)  
                            END PPN_BKP,
                            CASE WHEN NVL(mstd_bkp,'N') = 'N' THEN
                                    nvl(mstd_ppnrph,0) 
                            END PPN_BTKP,        
                            CASE WHEN mstd_bkp = 'Y' THEN
                                    nvl(mstd_ppnbmrph,0)
                            END BM_BKP,
                            CASE WHEN NVL(mstd_bkp,'N') = 'N' THEN
                                    nvl(mstd_ppnbmrph,0)
                            END BM_BTKP,        
                            CASE WHEN mstd_bkp = 'Y' THEN
                                    nvl(mstd_ppnbtlrph,0)
                            END BTL_BKP,
                            CASE WHEN NVL(mstd_bkp,'N') = 'N' THEN
                                    nvl(mstd_ppnbtlrph,0)
                            END BTL_BTKP,
                            CASE WHEN mstd_bkp = 'Y' THEN
                                    (nvl(mstd_gross,0 )+ nvl(mstd_ppnrph,0) + nvl(mstd_ppnbmrph,0) + nvl(mstd_ppnbtlrph,0)) - nvl(mstd_discrph,0)
                            END TOTAL_BKP,
                            CASE WHEN NVL(mstd_bkp,'N') = 'N' THEN
                                    (nvl(mstd_gross,0 )+ nvl(mstd_ppnrph,0) + nvl(mstd_ppnbmrph,0) + nvl(mstd_ppnbtlrph,0)) - nvl(mstd_discrph,0)
                            END TOTAL_BTKP,
                            mstd_nodoc, mstd_tgldoc, prd_unit||'/'|| prd_frac unit,
                            mstd_hrgsatuan hg_beli, floor(mstd_qty/prd_frac) ctn, mod(mstd_qty,prd_frac) pcs,
                            mstd_prdcd, prd_deskripsipanjang, mstd_gross,  mstd_ocost, mstd_avgcost,
                            nvl(mstd_discrph,0) mstd_pot,
                            nvl(mstd_ppnrph,0) mstd_ppn, nvl(mstd_ppnbmrph,0) mstd_bm, nvl(mstd_ppnbtlrph,0) mstd_btl, 
                            (nvl(mstd_gross,0 )+ nvl(mstd_ppnrph,0) + nvl(mstd_ppnbmrph,0) + nvl(mstd_ppnbtlrph,0)) - 
                            (nvl(mstd_discrph,0)) total,
                            prs_namaperusahaan, prs_namacabang, prs_namawilayah
                from tbtr_mstran_h, tbtr_mstran_d,tbmaster_prodmast, 
                    tbmaster_divisi, tbmaster_departement,tbmaster_kategori,
                    tbmaster_perusahaan
                where msth_typetrn='I'
                    and nvl(msth_recordid,'9') <>'1'
                    and msth_kodeigr='" . $_SESSION['kdigr'] . "'
                    and mstd_nodoc=msth_nodoc
                    and mstd_kodeigr='" . $_SESSION['kdigr'] . "'
                    and mstd_tgldoc between TO_DATE('" . $tgl1 . "','DD/MM/YYYY') and TO_DATE('" . $tgl2 . "','DD/MM/YYYY')
                    and prd_prdcd = mstd_prdcd
                    and prd_kodeigr=mstd_kodeigr
                    and div_kodeigr=mstd_kodeigr
                    and div_kodedivisi = mstd_kodedivisi
                    and dep_kodeigr = mstd_kodeigr
                    and dep_kodedivisi= mstd_kodedivisi
                    and dep_kodedepartement = mstd_kodedepartement
                    and kat_kodeigr = mstd_kodeigr
                    and kat_kodedepartement = mstd_kodedepartement
                    and kat_kodekategori= mstd_kodekategoribrg
                    and div_kodedivisi||dep_kodedepartement||kat_kodekategori 
                    between '" . $div1 . "'||'" . $dep1 . "'||'" . $kat1 . "' and '" . $div2 . "'||'" . $dep2 . "'||'" . $kat2 . "'
                    and prs_kodeigr=msth_kodeigr)
            group by mstd_kodedivisi, div_namadivisi,
                    mstd_kodedepartement, dep_namadepartement,
                    mstd_kodekategoribrg, kat_namakategori,FRAC, BONUS,
                    prs_namaperusahaan, prs_namacabang, prs_namawilayah,
                    mstd_prdcd, prd_deskripsipanjang, mstd_nodoc,  mstd_tgldoc,unit,
                    hg_beli, ctn, pcs,mstd_keterangan
            order by mstd_kodedivisi, mstd_kodedepartement, mstd_kodekategoribrg, mstd_nodoc, mstd_prdcd");

//            dd($data);

            $dompdf = new PDF();

            $pdf = PDF::loadview('BACKOFFICE.LAPORAN.DaftarPembelian-rincian-pdf', compact(['perusahaan', 'data', 'tgl1', 'tgl2']));

            error_reporting(E_ALL ^ E_DEPRECATED);

            $pdf->output();
            $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);

            $canvas = $dompdf->get_canvas();
            $canvas->page_text(986, 80.75, "{PAGE_NUM} dari {PAGE_COUNT}", null, 7, array(0, 0, 0));

            $dompdf = $pdf;

            return $dompdf->stream('LAPORAN DaftarPembelian ANTAR CABANG RINCIAN PRODUK PER DIVISI/DEPT/KATEGORI.pdf');
        }
    }
}