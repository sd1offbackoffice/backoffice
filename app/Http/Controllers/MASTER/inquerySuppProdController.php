<?php

namespace App\Http\Controllers\MASTER;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;


class inquerySuppProdController extends Controller
{
    public function index(){

       //dd($result);

        return view('MASTER.inquerySuppProd');
    }


}
