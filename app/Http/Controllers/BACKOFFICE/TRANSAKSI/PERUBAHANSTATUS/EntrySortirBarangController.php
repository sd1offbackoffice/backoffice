<?php
namespace App\Http\Controllers\BACKOFFICE\TRANSAKSI\PERUBAHANSTATUS;

use App\Http\Controllers\Auth\loginController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller; use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use PDF;
use Yajra\DataTables\DataTables;

class EntrySortirBarangController extends Controller
{
    //

    public function index(){
        return view('BACKOFFICE.TRANSAKSI.PERUBAHANSTATUS.entry-sortir-barang');
    }

    public function getNewNmrSrt(){
        $kodeigr = Session::get('kdigr');

        $connect = loginController::getConnectionProcedure();

        $query = oci_parse($connect, "BEGIN :ret := f_igr_get_nomor('$kodeigr','S',
            'Nomor Sortir Barang',
               'S'
            || TO_CHAR (SYSDATE, 'yy')
            || SUBSTR ('123456789ABC', TO_CHAR (SYSDATE, 'MM'), 1),
            5,
            FALSE); END;");
        oci_bind_by_name($query, ':ret', $result, 32);
        oci_execute($query);

        return response()->json($result);
    }

    public function getNmrSrt(Request $request){
        $search = $request->val;
        $kodeigr = Session::get('kdigr');

        $datas = DB::connection(Session::get('connection'))->table('TBTR_SORTIR_BARANG')
            ->selectRaw('distinct SRT_KODEIGR as SRT_KODEIGR')
            ->selectRaw('SRT_NOSORTIR')
            ->selectRaw('SRT_TGLSORTIR')
            ->selectRaw('SRT_KETERANGAN')
            ->selectRaw('SRT_GUDANGTOKO')
            ->where('SRT_NOSORTIR','=', $search)
            ->where('SRT_KODEIGR','=',$kodeigr)
            ->where('SRT_NOSORTIR','<>',null)
            ->orderByDesc('SRT_TGLSORTIR')
            ->orderByDesc('SRT_NOSORTIR')
//            ->orderByDesc('rsk_create_dt')
            ->first();

        return response()->json($datas);
    }

    public function ModalSrt(Request $request){
        $kodeigr = Session::get('kdigr');
        $search = $request->value;

        $datas = DB::connection(Session::get('connection'))->table('TBTR_SORTIR_BARANG')
            ->selectRaw('distinct SRT_KODEIGR as SRT_KODEIGR')
            ->selectRaw('SRT_NOSORTIR')
            ->selectRaw('SRT_TGLSORTIR')
            ->selectRaw('SRT_KETERANGAN')

            ->where('SRT_NOSORTIR','LIKE', '%'.$search.'%')
            ->where('SRT_KODEIGR','=',$kodeigr)
            ->where('SRT_NOSORTIR','<>',null)

            ->orWhere('SRT_TGLSORTIR','LIKE', '%'.$search.'%')
            ->where('SRT_KODEIGR','=',$kodeigr)
            ->where('SRT_NOSORTIR','<>',null)

            ->orWhere('SRT_KETERANGAN','LIKE', '%'.$search.'%')
            ->where('SRT_KODEIGR','=',$kodeigr)
            ->where('SRT_NOSORTIR','<>',null)

            ->orderByDesc('SRT_TGLSORTIR')
            ->orderByDesc('SRT_NOSORTIR')
            ->limit(100)
            ->get();

        return Datatables::of($datas)->make(true);
    }

