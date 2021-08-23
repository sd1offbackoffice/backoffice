<?php

namespace App\Http\Controllers\OMI;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProsesBKLDalamKotaController extends Controller
{
    public function index(){
        return view('OMI.prosesBKLDalamKota');
    }
}
