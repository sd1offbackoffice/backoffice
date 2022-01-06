<?php

namespace App\Http\Controllers\BACKOFFICE\PROSES;

use Carbon\Carbon;
use DateTime;
use Dompdf\Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller; use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use PDF;
use Yajra\DataTables\DataTables;
use File;

class PemutihanPluController extends Controller
{
    public function index()
    {
        return view('BACKOFFICE.PROSES.pemutihan-plu');
    }

    public function startup(){
        $kodeigr = Session::get('kdigr');
        $datas = DB::connection(Session::get('connection'))->table("TBHISTORY_PEMUTIHANPLU")
            ->selectRaw("DISTINCT MAX (HPT_PERIODE) as max_value")
            ->first();

        return response()->json($datas->max_value);
    }

    public function proses(Request $request){
        try {
            DB::connection(Session::get('connection'))->beginTransaction();
            $kodeigr = Session::get('kdigr');
            $userid = Session::get('usid');
            $lastproses = $request->lastproses;
            $status = $request->status;
            $ip = Session::get('ip');
            $ip = str_replace('.', '', $ip);

            if($status == "samedate"){
                DB::connection(Session::get('connection'))->table('TBHISTORY_PEMUTIHANPLU')
                    ->whereRaw("HPT_PERIODE = TRUNC (SYSDATE)")
                    ->delete();
                DB::connection(Session::get('connection'))->table('TBHISTORY_PLUMDY_IGRN')
                    ->whereRaw("HMI_PERIODE = TRUNC (SYSDATE)")
                    ->delete();
                DB::connection(Session::get('connection'))->table('TBHISTORY_PERUBAHANDATAPLU')
                    ->whereRaw("HRP_PERIODE = TRUNC (SYSDATE)")
                    ->delete();
            }

            $connect = loginController::getConnectionProcedure();

            $note = "";
            $query = oci_parse($connect, "BEGIN SP_FILL_DATAMD ('$ip', :ERRM); END;");
            oci_bind_by_name($query, ':ERRM', $note, 999999);
            oci_execute($query);

            if($note == "SUKSES"){
                //FILL_HISTORY(N_REQ_ID)
//                --->>>> Insert History Pemutihan PLU <<<<---
//                -- PLU IGR ada MD gak ada --
                $values = DB::connection(Session::get('connection'))->select("SELECT PRD_KODEIGR, PRD_PRDCD, PRD_KODECABANG, PRD_KATEGORITOKO, PRD_KODETAG, SALDO_AKHIR,
               CASE
                   WHEN NVL (MUTASI, 0) = 0
                       THEN 'N'
                   ELSE 'Y'
               END MUTASI, TRUNC (SYSDATE) as tgl
          FROM TBMASTER_PRODMAST,
               (SELECT   SUBSTR (ST_PRDCD, 1, 6) PLU, SUM (ABS (NVL (ST_SALDOAWAL, 0))) SALDO_AKHIR,
                         SUM (  ABS (NVL (ST_SALDOAWAL, 0))
                              + ABS (NVL (ST_TRFIN, 0))
                              + ABS (NVL (ST_TRFOUT, 0))
                              + ABS (NVL (ST_SALES, 0))
                              + ABS (NVL (ST_ADJ, 0))
                             ) MUTASI
                    FROM TBMASTER_STOCK
                GROUP BY ST_PRDCD)
         WHERE NOT EXISTS (SELECT 1
                             FROM TBTEMP_PLUDATAMD
                            WHERE SUBSTR (FMKPLU, 1, 6) = SUBSTR (PRD_PRDCD, 1, 6))
           AND SUBSTR (PRD_PRDCD, 1, 6) = PLU(+)");
                for($i=0; $i<sizeof($values); $i++){
                    DB::connection(Session::get('connection'))->table("TBHISTORY_PEMUTIHANPLU")
                        ->insert([
                            'HPT_KODEIGR' => $values[$i]->prd_kodeigr,
                            'HPT_PRDCD' => $values[$i]->prd_prdcd,
                            'HPT_KODECABANG' => $values[$i]->prd_kodecabang,
                            'HPT_KATEGORITOKO' => $values[$i]->prd_kategoritoko,
                            'HPT_KODETAG' => $values[$i]->prd_kodetag,
                            'HPT_SALDOAKHIR' => $values[$i]->saldo_akhir,
                            'HPT_MUTASI' => $values[$i]->mutasi,
                            'HPT_PERIODE' => $values[$i]->tgl,
                            'HPT_CREATE_BY' => $userid
                        ]);
                }

//                --->>>> Insert History plumdY_igrN <<<<---
//                -- PLU IGR gak ada MD ada --
                $values = DB::connection(Session::get('connection'))->select("SELECT DISTINCT FMKCAB,
                            SUBSTR (FMKPLU, 1, 6)
                         || CASE
                                WHEN (FMKCAB = '18' OR FMKCAB = '16') AND FMTSJL = '4'
                                    THEN 1
                                ELSE FMTSJL
                            END FMKPLU,
                         FMKTKO, FMKTTK, FMTAGP, TRUNC (SYSDATE) as tgl
                    FROM TBTEMP_PLUDATAMD
                   WHERE FMKCAB = '$kodeigr'
                     AND NOT EXISTS (SELECT 1
                                       FROM TBMASTER_PRODMAST
                                      WHERE SUBSTR (FMKPLU, 1, 6) = SUBSTR (PRD_PRDCD, 1, 6))");
                for($i=0; $i<sizeof($values); $i++){
                    DB::connection(Session::get('connection'))->table("TBHISTORY_PLUMDY_IGRN")
                        ->insert([
                            'HMI_KODEIGR' => $values[$i]->fmkcab,
                            'HMI_PRDCD' => $values[$i]->fmkplu,
                            'HMI_KODECABANG' => $values[$i]->fmktko,
                            'HMI_KATEGORITOKO' => $values[$i]->fmkttk,
                            'HMI_KODETAG' => $values[$i]->fmtagp,
                            'HMI_PERIODE' => $values[$i]->tgl,
                            'HMI_CREATE_BY' => $userid
                        ]);
                }

                //--->>>> Sync data PLU MD-IGR <<<<---
                $values = DB::connection(Session::get('connection'))->select("SELECT FMKCAB, FMKPLU, FMKTKO, PRD_KODECABANG, FMKTTK, PRD_KATEGORITOKO, FMTAGP,
               PRD_KODETAG, TRUNC (SYSDATE) as tgl
          FROM (SELECT DISTINCT    SUBSTR (FMKPLU, 1, 6)
                                || CASE
                                       WHEN (FMKCAB = '18' OR FMKCAB = '16') AND FMTSJL = '4'
                                           THEN 1
                                       ELSE FMTSJL
                                   END FMKPLU,
                                FMKSBU, FMKWIL, FMKCAB, FMKTKO, FMKTTK, FMTAGP            --, FMTSJL
                           FROM TBTEMP_PLUDATAMD
                          WHERE CASE
                                                    WHEN fmkcab = '18' OR fmkcab = '16'
                                                        THEN fmtsjl
                                                    ELSE 0
                                                END <> 1
                            AND REQ_ID = '$ip') A,
               TBMASTER_PRODMAST
         WHERE FMKCAB = '$kodeigr'
           AND FMKPLU = PRD_PRDCD
           AND (   NVL (FMKTKO, 'zz') <> NVL (PRD_KODECABANG, 'zz')
                OR NVL (FMKTTK, 'zz') <> NVL (PRD_KATEGORITOKO, 'zz')
                OR NVL (FMTAGP, '_') <> NVL (PRD_KODETAG, '_')
               )");
                for($i=0; $i<sizeof($values); $i++){
                    DB::connection(Session::get('connection'))->table("TBHISTORY_PERUBAHANDATAPLU")
                        ->insert([
                            'HRP_KODEIGR' => $values[$i]->fmkcab,
                            'HRP_PRDCD' => $values[$i]->fmkplu,
                            'HRP_KODECABANG_N' => $values[$i]->fmktko,
                            'HRP_KODECABANG_O' => $values[$i]->prd_kodecabang,
                            'HRP_KATEGORITOKO_N' => $values[$i]->fmkttk,
                            'HRP_KATEGORITOKO_O' => $values[$i]->prd_kategoritoko,
                            'HRP_KODETAG_N' => $values[$i]->fmtagp,
                            'HRP_KODETAG_O' => $values[$i]->prd_kodetag,
                            'HRP_PERIODE' => $values[$i]->tgl,
                            'HRP_CREATE_BY' => $userid
                        ]);
                }

                //----------

                $rec = DB::connection(Session::get('connection'))->select("SELECT   *
                    FROM (SELECT    SUBSTR (FMKPLU, 1, 6)
                                 || CASE
                                        WHEN (FMKCAB = '18' OR FMKCAB = '16') AND FMTSJL = '4'
                                            THEN 1
                                        ELSE FMTSJL
                                    END FMKPLU,
                                 FMBARC, 'MD' DTA
                            FROM TBTEMP_PLUDATAMD
                           WHERE CASE
								                    WHEN fmkcab = '18' OR fmkcab = '16'
								                        THEN fmtsjl
								                    ELSE 0
								                END <> 1
                             AND FMBARC IS NOT NULL
                             AND FMBARC NOT LIKE 'X%'
												     AND FMBARC NOT LIKE 'NOBRC%'
												     AND NVL (FMTAGP, '9') NOT IN ('N', 'A', 'X')
                          UNION ALL
                          SELECT BRC_PRDCD, BRC_BARCODE, 'IGR' DTA
                            FROM TBMASTER_BARCODE
                           WHERE EXISTS (
                                     SELECT 1
                                       FROM (SELECT    SUBSTR (FMKPLU, 1, 6)
                                                    || CASE
                                                           WHEN (FMKCAB = '18' OR FMKCAB = '16')
                                                           AND FMTSJL = '4'
                                                               THEN 1
                                                           ELSE FMTSJL
                                                       END FMKPLU,
                                                    FMBARC
                                               FROM TBTEMP_PLUDATAMD
                                              WHERE CASE
																		                    WHEN fmkcab = '18' OR fmkcab = '16'
																		                        THEN fmtsjl
																		                    ELSE 0
																		                END <> 1
                                                AND FMBARC IS NOT NULL)
                                      WHERE FMKPLU = BRC_PRDCD))
                ORDER BY FMKPLU, FMBARC, DTA");
                for($i=0;$i<sizeof($rec);$i++){
                    if($rec[$i]->dta == 'IGR'){
                        $temp = DB::connection(Session::get('connection'))->table("TEMP_COMPAREBRC")
                            ->selectRaw("COUNT (1) as result")
                            ->where("PLU",'=',$rec[$i]->fmkplu)
                            ->where("BRC_MD",'=',$rec[$i]->fmbarc) //kenapa check md insert igr?
                            ->first();
                        if($temp->result == 0){
                            DB::connection(Session::get('connection'))->table("TEMP_COMPAREBRC")
                                ->insert([
                                    'PLU' => $rec[$i]->fmkplu,
                                    'BRC_IGR' => $rec[$i]->fmbarc
                                ]);
                        }else{
                            DB::connection(Session::get('connection'))->table("TEMP_COMPAREBRC")
                                ->where("PLU",'=',$rec[$i]->fmkplu)
                                ->where("BRC_MD",'=',$rec[$i]->fmbarc)
                                ->update([
                                    'BRC_IGR' => $rec[$i]->fmbarc
                                ]);
                        }
                    }elseif ($rec[$i]->dta == 'MD'){
                        $temp = DB::connection(Session::get('connection'))->table("TEMP_COMPAREBRC")
                            ->selectRaw("COUNT (1) as result")
                            ->where("PLU",'=',$rec[$i]->fmkplu)
                            ->where("BRC_IGR",'=',$rec[$i]->fmbarc) //kenapa check igr insert md?
                            ->first();
                        if($temp->result == 0){
                            DB::connection(Session::get('connection'))->table("TEMP_COMPAREBRC")
                                ->insert([
                                    'PLU' => $rec[$i]->fmkplu,
                                    'BRC_MD' => $rec[$i]->fmbarc
                                ]);
                        }else{
                            DB::connection(Session::get('connection'))->table("TEMP_COMPAREBRC")
                                ->where("PLU",'=',$rec[$i]->fmkplu)
                                ->where("BRC_IGR",'=',$rec[$i]->fmbarc)
                                ->update([
                                    'BRC_MD' => $rec[$i]->fmbarc
                                ]);
                        }
                    }
                }

                DB::connection(Session::get('connection'))->commit();
                return response()->json(['status' => "berhasil",'message' => "Proses Import File selesai, harap tekan tombol Re/Print Trf File TERLEBIH DAHULU untuk Laporannya."]);
            }else{
                return response()->json(['status' => "error",'message' => $note]);
            }
        }catch(QueryException $e){
            DB::connection(Session::get('connection'))->rollBack();
            $status = 'error';
            $message = $e->getMessage();

            return response()->json(['status' => $status,'message' => $message]);
        }

    }

    public function pemutihanPlu(Request $request){
        try{
            DB::connection(Session::get('connection'))->beginTransaction();
            //Periksa apakah ada data
            $temp = DB::connection(Session::get('connection'))->table("TBHISTORY_PEMUTIHANPLU")
                ->selectRaw("COUNT (1) as result")
                ->whereRaw("NVL (HPT_PROSES, 'zz') = 'zz'")
                ->first();
            if($temp->result == 0){
                return response()->json(['status' => "nodata",'message' => "Tidak ada data yang dihapus"]);
            }
            //PEMUTIHAN
            //---->>>>> PRODMAST <<<<<----
            //--insert history PRODMAST
            $kodeigr = Session::get('kdigr');
            $userid = Session::get('usid');
            $lastproses = $request->lastproses;
            $lastproses = DateTime::createFromFormat('Y-m-d', $lastproses)->format('d-m-Y');

            $values = DB::connection(Session::get('connection'))->select("SELECT * FROM TBMASTER_PRODMAST
         WHERE EXISTS (
                   SELECT 1
                     FROM TBHISTORY_PEMUTIHANPLU
                    WHERE NVL (HPT_PROSES, 'zz') = 'zz'
                      AND NVL (HPT_SALDOAKHIR, 0) = 0
                      AND HPT_MUTASI = 'N'
                      AND HPT_PERIODE = TO_DATE('$lastproses','DD-MM-YYYY')
                      AND HPT_PRDCD = PRD_PRDCD)");

            for($i=0;$i<sizeof($values);$i++){
                DB::connection(Session::get('connection'))->table("TBHISTORY_PEMUTIHANPRODMAST")
                ->insert([
                    'HPRD_KODEIGR' => $values[$i]->prd_kodeigr,
                    'HPRD_RECORDID' => $values[$i]->prd_recordid,
                    'HPRD_PRDCD' => $values[$i]->prd_prdcd,
                    'HPRD_PLUMCG' => $values[$i]->prd_plumcg,
                    'HPRD_PLUSUPPLIER' => $values[$i]->prd_plusupplier,
                    'HPRD_TGLDAFTAR' => $values[$i]->prd_tgldaftar,
                    'HPRD_TGLDISCONTINUE' => $values[$i]->prd_tgldiscontinue,
                    'HPRD_TGLAKTIF' => $values[$i]->prd_tglaktif,
                    'HPRD_KODECABANG' => $values[$i]->prd_kodecabang,
                    'HPRD_KODEDIVISI' => $values[$i]->prd_kodedivisi,
                    'HPRD_KODEDEPARTEMENT' => $values[$i]->prd_kodedepartement,
                    'HPRD_KODEKATEGORIBARANG' => $values[$i]->prd_kodekategoribarang,
                    'HPRD_KODETAG' => $values[$i]->prd_kodetag,
                    'HPRD_PRC_KODEPRINCIPLES' => $values[$i]->prd_prc_kodeprinciples,
                    'HPRD_KODESUPPLIER' => $values[$i]->prd_kodesupplier,
                    'HPRD_BRG_MERK' => $values[$i]->prd_brg_merk,
                    'HPRD_BRG_NAMA' => $values[$i]->prd_brg_nama,
                    'HPRD_BRG_FLAVOR' => $values[$i]->prd_brg_flavor,
                    'HPRD_BRG_KEMASAN' => $values[$i]->prd_brg_kemasang,
                    'HPRD_BRG_SIZE' => $values[$i]->prd_brg_size,
                    'HPRD_DESKRIPSIPENDEK' => $values[$i]->prd_deskripsipendek,
                    'HPRD_DESKRIPSIPANJANG' => $values[$i]->prd_deskripsipanjang,
                    'HPRD_UNIT' => $values[$i]->prd_unit,
                    'HPRD_FRAC' => $values[$i]->prd_frac,
                    'HPRD_KODESATUANJUAL2' => $values[$i]->prd_kodesatuanjual2,
                    'HPRD_ISISATUANJUAL2' => $values[$i]->prd_isisatuanjual2,
                    'HPRD_GROUP' => $values[$i]->prd_group,
                    'HPRD_GROUPPB' => $values[$i]->prd_grouppb,
                    'HPRD_FLAGBANDROL' => $values[$i]->prd_flagbandrol,
                    'HPRD_KODEDIVISIPO' => $values[$i]->prd_kodedivisipo,
                    'HPRD_KATEGORITOKO' => $values[$i]->prd_kategoritoko,
                    'HPRD_MINORDER' => $values[$i]->prd_minorder,
                    'HPRD_SATUANBELI' => $values[$i]->prd_satuanbeli,
                    'HPRD_ISIBELI' => $values[$i]->prd_isibeli,
                    'HPRD_SATUANKONVERSI' => $values[$i]->prd_satuankonversi,
                    'HPRD_FRACKONVERSI' => $values[$i]->frackonversi,
                    'HPRD_BRGNONDISC' => $values[$i]->prd_brgnondisc,
                    'HPRD_PERLAKUANBARANG' => $values[$i]->prd_perlakuanbarang,
                    'HPRD_OPENPRICE' => $values[$i]->prd_openprice,
                    'HPRD_MINJUAL' => $values[$i]->prd_minjual,
                    'HPRD_LASTCOST' => $values[$i]->prd_lastcost,
                    'HPRD_AVGCOST' => $values[$i]->prd_avgcost,
                    'HPRD_MARKUPSTANDARD' => $values[$i]->prd_markupstandard,
                    'HPRD_HRGJUAL' => $values[$i]->prd_hrgjual,
                    'HPRD_HRGJUAL2' => $values[$i]->prd_hrgjual2,
                    'HPRD_HRGJUAL3' => $values[$i]->prd_hrgjual3,
                    'HPRD_FLAGCETAKLABELHARGA' => $values[$i]->prd_flagcetaklabelharga,
                    'HPRD_TGLHRGJUAL' => $values[$i]->prd_tglhrgjual,
                    'HPRD_TGLHRGJUAL2' => $values[$i]->prd_tglhrgjual2,
                    'HPRD_TGLHRGJUAL3' => $values[$i]->prd_tglhrgjual3,
                    'HPRD_FLAGBARCODE1' => $values[$i]->prd_flagbarcode1,
                    'HPRD_FLAGBARCODE2' => $values[$i]->prd_flagbarcode2,
                    'HPRD_FLAGBKP1' => $values[$i]->prd_flagbkp1,
                    'HPRD_FLAGBKP2' => $values[$i]->prd_flagbkp2,
                    'HPRD_FLAGBARANGORDERTOKO' => $values[$i]->prd_flagbarangordertoko,
                    'HPRD_TGLDAFTAR2' => $values[$i]->prd_tgldaftar2,
                    'HPRD_FLAGKELIPATANORDER' => $values[$i]->prd_flagkelipatanorder,
                    'HPRD_DIMENSILEBAR' => $values[$i]->prd_dimensilebar,
                    'HPRD_DIMENSIPANJANG' => $values[$i]->prd_dimensipanjang,
                    'HPRD_DIMENSITINGGI' => $values[$i]->prd_dimensitinggi,
                    'HPRD_FLAGGUDANG' => $values[$i]->prd_flaggudang,
                    'HPRD_FLAGEXPORT' => $values[$i]->prd_flagexport,
                    'HPRD_FLAGNONDISTFEE' => $values[$i]->prd_flagnondistfee,
                    'HPRD_CREATE_BY' => $values[$i]->prd_create_by,
                    'HPRD_CREATE_DT' => $values[$i]->prd_create_dt,
                    'HPRD_MODIFY_BY' => $values[$i]->prd_modify_by,
                    'HPRD_MODIFY_DT' => $values[$i]->prd_modify_dt,
                    'HPRD_BARCODE' => $values[$i]->prd_barcode,
                    'HPRD_FLAGOBI' => $values[$i]->prd_flagobi,
                    'HPRD_FLAGNAS' => $values[$i]->prd_flagnas,
                    'HPRD_FLAGBRD' => $values[$i]->prd_flagbrd,
                    'HPRD_FLAGOMI' => $values[$i]->prd_flagomi,
                    'HPRD_FLAGIDM' => $values[$i]->prd_flagidm,
                    'HPRD_FLAGHBV' => $values[$i]->prd_flaghbv,
                    'HPRD_PROSES_DATE' => Carbon::now(),
                    'HPRD_PROSES_BY' => $userid
                ]);
            }
            //--delete prodmast
            DB::connection(Session::get('connection'))->table("TBMASTER_PRODMAST")
                ->whereRaw("EXISTS (
                    SELECT 1
                      FROM TBHISTORY_PEMUTIHANPLU
                     WHERE NVL (HPT_PROSES, 'zz') = 'zz'
                       AND NVL (HPT_SALDOAKHIR, 0) = 0
                       AND HPT_MUTASI = 'N'
                       AND HPT_PERIODE = TO_DATE('$lastproses','DD-MM-YYYY')
                       AND HPT_PRDCD = PRD_PRDCD)")
                ->delete();

            //---->>>>> PRODCRM <<<<<----
            //--insert history PRODCRM
            $values = DB::connection(Session::get('connection'))->select("SELECT * FROM TBMASTER_PRODCRM
         WHERE EXISTS (
                   SELECT 1
                     FROM TBHISTORY_PEMUTIHANPLU
                    WHERE NVL (HPT_PROSES, 'zz') = 'zz'
                      AND NVL (HPT_SALDOAKHIR, 0) = 0
                      AND HPT_MUTASI = 'N'
                      AND HPT_PERIODE = TO_DATE('$lastproses','DD-MM-YYYY')
                      AND HPT_PRDCD = PRC_PLUIGR)");

            for($i=0;$i<sizeof($values);$i++){
                DB::connection(Session::get('connection'))->table("TBHISTORY_PEMUTIHANPRODCRM")
                    ->insert([
                        'HPRC_KODEIGR' => $values[$i]->prc_kodeigr,
                        'HPRC_GROUP' => $values[$i]->prc_group,
                        'HPRC_PLUIDM' => $values[$i]->prc_pluidm,
                        'HPRC_PLUIGR' => $values[$i]->prc_pluigr,
                        'HPRC_PLUOMI' => $values[$i]->prc_pluomi,
                        'HPRC_HRGJUAL' => $values[$i]->prc_hrgjual,
                        'HPRC_TGLHRGJUAL' => $values[$i]->prc_tglhrgjual,
                        'HPRC_PRICEB' => $values[$i]->prc_priceb,
                        'HPRC_DATEB' => $values[$i]->prc_dateb,
                        'HPRC_PRICEK' => $values[$i]->prc_pricek,
                        'HPRC_DATEK' => $values[$i]->prc_datek,
                        'HPRC_PRICER' => $values[$i]->prc_pricer,
                        'HPRC_DATER' => $values[$i]->prc_dater,
                        'HPRC_PRICEN' => $values[$i]->prc_pricen,
                        'HPRC_DATEN' => $values[$i]->prc_daten,
                        'HPRC_SATUANRENCENG' => $values[$i]->prc_satuanrenceng,
                        'HPRC_MINORDER' => $values[$i]->prc_minorder,
                        'HPRC_MARGINMARKUP' => $values[$i]->prc_marginmarkup,
                        'HPRC_MAXORDEROMI' => $values[$i]->prc_maxorderomi,
                        'HPRC_MINORDEROMI' => $values[$i]->prc_minorderomi,
                        'HPRC_FLAGBKL' => $values[$i]->prc_flagbkl,
                        'HPRC_KODETAG' => $values[$i]->prc_kodetag,
                        'HPRC_CREATE_BY' => $values[$i]->prc_create_by,
                        'HPRC_CREATE_DT' => $values[$i]->prc_create_dt,
                        'HPRC_MODIFY_BY' => $values[$i]->prc_modify_by,
                        'HPRC_MODIFY_DT' => $values[$i]->prc_modify_dt,
                        'HPRC_PROSES_DT' => Carbon::now(),
                        'HPRC_PROSES_BY' => $userid

                    ]);
            }
            //--delete PRODCRM
            DB::connection(Session::get('connection'))->table("TBMASTER_PRODCRM")
                ->whereRaw("EXISTS (
                    SELECT 1
                      FROM TBHISTORY_PEMUTIHANPLU
                     WHERE NVL (HPT_PROSES, 'zz') = 'zz'
                       AND NVL (HPT_SALDOAKHIR, 0) = 0
                       AND HPT_MUTASI = 'N'
                       AND HPT_PERIODE = TO_DATE('$lastproses','DD-MM-YYYY')
                       AND HPT_PRDCD = PRC_PLUIGR)")
                ->delete();

            //---->>>>> STOCK <<<<<----
            //--insert history STOCK
            $values = DB::connection(Session::get('connection'))->select("SELECT * FROM TBMASTER_STOCK
         WHERE EXISTS (
                  SELECT 1
                     FROM TBHISTORY_PEMUTIHANPLU
                    WHERE NVL (HPT_PROSES, 'zz') = 'zz'
                      AND NVL (HPT_SALDOAKHIR, 0) = 0
                      AND HPT_MUTASI = 'N'
                      AND HPT_PERIODE = TO_DATE('$lastproses','DD-MM-YYYY')
                      AND HPT_PRDCD = ST_PRDCD)");
            for($i=0;$i<sizeof($values);$i++){
                DB::connection(Session::get('connection'))->table("TBHISTORY_PEMUTIHANSTOCK")
                    ->insert([
                        'HST_KODEIGR' => $values[$i]->st_kodeigr,
                        'HST_RECORDID' => $values[$i]->st_recordid,
                        'HST_LOKASI' => $values[$i]->st_lokasi,
                        'HST_PRDCD' => $values[$i]->st_prdcd,
                        'HST_SALDOAWAL' => $values[$i]->st_saldoawal,
                        'HST_TRFIN' => $values[$i]->st_trfin,
                        'HST_TRFOUT' => $values[$i]->st_trfout,
                        'HST_SALES' => $values[$i]->st_sales,
                        'HST_RETUR' => $values[$i]->st_retur,
                        'HST_ADJ' => $values[$i]->st_adj,
                        'HST_INTRANSIT' => $values[$i]->st_intransit,
                        'HST_SALDOAKHIR' => $values[$i]->st_saldoakhir,
                        'HST_MIN' => $values[$i]->st_min,
                        'HST_MAX' => $values[$i]->st_max,
                        'HST_LASTCOST' => $values[$i]->st_lastcost,
                        'HST_AVGCOST' => $values[$i]->st_avgcost,
                        'HST_AVGCOSTMONTHEND' => $values[$i]->st_avgcostmonthend,
                        'HST_TGLAVGCOST' => $values[$i]->st_tglavgcost,
                        'HST_RPSALDOAWAL' => $values[$i]->st_rpsaldoawal,
                        'HST_RPSALDOAWAL2' => $values[$i]->st_rpsaldoawal2,
                        'HST_CREATE_BY' => $values[$i]->st_create_by,
                        'HST_CREATE_DT' => $values[$i]->st_create_dt,
                        'HST_MODIFY_BY' => $values[$i]->st_modify_by,
                        'HST_MODIFY_DT' => $values[$i]->st_modify_dt,
                        'HST_PROSES_DT' => Carbon::now(),
                        'HST_PROSES_BY' => $userid
                    ]);
            }
            //--delete stock
            DB::connection(Session::get('connection'))->table("TBMASTER_STOCK")
                ->whereRaw("EXISTS (
                    SELECT 1
                      FROM TBHISTORY_PEMUTIHANPLU
                     WHERE NVL (HPT_PROSES, 'zz') = 'zz'
                       AND NVL (HPT_SALDOAKHIR, 0) = 0
                       AND HPT_MUTASI = 'N'
                       AND HPT_PERIODE = TO_DATE('$lastproses','DD-MM-YYYY')
                       AND HPT_PRDCD = ST_PRDCD)")
                ->delete();

            //---->>>>> LOKASI <<<<<----
            //--insert history LOKASI
            $values = DB::connection(Session::get('connection'))->select("SELECT * FROM TBMASTER_LOKASI
         WHERE EXISTS (
                  SELECT 1
                     FROM TBHISTORY_PEMUTIHANPLU
                    WHERE NVL (HPT_PROSES, 'zz') = 'zz'
                      AND NVL (HPT_SALDOAKHIR, 0) = 0
                      AND HPT_MUTASI = 'N'
                      AND HPT_PERIODE = TO_DATE('$lastproses','DD-MM-YYYY')
                      AND HPT_PRDCD = LKS_PRDCD)");

            for($i=0;$i<sizeof($values);$i++) {
                DB::connection(Session::get('connection'))->table("TBHISTORY_PEMUTIHANLOKASI")
                    ->insert([
                        'HLKS_KODEIGR' => $values[$i]->lks_kodeigr,
                        'HLKS_KODERAK' => $values[$i]->lks_koderak,
                        'HLKS_KODESUBRAK' => $values[$i]->lks_kodesubrak,
                        'HLKS_TIPERAK' => $values[$i]->lks_tiperak,
                        'HLKS_SHELVINGRAK' => $values[$i]->lks_shelvingrak,
                        'HLKS_PRDCD' => $values[$i]->lks_prdcd,
                        'HLKS_NOURUT' => $values[$i]->lks_nourut,
                        'HLKS_DEPANBELAKANG' => $values[$i]->lks_depanbelakang,
                        'HLKS_ATASBAWAH' => $values[$i]->lks_atasbawah,
                        'HLKS_TIRKIRIKANAN' => $values[$i]->lks_tirkirikanan,
                        'HLKS_TIRDEPANBELAKANG' => $values[$i]->lks_tirdepanbelakang,
                        'HLKS_TIRATASBAWAH' => $values[$i]->lks_tiratasbawah,
                        'HLKS_MAXDISPLAY' => $values[$i]->lks_maxdisplay,
                        'HLKS_DIMENSILEBARPRODUK' => $values[$i]->lks_dimensilebarproduk,
                        'HLKS_DIMENSITINGGIPRODUK' => $values[$i]->lks_dimensitinggiproduk,
                        'HLKS_DIMENSIPANJANGPRODUK' => $values[$i]->lks_dimensipanjangproduk,
                        'HLKS_FMMSQR' => $values[$i]->lks_fmmsqr,
                        'HLKS_NOID' => $values[$i]->lks_noid,
                        'HLKS_FLAGUPDATE' => $values[$i]->lks_flagupdate,
                        'HLKS_CREATE_BY' => $values[$i]->lks_create_by,
                        'HLKS_CREATE_DT' => $values[$i]->lks_create_dt,
                        'HLKS_MODIFY_BY' => $values[$i]->lks_modify_by,
                        'HLKS_MODIFY_DT' => $values[$i]->lks_modify_dt,
                        'HLKS_QTY' => $values[$i]->lks_qty,
                        'HLKS_EXPDATE' => $values[$i]->lks_expdate,
                        'HLKS_MINPCT' => $values[$i]->lks_minpct,
                        'HLKS_BOOKED' => $values[$i]->lks_booked,
                        'HLKS_MAXPLANO' => $values[$i]->lks_maxplano,
                        'HLKS_PROSES_DT' => Carbon::now(),
                        'HLKS_PROSES_BY' => $userid
                    ]);
            }
            //--delete LOKASI
            DB::connection(Session::get('connection'))->table("TBMASTER_LOKASI")
                ->whereRaw("EXISTS (
                    SELECT 1
                      FROM TBHISTORY_PEMUTIHANPLU
                     WHERE NVL (HPT_PROSES, 'zz') = 'zz'
                       AND NVL (HPT_SALDOAKHIR, 0) = 0
                       AND HPT_MUTASI = 'N'
                       AND HPT_PERIODE = TO_DATE('$lastproses','DD-MM-YYYY')
                       AND HPT_PRDCD = LKS_PRDCD)")
                ->delete();

            //---->>>>> HARGABELI <<<<<----
            //--insert history HARGABELI
            $values = DB::connection(Session::get('connection'))->select("SELECT * FROM TBMASTER_HARGABELI
         WHERE EXISTS (
                  SELECT 1
                     FROM TBHISTORY_PEMUTIHANPLU
                    WHERE NVL (HPT_PROSES, 'zz') = 'zz'
                      AND NVL (HPT_SALDOAKHIR, 0) = 0
                      AND HPT_MUTASI = 'N'
                      AND HPT_PERIODE = TO_DATE('$lastproses','DD-MM-YYYY')
                      AND HPT_PRDCD = HGB_PRDCD)");
            for($i=0;$i<sizeof($values);$i++){
                DB::connection(Session::get('connection'))->table("TBHISTORY_PEMUTIHANHARGABELI")
                    ->insert([
                        'HHGB_KODEIGR' => $values[$i]->hgb_kodeigr,
                        'HHGB_RECORDID' => $values[$i]->hgb_recordid,
                        'HHGB_TIPE' => $values[$i]->hgb_tipe,
                        'HHGB_PRDCD' => $values[$i]->hgb_prdcd,
                        'HHGB_KODESUPPLIER' => $values[$i]->hgb_kodesupplier,
                        'HHGB_JENISHRGBELI' => $values[$i]->hgb_jenishrgbeli,
                        'HHGB_HRGBELI' => $values[$i]->hgb_hrgbeli,
                        'HHGB_PPNBM' => $values[$i]->hgb_ppnbm,
                        'HHGB_PPN' => $values[$i]->hgb_ppn,
                        'HHGB_PPNBOTOL' => $values[$i]->hgb_ppnbotol,
                        'HHGB_PPNIMPORT' => $values[$i]->hgb_ppnimport,
                        'HHGB_TOP' => $values[$i]->hgb_top,
                        'HHGB_STATUSBARANG' => $values[$i]->hgb_statusbarang,
                        'HHGB_ISISATUANBELI' => $values[$i]->hgb_isisatuanbeli,
                        'HHGB_TGLMULAIDISC01' => $values[$i]->hgb_tglmulaidisc01,
                        'HHGB_TGLAKHIRDISC01' => $values[$i]->hgb_tglakhirdisc01,
                        'HHGB_PERSENDISC01' => $values[$i]->hgb_persendisc01,
                        'HHGB_RPHDISC01' => $values[$i]->hgb_rphdisc01,
                        'HHGB_FLAGDISC01' => $values[$i]->hgb_flagdisc01,
                        'HHGB_TGLMULAIDISC02' => $values[$i]->hgb_tglmulaidisc02,
                        'HHGB_TGLAKHIRDISC02' => $values[$i]->hgb_tglakhirdisc02,
                        'HHGB_PERSENDISC02' => $values[$i]->hgb_persendisc02,
                        'HHGB_RPHDISC02' => $values[$i]->hgb_rphdisc02,
                        'HHGB_FLAGDISC02' => $values[$i]->hgb_flagdisc02,
                        'HHGB_TGLMULAIDISC02II' => $values[$i]->hgb_tglmulaidisc02ii,
                        'HHGB_TGLAKHIRDISC02II' => $values[$i]->hgb_tglakhirdisc02ii,
                        'HHGB_PERSENDISC02II' => $values[$i]->hgb_persendisc02ii,
                        'HHGB_RPHDISC02II' => $values[$i]->hgb_rphdisc02ii,
                        'HHGB_FLAGDISC02II' => $values[$i]->hgb_flagdisc02ii,
                        'HHGB_TGLMULAIDISC02III' => $values[$i]->hgb_tglmulaidisc02iii,
                        'HHGB_TGLAKHIRDISC02III' => $values[$i]->hgb_tglakhirdisc02iii,
                        'HHGB_PERSENDISC02III' => $values[$i]->hgb_persendisc02iii,
                        'HHGB_RPHDISC02III' => $values[$i]->hgb_rphdisc02iii,
                        'HHGB_FLAGDISC02III' => $values[$i]->hgb_flagdisc02iii,
                        'HHGB_TGLMULAIDISC03' => $values[$i]->hgb_tglmulaidisc03,
                        'HHGB_TGLAKHIRDISC03' => $values[$i]->hgb_tglakhirdisc03,
                        'HHGB_PERSENDISC03' => $values[$i]->hgb_persendisc03,
                        'HHGB_RPHDISC03' => $values[$i]->hgb_rphdisc03,
                        'HHGB_FLAGDISC03' => $values[$i]->hgb_flagdisc03,
                        'HHGB_TGLMULAIDISC04' => $values[$i]->hgb_tglmulaidisc04,
                        'HHGB_TGLAKHIRDISC04' => $values[$i]->hgb_tglakhirdisc04,
                        'HHGB_PERSENDISC04' => $values[$i]->hgb_persendisc04,
                        'HHGB_RPHDISC04' => $values[$i]->hgb_rphdisc04,
                        'HHGB_FLAGDISC04' => $values[$i]->hgb_flagdisc04,
                        'HHGB_TGLMULAIDISC05' => $values[$i]->hgb_tglmulaidisc05,
                        'HHGB_TGLAKHIRDISC05' => $values[$i]->hgb_tglakhirdisc05,
                        'HHGB_PERSENDISC05' => $values[$i]->hgb_persendisc05,
                        'HHGB_RPHDISC05' => $values[$i]->hgb_rphdisc05,
                        'HHGB_FLAGDISC05' => $values[$i]->hgb_flagdisc05,
                        'HHGB_TGLMULAIDISC06' => $values[$i]->hgb_tglmulaidisc06,
                        'HHGB_TGLAKHIRDISC06' => $values[$i]->hgb_tglakhirdisc06,
                        'HHGB_PERSENDISC06' => $values[$i]->hgb_persendisc06,
                        'HHGB_RPHDISC06' => $values[$i]->hgb_rphdisc06,
                        'HHGB_FLAGDISC06' => $values[$i]->hgb_flagdisc06,
                        'HHGB_FLAGKELIPATANBONUS01' => $values[$i]->hgb_flagkelipatanbonus01,
                        'HHGB_FLAGKELIPATANBONUS02' => $values[$i]->hgb_flagkelipatanbonus02,
                        'HHGB_JENISBONUS' => $values[$i]->hgb_jenisbonus,
                        'HHGB_TGLMULAIBONUS01' => $values[$i]->hgb_tglmulaibonus01,
                        'HHGB_TGLAKHIRBONUS01' => $values[$i]->hgb_tglakhirbonus01,
                        'HHGB_QTYMULAI1BONUS01' => $values[$i]->hgb_qtymulai1bonus01,
                        'HHGB_QTYAKHIR1BONUS01' => $values[$i]->hgb_qtyakhir1bonus01,
                        'HHGB_QTY1BONUS01' => $values[$i]->hgb_qty1bonus01,
                        'HHGB_QTYMULAI2BONUS01' => $values[$i]->hgb_qtymulai2bonus01,
                        'HHGB_QTYAKHIR2BONUS01' => $values[$i]->hgb_qtyakhir2bonus01,
                        'HHGB_QTY2BONUS01' => $values[$i]->hgb_qty2bonus01,
                        'HHGB_QTYMULAI3BONUS01' => $values[$i]->hgb_qtymulai3bonus01,
                        'HHGB_QTYAKHIR3BONUS01' => $values[$i]->hgb_qtyakhir3bonus01,
                        'HHGB_QTY3BONUS01' => $values[$i]->hgb_qty3bonus01,
                        'HHGB_QTYMULAI4BONUS01' => $values[$i]->hgb_qtymulai4bonus01,
                        'HHGB_QTYAKHIR4BONUS01' => $values[$i]->hgb_qtyakhir4bonus01,
                        'HHGB_QTY4BONUS01' => $values[$i]->hgb_qty4bonus01,
                        'HHGB_QTYMULAI5BONUS01' => $values[$i]->hgb_qtymulai5bonus01,
                        'HHGB_QTYAKHIR5BONUS01' => $values[$i]->hgb_qtyakhir5bonus01,
                        'HHGB_QTY5BONUS01' => $values[$i]->hgb_qty5bonus01,
                        'HHGB_QTYMULAI6BONUS01' => $values[$i]->hgb_qtymulai6bonus01,
                        'HHGB_QTYAKHIR6BONUS01' => $values[$i]->hgb_qtyakhir6bonus01,
                        'HHGB_QTY6BONUS01' => $values[$i]->hgb_qty6bonus01,
                        'HHGB_TGLMULAIBONUS02' => $values[$i]->hgb_tglmulaibonus02,
                        'HHGB_TGLAKHIRBONUS02' => $values[$i]->hgb_tglakhirbonus02,
                        'HHGB_QTYMULAI1BONUS02' => $values[$i]->hgb_qtymulai1bonus02,
                        'HHGB_QTYAKHIR1BONUS02' => $values[$i]->hgb_qtyakhir1bonus02,
                        'HHGB_QTY1BONUS02' => $values[$i]->hgb_qty1bonus02,
                        'HHGB_QTYMULAI2BONUS02' => $values[$i]->hgb_qtymulai2bonus02,
                        'HHGB_QTYAKHIR2BONUS02' => $values[$i]->hgb_qtyakhir2bonus02,
                        'HHGB_QTY2BONUS02' => $values[$i]->hgb_qty2bonus02,
                        'HHGB_QTYMULAI3BONUS02' => $values[$i]->hgb_qtymulai3bonus02,
                        'HHGB_QTYAKHIR3BONUS02' => $values[$i]->hgb_qtyakhir3bonus02,
                        'HHGB_QTY3BONUS02' => $values[$i]->hgb_qty3bonus02,
                        'HHGB_TGLBERLAKU01' => $values[$i]->hgb_tglberlaku01,
                        'HHGB_TGLBERLAKU02' => $values[$i]->hgb_tglberlaku02,
                        'HHGB_NILAIDPP' => $values[$i]->hgb_nilaidpp,
                        'HHGB_PPNDPP' => $values[$i]->hgb_ppndpp,
                        'HHGB_CREATE_BY' => $values[$i]->hgb_create_by,
                        'HHGB_CREATE_DT' => $values[$i]->hgb_create_dt,
                        'HHGB_MODIFY_BY' => $values[$i]->hgb_modify_by,
                        'HHGB_MODIFY_DT' => $values[$i]->hgb_modify_dt,
                        'HHGB_PROSES_DT' => Carbon::now(),
                        'HHGB_PROSES_BY' => $userid
                    ]);
            }
            //--delete hargabeli
            DB::connection(Session::get('connection'))->table("TBMASTER_HARGABELI")
                ->whereRaw("EXISTS (
                    SELECT 1
                      FROM TBHISTORY_PEMUTIHANPLU
                     WHERE NVL (HPT_PROSES, 'zz') = 'zz'
                       AND NVL (HPT_SALDOAKHIR, 0) = 0
                       AND HPT_MUTASI = 'N'
                       AND HPT_PERIODE = TO_DATE('$lastproses','DD-MM-YYYY')
                       AND HPT_PRDCD = HGB_PRDCD)")
                ->delete();

            //---->>>>> KKPKM <<<<<----
            //--insert history KKPKM
            $values = DB::connection(Session::get('connection'))->select("SELECT * FROM TBMASTER_KKPKM
         WHERE EXISTS (
                   SELECT 1
                     FROM TBHISTORY_PEMUTIHANPLU
                    WHERE NVL (HPT_PROSES, 'zz') = 'zz'
                      AND NVL (HPT_SALDOAKHIR, 0) = 0
                      AND HPT_MUTASI = 'N'
                      AND HPT_PERIODE = TO_DATE('$lastproses','DD-MM-YYYY')
                      AND HPT_PRDCD = PKM_PRDCD)");

            for($i=0;$i<sizeof($values);$i++){
                DB::connection(Session::get('connection'))->table("TBHISTORY_PEMUTIHANKKPKM")
                    ->insert([
                        'HPKM_KODEIGR' => $values[$i]->pkm_kodeigr,
                        'HPKM_KODEDIVISI' => $values[$i]->pkm_kodedivisi,
                        'HPKM_KODEDEPARTEMENT' => $values[$i]->pkm_kodedepartement,
                        'HPKM_PERIODEPROSES' => $values[$i]->pkm_periodeorises,
                        'HPKM_KODEKATEGORIBARANG' => $values[$i]->pkm_kodekategoribarang,
                        'HPKM_PRDCD' => $values[$i]->pkm_prdcd,
                        'HPKM_KODESUPPLIER' => $values[$i]->pkm_kodesupplier,
                        'HPKM_MINDISPLASY' => $values[$i]->pkm_mindisplay,
                        'HPKM_PERIODE1' => $values[$i]->pkm_periode1,
                        'HPKM_PERIODE2' => $values[$i]->pkm_periode2,
                        'HPKM_PERIODE3' => $values[$i]->pkm_periode3,
                        'HPKM_QTY1' => $values[$i]->pkm_qty1,
                        'HPKM_QTY2' => $values[$i]->pkm_qty2,
                        'HPKM_QTY3' => $values[$i]->pkm_qty3,
                        'HPKM_QTYAVERAGE' => $values[$i]->pkm_qtyaverage,
                        'HPKM_MINORDER' => $values[$i]->pkm_minorder,
                        'HPKM_LEADTIME' => $values[$i]->pkm_leadtime,
                        'HPKM_STOCK' => $values[$i]->pkm_stock,
                        'HPKM_PKM' => $values[$i]->pkm_pkm,
                        'HPKM_MPKM' => $values[$i]->pkm_mpkm,
                        'HPKM_PKMT' => $values[$i]->pkm_pkmt,
                        'HPKM_PKMB' => $values[$i]->pkm_pkmb,
                        'HPKM_CREATE_BY' => $values[$i]->pkm_create_by,
                        'HPKM_CREATE_DT' => $values[$i]->pkm_create_dt,
                        'HPKM_MODIFY_BY' => $values[$i]->pkm_modify_by,
                        'HPKM_MODIFY_DT' => $values[$i]->pkm_modify_dt,
                        'HPKM_HARI1' => $values[$i]->pkm_hari1,
                        'HPKM_HARI2' => $values[$i]->pkm_hari2,
                        'HPKM_HARI3' => $values[$i]->pkm_hari3,
                        'HPKM_KOEFISIEN' => $values[$i]->pkm_koefisien,
                        'HPKM_PROSES_DT' => Carbon::now(),
                        'HPKM_PROSES_BY' => $userid,
                    ]);
            }
            //--delete KKPKM
            DB::connection(Session::get('connection'))->table("TBMASTER_KKPKM")
                ->whereRaw("EXISTS (
                    SELECT 1
                      FROM TBHISTORY_PEMUTIHANPLU
                     WHERE NVL (HPT_PROSES, 'zz') = 'zz'
                       AND NVL (HPT_SALDOAKHIR, 0) = 0
                       AND HPT_MUTASI = 'N'
                       AND HPT_PERIODE = TO_DATE('$lastproses','DD-MM-YYYY')
                       AND HPT_PRDCD = PKM_PRDCD)")
                ->delete();

            //---->>>>> BRGEXPORT <<<<<----
            //--insert history BRGEXPORT
            $values = DB::connection(Session::get('connection'))->select("SELECT * FROM TBMASTER_BARANGEXPORT
         WHERE EXISTS (
                   SELECT 1
                     FROM TBHISTORY_PEMUTIHANPLU
                    WHERE NVL (HPT_PROSES, 'zz') = 'zz'
                      AND NVL (HPT_SALDOAKHIR, 0) = 0
                      AND HPT_MUTASI = 'N'
                      AND HPT_PERIODE = TO_DATE('$lastproses','DD-MM-YYYY')
                      AND HPT_PRDCD = EXP_PRDCD)");

            for($i=0;$i<sizeof($values);$i++){
                DB::connection(Session::get('connection'))->table("TBHISTORY_PEMUTIHANBRGEXPORT")
                    ->insert([
                        'HEXP_KODEIGR' => $values[$i]->exp_kodeigr,
                        'HEXP_RECORDID' => $values[$i]->exp_recordid,
                        'HEXP_PRDCD' => $values[$i]->exp_prdcd,
                        'HEXP_DESKRIPSIPENDEK' => $values[$i]->exp_deskripsipendek,
                        'HEXP_DESKRIPSIPANJANG' => $values[$i]->exp_deskripsipanjang,
                        'HEXP_FRAC' => $values[$i]->exp_frac,
                        'HEXP_BERATPCS' => $values[$i]->exp_beratpcs,
                        'HEXP_BERATBOX' => $values[$i]->exp_beratbox,
                        'HEXP_BERATCTN' => $values[$i]->exp_beratctn,
                        'HEXP_DIMENSIPANJANGKEMASAN' => $values[$i]->exp_dimensipanjangkemasan,
                        'HEXP_DIMENSILEBARKEMASAN' => $values[$i]->exp_dimensilebarkemasan,
                        'HEXP_DIMENSITINGGIKEMASAN' => $values[$i]->exp_dimensitinggikemasan,
                        'HEXP_CREATE_BY' => $values[$i]->exp_create_by,
                        'HEXP_CREATE_DT' => $values[$i]->exp_create_dt,
                        'HEXP_MODIFY_BY' => $values[$i]->exp_modify_by,
                        'HEXP_MODIFY_DT' => $values[$i]->exp_modify_dt,
                        'HEXP_PROSES_DT' => Carbon::now(),
                        'HEXP_PROSES_BY' => $userid
                    ]);
            }
            //--delete BRGEXPORT
            DB::connection(Session::get('connection'))->table("TBMASTER_BARANGEXPORT")
                ->whereRaw("EXISTS (
                    SELECT 1
                      FROM TBHISTORY_PEMUTIHANPLU
                     WHERE NVL (HPT_PROSES, 'zz') = 'zz'
                       AND NVL (HPT_SALDOAKHIR, 0) = 0
                       AND HPT_MUTASI = 'N'
                       AND HPT_PERIODE = TO_DATE('$lastproses','DD-MM-YYYY')
                       AND HPT_PRDCD = EXP_PRDCD)")
                ->delete();

            //---->>>>> update master_prodmast <<<<<----
            DB::connection(Session::get('connection'))->raw("UPDATE TBMASTER_PRODMAST
       SET PRD_KODECABANG = (SELECT HRP_KODECABANG_N
                               FROM TBHISTORY_PERUBAHANDATAPLU
                              WHERE HRP_PRDCD = PRD_PRDCD AND HRP_PERIODE = TO_DATE('$lastproses','DD-MM-YYYY')),
           PRD_KATEGORITOKO = (SELECT HRP_KATEGORITOKO_N
                                 FROM TBHISTORY_PERUBAHANDATAPLU
                                WHERE HRP_PRDCD = PRD_PRDCD AND HRP_PERIODE = TO_DATE('$lastproses','DD-MM-YYYY')),
           PRD_KODETAG = (SELECT HRP_KODETAG_N
                            FROM TBHISTORY_PERUBAHANDATAPLU
                           WHERE HRP_PRDCD = PRD_PRDCD AND HRP_PERIODE = TO_DATE('$lastproses','DD-MM-YYYY'))
     WHERE EXISTS (SELECT 1
                     FROM TBHISTORY_PERUBAHANDATAPLU
                    WHERE HRP_PRDCD = PRD_PRDCD AND HRP_PERIODE = TO_DATE('$lastproses','DD-MM-YYYY'))");

//            $values = DB::connection(Session::get('connection'))->table("TBHISTORY_PERUBAHANDATAPLU")
//                ->selectRaw("HRP_KODECABANG_N, HRP_KATEGORITOKO_N, HRP_KODETAG_N")
//                ->leftJoin("TBMASTER_PRODMAST","PRD_PRDCD","=","HRP_PRDCD")
//                ->whereRaw("HRP_PERIODE = TO_DATE('$lastproses','DD-MM-YYYY')")
//                ->get();
//
//            if(sizeof($values) != 0){
//                DB::connection(Session::get('connection'))->table("TBMASTER_PRODMAST")
//                    ->whereRaw("EXISTS (SELECT 1
//                     FROM TBHISTORY_PERUBAHANDATAPLU
//                    WHERE HRP_PRDCD = PRD_PRDCD AND HRP_PERIODE = TO_DATE('$lastproses','DD-MM-YYYY')")
//                    ->update([
//                        'PRD_KODECABANG' => $values[0]->hrp_kodecabang_n,
//                        'PRD_KATEGORITOKO' => $values[0]->hrp_kategoritoko_n,
//                        'PRD_KODETAG' => $values[0]->hrp_kodetag_n
//                    ]);
//            }
//            for($i=0;$i<sizeof($values);$i++){
            //not sure if this gonna work
            //            DB::connection(Session::get('connection'))->table("TBMASTER_PRODMAST")
//                ->whereRaw("EXISTS (SELECT 1
//                     FROM TBHISTORY_PERUBAHANDATAPLU
//                    WHERE HRP_PRDCD = PRD_PRDCD AND HRP_PERIODE = TO_DATE('$lastproses','DD-MM-YYYY')")
//                ->update([
//                    'PRD_KODECABANG' => DB::connection(Session::get('connection'))->raw("SELECT HRP_KODECABANG_N
//                               FROM TBHISTORY_PERUBAHANDATAPLU
//                              WHERE HRP_PRDCD = PRD_PRDCD AND HRP_PERIODE = TO_DATE('$lastproses','DD-MM-YYYY')"),
//                    'PRD_KATEGORITOKO' => DB::connection(Session::get('connection'))->raw("SELECT HRP_KATEGORITOKO_N
//                               FROM TBHISTORY_PERUBAHANDATAPLU
//                              WHERE HRP_PRDCD = PRD_PRDCD AND HRP_PERIODE = TO_DATE('$lastproses','DD-MM-YYYY')"),
//                    'PRD_KODETAG' => DB::connection(Session::get('connection'))->raw("SELECT HRP_KODETAG_N
//                               FROM TBHISTORY_PERUBAHANDATAPLU
//                              WHERE HRP_PRDCD = PRD_PRDCD AND HRP_PERIODE = TO_DATE('$lastproses','DD-MM-YYYY')")
//                ]);

//            }

            //---->>>>> hpt_proses dibintangin <<<<<----
            DB::connection(Session::get('connection'))->table("TBHISTORY_PEMUTIHANPLU")
                ->whereRaw("NVL (HPT_SALDOAKHIR, 0) = 0 AND HPT_MUTASI = 'N' AND HPT_PERIODE = TO_DATE('$lastproses','DD-MM-YYYY')")
                ->update([
                    'HPT_PROSES' => '*'
                ]);
            //---->>>>> hrp_proses dibintangin <<<<<----
            DB::connection(Session::get('connection'))->table("TBHISTORY_PERUBAHANDATAPLU")
                ->whereRaw("HRP_PERIODE = TO_DATE('$lastproses','DD-MM-YYYY')")
                ->update([
                    'HRP_PROSES' => '*'
                ]);

            //---->>>>> delete master_barcode yang PLU nya gak ada di prodmast <<<<<----
            $values = DB::connection(Session::get('connection'))->select("SELECT * FROM TBMASTER_BARCODE
         WHERE NOT EXISTS (SELECT 1
                              FROM TBMASTER_PRODMAST
                             WHERE PRD_PRDCD = BRC_PRDCD)");

            for($i=0;$i<sizeof($values);$i++){
                DB::connection(Session::get('connection'))->table("TBHISTORY_PEMUTIHANBARCODE")
                    ->insert([
                        'HBRC_PRDCD' => $values[$i]->brc_prdcd,
                        'HBRC_BARCODE' => $values[$i]->brc_barcode,
                        'HBRC_STATUS' => $values[$i]->brc_status,
                        'HBRC_CREATE_BY' => $values[$i]->brc_create_by,
                        'HBRC_CREATE_DT' => $values[$i]->brc_create_dt,
                        'HBRC_MODIFY_BY' => $values[$i]->brc_modify_by,
                        'HBRC_MODIFY_DT' => $values[$i]->brc_modify_dt,
                        'HHGB_PROSES_DT' => Carbon::now(),
                        'HHGB_PROSES_BY' => $userid
                    ]);
            }
            DB::connection(Session::get('connection'))->table("TBMASTER_BARCODE")
                ->whereRaw("NOT EXISTS (SELECT 1
                              FROM TBMASTER_PRODMAST
                             WHERE PRD_PRDCD = BRC_PRDCD)")
                ->delete();
            DB::connection(Session::get('connection'))->commit();
            return response()->json(['status' => "sukses",'message' => "PEMUTIHAN PLU SELESAI"]);
        }catch(QueryException $e){
            DB::connection(Session::get('connection'))->rollBack();
            $status = 'Pemulihan Error';
            $message = $e->getMessage();

            return response()->json(['status' => $status,'message' => $message]);
        }
    }

    public function pemutihanBarcode(Request $request){
        try {
            DB::connection(Session::get('connection'))->beginTransaction();
            $kodeigr = Session::get('kdigr');
            $userid = Session::get('usid');
            $lastproses = $request->lastproses;
            $lastproses = DateTime::createFromFormat('Y-m-d', $lastproses)->format('d-m-Y');

            //---->>>>> delete master_barcode yang PLU nya gak ada di prodmast <<<<<----
            $values = DB::connection(Session::get('connection'))->select("SELECT * FROM TBMASTER_BARCODE
         WHERE NOT EXISTS (SELECT 1
                              FROM TBMASTER_PRODMAST
                             WHERE PRD_PRDCD = BRC_PRDCD)");

            for($i=0;$i<sizeof($values);$i++){
                DB::connection(Session::get('connection'))->table("TBHISTORY_PEMUTIHANBARCODE")
                    ->insert([
                        'HBRC_PRDCD' => $values[$i]->brc_prdcd,
                        'HBRC_BARCODE' => $values[$i]->brc_barcode,
                        'HBRC_STATUS' => $values[$i]->brc_status,
                        'HBRC_CREATE_BY' => $values[$i]->brc_create_by,
                        'HBRC_CREATE_DT' => $values[$i]->brc_create_dt,
                        'HBRC_MODIFY_BY' => $values[$i]->brc_modify_by,
                        'HBRC_MODIFY_DT' => $values[$i]->brc_modify_dt,
                        'HHGB_PROSES_DT' => Carbon::now(),
                        'HHGB_PROSES_BY' => $userid
                    ]);
            }
            DB::connection(Session::get('connection'))->table("TBMASTER_BARCODE")
                ->whereRaw("NOT EXISTS (SELECT 1
                              FROM TBMASTER_PRODMAST
                             WHERE PRD_PRDCD = BRC_PRDCD)")
                ->delete();

            //---->>>>> insert barcode yang ada di MD gak ada di IGR <<<<<----
            DB::connection(Session::get('connection'))->raw("INSERT INTO TBMASTER_BARCODE
                (BRC_PRDCD, BRC_BARCODE, BRC_STATUS, BRC_CREATE_BY, BRC_CREATE_DT)
        SELECT    SUBSTR (FMKPLU, 1, 6)
               || CASE
                      WHEN (FMKCAB = '18' OR FMKCAB = '16') AND FMTSJL = '4'
                          THEN 1
                      ELSE FMTSJL
                  END FMKPLU,
               FMBARC, 'BC', '$userid', SYSDATE
          FROM TBTEMP_PLUDATAMD
         WHERE FMKCAB = '$kodeigr'
           AND CASE
             WHEN FMKCAB = '18' OR FMKCAB = '16'
                 THEN FMTSJL
             ELSE 0
         			END <> '1'
           AND FMBARC IS NOT NULL
           AND NOT EXISTS (SELECT 1
                             FROM TBMASTER_BARCODE
                            WHERE FMBARC = BRC_BARCODE)
           AND FMBARC NOT LIKE 'X%'
           AND FMBARC NOT LIKE 'NOBRC%'
           AND NVL (FMTAGP, '9') NOT IN ('N', 'A', 'X')
           AND TGLPROSES = TO_DATE('$lastproses','DD-MM-YYYY')");

            return response()->json(['status' => "sukses",'message' => "PEMUTIHAN BARCODE SELESAI"]);
        }catch(QueryException $e){
            DB::connection(Session::get('connection'))->rollBack();
            $status = 'Pemulihan Error';
            $message = $e->getMessage();

            return response()->json(['status' => $status,'message' => $message]);
        }
    }

    public function printLap1(Request $request){
        //IGR_BO_PEMUTIHANPLUQTY.jsp
        $kodeigr = Session::get('kdigr');
        $periode = $request->lastproses;
        $periode = DateTime::createFromFormat('Y-m-d', $periode)->format('d-m-Y');
        $qty = $request->qty; //parameter 1 di program lama
        $mutasi = $request->mutasi; // parameter 2 di program lama


        if($qty == '0'){
            if($mutasi == 'Y'){
                $ket = "DENGAN STOCK = 0 DAN ADA MUTASI LPP";
                $kosong = "TIDAK ADA PLU YANG BEDA DENGAN STOCK = 0 DAN ADA MUTASI LPP";
            }else{
                $ket = "DENGAN STOCK = 0 DAN TIDAK ADA MUTASI LPP";
                $kosong = "TIDAK ADA PLU YANG BEDA DENGAN STOCK = 0 DAN TIDAK ADA MUTASI LPP";
            }
        }else{
            $ket = "DENGAN STOCK > 0";
            $kosong = "TIDAK ADA PLU YANG BEDA DENGAN STOCK > 0";
        }

        if($qty == '0'){
            $p_qty = "AND NVL (HPT_SALDOAKHIR, 0) <= 0";
        }else{
            $p_qty = "AND NVL (HPT_SALDOAKHIR, 0) > 0";
        }

        if($mutasi == 'Y'){
            $p_mutasi = "AND HPT_MUTASI = 'Y'";
        }else{
            $p_mutasi = "AND HPT_MUTASI = 'N'";
        }

        $datas = DB::connection(Session::get('connection'))->select("SELECT   PRS_NAMAPERUSAHAAN, PRS_NAMACABANG, TO_CHAR (HPT_PERIODE, 'DD-MM-YY') PERIODE, HPT_PRDCD,
         PRD_DESKRIPSIPANJANG, PRD_UNIT || ' / ' || PRD_FRAC SATUAN, HPT_KODECABANG, HPT_KATEGORITOKO,
         HPT_KODETAG, HPT_SALDOAKHIR
    FROM TBHISTORY_PEMUTIHANPLU, TBMASTER_PRODMAST, TBMASTER_PERUSAHAAN
   WHERE HPT_PRDCD = PRD_PRDCD
     AND HPT_KODEIGR = PRS_KODEIGR
     AND PRS_KODEIGR = '$kodeigr'
     AND NVL (HPT_PROSES, 'zz') = 'zz'
     AND hpt_periode = TO_DATE('$periode','DD-MM-YYYY')
     ".$p_qty."
     ".$p_mutasi."
ORDER BY HPT_PRDCD");
        if(sizeof($datas) != 0){
            $periode_db = $datas[0]->periode;
        }else{
            $periode_db = '';
        }
        //PRINT
        $perusahaan = DB::table("tbmaster_perusahaan")->first();
        return view('BACKOFFICE.PROSES.pemutihan-plu-lap1-pdf',
            ['kodeigr' => $kodeigr, 'data' => $datas, 'perusahaan' => $perusahaan,
                'periode' => $periode_db, 'ket' => $ket, 'kosong' => $kosong]);
    }

    public function printLap2(Request $request){
        //IGR_BO_PEMUTIHANPLUMDYIGRN.jsp
        $kodeigr = Session::get('kdigr');
        $periode = $request->lastproses;
        $periode = DateTime::createFromFormat('Y-m-d', $periode)->format('d-m-Y');

        $datas = DB::connection(Session::get('connection'))->select("SELECT   PRS_NAMAPERUSAHAAN, PRS_NAMACABANG, HMI_PRDCD, HMI_KODECABANG, HMI_KATEGORITOKO,
         HMI_KODETAG
    FROM TBHISTORY_PLUMDY_IGRN, TBMASTER_PERUSAHAAN
   WHERE PRS_KODEIGR = HMI_KODEIGR AND HMI_KODEIGR = '$kodeigr' AND HMI_PERIODE = TO_DATE('$periode','DD-MM-YYYY')
and not exists (select 1 from tbmaster_prodmast where prd_prdcd=hmi_prdcd)
ORDER BY HMI_PRDCD");

        //PRINT
        $perusahaan = DB::table("tbmaster_perusahaan")->first();
        return view('BACKOFFICE.PROSES.pemutihan-plu-lap2-pdf',
            ['kodeigr' => $kodeigr, 'data' => $datas, 'perusahaan' => $perusahaan]);
    }

    public function printLap3(Request $request){
        //IGR_BO_PEMUTIHANPLUSYNC.jsp
        $kodeigr = Session::get('kdigr');
        $periode = $request->lastproses;
        $periode = DateTime::createFromFormat('Y-m-d', $periode)->format('d-m-Y');

        $datas = DB::connection(Session::get('connection'))->select("SELECT   PRS_NAMAPERUSAHAAN, PRS_NAMACABANG, HRP_PRDCD, PRD_DESKRIPSIPANJANG, HRP_KODECABANG_O,
         HRP_KODECABANG_N, HRP_KATEGORITOKO_O, HRP_KATEGORITOKO_N, HRP_KODETAG_O, HRP_KODETAG_N
    FROM TBHISTORY_PERUBAHANDATAPLU, TBMASTER_PRODMAST, TBMASTER_PERUSAHAAN
   WHERE HRP_KODEIGR = PRS_KODEIGR
     AND PRS_KODEIGR = '$kodeigr'
     AND HRP_PRDCD = PRD_PRDCD
     AND HRP_PERIODE = TO_DATE('$periode','DD-MM-YYYY')
     AND HRP_PROSES IS NULL
ORDER BY HRP_PRDCD");

        //PRINT
        $perusahaan = DB::table("tbmaster_perusahaan")->first();
        return view('BACKOFFICE.PROSES.pemutihan-plu-lap3-pdf',
            ['kodeigr' => $kodeigr, 'data' => $datas, 'perusahaan' => $perusahaan]);
    }

    public function printLap4(Request $request){
        //IGR_BO_PTHBRC_IGRYMDN.jsp
        //--igr ada md gak ada
        $kodeigr = Session::get('kdigr');
        $periode = $request->lastproses;
        $periode = DateTime::createFromFormat('Y-m-d', $periode)->format('d-m-Y');

        $datas = DB::connection(Session::get('connection'))->select("SELECT   PRS_NAMAPERUSAHAAN, PRS_NAMACABANG, BRC_PRDCD, PRD_DESKRIPSIPANJANG, PRD_KODETAG,
         BRC_BARCODE, BRC_STATUS
    FROM TBMASTER_BARCODE, TBMASTER_PRODMAST, TBMASTER_PERUSAHAAN
   WHERE BRC_STATUS = 'BC'
     AND NOT EXISTS (
             SELECT 1
               FROM (SELECT    SUBSTR (FMKPLU, 1, 6)
                            || CASE
                                   WHEN (FMKCAB = '18' OR FMKCAB = '16') AND FMTSJL = '4'
                                       THEN 1
                                   ELSE FMTSJL
                               END FMKPLU,
                            FMBARC
                       FROM TBTEMP_PLUDATAMD
                      WHERE TRUNC (TGLPROSES) = TRUNC (TO_DATE('$periode','DD-MM-YYYY'))
                        AND CASE
                                WHEN FMKCAB = '18' OR FMKCAB = '16'
                                    THEN FMTSJL
                                ELSE 0
                            END <> '1'
                        AND FMBARC IS NOT NULL)
              WHERE FMBARC = BRC_BARCODE)
     AND BRC_PRDCD = PRD_PRDCD(+)
ORDER BY BRC_PRDCD");

        //PRINT
        $perusahaan = DB::table("tbmaster_perusahaan")->first();
        return view('BACKOFFICE.PROSES.pemutihan-plu-lap4-pdf',
            ['kodeigr' => $kodeigr, 'data' => $datas, 'perusahaan' => $perusahaan]);
    }

    public function printLap5(Request $request){
        //IGR_BO_PTHBRC_IGRNMDY.jsp
        $kodeigr = Session::get('kdigr');
        $periode = $request->lastproses;
        $periode = DateTime::createFromFormat('Y-m-d', $periode)->format('d-m-Y');

        $datas = DB::connection(Session::get('connection'))->select("SELECT   PRS_NAMAPERUSAHAAN, PRS_NAMACABANG,
            SUBSTR (FMKPLU, 1, 6)
         || CASE
                WHEN (FMKCAB = '18' OR FMKCAB = '16') AND FMTSJL = '4'
                    THEN 1
                ELSE FMTSJL
            END FMKPLU,
         PRD_DESKRIPSIPANJANG, FMTAGP, FMBARC
    FROM TBTEMP_PLUDATAMD, TBMASTER_PRODMAST, TBMASTER_PERUSAHAAN
   WHERE PRS_KODEIGR = FMKCAB
     AND FMKCAB = '$kodeigr'
     AND CASE
             WHEN FMKCAB = '18' OR FMKCAB = '16'
                 THEN FMTSJL
             ELSE 0
         END <> '1'
     AND FMBARC IS NOT NULL
     AND NOT EXISTS (SELECT 1
                       FROM TBMASTER_BARCODE
                      WHERE FMBARC = BRC_BARCODE)
     AND FMKPLU = PRD_PRDCD(+)
     AND FMBARC NOT LIKE 'X%'
     AND FMBARC NOT LIKE 'NOBRC%'
     AND NVL (FMTAGP, '9') NOT IN ('N', 'A', 'X')
     AND TRUNC (TGLPROSES) = TRUNC (TO_DATE('$periode','DD-MM-YYYY'))
ORDER BY FMKPLU");

        //PRINT
        $perusahaan = DB::table("tbmaster_perusahaan")->first();
        return view('BACKOFFICE.PROSES.pemutihan-plu-lap5-pdf',
            ['kodeigr' => $kodeigr, 'data' => $datas, 'perusahaan' => $perusahaan]);
    }

    public function printLap6(Request $request){
        //IGR_BO_PTHBRC_CMPR.jsp
        $kodeigr = Session::get('kdigr');
        $periode = $request->lastproses;
        $periode = DateTime::createFromFormat('Y-m-d', $periode)->format('d-m-Y');
        $flag = $request->flag;

        if($flag == 1){
            $ket = "DAFTAR PERBANDINGAN BARCODE";
            $where_clause = "";
        }else{
            $ket = "DAFTAR PERBANDINGAN BARCODE YANG BERBEDA";
            $where_clause = "and nvl(brc_igr,'ZZ')  <> nvl(brc_md,'ZZ')";
        }

        $datas = DB::connection(Session::get('connection'))->select("SELECT a.* , prd_deskripsipanjang FROM TEMP_COMPAREbrc a, tbmaster_prodmast
WHERE plu=prd_prdcd(+)
".$where_clause."
ORDER BY plu");

        //PRINT
        $perusahaan = DB::table("tbmaster_perusahaan")->first();
        return view('BACKOFFICE.PROSES.pemutihan-plu-lap6-pdf',
            ['kodeigr' => $kodeigr, 'data' => $datas, 'perusahaan' => $perusahaan,
                'ket' => $ket]);
    }
}
