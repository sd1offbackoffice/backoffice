<?php

namespace App\Http\Controllers\BACKOFFICE\TRANSAKSI\PENERIMAANDARICABANG;

use App\Http\Controllers\Auth\loginController;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;
use PDF;
use XBase\TableReader;
use Yajra\DataTables\DataTables;
use ZipArchive;
use File;

class PenerimaanTransferController extends Controller
{
    public function index()
    {
        return view('BACKOFFICE.TRANSAKSI.PENERIMAANDARICABANG.penerimaan-transfer');
    }

    public function getDataTSJ()
    {
        $datatsj = DB::connection(Session::get('connection'))->table('tbtr_tolakansj')
            ->selectRaw("tsj_nodokumen no, TO_CHAR(tsj_tgldokumen,'DD/MM/YYYY') tgl, count(1) as jum")
            ->whereRaw("NVL(tsj_recordid,'0') <> '1'")
            ->where('tsj_kodeigr', '=', Session::get('kdigr'))
            ->where('tsj_lokasiterima', '=', Session::get('kdigr'))
            ->groupBy(['tsj_nodokumen', 'tsj_tgldokumen'])
            ->orderBy('tsj_nodokumen')
            ->get();

        return $datatsj;
    }

    public function getDetailTSJ(Request $request)
    {
        $detail = DB::connection(Session::get('connection'))->table('tbtr_tolakansj')
            ->join('tbmaster_prodmast', function ($join) {
                $join->on('prd_prdcd', '=', 'tsj_prdcd');
                $join->on('prd_kodeigr', '=', 'tsj_kodeigr');
            })
            ->select('tsj_prdcd', 'tsj_qty', 'tsj_qtyk', 'prd_deskripsipanjang')
            ->whereRaw("NVL(tsj_recordid,'0') <> '1'")
            ->where('tsj_nodokumen', '=', $request->no)
            ->where('tsj_kodeigr', '=', Session::get('kdigr'))
            ->where('tsj_lokasiterima', '=', Session::get('kdigr'))
            ->get();

        return $detail;
    }

