<?php

namespace App\Http\Controllers\MASTER;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class hargaBeliController extends Controller
{
    public function index(){
        return view('MASTER.hargaBeli');
    }

    public function getProdmast(Request $request){
        $search = $request->value;
        $prodmast   = DB::table('tbmaster_prodmast')
            ->select('prd_prdcd','prd_deskripsipanjang')
            ->where('prd_prdcd','LIKE', '%'.$search.'%')
            ->orWhere('prd_deskripsipanjang','LIKE', '%'.$search.'%')
            ->where(DB::RAW('SUBSTR(prd_prdcd,7,1)'),'=','0')
            ->orderBy('prd_deskripsipanjang')
            ->limit(100)
            ->get();

        return Datatables::of($prodmast)->make(true);
    }

    public function lov_select(Request $request){
        $produk = DB::table('tbmaster_prodmast')
            ->select('*')
            ->where('prd_prdcd','=',$request->value)
            ->orderBy('prd_deskripsipanjang')
            ->first();

        if(!$produk){
            return 'not-found';
        }

        $tag = DB::table('tbmaster_tag')
            ->select('*')
            ->where('tag_kodeigr','=','22')
            ->where('tag_kodetag','=',$produk->prd_kodetag)
            ->first();

        $hargabeli = DB::table('tbmaster_hargabeli')
            ->select('*')
            ->where('hgb_prdcd','=',$request->value)
            ->first();

        $supplier = DB::table('tbmaster_supplier')
            ->select('*')
            ->where('sup_kodeigr','=','22')
            ->where('sup_kodesupplier','=',$hargabeli->hgb_kodesupplier)
            ->first();

        $hargabelibaru = DB::table('tbmaster_hargabelibaru')
            ->select('*')
            ->where('hgn_kodeigr','=','22')
            ->where('hgn_tipe','=',$hargabeli->hgb_tipe)
            ->where('hgn_prdcd','=',$hargabeli->hgb_prdcd)
            ->where('hgn_kodesupplier','=',$hargabeli->hgb_kodesupplier)
            ->where('hgn_jenishrgbeli','=',$hargabeli->hgb_jenishrgbeli)
            ->first();

        return compact(['produk','tag','hargabeli','supplier','hargabelibaru']);
    }

    public function lov_search(Request $request){
        if(is_numeric($request->value)){
            $result = DB::table('tbmaster_prodmast')
                ->select('prd_prdcd','prd_deskripsipanjang')
                ->where('prd_prdcd','like','%'.$request->value.'%')
                ->where(DB::RAW('SUBSTR(prd_prdcd,7,1)'),'=','0')
                ->orderBy('prd_deskripsipanjang')
                ->get();
        }


        else{
            $result = DB::table('tbmaster_prodmast')
                ->select('prd_prdcd','prd_deskripsipanjang')
                ->where('prd_deskripsipanjang','like','%'.$request->value.'%')
                ->where(DB::RAW('SUBSTR(prd_prdcd,7,1)'),'=','0')
                ->orderBy('prd_deskripsipanjang')
                ->get();
        }

        return $result;
    }


}
