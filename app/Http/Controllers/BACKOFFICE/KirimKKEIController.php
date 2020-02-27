<?php

namespace App\Http\Controllers\BACKOFFICE;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class KirimKKEIController extends Controller
{
    //

    public function index(){
        return view('BACKOFFICE.kirimKKEI');
    }

}
