<?php

namespace App\Http\Controllers\FRONTOFFICE\POINTREWARDMEMBERMERAH;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use PDF;
use DateTime;
use Yajra\DataTables\DataTables;

class PerolehanPointRewardPerTanggal extends Controller
{

    public function index()
    {
        return view('FRONTOFFICE.POINTREWARDMEMBERMERAH.PEROLEHANPOINTREWARDPERTANGGAL.PerolehanPointRewardPerTanggal');
    }

    public function cetak(Request $request)
    {
        $data = '';
        $filename = '';
        $t_pi = '';
        $t_pe = '';
        $total = '';
        $cw = 665;
        $ch = 35;
        $tgl1 = $request->tgl1;
        $tgl2 = $request->tgl2;
        $menu = $request->menu;

        if ($menu == 'rekap') {
            $filename = 'igr-fo-rwd-trn-rkp';
            $data = DB::select("SELECT PRS_NAMAPERUSAHAAN, PRS_NAMACABANG, KODEMEMBER, NAMAMEMBER, RECORDID, JS, SUM(JML) TOT_JML,
                       SUM(CASE WHEN FLAG='Y' THEN JML END) TOT_VALID, SUM(CASE WHEN NVL(FLAG,'N')<>'Y' THEN JML END) TOT_NOTVALID
                    FROM (
                        SELECT  PRS_NAMAPERUSAHAAN, PRS_NAMACABANG, POR_KODEMEMBER KODEMEMBER, CUS_NAMAMEMBER NAMAMEMBER, POR_RECORDID RECORDID,
                        CASE WHEN INSTR(POR_DESKRIPSI,'INTERN')>0 THEN 'INTERN'ELSE 'EXTERN' END JS,
                        CASE WHEN SUBSTR(POR_KODETRANSAKSI,19,1)='S' THEN (POR_PEROLEHANPOINT)*1 ELSE (POR_PEROLEHANPOINT)*-1 END JML, POR_FLAGUPDATE FLAG
                        FROM TBTR_PEROLEHANMYPOIN, TBMASTER_CUSTOMER, TBMASTER_PERUSAHAAN
                        WHERE CUS_KODEMEMBER = POR_KODEMEMBER
                        AND PRS_KODEIGR = POR_KODEIGR
                        AND POR_KODEIGR = '" . $_SESSION['kdigr'] . "'
                        AND POR_RECORDID IS NULL
                        AND TO_DATE(SUBSTR(POR_KODETRANSAKSI,1,8),'YYYY-MM-DD') BETWEEN to_date('" . $tgl1 . "','dd/mm/yyyy') AND to_date('" . $tgl2 . "','dd/mm/yyyy'))POR
                        where rownum < 100
                    GROUP BY PRS_NAMAPERUSAHAAN, PRS_NAMACABANG, KODEMEMBER, NAMAMEMBER, RECORDID, JS");
        } else {
            //-----TOTAL INTERN
            $temp1 = DB::select("SELECT SUM (JML) jml
                             FROM (SELECT CASE
                                             WHEN SUBSTR (POR_KODETRANSAKSI, 19, 1) = 'S'
                                             THEN
                                             (POR_PEROLEHANPOINT) * 1
                                             ELSE
                                                (POR_PEROLEHANPOINT) * -1
                                          END
                                             JML
                                     FROM TBTR_PEROLEHANMYPOIN,
                                          TBMASTER_CUSTOMER,
                                          TBMASTER_PERUSAHAAN
                                    WHERE     CUS_KODEMEMBER = POR_KODEMEMBER
                                    AND PRS_KODEIGR = POR_KODEIGR
                                    AND POR_KODEIGR = '" . $_SESSION['kdigr'] . "'
                                    AND POR_RECORDID IS NULL
                                    AND INSTR (POR_DESKRIPSI, 'INTERN') > 0
                                    AND TO_DATE (SUBSTR (POR_KODETRANSAKSI, 1, 8),
                                        'YYYY-MM-DD') BETWEEN to_date('" . $tgl1 . "','dd/mm/yyyy')
                                     AND to_date('" . $tgl2 . "','dd/mm/yyyy')
                                     )")[0]->jml;

            if (!isset($temp1)) {
                $t_pi = 0;
            } else {
                $t_pi = $temp1;
            }

            // ------TOTAL EKSTERN
            $temp2 = DB::select("SELECT SUM (JML) jml
     FROM (SELECT CASE
                     WHEN SUBSTR (POR_KODETRANSAKSI, 19, 1) = 'S'
                     THEN
                     (POR_PEROLEHANPOINT) * 1
                     ELSE
                        (POR_PEROLEHANPOINT) * -1
                  END
                     JML
             FROM TBTR_PEROLEHANMYPOIN,
                  TBMASTER_CUSTOMER,
                  TBMASTER_PERUSAHAAN
            WHERE     CUS_KODEMEMBER = POR_KODEMEMBER
            AND PRS_KODEIGR = POR_KODEIGR
            AND POR_KODEIGR = '" . $_SESSION['kdigr'] . "'
            AND POR_RECORDID IS NULL
            AND INSTR (POR_DESKRIPSI, 'INTERN') = 0
            AND TO_DATE (SUBSTR (POR_KODETRANSAKSI, 1, 8),
                'YYYY-MM-DD') BETWEEN to_date('" . $tgl1 . "','dd/mm/yyyy') AND to_date('" . $tgl2 . "','dd/mm/yyyy'))
                ")[0]->jml;

            if (!isset($temp2)) {
                $t_pe = 0;
            } else {
                $t_pe = $temp2;
            }


//   -------- TOTAL
            $total = $t_pe + $t_pi;

            $filename = 'igr-fo-rwd-trn-dtl';
            $data = DB::select("SELECT PRS_NAMAPERUSAHAAN, PRS_NAMACABANG, KODEMEMBER || ' - ' || NAMAMEMBER KODEMEMBER, RECORDID, TGL, TRN, JS, JML, KET,
                   case WHEN FLAG = 'Y' THEN JML END VALID, case WHEN NVL(FLAG, 'N') <> 'Y' THEN JML END NOTVALID
                FROM(
                    SELECT PRS_NAMAPERUSAHAAN, PRS_NAMACABANG, POR_KODEMEMBER KODEMEMBER, CUS_NAMAMEMBER NAMAMEMBER, POR_RECORDID RECORDID,
                    TO_DATE(SUBSTR(POR_KODETRANSAKSI, 1, 8), 'YYYY-MM-DD') TGL ,
                    SUBSTR(POR_KODETRANSAKSI, 9, 2) || '.' || SUBSTR(POR_KODETRANSAKSI, 11, 3) || '.' || SUBSTR(POR_KODETRANSAKSI, 14, 5) TRN,
                    case WHEN INSTR(POR_DESKRIPSI, 'INTERN') > 0 THEN 'INTERN'else 'EXTERN' END JS,
                    case WHEN SUBSTR(POR_KODETRANSAKSI, 19, 1) = 'S' THEN(POR_PEROLEHANPOINT) * 1 else (POR_PEROLEHANPOINT) * -1 END JML,
                    case WHEN INSTR(POR_DESKRIPSI, 'INTERN') > 0 THEN '' else TRIM(BOTH ' ' FROM SUBSTR(POR_DESKRIPSI, 0, 24))||'.' || POR_KODEPROMOSI END KET, POR_FLAGUPDATE FLAG
                    FROM TBTR_PEROLEHANMYPOIN, TBMASTER_CUSTOMER, TBMASTER_PERUSAHAAN
                    WHERE CUS_KODEMEMBER = POR_KODEMEMBER
            and PRS_KODEIGR = POR_KODEIGR
            and POR_KODEIGR = '" . $_SESSION['kdigr'] . "'
            and POR_RECORDID IS NULL
            and TO_DATE(SUBSTR(POR_KODETRANSAKSI, 1, 8), 'YYYY-MM-DD') BETWEEN to_date('" . $tgl1 . "', 'dd/mm/yyyy') and to_date('" . $tgl2 . "', 'dd/mm/yyyy'))POR
              where rownum<100");
        }

        $perusahaan = DB::table('tbmaster_perusahaan')
            ->first();

        if (sizeof($data) != 0) {
            $data = [
                'perusahaan' => $perusahaan,
                'data' => $data,
                'tgl1' => $tgl1,
                'tgl2' => $tgl2,
                't_pi' => $t_pi,
                't_pe' => $t_pe,
                'total' => $total,
            ];

            $dompdf = new PDF();

            $pdf = PDF::loadview('FRONTOFFICE.POINTREWARDMEMBERMERAH.PEROLEHANPOINTREWARDPERTANGGAL.' . $filename . '-pdf', $data);

            error_reporting(E_ALL ^ E_DEPRECATED);

            $pdf->output();
            $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);

            $canvas = $dompdf->get_canvas();
            $canvas->page_text($cw, $ch, "Hal : {PAGE_NUM} dari {PAGE_COUNT}", null, 7, array(0, 0, 0));

            $dompdf = $pdf;


            return $dompdf->stream($filename . '_' . $tgl1 . ' - ' . $tgl2 . '.pdf');
        } else {
            return 'Tidak Ada Data!';
        }
    }
}

