<?php

namespace App\Http\Controllers\BACKOFFICE\TRANSAKSI\PENERIMAAN;

use App\AllModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use PDF;

class printBPBController extends Controller
{
    public function index()
    {
        return view('BACKOFFICE.TRANSAKSI.PENERIMAAN.printBPB');
    }

    public function viewData(Request $request)
    {
        $startDate = date('Y-M-d', strtotime($request->startDate));
        $endDate = date('Y-M-d', strtotime($request->endDate));
        $type = $request->type;
        $checked = $request->checked;
        $typeTrn = $request->typeTrn;

        if ($type == 1) {
            $data = DB::connection(Session::get('connection'))->select("SELECT DISTINCT trbo_nodoc as nodoc, trbo_tgldoc as tgldoc
                                       FROM tbtr_backoffice
                                      WHERE trbo_typetrn = '$typeTrn'
                                        AND NVL (trbo_flagdoc, '0') = '$checked'
                                        AND trbo_tgldoc BETWEEN ('$startDate') AND ('$endDate')
                                        order by trbo_nodoc");
            return response()->json($data);
        } else {
            if ($checked == 0) {
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

    public function cetakData(Request  $request)
    {
        $document   = $request->document;
        $type       = $request->type;
        $reprint    = $request->checked;
        $size       = $request->size;
        $trnType    = $request->typeTrn;
        $dummyvar   = 1;
        $kodeigr    = Session::get('kdigr');
        $userid     = Session::get('usid');

        $counter    = 0;
        $v_print    = 0;
        $temp       = [];
        $temp_lokasi = [];

        $model  = new AllModel();
        $conn   = $model->connectionProcedure();

        if ($type == 1) {
            $temp = $document;
            $v_print = $reprint;
        } else {
            if ($reprint == 0) {
                foreach ($document as $data) {
                    $updateData = $this->update_data($document[0], $kodeigr, $userid, $conn, $type, '');

                    if ($updateData['kode'] == 0) {
                        return response()->json($updateData);
                    }
                    $updateData = $this->update_data2($kodeigr, $conn, $type);

                    $ct = DB::connection(Session::get('connection'))->select("select nvl(count(1),0) as ct
						            	from tbtr_backoffice, tbmaster_lokasi
						            	where trbo_nodoc = '$data'
							            	and lks_prdcd = trbo_prdcd
														and lks_kodeigr= trbo_kodeigr
														and substr(lks_koderak,1,1) = 'A'");

                    if ($ct[0]->ct > 0) {
                        array_push($temp_lokasi, [$data]);
                        $counter = $counter + 1;
                    }
                }
            }
        } // End Else ($type = 1)

        if ($counter > 0) {
            $this->print_lokasi($temp_lokasi, $type, $v_print);
        }


        if ($temp) {
            if ($type == 1 && $reprint == 0) {
                DB::connection(Session::get('connection'))->table('tbtr_backoffice')
                    ->whereIn('trbo_nodoc', $temp)
                    ->update(['trbo_flagdoc' => '1']);
            } elseif ($type == 2 && $reprint == 0) {
                DB::connection(Session::get('connection'))->table('tbtr_backoffice')
                    ->whereIn('trbo_nodoc', $temp)
                    ->update(['trbo_flagdoc' => '*', 'trbo_recordid' => 2]);
            }

            $print_btb = $this->print_btb($temp, $type, $v_print, $size);
        }

        //        if ($type == 1){
        //            $this->getData1();
        //        } else {
        //            $this->getData2();
        //        }

        return response()->json(['kode' => 1, 'message' => 'Create Report Success', 'data' => $print_btb]);
    }

    public function update_data($noDoc, $kodeigr, $userId, $conn, $type, $dummyvar)
    {
        $P_SUKSES = 0;
        $P_ERROR = 0;
        if (!$dummyvar) {
            $checkDummyVar = DB::connection(Session::get('connection'))->select("SELECT 
                                                     TRBO_PRDCD, TRBO_TYPETRN, TRBO_DIS4CR, ST_PRDCD, PRD_PRDCD, PRD_UNIT,
                                                     TRBO_DIS4JR, TRBO_DIS4RR, PRD_AVGCOST, ST_AVGCOST, PRD_FRAC, ST_SALDOAKHIR,
                                                     TRBO_GROSS, TRBO_DISCRPH, TRBO_PPNBMRPH, TRBO_PPNBTLRPH, NVL(TRBO_QTY, 0) TRBO_QTY,
                                                     TRBO_QTYBONUS1, SUP_TOP, TRBO_NOPO, TRBO_FURGNT, TRBO_KODEIGR, TRBO_TGLPO,
                                                     TRBO_NODOC, TRBO_QTYBONUS2, TRBO_NOFAKTUR, TRBO_HRGSATUAN, PRD_LASTCOST,
                                                     TRBO_TGLFAKTUR, TRBO_PERSENDISC1, TRBO_KODESUPPLIER, SUP_KODESUPPLIER,
                                                     SUP_PKP, TRBO_ISTYPE, TRBO_PERSENDISC2, TRBO_PERSENDISC2II,
                                                     TRBO_PERSENDISC2III, TRBO_SEQNO, TRBO_PERSENDISC3, PRD_KODEDIVISI,
                                                     TRBO_PERSENDISC4, PRD_KODEDEPARTEMENT, TRBO_RPHDISC1, TPOD_SATUANBELI,
                                                     TPOD_ISIBELI, PRD_KODEKATEGORIBARANG,TRBO_RPHDISC2, TRBO_RPHDISC2II,
                                                     TRBO_RPHDISC2III, PRD_FLAGBKP1, TRBO_RPHDISC3, PRD_FLAGBKP2, TRBO_RPHDISC4,
                                                     TRBO_LOC, TRBO_FLAGDISC1, TRBO_FLAGDISC2, TRBO_FLAGDISC3, TRBO_FLAGDISC4,
                                                     TRBO_DIS4CP, TRBO_DIS4RP, TRBO_DIS4JP, TRBO_PPNRPH, TRBO_KETERANGAN,
                                                     PRD_KODETAG, TPOH_NOPO, TPOH_TOP, TPOH_FLAGALOKASI
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
            dd($type);
            foreach ($checkDummyVar as $data) {
                $updplu = false;
                $typeTrn = $data->trbo_typetrn;
                $prd_code = '';
                $NDISC4 =  $data->trbo_dis4cr +  $data->trbo_dis4jr +  $data->trbo_dis4rr;
                try {
                    $prd_code = $data->st_prdcd;
                    throw new TestException();
                } catch (TestException $e) {
                    $prd_code = $data->prd_prdcd;
                } catch (Exception $e) {
                    $prd_code = 0;
                }
                if ($prd_code == 0) {
                    $updplu = true;

                    DB::connection(Session::get('connection'))->table('TBMASTER_STOCK')->insert([
                        "ST_KODEIGR" => $data->trbo_kodeigr,
                        "ST_PRDCD" => $prd_code,
                        "ST_LOKASI" => '01'
                    ]);
                }
                if ($data->prd_lastcost == 0 && $data->prd_avgcost == 0) {
                    $updplu = true;
                }
                if (substr($prd_code, -1) == '1' || $data->prd_unit == 'KG') {
                    $NOLDACOST  = $data->prd_avgcost;
                    $NOLDACOSTX = $data->st_avgcost;
                } else {
                    $NOLDACOST = $data->prd_avgcost / $data->prd_frac;
                }

                if ($data->prd_unit != 'KG') {
                    if ($data->st_saldoakhir > 0) {
                        $NACOST = (($data->st_saldoakhir * $NOLDACOST) + ($data->trbo_gross - $data->trbo_discrph + $NDISC4 + $data->trbo_ppnbmrph + $data->trbo_ppnbtlrph)) / ($data->st_saldoakhir + ($data->trbo_qty + $data->trbo_qtybonus1));
                        $NACOSTX = (($data->st_saldoakhir * $NOLDACOSTX) + ($data->trbo_gross - $data->trbo_discrph + $NDISC4 + $data->trbo_ppnbmrph + $data->trbo_ppnbtlrph)) / ($data->st_saldoakhir + ($data->trbo_qty + $data->trbo_qtybonus1));
                    } else {
                        $NACOST = (($data->trbo_gross - $data->trbo_discrph + $NDISC4 + $data->trbo_ppnbmrph + $data->trbo_ppnbtlrph) / ($data->trbo_qty + $data->trbo_qtybonus1));
                        $NACOSTX = $NACOST;
                    }
                } else {
                    if ($data->st_saldoakhir > 0) {
                        $NACOST = (($data->st_saldoakhir / 1000 * $NOLDACOST) + ($data->trbo_gross - $data->trbo_discrph + $NDISC4 + $data->trbo_ppnbmrph + $data->trbo_ppnbtlrph)) / (($data->st_saldoakhir + ($data->trbo_qty + $data->trbo_qtybonus1)) / 1000);
                        $NACOSTX = (($data->st_saldoakhir / 1000 * $NOLDACOSTX) + ($data->trbo_gross - $data->trbo_discrph + $NDISC4 + $data->trbo_ppnbmrph + $data->trbo_ppnbtlrp)) / (($data->st_saldoakhir + ($data->trbo_qty + $data->trbo_qtybonus1)) / 1000);
                    } else {
                        $NACOST = (($data->trbo_gross - $data->trbo_discrph + $NDISC4 + $data->trbo_ppnbmrph + $data->trbo_ppnbtlrph) / (($data->trbo_qty + $data->trbo_qtybonus1) / 1000));
                        $NACOSTX = $NACOST;
                    }
                }

                if ($data->tpoh_nopo == '12345678') {
                    $SUPTOP = $data->sup_top;
                } else {
                    $SUPTOP = $data->tpoh_top;
                }
//--                //belum kelar
                if ($data->prd_lastcost == 0) {
                    if ($data->prd_avgcost > 0) {
                        return ['kode' => 0, 'message' => "PLU " . $data->prd_prdcd . " Avg Cost <> 0, Lakukan Update PKM?"];
                        $dummyvar = 0;
                        try {
                            $sub_prdcd = substr($data->trbo_prdcd, 1, 6);
                        } catch (Exception $e) {
                            $sub_prdcd = 0;
                        }
                        $query = oci_parse($conn, "BEGIN SP_PKM_BPB (:IGR, :PRDCD, :USID, :PS, :PE); END;");
                        oci_bind_by_name($query, ':IGR', $kodeigr);
                        oci_bind_by_name($query, ':PRDCD', $sub_prdcd);
                        oci_bind_by_name($query, ':USID', $userId);
                        oci_bind_by_name($query, ':PS', $P_SUKSES);
                        oci_bind_by_name($query, ':PE', $P_ERROR);
                        oci_execute($query);
                        //P_SUKSES + P_ERROR buat apa?

                        DB::connection(Session::get('connection'))->table('TBMASTER_BARANGBARU')
                            ->where('PLN_PRDCD', $data->trbo_prdcd)
                            ->update(['PLN_TGLBPB' => date("d/m/Y")]);
                    }
                }
//--                //belum kelar

                $trbo_nopo = '';
                $unit = '';
                $frac = '';
                $sum = 0;
                if ($data->trbo_nopo == null || $data->trbo_nopo == '') {
                    $trbo_nopo = 'AA1';
                    $unit = $data->prd_unit;
                    $frac = $data->prd_frac;
                } else {
                    $trbo_nopo = $data->trbo_nopo;
                    $unit = $data->tpod_satuanbeli;
                    $frac = $data->tpod_isibeli;
                }

                if ($data->prd_unit != 'KG') {
                    $sum = 1;
                } else {
                    $sum = 1000;
                }
                DB::connection(Session::get('connection'))->table('TBTR_MSTRAN_D')->insert([
                    "MSTD_TYPETRN" => $data->trbo_typetrn, 
                    "MSTD_NODOC" => $data->trbo_nodoc, 
                    "MSTD_TGLDOC" => date("d/m/Y"), 
                    "MSTD_NOPO" => $data->trbo_nopo, 
                    "MSTD_TGLPO" => $data->trbo_tglpo,
                    "MSTD_NOFAKTUR" => $data->trbo_nofaktur, 
                    "MSTD_TGLFAKTUR" => $data->trbo_tglfaktur, 
                    "MSTD_ISTYPE" => $data->trbo_istype, 
                    "MSTD_KODESUPPLIER" => $data->sup_kodesupplier,
                    "MSTD_PKP" => $data->sup_pkp, 
                    "MSTD_KODEIGR" => $data->trbo_kodeigr, 
                    "MSTD_SEQNO" => $data->trbo_seqno, 
                    "MSTD_PRDCD" => $data->trbo_prdcd,
                    "MSTD_KODEDIVISI" => $data->prd_kodedivisi, 
                    "MSTD_KODEDEPARTEMENT" => $data->prd_kodedepartement,
                    "MSTD_KODEKATEGORIBRG" => $data->prd_kodekategoribarang,
                    "MSTD_BKP" => $data->prd_flagbkp1,
                    "MSTD_FOBKP" => $data->prd_flagbkp2,
                    "MSTD_UNIT" => $unit,
                    "MSTD_FRAC" => $frac,
                    "MSTD_LOC" => $data->trbo_loc,
                    "MSTD_QTY" => $data->trbo_qty,
                    "MSTD_QTYBONUS1" => $data->trbo_qtybonus1,
                    "MSTD_QTYBONUS2" => $data->trbo_qtybonus2,
                    "MSTD_HRGSATUAN" => $data->trbo_hrgsatuan,
                    "MSTD_PERSENDISC1" => $data->trbo_persendisc1,
                    "MSTD_PERSENDISC2" => $data->trbo_persendisc2,
                    "MSTD_PERSENDISC2II" => $data->trbo_persendisc2ii,
                    "MSTD_PERSENDISC2III" => $data->trbo_persendisc2iii,
                    "MSTD_PERSENDISC3" => $data->trbo_persendisc3,
                    "MSTD_PERSENDISC4" => $data->trbo_persendisc4,
                    "MSTD_RPHDISC1" => $data->trbo_rphdisc1,
                    "MSTD_RPHDISC2" => $data->trbo_rphdisc2,
                    "MSTD_RPHDISC2II" => $data->trbo_rphdisc2ii,
                    "MSTD_RPHDISC2III" => $data->trbo_rphdisc2iii,
                    "MSTD_RPHDISC3" => $data->trbo_rphdisc3,
                    "MSTD_RPHDISC4" => $data->trbo_rphdisc4,
                    "MSTD_FLAGDISC1" => $data->trbo_flagdisc1,
                    "MSTD_FLAGDISC2" => $data->trbo_flagdisc2,
                    "MSTD_FLAGDISC3" => $data->trbo_flagdisc3,
                    "MSTD_FLAGDISC4" => $data->trbo_flagdisc4,
                    "MSTD_DIS4CP" => $data->trbo_dis4cp,
                    "MSTD_DIS4CR" => $data->trbo_dis4cr,
                    "MSTD_DIS4RP" => $data->trbo_dis4rp,
                    "MSTD_DIS4RR" => $data->trbo_dis4rr,
                    "MSTD_DIS4JP" => $data->trbo_dis4jp,
                    "MSTD_DIS4JR" => $data->trbo_dis4jr,
                    "MSTD_GROSS" => $data->trbo_gross,
                    "MSTD_DISCRPH" => $data->trbo_discrph,
                    "MSTD_PPNRPH" => $data->trbo_ppnrph,
                    "MSTD_PPNBMRPH" => $data->trbo_ppnbmrph,
                    "MSTD_PPNBTLRPH" => $data->trbo_ppnbtlrph,
                    "MSTD_AVGCOST" => $NACOSTX * $frac / $sum,
                    "MSTD_OCOST" => $NOLDACOSTX * $frac / $sum,
                    "MSTD_POSQTY" => $data->st_saldoakhir,
                    "MSTD_KETERANGAN" => $data->trbo_keterangan,
                    "MSTD_KODETAG" => $data->prd_kodetag,
                    "MSTD_FURGNT" => $data->trbo_furgnt,
                    "MSTD_CREATE_BY" => $userId,
                    "MSTD_CREATE_DT" => date("d/m/Y"),
                    "MSTD_CTERM" => $data->sup_top
                ]);
//ini apa?                // CKSJ := FALSE;

            }

            // if ($data->prd_avgcost) {
            //     return ['kode' => 0, 'message' => "PLU " . $data->prd_prdcd . " Abg Cost <> 0, Lakukan Update PKM?"];
            // }
            // $dummyvar = 0;
        }
        /*

    IF :PARAMETER.TERIMA = 'B'
    THEN
        NO_BTB :=
            F_IGR_GET_NOMOR (:PARAMETER.KODEIGR,
                             'BPB',
                             'Nomor BPB',
                             '0' || TO_CHAR (SYSDATE, 'yy'),
                             5,
                             TRUE
                            );
    ELSE
        NO_BTB :=
            F_IGR_GET_NOMOR (:PARAMETER.KODEIGR,
                             'BPL',
                             'Nomor BPB Lain-Lain',
                             '1' || TO_CHAR (SYSDATE, 'yy'),
                             5,
                             TRUE
                            );
    END IF;

    FOR REC IN (SELECT   TRBO_PRDCD, TRBO_TYPETRN, TRBO_DIS4CR, ST_PRDCD, PRD_PRDCD, PRD_UNIT,
                         TRBO_DIS4JR, TRBO_DIS4RR, PRD_AVGCOST, ST_AVGCOST, PRD_FRAC, ST_SALDOAKHIR,
                         TRBO_GROSS, TRBO_DISCRPH, TRBO_PPNBMRPH, TRBO_PPNBTLRPH, NVL(TRBO_QTY, 0) TRBO_QTY,
                         TRBO_QTYBONUS1, SUP_TOP, TRBO_NOPO, TRBO_FURGNT, TRBO_KODEIGR, TRBO_TGLPO,
                         TRBO_NODOC, TRBO_QTYBONUS2, TRBO_NOFAKTUR, TRBO_HRGSATUAN, PRD_LASTCOST,
                         TRBO_TGLFAKTUR, TRBO_PERSENDISC1, TRBO_KODESUPPLIER, SUP_KODESUPPLIER,
                         SUP_PKP, TRBO_ISTYPE, TRBO_PERSENDISC2, TRBO_PERSENDISC2II,
                         TRBO_PERSENDISC2III, TRBO_SEQNO, TRBO_PERSENDISC3, PRD_KODEDIVISI,
                         TRBO_PERSENDISC4, PRD_KODEDEPARTEMENT, TRBO_RPHDISC1, TPOD_SATUANBELI,
                         TPOD_ISIBELI, PRD_KODEKATEGORIBARANG, TRBO_RPHDISC2, TRBO_RPHDISC2II,
                         TRBO_RPHDISC2III, PRD_FLAGBKP1, TRBO_RPHDISC3, PRD_FLAGBKP2, TRBO_RPHDISC4,
                         TRBO_LOC, TRBO_FLAGDISC1, TRBO_FLAGDISC2, TRBO_FLAGDISC3, TRBO_FLAGDISC4,
                         TRBO_DIS4CP, TRBO_DIS4RP, TRBO_DIS4JP, TRBO_PPNRPH, TRBO_KETERANGAN,
                         PRD_KODETAG, TPOH_NOPO, TPOH_TOP, TPOH_FLAGALOKASI
                    FROM TBTR_BACKOFFICE AA,
                         TBMASTER_PRODMAST BB,
                         TBMASTER_SUPPLIER CC,
                         TBMASTER_STOCK DD,
                         TBMASTER_LOKASI EE,
                         TBTR_PO_D FF,
                         TBTR_PO_H GG
                   WHERE AA.TRBO_NODOC = :NO_BTB
                     AND (NVL(TRBO_QTY, 0) + NVL(TRBO_QTYBONUS1, 0) + NVL(TRBO_QTYBONUS2, 0)) <> 0
                     AND BB.PRD_PRDCD = AA.TRBO_PRDCD
                     AND BB.PRD_KODEIGR = :PARAMETER.KODEIGR
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
                     AND GG.TPOH_KODEIGR(+) = :PARAMETER.KODEIGR
                     AND GG.TPOH_NOPO(+) = AA.TRBO_NOPO
                     AND NVL (GG.TPOH_RECORDID, '0') <> '1'
                ORDER BY AA.TRBO_PRDCD)
    LOOP
        UPDPLU := FALSE;
        TYPETRN := REC.TRBO_TYPETRN;
        NDISC4 := NVL (REC.TRBO_DIS4CR, 0) + NVL (REC.TRBO_DIS4JR, 0) + NVL (REC.TRBO_DIS4RR, 0);

        IF REC.ST_PRDCD IS NULL
        THEN
            UPDPLU := TRUE;

            INSERT INTO TBMASTER_STOCK
                        (ST_KODEIGR, ST_PRDCD, ST_LOKASI
                        )
                 VALUES (:PARAMETER.KODEIGR, REC.TRBO_PRDCD, '01'
                        );

            FORMS_DDL ('commit');
        END IF;

        IF NVL (REC.PRD_LASTCOST, 0) = 0 AND NVL (REC.PRD_AVGCOST, 0) = 0
        THEN
            UPDPLU := TRUE;
        END IF;

        IF SUBSTR (REC.PRD_PRDCD, -1) = '1' OR trim (REC.PRD_UNIT) = 'KG'
        THEN
            NOLDACOST := NVL (REC.PRD_AVGCOST, 0);
            NOLDACOSTX := NVL (REC.ST_AVGCOST, 0);
        ELSE
            NOLDACOST := NVL (REC.PRD_AVGCOST, 0) / REC.PRD_FRAC;
            NOLDACOSTX := NVL (REC.ST_AVGCOST, 0);
        END IF;

        IF TRIM (REC.PRD_UNIT) <> 'KG'
        THEN
            IF REC.ST_SALDOAKHIR > 0
            THEN
                NACOST :=
                      (  (REC.ST_SALDOAKHIR * NOLDACOST)
                       + (  REC.TRBO_GROSS
                          - REC.TRBO_DISCRPH
                          + NDISC4
                          + REC.TRBO_PPNBMRPH
                          + REC.TRBO_PPNBTLRPH
                         )
                      )
                    / (REC.ST_SALDOAKHIR + (REC.TRBO_QTY + REC.TRBO_QTYBONUS1));
                NACOSTX :=
                      (  (REC.ST_SALDOAKHIR * NOLDACOSTX)
                       + (  REC.TRBO_GROSS
                          - REC.TRBO_DISCRPH
                          + NDISC4
                          + REC.TRBO_PPNBMRPH
                          + REC.TRBO_PPNBTLRPH
                         )
                      )
                    / (REC.ST_SALDOAKHIR + (REC.TRBO_QTY + REC.TRBO_QTYBONUS1));
            ELSE
                NACOST :=
                    (  (  REC.TRBO_GROSS
                        - REC.TRBO_DISCRPH
                        + NDISC4
                        + REC.TRBO_PPNBMRPH
                        + REC.TRBO_PPNBTLRPH
                       )
                     / (REC.TRBO_QTY + REC.TRBO_QTYBONUS1)
                    );
                NACOSTX := NACOST;
            END IF;

            IF NACOST <= 0
            THEN
                NACOST :=
                    (  (  REC.TRBO_GROSS
                        - REC.TRBO_DISCRPH
                        + NDISC4
                        + REC.TRBO_PPNBMRPH
                        + REC.TRBO_PPNBTLRPH
                       )
                     / (REC.TRBO_QTY + REC.TRBO_QTYBONUS1)
                    );
            END IF;

            IF NACOSTX <= 0
            THEN
                NACOSTX :=
                    (  (  REC.TRBO_GROSS
                        - REC.TRBO_DISCRPH
                        + NDISC4
                        + REC.TRBO_PPNBMRPH
                        + REC.TRBO_PPNBTLRPH
                       )
                     / (REC.TRBO_QTY + REC.TRBO_QTYBONUS1)
                    );
            END IF;
        ELSE
            -------------- KILO-an --------------
            IF REC.ST_SALDOAKHIR > 0
            THEN
                NACOST :=
                      (  (REC.ST_SALDOAKHIR / 1000 * NOLDACOST)
                       + (  REC.TRBO_GROSS
                          - REC.TRBO_DISCRPH
                          + NDISC4
                          + REC.TRBO_PPNBMRPH
                          + REC.TRBO_PPNBTLRPH
                         )
                      )
                    / ((REC.ST_SALDOAKHIR + REC.TRBO_QTY + REC.TRBO_QTYBONUS1) / 1000);
                NACOSTX :=
                      (  (REC.ST_SALDOAKHIR / 1000 * NOLDACOSTX)
                       + (  REC.TRBO_GROSS
                          - REC.TRBO_DISCRPH
                          + NDISC4
                          + REC.TRBO_PPNBMRPH
                          + REC.TRBO_PPNBTLRPH
                         )
                      )
                    / ((REC.ST_SALDOAKHIR + REC.TRBO_QTY + REC.TRBO_QTYBONUS1) / 1000);
            ELSE
                NACOST :=
                    (  (  REC.TRBO_GROSS
                        - REC.TRBO_DISCRPH
                        + NDISC4
                        + REC.TRBO_PPNBMRPH
                        + REC.TRBO_PPNBTLRPH
                       )
                     / ((REC.TRBO_QTY + REC.TRBO_QTYBONUS1) / 1000)
                    );
                NACOSTX := NACOST;
            END IF;

            IF NACOST <= 0
            THEN
                NACOST :=
                    (  (  REC.TRBO_GROSS
                        - REC.TRBO_DISCRPH
                        + NDISC4
                        + REC.TRBO_PPNBMRPH
                        + REC.TRBO_PPNBTLRPH
                       )
                     / ((REC.TRBO_QTY + REC.TRBO_QTYBONUS1) / 1000)
                    );
            END IF;

            IF NACOSTX <= 0
            THEN
                NACOSTX :=
                    (  (  REC.TRBO_GROSS
                        - REC.TRBO_DISCRPH
                        + NDISC4
                        + REC.TRBO_PPNBMRPH
                        + REC.TRBO_PPNBTLRPH
                       )
                     / ((REC.TRBO_QTY + REC.TRBO_QTYBONUS1) / 1000)
                    );
            END IF;
        END IF;

        IF NVL (REC.TPOH_NOPO, '12345678') = '12345678'
        THEN
            SUPTOP := REC.SUP_TOP;
        ELSE
            SUPTOP := REC.TPOH_TOP;
        END IF;

                        --pengecekan plu baru utk selanjutnya dimasukkan ke dalam table pkm
                /*SELECT NVL (COUNT (1), 0)
                  INTO TEMP
                  FROM TBTR_MSTRAN_D
                 WHERE MSTD_PRDCD LIKE SUBSTR (REC.TRBO_PRDCD, 1, 6) || '%';
        */
        /*IF NVL (REC.PRD_LASTCOST, 0) = 0
        THEN
            IF NVL (REC.PRD_AVGCOST, 0) <> 0
            THEN
                Set_Alert_Property (ALERT_ID,
                                    ALERT_MESSAGE_TEXT,
                                    'PLU ' || REC.PRD_PRDCD
                                    || ' Avg Cost <> 0, Lakukan Update PKM ?'
                                   );
                DUMMY_VAR := Show_Alert (ALERT_ID);

                IF DUMMY_VAR = ALERT_BUTTON1
                THEN
                    SP_PKM_BPB (:PARAMETER.KODEIGR,
                                SUBSTR (REC.TRBO_PRDCD, 1, 6) || '0',
                                :PARAMETER.USID,
                                P_SUKSES,
                                P_ERROR
                               );

                    UPDATE TBMASTER_BARANGBARU
                       SET PLN_TGLBPB = TRUNC (SYSDATE)
                     WHERE PLN_PRDCD = REC.TRBO_PRDCD
                       AND NVL (PLN_TGLBPB, TO_DATE ('01/01/2000', 'dd/MM/RRRR')) =
                                                                TO_DATE ('01/01/2000', 'dd/MM/RRRR');
                END IF;
            ELSE
                SP_PKM_BPB (:PARAMETER.KODEIGR,
                            SUBSTR (REC.TRBO_PRDCD, 1, 6) || '0',
                            :PARAMETER.USID,
                            P_SUKSES,
                            P_ERROR
                           );

                UPDATE TBMASTER_BARANGBARU
                   SET PLN_TGLBPB = TRUNC (SYSDATE)
                 WHERE PLN_PRDCD = REC.TRBO_PRDCD
                   AND NVL (PLN_TGLBPB, TO_DATE ('01/01/2000', 'dd/MM/RRRR')) =
                                                                TO_DATE ('01/01/2000', 'dd/MM/RRRR');
            END IF;
        END IF;

        INSERT INTO TBTR_MSTRAN_D
                    (MSTD_TYPETRN, MSTD_NODOC, MSTD_TGLDOC, MSTD_NOPO, MSTD_TGLPO,
                     MSTD_NOFAKTUR, MSTD_TGLFAKTUR, MSTD_ISTYPE, MSTD_KODESUPPLIER,
                     MSTD_PKP, MSTD_KODEIGR, MSTD_SEQNO, MSTD_PRDCD,
                     MSTD_KODEDIVISI, MSTD_KODEDEPARTEMENT, MSTD_KODEKATEGORIBRG,
                     MSTD_BKP, MSTD_FOBKP,
                     MSTD_UNIT,
                     MSTD_FRAC,
                     MSTD_LOC, MSTD_QTY, MSTD_QTYBONUS1, MSTD_QTYBONUS2,
                     MSTD_HRGSATUAN, MSTD_PERSENDISC1, MSTD_PERSENDISC2,
                     MSTD_PERSENDISC2II, MSTD_PERSENDISC2III, MSTD_PERSENDISC3,
                     MSTD_PERSENDISC4, MSTD_RPHDISC1, MSTD_RPHDISC2,
                     MSTD_RPHDISC2II, MSTD_RPHDISC2III, MSTD_RPHDISC3,
                     MSTD_RPHDISC4, MSTD_FLAGDISC1, MSTD_FLAGDISC2, MSTD_FLAGDISC3,
                     MSTD_FLAGDISC4, MSTD_DIS4CP, MSTD_DIS4CR, MSTD_DIS4RP,
                     MSTD_DIS4RR, MSTD_DIS4JP, MSTD_DIS4JR, MSTD_GROSS,
                     MSTD_DISCRPH, MSTD_PPNRPH, MSTD_PPNBMRPH, MSTD_PPNBTLRPH,
                     MSTD_AVGCOST,
                     MSTD_OCOST,
                     MSTD_POSQTY, MSTD_KETERANGAN, MSTD_KODETAG, MSTD_FURGNT,
                     MSTD_CREATE_BY, MSTD_CREATE_DT, MSTD_CTERM
                    )
             VALUES (REC.TRBO_TYPETRN, NO_BTB, TRUNC (SYSDATE), REC.TRBO_NOPO, REC.TRBO_TGLPO,
                     REC.TRBO_NOFAKTUR, REC.TRBO_TGLFAKTUR, REC.TRBO_ISTYPE, REC.SUP_KODESUPPLIER,
                     REC.SUP_PKP, :PARAMETER.KODEIGR, REC.TRBO_SEQNO, REC.TRBO_PRDCD,
                     REC.PRD_KODEDIVISI, REC.PRD_KODEDEPARTEMENT, REC.PRD_KODEKATEGORIBARANG,
                     REC.PRD_FLAGBKP1, REC.PRD_FLAGBKP2,
                     CASE
                         WHEN NVL (REC.TRBO_NOPO, 'AA1') = 'AA1'
                             THEN REC.PRD_UNIT
                         ELSE REC.TPOD_SATUANBELI
                     END,
                     CASE
                         WHEN NVL (REC.TRBO_NOPO, 'AA1') = 'AA1'
                             THEN REC.PRD_FRAC
                         ELSE REC.TPOD_ISIBELI
                     END,
                     REC.TRBO_LOC, REC.TRBO_QTY, REC.TRBO_QTYBONUS1, REC.TRBO_QTYBONUS2,
                     REC.TRBO_HRGSATUAN, REC.TRBO_PERSENDISC1, REC.TRBO_PERSENDISC2,
                     REC.TRBO_PERSENDISC2II, REC.TRBO_PERSENDISC2III, REC.TRBO_PERSENDISC3,
                     REC.TRBO_PERSENDISC4, REC.TRBO_RPHDISC1, REC.TRBO_RPHDISC2,
                     REC.TRBO_RPHDISC2II, REC.TRBO_RPHDISC2III, REC.TRBO_RPHDISC3,
                     REC.TRBO_RPHDISC4, REC.TRBO_FLAGDISC1, REC.TRBO_FLAGDISC2, REC.TRBO_FLAGDISC3,
                     REC.TRBO_FLAGDISC4, REC.TRBO_DIS4CP, REC.TRBO_DIS4CR, REC.TRBO_DIS4RP,
                     REC.TRBO_DIS4RR, REC.TRBO_DIS4JP, REC.TRBO_DIS4JR, REC.TRBO_GROSS,
                     REC.TRBO_DISCRPH, REC.TRBO_PPNRPH, REC.TRBO_PPNBMRPH, REC.TRBO_PPNBTLRPH,
                       (  NACOSTX
                        * CASE
                              WHEN NVL (REC.TRBO_NOPO, 'AA1') = 'AA1'
                                  THEN REC.PRD_FRAC
                              ELSE REC.TPOD_ISIBELI
                          END
                       )
                     / CASE
                           WHEN TRIM (REC.PRD_UNIT) = 'KG'
                               THEN 1000
                           ELSE 1
                       END,
                       NOLDACOSTX
                     * CASE
                           WHEN NVL (REC.TRBO_NOPO, 'AA1') = 'AA1'
                               THEN REC.PRD_FRAC
                           ELSE REC.TPOD_ISIBELI
                       END
                     / CASE
                           WHEN TRIM (REC.PRD_UNIT) = 'KG'
                               THEN 1000
                           ELSE 1
                       END,
                     REC.ST_SALDOAKHIR, REC.TRBO_KETERANGAN, REC.PRD_KODETAG, REC.TRBO_FURGNT,
                     :PARAMETER.USID, SYSDATE, SUPTOP
                    );

        CKSJ := FALSE;

        --IF :parameter.kodeigr ='05' AND  :parameter.terima ='B' then
        IF :PARAMETER.TERIMA = 'B'
        THEN
            IF REC.TRBO_FURGNT = '3'
            THEN
                FOR REC2 IN (SELECT *
                               FROM TBTR_PO_D, TBTR_PB_D
                              WHERE TPOD_NOPO = REC.TRBO_NOPO
                                AND TPOD_PRDCD = REC.TRBO_PRDCD
                                AND PBD_NOPO = TPOD_NOPO
                                AND PBD_PRDCD = TPOD_PRDCD)
                LOOP
                    FOR PBCABG IN (SELECT *
                                     FROM TBTR_PBCABANG_GUDANGPUSAT
                                    WHERE PBC_NOPBGUDANGPUSAT = REC2.PBD_NOPB
                                      AND PBC_PRDCD = REC2.PBD_PRDCD)
                    LOOP
                        IF    NVL (PBCABG.PBC_RECORDID, '0') = '1'
                           OR NVL (PBCABG.PBC_RECORDID, '0') = '3'
                        THEN
                            IF NVL (PBCABG.PBC_RECORDID, '0') = '3'
                            THEN
                                IF NVL (PBCABG.PBC_QTYPB, 0) - NVL (PBCABG.PBC_QTYBBP, 0) = 0
                                THEN
                                    EXIT;
                                END IF;
                            END IF;

                            IF PBCABG.PBC_KODECABANG = '03'
                            THEN
                                CKODE := '1';
                            ELSIF PBCABG.PBC_KODECABANG = '06'
                            THEN
                                CKODE := '2';
                            ELSIF PBCABG.PBC_KODECABANG = '04'
                            THEN
                                CKODE := '3';
                            ELSIF PBCABG.PBC_KODECABANG = '01'
                            THEN
                                CKODE := '4';
                            ELSIF PBCABG.PBC_KODECABANG = '02'
                            THEN
                                CKODE := '5';
                            ELSE
                                CKODE := '6';
                            END IF;

                            SELECT NVL (COUNT (1), 0)
                              INTO TEMP
                              FROM TBTR_LISTPACKING
                             WHERE PCL_RECORDID IS NULL
                               AND PCL_KODECABANG = PBCABG.PBC_KODECABANG
                               AND PCL_NOREFERENSI = PBCABG.PBC_NOPBCABANG
                               AND PCL_PRDCD = REC.TRBO_PRDCD;

                            IF TEMP = 0
                            THEN
                                INSERT INTO TBTR_LISTPACKING
                                            (PCL_KODEIGR, PCL_RECORDID, PCL_KODECABANG,
                                             PCL_NOREFERENSI, PCL_NOREFERENSI1, PCL_PRDCD
                                            )
                                     VALUES (:PARAMETER.KODEIGR, NULL, PBCABG.PBC_KODECABANG,
                                             PBCABG.PBC_NOPBCABANG, REC.TRBO_NODOC, REC.TRBO_PRDCD
                                            );

                                FORMS_DDL ('commit');
                            END IF;

                            IF NVL (PBCABG.PBC_RECORDID, '0') = '3'
                            THEN
                                QTY_O :=
                                    ROUND (  ((NVL (PBCABG.PBC_QTYPB, 0)
                                               - NVL (PBCABG.PBC_QTYBBP, 0)
                                              )
                                             )
                                           / REC.PRD_FRAC
                                          );
                                QTY_OK :=
                                      (NVL (PBCABG.PBC_QTYPB, 0) - NVL (PBCABG.PBC_QTYBBP, 0))
                                    - (  ROUND (  NVL (PBCABG.PBC_QTYPB, 0)
                                                - NVL (PBCABG.PBC_QTYBBP, 0) / REC.PRD_FRAC
                                               )
                                       * REC.PRD_FRAC
                                      );
                            ELSE
                                QTY_O := ROUND (NVL (PBCABG.PBC_QTYPB, 0) / REC.PRD_FRAC);
                                QTY_OK :=
                                      NVL (PBCABG.PBC_QTYPB, 0)
                                    - (ROUND (NVL (PBCABG.PBC_QTYPB, 0) / REC.PRD_FRAC)
                                       * REC.PRD_FRAC
                                      );
                            END IF;

                            UPDATE TBTR_LISTPACKING
                               SET PCL_KODE = CKODE,
                                   PCL_TGLREFERENSI = PBCABG.PBC_TGLPBCABANG,
                                   PCL_NODOKUMEN = NO_BTB || PBCABG.PBC_KODECABANG,
                                   PCL_TGLDOKUMEN = SYSDATE,
                                   --PCL_NoReferensi1 = rec.trbo_noreff,  LS
                                   PCL_QTY_O = QTY_O,
                                   PCL_QTY_OK = QTY_OK,
                                   PCL_QTYBONUS1 = REC.TRBO_QTYBONUS1,
                                   PCL_QTYBONUS2 = REC.TRBO_QTYBONUS2,
                                   PCL_HRG = REC.TRBO_HRGSATUAN,
                                   PCL_DISCPERSEN1 = REC.TRBO_PERSENDISC1,
                                   PCL_DISCPERSEN2 = REC.TRBO_PERSENDISC2,
                                   PCL_DISCPERSEN3 = REC.TRBO_PERSENDISC3,
                                   PCL_DISCPERSEN4 = REC.TRBO_PERSENDISC4,
                                   PCL_DISCRPH1 = REC.TRBO_RPHDISC1,
                                   PCL_DISCRPH2 = REC.TRBO_RPHDISC2,
                                   PCL_DISCRPH3 = REC.TRBO_RPHDISC3,
                                   PCL_DISCRPH4 = REC.TRBO_RPHDISC4,
                                   PCL_FLAGDISC1 = REC.TRBO_FLAGDISC1,
                                   PCL_FLAGDISC2 = REC.TRBO_FLAGDISC2,
                                   PCL_FLAGDISC3 = REC.TRBO_FLAGDISC3,
                                   PCL_FLAGDISC4 = REC.TRBO_FLAGDISC4,
                                   PCL_DIS4CP = REC.TRBO_DIS4CP,
                                   PCL_DIS4CR = REC.TRBO_DIS4CR,
                                   PCL_DIS4RP = REC.TRBO_DIS4RP,
                                   PCL_DIS4RR = REC.TRBO_DIS4RR,
                                   PCL_DIS4JP = REC.TRBO_DIS4JP,
                                   PCL_DIS4JR = REC.TRBO_DIS4JR,
                                   PCL_NILAI = REC.TRBO_GROSS,
                                   PCL_DISCRPH = REC.TRBO_DISCRPH,
                                   PCL_PPNRPH = REC.TRBO_PPNRPH,
                                   PCL_PPNBMRPH = REC.TRBO_PPNBMRPH,
                                   PCL_PPNBTLRPH = REC.TRBO_PPNBTLRPH,
                                   PCL_AVGCOST =
                                         (NACOSTX * REC.PRD_FRAC)
                                       / CASE
                                             WHEN TRIM (REC.PRD_UNIT) = 'KG'
                                                 THEN 1000
                                             ELSE 1
                                         END,
                                   PCL_KETERANGAN = 'PACKLIST OTOMATIS BPB GMS',
                                        --PCL_DOC =
                                        --PCL_DOC2 =
                                   -- PCL_TglFakturPajak =
                                   ---PCL_MTAG      = MSTRAN->Mtag
                                   PCL_CREATE_DT = TRUNC (SYSDATE),
                                   PCL_CREATE_BY = :PARAMETER.USID,
                                   PCL_FURGNT = REC.TRBO_FURGNT
                             WHERE PCL_RECORDID IS NULL
                               AND PCL_KODECABANG = PBCABG.PBC_KODECABANG
                               AND PCL_NOREFERENSI = PBCABG.PBC_NOPBCABANG
                               AND PCL_PRDCD = REC.TRBO_PRDCD;
                        END IF;
                    END LOOP;

                    TRUET := TRUE;

                    FOR PBCABG2 IN (SELECT *
                                      FROM TBTR_PBCABANG_GUDANGPUSAT
                                     WHERE PBC_NOPBGUDANGPUSAT = REC2.PBD_NOPB
                                       AND PBC_PRDCD = REC2.PBD_PRDCD
                                       AND PBC_KODECABANG = :PARAMETER.KODEIGR)
                    LOOP
                        IF     NVL (PBCABG2.PBC_RECORDID, '0') = '3'
                           AND NVL (PBCABG2.PBC_QTYPB, 0) - NVL (PBCABG2.PBC_QTYBBP, 0) = 0
                        THEN
                            TRUET := FALSE;
                        END IF;

                        IF TRUET = TRUE
                        THEN
                            SELECT NVL (COUNT (1), 0)
                              INTO TEMP
                              FROM TBTR_LISTPACKING
                             WHERE PCL_RECORDID IS NULL
                               AND PCL_KODECABANG = :PARAMETER.KODEIGR
                               AND PCL_NOREFERENSI = PBCABG2.PBC_NOPBCABANG
                               AND PCL_PRDCD = PBCABG2.PBC_PRDCD;

                            IF TEMP = 0
                            THEN
                                ORDER1 := 0;

                                FOR REC3 IN (SELECT *
                                               FROM TBTR_PBCABANG_GUDANGPUSAT
                                              WHERE PBC_NOPBGUDANGPUSAT = REC2.PBD_NOPB
                                                AND PBC_PRDCD = REC2.PBD_PRDCD)
                                LOOP
                                    IF    NVL (PBCABG2.PBC_RECORDID, '0') = '1'
                                       OR NVL (PBCABG2.PBC_RECORDID, '0') = '3'
                                    THEN
                                        ORDER1 := ORDER1 + NVL (PBCABG2.PBC_QTYPB, 0);
                                    END IF;
                                END LOOP;

                                IF ORDER1 < REC.TRBO_QTY
                                THEN
                                    CKODE := '6';

                                    SELECT NVL (COUNT (1), 0)
                                      INTO TEMP
                                      FROM TBTR_LISTPACKING
                                     WHERE PCL_RECORDID IS NULL
                                       AND PCL_KODECABANG = :PARAMETER.KODEIGR
                                       AND PCL_NOREFERENSI = PBCABG2.PBC_NOPBCABANG
                                       AND PCL_PRDCD = PBCABG2.PBC_PRDCD;

                                    IF TEMP = 0
                                    THEN
                                        IF TEMP = 0
                                        THEN
                                            INSERT INTO TBTR_LISTPACKING
                                                        (PCL_KODEIGR, PCL_RECORDID,
                                                         PCL_KODECABANG,
                                                         PCL_NOREFERENSI, PCL_NOREFERENSI1,
                                                         PCL_PRDCD
                                                        )
                                                 VALUES (:PARAMETER.KODEIGR, NULL,
                                                         PBCABG2.PBC_KODECABANG,
                                                         PBCABG2.PBC_NOPBCABANG, REC.TRBO_NODOC,
                                                         REC.TRBO_PRDCD
                                                        );

                                            FORMS_DDL ('commit');
                                        END IF;

                                        UPDATE TBTR_LISTPACKING
                                           SET PCL_KODE = CKODE,
                                               PCL_TGLREFERENSI = PBCABG2.PBC_TGLPBCABANG,
                                               PCL_NODOKUMEN = NO_BTB || PBCABG2.PBC_KODECABANG,
                                               PCL_TGLDOKUMEN = SYSDATE,
                                               --PCL_NoReferensi = rec.trbo_nopo,   LS
                                               PCL_QTY_O = QTY_O,
                                               PCL_QTY_OK = QTY_OK,
                                               PCL_QTYBONUS1 = REC.TRBO_QTYBONUS1,
                                               PCL_QTYBONUS2 = REC.TRBO_QTYBONUS2,
                                               PCL_HRG = REC.TRBO_HRGSATUAN,
                                               PCL_DISCPERSEN1 = REC.TRBO_PERSENDISC1,
                                               PCL_DISCPERSEN2 = REC.TRBO_PERSENDISC2,
                                               PCL_DISCPERSEN3 = REC.TRBO_PERSENDISC3,
                                               PCL_DISCPERSEN4 = REC.TRBO_PERSENDISC4,
                                               PCL_DISCRPH1 = REC.TRBO_RPHDISC1,
                                               PCL_DISCRPH2 = REC.TRBO_RPHDISC2,
                                               PCL_DISCRPH3 = REC.TRBO_RPHDISC3,
                                               PCL_DISCRPH4 = REC.TRBO_RPHDISC4,
                                               PCL_FLAGDISC1 = REC.TRBO_FLAGDISC1,
                                               PCL_FLAGDISC2 = REC.TRBO_FLAGDISC2,
                                               PCL_FLAGDISC3 = REC.TRBO_FLAGDISC3,
                                               PCL_FLAGDISC4 = REC.TRBO_FLAGDISC4,
                                               PCL_DIS4CP = REC.TRBO_DIS4CP,
                                               PCL_DIS4CR = REC.TRBO_DIS4CR,
                                               PCL_DIS4RP = REC.TRBO_DIS4RP,
                                               PCL_DIS4RR = REC.TRBO_DIS4RR,
                                               PCL_DIS4JP = REC.TRBO_DIS4JP,
                                               PCL_DIS4JR = REC.TRBO_DIS4JR,
                                               PCL_NILAI = REC.TRBO_GROSS,
                                               PCL_DISCRPH = REC.TRBO_DISCRPH,
                                               PCL_PPNRPH = REC.TRBO_PPNRPH,
                                               PCL_PPNBMRPH = REC.TRBO_PPNBMRPH,
                                               PCL_PPNBTLRPH = REC.TRBO_PPNBTLRPH,
                                               PCL_AVGCOST =
                                                     (NACOSTX * REC.PRD_FRAC)
                                                   / CASE
                                                         WHEN TRIM (REC.PRD_UNIT) = 'KG'
                                                             THEN 1000
                                                         ELSE 1
                                                     END,
                                               PCL_KETERANGAN = 'PACKLIST OTOMATIS BPB GMS',
                                                    --PCL_DOC =
                                                    --PCL_DOC2 =
                                               -- PCL_TglFakturPajak =
                                               ---PCL_MTAG      = MSTRAN->Mtag
                                               PCL_CREATE_DT = TRUNC (SYSDATE),
                                               PCL_CREATE_BY = :PARAMETER.USID,
                                               PCL_FURGNT = REC.TRBO_FURGNT
                                         WHERE PCL_RECORDID IS NULL
                                           AND PCL_KODECABANG = :PARAMETER.KODEIGR
                                           AND PCL_NOREFERENSI = PBCABG2.PBC_NOPBCABANG
                                           AND PCL_PRDCD = PBCABG2.PBC_PRDCD;
                                    END IF;
                                END IF;
                            END IF;
                        END IF;
                    END LOOP;
                --- KHUSUS PACKING LIST ELEKTRONIK
                END LOOP;
            END IF;
        END IF;

        IF NACOSTX <> 0
        THEN
            UPDATE TBMASTER_STOCK
               SET ST_AVGCOST = NACOSTX,
                   ST_SALDOAKHIR =
                          NVL (ST_SALDOAKHIR, 0) + NVL (REC.TRBO_QTY, 0)
                          + NVL (REC.TRBO_QTYBONUS1, 0),
                   ST_TRFIN = NVL (ST_TRFIN, 0) + NVL (REC.TRBO_QTY, 0)
                              + NVL (REC.TRBO_QTYBONUS1, 0),
                   ST_MODIFY_BY = :PARAMETER.USID,
                   ST_MODIFY_DT = TRUNC (SYSDATE)
             WHERE ST_PRDCD = REC.TRBO_PRDCD AND ST_LOKASI = '01' AND ST_KODEIGR =
                                                                                  :PARAMETER.KODEIGR;

            FOR REC2 IN (SELECT PRD_PRDCD, PRD_UNIT, PRD_FRAC
                           FROM TBMASTER_PRODMAST
                          WHERE SUBSTR (PRD_PRDCD, 1, 6) = SUBSTR (REC.TRBO_PRDCD, 1, 6)
                            AND PRD_KODEIGR = REC.TRBO_KODEIGR)
            LOOP
                IF SUBSTR (REC2.PRD_PRDCD, -1) = '1' OR TRIM (REC2.PRD_UNIT) = 'KG'
                THEN
                    UPDATE TBMASTER_PRODMAST
                       --SET prd_avgcost = nacost
                       --++22-03-13 Ard (P'Lili)
                       --SET prd_avgcost = nacost
                    SET PRD_AVGCOST = NACOSTX
                     ----22-03-13 Ard (P'Lili)
                    WHERE  PRD_PRDCD = REC2.PRD_PRDCD AND PRD_KODEIGR = :PARAMETER.KODEIGR;
                ELSE
                    UPDATE TBMASTER_PRODMAST
                       SET PRD_AVGCOST = NACOST * REC2.PRD_FRAC
                     WHERE PRD_PRDCD = REC2.PRD_PRDCD AND PRD_KODEIGR = :PARAMETER.KODEIGR;
                END IF;
            END LOOP;

            FORMS_DDL ('commit');
        END IF;

        TEMP := 0;

        SELECT NVL (COUNT (1), 0)
          INTO TEMP
          FROM TBHISTORY_COST
         WHERE HCS_PRDCD = REC.TRBO_PRDCD AND HCS_TGLBPB = TRUNC (SYSDATE) AND HCS_NODOCBPB = NO_BTB;

        IF TEMP = 0
        THEN
            INSERT INTO TBHISTORY_COST
                        (HCS_KODEIGR, HCS_LOKASI, HCS_TYPETRN, HCS_PRDCD,
                         HCS_TGLBPB, HCS_NODOCBPB,
                         HCS_QTYBARU, HCS_QTYLAMA,
                         HCS_AVGLAMA,
                         HCS_AVGBARU,
                         HCS_LASTQTY,
                         HCS_CREATE_BY, HCS_CREATE_DT
                        )
                 VALUES (:PARAMETER.KODEIGR, :PARAMETER.KODEIGR, TYPETRN, REC.TRBO_PRDCD,
                         TRUNC (SYSDATE), NO_BTB,
                         (NVL (REC.TRBO_QTY, 0) + NVL (REC.TRBO_QTYBONUS1, 0)
                         ), REC.ST_SALDOAKHIR,
                           NOLDACOSTX
                         * CASE
                               WHEN TRIM (REC.PRD_UNIT) = 'KG' OR SUBSTR (REC.PRD_PRDCD, -1) = '1'
                                   THEN 1
                               ELSE CASE
                               WHEN NVL (REC.TRBO_NOPO, 'AA1') = 'AA1'
                                   THEN REC.PRD_FRAC
                               ELSE REC.TPOD_ISIBELI
                           END
                           END,
                           NACOSTX
                         * CASE
                               WHEN TRIM (REC.PRD_UNIT) = 'KG' OR SUBSTR (REC.PRD_PRDCD, -1) = '1'
                                   THEN 1
                               ELSE CASE
                               WHEN NVL (REC.TRBO_NOPO, 'AA1') = 'AA1'
                                   THEN REC.PRD_FRAC
                               ELSE REC.TPOD_ISIBELI
                           END
                           END,
                         (  NVL (REC.ST_SALDOAKHIR, 0)
                          + NVL (REC.TRBO_QTY, 0)
                          + NVL (REC.TRBO_QTYBONUS1, 0)
                         ),
                         :PARAMETER.USID, SYSDATE
                        );
        END IF;

        NLCOST :=
              ((  REC.TRBO_GROSS
                - NVL (REC.TRBO_DISCRPH, 0)
                + NVL (REC.TRBO_DIS4CR, 0)
                + NVL (REC.TRBO_DIS4JR, 0)
                + NVL (REC.TRBO_DIS4RR, 0)
                + NVL (REC.TRBO_PPNBMRPH, 0)
                + NVL (REC.TRBO_PPNBTLRPH, 0)
               )
              )
            / (REC.TRBO_QTY + NVL (REC.TRBO_QTYBONUS1, 0));
        NLCOST := NLCOST * CASE
                      WHEN TRIM (REC.PRD_UNIT) = 'KG'
                          THEN 1000
                      ELSE 1
                  END;

        UPDATE TBHISTORY_COST
           SET HCS_LASTCOSTBARU =
                     NLCOST
                   * CASE
                         WHEN SUBSTR (REC.PRD_PRDCD, -1) = '1' OR TRIM (REC.PRD_UNIT) = 'KG'
                             THEN 1
                         ELSE CASE
                         WHEN NVL (REC.TRBO_NOPO, 'AA1') = 'AA1'
                             THEN REC.PRD_FRAC
                         ELSE REC.TPOD_ISIBELI
                     END
                     END,
               HCS_LASTCOSTLAMA = REC.PRD_LASTCOST
         WHERE HCS_PRDCD = REC.TRBO_PRDCD AND HCS_TGLBPB = TRUNC (SYSDATE) AND HCS_NODOCBPB = NO_BTB;

        IF NVL (NLCOST, 0) <> 0
        THEN
            UPDATE TBMASTER_STOCK
               SET ST_LASTCOST = NLCOST
             WHERE ST_PRDCD = REC.TRBO_PRDCD AND ST_KODEIGR = :PARAMETER.KODEIGR;

                       /* update lastcost utk all lokasi info pak daulay 9 nov 2011
                       UPDATE tbmaster_stock
              SET st_lastcost = nlcost
            WHERE st_prdcd = rec.trbo_prdcd AND st_lokasi = '01' AND st_kodeigr =
                                                                                 :parameter.kodeigr;*/
        /*FOR REC2 IN (SELECT PRD_PRDCD, PRD_UNIT, PRD_FRAC
                           FROM TBMASTER_PRODMAST
                          WHERE SUBSTR (PRD_PRDCD, 1, 6) = SUBSTR (REC.TRBO_PRDCD, 1, 6)
                            AND PRD_KODEIGR = REC.TRBO_KODEIGR)
            LOOP
                IF SUBSTR (REC2.PRD_PRDCD, -1) = '1' OR TRIM (REC2.PRD_UNIT) = 'KG'
                THEN
                    UPDATE TBMASTER_PRODMAST
                       SET PRD_LASTCOST = NLCOST
                     WHERE PRD_PRDCD = REC2.PRD_PRDCD AND PRD_KODEIGR = :PARAMETER.KODEIGR;

                    IF UPDPLU = TRUE
                    THEN
                        INSERT INTO TBTR_UPDATE_PLU_MD
                                    (UPD_KODEIGR, UPD_PRDCD, UPD_HARGA, UPD_ATRIBUTE1,
                                     UPD_CREATE_BY, UPD_CREATE_DT
                                    )
                             VALUES (:PARAMETER.KODEIGR, REC2.PRD_PRDCD, NLCOST, 'BPB',
                                     :PARAMETER.USID, SYSDATE
                                    );
                    END IF;
                ELSE
                    UPDATE TBMASTER_PRODMAST
                       SET PRD_LASTCOST = NLCOST * REC2.PRD_FRAC
                     WHERE PRD_PRDCD = REC2.PRD_PRDCD AND PRD_KODEIGR = :PARAMETER.KODEIGR;

                    IF UPDPLU = TRUE
                    THEN
                        INSERT INTO TBTR_UPDATE_PLU_MD
                                    (UPD_KODEIGR, UPD_PRDCD, UPD_HARGA,
                                     UPD_ATRIBUTE1, UPD_CREATE_BY, UPD_CREATE_DT
                                    )
                             VALUES (:PARAMETER.KODEIGR, REC2.PRD_PRDCD, NLCOST * REC2.PRD_FRAC,
                                     'BPB', :PARAMETER.USID, SYSDATE
                                    );
                    END IF;
                END IF;
            END LOOP;
        END IF;

        TEMP := 0;

        SUPCO := REC.SUP_KODESUPPLIER;
        NOPO := REC.TRBO_NOPO;
        NOFAKTUR := REC.TRBO_NOFAKTUR;
        PKP := REC.SUP_PKP;
        TGLPO := REC.TRBO_TGLPO;
        TGLFAKTUR := REC.TRBO_TGLFAKTUR;

        UPDATE TBTR_BACKOFFICE
           SET TRBO_NONOTA = NO_BTB,
               TRBO_TGLNOTA = TRUNC (SYSDATE)
         WHERE TRBO_NODOC = REC.TRBO_NODOC AND TRBO_PRDCD = REC.TRBO_PRDCD;
    END LOOP;

    INSERT INTO TBTR_MSTRAN_H
                (MSTH_KODEIGR, MSTH_TYPETRN, MSTH_NODOC, MSTH_TGLDOC, MSTH_FLAGDOC,
                 MSTH_KODESUPPLIER, MSTH_NOPO, MSTH_TGLPO, MSTH_NOFAKTUR, MSTH_TGLFAKTUR, MSTH_PKP,
                 MSTH_CTERM, MSTH_CREATE_BY, MSTH_CREATE_DT
                )
         VALUES (:PARAMETER.KODEIGR, TYPETRN, NO_BTB, TRUNC (SYSDATE), '1',
                 SUPCO, NOPO, TGLPO, NOFAKTUR, TGLFAKTUR, PKP,
                 SUPTOP, :PARAMETER.USID, TRUNC (SYSDATE)
                );

    IF SUPCO IS NOT NULL
    THEN
        SELECT NVL (COUNT (1), 0)
          INTO TEMP
          FROM TBTR_HUTANG
         WHERE HTG_TYPE = 'J' AND HTG_NODOKUMEN = NO_BTB AND NVL (HTG_RECORDID, 0) <> '1';

        FOR REC2 IN (SELECT   MSTD_KODESUPPLIER, MSTD_CTERM, MSTD_NOFAKTUR, MSTD_NOPO, MSTD_TGLPO,
                              MSTD_TGLFP, PRD_FLAGBKP1, PRD_FLAGBKP2,
                              SUM (  NVL (MSTD_GROSS, 0)
                                   - NVL (MSTD_DISCRPH, 0)
                                   + NVL (MSTD_PPNBMRPH, 0)
                                   + NVL (MSTD_PPNBTLRPH, 0)
                                  ) AMOUNT,
                              SUM (  NVL (MSTD_GROSS, 0)
                                   - NVL (MSTD_DISCRPH, 0)
                                   + NVL (MSTD_PPNBMRPH, 0)
                                   + NVL (MSTD_PPNBTLRPH, 0)
                                   + NVL (MSTD_PPNRPH, 0)
                                  ) BALANCE,
                              SUM (MSTD_PPNRPH) PPN, SUM (MSTD_PPNBMRPH) PPNBM,
                              SUM (MSTD_PPNBTLRPH) PPNBTL, SUM (MSTD_RPHDISC1) DISC1,
                              SUM (MSTD_RPHDISC2) DISC2, SUM (MSTD_RPHDISC2II) DISC2II,
                              SUM (MSTD_RPHDISC2III) DISC2III, SUM (MSTD_RPHDISC3) DISC3,
                              SUM (MSTD_RPHDISC4) DISC4, SUM (MSTD_DIS4CR) DISC4CR,
                              SUM (MSTD_DIS4RR) DISC4RR, SUM (MSTD_DIS4JR) DISC4JR, MSTH_CTERM
                         FROM TBTR_MSTRAN_D, TBMASTER_PRODMAST, TBTR_MSTRAN_H
                        WHERE MSTD_NODOC = NO_BTB
                          AND MSTD_KODEIGR = :PARAMETER.KODEIGR
                          AND MSTH_KODEIGR = :PARAMETER.KODEIGR
                          AND MSTH_NODOC = NO_BTB
                          AND PRD_PRDCD = MSTD_PRDCD
                          AND PRD_KODEIGR = MSTD_KODEIGR
                     GROUP BY MSTD_KODESUPPLIER,
                              MSTD_CTERM,
                              MSTD_NOFAKTUR,
                              MSTD_NOPO,
                              MSTD_TGLPO,
                              MSTD_TGLFP,
                              MSTD_KODESUPPLIER,
                              PRD_FLAGBKP1,
                              PRD_FLAGBKP2,
                              MSTH_CTERM)
        LOOP
            IF TEMP = 0
            THEN
                TGL := SYSDATE + REC2.MSTH_CTERM;

                INSERT INTO TBTR_HUTANG
                            (HTG_KODEIGR, HTG_RECORDID, HTG_TYPE, HTG_KODESUPPLIER, HTG_NODOKUMEN,
                             HTG_NODOKUMEN2, HTG_TGLFAKTURPAJAK, HTG_TGLJATUHTEMPO, HTG_TOP,
                             HTG_NOREFERENSI, HTG_TGLREFERENSI, HTG_NILAIHUTANG, HTG_FLAGBKP1,
                             HTG_FLAGBKP2, HTG_SALDO, HTG_RPHDISC1, HTG_RPHDISC2,
                             HTG_RPHDISC2II, HTG_RPHDISC2III, HTG_RPHDISC3, HTG_RPHDISC4,
                             HTG_DIS4CR, HTG_DIS4RR, HTG_DIS4JR, HTG_PPN, HTG_CREATEBY,
                             HTG_CREATEDT
                            )
                     VALUES (:PARAMETER.KODEIGR, NULL, 'J', REC2.MSTD_KODESUPPLIER, NO_BTB,
                             REC2.MSTD_NOFAKTUR, SYSDATE, TGL, REC2.MSTH_CTERM,
                             REC2.MSTD_NOPO, REC2.MSTD_TGLPO, REC2.AMOUNT, REC2.PRD_FLAGBKP1,
                             REC2.PRD_FLAGBKP2, REC2.BALANCE, REC2.DISC1, REC2.DISC2,
                             REC2.DISC2II, REC2.DISC2III, REC2.DISC3, REC2.DISC4,
                             REC2.DISC4CR, REC2.DISC4RR, REC2.DISC4JR, REC2.PPN, :PARAMETER.USID,
                             SYSDATE
                            );
            ELSE
                NULL;
            END IF;
        END LOOP;
    END IF;
EXCEPTION
    WHEN OTHERS
    THEN
        DC_ALERT.OK ('Update Data ' || SQLERRM);
END;*/
        $exec = oci_parse($conn, "BEGIN sp_penerimaan_updatedata(:kodeigr, :userid, :tipe, :dummyvar, :result); END;");
        oci_bind_by_name($exec, ':kodeigr', $kodeigr);
        oci_bind_by_name($exec, ':userid', $userId);
        oci_bind_by_name($exec, ':tipe', $type);
        oci_bind_by_name($exec, ':dummyvar', $dummyvar);
        oci_bind_by_name($exec, ':result', $result, 1000);
        oci_execute($exec);

        return ['kode' => 1, 'message' => "Success"];
    }

    public function update_data2($kodeigr, $conn, $type)
    {
        $exec = oci_parse($conn, "BEGIN sp_penerimaan_updatedata2(:kodeigr, :tipe, :result); END;");
        oci_bind_by_name($exec, ':kodeigr', $kodeigr);
        oci_bind_by_name($exec, ':tipe', $type);
        oci_bind_by_name($exec, ':result', $result, 1000);
        oci_execute($exec);

        return ['kode' => 1, 'message' => "Success"];
    }

    public function print_btb($temp, $type, $v_print, $size)
    {

        if ($type == 1) {
            if ($size == 2) {
                return 'IGR_BO_LISTBTB_FULL';
            } else {
                return 'IGR_BO_LISTBTB';
            }
        } else {
            if ($size == 2) {
                return "IGR_BO_CTBTBNOTA_FULL";
            } else {
                return "IGR_BO_CTBTBNOTA";
            }
        }
    }

    public function print_lokasi($temp_lokasi, $type, $v_print)
    {

        $datas = "1";

        $pdf = PDF::loadview('BACKOFFICE.TRANSAKSI.PENERIMAAN.igr_bo_ctklokasi', ['datas' => $datas]);
        $pdf->output();
        $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);

        $canvas = $dompdf->get_canvas();
        $canvas->page_text(514, 10, "Page {PAGE_NUM} of {PAGE_COUNT}", null, 10, array(0, 0, 0));

        return $pdf->stream('igr_bo_ctklokasi.pdf');
    }

    public function viewReport(Request $request)
    {
        $report = $request->report;
        $noDoc  = $request->noDoc;
        $reprint = $request->reprint;
        $splitDoc = explode(',', $noDoc);
        $kodeigr = Session::get('kdigr');
        $document = '';
        $re_print = ($reprint == 1) ? '(REPRINT)' : ' ';

        foreach ($splitDoc as $data) {
            $document = $document . "'" . $data . "',";
        }

        $document = substr($document, 0, -1);

        if ($report == 'IGR_BO_LISTBTB_FULL') {
            $datas = DB::connection(Session::get('connection'))->select("select trbo_nodoc, TO_CHAR(trbo_tgldoc,'DD/MM/YY') trbo_tgldoc, trbo_nopo, TO_CHAR(trbo_tglpo,'DD/MM/YY') trbo_tglpo, trbo_nofaktur, TO_CHAR(trbo_tglfaktur,'DD/MM/YY') trbo_tglfaktur,
                                        floor(trbo_qty/prd_frac) qty, mod(trbo_qty,prd_frac) qtyk, trbo_qtybonus1, trbo_qtybonus2, trbo_typetrn, trbo_qty, nvl(trbo_flagdoc,'0') flagdoc,
                                        trbo_hrgsatuan, trbo_persendisc1, trbo_persendisc2 , trbo_persendisc2ii , trbo_persendisc2iii , trbo_persendisc3, trbo_persendisc4, trbo_gross, trbo_ppnrph,trbo_ppnbmrph,trbo_ppnbtlrph,
                                        trbo_discrph, trbo_prdcd, trbo_rphdisc1, trbo_rphdisc2, trbo_rphdisc2ii, trbo_rphdisc2iii,  trbo_rphdisc3, trbo_rphdisc4,
                                        prd_deskripsipanjang, prd_unit||'/'||prd_frac kemasan, prd_unit, prd_frac,
                                        sup_kodesupplier||'-'||sup_namasupplier|| case when sup_singkatansupplier is not null then '/'||sup_singkatansupplier end supplier, sup_top,
                                        prs_namaperusahaan, prs_namacabang, case when trbo_persendisc1 <> 0 then (trbo_persendisc1 * trbo_gross) / 100 else trbo_rphdisc1 end as ptg1, case when trbo_persendisc2 <> 0 then (trbo_persendisc2 * trbo_gross) / 100 else trbo_rphdisc2 end as ptg2,
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

            $pdf = PDF::loadview('BACKOFFICE.TRANSAKSI.PENERIMAAN.igr_bo_listbtb_full', ['datas' => $datas]);
            $pdf->output();
            $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);

            $canvas = $dompdf->get_canvas();
            $canvas->page_text(514, 10, "Page {PAGE_NUM} of {PAGE_COUNT}", null, 10, array(0, 0, 0));

            return $pdf->stream('igr_bo_listbtb_full.pdf');
        } elseif ($report == 'IGR_BO_LISTBTB') {
            $datas = DB::connection(Session::get('connection'))->select("select trbo_nodoc, TO_CHAR(trbo_tgldoc,'DD/MM/YY') trbo_tgldoc, trbo_nopo, TO_CHAR(trbo_tglpo,'DD/MM/YY') trbo_tglpo, trbo_nofaktur, TO_CHAR(trbo_tglfaktur,'DD/MM/YY') trbo_tglfaktur,
                                        floor(trbo_qty/prd_frac) qty, mod(trbo_qty,prd_frac) qtyk, trbo_qtybonus1, trbo_qtybonus2, trbo_typetrn, trbo_qty, nvl(trbo_flagdoc,'0') flagdoc,
                                        trbo_hrgsatuan, trbo_persendisc1, trbo_persendisc2 , trbo_persendisc2ii , trbo_persendisc2iii , trbo_persendisc3, trbo_persendisc4, trbo_gross, trbo_ppnrph,trbo_ppnbmrph,trbo_ppnbtlrph,
                                        trbo_discrph, trbo_prdcd, trbo_rphdisc1, trbo_rphdisc2, trbo_rphdisc2ii, trbo_rphdisc2iii,  trbo_rphdisc3, trbo_rphdisc4,
                                        prd_deskripsipanjang, prd_unit||'/'||prd_frac kemasan, prd_unit, prd_frac,
                                        sup_kodesupplier||'-'||sup_namasupplier|| case when sup_singkatansupplier is not null then '/'||sup_singkatansupplier end supplier, sup_top,
                                        prs_namaperusahaan, prs_namacabang, case when trbo_persendisc1 <> 0 then (trbo_persendisc1 * trbo_gross) / 100 else trbo_rphdisc1 end as ptg1, case when trbo_persendisc2 <> 0 then (trbo_persendisc2 * trbo_gross) / 100 else trbo_rphdisc2 end as ptg2,
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

            if ($datas) {
                foreach ($datas as $data) {
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

            $canvas = $dompdf->get_canvas();
            $canvas->page_text(514, 10, "Page {PAGE_NUM} of {PAGE_COUNT}", null, 10, array(0, 0, 0));

            return $pdf->stream('igr_bo_listbtb.pdf');
        } elseif ($report == 'IGR_BO_CTBTBNOTA') {
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
        } elseif ($report == 'IGR_BO_CTBTBNOTA_FULL') {
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
        } elseif ($report == 'lokasi') {
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

            $canvas = $dompdf->get_canvas();
            $canvas->page_text(514, 10, "Page {PAGE_NUM} of {PAGE_COUNT}", null, 10, array(0, 0, 0));

            return $pdf->stream('igr_bo_ctklokasi.pdf');
        }

        dd($report);
    }
}
