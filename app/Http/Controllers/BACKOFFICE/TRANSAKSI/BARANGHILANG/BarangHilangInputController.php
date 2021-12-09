<?php

namespace App\Http\Controllers\BACKOFFICE\TRANSAKSI\BARANGHILANG;

use App\Http\Controllers\Auth\loginController;
use FontLib\WOFF\TableDirectoryEntry;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class barangHilangInputController extends Controller
{
    public function index()
    {
        return view('BACKOFFICE.TRANSAKSI.BARANGHILANG.BarangHilangInput');
    }

    public function lov_trn(Request $request)
    {
        $search = $request->search;

        $result = DB::connection($_SESSION['connection'])->table('tbtr_backoffice')
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
        $search = strtoupper($request->search);

        $result = DB::connection($_SESSION['connection'])->table('tbmaster_prodmast')
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

        $result = DB::connection($_SESSION['connection'])->table('tbtr_backoffice')
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

        $result = DB::connection($_SESSION['connection'])->select("SELECT PRD_DESKRIPSIPENDEK,PRD_DESKRIPSIPANJANG,PRD_FRAC,PRD_UNIT,PRD_KODETAG,PRD_FLAGBKP1, PRD_AVGCOST as hrgsatuan,
                ST_AVGCOST,NVL(ST_PRDCD,'XXXXXXX') as ST_PRDCD,Nvl(ST_SALDOAKHIR,0) as ST_SALDOAKHIR, PRD_KODESUPPLIER
                FROM TBMASTER_PRODMAST tp
                LEFT JOIN TBMASTER_STOCK ts ON prd_prdcd = st_prdcd and st_lokasi = '01'
                where  PRD_PRDCD = '$noplu'");

        if (!$result) {
            $message = "Kode ".$noplu." Tidak Terdaftar";

            return response()->json(['noplu' => 0, 'message' => $message, 'data' => '']);
        } else if ($result[0]->st_prdcd == 'XXXXXXX') {

            $message = "Plu ".$noplu." Belum Melakukan Perubahan Status";

            return response()->json(['noplu' => 0, 'message' => $message, 'data' => $result]);
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
            }
            return response()->json(['noplu' => 1, 'message' => '', 'data' => $result, 'hrgsatuan' => $hrgsatuan, 'avgcost' => $avgcost]);
        }
    }

    public function nmrBaruTrn(){

        $kodeigr = $_SESSION['kdigr'];
        $ip = str_replace('.', '0', SUBSTR($_SESSION['ip'], -3));

        $c = loginController::getConnectionProcedure();

        $s = oci_parse($c, "BEGIN :ret := f_igr_get_nomorstadoc('$kodeigr','NBH','Nomor Barang Hilang',
                            " .$ip. " || '7', 6, FALSE); END;");
        oci_bind_by_name($s, ':ret', $r, 32);
        oci_execute($s);

        return response()->json($r);
    }

    public function saveDoc(Request $request){
        $kodeigr = $_SESSION['kdigr'];
        $nodoc  = $request->nodoc;
        $data = $request->data;
        $date = date('Y-m-d', strtotime($request->date));
        $userid = $_SESSION['usid'];
        $today  = date('Y-m-d H:i:s');

        //get new no trn
        $ip = str_replace('.', '0', SUBSTR($_SESSION['ip'], -3));

        $c = loginController::getConnectionProcedure();

        $s = oci_parse($c, "BEGIN :ret := f_igr_get_nomorstadoc('$kodeigr','NBH','Nomor Barang Hilang',
                            " .$ip. " || '7', 6, TRUE); END;");
        oci_bind_by_name($s, ':ret', $docNo, 32);
        oci_execute($s);

        $getDoc = DB::connection($_SESSION['connection'])->table('tbtr_backoffice')->where('trbo_nodoc', $nodoc)->first();


        if($getDoc){
            DB::connection($_SESSION['connection'])->table('tbtr_backoffice')->where('trbo_nodoc', $nodoc)->delete();

            for ($i = 1; $i < sizeof($data); $i++){
                $temp = $data[$i];

                $prodmast = DB::connection($_SESSION['connection'])->table('tbmaster_prodmast')
                    ->where('prd_kodeigr', $kodeigr)
                    ->where('prd_prdcd', $temp['plu'])
                    ->first();
//update
                DB::connection($_SESSION['connection'])->table('tbtr_backoffice')
                    ->insert([
                        'trbo_kodeigr' => $kodeigr, 'trbo_recordid' => '', 'trbo_typetrn' => 'H','trbo_nodoc' => $getDoc->trbo_nodoc,
                        'trbo_tgldoc' => $date, 'trbo_noreff' => '', 'trbo_tglreff' => '', 'trbo_nopo' => '', 'trbo_tglpo' => '',
                        'trbo_nofaktur' => '', 'trbo_tglfaktur' => '', 'trbo_istype' => '', 'trbo_invno' => '', 'trbo_tglinv' => '',
                        'trbo_nott' => '', 'trbo_tgltt' => '', 'trbo_kodesupplier' => '', 'trbo_kodeigr2' => '', 'trbo_seqno' => $i,
                        'trbo_prdcd' => $temp['plu'], 'trbo_qty' => $temp['qty'], 'trbo_qtybonus1' => '', 'trbo_qtybonus2' => '',
                        'trbo_hrgsatuan' => $temp['hrgsatuan'], 'trbo_persendisc1' => '', 'trbo_rphdisc1' => '', 'trbo_flagdisc1' => '1',
                        'trbo_persendisc2' => '', 'trbo_rphdisc2' => '', 'trbo_flagdisc2' => '', 'trbo_persendisc2ii' => '',
                        'trbo_rphdisc2ii' => '', 'trbo_persendisc3' => '', 'trbo_rphdisc3' => '', 'trbo_flagdisc3' => '', 'trbo_persendisc4' => '',
                        'trbo_rphdisc4' => '', 'trbo_flagdisc4' => '', 'trbo_dis4cp' => '', 'trbo_dis4cr' => '', 'trbo_dis4rp' => '',
                        'trbo_dis4jp' => '', 'trbo_dis4jr' => '', 'trbo_gross' => $temp['gross'], 'trbo_discrph' => '', 'trbo_ppnrph' => '0',
                        'trbo_ppnbmrph' => '', 'trbo_averagecost' => $prodmast->prd_avgcost, 'trbo_oldcost' => '', 'trbo_posqty' => '',
                        'trbo_keterangan' => strtoupper($temp['keterangan']), 'trbo_furgnt' => '', 'trbo_gdg' => '', 'trbo_flagdoc' => '0',
                        'trbo_create_by' => $getDoc->trbo_create_by, 'trbo_create_dt' => $getDoc->trbo_create_dt, 'trbo_modify_by' => $userid,
                        'trbo_modify_dt' => $today, 'trbo_stokqty' => '', 'trbo_loc' => '', 'trbo_notaok' => '', 'trbo_nonota' => '',
                        'trbo_tglnota' => ''
                    ]);
            }

            return response()->json(['kode' => 1, 'msg' => $getDoc->trbo_nodoc]);
        } else {
            for ($i = 1; $i < sizeof($data); $i++) {
                $temp = $data[$i];

                $prodmast = DB::connection($_SESSION['connection'])->table('tbmaster_prodmast')
                    ->where('prd_kodeigr', $kodeigr)
                    ->where('prd_prdcd', $temp['plu'])
                    ->first();

                DB::connection($_SESSION['connection'])->table('tbtr_backoffice')
                    ->insert([
                        'trbo_kodeigr' => $kodeigr, 'trbo_recordid' => '', 'trbo_typetrn' => 'H','trbo_nodoc' => $docNo,
                        'trbo_tgldoc' => $date, 'trbo_noreff' => '', 'trbo_tglreff' => '', 'trbo_nopo' => '', 'trbo_tglpo' => '',
                        'trbo_nofaktur' => '', 'trbo_tglfaktur' => '', 'trbo_istype' => '', 'trbo_invno' => '', 'trbo_tglinv' => '',
                        'trbo_nott' => '', 'trbo_tgltt' => '', 'trbo_kodesupplier' => '', 'trbo_kodeigr2' => '', 'trbo_seqno' => $i,
                        'trbo_prdcd' => $temp['plu'], 'trbo_qty' => $temp['qty'], 'trbo_qtybonus1' => '', 'trbo_qtybonus2' => '',
                        'trbo_hrgsatuan' => $temp['hrgsatuan'], 'trbo_persendisc1' => '', 'trbo_rphdisc1' => '', 'trbo_flagdisc1' => '1',
                        'trbo_persendisc2' => '', 'trbo_rphdisc2' => '', 'trbo_flagdisc2' => '', 'trbo_persendisc2ii' => '',
                        'trbo_rphdisc2ii' => '', 'trbo_persendisc3' => '', 'trbo_rphdisc3' => '', 'trbo_flagdisc3' => '', 'trbo_persendisc4' => '',
                        'trbo_rphdisc4' => '', 'trbo_flagdisc4' => '', 'trbo_dis4cp' => '', 'trbo_dis4cr' => '', 'trbo_dis4rp' => '',
                        'trbo_dis4jp' => '', 'trbo_dis4jr' => '', 'trbo_gross' => $temp['gross'], 'trbo_discrph' => '', 'trbo_ppnrph' => '0',
                        'trbo_ppnbmrph' => '', 'trbo_averagecost' => $prodmast->prd_avgcost, 'trbo_oldcost' => '', 'trbo_posqty' => '',
                        'trbo_keterangan' => strtoupper($temp['keterangan']), 'trbo_furgnt' => '', 'trbo_gdg' => '', 'trbo_flagdoc' => '0',
                        'trbo_create_by' => $userid, 'trbo_create_dt' => $today, 'trbo_stokqty' => '', 'trbo_loc' => '', 'trbo_notaok' => '',
                        'trbo_nonota' => '', 'trbo_tglnota' => ''
                    ]);
            }
            return response()->json(['kode' => 1, 'msg' => $docNo]);
        }
    }

    public function deleteDoc(Request $request){
        $nodoc = $request->nodoc;

        DB::connection($_SESSION['connection'])->table('tbtr_backoffice')
            ->where('trbo_nodoc', $nodoc)
            ->where('trbo_typetrn','=','H')
            ->delete();

        return response()->json(['kode' => 1, 'msg' => "Dokumen Berhasil dihapus!"]);
    }

}


