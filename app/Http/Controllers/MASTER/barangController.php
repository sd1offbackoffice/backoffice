<?php

namespace App\Http\Controllers\MASTER;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;


class barangController extends Controller
{
    public function index()
    {
        $plu = DB::table('tbmaster_prodmast')
            ->select('prd_prdcd','prd_deskripsipanjang','prd_plusupplier','prd_deskripsipendek')
            ->where(DB::RAW('SUBSTR(prd_prdcd,7,1)'),'=','0')
            ->orderBy('prd_prdcd')
            ->limit(1000)
            ->get();

        return view('MASTER.barang')->with(compact('plu'));
    }

    public function showBarang (Request $request)
    {
        $kodeplu = $request->kodeplu;

        $result = DB::table('tbmaster_prodmast')
            ->join('tbmaster_divisi', function ($join) {
                $join->on('div_kodedivisi', '=', 'prd_kodedivisi')
                    ->on('div_kodeigr', '=', 'prd_kodeigr');
            })
            ->join('tbmaster_departement', function ($join) {
                $join->on('DEP_KodeDepartement', '=', 'PRD_KodeDepartement')
                    ->on('dep_kodedivisi', '=', 'DIV_KODEDIVISI')
                    ->on('DEP_KODEIGR', '=', 'PRD_KODEIGR');
            })
            ->join('tbmaster_kategori', function ($join) {
                $join->on('KAT_KodeKategori', '=', 'PRD_KodeKategoriBarang')
                    ->on('KAT_KodeIGR', '=', 'PRD_KODEIGR')
                    ->on('KAT_KODEDEPARTEMENT', '=', 'DEP_KODEDEPARTEMENT');
            })
            ->join('tbmaster_tag', function ($join) {
                $join->on('TAG_KodeTag', '=', 'PRD_KodeTag')
                    ->on('TAG_KodeIGR', '=', 'PRD_KodeIGR');
            })
            ->join('tbTR_PromoMD', function ($join) {
                $join->on('PRMD_PRDCD', '=', 'PRD_PRDCD')
                    ->on('PRMD_KODEIGR', '=', 'PRD_KodeIGR');
            })
//            ->leftjoin('tbmaster_barangexport', function ($join) {
//                $join->on('EXP_PRDCD','=','substr(PRD_PRDCD,1,6)')
//                ->on('EXP_KODEIGR','=','PRD_KodeIGR');
//            })
//            ->leftJoin('TBMASTER_MINIMUMORDER', function ($join) {
//                $join->On(DB::raw('SUBSTR (MIN_PRDCD, 1, 6)'), '=', DB::raw('SUBSTR (PRD_PRDCD, 1, 6)'))
//                    ->On('MIN_KODEIGR', '=', 'PRD_KODEIGR')
//                    ->On('KAT_KODEDEPARTEMENT', '=', 'DEP_KODEDEPARTEMENT');
//            })
            ->leftJoin('TBMASTER_BARCODE', function ($join) {
                $join->on('BRC_PRDCD', '=', 'PRD_PRDCD');
            })
            ->select('*')
            ->where('prd_prdcd','=',$kodeplu)
            ->distinct()
            ->get()->toArray();

        $date = date("ymd");

        if($date >= $result[0]->prmd_tglawal && $date <= $result[0]->prmd_tglakhir){
            $tglpromo = $result[0]->prmd_tglawal.'S/D'.$result[0]->prmd_tglakhir;
        }if($result[0]->prmd_jamawal==0) {
            $jampromo = ' ' . 'S/D' . ' ';
        }else{
            $jampromo = $result[0]->prmd_jamawal . 'S/D' . $result[0]->prmd_jamakhir;
        }
        $hrgpromo = $result[0]->prmd_hrgjual;

        $temp = DB::Table('tbmaster_barcode')
            ->select('brc_barcode')
            ->where('brc_prdcd','=',$kodeplu)
            ->get();

        if(!$temp){
            $barcode = '$barcode1', '$barcode2';
        }

        return response()->json(['kodeplu'=>$kodeplu, 'data'=>$result]);
        }

        public function helpSelect(Request $request){
            $result = DB::table('tbmaster_prodmast')
                ->select('*')
                ->where('prd_prdcd',$request->value)
                ->first();

            if(!$result){
                return 'not-found';
            }
                return response()->json($result);
        }
}
