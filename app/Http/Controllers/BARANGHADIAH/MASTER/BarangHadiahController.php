<?php

namespace App\Http\Controllers\BARANGHADIAH\MASTER;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
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

    public function getBarangHadiah(Request $request)
    {
        $bprp_prdcd = $request->prd_prdcd;
        $word = 'H';

        // BARANG HADIAH DARI TBMASTER_BRGPROMOSI -> PRDCD NYA ADA YANG H DAN ADA YANG FULL ANGKA
        if(strpos($bprp_prdcd, $word) !== false)
        {
            // CEK APABILA PRDCD CONTAIN H EXIST ATAU TIDAK
            $data_brgpromosi = DB::connection(Session::get('connection'))->table('TBMASTER_BRGPROMOSI')
            ->selectRaw("BPRP_PRDCD,BPRP_KETPANJANG,BPRP_FRACKONVERSI,BPRP_UNIT,'BARANG NON DAGANGAN' AS STATUS")
            ->where('BPRP_PRDCD',$bprp_prdcd)
            ->get();

            // $data_brgpromosi = DB::connection(Session::get('connection'))->SELECT("SELECT BPRP_PRDCD,
            // BPRP_KETPANJANG,
            // BPRP_FRACKONVERSI,
            // BPRP_UNIT,'BARANG NON DAGANGAN' AS STATUS
            // FROM TBMASTER_BRGPROMOSI
            // WHERE BPRP_PRDCD = '.$bprp_prdcd.' ");

            $check_data_promosi = count($data_brgpromosi);

            // KALO TIDAK EXIST MAKA AKAN DIINSERT KE DALAM TBMASTER_BRGPROMOSI
            // TETAPI SEBELUM ITU HARUS BALIK KE VIEW UNTUK ACTIVE KOLOM DESKRIPSI BARU DI LEMPAR KE CONTROLLER LAIN
            if($check_data_promosi == 0)
            {
                // status 1 = belum terdaftar
                return response()->json([
                    'message' => 'PLU ini bukan termasuk barang hadiah, akan didaftar sebagai PLU hadiah ?',
                    'prdcd' => $bprp_prdcd,
                    'status' => '1'
                ], 200);
            }
            else
            {    
                return response()->json($data_brgpromosi);
            }
        }
        else
        {
            $data_brgpromosi = DB::connection(Session::get('connection'))->table('TBMASTER_BRGPROMOSI')
            ->selectRaw("BPRP_PRDCD,BPRP_KETPANJANG,BPRP_FRACKONVERSI,BPRP_UNIT,BPRP_KETPENDEK,'BARANG NON DAGANGAN' AS STATUS")
            ->where('BPRP_PRDCD',$bprp_prdcd)
            ->get();

            $check_data_promosi = count($data_brgpromosi);

            if($check_data_promosi == 1)
            {
                return response()->json($data_brgpromosi);
            }
            else
            {    
                return response()->json([
                    'title' => 'An error occurred !',
                    'message' => 'PLU tidak terdaftar di master barang',
                    'status' => 'error'
                ], 500);
            }
        }
    }

    public function insertBarangHadiah(Request $request)
    {
        $kodeigr = Session::get('kdigr');

        $check_data_promosi = DB::connection(Session::get('connection'))->table('TBMASTER_BRGPROMOSI')
        ->where('bprp_prdcd',$request->prd_prdcd)
        ->get();

        $count_promosi = count($check_data_promosi);

        if($count_promosi > 0)
        {
            return response()->json([
                'title' => 'An error occurred !',
                'message' => 'PLU sudah terdaftar di tbmaster_brgpromosi',
                'status' => 'error'
            ], 500);
        }
        else
        {
            $insert_barang_hadiah = DB::connection(Session::get('connection'))->table('TBMASTER_BRGPROMOSI')
            ->insert([
                'bprp_kodeigr' => $kodeigr,
                'bprp_prdcd' => $request->prd_prdcd,
                'bprp_ketpanjang' => $request->deskripsi,
                'bprp_frackonversi' => 1,
                'bprp_unit' => 'PCS',
                'bprp_create_by' => Session::get('usid'),
                'bprp_create_dt' => Carbon::now()
            ]);
            // 226 - 233
            if($insert_barang_hadiah)
            {
                return response()->json([
                    'title' => 'success',
                    'message' => 'PLU baru berhasil terdaftar di tbmaster_brgpromosi !'
                ], 200);
            }
            // 233 - 240
            else
            {
                return response()->json([
                    'title' => 'An error occurred !',
                    'message' => 'PLU baru gagal didaftarkan',
                    'status' => 'error'
                ], 500);
            }
        }

    }

    public function convertBarangDagangan(Request $request)
    {
        $bprp_prdcd = $request->prd_prdcd;
        $bprp_ketpendek = $request->prd_deskripsipendek;
        $bprp_frackonversi = $request->prd_frac;
        $bprp_unit = $request->prd_unit;

        $data_prodmast = DB::connection(Session::get('connection'))->table('TBMASTER_PRODMAST')
        ->select('PRD_PRDCD','PRD_KODEDIVISI','PRD_KODEDEPARTEMENT','PRD_KODEKATEGORIBARANG','PRD_DESKRIPSIPANJANG')
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
                    // dd($data_prodmast[0]->prd_deskripsipanjang,$data_prodmast[0]->prd_kodedivisi,$data_prodmast[0]->prd_kodedepartement,$data_prodmast[0]->prd_kodekategoribarang);
                    $insert_barang_dagangan = DB::connection(Session::get('connection'))->table('TBMASTER_BRGPROMOSI')
                    ->insert([
                        'bprp_prdcd' => $bprp_prdcd,
                        'bprp_ketpanjang' => $data_prodmast[0]->prd_deskripsipanjang,
                        'bprp_ketpendek' => $bprp_ketpendek,
                        'bprp_frackonversi' => $bprp_frackonversi,
                        'bprp_unit' => $bprp_unit,
                        'bprp_kodedivisi' => $data_prodmast[0]->prd_kodedivisi,
                        'bprp_kodedepartement' => $data_prodmast[0]->prd_kodedepartement,
                        'bprp_kodekategoribrg' => $data_prodmast[0]->prd_kodekategoribarang,
                        'bprp_create_by' =>  Session::get('usid'),
                        'bprp_create_dt' => Carbon::now()
                    ]);

                    // dd($insert_barang_dagangan);

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

    public function getTableHadiah()
    {
        $datas = DB::connection(Session::get('connection'))->table('TBMASTER_BRGPROMOSI')
        ->selectRaw("bprp_recordid,bprp_prdcd,bprp_ketpanjang,bprp_frackonversi,bprp_unit")
        ->orderBy('bprp_prdcd')
        ->get();

        return Datatables::of($datas)->make(true);
    }

    // Buat Modal
    public function getModalBarangDagangan()
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

    public function getDetailBarangDagangan(Request $request)
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
}
