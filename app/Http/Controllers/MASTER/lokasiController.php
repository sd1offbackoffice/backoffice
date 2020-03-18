<?php

namespace App\Http\Controllers\MASTER;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;

class lokasiController extends Controller
{
    public function index(){
        $lokasi = DB::connection('simcpt')->table('tbmaster_lokasi')
            ->selectRaw('lks_koderak, lks_kodesubrak, lks_tiperak, lks_shelvingrak')
            ->where('lks_kodeigr','35')
            ->orderByRaw('lks_koderak, lks_kodesubrak, lks_tiperak, lks_shelvingrak')
            ->distinct()
            ->limit(100)
            ->get();

        $produk = DB::connection('simcpt')->table('tbmaster_prodmast')
            ->selectRaw('prd_deskripsipanjang,prd_prdcd')
            ->whereRaw("SUBSTR(PRD_PRDCD,7,1)='0'")
            ->orderBy('prd_deskripsipanjang')
            ->limit(100)
            ->get();

        return view('MASTER.lokasi')->with(compact(['lokasi','produk']));
    }

    public function lov_rak_search(Request $request){
        $lokasi = DB::connection('simcpt')->table('tbmaster_lokasi')
            ->selectRaw('lks_koderak, lks_kodesubrak, lks_tiperak, lks_shelvingrak')
            ->where('lks_kodeigr','35')
            ->where('lks_koderak','like','%'.$request->koderak.'%')
            ->orderByRaw('lks_koderak, lks_kodesubrak, lks_tiperak, lks_shelvingrak')
            ->distinct()
            ->limit(100)
            ->get();

        return $lokasi;
    }

