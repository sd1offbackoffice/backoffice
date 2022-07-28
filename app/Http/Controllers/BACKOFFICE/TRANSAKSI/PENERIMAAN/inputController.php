<?php

namespace App\Http\Controllers\BACKOFFICE\TRANSAKSI\PENERIMAAN;

use App\AllModel;
use App\Http\Controllers\Auth\loginController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;
use PDF;
use ZipArchive;

class inputController extends Controller
{
    public $getDataPlu;
    public $tempDataSave = [];
    public $tempPrdcdSave = [];
    public $tempTrbo  = [];
    public $param_cek;
    public $param_error;
    public $param_ndpp;
    public $param_rec = 0;
    public $param_seqno = 0;
    public $param_simpanData;

    public function index()
    {
        return view('BACKOFFICE.TRANSAKSI.PENERIMAAN.input');
    }

    public function showBTB(Request $request)
    {
        $kodeigr = Session::get('kdigr');
        $tipeTrn = $request->tipetrn;

        $data = DB::connection(Session::get('connection'))->select("SELECT DISTINCT TRBO_NODOC, TRBO_NOPO, TRBO_TGLREFF
                                    FROM TBTR_BACKOFFICE
                                    WHERE     TRBO_KODEIGR = '$kodeigr'
                                    AND TRBO_TYPETRN = '$tipeTrn'
                                    AND NVL (TRBO_NONOTA, 'AA') = 'AA'
                                    AND NVL (TRBO_RECORDID, '0') <> '1'
                                    ORDER BY TRBO_TGLREFF DESC");

        return DataTables::of($data)->make(true);
    }

    public function chooseBTB(Request $request)
    {
        $noDoc = $request->noDoc;
        $noPO = $request->noPO;
        $typeTrn = $request->typeTrn;
        $kodeigr = Session::get('kdigr');

        $temp = DB::connection(Session::get('connection'))->select("SELECT NVL (COUNT (1), 0) as temp
                                    FROM TBTR_BACKOFFICE
                                    WHERE TRBO_KODEIGR = '$kodeigr' AND TRBO_NODOC = '$noDoc' AND TRBO_NOPO = NVL('$noPO', '123') AND NVL(TRBO_RECORDID, '0') <> 1");

        if ($temp[0]->temp == '0') {
            $msg = "Nomor Dokumen Ini Sudah Terdapat di TBTR_BACKOFFICE";

            return response()->json(['kode' => 0, 'msg' => $msg, 'data' => '']);
        }

        $temp = DB::connection(Session::get('connection'))->select("SELECT NVL (COUNT (1), 0) as temp
                                    FROM TEMP_GO
                                    WHERE KODEIGR = '$kodeigr'
                                    AND ISI_TOKO = 'Y'
                                    AND TRUNC (SYSDATE-30) BETWEEN TRUNC (PER_AWAL_REORDER) AND TRUNC (PER_AKHIR_REORDER)");

        $flagGO = ($temp[0]->temp != '0') ? 'Y' : 'N';

        $temp = DB::connection(Session::get('connection'))->select("SELECT NVL (COUNT (*), 0) as temp
                                    FROM TBTR_BACKOFFICE
                                    WHERE TRBO_NODOC = '$noDoc' AND TRBO_KODEIGR = '$kodeigr' AND TRBO_TYPETRN = 'L'");

        if ($temp[0]->temp != '0') {
            $recId = DB::connection(Session::get('connection'))->select("SELECT DISTINCT TRBO_RECORDID
                                    FROM TBTR_BACKOFFICE
                                    WHERE TRBO_NODOC = '$noDoc'
                                    AND TRBO_KODEIGR = '$kodeigr'
                                    AND TRBO_TYPETRN = 'L'");

            if ($recId) {
                if ($recId[0]->trbo_recordid == '2') {
                    $msg = "Data BTB ini sudah Cetak NOTA, silakan dilihat di Menu INQUERY BTB";

                    return response()->json(['kode' => 0, 'msg' => $msg, 'data' => '']);
                }
            }
        }

        //      Program Unit "Check_btb" Tidak di pakai karena Pembuatan nomor dokumen baru sudah ada function tersendiri,
        //      dan kondisi dimana nomor dokumen tidak ada di tbtr_backoffice tidak bisa terpenuhi (Tidak ada inputan manual dari user),
        //      sehingga langsung menampilkan data dari tbtr_backoffice dengan query yang sepertinya buatan sendiri

        $data = DB::connection(Session::get('connection'))->select("SELECT a.*, b.prd_deskripsipanjang as barang, b.prd_unit, b.prd_frac as trbo_frac, b.prd_kodetag as trbo_kodetag, nvl(b.prd_flagbkp1, ' ') as trbo_bkp, c.sup_namasupplier,
                                    c.sup_pkp ,a.trbo_qty / b.prd_frac as qty, ( a.trbo_rphdisc1 + a.trbo_rphdisc2 + a.trbo_rphdisc2ii + a.trbo_rphdisc2iii + a.trbo_rphdisc3 + a.trbo_rphdisc4) as total_disc
                                    FROM tbtr_backoffice a
                                    LEFT JOIN tbmaster_prodmast b ON a.trbo_prdcd = b.prd_prdcd AND a.trbo_kodeigr = b.prd_kodeigr
                                    LEFT JOIN tbmaster_supplier c ON a.trbo_kodesupplier = c.sup_kodesupplier and a.trbo_kodeigr = c.sup_kodeigr
                                    WHERE trbo_kodeigr = '$kodeigr'
                                    AND trbo_typetrn = '$typeTrn'
                                    AND trbo_nodoc = '$noDoc'
                                    AND NVL (prd_deskripsipanjang, 'FLAG') <> 'FLAG'");


        if (!$data) {
            $msg = "Data tidak ada";

            return response()->json(['kode' => 0, 'msg' => $msg, 'data' => '']);
        } else {
            return response()->json(['kode' => 1, 'msg' => 'OKE', 'data' => $data]);
        }
    }

    public function getNewNoBTB(Request $request)
    {
        $typeTrn = $request->typeTrn;
        $kodeigr = Session::get('kdigr');
        $IP = str_replace('.', '0', SUBSTR(Session::get('ip'), -3));
        $connect = loginController::getConnectionProcedure();

        if ($typeTrn == 'B') {
            $query = oci_parse($connect, "BEGIN :ret := f_igr_get_nomorstadoc('$kodeigr','RTB','Nomor Reff BTB','$IP' || '0' ,6,FALSE); END;");
            oci_bind_by_name($query, ':ret', $result, 32);
            oci_execute($query);
        } else {
            $query = oci_parse($connect, "BEGIN :ret := f_igr_get_nomorstadoc('$kodeigr','RTL','Nomor Reff BTB Lain-Lain','$IP' || '1' ,6,FALSE); END;");
            oci_bind_by_name($query, ':ret', $result, 32);
            oci_execute($query);
        }

        return response()->json($result);
    }

    public function downloadNPD()
    {

        $connect = loginController::getConnectionProcedureKMY();
        $query = oci_parse($connect, "BEGIN sp_proses_trf_rte_npd_php(:p_sukses, :hasil); END;");
        oci_bind_by_name($query, ':p_sukses', $p_sukses, 32);
        oci_bind_by_name($query, ':hasil', $hasil, 100);
        oci_execute($query);

        if ($p_sukses == 'N') { //FALSE
            return response()->json(['kode' => '1', 'message' => $hasil, 'p_sukses' => $p_sukses]);
        } else {
            return response()->json(['kode' => '0', 'message' => 'Data NPD sudah di download', 'hasil' => $hasil]);
        }
    }

    public function showPO()
    {

        $kodeigr = Session::get('kdigr');
        $data = DB::connection(Session::get('connection'))->select("SELECT tpoh_nopo,
                                        tpoh_tglpo,
                                        tpoh_kodesupplier,
                                        sup_namasupplier
                                        FROM (SELECT    tpoh_nopo,
                                                        tpoh_tglpo,
                                                        TRUNC (tpoh_tglpo) + NVL (tpoh_jwpb, 0) tgl,
                                                        tpoh_kodesupplier,
                                                        sup_namasupplier
                                        FROM tbtr_po_h, tbmaster_supplier
                                        WHERE     tpoh_kodeigr = '$kodeigr'
                                        AND NVL (tpoh_recordid, '0') != '2'
                                        AND sup_kodesupplier = tpoh_kodesupplier
                                        AND sup_kodeigr = tpoh_kodeigr
                                        AND NVL (TRIM (tpoh_recordid), '0') != '2'
                                        AND NVL (TRIM (tpoh_recordid), '0') != '1')
                                        WHERE tgl > SYSDATE");

        return DataTables::of($data)->make(true);
    }

    public function showNPD()
    {
        $data = DB::connection('simkmy')->select("SELECT DISTINCT docno,
                                    pictgl,
                                    kirim,
                                    sup_namasupplier
                                    FROM tbhistory_npd_rte, tbmaster_supplier
                                    WHERE sup_kodesupplier = kirim");

        return DataTables::of($data)->make(true);
    }

    public function otorisasi(Request $request)
    {
        $otoUser = strtoupper($request->otoUser);
        $otoPass = strtoupper($request->otoPass);
        $noPO = strtoupper($request->noPO);
        $kodeigr = Session::get('kdigr');

        $user = DB::connection(Session::get('connection'))->select("SELECT USERID
        FROM  TBMASTER_USER
        WHERE USERID = '$otoUser'");
        if (!isset($user)) {
            return response()->json(['kode' => 0, 'msg' => 'User tidak ditemukan']);
        } else {
            $username = $user[0]->userid;
            $pass = DB::connection(Session::get('connection'))->select("SELECT USERID, USERPASSWORD
            FROM  TBMASTER_USER
            WHERE USERID = '$username'
            AND   USERPASSWORD = '$otoPass'");
            if (!isset($pass)) {
                return response()->json(['kode' => 0, 'msg' => 'User tidak ditemukan']);
            } else {
                $result = DB::connection(Session::get('connection'))->select("SELECT USERLEVEL
                FROM  TBMASTER_USER
                WHERE USERID = '$otoUser'
                AND   USERPASSWORD = '$otoPass'");

                if ($result[0]->userlevel == 1) {
                    try {
                        DB::connection(Session::get('connection'))->table('tbtr_po_d')
                            ->where('tpod_kodeigr', $kodeigr)->where('tpod_nopo', $noPO)
                            ->update(['tpod_recordid' => 2]);

                        DB::connection(Session::get('connection'))->table('tbtr_po_h')
                            ->where('tpoh_nopo', $noPO)
                            ->update(['tpoh_recordid' => 2]);

                        return response()->json(['kode' => 0, 'msg' => 'Otorisasi Sukses']);
                    } catch (Exception $e) {
                        return response()->json(['kode' => 1, 'msg' => $e]);
                    }
                } else {
                    return response()->json(['kode' => 1, 'msg' => 'Kode Otorisasi MGR Tidak Terdaftar !!']);
                }
            }
        }
    }

    public function printGagalBPB(Request $request)
    {
        $url = $request->url;
        $nopo = $request->po;
        $nobtb = $request->btbno;
        $kodeigr = Session::get('kdigr');

        $data = DB::connection(Session::get('connection'))->select("SELECT
        tpoh_kodesupplier AS code,
        sup_namasupplier AS sup_name
        FROM (SELECT    tpoh_nopo,
                        tpoh_tglpo,
                        TRUNC (tpoh_tglpo) + NVL (tpoh_jwpb, 0) tgl,
                        tpoh_kodesupplier,
                        sup_namasupplier
        FROM tbtr_po_h, tbmaster_supplier
        WHERE     tpoh_kodeigr = '$kodeigr'
        AND     tpoh_nopo = '$nopo'
        AND NVL (tpoh_recordid, '0') != '2'
        AND sup_kodesupplier = tpoh_kodesupplier
        AND sup_kodeigr = tpoh_kodeigr
        AND NVL (TRIM (tpoh_recordid), '0') != '2'
        AND NVL (TRIM (tpoh_recordid), '0') != '1')
        WHERE tgl > SYSDATE");

        $tokoigr = DB::connection(Session::get('connection'))->select("SELECT
        cab_namacabang AS toko
        FROM tbmaster_cabang
        WHERE cab_kodecabang = '$kodeigr'");

        $pdf = PDF::loadview('BACKOFFICE.TRANSAKSI.PENERIMAAN.' . $url, ['noBTB' => $nobtb, 'code' => $data[0]->code, 'name' => $data[0]->sup_name, 'date' => Carbon::now()->format('Ymd'), 'kodeigr' => $kodeigr, 'toko' => $tokoigr[0]->toko]);
        $pdf->output();
        $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);

        $canvas = $dompdf->get_canvas();
        $canvas->page_text(514, 10, "Page {PAGE_NUM} of {PAGE_COUNT}", null, 10, array(0, 0, 0));

        return $pdf->stream($url . '.PDF');
    }

    public function choosePO(Request $request)
    {
        $simpanData = 'Y';
        $batal = 'N';
        $rte = $request->rte ? $request->rte : 'N';
        $bread = 'N';
        if ($rte == 'Y') {
            $bpb = 'N';
        } else {
            $bpb = 'Y';
        }
        $temp = 0;
        $temp1 = 0;
        $temp2 = 0;
        $recid = '';
        $wkpo = 0;
        $tglpo = Carbon::now()->format('Ymd');
        $sysdate = Carbon::now()->format('Ymd');
        $awalgo = '';
        $akhirgo = '';
        $lotorisasi = false;
        $flaggo = 'N';
        $typeTrn = $request->typeTrn;
        $noPO = $request->noPo;
        $kodeigr = Session::get('kdigr');

        $temp1 = DB::connection(Session::get('connection'))->select("SELECT NVL (COUNT (1), 0) as temp1
                FROM  TBTR_BACKOFFICE
                WHERE TRBO_KODEIGR = '$kodeigr'
                AND   TRBO_NOPO = NVL ('$noPO', '123')
                AND   NVL (TRBO_RECORDID, '0') <> 1");

        $temp2 = DB::connection(Session::get('connection'))->select("SELECT NVL (COUNT (1), 0) as temp2
                FROM  TBTR_MSTRAN_D
                WHERE MSTD_KODEIGR = '$kodeigr'
                AND   MSTD_NOPO = NVL ('$noPO', '123')
                AND   MSTD_TYPETRN = 'B'
                AND   NVL (MSTD_RECORDID, '0') <> 1");

        if ($temp1[0]->temp1 != 0 || $temp2[0]->temp2 != 0) {
            $msg = "Nomor Dokumen Ini Sudah Terdapat di TBTR_BACKOFFICE / TBTR_MSTRAN_D";

            return response()->json(['kode' => 0, 'msg' => $msg, 'data' => '']);
        } else {
            if ($noPO == null || $noPO == '') {
                $msg = "Nomor PO Kosong";

                return response()->json(['kode' => 0, 'msg' => $msg, 'data' => '']);
            } else {
                if ($rte == 'Y') {
                    $batal = 'N';
                    $temp = DB::connection('simkmy')->select("SELECT NVL (COUNT (1), 0) as temp
                        FROM  TBHISTORY_NPD_RTE
                        WHERE docno = '$noPO'");
                    if ($temp[0]->temp == 0) {
                        $msg = "No NPD Tidak Ada, Berita Acara Gagal Proses akan dikirimkan ke email EDP !!";
                        $batal = 'N';
                        $connect = loginController::getConnectionProcedure();
                        try {
                            $query = oci_parse($connect, "BEGIN SP_MAIL_BAG('$noPO'");
                            oci_execute($query);
                        } catch (Exception $e) {
                            return response()->json(['kode' => 0, 'msg' => $e, 'data' => '']);
                        }
                        return response()->json(['kode' => 3, 'url' => 'IGR_BO_GAGAL_BPB', 'nopo' => $noPO]);
                    }
                    $temp1 = DB::connection('simkmy')->select("SELECT NVL (COUNT (1), 0) as temp
                                FROM  TBHISTORY_NPD_RTE
                                WHERE docno = '$noPO'
                                AND NVL (TRIM (no_bpb), '0') = '0'");
                    if ($temp1[0]->temp == 0) {
                        $msg = "No NPD Tidak Terdaftar / Kuantitas NPD sudah dipenuhi";

                        $batal = 'N';
                        return response()->json(['kode' => 0, 'msg' => $msg, 'data' => '']);
                    } else {
                        return $this->checkPO($flaggo, $typeTrn, $noPO, $kodeigr, $rte);
                    }
                    // } else if ($bread == 'Y') {
                    //     $batal = 'Y';
                    //     $temp = DB::connection(Session::get('connection'))->select("SELECT NVL (COUNT (1), 0) as temp
                    //                 FROM  tbtr_mbgi
                    //                 WHERE mbg_nosj  = '$noPO'
                    //                 AND NVL (TRIM (mbg_nobpb, '0') = '0'");
                    //     if ($temp[0]->temp == 0) {
                    //         $msg = "No MBGI Tidak Terdaftar / Kuantitas MBGI sudah dipenuhi";

                    //         $batal = 'N';
                    //         return response()->json(['kode' => 0, 'msg' => $msg, 'data' => '']);
                    //     } else {
                    //         $this->checkPO($flaggo, $typeTrn, $noPO, $kodeigr, $rte);
                    //     }
                } else if ($bpb == 'Y') {
                    $batal = 'Y';
                    $temp = DB::connection(Session::get('connection'))->select("SELECT NVL (COUNT (1), 0) as temp
                                FROM  TBTR_PO_H
                                WHERE TPOH_NOPO = '$noPO'
                                AND TPOH_KODEIGR = '$kodeigr'
                                AND NVL (TRIM (TPOH_RECORDID), '0') != '2'
                                AND NVL (TRIM (TPOH_RECORDID), '0') != '1'");
                    if ($temp[0]->temp == 0) {
                        $msg = "No PO Tidak Terdaftar / Kuantitas PO sudah dipenuhi";
                        $batal = 'N';
                        return response()->json(['kode' => 0, 'msg' => $msg, 'data' => '']);
                    } else {
                        //penambahan untuk penerimaan GO
                        if ($flaggo == 'Y') {
                            $temp = DB::connection(Session::get('connection'))->select("SELECT PER_AWAL_REORDER AS AWALGO, PER_AKHIR_REORDER AS AKHIRGO
                                    FROM  TEMP_GO
                                    WHERE KODEIGR = '$kodeigr'
                                    AND   ISI_TOKO = 'Y'
                                    AND   TRUNC (SYSDATE) BETWEEN TRUNC (PER_AWAL_REORDER) AND TRUNC (PER_AKHIR_REORDER)");

                            $awalgo = $temp[0]->awalgo;
                            $akhirgo = $temp[0]->akhirgo;

                            $temp1 = DB::connection(Session::get('connection'))->select("SELECT NVL (COUNT (1), 0) AS temp1
                                    FROM  TBTR_PO_D
                                    WHERE TBTR_PO_D = '$noPO'
                                    AND   TBTR_PO_D = '$kodeigr'
                                    AND   NVL (TRIM (TPOD_QTYPB), 0) = 0
                                    AND   NVL (TRIM (TPOD_RECORDID), '0') != '1'");
                            if ($temp1[0]->temp1 == 0) {
                                $msg = "Kuantitas PO sudah dipenuhi Semua";
                                $batal = 'N';
                                return response()->json(['kode' => 0, 'msg' => $msg, 'data' => '']);
                            } else {
                                if ($recid == 'X') {
                                    $msg = "PO Sedang Dipakai di DCP";
                                    $batal = 'N';
                                    return response()->json(['kode' => 0, 'msg' => $msg, 'data' => '']);
                                    /* front end
                                    SET_ITEM_PROPERTY ('KD_SUPPLIER',
                                                    ENABLED,
                                                    PROPERTY_FALSE);
                                    SET_ITEM_PROPERTY ('NO_FAKTUR',
                                                    ENABLED,
                                                    PROPERTY_FALSE);
                                    SET_ITEM_PROPERTY ('TGL_FAKTUR',
                                                    ENABLED,
                                                    PROPERTY_FALSE);
                                    SET_ITEM_PROPERTY ('I_PRDCD',
                                                    ENABLED,
                                                    PROPERTY_FALSE);
                                    :NO_PO := NULL;
                                    */
                                } else {
                                    $temp = DB::connection(Session::get('connection'))->select("SELECT TPOH_TGLPO as TGLPO, TPOH_JWPB as WKPO,
                                    FROM  TBTR_PO_H
                                        WHERE TPOH_NOPO  = '$noPO'
                                        AND   TPOH_KODEIGR  = '$kodeigr'");

                                    $tglpo = date_create($temp[0]->tglpo);
                                    $wkpo = $temp[0]->wkpo . " days";
                                    date_add($tglpo, date_interval_create_from_date_string($wkpo));
                                    $sysdate = date_create($sysdate);
                                    date_sub($sysdate, date_interval_create_from_date_string("1 day"));

                                    if (!(($tglpo >= $awalgo) && ($tglpo <= $akhirgo))) {
                                        $msg = "Umur P.O. untuk GO sudah melampaui Tanggal hari ini";
                                        $lotorisasi = true;

                                        return response()->json(['kode' => 0, 'msg' => $msg, 'data' => '']);
                                    } else {
                                        $diff = date_diff(date_create($temp[0]->tglpo), date_create($sysdate));

                                        if ($diff->d > 7) {
                                            $msg = "Tanggal P.O. sudah melampaui 1 minggu";
                                            $lotorisasi = true;

                                            return response()->json(['kode' => 0, 'msg' => $msg, 'data' => '']);
                                        }
                                    }

                                    if ($lotorisasi == true) {
                                        $msg = "Show Lotorisasi";

                                        return response()->json(['kode' => 0, 'msg' => $msg, 'data' => '']);
                                    } else {
                                        return $this->checkPO($flaggo, $typeTrn, $noPO, $kodeigr, $rte);
                                    }
                                }
                            }
                        } else { //else flaggo
                            $temp = DB::connection(Session::get('connection'))->select("SELECT NVL (TPOH_RECORDID, 0) AS RECID, TPOH_TGLPO AS TGLPO, TPOH_JWPB AS WKPO
                            FROM TBTR_PO_H
                                WHERE TPOH_NOPO = '$noPO'
                                AND  TPOH_KODEIGR = '$kodeigr'");

                            if ($temp[0]->recid == 2) {
                                $msg = "Kuantitas PO sudah dipenuhi";
                                $batal = 'N';
                                return response()->json(['kode' => 0, 'msg' => $msg, 'data' => '']);
                            } else {
                                if ($temp[0]->recid == 'X') {
                                    $msg = "PO Sedang Dipakai di DCP";
                                    $batal = 'N';
                                    /* front end
                                    SET_ITEM_PROPERTY ('KD_SUPPLIER',
                                                    ENABLED,
                                                    PROPERTY_FALSE);
                                    SET_ITEM_PROPERTY ('NO_FAKTUR',
                                                    ENABLED,
                                                    PROPERTY_FALSE);
                                    SET_ITEM_PROPERTY ('TGL_FAKTUR',
                                                    ENABLED,
                                                    PROPERTY_FALSE);
                                    SET_ITEM_PROPERTY ('I_PRDCD',
                                                    ENABLED,
                                                    PROPERTY_FALSE);
                                    */
                                    return response()->json(['kode' => 0, 'msg' => $msg, 'data' => '']);
                                } else {
                                    $tglpo = date_create($temp[0]->tglpo);
                                    $wkpo = $temp[0]->wkpo . " days";
                                    date_add($tglpo, date_interval_create_from_date_string($wkpo));
                                    $sysdate = date_create($sysdate);
                                    date_sub($sysdate, date_interval_create_from_date_string("1 day"));

                                    if ($tglpo < $sysdate) {
                                        $msg = "Umur P.O. sudah melampaui Tanggal hari ini";
                                        $lotorisasi = true;
                                    } else {
                                        $tglpo = date_create($temp[0]->tglpo);
                                        $diff = date_diff($tglpo, $sysdate);

                                        if ($diff->d > 7) {
                                            $msg = "Tanggal P.O. sudah melampaui 1 minggu";
                                            $lotorisasi = true;
                                        }
                                    }

                                    if ($lotorisasi == true) {
                                        $data = "Lotorisasi";

                                        return response()->json(['kode' => 0, 'msg' => $msg, 'data' => $data]);
                                    } else {
                                        return $this->checkPO($flaggo, $typeTrn, $noPO, $kodeigr, $rte);
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    public function checkPO($flaggo, $typeTrn, $noPO, $kodeigr, $rte)
    {
        if ($rte == 'Y') {
            $bpb = 'N';
        } else {
            $bpb = 'Y';
        }
        $temp = 0;
        $recid = '';

        if ($typeTrn == 'L' && $noPO != null) {
            $msg = "Nomor PO tidak boleh diisi";
            return response()->json(['kode' => 0, 'msg' => $msg, 'data' => '']);
        }

        if ($rte == 'Y') {
            $poh = DB::connection('simkmy')->select("SELECT docno, tanggal1, kirim, sup_namasupplier, sup_pkp
                FROM TBHISTORY_NPD_RTE, tbmaster_supplier
                WHERE docno = '$noPO'
                AND sup_kodesupplier = kirim
                AND sup_kodeigr = SUBSTR (toko, 3, 2)");
            return response()->json(['kode' => 1, 'msg' => 'RTE', 'data' => $poh[0]]);
        }

        if ($bpb == 'Y') {
            if ($flaggo == 'Y') {
                $temp = DB::connection(Session::get('connection'))->select("SELECT tpoh_tglpo as tglpo, tpoh_jwpb as wkpo, NVL (TRIM(tpoh_recordid), '0') recid
                                                    FROM tbtr_po_h
                                                    WHERE tpoh_nopo = '$noPO' AND tpoh_kodeigr = '$kodeigr'");

                if (!$temp) {
                    $msg = "No PO Tidak Terdaftar / Kuantitas PO sudah dipenuhi";
                    return (['kode' => 0, 'msg' => $msg, 'data' => '']);
                }
            } else {
                $temp = DB::connection(Session::get('connection'))->select("SELECT tpoh_tglpo, tpoh_jwpb, NVL (TRIM(tpoh_recordid), '0') as recid
                                                    FROM tbtr_po_h
                                                    WHERE tpoh_nopo = '$noPO'
                                                    AND tpoh_kodeigr = '$kodeigr'
                                                    AND NVL (TRIM(tpoh_recordid), '0') != '2'");

                if (!$temp) {
                    $msg = "No PO Tidak Terdaftar / Kuantitas PO sudah dipenuhi";
                    return response()->json(['kode' => 0, 'msg' => $msg, 'data' => '']);
                }
                $recid = $temp[0]->recid;

                if ($recid == '2') {
                    $msg = "Kuantitas PO sudah dipenuhi";
                    return response()->json(['kode' => 0, 'msg' => $msg, 'data' => '']);
                }
                $temp = DB::connection(Session::get('connection'))->select("SELECT tpoh_nopo, tpoh_tglpo, tpoh_kodesupplier, sup_namasupplier, sup_singkatansupplier, tpoh_top, sup_pkp
                FROM tbtr_po_h, tbmaster_supplier
                WHERE tpoh_nopo = '$noPO'
                AND tpoh_kodeigr = '$kodeigr'
                AND sup_kodesupplier = tpoh_kodesupplier
                AND sup_kodeigr = tpoh_kodeigr");

                return response()->json(['kode' => 1, 'msg' => 'BPB', 'data' => $temp[0]]);
            }
        }
        //        ------------------ Update RecID menjadi 2, di komen karena di browser gk bisa update otomatis ke null ketika page ditutup
        //                DB::connection(Session::get('connection'))->table('tbtr_po_h')->where('tpoh_nopo', $noPO)->update(['tpoh_recordid' => 2]);
        //                DB::connection(Session::get('connection'))->table('tbtr_po_d')->where('tpod_nopo', $noPO)->update(['tpod_recordid' => 2]);
    }

    public function showSupplier()
    {
        $kodeigr = Session::get('kdigr');

        $data = DB::connection(Session::get('connection'))->select("select distinct sup_namasupplier || '/' || sup_Singkatansupplier sup_namasupplier, sup_kodesupplier, sup_pkp, sup_top
                                    from tbmaster_supplier
                                    where sup_kodeigr='$kodeigr'");

        return DataTables::of($data)->make(true);
    }

    public function showSupplierRTE()
    {
        $data = DB::connection('simkmy')->select("SELECT docno, tanggal1, kirim, sup_namasupplier, sup_kodesupplier, sup_pkp, sup_top
        FROM TBHISTORY_NPD_RTE, tbmaster_supplier
        WHERE sup_kodesupplier = kirim
        AND sup_kodeigr = SUBSTR (toko, 3, 2)");

        return DataTables::of($data)->make(true);
    }

    public function checkkodeSupplier(Request  $request)
    {
        sleep(1);
        $kodeSupplier = $request->kodeSupplier;
        $kodeigr = Session::get('kdigr');

        $data = DB::select("SELECT SUP_NAMASUPPLIER || '/' || SUP_SINGKATANSUPPLIER SUPPLIER, SUP_TOP, SUP_PKP
	                            FROM TBMASTER_SUPPLIER
	                            WHERE SUP_KODESUPPLIER = '$kodeSupplier' AND SUP_KODEIGR = '$kodeigr'");

        if ($data) {
            return response()->json(['kode' => 1, 'message' => "Supplier Terdaftar", 'data' => $data[0]]);
        } else {
            return response()->json(['kode' => 0, 'message' => "Supplier Tidak Terdaftar", 'data' => '']);
        }
    }

    public function showPlu(Request $request)
    {
        $typeTrn = $request->typeTrn;
        $kodeigr = Session::get('kdigr');
        $value = strtoupper($request->value);
        $supplier = $request->supplier;
        $noPo = $request->noPo;
        $typeLov = $request->typeLov;

        if ($typeLov == 'PLU') {
            // $data = DB::connection(Session::get('connection'))->table('tbmaster_prodmast')
            //     ->select('prd_deskripsipanjang', 'prd_prdcd')
            //     ->join('tbmaster_stock', function ($join) {
            //         $join->on("st_prdcd", "prd_prdcd");
            //         $join->on("st_kodeigr", "prd_kodeigr");
            //     })
            //     ->where('prd_kodesupplier', $supplier)
            //     ->where('st_kodeigr', $kodeigr)
            //     ->where('st_lokasi', '01')
            //     ->whereNotNull('st_avgcost')
            //     ->whereRaw("(prd_deskripsipanjang LIKE '%$value%' or prd_prdcd LIKE '%$value%')")
            //     ->get()->toArray();
            $data = DB::connection(Session::get('connection'))->table('TBMASTER_PRODMAST')
                ->select('PRD_PRDCD', 'PRD_DESKRIPSIPANJANG')
                ->join('TBMASTER_STOCK', function ($join) {
                    $join->on('ST_PRDCD', 'PRD_PRDCD');
                    $join->on('ST_KODEIGR', 'PRD_KODEIGR');
                })
                ->where('ST_KODEIGR', $kodeigr)
                ->where('ST_LOKASI', '01')
                ->where('ST_SALDOAKHIR', '>', 0)
                ->whereNotNull('ST_AVGCOST')
                ->whereRaw("(PRD_KODETAG != 'T' AND PRD_KODETAG != 'G' AND PRD_KODETAG != 'Q')")
                ->get()->toArray();
        } else if ($typeLov == 'PLU_PO') {
            $data = DB::connection(Session::get('connection'))->select("select prd_deskripsipanjang, tpod_prdcd, prd_unit||'/'||prd_frac kemasan,
                                            floor(tpod_qtypo/prd_frac) qty,mod(tpod_qtypo,prd_frac) qtyk,
                                            tpod_bonuspo1 bonus1, tpod_bonuspo2 bonus2,
                                            TPOD_PERSENTASEDISC1, TPOD_RPHDISC1,
                                            TPOD_PERSENTASEDISC2, TPOD_RPHDISC2,
                                            TPOD_PERSENTASEDISC3, TPOD_RPHDISC3,
                                            TPOD_RPHDISC4,tpod_nopo
                                            FROM tbtr_po_d, tbmaster_prodmast
                                            WHERE tpod_nopo='$noPo'
                                            AND tpod_kodeigr='$kodeigr'
                                            AND prd_prdcd = tpod_prdcd
                                            AND prd_kodeigr=tpod_kodeigr
                                            AND (prd_deskripsipanjang LIKE '%$value%' or prd_prdcd LIKE '%$value%')");
        } else if ($typeLov == 'LOV155') {
            $data = DB::connection(Session::get('connection'))->table('tbmaster_prodmast')
                ->select('prd_deskripsipanjang', 'prd_prdcd')
                ->join('tbmaster_stock', function ($join) {
                    $join->on("st_prdcd", "prd_prdcd");
                    $join->on("st_kodeigr", "prd_kodeigr");
                })
                ->where('st_kodeigr', $kodeigr)
                ->where('st_lokasi', '01')
                ->whereNotNull('st_avgcost')
                ->whereRaw("(prd_deskripsipanjang LIKE '%$value%' or prd_prdcd LIKE '%$value%')")
                ->limit(100)
                ->get()->toArray();
        } else if ($typeLov == 'RTE') {
            $data = DB::connection('simkmy')->select("SELECT prd_deskripsipanjang, prd_prdcd, prdcd, prd_unit||'/'||prd_frac kemasan,
            floor(sj_qty/prd_frac) qty,mod(sj_qty,prd_frac) qtyk, docno
                    FROM TBHISTORY_NPD_RTE, tbmaster_prodmast
                    WHERE docno = '$noPo'
                    AND kirim = '$supplier'
                    AND substr(toko, 3, 2)='18'
                    AND prd_plumcg = prdcd
                    AND prd_kodeigr=substr(toko, 3, 2)
                    AND prd_prdcd LIKE '%0'
                    ORDER BY prd_prdcd");
        }
        return response()->json($data);
    }

    public function choosePlu(Request $request)
    {
        $typeTrn = $request->typeTrn;
        $prdcd = $request->prdcd;
        $noDoc = $request->noDoc;
        $noPo = $request->noPo;
        $supplier = $request->supplier;
        $tempData = $request->tempData;
        $rte = $request->rte;
        $kodeigr = Session::get('kdigr');

        if ($rte == 'Y') {
            $data = DB::connection('simkmy')->select("SELECT sj_qty as i_qtyk, ppnrp, nama_file, price, gross as i_gross, prd_prdcd as i_prdcd, nama, div, rtype
                FROM tbhistory_npd_rte, tbmaster_prodmast
                WHERE prdcd = '$prdcd'
                AND prd_plumcg = '$prdcd'
                AND docno = '$noPo'");
            return response()->json(['kode' => 0, 'msg' => 'Data RTE', 'data' => $data[0]]);
        } else if ($rte == 'N') {
            $this->tempDataSave = $tempData;

            $this->param_cek = 'Y';

            $temp1 = DB::connection(Session::get('connection'))->select("SELECT NVL (COUNT (1), 0) as temp1
                                        FROM TBTR_BACKOFFICE
                                        WHERE TRBO_KODEIGR = '$kodeigr' AND TRBO_NODOC = '$noDoc' AND TRBO_NOPO = NVL('$noPo', '123') AND TRBO_PRDCD = '$prdcd'
                                        AND NVL(TRBO_RECORDID, '0') <> 1");

            $temp2 = DB::connection(Session::get('connection'))->select("SELECT NVL (COUNT (1), 0) as temp2
                                        FROM TBTR_MSTRAN_D
                                        WHERE MSTD_KODEIGR = '$kodeigr' AND MSTD_NOPO = NVL('$noPo', '123') AND MSTD_TYPETRN = 'B'
                                        AND MSTD_PRDCD = '$prdcd' AND NVL(MSTD_RECORDID, '0') <> 1");

            if ($temp2[0]->temp2 != '0') {
                $msg = "PLU Sudah di BTB !!";

                return response()->json(['kode' => 2, 'msg' => $msg, 'data' => '']);
            }

            if ($noPo != '' || $noPo) {
                $temp = DB::connection(Session::get('connection'))->select(" SELECT NVL (TPOH_RECORDID, 0) as recid
                                        FROM TBTR_PO_H
                                        WHERE TPOH_NOPO = '$noPo' AND TPOH_KODEIGR = '$kodeigr'");

                if ($temp[0]->recid == 'X') {
                    $msg = "PO Sedang Dipakai di DCP";

                    return response()->json(['kode' => 2, 'msg' => $msg, 'data' => '']);
                }
            }

            //        CHECK PLU KE TEMP DATA YG UDH DI SAVE SEMENTARA
            if ($tempData) {
                for ($i = 0; $i < sizeof($tempData); $i++) {
                    if ($tempData[$i]['trbo_prdcd'] == $prdcd) {
                        $msg = "PLU " . $prdcd . " Sudah Ada, Silakan Edit !!";

                        return response()->json(['kode' => 2, 'msg' => $msg, 'data' => $prdcd]);
                    }
                }
            }

            if (!$noPo && $prdcd) {
                if ($typeTrn != 'L') {
                    $I_FLAGDISC1 = 'K';
                    $I_FLAGDISC2 = 'K';
                    $I_FLAGDISC3 = 'K';
                    $I_FLAGDISC4 = 'K';
                } else {
                    $I_FLAGDISC1 = '';
                    $I_FLAGDISC2 = '';
                    $I_FLAGDISC3 = '';
                    $I_FLAGDISC4 = '';
                }

                $getItemData = $this->getItemData($supplier, $prdcd, $kodeigr, $typeTrn, $noPo);

                if ($getItemData[0] == '0') {
                    $getItemData[2]->i_flagdisc1 = $I_FLAGDISC1;
                    $getItemData[2]->i_flagdisc2 = $I_FLAGDISC2;
                    $getItemData[2]->i_flagdisc3 = $I_FLAGDISC3;
                    $getItemData[2]->i_flagdisc4 = $I_FLAGDISC4;

                    $this->getDataPlu = $getItemData[2];
                } else {
                    return response()->json(['kode' => $getItemData[0], 'msg' => $getItemData[1], 'data' => $getItemData[2]]);
                }
            } else {
                //            Proses looping data dari tbtr_backoffice disini dipindahkan ke bagian JS, mengambil data dari tempData yg didapatkan dari chooseBTB()
                //            Dalam proses looping ada pembuatan status 0 atau 1, disini otomatis menjadi 0 sehingga langung memanggil GET_PO_DETAIL
                $getPODetail = $this->getPODetail($noPo, $kodeigr, $prdcd);
                if ($getPODetail[0] == 2) {
                    return response()->json(['kode' => $getPODetail[0], 'msg' => $getPODetail[1], 'data' => $getPODetail[2]]);
                }

                $this->getDataPlu = $getPODetail[2];
            }

            $chkGets = $this->chkGets(1, $prdcd, $kodeigr, $supplier, $noPo);

            return response()->json(['kode' => $chkGets['kode'], 'msg' => $chkGets['msg'], 'data' => $this->getDataPlu]);
        }
    }

    public function getItemData($supplier, $prdcd, $kodeigr, $typeTrn, $noPo)
    {
        if ($prdcd || $prdcd != null) {
            $data = $this->query1($supplier, $prdcd, $kodeigr);

            if (!$data) {
                return (['2', "PLU " . $prdcd . " tidak sesuai kategori-nya", ""]);
            }

            $data = $data[0];

            if ($data->i_unit == 'KG') {
                $data->i_frac = 1;
            }

            if ($typeTrn == 'L') {
                $data->i_persendis1 = 0;
                $data->i_rphdisc1 = 0;
                $data->i_persendis2 = 0;
                $data->i_rphdisc2 = 0;
                $data->i_persendis2a = 0;
                $data->i_rphdisc2a = 0;
                $data->i_persendis2b = 0;
                $data->i_rphdisc2b = 0;
                $data->i_persendis3 = 0;
                $data->i_rphdisc3 = 0;
                $data->i_persendis4 = 0;
                $data->i_rphdisc4 = 0;
            }

            if (!$data->kttk && !$data->kcab) {
                return (['2', "PLU " . $prdcd . " tidak sesuai kategori-nya", ""]);
            }

            if ($data->i_tag) {
                if ($data->i_tag != 'T' && $data->i_tag != 'G' && $data->i_tag != 'Q' && $data->i_tag != 'U') {
                    if ($data->ftftbo == 'Y') {
                        return (['2', "PLU " . $prdcd . " DISCONTINUE ( Flag Tidak Boleh Order )", ""]);
                    }

                    if ($data->ftftbo == 'Y' && !$noPo && $supplier) {
                        return (['2', "PLU " . $prdcd . " harus menggunakan PO", ""]);
                    }
                }
            }

            if ($data->v_lastcost > 0 && $data->st_prdcd) {
                $ndivcost = abs($data->v_lastcost - ($data->i_acost * $data->i_frac)) / $data->v_lastcost;

                if ($ndivcost >= '0.20') {
                    return (['2', "Selisih cost terlalu besar", ""]);
                }
            }

            if (!$noPo && !$supplier && $data->st_saldoakhir <= 0) {
                return (['2', "Stok Barang <= 0, tidak dapat menginput BPB Lain Lain ( " . $prdcd . " )", ""]);
            }

            if ($data->i_unit == 'KG') {
                $data->i_frac = '1';
            }

            $data->i_kemasan = $data->i_unit . ' / ' . $data->i_frac;

            if (!$noPo && !$supplier) {
                $data->i_hrgbeli = 0;
            } else {
                $data->i_hrgbeli = ($data->v_hrgbeli * $data->i_frac) / (($data->i_unit == 'KG') ? 1000 : 1);
            }


            $data->i_lcost = $data->v_lastcost;

            if (!($data->i_barang)) {
                return (['2', "Item Tidak Terdaftar", $data]);
            }
        }

        return (['0', "", $data]);
    }

    public function query1($supplier, $prdcd, $kodeigr)
    {
        $data = DB::connection(Session::get('connection'))->select("SELECT prd_kodeigr as i_kodeigr,
                                        prd_kodedivisi as i_kodedivisi,
                                        prd_kodedepartement as i_kodedepartement,
                                        prd_kodekategoribarang as i_kodekategoribrg,
                                        st_avgcost as i_acost,
                                        prd_lastcost as i_lcost,
                                        prd_deskripsipanjang as i_barang,
                                        prd_frac as i_frac,
                                        prd_flagbkp1 || '/' || prd_flagbkp2 as i_bkp,
                                        prd_unit as i_unit,
                                        prd_kodetag as i_tag,
                                        sup_pkp as i_pkp,
                                        prd_ppn as i_ppn_persen,
                                        hgb_hrgbeli as v_hrgbeli,
                                        hgb_persendisc01 as i_persendis1,
                                        hgb_rphdisc01 as i_rphdisc1,
                                        hgb_persendisc02 as i_persendis2,
                                        hgb_rphdisc02 as i_rphdisc2,
                                        hgb_persendisc02ii as i_persendis2a,
                                        hgb_rphdisc02ii as i_rphdisc2a,
                                        hgb_persendisc02iii as i_persendis2b,
                                        hgb_rphdisc02iii as i_rphdisc2b,
                                        hgb_persendisc03 as i_persendis3,
                                        hgb_rphdisc03 as i_rphdisc3,
                                        hgb_persendisc04 as i_persendis4,
                                        hgb_rphdisc04 as i_rphdisc4,
                                        prd_lastcost as v_lastcost,
                                        prd_kategoritoko as kttk,
                                        prd_flagbandrol as i_bandrol,
                                        prd_kodecabang as kcab,
                                        NVL(prd_flagbarangordertoko, 'v') as fmfbot,
                                        NVL(tag_tidakbolehorder, 'v') as ftftbo,
                                        st_prdcd as st_prdcd,
                                        st_saldoakhir as st_saldoakhir,
                                        prd_prdcd as i_prdcd
                                    FROM tbmaster_prodmast, tbmaster_stock, tbmaster_supplier, tbmaster_hargabeli, tbmaster_tag
                                    WHERE prd_prdcd = '$prdcd'
                                    AND prd_kodeigr = '$kodeigr'
                                    AND st_prdcd(+) = prd_prdcd
                                    AND st_kodeigr(+) = prd_kodeigr
                                    AND st_lokasi(+) = '01'
                                    AND sup_kodesupplier(+) = '$supplier'
                                    AND sup_kodeigr(+) = prd_kodeigr
                                    AND hgb_prdcd = prd_prdcd
                                    AND hgb_kodeigr = prd_kodeigr
                                    AND hgb_tipe = '2'
                                    AND tag_kodetag(+) = prd_kodetag
                                    AND tag_kodeigr(+) = prd_kodeigr");
        return $data;
    }

    public function getPODetail($noPo, $kodeigr, $prdcd)
    {
        $v_qty = '';
        $v_pkp = '';
        $v_acost = '';
        $v_lcost = '';
        $nprice = '';
        $ndpp = 0;
        $namt = '';
        $flag_update = 0;
        $i_prdcd = '';

        $data = $this->query2($noPo, $kodeigr, $prdcd);
        if (!$data) {
            return (['2', "Kode Produk tidak terdaftar dalam No.PO ini !!!", ""]);
        }

        $data = $data[0];
        $flag_update = 1;

        $data->i_bandrol = $data->prd_flagbandrol;
        $data->i_prdcd = $data->tpod_prdcd;
        $data->i_unit = $data->prd_unit;
        $data->i_frac = $data->tpod_isibeli;
        $data->i_isibeli = $data->prd_isibeli;
        $data->i_pkp = $data->prd_flagbkp1;
        $data->i_keterangan = $data->tpod_keterangan;
        $data->i_qty = floor($data->qty_po / $data->tpod_isibeli);
        $data->i_qtyk = $data->qty_po - ($data->i_qty * $data->tpod_isibeli);
        $data->i_lcost = $data->prd_lastcost;
        $data->i_acost = $data->st_avgcost;
        $data->i_barang = $data->prd_deskripsipanjang;
        $data->i_kemasan = $data->tpod_satuanbeli . '/' . $data->tpod_isibeli;
        $data->i_tag = $data->prd_kodetag;

        $nprice = ($data->prd_unit != 'KG') ? $data->tpod_hrgsatuan * $data->tpod_isibeli : $data->tpod_hrgsatuan;
        $data->i_bonus1 = $data->bonus1;
        $data->i_bonus2 = $data->bonus2;
        $data->i_gross = ((floor($data->qty_po / $data->tpod_isibeli)) * $nprice)
            + ((($data->qty_po / $data->tpod_isibeli)) * ($nprice / $data->tpod_isibeli));
        $data->i_persendis1 = $data->tpod_persentasedisc1;
        $data->i_rphdisc1 = $data->tpod_rphdisc1;
        $data->i_flagdisc1 = $data->tpod_flagdisc1;
        $data->i_persendis2 = $data->tpod_persentasedisc2;
        $data->i_rphdisc2 = $data->tpod_rphdisc2;
        $data->i_persendis2a = $data->tpod_persentasedisc2ii;
        $data->i_rphdisc2a = $data->tpod_rphdisc2ii;
        $data->i_persendis2b = $data->tpod_persentasedisc2iii;
        $data->i_rphdisc2b = $data->tpod_rphdisc2iii;
        $data->i_flagdisc2 = $data->tpod_flagdisc2;
        $data->i_persendis3 = $data->tpod_persentasedisc3;
        $data->i_rphdisc3 = $data->tpod_rphdisc3;
        $data->i_flagdisc3 = $data->tpod_flagdisc3;
        $data->i_persendis4 = $data->dis4cp + $data->dis4rp + $data->dis4jp;
        $data->i_rphdisc4 = $data->dis4cr + $data->dis4rr + $data->dis4jr;
        $data->i_flagdisc4 = $data->tpod_flagdisc4;
        $data->i_dis4cp = $data->dis4cp;
        $data->i_dis4cr = $data->dis4cr;
        $data->i_dis4rp = $data->dis4rp;
        $data->i_dis4rr = $data->dis4rr;
        $data->i_dis4jp = $data->dis4jp;
        $data->i_dis4jr = $data->dis4jr;
        $data->i_totaldisc = $data->tpod_rphttldisc;
        $data->i_hrgbeli = $nprice;
        $data->i_bkp = $data->prd_flagbkp1 . '/' . $data->prd_flagbkp2;
        $data->i_ppn = ($data->sup_pkp = 'Y' && $data->prd_flagbkp1 = 'Y') ? (($data->tpod_persenppn / 100) * $data->gross) : 0;
        $data->i_bm = $data->tpod_ppnbm;
        $data->i_ppn_persen = $data->tpod_persenppn;
        $data->i_botol = $data->tpod_ppnbotol;
        $data->trbo_qty = $data->qty_po;
        $flag_update = 1;
        $data->i_jenispb = $data->tpod_jenispb;
        $data->i_total = 0;

        if ($flag_update == 0) {
            return (['2', "Kode Produk tidak terdaftar dalam No.PO ini !!!", ""]);
        } else {
            return (['0', "", $data]);
        }
    }

    public function query2($noPo, $kodeigr, $prdcd)
    {
        $data = DB::connection(Session::get('connection'))->select(" SELECT   tpod_kodeigr,
                                            tpod_recordid,
                                            tpod_nopo,
                                            tpod_tglpo,
                                            tpod_kodedivisi,
                                            tpod_kodedepartemen,
                                            tpod_kategoribarang,
                                            tpod_prdcd,
                                            tpod_persenppn,
                                            NVL(tpod_qtypo, 0) qty_po,
                                            tpod_hrgsatuan,
                                            prd_frac tpod_satuanbeli,
                                            tpod_isibeli,
                                            NVL(tpod_persentasedisc1, 0) tpod_persentasedisc1,
                                            NVL(tpod_rphdisc1, 0) tpod_rphdisc1,
                                            tpod_flagdisc1,
                                            NVL(tpod_persentasedisc2, 0) tpod_persentasedisc2,
                                            NVL(tpod_rphdisc2, 0) tpod_rphdisc2,
                                            tpod_flagdisc2,
                                            NVL(tpod_persentasedisc2ii, 0) tpod_persentasedisc2ii,
                                            NVL(tpod_rphdisc2ii, 0) tpod_rphdisc2ii,
                                            NVL(tpod_persentasedisc2iii, 0) tpod_persentasedisc2iii,
                                            NVL(tpod_rphdisc2iii, 0) tpod_rphdisc2iii,
                                            NVL(tpod_persentasedisc3, 0) tpod_persentasedisc3,
                                            NVL(tpod_rphdisc3, 0) tpod_rphdisc3,
                                            tpod_flagdisc3,
                                            tpod_flagdisc4,
                                            tpod_jenispb,
                                            NVL(tpod_bonuspo1, 0) bonus1,
                                            NVL(tpod_bonuspo2, 0) bonus2,
                                            NVL(tpod_gross, 0) gross,
                                            NVL(tpod_rphttldisc, 0) tpod_rphttldisc,
                                            NVL(tpod_ppn, 0) tpod_ppn,
                                            NVL(tpod_ppnbm, 0) tpod_ppnbm,
                                            NVL(tpod_ppnbotol, 0) tpod_ppnbotol,
                                            NVL(tpod_persentasedisc4cashdisc, 0) dis4cp,
                                            NVL(tpod_rphdisc4, 0) dis4rp,
                                            NVL(tpod_persentasedisc4df, 0) dis4jp,
                                            NVL(tpod_rphdisc4cash, 0) dis4cr,
                                            NVL(tpod_rphdisc4retur, 0) dis4rr,
                                            NVL(tpod_rphdisc4df, 0) dis4jr,
                                            tpod_keterangan,
                                            prd_deskripsipanjang,
                                            prd_isibeli,
                                            prd_frac,
                                            prd_flagbkp1,
                                            prd_flagbkp2,
                                            prd_unit,
                                            prd_lastcost,
                                            prd_kodetag,
                                            st_avgcost,
                                            st_lastcost,
                                            sup_pkp,
                                            prd_flagbandrol
                                        FROM tbtr_po_d aa, tbmaster_prodmast bb, tbmaster_stock, tbmaster_supplier
                                        WHERE tpod_nopo = '$noPo'
                                        AND tpod_kodeigr = '$kodeigr'
                                        AND tpod_prdcd = '$prdcd'
                                        AND bb.prd_prdcd = aa.tpod_prdcd
                                        AND bb.prd_kodeigr = aa.tpod_kodeigr
                                        AND st_prdcd(+) = aa.tpod_prdcd
                                        AND st_kodeigr(+) = aa.tpod_kodeigr
                                        AND st_lokasi(+) = '01'
                                        AND sup_kodesupplier = ( SELECT * FROM (SELECT hgb_kodesupplier FROM TBMASTER_HARGABELI WHERE hgb_kodeigr = '$kodeigr' AND hgb_prdcd = '$prdcd' ORDER BY hgb_tipe) a WHERE ROWNUM = 1)
                                        AND sup_kodeigr = '$kodeigr'
                                    ORDER BY tpod_prdcd");
        return $data;
    }

    public function chkGets($col, $prdcd, $kodeigr, $supplier, $noPo)
    {
        $datas = $this->query3($prdcd, $kodeigr, $supplier, $noPo);
        $this->param_error = 0;
        $getDataPlu = $this->getDataPlu;
        $help = new AllModel();
        $sysdate = $help->getDateTime();
        $nisib = 1;

        foreach ($datas as $data) {
            if (!$data) {
                break; //EXIT
            }

            $nilhrgbeli = $data->hgb_hrgbeli;
            $i_prdcd = $prdcd;
            $i_qtypo = $data->tpod_qtypo;

            if ($noPo) {
                if (!$data->tpod_prdcd) {
                    $this->param_error = 0;
                    return (['kode' => 2, 'msg' => "Kode Produk tidak terdaftar dalam No.PO ini: " . $noPo . " !!!", 'data' => '']);
                }
            }

            if (!$data->prd_prdcd) {
                $this->param_error = 0;
                return (['kode' => 2, 'msg' => "Kode Produk tidak terdaftar", 'data' => '']);
            }

            $nsvlcost = $data->prd_lastcost;
            $nsvacost = $data->st_avgcost * (($data->prd_unit == 'KG') ? 1 : $data->tpod_isibeli);
            $cbkp = $data->prd_flagbkp1;
            $cfobkp = $data->prd_flagbkp2;

            if (!$data->prd_kategoritoko && !$data->prd_kodecabang) {
                $this->param_error = 0;
                return (['kode' => 2, 'msg' => "Produk ini tidak sesuai kategory-nya", 'data' => '']);
                break; //EXIT
            }

            if ($data->prd_kodetag != 'T' && $data->prd_kodetag != 'G' && $data->prd_kodetag != 'Q' && $data->prd_kodetag != 'U') {
                if ($data->tag_tidakbolehorder == 'Y') {
                    $this->param_error = 0;
                    return (['kode' => 2, 'msg' => "Produk DISCONTINUE", 'data' => '']);
                    break; //EXIT
                }

                if ($data->prd_flagbarangordertoko != 'Y' && !$noPo && $supplier) {
                    $this->param_error = 0;
                    return (['kode' => 2, 'msg' => "Produk ini harus menggunakan PO", 'data' => '']);
                    break; //EXIT
                }

                $ndivcost = 0;

                if ($nsvlcost != '0' && $data->st_prdcd) {
                    $ndivcost = (abs($nsvlcost - $nsvacost)) / $nsvlcost;

                    if ($ndivcost >= '0.20') {
                        $this->param_error = 2;
                    }
                }

                if (!$noPo && !$supplier && $data->st_saldoakhir <= 0) {
                    $this->param_error = 0;
                    return (['kode' => 2, 'msg' => "Stok Barang <= 0, tidak dapat menginput BPB Lain Lain", 'data' => '']);
                    break;
                }
            }


            if (!$supplier && !$noPo) {
                if ($getDataPlu->i_hrgbeli != 0 && $data->prd_kodedivisi != '4') {
                    break;
                }
            }

            if ($getDataPlu->i_hrgbeli < 0) {
                $this->param_error = 0;
                break;
            }

            $lhigh = false; //---------------------

            if ($noPo && $data->tpod_prdcd) {
                if ($data->prd_unit != 'KG') {
                    if (round(($getDataPlu->i_hrgbeli / $data->tpod_isibeli)) > round($data->tpod_hrgsatuan)) {
                        $lhigh = true;
                    }
                } else {
                    if (round($getDataPlu->i_hrgbeli, 0) > round($data->tpod_hrgsatuan, 0)) {
                        $lhigh = true;
                    }
                }

                if ($lhigh == true) {
                    $this->param_error = 3;
                    return (['kode' => 2, 'msg' => "Harga Satuan Barang melebihi PO", 'data' => '']);
                }

                $nsvlcost = $data->prd_lastcost;
                $nsvacost = $data->st_avgcost * (($data->prd_unit == 'KG') ? 1 : $data->tpod_isibeli);
                $ndivprice = 0;

                if ($nsvlcost != 0) {
                    $ndivprice = (abs($data->tpod_hrgsatuan - $nilhrgbeli)) / $data->tpod_hrgsatuan;

                    if ($ndivprice >= 0.20) {
                        if ($this->param_cek == 'Y') {
                            $this->param_cek = 'N';
                            return (['kode' => 2, 'msg' => "Selisih cost - price terlalu besar", 'data' => '']);
                        }
                    }
                }

                $getDataPlu->i_gross = $getDataPlu->i_qty * $getDataPlu->i_hrgbeli + $getDataPlu->i_qtyk * $getDataPlu->i_hrgbeli / $data->tpod_isibeli;
                $getDataPlu->i_totaldisc = $data->tpod_rphttldisc;
                $this->param_ndpp = (round($getDataPlu->i_hrgbeli, 0) != round($data->tpod_hrgsatuan)) ?
                    $getDataPlu->i_gross - ($getDataPlu->i_rphdisc1 + $getDataPlu->i_rphdisc2 + $getDataPlu->i_rphdisc2a + $getDataPlu->i_rphdisc2b + $getDataPlu->i_rphdisc3 + $getDataPlu->i_rphdisc4) : $data->tpod_gross;
                $getDataPlu->i_ppn = ($data->sup_pkp == 'Y' && $data->prd_flagbkp1 == 'Y') ? 0.11 * $this->param_ndpp : 0;
                $getDataPlu->i_bm = $data->tpod_ppnbm;
                $getDataPlu->i_botol = $data->tpod_ppnbotol;
                $getDataPlu->i_total = round(($this->param_ndpp + $getDataPlu->i_ppn + $getDataPlu->i_bm + $getDataPlu->i_botol));
            } else {
                if (!$supplier) {
                    null;
                } else {
                    if ($data->hgb_prdcd == null || $data->hgb_prdcd == '') {
                        return (['kode' => 2, 'msg' => "Produk ini tidak terdaftar pada Master Harga Beli", 'data' => '']);
                    }
                }

                if (($data->hgb_hrgbeli * $getDataPlu->i_frac) < $getDataPlu->i_hrgbeli) {
                    $this->param_error = '3';
                    return (['kode' => 2, 'msg' => "Harga Produk ini lebih besar dari harga beli di Master", 'data' => '']);
                }

                if (!isset($getDataPlu->i_bonus1)) {
                    $getDataPlu->i_bonus1 = 0;
                }

                if (!isset($getDataPlu->i_qty)) {
                    $getDataPlu->i_qty = 0;
                }

                if (!isset($getDataPlu->i_qtyk)) {
                    $getDataPlu->i_qtyk = 0;
                }

                if (($getDataPlu->i_bonus1 + $getDataPlu->i_bonus1) == 0) {
                    if ($data->hgb_tglmulaibonus01 <= $sysdate && $data->hgb_tglakhirbonus01 >= $sysdate && $data->hgb_tglmulaibonus01) {
                        if ($data->hgb_flagkelipatanbonus01 == 'Y') {
                            $getDataPlu->i_bonus1 = ($getDataPlu->i_qty >= $data->hgb_qtymulai1bonus01) ? ($getDataPlu->i_qty / $data->hgb_qtymulai1bonus01) * $data->hgb_qty1bonus01 : $getDataPlu->i_bonus1;
                        } else {
                            if ($getDataPlu->i_qty >= $data->hgb_qtymulai1bonus01 && $getDataPlu->i_qty < $data->hgb_qtymulai2bonus01) $getDataPlu->i_bonus1 = $data->hgb_qty1bonus01;
                            elseif ($getDataPlu->i_qty >= $data->hgb_qtymulai2bonus01 && $getDataPlu->i_qty < $data->hgb_qtymulai3bonus01) $getDataPlu->i_bonus1 = $data->hgb_qty2bonus01;
                            elseif ($getDataPlu->i_qty >= $data->hgb_qtymulai3bonus01 && $getDataPlu->i_qty < $data->hgb_qtymulai4bonus01) $getDataPlu->i_bonus1 = $data->hgb_qty3bonus01;
                            elseif ($getDataPlu->i_qty >= $data->hgb_qtymulai4bonus01 && $getDataPlu->i_qty < $data->hgb_qtymulai5bonus01) $getDataPlu->i_bonus1 = $data->hgb_qty4bonus01;
                            elseif ($getDataPlu->i_qty >= $data->hgb_qtymulai5bonus01 && $getDataPlu->i_qty < $data->hgb_qtymulai6bonus01) $getDataPlu->i_bonus1 = $data->hgb_qty5bonus01;
                            elseif ($getDataPlu->i_qty >= $data->hgb_qtymulai6bonus01) $getDataPlu->i_bonus1 = $data->hgb_qty6bonus01;
                        }
                    }

                    if ($data->hgb_tglmulaibonus02 <= $sysdate && $data->hgb_tglakhirbonus02 >= $sysdate && $data->hgb_tglmulaibonus02) {
                        if ($data->hgb_flagkelipatanbonus02 == 'Y') {
                            $getDataPlu->i_bonus2 = ($getDataPlu->i_qty >= $data->hgb_qtymulai1bonus02) ? ($getDataPlu->i_qty / $data->hgb_qtymulai1bonus02) * $data->hgb_qty1bonus02 : $getDataPlu->i_bonus2;
                        } else {
                            if ($getDataPlu->i_qty >= $data->hgb_qtymulai1bonus02 && $getDataPlu->i_qty < $data->hgb_qtymulai2bonus02) $getDataPlu->i_bonus2 = $data->hgb_qty1bonus02;
                            elseif ($getDataPlu->i_qty >= $data->hgb_qtymulai2bonus02 && $getDataPlu->i_qty < $data->hgb_qtymulai3bonus02) $getDataPlu->i_bonus2 = $data->hgb_qty2bonus02;
                            elseif ($getDataPlu->i_qty >= $data->hgb_qtymulai3bonus02) $getDataPlu->i_bonus2 = $data->hgb_qty3bonus02;
                        }
                    }
                }

                if ($noPo) {
                    $getDataPlu->i_gross = ($getDataPlu->i_qty * $getDataPlu->i_hrgbeli) + ($getDataPlu->i_qtyk * $getDataPlu->i_hrgbeli) / $data->tpod_isibeli;
                    $getDataPlu->i_totaldisc =  ($getDataPlu->i_rphdisc1 + $getDataPlu->i_rphdisc2 + $getDataPlu->i_rphdisc2a + $getDataPlu->i_rphdisc2b + $getDataPlu->i_rphdisc3 + $getDataPlu->i_rphdisc4) *
                        ($getDataPlu->i_qty * $data->tpod_isibeli + $getDataPlu->i_qtyk);
                } else {
                    $getDataPlu->i_gross = ($getDataPlu->i_qty * $getDataPlu->i_hrgbeli) + ($getDataPlu->i_qtyk * $getDataPlu->i_hrgbeli) / $getDataPlu->i_frac;
                    $getDataPlu->i_totaldisc =  ($getDataPlu->i_rphdisc1 + $getDataPlu->i_rphdisc2 + $getDataPlu->i_rphdisc2a + $getDataPlu->i_rphdisc2b + $getDataPlu->i_rphdisc3 + $getDataPlu->i_rphdisc4) *
                        ($getDataPlu->i_qty * $getDataPlu->i_frac + $getDataPlu->i_qtyk);
                }

                $this->param_ndpp = $getDataPlu->i_gross - $getDataPlu->i_totaldisc;

                $getDataPlu->i_ppn = ($data->sup_pkp == 'Y' && $data->prd_flagbkp1 == 'Y') ? 0.11 * $this->param_ndpp : 0;

                if ($data->prd_unit != 'KG') {
                    if ($noPo) {
                        $getDataPlu->i_botol = (($getDataPlu->i_qty * $data->tpod_isi) + $getDataPlu->i_qtyk) * $data->hgb_ppnbotol;
                        $getDataPlu->i_bm = (($getDataPlu->i_qty * $data->tpod_isi) + $getDataPlu->i_qtyk) * $data->hgb_ppnbm;
                    } else {
                        $getDataPlu->i_botol = (($getDataPlu->i_qty * $getDataPlu->i_frac) + $getDataPlu->i_qtyk) * $data->hgb_ppnbotol;
                        $getDataPlu->i_bm = (($getDataPlu->i_qty * $getDataPlu->i_frac) + $getDataPlu->i_qtyk) * $data->hgb_ppnbm;
                    }
                } else {
                    $getDataPlu->i_botol = $getDataPlu->i_qty * $data->hgb_ppnbotol;
                    $getDataPlu->i_bm = $getDataPlu->i_qty * $data->hgb_ppnbm;
                }

                $getDataPlu->i_total = round($getDataPlu->i_gross - $getDataPlu->i_totaldisc + $getDataPlu->i_ppn + $getDataPlu->i_botol + $getDataPlu->i_bm);
            }

            if ($getDataPlu->i_hrgbeli < $data->hgb_hrgbeli && $getDataPlu->i_hrgbeli < ($getDataPlu->i_hrgbeli * (1 - ($data->prs_toleransihrg / 100))) && $data->prd_toleransihrg != 0) {
                $this->param_error = 0;
                return (['kode' => 2, 'msg' => "Total Nilai melebihi toleransi harga yang sudah ditentukan", 'data' => '']);
            }

            if (!$noPo) {
                $getDataPlu->i_disc1 = $getDataPlu->i_rphdisc1 * ($getDataPlu->i_qty * $getDataPlu->i_frac + $getDataPlu->i_qtyk);
                $getDataPlu->i_disc2 = $getDataPlu->i_rphdisc2 * ($getDataPlu->i_qty * $getDataPlu->i_frac + $getDataPlu->i_qtyk);
                $getDataPlu->i_disc2a = $getDataPlu->i_rphdisc2a * ($getDataPlu->i_qty * $getDataPlu->i_frac + $getDataPlu->i_qtyk);
                $getDataPlu->i_disc2b = $getDataPlu->i_rphdisc2b * ($getDataPlu->i_qty * $getDataPlu->i_frac + $getDataPlu->i_qtyk);
                $getDataPlu->i_disc3 = $getDataPlu->i_rphdisc3 * ($getDataPlu->i_qty * $getDataPlu->i_frac + $getDataPlu->i_qtyk);
                $getDataPlu->i_disc4 = $getDataPlu->i_rphdisc4 * ($getDataPlu->i_qty * $getDataPlu->i_frac + $getDataPlu->i_qtyk);
            } else {
                $getDataPlu->i_disc1 = $data->tpod_rphdisc1;
                $getDataPlu->i_disc2 = $data->tpod_rphdisc2;
                $getDataPlu->i_disc2a = $data->tpod_rphdisc2ii;
                $getDataPlu->i_disc2b = $data->tpod_rphdisc2iii;
                $getDataPlu->i_disc3 = $data->tpod_rphdisc3;
                $getDataPlu->i_disc4 = $data->tpod_rphdisc4;
            } //line 541 di oracle

            if (!$noPo && !$supplier && $getDataPlu->i_qty != 0) {
                $getDataPlu->i_qty = 0;
                $this->param_error = 5;
                return (['kode' => 2, 'msg' => "Pada Transaksi Bonus, Qty tidak boleh diisi !", 'data' => '']);
            }

            if ($getDataPlu->i_qty < 0) {
                $this->param_error = 0;
                return (['kode' => 2, 'msg' => "Jml Qty Tidak Boleh < 0", 'data' => '']);
            }

            if ($noPo && $getDataPlu->i_prdcd) {
                if (($getDataPlu->i_qty * $data->tpod_isibeli + $getDataPlu->i_qtyk) > $data->tpod_qtypo) {
                    $getDataPlu->i_qty = floor($data->tpod_qtypo / $data->tpod_isibeli);
                    $getDataPlu->i_qtyk = (int) fmod($data->tpod_qtypo, $data->tpod_isibeli);
                    $this->param_error = 0;
                    return (['kode' => 2, 'msg' => "Kuantum melebihi PO Line 1040", 'data' => '']);
                }

                //--- LINE 575 di oracle
                $getDataPlu->i_gross = ($getDataPlu->i_qty * $getDataPlu->i_hrgbeli) + (($getDataPlu->i_qtyk * $getDataPlu->i_hrgbeli) / $data->tpod_isibeli);

                if ($getDataPlu->i_qty * $data->tpod_isibeli + $getDataPlu->i_qtyk != $data->tpod_qtypo) {
                    $getDataPlu->i_totaldisc = ($getDataPlu->i_rphdisc1 + $getDataPlu->i_rphdisc2 + $getDataPlu->i_rphdisc2a + $getDataPlu->i_rphdisc2b + $getDataPlu->i_rphdisc3 + $getDataPlu->i_rphdisc4);
                    $this->param_ndpp = $getDataPlu->i_gross - $getDataPlu->i_totaldisc;
                } else {
                    $getDataPlu->i_totaldisc = $data->tpod_rphttldisc;
                    $getDataPlu->i_gross = $data->tpod_gross;
                    $getDataPlu->i_totaldisc = ($getDataPlu->i_rphdisc1 + $getDataPlu->i_rphdisc2 + $getDataPlu->i_rphdisc2a + $getDataPlu->i_rphdisc2b + $getDataPlu->i_rphdisc3 + $getDataPlu->i_rphdisc4);
                    $this->param_ndpp = $getDataPlu->i_gross - $getDataPlu->i_totaldisc;
                    $getDataPlu->i_gross = ($getDataPlu->i_qty * $getDataPlu->i_hrgbeli) + (($getDataPlu->i_qtyk * $getDataPlu->i_hrgbeli) / $data->tpod_isibeli);
                }

                $getDataPlu->i_ppn = ($data->sup_pkp == 'Y' && $data->prd_flagbkp1 == 'Y') ? 0.1 * $this->param_ndpp : 0;
                $getDataPlu->i_bm = ($data->tpod_ppnbm / $data->tpod_qtypo) * ($getDataPlu->i_qty * $data->tpod_isibeli + $getDataPlu->i_qtyk);
                $getDataPlu->i_botol = ($data->tpod_ppnbotol / $data->tpod_qtypo) * ($getDataPlu->i_qty * $data->tpod_isibeli + $getDataPlu->i_qtyk);
                $getDataPlu->i_total = round(($this->param_ndpp + $getDataPlu->i_ppn + $getDataPlu->i_bm + $getDataPlu->i_botol));
            } else { //line 636 di oracle
                if (($getDataPlu->i_bonus1 + $getDataPlu->i_bonus1) == 0) {
                    if ($data->hgb_tglmulaibonus01 <= $sysdate && $data->hgb_tglakhirbonus01 >= $sysdate && $data->hgb_tglmulaibonus01) {
                        if ($data->hgb_flagkelipatanbonus01 == 'Y') {
                            $getDataPlu->i_bonus1 = ($getDataPlu->i_qty >= $data->hgb_qtymulai1bonus01) ? ($getDataPlu->i_qty / $data->hgb_qtymulai1bonus01) * $data->hgb_qty1bonus01 : $getDataPlu->i_bonus1;
                        } else {
                            if ($getDataPlu->i_qty >= $data->hgb_qtymulai1bonus01 && $getDataPlu->i_qty < $data->hgb_qtymulai2bonus01) $getDataPlu->i_bonus1 = $data->hgb_qty1bonus01;
                            elseif ($getDataPlu->i_qty >= $data->hgb_qtymulai2bonus01 && $getDataPlu->i_qty < $data->hgb_qtymulai3bonus01) $getDataPlu->i_bonus1 = $data->hgb_qty2bonus01;
                            elseif ($getDataPlu->i_qty >= $data->hgb_qtymulai3bonus01 && $getDataPlu->i_qty < $data->hgb_qtymulai4bonus01) $getDataPlu->i_bonus1 = $data->hgb_qty3bonus01;
                            elseif ($getDataPlu->i_qty >= $data->hgb_qtymulai4bonus01 && $getDataPlu->i_qty < $data->hgb_qtymulai5bonus01) $getDataPlu->i_bonus1 = $data->hgb_qty4bonus01;
                            elseif ($getDataPlu->i_qty >= $data->hgb_qtymulai5bonus01 && $getDataPlu->i_qty < $data->hgb_qtymulai6bonus01) $getDataPlu->i_bonus1 = $data->hgb_qty5bonus01;
                            elseif ($getDataPlu->i_qty >= $data->hgb_qtymulai6bonus01) $getDataPlu->i_bonus1 = $data->hgb_qty6bonus01;
                        }
                    }

                    if ($data->hgb_tglmulaibonus02 <= $sysdate && $data->hgb_tglakhirbonus02 >= $sysdate && $data->hgb_tglmulaibonus02) {
                        if ($data->hgb_flagkelipatanbonus02 == 'Y') {
                            $getDataPlu->i_bonus2 = ($getDataPlu->i_qty >= $data->hgb_qtymulai1bonus02) ? ($getDataPlu->i_qty / $data->hgb_qtymulai1bonus02) * $data->hgb_qty1bonus02 : $getDataPlu->i_bonus2;
                        } else {
                            if ($getDataPlu->i_qty >= $data->hgb_qtymulai1bonus02 && $getDataPlu->i_qty < $data->hgb_qtymulai2bonus02) $getDataPlu->i_bonus2 = $data->hgb_qty1bonus02;
                            elseif ($getDataPlu->i_qty >= $data->hgb_qtymulai2bonus02 && $getDataPlu->i_qty < $data->hgb_qtymulai3bonus02) $getDataPlu->i_bonus2 = $data->hgb_qty2bonus02;
                            elseif ($getDataPlu->i_qty >= $data->hgb_qtymulai3bonus02) $getDataPlu->i_bonus2 = $data->hgb_qty3bonus02;
                        }
                    }
                }

                if (!isset($data->tpod_isibeli)) {
                    $data->tpod_isibeli = 0;
                    $getDataPlu->i_gross = 0;
                } else {
                    $getDataPlu->i_gross = ($getDataPlu->i_qty * $getDataPlu->i_hrgbeli) + (($getDataPlu->i_qtyk * $getDataPlu->i_hrgbeli) / $data->tpod_isibeli);
                }


                $getDataPlu->i_totaldisc = ($getDataPlu->i_rphdisc1 + $getDataPlu->i_rphdisc2 + $getDataPlu->i_rphdisc2a + $getDataPlu->i_rphdisc2b + $getDataPlu->i_rphdisc3 + $getDataPlu->i_rphdisc4) *
                    ($getDataPlu->i_qty * $data->tpod_isibeli + $getDataPlu->i_qtyk);
                $this->param_ndpp = $getDataPlu->i_gross - $getDataPlu->i_totaldisc;
                $getDataPlu->i_ppn = ($data->sup_pkp == 'Y' && $data->prd_flagbkp1 == 'Y') ? 0.11 * $this->param_ndpp : 0;

                if (!$noPo) {
                    $getDataPlu->i_disc1 = $getDataPlu->i_rphdisc1 * ($getDataPlu->i_qty * $getDataPlu->i_frac + $getDataPlu->i_qtyk);
                    $getDataPlu->i_disc2 = $getDataPlu->i_rphdisc2 * ($getDataPlu->i_qty * $getDataPlu->i_frac + $getDataPlu->i_qtyk);
                    $getDataPlu->i_disc2a = $getDataPlu->i_rphdisc2a * ($getDataPlu->i_qty * $getDataPlu->i_frac + $getDataPlu->i_qtyk);
                    $getDataPlu->i_disc2b = $getDataPlu->i_rphdisc2b * ($getDataPlu->i_qty * $getDataPlu->i_frac + $getDataPlu->i_qtyk);
                    $getDataPlu->i_disc3 = $getDataPlu->i_rphdisc3 * ($getDataPlu->i_qty * $getDataPlu->i_frac + $getDataPlu->i_qtyk);
                    $getDataPlu->i_disc4 = $getDataPlu->i_rphdisc4 * ($getDataPlu->i_qty * $getDataPlu->i_frac + $getDataPlu->i_qtyk);
                } else {
                    $getDataPlu->i_disc1 = $data->tpod_rphdisc1;
                    $getDataPlu->i_disc2 = $data->tpod_rphdisc2;
                    $getDataPlu->i_disc2a = $data->tpod_rphdisc2ii;
                    $getDataPlu->i_disc2b = $data->tpod_rphdisc2iii;
                    $getDataPlu->i_disc3 = $data->tpod_rphdisc3;
                    $getDataPlu->i_disc4 = $data->tpod_rphdisc4;
                }

                $getDataPlu->i_total = round(($this->param_ndpp + $getDataPlu->i_ppn + $getDataPlu->i_bm + $getDataPlu->i_botol));
            } //end if ($noPo && $data->i_prdcd) Line 755


            if (!$noPo && !$supplier && $getDataPlu->i_qty != 0) {
                $getDataPlu->i_qty = 0;
                $this->param_error = 5;
                return (['kode' => 2, 'msg' => "Pada Transaksi Bonus, Qty tidak boleh diisi !", 'data' => '']);
            }

            if ($getDataPlu->i_qty < 0) {
                $this->param_error = 0;
                return (['kode' => 2, 'msg' => "Jml Qty Tidak Boleh < 0", 'data' => '']);
            }

            if (!$noPo && $supplier) {
                if (($getDataPlu->i_qty * $getDataPlu->i_frac + $getDataPlu->i_qtyk) <= 0) {
                    $getDataPlu->i_qty = 0;
                    $this->param_error = 5;
                    return (['kode' => 3, 'msg' => "Pada Transaksi Non PO / Barang BKL , Qty Harus di Isi !!", 'data' => '']);
                }
            }

            if ($noPo) {
                $getDataPlu->i_qty = floor($getDataPlu->i_qty + ($getDataPlu->i_qtyk / $data->tpod_isibeli));
                //                $getDataPlu->i_qtyk = ($getDataPlu->i_qtyk / $data->tpod_isibeli);
                //                $getDataPlu->i_qtyk = $data->qty_po - ($getDataPlu->i_qty * $data->tpod_isibeli);
                $getDataPlu->i_qtyk = (int) fmod($getDataPlu->i_qtyk, $data->tpod_isibeli);
            } else {
                $getDataPlu->i_qty = floor($getDataPlu->i_qty + ($getDataPlu->i_qtyk / $getDataPlu->i_frac));
                //                $getDataPlu->i_qtyk = ($getDataPlu->i_qtyk / $getDataPlu->i_frac);
                //                $getDataPlu->i_qtyk = $data->qty_po - ($getDataPlu->i_qty * $data->tpod_isibeli);
                $getDataPlu->i_qtyk = (int) fmod($getDataPlu->i_qtyk, $getDataPlu->i_frac);
            } // END di line  796 atau di 808

            //            30-12-2020
            if ($noPo && $data->tpod_prdcd) {
                if (($getDataPlu->i_qty * $data->tpod_isibeli + $getDataPlu->i_qtyk) > $data->tpod_qtypo) {
                    $getDataPlu->i_qty = floor($data->tpod_qtypo / $data->tpod_isibeli);
                    //                    $getDataPlu->i_qtyk = ($data->tpod_qtypo / $data->tpod_isibeli);
                    $getDataPlu->i_qtyk = (int) fmod($data->tpod_qtypo, $data->tpod_isibeli);
                    $this->param_error = 0;
                    return (['kode' => 2, 'msg' => "Kuantum melebihi PO", 'data' => '']);
                }

                $getDataPlu->i_gross = ($getDataPlu->i_qty * $getDataPlu->i_hrgbeli) + (($getDataPlu->i_qtyk * $getDataPlu->i_hrgbeli) / $data->tpod_isibeli);

                if ($getDataPlu->i_qty * $data->tpod_isibeli + $getDataPlu->i_qtyk != $data->tpod_qtypo) {
                    $getDataPlu->i_totaldisc = ($getDataPlu->i_rphdisc1 + $getDataPlu->i_rphdisc2 + $getDataPlu->i_rphdisc2a + $getDataPlu->i_rphdisc2b + $getDataPlu->i_rphdisc3 + $getDataPlu->i_rphdisc4);
                    $this->param_ndpp = $getDataPlu->i_gross - $getDataPlu->i_totaldisc;
                } else {
                    $getDataPlu->i_totaldisc = $data->tpod_rphttldisc;
                    $this->param_ndpp = $data->tpod_gross;
                }

                $getDataPlu->i_ppn = ($data->sup_pkp == 'Y' && $data->prd_flagbkp1 == 'Y') ? 0.11 * $this->param_ndpp : 0;
                $getDataPlu->i_bm = ($data->tpod_ppnbm / $data->tpod_qtypo) * ($getDataPlu->i_qty * $data->tpod_isibeli + $getDataPlu->i_qtyk);
                $getDataPlu->i_botol = ($data->tpod_ppnbotol / $data->tpod_qtypo) * ($getDataPlu->i_qty * $data->tpod_isibeli + $getDataPlu->i_qtyk);
                $getDataPlu->i_total = round(($this->param_ndpp + $getDataPlu->i_ppn + $getDataPlu->i_bm + $getDataPlu->i_botol));
            } //Line 853
            else {
                if (($getDataPlu->i_bonus1 + $getDataPlu->i_bonus1) == 0) {
                    if ($data->hgb_tglmulaibonus01 <= $sysdate && $data->hgb_tglakhirbonus01 >= $sysdate && $data->hgb_tglmulaibonus01) {
                        if ($data->hgb_flagkelipatanbonus01 == 'Y') {
                            $getDataPlu->i_bonus1 = ($getDataPlu->i_qty >= $data->hgb_qtymulai1bonus01) ? ($getDataPlu->i_qty / $data->hgb_qtymulai1bonus01) * $data->hgb_qty1bonus01 : $getDataPlu->i_bonus1;
                        } else {
                            if ($getDataPlu->i_qty >= $data->hgb_qtymulai1bonus01 && $getDataPlu->i_qty < $data->hgb_qtymulai2bonus01) $getDataPlu->i_bonus1 = $data->hgb_qty1bonus01;
                            elseif ($getDataPlu->i_qty >= $data->hgb_qtymulai2bonus01 && $getDataPlu->i_qty < $data->hgb_qtymulai3bonus01) $getDataPlu->i_bonus1 = $data->hgb_qty2bonus01;
                            elseif ($getDataPlu->i_qty >= $data->hgb_qtymulai3bonus01 && $getDataPlu->i_qty < $data->hgb_qtymulai4bonus01) $getDataPlu->i_bonus1 = $data->hgb_qty3bonus01;
                            elseif ($getDataPlu->i_qty >= $data->hgb_qtymulai4bonus01 && $getDataPlu->i_qty < $data->hgb_qtymulai5bonus01) $getDataPlu->i_bonus1 = $data->hgb_qty4bonus01;
                            elseif ($getDataPlu->i_qty >= $data->hgb_qtymulai5bonus01 && $getDataPlu->i_qty < $data->hgb_qtymulai6bonus01) $getDataPlu->i_bonus1 = $data->hgb_qty5bonus01;
                            elseif ($getDataPlu->i_qty >= $data->hgb_qtymulai6bonus01) $getDataPlu->i_bonus1 = $data->hgb_qty6bonus01;
                        }
                    }

                    if ($data->hgb_tglmulaibonus02 <= $sysdate && $data->hgb_tglakhirbonus02 >= $sysdate && $data->hgb_tglmulaibonus02) {
                        if ($data->hgb_flagkelipatanbonus02 == 'Y') {
                            $getDataPlu->i_bonus2 = ($getDataPlu->i_qty >= $data->hgb_qtymulai1bonus02) ? ($getDataPlu->i_qty / $data->hgb_qtymulai1bonus02) * $data->hgb_qty1bonus02 : $getDataPlu->i_bonus2;
                        } else {
                            if ($getDataPlu->i_qty >= $data->hgb_qtymulai1bonus02 && $getDataPlu->i_qty < $data->hgb_qtymulai2bonus02) $getDataPlu->i_bonus2 = $data->hgb_qty1bonus02;
                            elseif ($getDataPlu->i_qty >= $data->hgb_qtymulai2bonus02 && $getDataPlu->i_qty < $data->hgb_qtymulai3bonus02) $getDataPlu->i_bonus2 = $data->hgb_qty2bonus02;
                            elseif ($getDataPlu->i_qty >= $data->hgb_qtymulai3bonus02) $getDataPlu->i_bonus2 = $data->hgb_qty3bonus02;
                        }
                    }
                }

                $getDataPlu->i_gross = ($noPo) ? $getDataPlu->i_qty * $getDataPlu->i_hrgbeli + $getDataPlu->i_qtyk * $getDataPlu->i_hrgbeli / $data->tpod_isibeli : $getDataPlu->i_qty * $getDataPlu->i_hrgbeli + $getDataPlu->i_qtyk * $getDataPlu->i_hrgbeli / $getDataPlu->i_frac;
                $getDataPlu->i_totaldisc = ($getDataPlu->i_rphdisc1 + $getDataPlu->i_rphdisc2 + $getDataPlu->i_rphdisc2a + $getDataPlu->i_rphdisc2b + $getDataPlu->i_rphdisc3 + $getDataPlu->i_rphdisc4) *
                    ($getDataPlu->i_qty * $data->tpod_isibeli + $getDataPlu->i_qtyk);
                $this->param_ndpp = $getDataPlu->i_gross - $getDataPlu->i_totaldisc;
                $getDataPlu->i_ppn = ($data->sup_pkp == 'Y' && $data->prd_flagbkp1 == 'Y') ? 0.11 * $this->param_ndpp : 0;

                if (!$noPo) {
                    $getDataPlu->i_disc1 = $getDataPlu->i_rphdisc1 * ($getDataPlu->i_qty * $getDataPlu->i_frac + $getDataPlu->i_qtyk);
                    $getDataPlu->i_disc2 = $getDataPlu->i_rphdisc2 * ($getDataPlu->i_qty * $getDataPlu->i_frac + $getDataPlu->i_qtyk);
                    $getDataPlu->i_disc2a = $getDataPlu->i_rphdisc2a * ($getDataPlu->i_qty * $getDataPlu->i_frac + $getDataPlu->i_qtyk);
                    $getDataPlu->i_disc2b = $getDataPlu->i_rphdisc2b * ($getDataPlu->i_qty * $getDataPlu->i_frac + $getDataPlu->i_qtyk);
                    $getDataPlu->i_disc3 = $getDataPlu->i_rphdisc3 * ($getDataPlu->i_qty * $getDataPlu->i_frac + $getDataPlu->i_qtyk);
                    $getDataPlu->i_disc4 = $getDataPlu->i_rphdisc4 * ($getDataPlu->i_qty * $getDataPlu->i_frac + $getDataPlu->i_qtyk);
                } else {
                    $getDataPlu->i_disc1 = $data->tpod_rphdisc1;
                    $getDataPlu->i_disc2 = $data->tpod_rphdisc2;
                    $getDataPlu->i_disc2a = $data->tpod_rphdisc2ii;
                    $getDataPlu->i_disc2b = $data->tpod_rphdisc2iii;
                    $getDataPlu->i_disc3 = $data->tpod_rphdisc3;
                    $getDataPlu->i_disc4 = $data->tpod_rphdisc4;
                }

                $getDataPlu->i_total = round(($this->param_ndpp + $getDataPlu->i_ppn + $getDataPlu->i_bm + $getDataPlu->i_botol));
            } // END IF ($noPo && $data->tpod_prdcd) 977

            if ($data->tpod_isibeli != $nisib) {
                $getDataPlu->i_isibeli = (($getDataPlu->i_qty * $data->tpod_isibeli + $getDataPlu->i_qtyk) / $nisib) . ' ' . $data->prd_unit . ' ' . (($getDataPlu->i_qty * $data->tpod_isibeli + $getDataPlu->i_qtyk) / $nisib) . ' Pcs';
            }

            if ($getDataPlu->i_bonus1 < 0) {
                $getDataPlu->i_bonus1 = 0;
                $this->param_error = 0;
                return (['kode' => 2, 'msg' => "Bonus 1 harus >= 0", 'data' => '']);
            }

            if (!$noPo && !$supplier && $getDataPlu->i_bonus1 == 0) {
                $this->param_error = 5;
                return (['kode' => 2, 'msg' => "Pada Transaksi Bonus, Qty Bonus harus diisi !", 'data' => '']);
            }

            if (!$noPo && !$supplier) {
                $getDataPlu->i_gross        =  $getDataPlu->i_bonus1 *  $getDataPlu->i_hrgbeli /  $getDataPlu->i_frac;
                $getDataPlu->i_totaldisc    = ($getDataPlu->i_rphdisc1 + $getDataPlu->i_rphdisc2 + $getDataPlu->i_rphdisc2a + $getDataPlu->i_rphdisc2b + $getDataPlu->i_rphdisc3 + $getDataPlu->i_rphdisc4) * $getDataPlu->i_bonus1;
                $this->param_ndpp           = $getDataPlu->i_gross - $getDataPlu->i_totaldisc;
                $getDataPlu->i_ppn          = ($data->sup_pkp == 'Y' && $data->prd_flagbkp1 == 'Y') ? 0.11 * $this->param_ndpp : 0;
                $getDataPlu->i_total        = round(($this->param_ndpp + $getDataPlu->i_ppn + $getDataPlu->i_bm + $getDataPlu->i_botol));

                $getDataPlu->i_disc1        = $data->tpod_rphdisc1 * $getDataPlu->i_bonus1;
                $getDataPlu->i_disc2        = $data->tpod_rphdisc2 * $getDataPlu->i_bonus1;
                $getDataPlu->i_disc2a       = $data->tpod_rphdisc2a * $getDataPlu->i_bonus1;
                $getDataPlu->i_disc2b       = $data->tpod_rphdisc2b * $getDataPlu->i_bonus1;
                $getDataPlu->i_disc3        = $data->tpod_rphdisc3 * $getDataPlu->i_bonus1;
                $getDataPlu->i_disc4        = $data->tpod_rphdisc4 * $getDataPlu->i_bonus1;
            } // Line 1044

            if ($getDataPlu->i_rphdisc1 < 0) {
                $this->param_error = 0;
                return (['kode' => 2, 'msg' => "Potongan 1 (Rp) harus >= 0", 'data' => '']);
            }

            if (!$noPo && !$supplier && $getDataPlu->i_rphdisc1 != 0) {
                $getDataPlu->i_rphdisc1 = 0;
                $getDataPlu->i_disc1    = 0;
                $getDataPlu->i_ppn      = 0;
                $getDataPlu->i_botol    = 0;
                $getDataPlu->i_bm       = 0;
                $getDataPlu->i_total    = 0;
                return (['kode' => 2, 'msg' => "Pada Transaksi BTB Lain2, Discount 1 tidak boleh diisi !", 'data' => '']);
            }

            $getDataPlu->i_disc1 = $getDataPlu->i_rphdisc1;

            if (!$noPo) {
                if (!$supplier) {
                    $getDataPlu->i_totaldisc = ($getDataPlu->i_rphdisc1 + $getDataPlu->i_rphdisc2 + $getDataPlu->i_rphdisc2a + $getDataPlu->i_rphdisc2b + $getDataPlu->i_rphdisc3 + $getDataPlu->i_rphdisc4) * $getDataPlu->i_bonus2;
                } else {
                    $getDataPlu->i_totaldisc = ($getDataPlu->i_rphdisc1 + $getDataPlu->i_rphdisc2 + $getDataPlu->i_rphdisc2a + $getDataPlu->i_rphdisc2b + $getDataPlu->i_rphdisc3 + $getDataPlu->i_rphdisc4) *
                        ($getDataPlu->i_qty * $getDataPlu->i_frac + $getDataPlu->i_qtyk);
                }
            } else {
                $getDataPlu->i_totaldisc = ($getDataPlu->i_rphdisc1 + $getDataPlu->i_rphdisc2 + $getDataPlu->i_rphdisc2a + $getDataPlu->i_rphdisc2b + $getDataPlu->i_rphdisc3 + $getDataPlu->i_rphdisc4);
            } // Line 1105

            $this->param_ndpp    = $getDataPlu->i_gross - $getDataPlu->i_totaldisc;
            $getDataPlu->i_ppn   = ($data->sup_pkp == 'Y' && $data->prd_flagbkp1 == 'Y') ? 0.11 * $this->param_ndpp : 0;
            $getDataPlu->i_total = round(($this->param_ndpp + $getDataPlu->i_ppn + $getDataPlu->i_bm + $getDataPlu->i_botol));
            $getDataPlu->i_disc1 = (!$noPo) ? $getDataPlu->i_rphdisc1 * ($getDataPlu->i_qty * $getDataPlu->i_frac + $getDataPlu->i_qtyk)  : $getDataPlu->i_rphdisc1;

            if ($getDataPlu->i_rphdisc2 < 0) {
                $this->param_error = 0;
                return (['kode' => 2, 'msg' => "Potongan 2 (Rp) harus >= 0", 'data' => '']);
            }
            if ($getDataPlu->i_rphdisc2a < 0) {
                $this->param_error = 0;
                return (['kode' => 2, 'msg' => "Potongan 2 A (Rp) harus >= 0", 'data' => '']);
            }
            if ($getDataPlu->i_rphdisc2b < 0) {
                $this->param_error = 0;
                return (['kode' => 2, 'msg' => "Potongan 2 B (Rp) harus >= 0", 'data' => '']);
            }

            if (!$noPo && !$supplier && $getDataPlu->i_rphdisc2 != 0) { //Line 1152
                $getDataPlu->i_rphdisc2 = 0;
                $getDataPlu->i_disc2    = 0;
                $getDataPlu->i_ppn      = 0;
                $getDataPlu->i_botol    = 0;
                $getDataPlu->i_bm       = 0;
                $getDataPlu->i_total    = 0;
                return (['kode' => 2, 'msg' => "Pada Transaksi BTB Lain2, Discount 2 tidak boleh diisi !", 'data' => '']);
            }
            if (!$noPo && !$supplier && $getDataPlu->i_rphdisc2a != 0) { //Line 1152
                $getDataPlu->i_rphdisc2a = 0;
                $getDataPlu->i_disc2a    = 0;
                $getDataPlu->i_ppn      = 0;
                $getDataPlu->i_botol    = 0;
                $getDataPlu->i_bm       = 0;
                $getDataPlu->i_total    = 0;
                return (['kode' => 2, 'msg' => "Pada Transaksi BTB Lain2, Discount 2 A tidak boleh diisi !", 'data' => '']);
            }
            if (!$noPo && !$supplier && $getDataPlu->i_rphdisc2b != 0) { //Line 1152
                $getDataPlu->i_rphdisc2b = 0;
                $getDataPlu->i_disc2b    = 0;
                $getDataPlu->i_ppn      = 0;
                $getDataPlu->i_botol    = 0;
                $getDataPlu->i_bm       = 0;
                $getDataPlu->i_total    = 0;
                return (['kode' => 2, 'msg' => "Pada Transaksi BTB Lain2, Discount 2 B tidak boleh diisi !", 'data' => '']);
            }

            $getDataPlu->i_disc2  = $getDataPlu->i_rphdisc2;
            $getDataPlu->i_disc2a = $getDataPlu->i_rphdisc2a;
            $getDataPlu->i_disc2b = $getDataPlu->i_rphdisc2b;

            if (!$noPo) {
                if (!$supplier) {
                    $getDataPlu->i_totaldisc = ($getDataPlu->i_rphdisc1 + $getDataPlu->i_rphdisc2 + $getDataPlu->i_rphdisc2a + $getDataPlu->i_rphdisc2b + $getDataPlu->i_rphdisc3 + $getDataPlu->i_rphdisc4) *
                        $getDataPlu->i_bonus1;
                } else {
                    $getDataPlu->i_totaldisc = ($getDataPlu->i_rphdisc1 + $getDataPlu->i_rphdisc2 + $getDataPlu->i_rphdisc2a + $getDataPlu->i_rphdisc2b + $getDataPlu->i_rphdisc3 + $getDataPlu->i_rphdisc4) *
                        ($getDataPlu->i_qty * $getDataPlu->i_frac + $getDataPlu->i_qtyk);
                }
            } else {
                $getDataPlu->i_totaldisc = ($getDataPlu->i_rphdisc1 + $getDataPlu->i_rphdisc2 + $getDataPlu->i_rphdisc2a + $getDataPlu->i_rphdisc2b + $getDataPlu->i_rphdisc3 + $getDataPlu->i_rphdisc4);
            } // Line 1230

            $this->param_ndpp    = $getDataPlu->i_gross - $getDataPlu->i_totaldisc;
            $getDataPlu->i_ppn   = ($data->sup_pkp == 'Y' && $data->prd_flagbkp1 == 'Y') ? 0.11 * $this->param_ndpp : 0;
            $getDataPlu->i_total = round(($this->param_ndpp + $getDataPlu->i_ppn + $getDataPlu->i_bm + $getDataPlu->i_botol));
            $getDataPlu->i_disc2 = (!$noPo) ? $getDataPlu->i_rphdisc2 * ($getDataPlu->i_qty * $getDataPlu->i_frac + $getDataPlu->i_qtyk)  : $getDataPlu->i_rphdisc2;
            $getDataPlu->i_disc2a = (!$noPo) ? $getDataPlu->i_rphdisc2a * ($getDataPlu->i_qty * $getDataPlu->i_frac + $getDataPlu->i_qtyk)  : $getDataPlu->i_rphdisc2a;
            $getDataPlu->i_disc2b = (!$noPo) ? $getDataPlu->i_rphdisc2b * ($getDataPlu->i_qty * $getDataPlu->i_frac + $getDataPlu->i_qtyk)  : $getDataPlu->i_rphdisc2b;

            if ($getDataPlu->i_rphdisc3 < 0) {
                $this->param_error = 0;
                return (['kode' => 2, 'msg' => "Potongan 3 (Rp) harus >= 0", 'data' => '']);
            }

            if (!$noPo && !$supplier && $getDataPlu->i_rphdisc3 != 0) { //Line 1269
                $getDataPlu->i_rphdisc3 = 0;
                $getDataPlu->i_disc3    = 0;
                $getDataPlu->i_ppn      = 0;
                $getDataPlu->i_botol    = 0;
                $getDataPlu->i_bm       = 0;
                $getDataPlu->i_total    = 0;
                return (['kode' => 2, 'msg' => "Pada Transaksi BTB Lain2, Discount 3 tidak boleh diisi !", 'data' => '']);
            }

            $getDataPlu->i_disc3  = $getDataPlu->i_rphdisc3;

            if (!$noPo) {
                if (!$supplier) {
                    $getDataPlu->i_totaldisc = ($getDataPlu->i_rphdisc1 + $getDataPlu->i_rphdisc2 + $getDataPlu->i_rphdisc2a + $getDataPlu->i_rphdisc2b + $getDataPlu->i_rphdisc3 + $getDataPlu->i_rphdisc4) *
                        $getDataPlu->i_bonus1;
                } else {
                    $getDataPlu->i_totaldisc = ($getDataPlu->i_rphdisc1 + $getDataPlu->i_rphdisc2 + $getDataPlu->i_rphdisc2a + $getDataPlu->i_rphdisc2b + $getDataPlu->i_rphdisc3 + $getDataPlu->i_rphdisc4) *
                        ($getDataPlu->i_qty * $getDataPlu->i_frac + $getDataPlu->i_qtyk);
                }
            } else {
                $getDataPlu->i_totaldisc = ($getDataPlu->i_rphdisc1 + $getDataPlu->i_rphdisc2 + $getDataPlu->i_rphdisc2a + $getDataPlu->i_rphdisc2b + $getDataPlu->i_rphdisc3 + $getDataPlu->i_rphdisc4);
            } // Line 1319

            $this->param_ndpp    = $getDataPlu->i_gross - $getDataPlu->i_totaldisc;
            $getDataPlu->i_ppn   = ($data->sup_pkp == 'Y' && $data->prd_flagbkp1 == 'Y') ? 0.11 * $this->param_ndpp : 0;
            $getDataPlu->i_total = round(($this->param_ndpp + $getDataPlu->i_ppn + $getDataPlu->i_bm + $getDataPlu->i_botol));
            $getDataPlu->i_disc3 = (!$noPo) ? $getDataPlu->i_rphdisc3 * ($getDataPlu->i_qty * $getDataPlu->i_frac + $getDataPlu->i_qtyk)  : $getDataPlu->i_rphdisc3;

            if ($getDataPlu->i_rphdisc4 < 0) {
                return (['kode' => 2, 'msg' => "Potongan 4 (Rp) harus >= 0", 'data' => '']);
            }

            if (!$noPo && !$supplier && $getDataPlu->i_rphdisc4 != 0) { //Line 1352
                $getDataPlu->i_rphdisc4 = 0;
                $getDataPlu->i_disc4    = 0;
                $getDataPlu->i_ppn      = 0;
                $getDataPlu->i_botol    = 0;
                $getDataPlu->i_bm       = 0;
                $getDataPlu->i_total    = 0;
                return (['kode' => 2, 'msg' => "Pada Transaksi BTB Lain2, Discount 4 tidak boleh diisi !", 'data' => '']);
            }

            $getDataPlu->i_disc4  = $getDataPlu->i_rphdisc4;

            if (!$noPo) {
                if (!$supplier) {
                    $getDataPlu->i_totaldisc = ($getDataPlu->i_rphdisc1 + $getDataPlu->i_rphdisc2 + $getDataPlu->i_rphdisc2a + $getDataPlu->i_rphdisc2b + $getDataPlu->i_rphdisc3 + $getDataPlu->i_rphdisc4) *
                        $getDataPlu->i_bonus1;
                } else {
                    $getDataPlu->i_totaldisc = ($getDataPlu->i_rphdisc1 + $getDataPlu->i_rphdisc2 + $getDataPlu->i_rphdisc2a + $getDataPlu->i_rphdisc2b + $getDataPlu->i_rphdisc3 + $getDataPlu->i_rphdisc4) *
                        ($getDataPlu->i_qty * $getDataPlu->i_frac + $getDataPlu->i_qtyk);
                }
            } else {
                $getDataPlu->i_totaldisc = ($getDataPlu->i_rphdisc1 + $getDataPlu->i_rphdisc2 + $getDataPlu->i_rphdisc2a + $getDataPlu->i_rphdisc2b + $getDataPlu->i_rphdisc3 + $getDataPlu->i_rphdisc4);
            } // Line 1402

            $this->param_ndpp    = $getDataPlu->i_gross - $getDataPlu->i_totaldisc;
            $getDataPlu->i_ppn   = ($data->sup_pkp == 'Y' && $data->prd_flagbkp1 == 'Y') ? 0.11 * $this->param_ndpp : 0;
            $getDataPlu->i_total = round(($this->param_ndpp + $getDataPlu->i_ppn + $getDataPlu->i_bm + $getDataPlu->i_botol));
            $getDataPlu->i_disc4 = (!$noPo) ? $getDataPlu->i_rphdisc4 * ($getDataPlu->i_qty * $getDataPlu->i_frac + $getDataPlu->i_qtyk)  : $getDataPlu->i_rphdisc4;
        } //end for each

        return (['kode' => '0', 'msg' => "Procedure success", 'data' => '']);
    }

    public function query3($prdcd, $kodeigr, $supplier, $noPo)
    {
        $data = DB::connection(Session::get('connection'))->select("SELECT prd_prdcd,
                                    prd_lastcost,
                                    prd_unit,
                                    prd_flagbkp1,
                                    prd_flagbkp2,
                                    prd_kategoritoko,
                                    prd_kodecabang,
                                    prd_kodetag,
                                    prd_flagbarangordertoko,
                                    prd_kodedivisi,
                                    prd_frac,
                                    st_avgcost,
                                    st_prdcd,
                                    st_saldoakhir,
                                    hgb_kodesupplier,
                                    hgb_prdcd,
                                    hgb_hrgbeli,
                                    hgb_tglmulaibonus01,
                                    hgb_tglakhirbonus01,
                                    hgb_flagkelipatanbonus01,
                                    hgb_qtymulai1bonus01,
                                    hgb_qty1bonus01,
                                    hgb_qtymulai2bonus01,
                                    hgb_qtymulai3bonus01,
                                    hgb_qty2bonus01,
                                    hgb_qtymulai4bonus01,
                                    hgb_qty3bonus01,
                                    hgb_qtymulai5bonus01,
                                    hgb_qty4bonus01,
                                    hgb_qtymulai6bonus01,
                                    hgb_qty5bonus01,
                                    hgb_qty6bonus01,
                                    hgb_tglmulaibonus02,
                                    hgb_tglakhirbonus02,
                                    hgb_flagkelipatanbonus02,
                                    hgb_qtymulai1bonus02,
                                    hgb_qty1bonus02,
                                    hgb_qtymulai2bonus02,
                                    hgb_qtymulai3bonus02,
                                    hgb_qty2bonus02,
                                    hgb_qty3bonus02,
                                    hgb_ppnbotol,
                                    hgb_ppnbm,
                                    tag_tidakbolehorder,
                                    sup_pkp,
                                    tpod_qtypo,
                                    tpod_prdcd,
                                    tpod_isibeli,
                                    tpod_hrgsatuan,
                                    tpod_rphttldisc,
                                    tpod_gross,
                                    tpod_ppnbm,
                                    tpod_ppnbotol,
                                    tpod_rphdisc1,
                                    tpod_rphdisc2,
                                    tpod_rphdisc2ii,
                                    tpod_rphdisc2iii,
                                    tpod_rphdisc3,
                                    tpod_rphdisc4,
                                    tpod_rphdisc4df,
                                    tpod_rphdisc4cash,
                                    tpod_rphdisc4retur,
                                    prs_toleransihrg
                                FROM    TBMASTER_PRODMAST prdo,
                                        TBMASTER_STOCK stck,
                                        TBMASTER_SUPPLIER supp,
                                        TBMASTER_HARGABELI harga,
                                        TBMASTER_TAG mtag,
                                        TBTR_PO_D pod,
                                        TBMASTER_PERUSAHAAN persh
                                WHERE   prdo.prd_prdcd = '$prdcd'
                                    AND prdo.prd_kodeigr = '$kodeigr'
                                    AND stck.st_prdcd(+) = prd_prdcd
                                    AND stck.st_kodeigr(+) = prd_kodeigr
                                    AND stck.st_lokasi(+) = '01'
                                    AND supp.sup_kodesupplier(+) = '$supplier'
                                    AND supp.sup_kodeigr(+) = '$kodeigr'
                                    AND harga.hgb_prdcd(+) = prd_prdcd
                                    AND harga.hgb_kodeigr(+) = prd_kodeigr
                                    AND harga.hgb_tipe(+) = '2'
                                    AND mtag.tag_kodetag(+) = prd_kodetag
                                    AND mtag.tag_kodeigr(+) = prd_kodeigr
                                    AND pod.tpod_prdcd(+) = prd_prdcd
                                    AND pod.tpod_nopo(+) = '$noPo'
                                    AND pod.tpod_kodeigr(+) = prd_kodeigr
                                    AND persh.prs_kodeigr = prd_kodeigr");
        return $data;
    }

    public function changeHargaBeli(Request $request)
    {
        $hrgbeli    = $request->hargaBeli;
        $prdcd      = $request->prdcd;
        $supplier   = $request->supplier;
        $noPo       = $request->noPo;
        $qty        = $request->qty;
        $qtyk       = $request->qtyk;
        $kodeigr    = Session::get('kdigr');
        $tempDataPlu = $request->tempDataPLU;
        $this->getDataPlu = (object) $tempDataPlu;
        $this->getDataPlu->i_hrgbeli = $hrgbeli;
        $this->getDataPlu->i_qty = $qty;
        $this->getDataPlu->i_qtyk = $qtyk;
        $msg        = '';
        $kode       = 0;
        $chkGets    = $this->chkGets(2, $prdcd, $kodeigr, $supplier, $noPo);
        if ($chkGets['kode'] == 2) {
            if ($this->param_error == 0) {
                $msg = $chkGets['msg'];
            } elseif ($this->param_error == 2) {
                $msg = " Selisih cost terlalu besar";
            } elseif ($this->param_error == 3) {
                $msg = $chkGets['msg'];
            }
        } else {
            $kode = 1;
            $msg  = "Success";
        }

        return response()->json(['kode' => $kode, 'msg' => $msg, 'data' => $this->getDataPlu]);
    }

    public function changeQty(Request $request)
    {
        $hrgbeli    = $request->hargaBeli;
        $prdcd      = $request->prdcd;
        $supplier   = $request->supplier;
        $noPo       = $request->noPo;
        $qty        = $request->qty;
        $qtyk       = $request->qtyk;
        $kodeigr    = Session::get('kdigr');
        $tempDataPlu = $request->tempDataPLU;
        $this->getDataPlu = (object) $tempDataPlu;
        $msg        = '';
        $kode       = 0;

        $dataPoD  = DB::connection(Session::get('connection'))->table("TBTR_PO_D")->where('tpod_kodeigr', $kodeigr)->where('tpod_nopo', $noPo)->where('tpod_prdcd', $prdcd)->get()->toArray();

        if ($dataPoD) {
            $temp = $dataPoD[0];
            $this->getDataPlu->i_rphdisc1 = ($temp->tpod_rphdisc1 / $temp->tpod_qtypo) * (($qty * $temp->tpod_isibeli) + $qtyk);
            $this->getDataPlu->i_rphdisc2 = ($temp->tpod_rphdisc2 / $temp->tpod_qtypo) * (($qty * $temp->tpod_isibeli) + $qtyk);
            $this->getDataPlu->i_rphdisc2a = ($temp->tpod_rphdisc2ii / $temp->tpod_qtypo) * (($qty * $temp->tpod_isibeli) + $qtyk);
            $this->getDataPlu->i_rphdisc2b = ($temp->tpod_rphdisc2iii / $temp->tpod_qtypo) * (($qty * $temp->tpod_isibeli) + $qtyk);
            $this->getDataPlu->i_rphdisc3 = ($temp->tpod_rphdisc3 / $temp->tpod_qtypo) * (($qty * $temp->tpod_isibeli) + $qtyk);
            $this->getDataPlu->i_rphdisc4 = (($temp->tpod_rphdisc4cash + $temp->tpod_rphdisc4retur + $temp->tpod_rphdisc4df) / $temp->tpod_qtypo) * (($qty * $temp->tpod_isibeli) + $qtyk);
            $this->getDataPlu->i_rphdisc5 = ($temp->tpod_rphdisc4cash / $temp->tpod_qtypo) * (($qty * $temp->tpod_isibeli) + $qtyk);
            $this->getDataPlu->i_rphdisc6 = ($temp->tpod_rphdisc4retur / $temp->tpod_qtypo) * (($qty * $temp->tpod_isibeli) + $qtyk);
            $this->getDataPlu->i_dis4cr   = $this->getDataPlu->i_rphdisc5;
            $this->getDataPlu->i_dis4jr   = $this->getDataPlu->i_rphdisc4 - $this->getDataPlu->i_rphdisc5 + $this->getDataPlu->i_rphdisc6;
            $this->getDataPlu->i_dis4rr   = $this->getDataPlu->i_rphdisc6;
        }

        $this->getDataPlu->i_qty = $qty;
        $this->getDataPlu->i_qtyk = $qtyk;
        $this->getDataPlu->i_hrgbeli = $hrgbeli;

        $chkGets    = $this->chkGets(2, $prdcd, $kodeigr, $supplier, $noPo);

        if ($chkGets['kode'] == 2) {
            if ($this->param_error == 0) {
                $msg = $chkGets['msg'];
            }
        } else {
            $kode = 1;
            $msg  = "Success";
        }

        return response()->json(['kode' => $kode, 'msg' => $msg, 'data' => $this->getDataPlu]);
    }

    public function changeBonus1(Request $request)
    {
        $bonus1     = $request->bonus1;
        $prdcd      = $request->prdcd;
        $supplier   = $request->supplier;
        $noPo       = $request->noPo;
        $kodeigr    = Session::get('kdigr');
        $tempDataPlu = $request->tempDataPLU;
        $this->getDataPlu = (object) $tempDataPlu;
        $msg        = '';
        $kode       = 0;

        $this->getDataPlu->i_bonus1 = $bonus1;

        $chkGets    = $this->chkGets(2, $prdcd, $kodeigr, $supplier, $noPo);

        if ($chkGets['kode'] == 2) {
            if ($this->param_error == 0) {
                $msg = $chkGets['msg'];
            }
        } else {
            $kode = 1;
            $msg  = "Success";
        }

        return response()->json(['kode' => $kode, 'msg' => $msg, 'data' => $this->getDataPlu]);
    }

    public function changeRphDisc(Request $request)
    {
        $prdcd = $request->prdcd;
        $supplier = $request->supplier;
        $noPo = $request->noPo;
        $kodeigr = Session::get('kdigr');
        $tempDataPlu = $request->tempDataPLU;
        $this->getDataPlu = (object)$tempDataPlu;
        $msg = '';
        $kode = 0;

        $chkGets    = $this->chkGets(7, $prdcd, $kodeigr, $supplier, $noPo);

        if ($chkGets['kode'] == 2) {
            if ($this->param_error == 0) {
                $msg = $chkGets['msg'];
            }
        } else {
            $kode = 1;
            $msg  = "Success";
        }

        return response()->json(['kode' => $kode, 'msg' => $msg, 'data' => $this->getDataPlu]);
    }

    public function rekamData(Request $request)
    {
        $prdcd  = $request->prdcd;
        $noBtb  = $request->noBTB;
        $noPo   = $request->noPo;
        $rte = $request->rte;
        $kodeigr = Session::get('kdigr');
        $tempDataPlu = $request->tempDataPLU;
        $tempData    = $request->tempDataSave;
        $this->getDataPlu = (object)$tempDataPlu;
        $data = $this->getDataPlu; //**** tempdataplu -> getdataplu supaya berbentuk object. dari getdataplu ke data supaya pakainya lebih mudah
        if ($tempData) {
            foreach ($tempData as $datas) {
                if ($datas['trbo_prdcd'] != $prdcd) {
                    array_push($this->tempDataSave, $datas);
                }
            }
        }
        if ($noPo) {
            $checkBtb   = DB::connection(Session::get('connection'))->table('tbtr_backoffice')->where('trbo_nodoc', $noBtb)->get()->toArray();

            if ($checkBtb) {
                //            --- Tidak dipakai, karena validasi pas pakai noPO ini belum bisa dibuat, karena ketika halaman ditutup, belum bisa update otomatis supaya noPO dapat di pakai oleh user lain
                //            UPDATE TBTR_PO_H
                //            SET TPOH_RECORDID = NULL
                //            WHERE TPOH_NOPO = :NO_PO AND NVL (TPOH_RECORDID, '9') <> 'X';
                //
                //            UPDATE TBTR_PO_D
                //            SET TPOD_RECORDID = NULL
                //            WHERE  TPOD_NOPO = :NO_PO AND NVL (TPOD_RECORDID, '9') <> 'X' AND NVL (TPOD_QTYPB, 0) = 0;

                $msg = "Nomor BPB " . $noBtb . " Sudah Ada di TBTR_BACKOFFICE !! Hubungi EDP !!";

                return response()->json(['kode' => 0, 'msg' => $msg, 'data' => $data]);
            } else {
                //            if (((int)$data->i_totalpo) - ((int)$data->grant_total) > 500){
                //                return response()->json(['kode' => 0, 'msg' => "Selisih Total PO > 500 !!", 'data' => '']);
                //            } // ----- Tidak dipakai karena tidak ada yg init i_totalpo dan grant_total
                if ($rte == 'Y') {
                    if ($this->param_rec == 0) {
                        $temp = new \stdClass();
                        $temp->trbo_prdcd       = $prdcd;
                        $temp->trbo_kodetag     = '';
                        $temp->trbo_bkp         = '';
                        $temp->trbo_hrgsatuan   = $data->price;
                        $temp->qty              = $data->i_qty;
                        $temp->qtyk             = $data->i_qtyk;
                        $temp->trbo_qty         = $data->i_qtyk;
                        $temp->trbo_qtybonus1   = 0;
                        $temp->trbo_qtybonus2   = 0;
                        $temp->trbo_persendisc1   = 0;
                        $temp->trbo_rphdisc1   = 0;
                        $temp->trbo_persendisc2 = 0;
                        $temp->trbo_rphdisc2    = 0;
                        $temp->trbo_persendisc2ii = 0;
                        $temp->trbo_rphdisc2ii  = 0;
                        $temp->trbo_persendisc2iii = 0;
                        $temp->trbo_rphdisc2iii = 0;
                        $temp->trbo_persendisc3 = 0;
                        $temp->trbo_rphdisc3    = 0;
                        $temp->trbo_persendisc4 = 0;
                        $temp->trbo_rphdisc4    = 0;
                        $temp->trbo_keterangan   = $data->nama_file;
                        $temp->barang           = $data->nama;
                        $temp->trbo_averagecost = $data->price;
                        $temp->trbo_lcost       = $data->price;
                        $temp->kemasan          = 'PCS';
                        $temp->total_disc       = 0;
                        $temp->total_rph        = $data->price;
                        $temp->trbo_gross       = $data->i_gross;
                        $temp->trbo_ppnrph      = $data->ppnrp;
                        $temp->trbo_ppnbmrph    = 0;
                        $temp->trbo_ppnbtlrph   = 0;
                        $temp->trbo_kodeigr     = $kodeigr;
                        $temp->trbo_kodedivisi  = $data->div;
                        $temp->trbo_kodedepartement = '';
                        $temp->trbo_kodekategoribrg = $data->rtype;
                        $temp->trbo_unit        = '';
                        $temp->trbo_frac        = '';
                        $temp->item             = 1;
                        $temp->trbo_flagdisc1   = '';
                        $temp->trbo_flagdisc2   = '';
                        $temp->trbo_flagdisc3   = '';
                        $temp->trbo_flagdisc4   = '';
                        $temp->trbo_discrph     = 0;
                        $temp->trbo_dis4cp      = 0;
                        $temp->trbo_dis4cr      = 0;
                        $temp->trbo_dis4rp      = 0;
                        $temp->trbo_dis4rr      = 0;
                        $temp->trbo_dis4jp      = 0;
                        $temp->trbo_dis4jr      = 0;
                        $this->param_seqno      = $this->param_seqno + 1;
                        $temp->trbo_seqno       = $this->param_seqno;
                        $temp->trbo_furgnt      = '';
                        $temp->trbo_oldcost     = '';

                        array_push($this->tempDataSave, $temp);

                        $qtypb = $data->i_qty + $data->i_qtyk;
                        DB::connection(Session::get('connection'))->table('tbtr_po_d')
                            ->where('tpod_kodeigr', $kodeigr)->where('tpod_nopo', $noPo)->where('tpod_prdcd', $prdcd)
                            ->update(['tpod_qtypb' => $qtypb, 'tpod_recordid' => 2]);

                        DB::connection(Session::get('connection'))->table('tbtr_po_h')->where('tpoh_nopo', $noPo)->update(['tpoh_recordid' => 2]);

                        return response()->json(['kode' => 1, 'msg' => "Rekam Data Berhasil", 'data' => $this->tempDataSave]);
                    }
                }
                if ($data->i_qty * $data->i_frac + $data->i_qtyk > $data->qty_po) {
                    $data->i_qty = floor($data->qty_po / $data->tpod_isibeli);
                    $data->i_qtyk = $data->qty_po - ($data->i_qty * $data->tpod_isibeli);

                    return response()->json(['kode' => 0, 'msg' => "Kuantum melebihi PO", 'data' => $data]);
                } else {
                    //               --- Part dimana cek parameter.arr_plu di hilangkan karena bisa pakai tempDataSave

                    if ($this->param_rec == 0) {
                        $temp = new \stdClass();

                        $temp->trbo_prdcd       = $prdcd;
                        $temp->trbo_kodetag     = $data->i_tag;
                        $temp->trbo_bkp         = $data->i_bkp;
                        $temp->trbo_hrgsatuan    = $data->i_hrgbeli;
                        $temp->qty              = $data->i_qty;
                        $temp->qtyk             = $data->i_qtyk;
                        $temp->trbo_qty         = ($data->i_qty * $data->i_frac) + $data->i_qtyk;
                        $temp->trbo_qtybonus1   = $data->i_bonus1;
                        $temp->trbo_qtybonus2   = $data->i_bonus2;
                        $temp->trbo_persendisc1   = $data->i_persendis1;
                        $temp->trbo_rphdisc1   = $data->i_rphdisc1;
                        $temp->trbo_persendisc2 = $data->i_persendis2;
                        $temp->trbo_rphdisc2    = $data->i_rphdisc2;
                        $temp->trbo_persendisc2ii = $data->i_persendis2a;
                        $temp->trbo_rphdisc2ii  = $data->i_rphdisc2a;
                        $temp->trbo_persendisc2iii = $data->i_persendis2b;
                        $temp->trbo_rphdisc2iii = $data->i_rphdisc2b;
                        $temp->trbo_persendisc3 = $data->i_persendis3;
                        $temp->trbo_rphdisc3    = $data->i_rphdisc3;
                        $temp->trbo_persendisc4 = $data->i_persendis4;
                        $temp->trbo_rphdisc4    = $data->i_rphdisc4;
                        $temp->trbo_keterangan   = $data->i_keterangan;
                        $temp->trbo_bkp         = $data->i_bkp;
                        $temp->trbo_kodetag     = $data->i_tag;
                        $temp->barang           = $data->i_barang;
                        $temp->trbo_averagecost = ($data->i_unit == 'KG') ? $data->i_acost * 1 : $data->i_acost * $data->i_frac;
                        $temp->trbo_lcost       = $data->i_lcost;
                        $temp->kemasan          = $data->i_kemasan;
                        $temp->total_disc       = $data->i_totaldisc;
                        $temp->total_rph        = $data->i_total;
                        $temp->trbo_gross       = $data->i_gross;
                        $temp->trbo_ppnrph      = $data->i_ppn;
                        $temp->trbo_ppnbmrph    = $data->i_bm;
                        $temp->trbo_ppnbtlrph   = $data->i_botol;
                        $temp->trbo_kodeigr     = $kodeigr;
                        $temp->trbo_kodedivisi  = $data->tpod_kodedivisi;
                        $temp->trbo_kodedepartement = $data->tpod_kodedepartemen;
                        $temp->trbo_kodekategoribrg = $data->tpod_kategoribarang;
                        $temp->trbo_unit        = $data->i_unit;
                        $temp->trbo_frac        = $data->i_frac;
                        $temp->item             = 1;
                        $temp->trbo_flagdisc1   = $data->i_flagdisc1;
                        $temp->trbo_flagdisc2   = $data->i_flagdisc2;
                        $temp->trbo_flagdisc3   = $data->i_flagdisc3;
                        $temp->trbo_flagdisc4   = $data->i_flagdisc4;
                        $temp->trbo_discrph     = $data->i_disc1 + $data->i_disc2 + $data->i_disc2a + $data->i_disc2b + $data->i_disc3 + $data->i_disc4;
                        $temp->trbo_dis4cp      = $data->i_dis4cp;
                        $temp->trbo_dis4cr      = $data->i_dis4cr;
                        $temp->trbo_dis4rp      = $data->i_dis4rp;
                        $temp->trbo_dis4rr      = $data->i_dis4rr;
                        $temp->trbo_dis4jp      = $data->i_dis4jp;
                        $temp->trbo_dis4jr      = $data->i_dis4jr;
                        $this->param_seqno      = $this->param_seqno + 1;
                        $temp->trbo_seqno       = $this->param_seqno;
                        $temp->trbo_furgnt      = $data->i_jenispb;
                        $temp->trbo_oldcost     = $data->i_lcost;

                        array_push($this->tempDataSave, $temp);

                        $qtypb = ($data->i_qty * $data->i_frac) + $data->i_qtyk;
                        DB::connection(Session::get('connection'))->table('tbtr_po_d')
                            ->where('tpod_kodeigr', $kodeigr)->where('tpod_nopo', $noPo)->where('tpod_prdcd', $prdcd)
                            ->update(['tpod_qtypb' => $qtypb, 'tpod_recordid' => 2]);

                        DB::connection(Session::get('connection'))->table('tbtr_po_h')->where('tpoh_nopo', $noPo)->update(['tpoh_recordid' => 2]);
                    }
                }
            }
        } else {
            if ($this->param_rec == 0) {
                $temp = new \stdClass();
                if (!isset($data->i_keterangan)) {
                    $data->i_keterangan = '';
                }
                $temp->trbo_prdcd       = $prdcd;
                $temp->trbo_kodetag     = $data->i_tag;
                $temp->trbo_bkp         = $data->i_bkp;
                $temp->trbo_hrgsatuan    = $data->i_hrgbeli;
                $temp->qty              = $data->i_qty;
                $temp->qtyk             = $data->i_qtyk;
                $temp->trbo_qty         = ($data->i_qty * $data->i_frac) + $data->i_qtyk;
                $temp->trbo_qtybonus1   = $data->i_bonus1;
                $temp->trbo_persendisc1   = $data->i_persendis1;
                $temp->trbo_rphdisc1   = $data->i_rphdisc1;
                $temp->trbo_persendisc2 = $data->i_persendis2;
                $temp->trbo_rphdisc2    = $data->i_rphdisc2;
                $temp->trbo_persendisc2ii = $data->i_persendis2a;
                $temp->trbo_rphdisc2ii  = $data->i_rphdisc2a;
                $temp->trbo_persendisc2iii = $data->i_persendis2b;
                $temp->trbo_rphdisc2iii = $data->i_rphdisc2b;
                $temp->trbo_persendisc3 = $data->i_persendis3;
                $temp->trbo_rphdisc3    = $data->i_rphdisc3;
                $temp->trbo_persendisc4 = $data->i_persendis4;
                $temp->trbo_rphdisc4    = $data->i_rphdisc4;
                $temp->trbo_keterangan   = $data->i_keterangan;
                $temp->trbo_bkp         = $data->i_bkp;
                $temp->trbo_kodetag     = $data->i_tag;
                $temp->barang           = $data->i_barang;
                $temp->trbo_averagecost = ($data->i_unit == 'KG') ? $data->i_acost * 1 : $data->i_acost * $data->i_frac;
                $temp->trbo_lcost       = $data->i_lcost;
                $temp->kemasan          = $data->i_kemasan;
                $temp->total_disc       = $data->i_totaldisc;
                $temp->total_rph        = $data->i_total;
                $temp->trbo_gross       = $data->i_gross;
                $temp->trbo_ppnrph      = $data->i_ppn;
                $temp->trbo_ppnbmrph    = $data->i_bm;
                $temp->trbo_ppnbtlrph   = $data->i_botol;
                $temp->trbo_kodeigr     = $kodeigr;
                $temp->trbo_kodedivisi  = $data->i_kodedivisi;
                $temp->trbo_kodedepartement = $data->i_kodedepartement;
                $temp->trbo_kodekategoribrg = $data->i_kodekategoribrg;
                $temp->trbo_unit        = $data->i_unit;
                $temp->trbo_frac        = $data->i_frac;
                $temp->item             = 1;
                $temp->trbo_flagdisc1   = $data->i_flagdisc1;
                $temp->trbo_flagdisc2   = $data->i_flagdisc2;
                $temp->trbo_flagdisc3   = $data->i_flagdisc3;
                $temp->trbo_flagdisc4   = $data->i_flagdisc4;
                $temp->trbo_discrph     = $data->i_disc1 + $data->i_disc2 + $data->i_disc2a + $data->i_disc2b + $data->i_disc3 + $data->i_disc4;
                $this->param_seqno      = $this->param_seqno + 1;
                $temp->trbo_seqno       = $this->param_seqno;
                $temp->trbo_oldcost     = $data->i_lcost;

                array_push($this->tempDataSave, $temp);

                $qtypb = ($data->i_qty * $data->i_frac) + $data->i_qtyk;
            }
        }
        return response()->json(['kode' => 1, 'msg' => "Rekam Data Berhasil", 'data' => $this->tempDataSave]);
    }

    public function transferPO(Request $request)
    {
        $supplier = $request->supplier;
        $noPo   = $request->noPo;
        $kodeigr = Session::get('kdigr');


        $temp1 = DB::connection(Session::get('connection'))->select("SELECT NVL (COUNT (1), 0) as temp1
                                      FROM TBTR_BACKOFFICE
                                     WHERE TRBO_KODEIGR = '$kodeigr' AND TRBO_NOPO = NVL('$noPo', '123') AND NVL(trbo_recordid, '0') <> 1
                                         AND NVL(TRBO_RECORDID, '0') <> 1");

        $temp2 = DB::connection(Session::get('connection'))->select("SELECT NVL (COUNT (1), 0) as temp2
                                      FROM TBTR_MSTRAN_D
                                     WHERE MSTD_KODEIGR = '$kodeigr' AND MSTD_NOPO = NVL('$noPo', '123') AND MSTD_TYPETRN = 'B'  AND NVL(MSTD_RECORDID, '0') <> 1");

        if ($temp1[0]->temp1 != 0 || $temp2[0]->temp2 != 0) {
            return response()->json(['kode' => 2, 'msg' => "Nomor Dokumen Ini Sudah Terdapat di TBTR_BACKOFFICE / TBTR_MSTRAN_D, Program Akan Keluar Otomatis !!", 'data' => '']);
        }

        if ($noPo == '' || !$noPo) {
            return response()->json(['kode' => 2, 'msg' => "Check No PO", 'data' => '']);
        }

        $recID  = DB::connection(Session::get('connection'))->select("SELECT NVL (TPOH_RECORDID, 0)
                                      FROM TBTR_PO_H
                                     WHERE TPOH_NOPO = '$noPo' AND TPOH_KODEIGR = '$kodeigr'");

        if ($recID == 'X') {
            return response()->json(['kode' => 2, 'msg' => "PO Sedang Dipakai di DCP", 'data' => '']);
        }

        $getPOData  = $this->getPOData($kodeigr, $supplier, $noPo);

        return response()->json(['kode' => $getPOData['kode'], 'msg' => $getPOData['msg'], 'data' => $this->tempDataSave]);
    }

    public function getPOData($kodeigr, $supplier, $noPo)
    {
        $query4 = $this->query4($kodeigr, $supplier, $noPo);
        $query5 = $this->query5($kodeigr, $supplier, $noPo);
        if (!$query4) {
            return (['kode' => 2, 'msg' => "Data tidak ada !!", 'data' => '']);
        }
        $this->tempDataSave = [];

        // IF :parameter.rte = 'Y'
        // foreach ($query5 as $data) {
        //     DB::connection(Session::get('connection'))->table("tbtr_po_d")->where('docno', $noPo)->where('kirim', $supplier)->where('prdcd', $data->prd_plumcg)->where('toko', $kodeigr)->update(['no_bpb' => $noPo, 'tgl_bpb' => Carbon::now()->format('d-m-Y')]);
        //     $temp = new \stdClass();
        //     $temp->trbo_nopo = $data->docno;
        //     $temp->trbo_prdcd = $data->prd_prdcd;
        //     $temp->trbo_kodeigr = $kodeigr;
        //     $temp->trbo_unit = $data->prd_unit;
        //     $temp->trbo_frac = $data->prd_frac;
        //     $temp->trbo_bkp = $data->prd_flagbkp1;
        //     $temp->trbo_keterangan = $data->tpod_keterangan;
        //     $temp->qty = floor($data->qty_po / $data->prd_frac);
        //     $temp->qtyk = (int) fmod($data->qty_po, $data->prd_frac);
        //     $temp->trbo_lcost = $data->prd_lastcost;
        //     $temp->trbo_averagecost = ($data->prd_unit == 'KG') ? $data->st_avgcost * 1 : $data->st_avgcost * $data->prd_isibeli;
        //     $temp->trbo_oldcost = $data->prd_lastcost;
        //     $temp->barang = $data->prd_deskripsipanjang;
        //     $temp->trbo_kodetag = $data->prd_kodetag;
        //     $temp->nprice = ($data->prd_unit != 'KG') ? $data->price * $data->prd_frac : $data->price;
        //     $temp->trbo_gross = (floor($data->qty_po / $data->prd_frac) * $temp->nprice) + (((int) fmod($data->qty_po, $data->prd_frac)) * ($temp->nprice / $data->prd_frac));
        //     $temp->ndpp = $data->gross;
        //     $temp->trbo_hrgsatuan =  $temp->nprice;
        //     $temp->trbo_bkp = $data->prd_flagbkp1;
        //     $temp->trbo_fobkp = $data->prd_flagbkp2;
        //     $temp->trbo_persenppn = $data->tpod_persenppn;
        //     $temp->trbo_ppnrph = ($data->sup_pkp == 'Y' && $data->prd_flagbkp1 == 'Y') ? ($data->prd_ppn / 100) * $temp->ndpp : 0;
        //     $temp->trbo_qty = $data->qty_po;
        //     $temp->flag_update = 1;
        //     $temp->total_rph = $temp->trbo_gross - $temp->trbo_discrph + $temp->trbo_ppnrph + $temp->trbo_ppnbmrph + $temp->trbo_ppnbtlrph;
        //     $temp->total_disc = $temp->trbo_rphdisc1 + $temp->trbo_rphdisc2 + $temp->trbo_rphdisc2ii + $temp->trbo_rphdisc2iii + $temp->trbo_rphdisc3 + $temp->trbo_rphdisc4;
        //     $this->param_seqno = $this->param_seqno + 1;
        //     $temp->trbo_seqno = $this->param_seqno;
        //     $temp->item = 1;
        //     array_push($this->tempDataSave, $temp);
        // }

        foreach ($query4 as $data) {
            DB::connection(Session::get('connection'))->table("tbtr_po_d")->where('tpod_nopo', $noPo)->where('tpod_prdcd', $data->tpod_prdcd)->where('tpod_kodeigr', $kodeigr)
                ->update(['tpod_qtypb' => $data->qty_po, 'tpod_recordid' => '2']);
            $temp = new \stdClass();
            $temp->trbo_nopo = $data->tpod_nopo;
            $temp->trbo_prdcd = $data->tpod_prdcd;
            $temp->trbo_kodeigr = $kodeigr;
            $temp->trbo_unit = $data->tpod_satuanbeli;
            $temp->trbo_frac = $data->tpod_isibeli;
            $temp->trbo_isibeli = $data->tpod_isibeli;
            $temp->trbo_bkp = $data->prd_flagbkp1;
            $temp->trbo_keterangan = $data->tpod_keterangan;
            $temp->qty = floor($data->qty_po / $data->tpod_isibeli);
            $temp->qtyk = (int) fmod($data->qty_po, $data->tpod_isibeli);
            $temp->trbo_lcost = $data->prd_lastcost;
            $temp->trbo_averagecost = ($data->prd_unit == 'KG') ? $data->st_avgcost * 1 : $data->st_avgcost * $data->prd_isibeli;
            $temp->trbo_oldcost = $data->prd_lastcost;
            $temp->barang = $data->prd_deskripsipanjang;
            $temp->trbo_kodetag = $data->prd_kodetag;
            $temp->nprice = ($data->prd_unit != 'KG') ? $data->tpod_hrgsatuan * $data->tpod_isibeli : $data->tpod_hrgsatuan;
            $temp->trbo_qtybonus1 = $data->bonus1;
            $temp->trbo_qtybonus2 = $data->bonus2;
            $temp->trbo_gross = (floor($data->qty_po / $data->tpod_isibeli) * $temp->nprice) + (((int) fmod($data->qty_po, $data->tpod_isibeli)) * ($temp->nprice / $data->tpod_isibeli));
            $temp->trbo_persendisc1 = $data->tpod_persentasedisc1;
            $temp->trbo_rphdisc1 = $data->tpod_rphdisc1;
            $temp->trbo_flagdisc1 = $data->tpod_flagdisc1;
            $temp->trbo_persendisc2 = $data->tpod_persentasedisc2;
            $temp->trbo_rphdisc2 = $data->tpod_rphdisc2;
            $temp->trbo_persendisc2ii = $data->tpod_persentasedisc2ii;
            $temp->trbo_rphdisc2ii = $data->tpod_rphdisc2ii;
            $temp->trbo_persendisc2iii = $data->tpod_persentasedisc2iii;
            $temp->trbo_rphdisc2iii = $data->tpod_rphdisc2iii;
            $temp->trbo_flagdisc2 = $data->tpod_flagdisc2;
            $temp->trbo_persendisc3 = $data->tpod_persentasedisc3;
            $temp->trbo_rphdisc3 = $data->tpod_rphdisc3;
            $temp->trbo_flagdisc3 = $data->tpod_flagdisc3;
            $temp->trbo_persendisc4 = $data->dis4cp + $data->dis4rp + $data->dis4jp;
            $temp->trbo_rphdisc4 = $data->dis4cr + $data->dis4rr + $data->dis4jr;
            $temp->trbo_flagdisc4 = $data->tpod_flagdisc4;
            $temp->trbo_dis4cp = $data->dis4cp;
            $temp->trbo_dis4cr = $data->dis4cr;
            $temp->trbo_dis4rp = $data->dis4rp;
            $temp->trbo_dis4rr = $data->dis4rr;
            $temp->trbo_dis4jp = $data->dis4jp;
            $temp->trbo_dis4jr = $data->dis4jr;
            $temp->trbo_discrph = $data->tpod_rphttldisc;
            $temp->ndpp = $data->gross;
            $temp->trbo_furgnt = $data->tpod_jenispb;
            $temp->trbo_hrgsatuan =  $temp->nprice;
            $temp->trbo_bkp = $data->prd_flagbkp1;
            $temp->trbo_fobkp = $data->prd_flagbkp2;
            $temp->trbo_persenppn = $data->tpod_persenppn;
            $temp->trbo_ppnrph = ($data->sup_pkp == 'Y' && $data->prd_flagbkp1 == 'Y') ? ($data->tpod_persenppn / 100) * $temp->ndpp : 0;
            $temp->trbo_ppnbmrph = $data->tpod_ppnbm;
            $temp->trbo_ppnbtlrph = $data->tpod_ppnbotol;
            $temp->trbo_qty = $data->qty_po;
            $temp->flag_update = 1;
            $temp->total_rph = $temp->trbo_gross - $temp->trbo_discrph + $temp->trbo_ppnrph + $temp->trbo_ppnbmrph + $temp->trbo_ppnbtlrph;
            $temp->total_disc = $temp->trbo_rphdisc1 + $temp->trbo_rphdisc2 + $temp->trbo_rphdisc2ii + $temp->trbo_rphdisc2iii + $temp->trbo_rphdisc3 + $temp->trbo_rphdisc4;
            $this->param_seqno = $this->param_seqno + 1;
            $temp->trbo_seqno = $this->param_seqno;
            $temp->item = 1;
            array_push($this->tempDataSave, $temp);
        }
        return (['kode' => '0', 'msg' => "Procedure success", 'data' => '']);
    }
    public function query5($kodeigr, $supplier, $noPo)
    {
        $data   = DB::connection(Session::get('connection'))->select("SELECT SUBSTR (toko, 3, 2) toko,
                                    docno,
                                    tanggal1,
                                    prd_kodedivisi,
                                    prd_kodedepartement,
                                    prd_kodekategoribarang,
                                    prd_prdcd,
                                    sj_qty qty_po,
                                    price,
                                    prd_frac,
                                    NVL (gross, 0) gross,
                                    prd_deskripsipanjang,
                                    prd_flagbkp1,
                                    prd_flagbkp2,
                                    prd_unit,
                                    prd_lastcost,
                                    prd_kodetag,
                                    prd_plumcg,
                                    st_avgcost,
                                    st_lastcost,
                                    sup_pkp,
                                    prd_isibeli,
                                    prd_ppn
                            FROM TBHISTORY_NPD_RTE aa,
                                 tbmaster_prodmast bb,
                                 tbmaster_stock,
                                 tbmaster_supplier
                            WHERE docno = '$noPo'
                            AND kirim = '$supplier'
                            AND SUBSTR (toko, 3, 2) = '$kodeigr'
                            AND no_bpb IS NULL
                            AND bb.prd_plumcg = aa.prdcd
                            AND bb.prd_kodeigr = SUBSTR (aa.toko, 3, 2)
                            AND substr(bb.prd_prdcd, 7, 1) = '0'
                            AND st_prdcd(+) = bb.prd_prdcd
                            AND st_kodeigr(+) = bb.prd_kodeigr
                            AND st_lokasi(+) = '01'
                            AND sup_kodesupplier(+) = '$supplier'
                            AND sup_kodeigr(+) = '$kodeigr'
                      ORDER BY prd_prdcd");

        return $data;
    }

    public function query4($kodeigr, $supplier, $noPo)
    {
        $data   = DB::connection(Session::get('connection'))->select("SELECT  tpod_kodeigr,
                                             tpod_recordid,
                                             tpod_nopo,
                                             tpod_tglpo,
                                             tpod_kodedivisi,
                                             tpod_kodedepartemen,
                                             tpod_kategoribarang,
                                             tpod_prdcd,
                                             tpod_persenppn,
                                             NVL(tpod_qtypo, 0) qty_po,
                                             tpod_hrgsatuan,
                                             tpod_satuanbeli,
                                             tpod_isibeli,
                                             tpod_persentasedisc1,
                                             tpod_rphdisc1,
                                             tpod_flagdisc1,
                                             tpod_persentasedisc2,
                                             tpod_persentasedisc2ii,
                                             tpod_persentasedisc2iii,
                                             tpod_rphdisc2,
                                             tpod_rphdisc2ii,
                                             tpod_rphdisc2iii,
                                             tpod_flagdisc2,
                                             tpod_persentasedisc3,
                                             tpod_rphdisc3,
                                             tpod_flagdisc3,
                                             tpod_flagdisc4,
                                             tpod_jenispb,
                                             NVL(tpod_bonuspo1, 0) bonus1,
                                             NVL(tpod_bonuspo2, 0) bonus2,
                                             NVL(tpod_gross, 0) gross,
                                             NVL(tpod_rphttldisc, 0) tpod_rphttldisc,
                                             NVL(tpod_ppn, 0) tpod_ppn,
                                             NVL(tpod_ppnbm, 0) tpod_ppnbm,
                                             NVL(tpod_ppnbotol, 0) tpod_ppnbotol,
                                             NVL(tpod_persentasedisc4cashdisc, 0) dis4cp,
                                             NVL(tpod_rphdisc4, 0) dis4rp,
                                             NVL(tpod_persentasedisc4df, 0) dis4jp,
                                             NVL(tpod_rphdisc4cash, 0) dis4cr,
                                             NVL(tpod_rphdisc4retur, 0) dis4rr,
                                             NVL(tpod_rphdisc4df, 0) dis4jr,
                                             tpod_keterangan,
                                             prd_deskripsipanjang,
                                             prd_frac,
                                             prd_flagbkp1,
                                             prd_flagbkp2,
                                             prd_unit,
                                             prd_lastcost,
                                             prd_kodetag,
                                             st_avgcost,
                                             st_lastcost,
                                             sup_pkp,
                                             prd_isibeli
                                        FROM tbtr_po_d aa, tbmaster_prodmast bb, tbmaster_stock, tbmaster_supplier
                                       WHERE tpod_nopo = '$noPo'
                                         AND tpod_kodeigr = '$kodeigr'
                                         AND bb.prd_prdcd = aa.tpod_prdcd
                                         AND bb.prd_kodeigr = aa.tpod_kodeigr
                                         AND st_prdcd(+) = aa.tpod_prdcd
                                         AND st_kodeigr(+) = aa.tpod_kodeigr
                                         AND st_lokasi(+) = '01'
                                         AND sup_kodesupplier(+) = '$supplier'
                                         AND sup_kodeigr(+) = '$kodeigr'
                                    ORDER BY tpod_prdcd");

        return $data;
    }

    public function saveData(Request $request)
    {
        $typeTrn = $request->typeTrn;
        $tempdata   = $request->tempDataSave;
        $user       = Session::get('usid');
        $kodeigr    = Session::get('kdigr');
        $help       = new AllModel();
        $date       = $help->getDate();
        $noPo       = $request->noPO;
        $IP = str_replace('.', '0', SUBSTR(Session::get('ip'), -3));
        $connect = loginController::getConnectionProcedure();

        if ($typeTrn == 'B') {
            $query = oci_parse($connect, "BEGIN :ret := f_igr_get_nomorstadoc('$kodeigr','RTB','Nomor Reff BTB','$IP' || '0' ,6, TRUE); END;");
            oci_bind_by_name($query, ':ret', $fixNoBTB, 32);
            oci_execute($query);
        } else {
            $query = oci_parse($connect, "BEGIN :ret := f_igr_get_nomorstadoc('$kodeigr','RTL','Nomor Reff BTB Lain-Lain','$IP' || '1' ,6, TRUE); END;");
            oci_bind_by_name($query, ':ret', $fixNoBTB, 32);
            oci_execute($query);
        }

        try {
            if ($noPo) {
                foreach ($tempdata as $temp) {
                    $data = (object) $temp;

                    if (isset($data->trbo_persenppn) == false) {
                        $tax = 11;
                    } else {
                        $tax = $data->trbo_persenppn;
                    }
                    DB::connection(Session::get('connection'))->table('tbtr_backoffice')->insert([
                        "TRBO_KODEIGR" => $kodeigr,
                        "TRBO_RECORDID" => '',
                        "TRBO_TYPETRN" => $typeTrn,
                        "TRBO_NODOC" => $fixNoBTB,
                        "TRBO_TGLDOC" => $request->tglBTB,
                        "TRBO_NOREFF" => '',
                        "TRBO_TGLREFF" => '',
                        "TRBO_NOPO" => $request->noPO,
                        "TRBO_TGLPO" => $request->tglPO,
                        "TRBO_NOFAKTUR" => $request->noFaktur,
                        "TRBO_TGLFAKTUR" => $request->tglFaktur,
                        "TRBO_KODESUPPLIER" => $request->supplier,
                        "TRBO_SEQNO" => $data->trbo_seqno,
                        "TRBO_PRDCD" => $data->trbo_prdcd,
                        "TRBO_QTY" => $data->trbo_qty,
                        "TRBO_QTYBONUS1" => $data->trbo_qtybonus1,
                        "TRBO_QTYBONUS2" => $data->trbo_qtybonus2,
                        "TRBO_HRGSATUAN" => $data->trbo_hrgsatuan,
                        "TRBO_PERSENDISC1" => $data->trbo_persendisc1,
                        "TRBO_RPHDISC1" => $data->trbo_rphdisc1,
                        "TRBO_FLAGDISC1" => $data->trbo_flagdisc1,
                        "TRBO_PERSENDISC2" => $data->trbo_persendisc2,
                        "TRBO_RPHDISC2" => $data->trbo_rphdisc2,
                        "TRBO_FLAGDISC2" => $data->trbo_flagdisc2,
                        "TRBO_PERSENDISC2II" => $data->trbo_persendisc2ii,
                        "TRBO_RPHDISC2II" => $data->trbo_rphdisc2ii,
                        "TRBO_PERSENDISC2III" => $data->trbo_persendisc2iii,
                        "TRBO_RPHDISC2III" => $data->trbo_rphdisc2iii,
                        "TRBO_PERSENDISC3" => $data->trbo_persendisc3,
                        "TRBO_RPHDISC3" => $data->trbo_rphdisc3,
                        "TRBO_FLAGDISC3" => $data->trbo_flagdisc3,
                        "TRBO_PERSENDISC4" => $data->trbo_persendisc4,
                        "TRBO_RPHDISC4" => $data->trbo_rphdisc4,
                        "TRBO_FLAGDISC4" => $data->trbo_flagdisc4,
                        "TRBO_DIS4CP" => $data->trbo_dis4cp,
                        "TRBO_DIS4CR" => $data->trbo_dis4cr,
                        "TRBO_DIS4RP" => $data->trbo_dis4rp,
                        "TRBO_DIS4RR" => $data->trbo_dis4rr,
                        "TRBO_DIS4JP" => $data->trbo_dis4jp,
                        "TRBO_DIS4JR" => $data->trbo_dis4jr,
                        "TRBO_GROSS" => $data->trbo_gross,
                        "TRBO_DISCRPH" => $data->trbo_discrph,
                        "TRBO_PPNRPH" => $data->trbo_ppnrph,
                        "TRBO_PPNBMRPH" => $data->trbo_ppnbmrph,
                        "TRBO_PPNBTLRPH" => $data->trbo_ppnbtlrph,
                        "TRBO_AVERAGECOST" => $data->trbo_averagecost,
                        "TRBO_OLDCOST" => $data->trbo_oldcost,
                        "TRBO_KETERANGAN" => $data->trbo_keterangan,
                        "TRBO_FLAGDOC" => 0,
                        "TRBO_CREATE_BY" => $user,
                        "TRBO_CREATE_DT" => $date,
                        "TRBO_PERSENPPN" => $tax
                    ]);

                    if ($data->trbo_prdcd == '1381070') {
                        $query = oci_parse($connect, "BEGIN :no_krat := F_IGR_GET_NOMOR('$kodeigr', 'KRT', 'Nomor KRAT','K' || TO_CHAR (SYSDATE, 'yy'), 5, TRUE); END;");
                        oci_bind_by_name($query, ':no_krat', $result, 32);
                        oci_execute($query);
                        DB::connection(Session::get('connection'))->table('tbtr_krat_igr')->insert([
                            "krt_kodeigr" => $kodeigr,
                            "krt_nosj" => $request->noPO,
                            "krt_nobo" => $fixNoBTB,
                            "krt_prdcd" => $data->trbo_prdcd,
                            "krt_qty_bpb" => ($data->trbo_qty * $data->trbo_frac) + $data->qtyk,
                            "krt_nodraft" => $result,
                            "krt_qty_draft" => ($data->trbo_qty * $data->trbo_frac) + $data->qtyk,
                            "krt_qty_saldo" => ($data->trbo_qty * $data->trbo_frac) + $data->qtyk,
                            "krt_create_by" => $user,
                            "krt_create_dt" => $date
                        ]);
                    }
                }
            } else {
                foreach ($tempdata as $temp) {
                    $data = (object) $temp;

                    if (isset($data->trbo_persenppn) == false) {
                        $tax = 11;
                    } else {
                        $tax = $data->trbo_persenppn;
                    }
                    DB::connection(Session::get('connection'))->table('tbtr_backoffice')->insert([
                        "TRBO_KODEIGR" => $kodeigr,
                        "TRBO_RECORDID" => '',
                        "TRBO_TYPETRN" => $typeTrn,
                        "TRBO_NODOC" => $fixNoBTB,
                        "TRBO_TGLDOC" => $request->tglBTB,
                        "TRBO_NOREFF" => '',
                        "TRBO_TGLREFF" => '',
                        "TRBO_NOPO" => $request->noPO,
                        "TRBO_TGLPO" => $request->tglPO,
                        "TRBO_NOFAKTUR" => $request->noFaktur,
                        "TRBO_TGLFAKTUR" => $request->tglFaktur,
                        "TRBO_KODESUPPLIER" => $request->supplier,
                        "TRBO_SEQNO" => $data->trbo_seqno,
                        "TRBO_PRDCD" => $data->trbo_prdcd,
                        "TRBO_QTY" => $data->trbo_qty,
                        "TRBO_QTYBONUS1" => $data->trbo_qtybonus1,
                        "TRBO_QTYBONUS2" => 0,
                        "TRBO_HRGSATUAN" => $data->trbo_hrgsatuan,
                        "TRBO_PERSENDISC1" => $data->trbo_persendisc1,
                        "TRBO_RPHDISC1" => $data->trbo_rphdisc1,
                        "TRBO_FLAGDISC1" => $data->trbo_flagdisc1,
                        "TRBO_PERSENDISC2" => $data->trbo_persendisc2,
                        "TRBO_RPHDISC2" => $data->trbo_rphdisc2,
                        "TRBO_FLAGDISC2" => $data->trbo_flagdisc2,
                        "TRBO_PERSENDISC2II" => $data->trbo_persendisc2ii,
                        "TRBO_RPHDISC2II" => $data->trbo_rphdisc2ii,
                        "TRBO_PERSENDISC2III" => $data->trbo_persendisc2iii,
                        "TRBO_RPHDISC2III" => $data->trbo_rphdisc2iii,
                        "TRBO_PERSENDISC3" => $data->trbo_persendisc3,
                        "TRBO_RPHDISC3" => $data->trbo_rphdisc3,
                        "TRBO_FLAGDISC3" => $data->trbo_flagdisc3,
                        "TRBO_PERSENDISC4" => $data->trbo_persendisc4,
                        "TRBO_RPHDISC4" => $data->trbo_rphdisc4,
                        "TRBO_FLAGDISC4" => $data->trbo_flagdisc4,
                        "TRBO_DIS4CP" => 0,
                        "TRBO_DIS4CR" => 0,
                        "TRBO_DIS4RP" => 0,
                        "TRBO_DIS4RR" => 0,
                        "TRBO_DIS4JP" => 0,
                        "TRBO_DIS4JR" => 0,
                        "TRBO_GROSS" => $data->trbo_gross,
                        "TRBO_DISCRPH" => $data->trbo_discrph,
                        "TRBO_PPNRPH" => $data->trbo_ppnrph,
                        "TRBO_PPNBMRPH" => $data->trbo_ppnbmrph,
                        "TRBO_PPNBTLRPH" => $data->trbo_ppnbtlrph,
                        "TRBO_AVERAGECOST" => $data->trbo_averagecost,
                        "TRBO_OLDCOST" => $data->trbo_oldcost,
                        "TRBO_KETERANGAN" => $data->trbo_keterangan,
                        "TRBO_FLAGDOC" => 0,
                        "TRBO_CREATE_BY" => $user,
                        "TRBO_CREATE_DT" => $date,
                        "TRBO_PERSENPPN" => $tax
                    ]);
                }
            }
            return response()->json(['kode' => 1, 'msg' => "Simpan Data Berhasil !!", 'data' => '']);
        } catch (\Exception $catch) {
            return response()->json(['kode' => 0, 'msg' => $catch->getMessage(), 'data' => '']);
        }
    }

    public function get_string_between($string, $start, $end)
    {
        $string = ' ' . $string;
        $ini = strpos($string, $start);
        if ($ini == 0) return '';
        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;
        return substr($string, $ini, $len);
    }

    public function readQR(Request $request)
    {
        $path = 'qrcode/';
        chmod(storage_path($path . 'HEADER.zip'), 755);
        chmod(storage_path($path . 'DETAIL.zip'), 755);
        if (!(isset($request->header))) {
            return response()->json(['kode' => 0, 'msg' => 'HEADER Kosong!', 'data' => '']);
        } else {
            $header = substr($request->header, 0, -1);
            $header = strstr($header, '504B'); //remove all trash before PK Ext.
            //HEADER
            $length_header = strlen($header) / 2;
            $arr_head = array($length_header - 1);
            for ($i = 0; $i <= $length_header - 1; $i++) {
                $arr_head[$i] = intval(substr($header, 2 * $i, 2), 16);
            }
            $fp_head = fopen(storage_path($path . 'HEADER.zip'), 'wb+');
            while (!empty($arr_head)) {
                $byte1_head = array_shift($arr_head);
                $byte2_head = array_shift($arr_head);
                if (!$byte2_head) {
                    $byte2_head = 0;
                }
                fwrite($fp_head, pack("n*", ($byte1_head << 8) + $byte2_head));
            }
            fclose($fp_head);
        }

        if (!(isset($request->detail))) {
            return response()->json(['kode' => 0, 'msg' => 'DETAIL Kosong!', 'data' => '']);
        } else {
            $detail = substr($request->detail, 0, -1);
            $detail = strstr($detail, '504B'); //remove all trash before PK Ext.
            //DETAIL
            $length_detail = strlen($detail) / 2;
            $arr_detail = array($length_detail - 1);
            for ($i = 0; $i <= $length_detail - 1; $i++) {
                $arr_detail[$i] = intval(substr($detail, 2 * $i, 2), 16);
            }
            $fp_detail = fopen(storage_path($path . 'DETAIL.zip'), 'wb+');
            while (!empty($arr_detail)) {
                $byte1_detail = array_shift($arr_detail);
                $byte2_detail = array_shift($arr_detail);
                if (!$byte2_detail) {
                    $byte2_detail = 0;
                }
                fwrite($fp_detail, pack("n*", ($byte1_detail << 8) + $byte2_detail));
            }
            fclose($fp_detail);
        }
        //READ
        $hex_array_header = pack("H*", $header);
        $header_name_file = $this->get_string_between(strtoupper($hex_array_header), 'HEADER_', '.CSV');
        $name_header = 'HEADER_' . $header_name_file . '.CSV';
        if ($header_name_file == '') {
            return response()->json(['kode' => 2, 'msg' => 'Gagal Membaca File Header, Pastikan String QR adalah Header']);
        }

        $hex_array_detail = pack("H*", $detail);
        $detail_name_file = $this->get_string_between(strtoupper($hex_array_detail), 'DETAIL_', '.CSV');
        $name_detail = 'DETAIL_' . $detail_name_file . '.CSV';
        if ($detail_name_file == '') {
            return response()->json(['kode' => 2, 'msg' => 'Gagal Membaca File Detail, Pastikan String QR adalah Detail']);
        }


        $zip = new ZipArchive;
        $msg = '';
        //HEAD
        if ($zip->open('../storage/qrcode/HEADER.zip') === TRUE) {
            $zip->setPassword('PernahKejepit2XOuch!!');
            $zip->extractTo('../storage/qrcode/');
            $result_header = file_get_contents('../storage/qrcode/' . $name_header);
            $zip->close();
            $code = 0;
            $msg .= 'Berhasil membaca File Header | ';
        } else {
            $result_header = 'Gagal Baca Header';
            $code = 1;
            $msg .= 'Gagal Membaca File Header | ';
        }

        $result_header = explode("\r\n", $result_header);
        $result_header_col = explode("|", $result_header[0]);
        $result_header_row = explode("|", $result_header[1]);

        //DETAIL
        if ($zip->open('../storage/qrcode/DETAIL.zip') === TRUE) {
            $zip->setPassword('PernahKejepit2XOuch!!');
            $zip->extractTo('../storage/qrcode/');
            $result_detail = file_get_contents('../storage/qrcode/' . $name_detail);
            $zip->close();
            $code = 0;
            $msg .= 'Berhasil membaca File Detail';
        } else {
            $result_detail = $zip->open('../storage/qrcode/DETAIL.zip');
            $code = 1;
            $msg .= 'Gagal Membaca File Detail';
        }

        $result_detail = explode("\r\n", $result_detail);
        $result_detail_col = explode("|", $result_detail[0]);

        $length = count($result_detail);
        for ($i = 1; $i < $length - 1; $i++) {
            $result_detail_row[$i] = explode("|", $result_detail[$i]);
        }

        //INSERT TO DB
        //HEADER
        $toko = $result_header_row[0];
        $kirim = $result_header_row[1];
        $gembok = $result_header_row[2];
        $nosj = $result_header_row[3];
        $norang = $result_header_row[4];
        $jmlpart = $result_header_row[5];
        $jmlrecord = $result_header_row[6];

        $header = DB::connection(Session::get('connection'))->select("SELECT NOSJ FROM tbtr_npdqr_h WHERE NOSJ = '$nosj'");
        if ($header == null) {
            DB::connection(Session::get('connection'))->table('tbtr_npdqr_h')->insert([
                'TOKO' => $toko,
                'KIRIM' => $kirim,
                'GEMBOK' => $gembok,
                'NOSJ' => $nosj,
                'NORANG' => $norang,
                'JMLPART' => $jmlpart,
                'JMLRECORD' => $jmlrecord
            ]);
        } else {
            DB::connection(Session::get('connection'))->table('tbtr_npdqr_h')
                ->where('NOSJ', $nosj)
                ->update([
                    'TOKO' => $toko,
                    'KIRIM' => $kirim,
                    'GEMBOK' => $gembok,
                    'NORANG' => $norang,
                    'JMLPART' => $jmlpart,
                    'JMLRECORD' => $jmlrecord
                ]);
        }

        //DETAIL
        $length = count($result_detail_row);

        for ($j = 1; $j < $length + 1; $j++) {
            $docno = $result_detail_row[$j][0];
            $picno = $result_detail_row[$j][1];
            $pictgl = $result_detail_row[$j][2];
            $prdcd = $result_detail_row[$j][3];
            $sj_qty = $result_detail_row[$j][4];
            $price = $result_detail_row[$j][5];
            $ppnrp = $result_detail_row[$j][6];
            $hpp = $result_detail_row[$j][7];
            $keter = $result_detail_row[$j][8];
            $tanggal1 = $result_detail_row[$j][9];
            $tanggal2 = $result_detail_row[$j][10];
            $docno2 = $result_detail_row[$j][11];
            $dus_no = $result_detail_row[$j][12];
            $ppn_rate = $result_detail_row[$j][13];

            $detail = DB::connection(Session::get('connection'))->select(
                "SELECT PRDCD FROM tbtr_npdqr_d
                    WHERE PRDCD = '$prdcd'"
            );

            $npd_rte = DB::connection(Session::get('connection'))->select(
                "SELECT PRDCD FROM tbhistory_npd_rte
                    WHERE PRDCD = '$prdcd'"
            );

            if ($npd_rte == null) {
                DB::connection(Session::get('connection'))->table('tbhistory_npd_rte')->insert([
                    'BAR' => '',
                    'CREATE_BY' => Session::get('userid'),
                    'CREATE_DT' => Carbon::now()->format('Ymd'),
                    'DIV' => '',
                    'DOCNO' => $docno,
                    'DOCNO2' => $docno2,
                    'DUS_NO' => $dus_no,
                    'GROSS' => '',
                    'HPP' => $hpp,
                    'KETER' => $keter,
                    'KIRIM' => $kirim,
                    'LT' => '',
                    'NAMA' => '',
                    'NAMA_FILE' => $name_detail,
                    'NO_BPB' => '',
                    'PICNO' => $picno,
                    'PICNOT' => '',
                    'PICTGL' => Carbon::parse($pictgl)->format('Ymd'),
                    'PPNRP' => $ppnrp,
                    'PPN_RATE' => $ppn_rate,
                    'PRDCD' => $prdcd,
                    'PRICE' => $price,
                    'QTY' => '',
                    'RAK' => '',
                    'RECID' => '',
                    'RTYPE' => '',
                    'SEQNO' => '',
                    'SJ_QTY' => $sj_qty,
                    'STATUS' => '',
                    'TANGGAL1' => Carbon::parse($tanggal1)->format('Ymd'),
                    'TANGGAL2' => Carbon::parse($tanggal2)->format('Ymd'),
                    'TGL_BPB' => '',
                    'TOKO' => $toko
                ]);
            } else {
                DB::connection(Session::get('connection'))->table('tbhistory_npd_rte')
                    ->where('PRDCD', $prdcd)
                    ->update([
                        'BAR' => '',
                        'CREATE_BY' => Session::get('userid'),
                        'CREATE_DT' => Carbon::now()->format('Ymd'),
                        'DIV' => '',
                        'DOCNO2' => $docno2,
                        'DUS_NO' => $dus_no,
                        'GROSS' => '',
                        'HPP' => $hpp,
                        'KETER' => $keter,
                        'KIRIM' => $kirim,
                        'LT' => '',
                        'NAMA' => '',
                        'NAMA_FILE' => $name_detail,
                        'NO_BPB' => '',
                        'PICNO' => $picno,
                        'PICNOT' => '',
                        'PICTGL' => Carbon::parse($pictgl)->format('Ymd'),
                        'PPNRP' => $ppnrp,
                        'PPN_RATE' => $ppn_rate,
                        'PRDCD' => $prdcd,
                        'PRICE' => $price,
                        'QTY' => '',
                        'RAK' => '',
                        'RECID' => '',
                        'RTYPE' => '',
                        'SEQNO' => '',
                        'SJ_QTY' => $sj_qty,
                        'STATUS' => '',
                        'TANGGAL1' => Carbon::parse($tanggal1)->format('Ymd'),
                        'TANGGAL2' => Carbon::parse($tanggal2)->format('Ymd'),
                        'TGL_BPB' => '',
                        'TOKO' => $toko
                    ]);
            }

            if ($detail == null) {
                DB::connection(Session::get('connection'))->table('tbtr_npdqr_d')->insert([
                    'DOCNO' => $docno,
                    'PICNO' => $picno,
                    'PICTGL' => Carbon::parse($pictgl)->format('Ymd'),
                    'PRDCD' => $prdcd,
                    'SJ_QTY' => $sj_qty,
                    'PRICE' => $price,
                    'PPNRP' => $ppnrp,
                    'HPP' => $hpp,
                    'KETER' => $keter,
                    'TANGGAL1' => Carbon::parse($tanggal1)->format('Ymd'),
                    'TANGGAL2' => Carbon::parse($tanggal2)->format('Ymd'),
                    'DOCNO2' => $docno2,
                    'DUS_NO' => $dus_no,
                    'PPN_RATE' => $ppn_rate
                ]);
            } else {
                DB::connection(Session::get('connection'))->table('tbtr_npdqr_d')
                    ->where('PRDCD', $prdcd)
                    ->update([
                        'DOCNO' => $docno,
                        'PICNO' => $picno,
                        'PICTGL' => Carbon::parse($pictgl)->format('Ymd'),
                        'PRDCD' => $prdcd,
                        'SJ_QTY' => $sj_qty,
                        'PRICE' => $price,
                        'PPNRP' => $ppnrp,
                        'HPP' => $hpp,
                        'KETER' => $keter,
                        'TANGGAL1' => Carbon::parse($tanggal1)->format('Ymd'),
                        'TANGGAL2' => Carbon::parse($tanggal2)->format('Ymd'),
                        'DOCNO2' => $docno2,
                        'DUS_NO' => $dus_no,
                        'PPN_RATE' => $ppn_rate
                    ]);
            }
        }
        return response()->json(['kode' => $code, 'msg' => $msg, 'header_row' => $result_header_row, 'header_col' => $result_header_col, 'detail_row' => $result_detail_row, 'detail_col' => $result_detail_col]);
    }
}
