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

class TabelPembayaranVoucherController extends Controller
{

    public function index()
    {
        return view('TABEL.tabel-pembayaran-voucher');
    }


    public function GetSupp(){
        $kodeigr = $_SESSION['kdigr'];

        $datas = DB::connection($_SESSION['connection'])->table("tbmaster_hargabeli")
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

        $datas = DB::connection($_SESSION['connection'])->table("TBTABEL_VOUCHERSUPPLIER")
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

        $temp = DB::connection($_SESSION['connection'])->table("TBTABEL_PEMBAYARANVOUCHER")
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

    public function CheckDBTable(Request $request){
        $kodeigr = $_SESSION['kdigr'];
        $usid = $_SESSION['usid'];
        $supp = $request->supp;
        $sing = $request->sing;
        $dateA = $request->date1;
        $dateB = $request->date2;
        $sDate = DateTime::createFromFormat('d-m-Y', $dateA)->format('d-m-Y');
        $eDate = DateTime::createFromFormat('d-m-Y', $dateB)->format('d-m-Y');
        try{
            DB::connection($_SESSION['connection'])->beginTransaction();

            $temp = DB::connection($_SESSION['connection'])->table("TBTABEL_PEMBAYARANVOUCHER")
                ->selectRaw("NVL (COUNT (1), 0) as result")
                ->where("BYR_KODEIGR",'=',$kodeigr)
                ->where("BYR_KODESUPPLIER",'=',$supp)
                ->whereRaw("TRIM(BYR_SINGKATANSUPPLIER) = TRIM('$sing')")
                ->first();
            if($temp->result == '0'){
                $datas = DB::connection($_SESSION['connection'])->table("TBMASTER_HARGABELI")
                    ->selectRaw("HGB_PRDCD")

                    ->leftJoin('TBMASTER_PRODMAST',function($join){
                        $join->on('PRD_PRDCD','HGB_PRDCD');
                        $join->on('PRD_KODEIGR','HGB_KODEIGR');
                    })
                    ->where("HGB_KODEIGR",'=',$kodeigr)
                    ->where("HGB_TIPE",'=','2')
                    ->where("HGB_KODESUPPLIER",'=',$supp)
                    ->whereRaw("PRD_KODETAG NOT IN ('N', 'H', 'X')")

                    ->get();
                for($i=0;$i<sizeof($datas);$i++){
                    DB::connection($_SESSION['connection'])->table("TBTABEL_PEMBAYARANVOUCHER")
                        ->insert([
                            'BYR_KODEIGR'=>$kodeigr,
                            'BYR_KODESUPPLIER'=>$supp,
                            'BYR_SINGKATANSUPPLIER'=>$sing,
                            'BYR_PRDCD'=>$datas[$i]->hgb_prdcd,
                            'BYR_QTYMAXVOUCHER'=>0,
                            'BYR_TGLAWAL'=>DB::RAW("TO_DATE('$sDate','DD-MM-YYYY')"),
                            'BYR_TGLAKHIR'=>DB::RAW("TO_DATE('$eDate','DD-MM-YYYY')"),
                            'BYR_CREATE_BY'=>$usid,
                            'BYR_CREATE_DT'=>DB::RAW("trunc(SYSDATE)"),
                            'BYR_RECORDID'=>0,
                        ]);
                }
            }
//            $datas = DB::connection($_SESSION['connection'])->table("TBTABEL_PEMBAYARANVOUCHER")
//                ->selectRaw("BYR_PRDCD")
//                ->selectRaw("prd_deskripsipanjang")
//                ->selectRaw("byr_qtymaxvoucher")
////            ->selectRaw("byr_recordid")
//
//                ->leftJoin("TBMASTER_PRODMAST",'PRD_PRDCD','BYR_PRDCD')
//
//                ->where("BYR_KODEIGR",'=',$kodeigr)
//                ->where("BYR_KODESUPPLIER",'=',$supp)
//                ->whereRaw("TRIM(BYR_SINGKATANSUPPLIER) = TRIM('$sing')")
//                ->get();

            $datas = DB::connection($_SESSION['connection'])
                ->select("select byr_prdcd, prd_deskripsipanjang, byr_qtymaxvoucher
from TBTABEL_PEMBAYARANVOUCHER LEFT JOIN TBMASTER_PRODMAST ON trim(PRD_PRDCD) = trim(BYR_PRDCD)
WHERE BYR_KODEIGR = '$kodeigr' AND BYR_KODESUPPLIER = '$supp'
AND TRIM(BYR_SINGKATANSUPPLIER) = TRIM('$sing')");
            DB::connection($_SESSION['connection'])->commit();

            return response()->json($datas);
        }catch(QueryException $e){
            DB::connection($_SESSION['connection'])->rollBack();

            $status = 'error';
            $message = $e->getMessage();

            return compact(['status' => $status,'message' => $message]);
        }

    }

    public function Save(Request $request){
        try{
            DB::connection($_SESSION['connection'])->beginTransaction();
            $kodeigr = $_SESSION['kdigr'];
            $datas  = $request->datas;
            $supp = $request->supp;
            $sing = $request->sing;
//            $dateA = $request->date1;
//            $dateB = $request->date2;
//            $sDate = DateTime::createFromFormat('d-m-Y', $dateA)->format('d-m-Y');
//            $eDate = DateTime::createFromFormat('d-m-Y', $dateB)->format('d-m-Y');
            for($i=1;$i<sizeof($datas);$i++){
                $tempPlu = $datas[$i]['plu'];
                if($datas[$i]['status'] == 2){
                    DB::connection($_SESSION['connection'])->table("TBTABEL_PEMBAYARANVOUCHER")
                        ->where("BYR_KODEIGR",'=',$kodeigr)
                        ->where("BYR_KODESUPPLIER",'=',$supp)
                        ->whereRaw("TRIM(BYR_PRDCD) = TRIM('$tempPlu')")
                        ->whereRaw("TRIM(BYR_SINGKATANSUPPLIER) = TRIM('$sing')")
                        ->update([
                            "BYR_RECORDID" => null,
                            "BYR_QTYMAXVOUCHER" => $datas[$i]['voucher']
                        ]);
                }else{
                    DB::connection($_SESSION['connection'])->table("TBTABEL_PEMBAYARANVOUCHER")
                        ->where("BYR_KODEIGR",'=',$kodeigr)
                        ->where("BYR_KODESUPPLIER",'=',$supp)
                        ->whereRaw("TRIM(BYR_PRDCD) = TRIM('$tempPlu')")
                        ->whereRaw("TRIM(BYR_SINGKATANSUPPLIER) = TRIM('$sing')")
                        ->delete();
                }
            }
            DB::connection($_SESSION['connection'])->commit();
        }catch(QueryException $e){
            DB::connection($_SESSION['connection'])->rollBack();
            $status = 'error';
            $message = $e->getMessage();

            return compact(['status' => $status,'message' => $message]);
        }


    }
    public function Delete(Request $request){
        try{
            DB::connection($_SESSION['connection'])->beginTransaction();
            $kodeigr = $_SESSION['kdigr'];
            $supp = $request->supp;
            $sing = $request->sing;
            DB::connection($_SESSION['connection'])->table("TBTABEL_PEMBAYARANVOUCHER")
                ->where("BYR_KODEIGR",'=',$kodeigr)
                ->where("BYR_KODESUPPLIER",'=',$supp)
                ->whereRaw("TRIM(BYR_SINGKATANSUPPLIER) = TRIM('$sing')")
                ->delete();

            DB::connection($_SESSION['connection'])->commit();
        }catch(QueryException $e){
            DB::connection($_SESSION['connection'])->rollBack();

            $status = 'error';
            $message = $e->getMessage();

            return compact(['status' => $status,'message' => $message]);
        }


    }
}
