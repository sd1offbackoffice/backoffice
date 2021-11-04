<?php
/**
 * Created by PhpStorm.
 * User: ryan
 * Date: 1/12/2021
 * Time: 3:25 PM
 */

namespace App\Http\Controllers\FRONTOFFICE;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use PDF;
use DateTime;

class ampController extends Controller
{

    public function index()
    {
        $year = date("Y");
        $month = date("m");
        $periode = 1;
        if($month > 6){
            $periode = 2;
        }
        $segmentasi = DB::connection($_SESSION['connection'])->table('tbmaster_segmentasi')
            ->selectRaw("seg_id")
            ->selectRaw("seg_nama")
            ->selectRaw("seg_mintrx")
            ->selectRaw("seg_maxtrx")
            ->selectRaw("seg_member_merah")
            ->get();

        $datas = DB::connection($_SESSION['connection'])->table('TBTR_SEGMENTASI_CUS')
            ->selectRaw("*")
            ->where("sgc_tahun",'=',$year)
            ->where("sgc_periode",'=',$periode)
            ->where("sgc_flag_update",'=','N')
            ->whereRaw("(SGC_DEFAULT = '6' OR SGC_LAMPAU = '6')")
            ->orderBy("sgc_kd_member")
            ->get();

        for($i=0;$i<sizeof($datas);$i++){
            $temp = $datas[$i]->sgc_lampau;
            $nama_seg[$i] = DB::connection($_SESSION['connection'])->table("tbmaster_segmentasi")
                ->selectRaw('seg_nama')
                ->where('seg_id','=',$temp)
                ->first();
        }



        return view('FRONTOFFICE.amp',['segmentasi'=>$segmentasi, 'datas'=>$datas, 'nama_seg' => $nama_seg]);
    }

    public function GetData()
    {
        $usid = $_SESSION['usid'];
        $year = date("Y");
        $month = date("m");
        $periode = 1;
        if($month > 6){
            $periode = 2;
        }

        $segmentasi = DB::connection($_SESSION['connection'])->table('tbmaster_segmentasi')
            ->selectRaw("seg_id")
            ->selectRaw("seg_nama")
            ->selectRaw("seg_mintrx")
            ->selectRaw("seg_maxtrx")
            ->selectRaw("seg_member_merah")
            ->get();

        $datas = DB::connection($_SESSION['connection'])->table('TBTR_SEGMENTASI_CUS')
            ->selectRaw("*")
            ->where("sgc_tahun",'=',$year)
            ->where("sgc_periode",'=',$periode)
            ->where("sgc_flag_update",'=','N')
            ->whereRaw("(SGC_DEFAULT = '6' OR SGC_LAMPAU = '6')")
            ->orderBy("sgc_kd_member")
            ->get();

        $temp = DB::connection($_SESSION['connection'])->table("TBMASTER_USER")
            ->selectRaw("COUNT(1) result")
            ->where('USERID','=',$usid)
            ->whereRaw("UPPER(EMAIL) LIKE 'SM%INDOGROSIR%'")
            ->first();
        if($temp->result){
            $auth = true;
        }else{
            $auth = false;
        }
        for($i=0;$i<sizeof($datas);$i++){
            $member[$i] = DB::connection($_SESSION['connection'])->table('tbmaster_customer')
                ->selectRaw('cus_namamember')
                ->where('cus_kodemember','=',$datas[$i]->sgc_kd_member)
                ->first();
        }

        return response()->json(['namaseg' => $segmentasi, 'datas' => $datas, 'auth' => $auth, 'namaMember' => $member]);
    }

    public function UpdateData(Request $request){
        try{
            $usid = $_SESSION['usid'];
            $today = date("Y-m-d H:i:s");
            $kd_member = $request->kd_member;
            $v_thn = $request->sgc_tahun;
            $v_periode = $request->sgc_periode;
            $rekomendasi = $request->rekomendasi;
            DB::beginTransaction();
            DB::connection($_SESSION['connection'])->table("TBTR_SEGMENTASI_CUS")
                ->where('SGC_KD_MEMBER','=',$kd_member)
                ->where('SGC_TAHUN','=',$v_thn)
                ->where('SGC_PERIODE','=',$v_periode)
                ->update(['SGC_FLAG_UPDATE' => 'Y', 'SGC_MODIFY_BY' => $usid, 'SGC_MODIFY_DT' => $today]);

            DB::connection($_SESSION['connection'])->table("TBMASTER_CUSTOMERCRM")
                ->where('CRM_KODEMEMBER','=',$kd_member)
                ->update(['CRM_IDSEGMENT' => $rekomendasi, 'CRM_MODIFY_BY' => $usid, 'CRM_MODIFY_DT' => $today]);
            DB::commit();
        }catch (\Exception $e){
            dd($e->getMessage());
            //return response()->json(['kode' => 2, 'msg' => $e->getMessage()]);
        }

    }

