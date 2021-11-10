<?php

namespace App\Http\Controllers\MASTER;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class KategoriBarangController extends Controller
{
    //

    public function index(){
        $departement = DB::connection($_SESSION['connection'])->table('tbmaster_departement')
            ->select('dep_kodedepartement','dep_namadepartement')
            ->orderBy('dep_kodedepartement')
            ->get();

        $kategori = DB::connection($_SESSION['connection'])->table('tbmaster_kategori')
            ->select('kat_kodekategori', 'kat_namakategori', 'kat_singkatan')
            ->where('kat_kodedepartement','01')
            ->orderBy('kat_kodekategori')
            ->get();

        return view('MASTER.kategori-barang')->with(compact(['departement', 'kategori']));
    }

    public function departementSelect(Request $request){
        $kategori = DB::connection($_SESSION['connection'])->table('tbmaster_kategori')
            ->select('kat_kodekategori', 'kat_namakategori', 'kat_singkatan')
            ->where('kat_kodedepartement',$request->value)
            ->orderBy('kat_kodekategori')
            ->get();

        return $kategori;
    }


}
