<?php

namespace App\Http\Controllers\MASTER;

use App\AllModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class aktifAllHargaJualController extends Controller
{
    public function index(){
        $model  = new AllModel();
        $date   = $model->getDate();

//        $getData    = DB::table('tbmaster_prodmast')
//            ->where('PRD_HRGJUAL3', '>', 0)
//            ->whereRaw('PRD_HRGJUAL <> PRD_HRGJUAL3')
//            ->whereRaw('PRD_TGLHRGJUAL3 IS NOT NULL')
//            ->where('PRD_TGLHRGJUAL3', '<=', $date)
//            ->whereRaw('PRD_TGLHRGJUAL3 >= PRD_TGLHRGJUAL')
//            ->get()->toArray();

        $getData    = DB::table('tbmaster_prodmast')
            ->where('PRD_HRGJUAL3', '>', 0)
            ->limit(100)->get()->toArray();

        return view('MASTER.aktifAllHargaJual', compact('getData'));
    }

    public function aktifkanAllItem(){
        $user   = 'JEP';
        $model  = new AllModel();
        $getData= $model->getKodeigr();
        $kodeigr = $getData[0]->prs_kodeigr;
        $jenistimbangan = 1;
//      $jenistimbangan = $getData[0]->prs_jenistimbangan;
      $ppn            = $getData[0]->prs_nilaippn;
        $errm  = '';

        $connection = oci_connect('simsmg', 'simsmg','(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST=192.168.237.193)(PORT=1521)) (CONNECT_DATA=(SERVER=DEDICATED) (SERVICE_NAME = simsmg)))');

        $exec = oci_parse($connection, "BEGIN  sp_aktifkan_harga_allitem(:kodeigr,:jtim, :ppn, :user,:errm); END;");
        oci_bind_by_name($exec, ':kodeigr',$kodeigr,100);
        oci_bind_by_name($exec, ':jtim',$jenistimbangan,100);
        oci_bind_by_name($exec, ':ppn',$ppn,100);
        oci_bind_by_name($exec, ':user',$user,100);
        oci_bind_by_name($exec, ':errm', $errm,1000);
        oci_execute($exec);

        return response()->json($errm);
    }
}



/*

SELECT NVL(COUNT(1),0) INTO TEMP FROM TBMASTER_PRODMAST
	WHERE PRD_KODEIGR = :PARAMETER.KODEIGR AND NVL(PRD_RECORDID,' ') <> '1'
	AND NVL(PRD_HRGJUAL3,0) > 0 AND PRD_HRGJUAL <> PRD_HRGJUAL3
	AND PRD_TGLHRGJUAL3 IS NOT NULL AND PRD_TGLHRGJUAL3 <= SYSDATE
	AND PRD_TGLHRGJUAL3 >= PRD_TGLHRGJUAL;


 * */
