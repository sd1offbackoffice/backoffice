<?php

namespace App\Http\Controllers\BTAS;

use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller; use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;
use PDF;
use Yajra\DataTables\DataTables;

class TitipController extends Controller
{
    public function index(){
        return view('BTAS.titip');
    }

    public function getData(Request $request){
        $data = new \stdClass();

        $temp = DB::connection(Session::get('connection'))->table('tbtr_jualdetail')
            ->where('trjd_kodeigr','=',Session::get('kdigr'))
            ->whereRaw("TO_CHAR(TRJD_TRANSACTIONDATE, 'DD/MM/YYYY') = '".$request->tgl."'")
            ->where('trjd_cashierstation','=',$request->station)
            ->where('trjd_create_by','=',$request->kasir)
            ->where('trjd_transactionno','=',$request->notrx)
            ->where('trjd_transactiontype','=','S')
            ->first();

        if(!$temp){
            $temp = DB::connection(Session::get('connection'))->table('tbtr_jualdetail_interface')
                ->where('trjd_kodeigr','=',Session::get('kdigr'))
                ->whereRaw("TO_CHAR(TRJD_TRANSACTIONDATE, 'DD/MM/YYYY') = '".$request->tgl."'")
                ->where('trjd_cashierstation','=',$request->station)
                ->where('trjd_create_by','=',$request->kasir)
                ->where('trjd_transactionno','=',$request->notrx)
                ->where('trjd_transactiontype','=','S')
                ->first();

            if(!$temp){
                return response()->json(['title' => 'Data Struk tidak ada!'],500);
            }
            else{
                $temp = DB::connection(Session::get('connection'))->table('tbtr_jualdetail_interface')
                    ->join('tbmaster_customer','cus_kodemember','=','trjd_cus_kodemember')
                    ->select('trjd_cus_kodemember','cus_namamember')
                    ->where('trjd_kodeigr','=',Session::get('kdigr'))
                    ->whereRaw("TO_CHAR(TRJD_TRANSACTIONDATE, 'DD/MM/YYYY') = '".$request->tgl."'")
                    ->where('trjd_cashierstation','=',$request->station)
                    ->where('trjd_create_by','=',$request->kasir)
                    ->where('trjd_transactionno','=',$request->notrx)
                    ->where('trjd_transactiontype','=','S')
                    ->first();

                $data->kode = $temp->trjd_cus_kodemember;
                $data->nama = $temp->cus_namamember;

                $temp = DB::connection(Session::get('connection'))->table('tbtr_sjas_h')
                    ->selectRaw("to_char(sjh_tglpenitipan, 'dd/mm/yyyy') sjh_tglpenitipan")
                    ->where('sjh_kodeigr','=',Session::get('kdigr'))
                    ->where('sjh_nostruk','=',$request->station.$request->kasir.$request->notrx)
                    ->whereRaw("TO_CHAR(sjh_tglstruk, 'DD/MM/YYYY') = '".$request->tgl."'")
                    ->where('sjh_kodecustomer','=',$data->kode)
                    ->first();

                if(!$temp){
                    $data->status = 'Belum dititipkan';
                    $data->button = 'true';
                }
                else{
                    $data->status = 'Sudah dititipkan -> '.$temp->sjh_tglpenitipan;
                    $data->button = 'false';
                }

                $data->detail = $this->showData($request);
            }
        }
        else{
            $temp = DB::connection(Session::get('connection'))->table('tbtr_jualdetail')
                ->join('tbmaster_customer','cus_kodemember','=','trjd_cus_kodemember')
                ->select('trjd_cus_kodemember','cus_namamember')
                ->where('trjd_kodeigr','=',Session::get('kdigr'))
                ->whereRaw("TO_CHAR(TRJD_TRANSACTIONDATE, 'DD/MM/YYYY') = '".$request->tgl."'")
                ->where('trjd_cashierstation','=',$request->station)
                ->where('trjd_create_by','=',$request->kasir)
                ->where('trjd_transactionno','=',$request->notrx)
                ->where('trjd_transactiontype','=','S')
                ->first();

            $data->kode = $temp->trjd_cus_kodemember;
            $data->nama = $temp->cus_namamember;

            $temp = DB::connection(Session::get('connection'))->table('tbtr_sjas_h')
                ->selectRaw("to_char(sjh_tglpenitipan, 'dd/mm/yyyy') sjh_tglpenitipan")
                ->where('sjh_kodeigr','=',Session::get('kdigr'))
                ->where('sjh_nostruk','=',$request->station.$request->kasir.$request->notrx)
                ->whereRaw("TO_CHAR(sjh_tglstruk, 'DD/MM/YYYY') = '".$request->tgl."'")
                ->where('sjh_kodecustomer','=',$data->kode)
                ->first();

            if(!$temp){
                $data->status = 'Belum dititipkan';
                $data->button = 'true';
            }
            else{
                $data->status = 'Sudah dititipkan -> '.$temp->sjh_tglpenitipan;
                $data->button = 'false';
            }

            $data->detail = $this->showData($request);
        }

        return response()->json($data);
    }

