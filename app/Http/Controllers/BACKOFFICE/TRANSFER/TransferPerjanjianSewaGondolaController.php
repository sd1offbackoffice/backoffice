<?php

namespace App\Http\Controllers\BACKOFFICE\TRANSFER;

use App\Http\Controllers\Auth\loginController;
use Carbon\Carbon;
use FontLib\Table\Table;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller; use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use PDF;
use XBase\TableReader;
use Yajra\DataTables\DataTables;
use File;
use ZipArchive;

class TransferPerjanjianSewaGondolaController extends Controller
{
    public function index(){
        return view('BACKOFFICE.TRANSFER.transfer-perjanjian-sewa-gondola');
    }

    public function transferFileDBF(Request $request){
        set_time_limit(0);

        $isZip = false;
        $fileDBF = $request->file('fileDBF');

        if(strtoupper($fileDBF->getClientOriginalExtension()) === 'ZIP'){
            File::delete(public_path('TRANSFERPERJANJIANSEWAGONDOLA'));

            $zip = new ZipArchive;

            $list = [];

            if ($zip->open($fileDBF) === TRUE) {
                for ($i = 0; $i < $zip->numFiles; $i++) {
                    $entry = $zip->getNameIndex($i);
                    $list[] = $entry;
                }

                $zip->extractTo(public_path('TRANSFERPERJANJIANSEWAGONDOLA'));
                $zip->close();
            } else {
                $status = 'error';
                $alert = 'Terjadi kesalahan!';
                $message = 'Mohon pastikan file zip berasal dari program Transfer SJ - IAS!';

                return compact(['status', 'alert', 'message']);
            }

            $temp = File::allFiles(public_path('TRANSFERPERJANJIANSEWAGONDOLA'));

            if(count($temp) != 1){
                return response()->json([
                    'message' => 'File zip hanya boleh berisi satu file saja!',
                    'status' => 'error'
                ], 500);
            }
            else{
                $isZip = true;
                $fileDBF = $temp[0];
            }
        }

        try{
            DB::connection(Session::get('connection'))->beginTransaction();
//            $sesiproc = DB::connection(Session::get('connection'))->selectOne("select TO_CHAR (USERENV ('SESSIONID')) userenv from dual")->userenv;

            $sesiproc = '9999999';
            $lok = false;

//            dd($sesiproc);

            $v_filename = substr($isZip ? $fileDBF->getFilename() : $fileDBF->getClientOriginalName(), 0, 8).'.DBF';
            $v_file = $fileDBF;

//            $pdo = DB::getPdo();
//            $sql = "INSERT INTO t_file_transfer (ftuser, ftfile)
//        VALUES ('".$sesiproc."', EMPTY_BLOB())
//        RETURNING ftfile INTO :blob";
//            $stmt = $pdo->prepare($sql);
//            $stmt->bindParam(':blob', $v_file, \PDO::PARAM_LOB);
//            $stmt->execute();

            $datafileDBF = new TableReader($fileDBF);

//            dd($datafileDBF);

            $insert = [];

            while($recs = $datafileDBF->nextRecord()){
                $temp = [];

                $temp['RECID'] = $recs->get('recid');
                $temp['NOPJSEWA'] = $recs->get('nopjsewa');
                $temp['PRDCD'] = $recs->get('prdcd');
                $temp['KDPRINCIPAL'] = $recs->get('kdprincpl');
                $temp['QTY'] = $recs->get('qty');
                $temp['KDISPLAY'] = $recs->get('kdisplay');
                $temp['KCAB'] = $recs->get('kcab');
                $temp['TGLMULAI'] = $recs->get('tglmulai');
                $temp['TGLSELESAI'] = $recs->get('tglselesai');
                $temp['TGLUPD'] = $recs->get('tglupd');

                $insert[] = $temp;
            }

//            dd($insert);

            DB::connection(Session::get('connection'))->statement("truncate table temp_gdl");

            DB::connection(Session::get('connection'))
                ->table('temp_gdl')
                ->insert($insert);

            DB::connection(Session::get('connection'))
                ->table('tbtr_status')
                ->insert([
                    'sts_kodeigr' => Session::get('kdigr'),
                    'sts_program' => 'IGR_BO_TRF_GONDOLA',
                    'sts_user' => Session::get('usid'),
                    'sts_tanggal' => Carbon::now(),
                    'sts_jammulai' => Carbon::now()->format('H:i:s')
                ]);

            DB::connection(Session::get('connection'))->statement("truncate table temp_gdl2");

            DB::connection(Session::get('connection'))->commit();

            return self::fillGdl2();
        }
        catch(QueryException $e){
            DB::connection(Session::get('connection'))->rollBack();

            return $e->getMessage();
        }
    }

