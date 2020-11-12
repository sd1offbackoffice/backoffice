<?php

namespace App\Http\Controllers\BACKOFFICE\TRANSAKSI\PENERIMAAN;

use App\AllModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class inputController extends Controller
{
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

            if ($lotorisasi == 1){
                return response()->json(['kode' => 2, 'msg' => $msg, 'data' => '']);
            } else {
//-------------- PART : CHECK_PO
                if ($typeTrn == 'L' && $noPO > 0){
                    $msg = "Nomor PO tidak boleh diisi";

                    return response()->json(['kode' => 0, 'msg' => $msg, 'data' => '']);
                }

                if ($flaggo == 'Y'){

                } else {

                }

                dd('asd');
            }

        } else {
//-------------- ELSE DARI FLAGGO
            dd('flaggo');
        }




        return 'asd';
    }




}
