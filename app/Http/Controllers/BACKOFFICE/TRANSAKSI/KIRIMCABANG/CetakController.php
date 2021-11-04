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

class CetakController extends Controller
{
    public function index(){
        return view('BACKOFFICE.TRANSAKSI.KIRIMCABANG.cetak');
    }

    public function getData(Request $request){
        $reprint = $request->reprint;
        $jenis = $request->jenis;
        $tgl1 = $request->tgl1;
        $tgl2 = $request->tgl2;

        if($jenis == 1){
            $data = DB::connection($_SESSION['connection'])->table('tbtr_backoffice')
                ->selectRaw("trbo_nodoc no, trbo_tgldoc tgl")
                ->where('trbo_typetrn','=','O')
                ->whereRaw("trbo_recordid is null")
                ->where('trbo_flagdoc','=',$reprint)
                ->whereRaw("trbo_tgldoc between TO_DATE('".$tgl1."','dd/mm/yyyy') and TO_DATE('".$tgl2."','dd/mm/yyyy')")
                ->get();
        }
        else{
            if($reprint == 0){
                $data = DB::connection($_SESSION['connection'])->table('tbtr_backoffice')
                    ->selectRaw("trbo_nodoc no, trbo_tgldoc tgl")
                    ->where('trbo_typetrn','=','O')
                    ->whereRaw("nvl(trbo_flagdoc,' ') = '1'")
                    ->whereRaw("trbo_tgldoc between TO_DATE('".$tgl1."','dd/mm/yyyy') and TO_DATE('".$tgl2."','dd/mm/yyyy')")
                    ->get();
            }
            else{
                $data = DB::connection($_SESSION['connection'])->table('tbtr_mstran_h')
                    ->selectRaw("msth_nodoc no, msth_tgldoc tgl")
                    ->where('msth_typetrn','=','O')
                    ->whereRaw("nvl(msth_recordid,' ') <> '1'")
                    ->whereRaw("msth_tgldoc between TO_DATE('".$tgl1."','dd/mm/yyyy') and TO_DATE('".$tgl2."','dd/mm/yyyy')")
                    ->orderBy('msth_nodoc','desc')
                    ->get();
            }
        }

        return $data;
    }

    public function storeData(Request $request){
        try{
            $_SESSION['kkc_nodoc'] = $request->nodoc;
            $_SESSION['kkc_reprint'] = $request->reprint;
            $_SESSION['kkc_jenis'] = $request->jenis;
        }
        catch(\Exception $e){
            return 'false';
        }
        return 'true';
    }

