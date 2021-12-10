<?php

namespace App\Http\Controllers\BACKOFFICE;

use Carbon\Carbon;
use http\Env\Response;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller; use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;
use PDF;
use Yajra\DataTables\DataTables;

class InputPertemananController extends Controller
{
    public function index(){
        return view('BACKOFFICE.input-pertemanan');
    }

    public function getLovPrdcd(){
        $data = DB::connection(Session::get('connection'))->select("select prd_deskripsipanjang desk, prd_prdcd plu, prd_unit || '/' || prd_frac satuan from tbmaster_prodmast
            where prd_kodeigr = '".Session::get('kdigr')."'
            and substr(prd_Prdcd,7,1) = '0'
            order by prd_deskripsipanjang");

        return DataTables::of($data)->make(true);
    }

    public function getData(Request $request){
        $prdcd = $request->prdcd;

        $plu = DB::connection(Session::get('connection'))->table('tbmaster_prodmast')
            ->selectRaw("prd_deskripsipanjang desk, prd_prdcd plu, prd_unit || '/' || prd_frac satuan")
            ->where('prd_kodeigr','=',Session::get('kdigr'))
            ->where('prd_prdcd','=',$prdcd)
            ->first();

        if(!$plu){
            return response()->json(['title' => 'PLU tidak terdaftar!'],500);
        }

        $temp = DB::connection(Session::get('connection'))->table('tbmaster_maxpalet')
            ->where('mpt_prdcd','=',$prdcd)
            ->first();

        $maxqty = $temp ? $temp->mpt_maxqty : 0;

        $lokasi = DB::connection(Session::get('connection'))->table('tbmaster_lokasi')
            ->selectRaw("lks_tiperak, lks_koderak, lks_kodesubrak, lks_shelvingrak, lks_nourut, lks_qty, to_char(lks_expdate,'dd/mm/yyyy') lks_expdate")
            ->where('lks_kodeigr','=',Session::get('kdigr'))
            ->whereRaw("substr(lks_prdcd,1,6) = substr('".$prdcd."',1,6)")
            ->orderByRaw('lks_tiperak, lks_koderak, lks_kodesubrak, lks_shelvingrak, lks_nourut')
            ->get();

        $temp = DB::connection(Session::get('connection'))->select("SELECT *
                    FROM TBMASTER_PLANO
                    WHERE PLA_PRDCD = '".$prdcd."' AND PLA_KODERAK LIKE '%C'");


        if(count($temp) > 0){
            $isSubrak = true;
            $select = 'select pla_nourut, pla_koderak, pla_subrak, pla_prdcd from tbmaster_plano';
        }
        else{
            $isSubrak = false;
            $select = "select min (pla_nourut) pla_nourut, pla_koderak, pla_prdcd, '' pla_subrak from tbmaster_plano group by pla_koderak, pla_prdcd";
        }

        $plano = DB::connection(Session::get('connection'))->select("select *
            from(".$select.")
            where pla_prdcd = '".$prdcd."'
            order by pla_nourut");

        return compact(['plu','maxqty','lokasi','plano','isSubrak']);
    }

    public function deletePlano(Request $request){
        $prdcd = $request->prdcd;
        $koderak = $request->koderak;
        $subrak = $request->subrak;

        try{
            DB::connection(Session::get('connection'))->beginTransaction();

            if(substr($koderak, -1) == 'C'){
                DB::connection(Session::get('connection'))->table('tbmaster_plano')
                    ->where('pla_prdcd','=',$prdcd)
                    ->where('pla_koderak','=',$koderak)
                    ->where('pla_subrak','=',$subrak)
                    ->delete();
            }
            else{
                DB::connection(Session::get('connection'))->table('tbmaster_plano')
                    ->where('pla_prdcd','=',$prdcd)
                    ->where('pla_koderak','=',$koderak)
                    ->delete();
            }

            DB::connection(Session::get('connection'))->commit();

            return response()->json([
                'title' => 'Berhasil menghapus data!'
            ],200);
        }
        catch (QueryException $e){
            DB::connection(Session::get('connection'))->rollBack();

            return response()->json([
                'title' => 'Gagal menghapus data!'
            ],500);
        }
    }

    public function getLastNumber(Request $request){
        $temp = DB::connection(Session::get('connection'))->table('tbmaster_plano')
            ->selectRaw("max(pla_nourut) nourut")
            ->where('pla_prdcd','=',$request->prdcd)
            ->first();

        if(!$temp)
            $nourut = 1;
        else $nourut = $temp->nourut + 1;

        return $nourut;
    }

    public function addPlano(Request $request){
        $prdcd = $request->prdcd;
        $nourut = $request->nourut;
        $koderak = $request->koderak;
        $subrak = $request->subrak;
        $isSubrak = $request->isSubrak;

        if($isSubrak == 'false'){
            $temp = DB::connection(Session::get('connection'))->table('tbmaster_plano')
                ->where('pla_prdcd','=',$prdcd)
                ->where('pla_koderak','=',$koderak)
                ->first();

            if($temp){
                return response()->json([
                    'title' => 'Kode rak sudah ada dalam pertemanan!'
                ], 500);
            }

            $temp = DB::connection(Session::get('connection'))->select("select *
                    from tbmaster_lokasi
                      WHERE LKS_JENISRAK LIKE 'S%'
                        AND NOT EXISTS (SELECT 1
                                          FROM TBMASTER_PLANO
                                         WHERE PLA_PRDCD = '".$prdcd."' AND PLA_KODERAK = LKS_KODERAK)
                        and lks_koderak = '".$koderak."'");

            if(count($temp) == 0){
                return response()->json([
                    'title' => 'Data kode rak tidak valid!'
                ], 500);
            }

            DB::connection(Session::get('connection'))->table('tbmaster_plano')
                ->insert([
                    'pla_prdcd' => $prdcd,
                    'pla_nourut' => $nourut,
                    'pla_koderak' => $koderak,
                    'pla_subrak' => '01',
                    'pla_create_by' => Session::get('usid'),
                    'pla_create_dt' => DB::RAW("SYSDATE"),
                ]);

            return response()->json([
                'title' => 'Pertemanan untuk PLU '.$prdcd.' berhasil ditambahkan!'
            ], 200);
        }
        else{
            $temp = DB::connection(Session::get('connection'))->table('tbmaster_plano')
                ->where('pla_prdcd','=',$prdcd)
                ->where('pla_koderak','=',$koderak)
                ->where('pla_subrak','=',$subrak)
                ->first();

            if($temp){
                return response()->json([
                    'title' => 'Kode rak sudah ada dalam pertemanan!'
                ], 500);
            }

            $temp = DB::connection(Session::get('connection'))->table('tbmaster_lokasi')
                ->where('lks_koderak','=',$koderak)
                ->where('lks_kodesubrak','=',$subrak)
                ->first();

            if($temp){
                return response()->json([
                    'title' => 'Lokasi tidak valid!'
                ], 500);
            }

            DB::connection(Session::get('connection'))->table('tbmaster_plano')
                ->insert([
                    'pla_prdcd' => $prdcd,
                    'pla_nourut' => $nourut,
                    'pla_koderak' => $koderak,
                    'pla_subrak' => $subrak,
                    'pla_create_by' => Session::get('usid'),
                    'pla_create_dt' => DB::RAW("SYSDATE"),
                ]);

            return response()->json([
                'title' => 'Pertemanan untuk PLU '.$prdcd.' berhasil ditambahkan!'
            ], 200);
        }
    }

    public function getLovKoderak(Request $request){
        $prdcd = $request->prdcd;
        $isSubrak = $request->isSubrak;

        if($isSubrak == 'true'){
            $data = DB::connection(Session::get('connection'))->select("SELECT DISTINCT LKS_KODERAK, LKS_KODESUBRAK
           FROM TBMASTER_LOKASI, (SELECT COUNT (1) JML
                                    FROM TBMASTER_PLANO
                                   WHERE PLA_PRDCD = '".$prdcd."')
          WHERE LKS_JENISRAK LIKE 'S%'
            AND NOT EXISTS (SELECT 1
                              FROM TBMASTER_GROUPRAK
                             WHERE GRR_KODERAK = LKS_KODERAK)
            AND NOT EXISTS (
                    SELECT 1
                      FROM TBMASTER_PLANO
                     WHERE PLA_PRDCD = '".$prdcd."'
                       AND PLA_KODERAK = LKS_KODERAK
                       AND PLA_SUBRAK = LKS_KODESUBRAK)
            AND CASE
                    WHEN SUBSTR (LKS_KODERAK, -1, 1) = 'C'
                        THEN 'C'
                    ELSE 'A'
                END LIKE
                    CASE
                        WHEN JML = 0
                            THEN '%'
                        ELSE (SELECT CASE
                                         WHEN SUBSTR (PLA_KODERAK, -1, 1) = 'C'
                                             THEN 'C'
                                         ELSE 'A'
                                     END
                                FROM TBMASTER_PLANO
                               WHERE PLA_PRDCD = '".$prdcd."' AND PLA_NOURUT = '1')
                    END
       ORDER BY LKS_KODERAK, LKS_KODESUBRAK");
        }
        else{
            $data = DB::connection(Session::get('connection'))->select("SELECT DISTINCT LKS_KODERAK
                   FROM TBMASTER_LOKASI, (SELECT COUNT (1) JML
                                            FROM TBMASTER_PLANO
                                           WHERE PLA_PRDCD = '".$prdcd."')
                  WHERE LKS_JENISRAK LIKE 'S%'
                    /*AND NOT EXISTS (SELECT 1
                                      FROM TBMASTER_GROUPRAK
                                     WHERE GRR_KODERAK = LKS_KODERAK)*/
                    AND NOT EXISTS (SELECT 1
                                      FROM TBMASTER_PLANO
                                     WHERE PLA_PRDCD = '".$prdcd."' AND PLA_KODERAK = LKS_KODERAK)
                    AND CASE
                            WHEN SUBSTR (LKS_KODERAK, -1, 1) = 'C'
                                THEN 'C'
                            ELSE 'A'
                        END LIKE
                            CASE
                                WHEN JML = 0
                                    THEN '%'
                                ELSE (SELECT CASE
                                                 WHEN SUBSTR (PLA_KODERAK, -1, 1) = 'C'
                                                     THEN 'C'
                                                 ELSE 'A'
                                             END
                                        FROM TBMASTER_PLANO
                                       WHERE PLA_PRDCD = '".$prdcd."' AND PLA_NOURUT = '1')
                            END
               ORDER BY LKS_KODERAK");
        }

        return DataTables::of($data)->make(true);
    }

    public function swapPlano(Request $request){
        $prdcd = $request->prdcd;
        $plano1 = $request->plano1;
        $plano2 = $request->plano2;

        try{
            DB::connection(Session::get('connection'))->beginTransaction();

            if(substr($plano1['pla_koderak'],-1) == 'C'){
                DB::connection(Session::get('connection'))->table('tbmaster_plano')
                    ->where('pla_prdcd','=',$prdcd)
                    ->where('pla_nourut','=',$plano1['pla_nourut'])
                    ->update([
                        'pla_koderak' => $plano2['pla_koderak'],
                        'pla_subrak' => $plano2['pla_subrak'],
                        'pla_modify_by' => Session::get('usid'),
                        'pla_modify_dt' => DB::RAW("SYSDATE")
                    ]);

                DB::connection(Session::get('connection'))->table('tbmaster_plano')
                    ->where('pla_prdcd','=',$prdcd)
                    ->where('pla_nourut','=',$plano2['pla_nourut'])
                    ->update([
                        'pla_koderak' => $plano1['pla_koderak'],
                        'pla_subrak' => $plano1['pla_subrak'],
                        'pla_modify_by' => Session::get('usid'),
                        'pla_modify_dt' => DB::RAW("SYSDATE")
                    ]);
            }
            else{
                DB::connection(Session::get('connection'))->table('tbmaster_plano')
                    ->where('pla_prdcd','=',$prdcd)
                    ->where('pla_koderak','=',$plano1['pla_koderak'])
                    ->update([
                        'pla_nourut' => $plano2['pla_nourut'],
                        'pla_modify_by' => Session::get('usid'),
                        'pla_modify_dt' => DB::RAW("SYSDATE")
                    ]);

                DB::connection(Session::get('connection'))->table('tbmaster_plano')
                    ->where('pla_prdcd','=',$prdcd)
                    ->where('pla_koderak','=',$plano2['pla_koderak'])
                    ->update([
                        'pla_nourut' => $plano1['pla_nourut'],
                        'pla_modify_by' => Session::get('usid'),
                        'pla_modify_dt' => DB::RAW("SYSDATE")
                    ]);

                DB::connection(Session::get('connection'))->update("UPDATE TBMASTER_PLANO B
           SET PLA_NOURUT = (SELECT RN
                               FROM (SELECT ROWNUM RN, PLA_KODERAK, PLA_SUBRAK
                                       FROM (SELECT   PLA_KODERAK, PLA_SUBRAK
                                                 FROM TBMASTER_PLANO
                                                WHERE PLA_PRDCD = '".$prdcd."'
                                             ORDER BY PLA_NOURUT)) A
                              WHERE A.PLA_KODERAK = B.PLA_KODERAK AND A.PLA_SUBRAK = B.PLA_SUBRAK)
         WHERE PLA_PRDCD = '".$prdcd."'");
            }

            DB::connection(Session::get('connection'))->commit();

            return response()->json(['title' => 'Berhasil menukar data pertemanan!'],200);
        }
        catch(QueryException $e){
            DB::connection(Session::get('connection'))->rollBack();

            return response()->json(['title' => 'Gagal menukar data pertemanan!'],500);
        }
    }
}
