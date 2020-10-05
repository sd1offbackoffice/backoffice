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
            ->join('tbmaster_hargabeli','hgb_prdcd','=','prd_prdcd')
            ->select('prd_prdcd','prd_deskripsipanjang','prd_unit','prd_frac')
            ->where('prd_kodeigr',$_SESSION['kdigr'])
            ->orderBy('prd_deskripsipanjang')
            ->limit('100')
            ->get();

        $supplier = DB::table('tbmaster_supplier')
            ->select('sup_kodesupplier','sup_namasupplier')
            ->orderBy('sup_kodesupplier')
            ->limit(100)
            ->get();

        return view('BACKOFFICE.CetakTolakanPB')->with(compact(['divisi','departement','kategori','plu','supplier']));
    }

    public function cek_divisi(Request $request){
        $cek = DB::table('tbmaster_divisi')
            ->select('div_kodedivisi')
            ->where('div_kodeigr',$_SESSION['kdigr'])
            ->where('div_kodedivisi',$request->div)
            ->get();

        if(count($cek) == 0)
            return 'false';
        else{
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
    }

    public function cek_departement(Request $request){
        if($request->div1 == ''){
            $cek = DB::table('tbmaster_departement')
                ->select('dep_kodedepartement')
                ->where('dep_kodeigr',$_SESSION['kdigr'])
                ->where('dep_kodedivisi','<=',$request->div2)
                ->where('dep_kodedepartement',$request->dep)
                ->get();
        }
        else if($request->div2 == ''){
            $cek = DB::table('tbmaster_departement')
                ->select('dep_kodedepartement')
                ->where('dep_kodeigr',$_SESSION['kdigr'])
                ->where('dep_kodedivisi','>=',$request->div1)
                ->where('dep_kodedepartement',$request->dep)
                ->get();
        }
        else{
            $cek = DB::table('tbmaster_departement')
                ->select('dep_kodedepartement')
                ->where('dep_kodeigr',$_SESSION['kdigr'])
                ->whereBetween('dep_kodedivisi',[$request->div1,$request->div2])
                ->where('dep_kodedepartement',$request->dep)
                ->get();
        }


        if(count($cek) == 0)
            return 'false';
        else{
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
    }

    public function cek_kategori(Request $request){
        $kat = $request->kat;
        $div1 = $request->div1;
        $div2 = $request->div2;
        $dep1 = $request->dep1;
        $dep2 = $request->dep2;
        $kat1 = $request->kat1;
        $kat2 = $request->kat2;

        if($div1 == null){
            $divA = DB::table('tbmaster_divisi')
                ->select('div_kodedivisi')
                ->orderBy('div_kodedivisi','asc')
                ->first();
            $div1 = $divA->div_kodedivisi;
        }
        if($div2 == null){
            $divB = DB::table('tbmaster_divisi')
                ->select('div_kodedivisi')
                ->orderBy('div_kodedivisi','desc')
                ->first();
            $div2 = $divB->div_kodedivisi;
        }
        if($dep1 == null){
            $depA = DB::table('tbmaster_departement')
                ->select('dep_kodedepartement')
                ->orderBy('dep_kodedepartement','asc')
                ->first();
            $dep1 = $depA->dep_kodedepartement;
        }
        if($dep2 == null){
            $depB = DB::table('tbmaster_departement')
                ->select('dep_kodedepartement')
                ->orderBy('dep_kodedepartement','desc')
                ->first();
            $dep2 = $depB->dep_kodedepartement;
        }
        if($kat1 == null){
            $katA = DB::table('tbmaster_kategori')
                ->select('kat_kodekategori')
                ->orderBy('kat_kodekategori','asc')
                ->first();
            $kat1 = $katA->kat_kodekategori;
        }
        if($kat2 == null){
            $katB = DB::table('tbmaster_kategori')
                ->select('kat_kodekategori')
                ->orderBy('kat_kodekategori','desc')
                ->first();
            $kat2 = $katB->kat_kodekategori;
        }

        $cek = DB::table('tbmaster_kategori')
            ->select('kat_kodekategori')
            ->where('kat_kodeigr',$_SESSION['kdigr'])
            ->whereBetween('kat_kodedepartement',[$dep1,$dep2])
            ->where('kat_kodekategori',$kat)
            ->get();

        if(count($cek) == 0)
            return 'false';
        else{
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
    }

    public function div_cek_plu(Request $request){
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

    public function print_by_div(){
        if($_GET['tgl1'] != 'ALL'){
            $tgl1 = date_format(Carbon::createFromFormat('d-m-Y',$_GET['tgl1'],'Asia/Jakarta'),'d/m/Y');
        }
        else{
            $tgl1 = DB::table('tbtr_tolakanpb')
                ->selectRaw("to_char(trunc(tlk_tglpb),'dd-mm-yyyy') tgl")
                ->orderBy('tlk_tglpb','asc')
                ->first()->tgl;
        }

        if($_GET['tgl2'] != 'ALL'){
            $tgl2 = date_format(Carbon::createFromFormat('d-m-Y',$_GET['tgl2'],'Asia/Jakarta'),'d/m/Y');
        }
        else{
            $tgl2 = DB::table('tbtr_tolakanpb')
                ->selectRaw("to_char(trunc(tlk_tglpb),'dd-mm-yyyy') tgl")
                ->orderBy('tlk_tglpb','desc')
                ->first()->tgl;
        }

        $div1 = $_GET['div1'];
        $div2 = $_GET['div2'];
        $dep1 = $_GET['dep1'];
        $dep2 = $_GET['dep2'];
        $kat1 = $_GET['kat1'];
        $kat2 = $_GET['kat2'];
        $plu1 = $_GET['plu1'];
        $plu2 = $_GET['plu2'];
        $pil = $_GET['pil'];

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

        if($pil == 1)
            $where = "TLK_KETERANGANTOLAKAN NOT LIKE '%PKM' AND TLK_KETERANGANTOLAKAN LIKE 'STATUS%' AND TLK_KETERANGANTOLAKAN NOT LIKE '%ORDER LANGSUNG DI TOKO'";
        else if($pil == 2)
            $where = "TLK_KETERANGANTOLAKAN NOT LIKE '%PKM' AND TLK_KETERANGANTOLAKAN NOT LIKE 'STATUS%'";
        else if($pil == 4)
            $where = "TLK_KETERANGANTOLAKAN NOT LIKE '%PKM' AND (TLK_KETERANGANTOLAKAN NOT LIKE 'STATUS%' OR TLK_KETERANGANTOLAKAN LIKE '%TAG T%')";
        else if($pil == 5)
            $where = "TLK_KETERANGANTOLAKAN NOT LIKE '%PKM' AND (TLK_KETERANGANTOLAKAN LIKE '%KUNJUNGAN')";
        else if($pil == 6)
            $where = "TLK_KETERANGANTOLAKAN NOT LIKE '%PKM' AND (TLK_KETERANGANTOLAKAN LIKE '%MINOR%')";
        else $where = "TLK_KETERANGANTOLAKAN NOT LIKE '%PKM' AND (TLK_KETERANGANTOLAKAN NOT LIKE 'STATUS%' OR TLK_KETERANGANTOLAKAN LIKE '%TAG T%')";

        $tolakan = DB::table('tbtr_tolakanpb')
            ->join('tbmaster_prodmast',function($join){
                $join->on('tlk_kodeigr','prd_kodeigr');
                $join->on('tlk_prdcd','prd_prdcd');
            })
            ->join('tbmaster_divisi',function($join){
                $join->on('div_kodedivisi','prd_kodedivisi');
            })
            ->join('tbmaster_departement',function($join){
                $join->on('dep_kodedepartement','prd_kodedepartement');
                $join->on('dep_kodedivisi','prd_kodedivisi');
            })
            ->join('tbmaster_kategori',function($join){
                $join->on('kat_kodedepartement','prd_kodedepartement');
                $join->on('kat_kodekategori','prd_kodekategoribarang');
            })
            ->leftJoin('tbmaster_supplier',function($join){
                    $join->on('sup_kodeigr','tlk_kodeigr');
                    $join->on('sup_kodesupplier','tlk_kodesupplier');
            })
            ->leftJoin('tbmaster_kkpkm',function($join){
                $join->on('pkm_kodeigr','prd_kodeigr');
                $join->on('pkm_kodedivisi','prd_kodedivisi');
                $join->on('pkm_kodedepartement','prd_kodedepartement');
                $join->on('pkm_kodekategoribarang','prd_kodekategoribarang');
                $join->on('pkm_prdcd','prd_prdcd');
            })
            ->selectRaw("TO_CHAR(TLK_TGLPB,'DD/MM/YYYY') TGLPB,
                TLK_NOPB NOPB, PRD_KODEDIVISI DIV, DIV_NAMADIVISI DIVNAME, PRD_KODEDEPARTEMENT DEP,
                DEP_NAMADEPARTEMENT DEPNAME, PRD_KODEKATEGORIBARANG KAT, KAT_NAMAKATEGORI KATNAME,
                TLK_PRDCD PRDCD, PRD_DESKRIPSIPANJANG DESKRIPSI, PRD_UNIT || '/' || PRD_FRAC SATUAN,
                PRD_KODETAG TAG, TLK_KODESUPPLIER SUPCO, SUP_NAMASUPPLIER SUPNAME, PKM_PKMT PKMT,
                TLK_KETERANGANTOLAKAN KETERANGAN")
            ->whereRaw("trunc(tlk_tglpb) between to_date('".$tgl1."','dd-mm-yyyy')and to_date('".$tgl2."','dd-mm-yyyy')")
            ->whereBetween('prd_kodedivisi',[$div1,$div2])
            ->whereBetween('prd_kodedepartement',[$dep1,$dep2])
            ->whereBetween('prd_kodekategoribarang',[$kat1,$kat2])
            ->whereBetween('prd_prdcd',[$plu1,$plu2])
            ->whereRaw($where)
            ->orderBy('tlk_nopb')
            ->orderBy('prd_kodedivisi')
            ->orderBy('prd_kodedepartement')
            ->orderBy('tlk_prdcd')
            ->get();

//        dd($tolakan);

        $data = [
            'title' => 'LAPORAN DAFTAR TOLAKAN PB / DIVISI / DEPT / KATEGORY',
            'perusahaan' => $perusahaan,
            'tolakan' => $tolakan,
            'tgl1' => $tgl1,
            'tgl2' => $tgl2
        ];

        $now = Carbon::now('Asia/Jakarta');
        $now = date_format($now, 'd-m-Y H-i-s');

        $dompdf = new PDF();

        $pdf = PDF::loadview('BACKOFFICE.CetakTolakanPB-laporan-by-divisi', $data);

        error_reporting(E_ALL ^ E_DEPRECATED);

        $pdf->output();

        if(count($tolakan) > 0) {
            $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);
            $canvas = $dompdf->get_canvas();
            $canvas->page_text(525, 10, "Page {PAGE_NUM} of {PAGE_COUNT}", null, 8, array(0, 0, 0));
        }

        $dompdf = $pdf;

        // (Optional) Setup the paper size and orientation
        //        $dompdf->setPaper('a4', 'landscape');

        // Render the HTML as PDF

        return $dompdf->stream('Laporan Tolakan PB.pdf');
    }

    public function search_supplier(Request $request){
        if($request->sup == ''){
            $supplier = DB::table('tbmaster_supplier')
                ->select('sup_kodesupplier','sup_namasupplier')
                ->orderBy('sup_kodesupplier')
                ->limit(100)
                ->get();
        }
        else if(is_numeric(substr($request->sup,1,4))){
           $supplier = DB::table('tbmaster_supplier')
               ->select('sup_kodesupplier','sup_namasupplier')
               ->where('sup_kodesupplier','like',$request->sup.'%')
               ->orderBy('sup_kodesupplier')
               ->get();
        }
        else{
            $supplier = DB::table('tbmaster_supplier')
                ->select('sup_kodesupplier','sup_namasupplier')
                ->where('sup_namasupplier','like','%'.$request->sup.'%')
                ->orderBy('sup_kodesupplier')
                ->get();
        }

        if(count($supplier) == 0)
            return 'false';
        else return $supplier;
    }

    public function sup_search_plu(Request $request){
        $plu = $request->plu;
        $sup1 = $request->sup1;
        $sup2 = $request->sup2;

        if($sup1 == ''){
            $supA = DB::table('tbmaster_supplier')
                ->select('sup_kodesupplier')
                ->where('sup_kodeigr',$_SESSION['kdigr'])
                ->orderBy('sup_kodesupplier','asc')
                ->first();

            $sup1 = $supA->sup_kodesupplier;
        }

        if($sup2 == ''){
            $supB = DB::table('tbmaster_supplier')
                ->select('sup_kodesupplier')
                ->where('sup_kodeigr',$_SESSION['kdigr'])
                ->orderBy('sup_kodesupplier','desc')
                ->first();

            $sup2 = $supB->sup_kodesupplier;
        }

        if($plu == ''){
            $produk = DB::table('tbmaster_prodmast')
                ->join('tbmaster_hargabeli',function($join){
                    $join->on('hgb_kodeigr','prd_kodeigr');
                    $join->on('hgb_prdcd','prd_prdcd');
                })
                ->select('prd_prdcd','prd_deskripsipanjang','prd_unit','prd_frac')
                ->where('prd_kodeigr',$_SESSION['kdigr'])
                ->whereBetween('hgb_kodesupplier',[$sup1,$sup2])
                ->orderBy('prd_deskripsipanjang')
                ->limit('100')
                ->get();
        }
        else if(is_numeric($plu)){
            $produk = DB::table('tbmaster_prodmast')
                ->join('tbmaster_hargabeli',function($join){
                    $join->on('hgb_kodeigr','prd_kodeigr');
                    $join->on('hgb_prdcd','prd_prdcd');
                })
                ->select('prd_prdcd','prd_deskripsipanjang','prd_unit','prd_frac')
                ->where('prd_kodeigr',$_SESSION['kdigr'])
                ->whereBetween('hgb_kodesupplier',[$sup1,$sup2])
                ->where('prd_prdcd','like','%'.$plu)
                ->orderBy('prd_deskripsipanjang')
                ->get();
        }
        else{
            $produk = DB::table('tbmaster_prodmast')
                ->join('tbmaster_hargabeli',function($join){
                    $join->on('hgb_kodeigr','prd_kodeigr');
                    $join->on('hgb_prdcd','prd_prdcd');
                })
                ->select('prd_prdcd','prd_deskripsipanjang','prd_unit','prd_frac')
                ->where('prd_kodeigr',$_SESSION['kdigr'])
                ->whereBetween('hgb_kodesupplier',[$sup1,$sup2])
                ->where('prd_deskripsipanjang','like','%'.$plu.'%')
                ->orderBy('prd_deskripsipanjang')
                ->get();
        }

        if(count($produk) == 0)
            return 'false';
        else return $produk;
    }

    public function cek_supplier(Request $request){
        $sup = $request->sup;
        $sup1 = $request->sup1;
        $sup2 = $request->sup2;

        $cek = DB::table('tbmaster_supplier')
            ->select('sup_kodesupplier')
            ->where('sup_kodeigr',$_SESSION['kdigr'])
            ->where('sup_kodesupplier',$sup)
            ->get();

        if(count($cek) == 0){
            return 'false';
        }
        else{
            if($sup1 == ''){
                $supA = DB::table('tbmaster_supplier')
                    ->select('sup_kodesupplier')
                    ->where('sup_kodeigr',$_SESSION['kdigr'])
                    ->orderBy('sup_kodesupplier','asc')
                    ->first();

                $sup1 = $supA->sup_kodesupplier;
            }

            if($sup2 == ''){
                $supB = DB::table('tbmaster_supplier')
                    ->select('sup_kodesupplier')
                    ->where('sup_kodeigr',$_SESSION['kdigr'])
                    ->orderBy('sup_kodesupplier','desc')
                    ->first();

                $sup2 = $supB->sup_kodesupplier;
            }

            $produk = DB::table('tbmaster_prodmast')
                ->join('tbmaster_hargabeli',function($join){
                    $join->on('hgb_kodeigr','prd_kodeigr');
                    $join->on('hgb_prdcd','prd_prdcd');
                })
                ->select('prd_prdcd','prd_deskripsipanjang','prd_unit','prd_frac')
                ->where('prd_kodeigr',$_SESSION['kdigr'])
                ->whereBetween('hgb_kodesupplier',[$sup1,$sup2])
                ->orderBy('prd_deskripsipanjang')
                ->limit('100')
                ->get();

            return $produk;
        }
    }

    public function sup_cek_plu(Request $request){
        $sup1 = $request->sup1;
        $sup2 = $request->sup2;
        $plu = $request->plu;

        if($sup1 == ''){
            $supA = DB::table('tbmaster_supplier')
                ->select('sup_kodesupplier')
                ->where('sup_kodeigr',$_SESSION['kdigr'])
                ->orderBy('sup_kodesupplier','asc')
                ->first();

            $sup1 = $supA->sup_kodesupplier;
        }

        if($sup2 == ''){
            $supB = DB::table('tbmaster_supplier')
                ->select('sup_kodesupplier')
                ->where('sup_kodeigr',$_SESSION['kdigr'])
                ->orderBy('sup_kodesupplier','desc')
                ->first();

            $sup2 = $supB->sup_kodesupplier;
        }

        $cek = DB::table('tbmaster_prodmast')
            ->join('tbmaster_hargabeli',function($join){
                $join->on('hgb_kodeigr','prd_kodeigr');
                $join->on('hgb_prdcd','prd_prdcd');
            })
            ->select('prd_prdcd')
            ->where('prd_kodeigr',$_SESSION['kdigr'])
            ->whereBetween('hgb_kodesupplier',[$sup1,$sup2])
            ->where('prd_prdcd',$plu)
            ->get();

        if(count($cek) == 0)
            return 'false';
        else return 'true';
    }

    public function print_by_sup(){
        $tgl1 = date_format(Carbon::createFromFormat('d-m-Y',$_GET['tgl1'],'Asia/Jakarta'),'d/m/Y');
        $tgl2 = date_format(Carbon::createFromFormat('d-m-Y',$_GET['tgl2'],'Asia/Jakarta'),'d/m/Y');
        $sup1 = $_GET['sup1'];
        $sup2 = $_GET['sup2'];
        $plu1 = $_GET['plu1'];
        $plu2 = $_GET['plu2'];
        $pil = $_GET['pil'];

        $now = Carbon::now('Asia/Jakarta');
        $now = date_format($now,'d-m-Y');

        if($tgl1 == '' || strlen($tgl1) != 10)
            $tgl1 = $now;
        if($tgl2 == '' || strlen($tgl2) != 10)
            $tgl2 = $now;
        if($sup1 == 'ALL'){
            $supA = DB::table('tbmaster_supplier')
                ->select('sup_kodesupplier')
                ->where('sup_kodeigr',$_SESSION['kdigr'])
                ->orderBy('sup_kodesupplier','asc')
                ->first();

            $sup1 = $supA->sup_kodesupplier;
        }

        if($sup2 == 'ALL'){
            $supB = DB::table('tbmaster_supplier')
                ->select('sup_kodesupplier')
                ->where('sup_kodeigr',$_SESSION['kdigr'])
                ->orderBy('sup_kodesupplier','desc')
                ->first();

            $sup2 = $supB->sup_kodesupplier;
        }

        if($plu1 == 'ALL'){
            $pluA = DB::table('tbmaster_prodmast')
                ->join('tbmaster_hargabeli',function($join){
                    $join->on('hgb_kodeigr','prd_kodeigr');
                    $join->on('hgb_prdcd','prd_prdcd');
                })
                ->select('prd_prdcd')
                ->where('prd_kodeigr',$_SESSION['kdigr'])
                ->whereBetween('hgb_kodesupplier',[$sup1,$sup2])
                ->orderBy('prd_prdcd','asc')
                ->first();
            $plu1 = $pluA->prd_prdcd;
        }

        if($plu2 == 'ALL'){
            $pluB = DB::table('tbmaster_prodmast')
                ->join('tbmaster_hargabeli',function($join){
                    $join->on('hgb_kodeigr','prd_kodeigr');
                    $join->on('hgb_prdcd','prd_prdcd');
                })
                ->select('prd_prdcd')
                ->where('prd_kodeigr',$_SESSION['kdigr'])
                ->whereBetween('hgb_kodesupplier',[$sup1,$sup2])
                ->orderBy('prd_prdcd','desc')
                ->first();
            $plu2 = $pluB->prd_prdcd;
        }

        $perusahaan = DB::table('tbmaster_perusahaan')
            ->where('prs_kodeigr',$_SESSION['kdigr'])
            ->first();

        if($pil == 1)
            $where = "TLK_KETERANGANTOLAKAN NOT LIKE '%PKM' AND TLK_KETERANGANTOLAKAN LIKE 'STATUS%' AND TLK_KETERANGANTOLAKAN NOT LIKE '%ORDER LANGSUNG DI TOKO'";
        else if($pil == 2)
            $where = "TLK_KETERANGANTOLAKAN NOT LIKE '%PKM' AND TLK_KETERANGANTOLAKAN NOT LIKE 'STATUS%'";
        else if($pil == 4)
            $where = "TLK_KETERANGANTOLAKAN NOT LIKE '%PKM' AND (TLK_KETERANGANTOLAKAN NOT LIKE 'STATUS%' OR TLK_KETERANGANTOLAKAN LIKE '%TAG T%')";
        else if($pil == 5)
            $where = "TLK_KETERANGANTOLAKAN NOT LIKE '%PKM' AND (TLK_KETERANGANTOLAKAN LIKE '%KUNJUNGAN')";
        else if($pil == 6)
            $where = "TLK_KETERANGANTOLAKAN NOT LIKE '%PKM' AND (TLK_KETERANGANTOLAKAN LIKE '%MINOR%')";
        else $where = "TLK_KETERANGANTOLAKAN NOT LIKE '%PKM' AND (TLK_KETERANGANTOLAKAN NOT LIKE 'STATUS%' OR TLK_KETERANGANTOLAKAN LIKE '%TAG T%')";

        $tolakan = DB::table('tbtr_tolakanpb')
            ->join('tbmaster_prodmast',function($join){
                $join->on('tlk_kodeigr','prd_kodeigr');
                $join->on('tlk_prdcd','prd_prdcd');
            })
            ->join('tbmaster_divisi',function($join){
                $join->on('div_kodedivisi','prd_kodedivisi');
            })
            ->join('tbmaster_departement',function($join){
                $join->on('dep_kodedepartement','prd_kodedepartement');
                $join->on('dep_kodedivisi','prd_kodedivisi');
            })
            ->join('tbmaster_kategori',function($join){
                $join->on('kat_kodedepartement','prd_kodedepartement');
                $join->on('kat_kodekategori','prd_kodekategoribarang');
            })
            ->leftJoin('tbmaster_supplier',function($join){
                $join->on('sup_kodeigr','tlk_kodeigr');
                $join->on('sup_kodesupplier','tlk_kodesupplier');
            })
            ->leftJoin('tbmaster_kkpkm',function($join){
                $join->on('pkm_kodeigr','prd_kodeigr');
                $join->on('pkm_kodedivisi','prd_kodedivisi');
                $join->on('pkm_kodedepartement','prd_kodedepartement');
                $join->on('pkm_kodekategoribarang','prd_kodekategoribarang');
                $join->on('pkm_prdcd','prd_prdcd');
            })
            ->selectRaw("TO_CHAR(TLK_TGLPB,'DD/MM/YYYY') TGLPB, TLK_NOPB NOPB, 
                TLK_PRDCD PRDCD, PRD_DESKRIPSIPANJANG DESKRIPSI, PRD_UNIT || '/' || PRD_FRAC SATUAN,
                PRD_KODETAG TAG, PRD_KODEDIVISI DIV, PRD_KODEDEPARTEMENT DEP,
                PRD_KODEKATEGORIBARANG KAT, TLK_KODESUPPLIER SUPCO, SUP_NAMASUPPLIER SUPNAME, PKM_PKMT PKMT,
                TLK_KETERANGANTOLAKAN KETERANGAN")
            ->whereRaw("trunc(tlk_tglpb) between to_date('".$tgl1."','dd-mm-yyyy')and to_date('".$tgl2."','dd-mm-yyyy')")
            ->whereBetween('tlk_kodesupplier',[$sup1,$sup2])
            ->whereBetween('prd_prdcd',[$plu1,$plu2])
            ->whereRaw($where)
            ->orderBy('tlk_nopb')
            ->orderBy('tlk_kodesupplier')
            ->orderBy('tlk_prdcd')
            ->get();

//        dd($tolakan);

        $data = [
            'title' => 'LAPORAN DAFTAR TOLAKAN PB / SUPPLIER',
            'perusahaan' => $perusahaan,
            'tolakan' => $tolakan,
            'tgl1' => $tgl1,
            'tgl2' => $tgl2
        ];

        $now = Carbon::now('Asia/Jakarta');
        $now = date_format($now, 'd-m-Y H-i-s');

        $dompdf = new PDF();

        $pdf = PDF::loadview('BACKOFFICE.CetakTolakanPB-laporan-by-supplier', $data);

        error_reporting(E_ALL ^ E_DEPRECATED);

        $pdf->output();

        if(count($tolakan) > 0) {
            $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);
            $canvas = $dompdf->get_canvas();
            $canvas->page_text(525, 10, "Page {PAGE_NUM} of {PAGE_COUNT}", null, 8, array(0, 0, 0));
        }

        $dompdf = $pdf;

        // (Optional) Setup the paper size and orientation
        //        $dompdf->setPaper('a4', 'landscape');

        // Render the HTML as PDF

        return $dompdf->stream('Laporan Tolakan PB.pdf');
    }
}