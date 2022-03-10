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
use PDF;
use Yajra\DataTables\DataTables;
use ZipArchive;
use File;

class TransferPLUController extends Controller
{
    public $txtFile = [];

    public function index()
    {
        return view('BACKOFFICE.TRANSFER.transfer-plu');
    }

    public function downloadDTA(Request $request)
    {
        set_time_limit(0);
        $err_txt = '';

        $filedta = DB::connection(Session::get('connection'))
            ->select("select 'DTA4' || SUBSTR(TO_CHAR(SYSDATE , 'RR'), -1, 1)
                            || CASE
                                WHEN TO_CHAR(SYSDATE , 'MM') = '10'
                                    THEN 'A'
                                WHEN TO_CHAR(SYSDATE , 'MM') = '11'
                                    THEN 'B'
                                WHEN TO_CHAR(SYSDATE , 'MM') = '12'
                                    THEN 'C'
                                ELSE SUBSTR(TO_CHAR(SYSDATE , 'MM'), -1, 1)
                            END
                            || TO_CHAR(SYSDATE , 'DD')||'.'||" . Session::get('kdigr') . " a from dual")[0]->a;

        $c = loginController::getConnectionProcedure();
        $sql = "BEGIN sp_downloaddta('" . Session::get('kdigr') . "',:filedta,:err_txt); END;";
        $s = oci_parse($c, $sql);

        oci_bind_by_name($s, ':filedta', $filedta, 200);
        oci_bind_by_name($s, ':err_txt', $err_txt, 200);
        oci_execute($s);
        if ($err_txt == '') {
            $message = 'Download DTA4 berhasil, silahkan lakukan Transfer PLU';
            $status = 'success';
            return compact(['message', 'status']);
        } else {
            $message = $err_txt;
            $status = 'error';
            return compact(['message', 'status']);
        }
    }

    public function transferDTA4(Request $request)
    {
        $N_REQ_ID = '';
        $N_USR_ID = '';
        $KODEIGR = '';
        $PATHDTA = '';
        $V_RESULT_PLU = '';
        $V_RESULT_HGB = '';
        $V_RESULT_SUP = '';
        $V_RESULT_PRM = '';
        $V_RESULT_MGN = '';
        $V_RESULT_OMI = '';
        $JUM = '';
        $ADADTA = FALSE;
        $PROSES = FALSE;
        $PIL = '';
        $F = '';

        $N_REQ_ID = str_replace('.', '', $request->ip());

        $PATHDTA = DB::connection(Session::get('connection'))->table('igr_setup_db')->select('db_harian_folder')->first()->db_harian_folder;

        DB::connection(Session::get('connection'))->table('DIR_LIST_TMP')->where('REQ_ID', '=', $N_REQ_ID)->delete();

        $c = loginController::getConnectionProcedure();
        $sql = "BEGIN GET_DIR_LIST(:pathdta,:n_req_id); END;";
        $s = oci_parse($c, $sql);

        oci_bind_by_name($s, ':pathdta', $PATHDTA, 200);
        oci_bind_by_name($s, ':n_req_id', $N_REQ_ID, 200);
        oci_execute($s);

        $data = DB::connection(Session::get('connection'))->table('dir_list_tmp')
            ->select('filename as full_filename', DB::connection(Session::get('connection'))->raw("SUBSTR (filename, INSTR (filename, '/', -1) + 1) filename"))
            ->where('req_id', '=', $N_REQ_ID)
            ->orderBy('filename')
            ->get();

        foreach ($data as $x) {

            if (substr($x->filename, -3, 3) == '.' . Session::get('kdigr')) {
                $ADADTA = true;
                $PROSES = true;
            }
            if (substr($x->filename, 0, 4) == 'DTA4') {
                $JUM = DB::connection(Session::get('connection'))->table('TBTR_TRANSFERFILE')
                    ->select(DB::connection(Session::get('connection'))->raw("NVL (COUNT (1), 0) as count"))
                    ->where('TRF_KODEIGR', Session::get('kdigr'))
                    ->where('TRF_NAMAPROG', 'IGR_BO_TRF_PLU_CSV')
                    ->where('TRF_NAMAFILE', DB::connection(Session::get('connection'))->raw("SUBSTR ('" . $x->filename . "', 1, LENGTH ('" . $x->filename . "') - 3)"))
                    ->first()->count;

                if ($JUM > 0) {
                    $PROSES = FALSE;
                    $message = 'FILE ' . $x->filename . ' SUDAH PERNAH DIPROSES, INGIN MEMPROSES ULANG ??';
                    $status = 'info';
                    return compact(['message', 'status', 'ADADTA', 'PROSES', 'N_REQ_ID']);

                } else {
                    $PROSES = TRUE;
                }
            }
        }
        return $this->prosesDTA4($ADADTA, $PROSES, $N_REQ_ID);
    }

    public function reqProsesDTA4(Request $request)
    {
        return $this->prosesDTA4($request->adadta, $request->proses, $request->n_req_id);
    }

    public function prosesDTA4($ADADTA, $PROSES, $N_REQ_ID)
    {
        if ($ADADTA == TRUE || $ADADTA == 'true') {
            if ($PROSES == TRUE || $PROSES == 'true') {
//        -------->>>>>>>> TRARNSFER PLU <<<<<<<<--------
                DB::connection(Session::get('connection'))->beginTransaction();
                $c = loginController::getConnectionProcedure();
                $sql = "BEGIN SP_TRF_PLU(:n_req_id,'" . Session::get('usid') . "',:result); END;";
                $s = oci_parse($c, $sql);

                oci_bind_by_name($s, ':n_req_id', $PATHDTA, 200);
                oci_bind_by_name($s, ':result', $V_RESULT_PLU, 200);
                oci_execute($s);
                DB::connection(Session::get('connection'))->commit();
                $this->CETAK_HGBELI($N_REQ_ID);
//                --**cetak lap**--
                if (!isset($V_RESULT_PLU)) {
//                    $F = 'CETAK LAP';
                    $this->CETAK_LAP($N_REQ_ID);

                    $F = 'CETAK LAP2';
                    $this->CETAK_LAP2($N_REQ_ID);

                    $F = 'CETAK BCX DOBEL';
                    $this->CETAK_BCX_DOBEL($N_REQ_ID);

                    $F = 'CETAK PLU BANYAK BARCODE';
                    $this->CETAK_PLU_BANYAK_BARCODE($N_REQ_ID);

                    $F = 'CETAK DIMENSI NOL';
                    $this->CETAK_DIMENSI_NOL($N_REQ_ID);
                }

//            -------->>>>>>>> TRANSFER HARGA BELI <<<<<<<<--------
                DB::connection(Session::get('connection'))->beginTransaction();
                $c = loginController::getConnectionProcedure();
                $sql = "BEGIN SP_TRF_HGBELI(:n_req_id,'" . Session::get('usid') . "',:result); END;";
                $s = oci_parse($c, $sql);

                oci_bind_by_name($s, ':n_req_id', $PATHDTA, 200);
                oci_bind_by_name($s, ':result', $V_RESULT_HGB, 200);
                oci_execute($s);
                DB::connection(Session::get('connection'))->commit();

//                --**cetak lap**--
                $JUM = DB::connection(Session::get('connection'))->table('TEMP_HGBELI')
                    ->select(DB::connection(Session::get('connection'))->raw("NVL (COUNT (1), 0) count"))
                    ->first()->count;

                if ($JUM > 0 && !isset($V_RESULT_HGB)) {
                    $this->CETAK_HGBELI($N_REQ_ID);
                }
//
//            -------->>>>>>>> TRANSFER SUPPLIER <<<<<<<<--------
//            --menu sendiri
                DB::connection(Session::get('connection'))->beginTransaction();
                $c = loginController::getConnectionProcedure();
                $sql = "BEGIN SP_TRF_SUPP(:n_req_id,'" . Session::get('usid') . "',:result); END;";
                $s = oci_parse($c, $sql);

                oci_bind_by_name($s, ':n_req_id', $PATHDTA, 200);
                oci_bind_by_name($s, ':result', $V_RESULT_SUP, 200);
                oci_execute($s);
                DB::connection(Session::get('connection'))->commit();
                if (!isset($V_RESULT_SUP)) {
                    $this->CETAK_SUPPLIER($N_REQ_ID);
                }

//            -------->>>>>>>> TRANSFER HARGA PROMO <<<<<<<<--------
                DB::connection(Session::get('connection'))->beginTransaction();
                $c = loginController::getConnectionProcedure();
                $sql = "BEGIN SP_TRF_DISC(:n_req_id,'" . Session::get('usid') . "',:result); END;";
                $s = oci_parse($c, $sql);

                oci_bind_by_name($s, ':n_req_id', $PATHDTA, 200);
                oci_bind_by_name($s, ':result', $V_RESULT_PRM, 200);
                oci_execute($s);

//                --**cetak lap**--
                if (!isset($V_RESULT_PRM)) {
                    $this->CETAK_HRG_PROMO($N_REQ_ID);
                    $this->CETAK_BTL_PROMO($N_REQ_ID);
                }

//            -------->>>>>>>> TRANSFER MARGIN <<<<<<<<--------
                DB::connection(Session::get('connection'))->beginTransaction();
                $c = loginController::getConnectionProcedure();
                $sql = "BEGIN SP_TRF_MGN(:n_req_id,'" . Session::get('usid') . "',:result); END;";
                $s = oci_parse($c, $sql);

                oci_bind_by_name($s, ':n_req_id', $PATHDTA, 200);
                oci_bind_by_name($s, ':result', $V_RESULT_MGN, 200);
                oci_execute($s);

                if (!isset($V_RESULT_PRM)) {
                    $this->CETAK_MARGIN($N_REQ_ID);
                }

//            -------->>>>>>>> TRANSFER PLU OMI <<<<<<<<--------
                DB::connection(Session::get('connection'))->beginTransaction();
                $c = loginController::getConnectionProcedure();
                $sql = "BEGIN SP_TRF_PLU_OMI(:n_req_id,'" . Session::get('usid') . "',:result); END;";
                $s = oci_parse($c, $sql);

                oci_bind_by_name($s, ':n_req_id', $PATHDTA, 200);
                oci_bind_by_name($s, ':result', $V_RESULT_OMI, 200);
                oci_execute($s);

                $JUM = DB::connection(Session::get('connection'))->table('TEMP_BRX_OMI')
                    ->select(DB::connection(Session::get('connection'))->raw("NVL (COUNT (1), 0) count"))
                    ->where('SESSID', $N_REQ_ID)
                    ->first()->count;

                if ($JUM > 0) {
                    if (!isset($V_RESULT_OMI)) {
                        $this->CETAK_BRGDELOMI($N_REQ_ID);
                        $this->CETAK_BRXOMI_NULL($N_REQ_ID);
                    }
                }
                $message = 'Proses Transfer Selesai';
                $status = 'success';
                $data = $this->txtFile;
                return compact(['message', 'status', 'data']);
            } else {
                $message = 'Proses File DTA4 dibatalkan';
                $status = 'error';
                return compact(['message', 'status']);
            }
        } else {
            $message = 'File DTA4 tidak ada, silahkan tranfer file DTA4 dari FTP HO';
            $status = 'error';
            return compact(['message', 'status']);
        }
    }

    public function CETAK_LAP($N_REQ_ID)
    {
        $STEP = 0;

//        DIBUKA!!!!! contoh
//        $N_REQ_ID = '19216823774';


        $EOF = DB::connection(Session::get('connection'))->table('TEMP_PLUBARU')
            ->selectRaw('NVL(count(1),0) as count')
            ->where('REQ_ID', $N_REQ_ID)
            ->whereRaw("SUBSTR(fmkode,7,1) <> '4'")
            ->first()->count;

        if ($EOF > 0) {
            $perusahaan = DB::connection(Session::get('connection'))->table('tbmaster_perusahaan')
                ->select('PRS_NAMAPERUSAHAAN', 'PRS_NAMACABANG')
                ->where('PRS_KODEIGR', Session::get('kdigr'))
                ->first();
            $NPers = $perusahaan->prs_namaperusahaan;
            $NCab = $perusahaan->prs_namacabang;

            $hal = 1;
            $r = 0;
            $r2 = 0;
            $linebuff = '';

            $FNAME = 'TEMP_PLUBARU.txt';
            File::delete(storage_path($FNAME));
            $file = fopen(storage_path($FNAME), "w");
            $this->txtFile[] = $FNAME;

            $plus = DB::connection(Session::get('connection'))->table('TEMP_PLUBARU')
                ->where('REQ_ID', $N_REQ_ID)
                ->whereRaw("SUBSTR(fmkode,7,1) <> '4'")
                ->orderBy('fmkode')
                ->get();

            if ($plus) {
                foreach ($plus as $plu) {
//  	-- HEADER
                    if ($r == 0) {
                        $linebuff = '';
                        $linebuff = $linebuff . str_pad('LISTING TRANSFER PRODUK BARU', 57, ' ', STR_PAD_LEFT) . chr(13) . chr(10);
                        $linebuff = $linebuff . chr(13) . chr(10);
                        $linebuff = $linebuff . str_pad($NPers, 47, ' ', STR_PAD_RIGHT) . str_pad('TANGGAL : ' . Carbon::now()->format('d/M/Y'), 26, ' ', STR_PAD_RIGHT) . ' JAM : ' . Carbon::now()->format('H:i:s') . chr(13) . chr(10);
                        $linebuff = $linebuff . str_pad($NCab, 47, ' ', STR_PAD_RIGHT) . 'PROGRAM : TRANSFER PLU     HAL : ' . str_pad($hal, 4, '0', STR_PAD_LEFT) . chr(13) . chr(10);
                        $linebuff = $linebuff . str_pad(' = ', 88, ' = ', STR_PAD_LEFT) . chr(13) . chr(10);
                        $linebuff = $linebuff . ' | NO .| P . L . U | DESKRIPSI | KEMASAN | HARGA JUAL | ' . chr(13) . chr(10);
                        $linebuff = $linebuff . str_pad(' - ', 88, ' - ', STR_PAD_LEFT) . chr(13) . chr(10);
//
                        $r = $r + 7;
                    }
//  	-- BODY
                    $linebuff = $linebuff . ' ' . str_pad($r2 + 1, 4, 0, STR_PAD_LEFT) . ' ' . str_pad(($plu->fmkode), 8, ' ', STR_PAD_RIGHT) . str_pad(substr($plu->fmnama, 1, 50), 52, ' ', STR_PAD_RIGHT) . str_pad($plu->fmkstat . ' / ' . $plu->fmisis, 11, ' ', STR_PAD_RIGHT) . str_pad($plu->fmjual, 9, STR_PAD_LEFT) . chr(13) . chr(10);
                    $r = $r + 1;
                    $r2 = $r2 + 1;

//  	-- FOOTER --
                    if ($hal % 2 == 0) {
                        if ($r == 48 || $r2 == $EOF) {
                            $linebuff = $linebuff . str_pad(' = ', 88, ' = ', STR_PAD_LEFT) . chr(13) . chr(10);
                            $hal = $hal + 1;
                            if ($r2 == $EOF) {
                                $linebuff = $linebuff . str_pad('  ' . $EOF . ' Item(s) Transferred ', 68, ' ', STR_PAD_RIGHT) . ' ** AKHIR LAPORAN ** ';
                            } else {
                                $linebuff = $linebuff . ' ** BERSAMBUNG KE HAL ' . str_pad($hal, 4, '0', STR_PAD_LEFT) . chr(13) . chr(10);
                            }
                            $r = 0;
                            fwrite($file, $linebuff);
                        }
                    } else {
                        if ($r == 49 || $r2 == $EOF) {
                            $linebuff = $linebuff . str_pad(' = ', 88, ' = ', STR_PAD_LEFT) . chr(13) . chr(10);
                            $hal = $hal + 1;
                            if ($r2 == $EOF) {
                                $linebuff = $linebuff . str_pad('  ' . $EOF . ' Item(s) Transferred ', 68, ' ', STR_PAD_RIGHT) . ' ** AKHIR LAPORAN ** ';
                            } else {
                                $linebuff = $linebuff . ' ** BERSAMBUNG KE HAL ' . str_pad($hal, 4, '0', STR_PAD_LEFT) . chr(13) . chr(10);
                            }
                            $r = 0;
//  		            outputfile disini
                            fwrite($file, $linebuff);
                        }
                    }
                }
            }
            fclose($file);
        }


//  	STEP = 9;
//        DIBUKA!!!!
        DB::connection(Session::get('connection'))->table('TEMP_PLUBARU')
            ->where('REQ_ID', $N_REQ_ID)
            ->delete();
    }

    public function CETAK_LAP2($N_REQ_ID)
    {

//        DIBUKA!!!!! contoh
//        $N_REQ_ID = '123123';

        $EOF = DB::connection(Session::get('connection'))->table('temp_TRFPLU')
            ->selectRaw('NVL(count(1),0) as count')
            ->where('REQ_ID', $N_REQ_ID)
            ->first()->count;

        $FNAME = 'TEMP_TRFPLU.txt';
        File::delete(storage_path($FNAME));
        $file = fopen(storage_path($FNAME), "w");
        $this->txtFile[] = $FNAME;


        $perusahaan = DB::connection(Session::get('connection'))->table('tbmaster_perusahaan')
            ->select('PRS_NAMAPERUSAHAAN', 'PRS_NAMACABANG')
            ->where('PRS_KODEIGR', Session::get('kdigr'))
            ->first();
        $NPers = $perusahaan->prs_namaperusahaan;
        $NCab = $perusahaan->prs_namacabang;

        $linebuff = '';
        $r = 0;
        $r2 = 0;
        $hal = 1;
        if ($EOF > 0) {

            $plus = DB::connection(Session::get('connection'))->table('TEMP_TRFPLU')
                ->where('REQ_ID', $N_REQ_ID)
                ->orderBy('fmkode')
                ->get();

            if ($plus) {
                foreach ($plus as $plu) {

//              --HEADER
                    if ($r == 0) {
                        $linebuff = '';
                        $linebuff = $linebuff . str_pad('LISTING TRANSFER PLU', 88, ' ', STR_PAD_LEFT) . chr(13) . chr(10);
                        $linebuff = $linebuff . chr(13) . chr(10);
                        $linebuff = $linebuff . str_pad($NPers, 157, ' ', STR_PAD_RIGHT) . str_pad('TANGGAL : ' . Carbon::now()->format('d-M-Y'), 26, ' ', STR_PAD_RIGHT) . ' JAM : ' . Carbon::now()->format('H-i-s') . chr(13) . chr(10);
                        $linebuff = $linebuff . str_pad($NCab, 157, ' ', STR_PAD_RIGHT) . 'PROGRAM : TRANSFER PLU     HAL : ' . str_pad($hal, 4, '0') . chr(13) . chr(10);
                        $linebuff = $linebuff . str_pad('=', 200, '=', STR_PAD_LEFT) . chr(13) . chr(10);
                        $linebuff = $linebuff . str_pad('SEBELUM TRANSFER', 55, ' ', STR_PAD_LEFT) . str_pad('SETELAH TRANSFER', 85, ' ', STR_PAD_LEFT) . chr(13) . chr(10);
                        $linebuff = $linebuff . str_pad('=', 200, '=', STR_PAD_LEFT) . chr(13) . chr(10);
                        $linebuff = $linebuff . str_pad('PLU', 8, ' ', STR_PAD_RIGHT) . str_pad('STATUS', 9, ' ', STR_PAD_RIGHT) . str_pad('NAMA BARANG ', 52, ' ', STR_PAD_RIGHT) . str_pad('Konversi', 10, ' ', STR_PAD_RIGHT) . str_pad('STATUS', 9, ' ', STR_PAD_RIGHT) . str_pad('NAMA BARANG', 52, ' ', STR_PAD_RIGHT) . str_pad('KONVERSI', 10, ' ', STR_PAD_RIGHT) . str_pad('STATUS', 9, ' ', STR_PAD_RIGHT) . chr(13) . chr(10);
                        $linebuff = $linebuff . str_pad('BARCODE', 86, ' ', STR_PAD_LEFT) . str_pad('BARCODE', 71, ' ', STR_PAD_LEFT) . chr(13) . chr(10);
                        $linebuff = $linebuff . str_pad('-', 200, '-', STR_PAD_LEFT) . chr(13) . chr(10);

                        $r = $r + 10;
                    }

//  	--BODY
                    if (!in_array($plu->fmrcid, ['T', 'R', 'H'])) {
                        $linebuff = $linebuff . str_pad($plu->fmkode, 8, ' ', STR_PAD_RIGHT) . str_pad('FAIL?', 9, ' ', STR_PAD_RIGHT) . chr(13) . chr(10);
                        $r = $r + 1;
                        $r2 = $r2 + 1;
                    } else {
                        if ($plu->fmrcid <> 'T') {
                            if (isset($plu->fmksat)) {
                                if ($plu->fmrcid <> 'R') {
                                    $linebuff = $linebuff . str_pad($plu->fmkode, 8, ' ', STR_PAD_RIGHT) . str_pad('TAMBAH', 9, ' ') . str_pad(SUBSTR($plu->fmnama, 1, 50), 52, ' ', STR_PAD_RIGHT) . str_pad($plu->fmksat . '/' . $plu->fmisis, 11, ' ', STR_PAD_RIGHT) . str_pad($plu->fmbsts, 8, ' ', STR_PAD_RIGHT) . chr(13) . chr(10);
                                } else {
                                    $linebuff = $linebuff . str_pad($plu->fmkode, 8, ' ', STR_PAD_RIGHT) . str_pad('RUBAH', 9, ' ', STR_PAD_RIGHT) . str_pad(substr($plu->fmnama, 1, 50), 52, ' ', STR_PAD_RIGHT) . str_pad(TRIM($plu->fmksat) . '/' . $plu->fmisis, 11, ' ', STR_PAD_RIGHT) . str_pad($plu->fmbsts, 8, ' ', STR_PAD_RIGHT);
                                }
                            } else {
                                if ($plu->fmrcid <> 'R') {
                                    $linebuff = $linebuff . str_pad($plu->fmkode, 8, ' ') . str_pad('TAMBAH', 9, ' ', STR_PAD_RIGHT) . str_pad(substr($plu->fmnama, 1, 50), 52, ' ', STR_PAD_RIGHT) . str_pad(' ', 11, ' ', STR_PAD_RIGHT) . str_pad($plu->fmbsts, 8, ' ', STR_PAD_RIGHT) . chr(13) . chr(10);
                                } else {
                                    $linebuff = $linebuff . str_pad($plu->fmkode, 8, ' ', STR_PAD_RIGHT) . str_pad('RUBAH', 9, ' ', STR_PAD_RIGHT) . str_pad(substr($plu->fmnama, 1, 50), 52, ' ', STR_PAD_RIGHT) . str_pad(' ', 11, ' ', STR_PAD_RIGHT) . str_pad($plu->fmbsts, 8, ' ', STR_PAD_RIGHT);
                                }
                            }
                            if ($plu->fmrcid <> 'R') {
                                $r = $r + 1;
                                $r2 = $r2 + 1;
                            }
                        }

                        if ($plu->fmrcid <> 'H') {

                            if ($plu->fmrcid <> 'R') {

                                $linebuff = $linebuff . str_pad(TRIM($plu->fmkode), 8, ' ', STR_PAD_RIGHT) . str_pad('TAMBAH', 9, ' ', STR_PAD_RIGHT) . str_pad(' ', 71, ' ', STR_PAD_RIGHT);

                                if (isset($plu->foksat)) {
                                    $linebuff = $linebuff . str_pad(substr($plu->fonama, 1, 50), 52, ' ', STR_PAD_RIGHT) . str_pad($plu->foksat . '/' . $plu->foisis, 10, ' ', STR_PAD_RIGHT) . str_pad($plu->fmlsts, 9, ' ', STR_PAD_RIGHT) . chr(13) . chr(10);
                                } else {
                                    $linebuff = $linebuff . str_pad(substr($plu->fonama, 1, 50), 52, ' ', STR_PAD_RIGHT) . str_pad(' ', 10, ' ', STR_PAD_RIGHT) . str_pad($plu->fmlsts, 9, ' ', STR_PAD_RIGHT) . chr(13) . chr(10);
                                }
                            } else {
                                if (isset($plu->foksat)) {
                                    $linebuff = $linebuff . str_pad(substr($plu->fonama, 1, 50), 52, ' ', STR_PAD_RIGHT) . str_pad($plu->foksat . '/' . $plu->foisis, 10, ' ', STR_PAD_RIGHT) . str_pad($plu->fmlsts, 9, ' ', STR_PAD_RIGHT) . chr(13) . chr(10);
                                } else {
                                    $linebuff = $linebuff . str_pad(substr($plu->fonama, 1, 50), 52, ' ', STR_PAD_RIGHT) . str_pad(' ', 10, ' ', STR_PAD_RIGHT) . str_pad($plu->fmlsts, 9, ' ', STR_PAD_RIGHT) . chr(13) . chr(10);
                                }
                            }

                            $r = $r + 1;
                            $r2 = $r2 + 1;
                        }
                    }

//                    --FOOTER --
                    if ($hal % 2 == 0) {
                        if ($r == 48 || $r2 == $EOF) {
                            $linebuff = $linebuff . str_pad('=', 200, '=', STR_PAD_LEFT) . chr(13) . chr(10);

                            $hal = $hal + 1;
                            if ($r2 == $EOF) {
                                $linebuff = $linebuff . str_pad('  ' . $EOF . ' Item(s) Transferred ', 175, ' ', STR_PAD_RIGHT) . '** AKHIR LAPORAN **';
                            } else {
                                $linebuff = $linebuff . '** BERSAMBUNG KE HAL ' . str_pad($hal, 4, '0', STR_PAD_LEFT) . chr(13) . chr(10);
                            }
                            $r = 0;

                            fwrite($file, $linebuff);

                        }
                    } else {
                        if ($r == 49 or $r2 == $EOF) {
                            $linebuff = $linebuff . str_pad('=', 200, '=', STR_PAD_LEFT) . chr(13) . chr(10);

                            $hal = $hal + 1;
                            if ($r2 == $EOF) {

                                $linebuff = $linebuff . str_pad('  ' . $EOF . ' Item(s) Transferred ', 175, ' ', STR_PAD_RIGHT) . '** AKHIR LAPORAN **';
                            } else {
                                $linebuff = $linebuff . '** BERSAMBUNG KE HAL ' . str_pad($hal, 4, '0', STR_PAD_LEFT) . chr(13) . chr(10);
                            }
                            $r = 0;

                            fwrite($file, $linebuff);
                        }
                    }
                }
            }
            fclose($file);

//            DB::connection(Session::get('connection'))->table('TEMP_PLUBARU')
//                ->where('REQ_ID', $N_REQ_ID)
//                ->delete();
        }
    }

    public function CETAK_BCX_DOBEL($N_REQ_ID)
    {
        $r = 0;
        $r2 = 0;
        $hal = 1;
        $eof = '';
        $ldel = '';
        $nmbutton = '';
        $dirname = 'S:\TRF_MCG';
        $fname = '';
        $pil = '';
        $linebuff = '';
        $npers = '';
        $ncab = '';
        $step = '';
        $seq = 0;
        $v_list_file = '';
        $v_file_counter = 0;

        $fname = 'TEMP_BCX_DOBEL.txt';
        $step = 6;

        $eof = DB::connection(Session::get('connection'))->table('tbbarcode_bcx_dobel')
            ->selectRaw('NVL(count(1),0) as count')
            ->where('REQ_ID', $N_REQ_ID)
            ->whereRaw('TRUNC(tgltrf) = TRUNC(SYSDATE)')
            ->first()->count;

        if ($eof > 0) {
            File::delete(storage_path($fname));
            $file = fopen(storage_path($fname), "w");
            $this->txtFile[] = $fname;


            $perusahaan = DB::connection(Session::get('connection'))->table('tbmaster_perusahaan')
                ->select('PRS_NAMAPERUSAHAAN', 'PRS_NAMACABANG')
                ->where('PRS_KODEIGR', Session::get('kdigr'))
                ->first();
            $npers = $perusahaan->prs_namaperusahaan;
            $ncab = $perusahaan->prs_namacabang;
            $barcodes = DB::connection(Session::get('connection'))->select("SELECT SUBSTR(fmkode, 1, 6) . fmksjl AS prdcd,prd_deskripsipanjang AS desk, fmbarc AS barcode, TO_CHAR(fmtgup, 'DD-MM-RRRR') AS tanggal FROM tbbarcode_bcx_dobel, tbmaster_prodmast WHERE req_id = " . $N_REQ_ID . " AND TRUNC(tgltrf) = TRUNC(SYSDATE) AND SUBSTR(fmkode, 1, 6) . fmksjl = prd_prdcd ORDER BY fmkode");
            if ($barcodes) {
                foreach ($barcodes as $barcode) {
//            -- HEADER
                    if ($r == 0) {
                        $linebuff = '';
                        $linebuff =
                            $linebuff . str_pad('LISTING BARCODE BCX DOBEL', 60, ' ', STR_PAD_LEFT) . CHR(13)
                            . CHR(10);
                        $linebuff = $linebuff . CHR(13) . CHR(10);
                        $linebuff =
                            $linebuff . str_pad($npers, 54, ' ', STR_PAD_RIGHT)
                            . str_pad('TANGGAL : ' . Carbon::now()->format('d-M-Y'), 26, ' ', STR_PAD_RIGHT) . ' JAM : '
                            . Carbon::now()->format('H-i-s') . CHR(13) . CHR(10);
                        $linebuff =
                            $linebuff . str_pad($ncab, 54, ' ', STR_PAD_RIGHT) . 'PROGRAM : TRANSFER PLU     HAL : '
                            . str_pad($hal, 4, '0', STR_PAD_LEFT) . CHR(13) . CHR(10);
                        $linebuff = $linebuff . str_pad('=', 95, '=', STR_PAD_LEFT) . CHR(13) . CHR(10);
                        $linebuff =
                            $linebuff
                            . '| NO.| P.L.U |DESKRIPSI                                          |BARCODE         |TANGGAL DTA |'
                            . CHR(13) . CHR(10);
                        $linebuff = $linebuff . str_pad('-', 95, '-', STR_PAD_LEFT) . CHR(13) . CHR(10);
                        $r = $r + 7;
                    }

//            --BODY
                    $linebuff =
                        $linebuff . ' ' . str_pad($r2 + 1, 4, 0, STR_PAD_LEFT) . ' ' . str_pad(($barcode->prdcd), 8, ' ', STR_PAD_RIGHT)
                        . str_pad(substr($barcode->desk, 1, 50), 52, ' ', STR_PAD_RIGHT) . str_pad($barcode->barcode, 16, ' ', STR_PAD_RIGHT) . ' '
                        . str_pad($barcode->tanggal, 10, '', STR_PAD_LEFT) . CHR(13) . CHR(10);
                    $r = $r + 1;
                    $r2 = $r2 + 1;

//            --FOOTER --
                    if ($hal % 2 == 0) {
                        if ($r == 48 || $r2 == $eof) {
                            $linebuff = $linebuff . LPAD('=', 95, '=') . CHR(13) . CHR(10);
                            $hal = $hal + 1;

                            if ($r2 == $eof) {
                                $linebuff =
                                    $linebuff . str_pad('  ' . eof . ' Item(s) Transferred ', 75, ' ', STR_PAD_RIGHT)
                                    . '** AKHIR LAPORAN **';
                            } else {
                                $linebuff =
                                    $linebuff . '** BERSAMBUNG KE HAL ' . str_pad($hal, 4, '0', STR_PAD_LEFT) . CHR(13)
                                    . CHR(10);
                            }

                            $r = 0;
                            fwrite($file, $linebuff);
                        }
                    } else {
                        if ($r == 49 or $r2 == $eof) {
                            $linebuff = $linebuff . str_pad('=', 95, '=', STR_PAD_RIGHT) . CHR(13) . CHR(10);
                            $hal = $hal + 1;

                            if ($r2 == $eof) {
                                $linebuff =
                                    $linebuff . str_pad('  ' . $eof . ' Item(s) Transferred ', 75, ' ', STR_PAD_RIGHT)
                                    . '** AKHIR LAPORAN **';
                            } else {
                                $linebuff =
                                    $linebuff . '** BERSAMBUNG KE HAL ' . str_pad($hal, 4, '0', STR_PAD_LEFT) . CHR(13)
                                    . CHR(10);
                            }

                            $r = 0;
                            fwrite($file, $linebuff);
                        }
                    }
                }
            }
            fclose($file);
        }

    }

    public function CETAK_PLU_BANYAK_BARCODE($N_REQ_ID)
    {
        $r = 0;
        $r2 = 0;
        $hal = 1;
        $eof = '';
        $ldel = '';
        $nmbutton = '';
        $dirname = 'S:\TRF_MCG';
        $pil = '';
        $linebuff = '';
        $npers = '';
        $ncab = '';
        $step = '';
        $seq = 0;
        $v_list_file = '';
        $v_file_counter = 0;

        $FNAME = 'TEMP_PLU_BYK_BRC.txt';

        $EOF = DB::connection(Session::get('connection'))->table('TBPLU_BANYAK_BARCODE')
            ->selectRaw('NVL(count(1),0) as count')
            ->first()->count;


        if ($EOF > 0) {


            File::delete(storage_path($FNAME));
            $file = fopen(storage_path($FNAME), "w");
            $this->txtFile[] = $FNAME;


            $perusahaan = DB::connection(Session::get('connection'))->table('tbmaster_perusahaan')
                ->select('PRS_NAMAPERUSAHAAN', 'PRS_NAMACABANG')
                ->where('PRS_KODEIGR', Session::get('kdigr'))
                ->first();
            $NPers = $perusahaan->prs_namaperusahaan;
            $NCab = $perusahaan->prs_namacabang;

            $barcodes = DB::connection(Session::get('connection'))->table('TBPLU_BANYAK_BARCODE')
                ->orderBy('PRDCD')
                ->get();

            if ($barcodes) {
                foreach ($barcodes as $barcode) {

//  -- HEADER
                    if ($r == 0) {
                        $linebuff = '';
                        $linebuff = $linebuff . str_pad('LISTING PLU BANYAK BARCODE', 51, ' ', STR_PAD_LEFT) . chr(13) . chr(10);
                        $linebuff = $linebuff . chr(13) . chr(10);
                        $linebuff = $linebuff . str_pad($NPers, 42, ' ', STR_PAD_RIGHT) . str_pad('TANGGAL : ' . Carbon::now()->format('d/M/Y'), 26, ' ', STR_PAD_RIGHT) . ' JAM : ' . Carbon::now()->format('H:i:s') . chr(13) . chr(10);
                        $linebuff = $linebuff . str_pad($NCab, 42, ' ', STR_PAD_RIGHT) . 'PROGRAM : TRANSFER PLU     HAL : ' . str_pad($hal, 4, '0', STR_PAD_LEFT) . chr(13) . chr(10);
                        $linebuff = $linebuff . str_pad('=', 83, '=', STR_PAD_LEFT) . chr(13) . chr(10);
                        $linebuff = $linebuff . '| NO.| P.L.U |DESKRIPSI                                          |BARCODE         |' . chr(13) . chr(10);
                        $linebuff = $linebuff . str_pad('-', 83, '-', STR_PAD_LEFT) . chr(13) . chr(10);

                        $r = $r + 7;
                    }

//  	-- BODY
                    $linebuff = $linebuff . ' ' . str_pad($r2 + 1, 4, 0, STR_PAD_LEFT) . ' ' . str_pad(($barcode->prdcd), 8, ' ', STR_PAD_RIGHT) . str_pad(SUBSTR($barcode->desk, 1, 50), 52, ' ', STR_PAD_RIGHT) . str_pad($barcode->barcode, 16, ' ', STR_PAD_RIGHT) . chr(13) . chr(10);
                    $r = $r + 1;
                    $r2 = $r2 + 1;

//  	-- FOOTER --
                    if ($hal % 2 == 0) {
                        if ($r == 48 || $r2 == $EOF) {
                            $linebuff = $linebuff . str_pad(' = ', 88, ' = ', STR_PAD_LEFT) . chr(13) . chr(10);
                            $hal = $hal + 1;
                            if ($r2 == $EOF) {
                                $linebuff = $linebuff . str_pad('  ' . $EOF . ' Item(s) Transferred ', 68, ' ', STR_PAD_RIGHT) . ' ** AKHIR LAPORAN ** ';
                            } else {
                                $linebuff = $linebuff . ' ** BERSAMBUNG KE HAL ' . str_pad($hal, 4, '0', STR_PAD_LEFT) . chr(13) . chr(10);
                            }
                            $r = 0;
                            fwrite($file, $linebuff);
                        }
                    } else {
                        if ($r == 49 || $r2 == $EOF) {
                            $linebuff = $linebuff . str_pad('=', 83, '=', STR_PAD_LEFT) . chr(13) . chr(10);
                            $hal = $hal + 1;
                            if ($r2 == $EOF) {

                                $linebuff = $linebuff . str_pad('  ' . $EOF . ' Item(s) Transferred ', 70, ' ', STR_PAD_RIGHT) . '** AKHIR LAPORAN **';
                            } else {
                                $linebuff = $linebuff . '** BERSAMBUNG KE HAL ' . str_pad($hal, 4, '0', STR_PAD_LEFT) . chr(13) . chr(10);
                            }
                            $r = 0;
                            fwrite($file, $linebuff);
                        }
                    }
                }
            }

            fclose($file);


        }
    }

    public function CETAK_DIMENSI_NOL($N_REQ_ID)
    {
        $r = 0;
        $r2 = 0;
        $hal = 1;
        $eof = '';
        $ldel = '';
        $nmbutton = '';
        $dirname = 'S:\TRF_MCG';
        $pil = '';
        $linebuff = '';
        $npers = '';
        $ncab = '';
        $step = '';
        $seq = 0;
        $v_list_file = '';
        $v_file_counter = 0;

        $FNAME = 'TEMP_PLU_DMS_NOL.txt';

        $EOF = DB::connection(Session::get('connection'))->table('TBPLU_BANYAK_BARCODE')
            ->selectRaw('NVL(count(1),0) as count')
            ->first()->count;

        if ($EOF > 0) {

            File::delete(storage_path($FNAME));
            $file = fopen(storage_path($FNAME), "w");
            $this->txtFile[] = $FNAME;


            $perusahaan = DB::connection(Session::get('connection'))->table('tbmaster_perusahaan')
                ->select('PRS_NAMAPERUSAHAAN', 'PRS_NAMACABANG')
                ->where('PRS_KODEIGR', Session::get('kdigr'))
                ->first();
            $NPers = $perusahaan->prs_namaperusahaan;
            $NCab = $perusahaan->prs_namacabang;

            $plus = DB::connection(Session::get('connection'))
                ->table('TBMASTER_PRODMAST')
                ->selectRaw('TBMASTER_PRODMAST.*, SUBSTR (PRD_DESKRIPSIPANJANG, 1, 70) DESK')
                ->where('PRD_KODEIGR', Session::get('kdigr'))
                ->whereRaw('(PRD_DIMENSIPANJANG = 0 OR PRD_DIMENSILEBAR = 0 OR PRD_DIMENSITINGGI = 0 )')
                ->orderBy('PRD_PRDCD')
                ->get();

            if ($plus) {
                foreach ($plus as $plu) {

//  -- HEADER
                    if ($r == 0) {
                        $linebuff = '';
                        $linebuff =
                            $linebuff . str_pad('listing plu dimensi nol', 57, ' ', STR_PAD_LEFT) . chr(13)
                            . chr(10);
                        $linebuff = $linebuff . chr(13) . chr(10);
                        $linebuff = $linebuff . str_pad($NPers, 62, ' ', STR_PAD_RIGHT)
                            . str_pad('tanggal : ' . Carbon::now()->format('d/M/Y'), 26, ' ', STR_PAD_RIGHT)
                            . ' jam : '
                            . Carbon::now()->format('H:i:s')
                            . chr(13)
                            . chr(10);
                        $linebuff =
                            $linebuff
                            . str_pad($NCab, 62, ' ', STR_PAD_RIGHT)
                            . 'program : transfer plu     hal : '
                            . str_pad($hal, 4, '0', STR_PAD_LEFT)
                            . chr(13)
                            . chr(10);
                        $linebuff = $linebuff . str_pad('=', 103, '=', STR_PAD_LEFT) . chr(13) . chr(10);
                        $linebuff =
                            $linebuff
                            . ' plu     deskripsi                                                              panjang   lebar  tinggi'
                            . chr(13)
                            . chr(10);
                        $linebuff = $linebuff . str_pad('-', 103, '-', STR_PAD_LEFT) . chr(13) . chr(10);
                        $r = $r + 7;
                    }

//  	-- BODY
                    $linebuff = $linebuff . ' ' . str_pad($plu->prd_prdcd, 7, ' ', STR_PAD_RIGHT) . ' ' . str_pad($plu->desk, 70, ' ', STR_PAD_RIGHT) . ' ' . str_pad($plu->prd_dimensipanjang, 7, ' ', STR_PAD_LEFT) . ' ' . str_pad($plu->prd_dimensilebar, 7, ' ', STR_PAD_LEFT) . ' ' . str_pad($plu->prd_dimensitinggi, 7, ' ', STR_PAD_LEFT) . chr(13) . chr(10);
                    $r = $r + 1;
                    $r2 = $r2 + 1;

//  	-- FOOTER --
                    if ($hal % 2 == 0) {
                        if ($r == 48 || $r2 == $EOF) {
                            $linebuff = $linebuff . str_pad('=', 103, '=', STR_PAD_LEFT) . chr(13) . chr(10);
                            $hal = $hal + 1;
                            if ($r2 == $EOF) {
                                $linebuff =
                                    $linebuff
                                    . str_pad('  ' . $EOF . ' Item(s) Transferred ', 84, ' ', STR_PAD_RIGHT)
                                    . '** AKHIR LAPORAN **';
                            } else {
                                $linebuff =
                                    $linebuff
                                    . '** BERSAMBUNG KE HAL '
                                    . str_pad($hal, 4, '0', STR_PAD_LEFT)
                                    . chr(13)
                                    . chr(10);
                            }
                            $r = 0;
                            fwrite($file, $linebuff);
                        }
                    } else {
                        if ($r == 49 || $r2 == $EOF) {
                            $linebuff = $linebuff . str_pad('=', 103, '=', STR_PAD_LEFT) . chr(13) . chr(10);
                            $hal = $hal + 1;
                            if ($r2 == $EOF) {

                                $linebuff =
                                    $linebuff
                                    . str_pad('  ' . $EOF . ' Item(s) Transferred ', 84, ' ', STR_PAD_RIGHT)
                                    . '** AKHIR LAPORAN **';
                            } else {
                                $linebuff =
                                    $linebuff
                                    . '** BERSAMBUNG KE HAL '
                                    . str_pad($hal, 4, '0', STR_PAD_LEFT)
                                    . chr(13)
                                    . chr(10);
                            }
                            $r = 0;
                            fwrite($file, $linebuff);
                        }
                    }
                }
            }
            fclose($file);
        }
    }

    public function CETAK_HGBELI($N_REQ_ID)
    {
//        DIBUKA!!!!! contoh
//        $N_REQ_ID = '19216823774';

        $EOF = DB::connection(Session::get('connection'))->select('Select NVL(count(1),0) count
                From temp_hgbeli,
			        tbmaster_prodmast,
			        tbmaster_supplier
			    WHERE
                    FRKODE = PRD_PRDCD(+)
                    AND FRSUPP = SUP_KodeSupplier(+)
                    AND PRD_DESKRIPSIPANJANG IS NOT NULL
                    AND REQ_ID = ' . $N_REQ_ID)[0]->count;


        $perusahaan = DB::connection(Session::get('connection'))->table('tbmaster_perusahaan')
            ->select('PRS_NAMAPERUSAHAAN', 'PRS_NAMACABANG')
            ->where('PRS_KODEIGR', Session::get('kdigr'))
            ->first();
        $NPers = $perusahaan->prs_namaperusahaan;
        $NCab = $perusahaan->prs_namacabang;

        $hal = 1;
        $r = 0;
        $r2 = 0;
        $linebuff = '';

        $FNAME = 'TEMP_HGBELI.txt';
        File::delete(storage_path($FNAME));
        $file = fopen(storage_path($FNAME), "w");
        $this->txtFile[] = $FNAME;


        $hgbs = DB::connection(Session::get('connection'))->select("Select
			    FRKODE,
			    PRD_DESKRIPSIPANJANG AS Nama,
			    PRD_UNIT||'/'||PRD_FRAC as Satuan,
			    FRJNSH,
			    FRSUPP||'-'||SUP_NamaSupplier||'/'||SUP_SingkatanSupplier as Supplier,
			    FRJTOP,
			    FMBELI,FMDISC,
			    FXBELI,FXDISC,
			    FRTGBU,
			    CASE WHEN FRRCID = '1' THEN 'DEL' ELSE '' END AS FLAG
			From
			    temp_hgbeli,
			    tbmaster_prodmast,
			    tbmaster_supplier
			WHERE
			    FRKODE = PRD_PRDCD(+)
			    AND FRSUPP = SUP_KodeSupplier(+)
			    AND PRD_DESKRIPSIPANJANG IS NOT NULL
			    AND REQ_ID = " . $N_REQ_ID . "
			ORDER BY FRKODE");


        if ($hgbs) {
            foreach ($hgbs as $hgb) {
//  	-- HEADER
                if ($r == 0) {
                    $linebuff = '';
                    $linebuff = $linebuff . str_pad('** LAPORAN PERUBAHAN HARGA BELI', 121, ' ', STR_PAD_LEFT) . chr(13) . chr(10);
                    $linebuff = $linebuff . chr(13) . chr(10);
                    $linebuff = $linebuff . str_pad($NPers, 199, ' ', STR_PAD_RIGHT) . str_pad('TANGGAL : ' . Carbon::now()->format('d/M/Y'), 26, ' ', STR_PAD_RIGHT) . ' JAM : ' . Carbon::now()->format('H:i:s') . chr(13) . chr(10);
                    $linebuff = $linebuff . str_pad($NCab, 199, ' ', STR_PAD_RIGHT) . 'PROGRAM : TRANSFER HGBELI  HAL : ' . str_pad($hal, 4, '0', STR_PAD_LEFT) . chr(13) . chr(10);
                    $linebuff = $linebuff . str_pad(' = ', 240, ' = ', STR_PAD_LEFT) . chr(13) . chr(10);
                    $linebuff = $linebuff . 'NO.  PLU      NAMA BARANG                                                                  KONVERSI  JENIS  SUPPLIER                                                            TOP  ----- L A M A -----  ------ B A R U -------  TANGGAL   FLAG' . chr(13) . chr(10);
                    $linebuff = $linebuff . '                                                                                                     HARGA                                                                               HG BELI    DISC      HG BELI       DISC  BERLAKU       ' . chr(13) . chr(10);
                    $linebuff = $linebuff . str_pad(' - ', 240, ' - ', STR_PAD_LEFT) . chr(13) . chr(10);
//
                    $r = $r + 8;
                }
//  	-- BODY
                $linebuff = $linebuff . str_pad($r2 + 1, 4, 0) . ' ' . str_pad(($hgb->FRKODE), 7, ' ', STR_PAD_RIGHT) . ' ' . str_pad(SUBSTR($hgb->NAMA, 1, 50), 75, ' ', STR_PAD_RIGHT) . '   ' . str_pad($hgb->SATUAN, 9, ' ', STR_PAD_RIGHT) . ' ' . str_pad($hgb->FRJNSH, 6, ' ', STR_PAD_RIGHT) . ' ' . str_pad($hgb->SUPPLIER, 67, ' ', STR_PAD_RIGHT) . ' ' . str_pad($hgb->FRJTOP, 3, ' ', STR_PAD_RIGHT) . ' ' . str_pad($hgb->FMBELI, 13, ' ', STR_PAD_LEFT) . ' ' . str_pad($hgb->FMDISC, 5, ' ', STR_PAD_LEFT) . ' ' . str_pad($hgb->FXBELI, 13, ' ', STR_PAD_LEFT) . ' ' . str_pad($hgb->FXDISC, 10, ' ', STR_PAD_LEFT) . ' ' . str_pad($hgb->FRTGBU, 10, ' ', STR_PAD_RIGHT) . ' ' . str_pad($hgb->FLAG, 3, ' ', STR_PAD_RIGHT) . chr(13) . chr(10);
                $r = $r + 1;
                $r2 = $r2 + 1;

//  	-- FOOTER --
                if ($hal % 2 == 0) {
                    if ($r == 48 || $r2 == $EOF) {
                        $linebuff = $linebuff . str_pad(' = ', 88, ' = ', STR_PAD_LEFT) . chr(13) . chr(10);
                        $hal = $hal + 1;
                        if ($r2 == $EOF) {
                            $linebuff = $linebuff . str_pad('  ' . $EOF . ' Item(s) Transferred ', 220, ' ', STR_PAD_RIGHT) . ' ** AKHIR LAPORAN ** ';
                        } else {
                            $linebuff = $linebuff . ' ** BERSAMBUNG KE HAL ' . str_pad($hal, 4, '0', STR_PAD_LEFT) . chr(13) . chr(10);
                        }
                        $r = 0;
                        fwrite($file, $linebuff);
                    }
                } else {
                    if ($r == 49 || $r2 == $EOF) {
                        $linebuff = $linebuff . str_pad(' = ', 88, ' = ', STR_PAD_LEFT) . chr(13) . chr(10);
                        $hal = $hal + 1;
                        if ($r2 == $EOF) {
                            $linebuff = $linebuff . str_pad('  ' . $EOF . ' Item(s) Transferred ', 220, ' ', STR_PAD_RIGHT) . ' ** AKHIR LAPORAN ** ';
                        } else {
                            $linebuff = $linebuff . ' ** BERSAMBUNG KE HAL ' . str_pad($hal, 4, '0', STR_PAD_LEFT) . chr(13) . chr(10);
                        }
                        $r = 0;
//  		            outputfile disini
                        fwrite($file, $linebuff);
                    }
                }
            }
        }
        fclose($file);


//  	STEP = 9;
//        DIBUKA!!!!
        DB::connection(Session::get('connection'))->table('TEMP_HGBELI')
            ->where('REQ_ID', $N_REQ_ID)
            ->delete();
    }

    public function CETAK_SUPPLIER($N_REQ_ID)
    {
//        DIBUKA!!!!! contoh
//        $N_REQ_ID = '19216823774';

        $EOF = DB::connection(Session::get('connection'))->table('TEMP_SUPPLIER')
            ->selectRaw('NVL(count(1),0) count')
            ->where('REQ_ID', $N_REQ_ID)
            ->first()->count;


        $perusahaan = DB::connection(Session::get('connection'))->table('tbmaster_perusahaan')
            ->select('PRS_NAMAPERUSAHAAN', 'PRS_NAMACABANG')
            ->where('PRS_KODEIGR', Session::get('kdigr'))
            ->first();
        $NPers = $perusahaan->prs_namaperusahaan;
        $NCab = $perusahaan->prs_namacabang;

        $hal = 1;
        $r = 0;
        $r2 = 0;
        $linebuff = '';

        $FNAME = 'TEMP_SUPPLIER.txt';
        File::delete(storage_path($FNAME));
        $file = fopen(storage_path($FNAME), "w");
        $this->txtFile[] = $FNAME;


        $sups = DB::connection(Session::get('connection'))->table('TEMP_SUPPLIER')
            ->selectRaw("FMKODE,
                FMSUPP,
                FMNAMA,
                FMALM1,
                CASE WHEN FMTIPE = 'T' THEN 'TAMBAH' ELSE 'RUBAH' END as STATUS,
  				FONAMA,
  				FOALMT")
            ->where('REQ_ID', $N_REQ_ID)
            ->orderBy('FMKODE')
            ->get();


        if ($sups) {
            foreach ($sups as $sup) {
//  	-- HEADER
                if ($r == 0) {
                    $linebuff = '';
                    $linebuff = $linebuff . str_pad('** LISTING TRANSFER SUPPLIER', 121, ' ', STR_PAD_LEFT) . chr(13) . chr(10);
                    $linebuff = $linebuff . chr(13) . chr(10);
                    $linebuff = $linebuff . str_pad($NPers, 199, ' ', STR_PAD_RIGHT) . str_pad('TANGGAL : ' . Carbon::now()->format('d/M/Y'), 26, ' ', STR_PAD_RIGHT) . ' JAM : ' . Carbon::now()->format('H:i:s') . chr(13) . chr(10);
                    $linebuff = $linebuff . str_pad($NCab, 197, ' ', STR_PAD_RIGHT) . 'PROGRAM : TRANSFER SUPPLIER  HAL : ' . str_pad($hal, 4, '0', STR_PAD_LEFT) . chr(13) . chr(10);
                    $linebuff = $linebuff . str_pad(' = ', 240, ' = ', STR_PAD_LEFT) . chr(13) . chr(10);
                    $linebuff = $linebuff . '                      ============================================== SEBELUM TRANSFER ============================================  ============================================ SETELAH TRANSFER ==============================================' . chr(13) . chr(10);
                    $linebuff = $linebuff . 'KODE  KODE HO  STATUS NAMA SUPPLIER                                                          ALAMAT                                 NAMA SUPPLIER                                                          ALAMAT                               ' . chr(13) . chr(10);
                    $linebuff = $linebuff . str_pad(' - ', 240, ' - ', STR_PAD_LEFT) . chr(13) . chr(10);
//
                    $r = $r + 8;
                }
//  	-- BODY
                if ($sup->status == 'TAMBAH') {
                    $linebuff = $linebuff . str_pad($sup->FMKODE, 7, ' ', STR_PAD_RIGHT) . str_pad($sup->FMSUPP, 8, ' ', STR_PAD_RIGHT) . str_pad($sup->STATUS, 7, ' ') . str_pad($sup->FMNAMA, 70, ' ', STR_PAD_RIGHT) . str_pad($sup->FMALM1, 39, ' ', STR_PAD_RIGHT) . chr(13) . chr(10);
                } else {
                    $linebuff = $linebuff . str_pad($sup->FMKODE, 7, ' ', STR_PAD_RIGHT) . str_pad($sup->FMSUPP, 8, ' ', STR_PAD_RIGHT) . str_pad($sup->STATUS, 7, ' ', STR_PAD_RIGHT) . str_pad($sup->FMNAMA, 70, ' ', STR_PAD_RIGHT) . str_pad($sup->FMALM1, 39, ' ', STR_PAD_RIGHT) . str_pad($sup->FONAMA, 71, ' ', STR_PAD_RIGHT) . str_pad($sup->FOALMT, 37, ' ', STR_PAD_RIGHT) . chr(13) . chr(10);
                }
                $r = $r + 1;
                $r2 = $r2 + 1;

//  	-- FOOTER --
                if ($hal % 2 == 0) {
                    if ($r == 48 || $r2 == $EOF) {
                        $linebuff = $linebuff . str_pad(' = ', 240, ' = ', STR_PAD_LEFT) . chr(13) . chr(10);
                        $hal = $hal + 1;
                        if ($r2 == $EOF) {
                            $linebuff = $linebuff . str_pad('  ' . $EOF . ' Item(s) Transferred ', 220, ' ', STR_PAD_RIGHT) . ' ** AKHIR LAPORAN ** ';
                        } else {
                            $linebuff = $linebuff . ' ** BERSAMBUNG KE HAL ' . str_pad($hal, 4, '0', STR_PAD_LEFT) . chr(13) . chr(10);
                        }
                        $r = 0;
                        fwrite($file, $linebuff);
                    }
                } else {
                    if ($r == 49 || $r2 == $EOF) {
                        $linebuff = $linebuff . str_pad(' = ', 240, ' = ', STR_PAD_LEFT) . chr(13) . chr(10);
                        $hal = $hal + 1;
                        if ($r2 == $EOF) {
                            $linebuff = $linebuff . str_pad('  ' . $EOF . ' Item(s) Transferred ', 220, ' ', STR_PAD_RIGHT) . ' ** AKHIR LAPORAN ** ';
                        } else {
                            $linebuff = $linebuff . ' ** BERSAMBUNG KE HAL ' . str_pad($hal, 4, '0', STR_PAD_LEFT) . chr(13) . chr(10);
                        }
                        $r = 0;
//  		            outputfile disini
                        fwrite($file, $linebuff);
                    }
                }
            }
        }
        fclose($file);


//  	STEP = 9;
//        DIBUKA!!!!
        DB::connection(Session::get('connection'))->table('TEMP_SUPPLIER')
            ->where('REQ_ID', $N_REQ_ID)
            ->delete();
    }

    public function CETAK_HRG_PROMO($N_REQ_ID)
    {
//        DIBUKA!!!!! contoh
//        $N_REQ_ID = '19216823774';

        $EOF = DB::connection(Session::get('connection'))->table('TEMP_HRG_PROMO')
            ->select('FMKODE')
            ->where('REQ_ID', $N_REQ_ID)
            ->whereRaw('TRUNC(FMFRTG) >=  TRUNC(sysdate)')
            ->orWhereRaw('TRUNC(FMFRTB) >= TRUNC(sysdate)')
            ->distinct()->count();

        $perusahaan = DB::connection(Session::get('connection'))->table('tbmaster_perusahaan')
            ->select('PRS_NAMAPERUSAHAAN', 'PRS_NAMACABANG')
            ->where('PRS_KODEIGR', Session::get('kdigr'))
            ->first();
        $NPers = $perusahaan->prs_namaperusahaan;
        $NCab = $perusahaan->prs_namacabang;

        $hal = 1;
        $r = 0;
        $r2 = 0;
        $linebuff = '';

        $FNAME = 'TEMP_HRGPROMO.txt';
        File::delete(storage_path($FNAME));
        $file = fopen(storage_path($FNAME), "w");
        $this->txtFile[] = $FNAME;


        $hrg_promos = DB::connection(Session::get('connection'))->table('TEMP_HRG_PROMO')
            ->leftJoin('tbMaster_Prodmast', 'PRD_PRDCD', '=', 'FMKODE')
            ->selectRaw("FMKODE,FMJAMA, FMJAMB,
  	       PRD_DeskripsiPendek, PRD_Unit, PRD_Frac, PRD_HrgJual,
  	 			 FMFRTG, FMTOTG,FMJUAL, FMPOTR, FMPOTP,
  	 			 FMFRTB, FMTOTB, FMHJLB, FMPORB, FMPOPB")
            ->where('REQ_ID', $N_REQ_ID)
            ->where('PRD_KodeIgr', Session::get('kdigr'))
            ->whereRaw('(TRUNC(FMFRTG) >=  TRUNC(sysdate) OR TRUNC(FMFRTB) >= TRUNC(sysdate))')
            ->orderBy('FMKODE')
            ->distinct()
            ->get();

        if ($hrg_promos) {
            foreach ($hrg_promos as $hrg_promo) {
//  	-- HEADER
                if ($r == 0) {
                    $linebuff = '';
                    $linebuff = $linebuff . str_pad('** LISTING TRANSFER HARGA PROMO **', 113, ' ', STR_PAD_LEFT) . chr(13) . chr(10);
                    $linebuff = $linebuff . chr(13) . chr(10);
                    $linebuff = $linebuff . str_pad($NPers, 127, ' ', STR_PAD_RIGHT) . str_pad('TANGGAL : ' . Carbon::now()->format('d/M/Y'), 30, ' ', STR_PAD_RIGHT) . ' JAM : ' . Carbon::now()->format('H:i:s') . chr(13) . chr(10);
                    $linebuff = $linebuff . str_pad($NCab, 127, ' ', STR_PAD_RIGHT) . 'PROGRAM : TRANSFER HRG PROMO  HAL : ' . str_pad($hal, 4, '0', STR_PAD_LEFT) . chr(13) . chr(10);
                    $linebuff = $linebuff . str_pad(' = ', 240, ' = ', STR_PAD_LEFT) . chr(13) . chr(10);
                    $linebuff = $linebuff . '===========================================================================================================================================================================' . chr(13) . chr(10);
                    $linebuff = $linebuff . 'P L U   NAMA BARANG          SATUAN      HG.JUAL    --JAM DISCOUNT--    --------------------- PROMOSI I -----------------  ---------------------- PROMOSI II --------------' . chr(13) . chr(10);
                    $linebuff = $linebuff . '                                          MASTER    DARI      HINGGA    DARI       HINGGA          HG.JUAL  POT Rp  POT %  DARI       HINGGA         HG.JUAL  POT Rp  POT %' . chr(13) . chr(10);
                    $linebuff = $linebuff . str_pad(' - ', 171, ' - ', STR_PAD_LEFT) . chr(13) . chr(10);
//
                    $r = $r + 8;
                }
//  	-- BODY
                $linebuff = $linebuff . str_pad($hrg_promo->FMKODE, 8, ' ', STR_PAD_RIGHT) . str_pad($hrg_promo->PRD_DeskripsiPendek, 21, ' ', STR_PAD_RIGHT) . str_pad($hrg_promo->PRD_UNIT . '/' . $hrg_promo->PRD_FRAC, 7, ' ', STR_PAD_RIGHT) . str_pad($hrg_promo->PRD_HrgJual, 12, ' ', STR_PAD_LEFT) . '     ' . str_pad(NVL($hrg_promo->FMJAMA, ' '), 10, ' ', STR_PAD_RIGHT) . str_pad($hrg_promo->FMJAMB, 9, ' ', STR_PAD_RIGHT) . str_pad(Carbon::parse($hrg_promo->FMFRTG)->format('d-M-Y'), 10, ' ', STR_PAD_RIGHT) . ' ' . str_pad(Carbon::parse($hrg_promo->FMTOTG)->format('d-M-Y'), 10, ' ', STR_PAD_RIGHT) . str_pad($hrg_promo->FMJUAL, 13, ' ', STR_PAD_LEFT) . ' ' . str_pad($hrg_promo->FMPOTR, 7, ' ', STR_PAD_LEFT) . ' ' . str_pad($hrg_promo->FMPOTP, 6, ' ', STR_PAD_LEFT) . '  ' . str_pad(Carbon::parse($hrg_promo->FMFRTB)->format('d-M-Y'), 10, ' ', STR_PAD_RIGHT) . ' ' . str_pad(Carbon::parse($hrg_promo->FMTOTB)->format('d-M-Y'), 10, ' ', STR_PAD_RIGHT) . str_pad($hrg_promo->FMHJLB, 12, ' ', STR_PAD_LEFT) . ' ' . str_pad($hrg_promo->FMPORB, 7, ' ', STR_PAD_LEFT) . ' ' . str_pad($hrg_promo->FMPOPB, 6, ' ', STR_PAD_LEFT) . chr(13) . chr(10);
                $r = $r + 1;
                $r2 = $r2 + 1;

//  	-- FOOTER --
                if ($hal % 2 == 0) {
                    if ($r == 48 || $r2 == $EOF) {
                        $linebuff = $linebuff . str_pad(' = ', 171, ' = ', STR_PAD_LEFT) . chr(13) . chr(10);
                        $hal = $hal + 1;
                        if ($r2 == $EOF) {
                            $linebuff = $linebuff . str_pad('  ' . $EOF . ' Item(s) Transferred ', 152, ' ', STR_PAD_RIGHT) . ' ** AKHIR LAPORAN ** ';
                        } else {
                            $linebuff = $linebuff . ' ** BERSAMBUNG KE HAL ' . str_pad($hal, 4, '0', STR_PAD_LEFT) . chr(13) . chr(10);
                        }
                        $r = 0;
                        fwrite($file, $linebuff);
                    }
                } else {
                    if ($r == 49 || $r2 == $EOF) {
                        $linebuff = $linebuff . str_pad(' = ', 171, ' = ', STR_PAD_LEFT) . chr(13) . chr(10);
                        $hal = $hal + 1;
                        if ($r2 == $EOF) {
                            $linebuff = $linebuff . str_pad('  ' . $EOF . ' Item(s) Transferred ', 152, ' ', STR_PAD_RIGHT) . ' ** AKHIR LAPORAN ** ';
                        } else {
                            $linebuff = $linebuff . ' ** BERSAMBUNG KE HAL ' . str_pad($hal, 4, '0', STR_PAD_LEFT) . chr(13) . chr(10);
                        }
                        $r = 0;
//  		            outputfile disini
                        fwrite($file, $linebuff);
                    }
                }
            }
        }
        fclose($file);


//  	STEP = 9;
//        DIBUKA!!!!
        DB::connection(Session::get('connection'))->table('TEMP_HRG_PROMO')
            ->where('REQ_ID', $N_REQ_ID)
            ->delete();
    }

    public function CETAK_BTL_PROMO($N_REQ_ID)
    {
//        DIBUKA!!!!! contoh
//        $N_REQ_ID = '19216823774';

        $EOF = DB::connection(Session::get('connection'))->table('TEMP_BTL_PROMO')
            ->select('FMKODE')
            ->where('REQ_ID', $N_REQ_ID)
            ->distinct()->count();

        $perusahaan = DB::connection(Session::get('connection'))->table('tbmaster_perusahaan')
            ->select('PRS_NAMAPERUSAHAAN', 'PRS_NAMACABANG')
            ->where('PRS_KODEIGR', Session::get('kdigr'))
            ->first();
        $NPers = $perusahaan->prs_namaperusahaan;
        $NCab = $perusahaan->prs_namacabang;

        $hal = 1;
        $r = 0;
        $r2 = 0;
        $linebuff = '';

        $FNAME = 'TEMP_BTLPROMO.txt';
        File::delete(storage_path($FNAME));
        $file = fopen(storage_path($FNAME), "w");
        $this->txtFile[] = $FNAME;


        $bottles = DB::connection(Session::get('connection'))->table('TEMP_BTL_PROMO')
            ->leftJoin('tbMaster_Prodmast', 'PRD_PRDCD', '=', 'FMKODE')
            ->selectRaw("FMKODE,FMJAMA, FMJAMB,
  	       PRD_DeskripsiPendek, PRD_Unit, PRD_Frac, PRD_HrgJual,
  	 			 FMFRTG, FMTOTG,FMJUAL, FMPOTR, FMPOTP")
            ->where('REQ_ID', $N_REQ_ID)
            ->where('PRD_KodeIgr', Session::get('kdigr'))
            ->orderBy('FMKODE')
            ->distinct()
            ->get();

        if ($bottles) {
            foreach ($bottles as $bottle) {
//  	-- HEADER
                if ($r == 0) {
                    $linebuff = '';
                    $linebuff = $linebuff . str_pad('** LISTING BATAL PROMOSI **', 105, ' ', STR_PAD_LEFT) . chr(13) . chr(10);
                    $linebuff = $linebuff . chr(13) . chr(10);
                    $linebuff = $linebuff . str_pad($NPers, 71, ' ', STR_PAD_RIGHT) . str_pad('TANGGAL : ' . Carbon::now()->format('d/M/Y'), 30, ' ', STR_PAD_RIGHT) . ' JAM : ' . Carbon::now()->format('H:i:s') . chr(13) . chr(10);
                    $linebuff = $linebuff . str_pad($NCab, 71, ' ', STR_PAD_RIGHT) . 'PROGRAM : TRANSFER HRG PROMO  HAL : ' . str_pad($hal, 4, '0', STR_PAD_LEFT) . chr(13) . chr(10);
                    $linebuff = $linebuff . str_pad(' = ', 240, ' = ', STR_PAD_LEFT) . chr(13) . chr(10);
                    $linebuff = $linebuff . '===================================================================================================================' . chr(13) . chr(10);
                    $linebuff = $linebuff . 'P L U   NAMA BARANG          SATUAN      HG.JUAL    --JAM DISCOUNT--    -------------- P R O M O S I --------------' . chr(13) . chr(10);
                    $linebuff = $linebuff . '                                          MASTER    DARI      HINGGA    DARI      HINGGA     HG.JUAL  POT Rp  POT %' . chr(13) . chr(10);
                    $linebuff = $linebuff . str_pad(' - ', 116, ' - ', STR_PAD_LEFT) . chr(13) . chr(10);
//
                    $r = $r + 8;
                }
//  	-- BODY
                $linebuff = $linebuff . str_pad($bottle->FMKODE, 8, ' ', STR_PAD_RIGHT) . str_pad($bottle->PRD_DeskripsiPendek, 21, ' ', STR_PAD_RIGHT) . str_pad($bottle->PRD_UNIT . '/' . $bottle->PRD_FRAC, 7, ' ', STR_PAD_RIGHT) . str_pad($bottle->PRD_HrgJual, 12, ' ', STR_PAD_LEFT) . '     ' . str_pad($bottle->FMJAMA, 10, ' ', STR_PAD_RIGHT) . str_pad($bottle->FMJAMB, 9, ' ', STR_PAD_RIGHT) . str_pad(Carbon::parse($bottle->FMFRTG)->format('d-M-Y'), 10, ' ', STR_PAD_RIGHT) . ' ' . str_pad(Carbon::parse($bottle->FMTOTG)->format('d-M-Y'), 10, ' ', STR_PAD_RIGHT) . str_pad($bottle->FMJUAL, 13, ' ', STR_PAD_LEFT) . ' ' . str_pad($bottle->FMPOTR, 7, ' ', STR_PAD_LEFT) . ' ' . str_pad($bottle->FMPOTP, 6, ' ', STR_PAD_LEFT) . chr(13) . chr(10);
                $r = $r + 1;
                $r2 = $r2 + 1;

//  	-- FOOTER --
                if ($hal % 2 == 0) {
                    if ($r == 48 || $r2 == $EOF) {
                        $linebuff = $linebuff . str_pad(' = ', 116, ' = ', STR_PAD_LEFT) . chr(13) . chr(10);
                        $hal = $hal + 1;
                        if ($r2 == $EOF) {
                            $linebuff = $linebuff . str_pad('  ' . $EOF . ' Item(s) Transferred ', 142, ' ', STR_PAD_RIGHT) . ' ** AKHIR LAPORAN ** ';
                        } else {
                            $linebuff = $linebuff . ' ** BERSAMBUNG KE HAL ' . str_pad($hal, 4, '0', STR_PAD_LEFT) . chr(13) . chr(10);
                        }
                        $r = 0;
                        fwrite($file, $linebuff);
                    }
                } else {
                    if ($r == 49 || $r2 == $EOF) {
                        $linebuff = $linebuff . str_pad(' = ', 116, ' = ', STR_PAD_LEFT) . chr(13) . chr(10);
                        $hal = $hal + 1;
                        if ($r2 == $EOF) {
                            $linebuff = $linebuff . str_pad('  ' . $EOF . ' Item(s) Transferred ', 152, ' ', STR_PAD_RIGHT) . ' ** AKHIR LAPORAN ** ';
                        } else {
                            $linebuff = $linebuff . ' ** BERSAMBUNG KE HAL ' . str_pad($hal, 4, '0', STR_PAD_LEFT) . chr(13) . chr(10);
                        }
                        $r = 0;
//  		            outputfile disini
                        fwrite($file, $linebuff);
                    }
                }
            }
        }
        fclose($file);


//  	STEP = 9;
//        DIBUKA!!!!
        DB::connection(Session::get('connection'))->table('TEMP_BTL_PROMO')
            ->where('REQ_ID', $N_REQ_ID)
            ->delete();
    }

    public function CETAK_MARGIN($N_REQ_ID)
    {
//        DIBUKA!!!!! contoh
//        $N_REQ_ID = '19216823774';

        $EOF = DB::connection(Session::get('connection'))->select('SELECT NVL(COUNT(1),0) count
            FROM
			    TEMP_MGN,
			    TBMASTER_DEPARTEMENT,
			    TBMASTER_KATEGORI
			WHERE
			    REQ_ID = ' . $N_REQ_ID . ' AND
			    kd_dept = dep_kodedepartement(+) AND
			    kd_kat = kat_kodekategori(+) AND
			    kd_dept = kat_kodedepartement(+)')[0]->count;

        $perusahaan = DB::connection(Session::get('connection'))->table('tbmaster_perusahaan')
            ->select('PRS_NAMAPERUSAHAAN', 'PRS_NAMACABANG')
            ->where('PRS_KODEIGR', Session::get('kdigr'))
            ->first();
        $NPers = $perusahaan->prs_namaperusahaan;
        $NCab = $perusahaan->prs_namacabang;

        $hal = 1;
        $r = 0;
        $r2 = 0;
        $linebuff = '';

        $FNAME = 'TEMP_MARGIN.txt';
        File::delete(storage_path($FNAME));
        $file = fopen(storage_path($FNAME), "w");
        $this->txtFile[] = $FNAME;


        $margins = DB::connection(Session::get('connection'))->select("SELECT dc_idm,
						kd_dept||' - '||dep_namadepartement dept,
						kd_kat||' - '||kat_namakategori kat,
						kd_plu pluidm, margin
			FROM
			    TEMP_MGN,
			    TBMASTER_DEPARTEMENT,
			    TBMASTER_KATEGORI
			WHERE
			    REQ_ID = " . $N_REQ_ID . " AND
			    kd_dept = dep_kodedepartement(+) AND
			    kd_kat = kat_kodekategori(+) AND
			    kd_dept = kat_kodedepartement(+)
			ORDER BY
					dc_idm, kd_dept, kd_kat, kd_plu	");

        if ($margins) {
            foreach ($margins as $margin) {
//  	-- HEADER
                if ($r == 0) {
                    $linebuff = '';
                    $linebuff = $linebuff . str_pad('** LAPORAN PERUBAHAN TRANSFER MARGIN **', 63, ' ', STR_PAD_LEFT) . chr(13) . chr(10);
                    $linebuff = $linebuff . chr(13) . chr(10);
                    $linebuff = $linebuff . str_pad($NPers, 67, ' ', STR_PAD_RIGHT) . str_pad('TANGGAL : ' . Carbon::now()->format('d/M/Y'), 26, ' ', STR_PAD_RIGHT) . ' JAM : ' . Carbon::now()->format('H:i:s') . chr(13) . chr(10);
                    $linebuff = $linebuff . str_pad($NCab, 67, ' ', STR_PAD_RIGHT) . 'PROGRAM : TRANSFER MARGIN  HAL : ' . str_pad($hal, 4, '0', STR_PAD_LEFT) . chr(13) . chr(10);
                    $linebuff = $linebuff . str_pad(' = ', 108, ' = ', STR_PAD_LEFT) . chr(13) . chr(10);
                    $linebuff = $linebuff . 'DC    Departement                          Kategori                                       PLU IDM     Margin' . chr(13) . chr(10);
                    $linebuff = $linebuff . str_pad(' - ', 108, ' - ', STR_PAD_LEFT) . chr(13) . chr(10);
//
                    $r = $r + 8;
                }
//  	-- BODY
                $linebuff = $linebuff . str_pad($margin->dc_idm, 4, ' ', STR_PAD_RIGHT) . str_pad($margin->dept, 35, ' ', STR_PAD_RIGHT) . str_pad($margin->kat, 45, ' ', STR_PAD_RIGHT) . str_pad($margin->pluidm, 10, ' ', STR_PAD_LEFT) . '     ' . str_pad($margin->margin, 6, ' ', STR_PAD_RIGHT) . chr(13) . chr(10);
                $r = $r + 1;
                $r2 = $r2 + 1;

//  	-- FOOTER --
                if ($hal % 2 == 0) {
                    if ($r == 48 || $r2 == $EOF) {
                        $linebuff = $linebuff . str_pad(' = ', 108, ' = ', STR_PAD_LEFT) . chr(13) . chr(10);
                        $hal = $hal + 1;
                        if ($r2 == $EOF) {
                            $linebuff = $linebuff . str_pad('  ' . $EOF . ' Item(s) Transferred ', 88, ' ', STR_PAD_RIGHT) . ' ** AKHIR LAPORAN ** ';
                        } else {
                            $linebuff = $linebuff . ' ** BERSAMBUNG KE HAL ' . str_pad($hal, 4, '0', STR_PAD_LEFT) . chr(13) . chr(10);
                        }
                        $r = 0;
                        fwrite($file, $linebuff);
                    }
                } else {
                    if ($r == 49 || $r2 == $EOF) {
                        $linebuff = $linebuff . str_pad(' = ', 108, ' = ', STR_PAD_LEFT) . chr(13) . chr(10);
                        $hal = $hal + 1;
                        if ($r2 == $EOF) {
                            $linebuff = $linebuff . str_pad('  ' . $EOF . ' Item(s) Transferred ', 88, ' ', STR_PAD_RIGHT) . ' ** AKHIR LAPORAN ** ';
                        } else {
                            $linebuff = $linebuff . ' ** BERSAMBUNG KE HAL ' . str_pad($hal, 4, '0', STR_PAD_LEFT) . chr(13) . chr(10);
                        }
                        $r = 0;
//  		            outputfile disini
                        fwrite($file, $linebuff);
                    }
                }
            }
        }
        fclose($file);


//  	STEP = 9;
//        DIBUKA!!!!
        DB::connection(Session::get('connection'))->table('TEMP_MGN')
            ->where('REQ_ID', $N_REQ_ID)
            ->delete();
    }

    public function CETAK_BRGDELOMI($N_REQ_ID)
    {
//        DIBUKA!!!!! contoh
//        $N_REQ_ID = '19216823774';

        $EOF = DB::connection(Session::get('connection'))->select('SELECT NVL(COUNT(1),0) count
            FROM temp_brgdel_omi, tbmaster_prodmast
     WHERE sessid = ' . $N_REQ_ID . ' AND prd_kodeigr(+) = nkdigr AND prd_prdcd(+) = pluigr')[0]->count;

        $perusahaan = DB::connection(Session::get('connection'))->table('tbmaster_perusahaan')
            ->select('PRS_NAMAPERUSAHAAN', 'PRS_NAMACABANG')
            ->where('PRS_KODEIGR', Session::get('kdigr'))
            ->first();
        $NPers = $perusahaan->prs_namaperusahaan;
        $NCab = $perusahaan->prs_namacabang;

        $hal = 1;
        $r = 0;
        $r2 = 0;
        $linebuff = '';

        $FNAME = 'TEMP_BRGEDL_OMI.txt';
        File::delete(storage_path($FNAME));
        $file = fopen(storage_path($FNAME), "w");
        $this->txtFile[] = $FNAME;


        $rn = 0;
        $recs = DB::connection(Session::get('connection'))->select("SELECT   pluomi,
                             pluigr,
                             NVL(prd_deskripsipanjang, ' ') prd_deskripsipanjang,
                             NVL(prd_unit, ' ') prd_unit,
                             NVL(TO_CHAR(prd_frac), ' ') prd_frac
                        FROM temp_brgdel_omi, tbmaster_prodmast
                       WHERE sessid = " . $N_REQ_ID . " AND prd_kodeigr(+) = nkdigr AND prd_prdcd(+) = pluigr
                    ORDER BY pluomi");

        if ($recs) {
            foreach ($recs as $rec) {
//  	-- HEADER
                if ($r == 0) {
                    $linebuff = '';
                    $linebuff = $linebuff . str_pad('LIST PLU - PLU YANG NON-AKTIF', 60, ' ', STR_PAD_LEFT) . chr(13) . chr(10);
                    $linebuff = $linebuff . chr(13) . chr(10);
                    $linebuff = $linebuff . str_pad($NPers, 59, ' ', STR_PAD_RIGHT) . str_pad('TANGGAL : ' . Carbon::now()->format('d/M/Y'), 31, ' ', STR_PAD_RIGHT) . ' JAM : ' . Carbon::now()->format('H:i:s') . chr(13) . chr(10);
                    $linebuff = $linebuff . str_pad($NCab, 59, ' ', STR_PAD_RIGHT) . 'PROGRAM : TRANSFER PLU OMI     HAL : ' . str_pad($hal, 4, '0', STR_PAD_LEFT) . chr(13) . chr(10);
                    $linebuff = $linebuff . str_pad(' = ', 108, ' = ', STR_PAD_LEFT) . chr(13) . chr(10);
                    $linebuff = $linebuff . '  NO PLU_OMI PLU_IGR DESKRIPSI                                                                   SATUAN' . chr(13) . chr(10);
                    $linebuff = $linebuff . str_pad(' - ', 104, ' - ', STR_PAD_LEFT) . chr(13) . chr(10);
//
                    $r = $r + 7;
                }
//  	-- BODY
                $rn = $rn + 1;
                $linebuff = $linebuff . str_pad($rn, 4, ' ', STR_PAD_RIGHT) . str_pad($rec->pluomi, 7, ' ', STR_PAD_RIGHT) . str_pad($rec->pluigr, 7, ' ', STR_PAD_RIGHT) . str_pad($rec->prd_deskripsipanjang, 75, ' ', STR_PAD_LEFT) . '     ' . str_pad($rec->prd_unit, 3, ' ', STR_PAD_RIGHT) . str_pad($rec->prd_frac, 3, ' ', STR_PAD_RIGHT) . chr(13) . chr(10);
                $r = $r + 1;
                $r2 = $r2 + 1;

//  	-- FOOTER --
                if ($hal % 2 == 0) {
                    if ($r == 48 || $r2 == $EOF) {
                        $linebuff = $linebuff . str_pad(' = ', 104, ' = ', STR_PAD_LEFT) . chr(13) . chr(10);
                        $hal = $hal + 1;
                        if ($r2 == $EOF) {
                            $linebuff = $linebuff . str_pad('  ' . $EOF . ' Item(s) Transferred ', 84, ' ', STR_PAD_RIGHT) . ' ** AKHIR LAPORAN ** ';
                        } else {
                            $linebuff = $linebuff . ' ** BERSAMBUNG KE HAL ' . str_pad($hal, 4, '0', STR_PAD_LEFT) . chr(13) . chr(10);
                        }
                        $r = 0;
                        fwrite($file, $linebuff);
                    }
                } else {
                    if ($r == 49 || $r2 == $EOF) {
                        $linebuff = $linebuff . str_pad(' = ', 104, ' = ', STR_PAD_LEFT) . chr(13) . chr(10);
                        $hal = $hal + 1;
                        if ($r2 == $EOF) {
                            $linebuff = $linebuff . str_pad('  ' . $EOF . ' Item(s) Transferred ', 84, ' ', STR_PAD_RIGHT) . ' ** AKHIR LAPORAN ** ';
                        } else {
                            $linebuff = $linebuff . ' ** BERSAMBUNG KE HAL ' . str_pad($hal, 4, '0', STR_PAD_LEFT) . chr(13) . chr(10);
                        }
                        $r = 0;
//  		            outputfile disini
                        fwrite($file, $linebuff);
                    }
                }
            }
        }
        fclose($file);


//  	STEP = 9;
//        DIBUKA!!!!
        DB::connection(Session::get('connection'))->table('TEMP_MGN')
            ->where('REQ_ID', $N_REQ_ID)
            ->delete();
    }

    public function CETAK_BRXOMI_NULL($N_REQ_ID)
    {
//        DIBUKA!!!!! contoh
//        $N_REQ_ID = '19216823774';

        $EOF = DB::connection(Session::get('connection'))->select('SELECT NVL(COUNT(1),0) count
            FROM TEMP_BRX_OMI, tbmaster_prodmast
     WHERE sessid = ' . $N_REQ_ID . ' AND (PLUIGR IS NULL OR PLUOMI IS NULL) AND PRD_PRDCD(+) = PLUIGR')[0]->count;

        $perusahaan = DB::connection(Session::get('connection'))->table('tbmaster_perusahaan')
            ->select('PRS_NAMAPERUSAHAAN', 'PRS_NAMACABANG')
            ->where('PRS_KODEIGR', Session::get('kdigr'))
            ->first();
        $NPers = $perusahaan->prs_namaperusahaan;
        $NCab = $perusahaan->prs_namacabang;

        $hal = 1;
        $r = 0;
        $r2 = 0;
        $linebuff = '';

        $FNAME = 'TEMP_BRXOMINULL.txt';
        File::delete(storage_path($FNAME));
        $file = fopen(storage_path($FNAME), "w");
        $this->txtFile[] = $FNAME;


        $rn = 0;
        $recs = DB::connection(Session::get('connection'))->select("SELECT   pluomi,
                             pluigr,
                             NVL(prd_deskripsipanjang, ' ') prd_deskripsipanjang,
                             NVL(prd_unit, ' ') prd_unit,
                             NVL(TO_CHAR(prd_frac), ' ') prd_frac
                        FROM TEMP_BRX_OMI, tbmaster_prodmast
                       WHERE sessid = " . $N_REQ_ID . " AND (PLUIGR IS NULL OR PLUOMI IS NULL) AND PRD_PRDCD(+) = PLUIGR
                    ORDER BY pluomi");

        if ($recs) {
            foreach ($recs as $rec) {
//  	-- HEADER
                if ($r == 0) {
                    $linebuff = '';
                    $linebuff = $linebuff . str_pad('LIST PLU - PLU OMI NULL', 60, ' ', STR_PAD_LEFT) . chr(13) . chr(10);
                    $linebuff = $linebuff . chr(13) . chr(10);
                    $linebuff = $linebuff . str_pad($NPers, 59, ' ', STR_PAD_RIGHT) . str_pad('TANGGAL : ' . Carbon::now()->format('d/M/Y'), 31, ' ', STR_PAD_RIGHT) . ' JAM : ' . Carbon::now()->format('H:i:s') . chr(13) . chr(10);
                    $linebuff = $linebuff . str_pad($NCab, 59, ' ', STR_PAD_RIGHT) . 'PROGRAM : TRANSFER PLU OMI     HAL : ' . str_pad($hal, 4, '0', STR_PAD_LEFT) . chr(13) . chr(10);
                    $linebuff = $linebuff . str_pad(' = ', 104, ' = ', STR_PAD_LEFT) . chr(13) . chr(10);
                    $linebuff = $linebuff . '  NO PLU_OMI PLU_IGR DESKRIPSI                                                                   SATUAN' . chr(13) . chr(10);
                    $linebuff = $linebuff . str_pad(' - ', 104, ' - ', STR_PAD_LEFT) . chr(13) . chr(10);
//
                    $r = $r + 7;
                }
//  	-- BODY
                $rn = $rn + 1;
                $linebuff = $linebuff . str_pad($rn, 4, ' ', STR_PAD_RIGHT) . str_pad($rec->pluomi, 7, ' ', STR_PAD_RIGHT) . str_pad($rec->pluigr, 7, ' ', STR_PAD_RIGHT) . str_pad($rec->prd_deskripsipanjang, 75, ' ', STR_PAD_LEFT) . '     ' . str_pad($rec->prd_unit, 3, ' ', STR_PAD_RIGHT) . str_pad($rec->prd_frac, 3, ' ', STR_PAD_RIGHT) . chr(13) . chr(10);
                $r = $r + 1;
                $r2 = $r2 + 1;

//  	-- FOOTER --
                if ($hal % 2 == 0) {
                    if ($r == 48 || $r2 == $EOF) {
                        $linebuff = $linebuff . str_pad(' = ', 104, ' = ', STR_PAD_LEFT) . chr(13) . chr(10);
                        $hal = $hal + 1;
                        if ($r2 == $EOF) {
                            $linebuff = $linebuff . str_pad('  ' . $EOF . ' Item(s) Transferred ', 84, ' ', STR_PAD_RIGHT) . ' ** AKHIR LAPORAN ** ';
                        } else {
                            $linebuff = $linebuff . ' ** BERSAMBUNG KE HAL ' . str_pad($hal, 4, '0', STR_PAD_LEFT) . chr(13) . chr(10);
                        }
                        $r = 0;
                        fwrite($file, $linebuff);
                    }
                } else {
                    if ($r == 49 || $r2 == $EOF) {
                        $linebuff = $linebuff . str_pad(' = ', 104, ' = ', STR_PAD_LEFT) . chr(13) . chr(10);
                        $hal = $hal + 1;
                        if ($r2 == $EOF) {
                            $linebuff = $linebuff . str_pad('  ' . $EOF . ' Item(s) Transferred ', 84, ' ', STR_PAD_RIGHT) . ' ** AKHIR LAPORAN ** ';
                        } else {
                            $linebuff = $linebuff . ' ** BERSAMBUNG KE HAL ' . str_pad($hal, 4, '0', STR_PAD_LEFT) . chr(13) . chr(10);
                        }
                        $r = 0;
//  		            outputfile disini
                        fwrite($file, $linebuff);
                    }
                }
            }
        }
        fclose($file);


//  	STEP = 9;
//        DIBUKA!!!!
        DB::connection(Session::get('connection'))->table('TEMP_MGN')
            ->where('REQ_ID', $N_REQ_ID)
            ->delete();

    }

    public function downloadTxt(Request $request)
    {
        $filesAndPaths = $request->txt;
        $filesAndPaths = explode(',', $filesAndPaths);

        $zip_file = 'FileTxt.zip'; // Name of our archive to download

        $zip = new \ZipArchive();
        $zip->open(storage_path($zip_file), \ZipArchive::CREATE | \ZipArchive::OVERWRITE);

        foreach ($filesAndPaths as $file) {
            $relativeName = basename($file);
            $zip->addFile(storage_path($file), $relativeName);
        }
        $zip->close();

        return response()->download(storage_path($zip_file))->deleteFileAfterSend();
    }

    public function transferPLUCOmmitOrder()
    {
        set_time_limit(0);
        $err_txt = '';

        $filecmo = DB::connection(Session::get('connection'))
            ->select("select 'PLUCMOIGRIDM' || to_char(sysdate, 'yyMMdd') || '.' ||" . Session::get('kdigr') . " a from dual")[0]->a;

        $c = loginController::getConnectionProcedure();
        $sql = "BEGIN sp_downloadcmo('" . Session::get('kdigr') . "',:filecmo,:err_txt); END;";
        $s = oci_parse($c, $sql);

        oci_bind_by_name($s, ':filecmo', $filecmo, 200);
        oci_bind_by_name($s, ':err_txt', $err_txt, 200);
        oci_execute($s);


        if ($err_txt == '') {
            $sukses = 'true';
            $v_result = '';

            $sql = "BEGIN SP_TRF_CMO_PLU2(:filecmo,:sukses,:v_result); END;";
            $s = oci_parse($c, $sql);

            oci_bind_by_name($s, ':filecmo', $filecmo, 200);
            oci_bind_by_name($s, ':sukses', $sukses, 200);
            oci_bind_by_name($s, ':v_result', $v_result, 200);
            oci_execute($s);

            if ($sukses == 'false') {
                $message = 'CEK ' . $v_result;
                $status = 'error';
                return compact(['message', 'status']);
            } else {
                $message = 'Data PLU CMO Sudah Selesai di Transfer !!';
                $status = 'success';
                return compact(['message', 'status']);
            }
        } else {
            $message = $err_txt;
            $status = 'error';
            return compact(['message', 'status']);
        }


    }

}
