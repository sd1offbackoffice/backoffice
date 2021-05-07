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

class PerCusController extends Controller
{

    public function index()
    {
        $kodeigr = $_SESSION['kdigr'];
        $datas = DB::table('TBTR_SJAS_H')
            ->selectRaw('SJH_NOSTRUK')
            ->selectRaw('SJH_TGLSTRUK')
            ->selectRaw('SJH_KODECUSTOMER')
            ->selectRaw('SJH_TGLPENITIPAN')
            ->selectRaw('SJH_NOSJAS')
            ->selectRaw('SJH_TGLSJAS')
            ->selectRaw('SJH_FLAGSELESAI')
            ->selectRaw('SJH_FREKTAHAPAN')
            ->selectRaw("SUBSTR(SJH_NOSTRUK,1,2) || ' . ' || SUBSTR(SJH_NOSTRUK,3,3) || ' . ' || SUBSTR(SJH_NOSTRUK,6,5) AS viewstruk")
            ->selectRaw('CUS_NAMAMEMBER')
            ->leftJoin("TBMASTER_CUSTOMER","CUS_KODEMEMBER",'=','SJH_KODECUSTOMER')
            //->where("sjh_flagselesai",'=',null)
            ->whereRaw("NVL(SJH_FLAGSELESAI,'N') = 'N'")
            ->where('sjh_kodeigr','=',$kodeigr)
            ->get();
        return view('BTAS/MONITORING.PerCus',['datas'=>$datas]);
    }
    public function GetData(){
        $kodeigr = $_SESSION['kdigr'];
        $datas = DB::table('TBTR_SJAS_H')
            ->selectRaw('SJH_NOSTRUK')
            ->selectRaw('SJH_TGLSTRUK')
            ->selectRaw('SJH_KODECUSTOMER')
            ->selectRaw('SJH_TGLPENITIPAN')
            ->selectRaw('SJH_NOSJAS')
            ->selectRaw('SJH_TGLSJAS')
            ->selectRaw('SJH_FLAGSELESAI')
            ->selectRaw('SJH_FREKTAHAPAN')
            ->selectRaw("SUBSTR(SJH_NOSTRUK,1,2) || ' . ' || SUBSTR(SJH_NOSTRUK,3,3) || ' . ' || SUBSTR(SJH_NOSTRUK,6,5) AS viewstruk")
            ->selectRaw('CUS_NAMAMEMBER')
            ->leftJoin("TBMASTER_CUSTOMER","CUS_KODEMEMBER",'=','SJH_KODECUSTOMER')
            //->where("sjh_flagselesai",'=',null)
            ->whereRaw("NVL(SJH_FLAGSELESAI,'N') = 'N'")
            ->where('sjh_kodeigr','=',$kodeigr)
            ->get();

        return response()->json($datas);
    }
    public function SortCust(){
        $kodeigr = $_SESSION['kdigr'];
        $datas = DB::table('TBTR_SJAS_H')
            ->selectRaw('SJH_NOSTRUK')
            ->selectRaw('SJH_TGLSTRUK')
            ->selectRaw('SJH_KODECUSTOMER')
            ->selectRaw('SJH_TGLPENITIPAN')
            ->selectRaw('SJH_NOSJAS')
            ->selectRaw('SJH_TGLSJAS')
            ->selectRaw('SJH_FLAGSELESAI')
            ->selectRaw('SJH_FREKTAHAPAN')
            ->selectRaw("SUBSTR(SJH_NOSTRUK,1,2) || ' . ' || SUBSTR(SJH_NOSTRUK,3,3) || ' . ' || SUBSTR(SJH_NOSTRUK,6,5) AS viewstruk")
            ->selectRaw('CUS_NAMAMEMBER')
            ->leftJoin("TBMASTER_CUSTOMER","CUS_KODEMEMBER",'=','SJH_KODECUSTOMER')
            //->where("sjh_flagselesai",'=',null)
            ->whereRaw("NVL(SJH_FLAGSELESAI,'N') = 'N'")
            ->where('sjh_kodeigr','=',$kodeigr)
            ->orderBy("SJH_KODECUSTOMER")
            ->get();

        return response()->json($datas);
    }
    public function SortTgl(){
        $kodeigr = $_SESSION['kdigr'];
        $datas = DB::table('TBTR_SJAS_H')
            ->selectRaw('SJH_NOSTRUK')
            ->selectRaw('SJH_TGLSTRUK')
            ->selectRaw('SJH_KODECUSTOMER')
            ->selectRaw('SJH_TGLPENITIPAN')
            ->selectRaw('SJH_NOSJAS')
            ->selectRaw('SJH_TGLSJAS')
            ->selectRaw('SJH_FLAGSELESAI')
            ->selectRaw('SJH_FREKTAHAPAN')
            ->selectRaw("SUBSTR(SJH_NOSTRUK,1,2) || ' . ' || SUBSTR(SJH_NOSTRUK,3,3) || ' . ' || SUBSTR(SJH_NOSTRUK,6,5) AS viewstruk")
            ->selectRaw('CUS_NAMAMEMBER')
            ->leftJoin("TBMASTER_CUSTOMER","CUS_KODEMEMBER",'=','SJH_KODECUSTOMER')
            //->where("sjh_flagselesai",'=',null)
            ->whereRaw("NVL(SJH_FLAGSELESAI,'N') = 'N'")
            ->where('sjh_kodeigr','=',$kodeigr)
            ->orderBy("SJH_TGLPENITIPAN")
            ->orderBy("SJH_KODECUSTOMER")
            ->get();

        return response()->json($datas);
    }

