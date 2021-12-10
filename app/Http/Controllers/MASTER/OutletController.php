<?php

namespace App\Http\Controllers\MASTER;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller; use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class OutletController extends Controller
{
    public function index(){
        $outlet   = DB::connection(Session::get('connection'))->table('tbmaster_outlet')->orderBy('out_kodeoutlet')->get()->toArray();

        return view('MASTER.outlet', compact('outlet'));
    }
}
