<?php

namespace App\Http\Controllers\BACKOFFICE\LAPORAN;

use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;
use PDF;
use Yajra\DataTables\DataTables;
use ZipArchive;
use File;

class DaftarPBYangTidakTerbentukPOController extends Controller
{
    public function index()
    {
        return view('BACKOFFICE.LAPORAN.daftar-pb-yang-tidak-terbentuk-po');
    }

    public function cetak(Request $request)
    {
        $tanggal1 = $request->tanggal1;
        $tanggal2 = $request->tanggal2;

        $perusahaan = DB::connection(Session::get('connection'))
            ->table("tbmaster_perusahaan")
            ->first();
        try {
            $url = 'http://appapi2.indomaret.lan:8801/Get_pb_tolakan_igr/' . Session::get('kdigr') . '/' . $tanggal1 . '/' . $tanggal2;
            $data = file_get_contents($url);
            $data = json_decode($data);
            for ($i = 0; $i < sizeof($data); $i++) {
                $deskripsi = DB::connection(Session::get('connection'))
                    ->table('tbmaster_prodmast')
                    ->select('prd_deskripsipendek')
                    ->where('prd_prdcd','=',$data[$i]->PLUIGR)
                    ->pluck('prd_deskripsipendek')->first();
                $data[$i]->deskripsi = $deskripsi;
            }
            return view('BACKOFFICE.LAPORAN.daftar-pb-yang-tidak-terbentuk-po-pdf', compact(['perusahaan', 'data', 'tanggal1', 'tanggal2']));
        } catch (\Exception $e) {
            return 'Gagal Mengambil Data dari Webservice, Mohon Ditunggu Beberapa Saat!';

        }
    }
}
