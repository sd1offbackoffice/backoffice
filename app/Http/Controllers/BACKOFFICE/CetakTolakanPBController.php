<?php

namespace App\Http\Controllers\BACKOFFICE;

use Dompdf\Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use PDF;

class CetakTolakanPBController extends Controller
{
    //

    public function index(){
        $divisi = DB::table('tbmaster_divisi')
            ->select('div_kodedivisi','div_namadivisi')
            ->where('div_kodeigr',$_SESSION['kdigr'])
            ->get();

        $departement = DB::table('tbmaster_departement')
            ->select('dep_kodedepartement','dep_namadepartement','dep_kodedivisi')
            ->where('dep_kodeigr',$_SESSION['kdigr'])
            ->orderBy('dep_kodedepartement')
            ->get();

        $kategori = DB::table('tbmaster_kategori')
            ->select('kat_kodedepartement','kat_kodekategori','kat_namakategori')
            ->where('kat_kodeigr',$_SESSION['kdigr'])
            ->orderBy('kat_kodedepartement')
            ->orderBy('kat_kodekategori')
            ->get();

        $plu = DB::table('tbmaster_prodmast')
            ->select('prd_prdcd','prd_deskripsipanjang','prd_unit','prd_frac')
            ->where('prd_kodeigr',$_SESSION['kdigr'])
            ->orderBy('prd_deskripsipanjang')
            ->limit('100')
            ->get();

        return view('BACKOFFICE.CetakTolakanPB')->with(compact(['divisi','departement','kategori','plu']));
    }

    public function cek_divisi(Request $request){
        $cek = DB::table('tbmaster_divisi')
            ->where('div_kodeigr',$_SESSION['kdigr'])
            ->where('div_kodedivisi',$request->kodedivisi)
            ->get();

        if(count($cek) > 0)
            return 'true';
        else return 'false';
    }

    public function cek_plu(Request $request){

        $divA = DB::table('tbmaster_divisi')
            ->select('div_kodedivisi')
            ->orderBy('div_kodedivisi','asc')
            ->first();

        $divB = DB::table('tbmaster_divisi')
            ->select('div_kodedivisi')
            ->orderBy('div_kodedivisi','desc')
            ->first();

        $depA = DB::table('tbmaster_departement')
            ->select('dep_kodedepartement')
            ->orderBy('dep_kodedepartement','asc')
            ->first();

        $depB = DB::table('tbmaster_departement')
            ->select('dep_kodedepartement')
            ->orderBy('dep_kodedepartement','desc')
            ->first();

        $katA = DB::table('tbmaster_kategori')
            ->select('kat_kodekategori')
            ->orderBy('kat_kodekategori','asc')
            ->first();

        $katB = DB::table('tbmaster_kategori')
            ->select('kat_kodekategori')
            ->orderBy('kat_kodekategori','desc')
            ->first();

        $div1 = $request->div1;
        $div2 = $request->div2;
        $dep1 = $request->dep1;
        $dep2 = $request->dep2;
        $kat1 = $request->kat1;
        $kat2 = $request->kat2;
        $plu = $request->plu;

        if($div1 == null)
            $div1 = $divA->div_kodedivisi;
        if($div2 == null)
            $div2 = $divB->div_kodedivisi;
        if($dep1 == null)
            $dep1 = $depA->dep_kodedepartement;
        if($dep2 == null)
            $dep2 = $depB->dep_kodedepartement;
        if($kat1 == null)
            $kat1 = $katA->kat_kodekategori;
        if($kat2 == null)
            $kat2 = $katB->kat_kodekategori;

        $cek = DB::table('tbmaster_prodmast')
            ->select('prd_prdcd')
            ->where('prd_kodeigr',$_SESSION['kdigr'])
            ->whereBetween('prd_kodedivisi',[$div1,$div2])
            ->whereBetween('prd_kodedepartement',[$dep1,$dep2])
            ->whereBetween('prd_kodekategoribarang',[$kat1,$kat2])
            ->where('prd_prdcd',$plu)
            ->first();

        if($cek)
            return 'true';
        else return 'false';
    }

    public function get_departement(Request $request){
        $div1 = $request->div1;
        $div2 = $request->div2;

        if($div1 == null && $div2 == null){
            $departement = DB::table('tbmaster_departement')
                ->select('dep_kodedepartement','dep_namadepartement','dep_kodedivisi')
                ->where('dep_kodeigr',$_SESSION['kdigr'])
                ->orderBy('dep_kodedepartement')
                ->get();
        }
        else if($div1 == null && $div2 != null){
            $departement = DB::table('tbmaster_departement')
                ->select('dep_kodedepartement','dep_namadepartement','dep_kodedivisi')
                ->where('dep_kodeigr',$_SESSION['kdigr'])
                ->where('dep_kodedivisi','<=',$div2)
                ->orderBy('dep_kodedepartement')
                ->get();
        }
        else if($div1 != null && $div2 == null){
            $departement = DB::table('tbmaster_departement')
                ->select('dep_kodedepartement','dep_namadepartement','dep_kodedivisi')
                ->where('dep_kodeigr',$_SESSION['kdigr'])
                ->where('dep_kodedivisi','>=',$div1)
                ->orderBy('dep_kodedepartement')
                ->get();
        }
        else{
            $departement = DB::table('tbmaster_departement')
                ->select('dep_kodedepartement','dep_namadepartement','dep_kodedivisi')
                ->where('dep_kodeigr',$_SESSION['kdigr'])
                ->whereBetween('dep_kodedivisi',[$div1,$div2])
                ->orderBy('dep_kodedepartement')
                ->get();
        }

        return $departement;
    }

