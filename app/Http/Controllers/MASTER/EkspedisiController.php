<?php

namespace App\Http\Controllers\MASTER;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

class EkspedisiController extends Controller
{
    //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

    public function index(){
        $ekspedisi = DB::connection(Session::get('connection'))->table('tbmaster_ekspedisi')
            ->select('eks_nama')
            ->groupBy(['eks_nama'])
            ->orderBy('eks_nama')
            ->get();

        return view('MASTER.ekspedisi')->with(compact(['ekspedisi']));
    }
}
