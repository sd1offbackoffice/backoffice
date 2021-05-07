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

class PLUNonChargeController extends Controller
{
    public function index(){
        return view('TABEL.plunoncharge');
    }

    public function getData(){
        $data = DB::table('tbmaster_plucharge')
            ->leftJoin('tbmaster_prodmast','prd_prdcd','=','non_prdcd')
            ->selectRaw("non_prdcd plu, nvl(prd_deskripsipanjang, 'PLU TIDAK TERDAFTAR DI MASTER BARANG') desk, case when prd_unit is null then ' ' else prd_unit || '/' || prd_frac end satuan")
            ->where('non_kodeigr','=',$_SESSION['kdigr'])
            ->orderBy('non_prdcd')
            ->get();

        return $data;
    }

    public function getLovPLU(){
        $data = DB::table('tbmaster_prodmast')
            ->selectRaw("prd_prdcd plu, prd_deskripsipanjang desk, prd_unit || '/' || prd_frac satuan")
            ->where('prd_kodeigr','=',$_SESSION['kdigr'])
            ->whereRaw("substr(prd_prdcd,7,1) <> '0'")
            ->orderBy('prd_prdcd')
            ->get();

        return DataTables::of($data)->make(true);
    }

    public function getPLUDetail(Request $request){
        $data = DB::select("SELECT prd_prdcd plu, prd_kodetag tag, prd_deskripsipanjang desk, prd_unit || '/' || prd_frac satuan
          FROM TBMASTER_PRODMAST, TBMASTER_BARCODE
         WHERE prd_kodeigr = ".$_SESSION['kdigr']."
           AND prd_prdcd = brc_prdcd(+)
           AND (prd_prdcd = TRIM ('".$request->plu."') OR brc_barcode = TRIM('".$request->plu."'))")[0];

        if(!$data){
            return response()->json([
                'title' => 'Tidak terdaftar di Master Barang!'
            ], 500);
        }
        else if(in_array($data->tag, ['Z','X','N'])){
            return response()->json([
                'title' => 'Kode PLU '.$request->plu.' - Tag '.$data->tag.'!'
            ], 500);
        }
        else return response()->json($data, 200);
    }

    public function addPLU(Request $request){
        $temp = DB::table('tbmaster_plucharge')
            ->where('non_kodeigr','=',$_SESSION['kdigr'])
            ->where('non_prdcd','=',$request->plu)
            ->first();

        if(!$temp){
            DB::table('tbmaster_plucharge')
                ->insert([
                    'non_kodeigr' => $_SESSION['kdigr'],
                    'non_prdcd' => $request->plu,
                    'non_create_by' => $_SESSION['usid'],
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
            DB::table('tbmaster_plucharge')
                ->where('non_kodeigr','=',$_SESSION['kdigr'])
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
}
