<?php
/**
 * Created by PhpStorm.
 * User: ryan
 * Date: 23/08/2021
 * Time: 2:15 PM
 */

namespace App\Http\Controllers\FRONTOFFICE;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use PDF;
use DateTime;
use Yajra\DataTables\DataTables;

class uniquecodeController extends Controller
{

    public function index()
    {
        return view('FRONTOFFICE.uniquecode');
    }

    public function getCashBack(){
        $datas = DB::connection($_SESSION['connection'])->table('tbtr_cashback_hdr')
            ->selectRaw('cbh_kodepromosi')
            ->selectRaw('cbh_namapromosi')
            ->selectRaw("TO_CHAR(TRUNC(cbh_tglawal), 'dd-mm-yyyy') as cbh_tglawal")
            ->selectRaw("TO_CHAR(TRUNC(cbh_tglakhir), 'dd-mm-yyyy') as cbh_tglakhir")

            ->whereRaw("nvl(cbh_kiosk, 'N') = 'Y'")
            ->get()->toArray();

        return Datatables::of($datas)->make(true);
    }

    public function getGift(){
        $datas = DB::connection($_SESSION['connection'])->table('tbtr_gift_hdr')
            ->selectRaw('gfh_kodepromosi')
            ->selectRaw('gfh_namapromosi')
            ->selectRaw("TO_CHAR(TRUNC(gfh_tglawal), 'dd-mm-yyyy') as gfh_tglawal")
            ->selectRaw("TO_CHAR(TRUNC(gfh_tglakhir), 'dd-mm-yyyy') as gfh_tglakhir")

            ->whereRaw("nvl(gfh_kiosk, 'N') = 'Y'")
            ->get()->toArray();

        return Datatables::of($datas)->make(true);
    }

