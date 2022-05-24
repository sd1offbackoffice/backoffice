<?php

namespace App\Http\Controllers\BACKOFFICE\PKM;

use App\Http\Controllers\Auth\loginController;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;
use PDF;
use Symfony\Component\VarDumper\Cloner\Data;
use Yajra\DataTables\DataTables;

// CREATE INI DULU
//
// sp_transfer_usulanpkm_migrasi
//
//CREATE TABLE TBTEMP_EDITPKM_MIGRASI
//(
//    NO_USULAN   VARCHAR2(10 BYTE),
//  TGL_USULAN  VARCHAR2(10 BYTE),
//  PRDCD       VARCHAR2(10 BYTE),
//  PKM_EDIT    VARCHAR2(10 BYTE),
//  MPLUS_EDIT  VARCHAR2(10 BYTE),
//  KODEIGR     VARCHAR2(3 BYTE)
//)

//sp_transfer_pkmprodbaru_mig
//
//CREATE TABLE tbtemp_pkmbaru_migrasi
//(
//    KODEIGR   VARCHAR2(50 BYTE),
//  NOUSULAN VARCHAR2(50 BYTE),
//  TGLUSULAN VARCHAR2(50 BYTE),
//  PRDCD    VARCHAR2(50 BYTE),
//  MPKM VARCHAR2(50 BYTE),
//  PKM VARCHAR2(50 BYTE),
//  MPLUS_I VARCHAR2(50 BYTE),
//  MPLUS_O VARCHAR2(50 BYTE),
//  PKMT VARCHAR2(50 BYTE),
//  CREATE_BY VARCHAR2(50 BYTE),
//  CREATE_DT VARCHAR2(50 BYTE)
//)

class EditPKMController extends Controller
{
    public function index(){
//        $d = DB::connection('igrphi')
//            ->table('tbmaster_perusahaan')
//            ->first();
//
//        dd($d);

        return view('BACKOFFICE.PKM.edit-pkm');
    }

