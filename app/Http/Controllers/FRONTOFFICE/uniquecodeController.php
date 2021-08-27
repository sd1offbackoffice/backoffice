<?php
/**
 * Created by PhpStorm.
 * User: ryan
 * Date: 23/08/2021
 * Time: 2:15 PM
 */

namespace App\Http\Controllers\FRONTOFFICE;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use PDF;
use DateTime;
use Yajra\DataTables\DataTables;

class uniquecodeController extends Controller
{

    public function index()
    {
        return view('FRONTOFFICE.uniquecode');
    }

    public function getCashBack(){
        $datas = DB::table('tbtr_cashback_hdr')
            ->selectRaw('cbh_kodepromosi')
            ->selectRaw('cbh_namapromosi')
            ->selectRaw("TO_CHAR(TRUNC(cbh_tglawal), 'dd-mm-yyyy') as cbh_tglawal")
            ->selectRaw("TO_CHAR(TRUNC(cbh_tglakhir), 'dd-mm-yyyy') as cbh_tglakhir")

            ->whereRaw("nvl(cbh_kiosk, 'N') = 'Y'")
            ->get()->toArray();

        return Datatables::of($datas)->make(true);
    }

    public function getGift(){
        $datas = DB::table('tbtr_gift_hdr')
            ->selectRaw('gfh_kodepromosi')
            ->selectRaw('gfh_namapromosi')
            ->selectRaw("TO_CHAR(TRUNC(gfh_tglawal), 'dd-mm-yyyy') as gfh_tglawal")
            ->selectRaw("TO_CHAR(TRUNC(gfh_tglakhir), 'dd-mm-yyyy') as gfh_tglakhir")

            ->whereRaw("nvl(gfh_kiosk, 'N') = 'Y'")
            ->get()->toArray();

        return Datatables::of($datas)->make(true);
    }

    public function getPembanding(){
        $kodeigr = $_SESSION['kdigr'];

        $datas = DB::table('tbmaster_prodmast')
            ->selectRaw('prd_deskripsipendek')
            ->selectRaw('prd_prdcd')

            ->where("prd_kodeigr",'=',$kodeigr)
            ->where("prd_prdcd",'LIKE',"%0")

            ->orderBy("prd_prdcd")
            ->get()->toArray();

        return Datatables::of($datas)->make(true);
    }
}
