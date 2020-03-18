<?php

namespace App\Http\Controllers\MASTER;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;


class barcodeController extends Controller
{
    public function index(){
        $barcode = DB::table('TBMASTER_BARCODE')
            ->select('*')
            ->limit(20)
            ->get();
        return view('MASTER.barcode')->with('barcode',$barcode);
    }

    public function search_barcode(Request $request){
        if ($request->value == '0000000'){
            $barcode = DB::table('TBMASTER_BARCODE')
                ->select('*')
                ->limit(20)
                ->get();
        }
        else{
            $barcode = DB::table('TBMASTER_BARCODE')
                ->select('*')
                ->where('BRC_PRDCD','LIKE',$request->value)
                ->limit(20)
                ->get();
        }

        return $barcode;
    }
}
