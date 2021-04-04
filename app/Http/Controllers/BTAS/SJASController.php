<?php

namespace App\Http\Controllers\BTAS;

use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;
use PDF;
use Yajra\DataTables\DataTables;

class SJASController extends Controller
{
    public function index(){
        return view('BTAS.sjas');
    }
}