    public function getDataLovUsulan(){
        $lov = DB::connection(Session::get('connection'))
            ->select("select distinct upkm_nousulan dok, to_char(upkm_tglusulan,'dd/mm/yyyy') tgl,
                case when upkm_status ='0' then 'EDIT'
                 when upkm_status ='K' then 'SUDAH DIKIRIM'
                 when upkm_status ='A' then 'SUDAH DISETUJUI' end stat
                 from tbtr_usulanpkm
                where nvl(upkm_recordid,'_') <> '1'
                 order by 1 desc");

        return DataTables::of($lov)->make(true);
    }

    public function getDataLovPlu(){
        $lov = DB::connection(Session::get('connection'))->table('tbmaster_prodmast')
            ->selectRaw("PRD_PRDCD, PRD_UNIT||'/'||TO_CHAR(PRD_FRAC) SATUAN, PRD_DESKRIPSIPANJANG")
            ->where('prd_kodeigr',Session::get('kdigr'))
            ->whereRaw("SUBSTR(PRD_PRDCD,7,1)='0'")
            ->whereRaw("nvl(prd_recordid,9)<>1")
            ->orderBy('prd_prdcd')
            ->limit(200)
            ->get();

        return DataTables::of($lov)->make(true);
    }

    public function checkUsulan(Request $request){
//        select count(1) into temp from tbtr_usulanpkm
//      where upkm_status <> 'A'
//        and nvl(upkm_recordid,'_') <> '1';

        $usulan = DB::connection(Session::get('connection'))
            ->table('tbtr_usulanpkm')
            ->where('upkm_status','<>','A')
            ->whereRaw("nvl(upkm_recordid,'_') <> '1'")
            ->first();

        $found = DB::connection(Session::get('connection'))
            ->table('tbtr_usulanpkm')
            ->where('upkm_status','<>','A')
            ->whereRaw("nvl(upkm_recordid,'_') <> '1'")
            ->where('upkm_nousulan','=',$request->nousulan)
            ->first();

        if($usulan && !$found){
            return response()->json([
                'status' => 'error',
                'message' => 'Masih ada usulan Edit PKM!',
            ], 200);
        }
        else{
            return response()->json([
                'status' => 'success'
            ], 200);
        }
    }

    public function getNewNoUsulan(){
        $seq = DB::connection(Session::get('connection'))
            ->selectOne("select nvl(max( to_number( substr(upkm_nousulan,6) ) ),0)+1 seq
                                from tbtr_usulanpkm");

        $nousulan = 'PKM'.Session::get('kdigr').substr('00000'.$seq->seq,-5);
        $tglusulan = Carbon::now()->format('d/m/Y');

        return response()->json(compact(['nousulan','tglusulan']),200);
    }

    public function getDataUsulan(Request $request){
        $data = DB::connection(Session::get('connection'))
            ->table('tbtr_usulanpkm')
            ->join('tbmaster_prodmast',function($join){
                $join->on('prd_prdcd','=','upkm_prdcd');
                $join->on('prd_kodeigr','=','upkm_kodeigr');
            })
            ->leftJoin('tbtr_pkmsales','psl_prdcd','=','upkm_prdcd')
            ->where('upkm_nousulan','=',$request->nousulan)
            ->whereRaw("nvl(upkm_recordid,'0') <> '1'")
            ->get();

        if(count($data) == 0){
            return response()->json([
                'message' => 'Dokumen tidak ditemukan!',
            ], 500);
        }
        else{
            return response()->json($data, 200);
        }
    }

    public function deleteTrn(Request $request){
        try{
            DB::connection(Session::get('connection'))->beginTransaction();

            DB::connection(Session::get('connection'))->table('tbtr_tac')
                ->where('tac_kodeigr',Session::get('kdigr'))
                ->where('tac_nodoc',$request->notrn)
                ->delete();

            DB::connection(Session::get('connection'))->table('tbtr_backoffice')
                ->where('trbo_typetrn','O')
                ->where('trbo_nodoc',$request->notrn)
                ->delete();

            DB::connection(Session::get('connection'))->commit();

            $status = 'success';
            $title = 'Berhasil menghapus data '.$request->notrn;
            $message = '';
        }
        catch (QueryException $e){
            DB::connection(Session::get('connection'))->rollBack();

            $status = 'error';
            $title = 'Gagal menghapus data '.$request->notrn;
            $message = $e->getMessage();
        }

        return compact(['status','title','message']);
    }

    public function getDataPlu(Request $request){
        $data = DB::connection(Session::get('connection'))
            ->table('tbmaster_kkpkm')
            ->join('tbmaster_prodmast',function($join){
                $join->on('prd_kodeigr','=','pkm_kodeigr');
                $join->on('prd_prdcd','=','pkm_prdcd');
            })
            ->leftJoin('tbtr_pkmsales','psl_prdcd','=','prd_prdcd')
            ->where('pkm_prdcd','=',$request->prdcd)
            ->first();

        if(!$data){
            return response()->json([
                'message' => 'PLU tidak terdaftar di Master PKM!'
            ], 500);
        }
        else return response()->json($data);
    }

    public function sendUsulan(Request $request){
        $nousulan = $request->nousulan;
        $tglusulan = $request->tglusulan;

        $c = loginController::getConnectionProcedure();
        $sql = "BEGIN sp_usulanpkm('" . Session::get('kdigr') . "','".$nousulan."',to_date('" . $tglusulan . "','dd/mm/yyyy'),:err_txt); END;";
        $s = oci_parse($c, $sql);
        oci_bind_by_name($s, ':err_txt', $err_txt, 200);
        oci_execute($s);

        if($err_txt == ''){
            return response()->json([
                'message' => 'Usulan berhasil dikirim!'
            ], 200);
        }
        else{
            return response()->json([
                'message' => 'Usulan gagal dikirim!',
                'error' => $err_txt
            ], 500);
        }
    }

    public function saveUsulan(Request $request){
        try{
            $nousulan = $request->nousulan;
            $tglusulan = $request->tglusulan;
            $data = json_decode(json_encode($request->arrData, true));

            DB::connection(Session::get('connection'))
                ->beginTransaction();

            foreach($data as $d){
                $temp = DB::connection(Session::get('connection'))
                    ->selectOne("select pkm_mindisplay+pkm_minorder min_pkm
					from tbmaster_kkpkm
					where pkm_prdcd = '".$d->prdcd."'");

                if(!$temp){
                    return response()->json([
                        'message' => 'PLU tidak terdaftar di Master PKM!'
                    ], 500);
                }
                else if($d->pkmusulan < $temp->min_pkm){
                    return response()->json([
                        'message' => 'Nilai PKM < MINDIS + MINOR ('.$temp->min_pkm.')'
                    ], 500);
                }
            }

            $arrPLU = [];
            foreach($data as $d){
                $arrPLU[] = $d->prdcd;

                $found = DB::connection(Session::get('connection'))
                    ->table('tbtr_usulanpkm')
                    ->where('upkm_nousulan','=',$nousulan)
                    ->where('upkm_prdcd','=',$d->prdcd)
                    ->first();

                if(!$found){
                    DB::connection(Session::get('connection'))
                        ->table('tbtr_usulanpkm')
                        ->insert([
                            'upkm_kodeigr' => Session::get('kdigr'),
                            'upkm_recordid' => null,
                            'upkm_nousulan' => $nousulan,
                            'upkm_tglusulan' => Carbon::createFromFormat('d/m/Y',$tglusulan),
                            'upkm_prdcd' => $d->prdcd,
                            'upkm_mpkm_awal' => $d->mpkmawal,
                            'upkm_pkmadjust_awal' => $d->pkmadjustawal,
                            'upkm_mplus_awal' => $d->mplusawal,
                            'upkm_pkmt_awal' => $d->pkmtawal,
                            'upkm_pkm_usulan' => $d->pkmusulan,
                            'upkm_mplus_usulan' => $d->mplususulan,
                            'upkm_pkm_edit' => $d->pkmedit,
                            'upkm_mplus_edit' => $d->mplusedit,
                            'upkm_status' => 0,
                            'upkm_approval' => null,
                            'upkm_keterangan' => null,
                            'upkm_tglproses' => null,
                            'upkm_create_by' => Session::get('usid'),
                            'upkm_create_dt' => Carbon::now(),
                            'upkm_modify_by' => null,
                            'upkm_modify_dt' => null
                        ]);
                }
                else{
                    DB::connection(Session::get('connection'))
                        ->table('tbtr_usulanpkm')
                        ->where('upkm_nousulan','=',$nousulan)
                        ->where('upkm_prdcd','=',$d->prdcd)
                        ->update([
                            'upkm_pkm_usulan' => $d->pkmusulan,
                            'upkm_mplus_usulan' => $d->mplususulan,
                            'upkm_modify_by' => Session::get('usid'),
                            'upkm_modify_dt' => Carbon::now()
                        ]);
                }
            }

            DB::connection(Session::get('connection'))
                ->table('tbtr_usulanpkm')
                ->where('upkm_nousulan','=',$nousulan)
                ->whereNotIn('upkm_prdcd',$arrPLU)
                ->delete();

            DB::connection(Session::get('connection'))
                ->commit();

            return response()->json([
                'message' => 'Berhasil menyimpan usulan!',
            ], 200);
        }
        catch(\Exception $e){
            DB::connection(Session::get('connection'))
                ->rollBack();

            return response()->json([
                'message' => 'Gagal menyimpan usulan!',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function downloadFormatUsulan(){
        return response()->download(public_path('/EDITPKM/FORMAT_USULAN_PKM.CSV'))->deleteFileAfterSend(false);
    }

    public function uploadFileUsulan(Request $request){
        $filename = $request->file('fileUsulan');
        $noUsulan = $request->noUsulan;
        $tglUsulan = $request->tglUsulan;

        $header = NULL;
        $data = array();
        try {
            if (($handle = fopen($filename, 'r')) !== FALSE) {
                while (($row = fgetcsv($handle, 1000, '|', '#', '/')) !== FALSE) {
                    $skip = false;
                    if (!$header){
                        $header = $row;
                        if($header != ['PRDCD','PKM_USULAN','MPLUS_USULAN']){
                            return response()->json([
                                'message' => 'File CSV yang diupload tidak sesuai format!'
                            ], 500);
                        }
                    }
                    else {
                        foreach ($row as $r) {
                            if ($r == '' || $r == null) {
                                $skip = true;
                            }
                        }
                        if (!$skip) {
                            if (count($header) != count($row)) {
                                return response()->json([
                                    'message' => 'File CSV yang diupload tidak sesuai format!'
                                ], 500);
                            } else {
                                $data[] = array_combine($header, $row);
                            }
                        }
                    }
                }
                fclose($handle);
            }

            DB::connection(Session::get('connection'))->table('tbtr_usulanpkm')
            ->where('upkm_nousulan',$noUsulan)
            ->delete();

            foreach($data as $d){
                $plu = DB::connection(Session::get('connection'))
                    ->table('tbmaster_kkpkm')
                    ->join('tbmaster_prodmast',function($join){
                        $join->on('prd_kodeigr','=','pkm_kodeigr');
                        $join->on('prd_prdcd','=','pkm_prdcd');
                    })
                    ->leftJoin('tbtr_pkmsales','psl_prdcd','=','prd_prdcd')
                    ->where('pkm_prdcd','=',$d['PRDCD'])
                    ->first();

                if($plu->pkm_adjust_by != null)
                    $adjust = $plu->pkm_pkm;
                else $adjust = null;

                DB::connection(Session::get('connection'))
                    ->table('tbtr_usulanpkm')
                    ->insert([
                        'upkm_kodeigr' => Session::get('kdigr'),
                        'upkm_recordid' => null,
                        'upkm_nousulan' => $noUsulan,
                        'upkm_tglusulan' => Carbon::createFromFormat('d/m/Y',$tglUsulan),
                        'upkm_prdcd' => $d['PRDCD'],
                        'upkm_mpkm_awal' => $plu->pkm_mpkm,
                        'upkm_pkmadjust_awal' => $adjust,
                        'upkm_mplus_awal' => $plu->pkm_qtymplus,
                        'upkm_pkmt_awal' => $plu->pkm_pkmt,
                        'upkm_pkm_usulan' => $d['PKM_USULAN'],
                        'upkm_mplus_usulan' => $d['MPLUS_USULAN'],
                        'upkm_pkm_edit' => null,
                        'upkm_mplus_edit' => null,
                        'upkm_status' => 0,
                        'upkm_approval' => null,
                        'upkm_keterangan' => null,
                        'upkm_tglproses' => null,
                        'upkm_create_by' => Session::get('usid'),
                        'upkm_create_dt' => Carbon::now(),
                        'upkm_modify_by' => null,
                        'upkm_modify_dt' => null
                    ]);
            }

            return response()->json([
                'message' => 'Berhasil menyimpan data usulan!'
            ], 200);
        }
        catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal menyimpan data usulan!',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function cancelUsulan(Request $request){
        $noUsulan = $request->nousulan;

        $temp = DB::connection(Session::get('connection'))
            ->table('tbtr_usulanpkm')
            ->select('upkm_status')
            ->where('upkm_nousulan','=',$noUsulan)
            ->first();

        if($temp){
            if($temp->stat == '0'){
                return response()->json([
                    'message' => 'No usulan '.$noUsulan.' belum dikirim!'
                ], 500);
            }
            else if($temp->stat == 'A'){
                return response()->json([
                    'message' => 'No usulan '.$noUsulan.' sudah disetujui!'
                ], 500);
            }
            else if($temp->stat == 'K'){
                DB::connection(Session::get('connection'))
                    ->table('tbtr_usulanpkm')
                    ->where('upkm_nousulan','=',$noUsulan)
                    ->update([
                        'upkm_recordid' => '1',
                        'upkm_modify_by' => Session::get('usid'),
                        'upkm_modify_dt' => Carbon::now()
                    ]);

                return response()->json([
                    'message' => 'No usulan '.$noUsulan.' berhasil dibatalkan!'
                ], 200);
            }
        }
    }

    public function checkPrintUsulan(Request $request){
        $temp = DB::connection(Session::get('connection'))
            ->table('tbtr_usulanpkm')
            ->where('upkm_nousulan','=',$request->nousulan)
            ->where('upkm_status','=','A')
            ->first();

        if($temp){
            return response()->json([
                'message' => 'OK'
            ], 200);
        }
        else{
            return response()->json([
                'message' => 'No usulan belum disetujui!'
            ], 500);
        }
    }

    public function printUsulan(Request $request){
        $perusahaan = DB::connection(Session::get('connection'))
            ->table('tbmaster_perusahaan')
            ->first();

        $data = DB::connection(Session::get('connection'))
            ->select("SELECT DISTINCT
                upkm_nousulan,
                upkm_tglproses,
                upkm_prdcd,
                prd_deskripsipendek,
                prd_frac,
                prd_kodetag,
                pkm_minorder,
                pkm_mindisplay,
                pkm_periode1,
                pkm_qty1,
                pkm_periode2,
                pkm_qty2,
                pkm_periode3,
                pkm_qty3,
                pkm_leadtime,
                slv_servicelevel_qty,
                pkm_koefisien,
                upkm_mpkm_awal,
                upkm_pkmadjust_awal,
                upkm_mplus_awal,
                upkm_pkmt_awal,
                pkm_mpkm,
                pkm_qtymplus,
                pkm_pkmt
              FROM tbtr_usulanpkm,
                   tbmaster_prodmast,
                   tbmaster_kkpkm,
                   (SELECT slv_prdcd, slv_servicelevel_qty
                      FROM TBTR_SERVICELEVEL
                     WHERE slv_periode =
                              (SELECT MAX (slv_periode) FROM TBTR_SERVICELEVEL))
             WHERE upkm_nousulan = '".$request->nousulan."'
                   AND upkm_prdcd = prd_prdcd
                   AND upkm_prdcd = pkm_prdcd
                   AND upkm_prdcd = slv_prdcd(+)");

//        dd($data);

        if(count($data) > 0){
            $periode1 = $data[0]->pkm_periode1;
            $periode2 = $data[0]->pkm_periode2;
            $periode3 = $data[0]->pkm_periode3;
        }
        else{
            $periode1 = '-';
            $periode2 = '-';
            $periode3 = '-';
        }

        return view('BACKOFFICE.PKM.edit-pkm-pdf',compact(['perusahaan','data','periode1','periode2','periode3']));
    }

    public function uploadFileApproval(Request $request){
        $filename = $request->file('fileApproval');

        $header = NULL;
        $data = array();
        try {
            if (($handle = fopen($filename, 'r')) !== FALSE) {
                while (($row = fgetcsv($handle, 1000, '|', '#', '/')) !== FALSE) {
                    $skip = false;
                    if (!$header){
                        $header = $row;
                        if($header != ['NO_USULAN','TGL_USULAN','PRDCD','PKM_EDIT','MPLUS_EDIT','KODEIGR']){
                            return response()->json([
                                'message' => 'File CSV yang diupload tidak sesuai format!'
                            ], 500);
                        }
                    }
                    else {
                        foreach ($row as $r) {
                            if ($r == '' || $r == null) {
                                $skip = true;
                            }
                        }
                        if (!$skip) {
                            if (count($header) != count($row)) {
                                return response()->json([
                                    'message' => 'File CSV yang diupload tidak sesuai format!'
                                ], 500);
                            } else {
                                $data[] = array_combine($header, $row);
                            }
                        }
                    }
                }
                fclose($handle);
            }

            DB::connection(Session::get('connection'))
                ->beginTransaction();

            DB::connection(Session::get('connection'))
                ->table('tbtemp_editpkm_migrasi')
                ->delete();

            foreach($data as $d){
                DB::connection(Session::get('connection'))
                    ->table('tbtemp_editpkm_migrasi')
                    ->insert([
                        'no_usulan' => $d['NO_USULAN'],
                        'tgl_usulan' => $d['TGL_USULAN'],
                        'prdcd' => $d['PRDCD'],
                        'pkm_edit' => $d['PKM_EDIT'],
                        'mplus_edit' => $d['MPLUS_EDIT'],
                        'kodeigr' => $d['KODEIGR']
                    ]);
            }

            $temp = DB::connection(Session::get('connection'))
                        ->selectOne("SELECT COUNT (1) count
                            FROM tbtr_usulanpkm
                           WHERE     upkm_status = 'A'
                                 AND upkm_approval = SUBSTR ('".$filename->getClientOriginalName()."', 1, 10)
                                 AND EXISTS
                            (SELECT 1
                               FROM TBTEMP_EDITPKM_MIGRASI
                              WHERE NO_USULAN = upkm_nousulan)");

            if($temp->count > 0){
                return response()->json([
                    'message' => 'File sudah pernah diproses!'
                ], 500);
            }

            $temp = DB::connection(Session::get('connection'))
                ->table('tbtr_usulanpkm')
                ->where('upkm_status','=','K')
                ->where('upkm_approval','=',substr($filename->getClientOriginalName(),0,10))
                ->first();

            if(!$temp){
                return response()->json([
                    'message' => 'File tidak sesuai!'
                ], 500);
            }

            $c = loginController::getConnectionProcedure();
            $sql = "BEGIN sp_transfer_usulanpkm_migrasi('" . Session::get('kdigr') . "','".Session::get('usid')."',:nousulan,:err_txt); END;";
            $s = oci_parse($c, $sql);
            oci_bind_by_name($s, ':err_txt', $err_txt, 200);
            oci_bind_by_name($s, ':nousulan', $nousulan, 200);
            oci_execute($s);

            DB::connection(Session::get('connection'))
                ->commit();

            return response()->json([
                'message' => 'Berhasil menyimpan data approval!',
                'nousulan' => $nousulan,
                'tglusulan' => $data[0]['TGL_USULAN']
            ], 200);
        }
        catch (\Exception $e) {
            DB::connection(Session::get('connection'))
                ->rollBack();

            return response()->json([
                'message' => 'Gagal menyimpan data approval!',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getDataApproval(){
        $data = DB::connection(Session::get('connection'))
            ->select("select no_usulan, tgl_usulan, prdcd, upkm_mpkm_awal,
                        upkm_pkmadjust_awal, upkm_mplus_awal, upkm_pkmt_awal, upkm_pkm_edit, upkm_mplus_edit,
                        upkm_keterangan, pkm_mpkm, pkm_qtymplus, pkm_pkmt, prd_deskripsipanjang
                        from TBTEMP_EDITPKM_MIGRASI, tbtr_usulanpkm, tbmaster_prodmast, tbmaster_kkpkm
                        where no_usulan=upkm_nousulan and prdcd=upkm_prdcd
                        and prdcd=prd_prdcd and prdcd=pkm_prdcd");

        return DataTables::of($data)->make(true);
    }

    public function getDataLovPKMBaru(){
        $data = DB::connection(Session::get('connection'))
            ->table('tbtr_usulanpkmbaru')
            ->selectRaw("pkmn_nousulan no, pkmn_tglusulan, to_char(pkmn_tglusulan, 'dd/mm/yyyy') tgl")
            ->orderBy('pkmn_tglusulan','desc')
            ->distinct()
            ->get();

        return DataTables::of($data)->make(true);
    }

    public function getDataPKMBaru(Request $request){
        $data = DB::connection(Session::get('connection'))
            ->table('tbtr_usulanpkmbaru')
            ->join('tbmaster_prodmast','prd_prdcd','=','pkmn_prdcd')
            ->where('pkmn_nousulan','=',$request->nousulan)
            ->get();

        return DataTables::of($data)->make(true);
    }

    public function uploadFilePKMBaru(Request $request){
        $filename = $request->file('filePKMBaru');

        $header = NULL;
        $data = array();
       
        try {
            if (($handle = fopen($filename, 'r')) !== FALSE) {
                while (($row = fgetcsv($handle, 1000, '|', '#', '/')) !== FALSE) {
                    $skip = false;
                    if (!$header){
                        $header = $row;
                        if($header != ['KODEIGR', 'NOUSULAN', 'TGLUSULAN', 'PRDCD', 'MPKM', 'PKM', 'MPLUS_I', 'MPLUS_O', 'PKMT', 'CREATE_BY', 'CREATE_DT']){
                            return response()->json([
                                'message' => 'File xCSV yang diupload tidak sesuai format!'
                            ], 500);
                        }
                    }
                    else {
                        foreach ($row as $r) {
                            if ($r == '' || $r == null) {
                                $skip = true;
                            }
                        }
                        if (!$skip) {
                            if (count($header) != count($row)) {
                                return response()->json([
                                    'message' => 'File CSV yang diupload tidak sesuai format!'
                                ], 500);
                            } else {
                                $data[] = array_combine($header, $row);
                            }
                        }
                    }
                }
                fclose($handle);
            }

            $temp = DB::connection(Session::get('connection'))
                ->table('tbtr_usulanpkmbaru')
                ->where('pkmn_nousulan','=',substr($filename->getClientOriginalName(),0,11))
                ->first();

//            if($temp){
//                return response()->json([
//                    'message' => 'File sudah pernah diproses!'
//                ], 500);
//            }

            if(substr($filename->getClientOriginalName(),0,6) != 'PKMN'.Session::get('kdigr')){
                return response()->json([
                    'message' => 'File tidak sesuai dengan cabang!'
                ], 500);
            }

            DB::connection(Session::get('connection'))
                ->beginTransaction();

            DB::connection(Session::get('connection'))
                ->table('tbtemp_pkmbaru_migrasi')
                ->delete();

            foreach($data as $d){
                $test_insert = DB::connection(Session::get('connection'))
                    ->table('tbtemp_pkmbaru_migrasi')
                    ->insert([
                        'kodeigr' => $d['KODEIGR'],
                        'nousulan' => $d['NOUSULAN'],
                        'tglusulan' => DB::raw("TO_DATE('" . $d['TGLUSULAN'] . "','dd/mm/yyyy')"),
                        'prdcd' => $d['PRDCD'],
                        'mpkm' => $d['MPKM'],
                        'pkm' => $d['PKM'],
                        'mplus_i' => $d['MPLUS_I'],
                        'mplus_o' => $d['MPLUS_O'],
                        'pkmt' => $d['PKMT'],
                        'create_by' => $d['CREATE_BY'],
                        'create_dt' => DB::raw("TO_DATE('" . $d['CREATE_DT'] . "','dd/mm/yyyy')")
                    ]);
            }


            $c = loginController::getConnectionProcedure();
            $sql = "BEGIN sp_transfer_usulanpkm('" . Session::get('kdigr') . "','".Session::get('usid')."',:nousulan,:err_txt); END;";
            $s = oci_parse($c, $sql);
            oci_bind_by_name($s, ':err_txt', $err_txt, 200);
            oci_bind_by_name($s, ':nousulan', $nousulan, 200);
            oci_execute($s);

            DB::connection(Session::get('connection'))
                ->commit();

            return response()->json([
                'message' => 'Berhasil menyimpan data approval!',
                'nousulan' => $nousulan,
                'tglusulan' => $data[0]['TGLUSULAN']
            ], 200);
        }
        catch (\Exception $e) {
            DB::connection(Session::get('connection'))
                ->rollBack();

            return response()->json([
                'message' => 'Gagal menyimpan data approval!',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
