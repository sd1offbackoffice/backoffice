<?php
/**
 * Created by PhpStorm.
 * User: ryan
 * Date: 1/12/2021
 * Time: 3:25 PM
 */

namespace App\Http\Controllers\FRONTOFFICE\LAPORANKASIR;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use PDF;
use DateTime;
use Yajra\DataTables\DataTables;

class csiController extends Controller
{

    public function index()
    {
        return view('FRONTOFFICE\LAPORANKASIR.csi');
    }

    public function getNmr(Request $request)
    {
        $search = $request->val;
        $kodeigr = $_SESSION['kdigr'];

        $datas = DB::table('tbmaster_supplier')
            ->selectRaw('distinct sup_kodesupplier as sup_kodesupplier')
            ->selectRaw('sup_namasupplier')
            ->where('sup_kodesupplier','=', $search)
            ->where('sup_kodeigr','=',$kodeigr)
            ->orderBy('sup_namasupplier')
            ->first();
        return response()->json($datas);
    }

    public function getModal(Request $request)
    {
        $kodeigr = $_SESSION['kdigr'];
        $search = $request->value;

        $datas = DB::table('tbmaster_supplier')
            ->selectRaw('distinct sup_kodesupplier as sup_kodesupplier')
            ->selectRaw('sup_namasupplier')

            ->where('sup_kodesupplier','LIKE', '%'.$search.'%')
            ->where('sup_kodeigr','=',$kodeigr)

            ->orWhere('sup_namasupplier','LIKE', '%'.$search.'%')
            ->where('sup_kodeigr','=',$kodeigr)

            ->orderBy('sup_namasupplier')
            ->limit(100)
            ->get();

        return Datatables::of($datas)->make(true);
    }