    public function get_kategori(Request $request){
        $dep1 = $request->dep1;
        $dep2 = $request->dep2;

        if($dep1 == null && $dep2 == null){
            $kategori = DB::table('tbmaster_kategori')
                ->select('kat_kodedepartement','kat_kodekategori','kat_namakategori')
                ->where('kat_kodeigr',$_SESSION['kdigr'])
                ->orderBy('kat_kodedepartement')
                ->orderBy('kat_kodekategori')
                ->get();
        }
        else if($dep1 == null && $dep2 != null){
            $kategori = DB::table('tbmaster_kategori')
                ->select('kat_kodedepartement','kat_kodekategori','kat_namakategori')
                ->where('kat_kodeigr',$_SESSION['kdigr'])
                ->where('kat_kodedepartement','<=',$dep2)
                ->orderBy('kat_kodedepartement')
                ->orderBy('kat_kodekategori')
                ->get();
        }
        else if($dep1 != null && $dep2 == null){
            $kategori = DB::table('tbmaster_kategori')
                ->select('kat_kodedepartement','kat_kodekategori','kat_namakategori')
                ->where('kat_kodeigr',$_SESSION['kdigr'])
                ->where('kat_kodedepartement','>=',$dep1)
                ->orderBy('kat_kodedepartement')
                ->orderBy('kat_kodekategori')
                ->get();
        }
        else{
            $kategori = DB::table('tbmaster_kategori')
                ->select('kat_kodedepartement','kat_kodekategori','kat_namakategori')
                ->where('kat_kodeigr',$_SESSION['kdigr'])
                ->whereBetween('kat_kodedepartement',[$dep1,$dep2])
                ->orderBy('kat_kodedepartement')
                ->orderBy('kat_kodekategori')
                ->get();
        }

        return $kategori;
    }

    public function get_plu(Request $request){
        $divA = DB::table('tbmaster_divisi')
            ->select('div_kodedivisi')
            ->orderBy('div_kodedivisi','asc')
            ->first();

        $divB = DB::table('tbmaster_divisi')
            ->select('div_kodedivisi')
            ->orderBy('div_kodedivisi','desc')
            ->first();

        $depA = DB::table('tbmaster_departement')
            ->select('dep_kodedepartement')
            ->orderBy('dep_kodedepartement','asc')
            ->first();

        $depB = DB::table('tbmaster_departement')
            ->select('dep_kodedepartement')
            ->orderBy('dep_kodedepartement','desc')
            ->first();

        $katA = DB::table('tbmaster_kategori')
            ->select('kat_kodekategori')
            ->orderBy('kat_kodekategori','asc')
            ->first();

        $katB = DB::table('tbmaster_kategori')
            ->select('kat_kodekategori')
            ->orderBy('kat_kodekategori','desc')
            ->first();

        $div1 = $request->div1;
        $div2 = $request->div2;
        $dep1 = $request->dep1;
        $dep2 = $request->dep2;
        $kat1 = $request->kat1;
        $kat2 = $request->kat2;

        if($div1 == null)
            $div1 = $divA->div_kodedivisi;
        if($div2 == null)
            $div2 = $divB->div_kodedivisi;
        if($dep1 == null)
            $dep1 = $depA->dep_kodedepartement;
        if($dep2 == null)
            $dep2 = $depB->dep_kodedepartement;
        if($kat1 == null)
            $kat1 = $katA->kat_kodekategori;
        if($kat2 == null)
            $kat2 = $katB->kat_kodekategori;

        $plu = DB::table('tbmaster_prodmast')
            ->select('prd_prdcd','prd_deskripsipanjang','prd_unit','prd_frac')
            ->where('prd_kodeigr',$_SESSION['kdigr'])
            ->whereBetween('prd_kodedivisi',[$div1,$div2])
            ->whereBetween('prd_kodedepartement',[$dep1,$dep2])
            ->whereBetween('prd_kodekategoribarang',[$kat1,$kat2])
            ->orderBy('prd_deskripsipanjang')
            ->limit('100')
            ->get();

        return $plu;
    }

