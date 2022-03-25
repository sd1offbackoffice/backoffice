<?php

namespace App\Http\Controllers\BACKOFFICE;

use App\Http\Controllers\Auth\loginController;
use FontLib\WOFF\TableDirectoryEntry;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Yajra\DataTables\DataTables;

class PBPerishableController extends Controller
{
    public function index()
    {
        return view('BACKOFFICE.PBPerishable');
    }

    public function lov_trn(Request $request)
    {
        $search = $request->search;

        $result = DB::connection(Session::get('connection'))->table('tbtr_pb_perishable')
            ->selectRaw("pbp_nopb, pbp_createdt, pbp_modifydt, pbp_tglpb")
            ->whereRaw("nvl(pbp_recordid,'_') <> '1'")
            ->where('pbp_nopb', 'LIKE', '%' . $search . '%')
            ->orderBy('pbp_nopb')
            ->distinct()
            ->limit(100)
            ->get();

        return response()->json($result);
    }

    public function lov_plu(Request $request)
    {
        $search = strtoupper($request->search);

        $result = DB::connection(Session::get('connection'))->table('tbmaster_prodmast')
            ->select('prd_prdcd', 'prd_deskripsipanjang')
            ->whereRaw("SUBSTR(PRD_PRDCD,7,1)='0'")
            ->whereRaw("nvl(prd_recordid,'9')<>'1'")
            ->whereRaw("(prd_deskripsipanjang LIKE '%". $search."%' or prd_prdcd LIKE '%". $search."%')")
            ->orderBy('prd_deskripsipanjang')
            ->limit(100)->get();

        return response()->json($result);
    }

    public function showTrn(Request $request){
        $nopb = $request->nopb;
        $kodesupplier = $request->kodesupplier;

        $result = DB::connection(Session::get('connection'))->table('tbtr_pb_perishable')
            ->leftJoin('tbmaster_prodmast', 'pbp_prdcd', '=', 'prd_prdcd')
//            ->leftJoin('tbmaster_stock','pbp_prdcd','=','st_prdcd')
            ->selectRaw('pbp_nopb')
            ->selectRaw('pbp_tglpb')
            ->selectRaw('pbp_prdcd')
            ->selectRaw('pbp_pkm')
            ->selectRaw('pbp_isictn')
            ->selectRaw('pbp_stock')
            ->selectRaw('pbp_poout')
            ->selectRaw('pbp_pbout')
            ->selectRaw('pbp_mindisplay')
            ->selectRaw('pbp_minorder')
            ->selectRaw('pbp_dimensi')
            ->selectRaw('pbp_kubikase')
            ->selectRaw('prd_deskripsipanjang')
            ->selectRaw('prd_kodetag')
            ->selectRaw("prd_flagbkp1")
            ->selectRaw('pbp_qtypb')
            ->selectRaw('prd_frac')
            ->selectRaw('prd_unit')
            ->select("SELECT SUM PBP_KUBIKASE AS TOTALKUBIK FROM TBTR_PB_PERISHABLE WHERE PBP_KODESUPPLIER = $kodesupplier")
            ->selectRaw('TRUNC(trbo_qty/prd_frac) as QTYCTN')
            ->selectRaw('MOD(trbo_qty, prd_frac) as QTNPCS')
            ->selectRaw('trbo_gross')
            ->selectRaw('trbo_keterangan')
            ->selectRaw('prd_deskripsipanjang')
            ->selectRaw('pbp_avgsales')
            ->where('PBP_NOPB', '=', $nopb)
            ->whereNull('pbp_recordid')
            ->orderBy('PBP_NOPB')
            ->get();

        return response()->json($result);
    }

