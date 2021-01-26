<?php

namespace App\Http\Controllers\BACKOFFICE\PROSES;

use Carbon\Carbon;
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
        $txt_tahunold = '';
        $txt_bulanold = '';
        $txt_tahun = '';
        $txt_bulan = '';
        $copyacost = '';

        if ($txt_tahunold . $txt_bulanold == $txt_tahun . $txt_bulan) {
            if (!isset($copyacost) && $copyacost == '') {
                $message = 'Data Average Cost Akhir Bulan belum di Copy';
            }
        }

//   SYNCHRONIZE;
//   SET_ITEM_PROPERTY ('BL_INPUT.PROGRESSBAR', visible, property_true);
//   --** Getting Row Count
        $p_awal = to_date($txt_bulan . '/01/' . $txt_tahun, 'MM/DD/YYYY');
        $p_akhir = add_months($p_awal, 1) - 1;

        $p_sukses = TRUE;
        $p_loop = 6;
        $p_progress = 0;
        $p_session = USERENV('sessionid');
//   SET_ITEM_PROPERTY ('BL_INPUT.PROGRESSBAR', width, 0);

//   ----->>>> Hitung Ulang Stock Untuk Bulan Proses <<<<-----
        $c = oci_connect($_SESSION['conUser'], $_SESSION['conPassword'], $_SESSION['conString']);
        $sql = "BEGIN SP_HITUNG_STOCK('" . $_SESSION['kdigr'] . "',:p_awal,:p_akhir,' ','ZZZZZZZ',:p_sukses,:err_txt); END;";
        $s = oci_parse($c, $sql);

        oci_bind_by_name($s, ':p_awal', $p_awal);
        oci_bind_by_name($s, ':p_akhir', $p_akhir);
        oci_bind_by_name($s, ':p_sukses', $p_sukses, 200);
        oci_bind_by_name($s, ':err_txt', $err_txt, 200);
        oci_execute($s);

        if ($p_sukses) {
            $p_progress = $p_progress + 1;
//        loop_progress_bar('BL_INPUT.PROGRESSBAR', (p_progress / p_loop) * 419);
        }

        $c = oci_connect($_SESSION['conUser'], $_SESSION['conPassword'], $_SESSION['conString']);
        $sql = "BEGIN SP_HITUNG_STOCKCMO('" . $_SESSION['kdigr'] . "',:p_awal,:p_akhir,:p_sukses,:err_txt); END;";
        $s = oci_parse($c, $sql);

        oci_bind_by_name($s, ':p_awal', $p_awal);
        oci_bind_by_name($s, ':p_akhir', $p_akhir);
        oci_bind_by_name($s, ':p_sukses', $p_sukses, 200);
        oci_bind_by_name($s, ':err_txt', $err_txt, 200);
        oci_execute($s);

//    ----->>>> Hitung Sales Rekap <<<<-----
//    SYNCHRONIZE;
//--dc_alert.ok('2 ' . p_awal . ' - ' . p_akhir);
        $c = oci_connect($_SESSION['conUser'], $_SESSION['conPassword'], $_SESSION['conString']);
        $sql = "BEGIN SP_HITUNG_SLREKAP('" . $_SESSION['kdigr'] . "',:p_awal,:p_akhir,'" . $_SESSION['usid'] . "',:p_sukses,:err_txt); END;";
        $s = oci_parse($c, $sql);

        oci_bind_by_name($s, ':p_awal', $p_awal);
        oci_bind_by_name($s, ':p_akhir', $p_akhir);
        oci_bind_by_name($s, ':p_sukses', $p_sukses, 200);
        oci_bind_by_name($s, ':err_txt', $err_txt, 200);
        oci_execute($s);
        if ($p_sukses) {
            $p_progress = $p_progress + 1;
//        loop_progress_bar('BL_INPUT.PROGRESSBAR', (p_progress / p_loop) * 419);
        } else {
            $status = 'error';
            $message = $err_txt;
            return compact(['status', 'message']);
        }
//--dc_alert.ok('3 ' . p_awal . ' - ' . p_akhir);
//   ----->>>> Proses LPP <<<<-----
        $c = oci_connect($_SESSION['conUser'], $_SESSION['conPassword'], $_SESSION['conString']);
        $sql = "BEGIN SP_PROSES_LPP('" . $_SESSION['kdigr'] . "',:p_awal,:p_akhir,true,:p_sukses,:err_txt); END;";
        $s = oci_parse($c, $sql);

        oci_bind_by_name($s, ':p_awal', $p_awal);
        oci_bind_by_name($s, ':p_akhir', $p_akhir);
        oci_bind_by_name($s, ':p_sukses', $p_sukses, 200);
        oci_bind_by_name($s, ':err_txt', $err_txt, 200);
        oci_execute($s);

        if ($p_sukses) {
            $p_progress = $p_progress + 1;
//        loop_progress_bar('BL_INPUT.PROGRESSBAR', (p_progress / p_loop) * 419);
        }

//   ----->>>> Hapus Data tbTr_BackOffice <<<<-----
        DB::select("DELETE FROM tbTr_BackOffice WHERE trbo_kodeigr=" . $_SESSION['kdigr'] . " AND nvl(trbo_recordid,' ')='2' AND nvl(trbo_nonota,' ')<>' '");
        $p_progress = $p_progress + 1;
//        loop_progress_bar('BL_INPUT.PROGRESSBAR', (p_progress / p_loop) * 419);


