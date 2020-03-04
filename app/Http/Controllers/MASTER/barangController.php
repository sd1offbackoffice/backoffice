<?php

namespace App\Http\Controllers\MASTER;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;


class barangController extends Controller
{
    public function index()
    {


        return view('MASTER.barang');
    }
}