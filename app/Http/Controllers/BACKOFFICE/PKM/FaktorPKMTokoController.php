<?php

namespace App\Http\Controllers\BACKOFFICE\PKM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class FaktorPKMTokoController extends Controller
{
    public function index()
    {
        $datas = DB::connection(Session::get('connection'))->table('tbmaster_pkmplus')
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

    public function getDataTableM()
    {
        $data = DB::connection(Session::get('connection'))->table('tbmaster_pkmplus')
        ->select("PKMP_KODEIGR",
        "PKMP_PRDCD",
        "PKMP_MPLUSI",
        "PKMP_MPLUSO",
        DB::raw("PKMP_MPLUSI + PKMP_MPLUSO AS PKMP_MPLUS"))
        ->limit(100)
        ->orderBy('PKMP_PRDCD','ASC')
        ->get();

        return DataTables::of($data)->make(true);
    }

    public function getDataDetail(Request $request)
    {
        $data = DB::connection(Session::get('connection'))
        ->select("SELECT prd_prdcd, prd_deskripsipanjang, pkm_pkmt, pkm_mpkm
        FROM tbmaster_prodmast, tbmaster_kkpkm
        WHERE prd_prdcd = pkm_prdcd(+)
        AND prd_prdcd = '".$request->pkmp_prdcd."' 
        ");
       
        // return $data;
        return response()->json($data);
    }

    public function insertPLU(Request $request)
    {
        $check_prodmast = DB::connection(Session::get('connection'))->table('tbmaster_prodmast')
        ->select('pkmp_prdcd')
        ->where('prd_prdcd',$request->ma_prdcd)
        ->get();
      
        $count_prodmast = count($check_prodmast);

        dd($check_prodmast, $count_prodmast);

        if($count_prodmast == 1)
        {
            $data = DB::connection(Session::get('connection'))
            ->select("select prd_kodedivisi, prd_kodedepartement, prd_kodekategoribarang 
                    into div, dep, kat
                    from tbmaster_prodmast
                    where prd_prdcd = '".$request->ma_prdcd."' ");

            $check_pkmplus = DB::connection(Session::get('connection'))->table('tbmaster_pkmplus')
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

                $insert_pkmplus = DB::connection(Session::get('connection'))
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
                    PKMP_MPLUSO)
                    VALUES ( 
                    $kodeigr,
                    div, 
                    dep, 
                    kat,
                    :ma_prdcd,
                    nvl('".$request->ma_mplus_i."',0) + nvl('".$request->ma_mplus_o."',0) ,
                    $usid,
                    SYSDATE,
                    nvl('".$request->ma_mplus_i."',0),
                    nvl('".$request->ma_mplus_o."',0) )");

                $check_kkpkm = DB::connection(Session::get('connection'))->table('tbmaster_kkpkm')
                ->select('pkm_prdcd')
                ->where('pkm_prdcd',$request->ma_prdcd)
                ->get();
                
                $count_kkpkm = count($check_kkpkm);

                if($count_kkpkm > 0)
                {
                    $update_kkpkm = DB::connection(Session::get('connection'))
                    ->update("update tbmaster_kkpkm
                    set pkm_qtymplus = ( nvl('".$request->ma_mplus_i."',0) + nvl('".$request->ma_mplus_o."',0) ),
                            pkm_pkmt = pkm_mpkm + ( nvl('".$request->ma_mplus_i."',0) + nvl('".$request->ma_mplus_o."',0) )
                    where pkm_prdcd= '".$request->ma_prdcd."' ");
                   
                    
                    $select_kkpkm = DB::connection(Session::get('connection'))
                    ->select("SELECT pkm_pkmt
                            INTO v_pkmt
                            FROM tbmaster_kkpkm
                            WHERE pkm_prdcd = '".$request->ma_prdcd."' ");

                    $select_pkmgondola = DB::connection(Session::get('connection'))->table('tbtr_pkmgondola')
                    ->select("pkmg_prdcd")
                    ->where('pkmg_prdcd',$request->ma_prdcd)
                    ->get();

                    $count_pkmgondola = count($select_pkmgondola);

                    if($count_pkmgondola > 0)
                    {
                        $update_pkmgondola = DB::connection(Session::get('connection'))
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
}
