<?php

namespace App\Http\Controllers\BACKOFFICE\LAPORAN;

use App\Http\Controllers\Auth\loginController;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller; use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Mockery\Exception;
use PDF;
use Yajra\DataTables\DataTables;

class LaporanHistoryHargaController extends Controller
{
    public function index(){
        return view('BACKOFFICE.LAPORAN.laporan-history-harga');
    }

    public function getLovPLU(Request $request){
        $search = $request->plu;

        if($search == ''){
            $produk = DB::connection(Session::get('connection'))->table('tbmaster_prodmast')
                ->selectRaw("prd_prdcd,prd_deskripsipanjang, prd_unit || '/' || prd_frac satuan")
                ->where('prd_kodeigr',Session::get('kdigr'))
                ->whereRaw("substr(prd_prdcd,-1) = '0'")
                ->orderBy('prd_prdcd')
                ->limit(100)
                ->get();
        }
        else if(is_numeric($search)){
            $produk = DB::connection(Session::get('connection'))->table('tbmaster_prodmast')
                ->selectRaw("prd_prdcd,prd_deskripsipanjang, prd_unit || '/' || prd_frac satuan")
                ->where('prd_kodeigr',Session::get('kdigr'))
                ->where('prd_prdcd','like',DB::connection(Session::get('connection'))->raw("'%".$search."%'"))
                ->whereRaw("substr(prd_prdcd,-1) = '0'")
                ->orderBy('prd_prdcd')
                ->get();
        }
        else{
            $produk = DB::connection(Session::get('connection'))->table('tbmaster_prodmast')
                ->selectRaw("prd_prdcd,prd_deskripsipanjang, prd_unit || '/' || prd_frac satuan")
                ->where('prd_kodeigr',Session::get('kdigr'))
                ->where('prd_deskripsipanjang','like',DB::connection(Session::get('connection'))->raw("'%".$search."%'"))
                ->whereRaw("substr(prd_prdcd,-1) = '0'")
                ->orderBy('prd_prdcd')
                ->get();
        }

        return DataTables::of($produk)->make(true);
    }

    public function getDataPLU(Request $request){
        $data = DB::connection(Session::get('connection'))->table('tbmaster_prodmast')
            ->selectRaw("prd_prdcd,prd_deskripsipanjang")
            ->where('prd_kodeigr',Session::get('kdigr'))
            ->where('prd_prdcd','=',$request->plu)
            ->whereRaw("substr(prd_prdcd,-1) = '0'")
            ->first();

        if(!$data){
            return response()->json([
                'message' => 'PLU '.$request->plu.' tidak ditemukan!'
            ], 500);
        }
        else return response()->json($data);
    }

    public function print(Request $request){
        $tgl1 = $request->tgl1;
        $tgl2 = $request->tgl2;
        $plu1 = $request->plu1;
        $plu2 = $request->plu2;

        $perusahaan = DB::connection(Session::get('connection'))
            ->table('tbmaster_perusahaan')
            ->first();

        $data = DB::connection(Session::get('connection'))
            ->select("select hcs_prdcd, prd_deskripsipanjang, to_char(hcs_tglbpb, 'dd/mm/yyyy') hcs_tglbpb,
                hcs_nodocbpb, hcs_avglama, hcs_avgbaru, hcs_lastqty,
                 hcs_lastcostlama,hcs_lastcostbaru,
                 to_char(nvl(hcs_modify_dt, hcs_create_dt),'dd/mm/yyyy') tgl_upd,
                 to_char(nvl(hcs_modify_dt, hcs_create_dt),'hh24:mi:ss') jam_upd,
                 nvl(hcs_modify_by,hcs_create_by) usr
            from tbhistory_cost, tbmaster_prodmast
            where hcs_tglbpb between to_date('".$tgl1."','dd/mm/yyyy') and to_date('".$tgl2."','dd/mm/yyyy')
            and hcs_prdcd between '".$plu1."' and '".$plu2."'
            and prd_prdcd=hcs_prdcd
            and prd_kodeigr=hcs_kodeigr
            and hcs_kodeigr='".Session::get('kdigr')."'
            order by hcs_prdcd,hcs_tglbpb,hcs_nodocbpb");

        return view('BACKOFFICE.LAPORAN.laporan-history-harga-pdf',compact(['perusahaan','data','plu1','plu2','tgl1','tgl2']));
    }
}
