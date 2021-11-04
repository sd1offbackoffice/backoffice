<?php
/**
 * Created by PhpStorm.
 * User: ryan
 * Date: 1/12/2021
 * Time: 3:25 PM
 */

namespace App\Http\Controllers\BACKOFFICE\KERJASAMAIGRIDM;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use PDF;

class LapBedaTagController extends Controller
{

    public function index()
    {
        return view('BACKOFFICE.KERJASAMAIGRIDM.LapBedaTag');
    }
    public function CheckData(Request $request){
        $tag = $request->tag;
        $p_tag = "";

        if($tag != '_'){
            $count = DB::connection($_SESSION['connection'])->table("tbmaster_tag")
                ->selectRaw("count(1) hsl")
                ->where("tag_kodetag",'=',$tag)
                ->first();
            if($count->hsl == 0){
                return response()->json(['kode' => 2]);
            }
            $p_tag = "AND NVL(TRIM(PRD_KODETAG),'_') = '$tag'";
        }

        $cursor = DB::connection($_SESSION['connection'])->select("SELECT   TO_CHAR (SYSDATE, 'dd MON yyyy hh24:mi:ss') TGL, PRS_NAMAPERUSAHAAN, PRS_NAMACABANG,
         IDM_PLUIDM, IDM_PLUIGR, PRD_PRDCD, IDM_TAG, PRD_KODETAG, PRD_FLAGIDM, PRD_DESKRIPSIPENDEK,
         PRD_UNIT || ' / ' || PRD_FRAC PRD_SATUAN,
         CASE
             WHEN IDM_PLUIGR IS NOT NULL
                 THEN CASE
                         WHEN PRD_FLAGIDM = 'Y'
                             THEN 'IDM ONLY'
                         ELSE 'IGR+IDM'
                     END
             ELSE 'IGR ONLY'
         END KET
    FROM TBTEMP_PLUIDM, TBMASTER_PRODMAST, TBMASTER_PERUSAHAAN
   WHERE SUBSTR (IDM_PLUIGR, 1, 6) = SUBSTR (PRD_PRDCD(+), 1, 6)
     AND NVL (trim (IDM_TAG), '_') <> NVL (trim (PRD_KODETAG), '_')
     AND PRD_KODETAG IN ('G', 'R', 'A', 'N', 'O', 'X', 'T', 'M', 'H', 'B', 'I', 'P', 'J')
     $p_tag
ORDER BY NVL (trim (PRD_PRDCD), 'zzzzzzz'), IDM_PLUIDM");
        if(!$cursor){
            return response()->json(['kode' => 1]);
        }else{
            return response()->json(['kode' => 0]);
        }
    }
    public function printDocument(Request $request){
        $kodeigr = $_SESSION['kdigr'];
        $tag = $request->tag;
        $p_tag = "";
        $today = date('d-m-Y');
        $time = date('H:i:s');

        if($tag != '_'){
            $count = DB::connection($_SESSION['connection'])->table("tbmaster_tag")
                ->selectRaw("count(1) hsl")
                ->where("tag_kodetag",'=',$tag)
                ->first();
            if($count->hsl == 0){
                return response()->json(['kode' => 2]);
            }
            $p_tag = "AND NVL(TRIM(PRD_KODETAG),'_') = '$tag'";
        }

        $datas = DB::connection($_SESSION['connection'])->select("SELECT   TO_CHAR (SYSDATE, 'dd MON yyyy hh24:mi:ss') TGL, PRS_NAMAPERUSAHAAN, PRS_NAMACABANG,
         IDM_PLUIDM, IDM_PLUIGR, PRD_PRDCD, IDM_TAG, PRD_KODETAG, PRD_FLAGIDM, PRD_DESKRIPSIPENDEK,
         PRD_UNIT || ' / ' || PRD_FRAC PRD_SATUAN,
         CASE
             WHEN IDM_PLUIGR IS NOT NULL
                 THEN CASE
                         WHEN PRD_FLAGIDM = 'Y'
                             THEN 'IDM ONLY'
                         ELSE 'IGR+IDM'
                     END
             ELSE 'IGR ONLY'
         END KET
    FROM TBTEMP_PLUIDM, TBMASTER_PRODMAST, TBMASTER_PERUSAHAAN
   WHERE SUBSTR (IDM_PLUIGR, 1, 6) = SUBSTR (PRD_PRDCD(+), 1, 6)
     AND NVL (trim (IDM_TAG), '_') <> NVL (trim (PRD_KODETAG), '_')
     AND PRD_KODETAG IN ('G', 'R', 'A', 'N', 'O', 'X', 'T', 'M', 'H', 'B', 'I', 'P', 'J')
     $p_tag
ORDER BY NVL (trim (PRD_PRDCD), 'zzzzzzz'), IDM_PLUIDM");

//        //PRINT
//        $pdf = PDF::loadview('BACKOFFICE\KERJASAMAIGRIDM.LapBedaTag-pdf',
//            ['kodeigr' => $kodeigr, 'tag' => $tag, 'datas' => $datas, 'today' => $today, 'time' => $time]);
//        $pdf->setPaper('A4', 'potrait');
//        $pdf->output();
//        $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);
//
//        $canvas = $dompdf ->get_canvas();
//        $canvas->page_text(514, 10, "Hal {PAGE_NUM} / {PAGE_COUNT}", null, 8, array(0, 0, 0));
//
//        return $pdf->stream('BACKOFFICE\KERJASAMAIGRIDM.LapBedaTag-pdf');


        return view("BACKOFFICE.KERJASAMAIGRIDM.LapBedaTag-pdf", ['kodeigr' => $kodeigr, 'tag' => $tag, 'datas' => $datas, 'today' => $today, 'time' => $time]);
    }
}
