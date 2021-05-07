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
        $conUser = 'SIMSMG';
        $conPassword = 'SIMSMG';
        $conString = '192.168.237.193:1521/SIMSMG';

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
            $status = 'success';
            return compact(['message','status']);
        }

        $jum = DB::table('tbmaster_computer')
            ->select('*')
            ->where('ip', '=', $ipx)
            ->count('*');

        if ($jum == 0) {
            $message = 'IP ANDA ' . $ipx . ' BELUM TERDAFTAR DI TBMASTER_COMPUTER!!! SILAHKAN MENGHUBUNGI EDP';
            $status = 'info';
            $login = false;
            return compact(['message','status']);
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
                $status = 'info';
                return compact(['message','status']);
            } else {
                $message = 'USER ' . $request->username . ' SUDAH LOGIN DI IP = ' . $ipx;
                $status = 'info';
                return compact(['message','status']);
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
                dd($truepass);
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
                $_SESSION['id'] = str_replace('.', '', $vip);
                $_SESSION['ppn'] = $prs->prs_nilaippn;
                $_SESSION['stat'] = 99;
                $_SESSION['conUser'] = $conUser;
                $_SESSION['conPassword'] = $conPassword;
                $_SESSION['conString'] = $conString;

                DB::table('TBMASTER_PERUSAHAAN')
                    ->update([
                        'PRS_PERIODETERAKHIR' => DB::Raw('trunc(sysdate)'),
                        'PRS_MODIFY_BY' => $_SESSION['usid'],
                        'PRS_MODIFY_DT' => DB::Raw('sysdate')
                    ]);

            } else {
                $user = DB::table('tbmaster_user')
                    ->selectRaw('userid, username, userpassword, email, encryptpwd, userlevel')
                    ->whereRaw('nvl(recordid, \'0\') <> \'1\'')
                    ->where('userid', $request->username)
                    ->first();

                if (!$user) {
                    $message = 'User Tidak Ditemukan!';
                    $status = 'error';
                    return compact(['message', 'status']);
                } else {
                    if ($user->encryptpwd != md5($request->password)) {
                        $message = 'User / Password Salah!';
                        $status = 'error';
                        return compact(['message', 'status']);
                    }
                }
                $_SESSION['kdigr'] = $prs->prs_kodeigr;
                $_SESSION['usid'] = $user->userid;
                $_SESSION['un'] = $user->username;
                $_SESSION['eml'] = $user->email;
                $_SESSION['rptname'] = $prs->prs_rptname;
                $_SESSION['ip'] = $vip;
                $_SESSION['id'] = str_replace('.', '', $vip);
                $_SESSION['ppn'] = $prs->prs_nilaippn;
                $_SESSION['conUser'] = $conUser;
                $_SESSION['conPassword'] = $conPassword;
                $_SESSION['conString'] = $conString;
                $_SESSION['userlevel'] = $user->userlevel;

                if(substr($_SESSION['eml'],0,2) == 'SM'){
                    $usertype = 'SM';
                }
                else if(substr($_SESSION['eml'],0,3) == 'SJM'){
                    $usertype = 'SJM';
                }
                else $usertype = 'XXX';

                $_SESSION['usertype'] = $usertype;

                if (!is_null($_SESSION['usid']) AND $_SESSION['usid'] != 'NUL') {
                    $cek = DB::table('tbmaster_perusahaan')
                        ->whereRaw('prs_periodeterakhir = trunc(sysdate)')
                        ->first();

                    if(!$cek){
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
                            $userstatus = 'ADM';

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
                            $userstatus = 'USR';
                        }
                    }
                }
            }
        }

        $_SESSION['menu'] = DB::table('tbmaster_access_migrasi')
            ->whereRaw("acc_url <> ' '")
            ->orderBy('acc_group','asc')
            ->orderBy('acc_subgroup1','asc')
            ->orderBy('acc_subgroup2','asc')
            ->orderBy('acc_subgroup3','asc')
            ->orderBy('acc_name','asc')
            ->get();

        return compact(['userstatus']);
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
                ['ip' => $ipx, 'station' => rand(1, 9), 'computername' => 'SERVER', 'useraktif' => '', 'create_by' => 'WEB', 'create_dt' => '', 'modify_dt' => '', 'kodeigr' => '22', 'recordid' => '']);
            $message = 'IP berhasil didaftarkan!';
            $status = 'success';
        }
        return compact(['message', 'status']);

    }
}
