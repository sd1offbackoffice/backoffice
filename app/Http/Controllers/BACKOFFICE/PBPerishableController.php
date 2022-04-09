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
        $nopb = $request->nopb;
        $flag = '';


        $temp = DB::connection('simbdg')->select("SELECT count(1) FROM tbtr_pb_h 
        WHERE pbh_tgltransfer IS NOT NULL 
        AND pbh_nopb =$nopb"
        );

        if ($temp == 0){
            $flag = 0;
        }
        else {
            $flag = 1;
        }

        $result = DB::connection('simbdg')->select("SELECT pbp_nopb,
                            pbp_tglpb,
                            pbp_kodesupplier,
                            pbp_kodesarana,
                            pbp_kubikase,
                            sup_namasupplier,
                            sfrz_volsarana,
                            sfrz_volsarana * sfrz_jumlahsarana totalkapasitas
                    FROM (  SELECT pbp_nopb,
                                    pbp_tglpb,
                                    pbp_kodesupplier,
                                    pbp_kodesarana,
                                    SUM (pbp_kubikase) pbp_kubikase
                                FROM tbtr_pb_perishable
                            GROUP BY pbp_nopb,
                                    pbp_tglpb,
                                    pbp_kodesupplier,
                                    pbp_kodesarana),
                            tbmaster_supplier,
                            tbmaster_saranafreezer
                    WHERE     pbp_kodesupplier = sup_kodesupplier
                            AND pbp_kodesarana = sfrz_kodesarana
                            AND pbp_nopb = $nopb");
            // ->table('tbtr_pb_perishable')
            // ->leftJoin('tbmaster_saranafreezer', 'pbp_kodesarana', '=', 'sfrz_kodesarana')
            // ->leftJoin('tbmaster_supplier', 'pbp_kodesupplier', '=', 'sup_kodesupplier')
            // ->selectRaw('pbp_nopb')
            // ->selectRaw('pbp_tglpb')
            // ->selectRaw('pbp_kodesupplier')
            // ->selectRaw('pbp_kodesarana')
            // ->select('SUM (pbp_kubikase) TOTALKUBIKASE')
            // ->selectRaw('sup_namasupplier')
            // ->selectRaw('sfrz_volsarana')
            // ->selectRaw('sfrz_jumlahsarana')
            // ->where('PBP_NOPB' , '=', $nopb)
            // ->groupBy('pbp_nopb, pbp_tglpb, pbp_kodesupplier, pbp_kodesarana')
            // ->get();

        // if($result[0]->totalkubikase > $result[0]->totalkapasitas){
        //     $flag = 'X';            
        // }

        return response()->json([ 'data' => $result, 'flag' => $flag]);
        // return response()->json([ 'data' => $result, 'flag' => $flag, 'temp' => $temp]);
                                
        // return response()->json($result);

    }

    public function showTrn(Request $request){
        $nopb = $request->nopb;
        $kodesup = $request->kodesup;
        $kodesar = $request->kodesar;

        $result = DB::connection('simbdg')->select("SELECT pbp_nopb, pbp_tglpb, pbp_kodesupplier, sup_namasupplier,pbp_prdcd,pbp_pkm,pbp_avgsales,pbp_stock,pbp_mindisplay,pbp_minorder,pbp_qtypb,pbp_qtypbout,pbp_qtypoout,pbp_dimensi,pbp_kubikase, pbp_isictn, prd_deskripsipanjang
        FROM tbtr_pb_perishable, tbmaster_prodmast, tbmaster_supplier
        WHERE pbp_prdcd = prd_prdcd
        AND pbp_kodesupplier = sup_kodesupplier
        AND pbp_nopb = $nopb AND pbp_kodesupplier = '$kodesup' AND pbp_kodesarana = $kodesar
        ORDER BY pbp_avgsales DESC, pbp_prdcd");

        return response()->json($result);
    }
 
    public function nmrBaruPb(){

        $kodeigr = Session::get('kdigr');
        // $ip = str_replace('.', '0', SUBSTR(Session::get('ip'), -3));

        $c = loginController::getConnectionProcedure();

        $s = oci_parse($c, "BEGIN :NO_PB := f_igr_get_nomor('$kodeigr','PB','Nomor Permintaan Barang',
                            " .$kodeigr. " || TO_CHAR (SYSDATE, 'yyMM') , 3, FALSE); END;");
        oci_bind_by_name($s, ':NO_PB', $no_pb, 32);
        oci_execute($s);

        return response()->json($no_pb);
    }

    public function saveDoc(Request $request){
        $kodeigr = Session::get('kdigr');
        $nopb  = $request->nopb;
        $data = $request->data;
        $date = date('Y-m-d', strtotime($request->date));
        $userid = Session::get('usid');
        $today  = date('Y-m-d H:i:s');
        $message ='';
        $status = '';
    // DECLARE
    // temp       NUMBER;
    // confirm    VARCHAR2 (20);
    // P_SUKSES   BOOLEAN;
    // P_ERRMSG   VARCHAR2 (1000);
    // nopb_old   VARCHAR2 (20);

    // step number;
    // BEGIN

    // --**cek qty

    // select sum(pbp_qtypb) 
    // into temp 
    // from tbtr_pb_perishable
    // where pbp_nopb = :no_pb;

    $temp = DB::connection('simbdg')->table('tbtr_pb_perishable')
        ->selectRaw('SUM (pbp_qtypb)')
        ->where('pbp_nopb', '=', $nopb)
        ->get();

    // IF temp <= 0
    // THEN
    // dc_alert.ok ('Tidak ada qty yang akan diPB', 'info');
    // RETURN;
    // END IF;
    
    if($temp <=0){
        $message = 'Tidak ada qty yang akan diPB';
        $status = 'info';
        return response()->json(['message' => $message, 'status' => $status]);
    }


    // --**cek kubikase

    // step := 1;
    
    // SELECT COUNT (1)
    // INTO temp
    // FROM (  SELECT pbp_nopb,
    //                 pbp_tglpb,
    //                 pbp_kodesupplier,
    //                 pbp_kodesarana,
    //                 SUM (pbp_kubikase) ttl_kubikase
    //             FROM tbtr_pb_perishable
    //         GROUP BY pbp_nopb,
    //                 pbp_tglpb,
    //                 pbp_kodesupplier,
    //                 pbp_kodesarana),
    //     tbmaster_supplier,
    //     tbmaster_saranafreezer
    // WHERE     pbp_kodesupplier = sup_kodesupplier
    //     AND pbp_kodesarana = sfrz_kodesarana
    //     AND pbp_nopb = :no_pb
    //     AND ttl_kubikase > sfrz_volsarana*sfrz_jumlahsarana;
    //     --ganti disini
    $temp = DB::connection('simbdg')->select("SELECT COUNT (1)
            FROM (  SELECT pbp_nopb,
                            pbp_tglpb,
                            pbp_kodesupplier,
                            pbp_kodesarana,
                            SUM (pbp_kubikase) ttl_kubikase
                        FROM tbtr_pb_perishable
                    GROUP BY pbp_nopb,
                            pbp_tglpb,
                            pbp_kodesupplier,
                            pbp_kodesarana),
                tbmaster_supplier,
                tbmaster_saranafreezer
            WHERE     pbp_kodesupplier = sup_kodesupplier
                AND pbp_kodesarana = sfrz_kodesarana
                AND pbp_nopb = :no_pb
                AND ttl_kubikase > sfrz_volsarana*sfrz_jumlahsarana");

    // IF temp > 0
    // THEN
    // dc_alert.ok ('Terdapat Total Kubikase Item yang melebihi volume sarana. Qty PB harus dilakukan pengurangan!!', 'info');
    // RETURN;
    // END IF;

    if($temp > 0){
        $message = 'Terdapat Total Kubikase Item yang melebihi volume sarana. Qty PB harus dilakukan pengurangan!!';
        $status = 'info';
        return response()->json(['message' => $message, 'status' => $status]);
    }
    

    // --**cek nomor pb

    // step := 2;

    // SELECT COUNT (1)
    // INTO temp
    // FROM tbtr_pb_h
    // WHERE pbh_nopb = :no_pb AND pbh_keteranganpb <> 'PB PERISHABLE';

    // IF temp > 0
    // THEN
    // dc_alert.confirm (
    //     'No.PB sudah terpakai, akan diganti dengan nomor baru',
    //     'info',
    //     confirm);

    // IF confirm = 'OK'
    // THEN
        
    //     step := 3;
        
    //     nopb_old := :no_pb;

    //     :NO_PB :=
    //         f_igr_get_nomor ( :parameter.KodeIgr,
    //                         'PB',
    //                         'Nomor Permintaan Barang',
    //                         :parameter.KodeIgr || TO_CHAR (SYSDATE, 'yyMM'),
    //                         3,
    //                         TRUE);

    //     UPDATE tbtr_pb_perishable
    //         SET pbp_nopb = :no_pb
    //     WHERE pbp_nopb = nopb_old;

    //     FORMS_DDL ('commit');

    //     --dc_alert.ok ('ganti nomor');
    // ELSE
    //     RETURN;
    // END IF;
    // END IF;



    // --**proses

    // step := 4;
    
    // IF :no_pb IS NULL
    // THEN
    // RETURN;
    // END IF;

    // dc_alert.confirm (
    //     'Simpan PB?',
    //     ' ',
    //     confirm);

    // IF confirm = 'CANCEL'
    // THEN
    //         return;
    // END IF;

    // Sp_Create_Pb_Perishable_frz (2,
    //                             :tgl_pb,
    //                             :parameter.kodeigr,
    //                             :no_pb,
    //                             :parameter.userid,
    //                             P_SUKSES,
    //                             P_ERRMSG);

    // IF NOT p_sukses
    // THEN
    // dc_alert.ok (p_errmsg);
    // RETURN;
    // ELSE
    // dc_alert.ok ('PB berhasil disimpan', 'Info');
    // CLEAR_FORM (no_validate, full_rollback);  
    // go_item('no_pb');
    // END IF;

    // exception when others
    // then 
    // dc_alert.ok('Err, ' || step);

    // END;
        //get new no trn
        // $ip = str_replace('.', '0', SUBSTR(Session::get('ip'), -3));

        $c = loginController::getConnectionProcedure();

        $s = oci_parse($c, "BEGIN :NO_PB := f_igr_get_nomor('$kodeigr','PB','Nomor Permintaan Barang',
                            " .$kodeigr. " || TO_CHAR (SYSDATE, 'yyMM') , 3, FALSE); END;");
        oci_bind_by_name($s, ':NO_PB', $no_pb, 32);
        oci_execute($s);

        $getDoc = DB::connection('simbdg')->table('tbtr_pb_perishable')->where('pbp_nopb', $no_pb)->first();

        if($getDoc){
            DB::connection('simbdg')->table('tbtr_pb_perishable')->where('pbp_nopb', $no_pb)->delete();

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
                        'pbp_mindisplay' => $getDoc->pbp_mindisplay,
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
                        'pbp_nopb' => $no_pb,
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
            return response()->json(['kode' => 1, 'msg' => $no_pb]);
        }
    }

    public function qtyPb(Request $request){
        $pkm = $request->pkm;
        $nopb  = $request->nopb;
        $noplu = $request->noplu;
        $qtypb = $request->qtypb;
        $stock = $request->stock;
        $poout = $request->poout;
        $pbout = $request->pbout;
        $isictn = $request->isictn;
        $dimensi = $request->dimensi;
        $minorder = $request->minorder;
        $userid = Session::get('usid');
        $message = '';

        // get kode supp
        $kodesup = DB::connection('simbdg')
        ->table('tbtr_pb_perishable')
        ->selectRaw('pbp_kodesupplier')
        ->where('pbp_nopb', '=' , $nopb)
        ->where('pbp_prdcd' , '=' , $noplu)
        ->get();

        //get kode sarana
        $kodesar = DB::connection('simbdg')
        ->table('tbtr_pb_perishable')
        ->selectRaw('pbp_kodesarana')
        ->where('pbp_nopb', '=' , $nopb)
        ->where('pbp_prdcd' , '=' , $noplu)
        ->get();

        // select pbp_qtypb into qtypb_db
        // from tbtr_pb_perishable
	    //  WHERE     pbp_nopb = :no_pb
        //   AND pbp_kodesupplier = :h_supp
        //   AND pbp_kodesarana = :h_sarana
        //   AND pbp_prdcd = :d_prdcd;

        $qtypb_db = DB::connection('simbdg')
        ->table('tbtr_pb_perishable')
        ->selectRaw('pbp_qtypb')
        ->where('pbp_nopb', '=' , $nopb)
        ->where('pbp_kodesupplier', '=' , $kodesup)
        ->where('pbp_kodesarana', '=' , $kodesar)
        ->where('pbp_prdcd' , '=' , $noplu)
        ->get();

        //         IF :d_qtypb = qtypb_db
        // --         ( :d_kubikase / :d_dimensi) - :d_stockakhir - :d_poout 
        //    THEN
        //       RETURN;
        //    END IF;

        //    IF :d_prdcd IS NULL
        //    THEN
        //       :d_qtypb := NULL;
        //       RETURN;
        //    END IF;
        if ($qtypb == $qtypb_db){
            return;
        }

        if (!$noplu){
            // 0 = null
            $qtypb = 0;
            return response()->json(['qtypb' => $qtypb]);
        }

    //    IF :d_qtypb = 0 AND :d_stockakhir = 0 and :d_poout = 0
    //    THEN
    //       dc_alert.ok ('PLU ' || :d_prdcd || ' Sarana ' || :h_sarana || ' Stock 0, PB harus >= 1');
    //       --RAISE Form_Trigger_Failure;
        
    //       :d_kubikase :=
    //       round((( :d_qtypb + :d_stockakhir + :d_poout )/:d_isictn) * :d_dimensi);
        
    //       RETURN;
    //    END IF;

        if($qtypb == 0 && $stock == 0 && $poout ==0){
            $message = ('PLU ' + $noplu + ' Sarana ' + $kodesar + ' Stock 0, PB harus >= 1');

            return response()->json(['message' => $message]);
        }

        // IF MOD ( :d_qtypb, :d_minorder) > 0
        // THEN
        //     dc_alert.ok ('Qty PB kelipatan min order');
        // END IF;

        if($qtypb % $minorder > 0){
            $message = ('Qty PB kelipatan min order');

            return response()->json(['message' => $message]);
        }

        // IF ROUND ( ( :d_pkm - :d_stockakhir) / :d_minorder) > 0
        // THEN
        //     :d_qtypb :=
        //         GREATEST (ROUND ( :d_qtypb / :d_minorder) * :d_minorder,
        //                 :d_minorder);
        if (ROUND (( $pkm - $stock) / $minorder) > 0){
            $qtypb = MAX(ROUND ( $qtypb / $minorder) * $minorder, $minorder);
        }
        // ELSE
        //     IF :d_qtypb > 0
        //     THEN
        //         :d_qtypb :=
        //             GREATEST (ROUND ( :d_qtypb / :d_minorder) * :d_minorder,
        //                     :d_minorder);
        //     END IF;
        // END IF;
        else if ($qtypb > 0){
            $qtypb = MAX(ROUND ( $qtypb / $minorder) * $minorder, $minorder);
        }

        // :d_kubikase :=
        //     round((( :d_qtypb + :d_stockakhir + :d_poout + :d_pbout)/:d_isictn) * :d_dimensi);
        $kubikase = round((( $qtypb + $stock + $poout + $pbout)/$isictn) * $dimensi);

        // UPDATE tbtr_pb_perishable
        //         SET pbp_qtypb = :d_qtypb,
        //         pbp_kubikase = :d_kubikase,                --:d_qtypb * pbp_dimensi,
        //         pbp_modify_by = :parameter.userid,
        //         pbp_modify_dt = SYSDATE
        //      WHERE     pbp_nopb = :no_pb
        //         AND pbp_kodesupplier = :h_supp
        //         AND pbp_kodesarana = :h_sarana
        //         AND pbp_prdcd = :d_prdcd;
        // FORMS_DDL ('commit');       
        DB::connection('simbdg')->update("UPDATE tbtr_pb_perishable
                                            SET pbp_qtypb = $qtypb,
                                                pbp_kubikase = $kubikase,                
                                                pbp_modify_by = $userid,
                                                pbp_modify_dt = SYSDATE
                                            WHERE     pbp_nopb = $nopb
                                                AND pbp_kodesupplier = $kodesup
                                                AND pbp_kodesarana = $kodesar
                                                AND pbp_prdcd = $noplu");
       
    
    
        //todo
        // SELECT SUM (pbp_kubikase)
        // INTO :h_kubikase
        // FROM tbtr_pb_perishable
        // WHERE     pbp_nopb = :no_pb
        //         AND pbp_kodesupplier = :h_supp
        //         AND pbp_kodesarana = :h_sarana;
    
        // IF :h_kubikase > :h_kapasitas
        //     --ganti disini
        // THEN
        //     :h_flag := 'X';
        // ELSE
        //     :h_flag := NULL;
        // END IF;
 
        return response()->json(['message' => $message, 'kubikase' => $kubikase]);


    }


    public function prosesDoc(Request $request){
        $kodeigr = Session::get('kdigr');
        $nopb  = $request->nopb;
        $userid = Session::get('usid');
        $tglpb = $request->tglpb;
        $message = '';
        $status = '';

        $temp = DB::connection('simbdg')
            ->table('tbtr_pb_perishable')
            ->selectRaw('COUNT(1) as TEMP')
            ->where('pbp_nopb', $nopb)
            ->get();
            
        if($temp > 0){
            $message = 'No PB sudah diproses, silahkan edit';
            $status = 'info';
            return compact(['status', 'message']);
        }
        else if($temp == 0) {
            $message = 'Tidak ada PLU yang bisa di PB untuk tgl ' + $tglpb;
            $status = 'error';
            return compact(['status', 'message']);
        }

        $c = loginController::getConnectionProcedure();
        $sql = "BEGIN Sp_Create_Pb_Perishable_frz2(1, to_date('" . $tglpb . "','dd/mm/yyyy'),$kodeigr,$nopb, $userid, :P_SUKSES, :P_ERRMSG); END;";
        $s = oci_parse($c, $sql);

        oci_bind_by_name($s, ':P_SUKSES', $p_sukses, 200);
        oci_bind_by_name($s, ':P_ERRMSG', $err_txt, 200);
        oci_execute($s);

        
        if($p_sukses == 'FALSE'){
            $message = $err_txt;
            $status = 'error';
            return compact(['status', 'message']);
        }


        $c1 = loginController::getConnectionProcedure();
        $sql1 = "BEGIN  :NO_PB := f_igr_get_nomor($kodeigr,'PB','Nomor Permintaan Barang', $kodeigr || TO_CHAR (SYSDATE, 'yyMM'),3,TRUE); END;";
        $s1 = oci_parse($c1, $sql1);

        oci_bind_by_name($s1, ':NO_PB', $no_pb, 200);
        oci_execute($s1);
        
        return compact(['status', 'message', 'no_pb']);
    }

    public function deleteDoc(Request $request){
        $nopb = $request->nopb;
        $message= '';
        $status = '';

        // if :no_pb is null then return; end if;
        if (!$nopb){
            $message = 'Tidak ada nomor PB';
            $status = 'error';
            return compact(['status', 'message']);
        }

        // select count(1) into temp
        // from tbtr_pb_h
        // where pbh_nopb = :no_pb;
        
        $temp = DB::connection('simbdg')
            ->table('tbtr_pb_h')
            ->selectRaw('COUNT (1)')
            ->where('pbh_nopb', '=' , $nopb)
            ->get();
            
        // if temp > 0
        // then 
        //  dc_alert.ok('Draft sudah menjadi PB');
        //  return;
        // end if;
   
        if ($temp > 0){
            $message = 'Draft sudah menjadi PB';
            $status = 'info';
            return compact(['status', 'message']);
        }
 
        // delete from tbtr_pb_perishable 
        // where pbp_nopb=:no_pb;
        
        DB::connection('simbdg')
            ->table('tbtr_pb_perishable')
            ->where('pbp_nopb', $nopb)
            ->delete();
        
        // forms_ddl('commit');
        
        $message = 'Delete Success!';
        $status = 'info';

        return compact(['status', 'message']);

    }

}


