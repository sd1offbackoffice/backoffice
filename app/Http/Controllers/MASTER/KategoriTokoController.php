<?php

namespace App\Http\Controllers\MASTER;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\NotIn;


class KategoriTokoController extends Controller
{
    public function index(){
        $result = DB::connection($_SESSION['connection'])->table('tbmaster_cabang')->SELECT("*")->ORDERBY('cab_kodecabang')->Get();
//        ->WHERE('cab_kodecabang','!=',30)->
        return view('MASTER.kategori-toko')->with('result',$result);
    }

    public function getDataKtk(){
        $result = DB::connection($_SESSION['connection'])->table('tbmaster_kategoritoko')->SELECT("*")->ORDERBY('ktk_kodekategoritoko')->Get();
        return  $result;
    }

    public function saveDataKtk(Request $request){
        date_default_timezone_set('Asia/Jakarta');
        $date       = date('Y-m-d H:i:s');
        $result = DB::connection($_SESSION['connection'])->table('tbmaster_kategoritoko')->SELECT("*")->WHERE('ktk_kodekategoritoko',$request->kodektk )->count();
        if ($result==0){
            DB::connection($_SESSION['connection'])->table('tbmaster_kategoritoko')->insert(
                ['KTK_KODEKATEGORITOKO' => $request->kodektk, 'KTK_CLASSKODEIGR' => $request->kodeigr, 'KTK_KETERANGAN' => $request->keterangan, 'KTK_CREATE_BY' => 'sys', 'KTK_CREATE_DT' => $date]
            );
            return  'save';
        }
        else{
            DB::connection($_SESSION['connection'])->table('tbmaster_kategoritoko')->where('ktk_kodekategoritoko', $request->kodektk)
                ->update(['ktk_classkodeigr' => $request->kodeigr,'ktk_keterangan' => $request->keterangan, 'KTK_MODIFY_BY' => 'web', 'KTK_MODIFY_DT' => $date]);
            return  'update';
        }

    }
}
