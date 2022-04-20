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

        $result = DB::connection(Session::get('connection'))->table('tbtr_pb_perishable')
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

        $result = DB::connection(Session::get('connection'))->table('tbmaster_prodmast')
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


        $temp = DB::connection(Session::get('connection'))->select("SELECT count(1) as temp FROM tbtr_pb_h
        WHERE pbh_tgltransfer IS NOT NULL
        AND pbh_nopb =$nopb");

        if ($temp[0]->temp == 0){
            $flag = 0;
        }
        else {
            $flag = 1;
        }

        $result = DB::connection(Session::get('connection'))->select("SELECT pbp_nopb,
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

        $result = DB::connection(Session::get('connection'))->select("SELECT pbp_nopb, pbp_tglpb, pbp_kodesupplier, sup_namasupplier,pbp_prdcd,pbp_pkm,pbp_avgsales,pbp_stock,pbp_mindisplay,pbp_minorder,pbp_qtypb,pbp_qtypbout,pbp_qtypoout,pbp_dimensi,pbp_kubikase, pbp_isictn, prd_deskripsipanjang
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
        $nopb  = $request->nopb;
        $message ='';
        $status = '';
        $errflag = '';
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

        $temp = DB::connection(Session::get('connection'))->select("SELECT SUM(pbp_qtypb) as temp FROM tbtr_pb_perishable
        WHERE pbp_nopb =$nopb");
        // IF temp <= 0
        // THEN
        // dc_alert.ok ('Tidak ada qty yang akan diPB', 'info');
        // RETURN;
        // END IF;

        if($temp[0]->temp <=0){
            $message = 'Tidak ada qty yang akan diPB';
            $status = 'info';
            $errflag = '1';
            return response()->json(['message' => $message, 'status' => $status, 'errflag' => $errflag]);
        }


        // --**cek kubikase

        // step := 1;
        $step = 1;

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
        $temp = DB::connection(Session::get('connection'))->select("SELECT COUNT (1) as temp
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
                    AND pbp_nopb = $nopb
                    AND ttl_kubikase > sfrz_volsarana*sfrz_jumlahsarana");

        // IF temp > 0
        // THEN
        // dc_alert.ok ('Terdapat Total Kubikase Item yang melebihi volume sarana. Qty PB harus dilakukan pengurangan!!', 'info');
        // RETURN;
        // END IF;

        if($temp[0]->temp > 0){
            $message = 'Terdapat Total Kubikase Item yang melebihi volume sarana. Qty PB harus dilakukan pengurangan!!';
            $status = 'info';
            $errflag = '1';
            return response()->json(['message' => $message, 'status' => $status, 'errflag' => $errflag]);
        }


        // --**cek nomor pb

        // step := 2;
        $step = 2;

        // SELECT COUNT (1)
        // INTO temp
        // FROM tbtr_pb_h
        // WHERE pbh_nopb = :no_pb AND pbh_keteranganpb <> 'PB PERISHABLE';
        $temp = DB::connection(Session::get('connection'))->table('tbtr_pb_h')
        ->selectRaw('COUNT (1) as temp')
        ->where('pbh_nopb', '=', $nopb)
        ->where('pbh_keteranganpb', '<>', 'PB PERISHABLE')
        ->get();

        if ($temp[0]->temp > 0){
            $message = 'No.PB sudah terpakai, akan diganti dengan nomor baru';
            $status = 'info';
            $errflag = 1;
            return response()->json(['message' => $message, 'status' => $status, 'errflag' => $errflag]);
        }
        else if($temp[0]->temp == 0){
            $message = '';
            $status = '';
            $errflag = 0;
            return response()->json(['message' => $message, 'status' => $status, 'errflag' => $errflag]);
        }

    }
        // IF temp > 0
        // THEN
        // dc_alert.confirm (
        //     'No.PB sudah terpakai, akan diganti dengan nomor baru',
        //     'info',
        //     confirm);

        // IF confirm = 'OK'
        // THEN

    public function saveDoc2(Request $request){
        $kodeigr = Session::get('kdigr');//     step := 3;
        $nopb  = $request->nopb;

        $step = 3;
        //     nopb_old := :no_pb;

        //     :NO_PB :=
        //         f_igr_get_nomor ( :parameter.KodeIgr,
        //                         'PB',
        //                         'Nomor Permintaan Barang',
        //                         :parameter.KodeIgr || TO_CHAR (SYSDATE, 'yyMM'),
        //                         3,
        //                         TRUE);
        $c = loginController::getConnectionProcedure();

        $s = oci_parse($c, "BEGIN :NO_PB := f_igr_get_nomor('$kodeigr','PB','Nomor Permintaan Barang',
        " .$kodeigr. " || TO_CHAR (SYSDATE, 'yyMM') , 3, TRUE); END;");
        oci_bind_by_name($s, ':NO_PB', $no_pb, 32);
        oci_execute($s);

        //     UPDATE tbtr_pb_perishable
        //         SET pbp_nopb = :no_pb
        //     WHERE pbp_nopb = nopb_old;
        DB::connection(Session::get('connection'))
        ->update("UPDATE tbtr_pb_perishable
                    SET pbp_nopb = $no_pb
                    WHERE pbp_nopb = $nopb");

        //     FORMS_DDL ('commit');
        return response()->json(['message' => 'ganti nomor', 'status' => 'info', 'nopbnew' => $no_pb]);
        //     --dc_alert.ok ('ganti nomor');
        // ELSE
        //     RETURN;
        // END IF;
        // END IF;
    }


        // --**proses
    public function saveDoc3(Request $request){
        // step := 4;
        $kodeigr = Session::get('kdigr');//     step := 3;
        $nopb  = $request->nopb;
        $tglpb  = $request->tglpb;
        $data = $request->data;
        $date = date('Y-m-d', strtotime($request->date));
        $userid = Session::get('usid');
        $today  = date('Y-m-d H:i:s');
        $message ='';
        $status = '';
        $step = '';

        // Sp_Create_Pb_Perishable_frz (2,
        //                             :tgl_pb,
        //                             :parameter.kodeigr,
        //                             :no_pb,
        //                             :parameter.userid,
        //                             P_SUKSES,
        //                             P_ERRMSG);
        $c = loginController::getConnectionProcedure();
        $sql = "BEGIN Sp_Create_Pb_Perishable_frz2(2, to_date('" . $tglpb . "','dd/mm/yyyy'),'" . $kodeigr. "', '" . $nopb. "', '" . $userid. "', :P_SUKSES, :P_ERRMSG); END;";
        $s = oci_parse($c, $sql);

        oci_bind_by_name($s, ':P_SUKSES', $p_sukses, 200);
        oci_bind_by_name($s, ':P_ERRMSG', $err_txt, 200);
        oci_execute($s);

        // IF NOT p_sukses
        // THEN
        // dc_alert.ok (p_errmsg);
        // RETURN;
        // ELSE
        // dc_alert.ok ('PB berhasil disimpan', 'Info');
        // CLEAR_FORM (no_validate, full_rollback);
        // go_item('no_pb');
        // END IF;

        if($p_sukses == 'FALSE'){
            $message = $err_txt;
            $status = 'error';

        }else{
            $message = 'PB berhasil disimpan';
            $status = 'info';
        }
        return  response()->json(['status' => $status, 'message' => $message]);

        // exception when others
        // then
        // dc_alert.ok('Err, ' || step);

        // END;
            //get new no trn
            // $ip = str_replace('.', '0', SUBSTR(Session::get('ip'), -3));


    }

    public function qtyPb(Request $request){
        $pkm = $request->pkm;
        $nopb  = $request->nopb;
        $plu = $request->plu;
        $qtypb = $request->qtypb;
        $stock = $request->stock;
        $poout = $request->poout;
        $pbout = $request->pbout;
        $isictn = $request->isictn;
        $dimensi = $request->dimensi;
        $kodesup = $request->kodesup;
        $kodesar = $request->kodesar;
        $minorder = $request->minorder;
        $userid = Session::get('usid');
        $message = '';

        // get kode supp

        // select pbp_qtypb into qtypb_db
        // from tbtr_pb_perishable
	    //  WHERE     pbp_nopb = :no_pb
        //   AND pbp_kodesupplier = :h_supp
        //   AND pbp_kodesarana = :h_sarana
        //   AND pbp_prdcd = :d_prdcd;

        $qtypb_db = DB::connection(Session::get('connection'))->select("SELECT pbp_qtypb FROM tbtr_pb_perishable
        WHERE pbp_nopb = $nopb
        AND pbp_prdcd = $plu
        AND pbp_kodesupplier = '$kodesup'
        AND pbp_kodesarana = $kodesar");

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

        if (!$plu){
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
            $message = 'PLU ' . $plu . ' Sarana ' . $kodesar . ' Stock 0, PB harus >= 1';

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
        DB::connection(Session::get('connection'))->update("UPDATE tbtr_pb_perishable
                                            SET pbp_qtypb = $qtypb,
                                                pbp_kubikase = $kubikase,
                                                pbp_modify_by = '$userid',
                                                pbp_modify_dt = SYSDATE
                                            WHERE     pbp_nopb = $nopb
                                                AND pbp_kodesupplier = '$kodesup'
                                                AND pbp_kodesarana = $kodesar
                                                AND pbp_prdcd = $plu");



        //todo

        $totalkubik = DB::connection(Session::get('connection'))->select("SELECT SUM (pbp_kubikase) AS ttlkubik
        FROM tbtr_pb_perishable
        WHERE     pbp_nopb = $nopb
                AND pbp_kodesupplier = '$kodesup'
                AND pbp_kodesarana = $kodesar");

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

        return response()->json(['message' => $message, 'kubikase' => $kubikase, 'totalkubik' => $totalkubik[0]->ttlkubik]);


    }


    public function prosesDoc(Request $request){
        $kodeigr = Session::get('kdigr');
        $nopb  = $request->nopb;
        $no_pb = '';
        $userid = Session::get('usid');
        $tglpb = $request->tglpb;
        $flag = 0;
        $message = '';
        $status = '';

        $temp = DB::connection(Session::get('connection'))->select("SELECT COUNT(1) as temp
        FROM tbtr_pb_perishable
        WHERE pbp_nopb = $nopb");

        if($temp[0]->temp > 0){
            $message = 'No PB sudah diproses, silahkan edit';
            $status = 'info';
            $flag = 1;
            return response()->json(['status' => $status, 'message' => $message, 'flag' => $flag, 'temp' => $temp[0]->temp]);
        }


        $c = loginController::getConnectionProcedure();
        $sql = "BEGIN Sp_Create_Pb_Perishable_frz2(1, to_date('" . $tglpb . "','dd/mm/yyyy'),'" . $kodeigr. "', '" . $nopb . "', '" . $userid . "', :P_SUKSES, :P_ERRMSG); END;";
        $s = oci_parse($c, $sql);

        oci_bind_by_name($s, ':P_SUKSES', $p_sukses, 200);
        oci_bind_by_name($s, ':P_ERRMSG', $err_txt, 200);
        oci_execute($s);


        if($p_sukses == 'FALSE'){
            $message = $err_txt;
            $status = 'error';
            $flag = 1;
            return response()->json(['status' => $status, 'message' => $message, 'flag' => $flag]);
        }

        $temp = DB::connection(Session::get('connection'))->select("SELECT COUNT(1) as temp
        FROM tbtr_pb_perishable
        WHERE pbp_nopb = $nopb");

        if($temp[0]->temp == 0) {
            $message = 'Tidak ada PLU yang bisa di PB untuk tgl ' . $tglpb;
            $status = 'error';
            $flag = 1;
            return response()->json(['status' => $status, 'message' => $message, 'flag' => $flag, 'temp' => $temp[0]->temp]);
        }

        $sql1 = "BEGIN  :NO_PB := f_igr_get_nomor('" . $kodeigr. "','PB','Nomor Permintaan Barang', '" . $kodeigr. "' || TO_CHAR (SYSDATE, 'yyMM'),3,TRUE); END;";
        $s1 = oci_parse($c, $sql1);

        oci_bind_by_name($s1, ':NO_PB', $no_pb, 200);
        oci_execute($s1);

        return response()->json(['status' => $status, 'message' => $message, 'flag' => $flag, 'no_pb' => $no_pb]);
    }

    public function deleteDoc(Request $request){
        $nopb = $request->nopb;
        $message= '';
        $status = '';

        // if :no_pb is null then return; end if;
        if (!$nopb){
            $message = 'Tidak ada nomor PB';
            $status = 'error';
            return response()->json(['status' => $status, 'message' => $message]);
        }

        // select count(1) into temp
        // from tbtr_pb_h
        // where pbh_nopb = :no_pb;

        $temp = DB::connection(Session::get('connection'))->select("SELECT count(1) as temp FROM tbtr_pb_h
        WHERE pbh_tgltransfer IS NOT NULL
        AND pbh_nopb =$nopb");

        // if temp > 0
        // then
        //  dc_alert.ok('Draft sudah menjadi PB');
        //  return;
        // end if;

        if ($temp[0]->temp > 0){
            $message = 'Draft sudah menjadi PB';
            $status = 'info';
            return response()->json(['status' => $status, 'message' => $message]);
        }

        // delete from tbtr_pb_perishable
        // where pbp_nopb=:no_pb;

        DB::connection(Session::get('connection'))
            ->table('tbtr_pb_perishable')
            ->where('pbp_nopb', $nopb)
            ->delete();

        // forms_ddl('commit');

        $message = 'Delete Success!';
        $status = 'info';

        return response()->json(['status' => $status, 'message' => $message]);

    }

}


