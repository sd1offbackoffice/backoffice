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

class MaxPembelianItemPerTransaksiController extends Controller
{

    public function index()
    {
        return view('TABEL\MAXPEMBELIANITEMPERTRANSAKSI.maxpembelianitempertransaksi');
    }

    public function modalPlu(Request $request)
    {
        $search = $request->value;

        $datas = DB::table("TBMASTER_PRODMAST")
            ->select("PRD_DESKRIPSIPANJANG", "PRD_PRDCD")
            ->whereRaw('nvl(prd_recordid,9)<>1')
            ->where('prd_kodeigr', '=', $_SESSION['kdigr'])
            ->whereRaw("PRD_PRDCD like '%" . $search . "%'")
            ->orderBy("PRD_PRDCD")
            ->limit(100)
            ->get();
        return Datatables::of($datas)->make(true);
    }

    public function getDataTable(Request $request)
    {
        $search = $request->value;

        $datas = DB::table("TBTABEL_MAXTRANSAKSI")
            ->where('mtr_kodeigr', '=', $_SESSION['kdigr'])
            ->whereRaw("mtr_prdcd like '%" . $search . "%'")
            ->orderBy("mtr_prdcd")
            ->get();
        return Datatables::of($datas)->make(true);
    }

    public function getDeskripsi(Request $request)
    {
        $plu = $request->plu;
        $data = '';
        $temp = DB::table("TBMASTER_PRODMAST")
            ->selectRaw("NVL(COUNT(1),0) temp")
            ->whereRaw('nvl(prd_recordid,9)<>1')
            ->where('PRD_KODEIGR', '=', $_SESSION['kdigr'])
            ->where('PRD_PRDCD', '=', $plu)
            ->pluck('temp')->first();

        if ($temp > 0) {
            $data = DB::table("TBMASTER_PRODMAST")
                ->selectRaw("prd_deskripsipanjang || ' - ' || prd_unit || '/' || prd_frac desk")
                ->whereRaw('nvl(prd_recordid,9)<>1')
                ->where('PRD_KODEIGR', '=', $_SESSION['kdigr'])
                ->where('PRD_PRDCD', '=', $plu)
                ->pluck('desk')->first();
            return $data;
        } else {
            return 'Barang Tidak Terdaftar Di Master Prodmast';
        }
    }

    public function getDataPLU(Request $request)
    {
        $plu = $request->plu;
        $data = '';
        $info = DB::table("TBMASTER_PRODMAST")
            ->selectRaw("PRD_DESKRIPSIPANJANG || '-' || PRD_UNIT || '/' || PRD_FRAC info")
            ->where('PRD_KODEIGR', '=', $_SESSION['kdigr'])
            ->where('PRD_PRDCD', '=', $plu)
            ->pluck('info')->first();

        $temp = DB::table("TBTABEL_MAXTRANSAKSI")
            ->selectRaw("COUNT(1) count")
            ->where('MTR_KODEIGR', '=', $_SESSION['kdigr'])
            ->where('MTR_PRDCD', '=', $plu)
            ->pluck('count')->first();

        if ($temp > 0) {
            $data = DB::table("TBTABEL_MAXTRANSAKSI")
                ->selectRaw("MTR_QTYREGULERBIRU, MTR_QTYREGULERBIRUPLUS, MTR_QTYFREEPASS, MTR_QTYRETAILERMERAH, MTR_QTYSILVER, MTR_QTYGOLD1, MTR_QTYGOLD2, MTR_QTYGOLD3, MTR_QTYPLATINUM")
                ->where('MTR_KODEIGR', '=', $_SESSION['kdigr'])
                ->whereRaw("MTR_PRDCD = '" . $plu . "'")
                ->first();
        }
        return compact(['data', 'info']);

    }

