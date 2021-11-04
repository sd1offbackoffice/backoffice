<?php

namespace App\Http\Controllers\MASTER;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class subOutletController extends Controller
{
    public function index(){
        $outlet     = DB::connection($_SESSION['connection'])->table('tbmaster_outlet')->orderBy('out_kodeoutlet')->get()->toArray();

        return view('MASTER.subOutlet', compact('outlet'));
    }

    public function getSubOutlet(Request $request){
        $outlet = $request->outlet;

        $suboutlet  = DB::connection($_SESSION['connection'])->table('tbmaster_suboutlet')->where('sub_kodeoutlet', $outlet)->orderBy('sub_kodesuboutlet')->get()->toArray();

        return response()->json($suboutlet);
    }
}
