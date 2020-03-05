<?php

namespace App\Http\Controllers\MASTER;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;


class barangController extends Controller
{
    public function index()
    {
        $plu = DB::table('tbmaster_prodmast')
            ->select('prd_prdcd')
            ->where(DB::RAW('SUBSTR(prd_prdcd,7,1)'),'=','0')
            ->orderBy('prd_prdcd')
            ->limit(1000)
            ->get();

        return view('MASTER.barang')->with(compact('plu'));
    }

    public function barang (Request $request)
    {
        $kodeplu = $request->kodeplu;

        $result = DB::table('tbmaster_prodmast')
            ->select('*')
            ->where('prd_prdcd','=',$kodeplu)
            ->get();

        return response()->json(['kodeplu'=>$kodeplu, 'data'=>$result]);

    }
}