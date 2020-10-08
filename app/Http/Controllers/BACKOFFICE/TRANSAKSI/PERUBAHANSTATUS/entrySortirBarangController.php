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

    public function getNewNmrSrt(){
        $kodeigr = $_SESSION['kdigr'];

        $connect = oci_connect('SIMSMG', 'SIMSMG', '192.168.237.193:1521/SIMSMG');

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

    public function chooseSrt(Request $request){
        $kode = $request->kode;

        $datas = DB::table('TBTR_SORTIR_BARANG')
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

//        $test = DB::table('tbtr_barangrusak')->limit(10)->get()->toArray();
//        dd($datas);

        return response()->json($datas);
    }

    public function getPlu(Request $request){
        $search = $request->val;

        $datas = DB::table('tbmaster_prodmast')
            ->select('prd_prdcd', 'prd_deskripsipanjang')
//            ->where('prd_prdcd', '1188110')
            ->whereRaw("SUBSTR(PRD_PRDCD,7,1)='0'")
            ->whereRaw("nvl(prd_recordid,'9')<>'1'")
            ->whereRaw("(prd_deskripsipanjang LIKE '%". $search."%' or prd_prdcd LIKE '%". $search."%')")
            ->orderBy('prd_deskripsipanjang')
            ->limit(100)->get();

        return response()->json($datas);
    }

    public function choosePlu(Request $request){
        $kode = $request->kode;

        $cursor = DB::select("
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
        $datas  = $request->datas;
        $keterangan  = $request->keterangan;
        $pludi  = $request->pludi;
        $date   = date('Y-M-d', strtotime($request->date));
        $noSrt  = $request->noDoc;
        $kodeigr= $_SESSION['kdigr'];
        $userid = $_SESSION['usid'];
        $today  = date('Y-m-d H:i:s');

//        *** Get Doc No ***
        $connect = oci_connect('SIMSMG', 'SIMSMG', '192.168.237.193:1521/SIMSMG');
        $query = oci_parse($connect, "BEGIN :ret := f_igr_get_nomor('$kodeigr','S',
            'Nomor Sortir Barang',
               'S'
            || TO_CHAR (SYSDATE, 'yy')
            || SUBSTR ('123456789ABC', TO_CHAR (SYSDATE, 'MM'), 1),
            5,
            TRUE); END;");
        oci_bind_by_name($query, ':ret', $docNo, 32);
        oci_execute($query);

//        *** Search DocNo for Edit ***
        $getDoc = DB::table('TBTR_SORTIR_BARANG')->where('srt_nosortir', $noSrt)->first();


        if ($getDoc){
//                *** Update Data ***
//            DB::table('TBTR_SORTIR_BARANG')->where('srt_nosortir', $noSrt)->delete();
//
//            for ($i = 1; $i < sizeof($datas); $i++){
//                $temp = $datas[$i];
//
//                DB::table('TBTR_SORTIR_BARANG')
//                    ->insert(['rsk_kodeigr' => $kodeigr, 'rsk_recordid' => '', 'rsk_nodoc' => $getDoc->rsk_nodoc, 'rsk_tgldoc' => $date, 'rsk_seqno' => $i, 'rsk_prdcd' => $temp['plu'], 'rsk_qty' => $temp['qty'],
//                        'rsk_hrgsatuan' => $temp['harga'], 'rsk_nilai' => $temp['total'], 'rsk_flag' => '1', 'rsk_keterangan' => strtoupper($temp['keterangan']), 'rsk_create_by' => $getDoc->rsk_create_by,
//                        'rsk_create_dt' => $getDoc->rsk_create_dt, 'rsk_modify_by' => $userid, 'rsk_modify_dt' => $today]);
//            }
//
//            return response()->json(['kode' => 1, 'msg' => $getDoc->rsk_nodoc]);
        } else {
//              *** Insert Data ***
            for ($i = 1; $i < sizeof($datas); $i++){
                $temp = $datas[$i];
                $prodMast = DB::table('TBMASTER_PRODMAST')
                    ->where('prd_kodeigr', $kodeigr)
                    ->where('prd_prdcd', $temp['plu'])
                    ->get();

                $getVal = DB::table('TBMASTER_HARGABELI')
                    ->leftJoin('TBMASTER_SUPPLIER', 'hgb_kodesupplier', 'sup_kodesupplier', 'hgb_kodeigr','sup_kodeigr')
                    ->where('hgb_prdcd', $temp['plu'])
                    ->where('hgb_tipe','=',2)
                    ->where('hgb_kodeigr',$kodeigr)
                    ->get();

                DB::table('TBTR_SORTIR_BARANG')
                    ->insert(['srt_kodeigr' => $kodeigr, 'srt_recordid' => '', 'srt_type' => 'S', 'srt_batch' => '', 'srt_nosortir' => $docNo, 'rsk_tglsortir' => $date,
                        'srt_nodokumen' => '', 'srt_tgldokumen' => '', 'srt_noref' => '', 'srt_tglref' => '', 'srt_kodesupplier' => $getVal['hgb_kodesupplier'],
                        'srt_pkp' => $getVal['sup_pkp'], 'srt_cterm' => '', 'srt_seqno' => $i, 'srt_kodedivisi' => $prodMast['prd_kodedivisi'],
                        'srt_kodedepartement' => $prodMast['prd_kodedepartement'], 'srt_kodekategoribarang' => $prodMast['prd_kodekategoribarang'], 'srt_bkp' => '',
                        'srt_unit' => $temp['unit'], 'srt_frac' => $temp['frac'], 'srt_lokasi' => $kodeigr, 'srt_qtykarton' => $temp['ctn'], 'srt_qtypcs' => $temp['pcs'],
                        'srt_qtybonus1' => '', 'srt_qtybonus2' => '', 'srt_hrgsatuan' => $temp['avgcost'], 'srt_flagdisc1' => '', 'srt_flagdisc2' => '',
                        'srt_ttlhrg' => $temp['total'], 'srt_avgcost' => $temp['avgcost'], 'srt_keterangan' => $keterangan, 'srt_tag' => $temp['tag'], 'srt_create_by' => $userid,
                        'srt_create_dt' => $today, 'srt_gudangtoko' => $pludi]);
            }

            return response()->json(['kode' => 1, 'msg' => $docNo]);
        }
    }

    public function printDocument(Request $request){
        $noDoc      = $request->doc;
        $p_reprint  = 'Y';

        $cekStatusPrint = DB::table('tbtr_sortir_barang')->where('srt_nosortir', $noDoc)->first();

        if ($cekStatusPrint->srt_flagdisc3 == 'P' || $cekStatusPrint->srt_flagdisc3 == 'p'){
            $p_reprint = 'Y';
        } elseif ($cekStatusPrint->srt_flagdisc3 == null || $cekStatusPrint->srt_flagdisc3 == '') {
            $p_reprint = '';
        }
        if($p_reprint === ''){

        }

        $datas = DB::select("select SRT_PRDCD, SRT_UNIT, SRT_AVGCOST, SRT_FRAC, SRT_TAG, SRT_QTYKARTON, SRT_QTYPCS, SRT_KODEIGR,
                                        SRT_TTLHRG, SRT_RECORDID, SRT_TYPE, SRT_BATCH, SRT_NOSORTIR, SRT_TGLSORTIR, SRT_NODOKUMEN, SRT_TGLDOKUMEN, 
                                        SRT_NOREF, SRT_TGLREF, SRT_KODESUPPLIER, SRT_PKP, SRT_CTERM, SRT_SEQNO, SRT_KODEDIVISI, SRT_KODEDEPARTEMENT,
                                        SRT_KODEKATEGORIBARANG, SRT_BKP, SRT_LOKASI, SRT_QTYBONUS1, SRT_QTYBONUS2, SRT_FLAGDISC1, SRT_FLAGDISC2, 
                                        SRT_FLAGDISC3, SRT_KETERANGAN, SRT_CREATE_BY, SRT_CREATE_DT, SRT_MODIFY_DT, SRT_MODIFY_BY, SRT_HRGSATUAN, SRT_GUDANGTOKO"
        );

//        $datas = DB::select("select PRS_NAMAPERUSAHAAN, cab_namacabang, cab_alamat2, nvl(rsk_recordid,'8') ,
//                                              rsk_nodoc, rsk_tgldoc, rsk_prdcd, FLOOR(rsk_qty/prd_frac) qty, mod(rsk_qty,prd_frac) qtyk,rsk_hrgsatuan, rsk_nilai,
//                                              rsk_keterangan, rap_store_manager,  rap_logistic_supervisor, rap_administrasi,
//                                              prd_deskripsipanjang, prd_unit||'/'||prd_frac SATUAN, case when '$p_reprint' = 'Y' then 'REPRINT' else '' end reprint
//                                    from tbmaster_perusahaan, tbmaster_cabang, tbtr_barangrusak, tbmaster_prodmast, tbmaster_report_approval
//                                    where rsk_nodoc = '$noDoc'
//                                              and prs_kodeigr = rsk_kodeigr
//                                              and cab_kodecabang(+)=prs_kodecabang
//                                              and cab_kodeigr(+)=prs_kodeigr
//                                              and prd_prdcd(+)=rsk_prdcd
//                                              and prd_kodeigr(+)=rsk_kodeigr
//                                              and rap_kodeigr(+)=rsk_kodeigr
//                                    order by rsk_seqno
//");

//                Update rsk_recordid
        DB::table('tbtr_sortir_barang')->where('rsk_nosortir', $noDoc)->whereNull('srt_flagdisc3')->update(['srt_flagdisc3' => 'P']);

        $pdf = PDF::loadview('BACKOFFICE/TRANSAKSI/PEMUSNAHAN.EntrySortirBarang-laporan', ['datas' => $datas]);
        $pdf->output();
        $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);

        $canvas = $dompdf ->get_canvas();
        $canvas->page_text(514, 10, "Page {PAGE_NUM} of {PAGE_COUNT}", null, 10, array(0, 0, 0));

        return $pdf->stream('BACKOFFICE/TRANSAKSI/PEMUSNAHAN.EntrySortirBarang-laporan');
    }
}