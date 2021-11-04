<?php

namespace App\Http\Controllers\BACKOFFICE\PROSES;

use Carbon\Carbon;
use Dompdf\Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use PDF;
use Yajra\DataTables\DataTables;
use File;

class MonthEndController extends Controller
{
    public function index()
    {
        return view('BACKOFFICE.PROSES.monthend');
    }

    public function proses(Request $request)
    {

        $txt_tahun = $request->tahun;
        $txt_bulan = $request->bulan;

        $data = DB::connection($_SESSION['connection'])->table('TBMASTER_PERUSAHAAN')
            ->select('prs_kodeigr', 'prs_bulanberjalan', 'prs_tahunberjalan', 'prs_fmflcs')
            ->first();
        $copyacost = $data->prs_fmflcs;
        $txt_bulanold = $data->prs_bulanberjalan;
        $txt_tahunold = $data->prs_tahunberjalan;

        if ($txt_tahunold . $txt_bulanold == $txt_tahun . $txt_bulan) {
            if (!isset($copyacost) || $copyacost == '') {
                $message = 'Data Average Cost Akhir Bulan belum di Copy';
                $status = 'info';
                return compact(['status', 'message']);
            }
        }

        $message = 'Lanjut';
        $status = 'success';
        return compact(['status', 'message']);


//        $p_awal = "to_date('" . $txt_bulan . "01" . $txt_tahun . "','MM/DD/YYYY')";
//        $p_akhir = "add_months(to_date('" . $txt_bulan . "01" . $txt_tahun . "','MM/DD/YYYY'), 1) - 1";
//
//        $p_sukses = '';
//        $p_loop = 6;
//        $p_progress = 0;
//
//////   ----->>>> Hitung Ulang Stock Untuk Bulan Proses <<<<-----
//        $sql = "BEGIN SP_HITUNG_STOCK2('" . $_SESSION['kdigr'] . "'," . $p_awal . "," . $p_akhir . ",' ','ZZZZZZZ',:p_sukses,:err_txt); END;";
//        $s = oci_parse($c, $sql);
//
//        oci_bind_by_name($s, ':p_sukses', $p_sukses, 200);
//        oci_bind_by_name($s, ':err_txt', $err_txt, 200);
//        oci_execute($s);
//
//        if ($p_sukses) {
//            $p_progress = $p_progress + 1;
////        loop_progress_bar('BL_INPUT.PROGRESSBAR', (p_progress / p_loop) * 419);
//        }
//
//        $sql = "BEGIN SP_HITUNG_STOCKCMO2('" . $_SESSION['kdigr'] . "'," . $p_awal . "," . $p_akhir . ",:p_sukses,:err_txt); END;";
//        $s = oci_parse($c, $sql);
//
//        oci_bind_by_name($s, ':p_awal', $p_awal);
//        oci_bind_by_name($s, ':p_akhir', $p_akhir);
//        oci_bind_by_name($s, ':p_sukses', $p_sukses, 200);
//        oci_bind_by_name($s, ':err_txt', $err_txt, 200);
//        oci_execute($s);
//
////    ----->>>> Hitung Sales Rekap <<<<-----
////    SYNCHRONIZE;
//        $sql = "BEGIN SP_HITUNG_SLREKAP2('" . $_SESSION['kdigr'] . "'," . $p_awal . "," . $p_akhir . ",'" . $_SESSION['usid'] . "',:p_sukses,:err_txt); END;";
//        $s = oci_parse($c, $sql);
//
//        oci_bind_by_name($s, ':p_sukses', $p_sukses, 200);
//        oci_bind_by_name($s, ':err_txt', $err_txt, 200);
//        oci_execute($s);
//
//        if ($p_sukses) {
//            $p_progress = $p_progress + 1;
////        loop_progress_bar('BL_INPUT.PROGRESSBAR', (p_progress / p_loop) * 419);
//        } else {
//            $status = 'error';
//            $message = $err_txt;
//            return compact(['status', 'message']);
//        }
////   ----->>>> Proses LPP <<<<-----
//        $sql = "BEGIN SP_PROSES_LPP2('" . $_SESSION['kdigr'] . "'," . $p_awal . "," . $p_akhir . ",true,:p_sukses,:err_txt); END;";
//        $s = oci_parse($c, $sql);
//
//        oci_bind_by_name($s, ':p_sukses', $p_sukses, 200);
//        oci_bind_by_name($s, ':err_txt', $err_txt, 200);
//        oci_execute($s);
//
//        if ($p_sukses) {
//            $p_progress = $p_progress + 1;
////        loop_progress_bar('BL_INPUT.PROGRESSBAR', (p_progress / p_loop) * 419);
//        }
//
////   ----->>>> Hapus Data tbTr_BackOffice <<<<-----
//        DB::connection($_SESSION['connection'])->select("delete from tbtr_backoffice where trbo_kodeigr='" . $_SESSION['kdigr'] . "' and nvl(trbo_recordid,' ')='2' and nvl(trbo_nonota,' ')<>' '");
//        $p_progress = $p_progress + 1;
//        loop_progress_bar('BL_INPUT.PROGRESSBAR', (p_progress / p_loop) * 419);
//
//
////        ----->>>> Copy Stock Untuk Bulan Berjalan <<<<-----
////    SYNCHRONIZE;
//        $sql = "BEGIN SP_COPY_STOCK2('" . $_SESSION['kdigr'] . "','" . $txt_tahun . $txt_bulan . "',:p_sukses,:err_txt); END;";
//        $s = oci_parse($c, $sql);
//
//        oci_bind_by_name($s, ':p_sukses', $p_sukses, 200);
//        oci_bind_by_name($s, ':err_txt', $err_txt, 200);
//        oci_execute($s);
//
//        $sql = "BEGIN sp_copy_stock_CMO2('" . $_SESSION['kdigr'] . "','" . $txt_tahun . $txt_bulan . "',:p_sukses,:err_txt); END;";
//        $s = oci_parse($c, $sql);
//
//        oci_bind_by_name($s, ':p_sukses', $p_sukses, 200);
//        oci_bind_by_name($s, ':err_txt', $err_txt, 200);
//        oci_execute($s);
//
//
//        if ($p_sukses) {
//            $p_progress = $p_progress + 1;
////      loop_progress_bar('BL_INPUT.PROGRESSBAR', (p_progress / p_loop) * 419);
//        } else {
//            $status = 'error';
//            $message = $err_txt;
//            return compact(['status', 'message']);
//        }
//
////   ----->>>> Hitung Ulang Stock Untuk Bulan Berjalan <<<<-----
////    SYNCHRONIZE;
//
//        $p_awal = $p_akhir . ' + 1';
//
//        $re = DB::connection($_SESSION['connection'])->select("select to_char(" . $p_awal . ",'YYYYMM') value from dual");
//
//        if ($re[0]->value == Carbon::now()->format('Ym')) {
//            $p_akhir = 'trunc(sysdate)';
//        } else {
//            $p_akhir = $p_awal;
//        }
//
//        $sql = "BEGIN SP_HITUNG_STOCK2('" . $_SESSION['kdigr'] . "'," . $p_awal . "," . $p_akhir . ",' ','ZZZZZZZ',:p_sukses,:err_txt); END;";
//        $s = oci_parse($c, $sql);
//
//        oci_bind_by_name($s, ':p_sukses', $p_sukses, 200);
//        oci_bind_by_name($s, ':err_txt', $err_txt, 200);
//        oci_execute($s);
//
//        if ($p_sukses) {
//            $p_progress = $p_progress + 1;
////      loop_progress_bar('BL_INPUT.PROGRESSBAR', (p_progress / p_loop) * 419);
//        } else {
//            $status = 'error';
//            $message = $err_txt;
//            return compact(['status', 'message']);
//        }
//
//        $sql = "BEGIN SP_HITUNG_STOCKCMO2('" . $_SESSION['kdigr'] . "'," . $p_awal . "," . $p_akhir . ",:p_sukses,:err_txt); END;";
//        $s = oci_parse($c, $sql);
//
//        oci_bind_by_name($s, ':p_sukses', $p_sukses, 200);
//        oci_bind_by_name($s, ':err_txt', $err_txt, 200);
//        oci_execute($s);
//        if ($p_sukses) {
//            $p_progress = $p_progress + 1;
////      loop_progress_bar('BL_INPUT.PROGRESSBAR', (p_progress / p_loop) * 419);
//        } else {
//            $status = 'error';
//            $message = $err_txt;
//            return compact(['status', 'message']);
//        }
//
//        $sql = "BEGIN sp_lpp_point('" . $txt_tahun . $txt_bulan . "','" . $_SESSION['usid'] . "'||'Y',:err_txt); END;";
//        $s = oci_parse($c, $sql);
//
//        oci_bind_by_name($s, ':err_txt', $err_txt, 200);
//        oci_execute($s);
//
//        if (isset($err_txt)) {
//            $status = 'error';
//            $message = $err_txt;
//            return compact(['status', 'message']);
//        }
//
////   ----->>>> Hitung Ulang Stock Untuk Bulan Berjalan <<<<-----
//        if ($txt_tahunold . $txt_bulanold == $txt_tahun . $txt_bulan) {
//            $sql = "BEGIN UPDATE tbMaster_Perusahaan SET PRS_BULANBERJALAN = to_char(" . $p_awal . ", 'MM'), PRS_TAHUNBERJALAN = to_char(" . $p_awal . ", 'YYYY'), PRS_FMFLCS = '' WHERE PRS_KODECABANG = '" . $_SESSION['kdigr'] . "'; END;";
//            $s = oci_parse($c, $sql);
//            oci_execute($s);
//        }
//
//        if ($p_sukses) {
//            $status = 'success';
//            $message = 'Proses Month End berhasil!';
//            return compact(['status', 'message']);
//        } else {
//            $status = 'error';
//            $message = 'Proses Month End GAGAL! --> ' . $err_txt;
//            return compact(['status', 'message']);
//        }


    }

