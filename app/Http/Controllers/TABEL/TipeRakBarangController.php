<?php
/**
 * Created by PhpStorm.
 * User: ryan
 * Date: 09/11/2021
 * Time: 10:39 AM
 */

namespace App\Http\Controllers\TABEL;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller; use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use PDF;
use DateTime;
use Yajra\DataTables\DataTables;

class TipeRakBarangController extends Controller
{

    public function index()
    {
        return view('TABEL.tipe-rak-barang');
    }

    public function loadData(){
        try{
            $kodeigr = Session::get('kdigr');

            $datas = DB::connection(Session::get('connection'))->table("TBTABEL_TIPERAK")
                ->selectRaw("trak_kodetiperak")
                ->selectRaw("trak_namatiperak")
                ->get();

            return response()->json($datas);
        }catch(QueryException $e){
            $status = 'error';
            $message = $e->getMessage();

            return response()->json(['status' => $status,'message' => $message]);
        }
    }


    public function Save(Request $request){
        try{
            DB::connection(Session::get('connection'))->beginTransaction();
            $kodeigr = Session::get('kdigr');
            $kode = $request->kode;
            $nama = $request->nama;
            $status = $request->status;
            if($status == 'insert'){
                DB::connection(Session::get('connection'))->table("TBTABEL_TIPERAK")
                    ->insert([
                        'TRAK_KODETIPERAK' => $kode,
                        'TRAK_NAMATIPERAK' => $nama,
                        'TRAK_CREATE_BY' => Session::get('usid'),
                        'TRAK_CREATE_DT' => DB::connection(Session::get('connection'))->Raw('sysdate')
                    ]);
            }else{
                DB::connection(Session::get('connection'))->table("TBTABEL_TIPERAK")
                    ->where("TRAK_KODETIPERAK",'=',$kode)
                    ->update([
                        'TRAK_NAMATIPERAK' => $nama,
                        'TRAK_MODIFY_BY' => Session::get('usid'),
                        'TRAK_MODIFY_DT' => DB::connection(Session::get('connection'))->Raw('sysdate')
                    ]);
            }

            DB::connection(Session::get('connection'))->commit();
        }catch(QueryException $e){
            DB::connection(Session::get('connection'))->rollBack();
            $status = 'error';
            $message = $e->getMessage();

            return response()->json(['status' => $status,'message' => $message]);
        }
    }
    public function hapus(Request $request){
        try{
            DB::connection(Session::get('connection'))->beginTransaction();
            $kodeigr = Session::get('kdigr');
            $kode = $request->kode;
            DB::connection(Session::get('connection'))->table("TBTABEL_TIPERAK")
                ->where("TRAK_KODETIPERAK",'=',$kode)
                ->delete();

            DB::connection(Session::get('connection'))->commit();
        }catch(QueryException $e){
            DB::connection(Session::get('connection'))->rollBack();

            $status = 'error';
            $message = $e->getMessage();

            return response()->json(['status' => $status,'message' => $message]);
        }


    }
}
