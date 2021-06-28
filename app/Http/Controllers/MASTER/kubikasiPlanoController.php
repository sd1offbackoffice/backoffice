<?php

namespace App\Http\Controllers\MASTER;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\NotIn;
use phpDocumentor\Reflection\Types\Integer;


class kubikasiPlanoController extends Controller
{
    public function index(){
        Self::fill_kublikasi();
        $koderak =  DB::table('tbmaster_lokasi')
            ->select('lks_koderak')
            ->whereIn('lks_jenisrak', ['S'])
            ->where('lks_koderak', 'like', '%C')
            ->orderByRaw('REPLACE(lks_koderak,\'R\',\'E\')')
            ->distinct()
            ->get();

        $produk = DB::table('tbmaster_prodmast')
            ->select('prd_prdcd','prd_deskripsipanjang')
            ->where(DB::RAW('SUBSTR(prd_prdcd,7,1)'),'=','0')
            ->orderBy('prd_deskripsipanjang')
            ->limit(1000)
            ->get();
        return view('MASTER.kubikasiPlano')->with("koderak",$koderak)->with('produk',$produk);
    }

    public function lov_subrak(Request $request){
        $subrak =  DB::table('tbmaster_lokasi')
            ->select('lks_koderak','lks_kodesubrak')
            ->whereIn('lks_jenisrak', ['S'])
            ->where('lks_koderak', 'like', '%C')
            ->whereRaw('lks_koderak like nvl(\''.$request->koderak.'\',\'%\')')
            ->orderByRaw('REPLACE(lks_koderak,\'R\',\'E\')')
            ->orderBy('lks_kodesubrak')
            ->distinct()
            ->get();

        return $subrak;
    }

    public function lov_shelving(Request $request){
        $shelving =  DB::table('tbmaster_lokasi')
            ->select('lks_koderak','lks_kodesubrak','lks_shelvingrak')
            ->whereIn('lks_jenisrak', ['S'])
            ->where('lks_koderak', 'like', '%C')
            ->whereRaw('lks_koderak like nvl(\''.$request->koderak.'\',\'%\')')
            ->whereRaw('lks_kodesubrak like nvl(\''.$request->subrak.'\',\'%\')')
            ->orderByRaw('REPLACE(lks_koderak,\'R\',\'E\')')
            ->orderBy('lks_kodesubrak')
            ->orderBy('lks_shelvingrak')
            ->distinct()
            ->get();

        return $shelving;
    }

    public function lov_search(Request $request){
        if(is_numeric($request->value)){
            $result = DB::table('tbmaster_prodmast')
                ->selectRaw('prd_prdcd,prd_deskripsipanjang,prd_deskripsipendek s_desk,prd_unit || \'/\' || prd_frac s_sat,(NVL(prd_dimensilebar, 0) * NVL(prd_dimensipanjang, 0) * NVL(prd_dimensitinggi, 0)) s_vol')
                ->where('prd_prdcd','like','%'.$request->value.'%')
                ->orderBy('prd_deskripsipanjang')
                ->get();
        }
        else{
            $result = DB::table('tbmaster_prodmast')
                ->selectRaw('prd_prdcd,prd_deskripsipanjang,prd_deskripsipendek s_desk,prd_unit || \'/\' || prd_frac s_sat,(NVL(prd_dimensilebar, 0) * NVL(prd_dimensipanjang, 0) * NVL(prd_dimensitinggi, 0)) s_vol')
                ->where('prd_deskripsipanjang','like','%'.$request->value.'%')
                ->orderBy('prd_deskripsipanjang')
                ->get();
        }
        return $result;
    }


