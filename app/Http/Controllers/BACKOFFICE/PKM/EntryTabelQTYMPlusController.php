<?php

namespace App\Http\Controllers\BACKOFFICE\PKM;

use App\Http\Controllers\Auth\loginController;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller; use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Mockery\Exception;
use Yajra\DataTables\DataTables;

class EntryTabelQTYMPlusController extends Controller
{
    public function index(){
        return view('BACKOFFICE.PKM.entry-tabel-qty-mplus');
    }

    public function getLovPLU(Request $request){
        $search = $request->plu;

        if($search == ''){
            $produk = DB::connection(Session::get('connection'))->table('tbmaster_prodmast')
                ->selectRaw("prd_prdcd,prd_deskripsipanjang, prd_unit || '/' || prd_frac satuan")
                ->where('prd_kodeigr',Session::get('kdigr'))
                ->whereRaw("substr(prd_prdcd,-1) = '0'")
                ->orderBy('prd_prdcd')
                ->limit(100)
                ->get();
        }
        else if(is_numeric($search)){
            $produk = DB::connection(Session::get('connection'))->table('tbmaster_prodmast')
                ->selectRaw("prd_prdcd,prd_deskripsipanjang, prd_unit || '/' || prd_frac satuan")
                ->where('prd_kodeigr',Session::get('kdigr'))
                ->where('prd_prdcd','like',DB::connection(Session::get('connection'))->raw("'%".$search."%'"))
                ->whereRaw("substr(prd_prdcd,-1) = '0'")
                ->orderBy('prd_prdcd')
                ->get();
        }
        else{
            $produk = DB::connection(Session::get('connection'))->table('tbmaster_prodmast')
                ->selectRaw("prd_prdcd,prd_deskripsipanjang, prd_unit || '/' || prd_frac satuan")
                ->where('prd_kodeigr',Session::get('kdigr'))
                ->where('prd_deskripsipanjang','like',DB::connection(Session::get('connection'))->raw("'%".$search."%'"))
                ->whereRaw("substr(prd_prdcd,-1) = '0'")
                ->orderBy('prd_prdcd')
                ->get();
        }

        return DataTables::of($produk)->make(true);
    }

    public function getDataPLU(Request $request){
        $data = new \stdClass();
        $prd = DB::connection(Session::get('connection'))->table('tbmaster_prodmast')
            ->selectRaw("prd_prdcd,prd_deskripsipanjang,prd_kodetag")
            ->where('prd_kodeigr',Session::get('kdigr'))
            ->where('prd_prdcd','=',$request->plu)
            ->whereRaw("substr(prd_prdcd,-1) = '0'")
            ->first();

        if(!$prd){
            return response()->json([
                'message' => 'PLU '.$request->plu.' tidak ditemukan!'
            ], 500);
        }
        else{
            if(in_array($prd->prd_kodetag, ['N','H','X'])){
                return response()->json([
                    'message' => 'PLU Discontinue ( Tag NHX )!'
                ], 500);
            }
            else{
                $data->prd_prdcd = $prd->prd_prdcd;
                $data->prd_deskripsipanjang = $prd->prd_deskripsipanjang;
                $data->prd_kodetag = $prd->prd_kodetag;

                $kkpkm = DB::connection(Session::get('connection'))
                    ->table('tbmaster_kkpkm')
                    ->selectRaw("pkm_pkmt, pkm_qtyaverage")
                    ->where('pkm_kodeigr','=',Session::get('kdigr'))
                    ->where('pkm_prdcd','=',$request->plu)
                    ->first();

                if(!$kkpkm){
                    return response()->json([
                        'message' => 'PLU tidak terdaftar di Tabel KKPKM!'
                    ], 500);
                }
                else{
                    $data->pkm_pkmt = $kkpkm->pkm_pkmt;
                    $data->pkm_qtyaverage = $kkpkm->pkm_qtyaverage;

                    $pkmplus = DB::connection(Session::get('connection'))
                        ->table('tbmaster_pkmplus')
                        ->selectRaw("nvl(pkmp_qtyminor, 0) pkmp_qtyminor")
                        ->where('pkmp_kodeigr','=',Session::get('kdigr'))
                        ->where('pkmp_prdcd','=',$request->plu)
                        ->first();

                    if(!$pkmplus){
                        $data->qtym = 0;
                        $data->baru = 'Y';
                        $data->qtyminor = 0;
                    }
                    else{
                        $data->qtym = $pkmplus->pkmp_qtyminor;
                        $data->baru = 'N';
                        $data->qtyminor = $data->qtym;
                    }

                    $prodcrm = DB::connection(Session::get('connection'))
                        ->table('tbmaster_prodcrm')
                        ->where('prc_kodeigr','=',Session::get('kdigr'))
                        ->where('prc_pluigr','=',$request->plu)
                        ->whereNotIn('prc_kodetag',['A','R','N','O','H','X'])
                        ->first();

                    if($prodcrm)
                        $data->omi = '*';
                    else $data->omi = '';

                    return response()->json($data);
                }
            }
        }
    }

