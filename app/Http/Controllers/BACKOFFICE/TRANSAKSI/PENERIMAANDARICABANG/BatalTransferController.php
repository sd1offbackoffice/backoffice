<?php

namespace App\Http\Controllers\BACKOFFICE\TRANSAKSI\PENERIMAANDARICABANG;

use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;
use PDF;
use Yajra\DataTables\DataTables;

class BatalTransferController extends Controller
{
    public function index(){
        return view('BACKOFFICE.TRANSAKSI.PENERIMAANDARICABANG.batal-transfer');
    }

    public function getDataLov(){
        $lov = DB::connection($_SESSION['connection'])->table('tbtr_mstran_h')
            ->selectRaw("msth_nodoc no, TO_CHAR(msth_tgldoc, 'DD/MM/YYYY') tgl")
            ->where('msth_typetrn','=','I')
            ->where('msth_kodeigr','=',$_SESSION['kdigr'])
            ->whereRaw("NVL(msth_recordid,0) <> 1")
            ->orderBy('msth_tgldoc','desc')
            ->get();

        return DataTables::of($lov)->make(true);
    }

    public function batal(Request $request){
        try{
            DB::beginTransaction();

            $nosj = $request->nosj;

            $cek = DB::connection($_SESSION['connection'])->table('tbtr_mstran_h')
                ->selectRaw("TO_CHAR(MSTH_TGLDOC,'MMYYYY') tgl, TO_CHAR(SYSDATE,'MMYYYY') tglnow")
                ->where('msth_kodeigr','=',$_SESSION['kdigr'])
                ->where('msth_typetrn','=','I')
                ->where('msth_nodoc','=',$nosj)
                ->whereRaw("NVL(msth_recordid,'0') <> '1'")
                ->distinct()
                ->first();

            if($cek->tgl != $cek->tglnow){
                $status = 'error';
                $title = 'Tidak dapat melakukan pembatalan transfer antar cabang selain periode sekarang!';

                return compact(['status','title']);
            }
            else{
                $recs = DB::connection($_SESSION['connection'])->table('tbtr_mstran_d')
                    ->where('mstd_typetrn','=','I')
                    ->where('mstd_nodoc','=',$nosj)
                    ->where('mstd_kodeigr','=',$_SESSION['kdigr'])
                    ->get();

                foreach($recs as $rec){
                    $prdcur = DB::connection($_SESSION['connection'])->table('tbmaster_prodmast')
                        ->select('prd_unit','prd_frac','prd_avgcost')
                        ->where('prd_prdcd','=',substr($rec->mstd_prdcd,0,6).'1')
                        ->where('prd_kodeigr','=',$_SESSION['kdigr'])
                        ->first();

                    if(!$prdcur){
                        $prdcur = DB::connection($_SESSION['connection'])->table('tbmaster_prodmast')
                            ->select('prd_unit','prd_frac','prd_avgcost')
                            ->where('prd_prdcd','=',substr($rec->mstd_prdcd,0,6).'0')
                            ->where('prd_kodeigr','=',$_SESSION['kdigr'])
                            ->first();
                    }

                    $unit = $prdcur->prd_unit;
                    $frac = $prdcur->prd_frac;
                    $avgcost = $prdcur->prd_avgcost;

                    $temp = DB::connection($_SESSION['connection'])->table('tbmaster_stock')
                        ->select('st_saldoakhir','st_avgcost','st_trfin')
                        ->where('st_kodeigr','=',$_SESSION['kdigr'])
                        ->where('st_prdcd','=',substr($rec->mstd_prdcd,0,6).'0')
                        ->where('st_lokasi','=','01')
                        ->first();

                    if(!$temp){
                        DB::connection($_SESSION['connection'])->table('tbmaster_stock')
                            ->insert([
                                'st_kodeigr' => $_SESSION['kdigr'],
                                'st_prdcd' => substr($rec->mstd_prdcd,0,6).'0',
                                'st_lokasi' => '01'
                            ]);

                        $qtystk = 0;
                        $avgstk = 0;
                        $sttrfin = 0;
                    }
                    else{
                        $qtystk = $temp->st_saldoakhir;
                        $avgstk = $temp->st_avgcost;
                        $sttrfin = $temp->st_trfin;
                    }

                    if($unit == 'KG'){
                        $nilai = ($qtystk * $avgstk / 1000) - ($rec->mstd_gross - $rec->mstd_discrph + $rec->mstd_ppnbmrph + $rec->mstd_ppnbtlrph);
                        $nilai2 = $nilai;
                    }
                    else{
                        $nilai = ($qtystk * $avgstk / 1) - ($rec->mstd_gross - $rec->mstd_discrph + $rec->mstd_ppnbmrph + $rec->mstd_ppnbtlrph);
                        $nilai2 = $nilai;
                    }

                    $qty = $qtystk - ($rec->mstd_qty + $rec->mstd_qtybonus1);

                    $temp = DB::connection($_SESSION['connection'])->table('tbtr_hapusplu')
                        ->where('del_kodeigr','=',$_SESSION['kdigr'])
                        ->where('del_rtype','=',$rec->mstd_typetrn)
                        ->where('del_nodokumen','=',$rec->mstd_nodoc)
                        ->where('del_prdcd','=',$rec->mstd_prdcd)
                        ->first();

                    if(!$temp){
                        if($unit == 'KG'){
                            if($qty <= 0){
                                $insqty = $nilai * 1000;
                            }
                            else{
                                $insqty = $nilai / $qty * 1000;
                            }

                            DB::connection($_SESSION['connection'])->table('tbtr_hapusplu')
                                ->insert([
                                    'del_kodeigr' => $_SESSION['kdigr'],
                                    'del_rtype' => $rec->mstd_typetrn,
                                    'del_nodokumen' => $rec->mstd_nodoc,
                                    'del_tgldokumen' => $rec->mstd_tgldoc,
                                    'del_prdcd' => $rec->mstd_prdcd,
                                    'del_avgcostnew' => $insqty,
                                    'del_avgcostold' => $avgstk,
                                    'del_stokqtyold' => $qtystk,
                                    'del_create_by' => $_SESSION['usid'],
                                    'del_create_dt' => DB::RAW("SYSDATE")
                                ]);
                        }
                        else{
                            if($qty <= 0){
                                $insqty = $nilai * 1;
                            }
                            else{
                                $insqty = $nilai / $qty * 1;
                            }

                            DB::connection($_SESSION['connection'])->table('tbtr_hapusplu')
                                ->insert([
                                    'del_kodeigr' => $_SESSION['kdigr'],
                                    'del_rtype' => $rec->mstd_typetrn,
                                    'del_nodokumen' => $rec->mstd_nodoc,
                                    'del_tgldokumen' => $rec->mstd_tgldoc,
                                    'del_prdcd' => $rec->mstd_prdcd,
                                    'del_avgcostnew' => $insqty,
                                    'del_avgcostold' => $avgstk,
                                    'del_stokqtyold' => $qtystk,
                                    'del_create_by' => $_SESSION['usid'],
                                    'del_create_dt' => DB::RAW("SYSDATE")
                                ]);
                        }
                    }

                    if($unit == 'KG'){
                        if($qty <= 0){
                            $insavg = $avgstk;
                        }
                        else{
                            $insavg = $nilai / $qty * 1000;
                        }

                        DB::connection($_SESSION['connection'])->table('tbmaster_stock')
                            ->where('st_kodeigr','=',$_SESSION['kdigr'])
                            ->where('st_prdcd','=',substr($rec->mstd_prdcd,0,6).'0')
                            ->where('st_lokasi','=','01')
                            ->update([
                                'st_avgcost' => $insavg,
                                'st_saldoakhir' => $qtystk - $rec->mstd_qty,
                                'st_trfin' => $sttrfin - $rec->mstd_qty
                            ]);
                    }
                    else{
                        if($qty <= 0){
                            $insavg = $avgstk;
                        }
                        else{
                            $insavg = $nilai / $qty * 1;
                        }

                        DB::connection($_SESSION['connection'])->table('tbmaster_stock')
                            ->where('st_kodeigr','=',$_SESSION['kdigr'])
                            ->where('st_prdcd','=',substr($rec->mstd_prdcd,0,6).'0')
                            ->where('st_lokasi','=','01')
                            ->update([
                                'st_avgcost' => $insavg,
                                'st_saldoakhir' => $qtystk - $rec->mstd_qty,
                                'st_trfin' => $sttrfin - $rec->mstd_qty
                            ]);
                    }

                    $prdcur = DB::connection($_SESSION['connection'])->table('tbmaster_prodmast')
                        ->select('prd_unit','prd_frac','prd_avgcost')
                        ->where('prd_prdcd','=',substr($rec->mstd_prdcd,0,6).'0')
                        ->where('prd_kodeigr','=',$_SESSION['kdigr'])
                        ->first();

                    $unit = $prdcur->prd_unit;
                    $frac = $prdcur->prd_frac;
                    $avgcost = $prdcur->prd_avgcost;

                    $lcostlama = 0;

                    $temp = DB::connection($_SESSION['connection'])->table('tbhistory_cost')
                        ->select('hcs_lastcostlama')
                        ->where('hcs_kodeigr','=',$_SESSION['kdigr'])
                        ->where('hcs_prdcd','=',$rec->mstd_prdcd)
                        ->where('hcs_nodocbpb','=',$rec->mstd_nopo)
                        ->first();

                    if($temp){
                        $lcostlama = $temp->hcs_lastcostlama;

                        if($unit == 'KG')
                            $lcostlama = $lcostlama / 1;
                        else $lcostlama = $lcostlama / $frac;
                    }

                    $recprds = DB::connection($_SESSION['connection'])->table('tbmaster_prodmast')
                        ->where('prd_kodeigr','=',$_SESSION['kdigr'])
                        ->whereRaw("substr(prd_prdcd,1,6) = substr('".$rec->mstd_prdcd."',1,6)")
                        ->get();

                    foreach($recprds as $recprd){
                        if($recprd->prd_unit == 'KG'){
                            if($qty <= 0){
                                $insavg = $avgstk;
                            }
                            else{
                                $insavg = $nilai / $qty * 1000;
                            }

                            if($lcostlama != 0){
                                DB::connection($_SESSION['connection'])->table('tbmaster_prodmast')
                                    ->where('prd_kodeigr','=',$_SESSION['kdigr'])
                                    ->whereRaw("substr(prd_prdcd,1,6) = substr('".$recprd->prd_prdcd."',1,6)")
                                    ->update([
                                        'prd_avgcost' => $insavg,
                                        'prd_lastcost' => $lcostlama
                                    ]);
                            }
                            else{
                                DB::connection($_SESSION['connection'])->table('tbmaster_prodmast')
                                    ->where('prd_kodeigr','=',$_SESSION['kdigr'])
                                    ->whereRaw("substr(prd_prdcd,1,6) = substr('".$recprd->prd_prdcd."',1,6)")
                                    ->update([
                                        'prd_avgcost' => $insavg
                                    ]);
                            }
                        }
                    }

                    if($temp){
                        $rec2s = DB::connection($_SESSION['connection'])->table('tbhistory_cost')
                            ->where('hcs_kodeigr','=',$_SESSION['kdigr'])
                            ->where('hcs_prdcd','=',$rec->mstd_prdcd)
                            ->where('hcs_nodocbpb','=',$rec->mstd_nopo)
                            ->get();

                        foreach($rec2s as $rec2){
                            DB::connection($_SESSION['connection'])->table('tbhistory_cost')
                                ->insert([
                                    'hcs_kodeigr' => $_SESSION['kdigr'],
                                    'hcs_recordid' => $rec2->hcs_recordid,
                                    'hcs_typetrn' => $rec2->hcs_typetrn,
                                    'hcs_lokasi' => $rec2->hcs_lokasi,
                                    'hcs_prdcd' => $rec2->hcs_prdcd,
                                    'hcs_tglbpb' => DB::RAW("SYSDATE"),
                                    'hcs_nodocbpb' => $rec2->hcs_nodocbpb,
                                    'hcs_qtybaru' => $qtystk - $rec2->hcs_qtylama,
                                    'hcs_qtylama' => $rec2->hcs_lastqty,
                                    'hcs_avglama' => $rec2->hcs_avglama,
                                    'hcs_avgbaru' => $rec2->hcs_avgbaru,
                                    'hcs_lastqty' => $rec2->hcs_qtylama,
                                    'hcs_lastcostbaru' => $rec2->hcs_lastcostbaru,
                                    'hcs_lastcostlama' => $rec2->hcs_lastcostlama,
                                    'hcs_create_by' => $_SESSION['usid'],
                                    'hcs_create_dt' => DB::RAW('SYSDATE')
                                ]);
                        }
                    }

                    DB::connection($_SESSION['connection'])->table('tbtr_mstran_d')
                        ->where('mstd_typetrn','=','I')
                        ->where('mstd_nodoc','=',$rec->mstd_nodoc)
                        ->where('mstd_kodeigr','=',$_SESSION['kdigr'])
                        ->update([
                            'mstd_recordid' => '1',
                            'mstd_modify_by' => $_SESSION['usid'],
                            'mstd_modify_dt' => DB::RAW('SYSDATE')
                        ]);

                    DB::connection($_SESSION['connection'])->table('tbtr_mstran_h')
                        ->where('msth_typetrn','=','I')
                        ->where('msth_nodoc','=',$rec->mstd_nodoc)
                        ->where('msth_kodeigr','=',$_SESSION['kdigr'])
                        ->update([
                            'msth_recordid' => '1',
                            'msth_modify_by' => $_SESSION['usid'],
                            'msth_modify_dt' => DB::RAW('SYSDATE')
                        ]);
                }
            }

            DB::commit();

            $status = 'success';
            $title = 'Data Surat Jalan Nomor '.$nosj.' sudah dibatalkan!';

            return compact(['status','title']);
        }
        catch (QueryException $e){
            DB::rollBack();

            $status = 'error';
            $title = 'Terjadi kesalahan!';

            return compact(['status','title']);
        }
    }
}
