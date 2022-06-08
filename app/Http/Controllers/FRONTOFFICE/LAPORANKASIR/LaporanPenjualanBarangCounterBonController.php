<?php

namespace App\Http\Controllers\FRONTOFFICE\LAPORANKASIR;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use PDF;
use Yajra\DataTables\DataTables;

class LaporanPenjualanBarangCounterBonController extends Controller
{
    public function index()
    {
        return view('FRONTOFFICE.LAPORANKASIR.laporan-penjualan-barang-counter-bon');
    }

    public function getLovPLU(Request $request)
    {
        $search = $request->plu;

        if ($search == '') {
            $produk = DB::connection(Session::get('connection'))->table('tbmaster_prodmast')
                ->selectRaw("prd_prdcd,prd_deskripsipanjang, prd_unit || '/' || prd_frac satuan")
                ->where('prd_kodeigr', Session::get('kdigr'))
                ->whereRaw("substr(prd_prdcd,-1) = '0'")
                ->orderBy('prd_prdcd')
                ->limit(100)
                ->get();
        } else if (is_numeric($search)) {
            $produk = DB::connection(Session::get('connection'))->table('tbmaster_prodmast')
                ->selectRaw("prd_prdcd,prd_deskripsipanjang, prd_unit || '/' || prd_frac satuan")
                ->where('prd_kodeigr', Session::get('kdigr'))
                ->where('prd_prdcd', 'like', DB::connection(Session::get('connection'))->raw("'%" . $search . "%'"))
                ->whereRaw("substr(prd_prdcd,-1) = '0'")
                ->orderBy('prd_prdcd')
                ->limit(100)
                ->get();
        } else {
            $produk = DB::connection(Session::get('connection'))->table('tbmaster_prodmast')
                ->selectRaw("prd_prdcd,prd_deskripsipanjang, prd_unit || '/' || prd_frac satuan")
                ->where('prd_kodeigr', Session::get('kdigr'))
                ->where('prd_deskripsipanjang', 'like', DB::connection(Session::get('connection'))->raw("'%" . $search . "%'"))
                ->whereRaw("substr(prd_prdcd,-1) = '0'")
                ->orderBy('prd_prdcd')
                ->limit(100)
                ->get();
        }

        return DataTables::of($produk)->make(true);
    }

    public function print(Request $request)
    {
        $tgl1 = $request->tgl1;
        $tgl2 = $request->tgl2;
        $plu = $request->plu;

//        $kodeigr = Session::get('kdigr');
        $kodeigr = '06';

//        $perusahaan = DB::connection(Session::get('connection'))
        $perusahaan = DB::connection('simygy')
            ->table('tbmaster_perusahaan')
            ->first();

        $and_plu = $plu == '' ? '' : ' and trjd_prdcd = ' . $plu;

        //        $data = DB::connection(Session::get('connection'))
        $data = DB::connection('simygy')
            ->select("SELECT  TRJD_CREATE_BY KASIR, TRUNC (TRJD_TRANSACTIONDATE) TGLT,
         TRJD_TRANSACTIONNO NOTRN, TRJD_PRDCD PRDCD, TRJD_DIVISION DIV,
         TRJD_TRANSACTIONTYPE TIPE1, TRJD_TRANSACTIONTYPE TIPE2,
         TRJD_QUANTITY QTY, TRJD_UNITPRICE HRGJUAL, TRJD_DISCOUNT DISC, TRJD_NOMINALAMT NILAI,
         USERNAME, PRD_DESKRIPSIPENDEK, PRS_NAMAPERUSAHAAN, PRS_NAMACABANG, PRS_NAMAWILAYAH
    FROM TBTR_JUALDETAIL, TBMASTER_PRODMAST, TBMASTER_USER, TBMASTER_PERUSAHAAN
   WHERE TRJD_KODEIGR = '" . $kodeigr . "'
     AND TRUNC (TRJD_TRANSACTIONDATE) BETWEEN TRUNC (to_date('" . $tgl1 . "','dd/mm/yyyy')) AND TRUNC (to_date('" . $tgl2 . "','dd/mm/yyyy'))
     AND SUBSTR (TRJD_DIVISION, 3, 1) = 'C'
     AND TRJD_TRANSACTIONTYPE = 'S'
     ". $and_plu . "
     AND PRD_KODEIGR = TRJD_KODEIGR
     AND PRD_PRDCD = TRJD_PRDCD
     AND KODEIGR = TRJD_KODEIGR
     AND USERID = TRJD_CREATE_BY
     AND PRS_KODEIGR = TRJD_KODEIGR
UNION ALL
SELECT  TRJD_CREATE_BY KASIR, TRUNC (TRJD_TRANSACTIONDATE) TGLT,
         TRJD_TRANSACTIONNO NOTRN, TRJD_PRDCD PRDCD, TRJD_DIVISION DIV,
         TRJD_TRANSACTIONTYPE TIPE1, TRJD_TRANSACTIONTYPE TIPE2,
         TRJD_QUANTITY QTY, TRJD_UNITPRICE HRGJUAL, TRJD_DISCOUNT DISC, TRJD_NOMINALAMT NILAI,
         USERNAME, PRD_DESKRIPSIPENDEK, PRS_NAMAPERUSAHAAN, PRS_NAMACABANG, PRS_NAMAWILAYAH
    FROM TBTR_JUALDETAIL, TBMASTER_PRODMAST, TBMASTER_USER, TBMASTER_PERUSAHAAN
   WHERE TRJD_KODEIGR = '" . $kodeigr . "'
     AND TRUNC (TRJD_TRANSACTIONDATE) BETWEEN TRUNC (to_date('" . $tgl1 . "','dd/mm/yyyy')) AND TRUNC (to_date('" . $tgl2 . "','dd/mm/yyyy'))
     AND SUBSTR (TRJD_DIVISION, 3, 1) = 'C'
     AND TRJD_TRANSACTIONTYPE = 'R'
     ". $and_plu . "
     AND PRD_KODEIGR = TRJD_KODEIGR
     AND PRD_PRDCD = TRJD_PRDCD
     AND KODEIGR = TRJD_KODEIGR
     AND USERID = TRJD_CREATE_BY
     AND PRS_KODEIGR = TRJD_KODEIGR
ORDER BY TGLT, KASIR, NOTRN, PRDCD");
        return view('FRONTOFFICE.LAPORANKASIR.laporan-penjualan-barang-counter-bon-pdf', compact(['perusahaan', 'data', 'tgl1', 'tgl2']));
    }
}
