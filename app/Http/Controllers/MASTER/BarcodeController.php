<?php

namespace App\Http\Controllers\MASTER;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller; use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;


class BarcodeController extends Controller
{
    public function index(){
        return view('MASTER.barcode');
    }

    public function getBarcode(Request $request){
        $search = $request->value;

        $barcode = DB::connection(Session::get('connection'))->table('TBMASTER_BARCODE')
            ->select('*')
            ->where('BRC_BARCODE','LIKE', '%'.$search.'%')
            ->orWhere('BRC_PRDCD','LIKE', '%'.$search.'%')
            ->limit(100)
            ->get();
        return Datatables::of($barcode)->make(true);
    }

    public function search_barcode(Request $request){
        if ($request->value == '0000000'){
            $barcode = DB::connection(Session::get('connection'))->table('TBMASTER_BARCODE')
                ->select('*')
                ->limit(20)
                ->get();
        }
        else{
            $barcode = DB::connection(Session::get('connection'))->table('TBMASTER_BARCODE')
                ->select('*')
                ->where('BRC_PRDCD','LIKE',$request->value)
                ->limit(20)
                ->get();
        }

        return $barcode;
    }
    public function testdenni(){
        return view('BACKOFFICE.dennitest');
    }
}
