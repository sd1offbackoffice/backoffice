<?php
/**
 * Created by PhpStorm.
 * User: ryan
 * Date: 02/11/2021
 * Time: 14:08 PM
 */

namespace App\Http\Controllers\TABEL;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use PDF;
use DateTime;
use Yajra\DataTables\DataTables;

class superpromoController extends Controller
{

    public function index()
    {
        return view('TABEL\superpromo');
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

    public function print(){
        $kodeigr = $_SESSION['kdigr'];

        $datas = DB::table("TBTR_PROMOMD")
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
        $perusahaan = DB::table("tbmaster_perusahaan")->first();
        return view('TABEL\hrgpromo-pdf',['kodeigr' => $kodeigr, 'data' => $datas, 'perusahaan' => $perusahaan]);
    }
}
