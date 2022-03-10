<?php

namespace App\Http\Controllers\BACKOFFICE\TRANSFER;

use App\Http\Controllers\Auth\loginController;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;
use MongoDB\Driver\Exception\ExecutionTimeoutException;
use PDF;
use XBase\TableReader;
use Yajra\DataTables\DataTables;
use ZipArchive;
use File;

class TransferLokasiController extends Controller
{
    public $status = '';
    public $message = '';

    public function index()
    {
        return view('BACKOFFICE.TRANSFER.transfer-lokasi');
    }

    public function prosesTransfer(Request $request)
    {
        $fileDBF = $request->file('fileDBF');
        try {
            $data = Self::CEK_PLU();
            if ($data['status'] == 'error') {
                $status = $data['status'];
                $message = $data['message'];
                return compact(['status', 'message']);
            }


            $data = Self::FILL_LKS($fileDBF);
            if ($data['status'] == 'error') {
                $status = $data['status'];
                $message = $data['message'];
                return compact(['status', 'message']);
            }

            $data = Self::CEK_FILE();
            if ($data['status'] == 'error') {
                $status = $data['status'];
                $message = $data['message'];
                return compact(['status', 'message']);
            }

            $data = Self::PROSES_LKS();
            if ($data['status'] == 'error') {
                $status = $data['status'];
                $message = $data['message'];
                return compact(['status', 'message']);
            }

            $data = Self::FILL_INFO();
            if ($data['status'] == 'error') {
                $status = $data['status'];
                $message = $data['message'];
                return compact(['status', 'message']);
            }

            $data = Self::CETAK_LKS();
            if ($data['status'] == 'error') {
                $status = $data['status'];
                $message = $data['message'];
                return compact(['status', 'message']);
            }

            DB::connection(Session::get('connection'))->table('tbmaster_lokasi_backup')->delete();
            DB::connection(Session::get('connection'))->insert("insert into tbmaster_lokasi_backup (select * from tbmaster_lokasi)");

            DB::connection(Session::get('connection'))
                ->table('tbtemp_antrianspb')
                ->whereRaw("nvl(spb_recordid,'Z') = 'Z'")
                ->whereRaw("spb_jenis = 'OTOMATIS'")
                ->delete();


            $status = 'success';
            $message = "Proses Transfer Lokasi Berhasil!";
            return compact(['status', 'message']);
        } catch (\Exception $e) {
            DB::connection(Session::get('connection'))->rollBack();;

            $status = 'error';
            $message = $e->getMessage();
            return compact(['status', 'message']);
        }


    }