//        ----->>>> Copy Stock Untuk Bulan Berjalan <<<<-----
//    SYNCHRONIZE;
//--dc_alert.ok('4 ' . p_awal . ' - ' . p_akhir);
        $c = oci_connect($_SESSION['conUser'], $_SESSION['conPassword'], $_SESSION['conString']);
        $sql = "BEGIN SP_COPY_STOCK('" . $_SESSION['kdigr'] . "','" . $txt_tahun . $txt_bulan . "',:p_sukses,:err_txt); END;";
        $s = oci_parse($c, $sql);

        oci_bind_by_name($s, ':p_sukses', $p_sukses, 200);
        oci_bind_by_name($s, ':err_txt', $err_txt, 200);
        oci_execute($s);

        $c = oci_connect($_SESSION['conUser'], $_SESSION['conPassword'], $_SESSION['conString']);
        $sql = "BEGIN sp_copy_stock_CMO('" . $_SESSION['kdigr'] . "','" . $txt_tahun . $txt_bulan . "',:p_sukses,:err_txt); END;";
        $s = oci_parse($c, $sql);

        oci_bind_by_name($s, ':p_sukses', $p_sukses, 200);
        oci_bind_by_name($s, ':err_txt', $err_txt, 200);
        oci_execute($s);


        if ($p_sukses) {
            $p_progress = $p_progress + 1;
//      loop_progress_bar('BL_INPUT.PROGRESSBAR', (p_progress / p_loop) * 419);
        }

//   ----->>>> Hitung Ulang Stock Untuk Bulan Berjalan <<<<-----
//    SYNCHRONIZE;

        $p_awal = $p_akhir + 1;
        if (to_char($p_awal, 'YYYYMM') == to_char(Carbon::now(), 'YYYYMM')) {
            $p_akhir = Carbon::now();
        } else {
            $p_akhir = $p_awal;
        }

        $c = oci_connect($_SESSION['conUser'], $_SESSION['conPassword'], $_SESSION['conString']);
        $sql = "BEGIN SP_HITUNG_STOCK('" . $_SESSION['kdigr'] . "',:p_awal,:p_akhir,' ','ZZZZZZZ',:p_sukses,:err_txt); END;";
        $s = oci_parse($c, $sql);

        oci_bind_by_name($s, ':p_awal', $p_awal);
        oci_bind_by_name($s, ':p_akhir', $p_akhir);
        oci_bind_by_name($s, ':p_sukses', $p_sukses, 200);
        oci_bind_by_name($s, ':err_txt', $err_txt, 200);
        oci_execute($s);
    
        if ($p_sukses) {
            $p_progress = $p_progress + 1;
//      loop_progress_bar('BL_INPUT.PROGRESSBAR', (p_progress / p_loop) * 419);
        } else {
            $status = 'error';
            $message = $err_txt;
            return compact(['status', 'message']);
        }

        $c = oci_connect($_SESSION['conUser'], $_SESSION['conPassword'], $_SESSION['conString']);
        $sql = "BEGIN SP_HITUNG_STOCKCMO('" . $_SESSION['kdigr'] . "',:p_awal,:p_akhir,:p_sukses,:err_txt); END;";
        $s = oci_parse($c, $sql);

        oci_bind_by_name($s, ':p_awal', $p_awal);
        oci_bind_by_name($s, ':p_akhir', $p_akhir);
        oci_bind_by_name($s, ':p_sukses', $p_sukses, 200);
        oci_bind_by_name($s, ':err_txt', $err_txt, 200);
        oci_execute($s);
        if ($p_sukses) {
            $p_progress = $p_progress + 1;
//      loop_progress_bar('BL_INPUT.PROGRESSBAR', (p_progress / p_loop) * 419);
        } else {
            $status = 'error';
            $message = $err_txt;
            return compact(['status', 'message']);
        }

        $c = oci_connect($_SESSION['conUser'], $_SESSION['conPassword'], $_SESSION['conString']);
        $sql = "BEGIN sp_lpp_point('" . $txt_tahun . $txt_bulan . "','" . $_SESSION['usid'] . "','Y',:err_txt); END;";
        $s = oci_parse($c, $sql);

        oci_bind_by_name($s, ':err_txt', $err_txt, 200);
        oci_execute($s);

        if (isset($err_txt)) {
            $status = 'error';
            $message = $err_txt;
            return compact(['status', 'message']);
        }

//   ----->>>> Hitung Ulang Stock Untuk Bulan Berjalan <<<<-----
        if ($txt_tahunold . $txt_bulanold == $txt_tahun . $txt_bulan) {
            DB::Select("UPDATE tbMaster_Perusahaan SET PRS_BULANBERJALAN = to_char(p_awal, 'MM'), PRS_TAHUNBERJALAN = to_char(p_awal, 'YYYY'), PRS_FMFLCS = '' WHERE PRS_KODECABANG = " . $_SESSION['kdigr']);

        }

//        if (al_button == alert_button1){
//      SET_ITEM_PROPERTY('BL_INPUT.PROGRESSBAR', visible, property_false);
//      SET_ITEM_PROPERTY('BL_INPUT.PROGRESSBAR', width, 0);
//        }

        if ($p_sukses) {
            $status = 'success';
            $message = 'Proses Month End berhasil!';
            return compact(['status', 'message']);
        } else {
            $status = 'error';
            $message = 'Proses Month End GAGAL! --> ' . $message;
            return compact(['status', 'message']);

        }
    }

}