    public function showPlu(Request $request){
        $noplu = $request->noplu;
        $hrgsatuan = '';
        $avgcost = '';
        $ppn = '';
        $trim = 0;

        $result = DB::connection(Session::get('connection'))->select("SELECT PRD_DESKRIPSIPENDEK,PRD_DESKRIPSIPANJANG,PRD_FRAC,PRD_UNIT,PRD_KODETAG,PRD_FLAGBKP1, PRD_AVGCOST,
                ST_AVGCOST,NVL(ST_PRDCD,'XXXXXXX') as ST_PRDCD,Nvl(ST_SALDOAKHIR,0) as ST_SALDOAKHIR, PRD_KODESUPPLIER
                FROM TBMASTER_PRODMAST tp
                LEFT JOIN TBMASTER_STOCK ts ON tp.prd_prdcd = ts.st_prdcd and st_lokasi = '01'
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
                    $hrgsatuan = $result[0]->st_avgcost * $result[0]->prd_frac / 1000;
                    $avgcost = $result[0]->st_avgcost * $result[0]->prd_frac / 1000;
                } else {
                    $hrgsatuan = $result[0]->st_avgcost * $result[0]->prd_frac;
                    $avgcost = $result[0]->st_avgcost * $result[0]->prd_frac;
                }
            }
            return response()->json(['noplu' => 1, 'message' => '', 'data' => $result, 'hrgsatuan' => $hrgsatuan, 'avgcost' => $avgcost]);
        }
    }

    public function nmrBaruTrn(){

        $kodeigr = Session::get('kdigr');
        $ip = str_replace('.', '0', SUBSTR(Session::get('ip'), -3));

        $c = loginController::getConnectionProcedure();

        $s = oci_parse($c, "BEGIN :ret := f_igr_get_nomorstadoc('$kodeigr','NPB','Nomor PB',
                            " .$ip. " || '7', 6, FALSE); END;");
        oci_bind_by_name($s, ':ret', $nopb, 32);
        oci_execute($s);

        return response()->json($nopb);
    }

    public function saveDoc(Request $request){
        $kodeigr = Session::get('kdigr');
        $nopb  = $request->nopb;
        $data = $request->data;
        $date = date('Y-m-d', strtotime($request->date));
        $userid = Session::get('usid');
        $today  = date('Y-m-d H:i:s');

        //get new no trn
        $ip = str_replace('.', '0', SUBSTR(Session::get('ip'), -3));

        $c = loginController::getConnectionProcedure();

        $s = oci_parse($c, "BEGIN :ret := f_igr_get_nomorstadoc('$kodeigr','NPB -
        ','Nomor PB',
                            " .$ip. " || '7', 6, TRUE); END;");
        oci_bind_by_name($s, ':ret', $docNo, 32);
        oci_execute($s);

        $getDoc = DB::connection(Session::get('connection'))->table('tbtr_pb_perishable')->where('trbo_nodoc', $nopb)->first();

        if($getDoc){
            DB::connection(Session::get('connection'))->table('tbtr_pb_perishable')->where('trbo_nodoc', $nopb)->delete();

            for ($i = 1; $i < sizeof($data); $i++){
                $temp = $data[$i];

                $prodmast = DB::connection(Session::get('connection'))->table('tbmaster_prodmast')
                    ->where('prd_kodeigr', $kodeigr)
                    ->where('prd_prdcd', $temp['plu'])
                    ->first();

                //update data
                DB::connection(Session::get('connection'))->table('tbtr_pb_perishable')
                    ->insert([
                        'trbo_kodeigr' => $kodeigr, 'trbo_recordid' => '', 'trbo_typetrn' => 'H','trbo_nodoc' => $getDoc->trbo_nodoc,
                        'trbo_tgldoc' => $date, 'trbo_noreff' => '', 'trbo_tglreff' => '', 'trbo_nopo' => '', 'trbo_tglpo' => '',
                        'trbo_nofaktur' => '', 'trbo_tglfaktur' => '', 'trbo_istype' => '', 'trbo_invno' => '', 'trbo_tglinv' => '',
                        'trbo_nott' => '', 'trbo_tgltt' => '', 'trbo_kodesupplier' => '', 'trbo_kodeigr2' => '', 'trbo_seqno' => $i,
                        'pbp_prdcd' => $temp['plu'], 'trbo_qty' => $temp['qty'], 'trbo_qtybonus1' => '', 'trbo_qtybonus2' => '',
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

            return response()->json(['kode' => 1, 'msg' => $getDoc->pbp_nopb]);
        } else {
            for ($i = 1; $i < sizeof($data); $i++) {
                $temp = $data[$i];

                $prodmast = DB::connection(Session::get('connection'))->table('tbmaster_prodmast')
                    ->where('prd_kodeigr', $kodeigr)
                    ->where('prd_prdcd', $temp['plu'])
                    ->first();

                DB::connection(Session::get('connection'))->table('tbtr_pb_perishable')
                    ->insert([
                        'pbp_kodeigr' => $kodeigr, 
                        'pbp_recordid' => '', 
                        'pbp_nopb' => $docNo,
                        'pbp_tglpb' => $date,
                        'pbp_kodesupplier' => $temp[''],
                        'pbp_prdcd' => $temp['plu'], 
                        'pbp_qtypb' => $temp['qty'],
                        'pbp_avgsales' => '',
                        'trbo_keterangan' => strtoupper($temp['keterangan']),
                        'pbp_createby' => $userid, 
                        'pbp_createdt' => $today, 
                        'pbp_modifyby' => $userid, 
                        'pbp_modifydt' => $today
                    ]);
            }
            return response()->json(['kode' => 1, 'msg' => $docNo]);
        }
    }

    public function deleteDoc(Request $request){
        $nopb = $request->nopb;

        DB::connection(Session::get('connection'))
            ->table('tbtr_pb_perishable')
            ->where('pbp_nopb', $nopb)
            ->delete();

        return response()->json(['kode' => 1, 'msg' => "Dokumen Berhasil dihapus"]);
    }

}


