<?php

namespace App\Http\Controllers\TABEL;

use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller; use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;
use PDF;
use Yajra\DataTables\DataTables;

class PLUNonRefundController extends Controller
{
    public function index(){
        return view('TABEL.plunonrefund');
    }

    public function getData(){
        $data = DB::connection(Session::get('connection'))->table('tbmaster_plunonrefund')
            ->leftJoin('tbmaster_prodmast','prd_prdcd','=','non_prdcd')
            ->selectRaw("non_prdcd plu, nvl(prd_deskripsipanjang, 'PLU TIDAK TERDAFTAR DI MASTER BARANG') desk, case when prd_unit is null then ' ' else prd_unit || '/' || prd_frac end satuan, non_create_by, to_char(non_create_dt, 'dd/mm/yyyy hh24:mi:ss') non_create_dt")
            ->where('non_kodeigr','=',Session::get('kdigr'))
            ->orderBy('non_prdcd')
            ->get();

        return $data;
    }

    public function getLovPLU(){
        $data = DB::connection(Session::get('connection'))->table('tbmaster_prodmast')
            ->selectRaw("prd_prdcd plu, prd_deskripsipanjang desk, prd_unit || '/' || prd_frac satuan")
            ->where('prd_kodeigr','=',Session::get('kdigr'))
            ->whereRaw("substr(prd_prdcd,7,1) = '0'")
            ->orderBy('prd_prdcd')
            ->get();

        return DataTables::of($data)->make(true);
    }

