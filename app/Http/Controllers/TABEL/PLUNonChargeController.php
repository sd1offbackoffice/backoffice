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

class PLUNonChargeController extends Controller
{
    public function index(){
        return view('TABEL.plunoncharge');
    }

    public function getData(){
        $data = DB::connection(Session::get('connection'))->table('tbmaster_plucharge')
            ->leftJoin('tbmaster_prodmast','prd_prdcd','=','non_prdcd')
            ->selectRaw("non_prdcd plu, nvl(prd_deskripsipanjang, 'PLU TIDAK TERDAFTAR DI MASTER BARANG') desk, case when prd_unit is null then ' ' else prd_unit || '/' || prd_frac end satuan")
            ->where('non_kodeigr','=',Session::get('kdigr'))
            ->orderBy('non_prdcd')
            ->get();

        return $data;
    }

    public function getLovPLU(){
        $data = DB::connection(Session::get('connection'))->table('tbmaster_prodmast')
            ->selectRaw("prd_prdcd plu, prd_deskripsipanjang desk, prd_unit || '/' || prd_frac satuan")
            ->where('prd_kodeigr','=',Session::get('kdigr'))
            ->whereRaw("substr(prd_prdcd,7,1) <> '0'")
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
        else if(in_array($data->tag, ['Z','X','N'])){
            return response()->json([
                'title' => 'Kode PLU '.$request->plu.' - Tag '.$data->tag.'!'
            ], 500);
        }
        else return response()->json($data, 200);
    }

    public function addPLU(Request $request){
        $temp = DB::connection(Session::get('connection'))->table('tbmaster_plucharge')
            ->where('non_kodeigr','=',Session::get('kdigr'))
            ->where('non_prdcd','=',$request->plu)
            ->first();

        if(!$temp){
            DB::connection(Session::get('connection'))->table('tbmaster_plucharge')
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
            DB::connection(Session::get('connection'))->table('tbmaster_plucharge')
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

    public function print(){
//        SELECT NON_PRDCD,
//PRD_DESKRIPSIPANJANG, PRD_UNIT || '/' || PRD_FRAC UNIT,
//PRS_NAMAPERUSAHAAN, PRS_NAMACABANG, PRS_NAMAWILAYAH FROM TBMASTER_PLUNONCHARGE, TBMASTER_PRODMAST, TBMASTER_PERUSAHAAN
//WHERE NON_KODEIGR = :P_KODEIGR
//        AND PRD_KODEIGR = NON_KODEIGR AND PRD_PRDCD = NON_PRDCD
//        AND PRS_KODEIGR = :P_KODEIGR
//ORDER BY NON_PRDCD

        $perusahaan = DB::connection(Session::get('connection'))->table("tbmaster_perusahaan")->first();

        $data = DB::connection(Session::get('connection'))->table('tbmaster_plucharge')
            ->join('tbmaster_prodmast',function($join){
                $join->on('prd_kodeigr','=','non_kodeigr');
                $join->on('prd_prdcd','=','non_prdcd');
            })
            ->selectRaw("NON_PRDCD, PRD_DESKRIPSIPANJANG, PRD_UNIT || '/' || PRD_FRAC UNIT")
            ->where('non_kodeigr','=',Session::get('kdigr'))
            ->orderBy('non_prdcd')
            ->get();

        return view('TABEL.plu-non-charge-pdf',compact(['perusahaan','data']));
    }
}
