<?php

namespace App\Http\Controllers\BACKOFFICE\TRANSAKSI\KIRIMCABANG;

use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller; use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;
use PDF;
use Yajra\DataTables\DataTables;

class BatalController extends Controller
{
    public function index(){
        return view('BACKOFFICE.TRANSAKSI.KIRIMCABANG.batal');
    }

    public function getData(Request $request){
        $tgl1 = $request->tgl1;
        $tgl2 = $request->tgl2;

        $data = DB::connection(Session::get('connection'))->table('tbtr_mstran_h')
            ->selectRaw("msth_nodoc no, msth_tgldoc tgl")
            ->where('msth_typetrn','=','O')
            ->whereRaw("nvl(msth_recordid,' ') <> '1'")
            ->whereRaw("msth_tgldoc between TO_DATE('".$tgl1."','dd/mm/yyyy') and TO_DATE('".$tgl2."','dd/mm/yyyy')")
            ->get();

        return $data;
    }

    public function execute(Request $request){
        try{
            $nodoc = $request->nodoc;

            DB::connection(Session::get('connection'))->beginTransaction();

            foreach($nodoc as $no){
                $sjs = DB::connection(Session::get('connection'))->select("SELECT mstd_kodeigr, mstd_typetrn, mstd_nodoc, mstd_tgldoc,
  							          mstd_qty, mstd_avgcost,	mstd_prdcd, mstd_hrgsatuan,
  							          nvl(mstd_noref3,'xxx') mstd_noref3, mstd_tgref3,
  							          st_lastcost,st_avgcost,prd_unit, prd_frac, prd_avgcost,st_saldoakhir
  							   FROM tbtr_mstran_d, tbmaster_prodmast, tbmaster_stock
  							   WHERE mstd_nodoc='".$no."'
  							         and mstd_kodeigr='".Session::get('kdigr')."'
  							         and prd_prdcd = mstd_prdcd
  							         and prd_kodeigr = mstd_kodeigr
  							         and st_prdcd(+)=mstd_prdcd
  							         and st_kodeigr(+)=mstd_kodeigr
  							         and st_lokasi(+)='01'");

                foreach($sjs as $sj){
                    $vnoipb = $sj->mstd_noref3;
                    $nqtt = $sj->mstd_qty;

                    if($sj->prd_unit == 'KG')
                        $sj->prd_frac = 1;

                    $ncost = $sj->mstd_hrgsatuan / $sj->prd_frac;

                    if(Self::nvl($sj->st_saldoakhir,0) + $nqtt == 0){
                        $vacostbaru = (((Self::nvl($sj->st_saldoakhir,0)*Self::nvl($sj->st_avgcost,0))+(Self::nvl($ncost,0)*Self::nvl($nqtt,0)))/ 1 );
                    }
                    else $vacostbaru = (((Self::nvl($sj->st_saldoakhir,0)*Self::nvl($sj->st_avgcost,0))+(Self::nvl($ncost,0)*Self::nvl($nqtt,0)))/ ((Self::nvl($sj->st_saldoakhir,0)+$nqtt)));

                    DB::connection(Session::get('connection'))->update("	UPDATE tbmaster_prodmast
  							     set prd_avgcost=".$vacostbaru." * case when prd_unit='KG' then 1 else
  							                                case when prd_frac <= 0 then 1 else nvl(prd_frac,1) end end
  						WHERE substr(prd_prdcd,1,6)= substr('".$sj->mstd_prdcd."',1,6)
  							    and prd_kodeigr='".Session::get('kdigr')."'");

                    DB::connection(Session::get('connection'))->insert("INSERT INTO tbhistory_cost (HCS_KODEIGR,HCS_TYPETRN,HCS_LOKASI,HCS_PRDCD,HCS_TGLBPB,HCS_NODOCBPB,HCS_QTYBARU,HCS_QTYLAMA,HCS_AVGLAMA,HCS_AVGBARU, HCS_LASTQTY,
				HCS_CREATE_BY,HCS_CREATE_DT)
                VALUES ('".Session::get('kdigr')."', 'O', '01', '".$sj->mstd_prdcd."', '".$sj->mstd_tgldoc."','".$sj->mstd_nodoc."','".$sj->mstd_qty."', '".$sj->st_saldoakhir."', ".$sj->mstd_prdcd * $sj->prd_frac.", ".$vacostbaru * $sj->prd_frac.", ". $sj->st_saldoakhir."+".$sj->mstd_qty.",'".Session::get('usid')."', sysdate)");

//                $qty = (integer) -1 * $sj->mstd_qty;
//
//                $kode1   = '01';
//                $kode2   = 'TRFOUT';
//                $sup = '';
//                $v_lok   = '';
//                $v_msg   = '';
//                $lcost = (float) $sj->st_lastcost;
//                $acost = (float) $vacostbaru;
//
//                $connect = loginController::getConnectionProcedure();
//                $exec = oci_parse($connect, "BEGIN  sp_igr_update_stock(:kodeigr,:kode1,:prdcd,:sup,:kode2,:qty,:st_lastcost,:st_avgcost,:user,:v_lok,:v_message); END;"); //Procedure asli diganti ke varchar
//                oci_bind_by_name($exec, ':kodeigr',$kodeigr);
//                oci_bind_by_name($exec, ':kode1',$kode1);
//                oci_bind_by_name($exec, ':prdcd',$sj->mstd_prdcd);
//                oci_bind_by_name($exec, ':sup',$sup);
//                oci_bind_by_name($exec, ':kode2',$kode2);
//                oci_bind_by_name($exec, ':qty',$qty);
//                oci_bind_by_name($exec, ':st_lastcost',$lcost);
//                oci_bind_by_name($exec, ':st_avgcost',$acost);
//                oci_bind_by_name($exec, ':user',Session::get('usid'));
//                oci_bind_by_name($exec, ':v_lok', $v_lok,-1,'OCI_B_BOL');
//                oci_bind_by_name($exec, ':v_message', $v_msg,10000);
//                oci_execute($exec);
                }

                DB::connection(Session::get('connection'))->raw("INSERT INTO tbtr_hapusplu (DEL_KODEIGR,DEL_RTYPE,DEL_NODOKUMEN,DEL_TGLDOKUMEN,
  								DEL_STOKQTYOLD,DEL_AVGCOSTOLD, DEL_CREATE_BY,DEL_CREATE_DT,DEL_PRDCD)
 					    SELECT mstd_kodeigr, mstd_typetrn, mstd_nodoc, mstd_tgldoc,
  							   mstd_qty, mstd_avgcost,	'".Session::get('usid')."', sysdate,mstd_prdcd
                     FROM tbTr_MSTRAN_D, tbMaster_Stock
                     WHERE mstd_nodoc='".$no."'
                           and mstd_kodeigr='".Session::get('kdigr')."'
                           and st_prdcd=mstd_prdcd
                           and st_kodeigr=mstd_kodeigr
                           and st_lokasi='01'");

                DB::connection(Session::get('connection'))->table('tbtr_mstran_h')
                    ->where('msth_nodoc','=',$no)
                    ->where('msth_kodeigr','=',Session::get('kdigr'))
                    ->update([
                        'msth_recordid' => '1'
                    ]);

                DB::connection(Session::get('connection'))->table('tbtr_mstran_d')
                    ->where('mstd_nodoc','=',$no)
                    ->where('mstd_kodeigr','=',Session::get('kdigr'))
                    ->update([
                        'mstd_recordid' => '1'
                    ]);

                if($vnoipb != 'xxx'){
                    DB::connection(Session::get('connection'))->table('tbtr_ipb')
                        ->where('ipb_noipb','=',$vnoipb)
                        ->updae([
                            'ipb_recordid' => ''
                        ]);
                }
            }

            DB::connection(Session::get('connection'))->commit();

            $title = 'Surat Jalan berhasil dibatalkan!';
            $status = 'success';
            $message = '';
        }
        catch(QueryException $e){
            DB::connection(Session::get('connection'))->rollBack();

            $title = 'Surat Jalan gagal dibatalkan!';
            $message = $e->getMessage();
            $status = 'error';
        }

        return compact(['title','message','status']);
    }

    public function nvl($value, $defaultvalue){
        if($value == null || $value == '')
            return $defaultvalue;
        else return $value;
    }
}
