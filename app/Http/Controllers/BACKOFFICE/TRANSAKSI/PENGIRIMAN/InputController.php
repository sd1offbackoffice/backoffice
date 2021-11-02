<?php

namespace App\Http\Controllers\BACKOFFICE\TRANSAKSI\PENGIRIMAN;

use App\Http\Controllers\Auth\loginController;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;

class InputController extends Controller
{
    public function index(){
        $penyesuaian = DB::table('tbtr_backoffice')
            ->select('trbo_nodoc',DB::RAW("to_char(trbo_tgldoc,'dd/mm/yyyy') trbo_tgldoc"))
            ->where('trbo_kodeigr',$_SESSION['kdigr'])
            ->where('trbo_typetrn','X')
            ->whereRaw("NVL(trbo_recordid,'0') <> '1'")
            ->orderBy('trbo_nodoc','desc')
            ->distinct()
            ->limit(100)
            ->get();

        $produk = DB::table(DB::RAW("tbmaster_prodmast,tbmaster_stock"))
            ->select('prd_deskripsipanjang','prd_prdcd','prd_plusupplier','prd_barcode')
            ->whereRaw("st_prdcd(+) = SUBSTR (PRD_PRDCD, 1, 6) || '0'")
            ->whereRaw("st_lokasi(+) = '01'")
            ->where('prd_kodeigr',$_SESSION['kdigr'])
            ->whereRaw("substr(prd_prdcd,-1) = '0'")
            ->orderBy('prd_prdcd')
            ->limit(100)
            ->get();

        return view('BACKOFFICE.TRANSAKSI.PENGIRIMAN.input')->with(compact(['penyesuaian','produk']));
    }

    public function lov_plu_search(Request $request){
        $search = $request->plu;
        $produk = '';
        $tipebarang = $request->lokasi;

        if(is_numeric($search)){
            $produk = DB::table(DB::RAW("tbmaster_prodmast,tbmaster_stock"))
                ->select('prd_deskripsipanjang','prd_prdcd','prd_plusupplier','prd_barcode')
                ->whereRaw("st_prdcd(+) = SUBSTR (PRD_PRDCD, 1, 6) || '0'")
                ->whereRaw("st_lokasi(+) = '".$tipebarang."'")
                ->where('prd_kodeigr',$_SESSION['kdigr'])
                ->whereRaw("substr(prd_prdcd,-1) = '0'")
                ->where('prd_prdcd',$search)
                ->orderBy('prd_prdcd')
                ->get();
        }
        else{
            $produk = DB::table(DB::RAW("tbmaster_prodmast,tbmaster_stock"))
                ->select('prd_deskripsipanjang','prd_prdcd','prd_plusupplier','prd_barcode')
                ->whereRaw("st_prdcd(+) = SUBSTR (PRD_PRDCD, 1, 6) || '0'")
                ->whereRaw("st_lokasi(+) = '".$tipebarang."'")
                ->where('prd_kodeigr',$_SESSION['kdigr'])
                ->whereRaw("substr(prd_prdcd,-1) = '0'")
                ->where('prd_deskripsipanjang','like',DB::RAW("'%".$search."%'"))
                ->orderBy('prd_prdcd')
                ->get();
        }

        return response()->json($produk);
    }

