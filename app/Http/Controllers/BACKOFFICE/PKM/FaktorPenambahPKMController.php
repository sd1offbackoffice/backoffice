<?php

namespace App\Http\Controllers\BACKOFFICE\PKM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Auth\loginController;
use Carbon\Carbon;
use File;

class FaktorPenambahPKMController extends Controller
{
    public function index()
    {
        $datas = DB::connection('simckl')->table('tbmaster_pkmplus')
        ->select("PKMP_KODEIGR",
        "PKMP_PRDCD",
        "PKMP_MPLUSI",
        "PKMP_MPLUSO",
        DB::raw("PKMP_MPLUSI + PKMP_MPLUSO AS PKMP_MPLUS"))
        ->where('PKMP_MPLUSO','>','0')
        ->get();

        return view('BACKOFFICE.PKM.faktor-penambah-pkm',compact('datas'));
    }

    public function getDataTableN()
    {
        $data = DB::connection('simckl')->table('tbtr_gondola')
        ->selectRaw("gdl_noperjanjiansewa,
        gdl_prdcd,
        gdl_kodedisplay,
        TO_CHAR(gdl_tglawal,'DD-MM-YYYY') AS gdl_tglawal,
        TO_CHAR(gdl_tglakhir,'DD-MM-YYYY') AS gdl_tglakhir,
        gdl_qty")
        ->orderBy('gdl_noperjanjiansewa','ASC')
        ->get();

        return DataTables::of($data)->make(true);
    }

    public function insertPerjanjian(Request $request)
    {
        $kodeigr = '44';
        $usid = Session::get('usid');

        $check_prodmast = DB::connection('simckl')->table('tbmaster_prodmast')
        ->where('prd_prdcd',$request->na_prdcd)
        ->get();

        $count_prodmast = count($check_prodmast);

        if($count_prodmast == 1)
        {
            $check_tbtr_gondola = DB::connection('simckl')->table('tbtr_gondola')
            ->where('gdl_noperjanjiansewa',$request->na_noperjanjian)
            ->where('gdl_prdcd',$request->na_prdcd)
            ->where('gdl_kodedisplay',$request->na_kodedisplay)
            ->get();

            $count_tbtr_gondola = count($check_tbtr_gondola);

            if($count_tbtr_gondola > 0)
            {
                return response()->json([
                    'title' => 'An error occurred !',
                    'message' => 'Kode perjanjian, PLU, Kode Display sudah ada !',
                    'status' => 'error'
                ], 500);
            }
            else
            {
                $insert_tbtr_gondola = DB::connection('simckl')->table('tbtr_gondola')
                ->insert([
                    'gdl_kodeigr' => $kodeigr,
                    'gdl_noperjanjiansewa' => $request->na_noperjanjian,
                    'gdl_prdcd' => $request->na_prdcd,
                    'gdl_qty' => $request->na_qty,
                    'gdl_kodecabang' => $kodeigr,
                    'gdl_kodedisplay' => $request->na_kodedisplay,
                    'gdl_tglawal' => DB::raw("TO_DATE('" .$request->na_tglawal . "','dd/mm/yyyy')"),
                    'gdl_tglakhir' => DB::raw("TO_DATE('" .$request->na_tglakhir . "','dd/mm/yyyy')"),
                    'gdl_create_by' => $usid,
                    'gdl_create_dt' => Carbon::now()
                ]);

                $check_kkpkm = DB::connection('simckl')->table('tbmaster_kkpkm')
                ->where('pkm_prdcd',$request->na_prdcd)
                ->get();

                $count_kkpkm = count($check_kkpkm);

                if($count_kkpkm > 0)
                {
                    $select_kkpkm = DB::connection('simckl')
                    ->select("SELECT
                    PKM_KODEDIVISI,
                    PKM_KODEDEPARTEMENT,
                    PKM_KODEKATEGORIBARANG,
                    PKM_PKMT,
                    PKM_MPKM
                    FROM tbmaster_kkpkm
                    WHERE pkm_prdcd = '".$request->na_prdcd."' ");

                    $kkdiv = $select_kkpkm[0]->pkm_kodedivisi;
                    $kddep = $select_kkpkm[0]->pkm_kodedepartement;
                    $kdkat = $select_kkpkm[0]->pkm_kodekategoribarang;
                    $pkmt = $select_kkpkm[0]->pkm_pkmt;
                    $mpkm = $select_kkpkm[0]->pkm_mpkm;

                }
                else
                {
                    $select_prodmast = DB::connection('simckl')
                    ->select("SELECT PRD_KODEDIVISI,
                                PRD_KODEDEPARTEMENT,
                                PRD_KODEKATEGORIBARANG,
                                0,
                                0
                            FROM tbmaster_prodmast
                            WHERE prd_prdcd = '".$request->na_prdcd."'
                            ");

                    $kkdiv = $select_prodmast[0]->PKM_KODEDIVISI;
                    $kddep = $select_prodmast[0]->PKM_KODEDEPARTEMENT;
                    $kdkat = $select_prodmast[0]->PKM_KODEKATEGORIBARANG;
                    $pkmt = 0;
                    $mpkm = 0;
                }

                $ftngdla = 0;

                $loop_gondola = DB::connection('simckl')
                ->select("SELECT
                        GDL_PRDCD,
                        GDL_TGLAWAL,
                        GDL_TGLAKHIR,
                        GDL_QTY
                        FROM TBTR_GONDOLA
                        WHERE GDL_PRDCD = '".$request->na_prdcd."'
                        ORDER BY NVL (GDL_TGLAWAL, TO_DATE ('01-01-1990', 'dd-mm-yyyy')) DESC,
                        NVL (GDL_TGLAKHIR, TO_DATE ('31-12-2100', 'dd-mm-yyyy')) DESC
                        ");

                // $count_gondola = count($loop_gondola);

                for($i = 0; $i < sizeof($loop_gondola); $i++)
                {
                    $adagdl = true;
                    $ftngdla = $ftngdla + $loop_gondola[$i]->gdl_qty;
                }

                if($adagdl)
                {

                    $check_pkmgondola = DB::connection('simckl')->table('tbtr_pkmgondola')
                    ->where('PKMG_PRDCD',$request->na_prdcd)
                    ->where('PKMG_TGLAWALPKM',$request->na_tglawal)
                    ->where('PKMG_TGLAKHIRPKM',$request->na_tglakhir)
                    ->get();

                    $count_pkmgondola = count($check_pkmgondola);

                    if($count_pkmgondola == 0)
                    {
                        $insert_tbtr_pkmgondola = DB::connection('simckl')->table('TBTR_PKMGONDOLA')
                        ->insert([
                            'PKMG_KODEIGR' => $kodeigr,
                            'PKMG_KODEDIVISI' => $kkdiv,
                            'PKMG_KODEDEPARTEMENT' => $kddep,
                            'PKMG_KODEKATEGORIBRG' => $kdkat,
                            'PKMG_PRDCD' => $request->na_prdcd,
                            'PKMG_NILAIPKMG' => $pkmt + $ftngdla,
                            'PKMG_NILAIPKMB' => $pkmt + $ftngdla,
                            'PKMG_NILAIMPKM' => $mpkm,
                            'PKMG_NILAIPKMT' => $pkmt,
                            'PKMG_CREATE_DT' => Carbon::now(),
                            'PKMG_CREATE_BY' => $usid,
                            'PKMG_NILAIGONDOLA' => $ftngdla,
                            'PKMG_TGLAWALPKM' => DB::raw("TO_DATE('" .$request->na_tglawal . "','dd/mm/yyyy')"),
                            'PKMG_TGLAKHIRPKM' => DB::raw("TO_DATE('" .$request->na_tglakhir . "','dd/mm/yyyy')")
                        ]);

                        return response()->json([
                            'title' => 'success !',
                            'message' => 'Add data success !',
                            'status' => 'OK'
                        ], 200);

                    }
                    else
                    {
                        $update_pkmgondola = DB::connection('simckl')
                        ->update("  UPDATE TBTR_PKMGONDOLA
                        SET PKMG_NILAIPKMG = '".$pkmt."' + '".$ftngdla."',
                            PKMG_NILAIPKMB = '".$pkmt."' + '".$ftngdla."',
                            PKMG_NILAIMPKM = '".$mpkm."',
                            PKMG_NILAIPKMT = '".$pkmt."',
                            PKMG_MODIFY_DT = SYSDATE,
                            PKMG_MODIFY_BY = '".$usid."',
                            PKMG_NILAIGONDOLA = '".$ftngdla."',
                            WHERE PKMG_PRDCD = '".$request->na_prdcd."' AND PKMG_KODEIGR = '".$usid."' ");

                        return response()->json([
                            'title' => 'success !',
                            'message' => 'Update data pkmgondola success !',
                            'status' => 'OK'
                        ], 200);
                    }
                }

            }

            return response()->json([
                'title' => 'success !',
                'message' => ' OK !',
                'status' => 'OK'
            ], 200);

        }else{
            return response()->json([
                'title' => 'An error occurred !',
                'message' => 'PLU tidak terdaftar di master product !',
                'status' => 'error'
            ], 500);
        }

    }

    public function updateNPLUS(Request $request)
    {
        $usid = Session::get('usid');
        $kodeigr = '44';
        $update_nplus = $request->update_nplus;

        foreach($update_nplus as $un)
        {
            $select_gondola = DB::connection('simckl')->table('tbtr_gondola')
            ->selectRaw("gdl_noperjanjiansewa,
            gdl_prdcd,
            gdl_kodedisplay,
            TO_CHAR(gdl_tglawal,'DD-MM-YYYY') AS gdl_tglawal,
            TO_CHAR(gdl_tglakhir,'DD-MM-YYYY') AS gdl_tglakhir,
            gdl_qty")
            ->where('gdl_noperjanjiansewa',$un['no_perjanjian'])
            ->where('gdl_prdcd',$un['plu_n'])
            ->where('gdl_kodedisplay',$un['kode_display'])
            ->get();

            $count_gondola = count($select_gondola);

            if($count_gondola == 1)
            {
                $update_gondola = DB::connection('simckl')->table('tbtr_gondola')->where('gdl_noperjanjiansewa',$un['no_perjanjian'])
                ->where('gdl_prdcd',$un['plu_n'])
                ->where('gdl_kodedisplay',$un['kode_display'])
                ->update([
                    'gdl_qty' => $un['gdl_qty'] ,
                    'gdl_modify_by' => $usid,
                    'gdl_modify_dt' => Carbon::now()
                ]);

               $check_kkpkm = DB::connection('simckl')->table('tbmaster_kkpkm')
               ->where('pkm_prdcd',$un['plu_n'])
               ->get();

               $count_kkpkm = count($check_kkpkm);

                if($count_kkpkm > 0)
                {
                    $select_kkpkm = DB::connection('simckl')
                    ->select("SELECT PKM_KODEDIVISI,
                    PKM_KODEDEPARTEMENT,
                    PKM_KODEKATEGORIBARANG,
                    PKM_PKMT,
                    PKM_MPKM
                    FROM tbmaster_kkpkm
                    WHERE pkm_prdcd = '".$un['plu_n']."' ");

                    $kddiv = $select_kkpkm[0]->pkm_kodedivisi;
                    $kddep =  $select_kkpkm[0]->pkm_kodedepartement;
                    $kdkat =  $select_kkpkm[0]->pkm_kodekategoribarang;
                    $pkmt =  $select_kkpkm[0]->pkm_pkmt;
                    $mpkm =  $select_kkpkm[0]->pkm_mpkm;

                }
                else{
                    $select_prodmast = DB::connection('simckl')->table('tbmaster_prodmast')
                    ->where('prd_prdcd',$un['plu_n'])
                    ->get();

                    $count_prodmast = count($select_prodmast);

                    if($count_prodmast > 0)
                    {
                        $temp_prodmast = DB::connection('simckl')
                        ->select("SELECT PRD_KODEDIVISI,
                        PRD_KODEDEPARTEMENT,
                        PRD_KODEKATEGORIBARANG,
                        FROM tbmaster_prodmast
                        WHERE prd_prdcd = '".$un['plu_n']."' ");

                        $kddiv = $temp_prodmast[0]->prd_kodedivisi;
                        $kddep =  $temp_prodmast[0]->prd_kodedepartement;
                        $kdkat =  $temp_prodmast[0]->prd_kodekategoribarang;
                        $pkmt =  0;
                        $mpkm = 0;

                    }
                    else
                    {
                        return response()->json([
                            'title' => 'success !',
                            'message' => ' PLU tidak ada di master prodmast !',
                            'status' => 'OK'
                        ], 200);
                    }
               }

                $ftngdla = $un['gdl_qty'];

                $check_tbtr_pkmgondola = DB::connection('simckl')->table('TBTR_PKMGONDOLA')
                ->where('PKMG_PRDCD',$un['plu_n'])
                ->get();

                $count_tbtr_pkmgondola = count($check_tbtr_pkmgondola);

                if($count_tbtr_pkmgondola == 0)
                {
                    $insert_tbtr_pkmgondola = DB::connection('simckl')->table('TBTR_PKMGONDOLA')
                    ->insert([
                        'PKMG_KODEIGR' => $kodeigr,
                        'PKMG_KODEDIVISI' => $kddiv,
                        'PKMG_KODEDEPARTEMENT' => $kddep ,
                        'PKMG_KODEKATEGORIBRG' => $kdkat,
                        'PKMG_PRDCD' => $un['plu_n'],
                        'PKMG_NILAIPKMG' => $pkmt + $ftngdla,
                        'PKMG_NILAIPKMB' => $pkmt + $ftngdla,
                        'PKMG_NILAIMPKM' => $mpkm,
                        'PKMG_NILAIPKMT' => $pkmt,
                        'PKMG_CREATE_DT' => Carbon::now(),
                        'PKMG_CREATE_BY' => $usid,
                        'PKMG_NILAIGONDOLA' => $ftngdla,
                        'PKMG_TGLAWALPKM' => $un['tgl_awal'],
                        'PKMG_TGLAKHIRPKM' =>  $un['tgl_akhir']
                    ]);

                }
                else{

                    $calculate_qty_gondola = DB::connection('simckl')->table('tbtr_gondola')
                    ->select(DB::raw('SUM(gdl_qty) AS gdl_qty'))
                    ->where('gdl_prdcd',$un['plu_n'])
                    ->get();

                    $ftngdla = $calculate_qty_gondola[0]->gdl_qty;
                    $update_gondola = DB::connection('simckl')
                    ->update("UPDATE TBTR_PKMGONDOLA
                    SET PKMG_NILAIPKMG = '".$pkmt."' + '".$ftngdla."',
                        PKMG_NILAIPKMB = '".$pkmt."' + '".$ftngdla."',
                        PKMG_NILAIMPKM = '".$mpkm."',
                        PKMG_NILAIPKMT = '".$pkmt."',
                        PKMG_MODIFY_DT = SYSDATE,
                        PKMG_MODIFY_BY = '".$usid."',
                        PKMG_NILAIGONDOLA = '".$ftngdla."',
                        PKMG_TGLAWALPKM =
                            CASE
                                WHEN PKMG_TGLAWALPKM < TO_DATE('".$un['tgl_awal']."','dd-mm-yyyy')
                                THEN
                                    PKMG_TGLAWALPKM
                                ELSE
                                TO_DATE('".$un['tgl_awal']."','dd-mm-yyyy')
                            END,
                        PKMG_TGLAKHIRPKM =
                            CASE
                                WHEN PKMG_TGLAKHIRPKM > TO_DATE('".$un['tgl_akhir']."','dd-mm-yyyy')
                                THEN
                                    PKMG_TGLAKHIRPKM
                                ELSE
                                TO_DATE('".$un['tgl_akhir']."','dd-mm-yyyy')
                            END
                    WHERE PKMG_PRDCD = '".$un['plu_n']."' AND PKMG_KODEIGR = '".$kodeigr."' ");
                }
            }
            else{
                return response()->json([
                    'title' => 'An error occurred !',
                    'message' => 'data gondola not exist',
                    'status' => 'error'
                ], 500);
            }
        }
        return response()->json([
            'title' => 'success !',
            'message' => ' Update Success !',
            'status' => 'OK'
        ], 200);
    }

    public function getDataDetailN(Request $request)
    {
        $data_join = DB::connection('simckl')
        ->select("SELECT prd_prdcd
                FROM tbmaster_prodmast, tbtr_pkmgondola
                WHERE prd_prdcd = pkmg_prdcd(+)
                AND prd_prdcd = '".$request->n_prdcd."' ");

        $count_join = count($data_join);

        if($count_join == 1)
        {
            $data_prod_pkm = DB::connection('simckl')
            ->select("SELECT prd_prdcd, prd_deskripsipanjang, NVL(pkmg_nilaigondola,0) AS pkmg_nilaigondola , NVL(pkmg_nilaipkmg,0) AS pkmg_nilaipkmg
                    FROM tbmaster_prodmast, tbtr_pkmgondola
                    WHERE prd_prdcd = pkmg_prdcd(+)
                    AND prd_prdcd = '".$request->n_prdcd."' ");

            $nd_prdcd = $data_prod_pkm[0]->prd_prdcd;
            $nd_deskripsi = $data_prod_pkm[0]->prd_deskripsipanjang;

            if($data_prod_pkm[0]->pkmg_nilaigondola == 0)
            {
                $nd_nilaigondola = '';
            }else{
                $nd_nilaigondola = $data_prod_pkm[0]->pkmg_nilaigondola;
            }

            if($data_prod_pkm[0]->pkmg_nilaipkmg == 0)
            {
                $nd_pkmg = '';
            }else{
                $nd_pkmg = $data_prod_pkm[0]->pkmg_nilaipkmg;
            }

            $check_kkpkm = DB::connection('simckl')->table('tbmaster_kkpkm')
            ->where('pkm_prdcd',$request->n_prdcd)
            ->get();

            $count_kkpkm = count($check_kkpkm);

            if($count_kkpkm > 0)
            {
                $data_kkpkm = DB::connection('simckl')
                ->select("SELECT pkm_pkmt, pkm_mpkm, nvl(pkm_qtymplus,0) AS pkm_qtymplus
                FROM tbmaster_kkpkm
                WHERE pkm_prdcd = '".$request->n_prdcd."' ");

                $nd_pkmt = $data_kkpkm[0]->pkm_pkmt;
                $nd_mpkm = $data_kkpkm[0]->pkm_mpkm;

                if($data_kkpkm[0]->pkm_qtymplus == 0)
                {
                    $nd_mplus = '';
                }
                else
                {
                    $nd_mplus = $data_kkpkm[0]->pkm_qtymplus;
                }


                return compact(['nd_prdcd','nd_deskripsi','nd_nilaigondola','nd_pkmg','nd_pkmt','nd_mpkm','nd_mplus']);

            }
            else
            {
                $nd_pkmt = '';
                $nd_mpkm = '';
                $nd_mplus = '';

                return compact(['nd_prdcd','nd_deskripsi','nd_nilaigondola','nd_pkmg','nd_pkmt','nd_mpkm','nd_mplus']);

            }
        }
        else{
            $nd_prdcd = '';
            $nd_deskripsi = '';
            $nd_nilaigondola = '';
            $nd_pkmg = '';
            $nd_pkmt = '';
            $nd_mpkm = '';
            $nd_mplus = '';

            return compact(['nd_prdcd','nd_deskripsi','nd_nilaigondola','nd_pkmg','nd_pkmt','nd_mpkm','nd_mplus']);

        }
    }

    public function uploadNPLUS()
    {
        $userid = Session::get('usid');
        $c = loginController::getConnectionProcedureCKL();
        $s = oci_parse($c, "BEGIN SP_UPLOAD_NPLUS_GO (:userid,:result); END;");
        oci_bind_by_name($s, ':userid',$userid) ;
        oci_bind_by_name($s, ':result', $result,1000);
        oci_execute($s);

        $today = Carbon::now()->format('Y-m-d_His');

        $FNAME = 'TLKNPLUS'.$today.'.txt';
        $file = fopen(storage_path($FNAME), "w");
        $this->txtFile[] = $FNAME;

        $linebuff = '';

        $data = DB::connection('simckl')
        ->select("SELECT NVL (COUNT (1), 0)
                  FROM TEMP_NPLUS_GO
                  WHERE NOT EXISTS
                    (
                        SELECT 1
                        FROM tbmaster_prodmast
                        WHERE plu = prd_prdcd
                    )
                ");

        $eof = count($data);


        if($eof > 0)
        {
           // header
            $linebuff = '';
            $linebuff = $linebuff. 'LIST PLU YANG TIDAK TERDAFTAR DI PRODMAST'. chr (13) .chr (10);
            $linebuff = $linebuff. chr (13) . chr (10);
            $linebuff = $linebuff. 'TANGGAL : ' . Carbon::now()->format('d-m-Y') . chr (13) .chr (10).'JAM : '.Carbon::now()->format('H:i:s'). chr (13) .chr (10);
            $linebuff = $linebuff. 'FILE : NPLUS_GO.CSV' . chr (13) .chr (10);
            $linebuff = $linebuff. chr (13) .chr (10) . '==========' . chr (13) .chr (10);

            $data_not_prodmast = DB::connection('simckl')
            ->select("SELECT PLU
                    FROM TEMP_NPLUS_GO
                    WHERE NOT EXISTS
                        (
                            SELECT 1
                            FROM tbmaster_prodmast
                            WHERE plu = prd_prdcd
                        )
                        ORDER BY plu

                    ");
            // body
            for($i=0 ; $i<sizeof($data_not_prodmast); $i++)
            {
                $linebuff = $linebuff.str_pad($data_not_prodmast[$i]->plu, 7, ' ',STR_PAD_RIGHT) . chr (13) . chr (10);
            }

            // footer
            $linebuff = $linebuff .'=========='. chr (13) .chr (10);
            fwrite($file,$linebuff);
            fclose($file);
        }

        if ($result == 'OK') {
            return response()->json([
                'title' => 'success !',
                'message' => ' Upload data gondola sukses !',
                'filename' => $FNAME,
                'status' => 'OK'
            ], 200);
        } else {
            return response()->json([
                'title' => 'An error occurred !',
                'message' => $result,
                'status' => 'error'
            ], 500);
        }
    }

    public function downloadTXT(Request $request){
        $filename = $request->filename;
        return response()->download(storage_path($filename))->deleteFileAfterSend(true);
    }

    public function filterKodeNPLUS(Request $request)
    {
        if($request->nf_kodedisplay !=NULL)
        {
            $kodedisplay = $request->nf_kodedisplay;

            $data = DB::connection('simckl')->table('tbtr_gondola')
            ->selectRaw("gdl_noperjanjiansewa,
            gdl_prdcd,
            gdl_kodedisplay,
            TO_CHAR(gdl_tglawal,'DD-MM-YYYY') AS gdl_tglawal,
            TO_CHAR(gdl_tglakhir,'DD-MM-YYYY') AS gdl_tglakhir,
            gdl_qty")
            ->where('gdl_kodedisplay','=',$kodedisplay)
            ->orderBy('gdl_noperjanjiansewa','ASC')
            ->get();

            return DataTables::of($data)->make(true);

        }
        else if($request->nf_kodedisplay ==NULL)
        {
            $data = DB::connection('simckl')->table('tbtr_gondola')
            ->selectRaw("gdl_noperjanjiansewa,
            gdl_prdcd,
            gdl_kodedisplay,
            TO_CHAR(gdl_tglawal,'DD-MM-YYYY') AS gdl_tglawal,
            TO_CHAR(gdl_tglakhir,'DD-MM-YYYY') AS gdl_tglakhir,
            gdl_qty")
            ->orderBy('gdl_noperjanjiansewa','ASC')
            ->get();

            return DataTables::of($data)->make(true);
        }
        else{

            return response()->json([
                'title' => 'An error occurred !',
                'message' => 'Data master N+ kosong !',
                'status' => 'error'
            ], 500);
        }
    }


    public function filterTanggalNPLUS(Request $request)
    {
        if($request->nf_tglawal !=NULL && $request->nf_tglakhir !=NULL)
        {
            // $tglAwal = $request->nf_tglawal;
            $tglAwal = DB::raw("TO_DATE('" . $request->nf_tglawal . "','dd/mm/yyyy')");
            $tglAkhir = DB::raw("TO_DATE('" . $request->nf_tglakhir . "','dd/mm/yyyy')");
            // $tglAkhir = $request->nf_tglakhir;

            $data = DB::connection('simckl')->table('tbtr_gondola')
            ->selectRaw("gdl_noperjanjiansewa,
            gdl_prdcd,
            gdl_kodedisplay,
            TO_CHAR(gdl_tglawal,'DD-MM-YYYY') AS gdl_tglawal,
            TO_CHAR(gdl_tglakhir,'DD-MM-YYYY') AS gdl_tglakhir,
            gdl_qty")
            ->where('gdl_tglawal','>=',$tglAwal)
            ->where('gdl_tglakhir','<=',$tglAkhir)
            ->orderBy('gdl_noperjanjiansewa','ASC')
            ->get();

            return DataTables::of($data)->make(true);

        }
        else if($request->nf_tglawal ==NULL && $request->nf_tglakhir ==NULL)
        {
            $data = DB::connection('simckl')->table('tbtr_gondola')
            ->selectRaw("gdl_noperjanjiansewa,
            gdl_prdcd,
            gdl_kodedisplay,
            TO_CHAR(gdl_tglawal,'DD-MM-YYYY') AS gdl_tglawal,
            TO_CHAR(gdl_tglakhir,'DD-MM-YYYY') AS gdl_tglakhir,
            gdl_qty")
            ->orderBy('gdl_noperjanjiansewa','ASC')
            ->get();

            return DataTables::of($data)->make(true);
        }
        else
        {
            return response()->json([
                'title' => 'An error occurred !',
                'message' => 'Data master N+ kosong !',
                'status' => 'error'
            ], 500);
        }
    }

    public function getDataTableM()
    {
        $data = DB::connection('simckl')->table('tbmaster_pkmplus')
        ->select(
        "PKMP_PRDCD",
        "PKMP_MPLUSI",
        "PKMP_MPLUSO",
        "PKMP_QTYMINOR AS pkmp_mplus")
        ->orderBy('PKMP_PRDCD','ASC')
        ->get();

        return DataTables::of($data)->make(true);
    }

    public function getDataDetail(Request $request)
    {
        $data = DB::connection('simckl')->table('tbmaster_prodmast')
        ->select('prd_prdcd', 'prd_deskripsipanjang', 'pkm_pkmt', 'pkm_mpkm')
        ->leftJoin('tbmaster_kkpkm','prd_prdcd','pkm_prdcd')
        ->where('prd_prdcd',$request->pkmp_prdcd)
        ->get();
        // ->select("SELECT prd_prdcd, prd_deskripsipanjang, pkm_pkmt, pkm_mpkm
        // FROM tbmaster_prodmast, tbmaster_kkpkm
        // WHERE prd_prdcd = pkm_prdcd(+)
        // AND prd_prdcd = '".$request->pkmp_prdcd."'
        // ");

        // dd($data);

        return response()->json($data);
    }

    public function searchPLU(Request $request)
    {

        $data_table = DB::connection('simckl')->table('tbmaster_pkmplus')
        ->select("PKMP_KODEIGR",
        "PKMP_PRDCD",
        "PKMP_MPLUSI",
        "PKMP_MPLUSO",
        DB::raw("PKMP_MPLUSI + PKMP_MPLUSO AS PKMP_MPLUS"))
        ->where('PKMP_PRDCD',$request->search_plu)
        ->get();

        $count_table = count($data_table);

        if($count_table == 1)
        {
            $data_table = DB::connection('simckl')->table('tbmaster_pkmplus')
            ->select("PKMP_KODEIGR",
            "PKMP_PRDCD",
            "PKMP_MPLUSI",
            "PKMP_MPLUSO",
            DB::raw("PKMP_MPLUSI + PKMP_MPLUSO AS PKMP_MPLUS"))
            ->where('PKMP_PRDCD',$request->search_plu)
            ->get();

            $data_detail = DB::connection('simckl')
            ->select("SELECT prd_prdcd, prd_deskripsipanjang, pkm_pkmt, pkm_mpkm
            FROM tbmaster_prodmast, tbmaster_kkpkm
            WHERE prd_prdcd = pkm_prdcd(+)
            AND prd_prdcd = '".$request->search_plu."'
            ");

            return response()->json($data_table,$data_detail);
        }
        else
        {
            return response()->json([
                'title' => 'An error occurred !',
                'message' => 'PLU tidak ditemukan !',
                'status' => 'error'
            ], 500);
        }
    }

    public function insertPLU(Request $request)
    {
        $check_prodmast = DB::connection('simckl')->table('TBMASTER_PRODMAST')
        ->select("PRD_PRDCD")
        ->where('PRD_PRDCD','=',$request->ma_prdcd)
        ->get();

        $count_prodmast = count($check_prodmast);

        if($count_prodmast == 1)
        {
            $data = DB::connection('simckl')
            ->select("select prd_kodedivisi, prd_kodedepartement, prd_kodekategoribarang
                    from tbmaster_prodmast
                    where prd_prdcd = '".$request->ma_prdcd."' ");

            $div = $data[0]->prd_kodedivisi;
            $dep = $data[0]->prd_kodedepartement;
            $kat = $data[0]->prd_kodekategoribarang;

            $check_pkmplus = DB::connection('simckl')->table('tbmaster_pkmplus')
            ->select('pkmp_prdcd')
            ->where('pkmp_prdcd',$request->ma_prdcd)
            ->get();

            $count_pkmplus = count($check_pkmplus);

            if($count_pkmplus > 0)
            {
                return response()->json([
                    'title' => 'An error occurred !',
                    'message' => 'PLU sudah ada !',
                    'status' => 'error'
                ], 500);
            }
            else{
                $kodeigr = '44';
                $usid = Session::get('usid');

                $insert_pkmplus = DB::connection('simckl')
                ->insert("INSERT INTO tbmaster_pkmplus (
                    PKMP_KODEIGR,
                    PKMP_KODEDIVISI,
                    PKMP_KODEDEPARTEMEN,
                    PKMP_KODEKATEGORIBRG,
                    PKMP_PRDCD,
                    PKMP_QTYMINOR,
                    PKMP_CREATE_BY,
                    PKMP_CREATE_DT,
                    PKMP_MPLUSI,
                    PKMP_MPLUSO
                    )
                    VALUES (
                    '".$kodeigr."',
                     '".$div."',
                     '".$dep."',
                     '".$kat."',
                     '".$request->ma_prdcd."',
                    nvl('".$request->ma_mplus_i."',0) + nvl('".$request->ma_mplus_o."',0) ,
                    '".$usid."',
                    SYSDATE,
                    nvl('".$request->ma_mplus_i."',0),
                    nvl('".$request->ma_mplus_o."',0)
                    )
                    ");

                $check_kkpkm = DB::connection('simckl')->table('tbmaster_kkpkm')
                ->select('pkm_prdcd')
                ->where('pkm_prdcd',$request->ma_prdcd)
                ->get();

                $count_kkpkm = count($check_kkpkm);

                if($count_kkpkm > 0)
                {
                    $update_kkpkm = DB::connection('simckl')
                    ->update("update tbmaster_kkpkm
                    set pkm_qtymplus = ( nvl('".$request->ma_mplus_i."',0) + nvl('".$request->ma_mplus_o."',0) ),
                            pkm_pkmt = pkm_mpkm + ( nvl('".$request->ma_mplus_i."',0) + nvl('".$request->ma_mplus_o."',0) )
                    where pkm_prdcd= '".$request->ma_prdcd."' ");


                    $select_kkpkm = DB::connection('simckl')
                    ->select("SELECT pkm_pkmt
                            FROM tbmaster_kkpkm
                            WHERE pkm_prdcd = '".$request->ma_prdcd."' ");

                    $select_pkmgondola = DB::connection('simckl')->table('tbtr_pkmgondola')
                    ->select("pkmg_prdcd")
                    ->where('pkmg_prdcd',$request->ma_prdcd)
                    ->get();

                    $count_pkmgondola = count($select_pkmgondola);

                    if($count_pkmgondola > 0)
                    {
                        $update_pkmgondola = DB::connection('simckl')
                        ->update("UPDATE tbtr_pkmgondola
                        SET PKMG_NILAIPKMG = nvl(v_pkmt,0) + PKMG_NILAIGONDOLA,
                        PKMG_NILAIPKMB = nvl(v_pkmt,0) + PKMG_NILAIGONDOLA,
                        PKMG_NILAIPKMT = nvl(v_pkmt,0)
                        WHERE PKMG_PRDCD = '".$request->ma_prdcd."' ");
                    }
                    else{
                        return response()->json([
                            'title' => 'success',
                            'message' => 'OK '
                        ], 200);
                    }
                }
                else{
                    return response()->json([
                        'title' => 'An error occurred !',
                        'message' => 'plu tidak ada di master kkpkm !',
                        'status' => 'error'
                    ], 500);
                }
            }
        }
        else{
            return response()->json([
                'title' => 'An error occurred !',
                'message' => 'PLU tidak terdaftar di master product !',
                'status' => 'error'
            ], 500);
        }
    }

    public function updateMplus(Request $request)
    {
        $usid = Session::get('usid');
        $today = Carbon::now();

        $update_mplus = $request->update_mplus;

        foreach($update_mplus as $u)
        {
            $data_pkmplus= DB::connection('simckl')->table('tbmaster_pkmplus')
            ->select("PKMP_KODEIGR",
            "PKMP_PRDCD",
            "PKMP_MPLUSI",
            "PKMP_MPLUSO",
            "PKMP_QTYMINOR")
            ->where('PKMP_PRDCD',$u['plu'])
            ->get();

            $count_table = count($data_pkmplus);

            if($count_table == 1)
            {

                $m_mplus = $u['m_i'] + $u['m_o'] ;

                $update_pkmplus = DB::connection('simckl')->table('tbmaster_pkmplus')->where('pkmp_prdcd',$u['plu'])
                ->update([
                    'pkmp_mplusi' => $u['m_i'] ,
                    'pkmp_mpluso' => $u['m_o'],
                    'pkmp_qtyminor' => $m_mplus,
                    'PKMP_MODIFY_DT' => $today,
                    'PKMP_MODIFY_BY' => $usid
                ]);


                $data_pkmplus= DB::connection('simckl')->table('tbmaster_kkpkm')
                ->where('pkm_prdcd',$u['plu'])
                ->get();

                $count_kkpkm = count($data_pkmplus);

                if($count_kkpkm > 0)
                {
                    $update_kkpkm = DB::connection('simckl')
                    ->update("UPDATE TBMASTER_KKPKM
                    SET PKM_QTYMPLUS = ".$m_mplus.",
                        PKM_PKMT = PKM_MPKM + ".$m_mplus.",
                        PKM_MODIFY_DT = SYSDATE,
                        PKM_MODIFY_BY = '".$usid."'
                    WHERE pkm_prdcd = '".$u['plu']."' ");


                    $data_kkpkm = DB::connection('simckl')->table('TBMASTER_KKPKM')
                    ->select('pkm_pkmt')
                    ->where('pkm_prdcd',$u['plu'])
                    ->get();

                    $v_pkmt = $data_kkpkm[0]->pkm_pkmt;

                    $data_tbtr_pkmgondola = DB::connection('simckl')->table('tbtr_pkmgondola')
                    ->where('pkmg_prdcd',$u['plu'])
                    ->get();

                    $count_tbtr_pkmgondola = count($data_tbtr_pkmgondola);

                    if($count_tbtr_pkmgondola > 0)
                    {
                        $update_tbtr_pkmgondola = DB::connection('simckl')
                        ->update("UPDATE tbtr_pkmgondola
                        SET PKMG_NILAIPKMG = nvl('".$v_pkmt."',0) + PKMG_NILAIGONDOLA,
                        PKMG_NILAIPKMB = nvl('".$v_pkmt."',0) + PKMG_NILAIGONDOLA,
                        PKMG_NILAIPKMT = nvl('".$v_pkmt."',0)
                        WHERE PKMG_PRDCD = '".$u['plu']."' ");

                        //ENDIF
                    }

                }
                else{
                    return response()->json([
                        'title' => 'An error occurred !',
                        'message' => 'plu '.$u['plu'].' tidak ada di master kkpkm',
                        'status' => 'error'
                    ], 500);
                }

            }else{
                //ENDIF
            }

        }

        return response()->json([
            'title' => 'success',
            'message' => 'OK',
        ], 200);

    }

    public function uploadMPLUS()
    {
        $userid = Session::get('usid');
        $c = loginController::getConnectionProcedureCKL();
        $s = oci_parse($c, "BEGIN SP_UPLOAD_MPLUS_GO (:userid,:result); END;");
        oci_bind_by_name($s, ':userid',$userid) ;
        oci_bind_by_name($s, ':result', $result,1000);
        oci_execute($s);

        if ($result == 'OK') {
            return response()->json([
                'title' => 'success !',
                'message' => ' file MPLUS_GO.csv berhasil diupload !',
                'status' => 'OK'
            ], 200);
        } else {
            return response()->json([
                'title' => 'An error occurred !',
                'message' => $result,
                'status' => 'error'
            ], 500);
        }
    }

}
