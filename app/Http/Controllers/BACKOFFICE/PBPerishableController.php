<?php

namespace App\Http\Controllers\BACKOFFICE;

use App\Http\Controllers\Auth\loginController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class PBPerishableController extends Controller
{
    public function index()
    {
        return view('BACKOFFICE.PBPerishable');
    }

    public function lov_trn(Request $request)
    {
        $search = $request->search;

        $result = DB::connection('simbdg')->table('tbtr_pb_perishable')
            ->selectRaw("pbp_nopb, pbp_tglpb, pbp_recordid")
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

        $result = DB::connection('simbdg')->table('tbmaster_prodmast')
            ->select('prd_prdcd', 'prd_deskripsipanjang')
            ->whereRaw("SUBSTR(PRD_PRDCD,7,1)='0'")
            ->whereRaw("nvl(prd_recordid,'9')<>'1'")
            ->whereRaw("(prd_deskripsipanjang LIKE '%". $search."%' or prd_prdcd LIKE '%". $search."%')")
            ->orderBy('prd_deskripsipanjang')
            ->limit(100)->get();

        return response()->json($result);
    }

    public function showSup(Request $request){
        $kodesupplier = $request->kodesupplier;

        $result = DB::connection('simbdg')->table('tbtr_pb_perishable')
            ->leftJoin('tbtr_pb_h','pbp_nopb','=','pbh_nopb')
            ->leftJoin('tbmaster_supplier', 'pbp_kodesupplier', '=', 'sup_kodesupplier')
//            ->leftJoin('tbmaster_stock','pbp_prdcd','=','st_prdcd')
            ->selectRaw("COUNT(1)")
            ->selectRaw('pbp_kodesarana')
            ->selectRaw('pbp_volsarana')
            ->selectRaw('pbp_kodesupplier')
            ->selectRaw('sup_namasupplier')
            ->where('PBP_KODESUPPLIER', '=', $kodesupplier)
            ->whereNull('pbp_recordid')
            ->orderBy('PBP_KODESUPPLIER')
            ->get();

        return response()->json($result);
    }

    public function showTrn(Request $request){
        $nopb = $request->nopb;
        $kodesupplier = $request->kodesupplier;

        $result = DB::connection('simbdg')->table('tbtr_pb_perishable')
            ->leftJoin('tbmaster_prodmast', 'pbp_prdcd', '=', 'prd_prdcd')
            ->leftJoin('tbmaster_supplier', 'pbp_kodesupplier', '=', 'sup_kodesupplier')
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
            ->selectRaw('pbp_qtypb')
            ->selectRaw('pbp_kubikase')
            ->selectRaw('prd_deskripsipanjang')
            ->selectRaw('pbp_avgsales')
            ->selectRaw('pbp_kodesupplier')
            ->selectRaw('sup_namasupplier')
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

        $result = DB::connection('simbdg')->select("SELECT ,PRD_DESKRIPSIPANJANG
               NVL(ST_PRDCD,'XXXXXXX') as ST_PRDCD, PRD_KODESUPPLIER
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

        $getDoc = DB::connection('simbdg')->table('tbtr_pb_perishable')->where('pbp_nopb', $nopb)->first();

        if($getDoc){
            DB::connection('simbdg')->table('tbtr_pb_perishable')->where('pbp_nopb', $nopb)->delete();

            for ($i = 1; $i < sizeof($data); $i++){
                $temp = $data[$i];

                $prodmast = DB::connection('simbdg')->table('tbmaster_prodmast')
                    ->where('pbp_kodeigr', $kodeigr)
                    ->where('pbp_prdcd', $temp['plu'])
                    ->first();

                //update data
                DB::connection('simbdg')->table('tbtr_pb_perishable')
                    ->insert([
                        'pbp_kodeigr' => $kodeigr, 
                        'pbp_recordid' => '', 
                        'pbp_nopb' => $getDoc->pbp_nopb,
                        'pbp_tglpb' => $date,
                        'pbp_kodesupplier' => $getDoc->pbp_kodesupplier,
                        'pbp_kodesarana' => $getDoc->pbp_kodesarana,
                        'pbp_volsarana' => $getDoc->pbp_volsarana,
                        'pbp_prdcd' => $temp['plu'], 
                        'pbp_pkm' => $getDoc->pbp_pkm,
                        'pbp_avgsales' => $getDoc->pbp_avgsales,
                        'pbp_stock' => $getDoc->pbp_stock,
                        'pbp_mindisplay' => 1,
                        'pbp_minorder' => $getDoc->pbp_minorder,
                        'pbp_qtypb' => $temp['qty'],
                        'pbp_qtypbout' => $getDoc->pbp_qtypbout,
                        'pbp_qtypoout' => $getDoc->pbp_qtypoout,
                        'pbp_dimensi' => $getDoc->pbp_dimensi,
                        'pbp_kubikase' => $getDoc->pbp_kubikase,
                        'pbp_createby' => $getDoc->pbp_createby, 
                        'pbp_createdt' => $getDoc->pbp_createdt, 
                        'pbp_modifyby' => $userid, 
                        'pbp_modifydt' => $today,
                        'pbp_isictn' => ''
                    ]);
            }

            return response()->json(['kode' => 1, 'msg' => $getDoc->pbp_nopb]);
        } else {
            for ($i = 1; $i < sizeof($data); $i++) {
                $temp = $data[$i];

                $prodmast = DB::connection('simbdg')->table('tbmaster_prodmast')
                    ->where('prd_kodeigr', $kodeigr)
                    ->where('prd_prdcd', $temp['plu'])
                    ->first();

                DB::connection('simbdg')->table('tbtr_pb_perishable')
                    ->insert([
                        'pbp_kodeigr' => $kodeigr, 
                        'pbp_recordid' => '', 
                        'pbp_nopb' => $docNo,
                        'pbp_tglpb' => $date,
                        'pbp_kodesupplier' => $temp[''],
                        'pbp_kodesarana' => $temp[''],
                        'pbp_volsarana' => $temp[''],
                        'pbp_prdcd' => $temp['plu'], 
                        'pbp_pkm' => $temp[''],
                        'pbp_avgsales' => '',
                        'pbp_stock' => '',
                        'pbp_mindisplay' => '',
                        'pbp_minorder' => '',
                        'pbp_qtypb' => $temp['qty'],
                        'pbp_qtypbout' => '',
                        'pbp_qtypoout' => '',
                        'pbp_dimensi' => '',
                        'pbp_kubikase' => '',
                        'pbp_createby' => $userid, 
                        'pbp_createdt' => $today, 
                        'pbp_modifyby' => '', 
                        'pbp_modifydt' => '',
                        'pbp_isictn' => '',
                    ]);
            }
            return response()->json(['kode' => 1, 'msg' => $docNo]);
        }
    }

    public function deleteDoc(Request $request){
        $nopb = $request->nopb;

        DB::connection('simbdg')
            ->table('tbtr_pb_perishable')
            ->where('pbp_nopb', $nopb)
            ->delete();

        return response()->json(['kode' => 1, 'msg' => "Dokumen Berhasil dihapus"]);
    }

}


