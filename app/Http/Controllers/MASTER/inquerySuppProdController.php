<?php

namespace App\Http\Controllers\MASTER;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;


class inquerySuppProdController extends Controller
{
    public function index()
    {
        return view('MASTER.inquerySuppProd');
    }

    public function suppProd(Request $request)
    {
        $kodeplu = $request->kodeplu;

        $result = DB::table('tbmaster_prodmast')
            ->select('prd_deskripsipanjang')
            ->where('prd_prdcd', '=', '$kodeplu')
            ->get();

        return response()
            ->json(['kodeplu' => $kodeplu, 'data' => $result]);
    }
}
