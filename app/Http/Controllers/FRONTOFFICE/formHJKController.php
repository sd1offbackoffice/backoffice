<?php
/**
 * Created by PhpStorm.
 * User: ryan
 * Date: 1/12/2021
 * Time: 3:25 PM
 */

namespace App\Http\Controllers\FRONTOFFICE;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use PDF;
use DateTime;
use Yajra\DataTables\DataTables;

class formHJKController extends Controller
{

    public function index()
    {
        return view('FRONTOFFICE.formHJK');
    }

    public function getNmr(Request $request)
    {
        $search = $request->val;
        $kodeigr = $_SESSION['kdigr'];

        $datas = DB::table('tbmaster_supplier')
            ->selectRaw('distinct sup_kodesupplier as sup_kodesupplier')
            ->selectRaw('sup_namasupplier')
            ->where('sup_kodesupplier','LIKE', '%'.$search.'%')
            ->where('sup_kodeigr','=',$kodeigr)
            ->orderBy('sup_namasupplier')
            ->limit(100)
            ->get();

        return response()->json($datas);
    }

    public function dataModal(Request $request){
        $kodeigr = $_SESSION['kdigr'];
        $search = $request->value;

        $datas = DB::table('TBMASTER_PRODMAST')
            ->selectRaw('PRD_PRDCD')
            ->selectRaw('PRD_DESKRIPSIPANJANG')
            ->selectRaw("PRD_UNIT||'/'||TO_CHAR(PRD_FRAC) SATUAN")
            ->selectRaw('PRD_HRGJUAL')

            ->where('prd_prdcd','LIKE', '%'.$search.'%')
            ->where('prd_kodeigr', '=', $kodeigr)

            ->orWhere('prd_deskripsipanjang','LIKE', '%'.$search.'%')
            ->where('prd_kodeigr', '=', $kodeigr)

            ->orderBy('prd_deskripsipanjang')
            ->limit(100)->get()->toArray();

        return Datatables::of($datas)->make(true);
    }

//    public function GetPlu(Request $request){
//        $kodeigr = $_SESSION['kdigr'];
//        $search = $request->val;
//
//        $datas = DB::table('TBMASTER_PRODMAST')
//            ->selectRaw('PRD_PRDCD')
//            ->selectRaw('PRD_DESKRIPSIPANJANG')
//            ->selectRaw("PRD_UNIT||'/'||TO_CHAR(PRD_FRAC) SATUAN")
//            ->selectRaw('PRD_HRGJUAL')
//
//            ->whereRaw("(prd_deskripsipanjang LIKE '%". $search."%' or prd_prdcd LIKE '%". $search."%')")
//            ->where('prd_kodeigr', '=', $kodeigr)
//            ->orderBy('prd_deskripsipanjang')
//            ->limit(100)->get();
//
//        return response()->json($datas);
//    }

