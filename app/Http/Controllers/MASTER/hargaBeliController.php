<?php

namespace App\Http\Controllers\MASTER;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class hargaBeliController extends Controller
{
    //

    public function index(){
        $produk = DB::table('tbmaster_prodmast')
            ->select('prd_prdcd','prd_deskripsipanjang')
            ->where(DB::RAW('SUBSTR(prd_prdcd,7,1)'),'=','0')
            ->orderBy('prd_deskripsipanjang')
            ->limit(1000)
            ->get();

        return view('MASTER.hargaBeli')->with(compact('produk'));
    }

    public function lov_select(Request $request){
        $produk = DB::table('tbmaster_prodmast')
            ->select('*')
            ->where('prd_prdcd','=',$request->value)
            ->orderBy('prd_deskripsipanjang')
            ->first();

        $tag = DB::table('tbmaster_tag')
            ->select('*')
            ->where('tag_kodeigr','=','22')
            ->where('tag_kodetag','=',$produk->prd_kodetag)
            ->first();

        $hargabeli = DB::table('tbmaster_hargabeli')
//            ->select('hgb_tglberlaku01','hgb_hrgbeli','hgb_ppnbm','hgb_ppnbotol','hgb_flagdisc01','hgb_rphdisc01','hgb_tglmulaidisc02','hgb_tglmulaidisc02ii','hgb_tglmulaidisc02iii','hgb_tglmulaibonus01','hgb_tglakhirbonus01','hgb_qtymulai1bonus01','hgb_jenisbonus','hgb_kodesupplier','hgb_tipe')
                ->select('*')
            ->where('hgb_prdcd','=',$request->value)
            ->first();

        $supplier = DB::table('tbmaster_supplier')
            ->select('*')
            ->where('sup_kodeigr','=','22')
            ->where('sup_kodesupplier','=',$hargabeli->hgb_kodesupplier)
            ->first();

        $hargabelibaru = DB::table('tbmaster_hargabelibaru')
//            ->select('hgn_tglberlaku01','hgn_hrgbeli','hgn_ppnbm','hgn_ppnbotol','hgn_flagdisc01','hgn_rphdisc01','hgn_tglmulaidisc02','hgn_tglmulaidisc02ii','hgn_tglmulaidisc02iii','hgn_tglmulaibonus01','hgn_tglakhirbonus01','hgn_qtymulai1bonus01','hgn_jenisbonus','hgn_qty1bonus01')
            ->select('*')
            ->where('hgn_kodeigr','=','22')
            ->where('hgn_tipe','=',$hargabeli->hgb_tipe)
//            ->where('hgn_prdcd','=',$hargabeli->hgb_prdcd)
//            ->where('hgn_kodesupplier','=',$hargabeli->hgb_kodesupplier)
//            ->where('hgn_jenishrgbeli','=',$hargabeli->hgb_jenishrgbeli)
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