    public function prosesHitungStock(Request $request)
    {
        $txt_tahun = $request->tahun;
        $txt_bulan = $request->bulan;

        $p_sukses = '';
        $err_txt = '';

        $p_awal = "to_date('" . $txt_bulan . "01" . $txt_tahun . "','MM/DD/YYYY')";
        $p_akhir = "add_months(to_date('" . $txt_bulan . "01" . $txt_tahun . "','MM/DD/YYYY'), 1) - 1";

//        ----->>>> Hitung Ulang Stock Untuk Bulan Proses <<<<-----
        $c = loginController::getConnectionProcedure();
        $sql = "BEGIN SP_HITUNG_STOCK2('" . $_SESSION['kdigr'] . "'," . $p_awal . "," . $p_akhir . ",' ','ZZZZZZZ',:p_sukses,:err_txt); END;";
        $s = oci_parse($c, $sql);

        oci_bind_by_name($s, ':p_sukses', $p_sukses, 200);
        oci_bind_by_name($s, ':err_txt', $err_txt, 200);
        oci_execute($s);

        if ($p_sukses == 'TRUE') {
            $status = 'success';
            $message = $err_txt;
            return compact(['status', 'message']);
        } else {
            $status = 'error';
            $message = $err_txt;
            return compact(['status', 'message']);
        }

    }

