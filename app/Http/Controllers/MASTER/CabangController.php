<?php

namespace App\Http\Controllers\MASTER;

use App\Http\Controllers\Auth\loginController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller; use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller; use Illuminate\Support\Facades\Session;
use Mockery\Exception;

class CabangController extends Controller
{
    public function test(Request $request){
         return 'asddsa';
    }

    public function index(){
        $getCabang  = DB::connection(Session::get('connection'))->table('tbmaster_cabang')->orderBy('cab_kodecabang')->get();

        return view('MASTER.cabang', compact('getCabang'));
    }

    public function getDetailCabang(Request $request){
        $kodeigr    = $request->kodeigr;

        $getDetail  = DB::connection(Session::get('connection'))->table('tbmaster_cabang')->select('*')->where('cab_kodecabang', $kodeigr)->get();
        return response()->json($getDetail);
    }

    public function editDataCabang(Request $request){
        $namacabang = $request->namacabang;
        $alamat1    = $request->alamat1;
        $alamat2    = $request->alamat2;
        $alamat3    = $request->alamat3;
        $faximile   = $request->faximile;
        $telephone  = $request->telephone;
        $kodeigr    = $request->kodeigr;
        $npwp       = $request->npwp;
        $nosk       = $request->nosk;
        $tglsk      = $request->tglsk;
        $kodeanakcab= $request->kodeanakcab;
        $namaanakcab= $request->namaanakcab;
        date_default_timezone_set('Asia/Jakarta');
        $date       = date('Y-m-d H:i:s');
        $user       = Session::get('usid');

        $cekKodeigr = DB::connection(Session::get('connection'))->table('tbmaster_cabang')->select('cab_kodecabang')->where('cab_kodecabang', $kodeigr)->get()->toArray();
        $getKodeigr = DB::connection(Session::get('connection'))->table('tbmaster_perusahaan')->first();

        if (!$cekKodeigr) {
            DB::connection(Session::get('connection'))->table('tbmaster_cabang')->insert(['cab_kodeigr' => $getKodeigr->prs_kodeigr,'cab_kodecabang' => $kodeigr, 'cab_namacabang' => strtoupper($namacabang), 'cab_alamat1' => $alamat1, 'cab_alamat2' => $alamat2,
                'cab_alamat3' => $alamat3, 'cab_teleponcabang' => $telephone, 'cab_faxcabang' => $faximile, 'cab_npwpcabang' => $npwp, 'cab_nosk' => $nosk, 'cab_tglsk' => $tglsk, 'cab_kodecabang_anak' => $kodeanakcab, 'cab_namacabang_anak' => $namaanakcab,
                'cab_create_by' => $user, 'cab_create_dt' => $date]);

            return response()->json("Insert Data Berhasil");
        } else {
            DB::connection(Session::get('connection'))->table('tbmaster_cabang')->where('cab_kodecabang', $kodeigr)->update(['cab_kodecabang' => $kodeigr, 'cab_namacabang' => strtoupper($namacabang), 'cab_alamat1' => $alamat1, 'cab_alamat2' => $alamat2,
                'cab_alamat3' => $alamat3, 'cab_teleponcabang' => $telephone, 'cab_faxcabang' => $faximile, 'cab_npwpcabang' => $npwp, 'cab_nosk' => $nosk, 'cab_tglsk' => $tglsk, 'cab_kodecabang_anak' => $kodeanakcab, 'cab_namacabang_anak' => $namaanakcab,
                'cab_modify_by' => $user, 'cab_modify_dt' => $date]);

            return response()->json("Update Data Berhasil");
        }
    }

    public function transDataAnakCab(Request $request){
        $kodeigr    = Session::get('kdigr');
        date_default_timezone_set('Asia/Jakarta');
        $date       = date('ymd');
        $errm       = '';
        $filecmo    = 'DCIGRIDMCMO'.$date.'.'.$kodeigr;
        $connection = loginController::getConnectionProcedure();

        try{
            $exec = oci_parse($connection, "BEGIN  sp_downloadcmo_cabang(:kodeigr,:filecmo,:errm); END;");
            oci_bind_by_name($exec, ':kodeigr',$kodeigr,100);
            oci_bind_by_name($exec, ':filecmo', $filecmo,1000);
            oci_bind_by_name($exec, ':errm', $errm,1000);
            oci_execute($exec);

            if (!$errm){
                $s = oci_parse($connection, "BEGIN  sp_trf_cmo_cabang_web(:filecmo,:sukses,:value); END;"); /*PROCEDURE ASLI sp_trf_cmo_cabang  DENGAN PARAMETER BOOL DAN DIUBAH MENJADI VARCHAR*/
                oci_bind_by_name($s, ':filecmo',$filecmo,100);
                oci_bind_by_name($s, ':sukses', $sukses,1000);
                oci_bind_by_name($s, ':value', $result,1000);
                oci_execute($s);

                if (!$sukses){
                    $msg = "cek ".$result;
                    return response()->json(["msg" => $msg, "kode" => 0]);
                } else {
                    $msg = "Data Cabang Sudah Selesai di Transfer !!";
                    return response()->json(["msg" => $msg, "kode" => 1]);
                }
            } else {
                $msg = $errm;
                return response()->json(["msg" => $msg, "kode" => 0]);
            }
        } catch (\Exception $catch){
            $msg = "Call Procedure Failed";
            return response()->json(["msg" => $msg, "kode" => 0]);

        }
    }

    public function test2(Request $request){
        $test = $request->test;

        return $test;
    }
}

/*
 $c = loginController::getConnectionProcedure();

		$s = oci_parse($c, "BEGIN :ret := F_IGR_GET_NOMOR('18','S','Nomor Sortir Barang','S'
							|| TO_CHAR (SYSDATE, 'yy')
							|| SUBSTR ('123456789ABC', TO_CHAR (SYSDATE, 'MM'), 1),
							5,FALSE); END;");
		oci_bind_by_name($s, ':ret', $r, 32);
		oci_execute($s);
		return $r;

$c = loginController::getConnectionProcedure();

		$s = oci_parse($c, "BEGIN :ret := F_IGR_GET_NOMOR('18','S','Nomor Sortir Barang','S'
							|| TO_CHAR (SYSDATE, 'yy')
							|| SUBSTR ('123456789ABC', TO_CHAR (SYSDATE, 'MM'), 1),
							5,FALSE); END;");
		oci_bind_by_name($s, ':ret', $r, 32);
		oci_execute($s);
		return $r;
 * */


