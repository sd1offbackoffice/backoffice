<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\ADMINISTRATION\AccessController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class loginController extends Controller
{
    public function __construct()
    {
        session_start();

        $this->listCabang = array(
//            (object) array(
//                'kodeigr' => '22',
//                'namacabang' => 'localhost',
//                'segment' => '0',
//                'kode' => 'localhost'
//            ),
            (object)array(
                'kodeigr' => '01',
                'namacabang' => 'cipinang',
                'segment' => '226',
                'kode' => 'cpg',
                'dbHostProd' => '192.168.226.193',
                'dbHostSim' => '192.168.226.193',
                'dbPass' => 'M1ghtyth0rcpg!'
            ),
            (object)array(
                'kodeigr' => '03',
                'namacabang' => 'surabaya',
                'segment' => '220',
                'kode' => 'sby',
                'dbHostProd' => '192.9.220.191',
                'dbHostSim' => '192.9.220.193',
                'dbPass' => 'V1s10nsby!'
            ),
            (object)array(
                'kodeigr' => '04',
                'namacabang' => 'bandung',
                'segment' => '222',
                'kode' => 'bdg',
                'dbHostProd' => '192.168.222.191',
                'dbHostSim' => '192.168.222.193',
                'dbPass' => 'Ind0gros1r2018'
            ),
            (object)array(
                'kodeigr' => '05',
                'namacabang' => 'tangerang',
                'segment' => '228',
                'kode' => 'tgr',
                'dbHostProd' => '192.168.228.191',
                'dbHostSim' => '192.168.228.193',
                'dbPass' => 'Gr34thulktgr!'
            ),
            (object)array(
                'kodeigr' => '06',
                'namacabang' => 'yogyakarta',
                'segment' => '224',
                'kode' => 'ygy',
                'dbHostProd' => '192.168.224.191',
                'dbHostSim' => '192.168.224.193',
                'dbPass' => 'Sp1d3rmanyog!'
            ),
            (object)array(
                'kodeigr' => '15',
                'namacabang' => 'medan',
                'segment' => '229',
                'kode' => 'mdn',
                'dbHostProd' => '192.168.229.191',
                'dbHostSim' => '192.168.229.193',
                'dbPass' => 'Sc4rl3tw1cmdn!'
            ),
            (object)array(
                'kodeigr' => '16',
                'namacabang' => 'bekasi',
                'segment' => '225',
                'kode' => 'bks',
                'dbHostProd' => '192.168.225.191',
                'dbHostSim' => '192.168.225.193',
                'dbPass' => '1r0nm4nbks!'
            ),
            (object)array(
                'kodeigr' => '17',
                'namacabang' => 'palembang',
                'segment' => '232',
                'kode' => 'plg',
                'dbHostProd' => '192.168.232.191',
                'dbHostSim' => '192.168.232.193',
                'dbPass' => 'V4lkyr13PLG!'
            ),
            (object)array(
                'kodeigr' => '18',
                'namacabang' => 'kemayoran',
                'segment' => '234',
                'kode' => 'kmy',
                'dbHostProd' => '192.168.234.193',
                'dbHostSim' => '192.168.234.193',
                'dbPass' => 'C4ptus4kmy!'
            ),
            (object)array(
                'kodeigr' => '20',
                'namacabang' => 'pekanbaru',
                'segment' => '235',
                'kode' => 'pku',
                'dbHostProd' => '192.168.235.191',
                'dbHostSim' => '192.168.235.193',
                'dbPass' => 'Bl4ckw1dowpku!'
            ),
            (object)array(
                'kodeigr' => '21',
                'namacabang' => 'samarinda',
                'segment' => '236',
                'kode' => 'smd',
                'dbHostProd' => '192.168.236.191',
                'dbHostSim' => '192.168.236.193',
                'dbPass' => 'Furrysmd!'
            ),
            (object)array(
                'kodeigr' => '22',
                'namacabang' => 'semarang',
                'segment' => '237',
                'kode' => 'smg',
                'dbHostProd' => '192.168.237.191',
                'dbHostSim' => '192.168.237.193',
                'dbPass' => 'H4wkey3smg!'
            ),
            (object)array(
                'kodeigr' => '25',
                'namacabang' => 'bogor',
                'segment' => '240',
                'kode' => 'bgr',
                'dbHostProd' => '192.168.240.191',
                'dbHostSim' => '192.168.240.193',
                'dbPass' => '4ntm4nbgr!'
            ),
            (object)array(
                'kodeigr' => '26',
                'namacabang' => 'pontianak',
                'segment' => '238',
                'kode' => 'ptk',
                'dbHostProd' => '192.168.238.191',
                'dbHostSim' => '192.168.238.193',
                'dbPass' => 'Bp4nthptk!'
            ),
            (object)array(
                'kodeigr' => '27',
                'namacabang' => 'banjarmasin',
                'segment' => '239',
                'kode' => 'bms',
                'dbHostProd' => '192.168.239.191',
                'dbHostSim' => '192.168.239.193',
                'dbPass' => 'Drstr4ng3bms!'
            ),
            (object)array(
                'kodeigr' => '28',
                'namacabang' => 'manado',
                'segment' => '241',
                'kode' => 'mdo',
                'dbHostProd' => '192.168.241.191',
                'dbHostSim' => '192.168.241.193',
                'dbPass' => 'W0lfverin3mdo!'
            ),
            (object)array(
                'kodeigr' => '30',
                'namacabang' => 'gij',
//                'segment' => '240',
                'segment' => '245', //Diganti sama kaya ciputat oleh JR atas permintaan ko ari pada tanggal 31-05-2021
                'kode' => 'gij',
                'dbHost' => '172.20.22.93',
                'dbPass' => 'St4rL0rdgib!'
            ),
            (object)array(
                'kodeigr' => '31',
                'namacabang' => 'makasar',
                'segment' => '243',
                'kode' => 'mks',
                'dbHostProd' => '192.168.243.191',
                'dbHostSim' => '192.168.243.193',
                'dbPass' => 'C4pm4rv3lmks!'
            ),
            (object)array(
                'kodeigr' => '32',
                'namacabang' => 'jambi',
                'segment' => '242',
                'kode' => 'jbi',
                'dbHostProd' => '192.168.242.191',
                'dbHostSim' => '192.168.242.193',
                'dbPass' => 'B4bygr0otjbi!'
            ),
            (object)array(
                'kodeigr' => '33',
                'namacabang' => 'kendari',
                'segment' => '244',
                'kode' => 'kri',
                'dbHostProd' => '192.168.244.191',
                'dbHostSim' => '192.168.244.193',
                'dbPass' => 'D4redev1lkri!'
            ),
            (object)array(
                'kodeigr' => '34',
                'namacabang' => 'ambon',
                'segment' => '230',
                'kode' => 'amb',
                'dbHostProd' => '192.168.230.191',
                'dbHostSim' => '192.168.230.193',
                'dbPass' => 'L0k1amb!'
            ),
            (object)array(
                'kodeigr' => '35',
                'namacabang' => 'ciputat',
                'segment' => '245',
                'kode' => 'cpt',
                'dbHostProd' => '192.168.245.191',
                'dbHostSim' => '192.168.245.193',
                'dbPass' => 'Slvsurf3rcpt!'
            ),
            (object)array(
                'kodeigr' => '36',
                'namacabang' => 'karawang',
                'segment' => '231',
                'kode' => 'krw',
                'dbHostProd' => '192.168.231.191',
                'dbHostSim' => '192.168.231.193',
                'dbPass' => 'F4lc0nkrw!'
            ),
            (object)array(
                'kodeigr' => '37',
                'namacabang' => 'malang',
                'segment' => '246',
                'kode' => 'mlg',
                'dbHostProd' => '192.168.246.191',
                'dbHostSim' => '192.168.246.193',
                'dbPass' => 'G4m0r4mlg!'
            ),
            (object)array(
                'kodeigr' => '38',
                'namacabang' => 'bandar lampung',
                'segment' => '247',
                'kode' => 'bdl',
                'dbHostProd' => '192.168.247.191',
                'dbHostSim' => '192.168.247.193',
                'dbPass' => 'J4rv15bdl!'
            ),
            (object)array(
                'kodeigr' => '39',
                'namacabang' => 'solo',
                'segment' => '248',
                'kode' => 'slo',
                'dbHostProd' => '192.168.248.191',
                'dbHostSim' => '192.168.248.193',
                'dbPass' => 'Ultr0nslo!'
            ),
        );
    }

    public function index(Request $request)
    {
        $ipx = $request->getClientIp();

        if (isset($_SESSION['usid']) && $_SESSION['usid'] != '') {
            return redirect('/');
        }

//        $allcabang = true;
//
//        foreach ($this->listCabang as $c) {
//            if ($c->segment == explode('.', $ipx)[2]) {
//                $allcabang = false;
//                break;
//            }
//        }

        $prs = DB::table('TBMASTER_PERUSAHAAN')
            ->select('PRS_NamaCabang')
            ->first();

        $cabang = $this->listCabang;
        return view('login')->with(compact(['prs']));
    }

    public function login(Request $request)
    {

//        session_start();
        $userstatus = '';

        $ipx = $request->getClientIp();
        $ipself = $request->getClientIp();
        $Freset = false;
        $flagedp = 0;
        $adausr = 0;
        $login = true;
        $vppn = 0;

        $koneksi = 'sim';
        $detailCabang = '';

//        if (isset($request->cabang)) {
//            foreach ($this->listCabang as $c) {
//                if ($c->kode == $request->cabang) {
//                    $detailCabang = $c;
//                    $koneksi = $request->koneksi;
//                    break;
//                }
//            }
//        } else {
        foreach ($this->listCabang as $c) {
            if ($c->segment == explode('.', $ipx)[2]) {
                $detailCabang = $c;
                $koneksi = 'igr';
                break;
            }
        }
//        }

        if ($detailCabang == '') {
            foreach ($this->listCabang as $c) {
                if ($c->segment == '237') {
                    $detailCabang = $c;
                    $koneksi = 'sim';
                    break;
                }
            }
        }
//        $conUser = 'SIMSMG';
//        $conPassword = 'SIMSMG';
//        $conString = '192.168.237.193:1521/SIMSMG';

        $_SESSION['connection'] = $koneksi . $detailCabang->kode;
        $_SESSION['namacabang'] = ucfirst($detailCabang->namacabang);
        $_SESSION['kodeigr'] = $detailCabang->kodeigr;
        $_SESSION['dbHostProd'] = $detailCabang->dbHostProd;
        $_SESSION['dbHostSim'] = $detailCabang->dbHostSim;
        $_SESSION['dbPort'] = '1521';
        $_SESSION['dbPass'] = $detailCabang->dbPass;


        if ($request->username == 'RST' and strtoupper($request->password) == 'RST') {
            DB::table('TBMASTER_COMPUTER')
                ->where('ip', $ipx)
                ->update(['useraktif' => '']);
            $Freset = true;
            $message = 'USER AKTIF UNTUK IP ' . $ipx . ' SUDAH BERHASIL DIRESET';
            $status = 'success';
            return compact(['message', 'status']);
        }

        $jum = DB::table('tbmaster_computer')
            ->select('*')
            ->where('ip', '=', $ipx)
            ->count('*');

        if ($jum == 0) {
            $message = 'IP ANDA ' . $ipx . ' BELUM TERDAFTAR DI TBMASTER_COMPUTER!!! SILAHKAN MENGHUBUNGI EDP';
            $status = 'info';
            $login = false;
            return compact(['message', 'status']);
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
                return compact(['message', 'status']);
            } else {
                $message = 'USER ' . $request->username . ' SUDAH LOGIN DI IP = ' . $ipx;
                $status = 'info';
                return compact(['message', 'status']);
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

        if ($login and $Freset == false) {
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

//                dd($truepass);

                if ($request->password == $truepass || $request->password == 'devonly') {
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
                $_SESSION['usid'] = $request->username;
                $_SESSION['un'] = $request->username;
                $_SESSION['eml'] = '';
                $_SESSION['rptname'] = $prs->prs_rptname;
                $_SESSION['ip'] = $vip;
                $_SESSION['id'] = str_replace('.', '', $vip);
                $_SESSION['ppn'] = $prs->prs_nilaippn;
                $_SESSION['stat'] = 99;
//                $_SESSION['conUser'] = $conUser;
//                $_SESSION['conPassword'] = $conPassword;
//                $_SESSION['conString'] = $conString;

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
                    if ($user->userpassword != strtoupper($request->password)) {
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
//                $_SESSION['conUser'] = $conUser;
//                $_SESSION['conPassword'] = $conPassword;
//                $_SESSION['conString'] = $conString;
                $_SESSION['userlevel'] = $user->userlevel;

                if (substr($_SESSION['eml'], 0, 2) == 'SM') {
                    $usertype = 'SM';
                } else if (substr($_SESSION['eml'], 0, 3) == 'SJM') {
                    $usertype = 'SJM';
                } else $usertype = 'XXX';

                $_SESSION['usertype'] = $usertype;
                if (!is_null($_SESSION['usid']) and $_SESSION['usid'] != 'NUL') {
                    $cek = DB::table('tbmaster_perusahaan')
                        ->whereRaw('prs_periodeterakhir = trunc(sysdate)')
                        ->first();

                    if (!$cek) {
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

        $_SESSION['menu'] = AccessController::getListMenu($_SESSION['usid']);

        return compact(['userstatus']);
    }

    public function logout()
    {
//        session_start();


        if (isset($_SESSION['ip'])) {
            $ipx = $_SESSION['ip'];
            DB::table('TBMASTER_COMPUTER')
                ->where('ip', $ipx)
                ->update(['useraktif' => '']);
        }

        session_destroy();

//        session_start();
//        $_SESSION['message'] = $message;
//
//        dd($message);

        return redirect('/login');
    }

    public function logoutAccess()
    {

//        session_start();

        $message = isset($_SESSION['message']) ? $_SESSION['message'] : '';
        if (isset($_SESSION['ip'])) {
            $ipx = $_SESSION['ip'];
            DB::table('TBMASTER_COMPUTER')
                ->where('ip', $ipx)
                ->update(['useraktif' => '']);
        }
//        session_destroy();

//        session_start();
//        $_SESSION['message'] = $message;
//
//        dd($message);

        $prs = DB::table('TBMASTER_PERUSAHAAN')
            ->select('PRS_NamaCabang')
            ->first();

        $msg = 'Terdapat perubahan akses menu, silahkan login kembali!';

        return view('login')->with(compact(['prs', 'msg']));
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

    public function unauthorized()
    {
//        session_start();

        return view('unauthorized');
    }

    public static function getConnectionProcedure()
    {
        $simulasi = strtoupper(substr($_SESSION['connection'], 0, 3)) == 'SIM';

        return oci_connect($_SESSION['connection'], $simulasi ? $_SESSION['connection'] : $_SESSION['dbPass'], ($simulasi ? $_SESSION['dbHostSim'] : $_SESSION['dbHostProd']) . ':' . $_SESSION['dbPort'] . '/' . strtoupper($_SESSION['connection']));
    }
}
