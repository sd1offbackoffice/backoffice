<?php

namespace App\Http\Controllers\TABEL;

use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;
use PDF;
use Yajra\DataTables\DataTables;

class MonitoringProdukController extends Controller
{
    public function index(){
        return view('TABEL.monitoring-produk');
    }

    public function getLovMonitoring(){
        $data = DB::table('tbtr_monitoringplu')
            ->selectRaw("mpl_kodemonitoring kode, mpl_namamonitoring nama")
            ->whereNotNull('mpl_kodemonitoring')
            ->distinct()
            ->get();

        return DataTables::of($data)->make(true);
    }
}
