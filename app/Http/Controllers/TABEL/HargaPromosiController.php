<?php
/**
 * Created by PhpStorm.
 * User: ryan
 * Date: 01/11/2021
 * Time: 10:26 AM
 */

namespace App\Http\Controllers\TABEL;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use PDF;
use DateTime;
use Yajra\DataTables\DataTables;

class HargaPromosiController extends Controller
{

    public function index()
    {
        return view('TABEL.harga-promosi');
    }

    public function ModalMain(){
        $kodeigr = $_SESSION['kdigr'];

        $datas = DB::connection($_SESSION['connection'])->table("TBTR_PROMOMD")
            ->selectRaw("PRMD_PRDCD")
            ->selectRaw("PRMD_JENISDISC")
//            ->selectRaw("PRMD_TGLAWAL")
//            ->selectRaw("PRMD_TGLAKHIR")
            ->selectRaw("TO_CHAR(PRMD_TGLAWAL, 'DD/MM/YYYY') as PRMD_TGLAWAL")
            ->selectRaw("TO_CHAR(PRMD_TGLAKHIR, 'DD/MM/YYYY') as PRMD_TGLAKHIR")
            ->selectRaw("PRMD_HRGJUAL")
            ->selectRaw("PRMD_POTONGANPERSEN")
            ->selectRaw("PRMD_POTONGANRPH")
            ->selectRaw("PRD_DESKRIPSIPANJANG")
            ->leftJoin("TBMASTER_PRODMAST",'PRD_PRDCD','PRMD_PRDCD')
            ->where("PRMD_KODEIGR",'=',$kodeigr)
            ->orderBy("PRMD_PRDCD")
            ->get();

        return Datatables::of($datas)->make(true);
    }

    public function ModalPlu(Request $request){
        $kodeigr = $_SESSION['kdigr'];
        $search = $request->value;

        $datas = DB::connection($_SESSION['connection'])->table("TBMASTER_PRODMAST")
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
        $promo = '';

        $barang = DB::connection($_SESSION['connection'])->table("TBMASTER_PRODMAST")
            ->selectRaw("PRD_DESKRIPSIPANJANG as deskripsi")
            ->selectRaw("PRD_UNIT || '/' || PRD_FRAC as unit")
            ->where("PRD_KODEIGR",'=',$kodeigr)
            ->where("PRD_PRDCD",'=',$kode)
            ->first();
        if($barang){
            $temp = DB::connection($_SESSION['connection'])->table("TBTR_PROMOMD")
                ->selectRaw("NVL(COUNT(1),0) as result")
                ->where("PRMD_KODEIGR",'=',$kodeigr)
                ->where("PRMD_PRDCD",'=',$kode)
                ->first();
            if($temp->result != '0'){
                $promo = DB::connection($_SESSION['connection'])->table("TBTR_PROMOMD")
                    ->selectRaw("PRMD_JENISDISC")
                    ->selectRaw("PRMD_TGLAWAL")
                    ->selectRaw("PRMD_TGLAKHIR")
                    ->selectRaw("PRMD_HRGJUAL")
                    ->selectRaw("PRMD_POTONGANPERSEN")
                    ->selectRaw("PRMD_POTONGANRPH")
                    ->where("PRMD_KODEIGR",'=',$kodeigr)
                    ->where("PRMD_PRDCD",'=',$kode)
                    ->first();
            }
        }else{
            $notif = "Kode PLU ".$kode." - ".$kodeigr." Tidak Terdaftar di Master Barang  !!";
        }
        return response()->json(['notif' => $notif, 'barang'=>$barang, 'promo'=>$promo]);
    }

    public function print(){
        $kodeigr = $_SESSION['kdigr'];

        $datas = DB::connection($_SESSION['connection'])->table("TBTR_PROMOMD")
            ->selectRaw("PRMD_PRDCD")
            ->selectRaw("PRMD_JENISDISC")
            ->selectRaw("TO_CHAR(PRMD_TGLAWAL, 'DD/MM/YYYY') as PRMD_TGLAWAL")
            ->selectRaw("TO_CHAR(PRMD_TGLAKHIR, 'DD/MM/YYYY') as PRMD_TGLAKHIR")
            ->selectRaw("PRMD_HRGJUAL")
            ->selectRaw("PRMD_POTONGANPERSEN")
            ->selectRaw("PRMD_POTONGANRPH")

            ->selectRaw("PRD_DESKRIPSIPANJANG")
            ->selectRaw("PRD_UNIT || '/' || PRD_FRAC UNIT")

            ->LeftJoin('TBMASTER_PRODMAST',function($join){
                $join->on('PRD_KODEIGR','PRMD_KODEIGR');
                $join->on('PRD_PRDCD','PRMD_PRDCD');
            })
            ->orderBy("PRMD_PRDCD")
            ->get();
        //PRINT
        $perusahaan = DB::connection($_SESSION['connection'])->table("tbmaster_perusahaan")->first();
        return view('TABEL.harga-promosi-pdf',['kodeigr' => $kodeigr, 'data' => $datas, 'perusahaan' => $perusahaan]);
    }
}