    public function chooseSrt(Request $request){
        $kode = $request->kode;

        $datas = DB::connection(Session::get('connection'))->table('TBTR_SORTIR_BARANG')
            ->selectRaw('SRT_NOSORTIR')
            ->selectRaw('SRT_TGLSORTIR')
            ->selectRaw('SRT_KETERANGAN')
            ->selectRaw('SRT_GUDANGTOKO')
            ->selectRaw('SRT_PRDCD')
            ->selectRaw('SRT_TAG')
            ->selectRaw('SRT_TTLHRG')
            ->selectRaw('SRT_AVGCOST')
            ->selectRaw('SRT_QTYKARTON')
            ->selectRaw('SRT_QTYPCS')
            ->selectRaw('prd_perlakuanbarang')
            ->selectRaw('prd_deskripsipendek')
            ->selectRaw('prd_deskripsipanjang')
            ->selectRaw('prd_frac')
            ->selectRaw('prd_unit')
            ->selectRaw("Case When SRT_FLAGDISC3='P'  OR SRT_FLAGDISC3='p' Then 'Data Sudah Dicetak' Else 'Data Belum dicetak' End  Nota")
            ->leftJoin('tbmaster_prodmast', 'prd_prdcd', 'srt_prdcd')
            ->where('SRT_NOSORTIR', $kode)
            ->get();

//        $test = DB::connection(Session::get('connection'))->table('tbtr_barangrusak')->limit(10)->get()->toArray();
//        dd($datas);

        return response()->json($datas);
    }

//    public function getPlu(Request $request){
//        $search = $request->val;
//        $kodeigr = Session::get('kdigr');
//
//        $datas = DB::connection(Session::get('connection'))->table('tbmaster_prodmast')
//            ->select('prd_prdcd', 'prd_deskripsipanjang')
////            ->where('prd_prdcd', '1188110')
//            ->whereRaw("SUBSTR(PRD_PRDCD,7,1)='0'")
//            ->whereRaw("nvl(prd_recordid,'9')<>'1'")
//            ->whereRaw("(prd_deskripsipanjang LIKE '%". $search."%' or prd_prdcd LIKE '%". $search."%')")
//            ->where('PRD_KODEIGR','=',$kodeigr)
//            ->first();
//
//        return response()->json($datas);
//    }

    public function ModalPlu(Request $request){
        $kodeigr = Session::get('kdigr');
        $search = $request->value;

        $datas = DB::connection(Session::get('connection'))->table('tbmaster_prodmast')
            ->select('prd_prdcd', 'prd_deskripsipanjang')
//            ->where('prd_prdcd', '1188110')

            ->where('prd_prdcd','LIKE', '%'.$search.'%')
            ->whereRaw("SUBSTR(PRD_PRDCD,7,1)='0'")
            ->whereRaw("nvl(prd_recordid,'9')<>'1'")

            ->orWhere('prd_deskripsipanjang','LIKE', '%'.$search.'%')
            ->whereRaw("SUBSTR(PRD_PRDCD,7,1)='0'")
            ->whereRaw("nvl(prd_recordid,'9')<>'1'")

            ->where('PRD_KODEIGR','=',$kodeigr)
            ->limit(100)->get();

        return Datatables::of($datas)->make(true);
    }

