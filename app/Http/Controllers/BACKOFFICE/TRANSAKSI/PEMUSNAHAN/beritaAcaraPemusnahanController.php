<?php

namespace App\Http\Controllers\BACKOFFICE\TRANSAKSI\PEMUSNAHAN;

use App\Http\Controllers\Auth\loginController;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller; use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use PDF;
use Yajra\DataTables\DataTables;
use DateTime;

class beritaAcaraPemusnahanController extends Controller
{
    public function index(){
        return view('BACKOFFICE.TRANSAKSI.PEMUSNAHAN.beritaAcaraPemusnahan');
    }

    public function getNoDocument(Request $request){
        $search = $request->value;

        $datas = DB::connection(Session::get('connection'))->table('tbtr_bpb_barangrusak')
            ->selectRaw("DISTINCT brsk_nodoc, brsk_noref, brsk_tgldoc, brsk_tglref")
            ->whereRaw("NVL(brsk_recordid,0) <> 1")
            ->where('brsk_nodoc','LIKE', '%'.$search.'%')
            ->orderByDesc('brsk_tgldoc')
            ->limit(100)
            ->get();

        return Datatables::of($datas)->make(true);
    }

    public function getNoPBBR(Request $request){
        $search = strtoupper($request->value);

        $datas  = DB::connection(Session::get('connection'))->select("SELECT DISTINCT rsk_nodoc, rsk_tgldoc, rsk_create_dt
           FROM tbtr_barangrusak, tbtr_bpb_barangrusak
          WHERE NVL(rsk_recordid, '8') = '9'
            AND NVL(brsk_flagdoc, '9') <> '1'
            AND brsk_noref(+) = rsk_nodoc
            AND rsk_nodoc like '%$search%'
        ORDER BY rsk_create_dt DESC, rsk_nodoc DESC");

        return Datatables::of($datas)->make(true);
    }

    public function chooseNoDocument(Request $request){
        $noDoc  = $request->val;

        $datas  = DB::connection(Session::get('connection'))->table('tbtr_bpb_barangrusak')
            ->select('BRSK_RECORDID', 'BRSK_FLAGDOC','brsk_nodoc','brsk_tgldoc','brsk_noref', 'brsk_tglref', 'brsk_prdcd', 'brsk_hrgsatuan', 'brsk_qty_rsk', 'brsk_qty_real', 'brsk_nilai', 'brsk_flagdoc', 'brsk_keterangan',
                'prd_deskripsipendek', 'prd_deskripsipanjang', 'prd_frac', 'prd_unit')
            ->leftJoin('tbmaster_prodmast', 'brsk_prdcd', 'prd_prdcd')
            ->where('brsk_nodoc', $noDoc)
            ->get()->toArray();

        if (!$datas){
            return response()->json(['kode' => 0, 'msg' => "Data Tidak Ada !!"]);
        } else {
            if ($datas[0]->brsk_recordid == '1'){
                $keterangan = '* BATAL *';
            } else {
                if ($datas[0]->brsk_flagdoc == 'P'){
                    $keterangan = '* DOKUMEN SUDAH DICETAK *';
                } else {
                    $keterangan = '* KOREKSI *';
                }
            }

            return response()->json(['kode' => 1, 'data' => $datas, 'keterangan' => $keterangan]);

        }
    }

    public function choosePBBR(Request $request){
        $noPBBR = $request->val;

        $datas  = DB::connection(Session::get('connection'))->table('tbtr_barangrusak')
            ->select('rsk_recordid', 'rsk_nodoc', 'rsk_tgldoc', 'rsk_seqno', 'rsk_prdcd', 'rsk_hrgsatuan', 'rsk_nilai', 'rsk_qty', 'rsk_keterangan', 'prd_frac', 'prd_deskripsipendek', 'prd_deskripsipanjang', 'prd_unit')
            ->leftJoin('tbmaster_prodmast', 'rsk_prdcd', 'prd_prdcd')
            ->where('rsk_nodoc', $noPBBR)
            ->get()->toArray();

        if (!$datas || $datas[0]->rsk_recordid != '9' ){
            return response()->json(['kode' => 0, 'msg' => "No Referensi Sudah Pernah Dipakai atau Belum Dicetak !!"]);
        } else {
            return response()->json(['kode' => 1, 'data' => $datas]);
        }
    }

    public function getNewNmrDoc(){
        $kodeigr = Session::get('kdigr');

        $connect = loginController::getConnectionProcedure();

        $query = oci_parse($connect, "BEGIN :ret := f_igr_get_nomor('$kodeigr','PMN','Nomor Pemusnahan Barang',
                            '8' || TO_CHAR (SYSDATE, 'YY'),
							5,FALSE); END;");
        oci_bind_by_name($query, ':ret', $result, 32);
        oci_execute($query);

        return response()->json($result);
    }

    public function saveData(Request $request){
        $datas  = $request->datas;
        $noDoc  = $request->doc;
        $tglDoc= Carbon::createFromFormat('d/m/Y', $request->tglDoc)->format('Y/m/d');
        $noPBBR = $request->pbbr;
        $tglPBBR= Carbon::createFromFormat('d/m/Y', $request->tglPBBR)->format('Y/m/d');
        $kodeigr= Session::get('kdigr');
        $userid = Session::get('usid');
        $today  = date('Y-m-d H:i:s');

//        Cek Available Doc
        $getDoc    = DB::connection(Session::get('connection'))->table('tbtr_bpb_barangrusak')->where('brsk_nodoc', $noDoc)->get()->toArray();

//        Get No DOC
        $connect = loginController::getConnectionProcedure();

        $query = oci_parse($connect, "BEGIN :ret := f_igr_get_nomor('$kodeigr','PMN','Nomor Pemusnahan Barang',
                            '8' || TO_CHAR (SYSDATE, 'YY'),
							5,TRUE); END;");
        oci_bind_by_name($query, ':ret', $newNoDoc, 32);
        oci_execute($query);

        if(!$getDoc){
//            *** Insert Data ***
            for ($i = 1; $i < sizeof($datas); $i++){
                $temp = $datas[$i];

                DB::connection(Session::get('connection'))->table('tbtr_bpb_barangrusak')
                    ->insert(['brsk_kodeigr' => $kodeigr, 'brsk_recordid' => '', 'brsk_nodoc' => $newNoDoc, 'brsk_tgldoc' => $tglDoc, 'brsk_noref' => $noPBBR, 'brsk_tglref' => $tglPBBR, 'brsk_seqno' => $i, 'brsk_prdcd' => $temp['plu'],
                        'brsk_qty_rsk' => $temp['qtyRsk'], 'brsk_hrgsatuan' => $temp['harga'], 'brsk_qty_real' => $temp['qtyReal'], 'brsk_nilai' => $temp['total'], 'brsk_flagdoc' => '1', 'brsk_keterangan' => strtoupper($temp['keterangan']), 'brsk_create_by' => $userid, 'brsk_create_dt' => $today]);
            }

//            Update tbtr_barangrusak (rsk_Record_id = '2')
            DB::connection(Session::get('connection'))->table('tbtr_barangrusak')->where('rsk_nodoc', $noPBBR)->update(['rsk_recordid' => '2', 'rsk_modify_by' => $userid, 'rsk_modify_dt' => $today]);

            return response()->json(['kode' => 1, 'msg' => $newNoDoc]);
        } else {
//            *** Update Data ***
            DB::connection(Session::get('connection'))->table('tbtr_bpb_barangrusak')->where('brsk_nodoc', $noDoc)->delete();

            for ($i = 1; $i < sizeof($datas); $i++){
                $temp = $datas[$i];

                DB::connection(Session::get('connection'))->table('tbtr_bpb_barangrusak')
                    ->insert(['brsk_kodeigr' => $kodeigr, 'brsk_recordid' => '', 'brsk_nodoc' => $noDoc, 'brsk_tgldoc' => $tglDoc, 'brsk_noref' => $noPBBR, 'brsk_tglref' => $tglPBBR, 'brsk_seqno' => $i, 'brsk_prdcd' => $temp['plu'],
                        'brsk_qty_rsk' => $temp['qtyRsk'], 'brsk_hrgsatuan' => $temp['harga'], 'brsk_qty_real' => $temp['qtyReal'], 'brsk_nilai' => $temp['total'], 'brsk_flagdoc' => '1', 'brsk_keterangan' => strtoupper($temp['keterangan']),
                        'brsk_create_by' => $getDoc[0]->brsk_create_by, 'brsk_create_dt' => $getDoc[0]->brsk_create_dt,'brsk_modify_by' => $userid, 'brsk_modify_dt' => $today]);
            }

            return response()->json(['kode' => 1, 'msg' => $noDoc]);
        }
    }

    public function printDocument(Request $request){
        $noDoc  = $request->doc;
        $ukuran = $request->ukuran;
        $kodeigr= Session::get('kdigr');
        $userid = Session::get('usid');
        $today  = date('Y-m-d H:i:s');


//        Get No Ref/PBBR
        $getNoPBBR  = DB::connection(Session::get('connection'))->table('tbtr_bpb_barangrusak')->select('brsk_tgldoc', 'brsk_noref', 'brsk_tglref')->where('brsk_nodoc', $noDoc)->first();

//        Cek Status New or Update
        $getDoc = DB::connection(Session::get('connection'))->table('tbtr_mstran_h')->where('msth_nodoc', $noDoc)->where('msth_noref3', $getNoPBBR->brsk_noref)->get()->toArray();

        if(!$getDoc){
//            Insert into tbtr_mstran_h
            DB::connection(Session::get('connection'))->table('tbtr_mstran_h')->insert(['msth_kodeigr' => $kodeigr, 'msth_typetrn' => 'F', 'msth_nodoc' => $noDoc, 'msth_tgldoc' => $getNoPBBR->brsk_tgldoc, 'msth_noref3' => $getNoPBBR->brsk_noref, 'msth_tgref3' => $getNoPBBR->brsk_tglref,
                'msth_flagdoc' => '1', 'msth_create_by' => $userid, 'msth_create_dt' => $today, 'msth_modify_by' => $userid, 'msth_modify_dt' => $today]);

//            Get prdcd to looping
            $prdcd  = DB::connection(Session::get('connection'))->table('tbtr_bpb_barangrusak')->select('*')->where('brsk_nodoc', $noDoc)->get()->toArray();

            for ($i = 0; $i < sizeof($prdcd); $i++){
                $plu = $prdcd[$i]->brsk_prdcd;
                $qty = $prdcd[$i]->brsk_qty_real;

//                Get Data to REC
                $rec    = DB::connection(Session::get('connection'))->select(" SELECT prd_kodesupplier, prd_kodedivisi,
                                                    prd_kodedepartement, prd_kodekategoribarang,
                                                    prd_flagbkp1, prd_unit, prd_frac, prd_kodetag,
                                                    prd_flagbkp2, st_saldoakhir, sup_kodesupplier,
                                                    sup_pkp, sup_top, NVL (st_avgcost, 0) st_avgcost,
                                                    st_lastcost
                                               FROM tbmaster_prodmast,
                                                           tbmaster_hargabeli,
                                                    tbmaster_supplier,
                                                    tbmaster_stock
                                              WHERE prd_prdcd = '$plu'
                                                AND hgb_kodeigr(+) = prd_kodeigr
                                                AND hgb_prdcd(+) = prd_prdcd
                                                AND hgb_tipe(+) = '2'
                                                AND sup_kodesupplier(+) = hgb_kodesupplier
                                                AND sup_kodeigr(+) = hgb_kodeigr
                                                AND st_prdcd = prd_prdcd
                                                AND st_kodeigr = prd_kodeigr
                                                AND st_lokasi = '03'
                                                ");

//                Call Procedure Update Stock
                $connect = loginController::getConnectionProcedure();
                $kode1   = '03';
                $kode2   = 'TRFOUT';
                $v_lok   = '';
                $v_msg   = '';

                $exec = oci_parse($connect, "BEGIN  sp_igr_update_stock2(:kodeigr,:kode1,:prdcd,:sup_kodesup,:kode2,:qty,:st_lastcost,:st_avgcost,:user,:v_lok,:v_message); END;"); //Procedure asli diganti ke varchar
                oci_bind_by_name($exec, ':kodeigr',$kodeigr);
                oci_bind_by_name($exec, ':kode1',$kode1);
                oci_bind_by_name($exec, ':prdcd',$plu);
                oci_bind_by_name($exec, ':sup_kodesup',$rec[0]->sup_kodesupplier);
                oci_bind_by_name($exec, ':kode2',$kode2);
                oci_bind_by_name($exec, ':qty',$qty);
                oci_bind_by_name($exec, ':st_lastcost',$rec[0]->st_lastcost);
                oci_bind_by_name($exec, ':st_avgcost',$rec[0]->st_avgcost);
                oci_bind_by_name($exec, ':user',$userid);
                oci_bind_by_name($exec, ':v_lok', $v_lok,10);
                oci_bind_by_name($exec, ':v_message', $v_msg,10000);
                oci_execute($exec);

//                Insert into tbtr_mstran_d
                if ($rec[0]->prd_unit == 'KG'){
                    $temp = $rec[0]->st_avgcost * 1;
                } else {
                    $temp = $rec[0]->st_avgcost * $rec[0]->prd_frac;
                }

                DB::connection(Session::get('connection'))->table('tbtr_mstran_d')->insert(['mstd_kodeigr' => $kodeigr, 'mstd_typetrn' => 'F', 'mstd_nodoc' => $noDoc, 'mstd_tgldoc' => $getNoPBBR->brsk_tgldoc,
                    'mstd_noref3' => $getNoPBBR->brsk_noref, 'mstd_tgref3' => $getNoPBBR->brsk_tglref, 'mstd_kodesupplier' => $rec[0]->sup_kodesupplier,
                    'mstd_pkp' => $rec[0]->sup_pkp, 'mstd_cterm' => $rec[0]->sup_top, 'mstd_seqno' => $i, 'mstd_prdcd' => $plu,
                    'mstd_kodedivisi' => $rec[0]->prd_kodedivisi, 'mstd_kodedepartement' => $rec[0]->prd_kodedepartement,
                    'mstd_kodekategoribrg' => $rec[0]->prd_kodekategoribarang, 'mstd_bkp' => $rec[0]->prd_flagbkp1,
                    'mstd_unit' => $rec[0]->prd_unit, 'mstd_frac' => $rec[0]->prd_frac, 'mstd_qty' => $qty,
                    'mstd_hrgsatuan' =>  $prdcd[$i]->brsk_hrgsatuan, 'mstd_gross' =>  $prdcd[$i]->brsk_nilai, 'mstd_fobkp' => $rec[0]->prd_flagbkp2,
                    'mstd_flagdisc1' => '3', 'mstd_ppnrph' => '0',
                    'mstd_avgcost' => $temp,
                    'mstd_ocost' => $temp,
                    'mstd_keterangan' => $prdcd[$i]->brsk_keterangan, 'mstd_kodetag' => $rec[0]->prd_kodetag, 'mstd_create_by' => $userid,
                    'mstd_create_dt' => $today, 'mstd_modify_by' => $userid, 'mstd_modify_dt' => $today,
                    'mstd_posqty' => $rec[0]->st_saldoakhir]);
            }

        }

//         Update tbTr_Barang_Rusak [TRBR_RECORDID = '2']
        DB::connection(Session::get('connection'))->table('tbtr_barangrusak')
            ->where('rsk_kodeigr', $kodeigr)->where('rsk_nodoc', $getNoPBBR->brsk_noref)
            ->update(['rsk_recordid' => '2']);

        DB::connection(Session::get('connection'))->table('tbtr_bpb_barangrusak')
            ->where('brsk_kodeigr', $kodeigr)->where('brsk_nodoc', $noDoc)
            ->update(['brsk_flagdoc' => 'P']);


//        Get Data to Print
        $perusahaan = DB::connection(Session::get('connection'))->table('tbmaster_perusahaan')->first();
        $data = DB::connection(Session::get('connection'))->table('tbtr_bpb_barangrusak')
            ->select('prs_namaperusahaan', 'prs_namacabang', 'prs_alamat1', 'prs_alamat3', 'prs_npwp', 'prs_namawilayah', 'brsk_prdcd', 'brsk_qty_real', 'brsk_hrgsatuan', 'brsk_nilai',
                                'brsk_keterangan', 'brsk_noref', 'brsk_nodoc', 'brsk_tgldoc', 'brsk_flagdoc', 'prd_deskripsipanjang', 'prd_unit', 'prd_frac', 'rap_store_manager', 'rap_store_adm', 'rap_logistic_supervisor','rap_stockkeeper_ii')
            ->leftJoin('tbmaster_perusahaan', 'prs_kodeigr', 'brsk_kodeigr')
            ->leftJoin('tbmaster_prodmast', 'prd_prdcd', 'brsk_prdcd')
            ->leftJoin('tbmaster_report_approval', 'rap_kodeigr', 'brsk_kodeigr')
            ->where('brsk_nodoc', $noDoc)
            ->orderBy('brsk_seqno')
            ->get()->toArray();

//        $pdf = PDF::loadview('BACKOFFICE.TRANSAKSI.PEMUSNAHAN.BAPemusnahan-laporan', ['data' => $data, 'perusahaan' => $perusahaan]);
//        $pdf->output();
//        $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);
//
//        $canvas = $dompdf ->get_canvas();
//        $canvas->page_text(507, 77.75, "Page {PAGE_NUM} of {PAGE_COUNT}", null, 7, array(0, 0, 0));
//
//        return $pdf->stream('BApemusnahan-laporan.pdf');

        return view('BACKOFFICE.TRANSAKSI.PEMUSNAHAN.BAPemusnahan-laporan', ['data' => $data, 'perusahaan' => $perusahaan, 'ukuran' => $ukuran]);
    }

}
