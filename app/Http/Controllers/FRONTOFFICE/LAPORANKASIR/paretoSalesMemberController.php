<?php

namespace App\Http\Controllers\FRONTOFFICE\LAPORANKASIR;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class paretoSalesMemberController extends Controller
{

    public function index() {
        $kodeigr    = $_SESSION['kdigr'];

        $outlet = DB::table('tbmaster_outlet')->where('out_kodeigr', $kodeigr)->orderBy('out_kodeoutlet')->get();

        return view('FRONTOFFICE/LAPORANKASIR.laporanParetoSalesMember', compact('outlet'));
    }

    public function getLovMember(Request  $request){
        $search = $request->search;
        $kodeigr    = $_SESSION['kdigr'];

        $member = DB::table('tbmaster_customer')->select('cus_kodemember' , 'cus_namamember', 'cus_recordid')
            ->where('cus_kodeigr', $kodeigr)
            ->whereRaw("(cus_namamember LIKE '%$search%' or cus_kodemember  LIKE '%$search%' ) and (cus_recordid IS NULL OR cus_recordid <> 1)")
            ->orderBy('cus_kodemember')
            ->limit(100)->get();

        return Datatables::of($member)->make(true);
    }

    public function validasiCetak(Request $request){
        $tgl_start = $request->tgl_start;
        $tgl_end = $request->tgl_end;
        $outlet_start = $request->outlet_start;
        $outlet_end = $request->outlet_end;
        $member_start = $request->member_start;
        $member_end = $request->member_end;
        $limit = $request->limit;
        $rank_member = $request->rank_member;
        $up_under = $request->up_under;
        $rank_by = $request->rank_by;

        //----------- Check outlet
        if ($outlet_start){
            $temp = DB::table('tbmaster_outlet')->where('out_kodeoutlet', $outlet_start)->get()->toArray();

            if (!$temp) return response()->json(["kode" => 2, "msg" => "Kode Outlet 1 Tidak Tersedia!!", "data" => ""]);
        }

        if ($outlet_end){
            $temp = DB::table('tbmaster_outlet')->where('out_kodeoutlet', $outlet_end)->get()->toArray();

            if (!$temp) return response()->json(["kode" => 2, "msg" => "Kode Outlet 2 Tidak Tersedia!!", "data" => ""]);
        }

        if ($rank_member){
            //dsadasdasd
        }

        if ($limit){
            //asdadas
        }





        return response()->json('asd');
    }



}
