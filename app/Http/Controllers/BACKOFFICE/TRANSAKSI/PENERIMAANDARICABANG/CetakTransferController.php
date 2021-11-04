<?php

namespace App\Http\Controllers\BACKOFFICE\TRANSAKSI\PENERIMAANDARICABANG;

use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;
use PDF;
use Yajra\DataTables\DataTables;

class CetakTransferController extends Controller
{
    public function index(){
        return view('BACKOFFICE.TRANSAKSI.PENERIMAANDARICABANG.cetak-transfer');
    }

    public function getDataLov(){
        $lov = DB::connection($_SESSION['connection'])->table('tbtr_mstran_h')
            ->selectRaw("msth_nodoc no, TO_CHAR(msth_tgldoc, 'DD/MM/YYYY') tgl")
            ->where('msth_typetrn','=','I')
            ->where('msth_kodeigr','=',$_SESSION['kdigr'])
            ->whereNull('msth_recordid')
            ->orderBy('msth_tgldoc','desc')
            ->get();

        return DataTables::of($lov)->make(true);
    }

    public function cetak(Request $request){
        $bpb1 = $request->bpb1;
        $bpb2 = $request->bpb2;
        $ukuran = $request->size;

        $perusahaan = DB::connection($_SESSION['connection'])->table('tbmaster_perusahaan')
            ->first();

        $data = DB::connection($_SESSION['connection'])->select("select
                    case when prs_namacabang = cab_namacabang then
                                'BUKTI PENERIMAAN BARANG INTERN'
                    else
                                'TRANSFER ANTAR CABANG'
                    end jenis,
                    msth_nodoc,
                    msth_tgldoc,
                    cab_namacabang,
                    msth_nopo,
                    msth_tglpo,
                    mstd_prdcd,
                    prd_deskripsipanjang,
                    (
                        mstd_unit || '/' || mstd_frac
                    ) kemasan,
                    mstd_qty,
                    trunc(mstd_qty/mstd_frac) QB,
                    mod(mstd_qty,mstd_frac) QK,
                    mstd_hrgsatuan,
                    mstd_gross,
                    nvl(mstd_ppnrph,0) mstd_ppnrph,
                    (mstd_gross + nvl(mstd_ppnrph,0)) total_seluruh,
                    mstd_keterangan
                From
                    tbmaster_perusahaan,
                    tbmaster_cabang,
                    tbmaster_prodmast,
                    tbtr_mstran_h,
                    tbtr_mstran_d
                Where
                    prs_kodeigr = '".$_SESSION['kdigr']."'
                    and cab_kodeigr = prs_kodeigr
                    and msth_kodeigr = prs_kodeigr
                    and mstd_kodeigr = prs_kodeigr
                    and prd_kodeigr = prs_kodeigr
                    and prd_prdcd = mstd_prdcd
                    and cab_kodecabang = msth_loc2
                    and mstd_nodoc = msth_nodoc
                    and msth_typetrn = 'I'
                    and mstd_typetrn = msth_typetrn
                    and msth_nodoc >= '".$bpb1."'
                    and msth_nodoc <= '".$bpb2."'
                    and nvl(msth_recordid,0) <> '1'
                order by msth_nodoc asc");

//        dd($data);

        $dompdf = new PDF();

        $pdf = PDF::loadview('BACKOFFICE.TRANSAKSI.PENERIMAANDARICABANG.cetak-transfer-pdf', compact(['perusahaan','data','ukuran']));

        error_reporting(E_ALL ^ E_DEPRECATED);

        $pdf->output();
        $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);

        $canvas = $dompdf ->get_canvas();
        $canvas->page_text(507, 80.75, "{PAGE_NUM} dari {PAGE_COUNT}", null, 7, array(0, 0, 0));

        $dompdf = $pdf;

        return $dompdf->stream($data[0]->jenis.'.pdf');
    }

    public function test(){

    }
}
