<?php
/**
 * Created by PhpStorm.
 * User: ryan
 * Date: 03/11/2021
 * Time: 11:54 AM
 */

namespace App\Http\Controllers\TABEL;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use PDF;
use DateTime;
use Yajra\DataTables\DataTables;

class byrvchController extends Controller
{

    public function index()
    {
        return view('TABEL.byrvch');
    }


    public function ModalPlu(Request $request){
        $kodeigr = $_SESSION['kdigr'];
        $search = $request->value;

        $datas = DB::table("TBMASTER_PRODMAST")
            ->selectRaw("PRD_DESKRIPSIPANJANG")
            ->selectRaw("PRD_PRDCD")

            ->where('PRD_DESKRIPSIPANJANG','LIKE','%'.$search.'%')
            ->whereRaw("nvl(prd_recordid,9)<>1")
            ->where('PRD_KODEIGR','=',$kodeigr)

            ->orWhere('PRD_PRDCD','LIKE','%'.$search.'%')
            ->whereRaw("nvl(prd_recordid,9)<>1")
            ->where('PRD_KODEIGR','=',$kodeigr)

            ->orderBy("PRD_DESKRIPSIPANJANG")
            ->limit(100)
            ->get();

        return Datatables::of($datas)->make(true);
    }


    public function CheckPlu(Request $request){
        $kodeigr = $_SESSION['kdigr'];
        $kode = $request->kode;
        $notif = '';
        $deskripsi = '';
        $unit = '';

        $datas = DB::select("SELECT prd_prdcd
          FROM TBMASTER_PRODMAST, TBMASTER_BARCODE
         WHERE prd_kodeigr = '$kodeigr'
           AND prd_prdcd = brc_prdcd(+)
           AND (prd_prdcd = TRIM ('$kode') OR brc_barcode = TRIM ('kode'))");
        if($datas){
            $temp = DB::table("TBMASTER_PRODMAST")
                ->selectRaw("PRD_DESKRIPSIPANJANG")
                ->selectRaw("PRD_UNIT || '/' || PRD_FRAC as unit")
                ->where("PRD_KODEIGR",'=',$kodeigr)
                ->where("PRD_PRDCD",'=',$kode)
                ->first();
            $deskripsi = $temp->prd_deskripsipanjang;
            $unit = $temp->unit;
        }else{
            $notif = "Kode PLU ".$kode." - ".$kodeigr." Tidak Terdaftar di Master Barang  !!";
        }

        return response()->json(['notif' => $notif, 'deskripsi'=>$deskripsi, 'unit'=>$unit]);
    }

    public function save(Request $request){
        $kodeigr = $_SESSION['kdigr'];
        $datas  = $request->datas;
        $dateA = $request->date1;
        $dateB = $request->date2;
        $sDate = DateTime::createFromFormat('d-m-Y', $dateA)->format('d-m-Y');
        $eDate = DateTime::createFromFormat('d-m-Y', $dateB)->format('d-m-Y');
        for($i=1;$i<sizeof($datas);$i++){
            DB::table("tbtr_hadiahkejutan")
                ->insert([
                    'spot_kodeigr'=>$kodeigr,
                    'spot_periodeawal'=>DB::RAW("TO_DATE('$sDate','DD-MM-YYYY')"),
                    'spot_periodeakhir'=>DB::RAW("TO_DATE('$eDate','DD-MM-YYYY')"),
                    'spot_prdcd'=>$datas[$i]['plu'],
                    'spot_fmtrgq'=>$datas[$i]['qty'],
                    'spot_fmtrgs'=>$datas[$i]['sales'],
                    'spot_fmtrgg'=>$datas[$i]['margin'],
                    'spot_hrgjual'=>$datas[$i]['hrg'],
                    'spot_create_by'=>$_SESSION['usid'],
                    'spot_create_dt'=>DB::RAW("trunc(SYSDATE)"),
                    'spot_modify_by'=>'',
                    'spot_modify_dt'=>'',
                ]);
        }

    }
}
