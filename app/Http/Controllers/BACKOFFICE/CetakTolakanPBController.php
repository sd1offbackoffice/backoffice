<?php

namespace App\Http\Controllers\BACKOFFICE;

use Dompdf\Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller; use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use PDF;

class CetakTolakanPBController extends Controller
{
    //

    public function index(){
        $divisi = DB::connection(Session::get('connection'))->table('tbmaster_divisi')
            ->select('div_kodedivisi','div_namadivisi')
            ->where('div_kodeigr',Session::get('kdigr'))
            ->get();

        $departement = DB::connection(Session::get('connection'))->table('tbmaster_departement')
            ->select('dep_kodedepartement','dep_namadepartement','dep_kodedivisi')
            ->where('dep_kodeigr',Session::get('kdigr'))
            ->orderBy('dep_kodedepartement')
            ->get();

        $kategori = DB::connection(Session::get('connection'))->table('tbmaster_kategori')
            ->select('kat_kodedepartement','kat_kodekategori','kat_namakategori')
            ->where('kat_kodeigr',Session::get('kdigr'))
            ->orderBy('kat_kodedepartement')
            ->orderBy('kat_kodekategori')
            ->get();

        $plu = DB::connection(Session::get('connection'))->table('tbmaster_prodmast')
            ->join('tbmaster_hargabeli','hgb_prdcd','=','prd_prdcd')
            ->select('prd_prdcd','prd_deskripsipanjang','prd_unit','prd_frac')
            ->where('prd_kodeigr',Session::get('kdigr'))
            ->orderBy('prd_deskripsipanjang')
            ->limit('100')
            ->get();

        $supplier = DB::connection(Session::get('connection'))->table('tbmaster_supplier')
            ->select('sup_kodesupplier','sup_namasupplier')
            ->orderBy('sup_kodesupplier')
            ->get();

        return view('BACKOFFICE.CetakTolakanPB')->with(compact(['divisi','departement','kategori','plu','supplier']));
    }

    public function cek_divisi(Request $request){
        $cek = DB::connection(Session::get('connection'))->table('tbmaster_divisi')
            ->select('div_kodedivisi')
            ->where('div_kodeigr',Session::get('kdigr'))
            ->where('div_kodedivisi',$request->div)
            ->get();

        if(count($cek) == 0)
            return 'false';
        else{
            $div1 = $request->div1;
            $div2 = $request->div2;

            if($div1 == null && $div2 == null){
                $departement = DB::connection(Session::get('connection'))->table('tbmaster_departement')
                    ->select('dep_kodedepartement','dep_namadepartement','dep_kodedivisi')
                    ->where('dep_kodeigr',Session::get('kdigr'))
                    ->orderBy('dep_kodedepartement')
                    ->get();
            }
            else if($div1 == null && $div2 != null){
                $departement = DB::connection(Session::get('connection'))->table('tbmaster_departement')
                    ->select('dep_kodedepartement','dep_namadepartement','dep_kodedivisi')
                    ->where('dep_kodeigr',Session::get('kdigr'))
                    ->where('dep_kodedivisi','<=',$div2)
                    ->orderBy('dep_kodedepartement')
                    ->get();
            }
            else if($div1 != null && $div2 == null){
                $departement = DB::connection(Session::get('connection'))->table('tbmaster_departement')
                    ->select('dep_kodedepartement','dep_namadepartement','dep_kodedivisi')
                    ->where('dep_kodeigr',Session::get('kdigr'))
                    ->where('dep_kodedivisi','>=',$div1)
                    ->orderBy('dep_kodedepartement')
                    ->get();
            }
            else{
                $departement = DB::connection(Session::get('connection'))->table('tbmaster_departement')
                    ->select('dep_kodedepartement','dep_namadepartement','dep_kodedivisi')
                    ->where('dep_kodeigr',Session::get('kdigr'))
                    ->whereBetween('dep_kodedivisi',[$div1,$div2])
                    ->orderBy('dep_kodedepartement')
                    ->get();
            }

            return $departement;
        }
    }