    public static function fillGdl2(){
        set_time_limit(0);

        try{
            $recs = DB::connection(Session::get('connection'))
                ->table('temp_gdl')
                ->get();

            foreach($recs as $rec){
                if($rec->kcab == Session::get('kdigr')){
                    DB::connection(Session::get('connection'))
                        ->table('temp_gdl2')
                        ->insert([
                            'ftnpjs' => $rec->nopjsewa,
                            'ftkode' => $rec->prdcd,
                            'ftkpcp' => $rec->kdprincipal,
                            'ftkqty' => intval($rec->qty),
                            'ftkdis' => $rec->kdisplay,
                            'ftfrtg' => Carbon::createFromFormat('Ymd',$rec->tglmulai),
                            'fttotg' => Carbon::createFromFormat('Ymd',$rec->tglselesai)
                        ]);

                    if($rec->recid == '1'){
                        $jum = DB::connection(Session::get('connection'))
                            ->table('tbtr_gondola')
                            ->where('gdl_noperjanjiansewa','=',$rec->nopjsewa)
                            ->where('gdl_prdcd','=',$rec->prdcd)
                            ->where('gdl_kodedisplay','=',$rec->kdisplay)
                            ->where('gdl_kodecabang','=',$rec->kcab)
                            ->where('gdl_tglawal','=',Carbon::createFromFormat('Ymd',$rec->tglmulai))
                            ->where('gdl_tglakhir','=',Carbon::createFromFormat('Ymd',$rec->tglselesai))
                            ->first();

                        if($jum){
                            DB::connection(Session::get('connection'))
                                ->table('tbtr_gondola')
                                ->where('gdl_noperjanjiansewa','=',$rec->nopjsewa)
                                ->where('gdl_prdcd','=',$rec->prdcd)
                                ->where('gdl_kodedisplay','=',$rec->kdisplay)
                                ->where('gdl_kodecabang','=',$rec->kcab)
                                ->where('gdl_tglawal','=',Carbon::createFromFormat('Ymd',$rec->tglmulai))
                                ->where('gdl_tglakhir','=',Carbon::createFromFormat('Ymd',$rec->tglselesai))
                                ->update([
                                    'gdl_recordid' => $rec->recid,
                                    'gdl_modify_by' => Session::get('usid'),
                                    'gdl_modify_dt' => Carbon::now()
                                ]);
                        }
                    }
                    else{
                        $jum = DB::connection(Session::get('connection'))
                            ->table('tbtr_gondola')
                            ->where('gdl_noperjanjiansewa','=',$rec->nopjsewa)
                            ->where('gdl_prdcd','=',$rec->prdcd)
                            ->where('gdl_kodedisplay','=',$rec->kdisplay)
                            ->where('gdl_kodecabang','=',$rec->kcab)
                            ->first();

                        if($jum){
                            DB::connection(Session::get('connection'))
                                ->table('tbtr_gondola')
                                ->where('gdl_noperjanjiansewa','=',$rec->nopjsewa)
                                ->where('gdl_prdcd','=',$rec->prdcd)
                                ->where('gdl_kodedisplay','=',$rec->kdisplay)
                                ->where('gdl_kodecabang','=',$rec->kcab)
                                ->where('gdl_tglawal','=',Carbon::createFromFormat('Ymd',$rec->tglmulai))
                                ->where('gdl_tglakhir','=',Carbon::createFromFormat('Ymd',$rec->tglselesai))
                                ->update([
                                    'gdl_qty' => intval($rec->qty),
                                    'gdl_tglawal' => Carbon::createFromFormat('Ymd',$rec->tglmulai),
                                    'gdl_tglakhir' => Carbon::createFromFormat('Ymd',$rec->tglselesai),
                                    'gdl_modify_by' => Session::get('usid'),
                                    'gdl_modify_dt' => Carbon::now()
                                ]);
                        }
                        else{
//                            INSERT INTO TBTR_GONDOLA
//                            (GDL_KODEIGR, GDL_NOPERJANJIANSEWA, GDL_PRDCD, GDL_QTY,
//                                GDL_KODECABANG, GDL_KODEDISPLAY, GDL_TGLAWAL, GDL_TGLAKHIR,
//                                GDL_KODEPRINCIPAL, GDL_CREATE_BY, GDL_CREATE_DT
//                            )
//                         VALUES (:GLOBAL.KDIGR, REC.NOPJSEWA, REC.PRDCD, TO_NUMBER (REC.QTY),
//                                 REC.KCAB, REC.KDISPLAY, REC.TGLMULAI, REC.TGLSELESAI,
//                                 REC.KDPRINCIPAL, :GLOBAL.USID, SYSDATE
//                                );
//
                            DB::connection(Session::get('connection'))
                                ->table('tbtr_gondola')
                                ->insert([
                                    'gdl_kodeigr' => Session::get('kdigr'),
                                    'gdl_noperjanjiansewa' => $rec->nopjsewa,
                                    'gdl_prdcd' => $rec->prdcd,
                                    'gdl_qty' => intval($rec->qty),
                                    'gdl_kodecabang' => $rec->kcab,
                                    'gdl_kodedisplay' => $rec->kdisplay,
                                    'gdl_tglawal' => Carbon::createFromFormat('Ymd',$rec->tglmulai),
                                    'gdl_tglakhir' => Carbon::createFromFormat('Ymd',$rec->tglselesai),
                                    'gdl_kodeprincipal' => $rec->kdprincipal,
                                    'gdl_create_by' => Session::get('usid'),
                                    'gdl_create_dt' => Carbon::now()
                                ]);
                        }
                    }
                }
            }

            DB::connection(Session::get('connection'))->commit();

            return response()->json([
                'message' => 'Proses transfer berhasil!'
            ], 200);
        }
        catch (QueryException $e){
            DB::connection(Session::get('connection'))->rollBack();

            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public static function print(){
        $perusahaan = DB::connection(Session::get('connection'))
            ->table('tbmaster_perusahaan')
            ->first();

        $data = DB::connection(Session::get('connection'))
            ->table('temp_gdl2')
            ->leftJoin('tbmaster_prodmast',function($join){
                $join->on('prd_prdcd','=','ftkode');
            })
            ->selectRaw("ftnpjs, ftkode, prd_deskripsipendek, prd_unit, prd_frac, ftkpcp, ftkdis,
                ftkqty, to_char(ftfrtg, 'dd/mm/yyyy') ftfrtg, to_char(fttotg, 'dd/mm/yyyy') fttotg")
            ->orderBy('ftnpjs')
            ->get();

        return view('BACKOFFICE.TRANSFER.transfer-perjanjian-sewa-gondola-pdf', compact(['perusahaan','data']));
    }

    public static function nvl($value, $default){
        if($value == null || $value == '')
            return $default;
        else return $value;
    }
}
