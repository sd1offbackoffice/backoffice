<?php

namespace App\Http\Controllers\BARANGHADIAH\MASTER;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;

class BarangHadiahController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('BARANGHADIAH.MASTER.barang-hadiah');
    }

    public function getProduk()
    {
        $kodeigr = Session::get('kdigr');

        $datas = DB::connection(Session::get('connection'))
        ->select("SELECT  
            PRD_PRDCD, 
            PRD_DESKRIPSIPENDEK, 
            PRD_UNIT, 
            PRD_FRAC
        FROM TBMASTER_PRODMAST
        WHERE PRD_KODEIGR = $kodeigr
        AND SUBSTR(PRD_PRDCD,7,1) = '0'
        ORDER BY PRD_PRDCD");

        return Datatables::of($datas)->make(true);
    }

   public function getDataProduk(Request $request)
   {
        $value = $request->prd_prdcd;
        // $checkString = strpos($value, 'H');

        // dd($checkString);
        // if($checkString == 'false')
        // {
        //     if(Str::length($value) < 7)
        //     {

        //     }
        // }

        $datas = DB::connection(Session::get('connection'))->table('TBMASTER_PRODMAST')
            ->selectRaw("PRD_PRDCD, 
            PRD_DESKRIPSIPENDEK, 
            PRD_UNIT, 
            PRD_FRAC,'BARANG DAGANGAN' AS STATUS")
            ->where('PRD_PRDCD',$value)
            ->orderBy('PRD_PRDCD')
            ->limit(100)
            ->get();

        return compact(['datas']);
   }

   public function getCardProduk()
    {
       
        $datas = DB::connection(Session::get('connection'))->table('TBMASTER_BRGPROMOSI')
        ->selectRaw("bprp_recordid,bprp_prdcd,bprp_ketpendek,bprp_frackonversi,bprp_unit")
        ->orderBy('bprp_prdcd')
        ->limit(100)
        ->get();

        return Datatables::of($datas)->make(true);
    }

    public function convertBarangDagangan(Request $request)
    {
        $bprp_prdcd = $request->prd_prdcd;
        $bprp_ketpendek = $request->prd_deskripsipendek;
        $bprp_frackonversi = $request->prd_frac;
        $bprp_unit = $request->prd_unit;

        $data_prodmast = DB::connection(Session::get('connection'))->table('TBMASTER_PRODMAST')
        ->select('PRD_PRDCD')
        ->where('PRD_PRDCD',$bprp_prdcd)
        ->get();

        $check_data = count($data_prodmast);
        
        // kalo data yang diinput exist di master produk maka bisa lanjut
        if($check_data == 1)
        {

            $data_promosi = DB::connection(Session::get('connection'))->table('TBMASTER_BRGPROMOSI')
            ->selectRaw("bprp_recordid,bprp_prdcd,bprp_ketpendek,bprp_frackonversi,bprp_unit")
            ->where('bprp_prdcd',$bprp_prdcd)
            ->orderBy('bprp_prdcd')
            ->get();
    
            $check = count($data_promosi);
    
            if($check == 0)
            {
                if($bprp_prdcd != NULL && $bprp_ketpendek != NULL || $bprp_frackonversi != NULL || $bprp_unit != NULL )
                {
                    $insert_barang_dagangan = DB::connection(Session::get('connection'))->table('TBMASTER_BRGPROMOSI')
                    ->insert([
                        'bprp_prdcd' => $bprp_prdcd,
                        'bprp_ketpendek' => $bprp_ketpendek,
                        'bprp_frackonversi' => $bprp_frackonversi,
                        'bprp_unit' => $bprp_unit
                    ]);
    
                    if($insert_barang_dagangan)
                    {
                        return response()->json([
                            'title' => 'success',
                            'message' => 'Data success converted to barang hadiah  !'
                        ], 200);
                    }
                }
                else 
                {
                    return response()->json([
                        'title' => 'An error occurred !',
                        'message' => 'Data cannot be NULL  !',
                        'status' => 'error'
                    ], 500);
                }
            }
            else
            {
                return response()->json([
                    'title' => 'An error occurred !',
                    'message' => 'Data already exist in Table Master Barang Hadiah !',
                    'status' => 'error'
                ], 500);
            }
        }
        // kalo data nya tidak exist di master produk
        else
        {
            return response()->json([
                'title' => 'An error occurred !',
                'message' => 'Kode PLU doesnt exist in master produk !',
                'status' => 'error'
            ], 500);
        }


    }
}
