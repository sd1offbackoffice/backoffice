<?php

namespace App\Http\Controllers\BARANGHADIAH\MASTER;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

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
        $datas = DB::connection(Session::get('connection'))->table('TBMASTER_BRGPROMOSI')
        ->selectRaw("bprp_prdcd,bprp_ketpendek,bprp_frackonversi,bprp_unit")
        ->orderBy('bprp_prdcd')
        ->limit(100)
        ->get();

        return Datatables::of($datas)->make(true);
    }

   public function getDataProduk(Request $request)
   {
        $value = $request->bprp_prdcd;

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
