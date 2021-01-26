<?php

namespace App\Http\Controllers\BACKOFFICE\LAPORAN;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class LaporanServiceLevelController extends Controller
{
    public function index(){

        return view('BACKOFFICE/LAPORAN/LaporanServiceLevel');
    }

    public function lov_supplier(Request $request){
        $kodeigr = $_SESSION['kdigr'];
        $search = strtoupper($request->search);

        $supplier = DB::table('tbmaster_supplier')
            ->select('sup_namasupplier', 'sup_kodesupplier')
            ->where('sup_namasupplier', 'LIKE', '%'.$search.'%')
            ->where('sup_kodesupplier', 'LIKE', '%'.$search.'%')
            ->where('sup_kodeigr','=', $kodeigr)
            ->orderBy('sup_namasupplier')
            ->limit(100)
            ->get()->toArray();

        return response()->json($supplier);
    }

    public function lov_monitoring(Request $request){
        $kodeigr = $_SESSION['kdigr'];
        $search = strtoupper($request->search);

        $monitoring = DB::table('tbtr_monitoringsupplier')
            ->select('msu_namamonitoring', 'msu_kodemonitoring')
            ->where('msu_namamonitoring', 'LIKE', '%'.$search.'%')
            ->where('msu_kodemonitoring', 'LIKE', '%'.$search.'%')
            ->where('msu_kodeigr','=', $kodeigr)
            ->orderBy('msu_namamonitoring')
            ->limit(100)
            ->get()->toArray();

        return response()->json($monitoring);
    }

    public function cetak(){

    }
}
