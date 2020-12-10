<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class TemplateController extends Controller
{
    public function index(){
        return view('template');
    }

    public function dataModal(){
        $data   = DB::table('tbmaster_cabang')->orderBy('cab_kodecabang')->get()->toArray();


        return Datatables::of($data)->make(true);
    }
}