    public function showData(Request $request){
        $temp = DB::connection(Session::get('connection'))->table('tbtr_jualdetail')
            ->where('trjd_kodeigr','=',Session::get('kdigr'))
            ->whereRaw("TO_CHAR(TRJD_TRANSACTIONDATE, 'DD/MM/YYYY') = '".$request->tgl."'")
            ->where('trjd_cashierstation','=',$request->station)
            ->where('trjd_create_by','=',$request->kasir)
            ->where('trjd_transactionno','=',$request->notrx)
            ->where('trjd_transactiontype','=','S')
            ->first();

        if($temp){
            $data = DB::connection(Session::get('connection'))->select("SELECT trjd_seqno,
                      trjd_prdcd,
                      trjd_quantity,
                      trjd_unitprice,
                      trjd_nominalamt,
                      prd_deskripsipanjang,
                      prd_unit || '/' || prd_frac unit
                 FROM tbtr_jualdetail, tbmaster_prodmast
                WHERE     TRJD_KODEIGR = '".Session::get('kdigr')."'
                      AND TO_CHAR(TRJD_TRANSACTIONDATE, 'DD/MM/YYYY') = '".$request->tgl."'
                      AND TRJD_CASHIERSTATION = '".$request->station."'
                      AND TRJD_CREATE_BY = '".$request->kasir."'
                      AND TRJD_TRANSACTIONNO = '".$request->notrx."'
                      AND TRJD_TRANSACTIONTYPE = 'S'
                      AND prd_prdcd = trjd_prdcd
             ORDER BY trjd_seqno");

            foreach($data as $d){
                $temp = DB::connection(Session::get('connection'))->select("SELECT TRJD_QUANTITY
                        FROM TBTR_JUALHEADER, TBTR_JUALDETAIL
                        WHERE JH_TRANSACTIONTYPE = 'R'
                        AND JH_REFERENCECASHIERSTATION = '".$request->station."'
                        AND JH_REFERENCECASHIERID = '".$request->kasir."'
                        AND TO_CHAR(JH_REFERENCEDATE, 'DD/MM/YYYY') = '".$request->tgl."'
                        AND JH_REFERENCENO = '".$request->notrx."'
                        AND TRJD_TRANSACTIONNO = JH_TRANSACTIONNO
                        AND TRUNC (TRJD_TRANSACTIONDATE) = TRUNC (JH_TRANSACTIONDATE)
                        AND TRJD_CREATE_BY = JH_CASHIERID
                        AND TRJD_CASHIERSTATION = JH_CASHIERSTATION
                        AND TRJD_TRANSACTIONTYPE = 'R'
                        AND TRJD_PRDCD = '".$d->trjd_prdcd."'");

                if(count($temp) > 0){
                    $d->qtyrefund = $temp[0]->trjd_quantity;
                }
                else $d->qtyrefund = 0;

                $d->qtytitip = $d->trjd_quantity - $d->qtyrefund;
            }
        }
        else{
            $temp = DB::connection(Session::get('connection'))->table('tbtr_jualdetail_interface')
                ->where('trjd_kodeigr','=',Session::get('kdigr'))
                ->whereRaw("TO_CHAR(TRJD_TRANSACTIONDATE, 'DD/MM/YYYY') = '".$request->tgl."'")
                ->where('trjd_cashierstation','=',$request->station)
                ->where('trjd_create_by','=',$request->kasir)
                ->where('trjd_transactionno','=',$request->notrx)
                ->where('trjd_transactiontype','=','S')
                ->first();

            if($temp){
                $data = DB::connection(Session::get('connection'))->select("SELECT trjd_seqno,
                      trjd_prdcd,
                      trjd_quantity,
                      trjd_unitprice,
                      trjd_nominalamt,
                      prd_deskripsipanjang,
                      prd_unit || '/' || prd_frac unit
                 FROM tbtr_jualdetail_interface, tbmaster_prodmast
                WHERE     TRJD_KODEIGR = '".Session::get('kdigr')."'
                      AND TO_CHAR(TRJD_TRANSACTIONDATE, 'DD/MM/YYYY') = '".$request->tgl."'
                      AND TRJD_CASHIERSTATION = '".$request->station."'
                      AND TRJD_CREATE_BY = '".$request->kasir."'
                      AND TRJD_TRANSACTIONNO = '".$request->notrx."'
                      AND TRJD_TRANSACTIONTYPE = 'S'
                      AND prd_prdcd = trjd_prdcd
             ORDER BY trjd_seqno");

                foreach($data as $d){
                    $temp = DB::connection(Session::get('connection'))->select("SELECT TRJD_QUANTITY
                        FROM TBTR_JUALHEADER, TBTR_JUALDETAIL
                        WHERE JH_TRANSACTIONTYPE = 'R'
                        AND JH_REFERENCECASHIERSTATION = '".$request->station."'
                        AND JH_REFERENCECASHIERID = '".$request->kasir."'
                        AND TO_CHAR(JH_REFERENCEDATE, 'DD/MM/YYYY') = '".$request->tgl."'
                        AND JH_REFERENCENO = '".$request->notrx."'
                        AND TRJD_TRANSACTIONNO = JH_TRANSACTIONNO
                        AND TRUNC (TRJD_TRANSACTIONDATE) = TRUNC (JH_TRANSACTIONDATE)
                        AND TRJD_CREATE_BY = JH_CASHIERID
                        AND TRJD_CASHIERSTATION = JH_CASHIERSTATION
                        AND TRJD_TRANSACTIONTYPE = 'R'
                        AND TRJD_PRDCD = '".$d->trjd_prdcd."'");

                    if(count($temp) > 0){
                        $d->qtyrefund = $temp[0]->trjd_quantity;
                    }
                    else $d->qtyrefund = 0;

                    $d->qtytitip = $d->trjd_quantity - $d->qtyrefund;
                }
            }
        }

        return $data;
    }

    public function process(Request $request){
        $temp = DB::connection(Session::get('connection'))->table('tbtr_jualdetail')
            ->where('trjd_kodeigr','=',Session::get('kdigr'))
            ->whereRaw("TO_CHAR(TRJD_TRANSACTIONDATE, 'DD/MM/YYYY') = '".$request->tgl."'")
            ->where('trjd_cashierstation','=',$request->station)
            ->where('trjd_create_by','=',$request->kasir)
            ->where('trjd_transactionno','=',$request->notrx)
            ->where('trjd_transactiontype','=','S')
            ->first();

        if(!$temp) {
            $temp = DB::connection(Session::get('connection'))->table('tbtr_jualdetail_interface')
                ->where('trjd_kodeigr', '=', Session::get('kdigr'))
                ->whereRaw("TO_CHAR(TRJD_TRANSACTIONDATE, 'DD/MM/YYYY') = '" . $request->tgl . "'")
                ->where('trjd_cashierstation', '=', $request->station)
                ->where('trjd_create_by', '=', $request->kasir)
                ->where('trjd_transactionno', '=', $request->notrx)
                ->where('trjd_transactiontype', '=', 'S')
                ->first();

            if (!$temp) {
                return response()->json(['title' => 'Data Struk tidak ada!'], 500);
            }
            else{
                DB::connection(Session::get('connection'))->table('tbtr_sjas_h')
                    ->insert([
                        'sjh_kodeigr' => Session::get('kdigr'),
                        'sjh_nostruk' => $request->station.$request->kasir.$request->notrx,
                        'sjh_tglstruk' => DB::RAW("TO_DATE('".$request->tgl."','dd/mm/yyyy')"),
                        'sjh_kodecustomer' => $request->cus_kode,
                        'sjh_tglpenitipan' => DB::RAW("SYSDATE"),
                        'sjh_create_by' => Session::get('usid'),
                        'sjh_create_dt' => DB::RAW("SYSDATE")
                    ]);
            }
        }
        else{
            DB::connection(Session::get('connection'))->table('tbtr_sjas_h')
                ->insert([
                    'sjh_kodeigr' => Session::get('kdigr'),
                    'sjh_nostruk' => $request->station.$request->kasir.$request->notrx,
                    'sjh_tglstruk' => DB::RAW("TO_DATE('".$request->tgl."','dd/mm/yyyy')"),
                    'sjh_kodecustomer' => $request->cus_kode,
                    'sjh_tglpenitipan' => DB::RAW("SYSDATE"),
                    'sjh_create_by' => Session::get('usid'),
                    'sjh_create_dt' => DB::RAW("SYSDATE")
                ]);
        }
    }
}
