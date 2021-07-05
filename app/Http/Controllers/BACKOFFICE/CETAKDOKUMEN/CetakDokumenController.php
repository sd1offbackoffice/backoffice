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
                $recs = DB::select("SELECT TRBO_NODOC,TRBO_TGLDOC
                           FROM TBTR_BACKOFFICE
                           WHERE(TRBO_TGLDOC BETWEEN to_date('" . $tgl1 . "','dd/mm/yyyy') and to_date('" . $tgl2 . "','dd/mm/yyyy')) and
                                        NVL(TRBO_RECORDID, '0') <> '1' and
                                        TRBO_TYPETRN = '" . $doc . "' and
                                        (NVL(TRBO_FLAGDOC, ' ') = '" . $reprint . "' or NVL(TRBO_FLAGDOC, ' ') = ' ')
                           GROUP BY TRBO_NODOC,TRBO_TGLDOC
                           ORDER BY TRBO_NODOC");
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
                    $recs = DB::select("SELECT TRBO_NODOC,TRBO_TGLDOC
                               FROM TBTR_BACKOFFICE
                               WHERE(TRBO_TGLDOC BETWEEN to_date('" . $tgl1 . "','dd/mm/yyyy') and to_date('" . $tgl2 . "','dd/mm/yyyy')) and
                                          TRBO_TYPETRN = '" . $doc . "' and
                                          NVL(TRBO_RECORDID, '0') <> '1' and
                                          NVL(TRBO_FLAGDOC, ' ') <> '*'
                               GROUP BY TRBO_NODOC,TRBO_TGLDOC
                               ORDER BY TRBO_NODOC");
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
                $recs = DB::select("SELECT TRBO_NODOC,TRBO_TGLDOC
			           FROM TBTR_BACKOFFICE
			           WHERE(TRBO_TGLDOC BETWEEN to_date('" . $tgl1 . "','dd/mm/yyyy') and to_date('" . $tgl2 . "','dd/mm/yyyy')) and
			           			  TRBO_TYPETRN = '" . $doc . "' and
                                  NVL(TRBO_RECORDID, '0') <> '1' and
                                  (NVL(TRBO_FLAGDOC, ' ') = '" . $reprint . "' or NVL(TRBO_FLAGDOC, ' ') = ' ')
			           GROUP BY TRBO_NODOC,TRBO_TGLDOC
			           ORDER BY TRBO_NODOC");
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
                    $recs = DB::select("SELECT TRBO_NODOC,TRBO_TGLDOC
                               FROM TBTR_BACKOFFICE
                               WHERE(TRBO_TGLDOC BETWEEN to_date('" . $tgl1 . "','dd/mm/yyyy') and to_date('" . $tgl2 . "','dd/mm/yyyy')) and
                                          TRBO_TYPETRN = '" . $doc . "' and
                                          NVL(TRBO_RECORDID, '0') <> '1' and
                                          NVL(TRBO_FLAGDOC, ' ') <> '*'
                               GROUP BY TRBO_NODOC,TRBO_TGLDOC
                               ORDER BY TRBO_NODOC");
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
        return Datatables::of($data)->addColumn('checkbox', static function ($data) {
            return $data->nodoc;
        })->make(true);
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
        $linebuff = '';
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

        $nodocs = $request->nodoc;
        $tgldocs = $request->tgldoc;

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
                      WHERE     TRBO_PRDCD = PRD_PRDCD
                            and trbo_kodesupplier = sup_kodesupplier
                            and TRBO_TYPETRN = 'K'
                            and TRBO_NODOC = '" . $nodoc . "'
                            and PRD_FLAGBKP1 = 'Y'
                            and PRD_FLAGBKP2 = 'Y'
                            and sup_pkp = 'Y'")[0]->count;
            } else {
                $temp = DB::select("SELECT COUNT(1)
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


                $recs = DB::select("SELECT DISTINCT TRBO_INVNO INVNO, TRBO_NOFAKTUR
                     FROM TBTR_BACKOFFICE, tbmaster_prodmast, tbmaster_supplier
                    WHERE     trbo_prdcd = prd_prdcd
                and trbo_kodesupplier = sup_kodesupplier
                and TRBO_TYPETRN = 'K'
                and prd_flagbkp1 = 'Y'
                and sup_pkp = 'Y'
                and TRBO_NOFAKTUR IS NULL
                and TRBO_NODOC = '" . $nodocs[$i] . "'");

                foreach ($recs as $rec) {

                    $temp = DB::select("SELECT COUNT(1) count
                         FROM TBTR_BACKOFFICE
                        WHERE     TRBO_TYPETRN = 'K'
                            and TRBO_NODOC = '" . $nodocs[$i] . "'
                            and TRBO_INVNO = '" . $rec->invno . "'
                            and trbo_nofaktur is not null")[0]->count;

                    if ($temp > 0) {
                        $nofak = DB::select("SELECT distinct TRBO_NOFAKTUR
                                FROM TBTR_BACKOFFICE
                               WHERE     TRBO_TYPETRN = 'K'
                               and TRBO_NODOC = '" . $nodocs[$i] . "'
                               and TRBO_INVNO = '" . $rec->invno . "'
                               and trbo_nofaktur is not null")[0]->count;
                    } else {
                        $connect = oci_connect('SIMSMG', 'SIMSMG', '192.168.237.193:1521/SIMSMG');

                        $query = oci_parse($connect, "BEGIN :ret := f_igr_get_nomor('" . $_SESSION['kdigr'] . "','NRB','Nomor Retur Barang','Z',7,TRUE); END;");
                        oci_bind_by_name($query, ':ret', $nofak, 32);
                        oci_execute($query);
                    }

                    DB::table('TBTR_BACKOFFICE')
                        ->where([
                            'TRBO_KODEIGR' => $_SESSION['kdigr'],
                            'TRBO_TYPETRN' => 'K',
                            'TRBO_NODOC' => $nodocs[$i],
                            'TRBO_INVNO' => $rec->invno

                        ])
                        ->update([
                            'TRBO_TGLFAKTUR' => DB::raw("trunc(sysdate)"),
                            'TRBO_NOFAKTUR' => $nofak
                        ]);
                }
            } else {

                $tgldocbo = DB::select("SELECT DISTINCT MSTH_TGLDOC
                              FROM TBTR_MSTRAN_H
                             WHERE MSTH_NODOC = :NODOC and ROWNUM = 1")[0]->MSTH_TGLDOC;
            }


            if ($tgldocbo <> $tgldocs[$i]) {

                $FNAME =
                    'RM'
                    . $_SESSION['kdigr']
                    . ' . CSV';

//            -- HEADER'
                $linebuff = 'RM|NPWP|NAMA|KD_JENIS_TRANSAKSI|FG_PENGGANTI|NOMOR_FAKTUR|TANGGAL_FAKTUR|IS_CREDITABLE|NOMOR_DOKUMEN_RETUR|TANGGAL_RETUR|';
                $linebuff = $linebuff
                    . 'MASA_PAJAK_RETUR|TAHUN_PAJAK_RETUR|NILAI_RETUR_DPP|NILAI_RETUR_PPN|NILAI_RETUR_PPNBM'
                    . chr(13)
                    . chr(10);
                $tgldoc = $tgldocbo;
            }


            if ($reprint == '0') {
                $rmbo_recs = Self::RMBO_CUR($nodoc);

                foreach ($rmbo_recs as $rmbo_rec) {
                    $adaisi = true;
                    $recno = $recno + 1;
                    $linebuff = $linebuff . $rmbo_rec->rm . '|';
                    $linebuff = $linebuff . $rmbo_rec->npwp . '|';
                    $linebuff = $linebuff . $rmbo_rec->nama . '|';
                    $linebuff = $linebuff . $rmbo_rec->kd_jenis_transaksi . '|';
                    $linebuff = $linebuff . $rmbo_rec->fg_pengganti . '|';
                    $linebuff = $linebuff . $rmbo_rec->nomor_faktur . '|';
                    $linebuff = $linebuff . $rmbo_rec->tanggal_faktur . '|';
                    $linebuff = $linebuff . $rmbo_rec->is_creditable . '|';
                    $linebuff = $linebuff . $rmbo_rec->nomor_dokumen_retur . '|';
                    $linebuff = $linebuff . $rmbo_rec->tanggal_retur . '|';
                    $linebuff = $linebuff . $rmbo_rec->masa_pajak_retur . '|';
                    $linebuff = $linebuff . $rmbo_rec->tahun_pajak_retur . '|';
                    $linebuff = $linebuff . $rmbo_rec->nilai_retur_dpp . '|';
                    $linebuff = $linebuff . $rmbo_rec->nilai_retur_ppn . '|';
                    $linebuff = $linebuff
                        . $rmbo_rec->nilai_retur_ppnbm
                        . '|'
                        . CHR(13)
                        . CHR(10);
                }

            } else {
                $rmtr_recs = Self::RMTR_CUR($nodoc);

                foreach ($rmtr_recs as $rmtr_rec) {

                    $adaisi = true;
                    $recno = $recno + 1;
                    $linebuff = $linebuff . $rmtr_rec->rm . '|';
                    $linebuff = $linebuff . $rmtr_rec->npwp . '|';
                    $linebuff = $linebuff . $rmtr_rec->nama . '|';
                    $linebuff = $linebuff . $rmtr_rec->kd_jenis_transaksi . '|';
                    $linebuff = $linebuff . $rmtr_rec->fg_pengganti . '|';
                    $linebuff = $linebuff . $rmtr_rec->nomor_faktur . '|';
                    $linebuff = $linebuff . $rmtr_rec->tanggal_faktur . '|';
                    $linebuff = $linebuff . $rmtr_rec->is_creditable . '|';
                    $linebuff = $linebuff . $rmtr_rec->nomor_dokumen_retur . '|';
                    $linebuff = $linebuff . $rmtr_rec->tanggal_retur . '|';
                    $linebuff = $linebuff . $rmtr_rec->masa_pajak_retur . '|';
                    $linebuff = $linebuff . $rmtr_rec->tahun_pajak_retur . '|';
                    $linebuff = $linebuff . $rmtr_rec->nilai_retur_dpp . '|';
                    $linebuff = $linebuff . $rmtr_rec->nilai_retur_ppn . '|';
                    $linebuff =
                        $linebuff
                        . $rmtr_rec->nilai_retur_ppnbm
                        . '|'
                        . chr(13)
                        . chr(10);
                }
            }

            $temp = DB::select("SELECT COUNT(1) count
                   FROM TBTR_BACKOFFICE, TBMASTER_SUPPLIER
                  WHERE     TRBO_KODEIGR = :PARAMETER . KODEIGR
                    and TRBO_KODEIGR = SUP_KODEIGR
                    and TRBO_KODESUPPLIER = SUP_KODESUPPLIER
                    and SUP_PKP = 'Y'
                    and TRBO_NODOC = " . $nodocbo)[0]->count;

            if ($reprint == '0' && $temp > 0) {

                DB::table('TBHISTORY_FAKTURRM')->where('FRM_KODEIGR', '=', $_SESSION['kdigr'])->where('frm_nodocbo', '=', $nodocbo)->delete();

                DB::insert(" INSERT INTO TBHISTORY_FAKTURRM (FRM_KODEIGR,
                                            FRM_NODOCBO,
                                            FRM_TGLBO,
                                            FRM_REFERENSIFP,
                                            FRM_CREATE_BY,
                                            FRM_CREATE_DT)
                    SELECT TRBO_KODEIGR,TRBO_NODOC,TRBO_TGLDOC,
                      TRBO_ISTYPE . '.' . TRBO_INVNO,
                      '" . $_SESSION['usid'] . "'
                      SYSDATE
                 FROM TBTR_BACKOFFICE, TBMASTER_SUPPLIER
                WHERE     TRBO_KODEIGR = '" . $_SESSION['kdigr'] . "'
                and TRBO_KODEIGR = SUP_KODEIGR
                and TRBO_KODESUPPLIER = SUP_KODESUPPLIER
                and SUP_PKP = 'Y'
                and TRBO_NODOC = '" . $nodocbo . "'");
            }

        }

        $filename = 'RM.'.$_SESSION['kdigr'].'.csv';

        $headers = [
            "Content-type" => "text/csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];
        $file = fopen($filename, 'w');
        fputcsv($file, $linebuff, '|');
        fclose($file);
        return response()->download($filename, $filename, $headers)->deleteFileAfterSend(true);

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
                       SUBSTR(TRBO_ISTYPE, 1, 2) KD_JENIS_TRANSAKSI,
                       SUBSTR(TRBO_ISTYPE, 3, 1) FG_PENGGANTI,
                       REPLACE(SUBSTR(TRBO_ISTYPE . TRBO_INVNO, 5), '-', '')
                          NOMOR_FAKTUR,
                       TO_CHAR(TRBO_TGLINV, 'dd/MM/yyyy') TANGGAL_FAKTUR,
                       '1' IS_CREDITABLE,
                          PRS_KODEMTO
                          . '.'
                          . TO_CHAR(TRBO_TGLFAKTUR, 'YY')
                          . '.0'
                          . SUBSTR(TRBO_NOFAKTUR, 2, 7)
                          NOMOR_DOKUMEN_RETUR,
                       TO_CHAR(TRBO_TGLFAKTUR, 'dd/MM/yyyy') TANGGAL_RETUR,
                       TO_NUMBER(TO_CHAR(TRBO_TGLFAKTUR, 'MM'))
                          MASA_PAJAK_RETUR,
                       TO_NUMBER(TO_CHAR(TRBO_TGLFAKTUR, 'yyyy'))
                          TAHUN_PAJAK_RETUR,
                       (TRBO_GROSS - (bpb_discrph * trbo_qty)) NILAI_RETUR_DPP,
                       (TRBO_GROSS - (bpb_discrph * trbo_qty)) * 0.1
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
                 WHERE     TRBO_KODEIGR = '" . $_SESSION['kdigr'] . "'
                and TRBO_KODEIGR = PRS_KODEIGR
                and TRBO_KODEIGR = PRD_KODEIGR
                and TRBO_PRDCD = PRD_PRDCD
                and NVL(PRD_FLAGBKP1, 'N') = 'Y'
                and NVL(PRD_FLAGBKP2, 'N') = 'Y'
                and TRBO_KODEIGR = SUP_KODEIGR
                and TRBO_KODESUPPLIER = SUP_KODESUPPLIER
                and SUP_PKP = 'Y'
                and TRBO_KODEIGR = CONST_KODEIGR(+)
                and SUBSTR(CONST_BRANCH(+), 1, 1) = 'O'
                and trbo_noreff = bpb_nodoc
                and trbo_prdcd = bpb_prdcd
                and TRBO_NODOC = '" . $nodocbo . "')
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
               TAHUN_PAJAK_RETUR;");
        return $result;
    }

    public
    function RMTR_CUR(string $nodoctr)
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
                       REPLACE(SUBSTR(MSTD_ISTYPE . MSTD_INVNO, 5), '-', '')
                          NOMOR_FAKTUR,
                       TO_CHAR(MSTD_DATE3, 'dd/MM/yyyy') TANGGAL_FAKTUR,
                       '1' IS_CREDITABLE,
                          PRS_KODEMTO
                          . '.'
                          . TO_CHAR(MSTD_DATE2, 'YY')
                          . '.0'
                          . MSTD_DOCNO2
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
}
