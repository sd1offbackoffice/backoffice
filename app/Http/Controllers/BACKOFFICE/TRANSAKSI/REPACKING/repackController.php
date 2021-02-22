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

    public function getNmrTrn(Request $request){
        $search = $request->val;

        $datas = DB::table('tbTr_BackOffice')
            ->selectRaw('distinct TRBO_NODOC as TRBO_NODOC')
            ->selectRaw('TRBO_TGLDOC')
            ->selectRaw("CASE WHEN TRBO_FLAGDOC='*' THEN TRBO_NONOTA ELSE 'Belum Cetak Nota' END NOTA")
            ->where('TRBO_TYPETRN','=','P')
            ->where('TRBO_NODOC','LIKE', '%'.$search.'%')
            ->orderByDesc('TRBO_NODOC')
            ->limit(100)
            ->get();

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
            $tanggalTrn = date("Y-d-m", strtotime($request->tanggalTrn));
            $keterangan = $request->keterangan;
            $trbo_flagdisc3 = $request->trbo_flagdisc3; //ini perubahan Plu, nilainya Y atau kosong
            $trbo_flagdisc2 = $request->trbo_flagdisc2; // ini group_option pre-packing(P) atau re-packing(R)
            $noReff = $request->noReff;
            //$tglReff = date("Y-d-m", strtotime($request->tglReff));
            //$trbo_flagdoc = $request->statusPrint; //belum tau ambil dari mana, seharusnya lihat data model untuk tau inputnya, kalau masih belum di print berarti koreksi, input kosong, kalau sudah di print kasih simbol *, dan kalau sudah print ga bisa di update
            $datas = $request->datas;



            $check = DB::table('tbTr_BackOffice')
                ->selectRaw("*")
                ->where('TRBO_NODOC','=',$nomorTrn)
                ->where('TRBO_TYPETRN','=','P')
                ->where('ST_KODEIGR','=',$kodeigr)
                ->first();

            if($check){
                //update data
                $crDate = $check->trbo_create_dt;
                $creator = $check->trbo_create_by;
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
                    DB::table('tbTr_BackOffice')
                        ->where('TRBO_NODOC','=',$nomorTrn)
                        ->where('TRBO_TYPETRN','=','P')
                        ->where('ST_KODEIGR','=',$kodeigr)
                        ->where('TRBO_PRDCD','=',$temp['plu'])
                        ->insert(['TRBO_KODEIGR' => $kodeigr, 'TRBO_TYPETRN' => 'P','TRBO_NODOC' => $nomorTrn, 'TRBO_TGLDOC' => $tanggalTrn, 'TRBO_NOREFF' => $noReff2,
                            'TRBO_TGLREFF' => $tanggalTrn, 'TRBO_SEQNO' => $i, 'TRBO_PRDCD' => $temp['plu'], 'TRBO_QTY' => $temp['qty'], 'TRBO_HRGSATUAN' => $temp['hrgsatuan'],
                            'TRBO_FLAGDISC1' => $temp['flagdisc1'], 'TRBO_FLAGDISC2' => $trbo_flagdisc2,'TRBO_FLAGDISC3' => $trbo_flagdisc3, 'TRBO_GROSS' => $temp['gross'], 'TRBO_PPNRPH' => $temp['ppn'],
                            'TRBO_AVERAGECOST' => $temp['averagecost'], 'TRBO_KETERANGAN' => $keterangan,'TRBO_FLAGDOC' => '0', 'TRBO_CREATE_BY' => $creator, 'TRBO_CREATE_DT' => $crDate, 'TRBO_STOKQTY' => $temp['stokqty'],
                            'TRBO_MODIFY_BY' => $userid, 'TRBO_MODIFY_DT' => $today]);
                }
            }else{
                //create new save data
                $connect = oci_connect('SIMSMG', 'SIMSMG', '192.168.237.193:1521/SIMSMG');
                $ip =str_pad(substr(substr($_SESSION['ip'],-3),strpos(substr($_SESSION['ip'],-3),'.'),3),3,'0',STR_PAD_LEFT);
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
            $frac = [];
            $jualPRD = [];
            if($datas[0]->trbo_flagdoc == '0'){
                for ($i = 0; $i < sizeof($datas); $i++){
                    $plu = $datas[$i]->trbo_prdcd;
                    $rec = DB::SELECT("SELECT * FROM tbMaster_Prodmast WHERE PRD_KODEIGR='$kodeigr' AND PRD_PRDCD = '$plu'");
                    $frac[$i] = $rec[0]->prd_frac;
                    $jualPRD[$i] = $rec[0]->prd_hrgjual;
                }
                for ($i = 0; $i < sizeof($datas); $i++) {
                    $plu = $datas[$i]->trbo_prdcd;
                    if($datas[$i]->trbo_flagdisc1 == 'R'){
                        DB::table("TBTR_BACKOFFICE")
                            ->where("TRBO_NODOC",'=',$nomorTrn)
                            ->where("TRBO_KODEIGR",'=',$kodeigr)
                            ->where("TRBO_PRDCD",'=',$plu)
                            ->where("TRBO_FLAGDISC1",'=','R')
                            ->update(['TRBO_FLAGDOC' => '1', 'TRBO_MODIFY_BY' => $userid, 'TRBO_MODIFY_DT' => $today]);
                    }else{
                        DB::table("TBTR_BACKOFFICE")
                            ->where("TRBO_NODOC",'=',$nomorTrn)
                            ->where("TRBO_KODEIGR",'=',$kodeigr)
                            ->where("TRBO_PRDCD",'=',$plu)
                            ->where("TRBO_FLAGDISC1",'=','P')
                            ->update(['TRBO_FLAGDOC' => '1']);
                    }
                }

            }

            self::simpan($request);
dd("jangan sampai commit wkwkkwwkk");
            DB::commit();
        }catch(\Exception $e){
        }


    }

    public function simpan(Request $request){
        try{
            DB::beginTransaction();

            $nomorTrn = $request->nomorTrn;
            $userid = $_SESSION['usid'];
            $kodeigr = $_SESSION['kdigr'];
            $reprint = 1;

            $datas = DB::table('tbTr_BackOffice')
                ->selectRaw("trbo_flagdoc")
                ->selectRaw("trbo_flagdisc1")
                ->selectRaw("trbo_prdcd")
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
                }
            }
            dd("Jangan commit dulu cuy");
            DB::commit();
        }catch(\Exception $e){
        }
    }
}