    public function lov_rak_select(Request $request){
        $result = DB::connection('simcpt')->table('tbmaster_lokasi')
            ->leftJoin('tbmaster_prodmast',function($join){
                $join->on('lks_kodeigr','prd_kodeigr');
                $join->on('lks_prdcd','prd_prdcd');
            })
            ->leftJoin('tbmaster_kkpkm',function($join){
                $join->on('lks_kodeigr','pkm_kodeigr');
                $join->on('lks_prdcd','pkm_prdcd');
            })
            ->leftJoin('tbmaster_maxpalet',function($join){
                $join->on('lks_prdcd','mpt_prdcd');
            })
            ->selectRaw("NVL(PRD_DESKRIPSIPANJANG,'') AS DESK,TO_CHAR(PRD_FRAC)||'/'||PRD_UNIT AS SATUAN,
                 NVL(PRD_DIMENSIPANJANG,0) as lks_dimensipanjangproduk,NVL(PRD_DIMENSILEBAR,0) as lks_dimensilebarproduk,NVL(PRD_DIMENSITINGGI,0) as lks_dimensitinggiproduk,NVL(PKM_PKMT,0) as pkm, lks_noid,
                 lks_tirkirikanan, lks_tirdepanbelakang, lks_tiratasbawah, lks_maxdisplay, lks_prdcd,
                 mpt_maxqty, lks_jenisrak, lks_minpct, lks_maxplano, lks_qty, lks_expdate, lks_delete, lks_depanbelakang, lks_atasbawah, lks_nourut")
            ->where('lks_kodeigr','35')
            ->where($request->data)
            ->orderBy('lks_nourut')
            ->get();


        return $result;
    }

    public function lov_plu_search(Request $request){
        if(is_numeric($request->data)){
            $result = DB::connection('simcpt')->table('tbmaster_prodmast')
                ->selectRaw('prd_deskripsipanjang,prd_prdcd')
                ->whereRaw("SUBSTR(PRD_PRDCD,7,1)='0'")
                ->where('prd_prdcd',$request->data)
                ->orderBy('prd_deskripsipanjang')
                ->get();
        }
        else{
            $result = DB::connection('simcpt')->table('tbmaster_prodmast')
                ->selectRaw('prd_deskripsipanjang,prd_prdcd')
                ->whereRaw("SUBSTR(PRD_PRDCD,7,1)='0'")
                ->where('prd_deskripsipanjang','like','%'.$request->data.'%')
                ->orderBy('prd_deskripsipanjang')
                ->get();
        }
        return $result;
    }

    public function lov_plu_select(Request $request){

        if($request->data['lks_tiperak'] != 'S'){
            if($request->data['lks_prdcd'] != ''){
                if($request->data['lks_qty'] > 0){
                    $status = 'error';
                    $message = 'Qty Plano masih ada, kosongkan terlebih dahulu dengan SO PLANO';
                    return compact(['status','message']);
                }

                $produk = DB::connection('simcpt')->table('tbmaster_prodmast')
                    ->select('*')
                    ->where('prd_prdcd',$request->data['lks_prdcd'])
                    ->first();

                if(!$produk){
                    $status = 'error';
                    $message = 'PLU tidak terdaftar dalam master prodmast!';
                    return compact(['status','message']);
                }
                else{
                    if(substr($request->data['lks_koderak'],0,5) == 'DKLIK' || substr($request->data['lks_koderak'],0,1) == 'P'){
                        if($request->data['lks_noid'] != ''){
                            $temp = DB::connection('simcpt')->table('tbmaster_lokasi')
                                ->selectRaw('SUBSTR (LKS_NOID, -1) as lks_noid, lks_prdcd')
                                ->whereRaw("lks_koderak like 'D%'")
                                ->whereRaw("(LKS_TIPERAK = 'B' OR LKS_TIPERAK = 'N' OR LKS_TIPERAK LIKE 'I%')")
                                ->whereRaw("SUBSTR(LKS_NOID, -1) = SUBSTR(trim ('".$request->data['lks_noid']."'), -1)")
                                ->whereRaw("(NVL(LKS_NOID, '123456') <> '123456' OR TRIM(LKS_NOID) <> '')")
                                ->where('lks_prdcd',$request->data['lks_prdcd'])
                                ->first();

                            if($temp){
                                if($temp->lks_noid == 'P')
                                    $data_noid = 'PCS';
                                else $data_noid = 'BULKY';

                                $status = 'error';
                                $message = 'Inputan NOID untuk PLU '.$temp->lks_prdcd.' sudah ada, '.$data_noid.'!';
                                return compact(['status','message']);
                            }
                        }

                        if(substr($request->data['lks_koderak'],0,5) == 'DKLIK'){
                            $temp = DB::connection('simcpt')->table('tbmaster_lokasi')
                                ->where('lks_koderak','like','D%')
                                ->where('lks_tiperak','!=','S')
                                ->where('lks_prdcd',$request->data['lks_prdcd'])
                                ->first();

                            if($temp){
                                $status = 'error';
                                $message = 'PLU '.$temp->lks_prdcd.' sudah ada untuk rak D!';
                                return compact(['status','message']);
                            }
                        }

                        if(substr($request->data['lks_koderak'],0,1) == 'P'){
                            $temp = DB::connection('simcpt')->table('tbmaster_lokasi')
                                ->where('lks_koderak','not like','D%')
                                ->where('lks_tiperak','!=','S')
                                ->where('lks_prdcd',$request->data['lks_prdcd'])
                                ->first();

                            if($temp){
                                $status = 'error';
                                $message = 'PLU '.$temp->lks_prdcd.' sudah ada untuk lokasi lain!';
                                return compact(['status','message']);
                            }
                        }
                    }

                    if(substr($request->data['lks_koderak'],0,1) == 'H')
                        $jenisrak = 'H';
                    else{
                        $tipe = substr($request->data['lks_tiperak'],0,1);

                        if($tipe == 'S')
                            $jenisrak = 'S';
                        else if($tipe == 'B' || $tipe == 'I' || $tipe == 'N'){
                            $d = DB::connection('simcpt')->table('tbmaster_pluplano')
                                ->select('pln_jenisrak')
                                ->where('pln_prdcd',$request->data['lks_prdcd'])
                                ->first();

                            if($d){
                                $jenisrak = $d->pln_jenisrak;
                            }
                            else{
                                $jenisrak = 'N';
                            }
                        }
                    }

                    DB::connection('simcpt')->beginTransaction();
                    DB::connection('simcpt')->table('tbmaster_lokasi')
                        ->where('lks_kodeigr','35')
                        ->where('lks_koderak',$request->data['lks_koderak'])
                        ->where('lks_kodesubrak',$request->data['lks_kodesubrak'])
                        ->where('lks_tiperak',$request->data['lks_tiperak'])
                        ->where('lks_shelvingrak',$request->data['lks_shelvingrak'])
                        ->where('lks_nourut',$request->data['lks_nourut'])
                        ->update([
                            'lks_prdcd' => $request->data['lks_prdcd'],
                            'lks_noid' => $request->data['lks_noid'],
                            'lks_depanbelakang' => '1',
                            'lks_atasbawah' => '1',
                            'lks_modify_by' => $_SESSION['usid'],
                            'lks_modify_dt' => DB::RAW('SYSDATE'),
                            'lks_jenisrak' => $jenisrak
                        ]);
                    DB::connection('simcpt')->commit();

                    $produk = DB::connection('simcpt')->table('tbmaster_prodmast')
                        ->leftJoin('tbmaster_kkpkm',function($join){
                            $join->on('prd_kodeigr','pkm_kodeigr');
                            $join->on('prd_prdcd','pkm_prdcd');
                        })
                        ->selectRaw("PRD_DESKRIPSIPANJANG, TO_CHAR (PRD_FRAC) || '/' || PRD_UNIT AS SATUAN,
                           NVL (PRD_DIMENSIPANJANG, 0) as panjang, NVL (PRD_DIMENSILEBAR, 0) as lebar,
                           NVL (PRD_DIMENSITINGGI, 0) as tinggi, NVL (PKM_PKMT, 0) as pkm")
                        ->where('prd_kodeigr','35')
                        ->where('prd_prdcd',$request->data['lks_prdcd'])
                        ->first();

                    $maxpalet = DB::connection('simcpt')->table('tbmaster_maxpalet')
                        ->select('mpt_maxqty')
                        ->where('mpt_prdcd',$request->data['lks_prdcd'])
                        ->first();

                    $produk = (array) $produk;

                    array_push($produk, $jenisrak);

                    if($maxpalet)
                        array_push($produk, $maxpalet->mpt_maxqty);

                    return response()->json($produk);
                }
            }
            else{
                if($request->data['lks_qty'] > 0){
                    $status = 'error';
                    $message = 'Qty Plano masih ada, kosongkan terlebih dahulu dengan SO PLANO!';
                    return compact(['status','message']);
                }

                DB::connection('simcpt')->beginTransaction();
                DB::connection('simcpt')->table('tbmaster_lokasi')
                    ->where('lks_kodeigr','35')
                    ->where('lks_koderak',$request->data['lks_koderak'])
                    ->where('lks_kodesubrak',$request->data['lks_kodesubrak'])
                    ->where('lks_tiperak',$request->data['lks_tiperak'])
                    ->where('lks_shelvingrak',$request->data['lks_shelvingrak'])
                    ->where('lks_nourut',$request->data['lks_nourut'])
                    ->update([
                        'lks_prdcd' => null,
                        'lks_noid' => $request->data['lks_noid'],
                        'lks_depanbelakang' => '1',
                        'lks_atasbawah' => '1',
                        'lks_modify_by' => $_SESSION['usid'],
                        'lks_modify_dt' => DB::RAW('SYSDATE')
                    ]);
                DB::connection('simcpt')->commit();
            }
        }
        else{
            if($request->data['lks_qty'] > 0) {
                $status = 'error';
                $message = 'Qty Plano masih ada, kosongkan terlebih dahulu dengan SO PLANO';
                return compact(['status','message']);
            }
            else if($request->data['lks_prdcd'] != '') {
                $produk = DB::connection('simcpt')->table('tbmaster_prodmast')
                    ->select('*')
                    ->where('prd_prdcd', $request->data['lks_prdcd'])
                    ->first();

                if (!$produk) {
                    $status = 'error';
                    $message = 'PLU tidak terdaftar dalam master prodmast!';
                    return compact(['status', 'message']);
                }
            }
            else{
                DB::connection('simcpt')->beginTransaction();
                DB::connection('simcpt')->table('tbmaster_lokasi')
                    ->where('lks_kodeigr','35')
                    ->where('lks_koderak',$request->data['lks_koderak'])
                    ->where('lks_kodesubrak',$request->data['lks_kodesubrak'])
                    ->where('lks_tiperak',$request->data['lks_tiperak'])
                    ->where('lks_shelvingrak',$request->data['lks_shelvingrak'])
                    ->where('lks_nourut',$request->data['lks_nourut'])
                    ->update([
                        'lks_prdcd' => null,
                        'lks_noid' => $request->data['lks_noid'],
                        'lks_depanbelakang' => '1',
                        'lks_atasbawah' => '1',
                        'lks_modify_by' => $_SESSION['usid'],
                        'lks_modify_dt' => DB::RAW('SYSDATE')
                    ]);
                DB::connection('simcpt')->commit();
            }
        }
    }

    public function noid_enter(Request $request){
        $noid = $request->data['lks_noid'];

        if(substr($request->data['lks_koderak'], 0, 1) == 'D' && (substr($request->data['lks_tiperak'], 0, 1) == 'B' || substr($request->data['lks_tiperak'], 0, 1) == 'I' || substr($request->data['lks_tiperak'], 0, 1) == 'N')){
            $noid = DB::connection('simcpt')->table('tbmaster_lokasi')
                ->selectRaw('SUBSTR(LKS_NOID, -1) LKS_NOID')
                ->where('lks_koderak','like','D%')
                ->whereRaw("lks_tiperak = 'B' OR lks_tiperak = 'N' OR lks_tiperak like 'I%'")
                ->where('lks_prdcd',$request->data['lks_prdcd'])
                ->whereRaw(DB::RAW("SUBSTR(LKS_NOID, -1)").'='.DB::RAW("SUBSTR ('".$noid."', -1)"))
                ->whereRaw("(NVL(LKS_NOID, '123456') <> '123456' OR TRIM(LKS_NOID) <> '')")
                ->distinct()
                ->first();

            if($noid){
                if($noid->lks_noid == 'P')
                    $data_noid = 'PCS';
                else $data_noid = 'BULKY';

                $status = 'error';
                $message = 'Inputan NOID untuk PLU '.$request->data['lks_prdcd'].' sudah ada, '.$data_noid.'!';
                return compact(['status','message']);
            }
        }

        DB::connection('simcpt')->beginTransaction();
        DB::connection('simcpt')->table('tbmaster_lokasi')
            ->where('lks_kodeigr','35')
            ->where('lks_koderak',$request->data['lks_koderak'])
            ->where('lks_kodesubrak',$request->data['lks_kodesubrak'])
            ->where('lks_tiperak',$request->data['lks_tiperak'])
            ->where('lks_shelvingrak',$request->data['lks_shelvingrak'])
            ->where('lks_nourut',$request->data['lks_nourut'])
            ->update([
                'lks_noid' => $request->data['lks_noid'],
                'lks_modify_by' => $_SESSION['usid'],
                'lks_modify_dt' => DB::RAW('SYSDATE')
            ]);
        DB::connection('simcpt')->commit();

        if(substr($request->data['lks_koderak'],1,1) == 'D'){
            $dpd = DB::connection('simcpt')->table('tbtabel_dpd')
                ->where('dpd_noid',$request->data['tempnoid'])
                ->where('dpd_recordid',null)
                ->get();

            DB::connection('simcpt')->beginTransaction();
            try {
                if ($dpd) {
                    DB::connection('simcpt')->table('tbtabel_dpd')
                        ->where('dpd_noid', $request->data['tempnoid'])
                        ->where('dpd_koderak', $request->data['lks_koderak'])
                        ->where('dpd_recordid', null)
                        ->update([
                            'dpd_recordid' => '1',
                            'dpd_modify_by' => $_SESSION['usid'],
                            'dpd_modify_dt' => DB::RAW('sysdate')
                        ]);
                }
                else {
                    DB::connection('simcpt')->table('tbtabel_dpd')
                        ->insert([
                            'dpd_kodeigr' => '35',
                            'dpd_noid' => $request->data['lks_noid'],
                            'dpd_koderak' => $request->data['lks_koderak'],
                            'dpd_kodesubrak' => $request->data['lks_kodesubrak'],
                            'dpd_tiperak' => $request->data['lks_tiperak'],
                            'dpd_shelvingrak' => $request->data['lks_tiperak'],
                            'dpd_nourut' => $request->data['lks_nourut'],
                            'dpd_create_dt' => DB::RAW('sysdate'),
                            'dpd_create_by' => $_SESSION['usid']
                        ]);
                }
            }
            catch (QueryException $e){
                DB::connection('simcpt')->rollBack();
                $status = 'error';
                $message = 'Gagal menambahkan noid!';
                return compact(['status','message']);
            }
            finally{
                DB::connection('simcpt')->commit();
            }
        }
    }

    public function delete_plu(Request $request){
        try{
            DB::connection('simcpt')->beginTransaction();
            DB::connection('simcpt')->table('tbmaster_lokasi')
                ->where($request->data)
                ->update([
                    'lks_prdcd' => null,
                    'lks_depanbelakang' => null,
                    'lks_atasbawah' => null,
                    'lks_tirkirikanan' => null,
                    'lks_tirdepanbelakang' => null,
                    'lks_tiratasbawah' => null,
                    'lks_maxdisplay' => null,
                    'lks_dimensilebarproduk' => null,
                    'lks_dimensitinggiproduk' => null,
                    'lks_dimensipanjangproduk' => null,
                    'lks_fmmsqr' => null,
                    'lks_flagupdate' => null,
                    'lks_modify_by' => $_SESSION['usid'],
                    'lks_modify_dt' => DB::RAW('sysdate'),
                    'lks_qty' => '0',
                    'lks_expdate' => null,
                    'lks_booked' => null,
                ]);
        }
        catch(QueryException $e){
            DB::connection('simcpt')->rollBack();
            $message = 'Gagal menghapus PLU!';
            $status = 'error';
        }
        finally{
            DB::connection('simcpt')->commit();
            $message = 'Berhasil menghapus PLU!';
            $status = 'success';
        }

        return compact(['message','status']);
    }

    public function delete_lokasi(Request $request){
        try{
            DB::connection('simcpt')->beginTransaction();
            DB::connection('simcpt')->table('tbmaster_lokasi')
                ->where($request->data)
                ->delete();
        }
        catch(QueryException $e){
            DB::connection('simcpt')->rollBack();
            $message = 'Gagal menghapus lokasi!';
            $status = 'error';
        }
        finally{
            DB::connection('simcpt')->commit();
            $message = 'Berhasil menghapus lokasi!';
            $status = 'success';
        }

        return compact(['message','status']);
    }

    public function cek_plu(Request $request){
        $cek = DB::connection('simcpt')->table('tbmaster_lokasi')
            ->where('lks_kodeigr','35')
            ->where('lks_prdcd',$request->prdcd)
            ->first();

        if($cek){
            return 'ada';
        }
        else return 'tidak-ada';
    }

    public function tambah(Request $request){
        $lokasi = $request->data;

        $lokasi['lks_create_by'] = $_SESSION['usid'];
        $lokasi['lks_create_dt'] = DB::RAW('sysdate');
        $lokasi['lks_kodeigr'] = '35';

        try{
            DB::connection('simcpt')->beginTransaction();
            DB::connection('simcpt')->table('tbmaster_lokasi')
                ->insert($lokasi);
        }
        catch(QueryException $e){
            DB::connection('simcpt')->rollBack();
            $status = 'error';
            $message = 'Gagal tambah data!';
        }
        finally{
            DB::connection('simcpt')->commit();
            $status = 'success';
            $message = 'Berhasil tambah data!';
        }

        return compact(['status','message']);
    }

}