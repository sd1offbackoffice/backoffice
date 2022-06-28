<?php

namespace App\Http\Controllers\OMI\LAPORAN;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use PDF;
use DateTime;
use Yajra\DataTables\DataTables;

class LaporanRegisterPPRController extends Controller
{

    public function index()
    {
        return view('OMI.LAPORAN.LAPORANREGISTERPPR.laporan-register-ppr');
    }

    public function lovNodoc(Request $request)
    {
        $search = $request->value;
        $tipe = $request->tipe;
        if ($tipe == 'OMI') {
            $data = DB::connection(Session::get('connection'))->table('TBTR_RETUROMI')
                ->select('rom_nodokumen as nodoc')
                ->Where('rom_nodokumen', 'LIKE', '%' . $search . '%')
                ->orderBy('rom_nodokumen', 'desc')
                ->distinct()
                ->limit(100)
                ->get();
        } else if ($tipe == 'IDM') {
            $data = DB::connection(Session::get('connection'))->table('tbtr_piutang')
                ->select('trpt_salesinvoiceno as nodoc')
                ->Where('trpt_salesinvoiceno', 'LIKE', '%' . $search . '%')
                ->orderBy('trpt_salesinvoiceno', 'desc')
                ->distinct()
                ->limit(100)
                ->get();
        }
        return DataTables::of($data)->make(true);
    }

