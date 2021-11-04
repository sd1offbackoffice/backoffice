<?php
/**
 * Created by PhpStorm.
 * User: ryan
 * Date: 04/10/2021
 * Time: 15:02 PM
 */

namespace App\Http\Controllers\TABEL;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use PDF;
use DateTime;
use Yajra\DataTables\DataTables;

class PendaftaranVoucherBelanjaController extends Controller
{

    public function index()
    {
        return view('tabel.PENDAFTARANVOUCHERBELANJA.pendaftaranvoucherbelanja');
    }

    public function modalSupplier(Request $request)
    {
        $search = $request->value;

        $datas = DB::connection($_SESSION['connection'])->table("TBTABEL_VOUCHERSUPPLIER")
            ->select("vcs_namasupplier")
            ->where('vcs_kodeigr', '=', $_SESSION['kdigr'])
            ->whereRaw("vcs_namasupplier like '%" . $search . "%'")
            ->orderBy("vcs_namasupplier")
            ->get();
        return Datatables::of($datas)->make(true);
    }

    public function getDataTable(Request $request)
    {
        $search = $request->value;

        $datas = DB::connection($_SESSION['connection'])->table("TBTABEL_VOUCHERSUPPLIER")
            ->where('vcs_kodeigr', '=', $_SESSION['kdigr'])
            ->whereRaw("vcs_namasupplier like '%" . $search . "%'")
            ->orderBy("vcs_namasupplier")
            ->get();
        return Datatables::of($datas)->make(true);
    }

    public function getDeskripsi(Request $request)
    {
        $supp = $request->supp;
        $data = DB::connection($_SESSION['connection'])->table("TBTABEL_VOUCHERSUPPLIER")
            ->selectRaw("vcs_keterangan")
            ->where('vcs_kodeigr', '=', $_SESSION['kdigr'])
            ->where('vcs_namasupplier', '=', $supp)
            ->pluck('vcs_keterangan')->first();
        return $data;
    }

    public function getDataSupplier(Request $request)
    {
        $supp = $request->supp;

        $data = DB::connection($_SESSION['connection'])->table("TBTABEL_VOUCHERSUPPLIER")
            ->where('vcs_kodeigr', '=', $_SESSION['kdigr'])
            ->where('vcs_namasupplier', '=', $supp)
            ->first();

        return compact(['data']);

    }

    public function simpan(Request $request)
    {
        $supp = $request->supp;

        $temp = DB::connection($_SESSION['connection'])->table("TBTABEL_VOUCHERSUPPLIER")
            ->selectRaw("NVL(COUNT(1),0) count")
            ->where('vcs_kodeigr', '=', $_SESSION['kdigr'])
            ->where('vcs_namasupplier', '=', $supp)
            ->pluck('count')->first();

        if ($temp == 0) {
            DB::connection($_SESSION['connection'])->table("TBTABEL_VOUCHERSUPPLIER")
                ->insert([
                    'vcs_kodeigr' => $_SESSION['kdigr'],
                    'vcs_namasupplier' => $supp,
                    'vcs_nilaivoucher' => $request->vcs_nilaivoucher,
                    'vcs_tglmulai' => DB::raw("to_date('" . $request->vcs_tglmulai . "','yyyy-mm-dd')"),
                    'vcs_tglakhir' => DB::raw("to_date('" . $request->vcs_tglakhir . "','yyyy-mm-dd')"),
                    'vcs_maxvoucher' => $request->vcs_maxvoucher,
                    'vcs_joinpromo' => $request->vcs_joinpromo,
                    'vcs_keterangan' => $request->vcs_keterangan,
                    'vcs_minstruk' => $request->vcs_minstruk,
                    'vcs_create_by' => $_SESSION['usid'],
                    'vcs_create_dt' => DB::raw('sysdate')
                ]);
            $message = "Data supp " . $supp . " Berhasil Disimpan!";
            $status = "success";
            return compact(['message', 'status']);
        } else {
            DB::connection($_SESSION['connection'])->table("TBTABEL_VOUCHERSUPPLIER")
                ->where('vcs_kodeigr', '=', $_SESSION['kdigr'])
                ->where('vcs_namasupplier', '=', $supp)
                ->update([
                    'vcs_nilaivoucher' => $request->vcs_nilaivoucher,
                    'vcs_tglmulai' => DB::raw("to_date('" . $request->vcs_tglmulai . "','yyyy-mm-dd')"),
                    'vcs_tglakhir' => DB::raw("to_date('" . $request->vcs_tglakhir . "','yyyy-mm-dd')"),
                    'vcs_maxvoucher' => $request->vcs_maxvoucher,
                    'vcs_joinpromo' => $request->vcs_joinpromo,
                    'vcs_keterangan' => $request->vcs_keterangan,
                    'vcs_minstruk' => $request->vcs_minstruk,
                    'vcs_create_by' => $_SESSION['usid'],
                    'vcs_create_dt' => DB::raw('sysdate')
                ]);
            $message = "Data " . $supp . " Berhasil Diupdate!";
            $status = "success";
            return compact(['message', 'status']);
        }

    }

    public function hapus(Request $request)
    {
        $supp = $request->supp;
        DB::connection($_SESSION['connection'])->table("TBTABEL_VOUCHERSUPPLIER")
            ->where('vcs_kodeigr', '=', $_SESSION['kdigr'])
            ->where('vcs_namasupplier', '=', $supp)
            ->delete();
        $message = "Data " . $supp . " Berhasil Dihapus!";
        $status = "success";
        return compact(['message', 'status']);
    }

    public function cetak()
    {
        $w = 647;
        $h = 52.75;

        $data = DB::connection($_SESSION['connection'])->table("tbtabel_vouchersupplier")
            ->selectRaw('VCS_NAMASUPPLIER, VCS_NILAIVOUCHER, VCS_TGLMULAI, VCS_TGLAKHIR, VCS_MAXVOUCHER, VCS_JOINPROMO, VCS_KETERANGAN, VCS_MINSTRUK')
        ->where('vcs_kodeigr', '=', $_SESSION['kdigr'])
        ->orderBy('vcs_namasupplier')
        ->get();

        $filename = 'igr-tab-vchsup';

        $perusahaan = DB::connection($_SESSION['connection'])->table('tbmaster_perusahaan')
            ->first();

        $date = Carbon::now();
        $dompdf = new PDF();

        $pdf = PDF::loadview('TABEL.PENDAFTARANVOUCHERBELANJA.' . $filename . '-pdf', compact(['perusahaan', 'data']));

        error_reporting(E_ALL ^ E_DEPRECATED);

        $pdf->output();
        $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);

        $canvas = $dompdf->get_canvas();
        $canvas->page_text($w, $h, "Hal : {PAGE_NUM} dari {PAGE_COUNT}", null, 7, array(0, 0, 0));

        $dompdf = $pdf;

        return $dompdf->stream($filename . ' - ' . $date . '.pdf');
    }
}