    public function getPLUDetail(Request $request){
        $data = DB::connection(Session::get('connection'))->select("SELECT prd_prdcd plu, prd_kodetag tag, prd_deskripsipanjang desk, prd_unit || '/' || prd_frac satuan
          FROM TBMASTER_PRODMAST, TBMASTER_BARCODE
         WHERE prd_kodeigr = ".Session::get('kdigr')."
           AND prd_prdcd = brc_prdcd(+)
           AND (prd_prdcd = TRIM ('".$request->plu."') OR brc_barcode = TRIM('".$request->plu."'))")[0];

        if(!$data){
            return response()->json([
                'title' => 'Tidak terdaftar di Master Barang!'
            ], 500);
        }
        else if(substr($request->plu,6,1) != '0'){
            return response()->json([
                'title' => 'Inputan satuan jual PLU salah!'
            ], 500);
        }
        else return response()->json($data, 200);
    }

    public function addPLU(Request $request){
        $temp = DB::connection(Session::get('connection'))->table('tbmaster_plunonrefund')
            ->where('non_kodeigr','=',Session::get('kdigr'))
            ->where('non_prdcd','=',$request->plu)
            ->first();

        if(!$temp){
            DB::connection(Session::get('connection'))->table('tbmaster_plunonrefund')
                ->insert([
                    'non_kodeigr' => Session::get('kdigr'),
                    'non_prdcd' => $request->plu,
                    'non_create_by' => Session::get('usid'),
                    'non_create_dt' => DB::RAW("SYSDATE")
                ]);

            return response()->json([
                'title' => 'PLU '.$request->plu.' berhasil ditambahkan!'
            ], 200);
        }
        else{
            return response()->json([
                'title' => 'Data sudah ada!'
            ], 500);
        }
    }

    public function deletePLU(Request $request){
        try{
            DB::connection(Session::get('connection'))->table('tbmaster_plunonrefund')
                ->where('non_kodeigr','=',Session::get('kdigr'))
                ->where('non_prdcd','=',$request->plu)
                ->delete();

            return response()->json([
                'title' => 'PLU '.$request->plu.' berhasil dihapus!'
            ], 200);
        }
        catch(QueryException $e){
            return response()->json([
                'title' => 'PLU '.$request->plu.' gagal dihapus!'
            ], 500);
        }
    }

    public function getLovDivisi(){
        $data = DB::connection(Session::get('connection'))->table('tbmaster_divisi')
            ->selectRaw("div_kodedivisi kode, div_namadivisi nama, div_singkatannamadivisi singkatan")
            ->where('div_kodeigr','=',Session::get('kdigr'))
            ->orderBy('div_kodedivisi')
            ->get();

        return DataTables::of($data)->make(true);
    }

    public function getLovDepartement(Request $request){
        $data = DB::connection(Session::get('connection'))->table('tbmaster_departement')
            ->selectRaw("dep_kodedepartement kode, dep_namadepartement nama, dep_singkatandepartement singkatan")
            ->where('dep_kodeigr','=',Session::get('kdigr'))
            ->where('dep_kodedivisi','=',$request->div)
            ->orderBy('dep_kodedepartement')
            ->get();

        return DataTables::of($data)->make(true);
    }

    public function getLovKategori(Request $request){
        $data = DB::connection(Session::get('connection'))->table('tbmaster_kategori')
            ->selectRaw("kat_kodekategori kode, kat_namakategori nama, kat_singkatan singkatan")
            ->where('kat_kodeigr','=',Session::get('kdigr'))
            ->where('kat_kodedepartement','=',$request->dep)
            ->orderBy('kat_kodekategori')
            ->get();

        return DataTables::of($data)->make(true);
    }

    public function addBatch(Request $request){
        if($request->div != '' && $request->dep != '' && $request->div != ''){
            $data = DB::connection(Session::get('connection'))->table('tbmaster_prodmast')
                ->select('prd_prdcd')
                ->where('prd_kodeigr','=',Session::get('kdigr'))
                ->whereRaw("substr(prd_prdcd,7,1) = '0'")
                ->where('prd_kodedivisi','=',$request->div)
                ->where('prd_kodedepartement','=',$request->dep)
                ->where('prd_kodekategoribarang','=',$request->kat)
                ->get();

            $title = 'PLU pada Divisi '.$request->div.' Departement '.$request->dep.' Kategori '.$request->kat.' berhasil ditambahkan!';
        }
        else if($request->div != '' && $request->dep != ''){
            $data = DB::connection(Session::get('connection'))->table('tbmaster_prodmast')
                ->select('prd_prdcd')
                ->where('prd_kodeigr','=',Session::get('kdigr'))
                ->whereRaw("substr(prd_prdcd,7,1) = '0'")
                ->where('prd_kodedivisi','=',$request->div)
                ->where('prd_kodedepartement','=',$request->dep)
                ->get();

            $title = 'PLU pada Divisi '.$request->div.' Departement '.$request->dep.' berhasil ditambahkan!';
        }
        else if($request->div != ''){
            $data = DB::connection(Session::get('connection'))->table('tbmaster_prodmast')
                ->select('prd_prdcd')
                ->where('prd_kodeigr','=',Session::get('kdigr'))
                ->whereRaw("substr(prd_prdcd,7,1) = '0'")
                ->where('prd_kodedivisi','=',$request->div)
                ->where('prd_kodedepartement','=',$request->dep)
                ->get();

            $title = 'PLU pada Divisi '.$request->div.' berhasil ditambahkan!';
        }

        foreach($data as $d){
            $temp = DB::connection(Session::get('connection'))->table('tbmaster_plunonrefund')
                ->where('non_kodeigr','=',Session::get('kdigr'))
                ->where('non_prdcd','=',$d->prd_prdcd)
                ->first();

            if(!$temp){
                DB::connection(Session::get('connection'))->table('tbmaster_plunonrefund')
                    ->insert([
                        'non_kodeigr' => Session::get('kdigr'),
                        'non_prdcd' => $d->prd_prdcd,
                        'non_create_by' => Session::get('usid'),
                        'non_create_dt' => DB::RAW("SYSDATE")
                    ]);
            }
        }

        return response()->json([
            'title' => $title
        ], 200);
    }

    public function deleteBatch(Request $request){
        if($request->div != '' && $request->dep != '' && $request->div != ''){
            $data = DB::connection(Session::get('connection'))->table('tbmaster_prodmast')
                ->select('prd_prdcd')
                ->where('prd_kodeigr','=',Session::get('kdigr'))
                ->whereRaw("substr(prd_prdcd,7,1) = '0'")
                ->where('prd_kodedivisi','=',$request->div)
                ->where('prd_kodedepartement','=',$request->dep)
                ->where('prd_kodekategoribarang','=',$request->kat)
                ->get();

            $title = 'PLU pada Divisi '.$request->div.' Departement '.$request->dep.' Kategori '.$request->kat.' berhasil dihapus!';
        }
        else if($request->div != '' && $request->dep != ''){
            $data = DB::connection(Session::get('connection'))->table('tbmaster_prodmast')
                ->select('prd_prdcd')
                ->where('prd_kodeigr','=',Session::get('kdigr'))
                ->whereRaw("substr(prd_prdcd,7,1) = '0'")
                ->where('prd_kodedivisi','=',$request->div)
                ->where('prd_kodedepartement','=',$request->dep)
                ->get();

            $title = 'PLU pada Divisi '.$request->div.' Departement '.$request->dep.' berhasil dihapus!';
        }
        else if($request->div != ''){
            $data = DB::connection(Session::get('connection'))->table('tbmaster_prodmast')
                ->select('prd_prdcd')
                ->where('prd_kodeigr','=',Session::get('kdigr'))
                ->whereRaw("substr(prd_prdcd,7,1) = '0'")
                ->where('prd_kodedivisi','=',$request->div)
                ->where('prd_kodedepartement','=',$request->dep)
                ->get();

            $title = 'PLU pada Divisi '.$request->div.' berhasil dihapus!';
        }

        foreach($data as $d){
            DB::connection(Session::get('connection'))->table('tbmaster_plunonrefund')
                ->where('non_kodeigr','=',Session::get('kdigr'))
                ->where('non_prdcd','=',$d->prd_prdcd)
                ->delete();
        }

        return response()->json([
            'title' => $title
        ], 200);
    }

    public function print(){
        $perusahaan = DB::connection(Session::get('connection'))
            ->table("tbmaster_perusahaan")
            ->first();

        $data = DB::connection(Session::get('connection'))->table('tbmaster_plunonrefund')
            ->leftJoin('tbmaster_prodmast','prd_prdcd','=','non_prdcd')
            ->selectRaw("non_prdcd plu, nvl(prd_deskripsipanjang, 'PLU TIDAK TERDAFTAR DI MASTER BARANG') desk, case when prd_unit is null then ' ' else prd_unit || '/' || prd_frac end satuan")
            ->where('non_kodeigr','=',Session::get('kdigr'))
            ->orderBy('non_prdcd')
            ->get();

        return view('TABEL.plu-non-refund-pdf',compact(['perusahaan','data']));
    }
}
