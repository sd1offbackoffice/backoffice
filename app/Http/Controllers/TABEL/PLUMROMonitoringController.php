<?php

namespace App\Http\Controllers\TABEL;

use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;
use PDF;
use Yajra\DataTables\DataTables;

class PLUMROMonitoringController extends Controller
{
    public function index(){
        return view('TABEL.plu-mro-monitoring');
    }

    public function getLovMonitoring(){
        $data = DB::connection($_SESSION['connection'])->table('tbtr_monitoringplu')
            ->selectRaw("mpl_kodemonitoring kode, mpl_namamonitoring nama")
            ->whereNotNull('mpl_kodemonitoring')
            ->distinct()
            ->get();

        return DataTables::of($data)->make(true);
    }

    public function getMonitoring(Request $request){
        $data = DB::connection($_SESSION['connection'])->table('tbtr_monitoringplu')
            ->select('mpl_namamonitoring')
            ->where('mpl_kodeigr','=',$_SESSION['kdigr'])
            ->where('mpl_kodemonitoring','=',$request->kode)
            ->first();

        if(!$data){
            return response()->json([
                'message' => 'Kode monitoring tidak terdaftar!'
            ], 500);
        }
        else{
            return response()->json([
                'nama' => $data->mpl_namamonitoring
            ], 200);
        }
    }

    public function getData(Request $request){
        $data = DB::connection($_SESSION['connection'])->select("SELECT mpl_prdcd plu, SUBSTR(PRD_DESKRIPSIPANJANG,1,60) DESKRIPSI, PRD_UNIT||'/'||PRD_FRAC SATUAN, MPT_MAXQTY max_ctn, (mpt_maxqty * prd_frac) max_pcs
					FROM TBMASTER_PRODMAST, tbtr_monitoringplu, tbmaster_maxpalet
					WHERE PRD_PRDCD(+) = mpl_prdcd AND MPT_PRDCD(+) = PRD_PRDCD
					AND mpl_kodemonitoring = '".$request->kode."'
					ORDER BY mpl_prdcd");

        return DataTables::of($data)->make(true);
    }

    public function print(Request $request){
        $perusahaan = DB::connection($_SESSION['connection'])->table("tbmaster_perusahaan")->first();

        if($request->orderBy == 'plu')
            $orderBy = 'ORDER BY MPL_PRDCD ASC';
        else $orderBy = 'ORDER BY PRD_DESC ASC';

        $data = DB::connection($_SESSION['connection'])->select("SELECT DISTINCT MPL_PRDCD, PRD_DESC, PRD_KODETAG, SATUAN,
                HRG_1, HRG_D, HRG_C, HRG_B, HRG_E, HRG_A, ST_SALDOAKHIR, ' ' KET
                FROM TBTR_MONITORINGPLU, (SELECT ST_PRDCD, ST_SALDOAKHIR FROM TBMASTER_STOCK WHERE ST_LOKASI=01 ),
                (
                SELECT SUBSTR(PRD_PRDCD,1,6)||'0' PRDCD, PRD_DESC, PRD_KODETAG, SATUAN, SUM(HRG_1) HRG_1,
                       SUM(HRG_D)HRG_D, SUM(HRG_C) HRG_C, SUM(HRG_B) HRG_B, SUM(HRG_E) HRG_E, SUM(HRG_A) HRG_A
                FROM(
                     SELECT PRD_PRDCD, PRD_DESC, PRD_KODETAG,  PRD_KODESATUANJUAL2||'/'||PRD_ISISATUANJUAL2 SATUAN,
                           CASE WHEN SUBSTR(PRD_PRDCD,-1,1)='1' THEN HARGA ELSE 0 END HRG_1,
                           CASE WHEN SUBSTR(PRD_PRDCD,-1,1) IN('2','3') THEN HARGA*PRD_MINJUAL ELSE 0 END HRG_D,
                           CASE WHEN SUBSTR(PRD_PRDCD,-1,1) IN('2','3') THEN HARGA ELSE 0 END HRG_C,
                           CASE WHEN SUBSTR(PRD_PRDCD,-1,1) IN('2','3') THEN PRD_MINJUAL ELSE 0 END HRG_B,
                           CASE WHEN SUBSTR(PRD_PRDCD,-1,1)='0' THEN HARGA/PRD_FRAC ELSE 0 END HRG_E,
                           CASE WHEN SUBSTR(PRD_PRDCD,-1,1)='0' THEN HARGA ELSE 0 END HRG_A
                     FROM (SELECT PRD_PRDCD, CASE WHEN PRD_FRAC=0 THEN 1 ELSE PRD_FRAC END PRD_FRAC, PRD_UNIT, SUBSTR(PRD_DESKRIPSIPANJANG,1,50) PRD_DESC, PRD_KODETAG, PRD_HRGJUAL, PRD_MINJUAL,
                                 PRD_KODESATUANJUAL2, PRD_ISISATUANJUAL2, PROMO, HRGPROMO, CASE WHEN PROMO='Y' THEN HRGPROMO ELSE PRD_HRGJUAL END HARGA
                          FROM TBMASTER_PRODMAST,( SELECT 'Y' PROMO, PRMD_PRDCD, PRMD_HRGJUAL HRGPROMO
                                                   FROM TBTR_PROMOMD, TBMASTER_PRODMAST
                                                   WHERE PRMD_PRDCD = PRD_PRDCD
                                                 )
                          WHERE PRMD_PRDCD(+) = PRD_PRDCD
                            AND NVL(PRD_KODETAG,'123') NOT IN ('X','Z')
                         )
                    )
                GROUP BY SUBSTR(PRD_PRDCD,1,6), PRD_DESC, PRD_KODETAG, SATUAN
                )
                WHERE MPL_KODEIGR = '".$_SESSION['kdigr']."'
                AND PRDCD(+) = MPL_PRDCD
                AND ST_PRDCD(+) = MPL_PRDCD
                AND MPL_KODEMONITORING = '".$request->mon."'
                ".$orderBy);

//        dd($data);

        $dompdf = new PDF();

        $pdf = PDF::loadview('TABEL.plu-mro-monitoring-pdf',compact(['perusahaan','data']));

        error_reporting(E_ALL ^ E_DEPRECATED);

        $pdf->output();
        $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);

        $canvas = $dompdf ->get_canvas();
        $canvas->page_text(507, 77.75, "{PAGE_NUM} dari {PAGE_COUNT}", null, 7, array(0, 0, 0));

        $dompdf = $pdf;

        return $dompdf->stream('Daftar Harga Jual Barang per Tanggal '.date("d-m-Y").'.pdf');
    }

    public function deleteData(Request $request){
        return response()->json([
            'message' => 'Data berhasil dihapus!'
        ]);
    }
}