    public function getTableData(){
        $data = DB::connection(Session::get('connection'))
            ->table('tbmaster_pkmplus')
            ->join('tbmaster_prodmast',function($join){
                $join->on('pkmp_kodeigr','=','prd_kodeigr');
                $join->on('pkmp_prdcd','=','prd_prdcd');
            })
            ->leftJoin('tbmaster_kkpkm',function($join){
                $join->on('pkm_kodeigr','=','pkmp_kodeigr');
                $join->on('pkm_prdcd','=','pkmp_prdcd');
            })
            ->leftJoin('tbmaster_prodcrm',function($join){
                $join->on('prc_kodeigr','=','pkmp_kodeigr');
                $join->on('prc_pluigr','=','pkmp_prdcd');
            })
            ->selectRaw("pkmp_prdcd, prd_deskripsipanjang, prd_unit || '/' || prd_frac unit,
                nvl(pkm_pkmt,0) pkm_pkmt, nvl(pkm_qtyaverage, 0) pkm_qtyaverage,
                case
                    when prc_kodetag not in ('A','R','N','O','H','X') and prc_pluigr is not null
                        then '*'
                    else ''
                end omi,
                pkmp_qtyminor
            ")
            ->where('pkmp_kodeigr','=',Session::get('kdigr'))
            ->orderBy('pkmp_prdcd')
            ->orderBy('omi')
            ->limit(100)
            ->get();

        $finalData = [];

//        foreach($data as $d){
//            $temp = DB::connection(Session::get('connection'))
//                ->table('tbmaster_prodcrm')
//                ->where('prc_kodeigr','=',Session::get('kdigr'))
//                ->where('prc_pluigr','=',$d->pkmp_prdcd)
//                ->whereNotIn('prc_kodetag',['A','R','N','O','H','X'])
//                ->first();
//
//            if($temp){
//                $d->omi = '*';
//            }
//            else $d->omi = '';
//
//            $finalData[] = $d;
//        }

        $temp = null;
        foreach($data as $d){
            if($temp == $d->pkmp_prdcd){
                continue;
            }
            if($temp != $d->pkmp_prdcd){
                $temp = $d->pkmp_prdcd;
                $finalData[] = $d;
            }
        }

        return DataTables::of($finalData)->make(true);
    }

    public function save(Request $request){
        try{
            DB::connection(Session::get('connection'))
                ->beginTransaction();

            $data = DB::connection(Session::get('connection'))
                ->table('tbmaster_prodmast')
                ->selectRaw("prd_kodedivisi, prd_kodedepartement, prd_kodekategoribarang")
                ->where('prd_kodeigr','=',Session::get('kdigr'))
                ->where('prd_prdcd','=',$request->plu)
                ->first();

            if($request->baru == 'Y'){
                DB::connection(Session::get('connection'))
                    ->table('tbmaster_pkmplus')
                    ->insert([
                        'pkmp_kodeigr' => Session::get('kdigr'),
                        'pkmp_kodedivisi' => $data->prd_kodedivisi,
                        'pkmp_kodedepartemen' => $data->prd_kodedepartement,
                        'pkmp_kodekategoribrg' => $data->prd_kodekategoribarang,
                        'pkmp_prdcd' => $request->plu,
                        'pkmp_qtyminor' => $request->qtymplus,
                        'pkmp_create_by' => Session::get('usid'),
                        'pkmp_create_dt' => Carbon::now()
                    ]);

                DB::connection(Session::get('connection'))
                    ->update("UPDATE tbmaster_kkpkm
                   SET pkm_pkmt = NVL(pkm_pkmt	, 0) + ".$request->qtymplus.",
                         pkm_qtymplus = ".$request->qtymplus.",
                       pkm_modify_by = '".Session::get('usid')."',
                       pkm_modify_dt = SYSDATE
                 WHERE pkm_kodeigr = '".Session::get('kdigr')."' AND pkm_prdcd = '".$request->plu."'");
            }
            else{
                DB::connection(Session::get('connection'))
                    ->table('tbmaster_pkmplus')
                    ->where('pkmp_kodeigr','=',Session::get('kdigr'))
                    ->where('pkmp_prdcd','=',$request->plu)
                    ->update([
                        'pkmp_qtyminor' => $request->qtymplus,
                        'pkmp_modify_by' => Session::get('usid'),
                        'pkmp_modify_dt' => Carbon::now()
                    ]);

                DB::connection(Session::get('connection'))
                    ->update("UPDATE tbmaster_kkpkm
               SET pkm_pkmt =((NVL(pkm_pkmt, 0) - ".$request->qtyminor.") + ".$request->qtymplus."),
                   pkm_qtymplus = ".$request->qtymplus.",
                   pkm_modify_by = '".Session::get('usid')."',
                   pkm_modify_dt = SYSDATE
             WHERE pkm_kodeigr = '".Session::get('kdigr')."' AND pkm_prdcd = '".$request->plu."'");
            }

            DB::connection(Session::get('connection'))
                ->commit();

            return response()->json([
                'title' => 'Data berhasil disimpan!'
            ], 200);
        }
        catch (\Exception $e){
            DB::connection(Session::get('connection'))
                ->rollBack();

            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function delete(Request $request){
        try{
            DB::connection(Session::get('connection'))
                ->beginTransaction();

            $pkmplus = DB::connection(Session::get('connection'))
                ->table('tbmaster_pkmplus')
                ->selectRaw("nvl(pkmp_qtyminor, 0) pkmp_qtyminor")
                ->where('pkmp_kodeigr','=',Session::get('kdigr'))
                ->where('pkmp_prdcd','=',$request->plu)
                ->first();

            if(!$pkmplus)
                $qtym = 0;
            else $qtym = $pkmplus->pkmp_qtyminor;

            DB::connection(Session::get('connection'))
                ->table('tbmaster_pkmplus')
                ->where('pkmp_kodeigr','=',Session::get('kdigr'))
                ->where('pkmp_prdcd','=',$request->plu)
                ->delete();

            DB::connection(Session::get('connection'))
                ->update("UPDATE tbmaster_kkpkm
                   SET pkm_pkmt = NVL(pkm_pkmt, 0) - ".$qtym.",
                       pkm_qtymplus = 0,
                       pkm_modify_by = '".Session::get('usid')."',
                       pkm_modify_dt = SYSDATE
                 WHERE pkm_kodeigr = '".Session::get('kdigr')."' AND pkm_prdcd = '".$request->plu."'");

            DB::connection(Session::get('connection'))
                ->commit();

            return response()->json([
                'title' => 'Data berhasil dihapus!'
            ], 200);
        }
        catch (\Exception $e){
            DB::connection(Session::get('connection'))
                ->rollBack();

            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function printTag(){
        $perusahaan = DB::connection(Session::get('connection'))
            ->table('tbmaster_perusahaan')
            ->first();

        $data = DB::connection(Session::get('connection'))
            ->select("SELECT * FROM (
                SELECT pkmp_prdcd, prd_deskripsipanjang,
                prd_unit || '/' || TO_CHAR(prd_frac, '9999') unit,
                prc_pluigr, prc_kodetag, case when nvl(prc_pluigr,'1234567') = '1234567' then 'Tdk Ada Di PRODCRM' else '' end keterangan,
                pkm_qtyaverage, pkmp_qtyminor
                FROM tbmaster_pkmplus, tbmaster_prodmast, tbmaster_prodcrm, tbmaster_kkpkm
                WHERE pkmp_kodeigr = '".Session::get('kdigr')."'
                AND prd_kodeigr = pkmp_kodeigr AND prd_prdcd = pkmp_prdcd
                AND prc_kodeigr(+) = pkmp_kodeigr AND prc_pluigr(+) = pkmp_prdcd
                AND pkm_kodeigr(+) = pkmp_kodeigr AND pkm_prdcd(+) = pkmp_prdcd
                ORDER BY pkmp_prdcd
                ) a
                WHERE NVL(prc_pluigr, '1234567') = '1234567'  OR (NVL(prc_pluigr, '1234567') <> '1234567'
                AND NVL(prc_kodetag,'1') IN ('A', 'R', 'N', 'O', 'H', 'X'))
                order by pkmp_prdcd");

//        dd($data);

        return view('BACKOFFICE.PKM.entry-tabel-qty-mplus-print-tag-pdf',compact(['perusahaan','data']));
    }

    public function printAll(){
        $perusahaan = DB::connection(Session::get('connection'))
            ->table('tbmaster_perusahaan')
            ->first();

        $data = DB::connection(Session::get('connection'))
            ->select("SELECT pkmp_prdcd, prd_deskripsipanjang,
                prd_unit || '/' || TO_CHAR(prd_frac, '9999') unit, prd_kodetag,
                pkm_qtyaverage, pkmp_qtyminor
                FROM tbmaster_pkmplus, tbmaster_kkpkm, tbmaster_prodmast
                WHERE pkmp_kodeigr = '".Session::get('kdigr')."'
                AND pkm_kodeigr(+) = pkmp_kodeigr AND pkm_prdcd(+) = pkmp_prdcd
                AND prd_kodeigr(+) = pkmp_kodeigr AND prd_prdcd(+) = pkmp_prdcd
                ORDER BY pkmp_prdcd");

        return view('BACKOFFICE.PKM.entry-tabel-qty-mplus-print-all-pdf',compact(['perusahaan','data']));
    }

    public function uploadCSV(Request $request){
        try{
            DB::connection(Session::get('connection'))->beginTransaction();

            $user = DB::connection(Session::get('connection'))
                ->table('tbmaster_user')
                ->where('kodeigr','=',Session::get('kdigr'))
                ->where('userid','=',$request->user)
                ->where('userpassword','=',$request->pass)
                ->where('userlevel','=','1')
                ->first();

            if(!$user){
                return response()->json([
                    'message' => 'Kode Otorisasi MGR tidak terdaftar!'
                ], 500);
            }
            else{
                $connect = loginController::getConnectionProcedure();

                $query = oci_parse($connect, "BEGIN sp_proses_trf_plu_mplus_php('PLU_MPLUS.CSV', :p_sukses, :hasil); END;");
                oci_bind_by_name($query, ':p_sukses', $p_sukses, 10);
                oci_bind_by_name($query, ':hasil', $hasil, 1000);
                oci_execute($query);

                if($p_sukses == 'FALSE'){
                    if(substr($hasil, 24,9) == 'ORA-29283'){
                        return response()->json([
                            'message' => 'Data PLU_MPLUS.CSV tidak ada!'
                        ], 500);
                    }
                    else{
                        return response()->json([
                            'message' => $hasil
                        ], 500);
                    }
                }
                else{
                    $data = DB::connection(Session::get('connection'))
                        ->select("SELECT SUBSTR ('0000000' || mpl_plu, LENGTH (mpl_plu) + 1, 7)
                          mpl_plu,
                       nvl(mpl_qty, 0) mpl_qty,
                       prd_kodedivisi,
                       prd_kodedepartement,
                       prd_kodekategoribarang
                  FROM tbtemp_plumplus, tbmaster_prodmast
                 WHERE prd_Prdcd = SUBSTR ('0000000' || mpl_plu, LENGTH (mpl_plu) + 1,7)");

                    foreach($data as $d){
                        $temp = DB::connection(Session::get('connection'))
                            ->table('tbmaster_kkpkm')
                            ->selectRaw("NVL (pkm_pkmt, 0) pkm_pkmt")
                            ->where('pkm_kodeigr','=',Session::get('kdigr'))
                            ->where('pkm_prdcd','=',$d->mpl_plu)
                            ->first();

                        if(!$temp){
                            $pkmtold = 0;
                        }
                        else $pkmtold = $temp->pkm_pkmt;

                        $temp = DB::connection(Session::get('connection'))
                            ->table('tbmaster_pkmplus')
                            ->selectRaw("nvl(pkmp_qtyminor, 0) pkmp_qtyminor")
                            ->where('pkmp_kodeigr','=',Session::get('connection'))
                            ->where('pkmp_prdcd','=',$d->mpl_plu)
                            ->first();

                        if(!$temp){
                            $mplusold = 0;
                            $qtyminor = 0;

                            DB::connection(Session::get('connection'))
                                ->table('tbmaster_pkmplus')
                                ->insert([
                                    'pkmp_kodeigr' => Session::get('kdigr'),
                                    'pkmp_kodedivisi' => $d->prd_kodedivisi,
                                    'pkmp_kodedepartemen' => $d->prd_kodedepartement,
                                    'pkmp_kodekategoribrg' => $d->prd_kodekategoribarang,
                                    'pkmp_prdcd' => $d->mpl_plu,
                                    'pkmp_qtyminor' => $d->mpl_qty,
                                    'pkmp_create_by' => Session::get('usid'),
                                    'pkmp_create_dt' => Carbon::now()
                                ]);

                            DB::connection(Session::get('connection'))
                                ->update("UPDATE tbmaster_kkpkm
                              SET pkm_pkmt = NVL (pkm_pkmt, 0) + ".$d->mpl_qty.",
                                  pkm_qtymplus = ".$d->mpl_qty.",
                                  pkm_modify_by = '".Session::get('usid')."',
                                  pkm_modify_dt = SYSDATE
                              WHERE pkm_kodeigr = '".Session::get('kdigr')."'
                              AND pkm_prdcd = '".$d->mpl_plu."'");
                        }
                        else{
                            $mplusold = $temp->pkmp_qtyminor;

                            DB::connection(Session::get('connection'))
                                ->table('tbmaster_pkmplus')
                                ->where('pkmp_kodeigr','=',Session::get('kdigr'))
                                ->where('pkmp_prdcd','=',$d->mpl_plu)
                                ->update([
                                    'pkmp_qtyminor' => $d->mpl_qty,
                                    'pkmp_modify_by' => Session::get('usid'),
                                    'pkmp_modify_dt' => Carbon::now()
                                ]);

                            DB::connection(Session::get('connection'))
                                ->update("UPDATE tbmaster_kkpkm
                                  SET pkm_pkmt =
                                         (  (NVL (pkm_pkmt, 0) - ".$qtyminor.")
                                          + ".$d->mpl_qty."),
                                      pkm_qtymplus = ".$d->mpl_qty.",
                                      pkm_modify_by = '".Session::get('usid')."',
                                      pkm_modify_dt = SYSDATE
                                WHERE     pkm_kodeigr = '".Session::get('kdigr')."'
                                      AND pkm_prdcd = '".$d->mpl_plu."'");
                        }

                        $pkmtnew = $pkmtold - $mplusold + $d->mpl_qty;

                        DB::connection(Session::get('connection'))
                            ->table('tbhistory_pkmplus')
                            ->insert([
                                'hmp_plu' => $d->mpl_plu,
                                'hmp_minor' => $mplusold,
                                'hmp_oldpkmt' => $pkmtold,
                                'hmp_mplus' => $d->mpl_qty,
                                'hmp_newpkmt' => $pkmtnew,
                                'hmp_otorisasi' => $request->user,
                                'hmp_create_by' => Session::get('usid'),
                                'hmp_create_dt' => Carbon::now()
                            ]);
                    }

                    DB::connection(Session::get('connection'))
                        ->commit();

                    return response()->json([
                        'message' => 'Data CSV sudah selesai diupload!'
                    ], 200);
                }
            }
        }
        catch (\Exception $e){
            DB::connection(Session::get('connection'))->rollBack();

            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
