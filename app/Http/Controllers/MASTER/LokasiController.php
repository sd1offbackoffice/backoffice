<?php

namespace App\Http\Controllers\MASTER;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;
use Yajra\DataTables\DataTables;

class LokasiController extends Controller
{
    public function index(){
        return view('MASTER.lokasi');
    }

    public function getLokasi(Request $request){ //Untuk datatables Rak
        $search = $request->value;
        $lokasi = DB::connection($_SESSION['connection'])->table('tbmaster_lokasi')
            ->selectRaw('lks_koderak, lks_kodesubrak, lks_tiperak, lks_shelvingrak')

            ->where('lks_koderak','LIKE', '%'.$search.'%')
            ->where('lks_kodeigr','22')

            ->orWhere('lks_kodesubrak','LIKE', '%'.$search.'%')
            ->where('lks_kodeigr','22')

            ->orWhere('lks_tiperak','LIKE', '%'.$search.'%')
            ->where('lks_kodeigr','22')

            ->orWhere('lks_shelvingrak','LIKE', '%'.$search.'%')
            ->where('lks_kodeigr','22')

            ->orderByRaw('lks_koderak, lks_kodesubrak, lks_tiperak, lks_shelvingrak')
            ->distinct()
            ->limit(100)
            ->get();

        return Datatables::of($lokasi)->make(true);
    }

    public function getPlu(Request $request){ //Untuk datatables PLU
        $search = $request->value;
        $datas = DB::connection($_SESSION['connection'])->table('TBMASTER_PRODMAST')
            ->selectRaw('PRD_DESKRIPSIPANJANG,PRD_PRDCD')

            ->where('PRD_PRDCD','LIKE', '%'.$search.'%')
            ->whereRaw("SUBSTR(PRD_PRDCD,7,1)='0'")

            ->orWhere('PRD_DESKRIPSIPANJANG','LIKE', '%'.$search.'%')
            ->whereRaw("SUBSTR(PRD_PRDCD,7,1)='0'")

            ->orderBy('PRD_DESKRIPSIPANJANG')
            ->limit(100)
            ->get();

        return Datatables::of($datas)->make(true);
    }

    public function lovRakSearch(Request $request){
        sleep(1);

        $lokasi = DB::connection($_SESSION['connection'])->table('tbmaster_lokasi')
            ->selectRaw('lks_koderak, lks_kodesubrak, lks_tiperak, lks_shelvingrak')
            ->where('lks_kodeigr','22')
            ->where('lks_koderak','like','%'.$request->koderak.'%')
            ->orderByRaw('lks_koderak, lks_kodesubrak, lks_tiperak, lks_shelvingrak')
            ->distinct()
            ->limit(100)
            ->get();

        return $lokasi;
    }

    public function lovrakSelect(Request $request){
        $result = DB::connection($_SESSION['connection'])->table('tbmaster_lokasi')
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
            ->where('lks_kodeigr','22')
            ->where($request->data)
            ->orderBy('lks_nourut')
            ->get();


        return $result;
    }

    public function lovPluSearch(Request $request){
        if(is_numeric($request->data)){
            $result = DB::connection($_SESSION['connection'])->table('tbmaster_prodmast')
                ->selectRaw('prd_deskripsipanjang,prd_prdcd')
                ->whereRaw("SUBSTR(PRD_PRDCD,7,1)='0'")
                ->where('prd_prdcd',$request->data)
                ->orderBy('prd_deskripsipanjang')
                ->get();
        }
        else{
            $result = DB::connection($_SESSION['connection'])->table('tbmaster_prodmast')
                ->selectRaw('prd_deskripsipanjang,prd_prdcd')
                ->whereRaw("SUBSTR(PRD_PRDCD,7,1)='0'")
                ->where('prd_deskripsipanjang','like','%'.$request->data.'%')
                ->orderBy('prd_deskripsipanjang')
                ->get();
        }
        return $result;
    }

