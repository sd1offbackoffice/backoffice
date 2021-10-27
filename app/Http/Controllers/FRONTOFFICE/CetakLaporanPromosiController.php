<?php

namespace App\Http\Controllers\FRONTOFFICE;

use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;
use PDF;
use Yajra\DataTables\DataTables;
use File;

class CetakLaporanPromosiController extends Controller
{
    public function index()
    {

        return view('FRONTOFFICE.CETAKLAPORANPROMOSI.cetak-laporan-promosi');
    }

    public function lovKodeRak(Request $request)
    {
        $search = $request->search;

        $data = DB::select("SELECT DISTINCT LKS_KODERAK FROM TBMASTER_LOKASI
                    WHERE LKS_KODERAK LIKE 'R%' OR LKS_KODERAK LIKE 'O%' and LKS_KODERAK like '%" . $request->search . "%' ORDER BY LKS_KODERAK");

        return Datatables::of($data)->make(true);
    }

    public function lovKodePromosi(Request $request)
    {
        $search = $request->search;

        $data = DB::select("SELECT DISTINCT CBH_KODEPROMOSI AS Kode, CBH_NAMAPROMOSI AS NamaPromosi
           FROM TBMASTER_LOKASI,
                TBMASTER_PERUSAHAAN,
                TBTR_CASHBACK_DTL,
                TBTR_CASHBACK_HDR,
                TBMASTER_PRODMAST,
				TBTR_CASHBACK_ALOKASI
          WHERE LKS_KODEIGR = CBD_KODEIGR AND CBA_KODEIGR = CBD_KODEIGR AND LKS_PRDCD = CBD_PRDCD
AND CBH_KODEIGR = CBD_KODEIGR AND  CBH_KODEPROMOSI = CBD_KODEPROMOSI
AND LKS_KODEIGR = PRD_KODEIGR AND LKS_PRDCD = PRD_PRDCD
AND PRS_KODEIGR = LKS_KODEIGR AND LKS_KODERAK LIKE 'R%' AND CBH_TGLAKHIR >= SYSDATE
AND CBA_KODEPROMOSI = CBD_KODEPROMOSI
and CBH_KODEPROMOSI like '%" . $request->search . "%'
UNION ALL
SELECT DISTINCT GFH_KODEPROMOSI AS Kode, GFH_NAMAPROMOSI AS NamaPromosi
           FROM TBMASTER_LOKASI,
                TBMASTER_PERUSAHAAN,
                TBTR_GIFT_DTL,
                TBTR_GIFT_HDR,
                TBMASTER_PRODMAST,
				TBTR_GIFT_ALOKASI
          WHERE LKS_KODEIGR = GFD_KODEIGR AND LKS_PRDCD = GFD_PRDCD
AND GFH_KODEIGR = GFD_KODEIGR AND  GFH_KODEPROMOSI = GFD_KODEPROMOSI
AND LKS_KODEIGR = PRD_KODEIGR AND LKS_PRDCD = PRD_PRDCD
AND PRS_KODEIGR = LKS_KODEIGR AND LKS_KODERAK LIKE 'R%' AND GFH_TGLAKHIR >= SYSDATE
AND GFA_KODEIGR = GFD_KODEIGR AND GFA_KODEPROMOSI = GFD_KODEPROMOSI
and GFA_KODEPROMOSI like '%" . $request->search . "%'");

        return Datatables::of($data)->make(true);
    }

    public function cetak(Request $request)
    {
        $koderak1 = '';
        $koderak2 = '';
        $kodepromosi = '';
        $cetakby = $request->cetakby;
        $data = '';

        $paper = 'potrait';
        $w = 0;
        $h = 0;

        if ($cetakby == 'RAKPROMO' || $cetakby == 'RAK' || $cetakby == 'PROMO' || $cetakby == 'ALL') {
            if ($cetakby == 'RAKPROMO') {
                $koderak1 = $request->koderak;
                $koderak2 = $request->koderak;
                $kodepromosi = $request->kodepromosi;
                //CETAK_LAPCOMBO;
            } else if ($cetakby == 'RAK') {
                $koderak1 = $request->koderak;
                $koderak2 = $request->koderak;
                $kodepromosi = "%";
                //CETAK_LAP;
            } else if ($cetakby == 'PROMO') {
                $koderak1 = 'R%';
                $koderak2 = 'O%';
                $kodepromosi = $request->kodepromosi;
                //CETAK_LAPPROMO;
            } else if ($cetakby == 'ALL') {
                //CETAK_LAP_ALL;
                $koderak1 = 'R%';
                $koderak2 = 'O%';
                $kodepromosi = '%';
            }
            $filename = 'igr-promo-per-rak';

            $data = DB::select("SELECT * FROM (
                                        SELECT DISTINCT LKS_KODESUBRAK AS SubRak, LKS_SHELVINGRAK AS Shelving, CBH_TGLAWAL, CBH_TGLAKHIR,
                                                        PRS_NAMACABANG AS CABANG, PRS_NAMAPERUSAHAAN AS PERUSAHAAN, LKS_KODERAK AS RAK,
                                                        LKS_PRDCD AS PLU, PRD_DESKRIPSIPANJANG AS DESCPEN,
                                                        CONCAT (CBH_KODEPROMOSI, CONCAT (' - ', CBH_NAMAPROMOSI)) AS PROMOSI,
                                                        CASE WHEN cba_Reguler = '1' AND cba_Freepass ='1' AND  cba_Retailer ='1' THEN 'ALL' ELSE
                                                        CASE WHEN cba_Reguler = '1' THEN 'MB ' END ||
                                                        CASE WHEN cba_Freepass ='1' THEN 'FP ' END ||
                                                        CASE WHEN cba_Retailer ='1' THEN 'MM' END
                                                        END AS MemberBerlaku,
                                                        'Cashback' AS CBorGF, CBH_KODEPROMOSI
                                                   FROM TBMASTER_LOKASI,
                                                        TBMASTER_PERUSAHAAN,
                                                        TBTR_CASHBACK_DTL,
                                                        TBTR_CASHBACK_HDR,
                                                        TBMASTER_PRODMAST,
                                                        TBTR_CASHBACK_ALOKASI
                                                  WHERE LKS_KODEIGR = CBD_KODEIGR AND CBA_KODEIGR = CBD_KODEIGR AND LKS_PRDCD = CBD_PRDCD
                                        AND CBH_KODEIGR = CBD_KODEIGR AND  CBH_KODEPROMOSI = CBD_KODEPROMOSI
                                        AND LKS_KODEIGR = PRD_KODEIGR AND LKS_PRDCD = PRD_PRDCD
                                        AND PRS_KODEIGR = LKS_KODEIGR AND CBH_TGLAKHIR >= SYSDATE
                                        AND (LKS_KODERAK LIKE '" . $koderak1 . "' OR LKS_KODERAK LIKE '" . $koderak2 . "')
                                        AND CBA_KODEPROMOSI = CBD_KODEPROMOSI
                                        UNION ALL
                                        SELECT DISTINCT LKS_KODESUBRAK AS SubRak, LKS_SHELVINGRAK AS Shelving, GFH_TGLAWAL, GFH_TGLAKHIR, PRS_NAMACABANG AS CABANG, PRS_NAMAPERUSAHAAN AS PERUSAHAAN, LKS_KODERAK AS RAK,
                                                        LKS_PRDCD AS PLU, PRD_DESKRIPSIPANJANG AS DESCPEN,
                                                        CONCAT (GFH_KODEPROMOSI, CONCAT (' - ', GFH_NAMAPROMOSI)) AS PROMOSI,
                                                        CASE WHEN GFA_Reguler = '1' AND GFA_Freepass ='1' AND GFA_Retailer ='1' THEN 'ALL' ELSE
                                                        CASE WHEN GFA_Reguler = '1' THEN 'MB ' END ||
                                                        CASE WHEN GFA_Freepass ='1' THEN 'FP ' END ||
                                                        CASE WHEN GFA_Retailer ='1' THEN 'MM' END
                                                        END AS MemberBerlaku,
                                                        'Gift' AS CBorGF, GFH_KODEPROMOSI
                                                   FROM TBMASTER_LOKASI,
                                                        TBMASTER_PERUSAHAAN,
                                                        TBTR_GIFT_DTL,
                                                        TBTR_GIFT_HDR,
                                                        TBMASTER_PRODMAST,
                                                        TBTR_GIFT_ALOKASI
                                                  WHERE LKS_KODEIGR = GFD_KODEIGR AND LKS_PRDCD = GFD_PRDCD
                                        AND GFH_KODEIGR = GFD_KODEIGR AND  GFH_KODEPROMOSI = GFD_KODEPROMOSI
                                        AND LKS_KODEIGR = PRD_KODEIGR AND LKS_PRDCD = PRD_PRDCD
                                        AND PRS_KODEIGR = LKS_KODEIGR AND GFH_TGLAKHIR >= SYSDATE
                                        AND (LKS_KODERAK LIKE '" . $koderak1 . "' OR LKS_KODERAK LIKE '" . $koderak2 . "')
                                        AND GFA_KODEIGR = GFD_KODEIGR AND GFA_KODEPROMOSI = GFD_KODEPROMOSI )
                                        WHERE CBH_KODEPROMOSI LIKE '" . $kodepromosi . "'
                                        order by rak,1,2,cborgf,promosi");
        } else if ($cetakby == 'CBPRINT') {
            $koderak1 = 'R%';
            $koderak2 = 'O%';
            $kodepromosi = '%';
            $data = DB::select("SELECT DISTINCT CBH_TGLAWAL, CBH_TGLAKHIR, PRS_NAMACABANG AS CABANG, PRS_NAMAPERUSAHAAN AS PERUSAHAAN,
				CONCAT (LKS_PRDCD, CONCAT (' - ', PRD_DESKRIPSIPANJANG)) AS PLU,
                CONCAT (CBH_KODEPROMOSI, CONCAT (' - ', CBH_NAMAPROMOSI)) AS Promosi,
				CASE WHEN cba_Reguler = '1' AND cba_Freepass ='1' AND  cba_Retailer ='1' THEN 'ALL' ELSE
				CASE WHEN cba_Reguler = '1' THEN 'MB ' END ||
				CASE WHEN cba_Freepass ='1' THEN 'FP ' END ||
				CASE WHEN cba_Retailer ='1' THEN 'MM' END
				END AS MemberBerlaku,
				'Cashback' AS CBorGF, CBH_KODEPROMOSI AS KodePromosi,
				CASE WHEN CBH_JENISPROMOSI = '1' THEN CBH_CASHBACK
				ELSE CBD_CASHBACK
				END AS CashbackAMT
           FROM TBMASTER_LOKASI,
                TBMASTER_PERUSAHAAN,
                TBTR_CASHBACK_DTL,
                TBTR_CASHBACK_HDR,
                TBMASTER_PRODMAST,
				TBTR_CASHBACK_ALOKASI
          WHERE LKS_KODEIGR = CBD_KODEIGR AND CBA_KODEIGR = CBD_KODEIGR AND LKS_PRDCD = CBD_PRDCD
            AND CBH_KODEIGR = CBD_KODEIGR AND  CBH_KODEPROMOSI = CBD_KODEPROMOSI
            AND LKS_KODEIGR = PRD_KODEIGR AND LKS_PRDCD = PRD_PRDCD
            AND PRS_KODEIGR = LKS_KODEIGR AND CBH_TGLAKHIR >= SYSDATE
            AND CBA_KODEPROMOSI = CBD_KODEPROMOSI
            order by kodepromosi,plu");
            //toomuch data
            $paper = 'landscape';
            $filename = 'igr-promo-cashback';
            //CETAK_LAP_CB;
        } else if ($cetakby == 'GFPRINT') {
            $koderak1 = 'R%';
            $koderak2 = 'O%';
            $kodepromosi = '%';
            $data = DB::select("SELECT DISTINCT GFH_TGLAWAL, GFH_TGLAKHIR, PRS_NAMACABANG AS CABANG, PRS_NAMAPERUSAHAAN AS PERUSAHAAN,
				CONCAT (LKS_PRDCD, CONCAT (' - ', PRD_DESKRIPSIPANJANG)) AS PLU,
                GFH_NAMAPROMOSI AS Promosi,
				BPRP_KETPENDEK AS Hadiah,
				CASE WHEN GFA_Reguler = '1' AND GFA_Freepass ='1' AND  GFA_Retailer ='1' THEN 'ALL' ELSE
				CASE WHEN GFA_Reguler = '1' THEN 'MB ' END ||
				CASE WHEN GFA_Freepass ='1' THEN 'FP ' END ||
				CASE WHEN GFA_Retailer ='1' THEN 'MM' END
				END AS MemberBerlaku,
				'Gift' AS CBorGF, GFH_KODEPROMOSI AS KodePromosi, GFH_JMLHADIAH,
				CASE WHEN GFD_PCS = 0 THEN GFH_MINTOTSPONSOR + GFH_MINTOTBELANJA
				ELSE 0
				END AS MinBeli,
				CASE WHEN GFD_PCS > 0 THEN GFD_PCS
				ELSE 0
				END AS MinQty
           FROM TBMASTER_LOKASI,
                TBMASTER_PERUSAHAAN,
                TBTR_GIFT_DTL,
                TBTR_GIFT_HDR,
                TBMASTER_PRODMAST,
				TBTR_GIFT_ALOKASI,
				TBMASTER_BRGPROMOSI
          WHERE LKS_KODEIGR = GFD_KODEIGR AND GFA_KODEIGR = GFD_KODEIGR AND LKS_PRDCD = GFD_PRDCD
AND GFH_KODEIGR = GFD_KODEIGR AND  GFH_KODEPROMOSI = GFD_KODEPROMOSI
AND LKS_KODEIGR = PRD_KODEIGR AND LKS_PRDCD = PRD_PRDCD
AND PRS_KODEIGR = LKS_KODEIGR AND GFH_TGLAKHIR >= SYSDATE AND BPRP_PRDCD = GFH_KETHADIAH
AND GFA_KODEPROMOSI = GFD_KODEPROMOSI
order by kodepromosi,plu
");
            $paper = 'landscape';
            $filename = 'igr-promo-gift';
            //CETAK_LAP_GF;
        } else if ($cetakby == 'PRINTBESOK') {
            $data = DB::select("SELECT DISTINCT CBH_TGLAWAL, CBH_TGLAKHIR, PRS_NAMACABANG AS CABANG, PRS_NAMAPERUSAHAAN AS PERUSAHAAN,
                LKS_PRDCD AS PLU, PRD_DESKRIPSIPANJANG AS DESCPAN,
                CBH_NAMAPROMOSI AS PROMOSI,
				CASE WHEN cba_Reguler = '1' AND cba_Freepass ='1' AND  cba_Retailer ='1' THEN 'ALL' ELSE
				CASE WHEN cba_Reguler = '1' THEN 'MB ' END ||
				CASE WHEN cba_Freepass ='1' THEN 'FP ' END ||
				CASE WHEN cba_Retailer ='1' THEN 'MM' END
				END AS MemberBerlaku,
				'Cashback' AS CBorGF, CBH_KODEPROMOSI
           FROM TBMASTER_LOKASI,
                TBMASTER_PERUSAHAAN,
                TBTR_CASHBACK_DTL,
                TBTR_CASHBACK_HDR,
                TBMASTER_PRODMAST,
				TBTR_CASHBACK_ALOKASI
          WHERE LKS_KODEIGR = CBD_KODEIGR AND CBA_KODEIGR = CBD_KODEIGR AND LKS_PRDCD = CBD_PRDCD
            AND CBH_KODEIGR = CBD_KODEIGR AND  CBH_KODEPROMOSI = CBD_KODEPROMOSI
            AND LKS_KODEIGR = PRD_KODEIGR AND LKS_PRDCD = PRD_PRDCD
            AND PRS_KODEIGR = LKS_KODEIGR AND LKS_KODERAK LIKE 'R%' AND CBH_TGLAKHIR >= SYSDATE
            AND CBA_KODEPROMOSI = CBD_KODEPROMOSI
            AND CBH_TGLAKHIR BETWEEN TRUNC(SYSDATE)-100 AND TRUNC(SYSDATE)+1
UNION ALL
SELECT DISTINCT GFH_TGLAWAL, GFH_TGLAKHIR, PRS_NAMACABANG AS CABANG, PRS_NAMAPERUSAHAAN AS PERUSAHAAN,
                LKS_PRDCD AS PLU, PRD_DESKRIPSIPANJANG AS DESCPAN,
                GFH_NAMAPROMOSI AS PROMOSI,
				CASE WHEN GFA_Reguler = '1' AND GFA_Freepass ='1' AND GFA_Retailer ='1' THEN 'ALL' ELSE
				CASE WHEN GFA_Reguler = '1' THEN 'MB ' END ||
				CASE WHEN GFA_Freepass ='1' THEN 'FP ' END ||
				CASE WHEN GFA_Retailer ='1' THEN 'MM' END
				END AS MemberBerlaku,
				'Gift' AS CBorGF, GFH_KODEPROMOSI
           FROM TBMASTER_LOKASI,
                TBMASTER_PERUSAHAAN,
                TBTR_GIFT_DTL,
                TBTR_GIFT_HDR,
                TBMASTER_PRODMAST,
				TBTR_GIFT_ALOKASI
          WHERE LKS_KODEIGR = GFD_KODEIGR AND LKS_PRDCD = GFD_PRDCD
            AND GFH_KODEIGR = GFD_KODEIGR AND  GFH_KODEPROMOSI = GFD_KODEPROMOSI
            AND LKS_KODEIGR = PRD_KODEIGR AND LKS_PRDCD = PRD_PRDCD
            AND PRS_KODEIGR = LKS_KODEIGR AND LKS_KODERAK LIKE 'R%' AND GFH_TGLAKHIR >= SYSDATE
            AND GFA_KODEIGR = GFD_KODEIGR
            AND GFA_KODEPROMOSI = GFD_KODEPROMOSI
            AND GFH_TGLAKHIR BETWEEN TRUNC(SYSDATE) AND TRUNC(SYSDATE)+1");
            $filename = 'igr-promo-last-besok';
            //CETAK_LAP_BESOK;
        }

        if($paper == 'potrait'){
            $w = 492;
            $h = 74;
        }
        else{
            $w = 738;
            $h = 74;
        }
        $perusahaan = DB::table('tbmaster_perusahaan')
            ->first();

        $date = Carbon::now();
        $dompdf = new PDF();

          return view('FRONTOFFICE.CETAKLAPORANPROMOSI.'.$filename.'-pdf', compact(['perusahaan', 'data','koderak1','koderak2','kodepromosi']));

//        $pdf = PDF::loadview('FRONTOFFICE.CETAKLAPORANPROMOSI.'.$filename.'-pdf', compact(['perusahaan', 'data','koderak1','koderak2','kodepromosi']));

//        error_reporting(E_ALL ^ E_DEPRECATED);
//
////        $pdf->setPaper('A4', $paper);
//        $pdf->output();
//        $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);
//
//        $canvas = $dompdf->get_canvas();
//        $canvas->page_text(507, 77.75, "{PAGE_NUM} dari {PAGE_COUNT}", null, 7, array(0, 0, 0));
//
//        $dompdf = $pdf;

//        return $dompdf->stream($filename.' - ' . $date . '.pdf');
    }
}
