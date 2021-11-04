<?php

namespace App\Http\Controllers\ADMINISTRATION;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class userController extends Controller
{
    public function index()
    {
        return view('ADMINISTRATION.user');
    }

    public function searchUser(Request $request)
    {
        $message = "";
        $status = "";
        if ($request->value == '') {
            $user = DB::connection($_SESSION['connection'])->table('TBMASTER_USER')
                ->select('*')
                ->whereRaw('NVL(RECORDID,\'0\') != \'1\'')
                ->orderBy('userid')
                ->get();
        } else {
            $user = DB::connection($_SESSION['connection'])->table('TBMASTER_USER')
                ->select('*')
                ->whereRaw('NVL(RECORDID,\'0\') != \'1\'')
                ->where('USERID', 'like', '%' . $request->value . '%')
                ->orderBy('userid')
                ->get();
            if (sizeof($user) == 0) {
                $message = "User tidak ditemukan!";
                $status = "error";
            }
        }
        return compact(['user', 'message', 'status']);
    }

    public function searchIp(Request $request)
    {
        $message = "";
        $status = "";
        if ($request->value == '') {
            $ip = DB::connection($_SESSION['connection'])->table('TBMASTER_COMPUTER')
                ->select('*')
                ->get();
        } else {
            $ip = DB::connection($_SESSION['connection'])->table('TBMASTER_COMPUTER')
                ->select('*')
                ->where('IP', 'like', '%' . $request->value . '%')
                ->get();
            if (sizeof($ip) == 0) {
                $message = "IP tidak ditemukan!";
                $status = "error";
            }
        }
        return compact(['ip', 'message', 'status']);
    }

    public function saveUser(Request $request)
    {
        $cek = DB::connection($_SESSION['connection'])->table('TBMASTER_USER')
            ->select('*')
            ->where('USERID', '=', $request->id)
            ->first();

        if (!is_null($cek)) {
            $message = 'User ID Sudah Ada, Silahkan Ganti User ID!';
            $status = 'error';
        } else {
            if (DB::connection($_SESSION['connection'])->table('tbmaster_user')->insert(
                ['kodeigr' => $_SESSION['kdigr'], 'userid' => $request->id, 'userpassword' => $request->password, 'userlevel' => $request->level, 'station' => $request->station, 'username' => $request->username, 'email' => $request->email, 'create_by' => $_SESSION['usid'], 'create_dt' => DB::raw('trunc(sysdate)'), 'encryptpwd' => md5($request->password), 'jabatan' => $request->jabatan])) {
                $message = 'User Berhasil Disimpan!';
                $status = 'success';
            } else {
                $message = 'User Gagal Disimpan!';
                $status = 'error';
            }
        }
        return compact(['message', 'status']);
    }

    public function updateUser(Request $request)
    {
        for ($i = 0; $i < sizeof($request->value['userid']); $i++) {
            DB::connection($_SESSION['connection'])->table('tbmaster_user')
                ->where('userid', '=', $request->value['userid'][$i])
                ->update(['userpassword' => $request->value['password'][$i], 'userlevel' => $request->value['userlevel'][$i], 'station' => $request->value['station'][$i], 'username' => $request->value['username'][$i], 'email' => $request->value['email'][$i], 'jabatan' => $request->value['jabatan'][$i], 'encryptpwd' => md5($request->value['password'][$i]), 'modify_by' => $_SESSION['usid'], 'modify_dt' => DB::RAW("trunc(sysdate)")]);
        }
        $message = 'User berhasil di update!';
        $status = 'success';
        return compact(['message', 'status']);
    }

