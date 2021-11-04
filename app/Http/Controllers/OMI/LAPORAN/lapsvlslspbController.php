<?php
/**
 * Created by PhpStorm.
 * User: ryan
 * Date: 20/09/2021
 * Time: 14:58 AM
 */

namespace App\Http\Controllers\OMI\LAPORAN;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use PDF;
use DateTime;
use Yajra\DataTables\DataTables;

class lapsvlslspbController extends Controller
{

    public function index()
    {
        return view('OMI.LAPORAN.lapsvlslspb');
    }

    public function pbModal(Request $request){
        $kodeigr = $_SESSION['kdigr'];

        $datas = DB::connection($_SESSION['connection'])->table("tbmaster_pbomi")
            ->selectRaw("DISTINCT pbo_nopb, pbo_kodeomi, pbo_create_dt")
            ->where('pbo_kodeigr','=',$kodeigr)
            //->whereRaw("trunc(pbo_create_dt) between :tgl1 and :tgl2")
            ->whereRaw("(SUBSTR(pbo_nostruk,-3,3) <> 'BKL'  OR pbo_nostruk IS NULL)")
            ->whereRaw("pbo_nokoli IS NULL")
            ->whereRaw("SUBSTR(pbo_pluigr,1,6) NOT IN ('074828', '074829')")
            //->limit(100)
            ->get();

        return Datatables::of($datas)->make(true);
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
            $datas = DB::connection($_SESSION['connection'])->select("SELECT NVL(COUNT(*),0) itemo, pbo_nopb, tglstruk, pbo_kodeomi, kodemember,
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
            $datas = DB::connection($_SESSION['connection'])->select("SELECT pbo_kodeomi, kodemember, tglgo,
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
            return view('OMI.LAPORAN.lapsvlslspb_detail-pdf',
                ['kodeigr' => $kodeigr, 'datas' => $datas, 'today' => $today, 'time' => $time, 'date1' => $dateA, 'date2' => $dateB, 'pb1' => $pb1, 'pb2' => $pb2, 'val' => $val]);
        }else{
            $pdf = PDF::loadview('OMI.LAPORAN.lapsvlslspb-pdf',
                ['kodeigr' => $kodeigr, 'datas' => $datas, 'today' => $today, 'time' => $time, 'date1' => $dateA, 'date2' => $dateB, 'pb1' => $pb1, 'pb2' => $pb2, 'val' => $val]);
            $pdf->setPaper('A4', 'potrait');
            $pdf->output();
            $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);

            $canvas = $dompdf ->get_canvas();
            $canvas->page_text(524, 12, "HAL {PAGE_NUM} / {PAGE_COUNT}", null, 7, array(0, 0, 0));

            return $pdf->stream('lapsvlslspb.pdf');
        }
    }
}
