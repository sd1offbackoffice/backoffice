<?php

namespace App\Http\Controllers\BACKOFFICE;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class cetakPBController extends Controller
{
    public function index(){
        return view('BACKOFFICE.cetakPB');
    }

    public function getDocument(Request $request){
        $tgl1   = $request->tgl1;
        $tgl2   = $request->tgl2;

        $document = DB::table('tbtr_pb_h')->select('pbh_nopb', 'pbh_keteranganpb')
            ->whereBetween('pbh_create_dt', [$tgl1,$tgl2])
            ->orderBy('pbh_nopb')->get();

        return response()->json($document);
    }

    public function searchDocument(Request $request){
        $search = $request->search;
        $tgl1   = $request->tgl1;
        $tgl2   = $request->tgl2;

        $document = DB::table('tbtr_pb_h')->select('pbh_nopb', 'pbh_keteranganpb')
            ->where('pbh_nopb','LIKE', '%'.$search.'%')
            ->orWhere('pbh_keteranganpb','LIKE', '%'.$search.'%')
            ->whereBetween('pbh_create_dt', [$tgl1,$tgl2])
            ->orderBy('pbh_nopb')->get();

        return response()->json($document);
    }

    public function getDivisi(){
        $divisi     = DB::table('TBMASTER_DIVISI')->select('div_kodedivisi', 'div_namadivisi')->orderBy('div_kodedivisi')->limit(100)->get();

        return response()->json($divisi);
    }

    public function searchDivisi(Request $request){
        $search = $request->search;

        $divisi = DB::table('TBMASTER_DIVISI')->select('div_kodedivisi', 'div_namadivisi')
            ->where('div_kodedivisi','LIKE', '%'.$search.'%')
            ->orWhere('div_namadivisi','LIKE', '%'.$search.'%')
            ->orderBy('div_kodedivisi')
            ->get();

        return response()->json($divisi);
    }

    public function getDepartement(Request $request){
        $div1   = $request->div1;
        $div2   = $request->div2;

        $departemen = DB::table('TBMASTER_DEPARTEMENT')->select('DEP_KODEDEPARTEMENT', 'DEP_NAMADEPARTEMENT')
            ->whereBetween('dep_kodedivisi', [$div1,$div2])
            ->orderBy('DEP_KODEDEPARTEMENT')->get();

        return response()->json($departemen);
    }

    public function searchDepartement(Request $request){
        $search = $request->search;
        $div1   = $request->div1;
        $div2   = $request->div2;

        $departemen = DB::table('TBMASTER_DEPARTEMENT')->select('DEP_KODEDEPARTEMENT', 'DEP_NAMADEPARTEMENT')
            ->where('DEP_KODEDEPARTEMENT','LIKE', '%'.$search.'%')
            ->orWhere('DEP_NAMADEPARTEMENT','LIKE', '%'.$search.'%')
            ->whereBetween('dep_kodedivisi', [$div1,$div2])
            ->orderBy('DEP_KODEDEPARTEMENT')
            ->get();

        return response()->json($departemen);
    }

    public function getKategori(Request $request){
        $dep1   = $request->dept1;
        $dep2   = $request->dept2;

        $kategori = DB::table('TBMASTER_KATEGORI')->select('KAT_KODEDEPARTEMENT', 'KAT_KODEKATEGORI', 'KAT_NAMAKATEGORI')
            ->whereBetween('KAT_KODEDEPARTEMENT',[$dep1,$dep2])
            ->orderBy('KAT_KODEDEPARTEMENT')
            ->orderBy('KAT_KODEKATEGORI')
            ->get()->toArray();

        return response()->json($kategori);
    }

    public function searchKategori(Request $request){
        $dep1   = $request->dept1;
        $dep2   = $request->dept2;
        $search = strtoupper($request->search);

        $kategori = DB::table('TBMASTER_KATEGORI')->select('KAT_KODEDEPARTEMENT', 'KAT_KODEKATEGORI', 'KAT_NAMAKATEGORI')
            ->where('KAT_KODEKATEGORI','LIKE', '%'.$search.'%')
            ->orWhere('KAT_NAMAKATEGORI','LIKE', '%'.$search.'%')
            ->whereBetween('KAT_KODEDEPARTEMENT',[$dep1,$dep2])
            ->orderBy('KAT_KODEDEPARTEMENT')
            ->orderBy('KAT_KODEKATEGORI')
            ->get()->toArray();

        return response()->json($kategori);
    }
}
