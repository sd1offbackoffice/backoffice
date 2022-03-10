<?php

namespace App\Http\Controllers\BACKOFFICE\LAPORAN;

use App\Http\Controllers\Auth\loginController;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Mockery\Exception;
use PDF;
use Yajra\DataTables\DataTables;

class LaporanMonitoringFakturPajakSJNRBController extends Controller
{
    public function index()
    {
        return view('BACKOFFICE.LAPORAN.monitoring-faktur-pajak-sj-nrb');
    }

    public function getLovSupplier(Request $request)
    {
        $search = $request->search;
        $data = DB::connection(Session::get('connection'))->table('tbmaster_supplier')
            ->selectRaw("sup_kodesupplier,sup_namasupplier")
            ->whereRaw("sup_kodesupplier LIKE '%" . $search . "%' or sup_namasupplier LIKE '%" . $search . "%'")
            ->orderBy('sup_kodesupplier')
            ->limit(100)
            ->get();

        return DataTables::of($data)->make(true);
    }

    public function cetak(Request $request)
    {
        $tgl1 = $request->tanggal1;
        $tgl2 = $request->tanggal2;
        $kategori = $request->kategori;
        $cetak = $request->cetak;
        $keterangan='';
        $and_pil = '';
        $and_type = '';

        if ($cetak == 'S') {
            $and_pil = " and msth_typetrn in ('O')";
        } else {
            $and_pil = " and msth_typetrn in ('K')";
        }

        if ($kategori == 'O') {
            $and_type = ' and mstd_invno is not null';
            $keterangan = 'SUDAH CETAK';
        } else if ($kategori == 'K') {
            $and_type = ' and mstd_invno is null';
            $keterangan = 'BELUM CETAK';
        } else if ($kategori == 'A') {
            $and_type = ' ';
            $keterangan = 'SEMUA TRANSAKSI';
        }

        $data = DB::connection(Session::get('connection'))
            ->select("select prs_namaperusahaan, prs_namacabang, mstd_tgldoc, mstd_nodoc,  mstd_invno, keterangan,
                                sum(item) item, sum(mstd_gross+mstd_ppnrph+mstd_ppnbmrph+mstd_ppnbtlrph-mstd_discrph) gross
                            from (
                                    select prs_namaperusahaan, prs_namacabang, mstd_tgldoc, mstd_nodoc,  mstd_invno,  1 item,
                                        mstd_gross, mstd_ppnrph, mstd_ppnbmrph, mstd_ppnbtlrph, mstd_discrph,
                                        case when mstd_invno is not null then 'OK' else 'BELUM' end keterangan
                                from tbtr_mstran_h, tbtr_mstran_d, tbmaster_perusahaan, tbmaster_prodmast
                                where msth_kodeigr='".Session::get('kdigr')."'
                                    and nvl(msth_recordid, '9') <> '1'
                                    and msth_tgldoc between to_date('" . $tgl1 . "','dd/mm/yyyy') and to_date('" . $tgl2 . "','dd/mm/yyyy')
                                    and nvl(mstd_recordid, '9') <> '1'
                                    ".$and_pil."
                                    and mstd_nodoc=msth_nodoc
                                    and mstd_kodeigr=msth_kodeigr
                                    and mstd_pkp = 'Y'
                                    ".$and_type."
                                    and prd_prdcd(+)=mstd_prdcd
                                    and prd_kodeigr(+)=mstd_kodeigr
                                    and prd_flagbkp1 = 'Y'
                                    and prs_kodeigr=msth_kodeigr
                                 order by mstd_tgldoc, mstd_nodoc)
                            group by prs_namaperusahaan, prs_namacabang, mstd_tgldoc, mstd_nodoc,  mstd_invno, keterangan
                            order by mstd_tgldoc, mstd_nodoc");
        $perusahaan = DB::connection(Session::get('connection'))->table('tbmaster_perusahaan')->first();

        return view('BACKOFFICE.LAPORAN.monitoring-faktur-pajak-sj-nrb-pdf', compact(['perusahaan', 'data', 'tgl1', 'tgl2', 'keterangan']));
    }
}