    public function cetak(Request $request)
    {
        $tgl1 = $request->tgl1;
        $tgl2 = $request->tgl2;
        $nodoc1 = $request->nodoc1;
        $nodoc2 = $request->nodoc2;
        $member1 = $request->member1;
        $member2 = $request->member2;
        $tipe = $request->tipe;

        $and_doc = '';
        $data = '';
        $filename = '';

        $w = 665;
        $h = 50.75;
        if ($tipe == 'OMI') {
            if (isset($nodoc2) && isset($nodoc1)) {
                $and_doc = " and rom_nodokumen between '" . $nodoc1 . "' and '" . $nodoc2 . "'";
            }
            $data = DB::connection(Session::get('connection'))->select("SELECT PRD_FLAGBKP1, PRD_FLAGBKP2,  ROM_NODOKUMEN, TGLDOK, ROM_NOREFERENSI, ROM_MEMBER, ROM_KODETOKO, CUS_NAMAMEMBER, CUS_NPWP,
         SUM (ROM_QTY) QTY, SUM (ROM_QTYTLR) QTYTLR, SUM (HRGSAT) HRGSAT, SUM (ROM_TTL) TOTAL,
         SUM (PPN) PPN, SUM (ITEM) ITEM, SUM (HARGA) HARGA, PRS_NAMAPERUSAHAAN, PRS_NAMACABANG,
         PRS_NAMAWILAYAH
    FROM (SELECT PRD_FLAGBKP1, PRD_FLAGBKP2, ROM_NODOKUMEN, TRUNC (ROM_TGLDOKUMEN) TGLDOK, lpad(to_char(ROM_NOREFERENSI),7,'0') ROM_NOREFERENSI, ROM_MEMBER,
                 ROM_KODETOKO, CUS_NPWP, ROM_QTY, ROM_QTYTLR, CUS_NAMAMEMBER, 1 ITEM, PRD_UNIT,
                 ROM_TTL, CASE
                     WHEN PRD_UNIT = 'KG'
                         THEN ROM_HRG / 1000
                     ELSE ROM_HRG
                 END HRGSAT,
                 CASE
                     WHEN ROM_FLAGBKP = 'Y' AND ROM_FLAGBKP2 <> 'P'
                         THEN CASE
                                 WHEN PRD_UNIT = 'KG'
                                     THEN (ROM_TTL / 1000) / (1+ (COALESCE (prd_ppn,10)/100)) --1.1
                                 ELSE ROM_TTL / (1+ (COALESCE (prd_ppn,10)/100)) --1.1
                             END
                     ELSE ROM_TTL
                 END HARGA,
                 CASE
                     WHEN ROM_FLAGBKP = 'Y' AND ROM_FLAGBKP2 <> 'P'
                         THEN CASE
                                 WHEN PRD_UNIT = 'KG'
                                     THEN ((ROM_TTL / 1000) /  (1+ (COALESCE (prd_ppn,10)/100)) ) *  ( (COALESCE (prd_ppn,10)/100)) --((ROM_TTL / 1000) / 1.1) * 0.1
                                 ELSE (ROM_TTL / (1+ (COALESCE (prd_ppn,10)/100)) ) *  ( (COALESCE (prd_ppn,10)/100)) --(ROM_TTL / 1.1) * 0.1
                             END
                     ELSE 0
                 END PPN,
                 PRS_NAMAPERUSAHAAN, PRS_NAMACABANG, PRS_NAMAWILAYAH
            FROM TBTR_RETUROMI, TBMASTER_CUSTOMER, TBMASTER_PRODMAST, TBMASTER_PERUSAHAAN
           WHERE ROM_KODEIGR = '" . Session::get('kdigr') . "'
             AND TRUNC (ROM_TGLDOKUMEN) BETWEEN to_date('" . $tgl1 . "','dd/mm/yyyy') AND to_date('" . $tgl2 . "','dd/mm/yyyy')
            " . $and_doc . "
             AND EXISTS (SELECT 1 FROM TBMASTER_TOKOIGR WHERE TKO_KODESBU='O' AND TKO_KODECUSTOMER=ROM_MEMBER)
             AND CUS_KODEMEMBER(+) = ROM_MEMBER
             AND PRD_KODEIGR = ROM_KODEIGR
             AND PRD_PRDCD = ROM_PRDCD
             AND PRS_KODEIGR = ROM_KODEIGR)
GROUP BY PRD_FLAGBKP1,
         PRD_FLAGBKP2,
         ROM_NODOKUMEN,
         TGLDOK,
         ROM_NOREFERENSI,
         ROM_MEMBER,
         ROM_KODETOKO,
         CUS_NAMAMEMBER,
         CUS_NPWP,
         PRS_NAMAPERUSAHAAN,
         PRS_NAMACABANG,
         PRS_NAMAWILAYAH
ORDER BY TGLDOK, ROM_NODOKUMEN");
            for ($i = 0; $i < sizeof($data); $i++) {
                $cp_nonota = Self::cp_nonota($data[$i]->rom_nodokumen, $data[$i]->tgldok, $data[$i]->rom_kodetoko);
                $cp_reffp = Self::cp_reffp($data[$i]->rom_nodokumen, $data[$i]->cus_npwp);
                $data[$i]->cp_nonota = $cp_nonota;
                $data[$i]->cp_reffp = $cp_reffp;
            }
            $filename = 'igr-bo-lapregppr';
        }
        else if ($tipe == 'IDM') {
            if (isset($nodoc2) && isset($nodoc1)) {
                $and_doc = " and trpt_salesinvoiceno between '" . $nodoc1 . "' and '" . $nodoc2 . "'";
            }
            $data = DB::connection(Session::get('connection'))->select("SELECT trpt_salesinvoicedate, trpt_invoicetaxno, trpt_salesinvoiceno, trpt_cus_kodemember, trpt_netsales, trpt_ppntaxvalue,
tko_kodeomi, tko_kodesbu, CUS_NAMAMEMBER, PRS_NAMAPERUSAHAAN, PRS_NAMACABANG, PRS_NAMAWILAYAH,
(trpt_cus_kodemember  || ' - ' || CUS_NAMAMEMBER) member
FROM tbtr_piutang, tbmaster_tokoigr, tbmaster_customer, tbmaster_perusahaan
WHERE trpt_kodeigr = '" . Session::get('kdigr') . "' AND TRUNC(trpt_salesinvoicedate) BETWEEN to_date('" . $tgl1 . "','dd/mm/yyyy') AND to_date('" . $tgl2 . "','dd/mm/yyyy') AND trpt_type = 'D'
" . $and_doc . "
AND tko_kodeigr = trpt_kodeigr
AND tko_kodecustomer = trpt_cus_kodemember
AND tko_kodesbu = 'I'
AND CUS_KODEMEMBER(+) = trpt_cus_kodeMEMBER
AND PRS_KODEIGR = trpt_KODEIGR
order by trpt_salesinvoicedate, trpt_invoicetaxno, trpt_salesinvoiceno, trpt_cus_kodemember


--SELECT prd_flagbkp1, prd_flagbkp2,trpt_salesinvoicedate, trpt_invoicetaxno, trpt_salesinvoiceno, trpt_cus_kodemember, trpt_netsales, trpt_ppntaxvalue,
--                    tko_kodeomi, tko_kodesbu, CUS_NAMAMEMBER, PRS_NAMAPERUSAHAAN, PRS_NAMACABANG, PRS_NAMAWILAYAH,
--                    (trpt_cus_kodemember  || ' - ' || CUS_NAMAMEMBER) member
--                    FROM tbtr_piutang, tbmaster_tokoigr,tbmaster_prodmast, tbmaster_customer, tbmaster_perusahaan
--                    WHERE trpt_kodeigr = '" . Session::get('kdigr') . "' AND TRUNC(trpt_salesinvoicedate) BETWEEN to_date('" . $tgl1 . "','dd/mm/yyyy') AND to_date('" . $tgl2 . "','dd/mm/yyyy') AND trpt_type = 'D'
--                    " . $and_doc . "
--                    AND tko_kodeigr = trpt_kodeigr
--                    AND tko_kodecustomer = trpt_cus_kodemember
--                    AND tko_kodesbu = 'I'
--                    AND CUS_KODEMEMBER(+) = trpt_cus_kodeMEMBER
--                    AND PRS_KODEIGR = trpt_KODEIGR
--                    order by trpt_salesinvoicedate, trpt_invoicetaxno, trpt_salesinvoiceno, trpt_cus_kodemember
                    ");
            for ($i = 0; $i < sizeof($data); $i++) {
                $cf_item = Self::cf_item($data[$i]->trpt_invoicetaxno, $data[$i]->tko_kodeomi);
                $data[$i]->cf_item = $cf_item;
            }
            $filename = 'igr-bo-lapregppr-idm';
        }

        $perusahaan = DB::connection(Session::get('connection'))->table('tbmaster_perusahaan')
            ->first();

//        $date = Carbon::now();
//        $dompdf = new PDF();
//
//        $pdf = PDF::loadview('OMI.LAPORAN.LAPORANREGISTERPPR.' . $filename . '-pdf', compact(['perusahaan', 'data', 'tgl1', 'tgl2', 'nodoc1', 'nodoc2']));
//
//        error_reporting(E_ALL ^ E_DEPRECATED);
//
//        $pdf->output();
//        $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);
//
//        $canvas = $dompdf->get_canvas();
//        $canvas->page_text($w, $h, "Hal : {PAGE_NUM} dari {PAGE_COUNT}", null, 7, array(0, 0, 0));
//
//        $dompdf = $pdf;
//
//        return $dompdf->stream($filename . ' - ' . $date . '.pdf');

        return view('OMI.LAPORAN.LAPORANREGISTERPPR.' . $filename. '-pdf', compact(['perusahaan', 'data', 'tgl1', 'tgl2', 'nodoc1', 'nodoc2']));

    }

    public function cp_nonota($nodokumen, $tgldok, $rom_kodetoko)
    {
        $cp_nonota = '';
        $temp = DB::connection(Session::get('connection'))->select("SELECT count(1) count
                       FROM TBTR_RETUROMI, TBMASTER_PERUSAHAAN
                      WHERE ROM_KODEIGR = '" . Session::get('kdigr') . "'
                        AND ROM_NODOKUMEN = '" . $nodokumen . "'
                        AND ROM_FLAGBKP = 'Y'
                        AND TRUNC (ROM_TGLDOKUMEN) = to_date('" . substr($tgldok, 0, 10) . "','yyyy-mm-dd')
                        AND PRS_KODEIGR = ROM_KODEIGR")[0]->count;
        if ($temp > 0) {
            $nopajak = DB::connection(Session::get('connection'))->select("SELECT NOPAJAK
      FROM (SELECT DISTINCT ROWNUM NOURUT, ROM_KODETOKO,
                            CASE
                                WHEN NVL (ROM_NOFP1, 0) <> 0
                                    THEN LPAD (RPAD (SUBSTR (ROM_NOFP1, 1, LENGTH (ROM_NOFP1)),
        LENGTH (ROM_NOFP1),
        '0'
    ),
        7,
        '0'
    )
                                ELSE LPAD (RPAD (SUBSTR (ROM_NOFP2, 1, LENGTH (ROM_NOFP2)),
        LENGTH (ROM_NOFP2),
        '0'
    ),
        7,
        '0'
    )
                            END NOPAJAK
                       FROM TBTR_RETUROMI, TBMASTER_PERUSAHAAN
                      WHERE ROM_KODEIGR = '" . Session::get('kdigr') . "'
    AND ROM_NODOKUMEN = '" . $nodokumen . "'
    AND ROM_FLAGBKP = 'Y'
    AND TRUNC (ROM_TGLDOKUMEN) = to_date('" . substr($tgldok, 0, 10) . "','yyyy-mm-dd')
                        AND PRS_KODEIGR = ROM_KODEIGR)
     WHERE NOURUT = 1")[0]->nopajak;
        }

        if (isset($nopajak)) {
            $cp_nonota = $rom_kodetoko . substr($tgldok, 6, 2) . '.' . substr($nopajak, 1, 7);
        }
        return $cp_nonota;
    }

    public function cp_reffp($nodokumen,$cus_npwp){
        $cp_reffp='';
        $reffp = DB::connection(Session::get('connection'))->select("SELECT LPAD (TO_CHAR (ROM_REFERENSIFP), 13, '0') reffp
      FROM (SELECT   ROM_REFERENSIFP
                FROM TBTR_RETUROMI
               WHERE ROM_NODOKUMEN = '".$nodokumen."'
            ORDER BY ROM_REFERENSITGLFP DESC)
     WHERE ROWNUM = 1")[0]->reffp;

        if(isset($cus_npwp)){
            $cp_reffp.='010.'
                . substr ($reffp, 1, 3)
                . '-'
                . substr ($reffp, 4, 2)
                . '.'
                . substr ($reffp, 6, 8);
        }
        return $cp_reffp;
    }

    public function cf_item($trpt_invoicetaxno, $tko_kodeomi)
    {
        $cf_item = DB::connection(Session::get('connection'))->select("SELECT nvl(COUNT(1),0) count
  FROM tbtr_wt_interface WHERE docno = '" . $trpt_invoicetaxno . "' AND shop = '" . $tko_kodeomi . "'")[0]->count;
        return $cf_item;

    }
}
