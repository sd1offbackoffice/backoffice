<?php

namespace App\Http\Controllers\MASTER;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class kategoriBarangController extends Controller
{
    //

    public function index(){
        $departement = DB::table('tbmaster_departement')
            ->select('dep_kodedepartement','dep_namadepartement')
            ->orderBy('dep_kodedepartement')
            ->get();

        $kategori = DB::table('tbmaster_kategori')
            ->select('kat_kodekategori', 'kat_namakategori', 'kat_singkatan')
            ->where('kat_kodedepartement','01')
            ->orderBy('kat_kodekategori')
            ->get();

        return view('MASTER.kategoriBarang')->with(compact(['departement', 'kategori']));
    }

    public function departement_select(Request $request){
        $kategori = DB::table('tbmaster_kategori')
            ->select('kat_kodekategori', 'kat_namakategori', 'kat_singkatan')
            ->where('kat_kodedepartement',$request->value)
            ->orderBy('kat_kodekategori')
            ->get();

        return $kategori;
    }


}
