<?php

namespace App\Http\Controllers\FRONTOFFICE\LAPORANKASIR;

use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;
use PDF;
use Symfony\Component\VarDumper\Cloner\Data;
use Yajra\DataTables\DataTables;
use ZipArchive;
use File;

class DaftarMemberTidakAktifController extends Controller
{
    public function index()
    {
        return view('FRONTOFFICE.LAPORANKASIR.daftar-member-tidak-aktif');
    }

    public function lovMember(Request $request)
    {
        $search = $request->search;
        $data = DB::connection(Session::get('connection'))->table("tbmaster_customer")
            ->whereRaw("cus_kodemember like '%" . $search . "%'")
            ->orWhereRaw("cus_namamember like '%" . $search . "%'")
            ->limit(100)
            ->get();

        return DataTables::of($data)->make(true);

    }

    public function cetak(Request $request)
    {
        $txt_kdmbr1 = $request->mulai;
        $txt_kdmbr2 = $request->sampai;
        $sort = $request->sort;

        $txt_namambr1 = '';
        $txt_namambr2 = '';

        if ($txt_kdmbr1 == '') {
            $result = DB::connection(Session::get('connection'))
                ->select("SELECT LPAD(CUS_KODEMEMBER,6,0) kode, CUS_NAMAMEMBER nama
                                FROM TBMASTER_CUSTOMER
                                WHERE LPAD(CUS_KODEMEMBER,6,0) IN (SELECT MIN(LPAD(cus_kodemember,6,0))
                                FROM TBMASTER_CUSTOMER)")->first();
            $txt_kdmbr1 = $result->kode;
            $txt_namambr1 = $result->nama;
        }

        if ($txt_kdmbr2 == '') {
            $result = DB::connection(Session::get('connection'))
                ->select("SELECT LPAD(CUS_KODEMEMBER,6,0) kode, CUS_NAMAMEMBER nama
                                FROM TBMASTER_CUSTOMER
                                WHERE LPAD(CUS_KODEMEMBER,6,0) IN (SELECT MAX(LPAD(cus_kodemember,6,0))
                                FROM TBMASTER_CUSTOMER)")->first();
            $txt_kdmbr2 = $result->kode;
            $txt_namambr2 = $result->nama;
        }

        $filename = '';
        $urut = '';
        if ($sort == '1' || $sort == '2') {
            $filename = 'cetak-a';
            if ($sort == '1') {
                $sort = 'order by cus_kodeoutlet,cus_kodearea,cus_kodemember';
                $urut = 'OUTLET + AREA + KODE';
            } else {
                $sort = 'order by cus_kodeoutlet,cus_kodearea,cus_namamember';
                $urut = 'OUTLET + AREA + NAMA';
            }
        } else if ($sort == '3' || $sort == '4') {
            $filename = 'cetak-b';
            if ($sort == '3') {
                $sort = 'order by cus_kodeoutlet,cus_kodemember';
                $urut = 'OUTLET + KODE';
            } else {
                $sort = 'order by cus_kodeoutlet,cus_namamember';
                $urut = 'OUTLET + NAMA';
            }
        } else if ($sort == '5' || $sort == '6') {
            $filename = 'cetak-c';
            if ($sort == '5') {
                $sort = 'order by cus_kodearea,cus_kodemember';
                $urut = 'AREA + KODE';
            } else {
                $sort = 'order by cus_kodearea,cus_namamember';
                $urut = 'AREA + NAMA';
            }

        } else if ($sort == '7' || $sort == '8') {
            $filename = 'cetak-d';
            if ($sort == '7') {
                $sort = 'order by cus_kodemember';
                $urut = 'KODE';
            } else {
                $sort = 'order by cus_namamember';
                $urut = 'NAMA';
            }
        }
        $data = DB::connection(Session::get('connection'))
            ->select("SELECT prs_namaperusahaan, prs_namacabang, cus_kodeoutlet, out_namaoutlet, nvl(cus_kodearea,'') cus_kodearea, LPAD(cus_kodemember,6,0) cus_kodemember,   '1'||NVL(cus_kodearea,' ')||NVL(cus_kodeoutlet,' ')||'-'||SUBSTR(LPAD(cus_kodemember,6,0),2,5)||'-'||SUBSTR(TO_CHAR(cus_tglregistrasi,'dd-MM-yy'),4,2)||
                 LPAD(SUBSTR(TO_CHAR(cus_tglregistrasi,'dd-MM-yy'),7,2)+5,2,0) cus_nomorkartu, cus_namamember, cus_alamatmember1,cus_alamatmember2, cus_tlpmember, cus_flagpkp, cus_npwp, cus_creditlimit, cus_top, TRUNC(cus_tglregistrasi) cus_tgl_registrasi
                FROM TBMASTER_CUSTOMER cus,TBMASTER_PERUSAHAAN prs, TBMASTER_OUTLET out
                WHERE LPAD(CUS_KODEMEMBER,6,0) BETWEEN  '".$txt_kdmbr1."' AND '".$txt_kdmbr2."'
                    AND prs_kodeigr = '".Session::get('kdigr')."'
                    AND out_kodeoutlet (+) = cus_kodeoutlet
                    AND cus_recordid = '1' " . $sort );

        $perusahaan = DB::connection(Session::get('connection'))->table('tbmaster_perusahaan')
            ->first();

        return view('FRONTOFFICE.LAPORANKASIR.daftar-member-tidak-aktif-' . $filename . '-pdf', compact(['perusahaan', 'data', 'urut']));
    }

}
