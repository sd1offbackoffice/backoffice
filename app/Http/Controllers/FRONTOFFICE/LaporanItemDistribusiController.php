<?php

namespace App\Http\Controllers\FRONTOFFICE;

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

class LaporanItemDistribusiController extends Controller
{
    public function index(){

        return view('FRONTOFFICE.LAPORANITEMDISTRIBUSI.laporan-item-distribusi');
    }

    public function cetak(Request $request)
    {
        $perusahaan = DB::connection(Session::get('connection'))->table('tbmaster_perusahaan')
            ->select('prs_namaperusahaan', 'prs_namacabang')
            ->first();
        $jenis = $request->jenis;
        if(in_array($jenis, ["1","4"])) {
            $bulan = $request->bulan;
            switch ($jenis) {
                case "1":
                    return Self::laporanPembelianPerdanaItemDistribusiTertentu($perusahaan,$jenis,$bulan);
                break;
                case "4":
                    return Self::laporanFrekuensiPenukaranBarangDagangan($perusahaan,$jenis,$bulan);
                break;
            }
        }else{
            $tgl1 = $request->tgl1;
            $tgl2 = $request->tgl2;

            switch ($jenis) {
                case "2":
                    return Self::listingReturItemDistribusiTertentu($perusahaan,$jenis,$tgl1,$tgl2);
                break;
                case "3":
                    return Self::laporanTransaksiPenukaranBarang($perusahaan,$jenis,$tgl1,$tgl2);
                break;
                case "5":
                    return Self::laporanPenyerahanBarangDaganganYangDitukar($perusahaan,$jenis,$tgl1,$tgl2);
                break;
            }
        }
    }
    //laporan 1
    public function laporanPembelianPerdanaItemDistribusiTertentu($perusahaan,$jenis,$bulan)
    {
        $data = ['1'];
        return view('FRONTOFFICE.LAPORANITEMDISTRIBUSI.laporan-pembelian-perdana-item-distribusi-tertentu-pdf', compact(['perusahaan', 'data', 'bulan']));
    }

    //laporan 2
    public function listingReturItemDistribusiTertentu($perusahaan,$jenis,$bulan)
    {
        $data = ['1'];
        return view('FRONTOFFICE.LAPORANITEMDISTRIBUSI.listing-retur-item-distribusi-tertentu-pdf', compact(['perusahaan', 'data', 'bulan']));
    }

    //laporan 3
    public function laporanTransaksiPenukaranBarang($perusahaan,$jenis,$tgl1,$tgl2)
    {
        // Cesar
        $data = ['1'];
        return view('FRONTOFFICE.LAPORANITEMDISTRIBUSI.laporan-transaksi-penukaran-barang-pdf', compact(['perusahaan', 'data', 'tgl1', 'tgl2']));
    }

    //laporan 4
    public function laporanFrekuensiPenukaranBarangDagangan($perusahaan,$jenis,$tgl1,$tgl2)
    {

    }

    //laporan 5
    public function laporanPenyerahanBarangDaganganYangDitukar($perusahaan,$jenis,$tgl1,$tgl2)
    {
        //hen
        $data = ['1'];
        return view('FRONTOFFICE.LAPORANITEMDISTRIBUSI.laporan-penyerahan-barang-dagangan-yang-ditukar-pdf', compact(['perusahaan', 'data', 'tgl1','tgl2']));
    }

}
