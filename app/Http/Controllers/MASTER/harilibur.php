<?php

namespace App\Http\Controllers\MASTER;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class hariliburController extends Controller
{
    public function index(){

        $harilibur = DB::table('TBMASTER_HARILIBUR')
            ->select('lib_tgllibur', 'lib_keteranganlibur')
            ->whereYear('lib_tgllibur', date("Y", strtotime("now")))
            //->limit(10)
            ->orderBy('lib_tgllibur')
            ->get();

        return view('MASTER.harilibur')->with('harilibur',$harilibur);
    }
}
