<?php

namespace App\Http\Controllers\MASTER;

use App\AllModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class aktifAllHargaJualController extends Controller
{
    public function index(){
        return view('MASTER.aktifAllHargaJual');
    }

    public function aktifkanAllItem(){
        $model  = new AllModel();
        $date   = $model->getDate();

        $getData    = DB::table('tbmaster_prodmast')
            ->where('PRD_HRGJUAL3', '>', 0)
            ->whereRaw('PRD_HRGJUAL <> PRD_HRGJUAL3')
            ->whereRaw('PRD_TGLHRGJUAL3 IS NOT NULL')
            ->where('PRD_TGLHRGJUAL3', '<=', $date)
            ->whereRaw('PRD_TGLHRGJUAL3 >= PRD_TGLHRGJUAL')
            ->get()->toArray();

        foreach ($getData as $data){
//            DB::table('tbmaster_prodmast')->where('prd_prdcd', $plu)->update(['prd_hrgjual2' => $getHarga[0]->prd_hrgjual, 'prd_hrgjual' => $getHarga[0]->prd_hrgjual3, 'prd_tglhrgjual2' => $getHarga[0]->prd_tglhrgjual, 'prd_tglhrgjual' => $getHarga[0]->prd_tglhrgjual3 ,
//            'prd_modify_by' => $user, 'prd_modify_dt' => $date]);
        }

        return response()->json($getData);
    }
}



/*

SELECT NVL(COUNT(1),0) INTO TEMP FROM TBMASTER_PRODMAST
	WHERE PRD_KODEIGR = :PARAMETER.KODEIGR AND NVL(PRD_RECORDID,' ') <> '1'
	AND NVL(PRD_HRGJUAL3,0) > 0 AND PRD_HRGJUAL <> PRD_HRGJUAL3
	AND PRD_TGLHRGJUAL3 IS NOT NULL AND PRD_TGLHRGJUAL3 <= SYSDATE
	AND PRD_TGLHRGJUAL3 >= PRD_TGLHRGJUAL;


 * */
