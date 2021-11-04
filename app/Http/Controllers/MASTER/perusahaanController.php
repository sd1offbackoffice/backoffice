<?php

namespace App\Http\Controllers\MASTER;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;


class perusahaanController extends Controller
{
    public function index()
    {
        $result = DB::connection($_SESSION['connection'])->table('tbmaster_perusahaan')->SELECT("*")->First();
        return view('MASTER.perusahaan')->with('result', $result);

    }

    public function update(Request $request)
    {
        $username = strtoupper($request->username);
        $password = $request->password;
        $obj = $request->obj;
        $kph = $request->kph;
        $cmo = $request->cmo;
        $tglcmo = $request->tglcmo;

        $temp = DB::connection($_SESSION['connection'])->table('TBMASTER_USER')
            ->where('userid', '=', $username)
            ->where('userpassword', '=', $password)
            ->count();

        if ($temp == 0) {
            $status = 'error';
            $message = 'Kode User / Password Anda Salah !!!';
            return compact(['status', 'message']);

        }

        $temp = DB::connection($_SESSION['connection'])->table('TBMASTER_USER')
            ->where('userid', '=', $username)
            ->where('userpassword', '=', $password)
            ->whereRaw("UPPER(SUBSTR(EMAIL, 1, 2)) = 'SM'")
            ->count();

        if ($temp == 0) {
            $status = 'error';
            $message = 'Anda tidak Berhak Mengubah Nilai !!';
            return compact(['status', 'message']);

        } else {
            if ($obj == 'kph') {
                DB::connection($_SESSION['connection'])->table('tbmaster_perusahaan')
                    ->update([
                        'PRS_KPHCONST' => $kph
                    ]);
                $status = 'success';
                $message = 'Nilai Faktor Pengali KPH Mean sudah diupdate';
                return compact(['status', 'message']);
            }
            else if ($obj == 'cmo') {
                DB::connection($_SESSION['connection'])->table('tbmaster_perusahaan')
                    ->update([
                        'PRS_FLAGCMO' => $cmo
                    ]);
                $status = 'success';
                $message = 'Flag CMO sudah diupdate';
                return compact(['status', 'message']);
            }
            else if ($obj == 'tglcmo') {
                DB::connection($_SESSION['connection'])->table('tbmaster_perusahaan')
                    ->update([
                        'PRS_TGLCMO' => DB::raw("to_date('".$tglcmo."','dd/mm/yyyy')")
                    ]);
                $status = 'success';
                $message = 'Tanggal CMO sudah diupdate';
                return compact(['status', 'message']);
            }

        }

    }

}
