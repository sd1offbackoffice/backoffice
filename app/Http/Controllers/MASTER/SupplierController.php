<?php

namespace App\Http\Controllers\MASTER;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller; use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class SupplierController extends Controller
{
    //

    public function index(){
        $kodeigr = Session::get('kdigr');

        $firstsupplier = DB::connection(Session::get('connection'))->table('tbmaster_supplier')
            ->select('sup_kodesupplier')
            ->where('sup_kodeigr','=',Session::get('kdigr'))
            ->orderBy('sup_kodesupplier')
            ->first();

        $supplier = DB::connection(Session::get('connection'))->table('tbmaster_supplier')
            ->select('sup_kodesupplier', 'sup_namasupplier')
            ->where('sup_kodeigr',$kodeigr)
            ->orderBy('sup_namasupplier')
            ->get();

        return view('MASTER.supplier')->with(compact(['firstsupplier','supplier']));
    }

    public function getDetail(Request $request){
        $result = DB::connection(Session::get('connection'))->table('tbmaster_supplier')
            ->select('*')
            ->where('sup_kodesupplier', $request->value)
            ->first();

        return $result;
    }

    public function lovSelect(Request $request){
        $result = DB::connection(Session::get('connection'))->table('tbmaster_supplier')
            ->select('*')
            ->where('sup_kodesupplier',$request->value)
            ->first();

        if(!$result){
            return 'not-found';
        }
        else return response()->json($result);
    }

    public function lovSearch(Request $request){
        if(is_numeric(substr($request->value,1,4))){
            $result = DB::connection(Session::get('connection'))->table('tbmaster_supplier')
                ->select('*')
                ->where('sup_kodesupplier','like', '%'.$request->value.'%')
                ->orderBy('sup_namasupplier')
                ->get();
        }


        else{
            $result = DB::connection(Session::get('connection'))->table('tbmaster_supplier')
                ->select('*')
                ->where('sup_namasupplier','like','%'.$request->value.'%')
                ->orderBy('sup_namasupplier')
                ->get();
        }

        return $result;
    }
}
