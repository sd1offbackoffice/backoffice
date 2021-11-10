<?php

namespace App\Http\Controllers\TABEL;

use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;
use PDF;
use Yajra\DataTables\DataTables;

class MonitoringProdukController extends Controller
{
    public function index(){
        return view('TABEL.monitoring-produk');
    }

    public function getLovMonitoring(){
        $data = DB::connection($_SESSION['connection'])->table('tbtr_monitoringplu')
            ->selectRaw("mpl_kodemonitoring kode, mpl_namamonitoring nama")
            ->whereNotNull('mpl_kodemonitoring')
            ->distinct()
            ->get();

        return DataTables::of($data)->make(true);
    }

    public function getMonitoring(Request $request){
        if(!in_array($request->kode, ['F1','F2','NF1','NF2','O','G','SM','SJMF','SJMNF','SPVF','SPVNF','SPVGMS'])){
            return response()->json([
                'message' => 'Kode monitoring tidak valid!'
            ], 500);
        }
        else{
            $data = DB::connection($_SESSION['connection'])->table('tbtr_monitoringplu')
                ->select('mpl_namamonitoring')
                ->where('mpl_kodeigr','=',$_SESSION['kdigr'])
                ->where('mpl_kodemonitoring','=',$request->kode)
                ->first();

            if(!$data){
                return response()->json([
                    'message' => 'Kode monitoring tidak terdaftar!'
                ], 500);
            }
            else{
                return response()->json([
                    'nama' => $data->mpl_namamonitoring
                ], 200);
            }
        }
    }

    public function getLovPLU(Request $request){
        $search = $request->plu;

        if($search == ''){
            $produk = DB::connection($_SESSION['connection'])->table(DB::RAW("tbmaster_prodmast"))
                ->selectRaw("prd_prdcd,prd_deskripsipanjang, prd_unit || '/' || prd_frac satuan")
                ->where('prd_kodeigr',$_SESSION['kdigr'])
                ->whereRaw("substr(prd_prdcd,7,1) = '0'")
                ->orderBy('prd_prdcd')
                ->limit(100)
                ->get();
        }
        else if(is_numeric($search)){
            $produk = DB::connection($_SESSION['connection'])->table(DB::RAW("tbmaster_prodmast"))
                ->selectRaw("prd_prdcd,prd_deskripsipanjang, prd_unit || '/' || prd_frac satuan")
                ->where('prd_kodeigr',$_SESSION['kdigr'])
                ->whereRaw("substr(prd_prdcd,7,1) = '0'")
                ->where('prd_prdcd','like',DB::RAW("'%".$search."%'"))
                ->orderBy('prd_prdcd','asc')
                ->get();
        }
        else{
            $produk = DB::connection($_SESSION['connection'])->table(DB::RAW("tbmaster_prodmast"))
                ->selectRaw("prd_prdcd,prd_deskripsipanjang, prd_unit || '/' || prd_frac satuan")
                ->where('prd_kodeigr',$_SESSION['kdigr'])
                ->whereRaw("substr(prd_prdcd,7,1) = '0'")
                ->where('prd_deskripsipanjang','like',DB::RAW("'%".$search."%'"))
                ->orderBy('prd_prdcd','asc')
                ->get();
        }

        return DataTables::of($produk)->make(true);
    }

