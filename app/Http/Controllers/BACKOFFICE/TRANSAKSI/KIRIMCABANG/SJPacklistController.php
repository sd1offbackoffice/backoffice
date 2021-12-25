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

class SJPacklistController extends Controller
{
    public function index(){
        return view('BACKOFFICE.TRANSAKSI.KIRIMCABANG.sj-packlist');
    }

    public function execute(){
        $nomorpc = 0;
        $sesikom = DB::connection(Session::get('connection'))->select("Select SUBSTR(TO_CHAR (USERENV ('SESSIONID')),0,10) sesikom from dual")[0]->sesikom;

//        dd($sesikom);
        $seq = 0;

        Self::buat_jalan($sesikom);

        if($nomorpc == 0){
            $title = 'Data Tidak Ada Yang Bisa Diproses Surat Jalan!';
            $status = 'error';

            return compact(['title','status']);
        }

        $v_nodoc = '';
        $trbodoc = '';

        $recs = DB::connection(Session::get('connection'))->select("SELECT * FROM TBTR_BACKOFFICE, TBTR_LISTPACKING  WHERE TRBO_TYPETRN = 'O' AND NVL(TRBO_NOFAKTUR,'ZZZZ') = '".$sesikom."' AND TRBO_KODEIGR = '".Session::get('kdigr')."' AND NVL(TRBO_RECORDID,' ') <> '1' AND NVL(TRBO_FLAGDOC,' ') <> '*' AND PCL_KODEIGR = TRBO_KODEIGR AND PCL_NODOKUMEN = TRBO_NOREFF AND PCL_NOREFERENSI1 = TRBO_NODOC AND NVL(PCL_NODOKUMEN,' ') <> ' ' AND PCL_NOREFERENSI = TRBO_NOPO AND PCL_PRDCD = TRBO_PRDCD ORDER BY TRBO_NODOC");

        foreach($recs as $rec){
            $temp = DB::connection(Session::get('connection'))->select("SELECT NVL(COUNT(1),0) FROM TBMASTER_PRODMAST
                              WHERE PRD_PRDCD = '".$rec->trbo_prdcd."' AND PRD_KODEIGR = '".Session::get('kdigr')."'");

            if(count($temp) != 0){
                if(Self::nvl($rec->trbo_flagdc,' ') != '*'){
                    if(Self::nvl($rec->trbo_nonota, ' ') == ' '){
                        if(Self::nvl($trbodoc,' ') != Self::nvl($rec->trbo_nodoc, ' ')){
                            $trbodoc = Self::nvl($rec->trbo_nodoc,' ');

                            $c = loginController::getConnectionProcedure();
                            $s = oci_parse($c, "BEGIN :ret := F_IGR_GET_NOMOR('".Session::get('kdigr')."','SJK','Nomor Surat Jalan','SJK' || ".Session::get('kdigr')." || TO_CHAR(SYSDATE, 'yy'),3,TRUE); END;");
                            oci_bind_by_name($s, ':ret', $v_nodoc, 32);
                            oci_execute($s);
                        }
                    }

                    $qtystk = 0;

                    $prdcur = DB::connection(Session::get('connection'))->table('tbmaster_prodmast')
                        ->selectRaw("PRD_KODEDIVISI, PRD_KODEDEPARTEMENT, PRD_KODEKATEGORIBARANG, PRD_UNIT, PRD_FRAC, PRD_FLAGBKP1, PRD_FLAGBKP2")
                        ->where('prd_kodeigr','=',Session::get('kdigr'))
                        ->where('prd_prdcd','=',$rec->trbo_prdcd)
                        ->first();

                    if($prdcur){
                        $kdivp = $prdcur->prd_kodedivisi;
                        $kdepp = $prdcur->prd_kodedepartment;
                        $kkatp = $prdcur->prd_kodekategoribarang;
                        $unitp = $prdcur->prd_unit;
                        $fracp = $prdcur->prd_frac;
                        $pkp1p = $prdcur->prd_flagbkp1;
                        $pkp2p = $prdcur->prd_flagbkp2;
                    }
                    else{
                        $kdivp = '';
                        $kdepp = '';
                        $kkatp = '';
                        $unitp = '';
                        $fracp = '';
                        $pkp1p = '';
                        $pkp2p = '';
                    }

                    $temp = DB::connection(Session::get('connection'))->select("SELECT NVL(COUNT(1),0) FROM TBMASTER_STOCK
				WHERE ST_KODEIGR = '".Session::get('kdigr')."' AND ST_PRDCD = SUBSTR('".$rec->trbo_prdcd."',1,6) || '0'
				AND ST_LOKASI = '01'");

                    if(count($temp) == 0){
                        $qtystk = 0;

                        if(Self::nvl($unitp,' ') == 'KG'){
                            DB::connection(Session::get('connection'))->table('tbmaster_stock')
                                ->insert([
                                    'st_kodeigr' => Session::get('kdigr'),
                                    'st_prdcd' => substr($rec->trbo_prdcd,0,6).'0',
                                    'st_lokasi' => '01',
                                    'st_saldoakhir' => ($rec->trbo_qty / 1000 * -1),
                                    'st_trfout' => ($rec->trbo_qty / 1000)
                                ]);
                        }
                        else{
                            DB::connection(Session::get('connection'))->table('tbmaster_stock')
                                ->insert([
                                    'st_kodeigr' => Session::get('kdigr'),
                                    'st_prdcd' => substr($rec->trbo_prdcd,0,6).'0',
                                    'st_lokasi' => '01',
                                    'st_saldoakhir' => ($rec->trbo_qty * -1),
                                    'st_trfout' => $rec->trbo_qty
                                ]);
                        }
                    }
                    else{
                        $qtystk = DB::connection(Session::get('connection'))->table('tbmaster_stock')
                            ->select('st_saldoakhir')
                            ->where('st_kodeigr','=',Session::get('kdigr'))
                            ->where('st_prdcd','=',substr($rec->trbo_prdcd,0,6).'0')
                            ->where('st_lokasi','=','01')
                            ->first()->st_saldoakhir;

                        if(Self::nvl($unitp,' ') == 'KG'){
                            DB::connection(Session::get('connection'))->update("UPDATE TBMASTER_STOCK
                            SET ST_SALDOAKHIR = (ST_SALDOAKHIR - (".$rec->trbo_qty." / 1000)),
                            ST_TRFOUT = (ST_TRFOUT + (".$rec->trbo_qty." / 1000))
                            WHERE ST_KODEIGR = '".Session::get('kdigr')."' AND ST_PRDCD = SUBSTR('".$rec->trbo_prdcd."',1,6) || '0'
                            AND ST_LOKASI = '01';");
                        }
                        else{
                            DB::connection(Session::get('connection'))->update("UPDATE TBMASTER_STOCK
                            SET ST_SALDOAKHIR = (ST_SALDOAKHIR - (".$rec->trbo_qty.")),
                            ST_TRFOUT = (ST_TRFOUT + (".$rec->trbo_qty."))
                            WHERE ST_KODEIGR = '".Session::get('kdigr')."' AND ST_PRDCD = SUBSTR('".$rec->trbo_prdcd."',1,6) || '0'
                            AND ST_LOKASI = '01';");
                        }
                    }

                    $supcur = DB::connection(Session::get('connection'))->select("SELECT SUP_PKP, SUP_TOP FROM TBMASTER_SUPPLIER
                            WHERE SUP_KODEIGR = '".Session::get('kdigr')."' AND SUP_KODESUPPLIER = '".$rec->trbo_kodesupplier."'");

                    $supcur = DB::connection(Session::get('connection'))->table('tbmaster_supplier')
                        ->select('sup_pkp','sup_top')
                        ->where('sup_kodeigr','=',Session::get('kdigr'))
                        ->where('sup_kodesupplier','=',$rec->trbo_kodesupplier)
                        ->first();

                    if($supcur){
                        $pkps = $supcur->sup_pkp;
                        $tops = $supcur->sup_top;
                    }
                    else{
                        $pkps = '';
                        $tops = 0;
                    }

                    $temp = DB::connection(Session::get('connection'))->table('tbtr_mstran_h')
                        ->where('msth_kodeigr','=',Session::get('kdigr'))
                        ->where('msth_typetrn','=','O')
                        ->where('msth_nodoc','=',$v_nodoc)
                        ->where('msth_nofaktur','=',$rec->trbo_noreff)
                        ->where('msth_kodesupplier','=',$rec->trbo_kodesupplier)
                        ->count();

                    if($temp == 0){
                        DB::connection(Session::get('connection'))->table('tbtr_mstran_h')
                            ->insert([
                                'msth_kodeigr' => Session::get('kdigr'),
                                'msth_typetrn' => 'O',
                                'msth_nodoc' => $v_nodoc,
                                'msth_tgldoc' => Carbon::now(),
                                'msth_nofaktur' => $rec->trbo_noreff,
                                'msth_tglfaktur' => $rec->trbo_tglreff,
                                'msth_nopo' => $sesikom,
                                'msth_kodesupplier' => $rec->trbo_kodesupplier,
                                'msth_pkp' => $pkps,
                                'msth_cterm' => $tops,
                                'msth_loc' => $rec->trbo_loc,
                                'msth_loc2' => '',
                                'msth_flagdoc' => '9',
                                'msth_create_by' => Session::get('usid'),
                                'msth_create_dt' => Carbon::now()
                            ]);
                    }

                    $temp = DB::connection(Session::get('connection'))->table('tbtr_mstran_d')
                        ->where('mstd_kodeigr','=',Session::get('kdigr'))
                        ->where('mstd_typetrn','=','O')
                        ->where('mstd_nodoc','=',$v_nodoc)
                        ->where('mstd_nofaktur','=',$rec->trbo_noreff)
                        ->where('mstd_prdcd','=',$rec->trbo_prdcd)
                        ->count();

                    if($temp == 0){
                        $seq++;

                        DB::connection(Session::get('connection'))->table('tbtr_mstran_d')
                            ->insert([
                                'mstd_kodeigr' => Session::get('kdigr'),
                                'mstd_nodoc' => $v_nodoc,
                                'mstd_prdcd' => $rec->trbo_prdcd,
                                'mstd_seqno' => $rec->trbo_seqno,
                                'mstd_kodedivisi' => $kdivp,
                                'mstd_kodedepartement' => $kdepp,
                                'mstd_bkp' => $pkp1p,
                                'mstd_fobkp' => $pkp2p,
                                'mstd_kodekategoribrg' => $kkatp,
                                'mstd_unit' => $unitp,
                                'mstd_frac' => $fracp,
                                'mstd_qty' => $rec->trbo_qty,
                                'mstd_hrgsatuan' => $rec->trbo_hrgsatuan,
                                'mstd_gross' => $rec->trbo_gross,
                                'mstd_ppnrph' => $rec->trbo_ppnrph,
                                'mstd_avgcost' => $rec->trbo_averagecost,
                                'mstd_keterangan' => $rec->trbo_keterangan,
                                'mstd_fk' => ' ',
                                'mstd_tglfp' => null,
                                'mstd_kodetag' => ' ',
                                'mstd_create_by' => Session::get('usid'),
                                'mstd_create_dt' => Carbon::now()
                            ]);
                    }

                    DB::connection(Session::get('connection'))->table('tbtr_backoffice')
                        ->where('trbo_kodeigr','=',Session::get('kdigr'))
                        ->where('trbo_typetrn','=','O')
                        ->where('trbo_nodoc','=',$rec->trbo_nodoc)
                        ->where('trbo_tgldoc','=',$rec->trbo_tgldoc)
                        ->where('trbo_prdcd','=',$rec->trbo_prdcd)
                        ->update([
                            'trbo_flagdoc' => '9',
                            'trbo_nonota' => $v_nodoc,
                            'trbo_tglnota' => Carbon::now(),
                            'trbo_stokqty' => $qtystk
                        ]);
                }
            }
        }

        Session::put('sesikom',$sesikom);

        return Self::view_data($sesikom);
    }

    public function buat_jalan($sesikom){
        $nomorpc = 0;
        $pcldoc = '';

        $recs = DB::connection(Session::get('connection'))->select("select pcl_kodecabang, pcl_nodokumen, pcl_tgldokumen, pcl_noreferensi, trbo_nodoc,
                          PCL_RECORDID, sum(item) item
							from (select pcl_kodecabang, pcl_nodokumen, pcl_tgldokumen, pcl_noreferensi, PCL_RECORDID,'1' item,nvl(trbo_noreff,'0x') trbo_nodoc
							        from tbtr_listpacking, tbtr_backoffice
							        where PCL_KODEIGR = '".Session::get('kdigr')."'
									        and nvl(pcl_recordid,'9')<='3'
									        and nvl(pcl_recordid,'9')<>1
									        and trbo_noreff(+)=pcl_nodokumen
									        and trbo_prdcd(+)=pcl_prdcd
									        and trbo_kodeigr(+)=pcl_kodeigr
									        and trbo_typetrn(+)='O'
									        and nvl(trbo_recordid,'9')<>1
							)
							group by pcl_kodecabang, pcl_nodokumen, pcl_tgldokumen, pcl_noreferensi, trbo_nodoc, PCL_RECORDID");

        foreach($recs as $rec){
            $hgb = DB::connection(Session::get('connection'))->select("select nvl(count(1),0)
                                  from tbtr_listpacking, tbmaster_hargabeli
                                  where pcl_kodecabang=rec.pcl_kodecabang
                                    and PCL_NODOKUMEN = rec.pcl_nodokumen
                                    and hgb_prdcd = pcl_prdcd
                                    and hgb_kodeigr= pcl_kodeigr
                                    and hgb_tipe='2'");

            if(count($hgb) > 0){
                $rechgbs = DB::connection(Session::get('connection'))->select("select distinct hgb_kodesupplier
								  		  		from tbtr_listpacking, tbmaster_hargabeli
								  		  		where pcl_kodecabang = '".$rec->PCL_KODECABANG."'
                                                and PCL_NODOKUMEN = '".$rec->PCL_NODOKUMEN."'
                                                and hgb_prdcd = pcl_prdcd
                                                and hgb_kodeigr= pcl_kodeigr
                                                and hgb_tipe='2'
                                                and hgb_kodesupplier = hgb_kodesupplier");

                foreach($rechgbs as $rechgb){
                    $seq = 0;

                    $ip = Session::get('ip');

                    $arrip = explode('.',$ip);

                    $c = loginController::getConnectionProcedure();
                    $s = oci_parse($c, "BEGIN :ret := F_IGR_GET_NOMORSTADOC('".Session::get('kdigr')."','SJK','Nomor Surat Jalan',".$arrip[3].",7,TRUE); END;");
                    oci_bind_by_name($s, ':ret', $nosj, 32);
                    oci_execute($s);

                    $rec2s = DB::connection(Session::get('connection'))->select("select PCL_NODOKUMEN, PCL_PRDCD, pcl_noreferensi, pcl_tgldokumen,
                            pcl_tglreferensi, nvl(pcl_qtyr_b,0) pcl_qtyr_b,nvl(pcl_qtyr_s,0) pcl_qtyr_s,
                            nvl(pcl_qtyr_bk,0) pcl_qtyr_bk,nvl(pcl_qtyr_sk,0) pcl_qtyr_sk,
                            pcl_kodekoli||'-'||pcl_qtykoli ket, pcl_doc, pcl_doc2, pcl_fk,
                            pcl_tglfakturpajak, pcl_mtag, pcl_create_dt,pcl_furgnt, pcl_create_by,
                            prd_kodedivisi, prd_kodedepartement, prd_kodekategoribarang, prd_unit, prd_frac,
                            st_avgcost
                            from tbtr_listpacking, tbmaster_prodmast, tbmaster_stock, tbmaster_hargabeli
                            where pcl_kodecabang = '".$rec->PCL_KODECABANG."'
                            and PCL_NODOKUMEN = '".$rec->PCL_NODOKUMEN."'
                            and prd_prdcd = pcl_prdcd	and prd_kodeigr=pcl_kodeigr
                            and st_prdcd(+)=prd_prdcd	and st_kodeigr(+)=prd_kodeigr and st_lokasi(+)='01'
                            and hgb_prdcd = pcl_prdcd	and hgb_kodeigr= pcl_kodeigr and hgb_tipe='2'	and hgb_kodesupplier = '".$rechgb->hgb_kodesupplier."'");

                    foreach($rec2s as $rec2){
                        if($pcldoc != $rec2->pcl_nodokumen){
                            $pcldoc = $rec2->pcl_nodokumen;
                            $nomorpc = $nomorpc."'".$pcldoc."',";
                        }

                        DB::connection(Session::get('connection'))->table('tbtr_listpacking')
                            ->where('pcl_kodecabang','=',$rec->pcl_kodecabang)
                            ->where('pcl_nodokumen','=',$rec2->pcl_nodokumen)
                            ->where('pcl_prdcd','=',$rec2->pcl_prdcd)
                            ->update([
                                'pcl_recordid' => '1',
                                'pcl_noreferensi1' => $nosj
                            ]);

                        $qtyb = floor((( ($rec2->pcl_qtyr_b + $rec2->pcl_qtyr_s) * $rec2->prd_frac) + ($rec2->pcl_qtyr_bk+$rec2->pcl_qtyr_sk)) / $rec2->prd_frac );

                        $qtyk = (( ($rec2->pcl_qtyr_b + $rec2->pcl_qtyr_s) * $rec2->prd_frac) + ($rec2->pcl_qtyr_bk+$rec2->pcl_qtyr_sk)) % $rec2->prd_frac;

                        $qty7A = floor((( ($rec2->pcl_qtyr_b + $rec2->pcl_qtyr_s) * $rec2->prd_frac) + ($rec2->pcl_qtyr_bk+$rec2->pcl_qtyr_sk)) / $rec2->prd_frac );

                        $qty7B =(( ($rec2->pcl_qtyr_b + $rec2->pcl_qtyr_s) * $rec2->prd_frac) + ($rec2->pcl_qtyr_bk+$rec2->pcl_qtyr_sk)) % $rec2->prd_frac;

                        if($rec2->prd_unit == 'KG')
                            $value = 1;
                        else $value = $rec2->prd_frac;

                        $gross = ($qty7A * ($rec2->st_avgcost * $value)) + ($qty7B / $rec2->prd_frac * ($rec2->st_avgcost * $value));

                        $qty = ($qtyb * $rec2->prd_frac) + $qtyk;

                        $seq++;

                        $hrgsatuan = $rec2->st_avgcost * $value;

                        DB::connection(Session::get('connection'))->insert("insert into tbtr_backoffice(trbo_typetrn, trbo_nodoc, trbo_noreff, TRBO_NOFAKTUR, trbo_prdcd, trbo_loc, trbo_kodeigr,trbo_nopo, trbo_tglpo,
								 trbo_tgldoc, trbo_tglreff, trbo_qty, trbo_hrgsatuan, trbo_gross, trbo_ppnrph, trbo_averagecost, trbo_keterangan, trbo_gdg,
								 trbo_create_dt, trbo_create_by, trbo_furgnt,trbo_seqno, trbo_kodesupplier)
					values ('O', '".$nosj."', TRIM('".$rec2->pcl_nodokumen."'),  '".$sesikom."', TRIM('".$rec2->pcl_prdcd."'), TRIM('".$rec->pcl_kodecabang."'), '".Session::get('kdigr')."','".$rec2->pcl_noreferensi."', '".$rec2->pcl_tglreferensi."',SYSDATE, '".$rec2->pcl_tgldokumen."',  ".$qty.", ".$hrgsatuan.",
					  		".$gross.", 0, $hrgsatuan, '".$rec2->ket."',  null, '".$rec2->pcl_create_dt."',  '".$rec2->pcl_create_by."','".$rec2->pcl_furgnt."', ".$seq.", '".$rechgb->hrg_kodesupplier."')");
                    }
                }
            }
            else{
                $rechgbs = DB::connection(Session::get('connection'))->select("select distinct hgb_kodesupplier
								  		  		from tbtr_listpacking, tbmaster_hargabeli
								  		  		where pcl_kodecabang = '".$rec->PCL_KODECABANG."'
                                                and PCL_NODOKUMEN = '".$rec->PCL_NODOKUMEN."'
                                                and hgb_prdcd = pcl_prdcd
                                                and hgb_kodeigr= pcl_kodeigr
                                                and nvl(trim(hgb_tipe),'0') = '0'
                                                and hgb_kodesupplier = hgb_kodesupplier");

                foreach($rechgbs as $rechgb){
                    $seq = 0;

                    $ip = Session::get('ip');

                    $arrip = explode('.',$ip);

                    $c = loginController::getConnectionProcedure();
                    $s = oci_parse($c, "BEGIN :ret := F_IGR_GET_NOMORSTADOC('".Session::get('kdigr')."','SJK','Nomor Surat Jalan',".$arrip[3].",7,TRUE); END;");
                    oci_bind_by_name($s, ':ret', $nosj, 32);
                    oci_execute($s);

                    $rec2s = DB::connection(Session::get('connection'))->select("select PCL_NODOKUMEN, PCL_PRDCD, pcl_noreferensi, pcl_tgldokumen, pcl_tglreferensi,nvl(pcl_qtyr_b,0) pcl_qtyr_b,nvl(pcl_qtyr_s,0) pcl_qtyr_s, nvl(pcl_qtyr_bk,0) pcl_qtyr_bk,nvl(pcl_qtyr_sk,0) pcl_qtyr_sk,pcl_kodekoli||'-'||pcl_qtykoli ket, pcl_doc, pcl_doc2, pcl_fk,pcl_tglfakturpajak, pcl_mtag, pcl_create_dt,pcl_furgnt, pcl_create_by,
                        prd_kodedivisi, prd_kodedepartement, prd_kodekategoribarang, prd_unit,  prd_frac,st_avgcost
                        from tbtr_listpacking, tbmaster_prodmast, tbmaster_stock, tbmaster_hargabeli
                        where pcl_kodecabang = '".$rec->pcl_kodecabang."' and PCL_NODOKUMEN = '".$rec->pcl_nodokumen."'
                        and prd_prdcd = pcl_prdcd	and prd_kodeigr=pcl_kodeigr
                        and st_prdcd(+)=prd_prdcd and st_kodeigr(+)=prd_kodeigr and st_lokasi(+)='01'
                        and hgb_prdcd = pcl_prdcd and hgb_kodeigr= pcl_kodeigr and nvl(hgb_tipe,'0')='0' and hgb_kodesupplier = '".$rechgb->hgb_kodesupplier."'");

                    foreach($rec2s as $rec2){
                        if($pcldoc != $rec2->pcl_nodokumen){
                            $pcldoc = $rec2->pcl_nodokumen;
                            $nomorpc = $nomorpc."'".$pcldoc."',";
                        }

                        DB::connection(Session::get('connection'))->table('tbtr_listpacking')
                            ->where('pcl_kodecabang','=',$rec->pcl_kodecabang)
                            ->where('pcl_nodokumen','=',$rec2->pcl_nodokumen)
                            ->where('pcl_prdcd','=',$rec2->pcl_prdcd)
                            ->update([
                                'pcl_recordid' => '1',
                                'pcl_noreferensi1' => $nosj
                            ]);

                        $qtyb = floor((( ($rec2->pcl_qtyr_b + $rec2->pcl_qtyr_s) * $rec2->prd_frac) + ($rec2->pcl_qtyr_bk+$rec2->pcl_qtyr_sk)) / $rec2->prd_frac );

                        $qtyk = (( ($rec2->pcl_qtyr_b + $rec2->pcl_qtyr_s) * $rec2->prd_frac) + ($rec2->pcl_qtyr_bk+$rec2->pcl_qtyr_sk)) % $rec2->prd_frac;

                        $qty7A = floor((( ($rec2->pcl_qtyr_b + $rec2->pcl_qtyr_s) * $rec2->prd_frac) + ($rec2->pcl_qtyr_bk+$rec2->pcl_qtyr_sk)) / $rec2->prd_frac );

                        $qty7B =(( ($rec2->pcl_qtyr_b + $rec2->pcl_qtyr_s) * $rec2->prd_frac) + ($rec2->pcl_qtyr_bk+$rec2->pcl_qtyr_sk)) % $rec2->prd_frac;

                        if($rec2->prd_unit == 'KG')
                            $value = 1;
                        else $value = $rec2->prd_frac;

                        $gross = ($qty7A * ($rec2->st_avgcost * $value)) + ($qty7B / $rec2->prd_frac * ($rec2->st_avgcost * $value));

                        $qty = ($qtyb * $rec2->prd_frac) + $qtyk;

                        $seq++;

                        $hrgsatuan = $rec2->st_avgcost * $value;

                        DB::connection(Session::get('connection'))->insert("insert into tbtr_backoffice(trbo_typetrn, trbo_nodoc, trbo_noreff, TRBO_NOFAKTUR, trbo_prdcd, trbo_loc, trbo_kodeigr,trbo_nopo, trbo_tglpo,
								 trbo_tgldoc, trbo_tglreff, trbo_qty, trbo_hrgsatuan, trbo_gross, trbo_ppnrph, trbo_averagecost, trbo_keterangan, trbo_gdg,
								 trbo_create_dt, trbo_create_by, trbo_furgnt,trbo_seqno, trbo_kodesupplier)
					values ('O', '".$nosj."', TRIM('".$rec2->pcl_nodokumen."'),  '".$sesikom."', TRIM('".$rec2->pcl_prdcd."'), TRIM('".$rec->pcl_kodecabang."'), '".Session::get('kdigr')."','".$rec2->pcl_noreferensi."', '".$rec2->pcl_tglreferensi."',SYSDATE, '".$rec2->pcl_tgldokumen."',  ".$qty.", ".$hrgsatuan.",
					  		".$gross.", 0, $hrgsatuan, '".$rec2->ket."',  null, '".$rec2->pcl_create_dt."',  '".$rec2->pcl_create_by."','".$rec2->pcl_furgnt."', ".$seq.", '".$rechgb->hrg_kodesupplier."')");
                    }
                }
            }
        }
    }

    public function view_data($sesikom){
        $temp = 0;

        $recs = DB::connection(Session::get('connection'))->select("select DISTINCT TRBO_LOC, TRBO_NODOC, TRBO_NONOTA, TRBO_KODESUPPLIER, SUP_NAMASUPPLIER
                                  from tbtr_backoffice, tbmaster_supplier
							        where TRBO_KODEIGR = '".Session::get('kdigr')."' AND TRBO_TYPETRN = 'O' AND SUP_KODEIGR(+) = TRBO_KODEIGR
							        AND SUP_KODESUPPLIER(+) = TRBO_KODESUPPLIER
							        ORDER BY TRBO_LOC, TRBO_NODOC, TRBO_NONOTA, TRBO_KODESUPPLIER");

        return $recs;
    }

    public function cetak(){
        if(Session::get('sesikom')==null){
            return 'Terjadi kesalahan!';
        }

        $sesikom = Session::get('sesikom');

        $perusahaan = DB::connection(Session::get('connection'))->table('tbmaster_perusahaan')
            ->first();

        $data = DB::connection(Session::get('connection'))->select("select msth_recordid, msth_nodoc, msth_tgldoc, msth_nopo, msth_tglpo,
                    msth_nofaktur, msth_tglfaktur, msth_cterm, msth_flagdoc,
                    mstd_loc||' '||cab_namacabang cabang,
                    mstd_gdg gudang, MSTD_SEQNO,
                    mstd_prdcd, prd_deskripsipanjang, prd_unit||'/'||prd_frac kemasan, mstd_qty, mstd_frac,
                    mstd_hrgsatuan, mstd_ppnrph, mstd_ppnbmrph, mstd_ppnbtlrph, mstd_gross,
                    nvl(mstd_rphdisc1,0), nvl(mstd_rphdisc2,0),nvl(mstd_rphdisc3,0), nvl(mstd_qtybonus1,0),
                    nvl(mstd_qtybonus2,0), mstd_keterangan
                    from tbtr_mstran_h, tbtr_mstran_d, tbmaster_prodmast, tbmaster_cabang
                    where msth_kodeigr='".Session::get('kdigr')."'
                    and nvl(msth_flagdoc,' ') = '9'
                    AND MSTH_NOPO = '".$sesikom."'
                    and mstd_nodoc=msth_nodoc
                    and mstd_kodeigr=msth_kodeigr
                    and prd_prdcd = mstd_prdcd
                    and cab_kodecabang(+)=mstd_loc
                    and cab_kodeigr(+)=mstd_kodeigr
                    ORDER BY MSTH_NODOC, MSTH_TGLDOC, MSTH_NOFAKTUR, MSTH_TGLFAKTUR, MSTD_SEQNO");

        DB::connection(Session::get('connection'))->table('tbtr_backoffice')
            ->where('trbo_kodeigr','=',Session::get('kdigr'))
            ->where('trbo_flagdoc','=','9')
            ->where('trbo_typetrn','=','O')
            ->where('trbo_nofaktur','=',$sesikom)
            ->update([
                'trbo_flagdoc' => '*',
                'trbo_nofaktur' => ' ',
                'trbo_recordid' => '2'
            ]);

        DB::connection(Session::get('connection'))->table('tbtr_mstran_h')
            ->where('msth_flagdoc','=','9')
            ->where('msth_typetrn','=','O')
            ->where('msth_kodeigr','=',Session::get('kdigr'))
            ->where('msth_nopo','=',$sesikom)
            ->update([
                'msth_flagdoc' => '1',
                'msth_nopo' => ' '
            ]);

        $dompdf = new PDF();

        $pdf = PDF::loadview('BACKOFFICE.TRANSAKSI.KIRIMCABANG.sj-packlist-pdf',compact(['perusahaan','data']));

        error_reporting(E_ALL ^ E_DEPRECATED);

        $pdf->output();
        $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);

        $canvas = $dompdf ->get_canvas();
        $canvas->page_text(507, 80.75, "{PAGE_NUM} dari {PAGE_COUNT}", null, 7, array(0, 0, 0));

        $dompdf = $pdf;

        return $dompdf->stream('Surat Jalan Packlist.pdf');
    }

    public function nvl($value, $defaultvalue){
        if($value == null || $value == '')
            return $defaultvalue;
        else return $value;
    }
}























