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

class PenyesuaianController extends Controller
{
    public function index(){
        return view('BACKOFFICE.LAPORAN.penyesuaian');
    }

    public function getDataLovDiv(Request $request){
        if(is_null($request->div))
            $div = 1;
        else $div = $request->div;

        $data = DB::connection(Session::get('connection'))->table('tbmaster_divisi')
            ->select('div_kodedivisi','div_namadivisi')
            ->where('div_kodeigr','=',Session::get('kdigr'))
            ->whereRaw('div_kodedivisi >= '.$div)
            ->get();

        return DataTables::of($data)->make(true);
    }

    public function getDataLovDep(Request $request){
        $data = DB::connection(Session::get('connection'))->table('tbmaster_departement')
            ->select('dep_kodedepartement','dep_namadepartement','dep_kodedivisi')
            ->where('dep_kodeigr','=',Session::get('kdigr'))
            ->where('dep_kodedivisi','=',$request->div)
            ->get();

        return DataTables::of($data)->make(true);
    }

    public function getDataLovKat(Request $request){
        $data = DB::connection(Session::get('connection'))->table("tbmaster_kategori")
            ->join('tbmaster_departement','dep_kodedepartement','=','kat_kodedepartement')
            ->select('kat_namakategori','kat_kodekategori','kat_kodedepartement','dep_kodedivisi')
            ->where('kat_kodeigr','=',Session::get('kdigr'))
            ->where('kat_kodedepartement','=',$request->dep)
            ->where('dep_kodedivisi','=',$request->div)
            ->orderBy('kat_kodedepartement')
            ->orderBy('kat_kodekategori')
            ->get();

        return DataTables::of($data)->make(true);
    }

