<?php

namespace App\Http\Controllers\MASTER;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class omiController extends Controller
{
    public function index(){
        return view('MASTER.omi');
    }

    public function getTokoOmi(Request $request){
        $kodeSBU    = $request->kodeSBU;

        $datas      = DB::connection($_SESSION['connection'])->table('tbmaster_tokoigr a')
            ->select('a.*', 'b.cab_namacabang', 'c.cus_namamember')
            ->leftJoin('tbmaster_customer c', 'a.tko_kodecustomer', 'c.cus_kodemember')
            ->leftJoin('tbmaster_cabang b', 'a.TKO_KODEIGR', 'b.cab_kodecabang')
            ->where('a.tko_kodesbu', $kodeSBU)
            ->orderBy('a.tko_kodeomi')
            ->get()->toArray();

        return Datatables::of($datas)->make(true);
//        return response()->json($datas);
    }

    public function detailTokoOmi(Request $request){
        $kodeOmi    = $request->kodeOmi;

        $identity   = DB::connection($_SESSION['connection'])->table('tbmaster_tokoigr a')
            ->select('a.*', 'b.cab_namacabang', 'c.cus_namamember', 'c.cus_npwp', 'c.cus_tglpajak')
            ->leftJoin('tbmaster_customer c', 'a.tko_kodecustomer', 'c.cus_kodemember')
            ->leftJoin('tbmaster_cabang b', 'a.TKO_KODEIGR', 'b.cab_kodecabang')
            ->where('a.tko_kodeomi', $kodeOmi)
            ->orderBy('a.tko_kodeomi')
            ->get()->toArray();

        if ($identity){
            $detail     = DB::connection($_SESSION['connection'])->table('tbmaster_customer')->where('cus_kodemember', $identity[0]->tko_kodecustomer)->get()->toArray();

            return response()->json(['kode' => 1,'identity' => $identity, 'detail' => $detail]);
        } else {
            return response()->json(['kode' => 0]);
        }
    }

    public function getBranchName(Request $request){
        $kodeigr= $request->kodeIgr;

        $branch = DB::connection($_SESSION['connection'])->table('tbmaster_cabang')->select('cab_namacabang')->where('cab_kodecabang', $kodeigr)->get()->toArray();

        return response()->json($branch);
    }

    public function getCustomerName(Request $request){
        $member = $request->member;

        $cust   = DB::connection($_SESSION['connection'])->table('tbmaster_customer')->where('cus_kodemember', $member)->get()->toArray();

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
//        $tglGo=$request->tglGo;
//        $tglTutup=$request->tglTutup;
        $tglGo      = ($request->tglGo) ? DB::raw( "to_date('$request->tglGo', 'DD/MM/YYYY')") : '';
        $tglTutup   = ($request->tglTutup) ?DB::raw( "to_date('$request->tglTutup', 'DD/MM/YYYY')") : '';
        $statusToko=$request->statusToko;
        $jamBuka=$request->jamBuka;
        $jamTutup=$request->jamTutup;
        $tglUpdate= ($request->tglUpdate) ?DB::raw( "to_date('$request->tglUpdate', 'DD/MM/YYYY')") : '';;
        $flagPB=$request->flagPB;
        $hari=$request->hari;
        $jadwalKirim = str_replace('_', ' ', $hari);
        $user   = $_SESSION['usid'];
        date_default_timezone_set('Asia/Jakarta');
        $date   = date('Y-m-d H:i:s');

//        dd($request->tglTutup);

        DB::connection($_SESSION['connection'])->table('tbmaster_tokoigr')->where('tko_kodeomi', $kodeOmi)
            ->update(['tko_namaomi' => $namaOmi, 'tko_kodeigr' => $kodeIgr, 'tko_flagdistfee' => $flagFee, 'tko_flagkph' => $flagKph,
                'tko_flagvb' => $flagVb, 'tko_kodecustomer' => $kodeCust, 'tko_tglgo' => $tglGo,
                'tko_tgltutup' => $tglTutup, 'tko_statustoko' => $statusToko, 'tko_jambukatoko' => $jamBuka,
                'tko_jamtutuptoko' => $jamTutup, 'tko_tglberlakujadwal' => $tglUpdate, 'tko_flageditpb' => $flagPB,
                'tko_jadwalkirimbrg'=>$jadwalKirim, 'tko_modify_by' => $user, 'tko_modify_dt' => $date]);

        return response()->json('SUCCESS UPDATE');

    }

