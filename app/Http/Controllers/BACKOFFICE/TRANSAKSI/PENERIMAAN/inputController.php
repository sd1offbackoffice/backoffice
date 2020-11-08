<?php

namespace App\Http\Controllers\BACKOFFICE\TRANSAKSI\PENERIMAAN;

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
        $kodeigr    = $_SESSION['kdigr'];

        $data   = DB::select("SELECT DISTINCT TRBO_NODOC, TRBO_NOPO, TRBO_TGLREFF
                                        FROM TBTR_BACKOFFICE
                                       WHERE     TRBO_KODEIGR = '$kodeigr'
                                             AND TRBO_TYPETRN = '$typeTrn'
                                             AND NVL (TRBO_NONOTA, 'AA') = 'AA'
                                             AND NVL (TRBO_RECORDID, '0') <> '1'
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

        $data   = DB::select("SELECT a.*, b.prd_deskripsipanjang, b.prd_unit, b.prd_frac, b.prd_kodetag
                                      FROM tbtr_backoffice a
                                           LEFT JOIN tbmaster_prodmast b ON a.trbo_prdcd = b.prd_prdcd AND a.trbo_kodeigr = b.prd_kodeigr
                                             WHERE trbo_kodeigr = '$kodeigr'
                                               AND trbo_typetrn = '$typeTrn'
                                               AND trbo_nodoc = '$noDoc'");

        if (!$data){
            $msg = "Data tidak ada";

            return response()->json(['kode' => 0, 'msg' => $msg, 'data' => '']);
        } else {
            return response()->json(['kode' => 1, 'msg' => 'OKE', 'data' => $data]);
        }
    }

}
