<?php

namespace App\Http\Controllers\BACKOFFICE;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class KKEIController extends Controller
{
    //

    public function index(){
        return view('BACKOFFICE.KKEI');
    }


}
