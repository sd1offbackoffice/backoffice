<?php

namespace App\Http\Controllers\MASTER;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class outletController extends Controller
{
    public function index(){
        $outlet   = DB::table('tbmaster_outlet')->orderBy('out_kodeoutlet')->get()->toArray();

        return view('MASTER.outlet', compact('outlet'));
    }
}
