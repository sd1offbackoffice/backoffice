<?php

namespace App\Http\Controllers\BACKOFFICE;

use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller; use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;
use PDF;
use Yajra\DataTables\DataTables;

class PBGudangPusatController extends Controller
{
    public function index(){
        $cabang = DB::connection(Session::get('connection'))->table('tbmaster_cabang')
            ->select('cab_kodecabang','cab_namacabang')
            ->where('cab_kodeigr','=',Session::get('kdigr'))
            ->where('cab_kodecabang','!=',Session::get('kdigr'))
            ->orderBy('cab_kodecabang')
            ->get();

        return view('BACKOFFICE.PBGUDANGPUSAT.pb-gudang-pusat');
    }

    public function getLovDepartement(){
        $data = DB::connection(Session::get('connection'))->select("SELECT distinct dep_namadepartement, dep_kodedepartement, dep_singkatandepartement, dep_kodedivisi
                FROM TBMASTER_DEPARTEMENT
                WHERE dep_kodeigr ='".Session::get('kdigr')."'
                order by dep_kodedepartement");

        return DataTables::of($data)->make(true);
    }

    public function getLovKategori(Request $request){
        $data = DB::connection(Session::get('connection'))->select("SELECT distinct kat_namakategori, kat_kodekategori, kat_kodedepartement
                FROM TBMASTER_KATEGORI
                WHERE kat_kodeigr ='".Session::get('kdigr')."'
                AND kat_kodedepartement between '".$request->dep1."' and '".$request->dep2."'
                order by kat_kodedepartement, kat_kodekategori");

        return DataTables::of($data)->make(true);
    }

    public function getLovPrdcd(Request $request){
        $data = DB::connection(Session::get('connection'))->select("select prd_deskripsipanjang desk, prd_prdcd plu, prd_unit || '/' || prd_frac konversi, prd_hrgjual from tbmaster_prodmast
            where prd_kodeigr = '".Session::get('kdigr')."'
            and prd_kodedepartement between '".$request->dep1."' and '".$request->dep2."'
            and prd_kodekategoribarang between '".$request->kat1."' and '".$request->kat2."'
            and substr(prd_Prdcd,7,1) = '0'
            order by prd_deskripsipanjang");

        return DataTables::of($data)->make(true);
    }

    public function proses(Request $request){
        $dep1 = $request->dep1;
        $dep2 = $request->dep2;
        $kat1 = $request->kat1;
        $kat2 = $request->kat2;
        $plu1 = $request->prdcd1;
        $plu2 = $request->prdcd2;

        $p_nodok = '';

        try{
//            DB::connection(Session::get('connection'))->table('tbtr_pbgdps_ok')
//                ->where('kodeigr','=',Session::get('kdigr'))
//                ->delete();

            $recs = DB::connection(Session::get('connection'))->select("SELECT * FROM TBMASTER_PRODMAST WHERE PRD_KODEIGR = '".Session::get('kdigr')."' AND PRD_KODEDEPARTEMENT || PRD_KODEKATEGORIBARANG BETWEEN '".$dep1."' || '".$kat1."' AND '".$dep2."' || '".$kat2."' AND PRD_PRDCD BETWEEN NVL('".$plu1."',' ') AND '".$plu2."' AND NVL(PRD_FLAGGUDANG,' ') = 'Y' AND SUBSTR(PRD_PRDCD,7,1) = '0'");

            foreach($recs as $rec){
                if($p_nodok == ''){
                    $c = loginController::getConnectionProcedure();
                    $s = oci_parse($c, "BEGIN :ret := F_IGR_GET_NOMOR('".Session::get('kdigr')."','PB','Nomor Permintaan Barang','PB' || ".Session::get('kdigr')." || TO_CHAR(SYSDATE, 'yy'),3,FALSE); END;");
                    oci_bind_by_name($s, ':ret', $r, 32);
                    oci_execute($s);

                    $p_nodok = $r;
                }

                $ksupco = DB::connection(Session::get('connection'))->select("SELECT HGB_KODESUPPLIER FROM TBMASTER_HARGABELI
                WHERE (NVL(HGB_TIPE,' ') = '2' AND HGB_PRDCD = SUBSTR('".$rec->prd_prdcd."',1,6) || '0')
                OR NVL(HGB_RECORDID,' ') = ' '");

                dd($ksupco);
            }
        }
        catch (QueryException $e){

        }
    }
}
