<?php

namespace App\Http\Controllers\BACKOFFICE;

use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;
use PDF;
use Yajra\DataTables\DataTables;

class PBGudangPusatController extends Controller
{
    public function index(){
        $cabang = DB::table('tbmaster_cabang')
            ->select('cab_kodecabang','cab_namacabang')
            ->where('cab_kodeigr','=',$_SESSION['kdigr'])
            ->where('cab_kodecabang','!=',$_SESSION['kdigr'])
            ->orderBy('cab_kodecabang')
            ->get();

        return view('BACKOFFICE.PBGUDANGPUSAT.pb-gudang-pusat');
    }

    public function getLovPrdcd(){
        $data = DB::select("select prd_deskripsipanjang desk, prd_prdcd plu, prd_unit || '/' || prd_frac konversi, prd_hrgjual from tbmaster_prodmast
            where prd_kodeigr = '".$_SESSION['kdigr']."'
            and substr(prd_Prdcd,7,1) = '0'
            order by prd_deskripsipanjang");

        return DataTables::of($data)->make(true);
    }

    public function getLovDepartement(){
        $data = DB::select("SELECT distinct dep_namadepartement, dep_kodedepartement, dep_singkatandepartement, dep_kodedivisi
                FROM TBMASTER_DEPARTEMENT
                WHERE dep_kodeigr ='".$_SESSION['kdigr']."'
                order by dep_kodedepartement");

        return DataTables::of($data)->make(true);
    }

    public function getLovKategori(Request $request){
        $data = DB::select("SELECT distinct kat_namakategori, kat_kodekategori, kat_kodedepartement
                FROM TBMASTER_KATEGORI
                WHERE kat_kodeigr ='".$_SESSION['kdigr']."'
                AND kat_kodedepartement between '".$request->dep1."' and '".$request->dep2."'
                order by kat_kodedepartement, kat_kodekategori");

        return DataTables::of($data)->make(true);
    }
}