    public function ChoosePlu(Request $request){
        $kodeigr = $_SESSION['kdigr'];
        $kode = $request->kode;


        $cursor = DB::select("SELECT   prd_prdcd,
                             prd_deskripsipanjang deskripsi,
                             prd_unit unit,
                             prd_frac frac,
                             prd_minjual minj,
                             prd_flagbkp1 pkp,
                             NVL(prd_flagbkp2, 'xx') pkp2,
                             prd_hrgjual price_a,
                             prd_kodetag ptag,
                             NVL(prd_lastcost, 0) prd_lcost,
                             NVL(prmd_prdcd, 'xxx') prmd_prdcd,
                             prmd_hrgjual fmjual,
                             prmd_potonganpersen fmpotp,
                             prmd_potonganrph fmpotr,
                             NVL(st_avgcost, 0) st_lcost,
                             TO_CHAR(NVL(MAX(prmd_tglawal), SYSDATE + 1), 'mm-dd-yyyy') fmfrtg,
                             TO_CHAR(NVL(MAX(prmd_tglakhir), SYSDATE - 1), 'mm-dd-yyyy') fmtotg,
                             NVL(prmd_jamawal, '00:00:00') fmfrhr,
                             NVL(prmd_jamakhir, '23:59:59') fmtohr
                        FROM tbmaster_prodmast, tbtr_promomd, tbmaster_stock
                       WHERE prd_kodeigr = '$kodeigr'
                         AND prd_prdcd = '$kode'
                         AND prmd_prdcd(+) = prd_prdcd
                         AND prmd_kodeigr(+) = prd_kodeigr
                         AND SUBSTR(st_prdcd(+), 1, 6) = SUBSTR(prd_prdcd, 1, 6)
                         AND st_kodeigr(+) = prd_kodeigr
                         AND st_lokasi(+) = '01'
                    GROUP BY prd_prdcd,
                             prd_deskripsipanjang,
                             prd_unit,
                             prd_frac,
                             prd_minjual,
                             prd_flagbkp1,
                             NVL(prd_flagbkp2, 'xx'),
                             prd_hrgjual,
                             prd_kodetag,
                             NVL(prd_lastcost, 0),
                             NVL(prmd_prdcd, 'xxx'),
                             prmd_hrgjual,
                             prmd_potonganpersen,
                             prmd_potonganrph,
                             NVL(st_avgcost, 0),
                             prmd_jamawal,
                             prmd_jamakhir
                    ORDER BY prd_prdcd");
        if (!$cursor){
            $msg = "Kode Produk ". $kode. " Tidak Terdaftar!";

            return response()->json(['kode' => 0, 'msg' => $msg, 'data' => '']);
        }
        else{
            return response()->json(['kode' => 1, 'msg' => '', 'data' => $cursor]);
        }
    }

    public function CalculateMargin(Request $request){
        $kodeigr = $_SESSION['kdigr'];
        $kode = $request->kode;


        $cursor = DB::select("SELECT   PRD_PRDCD, PRD_DESKRIPSIPANJANG DESKRIPSI, PRD_UNIT UNIT,
                         PRD_FRAC FRAC, PRD_MINJUAL MINJ, PRD_FLAGBKP1 PKP,
                         NVL (PRD_FLAGBKP2, 'xx') PKP2, PRD_HRGJUAL PRICE_A, PRD_KODETAG PTAG,
                         NVL (PRD_LASTCOST, 0) PRD_LCOST,
                         NVL (PRD_AVGCOST, 0) PRD_ACOST,
                         NVL (ST_AVGCOST, 0) ST_LCOST
                    FROM TBMASTER_PRODMAST, TBMASTER_STOCK
                   WHERE PRD_KODEIGR = '$kodeigr'
                     AND PRD_PRDCD = '$kode'
                     AND SUBSTR (ST_PRDCD(+), 1, 6) = SUBSTR (PRD_PRDCD, 1, 6)
                     AND ST_KODEIGR(+) = PRD_KODEIGR
                     AND ST_LOKASI(+) = '01'
                GROUP BY PRD_PRDCD,
                         PRD_DESKRIPSIPANJANG,
                         PRD_UNIT,
                         PRD_FRAC,
                         PRD_MINJUAL,
                         PRD_FLAGBKP1,
                         NVL (PRD_FLAGBKP2, 'xx'),
                         PRD_HRGJUAL,
                         PRD_KODETAG,
                         NVL (PRD_LASTCOST, 0),
                         NVL (PRD_AVGCOST, 0),
                         NVL (ST_AVGCOST, 0)
                ORDER BY PRD_PRDCD");
        return response()->json(['data' => $cursor]);
    }

    public function printDocument(Request  $request){
        //$session_id = session()->getId();
        $kodeigr = $_SESSION['kdigr'];
        $datas = $request->datas;
        $dateA = $request->dateA;
        $dateB = $request->dateB;
        $prs = DB::table('tbmaster_perusahaan')
            ->selectRaw("prs_namaperusahaan")
            ->selectRaw("prs_namacabang")
            ->first();

        //PRINT
        $today = date('d-m-Y');
        $time = date('H:i:s');
        $pdf = PDF::loadview('FRONTOFFICE.formHJK-pdf',
            ['kodeigr' => $kodeigr,'date1' => $dateA, 'date2' => $dateB, 'data' => $datas, 'perusahaan' => $prs, 'today' => $today, 'time' => $time]);
        $pdf->setPaper('A4', 'potrait');
        $pdf->output();
        $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);

        $canvas = $dompdf ->get_canvas();
        $canvas->page_text(511, 78, "{PAGE_NUM} / {PAGE_COUNT}", null, 7, array(0, 0, 0));

        return $pdf->stream('formHJK.pdf');
    }

}
