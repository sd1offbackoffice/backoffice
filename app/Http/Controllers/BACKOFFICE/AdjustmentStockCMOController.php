<?php

namespace App\Http\Controllers\BACKOFFICE;

use App\Http\Controllers\Auth\loginController;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;
use PDF;
use Symfony\Component\VarDumper\Cloner\Data;
use Yajra\DataTables\DataTables;

class AdjustmentStockCMOController extends Controller
{
    public function index(){
        return view('BACKOFFICE.adjustment-stock-cmo');
    }

    public function getDataLovBA(){
        $data = DB::connection(Session::get('connection'))
            ->table('tbtr_ba_cmo')
            ->selectRaw("bac_noba noba, bac_tglba, to_char(bac_tglba,'dd/mm/yyyy') tglba,
                to_char(bac_tgladj, 'dd/mm/yyyy') tgladj, bac_modify_by useradj")
            ->whereRaw("nvl(bac_recordid,'0') <> '1'")
            ->orderBy('bac_tglba','desc')
            ->orderBy('bac_noba','desc')
            ->distinct()
            ->get();

        return DataTables::of($data)->make(true);
    }

    public function getDataLovPLU(){
        $data = DB::connection(Session::get('connection'))
            ->select(" select distinct icm_pluigr, prc_pluidm, prd_deskripsipanjang , prd_unit || '-' || prd_frac unit
                 from tbmaster_item_cmo, tbmaster_prodcrm, tbmaster_prodmast
                 where prc_pluigr = icm_pluigr and prc_group = 'I' and prd_prdcd = icm_pluigr
                 order by icm_pluigr");

        return DataTables::of($data)->make(true);
    }

    public function checkPLU(Request $request){
        $plu = substr('0000000'.$request->plu,-7);

        if(substr($plu,-1) != '0')
            $plu = substr($plu,0,6).'0';

        $temp = DB::connection(Session::get('connection'))
            ->table('tbmaster_item_cmo')
            ->where('icm_pluigr','=',$plu)
            ->first();

        if(!$temp){
            return response()->json([
                'message' => 'Data Item CMO tidak ada!'
            ], 500);
        }

        $temp = DB::connection(Session::get('connection'))
            ->table('tbmaster_prodmast')
            ->where('prd_prdcd','=',$plu)
            ->first();

        if(!$temp){
            return response()->json([
                'message' => 'Data Master Produk CMO tidak ada!'
            ], 500);
        }
        else{
            $desk = $temp->prd_deskripsipanjang;
            $unit = $temp->prd_unit .'-'. $temp->prd_frac;
        }

        $temp = DB::connection(Session::get('connection'))
            ->table('tbmaster_prodcrm')
            ->where('prc_pluigr','=',$plu)
            ->where('prc_group','=','I')
            ->first();

        if(!$temp){
            return response()->json([
                'message' => 'Data Master Produk 2 CMO tidak ada!'
            ], 500);
        }
        else $pluidm = $temp->prc_pluidm;

        $temp = DB::connection(Session::get('connection'))
            ->table('tbmaster_stock_cab_anak')
            ->where('sta_lokasi','=','01')
            ->where('sta_prdcd','=',$plu)
            ->first();

        if(!$temp){
            return response()->json([
                'message' => 'Data Transaksi Stock CMO tidak ada!'
            ], 500);
        }
        else $qty = $temp->sta_saldoakhir;

        return response()->json(compact(['plu','desk','unit','pluidm','qty']),200);
    }

    public function getDataBA(Request $request){
        $data = DB::connection(Session::get('connection'))
            ->table('tbtr_ba_cmo')
            ->where('bac_noba','=',$request->noba)
            ->whereRaw("nvl(bac_recordid,'0') <> '1'")
            ->first();

        $data = DB::connection(Session::get('connection'))
            ->select("SELECT bac_recordid,
                         bac_prdcd,
                         prc_pluidm,
                         bac_keterangan,
                         prd_deskripsipanjang,
                         prd_unit || '-' || prd_frac unit,
                         bac_qty_stock,
                         bac_qty_ba,
                         bac_qty_adj
                    FROM tbtr_ba_cmo, tbmaster_prodmast, tbmaster_prodcrm
                   WHERE     bac_noba = '".$request->noba."'
                         AND NVL (bac_recordid, '0') <> '1'
                         AND prd_prdcd = bac_prdcd
                         AND prc_pluigr = prd_prdcd and prc_group = 'I'
                ORDER BY bac_prdcd");

        if(count($data) == 0){
            return response()->json([
                'message' => 'Data BA CMO tidak ada!'
            ], 500);
        }
        else return response()->json($data, 200);
    }
}
