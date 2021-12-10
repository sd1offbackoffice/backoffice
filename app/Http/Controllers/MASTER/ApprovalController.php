<?php

namespace App\Http\Controllers\MASTER;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller; use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\NotIn;


class ApprovalController extends Controller
{
    public function index(){
//        $result = DB::connection(Session::get('connection'))->table('TBMASTER_REPORT_APPROVAL')->SELECT("*")->First();
        return view('MASTER.approval');
    }

    public function saveData(Request $request){
//        $result = DB::connection(Session::get('connection'))->table('TBMASTER_REPORT_APPROVAL')->SELECT("*")->count();
//        if ($result==0) {
            DB::connection(Session::get('connection'))->table('TBMASTER_REPORT_APPROVAL')->insert(
                ['RAP_KODEIGR' => Session::get('kdigr'), 'RAP_STORE_MANAGER' => $request->storemanager, 'RAP_STORE_ADM' => $request->storeadm, 'RAP_LOGISTIC_SUPERVISOR' => $request->logisticsupervisor, 'RAP_STOCKKEEPER_II' => $request->stockkeeper, 'RAP_ADMINISTRASI' => $request->administrasi, 'RAP_KEPALAGUDANG' => $request->kepalagudang]
            );
            return 'save';
//        }
//        else{
//            DB::connection(Session::get('connection'))->table('TBMASTER_REPORT_APPROVAL')->where('RAP_KODEIGR','22')
//                ->update(['RAP_KODEIGR' => '22', 'RAP_STORE_MANAGER' => $request->storemanager, 'RAP_STORE_ADM' => $request->storeadm, 'RAP_LOGISTIC_SUPERVISOR' => $request->logisticsupervisor, 'RAP_STOCKKEEPER_II' => $request->stockkeeper, 'RAP_ADMINISTRASI' => $request->administrasi, 'RAP_KEPALAGUDANG' => $request->kepalagudang]);
//            return 'update';
//        }
    }
}
