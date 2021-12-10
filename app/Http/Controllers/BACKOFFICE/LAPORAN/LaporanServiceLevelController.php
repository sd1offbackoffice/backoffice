<?php

namespace App\Http\Controllers\BACKOFFICE\LAPORAN;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller; use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class LaporanServiceLevelController extends Controller
{
    public function index(){

        return view('BACKOFFICE.LAPORAN.LaporanServiceLevel');
    }

    public function lov_supplier(Request $request){
        $kodeigr = Session::get('kdigr');
        $search = strtoupper($request->search);

        $supplier = DB::connection(Session::get('connection'))->table('tbmaster_supplier')
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
        $kodeigr = Session::get('kdigr');
        $search = strtoupper($request->search);

        $monitoring = DB::connection(Session::get('connection'))->table('tbtr_monitoringsupplier')
            ->select('msu_namamonitoring', 'msu_kodemonitoring')
            ->where('msu_namamonitoring', 'LIKE', '%'.$search.'%')
            ->where('msu_kodemonitoring', 'LIKE', '%'.$search.'%')
            ->where('msu_kodeigr','=', $kodeigr)
            ->orderBy('msu_namamonitoring')
            ->limit(100)
            ->get()->toArray();

        return response()->json($monitoring);
    }

    public function cetak_laporan(Request $request){

        $kodeigr    = Session::get('kdigr');
        $tgl1       = $request->tgl1;
        $tgl2       = $request->tgl2;
        $sup1       = $request->sup1;
        $sup2       = $request->sup2;
        $mtrSup     = $request->mtrSup;

        $perusahaan = DB::connection(Session::get('connection'))->table('tbmaster_perusahaan')
            ->select('prs_rptname', 'prs_namaperusahaan', 'prs_namacabang')
            ->where('prs_kodeigr', '=', $kodeigr)
            ->first();

        $data = DB::connection(Session::get('connection'))->select("SELECT sup_kodesupplier, sup_namasupplier, msu_kodemonitoring, msu_kodesupplier
        FROM
            tbmaster_supplier, tbtr_monitoringsupplier
        WHERE
              sup_kodeigr = '$kodeigr'
              AND msu_kodeigr = '$kodeigr'
              AND sup_kodesupplier = msu_kodesupplier
              AND sup_kodesupplier BETWEEN '$sup1' AND '$sup2'
              AND msu_kodemonitoring = '$mtrSup'
        ");

        $pdf = PDF::loadview('BACKOFFICE.LAPORAN.laporanservicelevel-cetak-pdf', compact(['perusahaan', 'supplier', 'mtrSup']));
        $pdf->output();
        $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);

        $canvas = $dompdf ->get_canvas();
        $canvas->page_text(514, 10, "Page {PAGE_NUM} of {PAGE_COUNT}", null, 10, array(0, 0, 0));

        return $pdf->stream('laporanservicelevel-cetak.pdf');
    }
}
