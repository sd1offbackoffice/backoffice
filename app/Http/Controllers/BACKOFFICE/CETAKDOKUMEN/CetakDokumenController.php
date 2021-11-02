<?php

namespace App\Http\Controllers\BACKOFFICE\CETAKDOKUMEN;

use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;
use PDF;
use Yajra\DataTables\DataTables;
use File;

class CetakDokumenController extends Controller
{
    public function index()
    {

        return view('BACKOFFICE.CETAKDOKUMEN.cetak-dokumen');
    }

    public function showData(Request $request)
    {
        $doc = $request->doc;
        $lap = $request->lap;
        $reprint = $request->reprint;
        $tgl1 = $request->tgl1;
        $tgl2 = $request->tgl2;
        if ($reprint == 'on') {
            $reprint = 1;
        } else {
            $reprint = 0;
        }
        $data = [];

        if ($doc == 'K') {
            if ($lap == 'L') {
                $recs = DB::select("SELECT trbo_nodoc,trbo_tgldoc
                           FROM TBTR_BACKOFFICE
                           WHERE(trbo_tgldoc BETWEEN to_date('" . $tgl1 . "','dd/mm/yyyy') and to_date('" . $tgl2 . "','dd/mm/yyyy')) and
                                        NVL(trbo_recordid, '0') <> '1' and
                                        trbo_typetrn = '" . $doc . "' and
                                        (NVL(trbo_flagdoc, ' ') = '" . $reprint . "' or NVL(trbo_flagdoc, ' ') = ' ')
                           GROUP BY trbo_nodoc,trbo_tgldoc
                           ORDER BY trbo_nodoc");
                if ($recs) {
                    foreach ($recs as $rec) {
                        $obj = (object)'';
                        $obj->nodoc = $rec->trbo_nodoc;
                        $obj->tgldoc = $rec->trbo_tgldoc;
                        array_push($data, $obj);
                    }
                }
            } else {
                if ($reprint == '0') {
                    $recs = DB::select("SELECT trbo_nodoc,trbo_tgldoc
                               FROM TBTR_BACKOFFICE
                               WHERE(trbo_tgldoc BETWEEN to_date('" . $tgl1 . "','dd/mm/yyyy') and to_date('" . $tgl2 . "','dd/mm/yyyy')) and
                                          trbo_typetrn = '" . $doc . "' and
                                          NVL(trbo_recordid, '0') <> '1' and
                                          NVL(trbo_flagdoc, ' ') <> '*'
                               GROUP BY trbo_nodoc,trbo_tgldoc
                               ORDER BY trbo_nodoc");
                    if ($recs) {
                        foreach ($recs as $rec) {
                            $obj = (object)'';
                            $obj->nodoc = $rec->trbo_nodoc;
                            $obj->tgldoc = $rec->trbo_tgldoc;
                            array_push($data, $obj);
                        }
                    }
                } else {
                    $recs = DB::select("SELECT MSTH_NODOC,MSTH_TGLDOC
                               FROM TBTR_MSTRAN_H
                               WHERE(MSTH_TGLDOC BETWEEN to_date('" . $tgl1 . "','dd/mm/yyyy') and to_date('" . $tgl2 . "','dd/mm/yyyy')) and
                                          MSTH_TYPETRN = '" . $doc . "' and
                                          NVL(MSTH_RECORDID, '0') <> '1' and
                                          NVL(MSTH_FLAGDOC, ' ') = '" . $reprint . "'
                               ORDER BY MSTH_NODOC");
                    if ($recs) {
                        foreach ($recs as $rec) {
                            $obj = (object)'';
                            $obj->nodoc = $rec->msth_nodoc;
                            $obj->tgldoc = $rec->msth_tgldoc;
                            array_push($data, $obj);
                        }
                    }
                }
            }
        } else {
            if ($lap == 'L') {
                $recs = DB::select("SELECT trbo_nodoc,trbo_tgldoc
			           FROM TBTR_BACKOFFICE
			           WHERE(trbo_tgldoc BETWEEN to_date('" . $tgl1 . "','dd/mm/yyyy') and to_date('" . $tgl2 . "','dd/mm/yyyy')) and
			           			  trbo_typetrn = '" . $doc . "' and
                                  NVL(trbo_recordid, '0') <> '1' and
                                  (NVL(trbo_flagdoc, ' ') = '" . $reprint . "' or NVL(trbo_flagdoc, ' ') = ' ')
			           GROUP BY trbo_nodoc,trbo_tgldoc
			           ORDER BY trbo_nodoc");
                if ($recs) {
                    foreach ($recs as $rec) {
                        $obj = (object)'';
                        $obj->nodoc = $rec->trbo_nodoc;
                        $obj->tgldoc = $rec->trbo_tgldoc;
                        array_push($data, $obj);
                    }
                }
            } else {
                if ($reprint == '0') {
                    $recs = DB::select("SELECT trbo_nodoc,trbo_tgldoc
                               FROM TBTR_BACKOFFICE
                               WHERE(trbo_tgldoc BETWEEN to_date('" . $tgl1 . "','dd/mm/yyyy') and to_date('" . $tgl2 . "','dd/mm/yyyy')) and
                                          trbo_typetrn = '" . $doc . "' and
                                          NVL(trbo_recordid, '0') <> '1' and
                                          NVL(trbo_flagdoc, ' ') <> '*'
                               GROUP BY trbo_nodoc,trbo_tgldoc
                               ORDER BY trbo_nodoc");
                    if ($recs) {
                        foreach ($recs as $rec) {
                            $obj = (object)'';
                            $obj->nodoc = $rec->trbo_nodoc;
                            $obj->tgldoc = $rec->trbo_tgldoc;
                            array_push($data, $obj);
                        }
                    }
                } else {
                    $recs = DB::select("SELECT MSTH_NODOC,MSTH_TGLDOC
                               FROM TBTR_MSTRAN_H
                               WHERE(MSTH_TGLDOC BETWEEN to_date('" . $tgl1 . "','dd/mm/yyyy') and to_date('" . $tgl2 . "','dd/mm/yyyy')) and
                                          MSTH_TYPETRN = '" . $doc . "' and
                                          NVL(MSTH_RECORDID, '0') <> '1' and
                                          NVL(MSTH_FLAGDOC, ' ') = '" . $reprint . "'
                               ORDER BY MSTH_NODOC");
                    if ($recs) {
                        foreach ($recs as $rec) {
                            $obj = (object)'';
                            $obj->nodoc = $rec->msth_nodoc;
                            $obj->tgldoc = $rec->msth_tgldoc;
                            array_push($data, $obj);
                        }
                    }
                }
            }
        }
        return Datatables::of($data)->addColumn('cekbox', '<input type="checkbox" class="cekbox" name="cekbox[]" value="{{ $nodoc }}' . "x" . '{{ substr($tgldoc,0,10) }}">')
            ->rawColumns(['cekbox'])
            ->make(true);
    }

    public function CSVeFaktur(Request $request)
    {
        $adaisi = false;
        $adadoc = false;
        $ldel = '';
        $lcrdir = '';
        $dirrootname = 's:\trf\efaktur';
        $dirname = 's:\trf\efaktur\rm';
        $fname = '';
        $linebuffs = [];
        $step = 0;
        $seq = 0;
        $v_file_counter = 0;
        $nodocbo = '';
        $tgldocbo = '';
        $recno = 0;
        $tgldoc = Carbon::now();
        $nofak = '';
        $temp = '';

        $doc = $request->doc;
        $lap = $request->lap;
        $reprint = $request->reprint;
        $tgl1 = $request->tgl1;
        $tgl2 = $request->tgl2;

        $data = $request->data;
        $nodocs = [];
        $tgldocs = [];
        foreach ($data as $d) {
            $splitData = explode('x', $d);
            array_push($nodocs, $splitData[0]);
            array_push($tgldocs, $splitData[1]);
        }

        if ($reprint == 'on') {
            $reprint = 1;
        } else {
            $reprint = 0;
        }

        if ($doc <> 'K' && $lap <> 'N') {
            $message = 'Button Create CSV Faktur hanya untuk Dokumen Keluaran yang sudah cetak List.';
            $status = 'info';
            return compact(['message', 'status']);
        }
        foreach ($nodocs as $nodoc) {
            if ($reprint == '0') {
                $temp = DB::select("SELECT COUNT(1) count
                       FROM TBTR_BACKOFFICE, TBMASTER_PRODMAST, tbmaster_supplier
                      WHERE     trbo_prdcd = PRD_PRDCD
                            and trbo_kodesupplier = sup_kodesupplier
                            and trbo_typetrn = 'K'
                            and trbo_nodoc = '" . $nodoc . "'
                            and PRD_FLAGBKP1 = 'Y'
                            and PRD_FLAGBKP2 = 'Y'
                            and sup_pkp = 'Y'")[0]->count;
            } else {
                $temp = DB::select("SELECT COUNT(1) count
                       FROM TBTR_MSTRAN_D, TBMASTER_PRODMAST, tbmaster_supplier
                      WHERE     MSTD_PRDCD = PRD_PRDCD
                            and mstd_kodesupplier = sup_kodesupplier
                            and MSTD_TYPETRN = 'K'
                            and MSTD_NODOC = '" . $nodoc . "'
                            and PRD_FLAGBKP1 = 'Y'
                            and PRD_FLAGBKP2 = 'Y'
                            and sup_pkp = 'Y'")[0]->count;
            }

            if (isset($nodoc) && $temp > 0) {
                $adadoc = true;
                break;
            }
        } //end foreach


        if ($adadoc == false) {
            $message = 'Tidak ada nomor Dokumen yang dipilih atau tidak ada PLU BKP atau tidak ada supplier PKP.';
            $status = 'info';
            return compact(['message', 'status']);
        }

        for ($i = 0; $i < sizeof($nodocs); $i++) {
            if ($reprint == '0') {


                $nodocbo = $nodocs[$i];
                $tgldocbo = $tgldocs[$i];


                $recs = DB::select("SELECT DISTINCT trbo_invno INVNO, trbo_nofaktur
                     FROM TBTR_BACKOFFICE, tbmaster_prodmast, tbmaster_supplier
                    WHERE     trbo_prdcd = prd_prdcd
                and trbo_kodesupplier = sup_kodesupplier
                and trbo_typetrn = 'K'
                and prd_flagbkp1 = 'Y'
                and sup_pkp = 'Y'
                and trbo_nofaktur IS NULL
                and trbo_nodoc = '" . $nodocs[$i] . "'");

                foreach ($recs as $rec) {

                    $temp = DB::select("SELECT COUNT(1) count
                         FROM TBTR_BACKOFFICE
                        WHERE     trbo_typetrn = 'K'
                            and trbo_nodoc = '" . $nodocs[$i] . "'
                            and trbo_invno = '" . $rec->invno . "'
                            and trbo_nofaktur is not null")[0]->count;

                    if ($temp > 0) {
                        $nofak = DB::select("SELECT distinct trbo_nofaktur
                                FROM TBTR_BACKOFFICE
                               WHERE     trbo_typetrn = 'K'
                               and trbo_nodoc = '" . $nodocs[$i] . "'
                               and trbo_invno = '" . $rec->invno . "'
                               and trbo_nofaktur is not null")[0]->count;
                    } else {
                        $connect = loginController::getConnectionProcedure();
                        $query = oci_parse($connect, "BEGIN :ret := f_igr_get_nomor('" . $_SESSION['kdigr'] . "','NRB','Nomor Retur Barang','Z',7,true); END;");
                        oci_bind_by_name($query, ':ret', $nofak, 32);
                        oci_execute($query);
                    }

                    DB::table('TBTR_BACKOFFICE')
                        ->where([
                            'trbo_kodeigr' => $_SESSION['kdigr'],
                            'trbo_typetrn' => 'K',
                            'trbo_nodoc' => $nodocs[$i],
                            'trbo_invno' => $rec->invno

                        ])
                        ->update([
                            'trbo_tglfaktur' => DB::raw("trunc(sysdate)"),
                            'trbo_nofaktur' => $nofak
                        ]);
                }
            } else {

                $tgldocbo = DB::select("SELECT DISTINCT MSTH_TGLDOC MSTH_TGLDOC
                              FROM TBTR_MSTRAN_H
                             WHERE MSTH_NODOC = '" . $nodocs[$i] . "' and ROWNUM = 1")[0]->msth_tgldoc;
            }


            if ($tgldocbo <> $tgldocs[$i]) {

                $FNAME =
                    'RM'
                    . $_SESSION['kdigr']
                    . ' . CSV';

//            -- HEADER'
                $columnHeader = [
                    'PLU',
                    'Qty Min Disp',
                    'Qty Min Ord',
                    'Avg Sales 3 bulan',
                    'Bulan 1',
                    'Sales (qty)',
                    'Hari',
                    'Bulan 2',
                    'Sales (qty)',
                    'Hari',
                    'Bulan 3',
                    'Sales (qty)',
                    'Hari',
                    'PKM',
                    'Kode Supplier',
                    'N',
                    'Periode proses',
                    'Tgl edit PKM',
                    'Sebelum Proses PKM',
                    'Usulan (by program)',
                    'Adjust (by user)'
                ];
                $columnHeader = ['RM', 'NPWP', 'NAMA', 'KD_JENIS_TRANSAKSI', 'FG_PENGGANTI', 'NOMOR_FAKTUR', 'TANGGAL_FAKTUR', 'IS_CREDITABLE', 'NOMOR_DOKUMEN_RETUR', 'TANGGAL_RETUR', 'MASA_PAJAK_RETUR', 'TAHUN_PAJAK_RETUR', 'NILAI_RETUR_DPP', 'NILAI_RETUR_PPN', 'NILAI_RETUR_PPNBM'];
                $tgldoc = $tgldocbo;
            }


            if ($reprint == '0') {
                $rmbo_recs = Self::RMBO_CUR($nodoc);

                foreach ($rmbo_recs as $rmbo_rec) {
                    $adaisi = true;
                    $recno = $recno + 1;
                    $data = [
                        $rmbo_rec->rm,
                        $rmbo_rec->npwp,
                        $rmbo_rec->nama,
                        $rmbo_rec->kd_jenis_transaksi,
                        $rmbo_rec->fg_pengganti,
                        $rmbo_rec->nomor_faktur,
                        $rmbo_rec->tanggal_faktur,
                        $rmbo_rec->is_creditable,
                        $rmbo_rec->nomor_dokumen_retur,
                        $rmbo_rec->tanggal_retur,
                        $rmbo_rec->masa_pajak_retur,
                        $rmbo_rec->tahun_pajak_retur,
                        $rmbo_rec->nilai_retur_dpp,
                        $rmbo_rec->nilai_retur_ppn,
                        $rmbo_rec->nilai_retur_ppnbm
                    ];
                    array_push($linebuffs, $data);
                }

            } else {
                $rmtr_recs = Self::RMTR_CUR($nodoc);

                foreach ($rmtr_recs as $rmtr_rec) {
                    $adaisi = true;
                    $recno = $recno + 1;
                    $data = [
                        $rmtr_rec->rm,
                        $rmtr_rec->npwp,
                        $rmtr_rec->nama,
                        $rmtr_rec->kd_jenis_transaksi,
                        $rmtr_rec->fg_pengganti,
                        $rmtr_rec->nomor_faktur,
                        $rmtr_rec->tanggal_faktur,
                        $rmtr_rec->is_creditable,
                        $rmtr_rec->nomor_dokumen_retur,
                        $rmtr_rec->tanggal_retur,
                        $rmtr_rec->masa_pajak_retur,
                        $rmtr_rec->tahun_pajak_retur,
                        $rmtr_rec->nilai_retur_dpp,
                        $rmtr_rec->nilai_retur_ppn,
                        $rmtr_rec->nilai_retur_ppnbm
                    ];
                    array_push($linebuffs, $data);
                }
            }

            $temp = DB::select("SELECT COUNT(1) count
                   FROM TBTR_BACKOFFICE, TBMASTER_SUPPLIER
                  WHERE     trbo_kodeigr = '" . $_SESSION['kdigr'] . "'
                    and trbo_kodeigr = SUP_KODEIGR
                    and trbo_kodesupplier = SUP_KODESUPPLIER
                    and SUP_PKP = 'Y'
                    and trbo_nodoc = '" . $nodocbo . "'")[0]->count;

            if ($reprint == '0' && $temp > 0) {

                DB::table('TBHISTORY_FAKTURRM')->where('FRM_KODEIGR', '=', $_SESSION['kdigr'])->where('frm_nodocbo', '=', $nodocbo)->delete();

                $dataInsert = DB::selectOne("SELECT trbo_kodeigr,trbo_nodoc,trbo_tgldoc,
                      trbo_istype || '.' || trbo_invno referensifp
                 FROM TBTR_BACKOFFICE, TBMASTER_SUPPLIER
                WHERE     trbo_kodeigr = '" . $_SESSION['kdigr'] . "'
                and trbo_kodeigr = SUP_KODEIGR
                and trbo_kodesupplier = SUP_KODESUPPLIER
                and SUP_PKP = 'Y'
                and trbo_nodoc = '" . $nodocbo . "'");

                DB::table('TBHISTORY_FAKTURRM')
                    ->where('FRM_KODEIGR', '=', $_SESSION['kdigr'])
                    ->where('frm_nodocbo', '=', $nodocbo)
                    ->delete();

                DB::table('tbhistory_fakturrm')
                    ->insert([
                        'frm_nodocbo' => $dataInsert->trbo_kodeigr,
                        'frm_nodocbo' => $dataInsert->trbo_nodoc,
                        'frm_tglbo' => $dataInsert->trbo_tgldoc,
                        'frm_referensifp' => $dataInsert->referensifp,
                        'frm_create_by' => $_SESSION['usid'],
                        'frm_create_dt' => DB::RAW("SYSDATE")
                    ]);

//                DB::insert(" INSERT INTO TBHISTORY_FAKTURRM(FRM_KODEIGR,
//                                            FRM_NODOCBO,
//                                            FRM_TGLBO,
//                                            FRM_REFERENSIFP,
//                                            FRM_CREATE_BY,
//                                            FRM_CREATE_DT) values(
//                    )");
            }

        }

        $filename = 'RM.' . $_SESSION['kdigr'] . '.csv';

        $columnHeader = ['RM', 'NPWP', 'NAMA', 'KD_JENIS_TRANSAKSI', 'FG_PENGGANTI', 'NOMOR_FAKTUR', 'TANGGAL_FAKTUR', 'IS_CREDITABLE', 'NOMOR_DOKUMEN_RETUR', 'TANGGAL_RETUR', 'MASA_PAJAK_RETUR', 'TAHUN_PAJAK_RETUR', 'NILAI_RETUR_DPP', 'NILAI_RETUR_PPN', 'NILAI_RETUR_PPNBM'];

        $headers = [
            "Content-type" => "text/csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];
        $file = fopen($filename, 'w');

        fputcsv($file, $columnHeader, '|');
        foreach ($linebuffs as $linebuff) {
            fputcsv($file, $linebuff, '|');
        }
        fclose($file);
        return $filename;

    }

    public function RMBO_CUR(string $nodocbo)
    {
        $result = DB::select("SELECT RM,
               NPWP,
               NAMA,
               KD_JENIS_TRANSAKSI,
               FG_PENGGANTI,
               NOMOR_FAKTUR,
               TANGGAL_FAKTUR,
               IS_CREDITABLE,
               NOMOR_DOKUMEN_RETUR,
               TANGGAL_RETUR,
               MASA_PAJAK_RETUR,
               TAHUN_PAJAK_RETUR,
               FLOOR(SUM(NILAI_RETUR_DPP)) NILAI_RETUR_DPP,
               FLOOR(SUM(NILAI_RETUR_PPN)) NILAI_RETUR_PPN,
               FLOOR(SUM(NILAI_RETUR_PPNBM)) NILAI_RETUR_PPNBM
          FROM(SELECT 'RM' RM,
                       REPLACE(REPLACE(SUP_NPWP, '.', ''), '-', '') NPWP,
                       SUP_NAMASUPPLIER NAMA,
                       SUBSTR(trbo_istype, 1, 2) KD_JENIS_TRANSAKSI,
                       SUBSTR(trbo_istype, 3, 1) FG_PENGGANTI,
                       REPLACE(SUBSTR(trbo_istype || trbo_invno, 5), '-', '')
                          NOMOR_FAKTUR,
                       TO_CHAR(trbo_tglinv, 'dd/MM/yyyy') TANGGAL_FAKTUR,
                       '1' IS_CREDITABLE,
                          PRS_KODEMTO
                          || '.'
                          || TO_CHAR(trbo_tglfaktur, 'YY')
                          || '.0'
                          || SUBSTR(trbo_nofaktur, 2, 7)
                          NOMOR_DOKUMEN_RETUR,
                       TO_CHAR(trbo_tglfaktur, 'dd/MM/yyyy') TANGGAL_RETUR,
                       TO_NUMBER(TO_CHAR(trbo_tglfaktur, 'MM'))
                          MASA_PAJAK_RETUR,
                       TO_NUMBER(TO_CHAR(trbo_tglfaktur, 'yyyy'))
                          TAHUN_PAJAK_RETUR,
                       (trbo_gross - (bpb_discrph * trbo_qty)) NILAI_RETUR_DPP,
                       (trbo_gross - (bpb_discrph * trbo_qty)) * 0.1
                          NILAI_RETUR_PPN,
                       0 NILAI_RETUR_PPNBM
                  FROM TBTR_BACKOFFICE,
                       TBMASTER_SUPPLIER,
                       TBMASTER_CONST,
                       TBMASTER_PERUSAHAAN,
                       TBMASTER_PRODMAST,
                       (SELECT mstd_nodoc bpb_nodoc,
                               mstd_prdcd bpb_prdcd,
                               mstd_discrph / mstd_qty bpb_discrph
                          FROM tbtr_mstran_d
                         WHERE mstd_typetrn = 'B')
                 WHERE     trbo_kodeigr = '" . $_SESSION['kdigr'] . "'
                and trbo_kodeigr = PRS_KODEIGR
                and trbo_kodeigr = PRD_KODEIGR
                and trbo_prdcd = PRD_PRDCD
                and NVL(PRD_FLAGBKP1, 'N') = 'Y'
                and NVL(PRD_FLAGBKP2, 'N') = 'Y'
                and trbo_kodeigr = SUP_KODEIGR
                and trbo_kodesupplier = SUP_KODESUPPLIER
                and SUP_PKP = 'Y'
                and trbo_kodeigr = CONST_KODEIGR(+)
                and SUBSTR(CONST_BRANCH(+), 1, 1) = 'O'
                and trbo_noreff = bpb_nodoc
                and trbo_prdcd = bpb_prdcd
                and trbo_nodoc = '" . $nodocbo . "')
      GROUP BY RM,
               NPWP,
               NAMA,
               KD_JENIS_TRANSAKSI,
               FG_PENGGANTI,
               NOMOR_FAKTUR,
               TANGGAL_FAKTUR,
               IS_CREDITABLE,
               NOMOR_DOKUMEN_RETUR,
               TANGGAL_RETUR,
               MASA_PAJAK_RETUR,
               TAHUN_PAJAK_RETUR");
        return $result;
    }

    public function RMTR_CUR(string $nodoctr)
    {
        $result = DB::select("SELECT RM,
               NPWP,
               NAMA,
               KD_JENIS_TRANSAKSI,
               FG_PENGGANTI,
               NOMOR_FAKTUR,
               TANGGAL_FAKTUR,
               IS_CREDITABLE,
               NOMOR_DOKUMEN_RETUR,
               TANGGAL_RETUR,
               MASA_PAJAK_RETUR,
               TAHUN_PAJAK_RETUR,
               FLOOR(SUM(NILAI_RETUR_DPP)) NILAI_RETUR_DPP,
               FLOOR(SUM(NILAI_RETUR_PPN)) NILAI_RETUR_PPN,
               FLOOR(SUM(NILAI_RETUR_PPNBM)) NILAI_RETUR_PPNBM
          FROM(SELECT 'RM' RM,
                       REPLACE(REPLACE(SUP_NPWP, '.', ''), '-', '') NPWP,
                       SUP_NAMASUPPLIER NAMA,
                       SUBSTR(MSTD_ISTYPE, 1, 2) KD_JENIS_TRANSAKSI,
                       SUBSTR(MSTD_ISTYPE, 3, 1) FG_PENGGANTI,
                       REPLACE(SUBSTR(MSTD_ISTYPE || MSTD_INVNO, 5), '-', '')
                          NOMOR_FAKTUR,
                       TO_CHAR(MSTD_DATE3, 'dd/MM/yyyy') TANGGAL_FAKTUR,
                       '1' IS_CREDITABLE,
                          PRS_KODEMTO
                          || '.'
                          || TO_CHAR(MSTD_DATE2, 'YY')
                          || '.0'
                          || MSTD_DOCNO2
                          NOMOR_DOKUMEN_RETUR,
                       TO_CHAR(MSTD_DATE2, 'dd/MM/yyyy') TANGGAL_RETUR,
                       TO_NUMBER(TO_CHAR(MSTD_DATE2, 'MM')) MASA_PAJAK_RETUR,
                       TO_NUMBER(TO_CHAR(MSTD_DATE2, 'yyyy'))
                          TAHUN_PAJAK_RETUR,
                       (mstd_GROSS - (bpb_discrph * mstd_qty)) NILAI_RETUR_DPP,
                       (MSTD_GROSS - (bpb_discrph * mstd_qty)) * 0.1
                          NILAI_RETUR_PPN,
                       0 NILAI_RETUR_PPNBM
                  FROM TBTR_MSTRAN_D,
                       TBMASTER_SUPPLIER,
                       TBMASTER_CONST,
                       TBMASTER_PERUSAHAAN,
                       TBMASTER_PRODMAST,
                       (SELECT mstd_nodoc bpb_nodoc,
                               mstd_prdcd bpb_prdcd,
                               mstd_discrph / mstd_qty bpb_discrph
                          FROM tbtr_mstran_d
                         WHERE mstd_typetrn = 'B')
                 WHERE     MSTD_KODEIGR = '" . $_SESSION['kdigr'] . "'
                and MSTD_KODEIGR = PRS_KODEIGR
                and MSTD_KODEIGR = PRD_KODEIGR
                and MSTD_PRDCD = PRD_PRDCD
                and NVL(PRD_FLAGBKP1, 'N') = 'Y'
                and NVL(PRD_FLAGBKP2, 'N') = 'Y'
                and MSTD_KODEIGR = SUP_KODEIGR
                and MSTD_KODESUPPLIER = SUP_KODESUPPLIER
                and SUP_PKP = 'Y'
                and MSTD_KODEIGR = CONST_KODEIGR(+)
                and SUBSTR(CONST_BRANCH(+), 1, 1) = 'O'
                and mstd_noref3 = bpb_nodoc
                and mstd_prdcd = bpb_prdcd
                and MSTD_NODOC = '" . $nodoctr . "')
      GROUP BY RM,
               NPWP,
               NAMA,
               KD_JENIS_TRANSAKSI,
               FG_PENGGANTI,
               NOMOR_FAKTUR,
               TANGGAL_FAKTUR,
               IS_CREDITABLE,
               NOMOR_DOKUMEN_RETUR,
               TANGGAL_RETUR,
               MASA_PAJAK_RETUR,
               TAHUN_PAJAK_RETUR");
        return $result;
    }

    public function cetak(Request $request)
    {
        $step = '';
        $temp = '';
        $ada = '';
        $pjg = '';
        $v_prdcd = '';
        $v_qty = '';
        $v_sup = '';
        $v_nodoc = '';
        $v_nour = '';
        $v_lok = '';
        $v_message = '';
        $qtypb = '';

        $sub_isi_docno = '';
        $arr = '';
        $temdoc = '';
        $pkp1 = '';
        $pkp2 = '';
        $qtyst = '';
        $pkp = '';
        $cterm = '';
        $lcostst = '';
        $acostst = '';
        $nonpb = '';
        $nonrb = '';
        $nonrba = '';
        $nodocbkp = '';
        $nodocbtkp = '';
        $nofak = '';
        $tglfak = '';
        $istype = '';
        $invno = '';
        $tglinv = '';
        $tglrb = '';
        $lambil = '';
        $nofp = '';
        $nnum = '';
        $supcoht = '';
        $pluht = '';
        $nilht = '';
        $nilppn = '';
        $nilsal = '';
        $nildisc = '';

        $nilht_btkp = '';
        $nilppn_btkp = '';
        $nilsal_btkp = '';
        $nildisc_btkp = '';

        $tglht = '';
        $nonota = '';
        $tmp = '';
        $frac = '';
        $unit = '';
        $efaktur = true;
        $f_plubkp = '';
        $f_docbtkp = '';
        $f_docbkp = '';

        $file= [];
        $laporan = [];
        $doc = $request->doc;
        $lap = $request->lap;
        $reprint = $request->reprint;
        $tgl1 = $request->tgl1;
        $tgl2 = $request->tgl2;
        $kertas = $request->kertas;
        $nrfp = $request->nrfp;
        $data = $request->data;

        $nodocs = [];
        $tgldocs = [];
        if (is_array($data)) {
            foreach ($data as $d) {
                $splitData = explode('x', $d);
                array_push($nodocs, $splitData[0]);
                array_push($tgldocs, $splitData[1]);
            }
        } else {
            $splitData = explode('x', $data);
            array_push($nodocs, $splitData[0]);
            array_push($tgldocs, $splitData[1]);
        }

        if ($nrfp == 'on') {
            $nrfp = 1;
        } else {
            $nrfp = 0;
        }
        if ($reprint == 'on') {
            $reprint = 1;
        } else {
            $reprint = 0;
        }

        $sub_isi_docno = [];
        $temp = null;
        $nofp = null;

        if ($doc == 'K') {
            if ($lap == 'L') {
                foreach ($nodocs as $nodoc) {
                    $temp = $temp . '\'' . $nodoc . '\',';
                    array_push($sub_isi_docno, $nodoc);
                }
            } else {
                $tmp = DB::select("SELECT COUNT(1) count
                              FROM TBMASTER_CABANG
                             WHERE CAB_KODECABANG = '" . $_SESSION['kdigr'] . "'
                                    and NVL(CAB_EFAKTUR, 'N') = 'Y'")[0]->count;

                if ($tmp > 0) {
                    if ($reprint == 0) {
                        $efaktur = true;

                        foreach ($nodocs as $nodoc) {
                            $tmp = DB::select("SELECT COUNT(1) count
                          FROM TBTR_BACKOFFICE, TBMASTER_PRODMAST, tbmaster_supplier
                         WHERE     trbo_prdcd = PRD_PRDCD
                        and trbo_kodesupplier = sup_kodesupplier
                        and trbo_typetrn = 'K'
                        and trbo_nodoc = '" . $nodoc . "'
                        and PRD_FLAGBKP1 = 'Y'
                        and PRD_FLAGBKP2 = 'Y'
                        and sup_pkp = 'Y'
                        and trbo_nofaktur is null")[0]->count;

                            if ($tmp > 0) {
                                $efaktur = false;
                                $message = 'Ada Dokumen yang Belum Import CSV EFaktur';
                                $status = 'error';
                                return compact(['message', 'status']);
                            }

                        }

                        if ($efaktur == false) {
                            return;
                        }
                    }
                }

                $sub_isi_docno = [];

                for ($i = 0; $i < sizeof($nodocs); $i++) {

                    $f_docbtkp = 'N';
                    $f_docbkp = 'N';

                    array_push($sub_isi_docno, $nodocs[$i]);

                    if ($reprint == '0') {

                        $tmp = DB::select("SELECT COUNT(1) count
                                   FROM TBTR_BACKOFFICE, TBMASTER_PRODMAST, TBMASTER_SUPPLIER
                                  WHERE trbo_prdcd = PRD_PRDCD
                                  and trbo_typetrn = 'K'
                                    and trbo_nodoc = $nodocs[$i]
                                    and NVL(PRD_FLAGBKP1, 'N') = 'Y'
                                    and NVL(PRD_FLAGBKP2, 'N') = 'Y'")[0]->count;


                        if ($tmp > 0) {
                            $f_docbkp = 'Y';

                            $connect = loginController::getConnectionProcedure();
                            $query = oci_parse($connect, "BEGIN :ret := F_IGR_GET_NOMOR('" . $_SESSION['kdigr'] . "',
                                 'NPB',
                                 'Nomor Pengeluaran Barang',
                                 '2' || TO_CHAR(SYSDATE, 'yy'),
                                 5,
                                 true); END;");
                            oci_bind_by_name($query, ':ret', $nodocbkp, 32);
                            oci_execute($query);
                        }

                        $tmp = DB::selectOne("SELECT COUNT(1)
                               FROM TBTR_BACKOFFICE, TBMASTER_PRODMAST
                              WHERE     trbo_prdcd = PRD_PRDCD
                                and trbo_typetrn = 'K'
                                and trbo_nodoc = '" . $nodocs[$i] . "'
                                and (NVL(PRD_FLAGBKP1, 'N') <> 'Y' or NVL(PRD_FLAGBKP2, 'N') <> 'Y')");


                        if ($tmp) {
                            $f_docbtkp = 'Y';

                            $connect = loginController::getConnectionProcedure();
                            $query = oci_parse($connect, "BEGIN :ret :=  F_IGR_GET_NOMOR('" . $_SESSION['kdigr'] . "',
                                 'NPB',
                                 'Nomor Pengeluaran Barang',
                                 '2' || TO_CHAR(SYSDATE, 'yy'),
                                 5,
                                 true); END;");
                            oci_bind_by_name($query, ':ret', $nodocbtkp, 32);
                            oci_execute($query);

                        }
                        $recs = DB::select("SELECT DISTINCT trbo_invno INVNO, trbo_nofaktur
                              FROM TBTR_BACKOFFICE, TBMASTER_PRODMAST
                             WHERE     trbo_prdcd = PRD_PRDCD
                        and PRD_FLAGBKP1 = 'Y'
                        and PRD_FLAGBKP2 = 'Y'
                        and trbo_typetrn = 'K'
                        and trbo_nodoc = '" . $nodocs[$i] . "'");


                        foreach ($recs as $rec) {
//                         getnofp_tab($i).invno = rec . invno;

                            $tmp = DB::selectOne("SELECT COUNT(1)
                          FROM TBMASTER_CABANG
                         WHERE CAB_KODECABANG = '" . $_SESSION['kdigr'] . "'
                         and NVL(CAB_EFAKTUR, 'N') = 'Y'");


                            if ($tmp) {
                                $nofak = $rec->trbo_nofaktur;
                            } else {

                                $connect = loginController::getConnectionProcedure();

                                $query = oci_parse($connect, "BEGIN :ret :=  F_IGR_GET_NOMOR('" . $_SESSION['kdigr'] . "',
                                 'NRB',
                                    'Nomor Retur Barang',
                                    'Z',
                                    7,
                                    true); END;");
                                oci_bind_by_name($query, ':ret', $nofak, 32);
                                oci_execute($query);
                            }

//                        getnofp_tab(i).nofak = substr(nofak, 2, 7);
                        }


                        if ($f_docbkp == 'Y') {
                            $temp = $temp . '\'' . $nodocbkp . '\',';
                        }

                        if ($f_docbtkp == 'Y') {
                            $temp = $temp . '\'' . $nodocbtkp . '\',';
                        }

                        $lambil = true;
                        $nonrb = ' ';
                        $nonrba = ' ';
                        $tglrb = null;
                        $nilht = 0;
                        $nilppn = 0;
                        $nilsal = 0;
                        $nildisc = 0;
                        $nilht_btkp = 0;
                        $nilppn_btkp = 0;
                        $nilsal_btkp = 0;
                        $nildisc_btkp = 0;

                        $recs = DB::select("SELECT *
                             FROM TBTR_BACKOFFICE,
                                   TBMASTER_PRODMAST,
                                   TBMASTER_STOCK,
                                   TBMASTER_SUPPLIER
                             WHERE     trbo_nodoc = '" . $nodocs[$i] . "'
                        and trbo_kodeigr = PRD_KODEIGR
                        and trbo_prdcd = PRD_PRDCD
                        and trbo_kodeigr = ST_KODEIGR(+)
                        and trbo_prdcd = ST_PRDCD(+)
                        and '02' = ST_LOKASI(+)
                        and trbo_kodeigr = SUP_KODEIGR(+)
                        and trbo_kodesupplier =
                            SUP_KODESUPPLIER(+)
                        and trbo_kodeigr = '" . $_SESSION['kdigr'] . "'
                        and trbo_typetrn = 'K'");

                        foreach ($recs as $rec) {
                            $v_prdcd = $rec->trbo_prdcd;
                            $step = 4;
                            $tglrb = Carbon::now();
                            $istype = isset($rec->trbo_istype) ? $rec->trbo_istype : ' ';
                            $qtyst = isset($rec->st_saldoakhir) ? $rec->st_saldoakhir : 0;
                            $lcostst = isset($rec->st_lastcost) ? $rec->st_lastcost : 0;
                            $acostst = isset($rec->st_avgcost) ? $rec->st_avgcost : 0;
                            $pkp = (isset($rec->sup_pkp) ? $rec->sup_pkp : ' ') != 'Y' ? 'N' : 'Y';
                            $cterm = isset($rec->sup_top) ? $rec->sup_top : 0;
                            $f_plubkp = $rec->prd_flagbkp1 == 'Y' && $rec->prd_flagbkp2 == 'Y' ? 'Y' : 'N';

                            if (isset($rec->trbo_invno) ? $rec->trbo_invno : ' ' == ' ') {
                                $nofp = '';
                            } else {
//                            GETNOFP_IDX = GETNOFP_TAB . FIRST;

//                            foreach () {
//                                STEP = 3005;
//                                exit WHEN GETNOFP_IDX IS NULL;
//                              STEP = 3002;
//
//                              if GETNOFP_TAB(GETNOFP_IDX) . INVNO =
//                                  $rec->trbo_invno {
//                                  STEP = 3003;
//                                  NOFAK = GETNOFP_TAB(GETNOFP_IDX) . NOFAK;
//                              }
//
//                              STEP = 3004;
//                              GETNOFP_IDX = GETNOFP_TAB . NEXT(GETNOFP_IDX);
//                           }


                                $nofp = $nofp . '\'' . $nofak . '\',';
                            }

                            $tmp = DB::select("SELECT COUNT(1) count
                          FROM TBTR_MSTRAN_BTB, TBTR_KONVERSIPLU
                         WHERE     BTB_PRDCD = KVP_PLUOLD(+)
                                 and BTB_NODOC = '" . $rec->trbo_noreff . "'
                                 and (KVP_PLUOLD = '" . $rec->trbo_prdcd . "'
                                     or KVP_PLUNEW = '" . $rec->trbo_prdcd . "'
                                     or BTB_PRDCD = '" . $rec->trbo_prdcd . "')")[0]->count;

                            if ($tmp > 0) {
                                $res = DB::select("SELECT BTB_FRAC, BTB_UNIT
                             FROM TBTR_MSTRAN_BTB, TBTR_KONVERSIPLU
                            WHERE     BTB_PRDCD = KVP_PLUOLD(+)
                            and BTB_NODOC = '" . $rec->trbo_noreff . "'
                            and (KVP_PLUOLD = '" . $rec->trbo_prdcd . "'
                                or KVP_PLUNEW = '" . $rec->trbo_prdcd . "'
                                or BTB_PRDCD = '" . $rec->trbo_prdcd . "')
                            and ROWNUM = 1");
                                $frac = $res[0]->btb_frac;
                                $unit = $res[0]->btb_unit;
                            } else {
                                $tmp = DB::select("SELECT COUNT(1) count
                             FROM TBTR_MSTRAN_BTB, TBTR_KONVERSIPLU
                            WHERE     BTB_PRDCD = KVP_PLUOLD(+)
                            and (KVP_PLUOLD = '" . $rec->trbo_prdcd . "'
                                or KVP_PLUNEW = '" . $rec->trbo_prdcd . "'
                                or BTB_PRDCD = '" . $rec->trbo_prdcd . "')
                            and SUBSTR(BTB_ISTYPE, -2, 2) || BTB_NODOC <
                            SUBSTR('" . $rec->trbo_istype . "', -2, 2)
                            || '" . $rec->trbo_noreff . "'
                            and BTB_INVNO IS NOT NULL")[0]->count;

                                if ($tmp > 0) {
                                    $res = DB::select("SELECT BTB_FRAC, BTB_UNIT
                                  INTO FRAC, UNIT
                                  FROM TBTR_MSTRAN_BTB, TBTR_KONVERSIPLU
                                 WHERE     BTB_PRDCD = KVP_PLUOLD(+)
                               and (KVP_PLUOLD = '" . $rec->trbo_prdcd . "'
                                   or KVP_PLUNEW = '" . $rec->trbo_prdcd . "'
                                   or BTB_PRDCD = '" . $rec->trbo_prdcd . "')
                               and SUBSTR(BTB_ISTYPE, -2, 2)
                               || BTB_NODOC <
                               SUBSTR('" . $rec->trbo_istype . "',
                                   -2,
                                   2)
                               || '" . $rec->trbo_noreff . "'
                               and BTB_INVNO IS NOT NULL
                               and ROWNUM = 1
                              ORDER BY    SUBSTR(BTB_ISTYPE, -2, 2)
                               || BTB_NODOC DESC");
                                    $frac = $res[0]->btb_frac;
                                    $unit = $res[0]->btb_unit;
                                } else {
                                    $res = DB::select("SELECT PRD_FRAC, PRD_UNIT
                                INTO FRAC, UNIT
                                FROM TBMASTER_PRODMAST, TBTR_KONVERSIPLU
                               WHERE     PRD_PRDCD = KVP_PLUOLD(+)
                               and (KVP_PLUOLD = '" . $rec->trbo_prdcd . "'
                                   or KVP_PLUNEW = '" . $rec->trbo_prdcd . "'
                                   or PRD_PRDCD = '" . $rec->trbo_prdcd . "')
                               and ROWNUM = 1");
                                    $frac = $res[0]->prd_frac;
                                    $unit = $res[0]->prd_unit;
                                }
                            }

                            DB::table('tbtr_mstran_d')
                                ->insert([
                                    'mstd_kodeigr' => $rec->trbo_kodeigr,
                                    'mstd_recordid' => $rec->trbo_recordid,
                                    'mstd_typetrn' => $doc,
                                    'mstd_nodoc' => $f_plubkp == 'Y' ? $nodocbkp : $nodocbtkp,
                                    'mstd_tgldoc' => DB::RAW("SYSDATE"),
                                    'mstd_docno2' => $rec->trbo_invno != 'P' ? $nofak : null,
                                    'mstd_date2' => $rec->trbo_tglfaktur,
                                    'mstd_istype' => $rec->trbo_istype,
                                    'mstd_invno' => $rec->trbo_invno,
                                    'mstd_date3' => $rec->trbo_tglinv,
                                    'mstd_kodesupplier' => $rec->trbo_kodesupplier,
                                    'mstd_pkp' => $pkp,
                                    'mstd_seqno' => $rec->trbo_seqno,
                                    'mstd_prdcd' => $rec->trbo_prdcd,
                                    'mstd_kodedivisi' => $rec->prd_kodedivisi,
                                    'mstd_kodedepartement' => $rec->prd_kodedepartement,
                                    'mstd_kodekategoribrg' => $rec->prd_kodekategoribarang,
                                    'mstd_bkp' => $rec->prd_flagbkp1,
                                    'mstd_fobkp' => $rec->prd_flagbkp2,
                                    'mstd_unit' => $unit,
                                    'mstd_frac' => $frac,
                                    'mstd_qty' => $rec->trbo_qty,
                                    'mstd_qtybonus1' => $rec->trbo_qtybonus1,
                                    'mstd_qtybonus2' => $rec->trbo_qtybonus2,
                                    'mstd_hrgsatuan' => $rec->trbo_hrgsatuan,
                                    'mstd_persendisc1' => $rec->trbo_persendisc1,
                                    'mstd_rphdisc1' => $rec->trbo_rphdisc1,
                                    'mstd_flagdisc1' => $rec->trbo_flagdisc1,
                                    'mstd_persendisc2' => $rec->trbo_persendisc2,
                                    'mstd_rphdisc2' => $rec->trbo_rphdisc2,
                                    'mstd_flagdisc2' => $rec->trbo_flagdisc2,
                                    'mstd_persendisc3' => $rec->trbo_persendisc3,
                                    'mstd_rphdisc3' => $rec->trbo_rphdisc3,
                                    'mstd_flagdisc3' => $rec->trbo_flagdisc3,
                                    'mstd_persendisc4' => $rec->trbo_persendisc4,
                                    'mstd_rphdisc4' => $rec->trbo_rphdisc4,
                                    'mstd_flagdisc4' => $rec->trbo_flagdisc4,
                                    'mstd_dis4cp' => $rec->trbo_dis4cp,
                                    'mstd_dis4cr' => $rec->trbo_dis4cr,
                                    'mstd_dis4rp' => $rec->trbo_dis4rp,
                                    'mstd_dis4rr' => $rec->trbo_dis4rr,
                                    'mstd_dis4jp' => $rec->trbo_dis4jp,
                                    'mstd_dis4jr' => $rec->trbo_dis4jr,
                                    'mstd_gross' => $rec->trbo_gross,
                                    'mstd_discrph' => $rec->trbo_discrph,
                                    'mstd_ppnrph' => $rec->trbo_ppnrph,
                                    'mstd_ppnbmrph' => $rec->trbo_ppnbmrph,
                                    'mstd_ppnbtlrph' => $rec->trbo_ppnbtlrph,
                                    'mstd_avgcost' => $rec->trbo_averagecost,
                                    'mstd_ocost' => null,
                                    'mstd_posqty' => $qtyst,
                                    'mstd_keterangan' => $rec->trbo_keterangan,
                                    'mstd_kodetag' => $rec->prd_kodetag,
                                    'mstd_create_by' => $_SESSION['usid'],
                                    'mstd_create_dt' => DB::RAW("SYSDATE"),
                                    'mstd_modify_by' => $_SESSION['usid'],
                                    'mstd_modify_dt' => DB::RAW("SYSDATE"),
                                    'mstd_noref3' => $rec->trbo_noreff,
                                ]);


                            $ada = DB::selectOne("SELECT *
                                  FROM TBTR_MSTRAN_BTB
                                 WHERE BTB_KODEIGR = '" . $_SESSION['kdigr'] . "'
                                     and BTB_NODOC = '" . $rec->trbo_noreff . "'
                                     and BTB_PRDCD = '" . $rec->trbo_prdcd . "'");


                            if (!$ada) {
                                $tmp = DB::select("SELECT COUNT(1) count
                                     FROM TBTR_KONVERSIPLU
                                    WHERE KVP_PLUNEW = '" . $rec->trbo_prdcd . "'")[0]->count;
                                if ($tmp == 0) {
                                    $qtypb = 9999999999;
                                } else {
                                    $qtypb = DB::select("SELECT BTB_QTY count
                                    FROM TBTR_MSTRAN_BTB
                                   WHERE     BTB_KODEIGR = '" . $_SESSION['kdigr'] . "'
                                   and BTB_NODOC = '" . $rec->trbo_noreff . "'
                                   and BTB_PRDCD IN(SELECT KVP_PLUOLD
                                     FROM TBTR_KONVERSIPLU
                                    WHERE KVP_PLUNEW = '" . $rec->trbo_prdcd . "')")[0]->count;
                                }
                            } else {
                                $qtypb = DB::select("SELECT BTB_QTY count
                                 FROM TBTR_MSTRAN_BTB
                                WHERE     BTB_KODEIGR = '" . $_SESSION['kdigr'] . "'
                                and BTB_NODOC = '" . $rec->trbo_noreff . "'
                                and BTB_PRDCD = '" . $rec->trbo_prdcd . "'")[0]->count;

                            }

                            DB::table('tbhistory_retursupplier')
                                ->insert([
                                    'hsr_kodeigr' => $_SESSION['kdigr'],
                                    'hsr_nodoc' => $f_plubkp == 'Y' ? $nodocbkp : $nodocbtkp,
                                    'hsr_kodesupplier' => $rec->trbo_kodesupplier,
                                    'hsr_prdcd' =>  $rec->trbo_prdcd,
                                    'hsr_refnopajak' => $rec->trbo_invno,
                                    'hsr_hrgsatuan' => $rec->trbo_hrgsatuan,
                                    'hsr_qtypb' => $qtypb,
                                    'hsr_qtyretur' => $rec->trbo_qty,
                                    'hsr_create_by' => $_SESSION['usid'],
                                    'hsr_create_dt' => DB::RAW("SYSDATE"),
                                    'hsr_refbpb' => $rec->trbo_noreff
                                ]);




                            $connect = loginController::getConnectionProcedure();

                            $query = oci_parse($connect, "BEGIN  sp_igr_update_stock('" . $_SESSION['kdigr'] . "',
                            '02',
                            '" . $rec->trbo_prdcd . "',
                            ' ',
                            'TRFOUT',
                            " . $rec->trbo_qty . ",
                            ".$lcostst.",
                            ".$acostst.",
                            '" . $_SESSION['usid'] . "',
                            :v_lok,
                            :v_message); END;");
                            oci_bind_by_name($query, ':v_lok', $v_lok, 32);
                            oci_bind_by_name($query, ':v_message', $v_message, 32);
                            oci_execute($query);

                            $supcoht = $rec->trbo_kodesupplier;
                            $pluht = $rec->trbo_prdcd;

                            if ($f_plubkp == 'Y') {
                                $nilht = $nilht + ($rec->trbo_gross - $rec->trbo_discrph);
                                $nilppn = $nilppn + $rec->trbo_ppnrph;
                                $nilsal = $nilsal + ($rec->trbo_gross - $rec->trbo_discrph + $rec->trbo_ppnrph);
                                $nildisc = $nildisc + (($rec->trbo_averagecost / $frac) * $rec->trbo_qty);
                            } else {
                                $nilht_btkp =
                                    $nilht_btkp
                                    + ($rec->trbo_gross - $rec->trbo_discrph);
                                $nilppn_btkp = $nilppn_btkp + $rec->trbo_ppnrph;
                                $nilsal_btkp =
                                    $nilsal_btkp
                                    + ($rec->trbo_gross
                                        - $rec->trbo_discrph
                                        + $rec->trbo_ppnrph);
                                $nildisc_btkp =
                                    $nildisc_btkp
                                    + (($rec->trbo_averagecost / $frac)
                                        * $rec->trbo_qty);
                            }


                            $tglht = $rec->trbo_tgldoc;
                            $tglfak = $rec->trbo_tglfaktur;
                            $tglinv = $rec->trbo_tglinv;
                        }


                        if ($f_docbkp == 'Y') {
                            DB::insert("INSERT INTO TBTR_MSTRAN_H
                            (MSTH_KODEIGR,
                             MSTH_RECORDID,
                             MSTH_TYPETRN,
                             MSTH_NODOC,
                             MSTH_TGLDOC,
                             MSTH_NOPO,
                             MSTH_TGLPO,
                             MSTH_NOFAKTUR,
                             MSTH_TGLFAKTUR,
                             MSTH_NOREF3,
                             MSTH_TGREF3,
                             MSTH_ISTYPE,
                             MSTH_INVNO,
                             MSTH_TGLINV,
                             MSTH_NOTT,
                             MSTH_TGLTT,
                             MSTH_KODESUPPLIER,
                             MSTH_PKP,
                             MSTH_CTERM,
                             MSTH_LOC,
                             MSTH_LOC2,
                             MSTH_KETERANGAN_HEADER,
                             MSTH_FURGNT,
                             MSTH_FLAGDOC,
                             MSTH_CREATE_BY,
                             MSTH_CREATE_DT,
                             MSTH_MODifY_BY,
                             MSTH_MODifY_DT)
                             VALUES('" . $_SESSION['kdigr'] . "',
                                 NULL,
                                 '" . $doc . "',
                                 '" . $nodocbkp . "',
                                 TRUNC(SYSDATE),
                                 '',
                                 NULL,
                                 NULL,
                                 TRUNC(SYSDATE),
                                 NULL,
                                 NULL,
                                 NULL,
                                 NULL,
                                 NULL,
                                 NULL,
                                 NULL,
                                 '" . $supcoht . "',
                                 '" . $pkp . "',
                                 '" . $cterm . "',
                                 NULL,
                                 NULL,
                                 NULL,
                                 NULL,
                                 '1',
                                  '" . $_SESSION['usid'] . "',
                                 SYSDATE,
                                  '" . $_SESSION['usid'] . "',
                                 SYSDATE)");

                        }

                        if ($f_docbtkp == 'Y') {
                            DB::table('tbtr_mstran_h')
                                ->insert([
                                    'MSTH_KODEIGR' => $_SESSION['kdigr'],
                                    'MSTH_RECORDID' => '',
                                    'MSTH_TYPETRN' => $doc,
                                    'MSTH_NODOC' => $nodocbtkp,
                                    'MSTH_TGLDOC' => DB::RAW("TRUNC(SYSDATE)"),
                                    'MSTH_NOPO' => '',
                                    'MSTH_TGLPO' => null,
                                    'MSTH_NOFAKTUR' => null,
                                    'MSTH_TGLFAKTUR' => DB::RAW("TRUNC(SYSDATE)"),
                                    'MSTH_NOREF3' => null,
                                    'MSTH_TGREF3' => null,
                                    'MSTH_ISTYPE' => null,
                                    'MSTH_INVNO' => null,
                                    'MSTH_TGLINV' => null,
                                    'MSTH_NOTT' => null,
                                    'MSTH_TGLTT' => null,
                                    'MSTH_KODESUPPLIER' => $supcoht,
                                    'MSTH_PKP' => $pkp,
                                    'MSTH_CTERM' => $cterm,
                                    'MSTH_LOC' => null,
                                    'MSTH_LOC2' => null,
                                    'MSTH_KETERANGAN_HEADER' => null,
                                    'MSTH_FURGNT' => null,
                                    'MSTH_FLAGDOC' => 1,
                                    'MSTH_CREATE_BY' => $_SESSION['usid'],
                                    'MSTH_CREATE_DT' => DB::RAW("SYSDATE"),
                                    'MSTH_MODifY_BY' => $_SESSION['usid'],
                                    'MSTH_MODifY_DT' => DB::RAW("SYSDATE")
                                ]);
                        }

                        DB::update("UPDATE TBTR_BACKOFFICE
                        SET trbo_nonota = '" . $nodocbkp . "',
                            trbo_tglnota = TRUNC(SYSDATE),
                            trbo_recordid = '2',
                            trbo_flagdoc = '*'
                      WHERE     trbo_nodoc = '" . $nodocs[$i] . "'
                                             and trbo_typetrn = 'K'
                                             and EXISTS
                                             (SELECT 1
                                      FROM TBMASTER_PRODMAST
                                     WHERE     PRD_PRDCD = trbo_prdcd
                                             and PRD_FLAGBKP1 = 'Y'
                                             and PRD_FLAGBKP2 = 'Y')");

                        DB::update("UPDATE TBTR_BACKOFFICE
                        SET trbo_nonota = '" . $nodocbtkp . "',
                            trbo_tglnota = TRUNC(SYSDATE),
                            trbo_recordid = '2',
                            trbo_flagdoc = '*'
                      WHERE     trbo_nodoc = '" . $nodocs[$i] . "'
                                             and trbo_typetrn = 'K'
                                             and EXISTS
                                             (SELECT 1
                                      FROM TBMASTER_PRODMAST
                                     WHERE     PRD_PRDCD = trbo_prdcd
                                             and (NVL(PRD_FLAGBKP1, 'N') <>
                                                 'Y'
                                                 or NVL(PRD_FLAGBKP2, 'N') <>
                                                 'Y'))");

                        DB::update("update tbtr_usul_returlebih
												set usl_status = 'SUDAH CETAK NOTA'
										WHERE     usl_trbo_nodoc = '" . $nodocs[$i] . "'");

                        if (isset($supcoht)) {
                            $ada = DB::select("SELECT NVL(COUNT(1), 0)
                          FROM TBTR_HUTANG
                         WHERE     HTG_TYPE = 'D'
                         and HTG_KODEIGR = '" . $_SESSION['kdigr'] . "'
                         and HTG_NODOKUMEN = '" . $nonpb . "'");


                            if (!isset($ada)) {
                                $res = Self::PRD_CUR($pluht);
                                $pkp1 = $res[0]->prd_flagbkp1;
                                $pkp2 = $res[0]->prd_flagbkp2;

                                if ($f_docbkp == 'Y') {
                                    DB::insert("INSERT INTO TBTR_HUTANG(HTG_KODEIGR,
                                   HTG_TYPE,
                                   HTG_KODESUPPLIER,
                                   HTG_NODOKUMEN,
                                   HTG_TGLFAKTURPAJAK,
                                   HTG_TGLJATUHTEMPO,
                                   HTG_NILAIHUTANG,
                                   HTG_PPN,
                                   HTG_SALDO,
                                   HTG_FLAGBKP1,
                                   HTG_FLAGBKP2,
                                   /*HTG_RPHDISC1, */
                                   HTG_CREATEBY,
                                   HTG_CREATEDT,
                                   HTG_MODifYBY,
                                   HTG_MODifYDT,
                                   HTG_NOREFERENSI,
                                   HTG_TGLREFERENSI)
                                   VALUES('" . $_SESSION['kdigr'] . "'
                                       'D',
                                       $supcoht,
                                       $nodocbkp,
                                       SYSDATE,
                                       '" . $tglht . "',
                                       '" . $nilht . "',
                                       '" . $nilppn . "',
                                       '" . $nilsal . "',
                                       '" . $pkp1 . "',
                                       '" . $pkp2 . "',
                                       '" . $_SESSION['usid'] . "',
                                       SYSDATE,
                                       '" . $_SESSION['usid'] . "',
                                       SYSDATE,
                                       '" . $nodocs[$i] . "',
                                       TGLDOC)");

                                }

                                if ($f_docbtkp == 'Y') {
                                    DB::insert("INSERT INTO TBTR_HUTANG(HTG_KODEIGR,
                                   HTG_TYPE,
                                   HTG_KODESUPPLIER,
                                   HTG_NODOKUMEN,
                                   HTG_TGLFAKTURPAJAK,
                                   HTG_TGLJATUHTEMPO,
                                   HTG_NILAIHUTANG,
                                   HTG_PPN,
                                   HTG_SALDO,
                                   HTG_FLAGBKP1,
                                   HTG_FLAGBKP2,
                                   /*HTG_RPHDISC1, */
                                   HTG_CREATEBY,
                                   HTG_CREATEDT,
                                   HTG_MODifYBY,
                                   HTG_MODifYDT,
                                   HTG_NOREFERENSI,
                                   HTG_TGLREFERENSI)
                                   VALUES('" . $_SESSION['kdigr'] . "',
                                       'D',
                                       '" . $supcoht . "',
                                       '" . $nodocbtkp . "',
                                       SYSDATE,
                                       '" . $tglht . "',
                                       '" . $nilht_btkp . "',
                                       '" . $nilppn_btkp . "',
                                       '" . $nilsal_btkp . "',
                                       '" . $pkp1 . "',
                                       '" . $pkp2 . "',
                                       '" . $_SESSION['usid'] . "',
                                       SYSDATE,
                                       '" . $_SESSION['usid'] . "',
                                       SYSDATE,
                                       '" . $nodocs[$i] . "',
                                       '" . $tgldocs[$i] . "')ss");

                                }
                            }
                        }
                    } else {
                        $temp = $temp . '\'' . $nodocs[$i] . '\',';
                        $nofak = DB::select("SELECT msth_nofaktur
                       FROM TBTR_MSTRAN_H
                      WHERE     MSTH_NODOC =  '" . $nodocs[$i] . "'
                                         and MSTH_TYPETRN = 'K'
                                         and MSTH_KODEIGR = '" . $_SESSION['kdigr'] . "'")[0]->msth_nofaktur;


                        $nofp = $nofp . '\'' . $nofak . '\',';
                    }
                }
            }


            $temp = substr($temp, 0, strlen($temp) - 1);

            if (isset($temp)) {
                //sini
//                return Self::PRINT_DOC($_SESSION['kdigr'], $temp, $doc, $lap, $kertas, $reprint, $tgl1, $tgl2);
//                array_push($file, Self::PRINT_DOC($_SESSION['kdigr'], $temp, $doc, $lap, $kertas, $reprint, $tgl1, $tgl2));
                $func = 'print-doc';
                $kdigr = $_SESSION['kdigr'];
                $laporan[] = compact(['func','kdigr','temp','doc','lap','kertas','reprint','tgl1','tgl2']);

                if ($nrfp == 1) {
                    if (isset($nofp)) {
                        foreach ($nodocs as $nodoc) {
                            $nofp = trim(substr($nofp, 0, strlen($nofp) - 1));

                            if ($reprint == '0') {

                                $tmp = DB::SELECT("SELECT COUNT(1) count
                          FROM TBTR_BACKOFFICE, TBMASTER_SUPPLIER
                         WHERE     trbo_nodoc = '" . $nodoc . "'
                            and trbo_kodeigr = SUP_KODEIGR(+)
                            and trbo_invno <> 'P'
                            and trbo_kodesupplier = SUP_KODESUPPLIER(+)")[0]->count;

                                if ($tmp > 0) {
                                    $res = DB::SELECT("SELECT DISTINCT NVL(SUP_PKP, 'N') pkp, trbo_nonota nonota
                             FROM TBTR_BACKOFFICE, TBMASTER_SUPPLIER
                            WHERE     trbo_nodoc = '" . $nodoc . "'
                            and trbo_kodeigr = SUP_KODEIGR(+)
                            and trbo_invno <> 'P'
                            and trbo_kodesupplier = SUP_KODESUPPLIER(+)");

                                    $pkp = $res[0]->pkp;
                                    $nonota = $res[0]->nonota;

                                    if ($pkp == 'Y') {

                                        $tmp = DB::selectOne("SELECT *
                                FROM TBTR_BACKOFFICE, TBMASTER_PRODMAST
                               WHERE     trbo_prdcd = PRD_PRDCD
                               and trbo_typetrn = 'K'
                               and trbo_nodoc = '" . $nodoc . "'
                               and PRD_FLAGBKP1 = 'Y'
                               and PRD_FLAGBKP2 = 'Y'");

                                        if ($tmp) {
                                            array_push($file, Self::CETAK_BARU($nonota,$reprint));
                                            $func = 'cetak-baru';
                                            $laporan[] = compact(['func','nonota','reprint']);
                                        }
                                    }
                                }
                            } else {
                                $pkp = DB::SELECT("SELECT DISTINCT NVL(MSTD_PKP, 'N') pkp
                          FROM TBTR_MSTRAN_D
                         WHERE MSTD_NODOC = '" . $nodoc . "'
                            and MSTD_TYPETRN = 'K'
                            and MSTD_KODEIGR = '" . $_SESSION['kdigr'] . "' ")[0]->pkp;

                                if ($pkp == 'Y') {
                                    $pkp = DB::SELECT("SELECT COUNT(1) count
                             FROM TBTR_MSTRAN_D, TBMASTER_PRODMAST
                            WHERE     MSTD_PRDCD = PRD_PRDCD
                            and MSTD_TYPETRN = 'K'
                            and MSTD_NODOC = '" . $nodoc . "'
                            and PRD_FLAGBKP1 = 'Y'
                            and PRD_FLAGBKP2 = 'Y'")[0]->count;

                                    if ($tmp > 0) {
                                        array_push($file, Self::CETAK_BARU($nodoc,$reprint));
                                        $func = 'cetak-baru';
                                        $laporan[] = compact(['func','nodoc','reprint']);
                                    }
                                }
                            }
                        }
                    }
                }

                if ($lap == 'L') {
                    if ($reprint == '0') {
                        foreach ($sub_isi_docno as $sub) {
                            DB::update("UPDATE TBTR_BACKOFFICE
                                SET trbo_flagdoc = '1'
                              WHERE trbo_nodoc = '" . $sub . "'
                            and trbo_kodeigr = '" . $_SESSION['kdigr'] . "'");
                        }
                    } else {
                        foreach ($sub_isi_docno as $sub) {
                            DB::update("UPDATE TBTR_MSTRAN_H
                            SET MSTH_FLAGDOC = '1'
                            WHERE     MSTH_KODEIGR = '" . $_SESSION['kdigr'] . "')
                                    and MSTH_TYPETRN = '" . $doc . "'
                                    and MSTH_NOPO = '" . $sub . "'");
                        }
                    }
                }
            }
        } else {
            if ($lap == 'L') {
                $sub_isi_docno = [];

                foreach ($nodocs as $nodoc) {
                    $temp = $temp . '\'' . $nodoc . '\',';
                    array_push($sub_isi_docno, $nodoc);
                }
            } else {
                if (isset($nodocs)) {
                    $sub_isi_docno = [];
                    foreach ($nodocs as $nodoc) {

                        $v_nour = 0;
                        array_push($sub_isi_docno, $nodoc);


                        if ($reprint == '0') {
                            $connect = loginController::getConnectionProcedure();

                            $query = oci_parse($connect, "BEGIN :ret := F_IGR_GET_NOMOR( '" . $_SESSION['kdigr'] . "',
                             'NBH',
                             'Nomor Nota Barang Hilang',
                             '7' || TO_CHAR(SYSDATE, 'yy'),
                             5,
                             true); END;");
                            oci_bind_by_name($query, ':ret', $v_nodoc, 32);
                            oci_execute($query);

                            $temp = $temp . '\'' . $v_nodoc . '\',';

                            $recs = DB::select("SELECT A .*, B .*
                                FROM TBTR_BACKOFFICE A, TBMASTER_PRODMAST B
                               WHERE     PRD_KODEIGR = trbo_kodeigr
                                        and PRD_PRDCD = trbo_prdcd
                                        and trbo_nodoc = '" . $nodoc . "'
                                        and trbo_typetrn = 'H'
                            ORDER BY trbo_seqno");
                            foreach ($recs as $rec) {
                                $qtyst = 0;
                                $lcostst = 0;


                                $results = DB::select("SELECT ST_SALDOAKHIR, ST_LASTCOST, ST_AVGCOST
                             FROM TBMASTER_STOCK
                            WHERE     ST_KODEIGR =  '" . $rec->trbo_kodeigr . "'
                         and ST_PRDCD =
                             SUBSTR( '" . $rec->trbo_prdcd . "', 1, 6) || '0'
                         and ST_LOKASI = '0' ||  '" . $rec->trbo_flagdisc1 . "';");

                                $qtyst = $results->st_saldoakhir;
                                $lcostst = $results->st_lastcost;
                                $acostst = $results->st_avgcost;
                                $pkp = ' ';

                                if (isset($rec->trbo_kodesupplier)) {

                                    $pkp = DB::select(" SELECT SUP_PKP
                                FROM TBMASTER_SUPPLIER
                               WHERE     SUP_KODEIGR = '" . $_SESSION['kdigr'] . "'
                                   and SUP_KODESUPPLIER = '" . $rec->trbo_kodesupplier . "';");
                                    if (!isset($pkp)) {
                                        $pkp = 'N';
                                    }
                                    DB::insert("INSERT INTO TBTR_MSTRAN_D(MSTD_KODEIGR,
                                       MSTD_RECORDID,
                                       MSTD_TYPETRN,
                                       MSTD_NODOC,
                                       MSTD_TGLDOC,
                                       MSTD_DOCNO2,
                                       MSTD_DATE2,
                                       MSTD_NOPO,
                                       MSTD_TGLPO,
                                       MSTD_NOFAKTUR,
                                       MSTD_TGLFAKTUR,
                                       MSTD_ISTYPE,
                                       MSTD_INVNO,
                                       MSTD_DATE3,
                                       MSTD_NOTT,
                                       MSTD_TGLTT,
                                       MSTD_KODESUPPLIER,
                                       MSTD_SEQNO,
                                       MSTD_PRDCD,
                                       MSTD_KODEDIVISI,
                                       MSTD_KODEDEPARTEMENT,
                                       MSTD_KODEKATEGORIBRG,
                                       MSTD_BKP,
                                       MSTD_FOBKP,
                                       MSTD_UNIT,
                                       MSTD_FRAC,
                                       MSTD_LOC2,
                                       MSTD_QTY,
                                       MSTD_QTYBONUS1,
                                       MSTD_QTYBONUS2,
                                       MSTD_HRGSATUAN,
                                       MSTD_PERSENDISC1,
                                       MSTD_RPHDISC1,
                                       MSTD_FLAGDISC1,
                                       MSTD_PERSENDISC2,
                                       MSTD_RPHDISC2,
                                       MSTD_FLAGDISC2,
                                       MSTD_PERSENDISC3,
                                       MSTD_RPHDISC3,
                                       MSTD_FLAGDISC3,
                                       MSTD_PERSENDISC4,
                                       MSTD_RPHDISC4,
                                       MSTD_FLAGDISC4,
                                       MSTD_DIS4CP,
                                       MSTD_DIS4CR,
                                       MSTD_DIS4RP,
                                       MSTD_DIS4RR,
                                       MSTD_DIS4JP,
                                       MSTD_DIS4JR,
                                       MSTD_GROSS,
                                       MSTD_DISCRPH,
                                       MSTD_PPNRPH,
                                       MSTD_PPNBMRPH,
                                       MSTD_PPNBTLRPH,
                                       MSTD_AVGCOST,
                                       MSTD_OCOST,
                                       MSTD_POSQTY,
                                       MSTD_KETERANGAN,
                                       MSTD_KODETAG,
                                       MSTD_FURGNT,
                                       MSTD_PKP,
                                       MSTD_CREATE_BY,
                                       MSTD_CREATE_DT)
                             VALUES('" . $rec->trbo_kodeigr . "',
                                 '" . $rec->trbo_recordid . "',
                                 '" . $rec->trbo_typetrn . "',
                                 '" . $v_nodoc . "',
                                 TRUNC(SYSDATE),
                                 '" . $rec->trbo_noreff . "',
                                 '" . $rec->trbo_tglreff . "',
                                 '" . $rec->trbo_nopo . "',
                                 '" . $rec->trbo_tglpo . "',
                                 '" . $rec->trbo_nofaktur . "',
                                 '" . $rec->trbo_tglfaktur . "',
                                 '" . $rec->trbo_istype . "',
                                 '" . $rec->trbo_invno . "',
                                 '" . $rec->trbo_tglinv . "',
                                 '" . $rec->trbo_nott . "',
                                 '" . $rec->trbo_tgltt . "',
                                 '" . $rec->trbo_kodesupplier . "',
                                 '" . $rec->trbo_seqno . "',
                                 '" . $rec->trbo_prdcd . "',
                                 '" . $rec->PRD_KODEDIVISI . "',
                                 '" . $rec->PRD_KODEDEPARTEMENT . "',
                                 '" . $rec->PRD_KODEKATEGORIBARANG . "',
                                 '" . $rec->PRD_FLAGBKP1 . "',
                                 '" . $rec->PRD_FLAGBKP2 . "',
                                 '" . $rec->PRD_UNIT . "',
                                 '" . $rec->PRD_FRAC . "',
                                 '" . $rec->trbo_gdg . "',
                                 '" . $rec->trbo_qty . "',
                                 '" . $rec->trbo_qtybonus1 . "',
                                 '" . $rec->trbo_qtybonus2 . "',
                                 '" . $rec->trbo_hrgsatuan . "',
                                 '" . $rec->trbo_persendisc1 . "',
                                 '" . $rec->trbo_rphdisc1 . "',
                                 '" . $rec->trbo_flagdisc1 . "',
                                 '" . $rec->trbo_persendisc2 . "',
                                 '" . $rec->trbo_rphdisc2 . "',
                                 '" . $rec->trbo_flagdisc2 . "',
                                 '" . $rec->trbo_persendisc3 . "',
                                 '" . $rec->trbo_rphdisc3 . "',
                                 '" . $rec->trbo_flagdisc3 . "',
                                 '" . $rec->trbo_persendisc4 . "',
                                 '" . $rec->trbo_rphdisc4 . "',
                                 '" . $rec->trbo_flagdisc4 . "',
                                 '" . $rec->trbo_dis4cp . "',
                                 '" . $rec->trbo_dis4cr . "',
                                 '" . $rec->trbo_dis4rp . "',
                                 '" . $rec->trbo_dis4rr . "',
                                 '" . $rec->trbo_dis4jp . "',
                                 '" . $rec->trbo_dis4jr . "',
                                 '" . $rec->trbo_gross . "',
                                 '" . $rec->trbo_discrph . "',
                                 '" . $rec->trbo_ppnrph . "',
                                 '" . $rec->trbo_ppnbmrph . "',
                                 '" . $rec->trbo_ppnbtlrph . "',
                                 '" . $rec->trbo_averagecost . "',
                                 '" . $rec->trbo_oldcost . "',
                                 '" . $qtyst . "',
                                 '" . $rec->trbo_keterangan . "',
                                 '" . $rec->PRD_KODETAG . "',
                                 '" . $rec->trbo_furgnt . "',
                                 '" . $pkp . "',
                                 '" . $_SESSION['usid'] . "',
                                 SYSDATE);");

                                    if ($doc == 'B') {
                                        $connect = loginController::getConnectionProcedure();

                                        $query = oci_parse($connect, "BEGIN  SP_IGR_UPDATE_STOCK('" . $_SESSION['kdigr'] . "','01','" . $rec->trbo_prdcd . "',' ','TRFIN','" . $rec->trbo_qty . "','" . $lcostst . "',0,'" . $_SESSION['usid'] . "','" . $v_lok . "','" . $v_message . "'); END;");
                                        oci_execute($query);

                                    } else {
                                        if ($doc == 'K') {
                                            $connect = loginController::getConnectionProcedure();

                                            $query = oci_parse($connect, "BEGIN SP_IGR_UPDATE_STOCK('" . $_SESSION['kdigr'] . "','02','" . $rec->trbo_prdcd . "',' ','TRFOUT',$rec->trbo_qty,'" . $lcostst . "','" . $acostst . "','" . $_SESSION['usid'] . "','" . $v_lok . "','" . $v_message . "'); END;");
                                            oci_execute($query);

                                        } else {
                                            if ($doc == 'F') {
                                                $connect = loginController::getConnectionProcedure();

                                                $query = oci_parse($connect, "BEGIN  SP_IGR_UPDATE_STOCK('" . $_SESSION['kdigr'] . "','03','" . $rec->trbo_prdcd . "',' ','TRFOUT','" . $rec->trbo_qty . "','" . $lcostst . "',0,'" . $_SESSION['usid'] . "','" . $v_lok . "','" . $v_message . "'); END;");
                                                oci_execute($query);

                                            } else {
                                                if ($doc == 'X') {
                                                    $connect = loginController::getConnectionProcedure();

                                                    $query = oci_parse($connect, "BEGIN  SP_IGR_UPDATE_STOCK('" . $_SESSION['kdigr'] . "',LPAD('" . $rec->trbo_flagdisc2 . "', 2, '0'),,'" . $rec->trbo_prdcd . "',' ','ADJ','" . $rec->trbo_qty . "','" . $lcostst . "',0,'" . $_SESSION['usid'] . "','" . $v_lok . "','" . $v_message . "'); END;");
                                                    oci_execute($query);


                                                } else {
                                                    if ($doc == 'H') {
                                                        $connect = loginController::getConnectionProcedure();

                                                        $query = oci_parse($connect, "BEGIN  SP_IGR_UPDATE_STOCK('" . $_SESSION['kdigr'] . "',LPAD('" . $rec->trbo_flagdisc1 . "', 2, '0'),,'" . $rec->trbo_prdcd . "',' ','TRFOUT','" . $rec->trbo_qty . "','" . $lcostst . "','" . $acostst . "','" . $_SESSION['usid'] . "','" . $v_lok . "','" . $v_message . "'); END;");
                                                        oci_execute($query);


                                                    } else {
                                                        if ($doc == 'P') {
                                                            if ($rec->trbo_flagdisc1 == 'P') {
                                                                $connect = loginController::getConnectionProcedure();

                                                                $query = oci_parse($connect, "BEGIN  SP_IGR_UPDATE_STOCK('" . $_SESSION['kdigr'] . "','01','" . $rec->trbo_prdcd . "',' ','TRFOUT','" . $rec->trbo_qty . "','" . $lcostst . "',0,'" . $_SESSION['usid'] . "','" . $v_lok . "','" . $v_message . "'); END;");
                                                                oci_execute($query);

                                                            } else {
                                                                $connect = loginController::getConnectionProcedure();

                                                                $query = oci_parse($connect, "BEGIN  SP_IGR_UPDATE_STOCK('" . $_SESSION['kdigr'] . "','01','" . $rec->trbo_prdcd . "',' ','TRFIN','" . $rec->trbo_qty . "','" . $lcostst . "',0,'" . $_SESSION['usid'] . "','" . $v_lok . "','" . $v_message . "'); END;");
                                                                oci_execute($query);

                                                            }
                                                        } else {
                                                            if ($doc == 'O') {
                                                                $connect = loginController::getConnectionProcedure();

                                                                $query = oci_parse($connect, "BEGIN  SP_IGR_UPDATE_STOCK('" . $_SESSION['kdigr'] . "','01','" . $rec->trbo_prdcd . "',' ','TRFOUT','" . $rec->trbo_qty . "','" . $lcostst . "',0,'" . $_SESSION['usid'] . "','" . $v_lok . "','" . $v_message . "'); END;");
                                                                oci_execute($query);


                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                    $ada = DB::Select("SELECT NVL(COUNT(1), 0) count
                                          FROM TBTR_MSTRAN_H
                                         WHERE MSTH_KODEIGR = '" . $_SESSION['kdigr'] . "'
                                                   and MSTH_TYPETRN = '" . $doc . "'
                                                   and MSTH_NODOC = V_NODOC;")[0]->count;

                                    if ($ada == 0) {

                                        DB::insert("INSERT INTO TBTR_MSTRAN_H(MSTH_KODEIGR,
                                MSTH_TYPETRN,
                                MSTH_NODOC,
                                MSTH_TGLDOC,
                                MSTH_FLAGDOC,
                                MSTH_KODESUPPLIER,
                                MSTH_CREATE_BY,
                                MSTH_CREATE_DT)
                                VALUES('" . $_SESSION['kdigr'] . "'
                                    '" . $doc . "',
                                    '" . $v_nodoc . "',
                                    TRUNC(SYSDATE),
                                    '1',
                                    '" . $rec->trbo_kodesupplier . "',
                                    '" . $_SESSION['usid'] . "',
                                    SYSDATE);");
                                    }
                                }
                            }
                            DB::update("UPDATE TBTR_BACKOFFICE
                        SET trbo_nonota = '" . $v_nodoc . "'
                            trbo_tglnota = TRUNC(SYSDATE),
                            trbo_recordid = '2',
                            trbo_flagdoc = '*'
                      WHERE trbo_nodoc = '" . $nodoc . "' and trbo_typetrn = 'H';");
                        } else {
                            $temp = $temp . '\'' . $nodoc . '\',';
                        }

                    }

                }

                $temp = substr($temp, 0, strlen($temp) - 1);

                if (isset($temp)) {
//                    return Self::PRINT_DOC($_SESSION['kdigr'], $temp, $doc, $lap, $kertas, $reprint, $tgl1, $tgl2);
//                    array_push($file, Self::PRINT_DOC($_SESSION['kdigr'], $temp, $doc, $lap, $kertas, $reprint, $tgl1, $tgl2));
                    $func = 'print-doc';
                    $kdigr = $_SESSION['kdigr'];
                    $laporan[] = compact(['func','kdigr','temp','doc','lap','kertas','reprint','tgl1','tgl2']);
//sini
                    if ($lap == 'L') {
                        if ($reprint == '0') {
                            foreach ($nodocs as $nodoc) {

                                DB::update("UPDATE TBTR_BACKOFFICE
                        SET trbo_flagdoc = '1'
                      WHERE     trbo_nodoc = '" . $nodoc . "'
                      and trbo_kodeigr = '" . $_SESSION['kdigr'] . "';");
                            }
                        }
                    } else {
                        foreach ($nodocs as $nodoc) {
                            DB::update("UPDATE TBTR_MSTRAN_H
                     SET MSTH_FLAGDOC = '1'
                   WHERE     MSTH_KODEIGR = '" . $_SESSION['kdigr'] . "'
                      and MSTH_TYPETRN = '" . $doc . "'
                      and MSTH_NODOC =  '" . $nodoc . "'");
                        }
                    }
                }
            }

            if ($doc == 'K' && $lap == 'N' && $reprint == 0) {
                $nomor = 'NOMOR REFERENSI';
            } else {
                $nomor = 'NOMOR DOKUMEN';
            }

//          SHOW_DATA($doc, $lap, $reprint);
        }
        return $laporan;
    }

    public function PRD_CUR(string $plu)
    {
        $result = DB::select("SELECT PRD_FLAGBKP1, PRD_FLAGBKP2 FROM TBMASTER_PRODMAST WHERE PRD_KODEIGR = '" . $_SESSION['kdigr'] . "' AND PRD_PRDCD = '" . $plu . "' ");
        return $result;
    }

    public function PRINT_DOC(Request $request)
    {
        $kodeigr = $request->kodeigr;
        $nodoc = $request->nodoc;
        $typedoc = $request->typedoc;
        $typelap = $request->typelap;
        $jnskertas = $request->jnskertas;
        $reprint = $request->reprint;
        $tgl1 = $request->tgl1;
        $tgl2 = $request->tgl2;

        try{
            $data1 = '';
            $data2 = '';
            $filename = '';
            $cw = '';
            $ch = '';
            if ($typelap == 'L') {
                // L = List  N = Nota
                switch ($typedoc) {
                    case  'B' :      // Penerimaan
                        null;
                        break;
                    case  'K' :     // Pengeluaran data belum keluar
                        $cw = 700;
                        $ch = 45;
                        $filename = 'list-pengeluaran';
                        $P_PN = "AND trbo_nodoc IN (" . $nodoc . ") AND trbo_typetrn='K'";
                        $data1 = DB::select("SELECT   trbo_nodoc, trbo_tgldoc, trbo_kodesupplier, trbo_istype, trbo_invno, trbo_tglinv,
                                 trbo_prdcd, trbo_hrgsatuan, trbo_keterangan, trbo_gross, trbo_discrph, trbo_ppnrph,
                                 CASE
                                     WHEN '" . $reprint . "' = '1'
                                         THEN 'RE-PRINT'
                                     ELSE ''
                                 END AS STATUS, trbo_qty, FLOOR (trbo_qty / BTB_FRAC) AS CTN,
                                 MOD (trbo_qty, BTB_FRAC) AS PCS,
                                 (NVL (trbo_gross, 0) - NVL (trbo_discrph, 0) + NVL (trbo_ppnrph, 0)) AS TOTAL,
                                 PRD_DESKRIPSIPENDEK, BTB_UNIT, BTB_FRAC, SUP_NAMASUPPLIER, PRS_NAMAPERUSAHAAN,
                                 PRS_NAMACABANG, trbo_noreff
                            FROM TBTR_BACKOFFICE, TBMASTER_PRODMAST, TBMASTER_SUPPLIER, TBMASTER_PERUSAHAAN,
                                 TBTR_MSTRAN_BTB
                           WHERE trbo_kodeigr = '" . $_SESSION['kdigr'] . "'
                                      " . $P_PN . "
                             AND PRD_KODEIGR = trbo_kodeigr
                             AND PRD_PRDCD = trbo_prdcd
                             AND SUP_KODEIGR(+) = trbo_kodeigr
                             AND SUP_KODESUPPLIER(+) = trbo_kodesupplier
                             AND PRS_KODEIGR = trbo_kodeigr
                             AND trbo_prdcd = BTB_PRDCD(+)
                             AND trbo_noreff = BTB_NODOC(+)
                        ORDER BY trbo_seqno");

                        $data2 = DB::select("SELECT distinct trbo_nodoc, trbo_tgldoc, trbo_kodesupplier,trbo_istype, trbo_invno, trbo_tglinv
                                    FROM TBTR_BACKOFFICE,  TBMASTER_PRODMAST, TBMASTER_SUPPLIER, TBMASTER_PERUSAHAAN
                                    WHERE trbo_kodeigr = '" . $_SESSION['kdigr'] . "'
                                                  " . $P_PN . "
                                                  AND prd_kodeigr = trbo_kodeigr AND prd_prdcd = trbo_prdcd
                                                  AND sup_kodeigr(+) = trbo_kodeigr AND sup_kodesupplier(+) = trbo_kodesupplier
                                                  AND prs_kodeigr = trbo_kodeigr
                                    order by trbo_tglinv desc, trbo_istype desc, trbo_invno desc");
                        break;
                    case  'F' :      // Pemusnahan
                        $cw = 700;
                        $ch = 45;
                        $filename = 'cetak-list';
                        $P_PN = "AND trbo_noreff IN (" . $nodoc . ")";
                        $data1 = DB::select("SELECT trbo_noreff trbo_nodoc, trbo_tglreff  trbo_tgldoc, trbo_flagdisc1, trbo_prdcd, prd_unit trbo_unit, prd_isibeli trbo_frac,                                    trbo_hrgsatuan, trbo_keterangan,
                                CASE WHEN trbo_flagdoc = '1' THEN 'RE-PRINT' ELSE '' END AS STATUS,
                                trbo_qty, FLOOR(trbo_qty/prd_isibeli) AS CTN, MOD(trbo_qty,prd_isibeli) AS PCS, (trbo_qty * trbo_hrgsatuan) AS total ,
                                CASE WHEN trbo_flagdisc1 = '1' THEN 'BARANG BAIK' ELSE
                                CASE WHEN trbo_flagdisc1 = '2' THEN 'BARANG RETUR' ELSE
                                 'BARANG RUSAK' END END AS KET,
                                prd_deskripsipanjang,
                                prs_namaperusahaan, prs_namacabang,
                                CASE WHEN trbo_typetrn = 'H' THEN 'EDIT LIST TRANSAKSI BARANG HILANG'
                                     WHEN trbo_typetrn = 'X' THEN 'EDIT LIST PENYESUAIAN PERSEDIAAN'
                                     ELSE  'EDIT LIST PENERIMAAN BARANG'
                                END AS JUDUL
                                FROM TBTR_BACKOFFICE,  TBMASTER_PRODMAST, TBMASTER_PERUSAHAAN
                                WHERE trbo_kodeigr = '" . $_SESSION['kdigr'] . "'
                                 " . $P_PN . "
                                AND prd_kodeigr = trbo_kodeigr AND prd_prdcd = trbo_prdcd
                                AND prs_kodeigr = trbo_kodeigr
                                ORDER BY trbo_nodoc");
                        break;
                    case  'X' :      // Penyesuaian
                        null;
                        break;
                    case  'H' :      // Barang Hilang
                        $cw = 700;
                        $ch = 45;
                        $filename = 'list-baranghilang';
                        $P_PN = "AND trbo_nodoc IN (" . $nodoc . ") AND trbo_typetrn='H'";
                        $data1 = DB::select("SELECT trbo_nodoc,trbo_tgldoc, trbo_flagdisc1, trbo_prdcd, prd_unit trbo_unit, prd_frac trbo_frac, trbo_hrgsatuan, trbo_keterangan,
                                    CASE WHEN trbo_flagdoc = '1' THEN 'RE-PRINT' ELSE '' END AS STATUS,
                                 trbo_qty, FLOOR(trbo_qty/prd_frac) AS CTN, MOD(trbo_qty,prd_frac) AS PCS, (trbo_qty * (trbo_hrgsatuan/prd_frac)) AS total ,
                                    CASE WHEN trbo_flagdisc1 = '1' THEN 'BARANG BAIK' ELSE
                                    CASE WHEN trbo_flagdisc1 = '2' THEN 'BARANG RETUR' ELSE 'BARANG RUSAK' END END AS KET,
                                 prd_deskripsipanjang,
                                 prs_namaperusahaan, prs_namacabang,
                                    CASE WHEN trbo_typetrn = 'H' THEN 'EDIT LIST TRANSAKSI BARANG HILANG'
                                          WHEN trbo_typetrn = 'X' THEN 'EDIT LIST PENYESUAIAN PERSEDIAAN'
                                          ELSE  'EDIT LIST PENERIMAAN BARANG' END AS JUDUL
                                FROM TBTR_BACKOFFICE,  TBMASTER_PRODMAST, TBMASTER_PERUSAHAAN
                                WHERE trbo_kodeigr = '" . $_SESSION['kdigr'] . "'
                                 " . $P_PN . "
                                                    AND prd_kodeigr = trbo_kodeigr AND prd_prdcd = trbo_prdcd
                                                    AND prs_kodeigr = trbo_kodeigr
                                ORDER BY trbo_nodoc,trbo_seqno");


                        break;
                    case  'P' :      // Re-Packing
                        null;
                        break;
                    case  'O' :      // Surat Jalan
                        null;
                        break;
                    default:
                        null;
                }
            } else {
                switch ($typedoc) {

                    case  'K' :

                        $P_PN = "AND MSTH_NODOC IN (" . $nodoc . ") AND MSTH_TYPETRN='K'";

                        $data1 = DB::select("SELECT msth_nodoc, to_char(msth_tgldoc, 'dd/mm/yyyy') msth_tgldoc,
                                  CASE WHEN '" . $reprint . "' = '1' THEN 'RE-PRINT' ELSE '' END AS STATUS,
                                  mstd_prdcd, mstd_unit, mstd_frac, mstd_qty, mstd_hrgsatuan,
                                  FLOOR(mstd_qty/mstd_frac) AS CTN, MOD(mstd_qty,mstd_frac) AS PCS, mstd_keterangan,
                                  mstd_gross, mstd_discrph, mstd_ppnrph, (NVL(mstd_gross,0) - NVL(mstd_discrph,0) + NVL(mstd_ppnrph,0)) AS TOTAL, msth_kodesupplier, msth_istype || msth_invno nofp, msth_tglinv,
                                  case when nvl(msth_kodesupplier,' ') <> ' ' then '( RETUR PEMBELIAN )' ELSE '( LAIN - LAIN )' end judul,prd_deskripsipanjang,
                                  prs_namaperusahaan, prs_namacabang, prs_npwp, prs_alamat1, prs_alamat3,
                                 nvl(sup_namanpwp,sup_namasupplier || sup_singkatansupplier) namas, sup_npwp, NVL(SUP_ALAMATNPWP1,SUP_ALAMATSUPPLIER1) SUP_ALAMATSUPPLIER1,
                                 NVL(SUP_ALAMATNPWP2,SUP_ALAMATSUPPLIER2) SUP_ALAMATSUPPLIER2,
                                 NVL(SUP_ALAMATNPWP3,SUP_KOTASUPPLIER3) SUP_KOTASUPPLIER3, sup_telpsupplier, sup_contactperson, mstd_noref3
                    FROM TBTR_MSTRAN_H, TBTR_MSTRAN_D, TBMASTER_PRODMAST, TBMASTER_PERUSAHAAN, TBMASTER_SUPPLIER
                    WHERE MSTH_KODEIGR = '" . $_SESSION['kdigr'] . "' AND
                                   MSTH_KODEIGR = MSTD_KODEIGR AND MSTH_NODOC = MSTD_NODOC AND
                                   MSTD_KODEIGR = PRD_KODEIGR AND MSTD_PRDCD = PRD_PRDCD AND
                                   MSTH_KODEIGR = PRS_KODECABANG AND
                                   MSTH_KODEIGR = SUP_KODEIGR(+) AND MSTH_KODESUPPLIER = SUP_KODESUPPLIER(+)
                                    " . $P_PN . "
                    ORDER BY MSTH_NODOC,MSTD_SEQNO");

                        $data2 = DB::select("select rownum, a.*
                                        from
                                        (SELECT DISTINCT MSTH_NODOC NODOC, to_char(MSTH_TGLDOC, 'dd/mm/yyyy') MSTH_TGLDOC, MSTH_KODESUPPLIER, MSTD_ISTYPE || MSTD_INVNO NOFP,
                                                        to_char(MSTD_DATE3, 'dd/mm/yyyy') MSTD_DATE3
                                                   FROM TBTR_MSTRAN_H,
                                                        TBTR_MSTRAN_D,
                                                        TBMASTER_PRODMAST,
                                                        TBMASTER_PERUSAHAAN,
                                                        TBMASTER_SUPPLIER
                                                  WHERE MSTH_KODEIGR = '" . $_SESSION['kdigr'] . "'
                                                    AND MSTH_KODEIGR = MSTD_KODEIGR
                                                    AND MSTH_NODOC = MSTD_NODOC
                                                    AND MSTD_KODEIGR = PRD_KODEIGR
                                                    AND MSTD_PRDCD = PRD_PRDCD
                                                    AND MSTH_KODEIGR = PRS_KODECABANG
                                                    AND MSTH_KODEIGR = SUP_KODEIGR(+)
                                                    AND MSTH_KODESUPPLIER = SUP_KODESUPPLIER(+)
                                                    " . $P_PN . "
                                                    ORDER BY MSTH_NODOC
                                        ) a");

                        if ($jnskertas == 'B') {
                            $cw = 700;
                            $ch = 45;
                            $filename = 'cetak-nota-pengeluaran-biasa';
                        } else {
                            $cw = 700;
                            $ch = 45;
                            $filename = 'cetak-nota-pengeluaran-kecil';
                        }
                        break;
                    case  'H' :      // Barang Hilang
                        $P_PN = "AND MSTH_NODOC IN (" . $nodoc . ") AND MSTH_TYPETRN='H'";
                        $data1 = DB::select("SELECT msth_nodoc, msth_tgldoc,
                                      mstd_flagdisc1, mstd_prdcd, mstd_unit, mstd_frac, mstd_qty, mstd_hrgsatuan,
                                      FLOOR(mstd_qty/mstd_frac) AS CTN, MOD(mstd_qty,mstd_frac) AS PCS, (mstd_qty * (mstd_hrgsatuan/prd_frac)) AS total, mstd_keterangan,
                                      CASE WHEN mstd_flagdisc1 = '1' THEN 'BARANG BAIK' ELSE
                                      CASE WHEN mstd_flagdisc1 = '2' THEN 'BARANG RETUR' ELSE 'BARANG RUSAK' END END AS KET,
                                      prd_deskripsipanjang,  prd_frac,
                                      prs_namaperusahaan, prs_namacabang, prs_npwp, prs_alamat1, prs_alamat3
                        FROM TBTR_MSTRAN_H, TBTR_MSTRAN_D, TBMASTER_PRODMAST, TBMASTER_PERUSAHAAN
                        WHERE msth_KODEIGR = '" . $_SESSION['kdigr'] . "'
                                      " . $P_PN . "
                                     AND mstd_kodeigr = msth_kodeigr AND mstd_nodoc = msth_nodoc
                                     AND prd_kodeigr = msth_kodeigr AND prd_prdcd = mstd_prdcd
                                     AND prs_kodeigr = msth_kodeigr
                        ORDER BY msth_NODOC,mstd_seqno");

                        if ($jnskertas == 'B') {
                            $cw = 700;
                            $ch = 45;

                            $filename = 'cetak-nota-nbh-biasa';
                        } else {
                            $cw = 700;
                            $ch = 45;

                            $filename = 'cetak-nota-nbh-kecil';
                        }
                        break;
                }
            }

            $perusahaan = DB::table('tbmaster_perusahaan')
                ->first();


            if (sizeof($data1) != 0) {
                $arrData = [];
                $arrTemp = [];
                $head = [];
                $detail = [];
                $temp = null;

                for($i=0;$i<count($data1);$i++){
                    if($data1[$i]->msth_nodoc != $temp){
                        if($temp != null){
                            $arrTemp['head'] = $head;
                            $arrTemp['detail'] = $detail;
                            $arrData[] = $arrTemp;
                        }

                        $temp = $data1[$i]->msth_nodoc;
                        $arrTemp = [];
                        $head = [];
                        $detail = [];
                    }

                    $head[] = $data2[$i];
                    $detail[] = $data1[$i];
                }
                $arrTemp['head'] = $head;
                $arrTemp['detail'] = $detail;
                $arrData[] = $arrTemp;

//                dd($arrData);

                $data = [
                    'data' => ['dummy'],
                    'perusahaan' => $perusahaan,
                    'data1' => $data1,
                    'data2' => $data2,
                    'arrData' => $arrData,
                    'tgl1' => $tgl1,
                    'tgl2' => $tgl2,
                    'jnskertas' => $jnskertas
                ];

//                dd($filename);

//                dd($data);

                return view('BACKOFFICE.CETAKDOKUMEN.' . $filename . '-pdf', $data);

                $dompdf = new PDF();

                $pdf = PDF::loadview('BACKOFFICE.CETAKDOKUMEN.' . $filename . '-pdf', $data);

                error_reporting(E_ALL ^ E_DEPRECATED);

                $pdf->output();
                $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);

                $canvas = $dompdf ->get_canvas();
                $canvas->page_text(507, 77.75, "{PAGE_NUM} dari {PAGE_COUNT}", null, 7, array(0, 0, 0));

                $dompdf = $pdf;

                return $dompdf->stream('Nota Pengeluaran Barang (Retur Pembelian).pdf');

//                file_put_contents($filename.'.pdf',$pdf->output());
//
//                return $filename.'.pdf';
            }
            else {
                return "TIDAK ADA DATA!";

            }
        }
        catch (\Exception $e){
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function CETAK_BARU($nodoc, $reprint){
        $cw = 700;
        $ch = 45;
        $filename = 'ctk-rtrpjk';
        $P_PN = "AND MSTH_NODOC IN (" . $nodoc . ") AND MSTH_TYPETRN='K'";
//        $P_JBT1 = REPLACE(:P_JBT1,'1',' ');
//          $P_JBT2 = REPLACE(:P_JBT2,'1',' ');
//          $P_TANDA = REPLACE(:P_TANDA,'1',' ');

        $data1 = DB::select("SELECT   MSTH_NODOC, trunc(msth_tgldoc) msth_tgldoc, MSTH_KODESUPPLIER, MSTD_DOCNO2, MSTD_DATE3 ,
         MSTD_DATE2 , PRD_PRDCD, MSTD_QTY, MSTD_UNIT, MSTD_FRAC, MSTD_GROSS,
         MSTD_DISCRPH, (MSTD_PPNRPH) MSTD_PPNRPH, MSTD_PKP, MSTH_ISTYPE, MSTH_INVNO, MSTH_FLAGDOC,
         SUP_NAMASUPPLIER, SUP_SINGKATANSUPPLIER, SUP_NAMANPWP,
         SUP_ALAMATNPWP1 || ' ' || SUP_ALAMATNPWP2 || ' ' || SUP_ALAMATNPWP3 ADDR_SUP, SUP_NPWP,
         SUP_TGLSK, SUP_NOSK, PRS_KODEMTO, PRS_BULANBERJALAN, PRS_TAHUNBERJALAN, PRS_NONRB,
         PRS_NAMAPERUSAHAAN, PRS_NPWP, PRS_NAMAWILAYAH,
         CONST_ADDR1 || ' ' || CONST_ADDR2 CONST_ADDR, PRD_DESKRIPSIPANJANG,
         CASE
             WHEN " . $reprint . " = 0
                 THEN ''
             ELSE '*'
         END REPRINT, MSTd_ISTYPE, MSTd_INVNO, MSTD_NOREF3
    FROM TBTR_MSTRAN_H,
         TBTR_MSTRAN_D,
         TBMASTER_SUPPLIER,
         TBMASTER_PERUSAHAAN,
         TBMASTER_CONST,
         TBMASTER_PRODMAST
   WHERE MSTH_KODEIGR = '" . $_SESSION['kdigr'] . "'
" . $P_PN . "
     AND MSTH_TYPETRN = 'K'
     AND MSTD_NODOC = MSTH_NODOC
     AND MSTD_KODEIGR = MSTH_KODEIGR
     AND (NVL (MSTD_DOCNO2, '9') <> '9' OR MSTD_DOCNO2 <> '  '
         )
     AND NVL (MSTD_PKP, 'N') = 'Y'
     AND SUP_KODESUPPLIER = MSTH_KODESUPPLIER
     AND SUP_KODEIGR = MSTH_KODEIGR
     AND PRS_KODEIGR = MSTH_KODEIGR
     AND CONST_KODEIGR(+) = MSTH_KODEIGR
     AND SUBSTR (CONST_BRANCH, 1, 1) = 'O'
     AND PRD_PRDCD = MSTD_PRDCD
     AND NVL (PRD_FLAGBKP1, 'N') = 'Y'
     AND PRD_KODEIGR = MSTD_KODEIGR
ORDER BY MSTD_SEQNO");
        $perusahaan = DB::table('tbmaster_perusahaan')->first();


        if (sizeof($data1) != 0) {
            $data = [
                'perusahaan' => $perusahaan,
                'data1' => $data1
            ];
            $dompdf = new PDF();

            $pdf = PDF::loadview('BACKOFFICE.CETAKDOKUMEN.' . $filename . '-pdf', $data);

            error_reporting(E_ALL ^ E_DEPRECATED);

            $pdf->output();
            $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);
            $canvas = $dompdf->get_canvas();
            $canvas->page_text($cw, $ch, "{PAGE_NUM} dari {PAGE_COUNT}", null, 7, array(0, 0, 0));

            $dompdf = $pdf;
            $filenames = $filename.'_'.$nodoc.'.pdf';
            file_put_contents($filenames,$pdf->output());

            return $filenames;
        }
    }
}