    public function getData(Request $request){
        if(!in_array($request->kode, ['F1','F2','NF1','NF2','O','G','SM','SJMF','SJMNF','SPVF','SPVNF','SPVGMS'])){
            return response()->json([
                'message' => 'Kode monitoring tidak valid!'
            ], 500);
        }
        else{
            $data = DB::connection($_SESSION['connection'])->select("SELECT mpl_prdcd plu, SUBSTR(PRD_DESKRIPSIPANJANG,1,60) DESKRIPSI, PRD_UNIT||'/'||PRD_FRAC SATUAN
					FROM TBMASTER_PRODMAST, tbtr_monitoringplu, tbmaster_maxpalet
					WHERE PRD_PRDCD(+) = mpl_prdcd AND MPT_PRDCD(+) = PRD_PRDCD
					AND mpl_kodemonitoring = '".$request->kode."'
					ORDER BY mpl_prdcd");

            return DataTables::of($data)->make(true);
        }
    }

    public function addData(Request $request){
        try{
            DB::connection($_SESSION['connection'])->beginTransaction();

            $temp = DB::connection($_SESSION['connection'])
                ->selectOne("select * from (
                    SELECT prd_kodeigr kdigr, prd_prdcd prdcd FROM TBMASTER_PRODMAST
                    UNION
                    SELECT mpl_kodeigr kdigr, mpl_prdcd prdcd FROM TBTR_MONITORINGPLU
                    where mpl_kodemonitoring = '".$request->mon_kode."'
				)
                where kdigr = '".$_SESSION['kdigr']."'
                  and prdcd = '".$request->plu."'");

            if(!$temp){
                return response()->json([
                    'message' => 'Kode tidak terdaftar!'
                ], 500);
            }
            else{
                DB::connection($_SESSION['connection'])
                    ->table('tbtr_monitoringplu')
                    ->insert([
                        'mpl_kodeigr' => $_SESSION['kdigr'],
                        'mpl_kodemonitoring' => $request->mon_kode,
                        'mpl_namamonitoring' => $request->mon_nama,
                        'mpl_prdcd' => $request->plu,
                        'mpl_create_by' => $_SESSION['usid'],
                        'mpl_create_dt' => Carbon::now()
                    ]);
            }

            DB::connection($_SESSION['connection'])->commit();

            return response()->json([
                'message' => 'PLU sudah masuk ke kode monitoring '.$request->mon_kode.' !'
            ], 200);
        }
        catch(\Exception $e){
            DB::connection($_SESSION['connection'])->rollBack();

            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function deleteData(Request $request){
        try{
            DB::connection($_SESSION['connection'])->beginTransaction();

            $temp = DB::connection($_SESSION['connection'])
                ->selectOne("select * from (
                    SELECT prd_kodeigr kdigr, prd_prdcd prdcd FROM TBMASTER_PRODMAST
                    UNION
                    SELECT mpl_kodeigr kdigr, mpl_prdcd prdcd FROM TBTR_MONITORINGPLU
                    where mpl_kodemonitoring = '".$request->mon_kode."'
				)
                where kdigr = '".$_SESSION['kdigr']."'
                  and prdcd = '".$request->plu."'");

            if(!$temp){
                return response()->json([
                    'message' => 'Kode tidak terdaftar!'
                ], 500);
            }
            else{
                $temp = DB::connection($_SESSION['connection'])
                    ->table('tbtr_monitoringplu')
                    ->where('mpl_kodemonitoring','=',$request->mon_kode)
                    ->where('mpl_namamonitoring','=',$request->mon_nama)
                    ->where('mpl_prdcd','=',$request->plu)
                    ->delete();

                DB::connection($_SESSION['connection'])->commit();

                if($temp == 0){
                    return response()->json([
                        'message' => 'PLU tidak ada dalam kode monitoring '.$request->mon_kode.' !'
                    ], 500);
                }
                else{
                    return response()->json([
                        'message' => 'PLU '.$request->mon_kode.' berhasil dihapus!'
                    ], 200);
                }
            }
        }
        catch(\Exception $e){
            DB::connection($_SESSION['connection'])->rollBack();

            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function print(Request $request){
        $perusahaan = DB::connection($_SESSION['connection'])
            ->table("tbmaster_perusahaan")
            ->first();

        $monitoring = DB::connection($_SESSION['connection'])
            ->table('tbtr_monitoringplu')
            ->selectRaw("mpl_kodemonitoring kode, mpl_namamonitoring nama")
            ->where('mpl_kodemonitoring','=',$request->mon)
            ->first();

        $data = DB::connection($_SESSION['connection'])
            ->select("SELECT mpl_kodemonitoring, mpl_namamonitoring, mpl_prdcd, prd_deskripsipanjang,
                prd_unit||'/'||prd_frac satuan, prd_kodetag
                FROM TBTR_MONITORINGPLU, TBMASTER_PRODMAST
                WHERE translate(mpl_kodemonitoring,' ','_') = '".$request->mon."'
                AND prd_prdcd(+) = mpl_prdcd
                AND mpl_kodeigr = '".$_SESSION['kdigr']."'
                ORDER BY mpl_prdcd");

        return view('TABEL.monitoring-produk-pdf',compact(['perusahaan','data','monitoring']));
    }
}
