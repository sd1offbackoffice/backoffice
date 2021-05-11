<?php
/**
 * Created by PhpStorm.
 * User: ryan
 * Date: 1/12/2021
 * Time: 3:25 PM
 */

namespace App\Http\Controllers\BACKOFFICE\TRANSAKSI\REPACKING;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use PDF;
use Yajra\DataTables\DataTables;

class repackController extends Controller
{

    public function index()
    {
        return view('BACKOFFICE/TRANSAKSI/REPACKING.repack');
    }

    public function getNewNmrTrn(){
        $kodeigr = $_SESSION['kdigr'];
//        $ip = LPAD(Substr(SUBSTR(:global.IP,-3),INSTR(SUBSTR(:global.IP,-3),'.')+1,3),3,'0');
        //$_SESSION['ip'] = "172.20.28.123";

        //Bila ip nya 3 digit, +1 nya dihapus
        $ip =str_pad(substr(substr($_SESSION['ip'],-3),strpos(substr($_SESSION['ip'],-3)+1,'.'),3),3,'0',STR_PAD_LEFT);


        $connect = oci_connect('SIMSMG', 'SIMSMG', '192.168.237.193:1521/SIMSMG');

        $query = oci_parse($connect, "BEGIN :ret := f_igr_get_nomor('$kodeigr','PCK',
									                       'Nomor Packing',
				                                 '$ip'||'PC',
				                                 5,
				                                 FALSE); END;");
        oci_bind_by_name($query, ':ret', $noDoc, 32);
        oci_execute($query);

        $query = oci_parse($connect, "BEGIN :ret := f_igr_get_nomorstadoc ('$kodeigr',
									                       'RPK',
									                       'Refferensi Nomor Packing',
				                                 '$ip'||'RP',
				                                 5,
	                                       FALSE); END;");
        oci_bind_by_name($query, ':ret', $noReff, 32);
        oci_execute($query);


       // dd($_SESSION['ip']);
        //dd($request->getClientIps());
        return response()->json(['noDoc' => $noDoc, 'noReff' => $noReff, 'model' => '* TAMBAH *']);
    }

    public function chooseTrn(Request $request){
        $kode = $request->kode;
        $kodeigr = $_SESSION['kdigr'];

//        $cursor = DB::select("
//            SELECT * FROM tbTr_BackOffice
//		             WHERE TRBO_KodeIGR = '.$kodeigr'
//		                   AND TRBO_NODOC = '$kode'
//		                   AND TRBO_TYPETRN = 'P'
//		             ORDER BY TRBO_SEQNO
//        ");
        $cursor = DB::table('tbTr_BackOffice')
            ->selectRaw('TRBO_NODOC')
            ->selectRaw('TRBO_TGLDOC')
            ->selectRaw('trbo_noreff')
            ->selectRaw('trbo_tglreff')
            ->selectRaw('trbo_keterangan')
            ->selectRaw('trbo_flagdisc3')
            ->selectRaw('trbo_flagdisc2')
            ->selectRaw('trbo_flagdoc')
            ->selectRaw("CASE WHEN TRBO_FLAGDOC='*' THEN TRBO_NONOTA ELSE 'Belum Cetak Nota' END NOTA")

            ->selectRaw('trbo_flagdisc1')
            ->selectRaw('trbo_prdcd')
            ->selectRaw('PRD_DESKRIPSIPENDEK')
            ->selectRaw('PRD_DESKRIPSIPANJANG')
            ->selectRaw('PRD_FRAC')
            ->selectRaw('PRD_UNIT')
            ->selectRaw('PRD_KODETAG')
            ->selectRaw('TRBO_QTY')
            ->selectRaw('ST_SALDOAKHIR')
            ->selectRaw('PRD_FLAGBKP1')
            ->selectRaw('trbo_hrgsatuan')
            ->selectRaw('trbo_averagecost')
            ->selectRaw('trbo_gross')
            ->selectRaw('trbo_ppnrph')

            ->LeftJoin('TBMASTER_PRODMAST',function($join){
                $join->on('TRBO_PRDCD','PRD_PRDCD');
                $join->on('TRBO_KODEIGR','PRD_KODEIGR');
            })

            ->LeftJoin('TBMASTER_STOCK',function($join){
                $join->on('PRD_PRDCD','ST_PRDCD');
                $join->on('PRD_KODEIGR','ST_KODEIGR');
            })

            ->where('ST_LOKASI','=','01')
            ->where('TRBO_TYPETRN','=','P')
            ->where('TRBO_NODOC','=', $kode)
            ->where('TRBO_KodeIGR','=', $kodeigr)
            ->orderBy('TRBO_SEQNO')
            ->get();

        return response()->json($cursor);

    }

    public function ModalNmrTrn(Request $request){

        $datas = DB::table('tbTr_BackOffice')
            ->selectRaw('distinct TRBO_NODOC as TRBO_NODOC')
            ->selectRaw('TRBO_TGLDOC')
            ->selectRaw("CASE WHEN TRBO_FLAGDOC='*' THEN TRBO_NONOTA ELSE 'Belum Cetak Nota' END NOTA")
            ->where('TRBO_TYPETRN','=','P')
            ->orderByDesc('TRBO_NODOC')
            ->limit(100)
            ->get();

        return Datatables::of($datas)->make(true);
    }

    public function getNmrTrn(Request $request){
        $search = $request->val;

        $datas = DB::table('tbTr_BackOffice')
            ->selectRaw('distinct TRBO_NODOC as TRBO_NODOC')
            ->selectRaw('TRBO_TGLDOC')
            ->selectRaw("CASE WHEN TRBO_FLAGDOC='*' THEN TRBO_NONOTA ELSE 'Belum Cetak Nota' END NOTA")
            ->where('TRBO_TYPETRN','=','P')
            ->where('TRBO_NODOC','=', $search)
            ->first();

        return response()->json($datas);
    }

    public function deleteTrn(Request $request){
        $data = $request->val;
        try{
            DB::beginTransaction();
            DB::table('tbTr_BackOffice')
                ->where('TRBO_NODOC','=',$data)
                ->where('TRBO_TYPETRN','=','P')
                ->delete();
            DB::commit();
            return response()->json(['kode' => 1]);
        }catch(\Exception $e){
            return response()->json(['kode' => 2]);
        }
    }

    public function getPlu(Request $request){
        $kodeigr = $_SESSION['kdigr'];
        $search = $request->val;

        $datas = DB::table('TBMASTER_PRODMAST')
            ->selectRaw('PRD_DESKRIPSIPANJANG')
            ->selectRaw('PRD_PRDCD')
            ->selectRaw("PRD_UNIT||'/'||TO_CHAR(PRD_FRAC) SATUAN")

            ->whereRaw("SUBSTR(PRD_PRDCD,7,1)='0'")
            ->whereRaw("nvl(prd_recordid,'9')<>'1'")

            ->LeftJoin('TBMASTER_STOCK',function($join){
                $join->on('PRD_PRDCD','ST_PRDCD');
                $join->on('PRD_KODEIGR','PRD_KODEIGR');
            })
            ->where('ST_LOKASI','=','01')

            ->whereRaw("(prd_deskripsipanjang LIKE '%". $search."%' or prd_prdcd LIKE '%". $search."%')")
            ->where('prd_kodeigr', '=', $kodeigr)
            ->orderBy('prd_deskripsipanjang')
            ->limit(100)->get();

        return response()->json($datas);
    }

    public function ModalPlu(){
        $kodeigr = $_SESSION['kdigr'];

        $datas = DB::table('TBMASTER_PRODMAST')
            ->selectRaw('PRD_DESKRIPSIPANJANG')
            ->selectRaw('PRD_PRDCD')
            ->selectRaw("PRD_UNIT||'/'||TO_CHAR(PRD_FRAC) SATUAN")

            ->whereRaw("SUBSTR(PRD_PRDCD,7,1)='0'")
            ->whereRaw("nvl(prd_recordid,'9')<>'1'")

            ->LeftJoin('TBMASTER_STOCK',function($join){
                $join->on('PRD_PRDCD','ST_PRDCD');
                $join->on('PRD_KODEIGR','PRD_KODEIGR');
            })
            ->where('ST_LOKASI','=','01')

            ->where('prd_kodeigr', '=', $kodeigr)
            ->orderBy('prd_deskripsipanjang')
            ->limit(100)->get();

        return Datatables::of($datas)->make(true);
    }

