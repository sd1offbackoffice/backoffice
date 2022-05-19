<?php

namespace App\Http\Controllers\BACKOFFICE\TRANSAKSI\PENGELUARAN;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\DataTables;

class CetakUlangFakturPajakController extends Controller
{
    public function index() {
        return view('BACKOFFICE.TRANSAKSI.PENGELUARAN.cetakulangfakturpajak');
    }

    public function lovSearchNPB1(Request $request) {
        $kodeigr = Session::get('kdigr');
        $datas = DB::connection(Session::get('connection'))
            ->select("SELECT DISTINCT msth_nodoc, TRUNC(msth_tgldoc) msth_tgldoc
                    FROM tbtr_mstran_h, tbtr_mstran_d
                    WHERE msth_kodeigr= '$kodeigr'
                                AND NVL(msth_recordid,' ')<>'1'
                                AND msth_typetrn='K'
                                AND mstd_nodoc = msth_nodoc
                                AND mstd_noref3 IS NOT NULL
                    ORDER BY msth_nodoc DESC");



        if (!$datas) {
            return response()->json([
                'status' => 'FAILED',
                'message' => 'Data NPB Tidak Ditemukan'
            ]);
        }

        return Datatables::of($datas)->make(true);
    }

    public function lovSearchNPB2(Request $request) {
        $npb1 = $request->value;
        $kodeigr = Session::get('kdigr');
        $datas = DB::connection(Session::get('connection'))
            ->select("SELECT DISTINCT msth_nodoc, TRUNC(msth_tgldoc) msth_tgldoc
            FROM tbtr_mstran_h, tbtr_mstran_d
            WHERE msth_kodeigr= '$kodeigr'
                        AND NVL(msth_recordid,' ')<>'1'
                        AND msth_typetrn='K'
                                    AND msth_nodoc >= '$npb1'
                        AND mstd_nodoc = msth_nodoc
                        AND mstd_noref3 IS NOT NULL
            ORDER BY msth_nodoc DESC");

        if (!$datas) {
            return response()->json([
                'status' => 'FAILED',
                'message' => 'Data NPB Tidak Ditemukan'
            ]);
        }
        // return dd($npb1);
        return Datatables::of($datas)->make(true);
    }

    public function checkData(Request $request) {
        $kodeigr = Session::get('kdigr');
        $npb1 = $request->npb1;
        $npb2 = $request->npb2;

        $datas = DB::connection(Session::get('connection'))
            ->select("SELECT DISTINCT msth_nodoc
                FROM tbtr_mstran_h, tbtr_mstran_d
                WHERE msth_kodeigr = '$kodeigr'
                AND NVL (msth_recordid,' ')<> '1'
                AND msth_typetrn = 'K'
                AND msth_nodoc BETWEEN '$npb1' AND '$npb2'
                AND mstd_nodoc = msth_nodoc
                AND mstd_noref3 IS NOT NULL");

            // return dd($datas);

        if (!$datas) {
            return response()->json([
                'status' => 'FAILED',
                'message' => 'Data NPB Tidak Ditemukan'
            ]);
        }

        return response()->json([
            'status' => 'SUCCESS',
            'message' => 'Data NPB Ditemukan',
            'datas' => $datas
            // 'data' => [
            //     $datas
            // ]
        ]);
    }

    public function printDocument(Request $request) {
        $perusahaan = DB::connection(Session::get('connection'))->table("tbmaster_perusahaan")->first();
        $kodeigr = Session::get('kdigr');
        $concatData = $request->concatData;
        $npb1 = $request->npb1;
        $npb2 = $request->npb2;
        $ttd = $request->signedName;
        $role1 = $request->role1;
        $role2 = $request->role2;
        $p_print = 1;

        $data = DB::connection(Session::get('connection'))
            ->select("SELECT   MSTH_NODOC, trunc(msth_tgldoc) msth_tgldoc, MSTH_KODESUPPLIER, MSTD_DOCNO2 /*msth_nofaktur*/, MSTD_DATE3 /*msth_tglinv*/,
                        MSTD_DATE2 /*msth_tglfaktur*/, PRD_PRDCD, MSTD_QTY, MSTD_UNIT, MSTD_FRAC, MSTD_GROSS,
                        MSTD_DISCRPH, (MSTD_PPNRPH) MSTD_PPNRPH, MSTD_PKP, MSTH_ISTYPE, MSTH_INVNO, MSTH_FLAGDOC,
                        SUP_NAMASUPPLIER, SUP_SINGKATANSUPPLIER, SUP_NAMANPWP,
                        SUP_ALAMATNPWP1 || ' ' || SUP_ALAMATNPWP2 || ' ' || SUP_ALAMATNPWP3 ADDR_SUP, SUP_NPWP,
                        SUP_TGLSK, SUP_NOSK, PRS_KODEMTO, PRS_BULANBERJALAN, PRS_TAHUNBERJALAN, PRS_NONRB,
                        PRS_NAMAPERUSAHAAN, PRS_NPWP, PRS_NAMAWILAYAH,
                        CONST_ADDR1 || ' ' || CONST_ADDR2 CONST_ADDR, PRD_DESKRIPSIPANJANG,
                        CASE
                            WHEN ".$p_print." = 0
                                THEN ''
                            ELSE '*'
                        END REPRINT, MSTd_ISTYPE, MSTd_INVNO, MSTD_NOREF3
                    FROM TBTR_MSTRAN_H,
                        TBTR_MSTRAN_D,
                        TBMASTER_SUPPLIER,
                        TBMASTER_PERUSAHAAN,
                        TBMASTER_CONST,
                        TBMASTER_PRODMAST
                WHERE MSTH_KODEIGR = ".$kodeigr."
                    -- AND MSTH_NODOC IN ($concatData) AND MSTH_TYPETRN='K'
                    AND MSTH_NODOC IN (".$concatData.") AND MSTH_TYPETRN='K'
                    AND MSTH_TYPETRN = 'K'
                    AND MSTD_NODOC = MSTH_NODOC
                    AND MSTD_KODEIGR = MSTH_KODEIGR
                    AND (NVL (MSTD_DOCNO2, '9') <> '9' OR MSTD_DOCNO2 <> '  '
                        )                             --and (NVL(msth_nofaktur,'9') <>'9' or msth_nofaktur <> '  ')
                    AND NVL (MSTD_PKP, 'N') = 'Y'
                    AND SUP_KODESUPPLIER = MSTH_KODESUPPLIER
                    AND SUP_KODEIGR = MSTH_KODEIGR
                    AND PRS_KODEIGR = MSTH_KODEIGR
                    AND CONST_KODEIGR(+) = MSTH_KODEIGR
                    AND SUBSTR (CONST_BRANCH, 1, 1) = 'O'
                    AND PRD_PRDCD = MSTD_PRDCD
                    AND NVL (PRD_FLAGBKP1, 'N') = 'Y'
                    AND PRD_KODEIGR = MSTD_KODEIGR
            ORDER BY MSTD_SEQNO");

        // dd($data);

    return view('BACKOFFICE.TRANSAKSI.PENGELUARAN.cetakulangfakturpajak_pdf', compact('npb1', 'npb2', 'perusahaan', 'data', 'ttd', 'role1', 'role2'));
//        return view('BACKOFFICE.CETAKDOKUMEN.ctk-rtrpjk-pdf', compact('npb1', 'npb2', 'perusahaan', 'data', 'ttd', 'role1', 'role2'));

    }
}