    public function prosesHitungStockCMO(Request $request)
    {
        $txt_tahun = $request->tahun;
        $txt_bulan = $request->bulan;

        $p_sukses = '';
        $err_txt = '';

        $p_awal = "to_date('" . $txt_bulan . "01" . $txt_tahun . "','MM/DD/YYYY')";
        $p_akhir = "add_months(to_date('" . $txt_bulan . "01" . $txt_tahun . "','MM/DD/YYYY'), 1) - 1";

        $c = loginController::getConnectionProcedure();
        $sql = "BEGIN SP_HITUNG_STOCKCMO2('" . $_SESSION['kdigr'] . "'," . $p_awal . "," . $p_akhir . ",:p_sukses,:err_txt); END;";
        $s = oci_parse($c, $sql);

        oci_bind_by_name($s, ':p_sukses', $p_sukses, 200);
        oci_bind_by_name($s, ':err_txt', $err_txt, 200);
        oci_execute($s);

        if ($p_sukses == 'TRUE') {
            $status = 'success';
            $message = $err_txt;
            return compact(['status', 'message']);
        } else {
            $status = 'error';
            $message = $err_txt;
            return compact(['status', 'message']);
        }
    }

    public function prosesSalesRekap(Request $request)
    {
        $txt_tahun = $request->tahun;
        $txt_bulan = $request->bulan;

        $p_sukses = '';
        $err_txt = '';

        $p_awal = "to_date('" . $txt_bulan . "01" . $txt_tahun . "','MM/DD/YYYY')";
        $p_akhir = "add_months(to_date('" . $txt_bulan . "01" . $txt_tahun . "','MM/DD/YYYY'), 1) - 1";

        $c = loginController::getConnectionProcedure();
        $sql = "BEGIN SP_HITUNG_SLREKAP2('" . $_SESSION['kdigr'] . "'," . $p_awal . "," . $p_akhir . ",'" . $_SESSION['usid'] . "',:p_sukses,:err_txt); END;";
        $s = oci_parse($c, $sql);

        oci_bind_by_name($s, ':p_sukses', $p_sukses, 200);
        oci_bind_by_name($s, ':err_txt', $err_txt, 200);
        oci_execute($s);

        if ($p_sukses == 'TRUE') {
            $status = 'success';
            $message = $err_txt;
            return compact(['status', 'message']);
        } else {
            $status = 'error';
            $message = $err_txt;
            return compact(['status', 'message']);
        }
    }

