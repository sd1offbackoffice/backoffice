<?php
namespace App\Http\Controllers\BACKOFFICE\TRANSAKSI\PERUBAHANSTATUS;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class entrySortirBarangController extends Controller
{
    //

    public function index(){
        return view('BACKOFFICE/TRANSAKSI/PERUBAHANSTATUS.entrySortirBarang');
    }

    public function chooseSrt(Request $request){
        $kode = $request->kode;

        $datas = DB::table('TBTR_SORTIR_BARANG')
            ->selectRaw('RSK_NOSORTIR')
            ->selectRaw('RSK_TGLSORTIR')
            ->selectRaw('SRT_KETERANGAN')
            ->selectRaw('SRT_GUDANGTOKO')
            ->selectRaw('SRT_PRDCD')
            ->selectRaw('SRT_TAG')
            ->selectRaw('SRT_TTLHARGA')
            ->selectRaw('SRT_AVGCOST')
            ->selectRaw('prd_perlakuanbarang')
            ->selectRaw('prd_deskripsipendek')
            ->selectRaw('prd_deskripsipanjang')
            ->selectRaw('prd_frac')
            ->selectRaw('prd_unit')
            ->selectRaw('TRUNC(rsk_qty/prd_frac) as qty_ctn')
            ->selectRaw('MOD(rsk_qty , prd_frac) as qty_pcs')
            ->leftJoin('tbmaster_prodmast', 'prd_prdcd', 'srt_prdcd')
            ->where('rsk_nodoc', $kode)
            ->orderBy('rsk_seqno')
            ->get();

//        $test = DB::table('tbtr_barangrusak')->limit(10)->get()->toArray();
//        dd($datas);

        return response()->json($datas);
    }

    public function getNmrSrt(Request $request){
        $search = $request->val;

        $datas = DB::table('TBTR_SORTIR_BARANG')
            ->selectRaw('distinct SRT_NOSORTIR as SRT_NOSORTIR')
            ->selectRaw('SRT_TGLSORTIR')
            ->selectRaw('SRT_KETERANGAN')
            ->selectRaw('SRT_GUDANGTOKO')
            ->where('SRT_NOSORTIR','LIKE', '%'.$search.'%')
            ->orderByDesc('SRT_NOSORTIR')
//            ->orderByDesc('rsk_create_dt')
            ->limit(100)
            ->get();

        return response()->json($datas);
    }
}