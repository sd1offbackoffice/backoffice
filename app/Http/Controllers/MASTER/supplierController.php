<?php

namespace App\Http\Controllers\MASTER;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class supplierController extends Controller
{
    //

    public function index(){
        $firstsupplier = DB::table('tbmaster_supplier')
            ->select('sup_kodesupplier')
            ->where('sup_kodeigr','=','22')
            ->orderBy('sup_kodesupplier')
            ->first();

        $supplier = DB::table('tbmaster_supplier')
            ->select('sup_kodesupplier', 'sup_namasupplier')
            ->where('sup_kodeigr','=','22')
            ->orderBy('sup_namasupplier')
            ->limit(100)
            ->get();

        return view('MASTER.supplier')->with(compact(['firstsupplier','supplier']));
    }

    public function getDetail(Request $request){
        $result = DB::table('tbmaster_supplier')
            ->select('*')
            ->where('sup_kodesupplier', $request->value)
            ->first();

        return $result;
    }

    public function lov_select(Request $request){
        $result = DB::table('tbmaster_supplier')
            ->select('*')
            ->where('sup_kodesupplier',$request->value)
            ->first();

        if(!$result){
            return 'not-found';
        }
        else return response()->json($result);
    }

    public function lov_search(Request $request){
        if(is_numeric(substr($request->value,1,4))){
            $result = DB::table('tbmaster_supplier')
                ->select('*')
                ->where('sup_kodesupplier','like', '%'.$request->value.'%')
                ->orderBy('sup_namasupplier')
                ->get();
        }


        else{
            $result = DB::table('tbmaster_supplier')
                ->select('*')
                ->where('sup_namasupplier','like','%'.$request->value.'%')
                ->orderBy('sup_namasupplier')
                ->get();
        }

        return $result;
    }
}
