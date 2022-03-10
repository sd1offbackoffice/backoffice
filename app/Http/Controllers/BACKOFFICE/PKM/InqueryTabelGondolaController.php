<?php

namespace App\Http\Controllers\BACKOFFICE\PKM;

use App\Http\Controllers\Auth\loginController;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller; use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Mockery\Exception;
use PDF;
use Yajra\DataTables\DataTables;

class InqueryTabelGondolaController extends Controller
{
    public function index(){
        return view('BACKOFFICE.PKM.inquery-tabel-gondola');
    }

    public function getLovPLU(Request $request){
        $search = $request->plu;

        if($search == ''){
            $produk = DB::connection(Session::get('connection'))->table('tbmaster_prodmast')
                ->join('tbtr_gondola',function($join){
                    $join->on('gdl_kodeigr','=','prd_kodeigr');
                    $join->on('gdl_prdcd','=','prd_prdcd');
                })
                ->selectRaw("prd_prdcd,prd_deskripsipanjang, prd_unit || '/' || prd_frac satuan")
                ->where('prd_kodeigr',Session::get('kdigr'))
                ->whereRaw("TRUNC(SYSDATE) BETWEEN TRUNC(GDL_TGLAWAL) AND TRUNC(GDL_TGLAKHIR)")
                ->where('prd_prdcd','like',DB::connection(Session::get('connection'))->raw("'%".$search."%'"))
                ->orderBy('prd_prdcd')
                ->limit(100)
                ->get();
        }
        else if(is_numeric($search)){
            $produk = DB::connection(Session::get('connection'))->table('tbmaster_prodmast')
                ->join('tbtr_gondola',function($join){
                    $join->on('gdl_kodeigr','=','prd_kodeigr');
                    $join->on('gdl_prdcd','=','prd_prdcd');
                })
                ->selectRaw("prd_prdcd,prd_deskripsipanjang, prd_unit || '/' || prd_frac satuan")
                ->where('prd_kodeigr',Session::get('kdigr'))
                ->whereRaw("TRUNC(SYSDATE) BETWEEN TRUNC(GDL_TGLAWAL) AND TRUNC(GDL_TGLAKHIR)")
                ->where('prd_prdcd','like',DB::connection(Session::get('connection'))->raw("'%".$search."%'"))
                ->orderBy('prd_prdcd')
                ->get();
        }
        else{
            $produk = DB::connection(Session::get('connection'))->table('tbmaster_prodmast')
                ->join('tbtr_gondola',function($join){
                    $join->on('gdl_kodeigr','=','prd_kodeigr');
                    $join->on('gdl_prdcd','=','prd_prdcd');
                })
                ->selectRaw("prd_prdcd,prd_deskripsipanjang, prd_unit || '/' || prd_frac satuan")
                ->where('prd_kodeigr',Session::get('kdigr'))
                ->whereRaw("TRUNC(SYSDATE) BETWEEN TRUNC(GDL_TGLAWAL) AND TRUNC(GDL_TGLAKHIR)")
                ->where('prd_deskripsipanjang','like',DB::connection(Session::get('connection'))->raw("'%".$search."%'"))
                ->orderBy('prd_prdcd')
                ->get();
        }

        return DataTables::of($produk)->make(true);
    }

