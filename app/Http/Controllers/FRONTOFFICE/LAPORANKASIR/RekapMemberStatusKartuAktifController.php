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

class RekapMemberStatusKartuAktifController extends Controller
{
    public function index()
    {
        return view('FRONTOFFICE.LAPORANKASIR.rekap-member-status-kartu-aktif');
    }

    public function cetak(Request $request)
    {
        $periode = $request->periode;
        $data = DB::connection(Session::get('connection'))
            ->select("SELECT PRS_NAMACABANG, PRS_NAMAWILAYAH, CAB_KODECABANG, CAB_NAMACABANG, KARYAWAN, WHS, RT_RMB,
         RT_RMH, RT_PSR, APOTIK, SPRMKT,
         MNIMRKT, OMI, HOREKA, KANTOR,
         KOPERASI, RS, EXPORTIR, PRIBADI,
		 (KARYAWAN + WHS + RT_RMB + RT_RMH + RT_PSR + APOTIK + SPRMKT + MNIMRKT + OMI + HOREKA + KANTOR + KOPERASI + RS + EXPORTIR + PRIBADI) TOTAL FROM (
SELECT   PRS_NAMACABANG, PRS_NAMAWILAYAH, CAB_KODECABANG, CAB_NAMACABANG, SUM (KARYAWAN) KARYAWAN, SUM (WHS) WHS, SUM (RT_RMB) RT_RMB,
         SUM (RT_RMH) RT_RMH, SUM (RT_PSR) RT_PSR, SUM (APOTIK) APOTIK, SUM (SPRMKT) SPRMKT,
         SUM (MNIMRKT) MNIMRKT, SUM (OMI) OMI, SUM (HOREKA) HOREKA, SUM (KANTOR) KANTOR,
         SUM (KOPERASI) KOPERASI, SUM (RS) RS, SUM (EXPORTIR) EXPORTIR, SUM (PRIBADI) PRIBADI
    FROM (SELECT CAB_KODECABANG, CAB_NAMACABANG,
                 CASE
                     WHEN KODE = '0'
                         THEN ITEM
                     ELSE 0
                 END KARYAWAN, CASE
                     WHEN KODE = '1'
                         THEN ITEM
                     ELSE 0
                 END WHS, CASE
                     WHEN KODE = '2A'
                         THEN ITEM
                     ELSE 0
                 END RT_RMB, CASE
                     WHEN KODE = '2B'
                         THEN ITEM
                     ELSE 0
                 END RT_RMH, CASE
                     WHEN KODE = '2C'
                         THEN ITEM
                     ELSE 0
                 END RT_PSR, CASE
                     WHEN KODE = '2D'
                         THEN ITEM
                     ELSE 0
                 END APOTIK, CASE
                     WHEN KODE = '3A'
                         THEN ITEM
                     ELSE 0
                 END SPRMKT, CASE
                     WHEN KODE = '3B'
                         THEN ITEM
                     ELSE 0
                 END MNIMRKT, CASE
                     WHEN KODE = '4'
                         THEN ITEM
                     ELSE 0
                 END OMI, CASE
                     WHEN KODE = '5A'
                         THEN ITEM
                     ELSE 0
                 END HOREKA, CASE
                     WHEN KODE = '5B'
                         THEN ITEM
                     ELSE 0
                 END KANTOR, CASE
                     WHEN KODE = '5C'
                         THEN ITEM
                     ELSE 0
                 END KOPERASI, CASE
                     WHEN KODE = '5D'
                         THEN ITEM
                     ELSE 0
                 END RS, CASE
                     WHEN KODE = '5E'
                         THEN ITEM
                     ELSE 0
                 END EXPORTIR, CASE
                     WHEN KODE = '6'
                         THEN ITEM
                     ELSE 0
                 END PRIBADI
            FROM (SELECT   CUS_KODEIGR, CUS_KODESUBOUTLET KODE, SUM (ITEM) ITEM
                      FROM (SELECT CUS_KODEIGR, CUS_KODEMEMBER, CUS_KODESUBOUTLET, 1 ITEM
                              FROM TBMASTER_CUSTOMER
                             WHERE NVL (CUS_RECORDID, '0') <> '1'
                               AND CUS_KODEMEMBER <> '299999'
                               AND CUS_KODEMEMBER <> '299998'
                               AND TRUNC (CUS_TGLREGISTRASI) <= to_date('" . $periode . "','dd/mm/yyyy')
                               AND TRUNC (CUS_TGLREGISTRASI + 365) >= to_date('" . $periode . "','dd/mm/yyyy')
                               AND CUS_KODESUBOUTLET IN
                                       ('2A',
                                        '2B',
                                        '2C',
                                        '2D',
                                        '3A',
                                        '3B',
                                        '5A',
                                        '5B',
                                        '5C',
                                        '5D',
                                        '5E'
                                       )) A
                  GROUP BY CUS_KODEIGR, CUS_KODESUBOUTLET
                  UNION
                  SELECT CUS_KODEIGR, KODE, SUM (ITEM) ITEM
                      FROM (SELECT CUS_KODEIGR, CUS_KODEMEMBER,
                                   CASE
                                       WHEN CUS_KODEOUTLET IN ('0', '1', '4', '6')
                                           THEN CUS_KODEOUTLET
                                       ELSE '6'
                                   END KODE,
                                   1 ITEM
                              FROM TBMASTER_CUSTOMER
                             WHERE NVL (CUS_RECORDID, '0') <> '1'
                               AND CUS_KODEMEMBER <> '299999'
                               AND CUS_KODEMEMBER <> '299998'
                               AND TRUNC (CUS_TGLREGISTRASI) <= to_date('" . $periode . "','dd/mm/yyyy')
                               AND TRUNC (CUS_TGLREGISTRASI + 365) >= to_date('" . $periode . "','dd/mm/yyyy')
                               AND CUS_KODEOUTLET NOT IN ('2', '3', '5')) A
                  GROUP BY CUS_KODEIGR, KODE) HASIL,
                 TBMASTER_CABANG
           WHERE CAB_KODECABANG = CUS_KODEIGR) HASIL , TBMASTER_PERUSAHAAN
		   WHERE PRS_KODEIGR = '" . Session::get('kdigr') . "'
GROUP BY CAB_NAMACABANG, CAB_KODECABANG, PRS_NAMACABANG, PRS_NAMAWILAYAH ) C
ORDER BY CAB_KODECABANG");
        $perusahaan = DB::connection(Session::get('connection'))->table('tbmaster_perusahaan')
            ->first();

        return view('FRONTOFFICE.LAPORANKASIR.rekap-member-status-kartu-aktif-pdf',compact(['perusahaan','data','periode']));
    }

}
