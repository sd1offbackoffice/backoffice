<?php

namespace App\Http\Controllers\BACKOFFICE\PKM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FaktorPKMTokoController extends Controller
{
    public function index()
    {
        return view('BACKOFFICE.PKM.faktor-pkm-toko');
    }
}