    public function GetDetail(Request $request){
        $kodeigr = $_SESSION['kdigr'];
        $kodeMember = $request->kodeMember;
        $tanggalTrn = $request->tanggalTrn;
        $noSJAS = $request->noSJAS;
        $noStruk = $request->noStruk;
        $partStruk = explode(" . ",$noStruk);

        $datas = DB::table('TBTR_JUALDETAIL')
            ->selectRaw('TRJD_SEQNO')
            ->selectRaw('TRJD_PRDCD')
            ->selectRaw('TRJD_QUANTITY')
            ->selectRaw("PRD_DESKRIPSIPENDEK")
            ->selectRaw("(PRD_UNIT || '/' || PRD_FRAC) AS unit")
            ->LeftJoin('tbmaster_prodmast',function($join){
                $join->on('trjd_kodeigr','prd_kodeigr');
                $join->on('TRJD_PRDCD','prd_prdcd');
            })
            ->where('trjd_kodeigr','=',$kodeigr)
            ->where("trjd_cus_kodemember",'=',$kodeMember)
            ->where("TRJD_TRANSACTIONTYPE",'=','S')
            ->where("TRJD_CASHIERSTATION",'=',$partStruk[0])
            ->where('TRJD_CREATE_BY','=',$partStruk[1])
            ->where('TRJD_TRANSACTIONNO','=',$partStruk[2])
            ->whereRaw("trunc(trjd_transactiondate) = trunc(to_date('$tanggalTrn','YYYY-MM-DD HH24:MI:SS'))")
            ->orderBy("TRJD_SEQNO")
            ->get();
        if($noSJAS == null){
            $qty = null;
        }else{
            for($i = 0; $i < sizeof($datas); $i++){
                $qty[$i] = DB::table('TBTR_SJAS_D')
                    ->selectRaw("SUM(SJD_QTYSJAS) QTY")
                    ->where('SJD_KODEIGR','=',$kodeigr)
                    ->where('SJD_NOSJAS','=',$noSJAS)
                    ->where('SJD_PRDCD','=',$datas[$i]->trjd_prdcd)
                    ->where('SJD_KODECUSTOMER','=',$kodeMember)
                    ->first();
            }
        }
        return response()->json(['datas' => $datas, 'qty' => $qty]);
    }