    public function laporan(){
        $lap_nodoc = [];
        $reprint = $_SESSION['kkc_reprint'];

        try{
            DB::beginTransaction();

            if($_SESSION['kkc_jenis'] == 1){
                if($_SESSION['kkc_reprint'] == 0){
                    DB::connection($_SESSION['connection'])->table('tbtr_backoffice')
                        ->whereIn('trbo_nodoc',$_SESSION['kkc_nodoc'])
                        ->update([
                            'trbo_flagdoc' => '1'
                        ]);
                }

                $nodoc = "(";
                foreach($_SESSION['kkc_nodoc'] as $l){
                    $nodoc .= "'".$l."',";
                }
                $nodoc = substr($nodoc,0,-1).')';

                $data = DB::connection($_SESSION['connection'])->select("SELECT   trbo_nodoc,
                                             trbo_tgldoc,
                                             trbo_noreff,
                                             trbo_flagdisc1,
                                             trbo_prdcd,
                                             trbo_hrgsatuan,
                                             trbo_keterangan,
                                             trbo_qty,
                                             FLOOR(trbo_qty / prd_frac) AS ctn,
                                             MOD(trbo_qty, prd_frac) AS pcs,
                                             trbo_gross AS total,
                                             CASE
                                                 WHEN trbo_flagdisc1 = '1'
                                                     THEN 'BARANG BAIK'
                                                 ELSE CASE
                                                 WHEN trbo_flagdisc1 = '2'
                                                     THEN 'BARANG RETUR'
                                                 ELSE CASE
                                                 WHEN trbo_flagdisc1 = '3'
                                                     THEN 'BARANG RUSAK'
                                                 ELSE ''
                                             END
                                             END
                                             END AS ket,
                                             prd_deskripsipanjang,
                                             prd_unit,
                                             prd_frac,
                                             trbo_loc,
                                             cab_namacabang,
                                             trbo_gdg,
                                             gdg_namagudang
                                        FROM tbtr_backoffice, tbmaster_prodmast, tbmaster_cabang, tbmaster_gudang
                                       WHERE trbo_kodeigr = '".$_SESSION['kdigr']."'
                                         AND trbo_nodoc in ".$nodoc."
                                         AND prd_kodeigr = trbo_kodeigr
                                         AND prd_prdcd = trbo_prdcd
                                         AND trbo_kodeigr = cab_kodeigr(+)
                                         AND trbo_loc = cab_kodecabang(+)
                                         AND trbo_kodeigr = gdg_kodeigr(+)
                                         AND trbo_kodeigr || trbo_gdg = gdg_kodegudang(+)
                                    ORDER BY trbo_nodoc, trbo_seqno");

                $perusahaan = DB::connection($_SESSION['connection'])->table('tbmaster_perusahaan')
                    ->first();

//                dd($data[0]);

                $dompdf = new PDF();

                $pdf = PDF::loadview('BACKOFFICE.TRANSAKSI.KIRIMCABANG.laporan-list',compact(['perusahaan','data','reprint']));

                error_reporting(E_ALL ^ E_DEPRECATED);

                $pdf->output();
                $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);

                $canvas = $dompdf ->get_canvas();
                $canvas->page_text(507, 80.75, "{PAGE_NUM} dari {PAGE_COUNT}", null, 7, array(0, 0, 0));

                $dompdf = $pdf;

                return $dompdf->stream('Edit List Surat Jalan.pdf');
            }
            else{
                if($reprint == 0){
                    foreach($_SESSION['kkc_nodoc'] as $knodoc){
                        $c = loginController::getConnectionProcedure();
                        $s = oci_parse($c, "BEGIN :ret := F_IGR_GET_NOMORSTADOC('".$_SESSION['kdigr']."','SJK','Nomor Surat Jalan','3' || TO_CHAR(SYSDATE, 'yy'),5,TRUE); END;");
                        oci_bind_by_name($s, ':ret', $vnodoc, 32);
                        oci_execute($s);

                        $data = DB::connection($_SESSION['connection'])->select("SELECT aa.*,
															      prd_unit, prd_frac, prd_flagbkp1,prd_flagbkp2,prd_kodedivisi,
															      prd_kodedepartement, prd_kodekategoribarang,prd_kodetag,
															      sup_pkp, prd_kodesupplier,sup_top,st_saldoakhir,st_lastcost,st_avgcost
													   FROM tbtr_backoffice aa, tbmaster_prodmast bb, tbmaster_supplier, tbmaster_stock
                             WHERE trbo_nodoc = '".$knodoc."' and trbo_typetrn='O'
                          		     and prd_prdcd=trbo_prdcd
                                     and prd_kodeigr=trbo_kodeigr
                                     and sup_kodesupplier(+)=prd_kodesupplier
                                     and sup_kodeigr(+)=prd_kodeigr
                                     and trbo_kodeigr=st_kodeigr(+)
                                     and substr(trbo_prdcd,1,6)||'0'=st_prdcd
                                     and '01'=st_lokasi
                             ORDER BY trbo_seqno");

                        foreach($data as $d){
                            DB::connection($_SESSION['connection'])->table('tbtr_mstran_d')
                                ->insert([
                                    'mstd_kodeigr' => $_SESSION['kdigr'],
                                    'mstd_typetrn' => $d->trbo_typetrn,
                                    'mstd_nodoc' => $vnodoc,
                                    'mstd_tgldoc' => DB::RAW("trunc(sysdate)"),
                                    'mstd_pkp' => $d->prd_flagbkp1,
                                    'mstd_noref3' => $d->trbo_noreff,
                                    'mstd_tgref3' => $d->trbo_tglreff,
                                    'mstd_loc' => $_SESSION['kdigr'],
                                    'mstd_loc2' => $d->trbo_loc,
                                    'mstd_seqno' => $d->trbo_seqno,
                                    'mstd_prdcd' => $d->trbo_prdcd,
                                    'mstd_unit' => $d->prd_unit,
                                    'mstd_frac' => $d->prd_frac,
                                    'mstd_qty' => $d->trbo_qty,
                                    'mstd_flagdisc1' => $d->trbo_flagdisc1,
                                    'mstd_gross' => $d->trbo_gross,
                                    'mstd_avgcost' => $d->trbo_averagecost,
                                    'mstd_ocost' => $d->trbo_oldcost,
                                    'mstd_bkp' => $d->prd_flagbkp1,
                                    'mstd_fobkp' => $d->prd_flagbkp2,
                                    'mstd_ppnrph' => $d->trbo_ppnrph,
                                    'mstd_create_by' => $_SESSION['usid'],
                                    'mstd_create_dt' => DB::RAW("sysdate"),
                                    'mstd_hrgsatuan' => $d->trbo_hrgsatuan,
                                    'mstd_kodedivisi' => $d->prd_kodedivisi,
                                    'mstd_kodedepartement' => $d->prd_kodedepartement,
                                    'mstd_kodekategoribrg' => $d->prd_kodekateg,
                                    'mstd_qtybonus1' => $d->trbo_qtybonus1,
                                    'mstd_qtybonus2' => $d->trbo_qtybonus2,
                                    'mstd_persendisc1' => $d->trbo_persendisc1,
                                    'mstd_rphdisc1' => $d->trbo_rphdisc1,
                                    'mstd_persendisc2' => $d->trbo_persendisc2,
                                    'mstd_rphdisc2' => $d->trbo_rphdisc2,
                                    'mstd_persendisc3' => $d->trbo_persendisc3,
                                    'mstd_rphdisc3' => $d->trbo_rphdisc3,
                                    'mstd_persendisc4' => $d->trbo_persendisc4,
                                    'mstd_rphdisc4' => $d->trbo_rphdisc4,
                                    'mstd_keterangan' => $d->trbo_keterangan,
                                    'mstd_posqty' => $d->st_saldoakhir,
                                    'mstd_kodetag' => $d->prd_kodetag,
                                ]);

                            $vlok = '';
                            $vmessage = '';

                            $c = loginController::getConnectionProcedure();
                            $s = oci_parse($c, "BEGIN SP_IGR_UPDATE_STOCK('".$_SESSION['kdigr']."','01','".$d->trbo_prdcd."','".$d->trbo_kodesupplier."','TRFOUT','".$d->trbo_qty."','".$d->st_lastcost."','".$d->st_avgcost."','".$_SESSION['usid']."',:vlok,:vmessage); END;");
                            oci_bind_by_name($s,':vlok',$vlok);
                            oci_bind_by_name($s,':vmessage',$vmessage);
                            oci_execute($s);

                            $v_supp = $d->prd_kodesupplier;
                            $v_loc  = $d->trbo_loc;
                            $v_gud  = $d->trbo_gdg;
                            $v_ref  = $d->trbo_noreff;
                            $v_tgref= $d->trbo_tglreff;
                        }

                        DB::connection($_SESSION['connection'])->table('tbtr_mstran_h')
                            ->insert([
                                'MSTH_KODEIGR' => $_SESSION['kdigr'],
                                'MSTH_RECORDID' => '',
                                'MSTH_TYPETRN' => 'O',
                                'MSTH_NODOC' => $vnodoc,
                                'MSTH_TGLDOC' => DB::RAW("TRUNC(SYSDATE)"),
                                'MSTH_NOPO' => '',
                                'MSTH_TGLPO' => null,
                                'MSTH_NOFAKTUR' => null,
                                'MSTH_TGLFAKTUR' => null,
                                'MSTH_NOREF3' => $v_ref,
                                'MSTH_TGREF3' => $v_tgref,
                                'MSTH_ISTYPE' => null,
                                'MSTH_INVNO' => null,
                                'MSTH_TGLINV' => null,
                                'MSTH_NOTT' => null,
                                'MSTH_TGLTT' => null,
                                'MSTH_PKP' => null,
                                'MSTH_LOC' => $_SESSION['kdigr'],
                                'MSTH_LOC2' => $v_loc,
                                'MSTH_KETERANGAN_HEADER' => null,
                                'MSTH_FURGNT' => null,
                                'MSTH_FLAGDOC' => '1',
                                'MSTH_CREATE_BY' => $_SESSION['usid'],
                                'MSTH_CREATE_DT' => DB::RAW("SYSDATE"),
                                'MSTH_MODIFY_BY' => $_SESSION['usid'],
                                'MSTH_MODIFY_DT' => DB::RAW("SYSDATE"),
                            ]);

                        DB::connection($_SESSION['connection'])->table('tbtr_backoffice')
                            ->where('trbo_nodoc',$knodoc)
                            ->where('trbo_typetrn','=','O')
                            ->update([
                                'trbo_nonota' => $vnodoc,
                                'trbo_tglnota' => DB::RAW("SYSDATE"),
                                'trbo_recordid' => '2',
                                'trbo_flagdoc' => '*'
                            ]);

                        $lap_nodoc[] = $vnodoc;
                    }
                }
                else {
                    $lap_nodoc = $_SESSION['kkc_nodoc'];
                }

                $nodoc = "(";
                foreach($lap_nodoc as $l){
                    $nodoc .= "'".$l."',";
                }
                $nodoc = substr($nodoc,0,-1).')';

                $perusahaan = DB::connection($_SESSION['connection'])->table('tbmaster_perusahaan')
                    ->first();

                $data = DB::connection($_SESSION['connection'])->select("SELECT msth_recordid, msth_nodoc, msth_tgldoc, msth_nopo, msth_tglpo,
                        msth_nofaktur, msth_tglfaktur,
                        msth_noref3,msth_tgref3,msth_cterm, msth_flagdoc,
                        mstd_flagdisc1,msth_loc,cab_namacabang,msth_loc2,gdg_namagudang,
                        mstd_prdcd, prd_deskripsipanjang, prd_unit||'/'||prd_frac kemasan, mstd_qty, mstd_frac,
                        mstd_hrgsatuan, mstd_ppnrph, mstd_ppnbmrph, mstd_ppnbtlrph, mstd_gross,
                        nvl(mstd_rphdisc1,0), nvl(mstd_rphdisc2,0),nvl(mstd_rphdisc3,0), nvl(mstd_qtybonus1,0), nvl(mstd_qtybonus2,0),  mstd_keterangan
                        FROM tbtr_mstran_h, tbtr_mstran_d, tbmaster_prodmast, tbmaster_cabang,tbmaster_gudang
                        WHERE msth_kodeigr='".$_SESSION['kdigr']."'
                        and msth_nodoc in ".$nodoc."
                        and mstd_nodoc=msth_nodoc
                        and mstd_kodeigr=msth_kodeigr
                        and prd_kodeigr=msth_kodeigr
                        and prd_prdcd = mstd_prdcd
                        and msth_kodeigr=cab_kodeigr(+)
                        and msth_loc2=cab_kodecabang(+)
                        and msth_kodeigr=gdg_kodeigr(+)
                        and msth_kodeigr||msth_loc2=gdg_kodegudang(+)
                        ORDER BY msth_nodoc,mstd_prdcd");

//                dd($data[0]);

                $dompdf = new PDF();

                $pdf = PDF::loadview('BACKOFFICE.TRANSAKSI.KIRIMCABANG.laporan-nota',compact(['perusahaan','data','reprint']));

                error_reporting(E_ALL ^ E_DEPRECATED);

                $pdf->output();
                $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);

                $canvas = $dompdf ->get_canvas();
                $canvas->page_text(507, 80.75, "{PAGE_NUM} dari {PAGE_COUNT}", null, 7, array(0, 0, 0));

                $dompdf = $pdf;

                return $dompdf->stream('Surat Jalan.pdf');
            }
        }
        catch(QueryException $e){
            dd($e->getMessage());
        }
    }
}
