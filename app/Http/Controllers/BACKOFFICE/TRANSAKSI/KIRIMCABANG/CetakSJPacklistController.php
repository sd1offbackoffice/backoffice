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

class CetakSJPacklistController extends Controller
{
    public function index(){
        return view('BACKOFFICE.TRANSAKSI.KIRIMCABANG.cetak-sj-packlist');
    }

    public function getPDF(){
        $perusahaan = DB::table('tbmaster_perusahaan')
            ->first();

        $data = DB::select("select msth_recordid, msth_nodoc, to_char(msth_tgldoc,'DD/MM/YYYY') msth_tgldoc, msth_nopo, msth_tglpo, msth_nofaktur, msth_tglfaktur, msth_cterm, msth_flagdoc,
                    mstd_loc||' '||cab_namacabang cabang,
                    mstd_gdg gudang, MSTD_SEQNO,
                    mstd_prdcd, prd_deskripsipanjang, prd_unit||'/'||prd_frac kemasan, mstd_qty, mstd_frac,
                    mstd_hrgsatuan, mstd_ppnrph, mstd_ppnbmrph, mstd_ppnbtlrph, mstd_gross,
                    nvl(mstd_rphdisc1,0), nvl(mstd_rphdisc2,0),nvl(mstd_rphdisc3,0), nvl(mstd_qtybonus1,0), nvl(mstd_qtybonus2,0),  mstd_keterangan
                    from tbtr_mstran_h, tbtr_mstran_d, tbmaster_prodmast, tbmaster_cabang
                    where msth_kodeigr='".$_SESSION['kdigr']."'
                    and nvl(msth_flagdoc,' ') = '9'
                    and mstd_nodoc=msth_nodoc
                    and mstd_kodeigr=msth_kodeigr
                    and prd_kodeigr=msth_kodeigr
                    and prd_prdcd = mstd_prdcd
                    and cab_kodecabang(+)=mstd_loc
                    and cab_kodeigr(+)=mstd_kodeigr
                    ORDER BY MSTH_NODOC, MSTH_TGLDOC, MSTH_NOFAKTUR, MSTH_TGLFAKTUR, MSTD_SEQNO");

        DB::table('tbtr_backoffice')
            ->where('trbo_kodeigr','=',$_SESSION['kdigr'])
            ->where('trbo_flagdoc','=','9')
            ->where('trbo_typetrn','=','O')
            ->update([
                'trbo_flagdoc' => '*',
            ]);

        DB::table('tbtr_mstran_h')
            ->where('msth_flagdoc','=','9')
            ->where('msth_typetrn','=','O')
            ->where('msth_kodeigr','=',$_SESSION['kdigr'])
            ->update([
                'msth_flagdoc' => '*',
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

    public function cetak(Request  $request){
        $data = DB::select("SELECT * FROM TBTR_BACKOFFICE, TBTR_LISTPACKING
	        WHERE TRBO_TYPETRN = 'O' AND TRUNC(TRBO_TGLDOC) BETWEEN TRUNC(TO_DATE('".$request->tgl1."','DD/MM/YYYY')) AND TRUNC(TO_DATE('".$request->tgl2."','DD/MM/YYYY')) AND TRBO_KODEIGR = '".$_SESSION['kdigr']."' AND NVL(TRBO_FLAGDOC,' ') <> '*' AND PCL_NODOKUMEN = TRBO_NOREFF AND PCL_NOREFERENSI1 = TRBO_NODOC AND NVL(PCL_NODOKUMEN,' ') <> ' ' AND PCL_NOREFERENSI = TRBO_NOPO AND PCL_PRDCD = TRBO_PRDCD ORDER BY TRBO_NODOC");

        if(count($data) == 0){
            $title = 'Data untuk periode tanggal tersebut tidak ada!';
            $status = 'error';

            return compact(['title','status']);
        }
        else{
            $v_nodoc = ' ';
            $trbodoc = ' ';
            $seq = 0;

            foreach($data as $rec){
                $temp = DB::table('tbmaster_prodmast')
                    ->where('prd_prdcd','=',$rec->trbo_prdcd)
                    ->where('prd_kodeigr','=',$_SESSION['kdigr'])
                    ->first();

                if($temp){
                    if(Self::nvl($rec->trbo_flagdoc,' ') != '*'){
                        if(Self::nvl($rec->trbo_nonota,' ') == ' '){
                            if(Self::nvl($trbodoc,' ') != Self::nvl($rec->trbo_nodoc,' ')){
                                $trbodoc = Self::nvl($rec->trbo_nodoc,' ');

                                $c = loginController::getConnectionProcedure();
                                $s = oci_parse($c, "BEGIN :ret := F_IGR_GET_NOMOR('".$_SESSION['kdigr']."','SJK','Nomor Surat Jalan','SJK' || ".$_SESSION['kdigr']." || TO_CHAR(SYSDATE, 'yy'),3,TRUE); END;");
                                oci_bind_by_name($s, ':ret', $v_nodoc, 32);
                                oci_execute($s);
                            }
                        }

                        $prdcur = DB::table('tbmaster_prodmast')
                            ->selectRaw("PRD_KODEDIVISI, PRD_KODEDEPARTEMENT, PRD_KODEKATEGORIBARANG, PRD_UNIT, PRD_FRAC, PRD_FLAGBKP1, PRD_FLAGBKP2")
                            ->where('prd_kodeigr','=',$_SESSION['kdigr'])
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

                        $temp = DB::select("SELECT NVL(COUNT(1),0) FROM TBMASTER_STOCK
				WHERE ST_KODEIGR = '".$_SESSION['kdigr']."' AND ST_PRDCD = SUBSTR('".$rec->trbo_prdcd."',1,6) || '0'
				AND ST_LOKASI = '01'");

                        if(count($temp) == 0){
                            if(Self::nvl($unitp,' ') == 'KG'){
                                DB::table('tbmaster_stock')
                                    ->insert([
                                        'st_kodeigr' => $_SESSION['kdigr'],
                                        'st_prdcd' => substr($rec->trbo_prdcd,0,6).'0',
                                        'st_lokasi' => '01',
                                        'st_saldoakhir' => ($rec->trbo_qty / 1000 * -1),
                                        'st_trfout' => ($rec->trbo_qty / 1000)
                                    ]);
                            }
                            else{
                                DB::table('tbmaster_stock')
                                    ->insert([
                                        'st_kodeigr' => $_SESSION['kdigr'],
                                        'st_prdcd' => substr($rec->trbo_prdcd,0,6).'0',
                                        'st_lokasi' => '01',
                                        'st_saldoakhir' => ($rec->trbo_qty * -1),
                                        'st_trfout' => $rec->trbo_qty
                                    ]);
                            }
                        }
                        else{
                            if(Self::nvl($unitp,' ') == 'KG'){
                                DB::update("UPDATE TBMASTER_STOCK
                            SET ST_SALDOAKHIR = (ST_SALDOAKHIR - (".$rec->trbo_qty." / 1000)),
                            ST_TRFOUT = (ST_TRFOUT + (".$rec->trbo_qty." / 1000))
                            WHERE ST_KODEIGR = '".$_SESSION['kdigr']."' AND ST_PRDCD = SUBSTR('".$rec->trbo_prdcd."',1,6) || '0'
                            AND ST_LOKASI = '01';");
                            }
                            else{
                                DB::update("UPDATE TBMASTER_STOCK
                            SET ST_SALDOAKHIR = (ST_SALDOAKHIR - (".$rec->trbo_qty.")),
                            ST_TRFOUT = (ST_TRFOUT + (".$rec->trbo_qty."))
                            WHERE ST_KODEIGR = '".$_SESSION['kdigr']."' AND ST_PRDCD = SUBSTR('".$rec->trbo_prdcd."',1,6) || '0'
                            AND ST_LOKASI = '01';");
                            }
                        }

                        $temp = DB::table('tbtr_mstran_h')
                            ->where('msth_kodeigr','=',$_SESSION['kdigr'])
                            ->where('msth_typetrn','=','O')
                            ->where('msth_nodoc','=',$v_nodoc)
                            ->where('msth_nofaktur','=',$rec->trbo_noreff)
                            ->where('msth_kodesupplier','=',$rec->trbo_kodesupplier)
                            ->count();

                        if($temp == 0){
                            DB::table('tbtr_mstran_h')
                                ->insert([
                                    'msth_kodeigr' => $_SESSION['kdigr'],
                                    'msth_typetrn' => 'O',
                                    'msth_nodoc' => $v_nodoc,
                                    'msth_tgldoc' => DB::RAW("SYSDATE"),
                                    'msth_nofaktur' => $rec->trbo_noreff,
                                    'msth_tglfaktur' => $rec->trbo_tglreff,
                                    'msth_kodesupplier' => $rec->trbo_kodesupplier,
                                    'msth_pkp' => 'Y',
                                    'msth_loc' => $rec->trbo_loc,
                                    'msth_loc2' => '',
                                    'msth_flagdoc' => '9',
                                    'msth_create_by' => $_SESSION['usid'],
                                    'msth_create_dt' => DB::RAW("SYSDATE")
                                ]);
                        }

                        $temp = DB::table('tbtr_mstran_d')
                            ->where('mstd_kodeigr','=',$_SESSION['kdigr'])
                            ->where('mstd_typetrn','=','O')
                            ->where('mstd_nodoc','=',$v_nodoc)
                            ->where('mstd_nofaktur','=',$rec->trbo_noreff)
                            ->where('mstd_prdcd','=',$rec->trbo_prdcd)
                            ->count();

                        if($temp == 0){
                            $seq++;

                            DB::table('tbtr_mstran_d')
                                ->insert([
                                    'mstd_kodeigr' => $_SESSION['kdigr'],
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
                                    'mstd_create_by' => $_SESSION['usid'],
                                    'mstd_create_dt' => DB::RAW("SYSDATE")
                                ]);
                        }

                        DB::table('tbtr_backoffice')
                            ->where('trbo_kodeigr','=',$_SESSION['kdigr'])
                            ->where('trbo_typetrn','=','O')
                            ->where('trbo_nodoc','=',$rec->trbo_nodoc)
                            ->where('trbo_tgldoc','=',$rec->trbo_tgldoc)
                            ->where('trbo_prdcd','=',$rec->trbo_prdcd)
                            ->insert([
                                'trbo_flagdoc' => '9',
                                'trbo_nonota' => $v_nodoc,
                                'trbo_tglnota' => DB::RAW("SYSDATE")
                            ]);
                    }
                }
            }

            $data = DB::select("select msth_recordid, msth_nodoc, msth_tgldoc, msth_nopo, msth_tglpo,
                    msth_nofaktur, msth_tglfaktur, msth_cterm, msth_flagdoc,
                    prs_namaperusahaan, prs_namacabang, prs_alamat1, prs_alamat3,prs_npwp,
                    mstd_loc||' '||cab_namacabang cabang,
                    mstd_gdg gudang, MSTD_SEQNO,
                    mstd_prdcd, prd_deskripsipanjang, prd_unit||'/'||prd_frac kemasan, mstd_qty, mstd_frac,
                    mstd_hrgsatuan, mstd_ppnrph, mstd_ppnbmrph, mstd_ppnbtlrph, mstd_gross,
                    nvl(mstd_rphdisc1,0), nvl(mstd_rphdisc2,0),nvl(mstd_rphdisc3,0), nvl(mstd_qtybonus1,0),
                    nvl(mstd_qtybonus2,0), mstd_keterangan
                    from tbtr_mstran_h, tbmaster_perusahaan, tbtr_mstran_d, tbmaster_prodmast, tbmaster_cabang
                    where msth_kodeigr='".$_SESSION['kdigr']."'
                    and nvl(msth_flagdoc,' ') = '9'
                    and prs_kodeigr=msth_kodeigr
                    and mstd_nodoc=msth_nodoc
                    and mstd_kodeigr=msth_kodeigr
                    and prd_kodeigr=msth_kodeigr
                    and prd_prdcd = mstd_prdcd
                    and cab_kodecabang(+)=mstd_loc
                    and cab_kodeigr(+)=mstd_kodeigr
                    ORDER BY MSTH_NODOC, MSTH_TGLDOC, MSTH_NOFAKTUR, MSTH_TGLFAKTUR, MSTD_SEQNO");
        }
    }

    public function nvl($value, $defaultvalue){
        if($value == null || $value == '')
            return $defaultvalue;
        else return $value;
    }
}
