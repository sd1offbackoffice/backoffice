<?php

namespace App\Http\Controllers\MASTER;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class hariliburController extends Controller
{
    public function index(){
        return view('MASTER.harilibur');
    }
}