    public function dataRakKecil(){
        try {
            $shelving =  DB::select('SELECT kbp_koderak,
                                         kbp_kodesubrak,
                                         kbp_shelvingrak,
                                         kbp_volumeshell,
                                         kbp_allowance,
                                         vreal,
                                         vexists,
                                         vbook,
                                         vbtb,
                                         (vreal - (vexists+vbtb + 0)) vsisa
                                  from(
                                  SELECT kbp_koderak,
                                         kbp_kodesubrak,
                                         kbp_shelvingrak,
                                         kbp_volumeshell,
                                         kbp_allowance,
                                         kbp_volumeshell * kbp_allowance / 100 vreal,
                                         (SELECT SUM (
                                                    NVL (
                                                         (  prd_dimensilebar
                                                          * prd_dimensipanjang
                                                          * prd_dimensitinggi)
                                                       * ROUND (lks_qty / prd_frac),
                                                       0))
                                            FROM tbmaster_lokasi left join tbmaster_prodmast on lks_kodeigr = prd_kodeigr
                                                 AND lks_prdcd = prd_prdcd
                                           WHERE lks_koderak = kbp_koderak
                                                 AND lks_kodesubrak = kbp_kodesubrak
                                                 AND lks_shelvingrak = kbp_shelvingrak
                                                 AND lks_jenisrak = \'S\')
                                            vexists,
                                         (SELECT SUM (
                                                    NVL (
                                                         (  NVL (prd_dimensilebar, 0)
                                                          * NVL (prd_dimensipanjang, 0)
                                                          * NVL (prd_dimensitinggi, 0))
                                                       * slp_qtycrt,
                                                       0))
                                                    vol_book
                                            FROM TBMASTER_LOKASI, TBMASTER_PRODMAST, TBTR_SLP
                                           WHERE     LKS_KODERAK = KBP_KODERAK
                                                 AND LKS_KODESUBRAK = KBP_KODESUBRAK
                                                 AND LKS_SHELVINGRAK = KBP_SHELVINGRAK
                                                 AND LKS_JENISRAK = \'S\'
                                                 AND LKS_BOOKED_SLPID = SLP_ID
                                                 AND slp_prdcd = prd_prdcd)
                                            vbook,
                                            0 vbtb
                                    FROM tbmaster_kubikasiplano
                                ORDER BY REPLACE (kbp_koderak, \'R\', \'E\'), kbp_kodesubrak, kbp_shelvingrak
                                )');
            return $shelving;
        } catch (\Exception $e) {
            report($e);
            return $e->getTraceAsString();
        }
    }

    public function dataRakKecilParam(Request $request){
        $shelving =  DB::select('SELECT kbp_koderak,
                                         kbp_kodesubrak,
                                         kbp_shelvingrak,
                                         kbp_volumeshell,
                                         kbp_allowance,
                                         vreal,
                                         vexists,
                                         vbook,
                                         vbtb,
                                         (vreal - (vexists+vbtb + 0)) vsisa
                                  from(
                                  SELECT kbp_koderak,
                                         kbp_kodesubrak,
                                         kbp_shelvingrak,
                                         kbp_volumeshell,
                                         kbp_allowance,
                                         kbp_volumeshell * kbp_allowance / 100 vreal,
                                         (SELECT SUM (
                                                    NVL (
                                                         (  prd_dimensilebar
                                                          * prd_dimensipanjang
                                                          * prd_dimensitinggi)
                                                       * ROUND (lks_qty / prd_frac),
                                                       0))
                                            FROM tbmaster_lokasi left join tbmaster_prodmast on lks_kodeigr = prd_kodeigr
                                                 AND lks_prdcd = prd_prdcd
                                           WHERE lks_koderak = kbp_koderak
                                                 AND lks_kodesubrak = kbp_kodesubrak
                                                 AND lks_shelvingrak = kbp_shelvingrak
                                                 AND lks_jenisrak = \'S\')
                                            vexists,
                                         (SELECT SUM (
                                                    NVL (
                                                         (  NVL (prd_dimensilebar, 0)
                                                          * NVL (prd_dimensipanjang, 0)
                                                          * NVL (prd_dimensitinggi, 0))
                                                       * slp_qtycrt,
                                                       0))
                                                    vol_book
                                            FROM TBMASTER_LOKASI, TBMASTER_PRODMAST, TBTR_SLP
                                           WHERE     LKS_KODERAK = KBP_KODERAK
                                                 AND LKS_KODESUBRAK = KBP_KODESUBRAK
                                                 AND LKS_SHELVINGRAK = KBP_SHELVINGRAK
                                                 AND LKS_JENISRAK = \'S\'
                                                 AND LKS_BOOKED_SLPID = SLP_ID
                                                 AND slp_prdcd = prd_prdcd)
                                            vbook,
                                            0 vbtb
                                    FROM tbmaster_kubikasiplano
                                    WHERE kbp_koderak = \''.$request->koderak.'\'
                                         AND kbp_kodesubrak = \''.$request->kodesubrak.'\'
                                         AND kbp_shelvingrak = \''.$request->shelvingrak.'\'
                                ORDER BY REPLACE (kbp_koderak, \'R\', \'E\'), kbp_kodesubrak, kbp_shelvingrak
                                )');

        return $shelving;
    }
    public function save_kubikasi(Request $request){
//        dd(($request));
        for($i = 0 ; $i< sizeof($request->value['koderak']); $i++){
            $opo = DB::table('tbmaster_kubikasiplano')
                ->where('kbp_koderak', $request->value['koderak'][$i])
                ->where('kbp_kodesubrak', $request->value['kodesubrak'][$i])
                ->where('kbp_shelvingrak', $request->value['shelvingrak'][$i])->get();
//            dd($opo);
            if($opo) {
                DB::table('tbmaster_kubikasiplano')
                    ->where('kbp_koderak', $request->value['koderak'][$i])
                    ->where('kbp_kodesubrak', $request->value['kodesubrak'][$i])
                    ->where('kbp_shelvingrak', $request->value['shelvingrak'][$i])
                    ->update(['kbp_volumeshell' => $request->value['volume'][$i], 'kbp_allowance' => $request->value['allowance'][$i], 'kbp_modify_dt' => DB::RAW('sysdate'), 'KBP_MODIFY_BY' => 'WEB']);
            }
        }
        $message = 'Data Berhasil Terupdate!';
        $status = 'success';

        return compact(['message','status']);
    }

    public function fill_kublikasi(){
        DB::insert("INSERT INTO TBMASTER_KUBIKASIPLANO
        (KBP_KODERAK, KBP_KODESUBRAK, KBP_SHELVINGRAK, KBP_VOLUMESHELL, KBP_ALLOWANCE, KBP_CREATE_BY, KBP_CREATE_DT)
        SELECT LKS_KODERAK, LKS_KODESUBRAK, LKS_SHELVINGRAK, 0, 0, '". $_SESSION['usid'] ."', SYSDATE
          FROM (SELECT DISTINCT LKS_KODERAK, LKS_KODESUBRAK, LKS_SHELVINGRAK
                           FROM TBMASTER_LOKASI
                          WHERE LKS_KODERAK LIKE '%C'
        AND LKS_JENISRAK = 'S'
        AND NOT EXISTS (
            SELECT 1 FROM TBMASTER_KUBIKASIPLANO
            WHERE KBP_KODERAK = LKS_KODERAK
        AND KBP_KODESUBRAK = LKS_KODESUBRAK
        AND KBP_SHELVINGRAK = LKS_SHELVINGRAK))");
    }
}
