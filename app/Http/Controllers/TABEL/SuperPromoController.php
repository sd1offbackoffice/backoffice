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
use App\Http\Controllers\Controller; use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use PDF;
use DateTime;
use Yajra\DataTables\DataTables;

class SuperPromoController extends Controller
{

    public function index()
    {
        return view('TABEL.super-promo');
    }


    public function ModalPlu(Request $request){
        $kodeigr = Session::get('kdigr');
        $search = $request->value;

        $datas = DB::connection(Session::get('connection'))->table("TBMASTER_PRODMAST")
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


    public function checkPlu(Request $request){
        $kodeigr = Session::get('kdigr');
        $kode = $request->kode;
        $notif = '';
        $deskripsi = '';
        $unit = '';

        $datas = DB::connection(Session::get('connection'))->select("SELECT prd_prdcd
          FROM TBMASTER_PRODMAST, TBMASTER_BARCODE
         WHERE prd_kodeigr = '$kodeigr'
           AND prd_prdcd = brc_prdcd(+)
           AND (prd_prdcd = TRIM ('$kode') OR brc_barcode = TRIM ('kode'))");
        if($datas){
            $temp = DB::connection(Session::get('connection'))->table("TBMASTER_PRODMAST")
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
        $kodeigr = Session::get('kdigr');
        $datas  = $request->datas;
        $dateA = $request->date1;
        $dateB = $request->date2;
        $sDate = DateTime::createFromFormat('d-m-Y', $dateA)->format('d-m-Y');
        $eDate = DateTime::createFromFormat('d-m-Y', $dateB)->format('d-m-Y');
        $insert = [];
        DB::connection(Session::get('connection'))->beginTransaction();
        DB::connection(Session::get('connection'))->table("tbtr_hadiahkejutan")
            ->where('spot_periodeawal',DB::connection(Session::get('connection'))->raw("TO_DATE('$sDate','DD-MM-YYYY')"))
            ->where('spot_periodeakhir',DB::connection(Session::get('connection'))->raw("TO_DATE('$eDate','DD-MM-YYYY')"))
            ->delete();
        for($i=0;$i<sizeof($datas);$i++){
            if($datas[$i]['plu']!='') {
                DB::connection(Session::get('connection'))->table("tbtr_hadiahkejutan")
                    ->insert(
                        [
                            'spot_kodeigr' => $kodeigr,
                            'spot_periodeawal' => DB::connection(Session::get('connection'))->raw("TO_DATE('$sDate','DD-MM-YYYY')"),
                            'spot_periodeakhir' => DB::connection(Session::get('connection'))->raw("TO_DATE('$eDate','DD-MM-YYYY')"),
                            'spot_prdcd' => $datas[$i]['plu'],
                            'spot_fmtrgq' => $datas[$i]['qty'],
                            'spot_fmtrgs' => $datas[$i]['sales'],
                            'spot_fmtrgg' => $datas[$i]['margin'],
                            'spot_hrgjual' => $datas[$i]['hrg'],
                            'spot_create_by' => Session::get('usid'),
                            'spot_create_dt' => DB::connection(Session::get('connection'))->raw("trunc(SYSDATE)"),
                            'spot_modify_by' => '',
                            'spot_modify_dt' => '',
                        ]
                    );
            }
        }

        DB::connection(Session::get('connection'))->commit();

    }

    public function getTable(Request $request){
        $kodeigr = Session::get('kdigr');
        $dateA = $request->date1;
        $dateB = $request->date2;
        $sDate = DateTime::createFromFormat('d-m-Y', $dateA)->format('d-m-Y');
        $eDate = DateTime::createFromFormat('d-m-Y', $dateB)->format('d-m-Y');

        $datas = DB::connection(Session::get('connection'))->table("tbtr_hadiahkejutan")
            ->selectRaw("SPOT_PRDCD")
            ->selectRaw("SPOT_HRGJUAL")
            ->selectRaw("SPOT_FMTRGQ AS QTY")
            ->selectRaw("SPOT_FMTRGS AS TARGET_SALES")
            ->selectRaw("SPOT_FMTRGG AS TARGET_GROSS_MARGIN")
            ->whereRaw("trunc(spot_periodeawal) = TO_DATE('$sDate','DD-MM-YYYY')")
            ->whereRaw("trunc(spot_periodeakhir) = TO_DATE('$eDate','DD-MM-YYYY')")
            ->get();

        return response()->json($datas);
    }
}
