<?php

namespace App\Http\Controllers\BACKOFFICE\PKM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class FaktorPKMTokoController extends Controller
{
    public function index()
    {
        $datas = DB::connection(Session::get('connection'))->table('tbmaster_pkmplus')
        ->select("PKMP_KODEIGR",
        "PKMP_PRDCD",
        "PKMP_MPLUSI",
        "PKMP_MPLUSO",
        DB::raw("PKMP_MPLUSI + PKMP_MPLUSO AS PKMP_MPLUS"))
        ->limit(100)
        ->where('PKMP_MPLUSO','>','0')
        ->get();

        return view('BACKOFFICE.PKM.faktor-pkm-toko',compact('datas'));
    }

    public function getDataTableM()
    {
        $data = DB::connection(Session::get('connection'))->table('tbmaster_pkmplus')
        ->select("PKMP_KODEIGR",
        "PKMP_PRDCD",
        "PKMP_MPLUSI",
        "PKMP_MPLUSO",
        DB::raw("PKMP_MPLUSI + PKMP_MPLUSO AS PKMP_MPLUS"))
        ->orderBy('PKMP_PRDCD','ASC')
        ->get();

        return DataTables::of($data)->make(true);
    }
}
