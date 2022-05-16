<?php

namespace App\Http\Controllers\BACKOFFICE\TRANSAKSI\PENERIMAAN;

use App\AllModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Carbon\Exceptions\Exception as ExceptionsException;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use PDF;
use Exception;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;
use ZipArchive;

class printBPBController extends Controller
{
    public function index()
    {
        return view('BACKOFFICE.TRANSAKSI.PENERIMAAN.printBPB');
    }

    // Signature
    public function save(Request $request)
    {
        $message = "";
        $status = "";
        $id = uniqid();
        try {
            $path = "signature_expedition/";
            if (!File::exists(storage_path($path))) {
                File::makeDirectory(storage_path($path), 0755, true, true);
            }
            $img = $this->dataURLtoImage($request->signed);
            $file = storage_path($path . $id . '.' . $img['image_type']);
            file_put_contents($file, $img['image_base64']);
            $message = "Signature Saved!";
            $status = "success";
        } catch (Exception $e) {
            $message = $e->getMessage();
            $status = "error";
        }
        Session::put('signer', $request->signedby);
        return response()->json(['message' => $message, 'status' => $status, 'data' => $id]);
    }

    public function dataURLtoImage($value)
    {
        $image_parts = explode(";base64,", $value);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);
        return compact(['image_base64', 'image_type']);
    }

    public function viewData(Request $request)
    {
        $startDate = date('Y-M-d', strtotime($request->startDate));
        $endDate = date('Y-M-d', strtotime($request->endDate));
        $type = $request->type;
        $checked = $request->checked;
        $typeTrn = $request->typeTrn;
        if ($type == 1) {
            $data = DB::connection(Session::get('connection'))->select("SELECT DISTINCT trbo_nodoc as nodoc, trbo_tgldoc as tgldoc
                                       FROM tbtr_backoffice
                                      WHERE trbo_typetrn = '$typeTrn'
                                        AND NVL (trbo_flagdoc, '0') = '$checked'
                                        AND trbo_tgldoc BETWEEN ('$startDate') AND ('$endDate')
                                        order by trbo_nodoc");
            return response()->json($data);
        } else {
            if ($checked == 0) {
                $data = DB::connection(Session::get('connection'))->select("SELECT DISTINCT trbo_nodoc as nodoc, trbo_tgldoc as tgldoc
                                           FROM tbtr_backoffice
                                          WHERE trbo_tgldoc BETWEEN ('$startDate') AND ('$endDate')
                                            AND trbo_typetrn = '$typeTrn'
                                            AND trbo_flagdoc != '*'
                                            order by trbo_nodoc");

                return response()->json($data);
            } else {
                $data = DB::connection(Session::get('connection'))->select("SELECT msth_nodoc as nodoc, msth_tgldoc as tgldoc
                                          FROM TBTR_MSTRAN_H
                                         WHERE msth_typetrn = '$typeTrn'
                                           AND NVL (msth_flagdoc, ' ') = '$checked'
                                           AND msth_tgldoc BETWEEN ('$startDate') AND ('$endDate')
                                           order by msth_nodoc");
                return response()->json($data);
            }
        }
    }

    public function kirimFtp(Request $request)
    {
        $date = $request->chosenDate;
        $msg = '';
        $ftp_server = config('ftp.ftp_server_sd6');
        $ftp_user_name = config('ftp.ftp_user_name_sd6');
        $ftp_user_pass = config('ftp.ftp_user_pass_sd6');
        $zipName = Session::get('kdigr') . '_' . date("Ymd", strtotime($date)) . '.ZIP';
        $zipAddress = '../storage/receipts/' . $zipName;
        try {
            $conn_id = ftp_connect($ftp_server);
            ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);
            $files = Storage::disk('receipts')->allFiles();
            if (count($files) > 0) {
                if (Storage::disk('receipts')->exists($zipName) == false) {
                    $zip = new ZipArchive;
                    if (true === ($zip->open($zipAddress, ZipArchive::CREATE | ZipArchive::OVERWRITE))) {
                        try {
                            foreach ($files as $file => $value) {
                                if (substr($value, -12, -4) == date("Ymd", strtotime($date))) {
                                    $filePath = '../storage/receipts/' . $value;
                                    // ftp_put($conn_id, '/opt/btbigr/' . $value, $filePath); --send file separately
                                    $zip->addFile($filePath, $value);
                                }
                            }
                            $zip->close();
                            ftp_put($conn_id, '/opt/btbigr/' . $zipName, $zipAddress);
                            //send to SD6
                        } catch (Exception $e) {
                            $msg = 'Tidak ada file pada tanggal ' . $date . '!';
                            return response()->json(['kode' => 0, 'message' => $msg]);
                        }
                    } else {
                        $msg = 'Proses kirim file gagal';
                        return response()->json(['kode' => 0, 'message' => $msg]);
                    }
                } else {
                    ftp_put($conn_id, '/opt/btbigr/' . $zipName, $zipAddress);
                    //send to SD6
                }

                $msg = 'File terkirim ke SD6';
                File::delete($zipAddress); //delete zip file from storage
                $this->deleteSigs(); //delete all ttd
                $this->deleteFiles(); //delete all files
            } else {
                $msg = 'Empty Record, nothing to transfer';
                return response()->json(['kode' => 2, 'message' => $msg]);
            }
        } catch (Exception $e) {
            $msg = 'Proses kirim file gagal';
            return response()->json(['kode' => 0, 'message' => $msg . $e]);
        }
        return response()->json(['kode' => 1, 'message' => $msg]);
    }

    public function cetakData(Request $request)
    {
        $document   = $request->document;
        $type       = $request->type;
        $reprint    = $request->checked;
        $size       = $request->size;
        $trnType    = $request->typeTrn;
        $is_list    = 0;
        $kodeigr    = Session::get('kdigr');
        $userid     = Session::get('usid');
        $lokasi     = 0;
        $counter    = 0;
        $v_print    = 0;
        $temp_lokasi = [];
        $temp_nota = [];
        $model  = new AllModel();
        $conn   = $model->connectionProcedure();

        if ($type == 1) {
            $v_print = $reprint;
            $is_list = 1;
        } else {
            if ($reprint == 0) {
                foreach ($document as $data) {
                    $updateData = $this->update_data($data, $kodeigr, $userid, $conn, $type, $trnType);
                    if ($updateData != null) {
                        if ($updateData['kode'] == 0) {
                            return response()->json($updateData);
                        }
                        $temp_nota[] = $updateData['nota'];
                    }
                    $updateData = $this->update_data2($kodeigr, $conn, $type);
                    $ct = DB::connection(Session::get('connection'))->select(
                        "SELECT nvl(count(1),0) as ct
						    from tbtr_backoffice, tbmaster_lokasi
						    where   trbo_nodoc              = '$data'
							and     lks_prdcd               = trbo_prdcd
							and     lks_kodeigr             = trbo_kodeigr
							and     substr(lks_koderak,1,1) = 'A'"
                    );
                    if (count($ct) > 0) {
                        array_push($temp_lokasi, [$data]);
                        $counter++;
                    }
                }
            } else {
                $temp_nota = $document;
            }
        }
        if ($counter > 0) {
            $this->print_lokasi($temp_lokasi, $type, $v_print);
            $lokasi = 1;
        }

        if ($document) {
            if ($type == 1 && $reprint == 0) {
                DB::connection(Session::get('connection'))->table('tbtr_backoffice')
                    ->whereIn('trbo_nodoc', $document)
                    ->update(['trbo_flagdoc' => '1']);
            } else if ($type == 2 && $reprint == 0) {
                DB::connection(Session::get('connection'))->table('tbtr_backoffice')
                    ->whereIn('trbo_nodoc', $document)
                    ->update(['trbo_flagdoc' => '*', 'trbo_recordid' => 2]);
            }

            $print_btb = $this->print_btb($document, $type, $v_print, $size);
        }
        return response()->json(['kode' => 1, 'message' => 'Create Report Success', 'data' => $print_btb, 'lokasi' => $lokasi, 'nota' => $temp_nota, 'list' => $is_list]);
    }

    //masih error di update barang baru
    public function SP_PKM_BPB($kodeigr, $sub_prdcd, $userId, $P_SUKSES, $P_ERROR)
    {
        $model  = new AllModel();
        $conn   = $model->connectionProcedure();
        $sysdatef = Carbon::now();
        $DIMENSI = 0;
        $MINORDER = 0;
        $PKMM = 0;
        $PKMT = 0;
        $LEADTIME = 0;
        $MIND = 0;
        $MPKM = 0;
        $N = 0;
        $AVGSPD = 0;
        $KSUP = '';
        $ADA = oci_parse($conn, "SELECT COUNT (1)
                                FROM tbmaster_kkpkm
                                WHERE pkm_kodeigr = '$kodeigr' 
                                AND pkm_prdcd = '$sub_prdcd'");
        oci_execute($ADA);
        $ADA_KEY = oci_fetch_array($ADA, OCI_ASSOC);
        $keys = array_keys($ADA_KEY);

        if ($ADA_KEY[$keys[0]] > 0) {
            $P_SUKSES = 'Y';
            return $ADA_KEY[$keys[0]];
        } else {
            $min_order =  oci_parse($conn, "SELECT PRD_MINORDER
                                FROM TBMASTER_PRODMAST,
                                    TBMASTER_KKPKM,
                                    TBMASTER_PRODCRM,
                                    TBMASTER_PKMPLUS
                                WHERE   PRD_KODEIGR     = '$kodeigr'
                                AND     PRD_PRDCD       = '$sub_prdcd'
                                AND     PKM_KODEIGR(+)  = '$kodeigr'
                                AND     PKM_PRDCD(+)    = '$sub_prdcd'
                                AND     PRC_KODEIGR(+)  = '$kodeigr'
                                AND     PRC_PLUIGR(+)   = '$sub_prdcd'
                                AND     PRC_GROUP(+)    = 'O'
                                AND     PKMP_KODEIGR(+) = '$kodeigr'
                                AND     PKMP_PRDCD(+)   = '$sub_prdcd'");

            oci_execute($min_order);
            $min_order_KEY = oci_fetch_array($min_order, OCI_ASSOC);
            $keys = array_keys($min_order_KEY);
            if ($keys > 0) {
                $MINORDER = $keys;
            } else {
                $isi_beli =  oci_parse($conn, "SELECT PRD_ISIBELI
                                FROM TBMASTER_PRODMAST,
                                    TBMASTER_KKPKM,
                                    TBMASTER_PRODCRM,
                                    TBMASTER_PKMPLUS
                                WHERE   PRD_KODEIGR     = '$kodeigr'
                                AND     PRD_PRDCD       = '$sub_prdcd'
                                AND     PKM_KODEIGR(+)  = '$kodeigr'
                                AND     PKM_PRDCD(+)    = '$sub_prdcd'
                                AND     PRC_KODEIGR(+)  = '$kodeigr'
                                AND     PRC_PLUIGR(+)   = '$sub_prdcd'
                                AND     PRC_GROUP(+)    = 'O'
                                AND     PKMP_KODEIGR(+) = '$kodeigr'
                                AND     PKMP_PRDCD(+)   = '$sub_prdcd'");
                oci_execute($isi_beli);
                $isi_beli_KEY = oci_fetch_array($isi_beli, OCI_ASSOC);
                $keys = array_keys($isi_beli_KEY);
                if ($keys > 0) {
                    $MINORDER = $keys;
                }
            }

            $sp_pkm_bpb = oci_parse($conn, "SELECT PRD_PRDCD,
                                    PRD_LASTCOST,
                                    PRD_KODETAG,
                                    PRD_KODECABANG,
                                    PRD_KATEGORITOKO,
                                    PRD_KODEDIVISI,
                                    PRD_KODEDEPARTEMENT,
                                    PRD_KODEKATEGORIBARANG,
                                    PRD_TGLDAFTAR,
                                    PRD_FLAGGUDANG
                                    FROM TBMASTER_PRODMAST,
                                        TBMASTER_KKPKM,
                                        TBMASTER_PRODCRM,
                                        TBMASTER_PKMPLUS
                                    WHERE   PRD_KODEIGR     = '$kodeigr'
                                    AND     PRD_PRDCD       = '$sub_prdcd'
                                    AND     PKM_KODEIGR(+)  = '$kodeigr'
                                    AND     PKM_PRDCD(+)    = '$sub_prdcd'
                                    AND     PRC_KODEIGR(+)  = '$kodeigr'
                                    AND     PRC_PLUIGR(+)   = '$sub_prdcd'
                                    AND     PRC_GROUP(+)    = 'O'
                                    AND     PKMP_KODEIGR(+) = '$kodeigr'
                                    AND     PKMP_PRDCD(+)   = '$sub_prdcd'");
            oci_execute($sp_pkm_bpb);
            $sp_pkm_bpb_KEY = oci_fetch_array($sp_pkm_bpb, OCI_ASSOC);
            foreach ($sp_pkm_bpb_KEY as $data => $value) {
                $ADA = oci_parse($conn, "SELECT COUNT (1)
                                FROM TBMASTER_LOKASI
                                WHERE LKS_KODEIGR = '$kodeigr' 
                                AND LKS_PRDCD = '$sub_prdcd'
                                AND (LKS_KODERAK NOT LIKE 'X%'
                                AND LKS_KODERAK NOT LIKE 'A%'
                                AND LKS_KODERAK NOT LIKE 'G%')
                                AND LKS_TIPERAK <> 'S'");
                oci_execute($ADA);
                $ADA_KEY = oci_fetch_array($ADA, OCI_ASSOC);
                $keys = array_keys($ADA_KEY);
                if ($ADA_KEY[$keys[0]] == 0) {
                    $DIMENSI = 0;
                } else {
                    $LKS_TIRKIRIKANAN = 0;
                    $LKS_TIRDEPANBELAKANG = 0;
                    $LKS_TIRATASBAWAH = 0;
                    $ADA = oci_parse($conn, "SELECT *
                                FROM TBMASTER_LOKASI
                                WHERE LKS_KODEIGR = '$kodeigr'
                                AND LKS_PRDCD = '$sub_prdcd'
                                AND (LKS_KODERAK NOT LIKE 'X%'
                                AND LKS_KODERAK NOT LIKE 'A%'
                                AND LKS_KODERAK NOT LIKE 'G%')
                                AND LKS_TIPERAK <> 'S'");
                    oci_execute($ADA);
                    $ADA_KEY = oci_fetch_array($ADA, OCI_ASSOC);
                    foreach ($ADA_KEY as $lks => $lksv) {
                        if ($lks == 'LKS_TIRKIRIKANAN') {
                            $LKS_TIRKIRIKANAN += $lksv;
                        }
                        if ($lks == 'LKS_TIRDEPANBELAKANG') {
                            $LKS_TIRDEPANBELAKANG += $lksv;
                        }
                        if ($lks == 'LKS_TIRATASBAWAH') {
                            $LKS_TIRATASBAWAH += $lksv;
                        }
                    }
                    $NILAI = $LKS_TIRKIRIKANAN * $LKS_TIRDEPANBELAKANG * $LKS_TIRATASBAWAH;
                    // $DIMENSI = DB::connection(Session::get('connection'))
                    //     ->select("SELECT SUM (NILAI)
                    //     FROM (SELECT LKS_PRDCD, (LKS_TIRKIRIKANAN * LKS_TIRDEPANBELAKANG * LKS_TIRATASBAWAH) NILAI
                    //     FROM TBMASTER_LOKASI
                    //     WHERE LKS_KODEIGR = $kodeigr 
                    //     AND LKS_PRDCD = $sub_prdcd
                    //     AND (LKS_KODERAK NOT LIKE 'X%'
                    //     AND LKS_KODERAK NOT LIKE 'A%'
                    //     AND LKS_KODERAK NOT LIKE 'G%')
                    //     AND LKS_TIPERAK <> 'S';
                    //     GROUP BY LKS_PRDCD");
                    $DIMENSI = $NILAI;
                }
                $PRD_FLAGGUDANG = '999'; //init code boongan
                if ($data == 'PRD_FLAGGUDANG') {
                    $PRD_FLAGGUDANG = $value;
                }
                $arr = array('Y', 'P');

                if (in_array($PRD_FLAGGUDANG, $arr)) {
                    $ADA = DB::connection(Session::get('connection'))
                        ->select("SELECT COUNT (1),
                    FROM TBMASTER_MINIMUMORDER
                    WHERE MIN_KODEIGR   = $kodeigr 
                    AND   MIN_PRDCD     = $sub_prdcd");
                    if ($ADA > 0) {
                        $MINORDER = DB::connection(Session::get('connection'))
                            ->select("SELECT MIN_MINORDER
                            FROM TBMASTER_MINIMUMORDER
                            WHERE MIN_KODEIGR   = $kodeigr 
                            AND   MIN_PRDCD     = $sub_prdcd");
                    }
                }
                $MINORDER = 0;
            }
            $arr = ['Y', 'P'];
            $MIND = $DIMENSI;
            if (in_array('N', $arr)) {
                $LEADTIME = 15;
            } else {
                $PRD_FLAGGUDANG = '999'; //init code boongan
                if ($data == 'PRD_FLAGGUDANG') {
                    $PRD_FLAGGUDANG = $value;
                }
                $ADA = DB::connection(Session::get('connection'))
                    ->select("SELECT COUNT (1),
                        IF ($PRD_FLAGGUDANG = 'N' IN ('Y','P'))
                        FROM (SELECT *
                        FROM (SELECT HGB_KODESUPPLIER
                        FROM TBMASTER_HARGABELI
                        WHERE     HGB_KODEIGR = P_MEMKODEIGR
                                AND HGB_PRDCD = P_PRDCD
                        ORDER BY HGB_TIPE)
                        WHERE ROWNUM = 1) A,
                        TBMASTER_SUPPLIER
                        WHERE     SUP_KODEIGR = $kodeigr
                        AND       SUP_KODESUPPLIER = HGB_KODESUPPLIER");
                if ($ADA == 0) {
                    $LEADTIME = 1;
                    $KSUP = '';
                } else {
                    $LEADTIME = DB::connection(Session::get('connection'))
                        ->select("SELECT SUP_JANGKAWAKTUKIRIMBARANG
                        FROM (SELECT *
                        FROM (SELECT HGB_KODESUPPLIER
                        FROM TBMASTER_HARGABELI
                        WHERE     HGB_KODEIGR = P_MEMKODEIGR
                                AND HGB_PRDCD = P_PRDCD
                        ORDER BY HGB_TIPE)
                        WHERE ROWNUM = 1) A,
                        TBMASTER_SUPPLIER
                        WHERE     SUP_KODEIGR = $kodeigr
                        AND       SUP_KODESUPPLIER = HGB_KODESUPPLIER");

                    $KSUP = DB::connection(Session::get('connection'))
                        ->select("SELECT SUP_KODESUPPLIER
                        FROM (SELECT *
                        FROM (SELECT HGB_KODESUPPLIER
                        FROM TBMASTER_HARGABELI
                        WHERE     HGB_KODEIGR = P_MEMKODEIGR
                                AND HGB_PRDCD = P_PRDCD
                        ORDER BY HGB_TIPE)
                        WHERE ROWNUM = 1) A,
                        TBMASTER_SUPPLIER
                        WHERE     SUP_KODEIGR = $kodeigr
                        AND       SUP_KODESUPPLIER = HGB_KODESUPPLIER");
                }
                $N = 2;
            }
            $AVGSPD = 0;
            $PKMM   = $MIND + $MINORDER;
            $MPKM   = 0;

            if ($PKMM <= ($MIND + $MINORDER) || (($PKMM > $MIND) && ($PKMM < ($MIND + $MINORDER)))) {
                $MPKM = $MIND + $MINORDER;
            } else if (($PKMM > $MIND) && ($PKMM > ($MIND + $MINORDER))) {
                $MPKM = $PKMM;
            }

            $PKMT = $MPKM + $data->PKMP_QTYMINOR;

            if ($data->PKM_PRDCD == '1234567') {
                DB::connection(Session::get('connection'))->table('TBMASTER_KKPKM')->insert([
                    "PKM_KODEIGR" => $kodeigr,
                    "PKM_KODEDIVISI" => $data->prd_kodedivisi,
                    "PKM_KODEDEPARTEMENT" => $data->prd_kodedepartement,
                    "PKM_PERIODEPROSES" => Carbon::now()->format('My'),
                    "PKM_KODEKATEGORIBARANG" => $data->prd_kodekategoribarang,
                    "PKM_PRDCD" => $data->prd_prdcd,
                    "PKM_KODESUPPLIER" => $KSUP,
                    "PKM_MINDISPLAY" => $MIND,
                    "PKM_MINORDER" => $MINORDER,
                    "PKM_LEADTIME" => $LEADTIME,
                    "PKM_KOEFISIEN" => $N,
                    "PKM_PKM" => $PKMM,
                    "PKM_PKMT" => $PKMT,
                    "PKM_MPKM" => $MPKM,
                    "PKM_CREATE_BY" => $userId,
                    "PKM_CREATE_DT" => $sysdatef,
                ]);
            } else {
                DB::connection(Session::get('connection'))->table('TBMASTER_KKPKM')
                    ->where('PKM_KODEIGR', $kodeigr)
                    ->where('PKM_PRDCD', $sub_prdcd)
                    ->update([
                        'PKM_PERIODEPROSES' => Carbon::now()->format('My'), 'PKM_KODESUPPLIER' => $KSUP,
                        'PKM_MINDISPLAY' => $MIND,
                        'PKM_MINORDER' => $MINORDER,
                        'PKM_LEADTIME' => $LEADTIME,
                        'PKM_KOEFISIEN' => $N,
                        'PKM_PKM' => $PKMM,
                        'PKM_PKMT' => $PKMT,
                        'PKM_MPKM' => $MPKM,
                        'PKM_MODIFY_BY' => $userId,
                        'PKM_MODIFY_DT' => $sysdatef
                    ]);

                $gondola = DB::connection(Session::get('connection'))->table('TBTR_PKMGONDOLA')
                    ->where('PKMG_KODEIGR', $kodeigr)
                    ->where('PKMG_PRDCD', $sub_prdcd)
                    ->get('PKMG_NILAIGONDOLA');

                DB::connection(Session::get('connection'))->table('TBTR_PKMGONDOLA')
                    ->where('PKMG_KODEIGR', $kodeigr)
                    ->where('PKMG_PRDCD', $sub_prdcd)
                    ->update([
                        'PKMG_NILAIPKMG' => $gondola + $PKMT
                    ]);
            }
            $P_SUKSES = 'Y';
            return response()->json(['kode' => $P_SUKSES, 'msg' => 'Sukses']);
        }
    }

    public function update_data($noDoc, $kodeigr, $userId, $conn, $type, $trnType)
    {
        $CKODE = '';
        $SUPCO = '';
        $NOPO = '';
        $NOFAKTUR = '';
        $PKP = '';
        $NACOST = 0;
        $NOLDACOSTX = 0;
        $NOLDACOST = 0;
        $NDISC4 = 0;
        $NACOSTX = 0;
        $TEMP = 0;
        $QTY_O = 0;
        $QTY_OK = 0;
        $ORDER1 = 0;
        $NLCOST = 0;
        $TGL = Carbon::now()->format('Y-m-d');
        $TGLPO = Carbon::now()->format('Y-m-d');
        $TGLFAKTUR = Carbon::now()->format('Y-m-d');
        $CKSJ = false;
        $TRUET = false;
        $SUPTOP = 0;
        $UPDPLU = false;
        $P_SUKSES = '';
        $P_ERROR = '';
        $dummyvar = 0;
        $SUPCO = null;
        $sysdatef = Carbon::now()->format('Y-m-d H:i:s');
        $btb_date = Carbon::now()->format('y');
        $no_btb = '';
        if ($trnType == 'B') {
            $query = oci_parse($conn, "BEGIN :no_btb := F_IGR_GET_NOMOR (:IGR, 'BPB', 'Nomor BPB', '$btb_date' || '0' || '$btb_date', 5, TRUE); END;");
            oci_bind_by_name($query, ':IGR', $kodeigr);
            oci_bind_by_name($query, ':no_btb', $result, 32);
            oci_execute($query);
            $no_btb = $result;
        } else {
            $query = oci_parse($conn, "BEGIN :no_btb := F_IGR_GET_NOMOR (:IGR, 'BPL', 'Nomor BPB Lain-Lain', '$btb_date' || '1' || '$btb_date', 5, TRUE); END;");
            oci_bind_by_name($query, ':IGR', $kodeigr);
            oci_bind_by_name($query, ':no_btb', $result, 32);
            oci_execute($query);
            $no_btb = $result;
        }
        $record = DB::connection(Session::get('connection'))->select("SELECT 
                    TRBO_PRDCD, TRBO_TYPETRN, TRBO_DIS4CR, ST_PRDCD, PRD_PRDCD, PRD_UNIT,
                    TRBO_DIS4JR, TRBO_DIS4RR, PRD_AVGCOST, ST_AVGCOST, PRD_FRAC, ST_SALDOAKHIR,
                    TRBO_GROSS, TRBO_DISCRPH, TRBO_PPNBMRPH, TRBO_PPNBTLRPH, NVL(TRBO_QTY, 0) TRBO_QTY,
                    TRBO_QTYBONUS1, SUP_TOP, TRBO_NOPO, TRBO_FURGNT, TRBO_KODEIGR, TRBO_TGLPO,
                    TRBO_NODOC, TRBO_QTYBONUS2, TRBO_NOFAKTUR, TRBO_HRGSATUAN, PRD_LASTCOST,
                    TRBO_TGLFAKTUR, TRBO_PERSENDISC1, TRBO_KODESUPPLIER, SUP_KODESUPPLIER,
                    SUP_PKP, TRBO_ISTYPE, TRBO_PERSENDISC2, TRBO_PERSENDISC2II,
                    TRBO_PERSENDISC2III, TRBO_SEQNO, TRBO_PERSENDISC3, PRD_KODEDIVISI,
                    TRBO_PERSENDISC4, PRD_KODEDEPARTEMENT, TRBO_RPHDISC1, TPOD_SATUANBELI,
                    TPOD_ISIBELI, PRD_KODEKATEGORIBARANG,TRBO_RPHDISC2, TRBO_RPHDISC2II,
                    TRBO_RPHDISC2III, PRD_FLAGBKP1, TRBO_RPHDISC3, PRD_FLAGBKP2, TRBO_RPHDISC4,
                    TRBO_LOC, TRBO_FLAGDISC1, TRBO_FLAGDISC2, TRBO_FLAGDISC3, TRBO_FLAGDISC4,
                    TRBO_DIS4CP, TRBO_DIS4RP, TRBO_DIS4JP, TRBO_PPNRPH, TRBO_KETERANGAN,
                    PRD_KODETAG, TPOH_NOPO, TPOH_TOP, TPOH_FLAGALOKASI
                    FROM TBTR_BACKOFFICE AA,
                         TBMASTER_PRODMAST BB,
                         TBMASTER_SUPPLIER CC,
                         TBMASTER_STOCK DD,
                         TBMASTER_LOKASI EE,
                         TBTR_PO_D FF,
                         TBTR_PO_H GG,
                         tbmaster_stock_cab_anak hh
                    WHERE     AA.TRBO_NODOC = '$noDoc'
                    AND (NVL (TRBO_QTY, 0)
                        + NVL (TRBO_QTYBONUS1, 0)
                        + NVL (TRBO_QTYBONUS2, 0)) <> 0
                    AND BB.PRD_PRDCD = AA.TRBO_PRDCD
                    AND BB.PRD_KODEIGR = '$kodeigr'
                    AND CC.SUP_KODESUPPLIER(+) = AA.TRBO_KODESUPPLIER
                    AND CC.SUP_KODEIGR(+) = AA.TRBO_KODEIGR
                    AND DD.ST_PRDCD(+) = AA.TRBO_PRDCD
                    AND DD.ST_KODEIGR(+) = AA.TRBO_KODEIGR
                    AND DD.ST_LOKASI(+) = '01'
                    AND EE.LKS_PRDCD(+) = AA.TRBO_PRDCD
                    AND EE.LKS_KODEIGR(+) = AA.TRBO_KODEIGR
                    AND SUBSTR (EE.LKS_KODERAK(+), 1, 1) = 'A'
                    AND FF.TPOD_PRDCD(+) = AA.TRBO_PRDCD
                    AND FF.TPOD_KODEIGR(+) = AA.TRBO_KODEIGR
                    AND FF.TPOD_NOPO(+) = AA.TRBO_NOPO
                    AND GG.TPOH_KODEIGR(+) = '$kodeigr'
                    AND GG.TPOH_NOPO(+) = AA.TRBO_NOPO
                    AND NVL (GG.TPOH_RECORDID, '0') <> '1'
                    AND HH.STA_PRDCD(+) = AA.TRBO_PRDCD
                    AND HH.STA_KODEIGR(+) = AA.TRBO_KODEIGR
                    AND HH.STA_LOKASI(+) = '01'
                    ORDER BY AA.TRBO_PRDCD");
        foreach ($record as $data) {
            $UPDPLU = false;
            $prd_code = '';
            $trnType = $data->trbo_typetrn;
            $NDISC4 =  $data->trbo_dis4cr +  $data->trbo_dis4jr +  $data->trbo_dis4rr;
            if ($data->st_prdcd != null || $data->st_prdcd != 0) {
                $prd_code = $data->st_prdcd;
            } else if ($data->prd_prdcd != null || $data->prd_prdcd != 0) {
                $prd_code = $data->prd_prdcd;
            } else {
                $prd_code = 0;
            }
            if ($data->st_prdcd == null) {
                $UPDPLU = true;

                DB::connection(Session::get('connection'))->table('TBMASTER_STOCK')->insert([
                    "ST_KODEIGR" => $data->trbo_kodeigr,
                    "ST_PRDCD" => $prd_code,
                    "ST_LOKASI" => '01'
                ]);
            }
            if ($data->prd_lastcost == 0 && $data->prd_avgcost == 0) {
                $UPDPLU = true;
            }
            if (substr($prd_code, -1) == '1' || strtoupper($data->prd_unit) == 'KG') {
                $NOLDACOST  = $data->prd_avgcost;
                $NOLDACOSTX = $data->st_avgcost;
            } else {
                $NOLDACOST = $data->prd_avgcost / $data->prd_frac;
                $NOLDACOSTX = $data->st_avgcost;
            }

            if (strtoupper($data->prd_unit) != 'KG') {
                if ($data->st_saldoakhir > 0) {
                    $NACOST = (($data->st_saldoakhir * $NOLDACOST) + ($data->trbo_gross - $data->trbo_discrph + $NDISC4 + $data->trbo_ppnbmrph + $data->trbo_ppnbtlrph)) / ($data->st_saldoakhir + ($data->trbo_qty + $data->trbo_qtybonus1));
                    $NACOSTX = (($data->st_saldoakhir * $NOLDACOSTX) + ($data->trbo_gross - $data->trbo_discrph + $NDISC4 + $data->trbo_ppnbmrph + $data->trbo_ppnbtlrph)) / ($data->st_saldoakhir + ($data->trbo_qty + $data->trbo_qtybonus1));
                } else {
                    $NACOST = (($data->trbo_gross - $data->trbo_discrph + $NDISC4 + $data->trbo_ppnbmrph + $data->trbo_ppnbtlrph) / ($data->trbo_qty + $data->trbo_qtybonus1));
                    $NACOSTX = $NACOST;
                }

                if ($NACOST <= 0) {
                    $NACOST = (($data->trbo_gross - $data->trbo_discrph + $NDISC4 + $data->trbo_ppnbmrph + $data->trbo_ppnbtlrph) / ($data->trbo_qty + $data->trbo_qtybonus1));
                }
            } else { //kilo-an
                if ($data->st_saldoakhir > 0) {
                    $NACOST = (($data->st_saldoakhir / 1000 * $NOLDACOST) + ($data->trbo_gross - $data->trbo_discrph + $NDISC4 + $data->trbo_ppnbmrph + $data->trbo_ppnbtlrph)) / (($data->st_saldoakhir + ($data->trbo_qty + $data->trbo_qtybonus1)) / 1000);
                    $NACOSTX = (($data->st_saldoakhir / 1000 * $NOLDACOSTX) + ($data->trbo_gross - $data->trbo_discrph + $NDISC4 + $data->trbo_ppnbmrph + $data->trbo_ppnbtlrp)) / (($data->st_saldoakhir + ($data->trbo_qty + $data->trbo_qtybonus1)) / 1000);
                } else {
                    $NACOST = (($data->trbo_gross - $data->trbo_discrph + $NDISC4 + $data->trbo_ppnbmrph + $data->trbo_ppnbtlrph) / (($data->trbo_qty + $data->trbo_qtybonus1) / 1000));
                    $NACOSTX = $NACOST;
                }

                if ($NACOST <= 0) {
                    $NACOST = (($data->trbo_gross - $data->trbo_discrph + $NDISC4 + $data->trbo_ppnbmrph + $data->trbo_ppnbtlrph) / (($data->trbo_qty + $data->trbo_qtybonus1) / 1000));
                }

                if ($NACOSTX <= 0) {
                    $NACOSTX = (($data->trbo_gross - $data->trbo_discrph + $NDISC4 + $data->trbo_ppnbmrph + $data->trbo_ppnbtlrph) / (($data->trbo_qty + $data->trbo_qtybonus1) / 1000));
                }
            }

            if ($data->tpoh_nopo == '12345678') {
                $SUPTOP = $data->sup_top;
            } else {
                $SUPTOP = $data->tpoh_top;
            }
            $TODATE = Carbon::now();
            $TODATEF = $TODATE->format('d/m/Y');
            try {
                $sub_prdcd = substr($data->trbo_prdcd, 1, 6);
            } catch (Exception $e) {
                $sub_prdcd = 0;
            }
            //seharusnya dipake buat sp_pkm_bpb, tapi knp harus di substr
            if ($data->prd_lastcost == 0) {
                if ($data->prd_avgcost != 0) {
                    return ['kode' => 0, 'message' => "PLU " . $data->prd_prdcd . " Avg Cost <> 0, Lakukan Update PKM?"];
                    $query = oci_parse($conn, "BEGIN SP_PKM_BPB (:IGR, :PRDCD, :USID, :PS, :PE); END;");
                    oci_bind_by_name($query, ':IGR', $kodeigr);
                    oci_bind_by_name($query, ':PRDCD', $sub_prdcd);
                    oci_bind_by_name($query, ':USID', $userId);
                    oci_bind_by_name($query, ':PS', $P_SUKSES);
                    oci_bind_by_name($query, ':PE', $P_ERROR);
                    oci_execute($query);
                    // $this->SP_PKM_BPB($kodeigr, $data->trbo_prdcd, $userId, $P_SUKSES, $P_ERROR);
                    DB::connection(Session::get('connection'))->table('TBMASTER_BARANGBARU')
                        ->where('PLN_PRDCD', $data->trbo_prdcd)
                        ->where('PLN_TGLBPB', $TODATEF)
                        ->update(['PLN_TGLBPB' => $sysdatef]);
                }
            } else {
                $query = oci_parse($conn, "BEGIN SP_PKM_BPB (:IGR, :PRDCD, :USID, :PS, :PE); END;");
                oci_bind_by_name($query, ':IGR', $kodeigr);
                oci_bind_by_name($query, ':PRDCD', $sub_prdcd);
                oci_bind_by_name($query, ':USID', $userId);
                oci_bind_by_name($query, ':PS', $P_SUKSES);
                oci_bind_by_name($query, ':PE', $P_ERROR);
                oci_execute($query);
                // $this->SP_PKM_BPB($kodeigr, $data->trbo_prdcd, $userId, $P_SUKSES, $P_ERROR);
                DB::connection(Session::get('connection'))->table('TBMASTER_BARANGBARU')
                    ->where('PLN_PRDCD', $data->trbo_prdcd)
                    ->where('PLN_TGLBPB', $TODATEF)
                    ->update(['PLN_TGLBPB' => $sysdatef]);
            }

            $trbo_nopo = '';
            $unit = '';
            $frac = '';
            $sum = 0;
            if ($data->trbo_nopo == null || $data->trbo_nopo == '') {
                $trbo_nopo = 'AA1';
                $unit = $data->prd_unit;
                $frac = $data->prd_frac;
            } else {
                $trbo_nopo = $data->trbo_nopo;
                $unit = $data->tpod_satuanbeli;
                $frac = $data->tpod_isibeli;
            }

            if (strtoupper($data->prd_unit) != 'KG') {
                $sum = 1;
            } else {
                $sum = 1000;
            }
            DB::connection(Session::get('connection'))->table('TBTR_MSTRAN_D')->insert([
                "MSTD_TYPETRN" => $data->trbo_typetrn,
                "MSTD_NODOC" => $no_btb,
                "MSTD_TGLDOC" => $sysdatef,
                "MSTD_NOPO" => $data->trbo_nopo,
                "MSTD_TGLPO" => $data->trbo_tglpo,
                "MSTD_NOFAKTUR" => $data->trbo_nofaktur,
                "MSTD_TGLFAKTUR" => $data->trbo_tglfaktur,
                "MSTD_ISTYPE" => $data->trbo_istype,
                "MSTD_KODESUPPLIER" => $data->sup_kodesupplier,
                "MSTD_PKP" => $data->sup_pkp,
                "MSTD_KODEIGR" => $data->trbo_kodeigr,
                "MSTD_SEQNO" => $data->trbo_seqno,
                "MSTD_PRDCD" => $data->trbo_prdcd,
                "MSTD_KODEDIVISI" => $data->prd_kodedivisi,
                "MSTD_KODEDEPARTEMENT" => $data->prd_kodedepartement,
                "MSTD_KODEKATEGORIBRG" => $data->prd_kodekategoribarang,
                "MSTD_BKP" => $data->prd_flagbkp1,
                "MSTD_FOBKP" => $data->prd_flagbkp2,
                "MSTD_UNIT" => $unit,
                "MSTD_FRAC" => $frac,
                "MSTD_LOC" => $data->trbo_loc,
                "MSTD_QTY" => $data->trbo_qty,
                "MSTD_QTYBONUS1" => $data->trbo_qtybonus1,
                "MSTD_QTYBONUS2" => $data->trbo_qtybonus2,
                "MSTD_HRGSATUAN" => $data->trbo_hrgsatuan,
                "MSTD_PERSENDISC1" => $data->trbo_persendisc1,
                "MSTD_PERSENDISC2" => $data->trbo_persendisc2,
                "MSTD_PERSENDISC2II" => $data->trbo_persendisc2ii,
                "MSTD_PERSENDISC2III" => $data->trbo_persendisc2iii,
                "MSTD_PERSENDISC3" => $data->trbo_persendisc3,
                "MSTD_PERSENDISC4" => $data->trbo_persendisc4,
                "MSTD_RPHDISC1" => $data->trbo_rphdisc1,
                "MSTD_RPHDISC2" => $data->trbo_rphdisc2,
                "MSTD_RPHDISC2II" => $data->trbo_rphdisc2ii,
                "MSTD_RPHDISC2III" => $data->trbo_rphdisc2iii,
                "MSTD_RPHDISC3" => $data->trbo_rphdisc3,
                "MSTD_RPHDISC4" => $data->trbo_rphdisc4,
                "MSTD_FLAGDISC1" => $data->trbo_flagdisc1,
                "MSTD_FLAGDISC2" => $data->trbo_flagdisc2,
                "MSTD_FLAGDISC3" => $data->trbo_flagdisc3,
                "MSTD_FLAGDISC4" => $data->trbo_flagdisc4,
                "MSTD_DIS4CP" => $data->trbo_dis4cp,
                "MSTD_DIS4CR" => $data->trbo_dis4cr,
                "MSTD_DIS4RP" => $data->trbo_dis4rp,
                "MSTD_DIS4RR" => $data->trbo_dis4rr,
                "MSTD_DIS4JP" => $data->trbo_dis4jp,
                "MSTD_DIS4JR" => $data->trbo_dis4jr,
                "MSTD_GROSS" => $data->trbo_gross,
                "MSTD_DISCRPH" => $data->trbo_discrph,
                "MSTD_PPNRPH" => $data->trbo_ppnrph,
                "MSTD_PPNBMRPH" => $data->trbo_ppnbmrph,
                "MSTD_PPNBTLRPH" => $data->trbo_ppnbtlrph,
                "MSTD_AVGCOST" => $NACOSTX * $frac / $sum,
                "MSTD_OCOST" => $NOLDACOSTX * $frac / $sum,
                "MSTD_POSQTY" => $data->st_saldoakhir,
                "MSTD_KETERANGAN" => $data->trbo_keterangan,
                "MSTD_KODETAG" => $data->prd_kodetag,
                "MSTD_FURGNT" => $data->trbo_furgnt,
                "MSTD_CREATE_BY" => $userId,
                "MSTD_CREATE_DT" => $sysdatef,
                "MSTD_CTERM" => $data->sup_top
            ]);
            $CKSJ == FALSE;
            if ($trnType == 'B') {
                if ($data->trbo_furgnt == '3') {
                    $record2 = DB::connection(Session::get('connection'))->select("SELECT *
                    FROM TBTR_PO_D,
                         TBTR_PB_D,
                    WHERE   TPOD_NOPO   = '$data->trbo_nopo'
                    AND     TPOD_PRDCD  = '$data->trbo_prdcd'
                    AND     PBD_NOPO    = '$data->tpod_nopo'
                    AND     PBD_PRDCD   = '$data->tpod_prdcd'");

                    foreach ($record2 as $data2) {
                        $pbcabg = DB::connection(Session::get('connection'))->select("SELECT *
                        FROM TBTR_PBCABANG_GUDANGPUSAT
                        WHERE   PBC_NOPBGUDANGPUSAT   = '$data2->pbd_nopb'
                        AND     PBC_PRDCD  = '$data2->pbd_prdcd'");
                        foreach ($pbcabg as $datapbc) {
                            if ($datapbc->pbc_recordid == '1' || $datapbc->pbc_recordid == '3') {
                                if ($datapbc->pbc_recordid == '3') {
                                    if ($datapbc->pbc_qtypb - $datapbc->pbc_qtybbp == 0) {
                                        return false;
                                    }
                                }
                                if ($datapbc->pbc_kodecabang == '03') {
                                    $CKODE = '1';
                                } else if ($datapbc->pbc_kodecabang == '06') {
                                    $CKODE = '2';
                                } else if ($datapbc->pbc_kodecabang == '04') {
                                    $CKODE = '3';
                                } else if ($datapbc->pbc_kodecabang == '01') {
                                    $CKODE = '4';
                                } else if ($datapbc->pbc_kodecabang == '02') {
                                    $CKODE = '5';
                                } else {
                                    $CKODE = '6';
                                }

                                $recordtemp = DB::connection(Session::get('connection'))->select("SELECT COUNT(1)
                                FROM TBTR_LISTPACKING
                                WHERE   PCL_RECORDID    IS NULL
                                AND     PCL_KODECABANG  = '$datapbc->pbc_kodecabang'
                                AND     PCL_NOREFERENSI = '$datapbc->pbc_nopbcabang'
                                AND     PCL_PRDCD       = '$data->trbo_prdcd'");

                                if (count($recordtemp) == 0) {
                                    DB::connection(Session::get('connection'))->table('TBTR_LISTPACKING')->insert([
                                        "PCL_KODEIGR" => $kodeigr,
                                        "PCL_RECORDID" => null,
                                        "PCL_KODECABANG" => $datapbc->pbc_kodecabang,
                                        "PCL_NOREFERENSI" => $datapbc->pbc_nopbcabang,
                                        "PCL_NOREFERENSI1" => $data->trbo_nodoc,
                                        "PCL_PRDCD" => $data->trbo_prdcd
                                    ]);
                                }

                                if ($datapbc->pbc_recordid == '3') {
                                    $QTY_O = round((($datapbc->pbc_qtypb - $datapbc->pbc_qtybbp) / $data->prd_frac), 0);

                                    $QTY_OK = ($datapbc->pbc_qtypb - $datapbc->pbc_qtybbp) - (round(($datapbc->pbc_qtypb - $datapbc->pbc_qtybbp) / $data->prd_frac, 0)) * $data->prd_frac;
                                } else {
                                    $QTY_O = round($datapbc->pbc_qtypb / $data->prd_frac, 0);

                                    $QTY_OK = $datapbc->pbc_qtypb - round(($datapbc->pbc_qtypb / $data->prd_frac) * $data->prd_frac, 0);
                                }
                                DB::connection(Session::get('connection'))->table('TBTR_LISTPACKING')
                                    ->where('PCL_RECORDID', null)
                                    ->where('PCL_KODECABANG', $datapbc->pbc_kodecabang)
                                    ->where('PCL_NOREFERENSI', $datapbc->pbc_nopbcabang)
                                    ->where('PCL_PRDCD', $data->trbo_prdcd)
                                    ->update([
                                        'PCL_KODE' => $CKODE, 'PCL_TGLREFERENSI' => $datapbc->pbc_tglpbcabang,
                                        'PCL_NODOKUMEN' => $no_btb || $datapbc->pbc_kodecabang, 'PCL_TGLDOKUMEN' => $sysdatef,
                                        'PCL_QTY_O' => $QTY_O, 'PCL_QTY_OK' => $QTY_OK,
                                        'PCL_QTYBONUS1' => $data->trbo_qtybonus1, 'PCL_QTYBONUS2' => $data->trbo_qtybonus2,
                                        'PCL_HRG' => $data->trbo_hrgsatuan, 'PCL_DISCPERSEN1' => $data->trbo_persendisc1,
                                        'PCL_DISCPERSEN2' => $data->trbo_persendisc2, 'PCL_DISCPERSEN3' => $data->trbo_persendisc3,
                                        'PCL_DISCPERSEN4' => $data->trbo_persendisc4, 'PCL_DISCRPH1' => $data->trbo_rphdisc1,
                                        'PCL_DISCRPH2' => $data->trbo_rphdisc2, 'PCL_DISCRPH3' => $data->trbo_rphdisc3,
                                        'PCL_DISCRPH4' => $data->trbo_rphdisc4, 'PCL_FLAGDISC1' => $data->trbo_flagdisc1,
                                        'PCL_FLAGDISC2' => $data->trbo_flagdisc2, 'PCL_FLAGDISC3' => $data->trbo_flagdisc3,
                                        'PCL_FLAGDISC4' => $data->trbo_flagdisc4, 'PCL_DIS4CP' => $data->trbo_dis4cp,
                                        'PCL_DIS4CR' => $data->trbo_dis4cr, 'PCL_DIS4RP' => $data->trbo_dis4rp,
                                        'PCL_DIS4RR' => $data->trbo_dis4rr, 'PCL_DIS4JP' => $data->trbo_dis4jp,
                                        'PCL_DIS4JR' => $data->trbo_dis4jr, 'PCL_NILAI' => $data->trbo_gross,
                                        'PCL_DISCRPH' => $data->rebo_discrph, 'PCL_PPNRPH' => $data->trbo_ppnrph,
                                        'PCL_PPNBMRPH' => $data->trbo_ppnbmrph, 'PCL_PPNBTLRPH' => $data->trbo_ppnbtlrph,
                                        'PCL_AVGCOST' => ($NACOSTX * $data->trbo_frac) / $sum, 'PCL_KETERANGAN' => 'PACKLIST OTOMATIS BPB GMS',
                                        'PCL_CREATE_DT' => $sysdatef, 'PCL_CREATE_BY' => $userId,
                                        'PCL_FURGNT' => $data->trbo_furgnt
                                    ]);
                            }
                        }
                        $TRUET = true;
                        $pbcabg2 = DB::connection(Session::get('connection'))->select("SELECT *
                                FROM TBTR_PBCABANG_GUDANGPUSAT
                                WHERE   PBC_NOPBGUDANGPUSAT    = $data2->pbd_nopb
                                AND     PBC_PRDCD  = '$data2->pbd_prdcd'
                                AND     PBC_KODECABANG = '$kodeigr'");
                        foreach ($pbcabg2 as $datapbc2) {
                            if ($datapbc2->pbc_recordid == '3' && ($datapbc2->pbc_qtypb - $datapbc2->pbc_qtybbp == 0)) {
                                $TRUET = false;
                            }
                            if ($TRUET == true) {
                                $TEMP = DB::connection(Session::get('connection'))->select("SELECT COUNT(1)
                                FROM TBTR_LISTPACKING
                                WHERE   PCL_RECORDID IS NULL
                                AND     PCL_KODECABANG  = '$kodeigr'
                                AND     PCL_NOREFERENSI = '$datapbc2->pbc_nopbcabang'
                                AND     PCL_PRDCD = '$datapbc2->pbc_prdcd'");

                                if (count($TEMP) == 0) {
                                    $record3 = DB::connection(Session::get('connection'))->select("SELECT *
                                    FROM TBTR_PBCABANG_GUDANGPUSAT
                                    WHERE   PBC_NOPBGUDANGPUSAT = $data2->pbd_nopb
                                    AND     PBC_PRDCD  = '$data2->pbd_prdcd'");

                                    foreach ($record3 as $data3) {
                                        if ($datapbc2->pbc_recordid == '1' || $datapbc2->pbc_recordid == '3') {
                                            $ORDER1 = $ORDER1 + $datapbc2->pbc_qtypb;
                                        }
                                    }

                                    if ($ORDER1 < $data->trbo_qty) {
                                        $CKODE = '6';
                                        $TEMP = DB::connection(Session::get('connection'))->select("SELECT COUNT(1)
                                        INTO $TEMP
                                        FROM TBTR_LISTPACKING
                                        WHERE   PCL_RECORDID IS NULL
                                        AND     PCL_KODECABANG  = '$kodeigr'
                                        AND     PCL_NOREFERENSI  = '$datapbc2->pbc_nopbcabang'
                                        AND     PCL_PRDCD  = '$datapbc2->pbc_prdcd'");
                                        if (count($TEMP) == 0) {
                                            if (count($TEMP) == 0) {
                                                DB::connection(Session::get('connection'))->table('TBTR_LISTPACKING')->insert([
                                                    "PCL_KODEIGR" => $kodeigr,
                                                    "PCL_RECORDID" => null,
                                                    "PCL_KODECABANG" => $datapbc2->pbc_kodecabang,
                                                    "PCL_NOREFERENSI" => $datapbc2->pbc_nopbcabang,
                                                    "PCL_NOREFERENSI1" => $data->trbo_nodoc,
                                                    "PCL_PRDCD" => $data->trbo_prdcd
                                                ]);
                                            }
                                            DB::connection(Session::get('connection'))->table('TBTR_LISTPACKING')
                                                ->where('PCL_RECORDID', null)
                                                ->where('PCL_KODECABANG', $kodeigr)
                                                ->where('PCL_NOREFERENSI', $datapbc2->pbc_nopbcabang)
                                                ->where('PCL_PRDCD', $datapbc2->pbc_prdcd)
                                                ->update([
                                                    'PCL_KODE' => $CKODE, 'PCL_TGLREFERENSI' => $datapbc2->pbc_tglpbcabang,
                                                    'PCL_NODOKUMEN' => $no_btb || $datapbc2->pbc_kodecabang, 'PCL_TGLDOKUMEN' => $sysdatef,
                                                    'PCL_QTY_O' => $QTY_O, 'PCL_QTY_OK' => $QTY_OK,
                                                    'PCL_QTYBONUS1' => $data->trbo_qtybonus1, 'PCL_QTYBONUS2' => $data->trbo_qtybonus2,
                                                    'PCL_HRG' => $data->trbo_hrgsatuan, 'PCL_DISCPERSEN1' => $data->trbo_persendisc1,
                                                    'PCL_DISCPERSEN2' => $data->trbo_persendisc2, 'PCL_DISCPERSEN3' => $data->trbo_persendisc3,
                                                    'PCL_DISCPERSEN4' => $data->trbo_persendisc4, 'PCL_DISCRPH1' => $data->trbo_rphdisc1,
                                                    'PCL_DISCRPH2' => $data->trbo_rphdisc2, 'PCL_DISCRPH3' => $data->trbo_rphdisc3,
                                                    'PCL_DISCRPH4' => $data->trbo_rphdisc4, 'PCL_FLAGDISC1' => $data->trbo_flagdisc1,
                                                    'PCL_FLAGDISC2' => $data->trbo_flagdisc2, 'PCL_FLAGDISC3' => $data->trbo_flagdisc3,
                                                    'PCL_FLAGDISC4' => $data->trbo_flagdisc4, 'PCL_DIS4CP' => $data->trbo_dis4cp,
                                                    'PCL_DIS4CR' => $data->trbo_dis4cr, 'PCL_DIS4RP' => $data->trbo_dis4rp,
                                                    'PCL_DIS4RR' => $data->trbo_dis4rr, 'PCL_DIS4JP' => $data->trbo_dis4jp,
                                                    'PCL_DIS4JR' => $data->trbo_dis4jr, 'PCL_NILAI' => $data->trbo_gross,
                                                    'PCL_DISCRPH' => $data->rebo_discrph, 'PCL_PPNRPH' => $data->trbo_ppnrph,
                                                    'PCL_PPNBMRPH' => $data->trbo_ppnbmrph, 'PCL_PPNBTLRPH' => $data->trbo_ppnbtlrph,
                                                    'PCL_AVGCOST' => ($NACOSTX * $data->trbo_frac) / $sum, 'PCL_KETERANGAN' => 'PACKLIST OTOMATIS BPB GMS',
                                                    'PCL_CREATE_DT' => $sysdatef, 'PCL_CREATE_BY' => $userId,
                                                    'PCL_FURGNT' => $data->trbo_furgnt
                                                ]);
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }


            if ($NACOSTX != 0) {
                $master_stock = DB::connection(Session::get('connection'))->table('TBMASTER_STOCK')
                    ->where('ST_PRDCD', $data->trbo_prdcd)
                    ->where('ST_LOKASI', '01')
                    ->where('ST_KODEIGR', $kodeigr)
                    ->get();

                foreach ($master_stock as $mstock) {
                    DB::connection(Session::get('connection'))->table('TBMASTER_STOCK')
                        ->where('ST_PRDCD', $data->trbo_prdcd)
                        ->where('ST_LOKASI', '01')
                        ->where('ST_KODEIGR', $kodeigr)
                        ->update([
                            'ST_AVGCOST' => $NACOSTX,
                            'ST_SALDOAKHIR' => $mstock->st_saldoakhir + $data->trbo_qty + $data->trbo_qtybonus1,
                            'ST_TRFIN' => $mstock->st_trfin + $data->trbo_qty + $data->trbo_qtybonus1,
                            'ST_MODIFY_BY' => $userId,
                            'ST_MODIFY_DT' => $sysdatef
                        ]);
                }
                //original code
                // $record2 = DB::connection(Session::get('connection'))->select("SELECT PRD_PRDCD, PRD_UNIT, PRD_FRAC
                //             FROM TBMASTER_PRODMAST,
                //             WHERE   SUBSTR (PRD_PRDCD, 1, 6) = SUBSTR ($data->trbo_prdcd, 1, 6)
                //             AND     PRD_KODEIGR  = '$kodeigr'");

                $record2 = DB::connection(Session::get('connection'))->table('TBMASTER_PRODMAST')
                    ->where('PRD_PRDCD', $data->trbo_prdcd)
                    ->where('PRD_KODEIGR', $kodeigr)
                    ->get();
                foreach ($record2 as $data2) {
                    if (substr($data2->prd_prdcd, -1) == 1 || $data2->prd_unit == 'KG') {
                        DB::connection(Session::get('connection'))->table('TBMASTER_PRODMAST')
                            ->where('PRD_PRDCD', $data2->prd_prdcd)
                            ->where('PRD_KODEIGR', $kodeigr)
                            ->update([
                                'PRD_AVGCOST' => $NACOSTX,
                            ]);
                    } else {
                        DB::connection(Session::get('connection'))->table('TBMASTER_PRODMAST')
                            ->where('PRD_PRDCD', $data2->prd_prdcd)
                            ->where('PRD_KODEIGR', $kodeigr)
                            ->update([
                                'PRD_AVGCOST' => $NACOST * $data2->prd_frac
                            ]);
                    }
                }
            }

            $TEMP = 0;
            $record2 = DB::connection(Session::get('connection'))->table('TBHISTORY_COST')
                ->where('HCS_PRDCD', $data->trbo_prdcd)
                ->where('HCS_TGLBPB', $sysdatef)
                ->where('HCS_NODOCBPB', $no_btb)
                ->get();

            $TEMP = count($record2);
            if ($TEMP == 0) {
                $trbo_nopo = '';
                $unit = '';
                $frac = '';
                $sum = 0;
                if ($data->trbo_nopo == null || $data->trbo_nopo == '') {
                    $trbo_nopo = 'AA1';
                    $unit = $data->prd_unit;
                    $frac = $data->prd_frac;
                } else {
                    $trbo_nopo = $data->trbo_nopo;
                    $unit = $data->tpod_satuanbeli;
                    $frac = $data->tpod_isibeli;
                }

                DB::connection(Session::get('connection'))->table('TBHISTORY_COST')->insert([
                    "HCS_KODEIGR" => $kodeigr,
                    "HCS_LOKASI" => $kodeigr,
                    "HCS_TYPETRN" => $trnType,
                    "HCS_PRDCD" => $data->trbo_prdcd,
                    "HCS_TGLBPB" => $sysdatef,
                    "HCS_NODOCBPB" => $no_btb,
                    "HCS_QTYBARU" => $data->trbo_qty + $data->trbo_qtybonus1,
                    "HCS_QTYLAMA" => $data->st_saldoakhir,
                    "HCS_AVGLAMA" => $NOLDACOSTX * $frac,
                    "HCS_AVGBARU" => $NACOSTX * $frac,
                    "HCS_LASTQTY" => $data->st_saldoakhir + $data->trbo_qty + $data->trbo_qtybonus1,
                    "HCS_CREATE_BY" => $userId,
                    "HCS_CREATE_DT" => $sysdatef
                ]);
            }
            $NLCOST = ($data->trbo_gross - $data->trbo_discrph + $data->trbo_dis4cr + $data->trbo_dis4jr + $data->trbo_dis4rr + $data->trbo_ppnbmrph + $data->trbo_ppnbtlrph) / ($data->trbo_qty + $data->trbo_qtybonus1);
            if (strtoupper($data->prd_unit) != 'KG') {
                $sum = 1;
            } else {
                $sum = 1000;
            }
            $NLCOST *= $sum;

            $x = 0;
            if ($data->prd_prdcd == '1' || strtoupper($data->prd_unit) == 'KG') {
                $x = 1;
            } else if ($data->trbo_nopo == 'AA1') {
                $x = $data->prd_frac;
            } else {
                $x = $data->tpod_isibeli;
            }
            DB::connection(Session::get('connection'))->table('TBHISTORY_COST')
                ->where('HCS_PRDCD', $data->trbo_prdcd)
                ->where('HCS_TGLBPB', $sysdatef)
                ->where('HCS_NODOCBPB', $no_btb)
                ->update([
                    'HCS_LASTCOSTBARU' => $NLCOST * $x,
                    'HCS_LASTCOSTLAMA' => $data->prd_lastcost,
                ]);

            if ($NLCOST != 0) {
                DB::connection(Session::get('connection'))->table('TBMASTER_STOCK')
                    ->where('ST_PRDCD', $data->trbo_prdcd)
                    ->where('ST_KODEIGR', $kodeigr)
                    ->update([
                        'ST_LASTCOST' => $NLCOST
                    ]);

                $record2 = DB::connection(Session::get('connection'))->table('TBMASTER_PRODMAST')
                    ->where('PRD_PRDCD', $data->trbo_prdcd)
                    ->where('PRD_KODEIGR', $kodeigr)
                    ->get(['PRD_PRDCD', 'PRD_UNIT', 'PRD_FRAC']);

                foreach ($record2 as $data2) {
                    if (substr($data2->prd_prdcd, -1) == 1 || $data2->prd_unit == 'KG') {
                        DB::connection(Session::get('connection'))->table('TBMASTER_PRODMAST')
                            ->where('PRD_PRDCD', $data2->prd_prdcd)
                            ->where('PRD_KODEIGR', $kodeigr)
                            ->update([
                                'PRD_LASTCOST' => $NLCOST,
                            ]);

                        if ($UPDPLU == true) {
                            DB::connection(Session::get('connection'))->table('TBTR_UPDATE_PLU_MD')->insert([
                                "UPD_KODEIGR" => $kodeigr,
                                "UPD_PRDCD" => $data2->prd_prdcd,
                                "UPD_HARGA" => $NLCOST,
                                "UPD_ATRIBUTE1" => 'BPB',
                                "UPD_CREATE_BY" => $userId,
                                "UPD_CREATE_DT" => $sysdatef
                            ]);
                        }
                    } else {
                        DB::connection(Session::get('connection'))->table('TBMASTER_PRODMAST')
                            ->where('PRD_PRDCD', $data2->prd_prdcd)
                            ->where('PRD_KODEIGR', $kodeigr)
                            ->update([
                                'PRD_LASTCOST' => $NLCOST * $data2->prd_frac
                            ]);
                        if ($UPDPLU == true) {
                            DB::connection(Session::get('connection'))->table('TBTR_UPDATE_PLU_MD')->insert([
                                "UPD_KODEIGR" => $kodeigr,
                                "UPD_PRDCD" => $data2->prd_prdcd,
                                "UPD_HARGA" => $NLCOST * $data2->prd_frac,
                                "UPD_ATRIBUTE1" => 'BPB',
                                "UPD_CREATE_BY" => $userId,
                                "UPD_CREATE_DT" => $sysdatef
                            ]);
                        }
                    }
                }
            }

            $TEMP = 0;
            $SUPCO = $data->sup_kodesupplier;
            $NOPO = $data->trbo_nopo;
            $NOFAKTUR = $data->trbo_nofaktur;
            $PKP = $data->sup_pkp;
            $TGLPO = $data->trbo_tglpo;
            $TGLFAKTUR = $data->trbo_tglfaktur;
            DB::connection(Session::get('connection'))->table('TBTR_BACKOFFICE')
                ->where('TRBO_NODOC', $data->trbo_nodoc)
                ->where('TRBO_PRDCD', $data->trbo_prdcd)
                ->update(['TRBO_NONOTA' => $no_btb, 'TRBO_TGLNOTA' => $sysdatef]);
        }
        DB::connection(Session::get('connection'))->table('TBTR_MSTRAN_H')->insert([
            "MSTH_KODEIGR" => $kodeigr,
            "MSTH_TYPETRN" => $trnType,
            "MSTH_NODOC" => $no_btb,
            "MSTH_TGLDOC" => $sysdatef,
            "MSTH_FLAGDOC" => '1',
            "MSTH_KODESUPPLIER" => $SUPCO,
            "MSTH_NOPO" => $NOPO,
            "MSTH_TGLPO" => $TGLPO,
            "MSTH_NOFAKTUR" => $NOFAKTUR,
            "MSTH_TGLFAKTUR" => $TGLFAKTUR,
            "MSTH_PKP" => $PKP,
            "MSTH_CTERM" => $SUPTOP,
            "MSTH_CREATE_BY" => $userId,
            "MSTH_CREATE_DT" => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        if ($SUPCO != null) {
            $hutang = DB::connection(Session::get('connection'))->table('TBTR_HUTANG')
                ->where('HTG_TYPE', 'J')
                ->where('HTG_NODOKUMEN', $no_btb)
                ->where('HTG_RECORDID', '!=', '1')
                ->get();
            $TEMP = count($hutang);
            $record2 = DB::connection(Session::get('connection'))->select(
                "SELECT MSTD_KODESUPPLIER, MSTD_CTERM, MSTD_NOFAKTUR, MSTD_NOPO, MSTD_TGLPO, MSTD_TGLFP, PRD_FLAGBKP1, PRD_FLAGBKP2,
                        SUM (NVL (MSTD_GROSS, 0)
                            - NVL (MSTD_DISCRPH, 0)
                            + NVL (MSTD_PPNBMRPH, 0)
                            + NVL (MSTD_PPNBTLRPH, 0)
                            ) AMOUNT,
                        SUM (NVL (MSTD_GROSS, 0)
                            - NVL (MSTD_DISCRPH, 0)
                            + NVL (MSTD_PPNBMRPH, 0)
                            + NVL (MSTD_PPNBTLRPH, 0)
                            + NVL (MSTD_PPNRPH, 0)
                            ) BALANCE,
                        SUM(MSTD_PPNRPH) PPN, 
                        SUM(MSTD_PPNBMRPH) PPNBM, 
                        SUM(MSTD_PPNBTLRPH) PPNBTL, 
                        SUM(MSTD_RPHDISC1) DISC1, 
                        SUM(MSTD_RPHDISC2) DISC2, 
                        SUM(MSTD_RPHDISC2II) DISC2II, 
                        SUM(MSTD_RPHDISC2III) DISC2III, 
                        SUM(MSTD_RPHDISC3) DISC3, 
                        SUM(MSTD_RPHDISC4) DISC4, 
                        SUM(MSTD_DIS4CR) DISC4CR, 
                        SUM(MSTD_DIS4RR) DISC4RR, 
                        SUM(MSTD_DIS4JR) DISC4JR, 
                        MSTH_CTERM
                        FROM    TBTR_MSTRAN_D, TBMASTER_PRODMAST, TBTR_MSTRAN_H
                        WHERE   MSTD_NODOC      = '$no_btb'
                        AND     MSTD_KODEIGR    = '$kodeigr'
                        AND     MSTH_KODEIGR    = '$kodeigr'
                        AND     MSTH_NODOC      = '$no_btb'
                        AND     PRD_PRDCD       = MSTD_PRDCD
                        AND     PRD_KODEIGR     = MSTD_KODEIGR
                        GROUP BY 
                            MSTD_KODESUPPLIER,
                            MSTD_CTERM,
                            MSTD_NOFAKTUR,
                            MSTD_NOPO,
                            MSTD_TGLPO,
                            MSTD_TGLFP,
                            PRD_FLAGBKP1,
                            PRD_FLAGBKP2,
                            MSTH_CTERM"
            );
            foreach ($record2 as $data2) {
                if ($TEMP == 0) {
                    $TGL = Carbon::now()->addDays($data2->msth_cterm);
                    DB::connection(Session::get('connection'))->table('TBTR_HUTANG')->insert([
                        "HTG_KODEIGR" => $kodeigr,
                        "HTG_RECORDID" => null,
                        "HTG_TYPE" => 'J',
                        "HTG_KODESUPPLIER" => $data2->mstd_kodesupplier,
                        "HTG_NODOKUMEN" => $no_btb,
                        "HTG_NODOKUMEN2" => $data2->mstd_nofaktur,
                        "HTG_TGLFAKTURPAJAK" => $sysdatef,
                        "HTG_TGLJATUHTEMPO" => $TGL,
                        "HTG_TOP" => $data2->msth_cterm,
                        "HTG_NOREFERENSI" => $data2->mstd_nopo,
                        "HTG_TGLREFERENSI" => $data2->mstd_tglpo,
                        "HTG_NILAIHUTANG" => $data2->amount,
                        "HTG_FLAGBKP1" => $data2->prd_flagbkp1,
                        "HTG_FLAGBKP2" => $data2->prd_flagbkp2,
                        "HTG_SALDO" => $data2->balance,
                        "HTG_RPHDISC1" => $data2->disc1,
                        "HTG_RPHDISC2" => $data2->disc2,
                        "HTG_RPHDISC2II" => $data2->disc2ii,
                        "HTG_RPHDISC2III" => $data2->disc2iii,
                        "HTG_RPHDISC3" => $data2->disc3,
                        "HTG_RPHDISC4" => $data2->disc4,
                        "HTG_DIS4CR" => $data2->disc4cr,
                        "HTG_DIS4RR" => $data2->disc4rr,
                        "HTG_DIS4JR" => $data2->disc4jr,
                        "HTG_PPN" => $data2->ppn,
                        "HTG_CREATEBY" => $userId,
                        "HTG_CREATEDT" => $sysdatef
                    ]);
                } else {
                    $P_SUKSES = 99;
                }
            }
            $P_SUKSES = 1;
        }
        if ($P_SUKSES == 1 || $trnType == 'L') {
            return ['kode' => 1, 'msg' => 'Update Data 1 Sukses', 'nota' => $no_btb];
        } else {
            return ['kode' => $P_ERROR, 'msg' => 'Error ' . $P_SUKSES, 'nota' => $no_btb];
        }
        // $exec = oci_parse($conn, "BEGIN sp_penerimaan_updatedata(:kodeigr, :userid, :tipe, :dummyvar, :result); END;");
        // oci_bind_by_name($exec, ':kodeigr', $kodeigr);
        // oci_bind_by_name($exec, ':userid', $userId);
        // oci_bind_by_name($exec, ':tipe', $type);
        // oci_bind_by_name($exec, ':dummyvar', $dummyvar);
        // oci_bind_by_name($exec, ':result', $result, 1000);
        // oci_execute($exec);
    }

    public function update_data2($kodeigr, $conn, $trnType)
    {
        $cprdcd = '';
        $nqtyb  = 0;
        $nqtypo = 0;
        $nqtys  = 0;
        $qty7a  = 0;
        $qty7b  = 0;
        $nqtyo  = 0;
        $naaa   = 0;
        $nbbb   = 0;
        $cklist = false;
        $pclb   = 0;
        $pclbk  = 0;
        $pcls   = 0;
        $pclsk  = 0;
        $tes    = 0;
        $sysdatef = Carbon::now()->format('Y-m-d');
        $x = 0;

        $cprdcd = NULL;
        if ($trnType == 'B') {
            $record = DB::connection(Session::get('connection'))->select("SELECT *
                    FROM    tbtr_listpacking,
                            tbtr_backoffice,
                            tbtr_pbcabang_gudangpusat,
                            tbmaster_stock,
                            tbmaster_hargabeli,
                            tbmaster_prodmast
                    WHERE   pcl_kodeigr     = '$kodeigr'
                    AND     pcl_create_dt   = '$sysdatef'
                    AND     pcl_recordid    IS NULL
                    AND     trbo_kodeigr    = pcl_kodeigr
                    AND     trbo_typetrn    = 'B'
                    AND     trbo_nodoc      = pcl_noreferensi1
                    AND     trbo_prdcd      = pcl_prdcd
                    AND     pbc_kodecabang  = pcl_kodecabang
                    AND     pbc_nopbcabang  = pcl_noreferensi
                    AND     pbc_prdcd       = pcl_prdcd
                    AND     st_prdcd        = pcl_prdcd
                    AND     st_lokasi       = '01'
                    AND     hgb_prdcd       = pcl_prdcd
                    AND     prd_prdcd       = pcl_prdcd
                    ORDER BY 
                            pcl_create_dt, pcl_prdcd, 
                            pcl_kode, pcl_nodokumen, 
                            pcl_kodecabang
                    ");

            foreach ($record as $rec) {
                if ($rec->pbc_recordid == 3 && ($rec->pbc_qtypb - $rec->pbc_qtybbp) == 0) {
                    return false;
                } else {
                    if ($rec->pcl_kodecabang == '05') {
                        return false;
                    }
                    $cklist = true;
                    $nqtyo = (($rec->pcl_qty_o * $rec->prd_frac) + $rec->pcl_qty_ok);
                    if ($cprdcd == '1234567' || $cprdcd != $rec->pcl_prdcd) {
                        $nqtyb  = $rec->trbo_qty;
                        $nqtypo = $rec->trbo_qty;
                        $nqtys  = $rec->st_saldoakhir;
                        $nqtys  = $nqtys - $nqtyb;
                        $cprdcd = $rec->pcl_prdcd;
                    }

                    if ($nqtyo <= $nqtyb) {
                        $pcls   = 0;
                        $pclb   = 0;
                        $pclsk  = 0;
                        $pclbk  = 0;
                        $naaa   = 0;
                        $nbbb   = 0;
                        $naaa   = floor($nqtyo / $rec->prd_frac);
                        $nbbb   = $nqtyo % $rec->prd_frac;

                        if ($rec->pcl_kodecabang == $kodeigr) {
                            DB::connection(Session::get('connection'))->table('tbtr_listpacking')
                                ->where('pcl_nodokumen', $rec->pcl_nodokumen)
                                ->where('pcl_prdcd', $rec->pcl_prdcd)
                                ->where('pcl_kodecabang', $rec->pcl_kodecabang)
                                ->update([
                                    'pcl_qtyr_b'  => floor($nqtyb / $rec->prd_frac),
                                    'pcl_qtyr_bk' => $nqtyb % $rec->prd_frac
                                ]);
                            $pclb = floor($nqtyb / $rec->prd_frac);
                            $pclbk = $nqtyb % $rec->prd_frac;
                        } else {
                            DB::connection(Session::get('connection'))->table('tbtr_listpacking')
                                ->where('pcl_nodokumen', $rec->pcl_nodokumen)
                                ->where('pcl_prdcd', $rec->pcl_prdcd)
                                ->where('pcl_kodecabang', $rec->pcl_kodecabang)
                                ->update([
                                    'pcl_qtyr_b'  => $naaa,
                                    'pcl_qtyr_bk' => $nbbb
                                ]);
                            $pclb = $naaa;
                            $pclbk = $nbbb;
                        }
                        DB::connection(Session::get('connection'))->table('tbtr_listpacking')
                            ->where('pcl_nodokumen', $rec->pcl_nodokumen)
                            ->where('pcl_prdcd', $rec->pcl_prdcd)
                            ->where('pcl_kodecabang', $rec->pcl_kodecabang)
                            ->update([
                                'pcl_qtyr_s'  => 0,
                                'pcl_qtyr_sk' => 0
                            ]);
                    } else {
                        $pcls   = 0;
                        $pclb   = 0;
                        $pclsk  = 0;
                        $pclbk  = 0;
                        $naaa   = 0;
                        $nbbb   = 0;
                        $naaa   = floor($nqtyb / $rec->prd_frac);
                        $nbbb   = $nqtyb % $rec->prd_frac;

                        DB::connection(Session::get('connection'))->table('tbtr_listpacking')
                            ->where('pcl_nodokumen', $rec->pcl_nodokumen)
                            ->where('pcl_prdcd', $rec->pcl_prdcd)
                            ->where('pcl_kodecabang', $rec->pcl_kodecabang)
                            ->update([
                                'pcl_qtyr_b'  => $naaa,
                                'pcl_qtyr_bk' => $nbbb
                            ]);

                        $pclb = $naaa;
                        $pclbk = $nbbb;

                        if ($rec->pbc_kodecabang || $rec->pbc_nopbcabang || $rec->pbc_prdcd || $rec->pcl_kodecabang || $rec->pcl_noreferensi || $rec->pcl_prdcd) {
                            if ($rec->pbc_recordid == 3) {
                                if (($rec->pbc_qtybbp + $nqtyb) < $rec->pbc_qtypb) {
                                    if (($nqtyo - $nqtyb) < $nqtys) {
                                        DB::connection(Session::get('connection'))->table('tbtr_listpacking')
                                            ->where('pcl_nodokumen', $rec->pcl_nodokumen)
                                            ->where('pcl_prdcd', $rec->pcl_prdcd)
                                            ->where('pcl_kodecabang', $rec->pcl_kodecabang)
                                            ->update([
                                                'pcl_qtyr_s'  => floor(($nqtyo - $nqtyb) / $rec->prd_frac),
                                                'pcl_qtyr_sk' => ($nqtyo - $nqtyb) % $rec->prd_frac
                                            ]);

                                        $pcls = floor(($nqtyo - $nqtyb) / $rec->prd_frac);
                                        $pclsk = floor($nqtyo - $nqtyb) % $rec->prd_frac;
                                    } else {
                                        if ($nqtys > 0) {
                                            DB::connection(Session::get('connection'))->table('tbtr_listpacking')
                                                ->where('pcl_nodokumen', $rec->pcl_nodokumen)
                                                ->where('pcl_prdcd', $rec->pcl_prdcd)
                                                ->where('pcl_kodecabang', $rec->pcl_kodecabang)
                                                ->update([
                                                    'pcl_qtyr_s'  => floor($nqtys / $rec->prd_frac),
                                                    'pcl_qtyr_sk' => $nqtys % $rec->prd_frac
                                                ]);

                                            $pcls = floor($nqtys / $rec->prd_frac);
                                            $pclsk = $nqtys % $rec->prd_frac;
                                        }
                                    }
                                }
                            } else {
                                if (($nqtyo - $nqtyb) < $nqtys) {
                                    DB::connection(Session::get('connection'))->table('tbtr_listpacking')
                                        ->where('pcl_nodokumen', $rec->pcl_nodokumen)
                                        ->where('pcl_prdcd', $rec->pcl_prdcd)
                                        ->where('pcl_kodecabang', $rec->pcl_kodecabang)
                                        ->update([
                                            'pcl_qtyr_s'  => floor(($nqtyo - $nqtyb) / $rec->prd_frac),
                                            'pcl_qtyr_sk' => ($nqtyo - ($pclb * $rec->prd_frac) + $pclbk) - ($pcls * $rec->prd_frac)
                                        ]);

                                    $pcls = floor(($nqtyo - $nqtyb) / $rec->prd_frac);
                                    $pclsk = ($nqtyo - ($nqtyb * $rec->prd_frac) + $pclbk) - ($pcls * $rec->prd_frac);
                                } else {
                                    if ($nqtys > 0) {
                                        DB::connection(Session::get('connection'))->table('tbtr_listpacking')
                                            ->where('pcl_nodokumen', $rec->pcl_nodokumen)
                                            ->where('pcl_prdcd', $rec->pcl_prdcd)
                                            ->where('pcl_kodecabang', $rec->pcl_kodecabang)
                                            ->update([
                                                'pcl_qtyr_s'  => floor($nqtys / $rec->prd_frac),
                                                'pcl_qtyr_sk' => ($nqtys % $rec->prd_frac)
                                            ]);

                                        $pcls = floor($nqtys / $rec->prd_frac);
                                        $pclsk = $nqtys % $rec->prd_frac;
                                    }
                                }
                            }
                        }
                    }

                    if (strtoupper($rec->prd_unit) == 'KG') {
                        $x = 1;
                    } else {
                        $x = $rec->prd_frac;
                    }
                    $qty7a = floor(((($pclb + $pcls) * $rec->prd_frac) + $pclbk + $pclsk) / $rec->prd_frac);
                    $qty7b = ((($pclb + $pcls) * $rec->prd_frac) + $pclbk + $pclsk) % $rec->prd_frac;
                    $tes = ($qty7a * ($rec->st_avgcost * $x)) + ($qty7b / $rec->prd_frac * ($rec->st_avgcost * $x)) * 0.1;

                    DB::connection(Session::get('connection'))->table('tbtr_listpacking')
                        ->where('pcl_nodokumen', $rec->pcl_nodokumen)
                        ->where('pcl_prdcd', $rec->pcl_prdcd)
                        ->where('pcl_kodecabang', $rec->pcl_kodecabang)
                        ->update([
                            'pcl_nilai'  => ($qty7a * ($rec->st_avgcost * $x)) + $qty7b / $rec->prd_frac * ($rec->st_avgcost * $x),
                            'pcl_ppnrph' => (($qty7a * ($rec->st_avgcost * $x)) + $qty7b / $rec->prd_frac * ($rec->st_avgcost * $x)) * 0.1,
                            'pcl_ppnbmrph' => $rec->hgb_ppnbm * ($qty7a) + $qty7b,
                            'pcl_ppnbtlrph' => $rec->hgb_ppnbotol * ($qty7a + $qty7b)
                        ]);

                    $nqtyb = $nqtyb - (($pclb * $rec->prd_frac) + $pclbk);
                    $nqtys = $nqtys - (($pcls * $rec->prd_frac) + $pclsk);

                    if ($nqtyb < 0) {
                        $nqtyb = 0;
                    }

                    if ($nqtys < 0) {
                        $nqtys = 0;
                    }

                    if ((($pclb + $pcls) * $rec->prd_frac) + $pclbk + $pclsk != 0) {
                        DB::connection(Session::get('connection'))->table('tbtr_listpacking')
                            ->where('pcl_nodokumen', $rec->pcl_nodokumen)
                            ->where('pcl_prdcd', $rec->pcl_prdcd)
                            ->where('pcl_kodecabang', $rec->pcl_kodecabang)
                            ->update([
                                'pcl_recordid' => '2'
                            ]);
                    } else {
                        DB::connection(Session::get('connection'))->table('tbtr_listpacking')
                            ->where('pcl_nodokumen', $rec->pcl_nodokumen)
                            ->where('pcl_prdcd', $rec->pcl_prdcd)
                            ->where('pcl_kodecabang', $rec->pcl_kodecabang)
                            ->update([
                                'pcl_recordid'  => '9'
                            ]);
                    }
                    if (($rec->pbc_kodecabang || $rec->pbc_nopbcabang || $rec->pbc_prdcd) == ($rec->pcl_kodecabang || $rec->pcl_noreferensi || $rec->pcl_prdcd)) {
                        if ($rec->pbc_recordid != '3') {
                            DB::connection(Session::get('connection'))->table('tbtr_pbcabang_gudangpusat')
                                ->where('pbc_nopbgudangpusat', $rec->pbc_nopbgudangpusat)
                                ->where('pbc_nopbcabang', $rec->pbc_nopbcabang)
                                ->update([
                                    'pbc_recordid'  => '2'
                                ]);
                        }
                    }
                }
            }
        }
        // $exec = oci_parse($conn, "BEGIN sp_penerimaan_updatedata2(:kodeigr, :tipe, :result); END;");
        // oci_bind_by_name($exec, ':kodeigr', $kodeigr);
        // oci_bind_by_name($exec, ':tipe', $type);
        // oci_bind_by_name($exec, ':result', $result, 1000);
        // oci_execute($exec);

        return ['kode' => 1, 'message' => "Update Data 2 Sukses"];
    }

    public function print_btb($temp, $type, $v_print, $size)
    {
        if ($type == 1) {
            if ($size == 2) {
                return 'IGR_BO_LISTBTB_FULL';
            } else {
                return 'IGR_BO_LISTBTB';
            }
        } else {
            if ($size == 2) {
                return "IGR_BO_CTBTBNOTA_FULL,IGR_BO_CTBTBNOTA_NONHARGA_FULL";
            } else {
                return "IGR_BO_CTBTBNOTA,IGR_BO_CTBTBNOTA_NONHARGA";
            }
        }
    }

    public function print_lokasi($temp_lokasi, $type, $v_print)
    {
        $temp = $temp_lokasi[0][0];
        $datas = DB::connection(Session::get('connection'))->select("SELECT trbo_prdcd,
                                       SUBSTR (prd_deskripsipanjang, 1, 50) desc2,
                                       prd_unit || '/' || prd_frac kemasan,
                                       lks_koderak,
                                       lks_kodesubrak,
                                       lks_tiperak,
                                       lks_shelvingrak,
                                       FLOOR (trbo_qty / prd_frac) qty,
                                       lks_koderak || lks_kodesubrak || lks_tiperak || lks_shelvingrak
                                          keterangan,
                                       MOD (trbo_qty, prd_frac) qtyk,
                                       prs_namaperusahaan,
                                       prs_namacabang,
                                       prs_namawilayah
                                  FROM tbtr_backoffice,
                                       tbmaster_lokasi,
                                       tbmaster_prodmast,
                                       tbmaster_perusahaan
                                 WHERE     prs_kodeigr = trbo_kodeigr
                                       AND trbo_kodeigr = '22'
                                       AND trbo_nodoc in '$temp'
                                       AND lks_prdcd = trbo_prdcd
                                       AND lks_kodeigr = trbo_kodeigr
                                       AND prd_prdcd = trbo_prdcd
                                       AND prd_kodeigr = trbo_kodeigr");
        // perlu di panggil ulang dari viewreport soalnya datas engga kebaca kalo cuma = '1'
        $pdf = PDF::loadview('BACKOFFICE.TRANSAKSI.PENERIMAAN.igr_bo_ctklokasi', ['datas' => $datas]);
        $pdf->output();
        $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);
        $canvas = $dompdf->get_canvas();
        $canvas->page_text(514, 10, "Page {PAGE_NUM} of {PAGE_COUNT}", null, 10, array(0, 0, 0));


        return $pdf->stream('igr_bo_ctklokasi.PDF');
    }

    public function deleteSigs()
    {
        $files = Storage::disk('signature_expedition')->allFiles();
        if (count($files) > 0) {
            foreach ($files as $file => $value) {
                $filePath = '../storage/signature_expedition/' . $value;
                File::delete($filePath);
            }
        }
    }

    public function deleteFiles()
    {
        $files = Storage::disk('receipts')->allFiles();
        if (count($files) > 0) {
            foreach ($files as $file => $value) {
                $filePath = '../storage/receipts/' . $value;
                File::delete($filePath);
            }
        }
    }

    public function deleteBackupFiles()
    {
        $files = Storage::disk('receipts_backup')->allFiles();
        if (count($files) > 0) {
            foreach ($files as $file => $value) {
                $filePath = '../storage/receipts_backup/' . $value;
                File::delete($filePath);
            }
        }
    }

    public function getArea()
    {
        $kodeigr = Session::get('kdigr');
        $result = DB::connection(Session::get('connection'))->select(
            "SELECT CAB_KODEWILAYAH
             FROM TBMASTER_CABANG
             WHERE CAB_KODECABANG = '$kodeigr'"
        );
        return $result[0]->cab_kodewilayah;
    }

    public function kirimFtpCabang($area)
    {
        $cabang = strtolower($area);
        $msg = '';
        $ftp_server = config('database.connections.igr' . $cabang . '.host');
        $ftp_user_name = 'ftpigr';
        $ftp_user_pass = 'ftpigr';
        $zipName = Session::get('kdigr') . '_' . date("Ymd", strtotime(Carbon::now())) . '.ZIP';
        $zipAddress = '../storage/receipts_backup/' . $zipName;
        try {
            $conn_id = ftp_connect($ftp_server);
            ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);
            $files = Storage::disk('receipts_backup')->allFiles();
            if (count($files) > 0) {
                if (Storage::disk('receipts_backup')->exists($zipName) == false) {
                    $zip = new ZipArchive;
                    if (true === ($zip->open($zipAddress, ZipArchive::CREATE | ZipArchive::OVERWRITE))) {
                        foreach ($files as $file => $value) {
                            $filePath = '../storage/receipts_backup/' . $value;
                            $zip->addFile($filePath, $value);
                        }
                        $zip->close();
                        ftp_put($conn_id, '/u01/lhost/bpb_backup/' . $zipName, $zipAddress);
                        //send to Cabang
                    } else {
                        $msg = 'Proses kirim file gagal';
                        return response()->json(['kode' => 0, 'message' => $msg]);
                    }
                } else {
                    ftp_put($conn_id, '/u01/lhost/bpb_backup/' . $zipName, $zipAddress);
                    //send to Cabang
                }

                $msg = 'File terkirim ke Cabang';
                File::delete($zipAddress); //delete zip file from storage
                // $this->deleteBackupFiles(); //delete all files
            } else {
                $msg = 'Empty Record, nothing to transfer';
                return response()->json(['kode' => 2, 'message' => $msg]);
            }
        } catch (Exception $e) {
            $msg = 'Proses kirim file gagal (error)';
            return response()->json(['kode' => 0, 'message' => $msg . $e]);
        }
        return response()->json(['kode' => 1, 'message' => $msg]);
    }

    public function kirimServerCabang($path, $datas, $pdf, $report)
    {
        $area = $this->getArea();
        $type = '';
        if ($report == 'IGR_BO_CTBTBNOTA' || $report == 'IGR_BO_CTBTBNOTA_FULL') {
            $type = 'BTB_';
        } else {
            $type = 'BTB_NON_HARGA_';
        }

        if (!File::exists(storage_path($path))) {
            File::makeDirectory(storage_path($path), 0755, true, true);
        }

        for ($i = 0; $i < sizeof($datas); $i++) {
            $content = $pdf->download()->getOriginalContent();
            $id = $type . $datas[$i]->msth_nodoc . '_' . date("Ymd", strtotime($datas[$i]->msth_tgldoc));
            $file = storage_path($path . $id . '.PDF');
            file_put_contents($file, $content);
        }

        $this->kirimFtpCabang($area);
    }

    public function viewReport(Request $request)
    {
        $signedBy = Session::get('signer');
        $report = $request->report;
        $noDoc  = $request->noDoc;
        $reprint = $request->reprint;
        $ttd = $request->ttd;
        $ttd = ($ttd != null) ? $ttd : ' ';
        $splitDoc = explode(',', $noDoc);
        $kodeigr = Session::get('kdigr');
        $document = '';
        $re_print = ($reprint == 1) ? '(REPRINT)' : ' ';
        foreach ($splitDoc as $data) {
            $document = $document . "'" . $data . "',";
        }

        $document = substr($document, 0, -1);
        if ($report == 'IGR_BO_LISTBTB_FULL') {
            $datas = DB::connection(Session::get('connection'))->select("select trbo_nodoc, TO_CHAR(trbo_tgldoc,'DD/MM/YY') trbo_tgldoc, trbo_nopo, TO_CHAR(trbo_tglpo,'DD/MM/YY') trbo_tglpo, trbo_nofaktur, TO_CHAR(trbo_tglfaktur,'DD/MM/YY') trbo_tglfaktur,
                                        floor(trbo_qty/prd_frac) qty, mod(trbo_qty,prd_frac) qtyk, trbo_qtybonus1, trbo_qtybonus2, trbo_typetrn, trbo_qty, nvl(trbo_flagdoc,'0') flagdoc,
                                        trbo_hrgsatuan, trbo_persendisc1, trbo_persendisc2 , trbo_persendisc2ii , trbo_persendisc2iii , trbo_persendisc3, trbo_persendisc4, trbo_gross, trbo_ppnrph,trbo_ppnbmrph,trbo_ppnbtlrph,
                                        trbo_discrph, trbo_prdcd, trbo_rphdisc1, trbo_rphdisc2, trbo_rphdisc2ii, trbo_rphdisc2iii,  trbo_rphdisc3, trbo_rphdisc4,
                                        prd_deskripsipanjang, prd_unit||'/'||prd_frac kemasan, prd_unit, prd_frac,
                                        sup_kodesupplier||'-'||sup_namasupplier|| case when sup_singkatansupplier is not null then '/'||sup_singkatansupplier end supplier, sup_top,
                                        prs_namaperusahaan, prs_namacabang, case when trbo_persendisc1 <> 0 then (trbo_persendisc1 * trbo_gross) / 100 else trbo_rphdisc1 end as ptg1, case when trbo_persendisc2 <> 0 then (trbo_persendisc2 * trbo_gross) / 100 else trbo_rphdisc2 end as ptg2,
                                        (NVL(TRBO_Gross,0) - NVL(TRBO_DISCRPH,0) + NVL(TRBO_PPNRPH,0) + NVL(TRBO_PPNBmrpH,0) + NVL(TRBO_PPNBtlrpH,0)) as total
                                            FROM tbtr_backoffice,
                                                 tbmaster_prodmast,
                                                 tbmaster_supplier,
                                                 tbmaster_perusahaan
                                           WHERE     trbo_kodeigr = :p_kodeigr
                                                 AND prd_kodeigr = trbo_kodeigr
                                                 AND prd_prdcd = trbo_prdcd
                                                 AND prs_kodeigr = trbo_kodeigr
                                                 AND sup_kodesupplier(+) = trbo_kodesupplier
                                                 AND trbo_nodoc in ($document)
                                        ORDER BY trbo_nodoc, trbo_prdcd", (['p_kodeigr' => $kodeigr]));

            $pdf = PDF::loadview('BACKOFFICE.TRANSAKSI.PENERIMAAN.igr_bo_listbtb_full', ['datas' => $datas, 're_print' => $re_print]);
            $pdf->output();
            $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);

            $canvas = $dompdf->get_canvas();
            $canvas->page_text(514, 10, "Page {PAGE_NUM} of {PAGE_COUNT}", null, 10, array(0, 0, 0));

            return $pdf->stream('igr_bo_listbtb_full.PDF');
        } else if ($report == 'IGR_BO_LISTBTB') {
            $datas = DB::connection(Session::get('connection'))->select("select trbo_nodoc, TO_CHAR(trbo_tgldoc,'DD/MM/YY') trbo_tgldoc, trbo_nopo, TO_CHAR(trbo_tglpo,'DD/MM/YY') trbo_tglpo, trbo_nofaktur, TO_CHAR(trbo_tglfaktur,'DD/MM/YY') trbo_tglfaktur,
                                        floor(trbo_qty/prd_frac) qty, mod(trbo_qty,prd_frac) qtyk, trbo_qtybonus1, trbo_qtybonus2, trbo_typetrn, trbo_qty, nvl(trbo_flagdoc,'0') flagdoc,
                                        trbo_hrgsatuan, trbo_persendisc1, trbo_persendisc2 , trbo_persendisc2ii , trbo_persendisc2iii , trbo_persendisc3, trbo_persendisc4, trbo_gross, trbo_ppnrph,trbo_ppnbmrph,trbo_ppnbtlrph,
                                        trbo_discrph, trbo_prdcd, trbo_rphdisc1, trbo_rphdisc2, trbo_rphdisc2ii, trbo_rphdisc2iii,  trbo_rphdisc3, trbo_rphdisc4,
                                        prd_deskripsipanjang, prd_unit||'/'||prd_frac kemasan, prd_unit, prd_frac,
                                        sup_kodesupplier||'-'||sup_namasupplier|| case when sup_singkatansupplier is not null then '/'||sup_singkatansupplier end supplier, sup_top,
                                        prs_namaperusahaan, prs_namacabang, case when trbo_persendisc1 <> 0 then (trbo_persendisc1 * trbo_gross) / 100 else trbo_rphdisc1 end as ptg1, case when trbo_persendisc2 <> 0 then (trbo_persendisc2 * trbo_gross) / 100 else trbo_rphdisc2 end as ptg2,
                                        (NVL(TRBO_Gross,0) - NVL(TRBO_DISCRPH,0) + NVL(TRBO_PPNRPH,0) + NVL(TRBO_PPNBmrpH,0) + NVL(TRBO_PPNBtlrpH,0)) as total
                                            FROM tbtr_backoffice,
                                                 tbmaster_prodmast,
                                                 tbmaster_supplier,
                                                 tbmaster_perusahaan
                                           WHERE     trbo_kodeigr = :p_kodeigr
                                                 AND prd_kodeigr = trbo_kodeigr
                                                 AND prd_prdcd = trbo_prdcd
                                                 AND prs_kodeigr = trbo_kodeigr
                                                 AND sup_kodesupplier(+) = trbo_kodesupplier
                                                 AND trbo_nodoc in ($document)
                                        ORDER BY trbo_nodoc, trbo_prdcd", (['p_kodeigr' => $kodeigr]));

            if ($datas) {
                foreach ($datas as $data) {
                    $nilaiDisc1 = 0;
                    $nilaiDisc1 = $data->ptg1;
                    $nilaiDisc2 = ($data->trbo_persendisc2 != 0) ? ($data->trbo_persendisc2 * ($data->trbo_gross - $nilaiDisc1)) / 100 : $data->trbo_rphdisc2;
                    $nilaiDisc2a = ($data->trbo_persendisc2ii != 0) ? ($data->trbo_persendisc2ii * ($data->trbo_gross - ($nilaiDisc1 + $nilaiDisc2))) / 100 : $data->trbo_rphdisc2ii;
                    $nilaiDisc2b = ($data->trbo_persendisc2iii != 0) ? ($data->trbo_persendisc2iii * ($data->trbo_gross - ($nilaiDisc1 + $nilaiDisc2 + $nilaiDisc2a))) / 100 : $data->trbo_rphdisc2iii;

                    $data->ptg2 = $nilaiDisc2 + $nilaiDisc2a + $nilaiDisc2b;
                }
            }

            $pdf = PDF::loadview('BACKOFFICE.TRANSAKSI.PENERIMAAN.igr_bo_listbtb', ['datas' => $datas, 're_print' => $re_print]);
            $pdf->output();
            $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);

            $canvas = $dompdf->get_canvas();
            $canvas->page_text(514, 10, "Page {PAGE_NUM} of {PAGE_COUNT}", null, 10, array(0, 0, 0));

            return $pdf->stream('igr_bo_listbtb.PDF');
        } else if ($report == 'IGR_BO_CTBTBNOTA') {
            $datas = DB::connection(Session::get('connection'))->select("select msth_recordid, msth_nodoc, msth_tgldoc, msth_nopo, msth_tglpo, msth_nofaktur, msth_tglfaktur, msth_cterm, msth_flagdoc, (mstd_tgldoc + msth_cterm) tgljt, mstd_cterm,
                                        prs_namaperusahaan, prs_namacabang, prs_alamat1, prs_alamat2, prs_alamat3,prs_npwp,
                                        sup_kodesupplier||' '||sup_namasupplier || '/' || sup_singkatansupplier supplier, sup_npwp, sup_alamatsupplier1 ||'   '||sup_alamatsupplier2 alamat_supplier,
                                        sup_telpsupplier, sup_contactperson contact_person, sup_kotasupplier3,
                                        mstd_prdcd||' '||prd_deskripsipanjang plu, mstd_unit||'/'||mstd_frac kemasan, floor(mstd_qty/mstd_frac) qty, mod(mstd_qty,mstd_frac) qtyk, mstd_typetrn,
                                        mstd_hrgsatuan, mstd_ppnrph, mstd_ppnbmrph, mstd_ppnbtlrph, nvl(mstd_gross,0)- nvl(mstd_discrph,0)+nvl(mstd_dis4cr,0)+ nvl(mstd_dis4rr,0)+nvl(mstd_dis4jr,0) jumlah,
                                        nvl(mstd_rphdisc1,0) as disc1,
                                        (nvl(mstd_rphdisc2,0) + nvl(mstd_rphdisc2ii,0) + nvl(mstd_rphdisc2iii,0) ) as disc2,
                                        nvl(mstd_rphdisc3,0) as disc3, nvl(mstd_qtybonus1,0) as bonus1, nvl(mstd_qtybonus2,0) as bonus2, nvl(mstd_keterangan,' ') as keterangan, (nvl(mstd_dis4cr,0) + nvl(mstd_dis4rr,0) + nvl(mstd_dis4jr,0)) as disc4,
                                        case when mstd_typetrn = 'B' then '( PEMBELIAN )' else '( LAIN - LAIN )' end judul, '0' || '$kodeigr' || mstd_nodoc barcode
                                        from tbtr_mstran_h, tbmaster_perusahaan, tbmaster_supplier, tbtr_mstran_d, tbmaster_prodmast, tbtr_backoffice
                                        where msth_kodeigr='$kodeigr'
                                        and prs_kodeigr=msth_kodeigr
                                        and sup_kodesupplier(+)=msth_kodesupplier
                                        and sup_kodeigr(+)=msth_kodeigr
                                        and mstd_nodoc=msth_nodoc
                                        and mstd_kodeigr=msth_kodeigr
                                        and prd_kodeigr=msth_kodeigr
                                        and prd_prdcd = mstd_prdcd
                                        AND trbo_nonota(+) = mstd_nodoc
                                        AND trbo_kodeigr(+) = mstd_kodeigr
                                        and trbo_prdcd(+) = mstd_prdcd
                                        and msth_nodoc in ($document)
                                        order by msth_nodoc");
            $pdf = PDF::loadview('BACKOFFICE.TRANSAKSI.PENERIMAAN.igr_bo_ctbtbnota', ['datas' => $datas, 're_print' => $re_print, 'ttd' => $ttd])->setPaper('a5', 'potrait');
            $pdf->output();
            $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);

            $path = 'receipts/';
            if (!File::exists(storage_path($path))) {
                File::makeDirectory(storage_path($path), 0755, true, true);
            }

            for ($i = 0; $i < sizeof($datas); $i++) {
                $content = $pdf->download()->getOriginalContent();
                $id = 'BTB_' . $datas[$i]->msth_nodoc . '_' . date("Ymd", strtotime($datas[$i]->msth_tgldoc));
                $file = storage_path($path . $id . '.PDF');
                file_put_contents($file, $content);
            }

            $path = 'receipts_backup/';
            $this->kirimServerCabang($path, $datas, $pdf, $report);

            return $pdf->stream($id . '.PDF');
        } else if ($report == 'IGR_BO_CTBTBNOTA_FULL') {
            $datas = DB::connection(Session::get('connection'))->select("select msth_recordid, msth_nodoc, msth_tgldoc, msth_nopo, msth_tglpo, msth_nofaktur, msth_tglfaktur, msth_cterm, msth_flagdoc, (mstd_tgldoc + msth_cterm) tgljt, mstd_cterm,
                                        prs_namaperusahaan, prs_namacabang, prs_alamat1, prs_alamat2, prs_alamat3,prs_npwp,
                                        sup_kodesupplier||' '||sup_namasupplier || '/' || sup_singkatansupplier supplier, sup_npwp, sup_alamatsupplier1 ||'   '||sup_alamatsupplier2 alamat_supplier,
                                        sup_telpsupplier, sup_contactperson contact_person, sup_kotasupplier3,
                                        mstd_prdcd||' '||prd_deskripsipanjang plu, mstd_unit||'/'||mstd_frac kemasan, floor(mstd_qty/mstd_frac) qty, mod(mstd_qty,mstd_frac) qtyk, mstd_typetrn,
                                        mstd_hrgsatuan, mstd_ppnrph, mstd_ppnbmrph, mstd_ppnbtlrph, nvl(mstd_gross,0)- nvl(mstd_discrph,0)+nvl(mstd_dis4cr,0)+ nvl(mstd_dis4rr,0)+nvl(mstd_dis4jr,0) jumlah,
                                        nvl(mstd_rphdisc1,0) as disc1,
                                        (nvl(mstd_rphdisc2,0) + nvl(mstd_rphdisc2ii,0) + nvl(mstd_rphdisc2iii,0) ) as disc2,
                                        nvl(mstd_rphdisc3,0) as disc3, nvl(mstd_qtybonus1,0) as bonus1, nvl(mstd_qtybonus2,0) as bonus2, nvl(mstd_keterangan,' ') as keterangan, (nvl(mstd_dis4cr,0) + nvl(mstd_dis4rr,0) + nvl(mstd_dis4jr,0)) as disc4,
                                        case when mstd_typetrn = 'B' then '( PEMBELIAN )' else '( LAIN - LAIN )' end judul, '0' || '$kodeigr' || mstd_nodoc barcode
                                        from tbtr_mstran_h, tbmaster_perusahaan, tbmaster_supplier, tbtr_mstran_d, tbmaster_prodmast, tbtr_backoffice
                                        where msth_kodeigr='$kodeigr'
                                        and prs_kodeigr=msth_kodeigr
                                        and sup_kodesupplier(+)=msth_kodesupplier
                                        and sup_kodeigr(+)=msth_kodeigr
                                        and mstd_nodoc=msth_nodoc
                                        and mstd_kodeigr=msth_kodeigr
                                        and prd_kodeigr=msth_kodeigr
                                        and prd_prdcd = mstd_prdcd
                                        AND trbo_nonota(+) = mstd_nodoc
                                        AND trbo_kodeigr(+) = mstd_kodeigr
                                        and trbo_prdcd(+) = mstd_prdcd
                                        and msth_nodoc in ($document)
                                        order by msth_nodoc");

            $pdf = PDF::loadview('BACKOFFICE.TRANSAKSI.PENERIMAAN.igr_bo_ctbtbnota_full', ['datas' => $datas, 're_print' => $re_print, 'ttd' => $ttd])->setPaper('a4', 'potrait');
            $pdf->output();
            $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);

            $path = 'receipts/';
            if (!File::exists(storage_path($path))) {
                File::makeDirectory(storage_path($path), 0755, true, true);
            }

            for ($i = 0; $i < sizeof($datas); $i++) {
                $content = $pdf->download()->getOriginalContent();
                $id = 'BTB_' . $datas[$i]->msth_nodoc . '_' . date("Ymd", strtotime($datas[$i]->msth_tgldoc));
                $file = storage_path($path . $id . '.PDF');
                file_put_contents($file, $content);
            }

            $path = 'receipts_backup/';
            $this->kirimServerCabang($path, $datas, $pdf, $report);

            return $pdf->stream($id . '.PDF');
        } else if ($report == 'lokasi') {
            $datas = DB::connection(Session::get('connection'))->select("SELECT trbo_prdcd,
                                       SUBSTR (prd_deskripsipanjang, 1, 50) desc2,
                                       prd_unit || '/' || prd_frac kemasan,
                                       lks_koderak,
                                       lks_kodesubrak,
                                       lks_tiperak,
                                       lks_shelvingrak,
                                       FLOOR (trbo_qty / prd_frac) qty,
                                       lks_koderak || lks_kodesubrak || lks_tiperak || lks_shelvingrak
                                          keterangan,
                                       MOD (trbo_qty, prd_frac) qtyk,
                                       prs_namaperusahaan,
                                       prs_namacabang,
                                       prs_namawilayah
                                  FROM tbtr_backoffice,
                                       tbmaster_lokasi,
                                       tbmaster_prodmast,
                                       tbmaster_perusahaan
                                 WHERE     prs_kodeigr = trbo_kodeigr
                                       AND trbo_kodeigr = '22'
                                       AND trbo_nodoc in ($document)
                                       --AND TRBO_NOREFF IN ('01400388')
                                       AND lks_prdcd = trbo_prdcd
                                       AND lks_kodeigr = trbo_kodeigr
                                       --and substr(lks_koderak,1,1) = 'a'
                                       AND prd_prdcd = trbo_prdcd
                                       AND prd_kodeigr = trbo_kodeigr");

            $pdf = PDF::loadview('BACKOFFICE.TRANSAKSI.PENERIMAAN.igr_bo_ctklokasi', ['datas' => $datas]);
            $pdf->output();
            $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);

            $canvas = $dompdf->get_canvas();
            $canvas->page_text(514, 10, "Page {PAGE_NUM} of {PAGE_COUNT}", null, 10, array(0, 0, 0));

            return $pdf->stream('igr_bo_ctklokasi.PDF');
        } else if ($report == 'IGR_BO_CTBTBNOTA_NONHARGA') {
            $datas = DB::connection(Session::get('connection'))->select("select msth_recordid, msth_nodoc, msth_tgldoc, msth_nopo, msth_tglpo, msth_nofaktur, msth_tglfaktur, msth_cterm, msth_flagdoc, (mstd_tgldoc + msth_cterm) tgljt, mstd_cterm,
            prs_namaperusahaan, prs_namacabang, prs_alamat1, prs_alamat2, prs_alamat3,prs_npwp,
            sup_kodesupplier||' '||sup_namasupplier || '/' || sup_singkatansupplier supplier, sup_npwp, sup_alamatsupplier1 ||'   '||sup_alamatsupplier2 alamat_supplier,
            sup_telpsupplier, sup_contactperson contact_person, sup_kotasupplier3,
            mstd_prdcd||' '||prd_deskripsipanjang plu, mstd_unit||'/'||mstd_frac kemasan, floor(mstd_qty/mstd_frac) qty, mod(mstd_qty,mstd_frac) qtyk, mstd_typetrn,
            mstd_hrgsatuan, mstd_ppnrph, mstd_ppnbmrph, mstd_ppnbtlrph, nvl(mstd_gross,0)- nvl(mstd_discrph,0)+nvl(mstd_dis4cr,0)+ nvl(mstd_dis4rr,0)+nvl(mstd_dis4jr,0) jumlah,
            nvl(mstd_rphdisc1,0) as disc1,
            (nvl(mstd_rphdisc2,0) + nvl(mstd_rphdisc2ii,0) + nvl(mstd_rphdisc2iii,0) ) as disc2,
            nvl(mstd_rphdisc3,0) as disc3, nvl(mstd_qtybonus1,0) as bonus1, nvl(mstd_qtybonus2,0) as bonus2, nvl(mstd_keterangan,' ') as keterangan, (nvl(mstd_dis4cr,0) + nvl(mstd_dis4rr,0) + nvl(mstd_dis4jr,0)) as disc4,
            case when mstd_typetrn = 'B' then '( PEMBELIAN )' else '( LAIN - LAIN )' end judul, '0' || '$kodeigr' || mstd_nodoc barcode
            from tbtr_mstran_h, tbmaster_perusahaan, tbmaster_supplier, tbtr_mstran_d, tbmaster_prodmast, tbtr_backoffice
            where msth_kodeigr='$kodeigr'
            and prs_kodeigr=msth_kodeigr
            and sup_kodesupplier(+)=msth_kodesupplier
            and sup_kodeigr(+)=msth_kodeigr
            and mstd_nodoc=msth_nodoc
            and mstd_kodeigr=msth_kodeigr
            and prd_kodeigr=msth_kodeigr
            and prd_prdcd = mstd_prdcd
            AND trbo_nonota(+) = mstd_nodoc
            AND trbo_kodeigr(+) = mstd_kodeigr
            and trbo_prdcd(+) = mstd_prdcd
            and msth_nodoc in ($document)
            order by msth_nodoc");

            $pdf = PDF::loadview('BACKOFFICE.TRANSAKSI.PENERIMAAN.igr_bo_ctbtbnota_nonharga', ['datas' => $datas, 're_print' => $re_print, 'ttd' => $ttd, 'signedby' => $signedBy])->setPaper('a4', 'potrait');
            $pdf->output();
            $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);

            $path = 'receipts_backup/';
            $type = 'BTB_NON_HARGA_';

            if (!File::exists(storage_path($path))) {
                File::makeDirectory(storage_path($path), 0755, true, true);
            }

            for ($i = 0; $i < sizeof($datas); $i++) {
                $content = $pdf->download()->getOriginalContent();
                $id = $type . $datas[$i]->msth_nodoc . '_' . date("Ymd", strtotime($datas[$i]->msth_tgldoc));
                $file = storage_path($path . $id . '.PDF');
                file_put_contents($file, $content);
            }

            return $pdf->stream($id . '.PDF');
        } else if ($report == 'IGR_BO_CTBTBNOTA_NONHARGA_FULL') {
            $datas = DB::connection(Session::get('connection'))->select("select msth_recordid, msth_nodoc, msth_tgldoc, msth_nopo, msth_tglpo, msth_nofaktur, msth_tglfaktur, msth_cterm, msth_flagdoc, (mstd_tgldoc + msth_cterm) tgljt, mstd_cterm,
            prs_namaperusahaan, prs_namacabang, prs_alamat1, prs_alamat2, prs_alamat3,prs_npwp,
            sup_kodesupplier||' '||sup_namasupplier || '/' || sup_singkatansupplier supplier, sup_npwp, sup_alamatsupplier1 ||'   '||sup_alamatsupplier2 alamat_supplier,
            sup_telpsupplier, sup_contactperson contact_person, sup_kotasupplier3,
            mstd_prdcd||' '||prd_deskripsipanjang plu, mstd_unit||'/'||mstd_frac kemasan, floor(mstd_qty/mstd_frac) qty, mod(mstd_qty,mstd_frac) qtyk, mstd_typetrn,
            mstd_hrgsatuan, mstd_ppnrph, mstd_ppnbmrph, mstd_ppnbtlrph, nvl(mstd_gross,0)- nvl(mstd_discrph,0)+nvl(mstd_dis4cr,0)+ nvl(mstd_dis4rr,0)+nvl(mstd_dis4jr,0) jumlah,
            nvl(mstd_rphdisc1,0) as disc1,
            (nvl(mstd_rphdisc2,0) + nvl(mstd_rphdisc2ii,0) + nvl(mstd_rphdisc2iii,0) ) as disc2,
            nvl(mstd_rphdisc3,0) as disc3, nvl(mstd_qtybonus1,0) as bonus1, nvl(mstd_qtybonus2,0) as bonus2, nvl(mstd_keterangan,' ') as keterangan, (nvl(mstd_dis4cr,0) + nvl(mstd_dis4rr,0) + nvl(mstd_dis4jr,0)) as disc4,
            case when mstd_typetrn = 'B' then '( PEMBELIAN )' else '( LAIN - LAIN )' end judul, '0' || '$kodeigr' || mstd_nodoc barcode
            from tbtr_mstran_h, tbmaster_perusahaan, tbmaster_supplier, tbtr_mstran_d, tbmaster_prodmast, tbtr_backoffice
            where msth_kodeigr='$kodeigr'
            and prs_kodeigr=msth_kodeigr
            and sup_kodesupplier(+)=msth_kodesupplier
            and sup_kodeigr(+)=msth_kodeigr
            and mstd_nodoc=msth_nodoc
            and mstd_kodeigr=msth_kodeigr
            and prd_kodeigr=msth_kodeigr
            and prd_prdcd = mstd_prdcd
            AND trbo_nonota(+) = mstd_nodoc
            AND trbo_kodeigr(+) = mstd_kodeigr
            and trbo_prdcd(+) = mstd_prdcd
            and msth_nodoc in ($document)
            order by msth_nodoc");

            $pdf = PDF::loadview('BACKOFFICE.TRANSAKSI.PENERIMAAN.igr_bo_ctbtbnota_nonharga_full', ['datas' => $datas, 're_print' => $re_print, 'ttd' => $ttd, 'signedby' => $signedBy])->setPaper('a4', 'potrait');
            $pdf->output();
            $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);

            for ($i = 0; $i < sizeof($datas); $i++) {
                $id = 'BTB_' . $datas[$i]->msth_nodoc . '_' . date("Ymd", strtotime($datas[$i]->msth_tgldoc));
            }

            $path = 'receipts_backup/';
            $type = 'BTB_NON_HARGA_';

            if (!File::exists(storage_path($path))) {
                File::makeDirectory(storage_path($path), 0755, true, true);
            }

            for ($i = 0; $i < sizeof($datas); $i++) {
                $content = $pdf->download()->getOriginalContent();
                $id = $type . $datas[$i]->msth_nodoc . '_' . date("Ymd", strtotime($datas[$i]->msth_tgldoc));
                $file = storage_path($path . $id . '.PDF');
                file_put_contents($file, $content);
            }

            return $pdf->stream($id . '.PDF');
        }

        // dd($report);
    }

    public function showUser()
    {
        $records =  DB::connection(Session::get('connection'))->select("SELECT DISTINCT USERNAME, USERLEVEL, USERID
                        FROM TBMASTER_USER");
        return DataTables::of($records)->make(true);
    }
}