    public function getPembanding(){
        $kodeigr = $_SESSION['kdigr'];

//        $datas = DB::connection($_SESSION['connection'])->table('tbmaster_prodmast')
//            ->selectRaw('prd_deskripsipendek')
//            ->selectRaw('prd_prdcd')
//
//            ->where("prd_kodeigr",'=',$kodeigr)
//            ->where("prd_prdcd",'LIKE',"%0")
//
//            ->orderBy("prd_prdcd")
//            ->get()->toArray();

        //NOTE, langsung menampilkan plu dari prodmast dan barcode, agar proses lebih cepat (tidak perlu request data lagi)
        $datas = DB::connection($_SESSION['connection'])->select("SELECT PRD_PRDCD, PRD_DESKRIPSIPENDEK
          FROM TBMASTER_PRODMAST, TBMASTER_BARCODE
         WHERE PRD_KODEIGR = '$kodeigr'
           AND PRD_PRDCD LIKE '%0'
           AND PRD_PRDCD = BRC_PRDCD(+)");

        return Datatables::of($datas)->make(true);
    }

    public function cetak(Request $request){
        $kodeigr = $_SESSION['kdigr'];

        $jenisPromosi = $request->jenisPromosi;
        $kodePromosi = $request->kodePromosi;
        $namaPromosi = $request->namaPromosi;

        $tglSales1 = $request->tglSales1;
        $tglSales2 = $request->tglSales2;
        $sDate = DateTime::createFromFormat('d-m-Y', $tglSales1)->format('d-m-Y');
        $eDate = DateTime::createFromFormat('d-m-Y', $tglSales2)->format('d-m-Y');
        $tglPromo1 = $request->tglPromo1;
        $tglPromo2 = $request->tglPromo2;

        $jenisMember = $request->jenisMember;
        $kodePembanding = $request->kodePembanding;
        $namaPembanding = $request->namaPembanding;
        $minPembelian = (int)$request->minPembelian;

        if($jenisMember == 'khusus'){
            $seg1 = 'K';
            $seg2 = 'K';
            if($kodePembanding != ''){
                $temp = DB::connection($_SESSION['connection'])->select("SELECT NVL (COUNT (1), 0) as result
              FROM (SELECT DISTINCT TRJD_CUS_KODEMEMBER
                               FROM (SELECT   TRJD_CUS_KODEMEMBER,
                                              SUM (TRJD_QUANTITY * PRD_FRAC) QTY
                                         FROM TBTR_JUALDETAIL, TBMASTER_PRODMAST, TBMASTER_CUSTOMER
                                        WHERE TRUNC (TRJD_TRANSACTIONDATE) BETWEEN TO_DATE('$sDate','DD-MM-YYYY') AND TO_DATE('$eDate', 'DD-MM-YYYY')
                                          AND SUBSTR (TRJD_PRDCD, 1, 6) =
                                                                         SUBSTR ('$kodePembanding', 1, 6)
                                          AND PRD_PRDCD = TRJD_PRDCD
                                          AND CUS_KODEMEMBER = TRJD_CUS_KODEMEMBER
                                          AND NVL (CUS_FLAGMEMBERKHUSUS, 'N') = 'Y'
                                     GROUP BY TRJD_CUS_KODEMEMBER) A
                              WHERE NVL (QTY, 0) >= NVL ('$minPembelian', 0)) B");
                $memb_banding = (int)$temp[0]->result;
            }else{
                $memb_banding = 0;
            }

            if($jenisPromosi == 'cashback'){
                $memb_unique = DB::connection($_SESSION['connection'])->select("SELECT NVL (COUNT (1), 0) as result
              FROM (SELECT DISTINCT UCK_KODEMEMBER
                               FROM TBTR_UNIQUECODE_KIOSK, M_PROMOSI_H, TBMASTER_CUSTOMER
                              WHERE UCK_KODEPROMOSI = '$kodePromosi'
                                AND NVL (UCK_FLAGTERPAKAI, 'N') = 'Y'
                                AND TRUNC (UCK_CREATE_TIME) BETWEEN TO_DATE('$sDate','DD-MM-YYYY') AND TO_DATE('$eDate', 'DD-MM-YYYY')
                                AND KD_PROMOSI = UCK_KODEPROMOSI
                                AND KD_MEMBER = UCK_KODEMEMBER
                                AND TGL_TRANS = TRUNC (UCK_CREATE_TIME)
                                AND CUS_KODEMEMBER = UCK_KODEMEMBER
                                AND NVL (CUS_FLAGMEMBERKHUSUS, 'N') = 'Y') B");
            }else{
                $memb_unique = DB::connection($_SESSION['connection'])->select("SELECT NVL (COUNT (1), 0) as result
              FROM (SELECT DISTINCT UCK_KODEMEMBER
                               FROM TBTR_UNIQUECODE_KIOSK, M_GIFT_H, TBMASTER_CUSTOMER
                              WHERE UCK_KODEPROMOSI = '$kodePromosi'
                                AND NVL (UCK_FLAGTERPAKAI, 'N') = 'Y'
                                AND TRUNC (UCK_CREATE_TIME) BETWEEN TO_DATE('$sDate','DD-MM-YYYY') AND TO_DATE('$eDate', 'DD-MM-YYYY')
                                AND KD_PROMOSI = UCK_KODEPROMOSI
                                AND KD_MEMBER = UCK_KODEMEMBER
                                AND TGL_TRANS = TRUNC (UCK_CREATE_TIME)
                                AND CUS_KODEMEMBER = UCK_KODEMEMBER
                                AND NVL (CUS_FLAGMEMBERKHUSUS, 'N') = 'Y') B");
            }
        }elseif ($jenisMember == 'biasa'){
            $seg1 = 'B';
            $seg2 = 'B';
            if($kodePembanding != ''){
                $temp = DB::connection($_SESSION['connection'])->select("SELECT NVL (COUNT (1), 0) as result
              FROM (SELECT DISTINCT TRJD_CUS_KODEMEMBER
                               FROM (SELECT   TRJD_CUS_KODEMEMBER,
                                              SUM (TRJD_QUANTITY * PRD_FRAC) QTY
                                         FROM TBTR_JUALDETAIL, TBMASTER_PRODMAST, TBMASTER_CUSTOMER
                                        WHERE TRUNC (TRJD_TRANSACTIONDATE) BETWEEN TO_DATE('$sDate','DD-MM-YYYY') AND TO_DATE('$eDate', 'DD-MM-YYYY')
                                          AND SUBSTR (TRJD_PRDCD, 1, 6) =
                                                                         SUBSTR ('$kodePembanding', 1, 6)
                                          AND PRD_PRDCD = TRJD_PRDCD
                                          AND CUS_KODEMEMBER = TRJD_CUS_KODEMEMBER
                                          AND NVL (CUS_FLAGMEMBERKHUSUS, 'N') <> 'Y'
                                     GROUP BY TRJD_CUS_KODEMEMBER) A
                              WHERE NVL (QTY, 0) >= NVL ('$minPembelian', 0)) B");
                $memb_banding = (int)$temp[0]->result;
            }else{
                $memb_banding = 0;
            }

            if($jenisPromosi == 'cashback'){
                $memb_unique = DB::connection($_SESSION['connection'])->select("SELECT NVL (COUNT (1), 0) as result
              FROM (SELECT DISTINCT UCK_KODEMEMBER
                               FROM TBTR_UNIQUECODE_KIOSK, M_PROMOSI_H, TBMASTER_CUSTOMER
                              WHERE UCK_KODEPROMOSI = '$kodePromosi'
                                AND NVL (UCK_FLAGTERPAKAI, 'N') = 'Y'
                                AND TRUNC (UCK_CREATE_TIME) BETWEEN TO_DATE('$sDate','DD-MM-YYYY') AND TO_DATE('$eDate', 'DD-MM-YYYY')
                                AND KD_PROMOSI = UCK_KODEPROMOSI
                                AND KD_MEMBER = UCK_KODEMEMBER
                                AND TGL_TRANS = TRUNC (UCK_CREATE_TIME)
                                AND CUS_KODEMEMBER = UCK_KODEMEMBER
                                AND NVL (CUS_FLAGMEMBERKHUSUS, 'N') <> 'Y') B");
            }else{
                $memb_unique = DB::connection($_SESSION['connection'])->select("SELECT NVL (COUNT (1), 0) as result
              FROM (SELECT DISTINCT UCK_KODEMEMBER
                               FROM TBTR_UNIQUECODE_KIOSK, M_GIFT_H, TBMASTER_CUSTOMER
                              WHERE UCK_KODEPROMOSI = '$kodePromosi'
                                AND NVL (UCK_FLAGTERPAKAI, 'N') = 'Y'
                                AND TRUNC (UCK_CREATE_TIME) BETWEEN TO_DATE('$sDate','DD-MM-YYYY') AND TO_DATE('$eDate', 'DD-MM-YYYY')
                                AND KD_PROMOSI = UCK_KODEPROMOSI
                                AND KD_MEMBER = UCK_KODEMEMBER
                                AND TGL_TRANS = TRUNC (UCK_CREATE_TIME)
                                AND CUS_KODEMEMBER = UCK_KODEMEMBER
                                AND NVL (CUS_FLAGMEMBERKHUSUS, 'N') <> 'Y') B");
            }
        }else{
            $seg1 = 'K';
            $seg2 = 'B';

            if($kodePembanding != ''){
                $temp = DB::connection($_SESSION['connection'])->select("SELECT NVL (COUNT (1), 0) as result
              FROM (SELECT DISTINCT TRJD_CUS_KODEMEMBER
                               FROM (SELECT   TRJD_CUS_KODEMEMBER,
                                              SUM (TRJD_QUANTITY * PRD_FRAC) QTY
                                         FROM TBTR_JUALDETAIL, TBMASTER_PRODMAST
                                        WHERE TRUNC (TRJD_TRANSACTIONDATE) BETWEEN TO_DATE('$sDate','DD-MM-YYYY') AND TO_DATE('$eDate', 'DD-MM-YYYY')
                                          AND SUBSTR (TRJD_PRDCD, 1, 6) =
                                                                         SUBSTR ('$kodePembanding', 1, 6)
                                          AND PRD_PRDCD = TRJD_PRDCD
                                     GROUP BY TRJD_CUS_KODEMEMBER) A
                              WHERE NVL (QTY, 0) >= NVL ('$minPembelian', 0)) B");
                $memb_banding = (int)$temp[0]->result;
            }else{
                $memb_banding = 0;
            }

            if($jenisPromosi == 'cashback'){
                $memb_unique = DB::connection($_SESSION['connection'])->select("SELECT NVL (COUNT (1), 0) as result
              FROM (SELECT DISTINCT UCK_KODEMEMBER
                               FROM TBTR_UNIQUECODE_KIOSK, M_PROMOSI_H
                              WHERE UCK_KODEPROMOSI = '$kodePromosi'
                                AND NVL (UCK_FLAGTERPAKAI, 'N') = 'Y'
                                AND TRUNC (UCK_CREATE_TIME) BETWEEN TO_DATE('$sDate','DD-MM-YYYY') AND TO_DATE('$eDate', 'DD-MM-YYYY')
                                AND KD_PROMOSI = UCK_KODEPROMOSI
                                AND KD_MEMBER = UCK_KODEMEMBER
                                AND TGL_TRANS = TRUNC (UCK_CREATE_TIME)) B");
            }else{
                $memb_unique = DB::connection($_SESSION['connection'])->select("SELECT NVL (COUNT (1), 0) as result
              FROM (SELECT DISTINCT UCK_KODEMEMBER
                               FROM TBTR_UNIQUECODE_KIOSK, M_GIFT_H
                              WHERE UCK_KODEPROMOSI = '$kodePromosi'
                                AND NVL (UCK_FLAGTERPAKAI, 'N') = 'Y'
                                AND TRUNC (UCK_CREATE_TIME) BETWEEN TO_DATE('$sDate','DD-MM-YYYY') AND TO_DATE('$eDate', 'DD-MM-YYYY')
                                AND KD_PROMOSI = UCK_KODEPROMOSI
                                AND KD_MEMBER = UCK_KODEMEMBER
                                AND TGL_TRANS = TRUNC (UCK_CREATE_TIME)) B");
            }
        }

        $kunj = DB::connection($_SESSION['connection'])->select("SELECT TOTALK
      FROM (SELECT SUM (TOTALK) TOTALK
              FROM (SELECT   SUM (TOTALK) AS TOTALK, SEGMEN
                        FROM (SELECT   COUNT (*) AS TOTALK, LGK_SEGMENTASI,
                                       CASE
                                           WHEN LGK_SEGMENTASI = 7
                                               THEN 'B'
                                           ELSE 'K'
                                       END AS SEGMEN
                                  FROM (SELECT DISTINCT LGK_KODEMEMBER, LGK_SEGMENTASI
                                                   FROM TBTR_LOGKIOSKIGR
                                                  WHERE LGK_LOGIN_DT BETWEEN TO_DATE('$sDate','DD-MM-YYYY') AND TO_DATE('$eDate', 'DD-MM-YYYY'))
                              GROUP BY LGK_SEGMENTASI)
                    GROUP BY SEGMEN
                    ORDER BY SEGMEN DESC) A
             WHERE SEGMEN = '$seg1' OR SEGMEN = '$seg2') C");

        if($memb_banding == 0){
            $memb_persen = 0;
        }else{
            $memb_persen = round(((float)$memb_unique[0]->result / (float)$memb_banding)*100,2);
        }

        //PRINT
        $today = date('d-m-Y');
        $time = date('H:i:s');
        $tempPromosi = $kodePromosi.' - '.$namaPromosi;
        if($kodePembanding != ''){
            $tempPembanding = $kodePembanding.' - '.$namaPembanding;
        }else{
            $tempPembanding = ' - ';
        }

        $datas = DB::connection($_SESSION['connection'])->table("tbmaster_perusahaan")
            ->selectRaw("prs_namaperusahaan")
            ->selectRaw("prs_namacabang")
            ->where("prs_kodeigr",'=',$kodeigr)
            ->first();

        $pdf = PDF::loadview('FRONTOFFICE.uniquecode-pdf',
            ['kodeigr' => $kodeigr, 'datas' => $datas, 'kunj' => $kunj[0]->totalk, 'banding' => $memb_banding, 'unique' => (int)$memb_unique[0]->result,
                'persen' => $memb_persen, 'promosi' => $tempPromosi, 'tglawal' => $tglSales1, 'tglakhir' => $tglSales2,
                'tglpromo1' => $tglPromo1, 'tglpromo2' => $tglPromo2, 'member' => strtoupper($jenisMember),
                'item' => $tempPembanding, 'minbeli' => $minPembelian, 'today' => $today, 'time' => $time]);
        $pdf->setPaper('A4', 'potrait');
        $pdf->output();
        $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);

        $canvas = $dompdf ->get_canvas();
        $canvas->page_text(509, 33, "HAL : {PAGE_NUM} / {PAGE_COUNT}", null, 8, array(0, 0, 0));

        return $pdf->stream('uniquecode.pdf');
    }
}