    public function div_print(){
        $tgl1 = $_GET['tgl1'];
        $tgl2 = $_GET['tgl2'];
        $div1 = $_GET['div1'];
        $div2 = $_GET['div2'];
        $dep1 = $_GET['dep1'];
        $dep2 = $_GET['dep2'];
        $kat1 = $_GET['kat1'];
        $kat2 = $_GET['kat2'];
        $plu1 = $_GET['plu1'];
        $plu2 = $_GET['plu2'];

        $divA = DB::table('tbmaster_divisi')
            ->select('div_kodedivisi')
            ->orderBy('div_kodedivisi','asc')
            ->first();

        $divB = DB::table('tbmaster_divisi')
            ->select('div_kodedivisi')
            ->orderBy('div_kodedivisi','desc')
            ->first();

        $depA = DB::table('tbmaster_departement')
            ->select('dep_kodedepartement')
            ->orderBy('dep_kodedepartement','asc')
            ->first();

        $depB = DB::table('tbmaster_departement')
            ->select('dep_kodedepartement')
            ->orderBy('dep_kodedepartement','desc')
            ->first();

        $katA = DB::table('tbmaster_kategori')
            ->select('kat_kodekategori')
            ->orderBy('kat_kodekategori','asc')
            ->first();

        $katB = DB::table('tbmaster_kategori')
            ->select('kat_kodekategori')
            ->orderBy('kat_kodekategori','desc')
            ->first();

        if($div1 == 'ALL')
            $div1 = $divA->div_kodedivisi;
        if($div2 == 'ALL')
            $div2 = $divB->div_kodedivisi;
        if($dep1 == 'ALL')
            $dep1 = $depA->dep_kodedepartement;
        if($dep2 == 'ALL')
            $dep2 = $depB->dep_kodedepartement;
        if($kat1 == 'ALL')
            $kat1 = $katA->kat_kodekategori;
        if($kat2 == 'ALL')
            $kat2 = $katB->kat_kodekategori;

        $pluA = DB::table('tbmaster_prodmast')
            ->select('prd_prdcd')
            ->where('prd_kodeigr',$_SESSION['kdigr'])
            ->whereBetween('prd_kodedivisi',[$div1,$div2])
            ->whereBetween('prd_kodedepartement',[$dep1,$dep2])
            ->whereBetween('prd_kodekategoribarang',[$kat1,$kat2])
            ->orderBy('prd_prdcd','asc')
            ->first();

        $pluB = DB::table('tbmaster_prodmast')
            ->select('prd_prdcd')
            ->where('prd_kodeigr',$_SESSION['kdigr'])
            ->whereBetween('prd_kodedivisi',[$div1,$div2])
            ->whereBetween('prd_kodedepartement',[$dep1,$dep2])
            ->whereBetween('prd_kodekategoribarang',[$kat1,$kat2])
            ->orderBy('prd_prdcd','desc')
            ->first();

        if($plu1 == 'ALL')
            $plu1 = $pluA->prd_prdcd;
        if($plu2 == 'ALL')
            $plu2 = $pluB->prd_prdcd;

        $perusahaan = DB::table('tbmaster_perusahaan')
            ->where('prs_kodeigr',$_SESSION['kdigr'])
            ->first();

        $tolakan = DB::table('tbtr_tolakanpb')
            ->join('tbmaster_prodmast',function($join){
                $join->on('tlk_prdcd','prd_prdcd')
            })
            ->selectRaw("PRS_KODEIGR, PRS_NAMAPERUSAHAAN, PRS_NAMACABANG, TRUNC (TLK_TGLPB) TGLPB,
                TLK_NOPB NOPB, PRD_KODEDIVISI DIV, DIV_NAMADIVISI DIVNAME, PRD_KODEDEPARTEMENT DEP,
                DEP_NAMADEPARTEMENT DEPNAME, PRD_KODEKATEGORIBARANG KAT, KAT_NAMAKATEGORI KATNAME,
                TLK_PRDCD PRDCD, PRD_DESKRIPSIPANJANG DESKRIPSI, PRD_UNIT || '/' || PRD_FRAC SATUAN,
                PRD_KODETAG TAG, TLK_KODESUPPLIER SUPCO, SUP_NAMASUPPLIER SUPNAME, PKM_PKMT PKMT,
                TLK_KETERANGANTOLAKAN")
            ->get();

        $data = [
            'title' => 'LAPORAN DAFTAR TOLAKAN PB / DIVISI / DEPT / KATEGORY',
            'perusahaan' => $perusahaan,
        ];

        $now = Carbon::now('Asia/Jakarta');
        $now = date_format($now, 'd-m-Y H-i-s');

        $dompdf = new PDF();

        $pdf = PDF::loadview('BACKOFFICE.CetakTolakanPB-laporan', $data);

        error_reporting(E_ALL ^ E_DEPRECATED);

        $pdf->output();
        $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);

        $canvas = $dompdf ->get_canvas();
        $canvas->page_text(525, 10, "Page {PAGE_NUM} of {PAGE_COUNT}", null, 8, array(0, 0, 0));

        $dompdf = $pdf;

        // (Optional) Setup the paper size and orientation
        //        $dompdf->setPaper('a4', 'landscape');

        // Render the HTML as PDF

        return $dompdf->stream('Laporan Tolakan PB.pdf');
    }
}
