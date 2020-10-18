<?php

namespace App\Http\Controllers\BACKOFFICE\TRANSAKSI\PEMUSNAHAN;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class pembatalanBAPemusnahanController extends Controller
{
    public function index(){
        $test = DB::table('tbtr_mstran_d')->where('mstd_nodoc', '82000656')->limit(10)->get()->toArray();

        dd($test);
        return view('BACKOFFICE/TRANSAKSI/PEMUSNAHAN.pembatalanBAPemusnahan');
    }
}
