<?php
/**
 * Created by PhpStorm.
 * User: ryan
 * Date: 04/10/2021
 * Time: 15:02 PM
 */

namespace App\Http\Controllers\TABEL\SETTINGHADIAHPADATRANSAKSIKASIR;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use PDF;
use DateTime;
use Yajra\DataTables\DataTables;

class hdhitemController extends Controller
{

    public function index()
    {
        return view('TABEL\SETTINGHADIAHPADATRANSAKSIKASIR.hdhitem');
    }

    public function ModalPlu(Request $request){
        $kodeigr = $_SESSION['kdigr'];
        $search = $request->value;

        $datas = DB::table("TBMASTER_PRODMAST")
            ->selectRaw("PRD_DESKRIPSIPANJANG")
            ->selectRaw("PRD_UNIT || '/' || PRD_FRAC FRAC")
            ->selectRaw("TO_CHAR(PRD_HRGJUAL, '999g999g999') HRGJUAL")
            ->selectRaw("PRD_KODETAG")
            ->selectRaw("PRD_MINJUAL JUAL")
            ->selectRaw("PRD_PRDCD")
            ->selectRaw("NULL REG")

            ->where('PRD_DESKRIPSIPANJANG','LIKE', '%'.$search.'%')
            ->where('PRD_KODEIGR','=',$kodeigr)
            ->whereRaw("SUBSTR(PRD_PRDCD,7,1) = '0'")

            ->orWhere('PRD_UNIT','LIKE', '%'.$search.'%')
            ->where('PRD_KODEIGR','=',$kodeigr)
            ->whereRaw("SUBSTR(PRD_PRDCD,7,1) = '0'")

            ->orWhere('PRD_FRAC','LIKE', '%'.$search.'%')
            ->where('PRD_KODEIGR','=',$kodeigr)
            ->whereRaw("SUBSTR(PRD_PRDCD,7,1) = '0'")

            ->orWhere('PRD_HRGJUAL','LIKE', '%'.$search.'%')
            ->where('PRD_KODEIGR','=',$kodeigr)
            ->whereRaw("SUBSTR(PRD_PRDCD,7,1) = '0'")

            ->orWhere('PRD_KODETAG','LIKE', '%'.$search.'%')
            ->where('PRD_KODEIGR','=',$kodeigr)
            ->whereRaw("SUBSTR(PRD_PRDCD,7,1) = '0'")

            ->orWhere('PRD_MINJUAL','LIKE', '%'.$search.'%')
            ->where('PRD_KODEIGR','=',$kodeigr)
            ->whereRaw("SUBSTR(PRD_PRDCD,7,1) = '0'")

            ->orWhere('PRD_PRDCD','LIKE', '%'.$search.'%')
            ->where('PRD_KODEIGR','=',$kodeigr)
            ->whereRaw("SUBSTR(PRD_PRDCD,7,1) = '0'")

            ->limit(1000)
            ->get();

//        $datas = DB::table("TBMASTER_PRODMAST")
//            ->selectRaw("PRD_DESKRIPSIPANJANG")
//            ->selectRaw("PRD_UNIT || '/' || PRD_FRAC FRAC")
//            ->selectRaw("TO_CHAR(PRD_HRGJUAL, '999g999g999') HRGJUAL")
//            ->selectRaw("PRD_KODETAG")
//            ->selectRaw("PRD_MINJUAL JUAL")
//            ->selectRaw("PRD_PRDCD")
//            ->selectRaw("NULL REG")
//            ->where('PRD_KODEIGR','=',$kodeigr)
//            ->whereRaw("SUBSTR(PRD_PRDCD,7,1) = '0'")
//            ->get();

        return Datatables::of($datas)->make(true);
    }

    public function ModalHadiah(Request $request){
        $kodeigr = $_SESSION['kdigr'];
        $search = $request->value;

        $datas = DB::table("TBMASTER_BRGPROMOSI")
            ->selectRaw("BPRP_KETPANJANG")
            ->selectRaw("BPRP_PRDCD")

            ->where('BPRP_KODEIGR','=',$kodeigr)
            ->orderBy("BPRP_KETPANJANG")

            ->get();

        return Datatables::of($datas)->make(true);
    }

