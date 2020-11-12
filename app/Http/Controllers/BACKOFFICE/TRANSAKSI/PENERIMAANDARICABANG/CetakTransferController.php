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
        $lov = DB::table('tbtr_mstran_h')
            ->selectRaw("msth_nodoc no, TO_CHAR(msth_tgldoc, 'DD/MM/YYYY') tgl")
            ->where('msth_typetrn','=','I')
            ->where('msth_kodeigr','=',$_SESSION['kdigr'])
            ->whereNull('msth_recordid')
            ->orderBy('msth_tgldoc','desc')
            ->get();

        return DataTables::of($lov)->make(true);
    }
}