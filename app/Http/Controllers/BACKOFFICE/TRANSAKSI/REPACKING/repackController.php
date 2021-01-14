<?php
/**
 * Created by PhpStorm.
 * User: ryan
 * Date: 1/12/2021
 * Time: 3:25 PM
 */

namespace App\Http\Controllers\BACKOFFICE\TRANSAKSI\REPACKING;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class repackController extends Controller
{
    public function index()
    {
        return view('BACKOFFICE/TRANSAKSI/REPACKING.repack');
    }

    public function getNewNmrTrn(){
        $kodeigr = $_SESSION['kdigr'];
//        $ip = LPAD(Substr(SUBSTR(:global.IP,-3),INSTR(SUBSTR(:global.IP,-3),'.')+1,3),3,'0');
        $ip =str_pad(substr(substr($_SESSION['ip'],-3),strpos(substr($_SESSION['ip'],-3),'.'),3),3,'0',STR_PAD_LEFT);


        $connect = oci_connect('SIMSMG', 'SIMSMG', '192.168.237.193:1521/SIMSMG');

        $query = oci_parse($connect, "BEGIN :ret := f_igr_get_nomor('$kodeigr','PCK',
									                       'Nomor Packing',
				                                 '$ip'||'PC',
				                                 5,
				                                 FALSE); END;");
        oci_bind_by_name($query, ':ret', $result, 32);
        oci_execute($query);


       // dd($_SESSION['ip']);
        //dd($request->getClientIps());
        return response()->json($result);
    }
}