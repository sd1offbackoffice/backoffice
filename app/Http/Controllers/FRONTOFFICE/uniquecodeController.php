<?php
/**
 * Created by PhpStorm.
 * User: ryan
 * Date: 23/08/2021
 * Time: 2:15 PM
 */

namespace App\Http\Controllers\FRONTOFFICE;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use PDF;
use DateTime;
use Yajra\DataTables\DataTables;

class uniquecodeController extends Controller
{

    public function index()
    {
        return view('FRONTOFFICE.uniquecode');
    }

}
