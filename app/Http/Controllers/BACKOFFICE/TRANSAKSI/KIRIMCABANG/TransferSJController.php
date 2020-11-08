<?php

namespace App\Http\Controllers\BACKOFFICE\TRANSAKSI\KIRIMCABANG;

use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;
use PDF;
use Yajra\DataTables\DataTables;

class TransferSJController extends Controller
{
    public function index(){
        return view('BACKOFFICE.TRANSAKSI.KIRIMCABANG.transfer-sj');
    }

    public function getData(Request $request){
        $data = DB::select("select distinct msth_loc2, cab_namacabang, msth_nodoc no
                    from tbtr_mstran_h, tbtr_mstran_d, tbmaster_cabang
                    where nvl(msth_recordid,0) <> '1'                    
                    and msth_kodeigr = '".$_SESSION['kdigr']."'
                    and msth_typetrn = 'O'
                    and mstd_kodeigr = msth_kodeigr
                    and mstd_nodoc = msth_nodoc
                    and trunc(mstd_tgldoc) =TO_DATE('".$request->tgl."','DD/MM/YYYY')
                    and cab_kodecabang = msth_loc
                    and cab_kodeigr = msth_kodeigr
                    and nvl(msth_flagdoc,' ') <> '*'
                    order by msth_loc2");

        return $data;
    }

    public function transfer(Request $request){
        $nodoc = '(';
        foreach($request->nodoc as $n){
            $nodoc .= "'".$n."',";
        }
        $nodoc = substr($nodoc,0,-1).')';

        DB::statement("truncate table temp_sj");


        try{
            DB::beginTransaction();

            $data = DB::insert("insert into temp_sj select mstd_recordid recid , mstd_typetrn rtype, mstd_nodoc docno,
                              mstd_tgldoc DATEO, mstd_noref3 noref1, mstd_tgref3 tgref1,mstd_docno2 noref2,
                              mstd_date2 tgref2,
						       mstd_docno2 docno2, mstd_date2  date2, mstd_istype istype,  mstd_invno invno,  
						       mstd_date3 date3, mstd_nott nott,  mstd_tgltt date4, mstd_kodesupplier supco,   
						       mstd_pkp pkp, mstd_cterm cterm,  mstd_seqno seqno, mstd_prdcd prdcd,
						       substr(prd_deskripsipanjang,1,45) desc2, mstd_kodedivisi div, mstd_kodedepartement dept, mstd_kodekategoribrg katb,
						       mstd_bkp bkp, mstd_fobkp fobkp, mstd_unit unit, mstd_frac frac, 
						       msth_loc loc, msth_loc2 loc2, 						       
						       floor(to_number((mstd_qty/case when mstd_unit='KG' then 1000 else mstd_frac end))) qty_ctn, 						       
						       case when mstd_unit='KG' then 0 else nvl(mod(nvl(mstd_qty,0),nvl(mstd_frac,0)),0) end qty_pcs,  						       
						       nvl(mstd_qtybonus1,0) qbns1, nvl(mstd_qtybonus2,0) qbns2, mstd_hrgsatuan price,  nvl(mstd_persendisc1,0) discp1, 
						       nvl(mstd_rphdisc1,0) discr1, null, nvl(mstd_persendisc2,0) discp2, nvl(mstd_rphdisc2,0)	discr2, 
						       null, nvl(mstd_gross,0) gross, nvl(mstd_discrph,0) discrp, nvl(mstd_ppnrph,0) ppnrp,	
						       nvl(mstd_ppnbmrph,0) bmrp, nvl(mstd_ppnbtlrph,0) btlrp, nvl(mstd_avgcost,0) acost,	mstd_keterangan keter, 
						       'T' doc, 'F' doc2, 'F' fk, NULL	,
						        mstd_kodetag mtag, mstd_gdg	gdg, trunc(sysdate) tglupd, to_char(sysdate,'hh24:mi:ss') jamupd,'".$_SESSION['usid']."'	USERO
						from tbtr_mstran_h, tbtr_mstran_d, tbmaster_prodmast
						where msth_nodoc in ".$nodoc."
								and msth_kodeigr='".$_SESSION['kdigr']."'
								and mstd_nodoc=msth_nodoc
								and mstd_kodeigr=msth_kodeigr
								and prd_prdcd=mstd_prdcd
								and prd_kodeigr=mstd_kodeigr");

            DB::commit();

            return 'success';
        }
        catch (QueryException $e){
            DB::rollBack();
            return 'error';
        }
    }

    public function download(){
        $data = DB::select("select * from temp_sj");

        $column = DB::select("select column_name FROM USER_TAB_COLUMNS WHERE table_name = 'TEMP_SJ' 
                                    ORDER BY column_id");

        $columnHeader = [];
        foreach($column as $c){
            $columnHeader[] = $c->column_name;
        }

        $rows = collect($data)->map(function ($x) {
            return (array)$x;
        })->toArray();

        $tgl = date_format(Carbon::now(),'d-m-Y His');

        $filename = 'TRANSFER SURAT JALAN '.$tgl.'.csv';

        $headers = [
            "Content-type" => "text/csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];
        $file = fopen($filename, 'w');
        fputcsv($file, $columnHeader, '|');
        foreach ($rows as $row) {
            fputcsv($file, $row, '|');
        }
        fclose($file);
        return response()->download($filename, $filename, $headers)->deleteFileAfterSend(true);
    }
}