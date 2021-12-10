<?php

namespace App\Http\Controllers\BACKOFFICE\TRANSFER;

use App\Http\Controllers\Auth\loginController;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller; use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;
use PDF;
use Yajra\DataTables\DataTables;
use ZipArchive;
use File;

class TransferPOController extends Controller
{
    public function index(){
        return view('BACKOFFICE.TRANSFER.transfer-po');
    }

    public function getData(Request $request){
        $kodeanak = DB::connection(Session::get('connection'))->table('tbmaster_cabang')
            ->select('cab_kodecabang_anak')
            ->where('cab_kodecabang','=',Session::get('kdigr'))
            ->first()->cab_kodecabang_anak;

        $data = DB::connection(Session::get('connection'))->select("SELECT fhkcab, fhnopo,TO_CHAR(fhtgpo,'DD/MM/YYYY') fhtgpo,nvl(tpoh_nopo,'BELUM DIPROSES') tpoh_nopo
			       FROM mcgdata.mh_poord@mcgprod, (select tpoh_recordid, case when tpoh_flagcmo='Y' then tpoh_cab_anak else tpoh_kodeigr end tpoh_kodeigr, tpoh_nopo from tbtr_po_h)
						 WHERE fhkcab=tpoh_kodeigr(+) and fhnopo=tpoh_nopo(+) and nvl(tpoh_recordid,' ')<>'2'
						 and fhksbu='4'
			       and ( fhkcab = '".Session::get('kdigr')."' or fhkcab = '".$kodeanak."' )
			       AND (   TRUNC (fhtgup) BETWEEN TRUNC ( TO_DATE('".$request->tgl1."','DD/MM/YYYY')) AND TRUNC (TO_DATE('".$request->tgl2."','DD/MM/YYYY'))
              OR TRUNC (fhtgpo) BETWEEN TRUNC (TO_DATE('".$request->tgl1."','DD/MM/YYYY')) AND TRUNC (TO_DATE('".$request->tgl2."','DD/MM/YYYY')))
			       and nvl(fhrcid,'zzz')<>'1'
			       ORDER BY fhnopo");

        return $data;
    }

    public function prosesTransfer(Request $request){
        $nodoc = $request->nodoc;
        $vnew = $request->vnew;

        for($i=0;$i<count($nodoc);$i++){
            $f_cegattrf = DB::connection(Session::get('connection'))->table('igr_log_aj')
                ->where('nama_procedure','=','SP_TRANSFER_PO')
                ->where('attribute1','=',$nodoc[$i])
                ->first();

            if($f_cegattrf){
                return [
                    'status' => 'error',
                    'title' => $nodoc[$i].' sedang ditransfer di tempat lain!'
                ];
            }
            else{
                DB::connection(Session::get('connection'))->table('tb_log_aj')
                    ->insert([
                        'nm_procedure' => $nodoc[$i],
                        'tgl_create' => DB::RAW("TRUNC(SYSDATE)")
                    ]);

                $kodewil = DB::connection(Session::get('connection'))->table('tbmaster_perusahaan')
                    ->select('prs_kodewilayah')
                    ->first()->prs_kodewilayah;

                $connection = loginController::getConnectionProcedure();
                $exec = oci_parse($connection, "BEGIN  sp_transfer_po_migrasi('4',
                                    :p_wil,:kdcab,:nodoc,:v_new,'".Session::get('usid')."',
                                    :v_errm); END;");
                oci_bind_by_name($exec, ':p_wil',$kodewil,100);
                oci_bind_by_name($exec, ':kdcab',Session::get('kdigr'),100);
                oci_bind_by_name($exec, ':nodoc',$nodoc[$i],100);
                oci_bind_by_name($exec, ':v_new',$vnew[$i],100);
                oci_bind_by_name($exec, ':v_errm',$v_errm,100);
                oci_execute($exec);

                DB::connection(Session::get('connection'))->table('tb_log_aj')
                    ->where('nm_procedure','=',$nodoc[$i])
                    ->where('tgl_create','=',DB::RAW("TRUNC(SYSDATE)"))
                    ->delete();

                $newpo = $nodoc[$i];
            }
        }

        return [
            'status' => 'success',
            'title' => 'Proses Transfer PO Selesai!'
        ];
    }
}
