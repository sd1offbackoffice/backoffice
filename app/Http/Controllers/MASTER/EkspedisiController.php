<?php

namespace App\Http\Controllers\MASTER;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use PDF;
use Yajra\DataTables\DataTables;

class EkspedisiController extends Controller
{
    //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

    public function index(){
        $ekspedisi = DB::connection(Session::get('connection'))->table('tbmaster_ekspedisi')
            ->orderBy('xpd_kodeekspedisi')
            ->get();

        return view('MASTER.ekspedisi')->with(compact(['ekspedisi']));
    }

    public function getExpeditionDetail(Request $request){
        $detail = DB::connection(Session::get('connection'))->table('tbmaster_ekspedisi_area')
            ->join('tbmaster_cabang','cab_kodecabang','=','axp_igrtujuan')
            ->selectRaw("cab_namacabang tujuan, axp_biaya biaya, axp_lamakirim lamakirim")
            ->where('axp_kodeekspedisi','=',$request->code)
            ->orderBy('axp_igrtujuan')
            ->get();

        return DataTables::of($detail)->make(true);
    }

    public function updateFromIGRCRM(){
        try {
            DB::connection(Session::get('connection'))->beginTransaction();

            $data = DB::connection('igrcrm')
                ->table('tbmaster_ekspedisi')
                ->get();

            DB::connection(Session::get('connection'))
                ->table('tbmaster_ekspedisi')
                ->truncate();

            DB::connection(Session::get('connection'))
                ->table('tbmaster_ekspedisi')
                ->insert(json_decode(json_encode($data), true));

            DB::connection(Session::get('connection'))
                ->table('tbmaster_ekspedisi')
                ->update([
                    'xpd_kodeigr' => Session::get('kdigr')
                ]);

            $data = DB::connection('igrcrm')
                ->table('tbmaster_ekspedisi_area')
                ->get();

            DB::connection(Session::get('connection'))
                ->table('tbmaster_ekspedisi_area')
                ->truncate();

            DB::connection(Session::get('connection'))
                ->table('tbmaster_ekspedisi_area')
                ->insert(json_decode(json_encode($data), true));

            DB::connection(Session::get('connection'))
                ->table('tbmaster_ekspedisi_area')
                ->update([
                    'axp_kodeigr' => Session::get('kdigr')
                ]);

            DB::connection(Session::get('connection'))->commit();

            return response()->json([
                'message' => 'Update data berhasil!'
            ], 200);
        }
        catch (\Exception $e){
            DB::connection(Session::get('connection'))->rollBack();

            return response()->json([
                'message' => 'Update data gagal!',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
