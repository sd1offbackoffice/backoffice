<?php

namespace App\Http\Controllers\BACKOFFICE\TRANSAKSI\PENYESUAIAN;

use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;
use PDF;
use Yajra\DataTables\DataTables;

class PerubahanPLUController extends Controller
{
    public function index(){
        return view('BACKOFFICE.TRANSAKSI.PENYESUAIAN.perubahan-plu');
    }

    public function getDataLov(){
        $data = DB::connection($_SESSION['connection'])->table('tbmaster_prodmast')
            ->select('prd_prdcd','prd_deskripsipanjang')
            ->where('prd_kodeigr',$_SESSION['kdigr'])
            ->where('prd_recordid',null)
            ->whereRaw("SUBSTR(prd_prdcd,7,1) = '0'")
            ->orderBy('prd_prdcd')
            ->get();

        return DataTables::of($data)->make(true);
    }

    public function getData(Request $request){
        $prdcd = $request->prdcd;

        $data = DB::connection($_SESSION['connection'])->select("Select prd_deskripsipanjang desk,
                                'SATUAN : '||prd_unit||'/'||prd_frac||'  STOK : '||nvl(st_saldoakhir,0) satuan
                                From tbmaster_prodmast, tbmaster_stock
                                Where
                                PRD_PRDCD = '".$prdcd."' AND
                                PRD_PRDCD = ST_PRDCD(+) AND
                                ST_LOKASI(+) = '01' AND
                                PRD_KodeIGR = '".$_SESSION['kdigr']."'");

        return response()->json($data[0]);
    }

    public function proses(Request $request){
        $plulama = $request->prdcdlama;
        $plubaru = $request->prdcdbaru;
        $ukuran = $request->ukuran;

        $updplu = false;

        try{
            DB::connection($_SESSION['connection'])->beginTransaction();

            $dataplulama = DB::connection($_SESSION['connection'])->table('tbmaster_prodmast')
                ->selectRaw("prd_prdcd, prd_deskripsipanjang, prd_unit || ' / ' || prd_frac kemasan")
                ->where('prd_prdcd',$plulama)
                ->first();

            $dataplubaru = DB::connection($_SESSION['connection'])->table('tbmaster_prodmast')
                ->selectRaw("prd_prdcd, prd_deskripsipanjang, prd_unit || ' / ' || prd_frac kemasan")
                ->where('prd_prdcd',$plubaru)
                ->first();

            if(true){
                $temp = DB::connection($_SESSION['connection'])->table('tbmaster_stock')
                    ->where('st_prdcd',$plulama)
                    ->where('st_kodeigr',$_SESSION['kdigr'])
                    ->where('st_lokasi','01')
                    ->get()->count();

                if($temp == 0){

                }
                else{
                    $temp = DB::connection($_SESSION['connection'])->table('tbmaster_stock')
                        ->where('st_prdcd',$plubaru)
                        ->where('st_kodeigr',$_SESSION['kdigr'])
                        ->where('st_lokasi','01')
                        ->get()->count();

                    if($temp > 0){

                    }
                    else{
                        if(true){
                            $temp = DB::connection($_SESSION['connection'])->table('tbmaster_stock')
                                ->where('st_kodeigr',$_SESSION['kdigr'])
                                ->where('st_recordid',null)
                                ->where('st_lokasi','01')
                                ->where('st_prdcd',$plubaru)
                                ->get()->count();

                            if($temp == 0){
                                $updplu = true;

                                $data = DB::connection($_SESSION['connection'])->table('tbmaster_stock')
                                    ->select('st_lastcost','st_avgcost')
                                    ->where('st_prdcd',$plulama)
                                    ->where('st_kodeigr',$_SESSION['kdigr'])
                                    ->where('st_lokasi','01')
                                    ->first();

                                if($data){
                                    $lcost = $data->st_lastcost;
                                    $acost = $data->st_avgcost;
                                }
                                else{
                                    $lcost = 0;
                                    $acost = 0;
                                }

                                DB::connection($_SESSION['connection'])->table('tbmaster_stock')
                                    ->insert([
                                        'st_kodeigr' => $_SESSION['kdigr'],
                                        'st_prdcd' => $plubaru,
                                        'st_saldoawal' => 0,
                                        'st_trfin' => 0,
                                        'st_trfout' => 0,
                                        'st_sales' => 0,
                                        'st_retur' => 0,
                                        'st_adj' => 0,
                                        'st_intransit' => 0,
                                        'st_lokasi' => '01',
                                        'st_lastcost' => $lcost,
                                        'st_avgcost' => $acost,
                                        'st_create_by' => $_SESSION['usid'],
                                        'st_create_dt' => DB::RAW("SYSDATE")
                                    ]);
                            }

                            DB::connection($_SESSION['connection'])->table('tbmaster_lokasi')
                                ->where('lks_prdcd',$plulama)
                                ->where('lks_kodeigr',$_SESSION['kdigr'])
                                ->update([
                                    'lks_prdcd' => $plubaru,
                                    'lks_modify_by' => $_SESSION['usid'],
                                    'lks_modify_dt' => DB::RAW("SYSDATE")
                                ]);

                            $temp = DB::connection($_SESSION['connection'])->table('tbmaster_kkpkm')
                                ->where('pkm_kodeigr',$_SESSION['kdigr'])
                                ->where('pkm_prdcd',$plulama)
                                ->get()->count();

                            if($temp > 0){
                                $temp = DB::connection($_SESSION['connection'])->table('tbmaster_kkpkm')
                                    ->where('pkm_kodeigr',$_SESSION['kdigr'])
                                    ->where('pkm_prdcd',$plubaru)
                                    ->get()->count();

                                if($temp > 0){
                                    DB::connection($_SESSION['connection'])->table('tbmaster_kkpkm')
                                        ->where('pkm_prdcd',$plulama)
                                        ->where('pkm_kodeigr',$_SESSION['kdigr'])
                                        ->delete();
                                }
                                else{
                                    DB::connection($_SESSION['connection'])->table('tbmaster_kkpkm')
                                        ->where('pkm_prdcd',$plulama)
                                        ->where('pkm_kodeigr',$_SESSION['kdigr'])
                                        ->update([
                                            'pkm_prdcd' => $plubaru,
                                            'pkm_modify_by' => $_SESSION['usid'],
                                            'pkm_modify_dt' => DB::RAW("SYSDATE")
                                        ]);
                                }
                            }

                            $temp = DB::connection($_SESSION['connection'])->table('tbmaster_pkmplus')
                                ->where('pkmp_kodeigr',$_SESSION['kdigr'])
                                ->where('pkmp_prdcd',$plulama)
                                ->get()->count();

                            if($temp > 0){
                                $temp = DB::connection($_SESSION['connection'])->table('tbmaster_pkmplus')
                                    ->where('pkmp_kodeigr',$_SESSION['kdigr'])
                                    ->where('pkmp_prdcd',$plubaru)
                                    ->get()->count();

                                if($temp > 0){
                                    DB::connection($_SESSION['connection'])->table('tbmaster_pkmplus')
                                        ->where('pkmp_kodeigr',$_SESSION['kdigr'])
                                        ->where('pkmp_prdcd',$plulama)
                                        ->delete();
                                }
                                else{
                                    DB::connection($_SESSION['connection'])->table('tbmaster_pkmplus')
                                        ->where('pkmp_kodeigr',$_SESSION['kdigr'])
                                        ->where('pkmp_prdcd',$plulama)
                                        ->update([
                                            'pkmp_prdcd' => $plubaru,
                                            'pkmp_modify_by' => $_SESSION['usid'],
                                            'pkmp_modify_dt' => DB::RAW("SYSDATE")
                                        ]);
                                }
                            }

                            $temp = DB::connection($_SESSION['connection'])->table('tbtr_pkmgondola')
                                ->where('pkmg_kodeigr',$_SESSION['kdigr'])
                                ->where('pkmg_prdcd',$plulama)
                                ->get()->count();

                            if($temp > 0){
                                $temp = DB::connection($_SESSION['connection'])->table('tbtr_pkmgondola')
                                    ->where('pkmg_kodeigr',$_SESSION['kdigr'])
                                    ->where('pkmg_prdcd',$plubaru)
                                    ->get()->count();

                                if($temp > 0){
                                    DB::connection($_SESSION['connection'])->table('tbtr_pkmgondola')
                                        ->where('pkmg_kodeigr',$_SESSION['kdigr'])
                                        ->where('pkmg_prdcd',$plulama)
                                        ->delete();
                                }
                                else{
                                    DB::connection($_SESSION['connection'])->table('tbtr_pkmgondola')
                                        ->where('pkmg_kodeigr',$_SESSION['kdigr'])
                                        ->where('pkmg_prdcd',$plulama)
                                        ->update([
                                            'pkmg_prdcd' => $plubaru,
                                            'pkmg_modify_by' => $_SESSION['usid'],
                                            'pkmg_modify_dt' => DB::RAW("SYSDATE")
                                        ]);
                                }
                            }

                            $temp = DB::connection($_SESSION['connection'])->table('tbtr_gondola')
                                ->where('gdl_kodeigr',$_SESSION['kdigr'])
                                ->where('gdl_prdcd',$plulama)
                                ->where('gdl_recordid',null)
                                ->get()->count();

                            if($temp > 0){
                                $temp = DB::connection($_SESSION['connection'])->table('tbtr_gondola')
                                    ->where('gdl_kodeigr',$_SESSION['kdigr'])
                                    ->where('gdl_prdcd',$plubaru)
                                    ->where('gdl_recordid',null)
                                    ->get()->count();

                                if($temp > 0){
                                    DB::connection($_SESSION['connection'])->table('tbtr_gondola')
                                        ->where('gdl_kodeigr',$_SESSION['kdigr'])
                                        ->where('gdl_prdcd',$plulama)
                                        ->where('gdl_recordid',null)
                                        ->update([
                                            'gdl_recordid' => '1',
                                            'gdl_modify_by' => $_SESSION['usid'],
                                            'gdl_modify_dt' => DB::RAW("SYSDATE")
                                        ]);
                                }
                                else{
                                    DB::connection($_SESSION['connection'])->table('tbtr_gondola')
                                        ->where('gdl_kodeigr',$_SESSION['kdigr'])
                                        ->where('gdl_prdcd',$plulama)
                                        ->where('gdl_recordid',null)
                                        ->update([
                                            'gdl_prdcd' => $plubaru,
                                            'gdl_modify_by' => $_SESSION['usid'],
                                            'gdl_modify_dt' => DB::RAW("SYSDATE")
                                        ]);
                                }
                            }

                            $temp = DB::connection($_SESSION['connection'])->table('tbmaster_minimumorder')
                                ->where('min_kodeigr',$_SESSION['kdigr'])
                                ->where('min_prdcd',$plulama)
                                ->get()->count();

                            if($temp > 0){
                                $temp = DB::connection($_SESSION['connection'])->table('tbmaster_minimumorder')
                                    ->where('min_kodeigr',$_SESSION['kdigr'])
                                    ->where('min_prdcd',$plubaru)
                                    ->get()->count();

                                if($temp > 0){
                                    DB::connection($_SESSION['connection'])->table('tbmaster_minimumorder')
                                        ->where('min_kodeigr',$_SESSION['kdigr'])
                                        ->where('min_prdcd',$plulama)
                                        ->delete();
                                }
                                else{
                                    DB::connection($_SESSION['connection'])->table('tbmaster_minimumorder')
                                        ->where('min_kodeigr',$_SESSION['kdigr'])
                                        ->where('min_prdcd',$plulama)
                                        ->update([
                                            'min_prdcd' => $plubaru,
                                            'min_modify_by' => $_SESSION['usid'],
                                            'min_modify_dt' => DB::RAW("SYSDATE")
                                        ]);
                                }
                            }

                            DB::connection($_SESSION['connection'])->table('tbtr_promomd')
                                ->where('prmd_prdcd',$plulama)
                                ->where('prmd_kodeigr',$_SESSION['kdigr'])
                                ->update([
                                    'prmd_prdcd' => substr($plubaru,0,6).substr($plulama,-1),
                                    'prmd_modify_by' => $_SESSION['usid'],
                                    'prmd_modify_dt' => DB::RAW("SYSDATE")
                                ]);

                            $temp = DB::connection($_SESSION['connection'])->table('tbtr_konversiplu')
                                ->where('kvp_pluold',$plulama)
                                ->where('kvp_plunew',$plubaru)
                                ->where('kvp_kodeigr',$_SESSION['kdigr'])
                                ->get()->count();

                            if($temp == 0){
                                $konl = DB::connection($_SESSION['connection'])->table('tbmaster_prodmast')
                                    ->select('prd_frac')
                                    ->where('prd_prdcd',$plulama)
                                    ->where('prd_kodeigr',$_SESSION['kdigr'])
                                    ->where('prd_recordid',null)
                                    ->first()->prd_frac;

                                $konb = DB::connection($_SESSION['connection'])->table('tbmaster_prodmast')
                                    ->select('prd_frac')
                                    ->where('prd_prdcd',$plubaru)
                                    ->where('prd_kodeigr',$_SESSION['kdigr'])
                                    ->where('prd_recordid',null)
                                    ->first()->prd_frac;

                                DB::connection($_SESSION['connection'])->table('tbtr_konversiplu')
                                    ->insert([
                                        'kvp_kodeigr' => $_SESSION['kdigr'],
                                        'kvp_pluold' => $plulama,
                                        'kvp_plunew' => $plubaru,
                                        'kvp_kodetipe' => 'N',
                                        'kvp_tgl' => DB::RAW("SYSDATE"),
                                        'kvp_konversiold' => $konl,
                                        'kvp_konversinew' => $konb,
                                        'kvp_create_by' => $_SESSION['usid'],
                                        'kvp_create_dt' => DB::RAW("SYSDATE")
                                    ]);
                            }

                            $temp = DB::connection($_SESSION['connection'])->table('tbmaster_barangbaru')
                                ->where('pln_kodeigr',$_SESSION['kdigr'])
                                ->whereRaw("SUBSTR(pln_prdcd,1,6) = '".substr($plulama,0,6)."'")
                                ->get()->count();

                            if($temp > 0){
                                $temp = DB::connection($_SESSION['connection'])->table('tbhistory_barangbaru')
                                    ->whereRaw("SUBSTR(hpn_prdcd,1,6) = '".substr($plulama,0,6)."'")
                                    ->where('hpn_kodeigr',$_SESSION['kdigr'])
                                    ->get()->count();

                                if($temp == 0){
//                                    $data = DB::connection($_SESSION['connection'])->table('tbmaster_barangbaru')
//                                        ->where('pln_kodeigr',$_SESSION['kdigr'])
//                                        ->whereRaw("SUBSTR(pln_prdcd,1,6) = '".substr($plulama,0,6)."'")
//                                        ->first()->toArray();
//
//                                    DB::connection($_SESSION['connection'])->table('tbhistory_barangbaru')
//                                        ->insert($data);

                                    DB::connection($_SESSION['connection'])->statement("INSERT INTO TBHISTORY_BARANGBARU
                                                (HPN_KODEIGR, HPN_PRDCD, HPN_PKMTOKO, HPN_KODETAG,
                                                 HPN_TGLPENERIMAANBRG, HPN_TGLDAFTAR, HPN_CREATE_BY,
                                                 HPN_CREATE_DT, HPN_MODIFY_BY, HPN_MODIFY_DT)
                                                    (SELECT PLN_KODEIGR, PLN_PRDCD, PLN_PKMT, PLN_FLAGTAG, PLN_TGLBPB,
                                                            PLN_TGLAKTIF, PLN_CREATE_BY, PLN_CREATE_DT, PLN_MODIFY_BY,
                                                            PLN_MODIFY_DT
                                                       FROM TBMASTER_BARANGBARU
                                                      WHERE SUBSTR (PLN_PRDCD, 1, 6) = SUBSTR ('".$plulama."', 1, 6)
                                                        AND PLN_KODEIGR = '".$_SESSION['kdigr']."')");
                                }

                                DB::connection($_SESSION['connection'])->table('tbmaster_barangbaru')
                                    ->where('pln_kodeigr',$_SESSION['kdigr'])
                                    ->whereRaw("SUBSTR(pln_prdcd,1,6) = '".substr($plulama,0,6)."'")
                                    ->delete();
                            }
                            else{
                                $temp = DB::connection($_SESSION['connection'])->table('tbmaster_barangbaru')
                                    ->whereRaw("SUBSTR(pln_prdcd,1,6) = '".substr($plubaru,0,6)."'")
                                    ->where('pln_kodeigr',$_SESSION['kdigr'])
                                    ->get()->count();

                                if($temp > 0){
                                    $temp = DB::connection($_SESSION['connection'])->table('tbhistory_barangbaru')
                                        ->whereRaw("SUBSTR(hpn_prdcd,1,6) = '".substr($plubaru,0,6)."'")
                                        ->where('hpn_kodeigr',$_SESSION['kdigr'])
                                        ->get()->count();

                                    if($temp == 0){
                                        DB::connection($_SESSION['connection'])->statement("INSERT INTO TBHISTORY_BARANGBARU
                                            (HPN_KODEIGR, HPN_PRDCD, HPN_PKMTOKO, HPN_KODETAG,
                                             HPN_TGLPENERIMAANBRG, HPN_TGLDAFTAR, HPN_CREATE_BY,
                                             HPN_CREATE_DT, HPN_MODIFY_BY, HPN_MODIFY_DT)
                                    (SELECT PLN_KODEIGR, PLN_PRDCD, PLN_PKMT, PLN_FLAGTAG,
                                            PLN_TGLBPB, PLN_TGLAKTIF, PLN_CREATE_BY, PLN_CREATE_DT,
                                            PLN_MODIFY_BY, PLN_MODIFY_DT
                                       FROM TBMASTER_BARANGBARU
                                      WHERE SUBSTR (PLN_PRDCD, 1, 6) = SUBSTR ('".$plubaru."', 1, 6)
                                        AND PLN_KODEIGR = '".$_SESSION['kdigr']."')");
                                    }

                                    DB::connection($_SESSION['connection'])->table('tbmaster_barangbaru')
                                        ->whereRaw("SUBSTR(pln_prdcd,1,6) = '".substr($plubaru,0,6)."'")
                                        ->where('pln_kodeigr',$_SESSION['kdigr'])
                                        ->delete();
                                }
                            }

                            $data = DB::connection($_SESSION['connection'])->table('tbmaster_prodmast')
                                ->select('prd_lastcost','prd_avgcost')
                                ->where('prd_prdcd',$plubaru)
                                ->where('prd_kodeigr',$_SESSION['kdigr'])
                                ->where('prd_recordid',null)
                                ->first();

                            if($data){
                                $prdlast = $data->prd_lastcost;
                                $prdavg = $data->prd_avgcost;
                            }

                            if(self::nvl($prdlast,0) == 0 && self::nvl($prdavg,0) == 0){
                                $updplu = true;
                            }

                            $data = DB::connection($_SESSION['connection'])->table('tbmaster_prodmast')
                                ->select('prd_lastcost','prd_avgcost')
                                ->where('prd_prdcd',substr($plulama,0,6).'1')
                                ->where('prd_kodeigr',$_SESSION['kdigr'])
                                ->where('prd_recordid',null)
                                ->first();

                            if($data){
                                $prdlast = $data->prd_lastcost;
                                $prdavg = $data->prd_avgcost;
                            }

                            $records2 = DB::connection($_SESSION['connection'])->table('tbmaster_prodmast')
                                ->select('prd_prdcd','prd_unit','prd_frac')
                                ->whereRaw("SUBSTR(prd_prdcd,1,6) = '".substr($plubaru,0,6)."'")
                                ->where('prd_kodeigr',$_SESSION['kdigr'])
                                ->get();

                            foreach($records2 as $rec2){
                                if(substr($rec2->prd_prdcd, -1) == '1' || $rec2->prd_unit == 'KG'){
                                    DB::connection($_SESSION['connection'])->table('tbmaster_prodmast')
                                        ->where('prd_prdcd',$rec2->prd_prdcd)
                                        ->where('prd_kodeigr',$_SESSION['kdigr'])
                                        ->update([
                                            'prd_lastcost' => $prdlast,
                                            'prd_avgcost' => $prdavg
                                        ]);

                                    if($updplu){
                                        DB::connection($_SESSION['connection'])->table('tbtr_update_plu_md')
                                            ->insert([
                                                'upd_kodeigr' => $_SESSION['kdigr'],
                                                'upd_prdcd' => $rec2->prd_prdcd,
                                                'upd_harga' => $prdlast,
                                                'upd_atribute1' => 'MPP2',
                                                'upd_create_by' => $_SESSION['usid'],
                                                'upd_create_dt' => DB::RAW("SYSDATE")
                                            ]);
                                    }
                                }
                                else{
                                    DB::connection($_SESSION['connection'])->table('tbmaster_prodmast')
                                        ->where('prd_prdcd',$rec2->prd_prdcd)
                                        ->where('prd_kodeigr',$_SESSION['kdigr'])
                                        ->update([
                                            'prd_lastcost' => $prdlast * $rec2->prd_frac,
                                            'prd_avgcost' => $prdavg * $rec2->prd_frac
                                        ]);

                                    if($updplu){
                                        DB::connection($_SESSION['connection'])->table('tbtr_update_plu_md')
                                            ->insert([
                                                'upd_kodeigr' => $_SESSION['kdigr'],
                                                'upd_prdcd' => $rec2->prd_prdcd,
                                                'upd_harga' => $prdlast * $rec2->prd_frac,
                                                'upd_atribute1' => 'MPP2',
                                                'upd_create_by' => $_SESSION['usid'],
                                                'upd_create_dt' => DB::RAW("SYSDATE")
                                            ]);
                                    }
                                }
                            }
                        }
                    }
                }
            }

//            DB::connection($_SESSION['connection'])->commit();

            $_SESSION['pys_dataplulama'] = $dataplulama;
            $_SESSION['pys_dataplubaru'] = $dataplubaru;
            $_SESSION['pys_ukuran'] = $ukuran;

            $status = 'success';
            $title = 'Berhasil melakukan perubahan PLU!';
            $message = '';

            return compact(['status','title','message']);
        }
        catch(QueryException $e){
            DB::connection($_SESSION['connection'])->rollBack();

            $status = 'error';
            $title = 'Gagal melakukan perubahan PLU!';
            $message = $e->getMessage();

            return compact(['status','title','message']);
        }
    }

    public function laporan(){
        $plulama = $_SESSION['pys_dataplulama'];
        $plubaru = $_SESSION['pys_dataplubaru'];
        $ukuran = $_SESSION['pys_ukuran'];

        $perusahaan = DB::connection($_SESSION['connection'])->table('tbmaster_perusahaan')
            ->select('prs_namaperusahaan','prs_namacabang')
            ->first();

        $dompdf = new PDF();

        $pdf = PDF::loadview('BACKOFFICE.TRANSAKSI.PENYESUAIAN.perubahan-plu-pdf',compact(['perusahaan','plulama','plubaru','ukuran']));

        error_reporting(E_ALL ^ E_DEPRECATED);

        $pdf->output();
        $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);

        $canvas = $dompdf ->get_canvas();
        $canvas->page_text(507, 80.75, "{PAGE_NUM} dari {PAGE_COUNT}", null, 7, array(0, 0, 0));

        $dompdf = $pdf;

        return $dompdf->stream('Laporan Penyesuaian.pdf');
    }

    public function tes(){

    }

    public function nvl($value, $defaultvalue){
        if($value == null || $value == '')
            return $defaultvalue;
        else return $value;
    }
}
