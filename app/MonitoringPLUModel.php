<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class MonitoringPLUModel extends Model
{
    public function viewListMtrPlu(){
        $result = DB::connection(Session::get('connection'))->table('tbmaster_monitoringplueis')->select('mtr_kodemtr', 'mtr_namamtr')->groupBy(['mtr_kodemtr', 'mtr_namamtr'])
            ->where('mtr_record_id', null)
            ->orderBy('mtr_kodemtr')->get()->toArray();

        return $result;
    }

    public function viewListDetail($kodeMtr){
        $detail = DB::connection(Session::get('connection'))->table('tbmaster_monitoringplueis')->select('mtr_prdcd as mtr_kodeplu', 'mtr_deskripsi')->where('mtr_kodemtr', $kodeMtr)->get()->toArray();

        foreach ($detail as $item) {
            $getProdmast = DB::connection(Session::get('connection'))->table('tbmaster_prodmast')->select('prd_unit', 'prd_frac', 'prd_kodetag')->where('prd_prdcd', $item->mtr_kodeplu)->first();

            if ($getProdmast == null){
                $item->mtr_unit = 'null';
                $item->mtr_frac = 'null';
                $item->mtr_ptag = 'null';
            } else {
                $item->mtr_unit = $getProdmast->prd_unit;
                $item->mtr_frac = $getProdmast->prd_frac;
                $item->mtr_ptag = $getProdmast->prd_kodetag;
            }
        }

        return $detail;
    }

    public function searchPlu($plu){
        $result = DB::connection(Session::get('connection'))->table('tbmaster_prodmast')
            ->select('prd_prdcd as mtr_kodeplu', 'prd_deskripsipendek as mtr_deskripsi')
            ->where("prd_prdcd", $plu)
            ->get()->toArray();

        return $result;
    }

    public function searchMtrName($kodeMtr){
        return   DB::connection(Session::get('connection'))->table('tbmaster_monitoringplueis')->select("mtr_namamtr")->where('mtr_kodemtr', $kodeMtr)->get()->first();
    }

    public function saveNewMtr($datas, $mtrName){
        $date       = date('Y-m-d');
        $kodemtr    = null;
        $flag       = null;
        $user       = Session::get('uid');

        $getId  = DB::connection(Session::get('connection'))->table('tbmaster_monitoringplueis')->select('mtr_kodemtr')
            ->where('mtr_kodemtr','like','P%')
            ->whereRaw("length(mtr_kodemtr) = 5")
            ->orderByDesc('mtr_kodemtr')->first();

        if ($getId == null){
            $kodemtr = 'P0001';
        } else {
            $kodemtr = substr($getId->mtr_kodemtr,1);
            $kodemtr = (int)$kodemtr+1;

            for ($i =strlen($kodemtr); $i < 4; $i++){
                $flag = $flag.'0';
            }
            $kodemtr = 'P'.$flag.$kodemtr;
        }

        foreach ($datas as $data){
            DB::connection(Session::get('connection'))->table('tbmaster_monitoringplueis')->insert(['mtr_record_id'=>'', 'mtr_kodemtr'=>$kodemtr, 'mtr_namamtr'=>strtoupper($mtrName), 'mtr_prdcd'=>$data['mtr_kodeplu'], 'mtr_deskripsi'=>$data['mtr_deskripsi'],
                'mtr_keterangan'=> '', 'mtr_create_by'=>$user, 'mtr_create_dt'=>$date, 'mtr_update_by'=>'', 'mtr_update_dt'=>'']);
        }

        return ['kode' => 1, 'kodeMtr' => $kodemtr];
    }

    public function deleteListMonitoring($kodeMtr){
        $date       = date('Y-m-d');
        $user       = Session::get('uid');

        DB::connection(Session::get('connection'))->table('tbmaster_monitoringplueis')->where('mtr_kodemtr', $kodeMtr)->update(['mtr_record_id'=>'1', 'mtr_update_by'=>$user, 'mtr_update_dt' => $date]);
        return ['kode' => 1];
    }

    public function updateDataMonitoring($datas, $mtrName, $kodeMtr){
        $getOldData = DB::connection(Session::get('connection'))->table('tbmaster_monitoringplueis')->select('mtr_create_by', 'mtr_create_dt')->where('mtr_kodemtr', $kodeMtr)->get();
        $createBy   = $getOldData[0]->mtr_create_by;
        $createDt   = substr($getOldData[0]->mtr_create_dt,0,10);
        $date       = date('Y-m-d');
        $flag       = null;
        $user       = Session::get('uid');

        DB::connection(Session::get('connection'))->table('tbmaster_monitoringplueis')->where('mtr_kodemtr', $kodeMtr)->delete();

        foreach ($datas as $data){
            DB::connection(Session::get('connection'))->table('tbmaster_monitoringplueis')->insert(['mtr_record_id'=>'', 'mtr_kodemtr'=>$kodeMtr, 'mtr_namamtr'=>strtoupper($mtrName), 'mtr_prdcd'=>$data['mtr_kodeplu'], 'mtr_deskripsi'=>$data['mtr_deskripsi'],
                'mtr_keterangan'=> '', 'mtr_create_by'=>$createBy, 'mtr_create_dt'=>$createDt, 'mtr_update_by'=>$user, 'mtr_update_dt'=>$date]);
        }

        return ['kode' => 1];
    }
}
