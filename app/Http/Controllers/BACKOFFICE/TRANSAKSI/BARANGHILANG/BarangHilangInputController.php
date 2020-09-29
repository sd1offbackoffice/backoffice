<?php

namespace App\Http\Controllers\BACKOFFICE\TRANSAKSI\BARANGHILANG;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class barangHilangInputController extends Controller
{
    public function index()
    {

        $lovTrn = DB::table('tbtr_backoffice')
            ->selectRaw("trbo_nodoc,
            CASE WHEN TRBO_FLAGDISC1='1' THEN 'Barang Baik' 
                                      ELSE 'Barang Retur' End trbo_tipe,
               CASE 
                      WHEN TRBO_FLAGDOC='*' THEN TRBO_NONOTA 
                      ELSE 'Belum Cetak Nota' END NOTA")
            ->where('trbo_typetrn', '=', 'H')
            ->where('trbo_kodeigr', '=', $_SESSION['kdigr'])
            ->whereRaw("nvl(trbo_recordid, '0') <> '1'")
            ->distinct()
            ->limit(100)
            ->get();

        $lovPlu = DB::table('tbmaster_prodmast')
            ->select('prd_deskripsipanjang', 'prd_prdcd')
            ->whereRaw("SUBSTR(PRD_PRDCD,7,1)='0'")
            ->where('prd_kodeigr', '=', $_SESSION['kdigr'])
            ->orderby('prd_deskripsipanjang')
            ->limit(100)
            ->get();

        return view('BACKOFFICE/TRANSAKSI/BARANGHILANG.barangHilangInput')->with(compact(['lovTrn', 'lovPlu']));
    }

    public function helpTrn(Request $request)
    {

        $result = DB::table('tbtr_backoffice')
            ->select('*')
            ->where('trbo_kodeigr', '=', $_SESSION['kdigr'])
            ->where('trbo_nodoc', $request->value)
            ->distinct()
            ->limit(100)
            ->get();

        return response()->json($result);
    }

    public function showData(Request $request)
    {

        $nodoc = $request->nodoc;
        $model = '';
        $dataTrn = [];
        $dataPlu = [];
        $kodeigr = $_SESSION['kdigr'];
        $ip = str_replace('.', '0', SUBSTR($_SESSION['ip'], -3));

        if (is_null($nodoc)) {
            $model = '* TAMBAH *';

            $connection = oci_connect('SIMSMG', 'SIMSMG', '192.168.237.193:1521/SIMSMG');

            $s = oci_parse($connection, "BEGIN :ret := f_igr_get_nomorstadoc('$kodeigr','NBH','Nomor Barang Hilang',
                            ' .$ip. ' || '7', 6, FALSE); END;");
            oci_bind_by_name($s, ':ret', $result, 32);
            oci_execute($s);

            $tglDoc = Carbon::now();
            $pb['trbo_nodoc'] = $result;
            $pb['trbo_tglDoc'] = $tglDoc;

        } else {

            $dataTrn = DB::table('tbtr_backoffice')
                ->select('*')
                ->where('trbo_kodeigr', '=', $kodeigr)
                ->where('trbo_nodoc', '=', $nodoc)
                ->where('trbo_typetrn', '=', 'H')
                ->orderby('trbo_seqno')
                ->limit(100)
                ->distinct()
                ->get();

            if (is_null($dataTrn)) {
                $message = 'Nomor Doc tidak ditemukan!';
                $status = 'error';
                return compact(['message', 'status']);
            }

            if ($dataTrn->trbo_flagdoc == '*'){
                $model = '* NOTA SUDAH DICETAK *';
            } else {
                $model = '* KOREKSI *';
            }

            $dataPlu = DB::table('tbmaster_prodmast')
                ->leftJoin('tbmaster_stock','prd_prdcd','=','st_prdcd')
//                ->leftJoin('tbtr_backoffice','trbo_prdcd','=','prd_prdcd')
                ->selectRaw("PRD_DESKRIPSIPENDEK,PRD_DESKRIPSIPANJANG,PRD_FRAC,PRD_UNIT,
            PRD_FLAGBKP1,PRD_KODETAG,PRD_AVGCOST,ST_AVGCOST,
				 NVL(ST_PRDCD,'XXXXXXX') ST_PRDCD,ST_SALDOAKHIR, PRD_KODESUPPLIER")
                ->where('prd_prdcd','=','$noplu')
                ->where('st_lokasi','=','01')
                ->where(DB::RAW('SUBSTR(prd_prdcd,7,1)'),'=','0')
                ->limit(100)
                ->get();

            if(is_null($dataPlu)){
                $message = 'Kode Produk tidak terdaftar!';
                $status = 'error';
                return compact(['message', 'status']);
            }

        }

//        $count = $result->count();
        return response()->json();
    }

    public function showDataPlu(Request $request){

        $noplu = $request->noplu;

        $dataPlu = DB::table('tbmaster_prodmast')
            ->leftJoin('tbmaster_stock','prd_prdcd','=','st_prdcd')
            ->leftJoin('tbtr_backoffice','trbo_prdcd','=','prd_prdcd')
            ->selectRaw("PRD_DESKRIPSIPENDEK,PRD_DESKRIPSIPANJANG,PRD_FRAC,PRD_UNIT,
            PRD_FLAGBKP1,PRD_KODETAG,PRD_AVGCOST,ST_AVGCOST,
				 NVL(ST_PRDCD,'XXXXXXX') ST_PRDCD,ST_SALDOAKHIR, PRD_KODESUPPLIER")
            ->where('prd_prdcd','=','$noplu')
            ->where('st_lokasi','=','01')
            ->where(DB::RAW('SUBSTR(prd_prdcd,7,1)'),'=','0')
            ->limit(100)
            ->get();

        return response()->json($dataPlu);
    }

//    public function getNomorTrn(){
//
//        $kodeigr = $_SESSION['kdigr'];
//
//        $ip = str_replace('.','0', SUBSTR($_SESSION['ip'],-3));
//
//        $connection = oci_connect('SIMSMG', 'SIMSMG', '192.168.237.193:1521/SIMSMG');
//
//        $s = oci_parse($connection, "BEGIN :ret := f_igr_get_nomorstadoc('$kodeigr','NBH','Nomor Barang Hilang',
//                            '.$ip.' || '7', 6, FALSE); END;");
//        oci_bind_by_name($s, ':ret', $result, 32);
//        oci_execute($s);
//
//        return response()->json($result);
//    }

    public function deleteDoc(Request $request){


        return response()->json();
    }

}
