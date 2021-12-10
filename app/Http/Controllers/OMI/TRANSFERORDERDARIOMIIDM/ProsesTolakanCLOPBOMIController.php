<?php

namespace App\Http\Controllers\OMI\TRANSFERORDERDARIOMIIDM;

use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller; use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;
use PDF;
use Yajra\DataTables\DataTables;

class ProsesTolakanCLOPBOMIController extends Controller
{
    public function index(){
        return view('OMI.TRANSFERORDERDARIOMIIDM.proses-tolakan-clo-pb-omi');
    }

    public function getData(){
        $data = DB::connection(Session::get('connection'))
            ->table('tbtr_tolakanpbomi_clo')
            ->selectRaw("tlkc_kodeomi, tlkc_nopb, to_char(tlkc_tglpb, 'dd/mm/yyyy') tlkc_tglpb,
                tlkc_max_kredit, tlkc_tagihan, tlkc_nilai_pb, tlkc_jml_kredit, tlkc_status, tlkc_namaomi,
                tlkc_keterangan")
//            ->where('tlkc_status','=',1)
            ->get();

        return DataTables::of($data)->make(true);
    }

    public function saveData(Request $request){
        try{
            DB::connection(Session::get('connection'))->beginTransaction();

            foreach($request->changedData as $cd){
                $test = DB::connection(Session::get('connection'))
                    ->table('tbtr_tolakanpbomi_clo')
                    ->where('tlkc_kodeomi','=',$cd['tlkc_kodeomi'])
                    ->where('tlkc_nopb','=',$cd['tlkc_nopb'])
                    ->whereDate('tlkc_tglpb','=',Carbon::createFromFormat('d/m/Y',$cd['tlkc_tglpb']))
                    ->update([
                        'tlkc_status' => $cd['tlkc_status'],
                        'tlkc_modify_by' => Session::get('usid'),
                        'tlkc_modify_dt' => Carbon::now()
                    ]);
            }

            DB::connection(Session::get('connection'))->commit();

            return response()->json([
                'message' => 'Perubahan berhasil disimpan!'
            ], 200);
        }
        catch (\Exception $e){
            DB::connection(Session::get('connection'))->rollBack();

            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