    public function CEK_PLU()
    {
        $data = DB::connection(Session::get('connection'))
            ->select("SELECT   PLU
                    FROM (SELECT   COUNT (1), LKS_PRDCD PLU--, LKS_TIPERAK
                              FROM TBMASTER_LOKASI
                             WHERE (LKS_KODERAK LIKE 'R%' OR LKS_KODERAK LIKE 'O%')
                               AND Lks_jenisrak in ('D','N')
                               AND LKS_PRDCD IS NOT NULL
                          GROUP BY LKS_PRDCD
                            HAVING COUNT (1) > 1)
                ORDER BY PLU");
        $plu = '';
        if (sizeof($data) != 0) {
            for ($i = 0; $i < sizeof($data); $i++) {
                $plu += SUBSTR($data[$i]->plu, 4);
            }
            $message = "Terdapat PLU yg memiliki lebih dari 1 lokasi di Rak Display Toko, PLU : " . $plu;
            $status = "error";
            return compact(['status', 'message']);
        }
        $message = "";
        $status = "success";
        return compact(['status', 'message']);
    }

    public function FILL_LKS($fileDBF)
    {
        $V_FILENAME = 0;
        $V_FILE_COUNTER = 0;
        $result = 0;
        $TEMP = 0;
        $ZIP = 0;
        $CMD = 0;
        $STEP = 0;
        $JUM = 0;
        $QRY = 0;
        $P_STEP = 0;
        $ERR = 0;
        $P_COUNT = 0;

        DB::connection(Session::get('connection'))->beginTransaction();
        DB::connection(Session::get('connection'))->table('temp_lokasi')->delete();
        DB::connection(Session::get('connection'))->table('tbtemp_lokasi')->whereRaw('tglproses < SYSDATE - 90')->delete();


        if (strtoupper($fileDBF->getClientOriginalExtension()) === 'ZIP') {
            File::delete(public_path('TRANSFERLOKASI'));

            $zip = new ZipArchive;

            $list = [];
            if ($zip->open($fileDBF) === TRUE) {
                for ($i = 0; $i < $zip->numFiles; $i++) {
                    $entry = $zip->getNameIndex($i);
                    $list[] = $entry;
                }

                $zip->extractTo(public_path('TRANSFERLOKASI'));
                $zip->close();
            } else {
                $status = 'error';
                $message = 'Mohon pastikan file zip berasal dari program Transfer SJ - IAS!';

                return compact(['status', 'message']);
            }

            $temp = File::allFiles(public_path('TRANSFERLOKASI'));

            if (count($temp) != 1) {
                $status = 'error';
                $message = 'File zip hanya boleh berisi satu file saja!';
                return compact(['status', 'message']);
            } else {
                $isZip = true;
                $fileDBF = $temp[0];

            }
        }


        $datafileDBF = new TableReader($fileDBF);

        $insert = [];

        while ($recs = $datafileDBF->nextRecord()) {
            $temp = [];

            $temp['fmkrak'] = $recs->get('fmkrak');
            $temp['fmsrak'] = $recs->get('fmsrak');
            $temp['fmtipe'] = $recs->get('fmtipe');
            $temp['fmselv'] = $recs->get('fmselv');
            $temp['fmnour'] = $recs->get('fmnour');
            $temp['fmkplu'] = $recs->get('fmkplu');
            $temp['fmface'] = $recs->get('fmface');
            $temp['fmtrdb'] = $recs->get('fmtrdb');
            $temp['fmtrab'] = $recs->get('fmtrab');
            $temp['fmtotl'] = $recs->get('fmtotl');

            $insert[] = $temp;
        }

        DB::connection(Session::get('connection'))
            ->table('temp_lokasi')
            ->insert($insert);
        DB::connection(Session::get('connection'))->commit();
        $status = 'success';
        $message = '';

        return compact(['status', 'message']);
    }

    public function CEK_FILE()
    {
        $TEMP = 0;
        $PLU = 0;
        $TEMP = DB::connection(Session::get('connection'))
            ->select("SELECT COUNT (1) count
                      FROM TEMP_LOKASI A
                     WHERE EXISTS (SELECT 1
                                     FROM (SELECT   COUNT (1), FMKPLU PLU
                                               FROM TEMP_LOKASI B
                                           GROUP BY FMKPLU
                                             HAVING COUNT (1) > 1)
                                    WHERE PLU = A.FMKPLU)")[0]->count;

        if ($TEMP > 0) {

//            Self::CETAK_WPLU_FILE(); //IGR_BO_LIST_PLUWLKS.jsp
            $status = 'info';
            $message = "Terdapat PLU yg memiliki lebih dari 1 lokasi pada File RAK*. ";
            return compact(['status', 'message']);
        }

        $TEMP = DB::connection(Session::get('connection'))
            ->select("SELECT COUNT (1) count
                          FROM TEMP_LOKASI
                         WHERE length(fmtotl)>6")[0]->count;

        if ($TEMP > 0) {
            $message = "Field FMTOTL terlalu besar nilainya. File RAK*.ZIP bermasalah Harap hubungi EDP. ";
            $status = 'error';
            return compact(['status', 'message']);
        }
        $message = "";
        $status = 'success';
        return compact(['status', 'message']);

    }

    public function PROSES_LKS()
    {
        $JUM = 0;
        $STEP = 0;
        $JAMA = 0;
        $NOID = 0;
        $DESK = 0;
        $UNIT = 0;
        $FRAC = 0;
        $NLOKASI = 0;
        $TEMP = 0;
        $JAMA = "TO_CHAR (SYSDATE, 'HH24:MI:SS')";
        $STEP = 2;

//    ------->>>>>>>>>>>>> INSERT START LOG <<<<<<<<<<<<<-------
        try {

            DB::connection(Session::get('connection'))
                ->insert("INSERT INTO TBTR_STATUS
                            (STS_KODEIGR, STS_PROGRAM, STS_USER, STS_TANGGAL, STS_JAMMULAI,STS_CREATE_BY, STS_CREATE_DT)
                                 VALUES ('" . Session::get('kdigr') . "', 'IGR_BO_TRF_LOKASI', '" . Session::get('usid') . "', TRUNC (SYSDATE)," . $JAMA . ",
                                         '" . Session::get('usid') . "', SYSDATE)");

//    ------->>>>>>>>>>>>> DELETE TBTEMP_LOKASI YG SUDAH 3 BULAN TERAKHIR DIJALANKAN <<<<<<<<<<<<<-------
            DB::connection(Session::get('connection'))
                ->delete("DELETE FROM TBTEMP_LOKASI WHERE TGLPROSES < ADD_MONTHS (SYSDATE, -3)");


//    ------->>>>>>>>>>>>> BACK UP INFO PLU YG MAU DIPROSES <<<<<<<<<<<<<-------
            DB::connection(Session::get('connection'))
                ->insert("INSERT INTO TBTEMP_LOKASI
                    (PRDCD, QTY, EXPDATE, MINPCT, MAXPLANO, TGLPROSES, JNSRAK)
                    (SELECT DISTINCT LKS_PRDCD, LKS_QTY, LKS_EXPDATE, LKS_MINPCT, LKS_MAXPLANO, SYSDATE,
                                         LKS_JENISRAK
                                    FROM TBMASTER_LOKASI
                                   WHERE (   LKS_KODERAK || LKS_KODESUBRAK || LKS_TIPERAK IN (
                        SELECT DISTINCT trim (FMKRAK) || trim (FMSRAK)
                    || trim (FMTIPE)
                                                                  FROM TEMP_LOKASI)
                                          OR LKS_PRDCD IN (SELECT SUBSTR (trim (FMKPLU), 1, 6) || '0'
                                                             FROM TEMP_LOKASI)
                                         )
                                     AND (LKS_KODERAK LIKE 'R%' OR LKS_KODERAK LIKE 'O%')
                                     AND NVL (LKS_JENISRAK, 'D') IN ('D', 'N')
                    AND LKS_PRDCD IS NOT NULL)");


//    ------->>>>>>>>>>>>> DELETE LOKASI MAU DIPROSES & PLU <<<<<<<<<<<<<-------
            DB::connection(Session::get('connection'))
                ->delete("DELETE FROM TBMASTER_LOKASI
          WHERE (   LKS_KODERAK || LKS_KODESUBRAK || LKS_TIPERAK IN (
        SELECT DISTINCT trim (FMKRAK) || trim (FMSRAK)
    || trim (FMTIPE)
                                                  FROM TEMP_LOKASI)
                 OR LKS_PRDCD IN (SELECT SUBSTR (trim (FMKPLU), 1, 6) || '0'
                                    FROM TEMP_LOKASI)
                )
            AND (LKS_KODERAK LIKE 'R%' OR LKS_KODERAK LIKE 'O%')
            AND NVL (LKS_JENISRAK, 'D') IN ('D', 'N')
    AND LKS_PRDCD IS NOT NULL");


//    ------->>>>>>>>>>>>> PROSES INSERT LOKASI BARU <<<<<<<<<<<<<-------
            $recs = DB::connection(Session::get('connection'))
                ->select("SELECT FMKRAK, FMSRAK, FMTIPE, FMSELV, FMNOUR, FMKPLU, FMFACE, FMTRDB, FMTRAB,
                       FMTOTL
                  FROM TEMP_LOKASI");
//            for ($i = 0; $i < sizeof($rec); $i++) {
            foreach ($recs as $rec) {

                DB::connection(Session::get('connection'))
                    ->insert("INSERT INTO TBMASTER_LOKASI
                (LKS_KODEIGR, LKS_KODERAK, LKS_KODESUBRAK, LKS_TIPERAK,
                    LKS_SHELVINGRAK, LKS_NOURUT, LKS_PRDCD,
                    LKS_TIRKIRIKANAN, LKS_TIRDEPANBELAKANG, LKS_TIRATASBAWAH, LKS_MAXDISPLAY,
                    LKS_DEPANBELAKANG, LKS_ATASBAWAH, LKS_CREATE_BY, LKS_CREATE_DT, LKS_QTY
                )
                 VALUES ('" . Session::get('kdigr') . "', trim ('" . $rec->fmkrak . "'), trim ('" . $rec->fmsrak . "'), trim ('" . $rec->fmtipe . "'),
                         trim ('" . $rec->fmselv . "'), trim ('" . $rec->fmnour . "'), substr (trim ('" . $rec->fmkplu . "'), 1, 6) || '0',
                         trim ('" . $rec->fmface . "'), trim ('" . $rec->fmtrdb . "'), trim ('" . $rec->fmtrab . "'), trim ('" . $rec->fmtotl . "'),
                         1, 1, '" . session::get('usid') . "', sysdate, 0)");

                $JUM = DB::connection(Session::get('connection'))
                    ->select("SELECT NVL (COUNT (1), 0) count
          FROM TBTABEL_DPD
         WHERE DPD_Kodeigr = '" . session::get('kdigr') . "'
    and dpd_koderak = trim ('" . $rec->fmkrak . "')
    and dpd_kodesubrak = trim ('" . $rec->fmsrak . "')
    and dpd_tiperak = trim ('" . $rec->fmtipe . "')
    and dpd_shelvingrak = trim ('" . $rec->fmselv . "')
    and dpd_nourut = trim ('" . $rec->fmnour . "')
    and nvl (dpd_recordid, '0') <> '1'")[0]->count;

                if ($JUM > 0) {
                    $NOID = DB::connection(Session::get('connection'))
                        ->select("SELECT DPD_NOID
                                  FROM TBTABEL_DPD
                                 WHERE DPD_KODEIGR = '" . Session::get('kdigr') . "'
                        and dpd_koderak = trim ('" . $rec->fmkrak . "')
                        and dpd_kodesubrak = trim ('" . $rec->fmsrak . "')
                        and dpd_tiperak = trim ('" . $rec->fmtipe . "')
                        and dpd_shelvingrak = trim ('" . $rec->fmselv . "')
                        and dpd_nourut = trim ('" . $rec->fmnour . "')
                        and nvl (dpd_recordid, '0') <> '1'")[0]->dpd_noid;

                    DB::connection(Session::get('connection'))
                        ->update("UPDATE TBMASTER_LOKASI
                               SET LKS_NOID = '" . $NOID . "'
                             WHERE LKS_KODEIGR = '" . Session::get('kdigr') . "'
                    AND LKS_KODERAK = TRIM ('" . $rec->fmkrak . "')
                    and lks_kodesubrak = trim ('" . $rec->fmsrak . "')
                    and lks_tiperak = trim ('" . $rec->fmtipe . "')
                    and lks_shelvingrak = trim ('" . $rec->fmselv . "')
                    and lks_nourut = trim ('" . $rec->fmnour . "')");

                }

                $JUM = DB::connection(Session::get('connection'))
                    ->select("SELECT NVL (COUNT (1), 0) count
                              FROM TBMASTER_KKPKM
                             WHERE PKM_KODEIGR = '" . Session::get('kdigr') . "'
                             AND PKM_PRDCD = SUBSTR (TRIM ('" . $rec->fmkplu . "'), 1, 6) || '0'")[0]->count;

                if ($JUM > 0) {
                    DB::connection(Session::get('connection'))
                        ->update("UPDATE TBMASTER_KKPKM
               SET PKM_MINDISPLAY =
                PKM_MINDISPLAY
                + (NVL(TRIM('" . $rec->fmface . "'), 0)
                    * NVL(TRIM('" . $rec->fmtrdb . "'), 0)
                    * NVL(TRIM('" . $rec->fmtrab . "'), 0)
                )
             WHERE PKM_KODEIGR = '" . Session::get('kdigr') . "'
            and PKM_PRDCD = SUBSTR(TRIM('" . $rec->fmkplu . "'), 1, 6) || '0'");
                }
                $JUM = DB::connection(Session::get('connection'))
                    ->select("SELECT NVL (COUNT (1), 0) count
          FROM TBMASTER_PRODMAST
         WHERE PRD_KODEIGR =  '" . Session::get('kdigr') . "'
         AND PRD_PRDCD = SUBSTR (TRIM ('" . $rec->fmkplu . "'), 1, 6) || '0'")[0]->count;

                if ($JUM > 0) {
                    $t = DB::connection(Session::get('connection'))
                        ->select("SELECT PRD_DESKRIPSIPANJANG, PRD_UNIT, PRD_FRAC
              FROM TBMASTER_PRODMAST
             WHERE PRD_KODEIGR = '" . Session::get('kdigr') . "'
            and PRD_PRDCD = SUBSTR(TRIM('" . $rec->fmkplu . "'), 1, 6) || '0'")[0];
                    $DESK = $t->prd_deskripsipanjang;
                    $UNIT = $t->prd_unit;
                    $FRAC = $t->prd_frac;
                } else {
                    $DESK = '';
                }

                DB::connection(Session::get('connection'))->table('TEMP_CTK_LOKASI')
                    ->insert(
                        [
                            'FMKRAK' => $rec->fmkrak,
                            'FMSRAK' => $rec->fmsrak,
                            'FMTIPE' => $rec->fmtipe,
                            'FMSELV' => $rec->fmselv,
                            'FMNOUR' => $rec->fmnour,
                            'FMKPLU' => $rec->fmkplu,
                            'FMDESC' => substr($DESK, 1, 50),
                            'FMUNIT' => $UNIT,
                            'FMFRAC' => $FRAC,
                            'FMFACE' => $rec->fmface,
                            'FMTRDB' => $rec->fmtrdb,
                            'FMTRAB' => $rec->fmtrab,
                            'FMTOTL' => $rec->fmtotl,
                        ]
                    );

            }
            $recs2 = DB::connection(Session::get('connection'))
                ->select("SELECT FMKRAK, FMSRAK, FMTIPE, FMSELV, FMNOUR, FMKPLU, FMFACE, FMTRDB, FMTRAB,
                        FMTOTL
                   FROM TEMP_LOKASI");
            foreach ($recs2 as $rec2) {

                $NLOKASI = 0;
                $JUM = DB::connection(Session::get('connection'))
                    ->select("SELECT NVL(COUNT(1), 0) count
                              FROM TBMASTER_LOKASI
                             WHERE LKS_KODEIGR = '" . Session::get('kdigr') . "'
                             and LKS_PRDCD = SUBSTR(TRIM('" . $rec2->fmkplu . "'), 1, 6) || '0'")[0]->count;
                if ($JUM > 0) {
                    $NLOKASI = DB::connection(Session::get('connection'))
                        ->select("SELECT SUM(NVL(LKS_TIRKIRIKANAN, 0)
                                    * NVL(LKS_TIRDEPANBELAKANG, 0)
                                    * NVL(LKS_TIRATASBAWAH, 0)
                                )  count
                                  FROM TBMASTER_LOKASI
                                 WHERE LKS_KODEIGR = '" . Session::get('kdigr') . "'
                                and LKS_PRDCD = SUBSTR(TRIM( '" . $rec2->fmkplu . "'), 1, 6) || '0'")[0]->count;
                }

                DB::connection(Session::get('connection'))
                    ->update("UPDATE TBMASTER_KKPKM
                       SET PKM_MINDISPLAY = '" . $NLOKASI . "'
                     WHERE PKM_KODEIGR = '" . Session::get('kdigr') . "' and PKM_PRDCD = SUBSTR(TRIM( '" . $rec2->fmkplu . "'), 1, 6) || '0'");
            }
            DB::connection(Session::get('connection'))
                ->update("UPDATE TBTR_STATUS
                   SET STS_JAMSELESAI = TO_CHAR (SYSDATE, 'HH24:MI:SS')
                 WHERE STS_KODEIGR = '" . Session::get('kdigr') . "'
                AND STS_PROGRAM = 'IGR_BO_TRF_LOKASI'
                AND STS_TANGGAL = TRUNC (SYSDATE)
                AND STS_JAMMULAI = " . $JAMA);
            $status = 'success';
            $message = "";
            return compact(['status', 'message']);
        } catch (\Exception $e) {
            $status = 'error';
            $message = "Error Proses LKS " . $e->getMessage();
            return compact(['status', 'message']);
        }
    }

    public function FILL_INFO()
    {
        $TEMP = 0;
        $V_LSDT = 0;
        $V_QTY = 0;
        $V_EXPDATE = 0;
        $V_MINPCT = 0;
        $V_MAXPLANO = 0;
        $V_JNSRAK = 0;
        $V_prdcd = 0;
        try {
            $recs = DB::connection(Session::get('connection'))
                ->select("SELECT LKS_KODERAK, LKS_KODESUBRAK, LKS_TIPERAK, LKS_SHELVINGRAK, LKS_NOURUT,
                                       LKS_PRDCD
                                FROM TEMP_LOKASI, TBMASTER_LOKASI
                                WHERE LKS_KODERAK = TRIM (FMKRAK)
                                        AND LKS_KODESUBRAK = TRIM (FMSRAK)
                                        AND LKS_TIPERAK = TRIM (FMTIPE)
                                        AND LKS_SHELVINGRAK = TRIM (FMSELV)
                                        AND LKS_NOURUT = TRIM (FMNOUR)
                                        AND NVL (SUBSTR (FMKPLU, 1, 6), 'zzz') = NVL (SUBSTR (LKS_PRDCD, 1, 6), 'zzz')
                                        AND (LKS_KODERAK LIKE 'R%' OR LKS_KODERAK LIKE 'O%')");


            foreach ($recs as $rec) {
                $TEMP = DB::connection(Session::get('connection'))
                    ->select("SELECT COUNT (1) count
                                    FROM TBTEMP_LOKASI
                                    WHERE PRDCD = '" . $rec->lks_prdcd . "' AND FLAGUPDATE IS NULL")[0]->count;
                if ($TEMP > 0) {
                    $V_LSDT = DB::connection(Session::get('connection'))
                        ->select("SELECT MAX(TO_CHAR(TGLPROSES, 'YYYYMMDDHH24MISS')) maks
                              FROM TBTEMP_LOKASI
                             WHERE PRDCD = '" . $rec->lks_prdcd . "' and FLAGUPDATE IS NULL")[0]->maks;

                    $V_QTY = NULL;
                    $V_EXPDATE = NULL;
                    $V_MINPCT = NULL;
                    $V_MAXPLANO = NULL;
                    $V_JNSRAK = NULL;

                    $res = DB::connection(Session::get('connection'))
                        ->select("SELECT QTY, EXPDATE, MINPCT, MAXPLANO, JNSRAK
                      FROM TBTEMP_LOKASI
                     WHERE PRDCD = '" . $rec->lks_prdcd . "'
                    and FLAGUPDATE IS NULL
                    and TO_CHAR(TGLPROSES, 'YYYYMMDDHH24MISS') ='" . $V_LSDT . "'")[0];

                    $V_QTY = $res->qty;
                    $V_EXPDATE = $res->expdate;
                    $V_MINPCT = $res->minpct;
                    $V_MAXPLANO = $res->maxplano;
                    $V_JNSRAK = $res->jnsrak;

                    DB::connection(Session::get('connection'))
                        ->update("UPDATE TBMASTER_LOKASI
                               SET LKS_QTY = '" . $V_QTY . "',
                                   LKS_EXPDATE = '" . $V_EXPDATE . "',
                                   LKS_MINPCT = '" . $V_MINPCT . "',
                                   LKS_MAXPLANO = '" . $V_MAXPLANO . "',
                                   LKS_JENISRAK = '" . $V_JNSRAK . "',
                                   LKS_MODIFY_DT = SYSDATE,
                                   LKS_MODIFY_BY = '" . Session::get('usid') . "'
                             WHERE LKS_PRDCD = '" . $rec->lks_prdcd . "'
                            and LKS_KODERAK = '" . $rec->lks_koderak . "'
                            and LKS_KODESUBRAK = '" . $rec->lks_kodesubrak . "'
                            and LKS_TIPERAK = '" . $rec->lks_tiperak . "'
                            and LKS_SHELVINGRAK = '" . $rec->lks_shelvingrak . "'
                            and LKS_NOURUT = '" . $rec->lks_nourut . "'");

                    DB::connection(Session::get('connection'))
                        ->update("UPDATE TBTEMP_LOKASI
                               SET FLAGUPDATE = '*'
                             WHERE PRDCD = '" . $rec->lks_prdcd . "'
                                and TO_CHAR(TGLPROSES, 'YYYYMMDDHH24MISS') = '" . $V_LSDT . "'");
                } else {
                    DB::connection(Session::get('connection'))
                        ->update("UPDATE TBMASTER_LOKASI
               SET LKS_QTY = 0,
                   LKS_EXPDATE = NULL,
                   LKS_MINPCT = '30',
                   LKS_MAXPLANO = LKS_MAXDISPLAY
             WHERE LKS_PRDCD = '" . $rec->lks_prdcd . "'
            and LKS_KODERAK = '" . $rec->lks_koderak . "'
            and LKS_KODESUBRAK = '" . $rec->lks_kodesubrak . "'
            and LKS_TIPERAK = '" . $rec->lks_tiperak . "'
            and LKS_SHELVINGRAK = '" . $rec->lks_shelvingrak . "'
            and LKS_NOURUT = '" . $rec->lks_nourut . "'");
                }
                $V_JNSRAK = DB::connection(Session::get('connection'))
                    ->select("SELECT LKS_JENISRAK
                                FROM TBMASTER_LOKASI
                                WHERE LKS_PRDCD = '" . $rec->lks_prdcd . "'
                                    AND (LKS_KODERAK LIKE 'R%' OR LKS_KODERAK LIKE 'O%')
                                    AND NVL (LKS_JENISRAK, 'D') IN ('D', 'N')")[0]->lks_jenisrak;

                if (!isset($V_JNSRAK)) {
                    $TEMP = DB::connection(Session::get('connection'))
                        ->select("SELECT COUNT(1) count
                                  FROM TBMASTER_PLUPLANO
                                  WHERE PLN_KODEIGR = '" . Session::get('kdigr') . "'
                                        and PLN_PRDCD = '" . $rec->lks_prdcd . "'")[0]->count;

                    if ($TEMP > 0) {
                        $V_JNSRAK = DB::connection(Session::get('connection'))
                            ->select("SELECT PLN_JENISRAK
                                      FROM TBMASTER_PLUPLANO
                                     WHERE PLN_KODEIGR = '" . Session::get('kdigr') . "'
                                            and PLN_PRDCD = '" . $rec->lks_prdcd . "'")[0]->pln_jenisrak;
                    } else {
                        $V_JNSRAK = 'D';

                        DB::connection(Session::get('connection'))
                            ->insert("INSERT INTO TBMASTER_PLUPLANO
                                    (PLN_KODEIGR, PLN_PRDCD, PLN_JENISRAK, PLN_CREATE_BY, PLN_CREATE_DT )
                        VALUES('" . Session::get('kdigr') . "', '" . $rec->lks_prdcd . "', 'D', 'TRF', SYSDATE)");
                    }
                    DB::connection(Session::get('connection'))
                        ->update("UPDATE TBMASTER_LOKASI
                                 SET LKS_JENISRAK = '" . $V_JNSRAK . "'
                                 WHERE LKS_PRDCD = '" . $rec->lks_prdcd . "'
                                    and (LKS_KODERAK LIKE 'R%' or LKS_KODERAK LIKE 'O%')
                                    and NVL(LKS_JENISRAK, 'D') IN('D', 'N')");
                }
            }
            $status = 'success';
            $message = "";
            return compact(['status', 'message']);
        } catch (\Exception $e) {
            $status = 'error';
            $message = "Error Proses FILL INFO " . $e->getMessage();
            return compact(['status', 'message']);
        }
    }

    public function CETAK_LKS()
    {
        try {
            $SUB_ISI_TXT = 0;
            $R = 0;
            $R2 = 0;
            $HAL = 0;
            $EOF = 0;
            $LDEL = 0;
            $NMBUTTON = 0;
            $DIRNAME = 0;
            $FNAME = 0;
            $PIL = 0;
            $LINEBUFF = 0;
            $NPERS = 0;
            $NCAB = 0;
            $STEP = 0;
            $SEQ = 0;
            $V_FILE_COUNTER = 0;


            File::delete(storage_path("lokasi.txt"));

            $dir1 = storage_path("lokasi.txt");


            $SEQ = $SEQ + 1;
            $FNAME = 'TEMP_LKS_' . Carbon::now()->format('d-m-Y') . '_' . str_pad($SEQ, 2, '0', STR_PAD_LEFT) . '.TXT';

            $EOF = DB::connection(Session::get('connection'))
                ->select("SELECT NVL (COUNT (1), 0) count
                                FROM TEMP_CTK_LOKASI")[0]->count;

            if ($EOF > 0) {

                $res = DB::connection(Session::get('connection'))
                    ->select("SELECT PRS_NAMAPERUSAHAAN, PRS_NAMACABANG
                                    FROM TBMASTER_PERUSAHAAN
                                    WHERE PRS_KODEIGR = '" . Session::get('kdigr') . "'");
                $NPERS = $res[0]->prs_namaperusahaan;
                $NCAB = $res[0]->prs_namacabang;
                $recs = DB::connection(Session::get('connection'))
                    ->select("SELECT LKS.*, PRD_DESKRIPSIPANJANG, PRD_UNIT, PRD_FRAC
                                                  FROM TEMP_CTK_LOKASI LKS, TBMASTER_PRODMAST
                                                 WHERE PRD_KODEIGR(+) = '" . Session::get('kdigr') . "' AND PRD_PRDCD(+) = FMKPLU");


                foreach ($recs as $rec) {
//            -- HEADER

                    if ($R == 0) {
                        $LINEBUFF = '';
                        $LINEBUFF =
                            $LINEBUFF
                            . str_pad('LISTING TRANSFER MASTER LOKASI', 76, ' ', STR_PAD_LEFT)
                            . CHR(13)
                            . CHR(10);
                        $LINEBUFF = $LINEBUFF . CHR(13) . CHR(10);
                        $LINEBUFF =
                            $LINEBUFF
                            . str_pad($NPERS, 85, ' ', STR_PAD_RIGHT)
                            . str_pad('TANGGAL : ' . Carbon::now()->format('d-m-Y'), 28, ' ', STR_PAD_RIGHT)
                            . 'JAM : '
                            . Carbon::now()->format('H:i:s')
                            . CHR(13)
                            . CHR(10);
                        $LINEBUFF =
                            $LINEBUFF
                            . str_pad($NCAB, 85, ' ', STR_PAD_RIGHT)
                            . 'PROGRAM : IGR_BO_TRF_LOKASI HAL : '
                            . str_pad($HAL, 4, '0', STR_PAD_LEFT)
                            . CHR(13)
                            . CHR(10);
                        $LINEBUFF =
                            $LINEBUFF
                            . '==============================================================================================================================='
                            . CHR(13)
                            . CHR(10);
                        $LINEBUFF =
                            $LINEBUFF
                            . 'RAK     SUBRAK TIPE SELV NO.URUT P.L.U    DESKRIPSI                                            SATUAN    K-K  D-B  A-B  MIN DIS'
                            . CHR(13)
                            . CHR(10);
                        $LINEBUFF = $LINEBUFF . str_pad('-', 127, '-', STR_PAD_LEFT) . CHR(13) . CHR(10);
                        $R = $R + 7;
                    }

//            --BODY
                    $LINEBUFF =
                        $LINEBUFF
                        . str_pad($rec->fmkrak, 8, ' ', STR_PAD_RIGHT)
                        . str_pad($rec->fmsrak, 7, ' ', STR_PAD_RIGHT)
                        . str_pad($rec->fmtipe, 5, ' ', STR_PAD_RIGHT)
                        . str_pad($rec->fmselv, 5, ' ', STR_PAD_RIGHT)
                        . str_pad($rec->fmnour, 8, ' ', STR_PAD_RIGHT)
                        . str_pad($rec->fmkplu, 9, ' ', STR_PAD_RIGHT)
                        . str_pad($rec->prd_deskripsipanjang, 52, ' ')
                        . ' '
                        . str_pad($rec->prd_unit . '/' . $rec->prd_frac, 10, ' ')
                        . str_pad($rec->fmface, 5, ' ', STR_PAD_RIGHT)
                        . str_pad($rec->fmtrdb, 5, ' ', STR_PAD_RIGHT)
                        . str_pad($rec->fmtrab, 5, ' ', STR_PAD_RIGHT)
                        . $rec->fmtotl
                        . CHR(13)
                        . CHR(10);
                    $R = $R + 1;
                    $R2 = $R2 + 1;

//            --FOOTER --
                    if ($HAL % 2 == 0) {
                        if ($R == 48 || $R2 == $EOF) {
                            $LINEBUFF = $LINEBUFF . str_pad('=', 127, '=', STR_PAD_LEFT) . CHR(13) . CHR(10);
                            $HAL = $HAL + 1;

                            if ($R2 == $EOF) {
                                $LINEBUFF =
                                    $LINEBUFF
                                    . str_pad('  ' . $EOF . ' Item(s) Transferred ', 108, ' ', STR_PAD_LEFT)
                                    . '** AKHIR LAPORAN **';
                            } else {
                                $LINEBUFF =
                                    $LINEBUFF
                                    . '** BERSAMBUNG KE HAL '
                                    . str_pad($HAL, 4, '0', STR_PAD_LEFT)
                                    . CHR(13)
                                    . CHR(10);
                            }

                            $R = 0;
//                    CLIENT_TEXT_IO . PUT_LINE(OUT_FILE, $LINEBUFF);
                            $out_file = fopen($dir1, "w") or die("Unable to open file!");
                            fwrite($out_file, $LINEBUFF);
                        }
                    } else {
                        if ($R == 49 or $R2 == $EOF) {
                            $LINEBUFF = $LINEBUFF || LPAD('=', 127, '=') || CHR(13) || CHR(10);
                            $HAL = $HAL + 1;

                            if ($R2 == $EOF) {
                                $LINEBUFF =
                                    $LINEBUFF
                                    . str_pad('  ' . EOF . ' Item(s) Transferred ', 108, ' ', STR_PAD_RIGHT)
                                    . '** AKHIR LAPORAN **';
                            } else {
                                $LINEBUFF =
                                    $LINEBUFF
                                    . '** BERSAMBUNG KE HAL '
                                    . str_pad($HAL, 4, '0', STR_PAD_RIGHT)
                                    . CHR(13)
                                    . CHR(10);
                            }

                            $R = 0;
                            fwrite($out_file, $LINEBUFF);

                        }
                    }
                }
                fclose($out_file);
                DB::connection(Session::get('connection'))
                    ->statement("truncate table temp_ctk_lokasi");

            }
            $status = 'success';
            $message = "";
            return compact(['status', 'message']);
        } catch (\Exception $e) {
            $status = 'error';
            $message = "Error Cetak LKS " . $e->getMessage();
            return compact(['status', 'message']);
        }
    }

    public function DOWNLOAD_WPLU_FILE()
    {
        $file = storage_path('lokasi.txt');
        if ($file)
            return response()->download($file)->deleteFileAfterSend(true);
        else {
            $status = 'error';
            $message = "Gagal Download WPLU File!";
            return compact(['status', 'message']);
        }
    }

    public function CETAK_WPLU_FILE()
    {
        $data = DB::connection(Session::get('connection'))
            ->select("SELECT  trim (FMKRAK) FMKRAK, trim (FMSRAK) FMSRAK, trim (FMTIPE) FMTIPE, trim (FMSELV) FMSELV,
                     trim (FMNOUR) FMNOUR, trim (FMKPLU) FMKPLU, PRD_DESKRIPSIPANJANG
                FROM TEMP_LOKASI A, TBMASTER_PRODMAST
               WHERE FMKPLU = PRD_PRDCD AND EXISTS (SELECT 1
                                                      FROM (SELECT   COUNT (1), FMKPLU PLU
                                                                FROM TEMP_LOKASI B
                                                            GROUP BY FMKPLU
                                                              HAVING COUNT (1) > 1)
                                                     WHERE PLU = A.FMKPLU)
            ORDER BY FMKPLU, FMKRAK, FMSRAK, FMTIPE, FMSELV, FMNOUR");
        $perusahaan = DB::connection(Session::get('connection'))->table('tbmaster_perusahaan')
            ->select('PRS_NAMAPERUSAHAAN', 'PRS_NAMACABANG')
            ->where('PRS_KODEIGR', Session::get('kdigr'))
            ->first();
        return view('BACKOFFICE.TRANSFER.list-plu-dengan-banyak-lokasi-dalam-file-rak-pdf', compact(['perusahaan', 'data']));

    }


}
