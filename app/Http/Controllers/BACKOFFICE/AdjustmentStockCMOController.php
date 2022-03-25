<?php

namespace App\Http\Controllers\BACKOFFICE;

use App\Http\Controllers\Auth\loginController;
use App\Mail\Email;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;
use PDF;
use Symfony\Component\VarDumper\Cloner\Data;
use Yajra\DataTables\DataTables;

class AdjustmentStockCMOController extends Controller
{
    public function index(){
        return view('BACKOFFICE.adjustment-stock-cmo');
    }

    public function getDataLovBA(){
        $data = DB::connection(Session::get('connection'))
            ->table('tbtr_ba_cmo')
            ->selectRaw("bac_noba noba, bac_tglba, to_char(bac_tglba,'dd/mm/yyyy') tglba,
                to_char(bac_tgladj, 'dd/mm/yyyy') tgladj, bac_modify_by useradj")
            ->whereRaw("nvl(bac_recordid,'0') <> '1'")
            ->orderBy('bac_tglba','desc')
            ->orderBy('bac_noba','desc')
            ->distinct()
            ->get();

        return DataTables::of($data)->make(true);
    }

    public function getDataLovPLU(){
        $data = DB::connection(Session::get('connection'))
            ->select(" select distinct icm_pluigr, prc_pluidm, prd_deskripsipanjang , prd_unit || '-' || prd_frac unit
                 from tbmaster_item_cmo, tbmaster_prodcrm, tbmaster_prodmast
                 where prc_pluigr = icm_pluigr and prc_group = 'I' and prd_prdcd = icm_pluigr
                 order by icm_pluigr");

        return DataTables::of($data)->make(true);
    }

    public function checkPLU(Request $request){
        $plu = substr('0000000'.$request->plu,-7);

        if(substr($plu,-1) != '0')
            $plu = substr($plu,0,6).'0';

        $temp = DB::connection(Session::get('connection'))
            ->table('tbmaster_item_cmo')
            ->where('icm_pluigr','=',$plu)
            ->first();

        if(!$temp){
            return response()->json([
                'message' => 'Data Item CMO tidak ada!'
            ], 500);
        }

        $temp = DB::connection(Session::get('connection'))
            ->table('tbmaster_prodmast')
            ->where('prd_prdcd','=',$plu)
            ->first();

        if(!$temp){
            return response()->json([
                'message' => 'Data Master Produk CMO tidak ada!'
            ], 500);
        }
        else{
            $prd_deskripsipanjang = $temp->prd_deskripsipanjang;
            $unit = $temp->prd_unit .'-'. $temp->prd_frac;
        }

        $temp = DB::connection(Session::get('connection'))
            ->table('tbmaster_prodcrm')
            ->where('prc_pluigr','=',$plu)
            ->where('prc_group','=','I')
            ->first();

        if(!$temp){
            return response()->json([
                'message' => 'Data Master Produk 2 CMO tidak ada!'
            ], 500);
        }
        else $pluidm = $temp->prc_pluidm;

        $temp = DB::connection(Session::get('connection'))
            ->table('tbmaster_stock_cab_anak')
            ->where('sta_lokasi','=','01')
            ->where('sta_prdcd','=',$plu)
            ->first();

        if(!$temp){
            return response()->json([
                'message' => 'Data Transaksi Stock CMO tidak ada!'
            ], 500);
        }
        else $qty = $temp->sta_saldoakhir;

        return response()->json(compact(['plu','prd_deskripsipanjang','unit','pluidm','qty']),200);
    }

    public function getDataBA(Request $request){
        $header = DB::connection(Session::get('connection'))
            ->table('tbtr_ba_cmo')
            ->selectRaw("bac_noba noba, to_char(bac_tglba,'dd/mm/yyyy') tglba,
                to_char(bac_tgladj, 'dd/mm/yyyy') tgladj, bac_modify_by useradj, bac_recordid status")
            ->whereRaw("nvl(bac_recordid,'0') <> '1'")
            ->where('bac_noba','=',$request->noba)
            ->first();

        if(!$header){
            return response()->json([
                'message' => 'Data BA CMO tidak ada!'
            ], 500);
        }

        $detail = DB::connection(Session::get('connection'))
            ->select("SELECT bac_recordid,
                         bac_prdcd,
                         prc_pluidm,
                         bac_keterangan,
                         prd_deskripsipanjang,
                         prd_unit || '-' || prd_frac unit,
                         bac_qty_stock,
                         bac_qty_ba,
                         bac_qty_adj
                    FROM tbtr_ba_cmo, tbmaster_prodmast, tbmaster_prodcrm
                   WHERE     bac_noba = '".$request->noba."'
                         AND NVL (bac_recordid, '0') <> '1'
                         AND prd_prdcd = bac_prdcd
                         AND prc_pluigr = prd_prdcd and prc_group = 'I'
                ORDER BY bac_prdcd");

        return response()->json(compact(['header','detail']), 200);
    }

    public function getNewNoBA(){
        $connect = loginController::getConnectionProcedure();

        $query = oci_parse($connect, "BEGIN :ret := f_igr_get_nomor('" . Session::get('kdigr') . "','BAC','Nomor BA CMO','CO' || to_char(sysdate,'yyMM'),4,true); END;");
        oci_bind_by_name($query, ':ret', $noba, 32);
        oci_execute($query);

        return response()->json([
            'noba' => $noba,
            'tglba' => Carbon::now()->format('d/m/Y')
        ], 200);
    }

    public function checkQtyBA(Request $request){
        $noba = $request->noba;
        $plu = $request->plu;
        $qty = $request->qty;
        $qtyst = $request->qtysv;

        $temp = DB::connection(Session::get('connection'))
            ->table('tbtr_ba_cmo')
            ->select('bac_qty_ba')
            ->where('bac_noba','=',$noba)
            ->whereRaw("nvl(bac_recordid,'0') <> '1'")
            ->where('bac_prdcd','=',$plu)
            ->first();

        if($temp)
            $qtyba = $temp->bac_qty_ba;
        else $qtyba = 0;

        $stock = DB::connection(Session::get('connection'))
            ->table('tbmaster_stock')
            ->selectRaw("nvl(st_saldoakhir,0) stigr")
            ->where('st_prdcd','=',$plu)
            ->where('st_lokasi','=','01')
            ->first();

        if($stock)
            $stigr = $stock->stigr;
        else $stigr = 0;

        if($qty > $stigr){
            return response()->json([
                'message' => 'Qty BA lebih besar dari Stock IGR!',
                'qtyba' => $qtyba
            ], 500);
        }
        else{
            if($qty == $qtyst){
                return response()->json([
                    'message' => 'Qty BA sama dengan Stock Virtual CMO!',
                    'qtyba' => $qtyba
                ], 500);
            }
            else{
                return response()->json([
                    'temp' => $temp ? 1 : 0
                ], 200);
            }
        }
    }

    public function processBA(Request $request){
        try{
            DB::connection(Session::get('connection'))->beginTransaction();

//            DB::connection(Session::get('connection'))
//                ->table('tbtr_ba_cmo')
//                ->where('bac_noba','=',$request->noba)
//                ->update([
//                    'bac_recordid' => '1',
//                    'bac_modify_by' => Session::get('usid'),
//                    'bac_modify_dt' => Carbon::now()
//                ]);

            foreach($request->dataBA as $d){
                DB::connection(Session::get('connection'))
                    ->table('tbtr_ba_cmo')
                    ->insert([
                        'bac_kodeigr' => Session::get('kdigr'),
                        'bac_noba' => $request->noba,
                        'bac_tglba' => Carbon::createFromFormat('d/m/Y',$request->tglba),
                        'bac_keterangan' => $d['keterangan'],
                        'bac_prdcd' => $d['pluigr'],
                        'bac_qty_stock' => $d['qtyst'],
                        'bac_qty_ba' => $d['qtyba'],
                        'bac_create_by' => Session::get('usid'),
                        'bac_create_dt' => Carbon::now()
                ]);
            }

            DB::connection(Session::get('connection'))->commit();

            return response()->json([
                'message' => 'Data selesai diproses!',
                'noba' => $request->noba
            ], 200);
        }
        catch (\Exception $e){
            DB::connection(Session::get('connection'))->rollBack();

            return response()->json([
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function printBA(Request $request){
        $noba = $request->noba;

        $perusahaan = DB::connection(Session::get('connection'))
            ->table('tbmaster_perusahaan')
            ->first();

        $judul = DB::connection(Session::get('connection'))
            ->selectOne("select 'Pada hari ini, '
                || TO_CHAR(sysdate, 'Day dd/mm/yyyy','nls_date_language = INDONESIAN')
                || ' telah dilakukan pemastian kuantitas Stock Virtual, dengan rincian sbb.' judul
                from dual")->judul;

        $data = DB::connection(Session::get('connection'))
            ->select("select bac_noba, bac_tglba, bac_keterangan, bac_prdcd, prd_deskripsipanjang,
                bac_qty_stock, bac_qty_ba - bac_qty_stock selisih,
                bac_qty_ba, bac_tgladj, bac_qty_adj, bac_qty_selisih, bac_modify_by
                from tbtr_ba_cmo, tbmaster_prodmast
                where bac_kodeigr = '".Session::get('kdigr')."'
                and bac_noba = '".$noba."' and nvl(bac_recordid, '0') <> '1'
                and prd_prdcd = bac_prdcd");

        return view('BACKOFFICE.adjustment-stock-cmo-ba-pdf',
            compact(['perusahaan','data','noba','judul']));
    }

    public function cancelBA(Request $request){
        $temp = DB::connection(Session::get('connection'))
            ->table('tbtr_ba_cmo')
            ->where('bac_noba','=',$request->noba)
            ->whereRaw("nvl(bac_recordid,'0') = '0'")
            ->first();

        if(!$temp){
            return response()->json([
                'message' => 'Data BA CMO tidak ada!'
            ], 500);
        }
        else{
            DB::connection(Session::get('connection'))
                ->table('tbtr_ba_cmo')
                ->where('bac_noba','=',$request->noba)
                ->whereRaw("nvl(bac_recordid,'0') <> '1'")
                ->update([
                    'bac_recordid' => '1',
                    'bac_modify_by' => Session::get('usid'),
                    'bac_modify_dt' => Carbon::now()
                ]);

            return response()->json([
                'message' => 'Data BA selesai dibatalkan!'
            ], 200);
        }
    }

    public function processAdjust(Request $request){
        try{
            DB::connection(Session::get('connection'))->beginTransaction();

            $temp = DB::connection(Session::get('connection'))
                ->table('tbtr_ba_cmo')
                ->where('bac_noba','=',$request->noba)
                ->whereRaw("nvl(bac_recordid,'0') <> '1'")
                ->first();

            if(!$temp){
                return response()->json([
                    'message' => 'Data BA tidak ada, proses data BA terlebih dahulu!'
                ], 500);
            }

            $temp = DB::connection(Session::get('connection'))
                ->table('tbtr_ba_cmo')
                ->where('bac_noba','=',$request->noba)
                ->whereRaw("nvl(bac_recordid,'0') <> '2'")
                ->first();

            if(!$temp){
                return response()->json([
                    'message' => 'Data BA sudah diproses adjust!'
                ], 500);
            }

            $lok = true;
            foreach($request->dataBA as $d){
                $temp = DB::connection(Session::get('connection'))
                    ->table('tbtr_ba_cmo')
                    ->where('bac_noba','=',$request->noba)
                    ->whereRaw("nvl(bac_recordid,'0') <> '1'")
                    ->where('bac_prdcd','=',$d['pluigr'])
                    ->first();

                if(!$temp){
                    $lok = false;
                }
            }

            if($lok){
                $isiemail = '';

                foreach($request->dataBA as $d){
                    DB::connection(Session::get('connection'))
                        ->table('tbtr_ba_cmo')
                        ->where('bac_noba','=',$request->noba)
                        ->where('bac_prdcd','=',$d['pluigr'])
                        ->whereRaw("nvl(bac_recordid,'0') <> '1'")
                        ->update([
                            'bac_recordid' => '2',
                            'bac_tgladj' => Carbon::now(),
                            'bac_qty_adj' => $d['qtyadj'],
                            'bac_qty_selisih' => $d['qtyadj'] - $d['qtyst'],
                            'bac_modify_by' => Session::get('usid'),
                            'bac_modify_dt' => Carbon::now()
                        ]);

                    DB::connection(Session::get('connection'))
                        ->table('tbmaster_stock_cab_anak')
                        ->where('sta_prdcd','=',$d['pluigr'])
                        ->where('sta_lokasi','=','01')
                        ->update([
                            'sta_intransit' => $d['qtyadj'] - $d['qtyst'],
                            'sta_saldoakhir' => $d['qtyadj'],
                            'sta_modify_by' => Session::get('usid'),
                            'sta_modify_dt' => Carbon::now()
                        ]);

                    $isiemail .= $d['pluigr'].' | '.$d['qtyst'].' | '.($d['qtyadj'] - $d['qtyst']).' | '.$d['qtyadj'].'<br>';
                }

                $objDemo = new \stdClass();
                $objDemo->from = 'noreply.sd1@indogrosir.co.id';
                $objDemo->subject = 'Adjustment Item Commit Order tgl '.Carbon::now()->format('d/m/Y');
                $objDemo->text = 'Tgl. Adjustment : '.Carbon::now()->format('d/m/Y').'<br>
                    User ID : '.Session::get('usid').'<br>
                    No BA : '.$request->noba.'<br><br>
                    PLU | Saldo Awal | Qty Adj | Saldo Akhir<br>'.$isiemail;
                $objDemo->document = null;

                $send = array();

                $email = DB::connection(Session::get('connection'))
                    ->table('tbmaster_email')
                    ->select('eml_email')
                    ->where('eml_adjcmo','=','Y')
                    ->get();

                foreach($email as $e) {
                    array_push($send, $e->eml_email);
                }

                Mail::to($send)->send(new Email($objDemo));
            }
            else{
                return response()->json([
                    'message' => 'Ada data PLU yang belum proses BA, lakukan pengecekan ulang!'
                ], 500);
            }

            DB::connection(Session::get('connection'))->commit();

            return response()->json([
                'message' => 'Data selesai di-adjust!',
                'useradj' => Session::get('usid'),
                'tgladj' => Carbon::now()->format('d/m/Y')
            ], 200);
        }
        catch (\Exception $e){
            DB::connection(Session::get('connection'))->rollBack();

            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function printList(Request $request){
        $tgl1 = $request->tgl1;
        $tgl2 = $request->tgl2;

        $perusahaan = DB::connection(Session::get('connection'))
            ->table('tbmaster_perusahaan')
            ->first();

        $data = DB::connection(Session::get('connection'))
            ->select("select prc_pluidm, bac_prdcd, prd_deskripsipanjang,
                bac_noba, to_char(bac_tglba,'dd/mm/yyyy') bac_tglba, bac_qty_stock,
                bac_qty_selisih, bac_qty_adj,
                to_char(bac_tgladj,'dd/mm/yyyy') bac_tgladj, bac_modify_by
                from tbtr_ba_cmo, tbmaster_prodcrm, tbmaster_prodmast
                where bac_kodeigr = '".Session::get('kdigr')."'
                and to_char(bac_tglba,'yyyymmdd') between to_char(to_date('".$tgl1."','dd/mm/yyyy'),'yyyymmdd')
                and to_char(to_date('".$tgl2."','dd/mm/yyyy'),'yyyymmdd')
                and nvl(bac_recordid, '0') = '2'
                and prc_pluigr = bac_prdcd and prc_group = 'I'
                and prd_prdcd = bac_prdcd
                order by prc_pluidm, bac_prdcd, bac_noba, bac_tglba");

//        dd($data);

        return view('BACKOFFICE.adjustment-stock-cmo-list-pdf',
            compact(['perusahaan','data','tgl1','tgl2']));
    }
}
