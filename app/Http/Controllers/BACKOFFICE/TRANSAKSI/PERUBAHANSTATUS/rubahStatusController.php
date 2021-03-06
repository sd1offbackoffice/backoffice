<?php
namespace App\Http\Controllers\BACKOFFICE\TRANSAKSI\PERUBAHANSTATUS;

use App\Http\Controllers\Auth\loginController;
use Carbon\Carbon;
use DateTime;
use Dompdf\Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller; use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use PDF;
use Yajra\DataTables\DataTables;

class rubahStatusController extends Controller
{
    private $flagisi;
    private $flag_retur;
    private $flag_rusak;
    private $flag_putus;
    private $nomor_retur;
    private $nomor_rusak;
    private $nomor_putus;

    public function index(){
        return view('BACKOFFICE.TRANSAKSI.PERUBAHANSTATUS.rubahStatus');
    }

    public function getNewNmrRsn(){
        $kodeigr = Session::get('kdigr');
        $no_key = DB::connection(Session::get('connection'))->table('tbmaster_nomordoc')
            ->selectRaw('nomorawal')
            ->where('kodedoc',"=",'RSN')
            ->where('nomordoc',"<=", 99999)
            ->orderBy('nomorawal')
            ->first();

        $connect = loginController::getConnectionProcedure();

        $query = oci_parse($connect, "BEGIN :ret := f_igr_get_nomor('$kodeigr','RSN',
                             'Nomor Rubah Status New',
                             TRIM ('$no_key->nomorawal'),
                             5,
                             FALSE); END;");
        oci_bind_by_name($query, ':ret', $result, 32);
        oci_execute($query);

        return response()->json($result);
    }

    public function getNmrRsn(Request $request){
        $search = $request->val;
        $kodeigr= Session::get('kdigr');

        $datas = DB::connection(Session::get('connection'))->table('tbtr_mstran_h')
            ->selectRaw('distinct msth_nopo as msth_nopo')
            ->selectRaw('msth_tglpo')
            ->selectRaw('msth_keterangan_header')
//            ->leftJoin('tbtr_sortir_barang', function($join){
//                $join->on('srt_nosortir', 'msth_nofaktur');
//                $join->on('srt_tglsortir', 'msth_tgldoc');
//            })
            ->where('msth_nopo','=', $search)
            ->where('msth_typetrn','=', 'Z')
            ->where('msth_kodeigr','=', $kodeigr)
//            ->where('SRT_TYPE','=','S')
            ->orderByDesc('msth_nopo')
//            ->orderByDesc('rsk_create_dt')
//            ->limit(100)
            ->first();

        return response()->json($datas);
    }
    public function ModalRsn(Request $request){
        $kodeigr= Session::get('kdigr');
        $search = $request->value;

        $datas = DB::connection(Session::get('connection'))->table('tbtr_mstran_h')
            ->selectRaw('distinct msth_nopo as msth_nopo')
            ->selectRaw('msth_tglpo')
            ->selectRaw('msth_keterangan_header')
            ->selectRaw('msth_nofaktur')
            ->selectRaw('msth_tglfaktur')

            ->where('msth_nopo','LIKE', '%'.$search.'%')
            ->where('msth_typetrn','=', 'Z')
            ->where('msth_kodeigr','=', $kodeigr)

            ->orWhere('msth_tglpo','LIKE', '%'.$search.'%')
            ->where('msth_typetrn','=', 'Z')
            ->where('msth_kodeigr','=', $kodeigr)

            ->orWhere('msth_keterangan_header','LIKE', '%'.$search.'%')
            ->where('msth_typetrn','=', 'Z')
            ->where('msth_kodeigr','=', $kodeigr)

            ->orWhere('msth_nofaktur','LIKE', '%'.$search.'%')
            ->where('msth_typetrn','=', 'Z')
            ->where('msth_kodeigr','=', $kodeigr)

            ->orWhere('msth_tglfaktur','LIKE', '%'.$search.'%')
            ->where('msth_typetrn','=', 'Z')
            ->where('msth_kodeigr','=', $kodeigr)


            ->orderByDesc('msth_nopo')
//            ->orderByDesc('rsk_create_dt')
            ->limit(100)
            ->get();

        return Datatables::of($datas)->make(true);
    }

    public function getNmrSrt(Request $request){
        $kodeigr= Session::get('kdigr');
        $search = $request->val;

        $datas = DB::connection(Session::get('connection'))->table('TBTR_SORTIR_BARANG')
            ->selectRaw('distinct SRT_NOSORTIR as SRT_NOSORTIR')
            ->selectRaw('SRT_TGLSORTIR')
            ->selectRaw('SRT_KETERANGAN')
            ->selectRaw('SRT_GUDANGTOKO')
            ->where('SRT_NOSORTIR','LIKE', '%'.$search.'%')
//            ->where('SRT_TYPE','=','S')
            ->where('SRT_KODEIGR','=',$kodeigr)
            ->where('SRT_NOSORTIR','<>',null)
            ->first();

        return response()->json($datas);
    }

    public function ModalSrt(Request $request){
        $kodeigr= Session::get('kdigr');
        $search = $request->value;

        $datas = DB::connection(Session::get('connection'))->table('TBTR_SORTIR_BARANG')
            ->selectRaw('distinct SRT_NOSORTIR as SRT_NOSORTIR')
            ->selectRaw('SRT_TGLSORTIR')
            ->selectRaw('SRT_KETERANGAN')

            ->where('SRT_NOSORTIR','LIKE', '%'.$search.'%')
            ->where('SRT_TYPE','=','S')
            ->where('SRT_KODEIGR','=',$kodeigr)
            ->where('SRT_NOSORTIR','<>',null)

            ->orWhere('SRT_TGLSORTIR','LIKE', '%'.$search.'%')
            ->where('SRT_TYPE','=','S')
            ->where('SRT_KODEIGR','=',$kodeigr)
            ->where('SRT_NOSORTIR','<>',null)

            ->orWhere('SRT_KETERANGAN','LIKE', '%'.$search.'%')
            ->where('SRT_TYPE','=','S')
            ->where('SRT_KODEIGR','=',$kodeigr)
            ->where('SRT_NOSORTIR','<>',null)

            ->orderByDesc('SRT_TGLSORTIR')
            ->orderByDesc('SRT_NOSORTIR')
            ->limit(100)
            ->get();

        return Datatables::of($datas)->make(true);
    }

    public function chooseRsn(Request $request){
        $kode = $request->kode;
        $kodeigr= Session::get('kdigr');

        $datas = DB::connection(Session::get('connection'))->table('tbtr_mstran_h')
            ->selectRaw('msth_nopo')
            ->selectRaw('msth_tgldoc')
            ->selectRaw('msth_nofaktur')
            ->selectRaw('msth_tglfaktur')
            ->selectRaw('msth_keterangan_header')
//            ->selectRaw('srt_nosortir')
//            ->selectRaw('srt_tglsortir')
//            ->selectRaw('srt_gudangtoko')
            ->selectRaw('mstd_prdcd')
//            ->selectRaw('prd_deskripsipanjang')
//            ->selectRaw('prd_frac')
//            ->selectRaw('prd_unit')
//            ->selectRaw('prd_perlakuanbarang')
//            ->selectRaw('srt_qtykarton')
//            ->selectRaw('srt_qtypcs')
            ->selectRaw('mstd_hrgsatuan')
            ->selectRaw('mstd_gross')
            ->selectRaw("Case When MSTD_FLAGDISC3='P'  OR MSTD_FLAGDISC3='p' Then 'Data Sudah Dicetak' Else 'Data Belum dicetak' End  Nota")
            ->leftJoin('tbtr_mstran_d','msth_nopo','=','mstd_nopo')
//            ->leftJoin('tbtr_sortir_barang', function($join){
//                $join->on('srt_nosortir', 'msth_nofaktur');
//                $join->on('srt_tglsortir', 'msth_tgldoc');
//                $join->on('srt_prdcd', 'mstd_prdcd');
//            })
//            ->leftJoin('tbmaster_prodmast', 'mstd_prdcd','=','prd_prdcd')
            ->where('msth_nopo','=', $kode)
            ->where('msth_kodeigr','=', $kodeigr)
            ->where('msth_typetrn','=', 'Z')
            ->whereRaw("nvl(msth_recordid, 0)<>'1'")
            ->get();

//        $test = DB::connection(Session::get('connection'))->table('tbtr_barangrusak')->limit(10)->get()->toArray();
//        dd($datas);

        return response()->json($datas);
    }

