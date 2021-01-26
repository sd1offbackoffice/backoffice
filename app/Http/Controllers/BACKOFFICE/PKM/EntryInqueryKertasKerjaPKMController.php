<?php

namespace App\Http\Controllers\BACKOFFICE\PKM;

use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;
use PDF;
use Yajra\DataTables\DataTables;
use ZipArchive;
use File;

class EntryInqueryKertasKerjaPKMController extends Controller
{
    public function index(){
        return view('BACKOFFICE.PKM.entry-inquery');
    }

    public function getLovPrdcd(){
        $data = DB::select("select prd_deskripsipendek desk, prd_prdcd plu, prd_unit || '/' || prd_frac konversi, prd_hrgjual from tbmaster_prodmast
            where prd_kodeigr = '".$_SESSION['kdigr']."'
            and substr(prd_Prdcd,7,1) = '0'
            order by prd_deskripsipendek");

        return DataTables::of($data)->make(true);
    }

    public function getLovDivisi(){
        $data = DB::select("SELECT div_namadivisi, div_kodedivisi 
                FROM TBMASTER_DIVISI 
                WHERE div_kodeigr ='".$_SESSION['kdigr']."' 
                order by div_kodedivisi");

        return DataTables::of($data)->make(true);
    }

    public function getLovDepartement(Request $request){
        $data = DB::select("SELECT distinct dep_namadepartement, dep_kodedepartement, dep_kodedivisi 
                FROM TBMASTER_DEPARTEMENT 
                WHERE dep_kodeigr ='".$_SESSION['kdigr']."' 
                AND dep_kodedivisi = '".$request->kodedivisi."'
                order by dep_kodedepartement");

        return DataTables::of($data)->make(true);
    }

    public function getLovKategori(Request $request){
        $data = DB::select("SELECT distinct kat_namakategori, kat_kodekategori, kat_kodedepartement 
                FROM TBMASTER_KATEGORI
                WHERE kat_kodeigr ='".$_SESSION['kdigr']."'
                AND kat_kodedepartement = '".$request->kodedepartement."'
                order by kat_kodekategori");

        return DataTables::of($data)->make(true);
    }


}