    public function CheckData(Request $request){
        $kodeigr = $_SESSION['kdigr'];
        $all = $request->all;
        if($all == 'Y'){
            $p_and = '';
        }else{
            $kodeMem = $request->kodeMem;
            $struk = $request->struk;
            $p_and = " AND SJH_KODECUSTOMER = '".$kodeMem."' AND SJH_NOSTRUK = '".$struk."'";
        }

        $cursor = DB::select("SELECT prs_namaperusahaan, prs_namacabang, 'Print: ' || TO_CHAR(SYSDATE, 'dd-MM-yy hh:mm:ss') info,
sjh_kodecustomer, sjh_tglstruk, SUBSTR(sjh_nostruk,1,2) || '.' || SUBSTR(sjh_nostruk,3,3) || '.' || SUBSTR(sjh_nostruk,6,5) struk, sjh_tglpenitipan,
CASE WHEN NVL(sjh_nosjas, '1234567') = '1234567' THEN 'Blm Pernah Diambil' ELSE 'Sdh ' || TO_CHAR(sjh_frektahapan,'999') || 'x Srt Jalan' END status,
cus_namamember,  SJH_NOSJAS,
trjd_seqno, trjd_prdcd, trjd_quantity,
prd_deskripsipendek, prd_unit || '/' || prd_frac unit
FROM tbtr_sjas_h, tbmaster_customer, tbtr_jualdetail, tbmaster_prodmast, tbmaster_perusahaan
WHERE sjh_kodeigr = '$kodeigr' AND NVL(sjh_flagselesai, 'N') <> 'Y'
$p_and
AND cus_kodemember = sjh_kodecustomer
AND TRJD_KODEIGR = sjh_kodeigr AND TRUNC(TRJD_TRANSACTIONDATE) = TRUNC(sjh_tglstruk) AND TRJD_CASHIERSTATION = SUBSTR(sjh_nostruk,1,2) AND TRJD_CREATE_BY = SUBSTR(sjh_nostruk,3,3) AND TRJD_TRANSACTIONNO = SUBSTR(sjh_nostruk,6,5)
AND TRJD_TRANSACTIONTYPE = 'S'
AND prd_kodeigr = trjd_kodeigr AND prd_prdcd = trjd_prdcd
AND prs_kodeigr = sjh_kodeigr
ORDER BY cus_namamember, sjh_tglstruk, sjh_nostruk, trjd_seqno");


        if(!$cursor){
            return response()->json(['kode' => 1]);
        }else{
            return response()->json(['kode' => 0]);
        }
    }
    public function printDocument(Request $request){
        $kodeigr = $_SESSION['kdigr'];
        $all = $request->all;
        $p_custinfo = "";
        if($all == 'Y'){
            $p_and = '';
            $counter = DB::table("TBTR_SJAS_H")
                ->selectRaw("distinct SJH_KODECUSTOMER as SJH_KODECUSTOMER")
                ->where('SJH_KODEIGR','=',$kodeigr)
                ->whereRaw("NVL(SJH_FLAGSELESAI, 'N') <> 'Y'")
                ->get();
                $p_custinfo = "* Total : ".strval(sizeof($counter))." Customer *";
        }else{
            $kodeMem = $request->kodeMem;
            $struk = $request->struk;
            $p_and = " AND SJH_KODECUSTOMER = '".$kodeMem."' AND SJH_NOSTRUK = '".$struk."'";
        }

        $datas = DB::select("SELECT prs_namaperusahaan, prs_namacabang, 'Print: ' || TO_CHAR(SYSDATE, 'dd-MM-yy hh:mm:ss') info,
sjh_kodecustomer, sjh_tglstruk, SUBSTR(sjh_nostruk,1,2) || '.' || SUBSTR(sjh_nostruk,3,3) || '.' || SUBSTR(sjh_nostruk,6,5) struk, sjh_tglpenitipan,
CASE WHEN NVL(sjh_nosjas, '1234567') = '1234567' THEN 'Blm Pernah Diambil' ELSE 'Sdh ' || TO_CHAR(sjh_frektahapan,'999') || 'x Srt Jalan' END status,
cus_namamember,  SJH_NOSJAS,
trjd_seqno, trjd_prdcd, trjd_quantity,
prd_deskripsipendek, prd_unit || '/' || prd_frac unit
FROM tbtr_sjas_h, tbmaster_customer, tbtr_jualdetail, tbmaster_prodmast, tbmaster_perusahaan
WHERE sjh_kodeigr = '$kodeigr' AND NVL(sjh_flagselesai, 'N') <> 'Y'
$p_and
AND cus_kodemember = sjh_kodecustomer
AND TRJD_KODEIGR = sjh_kodeigr AND TRUNC(TRJD_TRANSACTIONDATE) = TRUNC(sjh_tglstruk) AND TRJD_CASHIERSTATION = SUBSTR(sjh_nostruk,1,2) AND TRJD_CREATE_BY = SUBSTR(sjh_nostruk,3,3) AND TRJD_TRANSACTIONNO = SUBSTR(sjh_nostruk,6,5)
AND TRJD_TRANSACTIONTYPE = 'S'
AND prd_kodeigr = trjd_kodeigr AND prd_prdcd = trjd_prdcd
AND prs_kodeigr = sjh_kodeigr
ORDER BY cus_namamember, sjh_tglstruk, sjh_nostruk, trjd_seqno");

        for($i = 0; $i < sizeof($datas); $i++){
            $qty = DB::table('TBTR_SJAS_D')
                ->selectRaw("SUM(SJD_QTYSJAS) QTY")
                ->where('SJD_KODEIGR','=',$kodeigr)
                ->where('SJD_NOSJAS','=',$datas[$i]->sjh_nosjas)
                ->where('SJD_PRDCD','=',$datas[$i]->trjd_prdcd)
                ->where('SJD_KODECUSTOMER','=',$datas[$i]->sjh_kodecustomer)
                ->first();
            $sisa[$i] = ($datas[$i]->trjd_quantity)-($qty->qty);
        }
        //PRINT
        $path = 'BTAS\MONITORING.PerCus-pdf';

        $pdf = PDF::loadview($path,
            ['kodeigr' => $kodeigr, 'datas' => $datas, 'p_custinfo' => $p_custinfo, 'sisa' => $sisa]);
        $pdf->setPaper('A4', 'potrait');
        $pdf->output();
        $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);

        $canvas = $dompdf ->get_canvas();
        $canvas->page_text(514, 10, "Hal {PAGE_NUM} / {PAGE_COUNT}", null, 8, array(0, 0, 0));

        return $pdf->stream("$path");
    }
}
