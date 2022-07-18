<?php

namespace App\Http\Controllers\BACKOFFICE\TRANSAKSI\PENERIMAAN;

use App\Http\Controllers\Auth\loginController;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\DataTables;
use PDF;
use Illuminate\Support\Facades\File;

class BreadController extends Controller
{
    public function index()
    {
        return view('BACKOFFICE.TRANSAKSI.PENERIMAAN.bread');
    }

    public function upload(Request $request)
    {
        if (!(isset($request->tgl))) {
            $tgltrf = Carbon::now()->format('dmY');
        } else {
            $tgltrf = Carbon::parse($request->tgl)->format('dmY');
        }
        $connect = loginController::getConnectionProcedureKMY();
        $query = oci_parse($connect, "BEGIN SP_PROSES_ROTI_IRPC_PHP(to_date(:txt_tgltrf, 'DD-MM-YYYY HH24:MI:SS'), :p_sukses, :p_result); END;");
        oci_bind_by_name($query, ':txt_tgltrf', $tgltrf);
        oci_bind_by_name($query, ':p_sukses', $p_sukses, 32);
        oci_bind_by_name($query, ':p_result', $hasil, 100);
        oci_execute($query);

        if ($p_sukses == 'N') { //FALSE
            return response()->json(['kode' => '1', 'message' => $hasil, 'p_sukses' => $p_sukses]);
        } else {
            return response()->json(['kode' => '0', 'message' => 'Data IRPC sudah di upload !!', 'p_sukses' => $p_sukses]);
        }
    }

    public function show()
    {
        $temp = DB::connection('simkmy')->select("SELECT * FROM (
            SELECT krt_nodraft, krt_nobpb, krt_tglbpb, krt_qty_bpb, krt_tglnrb, krt_qty_nrb
            FROM TBTR_KRAT_IGR WHERE trunc(krt_tglbpb) < trunc(SYSDATE) 
            ORDER BY krt_tglbpb DESC ) aa");

        return DataTables::of($temp)->make(true);
    }

