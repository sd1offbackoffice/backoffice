<?php

namespace App\Http\Controllers\BACKOFFICE\TRANSAKSI\PENERIMAAN;

use App\AllModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class inputController extends Controller
{

    public $test = 10;
    public function index(){
        return view('BACKOFFICE/TRANSAKSI/PENERIMAAN.input');
    }

    public function showBTB(Request $request){
        $typeTrn    = $request->typeTrn;
        $value      = strtoupper($request->value);
        $kodeigr    = $_SESSION['kdigr'];

        $data   = DB::select("SELECT DISTINCT TRBO_NODOC, TRBO_NOPO, TRBO_TGLREFF
                                        FROM TBTR_BACKOFFICE
                                       WHERE     TRBO_KODEIGR = '$kodeigr'
                                             AND TRBO_TYPETRN = '$typeTrn'
                                             AND NVL (TRBO_NONOTA, 'AA') = 'AA'
                                             AND NVL (TRBO_RECORDID, '0') <> '1'
                                             AND (trbo_nodoc like '%$value%' or trbo_nopo like '%$value%')
                                    ORDER BY TRBO_TGLREFF DESC");

        return response()->json($data);
    }

    public function chooseBTB(Request $request){
        $noDoc  = $request->noDoc;
        $noPO   = $request->noPO;
        $typeTrn    = $request->typeTrn;
        $kodeigr= $_SESSION['kdigr'];

        $temp   = DB::select("SELECT NVL (COUNT (1), 0) as temp
                                      FROM TBTR_BACKOFFICE
                                     WHERE TRBO_KODEIGR = '$kodeigr' AND TRBO_NODOC = '$noDoc' AND TRBO_NOPO = NVL('$noPO', '123') AND NVL(TRBO_RECORDID, '0') <> 1");

        if ($temp[0]->temp == '0'){
            $msg = "Nomor Dokumen Ini Sudah Terdapat di TBTR_BACKOFFICE";

            return response()->json(['kode' => 0, 'msg' => $msg, 'data' => '']);
        }

        $temp   = DB::select("SELECT NVL (COUNT (1), 0) as temp
                                      FROM TEMP_GO
                                     WHERE KODEIGR = '$kodeigr'
                                       AND ISI_TOKO = 'Y'
                                       AND TRUNC (SYSDATE-30) BETWEEN TRUNC (PER_AWAL_REORDER) AND TRUNC (PER_AKHIR_REORDER)");

        $flagGO =  ($temp[0]->temp != '0') ? 'Y' :'N';

        $temp   = DB::select("SELECT NVL (COUNT (*), 0) as temp
                                      FROM TBTR_BACKOFFICE
                                     WHERE TRBO_NODOC = '$noDoc' AND TRBO_KODEIGR = '$kodeigr' AND TRBO_TYPETRN = 'L'");

        if ($temp[0]->temp != '0'){
            $recId  = DB::select("SELECT DISTINCT TRBO_RECORDID
                                           FROM TBTR_BACKOFFICE
                                          WHERE TRBO_NODOC = '$noDoc'
                                            AND TRBO_KODEIGR = '$kodeigr'
                                            AND TRBO_TYPETRN = 'L'");

            if ($recId){
                if ($recId[0]->trbo_recordid == '2'){
                    $msg = "Data BTB ini sudah Cetak NOTA, silakan dilihat di Menu Inquery BTB";

                    return response()->json(['kode' => 0, 'msg' => $msg, 'data' => '']);
                }
            }

        }

        $data   = DB::select("SELECT a.*, b.prd_deskripsipanjang, b.prd_unit, b.prd_frac, b.prd_kodetag, nvl(b.prd_flagbkp1, ' ') as prd_flagbkp1, c.sup_namasupplier, c.sup_pkp ,a.trbo_qty / b.prd_frac as qty
                                      FROM tbtr_backoffice a
                                           LEFT JOIN tbmaster_prodmast b ON a.trbo_prdcd = b.prd_prdcd AND a.trbo_kodeigr = b.prd_kodeigr
                                           LEFT JOIN tbmaster_supplier c ON a.trbo_kodesupplier = c.sup_kodesupplier and a.trbo_kodeigr = c.sup_kodeigr
                                             WHERE trbo_kodeigr = '$kodeigr'
                                               AND trbo_typetrn = '$typeTrn'
                                               AND trbo_nodoc = '$noDoc'
                                               AND NVL (prd_deskripsipanjang, 'FLAG') <> 'FLAG'
                                               ");


        if (!$data){
            $msg = "Data tidak ada";

            return response()->json(['kode' => 0, 'msg' => $msg, 'data' => '']);
        } else {
            return response()->json(['kode' => 1, 'msg' => 'OKE', 'data' => $data]);
        }
    }

    public function getNewNoBTB(Request $request){
        $typeTrn    = $request->typeTrn;
        $kodeigr    = $_SESSION['kdigr'];
        $IP         = str_replace('.', '0', SUBSTR($_SESSION['ip'], -3));
        $connect    = oci_connect('SIMSMG', 'SIMSMG', '192.168.237.193:1521/SIMSMG');

        if ($typeTrn == 'B'){
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

    public function showPO(Request $request){
        $typeTrn = $request->typeTrn;
        $kodeigr = $_SESSION['kdigr'];
        $value   = strtoupper($request->value);

        $data   = DB::select("SELECT tpoh_nopo,
                                           tpoh_tglpo,
                                           tpoh_kodesupplier,
                                           sup_namasupplier
                                      FROM (SELECT tpoh_nopo,
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
                                                   AND NVL (TRIM (tpoh_recordid), '0') != '1'
                                                   AND (tpoh_nopo like '%$value%' or tpoh_kodesupplier like '%$value%' or sup_namasupplier like '%$value%'))
                                     WHERE tgl > SYSDATE");

        return response()->json($data);
    }

    public function choosePO(Request $request){
        $typeTrn = $request->typeTrn;
        $noPO    = $request->noPo;
        $kodeigr = $_SESSION['kdigr'];
        $recid   = '';
        $awalgo  = '';
        $akhirgo = '';
        $lotorisasi = '';
        $flaggo  = 'N';

        $temp   = DB::select("SELECT NVL (COUNT (1), 0) as temp
                                      FROM TEMP_GO
                                     WHERE KODEIGR = '$kodeigr' AND ISI_TOKO = 'Y' 
                                       AND TRUNC (SYSDATE) BETWEEN TRUNC (PER_AWAL_REORDER) AND TRUNC (PER_AKHIR_REORDER)");

        if ($temp[0]->temp > 0){
            $flaggo = 'Y';
        }

        $temp1  = DB::select("SELECT NVL (COUNT (1), 0) as temp1
                                      FROM TBTR_BACKOFFICE
                                     WHERE     TRBO_KODEIGR = '$kodeigr'
                                           AND TRBO_NOPO = NVL ('$noPO', '123')
                                           AND NVL (TRBO_RECORDID, '0') <> 1");

        $temp2  = DB::select("SELECT NVL (COUNT (1), 0) as temp2
                                      FROM TBTR_MSTRAN_D
                                     WHERE     MSTD_KODEIGR = '$kodeigr'
                                           AND MSTD_NOPO = NVL ('$noPO', '123')
                                           AND MSTD_TYPETRN = 'B'
                                           AND NVL (MSTD_RECORDID, '0') <> 1");

        if ($temp1[0]->temp1 > 0 || $temp2[0]->temp2 > 0){
            $msg = "Nomor Dokumen Ini Sudah Terdapat di TBTR_BACKOFFICE / TBTR_MSTRAN_D";

            return response()->json(['kode' => 0, 'msg' => $msg, 'data' => '']);
        }

        $temp   = DB::select("SELECT NVL (COUNT (1), 0) as temp
                                      FROM TBTR_PO_H
                                     WHERE     TPOH_NOPO = '$noPO'
                                           AND TPOH_KODEIGR = '22'
                                           AND NVL (TRIM (TPOH_RECORDID), '0') != '2'
                                           AND NVL (TRIM (TPOH_RECORDID), '0') != '1'");

        if ($temp[0]->temp == 0){
            $msg = "No PO Tidak Terdaftar / Kuantitas PO sudah dipenuhi";

            return response()->json(['kode' => 0, 'msg' => $msg, 'data' => '']);
        }

//        $flaggo = 'Y';

        if ($flaggo == 'Y'){
            $temp   = DB::select("SELECT PER_AWAL_REORDER AS AWALGO, PER_AKHIR_REORDER AS AKHIRGO
                                      FROM TEMP_GO
                                     WHERE     KODEIGR = '$kodeigr'
                                           AND ISI_TOKO = 'Y'
                                           AND TRUNC (SYSDATE) BETWEEN TRUNC (PER_AWAL_REORDER)
                                                                   AND TRUNC (PER_AKHIR_REORDER)");

            if ($temp){
                $awalgo = $temp[0]->awalgo;
                $akhirgo= $temp[0]->akhirgo;
            }

            $temp   = DB::select("SELECT NVL (COUNT (1), 0) as temp
                                      FROM TBTR_PO_D
                                     WHERE     TPOD_NOPO = '$noPO'
                                           AND TPOD_KODEIGR = '$kodeigr'
                                           AND NVL (TRIM (TPOD_QTYPB), 0) = 0
                                           AND NVL (TRIM (TPOD_RECORDID), '0') != '1'");

            if ($temp[0]->temp == 0){
                $msg = "Kuantitas PO sudah dipenuhi Semua";

                return response()->json(['kode' => 0, 'msg' => $msg, 'data' => '']);
            }

            if ($recid == 'X'){
                $msg = "PO Sedang Dipakai di DCP";

                return response()->json(['kode' => 0, 'msg' => $msg, 'data' => '']);
            }

            $temp   = DB::select("SELECT TPOH_TGLPO as TGLPO, TPOH_JWPB as WKPO, TPOH_TGLPO + TPOH_JWPB as tgl
                       FROM TBTR_PO_H
                      WHERE     TPOH_NOPO = '$noPO'
                            AND TPOH_KODEIGR = '$kodeigr'");

            if ($temp){
                $msg     = '';
                if ($temp[0]->tgl <= $awalgo && $temp[0]->tgl >= $akhirgo){
                    $msg = "Umur P.O. untuk GO sudah melampaui Tanggal hari ini";
                    $lotorisasi = 1;
                } else {
                    $diff = date_diff(date_create($temp[0]->tglpo), date_create());
                    if ($diff->d > 7){
                        $msg  = "Tanggal P.O. sudah melampaui 1 minggu";
                        $lotorisasi = 1;
                    }
                }
            }

//            $lotorisasi = 0;
            if ($lotorisasi == 1){
//                return response()->json(['kode' => 2, 'msg' => $msg, 'data' => '']);
            } else {
                $checkPO    = $this->checkPO($flaggo,$typeTrn,$noPO,$kodeigr);
                return response()->json(['kode' => $checkPO['kode'], 'msg' => $checkPO['msg'], 'data' => $checkPO['data']]);
            }
        } else {
//-------------- ELSE DARI FLAGGO
            $temp   = DB::select("SELECT NVL (tpoh_flagcmo, 'N') as flagcmo
                                         FROM tbtr_po_h
                                        WHERE tpoh_nopo = '$noPO'");

            if ($temp[0]->flagcmo == 'Y'){
                $temp1  = DB::select("SELECT tpoh_tglkirimbrg as tglkirim
                                               FROM tbtr_po_h
                                              WHERE     tpoh_nopo = '$noPO'
                                                    AND tpoh_kodeigr = '$kodeigr'");

                if ($temp1){
                    $diff = date_diff(date_create($temp1[0]->tglkirim), date_create());
                    if ($diff->d != 0){
                        $msg = "PO Commit Order Harus Sesuai dengan Tgl Kirim barang".substr($temp1[0]->tglkirim,0,10);
                        return response()->json(['kode' => 0, 'msg' => $msg, 'data' => '']);
                    }
                } else {
                    $msg = "No PO Tidak Terdaftar / Kuantitas PO sudah dipenuhi";
                    return response()->json(['kode' => 0, 'msg' => $msg, 'data' => '']);
                }
            }

            $temp   = DB::select("SELECT NVL (TPOH_RECORDID, 0) as recid, TPOH_TGLPO, TPOH_JWPB, CASE WHEN (TPOH_TGLPO + TPOH_JWPB) < sysdate - 1 THEN 0 ELSE 1 END as cond1, CASE WHEN (TPOH_TGLPO - sysdate) > 7 THEN 0 ELSE 1 END as cond2
                                            FROM TBTR_PO_H
                                           WHERE     TPOH_NOPO = '$noPO'
                                                 AND TPOH_KODEIGR = '$kodeigr'");

            if ($temp[0]->recid == '2'){
                $msg = "Kuantitas PO sudah dipenuhi";
                return response()->json(['kode' => 0, 'msg' => $msg, 'data' => '']);

            } elseif ($temp[0]->recid == 'X') {
                $msg = "PO Sedang Dipakai di DCP";
                return response()->json(['kode' => 0, 'msg' => $msg, 'data' => '']);

            } else {
                if ($temp[0]->cond1 == '0'){
                    $msg = "Umur P.O. sudah melampaui Tanggal hari ini";
                    $lotorisasi = 1;
                } else{
                    if ($temp[0]->cond2 == '0'){
                        $msg = "Tanggal P.O. sudah melampaui 1 minggu";
                        $lotorisasi = 1;
                    }
                }

                if ($lotorisasi == 1){
                return response()->json(['kode' => 2, 'msg' => $msg, 'data' => '']);
                } else {
                    $checkPO    = $this->checkPO($flaggo,$typeTrn,$noPO,$kodeigr);
                    return response()->json(['kode' => $checkPO['kode'], 'msg' => $checkPO['msg'], 'data' => $checkPO['data']]);
                }
            }
        }

        return response()->json(['kode' => 0, 'msg' => "Something's Error", 'data' => '']);
    }

    public function checkPO($flaggo, $typeTrn, $noPO, $kodeigr){
        if ($typeTrn == 'L' && $noPO > 0){
            $msg = "Nomor PO tidak boleh diisi";
            return (['kode' => 0, 'msg' => $msg, 'data' => '']);
        }

        if ($flaggo == 'Y'){
            $temp   = DB::select("SELECT tpoh_tglpo as tglpo, tpoh_jwpb as wkpo, NVL (TRIM(tpoh_recordid), '0') recid
                                                  FROM tbtr_po_h
                                                 WHERE tpoh_nopo = '$noPO' AND tpoh_kodeigr = '$kodeigr'");

            if (!$temp){
                $msg = "No PO Tidak Terdaftar / Kuantitas PO sudah dipenuhi";
                return (['kode' => 0, 'msg' => $msg, 'data' => '']);
            } else {
                $recid = $temp[0]->recid;
            }
        } else {
            $temp   = DB::select("SELECT tpoh_tglpo, tpoh_jwpb, NVL (TRIM(tpoh_recordid), '0') recid
                                                  FROM tbtr_po_h
                                                 WHERE tpoh_nopo = '$noPO' AND tpoh_kodeigr = '$kodeigr'
                                                       AND NVL (TRIM(tpoh_recordid), '0') != '2'");

            if (!$temp){
                $msg = "No PO Tidak Terdaftar / Kuantitas PO sudah dipenuhi";
                return (['kode' => 0, 'msg' => $msg, 'data' => '']);
            } else {
                $recid = $temp[0]->recid;
            }

            if ($recid == '2'){
                $msg = "Kuantitas PO sudah dipenuhi";
                return (['kode' => 0, 'msg' => $msg, 'data' => '']);
            }
        }

        $temp   = DB::select("SELECT tpoh_nopo, tpoh_tglpo, tpoh_kodesupplier, sup_namasupplier, sup_singkatansupplier, tpoh_top, sup_pkp
                                              FROM tbtr_po_h, tbmaster_supplier
                                             WHERE tpoh_nopo = '$noPO'
                                               AND tpoh_kodeigr = '$kodeigr'
                                               AND sup_kodesupplier = tpoh_kodesupplier
                                               AND sup_kodeigr = tpoh_kodeigr");

//        ------------------ Update RecID menjadi 2, di komen karena di browser gk bisa update otomatis ke null ketika page ditutup
//                DB::table('tbtr_po_h')->where('tpoh_nopo', $noPO)->update(['tpoh_recordid' => 2]);
//                DB::table('tbtr_po_d')->where('tpod_nopo', $noPO)->update(['tpod_recordid' => 2]);

                return (['kode' => 1, 'msg' => '', 'data' => $temp]);
    }

    public function showSupplier(Request $request){
        $typeTrn = $request->typeTrn;
        $kodeigr = $_SESSION['kdigr'];
        $value   = strtoupper($request->value);

        $data   = DB::select("select sup_namasupplier || '/' || sup_Singkatansupplier sup_namasupplier, sup_kodesupplier, sup_pkp, sup_top
                                    from tbmaster_supplier
                                    where sup_kodeigr='$kodeigr'
                                    and (sup_namasupplier like '%$value%' or sup_kodesupplier like '%$value%')");

        return response()->json($data);
    }

    public function showPlu(Request $request) {
        $typeTrn = $request->typeTrn;
        $kodeigr = $_SESSION['kdigr'];
        $value   = strtoupper($request->value);
        $supplier= $request->supplier;
        $noPo    = $request->noPo;
        $typeLov = $request->typeLov;

        if ($typeLov == 'PLU'){
            $data   = DB::table('tbmaster_prodmast')
                ->select('prd_deskripsipanjang', 'prd_prdcd')
                ->join('tbmaster_stock', function ($join){
                    $join->on("st_prdcd", "prd_prdcd");
                    $join->on("st_kodeigr", "prd_kodeigr");
                })
                ->where('prd_kodesupplier', $supplier)
                ->where('st_kodeigr', $kodeigr)
                ->where('st_lokasi', '01')
                ->whereNotNull('st_avgcost')
                ->whereRaw("(prd_deskripsipanjang LIKE '%$value%' or prd_prdcd LIKE '%$value%')")
                ->limit(100)
                ->get()->toArray();

        } elseif ($typeLov == 'PLU_PO'){
            $data   = DB::select("select prd_deskripsipanjang, tpod_prdcd, prd_unit||'/'||prd_frac kemasan,
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
        } elseif ($typeLov == 'LOV155'){
            $data   = DB::table('tbmaster_prodmast')
                ->select('prd_deskripsipanjang', 'prd_prdcd')
                ->join('tbmaster_stock', function ($join){
                    $join->on("st_prdcd", "prd_prdcd");
                    $join->on("st_kodeigr", "prd_kodeigr");
                })
                ->where('st_kodeigr', $kodeigr)
                ->where('st_lokasi', '01')
                ->whereNotNull('st_avgcost')
                ->whereRaw("(prd_deskripsipanjang LIKE '%$value%' or prd_prdcd LIKE '%$value%')")
                ->limit(100)
                ->get()->toArray();
        }

        return response()->json($data);
    }

    public function choosePlu(Request $request){
        $typeTrn = $request->typeTrn;
        $prdcd   = $request->prdcd;
        $noDoc   = $request->noDoc;
        $noPo    = $request->noPo;
        $supplier= $request->supplier;
        $kodeigr = $_SESSION['kdigr'];

        $temp1  = DB::select("SELECT NVL (COUNT (1), 0) as temp1
                                      FROM TBTR_BACKOFFICE
                                     WHERE TRBO_KODEIGR = '$kodeigr' AND TRBO_NODOC = '$noDoc' AND TRBO_NOPO = NVL('$noPo', '123') AND TRBO_PRDCD = '$prdcd'
                                         AND NVL(TRBO_RECORDID, '0') <> 1");

        $temp2  = DB::select("SELECT NVL (COUNT (1), 0) as temp2
                                      FROM TBTR_MSTRAN_D
                                     WHERE MSTD_KODEIGR = '$kodeigr' AND MSTD_NOPO = NVL('$noPo', '123') AND MSTD_TYPETRN = 'B'
                                      AND MSTD_PRDCD = '$prdcd' AND NVL(MSTD_RECORDID, '0') <> 1");

        if ($temp2[0]->temp2 != '0'){
            $msg = "PLU Sudah di BTB !!";

            return response()->json(['kode' => 2, 'msg' => $msg, 'data' => '']);
        }

        if ($noPo != '' || $noPo) {
            $temp   = DB::select(" SELECT NVL (TPOH_RECORDID, 0) as recid
                                          FROM TBTR_PO_H
                                         WHERE TPOH_NOPO = '$noPo' AND TPOH_KODEIGR = '$kodeigr'");

            if ($temp[0]->recid == 'X'){
                $msg = "PO Sedang Dipakai di DCP";

                return response()->json(['kode' => 2, 'msg' => $msg, 'data' => '']);
            }
        }

//        check ke data temp yg udh di save sementara
        if (!$prdcd){
            $msg = "PLU ". $prdcd ." Sudah Ada, Silakan Edit !!";

            return response()->json(['kode' => 2, 'msg' => $msg, 'data' => '']);
        } else {
//            ----------------- Else dari prdcd yg di cek ke data temp

            if (!$noPo && $prdcd){
                if ($typeTrn != 'L'){
                    var_dump('asd');
//                    :I_FLAGDISC1 := 'K';
//                    :I_FLAGDISC2 := 'K';
//                    :I_FLAGDISC3 := 'K';
//                    :I_FLAGDISC4 := 'K';
                }

                $getItemData    = $this->getItemData($supplier, $prdcd, $kodeigr, $typeTrn, $noPo);

                return response()->json(['kode' => $getItemData[0], 'msg' => $getItemData[1], 'data' => $getItemData[2]]);
            } else {
//                -------------  if (!$noPo && $prdcd)
                $data   = DB::table('TBTR_BACKOFFICE')->where('trbo_prdcd', $prdcd)->first();

                if ($data->trbo_prdcd == $prdcd){
                    $status = 1;
                } else {
                    $status = 0;

                    if (!$data->trbo_prdcd){
                        //EXIT
                    }

                    //NEXT_RECORD
                }

                //CHK_GETS (1)
                $chkGets    = $this->chkGets(1,$prdcd,$kodeigr,$supplier,$noPo);

                dd($chkGets);

//                IF :PARAMETER.ERR = 0
//                THEN
//                    DC_ALERT.OK (:PARAMETER.ALERT);
//                    GO_BLOCK ('INPUT');
//                    CLEAR_BLOCK;
//                    RAISE FORM_TRIGGER_FAILURE;
//                        ELSE
//                            IF :PARAMETER.ERR = 5
//                    THEN
//                        DC_ALERT.OK (:PARAMETER.ALERT);
//                            ELSE
//                                NEXT_ITEM;
//                                END IF;
//                END IF;

                dd($data);

                return response()->json(['kode' => '1', 'msg' => 'data', 'data' => $data]);
            }
        }
    }

    public function getItemData($supplier, $prdcd, $kodeigr, $typeTrn, $noPo){
        if ($prdcd || $prdcd != null){
            $data   = $this->query1($supplier,$prdcd,$kodeigr);
            $data   = $data[0];

            if ($data->i_unit == 'KG'){
                $data->i_frac = 1;
            }

            if ($typeTrn == 'L'){
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

            if (!$data->kttk && !$data->kcab){
                return (['2', "PLU ".$prdcd." tidak sesuai kateory-nya", ""]);
            }

            if ($data->i_tag){
                if ($data->i_tag != 'T' && $data->i_tag != 'G' && $data->i_tag != 'Q' && $data->i_tag != 'U'){
                    if ($data->ftftbo == 'Y'){
                        return (['2', "PLU ".$prdcd." DISCONTINUE ( Flag Tidak Boleh Order )", ""]);
                    }

                    if ($data->ftfbot == 'Y' && !$noPo && $supplier){
                        return (['2', "PLU ".$prdcd." harus menggunakan PO", ""]);
                    }
                }
            }

            if ($data->v_lastcost > 0 && $data->st_prdcd ){
                $ndivcost   = abs($data->v_lastcost - ($data->i_acost * $data->i_frac)) / $data->v_lastcost;

                if ($ndivcost >= '0.20'){
                    return (['2', "Selisih cost terlalu besar", ""]);
                }
            }

            if (!$noPo && !$supplier && $data->st_saldoakhir <= 0){
                return (['2', "Stok Barang <= 0, tidak dapat menginput BPB Lain Lain ( ".$prdcd." )", ""]);
            }

            if ($data->i_unit == 'KG'){
                $data->i_frac = '1';
            }

            $data->i_kemasan  = $data->i_unit.' / '.$data->i_frac;

            if (!$noPo && !$supplier){
                $i_hrgbeli  = 0;
            } else {
                $i_hrgbeli      = ($data->v_hrgbeli * $data->i_frac) / (($data->i_unit == 'KG') ? 1000 : 1);
            }

            $data->i_lcost  = $data->v_lastcost;

            if (!$data->i_barang){
                return (['2', "Item Tidak Terdaftar", ""]);
            } elseif (!$i_hrgbeli){
                return (['2', "Harga Tidak Tercatat", ""]);
            }
        }

        return false;
    }

    public function query1($supplier, $prdcd, $kodeigr){
        $data   = DB::select("SELECT prd_kodeigr as i_kodeigr,
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
                                           st_saldoakhir as st_saldoakhir
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

    public function chkGets($col, $prdcd, $kodeigr, $supplier, $noPo){
        $data   = $this->query2($prdcd,$kodeigr,$supplier,$noPo);

        if (!$data){
            //EXIT
        } else {
            $data = $data[0];
        }

        $nilhrgbeli = $data->hgb_hrgbeli;
        $i_prdcd    = $prdcd;
        $i_qtypo    = $data->tpod_qtypo;

        if ($noPo){
            if (!$data->tpod_prdcd){
                return (['kode' => 2, 'msg' => "Kode Produk tidak terdaftar dalam No.PO ini :".$prdcd." !!!", 'data' => '']);
            }
        }

        if (!$data->prd_prdcd){
            return (['kode' => 2, 'msg' => "Kode Produk tidak terdaftar", 'data' => '']);
        }

        $nsvlcost   = $data->prd_lastcost;
        $nsvacost   = $data->st_avgcost * (($data->prd_unit == 'KG') ? 1 : $data->tpod_isibeli);
        $cbkp       = $data->prd_flagbkp1;
        $cfobkp     = $data->prd_flagbkp2;

        if (!$data->prd_kategoritoko && !$data->prd_kodecabang){
            return (['kode' => 2, 'msg' => "Produk ini tidak sesuai kategory-nya", 'data' => '']);
            //EXIT
        }


//        IF rec.prd_kategoritoko IS NULL AND rec.prd_kodecabang IS NULL
//          THEN
//          :parameter.alert := 'Produk ini tidak sesuai kategory-nya';
//             :parameter.err := 0;
//             EXIT;
//          END IF;


        return 0;
    }

    public function query2($prdcd, $kodeigr, $supplier, $noPo){
        $data   = DB::select("SELECT prd_prdcd,
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
                                FROM TBMASTER_PRODMAST prdo,
                                     TBMASTER_STOCK stck,
                                     TBMASTER_SUPPLIER supp,
                                     TBMASTER_HARGABELI harga,
                                     TBMASTER_TAG mtag,
                                     TBTR_PO_D pod,
                                     TBMASTER_PERUSAHAAN persh
                               WHERE     prdo.prd_prdcd = '$prdcd'
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




}












