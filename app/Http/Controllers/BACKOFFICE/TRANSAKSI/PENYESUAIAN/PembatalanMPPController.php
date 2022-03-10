<?php

namespace App\Http\Controllers\BACKOFFICE\TRANSAKSI\PENYESUAIAN;

use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller; use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;
use PDF;
use Yajra\DataTables\DataTables;

class PembatalanMPPController extends Controller
{
    public function index(){
        return view('BACKOFFICE.TRANSAKSI.PENYESUAIAN.pembatalan-mpp');
    }

    public function getDataLov(){
        $lov = DB::connection(Session::get('connection'))->table('tbtr_mstran_h')
            ->selectRaw("msth_nodoc, TO_CHAR(msth_tgldoc,'DD/MM/YYYY') msth_tgldoc")
            ->where('msth_kodeigr',Session::get('kdigr'))
            ->where('msth_typetrn','X')
            ->whereRaw("NVL(msth_recordid,'0') <> '1'")
            ->orderBy('msth_nodoc','desc')
            ->get();

        return DataTables::of($lov)->make(true);
    }

    public function getData(Request $request){
        $nompp = $request->nompp;

        $data = DB::connection(Session::get('connection'))->table('tbtr_mstran_h')
            ->join('tbtr_mstran_d','mstd_nodoc','=','msth_nodoc')
            ->join('tbmaster_prodmast','prd_prdcd','=','mstd_prdcd')
            ->selectRaw("mstd_tgldoc, mstd_nopo, mstd_tglpo, mstd_prdcd, prd_deskripsipanjang,
					prd_unit || '/' || prd_frac kemasan, mstd_qty, mstd_hrgsatuan, mstd_gross,
					msth_noref3, msth_tgref3, prd_frac")
            ->where('mstd_typetrn','X')
            ->where('msth_nodoc',$nompp)
            ->whereNull('msth_recordid')
            ->orderBy('mstd_prdcd')
            ->get();

        if(count($data) == 0){
            return response()->json([
                'message' => 'Nomor MPP salah!'
            ], 500);
        }

        return $data;
    }

    public function batal(Request $request){
        $nompp = $request->nompp;

        $cek = DB::connection(Session::get('connection'))->table('tbtr_mstran_h')
            ->selectRaw("to_char(msth_tgldoc, 'YYYYMM') tglmpp, to_char(sysdate, 'YYYYMM') now")
            ->where('msth_nodoc','=',$nompp)
            ->whereRaw("NVL(msth_recordid,0) <> '1'")
            ->where('msth_kodeigr',Session::get('kdigr'))
            ->first();

        if(!$cek){
            $status = 'error';
            $title = 'Gagal melakukan pembatalan MPP!';
            $message = 'Data MPP tidak ditemukan';

            return compact(['status','title','message']);
        }
        else{
            if($cek->tglmpp != $cek->now){
                $status = 'error';
                $title = 'Tidak dapat melakukan pembatalan MPP selain periode sekarang!';

                return compact(['status','title']);
            }
            else{
                try{
                    DB::connection(Session::get('connection'))->beginTransaction();

                    $v_plua1 = 0;
                    $v_plub1 = 0;
                    $step = 0;

                    if(true){
                        $jum = DB::connection(Session::get('connection'))->table('tbtr_mstran_d')
                            ->where('mstd_nodoc',$nompp)
                            ->where('mstd_kodeigr',Session::get('kdigr'))
                            ->where('mstd_typetrn','X')
                            ->get()->count();

                        if($jum == 2){
                            $fppm = DB::connection(Session::get('connection'))->table('tbtr_mstran_d')
                                ->where('mstd_nodoc',$nompp)
                                ->where('mstd_kodeigr',Session::get('kdigr'))
                                ->where('mstd_typetrn','X')
                                ->whereRaw("NVL(mstd_recordid,'0') <> '1'")
                                ->where('mstd_qty','<',0)
                                ->get()->count();

                            if($fppm != 2){
                                $fppm = DB::connection(Session::get('connection'))->table('tbtr_mstran_d')
                                    ->where('mstd_nodoc',$nompp)
                                    ->where('mstd_kodeigr',Session::get('kdigr'))
                                    ->where('mstd_typetrn','X')
                                    ->whereRaw("NVL(mstd_recordid,'0') <> '1'")
                                    ->where('mstd_qty','>',0)
                                    ->get()->count();
                            }

                            if($fppm == 2){
                                $ppmm = true;
                            }
                            else $ppmm = false;
                        }

                        if($jum == 1 || $jum > 2 || $ppmm){
                            $records = DB::connection(Session::get('connection'))->select("SELECT DISTINCT MSTD_NODOC, MSTD_PRDCD, MSTD_KODEIGR,
                                        MSTD_TGLDOC,MSTD_QTY, MSTD_UNIT, MSTD_FRAC, MSTD_AVGCOST, ST_AVGCOST,
                                        ST_SALDOAKHIR, MSTD_HRGSATUAN, PRD_AVGCOST,
                                        LPAD (MSTD_FLAGDISC2, 2, '0') AS LOKASI, MSTD_FLAGDISC1,
                                        MSTD_FLAGDISC2, MSTD_OCOST, MSTD_POSQTY
                                   FROM TBTR_MSTRAN_D, TBMASTER_PRODMAST, TBMASTER_STOCK
                                  WHERE MSTD_NODOC = '".$nompp."'
                                    AND MSTD_KODEIGR = '".Session::get('kdigr')."'
                                    AND MSTD_TYPETRN = 'X'
                                    AND PRD_PRDCD = MSTD_PRDCD
                                    AND PRD_KODEIGR = MSTD_KODEIGR
                                    AND ST_KODEIGR = PRD_KODEIGR
                                    AND ST_PRDCD = SUBSTR (PRD_PRDCD, 1, 6) || '0'
                                    AND ST_LOKASI = LPAD (MSTD_FLAGDISC2, 2, '0')");

                            foreach($records as $rec){
                                DB::connection(Session::get('connection'))->table('tbmaster_stock')
                                    ->where('st_prdcd',$rec->mstd_prdcd)
                                    ->where('st_lokasi',$rec->lokasi)
                                    ->where('st_kodeigr',Session::get('kdigr'))
                                    ->update([
                                        'st_saldoakhir' => DB::connection(Session::get('connection'))->raw('st_saldoakhir - '.$rec->mstd_qty),
                                        'st_adj' => DB::connection(Session::get('connection'))->raw("st_adj - ".$rec->mstd_qty),
                                        'st_modify_by' => Session::get('usid'),
                                        'st_modify_dt' => DB::connection(Session::get('connection'))->raw("TRUNC(SYSDATE)")
                                    ]);

                                $temp = DB::connection(Session::get('connection'))->table('tbtr_hapusplu')
                                    ->where('del_rtype','XXX')
                                    ->where('del_nodokumen',$nompp)
                                    ->where('del_prdcd',$rec->mstd_prdcd)
                                    ->get()->count();

                                if($temp == 0){
                                    DB::connection(Session::get('connection'))->table('tbtr_hapusplu')
                                        ->insert([
                                            'del_kodeigr' => Session::get('kdigr'),
                                            'del_rtype' => 'X',
                                            'del_nodokumen' => $rec->mstd_nodoc,
                                            'del_tgldokumen' => $rec->mstd_tgldoc,
                                            'del_flagtipe1' => $rec->mstd_flagdisc1,
                                            'del_flagtipe2' => $rec->mstd_flagdisc2,
                                            'del_avgcostnew' => $rec->st_avgcost,
                                            'del_stokqtyold' => $rec->st_saldoakhir,
                                            'del_create_dt' => DB::connection(Session::get('connection'))->raw("TRUNC(SYSDATE)"),
                                            'del_create_by' => Session::get('usid')
                                        ]);
                                }
                            }
                        }
                        else{
                            $data = DB::connection(Session::get('connection'))->table('tbtr_mstran_d')
                                ->select('mstd_prdcd','mstd_flagdisc2')
                                ->where('mstd_nodoc',$nompp)
                                ->where('mstd_kodeigr',Session::get('kdigr'))
                                ->where('mstd_typetrn','X')
                                ->where('mstd_qty','<',0)
                                ->distinct()
                                ->first();

                            if($data){
                                $prdcda = $data->mstd_prdcd;
                                $v_lok1 = $data->mstd_flagdisc2;
                            }

                            $data = DB::connection(Session::get('connection'))->table('tbtr_mstran_d')
                                ->select('mstd_prdcd','mstd_flagdisc2')
                                ->where('mstd_nodoc',$nompp)
                                ->where('mstd_kodeigr',Session::get('kdigr'))
                                ->where('mstd_typetrn','X')
                                ->where('mstd_qty','>',0)
                                ->distinct()
                                ->first();

                            if($data){
                                $prdcdb = $data->mstd_prdcd;
                                $v_lok2 = $data->mstd_flagdisc2;
                            }

                            $records = DB::connection(Session::get('connection'))->select("SELECT DISTINCT MSTD_NODOC, MSTD_PRDCD, MSTD_KODEIGR,
                                        MSTD_TGLDOC, MSTD_QTY,MSTD_UNIT, MSTD_FRAC, MSTD_AVGCOST, ST_AVGCOST,
                                        ST_SALDOAKHIR, MSTD_HRGSATUAN, PRD_AVGCOST,
                                        LPAD (MSTD_FLAGDISC2, 2, '0') AS LOKASI, MSTD_FLAGDISC1,
                                        MSTD_FLAGDISC2, MSTD_OCOST, MSTD_POSQTY
                                   FROM TBTR_MSTRAN_D, TBMASTER_PRODMAST, TBMASTER_STOCK
                                  WHERE MSTD_NODOC = '".$nompp."'
                                    AND MSTD_KODEIGR = '".Session::get('kdigr')."'
                                    AND MSTD_TYPETRN = 'X'
                                    AND PRD_PRDCD = MSTD_PRDCD
                                    AND PRD_KODEIGR = MSTD_KODEIGR
                                    AND ST_KODEIGR = PRD_KODEIGR
                                    AND ST_PRDCD = SUBSTR (PRD_PRDCD, 1, 6) || '0'
                                    AND ST_LOKASI = LPAD (MSTD_FLAGDISC2, 2, '0')");

                            foreach($records as $rec){
                                $temp = DB::connection(Session::get('connection'))->table('tbmaster_stock')
                                    ->where('st_prdcd',substr($rec->mstd_prdcd,0,6).'0')
                                    ->where('st_kodeigr',$rec->mstd_kodeigr)
                                    ->where('st_lokasi',$rec->lokasi)
                                    ->get()->count();

                                $step = 1;

                                if($temp == 0){
                                    DB::connection(Session::get('connection'))->table('tbmaster_stock')
                                        ->insert([
                                            'st_kodeigr' => $rec->mstd_kodeigr,
                                            'st_prdcd' => substr($rec->mstd_prdcd,0,6).'0',
                                            'st_lokasi' => $rec->lokasi
                                        ]);
                                }

                                $step = 5;

                                $temp = DB::connection(Session::get('connection'))->table('tbtr_hapusplu')
                                    ->where('del_rtype','X')
                                    ->where('del_nodokumen',$nompp)
                                    ->where('del_prdcd',$rec->mstd_prdcd)
                                    ->get()->count();

                                if($temp == 0){
                                    $step = 6;

                                    DB::connection(Session::get('connection'))->table('tbtr_hapusplu')
                                        ->insert([
                                            'del_kodeigr' => Session::get('kdigr'),
                                            'del_rtype' => 'X',
                                            'del_nodokumen' => $rec->mstd_nodoc,
                                            'del_tgldokumen' => $rec->mstd_tgldoc,
                                            'del_flagtipe1' => $rec->mstd_flagdisc1,
                                            'del_flagtipe2' => $rec->mstd_flagdisc2,
                                            'del_avgcostnew' => $rec->st_avgcost,
                                            'del_stokqtyold' => $rec->st_saldoakhir,
                                            'del_create_dt' => DB::connection(Session::get('connection'))->raw("TRUNC(SYSDATE)"),
                                            'del_create_by' => Session::get('usid')
                                        ]);
                                }

                                $step = 7;
                                $nqtt = $rec->mstd_qty;

                                if($rec->mstd_unit == 'KG'){
                                    $ncost = $rec->mstd_hrgsatuan;
                                }
                                else $ncost = $rec->mstd_hrgsatuan / $rec->mstd_frac;

                                $step = 10;

                                $jum = DB::connection(Session::get('connection'))->table('tbmaster_prodmast')
                                    ->select('prd_avgcost')
                                    ->where('prd_prdcd',substr($rec->mstd_prdcd,0,6).'1')
                                    ->where('prd_kodeigr',$rec->mstd_kodeigr)
                                    ->first();

                                if($jum){
                                    $temp = $jum->prd_avgcost;
                                }
                                else $temp = 0;

                                $step = 14;

                                DB::connection(Session::get('connection'))->table('tbmaster_stock')
                                    ->where('st_prdcd',$rec->mstd_prdcd)
                                    ->where('st_lokasi',$rec->lokasi)
                                    ->where('st_kodeigr',Session::get('kdigr'))
                                    ->update([
                                        'st_saldoakhir' => DB::connection(Session::get('connection'))->raw("st_saldoakhir - ".$rec->mstd_qty),
                                        'st_adj' => DB::connection(Session::get('connection'))->raw("st_adj - ".$rec->mstd_qty),
                                        'st_modify_by' => Session::get('usid'),
                                        'st_modify_dt' => DB::connection(Session::get('connection'))->raw("TRUNC(SYSDATE)")
                                    ]);

                                $step = 22;

                                if($rec->mstd_flagdisc1 == '3'){
                                    if($rec->mstd_qty > 0){
                                        if($prdcda != null){
                                            $step = 23;

                                            $data = DB::connection(Session::get('connection'))->table('tbmaster_stock')
                                                ->where('st_prdcd',$prdcda)
                                                ->where('st_kodeigr',Session::get('kdigr'))
                                                ->where('st_lokasi','01')
                                                ->first();

                                            if($data)
                                                $v_plua1 = $data->st_saldoakhir;

                                            $data = DB::connection(Session::get('connection'))->table('tbmaster_stock')
                                                ->where('st_prdcd',$rec->mstd_prdcd)
                                                ->where('st_kodeigr',Session::get('kdigr'))
                                                ->where('st_lokasi','01')
                                                ->first();

                                            if($data)
                                                $v_plub1 = $data->st_saldoakhir;

                                            $step = 25;

                                            DB::connection(Session::get('connection'))->table('tbtr_promomd')
                                                ->where('prmd_prdcd',substr($rec->mstd_prdcd,0,6).'0')
                                                ->where('prmd_kodeigr',Session::get('kdigr'))
                                                ->update([
                                                    'prmd_prdcd' => substr($prdcda,0,6).'0',
                                                    'prmd_modify_by' => Session::get('usid'),
                                                    'prmd_modify_dt' => Carbon::now()
                                                ]);

                                            DB::connection(Session::get('connection'))->table('tbtr_promomd')
                                                ->where('prmd_prdcd',substr($rec->mstd_prdcd,0,6).'1')
                                                ->where('prmd_kodeigr',Session::get('kdigr'))
                                                ->update([
                                                    'prmd_prdcd' => substr($prdcda,0,6).'1',
                                                    'prmd_modify_by' => Session::get('usid'),
                                                    'prmd_modify_dt' => Carbon::now()
                                                ]);

                                            DB::connection(Session::get('connection'))->table('tbtr_promomd')
                                                ->where('prmd_prdcd',substr($rec->mstd_prdcd,0,6).'2')
                                                ->where('prmd_kodeigr',Session::get('kdigr'))
                                                ->update([
                                                    'prmd_prdcd' => substr($prdcda,0,6).'2',
                                                    'prmd_modify_by' => Session::get('usid'),
                                                    'prmd_modify_dt' => Carbon::now()
                                                ]);

                                            DB::connection(Session::get('connection'))->table('tbtr_promomd')
                                                ->where('prmd_prdcd',substr($rec->mstd_prdcd,0,6).'3')
                                                ->where('prmd_kodeigr',Session::get('kdigr'))
                                                ->update([
                                                    'prmd_prdcd' => substr($prdcda,0,6).'3',
                                                    'prmd_modify_by' => Session::get('usid'),
                                                    'prmd_modify_dt' => Carbon::now()
                                                ]);

                                            $step = 39;

                                            $temp = DB::connection(Session::get('connection'))->table('tbmaster_lokasi')
                                                ->where('lks_prdcd',substr($rec->mstd_prdcd,0,6).'0')
                                                ->where('lks_kodeigr',Session::get('kdigr'))
                                                ->get()->count();

                                            if($temp > 0){
                                                $step = 40;

                                                DB::connection(Session::get('connection'))->table('tbmaster_lokasi')
                                                    ->where('lks_prdcd',substr($rec->mstd_prdcd,0,6).'0')
                                                    ->where('lks_kodeigr',Session::get('kdigr'))
                                                    ->update([
                                                        'lks_prdcd' => $prdcda,
                                                        'lks_modify_by' => Session::get('usid'),
                                                        'lks_modify_dt' => Carbon::now()
                                                    ]);

                                                $step = 41;

                                                $data = DB::connection(Session::get('connection'))->table('temp_tbmaster_lokasi')
                                                    ->where('lks_prdcd',substr($rec->mstd_prdcd,0,6).'0')
                                                    ->where('lks_kodeigr',Session::get('kdigr'))
                                                    ->where('lks_nodoc',$rec->mstd_nodoc)
                                                    ->first();

                                                DB::connection(Session::get('connection'))->table('tbmaster_lokasi')
                                                    ->insert($data);

                                                $step = 42;

                                                DB::connection(Session::get('connection'))->table('temp_tbmaster_lokasi')
                                                    ->where('lks_prdcd',substr($rec->mstd_prdcd,0,6).'0')
                                                    ->where('lks_kodeigr',Session::get('kdigr'))
                                                    ->where('lks_nodoc',$rec->mstd_nodoc)
                                                    ->delete();

                                                if($v_plua1 > 0 && $v_plub1 > 0){
                                                    DB::connection(Session::get('connection'))->table('tbmaster_lokasi')
                                                        ->where('lks_prdcd',substr($rec->mstd_prdcd,0,6).'0')
                                                        ->where('lks_kodeigr',Session::get('kdigr'))
                                                        ->delete();

                                                    $step = 43;

                                                    $data = DB::connection(Session::get('connection'))->table('temp_tbmaster_lokasi')
                                                        ->where('lks_prdcd',substr($rec->mstd_prdcd,0,6).'0')
                                                        ->where('lks_kodeigr',Session::get('kdigr'))
                                                        ->where('lks_nodoc',$rec->mstd_nodoc)
                                                        ->first();

                                                    DB::connection(Session::get('connection'))->table('tbmaster_lokasi')
                                                        ->insert($data);

                                                    $data = DB::connection(Session::get('connection'))->table('temp_tbmaster_lokasi')
                                                        ->where('lks_prdcd',substr($rec->mstd_prdcd,0,6).'0')
                                                        ->where('lks_kodeigr',Session::get('kdigr'))
                                                        ->where('lks_nodoc',$rec->mstd_nodoc)
                                                        ->delete();
                                                }
                                            }

                                            $step = 45;

                                            $temp = DB::connection(Session::get('connection'))->table('tbhistory_barangbaru')
                                                ->where('hpn_prdcd',substr($rec->mstd_prdcd,0,6).'0')
                                                ->where('hpn_kodeigr',Session::get('kdigr'))
                                                ->get()->count();

                                            if($temp > 0){
                                                $step = 47;

                                                $temp = DB::connection(Session::get('connection'))->table('tbmaster_barangbaru')
                                                    ->where('pln_prdcd',substr($rec->mstd_prdcd,0,6).'0')
                                                    ->where('pln_kodeigr',Session::get('kdigr'))
                                                    ->get()->count();

                                                if($temp == 0){
                                                    $step = 48;

                                                    $pkmt = DB::connection(Session::get('connection'))->table('tbhistory_barangbaru')
                                                        ->select('hpn_pkmtoko')
                                                        ->where('pln_prdcd',substr($rec->mstd_prdcd,0,6).'0')
                                                        ->where('pln_kodeigr',Session::get('kdigr'))
                                                        ->first();

                                                    $step = 49;

                                                    $tag = DB::connection(Session::get('connection'))->table('tbmaster_prodmast')
                                                        ->select('prd_kodetag')
                                                        ->where('pln_prdcd',substr($rec->mstd_prdcd,0,6).'0')
                                                        ->where('pln_kodeigr',Session::get('kdigr'))
                                                        ->first();

                                                    $step = 50;

                                                    DB::connection(Session::get('connection'))->table('tbmaster_barangbaru')
                                                        ->insert([
                                                            'pln_kodeigr' => Session::get('kdigr'),
                                                            'pln_prdcd' => substr($rec->mstd_prdcd,0,6).'0',
                                                            'pln_pkmt' => $pkmt,
                                                            'pln_flagtag' => $tag,
                                                            'pln_create_by' => Session::get('usid'),
                                                            'pln_create_dt' => Carbon::now()
                                                        ]);
                                                }

                                                $step = 51;

                                                DB::connection(Session::get('connection'))->table('tbhistory_barangbaru')
                                                    ->where('hpn_prdcd',substr($rec->mstd_prdcd,0,6).'0')
                                                    ->where('hpn_kodeigr',Session::get('kdigr'))
                                                    ->delete();
                                            }

                                            $step = 52;

                                            $temp = DB::connection(Session::get('connection'))->table('tbmaster_kkpkm')
                                                ->where('pkm_prdcd',substr($rec->mstd_prdcd,0,6).'0')
                                                ->where('pkm_kodeigr',Session::get('kdigr'))
                                                ->get()->count();

                                            if($temp > 0){
                                                $step = 54;

                                                DB::connection(Session::get('connection'))->table('tbmaster_kkpkm')
                                                    ->where('pkm_prdcd',substr($rec->mstd_prdcd,0,6).'0')
                                                    ->where('pkm_kodeigr',Session::get('kdigr'))
                                                    ->update([
                                                        'pkm_prdcd' => $prdcda,
                                                        'pkm_modify_by' => Session::get('usid'),
                                                        'pkm_modify_dt' => Carbon::now()
                                                    ]);

                                                $step = 55;

                                                $data = DB::connection(Session::get('connection'))->table('temp_tbmaster_kkpkm')
                                                    ->where('pkm_prdcd',substr($rec->mstd_prdcd,0,6).'0')
                                                    ->where('pkm_kodeigr',Session::get('kdigr'))
                                                    ->where('pkm_nodoc',$rec->mstd_nodoc)
                                                    ->first()->toArray();

                                                DB::connection(Session::get('connection'))->table('tbmaster_kkpkm')
                                                    ->insert($data);

                                                $step = 56;

                                                DB::connection(Session::get('connection'))->table('temp_tbmaster_kkpkm')
                                                    ->where('pkm_prdcd',substr($rec->mstd_prdcd,0,6).'0')
                                                    ->where('pkm_kodeigr',Session::get('kdigr'))
                                                    ->where('pkm_nodoc',$rec->mstd_nodoc)
                                                    ->delete();

                                                if($v_plua1 > 0 && $v_plub1 > 0){
                                                    DB::connection(Session::get('connection'))->table('tbmaster_kkpkm')
                                                        ->where('pkm_prdcd',substr($prdcda,0,6).'0')
                                                        ->where('pkm_kodeigr',Session::get('kdigr'))
                                                        ->delete();

                                                    $step = 57;

                                                    $data = DB::connection(Session::get('connection'))->table('temp_tbmaster_kkpkm')
                                                        ->where('pkm_prdcd',substr($rec->mstd_prdcd,0,6).'0')
                                                        ->where('pkm_kodeigr',Session::get('kdigr'))
                                                        ->where('pkm_nodoc',$rec->mstd_nodoc)
                                                        ->first()->toArray();

                                                    DB::connection(Session::get('connection'))->table('tbmaster_kkpkm')
                                                        ->insert($data);

                                                    $step = 58;

                                                    DB::connection(Session::get('connection'))->table('temp_tbmaster_kkpkm')
                                                        ->where('pkm_prdcd',substr($rec->mstd_prdcd,0,6).'0')
                                                        ->where('pkm_kodeigr',Session::get('kdigr'))
                                                        ->where('pkm_nodoc',$rec->mstd_nodoc)
                                                        ->delete();
                                                }

                                                $step = 59;

                                                DB::connection(Session::get('connection'))->table('tbtr_pkmgondola')
                                                    ->where('pkmg_prdcd',substr($rec->mstd_prdcd,0,6).'0')
                                                    ->where('pkmg_kodeigr',Session::get('kdigr'))
                                                    ->update([
                                                        'pkmg_prdcd' => $prdcda,
                                                        'pkmg_modify_by' => Session::get('usid'),
                                                        'pkmg_modify_dt' => Carbon::now()
                                                    ]);

                                                $step = 60;

                                                $data = DB::connection(Session::get('connection'))->table('temp_tbtr_pkmgondola')
                                                    ->where('pkmg_prdcd',substr($rec->mstd_prdcd,0,6).'0')
                                                    ->where('pkmg_kodeigr',Session::get('kdigr'))
                                                    ->where('pkmg_nodoc',$rec->mstd_nodoc)
                                                    ->first()->toArray();

                                                DB::connection(Session::get('connection'))->table('tbtr_pkmgondola')
                                                    ->insert($data);

                                                $step = 61;

                                                DB::connection(Session::get('connection'))->table('temp_tbtr_pkmgondola')
                                                    ->where('pkmg_prdcd',substr($rec->mstd_prdcd,0,6).'0')
                                                    ->where('pkmg_kodeigr',Session::get('kdigr'))
                                                    ->where('pkmg_nodoc',$rec->mstd_nodoc)
                                                    ->delete();

                                                $step = 62;

                                                if($v_plua1 > 0 && $v_plub1 > 0){
                                                    DB::connection(Session::get('connection'))->table('tbtr_pkmgondola')
                                                        ->where('pkmg_prdcd',substr($prdcda,0,6).'0')
                                                        ->where('pkmg_kodeigr',Session::get('kdigr'))
                                                        ->delete();

                                                    $step = 63;

                                                    $data = DB::connection(Session::get('connection'))->table('temp_tbtr_pkmgondola')
                                                        ->where('pkmg_prdcd',substr($prdcda,0,6).'0')
                                                        ->where('pkmg_kodeigr',Session::get('kdigr'))
                                                        ->where('pkmg_nodoc',$rec->mstd_nodoc)
                                                        ->first()->toArray();

                                                    DB::connection(Session::get('connection'))->table('tbtr_pkmgondola')
                                                        ->insert($data);

                                                    $step = 64;

                                                    DB::connection(Session::get('connection'))->table('temp_tbtr_pkmgondola')
                                                        ->where('pkmg_prdcd',substr($prdcda,0,6).'0')
                                                        ->where('pkmg_kodeigr',Session::get('kdigr'))
                                                        ->where('pkmg_nodoc',$rec->mstd_nodoc)
                                                        ->delete();
                                                }

                                                $step = 65;

                                                $data = DB::connection(Session::get('connection'))->table('temp_tbmaster_pkmplus')
                                                    ->where('pkm_prdcd',substr($rec->mstd_prdcd,0,6).'0')
                                                    ->where('pkmp_kodeigr',Session::get('kdigr'))
                                                    ->where('pkmp_nodoc',$rec->mstd_nodoc)
                                                    ->first()->toArray();

                                                DB::connection(Session::get('connection'))->table('tbmaster_pkmplus')
                                                    ->insert($data);

                                                $step = 67;

                                                DB::connection(Session::get('connection'))->table('temp_tbmaster_pkmplus')
                                                    ->where('pkm_prdcd',substr($rec->mstd_prdcd,0,6).'0')
                                                    ->where('pkmp_kodeigr',Session::get('kdigr'))
                                                    ->where('pkmp_nodoc',$rec->mstd_nodoc)
                                                    ->delete();

                                                $step = 68;

                                                if($v_plua1 > 0 && $v_plub1 > 0){
                                                    DB::connection(Session::get('connection'))->table('tbmaster_pkmplus')
                                                        ->where('pkmp_prdcd',substr($prdcda,0,6).'0')
                                                        ->where('pkmp_kodeigr',Session::get('kdigr'))
                                                        ->delete();

                                                    $step = 69;

                                                    $data = DB::connection(Session::get('connection'))->table('temp_tbmaster_pkmplus')
                                                        ->where('pkm_prdcd',substr($prdcda,0,6).'0')
                                                        ->where('pkmp_kodeigr',Session::get('kdigr'))
                                                        ->where('pkmp_nodoc',$rec->mstd_nodoc)
                                                        ->first()->toArray();

                                                    DB::connection(Session::get('connection'))->table('tbmaster_pkmplus')
                                                        ->insert($data);

                                                    $step = 70;

                                                    DB::connection(Session::get('connection'))->table('temp_tbmaster_pkmplus')
                                                        ->where('pkm_prdcd',substr($prdcda,0,6).'0')
                                                        ->where('pkmp_kodeigr',Session::get('kdigr'))
                                                        ->where('pkmp_nodoc',$rec->mstd_nodoc)
                                                        ->delete();
                                                }

                                                $step = 71;

                                                DB::connection(Session::get('connection'))->table('tbtr_gondola')
                                                    ->where('gdl_prdcd',substr($rec->mstd_prdcd,0,6).'0')
                                                    ->where('gdl_kodeigr',Session::get('kdigr'))
                                                    ->update([
                                                        'gdl_prdcd' => $prdcda,
                                                        'gdl_modify_by' => Session::get('usid'),
                                                        'gdl_modify_dt' => Carbon::now()
                                                    ]);

                                                $step = 72;

                                                $data = DB::connection(Session::get('connection'))->table('temp_tbtr_gondola')
                                                    ->where('gdl_prdcd',substr($rec->mstd_prdcd,0,6).'0')
                                                    ->where('gdl_kodeigr',Session::get('kdigr'))
                                                    ->where('gdl_nodoc',$rec->mstd_nodoc)
                                                    ->first()->toArray();

                                                DB::connection(Session::get('connection'))->table('tbtr_gondola')
                                                    ->insert($data);

                                                DB::connection(Session::get('connection'))->table('temp_tbtr_gondola')
                                                    ->where('gdl_prdcd',substr($rec->mstd_prdcd,0,6).'0')
                                                    ->where('gdl_kodeigr',Session::get('kdigr'))
                                                    ->where('gdl_nodoc',$rec->mstd_nodoc)
                                                    ->delete();

                                                $step = 73;

                                                if($v_plua1 > 0 && $v_plub1 > 0){
                                                    DB::connection(Session::get('connection'))->table('tbtr_gondola')
                                                        ->where('gdl_prdcd',substr($prdcda,0,6).'0')
                                                        ->where('gdl_kodeigr',Session::get('kdigr'))
                                                        ->delete();

                                                    $step = 74;

                                                    $data = DB::connection(Session::get('connection'))->table('temp_tbtr_gondola')
                                                        ->where('gdl_prdcd',substr($prdcda,0,6).'0')
                                                        ->where('gdl_kodeigr',Session::get('kdigr'))
                                                        ->where('gdl_nodoc',$rec->mstd_nodoc)
                                                        ->first()->toArray();

                                                    DB::connection(Session::get('connection'))->table('tbtr_gondola')
                                                        ->insert($data);

                                                    $step = 75;

                                                    DB::connection(Session::get('connection'))->table('temp_tbtr_gondola')
                                                        ->where('gdl_prdcd',substr($prdcda,0,6).'0')
                                                        ->where('gdl_kodeigr',Session::get('kdigr'))
                                                        ->where('gdl_nodoc',$rec->mstd_nodoc)
                                                        ->delete();
                                                }

                                                $step = 76;

                                                DB::connection(Session::get('connection'))->table('tbmaster_minimumorder')
                                                    ->where('min_prdcd',substr($rec->mstd_prdcd,0,6).'0')
                                                    ->where('min_Kodeigr',Session::get('kdigr'))
                                                    ->update([
                                                        'min_prdcd' => $prdcda,
                                                        'min_modify_by' => Session::get('usid'),
                                                        'min_modify_dt' => Carbon::now()
                                                    ]);

                                                $step = 77;

                                                $data = DB::connection(Session::get('connection'))->table('temp_tbmaster_minimumorder')
                                                    ->where('min_prdcd',substr($rec->mstd_prdcd,0,6).'0')
                                                    ->where('min_kodeigr',Session::get('kdigr'))
                                                    ->where('min_nodoc',$rec->mstd_nodoc)
                                                    ->first()->toArray();

                                                DB::connection(Session::get('connection'))->table('tbmaster_minimumorder')
                                                    ->insert($data);

                                                $step = 78;

                                                DB::connection(Session::get('connection'))->table('temp_tbmaster_minimumorder')
                                                    ->where('min_prdcd',substr($rec->mstd_prdcd,0,6).'0')
                                                    ->where('min_kodeigr',Session::get('kdigr'))
                                                    ->where('min_nodoc',$rec->mstd_nodoc)
                                                    ->delete();

                                                $step = 79;

                                                if($v_plua1 > 0 && $v_plub1 > 0){
                                                    DB::connection(Session::get('connection'))->table('tbmaster_minimumorder')
                                                        ->where('min_prdcd',substr($prdcda,0,6).'0')
                                                        ->where('min_Kodeigr',Session::get('kdigr'))
                                                        ->delete();

                                                    $step = 80;

                                                    $data = DB::connection(Session::get('connection'))->table('temp_tbmaster_minimumorder')
                                                        ->where('min_prdcd',substr($prdcda,0,6).'0')
                                                        ->where('min_kodeigr',Session::get('kdigr'))
                                                        ->where('min_nodoc',$rec->mstd_nodoc)
                                                        ->first()->toArray();

                                                    DB::connection(Session::get('connection'))->table('tbmaster_minimumorder')
                                                        ->insert($data);

                                                    $step = 81;

                                                    DB::connection(Session::get('connection'))->table('temp_tbmaster_minimumorder')
                                                        ->where('min_prdcd',substr($prdcda,0,6).'0')
                                                        ->where('min_kodeigr',Session::get('kdigr'))
                                                        ->where('min_nodoc',$rec->mstd_nodoc)
                                                        ->delete();
                                                }

                                                $step = 82;

                                                DB::connection(Session::get('connection'))->table('tbtr_konversiplu')
                                                    ->where('kvp_pluold',$prdcda)
                                                    ->where('kvp_plunew',substr($rec->mstd_prdcd,0,6).'0')
                                                    ->where('kvp_kodeigr',Session::get('kdigr'))
                                                    ->delete();
                                            }
                                        }
                                    }
                                    else{
                                        $step = 84;

                                        $temp = DB::connection(Session::get('connection'))->table('tbhistory_barangbaru')
                                            ->where('hpn_prdcd',$prdcda)
                                            ->where('hpn_kodeigr',Session::get('kdigr'))
                                            ->get()->count();

                                        if($temp > 0){
                                            $step = 85;

                                            $temp = DB::connection(Session::get('connection'))->table('tbmaster_barangbaru')
                                                ->where('pln_prdcd',$prdcda)
                                                ->where('pln_kodeigr',Session::get('kdigr'))
                                                ->get()->count();

                                            if($temp == 0){
                                                $step = 86;

                                                $data = DB::connection(Session::get('connection'))->table('tbhistory_barangbaru')
                                                    ->select('hpn_pkmtoko')
                                                    ->where('hpn_prdcd',$prdcda)
                                                    ->where('hpn_kodeigr',Session::get('kdigr'))
                                                    ->first();

                                                if($data)
                                                    $pkmt = $data->hpn_pkmtoko;

                                                $data = DB::connection(Session::get('connection'))->table('tbmaster_prodmast')
                                                    ->select('prd_kodetag')
                                                    ->where('prd_prdcd',$prdcda)
                                                    ->where('prd_kodeigr',Session::get('kdigr'))
                                                    ->first();

                                                if($data)
                                                    $tag = $data->prd_kodetag;

                                                DB::connection(Session::get('connection'))->table('tbmaster_barangbaru')
                                                    ->insert([
                                                        'pln_kodeigr' => Session::get('kdigr'),
                                                        'pln_prdcd' => $prdcda,
                                                        'pln_pkmt' => $pkmt,
                                                        'pln_flagtag' => $tag,
                                                        'pln_create_by' => Session::get('usid'),
                                                        'pln_create_dt' => Carbon::now()
                                                    ]);
                                            }

                                            $step = 87;

                                            DB::connection(Session::get('connection'))->table('tbhistory_barangbaru')
                                                ->where('hpn_prdcd',$prdcda)
                                                ->where('hpn_kodeigr',Session::get('kdigr'))
                                                ->delete();

                                            $step = 88;
                                        }
                                    }
                                }
                            }
                        }

                        $step = 93;

                        DB::connection(Session::get('connection'))->table('tbtr_mstran_h')
                            ->where('msth_nodoc',$nompp)
                            ->where('msth_kodeigr',Session::get('kdigr'))
                            ->where('msth_typetrn','X')
                            ->update([
                                'msth_recordid' => 1,
                                'msth_modify_by' => Session::get('usid'),
                                'msth_modify_dt' => Carbon::now()
                            ]);

                        $step = 94;

                        DB::connection(Session::get('connection'))->table('tbtr_mstran_d')
                            ->where('mstd_nodoc',$nompp)
                            ->where('mstd_kodeigr',Session::get('kdigr'))
                            ->where('mstd_typetrn','X')
                            ->update([
                                'mstd_recordid' => 1,
                                'mstd_modify_by' => Session::get('usid'),
                                'mstd_modify_dt' => Carbon::now()
                            ]);

                        DB::connection(Session::get('connection'))->commit();

                        $status = 'success';
                        $title = 'Berhasil melakukan pembatalan MPP!';

                        return compact(['status','title']);
                    }
                }
                catch(QueryException $e){
                    DB::connection(Session::get('connection'))->rollBack();

                    $status = 'error';
                    $title = 'Gagal melakukan pembatalan MPP!';
                    $message = $e->getMessage();

                    return compact(['status','title','message']);
                }
            }
        }
    }
}