    public function choosePlu(Request $request){
        $kodeigr = $_SESSION['kdigr'];
        $kode = $request->kode;

//        $cursor = DB::select("
//            SELECT PRD_PRDCD,PRD_DESKRIPSIPENDEK,PRD_DESKRIPSIPANJANG,PRD_FRAC,PRD_UNIT,PRD_KODETAG,PRD_AVGCOST,nvl(ST_AVGCOST,0) lcostst,PRD_FLAGBKP1,nvl(ST_SALDOAKHIR,0) trbo_stokqty
//            FROM TBMASTER_PRODMAST,TBMASTER_STOCK
//            WHERE PRD_KODEIGR = ST_KODEIGR(+) AND
//                      PRD_PRDCD = ST_PRDCD(+) AND
//                      PRD_KODEIGR = '$kodeigr' AND
//                      ST_LOKASI(+)='01' AND PRD_PRDCD='$kode'
//        ");

        $cursor = DB::table('TBMASTER_PRODMAST')
            ->selectRaw('PRD_DESKRIPSIPENDEK')
            ->selectRaw('PRD_DESKRIPSIPANJANG')
            ->selectRaw('PRD_FRAC')
            ->selectRaw('PRD_UNIT')
            ->selectRaw('PRD_KODETAG')
            ->selectRaw('PRD_AVGCOST')
            ->selectRaw('nvl(ST_AVGCOST,0) lcostst')
            ->selectRaw('PRD_FLAGBKP1')
            ->selectRaw('nvl(ST_SALDOAKHIR,0) trbo_stokqty')

            ->LeftJoin('TBMASTER_STOCK',function($join){
                $join->on('PRD_PRDCD','ST_PRDCD');
                $join->on('PRD_KODEIGR','PRD_KODEIGR');
            })

            ->where('PRD_PRDCD','=',$kode)
            ->where('PRD_KODEIGR','=',$kodeigr)
            ->where('ST_LOKASI','=','01')

            ->first();
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
            DB::beginTransaction();
            //Start here
            $userid = $_SESSION['usid'];
            $kodeigr = $_SESSION['kdigr'];

            $nomorTrn = $request->nomorTrn;
            $today  = date('Y-m-d H:i:s');
            $tanggalTrn = date("Y-m-d", strtotime($request->tanggalTrn));
            $keterangan = $request->keterangan;
            $trbo_flagdisc3 = $request->trbo_flagdisc3; //ini perubahan Plu, nilainya Y atau kosong
            $trbo_flagdisc2 = $request->trbo_flagdisc2; // ini group_option pre-packing(P) atau re-packing(R)
            $noReff = $request->noReff;
            //$tglReff = date("Y-d-m", strtotime($request->tglReff));
            //$flagdoc = $request->statusPrint; //belum tau ambil dari mana, seharusnya lihat data model untuk tau inputnya, kalau masih belum di print berarti koreksi, input kosong, kalau sudah di print kasih simbol *, dan kalau sudah print ga bisa di update
            $datas = $request->datas;

            $check = DB::table('tbTr_BackOffice')
                ->selectRaw("*")
                ->where('TRBO_NODOC','=',$nomorTrn)
                ->where('TRBO_TYPETRN','=','P')
                ->where('TRBO_KODEIGR','=',$kodeigr)
                ->first();

            if($check){
                //update data
                $crDate = $check->trbo_create_dt;
                $creator = $check->trbo_create_by;
                $flagdoc = $check->trbo_flagdoc;
                DB::table('tbTr_BackOffice')
                    ->where('TRBO_NODOC','=',$nomorTrn)
                    ->where('TRBO_TYPETRN','=','P')
                    ->where('ST_KODEIGR','=',$kodeigr)
                    ->delete();
                for ($i = 1; $i < sizeof($datas); $i++){
                    $temp = $datas[$i];
                    if($temp['flagdisc1'] === 'R'){
                        $noReff2 = $noReff;
                    }else{
                        $noReff2 = $nomorTrn;
                    }
                    //
                    DB::table('tbTr_BackOffice')
                        ->where('TRBO_NODOC','=',$nomorTrn)
                        ->where('TRBO_TYPETRN','=','P')
                        ->where('ST_KODEIGR','=',$kodeigr)
                        ->where('TRBO_PRDCD','=',$temp['plu'])
                        ->insert(['TRBO_KODEIGR' => $kodeigr, 'TRBO_TYPETRN' => 'P','TRBO_NODOC' => $nomorTrn, 'TRBO_TGLDOC' => $tanggalTrn, 'TRBO_NOREFF' => $noReff2,
                            'TRBO_TGLREFF' => $tanggalTrn, 'TRBO_SEQNO' => $i, 'TRBO_PRDCD' => $temp['plu'], 'TRBO_QTY' => $temp['qty'], 'TRBO_HRGSATUAN' => $temp['hrgsatuan'],
                            'TRBO_FLAGDISC1' => $temp['flagdisc1'], 'TRBO_FLAGDISC2' => $trbo_flagdisc2,'TRBO_FLAGDISC3' => $trbo_flagdisc3, 'TRBO_GROSS' => $temp['gross'], 'TRBO_PPNRPH' => $temp['ppn'],
                            'TRBO_AVERAGECOST' => $temp['averagecost'], 'TRBO_KETERANGAN' => $keterangan,'TRBO_FLAGDOC' => $flagdoc, 'TRBO_CREATE_BY' => $creator, 'TRBO_CREATE_DT' => $crDate, 'TRBO_STOKQTY' => $temp['stokqty'],
                            'TRBO_MODIFY_BY' => $userid, 'TRBO_MODIFY_DT' => $today]);
                }
            }else{
                //create new save data
                $connect = oci_connect('SIMSMG', 'SIMSMG', '192.168.237.193:1521/SIMSMG');
                $ip =str_pad(substr(substr($_SESSION['ip'],-3),strpos(substr($_SESSION['ip'],-3),'.')+1,3),3,'0',STR_PAD_LEFT);
                $query = oci_parse($connect, "BEGIN :ret := f_igr_get_nomor('$kodeigr','PCK',
									                       'Nomor Packing',
				                                 '$ip'||'PC',
				                                 5,
				                                 TRUE); END;");
                oci_bind_by_name($query, ':ret', $noDoc, 32);
                oci_execute($query);

                $query = oci_parse($connect, "BEGIN :ret := f_igr_get_nomorstadoc ('$kodeigr',
									                       'RPK',
									                       'Refferensi Nomor Packing',
				                                 '$ip'||'RP',
				                                 5,
	                                       TRUE); END;");
                oci_bind_by_name($query, ':ret', $noReff, 32);
                oci_execute($query);

                for ($i = 1; $i < sizeof($datas); $i++){
                    $temp = $datas[$i];
                    if($temp['flagdisc1'] === 'R'){
                        $noReff2 = $noReff;
                    }else{
                        $noReff2 = $nomorTrn;
                    }
                    DB::table('tbTr_BackOffice')
                        ->insert(['TRBO_KODEIGR' => $kodeigr, 'TRBO_TYPETRN' => 'P','TRBO_NODOC' => $nomorTrn, 'TRBO_TGLDOC' => $tanggalTrn, 'TRBO_NOREFF' => $noReff2,
                            'TRBO_TGLREFF' => $tanggalTrn, 'TRBO_SEQNO' => $i, 'TRBO_PRDCD' => $temp['plu'], 'TRBO_QTY' => $temp['qty'], 'TRBO_HRGSATUAN' => $temp['hrgsatuan'],
                            'TRBO_FLAGDISC1' => $temp['flagdisc1'], 'TRBO_FLAGDISC2' => $trbo_flagdisc2,'TRBO_FLAGDISC3' => $trbo_flagdisc3, 'TRBO_GROSS' => $temp['gross'], 'TRBO_PPNRPH' => $temp['ppn'],
                            'TRBO_AVERAGECOST' => $temp['averagecost'], 'TRBO_KETERANGAN' => $keterangan,'TRBO_FLAGDOC' => '0', 'TRBO_CREATE_BY' => $userid, 'TRBO_CREATE_DT' => $today, 'TRBO_STOKQTY' => $temp['stokqty']]);
                }
            }
            DB::commit();
        }catch(\Exception $e){
            //dd($e);
        }
    }

    public function print(Request $request){
        try{
            DB::beginTransaction();

            $userid = $_SESSION['usid'];
            $kodeigr = $_SESSION['kdigr'];
            $today  = date('Y-m-d H:i:s');

            $nomorTrn = $request->nomorTrn;
//            $flagdoc = $request->flagdoc;
//            $datas = $request->datas;

            $totalA = DB::select("SELECT Sum(Case trbo_flagdisc1 When 'P' Then trbo_qty*(trbo_hrgsatuan/nvl(prd_frac,1)) Else 0 End) a FROM tbTr_BackOffice, tbmaster_prodmast WHERE trbo_kodeigr=prd_kodeigr and trbo_prdcd=prd_prdcd and trbo_kodeigr = '$kodeigr' and trbo_nodoc = '$nomorTrn'");
            $totalB = DB::select("SELECT Sum(Case trbo_flagdisc1 When 'R' Then trbo_qty*(prd_hrgjual/nvl(prd_frac,1)) Else 0 End) b FROM tbTr_BackOffice, tbmaster_prodmast WHERE trbo_kodeigr=prd_kodeigr and trbo_prdcd=prd_prdcd and trbo_kodeigr = '$kodeigr' and trbo_nodoc = '$nomorTrn'");

            $datas = DB::table('tbTr_BackOffice')
                ->selectRaw("trbo_flagdoc")
                ->selectRaw("trbo_flagdisc1")
                ->selectRaw("trbo_prdcd")
                //->selectRaw("trbo_kodesupplier") //di program sebelumnya tidak menemukan sumber trbo_kodesupplier
                ->where("trbo_kodeigr",'=',$kodeigr)
                ->where("trbo_nodoc",'=',$nomorTrn)
                ->get();

//            $totalA = DB::table('tbTr_BackOffice')
//                ->selectRaw("Sum(Case trbo_flagdisc1 When 'P' Then trbo_qty*(trbo_hrgsatuan/nvl(prd_frac,1)) Else 0 End) totalA")
//                ->LeftJoin('tbmaster_prodmast',function($join){
//                    $join->on('trbo_kodeigr','prd_kodeigr');
//                    $join->on('trbo_prdcd','prd_prdcd');
//                })
//                ->where("trbo_kodeigr",'=',$kodeigr)
//                ->where("trbo_nodoc",'=',$nomorTrn)
//                ->get();
            $frac = 1;

//            if($flagdoc == '0'){
//                for ($i = 1; $i < sizeof($datas); $i++){
//                    $temp = $datas[$i];
//                    $plu = $datas['plu'];
//
//                    $rec = DB::table("SELECT * FROM tbMaster_Prodmast WHERE PRD_KODEIGR='$kodeigr' AND PRD_PRDCD = '$plu'");
//
//                    $frac = $rec[0]->prd_frac;
//                    $jualprd = $rec[0]->prd_hrgjual;
//                }
//            }
            //-------------->>> Sepertinya yang bawah ini ga pakai, karena sepertinya status flagdoc yang benar hanya ada 0 atau *, 0 berarti belum di print, * berarti sudah di print
//            $frac = [];
//            $jualPRD = [];
//            if($datas[0]->trbo_flagdoc == '0'){
//                for ($i = 0; $i < sizeof($datas); $i++){
//                    $plu = $datas[$i]->trbo_prdcd;
//                    $rec = DB::SELECT("SELECT * FROM tbMaster_Prodmast WHERE PRD_KODEIGR='$kodeigr' AND PRD_PRDCD = '$plu'");
//                    $frac[$i] = $rec[0]->prd_frac;
//                    $jualPRD[$i] = $rec[0]->prd_hrgjual;
//                }
//                for ($i = 0; $i < sizeof($datas); $i++) {
//                    $plu = $datas[$i]->trbo_prdcd;
//                    if($datas[$i]->trbo_flagdisc1 == 'R'){
//                        DB::table("TBTR_BACKOFFICE")
//                            ->where("TRBO_NODOC",'=',$nomorTrn)
//                            ->where("TRBO_KODEIGR",'=',$kodeigr)
//                            ->where("TRBO_PRDCD",'=',$plu)
//                            ->where("TRBO_FLAGDISC1",'=','R')
//                            ->update(['TRBO_FLAGDOC' => '1', 'TRBO_MODIFY_BY' => $userid, 'TRBO_MODIFY_DT' => $today]);
//                    }else{
//                        DB::table("TBTR_BACKOFFICE")
//                            ->where("TRBO_NODOC",'=',$nomorTrn)
//                            ->where("TRBO_KODEIGR",'=',$kodeigr)
//                            ->where("TRBO_PRDCD",'=',$plu)
//                            ->where("TRBO_FLAGDISC1",'=','P')
//                            ->update(['TRBO_FLAGDOC' => '1']);
//                    }
//                }
//
//            }

            self::simpan($request);
            DB::commit();


        }catch(\Exception $e){
        }


    }

    public function printDocument(Request $request){
        $noDoc      = $request->doc;
        $kodeigr = $_SESSION['kdigr'];

        $today  = date('Y-m-d');

        $flagdoc = DB::table('tbTr_BackOffice')
            ->selectRaw("trbo_flagdoc")
            ->selectRaw("trbo_nonota")
            ->where("trbo_kodeigr",'=',$kodeigr)
            ->where("trbo_nodoc",'=',$noDoc)
            ->orderBy('TRBO_SEQNO')
            ->first();

        if($flagdoc->trbo_flagdoc == '0'){
            $RePrint = '';
        }else{
            $RePrint = 'Re-Print';
        }
        $nodocPrint = $flagdoc->trbo_nonota;

        $datas = DB::select("SELECT MSTH_NODOC, MSTH_TGLDOC, MSTH_NOPO, MSTH_KETERANGAN_HEADER, MSTD_FLAGDISC1,
              MSTD_PRDCD, MSTD_UNIT, MSTD_FRAC, MSTD_HRGSATUAN, MSTD_GROSS, MSTD_PPNRPH, MSTD_PPNBMRPH, MSTD_PPNBTLRPH,
              ( MSTD_GROSS + nvl(MSTD_PPNRPH,0) + nvl(MSTD_PPNBMRPH,0) + nvl(MSTD_PPNBTLRPH,0) ) AS TOTAL,
              FLOOR(MSTD_QTY/MSTD_FRAC) AS CTN, MOD(MSTD_QTY,MSTD_FRAC) AS PCS,
              CASE WHEN MSTD_FLAGDISC1 = 'P' THEN '### BARANG BELUM DIOLAH ###' ELSE '### BARANG SUDAH DIOLAH ###' END AS JUDUL,
              PRD_DESKRIPSIPANJANG,PRS_NAMAPERUSAHAAN, PRS_NAMACABANG, PRS_ALAMAT1, PRS_NAMAWILAYAH, PRS_NPWP, PRS_TELEPON
FROM TBTR_MSTRAN_H,  TBTR_MSTRAN_D, TBMASTER_PRODMAST, TBMASTER_PERUSAHAAN
WHERE MSTH_KODEIGR = '$kodeigr'
               AND MSTH_NODOC IN '$nodocPrint' AND MSTH_TYPETRN = 'P'
               AND MSTD_KODEIGR = MSTH_KODEIGR  AND MSTD_NODOC = MSTH_NODOC
               AND PRD_KODEIGR = MSTH_KODEIGR AND PRD_PRDCD = MSTD_PRDCD
               AND PRS_KODEIGR = MSTH_KODEIGR
ORDER BY MSTH_NODOC, MSTD_FLAGDISC1
");
        //dd($datas);

                //-------------------------PRINT-----------------------------
        $pdf = PDF::loadview('BACKOFFICE\TRANSAKSI\REPACKING.repack-laporan', ['datas' => $datas, 'today' => $today, 'RePrint' => $RePrint]);
        $pdf->output();
        $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);

        $canvas = $dompdf ->get_canvas();
        $canvas->page_text(514, 10, "Page {PAGE_NUM} of {PAGE_COUNT}", null, 10, array(0, 0, 0));

        return $pdf->stream('BACKOFFICE\TRANSAKSI\REPACKING.repack-laporan');

    }
    public function printDocumentKecil(Request $request){
        $noDoc      = $request->doc;
        $kodeigr = $_SESSION['kdigr'];

        $today  = date('Y-m-d');

        $flagdoc = DB::table('tbTr_BackOffice')
            ->selectRaw("trbo_flagdoc")
            ->selectRaw("trbo_nonota")
            ->where("trbo_kodeigr",'=',$kodeigr)
            ->where("trbo_nodoc",'=',$noDoc)
            ->orderBy('TRBO_SEQNO')
            ->first();

        if($flagdoc->trbo_flagdoc == '0'){
            $RePrint = '';
        }else{
            $RePrint = 'Re-Print';
        }
        $nodocPrint = $flagdoc->trbo_nonota;

        $datas = DB::select("SELECT MSTH_NODOC, MSTH_TGLDOC, MSTH_NOPO, MSTH_KETERANGAN_HEADER, MSTD_FLAGDISC1,
              MSTD_PRDCD, MSTD_UNIT, MSTD_FRAC, MSTD_HRGSATUAN, MSTD_GROSS, MSTD_PPNRPH, MSTD_PPNBMRPH, MSTD_PPNBTLRPH,
              ( MSTD_GROSS + nvl(MSTD_PPNRPH,0) + nvl(MSTD_PPNBMRPH,0) + nvl(MSTD_PPNBTLRPH,0) ) AS TOTAL,
              FLOOR(MSTD_QTY/MSTD_FRAC) AS CTN, MOD(MSTD_QTY,MSTD_FRAC) AS PCS,
              CASE WHEN MSTD_FLAGDISC1 = 'P' THEN '### BARANG BELUM DIOLAH ###' ELSE '### BARANG SUDAH DIOLAH ###' END AS JUDUL,
              PRD_DESKRIPSIPANJANG,PRS_NAMAPERUSAHAAN, PRS_NAMACABANG, PRS_ALAMAT1, PRS_NAMAWILAYAH, PRS_NPWP, PRS_TELEPON
FROM TBTR_MSTRAN_H,  TBTR_MSTRAN_D, TBMASTER_PRODMAST, TBMASTER_PERUSAHAAN
WHERE MSTH_KODEIGR = '$kodeigr'
               AND MSTH_NODOC IN '$nodocPrint' AND MSTH_TYPETRN = 'P'
               AND MSTD_KODEIGR = MSTH_KODEIGR  AND MSTD_NODOC = MSTH_NODOC
               AND PRD_KODEIGR = MSTH_KODEIGR AND PRD_PRDCD = MSTD_PRDCD
               AND PRS_KODEIGR = MSTH_KODEIGR
ORDER BY MSTH_NODOC, MSTD_FLAGDISC1
");
        //dd($datas);

        //-------------------------PRINT-----------------------------
        $pdf = PDF::loadview('BACKOFFICE\TRANSAKSI\REPACKING.repack-laporan-kecil', ['datas' => $datas, 'today' => $today, 'RePrint' => $RePrint]);
        $pdf->output();
        $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);

        $canvas = $dompdf ->get_canvas();
        $canvas->page_text(514, 10, "Page {PAGE_NUM} of {PAGE_COUNT}", null, 10, array(0, 0, 0));

        return $pdf->stream('BACKOFFICE\TRANSAKSI\REPACKING.repack-laporan-kecil');

    }

    public function simpan(Request $request){
        try{
            DB::beginTransaction();

            $nomorTrn = $request->nomorTrn;
            $noReff = $request->noReff;
            $keterangan = $request->keterangan;
            $userid = $_SESSION['usid'];
            $kodeigr = $_SESSION['kdigr'];
            $today  = date('Y-m-d H:i:s');

            $vplulama = null;

            $datas = DB::table('tbTr_BackOffice')
                ->selectRaw("trbo_flagdoc")
                ->selectRaw("trbo_flagdisc1")
                ->selectRaw("trbo_flagdisc3")
                ->selectRaw("trbo_prdcd")
                ->selectRaw("trbo_seqno")
                ->selectRaw("trbo_qty")
                ->selectRaw("trbo_hrgsatuan")
                ->selectRaw("trbo_gross")
                ->selectRaw("trbo_ppnrph")
                ->selectRaw("trbo_ppnbmrph")
                ->selectRaw("trbo_ppnbtlrph")
                ->selectRaw("trbo_oldcost")
                ->selectRaw("trbo_qtybonus1")
                ->selectRaw("trbo_tgldoc")
                ->where("trbo_kodeigr",'=',$kodeigr)
                ->where("trbo_nodoc",'=',$nomorTrn)
                ->orderBy('TRBO_SEQNO')
                ->get();

            if($datas[0]->trbo_flagdoc == '0'){ //ubah kembali jadi == 0 nanti! kalau mau coba" fungsi ini == diubah jadi !=    , jangan coba" kalau bukan simulasi wkwkwkwkwk
                $connect = oci_connect('SIMSMG', 'SIMSMG', '192.168.237.193:1521/SIMSMG');

                $query = oci_parse($connect, "BEGIN :ret := f_igr_get_nomor('$kodeigr',
                            'RPC',
                            'Nomor RePacking',
                            '5R' || TO_CHAR(SYSDATE, 'yy'),
                            4,
                            TRUE); END;");
                oci_bind_by_name($query, ':ret', $v_nodoc, 32);
                oci_execute($query);


                $nodocprint = $v_nodoc;

                $prdcd_cur = DB::table('tbmaster_prodmast')
                    ->selectRaw("prd_kodedivisi")
                    ->selectRaw("prd_kodedepartement")
                    ->selectRaw("prd_kodekategoribarang")
                    ->selectRaw("prd_kodetag")
                    ->selectRaw("prd_unit")
                    ->selectRaw("prd_frac")
                    ->selectRaw("prd_lastcost")
                    ->selectRaw("prd_avgcost")
                    ->selectRaw("prd_hrgjual")
                    ->selectRaw("prd_flagbkp1")
                    ->selectRaw("prd_flagbkp2")
                    ->selectRaw("prd_flaggudang")
                    ->selectRaw("CASE WHEN NVL(prd_minorder, 0) = 0 THEN prd_isibeli ELSE prd_minorder END minord")
                    ->selectRaw("NVL(st_saldoakhir, 0) st_saldoakhir")
                    ->selectRaw("NVL(st_avgcost, 0) st_avgcost")
                    ->selectRaw("NVL(st_lastcost, 0) st_lastcost")

                    ->LeftJoin('tbmaster_stock',function($join){
                        $join->on('prd_kodeigr','st_kodeigr');
                        $join->on('prd_prdcd','st_prdcd');
                    })

                    ->LeftJoin('tbTr_BackOffice',function($join){
                        $join->on('prd_kodeigr','trbo_kodeigr');
                        $join->on('prd_prdcd','trbo_prdcd');
                    })

                    ->where("st_lokasi",'=','01')
                    ->where("prd_kodeigr",'=',$kodeigr)
                    ->where("trbo_nodoc",'=',$nomorTrn)
                    ->orderBy("TRBO_SEQNO")
                    ->get();

                for($i = 0; $i < sizeof($prdcd_cur); $i++){
                    if($prdcd_cur){
                        $div = $prdcd_cur[$i]->prd_kodedivisi;
                        $dept = $prdcd_cur[$i]->prd_kodedepartement;
                        $katb = $prdcd_cur[$i]->prd_kodekategoribarang;
                        $tag = $prdcd_cur[$i]->prd_kodetag;
                        $unit = $prdcd_cur[$i]->prd_unit;
                        $frac = $prdcd_cur[$i]->prd_frac;
                        $lcostprd = $prdcd_cur[$i]->prd_lastcost;
                        $acostprd = $prdcd_cur[$i]->prd_avgcost;
                        $jualprd = $prdcd_cur[$i]->prd_hrgjual;
                        $bkp1 = $prdcd_cur[$i]->prd_flagbkp1;
                        $bkp2 = $prdcd_cur[$i]->prd_flagbkp2;
                        $gudang = $prdcd_cur[$i]->prd_flaggudang;
                        $minord = $prdcd_cur[$i]->minord;
                        $qtystk = $prdcd_cur[$i]->st_saldoakhir;
                        $acoststk = $prdcd_cur[$i]->st_avgcost;
                        $lcoststk = $prdcd_cur[$i]->st_lastcost;
                    }else{
                        $bkp1 = null;
                        $bkp2 = null;
                        $tag = null;

                        $div = null;
                        $dept = null;
                        $katb = null;
                        $unit = null;
                        $frac = 1;
                        $acostprd = 0;
                        $jualprd = 0;
                        $qtystk = 0;
                        $acoststk = 0;
                        $minord = 0;
                    }
                    // ---->>>> Initialiasi PLU <<<<----
                    if($datas[$i]->trbo_flagdisc1 == 'P'){
                        $vplu_p = $datas[$i]->trbo_prdcd;
                    }else if($datas[$i]->trbo_flagdisc1 == 'R'){
                        $vplu_r = $datas[$i]->trbo_prdcd;
                    }

                    // ---->>>> =============== <<<<----
                    $temp = DB::table('tbtr_mstran_h')
                        ->selectRaw("NVL(COUNT(1), 0) abc")
                        ->where("msth_kodeigr",'=',$kodeigr)
                        ->where("msth_nodoc",'=',$v_nodoc)
                        ->first();

                    //dd($temp->abc);
                    if($temp->abc == 0){
                        DB::table("tbtr_mstran_h")
                            ->insert(['msth_kodeigr'=>$kodeigr,
                                'msth_recordid'=>null,
                                'msth_typetrn'=>'P',
                                'msth_nodoc'=>$v_nodoc,
                                'msth_tgldoc'=>$today,
                                'msth_nopo'=>$noReff,
                                'msth_tglpo'=>null,
                                'msth_nofaktur'=>null,
                                'msth_tglfaktur'=>null,
                                'msth_noref3'=>null,
                                'msth_tgref3'=>null,
                                'msth_istype'=>null,
                                'msth_invno'=>null,
                                'msth_tglinv'=>null,
                                'msth_nott'=>null,
                                'msth_tgltt'=>null,
                                'msth_kodesupplier'=>null,
                                'msth_pkp'=>null,
                                'msth_cterm'=>null,
                                'msth_loc'=>null,
                                'msth_loc2'=>null,
                                'msth_keterangan_header'=>$keterangan,
                                'msth_furgnt'=>null,
                                'msth_flagdoc'=>'1',
                                'msth_create_by'=>$userid,
                                'msth_create_dt'=>$today,
                                'msth_modify_by'=>null,
                                'msth_modify_dt'=>null]);
                    }
                    if($datas[$i]->trbo_flagdisc1 == 'P'){
                        $lcostx = $lcostprd/$frac;
                        if($unit == 'KG'){
                            $acoststk2 = $acoststk * 1;
                        }else{
                            $acoststk2 = $acoststk * $frac;
                        }
                        //dd($datas[$i]->trbo_kodesupplier);
                        DB::table("tbtr_mstran_d")
                            ->insert(['mstd_kodeigr'=>$kodeigr,
                                'mstd_recordid'=>null,
                                'mstd_typetrn'=>'P',
                                'mstd_nodoc'=>$v_nodoc,
                                'mstd_tgldoc'=>$today,
                                'mstd_docno2'=>'',
                                'mstd_date2'=>null,
                                'mstd_nopo'=>'',
                                'mstd_tglpo'=>null,
                                'mstd_nofaktur'=>'',
                                'mstd_tglfaktur'=>null,
                                'mstd_noref3'=>'',
                                'mstd_tgref3'=>null,
                                'mstd_istype'=>'',
                                'mstd_invno'=>'',
                                'mstd_date3'=>null,
                                'mstd_nott'=>'',
                                'mstd_tgltt'=>null,
                                'mstd_kodesupplier'=>null, // $datas[$i]->trbo_kodesupplier <- harusnya ini nilainya, tapi tidak ada data
                                'mstd_pkp'=>'',
                                'mstd_cterm'=>0,
                                'mstd_seqno'=>$datas[$i]->trbo_seqno,
                                'mstd_prdcd'=>$datas[$i]->trbo_prdcd,
                                'mstd_kodedivisi'=>$div,
                                'mstd_kodedepartement'=>$dept,
                                'mstd_kodekategoribrg'=>$katb,
                                'mstd_bkp'=>$bkp1,
                                'mstd_fobkp'=>$bkp2,
                                'mstd_unit'=>$unit,
                                'mstd_frac'=>$frac,
                                'mstd_loc'=>'',
                                'mstd_loc2'=>'',
                                'mstd_qty'=>$datas[$i]->trbo_qty,
                                'mstd_qtybonus1'=>0,
                                'mstd_qtybonus2'=>0,
                                'mstd_hrgsatuan'=>$datas[$i]->trbo_hrgsatuan,
                                'mstd_persendisc1'=>0,
                                'mstd_rphdisc1'=>0,
                                'mstd_flagdisc1'=>$datas[$i]->trbo_flagdisc1,
                                'mstd_persendisc2'=>0,
                                'mstd_rphdisc2'=>0,
                                'mstd_flagdisc2'=>null,
                                'mstd_persendisc3'=>'',
                                'mstd_rphdisc3'=>'',
                                'mstd_flagdisc3'=>null,
                                'mstd_persendisc4'=>'',
                                'mstd_rphdisc4'=>'',
                                'mstd_flagdisc4'=>null,
                                'mstd_dis4cp'=>0,
                                'mstd_dis4cr'=>0,
                                'mstd_dis4rp'=>0,
                                'mstd_dis4rr'=>0,
                                'mstd_dis4jp'=>0,
                                'mstd_dis4jr'=>0,
                                'mstd_gross'=>$datas[$i]->trbo_gross,
                                'mstd_discrph'=>0,
                                'mstd_ppnrph'=>$datas[$i]->trbo_ppnrph,
                                'mstd_ppnbmrph'=>$datas[$i]->trbo_ppnbmrph,
                                'mstd_ppnbtlrph'=>$datas[$i]->trbo_ppnbtlrph,
                                'mstd_avgcost'=>$acoststk2,
                                'mstd_ocost'=>$datas[$i]->trbo_oldcost,
                                'mstd_posqty'=>$qtystk,
                                'mstd_keterangan'=>$keterangan,
                                'mstd_fk'=>null,
                                'mstd_tglfp'=>null,
                                'mstd_kodetag'=>$tag,
                                'mstd_furgnt'=>null,
                                'mstd_gdg'=>'',
                                'mstd_create_by'=>$userid,
                                'mstd_create_dt'=>$today,
                                'mstd_modify_by'=>null,
                                'mstd_modify_dt'=>null,]);
                    //--->>>> Insert Data pada tbMaster_Stock <<<<---
                        $plu = $datas[$i]->trbo_prdcd;
                        $qty = $datas[$i]->trbo_qty;
                        //$v_lok = '';
                        //$v_message = '';
                        $connect = oci_connect('SIMSMG', 'SIMSMG', '192.168.237.193:1521/SIMSMG');
                        $query = oci_parse($connect, "BEGIN sp_igr_update_stock2('$kodeigr',
                                    '01',
                                    '$plu',
                                    '',
                                    'TRFOUT',
                                    '$qty',
                                    0,
                                    '$acoststk',
                                    '$userid',
                                    :v_lok,
                                    :v_message
                                   ); END;");
                        oci_bind_by_name($query, ':v_lok', $v_lok, 32);
                        oci_bind_by_name($query, ':v_message', $v_message, 32);
                        oci_execute($query);
                    //--->>>> Insert Data pada tbHistory_BarangBaru <<<<---
                        if($datas[$i]->trbo_flagdisc3 == 'Y'){
                            $vplulama = $datas[$i]->trbo_prdcd;

                            $plu = SUBSTR(($datas[$i]->trbo_prdcd), 1, 6).'0';
                            $mplunew_cur = DB::table("tbmaster_barangbaru")
                                ->selectRaw("pln_pkmt")
                                ->selectRaw("pln_flagtag")
                                ->selectRaw("pln_tglbpb")
                                ->selectRaw("pln_tglaktif")
                                ->where("pln_kodeigr",'=',$kodeigr)
                                ->where("pln_prdcd",'=',$plu)
                                ->first();
                            if($mplunew_cur){
                                $pkmt = $mplunew_cur->pln_pkmt;
                                $tag = $mplunew_cur->pln_flagtag;
                                $tglbpb = $mplunew_cur->pln_tglbpb;
                                $tglaktif = $mplunew_cur->pln_tglaktif;

                                //--->>> Cek Data History
                                $temp = DB::table("tbhistory_barangbaru")
                                    ->selectRaw("NVL(COUNT(1), 0) aaa")
                                    ->where("hpn_kodeigr",'=',$kodeigr)
                                    ->where("hpn_prdcd",'=',$plu)
                                    ->first();
                                if($temp->aaa == 0){
                                    $trbo_prdcd = $datas[$i]->trbo_prdcd;
                                    DB::table("tbhistory_barangbaru")
                                        ->insert(['hpn_kodeigr'=>$kodeigr,
                                            'hpn_prdcd'=>$trbo_prdcd,
                                            'hpn_pkmtoko'=>$pkmt,
                                            'hpn_kodetag'=>$tag,
                                            'hpn_tglpenerimaanbrg'=>$tglbpb,
                                            'hpn_tgldaftar'=>$tglaktif,
                                            'hpn_create_by'=>$userid,
                                            'hpn_create_dt'=>$today]);
                                }
                                //--->>> Hapus Data PLU <<<---
                                DB::table("tbmaster_barangbaru")
                                    ->where("pln_kodeigr",'=',$kodeigr)
                                    ->where("pln_prdcd",'=',$plu)
                                    ->delete();
                            }
                        }
                    }
                    // ---->>>> :trbo_flagdisc1 = 'R'
                    else{
                        if(SUBSTR($datas[$i]->trbo_prdcd, 7, 1) == '1' OR $unit == 'KG'){
                            null;
                        }else{
                            $acostprd = $acostprd/$frac;
                        }
                        if($datas[$i]->trbo_qtybonus1 == null || $datas[$i]->trbo_qtybonus1 == ''){
                            $qtybonus1 = 0;
                        }else{
                            $qtybonus1 = $datas[$i]->trbo_qtybonus1;
                        }
                        if($unit != 'KG'){
                            if($qtystk > 0){
                                $acost = (($qtystk * $acostprd) + ($datas[$i]->trbo_gross))/($qtystk + ($datas[$i]->trbo_qty) + $qtybonus1);
                                $acostx = (($qtystk * $acoststk) + ($datas[$i]->trbo_gross))/($qtystk + ($datas[$i]->trbo_qty) + $qtybonus1);
                            }else{
                                $acost = (($datas[$i]->trbo_gross))/(($datas[$i]->trbo_qty) + $qtybonus1);
                                $acostx = (($datas[$i]->trbo_gross))/(($datas[$i]->trbo_qty) + $qtybonus1);
                            }
                            if($acost <= 0){
                                $acost = ($datas[$i]->trbo_gross)/(($datas[$i]->trbo_qty)+$qtybonus1);
                            }
                            if($acostx <= 0){
                                $acostx = ($datas[$i]->trbo_gross)/(($datas[$i]->trbo_qty)+$qtybonus1);
                            }
                            $lcostx = ($datas[$i]->trbo_gross)/($datas[$i]->trbo_qty) + $qtybonus1;
                        }else{
                            if($qtystk > 0){
                                $acost = ((($qtystk/1000)*$acostprd)+($datas[$i]->trbo_gross))/($qtystk+($datas[$i]->trbo_qty)+$qtybonus1)*1000;
                                $acostx = ((($qtystk/1000)*$acoststk)+($datas[$i]->trbo_gross))/($qtystk+($datas[$i]->trbo_qty)+$qtybonus1)*1000;
                            }else{
                                $acost = ($datas[$i]->trbo_gross) / (($datas[$i]->trbo_qty)+$qtybonus1)*1000;
                                $acostx = ($datas[$i]->trbo_gross) / (($datas[$i]->trbo_qty)+$qtybonus1)*1000;
                            }
                            if($acost <= 0){
                                $acost = ($datas[$i]->trbo_gross) / (($datas[$i]->trbo_qty)+$qtybonus1)*1000;
                            }
                            if($acostx <= 0){
                                $acostx = ($datas[$i]->trbo_gross) / (($datas[$i]->trbo_qty)+$qtybonus1)*1000;
                            }
                            $lcostx = ($datas[$i]->trbo_gross) / (($datas[$i]->trbo_qty)+$qtybonus1)*1000;;
                        }
                        if($acost <= 0){
                            $acost = $acostprd;
                        }
                        if($acostx <= 0){
                            $acostx = $acoststk;
                        }

                        if($unit == 'KG'){
                            $acostx2 = $acostx * 1;
                            $acoststk2 = $acoststk * 1;
                            $lcostx2 = $lcostx * 1;
                            $lcoststk2 = $lcoststk * 1;
                        }else{
                            $acostx2 = $acostx * $frac;
                            $acoststk2 = $acoststk * $frac;
                            $lcostx2 = $lcostx * $frac;
                            $lcoststk2 = $lcoststk * $frac;
                        }
                        DB::table("tbtr_mstran_d")
                            ->insert(['mstd_kodeigr'=>$kodeigr,
                                'mstd_recordid'=>null,
                                'mstd_typetrn'=>'P',
                                'mstd_nodoc'=>$v_nodoc,
                                'mstd_tgldoc'=>$today,
                                'mstd_docno2'=>'',
                                'mstd_date2'=>null,
                                'mstd_nopo'=>'',
                                'mstd_tglpo'=>null,
                                'mstd_nofaktur'=>'',
                                'mstd_tglfaktur'=>null,
                                'mstd_noref3'=>'',
                                'mstd_tgref3'=>null,
                                'mstd_istype'=>'',
                                'mstd_invno'=>'',
                                'mstd_date3'=>null,
                                'mstd_nott'=>'',
                                'mstd_tgltt'=>null,
                                'mstd_kodesupplier'=>null, // $datas[$i]->trbo_kodesupplier <- harusnya ini nilainya, tapi tidak ada data
                                'mstd_pkp'=>'',
                                'mstd_cterm'=>0,
                                'mstd_seqno'=>$datas[$i]->trbo_seqno,
                                'mstd_prdcd'=>$datas[$i]->trbo_prdcd,
                                'mstd_kodedivisi'=>$div,
                                'mstd_kodedepartement'=>$dept,
                                'mstd_kodekategoribrg'=>$katb,
                                'mstd_bkp'=>$bkp1,
                                'mstd_fobkp'=>$bkp2,
                                'mstd_unit'=>$unit,
                                'mstd_frac'=>$frac,
                                'mstd_loc'=>'',
                                'mstd_loc2'=>'',
                                'mstd_qty'=>$datas[$i]->trbo_qty,
                                'mstd_qtybonus1'=>0,
                                'mstd_qtybonus2'=>0,
                                'mstd_hrgsatuan'=>$datas[$i]->trbo_hrgsatuan,
                                'mstd_persendisc1'=>0,
                                'mstd_rphdisc1'=>0,
                                'mstd_flagdisc1'=>$datas[$i]->trbo_flagdisc1,
                                'mstd_persendisc2'=>0,
                                'mstd_rphdisc2'=>0,
                                'mstd_flagdisc2'=>null,
                                'mstd_persendisc3'=>0,
                                'mstd_rphdisc3'=>0,
                                'mstd_flagdisc3'=>null,
                                'mstd_persendisc4'=>0,
                                'mstd_rphdisc4'=>0,
                                'mstd_flagdisc4'=>null,
                                'mstd_dis4cp'=>0,
                                'mstd_dis4cr'=>0,
                                'mstd_dis4rp'=>0,
                                'mstd_dis4rr'=>0,
                                'mstd_dis4jp'=>0,
                                'mstd_dis4jr'=>0,
                                'mstd_gross'=>$datas[$i]->trbo_gross,
                                'mstd_discrph'=>0,
                                'mstd_ppnrph'=>$datas[$i]->trbo_ppnrph,
                                'mstd_ppnbmrph'=>$datas[$i]->trbo_ppnbmrph,
                                'mstd_ppnbtlrph'=>$datas[$i]->trbo_ppnbtlrph,
                                'mstd_avgcost'=>$acostx2,
                                'mstd_ocost'=>$acoststk2,
                                'mstd_posqty'=>$qtystk,
                                'mstd_keterangan'=>$keterangan,
                                'mstd_fk'=>null,
                                'mstd_tglfp'=>null,
                                'mstd_kodetag'=>$tag,
                                'mstd_furgnt'=>null,
                                'mstd_gdg'=>'',
                                'mstd_create_by'=>$userid,
                                'mstd_create_dt'=>$today,
                                'mstd_modify_by'=>null,
                                'mstd_modify_dt'=>null]);
                        //--->>>> Insert Data pada tbMaster_Prodmast <<<<---
                        $plu = SUBSTR(($datas[$i]->trbo_prdcd), 1, 6);
                        DB::table("tbmaster_prodmast")
                            ->where('prd_kodeigr','=',$kodeigr)
                            ->whereRaw("SUBSTR(prd_prdcd, 1, 6) = $plu")
                            ->update(['prd_avgcost'=>$acostx2,'prd_lastcost'=>$lcostx2]);
                        //--->>>> Insert Data pada tbMaster_Stock <<<<---
                        $plu = $datas[$i]->trbo_prdcd;
                        $qty = $datas[$i]->trbo_qty;
                        //$v_lok = '';
                        //$v_message = '';
                        $connect = oci_connect('SIMSMG', 'SIMSMG', '192.168.237.193:1521/SIMSMG');
                        $query = oci_parse($connect, "BEGIN sp_igr_update_stock2('$kodeigr',
                                    '01',
                                    '$plu',
                                    '',
                                    'TRFIN',
                                    '$qty',
                                    '$lcostx',
                                    '$acostx',
                                    '$userid',
                                    :v_lok,
                                    :v_message
                                   ); END;");
                        oci_bind_by_name($query, ':v_lok', $v_lok, 32);
                        oci_bind_by_name($query, ':v_message', $v_message, 32);
                        oci_execute($query);

                        $tgldoc = $datas[$i]->trbo_tgldoc;
                        $temp = DB::table("tbhistory_cost")
                            ->selectRaw("NVL(COUNT(1), 0) ccc")
                            ->where('hcs_kodeigr','=',$kodeigr)
                            ->where('hcs_prdcd','=',$plu)
                            ->where('hcs_tglbpb','=',$tgldoc)
                            ->where('hcs_nodocbpb','=',$nomorTrn)
                            ->first();
                        if($temp->ccc == 0){
                            DB::table("tbhistory_cost")
                                ->insert(['hcs_kodeigr'=>$kodeigr,
                                    'hcs_typetrn'=>'P',
                                    'hcs_prdcd'=>$plu,
                                    'hcs_tglbpb'=>$tgldoc,
                                    'hcs_nodocbpb'=>$v_nodoc,
                                    'hcs_qtybaru'=>$qty,
                                    'hcs_qtylama'=>$qtystk,
                                    'hcs_avglama'=>$acoststk2,
                                    'hcs_avgbaru'=>$acostx2,
                                    'hcs_lastcostlama'=>$lcoststk2,
                                    'hcs_lastcostbaru'=>$lcostx2,
                                    'hcs_lastqty'=>($qtystk + $qty),
                                    'hcs_create_by'=>$userid,
                                    'hcs_create_dt'=>$today,
                                    'hcs_lokasi'=>'01']);
                        }
                        //-->>>>>> Cek Untuk Data Perubahan PLU
                        $plu = SUBSTR(($datas[$i]->trbo_prdcd), 1, 6).'0';
                        $mplunew_cur = DB::table("tbmaster_barangbaru")
                            ->selectRaw("pln_pkmt")
                            ->selectRaw("pln_flagtag")
                            ->selectRaw("pln_tglbpb")
                            ->selectRaw("pln_tglaktif")
                            ->where("pln_kodeigr",'=',$kodeigr)
                            ->where("pln_prdcd",'=',$plu)
                            ->first();
                        if($datas[$i]->trbo_flagdisc3 == 'Y'){
                            $vplulama = $datas[$i]->trbo_prdcd;
                            if($mplunew_cur) {
                                $pkmt = $mplunew_cur->pln_pkmt;
                                $tag = $mplunew_cur->pln_flagtag;
                                $tglbpb = $mplunew_cur->pln_tglbpb;
                                $tglaktif = $mplunew_cur->pln_tglaktif;
                                //--->>> Cek Data History
                                $temp = DB::table("tbhistory_barangbaru")
                                    ->selectRaw("NVL(COUNT(1), 0) ccc")
                                    ->where('hpn_kodeigr','=',$kodeigr)
                                    ->where('hpn_prdcd','=',$plu)
                                    ->first();
                                if($temp->ccc == 0){
                                    $trbo_prdcd = $datas[$i]->trbo_prdcd;
                                    DB::table("tbhistory_barangbaru")
                                        ->insert(['hpn_kodeigr'=>$kodeigr,
                                            'hpn_prdcd'=>$trbo_prdcd,
                                            'hpn_pkmtoko'=>$pkmt,
                                            'hpn_kodetag'=>$tag,
                                            'hpn_tglpenerimaanbrg'=>$tglbpb,
                                            'hpn_tgldaftar'=>$tglaktif,
                                            'hpn_create_by'=>$userid,
                                            'hpn_create_dt'=>$today]);
                                }
                                //--->>> Hapus Data PLU <<<---
                                DB::table("tbmaster_barangbaru")
                                    ->where("pln_kodeigr",'=',$kodeigr)
                                    ->where("pln_prdcd",'=',$plu)
                                    ->delete();
                            }
                        }
                        $temp = DB::table("tbmaster_kkpkm")
                            ->selectRaw("NVL(COUNT(1), 0) ccc")
                            ->where('pkm_kodeigr','=',$kodeigr)
                            ->where('pkm_prdcd','=',$vplulama)
                            ->first();
                        if($temp->ccc != 0){
                            $ada = DB::table("tbmaster_lokasi")
                                ->selectRaw("NVL(COUNT(1), 0) aaa")
                                ->where('lks_kodeigr','=',$kodeigr)
                                ->where('lks_prdcd','=',$plu)
                                ->where('lks_koderak','NOT LIKE','X%')
                                ->where('lks_koderak','NOT LIKE','A%')
                                ->where('lks_koderak','NOT LIKE','G%')
                                ->where('lks_tiperak','<>','S')
                                ->first();
                            if($ada->aaa == 0){
                                $vplulama2 = SUBSTR($vplulama, 1, 6).'0';
                                $ada = DB::table("tbmaster_lokasi")
                                    ->selectRaw("NVL(COUNT(1), 0) aaa")
                                    ->where('lks_kodeigr','=',$kodeigr)
                                    ->where('lks_prdcd','=',$vplulama2)
                                    ->where('lks_koderak','NOT LIKE','X%')
                                    ->where('lks_koderak','NOT LIKE','A%')
                                    ->where('lks_koderak','NOT LIKE','G%')
                                    ->where('lks_tiperak','<>','S')
                                    ->first();
                                if($ada->aaa == 0){
                                    $dimensi = 0;
                                }else{
                                    $dimensi = 0;
                                    $nilai = DB::table("tbmaster_lokasi")
                                        ->selectRaw("(lks_tirkirikanan * lks_tirdepanbelakang * lks_tiratasbawah) nilai")
                                        ->where('lks_kodeigr','=',$kodeigr)
                                        ->where('lks_prdcd','=',$vplulama2)
                                        ->where('lks_koderak','NOT LIKE','X%')
                                        ->where('lks_koderak','NOT LIKE','A%')
                                        ->where('lks_koderak','NOT LIKE','G%')
                                        ->where('lks_tiperak','<>','S')
                                        ->groupBy('lks_prdcd')
                                        ->get();
                                    for($j = 0; $j < sizeof($nilai); $j++){
                                        $dimensi = $dimensi + $nilai[$j]->nilai;
                                    }
//                                    $dimensi = DB::select("SELECT SUM(nilai)
//                                    INTO dimensi
//                                    FROM (SELECT lks_prdcd,
//                                                 (lks_tirkirikanan * lks_tirdepanbelakang
//                                                  * lks_tiratasbawah
//                                                 ) nilai
//                                            FROM tbmaster_lokasi
//                                           WHERE lks_kodeigr = :parameter.kodeigr
//                                             AND lks_prdcd = SUBSTR(vplulama, 1, 6) || '0'
//                                             AND (    lks_koderak NOT LIKE 'X%'
//                                                  AND lks_koderak NOT LIKE 'A%'
//                                                  AND lks_koderak NOT LIKE 'G%'
//                                                 )
//                                             AND lks_tiperak <> 'S')
//                                GROUP BY lks_prdcd");
                                }
                            }else{
                                $dimensi = 0;
                                $nilai = DB::table("tbmaster_lokasi")
                                    ->selectRaw("(lks_tirkirikanan * lks_tirdepanbelakang * lks_tiratasbawah) nilai")
                                    ->where('lks_kodeigr','=',$kodeigr)
                                    ->where('lks_prdcd','=',$plu)
                                    ->where('lks_koderak','NOT LIKE','X%')
                                    ->where('lks_koderak','NOT LIKE','A%')
                                    ->where('lks_koderak','NOT LIKE','G%')
                                    ->where('lks_tiperak','<>','S')
                                    ->groupBy('lks_prdcd')
                                    ->get();
                                for($j = 0; $j < sizeof($nilai); $j++){
                                    $dimensi = $dimensi + $nilai[$j]->nilai;
                                }
                            }
                            if($gudang == 'Y' || $gudang == 'P'){
                                $ada = DB::table("tbmaster_minimumorder")
                                    ->selectRaw("NVL(COUNT(1), 0)")
                                    ->where('min_kodeigr','=',$kodeigr)
                                    ->where('min_prdcd','=',$plu)
                                    ->first();

                                $minord= DB::table("tbmaster_minimumorder")
                                    ->selectRaw("min_minorder")
                                    ->where('min_kodeigr','=',$kodeigr)
                                    ->where('min_prdcd','=',$plu)
                                    ->first();
                            }
                            //----->>>> Update data PKM
                            DB::table("tbmaster_kkpkm")
                                ->where('pkm_kodeigr','=',$kodeigr)
                                ->where('pkm_prdcd','=',$plu)
                                ->delete();
                            $jojo = $dimensi + $minord;
                            DB::table("tbmaster_kkpkm")
                                ->where('pkm_kodeigr','=',$kodeigr)
                                ->where('pkm_prdcd','=',$vplulama)
                                ->update(['pkm_prdcd'=>$plu,'pkm_pkmt'=>$jojo,'pkm_mindisplay'=>$dimensi]);

                            //----->>>> ===o0O0o=== <<<<-----
                            //
                            //----->>>> Update data Master Lokasi
                            DB::table('tbmaster_lokasi')
                                ->where('lks_kodeigr','=',$kodeigr)
                                ->where('lks_prdcd','=',$vplulama)
                                ->update(['lks_prdcd'=>$plu]);

                            //----->>>> ===o0O0o===<<<<-----
                            //
                            //----->>>> Update data PKM GONDOLA
                            $temp = DB::table("tbtr_pkmgondola")
                                ->selectRaw('NVL(COUNT(1), 0)')
                                ->where('pkmg_kodeigr','=',$kodeigr)
                                ->where('pkmg_prdcd','=',$vplulama)
                                ->first();

                            if($temp != 0){
                                $tampungan = $datas[$i]->trbo_prdcd;
                                $pkmgdl_cur = DB::table("tbtr_pkmgondola")
                                    ->selectRaw('1')
                                    ->where('pkmg_kodeigr','=',$kodeigr)
                                    ->where('pkmg_prdcd','=',$tampungan)
                                    ->first();
                                if($pkmgdl_cur){
                                    DB::table("tbtr_pkmgondola")
                                        ->where('pkmg_kodeigr','=',$kodeigr)
                                        ->where('pkmg_prdcd','=',$vplulama)
                                        ->delete();
                                }else{
                                    DB::table("tbtr_pkmgondola")
                                        ->where('pkmg_kodeigr','=',$kodeigr)
                                        ->where('pkmg_prdcd','=',$vplulama)
                                        ->update(['pkmg_prdcd'=>$plu]);
                                }
                                //----->>>> ===o0O0o=== <<<<-----
                                //
                                //----->>>> Update data PKM PLUS
                                $temp = DB::table("tbmaster_pkmplus")
                                    ->selectRaw('NVL(COUNT(1), 0)')
                                    ->where('pkmp_kodeigr','=',$kodeigr)
                                    ->where('pkmp_prdcd','=',$vplulama)
                                    ->first();
                                if($temp != 0){
                                    $pkmplus_cur = DB::table("tbmaster_pkmplus")
                                        ->selectRaw('1')
                                        ->where('pkmp_kodeigr','=',$kodeigr)
                                        ->where('pkmp_prdcd','=',$tampungan)
                                        ->first();
                                    if($pkmplus_cur){
                                        DB::table("tbmaster_pkmplus")
                                            ->where('pkmp_kodeigr','=',$kodeigr)
                                            ->where('pkmp_prdcd','=',$vplulama)
                                            ->delete();
                                    }else{
                                        DB::table("tbmaster_pkmplus")
                                            ->where('pkmp_kodeigr','=',$kodeigr)
                                            ->where('pkmp_prdcd','=',$vplulama)
                                            ->update(['pkmp_prdcd'=>$plu]);
                                    }
                                }
                                //----->>>> ===o0O0o=== <<<<-----
                                //
                                //----->>>> Update data GONDOLA
                                $temp = DB::table("tbtr_gondola")
                                    ->selectRaw("NVL(COUNT(1), 0)")
                                    ->where('gdl_kodeigr','=',$kodeigr)
                                    ->where('gdl_prdcd','=',$vplulama)
                                    ->first();
                                if($temp != 0){
                                    $gondola_cur = DB::table("tbtr_gondola")
                                        ->selectRaw('1')
                                        ->where('gdl_kodeigr','=',$kodeigr)
                                        ->where('gdl_prdcd','=',$tampungan)
                                        ->first();
                                    if($gondola_cur){
                                        DB::table("tbtr_gondola")
                                            ->where('gdl_kodeigr','=',$kodeigr)
                                            ->where('gdl_prdcd','=',$vplulama)
                                            ->delete();
                                    }else{
                                        DB::table("tbtr_gondola")
                                            ->where('gdl_kodeigr','=',$kodeigr)
                                            ->where('gdl_prdcd','=',$vplulama)
                                            ->update(['gdl_prdcd'=>$plu]);
                                    }
                                }
                                //----->>>> ===o0O0o=== <<<<-----
                                //
                                //----->>>> Update data MINIMUM ORDER
                                $temp = DB::table("tbmaster_minimumorder")
                                    ->where('min_kodeigr','=',$kodeigr)
                                    ->where('min_prdcd','=',$vplulama)
                                    ->first();
                                if($temp != 0){
                                    $temp = DB::table("tbmaster_minimumorder")
                                        ->selectRaw('NVL(COUNT(1), 0)')
                                        ->where('min_kodeigr','=',$kodeigr)
                                        ->where('min_prdcd','=',$plu)
                                        ->first();
                                    if($temp != 0){
                                        DB::table("tbmaster_minimumorder")
                                            ->where('min_kodeigr','=',$kodeigr)
                                            ->where('min_prdcd','=',$vplulama)
                                            ->delete();
                                    }else{
                                        DB::table("tbmaster_minimumorder")
                                            ->where('min_kodeigr','=',$kodeigr)
                                            ->where('min_prdcd','=',$vplulama)
                                            ->update(['min_prdcd'=>$plu]);
                                    }
                                }
                                //----->>>> ===o0O0o=== <<<<-----
                                //
                                //----->>>> Update data PLU KONVERSI
                                $temp = DB::table("tbtr_konversiplu")
                                    ->selectRaw('NVL(COUNT(1), 0)')
                                    ->where('kvp_kodeigr','=',$kodeigr)
                                    ->where('kvp_pluold','=',$vplulama)
                                    ->where('kvp_plunew','=',$plu)
                                    ->first();
                                if($temp == 0){
                                    $konvfrac_cur = DB::table("tbmaster_prodmast")
                                        ->selectRaw("prd_frac")
                                        ->where('prd_kodeigr','=',$kodeigr)
                                        ->where('prd_prdcd','=',$vplulama)
                                        ->first();
                                    $fracold = $konvfrac_cur->prd_frac;
                                    if(!$konvfrac_cur){
                                        $fracold = 0;
                                    }
                                    $konvfrac_cur = DB::table("tbmaster_prodmast")
                                        ->selectRaw("prd_frac")
                                        ->where('prd_kodeigr','=',$kodeigr)
                                        ->where('prd_prdcd','=',$plu)
                                        ->first();
                                    $fracnew = $konvfrac_cur->prd_frac;
                                    if(!$konvfrac_cur){
                                        $fracnew = 0;
                                    }
                                    DB::table("tbtr_konversiplu")
                                        ->insert(['kvp_kodeigr'=>$kodeigr,
                                            'kvp_pluold'=>$vplulama,
                                            'kvp_plunew'=>$plu,
                                            'kvp_kodetipe'=>'P',
                                            'kvp_tgl'=>$tgldoc,
                                            'kvp_konversiold'=>$fracold,
                                            'kvp_konversinew'=>$fracnew,
                                            'kvp_create_by'=>$userid,
                                            'kvp_create_dt'=>$today]);
                                }
                            }
                        }
                    }
                }
                //--** update data tbTr_BackOffice
//ini masih dalam if trbo_flagdoc = 0, jadinya nonota nya kosong, dan tak bisa di print
                DB::table("tbtr_backoffice")
                    ->where('trbo_nodoc','=',$nomorTrn)
                    ->where('trbo_typetrn','=','P')
                    ->update(['trbo_nonota'=>$v_nodoc,
                        'trbo_tglnota'=>$today,
                        'trbo_recordid'=>'2',
                        'trbo_flagdoc'=>'*']);
            }
            //dd("Jangan commit dulu cuy");
            DB::commit();
        }catch(\Exception $e){
            dd($e);
        }
    }
}
