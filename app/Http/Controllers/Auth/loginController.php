<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class loginController extends Controller
{
    public function index()
    {
        session_start();
        if (isset($_SESSION['usid']) && $_SESSION['usid'] != '') {
            return redirect('/');
        }
        $prs = DB::table('TBMASTER_PERUSAHAAN')
            ->select('PRS_NamaCabang')
            ->first();
        return view('login')->with(compact(['prs']));
    }

    public function login(Request $request)
    {

        session_start();

        $ipx = $request->getClientIp();
        $ipself = $request->getClientIp();
        $Freset = false;
        $flagedp = 0;
        $adausr = 0;
        $login = true;
        $vppn = 0;

        if ($request->username == 'RST' AND strtoupper($request->password) == 'RST') {
            DB::table('TBMASTER_COMPUTER')
                ->where('ip', $ipx)
                ->update(['useraktif' => '']);
            $Freset = true;
            $message = 'USER AKTIF UNTUK IP ' . $ipx . ' SUDAH BERHASIL DIRESET';

            return compact('message');
        }

        $jum = DB::table('tbmaster_computer')
            ->select('*')
            ->where('ip', '=', $ipx)
            ->count('*');

        if ($jum == 0) {
            $message = 'IP ANDA ' . $ipx . ' BELUM TERDAFTAR DI TBMASTER_COMPUTER!!! SILAHKAN MENGHUBUNGI EDP';
            $login = false;
            return compact('message');
        }
        $ipx = DB::table('tbmaster_computer')
            ->select('ip')
            ->where('useraktif', $request->username)
            ->first();
        if (!is_null($ipx)) {
            $adausr = 1;
            $ipx = $ipx->ip;
        }
        if ($adausr == 1) {
            if ($ipx == $ipself) {

                $message = 'Untuk Melakukan RESET Silahkan Login Kembali Dengan :' . chr(10) . chr(13) .
                    'USER : RST' . chr(10) . chr(13) .
                    'PASS : RST' . chr(10) . chr(13);
                return compact('message');
            } else {
                $message = 'USER ' . $request->username . ' SUDAH LOGIN DI IP = ' . $ipx;
                return compact('message');
            }
            $login = false;
        } else {
            $usraktif = '';
            $ipx = $request->getClientIp();
            $ip = DB::table('tbmaster_computer')
                ->select('*')
                ->where('ip', $ipx)
                ->get();
            for ($i = 0; $i < sizeof($ip); $i++) {
                $usraktif = $ip[$i]->useraktif;
            }
            if (!is_null($usraktif)) {
                if ($jum > 0) {
                    $message = 'USER ' . $usraktif . ' SUDAH LOGIN DI KOMPUTER INI';
                }
                $login = false;
            }
        }

        if ($login AND $Freset == false) {
            $ipx = $request->getClientIp();
            $prs = DB::table('tbmaster_perusahaan')
                ->selectRaw('prs_kodeigr, prs_rptname, prs_nilaippn, prs_namacabang, prs_periodeterakhir')
                ->first();
            $vip = $request->getClientIp();

            if ($request->username == 'EDP') {
                $tgl = date('d-m-Y H:i:s');
                $truepass =
                    SUBSTR($tgl, 15, 1)
                    . SUBSTR($tgl, 12, 1)
                    . SUBSTR($tgl, 14, 1)
                    . SUBSTR($tgl, 11, 1)
                    . SUBSTR($tgl, 17, 1)
                    . SUBSTR($tgl, 1, 1);
                if ($request->password == $truepass) {
                    $flagedp = 1;
                    DB::table('tbmaster_computer')
                        ->where('ip', $ipx)
                        ->update(['useraktif' => $request->username]);
                } else {
                    $flagedp = 0;
                    $message = 'INCORRECT USERNAME OR PASSWORD ';
                }
            }

            if ($flagedp == 1) {
                $_SESSION['kdigr'] = $prs->prs_kodeigr;
                $_SESSION['usid'] = 'EDP';
                $_SESSION['un'] = 'EDP';
                $_SESSION['eml'] = '';
                $_SESSION['rptname'] = $prs->prs_rptname;
                $_SESSION['ip'] = $vip;
                $_SESSION['id'] = str_replace('.','',$vip);
                $_SESSION['ppn'] = $prs->prs_nilaippn;
                $_SESSION['stat'] = 99;

                DB::table('TBMASTER_PERUSAHAAN')
                    ->update([
                        'PRS_PERIODETERAKHIR' => DB::Raw('trunc(sysdate)'),
                        'PRS_MODIFY_BY' => $_SESSION['usid'],
                        'PRS_MODIFY_DT' => DB::Raw('sysdate')
                    ]);

            } else {
                $user = DB::table('tbmaster_user')
                    ->selectRaw('userid, username, userpassword, email, encryptpwd')
                    ->whereRaw('nvl(recordid, \'0\') <> \'1\'')
                    ->where('userid', $request->username)
                    ->first();

                if (!$user) {
                    $message = 'User Tidak Ditemukan!';
                    return compact('message');
                }else{
                    if($user->encryptpwd != md5($request->password)){
                        $message = 'User / Password Salah!';
                        return compact('message');
                    }
                }
                $_SESSION['kdigr'] = $prs->prs_kodeigr;
                $_SESSION['usid'] = $user->userid;
                $_SESSION['un'] = $user->username;
                $_SESSION['eml'] = $user->email;
                $_SESSION['rptname'] = $prs->prs_rptname;
                $_SESSION['ip'] = $vip;
                $_SESSION['id'] = str_replace('.','',$vip);
                $_SESSION['ppn'] = $prs->prs_nilaippn;

                if (!is_null($_SESSION['usid']) AND $_SESSION['usid'] != 'NUL') {
                    if ($_SESSION['usid'] == 'ADM') {
                        DB::table('TBMASTER_PERUSAHAAN')
                            ->update([
                                'PRS_PERIODETERAKHIR' => DB::Raw('trunc(sysdate)'),
                                'PRS_MODIFY_BY' => $_SESSION['usid'],
                                'PRS_MODIFY_DT' => DB::Raw('sysdate')
                            ]);

                        DB::table('tbmaster_computer')
                            ->where('ip', $ipx)
                            ->update(['useraktif' => $request->username]);
                        $status = 'ADM';

                    } else {
                        DB::table('TBMASTER_PERUSAHAAN')
                            ->update([
                                'PRS_PERIODETERAKHIR' => DB::Raw('trunc(sysdate)'),
                                'PRS_MODIFY_BY' => $_SESSION['usid'],
                                'PRS_MODIFY_DT' => DB::Raw('sysdate')
                            ]);

                        DB::table('tbmaster_computer')
                            ->where('ip', $ipx)
                            ->update(['useraktif' => $request->username]);
                        $status = 'USR';
                    }
                }
            }
        }

        return compact(['status']);
    }

    public function logout()
    {
        $ipx = $_SESSION['ip'];
        DB::table('TBMASTER_COMPUTER')
            ->where('ip', $ipx)
            ->update(['useraktif' => '']);
        session_destroy();
        return redirect('/');
    }

    public function insertip(Request $request)
    {
        $ipx = $request->getClientIp();
        $temp = DB::table('TBMASTER_COMPUTER')
            ->where('ip', $ipx)
            ->first();

        if (!is_null($temp)) {
            $message = 'IP sudah ada! jangan pencet-pencet terus!';
            $status = 'error';
        } else {
            DB::table('tbmaster_computer')->insert(
                ['ip' => $ipx, 'station' => rand(1,9), 'computername' => 'SERVER', 'useraktif' => '', 'create_by' => 'WEB', 'create_dt' => '', 'modify_dt' => '', 'kodeigr' => '22', 'recordid' => '']);
            $message = 'IP berhasil didaftarkan!';
            $status = 'success';
        }
        return compact(['message','status']);

    }
}
