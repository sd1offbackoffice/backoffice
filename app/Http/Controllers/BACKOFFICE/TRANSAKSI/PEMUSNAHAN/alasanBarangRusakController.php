<?php

namespace App\Http\Controllers\BACKOFFICE\TRANSAKSI\PEMUSNAHAN;

use App\Http\Controllers\Auth\loginController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller; use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class alasanBarangRusakController extends Controller
{
    //

    public function index(){

        $data = DB::connection(Session::get('connection'))->table('tbmaster_keteranganbarangrusak')
            ->select('kbr_tipeid','kbr_tipe','kbr_flagmanual')
            ->where('kbr_tipeid','!=','99')
            ->orderBy('kbr_tipeid')
            ->get();

        return view('BACKOFFICE.TRANSAKSI.PEMUSNAHAN.alasan-barang-rusak')->with(compact(['data']));
    }


}