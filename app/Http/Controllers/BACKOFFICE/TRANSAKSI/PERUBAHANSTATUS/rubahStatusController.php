<?php
namespace App\Http\Controllers\BACKOFFICE\TRANSAKSI\PERUBAHANSTATUS;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use PDF;

class rubahStatusController extends Controller
{
    public function index(){
        return view('BACKOFFICE/TRANSAKSI/PERUBAHANSTATUS.rubahStatus');
    }
}
