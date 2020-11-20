<?php
namespace App\Http\Controllers\BACKOFFICE\TRANSAKSI\PERUBAHANSTATUS;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use PDF;

class rubahStatusController extends Controller
{
    public function index(){
        return view('BACKOFFICE/TRANSAKSI/PERUBAHANSTATUS.rubahStatus');
    }

    public function getNewNmrRsn(){
        $kodeigr = $_SESSION['kdigr'];
        $no_key = DB::table('tbmaster_nomordoc')
            ->selectRaw('nomorawal')
            ->where('kodedoc',"=",'RSN')
            ->where('nomordoc',"<=", 99999)
            ->orderBy('nomorawal')
            ->first();

        $connect = oci_connect('SIMSMG', 'SIMSMG', '192.168.237.193:1521/SIMSMG');

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
        $kodeigr= $_SESSION['kdigr'];

        $datas = DB::table('tbtr_mstran_h')
            ->selectRaw('distinct msth_nopo as msth_nopo')
            ->selectRaw('msth_tglpo')
            ->selectRaw('msth_keterangan_header')
            ->leftJoin('tbtr_sortir_barang', function($join){
                $join->on('srt_nosortir', 'msth_nofaktur');
                $join->on('srt_tglsortir', 'msth_tgldoc');
            })
            ->where('msth_nopo','LIKE', '%'.$search.'%')
            ->where('msth_typetrn','=', 'Z')
            ->where('msth_kodeigr','=', $kodeigr)
            ->where('SRT_TYPE','=','S')
            ->orderByDesc('msth_nopo')
//            ->orderByDesc('rsk_create_dt')
            ->limit(100)
            ->get();

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
            ->where('SRT_TYPE','=','S')
            ->orderByDesc('SRT_NOSORTIR')
//            ->orderByDesc('rsk_create_dt')
            ->limit(100)
            ->get();

        return response()->json($datas);
    }

    public function chooseRsn(Request $request){
        $kode = $request->kode;
        $kodeigr= $_SESSION['kdigr'];
        $_SESSION['flagisi'] = 'Y';
        $_SESSION['flag_retur'] = 'N';
        $_SESSION['flag_rusak'] = 'N';
        $_SESSION['flag_putus'] = 'N';

        $datas = DB::table('tbtr_mstran_h')
            ->selectRaw('msth_nopo')
            ->selectRaw('msth_tgldoc')
            ->selectRaw('msth_nofaktur')
            ->selectRaw('msth_tglfaktur')
            ->selectRaw('msth_keterangan_header')
            ->selectRaw('srt_nosortir')
            ->selectRaw('srt_tglsortir')
            ->selectRaw('srt_gudangtoko')
            ->selectRaw('mstd_prdcd')
            ->selectRaw('prd_deskripsipanjang')
            ->selectRaw('prd_frac')
            ->selectRaw('prd_unit')
            ->selectRaw('prd_perlakuanbarang')
            ->selectRaw('srt_qtykarton')
            ->selectRaw('srt_qtypcs')
            ->selectRaw('mstd_hrgsatuan')
            ->selectRaw('mstd_gross')
            ->selectRaw("Case When MSTD_FLAGDISC3='P'  OR MSTD_FLAGDISC3='p' Then 'Data Sudah Dicetak' Else 'Data Belum dicetak' End  Nota")
            ->leftJoin('tbtr_mstran_d','msth_nopo','=','mstd_nopo')
            ->leftJoin('tbtr_sortir_barang', function($join){
                $join->on('srt_nosortir', 'msth_nofaktur');
                $join->on('srt_tglsortir', 'msth_tgldoc');
                $join->on('srt_prdcd', 'mstd_prdcd');
            })
            ->leftJoin('tbmaster_prodmast', 'mstd_prdcd','=','prd_prdcd')
            ->where('msth_nopo','=', $kode)
            ->where('msth_kodeigr','=', $kodeigr)
            ->where('msth_typetrn','=', 'Z')
            ->whereRaw("nvl(msth_recordid, 0)<>'1'")
            ->get();

//        $test = DB::table('tbtr_barangrusak')->limit(10)->get()->toArray();
//        dd($datas);

        return response()->json($datas);
    }

