<?php

namespace App\Http\Controllers\BACKOFFICE\TRANSAKSI\PENYESUAIAN;

use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;
use PDF;

class CetakPenyesuaianController extends Controller
{
    public function index(){
        return view('BACKOFFICE.TRANSAKSI.PENYESUAIAN.cetak');
    }

    public function getData(Request $request){
        $reprint = $request->reprint;
        $jenis = $request->jenis;
        $tgl1 = $request->tgl1;
        $tgl2 = $request->tgl2;

        if($jenis == 1){
            $data = DB::table('tbtr_backoffice')
                ->selectRaw('trbo_nodoc no, TRUNC(trbo_tgldoc) tgl')
                ->where('trbo_typetrn','=','X')
                ->whereRaw("NVL(trbo_recordid, '0') <> '1'")
                ->whereRaw("NVL(trbo_flagdoc, '0') = '".$reprint."'")
                ->whereRaw("trbo_tgldoc between TO_DATE('".$tgl1."','dd/mm/yyyy') and TO_DATE('".$tgl2."','dd/mm/yyyy')")
                ->orderBy('trbo_nodoc')
                ->distinct()
                ->get();
        }
        else{
            if($reprint == 0){
                $data = DB::table('tbtr_backoffice')
                    ->selectRaw('trbo_nodoc no, TRUNC(trbo_tgldoc) tgl')
                    ->where('trbo_typetrn','=','X')
                    ->whereRaw("NVL(trbo_flagdoc, ' ') <> '*'")
                    ->whereRaw("NVL(trbo_recordid, ' ') <> '1'")
                    ->whereRaw("trbo_tgldoc between TO_DATE('".$tgl1."','dd/mm/yyyy') and TO_DATE('".$tgl2."','dd/mm/yyyy')")
                    ->orderBy('trbo_nodoc')
                    ->distinct()
                    ->get();
            }
            else{
                $data = DB::table('tbtr_mstran_h')
                    ->selectRaw('msth_nodoc no, TRUNC(msth_tgldoc) tgl')
                    ->whereRaw("msth_tgldoc between TO_DATE('".$tgl1."','dd/mm/yyyy') and TO_DATE('".$tgl2."','dd/mm/yyyy')")
                    ->where('msth_typetrn','=','X')
                    ->whereRaw("NVL(msth_flagdoc, ' ') = '1'")
                    ->whereRaw("NVL(msth_recordid, '0') <> '1'")
                    ->orderBy('msth_nodoc')
                    ->distinct()
                    ->get();
            }
        }

        return $data;
    }

    public function storeData(Request $request){
        try{
            $_SESSION['pys_nodoc'] = $request->nodoc;
            $_SESSION['pys_reprint'] = $request->reprint;
            $_SESSION['pys_jenis'] = $request->jenis;
            $_SESSION['pys_ukuran'] = $request->ukuran;
        }
        catch(\Exception $e){
            return 'false';
        }
        return 'true';
    }