    public function cetak(Request $request){
        $tipe = $request->tipe;
        $tgl1 = $request->tgl1;
        $tgl2 = $request->tgl2;
        $div1 = $request->div1;
        $div2 = $request->div2;
        $dep1 = $request->dep1;
        $dep2 = $request->dep2;
        $kat1 = $request->kat1;
        $kat2 = $request->kat2;

        $perusahaan = DB::connection(Session::get('connection'))->table('tbmaster_perusahaan')
            ->select('prs_namaperusahaan','prs_namacabang')
            ->first();

        if($tipe === '1'){
            $data = DB::connection(Session::get('connection'))->select("SELECT
                prd_kodedivisi, div_namadivisi,
                prd_kodedepartement, dep_namadepartement,
                prd_kodekategoribarang, kat_namakategori,
                sum(mstd_gross) total
            FROM
                (
                    SELECT
                        mstd_tgldoc, prd_kodedivisi, div_namadivisi,
                        prd_kodedepartement, dep_namadepartement,
                        prd_kodekategoribarang, kat_namakategori,
                        mstd_prdcd, mstd_gross,
                        nvl(mstd_discrph,0) mstd_pot,
                        nvl(mstd_ppnrph,0) mstd_ppn,
                        nvl(mstd_ppnbmrph,0) mstd_bm, nvl(mstd_ppnbtlrph,0) mstd_btl,
                        nvl(mstd_gross,0 ) total,
                        prs_namaperusahaan, prs_namacabang
                    FROM
                        tbmaster_divisi, tbmaster_departement, tbmaster_kategori,
                        tbtr_mstran_h, tbtr_mstran_d, tbmaster_perusahaan,
                        tbmaster_prodmast
                    WHERE
                        msth_kodeigr='".Session::get('kdigr')."'
                        and nvl(msth_recordid, '0') <> '1'
                        and nvl(mstd_recordid, '0') <> '1'
                        and mstd_tgldoc between TO_DATE('".$tgl1."','DD/MM/YYYY') and TO_DATE('".$tgl2."','DD/MM/YYYY')
                        and mstd_nodoc = msth_nodoc
                        and msth_typetrn='X'
                        and prs_kodeigr= msth_kodeigr
                        and div_kodeigr(+)='".Session::get('kdigr')."'
                        and dep_kodeigr(+)='".Session::get('kdigr')."'
                        and kat_kodeigr(+)='".Session::get('kdigr')."'
                        and prd_prdcd = mstd_prdcd
                        and div_kodedivisi(+)=prd_kodedivisi
                        and dep_kodedepartement(+) = prd_kodedepartement
                        and dep_kodedivisi (+) = prd_kodedivisi
                        and kat_kodekategori (+) = prd_kodekategoribarang
                        and kat_kodedepartement (+) = prd_kodedepartement
                        and prd_kodedivisi||prd_kodedepartement||prd_kodekategoribarang
                        between '".$div1."'||'".$dep1."'||'".$kat1."' and '".$div2."'||'".$dep2."'||'".$kat2."'
                    ORDER BY
                        prd_kodedivisi,
                        prd_kodedepartement,
                        prd_kodekategoribarang
                )
            GROUP BY
                prd_kodedivisi, div_namadivisi,
                prd_kodedepartement, dep_namadepartement,
                prd_kodekategoribarang, kat_namakategori,
                prs_namaperusahaan, prs_namacabang
            ORDER BY
                prd_kodedivisi, prd_kodedepartement, prd_kodekategoribarang");

//            dd($data);

            $dompdf = new PDF();

            $pdf = PDF::loadview('BACKOFFICE.LAPORAN.penyesuaian-ringkasan-pdf',compact(['perusahaan','data','tgl1','tgl2']));

            error_reporting(E_ALL ^ E_DEPRECATED);

            $pdf->output();
            $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);

            $canvas = $dompdf ->get_canvas();
            $canvas->page_text(507, 80.75, "{PAGE_NUM} dari {PAGE_COUNT}", null, 7, array(0, 0, 0));

            $dompdf = $pdf;

            return $dompdf->stream('LAPORAN PENYESUAIAN PERSEDIAAN RINGKASAN DIVISI/DEPT/KATEGORI.pdf');
        }
        else{
            $data = DB::connection(Session::get('connection'))->select("SELECT
                msth_nodoc, TO_CHAR(msth_tgldoc,'DD/MM/YYYY') msth_tgldoc, kemasan,keterangan,
                plu, barang, mstd_qty qty, harga, total,
                prd_kodedivisi, div_namadivisi,
                prd_kodedepartement, dep_namadepartement,
                prd_kodekategoribarang, kat_namakategori,
                prs_namaperusahaan, prs_namacabang
            FROM
                (
                    SELECT msth_nodoc, msth_tgldoc, mstd_prdcd plu, mstd_keterangan keterangan,
                        prd_deskripsipanjang barang, prd_unit||'/'||prd_frac kemasan,
                        mstd_hrgsatuan harga, NVL (mstd_GROSS,0) total,
                        nvl(mstd_qty,0) mstd_qty,
                        prd_kodedivisi, div_namadivisi,
                        prd_kodedepartement, dep_namadepartement,
                        prd_kodekategoribarang, kat_namakategori,
                        mstd_prdcd, prd_deskripsipanjang, mstd_gross,
                        prs_namaperusahaan, prs_namacabang
                    FROM
                        tbmaster_divisi, tbmaster_departement, tbmaster_kategori, tbmaster_prodmast,
                        tbtr_mstran_h, tbtr_mstran_d, tbmaster_perusahaan
                    WHERE
                        msth_kodeigr='".Session::get('kdigr')."'
                        and mstd_recordid is null
                        and mstd_tgldoc between TO_DATE('".$tgl1."','DD/MM/YYYY') and TO_DATE('".$tgl2."','DD/MM/YYYY')
                        and mstd_nodoc = msth_nodoc
                        and mstd_kodeigr = '".Session::get('kdigr')."'
                        and msth_typetrn='X'
                        and prs_kodeigr= '".Session::get('kdigr')."'
                        and prd_kodeigr(+)='".Session::get('kdigr')."'
                        and div_kodeigr(+)='".Session::get('kdigr')."'
                        and dep_kodeigr(+)='".Session::get('kdigr')."'
                        and prd_prdcd(+) = mstd_prdcd
                        and kat_kodeigr(+)='".Session::get('kdigr')."'
                        and div_kodedivisi(+)=prd_kodedivisi
                        and dep_kodedepartement (+) = prd_kodedepartement
                        and dep_kodedivisi (+) = prd_kodedivisi
                        and kat_kodekategori (+) = prd_kodekategoribarang
                        and kat_kodedepartement (+) = prd_kodedepartement
                        and prd_kodedivisi||prd_kodedepartement||prd_kodekategoribarang
                        between '".$div1."'||'".$dep1."'||'".$kat1."' and '".$div2."'||'".$dep2."'||'".$kat2."'
                    ORDER BY
                            prd_kodedivisi,  prd_kodedepartement,  prd_kodekategoribarang, plu
                )
            GROUP BY
                msth_nodoc, msth_tgldoc,kemasan,keterangan,
                plu, barang, harga, mstd_qty, total,
                prd_kodedivisi, div_namadivisi,
                prd_kodedepartement, dep_namadepartement,
                prd_kodekategoribarang, kat_namakategori,
                prs_namaperusahaan, prs_namacabang
            ORDER BY
                prd_kodedivisi, prd_kodedepartement, prd_kodekategoribarang, msth_nodoc, plu");

            $dompdf = new PDF();

            $pdf = PDF::loadview('BACKOFFICE.LAPORAN.penyesuaian-rincian-pdf',compact(['perusahaan','data','tgl1','tgl2']));

            error_reporting(E_ALL ^ E_DEPRECATED);

            $pdf->output();
            $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);

            $canvas = $dompdf ->get_canvas();
            $canvas->page_text(757, 80.75, "{PAGE_NUM} dari {PAGE_COUNT}", null, 7, array(0, 0, 0));

            $dompdf = $pdf;

            return $dompdf->stream('LAPORAN PENYESUAIAN PERSEDIAAN RINCIAN PRODUK PER DIVISI/DEPT/KATEGORI.pdf');
        }
    }
}
