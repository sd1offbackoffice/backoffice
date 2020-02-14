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
        $koderak =  DB::table('tbmaster_lokasi')
            ->select('lks_koderak')
            ->whereIn('lks_jenisrak', ['S'])
            ->where('lks_koderak', 'like', '%C')
            ->orderByRaw('REPLACE(lks_koderak,\'R\',\'E\')')
            ->distinct()
            ->get();

        return view('MASTER.kubikasiPlano')->with("koderak",$koderak);
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

    public function dataRakKecil(){
        $shelving =  DB::table('tbmaster_kubikasiplano')
            ->selectRaw('kbp_koderak,kbp_kodesubrak,kbp_shelvingrak,kbp_volumeshell,kbp_allowance,kbp_volumeshell*kbp_allowance/100 volreal')
            ->orderByRaw('REPLACE(kbp_koderak,\'R\',\'E\'), kbp_kodesubrak, kbp_shelvingrak')
            ->get();

        SELECT ROUND(SUM(vol_item), 1) vol_item
      INTO :vexists
      FROM (SELECT NVL((prd_dimensilebar * prd_dimensipanjang * prd_dimensitinggi)
            * round(lks_qty / prd_frac),
            0
        ) vol_item
              FROM tbmaster_lokasi, tbmaster_prodmast
             WHERE lks_kodeigr = :parameter.kodeigr
        AND lks_kodeigr = prd_kodeigr(+)
        AND lks_prdcd = prd_prdcd(+)
        AND lks_koderak = :kbp_koderak
        AND lks_kodesubrak = :kbp_kodesubrak
        AND lks_shelvingrak = :kbp_shelvingrak
        AND lks_jenisrak = 'S'
               );

   SELECT  count(1)
                      into temp
          FROM TBMASTER_LOKASI , 		  TBMASTER_PRODMAST, TBTR_SLP
         WHERE LKS_KODEIGR = :parameter.KODEIGR
        AND LKS_KODERAK = :KBP_KODERAK
        AND LKS_KODESUBRAK = :KBP_KODESUBRAK
        AND LKS_SHELVINGRAK = :KBP_SHELVINGRAK
        AND LKS_JENISRAK = 'S'
        AND LKS_BOOKED_SLPID = SLP_ID
        AND slp_prdcd = prd_prdcd;

  if temp =0 then :vbook :=0;
  	else
  SELECT  sum(
            NVL((NVL(prd_dimensilebar, 0) * NVL(prd_dimensipanjang, 0)
                    * NVL(prd_dimensitinggi, 0)
                )
                * slp_qtycrt,
                0
            ) )vol_book
                      into :vbook
          FROM TBMASTER_LOKASI , 		  TBMASTER_PRODMAST, TBTR_SLP
         WHERE LKS_KODEIGR = :parameter.KODEIGR
        AND LKS_KODERAK = :KBP_KODERAK
        AND LKS_KODESUBRAK = :KBP_KODESUBRAK
        AND LKS_SHELVINGRAK = :KBP_SHELVINGRAK
        AND LKS_JENISRAK = 'S'
        AND LKS_BOOKED_SLPID = SLP_ID
        AND slp_prdcd = prd_prdcd;
    end if;
    -----

    :vbtb := 0;

    :vsisa := :vreal - (:vexists +  :vbook+ :vbtb);

    IF :VSISA <= 0 THEN
    		SET_ITEM_INSTANCE_PROPERTY ('VSISA', CURRENT_RECORD, VISUAL_ATTRIBUTE, 'V_MINUS');
    ELSE
        SET_ITEM_INSTANCE_PROPERTY ('VSISA', CURRENT_RECORD, VISUAL_ATTRIBUTE, 'V_STD');
        END IF;

        return $shelving;
    }


}
