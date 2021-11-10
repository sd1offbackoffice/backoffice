<?php

namespace App\Http\Controllers\BTAS;

use App\Http\Controllers\Auth\loginController;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;
use PDF;
use Yajra\DataTables\DataTables;

class SJASController extends Controller
{
    public function index(){
        return view('BTAS.sjas');
    }

    public function getLovCustomer(){
        $data = DB::connection($_SESSION['connection'])->select("SELECT SUBSTR(SJH_NOSTRUK,1,2) STAT, SUBSTR(SJH_NOSTRUK,3,3) KASIR, SUBSTR(SJH_NOSTRUK,6,5) NO, SJH_TGLSTRUK tglstruk, TO_CHAR(SJH_TGLSTRUK, 'DD/MM/YYYY') SJH_TGLSTRUK, SJH_KODECUSTOMER, TO_CHAR(SJH_TGLPENITIPAN, 'DD/MM/YYYY') SJH_TGLPENITIPAN, SJH_NOSJAS, TO_CHAR(SJH_TGLSJAS, 'DD/MM/YYYY') SJH_TGLSJAS, CUS_NAMAMEMBER, SJH_FLAGSELESAI
        FROM TBTR_SJAS_H, TBMASTER_CUSTOMER
        WHERE SJH_KODEIGR = '".$_SESSION['kdigr']."'
        AND CUS_KODEMEMBER = SJH_KODECUSTOMER
        ORDER BY tglstruk, SJH_KODECUSTOMER, SJH_NOSTRUK");

        return DataTables::of($data)->make(true);
    }

    public function getData(Request $request){
        $temp = DB::connection($_SESSION['connection'])->table('tbmaster_customer')
            ->select('cus_namamember')
            ->where('cus_kodemember','=',$request->cus_kode)
            ->first();

        $data = new \stdClass();

        if(!$temp){
            return response()->json([
                'title' => 'Data customer tidak ditemukan!',
            ],500);
        }
        else $data->cus_nama = $temp->cus_namamember;

        $temp = DB::connection($_SESSION['connection'])->table('tbtr_sjas_h')
            ->selectRaw("SJH_NOSJAS, TO_CHAR(SJH_TGLSJAS,'DD/MM/YYYY') SJH_TGLSJAS,
               SJH_FREKTAHAPAN, TO_CHAR(SJH_TGLSTRUK,'DD/MM/YYYY') SJH_TGLSTRUK,
               SUBSTR (SJH_NOSTRUK, 1, 2) station, SUBSTR (SJH_NOSTRUK, 3, 3) kasir,
               SUBSTR (SJH_NOSTRUK, 6, 5) no, SJH_FLAGSELESAI")
            ->where('sjh_kodeigr','=',$_SESSION['kdigr'])
            ->where('sjh_kodecustomer','=',$request->cus_kode)
            ->whereRaw("sjh_nostruk = '".$request->station."'||'".$request->kasir."'||'".$request->nostruk."'")
            ->whereRaw("to_char(sjh_tglstruk,'dd/mm/yyyy') = '".$request->tglstruk."'")
            ->first();

        if(!$temp){
            return response()->json([
                'title' => 'Tidak ada data yang dititipkan!',
            ],500);
        }
        else{
            $data->nosj = $temp->sjh_nosjas;
            $data->tglsj = $temp->sjh_tglsjas;
            $data->tahap = $temp->sjh_frektahapan;
            $data->tglstruk = $temp->sjh_tglstruk;
            $data->station = $temp->station;
            $data->kasir = $temp->kasir;
            $data->no = $temp->no;
            $data->flagselesai = $temp->sjh_flagselesai;
            $data->tgltitip = date_format(Carbon::now(), 'd/m/Y');
        }

        if($data->flagselesai == 'Y'){
            $data->status = 'SELESAI';
        }
        else{
            $data->status = '';
            $data->tahap += 1;
        }

        if(Carbon::now()->subDays(2) <= Carbon::createFromFormat('d/m/Y',$data->tglstruk)){
            $data->flagoto = '0';
        }
        else $data->flagoto = '1';

        $detail = DB::connection($_SESSION['connection'])->select("SELECT TRJD_SEQNO, TRJD_PRDCD, PRD_DESKRIPSIPANJANG,TRJD_QUANTITY, PRD_UNIT || '/' || PRD_FRAC unit
            FROM TBTR_JUALDETAIL, TBMASTER_PRODMAST
            WHERE TRJD_KODEIGR = PRD_KODEIGR
            AND TRJD_PRDCD = PRD_PRDCD
            AND TRJD_KODEIGR = '".$_SESSION['kdigr']."'
            AND TO_CHAR(TRJD_TRANSACTIONDATE,'dd/mm/yyyy') = '".$data->tglstruk."'
            AND TRJD_CASHIERSTATION = '".$data->station."'
            AND TRJD_CREATE_BY = '".$data->kasir."'
            AND TRJD_TRANSACTIONNO = '".$data->no."'
            AND TRJD_TRANSACTIONTYPE = 'S'
            ORDER BY TRJD_SEQNO");

        foreach($detail as $d){
            $temp = DB::connection($_SESSION['connection'])->selectOne("SELECT *
                      FROM TBTR_JUALHEADER, TBTR_JUALDETAIL
                     WHERE JH_TRANSACTIONTYPE = 'R'
                            AND JH_REFERENCECASHIERSTATION = '".$data->station."'
                            AND JH_REFERENCECASHIERID = '".$data->kasir."'
                            AND TO_CHAR(JH_REFERENCEDATE,'dd/mm/yyyy') = '".$data->tglstruk."'
                            AND JH_REFERENCENO = '".$data->no."'
                            AND TRJD_TRANSACTIONNO = JH_TRANSACTIONNO
                            AND TRUNC (TRJD_TRANSACTIONDATE) = TRUNC (JH_TRANSACTIONDATE)
                            AND TRJD_CREATE_BY = JH_CASHIERID
                            AND TRJD_CASHIERSTATION = JH_CASHIERSTATION
                            AND TRJD_TRANSACTIONTYPE = 'R'
                            AND TRJD_PRDCD = '".$d->trjd_prdcd."'");

            if($temp){
                $d->qtyrefund = $temp->trjd_quantity;
            }
            else $d->qtyrefund = 0;

            $d->qtytitip = $d->trjd_quantity - $d->qtyrefund;

            $temp = DB::connection($_SESSION['connection'])->selectOne("SELECT SUM(NVL (SJD_QTYSJAS, 0)) jml
                      FROM TBTR_SJAS_D
                     WHERE SJD_KODEIGR = '".$_SESSION['kdigr']."'
                       AND SJD_NOSJAS = '".$data->nosj."'
                       AND SJD_KODECUSTOMER = '".$request->cus_kode."'
                       AND SJD_PRDCD = '".$d->trjd_prdcd."'");

            if(!$temp){
                $d->qtyok = 0;
            }
            else{
                $d->qtyok = $temp->jml;
            }

            $d->qtysisa = $d->qtytitip - $d->qtyok;
            $d->qtysisaall = $d->qtytitip - $d->qtyok;

            if($request->paramTHP == 'Y'){
                $temp = DB::connection($_SESSION['connection'])->selectOne("SELECT NVL(SJD_QTYSJAS, 0) qty
                          FROM TBTR_SJAS_D
                         WHERE SJD_KODEIGR = '".$_SESSION['kdigr']."'
                           AND SJD_NOSJAS = '".$data->nosj."'
                           AND SJD_KODECUSTOMER = '".$request->cus_kode."'
                           AND SJD_PRDCD = '".$d->trjd_prdcd."'
                           AND SJD_TAHAPAN = '".$request->tahap."'");

                if(!$temp){
                    $d->qtyambil = $d->qtysisa;
                }
                else $d->qtyambil = $temp->qty;
            }
            else $d->qtyambil = $d->qtysisa;

            $d->qtysisa -= $d->qtyambil;

//            $d->qtysisa = $d->qtysisaall;
        }

        return compact(['data','detail']);
    }

    public function authUser(Request $request){
        $temp = DB::connection($_SESSION['connection'])->table('tbmaster_user')
            ->where('userid','=',strtoupper($request->username))
            ->where('userpassword','=',strtoupper($request->password))
            ->where('userlevel','=','1')
            ->first();

        if(!$temp)
            return 'false';
        return 'true';
    }

    public function save(Request $request){
        try{
            DB::connection($_SESSION['connection'])->beginTransaction();

            $temp = DB::connection($_SESSION['connection'])->selectOne("SELECT SJH_NOSJAS, to_char(SJH_TGLSJAS, 'dd/mm/yyyy') SJH_TGLSJAS, SJH_FREKTAHAPAN
                    FROM TBTR_SJAS_H
                    WHERE SJH_KODEIGR = '".$_SESSION['kdigr']."'
                    AND SJH_NOSTRUK = '".$request->nostruk."'
                    AND SJH_TGLSTRUK = to_date('".$request->tglstruk."','dd/mm/yyyy')
                    AND SJH_KODECUSTOMER = '".$request->kodecustomer."'");

            if($temp->sjh_nosjas == null){
                $c = loginController::getConnectionProcedure();
                $s = oci_parse($c, "BEGIN :ret := F_IGR_GET_NOMOR('".$_SESSION['kdigr']."','SJS','Surat Jalan Atas Struk', 'S'||TO_CHAR(SYSDATE, 'yy'),4,TRUE); END;");
                oci_bind_by_name($s, ':ret', $nosj, 32);
                oci_execute($s);

                $tglsj = DB::RAW("SYSDATE");
            }
            else{
                $nosj = $temp->sjh_nosjas;
                $tglsj = DB::RAW("to_date('".$temp->sjh_tglsjas."','dd/mm/yyyy')");
            }

            if($temp->sjh_frektahapan == null)
                $tahapan = 1;
            else $tahapan = intval($temp->sjh_frektahapan) + 1;

            $insert = [];
            foreach($request->data as $d){
                $ins = [];
                $ins['sjd_kodeigr'] = $_SESSION['kdigr'];
                $ins['sjd_nosjas'] = $nosj;
                $ins['sjd_tglsjas'] = $tglsj;
                $ins['sjd_kodecustomer'] = $request->kodecustomer;
                $ins['sjd_tahapan'] = $tahapan;
                $ins['sjd_tgltahapan'] = DB::RAW("SYSDATE");
                $ins['sjd_prdcd'] = $d['prdcd'];
                $ins['sjd_seqno'] = $d['seqno'];
                $ins['sjd_qtystruk'] = $d['qtytitip'];
                $ins['sjd_qtysjas'] = $d['qtyambil'];
                $ins['sjd_flagcetak'] = '1';
                $ins['sjd_create_by'] = $_SESSION['usid'];
                $ins['sjd_create_dt'] = DB::RAW("SYSDATE");

                DB::connection($_SESSION['connection'])->table('tbtr_sjas_d')
                    ->insert($ins);
//                $insert[] = $ins;
            }

            DB::connection($_SESSION['connection'])->table('tbtr_sjas_d')
                ->insert($insert);

            if($request->sumsisa == 0){
                $fok = 'Y';
            }
            else $fok = null;

            DB::connection($_SESSION['connection'])->table('tbtr_sjas_h')
                ->where('sjh_kodeigr','=',$_SESSION['kdigr'])
                ->where('sjh_nostruk','=',$request->nostruk)
                ->where('sjh_tglstruk','=',DB::RAW("to_date('".$request->tglstruk."','dd/mm/yyyy')"))
                ->where('sjh_kodecustomer','=',$request->kodecustomer)
                ->update([
                    'sjh_nosjas' => $nosj,
                    'sjh_tglsjas' => $tglsj,
                    'sjh_flagselesai' => $fok,
                    'sjh_frektahapan' => $tahapan,
                    'sjh_modify_by' => $_SESSION['usid'],
                    'sjh_modify_dt' => DB::RAW("SYSDATE")
                ]);

            DB::connection($_SESSION['connection'])->commit();

            return response()->json([
                'message' => 'success',
                'nosj' => $nosj,
                'tahapan' => $tahapan
            ], 200);
        }
        catch (QueryException $e){
            DB::connection($_SESSION['connection'])->rollBack();

            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function checkPrint(Request $request){
        $temp = DB::connection($_SESSION['connection'])->table('tbtr_sjas_d')
            ->where('sjd_kodeigr','=',$_SESSION['kdigr'])
            ->where('sjd_nosjas','=',$request->nosj)
            ->where('sjd_kodecustomer','=',$request->cus_kode)
            ->where('sjd_tahapan','=',$request->tahapan)
            ->first();

        if($temp){
            return 'true';
        }
        else{
            return 'false';
        }
    }

    public function print(Request $request){
        if($request->item == 'A')
            $p_and = ' AND NVL(SJD_QTYSJAS,0) IS NOT NULL';
        else $p_and = ' AND NVL(SJD_QTYSJAS,0) <> 0';

        if($request->reprint == 'Y')
            $reprint = 'RE-PRINT';
        else $reprint = '';

        $perusahaan = DB::connection($_SESSION['connection'])->table("tbmaster_perusahaan")->first();

        $data = DB::connection($_SESSION['connection'])->select("SELECT SJH_KODECUSTOMER, to_char(SJH_TGLSTRUK, 'dd/mm/yyyy') SJH_TGLSTRUK, SUBSTR(SJH_NOSTRUK,1,2) || '.' || SUBSTR(SJH_NOSTRUK,3,3) || '.' || SUBSTR(SJH_NOSTRUK,6,5) STRUK,
        SJH_NOSJAS, to_char(SJH_TGLPENITIPAN,'dd/mm/yyyy') SJH_TGLPENITIPAN,
        to_char(SJD_TGLTAHAPAN,'dd/mm/yyyy') SJD_TGLTAHAPAN, SUBSTR('00' || SJD_TAHAPAN ,LENGTH('00' || SJD_TAHAPAN ) - 1, 2) SJD_TAHAPAN, SJD_SEQNO, SJD_PRDCD, SJD_QTYSJAS,  SJD_QTYSTRUK,
        CUS_NAMAMEMBER,
        PRD_DESKRIPSIPANJANG, PRD_UNIT || '/' || PRD_FRAC UNIT,
        'PRINT : ' || TO_CHAR(SYSDATE, 'DD-MM-YYYY hh:mm:ss') KET
        FROM TBTR_SJAS_H, TBTR_SJAS_D, TBMASTER_CUSTOMER, TBMASTER_PRODMAST
        WHERE SJH_KODEIGR = '".$_SESSION['kdigr']."' AND SJH_NOSJAS = '".$request->nosj."' AND SJH_KODECUSTOMER = '".$request->cus_kode."'
        AND SJD_KODEIGR = SJH_KODEIGR AND SJD_NOSJAS = SJH_NOSJAS AND SJD_KODECUSTOMER = SJH_KODECUSTOMER
        AND SJD_TAHAPAN = '".$request->tahap."'
        AND CUS_KODEMEMBER = SJH_KODECUSTOMER
        AND PRD_KODEIGR = SJD_KODEIGR AND PRD_PRDCD = SJD_PRDCD
        ".$p_and."
        ORDER BY SJD_SEQNO");

        foreach($data as $d){
            $temp = DB::connection($_SESSION['connection'])->selectOne("SELECT SUM (NVL (SJD_QTYSJAS, 0)) qty
                  FROM TBTR_SJAS_D
                 WHERE SJD_KODEIGR = '".$_SESSION['kdigr']."'
                   AND SJD_NOSJAS = '".$request->nosj."'
                   AND SJD_KODECUSTOMER = '".$request->cus_kode."'
                   AND SJD_TAHAPAN <= '".$request->tahap."'
                   AND SJD_PRDCD = '".$d->sjd_prdcd."'");

            $d->qtysisa = $d->sjd_qtystruk - $temp->qty;
        }

//        dd($data);

        $dompdf = new PDF();

        $pdf = PDF::loadview('BTAS.sjas-pdf',compact(['perusahaan','data','reprint']));

        error_reporting(E_ALL ^ E_DEPRECATED);

        $pdf->output();
        $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);

        $canvas = $dompdf ->get_canvas();
//        $canvas->page_text(507, 80.75, "{PAGE_NUM} dari {PAGE_COUNT}", null, 7, array(0, 0, 0));

        $dompdf = $pdf;

        return $dompdf->stream('Tanda Terima Barang JA.pdf');
    }
}