    public function tambahTokoOmi(Request $request){
        $kodeSBU    =$request->kodeSBU;
        $namaSBU    ='';
        $kodeOmi    =$request->kodeOmi;
        $namaOmi    =strtoupper($request->namaOmi);
        $kodeCabang =$request->kodeIgr;
        $flagFee    =$request->flagFee;
        $flagVb     =$request->flagVb;
        $flagKph    =$request->flagKph;
        $kodeCust   =$request->kodeCust;
//        $tglGo      = ($request->tglGo) ? date('Y/m/d', strtotime($request->tglGo)) : '';
        $tglGo      = ($request->tglGo) ? DB::raw( "to_date('$request->tglGo', 'DD/MM/YYYY')") : '';
        $tglTutup   = ($request->tglTutup) ?DB::raw( "to_date('$request->tglTutup', 'DD/MM/YYYY')") : '';
        $user       = $_SESSION['usid'];
        $kodeigr    = $_SESSION['kdigr'];
        date_default_timezone_set('Asia/Jakarta');
        $date   = date('Y-m-d H:i:s');

//        dd($tglGo);

        if ($kodeSBU == 'O') $namaSBU = 'OMI';
        elseif ($kodeSBU == 'M') $namaSBU = 'MRO';
        elseif ($kodeSBU == 'K') $namaSBU = 'CHARMANT';
        elseif ($kodeSBU == 'C') $namaSBU = 'IDM CONV';
        elseif ($kodeSBU == 'I') $namaSBU = 'INDOMARET';

        DB::connection($_SESSION['connection'])->table('tbmaster_tokoigr')->insert(['TKO_KODEIGR' => $kodeigr, 'TKO_KODESBU' => $kodeSBU, 'TKO_NAMASBU' => $namaSBU, 'TKO_KODEOMI' => $kodeOmi, 'tko_namaomi' => $namaOmi,
                'TKO_KODECABANG' => $kodeCabang, 'tko_flagdistfee' => $flagFee, 'tko_flagkph' => $flagKph,
                'tko_flagvb' => $flagVb, 'tko_kodecustomer' => $kodeCust, 'tko_tglgo' => $tglGo,
                'tko_tgltutup' => $tglTutup, 'tko_create_by' => $user, 'tko_create_dt' => $date]);

        return response()->json('Data berhasil ditambahkan');
    }