    public function lovPluSelect(Request $request){
        sleep(1);
        if($request->data['lks_tiperak'] != 'S'){
            if($request->data['lks_prdcd'] != ''){
                if($request->data['lks_qty'] > 0){
                    $status = 'error';
                    $message = 'Qty Plano masih ada, kosongkan terlebih dahulu dengan SO PLANO';
                    return compact(['status','message']);
                }

                $produk = DB::connection($_SESSION['connection'])->table('tbmaster_prodmast')
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
                            $temp = DB::connection($_SESSION['connection'])->table('tbmaster_lokasi')
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
                            $temp = DB::connection($_SESSION['connection'])->table('tbmaster_lokasi')
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
                            $temp = DB::connection($_SESSION['connection'])->table('tbmaster_lokasi')
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

                    $jenisrak = null;
                    if(substr($request->data['lks_koderak'],0,1) == 'H')
                        $jenisrak = 'H';
                    else{
                        $tipe = substr($request->data['lks_tiperak'],0,1);

                        if($tipe == 'S')
                            $jenisrak = 'S';
                        else if($tipe == 'B' || $tipe == 'I' || $tipe == 'N'){
                            $d = DB::connection($_SESSION['connection'])->table('tbmaster_pluplano')
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
                        else $jenisrak = 'L';
                    }

                    DB::connection($_SESSION['connection'])->beginTransaction();
                    DB::connection($_SESSION['connection'])->table('tbmaster_lokasi')
                        ->where('lks_kodeigr','22')
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
                    DB::connection($_SESSION['connection'])->commit();

                    $produk = DB::connection($_SESSION['connection'])->table('tbmaster_prodmast')
                        ->leftJoin('tbmaster_kkpkm',function($join){
                            $join->on('prd_kodeigr','pkm_kodeigr');
                            $join->on('prd_prdcd','pkm_prdcd');
                        })
                        ->selectRaw("PRD_DESKRIPSIPANJANG, TO_CHAR (PRD_FRAC) || '/' || PRD_UNIT AS SATUAN,
                           NVL (PRD_DIMENSIPANJANG, 0) as panjang, NVL (PRD_DIMENSILEBAR, 0) as lebar,
                           NVL (PRD_DIMENSITINGGI, 0) as tinggi, NVL (PKM_PKMT, 0) as pkm")
                        ->where('prd_kodeigr','22')
                        ->where('prd_prdcd',$request->data['lks_prdcd'])
                        ->first();

                    $maxpalet = DB::connection($_SESSION['connection'])->table('tbmaster_maxpalet')
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

                DB::connection($_SESSION['connection'])->beginTransaction();
                DB::connection($_SESSION['connection'])->table('tbmaster_lokasi')
                    ->where('lks_kodeigr','22')
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
                DB::connection($_SESSION['connection'])->commit();
            }
        }
        else{
            if($request->data['lks_qty'] > 0) {
                $status = 'error';
                $message = 'Qty Plano masih ada, kosongkan terlebih dahulu dengan SO PLANO';
                return compact(['status','message']);
            }
            else if($request->data['lks_prdcd'] != '') {
                $produk = DB::connection($_SESSION['connection'])->table('tbmaster_prodmast')
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
                DB::connection($_SESSION['connection'])->beginTransaction();
                DB::connection($_SESSION['connection'])->table('tbmaster_lokasi')
                    ->where('lks_kodeigr','22')
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
                DB::connection($_SESSION['connection'])->commit();
            }
        }
    }

    public function noidEnter(Request $request){
        sleep(1);
        if(substr($request->data['lks_koderak'], 0, 1) == 'D' && (substr($request->data['lks_tiperak'], 0, 1) == 'B' || substr($request->data['lks_tiperak'], 0, 1) == 'I' || substr($request->data['lks_tiperak'], 0, 1) == 'N')){
            $noid = DB::connection($_SESSION['connection'])->table('tbmaster_lokasi')
                ->select('lks_prdcd','lks_noid')
                ->where('lks_koderak','like','D%')
                ->whereRaw("lks_tiperak = 'B' OR lks_tiperak = 'N' OR lks_tiperak like 'I%'")
                ->whereRaw(DB::RAW("SUBSTR(LKS_NOID, -1)").'='.DB::RAW("SUBSTR ('".$request->data['lks_noid']."', -1)"))
                ->whereRaw("(NVL(LKS_NOID, '123456') <> '123456' OR TRIM(LKS_NOID) <> '')")
                ->get();

            if($noid){
                foreach($noid as $n){
                    if($n->lks_prdcd == $request->data['lks_prdcd'] && substr($n->lks_noid,-1) == substr($request->data['lks_noid'],-1)){
                        if(substr($noid[0]->lks_noid,-1) == 'P')
                            $data_noid = 'PCS';
                        else $data_noid = 'BULKY';

                        $status = 'error';
                        $message = 'Inputan NOID untuk PLU '.$request->data['lks_prdcd'].' sudah ada, '.$data_noid.'!';
                        return compact(['status','message']);
                    }
                }
            }
        }

        DB::connection($_SESSION['connection'])->beginTransaction();
        DB::connection($_SESSION['connection'])->table('tbmaster_lokasi')
            ->where('lks_kodeigr','22')
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
        DB::connection($_SESSION['connection'])->commit();

        if(substr($request->data['lks_koderak'],1,1) == 'D'){
            $dpd = DB::connection($_SESSION['connection'])->table('tbtabel_dpd')
                ->where('dpd_noid',$request->data['tempnoid'])
                ->where('dpd_recordid',null)
                ->get();

            DB::connection($_SESSION['connection'])->beginTransaction();
            try {
                if ($dpd) {
                    DB::connection($_SESSION['connection'])->table('tbtabel_dpd')
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
                    DB::connection($_SESSION['connection'])->table('tbtabel_dpd')
                        ->insert([
                            'dpd_kodeigr' => '22',
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
                DB::connection($_SESSION['connection'])->commit();
            }
            catch (QueryException $e){
                DB::connection($_SESSION['connection'])->rollBack();
                $status = 'error';
                $message = 'Gagal menambahkan noid!';
                return compact(['status','message']);
            }
        }
    }

    public function deletePlu(Request $request){
        //dd($request->data['lks_koderak']);
        try{
            DB::connection($_SESSION['connection'])->beginTransaction();
            DB::connection($_SESSION['connection'])->table('tbmaster_lokasi')
                //->where($request->data)
                ->where('lks_kodeigr','=',$_SESSION['kdigr'])
                ->where('lks_koderak','=',$request->data['lks_koderak'])
                ->where('lks_kodesubrak','=',$request->data['lks_kodesubrak'])
                ->where('lks_tiperak','=',$request->data['lks_tiperak'])
                ->where('lks_shelvingrak','=',$request->data['lks_shelvingrak'])
                ->where('lks_nourut','=',$request->data['lks_nourut'])
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
            DB::connection($_SESSION['connection'])->rollBack();
            $message = 'Gagal menghapus PLU!';
            $status = 'error';
        }
        finally{
            DB::connection($_SESSION['connection'])->commit();
            $message = 'Berhasil menghapus PLU!';
            $status = 'success';
        }

        return compact(['message','status']);
    }

    public function deleteLokasi(Request $request){
        try{
            DB::connection($_SESSION['connection'])->beginTransaction();
            DB::connection($_SESSION['connection'])->table('tbmaster_lokasi')
                ->where('lks_kodeigr','=',$_SESSION['kdigr'])
                ->where('lks_koderak','=',$request->data['lks_koderak'])
                ->where('lks_kodesubrak','=',$request->data['lks_kodesubrak'])
                ->where('lks_tiperak','=',$request->data['lks_tiperak'])
                ->where('lks_shelvingrak','=',$request->data['lks_shelvingrak'])
                ->where('lks_nourut','=',$request->data['lks_nourut'])
                ->delete();

            DB::connection($_SESSION['connection'])->commit();
            $message = 'Berhasil menghapus lokasi!';
            $status = 'success';
        }
        catch(QueryException $e){
            DB::connection($_SESSION['connection'])->rollBack();
            $message = 'Gagal menghapus lokasi!';
            $status = 'error';
        }

        return compact(['message','status']);
    }

    public function cekPlu(Request $request){
//        $cek = DB::connection($_SESSION['connection'])->table('tbmaster_lokasi')
//            ->where('lks_kodeigr','22')
//            ->where('lks_prdcd',$request->prdcd)
//            ->first();
//
//        if($cek){
//            return 'ada';
//        }
//        else return 'tidak-ada';

        $in = [];

        if($request->tiperak == 'S'){
            if($request->prdcd == ''){
                return response()->json([
                    'message' => 'Kode produk tidak terdaftar!'
                ], 500);
            }
        }

        $prdcd = substr('0000000'.$request->prdcd, -7);

        if(substr($request->koderak, 0, 1) == 'H'){
            $in['jenisrak'] = 'H';
        }
        else{
            if($request->tiperak == 'S'){
                $in['jenisrak'] = 'S';
            }
            else if($request->tiperak == 'B' || substr($request->tiperak, 0, 1) == 'I' || $request->tiperak == 'N'){
                $plano = DB::connection($_SESSION['connection'])->table('tbmaster_pluplano')
                    ->where('pln_prdcd','=',$prdcd)
                    ->first();

                if(!$plano){
                    return response()->json([
                        'message' => 'Belum ada di Master PLU Planogram, silahkan didaftarkan jenis rak nya terlebih dahulu!'
                    ], 500);
                }
                else{
                    if(substr($request->koderak,0,1) == 'D' && (substr($request->tiperak, 0, 1) == 'I' || $request->tiperak == 'N')){
                        if($request->noid != ''){
                            $temp = DB::connection($_SESSION['connection'])->selectOne("SELECT SUBSTR (LKS_NOID, -1) data_noid
                                        FROM TBMASTER_LOKASI
                                        WHERE LKS_KODERAK LIKE 'D%'
                                        AND (LKS_TIPERAK = 'B' OR LKS_TIPERAK = 'N' OR LKS_TIPERAK LIKE 'I%')
                                        AND LKS_PRDCD = '".$prdcd."'
                                        AND SUBSTR (LKS_NOID, -1) = SUBSTR (trim ('".$request->noid."'), -1)
                                        AND (NVL (LKS_NOID, '123456') <> '123456' OR TRIM (LKS_NOID) <> '')");

                            if($temp){
                                $data_noid = $temp->data_noid;

                                return response()->json([
                                    'message' => 'Inputan data noid untuk PLU '.$prdcd.' sudah ada, '.$data_noid == 'P' ? 'PCS' : 'BULKY'.'!'
                                ], 500);
                            }
                        }
                    }

                    $in['jenisrak'] = $plano->pln_jenisrak;
                }
            }
            else $in['jenisrak'] = 'L';
        }

        if($request->tiperak != 'S'){
            $t_pluada = DB::connection($_SESSION['connection'])->table('tbmaster_lokasi')
                ->where('lks_kodeigr','=',$_SESSION['kdigr'])
                ->where('lks_koderak','=',$request->koderak)
                ->where('lks_kodesubrak','=',$request->kodesubrak)
                ->where('lks_tiperak','=',$request->tiperak)
                ->where('lks_shelvingrak','=',$request->shelvingrak)
                ->where('lks_prdcd','=',$prdcd)
                ->first();

            if($t_pluada){
                return response()->json([
                    'message' => 'PLU sudah terdaftar!'
                ], 500);
            }
        }

        $prd = DB::connection($_SESSION['connection'])->selectOne("SELECT PRD_DESKRIPSIPANJANG, TO_CHAR (PRD_FRAC) || '/' || PRD_UNIT AS SATUAN,
               NVL (PRD_DIMENSIPANJANG, 0) as panjang, NVL (PRD_DIMENSILEBAR, 0) as lebar, NVL (PRD_DIMENSITINGGI, 0) as tinggi,
               NVL (PKM_PKMT, 0) as pkm
          FROM TBMASTER_PRODMAST, TBMASTER_KKPKM                                     --,TBTABEL_DPD
         WHERE PRD_KODEIGR = PKM_KODEIGR(+)
           AND PRD_PRDCD = PKM_PRDCD(+)
           AND PRD_KODEIGR = '".$_SESSION['kdigr']."'
           AND PRD_PRDCD = '".$prdcd."'");

        if(!$prd){
            return response()->json([
                'message' => 'Kode produk ['.$prdcd.'] tidak terdaftar!'
            ], 500);
        }
        else{
            $in['prdcd'] = $prdcd;
            $in['deskripsi'] = $prd->prd_deskripsipanjang;
            $in['satuan'] = $prd->satuan;
            $in['panjang'] = $prd->panjang;
            $in['lebar'] = $prd->lebar;
            $in['tinggi'] = $prd->tinggi;
            $in['pkm'] = $prd->pkm;

            $noid = DB::connection($_SESSION['connection'])->table('tbtabel_dpd')
                ->select('dpd_noid')
                ->where('dpd_kodeigr','=',$_SESSION['kdigr'])
                ->where('dpd_koderak','=',$request->koderak)
                ->where('dpd_kodesubrak','=',$request->kodesubrak)
                ->where('dpd_tiperak','=',$request->tiperak)
                ->where('dpd_shelvingrak','=',$request->shelvingrak)
                ->where('dpd_nourut','=',$request->nourut)
                ->first();

            $in['noid'] = $noid ? $noid->dpd_noid : null;
        }

        if($request->tiperak == 'S'){
            $temp = DB::connection($_SESSION['connection'])->table('tbmaster_maxpallet')
                ->select('mpt_maxqty')
                ->where('mpt_prdcd','=',$prdcd)
                ->first();

            $in['maxpalet'] = $temp ? $temp->mpt_maxqty : null;
        }

        return response()->json([
            'data' => $in,
        ], 200);
    }

    public function tambah(Request $request){
        try{
            DB::connection($_SESSION['connection'])->beginTransaction();

            $insert = $request->data;

            if($insert['lks_nourut'] == null){
                $temp = DB::connection($_SESSION['connection'])->table('tbmaster_lokasi')
                    ->select('lks_nourut')
                    ->where('lks_koderak','=',$request->data['lks_koderak'])
                    ->where('lks_kodesubrak','=',$request->data['lks_kodesubrak'])
                    ->where('lks_tiperak','=',$request->data['lks_tiperak'])
                    ->where('lks_shelvingrak','=',$request->data['lks_shelvingrak'])
                    ->orderBy('lks_nourut','desc')
                    ->first();

                $insert['lks_nourut'] = $temp ? intval($temp->lks_nourut)+1 : 1;
            }

            DB::connection($_SESSION['connection'])->table('tbmaster_lokasi')
                ->insert([
                    'lks_koderak' => $insert['lks_koderak'],
                    'lks_kodesubrak' => $insert['lks_kodesubrak'],
                    'lks_tiperak' => $insert['lks_tiperak'],
                    'lks_shelvingrak' => $insert['lks_shelvingrak'],
                    'lks_prdcd' => $insert['lks_prdcd'],
                    'lks_nourut' => $insert['lks_nourut'],
                    'lks_depanbelakang' => $insert['lks_depanbelakang'],
                    'lks_atasbawah' => $insert['lks_atasbawah'],
                    'lks_tirkirikanan' => $insert['lks_tirkirikanan'],
                    'lks_tirdepanbelakang' => $insert['lks_tirdepanbelakang'],
                    'lks_tiratasbawah' => $insert['lks_tiratasbawah'],
                    'lks_maxdisplay' => $insert['lks_maxdisplay'],
                    'lks_minpct' => $insert['lks_minpct'],
                    'lks_maxplano' => $insert['lks_maxplano'],
                    'lks_jenisrak' => $insert['lks_jenisrak'],
                    'lks_delete' => $insert['lks_delete'],
                    'lks_create_by' => $_SESSION['usid'],
                    'lks_create_dt' => DB::RAW('sysdate'),
                    'lks_kodeigr' => $_SESSION['kdigr']
                ]);

            DB::connection($_SESSION['connection'])->commit();
            $status = 'success';
            $message = 'Berhasil tambah data!';
        }
        catch(QueryException $e){
            DB::connection($_SESSION['connection'])->rollBack();

            dd($e->getMessage());
            $status = 'error';
            $message = 'Gagal tambah data!';
        }

        return compact(['status','message']);
    }

    public function cekDpd(Request $request){
        $cek = DB::connection($_SESSION['connection'])->table('tbtabel_dpd')
            ->select('dpd_noid','dpd_koderak','dpd_kodesubrak','dpd_tiperak','dpd_shelvingrak','dpd_nourut')
            ->where('dpd_noid',$request->noid)
            ->first();

        return response()->json($cek);
    }

    public function deleteDpd(Request $request){
        try{
            DB::connection($_SESSION['connection'])->beginTransaction();

            DB::connection($_SESSION['connection'])->table('tbtabel_dpd')
                ->where($request->data)
                ->delete();
        }
        catch (QueryException $e){
            DB::connection($_SESSION['connection'])->rollBack();

            $status = 'error';
            $message = $e->getMessage();

            return compact(['status','message']);
        }
        finally{
            DB::connection($_SESSION['connection'])->commit();

            $status = 'success';
            $message = 'Nomor ID berhasil dihapus!';

            return compact(['status','message']);
        }
    }

    public function saveDpd(Request $request){
        $where = $request->data['tempdpd'];
        $data = $request->data;
        unset($data['tempdpd']);

        $cek = DB::connection($_SESSION['connection'])->table('tbtabel_dpd')
            ->select('dpd_noid')
            ->where($where)
            ->get();

        try{
            DB::connection($_SESSION['connection'])->table('tbmaster_lokasi')
                ->where('lks_kodeigr','=',$_SESSION['kdigr'])
                ->where('lks_koderak','=',$request->data['dpd_koderak'])
                ->where('lks_kodesubrak','=',$request->data['dpd_kodesubrak'])
                ->where('lks_tiperak','=',$request->data['dpd_tiperak'])
                ->where('lks_shelvingrak','=',$request->data['dpd_shelvingrak'])
                ->where('lks_nourut','=',$request->data['dpd_nourut'])
                ->update([
                    'lks_noid' => $request->data['dpd_noid']
                ]);

            //UPDATE DPD NYA
            if(count($cek) > 0){
                $temp = [
                    'dpd_modify_by' => $_SESSION['usid'],
                    'dpd_modify_dt' => DB::RAW('sysdate')
                ];
                $update = array_merge($data, $temp);

                DB::connection($_SESSION['connection'])->table('tbtabel_dpd')
                    ->where($where)
                    ->update($update);
            }
            else{
                $temp = [
                    'dpd_kodeigr' => '22',
                    'dpd_create_by' => $_SESSION['usid'],
                    'dpd_create_dt' => DB::RAW('sysdate')
                ];
                $insert = array_merge($data, $temp);

                DB::connection($_SESSION['connection'])->table('tbtabel_dpd')
                    ->insert($insert);
            }

            DB::connection($_SESSION['connection'])->commit();

            $status = 'success';
            $message = 'Nomor ID berhasil disimpan!';
        }
        catch (QueryException $e){
            DB::connection($_SESSION['connection'])->rollBack();

            $status = 'error';
            $message = $e->getMessage();
        }

        return compact(['status','message']);
    }

}
