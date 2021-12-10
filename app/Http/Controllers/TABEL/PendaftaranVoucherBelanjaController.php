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
use App\Http\Controllers\Controller; use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use PDF;
use DateTime;
use Yajra\DataTables\DataTables;

class PendaftaranVoucherBelanjaController extends Controller
{

    public function index()
    {
        return view('TABEL.PENDAFTARANVOUCHERBELANJA.pendaftaran-voucher-belanja');
    }

    public function modalSupplier(Request $request)
    {
        $search = $request->value;

        $datas = DB::connection(Session::get('connection'))->table("tbtabel_vouchersupplier")
            ->select("vcs_namasupplier")
            ->where('vcs_kodeigr', '=', Session::get('kdigr'))
            ->whereRaw("vcs_namasupplier like '%" . $search . "%'")
            ->orderBy("vcs_namasupplier")
            ->get();
        return Datatables::of($datas)->make(true);
    }

    public function getDataTable(Request $request)
    {
        $search = $request->value;

        $datas = DB::connection(Session::get('connection'))->table("tbtabel_vouchersupplier")
            ->where('vcs_kodeigr', '=', Session::get('kdigr'))
            ->whereRaw("vcs_namasupplier like '%" . $search . "%'")
            ->orderBy("vcs_namasupplier")
            ->get();
        return Datatables::of($datas)->make(true);
    }

    public function getDeskripsi(Request $request)
    {
        $supp = $request->supp;
        $data = DB::connection(Session::get('connection'))->table("tbtabel_vouchersupplier")
            ->selectRaw("vcs_keterangan")
            ->where('vcs_kodeigr', '=', Session::get('kdigr'))
            ->where('vcs_namasupplier', '=', $supp)
            ->pluck('vcs_keterangan')->first();
        return $data;
    }

    public function getDataSupplier(Request $request)
    {
        $supp = $request->supp;

        $data = DB::connection(Session::get('connection'))->table("tbtabel_vouchersupplier")
            ->where('vcs_kodeigr', '=', Session::get('kdigr'))
            ->where('vcs_namasupplier', '=', $supp)
            ->first();

        return compact(['data']);

    }

    public function simpan(Request $request)
    {
        $supp = $request->supp;

        $temp = DB::connection(Session::get('connection'))->table("tbtabel_vouchersupplier")
            ->selectRaw("NVL(COUNT(1),0) count")
            ->where('vcs_kodeigr', '=', Session::get('kdigr'))
            ->where('vcs_namasupplier', '=', $supp)
            ->pluck('count')->first();

        if ($temp == 0) {
            DB::connection(Session::get('connection'))->table("tbtabel_vouchersupplier")
                ->insert([
                    'vcs_kodeigr' => Session::get('kdigr'),
                    'vcs_namasupplier' => $supp,
                    'vcs_nilaivoucher' => $request->vcs_nilaivoucher,
                    'vcs_tglmulai' => DB::raw("to_date('" . $request->vcs_tglmulai . "','yyyy-mm-dd')"),
                    'vcs_tglakhir' => DB::raw("to_date('" . $request->vcs_tglakhir . "','yyyy-mm-dd')"),
                    'vcs_maxvoucher' => $request->vcs_maxvoucher,
                    'vcs_joinpromo' => $request->vcs_joinpromo,
                    'vcs_keterangan' => $request->vcs_keterangan,
                    'vcs_minstruk' => $request->vcs_minstruk,
                    'vcs_create_by' => Session::get('usid'),
                    'vcs_create_dt' => DB::raw('sysdate')
                ]);
            $message = "Data supp " . $supp . " Berhasil Disimpan!";
            $status = "success";
            return compact(['message', 'status']);
        } else {
            DB::connection(Session::get('connection'))->table("TBTABEL_VOUCHERSUPPLIER")
                ->where('vcs_kodeigr', '=', Session::get('kdigr'))
                ->where('vcs_namasupplier', '=', $supp)
                ->update([
                    'vcs_nilaivoucher' => $request->vcs_nilaivoucher,
                    'vcs_tglmulai' => DB::raw("to_date('" . $request->vcs_tglmulai . "','yyyy-mm-dd')"),
                    'vcs_tglakhir' => DB::raw("to_date('" . $request->vcs_tglakhir . "','yyyy-mm-dd')"),
                    'vcs_maxvoucher' => $request->vcs_maxvoucher,
                    'vcs_joinpromo' => $request->vcs_joinpromo,
                    'vcs_keterangan' => $request->vcs_keterangan,
                    'vcs_minstruk' => $request->vcs_minstruk,
                    'vcs_create_by' => Session::get('usid'),
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
        DB::connection(Session::get('connection'))->table("TBTABEL_VOUCHERSUPPLIER")
            ->where('vcs_kodeigr', '=', Session::get('kdigr'))
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

        $data = DB::connection(Session::get('connection'))->table("tbtabel_vouchersupplier")
            ->selectRaw('VCS_NAMASUPPLIER, VCS_NILAIVOUCHER, VCS_TGLMULAI, VCS_TGLAKHIR, VCS_MAXVOUCHER, VCS_JOINPROMO, VCS_KETERANGAN, VCS_MINSTRUK')
        ->where('vcs_kodeigr', '=', Session::get('kdigr'))
        ->orderBy('vcs_namasupplier')
        ->get();

        $filename = 'igr-tab-vchsup';

        $perusahaan = DB::connection(Session::get('connection'))->table('tbmaster_perusahaan')
            ->first();

        return view('TABEL.PENDAFTARANVOUCHERBELANJA.'.$filename.'-pdf', compact(['perusahaan', 'data']));

    }
}
