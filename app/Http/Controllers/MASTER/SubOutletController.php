<?php

namespace App\Http\Controllers\MASTER;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller; use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class subOutletController extends Controller
{
    public function index(){
        $outlet     = DB::connection(Session::get('connection'))->table('tbmaster_outlet')->orderBy('out_kodeoutlet')->get()->toArray();

        return view('MASTER.sub-outlet', compact('outlet'));
    }

    public function getSubOutlet(Request $request){
        $outlet = $request->outlet;

        $suboutlet  = DB::connection(Session::get('connection'))->table('tbmaster_suboutlet')->where('sub_kodeoutlet', $outlet)->orderBy('sub_kodesuboutlet')->get()->toArray();

        return response()->json($suboutlet);
    }
}
