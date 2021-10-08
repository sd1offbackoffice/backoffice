<?php
/**
 * Created by PhpStorm.
 * User: ryan
 * Date: 1/12/2021
 * Time: 3:25 PM
 */

namespace App\Http\Controllers\BTAS\MONITORING;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use PDF;

class PerItemController extends Controller
{

    public function index()
    {
        $kodeigr = $_SESSION['kdigr'];

        $datas = DB::select("SELECT   TRJD_PRDCD, PRD_DESKRIPSIPENDEK, PRD_UNIT, PRD_FRAC, SUM (QTY) STRUK,
                             SUM (CUST) CUST
                        FROM (SELECT TRJD_PRDCD, PRD_DESKRIPSIPENDEK, PRD_UNIT, PRD_FRAC,
                                     NVL (TRJD_QUANTITY, 0) QTY, 1 CUST
                                FROM TBTR_SJAS_H, TBTR_JUALDETAIL, TBMASTER_PRODMAST
                               WHERE SJH_KODEIGR = '$kodeigr'
                                 AND NVL (SJH_FLAGSELESAI, 'N') <> 'Y'
                                 AND TRJD_KODEIGR = SJH_KODEIGR
                                 AND TRUNC (TRJD_TRANSACTIONDATE) = TRUNC (SJH_TGLSTRUK)
                                 AND TRJD_CASHIERSTATION || TRJD_CREATE_BY || TRJD_TRANSACTIONNO =
                                                                                         SJH_NOSTRUK
                                 AND TRJD_TRANSACTIONTYPE = 'S'
                                 AND PRD_KODEIGR = SJH_KODEIGR
                                 AND PRD_PRDCD = TRJD_PRDCD)
                    GROUP BY TRJD_PRDCD, PRD_DESKRIPSIPENDEK, PRD_UNIT, PRD_FRAC
                    ORDER BY TRJD_PRDCD");
        if(sizeof($datas) == 0){
            $qtysj[0] = "0";
        }
        for($i=0;$i<sizeof($datas);$i++){
            $pewpew = $datas[$i]->trjd_prdcd;

            $sjas = DB::select("SELECT NVL (COUNT (1), 0) as count
              FROM TBTR_SJAS_H, TBTR_SJAS_D
             WHERE SJH_KODEIGR = '$kodeigr'
               AND NVL (SJH_FLAGSELESAI, 'N') <> 'Y'
               AND SJD_NOSJAS = SJH_NOSJAS
               AND SJD_KODECUSTOMER = SJH_KODECUSTOMER
               AND SJD_PRDCD = '$pewpew'");

            if($sjas[0]->count == 0){
                $qtysj[$i] = "0";
            }else{
                $temp = DB::table("TBTR_SJAS_D")
                    ->selectRaw("(NVL (SJD_QTYSJAS, 0)) SJ")
                    ->LeftJoin('TBTR_SJAS_H',function($join){
                        $join->on('SJD_NOSJAS','SJH_NOSJAS');
                        $join->on('SJD_KODECUSTOMER','SJH_KODECUSTOMER');
                        $join->on('SJD_KODEIGR','SJH_KODEIGR');
                    })
                    ->where('SJH_KODEIGR','=',$kodeigr)
                    ->whereRaw("NVL (SJH_FLAGSELESAI, 'N') <> 'Y'")
                    ->where('SJD_PRDCD','=',$pewpew)
                    ->first();
                $qtysj[$i] = $temp->sj;
            }
        }

        return view('BTAS/MONITORING.PerItem',['datas'=>$datas,'qtysj'=>$qtysj]);
    }
    public function GetData(){
        $kodeigr = $_SESSION['kdigr'];

        $datas = DB::select("SELECT   TRJD_PRDCD, PRD_DESKRIPSIPENDEK, PRD_UNIT, PRD_FRAC, SUM (QTY) STRUK,
                             SUM (CUST) CUST
                        FROM (SELECT TRJD_PRDCD, PRD_DESKRIPSIPENDEK, PRD_UNIT, PRD_FRAC,
                                     NVL (TRJD_QUANTITY, 0) QTY, 1 CUST
                                FROM TBTR_SJAS_H, TBTR_JUALDETAIL, TBMASTER_PRODMAST
                               WHERE SJH_KODEIGR = '$kodeigr'
                                 AND NVL (SJH_FLAGSELESAI, 'N') <> 'Y'
                                 AND TRJD_KODEIGR = SJH_KODEIGR
                                 AND TRUNC (TRJD_TRANSACTIONDATE) = TRUNC (SJH_TGLSTRUK)
                                 AND TRJD_CASHIERSTATION || TRJD_CREATE_BY || TRJD_TRANSACTIONNO =
                                                                                         SJH_NOSTRUK
                                 AND TRJD_TRANSACTIONTYPE = 'S'
                                 AND PRD_KODEIGR = SJH_KODEIGR
                                 AND PRD_PRDCD = TRJD_PRDCD)
                    GROUP BY TRJD_PRDCD, PRD_DESKRIPSIPENDEK, PRD_UNIT, PRD_FRAC
                    ORDER BY TRJD_PRDCD");
        if(sizeof($datas) == 0){
            $qtysj[0] = "0";
        }
        for($i=0;$i<sizeof($datas);$i++){
            $pewpew = $datas[$i]->trjd_prdcd;

            $sjas = DB::select("SELECT NVL (COUNT (1), 0) as count
              FROM TBTR_SJAS_H, TBTR_SJAS_D
             WHERE SJH_KODEIGR = '$kodeigr'
               AND NVL (SJH_FLAGSELESAI, 'N') <> 'Y'
               AND SJD_NOSJAS = SJH_NOSJAS
               AND SJD_KODECUSTOMER = SJH_KODECUSTOMER
               AND SJD_PRDCD = '$pewpew'");

            if($sjas[0]->count == 0){
                $qtysj[$i] = "0";
            }else{
                $temp = DB::table("TBTR_SJAS_D")
                    ->selectRaw("(NVL (SJD_QTYSJAS, 0)) SJ")
                    ->LeftJoin('TBTR_SJAS_H',function($join){
                        $join->on('SJD_NOSJAS','SJH_NOSJAS');
                        $join->on('SJD_KODECUSTOMER','SJH_KODECUSTOMER');
                        $join->on('SJD_KODEIGR','SJH_KODEIGR');
                    })
                    ->where('SJH_KODEIGR','=',$kodeigr)
                    ->whereRaw("NVL (SJH_FLAGSELESAI, 'N') <> 'Y'")
                    ->where('SJD_PRDCD','=',$pewpew)
                    ->first();
                $qtysj[$i] = $temp->sj;
            }
        }
        return response()->json(['datas'=>$datas,'qtysj'=>$qtysj]);
    }

    public function SortDesc(){
        $kodeigr = $_SESSION['kdigr'];

        $datas = DB::select("SELECT   TRJD_PRDCD, PRD_DESKRIPSIPENDEK, PRD_UNIT, PRD_FRAC, SUM (QTY) STRUK,
                             SUM (CUST) CUST
                        FROM (SELECT TRJD_PRDCD, PRD_DESKRIPSIPENDEK, PRD_UNIT, PRD_FRAC,
                                     NVL (TRJD_QUANTITY, 0) QTY, 1 CUST
                                FROM TBTR_SJAS_H, TBTR_JUALDETAIL, TBMASTER_PRODMAST
                               WHERE SJH_KODEIGR = '$kodeigr'
                                 AND NVL (SJH_FLAGSELESAI, 'N') <> 'Y'
                                 AND TRJD_KODEIGR = SJH_KODEIGR
                                 AND TRUNC (TRJD_TRANSACTIONDATE) = TRUNC (SJH_TGLSTRUK)
                                 AND TRJD_CASHIERSTATION || TRJD_CREATE_BY || TRJD_TRANSACTIONNO =
                                                                                         SJH_NOSTRUK
                                 AND TRJD_TRANSACTIONTYPE = 'S'
                                 AND PRD_KODEIGR = SJH_KODEIGR
                                 AND PRD_PRDCD = TRJD_PRDCD)
                    GROUP BY TRJD_PRDCD, PRD_DESKRIPSIPENDEK, PRD_UNIT, PRD_FRAC
                    ORDER BY PRD_DESKRIPSIPENDEK");
        for($i=0;$i<sizeof($datas);$i++){
            $pewpew = $datas[$i]->trjd_prdcd;

            $sjas = DB::select("SELECT NVL (COUNT (1), 0) as count
              FROM TBTR_SJAS_H, TBTR_SJAS_D
             WHERE SJH_KODEIGR = '$kodeigr'
               AND NVL (SJH_FLAGSELESAI, 'N') <> 'Y'
               AND SJD_NOSJAS = SJH_NOSJAS
               AND SJD_KODECUSTOMER = SJH_KODECUSTOMER
               AND SJD_PRDCD = '$pewpew'");

            if($sjas[0]->count == 0){
                $qtysj[$i] = "0";
            }else{
                $temp = DB::table("TBTR_SJAS_D")
                    ->selectRaw("(NVL (SJD_QTYSJAS, 0)) SJ")
                    ->LeftJoin('TBTR_SJAS_H',function($join){
                        $join->on('SJD_NOSJAS','SJH_NOSJAS');
                        $join->on('SJD_KODECUSTOMER','SJH_KODECUSTOMER');
                        $join->on('SJD_KODEIGR','SJH_KODEIGR');
                    })
                    ->where('SJH_KODEIGR','=',$kodeigr)
                    ->whereRaw("NVL (SJH_FLAGSELESAI, 'N') <> 'Y'")
                    ->where('SJD_PRDCD','=',$pewpew)
                    ->first();
                $qtysj[$i] = $temp->sj;
            }
        }
        return response()->json(['datas'=>$datas,'qtysj'=>$qtysj]);
    }

    public function GetDetail(Request $request){
        $kodeigr = $_SESSION['kdigr'];
        $prdcd = $request->prdcd;

        $datas = DB::select("SELECT DISTINCT SJH_KODECUSTOMER, SJH_NOSTRUK,
            SUBSTR (SJH_NOSTRUK, 1, 2) || '.' || SUBSTR (SJH_NOSTRUK, 3, 3) || '.' || SUBSTR (SJH_NOSTRUK, 6, 5) modelStruk,
                                TRUNC (SJH_TGLPENITIPAN) SJH_TGLPENITIPAN
                           FROM TBTR_SJAS_H, TBTR_JUALDETAIL
                          WHERE SJH_KODEIGR = '$kodeigr'
                            AND NVL (SJH_FLAGSELESAI, 'N') <> 'Y'
                            AND TRJD_KODEIGR = SJH_KODEIGR
                            AND TRUNC (TRJD_TRANSACTIONDATE) = TRUNC (SJH_TGLSTRUK)
                            AND TRJD_CASHIERSTATION = SUBSTR (SJH_NOSTRUK, 1, 2)
                            AND TRJD_CREATE_BY = SUBSTR (SJH_NOSTRUK, 3, 3)
                            AND TRJD_TRANSACTIONNO = SUBSTR (SJH_NOSTRUK, 6, 5)
                            AND TRJD_TRANSACTIONTYPE = 'S'
                            AND TRJD_CUS_KODEMEMBER = SJH_KODECUSTOMER
                            AND TRJD_PRDCD = '$prdcd'");
        for($i=0;$i<sizeof($datas);$i++){
            //Variable yang digunakan selama looping
            $kodcus = $datas[$i]->sjh_kodecustomer;

            //Customer Name
            $tempCus = DB::select("SELECT CUS_NAMAMEMBER FROM TBMASTER_CUSTOMER WHERE CUS_KODEMEMBER = '$kodcus' AND ROWNUM = 1");
            $customer[$i] = $tempCus[0]->cus_namamember;

            //Quantity Titipan
            $tempTitip = DB::select("SELECT SUM (NVL (TRJD_QUANTITY, 0)) STRUK
          FROM TBTR_SJAS_H, TBTR_JUALDETAIL
         WHERE SJH_KODEIGR = '$kodeigr'
           AND NVL (SJH_FLAGSELESAI, 'N') <> 'Y'
           AND TRJD_KODEIGR = SJH_KODEIGR
           AND TRUNC (TRJD_TRANSACTIONDATE) = TRUNC (SJH_TGLSTRUK)
           AND TRJD_CASHIERSTATION = SUBSTR (SJH_NOSTRUK, 1, 2)
           AND TRJD_CREATE_BY = SUBSTR (SJH_NOSTRUK, 3, 3)
           AND TRJD_TRANSACTIONNO = SUBSTR (SJH_NOSTRUK, 6, 5)
           AND TRJD_TRANSACTIONTYPE = 'S'
           AND TRJD_CUS_KODEMEMBER = '$kodcus'
           AND TRJD_PRDCD = '$prdcd'");
            $qtyTitip[$i] = $tempTitip[0]->struk;

            //Check apakah sudah pernah mengembalikan sebagian (ada atau tidaknya SJAS)
            $tempCheck = DB::select("SELECT NVL (COUNT (1), 0) temp
          FROM TBTR_SJAS_H, TBTR_SJAS_D
         WHERE SJH_KODEIGR = '$kodeigr'
           AND NVL (SJH_FLAGSELESAI, 'N') <> 'Y'
           AND SJD_NOSJAS = SJH_NOSJAS
           AND SJD_KODECUSTOMER = '$kodcus'
           AND SJD_PRDCD = '$prdcd'");

            if($tempCheck[0]->temp == "0"){
                $qtysjdet[$i] = 0;
            }else{
                $tempqtysjas = DB::select("SELECT SUM (NVL (SJD_QTYSJAS, 0)) SJ
              FROM TBTR_SJAS_H, TBTR_SJAS_D
             WHERE SJH_KODEIGR = '$kodeigr'
               AND NVL (SJH_FLAGSELESAI, 'N') <> 'Y'
               AND SJD_NOSJAS = SJH_NOSJAS
               AND SJD_KODECUSTOMER = '$kodcus'
               AND SJD_PRDCD = '$prdcd'");
                $qtysjdet[$i] = $tempqtysjas[0]->sj;
            }
            $qtysisadet[$i] = $qtyTitip[$i] - $qtysjdet[$i];
        }

        return response()->json(['datas' => $datas,'cust' => $customer, 'titip' => $qtyTitip, 'qtysj' => $qtysjdet, 'qtysisa' => $qtysisadet]);
    }


    public function CheckData(Request $request){
        $kodeigr = $_SESSION['kdigr'];

        $cursor = DB::select("SELECT   TRJD_PRDCD, PRD_DESKRIPSIPENDEK, UNIT, PRD_PRDCD, SUM (QTY) STRUK, TRJD_CUS_KODEMEMBER, CUS_NAMAMEMBER, SJH_TGLSTRUK, SJH_NOSTRUK,
TO_CHAR(SYSDATE, 'dd-MM-yy hh:mm:ss') info, 'POSISI BARANG TITIPAN per ' || TO_CHAR(SYSDATE, 'dd-MM-yy') HEAD, PRS_NAMAPERUSAHAAN, PRS_NAMACABANG
FROM (SELECT TRJD_PRDCD, PRD_DESKRIPSIPENDEK, PRD_UNIT || '/' ||  PRD_FRAC UNIT, PRD_PRDCD,
NVL (TRJD_QUANTITY, 0) QTY, TRJD_CUS_KODEMEMBER, CUS_NAMAMEMBER, SJH_TGLSTRUK, SJH_NOSTRUK, PRS_NAMAPERUSAHAAN, PRS_NAMACABANG
FROM TBTR_SJAS_H, TBTR_JUALDETAIL, TBMASTER_PRODMAST, TBMASTER_CUSTOMER, TBMASTER_PERUSAHAAN
WHERE SJH_KODEIGR = '$kodeigr'
AND NVL (SJH_FLAGSELESAI, 'N') <> 'Y'
AND TRJD_KODEIGR = SJH_KODEIGR
AND TRUNC (TRJD_TRANSACTIONDATE) = TRUNC (SJH_TGLSTRUK)
AND TRJD_CASHIERSTATION || TRJD_CREATE_BY || TRJD_TRANSACTIONNO =  SJH_NOSTRUK
AND TRJD_TRANSACTIONTYPE = 'S'
AND PRD_KODEIGR = TRJD_KODEIGR
AND PRD_PRDCD = TRJD_PRDCD
AND CUS_KODEMEMBER = SJH_KODECUSTOMER
AND PRS_KODEIGR = '$kodeigr')
GROUP BY TRJD_PRDCD, PRD_DESKRIPSIPENDEK, UNIT, PRD_PRDCD, TRJD_CUS_KODEMEMBER, CUS_NAMAMEMBER, SJH_TGLSTRUK, SJH_NOSTRUK, PRS_NAMAPERUSAHAAN, PRS_NAMACABANG
ORDER BY TRJD_PRDCD");


        if(!$cursor){
            return response()->json(['kode' => 1]);
        }else{
            return response()->json(['kode' => 0]);
        }
    }
    public function printDocument(Request $request){
        $kodeigr = $_SESSION['kdigr'];


        $datas = DB::select("SELECT   TRJD_PRDCD, PRD_DESKRIPSIPENDEK, UNIT, PRD_PRDCD, SUM (QTY) STRUK, TRJD_CUS_KODEMEMBER, CUS_NAMAMEMBER, SJH_TGLSTRUK, SJH_NOSTRUK,
TO_CHAR(SYSDATE, 'dd-MM-yy hh:mm:ss') info, 'POSISI BARANG TITIPAN per ' || TO_CHAR(SYSDATE, 'dd-MM-yy') HEAD, PRS_NAMAPERUSAHAAN, PRS_NAMACABANG
FROM (SELECT TRJD_PRDCD, PRD_DESKRIPSIPENDEK, PRD_UNIT || '/' ||  PRD_FRAC UNIT, PRD_PRDCD,
NVL (TRJD_QUANTITY, 0) QTY, TRJD_CUS_KODEMEMBER, CUS_NAMAMEMBER, SJH_TGLSTRUK, SJH_NOSTRUK, PRS_NAMAPERUSAHAAN, PRS_NAMACABANG
FROM TBTR_SJAS_H, TBTR_JUALDETAIL, TBMASTER_PRODMAST, TBMASTER_CUSTOMER, TBMASTER_PERUSAHAAN
WHERE SJH_KODEIGR = '$kodeigr'
AND NVL (SJH_FLAGSELESAI, 'N') <> 'Y'
AND TRJD_KODEIGR = SJH_KODEIGR
AND TRUNC (TRJD_TRANSACTIONDATE) = TRUNC (SJH_TGLSTRUK)
AND TRJD_CASHIERSTATION || TRJD_CREATE_BY || TRJD_TRANSACTIONNO =  SJH_NOSTRUK
AND TRJD_TRANSACTIONTYPE = 'S'
AND PRD_KODEIGR = TRJD_KODEIGR
AND PRD_PRDCD = TRJD_PRDCD
AND CUS_KODEMEMBER = SJH_KODECUSTOMER
AND PRS_KODEIGR = '$kodeigr')
GROUP BY TRJD_PRDCD, PRD_DESKRIPSIPENDEK, UNIT, PRD_PRDCD, TRJD_CUS_KODEMEMBER, CUS_NAMAMEMBER, SJH_TGLSTRUK, SJH_NOSTRUK, PRS_NAMAPERUSAHAAN, PRS_NAMACABANG
ORDER BY TRJD_PRDCD");

        for($i=0;$i<sizeof($datas);$i++){
            $prdcd = $datas[$i]->trjd_prdcd;
            $kodMem = $datas[$i]->trjd_cus_kodemember;

            $tempSjas = DB::select("SELECT NVL(SUM(NVL(SJD_QTYSJAS,0)),0) SJ FROM TBTR_SJAS_H, TBTR_SJAS_D
	WHERE SJH_KODEIGR = '$kodeigr' AND NVL(SJH_FLAGSELESAI, 'N') <> 'Y'  AND SJD_NOSJAS = SJH_NOSJAS AND SJD_KODECUSTOMER = SJH_KODECUSTOMER
	AND SJD_PRDCD = '$prdcd'");
            $sjasAll[$i] = $tempSjas[0]->sj;

            $tempSjas = DB::select("SELECT NVL(SUM(NVL(SJD_QTYSJAS,0)),0) SJ FROM TBTR_SJAS_H, TBTR_SJAS_D
	WHERE SJH_KODEIGR = '$kodeigr' AND NVL(SJH_FLAGSELESAI, 'N') <> 'Y'  AND SJD_NOSJAS = SJH_NOSJAS AND SJD_KODECUSTOMER = '$kodMem'
	AND SJD_PRDCD = '$prdcd'");
            $sisa[$i] = ($datas[$i]->struk)-($tempSjas[0]->sj);
        }

        //PRINT
        $path = 'BTAS\MONITORING.PerItem-pdf';

        $pdf = PDF::loadview($path,
            ['kodeigr' => $kodeigr, 'datas' => $datas, 'sjasAll' => $sjasAll, 'sisa' => $sisa]);
        $pdf->setPaper('A4', 'potrait');
        $pdf->output();
        $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);

        $canvas = $dompdf ->get_canvas();
        $canvas->page_text(514, 10, "Page {PAGE_NUM} of {PAGE_COUNT}", null, 8, array(0, 0, 0));

        return $pdf->stream("$path");
    }
}
