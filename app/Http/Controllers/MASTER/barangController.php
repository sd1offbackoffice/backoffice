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
            ->where(DB::RAW('substr(prd_prdcd,7,1)'),'=','0')
            ->orderBy('prd_prdcd')
            ->limit(100)
            ->get();

        $pluIdm = DB::table('tbmaster_prodmast')
            ->join('tbmaster_prodcrm','prc_pluigr', '=','prd_prdcd')
            ->select('prd_prdcd','prc_pluigr' ,'prc_pluidm', 'prd_deskripsipanjang',
                'prc_kodetag','PRC_HRGJUAL','prc_satuanrenceng',
                'prc_minorder','prc_minorderomi','prc_maxorderomi',
                'prc_datek','prc_pricek')
            ->where('prc_group','=','I')
            ->whereNotNull('prc_pluidm')
            ->orderBy('prc_pluigr')
            ->limit(100)
            ->get();

        $pluOmi = DB::table('tbmaster_prodmast')
            ->join('tbmaster_prodcrm','prc_pluigr', '=','prd_prdcd')
            ->select('prd_prdcd','prc_pluigr' ,'prc_pluidm', 'prd_deskripsipanjang',
                'prc_kodetag','PRC_HRGJUAL','prc_satuanrenceng',
                'prc_minorder','prc_minorderomi','prc_maxorderomi',
                'prc_datek','prc_pricek')
            ->where('prc_group','=','O')
            ->whereNotNull('prc_pluomi')
            ->orderBy('prc_pluigr')
            ->limit(100)
            ->get();

        return view('MASTER.barang')->with(['plu'=>$plu, 'pluIdm'=>$pluIdm, 'pluOmi'=>$pluOmi]);
    }

    public function showBarang (Request $request)
    {
        $kodeplu = $request->kodeplu;
        $tglpromo = '';
        $jampromo = '';
        $hrgpromo = '';
        $userUpd = '';
        $tglUpd = '';
        $brc1 = '';
        $brc2 = '';
        $margin_a = '';
        $margin_n = '';

        if ($kodeplu == 1){
            $kodeplu = DB::table('tbmaster_prodmast')->select('prd_prdcd')->orderBy('prd_prdcd')->first();
            $kodeplu = $kodeplu->prd_prdcd;

//            dd($kodeplu);
        }

        $result = DB::table('tbmaster_prodmast')
            ->leftJoin('tbmaster_divisi', function ($join) {
                $join->on('div_kodedivisi', '=', 'prd_kodedivisi');
//                    ->on('div_kodeigr', '=', 'prd_kodeigr');
            })
            ->leftJoin('tbmaster_departement', function ($join) {
                $join->on('DEP_KodeDepartement', '=', 'PRD_KodeDepartement')
                    ->on('dep_kodedivisi', '=', 'DIV_KODEDIVISI');
//                    ->on('DEP_KODEIGR', '=', 'PRD_KODEIGR');
            })
            ->leftJoin('tbmaster_kategori', function ($join) {
                $join->on('KAT_KodeKategori', '=', 'PRD_KodeKategoriBarang')
//                    ->on('KAT_KodeIGR', '=', 'PRD_KODEIGR')
                    ->on('KAT_KODEDEPARTEMENT', '=', 'DEP_KODEDEPARTEMENT');
            })
            ->leftJoin('tbmaster_tag', function ($join) {
                $join->on('TAG_KodeTag', '=', 'PRD_KodeTag');
//                    ->on('TAG_KodeIGR', '=', 'PRD_KodeIGR');
            })
//            ->join('tbmaster_procrm','prc_pluigr','=','prd_prdcd')
            ->leftJoin('tbtr_promomd', function ($join) {
                $join->on('PRMD_PRDCD', '=', 'PRD_PRDCD');
//                    ->on('PRMD_KODEIGR', '=', 'PRD_KodeIGR');
            })
//            ->join('tbmaster_barangexport', function ($join) {
//                $join->on('EXP_PRDCD','=','substr(PRD_PRDCD,1,6)')
//                ->on('EXP_KODEIGR','=','PRD_KodeIGR');
//            })
//            ->Join('TBMASTER_MINIMUMORDER', function ($join) {
//                $join->On(DB::raw('MIN_PRDCD'), '=', DB::raw('PRD_PRDCD'))
//                    ->On('MIN_KODEIGR', '=', 'PRD_KODEIGR')
//                    ->On('KAT_KODEDEPARTEMENT', '=', 'DEP_KODEDEPARTEMENT');
//            })
            ->leftJoin('TBMASTER_BARCODE', function ($join) {
                $join->on('BRC_PRDCD', '=', 'PRD_PRDCD');
            })
            ->select('*')
            ->where('prd_prdcd', '=', $kodeplu)
            ->where('prd_kodeigr','=','22')
//            ->where('prc_pluigr','=', $kodeplu)
            ->distinct()
            ->get();

        $date = date('Y-m-d');

//        dd($result);

        if ($date >= $result[0]->prmd_tglawal && $date <= $result[0]->prmd_tglakhir) {
            $tglpromo = substr($result[0]->prmd_tglawal, 0,10) . ' S/D ' . substr($result[0]->prmd_tglakhir,0,10);
            if ($result[0]->prmd_jamawal == 0) {
                $jampromo = ' ' . ' S/D ' . ' ';
            } else {
                $jampromo = $result[0]->prmd_jamawal . ' S/D ' . $result[0]->prmd_jamakhir;
            }
            $hrgpromo = $result[0]->prmd_hrgjual;
        }

//        $temp = ['tglpromo' => $tglpromo,'jampromo' => $jampromo,'hrgpromo' => $hrgpromo];



        $barcode = DB::Table('tbmaster_barcode')
            ->select('brc_barcode')
            ->where('brc_prdcd', '=', $kodeplu)
            ->orderBy('brc_prdcd')
            ->get();

        if (sizeof($barcode) == 0) {
            $brc1 = '';
            $brc2 = '';
        } else if (sizeof($barcode) == 1) {
            $brc1 = $result[0]->brc_barcode;
        } else {
            $brc1 = $result[0]->brc_barcode;
            $brc2 = $result[1]->brc_barcode;
        }

        if (!$result[0]->prd_modify_by) {
            $userUpd = $result[0]->prd_create_by;
            $tglUpd = $result[0]->prd_create_dt;
        } else {
            $userUpd = $result[0]->prd_modify_by;
            $tglUpd = $result[0]->prd_modify_dt;
        }

//        dd('test');

        if ($result[0]->prd_flagbkp1 == 'Y' and $result[0]->prd_flagbkp2 != 'PWG') {
            if ($result[0]->prd_kodetag == 'Q') {
                if ($result[0]->prd_avgcost == 0 or $result[0]->prd_hrgjual == 0 or $result[0]->prd_hrgjual3 == 0) {
                    $margin_a = null;
                    $margin_n = null;
                } else {
                    $margin_a = (1 - $result[0]->prd_avgcost / $result[0]->prd_hrgjual) * 100;
                    $margin_n = (1 - $result[0]->prd_avgcost / $result[0]->prd_hrgjual3) * 100;
                }
            } else {
                if ($result[0]->prd_avgcost == 0 or $result[0]->prd_hrgjual == 0 or $result[0]->prd_hrgjual3 == 0) {
                    $margin_a = null;
                    $margin_n = null;
                } else {
                    $margin_a = (1 - $result[0]->prd_avgcost / ($result[0]->prd_hrgjual / 1.1)) * 100;
                    $margin_n = (1 - $result[0]->prd_avgcost / ($result[0]->prd_hrgjual3 / 1.1)) * 100;
                }
            }
        } else {
            if ($result[0]->prd_avgcost == 0 or $result[0]->prd_hrgjual == 0 or $result[0]->prd_hrgjual3 == 0) {
                $margin_a = null;
                $margin_n = null;
            } else {
                $margin_a = (1 - $result[0]->prd_avgcost / $result[0]->prd_hrgjual) * 100;
                $margin_n = (1 - $result[0]->prd_avgcost / $result[0]->prd_hrgjual3) * 100;
            }
        }

        return response()->json(['kodeplu'=>$kodeplu, 'datas'=>$result, 'tglpromo' => $tglpromo, 'jampromo' => $jampromo, 'hrgpromo' => $hrgpromo, 'brc1'=>$brc1,
            'brc2'=>$brc2, 'userupd'=>$userUpd, 'tglupd'=>$tglUpd, 'margin_a'=>$margin_a,'margin_n'=>$margin_n]);

    }

    public function searchHelp(Request $request){
        $type       = $request->type;
        $search     = strtoupper($request->search);

        if ($type == 'plu'){
            $plu = DB::table('tbmaster_prodmast')
                ->selectRaw("nvl(prd_plusupplier, ' ') prd_plusupplier")
                ->selectRaw('prd_prdcd')
                ->selectRaw('prd_deskripsipanjang')
                ->selectRaw('prd_deskripsipendek')
//                ->select('prd_prdcd','prd_deskripsipanjang','prd_deskripsipendek')
                ->where(DB::RAW('substr(prd_prdcd,7,1)'),'=','0')
                ->where('prd_deskripsipanjang','LIKE', '%'.$search.'%')
//                ->orWhere('prd_prdcd','LIKE', '%'.$search.'%')
                ->orderBy('prd_prdcd')
                ->limit(100)
                ->get();

            return response()->json($plu);

        } elseif ($type == 'idm'){
            $pluIdm = DB::table('tbmaster_prodmast')
                ->join('tbmaster_prodcrm','prc_pluigr', '=','prd_prdcd')
//                ->select('prd_prdcd','prc_pluigr' ,'prc_pluidm', 'prd_deskripsipanjang',
//                    'prc_kodetag','PRC_HRGJUAL','prc_satuanrenceng',
//                    'prc_minorder','prc_minorderomi','prc_maxorderomi',
//                    'prc_datek','prc_pricek')
                ->selectRaw("nvl(prc_kodetag, ' ') prc_kodetag")
                ->selectRaw("nvl(prc_pluidm, ' ') prc_pluidm")
                ->selectRaw("prd_prdcd")
                ->selectRaw("prc_pluigr")
                ->selectRaw("prd_deskripsipanjang")
                ->selectRaw("PRC_HRGJUAL")
                ->selectRaw("prc_satuanrenceng")
                ->selectRaw("prc_minorder")
                ->selectRaw("prc_minorderomi")
                ->selectRaw("prc_maxorderomi")
                ->selectRaw("prc_pricek")
                ->selectRaw("nvl(to_char(null, prc_datek), ' ') prc_datek")
//                ->where('prd_prdcd','LIKE', '%'.$search.'%')
                ->where('prd_deskripsipanjang','LIKE', '%'.$search.'%')
                ->where('prc_group','=','I')
                ->whereNotNull('prc_pluidm')
//                ->whereRaw("prd_deskripsipanjang LIKE '%$search%' or prd_prdcd LIKE '%$search%'")
                ->orderBy('prc_pluigr')
                ->limit(100)
                ->get();

            return response()->json($pluIdm);

        } elseif ($type == 'omi') {
            $pluOmi = DB::table('tbmaster_prodmast')
                ->join('tbmaster_prodcrm','prc_pluigr', '=','prd_prdcd')
                ->selectRaw("nvl(prc_kodetag, ' ') prc_kodetag")
                ->selectRaw("nvl(to_char(null, prc_datek), ' ') prc_datek")
                ->selectRaw("prd_prdcd")
                ->selectRaw("prc_pluigr")
                ->selectRaw("prc_pluomi")
                ->selectRaw("prd_deskripsipanjang")
                ->selectRaw("PRC_HRGJUAL")
                ->selectRaw("prc_satuanrenceng")
                ->selectRaw("prc_minorder")
                ->selectRaw("prc_minorderomi")
                ->selectRaw("prc_maxorderomi")
                ->selectRaw("prc_pricek")
                ->where('prc_group','=','O')
                ->whereNotNull('prc_pluomi')
                ->where('prd_deskripsipanjang','LIKE', '%'.$search.'%')
//                ->orWhere('prd_prdcd','LIKE', '%'.$search.'%')
                ->orderBy('prc_pluigr')
                ->limit(100)
                ->get();
            return response()->json($pluOmi);

        }
    }

}
