<?php

namespace App\Http\Controllers\BACKOFFICE\TRANSAKSI\PEMUSNAHAN;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use PDF;

class barangRusakController extends Controller
{
    public function index(){
        return view('BACKOFFICE/TRANSAKSI/PEMUSNAHAN.barangRusak');
    }

    public function getNmrTrn(Request $request){
        $search = $request->val;

        $datas = DB::table('tbtr_BarangRusak')
            ->selectRaw('distinct RSK_NODOC as RSK_NODOC')
            ->selectRaw('RSK_tglDOC')
            ->selectRaw('RSK_create_dt')
            ->selectRaw("Case When RSK_RECORDID='2'  OR RSK_RECORDID='9' Then 'Sudah Cetak Nota' Else 'Belum Cetak Nota' End  Nota")
            ->where('rsk_nodoc','LIKE', '%'.$search.'%')
            ->orderByDesc('rsk_nodoc')
//            ->orderByDesc('rsk_create_dt')
            ->limit(100)
            ->get();

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

    public function getNewNmrTrn(){
        $kodeigr = $_SESSION['kdigr'];

        $connect = oci_connect('SIMSMG', 'SIMSMG', '192.168.237.193:1521/SIMSMG');

        $query = oci_parse($connect, "BEGIN :ret := f_igr_get_nomor('$kodeigr','RSK','Nomor Pengeluaran Barang',
                            'RSK' || '$kodeigr' || TO_CHAR (SYSDATE, 'YY'),
							5,FALSE); END;");
        oci_bind_by_name($query, ':ret', $result, 32);
        oci_execute($query);

        return response()->json($result);
    }

    public function chooseTrn(Request $request){
        $kode = $request->kode;

        $datas = DB::table('tbtr_barangrusak')
            ->selectRaw('RSK_NODOC')
            ->selectRaw('RSK_tglDOC')
            ->selectRaw("Case When RSK_RECORDID='2'  OR RSK_RECORDID='9' Then 'Sudah Cetak Nota' Else 'Belum Cetak Nota' End  Nota")
            ->selectRaw('rsk_prdcd')
            ->selectRaw('rsk_hrgsatuan')
            ->selectRaw('rsk_nilai')
            ->selectRaw('rsk_keterangan')
            ->selectRaw('prd_deskripsipendek')
            ->selectRaw('prd_deskripsipanjang')
            ->selectRaw('prd_frac')
            ->selectRaw('prd_unit')
            ->selectRaw('TRUNC(rsk_qty/prd_frac) as qty_ctn')
            ->selectRaw('MOD(rsk_qty , prd_frac) as qty_pcs')
            ->leftJoin('tbmaster_prodmast', 'prd_prdcd', 'rsk_prdcd')
            ->where('rsk_nodoc', $kode)
            ->orderBy('rsk_seqno')
            ->get();

//        $test = DB::table('tbtr_barangrusak')->limit(10)->get()->toArray();
//        dd($datas);

        return response()->json($datas);
    }

    public function choosePlu(Request $request){
        $kode = $request->kode;
        $type = $request->type;
        $trim = 0;

        if ($type == 'M'){
            $cursor = DB::select("
                SELECT PRD_DESKRIPSIPENDEK,PRD_DESKRIPSIPANJANG,PRD_FRAC,PRD_UNIT,PRD_avgCOST,ST_avgCOST,
                        NVL(ST_PRDCD,'XXXXXXX') ST_PRDCD,Nvl(ST_SALDOAKHIR,0) ST_SALDOAKHIR, prd_kodeigr as hrgsatuan
                FROM TBMASTER_PRODMAST a
                LEFT JOIN TBMASTER_STOCK b ON prd_prdcd = st_prdcd and st_lokasi = '03' 
                where  PRD_PRDCD = '$kode'    
            ");

            if (!$cursor){
                $msg = "Kode Produk ". $kode. " Tidak Terdaftar!";

                return response()->json(['kode' => 0, 'msg' => $msg, 'data' => '']);
            }

            if ($cursor[0]->st_prdcd == 'XXXXXXX'){
                $msg = "Plu ". $kode. " Belum Melakukan Perubahan Status!";

                return response()->json(['kode' => 0, 'msg' => $msg, 'data' => $cursor]);
            } else {
                if ($cursor[0]->st_saldoakhir <= 0){
                    $msg = "Stock Barang Rusak PLU ". $kode. " <= 0";

                    return response()->json(['kode' => 0, 'msg' => $msg, 'data' => $cursor]);
                }

                if ($cursor[0]->st_avgcost == null || $cursor[0]->st_avgcost == 0){
                    $cursor[0]->hrgsatuan = $cursor[0]->prd_avgcost;
                } else {
                    if($cursor[0]->prd_unit == 'KG') {
                        $trim = $cursor[0]->prd_frac / 1000;
                    } else {
                        $trim = $cursor[0]->prd_frac;
                    }
                    $cursor[0]->hrgsatuan = $cursor[0]->st_avgcost * $trim;

                    return response()->json(['kode' => 1, 'msg' => '', 'data' => $cursor]);
                }
            }
        }
    }

    public function saveData(Request $request){
        $datas  = $request->datas;
        $date   = date('Y-M-d', strtotime($request->date));
        $noTrn  = $request->noDoc;
        $kodeigr= $_SESSION['kdigr'];
        $userid = $_SESSION['usid'];
        $today  = date('Y-m-d H:i:s');

//        *** Get Doc No ***
        $connect = oci_connect('SIMSMG', 'SIMSMG', '192.168.237.193:1521/SIMSMG');
        $query = oci_parse($connect, "BEGIN :ret := f_igr_get_nomor('$kodeigr','RSK','Nomor Pengeluaran Barang',
                            'RSK' || '$kodeigr' || TO_CHAR (SYSDATE, 'YY'),
							5,TRUE); END;");
        oci_bind_by_name($query, ':ret', $docNo, 32);
        oci_execute($query);

//        *** Search DocNo for Edit ***
        $getDoc = DB::table('tbtr_barangrusak')->where('rsk_nodoc', $noTrn)->first();


        if ($getDoc){
//                *** Update Data ***
            DB::table('tbtr_barangrusak')->where('rsk_nodoc', $noTrn)->delete();

            for ($i = 1; $i < sizeof($datas); $i++){
                $temp = $datas[$i];

                DB::table('tbtr_barangrusak')
                    ->insert(['rsk_kodeigr' => $kodeigr, 'rsk_recordid' => '', 'rsk_nodoc' => $getDoc->rsk_nodoc, 'rsk_tgldoc' => $date, 'rsk_seqno' => $i, 'rsk_prdcd' => $temp['plu'], 'rsk_qty' => $temp['qty'],
                        'rsk_hrgsatuan' => $temp['harga'], 'rsk_nilai' => $temp['total'], 'rsk_flag' => '1', 'rsk_keterangan' => strtoupper($temp['keterangan']), 'rsk_create_by' => $getDoc->rsk_create_by,
                        'rsk_create_dt' => $getDoc->rsk_create_dt, 'rsk_modify_by' => $userid, 'rsk_modify_dt' => $today]);
            }

            return response()->json(['kode' => 1, 'msg' => $getDoc->rsk_nodoc]);
        } else {
//              *** Insert Data ***
            for ($i = 1; $i < sizeof($datas); $i++){
                $temp = $datas[$i];

                DB::table('tbtr_barangrusak')
                    ->insert(['rsk_kodeigr' => $kodeigr, 'rsk_recordid' => '', 'rsk_nodoc' => $docNo, 'rsk_tgldoc' => $date, 'rsk_seqno' => $i, 'rsk_prdcd' => $temp['plu'], 'rsk_qty' => $temp['qty'],
                        'rsk_hrgsatuan' => $temp['harga'], 'rsk_nilai' => $temp['total'], 'rsk_flag' => '1', 'rsk_keterangan' => strtoupper($temp['keterangan']), 'rsk_create_by' => $userid, 'rsk_create_dt' => $today]);
            }

            return response()->json(['kode' => 1, 'msg' => $docNo]);
        }
    }

    public function deleteDocument(Request $request){
        $docNum = $request->docNum;

        DB::table('tbtr_barangrusak')->where('rsk_nodoc', $docNum)->delete();

        return response()->json(['kode' => 1, 'msg' => "Dokumen Berhasil dihapus!"]);
    }

    public function showAll(){
        $datas  = DB::select("
                SELECT PRD_DESKRIPSIPENDEK,PRD_DESKRIPSIPANJANG,PRD_FRAC,PRD_UNIT,PRD_avgCOST,ST_avgCOST,
                        NVL(ST_PRDCD,'XXXXXXX') ST_PRDCD,Nvl(ST_SALDOAKHIR,0) ST_SALDOAKHIR, prd_kodeigr as hrgsatuan
                FROM TBMASTER_PRODMAST a
                LEFT JOIN TBMASTER_STOCK b ON prd_prdcd = st_prdcd and st_lokasi = '03' 
                where  st_lokasi = '03' AND st_saldoakhir>0
            ");

        for ($i =0; $i<sizeof($datas);$i++){
            if ($datas[$i]->st_avgcost == null || $datas[$i]->st_avgcost == 0){
                $datas[$i]->hrgsatuan = $datas[$i]->prd_avgcost;
            } else {
                if($datas[$i]->prd_unit == 'KG') {
                    $trim = $datas[$i]->prd_frac / 1000;
                } else {
                    $trim = $datas[$i]->prd_frac;
                }
                $datas[$i]->hrgsatuan = $datas[$i]->st_avgcost * $trim;
            }
        }

        return response()->json($datas);
    }

    public function printDocument(Request $request){
        $noDoc      = $request->doc;
        $p_reprint  = 'Y';

        $cekStatusPrint = DB::table('tbtr_barangrusak')->where('rsk_nodoc', $noDoc)->first();

        if ($cekStatusPrint->rsk_recordid == '2' || $cekStatusPrint->rsk_recordid == '9'){
            $p_reprint = 'Y';
        } elseif ($cekStatusPrint->rsk_recordid == null) {
            $p_reprint = '';
        }

        $datas = DB::select("select PRS_NAMAPERUSAHAAN, cab_namacabang, cab_alamat2, nvl(rsk_recordid,'8') ,
                                              rsk_nodoc, rsk_tgldoc, rsk_prdcd, FLOOR(rsk_qty/prd_frac) qty, mod(rsk_qty,prd_frac) qtyk,rsk_hrgsatuan, rsk_nilai,
                                              rsk_keterangan, rap_store_manager,  rap_logistic_supervisor, rap_administrasi,
                                              prd_deskripsipanjang, prd_unit||'/'||prd_frac SATUAN, case when '$p_reprint' = 'Y' then 'REPRINT' else '' end reprint
                                    from tbmaster_perusahaan, tbmaster_cabang, tbtr_barangrusak, tbmaster_prodmast, tbmaster_report_approval
                                    where rsk_nodoc = '$noDoc'
                                              and prs_kodeigr = rsk_kodeigr
                                              and cab_kodecabang(+)=prs_kodecabang
                                              and cab_kodeigr(+)=prs_kodeigr
                                              and prd_prdcd(+)=rsk_prdcd
                                              and prd_kodeigr(+)=rsk_kodeigr
                                              and rap_kodeigr(+)=rsk_kodeigr
                                    order by rsk_seqno
");

//                Update rsk_recordid
        DB::table('tbtr_barangrusak')->where('rsk_nodoc', $noDoc)->whereNull('rsk_recordid')->update(['rsk_recordid' => '9']);

        $pdf = PDF::loadview('BACKOFFICE/TRANSAKSI/PEMUSNAHAN.barangRusak-laporan', ['datas' => $datas]);
        $pdf->output();
        $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);

        $canvas = $dompdf ->get_canvas();
        $canvas->page_text(514, 10, "Page {PAGE_NUM} of {PAGE_COUNT}", null, 10, array(0, 0, 0));

        return $pdf->stream('BACKOFFICE/TRANSAKSI/PEMUSNAHAN.BarangRusak-laporan');
    }



}

//query cetak report
//        $datas = DB::table('tbtr_barangrusak')->select('*')
//            ->leftJoin('tbmaster_cabang','cab_kodeigr', 'prs_kodeigr')
//            ->leftJoin('tbmaster_perusahaan', 'rsk_kodeigr', 'prs_kodeigr')
//            ->leftJoin('tbmaster_prodmast', 'prd_prdcd', 'rsk_prdcd')
//            ->leftJoin('tbmaster_report_approval', 'rap_kodeigr', 'rsk_kodeigr')