    public function CheckData(Request $request){
        $kodeigr = $_SESSION['kdigr'];
        $dateA = $request->dateA;
        $dateB = $request->dateB;
        $sDate = DateTime::createFromFormat('d-m-Y', $dateA)->format('d-m-Y');
        $eDate = DateTime::createFromFormat('d-m-Y', $dateB)->format('d-m-Y');
        $p_tipe = $request->p_tipe;
        $sup1 = $request->sup1;
        $sup2 = $request->sup2;
        if($sup1 == "nodata"){
            $sup1 = '';
        }
        if($sup2 == "nodata"){
            $sup2 = '';
        }
        $and_tipe =" and hdr.tipe = 'S'";
        $and_csbck =" and dtl.cashback > 0";
        if ($p_tipe == 'R'){
            $and_tipe =" and hdr.tipe = 'R'";
   		    $and_csbck = " and dtl.cashback < 0";
        }
        $andsupp = " AND HGB_KODESUPPLIER IS NOT NULL";
        if($sup1 != '' && $sup2 != ''){
            $andsupp = " and HGB_kodesupplier between '".$sup1."' and '".$sup2."'";
        }
        $cursor = DB::select("SELECT A.TANGGAL, A.PLU, PRD_DESKRIPSIPANJANG, SUP_KODESUPPLIER,
              SUP_NAMASUPPLIER, PRS_NAMAPERUSAHAAN, PRS_NAMACABANG,
              PRS_NAMAWILAYAH,SUM(A.QTY) QTY, SUM(A.NILAI) NILAI
FROM(
            SELECT HDR.TGL_TRANS TANGGAL, '1111111' PLU, HDR.KD_MEMBER KDMEM,
                   HDR.KELIPATAN qty, HDR.cashback nilai
	   FROM M_PROMOSI_H HDR, TBTR_CASHBACK_HDR
	   WHERE HDR.KD_IGR = '$kodeigr'
  	   AND HDR.TGL_TRANS BETWEEN TO_DATE('$sDate','DD-MM-YYYY') AND TO_DATE('$eDate', 'DD-MM-YYYY')
  	   AND HDR.KD_PROMOSI = CBH_KODEPROMOSI
                   ".$and_tipe."
  	   AND CBH_JENISPROMOSI IN ('1', '2')
	UNION ALL
            SELECT HDR.TGL_TRANS TANGGAL, SUBSTR(DTL.KD_PLU,1,6)||'1' PLU,
                   HDR.KD_MEMBER KDMEM, dtl.KELIPATAN qty, dtl.cashback nilai
	   FROM M_PROMOSI_H HDR, M_PROMOSI_D DTL, TBTR_CASHBACK_HDR
                   WHERE HDR.KD_IGR = '$kodeigr'
                    AND HDR.TGL_TRANS BETWEEN TO_DATE('$sDate','DD-MM-YYYY') AND TO_DATE('$eDate', 'DD-MM-YYYY')
                    ".$and_tipe."
                    ".$and_csbck."
                    AND HDR.KD_PROMOSI = DTL.KD_PROMOSI
                    AND HDR.PROMOSI_ID = DTL.PROMOSI_ID
                    AND HDR.TRANS_NO = DTL.TRANS_NO
                    AND HDR.KD_PROMOSI = CBH_KODEPROMOSI
                    AND CBH_JENISPROMOSI NOT IN ('1', '2')) A,
	TBMASTER_SUPPLIER, TBMASTER_PRODMAST, TBMASTER_PERUSAHAAN
WHERE A.PLU = PRD_PRDCD(+)
     AND PRD_KODESUPPLIER = SUP_KODESUPPLIER(+)
     AND PRS_KODEIGR = '$kodeigr'
GROUP BY A.TANGGAL, A.PLU, prd_deskripsipanjang, sup_kodesupplier,
      sup_namasupplier, PRS_NAMAPERUSAHAAN, PRS_NAMACABANG, PRS_NAMAWILAYAH
ORDER BY SUP_KODESUPPLIER, A.PLU, A.TANGGAL");
        if(!$cursor){
            return response()->json(['kode' => 0]);
        }else{
            return response()->json(['kode' => 1]);
        }
    }
    public function CheckDataK(Request $request){
        $kodeigr = $_SESSION['kdigr'];
        $dateA = $request->dateA;
        $dateB = $request->dateB;
        $sDate = DateTime::createFromFormat('d-m-Y', $dateA)->format('d-m-Y');
        $eDate = DateTime::createFromFormat('d-m-Y', $dateB)->format('d-m-Y');
        $p_tipe = $request->p_tipe;
        $sup1 = $request->sup1;
        $sup2 = $request->sup2;
        if($sup1 == "nodata"){
            $sup1 = '';
        }
        if($sup2 == "nodata"){
            $sup2 = '';
        }
        $and_tipe =" and hdr.tipe = 'S'";
        $and_csbck =" and dtl.cashback > 0";
        if ($p_tipe == 'R'){
            $and_tipe =" and hdr.tipe = 'R'";
            $and_csbck = " and dtl.cashback < 0";
        }
        $andsupp = " AND HGB_KODESUPPLIER IS NOT NULL";
        if($sup1 != '' && $sup2 != ''){
            $andsupp = " and HGB_kodesupplier between '".$sup1."' and '".$sup2."'";
        }
        $cursor = DB::select("SELECT A.TANGGAL, A.PLU, PRD_DESKRIPSIPANJANG, SUP_KODESUPPLIER,
              SUP_NAMASUPPLIER, PRS_NAMAPERUSAHAAN, PRS_NAMACABANG,
              PRS_NAMAWILAYAH,SUM(A.QTY) QTY, SUM(A.NILAI) NILAI
FROM(
            SELECT HDR.TGL_TRANS TANGGAL, '1111111' PLU, HDR.KD_MEMBER KDMEM,
                   HDR.KELIPATAN qty, HDR.cashback nilai
	   FROM M_PROMOSI_H HDR, TBTR_CASHBACK_HDR
	   WHERE HDR.KD_IGR = '$kodeigr'
  	   AND HDR.TGL_TRANS BETWEEN TO_DATE('$sDate','DD-MM-YYYY') AND TO_DATE('$eDate', 'DD-MM-YYYY')
  	   AND HDR.KD_PROMOSI = CBH_KODEPROMOSI
                   ".$and_tipe."
  	   AND CBH_JENISPROMOSI IN ('1', '2')
	UNION ALL
            SELECT HDR.TGL_TRANS TANGGAL, SUBSTR(DTL.KD_PLU,1,6)||'1' PLU,
                   HDR.KD_MEMBER KDMEM, dtl.KELIPATAN qty, dtl.cashback nilai
	   FROM M_PROMOSI_H HDR, M_PROMOSI_D DTL, TBTR_CASHBACK_HDR
                   WHERE HDR.KD_IGR = '$kodeigr'
                    AND HDR.TGL_TRANS BETWEEN TO_DATE('$sDate','DD-MM-YYYY') AND TO_DATE('$eDate', 'DD-MM-YYYY')
                    ".$and_tipe."
                    ".$and_csbck."
                    AND HDR.KD_PROMOSI = DTL.KD_PROMOSI
                    AND HDR.PROMOSI_ID = DTL.PROMOSI_ID
                    AND HDR.TRANS_NO = DTL.TRANS_NO
                    AND HDR.KD_PROMOSI = CBH_KODEPROMOSI
                    AND CBH_JENISPROMOSI NOT IN ('1', '2')) A,
	TBMASTER_SUPPLIER, TBMASTER_PRODMAST,
                TBMASTER_CUSTOMER, TBMASTER_PERUSAHAAN
WHERE A.PLU = PRD_PRDCD(+)
     AND PRD_KODESUPPLIER = SUP_KODESUPPLIER(+)
     and A.KDMEM = CUS_KODEMEMBER(+)
     and cus_flagmemberkhusus = 'Y'
     AND PRS_KODEIGR = '$kodeigr'
GROUP BY A.TANGGAL, A.PLU, prd_deskripsipanjang, sup_kodesupplier,
      sup_namasupplier, PRS_NAMAPERUSAHAAN, PRS_NAMACABANG, PRS_NAMAWILAYAH
ORDER BY SUP_KODESUPPLIER, A.PLU, A.TANGGAL");
        if(!$cursor){
            return response()->json(['kode' => 0]);
        }else{
            return response()->json(['kode' => 1]);
        }
    }
    public function CheckDataR(Request $request){
        $kodeigr = $_SESSION['kdigr'];
        $dateA = $request->dateA;
        $dateB = $request->dateB;
        $sDate = DateTime::createFromFormat('d-m-Y', $dateA)->format('d-m-Y');
        $eDate = DateTime::createFromFormat('d-m-Y', $dateB)->format('d-m-Y');
        $p_tipe = $request->p_tipe;
        $sup1 = $request->sup1;
        $sup2 = $request->sup2;
        if($sup1 == "nodata"){
            $sup1 = '';
        }
        if($sup2 == "nodata"){
            $sup2 = '';
        }
        $and_tipe =" and hdr.tipe = 'S'";
        $and_csbck =" and dtl.cashback > 0";
        if ($p_tipe == 'R'){
            $and_tipe =" and hdr.tipe = 'R'";
            $and_csbck = " and dtl.cashback < 0";
        }
        $andsupp = " AND HGB_KODESUPPLIER IS NOT NULL";
        if($sup1 != '' && $sup2 != ''){
            $andsupp = " and HGB_kodesupplier between '".$sup1."' and '".$sup2."'";
        }
        $cursor = DB::select("SELECT A.TANGGAL, A.PLU, PRD_DESKRIPSIPANJANG, SUP_KODESUPPLIER,
              SUP_NAMASUPPLIER, PRS_NAMAPERUSAHAAN, PRS_NAMACABANG,
              PRS_NAMAWILAYAH,SUM(A.QTY) QTY, SUM(A.NILAI) NILAI
FROM(
            SELECT HDR.TGL_TRANS TANGGAL, '1111111' PLU, HDR.KD_MEMBER KDMEM,
                   HDR.KELIPATAN qty, HDR.cashback nilai
	   FROM M_PROMOSI_H HDR, TBTR_CASHBACK_HDR
	   WHERE HDR.KD_IGR = '$kodeigr'
  	   AND HDR.TGL_TRANS BETWEEN TO_DATE('$sDate','DD-MM-YYYY') AND TO_DATE('$eDate', 'DD-MM-YYYY')
  	   AND HDR.KD_PROMOSI = CBH_KODEPROMOSI
                   ".$and_tipe."
  	   AND CBH_JENISPROMOSI IN ('1', '2')
	UNION ALL
            SELECT HDR.TGL_TRANS TANGGAL, SUBSTR(DTL.KD_PLU,1,6)||'1' PLU,
                   HDR.KD_MEMBER KDMEM, dtl.KELIPATAN qty, dtl.cashback nilai
	   FROM M_PROMOSI_H HDR, M_PROMOSI_D DTL, TBTR_CASHBACK_HDR
                   WHERE HDR.KD_IGR = '$kodeigr'
                    AND HDR.TGL_TRANS BETWEEN TO_DATE('$sDate','DD-MM-YYYY') AND TO_DATE('$eDate', 'DD-MM-YYYY')
                    ".$and_tipe."
                    ".$and_csbck."
                    AND HDR.KD_PROMOSI = DTL.KD_PROMOSI
                    AND HDR.PROMOSI_ID = DTL.PROMOSI_ID
                    AND HDR.TRANS_NO = DTL.TRANS_NO
                    AND HDR.KD_PROMOSI = CBH_KODEPROMOSI
                    AND CBH_JENISPROMOSI NOT IN ('1', '2')) A,
	TBMASTER_SUPPLIER, TBMASTER_PRODMAST,
                TBMASTER_CUSTOMER, TBMASTER_PERUSAHAAN
WHERE A.PLU = PRD_PRDCD(+)
     AND PRD_KODESUPPLIER = SUP_KODESUPPLIER(+)
     and A.KDMEM = CUS_KODEMEMBER(+)
     and cus_flagmemberkhusus <> 'Y'
     AND PRS_KODEIGR = '$kodeigr'
GROUP BY A.TANGGAL, A.PLU, prd_deskripsipanjang, sup_kodesupplier,
      sup_namasupplier, PRS_NAMAPERUSAHAAN, PRS_NAMACABANG, PRS_NAMAWILAYAH
ORDER BY SUP_KODESUPPLIER, A.PLU, A.TANGGAL");
        if(!$cursor){
            return response()->json(['kode' => 0]);
        }else{
            return response()->json(['kode' => 1]);
        }
    }

    public function printDocument(Request $request){
        $kodeigr = $_SESSION['kdigr'];
        $dateA = $request->date1;
        $dateB = $request->date2;
        $sDate = DateTime::createFromFormat('d-m-Y', $dateA)->format('d-m-Y');
        $eDate = DateTime::createFromFormat('d-m-Y', $dateB)->format('d-m-Y');
        $p_tipe = $request->p_tipe;
        $sup1 = $request->sup1;
        $sup2 = $request->sup2;
        if($sup1 == "nodata"){
            $sup1 = '';
        }
        if($sup2 == "nodata"){
            $sup2 = '';
        }
        $and_tipe =" and hdr.tipe = 'S'";
        $and_csbck =" and dtl.cashback > 0";
        $judul = "LAPORAN CASH BACK / SUPPLIER / ITEM";
        if ($p_tipe == 'R'){
            $and_tipe =" and hdr.tipe = 'R'";
            $and_csbck = " and dtl.cashback < 0";
            $judul = "LAPORAN REFUND CASH BACK / SUPPLIER /ITEM";
        }
        $andsupp = " AND HGB_KODESUPPLIER IS NOT NULL";
        if($sup1 != '' && $sup2 != ''){
            $andsupp = " and HGB_kodesupplier between '".$sup1."' and '".$sup2."'";
        }
        $datas = DB::select("SELECT A.TANGGAL, A.PLU, PRD_DESKRIPSIPANJANG, SUP_KODESUPPLIER,
              SUP_NAMASUPPLIER, PRS_NAMAPERUSAHAAN, PRS_NAMACABANG,
              PRS_NAMAWILAYAH,SUM(A.QTY) QTY, SUM(A.NILAI) NILAI
FROM(
            SELECT HDR.TGL_TRANS TANGGAL, '1111111' PLU, HDR.KD_MEMBER KDMEM,
                   HDR.KELIPATAN qty, HDR.cashback nilai
	   FROM M_PROMOSI_H HDR, TBTR_CASHBACK_HDR
	   WHERE HDR.KD_IGR = '$kodeigr'
  	   AND HDR.TGL_TRANS BETWEEN TO_DATE('$sDate','DD-MM-YYYY') AND TO_DATE('$eDate', 'DD-MM-YYYY')
  	   AND HDR.KD_PROMOSI = CBH_KODEPROMOSI
                   ".$and_tipe."
  	   AND CBH_JENISPROMOSI IN ('1', '2')
	UNION ALL
            SELECT HDR.TGL_TRANS TANGGAL, SUBSTR(DTL.KD_PLU,1,6)||'1' PLU,
                   HDR.KD_MEMBER KDMEM, dtl.KELIPATAN qty, dtl.cashback nilai
	   FROM M_PROMOSI_H HDR, M_PROMOSI_D DTL, TBTR_CASHBACK_HDR
                   WHERE HDR.KD_IGR = '$kodeigr'
                    AND HDR.TGL_TRANS BETWEEN TO_DATE('$sDate','DD-MM-YYYY') AND TO_DATE('$eDate', 'DD-MM-YYYY')
                    ".$and_tipe."
                    ".$and_csbck."
                    AND HDR.KD_PROMOSI = DTL.KD_PROMOSI
                    AND HDR.PROMOSI_ID = DTL.PROMOSI_ID
                    AND HDR.TRANS_NO = DTL.TRANS_NO
                    AND HDR.KD_PROMOSI = CBH_KODEPROMOSI
                    AND CBH_JENISPROMOSI NOT IN ('1', '2')) A,
	TBMASTER_SUPPLIER, TBMASTER_PRODMAST, TBMASTER_PERUSAHAAN
WHERE A.PLU = PRD_PRDCD(+)
     AND PRD_KODESUPPLIER = SUP_KODESUPPLIER(+)
     AND PRS_KODEIGR = '$kodeigr'
GROUP BY A.TANGGAL, A.PLU, prd_deskripsipanjang, sup_kodesupplier,
      sup_namasupplier, PRS_NAMAPERUSAHAAN, PRS_NAMACABANG, PRS_NAMAWILAYAH
ORDER BY SUP_KODESUPPLIER, A.PLU, A.TANGGAL");
        //PRINT
        $today = date('d-m-Y');
        $time = date('H:i:s');
//        $pdf = PDF::loadview('FRONTOFFICE\LAPORANKASIR\csi-pdf',
//            ['kodeigr' => $kodeigr, 'judul' => $judul ,'date1' => $dateA, 'date2' => $dateB, 'datas' => $datas, 'today' => $today, 'time' => $time]);
//        $pdf->setPaper('A4', 'potrait');
//        $pdf->output();
//        $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);
//
//        $canvas = $dompdf ->get_canvas();
//        $canvas->page_text(514, 24, "PAGE {PAGE_NUM} of {PAGE_COUNT}", null, 8, array(0, 0, 0));
//
//        return $pdf->stream('FRONTOFFICE\LAPORANKASIR\csi-pdf');

        return view('FRONTOFFICE\LAPORANKASIR\csi-pdf',['kodeigr' => $kodeigr, 'judul' => $judul ,'date1' => $dateA, 'date2' => $dateB, 'datas' => $datas, 'today' => $today, 'time' => $time]);
    }

    public function printDocumentK(Request $request){
        $kodeigr = $_SESSION['kdigr'];
        $dateA = $request->date1;
        $dateB = $request->date2;
        $sDate = DateTime::createFromFormat('m-d-Y', $dateA)->format('d-m-Y');
        $eDate = DateTime::createFromFormat('m-d-Y', $dateB)->format('d-m-Y');
        $p_tipe = $request->p_tipe;
        $sup1 = $request->sup1;
        $sup2 = $request->sup2;
        if($sup1 == "nodata"){
            $sup1 = '';
        }
        if($sup2 == "nodata"){
            $sup2 = '';
        }
        $and_tipe =" and hdr.tipe = 'S'";
        $and_csbck =" and dtl.cashback > 0";
        $judul = "LAPORAN CASH BACK / SUPPLIER / ITEM";
        if ($p_tipe == 'R'){
            $and_tipe =" and hdr.tipe = 'R'";
            $and_csbck = " and dtl.cashback < 0";
            $judul = "LAPORAN REFUND CASH BACK / SUPPLIER /ITEM";
        }
        $andsupp = " AND HGB_KODESUPPLIER IS NOT NULL";
        if($sup1 != '' && $sup2 != ''){
            $andsupp = " and HGB_kodesupplier between '".$sup1."' and '".$sup2."'";
        }
        $datas = DB::select("SELECT A.TANGGAL, A.PLU, PRD_DESKRIPSIPANJANG, SUP_KODESUPPLIER,
              SUP_NAMASUPPLIER, PRS_NAMAPERUSAHAAN, PRS_NAMACABANG,
              PRS_NAMAWILAYAH,SUM(A.QTY) QTY, SUM(A.NILAI) NILAI
FROM(
            SELECT HDR.TGL_TRANS TANGGAL, '1111111' PLU, HDR.KD_MEMBER KDMEM,
                   HDR.KELIPATAN qty, HDR.cashback nilai
	   FROM M_PROMOSI_H HDR, TBTR_CASHBACK_HDR
	   WHERE HDR.KD_IGR = '$kodeigr'
  	   AND HDR.TGL_TRANS BETWEEN TO_DATE('$sDate','DD-MM-YYYY') AND TO_DATE('$eDate', 'DD-MM-YYYY')
  	   AND HDR.KD_PROMOSI = CBH_KODEPROMOSI
                   ".$and_tipe."
  	   AND CBH_JENISPROMOSI IN ('1', '2')
	UNION ALL
            SELECT HDR.TGL_TRANS TANGGAL, SUBSTR(DTL.KD_PLU,1,6)||'1' PLU,
                   HDR.KD_MEMBER KDMEM, dtl.KELIPATAN qty, dtl.cashback nilai
	   FROM M_PROMOSI_H HDR, M_PROMOSI_D DTL, TBTR_CASHBACK_HDR
                   WHERE HDR.KD_IGR = '$kodeigr'
                    AND HDR.TGL_TRANS BETWEEN TO_DATE('$sDate','DD-MM-YYYY') AND TO_DATE('$eDate', 'DD-MM-YYYY')
                    ".$and_tipe."
                    ".$and_csbck."
                    AND HDR.KD_PROMOSI = DTL.KD_PROMOSI
                    AND HDR.PROMOSI_ID = DTL.PROMOSI_ID
                    AND HDR.TRANS_NO = DTL.TRANS_NO
                    AND HDR.KD_PROMOSI = CBH_KODEPROMOSI
                    AND CBH_JENISPROMOSI NOT IN ('1', '2')) A,
	TBMASTER_SUPPLIER, TBMASTER_PRODMAST,
                TBMASTER_CUSTOMER, TBMASTER_PERUSAHAAN
WHERE A.PLU = PRD_PRDCD(+)
     AND PRD_KODESUPPLIER = SUP_KODESUPPLIER(+)
     and A.KDMEM = CUS_KODEMEMBER(+)
     and cus_flagmemberkhusus = 'Y'
     AND PRS_KODEIGR = '$kodeigr'
GROUP BY A.TANGGAL, A.PLU, prd_deskripsipanjang, sup_kodesupplier,
      sup_namasupplier, PRS_NAMAPERUSAHAAN, PRS_NAMACABANG, PRS_NAMAWILAYAH
ORDER BY SUP_KODESUPPLIER, A.PLU, A.TANGGAL");
        //PRINT
        $today = date('d-m-Y');
        $time = date('H:i:s');

        return view('FRONTOFFICE\LAPORANKASIR\csik-pdf',['kodeigr' => $kodeigr, 'judul' => $judul ,'date1' => $dateA, 'date2' => $dateB, 'datas' => $datas, 'today' => $today, 'time' => $time]);
    }

    public function printDocumentR(Request $request){
        $kodeigr = $_SESSION['kdigr'];
        $dateA = $request->date1;
        $dateB = $request->date2;
        $sDate = DateTime::createFromFormat('m-d-Y', $dateA)->format('d-m-Y');
        $eDate = DateTime::createFromFormat('m-d-Y', $dateB)->format('d-m-Y');
        $p_tipe = $request->p_tipe;
        $sup1 = $request->sup1;
        $sup2 = $request->sup2;
        if($sup1 == "nodata"){
            $sup1 = '';
        }
        if($sup2 == "nodata"){
            $sup2 = '';
        }
        $and_tipe =" and hdr.tipe = 'S'";
        $and_csbck =" and dtl.cashback > 0";
        $judul = "LAPORAN CASH BACK / SUPPLIER / ITEM";
        if ($p_tipe == 'R'){
            $and_tipe =" and hdr.tipe = 'R'";
            $and_csbck = " and dtl.cashback < 0";
            $judul = "LAPORAN REFUND CASH BACK / SUPPLIER /ITEM";
        }
        $andsupp = " AND HGB_KODESUPPLIER IS NOT NULL";
        if($sup1 != '' && $sup2 != ''){
            $andsupp = " and HGB_kodesupplier between '".$sup1."' and '".$sup2."'";
        }
        $datas = DB::select("SELECT A.TANGGAL, A.PLU, PRD_DESKRIPSIPANJANG, SUP_KODESUPPLIER,
              SUP_NAMASUPPLIER, PRS_NAMAPERUSAHAAN, PRS_NAMACABANG,
              PRS_NAMAWILAYAH,SUM(A.QTY) QTY, SUM(A.NILAI) NILAI
FROM(
            SELECT HDR.TGL_TRANS TANGGAL, '1111111' PLU, HDR.KD_MEMBER KDMEM,
                   HDR.KELIPATAN qty, HDR.cashback nilai
	   FROM M_PROMOSI_H HDR, TBTR_CASHBACK_HDR
	   WHERE HDR.KD_IGR = '$kodeigr'
  	   AND HDR.TGL_TRANS BETWEEN TO_DATE('$sDate','DD-MM-YYYY') AND TO_DATE('$eDate', 'DD-MM-YYYY')
  	   AND HDR.KD_PROMOSI = CBH_KODEPROMOSI
                   ".$and_tipe."
  	   AND CBH_JENISPROMOSI IN ('1', '2')
	UNION ALL
            SELECT HDR.TGL_TRANS TANGGAL, SUBSTR(DTL.KD_PLU,1,6)||'1' PLU,
                   HDR.KD_MEMBER KDMEM, dtl.KELIPATAN qty, dtl.cashback nilai
	   FROM M_PROMOSI_H HDR, M_PROMOSI_D DTL, TBTR_CASHBACK_HDR
                   WHERE HDR.KD_IGR = '$kodeigr'
                    AND HDR.TGL_TRANS BETWEEN TO_DATE('$sDate','DD-MM-YYYY') AND TO_DATE('$eDate', 'DD-MM-YYYY')
                    ".$and_tipe."
                    ".$and_csbck."
                    AND HDR.KD_PROMOSI = DTL.KD_PROMOSI
                    AND HDR.PROMOSI_ID = DTL.PROMOSI_ID
                    AND HDR.TRANS_NO = DTL.TRANS_NO
                    AND HDR.KD_PROMOSI = CBH_KODEPROMOSI
                    AND CBH_JENISPROMOSI NOT IN ('1', '2')) A,
	TBMASTER_SUPPLIER, TBMASTER_PRODMAST,
                TBMASTER_CUSTOMER, TBMASTER_PERUSAHAAN
WHERE A.PLU = PRD_PRDCD(+)
     AND PRD_KODESUPPLIER = SUP_KODESUPPLIER(+)
     and A.KDMEM = CUS_KODEMEMBER(+)
     and cus_flagmemberkhusus <> 'Y'
     AND PRS_KODEIGR = '$kodeigr'
GROUP BY A.TANGGAL, A.PLU, prd_deskripsipanjang, sup_kodesupplier,
      sup_namasupplier, PRS_NAMAPERUSAHAAN, PRS_NAMACABANG, PRS_NAMAWILAYAH
ORDER BY SUP_KODESUPPLIER, A.PLU, A.TANGGAL");
        //PRINT
        $today = date('d-m-Y');
        $time = date('H:i:s');

        return view('FRONTOFFICE\LAPORANKASIR\csir-pdf',['kodeigr' => $kodeigr, 'judul' => $judul ,'date1' => $dateA, 'date2' => $dateB, 'datas' => $datas, 'today' => $today, 'time' => $time]);
    }
}