    public function prosesLPP(Request $request)
    {
        $txt_tahun = $request->tahun;
        $txt_bulan = $request->bulan;

        $p_sukses = '';
        $err_txt = '';

        $p_awal = "to_date('" . $txt_bulan . "01" . $txt_tahun . "','MM/DD/YYYY')";
        $p_akhir = "add_months(to_date('" . $txt_bulan . "01" . $txt_tahun . "','MM/DD/YYYY'), 1) - 1";

        $c = loginController::getConnectionProcedure();
        $sql = "BEGIN SP_PROSES_LPP2('" . $_SESSION['kdigr'] . "'," . $p_awal . "," . $p_akhir . ",true,:p_sukses,:err_txt); END;";
        $s = oci_parse($c, $sql);

        oci_bind_by_name($s, ':p_sukses', $p_sukses, 200);
        oci_bind_by_name($s, ':err_txt', $err_txt, 200);
        oci_execute($s);

        if ($p_sukses == 'TRUE') {
            $status = 'success';
            $message = $err_txt;
            return compact(['status', 'message']);
        } else {
            $status = 'error';
            $message = $err_txt;
            return compact(['status', 'message']);
        }
    }

    public function deleteData(Request $request)
    {
        try {
            DB::beginTransaction();
            DB::connection($_SESSION['connection'])->delete("delete from tbtr_backoffice where trbo_kodeigr='" . $_SESSION['kdigr'] . "' and nvl(trbo_recordid,' ')='2' and nvl(trbo_nonota,' ')<>' '");

            $status = 'success';
            $message = '';
        } catch (Exception $e) {
            DB::rollBack();
            $status = 'error';
            $message = $e->getMessage();
        }
        DB::commit();
        return compact(['status', 'message']);
    }

