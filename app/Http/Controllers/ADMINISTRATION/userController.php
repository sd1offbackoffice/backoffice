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
        $user = DB::table('TBMASTER_USER')
            ->select('*')
            ->whereRaw('NVL(RECORDID,\'0\') != \'1\'')
            ->orderBy('userid')
            ->get();

        $computer = DB::table('TBMASTER_COMPUTER')
            ->select('*')
            ->whereRaw('NVL(RECORDID,\'0\') != \'1\'')
            ->get();

        return view('ADMINISTRATION.user')->with(compact(['user', 'computer']));
    }

    public function searchUser(Request $request)
    {
        if ($request->value == '') {
            $user = DB::table('TBMASTER_USER')
                ->select('*')
                ->whereRaw('NVL(RECORDID,\'0\') != \'1\'')
                ->orderBy('userid')
                ->get();
        } else {
            $user = DB::table('TBMASTER_USER')
                ->select('*')
                ->whereRaw('NVL(RECORDID,\'0\') != \'1\'')
                ->where('USERID', 'like', $request->value . '%')
                ->orderBy('userid')
                ->get();
        }
        return compact(['user']);
    }

    public function saveUser(Request $request)
    {
        $cek = DB::table('TBMASTER_USER')
            ->select('*')
            ->where('USERID', '=', $request->id)
            ->first();

        if (!is_null($cek)){
            $message = 'User ID Sudah Ada, Silahkan Ganti!';
            $status = 'error';
        }
        else {
            if (DB::table('tbmaster_user')->insert(
                ['kodeigr' => $_SESSION['kdigr'], 'userid' => $request->id, 'userpassword' => $request->password, 'userlevel' => $request->level, 'station' => $request->station, 'username' => $request->username, 'email' => $request->email, 'create_by' => $_SESSION['usid'], 'create_dt' => DB::raw('trunc(sysdate)'), 'encryptpwd' => md5($request->password), 'jabatan' => $request->jabatan])) {
                $message = 'User Berhasil Disimpan!';
                $status = 'success';
            } else {
                $message = 'User Gagal Disimpan!';
                $status = 'error';
            }
        }
        return compact(['message','status']);
    }
}
