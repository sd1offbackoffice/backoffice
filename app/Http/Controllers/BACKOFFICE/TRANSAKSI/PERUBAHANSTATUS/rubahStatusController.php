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
        $chkPlano = $request->statusPlano;
        $gudangtoko = $request->gudangtoko;
        $keterangan = '';
        $userid = $_SESSION['usid'];
        $kodeigr = $_SESSION['kdigr'];
        $today  = date('Y-m-d H:i:s');
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

            $STOK_CUR = DB::table('TBMASTER_STOCK')
                ->selectRaw('ST_SALDOAKHIR')
                ->selectRaw('nvl(ST_AVGCOST, 0) ST_AVGCOST')
                ->where('ST_KODEIGR','=',$kodeigr)
                ->where('ST_PRDCD','=',$temp['mstd_prdcd'])
                ->get();

            if($PRDCD_CUR){
                $FRACPRD = $PRDCD_CUR->PRD_FRAC;
                $UNITPRD = $PRDCD_CUR->PRD_UNIT;
                $DIVPRD = $PRDCD_CUR->PRD_KODEDIVISI;
                $DEPPRD = $PRDCD_CUR->PRD_KODEDEPARTEMENT;
                $KATPRD = $PRDCD_CUR->PRD_KODEKATEGORIBARANG;
                $ACOSTPRD = $PRDCD_CUR->PRD_AVGCOST;
                $DESCPRD = $PRDCD_CUR->PRD_FRAC;
                if($UNITPRD == 'KG'){
                    $FRACPRD = 1;
                }
                if($temp['flagdisc1'] = 'B'){
                    $LOC1 = '01';
                }elseif ($temp['flagdisc1'] = 'T'){
                    $LOC1 = '02';
                }elseif ($temp['flagdisc1'] = 'R'){
                    $LOC1 = '03';
                }
                $temp = DB::table('TBMASTER_STOCK')
                    ->selectRaw('*')
                    ->where('ST_KODEIGR','=',$kodeigr)
                    ->where('ST_PRDCD','=',$temp['mstd_prdcd'])
                    ->where('ST_LOKASI','=',$LOC1)
                    ->first();
                if($temp){
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
                                $rec = DB::table('TBMASTER_LOKASI')
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
                                $rak = "RAK ".$rec->LKS_KODERAK.".".$rec->LKS_KODESUBRAK.".".$rec->LKS_TIPERAK.".".$rec->LKS_SHELVINGRAK.".".$rec->LKS_NOURUT.", ";
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
                    
                }
            }
        }
    }
}
