<?php

namespace App\Http\Controllers\BACKOFFICE;

use App\AllModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class maxpaletUntukPBController extends Controller
{
    public function index(){
        return view('BACKOFFICE.maxpaletUntukPB');
    }

    public function loadData(){
        $datas  = DB::table('tbmaster_pb_maxpalet a')
            ->select('a.pmp_prdcd', 'b.prd_deskripsipanjang', 'c.mpt_maxqty')
            ->leftJoin('tbmaster_prodmast b', 'b.prd_prdcd', 'a.pmp_prdcd')
            ->leftJoin('tbmaster_maxpalet c', 'c.mpt_prdcd', 'a.pmp_prdcd')
            ->where('a.pmp_recordid',  null)
            ->orderBy('b.prd_prdcd')
            ->get()->toArray();

        return response()->json(['data' =>  $datas]);
//        return response()->json($datas);
    }

    public function getMaxPalet(Request $request){
        $kodePlu = $request->kodePlu;
        $plu    = DB::select("SELECT LPAD ( RPAD (SUBSTR ('$kodePlu', 0, LENGTH ('$kodePlu') - 1),LENGTH ('$kodePlu'),'0'), 7, '0') AS plu FROM DUAL");
        $plu    = $plu[0]->plu;

        $search = DB::table('tbmaster_prodmast')->where('prd_prdcd', $plu)->get()->toArray();

        if (!$search){
            return response()->json(['kode' => '0', 'return' => "Data PLU Tidak ada di Master Produk !!"]);
        }

        $getdata    = DB::table('tbmaster_prodmast')->select('prd_prdcd', 'prd_deskripsipanjang', 'prd_unit', 'prd_frac', "prd_kodeigr as maxpalet")
            ->where('prd_prdcd', $plu)
            ->get()->toArray();

        $searchMaxPalet = DB::table('tbmaster_maxpalet')->where('mpt_prdcd', $plu)->get()->toArray();

        if ($searchMaxPalet){
            $getdata[0]->maxpalet = $searchMaxPalet[0]->mpt_maxqty;
        } else {
            $getdata[0]->maxpalet = 0;
        }

        return response()->json(['kode' => '1', 'return' => $getdata]);
    }

    public function saveData(Request $request){
        $model      = new AllModel();
        $kodePlu    = $request->kodePlu;
        $kodeigr    = '22';
        $user       = 'JEP';
        $date       = $model->getDate();

        $search     = DB::table('tbmaster_prodmast')->where('prd_prdcd', $kodePlu)->get()->toArray();

        $search2    = DB::table('tbmaster_pb_maxpalet')->where('pmp_prdcd', $kodePlu)
            ->whereRaw("nvl(pmp_recordid, '0') <> '1'")
            ->get()->toArray();

        if (!$search){
            return response()->json(['kode' => '0', 'return' => "Data PLU Tidak Ada !!"]);
        } else {
            if ($search2){
                return response()->json(['kode' => '0', 'return' => "Data PLU Sudah Ada !!"]);
            } else {
                DB::table('tbmaster_pb_maxpalet')->insert(['pmp_kodeigr' => $kodeigr, 'pmp_prdcd' => $kodePlu, 'pmp_create_by' => $user, 'pmp_create_dt' => $date]);

                return response()->json(['kode' => '1', 'return' => "Data PLU Berhasil di Simpan !!"]);
            }
        }
    }

    public function deleteData(Request $request){
        $kodePlu    = $request->kodePlu;

        $search     = DB::table('tbmaster_prodmast')->where('prd_prdcd', $kodePlu)->get()->toArray();

        if (!$search){
            return response()->json(['kode' => '0', 'return' => "Data PLU Tidak Ada !!"]);
        } else {
           DB::table('tbmaster_pb_maxpalet')->where('pmp_prdcd', $kodePlu)->update(['pmp_recordid' => 1]);

            return response()->json(['kode' => '1', 'return' => "Data PLU Berhasil di Hapus !!"]);
        }
    }



}