    public function laporan(){
        try{
            DB::beginTransaction();

            $ukuran = $_SESSION['pys_ukuran'];

            if($_SESSION['pys_jenis'] == '1'){
                if($_SESSION['pys_reprint'] == '0'){
                    DB::table('tbtr_backoffice')
                        ->whereIn('trbo_nodoc',$_SESSION['pys_nodoc'])
                        ->update([
                            'trbo_flagdoc' => '1'
                        ]);
                }
                DB::commit();

                $data = DB::table('tbtr_backoffice')
                    ->join('tbmaster_perusahaan','prs_kodeigr','=','trbo_kodeigr')
                    ->join('tbmaster_prodmast',function($join){
                        $join->on('prd_prdcd','=','trbo_prdcd');
                        $join->on('prd_kodeigr','=','trbo_kodeigr');
                    })
                    ->selectRaw("trbo_nodoc, trbo_tgldoc,trbo_noreff,trbo_tglreff, trbo_prdcd plu,
                            trbo_qty, trbo_hrgsatuan, trbo_gross, trbo_keterangan, trbo_flagdoc,prd_frac,
                            case when trbo_flagdisc1 = '1' then 'SELISIH STOCK OPNAME' else
                            case when trbo_flagdisc1 = '2' then 'TERTUKAR JENIS' else
                             'GANTI PLU' end end as keterangan_h,
                            prs_namaperusahaan, prs_namacabang,
                            prd_deskripsipanjang, prd_unit||'/'||prd_frac kemasan,
                            CASE WHEN 
                                nvl(trbo_recordid,0) <> '1' and nvl(trbo_flagdoc,0)='1' 
                            THEN 
                                'REPRINT' 
                            ELSE '' 
                            END AS REP")
                    ->where('trbo_kodeigr','=','22')
                    ->whereRaw("NVL(trbo_recordid,'0') <> '1'")
                    ->whereIn('trbo_nodoc',$_SESSION['pys_nodoc'])
                    ->orderBy('trbo_nodoc')
                    ->get();

                $dompdf = new PDF();

                $pdf = PDF::loadview('BACKOFFICE.TRANSAKSI.PENYESUAIAN.laporan-list',compact(['data','ukuran']));

                error_reporting(E_ALL ^ E_DEPRECATED);

                $pdf->output();
                $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);

                $canvas = $dompdf ->get_canvas();
                $canvas->page_text(507, 80.75, "{PAGE_NUM} dari {PAGE_COUNT}", null, 7, array(0, 0, 0));

                $dompdf = $pdf;

                return $dompdf->stream('Laporan Penyesuaian.pdf');
            }
            else{
                $lfirst = 1;
                $lcost = 0;
                $acost = 0;
                $step = 0;
                $v_plua1 = 0;
                $v_plub1 = 0;
                $flagdisc1 = 0;
                $oldlcost = 0;
                $oldacost = 0;
                $oldlcostx = 0;
                $v_plulama = null;
                $v_prd1st0 = 0;

                $flag = '1';
                $step114 = false;
                $step143 = false;

                $step = 0;

                foreach($_SESSION['pys_nodoc'] as $n){
                    if($flag == 1){
                        $step = 4;
                        $jum = DB::table('tbtr_backoffice')
                            ->select('trbo_nodoc')
                            ->where('trbo_nodoc',$n)
                            ->where('trbo_kodeigr',$_SESSION['kdigr'])
                            ->whereRaw("NVL(trbo_recordid, ' ') <> '1'")
                            ->get()->count();

                        if($jum == 2){
                            $fppmm = DB::table('tbtr_backoffice')
                                ->select('trbo_nodoc')
                                ->where('trbo_nodoc',$n)
                                ->where('trbo_kodeigr',$_SESSION['kdigr'])
                                ->whereRaw("NVL(trbo_recordid, ' ') <> '1'")
                                ->where('trbo_qty','<','0')
                                ->get()->count();

                            if($fppmm != 2){
                                $fppmm = DB::table('tbtr_backoffice')
                                    ->select('trbo_nodoc')
                                    ->where('trbo_nodoc',$n)
                                    ->where('trbo_kodeigr',$_SESSION['kdigr'])
                                    ->whereRaw("NVL(trbo_recordid, ' ') <> '1'")
                                    ->where('trbo_qty','>','0')
                                    ->get()->count();
                            }
                            if($fppmm == 2)
                                $ppmm = true;
                            else $ppmm = false;
                        }

                        if($_SESSION['pys_reprint'] == '0'){
                            if($jum == 1 || $jum > 2 || $ppmm){
                                $step = 5;
                                $flagdisc1 = DB::table('tbtr_backoffice')
                                    ->select('trbo_flagdisc1')
                                    ->where('trbo_nodoc',$n)
                                    ->where('trbo_kodeigr',$_SESSION['kdigr'])
                                    ->whereRaw("NVL(trbo_recordid, ' ') <> '1'")
                                    ->distinct()
                                    ->first()->trbo_flagdisc1;

                                if($flagdisc1 == '1'){
                                    $rec = DB::SELECT("SELECT   AA.*, ROWNUM NOURUT, PRD_UNIT, PRD_FRAC,
                                                  PRD_KODETAG, PRD_FLAGBKP1, PRD_FLAGBKP2, SUP_PKP,
                                                  SUP_TOP, PRD_LASTCOST, PRD_AVGCOST,
                                                  PRD_KODEDIVISI, PRD_KODEDEPARTEMENT,
                                                  PRD_KODEKATEGORIBARANG
                                             FROM TBTR_BACKOFFICE AA,
                                                  TBMASTER_PRODMAST BB,
                                                  TBMASTER_SUPPLIER
                                            WHERE TRBO_NODOC = '".$n."'
                                              AND PRD_PRDCD = TRBO_PRDCD
                                              AND PRD_KODEIGR = '".$_SESSION['kdigr']."'
                                              AND SUP_KODESUPPLIER(+) = TRBO_KODESUPPLIER
                                              AND SUP_KODEIGR(+) = '".$_SESSION['kdigr']."'
                                              AND NVL (TRBO_RECORDID, ' ') <> '1'
                                         ORDER BY CASE
                                                      WHEN NVL (TRBO_FLAGDISC1, '0') <> '1'
                                                          THEN TO_NUMBER
                                                                     (TO_CHAR (NVL (TRBO_MODIFY_DT,
                                                                                    TRBO_CREATE_DT
                                                                                   ),
                                                                               'RRRRMMDDHH24MISS'
                                                                              )
                                                                     )
                                                      ELSE TRBO_QTY
                                                  END");

                                    foreach($rec as $r){
                                        $step = 6;
                                        DB::table('tbtr_mstran_d')
                                            ->insert([
                                                'mstd_kodeigr' => $_SESSION['kdigr'],
                                                'mstd_typetrn' => $r->trbo_typetrn,
                                                'mstd_nodoc' => $r->trbo_nodoc,
                                                'mstd_tgldoc' => DB::RAW("TRUNC(SYSDATE)"),
                                                'mstd_kodesupplier' => $r->trbo_kodesupplier,
                                                'mstd_seqno' => $r->trbo_seqno,
                                                'mstd_prdcd' => $r->trbo_prdcd,
                                                'mstd_unit' => $r->prd_unit,
                                                'mstd_frac' => $r->prd_frac,
                                                'mstd_qty' => $r->trbo_qty,
                                                'mstd_flagdisc1' => $r->trbo_flagdisc1,
                                                'mstd_flagdisc2' => $r->trbo_flagdisc2,
                                                'mstd_gross' => $r->trbo_gross,
                                                'mstd_avgcost' => $r->trbo_averagecost,
                                                'mstd_ocost' => $r->trbo_oldcost,
                                                'mstd_pkp' => $r->sup_pkp,
                                                'mstd_bkp' => $r->prd_flagbkp1,
                                                'mstd_cterm' => $r->sup_top,
                                                'mstd_create_by' => $_SESSION['usid'],
                                                'mstd_create_dt' => DB::RAW("SYSDATE"),
                                                'mstd_hrgsatuan' => self::nvl($r->trbo_hrgsatuan,0),
                                                'mstd_qtybonus1' => self::nvl($r->trbo_qtybonus1,0),
                                                'mstd_qtybonus2' => self::nvl($r->trbo_qtybonus2,0),
                                                'mstd_persendisc1' => self::nvl($r->trbo_persendisc1,0),
                                                'mstd_rphdisc1' => self::nvl($r->trbo_rphdisc1,0),
                                                'mstd_persendisc2' => self::nvl($r->trbo_persendisc2,0),
                                                'mstd_rphdisc2' => self::nvl($r->trbo_rphdisc2, 0),
                                                'mstd_persendisc3' => self::nvl($r->trbo_persendisc3, 0),
                                                'mstd_rphdisc3' => self::nvl($r->trbo_rphdisc3, 0),
                                                'mstd_persendisc4' => self::nvl($r->trbo_persendisc4, 0),
                                                'mstd_rphdisc4' => self::nvl($r->trbo_rphdisc4,0),
                                                'mstd_keterangan' => $r->trbo_keterangan,
                                                'mstd_posqty' => self::nvl($r->trbo_posqty,0),
                                                'mstd_fobkp' => $r->prd_flagbkp2,
                                                'mstd_kodetag' => $r->prd_kodetag,
                                                'mstd_dis4cp' => 0,
                                                'mstd_dis4cr' => 0,
                                                'mstd_dis4rp' => 0,
                                                'mstd_dis4rr' => 0,
                                                'mstd_dis4jp' => 0,
                                                'mstd_dis4jr' => 0,
                                                'mstd_discrph' => 0,
                                                'mstd_ppnrph' => 0,
                                                'mstd_ppnbmrph' => 0,
                                                'mstd_ppnbtlrph' => 0,
                                                'mstd_kodedivisi' => $r->prd_kodedivisi,
                                                'mstd_kodedepartement' => $r->prd_kodedepartement,
                                                'mstd_kodekategoribrg' => $r->prd_kodekategoribarang
                                            ]);

                                        $step = 7;

                                        DB::table('tbmaster_stock')
                                            ->where('st_kodeigr',$_SESSION['kdigr'])
                                            ->where('st_prdcd',$r->trbo_prdcd)
                                            ->where('st_lokasi', substr('0'.$r->trbo_flagdisc2,-2))
                                            ->update([
                                                'st_adj' => DB::RAW("NVL(st_adj,0) + ".self::nvl($r->trbo_qty,0)),
                                                'st_saldoakhir' => DB::RAW("NVL(st_saldoakhir,0) + ".self::nvl($r->trbo_qty,0)),
                                                'st_modify_by' => $_SESSION['usid'],
                                                'st_modify_dt' => DB::RAW('SYSDATE')
                                            ]);

                                        $step = 8;

                                        $jum = DB::table('tbtr_mstran_h')
                                            ->select('msth_nodoc')
                                            ->where('msth_kodeigr',$_SESSION['kdigr'])
                                            ->where('msth_typetrn','=','X')
                                            ->where('msth_nodoc',$n)
                                            ->whereRaw("NVL(msth_recordid, ' ') <> '1'")
                                            ->get()->count();

                                        if($jum == 0){
                                            DB::table('tbtr_mstran_h')
                                                ->insert([
                                                    'msth_kodeigr' => $_SESSION['kdigr'],
                                                    'msth_typetrn' => 'X',
                                                    'msth_nodoc' => $n,
                                                    'msth_tgldoc' => DB::RAW("TRUNC(SYSDATE)"),
                                                    'msth_flagdoc' => '1',
                                                    'msth_kodesupplier' => $r->trbo_kodesupplier,
                                                    'msth_create_by' => $_SESSION['usid'],
                                                    'msth_create_dt' => DB::RAW('SYSDATE'),
                                                    'msth_pkp' => $r->sup_pkp,
                                                    'msth_cterm' => $r->sup_top,
                                                    'msth_keterangan_header' => $r->trbo_keterangan,
                                                    'msth_noref3' => $r->trbo_noreff,
                                                    'msth_tgref3' => $r->trbo_tglreff
                                                ]);
                                        }

                                        $step = 9;

                                        DB::table('tbtr_backoffice')
                                            ->where('trbo_nodoc',$n)
                                            ->whereRaw("NVL(trbo_recordid, ' ') <> '1'")
                                            ->update([
                                                'trbo_flagdoc' => '*',
                                                'trbo_recordid' => '2'
                                            ]);
                                    }
                                }
                            }
                            else {
                                $step = 10;
                                $updplu = false;

                                $data = DB::table('tbtr_backoffice')
                                    ->selectRaw("TRBO_PRDCD prdcdlama, LPAD (TRBO_FLAGDISC2, 2, '0') loklama")
                                    ->where('trbo_nodoc', $n)
                                    ->where('trbo_qty', '<', 0)
                                    ->whereRaw("NVL(trbo_recordid, ' ') <> '1'")
                                    ->first();

                                if ($data) {
                                    $prdcdlama = $data->prdcdlama;
                                    $loklama = $data->loklama;
                                } else {
                                    $prdcdlama = '';
                                    $loklama = '';
                                }

                                $step = 11;

                                $data = DB::table('tbtr_backoffice')
                                    ->selectRaw("TRBO_PRDCD prdcdbaru, LPAD (TRBO_FLAGDISC2, 2, '0') lokbaru")
                                    ->where('trbo_nodoc', $n)
                                    ->where('trbo_qty', '>', 0)
                                    ->whereRaw("NVL(trbo_recordid, ' ') <> '1'")
                                    ->first();

                                if ($data) {
                                    $prdcdbaru = $data->prdcdbaru;
                                    $lokbaru = $data->lokbaru;
                                } else {
                                    $prdcdbaru = '';
                                    $lokbaru = '';
                                }

                                $step = 12;

                                $v_plua1 = DB::table('tbmaster_stock')
                                    ->selectRaw('NVL(st_saldoakhir,0) v_plua1')
                                    ->where('st_kodeigr', $_SESSION['kdigr'])
                                    ->where('st_prdcd', $prdcdlama)
                                    ->where('st_lokasi', $loklama)
                                    ->first()->v_plua1;

                                $step = 13;

                                $jum = DB::table('tbmaster_stock')
                                    ->select('st_prdcd')
                                    ->where('st_kodeigr', $_SESSION['kdigr'])
                                    ->where('st_prdcd', $prdcdbaru)
                                    ->where('st_lokasi', $lokbaru)
                                    ->get()->count();

                                if ($jum > 0) {
                                    $step = 14;

                                    $v_plub1 = DB::table('tbmaster_stock')
                                        ->selectRaw('NVL(st_saldoakhir,0) v_plub1')
                                        ->where('st_kodeigr', $_SESSION['kdigr'])
                                        ->where('st_prdcd', $prdcdbaru)
                                        ->where('st_lokasi', $lokbaru)
                                        ->first()->v_plub1;
                                } else {
                                    $step = 15;
                                    $updplu = true;
                                    $v_plub1 = 0;
                                }

                                $data = DB::table('tbmaster_prodmast')
                                    ->select('prd_lastcost', 'prd_avgcost')
                                    ->where('prd_kodeigr', $_SESSION['kdigr'])
                                    ->where('prd_prdcd', $prdcdbaru)
                                    ->first();

                                if ($data) {
                                    $ceklcost = $data->prd_lastcost;
                                    $cekacost = $data->prd_avgcost;
                                } else {
                                    $ceklcost = '';
                                    $cekacost = '';
                                }

                                if (self::nvl($ceklcost, 0) == 0 && self::nvl($cekacost, 0) == 0) {
                                    $updplu = true;
                                }

                                if ($updplu) {
                                    $jum = DB::table('tbmaster_prodmast')
                                        ->select('prd_prdcd')
                                        ->where('prd_kodeigr', $_SESSION['kdigr'])
                                        ->where('prd_prdcd', substr($prdcdlama, 0, 6) . '1')
                                        ->get()->count();

                                    if ($jum > 0) {
                                        $data = DB::table('tbmaster_prodmast')
                                            ->select('prd_lastcost', 'prd_avgcost')
                                            ->where('prd_kodeigr', $_SESSION['kdigr'])
                                            ->where('prd_prdcd', substr($prdcdlama, 0, 6) . '1')
                                            ->first();

                                        if ($data) {
                                            $ceklcost = $data->prd_lastcost;
                                            $cekacost = $data->prd_avgcost;
                                        }
                                    } else {
                                        $jum = DB::table('tbmaster_prodmast')
                                            ->select('prd_prdcd')
                                            ->where('prd_kodeigr', $_SESSION['kdigr'])
                                            ->where('prd_prdcd', substr($prdcdlama, 0, 6) . '3')
                                            ->get()->count();

                                        if ($jum > 0) {
                                            $data = DB::table('tbmaster_prodmast')
                                                ->selectRaw("case when PRD_UNIT = 'KG' then prd_lastcost else (PRD_LASTCOST / PRD_FRAC) end PRD_LASTCOST, 
                                              case when PRD_UNIT = 'KG' then PRD_AVGCOST else (PRD_AVGCOST / PRD_FRAC) end PRD_AVGCOST")
                                                ->where('prd_kodeigr', $_SESSION['kdigr'])
                                                ->where('prd_prdcd', substr($prdcdlama, 0, 6) . '3')
                                                ->first();

                                            $ceklcost = $data->prd_lastcost;
                                            $cekacost = $data->prd_avgcost;
                                        } else {
                                            $data = DB::table('tbmaster_prodmast')
                                                ->selectRaw("case when PRD_UNIT = 'KG' then prd_lastcost else (PRD_LASTCOST / PRD_FRAC) end PRD_LASTCOST, 
                                              case when PRD_UNIT = 'KG' then PRD_AVGCOST else (PRD_AVGCOST / PRD_FRAC) end PRD_AVGCOST")
                                                ->where('prd_kodeigr', $_SESSION['kdigr'])
                                                ->where('prd_prdcd', substr($prdcdlama, 0, 6) . '2')
                                                ->first();

                                            $ceklcost = $data->prd_lastcost;
                                            $cekacost = $data->prd_avgcost;
                                        }
                                    }

                                    $rec2 = DB::table('tbmaster_prodmast')
                                        ->select('prd_prdcd', 'prd_unit', 'prd_frac')
                                        ->whereRaw("SUBSTR(prd_prdcd,1,6) = '" . substr($prdcdbaru, 0, 6) . "'")
                                        ->where('prd_kodeigr', $_SESSION['kdigr'])
                                        ->get();

                                    foreach ($rec2 as $r2) {
                                        if (substr($r2->prd_prdcd, -1) == '1' || $r2->prd_unit == 'KG') {
                                            DB::table('tbmaster_prodmast')
                                                ->where('prd_prdcd', $r2->prd_prdcd)
                                                ->where('prd_kodeigr', $_SESSION['kdigr'])
                                                ->update([
                                                    'prd_lastcost' => $ceklcost,
                                                    'prd_avgcost' => $cekacost
                                                ]);

                                            if ($updplu) {
                                                DB::table('tbtr_update_plu_md')
                                                    ->insert([
                                                        'upd_kodeigr' => $_SESSION['kdigr'],
                                                        'upd_prdcd' => $r2->prd_prdcd,
                                                        'upd_harga' => $ceklcost,
                                                        'upd_atribute1' => 'MPP1',
                                                        'upd_create_by' => $_SESSION['usid'],
                                                        'upd_create_dt' => DB::RAW("SYSDATE")
                                                    ]);
                                            }
                                        } else {
                                            DB::table('tbmaster_prodmast')
                                                ->where('prd_prdcd', $r2->prd_prdcd)
                                                ->where('prd_kodeigr', $_SESSION['kdigr'])
                                                ->update([
                                                    'prd_lastcost' => $ceklcost * $r2->prd_frac,
                                                    'prd_avgcost' => $cekacost * $r2->prd_frac
                                                ]);

                                            if ($updplu) {
                                                DB::table('tbtr_update_plu_md')
                                                    ->insert([
                                                        'upd_kodeigr' => $_SESSION['kdigr'],
                                                        'upd_prdcd' => $r2->prd_prdcd,
                                                        'upd_harga' => $ceklcost * $r2->prd_frac,
                                                        'upd_atribute1' => 'MPP1',
                                                        'upd_create_by' => $_SESSION['usid'],
                                                        'upd_create_dt' => DB::RAW("SYSDATE")
                                                    ]);
                                            }
                                        }
                                    }
                                } else {
                                    $jum = DB::table('tbmaster_prodmast')
                                        ->select('prd_prdcd')
                                        ->where('prd_kodeigr', $_SESSION['kdigr'])
                                        ->where('prd_prdcd', substr($prdcdlama, 0, 6) . '1')
                                        ->get()->count();

                                    if ($jum > 0) {
                                        $data = DB::table('tbmaster_prodmast')
                                            ->select('prd_lastcost', 'prd_avgcost')
                                            ->where('prd_kodeigr', $_SESSION['kdigr'])
                                            ->where('prd_prdcd', substr($prdcdlama, 0, 6) . '1')
                                            ->first();

                                        $ceklcost = $data->prd_lastcost;
                                        $cekacost = $data->prd_avgcost;
                                    } else {
                                        $jum = DB::table('tbmaster_prodmast')
                                            ->select('prd_prdcd')
                                            ->where('prd_kodeigr', $_SESSION['kdigr'])
                                            ->where('prd_prdcd', substr($prdcdlama, 0, 6) . '3')
                                            ->get()->count();

                                        if ($jum > 0) {
                                            $data = DB::table('tbmaster_prodmast')
                                                ->selectRaw("case when PRD_UNIT = 'KG' then prd_lastcost else (PRD_LASTCOST / PRD_FRAC) end PRD_LASTCOST, 
                                              case when PRD_UNIT = 'KG' then PRD_AVGCOST else (PRD_AVGCOST / PRD_FRAC) end PRD_AVGCOST")
                                                ->where('prd_kodeigr', $_SESSION['kdigr'])
                                                ->where('prd_prdcd', substr($prdcdlama, 0, 6) . '3')
                                                ->first();

                                            $ceklcost = $data->prd_lastcost;
                                            $cekacost = $data->prd_avgcost;
                                        } else {
                                            $data = DB::table('tbmaster_prodmast')
                                                ->selectRaw("case when PRD_UNIT = 'KG' then prd_lastcost else (PRD_LASTCOST / PRD_FRAC) end PRD_LASTCOST, 
                                              case when PRD_UNIT = 'KG' then PRD_AVGCOST else (PRD_AVGCOST / PRD_FRAC) end PRD_AVGCOST")
                                                ->where('prd_kodeigr', $_SESSION['kdigr'])
                                                ->where('prd_prdcd', substr($prdcdlama, 0, 6) . '2')
                                                ->first();

                                            $ceklcost = $data->prd_lastcost;
                                            $cekacost = $data->prd_avgcost;
                                        }
                                    }

                                    $rec2 = DB::table('tbmaster_prodmast')
                                        ->select('prd_prdcd', 'prd_unit', 'prd_frac')
                                        ->whereRaw("SUBSTR(prd_prdcd,1,6) = '" . substr($prdcdbaru, 0, 6) . "'")
                                        ->where('prd_kodeigr', $_SESSION['kdigr'])
                                        ->get();

                                    foreach ($rec2 as $r2) {
                                        if (substr($r2->prd_prdcd, -1) == '1' || $r2->prd_unit == 'KG') {
                                            DB::table('tbmaster_prodmast')
                                                ->where('prd_prdcd', $r2->prd_prdcd)
                                                ->where('prd_kodeigr', $_SESSION['kdigr'])
                                                ->update([
                                                    'prd_avgcost' => $cekacost
                                                ]);
                                        } else {
                                            DB::table('tbmaster_prodmast')
                                                ->where('prd_prdcd', $r2->prd_prdcd)
                                                ->where('prd_kodeigr', $_SESSION['kdigr'])
                                                ->update([
                                                    'prd_avgcost' => $cekacost * $r2->prd_frac
                                                ]);
                                        }
                                    }
                                }

                                $rec = DB::Select("SELECT   AA.*, ROWNUM NOURUT, PRD_UNIT, PRD_FRAC, PRD_KODETAG,
                                              PRD_FLAGBKP1, PRD_FLAGBKP2, SUP_PKP, SUP_TOP,
                                              PRD_LASTCOST, PRD_AVGCOST, PRD_KODEDIVISI,
                                              PRD_KODEDEPARTEMENT, PRD_KODEKATEGORIBARANG
                                         FROM TBTR_BACKOFFICE AA,
                                              TBMASTER_PRODMAST BB,
                                              TBMASTER_SUPPLIER
                                        WHERE TRBO_NODOC = '" . $n . "'
                                          AND PRD_PRDCD = TRBO_PRDCD
                                          AND PRD_KODEIGR = '" . $_SESSION['kdigr'] . "'
                                          AND SUP_KODESUPPLIER(+) = TRBO_KODESUPPLIER
                                          AND SUP_KODEIGR(+) = '" . $_SESSION['kdigr'] . "'
                                          AND NVL (TRBO_RECORDID, ' ') <> '1'
                                     ORDER BY CASE
                                                  WHEN NVL (TRBO_FLAGDISC1, '0') <> '1'
                                                      THEN TO_NUMBER (TO_CHAR (NVL (TRBO_MODIFY_DT,
                                                                                    TRBO_CREATE_DT
                                                                                   ),
                                                                               'RRRRMMDDHH24MISS'
                                                                              )
                                                                     )
                                                  ELSE TRBO_QTY
                                              END");

                                foreach ($rec as $r) {
                                    $step = 16;
                                    $v_noreff = $r->trbo_noreff;
                                    $v_tglreff = $r->trbo_tglreff;
                                    $step = 17;

                                    if ($r->trbo_flagdisc1 != '3') {
                                        $jum = DB::table('tbmaster_stock')
                                            ->select('st_prdcd')
                                            ->where('st_kodeigr', $_SESSION['kdigr'])
                                            ->where('st_prdcd', $r->trbo_prdcd)
                                            ->where('st_lokasi', substr('00' . $r->trbo_flagdisc2, -2))
                                            ->get()->count();

                                        if ($jum == 0) {
                                            $trec = DB::table('tbmaster_stock')
                                                ->select('st_lastcost')
                                                ->where('st_kodeigr', $_SESSION['kdigr'])
                                                ->where('st_prdcd', $prdcdlama)
                                                ->where('st_lokasi', substr('00' . $r->trbo_flagdisc2, -2))
                                                ->get();

                                            $oldstacost = 0;
                                            foreach ($trec as $tr) {
                                                $oldstacost += $tr->st_lastcost;
                                            }

                                            DB::table('tbmaster_stock')
                                                ->insert([
                                                    'st_kodeigr' => $_SESSION['kdigr'],
                                                    'st_recordid' => null,
                                                    'st_lokasi' => substr('00' . $r->trbo_flagdisc2, -2),
                                                    'st_prdcd' => $r->trbo_prdcd,
                                                    'st_saldoawal' => 0,
                                                    'st_trfin' => 0,
                                                    'st_trfout' => 0,
                                                    'st_sales' => 0,
                                                    'st_retur' => 0,
                                                    'st_adj' => 0,
                                                    'st_intransit' => 0,
                                                    'st_saldoakhir' => 0,
                                                    'st_min' => 0,
                                                    'st_max' => 0,
                                                    'st_lastcost' => $oldstacost,
                                                    'st_avgcost' => ($r->trbo_averagecost / $r->prd_frac),
                                                    'st_avgcostmonthend' => 0,
                                                    'st_rpsaldoawal' => 0,
                                                    'st_rpsaldoawal2' => 0,
                                                    'st_tglavgcost' => DB::RAW("TRUNC(SYSDATE)"),
                                                    'st_create_by' => $_SESSION['usid'],
                                                    'st_create_dt' => DB::RAW("SYSDATE")
                                                ]);
                                        }
                                    }

                                    $v_gantiplu = DB::table('tbmaster_stock')
                                        ->select('st_prdcd')
                                        ->where('st_kodeigr', $_SESSION['kdigr'])
                                        ->where('st_prdcd', $r->trbo_prdcd)
                                        ->where('st_lokasi', substr('00' . $r->trbo_flagdisc2, -2))
                                        ->get()->count();

                                    if ($v_gantiplu > 0) {
                                        $step = 18;

                                        $data = DB::table('tbmaster_stock')
                                            ->select('st_saldoawal', 'st_lastcost', 'st_saldoakhir')
                                            ->where('st_kodeigr', $_SESSION['kdigr'])
                                            ->where('st_prdcd', $r->trbo_prdcd)
                                            ->where('st_lokasi', substr('00' . $r->trbo_flagdisc2, -2))
                                            ->first();

                                        $oldqty = $data->st_saldoawal;
                                        $oldlcost = $data->st_lastcost;
                                        $sldawal = $data->st_saldoakhir;
                                    } else {
                                        $step = 19;

                                        $oldqty = 0;
                                        $oldlcost = 0;
                                        $sldawal = 0;
                                    }

                                    $step = 20;

                                    if ((self::nvl($r->trbo_qty, 0) < 0)) {
                                        $data = DB::table('tbmaster_stock')
                                            ->select('st_lastcost', 'st_avgcost')
                                            ->where('st_kodeigr', $_SESSION['kdigr'])
                                            ->where('st_prdcd', $r->trbo_prdcd)
                                            ->where('st_lokasi', substr('00' . $r->trbo_flagdisc2, -2))
                                            ->first();

                                        if ($data) {
                                            $oldlcostx = $data->st_lastcost;
                                            $oldacost = $data->st_avgcost;
                                        }
                                    }

                                    $step = 21;

                                    DB::table('tbtr_mstran_d')
                                        ->insert([
                                            'mstd_kodeigr' => $_SESSION['kdigr'],
                                            'mstd_typetrn' => $r->trbo_typetrn,
                                            'mstd_nodoc' => $r->trbo_nodoc,
                                            'mstd_tgldoc' => DB::RAW("TRUNC(SYSDATE)"),
                                            'mstd_kodesupplier' => $r->trbo_kodesupplier,
                                            'mstd_seqno' => $r->trbo_seqno,
                                            'mstd_prdcd' => $r->trbo_prdcd,
                                            'mstd_unit' => $r->prd_unit,
                                            'mstd_frac' => $r->prd_frac,
                                            'mstd_qty' => $r->trbo_qty,
                                            'mstd_flagdisc1' => $r->trbo_flagdisc1,
                                            'mstd_flagdisc2' => $r->trbo_flagdisc2,
                                            'mstd_gross' => $r->trbo_gross,
                                            'mstd_avgcost' => $r->trbo_averagecost,
                                            'mstd_ocost' => $r->trbo_oldcost,
                                            'mstd_pkp' => $r->sup_pkp,
                                            'mstd_bkp' => $r->prd_flagbkp1,
                                            'mstd_cterm' => $r->sup_top,
                                            'mstd_create_by' => $_SESSION['usid'],
                                            'mstd_create_dt' => DB::RAW("SYSDATE"),
                                            'mstd_hrgsatuan' => self::nvl($r->trbo_hrgsatuan, 0),
                                            'mstd_qtybonus1' => self::nvl($r->trbo_qtybonus1, 0),
                                            'mstd_qtybonus2' => self::nvl($r->trbo_qtybonus2, 0),
                                            'mstd_persendisc1' => self::nvl($r->trbo_persendisc1, 0),
                                            'mstd_rphdisc1' => self::nvl($r->trbo_rphdisc1, 0),
                                            'mstd_persendisc2' => self::nvl($r->trbo_persendisc2, 0),
                                            'mstd_rphdisc2' => self::nvl($r->trbo_rphdisc2, 0),
                                            'mstd_persendisc3' => self::nvl($r->trbo_persendisc3, 0),
                                            'mstd_rphdisc3' => self::nvl($r->trbo_rphdisc3, 0),
                                            'mstd_persendisc4' => self::nvl($r->trbo_persendisc4, 0),
                                            'mstd_rphdisc4' => self::nvl($r->trbo_rphdisc4, 0),
                                            'mstd_keterangan' => $r->trbo_keterangan,
                                            'mstd_posqty' => self::nvl($r->trbo_posqty, 0),
                                            'mstd_fobkp' => $r->prd_flagbkp2,
                                            'mstd_kodetag' => $r->prd_kodetag,
                                            'mstd_dis4cp' => 0,
                                            'mstd_dis4cr' => 0,
                                            'mstd_dis4rp' => 0,
                                            'mstd_dis4rr' => 0,
                                            'mstd_dis4jp' => 0,
                                            'mstd_dis4jr' => 0,
                                            'mstd_discrph' => 0,
                                            'mstd_ppnrph' => 0,
                                            'mstd_ppnbmrph' => 0,
                                            'mstd_ppnbtlrph' => 0,
                                            'mstd_kodedivisi' => $r->prd_kodedivisi,
                                            'mstd_kodedepartement' => $r->prd_kodedepartement,
                                            'mstd_kodekategoribrg' => $r->prd_kodekategoribarang
                                        ]);

                                    if ($r->trbo_flagdisc1 == '3' && $r->trbo_flagdisc2 == '1') {
                                        $stanak = DB::table('tbmaster_stock_cab_anak')
                                            ->where('sta_prdcd', $r->trbo_prdcd)
                                            ->where('sta_lokasi', '01')
                                            ->get()->count();

                                        if (self::nvl($stanak, 0) == 0) {
                                            DB::table('tbmaster_stock_cab_anak')
                                                ->insert([
                                                    'sta_kodeigr' => $_SESSION['kdigr'],
                                                    'sta_lokasi' => '01',
                                                    'sta_prdcd' => $r->trbo_prdcd,
                                                    'sta_saldoawal' => 0,
                                                    'sta_trfin' => 0,
                                                    'sta_trfout' => 0,
                                                    'sta_sales' => 0,
                                                    'sta_retur' => 0,
                                                    'sta_adj' => 0,
                                                    'sta_intransit' => 0,
                                                    'sta_saldoakhir' => 0,
                                                    'sta_create_by' => $_SESSION['usid'],
                                                    'sta_create_dt' => DB::RAW("sysdate")
                                                ]);
                                        }

                                        $cek = DB::table('tbmaster_stock_cab_anak')
                                            ->select('sta_prdcd')
                                            ->where('sta_prdcd', $r->trbo_prdcd)
                                            ->where('sta_lokasi', '01')
                                            ->get()->count();

                                        if (self::nvl($cek, 0) == 0) {
                                            $qtycmo = 0;
                                        } else {
                                            $qtycmo = DB::table('tbmaster_stock_cab_anak')
                                                ->selectRaw("NVL(sta_saldoakhir,0) sta_saldoakhir")
                                                ->where('sta_prdcd', $r->trbo_prdcd)
                                                ->where('sta_lokasi', '01')
                                                ->first()->sta_saldoakhir;
                                        }

                                        $qtyst = $qtycmo;

                                        if ($r->trbo_qty < 0)
                                            $qtyadj = $qtycmo * -1;
                                        else $qtyadj = -1;

                                        DB::table('tbtr_adj_cmo')
                                            ->insert([
                                                'acm_kodeigr' => $_SESSION['kdigr'],
                                                'acm_typetrn' => 'X',
                                                'acm_nodokumen' => $r->trbo_nodoc,
                                                'acm_tgldokumen' => DB::RAW('SYSDATE'),
                                                'acm_prdcd' => $r->trbo_prdcd,
                                                'acm_qtystock' => $qtyst,
                                                'acm_qtycmo' => $qtycmo,
                                                'acm_qty' => $qtyadj,
                                                'acm_create_by' => $_SESSION['usid'],
                                                'acm_create_dt' => DB::RAW('SYSDATE')
                                            ]);

                                        DB::table('tbmaster_stock_cab_anak')
                                            ->where('sta_prdcd', $r->trbo_prdcd)
                                            ->where('sta_lokasi', '01')
                                            ->update([
                                                'sta_adj' => DB::RAW('NVL(sta_adj,0) + ' . $qtyadj)
                                            ]);
                                    }

                                    if ($r->trbo_flagdisc1 == '3' && $r->trbo_flagdisc2 == '1') {
                                        if ($r->trbo_qty > 0) {
                                            $step = 22;

                                            $v_plubaru = DB::table('tbtr_backoffice')
                                                ->select('trbo_prdcd')
                                                ->where('trbo_nodoc', $r->trbo_nodoc)
                                                ->where('trbo_qty', '>', 0)
                                                ->where('trbo_typetrn', 'X')
                                                ->where('trbo_kodeigr', $_SESSION['kdigr'])
                                                ->whereRaw("NVL(trbo_recordid,' ') <> '1'")
                                                ->first()->trbo_prdcd;

                                            $step = 23;

                                            DB::table('tbmaster_prodmast')
                                                ->where('prd_kodeigr', $_SESSION['kdigr'])
                                                ->where('prd_prdcd', $v_plubaru)
                                                ->update([
                                                    'prd_lastcost' => DB::RAW("CASE
                                                       WHEN NVL (PRD_LASTCOST, 0) = 0
                                                           THEN " . $r->prd_lastcost . "
                                                       ELSE PRD_LASTCOST
                                                   END")
                                                ]);

                                            $step = 24;

                                            $jum = DB::table('tbmaster_prodmast')
                                                ->select('prd_prdcd')
                                                ->where('prd_prdcd', substr($r->trbo_prdcd, 0, 6) . '1')
                                                ->where('prd_kodeigr', $_SESSION['kdigr'])
                                                ->get()->count();

                                            if ($jum > 0) {
                                                $v_lcplulama1 = DB::table('tbmaster_prodmast')
                                                    ->select('prd_lastcost')
                                                    ->where('prdcd', substr($r->trbo_prdcd, 0, 6) . '1')
                                                    ->where('prd_kodeigr', $_SESSION['kdigr'])
                                                    ->first()->prd_lastcost;
                                            } else $v_lcplulama1 = 0;

                                            $step = 25; //step 25 26 27

                                            DB::table('tbmaster_prodmast')
                                                ->where('prd_kodeigr', $_SESSION['kdigr'])
                                                ->whereIn('prd_prdcd', [
                                                    substr($v_plubaru, 0, 6) . '1',
                                                    substr($v_plubaru, 0, 6) . '2',
                                                    substr($v_plubaru, 0, 6) . '3',
                                                ])
                                                ->update([
                                                    'prd_lastcost' => DB::RAW("CASE
                                                       WHEN NVL (PRD_LASTCOST, 0) = 0
                                                           THEN " . $v_lcplulama1 . "
                                                       ELSE PRD_LASTCOST
                                                   END")
                                                ]);

                                            $step = 28;

                                            $data = DB::table('tbtr_backoffice')
                                                ->select('trbo_prdcd')
                                                ->where('trbo_nodoc', $r->trbo_nodoc)
                                                ->where('trbo_kodeigr', $r->trbo_kodeigr)
                                                ->where('trbo_flagdisc2', $r->trbo_flagdisc2)
                                                ->where('trbo_qty', '<', 0)
                                                ->whereRaw("NVL(trbo_recordid,' ') <> '1'")
                                                ->first();

                                            if ($data)
                                                $prdcdlama = $data->trbo_prdcd;

                                            $step = 29;

                                            $data = DB::table('tbmaster_prodmast')
                                                ->select('prd_lastcost')
                                                ->where('prd_kodeigr', $_SESSION['kdigr'])
                                                ->where('prd_prdcd', $prdcdlama)
                                                ->first();

                                            if ($data)
                                                $v_lcplulama1 = $data->prd_lastcost;

                                            $step = 30;

                                            DB::table('tbmaster_prodmast')
                                                ->where('prd_kodeigr', $_SESSION['kdigr'])
                                                ->where('prd_prdcd', $r->trbo_prdcd)
                                                ->update([
                                                    'prd_lastcost' => DB::RAW("CASE
                                                       WHEN NVL (PRD_LASTCOST, 0) = 0
                                                           THEN " . $v_lcplulama1 . "
                                                       ELSE PRD_LASTCOST
                                                   END")
                                                ]);

                                            $step = 31;

                                            $jum = DB::table('tbmaster_prodmast')
                                                ->select('prd_lastcost')
                                                ->where('prd_prdcd', substr($prdcdlama, 0, 6) . '1')
                                                ->where('prd_kodeigr', $_SESSION['kdigr'])
                                                ->first();


                                            if ($jum) {
                                                $step = 32;
                                                $v_lcplulama1 = $jum->prd_lastcost;
                                            } else {
                                                $step = 33;
                                                $v_lcplulama1 = 0;
                                            }

                                            $step = 34;

                                            $v_oldprdacost1 = $v_lcplulama1;
                                            $step = 35;

                                            DB::table('tbmaster_prodmast')
                                                ->where('prd_prdcd', substr($r->trbo_prdcd, 0, 6) . '1')
                                                ->where('prd_kodeigr', $_SESSION['kdigr'])
                                                ->update([
                                                    'prd_lastcost' => DB::RAW("CASE
                                                       WHEN NVL (PRD_LASTCOST, 0) = 0
                                                           THEN " . $v_lcplulama1 . "
                                                       ELSE PRD_LASTCOST
                                                   END")
                                                ]);

                                            $step = 36;

                                            $jum = DB::table('tbmaster_prodmast')
                                                ->selectRaw("NVL(prd_lastcost, 0) lcplulama")
                                                ->where('prd_prdcd', substr($prdcdlama, 0, 6) . '2')
                                                ->where('prd_kodeigr', $_SESSION['kdigr'])
                                                ->first();

                                            if ($jum) {
                                                $step = 37;

                                                $v_lcplulama1 = $jum->lcplulama;

                                                $step = 38;

                                                DB::table('tbmaster_prodmast')
                                                    ->where('prd_prdcd', substr($prdcdlama, 0, 6) . '2')
                                                    ->where('prd_kodeigr', $_SESSION['kdigr'])
                                                    ->update([
                                                        'prd_lastcost' => DB::RAW("CASE
                                                       WHEN NVL (PRD_LASTCOST, 0) = 0
                                                           THEN " . $v_lcplulama1 . "
                                                       ELSE PRD_LASTCOST
                                                   END")
                                                    ]);
                                            } else {
                                                $step = 39;

                                                DB::table('tbmaster_prodmast')
                                                    ->where('prd_prdcd', substr($prdcdlama, 0, 6) . '2')
                                                    ->where('prd_kodeigr', $_SESSION['kdigr'])
                                                    ->update([
                                                        'prd_lastcost' => DB::RAW("CASE
                                                       WHEN NVL (PRD_LASTCOST, 0) = 0
                                                           THEN " . $v_oldprdacost1 . " * PRD_FRAC
                                                       ELSE PRD_LASTCOST
                                                   END")
                                                    ]);
                                            }

                                            $step = 40;

                                            $jum = DB::table('tbmaster_prodmast')
                                                ->selectRaw("NVL(prd_lastcost,0) prd_lastcost")
                                                ->where('prd_prdcd', substr($prdcdlama, 0, 6) . '3')
                                                ->where('prd_kodeigr', $_SESSION['kdigr'])
                                                ->first();

                                            if ($jum) {
                                                $step = 41;

                                                $v_lcplulama1 = $jum->prd_lastcost;

                                                $step = 42;

                                                DB::table('tbmaster_prodmast')
                                                    ->where('prd_prdcd', substr($prdcdlama, 0, 6) . '3')
                                                    ->where('prd_kodeigr', $_SESSION['kdigr'])
                                                    ->update([
                                                        'prd_lastcost' => DB::RAW("CASE
                                                           WHEN NVL (PRD_LASTCOST, 0) = 0
                                                               THEN " . $v_lcplulama1 . "
                                                           ELSE PRD_LASTCOST
                                                       END")
                                                    ]);
                                            } else {
                                                $step = 43;

                                                DB::table('tbmaster_prodmast')
                                                    ->where('prd_prdcd', substr($prdcdlama, 0, 6) . '3')
                                                    ->where('prd_kodeigr', $_SESSION['kdigr'])
                                                    ->update([
                                                        'prd_lastcost' => DB::RAW("CASE
                                                           WHEN NVL (PRD_LASTCOST, 0) = 0
                                                               THEN " . $v_oldprdacost1 . " * PRD_FRAC
                                                           ELSE PRD_LASTCOST
                                                       END")
                                                    ]);
                                            }
                                        }
                                    }

                                    if ($r->trbo_flagdisc1 != '1') {
                                        if ($r->trbo_qty > 0) {
                                            $step = 44;

                                            $jum = DB::table('tbmaster_stock')
                                                ->select('st_lastcost')
                                                ->where('st_kodeigr', $_SESSION['kdigr'])
                                                ->where('st_prdcd', substr($r->trbo_prdcd, 0, 6) . '0')
                                                ->where('st_lokasi', substr('00' . $r->trbo_flagdisc2, -2))
                                                ->first();

                                            if ($jum) {
                                                $step = 45;
                                                $lcost = $jum->st_lastcost;
                                            } else {
                                                $step = 46;
                                                $lcost = DB::table('tbmaster_prodmast')
                                                    ->select('prd_lastcost')
                                                    ->where('prd_kodeigr', $_SESSION['kdigr'])
                                                    ->where('prd_prdcd', substr($r->trbo_prdcd, 0, 6) . '0')
                                                    ->first()->prd_lastcost;
                                            }

                                            $step = 47;

                                            if ($r->trbo_flagdisc1 == '3') {
                                                $step = 48;
                                                DB::table('tbmaster_stock')
                                                    ->where('st_kodeigr', $_SESSION['kdigr'])
                                                    ->where('st_lokasi', substr('00' . $r->trbo_flagdisc2, -2))
                                                    ->where('st_prdcd', substr($r->trbo_prdcd, 0, 6) . '0')
                                                    ->update([
                                                        'st_adj' => DB::RAW("NVL(st_adj,0) + " . $r->trbo_qty),
                                                        'st_saldoakhir' => DB::RAW("NVL(st_saldoakhir,0) + " . $r->trbo_qty),
                                                        'st_avgcost' => DB::RAW("CASE
                                                           WHEN NVL (ST_AVGCOST, 0) = 0
                                                               THEN " . $oldacost . "
                                                       ELSE ST_AVGCOST
                                                       END"),
                                                        'st_lastcost' => DB::RAW("CASE
                                                           WHEN NVL (ST_LASTCOST, 0) = 0
                                                               THEN " . $oldlcostx . "
                                                           ELSE ST_LASTCOST
                                                       END"),
                                                        'st_modify_by' => $_SESSION['usid'],
                                                        'st_modify_dt' => DB::RRAW("SYSDATE")
                                                    ]);

                                                $step = 49;

                                                $jum = DB::table('tbmaster_stock')
                                                    ->where('st_kodeigr', $_SESSION['kdigr'])
                                                    ->where('st_lokasi', substr('00' . $r->trbo_flagdisc2, -2))
                                                    ->where('st_prdcd', $r->trbo_prdcd)
                                                    ->get()->count();

                                                if ($jum == 0) {
                                                    $step = 50;

                                                    if (substr($r->trbo_prdcd, -1) == '0') {
                                                        DB::table('tbmaster_stock')
                                                            ->insert([
                                                                'st_kodeigr' => $_SESSION['kdigr'],
                                                                'st_recordid' => null,
                                                                'st_lokasi' => substr('00' . $r->trbo_flagdisc2, -2),
                                                                'st_prdcd' => $r->trbo_prdcd,
                                                                'st_adj' => $r->trbo_qty,
                                                                'st_saldoakhir' => $r->trbo_qty,
                                                                'st_lastcost' => $oldlcostx,
                                                                'st_avgcost' => $oldacost,
                                                                'st_create_by' => $_SESSION['usid'],
                                                                'st_create_dt' => DB::RAW("SYSDATE")
                                                            ]);
                                                    }
                                                } else {
                                                    $step = 51;

                                                }

                                            } else {
                                                $step = 55;

                                                $jum = DB::table('tbmaster_stock')
                                                    ->where('st_kodeigr', $_SESSION['kdigr'])
                                                    ->where('st_lokasi', substr('00' . $r->trbo_flagdisc2, -2))
                                                    ->where('st_prdcd', $r->trbo_prdcd)
                                                    ->get()->count();

                                                $step = 56;

                                                DB::table('tbmaster_stock')
                                                    ->where('st_kodeigr', $_SESSION['kdigr'])
                                                    ->where('st_prdcd', $r->trbo_prdcd)
                                                    ->where('st_lokasi', substr('00' . $r->trbo_flagdisc2, -2))
                                                    ->update([
                                                        'st_adj' => DB::RAW("NVL(ST_ADJ,0) + " . $r->trbo_qty),
                                                        'st_saldoakhir' => DB::RAW("NVL(ST_SALDOAKHIR,0) + " . $r->trbo_qty),
                                                        'st_modify_by' => $_SESSION['usid'],
                                                        'st_modify_dt' => DB::RAW("SYSDATE")
                                                    ]);

                                                $v_prd1st0 = 0;

                                                if ($jum == 0) {
                                                    $v_prd1st0 = 1;
                                                    $step = 57;

                                                    $prdcdlama = DB::table('tbtr_backoffice')
                                                        ->select('trbo_prdcd')
                                                        ->where('trbo_kodeigr', $_SESSION['kdigr'])
                                                        ->where('trbo_nodoc', $r->trbo_nodoc)
                                                        ->where('trbo_typetrn', 'X')
                                                        ->where('trbo_qty', '<', 0)
                                                        ->whereRaw("NVL(TRBO_RECORDID, ' ') <> '1'")
                                                        ->first();

                                                    $step = 58;

                                                    if ($prdcdlama) {
                                                        $v_lcplulama1 = DB::table('tbmaster_stock')
                                                            ->select('st_avgcost')
                                                            ->where('st_kodeigr', $_SESSION['kdigr'])
                                                            ->where('st_prdcd', $prdcdlama)
                                                            ->where('st_lokasi', '01')
                                                            ->first()->st_avgcost;
                                                    }
                                                }
                                            }
                                        } else {
                                            $step = 59;

                                            DB::table('tbmaster_stock')
                                                ->where('st_kodeigr', $_SESSION['kdigr'])
                                                ->where('st_lokasi', substr('00' . $r->trbo_flagdisc2, -2))
                                                ->where('st_prdcd', substr($r->trbo_prdcd, 0, 6) . '0')
                                                ->update([
                                                    'st_adj' => DB::RAW("NVL(st_adj,0) + " . self::nvl($r->trbo_qty,0)),
                                                    'st_saldoakhir' => DB::RAW("NVL(st_saldoakhir,0) + " . self::nvl($r->trbo_qty,0))
                                                ]);
                                        }
                                    } else {
                                        $step = 60;

                                        DB::table('tbmaster_stock')
                                            ->where('st_kodeigr', $_SESSION['kdigr'])
                                            ->where('st_lokasi', substr('00' . $r->trbo_flagdisc2, -2))
                                            ->where('st_prdcd', substr($r->trbo_prdcd, 0, 6) . '0')
                                            ->update([
                                                'st_adj' => DB::RAW("NVL(st_adj,0) + " . $r->trbo_qty),
                                                'st_saldoakhir' => DB::RAW("NVL(st_saldoakhir,0) + " . $r->trbo_qty)
                                            ]);
                                    }

                                    if (($lfirst == 1 && $r->trbo_qty < 0) || ($lfirst == 0 && $r->trbo_qty > 0)) {
                                        $step = 61;

                                        $data = DB::table('tbmaster_stock')
                                            ->selectRaw("NVL(ST_SALDOAKHIR, 0) newqty, NVL(ST_LASTCOST, 0) newlcost")
                                            ->where('st_kodeigr', $_SESSION['kdigr'])
                                            ->where('st_lokasi', substr('00' . $r->trbo_flagdisc2, -2))
                                            ->where('st_prdcd', $r->trbo_prdcd)
                                            ->first();

                                        if ($data) {
                                            $newqty = $data->newqty;
                                            $newlcost = $data->newlcost;
                                        }

                                        $step = 62;

                                        $data = DB::table('tbmaster_prodmast')
                                            ->selectRaw("NVL(prd_frac,1) prdfrac")
                                            ->where('prd_prdcd', $r->trbo_prdcd)
                                            ->where('prd_kodeigr', $_SESSION['kdigr'])
                                            ->first();

                                        if ($data) {
                                            $prdfrac = $data->prdfrac;
                                        }

                                        if ($jum > 0) {
                                            $step = 63;
                                            $data = DB::table('tbmaster_stock')
                                                ->selectRaw("NVL(st_avgcost,0) st_avgcost")
                                                ->where('st_prdcd', $r->trbo_prdcd)
                                                ->where('st_kodeigr', $_SESSION['kdigr'])
                                                ->where('st_lokasi', '01')
                                                ->first();

                                            if ($oldacost) {
                                                $oldacost2 = $data->st_avgcost;
                                            }
                                        } else {
                                            $step = 64;
                                            $oldacos2 = 0;
                                        }

                                        if ($r->trbo_flagdisc1 != '1') {
                                            if ($r->trbo_flagdisc2 == '1') {
                                                $step = 66;
                                                $data = DB::table('tbmaster_prodmast')
                                                    ->selectRaw("NVL(prd_frac,0) prd_frac")
                                                    ->where('prd_kodeigr', $_SESSION['kdigr'])
                                                    ->where('prd_prdcd', $r->trbo_prdcd)
                                                    ->first();

                                                if ($data)
                                                    $prdfrac = $data->prd_frac;

                                                $step = 67;

                                                $jum = DB::table('tbmaster_prodmast')
                                                    ->selectRaw("NVL(prd_avgcost,0) prdacost")
                                                    ->where('prd_kodeigr', $_SESSION['kdigr'])
                                                    ->where('prd_prdcd', substr($r->trbo_prdcd, 0, 6) . '1')
                                                    ->first();

                                                if ($jum) {
                                                    $step = 68;
                                                    $prdacost = $jum->prdacost;
                                                } else {
                                                    $step = 69;
                                                    $prdacost = 0;
                                                }

                                                if ($r->trbo_flagdisc1 == '3') {
                                                    $step = 71;
                                                    DB::table('tbmaster_prodmast')
                                                        ->where('prd_kodeigr', $_SESSION['kdigr'])
                                                        ->where('prd_prdcd', $r->trbo_prdcd)
                                                        ->update([
                                                            'prd_avgcost' => DB::RAW("CASE
                                                               WHEN NVL (PRD_AVGCOST, 0) = 0
                                                                   THEN " . $r->trbo_hrgsatuan . "
                                                               ELSE PRD_AVGCOST
                                                           END")
                                                        ]);
                                                }

                                                $step = 72;
                                                $plulama = DB::table('tbtr_backoffice')
                                                    ->select('trbo_prdcd')
                                                    ->where('trbo_nodoc', $r->trbo_nodoc)
                                                    ->where('trbo_kodeigr', $_SESSION['kdigr'])
                                                    ->where('trbo_typetrn', 'X')
                                                    ->where('trbo_qty', '<', 0)
                                                    ->whereRaw("NVL(trbo_recordid, ' ') <> '1'")
                                                    ->first()->trbo_prdcd;
                                            }

                                            $step = 86;
                                            if ($v_prd1st0 == 1 && $r->trbo_qty > 0) {
                                                $step = 87;
                                                $plulama = DB::table('tbtr_backoffice')
                                                    ->select('trbo_prdcd')
                                                    ->where('trbo_nodoc', $r->trbo_nodoc)
                                                    ->where('trbo_kodeigr', $_SESSION['kdigr'])
                                                    ->where('trbo_typetrn', 'X')
                                                    ->where('trbo_qty', '<', 0)
                                                    ->whereRaw("NVL(trbo_recordid, ' ') <> '1'")
                                                    ->first()->trbo_prdcd;

                                                $step = 88;
                                                $v_oldprdacost = DB::table('tbmaster_prodmast')
                                                    ->selectRaw("NVL(prd_avgcost,0) prd_avgcost")
                                                    ->where('prd_kodeigr', $_SESSION['kdigr'])
                                                    ->where('prd_prdcd', $plulama)
                                                    ->first()->prd_avgcost;

                                                $step = 89;
                                                $data = DB::table('tbmaster_prodmsat')
                                                    ->selectRaw("NVL(prd_avgcost,0) prd_avgcost")
                                                    ->where('prd_kodeigr', $_SESSION['kdigr'])
                                                    ->where('prd_prdcd', substr($plulama, 0, 6) . '1')
                                                    ->first();

                                                if ($data) {
                                                    $step = 90;
                                                    $v_oldprdacost1 = $data->prd_avgcost;
                                                }

                                                $step = 91;
                                                $jum = DB::table('tbmaster_prodmast')
                                                    ->selectRaw("NVL(prd_avgcost,0) prd_avgcost")
                                                    ->where('prd_kodeigr', $_SESSION['kdigr'])
                                                    ->where('prd_prdcd', substr($plulama, 0, 6) . '2')
                                                    ->first();

                                                if ($jum) {
                                                    $step = 92;
                                                    $v_oldprdacost = $jum->prd_avgcost;
                                                }

                                                $step = 94;
                                                $data = DB::table('tbmaster_prodmast')
                                                    ->selectRaw("NVL(prd_avgcost,0) prd_avgcost")
                                                    ->where('prd_kodeigr', $_SESSION['kdigr'])
                                                    ->where('prd_prdcd', substr($plulama, 0, 6) . '3')
                                                    ->first();

                                                if ($data) {
                                                    $step = 95;
                                                    $v_oldprdacost = $data->prd_avgcost;
                                                }
                                            }
                                        }
                                    }

                                    if ($v_prd1st0 == 1 && $r->trbo_qty > 0) {
                                        $step = 99;
                                        $prdcdlama = DB::table('tbtr_backoffice')
                                            ->select('trbo_prdcd')
                                            ->where('trbo_nodoc', $r->trbo_nodoc)
                                            ->where('trbo_kodeigr', $r->trbo_kodeigr)
                                            ->where('trbo_flagdisc2', $r->trbo_flagdisc2)
                                            ->where('trbo_qty', '<', 0)
                                            ->whereRaw("NVL(trbo_recordid,' ') <> '1'")
                                            ->first()->trbo_prdcd;

                                        $step = 100;
                                        $v_lcplulama1 = DB::table('tbmaster_prodmast')
                                            ->select('prd_lastcost')
                                            ->where('prd_kodeigr', $_SESSION['kdigr'])
                                            ->where('prd_prdcd', $prdcdlama)
                                            ->first()->prd_lastcost;

                                        $step = 101;
                                        $data = DB::table('tbmaster_prodmast')
                                            ->select('prd_lastcost')
                                            ->where('prd_prdcd', substr($prdcdlama, 0, 6) . '1')
                                            ->where('prd_kodeigr', $_SESSION['kdigr'])
                                            ->first();

                                        if ($data) {
                                            $v_lcplulama1 = $data->prd_lastcost;
                                        } else $v_lcplulama1 = 0;

                                        $v_oldprdacost1 = $v_lcplulama1;

                                        $step = 104;
                                        $data = DB::table('tbmaster_prodmast')
                                            ->selectRaw("NVL(prd_lastcost,0) prd_lastcost")
                                            ->where('prd_kodeigr', $_SESSION['kdigr'])
                                            ->where('prd_prdcd', substr($prdcdlama, 0, 6) . '2')
                                            ->first();

                                        if ($data) {
                                            $step = 105;
                                            $v_lcplulama1 = $data->prd_lastcost;
                                        }

                                        $step = 107;
                                        $data = DB::table('tbmaster_prodmast')
                                            ->selectRaw("NVL(prd_lastcost,0) prd_lastcost")
                                            ->where('prd_kodeigr', $_SESSION['kdigr'])
                                            ->where('prd_prdcd', substr($prdcdlama, 0, 6) . '3')
                                            ->first();

                                        if ($data) {
                                            $v_lcplulama1 = $data->prd_lastcost;
                                        }
                                    }

                                    if ($r->trbo_flagdisc1 == '3') {
                                        $step = 111;
                                        $data = DB::table('tbtr_backoffice')
                                            ->select('trbo_prdcd')
                                            ->where('trbo_nodoc', $r->trbo_nodoc)
                                            ->where('trbo_kodeigr', $r->trbo_kodeigr)
                                            ->where('trbo_flagdisc2', $r->trbo_flagdisc2)
                                            ->where('trbo_qty', '<', 0)
                                            ->whereRaw("NVL(trbo_recordid,' ') <> '1'")
                                            ->first();

                                        if($data)
                                            $prdcdlama = $data->trbo_prdcd;

                                        $step = 112;
                                        $data = DB::table('tbtr_backoffice')
                                            ->select('trbo_prdcd')
                                            ->where('trbo_nodoc', $r->trbo_nodoc)
                                            ->where('trbo_kodeigr', $r->trbo_kodeigr)
                                            ->where('trbo_flagdisc2', $r->trbo_flagdisc2)
                                            ->where('trbo_qty', '>', 0)
                                            ->whereRaw("NVL(trbo_recordid,' ') <> '1'")
                                            ->first();

                                        if($data)
                                            $prdcdbaru = $data->trbo_prdcd;
                                    }

                                    if ($r->trbo_flagdisc1 == '3' && $r->trbo_qty > 0) {
                                        $step = 114;
                                        if ($step114) {
                                            $jum = DB::table('tbmaster_barangbaru')
                                                ->where('pln_prdcd', substr($prdcdlama, 0, 6) . '0')
                                                ->where('pln_kodeigr', $_SESSION['kdigr'])
                                                ->get()->count();

                                            if ($jum > 0) {
                                                $step = 116;
                                                $jum = DB::table('tbhistory_barangbaru')
                                                    ->where('hpn_prdcd', substr($prdcdbaru, 0, 6) . '0')
                                                    ->where('hpn_kodeigr', $_SESSION['kdigr'])
                                                    ->get()->count();

                                                if ($jum == 0) {
                                                    $step = 117;
                                                    $data = DB::table('tbmaster_barangbaru')
                                                        ->where('pln_prdcd', substr($prdcdbaru, 0, 6) . '0')
                                                        ->where('pln_kodeigr', $_SESSION['kdigr'])
                                                        ->first();

                                                    $step = 118;
                                                    DB::table('tbhistory_barangbaru')
                                                        ->insert([
                                                            'hpn_kodeigr' => $data->pln_kodeigr,
                                                            'hpn_prdcd' => $data->pln_prdcd,
                                                            'hpn_pkmt' => $data->pln_pkmt,
                                                            'hpn_flagtag' => $data->pln_flagtag,
                                                            'hpn_tglbpb' => $data->pln_tglbpb,
                                                            'hpn_tglaktif' => $data->pln_tglaktif,
                                                            'hpn_create_by' => $data->pln_create_by,
                                                            'hpn_create_dt' => $data->pln_create_dt,
                                                            'hpn_modify_by' => $data->pln_modify_dt,
                                                            'hpn_modify_dt' => $data->pln_modify_dt
                                                        ]);
                                                }

                                                $step = 119;
                                                DB::table('tbmaser_barangbaru')
                                                    ->where('pln_prdcd', substr($prdcdbaru, 0, 6) . '0')
                                                    ->where('pln_kodeigr', $_SESSION['kdigr']);
                                            }

                                            $step = 120;
                                            $jum = DB::table('tbmaster_lokasi')
                                                ->where('lks_prdcd', $prdcdlama)
                                                ->where('lks_kodeigr', $r->trbo_kodeigr)
                                                ->get()->count();

                                            if ($jum > 0) {
                                                $step = 121;
                                                if ($v_plua1 > 0 && $v_plub1 > 0) {
                                                    $step = 122;
                                                    $data = DB::table('tbmaster_lokasi')
                                                        ->where('lks_prdcd', $prdcdbaru)
                                                        ->where('lks_kodeigr', $r->trbo_kodeigr)
                                                        ->first()->toArray();

                                                    if ($data) {
                                                        $data['lks_nodoc'] = $r->trbo_nodoc;

                                                        DB::table('temp_tbmaster_lokasi')
                                                            ->insert($data);
                                                    }
                                                }

                                                $step = 123;
                                                DB::table('tbmaster_lokasi')
                                                    ->where('lks_prdcd', $prdcdbaru)
                                                    ->where('lks_kodeigr', $r->trbo_kodeigr)
                                                    ->delete();

                                                $step = 124;
                                                $data = DB::table('tbmaster_lokasi')
                                                    ->where('lks_prdcd', $prdcdlama)
                                                    ->where('lks_kodeigr', $r->trbo_kodeigr)
                                                    ->first()->toArray();

                                                $data['lks_nodoc'] = $r->trbo_nodoc;

                                                DB::table('temp_tbmaster_lokasi')
                                                    ->insert($data);

                                                $step = 125;
                                                DB::table('tbmaster_lokasi')
                                                    ->where('lks_prdcd', $prdcdlama)
                                                    ->where('lks_kodeigr', $r->trbo_kodeigr)
                                                    ->update([
                                                        'lks_prdcd' => $prdcdbaru,
                                                        'lks_modify_by' => $_SESSION['usid'],
                                                        'lks_modify_dt' => DB::RAW("SYSDATE")
                                                    ]);

                                                $step = 126;
                                                DB::table('tbmaster_lokasi')
                                                    ->where('lks_prdcd', $prdcdlama)
                                                    ->where('lks_kodeigr', $r->trbo_kodeigr)
                                                    ->delete();
                                            }
                                        }

                                        $step = 134;
                                        $jum = DB::table('tbtr_promomd')
                                            ->whereRaw("SUBSTR(PRMD_PRDCD,1,6) = " . substr($prdcdlama, 0, 6))
                                            ->where('prmd_kodeigr', $_SESSION['kdigr'])
                                            ->get()->count();

                                        if ($jum > 0) {
                                            if ($v_plua1 > 0 && $v_plub1 > 0) {
                                                $step = 135;
                                                $data = DB::table('tbtr_promomd')
                                                    ->whereRaw("SUBSTR(PRMD_PRDCD,1,6) = " . substr($prdcdbaru, 0, 6))
                                                    ->where('prmd_kodeigr', $_SESSION['kdigr'])
                                                    ->first()->toArray();

                                                $data['prmd_nodoc'] = $r->trbo_nodoc;

                                                DB::table('temp_tbtr_promomd')
                                                    ->insert($data);
                                            }

                                            $step = 136;
                                            DB::table('tbtr_promomd')
                                                ->whereRaw("SUBSTR(PRMD_PRDCD,1,6) = " . substr($prdcdbaru, 0, 6))
                                                ->where('prmd_kodeigr', $_SESSION['kdigr'])
                                                ->delete();

                                            $step = 137;
                                            $data = DB::table('tbtr_promomd')
                                                ->whereRaw("SUBSTR(PRMD_PRDCD,1,6) = " . substr($prdcdlama, 0, 6))
                                                ->where('prmd_kodeigr', $_SESSION['kdigr'])
                                                ->first()->toArray();

                                            $data['prmd_nodoc'] = $r->trbo_nodoc;

                                            DB::table('temp_tbtr_promomd')
                                                ->insert($data);

                                            $step = 138;
                                            DB::table('tbtr_promomd')
                                                ->where('prmd_prdcd', substr($prdcdlama, 0, 6) . '0')
                                                ->where('prmd_kodeigr', $_SESSION['kdigr'])
                                                ->update([
                                                    'prmd_prdcd' => substr($prdcdbaru, 0, 6) . '0',
                                                    'prmd_modify_by' => $_SESSION['usid'],
                                                    'prmd_modify_dt' => DB::RAW("sysdate")
                                                ]);

                                            $step = 139;
                                            DB::table('tbtr_promomd')
                                                ->where('prmd_prdcd', substr($prdcdlama, 0, 6) . '1')
                                                ->where('prmd_kodeigr', $_SESSION['kdigr'])
                                                ->update([
                                                    'prmd_prdcd' => substr($prdcdbaru, 0, 6) . '1',
                                                    'prmd_modify_by' => $_SESSION['usid'],
                                                    'prmd_modify_dt' => DB::RAW("sysdate")
                                                ]);

                                            $step = 140;
                                            DB::table('tbtr_promomd')
                                                ->where('prmd_prdcd', substr($prdcdlama, 0, 6) . '2')
                                                ->where('prmd_kodeigr', $_SESSION['kdigr'])
                                                ->update([
                                                    'prmd_prdcd' => substr($prdcdbaru, 0, 6) . '2',
                                                    'prmd_modify_by' => $_SESSION['usid'],
                                                    'prmd_modify_dt' => DB::RAW("sysdate")
                                                ]);

                                            $step = 141;
                                            DB::table('tbtr_promomd')
                                                ->where('prmd_prdcd', substr($prdcdlama, 0, 6) . '3')
                                                ->where('prmd_kodeigr', $_SESSION['kdigr'])
                                                ->update([
                                                    'prmd_prdcd' => substr($prdcdbaru, 0, 6) . '3',
                                                    'prmd_modify_by' => $_SESSION['usid'],
                                                    'prmd_modify_dt' => DB::RAW("sysdate")
                                                ]);

                                            $step = 142;
                                            DB::table('tbtr_promomd')
                                                ->whereRaw("SUBSTR(PRMD_PRDCD,1,6) = " . substr($prdcdlama, 0, 6))
                                                ->where('prmd_kodeigr', $_SESSION['kdigr'])
                                                ->delete();
                                        }
                                    }

                                    if ($step143 && $r->trbo_flagdisc1 == '3' && $r->trbo_qty > 0) {
                                        if (($lfirst == '1' && $r->trbo_qty < 0) && ($lfirst == '0' && $r->trbo_qty < 0)) {
                                            if ($r->trbo_qty > 0) {
                                                $step = 144;
                                                $jum == DB::table('tbmaster_kkpkm')
                                                    ->where('pkm_prdcd', $prdcdlama)
                                                    ->where('pkm_kodeigr', $r->trbo_kodeigr)
                                                    ->get()->count();

                                                if ($jum > 0) {
                                                    $step = 145;
                                                    if ($v_plua1 > 0 && $v_plub1 > 0) {
                                                        $step = 146;
                                                        $data = DB::table('tbmaster_kkpkm')
                                                            ->where('pkm_prdcd', $prdcdbaru)
                                                            ->where('pkm_kodeigr', $_SESSION['kdigr'])
                                                            ->first()->toArray();

                                                        $data['pkm_nodoc'] = $r->trbo_nodoc;

                                                        DB::table('temp_tbmaster_kkpkm')
                                                            ->insert($data);
                                                    }

                                                    $step = 147;
                                                    DB::table('tbmaster_kkpkm')
                                                        ->where('pkm_prdcd', $prdcdbaru)
                                                        ->where('pkm_kodeigr', $_SESSION['kdigr'])
                                                        ->delete();

                                                    $step = 148;
                                                    $data = DB::table('tbmaster_kkpkm')
                                                        ->where('pkm_prdcd', $prdcdlama)
                                                        ->where('pkm_kodeigr', $_SESSION['kdigr'])
                                                        ->first()->toArray();

                                                    $data['pkm_nodoc'] = $r->trbo_nodoc;

                                                    DB::table('temp_tbmaster_kkpkm')
                                                        ->insert($data);

                                                    $step = 149;
                                                    DB::table('tbmaster_kkpkm')
                                                        ->where('pkm_prdcd', $prdcdlama)
                                                        ->where('pkm_kodeigr', $_SESSION['kdigr'])
                                                        ->update([
                                                            'pkm_prdcd' => $prdcdbaru,
                                                            'pkm_modify_by' => $_SESSION['usid'],
                                                            'pkm_modify_dt' => DB::RAW("SYSDATE")
                                                        ]);

                                                    $step = 150;
                                                    DB::table('tbmaster_kkpkm')
                                                        ->where('pkm_prdcd', $prdcdlama)
                                                        ->where('pkm_kodeigr', $_SESSION['kdigr'])
                                                        ->delete();
                                                }

                                                $step = 151;
                                                $jum = DB::table('tbtr_pkmgondola')
                                                    ->where('pkmg_prdcd', $prdcdlama)
                                                    ->where('pkmg_kodeigr', $r->trbo_kodeigr)
                                                    ->get()->count();

                                                $step = 152;
                                                if ($jum > 0) {
                                                    $jum = 0;

                                                    if ($v_plua1 > 0 && $v_plub1 > 0) {
                                                        $step = 153;
                                                        $data = DB::table('tbtr_pkmgondola')
                                                            ->where('pkmg_prdcd', $prdcdbaru)
                                                            ->where('pkmg_kodeigr', $_SESSION['kdigr'])
                                                            ->first()->toArray();

                                                        $data['pkmg_nodoc'] = $r->trbo_nodoc;

                                                        DB::table('temp_tbtr_pkmgondola')
                                                            ->insert($data);
                                                    }

                                                    $step = 154;
                                                    DB::table('tbtr_pkmgondola')
                                                        ->where('pkmg_prdcd', $prdcdbaru)
                                                        ->where('pkmg_kodeigr', $_SESSION['kdigr'])
                                                        ->delete();

                                                    $data = DB::table('tbtr_pkmgondola')
                                                        ->where('pkmg_prdcd', $prdcdlama)
                                                        ->where('pkmg_kodeigr', $_SESSION['kdigr'])
                                                        ->first()->toArray();

                                                    $data['pkmg_nodoc'] = $r->trbo_nodoc;

                                                    DB::table('temp_tbtr_pkmgondola')
                                                        ->insert($data);

                                                    $step = 155;
                                                    DB::table('tbtr_pkmgondola')
                                                        ->where('pkmg_prdcd', $prdcdlama)
                                                        ->where('pkmg_kodeigr', $_SESSION['kdigr'])
                                                        ->update([
                                                            'pkmg_prdcd' => $prdcdbaru,
                                                            'pkmg_modify_by' => $_SESSION['usid'],
                                                            'pkmg_modify_dt' => DB::RAW("SYSDATE")
                                                        ]);

                                                    $step = 156;
                                                    DB::table('tbtr_pkmgondola')
                                                        ->where('pkmg_prdcd', $prdcdlama)
                                                        ->where('pkmg_kodeigr', $_SESSION['kdigr'])
                                                        ->delete();
                                                }

                                                $step = 157;
                                                $jum = DB::table('tbmaster_pkmplus')
                                                    ->where('pkmp_prdcd', $prdcdlama)
                                                    ->where('pkmp_kodeigr', $_SESSION['kdigr'])
                                                    ->get()->count();

                                                $step = 158;
                                                if ($jum > 0) {
                                                    if ($v_plua1 > 0 && $v_plub1 > 0) {
                                                        $step = 159;
                                                        $data = DB::table('tbmaster_pkmplus')
                                                            ->where('pkmp_prdcd', $prdcdbaru)
                                                            ->where('pkmp_kodeigr', $_SESSION['kdigr'])
                                                            ->first()->toArray();

                                                        $data['pkmp_nodoc'] = $r->trbo_nodoc;

                                                        DB::table('temp_tbmaster_pkmplus')
                                                            ->insert($data);
                                                    }

                                                    $step = 160;
                                                    DB::table('tbmaster_pkmplus')
                                                        ->where('pkmp_prdcd', $prdcdbaru)
                                                        ->where('pkmp_kodeigr', $_SESSION['kdigr'])
                                                        ->delete();

                                                    $data = DB::table('tbmaster_pkmplus')
                                                        ->where('pkmp_prdcd', $prdcdlama)
                                                        ->where('pkmp_kodeigr', $_SESSION['kdigr'])
                                                        ->first()->toArray();

                                                    $data['pkmp_nodoc'] = $r->trbo_nodoc;

                                                    DB::table('temp_tbmaster_pkmplus')
                                                        ->insert($data);

                                                    $step = 161;
                                                    DB::table('tbtr_pkmplus')
                                                        ->where('pkmp_prdcd', $prdcdlama)
                                                        ->where('pkmp_kodeigr', $_SESSION['kdigr'])
                                                        ->update([
                                                            'pkmp_prdcd' => $prdcdbaru,
                                                            'pkmp_modify_by' => $_SESSION['usid'],
                                                            'pkmp_modify_dt' => DB::RAW("SYSDATE")
                                                        ]);

                                                    DB::table('tbmaster_pkmplus')
                                                        ->where('pkmp_prdcd', $prdcdlama)
                                                        ->where('pkmp_kodeigr', $_SESSION['kdigr'])
                                                        ->delete();
                                                }

                                                $step = 162;
                                                $jum = DB::table('tbtr_gondola')
                                                    ->where('gdl_prdcd', $prdcdlama)
                                                    ->where('gdl_kodeigr', $_SESSION['kdigr'])
                                                    ->get()->count();

                                                $step = 163;
                                                if ($jum > 0) {
                                                    if ($v_plua1 > 0 && $v_plub1 > 0) {
                                                        $step = 164;
                                                        $data = DB::table('tbtr_gondola')
                                                            ->where('gdl_prdcd', $prdcdbaru)
                                                            ->where('gdl_kodeigr', $_SESSION['kdigr'])
                                                            ->first()->toArray();

                                                        $data['gdl_nodoc'] = $r->trbo_nodoc;

                                                        DB::table('temp_tbtr_gondola')
                                                            ->insert($data);
                                                    }

                                                    $step = 165;
                                                    DB::table('tbtr_gondola')
                                                        ->where('gdl_prdcd', $prdcdbaru)
                                                        ->where('gdl_kodeigr', $_SESSION['kdigr'])
                                                        ->delete();

                                                    $step = 166;
                                                    $data = DB::table('tbtr_gondola')
                                                        ->where('gdl_prdcd', $prdcdlama)
                                                        ->where('gdl_kodeigr', $_SESSION['kdigr'])
                                                        ->first()->toArray();

                                                    $data['gdl_nodoc'] = $r->trbo_nodoc;

                                                    DB::table('temp_tbtr_gondola')
                                                        ->insert($data);

                                                    $step = 167;
                                                    DB::table('tbtr_gondola')
                                                        ->where('gdl_prdcd', $prdcdlama)
                                                        ->where('gdl_kodeigr', $_SESSION['kdigr'])
                                                        ->update([
                                                            'gdl_prdcd' => $prdcdbaru,
                                                            'gdl_modify_by' => $_SESSION['usid'],
                                                            'gdl_modify_dt' => DB::RAW("SYSDATE")
                                                        ]);

                                                    $step = 168;
                                                    DB::table('tbtr_gondola')
                                                        ->where('gdl_prdcd', $prdcdlama)
                                                        ->where('gdl_kodeigr', $_SESSION['kdigr'])
                                                        ->delete();
                                                }

                                                $step = 169;
                                                $jum = DB::table('tbmaster_minimumorder')
                                                    ->where('min_prdcd', $prdcdlama)
                                                    ->where('min_kodeigr', $_SESSION['kdigr'])
                                                    ->get()->count();

                                                if ($jum > 0) {
                                                    $step = 170;
                                                    if ($v_plua1 > 0 && $v_plub1 > 0) {
                                                        $step = 171;
                                                        $data = DB::table('tbmaster_minimumorder')
                                                            ->where('min_prdcd', $prdcdbaru)
                                                            ->where('min_kodeigr', $_SESSION['kdigr'])
                                                            ->first()->toArray();

                                                        $data['min_nodoc'] = $r->trbo_nodoc;

                                                        DB::table('temp_tbmaster_minimumorder')
                                                            ->insert($data);
                                                    }

                                                    $step = 172;
                                                    DB::table('tbmaster_minimumorder')
                                                        ->where('min_prdcd', $prdcdbaru)
                                                        ->where('min_kodeigr', $_SESSION['kdigr'])
                                                        ->delete();

                                                    $step = 173;
                                                    $data = DB::table('tbmaster_minimumorder')
                                                        ->where('min_prdcd', $prdcdlama)
                                                        ->where('min_kodeigr', $_SESSION['kdigr'])
                                                        ->first()->toArray();

                                                    $data['min_nodoc'] = $r->trbo_nodoc;

                                                    DB::table('temp_tbmaster_minimumorder')
                                                        ->insert($data);

                                                    $step = 174;
                                                    DB::table('tbmaster_minimumorder')
                                                        ->where('min_prdcd', $prdcdlama)
                                                        ->where('min_kodeigr', $_SESSION['kdigr'])
                                                        ->update([
                                                            'min_prdcd' => $prdcdbaru,
                                                            'min_modify_by' => $_SESSION['usid'],
                                                            'min_modify_dt' => DB::RAW("SYSDATE")
                                                        ]);

                                                    $step = 175;
                                                    DB::table('temp_tbmaster_minimumorder')
                                                        ->where('min_prdcd', $prdcdlama)
                                                        ->where('min_kodeigr', $_SESSION['kdigr'])
                                                        ->delete();
                                                }

                                                $step = 176;
                                                $jum = DB::table('tbtr_konversiplu')
                                                    ->where('kvp_pluold', $prdcdlama)
                                                    ->where('kvp_plunew', $prdcdbaru)
                                                    ->where('kvp_kodetipe', 'M')
                                                    ->where('kvp_kodeigr', $_SESSION['kdigr'])
                                                    ->get()->count();

                                                $step = 177;
                                                if ($jum == 0) {
                                                    $step = 178;
                                                    $fracold = DB::table('tbmaster_prodmast')
                                                        ->select('prd_frac')
                                                        ->where('prd_kodeigr', $_SESSION['kdigr'])
                                                        ->where('prd_prdcd', $prdcdlama)
                                                        ->first()->prd_frac;

                                                    $step = 179;
                                                    $fracnew = DB::table('tbmaster_prodmast')
                                                        ->select('prd_frac')
                                                        ->where('prd_kodeigr', $_SESSION['kdigr'])
                                                        ->where('prd_prdcd', $prdcdbaru)
                                                        ->first()->prd_frac;

                                                    $step = 180;
                                                    DB::table('tbtr_konversiplu')
                                                        ->insert([
                                                            'kvp_kodeigr' => $_SESSION['kdigr'],
                                                            'kvp_pluold' => $prdcdlama,
                                                            'kvp_plunew' => $prdcdbaru,
                                                            'kvp_kodetipe' => 'M',
                                                            'kvp_tgl' => DB::RAW("CASE
                                                                 WHEN REC.TRBO_MODIFY_DT IS NOT NULL
                                                                     THEN REC.TRBO_MODIFY_DT
                                                                 ELSE REC.TRBO_CREATE_DT
                                                             END"),
                                                            'kvp_konversiold' => $fracold,
                                                            'kvp_konversinew' => $fracnew,
                                                            'kvp_create_dt' => DB::RAW("SYSDATE"),
                                                            'kvp_create_by' => $_SESSION['usid']
                                                        ]);
                                                }
                                            }
                                        }
                                    }
                                    if ($lfirst == 1) {
                                        $lfirst = 0;
                                    } else $lfirst = 1;

                                    $v_supp = $r->trbo_kodesupplier;
                                    $v_pkp = $r->sup_pkp;
                                    $v_cterm = $r->sup_top;
                                    $v_kethdr = $r->trbo_keterangan;
                                }

                                DB::table('tbtr_mstran_h')
                                    ->insert([
                                        'msth_kodeigr' => $_SESSION['kdigr'],
                                        'msth_typetrn' => 'X',
                                        'msth_nodoc' => $n,
                                        'msth_tgldoc' => DB::RAW("TRUNC(SYSDATE)"),
                                        'msth_flagdoc' => '1',
                                        'msth_kodesupplier' => $v_supp,
                                        'msth_create_by' => $_SESSION['usid'],
                                        'msth_create_dt' => DB::RAW("SYSDATE"),
                                        'msth_pkp' => $v_pkp,
                                        'msth_cterm' => $v_cterm,
                                        'msth_keterangan_header' => $v_kethdr,
                                        'msth_noref3' => $v_noreff,
                                        'msth_tgref3' => $v_tglreff
                                    ]);

                                DB::table('tbtr_backoffice')
                                    ->where('trbo_nodoc', $n)
                                    ->whereRaw("NVL(trbo_recordid, ' ') <> '1'")
                                    ->update([
                                        'trbo_flagdoc' => '*',
                                        'trbo_recordid' => '2'
                                    ]);
                            }
                        }
                    }
                }

                DB::commit();

                $perusahaan = DB::table('tbmaster_perusahaan')
                    ->select('prs_namaperusahaan','prs_namacabang')
                    ->first();

                $nodoc = "(";
                foreach($_SESSION['pys_nodoc'] as $no){
                    $nodoc .= "'".$no."',";
                }
                $nodoc = substr($nodoc,0,strlen($nodoc)-1).")";

                $report = DB::select("Select DISTINCT 
                            msth_recordid, msth_nodoc, msth_tgldoc, msth_nopo, msth_tglpo,
                            msth_nofaktur, msth_tglfaktur, msth_cterm, msth_flagdoc,
                            mstd_prdcd, prd_deskripsipanjang, 
                            prd_unit||'/'||prd_frac kemasan, mstd_qty, mstd_frac,
                                        mstd_seqno,
                            case when mstd_flagdisc1 = '1' then 'SELISIH STOCK OPNAME' else
                            case when mstd_flagdisc1 = '2' then 'TERTUKAR JENIS' else
                            'GANTI_PLU' end end as keterangan_h,
                            mstd_hrgsatuan, mstd_ppnrph, mstd_ppnbmrph, mstd_ppnbtlrph, mstd_gross,
                            nvl(mstd_rphdisc1,0) mstd_rphdisc1, nvl(mstd_rphdisc2,0) mstd_rphdisc2,nvl(mstd_rphdisc3,0) mstd_rphdisc3, 
                            nvl(mstd_qtybonus1,0) mstd_qtybonus1, nvl(mstd_qtybonus2,0) mstd_qtybonus2,  mstd_keterangan,
                            trbo_noreff, trbo_tglreff            
                        From 
                            tbtr_mstran_h, 
                            tbtr_mstran_d, 
                            tbmaster_prodmast, 
                            tbmaster_cabang,
                            tbtr_backoffice
                        Where 
                            msth_kodeigr='".$_SESSION['kdigr']."'
                            and mstd_nodoc=msth_nodoc
                            and mstd_kodeigr=msth_kodeigr
                            and prd_kodeigr=msth_kodeigr
                            and prd_prdcd = mstd_prdcd
                            and cab_kodecabang(+)=msth_loc
                            and cab_kodeigr(+)=msth_kodeigr
                            and trbo_kodeigr = msth_kodeigr
                            and trbo_nodoc=msth_nodoc
                            and trbo_prdcd=mstd_prdcd
                            and NVL(trbo_recordid,'0') <> '1'
                            and msth_nodoc in ".$nodoc."
                        ORDER BY msth_nodoc,MSTD_SEQNO");

                $data = [
                    'perusahaan' => $perusahaan,
                    'report' => $report,
                    'ukuran' => $ukuran
                ];

//                dd($data);


                $dompdf = new PDF();

                $pdf = PDF::loadview('BACKOFFICE.TRANSAKSI.PENYESUAIAN.laporan-nota',$data);

                error_reporting(E_ALL ^ E_DEPRECATED);

                $pdf->output();
                $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);

                $canvas = $dompdf ->get_canvas();
                $canvas->page_text(507, 80.75, "{PAGE_NUM} dari {PAGE_COUNT}", null, 7, array(0, 0, 0));

                $dompdf = $pdf;

                return $dompdf->stream('Laporan Penyesuaian.pdf');
            }
        }
        catch(QueryException $e){
            DB::rollBack();
            $message = $e->getMessage();

            return compact(['step','message']);
        }
    }

    public function tes(){

    }

    public function nvl($value, $defaultvalue){
        if($value == null || $value == '')
            return $defaultvalue;
        else return $value;
    }
}