    public function UpdateData2(Request $request){
        try{
            $usid = $_SESSION['usid'];
            $today = date("Y-m-d H:i:s");
            $kd_member = $request->kd_member;
            $v_thn = $request->sgc_tahun;
            $v_periode = $request->sgc_periode;
            DB::beginTransaction();
            DB::connection($_SESSION['connection'])->table("TBTR_SEGMENTASI_CUS")
                ->where('SGC_KD_MEMBER','=',$kd_member)
                ->where('SGC_TAHUN','=',$v_thn)
                ->where('SGC_PERIODE','=',$v_periode)
                ->update(['SGC_REKOMENDASI' => '6', 'SGC_FLAG_UPDATE' => 'Y', 'SGC_MODIFY_BY' => $usid, 'SGC_MODIFY_DT' => $today]);

            DB::connection($_SESSION['connection'])->table("TBMASTER_CUSTOMERCRM")
                ->where('CRM_KODEMEMBER','=',$kd_member)
                ->update(['CRM_IDSEGMENT' => '6', 'CRM_MODIFY_BY' => $usid, 'CRM_MODIFY_DT' => $today]);
            DB::commit();
        }catch (\Exception $e){
            dd($e->getMessage());
            //return response()->json(['kode' => 2, 'msg' => $e->getMessage()]);
        }
    }

    public function UpdateData3(Request $request){
        try{
            $usid = $_SESSION['usid'];
            $today = date("Y-m-d H:i:s");
            $kd_member = $request->kd_member;
            $v_thn = $request->sgc_tahun;
            $v_periode = $request->sgc_periode;
            DB::beginTransaction();
            DB::connection($_SESSION['connection'])->table("TBTR_SEGMENTASI_CUS")
                ->where('SGC_KD_MEMBER','=',$kd_member)
                ->where('SGC_TAHUN','=',$v_thn)
                ->where('SGC_PERIODE','=',$v_periode)
                ->update(['SGC_REKOMENDASI' => '6', 'SGC_FLAG_UPDATE' => 'Y', 'SGC_MODIFY_BY' => $usid, 'SGC_MODIFY_DT' => $today]);

            DB::connection($_SESSION['connection'])->table("TBMASTER_CUSTOMERCRM")
                ->where('CRM_KODEMEMBER','=',$kd_member)
                ->update(['CRM_IDSEGMENT' => '6', 'CRM_MODIFY_BY' => $usid, 'CRM_MODIFY_DT' => $today]);
            DB::commit();
        }catch (\Exception $e){
            dd($e->getMessage());
            //return response()->json(['kode' => 2, 'msg' => $e->getMessage()]);
        }
    }

    public function UpdateData4(Request $request){
        try{
            $usid = $_SESSION['usid'];
            $today = date("Y-m-d H:i:s");
            $kd_member = $request->kd_member;
            $v_thn = $request->sgc_tahun;
            $v_periode = $request->sgc_periode;
            $deflt = $request->deflt;
            DB::beginTransaction();
            DB::connection($_SESSION['connection'])->table("TBTR_SEGMENTASI_CUS")
                ->where('SGC_KD_MEMBER','=',$kd_member)
                ->where('SGC_TAHUN','=',$v_thn)
                ->where('SGC_PERIODE','=',$v_periode)
                ->update(['SGC_REKOMENDASI' => $deflt, 'SGC_FLAG_UPDATE' => 'Y', 'SGC_MODIFY_BY' => $usid, 'SGC_MODIFY_DT' => $today]);

            DB::connection($_SESSION['connection'])->table("TBMASTER_CUSTOMERCRM")
                ->where('CRM_KODEMEMBER','=',$kd_member)
                ->update(['CRM_IDSEGMENT' => $deflt, 'CRM_MODIFY_BY' => $usid, 'CRM_MODIFY_DT' => $today]);
            DB::commit();
        }catch (\Exception $e){
            dd($e->getMessage());
            //return response()->json(['kode' => 2, 'msg' => $e->getMessage()]);
        }
    }

}