    public function prosesAlfdoc(Request $request)
    {
        try {
            $docs = $request->docs;

            $recs = DB::connection(Session::get('connection'))->table('tbtr_tolakansj')
                ->whereRaw("nvl(tsj_recordid,' ') <> '1'")
                ->where('tsj_lokasiterima', '=', Session::get('kdigr'))
                ->where('tsj_kodeigr', '=', Session::get('kdigr'))
                ->orderBy('tsj_nodokumen')
                ->get();

            $osqty2 = 0;
            $ocost2 = 0;
            $alert = [];

            DB::connection(Session::get('connection'))->beginTransaction();

            foreach ($recs as $rec) {
                $jum = 0;
                $temp = 0;
                $keterx = '';
                $recid = '';
                $kttk = '';
                $desk = '';
                $kcab = '';
                $lpos = '';
                $ndoc = '';
                $fobkp = '';
                $prosesp = 1;
                $stmastb = 0;

                $step = 1;

                $jum = DB::connection(Session::get('connection'))->table('tbmaster_prodmast')
                    ->selectRaw("nvl(prd_recordid,'0') recid, prd_deskripsipendek, prd_kodecabang, prd_kategoritoko")
                    ->where('prd_prdcd', '=', $rec->tsj_prdcd)
                    ->where('prd_kodeigr', '=', Session::get('kdigr'))
                    ->first();

                if ($jum) {
                    $recid = $jum->recid;
                    $desk = $jum->prd_deskripsipendek;
                    $kcab = $jum->prd_kodecabang;
                    $kttk = $jum->prd_kategoritoko;
                }

                $step = 3;
                $keterx = $desk;

                if (!$jum || $recid == '1') {
                    $step = 4;
                    $keterx = 'TIDAK TERDAFTAR DI MASTER BARANG';
                    $prosesp = 0;
                }

                if ($kttk == null && $kcab == null) {
                    $step = 5;
                    $keterx = 'TIDAK MEMPUNYAI KATEGORI TOKO DAN KODE CABANG';
                    $prosesp = 0;
                }

                if ($keterx != '') {
                    DB::connection(Session::get('connection'))->table('tbtr_tolakansj')
                        ->where('tsj_kodeigr', '=', Session::get('kdigr'))
                        ->where('tsj_nodokumen', '=', $rec->tsj_nodokumen)
                        ->where('tsj_prdcd', '=', $rec->tsj_prdcd)
                        ->update([
                            'tsj_keteranganx' => $keterx,
                            'tsj_modify_by' => Session::get('usid'),
                            'tsj_modify_dt' => Carbon::now()
                        ]);
                }

                $step = 7;
                $jum = 0;
                $prosesp = 1;

                if ($prosesp == 1) {
                    $step = 8;

                    foreach ($docs as $doc) {
                        if ($rec->tsj_nodokumen == $doc) {
                            $jum = DB::connection(Session::get('connection'))->table('tbmaster_stock')
                                ->select('st_saldoakhir', 'st_avgcost')
                                ->where('st_kodeigr', '=', Session::get('kdigr'))
                                ->where('st_lokasi', '=', '01')
                                ->where('st_prdcd', '=', $rec->tsj_prdcd)
                                ->first();

                            if ($jum) {
                                $osqty2 = $jum->st_saldoakhir;
                                $ocost2 = $jum->st_avgcost;
                            } else {
                                $osqty2 = 0;
                                $ocost2 = 0;
                            }

                            $step = 9;

                            $jum = DB::connection(Session::get('connection'))->table('tbtr_mstran_h')
                                ->where('msth_typetrn', '=', 'I')
                                ->whereRaw("TRIM(msth_nopo) = TRIM('" . $rec->tsj_nodokumen . "')")
                                ->where('msth_kodeigr', '=', Session::get('kdigr'))
                                ->get();

                            $step = 10;

                            if (count($jum) == 0) {
                                $step = 11;

                                $c = loginController::getConnectionProcedure();
                                $s = oci_parse($c, "BEGIN :ret := F_IGR_GET_NOMOR('" . Session::get('kdigr') . "','TSJ','Nomor Terima SJ','4' || TO_CHAR(SYSDATE, 'yy'),5,TRUE); END;");
                                oci_bind_by_name($s, ':ret', $ndoc, 32);
                                oci_execute($s);
                            } else {
                                $ndoc = $rec->tsj_nodokumen;
                            }

                            if (count($jum) > 0) {
                                $step = 12;

                                $alert[] = 'DATA DI TABLE TBTR_TOLAKANSJ DENGAN NOMOR DOKUMEN ' . $rec->tsj_nodokumen . ' SUDAH PERNAH DIPROSES';

                                DB::connection(Session::get('connection'))->table('tbtr_tolakansj')
                                    ->where('tsj_prdcd', '=', $rec->tsj_prdcd)
                                    ->where('tsj_nodokumen', '=', $rec->tsj_nodokumen)
                                    ->where('tsj_kodeigr', '=', $rec->tsj_kodeigr)
                                    ->delete();
                            }

                            $step = 120;

                            $jum = DB::connection(Session::get('connection'))->table('temp_tolakansj')
                                ->where('docno', '=', $rec->tsj_nodokumen)
                                ->where('prdcd', '=', $rec->tsj_prdcd)
                                ->get();

                            if (count($jum) == 0) {
                                DB::connection(Session::get('connection'))->insert("INSERT INTO TEMP_TOLAKANSJ
									VALUES(
									'" . $rec->tsj_recordid . "',
                                    '" . $rec->tsj_recordtype . "',
                                    '" . $ndoc . "',
                                    '" . $rec->tsj_nodokumen . "',
                                    '" . $rec->tsj_tgldokumen . "',
                                    '" . $rec->tsj_noreferensi1 . "',
                                    '" . $rec->tsj_tglreferensi1 . "',
                                    '" . $rec->tsj_noreferensi2 . "',
                                    '" . $rec->tsj_tglreferensi2 . "',
                                    '" . $rec->tsj_nodokumen2 . "',
                                    '" . $rec->tsj_tgldokumen2 . "',
                                    '" . $rec->tsj_hdrfakturpajak . "',
                                    '" . $rec->tsj_nofakturpajak . "',
                                    '" . $rec->tsj_date3 . "',
                                    '" . $rec->tsj_nott . "',
                                    '" . $rec->tsj_date4 . "',
                                    '" . $rec->tsj_kodesupplier . "',
                                    '" . $rec->tsj_flagpkp . "',
                                    '" . $rec->tsj_top . "',
                                    '" . $rec->tsj_nourut . "',
                                    '" . $rec->tsj_prdcd . "',
                                    '" . $rec->tsj_kodedivisi . "',
                                    '" . $rec->tsj_kodedepartemen . "',
                                    '" . $rec->tsj_kodekategoribrg . "',
                                    '" . $rec->tsj_flagbkp1 . "',
                                    '" . $rec->tsj_flagbkp2 . "',
                                    '" . $rec->tsj_unit . "',
                                    '" . $rec->tsj_fraction . "',
                                    '" . $rec->tsj_lokasikirim . "',
                                    '" . $rec->tsj_lokasiterima . "',
                                    '" . $rec->tsj_qty . "',
                                    '" . $rec->tsj_qtyk . "',
                                    '" . $rec->tsj_qbns1 . "',
                                    '" . $rec->tsj_qbns2 . "',
                                    '" . $rec->tsj_price . "',
                                    '" . $rec->tsj_persendisc1 . "',
                                    '" . $rec->tsj_rupiahdisc1 . "',
                                    '" . $rec->tsj_flagdisc1 . "',
                                    '" . $rec->tsj_persendisc2 . "',
                                    '" . $rec->tsj_rupiahdisc2 . "',
                                    '" . $rec->tsj_flagdisc2 . "',
                                    '" . $rec->tsj_gross . "',
                                    '" . $rec->tsj_discrp . "',
                                    '" . $rec->tsj_ppn . "',
                                    '" . $rec->tsj_ppnbrgmewah . "',
                                    '" . $rec->tsj_ppnbotol . "',
                                    '" . $rec->tsj_avgcost . "',
                                    '" . $rec->tsj_keterangan . "',
                                    '" . $rec->tsj_doc . "',
                                    '" . $rec->tsj_doc2 . "',
                                    '" . $rec->tsj_fk . "',
                                    '" . $rec->tsj_tglfp . "',
                                    '" . $rec->tsj_mtag . "',
                                    '" . $rec->tsj_kodegudang . "',
                                    '" . $rec->tsj_keteranganx . "'
									)");
                            }

                            $jum = DB::connection(Session::get('connection'))->table('tbmaster_barangbaru')
                                ->where('pln_kodeigr', '=', Session::get('kdigr'))
                                ->where('pln_prdcd', '=', $rec->tsj_prdcd)
                                ->first();

                            if ($jum) {
                                DB::connection(Session::get('connection'))->table('tbmaster_barangbaru')
                                    ->where('pln_kodeigr', '=', Session::get('kdigr'))
                                    ->where('pln_prdcd', '=', $rec->tsj_prdcd)
                                    ->update([
                                        'pln_tglbpb' => DB::connection(Session::get('connection'))->raw("TRUNC(SYSDATE)"),
                                        'pln_modify_by' => Session::get('usid'),
                                        'pln_modify_dt' => Carbon::now()
                                    ]);
                            }

                            $jum = DB::connection(Session::get('connection'))->table('tbtr_ipb')
                                ->where('ipb_noipb', '=', $rec->tsj_noreferensi1)
                                ->where('ipb_tglipb', '=', $rec->tsj_tglreferensi1)
                                ->where('ipb_prdcd', '=', substr($rec->tsj_prdcd, 0, 6) . '0')
                                ->where('ipb_kodeigr', '=', Session::get('kdigr'))
                                ->get();

                            if (count($jum) > 0) {
                                $step = 16;

                                DB::connection(Session::get('connection'))->table('tbtr_ipb')
                                    ->where('ipb_noipb', '=', $rec->tsj_noreferensi1)
                                    ->where('ipb_tglipb', '=', $rec->tsj_tglreferensi1)
                                    ->where('ipb_prdcd', '=', substr($rec->tsj_prdcd, 0, 6) . '0')
                                    ->where('ipb_kodeigr', '=', Session::get('kdigr'))
                                    ->update([
                                        'ipb_recordid' => '2',
                                        'ipb_qtyrealisasi' => $rec->tsj_qty * $rec->tsj_fraction + $rec->tsj_qtyk
                                    ]);
                            }

                            $step = 17;

                            $jum = DB::connection(Session::get('connection'))->table('tbtr_mstran_d')
                                ->select('mstd_fobkp')
                                ->where('mstd_typetrn', '=', 'I')
                                ->where('mstd_nopo', '=', $rec->tsj_nodokumen)
                                ->where('mstd_prdcd', '=', $rec->tsj_prdcd)
                                ->where('mstd_kodeigr', '=', Session::get('kdigr'))
                                ->first();

                            if ($jum) {
                                $step = 18;

                                $fobkp = $jum->mstd_fobkp;

                                $stmastb = 0;

                                DB::connection(Session::get('connection'))->table('tbtr_mstran_d')
                                    ->where('mstd_typetrn', '=', 'I')
                                    ->where('mstd_nopo', '=', $rec->tsj_nodokumen)
                                    ->where('mstd_prdcd', '=', $rec->tsj_prdcd)
                                    ->where('mstd_kodeigr', '=', Session::get('kdigr'))
                                    ->update([
                                        'mstd_recordid' => $rec->tsj_recordid,
                                        'mstd_nodoc' => $ndoc,
                                        'mstd_tgldoc' => Carbon::now(),
                                        'mstd_nopo' => $rec->tsj_nodokumen,
                                        'mstd_tglpo' => $rec->tsj_tgldokumen,
                                        'mstd_nofaktur' => $rec->tsj_noreferensi1,
                                        'mstd_tglfaktur' => $rec->tsj_tglreferensi1,
                                        'mstd_docno2' => $rec->tsj_nodokumen2,
                                        'mstd_date2' => $rec->tsj_tgldokumen2,
                                        'mstd_istype' => $rec->tsj_hdrfakturpajak,
                                        'mstd_invno' => $rec->tsj_nofakturpajak,
                                        'mstd_date3' => $rec->tsj_date3,
                                        'mstd_nott' => $rec->tsj_nott,
                                        'mstd_tgltt' => $rec->tsj_date4,
                                        'mstd_kodesupplier' => $rec->tsj_lokasikirim,
                                        'mstd_pkp' => $rec->tsj_flagpkp,
                                        'mstd_cterm' => $rec->tsj_top,
                                        'mstd_seqno' => $rec->tsj_nourut,
                                        'mstd_prdcd' => $rec->tsj_prdcd,
                                        'mstd_kodedivisi' => $rec->tsj_kodedivisi,
                                        'mstd_kodedepartement' => $rec->tsj_kodedepartemen,
                                        'mstd_kodekategoribarang' => $rec->tsj_kodekategoribrg,
                                        'mstd_bkp' => $rec->tsj_flagbkp1,
                                        'mstd_fobkp' => $rec->tsj_flagbkp2,
                                        'mstd_unit' => $rec->tsj_unit,
                                        'mstd_frac' => $rec->tsj_fraction,
                                        'mstd_loc' => Session::get('kdigr'),
                                        'mstd_loc2' => $rec->tsj_lokasikirim,
                                        'mstd_qty' => $rec->tsj_qty * $rec->tsj_fraction + $rec->tsj_qtyk,
                                        'mstd_qtybonus1' => $rec->tsj_qbns1,
                                        'mstd_qtybonus2' => $rec->tsj_qbns2,
                                        'mstd_hrgsatuan' => $rec->tsj_price,
                                        'mstd_persendisc1' => $rec->tsj_persendisc1,
                                        'mstd_rphdisc1' => $rec->tsj_rupiahdisc1,
                                        'mstd_flagdisc1' => $rec->tsj_flagdisc1,
                                        'mstd_persendisc2' => $rec->tsj_persendisc2,
                                        'mstd_rphdisc2' => $rec->tsj_rupiahdisc2,
                                        'mstd_flagdisc2' => $rec->tsj_flagdisc2,
                                        'mstd_gross' => $rec->tsj_gross,
                                        'mstd_discrph' => $rec->tsj_discrp,
                                        'mstd_ppnrph' => $rec->tsj_ppn,
                                        'mstd_ppnbmrph' => $rec->tsj_ppnbrgmewah,
                                        'mstd_ppnbtlrph' => $rec->tsj_ppnbotol,
                                        'mstd_keterangan' => $rec->tsj_keterangan,
                                        'mstd_fk' => $rec->tsj_fk,
                                        'mstd_tglfp' => $rec->tsj_tglfp,
                                        'mstd_kodetag' => $rec->tsj_mtag,
                                        'mstd_ocost' => $ocost2 * $rec->tsj_fraction,
                                        'mstd_posqty' => $osqty2 + ($rec->tsj_qty * $rec->tsj_fraction + $rec->tsj_qtyk),
                                        'mstd_modify_by' => Session::get('usid'),
                                        'mstd_modify_dt' => Carbon::now()
                                    ]);
                            } else {
                                $step = 22;
                                $stmastb = 1;

                                DB::connection(Session::get('connection'))->table('tbtr_mstran_d')
                                    ->insert([
                                        'mstd_recordid' => $rec->tsj_recordid,
                                        'mstd_nodoc' => $ndoc,
                                        'mstd_typetrn' => 'I',
                                        'mstd_tgldoc' => Carbon::now(),
                                        'mstd_nopo' => $rec->tsj_nodokumen,
                                        'mstd_tglpo' => $rec->tsj_tgldokumen,
                                        'mstd_nofaktur' => $rec->tsj_noreferensi1,
                                        'mstd_tglfaktur' => $rec->tsj_tglreferensi1,
                                        'mstd_docno2' => $rec->tsj_nodokumen2,
                                        'mstd_date2' => $rec->tsj_tgldokumen2,
                                        'mstd_istype' => $rec->tsj_hdrfakturpajak,
                                        'mstd_invno' => $rec->tsj_nofakturpajak,
                                        'mstd_date3' => $rec->tsj_date3,
                                        'mstd_nott' => $rec->tsj_nott,
                                        'mstd_tgltt' => $rec->tsj_date4,
                                        'mstd_kodesupplier' => $rec->tsj_lokasikirim,
                                        'mstd_pkp' => $rec->tsj_flagpkp,
                                        'mstd_cterm' => $rec->tsj_top,
                                        'mstd_seqno' => $rec->tsj_nourut,
                                        'mstd_prdcd' => $rec->tsj_prdcd,
                                        'mstd_kodedivisi' => $rec->tsj_kodedivisi,
                                        'mstd_kodedepartement' => $rec->tsj_kodedepartemen,
                                        'mstd_kodekategoribrg' => $rec->tsj_kodekategoribrg,
                                        'mstd_bkp' => $rec->tsj_flagbkp1,
                                        'mstd_fobkp' => $rec->tsj_flagbkp2,
                                        'mstd_unit' => $rec->tsj_unit,
                                        'mstd_frac' => $rec->tsj_fraction,
                                        'mstd_loc' => Session::get('kdigr'),
                                        'mstd_loc2' => $rec->tsj_lokasikirim,
                                        'mstd_qty' => $rec->tsj_qty * $rec->tsj_fraction + $rec->tsj_qtyk,
                                        'mstd_qtybonus1' => $rec->tsj_qbns1,
                                        'mstd_qtybonus2' => $rec->tsj_qbns2,
                                        'mstd_hrgsatuan' => $rec->tsj_price,
                                        'mstd_persendisc1' => $rec->tsj_persendisc1,
                                        'mstd_rphdisc1' => $rec->tsj_rupiahdisc1,
                                        'mstd_flagdisc1' => $rec->tsj_flagdisc1,
                                        'mstd_persendisc2' => $rec->tsj_persendisc2,
                                        'mstd_rphdisc2' => $rec->tsj_rupiahdisc2,
                                        'mstd_flagdisc2' => $rec->tsj_flagdisc2,
                                        'mstd_gross' => $rec->tsj_gross,
                                        'mstd_discrph' => $rec->tsj_discrp,
                                        'mstd_ppnrph' => $rec->tsj_ppn,
                                        'mstd_ppnbmrph' => $rec->tsj_ppnbrgmewah,
                                        'mstd_ppnbtlrph' => $rec->tsj_ppnbotol,
                                        'mstd_keterangan' => $rec->tsj_keterangan,
                                        'mstd_fk' => $rec->tsj_fk,
                                        'mstd_tglfp' => $rec->tsj_tglfp,
                                        'mstd_kodetag' => $rec->tsj_mtag,
                                        'mstd_ocost' => $ocost2 * $rec->tsj_fraction,
                                        'mstd_posqty' => $osqty2 + ($rec->tsj_qty * $rec->tsj_fraction + $rec->tsj_qtyk),
                                        'mstd_create_by' => Session::get('usid'),
                                        'mstd_create_dt' => Carbon::now()
                                    ]);

                                $jum = DB::connection(Session::get('connection'))->table('tbtr_mstran_h')
                                    ->where('msth_kodeigr', '=', Session::get('kdigr'))
                                    ->where('msth_nodoc', '=', $rec->tsj_nodokumen)
                                    ->where('msth_typetrn', '=', 'I')
                                    ->first();

                                if (!$jum) {
                                    DB::connection(Session::get('connection'))->table('tbtr_mstran_h')
                                        ->insert([
                                            'msth_kodeigr' => Session::get('kdigr'),
                                            'msth_recordid' => $rec->tsj_recordid,
                                            'msth_typetrn' => 'I',
                                            'msth_nodoc' => $ndoc,
                                            'msth_tgldoc' => DB::connection(Session::get('connection'))->raw("TRUNC(SYSDATE)"),
                                            'msth_nopo' => $rec->tsj_nodokumen,
                                            'msth_tglpo' => $rec->tsj_tgldokumen,
                                            'msth_nofaktur' => $rec->tsj_noreferensi1,
                                            'msth_tglfaktur' => $rec->tsj_tglreferensi1,
                                            'msth_istype' => $rec->tsj_hdrfakturpajak,
                                            'msth_invno' => $rec->tsj_nofakturpajak,
                                            'msth_nott' => $rec->tsj_nott,
                                            'msth_tgltt' => $rec->tsj_date4,
                                            'msth_kodesupplier' => $rec->tsj_lokasikirim,
                                            'msth_pkp' => $rec->tsj_flagpkp,
                                            'msth_loc' => Session::get('kdigr'),
                                            'msth_loc2' => $rec->tsj_lokasikirim,
                                            'msth_keterangan_header' => $rec->tsj_keterangan,
                                            'msth_create_by' => Session::get('usid'),
                                            'msth_create_dt' => Carbon::now()
                                        ]);
                                }
                            }

                            $jum = DB::connection(Session::get('connection'))->table('temp_hstdok')
                                ->where('nodokumen', '=', $rec->tsj_nodokumen)
                                ->first();

                            if (!$jum) {
                                $step = 24;

                                DB::connection(Session::get('connection'))->table('temp_hstdok')
                                    ->insert([
                                        'dokref' => $rec->tsj_nodokumen,
                                        'tglref' => $rec->tsj_tgldokumen,
                                        'nodokumen' => $ndoc,
                                        'tgldokumen' => Carbon::now(),
                                        'lokasikirim' => $rec->tsj_lokasikirim
                                    ]);
                            }

                            if ($rec->tsj_lokasikirim) {
                                $jum = DB::connection(Session::get('connection'))->table('tbmaster_prodmast')
                                    ->select('prd_frac', 'prd_unit', 'prd_lastcost', 'prd_avgcost')
                                    ->where('prd_prdcd', '=', $rec->tsj_prdcd)
                                    ->where('prd_kodeigr', '=', Session::get('kdigr'))
                                    ->first();

                                if ($jum) {
                                    $step = 27;
                                    $nfrac = $jum->prd_frac;
                                    $cunit = $jum->prd_unit;
                                    $nlcost = $jum->prd_lastcost;
                                    $acost = $jum->prd_avgcost;

                                    if ($cunit == 'KG')
                                        $q = 1000;
                                    else $q = 1;

                                    $jum = DB::connection(Session::get('connection'))->table('tbmaster_prodmast')
                                        ->where('prd_prdcd', '=', $rec->tsj_prdcd)
                                        ->where('prd_kodeigr', '=', Session::get('kdigr'))
                                        ->where('prd_kodesupplier', '=', $rec->tsj_lokasikirim)
                                        ->first();

                                    if (!$jum) {
                                        $step = 30;

                                        DB::connection(Session::get('connection'))->table('tbmaster_spd')
                                            ->insert([
                                                'spd_kodeigr' => Session::get('kdigr'),
                                                'spd_prdcd' => $rec->tsj_prdcd,
                                                'spd_kodesupplier' => $rec->tsj_lokasikirim,
                                                'spd_nodocbtb1' => $rec->tsj_nodokumen,
                                                'spd_tglbtb1' => $rec->tsj_tgldokumen,
                                                'spd_nofaktur1' => $rec->tsj_noreferensi2,
                                                'spd_tglfaktur1' => $rec->tsj_tglreferensi2,
                                                'spd_top1' => $rec->tsj_top,
                                                'spd_qtybtb1' => $rec->tsj_qty * $rec->tsj_fraction + $rec->tsj_qtyk + $rec->tsj_qbns1 + $rec->tsj_qbns2,
                                                'spd_hrgbtb1' => ($rec->tsj_gross - $rec->tsj_discrp + $rec->tsj_ppnbrgmewah + $rec->tsj_ppnbotol) / (($rec->tsj_qty * $rec->tsj_fraction + $rec->tsj_qtyk) * $q),
                                                'spd_ttlhrg1' => $rec->tsj_gross - $rec->tsj_discrp + $rec->tsj_ppnbrgmewah + $rec->tsj_ppnbotol,
                                                'spd_create_by' => Session::get('usid'),
                                                'spd_create_dt' => Carbon::now()
                                            ]);
                                    } else {
                                        DB::connection(Session::get('connection'))->table('tbmaster_spd')
                                            ->where('prd_prdcd', '=', $rec->tsj_prdcd)
                                            ->where('prd_kodeigr', '=', Session::get('kdigr'))
                                            ->where('prd_kodesupplier', '=', $rec->tsj_lokasikirim)
                                            ->update([
                                                'spd_nodocbtb3' => $jum->spd_nodocbtb2,
                                                'spd_nodocbtb2' => $jum->spd_nodocbtb1,
                                                'spd_nodocbtb1' => $rec->tsj_nodokumen,
                                                'spd_tglbtb3' => $jum->spd_tglbtb2,
                                                'spd_tglbtb2' => $jum->spd_tglbtb1,
                                                'spd_tglbpb1' => $rec->tsj_tglreferensi2,
                                                'spd_top3' => $jum->spd_top2,
                                                'spd_top2' => $jum->spd_top1,
                                                'spd_top1' => $rec->tsj_top,
                                                'spd_qtybtb3' => $jum->spd_qtybtb2,
                                                'spd_qtybtb2' => $jum->spd_qtybtb1,
                                                'spd_qtybtb1' => $rec->tsj_qty * $rec->tsj_fraction + $rec->tsj_qtyk + $rec->tsj_qbns1 + $rec->tsj_qbns2,
                                                'spd_hrgbtb3' => $jum->spd_hrgbtb2,
                                                'spd_hrgbtb2' => $jum->spd_hrgbtb1,
                                                'spd_hrgbtb1' => ($rec->tsj_gross - $rec->tsj_discrp + $rec->tsj_ppnbrgmewah + $rec->tsj_ppnbotol) / (($rec->tsj_qty * $rec->tsj_fraction + $rec->tsj_qtyk) * $q),
                                                'spd_ttlhrg3' => $jum->spd_ttlhrg2,
                                                'spd_ttlhrg2' => $jum->spd_ttlhrg1,
                                                'spd_ttlhrg1' => $rec->tsj_gross - $rec->tsj_discrp + $rec->tsj_ppnbrgmewah + $rec->tsj_ppnbotol,
                                            ]);
                                    }
                                }
                            }

                            $step = 32;

                            if ($stmastb == 1) {
                                $jum = DB::connection(Session::get('connection'))->table('tbmaster_stock')
                                    ->whereRaw("substr(st_prdcd,1,6)||'0' = substr('" . $rec->tsj_prdcd . "',1,6)||'0'")
                                    ->where('st_lokasi', '=', '01')
                                    ->where('st_kodeigr', '=', Session::get('kdigr'))
                                    ->first();

                                if (!$jum) {
                                    DB::connection(Session::get('connection'))->table('tbmaster_stock')
                                        ->insert([
                                            'st_kodeigr' => Session::get('kdigr'),
                                            'st_prdcd' => substr($rec->tsj_prdcd, 0, 6) . '0',
                                            'st_lokasi' => '01',
                                            'st_trfin' => 0,
                                            'st_trfout' => 0,
                                            'st_saldoakhir' => 0,
                                            'st_lastcost' => 0,
                                            'st_avgcost' => 0,
                                            'st_avgcostmonthend' => 0,
                                            'st_tglavgcost' => DB::connection(Session::get('connection'))->raw("TRUNC(SYSDATE)"),
                                            'st_create_by' => Session::get('usid'),
                                            'st_create_dt' => Carbon::now()
                                        ]);

                                    $step = 35;

                                    $stqty = 0;
                                    $stacost = 0;
                                    $sttrfin = 0;
                                    $sttrfout = 0;
                                }

                                $ckcost = 1;
                                $step = 36;

                                $jum = DB::connection(Session::get('connection'))->table('tbmaster_prodmast')
                                    ->select('prd_frac', 'prd_unit', 'prd_lastcost', 'prd_avgcost')
                                    ->where('prd_prdcd', '=', $rec->tsj_prdcd)
                                    ->where('prd_kodeigr', '=', Session::get('kdigr'))
                                    ->first();

                                if ($jum) {
                                    $nfrac = $jum->prd_frac;
                                    $cunit = $jum->prd_unit;
                                    $nlcost = $jum->prd_lastcost;
                                    $acost = $jum->prd_avgcost;

                                    if ($nlcost == 0)
                                        $ckcost = 0;
                                }

                                $jum = DB::connection(Session::get('connection'))->table('tbtr_mstran_d')
                                    ->select('mstd_ocost', 'mstd_posqty')
                                    ->where('mstd_typetrn', '=', 'I')
                                    ->where('mstd_nopo', '=', $rec->tsj_nodokumen)
                                    ->where('mstd_prdcd', '=', $rec->tsj_prdcd)
                                    ->where('mstd_kodeigr', '=', Session::get('kdigr'))
                                    ->first();

                                if ($jum) {
                                    $ocost = $jum->mstd_ocost;
                                    $osqty = $jum->mstd_posqty;

                                    $step = 42;

                                    $stacost = DB::connection(Session::get('connection'))->table('tbmaster_stock')
                                        ->select('st_avgcost')
                                        ->where('st_prdcd', '=', substr($rec->tsj_prdcd, 0, 6) . '0')
                                        ->where('st_lokasi', '=', '01')
                                        ->where('st_kodeigr', '=', Session::get('kdigr'))
                                        ->first()->st_avgcost;

                                    $step = 43;

                                    if ($cunit == 'KG')
                                        $q = 1;
                                    else $q = $nfrac;

                                    DB::connection(Session::get('connection'))->table('tbtr_mstran_d')
                                        ->where('mstd_typetrn', '=', 'I')
                                        ->where('mstd_nopo', '=', $rec->tsj_nodokumen)
                                        ->where('mstd_prdcd', '=', $rec->tsj_prdcd)
                                        ->where('mstd_kodeigr', '=', Session::get('kdigr'))
                                        ->update([
                                            'mstd_ocost' => $stacost * $q,
                                            'mstd_posqty' => $stqty
                                        ]);

                                    $step = 44;

                                    if (substr($rec->tsj_prdcd, -1) == '1' || $cunit == 'KG') {
                                        $noldacost = $acost;
                                        $noldacostx = $stacost;
                                    } else {
                                        $noldacost = $acost / $nfrac;
                                        $noldacostx = $stacost;
                                    }

                                    if ($cunit == 'KG') {
                                        if ($stqty > 0) {
                                            $step = 46;

                                            $nacost = (($stqty * $noldacost) + ($rec->tsj_gross - $rec->tsj_discrp + $rec->tsj_ppnbrgmewah + $rec->tsj_ppnbotol)) / ($stqty + ($rec->tsj_qty * $rec->tsj_fraction + $rec->tsj_qtyk + $rec->tsj_qbns1));

                                            $nacostx = (($stqty * $noldacostx) + ($rec->tsj_gross - $rec->tsj_discrp + $rec->tsj_ppnbrgmewah + $rec->tsj_ppnbotol)) / ($stqty + ($rec->tsj_qty * $rec->tsj_fraction + $rec->tsj_qtyk + $rec->tsj_qbns1));
                                        } else {
                                            $step = 47;

                                            $nacost = ($rec->tsj_gross - $rec->tsj_discrp + $rec->tsj_ppnbrgmewah + $rec->tsj_ppnbotol) / ($rec->tsj_qty * $rec->tsj_fraction + $rec->tsj_qtyk + $rec->tsj_qbns1);

                                            $nacostx = $nacost;
                                        }

                                        $step = 48;

                                        if ($nacost <= 0) {
                                            $nacost = ($rec->tsj_gross - $rec->tsj_discrp + $rec->tsj_ppnbrgmewah + $rec->tsj_ppnbotol) / ($rec->tsj_qty * $rec->tsj_fraction + $rec->tsj_qtyk + $rec->tsj_qbns1);
                                        }

                                        $step = 49;

                                        if ($nacostx <= 0) {
                                            $nacostx = ($rec->tsj_gross - $rec->tsj_discrp + $rec->tsj_ppnbrgmewah + $rec->tsj_ppnbotol) / ($rec->tsj_qty * $rec->tsj_fraction + $rec->tsj_qtyk + $rec->tsj_qbns1);
                                        }

                                        $step = 50;

                                        $nlcosta = ($rec->tsj_gross - $rec->tsj_discrp + $rec->tsj_ppnbrgmewah + $rec->tsj_ppnbotol) / ($rec->tsj_qty * $rec->tsj_fraction + $rec->tsj_qtyk + $rec->tsj_qbns1);
                                    } else {
                                        if ($stqty > 0) {
                                            $step = 51;

                                            $nacost = (($stqty / 1000 * $noldacost) + ($rec->tsj_gross - $rec->tsj_discrp + $rec->tsj_ppnbrgmewah + $rec->tsj_ppnbotol)) / ($stqty + ($rec->tsj_qty * $rec->tsj_fraction + $rec->tsj_qtyk + $rec->tsj_qbns1)) * 1000;

                                            $nacostx = (($stqty / 1000 * $noldacostx) + ($rec->tsj_gross - $rec->tsj_discrp + $rec->tsj_ppnbrgmewah + $rec->tsj_ppnbotol)) / ($stqty + ($rec->tsj_qty * $rec->tsj_fraction + $rec->tsj_qtyk + $rec->tsj_qbns1)) * 1000;
                                        } else {
                                            $step = 52;

                                            $nacost = ($rec->tsj_gross - $rec->tsj_discrp + $rec->tsj_ppnbrgmewah + $rec->tsj_ppnbotol) / ($rec->tsj_qty * $rec->tsj_fraction + $rec->tsj_qtyk + $rec->tsj_qbns1) * 1000;

                                            $nacostx = ($rec->tsj_gross - $rec->tsj_discrp + $rec->tsj_ppnbrgmewah + $rec->tsj_ppnbotol) / ($rec->tsj_qty * $rec->tsj_fraction + $rec->tsj_qtyk + $rec->tsj_qbns1) * 1000;
                                        }

                                        if ($nacost <= 0) {
                                            $step = 54;

                                            $nacost = ($rec->tsj_gross - $rec->tsj_discrp + $rec->tsj_ppnbrgmewah + $rec->tsj_ppnbotol) / ($rec->tsj_qty * $rec->tsj_fraction + $rec->tsj_qtyk + $rec->tsj_qbns1) * 1000;
                                        }

                                        if ($nacostx <= 0) {
                                            $step = 55;

                                            $nacostx = ($rec->tsj_gross - $rec->tsj_discrp + $rec->tsj_ppnbrgmewah + $rec->tsj_ppnbotol) / ($rec->tsj_qty * $rec->tsj_fraction + $rec->tsj_qtyk + $rec->tsj_qbns1) * 1000;
                                        }

                                        $nlcosta = ($rec->tsj_gross - $rec->tsj_discrp + $rec->tsj_ppnbrgmewah + $rec->tsj_ppnbotol) / ($rec->tsj_qty * $rec->tsj_fraction + $rec->tsj_qtyk + $rec->tsj_qbns1) * 1000;
                                    }

                                    if ($nacost <= 0) {
                                        $step = 57;
                                        $nacost = $noldacost;
                                    }

                                    if ($nacostx <= 0) {
                                        $step = 58;
                                        $nacostx = $noldacostx;
                                    }

                                    DB::connection(Session::get('connection'))->update("UPDATE tbmaster_prodmast
                                   SET prd_avgcost =
                                          CASE
                                             WHEN SUBSTR (prd_prdcd, -1, 1) = '1' OR prd_unit = 'KG'
                                                THEN " . $nacostx . "
                                             ELSE " . $nacostx . "* prd_frac
                                          END,
                                       prd_lastcost =
                                          CASE
                                            WHEN NVL(prd_lastcost,0) = 0 THEN
                                                CASE
                                                    WHEN SUBSTR (prd_prdcd, -1, 1) = '1' OR prd_unit = 'KG'
                                                      THEN " . $nacostx . "
                                                    ELSE " . $nacostx . " * prd_frac
                                                END
                                            ELSE prd_lastcost
                                          END
                                    WHERE SUBSTR (prd_prdcd, 1, 6) = SUBSTR('" . $rec->tsj_prdcd . "', 1, 6)
                                    AND prd_KodeIGR = '" . Session::get('kdigr') . "'");

                                    $step = 62;

                                    if ($cunit == 'KG')
                                        $q = 1000;
                                    else $q = 1;

                                    DB::connection(Session::get('connection'))->table('tbtr_mstran_d')
                                        ->where('mstd_typetrn', '=', 'I')
                                        ->where('mstd_nopo', '=', $rec->tsj_nodokumen)
                                        ->where('mstd_prdcd', '=', $rec->tsj_prdcd)
                                        ->where('mstd_kodeigr', '=', Session::get('kdigr'))
                                        ->update([
                                            'mstd_avgcost' => $nacostx * $nfrac / $q
                                        ]);

                                    $step = 63;

                                    $old = DB::connection(Session::get('connection'))->table('tbmaster_stock')
                                        ->select('st_saldoakhir', 'st_trfin', 'st_lastcost')
                                        ->where('st_prdcd', '=', substr($rec->tsj_prdcd, 0, 6) . '0')
                                        ->where('st_lokasi', '=', '01')
                                        ->where('st_kodeigr', '=', Session::get('kdigr'))
                                        ->first();

                                    if ($old->st_lastcost == null || $old->st_lastcost == 0)
                                        $lc = $nacostx;
                                    else $lc = 0;

                                    DB::connection(Session::get('connection'))->table('tbmaster_stock')
                                        ->where('st_prdcd', '=', substr($rec->tsj_prdcd, 0, 6) . '0')
                                        ->where('st_lokasi', '=', '01')
                                        ->where('st_kodeigr', '=', Session::get('kdigr'))
                                        ->update([
                                            'st_avgcost' => $nacostx,
                                            'st_saldoakhir' => $old->st_saldoakhir + ($rec->tsj_qty * $rec->tsj_fraction + $rec->tsj_qtyk + $rec->tsj_qbns1),
                                            'st_trfin' => $old->st_trfin + ($rec->tsj_qty * $rec->tsj_fraction + $rec->tsj_qtyk + $rec->tsj_qbns1),
                                            'st_lastcost' => $lc,
                                            'st_modify_by' => Session::get('usid'),
                                            'st_modify_dt' => Carbon::now()
                                        ]);

                                    $step = 64;

                                    $jum = DB::connection(Session::get('connection'))->table('tbhistory_cost')
                                        ->where('hcs_prdcd', '=', $rec->tsj_prdcd)
                                        ->where('hcs_tglbpb', '=', $rec->tsj_tgldokumen)
                                        ->where('hcs_nodocbpb', '=', $rec->tsj_nodokumen)
                                        ->where('hcs_kodeigr', '=', Session::get('kdigr'))
                                        ->first();

                                    if (!$jum) {
                                        DB::connection(Session::get('connection'))->table('tbhistory_cost')
                                            ->insert([
                                                'hcs_kodeigr' => Session::get('kdigr'),
                                                'hcs_typetrn' => 'I',
                                                'hcs_prdcd' => $rec->tsj_prdcd,
                                                'hcs_tglbpb' => $rec->tsj_tgldokumen,
                                                'hcs_nodocbpb' => $rec->tsj_nodokumen,
                                                'hcs_qtybaru' => $rec->tsj_qty * $rec->tsj_fraction + $rec->tsj_qtyk + $rec->tsj_qbns1,
                                                'hcs_avglama' => $noldacostx * $nfrac / $q,
                                                'hcs_avgbaru' => $nacostx * $nfrac / $q,
                                                'hcs_lastcostbaru' => $noldacostx * $rec->tsj_fraction,
                                                'hcs_lastcostlama' => $noldacost,
                                                'hcs_qtylama' => $stqty,
                                                'hcs_lastqty' => $stqty + ($rec->tsj_qty * $rec->tsj_fraction + $rec->tsj_qtyk + $rec->tsj_qbns1),
                                                'hcs_create_by' => Session::get('usid'),
                                                'hcs_create_dt' => Carbon::now()
                                            ]);
                                    }
                                }
                            }

                            $step = 66;

                            DB::connection(Session::get('connection'))->table('tbtr_tolakansj')
                                ->where('tsj_prdcd', '=', $rec->tsj_prdcd)
                                ->where('tsj_nodokumen', '=', $rec->tsj_nodokumen)
                                ->where('tsj_kodeigr', '=', Session::get('kdigr'))
                                ->delete();
                        }
                    }
                }
            }

            DB::connection(Session::get('connection'))->commit();

            $status = 'success';
            return compact(['status', 'alert']);
        } catch (QueryException $e) {
            DB::connection(Session::get('connection'))->rollBack();
            return 'error';
        }
    }

    public function getDataTO()
    {
        DB::connection(Session::get('connection'))->table('temp_to')
            ->delete();

        $recs = DB::connection(Session::get('connection'))->table('tbtr_to')
            ->selectRaw("docno, trim(dateo) as dateo, count(1) as jum")
            ->where('loc2', '=', Session::get('kdigr'))
            ->groupBy(['docno', 'dateo'])
            ->orderBy('docno')
            ->get();

        foreach ($recs as $rec) {
            DB::connection(Session::get('connection'))->table('temp_to')
                ->insert([
                    'to_flag' => 0,
                    'to_nomr' => $rec->docno,
                    'to_tagl' => $rec->dateo,
                    'to_item' => $rec->jum
                ]);
        }

        $data = DB::connection(Session::get('connection'))->table('temp_to')
            ->selectRaw("to_nomr as docno, to_char(to_tagl,'dd/mm/yyyy') as tgl, to_item as jml")
            ->orderBy('to_nomr', 'asc')
            ->get();

        return $data;
    }

    public function uploadTO(Request $request)
    {
        try {
            DB::connection(Session::get('connection'))->beginTransaction();

            if (file_exists($request->file('file'))) {
                $filename = $request->file('file');

                if (substr($filename->getClientOriginalName(), 2, 2) != Session::get('kdigr')) {
                    return response()->json([
                        'message' => 'Kode IGR tidak sesuai!'
                    ], 500);
                }

                $zip = new ZipArchive;

                $list = [];

                if ($zip->open($filename) === TRUE) {
                    for ($i = 0; $i < $zip->numFiles; $i++) {
                        $entry = $zip->getNameIndex($i);
                        $list[] = $entry;
                    }

                    $zip->extractTo(storage_path('TRFSJ'));
                    $zip->close();
                } else {
                    return response()->json([
                        'message' => 'Mohon pastikan file zip berasal dari program Transfer SJ - IAS!'
                    ], 500);
                }

                $temp = File::files(storage_path('TRFSJ'));
                $files = [];

                foreach ($temp as $t) {
                    if (in_array($t->getFilename(), $list)) {
                        $files[] = $t;
                    }
                }

                //            File::delete($list);

                foreach ($list as $l) {
                    $nodoc[] = substr($l, 0, -4);
                }

                $result = [];

                DB::connection(Session::get('connection'))->table('tbtr_to')
                    ->whereIn('docno', $nodoc)
                    ->leftJoin('tbtr_titip', 'titip_nonota', '=', $nodoc)
                    ->delete();

                foreach ($files as $file) {
                    $header = NULL;
                    $data = array();
                    if (($handle = fopen($file, 'r')) !== FALSE) {
                        $dataFileDBF = new TableReader($file);
                        // dd($dataFileR->getRecordCount());

                        $insert = [];
                        $insert_titip = [];
                        while ($recs = $dataFileDBF->nextRecord()) {
                            // dd($recs->get('recid'));
                            if (!(str_contains(substr($file, strpos($file, "_") + 1), 'exp'))) {
                                $temp = [];

                                $temp['recid'] = $recs->get('recid');
                                $temp['rtype'] = $recs->get('rtype');
                                $temp['docno'] = $recs->get('docno');
                                $temp['dateo'] = $recs->get('dateo');
                                $temp['noref1'] = $recs->get('noref1');
                                $temp['tgref1'] = $recs->get('tgref1');
                                $temp['noref2'] = $recs->get('noref2');
                                $temp['tgref2'] = $recs->get('tgref2');
                                $temp['docno2'] = $recs->get('docno2');
                                $temp['date2'] = $recs->get('date2');
                                $temp['istype'] = $recs->get('istype');
                                $temp['invno'] = $recs->get('invno');
                                $temp['date3'] = $recs->get('date3');
                                $temp['nott'] = $recs->get('nott');
                                $temp['date4'] = $recs->get('date4');
                                $temp['supco'] = $recs->get('supco');
                                $temp['pkp'] = $recs->get('pkp');
                                $temp['cterm'] = $recs->get('cterm');
                                $temp['seqno'] = $recs->get('seqno');
                                $temp['prdcd'] = $recs->get('prdcd');
                                $temp['desc2'] = $recs->get('desc2');
                                $temp['div'] = $recs->get('div');
                                $temp['dept'] = $recs->get('dept');
                                $temp['katb'] = $recs->get('katb');
                                $temp['bkp'] = $recs->get('bkp');
                                $temp['fobkp'] = $recs->get('fobkp');
                                $temp['unit'] = $recs->get('unit');
                                $temp['frac'] = $recs->get('frac');
                                $temp['loc'] = $recs->get('loc');
                                $temp['loc2'] = $recs->get('loc2');
                                $temp['qty'] = $recs->get('qty');
                                $temp['qtyk'] = $recs->get('qtyk');
                                $temp['qbns1'] = $recs->get('qbns1');
                                $temp['qbns2'] = $recs->get('qbns2');
                                $temp['price'] = $recs->get('price');
                                $temp['discp1'] = $recs->get('discp1');
                                $temp['discr1'] = $recs->get('discr1');
                                $temp['fdisc1'] = $recs->get('fdisc1');
                                $temp['discp2'] = $recs->get('discp2');
                                $temp['discr2'] = $recs->get('discr2');
                                $temp['fdisc2'] = $recs->get('fdisc2');
                                $temp['gross'] = $recs->get('gross');
                                $temp['discrp'] = $recs->get('discrp');
                                $temp['ppnrp'] = $recs->get('ppnrp');
                                $temp['bmrp'] = $recs->get('bmrp');
                                $temp['btlrp'] = $recs->get('btlrp');
                                $temp['acost'] = $recs->get('acost');
                                $temp['keter'] = $recs->get('keter');
                                $temp['doc'] = $recs->get('doc');
                                $temp['doc2'] = $recs->get('doc2');
                                $temp['fk'] = $recs->get('fk');
                                $temp['tglfp'] = $recs->get('tglfp');
                                $temp['mtag'] = $recs->get('mtag');
                                $temp['gdg'] = $recs->get('gdg');
                                $temp['tglupd'] = $recs->get('tglupd');
                                $temp['jamupd'] = $recs->get('jamupd');
                                $temp['usero'] = $recs->get('usero');

                                $insert[] = $temp;
                                DB::connection(Session::get('connection'))->table('tbtr_to')
                                    ->insert($temp);
                            } else {
                                $temp_titip = [];

                                $temp_titip['titip_alamat'] = $recs->get('alamat');
                                $temp_titip['titip_container'] = $recs->get('cont');
                                $temp_titip['titip_created_by'] = $recs->get('crt_by');
                                $temp_titip['titip_create_dt'] = $recs->get('crt_dt');
                                $temp_titip['titip_durasi'] = $recs->get('durasi');
                                $temp_titip['titip_ekspedisi'] = $recs->get('eks');
                                $temp_titip['titip_frac'] = $recs->get('frac');
                                $temp_titip['titip_kapal'] = $recs->get('kapal');
                                $temp_titip['titip_keterangan_titipan'] = $recs->get('ket');
                                $temp_titip['titip_kode'] = $recs->get('kode');
                                $temp_titip['titip_kodecabangtitip'] = $recs->get('kode_cab');
                                $temp_titip['titip_kode_ekspedisi'] = $recs->get('kode_x');
                                $temp_titip['titip_koli'] = $recs->get('koli');
                                $temp_titip['titip_m3'] = $recs->get('m3');
                                $temp_titip['titip_modify_dt'] = $recs->get('mod_dt');
                                $temp_titip['titip_nama_barang'] = $recs->get('nama');
                                $temp_titip['titip_namacabangtitip'] = $recs->get('nama_cab');
                                $temp_titip['titip_nodoc'] = $recs->get('nodoc');
                                $temp_titip['titip_nomobil'] = $recs->get('nomobil');
                                $temp_titip['titip_nonota'] = $recs->get('nonota');
                                $temp_titip['titip_nosj'] = $recs->get('nosj');
                                $temp_titip['titip_qty'] = $recs->get('qty');
                                $temp_titip['titip_seal'] = $recs->get('seal');
                                $temp_titip['titip_tarif'] = $recs->get('tarif');
                                $temp_titip['titip_tgleta'] = $recs->get('tgleta');
                                $temp_titip['titip_tgletd'] = $recs->get('tgletd');
                                $temp_titip['titip_ton'] = $recs->get('ton');

                                $insert_titip[] = $temp_titip;

                                DB::connection(Session::get('connection'))->table('tbtr_titip')
                                    ->insert($temp_titip);
                            }
                        }
                        // dd($insert);


                        //                    while (($row = fgetcsv($handle, 1000, '|')) !== FALSE) {
                        //                        if (!$header) {
                        //                            $header = $row;
                        //                            for ($i = 0; $i < count($row); $i++) {
                        //                                $header[$i] = preg_replace("/[^\w\d]/", "", strtoupper($header[$i]));
                        //                            }
                        //                        } else {
                        //                            if (count($header) != count($row)) {
                        //                                $status = 'error';
                        //                                $title = 'File CSV yang diupload tidak sesuai format!';
                        //                                $data = null;
                        //                                return compact(['status', 'title', 'data']);
                        //                            } else {
                        //                                $data[] = array_combine($header, $row);
                        //                            }
                        //                        }
                        //                    }

                        fclose($handle);
                    }

                    if (count($insert) > 0) {
                        DB::connection(Session::get('connection'))->table('temp_to')
                            ->insert([
                                'to_flag' => 0,
                                'to_nomr' => $insert[0]['docno'],
                                'to_tagl' => Carbon::parse($insert[0]['dateo'])->format('Ymd'),
                                //                                DB::connection(Session::get('connection'))->raw("TO_DATE('".$insert[0]['dateo']."','yyyy-mm-dd ')"),
                                'to_item' => count($insert)
                            ]);
                    } else if (count($insert_titip) > 0) {
                        $check = DB::connection(Session::get('connection'))->table('tbtr_titip_barang')
                            ->where('tb_nodoc', $insert_titip[0]['titip_nodoc'])
                            ->first();

                        if (!$check) {
                            DB::connection(Session::get('connection'))->table('tbtr_titip_barang')
                                ->insert([
                                    'tb_nodoc' => $insert_titip[0]['titip_nodoc'],
                                    'tb_nonota' => $insert_titip[0]['titip_nonota'],
                                    'tb_kode' => $insert_titip[0]['titip_kode'],
                                    'tb_kode_ekspedisi' => $insert_titip[0]['titip_kode_ekspedisi'],
                                    'tb_nama_barang' => $insert_titip[0]['titip_nama_barang'],
                                    'tb_frac' => $insert_titip[0]['titip_frac'],
                                    'tb_qty' => $insert_titip[0]['titip_qty'],
                                    'tb_m3' => $insert_titip[0]['titip_m3'],
                                    'tb_ton' => $insert_titip[0]['titip_ton'],
                                    'tb_keterangan' => $insert_titip[0]['titip_keterangan_titipan'],
                                    'tb_nosj' => $insert_titip[0]['titip_nosj'],
                                    'tb_tgletd' => $insert_titip[0]['titip_tgletd'],
                                    'tb_tgleta' => $insert_titip[0]['titip_tgleta'],
                                    'tb_kode_cabang' => $insert_titip[0]['titip_kodecabangtitip'],
                                    'tb_cabang' => $insert_titip[0]['titip_namacabangtitip'],
                                    'tb_ekspedisi' => $insert_titip[0]['titip_ekspedisi'],
                                    'tb_seal' => $insert_titip[0]['titip_seal'],
                                    'tb_mobil' => $insert_titip[0]['titip_nomobil'],
                                    'tb_durasi' => $insert_titip[0]['titip_durasi'],
                                    'tb_tarif' => $insert_titip[0]['titip_tarif'],
                                    'tb_koli' => $insert_titip[0]['titip_koli'],
                                    'tb_alamat' => $insert_titip[0]['titip_alamat'],
                                    'tb_container' => $insert_titip[0]['titip_container'],
                                    'tb_kapal' => $insert_titip[0]['titip_kapal'],
                                    'tb_create_dt' => Carbon::parse($insert_titip[0]['titip_create_dt'])->format('Ymd'),
                                    'tb_modify_dt' => Carbon::parse($insert_titip[0]['titip_modify_dt'])->format('Ymd'),
                                    'tb_created_by' => $insert_titip[0]['titip_created_by']
                                ]);
                        }
                    }
                    //                $result[] = [
                    //                    'docno' => $data[0]['DOCNO'],
                    //                    'tgl' => date('d/m/Y',strtotime($data[0]['DATEO'])),
                    //                    'jml' => count($data)
                    //                ];
                }
                File::delete($files);

                DB::connection(Session::get('connection'))->commit();

                return response()->json([
                    'message' => 'Proses TO berhasil!'
                ], 200);
            }
        } catch (\Exception $e) {
            DB::connection(Session::get('connection'))->rollBack();

            $status = 'error';
            $alert = 'Terjadi kesalahan!';
            $message = $e->getMessage();

            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getDetailTO(Request $request)
    {
        $detail = DB::connection(Session::get('connection'))->table('tbtr_to')
            ->select('prdcd', 'desc2', 'qty', 'qtyk')
            ->where('docno', '=', $request->no)
            ->orderBy('prdcd', 'asc')
            ->get();

        return $detail;
    }

    public function prosesTO(Request $request)
    {
        $status = 'success';
        $alert = 'BERHASIL PROSES DATA!';

        try {
            DB::connection(Session::get('connection'))->beginTransaction();

            $jum = DB::connection(Session::get('connection'))->table('tbtr_to')
                ->where('loc2', '<>', Session::get('kdigr'))
                ->first();

            if ($jum) {
                DB::connection(Session::get('connection'))->table('tbtr_to')
                    ->whereRaw("NVL(loc2,' ') <> '" . Session::get('kdigr') . "'")
                    ->delete();

                $alert = 'KODE CABANG PENERIMA TO TIDAK SESUAI DENGAN CABANG ANDA!';
                $status = 'error';
            } else {
                $no = $request->no;

                $lastnodoc = null;

                $recs = DB::connection(Session::get('connection'))->table('tbtr_to')
                    ->whereIn('docno', $no)
                    ->get();

                $jammulai = DB::connection(Session::get('connection'))->raw("TO_CHAR(SYSDATE,'HH24:MI:SS')");

                DB::connection(Session::get('connection'))->table('tbtr_status')
                    ->insert([
                        'sts_kodeigr' => Session::get('kdigr'),
                        'sts_program' => 'IGR_BO_TRF_SJ',
                        'sts_user' => Session::get('usid'),
                        'sts_tanggal' => DB::connection(Session::get('connection'))->raw("TRUNC(SYSDATE)"),
                        'sts_jammulai' => $jammulai,
                        'sts_create_by' => Session::get('usid'),
                        'sts_create_dt' => DB::connection(Session::get('connection'))->raw("TRUNC(SYSDATE)")
                    ]);

                foreach ($recs as $rec) {
                    $step = 1;
                    $jum = 0;
                    $plu = $rec->prdcd;
                    $stmastc = '';

                    $jum = DB::connection(Session::get('connection'))->table('tbtr_history_bo')
                        ->where('hbo_dokref', '=', $rec->docno)
                        ->where('hbo_kodeigr', '=', Session::get('kdigr'))
                        ->whereRaw("substr(hbo_deskripsi,9,2) = '" . $rec->loc . "'")
                        ->first();

                    $step = 2;

                    if (!$jum) {
                        $step = 3;
                        $prosesx = 1;
                        $temp = 0;
                        //                        $jammulai = DB::connection(Session::get('connection'))->raw("TO_CHAR(SYSDATE,'HH24:MI:SS')");
                        //
                        //                        DB::connection(Session::get('connection'))->table('tbtr_status')
                        //                            ->insert([
                        //                                'sts_kodeigr' => Session::get('kdigr'),
                        //                                'sts_program' => 'IGR_BO_TRF_SJ',
                        //                                'sts_user' => Session::get('usid'),
                        //                                'sts_tanggal' => DB::connection(Session::get('connection'))->raw("TRUNC(SYSDATE)"),
                        //                                'sts_jammulai' => $jammulai,
                        //                                'sts_create_by' => Session::get('usid'),
                        //                                'sts_create_dt' => DB::connection(Session::get('connection'))->raw("TRUNC(SYSDATE)")
                        //                            ]);

                        $step = 4;

                        $temp = DB::connection(Session::get('connection'))->table('tbmaster_prodmast')
                            ->select('prd_recordid', 'prd_kategoritoko', 'prd_kodecabang')
                            ->where('prd_prdcd', '=', $rec->prdcd)
                            ->where('prd_kodeigr', '=', Session::get('kdigr'))
                            ->first();

                        $step = 5;

                        if (!$temp) {
                            $prosesx = 0;
                            $recid = null;
                            $kttk = null;
                            $kcab = null;
                        } else {
                            $recid = $temp->prd_recordid;
                            $kttk = $temp->prd_kategoritoko;
                            $kcab = $temp->prd_kodecabang;
                        }

                        $step = 6;

                        if ($recid == '1' || ($kttk == null && $kcab == null)) {
                            $prosesx = 0;
                        }

                        $step = 7;

                        if (true && $prosesx == 1) { //loop data di view
                            $step = 8;
                            $temp = 0;

                            $jum = DB::connection(Session::get('connection'))->table('tbmaster_stock')
                                ->select('st_saldoakhir', 'st_avgcost', 'st_lastcost')
                                ->where('st_kodeigr', '=', Session::get('kdigr'))
                                ->where('st_lokasi', '=', '01')
                                ->where('st_prdcd', '=', $rec->prdcd)
                                ->first();

                            if ($jum) {
                                $osqty = $jum->st_saldoakhir;
                                $ocost = $jum->st_avgcost;
                                $lcostlama = $jum->st_lastcost;
                            } else {
                                $osqty = 0;
                                $ocost = 0;
                                $lcostlama = 0;
                            }

                            $temp = DB::connection(Session::get('connection'))->table('tbtr_mstran_h')
                                ->where('msth_typetrn', '=', 'I')
                                ->where('msth_nopo', '=', $rec->docno)
                                ->where('msth_kodeigr', '=', Session::get('kdigr'))
                                ->whereRaw("nvl(msth_recordid,'0') <> '1'")
                                ->where('msth_loc2', '=', $rec->loc)
                                ->first();

                            $step = 9;

                            if ($temp) {
                                $mstddocno = DB::connection(Session::get('connection'))->table('tbtr_mstran_d')
                                    ->select('mstd_nodoc')
                                    ->where('mstd_nopo', '=', $rec->docno)
                                    ->where('mstd_kodeigr', '=', Session::get('kdigr'))
                                    ->where('mstd_loc2', '=', $rec->loc)
                                    ->whereRaw("nvl(mstd_recordid,'0') <> '1'")
                                    ->first()->mstd_nodoc;

                                $docnoa = $mstddocno;

                                $step = 10;
                            } else {
                                $step = 11;

                                $c = loginController::getConnectionProcedure();
                                $s = oci_parse($c, "BEGIN :ret := F_IGR_GET_NOMOR('" . Session::get('kdigr') . "','TSJ','Nomor Terima SJ','4' || TO_CHAR(SYSDATE, 'yy'),5,TRUE); END;");
                                oci_bind_by_name($s, ':ret', $docnoa, 32);
                                oci_execute($s);
                            }

                            // titip barang
                            DB::connection(Session::get('connection'))->table('tbtr_titip_barang')
                                ->where('tb_nonota', $rec->docno)
                                ->update(['tb_noproses' => $docnoa]);

                            $step = 12;

                            $jum = DB::connection(Session::get('connection'))->table('temp_file3')
                                ->where('docno', '=', $rec->docno)
                                ->first();

                            if (!$jum) {
                                DB::connection(Session::get('connection'))->table('temp_file3')
                                    ->insert([
                                        'docno' => $rec->docno,
                                        'dateo' => $rec->dateo,
                                        'nodoc' => $docnoa,
                                        'noref' => $rec->noref1,
                                        'tgref' => $rec->tgref1
                                    ]);
                            }

                            $step = 15;

                            $jum = DB::connection(Session::get('connection'))->table('tbtr_ipb')
                                ->where('ipb_noipb', '=', $rec->noref1)
                                ->where('ipb_tglipb', '=', DB::connection(Session::get('connection'))->raw("TO_DATE(TRIM('" . $rec->tgref1 . "'),'DD-MON-YY')"))
                                ->where('ipb_prdcd', '=', substr($rec->prdcd, 0, 6) . '0')
                                ->where('ipb_kodeigr', '=', Session::get('kdigr'))
                                ->first();

                            if ($jum) {
                                DB::connection(Session::get('connection'))->table('tbtr_ipb')
                                    ->where('ipb_noipb', '=', $rec->noref1)
                                    ->where('ipb_tglipb', '=', DB::connection(Session::get('connection'))->raw("TO_DATE(TRIM('" . $rec->tgref1 . "'),'DD-MON-YY')"))
                                    ->where('ipb_prdcd', '=', substr($rec->prdcd, 0, 6) . '0')
                                    ->where('ipb_kodeigr', '=', Session::get('kdigr'))
                                    ->update([
                                        'ipb_recordid' => '2',
                                        'ipb_qtyrealisasi' => $rec->qty * $rec->frac + $rec->qtyk
                                    ]);
                            }

                            $step = 17;

                            $jum = DB::connection(Session::get('connection'))->table('tbtr_mstran_d')
                                ->select('mstd_fobkp')
                                ->where('mstd_typetrn', '=', 'I')
                                ->where('mstd_nopo', '=', $docnoa)
                                ->where('mstd_loc2', '=', $rec->loc)
                                ->where('mstd_prdcd', '=', $rec->prdcd)
                                ->where('mstd_kodeigr', '=', Session::get('kdigr'))
                                ->whereRaw("NVL(mstd_recordid,'0') <> '1'")
                                ->first();

                            $step = 18;

                            $fobkp = '';
                            if ($jum) {
                                $fobkp = $jum->mstd_fobkp;

                                $step = 20;

                                DB::connection(Session::get('connection'))->table('tbtr_mstran_d')
                                    ->select('mstd_fobkp')
                                    ->where('mstd_typetrn', '=', 'I')
                                    ->where('mstd_nopo', '=', $rec->docno)
                                    ->where('mstd_loc2', '=', $rec->loc)
                                    ->where('mstd_prdcd', '=', $rec->prdcd)
                                    ->where('mstd_kodeigr', '=', Session::get('kdigr'))
                                    ->update([
                                        'mstd_recordid' => $rec->recid,
                                        'mstd_tgldoc' => DB::connection(Session::get('connection'))->raw("TRUNC(SYSDATE)"),
                                        'mstd_nopo' => $rec->docno,
                                        'mstd_tglpo' => DB::connection(Session::get('connection'))->raw("TO_DATE('" . $rec->dateo . "','YYYY-MM-DD HH24:MI:SS')"),
                                        'mstd_nofaktur' => $rec->noref1,
                                        'mstd_tglfaktur' => DB::connection(Session::get('connection'))->raw("TO_DATE('" . $rec->tgref1 . "','YYYY-MM-DD HH24:MI:SS')"),
                                        'mstd_docno2' => $rec->docno2,
                                        'mstd_date2' => DB::connection(Session::get('connection'))->raw("TO_DATE('" . $rec->date2 . "','YYYY-MM-DD HH24:MI:SS')"),
                                        'mstd_istype' => $rec->istype,
                                        'mstd_invno' => $rec->invno,
                                        'mstd_date3' => DB::connection(Session::get('connection'))->raw("TO_DATE('" . $rec->date3 . "','YYYY-MM-DD HH24:MI:SS')"),
                                        'mstd_nott' => $rec->nott,
                                        'mstd_tgltt' => DB::connection(Session::get('connection'))->raw("TO_DATE('" . $rec->date4 . "','YYYY-MM-DD HH24:MI:SS')"),
                                        'mstd_kodesupplier' => $rec->loc,
                                        'mstd_pkp' => $rec->pkp,
                                        'mstd_cterm' => null,
                                        'mstd_seqno' => $rec->seqno,
                                        'mstd_prdcd' => $rec->prdcd,
                                        'mstd_kodedivisi' => $rec->div,
                                        'mstd_kodedepartement' => $rec->dept,
                                        'mstd_kodekategoribrg' => $rec->katb,
                                        'mstd_bkp' => $rec->bkp,
                                        'mstd_fobkp' => $rec->fobkp,
                                        'mstd_unit' => $rec->unit,
                                        'mstd_frac' => $rec->frac,
                                        'mstd_loc' => Session::get('kdigr'),
                                        'mstd_loc2' => $rec->loc,
                                        'mstd_qty' => $rec->qty * $rec->frac + $rec->qtyk,
                                        'mstd_qtybonus1' => $rec->qbns1,
                                        'mstd_qtybonus2' => $rec->qbns2,
                                        'mstd_hrgsatuan' => $rec->price,
                                        'mstd_persendisc1' => $rec->discp1,
                                        'mstd_rphdisc1' => $rec->discr1,
                                        'mstd_flagdisc1' => $rec->fdisc1,
                                        'mstd_persendisc2' => $rec->discp2,
                                        'mstd_rphdisc2' => $rec->discr2,
                                        'mstd_flagdisc2' => $rec->fdisc2,
                                        'mstd_gross' => $rec->gross,
                                        'mstd_discrph' => $rec->discrp,
                                        'mstd_ppnrph' => $rec->ppnrp,
                                        'mstd_ppnbmrph' => $rec->bmrp,
                                        'mstd_ppnbtlrph' => $rec->btlrp,
                                        'mstd_keterangan' => $rec->keter,
                                        'mstd_fk' => $rec->fk,
                                        'mstd_tglfp' => DB::connection(Session::get('connection'))->raw("TO_DATE('" . $rec->tglfp . "','YYYY-MM-DD HH24:MI:SS')"),
                                        'mstd_kodetag' => $rec->mtag,
                                        'mstd_ocost' => $ocost * $rec->frac,
                                        'mstd_posqty' => $osqty + ($rec->qty * $rec->frac + $rec->qtyk),
                                        'mstd_modify_by' => Session::get('usid'),
                                        'mstd_modify_dt' => Carbon::now()
                                    ]);
                            } else {
                                $step = 23;
                                $stmastc = 1;

                                DB::connection(Session::get('connection'))->table('tbtr_mstran_d')
                                    ->insert([
                                        'mstd_kodeigr' => Session::get('kdigr'),
                                        'mstd_recordid' => $rec->recid,
                                        'mstd_typetrn' => 'I',
                                        'mstd_nodoc' => $docnoa,
                                        'mstd_tgldoc' => DB::connection(Session::get('connection'))->raw("TRUNC(SYSDATE)"),
                                        'mstd_nopo' => $rec->docno,
                                        'mstd_tglpo' => DB::connection(Session::get('connection'))->raw("TO_DATE('" . $rec->dateo . "','YYYY-MM-DD HH24:MI:SS')"),
                                        'mstd_nofaktur' => $rec->noref1,
                                        'mstd_tglfaktur' => DB::connection(Session::get('connection'))->raw("TO_DATE('" . $rec->tgref1 . "','YYYY-MM-DD HH24:MI:SS')"),
                                        'mstd_docno2' => $rec->docno2,
                                        'mstd_date2' => DB::connection(Session::get('connection'))->raw("TO_DATE('" . $rec->date2 . "','YYYY-MM-DD HH24:MI:SS')"),
                                        'mstd_istype' => $rec->istype,
                                        'mstd_invno' => $rec->invno,
                                        'mstd_date3' => DB::connection(Session::get('connection'))->raw("TO_DATE('" . $rec->date3 . "','YYYY-MM-DD HH24:MI:SS')"),
                                        'mstd_nott' => $rec->nott,
                                        'mstd_tgltt' => DB::connection(Session::get('connection'))->raw("TO_DATE('" . $rec->date4 . "','YYYY-MM-DD HH24:MI:SS')"),
                                        'mstd_kodesupplier' => $rec->loc,
                                        'mstd_pkp' => $rec->pkp,
                                        'mstd_cterm' => null,
                                        'mstd_seqno' => $rec->seqno,
                                        'mstd_prdcd' => $rec->prdcd,
                                        'mstd_kodedivisi' => $rec->div,
                                        'mstd_kodedepartement' => $rec->dept,
                                        'mstd_kodekategoribrg' => $rec->katb,
                                        'mstd_bkp' => $rec->bkp,
                                        'mstd_fobkp' => $rec->fobkp,
                                        'mstd_unit' => $rec->unit,
                                        'mstd_frac' => $rec->frac,
                                        'mstd_loc' => Session::get('kdigr'),
                                        'mstd_loc2' => $rec->loc,
                                        'mstd_qty' => $rec->qty * $rec->frac + $rec->qtyk,
                                        'mstd_qtybonus1' => $rec->qbns1,
                                        'mstd_qtybonus2' => $rec->qbns2,
                                        'mstd_hrgsatuan' => $rec->price,
                                        'mstd_persendisc1' => $rec->discp1,
                                        'mstd_rphdisc1' => $rec->discr1,
                                        'mstd_flagdisc1' => $rec->fdisc1,
                                        'mstd_persendisc2' => $rec->discp2,
                                        'mstd_rphdisc2' => $rec->discr2,
                                        'mstd_flagdisc2' => $rec->fdisc2,
                                        'mstd_gross' => $rec->gross,
                                        'mstd_discrph' => $rec->discrp,
                                        'mstd_ppnrph' => $rec->ppnrp,
                                        'mstd_ppnbmrph' => $rec->bmrp,
                                        'mstd_ppnbtlrph' => $rec->btlrp,
                                        'mstd_keterangan' => $rec->keter,
                                        'mstd_fk' => $rec->fk,
                                        'mstd_tglfp' => DB::connection(Session::get('connection'))->raw("TO_DATE('" . $rec->tglfp . "','YYYY-MM-DD HH24:MI:SS')"),
                                        'mstd_kodetag' => $rec->mtag,
                                        'mstd_ocost' => $ocost * $rec->frac,
                                        'mstd_posqty' => $osqty + ($rec->qty * $rec->frac + $rec->qtyk),
                                        'mstd_create_by' => Session::get('usid'),
                                        'mstd_create_dt' => Carbon::now()
                                    ]);

                                $step = 24;

                                $jum = DB::connection(Session::get('connection'))->table('tbtr_mstran_h')
                                    ->where('msth_kodeigr', '=', Session::get('kdigr'))
                                    ->where('msth_nodoc', '=', $docnoa)
                                    ->where('msth_typetrn', '=', 'I')
                                    ->first();

                                if (!$jum) {
                                    DB::connection(Session::get('connection'))->table('tbtr_mstran_h')
                                        ->insert([
                                            'msth_kodeigr' => Session::get('kdigr'),
                                            'msth_recordid' => $rec->recid,
                                            'msth_typetrn' => 'I',
                                            'msth_nodoc' => $docnoa,
                                            'msth_tgldoc' => DB::connection(Session::get('connection'))->raw("TRUNC(SYSDATE)"),
                                            'msth_nopo' => $rec->docno,
                                            'msth_tglpo' => DB::connection(Session::get('connection'))->raw("TO_DATE('" . $rec->dateo . "','YYYY-MM-DD HH24:MI:SS')"),
                                            'msth_nofaktur' => $rec->noref1,
                                            'msth_tglfaktur' => DB::connection(Session::get('connection'))->raw("TO_DATE('" . $rec->tgref1 . "','YYYY-MM-DD HH24:MI:SS')"),
                                            'msth_istype' => $rec->istype,
                                            'msth_invno' => $rec->invno,
                                            'msth_nott' => $rec->nott,
                                            'msth_tgltt' => DB::connection(Session::get('connection'))->raw("TO_DATE('" . $rec->date4 . "','YYYY-MM-DD HH24:MI:SS')"),
                                            'msth_kodesupplier' => $rec->loc,
                                            'msth_pkp' => $rec->pkp,
                                            'msth_loc' => Session::get('kdigr'),
                                            'msth_loc2' => $rec->loc,
                                            'msth_keterangan_header' => $rec->keter,
                                            'msth_create_by' => Session::get('usid'),
                                            'msth_create_dt' => Carbon::now()
                                        ]);
                                }
                            }

                            $step = 25;

                            $jum = DB::connection(Session::get('connection'))->table('temp_hstdok')
                                ->where('dokref', '=', $rec->docno)
                                ->get();

                            if (!$jum) {
                                $step = 26;

                                DB::connection(Session::get('connection'))->table('temp_hstdok')
                                    ->insert([
                                        'dokref' => $rec->docno,
                                        'tglref' => $rec->dateo,
                                        'nodokumen' => $docnoa,
                                        'lokasikirim' => $rec->loc
                                    ]);
                            }

                            $step = 27;

                            if ($rec->loc != null) {
                                $step = 28;

                                $jum = DB::connection(Session::get('connection'))->table('tbmaster_prodmast')
                                    ->select('prd_frac', 'prd_unit', 'prd_lastcost', 'prd_avgcost')
                                    ->where('prd_prdcd', '=', $rec->prdcd)
                                    ->where('prd_kodeigr', '=', Session::get('kdigr'))
                                    ->first();

                                if ($jum) {
                                    $step = 29;

                                    $nfrac = $jum->prd_frac;
                                    $cunit = $jum->prd_unit;
                                    $nlcost = $jum->prd_lastcost;
                                    $acost = $jum->prd_avgcost;

                                    $jum = DB::connection(Session::get('connection'))->table('tbmaster_spd')
                                        ->where('spd_prdcd', '=', $rec->prdcd)
                                        ->where('spd_kodesupplier', '=', $rec->loc)
                                        ->where('spd_kodeigr', '=', Session::get('kdigr'))
                                        ->first();

                                    if ($cunit == 'KG')
                                        $q = 1000;
                                    else $q = 1;

                                    if (!$jum) {
                                        $step = 31;

                                        DB::connection(Session::get('connection'))->table('tbmaster_spd')
                                            ->insert([
                                                'spd_kodeigr' => Session::get('kdigr'),
                                                'spd_prdcd' => $rec->prdcd,
                                                'spd_kodesupplier' => $rec->loc,
                                                'spd_nodocbtb1' => $rec->docno,
                                                'spd_tglbtb1' => $rec->dateo,
                                                'spd_nofaktur1' => $rec->noref2,
                                                'spd_tglfaktur1' => $rec->tgref2,
                                                'spd_top1' => null,
                                                'spd_qtybtb1' => $rec->qty * $rec->frac + $rec->qtyk + $rec->qbns1 + $rec->qbns2,
                                                'spd_hrgbtb1' => ($rec->gross - $rec->discrp + $rec->bmrp + $rec->btlrp) / ($rec->qty * $rec->frac + $rec->qtyk) * $q,
                                                'spd_ttlhrg1' => $rec->gross - $rec->discrp + $rec->bmrp + $rec->btlrp,
                                                'spd_create_by' => Session::get('usid'),
                                                'spd_create_dt' => Carbon::now()
                                            ]);
                                    } else {
                                        $step = 32;

                                        DB::connection(Session::get('connection'))->table('tbmaster_spd')
                                            ->where('spd_prdcd', '=', $rec->prdcd)
                                            ->where('spd_kodesupplier', '=', $rec->loc)
                                            ->where('spd_kodeigr', '=', Session::get('kdigr'))
                                            ->update([
                                                'spd_nodocbtb3' => $jum->spd_nodocbtb2,
                                                'spd_nodocbtb2' => $jum->spd_nodocbtb1,
                                                'spd_nodocbtb1' => $rec->docno,
                                                'spd_tglbtb3' => $jum->spd_tglbtb2,
                                                'spd_tglbtb2' => $jum->spd_tglbtb1,
                                                'spd_tglbtb1' => $rec->dateo,
                                                'spd_top3' => $jum->spd_top2,
                                                'spd_top2' => $jum->spd_top1,
                                                'spd_top1' => null,
                                                'spd_qtybtb3' => $jum->spd_qtybtb2,
                                                'spd_qtybtb2' => $jum->spd_qtybtb1,
                                                'spd_qtybtb1' => $rec->qty * $rec->frac + $rec->qtyk + $rec->qbns1 + $rec->qbns2,
                                                'spd_hrgbtb3' => $jum->spd_hrgbtb2,
                                                'spd_hrgbtb2' => $jum->spd_hrgbtb1,
                                                'spd_hrgbtb1' => ($rec->gross - $rec->discrp + $rec->bmrp + $rec->btlrp) / ($rec->qty * $rec->frac + $rec->qtyk) * $q,
                                                'spd_ttlhrg3' => $jum->spd_ttlhrg2,
                                                'spd_ttlhrg2' => $jum->spd_ttlhrg1,
                                                'spd_ttlhrg1' => $rec->gross - $rec->discrp + $rec->bmrp + $rec->btlrp,
                                                'spd_modify_by' => Session::get('usid'),
                                                'spd_modify_dt' => Carbon::now()
                                            ]);
                                    }
                                }
                            }

                            $step = 33;

                            if ($stmastc == 1) {
                                $step = 34;

                                $jum = DB::connection(Session::get('connection'))->table('tbmaster_stock')
                                    ->select('st_saldoakhir', 'st_avgcost', 'st_trfin', 'st_trfout')
                                    ->where('st_prdcd', '=', substr($rec->prdcd, 0, 6) . '0')
                                    ->where('st_lokasi', '=', '01')
                                    ->where('st_kodeigr', '=', Session::get('kdigr'))
                                    ->first();

                                if (!$jum) {
                                    $step = 35;

                                    DB::connection(Session::get('connection'))->table('tbmaster_stock')
                                        ->insert([
                                            'st_kodeigr' => Session::get('kdigr'),
                                            'st_prdcd' => substr($rec->prdcd, 0, 6) . '0',
                                            'st_lokasi' => '01',
                                            'st_trfin' => 0,
                                            'st_trfout' => 0,
                                            'st_saldoakhir' => 0,
                                            'st_lastcost' => 0,
                                            'st_avgcost' => 0,
                                            'st_avgcostmonthend' => 0,
                                            'st_tglavgcost' => DB::connection(Session::get('connection'))->raw("TRUNC(SYSDATE)"),
                                            'st_create_by' => Session::get('usid'),
                                            'st_create_dt' => Carbon::now()
                                        ]);

                                    $step = 36;

                                    $stqty = 0;
                                    $stacost = 0;
                                    $sttrfin = 0;
                                    $sttrfout = 0;
                                } else {
                                    $stqty = $jum->st_saldoakhir;
                                    $stacost = $jum->st_avgcost;
                                    $sttrfin = $jum->st_trfin;
                                    $sttrfout = $jum->st_trfout;
                                }

                                $ckcost = 1;
                                $step = 37;

                                $jum = DB::connection(Session::get('connection'))->table('tbmaster_prodmast')
                                    ->select('prd_frac', 'prd_unit', 'prd_lastcost', 'prd_avgcost')
                                    ->where('prd_prdcd', '=', $rec->prdcd)
                                    ->where('prd_kodeigr', '=', Session::get('kdigr'))
                                    ->first();

                                if ($jum) {
                                    $step = 38;

                                    $nfrac = $jum->prd_frac;
                                    $cunit = $jum->prd_unit;
                                    $nlcost = $jum->prd_lastcost;
                                    $acost = $jum->prd_avgcost;

                                    if ($nlcost == 0 || $nlcost == null)
                                        $ckcost = 0;
                                }

                                if (substr($rec->prdcd, -1) == '1' || $cunit == 'KG') {
                                    $noldacost = $acost;
                                    $noldacostx = $stacost;
                                } else {
                                    $noldacost = $acost / $nfrac;
                                    $noldacostx = $stacost;
                                }

                                $step = 39;

                                if ($cunit != 'KG') {
                                    if ($stqty > 0 && ($rec->qty * $rec->frac + $rec->qtyk + $rec->qbns1 + $rec->qbns2) > 0) {
                                        $step = 40;

                                        $nacost = (($stqty * $noldacost) + ($rec->gross - $rec->discrp + $rec->bmrp + $rec->btlrp)) / ($stqty + ($rec->qty * $rec->frac + $rec->qtyk + $rec->qbns1 + $rec->qbns2));

                                        $nacostx = (($stqty * $noldacostx) + ($rec->gross - $rec->discrp + $rec->bmrp + $rec->btlrp)) / ($stqty + ($rec->qty * $rec->frac + $rec->qtyk + $rec->qbns1 + $rec->qbns2));
                                    } else {
                                        $step = 41;

                                        $nacost = (($rec->gross - $rec->discrp + $rec->bmrp + $rec->btlrp)) / (($rec->qty * $rec->frac + $rec->qtyk + $rec->qbns1 + $rec->qbns2));

                                        $nacostx = (($rec->gross - $rec->discrp + $rec->bmrp + $rec->btlrp)) / (($rec->qty * $rec->frac + $rec->qtyk + $rec->qbns1 + $rec->qbns2));
                                    }

                                    if ($nacost <= 0) {
                                        $step = 41;

                                        $nacost = (($rec->gross - $rec->discrp + $rec->bmrp + $rec->btlrp)) / (($rec->qty * $rec->frac + $rec->qtyk + $rec->qbns1 + $rec->qbns2));
                                    }

                                    if ($nacostx <= 0) {
                                        $nacostx = (($rec->gross - $rec->discrp + $rec->bmrp + $rec->btlrp)) / (($rec->qty * $rec->frac + $rec->qtyk + $rec->qbns1 + $rec->qbns2));
                                    }

                                    $nlcosta = (($rec->gross - $rec->discrp + $rec->bmrp + $rec->btlrp)) / (($rec->qty * $rec->frac + $rec->qtyk + $rec->qbns1 + $rec->qbns2));
                                } else {
                                    if ($stqty > 0 && ($rec->qty * $rec->frac + $rec->qtyk + $rec->qbns1 + $rec->qbns2) > 0) {
                                        $step = 43;

                                        $nacost = (($stqty / 1000 * $noldacost) + ($rec->gross - $rec->discrp + $rec->bmrp + $rec->btlrp)) / ($stqty + ($rec->qty * $rec->frac + $rec->qtyk + $rec->qbns1 + $rec->qbns2)) * 1000;

                                        $nacostx = (($stqty / 1000 * $noldacostx) + ($rec->gross - $rec->discrp + $rec->bmrp + $rec->btlrp)) / ($stqty + ($rec->qty * $rec->frac + $rec->qtyk + $rec->qbns1 + $rec->qbns2)) * 1000;
                                    } else {
                                        $step = 44;

                                        $nacost = (($rec->gross - $rec->discrp + $rec->bmrp + $rec->btlrp)) / (($rec->qty * $rec->frac + $rec->qtyk + $rec->qbns1 + $rec->qbns2)) * 1000;

                                        $nacostx = (($rec->gross - $rec->discrp + $rec->bmrp + $rec->btlrp)) / (($rec->qty * $rec->frac + $rec->qtyk + $rec->qbns1 + $rec->qbns2)) * 1000;
                                    }

                                    if ($nacost <= 0) {
                                        $step = 45;

                                        $nacost = (($rec->gross - $rec->discrp + $rec->bmrp + $rec->btlrp)) / (($rec->qty * $rec->frac + $rec->qtyk + $rec->qbns1 + $rec->qbns2)) * 1000;
                                    }

                                    if ($nacostx <= 0) {
                                        $step = 46;

                                        $nacostx = (($rec->gross - $rec->discrp + $rec->bmrp + $rec->btlrp)) / (($rec->qty * $rec->frac + $rec->qtyk + $rec->qbns1 + $rec->qbns2)) * 1000;
                                    }

                                    $nlcosta = (($rec->gross - $rec->discrp + $rec->bmrp + $rec->btlrp)) / (($rec->qty * $rec->frac + $rec->qtyk + $rec->qbns1 + $rec->qbns2)) * 1000;
                                }

                                $step = 47;

                                if ($nacost <= 0 || $nacost == null) {
                                    $nacost = $noldacost;
                                }

                                $step = 48;

                                if ($nacostx <= 0 || $nacostx == null) {
                                    $nacostx = $noldacostx;
                                }

                                $jum = DB::connection(Session::get('connection'))->table('tbmaster_prodmast')
                                    ->whereRaw("substr(prd_prdcd,1,6) = '" . substr($rec->prdcd, 0, 6) . "'")
                                    ->where('prd_kodeigr', '=', Session::get('kdigr'))
                                    ->first();

                                if ($jum) {
                                    DB::connection(Session::get('connection'))->update("UPDATE tbmaster_prodmast
                                        SET prd_avgcost =
                                               CASE
                                                  WHEN SUBSTR (prd_prdcd, -1, 1) = '1'
                                                   OR TRIM (prd_unit) = 'KG'
                                               THEN " . $nacostx . "
                                                  ELSE " . $nacostx . " * TRIM (prd_frac)
                                               END,
                                            prd_lastcost =
                                               CASE
                                                  WHEN NVL (prd_lastcost, 0) = 0
                                                     THEN CASE
                                                            WHEN SUBSTR (prd_prdcd, -1, 1) = '1'
                                                             OR TRIM (prd_unit) = 'KG'
                                                         THEN " . $nacostx . "
                                                            ELSE " . $nacostx . " * TRIM (prd_frac)
                                                         END
                                               ELSE prd_lastcost
                                               END
                                      WHERE SUBSTR (prd_prdcd, 1, 6) =
                                                               SUBSTR ('" . $rec->prdcd . "', 1, 6)
                                        AND prd_kodeigr ='" . Session::get('kdigr') . "'");
                                }

                                $step = 52;

                                if ($cunit == 'KG')
                                    $q = 1000;
                                else $q = 1;

                                DB::connection(Session::get('connection'))->table('tbtr_mstran_d')
                                    ->where('mstd_typetrn', '=', 'I')
                                    ->where('mstd_nopo', '=', $rec->docno)
                                    ->where('mstd_loc2', '=', $rec->loc)
                                    ->where('mstd_prdcd', '=', $rec->prdcd)
                                    ->where('mstd_kodeigr', '=', Session::get('kdigr'))
                                    ->update([
                                        'mstd_avgcost' => $nacostx * $nfrac /  $q
                                    ]);

                                $step = 53;

                                DB::connection(Session::get('connection'))->update("UPDATE tbmaster_stock
                                         SET st_avgcost = " . $nacostx . ",
                                             st_saldoakhir =
                                                  st_saldoakhir
                                                + (  TRIM (" . $rec->qty . ") * TRIM (" . $rec->frac . ")
                                                   + TRIM (" . $rec->qtyk . ")
                                                   + TRIM (" . $rec->qbns1 . ")
                                                  ),
                                             st_trfin =
                                                  st_trfin
                                                + (  TRIM (" . $rec->qty . ") * TRIM (" . $rec->frac . ")
                                                   + TRIM (" . $rec->qtyk . ")
                                                   + TRIM (" . $rec->qbns1 . ")
                                                  ),
                                             st_lastcost =
                                                CASE
                                                   WHEN NVL (st_lastcost, 0) = 0
                                                      THEN " . $nacostx . "
                                                   ELSE st_lastcost
                                                END,
                                             st_modify_by = '" . Session::get('usid') . "',
                                             st_modify_dt = SYSDATE
                                       WHERE st_prdcd = SUBSTR ('" . $rec->prdcd . "', 1, 6) || '0'
                                         AND st_lokasi = '01'
                                         AND st_kodeigr = '" . Session::get('kdigr') . "'");

                                $step = 54;

                                $jum = DB::connection(Session::get('connection'))->table('tbhistory_cost')
                                    ->where('hcs_prdcd', '=', $rec->prdcd)
                                    ->where('hcs_tglbpb', '=', $rec->dateo)
                                    ->where('hcs_nodocbpb', '=', $rec->docno)
                                    ->where('hcs_kodeigr', '=', Session::get('kdigr'))
                                    ->first();

                                if (!$jum) {
                                    $step = 55;

                                    $jum = DB::connection(Session::get('connection'))->table('tbmaster_stock')
                                        ->select('st_lastcost')
                                        ->where('st_kodeigr', '=', Session::get('kdigr'))
                                        ->where('st_lokasi', '=', '01')
                                        ->where('st_prdcd', '=', $rec->prdcd)
                                        ->first();

                                    if ($jum) {
                                        $lcostbaru = $jum->st_lastcost;
                                    }

                                    DB::connection(Session::get('connection'))->table('tbhistory_cost')
                                        ->insert([
                                            'hcs_kodeigr' => Session::get('kdigr'),
                                            'hcs_typetrn' => 'I',
                                            'hcs_prdcd' => $rec->prdcd,
                                            'hcs_tglbpb' => $rec->dateo,
                                            'hcs_nodocbpb' => $rec->docno,
                                            'hcs_qtybaru' => $rec->qty * $rec->frac + $rec->qtyk + $rec->qbns1,
                                            'hcs_avglama' => $ocost * $nfrac / $q,
                                            'hcs_avgbaru' => $nacostx * $nfrac / $q,
                                            'hcs_lastcostbaru' => $lcostbaru * $rec->frac,
                                            'hcs_lastcostlama' => $lcostlama * $rec->frac,
                                            'hcs_qtylama' => $stqty,
                                            'hcs_lastqty' => $stqty + ($rec->qty * $rec->frac + $rec->qtyk + $rec->qbns1),
                                            'hcs_create_by' => Session::get('usid'),
                                            'hcs_create_dt' => Carbon::now()
                                        ]);
                                }

                                $step = 56;

                                $jum = DB::connection(Session::get('connection'))->table('tbmaster_barangbaru')
                                    ->where('pln_prdcd', '=', $rec->prdcd)
                                    ->where('pln_kodeigr', '=', Session::get('kdigr'))
                                    ->first();

                                if ($jum) {
                                    $step = 57;

                                    DB::connection(Session::get('connection'))->table('tbmaster_barangbaru')
                                        ->where('pln_prdcd', '=', $rec->prdcd)
                                        ->where('pln_kodeigr', '=', Session::get('kdigr'))
                                        ->update([
                                            'pln_tglbpb' => Carbon::now()
                                        ]);
                                }
                            }
                        } else if (true && $prosesx == 0) {
                            $step = 58;

                            $jum = DB::connection(Session::get('connection'))->table('tbmaster_prodmast')
                                ->select('prd_deskripsipendek', 'prd_recordid', 'prd_kategoritoko', 'prd_kodecabang')
                                ->where('prd_prdcd', '=', $rec->prdcd)
                                ->where('prd_kodeigr', '=', Session::get('kdigr'))
                                ->first();

                            $recid = null;
                            $kttk = null;
                            $kcab = null;

                            $step = 59;

                            if ($jum) {
                                $desk = $jum->prd_deskripsipendek;
                                $recid = $jum->prd_recordid;
                                $kttk = $jum->prd_kategoritoko;
                                $kcab = $jum->prd_kodecabang;
                            }

                            $ketv = $desk;
                            $step = 60;

                            if (!$jum)
                                $ketv = 'TIDAK TERDAFTAR DI MASTER CABANG';

                            if ($recid == '1')
                                $ketv = 'TIDAK TERDAFTAR DI MASTER BARANG';

                            $step = 62;

                            if ($kttk == null || $kcab == null) {
                                $ketv = 'TIDAK MEMPUNYAI KATEGORI TOKO DAN KODE CABANG';
                            }

                            $step = 63;

                            $jum = DB::connection(Session::get('connection'))->table('tbtr_tolakansj')
                                ->where('tsj_prdcd', '=', $rec->prdcd)
                                ->where('tsj_nodokumen', '=', $rec->docno)
                                ->first();

                            if (!$jum) {
                                $step = 64;

                                DB::connection(Session::get('connection'))->table('tbtr_tolakansj')
                                    ->insert([
                                        'tsj_kodeigr' => Session::get('kdigr'),
                                        'tsj_recordid' => $rec->recid,
                                        'tsj_recordtype' => $rec->rtype,
                                        'tsj_nodokumen' => $rec->docno,
                                        'tsj_tgldokumen' => $rec->dateo,
                                        'tsj_noreferensi1' => $rec->noref1,
                                        'tsj_tglreferensi1' => DB::connection(Session::get('connection'))->raw("TO_DATE('" . $rec->tgref1 . "','YYYY-MM-DD HH24:MI:SS"),
                                        'tsj_noreferensi2' => $rec->noref2,
                                        'tsj_tglreferensi2' => $rec->tgref2,
                                        'tsj_nodokumen2' => $rec->docno2,
                                        'tsj_tgldokumen2' => $rec->date2,
                                        'tsj_hdrfakturpajak' => $rec->istype,
                                        'tsj_nofakturpajak' => $rec->invno,
                                        'tsj_date3' => $rec->date3,
                                        'tsj_nott' => $rec->nott,
                                        'tsj_date4' => $rec->date4,
                                        'tsj_kodesupplier' => $rec->supco,
                                        'tsj_flagpkp' => $rec->pkp,
                                        'tsj_top' => null,
                                        'tsj_nourut' => $rec->seqno,
                                        'tsj_prdcd' => $rec->prdcd,
                                        'tsj_kodedivisi' => $rec->div,
                                        'tsj_kodedepartemen' => $rec->dept,
                                        'tsj_kodekategoribrg' => $rec->katb,
                                        'tsj_flagbkp1' => $rec->bkp,
                                        'tsj_flagbkp2' => $rec->fobkp,
                                        'tsj_unit' => $rec->unit,
                                        'tsj_fraction' => $rec->frac,
                                        'tsj_lokasikirim' => $rec->loc,
                                        'tsj_lokasiterima' => $rec->loc2,
                                        'tsj_qty' => $rec->qty,
                                        'tsj_qtyk' => $rec->qtyk,
                                        'tsj_qbns1' => $rec->qbns1,
                                        'tsj_qbns2' => $rec->qbns2,
                                        'tsj_price' => $rec->price,
                                        'tsj_persendisc1' => $rec->discp1,
                                        'tsj_rupiahdisc1' => $rec->discr1,
                                        'tsj_flagdisc1' => $rec->fdisc1,
                                        'tsj_persendisc2' => $rec->discp2,
                                        'tsj_rupiahdisc2' => $rec->discr2,
                                        'tsj_flagdisc2' => $rec->fdisc2,
                                        'tsj_gross' => $rec->gross,
                                        'tsj_discrp' => $rec->discrp,
                                        'tsj_ppn' => $rec->ppnrp,
                                        'tsj_ppnbrgmewah' => $rec->bmrp,
                                        'tsj_ppnbotol' => $rec->btlrp,
                                        'tsj_avgcost' => $rec->acost,
                                        'tsj_keterangan' => $rec->keter,
                                        'tsj_doc' => $rec->doc,
                                        'tsj_doc2' => $rec->doc2,
                                        'tsj_fk' => $rec->fk,
                                        'tsj_tglfp' => $rec->tglfp,
                                        'tsj_mtag' => $rec->mtag,
                                        'tsj_kodegudang' => $rec->gdg,
                                        'tsj_keteranganx' => $ketv,
                                        'tsj_create_by' => Session::get('usid'),
                                        'tsj_create_dt' => Carbon::now()
                                    ]);
                            }
                        }

                        DB::connection(Session::get('connection'))->table('tbtr_to')
                            ->where('loc2', '=', Session::get('kdigr'))
                            ->where('docno', '=', $rec->docno)
                            ->where('prdcd', '=', $rec->prdcd)
                            ->delete();
                    } else {
                        if ($lastnodoc == null) {
                            $lastnodoc = $rec->docno;
                            $alert = 'DATA DI TABEL TBTR_TO DENGAN NOMOR DOKUMEN ' . $rec->docno . ' SUDAH PERNAH DIPROSES!';
                        } else {
                            if ($lastnodoc != $rec->docno) {
                                $alert = 'DATA DI TABEL TBTR_TO DENGAN NOMOR DOKUMEN ' . $rec->docno . ' SUDAH PERNAH DIPROSES!';
                            }
                        }
                        $status = 'warning';

                        DB::connection(Session::get('connection'))->table('tbtr_to')
                            ->where('docno', '=', $rec->docno)
                            ->where('prdcd', '=', $rec->prdcd)
                            ->delete();

                        DB::connection(Session::get('connection'))->table('temp_to')
                            ->where('to_nomr', '=', $rec->docno)
                            ->delete();
                    }
                }

                $step = 67;

                DB::connection(Session::get('connection'))->table('tbtr_status')
                    ->where('sts_kodeigr', '=', Session::get('kdigr'))
                    ->where('sts_program', '=', 'IGR_BO_TRF_SJ')
                    ->where('sts_jammulai', '=', $jammulai)
                    ->update([
                        'sts_jamselesai' => DB::connection(Session::get('connection'))->raw("TO_CHAR(SYSDATE,'HH24:MI:SS')"),
                        'sts_modify_by' => Session::get('usid'),
                        'sts_modify_dt' => Carbon::now()
                    ]);

                $jum = DB::connection(Session::get('connection'))->table('tbtr_to')
                    ->where('loc2', '=', Session::get('kdigr'))
                    ->first();

                if ($jum) {
                    DB::connection(Session::get('connection'))->table('temp_to')
                        ->delete();

                    $recs = DB::connection(Session::get('connection'))->table('tbtr_to')
                        ->selectRaw("docno, trim(dateo) as dateo, count(1) as jum")
                        ->where('loc2', '=', Session::get('kdigr'))
                        ->groupBy(['docno', 'dateo'])
                        ->orderBy('docno')
                        ->get();

                    foreach ($recs as $rec) {
                        DB::connection(Session::get('connection'))->table('temp_to')
                            ->insert([
                                'to_flag' => 0,
                                'to_nomr' => $rec->docno,
                                'to_tagl' => $rec->dateo,
                                'to_item' => $rec->jum
                            ]);
                    }
                } else {
                    $jum = DB::connection(Session::get('connection'))->table('tbtr_to')
                        ->where('loc2', '<>', Session::get('kdigr'))
                        ->first();

                    if ($jum) {
                        DB::connection(Session::get('connection'))->table('tbtr_to')
                            ->whereRaw("NVL(loc2,' ') <> '" . Session::get('kdigr') . "'")
                            ->delete();

                        $alert = 'KODE CABANG PENERIMA TO TIDAK SESUAI DENGAN CABANG ANDA!';
                        $status = 'error';
                    }
                }
            }

            DB::connection(Session::get('connection'))->commit();
        } catch (QueryException $e) {
            DB::connection(Session::get('connection'))->rollBack();

            $alert = 'TERJADI KESALAHAN!';
            $status = 'error';
        }

        return compact(['status', 'alert']);
    }
}