    public function prosesCopyStock(Request $request)
    {
        $txt_tahun = $request->tahun;
        $txt_bulan = $request->bulan;

        $p_sukses = '';
        $err_txt = '';

        $p_awal = "to_date('" . $txt_bulan . "01" . $txt_tahun . "','MM/DD/YYYY')";
        $p_akhir = "add_months(to_date('" . $txt_bulan . "01" . $txt_tahun . "','MM/DD/YYYY'), 1) - 1";

        $c = loginController::getConnectionProcedure();
        $sql = "BEGIN SP_COPY_STOCK2('" . $_SESSION['kdigr'] . "','" . $txt_tahun . $txt_bulan . "',:p_sukses,:err_txt); END;";
        $s = oci_parse($c, $sql);


        oci_bind_by_name($s, ':p_sukses', $p_sukses, 200);
        oci_bind_by_name($s, ':err_txt', $err_txt, 200);
        oci_execute($s);

        if ($p_sukses == 'FALSE') {
            $status = 'error';
            $message = $err_txt;
            return compact(['status', 'message']);
        }

        $sql = "BEGIN sp_copy_stock_CMO2('" . $_SESSION['kdigr'] . "','" . $txt_tahun . $txt_bulan . "',:p_sukses,:err_txt); END;";
        $s = oci_parse($c, $sql);

        oci_bind_by_name($s, ':p_sukses', $p_sukses, 200);
        oci_bind_by_name($s, ':err_txt', $err_txt, 200);
        oci_execute($s);

        if ($p_sukses == 'TRUE') {
            $status = 'success';
            $message = $err_txt;
            return compact(['status', 'message']);
        } else {
            $status = 'error';
            $message = $err_txt;
            return compact(['status', 'message']);
        }
    }
    public function prosesHitungStock2(Request $request)
    {
        $txt_tahun = $request->tahun;
        $txt_bulan = $request->bulan;

        $p_sukses = '';
        $err_txt = '';

        $p_awal = "to_date('" . $txt_bulan . "01" . $txt_tahun . "','MM/DD/YYYY')";
        $p_akhir = "add_months(to_date('" . $txt_bulan . "01" . $txt_tahun . "','MM/DD/YYYY'), 1) - 1";

        $p_awal = $p_akhir . ' + 1';

        $re = DB::connection($_SESSION['connection'])->select("select to_char(" . $p_awal . ",'YYYYMM') value from dual");

        if ($re[0]->value == Carbon::now()->format('Ym')) {
            $p_akhir = 'trunc(sysdate)';
        } else {
            $p_akhir = $p_awal;
        }
//        ----->>>> Hitung Ulang Stock Untuk Bulan Proses <<<<-----
        $c = loginController::getConnectionProcedure();
        $sql = "BEGIN SP_HITUNG_STOCK2('" . $_SESSION['kdigr'] . "'," . $p_awal . "," . $p_akhir . ",' ','ZZZZZZZ',:p_sukses,:err_txt); END;";
        $s = oci_parse($c, $sql);

        oci_bind_by_name($s, ':p_sukses', $p_sukses, 200);
        oci_bind_by_name($s, ':err_txt', $err_txt, 200);
        oci_execute($s);

        if ($p_sukses == 'TRUE') {
            $status = 'success';
            $message = $err_txt;
        } else {
            $status = 'error';
            $message = $err_txt;
            return compact(['status', 'message']);
        }

        $sql = "BEGIN SP_HITUNG_STOCKCMO2('" . $_SESSION['kdigr'] . "'," . $p_awal . "," . $p_akhir . ",:p_sukses,:err_txt); END;";
        $s = oci_parse($c, $sql);

        oci_bind_by_name($s, ':p_sukses', $p_sukses, 200);
        oci_bind_by_name($s, ':err_txt', $err_txt, 200);
        oci_execute($s);

        if ($p_sukses == 'TRUE') {
            $status = 'success';
            $message = $err_txt;
        } else {
            $status = 'error';
            $message = $err_txt;
            return compact(['status', 'message']);
        }

        $sql = "BEGIN sp_lpp_point('" . $txt_tahun . $txt_bulan . "','" . $_SESSION['usid'] . "'||'Y',:err_txt); END;";
        $s = oci_parse($c, $sql);

        oci_bind_by_name($s, ':err_txt', $err_txt, 200);
        oci_execute($s);

        if (isset($err_txt)) {
            $status = 'error';
            $message = $err_txt;
            return compact(['status', 'message']);
        }

//   ----->>>> Hitung Ulang Stock Untuk Bulan Berjalan <<<<-----
        $data = DB::connection($_SESSION['connection'])->table('TBMASTER_PERUSAHAAN')
            ->select('prs_kodeigr', 'prs_bulanberjalan', 'prs_tahunberjalan', 'prs_fmflcs')
            ->first();
        $copyacost = $data->prs_fmflcs;
        $txt_bulanold = $data->prs_bulanberjalan;
        $txt_tahunold = $data->prs_tahunberjalan;
        if ($txt_tahunold . $txt_bulanold == $txt_tahun . $txt_bulan) {
            $sql = "BEGIN UPDATE tbMaster_Perusahaan SET PRS_BULANBERJALAN = to_char(" . $p_awal . ", 'MM'), PRS_TAHUNBERJALAN = to_char(" . $p_awal . ", 'YYYY'), PRS_FMFLCS = '' WHERE PRS_KODECABANG = '" . $_SESSION['kdigr'] . "'; END;";
            $s = oci_parse($c, $sql);
            oci_execute($s);
        }

        if ($p_sukses) {
            $status = 'success';
            $message = 'Proses Month End berhasil!';
            return compact(['status', 'message']);
        } else {
            $status = 'error';
            $message = 'Proses Month End GAGAL! --> ' . $err_txt;
            return compact(['status', 'message']);

        }

    }




}
