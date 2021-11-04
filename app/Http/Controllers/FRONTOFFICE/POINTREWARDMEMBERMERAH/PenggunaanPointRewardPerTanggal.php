<?php

namespace App\Http\Controllers\FRONTOFFICE\POINTREWARDMEMBERMERAH;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use PDF;
use DateTime;
use Yajra\DataTables\DataTables;

class PenggunaanPointRewardPerTanggal extends Controller
{

    public function index()
    {
        return view('FRONTOFFICE.POINTREWARDMEMBERMERAH.PENGGUNAANPOINTREWARDPERTANGGAL.PenggunaanPointRewardPerTanggal');
    }

    public function cetak(Request $request)
    {
        $data = '';
        $filename = '';
        $cw = 665;
        $ch = 35;
        $tgl1 = $request->tgl1;
        $tgl2 = $request->tgl2;

            $filename = 'igr-fo-rwd-tkr-dtl';
            $data = DB::connection($_SESSION['connection'])->select("SELECT PRS_NAMAPERUSAHAAN,
         PRS_NAMACABANG,
         KODEMEMBER,
         NAMAMEMBER,
         RECORDID,
         TGL,
         TRN,
         TKR,
         RDM,
         TOT_TKR
    FROM (SELECT PRS_NAMAPERUSAHAAN,
                 PRS_NAMACABANG,
                 POT_KODEMEMBER KODEMEMBER,
                 CUS_NAMAMEMBER NAMAMEMBER,
                 POT_RECORDID RECORDID,
                 TO_DATE (SUBSTR (POT_KODETRANSAKSI, 1, 8), 'YYYY-MM-DD') TGL,
                    SUBSTR (POT_KODETRANSAKSI, 9, 2)
                 || '.'
                 || SUBSTR (POT_KODETRANSAKSI, 11, 3)
                 || '.'
                 || SUBSTR (POT_KODETRANSAKSI, 14, 5)
                    TRN,
                 POT_PENUKARANPOINT TKR,
                 NVL (POT_REDEEMPOINT, 0) RDM,
                 POT_PENUKARANPOINT + NVL (POT_REDEEMPOINT, 0) TOT_TKR
            FROM TBTR_PENUKARANmyPOIN, TBMASTER_CUSTOMER, TBMASTER_PERUSAHAAN
           WHERE     CUS_KODEMEMBER(+) = POT_KODEMEMBER
                 AND PRS_KODEIGR = POT_KODEIGR
                 AND POT_KODEIGR = '" . $_SESSION['kdigr'] . "'
                 AND POT_RECORDID IS NULL
                 AND POT_KODETRANSAKSI NOT LIKE '%R'
                 AND TO_DATE (SUBSTR (POT_KODETRANSAKSI, 1, 8), 'YYYY-MM-DD') BETWEEN to_date('" . $tgl1 . "','dd/mm/yyyy')
                                                                                  AND to_date('" . $tgl2 . "','dd/mm/yyyy'))
ORDER BY TGL, KODEMEMBER");

        $perusahaan = DB::connection($_SESSION['connection'])->table('tbmaster_perusahaan')
            ->first();

        if (sizeof($data) != 0) {
            $data = [
                'perusahaan' => $perusahaan,
                'data' => $data,
                'tgl1' => $tgl1,
                'tgl2' => $tgl2,
            ];

            $dompdf = new PDF();

            $pdf = PDF::loadview('FRONTOFFICE.POINTREWARDMEMBERMERAH.PENGGUNAANPOINTREWARDPERTANGGAL.' . $filename . '-pdf', $data);

            error_reporting(E_ALL ^ E_DEPRECATED);

//            $pdf->setPaper('A4', 'potrait');
            $pdf->output();
            $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);

            $canvas = $dompdf->get_canvas();
            $canvas->page_text(507, 77.75, "{PAGE_NUM} dari {PAGE_COUNT}", null, 7, array(0, 0, 0));

            $dompdf = $pdf;

            return $dompdf->stream($filename . '_' . $tgl1 . ' - ' . $tgl2 . '.pdf');
        } else {
            return 'Tidak Ada Data!';
        }
    }
}

