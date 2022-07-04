<?php

namespace App\Http\Controllers\BACKOFFICE\TRANSAKSI\PENERIMAAN;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SJEkspedisiController extends Controller
{
    public function index()
    {
        return view('BACKOFFICE.TRANSAKSI.PENERIMAAN.SJEkspedisi');
    }
}
