<?php

namespace App\Http\Controllers\MASTER;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class memberController extends Controller
{
    //

    public function index(){
        $member = DB::table('tbmaster_customer')
            ->select('*')
            ->where(DB::RAW('ROWNUM'),'<=','100')
            ->orderBy('cus_namamember')
            ->limit(100)
            ->get();

        $hobby = DB::table('tbtabel_hobby')->select('*')->get();

        $kodepos = DB::table('tbmaster_kodepos')->select('*')->limit(100)->get();

        $fasilitasperbankan = DB::table('tbmaster_fasilitasperbankan')->get();

        return view('MASTER.member')->with(compact(['member','hobby','fasilitasperbankan','kodepos']));
    }

    public function lov_member_select(Request $request){
        $member = DB::table('tbmaster_customer')
            ->leftJoin('tbmaster_customercrm','cus_kodemember','=','crm_kodemember')
            ->select('*')
            ->where('cus_kodemember',$request->value)
            ->first();

        if($member->cus_alamatmember4 != '' && $member->cus_alamatmember4 != null){
            $ktp = DB::table('tbmaster_kodepos')
                ->select('pos_kecamatan')
                ->where('pos_kode','=',$member->cus_alamatmember3)
                ->where('pos_kelurahan','=',$member->cus_alamatmember4)
                ->first();
        }
        else if($member->cus_alamatmember3 != '' && $member->cus_alamatmember3 != null){
            $ktp = DB::table('tbmaster_kodepos')
                ->select('*')
                ->where('pos_kode','=',$member->cus_alamatmember3)
                ->first();
        }
        else $ktp = '';

        if($member->cus_alamatmember8 != '' && $member->cus_alamatmember8 != null) {
            $surat = DB::table('tbmaster_kodepos')
                ->select('pos_kecamatan')
                ->where('pos_kode', '=', $member->cus_alamatmember7)
                ->where('pos_kelurahan', '=', $member->cus_alamatmember8)
                ->first();
        }
        else if($member->cus_alamatmember7 != '' && $member->cus_alamatmember7 != null){
            $surat = DB::table('tbmaster_kodepos')
                ->select('*')
                ->where('pos_kode', '=', $member->cus_alamatmember7)
                ->first();
        }
        else $surat = '';

        if($member->crm_kodemember != '' && $member->crm_alamatusaha3 != null && $member->crm_alamatusaha4 != null){
            $usaha = DB::table('tbmaster_kodepos')
                ->select('pos_kecamatan')
                ->where('pos_kode','=',$member->crm_alamatusaha3)
                ->where('pos_kelurahan','=',$member->crm_alamatusaha4)
                ->first();
        }
        else{
            $usaha = '';
        }

        if($member->crm_idgroupkat != '' && $member->crm_idgroupkat != null){
            $group = DB::table('tbtabel_groupkategori')
                ->select('*')
                ->where('grp_idgroupkat','=',$member->crm_idgroupkat)
                ->first();
        }
        else{
            $group = '';
        }

        $jenismember = DB::table('tbmaster_jenismember')
            ->select('*')
            ->where('jm_kode','=',$member->cus_jenismember)
            ->first();

        $outlet = DB::table('tbmaster_outlet')
            ->select('*')
            ->where('out_kodeoutlet','=',$member->cus_kodeoutlet)
            ->first();



        $bank = DB::table('tbmaster_customerfasilitasbank')
            ->select('*')
            ->where('cub_kodemember','=',$request->value)
            ->get();

        $hobbymember = DB::table('tbtabel_hobbydetail')
            ->select('*')
            ->where('dhb_kodemember','=',$member->cus_kodemember)
            ->get();

        $creditlimit = DB::table('tbhistory_creditlimit')
            ->select('*')
            ->where('lmt_kodemember','=',$member->cus_kodemember)
            ->get();

        $npwp = DB::table('tbmaster_npwp')
            ->select('*')
            ->where('pwp_kodemember','=',$member->cus_kodemember)
            ->first();

//        $member = DB::table('tbmaster_customer')
//            ->leftJoin('tbmaster_jenismember','jm_kode','=','cus_jenismember')
//            ->leftJoin('tbmaster_outlet','out_kodeoutlet','=','cus_kodeoutlet')
//            ->select('*')
//            ->where('cus_kodemember','=',$request->value)
//            ->first();
//
//        $membercrm = DB::table('tbmaster_customercrm')
//            ->join('tbtabel_groupkategori','grp_idgroupkat','=','crm_idgroupkat')
//            ->select('*')
//            ->where('crm_kodemember','=',$request->value)
//            ->get();
//
//        dd($member);

//        dd(compact(['member','ktp','surat','usaha','jenismember','outlet','group','bank','hobbymember','creditlimit','npwp']));

        if(!$member){
            return 'not-found';
        }
        else return compact(['member','ktp','surat','usaha','jenismember','outlet','group','bank','hobbymember','creditlimit','npwp']);
    }

    public function lov_member_search(Request $request){
        if(!ctype_alpha($request->value)){
            $result = DB::table('tbmaster_customer')
                ->select('*')
                ->where('cus_kodemember',$request->value)
                ->get();
        }
        else{
            $result = DB::table('tbmaster_customer')
                ->select('*')
                ->where('cus_namamember','like','%'.$request->value.'%')
                ->orderBy('cus_namamember')
                ->get();
        }

        return response()->json($result);
    }

    public function lov_kodepos_search(Request $request){
        if(is_numeric($request->value)){
            $result = DB::table('tbmaster_customer')
                ->select('*')
                ->where('cus_kodemember',$request->value)
                ->get();
        }

        else{
            $result = DB::table('tbmaster_customer')
                ->select('*')
                ->where('cus_namamember','like','%'.$request->value.'%')
                ->orderBy('cus_namamember')
                ->get();
        }

        return response()->json($result);
    }
}
