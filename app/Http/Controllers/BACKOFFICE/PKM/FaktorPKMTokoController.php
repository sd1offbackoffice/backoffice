<?php

namespace App\Http\Controllers\BACKOFFICE\PKM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Auth\loginController;
use Carbon\Carbon;

class FaktorPKMTokoController extends Controller
{
    public function index()
    {
        $datas = DB::connection('simckl')->table('tbmaster_pkmplus')
        ->select("PKMP_KODEIGR",
        "PKMP_PRDCD",
        "PKMP_MPLUSI",
        "PKMP_MPLUSO",
        DB::raw("PKMP_MPLUSI + PKMP_MPLUSO AS PKMP_MPLUS"))
        ->limit(100)
        ->where('PKMP_MPLUSO','>','0')
        ->get();

        return view('BACKOFFICE.PKM.faktor-pkm-toko',compact('datas'));
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
        ->limit(1000)
        ->orderBy('gdl_noperjanjiansewa','ASC')
        ->get();

        return DataTables::of($data)->make(true);
    }

    public function insertPerjanjian(Request $request)
    {
        $kodeigr = Session::get('kdigr');
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

            dd($count_tbtr_gondola);

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
                
                $insert_tbtr_gondola = DB::connection('simckl')
                ->insert("INSERT INTO tbtr_gondola 
                        (
                            gdl_kodeigr,
                            gdl_noperjanjiansewa,
                            gdl_prdcd,
                            gdl_qty,
                            gdl_kodecabang,
                            gdl_kodedisplay,
                            gdl_tglawal,
                            gdl_tglakhir,
                            gdl_create_by,
                            gdl_create_dt
                        )
                        VALUES 
                        ( 
                            '".$kodeigr."',
                            '".$request->na_noperjanjian."',
                            '".$request->na_prdcd."',
                            '".$request->na_qty."',
                            '".$kodeigr."',
                            '".$request->kodedisplay."',
                            '".$request->kodedisplay."',
                            '".$request->na_tglawal."',
                            '".$request->na_tglakhir."',
                            '".$usid."',
                            SYSDATE)
                        ");

                $check_kkpkm = DB::connection('simckl')->table('tbmaster_kkpkm')
                ->where('pkm_prdcd',$request->na_prdcd)
                ->get();
            
                $count_kkpkm = count($check_kkpkm);

                if($count_kkpkm > 1)
                {
                    $select_kkpkm = DB::connection('simckl')
                    ->select("SELECT 
                    PKM_KODEDIVISI
                    PKM_KODEDEPARTEMENT,
                    PKM_KODEKATEGORIBARANG,
                    PKM_PKMT,
                    PKM_MPKM
                    FROM tbmaster_kkpkm
                    WHERE pkm_prdcd = '".$request->na_prdcd."'");

                    $kkdiv = $select_kkpkm[0]->PKM_KODEDIVISI;
                    $kddep = $select_kkpkm[0]->PKM_KODEDEPARTEMENT;
                    $kdkat = $select_kkpkm[0]->PKM_KODEKATEGORIBARANG;
                    $pkmt = $select_kkpkm[0]->PKM_PKMT;
                    $mpkm = $select_kkpkm[0]->PKM_MPKM;

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

                $count_gondola = count($loop_gondola);

                for($i = 0; $i <= $count_gondola; $i++)
                {
                    $adagdl = true;
                    $ftngdla = $ftngdla + $loop_gondola[$i];  
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
                        
                        $insert_tbtr_pkmgondola = DB::connection('simckl')
                        ->insert(" INSERT INTO TBTR_PKMGONDOLA 
                        (
                            PKMG_KODEIGR,
                            PKMG_KODEDIVISI,
                            PKMG_KODEDEPARTEMENT,
                            PKMG_KODEKATEGORIBRG,
                            PKMG_PRDCD,
                            PKMG_NILAIPKMG,
                            PKMG_NILAIPKMB,
                            PKMG_NILAIMPKM,
                            PKMG_NILAIPKMT,
                            PKMG_CREATE_DT,
                            PKMG_CREATE_BY,
                            PKMG_NILAIGONDOLA,
                            PKMG_TGLAWALPKM,
                            PKMG_TGLAKHIRPKM
                        )
                        VALUES ( 
                        '".$kodeigr."',
                        '".$kkdiv."',
                        '".$kddep."',
                        '".$kdkat."',
                        '".$request->na_prdcd."',
                        '".$pkmt."' + '".$ftngdla."',
                        '".$pkmt."' + '".$ftngdla."',
                        '".$mpkm."',
                        '".$pkmt."',
                        SYSDATE,
                        '".$usid."',
                        '".$ftngdla."',
                        '".$request->na_tglawal."',
                        '".$request->na_tglakhir."'
                        )
                        ");
                        
                        return response()->json([
                            'title' => 'success !',
                            'message' => ' Upload data gondola sukses !',
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

        if ($result == 'OK') {
            return response()->json([
                'title' => 'success !',
                'message' => ' Upload data gondola sukses !',
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

    public function getDataTableM()
    {
        $data = DB::connection('simckl')->table('tbmaster_pkmplus')
        ->select(
        "PKMP_PRDCD",
        "PKMP_MPLUSI",
        "PKMP_MPLUSO",
        "PKMP_QTYMINOR AS pkmp_mplus")
        ->limit(100)
        ->orderBy('PKMP_PRDCD','ASC')
        ->get();

        return DataTables::of($data)->make(true);
    }

    public function getDataDetail(Request $request)
    {
        $data = DB::connection('simckl')
        ->select("SELECT prd_prdcd, prd_deskripsipanjang, pkm_pkmt, pkm_mpkm
        FROM tbmaster_prodmast, tbmaster_kkpkm
        WHERE prd_prdcd = pkm_prdcd(+)
        AND prd_prdcd = '".$request->pkmp_prdcd."'
        ");

        // return $data;
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

        // dd($check_prodmast, $count_prodmast);

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
                $kodeigr = Session::get('kdigr');
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

        // dd($update_mplus);

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
