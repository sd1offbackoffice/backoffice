<?php

namespace App\Http\Controllers\BACKOFFICE\TRANSAKSI\BARANGHILANG;

use FontLib\WOFF\TableDirectoryEntry;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class barangHilangInputController extends Controller
{
    public function index()
    {
        return view('BACKOFFICE/TRANSAKSI/BARANGHILANG.BarangHilangInput');
    }

    public function lov_trn(Request $request)
    {
        $search = $request->value;

        $result = DB::table('tbtr_backoffice')
            ->selectRaw("trbo_nodoc,
               CASE WHEN TRBO_FLAGDISC1='1' THEN 'Barang Baik' 
                                      ELSE 'Barang Retur' End trbo_tipe,
               CASE 
                      WHEN TRBO_FLAGDOC='*' THEN TRBO_NONOTA 
                      ELSE 'Belum Cetak Nota' END NOTA")
            ->where('trbo_typetrn', '=', 'H')
            ->whereRaw("nvl(trbo_recordid,'0') <> '1'")
            ->where('trbo_nodoc', 'LIKE', '%' . $search . '%')
            ->orderBy('trbo_nodoc')
            ->distinct()
            ->limit(100)
            ->get();

        return response()->json($result);
    }

    public function lov_plu(Request $request)
    {
        $search = $request->value;

        $result = DB::table('tbmaster_prodmast')
            ->select('prd_prdcd', 'prd_deskripsipanjang')
            ->whereRaw("SUBSTR(PRD_PRDCD,7,1)='0'")
            ->whereRaw("nvl(prd_recordid,'9')<>'1'")
            ->whereRaw("(prd_deskripsipanjang LIKE '%". $search."%' or prd_prdcd LIKE '%". $search."%')")
            ->orderBy('prd_deskripsipanjang')
            ->limit(100)->get();

        return response()->json($result);
    }

    public function showTrn(Request $request){
        $nodoc = $request->nodoc;

        $result = DB::table('tbtr_backoffice')
            ->leftJoin('tbmaster_prodmast', 'trbo_prdcd', '=', 'prd_prdcd')
//            ->leftJoin('tbmaster_stock','trbo_prdcd','=','st_prdcd')
            ->selectRaw("trbo_nodoc,
               CASE WHEN TRBO_FLAGDISC1='1' THEN 'Barang Baik'
                                      ELSE 'Barang Retur' End trbo_tipe,
               CASE
                      WHEN TRBO_FLAGDOC='*' THEN TRBO_NONOTA
                      ELSE 'Belum Cetak Nota' END NOTA")
            ->selectRaw('trbo_tgldoc')
            ->selectRaw('trbo_typetrn')
            ->selectRaw('trbo_prdcd')
            ->selectRaw('prd_deskripsipendek')
            ->selectRaw('prd_kodetag')
            ->selectRaw("prd_flagbkp1")
            ->selectRaw('trbo_qty')
            ->selectRaw("nvl(trbo_stokqty, '0') as trbo_stokqty")
            ->selectRaw('trbo_hrgsatuan')
            ->selectRaw('prd_frac')
            ->selectRaw('prd_unit')
            ->selectRaw('TRUNC(trbo_qty/prd_frac) as QTYCTN')
            ->selectRaw('MOD(trbo_qty, prd_frac) as QTNPCS')
            ->selectRaw('trbo_gross')
            ->selectRaw('trbo_keterangan')
            ->selectRaw('prd_deskripsipanjang')
            ->selectRaw('trbo_averagecost')
            ->selectRaw("trbo_ppnrph")
//            ->selectRaw("st_saldoakhir as stock")
//            ->selectRaw("SUM(trbo_gross) as totalgross")
            ->where('TRBO_TYPETRN', '=', 'H')
            ->where('TRBO_NODOC', '=', $nodoc)
            ->orderBy('TRBO_SEQNO')
            ->get();

        return response()->json($result);
    }

    public function showPlu(Request $request){
        $noplu = $request->noplu;
        $hrgsatuan = '';
        $avgcost = '';
        $ppn = '';
        $trim = 0;

        $result = DB::Table('tbmaster_prodmast')
            ->leftJoin('tbmaster_stock', 'prd_prdcd', '=', 'st_prdcd')
            ->selectRaw("PRD_DESKRIPSIPENDEK")
            ->selectRaw("PRD_DESKRIPSIPANJANG")
            ->selectRaw("NVL(PRD_FRAC,1) as PRD_FRAC")
            ->selectRaw("PRD_UNIT")
            ->selectRaw("PRD_FLAGBKP1")
            ->selectRaw("PRD_KODETAG")
            ->selectRaw("PRD_AVGCOST as hrgsatuan")
            ->selectRaw("ST_AVGCOST")
            ->selectRaw("NVL(ST_PRDCD,'XXXXXXX') ST_PRDCD")
            ->selectRaw("ST_SALDOAKHIR")
            ->selectRaw("PRD_KODESUPPLIER")
            ->where('st_lokasi', '=', '01')
            ->where('prd_prdcd', '=', $noplu)
            ->get();

        if (is_null($result)) {
            $message = "Kode Produk Tidak Terdaftar!";
            $status = 'error';
            return compact(['message', 'status']);
        }

        if ($result[0]->st_prdcd == 'XXXXXXX') {
            $message = "Plu Belum Melakukan Perubahan Status!";
            return response()->json(['message' => $message, 'data' => $result]);

        } else {
            if (is_null($result[0]->st_avgcost) || $result[0]->st_avgcost == 0) {
                $hrgsatuan = $result[0]->prd_avgcost;
                $avgcost = $result[0]->prd_avgcost;

            } else {
                if ($result[0]->prd_unit == 'KG') {
                    $trim = $result[0]->prd_frac / 1000;
                } else {
                    $trim = $result[0]->prd_frac;
                }
                $hrgsatuan = $result[0]->st_avgcost * $trim;
                $avgcost = $result[0]->st_avgcost * $trim;

                return response()->json(['message' => '', 'result' => $result, 'hrgsatuan' => $hrgsatuan, 'avgcost' => $avgcost]);
            }

        }
    }

    public function nmrBaruTrn(){

        $kodeigr = $_SESSION['kdigr'];
        $ip = str_replace('.', '0', SUBSTR($_SESSION['ip'], -3));

        $c = oci_connect('SIMSMG', 'SIMSMG', '192.168.237.193:1521/SIMSMG');

        $s = oci_parse($c, "BEGIN :ret := f_igr_get_nomorstadoc('$kodeigr','NBH','Nomor Barang Hilang',
                            " .$ip. " || '7', 6, FALSE); END;");
        oci_bind_by_name($s, ':ret', $r, 32);
        oci_execute($s);

        return response()->json($r);
    }

    public function saveDoc(){

    }

    public function delDoc(){

    }

}