    public function chooseSrt(Request $request){
        $kode = $request->kode;
        $kodeigr= Session::get('kdigr');

        //        cek flag P
        $cekFlag = DB::connection(Session::get('connection'))
            ->table('TBTR_SORTIR_BARANG')
            ->select("SRT_FLAGDISC3","SRT_TGLSORTIR")
            ->where('SRT_KODEIGR','=',$kodeigr)
            ->where('SRT_TYPE','=','S')
            ->where('SRT_NOSORTIR','=',$kode)
            ->first();
        if($cekFlag->srt_flagdisc3 == 'P'){
            return response()->json(['status' => 'error', 'message' => 'Nomor Dokumen Sortir Telah Diproses !!']);
        }

//        $datas = DB::connection(Session::get('connection'))->table('TBTfakR_SORTIR_BARANG')
//            ->selectRaw('SRT_NOSORTIR')
//            ->selectRaw('SRT_TGLSORTIR')
//            ->selectRaw('SRT_FLAGDISC3')
//            ->selectRaw('srt_gudangtoko')
//            ->selectRaw('SRT_PRDCD')
//            ->selectRaw('SRT_QTYKARTON')
//            ->selectRaw('SRT_QTYPCS')
//            ->selectRaw('SRT_HRGSATUAN')
//            ->selectRaw('prd_deskripsipanjang')
//            ->selectRaw('prd_frac')
//            ->selectRaw('prd_unit')
//            ->selectRaw('prd_perlakuanbarang')
//            ->selectRaw('HGB_STATUSBARANG')
//            ->selectRaw('SUP_FLAGPENANGANANPRODUK')
//            ->leftJoin('tbmaster_prodmast', 'prd_prdcd', 'srt_prdcd')
//            ->leftJoin('TBMASTER_HARGABELI','HGB_PRDCD','SRT_PRDCD')
//            ->leftJoin('TBMASTER_SUPPLIER','SUP_KODESUPPLIER','HGB_KODESUPPLIER')
//            ->where('SRT_NOSORTIR', $kode)
//            ->where('HGB_TIPE','=','2')
//            ->get();
        $datas = DB::connection(Session::get('connection'))->select("SELECT SRT_NOSORTIR, SRT_TGLSORTIR, SRT_KODESUPPLIER, SRT_PKP, SRT_PRDCD, SRT_SEQNO,
               SRT_KODEDIVISI, SRT_KODEDEPARTEMENT, SRT_KODEKATEGORIBARANG, SRT_QTYKARTON,
               SRT_QTYPCS, SRT_UNIT || '/' || SRT_FRAC, SRT_FRAC, SRT_UNIT, SRT_BKP, SRT_HRGSATUAN,
               SRT_TTLHRG, SRT_GUDANGTOKO, PRD_DESKRIPSIPANJANG, 'B' AS DARI,
               CASE
                   WHEN HGB_STATUSBARANG = 'PT'
                       THEN 'R'
                   ELSE CASE
                   WHEN HGB_STATUSBARANG = 'RT'
                       THEN 'T'
                   ELSE CASE
                   WHEN HGB_STATUSBARANG = 'TG'
                       THEN 'T'
                   ELSE CASE
                   WHEN SUP_FLAGPENANGANANPRODUK = 'PT'
                       THEN 'R'
                   ELSE CASE
                   WHEN SUP_FLAGPENANGANANPRODUK = 'RT'
                       THEN 'T'
                   ELSE CASE
                   WHEN SUP_FLAGPENANGANANPRODUK = 'TG'
                       THEN 'T'
                   ELSE ''
               END
               END
               END
               END
               END
               END AS KE
          FROM TBTR_SORTIR_BARANG, TBMASTER_PRODMAST, TBMASTER_SUPPLIER, TBMASTER_HARGABELI
         WHERE SRT_KODEIGR = '$kodeigr'
           AND SRT_TYPE = 'S'
           AND SRT_NOSORTIR = '$kode'
           AND PRD_KODEIGR = SRT_KODEIGR
           AND PRD_PRDCD = SRT_PRDCD
           AND HGB_KODEIGR = SRT_KODEIGR
           AND HGB_PRDCD = SRT_PRDCD
           AND HGB_TIPE = '2'
           AND SUP_KODEIGR = SRT_KODEIGR
           AND SUP_KODESUPPLIER = HGB_KODESUPPLIER
           AND NVL (SRT_QTYKARTON + SRT_QTYPCS, 0) > 0");

//        $test = DB::connection(Session::get('connection'))->table('tbtr_barangrusak')->limit(10)->get()->toArray();
//        dd($datas);

        return response()->json($datas);
    }

    public function saveData(Request $request){
        try{
            DB::connection(Session::get('connection'))->beginTransaction();
            $this->flagisi ='Y';
            $this->flag_retur ='N';
            $this->flag_rusak ='N';
            $this->flag_putus ='N';

            $datas  = $request->datas;
            $noDoc = $request->noDoc;
            $noSort = $request->noSort;
            $chkPlano = $request->statusPlano;
            $gudangtoko = $request->gudangtoko;
            $txtKeterangan = $request->keterangan;
            $keterangan = '';
            $userid = Session::get('usid');
            $kodeigr = Session::get('kdigr');
            $flagretur = $this->flag_retur;
            $today  = Carbon::now();

            $tglDoc = DateTime::createFromFormat('d/m/Y',$request->tglDoc)->format('d/m/Y');
            $tglSort = isset($request->tglSort)?DateTime::createFromFormat('d/m/Y',$request->tglSort)->format('d/m/Y'):'';
            $case = 0;
            $checker = DB::connection(Session::get('connection'))->table('TBTR_MSTRAN_D')
                ->selectRaw('MSTD_TGLDOC')
                ->selectRaw('MSTD_CREATE_BY')
                ->selectRaw('MSTD_CREATE_DT')
                ->selectRaw('MSTD_FLAGDISC3')
                ->where('MSTD_NOPO','=',$noDoc)
                ->where('MSTD_TYPETRN','=','Z')
                ->first();
            if($checker){
                if($checker->mstd_flagdisc3 == 'P'){
                    return response()->json(['kode' => 3, 'msg' => $noDoc]);
                }else{
                    $crDate = $checker->mstd_tgldoc;
                    $creator = $checker->mstd_create_by;
                    $crDate2 = $checker->mstd_create_dt;
                    DB::connection(Session::get('connection'))->table('TBTR_MSTRAN_D')
                        ->where('MSTD_NOPO','=',$noDoc)
                        ->where('MSTD_TYPETRN','=','Z')
                        ->delete();
                    $case = 1;
                }
            }
            for ($i = 1; $i < sizeof($datas); $i++){
                $temp = $datas[$i];
                $FRACPRD = 0;
                $UNITPRD = '';
                $DIVPRD = '';
                $DEPPRD = '';
                $KATPRD = '';
                $ACOSTPRD = '';
                $DESCPRD = '';
                $LOC1 = '';
                $LOC2 = '';
                $flagdisc3 = '';
                $qtyakhir = 0;
                if($temp['flagdisc1'] == 'B' AND $temp['flagdisc2'] == 'T'){
                    $flagdisc4 = 'A';
                }elseif ($temp['flagdisc1'] == 'B' AND $temp['flagdisc2'] == 'R'){
                    $flagdisc4 = 'B';
                }else{
                    $flagdisc4 = 'C';
                }

                $PRDCD_CUR = DB::connection(Session::get('connection'))->table('tbmaster_prodmast')
                    ->selectRaw('PRD_FRAC')
                    ->selectRaw('PRD_UNIT')
                    ->selectRaw('PRD_KODEDIVISI')
                    ->selectRaw('PRD_KODEDEPARTEMENT')
                    ->selectRaw('PRD_KODEKATEGORIBARANG')
                    ->selectRaw('PRD_AVGCOST')
                    ->selectRaw('PRD_DESKRIPSIPANJANG')
                    ->where('PRD_KODEIGR','=',$kodeigr)
                    ->where('PRD_PRDCD','=',$temp['mstd_prdcd'])
                    ->first();

                if($PRDCD_CUR) {
                    $FRACPRD = (int)$PRDCD_CUR->prd_frac;
                    $UNITPRD = $PRDCD_CUR->prd_unit;
                    $DIVPRD = $PRDCD_CUR->prd_kodedivisi;
                    $DEPPRD = $PRDCD_CUR->prd_kodedepartement;
                    $KATPRD = $PRDCD_CUR->prd_kodekategoribarang;
                    $ACOSTPRD = (int)$PRDCD_CUR->prd_avgcost;
                    $DESCPRD = $PRDCD_CUR->prd_deskripsipanjang;
                }
                if($UNITPRD == 'KG'){
                    $FRACPRD = 1;
                }elseif ($FRACPRD == null){
                    $FRACPRD = 1;
                }
                if($temp['flagdisc1'] == 'B'){
                    $LOC1 = '01';
                }elseif ($temp['flagdisc1'] == 'T'){
                    $LOC1 = '02';
                }elseif ($temp['flagdisc1'] == 'R'){
                    $LOC1 = '03';
                }
                $tempStock = DB::connection(Session::get('connection'))->table('TBMASTER_STOCK')
                    ->selectRaw('*')
                    ->where('ST_KODEIGR','=',$kodeigr)
                    ->where('ST_PRDCD','=',$temp['mstd_prdcd'])
                    ->where('ST_LOKASI','=',$LOC1)
                    ->first();
                if(!$tempStock){
                    DB::connection(Session::get('connection'))->table('TBMASTER_STOCK')
                        ->insert(['ST_KODEIGR' => $kodeigr, 'ST_LOKASI' => $LOC1, 'ST_PRDCD' => $temp['mstd_prdcd'],
                            'ST_SALDOAKHIR' => (int)$temp['mstd_qty'], 'ST_TRFOUT' => (int)$temp['mstd_qty'],
                            'ST_CREATE_BY' => $userid, 'ST_CREATE_DT' => $today]);
                }else{
                    DB::connection(Session::get('connection'))->table('TBMASTER_STOCK')
                        ->where('ST_KODEIGR','=',$kodeigr)
                        ->where('ST_PRDCD','=',$temp['mstd_prdcd'])
                        ->where('ST_LOKASI','=',$LOC1)
                        ->update(['ST_MODIFY_BY' => $userid, 'ST_MODIFY_DT' => $today]);

                    DB::connection(Session::get('connection'))->table('TBMASTER_STOCK')
                        ->where('ST_KODEIGR','=',$kodeigr)
                        ->where('ST_PRDCD','=',$temp['mstd_prdcd'])
                        ->where('ST_LOKASI','=',$LOC1)
                        ->decrement('ST_SALDOAKHIR', (int)$temp['mstd_qty']);

                    DB::connection(Session::get('connection'))->table('TBMASTER_STOCK')
                        ->where('ST_KODEIGR','=',$kodeigr)
                        ->where('ST_PRDCD','=',$temp['mstd_prdcd'])
                        ->where('ST_LOKASI','=',$LOC1)
                        ->increment('ST_TRFOUT', (int)$temp['mstd_qty']);
                }
                if($LOC1 == '01'){
                    if($chkPlano == '1'){
                        if($gudangtoko == 'G'){
                            $temp2 = DB::connection(Session::get('connection'))->table('TBMASTER_LOKASI')
                                ->selectRaw('*')
                                ->where('LKS_PRDCD','=',$temp['mstd_prdcd'])
                                ->whereRaw("LKS_JENISRAK IN ('D', 'N')")
                                ->where('LKS_NOID','LIKE','%P')
                                ->where('LKS_KODERAK','LIKE','D%')
                                ->count();
                            if($temp2 == 1){
                                DB::connection(Session::get('connection'))->table('TBMASTER_LOKASI')
                                    ->where('LKS_PRDCD','=',$temp['mstd_prdcd'])
                                    ->whereRaw("LKS_JENISRAK IN ('D', 'N')")
                                    ->where('LKS_NOID','LIKE','%P')
                                    ->where('LKS_KODERAK','LIKE','D%')
                                    ->decrement('LKS_QTY',(int)$temp['mstd_qty']);
                            }elseif ($temp2 == 0){
                                $keterangan = 'Tidak Ada Di Rak Display';
                            }else{
                                $keterangan = 'Rak lebih dari 1, ';
                                $recs = DB::connection(Session::get('connection'))->table('TBMASTER_LOKASI')
                                    ->selectRaw('LKS_KODERAK')
                                    ->selectRaw('LKS_KODESUBRAK')
                                    ->selectRaw('LKS_TIPERAK')
                                    ->selectRaw('LKS_SHELVINGRAK')
                                    ->selectRaw('LKS_NOURUT')
                                    ->where('LKS_PRDCD','=',$temp['mstd_prdcd'])
                                    ->whereRaw("LKS_JENISRAK IN ('D', 'N')")
                                    ->where('LKS_NOID','LIKE','%P')
                                    ->where('LKS_KODERAK','LIKE','D%')
                                    ->get();
                                $rak = "";
                                foreach ($recs as $rec){
                                    $rak = $rak."RAK ".$rec->LKS_KODERAK.".".$rec->LKS_KODESUBRAK.".".$rec->LKS_TIPERAK.".".$rec->LKS_SHELVINGRAK.".".$rec->LKS_NOURUT.", ";
                                }
                                $rak = rtrim($rak,", ");
                                $keterangan = $keterangan.$rak;
                            }
                            DB::connection(Session::get('connection'))->table('TBHISTORY_RUBAHSTATUS_RAK')
                                ->insert(['kodeigr' => $kodeigr, 'nodoc' => $noDoc,
                                    'nosortir' => $noSort.' - '.$gudangtoko,
                                    'prdcd' => $temp['mstd_prdcd'], 'deskripsi' => $temp['mstd_desc'],
                                    'qty' => (int)$temp['mstd_qty'], 'keterangan' => substr($keterangan,1,100)]);
                        }
                    }
                }
                if($temp['flagdisc2'] == 'B'){
                    $LOC2 = '01';
                }elseif ($temp['flagdisc2'] == 'T'){
                    $LOC2 = '02';
                }elseif ($temp['flagdisc2'] == 'R'){
                    $LOC2 = '03';
                }
                if($LOC2 == '01'){
                    if($chkPlano == '1'){
                        if($gudangtoko == 'G'){
                            $temp2 = DB::connection(Session::get('connection'))->table('TBMASTER_LOKASI')
                                ->selectRaw('*')
                                ->where('LKS_PRDCD','=',$temp['mstd_prdcd'])
                                ->whereRaw("LKS_JENISRAK IN ('D', 'N')")
                                ->where('LKS_NOID','LIKE','%P')
                                ->where('LKS_KODERAK','LIKE','D%')
                                ->count();
                            if($temp2 == 1){
                                DB::connection(Session::get('connection'))->table('TBMASTER_LOKASI')
                                    ->where('LKS_PRDCD','=',$temp['mstd_prdcd'])
                                    ->whereRaw("LKS_JENISRAK IN ('D', 'N')")
                                    ->where('LKS_NOID','LIKE','%P')
                                    ->where('LKS_KODERAK','LIKE','D%')
                                    ->increment('LKS_QTY',(int)$temp['mstd_qty']);
                            }elseif ($temp2 == 0){
                                $keterangan = 'Tidak Ada Di Rak Display';
                            }else{
                                $keterangan = 'Rak lebih dari 1, ';
                                $recs = DB::connection(Session::get('connection'))->table('TBMASTER_LOKASI')
                                    ->selectRaw('LKS_KODERAK')
                                    ->selectRaw('LKS_KODESUBRAK')
                                    ->selectRaw('LKS_TIPERAK')
                                    ->selectRaw('LKS_SHELVINGRAK')
                                    ->selectRaw('LKS_NOURUT')
                                    ->where('LKS_PRDCD','=',$temp['mstd_prdcd'])
                                    ->whereRaw("LKS_JENISRAK IN ('D', 'N')")
                                    ->where('LKS_NOID','LIKE','%P')
                                    ->where('LKS_KODERAK','LIKE','D%')
                                    ->get();
                                $rak = "";
                                foreach ($recs as $rec){
                                    $rak = $rak."RAK ".$rec->LKS_KODERAK.".".$rec->LKS_KODESUBRAK.".".$rec->LKS_TIPERAK.".".$rec->LKS_SHELVINGRAK.".".$rec->LKS_NOURUT.", ";
                                }
                                $rak = rtrim($rak,", ");
                                $keterangan = $keterangan.$rak;
                                DB::connection(Session::get('connection'))->table('TBHISTORY_RUBAHSTATUS_RAK')
                                    ->insert(['kodeigr' => $kodeigr, 'nodoc' => $noDoc,
                                        'nosortir' => $noSort.' - '.$gudangtoko,
                                        'prdcd' => $temp['mstd_prdcd'], 'descprd' => $temp['mstd_desc'],
                                        'qty' => $temp['mstd_qty'], 'keterangan' => substr($keterangan,1,100)]);
                            }
                        }else{
                            $temp2 = DB::connection(Session::get('connection'))->table('TBMASTER_LOKASI')
                                ->selectRaw('*')
                                ->where('LKS_PRDCD','=',$temp['mstd_prdcd'])
                                ->whereRaw("LKS_JENISRAK IN ('D', 'N')")
                                ->where('LKS_KODERAK',' NOT LIKE','D%')
                                ->count();
                            if($temp2 == 1){
                                DB::connection(Session::get('connection'))->table('TBMASTER_LOKASI')
                                    ->where('LKS_PRDCD','=',$temp['mstd_prdcd'])
                                    ->whereRaw("LKS_JENISRAK IN ('D', 'N')")
                                    ->where('LKS_KODERAK',' NOT LIKE','D%')
                                    ->increment('LKS_QTY',(int)$temp['mstd_qty']);
                            }elseif ($temp2 == 0){
                                $keterangan = 'Tidak Ada Di Rak Display';
                            }else{
                                $keterangan = 'Rak lebih dari 1, ';
                                $recs = DB::connection(Session::get('connection'))->table('TBMASTER_LOKASI')
                                    ->selectRaw('LKS_KODERAK')
                                    ->selectRaw('LKS_KODESUBRAK')
                                    ->selectRaw('LKS_TIPERAK')
                                    ->selectRaw('LKS_SHELVINGRAK')
                                    ->selectRaw('LKS_NOURUT')
                                    ->where('LKS_PRDCD','=',$temp['mstd_prdcd'])
                                    ->whereRaw("LKS_JENISRAK IN ('D', 'N')")
                                    ->where('LKS_KODERAK',' NOT LIKE','D%')
                                    ->get();
                                $rak="";
                                foreach ($recs as $rec){
                                    $rak = $rak."RAK ".$rec->LKS_KODERAK.".".$rec->LKS_KODESUBRAK.".".$rec->LKS_TIPERAK.".".$rec->LKS_SHELVINGRAK.".".$rec->LKS_NOURUT.", ";
                                }
                                $rak = rtrim($rak,", ");
                                $keterangan = $keterangan.$rak;
                                DB::connection(Session::get('connection'))->table('TBHISTORY_RUBAHSTATUS_RAK')
                                    ->insert(['kodeigr' => $kodeigr, 'nodoc' => $noDoc,
                                        'nosortir' => $noSort.' - '.$gudangtoko,
                                        'prdcd' => $temp['mstd_prdcd'], 'descprd' => $temp['mstd_desc'],
                                        'qty' => (int)$temp['mstd_qty'], 'keterangan' => substr($keterangan,1,100)]);
                            }
                        }
                    }
                }
                $temp2 = DB::connection(Session::get('connection'))->table('TBMASTER_STOCK')
                    ->selectRaw('*')
                    ->where('ST_KODEIGR','=',$kodeigr)
                    ->where('ST_PRDCD','=',$temp['mstd_prdcd'])
                    ->where('ST_LOKASI','=',$LOC2)
                    ->count();
                if($temp2 == 0){
                    DB::connection(Session::get('connection'))->table('TBMASTER_STOCK')
                        ->insert(['ST_KODEIGR' => $kodeigr, 'ST_LOKASI' => $LOC2, 'ST_PRDCD' => $temp['mstd_prdcd'],
                            'ST_SALDOAKHIR' => (int)$temp['mstd_qty'], 'ST_TRFIN' => (int)$temp['mstd_qty'], 'ST_CREATE_BY' => $userid,
                            'ST_CREATE_DT' => $today]);
                }else{
                    $qtyakhir = DB::connection(Session::get('connection'))->table('TBMASTER_STOCK')
                        ->selectRaw('ST_SALDOAKHIR')
                        ->where('ST_KODEIGR','=',$kodeigr)
                        ->where('ST_PRDCD','=',$temp['mstd_prdcd'])
                        ->where('ST_LOKASI','=',$LOC2)
                        ->first();
                    $additionalData = DB::connection(Session::get('connection'))->table('TBMASTER_STOCK')
                        ->selectRaw('NVL (ST_SALDOAKHIR, 0) AS SALDOAKHIR')
                        ->selectRaw('NVL (ST_TRFIN, 0) AS TRFIN')
                        ->where('ST_KODEIGR','=',$kodeigr)
                        ->where('ST_PRDCD','=',$temp['mstd_prdcd'])
                        ->where('ST_LOKASI','=',$LOC2)
                        ->first();
//                $trfin = DB::connection(Session::get('connection'))->table('TBMASTER_STOCK')
//
//                    ->where('ST_KODEIGR','=',$kodeigr)
//                    ->where('ST_PRDCD','=',$temp['mstd_prdcd'])
//                    ->where('ST_LOKASI','=',$LOC2)
//                    ->first();
                    DB::connection(Session::get('connection'))->table('TBMASTER_STOCK')
                        ->where('ST_KODEIGR','=',$kodeigr)
                        ->where('ST_PRDCD','=',$temp['mstd_prdcd'])
                        ->where('ST_LOKASI','=',$LOC2)
                        ->update(['ST_SALDOAKHIR' => (int)$additionalData->saldoakhir + (int)$temp['mstd_qty'], 'ST_TRFIN' => (int)$additionalData->trfin + (int)$temp['mstd_qty'], 'ST_MODIFY_BY' => $userid, 'ST_MODIFY_DT' => $today]);
                }
                DB::connection(Session::get('connection'))->table('TBTR_SORTIR_BARANG')
                    ->where('SRT_KODEIGR','=',$kodeigr)
                    ->where('SRT_TYPE','=','S')
                    ->where('SRT_NOSORTIR','=',$noSort)
                    ->where('SRT_PRDCD','=',$temp['mstd_prdcd'])
                    ->update(['SRT_FLAGDISC3' => 'P']);

                $dokumen = $noDoc;
                $mstd_nodoc = null;
                if($flagdisc4 == 'A'){
                    if($mstd_nodoc == null){
                        if($flagretur == 'Y'){
                            $dokumen = $this->nomor_retur;
                        }else{
                            $no_key = DB::connection(Session::get('connection'))->table('tbmaster_nomordoc')
                                ->selectRaw('nomorawal')
                                ->where('kodedoc','=','BTN')
                                ->where('nomordoc','<=',99999)
                                ->orderBy('nomorawal')
                                ->first();

                            $connect = loginController::getConnectionProcedure();

                            $query = oci_parse($connect, "BEGIN :ret := f_igr_get_nomor('$kodeigr','BTN',
                         'Nomor Barang Retur New',
                         TRIM ('$no_key->nomorawal'),
                         5,
                         TRUE);END;");
                            oci_bind_by_name($query, ':ret', $result, 32);
                            oci_execute($query);
                            $dokumen = $result;

                            $this->nomor_retur = $dokumen;
                            $this->flag_retur = 'Y';
                        }
                    }else{
                        $dokumen = $mstd_nodoc;
                        $this->nomor_retur = $dokumen;
                        $this->flag_retur = 'Y';
                    }
                }elseif ($flagdisc4 == 'B'){

                    if($mstd_nodoc == null){

                        if($this->flag_rusak == 'Y'){
                            $dokumen = $this->nomor_rusak;
                        }else{

                            $no_key = DB::connection(Session::get('connection'))->table('tbmaster_nomordoc')
                                ->selectRaw('nomorawal')
                                ->where('kodedoc','=','BRN')
                                ->where('nomordoc','<=',99999)
                                ->orderBy('nomorawal')
                                ->first();

                            $connect = loginController::getConnectionProcedure();


                            $query = oci_parse($connect, "BEGIN :ret := f_igr_get_nomor('$kodeigr','BRN',
                         'Nomor Barang Rusak New',
                         TRIM ('$no_key->nomorawal'),
                         5,
                         TRUE);END;");
                            oci_bind_by_name($query, ':ret', $result, 32);

                            oci_execute($query);
                            $dokumen = $result;
                            $this->nomor_rusak = $dokumen;
                            $this->flag_rusak = 'Y';

                        }
                    }else{
                        $dokumen = $mstd_nodoc;
                        $this->nomor_rusak = $dokumen;
                        $this->flag_rusak = 'Y';

                    }
                }elseif ($flagdisc4 == 'C'){
                    if($mstd_nodoc == null){
                        if($this->flag_putus == 'Y'){
                            $dokumen = $this->nomor_putus;
                        }else{
                            $no_key = DB::connection(Session::get('connection'))->table('tbmaster_nomordoc')
                                ->selectRaw('nomorawal')
                                ->where('kodedoc','=','BPN')
                                ->where('nomordoc','<=',99999)
                                ->orderBy('nomorawal')
                                ->first();

                            $connect = loginController::getConnectionProcedure();

                            $query = oci_parse($connect, "BEGIN :ret := f_igr_get_nomor('$kodeigr','BPN',
                         'Nomor Barang Putus New',
                         TRIM ('$no_key->nomorawal'),
                         5,
                         TRUE);END;");
                            oci_bind_by_name($query, ':ret', $result, 32);

                            oci_execute($query);
                            $dokumen = $result;
                            $this->nomor_putus = $dokumen;
                            $this->flag_putus = 'Y';
                        }
                    }else{
                        $dokumen = $mstd_nodoc;
                        $this->nomor_putus = $dokumen;
                        $this->flag_putus = 'Y';
                    }
                }
                $mstd_nodoc = $dokumen;
                //$flagdisc3 = 'P';

                $STOK_CUR = DB::connection(Session::get('connection'))->table('TBMASTER_STOCK')
                    ->selectRaw('ST_SALDOAKHIR')
                    ->selectRaw('nvl(ST_AVGCOST, 0) ST_AVGCOST')
                    ->where('ST_KODEIGR','=',$kodeigr)
                    ->where('ST_PRDCD','=',$temp['mstd_prdcd'])
                    ->where('ST_LOKASI','=',$LOC2)
                    ->first();

                if(!$STOK_CUR){
                    $ocost = 0 * $FRACPRD;
                    $postqty = 0 - (int)$temp['mstd_qty'];
                }else{
                    $ocost = (int)$STOK_CUR->st_avgcost * $FRACPRD;
                    $postqty = (int)$STOK_CUR->st_saldoakhir - (int)$temp['mstd_qty'];
                }
                $temp2 = DB::connection(Session::get('connection'))->table('TBTR_MSTRAN_H')
                    ->selectRaw('*')
                    ->where('MSTH_KODEIGR','=',$kodeigr)
                    ->where('MSTH_NODOC','=',$dokumen)
                    ->where('MSTH_NOPO','=',$noDoc)
                    ->where('MSTH_NOFAKTUR','=',$noSort)
                    ->count();

                if($temp2 == 0){

                    $sortData = DB::connection(Session::get('connection'))->table('TBTR_SORTIR_BARANG')
                        ->selectRaw('SRT_KODESUPPLIER')
                        ->selectRaw('SRT_PKP')
                        ->where('SRT_KODEIGR','=',$kodeigr)
                        ->where('SRT_NOSORTIR','=',$noSort)
                        ->first();


                    DB::connection(Session::get('connection'))->table('TBTR_MSTRAN_H')
                        ->insert(['MSTH_KODEIGR' => $kodeigr, 'MSTH_TYPETRN' => 'Z', 'MSTH_NODOC' => $dokumen,
                            'MSTH_TGLDOC' => DB::connection(Session::get('connection'))->raw("TO_DATE('".$tglDoc."','dd/mm/yyyy')"), 'MSTH_NOPO' => $noDoc, 'MSTH_TGLPO' => $today, 'MSTH_NOFAKTUR' => $noSort,
                            'MSTH_TGLFAKTUR' => DB::connection(Session::get('connection'))->raw("TO_DATE('".$tglSort."','dd/mm/yyyy')"), 'MSTH_KODESUPPLIER' => $sortData->srt_kodesupplier, 'MSTH_PKP' => $sortData->srt_pkp,
                            'MSTH_KETERANGAN_HEADER' => $txtKeterangan, 'MSTH_FLAGDOC' => '1', 'MSTH_CREATE_BY' => $userid, 'MSTH_CREATE_DT' => $today]);
                }

                if($LOC1 == '01'){
                    $oldAcostPrd = $ACOSTPRD/$FRACPRD;
                    $STOK_CUR = DB::connection(Session::get('connection'))->table('TBMASTER_STOCK')
                        ->selectRaw('ST_SALDOAKHIR')
                        ->selectRaw('nvl(ST_AVGCOST, 0) ST_AVGCOST')
                        ->where('ST_KODEIGR','=',$kodeigr)
                        ->where('ST_PRDCD','=',$temp['mstd_prdcd'])
                        ->where('ST_LOKASI','=',$LOC1)
                        ->first();
                    if(!$STOK_CUR){
                        $stock = 0;
                        $oldcost = 0;
                    }else{
                        $stock = (int)$STOK_CUR->st_saldoakhir;
                        $oldcost = (float)$STOK_CUR->st_avgcost;
                    }
                    $STOK_CUR = DB::connection(Session::get('connection'))->table('TBMASTER_STOCK')
                        ->selectRaw('ST_SALDOAKHIR')
                        ->selectRaw('nvl(ST_AVGCOST, 0) ST_AVGCOST')
                        ->where('ST_KODEIGR','=',$kodeigr)
                        ->where('ST_PRDCD','=',$temp['mstd_prdcd'])
                        ->where('ST_LOKASI','=',$LOC2)
                        ->first();
                    if(!$STOK_CUR){
                        $stock = 0;
                        $oldcost = 0;
                    }else{
                        $stock = (int)$STOK_CUR->st_saldoakhir;
                        $oldcostx = (float)$STOK_CUR->st_avgcost;
                    }

                    $qtystock = $stock - (int)$temp['mstd_qty'];

                    $temp2 = DB::connection(Session::get('connection'))->table('TBMASTER_PRODMAST')
                        ->selectRaw('*')
                        ->where('PRD_KODEIGR','=',$kodeigr)
                        ->where('PRD_PRDCD','=',$temp['mstd_prdcd'])
                        ->count();

                    if($temp2 != 0){
                        if($qtystock>0){
                            $newAcostx = ((($qtystock * $oldcostx) + ((int)$temp['mstd_qty'] * $oldcost))/($qtystock + (int)$temp['mstd_qty']));
                            $newAcost = ((($qtystock * $oldAcostPrd)+((int)$temp['mstd_qty'] * $oldcost))/($qtystock + (int)$temp['mstd_qty']));
                        }else{
                            $newAcostx = ((int)$temp['mstd_qty'] * $oldcost) / (int)$temp['mstd_qty'];
                            $newAcost = ((int)$temp['mstd_qty'] * $oldcost) / (int)$temp['mstd_qty'];
                        }
                    }
                }else{
                    $temp2 = DB::connection(Session::get('connection'))->table('TBMASTER_PRODMAST')
                        ->selectRaw('*')
                        ->where('PRD_KODEIGR','=',$kodeigr)
                        ->where('PRD','=',$temp['mstd_prdcd'])
                        ->count();
                    if($temp2 != 0){
                        $oldAcostPrd = $ACOSTPRD / $FRACPRD;
                        $STOK_CUR = DB::connection(Session::get('connection'))->table('TBMASTER_STOCK')
                            ->selectRaw('ST_SALDOAKHIR')
                            ->selectRaw('nvl(ST_AVGCOST, 0) ST_AVGCOST')
                            ->where('ST_KODEIGR','=',$kodeigr)
                            ->where('ST_PRDCD','=',$temp['mstd_prdcd'])
                            ->where('ST_LOKASI','=',$LOC1)
                            ->first();
                        if(!$STOK_CUR){
                            $stock = 0;
                            $oldcost = 0;
                        }else{
                            $stock = (int)$STOK_CUR->st_saldoakhir;
                            $oldcost = (float)$STOK_CUR->st_avgcost;
                        }
                        $temp3 = DB::connection(Session::get('connection'))->table('TBMASTER_STOCK')
                            ->selectRaw('*')
                            ->where('ST_KODEIGR','=',$kodeigr)
                            ->where('ST_PRDCD','=',$temp['mstd_prdcd'])
                            ->where('ST_LOKASI','=',$LOC2)
                            ->count();

                        if($temp3 != 0){
                            $STOK_CUR = DB::connection(Session::get('connection'))->table('TBMASTER_STOCK')
                                ->selectRaw('ST_SALDOAKHIR')
                                ->selectRaw('nvl(ST_AVGCOST, 0) ST_AVGCOST')
                                ->where('ST_KODEIGR','=',$kodeigr)
                                ->where('ST_PRDCD','=',$temp['mstd_prdcd'])
                                ->where('ST_LOKASI','=',$LOC2)
                                ->first();
                            if(!$STOK_CUR){
                                $stock = 0;
                                $oldcost = 0;
                            }else{
                                $stock = (int)$STOK_CUR->st_saldoakhir;
                                $oldacostx = (float)$STOK_CUR->st_avgcost;
                            }
                            $qtystock = $stock - (int)$temp['mstd_qty'];

                            if($qtystock > 0){
                                $newAcostx = (($qtystock * $oldacostx) + ((int)$temp['mstd_qty'] * $oldcost)) / ($qtystock + (int)$temp['mstd_qty']);
                                $newAcost = (($qtystock * $oldAcostPrd) + ((int)$temp['mstd_qty'] * $oldcost)) / ($qtystock + (int)$temp['mstd_qty']);
                            }else{
                                $newAcostx = ((int)$temp['mstd_qty']*$oldcost)/(int)$temp['mstd_qty'];
                                $newAcost = ((int)$temp['mstd_qty']*$oldcost)/(int)$temp['mstd_qty'];
                            }
                        }

                    }
                }
                $lCostStk = DB::connection(Session::get('connection'))->table('TBMASTER_STOCK')
                    ->selectRaw('ST_LASTCOST')
                    ->where('ST_KODEIGR','=',$kodeigr)
                    ->where('ST_PRDCD','=',$temp['mstd_prdcd'])
                    ->where('ST_LOKASI','=','01')
                    ->first();
                $temp2 = DB::connection(Session::get('connection'))->table('TBHISTORY_COST')
                    ->selectRaw('*')
                    ->where('HCS_KODEIGR','=',$kodeigr)
                    ->where('HCS_PRDCD','=',$temp['mstd_prdcd'])
                    ->where('HCS_TGLBPB','=',$today)
                    ->where('HCS_NODOCBPB','=',$mstd_nodoc)
                    ->count();
                if($temp2 == 0){
                    DB::connection(Session::get('connection'))->table('TBHISTORY_COST')
                        ->insert(['HCS_KODEIGR' => $kodeigr,'HCS_TYPETRN' => 'Z','HCS_LOKASI' => $LOC2,
                            'HCS_PRDCD' => $temp['mstd_prdcd'], 'HCS_TGLBPB' => $today,'HCS_NODOCBPB' => $mstd_nodoc,
                            'HCS_AVGLAMA' => ($oldcostx * $FRACPRD),'HCS_AVGBARU' => ($newAcostx * $FRACPRD),
                            'HCS_LASTCOSTLAMA' => ((float)$lCostStk->st_lastcost * $FRACPRD), 'HCS_LASTCOSTBARU' => ((float)$lCostStk->st_lastcost * $FRACPRD),
                            'HCS_CREATE_BY' => $userid, 'HCS_CREATE_DT' => $today, 'HCS_QTYLAMA' => (int)$qtyakhir->st_saldoakhir,
                            'HCS_QTYBARU' => (int)$temp['mstd_qty'], 'HCS_LASTQTY' => ((int)$temp['mstd_qty'] + (int)$qtyakhir->st_saldoakhir)]);
                }
                if($LOC2 == '01') {
                    DB::connection(Session::get('connection'))->table('TBMASTER_PRODMAST')
                        ->where('PRD_KODEIGR', '=', $kodeigr)
                        ->whereRaw("SUBSTR (PRD_PRDCD, 1, 6) = SUBSTR ( " . $temp['mstd_prdcd'] . ", 1, 6)")
                        ->update(['PRD_AVGCOST' => ($newAcost * $FRACPRD)]);
                }
                DB::connection(Session::get('connection'))->table('TBMASTER_STOCK')
                    ->where('ST_KODEIGR','=',$kodeigr)
                    ->where('ST_PRDCD','=',$temp['mstd_prdcd'])
                    ->where('ST_LOKASI','=',$LOC2)
                    ->update(['ST_AVGCOST' => $newAcostx, 'ST_LASTCOST' => (float)$lCostStk->st_lastcost]);
                $mstd_avgcost = $newAcostx * $FRACPRD;

                if($this->flagisi == 'Y'){

                    $no_key = DB::connection(Session::get('connection'))->table('tbmaster_nomordoc')
                        ->selectRaw('nomorawal')
                        ->where('kodedoc','=','RSN')
                        ->where('nomordoc','<',100000)
                        ->orderBy('nomorawal')
                        ->first();
                    $connect = loginController::getConnectionProcedure();

                    $query = oci_parse($connect, "BEGIN :ret := f_igr_get_nomor('$kodeigr','RSN',
                     'Nomor Rubah Status New',
                     TRIM ('$no_key->nomorawal'),
                     5,
                     TRUE);END;");
                    oci_bind_by_name($query, ':ret', $result, 32);
                    oci_execute($query);
                    $dokumen = $result;
                    $this->flagisi = 'N';
                }

                $sortData = DB::connection(Session::get('connection'))->table('TBTR_SORTIR_BARANG')
                    ->selectRaw('SRT_KODESUPPLIER')
                    ->selectRaw('SRT_KODEDEPARTEMENT')
                    ->selectRaw('SRT_PKP')
                    ->selectRaw('SRT_BKP')
                    ->selectRaw('SRT_KODEDIVISI')
                    ->selectRaw('SRT_KODEKATEGORIBARANG')
                    ->selectRaw('SRT_UNIT')
                    ->selectRaw('SRT_FRAC')
                    ->selectRaw('SRT_HRGSATUAN')
                    ->where('SRT_KODEIGR','=',$kodeigr)
                    ->where('SRT_TYPE','=','S')
                    ->where('SRT_NOSORTIR','=',$noSort)
                    ->where('SRT_PRDCD','=',$temp['mstd_prdcd'])
                    ->first();
//            $crDate = $checker->mstd_tgldoc;
//            $creator = $checker->mstd_create_by;
//            $crDate2 = $checker->mstd_create_dt;
//            dd($crDate);
                if($case == 1){
                    DB::connection(Session::get('connection'))->table('TBTR_MSTRAN_D')
                        ->insert(['MSTD_KODEIGR' => $kodeigr, 'MSTD_RECORDID' => null, 'MSTD_TYPETRN' => 'Z', 'MSTD_NODOC' => $mstd_nodoc, 'MSTD_TGLDOC' => $crDate,
                            'MSTD_DOCNO2' => null, 'MSTD_DATE2' => null, 'MSTD_NOPO' => $noDoc, 'MSTD_TGLPO' => $crDate, 'MSTD_NOFAKTUR' => $noSort, 'MSTD_TGLFAKTUR' => DB::connection(Session::get('connection'))->raw("TO_DATE('".$tglSort."','dd/mm/yyyy')"),
                            'MSTD_NOREF3' => null, 'MSTD_TGREF3' => null, 'MSTD_ISTYPE' => null, 'MSTD_INVNO' => null, 'MSTD_DATE3' => null, 'MSTD_NOTT' => null,
                            'MSTD_TGLTT' => null, 'MSTD_KODESUPPLIER' => $sortData->srt_kodesupplier, 'MSTD_PKP' => $sortData->srt_pkp, 'MSTD_CTERM' => null, 'MSTD_SEQNO' => $i, 'MSTD_PRDCD' => $temp['mstd_prdcd'],
                            'MSTD_KODEDIVISI' => $sortData->srt_kodedivisi, 'MSTD_KODEDEPARTEMENT' => $sortData->srt_kodedepartement, 'MSTD_KODEKATEGORIBRG' => $sortData->srt_kodekategoribarang, 'MSTD_BKP' => $sortData->srt_bkp, 'MSTD_FOBKP' => null,
                            'MSTD_UNIT' => $sortData->srt_unit, 'MSTD_FRAC' => $sortData->srt_frac, 'MSTD_LOC' => $kodeigr, 'MSTD_LOC2' => null, 'MSTD_QTY' => ($temp['mstd_qty']), 'MSTD_QTYBONUS1' => null,
                            'MSTD_QTYBONUS2' => null, 'MSTD_HRGSATUAN' => $sortData->srt_hrgsatuan, 'MSTD_PERSENDISC1' => null, 'MSTD_RPHDISC1' => null, 'MSTD_FLAGDISC1' => $temp['flagdisc1'],
                            'MSTD_PERSENDISC2' => null, 'MSTD_RPHDISC2' => null, 'MSTD_FLAGDISC2' => $temp['flagdisc2'], 'MSTD_PERSENDISC2II' => null, 'MSTD_RPHDISC2II' => null,
                            'MSTD_PERSENDISC2III' => null, 'MSTD_RPHDISC2III' => null, 'MSTD_PERSENDISC3' => null, 'MSTD_RPHDISC3' => null, 'MSTD_FLAGDISC3' => 'P',
                            'MSTD_PERSENDISC4' => null, 'MSTD_RPHDISC4' => null, 'MSTD_FLAGDISC4' => $flagdisc4, 'MSTD_DIS4CP' => null, 'MSTD_DIS4CR' => null,
                            'MSTD_DIS4RP' => null, 'MSTD_DIS4RR' => null, 'MSTD_DIS4JP' => null, 'MSTD_DIS4JR' => null, 'MSTD_GROSS' => (float)$temp['gross'], 'MSTD_DISCRPH' => null,
                            'MSTD_PPNRPH' => null, 'MSTD_PPNBMRPH' => null, 'MSTD_PPNBTLRPH' => null, 'MSTD_AVGCOST' => $mstd_avgcost, 'MSTD_OCOST' => $ocost, 'MSTD_POSQTY' => $postqty,
                            'MSTD_KETERANGAN' => null, 'MSTD_FK' => null, 'MSTD_TGLFP' => null, 'MSTD_KODETAG' => null, 'MSTD_FURGNT' => null, 'MSTD_GDG' => null,
                            'MSTD_CREATE_BY' => $creator, 'MSTD_CREATE_DT' => $crDate2, 'MSTD_MODIFY_BY' => $userid, 'MSTD_MODIFY_DT' => $today]);


                }else{
                    DB::connection(Session::get('connection'))->table('TBTR_MSTRAN_D')
                        ->insert(['MSTD_KODEIGR' => $kodeigr, 'MSTD_RECORDID' => null, 'MSTD_TYPETRN' => 'Z', 'MSTD_NODOC' => $mstd_nodoc, 'MSTD_TGLDOC' => DB::connection(Session::get('connection'))->raw("TO_DATE('".$tglDoc."','dd/mm/yyyy')"),
                            'MSTD_DOCNO2' => null, 'MSTD_DATE2' => null, 'MSTD_NOPO' => $noDoc, 'MSTD_TGLPO' => DB::connection(Session::get('connection'))->raw("TO_DATE('".$tglDoc."','dd/mm/yyyy')"), 'MSTD_NOFAKTUR' => $noSort, 'MSTD_TGLFAKTUR' => DB::connection(Session::get('connection'))->raw("TO_DATE('".$tglSort."','dd/mm/yyyy')"),
                            'MSTD_NOREF3' => null, 'MSTD_TGREF3' => null, 'MSTD_ISTYPE' => null, 'MSTD_INVNO' => null, 'MSTD_DATE3' => null, 'MSTD_NOTT' => null,
                            'MSTD_TGLTT' => null, 'MSTD_KODESUPPLIER' => $sortData->srt_kodesupplier, 'MSTD_PKP' => $sortData->srt_pkp, 'MSTD_CTERM' => null, 'MSTD_SEQNO' => $i, 'MSTD_PRDCD' => $temp['mstd_prdcd'],
                            'MSTD_KODEDIVISI' => $sortData->srt_kodedivisi, 'MSTD_KODEDEPARTEMENT' => $sortData->srt_kodedepartement, 'MSTD_KODEKATEGORIBRG' => $sortData->srt_kodekategoribarang, 'MSTD_BKP' => $sortData->srt_bkp, 'MSTD_FOBKP' => null,
                            'MSTD_UNIT' => $sortData->srt_unit, 'MSTD_FRAC' => $sortData->srt_frac, 'MSTD_LOC' => $kodeigr, 'MSTD_LOC2' => null, 'MSTD_QTY' => ($temp['mstd_qty']), 'MSTD_QTYBONUS1' => null,
                            'MSTD_QTYBONUS2' => null, 'MSTD_HRGSATUAN' => $sortData->srt_hrgsatuan, 'MSTD_PERSENDISC1' => null, 'MSTD_RPHDISC1' => null, 'MSTD_FLAGDISC1' => $temp['flagdisc1'],
                            'MSTD_PERSENDISC2' => null, 'MSTD_RPHDISC2' => null, 'MSTD_FLAGDISC2' => $temp['flagdisc2'], 'MSTD_PERSENDISC2II' => null, 'MSTD_RPHDISC2II' => null,
                            'MSTD_PERSENDISC2III' => null, 'MSTD_RPHDISC2III' => null, 'MSTD_PERSENDISC3' => null, 'MSTD_RPHDISC3' => null, 'MSTD_FLAGDISC3' => 'P',
                            'MSTD_PERSENDISC4' => null, 'MSTD_RPHDISC4' => null, 'MSTD_FLAGDISC4' => $flagdisc4, 'MSTD_DIS4CP' => null, 'MSTD_DIS4CR' => null,
                            'MSTD_DIS4RP' => null, 'MSTD_DIS4RR' => null, 'MSTD_DIS4JP' => null, 'MSTD_DIS4JR' => null, 'MSTD_GROSS' => (float)$temp['gross'], 'MSTD_DISCRPH' => null,
                            'MSTD_PPNRPH' => null, 'MSTD_PPNBMRPH' => null, 'MSTD_PPNBTLRPH' => null, 'MSTD_AVGCOST' => $mstd_avgcost, 'MSTD_OCOST' => $ocost, 'MSTD_POSQTY' => $postqty,
                            'MSTD_KETERANGAN' => null, 'MSTD_FK' => null, 'MSTD_TGLFP' => null, 'MSTD_KODETAG' => null, 'MSTD_FURGNT' => null, 'MSTD_GDG' => null,
                            'MSTD_CREATE_BY' => $userid, 'MSTD_CREATE_DT' => $today, 'MSTD_MODIFY_BY' => null, 'MSTD_MODIFY_DT' => null]);

                }
            }DB::connection(Session::get('connection'))->commit();
            return response()->json(['kode' => 1, 'msg' => $noDoc]);
        }
        catch(\Exception $e){
            DB::connection(Session::get('connection'))->rollBack();
            // do task when error
            //echo $e->getMessage();   // insert query
            return response()->json(['kode' => 2, 'msg' => $e->getMessage()]);
        }

    }
    public function checkDocument(Request $request){
        $noDoc      = $request->noDoc;
        $kodeigr = Session::get('kdigr');

        $datas = DB::connection(Session::get('connection'))->select("SELECT MSTD_FLAGDISC4
                                    from TBTR_MSTRAN_H,  TBTR_MSTRAN_D
                                    where MSTH_KODEIGR = '$kodeigr'
                                            AND MSTH_NOPO = '$noDoc'
                                            AND MSTD_KODEIGR = MSTH_KODEIGR
                                            AND MSTD_NOPO = MSTH_NOPO
                                            AND MSTD_NODOC = MSTH_NODOC
                                    order by MSTH_NODOC
");
        $barangRusak = "false";
        $barangRetur = "false";
        $perubahanStatus = "false";
        for($i=0;$i<sizeof($datas);$i++){
            if($datas[$i]->mstd_flagdisc4 == 'A'){
                $barangRetur = "true";
            }
            if($datas[$i]->mstd_flagdisc4 == 'B'){
                $barangRusak = "true";
            }
            if($datas[$i]->mstd_flagdisc4 == 'C'){
                $perubahanStatus = "true";
            }
        }
        return response()->json(['barangrusak' => $barangRusak, 'barangretur' => $barangRetur, 'perubahanstatus' => $perubahanStatus]);
    }
    public function printDocument(Request $request){
        $noDoc      = $request->doc;
        $page       = $request->page;
        $kodeigr = Session::get('kdigr');
        $P_FLAG = '1';

        $datas = DB::connection(Session::get('connection'))->select("SELECT MSTH_NODOC, MSTH_TGLDOC, MSTH_NOPO, MSTH_NOFAKTUR, MSTH_KETERANGAN_HEADER,
                                        MSTD_PRDCD, MSTD_UNIT, MSTD_FRAC, MSTD_HRGSATUAN, MSTD_FLAGDISC4,
                                        FLOOR(MSTD_QTY/MSTD_FRAC) AS CTN, MOD(MSTD_QTY,MSTD_FRAC) AS PCS, (MSTD_GROSS) AS total ,
                                        HGB_KODESUPPLIER, SUP_NAMASUPPLIER, PRD_DESKRIPSIPANJANG,
                                        PRS_NAMAPERUSAHAAN, PRS_NAMACABANG, PRS_ALAMAT1, PRS_NAMAWILAYAH, PRS_NPWP, PRS_TELEPON,
                                        CASE WHEN MSTD_FLAGDISC4 = 'A' THEN
                                            CASE WHEN '$P_FLAG' = '1' THEN 'DAFTAR BARANG RETUR'
                                            ELSE 'DAFTAR BARANG RETUR ( BATAL )'
                                            END
                                        ELSE
                                            CASE WHEN MSTD_FLAGDISC4 = 'B' THEN
                                              CASE WHEN '$P_FLAG' = '1' THEN 'NOTA BARANG RUSAK'
                                              ELSE 'NOTA BARANG RUSAK ( BATAL )'
                                              END
                                            ELSE
                                                CASE WHEN MSTD_FLAGDISC4 = 'C' THEN
                                                  CASE WHEN '$P_FLAG' = '1' THEN 'BUKTI PERUBAHAN STATUS'
                                                  ELSE 'BUKTI PERUBAHAN STATUS ( BATAL )'
                                                  END
                                               END
                                            END
                                        END AS JUDUL,
                                        CASE WHEN MSTD_FLAGDISC4 = 'A' THEN 'No. NB-Retur'
                                        ELSE
                                            CASE WHEN MSTD_FLAGDISC4 = 'B' THEN 'No. NB-Rusak'
                                            ELSE
                                                CASE WHEN MSTD_FLAGDISC4 = 'C' THEN 'No. BPS'
                                                  ELSE ''
                                               END
                                            END
                                        END AS LABEL
                                    from TBTR_MSTRAN_H,  TBTR_MSTRAN_D, TBMASTER_PRODMAST, TBMASTER_PERUSAHAAN, TBMASTER_HARGABELI, TBMASTER_SUPPLIER
                                    where MSTH_KODEIGR = '$kodeigr'
                                            AND MSTH_NOPO = '$noDoc'
                                            AND MSTD_KODEIGR = MSTH_KODEIGR
                                            AND MSTD_NOPO = MSTH_NOPO
                                            AND MSTD_NODOC = MSTH_NODOC
                                            AND PRD_KODEIGR = MSTH_KODEIGR
                                            AND PRD_PRDCD = MSTD_PRDCD
                                            AND PRS_KODEIGR = MSTH_KODEIGR
                                            AND HGB_TIPE = '2'
                                            AND HGB_PRDCD = MSTD_PRDCD
                                            AND HGB_KODEIGR = MSTH_KODEIGR
                                            AND SUP_KODESUPPLIER = HGB_KODESUPPLIER
                                            AND SUP_KODEIGR = MSTH_KODEIGR
                                    order by MSTH_NODOC
");

        DB::connection(Session::get('connection'))->table('TBTR_MSTRAN_D')->where('MSTD_NODOC', $noDoc)->whereNull('mstd_flagdisc3')->update(['mstd_flagdisc3' => 'P']);


        $today  = date('d-m-Y H:i:s');
        $perusahaan = DB::table("tbmaster_perusahaan")->first();
        if($page == 'barangrusak'){
            return view('BACKOFFICE.TRANSAKSI.PERUBAHANSTATUS.rubah-status-barang-rusak-laporan',
                ['data' => $datas, 'perusahaan' => $perusahaan]);
        }elseif($page == 'barangretur'){
            return view('BACKOFFICE.TRANSAKSI.PERUBAHANSTATUS.rubah-status-barang-retur-laporan',
                ['data' => $datas, 'perusahaan' => $perusahaan]);
        }elseif($page == 'perubahanstatus'){
            return view('BACKOFFICE.TRANSAKSI.PERUBAHANSTATUS.rubah-status-perubahan-status-laporan',
                ['data' => $datas, 'perusahaan' => $perusahaan]);
        }else{
            return view('errors.404');
        }
    }

    public function checkRak(Request $request){
        $noDoc      = $request->noDoc;
        $kodeigr = Session::get('kdigr');

        $rakChecker = DB::connection(Session::get('connection'))->table('tbhistory_rubahstatus_rak')
            ->selectRaw('*')
            ->where('kodeigr','=',$kodeigr)
            ->where('nodoc','=',$noDoc)
            ->first();
        if($rakChecker){
            return response()->json(['rak' => 1]);
        }else{
            return response()->json(['rak' => 2]);
        }

    }

    public function printDocumentRak(Request $request){
        $noDoc      = $request->doc;
        $kodeigr = Session::get('kdigr');

        $today  = date('Y-m-d');

        $datas = DB::connection(Session::get('connection'))->select("SELECT RAK.*, PRS_NAMAPERUSAHAAN, PRS_NAMAWILAYAH
                                FROM TBHISTORY_RUBAHSTATUS_RAK RAK, TBMASTER_PERUSAHAAN
                                WHERE KODEIGR = '$kodeigr' AND NODOC = '$noDoc'
                                AND PRS_KODEIGR = KODEIGR
");
        $perusahaan = DB::table("tbmaster_perusahaan")->first();
        return view('BACKOFFICE.TRANSAKSI.PERUBAHANSTATUS.rubah-status-rak-laporan',
            ['data' => $datas, 'perusahaan' => $perusahaan]);

    }
}
