<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class TemplateController extends Controller
{
    public function __construct()
    {

    }

    public function index(){
        return view('template');
    }

    public function dataModal(){
        $data   = DB::connection(Session::get('connection'))->table('tbmaster_cabang')->orderBy('cab_kodecabang')->limit(11)->get();
//        $data   = DB::connection(Session::get('connection'))->table('tbmaster_cabang')->orderBy('cab_kodecabang')->get()->toArray();


        return Datatables::of($data)->make(true);
    }

    public function searchDataModal(Request $request){
        $search = $request->value;

        $data   = DB::connection(Session::get('connection'))->table('tbmaster_prodmast')
            ->where('prd_prdcd','LIKE', '%'.$search.'%')
            ->orWhere('prd_deskripsipanjang','LIKE', '%'.$search.'%')
            ->orderBy('prd_prdcd')
            ->limit(100)
            ->get();

        return Datatables::of($data)->make(true);

//        return response()->json($data);
    }

    public function testing(Request $request){
//        $a = DB::connection('igrcrm')->table('tbmaster_cabang')->get();
//
//        dd($a);
        $kodeAPI        = "CUSTOMREPORT2021";
        $reload_name    = "reload-customreport2021";
        $reload_month   = "May+2021";

        $convert_month  = date('m', strtotime($reload_month));
        $convert_year   = date('Y', strtotime($reload_month));
        $ip             = $request->getClientIp();
        date_default_timezone_set('Asia/Jakarta');
        $date           = date('Y-m-d H:i:s');

        DB::connection('igrcrm')->table('mtr_api_temp')->insert(['list_apiname' => $kodeAPI, 'list_result' => 'LOADING', 'list_start_by' => $ip, 'list_start_dt' => $date]);

        try{
            $ch     = curl_init();
            $url    = "http://172.20.28.14:2128/$reload_name/?month=$convert_month&year=$convert_year";

            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

            $result         = curl_exec($ch);
            $get_response   = json_decode($result);
            curl_close($ch);

            if (!$get_response){
                DB::connection('igrcrm')->table('mtr_api_temp')->where('list_apiname', $kodeAPI)->where('list_result', 'LOADING')->update(['list_result' => 'Server Disconnect']);
                return response()->json(['kode' => 0, 'msg' => "Koneksi Server Terputus"]);
            } else {
                if ($get_response->Status == 'OK'){
                    $dateEnd      = date('Y-m-d H:i:s');
                    DB::connection('igrcrm')->table('mtr_api_temp')->where('list_apiname', $kodeAPI)->where('list_result', 'LOADING')
                        ->update(['list_result' => 'OK', 'list_finish_dt' => $dateEnd]);
                    return response()->json(['kode' => 1, 'msg' => 'Reload QV Berhasil']);
                } else {
                    $dateEnd      = date('Y-m-d H:i:s');
                    DB::connection('igrcrm')->table('mtr_api_temp')->where('list_apiname', $kodeAPI)->where('list_result', 'LOADING')
                        ->update(['list_result' => 'WARNING', 'list_finish_dt' => $dateEnd]);
                    return response()->json(['kode' => 0, 'msg' => $get_response]);
                }

            }
        } catch (\Exception $e){
            DB::connection('igrcrm')->table('mtr_api_temp')->where('list_apiname', $kodeAPI)->where('list_result', 'LOADING')->update(['list_result' => 'ERROR']);
            return response()->json(['kode' => 0, 'msg' => $e->getMessage()]);
        }
    }
}