    public function check(Request $request)
    {
        $nodraft = $request->nodraft;
        $tglDraft = $request->tglDraft;
        $temp = DB::connection('simkmy')->select("SELECT NVL (COUNT (1), 0)
                                                                    AS temp
                                                                    FROM TBTR_KRAT_IGR
                                                                    WHERE krt_nodraft = '$nodraft'");
        if ($temp[0]->temp == 0) {
            return response()->json(['kode' => '1', 'message' => 'Data Krat Tidak Ada !!', 'pointer' => '1']);
        } else {
            $temp = DB::connection('simkmy')->select("SELECT NVL (COUNT (*), 0)
                                                                        AS temp
                                                                        FROM (  SELECT krt_nodraft,
                                                                        krt_qty_draft,
                                                                        krt_nobpb,
                                                                        krt_tglbpb,
                                                                        krt_qty_bpb
                                                                        FROM TBTR_KRAT_IGR
                                                                        WHERE     TRUNC (krt_tglbpb) < TRUNC (SYSDATE)
                                                                        AND krt_tglnrb IS NULL
                                                                        ORDER BY krt_tglbpb DESC) aa
                                                                        WHERE ROWNUM = 1");
            if ($temp[0]->temp == 0) {
                return response()->json(['kode' => '1', 'message' => 'Data Draft Krat Tidak Ada !!', 'pointer' => '1']);
            }
            $data = DB::connection('simkmy')->select("SELECT krt_nodraft, krt_tglbpb
                                                                        FROM (  SELECT krt_nodraft,
                                                                                    krt_qty_draft,
                                                                                    krt_nobpb,
                                                                                    krt_tglbpb,
                                                                                    krt_qty_bpb
                                                                        FROM TBTR_KRAT_IGR
                                                                        WHERE     TRUNC (krt_tglbpb) < TRUNC (SYSDATE)
                                                                        AND krt_tglnrb IS NULL
                                                                        ORDER BY krt_tglbpb DESC) aa
                                                                        WHERE ROWNUM = 1");
            $draft = $data[0]->krt_nodraft;
            $tglbpb = date('Y-m-d', strtotime($data[0]->krt_tglbpb));
            //ambil saldo sebelumnya
            $temp = DB::connection('simkmy')->select("SELECT NVL (COUNT (1), 0)
                                                                        AS temp
                                                                        FROM (  SELECT NVL (krt_qty_saldo, 0) krt_qty_saldo, krt_tglbpb
                                                                        FROM TBTR_KRAT_IGR
                                                                        WHERE     krt_tglnrb IS NOT NULL
                                                                        AND TRUNC (krt_tglbpb) < '$tglbpb'
                                                                        ORDER BY krt_tglbpb DESC  ) aa
                                                                        WHERE ROWNUM = 1");
            $saldo_lalu = 0;
            if ($temp[0]->temp != 0) {
                $data = DB::connection('simkmy')->select("SELECT krt_qty_saldo AS saldo_lalu, krt_tglbpb
                                                                            FROM (  SELECT NVL (krt_qty_saldo, 0) krt_qty_saldo, krt_tglbpb
                                                                            FROM TBTR_KRAT_IGR
                                                                            WHERE     krt_tglnrb IS NOT NULL
                                                                            AND TRUNC (krt_tglbpb) < '$tglbpb'
                                                                            ORDER BY krt_tglbpb DESC) aa
                                                                            WHERE ROWNUM = 1");
                $saldo_lalu = $data[0]->saldo_lalu;
            }
            //ambil qt lalu
            $temp = DB::connection('simkmy')->select("SELECT NVL (COUNT (1), 0)
                                                                        AS temp
                                                                        FROM (SELECT *
                                                                        FROM TBTR_KRAT_IGR
                                                                        WHERE krt_tglnrb IS NULL AND krt_nodraft <> '$nodraft') aa");
            $qty_lalu = 0;
            if ($temp[0]->temp != 0) {
                $data = DB::connection('simkmy')->select("SELECT krt_qty_bpb AS qty_lalu
                                                                            FROM (SELECT SUM (NVL (krt_qty_bpb, 0)) krt_qty_bpb, krt_tglbpb
                                                                            FROM TBTR_KRAT_IGR
                                                                            WHERE     krt_tglnrb IS NULL
                                                                            AND krt_nodraft <> '$nodraft'
                                                                            AND TRUNC (krt_tglbpb) < '$tglDraft') aa");
                $qty_lalu = $data[0]->qty_lalu;
            }
            $data = DB::connection('simkmy')->select("SELECT  krt_tglbpb,
                                                                                krt_qty_draft,
                                                                                krt_nobpb,
                                                                                krt_qty_bpb,
                                                                                krt_prdcd,
                                                                                krt_qty_saldo,
                                                                                krt_recordid,
                                                                                NVL (krt_qty_nrb, 0) AS krt_qty_nrb
                                                                        FROM TBTR_KRAT_IGR
                                                                        WHERE krt_nodraft = '$nodraft'");
            $txt_tgldraft = $data[0]->krt_tglbpb;
            $txt_qty_draft = $data[0]->krt_qty_draft;
            $txt_nobpb = $data[0]->krt_nobpb;
            $txt_qty_bpb = $data[0]->krt_qty_bpb;
            $txt_prdcd = $data[0]->krt_prdcd;
            $txt_qty_saldo = $data[0]->krt_qty_saldo;
            $txt_status = $data[0]->krt_recordid;
            $txt_qty_nrb = $data[0]->krt_qty_nrb;
            $pointer = 0;

            if ($txt_status == 2) {
                $pointer = 2;
            }
            $txt_qty_draft = $txt_qty_draft + $qty_lalu + $saldo_lalu;
            $txt_qty_saldo  = $txt_qty_draft;
            if (date('d/m/Y', strtotime($txt_tgldraft)) <  date('d/m/Y', strtotime($tglbpb))) {
                return response()->json(['kode' => '0', 'message' => 'Data Draft terakhir dengan No ' . $draft, 'pointer' => '', 'draft' => $draft, 'tgl_draft' => '', 'qty_draft' => '', 'nopb' => '', 'qty_bpb' => '', 'prdcd' => '', 'qty_saldo' => '', 'status' => '', 'qty_nrb' => '']);
            } else {
                return response()->json(['kode' => '2', 'message' => '', 'pointer' => $pointer, 'draft' => $draft, 'tgl_draft' => $txt_tgldraft, 'qty_draft' => $txt_qty_draft, 'nopb' => $txt_nobpb, 'qty_bpb' => $txt_qty_bpb, 'prdcd' => $txt_prdcd, 'qty_saldo' => $txt_qty_saldo, 'status' => $txt_status, 'qty_nrb' => $txt_qty_nrb]);
            }
        }
    }

    public function cetak(Request $request)
    {
        $kodeigr = Session::get('kodeigr');
        $nodraft = $request->no;
        if (!(isset($nodraft))) {
            return response()->json(['kode' => '1', 'message' => 'Nomor Draft harus diisi !!', 'p_sukses' => 'N']);
        } else {
            $data = DB::connection('simkmy')->select("SELECT DISTINCT
                    krt_nodraft, krt_tglbpb, krt_nobpb, krt_prdcd, hgb_kodesupplier,
                    prd_deskripsipanjang, prd_satuanbeli, hgb_hrgbeli, sup_namasupplier,
                    sup_alamatsupplier1, sup_alamatsupplier2, sup_kotasupplier3,
                    sup_telpsupplier, sup_contactperson, sup_npwp, mstd_docno2,
                    mstd_frac, mstd_gross, mstd_qty, mstd_keterangan
                    FROM TBTR_KRAT_IGR, TBMASTER_HARGABELI, TBMASTER_PRODMAST, TBMASTER_SUPPLIER, TBTR_MSTRAN_D
                    WHERE krt_nodraft = '$nodraft'
                    AND krt_prdcd = prd_prdcd
                    AND hgb_prdcd = krt_prdcd
                    AND hgb_kodesupplier = sup_kodesupplier
                    AND krt_prdcd = mstd_prdcd
                    AND mstd_nopo = krt_nosj");

            $alamat = DB::connection(Session::get('connection'))->select("SELECT prs_alamat1, prs_alamat2, prs_alamat3
                                                    FROM TBMASTER_PERUSAHAAN
                                                    WHERE '$kodeigr' = prs_kodeigr");

            $pdf = PDF::loadview('BACKOFFICE.TRANSAKSI.PENERIMAAN.nota_pengeluaran_barang', ['data' => $data, 'alamat' => $alamat])->setPaper('a5', 'potrait');
            $pdf->output();

            $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);
            $canvas = $dompdf->get_canvas();
            $canvas->page_text(514, 10, "Page {PAGE_NUM} of {PAGE_COUNT}", null, 10, array(0, 0, 0));

            $path = 'retur/';
            if (!File::exists(storage_path($path))) {
                File::makeDirectory(storage_path($path), 0755, true, true);
            }

            for ($i = 0; $i < sizeof($data); $i++) {
                $content = $pdf->download()->getOriginalContent();
                $id = 'RETUR_' . $data[$i]->krt_nobpb . '_' . date("Ymd", strtotime($data[$i]->krt_tglbpb));
                $file = storage_path($path . $id . '.PDF');
                file_put_contents($file, $content);
            }

            return $pdf->stream('nota_pengeluaran_barang.PDF');
        }
    }

    public function process(Request $request)
    {
        $qty_nrb = $request->qty_nrb;
        $qty_draft = $request->qty_draft;
        $nodraft = $request->nodraft;
        $tgldraft = $request->tgldraft;
        $user = Session::get('usid');

        if ($qty_nrb > $qty_draft) {
            return response()->json(['kode' => '1', 'message' => 'Qty NRB tidak boleh > dari Qty Draft NRB !!', 'p_sukses' => 'N']);
        } else {
            DB::connection(Session::get('connection'))->table('tbtr_krat_igr')
                ->where('krt_nodraft', $nodraft)
                ->update([
                    'krt_recordid' => 2,
                    'krt_qty_draft' => $qty_draft,
                    'krt_qty_nrb' => $qty_nrb,
                    'krt_tglnrb' => Carbon::now()->format('d-m-Y'),
                    'krt_qty_saldo' => ($qty_draft - $qty_nrb),
                    'krt_modify_dt' => Carbon::now()->format('d-m-Y'),
                    'krt_modify_by' => $user
                ]);

            DB::connection(Session::get('connection'))->table('tbtr_krat_igr')
                ->where('krt_nodraft', '=', NULL)
                ->where('krt_tglbpb', '<', $tgldraft)
                ->update([
                    'krt_recordid' => 2,
                    'krt_tglnrb' => Carbon::now()->format('d-m-Y'),
                    'krt_modify_dt' => Carbon::now()->format('d-m-Y'),
                    'krt_modify_by' => $user
                ]);

            return response()->json(['kode' => '0', 'message' => 'NRB Dicetak', 'p_sukses' => 'Y', 'nodraft' => $nodraft]);
        }
    }
}