    public function choosePlu(Request $request){
        $kode = $request->kode;

        $cursor = DB::connection(Session::get('connection'))->select("
            SELECT PRD_PRDCD, PRD_DESKRIPSIPENDEK, PRD_DESKRIPSIPANJANG, PRD_FRAC, PRD_UNIT, PRD_PERLAKUANBARANG, PRD_KODETAG, ST_AVGCOST
            FROM TBMASTER_PRODMAST a
            LEFT JOIN TBMASTER_STOCK b ON prd_prdcd = st_prdcd and st_lokasi = '01'
            where  PRD_PRDCD = '$kode'
        ");

        if (!$cursor){
            $msg = "Kode Produk ". $kode. " Tidak Terdaftar!";

            return response()->json(['kode' => 0, 'msg' => $msg, 'data' => '']);
        }
        else{
            return response()->json(['kode' => 1, 'msg' => '', 'data' => $cursor]);
        }
    }

    public function saveData(Request $request){
        try{
            DB::connection(Session::get('connection'))->beginTransaction();
            $datas  = $request->datas;
            $keterangan  = $request->keterangan;
            $pludi  = $request->pludi;
            $date   = date('Y-m-d', strtotime($request->date));
            $noSrt  = $request->noDoc;
            $kodeigr= Session::get('kdigr');
            $userid = Session::get('usid');
            $today  = date('Y-m-d H:i:s');


//        *** Search DocNo for Edit ***
            $getDoc = DB::connection(Session::get('connection'))->table('TBTR_SORTIR_BARANG')->where('srt_nosortir', $noSrt)->first();


            if ($getDoc){
                if($getDoc->srt_flagdisc3 == 'P' || $getDoc->srt_flagdisc3 == 'p'){
                    return response()->json(['kode' => 3, 'msg' => $getDoc->srt_nosortir]);
                }
//                *** Update Data ***
                $prevVal = DB::connection(Session::get('connection'))->table('TBTR_SORTIR_BARANG')
                    ->selectRaw("srt_create_dt")
                    ->selectRaw("srt_create_by")
                    ->where('srt_nosortir', $noSrt)
                    ->first();
                $today  = date('Y-m-d H:i:s', strtotime($prevVal->srt_create_dt));
                $userid = $prevVal->srt_create_by;

               DB::connection(Session::get('connection'))->table('TBTR_SORTIR_BARANG')->where('srt_nosortir', $noSrt)->delete();

                for ($i = 1; $i < sizeof($datas); $i++){
                    $temp = $datas[$i];

                    //pakai ini print nya tidak jalan, di program lama juga sepertinya ini tidak terpakai
//                    $cekStatusPrint = DB::connection(Session::get('connection'))->table('tbtr_sortir_barang')->where('srt_nosortir', $noSrt)->first();
//
//                    if($cekStatusPrint->srt_flagdisc1 <> ' ' && $cekStatusPrint->srt_flagdisc2 <> ' ' && $cekStatusPrint->srt_flagdisc1 <> $cekStatusPrint->srt_flagdisc1){
//                        return response()->json(['kode' => 2, 'msg' => "Isian Status Aw & Ak Harus Beda !!"]);
//                    }


                    $prodMast = DB::connection(Session::get('connection'))->table('TBMASTER_PRODMAST')
                        ->where('prd_kodeigr', $kodeigr)
                        ->where('prd_prdcd', $temp['plu'])
                        ->first();

                    $getVal = DB::connection(Session::get('connection'))->table('TBMASTER_HARGABELI')
                        ->LeftJoin('TBMASTER_SUPPLIER',function($join){
                            $join->on('hgb_kodesupplier','sup_kodesupplier');
                            $join->on('hgb_kodeigr','sup_kodeigr');
                        })
                        ->where('hgb_prdcd', $temp['plu'])
                        ->where('hgb_tipe','=',2)
                        ->where('hgb_kodeigr',$kodeigr)
                        ->first();

                    DB::connection(Session::get('connection'))->table('TBTR_SORTIR_BARANG')
                        ->insert(['srt_kodeigr' => $kodeigr, 'srt_recordid' => '', 'srt_type' => 'S', 'srt_batch' => '', 'srt_nosortir' => $noSrt, 'srt_tglsortir' => $date,
                            'srt_nodokumen' => '', 'srt_tgldokumen' => '', 'srt_noref' => '', 'srt_tglref' => '', 'srt_kodesupplier' => $getVal->hgb_kodesupplier,
                            'srt_pkp' => $getVal->sup_pkp, 'srt_cterm' => '', 'srt_seqno' => $i, 'srt_prdcd' => $temp['plu'], 'srt_kodedivisi' => $prodMast->prd_kodedivisi,
                            'srt_kodedepartement' => $prodMast->prd_kodedepartement, 'srt_kodekategoribarang' => $prodMast->prd_kodekategoribarang, 'srt_bkp' => '',
                            'srt_unit' => $temp['unit'], 'srt_frac' => $temp['frac'], 'srt_lokasi' => $kodeigr, 'srt_qtykarton' => $temp['ctn'], 'srt_qtypcs' => $temp['pcs'],
                            'srt_qtybonus1' => '', 'srt_qtybonus2' => '', 'srt_hrgsatuan' => $temp['avgcost'], 'srt_flagdisc1' => '', 'srt_flagdisc2' => '',
                            'srt_ttlhrg' => $temp['total'], 'srt_avgcost' => $temp['avgcost'], 'srt_keterangan' => $keterangan, 'srt_tag' => $temp['tag'], 'srt_create_by' => $userid,
                            'srt_create_dt' => $today, 'srt_gudangtoko' => $pludi]);
                }
                DB::connection(Session::get('connection'))->commit();
                return response()->json(['kode' => 1, 'msg' => $getDoc->srt_nosortir]);
            } else {
//              *** Insert Data ***
                $connect = loginController::getConnectionProcedure();
                //menjalankan procedure untuk counter nomor dokumen
            $query = oci_parse($connect, "BEGIN :ret := f_igr_get_nomor('$kodeigr','S',
            'Nomor Sortir Barang',
               'S'
            || TO_CHAR (SYSDATE, 'yy')
            || SUBSTR ('123456789ABC', TO_CHAR (SYSDATE, 'MM'), 1),
            5,
            TRUE); END;");
            oci_bind_by_name($query, ':ret', $noSrt, 32);
            oci_execute($query);

                for ($i = 1; $i < sizeof($datas); $i++){
                    $temp = $datas[$i];

                    $prodMast = DB::connection(Session::get('connection'))->table('TBMASTER_PRODMAST')
                        ->where('prd_kodeigr', $kodeigr)
                        ->where('prd_prdcd', $temp['plu'])
                        ->first();

                    $getVal = DB::connection(Session::get('connection'))->table('TBMASTER_HARGABELI')
                        ->LeftJoin('TBMASTER_SUPPLIER',function($join){
                            $join->on('hgb_kodesupplier','sup_kodesupplier');
                            $join->on('hgb_kodeigr','sup_kodeigr');
                        })
                        ->where('hgb_prdcd', $temp['plu'])
                        ->where('hgb_tipe','=',2)
                        ->where('hgb_kodeigr',$kodeigr)
                        ->first();

                    DB::connection(Session::get('connection'))->table('TBTR_SORTIR_BARANG')
                        ->insert(['srt_kodeigr' => $kodeigr, 'srt_recordid' => '', 'srt_type' => 'S', 'srt_batch' => '', 'srt_nosortir' => $noSrt, 'srt_tglsortir' => $date,
                            'srt_nodokumen' => '', 'srt_tgldokumen' => '', 'srt_noref' => '', 'srt_tglref' => '', 'srt_kodesupplier' => $getVal->hgb_kodesupplier,
                            'srt_pkp' => $getVal->sup_pkp, 'srt_cterm' => '', 'srt_seqno' => $i, 'srt_prdcd' => $temp['plu'], 'srt_kodedivisi' => $prodMast->prd_kodedivisi,
                            'srt_kodedepartement' => $prodMast->prd_kodedepartement, 'srt_kodekategoribarang' => $prodMast->prd_kodekategoribarang, 'srt_bkp' => '',
                            'srt_unit' => $temp['unit'], 'srt_frac' => $temp['frac'], 'srt_lokasi' => $kodeigr, 'srt_qtykarton' => $temp['ctn'], 'srt_qtypcs' => $temp['pcs'],
                            'srt_qtybonus1' => '', 'srt_qtybonus2' => '', 'srt_hrgsatuan' => $temp['avgcost'], 'srt_flagdisc1' => '', 'srt_flagdisc2' => '',
                            'srt_ttlhrg' => $temp['total'], 'srt_avgcost' => $temp['avgcost'], 'srt_keterangan' => $keterangan, 'srt_tag' => $temp['tag'], 'srt_create_by' => $userid,
                            'srt_create_dt' => $today, 'srt_gudangtoko' => $pludi]);
                }
                DB::connection(Session::get('connection'))->commit();
                return response()->json(['kode' => 1, 'msg' => $noSrt]);
            }
        }catch (\Exception $e){
            DB::connection(Session::get('connection'))->rollBack();
            return response()->json(['kode' => 2, 'msg' => $e->getMessage()]);
        }

    }

    public function printDocument(Request $request){
        $noDoc      = $request->doc;
        $kodeigr= Session::get('kdigr');
        $p_reprint  = 'Y';

        $cekStatusPrint = DB::connection(Session::get('connection'))->table('tbtr_sortir_barang')->where('srt_nosortir', $noDoc)->first();

//        if ($cekStatusPrint->srt_flagdisc3 == 'P' || $cekStatusPrint->srt_flagdisc3 == 'p'){
//            $p_reprint = 'Y';
//        } elseif ($cekStatusPrint->srt_flagdisc3 == null || $cekStatusPrint->srt_flagdisc3 == '') {
//            $p_reprint = '';
//        }
//        if($p_reprint === ''){
//
//        }

//        $datas = DB::connection(Session::get('connection'))->select("select prs_namaperusahaan, prs_namacabang, prs_namaregional, prs_npwp, prs_alamat1, srt_tglsortir, srt_nosortir, srt_keterangan, prs_telepon, prd_perlakuanbarang, srt_prdcd, srt_qtykarton, srt_qtypcs, prd_deskripsipanjang, prd_unit||' / '||prd_frac SATUAN, prd_kodetag, hgb_statusbarang, case when '$p_reprint' = 'Y' then 'REPRINT' else '' end reprint
//                                    from tbmaster_perusahaan, tbtr_sortir_barang, tbmaster_prodmast, tbmaster_hargabeli
//                                    where srt_nosortir = '$noDoc'
//                                              and prs_kodeigr = srt_kodeigr
//                                              and prd_prdcd = srt_prdcd
//                                              and prd_kodeigr = srt_kodeigr
//                                              and hgb_prdcd = srt_prdcd
//                                    order by srt_seqno
//");
        $datas = DB::connection(Session::get('connection'))->select("SELECT srt_tglsortir, srt_nosortir || ' / ' || case when srt_gudangtoko = 'G' then 'GUDANG' else 'TOKO' end srt_nosortir, srt_prdcd, srt_qtykarton, srt_qtypcs, srt_keterangan,
                                                   prd_deskripsipanjang, prd_unit, prd_frac, prd_kodetag,
                                                   hgb_statusbarang, CASE WHEN hgb_statusbarang = 'PT' THEN 'Y' ELSE '' END AS flag_pt,
                                                   CASE WHEN hgb_statusbarang = 'RT' OR hgb_statusbarang = 'TG' THEN 'Y' ELSE '' END AS flag_rttg,
                                                   prs_namaperusahaan, prs_namacabang, prs_alamat1, prs_namaregional, prs_npwp, prs_telepon
                                    FROM TBTR_SORTIR_BARANG,  TBMASTER_PRODMAST, TBMASTER_HARGABELI, TBMASTER_PERUSAHAAN
                                    WHERE srt_nosortir = '$noDoc' AND srt_type = 'S' AND srt_kodeigr = '$kodeigr'
                                             AND prd_kodeigr = srt_kodeigr AND prd_prdcd = srt_prdcd
                                            AND hgb_kodeigr = srt_kodeigr AND hgb_tipe = '2' AND hgb_prdcd = srt_prdcd
                                            AND prs_kodeigr = srt_kodeigr
                                    ORDER BY SRT_SEQNO
");

//                Update srt_flagdisc3
        DB::connection(Session::get('connection'))->beginTransaction();
        DB::connection(Session::get('connection'))->table('tbtr_sortir_barang')->where('srt_nosortir', $noDoc)->whereNull('srt_flagdisc3')->update(['srt_flagdisc3' => 'P']);
        DB::connection(Session::get('connection'))->commit();

        $perusahaan = DB::connection(Session::get('connection'))->table("tbmaster_perusahaan")->first();
        return view('BACKOFFICE.TRANSAKSI.PERUBAHANSTATUS.entry-sortir-barang-laporan',
            ['data' => $datas, 'perusahaan' => $perusahaan]);
    }
}
