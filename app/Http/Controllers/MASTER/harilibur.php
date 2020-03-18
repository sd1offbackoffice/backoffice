<?php

namespace App\Http\Controllers\MASTER;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class hariliburController extends Controller
{
    public function index(){

        $harilibur = DB::table('tbmaster_harilibur')
            ->select('lib_tgllibur', 'lib_keteranganlibur')
            //->whereYear('lib_tgllibur', date("Y", strtotime("now")))
            //->limit(10)
            ->orderBy('lib_tgllibur')
            ->get();

        return view('MASTER.harilibur')->with('harilibur',$harilibur);
    }

    public function insert(Request $request)
    {
        $tgllibur = $request->input('tgllibur');
        $ketlibur = $request->input('ketlibur');

        if ($tgllibur != '' && $ketlibur != '') {
            $data = array('tgllibur' => $tgllibur, 'ketlibur' => $ketlibur);

            $value = DB::table('tbmaster_harilibur')
                ->where('lib_tgllibur', $data['tgllibur'])
                ->where('lib_keteranganlibur', $data['ketlibur'])
                ->get();

            if ($value->count() == 0) {
                $insertData = DB::table('tbmaster_harilibur')->insertGetId($data);
                return $insertData;
            } else {
                return 0;
            }
        }

        return response()->json(['tgllibur' => $tgllibur, 'ketlibur' => $ketlibur]);
    }


        public function delete(Request $request){

        }

}
