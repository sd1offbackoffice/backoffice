<?php

namespace App\Http\Controllers\BACKOFFICE\TRANSAKSI\PENERIMAAN;

use App\AllModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller; use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use PDF;

class printBPBController extends Controller
{
    public function index(){
        return view('BACKOFFICE.TRANSAKSI.PENERIMAAN.printBPB');
    }

    public function viewData(Request $request){
        $startDate = date('Y-M-d', strtotime($request->startDate));
        $endDate = date('Y-M-d', strtotime($request->endDate));
        $type = $request->type;
        $checked = $request->checked;
        $typeTrn = $request->typeTrn;

        if ($type == 1){
            $data = DB::connection(Session::get('connection'))->select("SELECT DISTINCT trbo_nodoc as nodoc, trbo_tgldoc as tgldoc
                                       FROM tbtr_backoffice
                                      WHERE trbo_typetrn = '$typeTrn'
                                        AND NVL (trbo_flagdoc, '0') = '$checked'
                                        AND trbo_tgldoc BETWEEN ('$startDate') AND ('$endDate')
                                        order by trbo_nodoc");
            return response()->json($data);
        } else {
            if ($checked == 0){
                $data = DB::connection(Session::get('connection'))->select("SELECT DISTINCT trbo_nodoc as nodoc, trbo_tgldoc as tgldoc
                                           FROM tbtr_backoffice
                                          WHERE (trbo_tgldoc BETWEEN ('$startDate') AND ('$endDate'))
                                            AND trbo_typetrn = '$typeTrn'
                                            AND NVL (trbo_flagdoc, '0') <> '*'
                                            order by trbo_nodoc");

                return response()->json($data);
            } else {
                $data = DB::connection(Session::get('connection'))->select("SELECT msth_nodoc as nodoc, msth_tgldoc as tgldoc
                                          FROM tbtr_mstran_h
                                         WHERE (msth_tgldoc BETWEEN ('$startDate') AND ('$endDate'))
                                           AND msth_typetrn = '$typeTrn'
                                           AND NVL (msth_flagdoc, ' ') = '$checked'
                                           order by msth_nodoc");

                return response()->json($data);
            }

        }


    }

    public function cetakData(Request  $request){
        $document   = $request->document;
        $type       = $request->type;
        $reprint    = $request->checked;
        $size       = $request->size;
        $dummyvar   = 1;
        $kodeigr    = Session::get('kdigr');
        $userid     = Session::get('usid');

        $counter    = 0;
        $v_print    = 0;
        $temp       = [];
        $temp_lokasi = [];

        $model  = new AllModel();
        $conn   = $model->connectionProcedure();

        if ($type == 1){
            $temp = $document;
            $v_print = $reprint;
        } else {
            if ($reprint == 0){
                foreach ($document as $data){
                    $updateData = $this->update_data($document[0],$kodeigr,$userid,$conn,$type,'');

                    if($updateData['kode'] == 0){
                        return response()->json($updateData);
                    }
                $updateData = $this->update_data2($kodeigr,$conn,$type);

                    $ct = DB::connection(Session::get('connection'))->select("select nvl(count(1),0) as ct
						            	from tbtr_backoffice, tbmaster_lokasi
						            	where trbo_nodoc = '$data'
							            	and lks_prdcd = trbo_prdcd
														and lks_kodeigr= trbo_kodeigr
														and substr(lks_koderak,1,1) = 'A'");

                    if ($ct[0]->ct > 0){
                        array_push($temp_lokasi, [$data]);
                        $counter = $counter + 1;
                    }
                }
            }
        } // End Else ($type = 1)

        if ($counter > 0){
            $this->print_lokasi($temp_lokasi, $type, $v_print);
        }


        if ($temp){
            if ($type == 1 && $reprint == 0){
                DB::connection(Session::get('connection'))->table('tbtr_backoffice')
                    ->whereIn('trbo_nodoc', $temp)
                    ->update(['trbo_flagdoc' => '1']);
            } elseif ($type == 2 && $reprint == 0){
                DB::connection(Session::get('connection'))->table('tbtr_backoffice')
                    ->whereIn('trbo_nodoc', $temp)
                    ->update(['trbo_flagdoc' => '*', 'trbo_recordid' => 2]);
            }

            $print_btb = $this->print_btb($temp,$type,$v_print,$size);
        }

//        if ($type == 1){
//            $this->getData1();
//        } else {
//            $this->getData2();
//        }

        return response()->json(['kode' => 1 , 'message' => 'Create Report Success', 'data' => $print_btb]);
    }

    public function update_data($noDoc, $kodeigr, $userId, $conn, $type, $dummyvar){
        if(!$dummyvar){
            $checkDummyVar = DB::connection(Session::get('connection'))->select(" SELECT TRBO_PRDCD,
                                                     TRBO_TYPETRN,
                                                     PRD_PRDCD,
                                                     PRD_AVGCOST,
                                                     PRD_LASTCOST
                                                FROM TBTR_BACKOFFICE AA,
                                                     TBMASTER_PRODMAST BB,
                                                     TBMASTER_SUPPLIER CC,
                                                     TBMASTER_STOCK DD,
                                                     TBMASTER_LOKASI EE,
                                                     TBTR_PO_D FF,
                                                     TBTR_PO_H GG,
                                                     tbmaster_stock_cab_anak hh
                                               WHERE     AA.TRBO_NODOC = '$noDoc'
                                                     AND (  NVL (TRBO_QTY, 0)
                                                          + NVL (TRBO_QTYBONUS1, 0)
                                                          + NVL (TRBO_QTYBONUS2, 0)) <> 0
                                                     AND BB.PRD_PRDCD = AA.TRBO_PRDCD
                                                     AND BB.PRD_KODEIGR = '$kodeigr'
                                                     AND CC.SUP_KODESUPPLIER(+) = AA.TRBO_KODESUPPLIER
                                                     AND CC.SUP_KODEIGR(+) = AA.TRBO_KODEIGR
                                                     AND DD.ST_PRDCD(+) = AA.TRBO_PRDCD
                                                     AND DD.ST_KODEIGR(+) = AA.TRBO_KODEIGR
                                                     AND DD.ST_LOKASI(+) = '01'
                                                     AND EE.LKS_PRDCD(+) = AA.TRBO_PRDCD
                                                     AND EE.LKS_KODEIGR(+) = AA.TRBO_KODEIGR
                                                     AND SUBSTR (EE.LKS_KODERAK(+), 1, 1) = 'A'
                                                     AND FF.TPOD_PRDCD(+) = AA.TRBO_PRDCD
                                                     AND FF.TPOD_KODEIGR(+) = AA.TRBO_KODEIGR
                                                     AND FF.TPOD_NOPO(+) = AA.TRBO_NOPO
                                                     AND GG.TPOH_KODEIGR(+) = '$kodeigr'
                                                     AND GG.TPOH_NOPO(+) = AA.TRBO_NOPO
                                                     AND NVL (GG.TPOH_RECORDID, '0') <> '1'
                                                     AND HH.STA_PRDCD(+) = AA.TRBO_PRDCD
                                                     AND HH.STA_KODEIGR(+) = AA.TRBO_KODEIGR
                                                     AND HH.STA_LOKASI(+) = '01'
                                            ORDER BY AA.TRBO_PRDCD");

            foreach ($checkDummyVar as $data){
                if (!$data->prd_lastcost){
                    if ($data->prd_avgcost){
                        return ['kode' => 0, 'message' => "PLU ".$data->prd_prdcd." Abg Cost <> 0, Lakukan Update PKM?" ];
                    }
                }
            }

            $dummyvar = 0;
        }

        $exec = oci_parse($conn, "BEGIN sp_penerimaan_updatedata(:kodeigr, :userid, :tipe, :dummyvar, :result); END;");
        oci_bind_by_name($exec, ':kodeigr',$kodeigr);
        oci_bind_by_name($exec, ':userid',$userId);
        oci_bind_by_name($exec, ':tipe', $type);
        oci_bind_by_name($exec, ':dummyvar', $dummyvar);
        oci_bind_by_name($exec, ':result', $result,1000);
        oci_execute($exec);

        return ['kode' => 1, 'message' => "Success" ];
    }

    public function update_data2($kodeigr, $conn, $type){
        $exec = oci_parse($conn, "BEGIN sp_penerimaan_updatedata2(:kodeigr, :tipe, :result); END;");
        oci_bind_by_name($exec, ':kodeigr',$kodeigr);
        oci_bind_by_name($exec, ':tipe', $type);
        oci_bind_by_name($exec, ':result', $result,1000);
        oci_execute($exec);

        return ['kode' => 1, 'message' => "Success" ];
    }

    public function print_btb($temp, $type, $v_print, $size){

        if ($type == 1){
            if ($size == 2){
                return 'IGR_BO_LISTBTB_FULL';
            } else {
                return 'IGR_BO_LISTBTB';
            }
        } else {
            if ($size == 2){
                return "IGR_BO_CTBTBNOTA_FULL";
            } else {
                return "IGR_BO_CTBTBNOTA";
            }
        }

    }

    public function print_lokasi($temp_lokasi, $type, $v_print){

        $datas = "1";

        $pdf = PDF::loadview('BACKOFFICE.TRANSAKSI.PENERIMAAN.igr_bo_ctklokasi', ['datas' => $datas]);
        $pdf->output();
        $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);

        $canvas = $dompdf ->get_canvas();
        $canvas->page_text(514, 10, "Page {PAGE_NUM} of {PAGE_COUNT}", null, 10, array(0, 0, 0));

        return $pdf->stream('igr_bo_ctklokasi.pdf');

    }

    public function viewReport(Request $request){
        $report = $request->report;
        $noDoc  = $request->noDoc;
        $reprint = $request->reprint;
        $splitDoc = explode(',', $noDoc);
        $kodeigr= Session::get('kdigr');
        $document = '';
        $re_print = ($reprint == 1) ? '(REPRINT)' :' ';

        foreach ($splitDoc as $data){
            $document = $document."'".$data."',";
        }

        $document = substr($document,0,-1);

        if ($report == 'IGR_BO_LISTBTB_FULL'){
            $datas = DB::connection(Session::get('connection'))->select("select trbo_nodoc, TO_CHAR(trbo_tgldoc,'DD/MM/YY') trbo_tgldoc, trbo_nopo, TO_CHAR(trbo_tglpo,'DD/MM/YY') trbo_tglpo, trbo_nofaktur, TO_CHAR(trbo_tglfaktur,'DD/MM/YY') trbo_tglfaktur,
                                        floor(trbo_qty/prd_frac) qty, mod(trbo_qty,prd_frac) qtyk, trbo_qtybonus1, trbo_qtybonus2, trbo_typetrn, trbo_qty, nvl(trbo_flagdoc,'0') flagdoc,
                                        trbo_hrgsatuan, trbo_persendisc1, trbo_persendisc2 , trbo_persendisc2ii , trbo_persendisc2iii , trbo_persendisc3, trbo_persendisc4, trbo_gross, trbo_ppnrph,trbo_ppnbmrph,trbo_ppnbtlrph,
                                        trbo_discrph, trbo_prdcd, trbo_rphdisc1, trbo_rphdisc2, trbo_rphdisc2ii, trbo_rphdisc2iii,  trbo_rphdisc3, trbo_rphdisc4,
                                        prd_deskripsipanjang, prd_unit||'/'||prd_frac kemasan, prd_unit, prd_frac,
                                        sup_kodesupplier||'-'||sup_namasupplier|| case when sup_singkatansupplier is not null then '/'||sup_singkatansupplier end supplier, sup_top,
                                        prs_namaperusahaan, prs_namacabang
                                            FROM tbtr_backoffice,
                                                 tbmaster_prodmast,
                                                 tbmaster_supplier,
                                                 tbmaster_perusahaan
                                           WHERE     trbo_kodeigr = :p_kodeigr
                                                 AND prd_kodeigr = trbo_kodeigr
                                                 AND prd_prdcd = trbo_prdcd
                                                 AND prs_kodeigr = trbo_kodeigr
                                                 AND sup_kodesupplier(+) = trbo_kodesupplier
                                                 AND trbo_nodoc in ($document)
                                        ORDER BY trbo_nodoc, trbo_prdcd", (['p_kodeigr' => $kodeigr]));

            $pdf = PDF::loadview('BACKOFFICE.TRANSAKSI.PENERIMAAN.igr_bo_listbtb_full', ['datas' => $datas]);
            $pdf->output();
            $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);

            $canvas = $dompdf ->get_canvas();
            $canvas->page_text(514, 10, "Page {PAGE_NUM} of {PAGE_COUNT}", null, 10, array(0, 0, 0));

            return $pdf->stream('igr_bo_listbtb_full.pdf');
        } elseif ($report == 'IGR_BO_LISTBTB'){
            $datas = DB::connection(Session::get('connection'))->select("select trbo_nodoc, TO_CHAR(trbo_tgldoc,'DD/MM/YY') trbo_tgldoc, trbo_nopo, TO_CHAR(trbo_tglpo,'DD/MM/YY') trbo_tglpo, trbo_nofaktur, TO_CHAR(trbo_tglfaktur,'DD/MM/YY') trbo_tglfaktur,
                                        floor(trbo_qty/prd_frac) qty, mod(trbo_qty,prd_frac) qtyk, trbo_qtybonus1, trbo_qtybonus2, trbo_typetrn, trbo_qty, nvl(trbo_flagdoc,'0') flagdoc,
                                        trbo_hrgsatuan, trbo_persendisc1, trbo_persendisc2 , trbo_persendisc2ii , trbo_persendisc2iii , trbo_persendisc3, trbo_persendisc4, trbo_gross, trbo_ppnrph,trbo_ppnbmrph,trbo_ppnbtlrph,
                                        trbo_discrph, trbo_prdcd, trbo_rphdisc1, trbo_rphdisc2, trbo_rphdisc2ii, trbo_rphdisc2iii,  trbo_rphdisc3, trbo_rphdisc4,
                                        prd_deskripsipanjang, prd_unit||'/'||prd_frac kemasan, prd_unit, prd_frac,
                                        sup_kodesupplier||'-'||sup_namasupplier|| case when sup_singkatansupplier is not null then '/'||sup_singkatansupplier end supplier, sup_top,
                                        prs_namaperusahaan, prs_namacabang, case when trbo_persendisc1 <> 0 then (trbo_persendisc1 * trbo_gross) / 100 else trbo_rphdisc1 end as ptg1, 0 as ptg2,
                                        (NVL(TRBO_Gross,0) - NVL(TRBO_DISCRPH,0) + NVL(TRBO_PPNRPH,0) + NVL(TRBO_PPNBmrpH,0) + NVL(TRBO_PPNBtlrpH,0)) as total
                                            FROM tbtr_backoffice,
                                                 tbmaster_prodmast,
                                                 tbmaster_supplier,
                                                 tbmaster_perusahaan
                                           WHERE     trbo_kodeigr = :p_kodeigr
                                                 AND prd_kodeigr = trbo_kodeigr
                                                 AND prd_prdcd = trbo_prdcd
                                                 AND prs_kodeigr = trbo_kodeigr
                                                 AND sup_kodesupplier(+) = trbo_kodesupplier
                                                 AND trbo_nodoc in ($document)
                                        ORDER BY trbo_nodoc, trbo_prdcd", (['p_kodeigr' => $kodeigr]));

            if ($datas){
                foreach ($datas as $data){
                    $nilaiDisc1 = 0;
                    $nilaiDisc1 = $data->ptg1;
                    $nilaiDisc2 = ($data->trbo_persendisc2 != 0) ? ($data->trbo_persendisc2 * ($data->trbo_gross - $nilaiDisc1)) / 100 : $data->trbo_rphdisc2;
                    $nilaiDisc2a = ($data->trbo_persendisc2ii != 0) ? ($data->trbo_persendisc2ii * ($data->trbo_gross - ($nilaiDisc1 + $nilaiDisc2))) / 100 : $data->trbo_rphdisc2ii;
                    $nilaiDisc2b = ($data->trbo_persendisc2iii != 0) ? ($data->trbo_persendisc2iii * ($data->trbo_gross - ($nilaiDisc1 + $nilaiDisc2 + $nilaiDisc2a))) / 100 : $data->trbo_rphdisc2iii;

                    $data->ptg2 = $nilaiDisc2 + $nilaiDisc2a + $nilaiDisc2b;
                }
            }

            $pdf = PDF::loadview('BACKOFFICE.TRANSAKSI.PENERIMAAN.igr_bo_listbtb', ['datas' => $datas]);
            $pdf->output();
            $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);

            $canvas = $dompdf ->get_canvas();
            $canvas->page_text(514, 10, "Page {PAGE_NUM} of {PAGE_COUNT}", null, 10, array(0, 0, 0));

            return $pdf->stream('igr_bo_listbtb.pdf');
        } elseif ($report == 'IGR_BO_CTBTBNOTA'){
            $datas = DB::connection(Session::get('connection'))->select("select msth_recordid, msth_nodoc, msth_tgldoc, msth_nopo, msth_tglpo, msth_nofaktur, msth_tglfaktur, msth_cterm, msth_flagdoc, (mstd_tgldoc + msth_cterm) tgljt, mstd_cterm,
                                        prs_namaperusahaan, prs_namacabang, prs_alamat1, prs_alamat2, prs_alamat3,prs_npwp,
                                        sup_kodesupplier||' '||sup_namasupplier || '/' || sup_singkatansupplier supplier, sup_npwp, sup_alamatsupplier1 ||'   '||sup_alamatsupplier2 alamat_supplier,
                                        sup_telpsupplier, sup_contactperson contact_person, sup_kotasupplier3,
                                        mstd_prdcd||' '||prd_deskripsipanjang plu, mstd_unit||'/'||mstd_frac kemasan, floor(mstd_qty/mstd_frac) qty, mod(mstd_qty,mstd_frac) qtyk, mstd_typetrn,
                                        mstd_hrgsatuan, mstd_ppnrph, mstd_ppnbmrph, mstd_ppnbtlrph, nvl(mstd_gross,0)- nvl(mstd_discrph,0)+nvl(mstd_dis4cr,0)+ nvl(mstd_dis4rr,0)+nvl(mstd_dis4jr,0) jumlah,
                                        nvl(mstd_rphdisc1,0) as disc1,
                                        (nvl(mstd_rphdisc2,0) + nvl(mstd_rphdisc2ii,0) + nvl(mstd_rphdisc2iii,0) ) as disc2,
                                        nvl(mstd_rphdisc3,0) as disc3, nvl(mstd_qtybonus1,0) as bonus1, nvl(mstd_qtybonus2,0) as bonus2, nvl(mstd_keterangan,' ') as keterangan, (nvl(mstd_dis4cr,0) + nvl(mstd_dis4rr,0) + nvl(mstd_dis4jr,0)) as disc4,
                                        case when mstd_typetrn = 'B' then '( PEMBELIAN )' else '( LAIN - LAIN )' end judul, '0' || '$kodeigr' || mstd_nodoc barcode
                                        from tbtr_mstran_h, tbmaster_perusahaan, tbmaster_supplier, tbtr_mstran_d, tbmaster_prodmast, tbtr_backoffice
                                        where msth_kodeigr='$kodeigr'
                                        and prs_kodeigr=msth_kodeigr
                                        and sup_kodesupplier(+)=msth_kodesupplier
                                        and sup_kodeigr(+)=msth_kodeigr
                                        and mstd_nodoc=msth_nodoc
                                        and mstd_kodeigr=msth_kodeigr
                                        and prd_kodeigr=msth_kodeigr
                                        and prd_prdcd = mstd_prdcd
                                        AND trbo_nonota(+) = mstd_nodoc
                                        AND trbo_kodeigr(+) = mstd_kodeigr
                                        and trbo_prdcd(+) = mstd_prdcd
                                        and msth_nodoc in ($document)
                                        order by msth_nodoc");

            $pdf = PDF::loadview('BACKOFFICE.TRANSAKSI.PENERIMAAN.igr_bo_ctbtbnota', ['datas' => $datas, 're_print' => $re_print])->setPaper('a5', 'potrait');
            $pdf->output();
            $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);

            return $pdf->stream('igr_bo_ctbtbnota.pdf');
        } elseif ($report == 'IGR_BO_CTBTBNOTA_FULL'){
            $datas = DB::connection(Session::get('connection'))->select("select msth_recordid, msth_nodoc, msth_tgldoc, msth_nopo, msth_tglpo, msth_nofaktur, msth_tglfaktur, msth_cterm, msth_flagdoc, (mstd_tgldoc + msth_cterm) tgljt, mstd_cterm,
                                        prs_namaperusahaan, prs_namacabang, prs_alamat1, prs_alamat2, prs_alamat3,prs_npwp,
                                        sup_kodesupplier||' '||sup_namasupplier || '/' || sup_singkatansupplier supplier, sup_npwp, sup_alamatsupplier1 ||'   '||sup_alamatsupplier2 alamat_supplier,
                                        sup_telpsupplier, sup_contactperson contact_person, sup_kotasupplier3,
                                        mstd_prdcd||' '||prd_deskripsipanjang plu, mstd_unit||'/'||mstd_frac kemasan, floor(mstd_qty/mstd_frac) qty, mod(mstd_qty,mstd_frac) qtyk, mstd_typetrn,
                                        mstd_hrgsatuan, mstd_ppnrph, mstd_ppnbmrph, mstd_ppnbtlrph, nvl(mstd_gross,0)- nvl(mstd_discrph,0)+nvl(mstd_dis4cr,0)+ nvl(mstd_dis4rr,0)+nvl(mstd_dis4jr,0) jumlah,
                                        nvl(mstd_rphdisc1,0) as disc1,
                                        (nvl(mstd_rphdisc2,0) + nvl(mstd_rphdisc2ii,0) + nvl(mstd_rphdisc2iii,0) ) as disc2,
                                        nvl(mstd_rphdisc3,0) as disc3, nvl(mstd_qtybonus1,0) as bonus1, nvl(mstd_qtybonus2,0) as bonus2, nvl(mstd_keterangan,' ') as keterangan, (nvl(mstd_dis4cr,0) + nvl(mstd_dis4rr,0) + nvl(mstd_dis4jr,0)) as disc4,
                                        case when mstd_typetrn = 'B' then '( PEMBELIAN )' else '( LAIN - LAIN )' end judul, '0' || '$kodeigr' || mstd_nodoc barcode
                                        from tbtr_mstran_h, tbmaster_perusahaan, tbmaster_supplier, tbtr_mstran_d, tbmaster_prodmast, tbtr_backoffice
                                        where msth_kodeigr='$kodeigr'
                                        and prs_kodeigr=msth_kodeigr
                                        and sup_kodesupplier(+)=msth_kodesupplier
                                        and sup_kodeigr(+)=msth_kodeigr
                                        and mstd_nodoc=msth_nodoc
                                        and mstd_kodeigr=msth_kodeigr
                                        and prd_kodeigr=msth_kodeigr
                                        and prd_prdcd = mstd_prdcd
                                        AND trbo_nonota(+) = mstd_nodoc
                                        AND trbo_kodeigr(+) = mstd_kodeigr
                                        and trbo_prdcd(+) = mstd_prdcd
                                        and msth_nodoc in ($document)
                                        order by msth_nodoc");

            $pdf = PDF::loadview('BACKOFFICE.TRANSAKSI.PENERIMAAN.igr_bo_ctbtbnota_full', ['datas' => $datas, 're_print' => $re_print])->setPaper('a4', 'potrait');
            $pdf->output();
            $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);

            return $pdf->stream('igr_bo_ctbtbnota_full.pdf');
        } elseif ($report == 'lokasi'){
            $datas = DB::connection(Session::get('connection'))->select("SELECT trbo_prdcd,
                                       SUBSTR (prd_deskripsipanjang, 1, 50) desc2,
                                       prd_unit || '/' || prd_frac kemasan,
                                       lks_koderak,
                                       lks_kodesubrak,
                                       lks_tiperak,
                                       lks_shelvingrak,
                                       FLOOR (trbo_qty / prd_frac) qty,
                                       lks_koderak || lks_kodesubrak || lks_tiperak || lks_shelvingrak
                                          keterangan,
                                       MOD (trbo_qty, prd_frac) qtyk,
                                       prs_namaperusahaan,
                                       prs_namacabang,
                                       prs_namawilayah
                                  FROM tbtr_backoffice,
                                       tbmaster_lokasi,
                                       tbmaster_prodmast,
                                       tbmaster_perusahaan
                                 WHERE     prs_kodeigr = trbo_kodeigr
                                       AND trbo_kodeigr = '22'
                                       AND TRBO_NOREFF IN ('01400388')
                                       AND lks_prdcd = trbo_prdcd
                                       AND lks_kodeigr = trbo_kodeigr
                                       --and substr(lks_koderak,1,1) = 'a'
                                       AND prd_prdcd = trbo_prdcd
                                       AND prd_kodeigr = trbo_kodeigr");

            $pdf = PDF::loadview('BACKOFFICE.TRANSAKSI.PENERIMAAN.igr_bo_ctklokasi', ['datas' => $datas]);
            $pdf->output();
            $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);

            $canvas = $dompdf ->get_canvas();
            $canvas->page_text(514, 10, "Page {PAGE_NUM} of {PAGE_COUNT}", null, 10, array(0, 0, 0));

            return $pdf->stream('igr_bo_ctklokasi.pdf');
        }

        dd($report);
    }


}