    public function userAccess(Request $request)
    {
        $id = $request->value;
        $access = DB::connection($_SESSION['connection'])->table('tbmaster_access')->leftJoin('tbmaster_useraccess', function ($join) use ($id) {
            $join->on('tbmaster_access.accessgroup', '=', 'tbmaster_useraccess.accessgroup')
                ->on('tbmaster_access.accesscode', '=', 'tbmaster_useraccess.accesscode')
                ->on('tbmaster_useraccess.userid', DB::RAW("'" . $id . "'"))
                ->on('tbmaster_useraccess.kodeigr', '=', DB::raw($_SESSION['kdigr']));
        })
            ->selectRaw('tbmaster_access.accessgroup,
                                    tbmaster_access.accesscode,
                                    tbmaster_access.accessname,
                                    NVL (tbmaster_useraccess.baca, 0) baca,
                                    NVL (tbmaster_useraccess.tambah, 0) tambah,
                                    NVL (tbmaster_useraccess.koreksi, 0) koreksi,
                                    NVL (tbmaster_useraccess.hapus, 0) hapus')
            ->where('tbmaster_access.kodeigr', '=', $_SESSION['kdigr'])
            ->where('tbmaster_access.accessgroup', 'like', $request->accessgroup . '%')
            ->orderBy('tbmaster_access.accesscode')
            ->get();

        $accessgroup = DB::connection($_SESSION['connection'])->table('tbmaster_access')->leftJoin('tbmaster_useraccess', function ($join) use ($id) {
            $join->on('tbmaster_access.accessgroup', '=', 'tbmaster_useraccess.accessgroup')
                ->on('tbmaster_access.accesscode', '=', 'tbmaster_useraccess.accesscode')
                ->on('tbmaster_useraccess.userid', DB::RAW("'" . $id . "'"))
                ->on('tbmaster_useraccess.kodeigr', '=', DB::raw($_SESSION['kdigr']));
        })
            ->selectRaw('tbmaster_access.accessgroup')
            ->where('tbmaster_access.kodeigr', '=', $_SESSION['kdigr'])
            ->orderBy('tbmaster_access.accessgroup')
            ->distinct()
            ->get();

        return compact(['access', 'accessgroup']);
    }

    public function saveAccess(Request $request)
    {
        for ($i = 0; $i < sizeof($request->value['baca']); $i++) {
            $cek = DB::connection($_SESSION['connection'])->table('tbmaster_useraccess')
                ->select('*')
                ->where('userid', '=', $request->userid)
                ->where('accesscode', '=', $request->value['accesscode'][$i])
                ->first();

            if (!is_null($cek)) {
                DB::connection($_SESSION['connection'])->table('tbmaster_useraccess')
                    ->where('userid', '=', $request->userid)
                    ->where('accesscode', '=', $request->value['accesscode'][$i])
                    ->update(['baca' => $request->value['baca'][$i], 'tambah' => $request->value['tambah'][$i], 'koreksi' => $request->value['koreksi'][$i], 'hapus' => $request->value['hapus'][$i], 'modify_by' => $_SESSION['usid'], 'modify_dt' => DB::raw('sysdate')]);
            } else {
                $accessgroup = DB::connection($_SESSION['connection'])->table('tbmaster_access')
                    ->selectRaw('accessgroup,accessname')
                    ->where('accesscode', '=', $request->value['accesscode'][$i])
                    ->first();

                DB::connection($_SESSION['connection'])->table('tbmaster_useraccess')->insert(
                    ['userid' => $request->userid,
                        'accessgroup' => $accessgroup->accessgroup,
                        'accesscode' => $request->value['accesscode'][$i],
                        'baca' => $request->value['baca'][$i],
                        'tambah' => $request->value['tambah'][$i],
                        'koreksi' => $request->value['koreksi'][$i],
                        'hapus' => $request->value['hapus'][$i],
                        'kodeigr' => $_SESSION['kdigr'],
                        'create_dt' => DB::Raw('sysdate'),
                        'create_by' => $_SESSION['usid']
                    ]);
            }
        }
        $message = 'Akses berhasil di update!';
        $status = 'success';

        return compact(['message', 'status']);
    }
    public function saveIp(Request $request)
    {
        $cek = DB::connection($_SESSION['connection'])->table('TBMASTER_COMPUTER')
            ->select('*')
            ->where('IP', '=', $request->ip)
            ->orWhere('station', '=', $request->station)
            ->first();

        if (!is_null($cek)) {
            $message = 'IP / Station Sudah Ada, Silahkan Ganti IP / Station!';
            $status = 'error';
        } else {
            if (DB::connection($_SESSION['connection'])->table('TBMASTER_COMPUTER')->insert(
                ['ip' => $request->ip, 'station' => $request->station, 'computername' => $request->computername, 'create_by' => $_SESSION['usid'], 'create_dt' => DB::raw('sysdate'), 'kodeigr' => $_SESSION['kdigr']])) {
                $message = 'IP Berhasil Disimpan!';
                $status = 'success';
            } else {
                $message = 'IP Gagal Disimpan!';
                $status = 'error';
            }
        }
        return compact(['message', 'status']);
    }
    public function updateIp(Request $request)
    {
        for ($i = 0; $i < sizeof($request->value['ip']); $i++) {
            DB::connection($_SESSION['connection'])->table('TBMASTER_COMPUTER')
                ->where('ip', '=', $request->value['ip'][$i])
                ->update(['station' => $request->value['station'][$i], 'computername' => $request->value['computername'][$i], 'modify_by' => $_SESSION['usid'], 'modify_dt' => DB::RAW('sysdate')]);
        }
        $message = 'IP berhasil di update!';
        $status = 'success';
        return compact(['message', 'status']);
    }
}
