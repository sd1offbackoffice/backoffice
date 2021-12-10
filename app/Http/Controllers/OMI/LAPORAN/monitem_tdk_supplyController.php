<?php
/**
 * Created by PhpStorm.
 * User: ryan
 * Date: 08/09/2021
 * Time: 9:13 AM
 */

namespace App\Http\Controllers\OMI\LAPORAN;

use App\Http\Controllers\Auth\loginController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller; use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use PDF;
use DateTime;
use Yajra\DataTables\DataTables;

class monitem_tdk_supplyController extends Controller
{

    public function index()
    {
        return view('OMI.LAPORAN.monitem_tdk_supply');
    }

    public function monModal(){
        $kodeigr = Session::get('kdigr');

        $datas = DB::connection(Session::get('connection'))->table("tbtr_monitoringplu")
            ->selectRaw("distinct MPL_KodeMonitoring, MPL_NamaMonitoring")
            ->where("MPL_KodeIGR",'=',$kodeigr)
            ->orderBy("MPL_KodeMonitoring")
            ->get();

        return Datatables::of($datas)->make(true);
    }

    public function fillTable(Request $request){
        $kdMon = $request->kdmon;
        $dateA = $request->date1;
        $dateB = $request->date2;
        $sDate = DateTime::createFromFormat('d-m-Y', $dateA)->format('d-m-Y');
        $sDate = explode("-",$sDate);
        $sDate = $sDate[2].$sDate[1].$sDate[0];
        $eDate = DateTime::createFromFormat('d-m-Y', $dateB)->format('d-m-Y');
        $eDate = explode("-",$eDate);
        $eDate = $eDate[2].$eDate[1].$eDate[0];

        DB::connection(Session::get('connection'))->table("temp_lap211")
            ->truncate();
//        ("temp_lap211")
//            ->selectRaw("*")
//            ->get();

        $connect = loginController::getConnectionProcedure();
        $query = oci_parse($connect, "BEGIN FILL_TEMP_LAP211('$sDate','$eDate','$kdMon'); END;");

        oci_execute($query);
    }

    public function getTable(){
        $datas = DB::connection(Session::get('connection'))->table("temp_lap211")
            ->selectRaw("*")
            ->get();
        return Datatables::of($datas)->make(true);
    }

    public function checkData(){
        $datas = DB::connection(Session::get('connection'))->table("temp_lap211")
            ->selectRaw("*")
            ->first();
        if($datas){
            return response()->json(true);
        }else{
            return response()->json(false);
        }
    }

    public function cetak(Request $request){
        $kodeigr = Session::get('kdigr');


        $dateA = $request->date1;
        $dateB = $request->date2;
//        $sDate = DateTime::createFromFormat('d-m-Y', $dateA)->format('d-m-Y');
//        $eDate = DateTime::createFromFormat('d-m-Y', $dateB)->format('d-m-Y');

        $datas = DB::connection(Session::get('connection'))->select("Select PRS_NamaPerusahaan,
       PRS_NamaCabang,
       PRS_NamaWilayah,
       PLUIGR,
       Divisi,
       Deskripsi,
       UNIT||' / '||RPAD(FRAC,3,' ') as Satuan,
       Tag,
       REPLACE(to_char(PBOMI,'99G999'),',','.') as PBOMI,
       REPLACE(to_char(ACTUAL,'99G999'),',','.') as ACTUAL,
       REPLACE(to_char(SELISIH,'99G999'),',','.') as SELISIH,
       STOCK,
       TglPB,
       REPLACE(to_char(QtyPB,'999G999'),',','.') as QtyPB,
       BPB,
       TglPO,
       REPLACE(to_char(PKMT,'99G999'),',','.') as PKMT,
       REPLACE(to_char(MPlus,'99G999'),',','.') as MPlus,
       Flag,
       FCETAK,
       CASE WHEN FCETAK = '1' THEN '*' ELSE '' END as KD
From
(
Select FTKODE as PLUIGR,
       FTDIVI ||' - '||DIV_NamaDivisi as Divisi,
       SUBSTR(PRD_DeskripsiPanjang,1,38) as Deskripsi,
       PRD_UNIT as Unit,
       PRD_FRAC as Frac,
       PRD_KodeTag as Tag,
       FTQTYO as PBOMI,
       FTQTYR as ACTUAL,
       FTQTYL as SELISIH,
       FTQTYS as STOCK,
       FTTGPB as TglPB,
       NVL(FTQTYP,0) as QtyPB,
       FTTBPB as BPB,
       FTTGBP as TglPO,
       NVL(FTPKMT,0) as PKMT,
       NVL(FTMPLS,0) as MPlus,
       FTFLAG as Flag,
       FCETAK
  From temp_Lap211, tbMaster_Prodmast, tbMaster_Divisi
 Where PRD_PRDCD = FTKODE
   And PRD_KodeDivisi = FTDIVI
   And PRD_KodeDepartement = FTDEPT
   And PRD_KodeKategoriBarang = FTKATB
   And DIV_KodeDivisi = PRD_KodeDivisi
  Order By FTDivi
) A, tbMaster_Perusahaan
ORDER BY STOCK ");
        if(sizeof($datas) == 0){
            return "**DATA TIDAK ADA**";
        }
        //PRINT
        $today = date('d-m-Y');
        $time = date('H:i:s');
        $pdf = PDF::loadview('OMI.LAPORAN.monitem_tdk_supply-pdf',
            ['kodeigr' => $kodeigr, 'datas' => $datas, 'today' => $today, 'time' => $time, 'date1' => $dateA, 'date2' => $dateB]);
        $pdf->setPaper('A4', 'potrait');
        $pdf->output();
        $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);

        $canvas = $dompdf ->get_canvas();
        $canvas->page_text(524, 24, "HAL {PAGE_NUM} / {PAGE_COUNT}", null, 8, array(0, 0, 0));

        return $pdf->stream('monitem_tdk_supply_pdf.pdf');
    }
}
