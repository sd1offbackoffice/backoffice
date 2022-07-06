<?php

namespace App\Http\Controllers\BACKOFFICE\CETAKDOKUMEN;

use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Auth\loginController;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;
use PDF;
use Yajra\DataTables\DataTables;
use File;
use Illuminate\Support\Facades\File as FacadesFile;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class CetakDokumenController extends Controller
{
    public function index()
    {
        return view('BACKOFFICE.CETAKDOKUMEN.cetak-dokumen');
    }

    public function getDataSupplierByNodoc(Request $request)
    {

        $nodocs = $request->nodocs;
        $reprint = $request->reprint;

        if ($reprint == 'on') {
            $data = DB::connection(Session::get('connection'))->table('tbmaster_supplier')
            ->join('TBTR_MSTRAN_H', 'MSTH_KODESUPPLIER', '=', 'sup_kodesupplier')
            ->selectRaw('nvl(sup_namanpwp,sup_namasupplier || sup_singkatansupplier) nama_supplier,sup_kodesupplier')
            ->whereIn('msth_nodoc', $nodocs)
            ->get();
        } else {
            $data = DB::connection(Session::get('connection'))->table('tbmaster_supplier')
            ->join('TBTR_BACKOFFICE', 'sup_kodesupplier', '=', 'TRBO_KODESUPPLIER')
            ->selectRaw('nvl(sup_namanpwp,sup_namasupplier || sup_singkatansupplier) nama_supplier,sup_kodesupplier')
            ->whereIn('TRBO_NODOC', $nodocs)
            ->distinct()
            ->get();
        }


        // dd($data);
        return response()->json([
            'status' => 'SUCCESS',
            'message' => 'Successfully get Supplier data',
            'data' => $data
        ]);
    }

    public function testpdf()
    {
        $P_PN = " AND MSTH_NODOC IN (2222204277,2222204278) AND MSTH_TYPETRN='K'";
        $data1 = DB::connection(Session::get('connection'))->select("SELECT msth_nodoc, msth_tgldoc,
                                  CASE WHEN '" . 1 . "' = '1' THEN 'RE-PRINT' ELSE '' END AS STATUS,
                                  mstd_prdcd, mstd_unit, mstd_frac, mstd_qty, mstd_hrgsatuan,
                                  FLOOR(mstd_qty/mstd_frac) AS CTN, MOD(mstd_qty,mstd_frac) AS PCS, mstd_keterangan,
                                  mstd_gross, mstd_discrph, mstd_ppnrph, (NVL(mstd_gross,0) - NVL(mstd_discrph,0) + NVL(mstd_ppnrph,0)) AS TOTAL, msth_kodesupplier, msth_istype || msth_invno nofp, msth_tglinv,
                                  case when nvl(msth_kodesupplier,' ') <> ' ' then '( BARANG RETUR )' ELSE '( LAIN - LAIN )' end judul,prd_deskripsipanjang,
                                  prs_namaperusahaan, prs_namacabang, prs_npwp, prs_alamat1, prs_alamat3, prs_telepon,
                                 nvl(sup_namanpwp,sup_namasupplier || sup_singkatansupplier) namas, sup_npwp, NVL(SUP_ALAMATNPWP1,SUP_ALAMATSUPPLIER1) SUP_ALAMATSUPPLIER1,
                                 NVL(SUP_ALAMATNPWP2,SUP_ALAMATSUPPLIER2) SUP_ALAMATSUPPLIER2,
                                 NVL(SUP_ALAMATNPWP3,SUP_KOTASUPPLIER3) SUP_KOTASUPPLIER3, sup_telpsupplier, sup_contactperson, mstd_noref3
                    FROM TBTR_MSTRAN_H, TBTR_MSTRAN_D, TBMASTER_PRODMAST, TBMASTER_PERUSAHAAN, TBMASTER_SUPPLIER
                    WHERE MSTH_KODEIGR = '" . Session::get('kdigr') . "' AND
                                   MSTH_KODEIGR = MSTD_KODEIGR AND MSTH_NODOC = MSTD_NODOC AND
                                   MSTD_KODEIGR = PRD_KODEIGR AND MSTD_PRDCD = PRD_PRDCD AND
                                   MSTH_KODEIGR = PRS_KODECABANG AND
                                   MSTH_KODEIGR = SUP_KODEIGR(+) AND MSTH_KODESUPPLIER = SUP_KODESUPPLIER(+)
                                    " . $P_PN . "
                    ORDER BY MSTH_NODOC,MSTD_SEQNO");

        $data2 = DB::connection(Session::get('connection'))->select("select rownum, a.*
                                        from
                                        (SELECT DISTINCT MSTH_NODOC NODOC, MSTH_TGLDOC, MSTH_KODESUPPLIER, MSTD_ISTYPE || MSTD_INVNO NOFP,
                                                        MSTD_DATE3
                                                   FROM TBTR_MSTRAN_H,
                                                        TBTR_MSTRAN_D,
                                                        TBMASTER_PRODMAST,
                                                        TBMASTER_PERUSAHAAN,
                                                        TBMASTER_SUPPLIER
                                                  WHERE MSTH_KODEIGR = '" . Session::get('kdigr') . "'
                                                    AND MSTH_KODEIGR = MSTD_KODEIGR
                                                    AND MSTH_NODOC = MSTD_NODOC
                                                    AND MSTD_KODEIGR = PRD_KODEIGR
                                                    AND MSTD_PRDCD = PRD_PRDCD
                                                    AND MSTH_KODEIGR = PRS_KODECABANG
                                                    AND MSTH_KODEIGR = SUP_KODEIGR(+)
                                                    AND MSTH_KODESUPPLIER = SUP_KODESUPPLIER(+)
                                                    " . $P_PN . "
                                        ) a");
        $cw = 510;
        $ch = 77.5;
        $filename = 'cetak-surat-jalan';
        $perusahaan = DB::connection(Session::get('connection'))->table('tbmaster_perusahaan')
            ->first();
        $data = [
            'data1' => $data1,
            'data2' => $data2,
            'tgl1' => '01/05/2022',
            'tgl2' => '20/05/2022',
            'signatureId' => "62876f2e4f441",
            'signedBy' => "asd"
        ];
        $dompdf = new PDF();

        $pdf = PDF::loadview('BACKOFFICE.CETAKDOKUMEN.' . $filename . '-pdf', compact(['data', 'perusahaan']));

        error_reporting(E_ALL ^ E_DEPRECATED);

        $pdf->output();
        $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);

        $canvas = $dompdf->get_canvas();
        $canvas->page_text($cw, $ch, "{PAGE_NUM} dari {PAGE_COUNT}", null, 7, array(0, 0, 0));

        $dompdf = $pdf;

        return $dompdf->stream('coba.pdf');
    }

    public function saveSignature(Request $request)
    {
        $message = "";
        $status = "";
        $id = uniqid();
        try {
            $path = 'signature_expedition/';
            if (!FacadesFile::exists(storage_path($path))) {
                FacadesFile::makeDirectory(storage_path($path), 0755, true, true);
            }
            $img = $this->dataURLtoImage($request->signed);
            $file = storage_path($path . $id . '.' . $img['image_type']);
            file_put_contents($file, $img['image_base64']);
            $message = "Signature Successfully Saved!";
            $status = "SUCCESS";
        } catch (Exception $e) {
            $message = $e->getMessage();
            $status = "FAILED";
        }

        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => [
                'signatureId' => $id,
                'signedBy' => $request->signedBy,
            ]
        ]);
    }

    public function dataURLtoImage($value)
    {
        $image_parts = explode(";base64,", $value);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);
        return compact(['image_base64', 'image_type']);
    }

    // public function findKodeSupp(Request $request){
    //     $kode_supp = DB::connection(Session::get('connection'))->table('TBTR_BACKOFFICE')
    //                     ->select('TRBO_KODESUPPLIER')
    //                     ->where('TRBO')
    // }

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
                $recs = DB::connection(Session::get('connection'))->select("SELECT TRBO_NODOC,TRBO_TGLDOC
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
                    $recs = DB::connection(Session::get('connection'))->select("SELECT TRBO_NODOC,TRBO_TGLDOC
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
                    $recs = DB::connection(Session::get('connection'))->select("SELECT MSTH_NODOC,MSTH_TGLDOC
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
                $recs = DB::connection(Session::get('connection'))->select("SELECT TRBO_NODOC,TRBO_TGLDOC
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
                    $recs = DB::connection(Session::get('connection'))->select("SELECT TRBO_NODOC,TRBO_TGLDOC
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
                    $recs = DB::connection(Session::get('connection'))->select("SELECT MSTH_NODOC,MSTH_TGLDOC
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
        DB::connection(Session::get('connection'))->beginTransaction();
        if ($doc <> 'K' && $lap <> 'N') {
            $message = 'Button Create CSV Faktur hanya untuk Dokumen Keluaran yang sudah cetak List.';
            $status = 'info';
            return compact(['message', 'status']);
        }
        foreach ($nodocs as $nodoc) {
            if ($reprint == '0') {
                $temp = DB::connection(Session::get('connection'))->select("SELECT COUNT(1) count
                       FROM TBTR_BACKOFFICE, TBMASTER_PRODMAST, tbmaster_supplier
                      WHERE     TRBO_PRDCD = PRD_PRDCD
                            and trbo_kodesupplier = sup_kodesupplier
                            and TRBO_TYPETRN = 'K'
                            and TRBO_NODOC = '" . $nodoc . "'
                            and PRD_FLAGBKP1 = 'Y'
                            and PRD_FLAGBKP2 = 'Y'
                            and sup_pkp = 'Y'")[0]->count;
            } else {
                $temp = DB::connection(Session::get('connection'))->select("SELECT COUNT(1) count
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


                $recs = DB::connection(Session::get('connection'))->select("SELECT DISTINCT TRBO_INVNO INVNO, TRBO_NOFAKTUR
                     FROM TBTR_BACKOFFICE, tbmaster_prodmast, tbmaster_supplier
                    WHERE     trbo_prdcd = prd_prdcd
                and trbo_kodesupplier = sup_kodesupplier
                and TRBO_TYPETRN = 'K'
                and prd_flagbkp1 = 'Y'
                and sup_pkp = 'Y'
                and TRBO_NOFAKTUR IS NULL
                and TRBO_NODOC = '" . $nodocs[$i] . "'");

                foreach ($recs as $rec) {

                    $temp = DB::connection(Session::get('connection'))->select("SELECT COUNT(1) count
                         FROM TBTR_BACKOFFICE
                        WHERE     TRBO_TYPETRN = 'K'
                            and TRBO_NODOC = '" . $nodocs[$i] . "'
                            and TRBO_INVNO = '" . $rec->invno . "'
                            and trbo_nofaktur is not null")[0]->count;

                    if ($temp > 0) {
                        $nofak = DB::connection(Session::get('connection'))->select("SELECT distinct TRBO_NOFAKTUR
                                FROM TBTR_BACKOFFICE
                               WHERE     TRBO_TYPETRN = 'K'
                               and TRBO_NODOC = '" . $nodocs[$i] . "'
                               and TRBO_INVNO = '" . $rec->invno . "'
                               and trbo_nofaktur is not null")[0]->count;
                    } else {
                        $connect = loginController::getConnectionProcedure();


                        // $query = oci_parse($connect, "BEGIN :ret := f_igr_get_nomor('" . Session::get('kdigr') . "','NRB','Nomor Retur Barang','Z',7,true); END;");
                        $query = oci_parse($connect, "BEGIN :ret := f_igr_get_nomor('" . Session::get('kdigr') . "','NRB','Nomor Retur Barang','" . Session::get('kdigr') . "',7,true); END;");
                        oci_bind_by_name($query, ':ret', $nofak, 32);
                        oci_execute($query);
                    }

                    DB::connection(Session::get('connection'))->table('TBTR_BACKOFFICE')
                        ->where([
                            'TRBO_KODEIGR' => Session::get('kdigr'),
                            'TRBO_TYPETRN' => 'K',
                            'TRBO_NODOC' => $nodocs[$i],
                            'TRBO_INVNO' => $rec->invno

                        ])
                        ->update([
                            'TRBO_TGLFAKTUR' => DB::connection(Session::get('connection'))->raw("trunc(sysdate)"),
                            'TRBO_NOFAKTUR' => $nofak
                        ]);
                }
            } else {

                $tgldocbo = DB::connection(Session::get('connection'))->select("SELECT DISTINCT MSTH_TGLDOC MSTH_TGLDOC
                              FROM TBTR_MSTRAN_H
                             WHERE MSTH_NODOC = '" . $nodocs[$i] . "' and ROWNUM = 1")[0]->msth_tgldoc;
            }


//            if ($tgldocbo <> $tgldocs[$i]) {

//            -- HEADER'
                // array_push($linebuffs, ['RM', 'NPWP', 'NAMA', 'KD_JENIS_TRANSAKSI', 'FG_PENGGANTI', 'NOMOR_FAKTUR', 'TANGGAL_FAKTUR', 'IS_CREDITABLE', 'NOMOR_DOKUMEN_RETUR', 'TANGGAL_RETUR', 'MASA_PAJAK_RETUR', 'TAHUN_PAJAK_RETUR', 'NILAI_RETUR_DPP', 'NILAI_RETUR_PPN', 'NILAI_RETUR_PPNBM']);
//                $tgldoc = $tgldocbo;
//            }

            if ($reprint == '0') {
                $rmbo_recs = Self::RMBO_CUR($nodocs[$i]);

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
                $rmtr_recs = Self::RMTR_CUR($nodocs[$i]);

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

            $temp = DB::connection(Session::get('connection'))->select("SELECT COUNT(1) count
                   FROM TBTR_BACKOFFICE, TBMASTER_SUPPLIER
                  WHERE     TRBO_KODEIGR = '" . Session::get('kdigr') . "'
                    and TRBO_KODEIGR = SUP_KODEIGR
                    and TRBO_KODESUPPLIER = SUP_KODESUPPLIER
                    and SUP_PKP = 'Y'
                    and TRBO_NODOC = '" . $nodocbo . "'")[0]->count;

            if ($reprint == '0' && $temp > 0) {

                DB::connection(Session::get('connection'))->table('TBHISTORY_FAKTURRM')->where('FRM_KODEIGR', '=', Session::get('kdigr'))->where('frm_nodocbo', '=', $nodocbo)->delete();

                DB::connection(Session::get('connection'))
                    ->insert("INSERT INTO TBHISTORY_FAKTURRM (FRM_KODEIGR,
                                            FRM_NODOCBO,
                                            FRM_TGLBO,
                                            FRM_REFERENSIFP,
                                            FRM_CREATE_BY,
                                            FRM_CREATE_DT)
                    SELECT TRBO_KODEIGR,TRBO_NODOC,TRBO_TGLDOC,
                      TRBO_ISTYPE || '.' || TRBO_INVNO,
                      '" . Session::get('usid') . "',
                      SYSDATE
                 FROM TBTR_BACKOFFICE, TBMASTER_SUPPLIER
                WHERE TRBO_KODEIGR = '" . Session::get('kdigr') . "'
                and TRBO_KODEIGR = SUP_KODEIGR
                and TRBO_KODESUPPLIER = SUP_KODESUPPLIER
                and SUP_PKP = 'Y'
                and TRBO_NODOC = '" . $nodocbo . "'");
            }

        }
        DB::connection(Session::get('connection'))->commit();
        $filename = 'RM.' . Session::get('kdigr') .'_'.Carbon::now()->format('dmY_His'). '.csv';
        $columnHeader = [
            'RM',
            'NPWP',
            'NAMA',
            'KD_JENIS_TRANSAKSI',
            'FG_PENGGANTI',
            'NOMOR_FAKTUR',
            'TANGGAL_FAKTUR',
            'IS_CREDITABLE',
            'NOMOR_DOKUMEN_RETUR',
            'TANGGAL_RETUR',
            'MASA_PAJAK_RETUR',
            'TAHUN_PAJAK_RETUR',
            'NILAI_RETUR_DPP',
            'NILAI_RETUR_PPN',
            'NILAI_RETUR_PPNBM'
        ];

        $headers = [
            "Content-type" => "text/csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $file = fopen(storage_path($filename), 'w');
        fputcsv($file, $columnHeader, '|');
        foreach ($linebuffs as $linebuff) {
            fputcsv($file, $linebuff, '|');
        }
        fclose($file);
        return $filename;
    }

    public function donwloadCSVeFaktur(Request $request){
        $filename = $request->filename;
        return response()->download(storage_path($filename))->deleteFileAfterSend(true);
    }

    public function RMBO_CUR(string $nodocbo)
    {
        $result = DB::connection(Session::get('connection'))->select("SELECT RM,
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
                       REPLACE(SUBSTR(TRBO_ISTYPE || TRBO_INVNO, 5), '-', '')
                          NOMOR_FAKTUR,
                       TO_CHAR(TRBO_TGLINV, 'dd/MM/yyyy') TANGGAL_FAKTUR,
                       '1' IS_CREDITABLE,
                          PRS_KODEMTO
                          || '.'
                          || TO_CHAR(TRBO_TGLFAKTUR, 'YY')
                          || '.0'
                          || SUBSTR(TRBO_NOFAKTUR, 2, 7)
                          NOMOR_DOKUMEN_RETUR,
                       TO_CHAR(TRBO_TGLFAKTUR, 'dd/MM/yyyy') TANGGAL_RETUR,
                       TO_NUMBER(TO_CHAR(TRBO_TGLFAKTUR, 'MM'))
                          MASA_PAJAK_RETUR,
                       TO_NUMBER(TO_CHAR(TRBO_TGLFAKTUR, 'yyyy'))
                          TAHUN_PAJAK_RETUR,
                       (TRBO_GROSS - (bpb_discrph * trbo_qty)) NILAI_RETUR_DPP,
                       (TRBO_GROSS - (bpb_discrph * trbo_qty)) * (COALESCE(mstd_persenppn, 10)/100) NILAI_RETUR_PPN,
                       0 NILAI_RETUR_PPNBM
                  FROM TBTR_BACKOFFICE,
                       TBMASTER_SUPPLIER,
                       TBMASTER_CONST,
                       TBMASTER_PERUSAHAAN,
                       TBMASTER_PRODMAST,
                       (SELECT mstd_nodoc bpb_nodoc,
                               mstd_prdcd bpb_prdcd,mstd_persenppn,
                               mstd_discrph / mstd_qty bpb_discrph
                          FROM tbtr_mstran_d
                         WHERE mstd_typetrn = 'B')
                 WHERE     TRBO_KODEIGR = '" . Session::get('kdigr') . "'
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
               TAHUN_PAJAK_RETUR");
        return $result;
    }

    public function RMTR_CUR(string $nodoctr)
    {
        $result = DB::connection(Session::get('connection'))->select("SELECT RM,
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
                       (MSTD_GROSS - (bpb_discrph * mstd_qty)) * (COALESCE(mstd_persenppn, 10)/100) NILAI_RETUR_PPN,
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
                 WHERE     MSTD_KODEIGR = '" . Session::get('kdigr') . "'
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

        $file = [];
        $doc = $request->doc;
        $lap = $request->lap;
        $reprint = $request->reprint;
        $tgl1 = $request->tgl1;
        $tgl2 = $request->tgl2;
        $kertas = $request->kertas;
        $nrfp = $request->nrfp;
        $namattd = $request->namattd;
        $jabatan1 = $request->jbt1;
        $jabatan2 = $request->jbt2;
        $data = $request->data;

        // $signatureId = $request->signatureId;
        // $signedBy = $request->signedBy;
        $arrSuppSig = $request->arrSuppSig;


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
                    $temp = $temp . $nodoc . ',';
                    array_push($sub_isi_docno, $nodoc);
                }
            } else {
                $tmp = DB::connection(Session::get('connection'))->select("SELECT COUNT(1) count
                              FROM TBMASTER_CABANG
                             WHERE CAB_KODECABANG = '" . Session::get('kdigr') . "'
                                    and NVL(CAB_EFAKTUR, 'N') = 'Y'")[0]->count;

                if ($tmp > 0) {
                    if ($reprint == 0) {
                        $efaktur = true;

                        foreach ($nodocs as $nodoc) {
                            $tmp = DB::connection(Session::get('connection'))->select("SELECT COUNT(1) count
                          FROM TBTR_BACKOFFICE, TBMASTER_PRODMAST, tbmaster_supplier
                         WHERE     TRBO_PRDCD = PRD_PRDCD
                        and trbo_kodesupplier = sup_kodesupplier
                        and TRBO_TYPETRN = 'K'
                        and TRBO_NODOC = '" . $nodoc . "'
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

                        $tmp = DB::connection(Session::get('connection'))->select("SELECT COUNT(1) count
                                   FROM TBTR_BACKOFFICE, TBMASTER_PRODMAST, TBMASTER_SUPPLIER
                                  WHERE TRBO_PRDCD = PRD_PRDCD
                                  and TRBO_TYPETRN = 'K'
                                    and TRBO_NODOC = '" . $nodocs[$i] . "'
                                    and NVL(PRD_FLAGBKP1, 'N') = 'Y'
                                    and NVL(PRD_FLAGBKP2, 'N') = 'Y'")[0]->count;


                        if ($tmp > 0) {
                            $f_docbkp = 'Y';

                            $connect = loginController::getConnectionProcedure();

                            $query = oci_parse($connect, "BEGIN :ret := F_IGR_GET_NOMOR('" . Session::get('kdigr') . "',
                                 'NPB',
                                 'Nomor Pengeluaran Barang',
                                 '2' || TO_CHAR(SYSDATE, 'yy'),
                                 5,
                                 true); END;");
                            oci_bind_by_name($query, ':ret', $nodocbkp, 32);
                            oci_execute($query);
                            $nodocbkp = Session::get('kdigr').$nodocbkp;
                        }

                        $tmp = DB::connection(Session::get('connection'))->select("SELECT COUNT(1) count
                               FROM TBTR_BACKOFFICE, TBMASTER_PRODMAST
                              WHERE     TRBO_PRDCD = PRD_PRDCD
                                and TRBO_TYPETRN = 'K'
                                and TRBO_NODOC = '" . $nodocs[$i] . "'
                                and (NVL(PRD_FLAGBKP1, 'N') <> 'Y' OR NVL(PRD_FLAGBKP2, 'N') <> 'Y')")[0]->count;


                        if ($tmp > 0) {
                            $f_docbtkp = 'Y';

                            $connect = loginController::getConnectionProcedure();
                            $query = oci_parse($connect, "BEGIN :ret :=  F_IGR_GET_NOMOR('" . Session::get('kdigr') . "',
                                 'NPB',
                                 'Nomor Pengeluaran Barang',
                                 '2' || TO_CHAR(SYSDATE, 'yy'),
                                 5,
                                 true); END;");
                            oci_bind_by_name($query, ':ret', $nodocbtkp, 32);
                            oci_execute($query);
                            $nodocbtkp = Session::get('kdigr').$nodocbtkp;


                        }
                        $recs = DB::connection(Session::get('connection'))->select("SELECT DISTINCT TRBO_INVNO INVNO, TRBO_NOFAKTUR
                              FROM TBTR_BACKOFFICE, TBMASTER_PRODMAST
                             WHERE     TRBO_PRDCD = PRD_PRDCD
                        and PRD_FLAGBKP1 = 'Y'
                        and PRD_FLAGBKP2 = 'Y'
                        and TRBO_TYPETRN = 'K'
                        and TRBO_NODOC = '" . $nodocs[$i] . "'");
                        foreach ($recs as $rec) {

                            $tmp = DB::connection(Session::get('connection'))->select("SELECT COUNT(1) count
                          FROM TBMASTER_CABANG
                         WHERE CAB_KODECABANG = '" . Session::get('kdigr') . "'
                         and NVL(CAB_EFAKTUR, 'N') = 'Y'")[0]->count;


                            if ($tmp > 0) {
                                $nofak = $rec->trbo_nofaktur;
                            } else {

                                $connect = loginController::getConnectionProcedure();
                                // $query = oci_parse($connect, "BEGIN :ret :=  F_IGR_GET_NOMOR('" . Session::get('kdigr') . "','NRB','Nomor Retur Barang','',7,true); END;");
                                $query = oci_parse($connect, "BEGIN :ret :=  F_IGR_GET_NOMOR('" . Session::get('kdigr') . "','NRB','Nomor Retur Barang','" . Session::get('kdigr') . "',7,true); END;");
                                oci_bind_by_name($query, ':ret', $nofak, 32);
                                oci_execute($query);
                            }

//                        getnofp_tab(i).nofak = substr(nofak, 2, 7);
                        }


                        if ($f_docbkp == 'Y') {
                            $temp = $temp . $nodocbkp . ",";
                        }

                        if ($f_docbtkp == 'Y') {
                            $temp = $temp . $nodocbtkp . ',';
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

                        $recs = DB::connection(Session::get('connection'))->select("SELECT *
                             FROM TBTR_BACKOFFICE,
                                   TBMASTER_PRODMAST,
                                   TBMASTER_STOCK,
                                   TBMASTER_SUPPLIER
                             WHERE TRBO_NODOC = '" . $nodocs[$i] . "'
                        and TRBO_KODEIGR = PRD_KODEIGR
                        and TRBO_PRDCD = PRD_PRDCD
                        and TRBO_KODEIGR = ST_KODEIGR(+)
                        and TRBO_PRDCD = ST_PRDCD(+)
                        and '02' = ST_LOKASI(+)
                        and TRBO_KODEIGR = SUP_KODEIGR(+)
                        and TRBO_KODESUPPLIER =
                            SUP_KODESUPPLIER(+)
                        and TRBO_KODEIGR = '" . Session::get('kdigr') . "'
                        and TRBO_TYPETRN = 'K'");

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

                            if (isset($rec->TRBO_INVNO) ? $rec->TRBO_INVNO : ' ' == ' ') {
                                $nofp = '';
                            } else {
//                            GETNOFP_IDX = GETNOFP_TAB . FIRST;

//                            foreach () {
//                                STEP = 3005;
//                                exit WHEN GETNOFP_IDX IS NULL;
//                              STEP = 3002;
//
//                              if GETNOFP_TAB(GETNOFP_IDX) . INVNO =
//                                  $rec->TRBO_INVNO {
//                                  STEP = 3003;
//                                  NOFAK = GETNOFP_TAB(GETNOFP_IDX) . NOFAK;
//                              }
//
//                              STEP = 3004;
//                              GETNOFP_IDX = GETNOFP_TAB . NEXT(GETNOFP_IDX);
//                           }


                                $nofp = $nofp . $nofak . ',';
                            }

                            $tmp = DB::connection(Session::get('connection'))->select("SELECT COUNT(1) count
                          FROM TBTR_MSTRAN_BTB, TBTR_KONVERSIPLU
                         WHERE     BTB_PRDCD = KVP_PLUOLD(+)
                                 and BTB_NODOC = '" . $rec->trbo_noreff . "'
                                 and (KVP_PLUOLD = '" . $rec->trbo_prdcd . "'
                                     or KVP_PLUNEW = '" . $rec->trbo_prdcd . "'
                                     or BTB_PRDCD = '" . $rec->trbo_prdcd . "')")[0]->count;

                            if ($tmp > 0) {
                                $res = DB::connection(Session::get('connection'))->select("SELECT BTB_FRAC, BTB_UNIT
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
                                $tmp = DB::connection(Session::get('connection'))->select("SELECT COUNT(1) count
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
                                    $res = DB::connection(Session::get('connection'))->select("SELECT BTB_FRAC, BTB_UNIT
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
                                    $res = DB::connection(Session::get('connection'))->select("SELECT PRD_FRAC, PRD_UNIT
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

                            DB::connection(Session::get('connection'))->insert("INSERT INTO TBTR_MSTRAN_D(MSTD_KODEIGR,
                                     MSTD_RECORDID,
                                     MSTD_TYPETRN,
                                     MSTD_NODOC,
                                     MSTD_TGLDOC,
                                     MSTD_DOCNO2,
                                     MSTD_DATE2,
                                     MSTD_ISTYPE,
                                     MSTD_INVNO,
                                     MSTD_DATE3,
                                     MSTD_KODESUPPLIER,
                                     MSTD_PKP,
                                     MSTD_SEQNO,
                                     MSTD_PRDCD,
                                     MSTD_KODEDIVISI,
                                     MSTD_KODEDEPARTEMENT,
                                     MSTD_KODEKATEGORIBRG,
                                     MSTD_BKP,
                                     MSTD_FOBKP,
                                     MSTD_UNIT,
                                     MSTD_FRAC,
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
                                     MSTD_CREATE_BY,
                                     MSTD_CREATE_DT,
                                     MSTD_MODifY_BY,
                                     MSTD_MODifY_DT,
                                     MSTD_NOREF3
                                      )
                                VALUES(
                                    '" . $rec->trbo_kodeigr . "',
                                    '" . $rec->trbo_recordid . "',
                                    '" . $doc . "',
                                          case
                                             WHEN '" . $f_plubkp . "' = 'Y'
                                             THEN
                                                 '" . $nodocbkp . "'
                                             ELSE
                                                '" . $nodocbtkp . "'
                                          END,
                                          TRUNC(SYSDATE),
                                          case
                                             WHEN NVL('" . $rec->trbo_invno . "', 'P') <> 'P'
                                             THEN
                                                 '" . $nofak . "'
                                          END,
                                          '" . $rec->trbo_tglfaktur . "',
                                          '" . $rec->trbo_istype . "',
                                          '" . $rec->trbo_invno . "',
                                          '" . $rec->trbo_tglinv . "',
                                          '" . $rec->trbo_kodesupplier . "',
                                          '" . $pkp . "',
                                          '" . $rec->trbo_seqno . "',
                                          '" . $rec->trbo_prdcd . "',
                                          '" . $rec->prd_kodedivisi . "',
                                          '" . $rec->prd_kodedepartement . "',
                                          '" . $rec->prd_kodekategoribarang . "',
                                          '" . $rec->prd_flagbkp1 . "',
                                          '" . $rec->prd_flagbkp2 . "',
                                          '" . $unit . "',
                                          '" . $frac . "',
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
                                          NULL,
                                          '" . $qtyst . "',
                                          '" . $rec->trbo_keterangan . "',
                                          '" . $rec->prd_kodetag . "',
                                          '" . Session::get('usid') . "',
                                          SYSDATE,
                                          '" . Session::get('usid') . "',
                                          SYSDATE,
                                          '" . $rec->trbo_noreff . "')");


                            $ada = DB::connection(Session::get('connection'))->select("SELECT COUNT(1) count
                                  FROM TBTR_MSTRAN_BTB
                                 WHERE BTB_KODEIGR = '" . Session::get('kdigr') . "'
                                     and BTB_NODOC = '" . $rec->trbo_noreff . "'
                                     and BTB_PRDCD = '" . $rec->trbo_prdcd . "'")[0]->count;


                            if ($ada == 0) {
                                $tmp = DB::connection(Session::get('connection'))->select("SELECT COUNT(1) count
                                     FROM TBTR_KONVERSIPLU
                                    WHERE KVP_PLUNEW = '" . $rec->trbo_prdcd . "'")[0]->count;
                                if ($tmp == 0) {
                                    $qtypb = 9999999999;
                                } else {
                                    $qtypb = DB::connection(Session::get('connection'))->select("SELECT BTB_QTY count
                                    FROM TBTR_MSTRAN_BTB
                                   WHERE     BTB_KODEIGR = '" . Session::get('kdigr') . "'
                                   and BTB_NODOC = '" . $rec->trbo_noreff . "'
                                   and BTB_PRDCD IN(SELECT KVP_PLUOLD
                                     FROM TBTR_KONVERSIPLU
                                    WHERE KVP_PLUNEW = '" . $rec->trbo_prdcd . "')")[0]->count;
                                }
                            } else {
                                $qtypb = DB::connection(Session::get('connection'))->select("SELECT BTB_QTY count
                                 FROM TBTR_MSTRAN_BTB
                                WHERE     BTB_KODEIGR = '" . Session::get('kdigr') . "'
                                and BTB_NODOC = '" . $rec->trbo_noreff . "'
                                and BTB_PRDCD = '" . $rec->trbo_prdcd . "'")[0]->count;

                            }

                            DB::connection(Session::get('connection'))->insert("INSERT
                          INTO TBHISTORY_RETURSUPPLIER(HSR_KODEIGR,
                                                 HSR_NODOC,
                                                 HSR_KODESUPPLIER,
                                                 HSR_PRDCD,
                                                 HSR_REFNOPAJAK,
                                                 HSR_HRGSATUAN,
                                                 HSR_QTYPB,
                                                 HSR_QTYRETUR,
                                                 HSR_CREATE_BY,
                                                 HSR_CREATE_DT,
                                                 HSR_REFBPB)
                           VALUES(
                                      '" . Session::get('kdigr') . "',
                                     case
                                        WHEN '" . $f_plubkp . "' = 'Y' THEN
                                             '" . $nodocbkp . "'
                                        ELSE
                                             '" . $nodocbtkp . "'
                                     END,
                                     '" . $rec->trbo_kodesupplier . "',
                                     '" . $rec->trbo_prdcd . "',
                                     '" . $rec->trbo_invno . "',
                                     '" . $rec->trbo_hrgsatuan . "',
                                     NVL(" . $qtypb . ", 0),
                                     '" . $rec->trbo_qty . "',
                                      '" . Session::get('usid') . "',
                                     SYSDATE,
                                     '" . $rec->trbo_noreff . "')");


                            $connect = loginController::getConnectionProcedure();


                            $query = oci_parse($connect, "BEGIN  SP_IGR_UPDATE_STOCK2('" . Session::get('kdigr') . "',
                            '02',
                            '" . $rec->trbo_prdcd . "',
                            ' ',
                            'TRFOUT',
                            " . $rec->trbo_qty . ",
                            " . $lcostst . ",
                            " . $acostst . ",
                            '" . Session::get('usid') . "',
                            :v_lok,
                            :v_message); END;");
                            oci_bind_by_name($query, ':v_lok', $v_lok, 100);
                            oci_bind_by_name($query, ':v_message', $v_message, 100);

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
                            DB::connection(Session::get('connection'))->insert("INSERT INTO TBTR_MSTRAN_H
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
                             VALUES('" . Session::get('kdigr') . "',
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
                                  '" . Session::get('usid') . "',
                                 SYSDATE,
                                  '" . Session::get('usid') . "',
                                 SYSDATE)");

                        }

                        if ($f_docbtkp == 'Y') {
                            DB::connection(Session::get('connection'))->insert("INSERT INTO TBTR_MSTRAN_H(MSTH_KODEIGR,
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
                             VALUES('" . Session::get('kdigr') . "',
                                 '',
                                 '" . $doc. "',
                                 $nodocbtkp,
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
                                 '" . Session::get('usid') . "',
                                 SYSDATE,
                                 '" . Session::get('usid') . "',
                                 SYSDATE)");
                        }
                        DB::connection(Session::get('connection'))->update("UPDATE TBTR_BACKOFFICE
                        SET TRBO_NONOTA = '" . $nodocbkp . "',
                            TRBO_TGLNOTA = TRUNC(SYSDATE),
                            TRBO_RECORDID = '2',
                            TRBO_FLAGDOC = '*'
                      WHERE     TRBO_NODOC = '" . $nodocs[$i] . "'
                                             and TRBO_TYPETRN = 'K'
                                             and EXISTS
                                             (SELECT 1
                                      FROM TBMASTER_PRODMAST
                                     WHERE     PRD_PRDCD = TRBO_PRDCD
                                             and PRD_FLAGBKP1 = 'Y'
                                             and PRD_FLAGBKP2 = 'Y')");

                        DB::connection(Session::get('connection'))->update("UPDATE TBTR_BACKOFFICE
                        SET TRBO_NONOTA = '" . $nodocbtkp . "',
                            TRBO_TGLNOTA = TRUNC(SYSDATE),
                            TRBO_RECORDID = '2',
                            TRBO_FLAGDOC = '*'
                      WHERE     TRBO_NODOC = '" . $nodocs[$i] . "'
                                             and TRBO_TYPETRN = 'K'
                                             and EXISTS
                                             (SELECT 1
                                      FROM TBMASTER_PRODMAST
                                     WHERE     PRD_PRDCD = TRBO_PRDCD
                                             and (NVL(PRD_FLAGBKP1, 'N') <>
                                                 'Y'
                                                 or NVL(PRD_FLAGBKP2, 'N') <>
                                                 'Y'))");

                        DB::connection(Session::get('connection'))->update("update tbtr_usul_returlebih
												set usl_status = 'SUDAH CETAK NOTA'
										WHERE     usl_TRBO_NODOC = '" . $nodocs[$i] . "'");

                        if ($supcoht != "") {
                            $ada = DB::connection(Session::get('connection'))->select("SELECT NVL(COUNT(1), 0) count
                          FROM TBTR_HUTANG
                         WHERE     HTG_TYPE = 'D'
                         and HTG_KODEIGR = '" . Session::get('kdigr') . "'
                         and HTG_NODOKUMEN = '" . $nonpb . "'");


                            if ($ada == 0) {
                                $res = Self::PRD_CUR($pluht);
                                $pkp1 = $res[0]->prd_flagbkp1;
                                $pkp2 = $res[0]->prd_flagbkp2;

                                if ($f_docbkp == 'Y') {
                                    DB::connection(Session::get('connection'))->insert("INSERT INTO TBTR_HUTANG(HTG_KODEIGR,
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
                                   VALUES('" . Session::get('kdigr') . "'
                                       'D',
                                       '" . $supcoht . "',
                                        '" . $nodocbkp . "',
                                       SYSDATE,
                                       '" . $tglht . "',
                                       '" . $nilht . "',
                                       '" . $nilppn . "',
                                       '" . $nilsal . "',
                                       '" . $pkp1 . "',
                                       '" . $pkp2 . "',
                                       '" . Session::get('usid') . "',
                                       SYSDATE,
                                       '" . Session::get('usid') . "',
                                       SYSDATE,
                                       '" . $nodocs[$i] . "',
                                       '" . $tgldocs[$i] . "')");

                                }

                                if ($f_docbtkp == 'Y') {
                                    DB::connection(Session::get('connection'))->insert("INSERT INTO TBTR_HUTANG(HTG_KODEIGR,
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
                                   VALUES('" . Session::get('kdigr') . "',
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
                                       '" . Session::get('usid') . "',
                                       SYSDATE,
                                       '" . Session::get('usid') . "',
                                       SYSDATE,
                                       '" . $nodocs[$i] . "',
                                       '" . $tgldocs[$i] . "')");

                                }
                            }
                        }
                    } else {
                        $temp = $temp . $nodocs[$i] . ',';
                        $nofak = DB::connection(Session::get('connection'))->select("SELECT msth_nofaktur
                       FROM TBTR_MSTRAN_H
                      WHERE     MSTH_NODOC =  '" . $nodocs[$i] . "'
                                         and MSTH_TYPETRN = 'K'
                                         and MSTH_KODEIGR = '" . Session::get('kdigr') . "'")[0]->msth_nofaktur;


                        $nofp = $nofp . $nofak . ',';
                    }
                }
            }

            $temp = substr($temp, 0, strlen($temp) - 1);
            // var_dump($temp);
            if (isset($temp)) {
                array_push($file, Self::PRINT_DOC(Session::get('kdigr'), $temp, $doc, $lap, $kertas, $reprint, $tgl1, $tgl2, $arrSuppSig));

                if ($lap != 'L') {
                    array_push($file, Self::printSuratJalan(Session::get('kdigr'), $temp, $doc, $lap, $kertas, $reprint, $tgl1, $tgl2, $arrSuppSig));
                }


                if ($nrfp == 1) {
                    if (isset($nofp)) {
                        foreach ($nodocs as $nodoc) {
                            $nofp = trim(substr($nofp, 0, strlen($nofp) - 1));

                            if ($reprint == '0') {

                                $tmp = DB::connection(Session::get('connection'))->SELECT("SELECT COUNT(1) count
                          FROM TBTR_BACKOFFICE, TBMASTER_SUPPLIER
                         WHERE     TRBO_NODOC = '" . $nodoc . "'
                            and TRBO_KODEIGR = SUP_KODEIGR(+)
                            and TRBO_INVNO <> 'P'
                            and TRBO_KODESUPPLIER = SUP_KODESUPPLIER(+)")[0]->count;

                                if ($tmp > 0) {
                                    $res = DB::connection(Session::get('connection'))->SELECT("SELECT DISTINCT NVL(SUP_PKP, 'N') pkp, TRBO_NONOTA nonota
                             FROM TBTR_BACKOFFICE, TBMASTER_SUPPLIER
                            WHERE     TRBO_NODOC = '" . $nodoc . "'
                            and TRBO_KODEIGR = SUP_KODEIGR(+)
                            and TRBO_INVNO <> 'P'
                            and TRBO_KODESUPPLIER = SUP_KODESUPPLIER(+)");

                                    $pkp = $res[0]->pkp;
                                    $nonota = $res[0]->nonota;

                                    if ($pkp == 'Y') {

                                        $tmp = DB::connection(Session::get('connection'))->SELECT("SELECT COUNT(1) count
                                FROM TBTR_BACKOFFICE, TBMASTER_PRODMAST
                               WHERE     TRBO_PRDCD = PRD_PRDCD
                               and TRBO_TYPETRN = 'K'
                               and TRBO_NODOC = '" . $nodoc . "'
                               and PRD_FLAGBKP1 = 'Y'
                               and PRD_FLAGBKP2 = 'Y'")[0]->count;

                                        if ($tmp > 0) {
                                            array_push($file, Self::CETAK_BARU($nonota, $reprint, $namattd, $jabatan1, $jabatan2));
                                        }
                                    }
                                }
                            } else {
                                $pkp = DB::connection(Session::get('connection'))->SELECT("SELECT DISTINCT NVL(MSTD_PKP, 'N') pkp
                          FROM TBTR_MSTRAN_D
                         WHERE MSTD_NODOC = '" . $nodoc . "'
                            and MSTD_TYPETRN = 'K'
                            and MSTD_KODEIGR = '" . Session::get('kdigr') . "' ")[0]->pkp;

                                if ($pkp == 'Y') {
                                    $pkp = DB::connection(Session::get('connection'))->SELECT("SELECT COUNT(1) count
                             FROM TBTR_MSTRAN_D, TBMASTER_PRODMAST
                            WHERE     MSTD_PRDCD = PRD_PRDCD
                            and MSTD_TYPETRN = 'K'
                            and MSTD_NODOC = '" . $nodoc . "'
                            and PRD_FLAGBKP1 = 'Y'
                            and PRD_FLAGBKP2 = 'Y'")[0]->count;

                                    if ($tmp > 0) {
                                        array_push($file, Self::CETAK_BARU($nodoc, $reprint, $namattd, $jabatan1, $jabatan2));

                                    }
                                }
                            }
                        }
                    }
                }

                if ($lap == 'L') {
                    if ($reprint == '0') {
                        foreach ($sub_isi_docno as $sub) {

                            DB::connection(Session::get('connection'))->update("UPDATE TBTR_BACKOFFICE
                                SET TRBO_FLAGDOC = '1'
                              WHERE TRBO_NODOC = '" . $sub . "'
                            and TRBO_KODEIGR = '" . Session::get('kdigr') . "'");
                        }
                    } else {
                        foreach ($sub_isi_docno as $sub) {
                            DB::connection(Session::get('connection'))->table("TBTR_MSTRAN_H")
                                ->where([
                                    "MSTH_KODEIGR" => Session::get('kdigr'),
                                    "MSTH_TYPETRN" => $doc,
                                    "MSTH_NOPO" => $sub,
                                ])
                                ->update(["MSTH_FLAGDOC" => '1']);
                        }
                    }
                }
            }
        } else {
            if ($lap == 'L') {
                $sub_isi_docno = [];

                foreach ($nodocs as $nodoc) {
                    $temp = $temp . $nodoc . ',';
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


                            $query = oci_parse($connect, "BEGIN :ret := F_IGR_GET_NOMOR( '" . Session::get('kdigr') . "',
                             'NBH',
                             'Nomor Nota Barang Hilang',
                             '7' || TO_CHAR(SYSDATE, 'yy'),
                             5,
                             true); END;");
                            oci_bind_by_name($query, ':ret', $v_nodoc, 32);
                            oci_execute($query);

                            $temp = $temp . $v_nodoc . ',';

                            $recs = DB::connection(Session::get('connection'))->select("SELECT A .*, B .*
                                FROM TBTR_BACKOFFICE A, TBMASTER_PRODMAST B
                               WHERE     PRD_KODEIGR = TRBO_KODEIGR
                                        and PRD_PRDCD = TRBO_PRDCD
                                        and TRBO_NODOC = '" . $nodoc . "'
                                        and TRBO_TYPETRN = 'H'
                            ORDER BY TRBO_SEQNO");
                            foreach ($recs as $rec) {
                                $qtyst = 0;
                                $lcostst = 0;

                                $results = DB::connection(Session::get('connection'))->select("SELECT ST_SALDOAKHIR, ST_LASTCOST, ST_AVGCOST
                                                FROM TBMASTER_STOCK
                                                WHERE     ST_KODEIGR =  '" . $rec->trbo_kodeigr . "'
                                            and ST_PRDCD =
                                                SUBSTR( '" . $rec->trbo_prdcd . "', 1, 6) || '0'
                                            and ST_LOKASI = '0' ||  '" . $rec->trbo_flagdisc1 . "'");


                                $qtyst = $results[0]->st_saldoakhir;
                                $lcostst = $results[0]->st_lastcost;
                                $acostst = $results[0]->st_avgcost;
                                $pkp = ' ';

                                if ($rec->trbo_kodesupplier != '') {

                                    $pkp = DB::connection(Session::get('connection'))->select(" SELECT SUP_PKP
                                                FROM TBMASTER_SUPPLIER
                                            WHERE     SUP_KODEIGR = '" . Session::get('kdigr') . "'
                                                and SUP_KODESUPPLIER = '" . $rec->trbo_kodesupplier . "'")[0]->sup_pkp;
                                }
                                if ($pkp != 'Y') {
                                    $pkp = 'N';
                                }
                                DB::connection(Session::get('connection'))->insert("INSERT INTO TBTR_MSTRAN_D(MSTD_KODEIGR,
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
                                    '" . $rec->prd_kodedivisi . "',
                                    '" . $rec->prd_kodedepartement . "',
                                    '" . $rec->prd_kodekategoribarang . "',
                                    '" . $rec->prd_flagbkp1 . "',
                                    '" . $rec->prd_flagbkp2 . "',
                                    '" . $rec->prd_unit . "',
                                    '" . $rec->prd_frac . "',
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
                                    '" . $rec->prd_kodetag . "',
                                    '" . $rec->trbo_furgnt . "',
                                    '" . $pkp . "',
                                    '" . Session::get('usid') . "',
                                    SYSDATE)");

                                if ($doc == 'B') {
                                    $connect = loginController::getConnectionProcedure();

                                    $query = oci_parse($connect, "BEGIN  SP_IGR_UPDATE_STOCK2('" . Session::get('kdigr') . "','01','" . $rec->trbo_prdcd . "',' ','TRFIN'," . $rec->trbo_qty . "," . $lcostst . ",0,'" . Session::get('usid') . "',  , :v_message ); END;");
                                    oci_bind_by_name($query, ':v_lok', $v_lok, 32);
                                    oci_bind_by_name($query, ':v_message', $v_message, 32);
                                    oci_execute($query);

                                } else {
                                    if ($doc == 'K') {
                                        $connect = loginController::getConnectionProcedure();

                                        $query = oci_parse($connect, "BEGIN SP_IGR_UPDATE_STOCK2('" . Session::get('kdigr') . "','02','" . $rec->trbo_prdcd . "',' ','TRFOUT',$rec->trbo_qty," . $lcostst . "," . $acostst . ",'" . Session::get('usid') . "',:v_lok,:v_message); END;");
                                        oci_bind_by_name($query, ':v_lok', $v_lok, 32);
                                        oci_bind_by_name($query, ':v_message', $v_message, 32);
                                        oci_execute($query);

                                    } else {
                                        if ($doc == 'F') {
                                            $connect = loginController::getConnectionProcedure();

                                            $query = oci_parse($connect, "BEGIN  SP_IGR_UPDATE_STOCK2('" . Session::get('kdigr') . "','03','" . $rec->trbo_prdcd . "',' ','TRFOUT'," . $rec->trbo_qty . "," . $lcostst . ",0,'" . Session::get('usid') . "',:v_lok,:v_message); END;");
                                            oci_bind_by_name($query, ':v_lok', $v_lok, 32);
                                            oci_bind_by_name($query, ':v_message', $v_message, 32);
                                            oci_execute($query);

                                        } else {
                                            if ($doc == 'X') {
                                                $connect = loginController::getConnectionProcedure();

                                                $query = oci_parse($connect, "BEGIN  SP_IGR_UPDATE_STOCK2('" . Session::get('kdigr') . "',LPAD('" . $rec->trbo_flagdisc2 . "', 2, '0'),'" . $rec->trbo_prdcd . "',' ','ADJ'," . $rec->trbo_qty . "," . $lcostst . ",0,'" . Session::get('usid') . "',:v_lok,:v_message); END;");
                                                oci_bind_by_name($query, ':v_lok', $v_lok, 32);
                                                oci_bind_by_name($query, ':v_message', $v_message, 32);
                                                oci_execute($query);


                                            } else {
                                                if ($doc == 'H') {
                                                    $connect = loginController::getConnectionProcedure();

                                                    $query = oci_parse($connect, "BEGIN  SP_IGR_UPDATE_STOCK2('" . Session::get('kdigr') . "',LPAD('" . $rec->trbo_flagdisc1 . "', 2, '0'),'" . $rec->trbo_prdcd . "',' ','TRFOUT','" . $rec->trbo_qty . "'," . $lcostst . "," . $acostst . ",'" . Session::get('usid') . "',:v_lok,:v_message); END;");
                                                    oci_bind_by_name($query, ':v_lok', $v_lok, 32);
                                                    oci_bind_by_name($query, ':v_message', $v_message, 32);
                                                    oci_execute($query);


                                                } else {
                                                    if ($doc == 'P') {
                                                        if ($rec->trbo_flagdisc1 == 'P') {
                                                            $connect = loginController::getConnectionProcedure();
                                                            $query = oci_parse($connect, "BEGIN  SP_IGR_UPDATE_STOCK2('" . Session::get('kdigr') . "','01','" . $rec->trbo_prdcd . "',' ','TRFOUT'," . $rec->trbo_qty . "," . $lcostst . ",0,'" . Session::get('usid') . "',:v_lok,:v_message); END;");
                                                            oci_bind_by_name($query, ':v_lok', $v_lok, 32);
                                                            oci_bind_by_name($query, ':v_message', $v_message, 32);
                                                            oci_execute($query);

                                                        } else {
                                                            $connect = loginController::getConnectionProcedure();
                                                            $query = oci_parse($connect, "BEGIN  SP_IGR_UPDATE_STOCK2('" . Session::get('kdigr') . "','01','" . $rec->trbo_prdcd . "',' ','TRFIN'," . $rec->trbo_qty . "," . $lcostst . ",0,'" . Session::get('usid') . "',:v_lok,:v_message); END;");
                                                            oci_bind_by_name($query, ':v_lok', $v_lok, 32);
                                                            oci_bind_by_name($query, ':v_message', $v_message, 32);
                                                            oci_execute($query);

                                                        }
                                                    } else {
                                                        if ($doc == 'O') {
                                                            $connect = loginController::getConnectionProcedure();
                                                            $query = oci_parse($connect, "BEGIN  SP_IGR_UPDATE_STOCK2('" . Session::get('kdigr') . "','01','" . $rec->trbo_prdcd . "',' ','TRFOUT'," . $rec->trbo_qty . "," . $lcostst . ",0,'" . Session::get('usid') . "',:v_lok,:v_message); END;");
                                                            oci_bind_by_name($query, ':v_lok', $v_lok, 32);
                                                            oci_bind_by_name($query, ':v_message', $v_message, 32);
                                                            oci_execute($query);


                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                                $ada = DB::connection(Session::get('connection'))->Select("SELECT NVL(COUNT(1), 0) count
                                        FROM TBTR_MSTRAN_H
                                        WHERE MSTH_KODEIGR = '" . Session::get('kdigr') . "'
                                                and MSTH_TYPETRN = '" . $doc . "'
                                                and MSTH_NODOC = '" . $v_nodoc . "'")[0]->count;

                                if ($ada == 0) {

                                    DB::connection(Session::get('connection'))
                                        ->insert("INSERT INTO TBTR_MSTRAN_H(MSTH_KODEIGR,
                                            MSTH_TYPETRN,
                                            MSTH_NODOC,
                                            MSTH_TGLDOC,
                                            MSTH_FLAGDOC,
                                            MSTH_KODESUPPLIER,
                                            MSTH_CREATE_BY,
                                            MSTH_CREATE_DT)
                                            VALUES('" . Session::get('kdigr') . "',
                                                '" . $doc . "',
                                                '" . $v_nodoc . "',
                                                TRUNC(SYSDATE ),
                                                '1',
                                                '" . $rec->trbo_kodesupplier . "',
                                                '" . Session::get('usid') . "',
                                                SYSDATE)");
                                }

                            }


                            DB::connection(Session::get('connection'))
                                ->table('TBTR_BACKOFFICE')
                                ->where('TRBO_NODOC', '=', $nodoc)
                                ->where('TRBO_TYPETRN', '=', 'H')
                                ->update([
                                    'trbo_nonota' => $v_nodoc,
                                    'trbo_tglnota' => Carbon::now(),
                                    'trbo_recordid' => '2',
                                    'trbo_flagdoc' => '*'
                                ]);


                        } else {
                            $temp = $temp . $nodoc . ',';
                        }

                    }

                }
            }
            $temp = substr($temp, 0, strlen($temp) - 1);

            if ($temp != '') {
                array_push($file, Self::PRINT_DOC(Session::get('kdigr'), $temp, $doc, $lap, $kertas, $reprint, $tgl1, $tgl2, $arrSuppSig));

                // if ($lap != 'L') {
                //     array_push($file, Self::printSuratJalan(Session::get('kdigr'), $temp, $doc, $lap, $kertas, $reprint, $tgl1, $tgl2, $arrSuppSig));
                // }


                if ($lap == 'L') {
                    if ($reprint == '0') {
                        foreach ($nodocs as $nodoc) {

                            DB::connection(Session::get('connection'))->update("UPDATE TBTR_BACKOFFICE
                        SET TRBO_FLAGDOC = '1'
                      WHERE     TRBO_NODOC = '" . $nodoc . "'
                      and TRBO_KODEIGR = '" . Session::get('kdigr') . "'");
                        }
                    }
                } else {
                    foreach ($nodocs as $nodoc) {
                        DB::connection(Session::get('connection'))->update("UPDATE TBTR_MSTRAN_H
                     SET MSTH_FLAGDOC = '1'
                   WHERE     MSTH_KODEIGR = '" . Session::get('kdigr') . "'
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
        return $file;
    }

    public function PRD_CUR(string $plu)
    {
        $result = DB::connection(Session::get('connection'))->select("SELECT PRD_FLAGBKP1, PRD_FLAGBKP2 FROM TBMASTER_PRODMAST WHERE PRD_KODEIGR = '" . Session::get('kdigr') . "' AND PRD_PRDCD = '" . $plu . "' ");
        return $result;
    }

    public function printSuratJalan(string $KodeIGR, string $NoDoc, string $TypeDoc, string $TypeLap, string $JNSKERTAS, string $REPRINT, string $tgl1, string $tgl2, $arrSuppSig)
    {
        $data1 = '';
        $data2 = '';
        $filename = '';
        $cw = '';
        $ch = '';
        if ($TypeLap == 'L') {
        } else {
            switch ($TypeDoc) {
                case  'K' :
                    $P_PN = " AND MSTH_NODOC IN (" . $NoDoc . ") AND MSTH_TYPETRN='K'";
                    $data1 = DB::connection(Session::get('connection'))->select("SELECT msth_nodoc, to_char(msth_tgldoc,'yyyymmdd') msth_tgldoc,
                                  CASE WHEN '" . $REPRINT . "' = '1' THEN 'RE-PRINT' ELSE '' END AS STATUS,
                                  mstd_prdcd, mstd_unit, mstd_frac, mstd_qty, mstd_hrgsatuan,
                                  FLOOR(mstd_qty/mstd_frac) AS CTN, MOD(mstd_qty,mstd_frac) AS PCS, mstd_keterangan,
                                  mstd_gross, mstd_discrph, mstd_ppnrph, (NVL(mstd_gross,0) - NVL(mstd_discrph,0) + NVL(mstd_ppnrph,0)) AS TOTAL, msth_kodesupplier, msth_istype || msth_invno nofp, msth_tglinv,
                                  case when nvl(msth_kodesupplier,' ') <> ' ' then '( BARANG RETUR )' ELSE '( LAIN - LAIN )' end judul,prd_deskripsipanjang,
                                  prs_namaperusahaan, prs_namacabang, prs_npwp, prs_alamat1, prs_alamat3, prs_telepon,
                                 nvl(sup_namanpwp,sup_namasupplier || sup_singkatansupplier) namas, sup_npwp, NVL(SUP_ALAMATNPWP1,SUP_ALAMATSUPPLIER1) SUP_ALAMATSUPPLIER1,
                                 NVL(SUP_ALAMATNPWP2,SUP_ALAMATSUPPLIER2) SUP_ALAMATSUPPLIER2,
                                 NVL(SUP_ALAMATNPWP3,SUP_KOTASUPPLIER3) SUP_KOTASUPPLIER3, sup_telpsupplier, sup_contactperson, mstd_noref3
                    FROM TBTR_MSTRAN_H, TBTR_MSTRAN_D, TBMASTER_PRODMAST, TBMASTER_PERUSAHAAN, TBMASTER_SUPPLIER
                    WHERE MSTH_KODEIGR = '" . Session::get('kdigr') . "' AND
                                   MSTH_KODEIGR = MSTD_KODEIGR AND MSTH_NODOC = MSTD_NODOC AND
                                   MSTD_KODEIGR = PRD_KODEIGR AND MSTD_PRDCD = PRD_PRDCD AND
                                   MSTH_KODEIGR = PRS_KODECABANG AND
                                   MSTH_KODEIGR = SUP_KODEIGR(+) AND MSTH_KODESUPPLIER = SUP_KODESUPPLIER(+)
                                    " . $P_PN . "
                    ORDER BY MSTH_NODOC,MSTD_SEQNO");

                    $data2 = DB::connection(Session::get('connection'))->select("select rownum, a.*
                                        from
                                        (SELECT DISTINCT MSTH_NODOC NODOC, MSTH_TGLDOC, MSTH_KODESUPPLIER, MSTD_ISTYPE || MSTD_INVNO NOFP,
                                                        MSTD_DATE3
                                                   FROM TBTR_MSTRAN_H,
                                                        TBTR_MSTRAN_D,
                                                        TBMASTER_PRODMAST,
                                                        TBMASTER_PERUSAHAAN,
                                                        TBMASTER_SUPPLIER
                                                  WHERE MSTH_KODEIGR = '" . Session::get('kdigr') . "'
                                                    AND MSTH_KODEIGR = MSTD_KODEIGR
                                                    AND MSTH_NODOC = MSTD_NODOC
                                                    AND MSTD_KODEIGR = PRD_KODEIGR
                                                    AND MSTD_PRDCD = PRD_PRDCD
                                                    AND MSTH_KODEIGR = PRS_KODECABANG
                                                    AND MSTH_KODEIGR = SUP_KODEIGR(+)
                                                    AND MSTH_KODESUPPLIER = SUP_KODESUPPLIER(+)
                                                    " . $P_PN . "
                                        ) a");
                    if ($JNSKERTAS == 'B') {
                        $cw = 510;
                        $ch = 78;
                        $filename = 'cetak-surat-jalan';
                    } else {
                        $cw = 510;
                        $ch = 78;
                        $filename = 'cetak-surat-jalan';
                    }
                    break;
            }
        }

        $perusahaan = DB::connection(Session::get('connection'))->table('tbmaster_perusahaan')
            ->first();
            $data = [
                'data1' => $data1,
                'data2' => $data2,
                'tgl1' => $tgl1,
                'tgl2' => $tgl2,
                'reprint' => $REPRINT,
                'arrSuppSig' => $arrSuppSig,
                'filename' => $filename,
                'perusahaan' => $perusahaan
            ];

            $dompdf = new PDF();

            $pdf = PDF::loadview('BACKOFFICE.CETAKDOKUMEN.' . $filename . '-pdf', compact(['data', 'perusahaan']));

            error_reporting(E_ALL ^ E_DEPRECATED);

            $pdf->output();
            $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);

            $canvas = $dompdf->get_canvas();
            $canvas->page_text($cw, $ch, "{PAGE_NUM} dari {PAGE_COUNT}", null, 7, array(0, 0, 0));

            $dompdf = $pdf;
            // $filenames = $filename . '.pdf';

            // $path = 'surat_jalan/';
            // if (!FacadesFile::exists(storage_path($path))) {
            //     FacadesFile::makeDirectory(storage_path($path), 0755, true, true);
            // }
            // $nodocs = '';
            // $splitedNodoc = explode(',', $NoDoc);
            // foreach ($splitedNodoc as $nodoc) {
            //     $nodocs .= $nodoc . '_';
            // }
            // $filenames = 'SJ_'. $nodocs . $data1[0]->msth_tgldoc;
            // $file = storage_path($path . $filenames . '.pdf');

            // file_put_contents($file, $pdf->output());

            $nodocs = '';
            $splitedNodoc = explode(',', $NoDoc);
            foreach ($splitedNodoc as $nodoc) {
                $nodocs .= $nodoc . '_';
            }

            if ($REPRINT == '0') {
                $path = 'surat_jalan/';
                $filenames = 'SJ_'. $nodocs . $data1[0]->msth_tgldoc;
            } else {
                $path = 'reprint/';
                $filenames = 'REPRINT_SJ_' . $nodocs . $data1[0]->msth_tgldoc;
            }

            if (!FacadesFile::exists(storage_path($path))) {
                FacadesFile::makeDirectory(storage_path($path), 0755, true, true);
            }

            $file = storage_path($path . $filenames . '.PDF');

            file_put_contents($file, $pdf->output());

            return $filenames;
            // return $data;

            // return view('BACKOFFICE.CETAKDOKUMEN.' . $filename . '-pdf', compact(['data', 'perusahaan']));

    }

    public function PRINT_DOC(string $KodeIGR, string $NoDoc, string $TypeDoc, string $TypeLap, string $JNSKERTAS, string $REPRINT, string $tgl1, string $tgl2, $arrSuppSig)
    {
        $data1 = '';
        $data2 = '';
        $filename = '';
        $cw = '';
        $ch = '';
        $path_backup = '';

        if ($TypeLap == 'L') {
            // L = List  N = Nota
            switch ($TypeDoc) {
                case  'B' :      // Penerimaan
                    null;
                    break;
                case  'K' :     // Pengeluaran data belum keluar
                    $cw = 510;
                    $ch = 78;
                    $filename = 'list-pengeluaran';
                    $P_PN = " AND TRBO_NODOC IN (" . $NoDoc . ") AND TRBO_TYPETRN='K'";
                    $data1 = DB::connection(Session::get('connection'))
                        ->select("SELECT   TRBO_NODOC, to_char(TRBO_TGLDOC,'yyyymmdd') TRBO_TGLDOC, TRBO_KODESUPPLIER, TRBO_ISTYPE, TRBO_INVNO, TRBO_TGLINV,
                                 TRBO_PRDCD, TRBO_HRGSATUAN, TRBO_KETERANGAN, TRBO_GROSS, TRBO_DISCRPH, TRBO_PPNRPH,
                                 CASE
                                     WHEN '" . $REPRINT . "' = '1'
                                         THEN 'RE-PRINT'
                                     ELSE ''
                                 END AS STATUS, TRBO_QTY, FLOOR (TRBO_QTY / BTB_FRAC) AS CTN,
                                 MOD (TRBO_QTY, BTB_FRAC) AS PCS,
                                 (NVL (TRBO_GROSS, 0) - NVL (TRBO_DISCRPH, 0) + NVL (TRBO_PPNRPH, 0)) AS TOTAL,
                                 PRD_DESKRIPSIPENDEK, BTB_UNIT, BTB_FRAC, SUP_NAMASUPPLIER, PRS_NAMAPERUSAHAAN,
                                 PRS_NAMACABANG, TRBO_NOREFF
                            FROM TBTR_BACKOFFICE, TBMASTER_PRODMAST, TBMASTER_SUPPLIER, TBMASTER_PERUSAHAAN,
                                 TBTR_MSTRAN_BTB
                           WHERE TRBO_KODEIGR = '" . Session::get('kdigr') . "'
                                      " . $P_PN . "
                             AND PRD_KODEIGR = TRBO_KODEIGR
                             AND PRD_PRDCD = TRBO_PRDCD
                             AND SUP_KODEIGR(+) = TRBO_KODEIGR
                             AND SUP_KODESUPPLIER(+) = TRBO_KODESUPPLIER
                             AND PRS_KODEIGR = TRBO_KODEIGR
                             AND TRBO_PRDCD = BTB_PRDCD(+)
                             AND TRBO_NOREFF = BTB_NODOC(+)
                        ORDER BY TRBO_SEQNO");
                        // var_dump($data1);

                    $data2 = DB::connection(Session::get('connection'))->select("SELECT distinct trbo_nodoc, trbo_tgldoc, trbo_kodesupplier,trbo_istype, trbo_invno, trbo_tglinv
                                    FROM TBTR_BACKOFFICE,  TBMASTER_PRODMAST, TBMASTER_SUPPLIER, TBMASTER_PERUSAHAAN
                                    WHERE TRBO_KODEIGR = '" . Session::get('kdigr') . "'
                                                  " . $P_PN . "
                                                  AND prd_kodeigr = trbo_kodeigr AND prd_prdcd = trbo_prdcd
                                                  AND sup_kodeigr(+) = trbo_kodeigr AND sup_kodesupplier(+) = trbo_kodesupplier
                                                  AND prs_kodeigr = trbo_kodeigr
                                    order by trbo_tglinv desc, trbo_istype desc, trbo_invno desc");

                    $path = 'list_pengeluaran/';
                    $nodocs = '';
                    $splitedNodoc = explode(',', $NoDoc);
                    foreach ($splitedNodoc as $nodoc) {
                        $nodocs .= $nodoc . '_';
                    }
                    $filenames = 'LIST-PENGELUARAN_'. $nodocs . $data1[0]->trbo_tgldoc;
                    break;
                case  'F' :      // Pemusnahan
                    $cw = 700;
                    $ch = 45;
                    $filename = 'cetak-list';
                    $P_PN = " AND TRBO_NOREFF IN (" . $NoDoc . ")";
                    $data1 = DB::connection(Session::get('connection'))->select("SELECT trbo_noreff trbo_nodoc, trbo_tglreff, to_char(TRBO_TGLDOC,'yyyymmdd') TRBO_TGLDOC, trbo_flagdisc1, trbo_prdcd, prd_unit trbo_unit, prd_isibeli trbo_frac,                                    trbo_hrgsatuan, trbo_keterangan,
                                CASE WHEN trbo_flagdoc = '1' THEN 'RE-PRINT' ELSE '' END AS STATUS,
                                trbo_qty, FLOOR(trbo_qty/prd_isibeli) AS CTN, MOD(trbo_qty,prd_isibeli) AS PCS, (trbo_qty * trbo_hrgsatuan) AS total ,
                                CASE WHEN trbo_flagdisc1 = '1' THEN 'BARANG BAIK' ELSE
                                CASE WHEN trbo_flagdisc1 = '2' THEN 'BARANG RETUR' ELSE
                                 'BARANG RUSAK' END END AS KET,
                                prd_deskripsipanjang,
                                prs_namaperusahaan, prs_namacabang,
                                CASE WHEN TRBO_TYPETRN = 'H' THEN 'EDIT LIST TRANSAKSI BARANG HILANG'
                                     WHEN TRBO_TYPETRN = 'X' THEN 'EDIT LIST PENYESUAIAN PERSEDIAAN'
                                     ELSE  'EDIT LIST PENERIMAAN BARANG'
                                END AS JUDUL
                                FROM TBTR_BACKOFFICE,  TBMASTER_PRODMAST, TBMASTER_PERUSAHAAN
                                WHERE TRBO_KODEIGR = '" . Session::get('kdigr') . "'
                                 " . $P_PN . "
                                AND prd_kodeigr = trbo_kodeigr AND prd_prdcd = trbo_prdcd
                                AND prs_kodeigr = trbo_kodeigr
                                ORDER BY TRBO_NODOC");

                    $path = 'list_pemusnahan/';
                    $nodocs = '';
                    $splitedNodoc = explode(',', $NoDoc);
                    foreach ($splitedNodoc as $nodoc) {
                        $nodocs .= $nodoc . '_';
                    }
                    $filenames = 'LIST-PEMUSNAHAN_'. $nodocs . $data1[0]->trbo_tgldoc;
                    break;
                case  'X' :      // Penyesuaian
                    null;
                    break;
                case  'H' :      // Barang Hilang
                    $cw = 508.5;
                    $ch = 77.5;
                    $filename = 'list-baranghilang';
                    $P_PN = " AND TRBO_NODOC IN (" . $NoDoc . ") AND TRBO_TYPETRN='H'";
                    $data1 = DB::connection(Session::get('connection'))->select("SELECT trbo_nodoc,to_char(TRBO_TGLDOC,'yyyymmdd') TRBO_TGLDOC, trbo_flagdisc1, trbo_prdcd, prd_unit trbo_unit, prd_frac trbo_frac, trbo_hrgsatuan, trbo_keterangan,
                                    CASE WHEN trbo_flagdoc = '1' THEN 'RE-PRINT' ELSE '' END AS STATUS,
                                 trbo_qty, FLOOR(trbo_qty/prd_frac) AS CTN, MOD(trbo_qty,prd_frac) AS PCS, (trbo_qty * (trbo_hrgsatuan/prd_frac)) AS total ,
                                    CASE WHEN trbo_flagdisc1 = '1' THEN 'BARANG BAIK' ELSE
                                    CASE WHEN trbo_flagdisc1 = '2' THEN 'BARANG RETUR' ELSE 'BARANG RUSAK' END END AS KET,
                                 prd_deskripsipanjang,
                                 prs_namaperusahaan, prs_namacabang,
                                    CASE WHEN TRBO_TYPETRN = 'H' THEN 'EDIT LIST TRANSAKSI BARANG HILANG'
                                          WHEN TRBO_TYPETRN = 'X' THEN 'EDIT LIST PENYESUAIAN PERSEDIAAN'
                                          ELSE  'EDIT LIST PENERIMAAN BARANG' END AS JUDUL
                                FROM TBTR_BACKOFFICE,  TBMASTER_PRODMAST, TBMASTER_PERUSAHAAN
                                WHERE TRBO_KODEIGR = '" . Session::get('kdigr') . "'
                                 " . $P_PN . "
                                                    AND prd_kodeigr = trbo_kodeigr AND prd_prdcd = trbo_prdcd
                                                    AND prs_kodeigr = trbo_kodeigr
                                ORDER BY TRBO_NODOC,TRBO_SEQNO");

                    $path = 'list_barang-hilang/';
                    $nodocs = '';
                    $splitedNodoc = explode(',', $NoDoc);
                    foreach ($splitedNodoc as $nodoc) {
                        $nodocs .= $nodoc . '_';
                    }
                    $filenames = 'LIST-BARANG-HILANG_'. $nodocs . $data1[0]->trbo_tgldoc;
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
            switch ($TypeDoc) {

                case  'K' :
                    $P_PN = " AND MSTH_NODOC IN (" . $NoDoc . ") AND MSTH_TYPETRN='K'";
                    $data1 = DB::connection(Session::get('connection'))->select("SELECT msth_nodoc, to_char(msth_tgldoc,'yyyymmdd') msth_tgldoc,
                                  CASE WHEN '" . $REPRINT . "' = '1' THEN 'RE-PRINT' ELSE '' END AS STATUS,
                                  mstd_prdcd, mstd_unit, mstd_frac, mstd_qty, mstd_hrgsatuan,
                                  FLOOR(mstd_qty/mstd_frac) AS CTN, MOD(mstd_qty,mstd_frac) AS PCS, mstd_keterangan,
                                  mstd_gross, mstd_discrph, mstd_ppnrph, (NVL(mstd_gross,0) - NVL(mstd_discrph,0) + NVL(mstd_ppnrph,0)) AS TOTAL, msth_kodesupplier, msth_istype || msth_invno nofp, msth_tglinv,
                                  case when nvl(msth_kodesupplier,' ') <> ' ' then '( RETUR PEMBELIAN )' ELSE '( LAIN - LAIN )' end judul,prd_deskripsipanjang,
                                  prs_namaperusahaan, prs_namacabang, prs_npwp, prs_alamat1, prs_alamat3,
                                 nvl(sup_namanpwp,sup_namasupplier || sup_singkatansupplier) namas, sup_npwp, NVL(SUP_ALAMATNPWP1,SUP_ALAMATSUPPLIER1) SUP_ALAMATSUPPLIER1,
                                 NVL(SUP_ALAMATNPWP2,SUP_ALAMATSUPPLIER2) SUP_ALAMATSUPPLIER2,
                                 NVL(SUP_ALAMATNPWP3,SUP_KOTASUPPLIER3) SUP_KOTASUPPLIER3, sup_telpsupplier, sup_contactperson, mstd_noref3
                    FROM TBTR_MSTRAN_H, TBTR_MSTRAN_D, TBMASTER_PRODMAST, TBMASTER_PERUSAHAAN, TBMASTER_SUPPLIER
                    WHERE MSTH_KODEIGR = '" . Session::get('kdigr') . "' AND
                                   MSTH_KODEIGR = MSTD_KODEIGR AND MSTH_NODOC = MSTD_NODOC AND
                                   MSTD_KODEIGR = PRD_KODEIGR AND MSTD_PRDCD = PRD_PRDCD AND
                                   MSTH_KODEIGR = PRS_KODECABANG AND
                                   MSTH_KODEIGR = SUP_KODEIGR(+) AND MSTH_KODESUPPLIER = SUP_KODESUPPLIER(+)
                                    " . $P_PN . "
                    ORDER BY MSTH_NODOC,MSTD_SEQNO");

                    $data2 = DB::connection(Session::get('connection'))->select("select rownum, a.*
                                        from
                                        (SELECT DISTINCT MSTH_NODOC NODOC, MSTH_TGLDOC, MSTH_KODESUPPLIER, MSTD_ISTYPE || MSTD_INVNO NOFP,
                                                        MSTD_DATE3
                                                   FROM TBTR_MSTRAN_H,
                                                        TBTR_MSTRAN_D,
                                                        TBMASTER_PRODMAST,
                                                        TBMASTER_PERUSAHAAN,
                                                        TBMASTER_SUPPLIER
                                                  WHERE MSTH_KODEIGR = '" . Session::get('kdigr') . "'
                                                    AND MSTH_KODEIGR = MSTD_KODEIGR
                                                    AND MSTH_NODOC = MSTD_NODOC
                                                    AND MSTD_KODEIGR = PRD_KODEIGR
                                                    AND MSTD_PRDCD = PRD_PRDCD
                                                    AND MSTH_KODEIGR = PRS_KODECABANG
                                                    AND MSTH_KODEIGR = SUP_KODEIGR(+)
                                                    AND MSTH_KODESUPPLIER = SUP_KODESUPPLIER(+)
                                                    " . $P_PN . "
                                        ) a");
                    if ($JNSKERTAS == 'B') {
                        $cw = 423;
                        $ch = 77.5;
                        $filename = 'cetak-nota-pengeluaran-biasa';
//                        $filename = 'cetak-nota-pengeluaran-biasa';
                    } else {
                        $cw = 423;
                        $ch = 77.5;
                        $filename = 'cetak-nota-pengeluaran-kecil';
                    }

                    $path = 'receipts/';
                    $nodocs = '';
                    $splitedNodoc = explode(',', $NoDoc);
                    foreach ($splitedNodoc as $nodoc) {
                        $nodocs .= $nodoc . '_';
                    }
                    $filenames = 'NRB_'. $nodocs . $data1[0]->msth_tgldoc;
                    if($REPRINT == '0'){
                        $path_backup = 'nrb_nrp_backup/';
                    }
                    break;
                case  'H' :      // Barang Hilang
                    if ($JNSKERTAS == 'B') {
                        $cw = 508;
                        $ch = 77.5;
                        $P_PN = " AND MSTD_NODOC IN (" . $NoDoc . ") AND MSTH_TYPETRN='H'";

                        $data1 = DB::connection(Session::get('connection'))
                            ->select("SELECT msth_nodoc, to_char(msth_tgldoc,'yyyymmdd') msth_tgldoc, msth_nopo, msth_tglpo,
                                    CASE WHEN msth_flagdoc = '1' THEN 'RE-PRINT' ELSE '' END AS STATUS,
                                    mstd_flagdisc1, mstd_prdcd, mstd_unit, mstd_frac, mstd_qty, mstd_hrgsatuan,
                                FLOOR(mstd_qty/mstd_frac) AS CTN, MOD(mstd_qty,mstd_frac) AS PCS, (mstd_qty * (mstd_hrgsatuan/mstd_frac))                                       AS total, mstd_keterangan,
                                    CASE WHEN msth_typetrn = 'H' THEN
                                    CASE WHEN mstd_flagdisc1 = '1' THEN 'BARANG BAIK' ELSE
                                    CASE WHEN mstd_flagdisc1 = '2' THEN 'BARANG RETUR' ELSE
                                     'BARANG RUSAK' END END
                                    ELSE
                                    CASE WHEN mstd_flagdisc1 = '1' THEN 'SELISIH STOK OPNAME' ELSE
                                    CASE WHEN mstd_flagdisc1 = '2' THEN 'TERTUKAR JENIS' ELSE
                                     'GANTI PLU' END END
                                    END
                                    AS KET,
                                    prd_deskripsipanjang,
                                    prs_namaperusahaan, prs_namacabang, prs_npwp, prs_alamat1, prs_alamat3,
                                    CASE WHEN msth_typetrn = 'H' THEN 'NOTA BARANG HILANG' ELSE CASE WHEN msth_typetrn = 'X' THEN 'MEMO PENYESUAIAN PERSEDIAAN' ELSE '' END END AS JUDUL
                                    FROM TBTR_MSTRAN_H, TBTR_MSTRAN_D, TBMASTER_PRODMAST, TBMASTER_PERUSAHAAN
                                    WHERE msth_KODEIGR = '" . Session::get('kdigr') . "'
                                    " . $P_PN . "
                                    AND mstd_kodeigr = msth_kodeigr AND mstd_nodoc = msth_nodoc
                                    AND prd_kodeigr = msth_kodeigr AND prd_prdcd = mstd_prdcd
                                    AND prs_kodeigr = msth_kodeigr
                                    ORDER BY msth_NODOC,MSTD_SEQNO");
                        $filename = 'cetak-nota-nbh-biasa';
                    } else {
                        $cw = 508;
                        $ch = 77.5;
                        $P_PN = " AND MSTH_NODOC IN (" . $NoDoc . ") AND MSTH_TYPETRN='H'";
                        $data1 = DB::connection(Session::get('connection'))->select("SELECT msth_nodoc, to_char(msth_tgldoc,'yyyymmdd') msth_tgldoc, msth_nopo, msth_tglpo,
                                    CASE WHEN msth_flagdoc = '1' THEN 'RE-PRINT' ELSE '' END AS STATUS,
                                    mstd_flagdisc1, mstd_prdcd, mstd_unit, mstd_frac, mstd_qty, mstd_hrgsatuan,
                                    FLOOR(mstd_qty/mstd_frac) AS CTN, MOD(mstd_qty,mstd_frac) AS PCS, (mstd_qty * (mstd_hrgsatuan/mstd_frac)) AS total, mstd_keterangan,
                                    CASE WHEN msth_typetrn = 'H' THEN
                                    CASE WHEN mstd_flagdisc1 = '1' THEN 'BARANG BAIK' ELSE
                                    CASE WHEN mstd_flagdisc1 = '2' THEN 'BARANG RETUR' ELSE
                                     'BARANG RUSAK' END END
                                    ELSE
                                    CASE WHEN mstd_flagdisc1 = '1' THEN 'SELISIH STOK OPNAME' ELSE
                                    CASE WHEN mstd_flagdisc1 = '2' THEN 'TERTUKAR JENIS' ELSE
                                     'GANTI PLU' END END
                                    END
                                    AS KET,
                                    prd_deskripsipanjang,
                                    prs_namaperusahaan, prs_namacabang, prs_npwp, prs_alamat1, prs_alamat3,
                                    CASE WHEN msth_typetrn = 'H' THEN 'NOTA BARANG HILANG' ELSE CASE WHEN msth_typetrn = 'X' THEN 'MEMO PENYESUAIAN PERSEDIAAN' ELSE '' END END AS JUDUL
                                    FROM TBTR_MSTRAN_H, TBTR_MSTRAN_D, TBMASTER_PRODMAST, TBMASTER_PERUSAHAAN
                                    WHERE msth_KODEIGR = '" . Session::get('kdigr') . "'
                                    " . $P_PN . "
                                    AND mstd_kodeigr = msth_kodeigr AND mstd_nodoc = msth_nodoc
                                    AND prd_kodeigr = msth_kodeigr AND prd_prdcd = mstd_prdcd
                                    AND prs_kodeigr = msth_kodeigr
                                    ORDER BY msth_NODOC,MSTD_SEQNO");
                        $filename = 'cetak-nota-nbh-kecil';
                    }

                    $path = 'nbh/';
                    $nodocs = '';
                    $splitedNodoc = explode(',', $NoDoc);
                    foreach ($splitedNodoc as $nodoc) {
                        $nodocs .= $nodoc . '_';
                    }
                    $filenames = 'NBH_'. $nodocs . $data1[0]->msth_tgldoc;
                    break;
            }
        }

        $perusahaan = DB::connection(Session::get('connection'))->table('tbmaster_perusahaan')
            ->first();
            $data = [
                'data1' => $data1,
                'data2' => $data2,
                'tgl1' => $tgl1,
                'tgl2' => $tgl2,
                'reprint' => $REPRINT,
                'arrSuppSig' => $arrSuppSig,
                'filename' => $filename,
                'perusahaan' => $perusahaan
            ];

            $dompdf = new PDF();

            $pdf = PDF::loadview('BACKOFFICE.CETAKDOKUMEN.' . $filename . '-pdf', compact(['data', 'perusahaan']));

            error_reporting(E_ALL ^ E_DEPRECATED);

            $pdf->output();
            $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);

            $canvas = $dompdf->get_canvas();
            $canvas->page_text($cw, $ch, "{PAGE_NUM} dari {PAGE_COUNT}", null, 7, array(0, 0, 0));

            $dompdf = $pdf;

            if ($REPRINT != '0') {
                $path = 'reprint/';
                $filenames = 'REPRINT_' . $filenames;
            }

            if (!FacadesFile::exists(storage_path($path))) {
                FacadesFile::makeDirectory(storage_path($path), 0755, true, true);
            }

            $file = storage_path($path . $filenames . '.PDF');

            file_put_contents($file, $pdf->output());
            if ($path_backup != '') {
                if (!FacadesFile::exists(storage_path($path_backup))) {
                    FacadesFile::makeDirectory(storage_path($path_backup), 0755, true, true);
                }
                $file_backup = storage_path($path_backup . $filenames . '.PDF');
                file_put_contents($file_backup, $pdf->output());
            }
            return $filenames;
            // return $data;

            // return view('BACKOFFICE.CETAKDOKUMEN.' . $filename . '-pdf', compact(['data', 'perusahaan']));



    }

    public function CETAK_BARU($nodoc, $reprint, $namattd, $jabatan1, $jabatan2)
    {

        $filename = 'ctk-rtrpjk';
        $P_PN = "AND MSTH_NODOC IN (" . $nodoc . ") AND MSTH_TYPETRN='K'";

        $data = DB::connection(Session::get('connection'))->select("SELECT MSTH_KODEIGR, MSTH_NODOC,
        --trunc(msth_tgldoc) msth_tgldoc,
        to_char(msth_tgldoc,'yyyymmdd') msth_tgldoc,
        MSTH_KODESUPPLIER, MSTD_DOCNO2, MSTD_DATE3 ,
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
   WHERE MSTH_KODEIGR = '" . Session::get('kdigr') . "'
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
ORDER BY mstd_noref3 asc");
        $perusahaan = DB::connection(Session::get('connection'))->table('tbmaster_perusahaan')->first();
        $cw = 507;
        $ch = 45;
        if (sizeof($data) != 0) {
            $dompdf = new PDF();

            $pdf = PDF::loadview('BACKOFFICE.CETAKDOKUMEN.' . $filename . '-pdf', compact(['perusahaan', 'data', 'namattd', 'jabatan1', 'jabatan2']));

            error_reporting(E_ALL ^ E_DEPRECATED);

            $pdf->output();
            $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);
            $canvas = $dompdf->get_canvas();
            $canvas->page_text($cw, $ch, "HAL : {PAGE_NUM}", null, 7, array(0, 0, 0));

            $dompdf = $pdf;
            // $filenames = $filename . '_' . $nodoc . '.pdf';
            // $path = 'receipts/';
            // if (!FacadesFile::exists(storage_path($path))) {
            //     FacadesFile::makeDirectory(storage_path($path), 0755, true, true);
            // }
            // $nodocs = '';
            // $splitedNodoc = explode(',', $nodoc);
            // foreach ($splitedNodoc as $nodoc) {
            //     $nodocs .= $nodoc . '_';
            // }
            // $filenames = 'NRP_'. $nodocs . $data[0]->msth_tgldoc;
            // $file = storage_path($path . $filenames . '.pdf');

            // file_put_contents($file, $pdf->output());

            $nodocs = '';
            $splitedNodoc = explode(',', $nodoc);
            foreach ($splitedNodoc as $nodoc) {
                $nodocs .= $nodoc . '_';
            }

            $path_backup = '';
            if ($reprint == '0') {
                $path = 'receipts/';
                $path_backup = 'nrb_nrp_backup/';
                $filenames = 'NRP_'. $nodocs . $data[0]->msth_tgldoc;
            } else {
                $path = 'reprint/';
                $filenames = 'REPRINT_NRP_' . $nodocs . $data[0]->msth_tgldoc;
            }

            if (!FacadesFile::exists(storage_path($path))) {
                FacadesFile::makeDirectory(storage_path($path), 0755, true, true);
            }

            $file = storage_path($path . $filenames . '.PDF');

            file_put_contents($file, $pdf->output());
            if ($path_backup != '') {
                if (!FacadesFile::exists(storage_path($path_backup))) {
                    FacadesFile::makeDirectory(storage_path($path_backup), 0755, true, true);
                }
                $file_backup = storage_path($path_backup . $filenames . '.PDF');
                file_put_contents($file_backup, $pdf->output());
            }

            return $filenames;
            // return view('BACKOFFICE.CETAKDOKUMEN.' . $filename . '-pdf', compact(['perusahaan', 'data', 'namattd', 'jabatan1', 'jabatan2']));
        }
    }

    public function downloadFile(Request $request)
    {
        $filesAndPaths = $request->file;
        $splitedFilename = explode('_', $filesAndPaths);



        if ($splitedFilename[0] == 'NRB' || $splitedFilename[0] == 'NRP') {
            $path = 'receipts/';
            return response()->download(storage_path($path . $filesAndPaths . '.PDF'));
        }
        if ($splitedFilename[0] == 'SJ') {
            $path = 'surat_jalan/';
            return response()->download(storage_path($path . $filesAndPaths . '.PDF'))->deleteFileAfterSend();
        }
        if ($splitedFilename[0] == 'REPRINT') {
            $path = 'reprint/';
            return response()->download(storage_path($path . $filesAndPaths . '.PDF'))->deleteFileAfterSend();
        }
        if ($splitedFilename[0] == 'LIST-PENGELUARAN') {
            $path = 'list_pengeluaran/';
            return response()->download(storage_path($path . $filesAndPaths . '.PDF'))->deleteFileAfterSend();
        }
        if ($splitedFilename[0] == 'LIST-PEMUSNAHAN') {
            $path = 'list_pemusnahan/';
            return response()->download(storage_path($path . $filesAndPaths . '.PDF'))->deleteFileAfterSend();
        }
        if ($splitedFilename[0] == 'LIST-BARANG-HILANG') {
            $path = 'list_barang-hilang/';
            return response()->download(storage_path($path . $filesAndPaths . '.PDF'))->deleteFileAfterSend();
        }
        if ($splitedFilename[0] == 'NBH') {
            $path = 'nbh/';
            return response()->download(storage_path($path . $filesAndPaths . '.PDF'))->deleteFileAfterSend();
        }

        // return response()->download(storage_path($path.$filesAndPaths))->deleteFileAfterSend();

    }

    public function getArea()
    {
        $kodeigr = Session::get('kdigr');
        $result = DB::connection(Session::get('connection'))->select(
            "SELECT CAB_KODEWILAYAH
             FROM TBMASTER_CABANG
             WHERE CAB_KODECABANG = '$kodeigr'"
        );
        return $result[0]->cab_kodewilayah;
    }

    public function kirimFtpCabang(Request $request)
    {
        $date = $request->date;
        // $filesAndPaths = $request->file;
        // $splitedFilename = explode('_', $filesAndPaths);

        $area = $this->getArea();
        $cabang = strtolower($area);
        $msg = '';
        $ftp_server = config('database.connections.' . Session::get('connection') . '.host');
        $ftp_user_name = 'ftpigr';
        $ftp_user_pass = 'ftpigr';
        $zipName = Session::get('kdigr') . '_' . date("dmY", strtotime(Carbon::now())) . '.ZIP';
        $zipAddress = '../storage/nrb_nrp_backup/' . $zipName;
        
        try {
            $conn_id = ftp_connect($ftp_server);
            ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);
            $files = Storage::disk('nrb_nrp_backup')->allFiles();
            if (count($files) > 0) {
                if (Storage::disk('nrb_nrp_backup')->exists($zipName) == false) {
                    $zip = new ZipArchive;
                    if (true === ($zip->open($zipAddress, ZipArchive::CREATE | ZipArchive::OVERWRITE))) {
                        foreach ($files as $file => $value) {
                            // $filePath = '../storage/nrb_nrp_backup/' . $value;
                            // $zip->addFile($filePath, $value);

                            // cesar nrb nrp
                            $splitedFilename = explode('_', $value);                            
                            if ($splitedFilename[0] == 'NRB' || $splitedFilename[0] == 'NRP') {                                
                                $split = explode('.', $splitedFilename[sizeof($splitedFilename)-1]);
                                $docDate = $split[0];
                                if ($docDate == $date) {
                                    $filePath = '../storage/nrb_nrp_backup/' . $value;
                                    $zip->addFile($filePath, $value);
                                }
                            }
                        }
                        $zip->close();
                        ftp_put($conn_id, '/u01/lhost/nrb_nrp_backup/' . $zipName, $zipAddress);
                        //send to Cabang
                    } else {
                        $msg = 'Proses kirim file gagal';
                        return response()->json(['kode' => 0, 'message' => $msg]);
                    }
                } else {
                    ftp_put($conn_id, '/u01/lhost/nrb_nrp_backup/' . $zipName, $zipAddress);
                    //send to Cabang
                }
                $msg = 'File terkirim ke Cabang';
                FacadesFile::delete($zipAddress); //delete zip file from storage
                // $this->deleteBackupFiles(); //delete all files
            } else {
                $msg = 'Empty Record, nothing to transfer';
                return response()->json(['kode' => 2, 'message' => $msg]);
            }
        } catch (Exception $e) {
            $msg = 'Proses kirim file gagal (error)';
            return response()->json(['kode' => 0, 'message' => $msg . $e]);
        }
        return response()->json(['kode' => 1, 'message' => $msg]);
    }
}
