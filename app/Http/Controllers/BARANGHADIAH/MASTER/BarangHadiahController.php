<?php

namespace App\Http\Controllers\BARANGHADIAH\MASTER;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;

class BarangHadiahController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('BARANGHADIAH.MASTER.barang-hadiah');
    }

    public function getProduk()
    {
        $datas = DB::connection(Session::get('connection'))
        ->select("SELECT  
            PRD_PRDCD, 
            PRD_DESKRIPSIPENDEK, 
            PRD_UNIT, 
            PRD_FRAC
        FROM TBMASTER_PRODMAST
        WHERE PRD_KODEIGR = :parameter.kodeigr
        AND SUBSTR(PRD_PRDCD,7,1) = '0'
        ORDER BY PRD_PRDCD");

        return Datatables::of($datas)->make(true);
    }

   public function getDataProduk(Request $request)
   {
        $value = $request->bprp_prdcd;
        // $checkString = strpos($value, 'H');

        // dd($checkString);
        // if($checkString == 'false')
        // {
        //     if(Str::length($value) < 7)
        //     {

        //     }
        // }

        $datas = DB::connection(Session::get('connection'))->table('TBMASTER_BRGPROMOSI')
            ->selectRaw("bprp_prdcd,bprp_ketpendek,bprp_frackonversi,bprp_unit")
            ->where('bprp_prdcd',$value)
            ->orderBy('bprp_prdcd')
            ->limit(100)
            ->get();

        // DD($datas);

        return compact(['datas']);
   }

   public function getCardProduk()
    {
       
        $datas = DB::connection(Session::get('connection'))->table('TBMASTER_BRGPROMOSI')
        ->selectRaw("bprp_recordid,bprp_prdcd,bprp_ketpendek,bprp_frackonversi,bprp_unit")
        ->orderBy('bprp_prdcd')
        ->limit(100)
        ->get();

        return Datatables::of($datas)->make(true);
    }
}
