<?php

namespace App\Http\Controllers\MASTER;

use App\AllModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class hariLiburController extends Controller
{
    public function index(){
        $harilibur = DB::table('TBMASTER_HARILIBUR')
            ->select('lib_tgllibur', 'lib_keteranganlibur')
            ->whereYear('lib_tgllibur', date("Y", strtotime("now")))
            ->orderBy('lib_tgllibur')
            ->get();

        return view('MASTER.harilibur')->with('harilibur',$harilibur);
    }

    public function getData(){
        $harilibur = DB::table('TBMASTER_HARILIBUR')
            ->select('lib_tgllibur', 'lib_keteranganlibur')
            ->whereYear('lib_tgllibur', date("Y", strtotime("now")))
            ->orderBy('lib_tgllibur')
            ->get();

        return $harilibur;
    }

    public function insert(Request $request)
    {
        $tgllibur   = $request->input('tgllibur');
        $ketlibur   = strtoupper($request->input('ketlibur'));
        $model      = new AllModel();
        $kodeigr    = $_SESSION['kdigr'];
        $user       = $_SESSION['usid'];
        $date       = $model->getDate();

        $cekData    = DB::table('tbmaster_harilibur')
            ->where('lib_tgllibur', $tgllibur)
            ->get()->toArray();

        if (!$cekData){
            DB::table('tbmaster_harilibur')->insert(['lib_kodeigr' => $kodeigr, 'lib_tgllibur' => $tgllibur, 'lib_keteranganlibur' => $ketlibur, 'lib_create_by' => $user, 'lib_create_dt' => $date]);
            $msg = "Hari Libur Berhasil di Simpan !!";
        } else {
            $cekData    = DB::table('tbmaster_harilibur')
                ->where('lib_tgllibur', $tgllibur)
                ->update(['lib_keteranganlibur' => $ketlibur, 'lib_modify_by' => $user, 'lib_modify_dt' => $date]);

            $msg = "Hari Libur Berhasil di Update !!";
        }

        $data = $this->getData();

        return response()->json(['kode' => 1, 'data' => $data, 'msg' => $msg]);
    }

    public function delete(Request $request){
        $tgllibur   = $request->input('tgllibur');
        $ketlibur   = strtoupper($request->input('ketlibur'));

        $cekData    = DB::table('tbmaster_harilibur')
            ->where('lib_tgllibur', $tgllibur)
            ->where('lib_keteranganlibur', $ketlibur)
            ->get()->toArray();

        if (!$cekData){
            $msg = "Hari Libur Tidak Terdaftar!!";
        } else {
            DB::table('tbmaster_harilibur')->where('lib_tgllibur', $tgllibur)->delete();
            $msg = "Hari Libur Berhasil di Hapus !!";
        }

        $data = $this->getData();

        return response()->json(['kode' => 1, 'data' => $data, 'msg' => $msg]);
    }
}
