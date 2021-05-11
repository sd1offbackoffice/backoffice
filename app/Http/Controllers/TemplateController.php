<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class TemplateController extends Controller
{
    public function index(){
        return view('template');
    }

    public function dataModal(){
        $data   = DB::table('tbmaster_cabang')->orderBy('cab_kodecabang')->limit(11)->get();
//        $data   = DB::table('tbmaster_cabang')->orderBy('cab_kodecabang')->get()->toArray();


        return Datatables::of($data)->make(true);
    }

    public function searchDataModal(Request $request){
        $search = $request->value;

        $data   = DB::table('tbmaster_prodmast')
            ->where('prd_prdcd','LIKE', '%'.$search.'%')
            ->orWhere('prd_deskripsipanjang','LIKE', '%'.$search.'%')
            ->orderBy('prd_prdcd')
            ->limit(100)
            ->get();

        return Datatables::of($data)->make(true);

//        return response()->json($data);
    }
}