    public function plu_select(Request $request){
        $cekPLU = DB::table('tbmaster_prodmast')
            ->select('prd_prdcd')
            ->where('prd_kodeigr',$_SESSION['kdigr'])
            ->where('prd_prdcd',$request->plu)
            ->first();

        if(!$cekPLU){
            $title = 'PLU TIDAK TERDAFTAR DI MASTER PRODMAST!';
            return compact(['title']);
        }
        else{
            $plu = $request->plu;
            $tipempp = $request->tipempp;
            $tipebarang = $request->tipebarang;
            if($tipebarang == null)
                $tipebarang = '01';
            $totalitem = $request->totalitem;
            $nodoc = $request->nodoc;
            $frac = '';
            $qty = 0;
            $qtyk = 0;
            $subtotal = 0;

            $FPRDCD = 0;
            $FGANTIPLU = 0;

            $cekStock = DB::table('tbmaster_stock')
                ->select('st_prdcd')
                ->where('st_kodeigr',$_SESSION['kdigr'])
                ->whereRaw("substr(st_prdcd,1,6) = '".substr($request->plu,0,6)."'")
                ->where('st_lokasi',$tipebarang)
                ->first();

            if(!$cekStock){
                $title = 'PLU TIDAK TERDAFTAR DI MASTER STOCK!';
                return compact(['title']);
            }
            else{
                if($tipempp == '3'){
                    if($totalitem > 0){
                        $FGANTIPLU = 1;
                    }
                }

                $plu = substr($plu,0,6).'0';

                $FPLUBARU = DB::table('tbmaster_stock')
                    ->selectRaw("NVL(st_saldoakhir,0) saldoakhir")
                    ->where('st_kodeigr',$_SESSION['kdigr'])
                    ->where('st_prdcd',$plu)
                    ->where('st_lokasi',$tipebarang)
                    ->first();

                if($FPLUBARU)
                    $FPLUBARU = $FPLUBARU->saldoakhir;
                else $FPLUBARU = 0;

                if($FPLUBARU == 0){
                    $title = 'PENYESUAIAN PERSEDIAAN';
                    $message = 'SALDO AKHIR UNTUK PLU '.$plu.' = 0';
                }

                if($FPRDCD == 0){
                    $response = DB::table('tbmaster_prodmast')
                        ->selectRaw("PRD_DESKRIPSIPANJANG barang, PRD_UNIT || '/' || NVL (PRD_FRAC, 0) KEMASAN,PRD_KODETAG tag, NVL (PRD_FRAC, 0) frac, PRD_FLAGBANDROL bandrol, PRD_UNIT unit, PRD_LASTCOST oldcost, PRD_FLAGBKP1 bkp")
                        ->where('prd_kodeigr',$_SESSION['kdigr'])
                        ->where('prd_prdcd',$plu)
                        ->first();

                    $barang = $response->barang;
                    $kemasan = $response->kemasan;
                    $tag = $response->tag;
                    $bandrol = $response->bandrol;
                    $unit = $response->unit;
                    $lastcost = $response->oldcost;
                    $bkp = $response->bkp;
                    $frac = $response->frac;

                    if(substr($request->plu,-1) == '1'){
                        $data = DB::table(DB::RAW("tbmaster_prodmast,tbmaster_stock"))
                            ->selectRaw("NVL(st_saldoakhir,0) persediaan, 0 persediaan2, st_avgcost hargasatuan,
                        ST_AVGCOST * CASE
                        WHEN TRIM (PRD_UNIT) = 'KG'
                           THEN 1
                        ELSE PRD_FRAC
                        END avgcost,
                        CASE
                           WHEN TRIM (PRD_UNIT) = 'KG'
                               THEN 'GRAM'
                           ELSE 'PCS'
                        END pcs")
                            ->whereRaw("st_prdcd(+) = SUBSTR (PRD_PRDCD, 1, 6) || '0'")
                            ->whereRaw("st_lokasi(+) = '".$tipebarang."'")
                            ->where('prd_kodeigr',$_SESSION['kdigr'])
                            ->where('prd_prdcd',$plu)
                            ->first();

                        $persediaan = $data->persediaan;
                        $persediaan2 = $data->persediaan2;
                        $hrgsatuan = $data->hargasatuan;
                        $avgcost = $data->avgcost;
                        $pcs = $data->pcs;
                    }
                    else{
                        if($FGANTIPLU == 0){
                            $cek = DB::table('tbmaster_stock')
                                ->selectRaw("NVL(COUNT(1),0) jum")
                                ->where('st_kodeigr',$_SESSION['kdigr'])
                                ->where('st_lokasi',$tipebarang)
                                ->where('st_prdcd',$plu)
                                ->first()->jum;

                            if($cek > 0){
                                $data = DB::table(DB::RAW("tbmaster_prodmast,tbmaster_stock"))
                                    ->selectRaw("
                                CASE
                                   WHEN PRD_UNIT = 'PCS'
                                       THEN NVL (ST_SALDOAKHIR, 0)
                                   ELSE TRUNC (NVL (ST_SALDOAKHIR, 0) / NVL (PRD_FRAC, 0))
                                END persediaan,
                                CASE
                                   WHEN PRD_UNIT = 'PCS'
                                       THEN 0
                                   ELSE MOD(NVL(ST_SALDOAKHIR, 0),PRD_FRAC)
                                END persediaan2,
                                NVL (ST_AVGCOST, 0) * CASE
                                   WHEN PRD_UNIT = 'KG'
                                       THEN 1
                                   ELSE PRD_FRAC
                                END hrgsatuan,
                                (NVL (ST_AVGCOST, 0) * CASE
                                WHEN TRIM (PRD_UNIT) = 'KG'
                                    THEN 1
                                ELSE PRD_FRAC
                                END) avgcost,
                                --NVL(ST_AvgCost,0),
                                CASE
                                WHEN PRD_UNIT = 'KG'
                                   THEN 'GRAM'
                                ELSE 'PCS'
                                END pcs")
                                    ->whereRaw("st_prdcd(+) = SUBSTR (PRD_PRDCD, 1, 6) || '0'")
                                    ->whereRaw("st_lokasi(+) = '".$tipebarang."'")
                                    ->where('prd_kodeigr',$_SESSION['kdigr'])
                                    ->where('prd_prdcd',$plu)
                                    ->first();

                                $persediaan = $data->persediaan;
                                $persediaan2 = $data->persediaan2;
                                $hrgsatuan = $data->hrgsatuan;
                                $avgcost = $data->avgcost;
                                $pcs = $data->pcs;
                            }
                            else{
                                $persediaan = 0;
                                $persediaan2 = 0;
                                $hrgsatuan = 0;

                                $data = DB::table('tbmaster_prodmast')
                                    ->selectRaw("
                                CASE
                                WHEN PRD_UNIT = 'KG'
                                   THEN 'GRAM'
                                ELSE 'PCS'
                                END pcs")
                                    ->where('prd_kodeigr',$_SESSION['kdigr'])
                                    ->where('prd_prdcd',substr($request->plu,0,6).'1')
                                    ->first();

                                if($data)
                                    $pcs = $data->pcs;
                            }
                        }
                        else{
                            $data = DB::table('tbmaster_prodmast')
                                ->selectRaw("0 persediaan, 0 persediaan2, nvl(prd_avgcost,0) hrgsatuan,
                            CASE
                               WHEN TRIM (PRD_UNIT) = 'KG'
                                   THEN 'GRAM'
                               ELSE 'PCS'
                            END oldcost")
                                ->where('prd_kodeigr',$_SESSION['kdigr'])
                                ->where('prd_prdcd',$plu)
                                ->first();

                            $persediaan = $data->persediaan;
                            $persediaan2 = $data->persediaan2;
                            $hrgsatuan = $data->hrgsatuan;
                            $lastcost = $data->oldcost;

                            $cek = DB::table('tbmaster_stock')
                                ->selectRaw("NVL(COUNT(1),0) jum")
                                ->where('st_kodeigr',$_SESSION['kdigr'])
                                ->where('st_prdcd',$plu)
                                ->where('st_lokasi',$tipebarang)
                                ->first()->jum;

                            if($cek > 0){
                                $data = DB::table(DB::RAW("tbmaster_prodmast,tbmaster_stock"))
                                    ->selectRaw("
                                CASE
                                   WHEN PRD_UNIT = 'PCS'
                                       THEN NVL (ST_SALDOAKHIR, 0)
                                   ELSE TRUNC (NVL (ST_SALDOAKHIR, 0) / NVL (PRD_FRAC, 0))
                                END persediaan1,
                                CASE
                                   WHEN PRD_UNIT = 'PCS'
                                       THEN 0
                                   ELSE MOD(NVL(ST_SALDOAKHIR, 0),PRD_FRAC)
                                END persediaan2,
                                NVL (ST_AVGCOST, 0) * CASE
                                   WHEN PRD_UNIT = 'KG'
                                       THEN 1
                                   ELSE PRD_FRAC
                                END hrgsatuan,
                                (NVL (ST_AVGCOST, 0) * CASE
                                WHEN TRIM (PRD_UNIT) = 'KG'
                                    THEN 1
                                ELSE PRD_FRAC
                                END) avgcost,
                                --NVL(ST_AvgCost,0),
                                CASE
                                WHEN PRD_UNIT = 'KG'
                                   THEN 'GRAM'
                                ELSE 'PCS'
                                END pcs")
                                    ->whereRaw("st_prdcd(+) = SUBSTR (PRD_PRDCD, 1, 6) || '0'")
                                    ->whereRaw("st_lokasi(+) = '".$tipebarang."'")
                                    ->where('prd_kodeigr',$_SESSION['kdigr'])
                                    ->where('prd_prdcd',$plu)
                                    ->first();

                                $persediaan = $data->persediaan;
                                $persediaan2 = $data->persediaan2;
                                $hrgsatuan = $data->hrgsatuan;
                                $avgcost = $data->avgcost;
                                $pcs = $data->pcs;
                            }
                            else{
                                $persediaan = 0;
                                $persediaan2 = 0;
                                $hrgsatuan = 0;

                                $data = DB::table('tbmaster_prodmast')
                                    ->selectRaw("
                                CASE
                                WHEN TRIM (PRD_UNIT) = 'KG'
                                   THEN 'GRAM'
                                ELSE 'PCS'
                                END pcs")
                                    ->where('prd_kodeigr',$_SESSION['kdigr'])
                                    ->where('prd_prdcd',substr($request->plu,0,6).'1')
                                    ->first();

                                if($data)
                                    $pcs = $data->pcs;
                                else $pcs = 'PCS';
                            }
                        }
                    }

                    $cek = DB::table('tbtr_backoffice')
                        ->selectRaw("NVL(COUNT(1),0) jum")
                        ->where('trbo_kodeigr',$_SESSION['kdigr'])
                        ->where('trbo_prdcd',$request->plu)
                        ->where('trbo_nodoc',$request->nodoc)
                        ->where('trbo_typetrn','X')
                        ->whereRaw("NVL(trbo_recordid,0) <> '1'")
                        ->first()->jum;

                    if($cek == 0){
                        $qty = 0;
                        $qtyk = 0;
                        $subtotal = 0;

                        if(substr($request->plu,-1) == '1' ){
                            $hrgsatuan = DB::table(DB::RAW("tbmaster_prodmast,tbmaster_stock"))
                                ->selectRaw("NVL (ST_AVGCOST, 0) hrgsatuan")
                                ->whereRaw("st_prdcd(+) = SUBSTR (PRD_PRDCD, 1, 6) || '0'")
                                ->whereRaw("st_lokasi(+) = '".$tipebarang."'")
                                ->where('prd_kodeigr',$_SESSION['kdigr'])
                                ->where('prd_prdcd',$plu)
                                ->first()->hrgsatuan;
                        }
                        else{
                            if($FGANTIPLU == 0){
                                $cek = DB::table('tbmaster_stock')
                                    ->selectRaw("NVL(COUNT(1),0) jum")
                                    ->where('st_prdcd',$plu)
                                    ->whereRaw("st_lokasi = '".$tipebarang."'")
                                    ->where('st_kodeigr',$_SESSION['kdigr'])
                                    ->first();

                                if($cek)
                                    $cek = $cek->jum;
                                else $cek = 0;

                                if($cek > 0){
                                    $hrgsatuan = DB::table(DB::RAW("tbmaster_prodmast,tbmaster_stock"))
                                        ->selectRaw("NVL (ST_AVGCOST, 0) hrgsatuan")
                                        ->whereRaw("st_prdcd(+) = SUBSTR (PRD_PRDCD, 1, 6) || '0'")
                                        ->whereRaw("st_lokasi(+) = '".$tipebarang."'")
                                        ->where('prd_kodeigr',$_SESSION['kdigr'])
                                        ->where('prd_prdcd',$plu)
                                        ->first()->hrgsatuan;

                                    if($unit != 'KG')
                                        $hrgsatuan *= $frac;
                                }
                                else{
                                    $hrgsatuan = DB::table('tbmaster_prodmast')
                                        ->selectRaw("
                                    NVL (PRD_AVGCOST, 0) * CASE
                                        WHEN PRD_UNIT = 'KG'
                                            THEN 1
                                        ELSE PRD_FRAC
                                    END hrgsatuan")
                                        ->where('prd_kodeigr',$_SESSION['kdigr'])
                                        ->where('prd_prdcd',substr($request->plu,0,6).'1')
                                        ->first()->hrgsatuan;
                                }
                            }
                            else{
                                $hrgsatuan = DB::table('tbmaster_prodmast')
                                    ->selectRaw("NVL(prd_avgcost,0) hrgsatuan")
                                    ->where('prd_kodeigr',$_SESSION['kdigr'])
                                    ->where('prd_prdcd',$plu)
                                    ->first()->hrgsatuan;
                            }
                        }
                    }
                    else{
                        $data = DB::table('tbtr_backoffice')
                            ->selectRaw("TRBO_AVERAGECOST avgcost, TRUNC (NVL (TRBO_QTY, 0)) AS QTYB,
                       (NVL (TRBO_QTY, 0)) AS QTYK, NVL (TRBO_GROSS, 0) subtotal,
                       NVL (TRBO_HRGSATUAN, 0) hrgsatuan, TRBO_KETERANGAN keterangan")
                            ->where('trbo_nodoc',$nodoc)
                            ->where('trbo_prdcd',$request->plu)
                            ->where('trbo_typetrn','X')
                            ->whereRaw("NVL(trbo_recordid,0) <> '1'")
                            ->first();

                        $avgcost = $data->avgcost;
                        $qty = $data->qtyb / $frac;
                        $qtyk = $data->qtyk % $frac;
                        $subtotal = $data->subtotal;
                        $hrgsatuan = $data->hrgsatuan;
                        $keterangan = $data->keterangan;
                    }

                    if($tipempp != '1'){
                        if($totalitem > 0){
                            $oldplu = DB::table('tbtr_backoffice')
                                ->select('trbo_prdcd')
                                ->where('trbo_kodeigr',$_SESSION['kdigr'])
                                ->where('trbo_nodoc',$nodoc)
                                ->where('trbo_qty','<','0')
                                ->whereRaw("NVL(trbo_recordid,0) <> '1'")
                                ->first()->trbo_prdcd;

                            $oldfrac = DB::table('tbmaster_prodmast')
                                ->selectRaw("NVL(prd_frac,0) frac")
                                ->where('prd_kodeigr',$_SESSION['kdigr'])
                                ->where('prd_prdcd',$oldplu)
                                ->first()->frac;

                            $hrgsatuan = (DB::table('tbtr_backoffice')
                                        ->select('trbo_hrgsatuan hrgsatuan')
                                        ->where('trbo_kodeigr',$_SESSION['kdigr'])
                                        ->where('trbo_nodoc',$nodoc)
                                        ->where('trbo_prdcd',$oldplu)
                                        ->whereRaw("NVL(trbo_recordid,0) <> '1'")
                                        ->first()->hrgsatuan / $oldfrac) * $frac;
                        }
                    }

                    $s = $qty * $frac + $qtyk * ($hrgsatuan/$frac);

                    $cek = DB::table('tbtr_backoffice')
                        ->select('trbo_nodoc')
                        ->where('trbo_kodeigr',$_SESSION['kdigr'])
                        ->where('trbo_nodoc',$nodoc)
                        ->where('trbo_typetrn','X')
                        ->whereRaw("NVL(trbo_recordid,0) <> '1'")
                        ->whereIn('trbo_flagdisc1',['02','03'])
                        ->get();

                    if(count($cek) == 2){
                        $cek = DB::table('tbtr_backoffice')
                            ->select('trbo_nodoc')
                            ->where('trbo_kodeigr',$_SESSION['kdigr'])
                            ->where('trbo_nodoc',$nodoc)
                            ->where('trbo_typetrn','X')
                            ->whereRaw("NVL(trbo_recordid,0) <> '1'")
                            ->where('trbo_flagdisc1',$tipempp)
                            ->where('trbo_prdcd',$request->plu)
                            ->first();

                        if(!$cek){
                            array_push($title, 'Kode Produk Tidak Boleh Di Tambah Dalam Dokumen Ini!');
                            array_push($message, '');
                        }
                    }
                }

                if($FGANTIPLU == 1){
                    $cek = DB::table('tbmaster_stock')
                        ->select('st_prdcd')
                        ->where('st_kodeigr',$_SESSION['kdigr'])
                        ->where('st_lokasi',$tipebarang)
                        ->where('st_prdcd',$request->plu)
                        ->get();

                    $V_AVGCOST = 0;

                    if(count($cek) > 0){
                        $V_AVGCOST = DB::table(DB::RAW('tbmaster_stock,tbmaster_prodmast'))
                            ->selectRaw("NVL (ST_AVGCOST, 0) * CASE
                        WHEN PRD_UNIT = 'KG'
                           THEN 1
                        ELSE PRD_FRAC
                        END avgcost")
                            ->where('st_kodeigr',$_SESSION['kdigr'])
                            ->where('st_lokasi',$tipebarang)
                            ->where('st_prdcd',$request->plu)
                            ->where('prd_kodeigr',$_SESSION['kdigr'])
                            ->where('prd_prdcd',$request->plu)
                            ->first();

                        if($V_AVGCOST && $V_AVGCOST != 0)
                            $hrgsatuan = $V_AVGCOST;
                    }
                }

                return compact([
                    'barang',
                    'kemasan',
                    'tag',
                    'bandrol',
                    'bkp',
                    'lastcost',
                    'avgcost',
                    'persediaan',
                    'persediaan2',
                    'hrgsatuan',
                    'qty',
                    'qtyk',
                    'subtotal',
                    'keterangan',
                    'unit'
                ]);
            }
        }
    }

    public function doc_select(Request $request){
        $doc = DB::table('tbtr_backoffice')
            ->select('trbo_nodoc','trbo_tgldoc','trbo_noreff','trbo_tglreff','trbo_flagdisc1','trbo_flagdisc2',DB::RAW('SUM(trbo_gross) total, count(trbo_gross) totalitem'))
            ->where('trbo_kodeigr',$_SESSION['kdigr'])
            ->where('trbo_nodoc',$request->nodoc)
            ->where('trbo_typetrn','X')
            ->whereRaw("NVL(trbo_recordid,'0') <> '1'")
            ->groupBy(['trbo_nodoc','trbo_tgldoc','trbo_noreff','trbo_tglreff','trbo_flagdisc1','trbo_flagdisc2'])
            ->distinct()
            ->first();

        return response()->json($doc);
    }

    public function doc_new(){
        $c = loginController::getConnectionProcedure();
        $s = oci_parse($c, "BEGIN :ret := F_IGR_GET_NOMOR('".$_SESSION['kdigr']."','PYS','Nomor Penyesuaian Persediaan','A'
							|| TO_CHAR (SYSDATE, 'yy'),5,FALSE); END;");
        oci_bind_by_name($s, ':ret', $r, 32);
        oci_execute($s);
        return $r;
    }

    public function doc_save(Request $request){
        $kodeigr = $_SESSION['kdigr'];
        $ty_mpp = $request->tipempp;
        $ty_brg = $request->tipebarang;
        $totalitem = $request->totalitem;
        $prdcd = $request->prdcd;
        $qty = $request->qty;
        $qtyk = $request->qtyk;
        $nodoc = $request->nodoc;
        $tglpys = $request->tgldoc;
        $hrgsatuan = $request->hrgsatuan;
        $avgcost = $request->avgcost;
        $subtotal = $request->subtotal;
        $noreff = $request->noreff;
        $tglreff = $request->tglreff;
        $keterangan = $request->keterangan;
        $jenisdoc = $request->jenisdoc;

        if($ty_mpp == '1' || ($ty_mpp != '1' && $totalitem < 2)){
            $frac = DB::table('tbmaster_prodmast')
                ->select('prd_frac')
                ->where('prd_kodeigr',$kodeigr)
                ->where('prd_prdcd',$prdcd)
                ->first()->prd_frac;

            if(($qty * $frac + $qtyk) < 0){
                $prdcdlama = $prdcd;

                $data = DB::table('tbtr_backoffice')
                    ->select('trbo_prdcd','trbo_flagdisc2')
                    ->where('trbo_nodoc',$nodoc)
                    ->where('trbo_qty','>',0)
                    ->whereRaw("NVL(trbo_recordid,'') <> '1'")
                    ->first();

                if($data){
                    $prdcdbaru = $data->trbo_prdcd;
                    $lokbaru = $data->trbo_flagdisc2;

                    $prdcdold = DB::table('tbtr_konversiplu')
                        ->select('kvp_pluold')
                        ->where('kvp_kodeigr',$kodeigr)
                        ->where('kvp_kodetipe','M')
                        ->where('kvp_plunew',$prdcdbaru)
                        ->first()->kvp_pluold;

                    if($prdcdold != $prdcdlama){
                        $status = 'error';
                        $title = 'PLU '.$prdcdbaru.' Sudah Dari Pergantian PLU '.$prdcdold.', Tidak Bisa Diganti Dari PLU '.$prdcdlama;
                        return compact(['status','title']);
                    }
                }
            }
            else{
                $prdcdbaru = $prdcd;

                $data = DB::table('tbtr_backoffice')
                    ->select('trbo_prdcd','trbo_flagdisc2')
                    ->where('trbo_nodoc',$nodoc)
                    ->where('trbo_qty','<',0)
                    ->whereRaw("NVL(trbo_recordid,'') <> '1'")
                    ->first();

                if($data){
                    $prdcdlama = $data->trbo_prdcd;
                    $loklama = $data->trbo_flagdisc2;

                    $temp = DB::table('tbtr_konversiplu')
                        ->select('kvp_pluold')
                        ->where('kvp_kodeigr',$kodeigr)
                        ->where('kvp_kodetipe','M')
                        ->where('kvp_plunew',$prdcdbaru)
                        ->first();

                    if($temp){
                        $prdcdold = $temp->kvp_pluold;
                        if($prdcdold != $prdcdlama){
                            $title = 'PLU '.$prdcdbaru.' Sudah Dari Pergantian PLU '.$prdcdold.', Tidak Bisa Diganti Dari PLU '.$prdcdlama;

                            return compact(['status','title']);
                        }
                    }
                }
            }

            $fgantiplu = 0;

            $temp = DB::table('tbmaster_stock')
                ->join('tbmaster_prodmast',function($join){
                    $join->on('prd_kodeigr','st_kodeigr');
                    $join->on('prd_prdcd','st_prdcd');
                })
                ->selectRaw("NVL (ST_AVGCOST, 0) * case when prd_unit = 'KG' then 1 else prd_frac end v_avgcost")
                ->where('st_kodeigr',$kodeigr)
                ->where('st_prdcd',$prdcd)
                ->where('st_lokasi',$ty_brg)
                ->first();

            if($temp){
                $v_avgcost = $temp->v_avgcost;
            }
            else{
                $v_avgcost = 0;
            }

            $jum = DB::table('tbtr_backoffice')
                ->where('trbo_kodeigr',$kodeigr)
                ->where('trbo_flagdoc','*')
                ->where('trbo_recordid','2')
                ->where('trbo_nodoc',$nodoc)
                ->where('trbo_prdcd',$prdcd)
                ->first();

            $cekstock = DB::table('tbmaster_stock')
                ->select('st_saldoakhir')
                ->where('st_kodeigr',$kodeigr)
                ->where('st_lokasi',$ty_brg)
                ->where('st_prdcd',$prdcd)
                ->first();

            if($cekstock){
                $cekstock = $cekstock->st_saldoakhir;
            }

            if($prdcd != null){
                if(!$jum){
                    $frac = DB::table('tbmaster_prodmast')
                        ->selectRaw("NVL(prd_frac,0) frac")
                        ->where('prd_kodeigr',$kodeigr)
                        ->where('prd_prdcd',$prdcd)
                        ->first()->frac;

                    $jum = DB::table('tbtr_backoffice')
                        ->select('trbo_nodoc')
                        ->where('trbo_nodoc',$nodoc)
                        ->where('trbo_typetrn','X')
                        ->whereRaw("NVL(trbo_recordid,'0') <> '1'")
                        ->where('trbo_prdcd',$prdcd)
                        ->first();

                    $ksup = DB::table('tbmaster_prodmast')
                        ->select('prd_kodesupplier')
                        ->where('prd_kodeigr',$kodeigr)
                        ->where('prd_prdcd',$prdcd)
                        ->first()->prd_kodesupplier;

                    if($ty_mpp == '3'){
                        $fgantiplu = DB::table('tbmaster_stock')
                            ->select('st_prdcd')
                            ->where('st_kodeigr',$kodeigr)
                            ->where('st_lokasi',$ty_brg)
                            ->where('st_prdcd',$prdcd)
                            ->first();

                        if($fgantiplu){
                            $fgantiplu = 1;
                        }
                        else $fgantiplu = 0;
                    }

                    $data = DB::table('tbmaster_stock')
                        ->select('st_avgcost','st_saldoakhir')
                        ->where('st_kodeigr',$kodeigr)
                        ->where('st_lokasi',$ty_brg)
                        ->where('st_prdcd',$prdcd)
                        ->first();

                    if($data){
                        $ocost = $data->st_avgcost;
                        $posqty = $data->st_saldoakhir;
                    }
                    else{
                        $ocost = 0;
                        $posqty = 0;
                    }

                    if(!$jum){
                        $seqno = DB::table('tbtr_backoffice')
                            ->selectRaw("NVL(MAX(trbo_seqno),0) + 1 seqno")
                            ->where('trbo_kodeigr',$kodeigr)
                            ->where('trbo_typetrn','X')
                            ->where('trbo_nodoc',$nodoc)
                            ->whereRaw("NVL(trbo_recordid,'0') <> '1'")
                            ->first()->seqno;

                        if($v_avgcost == 0){
                            $trbohrgsatuan = $hrgsatuan;
                        }
                        else{
                            $trbohrgsatuan = $v_avgcost;
                        }

                        if($avgcost == 0){
                            $trboavgcost = ($subtotal / ($qty * $frac + $qtyk)) * $frac;
                        }
                        else $trboavgcost = $avgcost;

                        $insert = array([
                            'trbo_kodeigr' => $kodeigr,
                            'trbo_recordid' => null,
                            'trbo_typetrn' => 'X',
                            'trbo_nodoc' => $nodoc,
                            'trbo_tgldoc' => DB::RAW("to_date('".$tglpys."','dd/mm/yyyy')"),
                            'trbo_noreff' => $noreff,
                            'trbo_tglreff' => $tglreff,
                            'trbo_prdcd' => $prdcd,
                            'trbo_flagdisc1' => $ty_mpp,
                            'trbo_flagdisc2' => $ty_brg,
                            'trbo_qty' => $qty * $frac + $qtyk,
                            'trbo_hrgsatuan' => $trbohrgsatuan,
                            'trbo_gross' => $subtotal,
                            'trbo_averagecost' => $trboavgcost,
                            'trbo_keterangan' => $keterangan,
                            'trbo_create_dt' => DB::RAW("sysdate"),
                            'trbo_create_by' => $_SESSION['usid'],
                            'trbo_kodesupplier' => $ksup,
                            'trbo_oldcost' => $v_avgcost,
                            'trbo_posqty' => $posqty,
                            'trbo_seqno' => $seqno
                        ]);

                        $insert = $insert[0];



                        try{
                            DB::beginTransaction();
                            if($jenisdoc == 'lama'){
                                DB::table('tbtr_backoffice')
                                    ->insert($insert);
                            }
                            else{
                                $c = loginController::getConnectionProcedure();
                                $s = oci_parse($c, "BEGIN :ret := F_IGR_GET_NOMOR('".$_SESSION['kdigr']."','PYS','Nomor Penyesuaian Persediaan','A'
							            || TO_CHAR (SYSDATE, 'yy'),5,TRUE); END;");
                                oci_bind_by_name($s, ':ret', $r, 32);
                                oci_execute($s);

                                $insert['trbo_nodoc'] = $r;

                                DB::table('tbtr_backoffice')
                                    ->insert($insert);
                            }
                        }
                        catch (QueryException $e){
                            DB::rollBack();

                            $status = 'error';
                            $title = 'ORACLE ERROR';
                            $message = $e->getMessage();
                            return compact(['status','title','message']);
                        }
                        finally{
                            DB::commit();
                        }
                    }
                    else{
                        if($v_avgcost == 0){
                            $trbohrgsatuan = $hrgsatuan;
                        }
                        else{
                            $trbohrgsatuan = $v_avgcost;
                        }

                        if($avgcost == 0){
                            $trboavgcost = ($subtotal / ($qty * $frac + $qtyk)) * $frac;
                        }
                        else $trboavgcost = $avgcost;

                        try{
                            DB::beginTransaction();
                            if($jenisdoc == 'lama'){
                                DB::table('tbtr_backoffice')
                                    ->where('trbo_kodeigr',$kodeigr)
                                    ->where('trbo_typetrn','X')
                                    ->where('trbo_nodoc',$nodoc)
                                    ->where('trbo_prdcd',$prdcd)
                                    ->whereRaw("NVL(trbo_recordid,'0') <> '1'")
                                    ->update([
                                        'trbo_noreff' => $noreff,
                                        'trbo_tglreff' => $tglreff,
                                        'trbo_flagdisc1' => $ty_mpp,
                                        'trbo_flagdisc2' => $ty_brg,
                                        'trbo_qty' => $qty * $frac + $qtyk,
                                        'trbo_hrgsatuan' => $trbohrgsatuan,
                                        'trbo_gross' => $subtotal,
                                        'trbo_averagecost' => $trboavgcost,
                                        'trbo_keterangan' => $keterangan,
                                        'trbo_modify_by' => $_SESSION['usid'],
                                        'trbo_modify_dt' => DB::RAW("sysdate")
                                    ]);

                                DB::table('tbmaster_lokasi')
                                    ->where('lks_prdcd',$prdcd)
                                    ->whereRaw("SUBSTR(lks_prdcd,1,1) = 'D'")
                                    ->update([
                                        'lks_flagupdate' => '1'
                                    ]);
                            }
                            else{
                                $insert = array([
                                    'trbo_kodeigr' => $kodeigr,
                                    'trbo_recordid' => null,
                                    'trbo_typetrn' => 'X',
                                    'trbo_nodoc' => $nodoc,
                                    'trbo_tgldoc' => DB::RAW("to_date('".$tglpys."','dd/mm/yyyy')"),
                                    'trbo_noreff' => $noreff,
                                    'trbo_tglreff' => $tglreff,
                                    'trbo_prdcd' => $prdcd,
                                    'trbo_flagdisc1' => $ty_mpp,
                                    'trbo_flagdisc2' => $ty_brg,
                                    'trbo_qty' => $qty * $frac + $qtyk,
                                    'trbo_hrgsatuan' => $trbohrgsatuan,
                                    'trbo_gross' => $subtotal,
                                    'trbo_averagecost' => $trboavgcost,
                                    'trbo_keterangan' => $keterangan,
                                    'trbo_create_dt' => DB::RAW("sysdate"),
                                    'trbo_create_by' => $_SESSION['usid'],
                                    'trbo_kodesupplier' => $ksup,
                                    'trbo_oldcost' => $v_avgcost,
                                    'trbo_posqty' => $posqty,
                                    'trbo_seqno' => '1'
                                ]);

                                $insert = $insert[0];

                                $c = loginController::getConnectionProcedure();
                                $s = oci_parse($c, "BEGIN :ret := F_IGR_GET_NOMOR('".$_SESSION['kdigr']."','PYS','Nomor Penyesuaian Persediaan','A'
							            || TO_CHAR (SYSDATE, 'yy'),5,TRUE); END;");
                                oci_bind_by_name($s, ':ret', $r, 32);
                                oci_execute($s);

                                $insert['trbo_nodoc'] = $r;

                                DB::table('tbtr_backoffice')
                                    ->insert($insert);
                            }
                        }
                        catch (QueryException $e){
                            DB::rollBack();

                            $status = 'error';
                            $title = 'ORACLE ERROR';
                            $message = $e->getMessage();
                            return compact(['status','title','message']);
                        }
                        finally{
                            DB::commit();
                        }

                        if(1 == 0){//$sts == 0
                            $c = loginController::getConnectionProcedure();
                            $s = oci_parse($c, "BEGIN :ret := F_IGR_GET_NOMOR('".$_SESSION['kdigr']."','PYS','Nomor Penyesuaian Persediaan','A'
							|| TO_CHAR (SYSDATE, 'yy'),5,FALSE); END;");
                            oci_bind_by_name($s, ':ret', $r, 32);
                            oci_execute($s);

                            $nodoc = $r;
                        }

                        if($ty_mpp != '1'){
                            if($qty + $qtyk > 0){
                                $data = DB::table('tbmaster_stock')
                                    ->selectRaw("NVL(st_saldoakhir,0) st_qty, NVL(st_avgcost,0) st_acost")
                                    ->where('st_kodeigr',$kodeigr)
                                    ->where('st_lokasi',$ty_brg)
                                    ->where('st_prdcd',$prdcd)
                                    ->first();

                                if($data){
                                    $st_qty = $data->st_qty;
                                    $st_acost = $data->st_acost;

                                    try{
                                        $update = (($qty * $frac + $qtyk) * ($hrgsatuan / $frac) + ($st_acost * $st_qty)) / (($qty * $frac + $qtyk) + $st_qty) * $frac;

                                        DB::beginTransaction();
                                        DB::table('tbtr_backofficce')
                                            ->where('trbo_kodeigr',$kodeigr)
                                            ->where('trbo_typetrn','X')
                                            ->where('trbo_nodoc',$nodoc)
                                            ->whereRaw("NVL(trbo_recordid,'0') <> '1'")
                                            ->where('trbo_prdcd',$prdcd)
                                            ->update([
                                                'trbo_averagecost' => $update
                                            ]);
                                    }
                                    catch (QueryException $e){
                                        DB::rollBack();

                                        $status = 'error';
                                        $title = 'ORACLE ERROR';
                                        $message = $e->getMessage();
                                        return compact(['status','title','message']);
                                    }
                                    finally{
                                        DB::commit();
                                    }
                                }
                            }
                        }
                    }
                }
                else{
                    $status = 'error';
                    $title = 'TIDAK DAPAT MELAKUKAN PROSES REKAM KARENA NOMOR PENYESUAIAN TELAH MELAKUKAN CETAK NOTA PENYESUAIAN PERSEDIAAN!';
                    return compact(['status','title']);
                }
            }
        }
        else{
            $status = 'error';
            $title = 'Kode Produk Tidak Boleh Ditambah Dalam Dokumen Ini!';
            return compact(['status','title']);
        }

        $status = 'success';
        $title = 'Berhasil menyimpan data!';
        return compact(['status','title']);
    }

    public function doc_delete(Request $request){
        $kodeigr = $_SESSION['kdigr'];
        $nodoc = $request->nodoc;
        $prdcd = $request->prdcd;

        $doc = DB::table('tbtr_backoffice')
            ->where('trbo_kodeigr',$kodeigr)
            ->where('trbo_nodoc',$nodoc)
            ->where('trbo_typetrn','X')
            ->where('trbo_prdcd',$prdcd)
            ->first();

        if($doc){
            $cek = DB::table('tbtr_backoffice')
                ->where('trbo_kodeigr',$kodeigr)
                ->where('trbo_nodoc',$nodoc)
                ->where('trbo_prdcd',$prdcd)
                ->where('trbo_flagdoc','*')
                ->where('trbo_recordid','2')
                ->first();

            if($cek){
                $status = 'error';
                $title = 'Gagal menghapus data!';
                $message = 'Nomor Penyesuaian telah melakukan cetak nota!';
                return compact(['status','title','message']);
            }
            else{
                try{
                    DB::beginTransaction();
                    DB::table('tbtr_backoffice')
                        ->where('trbo_kodeigr',$kodeigr)
                        ->where('trbo_nodoc',$nodoc)
                        ->where('trbo_typetrn','X')
                        ->where('trbo_prdcd',$prdcd)
                        ->update([
                            'trbo_recordid' => '1',
                            'trbo_modify_by' => $_SESSION['usid'],
                            'trbo_modify_dt' => DB::RAW("sysdate")
                        ]);
                }
                catch (QueryException $e){
                    DB::rollBack();

                    $status = 'error';
                    $title = 'ORACLE ERROR!';
                    $message = $e->getMessage();
                    return compact(['status','title','message']);
                }
                finally{
                    DB::commit();

                    $status = 'success';
                    $title = 'Berhasil menghapus data!';
                    return compact(['status','title']);
                }
            }
        }
        else{
            $status = 'error';
            $title = 'Gagal menghapus data!';
            $message = 'Data tidak ditemukan!';
            return compact(['status','title','message']);
        }
    }
}
