<?php
/**
 * Created by PhpStorm.
 * User: ryan
 * Date: 30/08/2021
 * Time: 2:15 PM
 */

namespace App\Http\Controllers\OMI;

use App\Http\Controllers\Auth\loginController;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller; use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use PDF;
use DateTime;
use Yajra\DataTables\DataTables;

class PerubahanStatusOmiPtkpToPkpController extends Controller
{

    public function index()
    {
        return view('OMI.perubahan-status-omi-ptkp-to-pkp');
    }

    public function newFormInstance(){
        $kodeigr = Session::get('kdigr');
        $usid = Session::get('usid');

        $temp = DB::connection(Session::get('connection'))->table("TBMASTER_PERUSAHAAN")
            ->selectRaw("PRS_RPTNAME")
            ->selectRaw("PRS_KODEMTO")
            ->where("PRS_KODEIGR",'=',$kodeigr)
            ->first();
        $rptname = $temp->prs_rptname;
        $kodemto = $temp->prs_kodemto;

        $temp = DB::connection(Session::get('connection'))->table("TBMASTER_PERUSAHAAN")
            ->selectRaw("PRS_NAMACABANG")
            ->first();
        $apptitle = $temp->prs_namacabang;

        $temp = DB::connection(Session::get('connection'))->table("TBTR_ALOKASITAX")
            ->selectRaw("NVL (COUNT (1), 0) as result")
            ->where("ALK_KDIGR",'=',$kodeigr)
            ->whereRaw("ALK_USED IS NULL")
            ->whereRaw("ALK_TAHUNPAJAK = TO_CHAR (SYSDATE, 'RR')")
            ->first();
        $temp = (int)$temp->result;
        if($temp == 0){
            //Nomor FP Kosong !! (EXIT PAGE)
            return response()->json('1');
        }elseif($temp == 1){
            //Nomor FP Tidak Cukup, Cadangan Nomor FP Harus 2 Nomor !! (EXIT PAGE)
            return response()->json('2');
        }
        $datas = DB::connection(Session::get('connection'))->select("SELECT CAST(ALK_TAXNUM AS INT) as nofp1,  CAST(ALK_TAXNUM AS INT) + 1 as nofp2
      FROM TBTR_ALOKASITAX
     WHERE ALK_TAXNUM =
               (SELECT MIN (ALK_TAXNUM)
                  FROM TBTR_ALOKASITAX
                 WHERE ALK_KDIGR = '$kodeigr'
                   AND ALK_USED IS NULL
                   AND ALK_TAHUNPAJAK = TO_CHAR (SYSDATE, 'RR'))");
        return response()->json($datas);

    }

    public function modalPTKP(Request $request){
        $search = $request->value;
        $datas = DB::connection(Session::get('connection'))->table('tbmaster_customer')
            ->select('cus_namamember','cus_kodemember')

            ->where('cus_namamember','LIKE', '%'.$search.'%')
            ->whereRaw("nvl(cus_flagpkp, 'A') <> 'Y'")

            ->orWhere('cus_kodemember','LIKE','%'.$search.'%')
            ->whereRaw("nvl(cus_flagpkp, 'A') <> 'Y'")

            ->orderBy("cus_namamember")

            ->limit(500)->get();

        return Datatables::of($datas)->make(true);
    }

    public function choosePTKP(Request $request){
        $kode = $request->kodeptkp;
        $temp = DB::connection(Session::get('connection'))->table('tbmaster_customer')
            ->selectRaw("NVL(COUNT(1),0) as result")
            ->where('cus_kodemember','=',$kode)
            ->first();
        if((int)$temp->result == 0){
            //Kode Member Tidak Terdaftar !!
            return response()->json('1');
        }else{
            $temp = DB::connection(Session::get('connection'))->table("tbmaster_customer")
                ->selectRaw("NVL(CUS_FLAGPKP,'N') as pkp")
                ->selectRaw("CUS_NAMAMEMBER")
                ->where("CUS_KODEMEMBER",'=',$kode)
                ->first();
            if($temp->pkp == 'Y'){
                //Member PTKP Sudah Terdaftar Sebagai PKP !!
                return response()->json('2');
            }else{
                return response()->json($temp->cus_namamember);
            }
        }
    }

    public function modalPKP(Request $request){
        $search = $request->value;
        $datas = DB::connection(Session::get('connection'))->table('tbmaster_customer')
            ->select('cus_namamember','cus_kodemember')

            ->where('cus_namamember','LIKE', '%'.$search.'%')
            ->whereRaw("nvl(cus_flagpkp, 'A') = 'Y'")

            ->orWhere('cus_kodemember','LIKE','%'.$search.'%')
            ->whereRaw("nvl(cus_flagpkp, 'A') = 'Y'")

            ->orderBy("cus_namamember")

            ->limit(500)->get();

        return Datatables::of($datas)->make(true);
    }

    public function choosePKP(Request $request){
        $kode = $request->kodepkp;
        $temp = DB::connection(Session::get('connection'))->table('tbmaster_customer')
            ->selectRaw("NVL(COUNT(1),0) as result")
            ->where('cus_kodemember','=',$kode)
            ->first();
        if((int)$temp->result == 0){
            //Kode Member Tidak Terdaftar !!
            return response()->json('1');
        }else{
            $temp = DB::connection(Session::get('connection'))->table("tbmaster_customer")
                ->selectRaw("NVL(CUS_FLAGPKP,'N') as pkp")
                ->selectRaw("CUS_NAMAMEMBER")
                ->where("CUS_KODEMEMBER",'=',$kode)
                ->first();
            if($temp->pkp != 'Y'){
                //Member ini PTKP, Belum Terdaftar Sebagai PKP !!
                return response()->json('2');
            }else{
                return response()->json($temp->cus_namamember);
            }
        }
    }
    public function prosesData(Request $request){
        try {
            DB::connection(Session::get('connection'))->beginTransaction();
            $kodeigr = Session::get('kdigr');
            $usid = Session::get('usid');
            $ptkp = $request->ptkp;
            $pkp = $request->pkp;
            $bkl = $request->bkl;

            $invno1 = 0;
            $invno2 = 0;

            $jmlstruk = ''; //di program lama, jmlstruk juga hanya di declare tapi ga diapa apain

            $dateA = $request->tglSales1;
            $dateB = $request->tglSales2;
            $sDate = DateTime::createFromFormat('d-m-Y', $dateA)->format('d-m-Y');
            $eDate = DateTime::createFromFormat('d-m-Y', $dateB)->format('d-m-Y');

            $tglfp = $request->tglfp;
            $tglfp = DateTime::createFromFormat('d-m-Y', $tglfp)->format('d-m-Y');

            DB::connection(Session::get('connection'))->beginTransaction();
            $temp = DB::connection(Session::get('connection'))->select("SELECT NVL (COUNT (1), 0) as result
      FROM (SELECT DISTINCT TRJD_FLAGTAX1, TRJD_FLAGTAX2
                       FROM TBTR_JUALDETAIL
                      WHERE TRJD_KODEIGR = '$kodeigr'
                        AND NVL (TRJD_RECORDID, '0') = '0'
                        AND TRJD_CUS_KODEMEMBER = '$ptkp'
                        AND TRUNC (TRJD_TRANSACTIONDATE) BETWEEN TO_DATE('$sDate','DD-MM-YYYY') AND TO_DATE('$eDate', 'DD-MM-YYYY')
                        AND NVL (TRJD_FLAGTAX2, 'N') = 'P') A");
            if((int)$temp[0]->result == 0){
                $temp = DB::connection(Session::get('connection'))->select("SELECT NVL (COUNT (1), 0) as result
          FROM (SELECT DISTINCT TRJD_FLAGTAX1, TRJD_FLAGTAX2
                           FROM TBTR_JUALDETAIL
                          WHERE TRJD_KODEIGR = '$kodeigr'
                            AND NVL (TRJD_RECORDID, '0') = '0'
                            AND TRJD_CUS_KODEMEMBER = '$ptkp'
                            AND TRUNC (TRJD_TRANSACTIONDATE) BETWEEN TO_DATE('$sDate','DD-MM-YYYY') AND TO_DATE('$eDate', 'DD-MM-YYYY')
                            AND NVL (TRJD_FLAGTAX1, 'N') = 'Y') A");
                if((int)$temp[0]->result != 0){
                    $pajak = 0;
                    //get_no_faktur
                    $connect = loginController::getConnectionProcedure();
                    $query = oci_parse($connect, "BEGIN get_no_faktur('$kodeigr','$usid',:taxnum); END;");
                    oci_bind_by_name($query, ':taxnum', $pajak, 32);
                    oci_execute($query);
                    if((int)$pajak == 0){
                        //Nomor FP Kosong (exit form)
                        return response()->json(['error' => 'Nomor FP Kosong']);

                    }
                    $invno1 = (int)$pajak;
                    $invno2 = 0;
                }
            }else{
                $temp = DB::connection(Session::get('connection'))->select("SELECT NVL (COUNT (1), 0) as result
          FROM (SELECT DISTINCT TRJD_FLAGTAX1, TRJD_FLAGTAX2
                           FROM TBTR_JUALDETAIL
                          WHERE TRJD_KODEIGR = '$kodeigr'
                            AND NVL (TRJD_RECORDID, '0') = '0'
                            AND TRJD_CUS_KODEMEMBER = '$ptkp'
                            AND TRUNC (TRJD_TRANSACTIONDATE) BETWEEN TO_DATE('$sDate','DD-MM-YYYY') AND TO_DATE('$eDate', 'DD-MM-YYYY')
                            AND NVL (TRJD_FLAGTAX1, 'N') = 'Y') A");

                if((int)$temp[0]->result != 0){
                    $temp = DB::connection(Session::get('connection'))->table("TBTR_ALOKASITAX")
                        ->selectRaw("NVL (COUNT (1), 0) as result")
                        ->where("ALK_KDIGR",'=',$kodeigr)
                        ->where("ALK_USED",'is',null)
                        ->whereRaw("ALK_TAHUNPAJAK = TO_CHAR (SYSDATE, 'RR')")
                        ->first();
                    if($temp->result < 2){
                        //Nomor FP Tidak Cukup, Nomor FP Harus 2 Nomor !! (exit form)
                        return response()->json(['error' => 'Nomor FP Tidak Cukup, Nomor FP Harus 2 Nomor !!']);
                    }
                    $pajak = 0;
                    $connect = loginController::getConnectionProcedure();
                    $query = oci_parse($connect, "BEGIN get_no_faktur('$kodeigr','$usid',:taxnum); END;");
                    oci_bind_by_name($query, ':taxnum', $pajak, 32);
                    oci_execute($query);
                    if((int)$pajak == 0){
                        //Nomor FP Kosong !! (exit form)
                        return response()->json(['error' => 'Nomor FP Kosong !!']);
                    }
                    $invno1 = (int)$pajak;
                }
                $pajak = 0;
                $connect = loginController::getConnectionProcedure();
                $query = oci_parse($connect, "BEGIN get_no_faktur('$kodeigr','$usid',:taxnum); END;");
                oci_bind_by_name($query, ':taxnum', $pajak, 32);
                oci_execute($query);
                if((int)$pajak == 0){
                    //Nomor FP Kosong !! (exit form)
                    return response()->json(['error' => 'Nomor FP Kosong !!']);
                }
                $invno2 = (int)$pajak;
            }
            $temp = DB::connection(Session::get('connection'))->table("TBMASTER_TOKOIGR")
                ->selectRaw("NVL (COUNT (1), 0) as result")
                ->where("TKO_KODECUSTOMER",'=',$pkp)
                ->first();

            if((int)$temp->result != 0){
                $kodeomi = DB::connection(Session::get('connection'))->table("TBMASTER_TOKOIGR")
                    ->selectRaw("TKO_KODEOMI")
                    ->where("TKO_KODECUSTOMER",'=',$pkp)
                    ->first();
                $kodeomi = $kodeomi->tko_kodeomi;
            }else{
                $kodeomi = '';
            }
            $temp = DB::connection(Session::get('connection'))->table("TBMASTER_TOKOIGR")
                ->selectRaw("NVL (COUNT (1), 0) as result")
                ->where("TKO_KODECUSTOMER",'=',$ptkp)
                ->first();
            if((int)$temp->result != 0){
                $kodeomilama = DB::connection(Session::get('connection'))->table("TBMASTER_TOKOIGR")
                    ->selectRaw("TKO_KODEOMI")
                    ->where("TKO_KODECUSTOMER",'=',$ptkp)
                    ->first();
                $kodeomilama = $kodeomilama->tko_kodeomi;
            }else{
                $kodeomilama = '';
            }
            $PESAN = 'Jumlah Struk'; //apaan, baru deklarasi sudah di replace
            $temp = DB::connection(Session::get('connection'))->table("TBTR_JUALDETAIL")
                ->selectRaw("NVL (COUNT (1), 0) as result")
                ->where("TRJD_KODEIGR",'=',$kodeigr)
                ->whereRaw("NVL (TRJD_RECORDID, '0') <> '1'")
                ->where("TRJD_TRANSACTIONTYPE",'=','S')
                ->whereRaw("TRUNC (TRJD_TRANSACTIONDATE) >= TO_DATE('$sDate','DD-MM-YYYY') AND TRUNC (TRJD_TRANSACTIONDATE) <= TO_DATE('$eDate','DD-MM-YYYY')")
                ->where("TRJD_CUS_KODEMEMBER",'=',$pkp)
                ->first();
            $PESAN = 'JualDetail - R - P';

            //-- update jualdetail utk kondisi R ( Baca JualHeader )
            DB::connection(Session::get('connection'))->table('TBTR_JUALDETAIL')
                ->whereRaw("TRJD_KODEIGR = '$kodeigr'
       AND NVL (TRJD_RECORDID, '0') <> '1'
       AND TRJD_TRANSACTIONTYPE = 'R'
       AND TRUNC (TRJD_TRANSACTIONDATE) >= TO_DATE('$sDate','DD-MM-YYYY')
       AND TRUNC (TRJD_TRANSACTIONDATE) <= TO_DATE('$eDate','DD-MM-YYYY')
       AND TRJD_CUS_KODEMEMBER = '$ptkp'
       AND TRJD_CREATE_BY <> 'BKL'
       AND NVL (TRJD_FLAGTAX2, 'N') = 'P'
       AND EXISTS (
               SELECT 'X'
                 FROM TBTR_JUALHEADER
                WHERE JH_KODEIGR = '$kodeigr'
                  AND NVL (JH_RECORDID, '0') <> '1'
                  AND JH_TRANSACTIONTYPE = 'R'
                  AND TRUNC (JH_TRANSACTIONDATE) = TRUNC (TRJD_TRANSACTIONDATE)
                  AND JH_CASHIERID = TRJD_CREATE_BY
                  AND JH_CASHIERSTATION = TRJD_CASHIERSTATION
                  AND JH_TRANSACTIONNO = TRJD_TRANSACTIONNO
                  AND TRUNC (JH_REFERENCEDATE) >= TO_DATE('$sDate','DD-MM-YYYY')
                  AND TRUNC (JH_REFERENCEDATE) <= TO_DATE('$eDate','DD-MM-YYYY'))")
                ->update([
                    'TRJD_CUS_KODEMEMBER' => $pkp,
                    'TRJD_NOINVOICE1' => $invno2,
                    'TRJD_NOINVOICE2' => $invno1
                ]);

            $PESAN = 'JualDetail - R - <> P, Y';

            DB::connection(Session::get('connection'))->table('TBTR_JUALDETAIL')
                ->whereRaw("TRJD_KODEIGR = '$kodeigr'
       AND NVL (TRJD_RECORDID, '0') <> '1'
       AND TRJD_TRANSACTIONTYPE = 'R'
       AND TRUNC (TRJD_TRANSACTIONDATE) >= TO_DATE('$sDate','DD-MM-YYYY')
       AND TRUNC (TRJD_TRANSACTIONDATE) <= TO_DATE('$eDate','DD-MM-YYYY')
       AND TRJD_CUS_KODEMEMBER = '$ptkp'
       AND TRJD_CREATE_BY <> 'BKL'
       AND NVL (TRJD_FLAGTAX2, 'N') NOT IN ('P', 'Y')
       AND EXISTS (
               SELECT 'X'
                 FROM TBTR_JUALHEADER
                WHERE JH_KODEIGR = '$kodeigr'
                  AND NVL (JH_RECORDID, '0') <> '1'
                  AND JH_TRANSACTIONTYPE = 'R'
                  AND TRUNC (JH_TRANSACTIONDATE) = TRUNC (TRJD_TRANSACTIONDATE)
                  AND JH_CASHIERID = TRJD_CREATE_BY
                  AND JH_CASHIERSTATION = TRJD_CASHIERSTATION
                  AND JH_TRANSACTIONNO = TRJD_TRANSACTIONNO
                  AND TRUNC (JH_REFERENCEDATE) >= TO_DATE('$sDate','DD-MM-YYYY')
                  AND TRUNC (JH_REFERENCEDATE) <= TO_DATE('$eDate','DD-MM-YYYY'))")
                ->update([
                    'TRJD_CUS_KODEMEMBER' => $pkp,
                    'TRJD_NOINVOICE2' => $invno1
                ]);

            $PESAN = 'JualDetail - R - Y';

            DB::connection(Session::get('connection'))->table('TBTR_JUALDETAIL')
                ->whereRaw("TRJD_KODEIGR = '$kodeigr'
       AND NVL (TRJD_RECORDID, '0') <> '1'
       AND TRJD_TRANSACTIONTYPE = 'R'
       AND TRUNC (TRJD_TRANSACTIONDATE) >= TO_DATE('$sDate','DD-MM-YYYY')
       AND TRUNC (TRJD_TRANSACTIONDATE) <= TO_DATE('$eDate','DD-MM-YYYY')
       AND TRJD_CUS_KODEMEMBER = '$ptkp'
       AND TRJD_CREATE_BY <> 'BKL'
       AND NVL (TRJD_FLAGTAX2, 'N') = 'Y'
       AND EXISTS (
               SELECT 'X'
                 FROM TBTR_JUALHEADER
                WHERE JH_KODEIGR = '$kodeigr'
                  AND NVL (JH_RECORDID, '0') <> '1'
                  AND JH_TRANSACTIONTYPE = 'R'
                  AND TRUNC (JH_TRANSACTIONDATE) = TRUNC (TRJD_TRANSACTIONDATE)
                  AND JH_CASHIERID = TRJD_CREATE_BY
                  AND JH_CASHIERSTATION = TRJD_CASHIERSTATION
                  AND JH_TRANSACTIONNO = TRJD_TRANSACTIONNO
                  AND TRUNC (JH_REFERENCEDATE) >= TO_DATE('$sDate','DD-MM-YYYY')
                  AND TRUNC (JH_REFERENCEDATE) <= TO_DATE('$eDate','DD-MM-YYYY'))")
                ->update([
                    'TRJD_CUS_KODEMEMBER' => $pkp,
                    'TRJD_NOINVOICE1' => $invno1
                ]);

            $PESAN = 'JualHeader - R';

            DB::connection(Session::get('connection'))->table('TBTR_JUALHEADER')
                ->whereRaw("JH_KODEIGR = '$kodeigr'
       AND NVL (JH_RECORDID, '0') <> '1'
       AND JH_TRANSACTIONTYPE = 'R'
       AND TRUNC (JH_TRANSACTIONDATE) >= TO_DATE('$sDate','DD-MM-YYYY')
       AND TRUNC (JH_TRANSACTIONDATE) <= TO_DATE('$eDate','DD-MM-YYYY')
       AND JH_CUS_KODEMEMBER = '$ptkp'
       AND JH_CREATE_BY <> 'BKL'")
                ->update([
                    'JH_CUS_KODEMEMBER' => $pkp
                ]);

            //--update jualdetail utk kondisi S, BKL (baca master PB OMI ) dan non BKL
            if($bkl == 'Y'){
                $PESAN = 'JualDetail - S - P - BKL';

                DB::connection(Session::get('connection'))->table('TBTR_JUALDETAIL')
                    ->whereRaw("TRJD_KODEIGR = '$kodeigr'
           AND NVL (TRJD_RECORDID, '0') <> '1'
           AND TRJD_TRANSACTIONTYPE = 'S'
           AND TRUNC (TRJD_TRANSACTIONDATE) >= TO_DATE('$sDate','DD-MM-YYYY')
           AND TRUNC (TRJD_TRANSACTIONDATE) <= TO_DATE('$eDate','DD-MM-YYYY')
           AND TRJD_CUS_KODEMEMBER = '$ptkp'
           AND TRJD_CREATE_BY = 'BKL'
           AND NVL (TRJD_FLAGTAX2, 'N') = 'P'
           AND EXISTS (
                   SELECT 'X'
                     FROM TBMASTER_PBOMI, TBMASTER_TOKOIGR
                    WHERE TKO_KODEIGR = '$kodeigr'
                      AND TKO_KODECUSTOMER = TRJD_CUS_KODEMEMBER
                      AND PBO_KODEIGR = '$kodeigr'
                      AND NVL (PBO_RECORDID, '0') = '0'
                      AND TRUNC (PBO_TGLUPDATE) = TRUNC (TRJD_CREATE_DT)
                      AND PBO_NOSTRUK =
                                 SUBSTR (TRJD_TRANSACTIONNO, 1, 5)
                              || TRJD_CASHIERSTATION
                              || TRJD_CREATE_BY
                      AND PBO_KODEOMI = TKO_KODEOMI
                      AND PBO_CREATE_BY = 'BKL'
                      AND TRUNC (PBO_TGLPB) >= TO_DATE('$sDate','DD-MM-YYYY')
                      AND TRUNC (PBO_TGLPB) <= TO_DATE('$eDate','DD-MM-YYYY'))")
                    ->update([
                        'TRJD_CUS_KODEMEMBER' => $pkp,
                        'TRJD_NOINVOICE1' => $invno2,
                        'TRJD_NOINVOICE2' =>  $invno1
                    ]);

                $PESAN = 'JualDetail - S - <> P, Y - BKL';

                DB::connection(Session::get('connection'))->table('TBTR_JUALDETAIL')
                    ->whereRaw("TRJD_KODEIGR = '$kodeigr'
           AND NVL (TRJD_RECORDID, '0') <> '1'
           AND TRJD_TRANSACTIONTYPE = 'S'
           AND TRUNC (TRJD_TRANSACTIONDATE) >= TO_DATE('$sDate','DD-MM-YYYY')
           AND TRUNC (TRJD_TRANSACTIONDATE) <= TO_DATE('$eDate','DD-MM-YYYY')
           AND TRJD_CUS_KODEMEMBER = '$ptkp'
           AND TRJD_CREATE_BY = 'BKL'
           AND NVL (TRJD_FLAGTAX2, 'N') NOT IN ('P', 'Y')
           AND EXISTS (
                   SELECT 'X'
                     FROM TBMASTER_PBOMI, TBMASTER_TOKOIGR
                    WHERE TKO_KODEIGR = '$kodeigr'
                      AND TKO_KODECUSTOMER = TRJD_CUS_KODEMEMBER
                      AND PBO_KODEIGR = '$kodeigr'
                      AND NVL (PBO_RECORDID, '0') = '0'
                      AND TRUNC (PBO_TGLUPDATE) = TRUNC (TRJD_CREATE_DT)
                      AND PBO_NOSTRUK =
                                 SUBSTR (TRJD_TRANSACTIONNO, 1, 5)
                              || TRJD_CASHIERSTATION
                              || TRJD_CREATE_BY
                      AND PBO_KODEOMI = TKO_KODEOMI
                      AND PBO_CREATE_BY = 'BKL'
                      AND TRUNC (PBO_TGLPB) >= TO_DATE('$sDate','DD-MM-YYYY')
                      AND TRUNC (PBO_TGLPB) <= TO_DATE('$eDate','DD-MM-YYYY'))")
                    ->update([
                        'TRJD_CUS_KODEMEMBER' => $pkp,
                        'TRJD_NOINVOICE2' => $invno1
                    ]);

                $PESAN = 'JualDetail - S - Y - BKL';

                DB::connection(Session::get('connection'))->table('TBTR_JUALDETAIL')
                    ->whereRaw("TRJD_KODEIGR = '$kodeigr'
           AND NVL (TRJD_RECORDID, '0') <> '1'
           AND TRJD_TRANSACTIONTYPE = 'S'
           AND TRUNC (TRJD_TRANSACTIONDATE) >= TO_DATE('$sDate','DD-MM-YYYY')
           AND TRUNC (TRJD_TRANSACTIONDATE) <= TO_DATE('$eDate','DD-MM-YYYY')
           AND TRJD_CUS_KODEMEMBER = '$ptkp'
           AND TRJD_CREATE_BY = 'BKL'
           AND NVL (TRJD_FLAGTAX2, 'N') = 'Y'
           AND EXISTS (
                   SELECT 'X'
                     FROM TBMASTER_PBOMI, TBMASTER_TOKOIGR
                    WHERE TKO_KODEIGR = '$kodeigr'
                      AND TKO_KODECUSTOMER = TRJD_CUS_KODEMEMBER
                      AND PBO_KODEIGR = '$kodeigr'
                      AND NVL (PBO_RECORDID, '0') = '0'
                      AND TRUNC (PBO_TGLUPDATE) = TRUNC (TRJD_CREATE_DT)
                      AND PBO_NOSTRUK =
                                 SUBSTR (TRJD_TRANSACTIONNO, 1, 5)
                              || TRJD_CASHIERSTATION
                              || TRJD_CREATE_BY
                      AND PBO_KODEOMI = TKO_KODEOMI
                      AND PBO_CREATE_BY = 'BKL'
                      AND TRUNC (PBO_TGLPB) >= TO_DATE('$sDate','DD-MM-YYYY')
                      AND TRUNC (PBO_TGLPB) <= TO_DATE('$eDate','DD-MM-YYYY'))")
                    ->update([
                        'TRJD_CUS_KODEMEMBER' => $pkp,
                        'TRJD_NOINVOICE1' => $invno1
                    ]);

                $PESAN = 'JualHeader - S - BKL';

                DB::connection(Session::get('connection'))->table('TBTR_JUALHEADER')
                    ->whereRaw("JH_KODEIGR = '$kodeigr'
           AND NVL (JH_RECORDID, '0') <> '1'
           AND JH_TRANSACTIONTYPE = 'S'
           AND TRUNC (JH_TRANSACTIONDATE) >= TO_DATE('$sDate','DD-MM-YYYY')
           AND TRUNC (JH_TRANSACTIONDATE) <= TO_DATE('$eDate','DD-MM-YYYY')
           AND JH_CUS_KODEMEMBER = '$ptkp'
           AND JH_CREATE_BY = 'BKL'
           AND EXISTS (
                   SELECT 'X'
                     FROM TBMASTER_PBOMI, TBMASTER_TOKOIGR
                    WHERE TKO_KODEIGR = '$kodeigr'
                      AND TKO_KODECUSTOMER = JH_CUS_KODEMEMBER
                      AND PBO_KODEIGR = '$kodeigr'
                      AND NVL (PBO_RECORDID, '0') = '0'
                      AND TRUNC (PBO_TGLUPDATE) = TRUNC (JH_TRANSACTIONDATE)
                      AND PBO_NOSTRUK =
                                 SUBSTR (JH_TRANSACTIONNO, 1, 5) || JH_CASHIERSTATION
                                 || JH_CREATE_BY
                      AND PBO_KODEOMI = TKO_KODEOMI
                      AND PBO_CREATE_BY = 'BKL'
                      AND TRUNC (PBO_TGLPB) >= TO_DATE('$sDate','DD-MM-YYYY')
                      AND TRUNC (PBO_TGLPB) <= TO_DATE('$eDate','DD-MM-YYYY'))")
                    ->update([
                        'JH_CUS_KODEMEMBER' => $pkp
                    ]);
            }

            $PESAN = 'JualDetail - S - P';

            DB::connection(Session::get('connection'))->table('TBTR_JUALDETAIL')
                ->whereRaw("TRJD_KODEIGR = '$kodeigr'
       AND NVL (TRJD_RECORDID, '0') <> '1'
       AND TRJD_TRANSACTIONTYPE = 'S'
       AND TRUNC (TRJD_TRANSACTIONDATE) >= TO_DATE('$sDate','DD-MM-YYYY')
       AND TRUNC (TRJD_TRANSACTIONDATE) <= TO_DATE('$eDate','DD-MM-YYYY')
       AND TRJD_CUS_KODEMEMBER = '$ptkp'
       AND TRJD_CREATE_BY <> 'BKL'
       AND NVL (TRJD_FLAGTAX2, 'N') = 'P'")
                ->update([
                    'TRJD_CUS_KODEMEMBER' => $pkp,
                    'TRJD_NOINVOICE1' => $invno2,
                    'TRJD_NOINVOICE2' => $invno1
                ]);

            $PESAN = 'JualDetail - S - <> P, Y';

            DB::connection(Session::get('connection'))->table('TBTR_JUALDETAIL')
                ->whereRaw("TRJD_KODEIGR = '$kodeigr'
       AND NVL (TRJD_RECORDID, '0') <> '1'
       AND TRJD_TRANSACTIONTYPE = 'S'
       AND TRUNC (TRJD_TRANSACTIONDATE) >= TO_DATE('$sDate','DD-MM-YYYY')
       AND TRUNC (TRJD_TRANSACTIONDATE) <= TO_DATE('$eDate','DD-MM-YYYY')
       AND TRJD_CUS_KODEMEMBER = '$ptkp'
       AND TRJD_CREATE_BY <> 'BKL'
       AND NVL (TRJD_FLAGTAX2, 'N') NOT IN ('P', 'Y')")
                ->update([
                    'TRJD_CUS_KODEMEMBER' => $pkp,
                    'TRJD_NOINVOICE2' => $invno1
                ]);

            $PESAN = 'JualDetail - S - Y';

            DB::connection(Session::get('connection'))->table('TBTR_JUALDETAIL')
                ->whereRaw("TRJD_KODEIGR = '$kodeigr'
       AND NVL (TRJD_RECORDID, '0') <> '1'
       AND TRJD_TRANSACTIONTYPE = 'S'
       AND TRUNC (TRJD_TRANSACTIONDATE) >= TO_DATE('$sDate','DD-MM-YYYY')
       AND TRUNC (TRJD_TRANSACTIONDATE) <= TO_DATE('$eDate','DD-MM-YYYY')
       AND TRJD_CUS_KODEMEMBER = '$ptkp'
       AND TRJD_CREATE_BY <> 'BKL'
       AND NVL (TRJD_FLAGTAX2, 'N') = 'Y'")
                ->update([
                    'TRJD_CUS_KODEMEMBER' => $pkp,
                    'TRJD_NOINVOICE1' => $invno1
                ]);

            $PESAN = 'JualHeader - S';

            DB::connection(Session::get('connection'))->table('TBTR_JUALHEADER')
                ->whereRaw("JH_KODEIGR = '$kodeigr'
       AND NVL (JH_RECORDID, '0') <> '1'
       AND JH_TRANSACTIONTYPE = 'S'
       AND TRUNC (JH_TRANSACTIONDATE) >= TO_DATE('$sDate','DD-MM-YYYY')
       AND TRUNC (JH_TRANSACTIONDATE) <= TO_DATE('$eDate','DD-MM-YYYY')
       AND JH_CUS_KODEMEMBER = '$ptkp'
       AND JH_CREATE_BY <> 'BKL'")
                ->update([
                    'JH_CUS_KODEMEMBER' => $pkp
                ]);

            $hutang1 = 0;
            $hutang2 = 0;
            $bayar1 = 0;
            $bayar2 = 0;
            $PESAN = 'Hitung Nilai Hutang & Bayar';

            $temp = DB::connection(Session::get('connection'))->select("SELECT NVL (SUM (HUTANG), 0) HUTANG, NVL (SUM (BAYAR), 0) BAYAR
      FROM (SELECT TRPT_CUS_KODEMEMBER,
                   CASE
                       WHEN TRPT_TYPE IN ('D', 'R')
                           THEN TRPT_SALESVALUE * -1
                       ELSE TRPT_SALESVALUE
                   END HUTANG,
                   CASE
                       WHEN TRPT_TYPE = 'J'
                           THEN CASE
                                   WHEN NVL (TRPT_RECORDID, '0') = '2'
                                       THEN TRPT_SALESVALUE
                                   ELSE 0
                               END
                       ELSE 0
                   END BAYAR
              FROM TBTR_PIUTANG
             WHERE TRPT_KODEIGR = '$kodeigr'
               AND TRPT_SALESINVOICEDATE >= TO_DATE('$sDate','DD-MM-YYYY')
               AND TRPT_SALESINVOICEDATE <= TO_DATE('$eDate','DD-MM-YYYY')
               AND TRPT_CUS_KODEMEMBER = '$ptkp'
               AND TRPT_CASHIERID <> 'BKL')");
            $hutang1 = $temp[0]->hutang;
            $bayar1 = $temp[0]->bayar;

            $PESAN = 'Piutang';

            DB::connection(Session::get('connection'))->table('TBTR_PIUTANG')
                ->where("TRPT_KODEIGR",'=',$kodeigr)
                ->whereRaw("TRPT_SALESINVOICEDATE >= TO_DATE('$sDate','DD-MM-YYYY') AND TRPT_SALESINVOICEDATE <= TO_DATE('$eDate','DD-MM-YYYY')")
                ->where("TRPT_CUS_KODEMEMBER",'=',$ptkp)
                ->where("TRPT_CASHIERID",'<>','BKL')
                ->update([
                    'TRPT_CUS_KODEMEMBER' => $pkp,
                    'TRPT_INVOICETAXNO' => $invno1,
                    'TRPT_INVOICETAXDATE' => DB::RAW("TO_DATE('$tglfp','DD-MM-YYYY')")
                ]);

            if($bkl == 'Y'){
                $PESAN = 'Hitung Nilai Hutang & Bayar - BKL';

                $temp = DB::connection(Session::get('connection'))->select("SELECT NVL (SUM (HUTANG), 0) HUTANG, NVL (SUM (BAYAR), 0) BAYAR
          FROM (SELECT TRPT_CUS_KODEMEMBER,
                       CASE
                           WHEN TRPT_TYPE IN ('D', 'R')
                               THEN TRPT_SALESVALUE * -1
                           ELSE TRPT_SALESVALUE
                       END HUTANG,
                       CASE
                           WHEN TRPT_TYPE = 'J'
                               THEN CASE
                                       WHEN NVL (TRPT_RECORDID, '0') = '2'
                                           THEN TRPT_SALESVALUE
                                       ELSE 0
                                   END
                           ELSE 0
                       END BAYAR
                  FROM TBTR_PIUTANG
                 WHERE TRPT_KODEIGR = '$kodeigr'
                   AND TRPT_SALESINVOICEDATE >= TO_DATE('$sDate','DD-MM-YYYY')
                   AND TRPT_SALESINVOICEDATE <= TO_DATE('$eDate','DD-MM-YYYY')
                   AND TRPT_CUS_KODEMEMBER = '$ptkp'
                   AND TRPT_CASHIERID = 'BKL'
                   AND EXISTS (
                           SELECT 'X'
                             FROM TBMASTER_PBOMI, TBMASTER_TOKOIGR
                            WHERE TKO_KODEIGR = '$kodeigr'
                              AND TKO_KODECUSTOMER = TRPT_CUS_KODEMEMBER
                              AND PBO_KODEIGR = '$kodeigr'
                              AND NVL (PBO_RECORDID, '0') = '0'
                              AND TRUNC (PBO_TGLUPDATE) = TRUNC (TRPT_SALESINVOICEDATE)
                              AND PBO_NOSTRUK =
                                        TRPT_SALESINVOICENO || TRPT_CASHIERSTATION || TRPT_CASHIERID
                              AND PBO_KODEOMI = TKO_KODEOMI
                              AND PBO_CREATE_BY = 'BKL'
                              AND TRUNC (PBO_TGLPB) >= TO_DATE('$sDate','DD-MM-YYYY')
                              AND TRUNC (PBO_TGLPB) <= TO_DATE('$eDate','DD-MM-YYYY')))");
                $hutang2 = $temp[0]->hutang;
                $bayar2 = $temp[0]->bayar;
            }

            $PESAN = 'Piutang - BKL';

            DB::connection(Session::get('connection'))->table('TBTR_PIUTANG')
                ->whereRaw("TRPT_KODEIGR = '$kodeigr'
           AND TRPT_SALESINVOICEDATE >= TO_DATE('$sDate','DD-MM-YYYY')
           AND TRPT_SALESINVOICEDATE <= TO_DATE('$eDate','DD-MM-YYYY')
           AND TRPT_CUS_KODEMEMBER = '$ptkp'
           AND TRPT_CASHIERID = 'BKL'
           AND EXISTS (
                   SELECT 'X'
                     FROM TBMASTER_PBOMI, TBMASTER_TOKOIGR
                    WHERE TKO_KODEIGR = '$kodeigr'
                      AND TKO_KODECUSTOMER = TRPT_CUS_KODEMEMBER
                      AND PBO_KODEIGR = '$kodeigr'
                      AND NVL (PBO_RECORDID, '0') = '0'
                      AND TRUNC (PBO_TGLUPDATE) = TRUNC (TRPT_SALESINVOICEDATE)
                      AND PBO_NOSTRUK = TRPT_SALESINVOICENO || TRPT_CASHIERSTATION || TRPT_CASHIERID
                      AND PBO_KODEOMI = TKO_KODEOMI
                      AND PBO_CREATE_BY = 'BKL'
                      AND TRUNC (PBO_TGLPB) >= TO_DATE('$sDate','DD-MM-YYYY')
                      AND TRUNC (PBO_TGLPB) <= TO_DATE('$eDate','DD-MM-YYYY'))")
                ->update([
                    'TRPT_CUS_KODEMEMBER' => $pkp,
                    'TRPT_INVOICETAXNO' => $invno1,
                    'TRPT_INVOICETAXDATE' => DB::RAW("TO_DATE('$tglfp','DD-MM-YYYY')")
                ]);

            $PESAN = 'PBOMI - BKL';

            DB::connection(Session::get('connection'))->table('TBMASTER_PBOMI')
                ->where("PBO_KODEMEMBER",'=',$ptkp)
                ->where("PBO_CREATE_BY",'=','BKL')
                ->whereRaw("PBO_TGLPB >= TO_DATE('$sDate','DD-MM-YYYY') AND PBO_TGLPB <= TO_DATE('$eDate','DD-MM-YYYY')")
                ->update([
                    'PBO_KODEMEMBER' => $pkp,
                    'PBO_KODEOMI' => $kodeomi
                ]);

            $PESAN = 'PBOMI';

            DB::connection(Session::get('connection'))->table('TBMASTER_PBOMI')
                ->where("PBO_KODEMEMBER",'=',$ptkp)
                ->where("PBO_CREATE_BY",'<>','BKL')
                ->whereRaw("PBO_TGLSTRUK >= TO_DATE('$sDate','DD-MM-YYYY') AND PBO_TGLSTRUK <= TO_DATE('$eDate','DD-MM-YYYY')")
                ->update([
                    'PBO_KODEMEMBER' => $pkp,
                    'PBO_KODEOMI' => $kodeomi
                ]);

            $PESAN = 'Update Piutang PTKP';
            $jmlhutang = (int)$hutang1 + (int)$hutang2;
            $jmlbayar = (int)$bayar1 + (int)$bayar2;

            DB::connection(Session::get('connection'))->table('TBMASTER_PIUTANG')
                ->where("PTG_KODEIGR",'=',$kodeigr)
                ->where("PTG_KODEMEMBER",'=','$ptkp')
                ->update([
                    'PTG_AMTAR' => DB::raw("PTG_AMTAR - $jmlhutang"),
                    'PTG_AMTPAYMENT' => DB::raw("PTG_AMTPAYMENT - $jmlbayar")
                ]);

            $PESAN = 'Cek Piutang PKP';

            $temp = DB::connection(Session::get('connection'))->table("TBMASTER_PIUTANG")
                ->selectRaw("NVL (COUNT (1), 0) as result")
                ->where("PTG_KODEIGR",'=',$kodeigr)
                ->where("PTG_KODEMEMBER",'=',$pkp)
                ->first();
            if((int)$temp->result == 0){
                $PESAN = 'Insert Piutang PKP';

                DB::connection(Session::get('connection'))->table("TBMASTER_PIUTANG")
                    ->insert([
                        'PTG_KODEIGR' => $kodeigr,
                        'PTG_KODEMEMBER' => $pkp,
                        'PTG_AMTAR' => $jmlhutang,
                        'PTG_AMTPAYMENT' => $jmlbayar,
                        'PTG_CREATE_BY' => $usid,
                        'PTG_CREATE_DT' => DB::RAW("SYSDATE")]);
            }else{
                $PESAN = 'Update Piutang PKP';

                DB::connection(Session::get('connection'))->table('TBMASTER_PIUTANG')
                    ->where("PTG_KODEIGR",'=',$kodeigr)
                    ->where("PTG_KODEMEMBER",'=','$pkp')
                    ->update([
                        'PTG_AMTAR' => DB::raw("PTG_AMTAR + $jmlhutang"),
                        'PTG_AMTPAYMENT' => DB::raw("PTG_AMTPAYMENT + $jmlbayar")
                    ]);
            }

            if($invno1 != 0){
                $PESAN = 'Cek FP';

                $temp = DB::connection(Session::get('connection'))->select("SELECT PRS_KODEMTO, CUS_FLAGINSTITUSIPEMERINTAH
          FROM TBMASTER_PERUSAHAAN, TBMASTER_CUSTOMER
         WHERE PRS_KODEIGR = '$kodeigr' AND CUS_KODEMEMBER = '$pkp'");
                if($temp){
                    $kodemto = $temp[0]->prs_kodemto;
                    $flaginstitusipemerintah = $temp[0]->cus_flaginstitusipemerintah;
                }else{
                    $kodemto = '';
                    $flaginstitusipemerintah = '';
                }

                $nopajak = str_pad(strval($invno1),13,'0',STR_PAD_LEFT);
                if($flaginstitusipemerintah == 'Y'){
                    $serial1 = '02';
                }else{
                    $serial1 = '01';
                }
                $serial1 = $serial1.'0.'.substr($nopajak,1,3).'-'.substr($nopajak,4,2).'.'.str_pad(substr($nopajak,6,8),8,'0',STR_PAD_LEFT).'Y';

                $temp = DB::connection(Session::get('connection'))->table("TBMASTER_FAKTUR")
                    ->selectRaw("NVL (COUNT (1), 0) as result")
                    ->where("FKT_KODEIGR",'=',$kodeigr)
                    ->where("FKT_NOFAKTUR",'=',$invno1)
                    ->where("FKT_TIPE",'=','S')
                    ->first();
                if((int)$temp->result == 0){
                    $PESAN = 'Insert FP';

                    DB::connection(Session::get('connection'))->table("TBMASTER_FAKTUR")
                        ->insert([
                            'FKT_KODEIGR' => $kodeigr,
                            'FKT_TIPE' => 'S',
                            'FKT_TGL' => DB::RAW("TO_DATE('$tglfp','DD-MM-YYYY')"),
                            'FKT_NOFAKTUR' => $invno1,
                            'FKT_TGLFAKTUR' => DB::RAW("TO_DATE('$tglfp','DD-MM-YYYY')"),
                            'FKT_KODEMEMBER' => $pkp,
                            'FKT_SIGN' => 'PINDAH STATUS',
                            'FKT_CREATE_BY' => $usid,
                            'FKT_CREATE_DT' => DB::RAW("SYSDATE"),
                            'FKT_NOSERI' => $serial1]);
                }else{
                    $PESAN = 'Update FP';

                    DB::connection(Session::get('connection'))->table("TBMASTER_FAKTUR")
                        ->where("FKT_KODEIGR",'=',$kodeigr)
                        ->where("FKT_NOFAKTUR",'=',$invno1)
                        ->where("FKT_TIPE",'=','S')
                        ->update([
                            'FKT_TGL' => DB::RAW("TO_DATE('$tglfp','DD-MM-YYYY')"),
                            'FKT_TGLFAKTUR' => DB::RAW("TO_DATE('$tglfp','DD-MM-YYYY')"),
                            'FKT_KODEMEMBER' => $pkp,
                            'FKT_SIGN' => 'PINDAH STATUS',
                        ]);
                }
            }
            if($invno2 != 0){
                $PESAN = 'Cek FP 2';

                $temp = DB::connection(Session::get('connection'))->select("SELECT PRS_KODEMTO, CUS_FLAGINSTITUSIPEMERINTAH
          FROM TBMASTER_PERUSAHAAN, TBMASTER_CUSTOMER
         WHERE PRS_KODEIGR = '$kodeigr' AND CUS_KODEMEMBER = '$pkp'");
                if($temp){
                    $kodemto = $temp[0]->prs_kodemto;
                    $flaginstitusipemerintah = $temp[0]->cus_flaginstitusipemerintah;
                }else{
                    $kodemto = '';
                    $flaginstitusipemerintah = '';
                }

                $nopajak = str_pad(strval($invno2),13,'0',STR_PAD_LEFT);
                if($flaginstitusipemerintah == 'Y'){
                    $serial2 = '02';
                }else{
                    $serial2 = '01';
                }
                $serial2 = $serial2.'0.'.substr($nopajak,1,3).'-'.substr($nopajak,4,2).'.'.str_pad(substr($nopajak,6,8),8,'0',STR_PAD_LEFT).'Y';
                $temp = DB::connection(Session::get('connection'))->table("TBMASTER_FAKTUR")
                    ->selectRaw("NVL (COUNT (1), 0) as result")
                    ->where("FKT_KODEIGR",'=',$kodeigr)
                    ->where("FKT_NOFAKTUR",'=',$invno2)
                    ->where("FKT_TIPE",'=','S')
                    ->first();
                if((int)$temp->result == 0){
                    $PESAN = 'Insert FP 2';

                    DB::connection(Session::get('connection'))->table("TBMASTER_FAKTUR")
                        ->insert([
                            'FKT_KODEIGR' => $kodeigr,
                            'FKT_TIPE' => 'S',
                            'FKT_TGL' => DB::RAW("TO_DATE('$tglfp','DD-MM-YYYY')"),
                            'FKT_NOFAKTUR' => $invno2,
                            'FKT_TGLFAKTUR' => DB::RAW("TO_DATE('$tglfp','DD-MM-YYYY')"),
                            'FKT_KODEMEMBER' => $pkp,
                            'FKT_SIGN' => 'PINDAH STATUS',
                            'FKT_CREATE_BY' => $usid,
                            'FKT_CREATE_DT' => DB::RAW("SYSDATE"),
                            'FKT_NOSERI' => $serial2]);
                }else{
                    $PESAN = 'Update FP 2';

                    DB::connection(Session::get('connection'))->table("TBMASTER_FAKTUR")
                        ->where("FKT_KODEIGR",'=',$kodeigr)
                        ->where("FKT_NOFAKTUR",'=',$invno2)
                        ->where("FKT_TIPE",'=','S')
                        ->update([
                            'FKT_TGL' => DB::RAW("TO_DATE('$tglfp','DD-MM-YYYY')"),
                            'FKT_TGLFAKTUR' => DB::RAW("TO_DATE('$tglfp','DD-MM-YYYY')"),
                            'FKT_KODEMEMBER' => $pkp,
                            'FKT_SIGN' => 'PINDAH STATUS',
                        ]);
                }
            }

            $PESAN = 'History Harga Struk OMI';

            DB::connection(Session::get('connection'))->table("TBHISTORY_HARGASTRUKOMI")
                ->where("HSO_KODEIGR",'=',$kodeigr)
                ->where("HSO_KODEMEMBER",'=',$ptkp)
                ->update([
                    'HSO_KODEMEMBER' => $pkp
                ]);

            //--penambahan diluar clipper info Pak Lili
            $PESAN = 'Update TBTR_REALPB';

            DB::connection(Session::get('connection'))->table("TBTR_REALPB")
                ->whereRaw("TRUNC (RPB_CREATE_DT) BETWEEN TO_DATE('$sDate','DD-MM-YYYY') AND TO_DATE('$eDate', 'DD-MM-YYYY')")
                ->where("RPB_KODECUSTOMER",'=',$ptkp)
                ->update([
                    'RPB_KODECUSTOMER' => $pkp,
                    'RPB_KODEOMI' => $kodeomi
                ]);

            $PESAN = 'Update TBTR_OMIKOLI';
            DB::connection(Session::get('connection'))->table("TBTR_OMIKOLI")
                ->whereRaw("TRUNC (OKL_CREATE_DT) BETWEEN TO_DATE('$sDate','DD-MM-YYYY') AND TO_DATE('$eDate', 'DD-MM-YYYY')")
                ->where("OKL_KODEOMI",'=',$kodeomilama)
                ->update([
                    'OKL_KODEOMI' => $kodeomi
                ]);

            $PESAN = 'Update TBTR_RETUROMI';
            DB::connection(Session::get('connection'))->table("TBTR_RETUROMI")
                ->whereRaw("TRUNC (ROM_TGLDOKUMEN) BETWEEN TO_DATE('$sDate','DD-MM-YYYY') AND TO_DATE('$eDate', 'DD-MM-YYYY')")
                ->where("ROM_MEMBER",'=',$ptkp)
                ->update([
                    'ROM_KODETOKO' => $kodeomi,
                    'ROM_MEMBER' => $pkp
                ]);
            //commit
            DB::connection(Session::get('connection'))->commit();

            $PESAN = 'ADM Fee';
            $temp = DB::connection(Session::get('connection'))->select("SELECT SUM (NVL (FEE, 0)) FEE
      FROM (SELECT CASE
                       WHEN TRJD_TRANSACTIONTYPE = 'S'
                           THEN TRJD_ADMFEE
                       ELSE TRJD_ADMFEE * -1
                   END FEE
              FROM TBTR_JUALDETAIL
             WHERE TRJD_KODEIGR = '$kodeigr'
               AND NVL (TRJD_RECORDID, '0') <> '1'
               AND TRUNC (TRJD_TRANSACTIONDATE) >= TO_DATE('$sDate','DD-MM-YYYY')
               AND TRUNC (TRJD_TRANSACTIONDATE) <= TO_DATE('$eDate','DD-MM-YYYY')
               AND TRJD_CUS_KODEMEMBER = '$pkp') A");
            $admfee = $temp[0]->fee;

            if($invno1 != 0 || $invno2 != 0){
                //PRINT_FP (INVNO1, INVNO2, ADMFEE, JMLSTRUK);
                return response()->json(['error' => '', 'cetak' => 'yes', 'invno1' => $invno1, 'invno2' => $invno2, 'admfee' => $admfee, 'jmlstruk' => $jmlstruk]);
            }else{
                return response()->json(['error' => '', 'cetak' => 'no']);
            }
            //return notif DDC_ALERT.OK (   'Perubahan Member PTKP '
            //                 || :TXT_PTKP
            //                 || ' Menjadi Member PKP '
            //                 || :TXT_PKP
            //                 || ' Sudah Selesai Dilakukan !!'
            //                );
            DB::connection(Session::get('connection'))->commit();
        }catch (QueryException $e){
            DB::connection(Session::get('connection'))->rollBack();

            return response()->json([
                'error' => "Gagal memproses data!",
            ], 500);
        }

    }

    public function cetak(Request $request){
        $kodeigr = Session::get('kdigr');

        $invno1 = (int)$request->invno1;
        $invno2 = (int)$request->invno2;
        $admfee = $request->admfee;
        $jmlstruk = $request->jmlstruk;

        $tglFP = $request->tglfp;
        $date = DateTime::createFromFormat('d-m-Y', $tglFP)->format('d-m-Y');

        $nama = $request->nama;
        $jabatan1 = $request->jabatan1;
        $jabatan2 = $request->jabatan2;

        $p_and = " and (trjd_noinvoice1 in (".$invno1.", ".$invno2.") or trjd_noinvoice2 in (".$invno1.", ".$invno2."))";

        $datas = DB::connection(Session::get('connection'))->select("SELECT ROWNUM NOMOR, CUS_KODEMEMBER, PWP_KODEMEMBER, PRS_NPWP,
       TO_CHAR (PRS_TGLSK, 'DD MONTH YYYY') PRS_TGLSK,
       PRS_ALAMATFAKTURPAJAK1 || ' ' || PRS_ALAMATFAKTURPAJAK2 ALAMATPJK1,
       PRS_ALAMATFAKTURPAJAK3 ALAMATPJK2, PRS_NAMAPERUSAHAAN, PRS_NAMAWILAYAH, CUS_NAMAMEMBER,
       CASE
           WHEN PWP_KODEMEMBER IS NULL
               THEN CUS_ALAMATMEMBER1
           ELSE PWP_ALAMAT
       END ALAMAT1,
       CASE
           WHEN PWP_KODEMEMBER IS NULL
               THEN CUS_ALAMATMEMBER4 || ', ' || CUS_ALAMATMEMBER2 || ' '
                    || CUS_ALAMATMEMBER3
           ELSE PWP_KELURAHAN || ', ' || PWP_KOTA || ' ' || PWP_KODEPOS
       END ALAMAT2,
       CUS_NPWP,
          CASE
              WHEN NVL (CUS_FLAGINSTITUSIPEMERINTAH, 'N') = 'Y'
                  THEN '020.'
              ELSE '010.'
          END
       || PRS_KODEMTO
       || '-'
       || TO_CHAR (TO_DATE('$date','DD-MM-YYYY'), 'YY')
       || '.'
       || LPAD (TRJD_NOINVOICE1, 13, '0') SERIAL,
       PLU, TRJD_NOINVOICE1, REPLACE (FKT_NOSERI, 'Y', '') FKT_NOSERI, TRJD_CUS_KODEMEMBER,
       PRD_DESKRIPSIPENDEK, PRD_UNIT, QTY, DISCOUNT, HRGJUAL, HARGA, ADMFEE
  FROM (SELECT   PLU, TRJD_NOINVOICE1, TRJD_CUS_KODEMEMBER, PRD_DESKRIPSIPENDEK, PRD_UNIT,
                 SUM (QTY) QTY,  ROUND (SUM (DISCOUNT)) DISCOUNT,
                 ROUND (SUM (HRGJUAL)) HRGJUAL, ROUND ((SUM (HRGJUAL) / SUM (QTY))) HARGA,
                 SUM (TRJD_ADMFEE) ADMFEE
            FROM (SELECT   SUBSTR (TRJD_PRDCD, 1, 6) || '0' PLU, TRJD_NOINVOICE1,
                           TRJD_CUS_KODEMEMBER, PRD_DESKRIPSIPENDEK, PRD_UNIT,
                           CASE
                               WHEN TRJD_TRANSACTIONTYPE = 'S'
                                   THEN TRJD_QUANTITY * PRD_FRAC * 1
                               ELSE TRJD_QUANTITY * PRD_FRAC * -1
                           END QTY,
                           CASE
                               WHEN TRJD_TRANSACTIONTYPE = 'S'
                                   THEN (0.1 * (TRJD_DISCOUNT))
                               ELSE (0.1 * (TRJD_DISCOUNT)) * -1
                           END DISCOUNT,
                           CASE
                               WHEN TRJD_TRANSACTIONTYPE = 'S'
                                   THEN TRJD_NOMINALAMT
                               ELSE TRJD_NOMINALAMT * -1
                           END HRGJUAL,
                           TRJD_ADMFEE
                      FROM TBTR_JUALDETAIL, TBMASTER_PRODMAST
                     WHERE TRJD_KODEIGR = '$kodeigr'
                       ".$p_and."
                       AND NVL (TRJD_FLAGTAX1, 'N') = 'Y'
                       AND PRD_KODEIGR = TRJD_KODEIGR
                       AND PRD_PRDCD = TRJD_PRDCD
                  ORDER BY PLU) A
        GROUP BY PLU, TRJD_NOINVOICE1, TRJD_CUS_KODEMEMBER, PRD_DESKRIPSIPENDEK, PRD_UNIT) B,
       TBMASTER_PERUSAHAAN,
       TBMASTER_CUSTOMER,
       TBMASTER_NPWP,
       TBMASTER_FAKTUR
 WHERE PRS_KODEIGR = '$kodeigr'
   AND CUS_KODEMEMBER = TRJD_CUS_KODEMEMBER
   AND PWP_KODEIGR(+) = '$kodeigr'
   AND PWP_KODEMEMBER(+) = TRJD_CUS_KODEMEMBER
   AND FKT_NOFAKTUR = TRJD_NOINVOICE1");

        if(sizeof($datas) === 0){
            return "Data not found!";
        }
        //PRINT
        $today = date('d-m-Y');
        $time = date('H:i:s');



        $pdf = PDF::loadview('OMI.perubahan-status-omi-ptkp-to-pkp_fp-pdf',
            ['kodeigr' => $kodeigr, 'datas' => $datas,'nama' => $nama, 'jabatan1' => $jabatan1, 'jabatan2' => $jabatan2, 'p_jmlstruk' => $jmlstruk, 'admfee' => $admfee]);
        $pdf->setPaper('A4', 'potrait');
        $pdf->output();
        $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);

        $canvas = $dompdf ->get_canvas();
        $canvas->page_text(509, 33, "HAL : {PAGE_NUM} / {PAGE_COUNT}", null, 8, array(0, 0, 0));

        return $pdf->stream('rubahstatusomi_fp.pdf');
    }
}
