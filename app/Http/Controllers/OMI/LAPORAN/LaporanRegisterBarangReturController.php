<?php
/**
 * Created by PhpStorm.
 * User: ryan
 * Date: 20/09/2021
 * Time: 8:28 AM
 */

namespace App\Http\Controllers\OMI\LAPORAN;

use App\Http\Controllers\ExcelController;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller; use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use PDF;
use DateTime;
use Yajra\DataTables\DataTables;

class LaporanRegisterBarangReturController extends Controller
{

    public function index()
    {
        return view('OMI.LAPORAN.laporan-register-barang-retur');
    }



    public function cetak(Request $request){
        $kodeigr = Session::get('kdigr');
        $nodoc1 = $request->nodoc1;
        $nodoc2 = $request->nodoc2;
        $p_prog = 'IGR0369';
        $and_doc = '';
        if($nodoc1 != '' && $nodoc2 != ''){
            $and_doc = " and rom_nodokumen between '".$nodoc1."' and '".$nodoc2."'";
        }

        $dateA = $request->date1;
        $dateB = $request->date2;
        $sDate = DateTime::createFromFormat('d-m-Y', $dateA)->format('d-m-Y');
        $eDate = DateTime::createFromFormat('d-m-Y', $dateB)->format('d-m-Y');

        $datas = DB::connection(Session::get('connection'))->select("SELECT rom_nodokumen, tgldok, rom_kodetoko, rom_member, rom_noreferensi,
    rom_tglreferensi, SUM(rom_ttlcost) total, cus_namamember, SUM(item) item,
    prs_namaperusahaan, prs_namacabang, prs_namawilayah, (rom_member  || ' - ' || cus_namamember) member,
    sum(case when flag_bkp='Y' then rom_ttlcost else 0 end) ttl_bkp,
    sum(case when flag_bkp ='N' then rom_ttlcost else 0 end) ttl_btkp
FROM(SELECT rom_nodokumen, TRUNC(rom_tgldokumen) tgldok, rom_kodetoko, rom_member,
    rom_noreferensi, rom_tglreferensi, rom_ttlcost, cus_namamember, 1 item,
    prs_namaperusahaan, prs_namacabang, prs_namawilayah,
    case when prd_flagbkp1='Y' and prd_flagbkp1='Y' then 'Y' else 'N' end flag_bkp
FROM TBTR_RETUROMI, TBMASTER_CUSTOMER, TBMASTER_PERUSAHAAN, TBMASTER_PRODMAST
WHERE rom_kodeigr = '$kodeigr'
              AND TRUNC(rom_tgldokumen) BETWEEN TO_DATE('$sDate','DD-MM-YYYY') and TO_DATE('$eDate', 'DD-MM-YYYY')
              ".$and_doc."
              AND cus_kodemember(+) = rom_member
              AND prs_kodeigr = rom_kodeigr
              AND substr(rom_prdcd,1,6)||'0' = prd_prdcd(+)
ORDER BY rom_tgldokumen, rom_nodokumen)
GROUP BY rom_nodokumen, tgldok, rom_kodetoko, rom_member, rom_noreferensi, rom_tglreferensi,
    cus_namamember, prs_namaperusahaan, prs_namacabang, prs_namawilayah
    ORDER BY tgldok, rom_nodokumen
");
        //PRINT
        $perusahaan = DB::table("tbmaster_perusahaan")->first();
        $today = date('d-m-Y');
        $time = date('H:i:s');
//        return view('OMI.LAPORAN.laporan-register-barang-retur-pdf',
//            ['kodeigr' => $kodeigr, 'date1' => $dateA, 'date2' => $dateB, 'nodoc1' => $nodoc1 , 'nodoc2' => $nodoc2, 'data' => $datas, 'today' => $today, 'time' => $time, 'perusahaan' => $perusahaan]);


        $title = 'LAPORAN REGISTER BARANG RETUR';
        $filename = $title.'_'.Carbon::now()->format('dmY_His').'.xlsx';
        $view = view('OMI.LAPORAN.laporan-register-barang-retur-xlxs',
            ['kodeigr' => $kodeigr, 'date1' => $dateA, 'date2' => $dateB, 'nodoc1' => $nodoc1 , 'nodoc2' => $nodoc2, 'data' => $datas, 'today' => $today, 'time' => $time, 'perusahaan' => $perusahaan])
            ->render();
        $keterangan = '';
        $subtitle = 'TANGGAL :'. $dateA .' s/d '. $dateB." NO. DOKUMEN :". $nodoc1 .' s/d '. $nodoc2;
        ExcelController::create($view,$filename,$title,$subtitle,$keterangan);

        return response()->download(storage_path($filename))->deleteFileAfterSend(true);
    }
}
