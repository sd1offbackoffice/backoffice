<?php

namespace App\Http\Controllers\MASTER;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;


class perusahaanController extends Controller
{
    public function index(){
        $result = DB::TABLE('tbmaster_perusahaan')->SELECT("*")->First();
        return view('MASTER.perusahaan')->with('result',$result);
    }
}