    public function ModalHistory(Request $request){
        $kodeigr = $_SESSION['kdigr'];

        $datas = DB::select("SELECT ISD_PRDCD, TO_CHAR(ISD_TGLAWAL, 'dd-MM-yyyy') || ' s/d ' || TO_CHAR(ISD_TGLAKHIR,'dd-MM-yyyy') BERLAKU,
ISH_KETERANGAN, ISD_KODEPROMOSI, PRD_DESKRIPSIPANJANG FROM TBTR_INSTORE_DTL, TBTR_INSTORE_HDR, TBMASTER_PRODMAST
WHERE ISD_KODEIGR = '$kodeigr' AND ISD_JENISPROMOSI = 'I' AND ISH_KODEIGR = ISD_KODEIGR
AND ISH_JENISPROMOSI = ISD_JENISPROMOSI AND ISH_KODEPROMOSI = ISD_KODEPROMOSI AND TRUNC(ISH_TGLAWAL) = TRUNC(ISD_TGLAWAL)
AND TRUNC(ISH_TGLAKHIR) = TRUNC(ISD_TGLAKHIR) AND PRD_KODEIGR = '$kodeigr' AND PRD_PRDCD = ISD_PRDCD
ORDER BY BERLAKU, ISD_PRDCD");

        return Datatables::of($datas)->make(true);
    }

    public function CheckPlu(Request $request){
        $kodeigr = $_SESSION['kdigr'];
        $prd = $request->prd;

        $datas = DB::select("SELECT prd_prdcd, PRD_DESKRIPSIPANJANG || '-' || PRD_UNIT || '/' || PRD_FRAC as deskripsi
          FROM TBMASTER_PRODMAST, TBMASTER_BARCODE
         WHERE prd_kodeigr = '22'
           AND prd_prdcd = brc_prdcd(+)
           AND (prd_prdcd = TRIM ('$prd') OR brc_barcode = TRIM ('$prd'))");

        if(sizeof($datas) != 0){
            //#NOTE# :TXT_KODE di program lama nilainya sekalu null
            $temp = DB::table("TBTR_INSTORE_DTL")
                ->selectRaw("NVL(COUNT(1),0) as result")
                ->where("ISD_KODEIGR",'=',$kodeigr)
                ->where("ISD_JENISPROMOSI",'=','I')
                ->where("ISD_PRDCD",'=',$datas[0]->prd_prdcd)
                ->first();
            if((int)$temp->result == 0){
                $status = 'baru';
            }else{
                $status = 'tidak baru';
            }

            return response()->json(['prdcd' => $datas[0]->prd_prdcd, 'deskripsi' =>$datas[0]->deskripsi, 'status' => $status]);
        }else{
            return response()->json('0');
        }
    }

    public function cetak(Request $request){
        $kodeigr = $_SESSION['kdigr'];

        $cab1 = $request->cab1;
        $cab2 = $request->cab2;
        $pb1 = $request->pb1;
        $pb2 = $request->pb2;
        $pilihan = $request->pilihan;

        $and_nopb = '';
        if($pb1 != '' && $pb2 != ''){
            $and_nopb = " and TRIM(pbo_nopb) between '".$pb1."' and '".$pb2."'";
        }

        $and_cab = '';
        if($cab1 != '' && $cab2 != ''){
            $and_cab = " and TRIM(pbo_kodeomi) between '".$cab1."' and '".$cab2."'";
        }
        $p_prog = 'LAP224';

        $dateA = $request->date1;
        $dateB = $request->date2;
        $sDate = DateTime::createFromFormat('d-m-Y', $dateA)->format('d-m-Y');
        $eDate = DateTime::createFromFormat('d-m-Y', $dateB)->format('d-m-Y');

        if($pilihan == 'D'){
            $datas = DB::select("SELECT NVL(COUNT(*),0) itemo, pbo_nopb, tglstruk, pbo_kodeomi, kodemember,
     pbo_nostruk, pbo_recordid, pbo_nokoli, tglgo, SUM(pbo_qtyorder) qtyo,
     SUM(pbo_nilaiorder) nilaio, SUM(pbo_ppnorder) ppno, SUM(qtyr) qtyr,
     SUM(nilair) nilair, SUM(itemr) itemr, tko_namaomi, namamember,
     prs_namaperusahaan, prs_namacabang, prs_namawilayah
FROM
(    SELECT TRIM(pbo_nopb) pbo_nopb, TRUNC(pbo_tglstruk) tglstruk, pbo_nostruk,
          pbo_kodeomi, pbo_kodemember kodemember, pbo_recordid, pbo_nokoli,
          CASE WHEN pbo_recordid IN('4','5') THEN
                 pbo_qtyrealisasi
          ELSE
                 0
          END qtyr,
          CASE WHEN pbo_recordid IN('4','5') THEN
                 pbo_ttlnilai
          ELSE
                 0
          END nilair,
          CASE WHEN pbo_recordid IN('4','5') THEN
                 1
          ELSE
                 0
          END itemr,
          pbo_qtyorder, pbo_nilaiorder, pbo_ppnorder,
          tko_namaomi, TRUNC(tko_tglgo) tglgo, SUBSTR(cus_namamember,1,30) namamember,
          prs_namaperusahaan, prs_namacabang, prs_namawilayah
    FROM TBMASTER_PBOMI, TBMASTER_TOKOIGR, TBMASTER_CUSTOMER, TBMASTER_PERUSAHAAN
    WHERE pbo_kodeigr = '$kodeigr'
and pbo_qtyorder > 0
    AND TRUNC(pbo_create_dt) BETWEEN TO_DATE('$sDate','DD-MM-YYYY') AND TO_DATE('$eDate', 'DD-MM-YYYY')
    ".$and_nopb."
    AND SUBSTR(pbo_pluigr,1,6) NOT IN ('074828', '074829')
    ".$and_cab."
    AND (SUBSTR(pbo_nostruk,-3,3) <> 'BKL'  OR pbo_nostruk IS NULL)
    AND tko_kodeigr = pbo_kodeigr
    AND tko_kodeomi = pbo_kodeomi
    --AND cus_kodeigr(+) = pbo_kodeigr
    AND cus_kodemember(+) = pbo_kodemember
    AND prs_kodeigr = pbo_kodeigr
)
GROUP BY pbo_nopb, tglstruk, pbo_kodeomi, pbo_nostruk, kodemember,
                    pbo_recordid, pbo_nokoli, namamember, tglgo, tko_namaomi,
                    prs_namaperusahaan, prs_namacabang, prs_namawilayah
ORDER BY kodemember, pbo_kodeomi, pbo_nopb, tglstruk");
        }else{
            $datas = DB::select("SELECT pbo_kodeomi, kodemember, tglgo,
     SUM(pbo_qtyorder) qtyo, SUM(pbo_nilaiorder) nilaio,
     SUM(qtyr) qtyr, SUM(nilair) nilair, SUM(itemr) itemr,
     SUM(itemo) itemo, tko_namaomi, cus_namamember,
     prs_namaperusahaan, prs_namacabang, prs_namawilayah
FROM
(    SELECT pbo_kodeomi, pbo_kodemember kodemember,
          TRUNC(tko_tglgo) tglgo, pbo_qtyorder, pbo_nilaiorder, 1 itemo, tko_namaomi,
          CASE WHEN pbo_recordid IN('4','5') THEN
                 pbo_qtyrealisasi
          ELSE
                 0
          END qtyr,
          CASE WHEN pbo_recordid IN('4','5') THEN
                 pbo_ttlnilai
          ELSE
                 0
          END nilair,
          CASE WHEN pbo_recordid IN('4','5') THEN
                 1
          ELSE
                 0
          END itemr,
          cus_namamember, prs_namaperusahaan, prs_namacabang, prs_namawilayah
    FROM TBMASTER_PBOMI, TBMASTER_TOKOIGR,
          TBMASTER_CUSTOMER, TBMASTER_PERUSAHAAN
    WHERE pbo_kodeigr = '$kodeigr'
    AND TRUNC(pbo_create_dt) BETWEEN TO_DATE('$sDate','DD-MM-YYYY') AND TO_DATE('$eDate', 'DD-MM-YYYY')
    ".$and_nopb."
    AND SUBSTR(pbo_pluigr,1,6) NOT IN ('074828', '074829')
    AND (SUBSTR(pbo_nostruk,-3,3) <> 'BKL'  OR pbo_nostruk IS NULL)
    ".$and_cab."
    AND tko_kodeigr = pbo_kodeigr
    AND tko_kodeomi = pbo_kodeomi
    --AND cus_kodeigr(+) = pbo_kodeigr
    AND cus_kodemember(+) = pbo_kodemember
    AND prs_kodeigr = pbo_kodeigr
)
GROUP BY pbo_kodeomi, kodemember, tglgo, tko_namaomi,
                    cus_namamember, prs_namaperusahaan, prs_namacabang, prs_namawilayah
ORDER BY kodemember, pbo_kodeomi");
        }

        if(sizeof($datas) == 0){
            return "**DATA TIDAK ADA**";
        }

        $val['tnilo'] = 0; $val['tnilr'] = 0;
        $val['tqtyo'] = 0; $val['tqtyr'] = 0;
        $val['titemo'] = 0; $val['titemr'] = 0;
        for($i=0;$i<sizeof($datas);$i++){
            $val['tnilo'] = $val['tnilo'] + $datas[$i]->nilaio;
            $val['tnilr'] = $val['tnilr'] + $datas[$i]->nilair;

            $val['tqtyo'] = $val['tqtyo'] + $datas[$i]->qtyo;
            $val['tqtyr'] = $val['tqtyr'] + $datas[$i]->qtyr;

            $val['titemo'] = $val['titemo'] + $datas[$i]->itemo;
            $val['titemr'] = $val['titemr'] + $datas[$i]->itemr;
        }

        if($val['tnilo'] == 0 || $val['tnilr'] == 0){
            $val['totnil'] = 0;
        }else{
            $val['totnil'] = round(($val['tnilr']/$val['tnilo']) *100,2);
        }

        if($val['tqtyo'] == 0 || $val['tqtyr'] == 0){
            $val['totqty'] = 0;
        }else{
            $val['totqty'] = round(($val['tqtyr']/$val['tqtyo']) *100,2);
        }

        if($val['titemo'] == 0 || $val['titemr'] == 0){
            $val['totitem'] = 0;
        }else{
            $val['totitem'] = round(($val['titemr']/$val['titemo']) *100,2);
        }

        //PRINT
        $today = date('d-m-Y');
        $time = date('H:i:s');

        if($pilihan == 'D'){
            return view('OMI\LAPORAN\lapsvlslspb_detail-pdf',
                ['kodeigr' => $kodeigr, 'datas' => $datas, 'today' => $today, 'time' => $time, 'date1' => $dateA, 'date2' => $dateB, 'pb1' => $pb1, 'pb2' => $pb2, 'val' => $val]);
        }else{
            $pdf = PDF::loadview('OMI\LAPORAN\lapsvlslspb-pdf',
                ['kodeigr' => $kodeigr, 'datas' => $datas, 'today' => $today, 'time' => $time, 'date1' => $dateA, 'date2' => $dateB, 'pb1' => $pb1, 'pb2' => $pb2, 'val' => $val]);
            $pdf->setPaper('A4', 'potrait');
            $pdf->output();
            $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);

            $canvas = $dompdf ->get_canvas();
            $canvas->page_text(524, 12, "HAL {PAGE_NUM} / {PAGE_COUNT}", null, 7, array(0, 0, 0));

            return $pdf->stream('OMI\LAPORAN\lapsvlslspb-pdf');
        }
    }
}
