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
        $user   = 'JEP';
        date_default_timezone_set('Asia/Jakarta');
        $date   = date('Y-m-d H:i:s');
        $model  = new AllModel();
        $getData= $model->getKodeigr();
        $kodeigr = $getData[0]->prs_kodeigr;
        $jenistimbangan = $getData[0]->prs_jenistimbangan;
        $errm  = '';
        $connection = oci_connect('simsmg', 'simsmg','(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST=192.168.237.193)(PORT=1521)) (CONNECT_DATA=(SERVER=DEDICATED) (SERVICE_NAME = simsmg)))');

        $getHarga   = DB::table('tbmaster_prodmast')->select('prd_hrgjual', 'prd_tglhrgjual', 'prd_hrgjual3', 'prd_tglhrgjual3')->where('prd_prdcd', $plu)->get()->toArray();

//        DB::raw(DB::statement ("call sp_aktifkan_harga_peritem(?)", array($kodeigr)));

        $exec = oci_parse($connection, "BEGIN  sp_aktifkan_harga_peritem(:kodeigr,:prdcd,:jtim,:user,:errm); END;");
        oci_bind_by_name($exec, ':kodeigr',$kodeigr,100);
        oci_bind_by_name($exec, ':prdcd',$plu,100);
        oci_bind_by_name($exec, ':jtim',$jenistimbangan,100);
        oci_bind_by_name($exec, ':user',$user,100);
        oci_bind_by_name($exec, ':errm', $errm,1000);
        oci_execute($exec);


//        DB::table('tbmaster_prodmast')->where('prd_prdcd', $plu)->update(['prd_hrgjual2' => $getHarga[0]->prd_hrgjual, 'prd_hrgjual' => $getHarga[0]->prd_hrgjual3, 'prd_tglhrgjual2' => $getHarga[0]->prd_tglhrgjual, 'prd_tglhrgjual' => $getHarga[0]->prd_tglhrgjual3 ,
//            'prd_modify_by' => $user, 'prd_modify_dt' => $date]);
//
//        DB::table('TBTR_UPDATE_PLU_MD')->insert(['UPD_KODEIGR' => $kodeigr, 'UPD_PRDCD' => $plu, 'UPD_HARGA' => $getHarga[0]->prd_hrgjual3, 'UPD_CREATE_BY' => $user, 'UPD_CREATE_DT' => $date]);
//
//        $hargaJual  = DB::table('TBMASTER_HARGAJUAL')
//            ->where('HGJ_PRDCD', $plu)
//            ->where('HGJ_KODEIGR', $kodeigr)
//            ->orderBy('HGJ_PRDCD')
//            ->orderBy('HGJ_TGLBERLAKU')
//            ->get()->toArray();
//
//        if ($hargaJual == null){
//            DB::table('tbmaster_prodmast')->where('prd_prdcd', $plu)->update(['prd_hrgjual3' => '0', 'prd_tglhrgjual3' => '', 'prd_modify_by' => $user, 'prd_modify_dt' => $date]);
//        } else {
//            dd('asd');
//        }

        $msg = "Data Berhasil Di Aktifkan";

        return response()->json($errm);
    }

}
