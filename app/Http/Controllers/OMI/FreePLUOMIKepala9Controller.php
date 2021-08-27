<?php

namespace App\Http\Controllers\OMI;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use PDF;
use Yajra\DataTables\DataTables;
use File;

class FreePLUOMIKepala9Controller extends Controller
{
    public function index(){
        return view('OMI.freepluomikepala9');
    }

    public function getLovNodoc(Request $request){
        $where = "rom_nodokumen like '%".$request->search."%'";

        $data = DB::table('tbtr_returomi')
            ->selectRaw("rom_nodokumen nodoc,to_char(rom_tgldokumen, 'dd/mm/yyyy') tgl, rom_tgldokumen")
            ->where('rom_kodeigr','=',$_SESSION['kdigr'])
            ->whereNotNull('rom_nodokumen')
            ->whereRaw("NVL(rom_recordid,'0') <> '1'")
            ->whereRaw($where)
            ->orderBy('rom_tgldokumen','desc')
            ->orderBy('rom_nodokumen','desc')
            ->distinct()
            ->limit($request->search == '' ? 100 : 0)
            ->get();

        return DataTables::of($data)->make(true);
    }

    public function getData(Request $request){
        $data = DB::table('tbtr_returomi')
            ->join('tbmaster_prodmast','prd_prdcd','=','rom_prdcd')
            ->selectRaw("rom_prdcd, rom_hrg, rom_ttl, rom_qty, rom_qtyrealisasi, rom_qtyselisih, rom_qtymlj, rom_qtytlj, rom_noreferensi, to_char(rom_tglreferensi,'dd/mm/yyyy') rom_tglreferensi, rom_member, rom_kodetoko, rom_statusdata")
            ->where('rom_nodokumen','=',$request->nodokumen)
            ->orderBy('rom_prdcd','asc')
            ->get();

        foreach($data as $d){
            if($d->rom_statusdata == '2' && $d->rom_qtyrealisasi == '0')
                $d->rom_qtyrealisasi = $d->rom_qty;

            $d->rom_hrg = round($d->rom_hrg);
            $d->rom_ttl = round($d->rom_ttl);
        }

        return DataTables::of($data)->make(true);
    }
}