    public function getData(){
        $data = DB::connection(Session::get('connection'))->table('tbtr_gondola')
            ->join('tbmaster_prodmast',function($join){
                $join->on('prd_kodeigr','=','gdl_kodeigr');
                $join->on('prd_prdcd','=','gdl_prdcd');
            })
            ->leftJoin('tbmaster_hargabeli',function($join){
                $join->on('hgb_kodeigr','=','gdl_kodeigr');
                $join->on('hgb_prdcd','=','gdl_prdcd');
            })
            ->leftJoin('tbmaster_supplier',function($join){
                $join->on('sup_kodeigr','=','gdl_kodeigr');
                $join->on('sup_kodesupplier','=','hgb_kodesupplier');
            })
            ->selectRaw("prd_prdcd plu,prd_deskripsipanjang deskripsi, prd_unit || '/' || prd_frac satuan,
                sup_kodesupplier kodesupplier, sup_namasupplier namasupplier,
                to_char(gdl_tglawal, 'dd/mm/yyyy') tglawal, to_char(gdl_tglakhir, 'dd/mm/yyyy') tglakhir, gdl_qty qty
            ")
            ->where('prd_kodeigr',Session::get('kdigr'))
            ->whereRaw("TRUNC(SYSDATE) BETWEEN TRUNC(GDL_TGLAWAL) AND TRUNC(GDL_TGLAKHIR)")
            ->orderBy('prd_prdcd')
            ->get();

        return response()->json($data);
    }

    public function getDataPLU(Request $request){
        $plu = $request->plu;
        $alert = [];

        if(!$plu){
            return response()->json([
                'message' => 'Kode barang tidak boleh kosong!'
            ], 500);
        }

        if(substr($plu,-1) != '0'){
            return response()->json([
                'message' => 'PLU harus satuan jual besar!'
            ], 500);
        }

        $prd = DB::connection(Session::get('connection'))
            ->table('tbmaster_prodmast')
            ->selectRaw("prd_prdcd,prd_deskripsipanjang, prd_unit || '/' || prd_frac satuan")
            ->where('prd_kodeigr','=',Session::get('kdigr'))
            ->where('prd_prdcd','=',$plu)
            ->first();

        if(!$prd){
            return response()->json([
                'message' => 'PLU '.$plu.' - '.Session::get('kdigr').' tidak terdaftar di Master Barang!'
            ], 500);
        }

        $hgb = DB::connection(Session::get('connection'))
            ->table('tbmaster_hargabeli')
            ->select('hgb_kodesupplier')
            ->where('hgb_kodeigr','=',Session::get('kdigr'))
            ->where('hgb_prdcd','=',$plu)
            ->first();

        if(!$hgb){
            $alert[] = 'Produk ini tidak mempunyai supplier!';
        }

        $supplier = DB::connection(Session::get('connection'))
            ->table('tbmaster_supplier')
            ->select('sup_namasupplier')
            ->where('sup_kodeigr','=',Session::get('kdigr'))
            ->where('sup_kodesupplier','=',$hgb->hgb_kodesupplier)
            ->first();

        if(!$supplier){
            $alert[] = 'Supplier tidak terdaftar!';
        }

        $gondola = DB::connection(Session::get('connection'))
            ->table('tbtr_gondola')
            ->selectRaw("to_char(gdl_tglawal, 'dd/mm/yyyy') gdl_tglawal, to_char(gdl_tglakhir, 'dd/mm/yyyy') gdl_tglakhir, gdl_qty")
            ->where('gdl_kodeigr','=',Session::get('kdigr'))
            ->where('gdl_prdcd','=',$plu)
            ->whereRaw("TRUNC(SYSDATE) BETWEEN TRUNC(GDL_TGLAWAL) AND TRUNC(GDL_TGLAKHIR)")
            ->first();

        $result = new \stdClass();

        $result->plu = $prd->prd_prdcd;
        $result->deskripsi = $prd->prd_deskripsipanjang;
        $result->satuan = $prd->satuan;

        if(!$gondola){
            $result->kodesupplier = '';
            $result->namasupplier = '';
            $result->tglmulai = '';
            $result->tglakhir = '';
            $result->qty = 0;
        }
        else{
            $result->kodesupplier = $hgb->hgb_kodesupplier;
            $result->namasupplier = $supplier->sup_namasupplier;
            $result->tglawal = $gondola->gdl_tglawal;
            $result->tglakhir = $gondola->gdl_tglakhir;
            $result->qty = $gondola->gdl_qty;
        }

        return response()->json(compact(['result','alert']), 200);

    }
}
