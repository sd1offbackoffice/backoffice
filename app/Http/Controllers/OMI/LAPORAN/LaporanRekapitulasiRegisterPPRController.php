<?php
/**
 * Created by PhpStorm.
 * User: ryan
 * Date: 08/09/2021
 * Time: 9:13 AM
 */

namespace App\Http\Controllers\OMI\LAPORAN;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use PDF;
use DateTime;
use Yajra\DataTables\DataTables;

class LaporanRekapitulasiRegisterPPRController extends Controller
{

    public function index()
    {
        return view('OMI\LAPORAN.LAPORANREKAPITULASIREGISTERPPR.laporan-rekapitulasi-register-ppr');
    }
    public function lovNodoc(Request $request)
    {
        $search = $request->value;
        $tipe = $request->tipe;
        if ($tipe == 'OMI') {
            $data = DB::table('TBTR_RETUROMI')
                ->select('rom_nodokumen as nodoc')
                ->Where('rom_nodokumen', 'LIKE', '%' . $search . '%')
                ->orderBy('rom_nodokumen', 'desc')
                ->distinct()
                ->limit(100)
                ->get();
        } else if ($tipe == 'IDM') {
            $data = DB::table('tbtr_piutang')
                ->select('trpt_salesinvoiceno as nodoc')
                ->Where('trpt_salesinvoiceno', 'LIKE', '%' . $search . '%')
                ->orderBy('trpt_salesinvoiceno', 'desc')
                ->distinct()
                ->limit(100)
                ->get();
        }
        return DataTables::of($data)->make(true);
    }
    public function lovMember(Request $request)
    {
        $search = $request->value;
        $tipe = $request->tipe;
        if ($tipe == 'IDM') {
            $data = DB::table('tbtr_piutang')
                ->join('tbmaster_customer','trpt_cus_kodemember','=','cus_kodemember')
                ->select('trpt_cus_kodemember as kode_member', 'cus_namamember as nama_member')
                ->Where('trpt_cus_kodemember', 'LIKE', '%' . $search . '%')
                ->orderBy('trpt_cus_kodemember', 'asc')
                ->distinct()
                ->limit(100)
                ->get();
        } else if ($tipe == 'OMI') {
            $data = DB::table('tbtr_returomi')
                ->join('tbmaster_customer','rom_member','=','cus_kodemember')
                ->select('rom_member as kode_member', 'cus_namamember as nama_member')
                ->Where('rom_member', 'LIKE', '%' . $search . '%')
                ->orderBy('rom_member', 'asc')
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
        $and_member = '';
        $data = '';
        $filename = '';

        $w = 663;
        $h = 50.75;
        if ($tipe == 'OMI') {
            if (isset($nodoc2) && isset($nodoc1)) {
                $and_doc = " and rom_nodokumen between '" . $nodoc1 . "' and '" . $nodoc2 . "'";
            }
            if (isset($member1) && isset($member2)) {
                $and_member = " and rom_member between '" . $member1 . "' and '" . $member2 . "'";
            }
            $data = DB::select("SELECT rom_nodokumen, tgldok, rom_noreferensi, rom_tglreferensi,
                                rom_member, rom_tgltransaksi, SUM(rom_qty) qty, SUM(harga) harga,
                                SUM(hrgsat) hrgsat, SUM(item) item, SUM(rom_ttl) total, SUM(ppn) ppn,cus_namamember,
                                prs_namaperusahaan, prs_namacabang, prs_namawilayah
                            FROM(SELECT rom_nodokumen, TRUNC(rom_tgldokumen) tgldok, rom_noreferensi,
                                   rom_tglreferensi, rom_member, rom_tgltransaksi,
                                   rom_qty, cus_namamember, 1 item, rom_ttl,
                                   CASE WHEN prd_unit = 'KG' THEN
                                        rom_hrg / 1000
                                   ELSE
                                        rom_hrg / 1
                                   END hrgsat,
                                CASE WHEN rom_flagbkp = 'Y' AND rom_flagbkp2 <> 'P' THEN
                                       CASE WHEN prd_unit = 'KG' THEN
                                              (rom_ttl/ 1000) / 1.1
                                       ELSE
                                              rom_ttl / 1.1
                                       END
                                ELSE
                                       rom_ttl
                                END harga,
                            CASE WHEN rom_flagbkp = 'Y' AND rom_flagbkp2 <> 'P' THEN
                                       CASE WHEN prd_unit = 'KG' THEN
                                              ((rom_ttl / 1000) / 1.1) * 0.1
                                       ELSE
                                              (rom_ttl / 1.1) * 0.1
                                      END
                                ELSE
                                       0
                                END ppn,
                                   prs_namaperusahaan, prs_namacabang, prs_namawilayah
                               FROM TBTR_RETUROMI, TBMASTER_CUSTOMER,
                                          TBMASTER_PRODMAST, TBMASTER_PERUSAHAAN
                               WHERE rom_kodeigr = '" . $_SESSION['kdigr'] . "'
                                          AND TRUNC(rom_tgldokumen) BETWEEN to_date('" . $tgl1 . "','dd/mm/yyyy') AND to_date('" . $tgl2 . "','dd/mm/yyyy')
                                          " . $and_doc . "
                                          " . $and_member . "
                                          AND cus_kodemember(+) = rom_member
                                          AND prd_kodeigr = rom_kodeigr
                                          AND prd_prdcd = rom_prdcd
                                          AND prs_kodeigr = rom_kodeigr
                                          and exists (select 1 from tbmaster_tokoigr where tko_kodesbu='O' and tko_kodeomi=rom_kodetoko)
                               ORDER BY rom_member, rom_tgldokumen, rom_noreferensi, rom_nodokumen)
                            GROUP BY rom_nodokumen, tgldok, rom_noreferensi, rom_tglreferensi,
                                                rom_member, rom_tgltransaksi, cus_namamember,
                                                prs_namaperusahaan, prs_namacabang, prs_namawilayah");
            $filename = 'igr-bo-rekapregppr';
        } else if ($tipe == 'IDM') {
            if (isset($nodoc2) && isset($nodoc1)) {
                $and_doc = " and trpt_salesinvoiceno between '" . $nodoc1 . "' and '" . $nodoc2 . "'";
            }
            if (isset($member1) && isset($member2)) {
                $and_member = " and trpt_cus_kodemember between '" . $member1 . "' and '" . $member2 . "'";
            }
            $data = DB::select("SELECT trpt_salesinvoicedate, trpt_invoicetaxno, trpt_salesinvoiceno, trpt_cus_kodemember, trpt_netsales, trpt_ppntaxvalue,
                    tko_kodeomi, tko_kodesbu, CUS_NAMAMEMBER, PRS_NAMAPERUSAHAAN, PRS_NAMACABANG, PRS_NAMAWILAYAH,
                    (trpt_cus_kodemember  || ' - ' || CUS_NAMAMEMBER) member
                    FROM tbtr_piutang, tbmaster_tokoigr, tbmaster_customer, tbmaster_perusahaan
                    WHERE trpt_kodeigr = '" . $_SESSION['kdigr'] . "' AND TRUNC(trpt_salesinvoicedate) BETWEEN to_date('" . $tgl1 . "','dd/mm/yyyy') AND to_date('" . $tgl2 . "','dd/mm/yyyy') AND trpt_type = 'D'
                    " . $and_doc . "
                    " . $and_member . "
                    AND tko_kodeigr = trpt_kodeigr
                    AND tko_kodecustomer = trpt_cus_kodemember
                    AND tko_kodesbu = 'I'
                    AND CUS_KODEMEMBER(+) = trpt_cus_kodeMEMBER
                    AND PRS_KODEIGR = trpt_KODEIGR
                    order by trpt_cus_kodemember, trpt_salesinvoicedate, trpt_invoicetaxno, trpt_salesinvoiceno");
            for ($i = 0; $i < sizeof($data); $i++) {
                $cf_item = Self::cf_item($data[$i]->trpt_invoicetaxno, $data[$i]->tko_kodeomi);
                $data[$i]->cf_item = $cf_item;
            }
            $filename = 'igr-bo-rekapregppr-idm';
        }

        $perusahaan = DB::table('tbmaster_perusahaan')
            ->first();

        $date = Carbon::now();
        $dompdf = new PDF();

        $pdf = PDF::loadview('OMI.LAPORAN.LAPORANREKAPITULASIREGISTERPPR.' . $filename . '-pdf', compact(['perusahaan', 'data','tgl1','tgl2','nodoc1','nodoc2','member1','member2']));

        error_reporting(E_ALL ^ E_DEPRECATED);

        $pdf->output();
        $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);

        $canvas = $dompdf->get_canvas();
        $canvas->page_text($w, $h, "HAL : {PAGE_NUM} dari {PAGE_COUNT}", null, 7, array(0, 0, 0));

        $dompdf = $pdf;

        return $dompdf->stream($filename . ' - ' . $date . '.pdf');
    }

    public function cf_item($trpt_invoicetaxno, $tko_kodeomi)
    {
        $cf_item = DB::select("SELECT nvl(COUNT(1),0) count
                    FROM tbtr_wt_interface WHERE docno = '" . $trpt_invoicetaxno . "' AND shop = '" . $tko_kodeomi . "'")[0]->count;

        return $cf_item;

    }
}
