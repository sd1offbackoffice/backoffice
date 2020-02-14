<?php

namespace App\Http\Controllers\MASTER;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class omiController extends Controller
{
    public function index(){
        return view('MASTER.omi');
    }

    public function getTokoOmi(Request $request){
        $kodeSBU    = $request->kodeSBU;

        $datas      = DB::table('tbmaster_tokoigr a')
            ->select('a.*', 'b.cab_namacabang', 'c.cus_namamember')
            ->leftJoin('tbmaster_customer c', 'a.tko_kodecustomer', 'c.cus_kodemember')
            ->leftJoin('tbmaster_cabang b', 'a.TKO_KODEIGR', 'b.cab_kodecabang')
            ->where('a.tko_kodesbu', $kodeSBU)
            ->orderBy('a.tko_kodeomi')
            ->get()->toArray();

        return response()->json($datas);
    }

    public function editTokoOmi(Request $request){
        $kodeOmi    = $request->kodeOmi;

        $identity   = DB::table('tbmaster_tokoigr a')
            ->select('a.*', 'b.cab_namacabang', 'c.cus_namamember', 'c.cus_npwp', 'c.cus_tglpajak')
            ->leftJoin('tbmaster_customer c', 'a.tko_kodecustomer', 'c.cus_kodemember')
            ->leftJoin('tbmaster_cabang b', 'a.TKO_KODEIGR', 'b.cab_kodecabang')
            ->where('a.tko_kodeomi', $kodeOmi)
            ->orderBy('a.tko_kodeomi')
            ->get()->toArray();

        $detail     = DB::table('tbmaster_customer')->where('cus_kodemember', $identity[0]->tko_kodecustomer)->get()->toArray();

        return response()->json(['identity' => $identity, 'detail' => $detail]);
    }

    public function getBranchName(Request $request){
        $kodeigr= $request->kodeIgr;

        $branch = DB::table('tbmaster_cabang')->select('cab_namacabang')->where('cab_kodecabang', $kodeigr)->get()->toArray();

        return response()->json($branch);
    }

    public function getCustomerName(Request $request){
        $member = $request->member;

        $cust   = DB::table('tbmaster_customer')->where('cus_kodemember', $member)->get()->toArray();

        return response()->json($cust);
    }

    public function updateTokoOmi(Request $request){
        $kodeOmi=$request->kodeOmi;
        $namaOmi=strtoupper($request->namaOmi);
        $kodeIgr=$request->kodeIgr;
        $flagFee=$request->flagFee;
        $flagVb=$request->flagVb;
        $flagKph=$request->flagKph;
        $kodeCust=$request->kodeCust;
        $tglGo=$request->tglGo;
        $tglTutup=$request->tglTutup;
        $statusToko=$request->statusToko;
        $jamBuka=$request->jamBuka;
        $jamTutup=$request->jamTutup;
        $tglUpdate=$request->tglUpdate;
        $flagPB=$request->flagPB;
        $hari=$request->hari;
        $jadwalKirim = str_replace('_', ' ', $hari);
        $user   = 'JEP';
        date_default_timezone_set('Asia/Jakarta');
        $date   = date('Y-m-d H:i:s');

        DB::table('tbmaster_tokoigr')->where('tko_kodeomi', $kodeOmi)
            ->update(['tko_namaomi' => $namaOmi, 'tko_kodeigr' => $kodeIgr, 'tko_flagdistfee' => $flagFee, 'tko_flagkph' => $flagKph,
                'tko_flagvb' => $flagVb, 'tko_kodecustomer' => $kodeCust, 'tko_tglgo' => $tglGo,
                'tko_tgltutup' => $tglTutup, 'tko_statustoko' => $statusToko, 'tko_jambukatoko' => $jamBuka,
                'tko_jamtutuptoko' => $jamTutup, 'tko_tglberlakujadwal' => $tglUpdate, 'tko_flageditpb' => $flagPB,
                'tko_jadwalkirimbrg'=>$jadwalKirim, 'tko_modify_by' => $user, 'tko_modify_dt' => $date]);

        return response()->json('SUCCESS UPDATE');

    }

}
