<?php
/**
 * Created by PhpStorm.
 * User: ryan
 * Date: 1/12/2021
 * Time: 3:25 PM
 */

namespace App\Http\Controllers\BACKOFFICE\TRANSAKSI\REPACKING;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller; use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use PDF;
use DateTime;

class LapRepackController extends Controller
{

    public function index()
    {
        return view('BACKOFFICE.TRANSAKSI.REPACKING.laprepack');
    }
    public function CheckData(Request $request){
        $kodeigr = Session::get('kdigr');
        $dateA = $request->dateA;
        $dateB = $request->dateB;
        $sDate = DateTime::createFromFormat('d-m-Y', $dateA)->format('d-m-Y');
        $eDate = DateTime::createFromFormat('d-m-Y', $dateB)->format('d-m-Y');
        $cursor = DB::connection(Session::get('connection'))->select("Select RowNum, msth_nodoc, to_char(msth_tgldoc, 'dd-mm-yyyy') tgldoc, prd_p,desk_p,gross_p,prd_r,desk_r,gross_r, prs_namaperusahaan, prs_namacabang
From (Select msth_nodoc, msth_tgldoc,
             Case mstd_flagdisc1 When 'P' Then mstd_prdcd Else Null End prd_p,
             Case mstd_flagdisc1 When 'P' Then prd_deskripsipanjang Else Null End desk_p,
             Case mstd_flagdisc1 When 'P' Then mstd_gross Else Null End gross_p,
             Case mstd_flagdisc1 When 'R' Then mstd_prdcd Else Null End prd_r,
             Case mstd_flagdisc1 When 'R' Then prd_deskripsipanjang Else Null End desk_r,
             Case mstd_flagdisc1 When 'R' Then mstd_gross Else Null End gross_r,
             prs_namaperusahaan,
             prs_namacabang
From tbtr_mstran_h, tbtr_mstran_d, tbmaster_prodmast,tbmaster_perusahaan
Where msth_kodeigr=mstd_kodeigr
  and msth_nodoc=mstd_nodoc
  and mstd_kodeigr=prd_kodeigr
  and mstd_prdcd=prd_prdcd
  and nvl(mstd_recordid,'9') <> '1'
  and msth_kodeigr=prs_kodeigr
  and msth_kodeigr='$kodeigr'
  and msth_tgldoc between TO_DATE('$sDate','DD-MM-YYYY') and TO_DATE('$eDate', 'DD-MM-YYYY')
  and msth_typetrn='P'
  and nvl(msth_recordid,'9') <> '1'
Order by msth_tgldoc,msth_nodoc,mstd_flagdisc1 desc,mstd_seqno)");
        if(!$cursor){
            return response()->json(['kode' => 0]);
        }else{
            return response()->json(['kode' => 1]);
        }
    }
    public function printDocument(Request $request){
        $kodeigr = Session::get('kdigr');
        $dateA = $request->date1;
        $dateB = $request->date2;
        $today = date('d-m-Y');
        $time = date('H:i:s');
        $p_prog = 'LAP030';
        $sDate = DateTime::createFromFormat('d-m-Y', $dateA)->format('d-m-Y');
        $eDate = DateTime::createFromFormat('d-m-Y', $dateB)->format('d-m-Y');

    $datas = DB::connection(Session::get('connection'))->select("Select RowNum, msth_nodoc, to_char(msth_tgldoc, 'dd-mm-yyyy') tgldoc, prd_p,desk_p,gross_p,prd_r,desk_r,gross_r, prs_namaperusahaan, prs_namacabang
From (Select msth_nodoc, msth_tgldoc,
             Case mstd_flagdisc1 When 'P' Then mstd_prdcd Else Null End prd_p,
             Case mstd_flagdisc1 When 'P' Then prd_deskripsipanjang Else Null End desk_p,
             Case mstd_flagdisc1 When 'P' Then mstd_gross Else Null End gross_p,
             Case mstd_flagdisc1 When 'R' Then mstd_prdcd Else Null End prd_r,
             Case mstd_flagdisc1 When 'R' Then prd_deskripsipanjang Else Null End desk_r,
             Case mstd_flagdisc1 When 'R' Then mstd_gross Else Null End gross_r,
             prs_namaperusahaan,
             prs_namacabang
From tbtr_mstran_h, tbtr_mstran_d, tbmaster_prodmast,tbmaster_perusahaan
Where msth_kodeigr=mstd_kodeigr
  and msth_nodoc=mstd_nodoc
  and mstd_kodeigr=prd_kodeigr
  and mstd_prdcd=prd_prdcd
  and nvl(mstd_recordid,'9') <> '1'
  and msth_kodeigr=prs_kodeigr
  and msth_kodeigr='$kodeigr'
  and msth_tgldoc between TO_DATE('$sDate','DD-MM-YYYY') and TO_DATE('$eDate', 'DD-MM-YYYY')
  and msth_typetrn='P'
  and nvl(msth_recordid,'9') <> '1'
Order by msth_tgldoc,msth_nodoc,mstd_flagdisc1 desc,mstd_seqno)");
        //PRINT
        $pdf = PDF::loadview('BACKOFFICE.TRANSAKSI.REPACKING.laprepack-laporan',
            ['kodeigr' => $kodeigr, 'p_tgl1' => $sDate, 'p_tgl2' => $eDate, 'p_prog' => $p_prog, 'datas' => $datas, 'today' => $today, 'time' => $time]);
        $pdf->setPaper('A4', 'potrait');
        $pdf->output();
        $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);

        $canvas = $dompdf ->get_canvas();
        $canvas->page_text(514, 10, "Hal {PAGE_NUM} / {PAGE_COUNT}", null, 8, array(0, 0, 0));

        return $pdf->stream('laprepack-laporan.pdf');
    }
}
