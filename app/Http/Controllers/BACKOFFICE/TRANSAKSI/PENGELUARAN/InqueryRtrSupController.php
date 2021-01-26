<?php

namespace App\Http\Controllers\BACKOFFICE\TRANSAKSI\PENGELUARAN;

use App\Http\Controllers\Connection;
use Carbon\Carbon;
use Dompdf\Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Expr\Cast\Object_;
use Yajra\DataTables\DataTables;
use PDF;



class InqueryRtrSupController extends Controller
{
    public function index()
    {
        return view('BACKOFFICE/TRANSAKSI/PENGELUARAN.inqueryrtrsup');
    }

    public function getDataLov()
    {
        $data = DB::table('tbmaster_supplier')
            ->select('sup_namasupplier', 'sup_kodesupplier')
            ->where('sup_kodeigr', '=', $_SESSION['kdigr'])
            ->get();

        return Datatables::of($data)->make(true);
    }

    public function getData(Request $request)
    {
        $kdsup = $request->kdsup;

        $supplier = DB::table('tbmaster_supplier')
            ->selectRaw('sup_namasupplier||case when sup_singkatansupplier is not null then \' / \'||sup_singkatansupplier else \'\' end supplier,sup_alamatsupplier1||\', \'||sup_alamatsupplier2||\', \'||sup_kotasupplier3 alamat,sup_telpsupplier telp, sup_contactperson cp')
            ->where('sup_kodeigr', '=', $_SESSION['kdigr'])
            ->where('sup_kodesupplier', '=', $kdsup)
            ->first();

        if (!isset($supplier)) {
            $message = 'Kode Supplier tidak ada di Master...';
            $status = 'error';
            return compact(['message', 'status']);
        } else {
            $datas = DB::table('TBMASTER_HARGABELI')
                ->join('TBMASTER_STOCK', 'ST_PRDCD', 'HGB_PRDCD')
                ->join('TBMASTER_PRODMAST', 'HGB_PRDCD', 'PRD_PRDCD')
                ->where('HGB_KODESUPPLIER', '=', $kdsup)
                ->where('ST_LOKASI', '=', '02')
                ->where('HGB_TIPE', '=', '2')
                ->get();
            if (sizeof($datas) == 0) {
                $message = 'Supplier ini tak ada barang retur...';
                $status = 'error';
                return compact(['message', 'status']);
            } else {
                $message = 'Next to get data detail';
                $status = 'success';
                return compact(['message', 'status', 'supplier']);
//                next to get data detail
            }
        }


    }

    public function getDataDetail(Request $request)
    {
        $kdsup = $request->kdsup;

        $result = DB::table('TBMASTER_HARGABELI')
            ->join('TBMASTER_STOCK', 'ST_PRDCD', 'HGB_PRDCD')
            ->join('TBMASTER_PRODMAST', 'HGB_PRDCD', 'PRD_PRDCD')
            ->selectRaw('HGB_PRDCD plu, PRD_DESKRIPSIPANJANG barang, PRD_UNIT||\'/\'||PRD_FRAC SATUAN, PRD_KODETAG tag, ST_SALDOAKHIR qty')
            ->where('HGB_KODESUPPLIER', '=', $kdsup)
            ->where('ST_LOKASI', '=', '02')
            ->where('HGB_TIPE', '=', '2')
            ->where('ST_SALDOAKHIR', '!=', 0)
            ->get();

        return Datatables::of($result)
            ->make(true);
    }

    public function report(Request $request)
    {
        $kdsup = $request->kdsup;
        $perusahaan = DB::table('tbmaster_perusahaan')
            ->select('prs_namaperusahaan', 'prs_namacabang')
            ->where('prs_kodeigr', '=', $_SESSION['kdigr'])
            ->first();

        $data = DB::table('TBMASTER_HARGABELI')
            ->join('TBMASTER_STOCK', 'ST_PRDCD', 'HGB_PRDCD')
            ->join('TBMASTER_PRODMAST', 'HGB_PRDCD', 'PRD_PRDCD')
            ->selectRaw('HGB_PRDCD plu, PRD_DESKRIPSIPANJANG barang, PRD_UNIT||\'/\'||PRD_FRAC SATUAN, PRD_KODETAG tag, ST_SALDOAKHIR qty')
            ->where('HGB_KODESUPPLIER', '=', $kdsup)
            ->where('ST_LOKASI', '=', '02')
            ->where('HGB_TIPE', '=', '2')
            ->where('ST_SALDOAKHIR', '!=', 0)
            ->orderBy('HGB_PRDCD')
            ->get();

        $pdf = PDF::loadview('BACKOFFICE/TRANSAKSI/PENGELUARAN/cetakrtrsup', compact(['data', 'perusahaan']));
        $pdf->output();
        $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);

        $canvas = $dompdf ->get_canvas();
        $canvas->page_text(514, 10, "Page {PAGE_NUM} of {PAGE_COUNT}", null, 10, array(0, 0, 0));

        return $pdf->stream('BACKOFFICE/TRANSAKSI/PENGELUARAN/cetakrtrsup');
    }

}