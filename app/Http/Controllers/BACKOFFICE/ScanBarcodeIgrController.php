<?php

namespace App\Http\Controllers\BACKOFFICE;

use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller; use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;
use PDF;
use Yajra\DataTables\DataTables;

class ScanBarcodeIgrController extends Controller
{
    public function index(){
        return view('BACKOFFICE.scan-barcode-igr');
    }

    public function detail(Request $request){
        $prdcd = $request->plu;
        $barcode = $request->barcode;

        if($prdcd == null){
            $temp = DB::connection(Session::get('connection'))->table('tbmaster_barcode')
                ->where('brc_barcode','=',$barcode)
                ->first();

            if(!$temp){
                return [
                    'status' => 'error',
                    'title' => 'Kode Barcode tidak terdaftar!'
                ];
            }

            $prdcd = $temp->brc_prdcd;
        }
        else{
            $temp = DB::connection(Session::get('connection'))->table('tbmaster_prodmast')
                ->where('prd_prdcd','=',$prdcd)
                ->first();

            if(!$temp){
                return [
                    'status' => 'error',
                    'title' => 'PLU tidak terdaftar!'
                ];
            }
        }

        $data = DB::connection(Session::get('connection'))->select("SELECT prd_kodeigr, PRD_PRDCD, PRD_DESKRIPSIPANJANG, 'SATUAN ' || SUBSTR (PRD_PRDCD, -1, 1) SATUANJUAL, PRD_HRGJUAL, ROUND (PRD_HRGJUAL / PRD_FRAC) HRGJUAL1, PRD_UNIT || '/' || PRD_FRAC SATUAN, PRD_KODETAG, PRMD_HRGJUAL, ROUND (PRMD_HRGJUAL / PRD_FRAC) HRGPROMO1, NVL(ST_SALDOAKHIR,0) st_saldoakhir FROM TBMASTER_PRODMAST, TBMASTER_STOCK, (SELECT PRMD_PRDCD, PRMD_HRGJUAL, PRMD_TGLAWAL, PRMD_TGLAKHIR FROM TBTR_PROMOMD WHERE SYSDATE BETWEEN PRMD_TGLAWAL AND PRMD_TGLAKHIR) where PRMD_PRDCD(+) = PRD_PRDCD AND SUBSTR (ST_PRDCD(+), 1, 6) = SUBSTR (PRD_PRDCD, 1, 6) AND ST_KODEIGR(+) = PRD_KODEIGR AND ST_LOKASI(+) = '01' AND SUBSTR (PRD_PRDCD, 1, 6) = SUBSTR ('".$prdcd."', 1, 6) AND PRD_KODEIGR = '".Session::get('kdigr')."' order by prd_prdcd");

        $lokasi = DB::connection(Session::get('connection'))->select("select lks_koderak, lks_kodesubrak, lks_shelvingrak, lks_tiperak, lks_nourut from tbmaster_lokasi where lks_kodeigr='".Session::get('kdigr')."' and substr(lks_prdcd,1,6)=substr('".$prdcd."',1,6)");

        return compact(['data','lokasi','prdcd']);
    }
}
