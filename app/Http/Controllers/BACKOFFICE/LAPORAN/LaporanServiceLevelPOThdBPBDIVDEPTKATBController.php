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

class LaporanServiceLevelPOThdBPBDIVDEPTKATBController extends Controller
{
    public function index(){
        return view('BACKOFFICE.LAPORAN.laporan-service-level-po-thd-bpb-div-dept-katb');
    }

    public function getDataLovDiv(Request $request){
        if(is_null($request->div))
            $div = 1;
        else $div = $request->div;

        $data = DB::connection(Session::get('connection'))->table('tbmaster_divisi')
            ->select('div_kodedivisi','div_namadivisi')
            ->where('div_kodeigr','=',Session::get('kdigr'))
            ->whereRaw('div_kodedivisi >= '.$div)
            ->get();

        return DataTables::of($data)->make(true);
    }

    public function getDataLovDep(Request $request){
        $data = DB::connection(Session::get('connection'))->table('tbmaster_departement')
            ->select('dep_kodedepartement','dep_namadepartement','dep_kodedivisi')
            ->where('dep_kodeigr','=',Session::get('kdigr'))
            ->where('dep_kodedivisi','=',$request->div)
            ->get();

        return DataTables::of($data)->make(true);
    }

    public function getDataLovKat(Request $request){
        $data = DB::connection(Session::get('connection'))->table("tbmaster_kategori")
            ->join('tbmaster_departement','dep_kodedepartement','=','kat_kodedepartement')
            ->select('kat_namakategori','kat_kodekategori','kat_kodedepartement','dep_kodedivisi')
            ->where('kat_kodeigr','=',Session::get('kdigr'))
            ->where('kat_kodedepartement','=',$request->dep)
            ->where('dep_kodedivisi','=',$request->div)
            ->orderBy('kat_kodedepartement')
            ->orderBy('kat_kodekategori')
            ->get();

        return DataTables::of($data)->make(true);
    }

