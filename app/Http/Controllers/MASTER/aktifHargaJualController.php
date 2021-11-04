<?php

namespace App\Http\Controllers\MASTER;

use App\AllModel;
use App\Http\Controllers\Auth\loginController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class aktifHargaJualController extends Controller
{
    public function index(){
        return view('MASTER.aktifHargaJual');
    }

    public function getProdmast(Request  $request){
        $search = $request->value;

        $prodmast   = DB::table('tbmaster_prodmast')->select('prd_prdcd', 'PRD_DESKRIPSIPANJANG')
            ->where('prd_prdcd','LIKE', '%'.$search.'%')
            ->orWhere('prd_deskripsipanjang','LIKE', '%'.$search.'%')
            ->orderBy('prd_prdcd')
            ->limit(100)->get();

        return Datatables::of($prodmast)->make(true);
    }

    public function getDetailPlu(Request $request){
        sleep(1);
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
        sleep(1);
        $plu    = $request->plu;
        $user   = $_SESSION['usid'];
        $model  = new AllModel();
        $getData= $model->getKodeigr();
        $kodeigr = $_SESSION['kdigr'];
//        $jenistimbangan = 1;
        $jenistimbangan = $getData[0]->prs_jenistimbangan;
        $errm  = '';


        $connection = loginController::getConnectionProcedure();

        $exec = oci_parse($connection, "BEGIN  sp_aktifkan_harga_peritem(:kodeigr,:prdcd,:jtim,:user,:errm); END;");
//        $exec = oci_parse($connection, "BEGIN  sp_transferfile_tokoigr(:kodeigr,:prdcd,:jtim,:user,:errm); END;");
        oci_bind_by_name($exec, ':kodeigr',$kodeigr,100);
        oci_bind_by_name($exec, ':prdcd',$plu,100);
        oci_bind_by_name($exec, ':jtim',$jenistimbangan,100);
        oci_bind_by_name($exec, ':user',$user,100);
        oci_bind_by_name($exec, ':errm', $errm,1000);
        oci_execute($exec);

        return response()->json($errm);
    }

}
