<?php

namespace App\Http\Controllers\BACKOFFICE\TRANSAKSI\PENERIMAAN;

use App\Http\Controllers\Auth\loginController;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class BreadController extends Controller
{
    public function index()
    {
        return view('BACKOFFICE.TRANSAKSI.PENERIMAAN.bread');
    }

    public function upload(Request $request)
    {
        $tgltrf = $request->tgl;
        if (!(isset($tgltrf))) {
            $tgltrf = Carbon::now()->format('dmY');
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

    public function check(Request $request)
    {
        $nodraft = $request->nodraft;
        $temp = DB::connection(Session::get('connection'))->select("SELECT NVL (COUNT (1), 0)
                                                                    AS temp
                                                                    FROM TBTR_KRAT_IGR
                                                                    WHERE krt_nodraft = '$nodraft'");
        if ($temp[0]->temp == 0) {
            return response()->json(['kode' => '1', 'message' => 'Data Krat Tidak Ada !!', 'pointer' => '1']);
        } else {
            $temp = DB::connection(Session::get('connection'))->select("SELECT NVL (COUNT (*), 0)
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
            $data = DB::connection(Session::get('connection'))->select("SELECT krt_nodraft, krt_tglbpb
                                                                        AS draft, tglbpb
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
            $draft = $data[0]->draft;
            $tglbpb = $data[0]->tglbpb;
            //ambil saldo sebelumnya
            $temp = DB::connection(Session::get('connection'))->select("SELECT NVL (COUNT (1), 0)
                                                                        AS temp
                                                                        FROM (  SELECT NVL (krt_qty_saldo, 0) krt_qty_saldo
                                                                        FROM TBTR_KRAT_IGR
                                                                        WHERE     krt_tglnrb IS NOT NULL
                                                                        AND TRUNC (krt_tglbpb) < TRUNC (tglbpb)
                                                                        ORDER BY krt_tglbpb DESC) aa
                                                                        WHERE ROWNUM = 1");

            $saldo_lalu = 0;
            if ($temp[0]->temp != 0) {
                $data = DB::connection(Session::get('connection'))->select("SELECT krt_qty_saldo
                                                                            AS saldo_lalu
                                                                            FROM (  SELECT NVL (krt_qty_saldo, 0) krt_qty_saldo
                                                                            FROM TBTR_KRAT_IGR
                                                                            WHERE     krt_tglnrb IS NOT NULL
                                                                            AND TRUNC (krt_tglbpb) < TRUNC (tglbpb)
                                                                            ORDER BY krt_tglbpb DESC) aa
                                                                            WHERE ROWNUM = 1");
                $saldo_lalu = $data[0]->saldo_lalu;
            }
            //ambil qt lalu
            $temp = DB::connection(Session::get('connection'))->select("SELECT NVL (COUNT (1), 0)
                                                                        AS temp
                                                                        FROM (SELECT *
                                                                        FROM TBTR_KRAT_IGR
                                                                        WHERE krt_tglnrb IS NULL AND krt_nodraft <> '$nodraft') aa");

            $qty_lalu = 0;
            if ($temp[0]->temp != 0) {
                $data = DB::connection(Session::get('connection'))->select("SELECT krt_qty_bpb
                                                                            AS qty_lalu
                                                                            FROM (SELECT SUM (NVL (krt_qty_bpb, 0)) krt_qty_bpb
                                                                            FROM TBTR_KRAT_IGR
                                                                            WHERE     krt_tglnrb IS NULL
                                                                            AND krt_nodraft <> :txt_nodraft
                                                                            AND TRUNC (krt_tglbpb) < TRUNC ( '$nodraft')) aa");
                $qty_lalu = $data[0]->qty_lalu;
            }
            $data = DB::connection(Session::get('connection'))->select("SELECT  krt_tglbpb,
                                                                                krt_qty_draft,
                                                                                krt_nobpb,
                                                                                krt_qty_bpb,
                                                                                krt_prdcd,
                                                                                krt_qty_saldo,
                                                                                krt_recordid,
                                                                                NVL (krt_qty_nrb, 0)
                                                                        AS      txt_tgldraft,
                                                                                txt_qty_draft,
                                                                                txt_nobpb,
                                                                                txt_qty_bpb,
                                                                                txt_prdcd,
                                                                                txt_qty_saldo,
                                                                                txt_status,
                                                                                txt_qty_nrb
                                                                        FROM TBTR_KRAT_IGR
                                                                        WHERE krt_nodraft = '$nodraft'");
            $txt_tgldraft = $data[0]->txt_tgldraft;
            $txt_qty_draft = $data[0]->txt_qty_draft;
            $txt_nobpb = $data[0]->txt_nobpb;
            $txt_qty_bpb = $data[0]->txt_qty_bpb;
            $txt_prdcd = $data[0]->txt_prdcd;
            $txt_qty_saldo = $data[0]->txt_qty_saldo;
            $txt_status = $data[0]->txt_status;
            $txt_qty_nrb = $data[0]->txt_qty_nrb;
            $pointer = 0;

            if ($txt_status == 2) {
                $pointer = 2;
            } else {
                $txt_qty_draft = $txt_qty_draft + $qty_lalu + $saldo_lalu;
                $txt_qty_saldo  = $txt_qty_draft;
                if ($txt_tgldraft <  $tglbpb) {
                    return response()->json(['kode' => '0', 'message' => 'Data Draft terakhir dengan No ' . $draft, 'pointer' => $pointer, 'draft' => $draft]);
                } else {
                    return response()->json(['kode' => '2', 'message' => '', 'qty_saldo' => $txt_qty_saldo]);
                }
            }
        }
    }

    public function cetak(Request $request)
    {
        $nodraft = $request->nodraft;
        if (!(isset($nodraft))) {
            return response()->json(['kode' => '1', 'message' => 'Nomor Draft harus diisi !!', 'p_sukses' => 'N']);
        } else {
            // PROCEDURE CETAK_NRB(p_print char) IS
            // repid report_object;
            // p_param VARCHAR2(1000);
            // reg_name VARCHAR2(1000);
            // rep_name VARCHAR2(1000);
            // report_srv VARCHAR2(1000);
            // BEGIN
            // report_srv: =: PARAMETER.RPTNAME;
            // repid: = FIND_REPORT_OBJECT('NRB');
            // rep_name: = GET_REPORT_OBJECT_PROPERTY(repid, report_filename);
            // p_param: =
            //     ' p_kodeigr=' ||
            //     : PARAMETER.KODEIGR ||
            //     ' p_nodoc=' ||
            //     : txt_nodraft ||
            //     ' p_print=' ||
            //     p_print;
            // run_report(repid, report_srv, 'PDF', p_param);

            // END;
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

            //       cetak_nrb('N');

            //       GO_BLOCK('INPUT');
            //       CLEAR_BLOCK(NO_VALIDATE);
            //       GO_ITEM('TXT_NODRAFT');
            //    END IF;
        }
    }
}
