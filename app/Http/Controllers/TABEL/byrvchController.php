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


    public function GetSupp(){
        $kodeigr = $_SESSION['kdigr'];

        $datas = DB::table("tbmaster_hargabeli")
            ->selectRaw("DISTINCT hgb_kodesupplier as hgb_kodesupplier")
            ->selectRaw("sup_namasupplier")

            ->leftJoin('tbmaster_supplier',function($join){
                $join->on('sup_kodeigr','hgb_kodeigr');
                $join->on('sup_kodesupplier','hgb_kodesupplier');
            })

            ->where('hgb_kodeigr','=',$kodeigr)
            ->where("hgb_tipe",'=','2')

            ->orderBy("hgb_kodesupplier")
            ->get();

        return Datatables::of($datas)->make(true);
    }

    public function GetSingkatan(){
        $kodeigr = $_SESSION['kdigr'];

        $datas = DB::table("TBTABEL_VOUCHERSUPPLIER")
            ->selectRaw("VCS_NAMASUPPLIER")
            ->selectRaw("VCS_NILAIVOUCHER")

            ->where('VCS_KODEIGR','=',$kodeigr)

            ->get();

        return Datatables::of($datas)->make(true);
    }


    public function CheckVoucher(Request $request){
        $kodeigr = $_SESSION['kdigr'];
        $supp = $request->supp;
        $sing = $request->sing;
        $tglAwal = '';
        $tglAkhir = '';

        $temp = DB::table("TBTABEL_PEMBAYARANVOUCHER")
            ->selectRaw("DISTINCT TO_CHAR(BYR_TGLAWAL, 'DD/MM/YYYY') as BYR_TGLAWAL")
            ->selectRaw("TO_CHAR(BYR_TGLAKHIR, 'DD/MM/YYYY') as BYR_TGLAKHIR")
            ->where("BYR_KODEIGR",'=',$kodeigr)
            ->where("BYR_KODESUPPLIER",'=',$supp)
            ->whereRaw("TRIM(BYR_SINGKATANSUPPLIER) = TRIM('$sing')")
            ->first();
        if($temp){
            $tglAwal = $temp->byr_tglawal;
            $tglAkhir = $temp->byr_tglakhir;
        }
        return response()->json(['tglAwal' => $tglAwal, 'tglAkhir' => $tglAkhir]);
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
