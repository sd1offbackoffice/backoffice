<?php

namespace App\Http\Controllers\BACKOFFICE\TRANSAKSI\PEMUSNAHAN;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class inqueryBAPBController extends Controller
{
    public function index(){
        $noDoc = DB::table('tbtr_mstran_d')->whereNull(['mstd_recordid'])->whereRaw("mstd_nodoc like '8%'")->orderByDesc('mstd_nodoc')->distinct()->limit(100)->get(['mstd_nodoc', 'mstd_tgldoc'])->toArray();

        return view('BACKOFFICE/TRANSAKSI/PEMUSNAHAN.inqueryBAPB', compact('noDoc'));
    }

    public function getDocument(Request $request){
        $search = $request->value;

        $noDoc= DB::table('tbtr_mstran_d')
            ->whereNull(['mstd_recordid'])
            ->whereRaw("mstd_nodoc like '8%$search%'")
            ->orderByDesc('mstd_nodoc')->distinct()->limit(100)->get(['mstd_nodoc', 'mstd_tgldoc'])->toArray();

        return Datatables::of($noDoc)->make(true);
    }

    public function getDetailDocument(Request $request){
        $noDoc  = $request->noDoc;

        $detail = DB::table('tbtr_mstran_d')
            ->leftJoin('tbmaster_prodmast', 'mstd_prdcd', 'prd_prdcd')
            ->where('mstd_nodoc', $noDoc)
            ->whereNull(['mstd_recordid'])
            ->get()->toArray();

        if ($detail) {
            return response()->json(['kode' => 1, 'data' => $detail]);
        } else {
            return response()->json(['kode' => 0, 'data' => 'Data tidak ada!!']);
        }
    }

    public function detailPlu(Request $request){
        $plu    = $request->plu;
        $doc    = $request->doc;
        $kodeigr = $_SESSION['kdigr'];

        $detail= DB::select("select mstd_prdcd plu, prd_deskripsipanjang barang, mstd_unit unit, prd_frac frac,
                                            prd_kodetag tag, prd_flagbandrol bandrol, mstd_bkp bkp,  case when st_lastcost is null or st_lastcost =0 then  prd_lastcost else st_lastcost * case when prd_unit='KG' then 1 else prd_frac end end lcost,
                                            nvl(st_avgcost,0) st_avgcost ,  nvl(st_saldoakhir,0) st_qty,
                                            mstd_hrgsatuan hrgsatuan, mstd_qty qty, mstd_gross gross, mstd_keterangan keterangan,
                                            mstd_noref3, mstd_tgref3
                                    from tbtr_mstran_d, tbmaster_prodmast, tbmaster_stock
                                    where MSTD_NODOC = '$doc'
                                            and mstd_kodeigr='$kodeigr'
                                            and mstd_prdcd = '$plu'
                                            and mstd_typetrn='F'
                                            and prd_prdcd=mstd_prdcd
                                            and prd_kodeigr = mstd_kodeigr
                                            and st_prdcd = substr(prd_prdcd,1,6)||'0'
                                            and st_kodeigr=prd_kodeigr
                                            and st_lokasi='03'
        ");

        if ($detail){
            if($detail[0]->unit == 'KG'){
                $tempAcost = $detail[0]->st_avgcost * 1;
            } else {
                $tempAcost = $detail[0]->st_avgcost * $detail[0]->frac;
            }

            $tempQty    = floor( $detail[0]->st_qty/ $detail[0]->frac);
            $tempQtyk   = $detail[0]->st_qty %  $detail[0]->frac;

            $detail[0]->tempAcost   = $tempAcost;
            $detail[0]->tempQty     = $tempQty;
            $detail[0]->tempQtyk    = $tempQtyk;
        }

        return response()->json($detail);
    }

}