    public function simpan(Request $request)
    {
        $plu = $request->plu;

        $temp = DB::table("TBTABEL_MAXTRANSAKSI")
            ->selectRaw("NVL(COUNT(1),0) count")
            ->where('MTR_KODEIGR', '=', $_SESSION['kdigr'])
            ->where('MTR_PRDCD', '=', $plu)
            ->pluck('count')->first();

        if ($temp == 0) {
            DB::table("TBTABEL_MAXTRANSAKSI")
                ->insert([
                    'mtr_kodeigr' => $_SESSION['kdigr'],
                    'mtr_prdcd' => $plu,
                    'mtr_qtyregulerbiru' => $request->mtr_qtyregulerbiru,
                    'mtr_qtyregulerbiruplus' => $request->mtr_qtyregulerbiruplus,
                    'mtr_qtyfreepass' => $request->mtr_qtyfreepass,
                    'mtr_qtyretailermerah' => $request->mtr_qtyretailermerah,
                    'mtr_qtysilver' => $request->mtr_qtysilver,
                    'mtr_qtygold1' => $request->mtr_qtygold1,
                    'mtr_qtygold2' => $request->mtr_qtygold2,
                    'mtr_qtygold3' => $request->mtr_qtygold3,
                    'mtr_qtyplatinum' => $request->mtr_qtyplatinum,
                    'mtr_create_by' => $_SESSION['usid'],
                    'mtr_create_dt' => DB::raw('sysdate')
                ]);
            $message = "Data PLU " . $plu . " Berhasil Disimpan!";
            $status = "success";
            return compact(['message', 'status']);
        } else {
            DB::table("TBTABEL_MAXTRANSAKSI")
                ->where('MTR_KODEIGR', '=', $_SESSION['kdigr'])
                ->where('MTR_PRDCD', '=', $plu)
                ->update([
                    'mtr_qtyregulerbiru' => $request->mtr_qtyregulerbiru,
                    'mtr_qtyregulerbiruplus' => $request->mtr_qtyregulerbiruplus,
                    'mtr_qtyfreepass' => $request->mtr_qtyfreepass,
                    'mtr_qtyretailermerah' => $request->mtr_qtyretailermerah,
                    'mtr_qtysilver' => $request->mtr_qtysilver,
                    'mtr_qtygold1' => $request->mtr_qtygold1,
                    'mtr_qtygold2' => $request->mtr_qtygold2,
                    'mtr_qtygold3' => $request->mtr_qtygold3,
                    'mtr_qtyplatinum' => $request->mtr_qtyplatinum,
                    'mtr_create_by' => $_SESSION['usid'],
                    'mtr_create_dt' => DB::raw('sysdate')
                ]);
            $message = "Data PLU " . $plu . " Berhasil Diupdate!";
            $status = "success";
            return compact(['message', 'status']);
        }

    }

    public function hapus(Request $request)
    {
        $plu = $request->plu;

        DB::table("TBTABEL_MAXTRANSAKSI")
            ->where('MTR_KODEIGR', '=', $_SESSION['kdigr'])
            ->where('MTR_PRDCD', '=', $plu)
            ->delete();
        $message = "Data PLU " . $plu . " Berhasil Dihapus!";
        $status = "success";
        return compact(['message', 'status']);
    }

    public function cetak()
    {
        $w = 490;
        $h = 37.75;

        $data = DB::select("SELECT MTR_PRDCD, MTR_QTYREGULERBIRU, MTR_QTYREGULERBIRUPLUS, MTR_QTYFREEPASS, MTR_QTYRETAILERMERAH, MTR_QTYSILVER, MTR_QTYGOLD1, MTR_QTYGOLD2, MTR_QTYGOLD3, MTR_QTYPLATINUM,
                PRD_DESKRIPSIPANJANG, PRD_UNIT || '/' || PRD_FRAC UNIT,
                PRS_NAMAPERUSAHAAN, PRS_NAMACABANG, PRS_NAMAWILAYAH FROM TBTABEL_MAXTRANSAKSI, TBMASTER_PRODMAST, TBMASTER_PERUSAHAAN
                WHERE MTR_KODEIGR = '" . $_SESSION['kdigr'] . "'
                AND PRD_KODEIGR = MTR_KODEIGR AND PRD_PRDCD = MTR_PRDCD
                AND PRS_KODEIGR = '" . $_SESSION['kdigr'] . "'
                ORDER BY MTR_PRDCD");
        $filename = 'igr-tab-maxtran';

        $perusahaan = DB::table('tbmaster_perusahaan')
            ->first();

        $date = Carbon::now();
        $dompdf = new PDF();

        $pdf = PDF::loadview('TABEL.MAXPEMBELIANITEMPERTRANSAKSI.' . $filename . '-pdf', compact(['perusahaan', 'data']));

        error_reporting(E_ALL ^ E_DEPRECATED);

        $pdf->output();
        $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);

        $canvas = $dompdf->get_canvas();
        $canvas->page_text($w, $h, "HAL : {PAGE_NUM} dari {PAGE_COUNT}", null, 7, array(0, 0, 0));

        $dompdf = $pdf;

        return $dompdf->stream($filename . ' - ' . $date . '.pdf');
    }
}