    public function chooseSrt(Request $request){
        $kode = $request->kode;

        $datas = DB::table('TBTR_SORTIR_BARANG')
            ->selectRaw('SRT_NOSORTIR')
            ->selectRaw('SRT_TGLSORTIR')
            ->selectRaw('SRT_FLAGDISC3')
            ->selectRaw('srt_gudangtoko')
            ->selectRaw('SRT_PRDCD')
            ->selectRaw('SRT_QTYKARTON')
            ->selectRaw('SRT_QTYPCS')
            ->selectRaw('SRT_HRGSATUAN')
            ->selectRaw('prd_deskripsipanjang')
            ->selectRaw('prd_frac')
            ->selectRaw('prd_unit')
            ->selectRaw('prd_perlakuanbarang')
            ->leftJoin('tbmaster_prodmast', 'prd_prdcd', 'srt_prdcd')
            ->where('SRT_NOSORTIR', $kode)
            ->get();

//        $test = DB::table('tbtr_barangrusak')->limit(10)->get()->toArray();
//        dd($datas);

        return response()->json($datas);
    }

    public function saveData(Request $request){
        $datas  = $request->datas;
        $noDoc = $request->noDoc;
        $noSort = $request->noSort;
        $chkPlano = $request->statusPlano;
        $gudangtoko = $request->gudangtoko;
        $txtKeterangan = $request->keterangan;
        $keterangan = '';
        $userid = $_SESSION['usid'];
        $kodeigr = $_SESSION['kdigr'];
        $flagretur = $_SESSION['flag_retur'];
        $today  = date('Y-m-d H:i:s');
        $tglSort = date($request->tglSort);
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

            $PRDCD_CUR = DB::table('tbmaster_prodmast')
                ->selectRaw('PRD_FRAC')
                ->selectRaw('PRD_UNIT')
                ->selectRaw('PRD_KODEDIVISI')
                ->selectRaw('PRD_KODEDEPARTEMENT')
                ->selectRaw('PRD_KODEKATEGORIBARANG')
                ->selectRaw('PRD_AVGCOST')
                ->selectRaw('PRD_DESKRIPSIPANJANG')
                ->where('PRD_KODEIGR','=',$kodeigr)
                ->where('PRD_PRDCD','=',$temp['mstd_prdcd'])
                ->get();

            if($PRDCD_CUR){
                $FRACPRD = $PRDCD_CUR->PRD_FRAC;
                $UNITPRD = $PRDCD_CUR->PRD_UNIT;
                $DIVPRD = $PRDCD_CUR->PRD_KODEDIVISI;
                $DEPPRD = $PRDCD_CUR->PRD_KODEDEPARTEMENT;
                $KATPRD = $PRDCD_CUR->PRD_KODEKATEGORIBARANG;
                $ACOSTPRD = $PRDCD_CUR->PRD_AVGCOST;
                $DESCPRD = $PRDCD_CUR->PRD_DESKRIPSIPANJANG;
                if($UNITPRD == 'KG'){
                    $FRACPRD = 1;
                }elseif ($FRACPRD == null){
                    $FRACPRD = 1;
                }
                if($temp['flagdisc1'] = 'B'){
                    $LOC1 = '01';
                }elseif ($temp['flagdisc1'] = 'T'){
                    $LOC1 = '02';
                }elseif ($temp['flagdisc1'] = 'R'){
                    $LOC1 = '03';
                }
                $tempStock = DB::table('TBMASTER_STOCK')
                    ->selectRaw('*')
                    ->where('ST_KODEIGR','=',$kodeigr)
                    ->where('ST_PRDCD','=',$temp['mstd_prdcd'])
                    ->where('ST_LOKASI','=',$LOC1)
                    ->first();
                if($tempStock){
                    DB::table('TBMASTER_STOCK')
                        ->insert(['ST_KODEIGR' => $kodeigr, 'ST_LOKASI' => $LOC1, 'ST_PRDCD' => $temp['mstd_prdcd'],
                            'ST_SALDOAKHIR' => $temp['mstd_qty'], 'ST_TRFOUT' => $temp['mstd_qty'],
                            'ST_CREATE_BY' => $userid, 'ST_CREATE_DT' => $today]);
                }else{
                    DB::table('TBMASTER_STOCK')
                        ->where('ST_KODEIGR','=',$kodeigr)
                        ->where('ST_PRDCD','=',$temp['mstd_prdcd'])
                        ->where('ST_LOKASI','=',$LOC1)
                        ->update(['ST_MODIFY_BY' => $userid, 'ST_MODIFY_DT' => $today]);

                    DB::table('TBMASTER_STOCK')
                        ->where('ST_KODEIGR','=',$kodeigr)
                        ->where('ST_PRDCD','=',$temp['mstd_prdcd'])
                        ->where('ST_LOKASI','=',$LOC1)
                        ->decrement('ST_SALDOAKHIR', $temp['mstd_qty']);

                    DB::table('TBMASTER_STOCK')
                        ->where('ST_KODEIGR','=',$kodeigr)
                        ->where('ST_PRDCD','=',$temp['mstd_prdcd'])
                        ->where('ST_LOKASI','=',$LOC1)
                        ->increment('ST_TRFOUT', $temp['mstd_qty']);
                }
                if($LOC1 == '01'){
                    if($chkPlano = '1'){
                        if($gudangtoko = 'G'){
                            $temp2 = DB::table('TBMASTER_LOKASI')
                                ->selectRaw('*')
                                ->where('LKS_PRDCD','=',$temp['mstd_prdcd'])
                                ->whereRaw("LKS_JENISRAK IN ('D', 'N')")
                                ->where('LKS_NOID','LIKE','%P')
                                ->where('LKS_KODERAK','LIKE','D%')
                                ->count();
                            if($temp2 == 1){
                                DB::table('TBMASTER_LOKASI')
                                    ->where('LKS_PRDCD','=',$temp['mstd_prdcd'])
                                    ->whereRaw("LKS_JENISRAK IN ('D', 'N')")
                                    ->where('LKS_NOID','LIKE','%P')
                                    ->where('LKS_KODERAK','LIKE','D%')
                                    ->decrement('LKS_QTY',$temp['mstd_qty']);
                            }elseif ($temp2 == 0){
                                $keterangan = 'Tidak Ada Di Rak Display';
                            }else{
                                $keterangan = 'Rak lebih dari 1, ';
                                $recs = DB::table('TBMASTER_LOKASI')
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
                            DB::table('TBHISTORY_RUBAHSTATUS_RAK')
                                ->insert(['kodeigr' => $kodeigr, 'nodoc' => $noDoc,
                                    'nosortir' => $temp['mstd_nofaktur'].' - '.$gudangtoko,
                                    'prdcd' => $temp['mstd_prdcd'], 'descprd' => $temp['mstd_desc'],
                                    'qty' => $temp['mstd_qty'], 'keterangan' => substr($keterangan,1,100)]);
                        }
                    }
                }
                if($temp['flagdisc2'] = 'B'){
                    $LOC2 = '01';
                }elseif ($temp['flagdisc2'] = 'T'){
                    $LOC2 = '02';
                }elseif ($temp['flagdisc2'] = 'R'){
                    $LOC2 = '03';
                }
                if($LOC2 == '01'){
                    if($chkPlano == '1'){
                        if($gudangtoko = 'G'){
                            $temp2 = DB::table('TBMASTER_LOKASI')
                                ->selectRaw('*')
                                ->where('LKS_PRDCD','=',$temp['mstd_prdcd'])
                                ->whereRaw("LKS_JENISRAK IN ('D', 'N')")
                                ->where('LKS_NOID','LIKE','%P')
                                ->where('LKS_KODERAK','LIKE','D%')
                                ->count();
                            if($temp2 == 1){
                                DB::table('TBMASTER_LOKASI')
                                    ->where('LKS_PRDCD','=',$temp['mstd_prdcd'])
                                    ->whereRaw("LKS_JENISRAK IN ('D', 'N')")
                                    ->where('LKS_NOID','LIKE','%P')
                                    ->where('LKS_KODERAK','LIKE','D%')
                                    ->increment('LKS_QTY',$temp['mstd_qty']);
                            }elseif ($temp2 == 0){
                                $keterangan = 'Tidak Ada Di Rak Display';
                            }else{
                                $keterangan = 'Rak lebih dari 1, ';
                                $recs = DB::table('TBMASTER_LOKASI')
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
                                DB::table('TBHISTORY_RUBAHSTATUS_RAK')
                                    ->insert(['kodeigr' => $kodeigr, 'nodoc' => $noDoc,
                                        'nosortir' => $temp['mstd_nofaktur'].' - '.$gudangtoko,
                                        'prdcd' => $temp['mstd_prdcd'], 'descprd' => $temp['mstd_desc'],
                                        'qty' => $temp['mstd_qty'], 'keterangan' => substr($keterangan,1,100)]);
                            }
                        }else{
                            $temp2 = DB::table('TBMASTER_LOKASI')
                                ->selectRaw('*')
                                ->where('LKS_PRDCD','=',$temp['mstd_prdcd'])
                                ->whereRaw("LKS_JENISRAK IN ('D', 'N')")
                                ->where('LKS_KODERAK',' NOT LIKE','D%')
                                ->count();
                            if($temp2 == 1){
                                DB::table('TBMASTER_LOKASI')
                                    ->where('LKS_PRDCD','=',$temp['mstd_prdcd'])
                                    ->whereRaw("LKS_JENISRAK IN ('D', 'N')")
                                    ->where('LKS_KODERAK',' NOT LIKE','D%')
                                    ->increment('LKS_QTY',$temp['mstd_qty']);
                            }elseif ($temp2 == 0){
                                $keterangan = 'Tidak Ada Di Rak Display';
                            }else{
                                $keterangan = 'Rak lebih dari 1, ';
                                $recs = DB::table('TBMASTER_LOKASI')
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
                                DB::table('TBHISTORY_RUBAHSTATUS_RAK')
                                    ->insert(['kodeigr' => $kodeigr, 'nodoc' => $noDoc,
                                        'nosortir' => $temp['mstd_nofaktur'].' - '.$gudangtoko,
                                        'prdcd' => $temp['mstd_prdcd'], 'descprd' => $temp['mstd_desc'],
                                        'qty' => $temp['mstd_qty'], 'keterangan' => substr($keterangan,1,100)]);
                            }
                        }
                    }
                }
                $temp2 = DB::table('TBMASTER_STOCK')
                    ->selectRaw('*')
                    ->where('ST_KODEIGR','=',$kodeigr)
                    ->where('ST_PRDCD','=',$temp['mstd_prdcd'])
                    ->where('ST_LOKASI','=',$LOC2)
                    ->count();
                if($temp2 == 0){
                    DB::table('TBMASTER_STOCK')
                        ->insert(['ST_KODEIGR' => $kodeigr, 'ST_LOKASI' => $LOC2, 'ST_PRDCD' => $temp['mstd_prdcd'],
                            'ST_SALDOAKHIR' => $temp['mstd_qty'], 'ST_TRFIN' => $temp['mstd_qty'], 'ST_CREATE_BY' => $userid,
                            'ST_CREATE_DT' => $today]);
                }else{
                    $qtyakhir = DB::table('TBMASTER_STOCK')
                        ->selectRaw('ST_SALDOAKHIR')
                        ->where('ST_KODEIGR','=',$kodeigr)
                        ->where('ST_PRDCD','=',$temp['mstd_prdcd'])
                        ->where('ST_LOKASI','=',$LOC2)
                        ->first();
                    $saldoAkhir = DB::table('TBMASTER_STOCK')
                        ->selectRaw('NVL (ST_SALDOAKHIR, 0)')
                        ->where('ST_KODEIGR','=',$kodeigr)
                        ->where('ST_PRDCD','=',$temp['mstd_prdcd'])
                        ->where('ST_LOKASI','=',$LOC2)
                        ->first();
                    $trfin = DB::table('TBMASTER_STOCK')
                        ->selectRaw('NVL (ST_TRFIN, 0)')
                        ->where('ST_KODEIGR','=',$kodeigr)
                        ->where('ST_PRDCD','=',$temp['mstd_prdcd'])
                        ->where('ST_LOKASI','=',$LOC2)
                        ->first();
                    DB::table('TBMASTER_STOCK')
                        ->where('ST_KODEIGR','=',$kodeigr)
                        ->where('ST_PRDCD','=',$temp['mstd_prdcd'])
                        ->where('ST_LOKASI','=',$LOC2)
                        ->update(['ST_SALDOAKHIR' => $saldoAkhir + $temp['mstd_qty'], 'ST_TRFIN' => $trfin + $temp['mstd_qty'], 'ST_MODIFY_BY' => $userid, 'ST_MODIFY_DT' => $today]);

                }
                DB::table('TBTR_SORTIR_BARANG')
                    ->where('SRT_KODEIGR','=',$kodeigr)
                    ->where('SRT_TYPE','=','S')
                    ->where('SRT_NOSORTIR','=',$temp['mstd_nofaktur'])
                    ->where('SRT_PRDCD','=',$temp['mstd_prdcd'])
                    ->update(['SRT_FLAGDISC3' => 'P']);

                $dokumen = $noDoc;
                if($flagdisc4 == 'A'){
                    if($noDoc == null){
                        if($flagretur == 'Y'){
                            $dokumen = $_SESSION['nomor_retur'];
                        }else{
                            $no_key = DB::table('tbmaster_nomordoc')
                                ->selectRaw('nomorawal')
                                ->where('kodedoc','=','BTN')
                                ->where('nomordoc','<=',99999)
                                ->orderBy('nomorawal')
                                ->first();

                            $connect = oci_connect('SIMSMG', 'SIMSMG', '192.168.237.193:1521/SIMSMG');

                            $query = oci_parse($connect, "BEGIN :ret := f_igr_get_nomor('$kodeigr','BTN',
                             'Nomor Barang Retur New',
                             TRIM ('$no_key'),
                             5,
                             TRUE);");
                            oci_bind_by_name($query, ':ret', $result, 32);

                            $dokumen = oci_execute($query);
                            $_SESSION['nomor_retur'] = $dokumen;
                            $_SESSION['flag_retur'] = 'Y';
                        }
                    }else{
                        $dokumen = $noDoc;
                        $_SESSION['nomor_retur'] = $dokumen;
                        $_SESSION['flag_retur'] = 'Y';
                    }
                }elseif ($flagdisc4 == 'B'){
                    if($noDoc == null){
                        if($_SESSION['flag_rusak'] == 'Y'){
                            $dokumen = $_SESSION['nomor_rusak'];
                        }else{
                            $no_key = DB::table('tbmaster_nomordoc')
                                ->selectRaw('nomorawal')
                                ->where('kodedoc','=','BRN')
                                ->where('nomordoc','<=',99999)
                                ->orderBy('nomorawal')
                                ->first();

                            $connect = oci_connect('SIMSMG', 'SIMSMG', '192.168.237.193:1521/SIMSMG');

                            $query = oci_parse($connect, "BEGIN :ret := f_igr_get_nomor('$kodeigr','BRN',
                             'Nomor Barang Rusak New',
                             TRIM ('$no_key'),
                             5,
                             TRUE);");
                            oci_bind_by_name($query, ':ret', $result, 32);

                            $dokumen = oci_execute($query);

                            $_SESSION['nomor_rusak'] = $dokumen;
                            $_SESSION['flag_rusak'] = 'Y';
                        }
                    }else{
                        $dokumen = $noDoc;
                        $_SESSION['nomor_rusak'] = $dokumen;
                        $_SESSION['flag_rusak'] = 'Y';
                    }
                }elseif ($flagdisc4 == 'C'){
                    if($noDoc == null){
                        if($_SESSION['flag_putus'] == 'Y'){
                            $dokumen = $_SESSION['nomor_putus'];
                        }else{
                            $no_key = DB::table('tbmaster_nomordoc')
                                ->selectRaw('nomorawal')
                                ->where('kodedoc','=','BPN')
                                ->where('nomordoc','<=',99999)
                                ->orderBy('nomorawal')
                                ->first();

                            $connect = oci_connect('SIMSMG', 'SIMSMG', '192.168.237.193:1521/SIMSMG');

                            $query = oci_parse($connect, "BEGIN :ret := f_igr_get_nomor('$kodeigr','BPN',
                             'Nomor Barang Putus New',
                             TRIM ('$no_key'),
                             5,
                             TRUE);");
                            oci_bind_by_name($query, ':ret', $result, 32);

                            $dokumen = oci_execute($query);

                            $_SESSION['nomor_putus'] = $dokumen;
                            $_SESSION['flag_putus'] = 'Y';
                        }
                    }else{
                        $dokumen = $noDoc;
                        $_SESSION['nomor_putus'] = $dokumen;
                        $_SESSION['flag_putus'] = 'Y';
                    }
                }
                //$noDoc = $dokumen;
                $flagdisc3 = 'P';

                $STOK_CUR = DB::table('TBMASTER_STOCK')
                    ->selectRaw('ST_SALDOAKHIR')
                    ->selectRaw('nvl(ST_AVGCOST, 0) ST_AVGCOST')
                    ->where('ST_KODEIGR','=',$kodeigr)
                    ->where('ST_PRDCD','=',$temp['mstd_prdcd'])
                    ->where('ST_LOKASI','=',$LOC2)
                    ->first();
                if(!$STOK_CUR){
                    $ocost = 0 * $FRACPRD;
                    $postqty = 0 - $temp['mstd_qty'];
                }else{
                    $ocost = $STOK_CUR->ST_AVGCOST * $FRACPRD;
                    $postqty = $STOK_CUR->ST_SALDOAKHIR - $temp['mstd_qty'];
                }
                $temp2 = DB::table('TBTR_MSTRAN_H')
                    ->selectRaw('*')
                    ->where('MSTH_KODEIGR','=',$kodeigr)
                    ->where('MSTH_NODOC','=',$dokumen)
                    ->where('MSTH_NOPO','=',$noDoc)
                    ->where('MSTH_NOFAKTUR','=',$noSort)
                    ->count();

                $sortData = DB::table('TBTR_SORTIR_BARANG')
                    ->selectRaw('SRT_KODESUPPLIER')
                    ->selectRaw('SRT_PKP')
                    ->where('SRT_KODEIGR','=',$kodeigr)
                    ->where('SRT_NOSORTIR','=',$dokumen)
                    ->first();

                if($temp2 == 0){
                    DB::table('TBTR_MSTRAN_H')
                        ->insert(['MSTH_KODEIGR' => $kodeigr, 'MSTH_TYPETRN' => 'Z', 'MSTH_NODOC' => $dokumen,
                            'MSTH_TGLDOC' => $today, 'MSTH_NOPO' => $noDoc, 'MSTH_TGLPO' => $today, 'MSTH_NOFAKTUR' => $noSort,
                            'MSTH_TGLFAKTUR' => $tglSort, 'MSTH_KODESUPPLIER' => $sortData->srt_kodesupplier, 'MSTH_PKP' => $sortData->srt_pkp,
                            'MSTH_KETERANGAN_HEADER' => $txtKeterangan, 'MSTH_FLAGDOC' => '1', 'MSTH_CREATE_BY' => $userid, 'MSTH_CREATE_DT', $today]);
                }
                if($LOC1 = '01'){
                    $oldAcostPrd = $ACOSTPRD/$FRACPRD;
                    $STOK_CUR = DB::table('TBMASTER_STOCK')
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
                        $stock = $STOK_CUR->ST_SALDOAKHIR;
                        $oldcost = $STOK_CUR->ST_AVGCOST;
                    }
                    $STOK_CUR = DB::table('TBMASTER_STOCK')
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
                        $stock = $STOK_CUR->ST_SALDOAKHIR;
                        $oldcostx = $STOK_CUR->ST_AVGCOST;
                    }
                    $qtystock = $stock - $temp['mstd_qty'];

                    $temp2 = DB::table('TBMASTER_PRODMAST')
                        ->selectRaw('*')
                        ->where('PRD_KODEIGR','=',$kodeigr)
                        ->where('PRD','=',$temp['mstd_prdcd'])
                        ->count();
                    if($temp2 != 0){
                        if($qtystock>0){
                            $newAcostx = ((($qtystock * $oldcostx) + ($temp['mstd_qty'] * $oldcost))+($qtystock + $temp['mstd_qty']));
                            $newAcost = ((($qtystock * $oldAcostPrd)+($temp['mstd_qty'] * $oldcost))+($qtystock + $temp['mstd_qty']));
                        }else{
                            $newAcostx = ($temp['mstd_qty'] * $oldcost) / $temp['mstd_qty'];
                            $newAcost = ($temp['mstd_qty'] * $oldcost) / $temp['mstd_qty'];
                        }
                    }
                }else{
                    $temp2 = DB::table('TBMASTER_PRODMAST')
                        ->selectRaw('*')
                        ->where('PRD_KODEIGR','=',$kodeigr)
                        ->where('PRD','=',$temp['mstd_prdcd'])
                        ->count();
                    if($temp2 != 0){
                        $oldAcostPrd = $ACOSTPRD / $FRACPRD;
                        $STOK_CUR = DB::table('TBMASTER_STOCK')
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
                            $stock = $STOK_CUR->ST_SALDOAKHIR;
                            $oldcost = $STOK_CUR->ST_AVGCOST;
                        }
                        $STOK_CUR = DB::table('TBMASTER_STOCK')
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
                            $stock = $STOK_CUR->ST_SALDOAKHIR;
                            $oldacostx = $STOK_CUR->ST_AVGCOST;
                        }
                        $qtystock = $stock - $temp['mstd_qty'];

                        if($qtystock > 0){
                            $newAcostx = (($qtystock * $oldacostx) + ($temp['mstd_qty'] * $oldcost)) / ($qtystock + $temp['mstd_qty']);
                            $newAcost = (($qtystock * $oldAcostPrd) + ($temp['mstd_qty'] * $oldcost)) / ($qtystock + $temp['mstd_qty']);
                        }else{
                            $newAcostx = ($temp['mstd_qty']*$oldcost)/$temp['mstd_qty'];
                            $newAcost = ($temp['mstd_qty']*$oldcost)/$temp['mstd_qty'];
                        }
                    }
                }
                $lCostStk = DB::table('TBMASTER_STOCK')
                    ->selectRaw('ST_LASTCOST')
                    ->where('ST_KODEIGR','=',$kodeigr)
                    ->where('ST_PRDCD','=',$temp['mstd_prdcd'])
                    ->where('ST_LOKASI','=','01')
                    ->first();
                $temp2 = DB::table('TBHISTORY_COST')
                    ->selectRaw('*')
                    ->where('HCS_KODEIGR','=',$kodeigr)
                    ->where('HCS_PRDCD','=',$temp['mstd_prdcd'])
                    ->where('HCS_TGLBPB','=',$today)
                    ->where('HCS_NODOCBPB','=',$dokumen)
                    ->first();
                if(!$temp2){
                    DB::table('TBHISTORY_COST')
                        ->insert(['HCS_KODEIGR' => $kodeigr,'HCS_TYPETRN' => 'Z','HCS_LOKASI' => $LOC2,
                            'HCS_PRDCD' => $temp['mstd_prdcd'], 'HCS_TGLBPB' => $today,'HCS_NODOCBPB' => $dokumen,
                            'HCS_AVGLAMA' => ($oldcostx * $FRACPRD),'HCS_AVGBARU' => ($newAcostx * $FRACPRD),
                            'HCS_LASTCOSTLAMA' => ($lCostStk * $FRACPRD), 'HCS_LASTCOSTBARU' => ($lCostStk * $FRACPRD),
                            'HCS_CREATE_BY' => $userid, 'HCS_CREATE_DT' => $today, 'HCS_QTYLAMA' => $qtyakhir,
                            'HCS_QTYBARU' => $temp['mstd_qty'], 'HCS_LASTQTY' => ($temp['mstd_qty'] = $qtyakhir)]);
                }
                if($LOC2 = '01'){
                    DB::table('TBMASTER_PRODMAST')
                        ->where('PRD_KODEIGR','=',$kodeigr)
                        ->whereRaw("SUBSTR (PRD_PRDCD, 1, 6) = SUBSTR ( ".$temp['mstd_prdcd'].", 1, 6)")
                        ->update(['PRD_AVGCOST' => ($newAcost * $FRACPRD)]);

                    DB::table('TBMASTER_STOCK')
                        ->where('ST_KODEIGR','=',$kodeigr)
                        ->where('ST_PRDCD','=',$temp['mstd_prdcd'])
                        ->where('ST_LOKASI','=',$LOC2)
                        ->update(['ST_AVGCOST' => $newAcostx, 'ST_LASTCOST' => $lCostStk]);

                    $mstd_avgcost = $newAcostx * $FRACPRD;

                    if($_SESSION['flagisi'] = 'Y'){
                        $no_key = DB::table('tbmaster_nomordoc')
                            ->selectRaw('nomorawal')
                            ->where('kodedoc','=','RSN')
                            ->where('nomordoc','<',10000)
                            ->orderBy('nomorawal')
                            ->first();
                        $connect = oci_connect('SIMSMG', 'SIMSMG', '192.168.237.193:1521/SIMSMG');

                        $query = oci_parse($connect, "BEGIN :ret := f_igr_get_nomor('$kodeigr','RSN',
                             'Nomor Rubah Status New',
                             TRIM ('$no_key'),
                             5,
                             TRUE);");
                        oci_bind_by_name($query, ':ret', $result, 32);

                        $dokumen = oci_execute($query);
                        $_SESSION['flagisi'] = 'N';
                    }
                }

                DB::table('TBTR_MSTRAN_D')
                    ->insert(['MSTD_KODEIGR' => $kodeigr, 'MSTD_RECORDID' => , 'MSTD_TYPETRN' => , 'MSTD_NODOC' => , 'MSTD_TGLDOC' => ,
                        'MSTD_DOCNO2' => , 'MSTD_DATE2' => , 'MSTD_NOPO' => , 'MSTD_TGLPO' => , 'MSTD_NOFAKTUR' => , 'MSTD_TGLFAKTUR' => ,
                        'MSTD_NOREF3' => , 'MSTD_TGLREF3' => , 'MSTD_ISTYPE' => , 'MSTD_INVO' => , 'MSTD_DATE3' => , 'MSTD_NOTT' => ,
                        'MSTD_TGLTT' => , 'MSTD_KODESUPLLIER' => , 'MSTD_PKP' => , 'MSTD_CTERM' => , 'MSTD_SEQNO' => , 'MSTD_PRDCD' => ,
                        'MSTD_KODEDIVISI' => , 'MSTD_KODEDEPARTEMENT' => ,]);
                // here probably better
            }
            // should be here
        }
    }
}
