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
        oci_bind_by_name($query, ':ret', $noDoc, 32);
        oci_execute($query);

        $query = oci_parse($connect, "BEGIN :ret := f_igr_get_nomorstadoc ('$kodeigr',
									                       'RPK',
									                       'Refferensi Nomor Packing',
				                                 '$ip'||'RP',
				                                 5,
	                                       FALSE); END;");
        oci_bind_by_name($query, ':ret', $noReff, 32);
        oci_execute($query);


       // dd($_SESSION['ip']);
        //dd($request->getClientIps());
        return response()->json(['noDoc' => $noDoc, 'noReff' => $noReff, 'model' => '* TAMBAH *']);
    }

    public function chooseTrn(Request $request){
        $kode = $request->kode;
        $kodeigr = $_SESSION['kdigr'];

//        $cursor = DB::select("
//            SELECT * FROM tbTr_BackOffice
//		             WHERE TRBO_KodeIGR = '.$kodeigr'
//		                   AND TRBO_NODOC = '$kode'
//		                   AND TRBO_TYPETRN = 'P'
//		             ORDER BY TRBO_SEQNO
//        ");
        $cursor = DB::table('tbTr_BackOffice')
            ->selectRaw('TRBO_NODOC')
            ->selectRaw('TRBO_TGLDOC')
            ->selectRaw('trbo_noreff')
            ->selectRaw('trbo_tglreff')
            ->selectRaw('trbo_keterangan')
            ->selectRaw('trbo_flagdisc3')
            ->selectRaw('trbo_flagdisc2')
            ->selectRaw('trbo_flagdoc')
            ->selectRaw("CASE WHEN TRBO_FLAGDOC='*' THEN TRBO_NONOTA ELSE 'Belum Cetak Nota' END NOTA")

            ->selectRaw('trbo_flagdisc1')
            ->selectRaw('trbo_prdcd')
            ->selectRaw('PRD_DESKRIPSIPENDEK')
            ->selectRaw('PRD_DESKRIPSIPANJANG')
            ->selectRaw('PRD_FRAC')
            ->selectRaw('PRD_UNIT')
            ->selectRaw('PRD_KODETAG')
            ->selectRaw('TRBO_QTY')
            ->selectRaw('ST_SALDOAKHIR')
            ->selectRaw('PRD_FLAGBKP1')
            ->selectRaw('trbo_hrgsatuan')
            ->selectRaw('trbo_gross')
            ->selectRaw('trbo_ppnrph')

            ->LeftJoin('TBMASTER_PRODMAST',function($join){
                $join->on('TRBO_PRDCD','PRD_PRDCD');
                $join->on('TRBO_KODEIGR','PRD_KODEIGR');
            })

            ->LeftJoin('TBMASTER_STOCK',function($join){
                $join->on('PRD_PRDCD','ST_PRDCD');
                $join->on('PRD_KODEIGR','ST_KODEIGR');
            })

            ->where('ST_LOKASI','=','01')
            ->where('TRBO_TYPETRN','=','P')
            ->where('TRBO_NODOC','=', $kode)
            ->where('TRBO_KodeIGR','=', $kodeigr)
            ->orderBy('TRBO_SEQNO')
            ->get();

        return response()->json($cursor);

    }

    public function getNmrTrn(Request $request){
        $search = $request->val;

        $datas = DB::table('tbTr_BackOffice')
            ->selectRaw('distinct TRBO_NODOC as TRBO_NODOC')
            ->selectRaw('TRBO_TGLDOC')
            ->selectRaw("CASE WHEN TRBO_FLAGDOC='*' THEN TRBO_NONOTA ELSE 'Belum Cetak Nota' END NOTA")
            ->where('TRBO_TYPETRN','=','P')
            ->where('TRBO_NODOC','LIKE', '%'.$search.'%')
            ->orderByDesc('TRBO_NODOC')
            ->limit(100)
            ->get();

        return response()->json($datas);

    }

    public function getPlu(Request $request){
        $kodeigr = $_SESSION['kdigr'];
        $search = $request->val;

        $datas = DB::table('TBMASTER_PRODMAST')
            ->selectRaw('PRD_DESKRIPSIPANJANG')
            ->selectRaw('PRD_PRDCD')
            ->selectRaw("PRD_UNIT||'/'||TO_CHAR(PRD_FRAC) SATUAN")

            ->whereRaw("SUBSTR(PRD_PRDCD,7,1)='0'")
            ->whereRaw("nvl(prd_recordid,'9')<>'1'")

            ->LeftJoin('TBMASTER_STOCK',function($join){
                $join->on('PRD_PRDCD','ST_PRDCD');
                $join->on('PRD_KODEIGR','PRD_KODEIGR');
            })
            ->where('ST_LOKASI','=','01')

            ->whereRaw("(prd_deskripsipanjang LIKE '%". $search."%' or prd_prdcd LIKE '%". $search."%')")
            ->where('prd_kodeigr', '=', $kodeigr)
            ->orderBy('prd_deskripsipanjang')
            ->limit(100)->get();

        return response()->json($datas);
    }

    public function choosePlu(Request $request){
        $kodeigr = $_SESSION['kdigr'];
        $kode = $request->kode;

//        $cursor = DB::select("
//            SELECT PRD_PRDCD,PRD_DESKRIPSIPENDEK,PRD_DESKRIPSIPANJANG,PRD_FRAC,PRD_UNIT,PRD_KODETAG,PRD_AVGCOST,nvl(ST_AVGCOST,0) lcostst,PRD_FLAGBKP1,nvl(ST_SALDOAKHIR,0) trbo_stokqty
//            FROM TBMASTER_PRODMAST,TBMASTER_STOCK
//            WHERE PRD_KODEIGR = ST_KODEIGR(+) AND
//                      PRD_PRDCD = ST_PRDCD(+) AND
//                      PRD_KODEIGR = '$kodeigr' AND
//                      ST_LOKASI(+)='01' AND PRD_PRDCD='$kode'
//        ");

        $cursor = DB::table('TBMASTER_PRODMAST')
            ->selectRaw('PRD_DESKRIPSIPENDEK')
            ->selectRaw('PRD_DESKRIPSIPANJANG')
            ->selectRaw('PRD_FRAC')
            ->selectRaw('PRD_UNIT')
            ->selectRaw('PRD_KODETAG')
            ->selectRaw('PRD_AVGCOST')
            ->selectRaw('nvl(ST_AVGCOST,0) lcostst')
            ->selectRaw('PRD_FLAGBKP1')
            ->selectRaw('nvl(ST_SALDOAKHIR,0) trbo_stokqty')

            ->LeftJoin('TBMASTER_STOCK',function($join){
                $join->on('PRD_PRDCD','ST_PRDCD');
                $join->on('PRD_KODEIGR','PRD_KODEIGR');
            })

            ->where('PRD_PRDCD','=',$kode)
            ->where('PRD_KODEIGR','=',$kodeigr)
            ->where('ST_LOKASI','=','01')

            ->first();
        if (!$cursor){
            $msg = "Kode Produk ". $kode. " Tidak Terdaftar!";

            return response()->json(['kode' => 0, 'msg' => $msg, 'data' => '']);
        }
        else{
            return response()->json(['kode' => 1, 'msg' => '', 'data' => $cursor]);
        }
    }
}