    public function getDataTag(){
        $data = DB::connection(Session::get('connection'))
            ->select("SELECT tag_kodeigr, tag_kodetag, tag_keterangan FROM tbmaster_tag
                UNION
                SELECT (select prs_kodeigr from tbmaster_perusahaan), NULL, 'KOSONG' FROM dual");

        return response()->json($data);
    }

    public function print(Request $request){
        $tgl1 = $request->tgl1;
        $tgl2 = $request->tgl2;
        $tgl1 = $request->tgl1;
        $tgl2 = $request->tgl2;
        $div1 = $request->div1;
        $div2 = $request->div2;
        $dep1 = $request->dep1;
        $dep2 = $request->dep2;
        $kat1 = $request->kat1;
        $kat2 = $request->kat2;
        $tag = explode('*',$request->tag);

        if(count($tag) > 0 and $tag[0] != ''){
            $whereTag = "(";

            foreach($tag as $t){
                $whereTag .= "'".$t."',";
            }
            $whereTag = "AND prd_kodetag in ".substr($whereTag, 0, strlen($whereTag) - 1).")";
        }
        else $whereTag = 'AND 1 = 1';

        $perusahaan = DB::connection(Session::get('connection'))
            ->table('tbmaster_perusahaan')
            ->first();

        $data = DB::connection(Session::get('connection'))
            ->select("select tpod_prdcd, tpod_kodedivisi, tpod_kodedepartemen,
        tpod_kategoribarang, div_namadivisi, dep_namadepartement, kat_namakategori,
        sum(tpod_qtypo) qtypo, sum(gross) gross, sum(bm) bm, sum(btl) btl,
        sum(nilaiA) nilaiA, sum(kuanB) kuanB, sum(nilaiB) nilaiB, sum(kuanA) kuanA,
        SUM(qty_PO_outs) qty_PO_outs, SUM(rph_PO_outs) rph_PO_outs,
        sum(mstd_qtybonus1) qtybns1, sum(mstd_qtybonus2) qtybns2, sum(grossrp) grossrp,
        sum(potongan) potongan, sum(bmrp) bmrp, sum(btlrp) btlrp, prd_kodetag,
        prd_deskripsipanjang
from (select tpod_prdcd, tpod_kodedivisi, tpod_kodedepartemen,
           tpod_kategoribarang, div_namadivisi, dep_namadepartement, kat_namakategori,
           (tpod_qtypo + nvl(tpod_bonuspo1, 0) + nvl(tpod_bonuspo2, 0)) tpod_qtypo , nvl(tpod_gross,0) gross, nvl(tpod_ppnbm,0) bm, nvl(tpod_ppnbotol,0) btl,
           (nvl(tpod_gross,0) + nvl(tpod_ppn,0) + nvl(tpod_ppnbm,0) + nvl(tpod_ppnbotol,0)) nilaiA,
           (nvl(mstd_qty,0)  + nvl(mstd_qtybonus1,0) + nvl(mstd_qtybonus2,0)) kuanB,
           (nvl(mstd_gross,0) - nvl(mstd_discrph,0) + nvl(mstd_ppnrph,0) + nvl(mstd_ppnbmrph,0) + nvl(mstd_ppnbtlrph,0)) nilaiB,
           nvl(mstd_qty,0) kuanA, mstd_qtybonus1, mstd_qtybonus2, nvl(mstd_gross,0) grossrp,
           nvl(mstd_discrph,0) potongan, nvl(mstd_ppnbmrph,0) bmrp, nvl(mstd_ppnbtlrph,0) btlrp,
           prd_deskripsipanjang, prd_kodetag,
           CASE WHEN mstd_prdcd is null  and trunc(tpoh_tglpo + tpoh_jwpb) >= trunc(sysdate) THEN (tpod_qtypo + nvl(tpod_bonuspo1, 0) + nvl(tpod_bonuspo2, 0))  ELSE 0 END qty_PO_outs,
           CASE WHEN mstd_prdcd is null  and trunc(tpoh_tglpo + tpoh_jwpb) >= trunc(sysdate) THEN
           (NVL(tpod_gross,0) + NVL(tpod_ppn,0) + NVL(tpod_ppnbm,0) + NVL(tpod_ppnbotol,0)) ELSE 0 END rph_PO_outs
        from tbtr_po_d, tbtr_po_h, tbtr_mstran_d, tbmaster_prodmast,
                tbmaster_divisi, tbmaster_departement, tbmaster_kategori
        where tpod_kodeigr = '".Session::get('kdigr')."'
          and TRUNC(tpod_tglpo) BETWEEN to_date('".$tgl1."','dd/mm/yyyy') and to_date('".$tgl2."','dd/mm/yyyy')
          AND NVL (tpoh_recordid, '0') <> '1'
          AND tpoh_nopo = tpod_nopo
          AND trunc(tpoh_tglpo) = trunc(tpod_tglpo)
          and tpod_kodedivisi between '".$div1."' and '".$div2."'
          and tpod_kodedepartemen between '".$dep1."' and '".$dep2."'
          and tpod_kategoribarang between '".$kat1."' and '".$kat2."'
          and mstd_typetrn(+) = 'B'
          and mstd_kodeigr(+) = tpod_kodeigr
          and nvl(mstd_recordid(+), '9') <> '1'
          and mstd_prdcd(+) = tpod_prdcd
          and mstd_nopo(+) = tpod_nopo
          and mstd_tglpo(+) = tpod_tglpo
          and prd_kodeigr(+) = tpod_kodeigr
          and nvl(prd_recordid(+), '9') <> '1'
          and prd_prdcd(+) = tpod_prdcd
          ".$whereTag."
          and div_kodedivisi(+) = tpod_kodedivisi
          and div_kodeigr(+) = tpod_kodeigr
          and dep_kodedivisi(+) = tpod_kodedivisi
          and dep_kodedepartement(+) = tpod_kodedepartemen
          and dep_kodeigr(+) = tpod_kodeigr
          and kat_kodedepartement(+) = tpod_kodedepartemen
          and kat_kodekategori(+) = tpod_kategoribarang
          and kat_kodeigr(+) = tpod_kodeigr
          --and (tpod_kodedivisi||tpod_kodedepartemen||tpod_kategoribarang between :p_div1||:p_dept1||:p_kat1 and :p_div2||:p_dept2||:p_kat2)
)
group by tpod_kodedivisi, tpod_kodedepartemen, tpod_kategoribarang,
        tpod_prdcd, div_namadivisi, dep_namadepartement, kat_namakategori, prd_kodetag,
       prd_deskripsipanjang
order by tpod_kodedivisi, tpod_kodedepartemen, tpod_kategoribarang, tpod_prdcd");

//        dd($data);

        return view('BACKOFFICE.LAPORAN.laporan-service-level-po-thd-bpb-div-dept-katb-pdf',compact(['perusahaan','data','tgl1','tgl2']));
    }
}
