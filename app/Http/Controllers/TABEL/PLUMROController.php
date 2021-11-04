<?php

namespace App\Http\Controllers\TABEL;

use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;
use PDF;
use Yajra\DataTables\DataTables;

class PLUMROController extends Controller
{
    public function index(){
        return view('TABEL.plu-mro');
    }

    public function getData(){
        $data = DB::connection($_SESSION['connection'])->select("SELECT MRO_PRDCD PLU, SUBSTR(PRD_DESKRIPSIPANJANG,1,60) DESKRIPSI, PRD_UNIT||'/'||PRD_FRAC SATUAN
				FROM TBMASTER_PRODMAST, TBTABEL_PLUMRO
				WHERE PRD_PRDCD(+) = MRO_PRDCD
				ORDER BY MRO_PRDCD");

        return DataTables::of($data)->make(true);
    }

    public function getDetailAndInsert(Request $request){
        $plu = substr('0000000'.$request->plu,-7);

        if($plu == '0000000'){
            return response()->json([
                'message' => "PLU tidak boleh kosong!",
                'plu' => $plu
            ], 500);
        }

        if(substr($plu, -1) != '0'){
            return response()->json([
                'message' => "PLU harus satuan jual '0'!",
                'plu' => $plu
            ], 500);
        }

        $temp = DB::connection($_SESSION['connection'])->table('tbmaster_prodmast')
            ->select('prd_kodetag')
            ->where('prd_kodeigr','=',$_SESSION['kdigr'])
            ->where('prd_prdcd','=',$plu)
            ->first();

        if(!$temp){
            return response()->json([
                'message' => "PLU tidak terdaftar!",
                'plu' => $plu
            ], 500);
        }
        else{
            if($temp->prd_kodetag == 'X'){
                return response()->json([
                    'message' => "PLU discontinue!",
                    'plu' => $plu
                ], 500);
            }
        }

        $data = DB::connection($_SESSION['connection'])->selectOne("SELECT PRD_KODEDIVISI, DIV_NAMADIVISI, PRD_KODEDEPARTEMENT, DEP_NAMADEPARTEMENT, PRD_KODEKATEGORIBARANG, KAT_NAMAKATEGORI,
                        SUBSTR(PRD_DESKRIPSIPANJANG,1,60) DESKRIPSI, PRD_UNIT||'/'||PRD_FRAC SATUAN
                        FROM TBMASTER_PRODMAST, TBMASTER_DIVISI,TBMASTER_DEPARTEMENT, TBMASTER_KATEGORI
                        WHERE PRD_KODEIGR = '".$_SESSION['kdigr']."'
                        AND PRD_KODEDIVISI = DIV_KODEDIVISI
                        AND PRD_KODEDEPARTEMENT = DEP_KODEDEPARTEMENT
                        AND PRD_KODEDEPARTEMENT = KAT_KODEDEPARTEMENT
                        AND PRD_KODEKATEGORIBARANG = KAT_KODEKATEGORI
                        AND PRD_PRDCD = '".$plu."'");

        $temp = DB::connection($_SESSION['connection'])->table('tbtabel_plumro')
            ->where('mro_kodeigr','=',$_SESSION['kdigr'])
            ->where('mro_prdcd','=',$plu)
            ->first();

        if($temp){
            return response()->json([
                'message' => "PLU sudah ada!",
                'plu' => $plu,
                'data' => $data
            ], 500);
        }
        else{
            try{
                DB::beginTransaction();

                DB::connection($_SESSION['connection'])->table('tbtabel_plumro')
                    ->insert([
                        'mro_kodeigr' => $_SESSION['kdigr'],
                        'mro_kodedivisi' => $data->prd_kodedivisi,
                        'mro_kodedepartement' => $data->prd_kodedepartement,
                        'mro_kodekategoribrg' => $data->prd_kodekategoribarang,
                        'mro_prdcd' => $plu,
                        'mro_create_by' => $_SESSION['usid'],
                        'mro_create_dt' => DB::RAW("SYSDATE")
                    ]);

                DB::commit();

                return response()->json([
                    'message' => "Berhasil menambahkan data!",
                    'plu' => $plu,
                    'data' => $data
                ], 200);
            }
            catch (QueryException $e){
                DB::rollBack();

                return response()->json([
                    'message' => "Gagal menambahkan data!",
                    'plu' => $plu
                ], 500);
            }
        }

    }

    public function getLovPLU(Request $request){
        $search = $request->plu;

        if($search == ''){
            $produk = DB::connection($_SESSION['connection'])->table(DB::RAW("tbmaster_prodmast"))
                ->select('prd_deskripsipanjang','prd_prdcd')
                ->where('prd_kodeigr',$_SESSION['kdigr'])
                ->whereRaw("substr(prd_prdcd,7,1) = '0'")
                ->orderBy('prd_prdcd')
                ->limit(100)
                ->get();
        }
        else if(is_numeric($search)){
            $produk = DB::connection($_SESSION['connection'])->table(DB::RAW("tbmaster_prodmast"))
                ->select('prd_deskripsipanjang','prd_prdcd')
                ->where('prd_kodeigr',$_SESSION['kdigr'])
                ->whereRaw("substr(prd_prdcd,7,1) = '0'")
                ->where('prd_prdcd','like',DB::RAW("'%".$search."%'"))
                ->orderBy('prd_prdcd')
                ->get();
        }
        else{
            $produk = DB::connection($_SESSION['connection'])->table(DB::RAW("tbmaster_prodmast"))
                ->select('prd_deskripsipanjang','prd_prdcd')
                ->where('prd_kodeigr',$_SESSION['kdigr'])
                ->whereRaw("substr(prd_prdcd,7,1) = '0'")
                ->where('prd_deskripsipanjang','like',DB::RAW("'%".$search."%'"))
                ->orderBy('prd_prdcd')
                ->get();
        }

        return DataTables::of($produk)->make(true);
    }

    public function deleteData(Request $request){
        $plu = $request->plu;

        try{
            DB::beginTransaction();

            DB::connection($_SESSION['connection'])->table('tbtabel_plumro')
                ->where('mro_kodeigr','=',$_SESSION['kdigr'])
                ->where('mro_prdcd','=',$plu)
                ->delete();

            DB::commit();

            return response()->json([
                'message' => "Berhasil menghapus data!",
            ], 200);
        }
        catch (QueryException $e){
            DB::rollBack();

            return response()->json([
                'message' => "Gagal menghapus data!",
            ], 500);
        }
    }

    public function print(Request $request){
        $perusahaan = DB::connection($_SESSION['connection'])->table("tbmaster_perusahaan")->first();

        if($request->orderBy == 'plu')
            $orderBy = 'ORDER BY MRO_PRDCD ASC';
        else $orderBy = 'ORDER BY PRD_DESC ASC';

        $data = DB::connection($_SESSION['connection'])->select("SELECT DISTINCT MRO_PRDCD, PRD_DESC, PRD_KODETAG, SATUAN,
                   HRG_1, HRG_D, HRG_C, HRG_B, HRG_E, HRG_A, ST_SALDOAKHIR, ' ' KET
                FROM TBTABEL_PLUMRO, (SELECT ST_PRDCD, ST_SALDOAKHIR FROM TBMASTER_STOCK WHERE ST_LOKASI=01 ),
                (
                SELECT SUBSTR(PRD_PRDCD,1,6)||'0' PRDCD, PRD_DESC, PRD_KODETAG, SATUAN, SUM(HRG_1) HRG_1,
                       SUM(HRG_D)HRG_D, SUM(HRG_C) HRG_C, SUM(HRG_B) HRG_B, SUM(HRG_E) HRG_E, SUM(HRG_A) HRG_A
                FROM(
                     SELECT PRD_PRDCD, PRD_DESC, PRD_KODETAG,  PRD_KODESATUANJUAL2||'/'||PRD_ISISATUANJUAL2 SATUAN,
                           CASE WHEN SUBSTR(PRD_PRDCD,-1,1)='1' THEN HARGA ELSE 0 END HRG_1,
                           CASE WHEN SUBSTR(PRD_PRDCD,-1,1) IN('2','3') THEN HARGA*PRD_MINJUAL ELSE 0 END HRG_D,
                           CASE WHEN SUBSTR(PRD_PRDCD,-1,1) IN('2','3') THEN HARGA ELSE 0 END HRG_C,
                           CASE WHEN SUBSTR(PRD_PRDCD,-1,1) IN('2','3') THEN PRD_MINJUAL ELSE 0 END HRG_B,
                           CASE WHEN SUBSTR(PRD_PRDCD,-1,1)='0' THEN HARGA/PRD_FRAC ELSE 0 END HRG_E,
                           CASE WHEN SUBSTR(PRD_PRDCD,-1,1)='0' THEN HARGA ELSE 0 END HRG_A
                     FROM (SELECT PRD_PRDCD, PRD_FRAC, PRD_UNIT, SUBSTR(PRD_DESKRIPSIPANJANG,1,50) PRD_DESC, PRD_KODETAG, PRD_HRGJUAL, PRD_MINJUAL,
                                 PRD_KODESATUANJUAL2, PRD_ISISATUANJUAL2, PROMO, HRGPROMO, CASE WHEN PROMO='Y' THEN HRGPROMO ELSE PRD_HRGJUAL END HARGA
                          FROM TBMASTER_PRODMAST,( SELECT 'Y' PROMO, PRMD_PRDCD, PRMD_HRGJUAL HRGPROMO
                                                   FROM TBTR_PROMOMD, TBMASTER_PRODMAST
                                                   WHERE PRMD_PRDCD = PRD_PRDCD
                                                 )
                          WHERE PRMD_PRDCD(+) = PRD_PRDCD
                            AND NVL(PRD_KODETAG,'123') NOT IN ('X','Z')
                         )
                    )
                GROUP BY SUBSTR(PRD_PRDCD,1,6), PRD_DESC, PRD_KODETAG, SATUAN
                )
                WHERE MRO_KODEIGR = '".$_SESSION['kdigr']."'
                AND PRDCD(+) = MRO_PRDCD
                AND ST_PRDCD(+) = MRO_PRDCD
                ".$orderBy);

//        dd($data);

        $dompdf = new PDF();

        $pdf = PDF::loadview('TABEL.plu-mro-pdf',compact(['perusahaan','data']));

        error_reporting(E_ALL ^ E_DEPRECATED);

        $pdf->output();
        $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);

        $canvas = $dompdf ->get_canvas();
        $canvas->page_text(507, 77.75, "{PAGE_NUM} dari {PAGE_COUNT}", null, 7, array(0, 0, 0));

        $dompdf = $pdf;

        return $dompdf->stream('Daftar Harga Jual Barang per Tanggal '.date("d-m-Y").'.pdf');
    }

    public function getLovDivisi(){
        $data = DB::connection($_SESSION['connection'])->table('tbmaster_divisi')
            ->selectRaw("div_kodedivisi kode, div_namadivisi nama, div_singkatannamadivisi singkatan")
            ->where('div_kodeigr','=',$_SESSION['kdigr'])
            ->orderBy('div_kodedivisi')
            ->get();

        return DataTables::of($data)->make(true);
    }

    public function getLovDepartement(Request $request){
        $data = DB::connection($_SESSION['connection'])->table('tbmaster_departement')
            ->selectRaw("dep_kodedepartement kode, dep_namadepartement nama, dep_singkatandepartement singkatan")
            ->where('dep_kodeigr','=',$_SESSION['kdigr'])
            ->where('dep_kodedivisi','=',$request->div)
            ->orderBy('dep_kodedepartement')
            ->get();

        return DataTables::of($data)->make(true);
    }

    public function getLovKategori(Request $request){
        $data = DB::connection($_SESSION['connection'])->table('tbmaster_kategori')
            ->selectRaw("kat_kodekategori kode, kat_namakategori nama, kat_singkatan singkatan")
            ->where('kat_kodeigr','=',$_SESSION['kdigr'])
            ->where('kat_kodedepartement','=',$request->dep)
            ->orderBy('kat_kodekategori')
            ->get();

        return DataTables::of($data)->make(true);
    }
}
