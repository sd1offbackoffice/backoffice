<?php

namespace App\Http\Controllers\BACKOFFICE\LAPORAN;

use App\Http\Controllers\Auth\loginController;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Mockery\Exception;
use PDF;
use Yajra\DataTables\DataTables;

class LaporanDiscount4Controller extends Controller
{
    public function index()
    {
        return view('BACKOFFICE.LAPORAN.laporan-discount-4');
    }

    public function getLovSupplier(Request $request)
    {
        $search = $request->search;
        $data = DB::connection(Session::get('connection'))->table('tbmaster_supplier')
            ->selectRaw("sup_kodesupplier,sup_namasupplier")
            ->whereRaw("sup_kodesupplier LIKE '%".$search."%' or sup_namasupplier LIKE '%".$search."%'")
            ->orderBy('sup_kodesupplier')
            ->limit(100)
            ->get();

        return DataTables::of($data)->make(true);
    }

    public function cetak(Request $request)
    {
        $tgl1 = $request->tanggal1;
        $tgl2 = $request->tanggal2;
        $supplier1 = $request->supplier1;
        $supplier2 = $request->supplier2;

        $p_sup='';
        if( $supplier1 == '' ) {
            $p_sup = '';
        }
        else {
            $p_sup = "AND mstd_kodesupplier BETWEEN '" . $supplier1 . "' AND '" . $supplier2;
        }

        $data = DB::connection(Session::get('connection'))
            ->select("SELECT   PRS_NAMAPERUSAHAAN, PRS_NAMACABANG, MSTD_KODESUPPLIER, SUP_NAMASUPPLIER,
                             TO_CHAR (MSTD_TGLDOC, 'dd-mm-yy') MSTD_TGLDOC, MSTD_PRDCD, PRD_DESKRIPSIPANJANG,
                             PRD_UNIT || '/' || LPAD (PRD_FRAC, 4, ' ') satuan, MSTD_QTY QTY, MSTD_HRGSATUAN, MSTD_GROSS,
                             MSTD_DISCRPH, MSTD_RPHDISC4, MSTD_DIS4CR, MSTD_DIS4RR, MSTD_DIS4JR
                        FROM TBMASTER_PERUSAHAAN, TBTR_MSTRAN_D, TBMASTER_SUPPLIER, TBMASTER_PRODMAST
                       WHERE PRS_KODEIGR = MSTD_KODEIGR
                         AND MSTD_KODESUPPLIER = SUP_KODESUPPLIER
                         AND MSTD_PRDCD = PRD_PRDCD
                         AND MSTD_RECORDID IS NULL
                         AND NVL (MSTD_RPHDISC4, 0) + NVL (MSTD_DIS4CR, 0) + NVL (MSTD_DIS4RR, 0) + NVL (MSTD_DIS4JR, 0) >
                                                                                                                       0
                         AND MSTD_TGLDOC BETWEEN to_date('".$tgl1."','dd/mm/yyyy') AND to_date('".$tgl2."','dd/mm/yyyy')
                         ".$p_sup."
                    ORDER BY SUP_KODESUPPLIER, MSTD_PRDCD");
        $perusahaan = DB::connection(Session::get('connection'))->table('tbmaster_perusahaan')->first();

        return view('BACKOFFICE.LAPORAN.laporan-discount-4-pdf', compact(['perusahaan', 'data', 'tgl1', 'tgl2']));
    }
}
