<?php

namespace App\Http\Controllers\TABEL;

use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller; use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;
use PDF;
use Yajra\DataTables\DataTables;

class MonitoringSupplierController extends Controller
{
    public function index()
    {
        return view('TABEL.monitoring-supplier');
    }

    public function getLovMonitoring()
    {
        $data = DB::connection(Session::get('connection'))->table('tbtr_monitoringsupplier')
            ->selectRaw("msu_kodemonitoring kode, msu_namamonitoring nama")
            ->orderBy("msu_kodemonitoring")
            ->distinct()
            ->get();
        return DataTables::of($data)->make(true);
    }

    public function getMonitoring(Request $request)
    {
        $search = $request->supplier;
        $data = DB::connection(Session::get('connection'))->table('tbtr_monitoringsupplier')
            ->where('msu_kodemonitoring', '=', $search)
            ->first();
        if (!$data) {
            return response()->json([
                'message' => 'Kode monitoring tidak valid!'
            ], 500);
        } else {
            $data = DB::connection(Session::get('connection'))->table('tbtr_monitoringsupplier')
                ->join('tbmaster_supplier', 'sup_kodesupplier', '=', 'msu_kodesupplier')
                ->where('msu_kodemonitoring', '=', $search)
                ->orderBy("msu_kodemonitoring")
                ->get();
            return DataTables::of($data)->make(true);
        }
    }

    public function getLovSupplier(Request $request)
    {
        $search = $request->supplier;

        $data = DB::connection(Session::get('connection'))->table("tbmaster_supplier")
            ->select("sup_kodesupplier", "sup_namasupplier", "sup_pkp")
            ->whereRaw("(sup_kodesupplier like '%" . $search . "%' or sup_namasupplier like '%" . $search . "%')")
            ->orderBy('sup_kodesupplier')
            ->get();

        return DataTables::of($data)->make(true);
    }

    public function cekData(Request $request)
    {
        $search = $request->kodemonitoring;
        $data = DB::connection(Session::get('connection'))->table('tbtr_monitoringsupplier')
            ->where('msu_kodemonitoring', '=', $search)
            ->first();
        return compact(['data']);
    }

    public function tambah(Request $request)
    {
        $kodemtr = $request->kodemonitoring;
        $namamtr = $request->namamonitoring;
        $kodesupplier = $request->kodesupplier;
        try {
            DB::connection(Session::get('connection'))->beginTransaction();
            $temp = DB::connection(Session::get('connection'))->table("tbtr_monitoringsupplier")
                ->where("msu_kodemonitoring", $kodemtr)
                ->where("msu_kodesupplier", $kodesupplier)
                ->first();

            if (!$temp) {
                DB::connection(Session::get('connection'))
                    ->table('tbtr_monitoringsupplier')
                    ->insert([
                        'msu_kodeigr' => Session::get('kdigr'),
                        'msu_kodemonitoring' => $kodemtr,
                        'msu_namamonitoring' => $namamtr,
                        'msu_kodesupplier' => $kodesupplier,
                        'msu_create_by' => Session::get('usid'),
                        'msu_create_dt' => Carbon::now()
                    ]);


            } else {
                return response()->json([
                    'message' => 'Kode sudah terdaftar!',
                    'status' => 'error'
                ], 500);
            }

            DB::connection(Session::get('connection'))->commit();

            return response()->json([
                'message' => 'Supplier ' . $kodesupplier . ' sudah masuk ke kode monitoring ' . $kodemtr . ' !',
                'status' => 'success'
            ], 200);
        } catch (\Exception $e) {
            DB::connection(Session::get('connection'))->rollBack();

            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function hapus(Request $request)
    {
        $kodemtr = $request->kodemonitoring;
        $kodesupplier = $request->kodesupplier;
        try {
            DB::connection(Session::get('connection'))->beginTransaction();
            $temp = DB::connection(Session::get('connection'))->table("tbtr_monitoringsupplier")
                ->where("msu_kodemonitoring", $kodemtr)
                ->where("msu_kodesupplier", $kodesupplier)
                ->first();

            if (!$temp) {
                return response()->json([
                    'message' => 'Kode tidak terdaftar!'
                ], 500);
            } else {
                $temp = DB::connection(Session::get('connection'))->table("tbtr_monitoringsupplier")
                    ->where("msu_kodemonitoring", $kodemtr)
                    ->where("msu_kodesupplier", $kodesupplier)
                    ->delete();

                DB::connection(Session::get('connection'))->commit();

                if ($temp == 0) {
                    return response()->json([
                        'message' => 'Kode Supplier ' . $kodesupplier . ' tidak ada dalam kode monitoring ' . $request->kodemtr . ' !'
                    ], 500);
                } else {
                    return response()->json([
                        'message' => 'Kode Supplier ' . $kodesupplier . ' berhasil dihapus!'
                    ], 200);
                }
            }
        } catch (\Exception $e) {
            DB::connection(Session::get('connection'))->rollBack();

            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function print(Request $request)
    {
        $perusahaan = DB::connection(Session::get('connection'))
            ->table("tbmaster_perusahaan")
            ->first();

        $monitoring = DB::connection(Session::get('connection'))
            ->table('tbtr_monitoringsupplier')
            ->selectRaw("msu_kodemonitoring kode, msu_namamonitoring nama")
            ->where('msu_kodemonitoring', '=', $request->mon)
            ->first();

        $data = DB::connection(Session::get('connection'))
            ->select("SELECT msu_kodemonitoring, msu_namamonitoring, msu_kodesupplier, sup_namasupplier, sup_pkp
                    FROM TBTR_MONITORINGSUPPLIER, TBMASTER_SUPPLIER
                    WHERE msu_kodesupplier = sup_kodesupplier
                      AND msu_kodemonitoring = '" . $request->mon . "'
                    ORDER BY msu_kodesupplier");
        return view('TABEL.monitoring-supplier-pdf', compact(['perusahaan', 'data', 'monitoring']));
    }
}