    public function confirmEdit(Request $request){
        $confirmUser    = $request->confirmUser;
        $confirmPass    = $request->confirmPass;
        $updateMKTHO    = $request->updateMKTHO;
        $kodeomiEditExpand  = $request->kodeomiEditExpand;
        $columnEditExpand   = $request->columnEditExpand;
        $valueEditExpand    = $request->valueEditExpand;
        $kodeSBU    = $request->kodeSBU;

        $password   = DB::connection($_SESSION['connection'])->select("select LPAD(SUBSTR(TO_CHAR(SYSDATE,'ddmmyy'),5,2)+1,2,0) ||
                                                LPAD(SUBSTR(TO_CHAR(SYSDATE,'ddmmyy'),3,2)+2,2,0) ||
                                                LPAD(SUBSTR(TO_CHAR(SYSDATE,'ddmmyy'),1,2)+1,2,0) as password
                                                from dual");
        $password   = $password[0]->password;
        $user       = $_SESSION['usid'];
        date_default_timezone_set('Asia/Jakarta');
        $date   = date('Y-m-d H:i:s');
        $kodeigr    = $_SESSION['kdigr'];

        if ($confirmUser != "OM123" || $confirmPass != $password){
            return response()->json(['kode' => 0, 'msg' => "Anda Tidak Berhak Untuk Mengedit !!'", 'data' => '']);
        }

        if($columnEditExpand == 'tko_flagdistfee'){
            DB::connection($_SESSION['connection'])->table('tbmaster_tokoigr')->where('tko_kodeomi', $kodeomiEditExpand)->where('tko_kodesbu', $kodeSBU)
                ->update(['tko_flagdistfee' => $valueEditExpand, 'tko_MODIFY_BY' => $user, 'tko_MODIFY_DT' => $date]);
        }
        elseif($columnEditExpand == "tko_persendistributionfee"){
            if($kodeSBU != 'I'){
                DB::connection($_SESSION['connection'])->table('tbmaster_tokoigr')->where('tko_kodeomi', $kodeomiEditExpand)
                    ->update(['tko_persendistributionfee' => $valueEditExpand.'.00', 'tko_MODIFY_BY' => $user, 'tko_MODIFY_DT' => $date]);

                if ($updateMKTHO == 'Y'){
                    // ---------------- DIKOMEN SUPAYA GK GANGGU PRODUCTION
//                    DB::connection($_SESSION['connection'])->select("	UPDATE tbmaster_tokoigr@igrmktho
//                                        SET tko_persendistributionfee = '$$valueEditExpand',
//                                        tko_MODIFY_BY = '$user', tko_MODIFY_DT = '$date'
//                                        WHERE tko_kodesbu = '$kodeSBU'
//                                            and tko_kodeomi = '$kodeomiEditExpand' and tko_kodeigr = '$kodeigr'");
//
//                    $connection = loginController::getConnectionProcedure();
//                    $exec = oci_parse($connection, "BEGIN  sp_upd_df_omi_web(:kodeomi,:kodeigr,:sukses,:errm); END;"); //Diganti karna proc yg asli pakai boolean
//                    oci_bind_by_name($exec, ':kodeomi',$kodeomiEditExpand,100);
//                    oci_bind_by_name($exec, ':kodeigr',$kodeigr,100);
//                    oci_bind_by_name($exec, ':sukses',$sukses,100);
//                    oci_bind_by_name($exec, ':errm', $errm,1000);
//                    oci_execute($exec);
//
//                    if (!$sukses){
//                        return response()->json(['kode' => 0, 'msg' => $errm, 'data' => '']);
//                    }
                }
            } else {
                 return response()->json(['kode' => 0, 'msg' => " Indomaret Tidak Ada Nilai Fee nya !!'", 'data' => '']);
            }
        }
        elseif($columnEditExpand == "tko_persenmargin"){
            if($kodeSBU != 'O'){
                DB::connection($_SESSION['connection'])->table('tbmaster_tokoigr')->where('tko_kodeomi', $kodeomiEditExpand)->where('tko_kodesbu', $kodeSBU)
                    ->update(['tko_persenMargin' => $valueEditExpand, 'tko_MODIFY_BY' => $user, 'tko_MODIFY_DT' => $date]);
            } else {
                return response()->json(['kode' => 0, 'msg' => " OMI Tidak Ada Nilai Margin nya !!'", 'data' => '']);
            }
        }
        elseif($columnEditExpand == "tko_flagsubsidipemanjangan"){
            if($valueEditExpand == 'T'){
                DB::connection($_SESSION['connection'])->table('tbmaster_tokoigr')->where('tko_kodeomi', $kodeomiEditExpand)->where('tko_kodesbu', $kodeSBU)
                    ->update(['tko_flagsubsidiPemanjangan' => '', 'tko_MODIFY_BY' => $user, 'tko_MODIFY_DT' => $date]);
            } else {
                DB::connection($_SESSION['connection'])->table('tbmaster_tokoigr')->where('tko_kodeomi', $kodeomiEditExpand)->where('tko_kodesbu', $kodeSBU)
                    ->update(['tko_flagsubsidiPemanjangan' => $valueEditExpand, 'tko_MODIFY_BY' => $user, 'tko_MODIFY_DT' => $date]);
            }
        }
        elseif($columnEditExpand == "tko_flagcreditlimitomi"){
            if($valueEditExpand == 'T'){
                DB::connection($_SESSION['connection'])->table('tbmaster_tokoigr')->where('tko_kodeomi', $kodeomiEditExpand)->where('tko_kodesbu', $kodeSBU)
                    ->update(['tko_flagCreditLimitOMI' => '', 'tko_MODIFY_BY' => $user, 'tko_MODIFY_DT' => $date]);
            } else {
                DB::connection($_SESSION['connection'])->table('tbmaster_tokoigr')->where('tko_kodeomi', $kodeomiEditExpand)->where('tko_kodesbu', $kodeSBU)
                    ->update(['tko_flagCreditLimitOMI' => $valueEditExpand, 'tko_MODIFY_BY' => $user, 'tko_MODIFY_DT' => $date]);
            }
        }
        elseif($columnEditExpand == "tko_tipeomi"){
            if($valueEditExpand == 'T'){
                DB::connection($_SESSION['connection'])->table('tbmaster_tokoigr')->where('tko_kodeomi', $kodeomiEditExpand)->where('tko_kodesbu', $kodeSBU)
                    ->update(['tko_tipeOMI' => '', 'tko_MODIFY_BY' => $user, 'tko_MODIFY_DT' => $date]);
            } else {
                DB::connection($_SESSION['connection'])->table('tbmaster_tokoigr')->where('tko_kodeomi', $kodeomiEditExpand)->where('tko_kodesbu', $kodeSBU)
                    ->update(['tko_tipeOMI' => $valueEditExpand, 'tko_MODIFY_BY' => $user, 'tko_MODIFY_DT' => $date]);
            }
        }

        return response()->json(['kode' => 1, 'msg' => "Perubahan berhasil di simpan !!'", 'data' => '']);
    }

}