    public function cek_departement(Request $request){
        if($request->div1 == ''){
            $cek = DB::connection(Session::get('connection'))->table('tbmaster_departement')
                ->select('dep_kodedepartement')
                ->where('dep_kodeigr',Session::get('kdigr'))
                ->where('dep_kodedivisi','<=',$request->div2)
                ->where('dep_kodedepartement',$request->dep)
                ->get();
        }
        else if($request->div2 == ''){
            $cek = DB::connection(Session::get('connection'))->table('tbmaster_departement')
                ->select('dep_kodedepartement')
                ->where('dep_kodeigr',Session::get('kdigr'))
                ->where('dep_kodedivisi','>=',$request->div1)
                ->where('dep_kodedepartement',$request->dep)
                ->get();
        }
        else{
            $cek = DB::connection(Session::get('connection'))->table('tbmaster_departement')
                ->select('dep_kodedepartement')
                ->where('dep_kodeigr',Session::get('kdigr'))
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
                $kategori = DB::connection(Session::get('connection'))->table('tbmaster_kategori')
                    ->select('kat_kodedepartement','kat_kodekategori','kat_namakategori')
                    ->where('kat_kodeigr',Session::get('kdigr'))
                    ->orderBy('kat_kodedepartement')
                    ->orderBy('kat_kodekategori')
                    ->get();
            }
            else if($dep1 == null && $dep2 != null){
                $kategori = DB::connection(Session::get('connection'))->table('tbmaster_kategori')
                    ->select('kat_kodedepartement','kat_kodekategori','kat_namakategori')
                    ->where('kat_kodeigr',Session::get('kdigr'))
                    ->where('kat_kodedepartement','<=',$dep2)
                    ->orderBy('kat_kodedepartement')
                    ->orderBy('kat_kodekategori')
                    ->get();
            }
            else if($dep1 != null && $dep2 == null){
                $kategori = DB::connection(Session::get('connection'))->table('tbmaster_kategori')
                    ->select('kat_kodedepartement','kat_kodekategori','kat_namakategori')
                    ->where('kat_kodeigr',Session::get('kdigr'))
                    ->where('kat_kodedepartement','>=',$dep1)
                    ->orderBy('kat_kodedepartement')
                    ->orderBy('kat_kodekategori')
                    ->get();
            }
            else{
                $kategori = DB::connection(Session::get('connection'))->table('tbmaster_kategori')
                    ->select('kat_kodedepartement','kat_kodekategori','kat_namakategori')
                    ->where('kat_kodeigr',Session::get('kdigr'))
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
            $divA = DB::connection(Session::get('connection'))->table('tbmaster_divisi')
                ->select('div_kodedivisi')
                ->orderBy('div_kodedivisi','asc')
                ->first();
            $div1 = $divA->div_kodedivisi;
        }
        if($div2 == null){
            $divB = DB::connection(Session::get('connection'))->table('tbmaster_divisi')
                ->select('div_kodedivisi')
                ->orderBy('div_kodedivisi','desc')
                ->first();
            $div2 = $divB->div_kodedivisi;
        }
        if($dep1 == null){
            $depA = DB::connection(Session::get('connection'))->table('tbmaster_departement')
                ->select('dep_kodedepartement')
                ->orderBy('dep_kodedepartement','asc')
                ->first();
            $dep1 = $depA->dep_kodedepartement;
        }
        if($dep2 == null){
            $depB = DB::connection(Session::get('connection'))->table('tbmaster_departement')
                ->select('dep_kodedepartement')
                ->orderBy('dep_kodedepartement','desc')
                ->first();
            $dep2 = $depB->dep_kodedepartement;
        }
        if($kat1 == null){
            $katA = DB::connection(Session::get('connection'))->table('tbmaster_kategori')
                ->select('kat_kodekategori')
                ->orderBy('kat_kodekategori','asc')
                ->first();
            $kat1 = $katA->kat_kodekategori;
        }
        if($kat2 == null){
            $katB = DB::connection(Session::get('connection'))->table('tbmaster_kategori')
                ->select('kat_kodekategori')
                ->orderBy('kat_kodekategori','desc')
                ->first();
            $kat2 = $katB->kat_kodekategori;
        }

        $cek = DB::connection(Session::get('connection'))->table('tbmaster_kategori')
            ->select('kat_kodekategori')
            ->where('kat_kodeigr',Session::get('kdigr'))
            ->whereBetween('kat_kodedepartement',[$dep1,$dep2])
            ->where('kat_kodekategori',$kat)
            ->get();

        if(count($cek) == 0)
            return 'false';
        else{
            $plu = DB::connection(Session::get('connection'))->table('tbmaster_prodmast')
                ->select('prd_prdcd','prd_deskripsipanjang','prd_unit','prd_frac')
                ->where('prd_kodeigr',Session::get('kdigr'))
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
        $divA = DB::connection(Session::get('connection'))->table('tbmaster_divisi')
            ->select('div_kodedivisi')
            ->orderBy('div_kodedivisi','asc')
            ->first();

        $divB = DB::connection(Session::get('connection'))->table('tbmaster_divisi')
            ->select('div_kodedivisi')
            ->orderBy('div_kodedivisi','desc')
            ->first();

        $depA = DB::connection(Session::get('connection'))->table('tbmaster_departement')
            ->select('dep_kodedepartement')
            ->orderBy('dep_kodedepartement','asc')
            ->first();

        $depB = DB::connection(Session::get('connection'))->table('tbmaster_departement')
            ->select('dep_kodedepartement')
            ->orderBy('dep_kodedepartement','desc')
            ->first();

        $katA = DB::connection(Session::get('connection'))->table('tbmaster_kategori')
            ->select('kat_kodekategori')
            ->orderBy('kat_kodekategori','asc')
            ->first();

        $katB = DB::connection(Session::get('connection'))->table('tbmaster_kategori')
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

        $cek = DB::connection(Session::get('connection'))->table('tbmaster_prodmast')
            ->select('prd_prdcd')
            ->where('prd_kodeigr',Session::get('kdigr'))
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
            $tgl1 = DB::connection(Session::get('connection'))->table('tbtr_tolakanpb')
                ->selectRaw("to_char(trunc(tlk_tglpb),'dd-mm-yyyy') tgl")
                ->orderBy('tlk_tglpb','asc')
                ->first()->tgl;
        }

        if($_GET['tgl2'] != 'ALL'){
            $tgl2 = date_format(Carbon::createFromFormat('d-m-Y',$_GET['tgl2'],'Asia/Jakarta'),'d/m/Y');
        }
        else{
            $tgl2 = DB::connection(Session::get('connection'))->table('tbtr_tolakanpb')
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

        $perusahaan = DB::connection(Session::get('connection'))->table('tbmaster_perusahaan')
            ->where('prs_kodeigr',Session::get('kdigr'))
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
        else $where = "TLK_KETERANGANTOLAKAN NOT LIKE '%PKM' AND TLK_KETERANGANTOLAKAN NOT LIKE '%ORDER LANGSUNG DI TOKO'";

        $data = DB::connection(Session::get('connection'))
            ->select("select TO_CHAR(TLK_TGLPB,'DD/MM/YYYY') TGLPB,
                    TLK_NOPB NOPB, PRD_KODEDIVISI DIV, DIV_NAMADIVISI DIVNAME, PRD_KODEDEPARTEMENT DEP,
                    DEP_NAMADEPARTEMENT DEPNAME, PRD_KODEKATEGORIBARANG KAT, KAT_NAMAKATEGORI KATNAME,
                    TLK_PRDCD PRDCD, PRD_DESKRIPSIPANJANG DESKRIPSI, PRD_UNIT || '/' || PRD_FRAC SATUAN,
                    PRD_KODETAG TAG, TLK_KODESUPPLIER SUPCO, SUP_NAMASUPPLIER SUPNAME, PKM_PKMT PKMT,
                    TLK_KETERANGANTOLAKAN KETERANGAN
              FROM TBTR_TOLAKANPB,
                   TBMASTER_PRODMAST,
                   TBMASTER_DIVISI,
                   TBMASTER_DEPARTEMENT,
                   TBMASTER_KATEGORI,
                   TBMASTER_SUPPLIER,
                   TBMASTER_KKPKM
             WHERE TLK_KODEIGR = '".Session::get('kdigr')."'
               AND TLK_KODEIGR = PRD_KODEIGR
               AND TLK_PRDCD = PRD_PRDCD
               AND PRD_KODEDIVISI = DIV_KODEDIVISI
               AND PRD_KODEDIVISI = DEP_KODEDIVISI
               AND PRD_KODEDEPARTEMENT = DEP_KODEDEPARTEMENT
               AND PRD_KODEDEPARTEMENT = KAT_KODEDEPARTEMENT
               AND PRD_KODEKATEGORIBARANG = KAT_KODEKATEGORI
               AND TLK_KODEIGR = SUP_KODEIGR(+)
               AND TLK_KODESUPPLIER = SUP_KODESUPPLIER(+)
               AND PRD_KODEIGR = PKM_KODEIGR(+)
               AND PRD_KODEDIVISI = PKM_KODEDIVISI(+)
               AND PRD_KODEDEPARTEMENT = PKM_KODEDEPARTEMENT(+)
               AND PRD_KODEKATEGORIBARANG = PKM_KODEKATEGORIBARANG(+)
               AND PRD_PRDCD = PKM_PRDCD(+)
               AND TRUNC (TLK_TGLPB) BETWEEN to_date('".$tgl1."','dd/mm/yyyy') AND to_date('".$tgl2."','dd/mm/yyyy')
               AND PRD_KODEDIVISI BETWEEN NVL ('".$div1."', '0') AND NVL ('".$div2."', 'Z')
               AND PRD_KODEDEPARTEMENT BETWEEN NVL ('".$dep1."', '00') AND NVL ('".$dep2."', 'ZZ')
               AND PRD_KODEKATEGORIBARANG BETWEEN NVL ('".$kat1."', '00') AND NVL ('".$kat2."', 'ZZ')
               AND PRD_PRDCD BETWEEN NVL ('".$plu1."', '0000000') AND NVL ('".$plu2."', 'ZZZZZZZ')
               AND ".$where."
               ORDER BY tlk_nopb, prd_kodedivisi, prd_kodedepartement, prd_kodekategoribarang, tlk_prdcd");

//        $data = DB::connection(Session::get('connection'))->table('tbtr_tolakanpb')
//            ->join('tbmaster_prodmast',function($join){
//                $join->on('tlk_kodeigr','prd_kodeigr');
//                $join->on('tlk_prdcd','prd_prdcd');
//            })
//            ->join('tbmaster_divisi',function($join){
//                $join->on('div_kodedivisi','prd_kodedivisi');
//            })
//            ->join('tbmaster_departement',function($join){
//                $join->on('dep_kodedepartement','prd_kodedepartement');
//                $join->on('dep_kodedivisi','prd_kodedivisi');
//            })
//            ->join('tbmaster_kategori',function($join){
//                $join->on('kat_kodedepartement','prd_kodedepartement');
//                $join->on('kat_kodekategori','prd_kodekategoribarang');
//            })
//            ->leftJoin('tbmaster_supplier',function($join){
//                    $join->on('sup_kodeigr','tlk_kodeigr');
//                    $join->on('sup_kodesupplier','tlk_kodesupplier');
//            })
//            ->leftJoin('tbmaster_kkpkm',function($join){
//                $join->on('pkm_kodeigr','prd_kodeigr');
//                $join->on('pkm_kodedivisi','prd_kodedivisi');
//                $join->on('pkm_kodedepartement','prd_kodedepartement');
//                $join->on('pkm_kodekategoribarang','prd_kodekategoribarang');
//                $join->on('pkm_prdcd','prd_prdcd');
//            })
//            ->selectRaw("TO_CHAR(TLK_TGLPB,'DD/MM/YYYY') TGLPB,
//                TLK_NOPB NOPB, PRD_KODEDIVISI DIV, DIV_NAMADIVISI DIVNAME, PRD_KODEDEPARTEMENT DEP,
//                DEP_NAMADEPARTEMENT DEPNAME, PRD_KODEKATEGORIBARANG KAT, KAT_NAMAKATEGORI KATNAME,
//                TLK_PRDCD PRDCD, PRD_DESKRIPSIPANJANG DESKRIPSI, PRD_UNIT || '/' || PRD_FRAC SATUAN,
//                PRD_KODETAG TAG, TLK_KODESUPPLIER SUPCO, SUP_NAMASUPPLIER SUPNAME, PKM_PKMT PKMT,
//                TLK_KETERANGANTOLAKAN KETERANGAN")
//            ->whereRaw("trunc(tlk_tglpb) between to_date('".$tgl1."','dd-mm-yyyy')and to_date('".$tgl2."','dd-mm-yyyy')")
//            ->whereBetween('prd_kodedivisi',[$div1,$div2])
//            ->whereBetween('prd_kodedepartement',[$dep1,$dep2])
//            ->whereBetween('prd_kodekategoribarang',[$kat1,$kat2])
//            ->whereBetween('prd_prdcd',[$plu1,$plu2])
//            ->whereRaw($where)
//            ->orderBy('tlk_nopb')
//            ->orderBy('prd_kodedivisi')
//            ->orderBy('prd_kodedepartement')
//            ->orderBy('prd_kodekategoribarang')
//            ->orderBy('tlk_prdcd')
//            ->get();

//        dd($tolakan);

        $title = (__('LAPORAN DAFTAR TOLAKAN PB / DIVISI / DEPT / KATEGORI'));

        return view('BACKOFFICE.CetakTolakanPB-laporan-by-divisi', compact(['perusahaan','data','tgl1','tgl2','title']));

        $dompdf = new PDF();

        $pdf = PDF::loadview('BACKOFFICE.CetakTolakanPB-laporan-by-divisi', compact(['perusahaan','data','tgl1','tgl2','title']));

        error_reporting(E_ALL ^ E_DEPRECATED);

        $pdf->output();

        $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);
        $canvas = $dompdf->get_canvas();
        $canvas->page_text(755, 77.75, "{PAGE_NUM} dari {PAGE_COUNT}", null, 7, array(0, 0, 0));

        $dompdf = $pdf;

        // (Optional) Setup the paper size and orientation
        //        $dompdf->setPaper('a4', 'landscape');

        // Render the HTML as PDF

        return $dompdf->stream((__('Laporan Tolakan PB.pdf')));
    }

    public function search_supplier(Request $request){
        if($request->sup == ''){
            $supplier = DB::connection(Session::get('connection'))->table('tbmaster_supplier')
                ->select('sup_kodesupplier','sup_namasupplier')
                ->orderBy('sup_kodesupplier')
                ->get();
        }
        else if(is_numeric(substr($request->sup,1,4))){
           $supplier = DB::connection(Session::get('connection'))->table('tbmaster_supplier')
               ->select('sup_kodesupplier','sup_namasupplier')
               ->where('sup_kodesupplier','like',$request->sup.'%')
               ->orderBy('sup_kodesupplier')
               ->get();
        }
        else{
            $supplier = DB::connection(Session::get('connection'))->table('tbmaster_supplier')
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
            $supA = DB::connection(Session::get('connection'))->table('tbmaster_supplier')
                ->select('sup_kodesupplier')
                ->where('sup_kodeigr',Session::get('kdigr'))
                ->orderBy('sup_kodesupplier','asc')
                ->first();

            $sup1 = $supA->sup_kodesupplier;
        }

        if($sup2 == ''){
            $supB = DB::connection(Session::get('connection'))->table('tbmaster_supplier')
                ->select('sup_kodesupplier')
                ->where('sup_kodeigr',Session::get('kdigr'))
                ->orderBy('sup_kodesupplier','desc')
                ->first();

            $sup2 = $supB->sup_kodesupplier;
        }

        if($plu == ''){
            $produk = DB::connection(Session::get('connection'))->table('tbmaster_prodmast')
                ->join('tbmaster_hargabeli',function($join){
                    $join->on('hgb_kodeigr','prd_kodeigr');
                    $join->on('hgb_prdcd','prd_prdcd');
                })
                ->select('prd_prdcd','prd_deskripsipanjang','prd_unit','prd_frac')
                ->where('prd_kodeigr',Session::get('kdigr'))
                ->whereBetween('hgb_kodesupplier',[$sup1,$sup2])
                ->orderBy('prd_deskripsipanjang')
                ->limit('100')
                ->get();
        }
        else if(is_numeric($plu)){
            $produk = DB::connection(Session::get('connection'))->table('tbmaster_prodmast')
                ->join('tbmaster_hargabeli',function($join){
                    $join->on('hgb_kodeigr','prd_kodeigr');
                    $join->on('hgb_prdcd','prd_prdcd');
                })
                ->select('prd_prdcd','prd_deskripsipanjang','prd_unit','prd_frac')
                ->where('prd_kodeigr',Session::get('kdigr'))
                ->whereBetween('hgb_kodesupplier',[$sup1,$sup2])
                ->where('prd_prdcd','like','%'.$plu)
                ->orderBy('prd_deskripsipanjang')
                ->get();
        }
        else{
            $produk = DB::connection(Session::get('connection'))->table('tbmaster_prodmast')
                ->join('tbmaster_hargabeli',function($join){
                    $join->on('hgb_kodeigr','prd_kodeigr');
                    $join->on('hgb_prdcd','prd_prdcd');
                })
                ->select('prd_prdcd','prd_deskripsipanjang','prd_unit','prd_frac')
                ->where('prd_kodeigr',Session::get('kdigr'))
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

        $cek = DB::connection(Session::get('connection'))->table('tbmaster_supplier')
            ->select('sup_kodesupplier')
            ->where('sup_kodeigr',Session::get('kdigr'))
            ->where('sup_kodesupplier',$sup)
            ->get();

        if(count($cek) == 0){
            return 'false';
        }
        else{
            if($sup1 == ''){
                $supA = DB::connection(Session::get('connection'))->table('tbmaster_supplier')
                    ->select('sup_kodesupplier')
                    ->where('sup_kodeigr',Session::get('kdigr'))
                    ->orderBy('sup_kodesupplier','asc')
                    ->first();

                $sup1 = $supA->sup_kodesupplier;
            }

            if($sup2 == ''){
                $supB = DB::connection(Session::get('connection'))->table('tbmaster_supplier')
                    ->select('sup_kodesupplier')
                    ->where('sup_kodeigr',Session::get('kdigr'))
                    ->orderBy('sup_kodesupplier','desc')
                    ->first();

                $sup2 = $supB->sup_kodesupplier;
            }

            $produk = DB::connection(Session::get('connection'))->table('tbmaster_prodmast')
                ->join('tbmaster_hargabeli',function($join){
                    $join->on('hgb_kodeigr','prd_kodeigr');
                    $join->on('hgb_prdcd','prd_prdcd');
                })
                ->select('prd_prdcd','prd_deskripsipanjang','prd_unit','prd_frac')
                ->where('prd_kodeigr',Session::get('kdigr'))
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
            $supA = DB::connection(Session::get('connection'))->table('tbmaster_supplier')
                ->select('sup_kodesupplier')
                ->where('sup_kodeigr',Session::get('kdigr'))
                ->orderBy('sup_kodesupplier','asc')
                ->first();

            $sup1 = $supA->sup_kodesupplier;
        }

        if($sup2 == ''){
            $supB = DB::connection(Session::get('connection'))->table('tbmaster_supplier')
                ->select('sup_kodesupplier')
                ->where('sup_kodeigr',Session::get('kdigr'))
                ->orderBy('sup_kodesupplier','desc')
                ->first();

            $sup2 = $supB->sup_kodesupplier;
        }

        $cek = DB::connection(Session::get('connection'))->table('tbmaster_prodmast')
            ->join('tbmaster_hargabeli',function($join){
                $join->on('hgb_kodeigr','prd_kodeigr');
                $join->on('hgb_prdcd','prd_prdcd');
            })
            ->select('prd_prdcd')
            ->where('prd_kodeigr',Session::get('kdigr'))
            ->whereBetween('hgb_kodesupplier',[$sup1,$sup2])
            ->where('prd_prdcd',$plu)
            ->get();

        if(count($cek) == 0)
            return 'false';
        else return 'true';
    }

    public function print_by_sup(){
        $tgl1 = $_GET['tgl1'];
        $tgl2 = $_GET['tgl2'];
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
            $supA = DB::connection(Session::get('connection'))->table('tbmaster_supplier')
                ->select('sup_kodesupplier')
                ->where('sup_kodeigr',Session::get('kdigr'))
                ->orderBy('sup_kodesupplier','asc')
                ->first();

            $sup1 = $supA->sup_kodesupplier;
        }

        if($sup2 == 'ALL'){
            $supB = DB::connection(Session::get('connection'))->table('tbmaster_supplier')
                ->select('sup_kodesupplier')
                ->where('sup_kodeigr',Session::get('kdigr'))
                ->orderBy('sup_kodesupplier','desc')
                ->first();

            $sup2 = $supB->sup_kodesupplier;
        }

        if($plu1 == 'ALL'){
            $pluA = DB::connection(Session::get('connection'))->table('tbmaster_prodmast')
                ->join('tbmaster_hargabeli',function($join){
                    $join->on('hgb_kodeigr','prd_kodeigr');
                    $join->on('hgb_prdcd','prd_prdcd');
                })
                ->select('prd_prdcd')
                ->where('prd_kodeigr',Session::get('kdigr'))
                ->whereBetween('hgb_kodesupplier',[$sup1,$sup2])
                ->orderBy('prd_prdcd','asc')
                ->first();
            $plu1 = $pluA->prd_prdcd;
        }

        if($plu2 == 'ALL'){
            $pluB = DB::connection(Session::get('connection'))->table('tbmaster_prodmast')
                ->join('tbmaster_hargabeli',function($join){
                    $join->on('hgb_kodeigr','prd_kodeigr');
                    $join->on('hgb_prdcd','prd_prdcd');
                })
                ->select('prd_prdcd')
                ->where('prd_kodeigr',Session::get('kdigr'))
                ->whereBetween('hgb_kodesupplier',[$sup1,$sup2])
                ->orderBy('prd_prdcd','desc')
                ->first();
            $plu2 = $pluB->prd_prdcd;
        }

        $perusahaan = DB::connection(Session::get('connection'))->table('tbmaster_perusahaan')
            ->where('prs_kodeigr',Session::get('kdigr'))
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
        else $where = "TLK_KETERANGANTOLAKAN NOT LIKE '%PKM' AND TLK_KETERANGANTOLAKAN NOT LIKE '%ORDER LANGSUNG DI TOKO'";

//        $data = DB::connection(Session::get('connection'))
//            ->select("SELECT PRS_KODEIGR, PRS_NAMAPERUSAHAAN, PRS_NAMACABANG, TRUNC (TLK_TGLPB) TGLPB, TLK_NOPB NOPB,
//                   PRD_KODEDIVISI DIV, DIV_NAMADIVISI DIVNAME, PRD_KODEDEPARTEMENT DEP,
//                   DEP_NAMADEPARTEMENT DEPNAME, PRD_KODEKATEGORIBARANG KAT, KAT_NAMAKATEGORI KATNAME,
//                   TLK_PRDCD PRDCD, PRD_DESKRIPSIPANJANG DESKRIPSI, PRD_UNIT || '/' || PRD_FRAC SATUAN,
//                   PRD_KODETAG TAG, TLK_KODESUPPLIER SUPCO, SUP_NAMASUPPLIER SUPNAME, PKM_PKMT PKMT,
//                   TLK_KETERANGANTOLAKAN
//              FROM TBMASTER_PERUSAHAAN,
//                   TBTR_TOLAKANPB,
//                   TBMASTER_PRODMAST,
//                   TBMASTER_DIVISI,
//                   TBMASTER_DEPARTEMENT,
//                   TBMASTER_KATEGORI,
//                   TBMASTER_SUPPLIER,
//                   TBMASTER_KKPKM
//             WHERE PRS_KODEIGR = :P_KODEIGR
//               AND PRS_KODEIGR = TLK_KODEIGR
//               AND TLK_KODEIGR = PRD_KODEIGR
//               AND TLK_PRDCD = PRD_PRDCD
//               AND PRD_KODEDIVISI = DIV_KODEDIVISI
//               AND PRD_KODEDIVISI = DEP_KODEDIVISI
//               AND PRD_KODEDEPARTEMENT = DEP_KODEDEPARTEMENT
//               AND PRD_KODEDEPARTEMENT = KAT_KODEDEPARTEMENT
//               AND PRD_KODEKATEGORIBARANG = KAT_KODEKATEGORI
//               AND TLK_KODEIGR = SUP_KODEIGR(+)
//               AND TLK_KODESUPPLIER = SUP_KODESUPPLIER(+)
//               AND PRD_KODEIGR = PKM_KODEIGR(+)
//               AND PRD_KODEDIVISI = PKM_KODEDIVISI(+)
//               AND PRD_KODEDEPARTEMENT = PKM_KODEDEPARTEMENT(+)
//               AND PRD_KODEKATEGORIBARANG = PKM_KODEKATEGORIBARANG(+)
//               AND PRD_PRDCD = PKM_PRDCD(+)
//               AND TRUNC (TLK_TGLPB) BETWEEN :P_TGL1 AND :P_TGL2
//               AND TLK_KODESUPPLIER BETWEEN NVL (:P_SUP1, '00000') AND NVL (:P_SUP2, 'ZZZZZ')
//               AND PRD_PRDCD BETWEEN NVL (:P_PLU1, '0000000') AND NVL (:P_PLU2, 'ZZZZZZZ')
//               AND ".$where."
//            ORDER BY PRD_PRDCD")

        $data = DB::connection(Session::get('connection'))->table('tbtr_tolakanpb')
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
            ->whereRaw("trunc(tlk_tglpb) between to_date('".$tgl1."','dd/mm/yyyy')and to_date('".$tgl2."','dd/mm/yyyy')")
            ->whereBetween('tlk_kodesupplier',[$sup1,$sup2])
            ->whereBetween('prd_prdcd',[$plu1,$plu2])
            ->whereRaw($where)
            ->orderBy('tlk_nopb')
            ->orderBy('tlk_kodesupplier')
            ->orderBy('tlk_prdcd')
            ->get();

//        dd($tolakan);

        $title = (__('LAPORAN DAFTAR TOLAKAN PB / SUPPLIER'));

        return view('BACKOFFICE.CetakTolakanPB-laporan-by-supplier', compact(['perusahaan','data','tgl1','tgl2','title']));

        $dompdf = new PDF();

        $pdf = PDF::loadview('BACKOFFICE.CetakTolakanPB-laporan-by-supplier', compact(['perusahaan','data','tgl1','tgl2','title']));

        error_reporting(E_ALL ^ E_DEPRECATED);

        $pdf->output();

        $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);
        $canvas = $dompdf->get_canvas();
        $canvas->page_text(509, 77.75, "{PAGE_NUM} dari {PAGE_COUNT}", null, 7, array(0, 0, 0));

        $dompdf = $pdf;

        // (Optional) Setup the paper size and orientation
        //        $dompdf->setPaper('a4', 'landscape');

        // Render the HTML as PDF

        return $dompdf->stream((__('Laporan Tolakan PB.pdf')));
    }
}
