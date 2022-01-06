<?php

namespace App\Http\Controllers\FRONTOFFICE;

use App\Http\Controllers\Auth\loginController;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller; use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Mockery\Exception;
use PDF;
use Yajra\DataTables\DataTables;

class StockBarangKosongPerPeriodeDSIController extends Controller
{
    public function index(){
        $monitoringPLU = DB::connection(Session::get('connection'))
            ->table('tbtr_monitoringplu')
            ->select('mpl_kodemonitoring','mpl_namamonitoring')
            ->whereNotNull('mpl_kodemonitoring')
            ->groupBy(['mpl_kodemonitoring','mpl_namamonitoring'])
            ->orderBy('mpl_namamonitoring')
            ->get();

        return view('FRONTOFFICE.stock-barang-kosong-per-periode-dsi')
            ->with(compact(['monitoringPLU']));
    }

    public static function viewReport(Request $request){
        $tgl1 = $request->tgl1;
        $tgl2 = $request->tgl2;
        $monitoringPLU = $request->monitoringPLU;

        $perusahaan = DB::connection(Session::get('connection'))
            ->table("tbmaster_perusahaan")
            ->first();

//        return $query;

        $data = DB::connection(Session::get('connection'))
            ->select("select distinct STH_KODEIGR,to_char(STH_PERIODE,'dd/mm/yyyy') periode, sth_periode,
                              STH_PRDCD,
                              prd_deskripsipanjang desk,
                              prd_unit || '/' || prd_frac frac,
                              prd_hrgjual / prd_frac hrgjual,
                              STH_LOKASI,
                              STH_SALDOAWAL,
                              STH_SALDOAKHIR,
                              STH_AVGCOST
                              from tbtr_stockharian
                              join tbmaster_prodmast on sth_prdcd = prd_prdcd and sth_kodeigr = prd_kodeigr
                              join tbtr_monitoringplu on mpl_kodeigr = sth_kodeigr and mpl_prdcd = sth_prdcd
                              where sth_kodeigr = '".Session::get('kdigr')."'
                              and sth_lokasi = '01'
                              and sth_periode BETWEEN to_date('".$tgl1."','dd/mm/yyyy')
                              AND to_date('".$tgl2."','dd/mm/yyyy')
                              AND mpl_kodemonitoring = '".$monitoringPLU."'
                              --and sth_prdcd = '1394730'
                              order by sth_prdcd, sth_periode asc, sth_lokasi");

//        dd($data);

        $finalData = [];
        foreach($data as $d){
            $tempData = $d;

            $temp = DB::connection(Session::get('connection'))
                ->table('tbmaster_kkpkm')
                ->select('pkm_pkmt')
                ->where('pkm_kodeigr','=',$d->sth_kodeigr)
                ->where('pkm_prdcd','=',$d->sth_prdcd)
                ->orderBy('pkm_modify_dt','desc')
                ->first();

            if($temp){
                $tempData->v_qtypkm = $temp->pkm_pkmt;
            }

            if($d->sth_lokasi == '01'){
//                $tempData->v_tanggal_awal = LAST_DAY (ADD_MONTHS (TRUNC (rec.sth_periode), -1)) + 1;

                $temp = DB::connection('igrcrm')
                    ->table('tb_avg_3_bulan')
                    ->select('tba_avg_qty')
                    ->whereRaw("tba_periode = LAST_DAY (ADD_MONTHS (TRUNC (to_date('".$d->periode."','dd/mm/yyyy')), -1)) + 1")
                    ->where('tba_kodeigr','=',$d->sth_kodeigr)
                    ->where('tba_prdcd','=',$d->sth_prdcd)
                    ->first();

                if($temp){
                    $tempData->v_avg_qty = $temp->tba_avg_qty;
                }
                else $tempData->v_avg_qty = null;
            }
            else $tempData->v_avg_qty = null;

            $temp = DB::connection(Session::get('connection'))
                ->table('tbtr_po_d')
                ->selectRaw("tpod_tglpo, sum(tpod_qtypo) qtypo, count(tpod_prdcd) frqpo")
                ->where('tpod_kodeigr','=',$d->sth_kodeigr)
                ->where('tpod_tglpo','=',Carbon::createFromFormat('d/m/Y',$d->periode))
                ->where('tpod_prdcd','=',$d->sth_prdcd)
                ->groupBy('tpod_tglpo')
                ->first();

            if($temp){
                $tempData->qtypo = $temp->qtypo;
                $tempData->frqpo = $temp->frqpo;
            }
            else{
                $tempData->qtypo = 0;
                $tempData->frqpo = 0;
            }

            $temp = DB::connection(Session::get('connection'))
                ->table('tbtr_mstran_d')
                ->selectRaw("mstd_tgldoc, sum(mstd_qty) frqbpb, count(mstd_prdcd) qtybpb")
                ->where('mstd_kodeigr','=',$d->sth_kodeigr)
                ->where('mstd_tgldoc','=',Carbon::createFromFormat('d/m/Y',$d->periode))
                ->where('mstd_prdcd','=',$d->sth_prdcd)
                ->groupBy('mstd_tgldoc')
                ->first();

            if($temp){
                $tempData->qtybpb = $temp->qtybpb;
                $tempData->frqbpb = $temp->frqbpb;
            }
            else{
                $tempData->qtybpb = 0;
                $tempData->frqbpb = 0;
            }

            $jmlhari = Carbon::createFromFormat('d/m/Y',$tgl1)->daysInMonth;

            $tempData->avgdsi = is_null($tempData->v_avg_qty) ? null : $tempData->v_avg_qty / $jmlhari;


//            if(MSTR_QTY /
//                 if( PO_QTYPO>0 ){
//                     PO_QTYPO
//                 }else{
//                     -1
//                 }
//            *100 < 0){
//                0
//}else{
//                MSTR_QTY / if(PO_QTYPO> 0){
//                    PO_QTYPO
//}else{
//                    -1
//}
//}
            $tempData->sl = ($tempData->qtybpb / ($tempData->qtypo > 0 ? $tempData->qtypo : -1) * 100 < 0) ? 0 : ($tempData->qtybpb / ($tempData->qtypo > 0 ? $tempData->qtypo : -1));

            $stock = DB::connection(Session::get('connection'))
                ->table('tbmaster_stock')
                ->select('st_saldoawal')
                ->where('st_kodeigr','=',$d->sth_kodeigr)
                ->where('st_prdcd','=',$d->sth_prdcd)
                ->first();

            if($stock){
//                (IF(ST_SALDOAWAL<=ST_AVG_DSI*DSI,1,0)*ROUND(ST_AVG_DSI*DSI))-
//IF(ST_SALDOAWAL <= (ST_AVG_DSI*DSI),IF(ST_SALDOAWAL<0,0,ST_SALDOAWAL),0)
                $tempData->qty = ((($stock->st_saldoawal <= $tempData->avgdsi * $request->dsi) ? 1 : 0) * round($tempData->avgdsi * $request->dsi)) - ($stock->st_saldoawal <= ($tempData->avgdsi * $request->dsi) ? ($stock->st_saldoawal < 0 ? 0 : $stock->st_saldoawal) : 0);


//                ((IF(ST_SALDOAWAL<=TBA_AVG_DSI*DSI,1,0) * round((TBA_AVG_DSI*DSI),0.01)) -
                //IF(ST_SALDOAWAL <= (TBA_AVG_DSI*DSI),
                //IF(ST_SALDOAWAL<0,0,ST_SALDOAWAL),0))*(PRD_HRGJUAL/PRD_FRAC)
                $tempData->rupiah = ((($stock->st_saldoawal <= $tempData->v_avg_qty * $request->dsi) ? 1 : 0) * round($tempData->avgdsi * $request->dsi)) - ($stock->st_saldoawal <= ($tempData->avgdsi * $request->dsi) ? ($stock->st_saldoawal < 0 ? 0 : $stock->st_saldoawal) : 0) * $tempData->hrgjual;
            }
            else{
                $tempData->qty = null;
                $tempData->rupiah = null;
            }

            $finalData[] = $tempData;
        }

        if(count($finalData) == 0){
            return response()->json([
                'customData' => null,
                'arrTanggal' => [],
                'message' => 'Data tidak ditemukan!'
            ], 500);
        }
        else{
            $finalData = json_decode(json_encode($finalData), true);

            $arrTahun = [];
            $arrBulan = [];
            $arrTanggal = [];
            $qtyTahun = 0;
            $qtyBulan = 0;
            $tempTahun = null;
            $tempBulan = null;
            $tempTgl = null;
            $tempPLU = null;
            $tempData = null;
            $customData = [];
            $skip = false;
            foreach($finalData as $f){
                if($tempPLU != $f['sth_prdcd']){
                    if($tempPLU != null){
                        $customData[] = $tempData;
                        $skip = true;
                    }

                    $tempData = $f;
                    $tempPLU = $f['sth_prdcd'];
                }

                if(!$skip){
                    if($tempTahun != substr($f['periode'], -4)){
                        if($tempTahun != null){
                            $arrTahun[count($arrTahun) - 1]['qty'] = $qtyTahun;
                        }
                        $tempTahun = substr($f['periode'], -4);
                        $arrTahun[] = [
                            'tahun' => substr($f['periode'], -4),
                            'qty' => 0
                        ];

                        $qtyTahun = 0;
                    }

                    if($tempBulan != substr($f['periode'], 3,2)){
                        if($tempBulan != null){
                            $arrBulan[count($arrBulan) - 1]['qty'] = $qtyBulan;
                        }
                        $tempBulan = substr($f['periode'], 3,2);
                        $arrBulan[] = [
                            'bulan' => Carbon::createFromFormat('d/m/Y', $f['periode'])->format('F'),
                            'qty' => 0
                        ];

                        $qtyBulan = 0;
                    }


                    $qtyTahun++;
                    $qtyBulan++;
                }

                if(!in_array($f['periode'], $arrTanggal)){
                    $arrTanggal[] = $f['periode'];
                }

                $tempData[$f['periode']] = $f['sth_saldoawal'];
            }
            $arrTahun[count($arrTahun) - 1]['qty'] = $qtyTahun;
            $arrBulan[count($arrBulan) - 1]['qty'] = $qtyBulan;

            $customData[] = $tempData;

//        dd($arrBulan);

//        return DataTables::of($data)->make(true);
            return response()->json(compact(['arrTahun','arrBulan','arrTanggal','customData']));
        }
    }

    public function exportPDF(Request $request){
        $tgl1 = $request->tgl1;
        $tgl2 = $request->tgl2;
        $monitoringPLU = $request->monitoringPLU;

        $perusahaan = DB::connection(Session::get('connection'))
            ->table('tbmaster_perusahaan')
            ->first();

        $monitoring = DB::connection(Session::get('connection'))
            ->table('tbtr_monitoringplu')
            ->select('mpl_namamonitoring')
            ->where('mpl_kodemonitoring','=',$monitoringPLU)
            ->first()->mpl_namamonitoring;

        $data = json_decode(self::viewReport($request)->getContent());

        if($data->customData == null){
            return view('FRONTOFFICE.stock-barang-kosong-per-periode-dsi-pdf')
                ->with([
                    'perusahaan' => $perusahaan,
                    'data' => [],
                    'arrTahun' => [],
                    'arrBulan' => [],
                    'arrTanggal' => [],
                    'tgl1' => $tgl1,
                    'tgl1' => $tgl1,
                    'tgl2' => $tgl2,
                    'monitoring' => $monitoring
                ]);
        }
        else{
            $arrTahun = $data->arrTahun;
            $arrBulan = $data->arrBulan;
            $arrTanggal = $data->arrTanggal;
            $data = json_decode(json_encode($data->customData),true);

            return view('FRONTOFFICE.stock-barang-kosong-per-periode-dsi-pdf',compact(['perusahaan','tgl1','tgl2','monitoring','arrTahun','arrBulan','arrTanggal','data']));
        }
    }

    public function exportCSV(Request $request){
        $data = json_decode(self::viewReport($request)->getContent());

        $filename = 'Stock Barang Kosong Per Periode DSI.csv';

        $columnHeader = [
            'PRDCD',
            'DESKRIPSI',
            'FRAC',
            'PO - FRQ',
            'PO - QTY',
            'BPB - FRQ',
            'BPB - QTY',
            'SL',
            'AVG',
        ];

        $columnHeader = array_merge($columnHeader,$data->arrTanggal);

        $columnHeader = array_merge($columnHeader,[
            'AVG/DSI',
            'QTY',
            'HRG JUAL',
            'RUPIAH'
        ]);

//        dd($columnHeader);

        $customData = json_decode(json_encode($data->customData),true);

//        dd($customData);

        $linebuffs = array();
        if($customData != null){
            foreach ($customData as $d) {
                $tempdata = [
                    $d['sth_prdcd'],
                    $d['desk'],
                    $d['frac'],
                    number_format($d['frqpo'],0),
                    number_format($d['qtypo'],0),
                    number_format($d['frqbpb'],0),
                    number_format($d['qtybpb'],0),
                    number_format($d['sl'],0),
                    number_format($d['v_avg_qty'],0)
                ];

                foreach($data->arrTanggal as $tgl){
                    $tempdata[] = number_format($d[$tgl], 0);
                }

                $tempdata[] = number_format($d['avgdsi'],0);
                $tempdata[] = number_format($d['qty'],0);
                $tempdata[] = number_format($d['hrgjual'],0);
                $tempdata[] = number_format($d['rupiah'],0);

                array_push($linebuffs, $tempdata);
            }
        }

        $headers = [
            "Content-type" => "text/csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];
        $file = fopen($filename, 'w');

        fputcsv($file, $columnHeader, '|');
        foreach ($linebuffs as $linebuff) {
            fputcsv($file, $linebuff, '|');
        }
        fclose($file);

        return response()->download(public_path($filename))->deleteFileAfterSend(true);
    }
}
