<?php

namespace App\Http\Controllers\MASTER;

use App\AllModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class aktifHargaJualController extends Controller
{
    public function index(){
        $prodmast   = DB::table('tbmaster_prodmast')->select('prd_prdcd', 'PRD_DESKRIPSIPANJANG')->orderBy('prd_prdcd')->limit(100)->get()->toArray();

        return view('MASTER.aktifHargaJual', compact('prodmast'));
    }

    public function getProdmast(Request $request){
        $search     = strtoupper($request->search);
        $prodmast   = DB::table('tbmaster_prodmast')->select('prd_prdcd', 'PRD_DESKRIPSIPANJANG')
            ->where('prd_deskripsipanjang','LIKE', '%'.$search.'%')
            ->orWhere('prd_prdcd','LIKE', '%'.$search.'%')
            ->orderBy('prd_prdcd')
            ->get()->toArray();

        return response()->json($prodmast);
    }

    public function getDetailPlu(Request $request){
        $plu    = $request->plu;

        $prod   = DB::table('tbmaster_prodmast a')
            ->select('a.PRD_PRDCD', 'a.PRD_KODEDIVISI', 'a.PRD_KODEDEPARTEMENT', 'a.PRD_KODEKATEGORIBARANG', 'a.PRD_DESKRIPSIPANJANG',
                'a.PRD_TglHrgJual3', 'a.PRD_HRGJUAL', 'a.PRD_HRGJUAL3', 'b.div_namadivisi', 'c.dep_namadepartement', 'd.kat_namakategori')
            ->leftJoin('tbmaster_divisi b', 'a.prd_kodedivisi', 'b.div_kodedivisi')
            ->leftJoin('tbmaster_departement c', 'a.prd_kodedepartement', 'c.dep_kodedepartement')
            ->leftJoin('tbmaster_kategori d', function ($join){
                $join->on('a.prd_kodekategoribarang', '=', 'd.kat_kodekategori');
                $join->on('a.PRD_KODEDEPARTEMENT', '=', 'd.kat_kodedepartement');
            })
            ->where('a.PRD_PRDCD', $plu)
            ->get()->toArray();

        return response()->json($prod);
    }

    public function aktifkanHarga(Request $request){
        $plu    = $request->plu;
        $user   = $_SESSION['usid'];
        $model  = new AllModel();
        $getData= $model->getKodeigr();
        $kodeigr = $_SESSION['kdigr'];
//        $jenistimbangan = 1;
        $jenistimbangan = $getData[0]->prs_jenistimbangan;
        $errm  = '';
        $connection = oci_connect('simsmg', 'simsmg','(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST=192.168.237.193)(PORT=1521)) (CONNECT_DATA=(SERVER=DEDICATED) (SERVICE_NAME = simsmg)))');

        $exec = oci_parse($connection, "BEGIN  sp_aktifkan_harga_peritem(:kodeigr,:prdcd,:jtim,:user,:errm); END;");
        oci_bind_by_name($exec, ':kodeigr',$kodeigr,100);
        oci_bind_by_name($exec, ':prdcd',$plu,100);
        oci_bind_by_name($exec, ':jtim',$jenistimbangan,100);
        oci_bind_by_name($exec, ':user',$user,100);
        oci_bind_by_name($exec, ':errm', $errm,1000);
        oci_execute($exec);

        return response()->json($errm);
    }

}
