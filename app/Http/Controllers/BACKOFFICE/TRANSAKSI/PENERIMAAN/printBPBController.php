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
                    $updateData = $this->update_data($document[0], $kodeigr, $userid, $conn, $type, $trnType);

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

    public function update_data($noDoc, $kodeigr, $userId, $conn, $type, $trnType)
    {
        $P_SUKSES = 0;
        $P_ERROR = 0;
        $dummyvar = '';
        $sysdate = date("d/m/Y");
        $btb_no = '';
        if ($trnType == 'B') {
            $query = oci_parse($conn, "BEGIN :no_btb := F_IGR_GET_NOMOR (:IGR, 'BPB', 'Nomor BPB', '$sysdate' || '0', 5, TRUE); END;");
            oci_bind_by_name($query, ':IGR', $kodeigr);
            oci_bind_by_name($query, ':no_btb', $result, 32);
            oci_execute($query);
            $btb_no = $result;
        } else {
            $query = oci_parse($conn, "BEGIN :no_btb := F_IGR_GET_NOMOR (:IGR, 'BPL', 'Nomor BPB Lain-Lain', '$sysdate' || '0', 5, TRUE); END;");
            oci_bind_by_name($query, ':IGR', $kodeigr);
            oci_bind_by_name($query, ':no_btb', $result, 32);
            oci_execute($query);
            $btb_no = $result;
        }
        $record = DB::connection(Session::get('connection'))->select("SELECT 
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
                    AND (NVL (TRBO_QTY, 0)
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
        // dd($checkDummyVar);
        foreach ($record as $data) {
            $updplu = false;
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
                //skipped if NACOST && NACOSTX <=0 bcs value is the same
            } else { //kilo-an
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
                    $query = oci_parse($conn, "BEGIN :test := SP_PKM_BPB (:IGR, :PRDCD, :USID, :PS, :PE); END;");
                    oci_bind_by_name($query, ':IGR', $kodeigr);
                    oci_bind_by_name($query, ':PRDCD', $sub_prdcd);
                    oci_bind_by_name($query, ':USID', $userId);
                    oci_bind_by_name($query, ':PS', $P_SUKSES);
                    oci_bind_by_name($query, ':PE', $P_ERROR);
                    oci_bind_by_name($query, ':test', $test);
                    oci_execute($query);
                    //P_SUKSES + P_ERROR buat apa?
                    dd($test);
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
            if ($trnType == 'B') {
                if ($data->trbo_furgnt == '3') {
                    $record2 = DB::connection(Session::get('connection'))->select("SELECT *
                    FROM TBTR_PO_D,
                         TBTR_PB_D,
                    WHERE   TPOD_NOPO   = '$data->trbo_nopo'
                    AND     TPOD_PRDCD  = '$data->trbo_prdcd'
                    AND     PBD_NOPO    = '$data->tpod_nopo'
                    AND     PBD_PRDCD   = '$data->tpod_prdcd'");

                    foreach ($record2 as $data2) {
                        $pbcabg = DB::connection(Session::get('connection'))->select("SELECT *
                        FROM TBTR_PBCABANG_GUDANGPUSAT
                        WHERE   PBC_NOPBGUDANGPUSAT   = '$data2->pbd_nopb'
                        AND     PBC_PRDCD  = '$data2->pbd_prdcd'");
                        foreach ($pbcabg as $datapbc) {
                            if ($datapbc->pbc_recordid == '1' || $datapbc->pbc_recordid == '3') {
                                if ($datapbc->pbc_recordid == '3') {
                                    if ($datapbc->pbc_qtypb - $datapbc->pbc_qtybbp == 0) {
                                        return false;
                                    }
                                }
                                if ($datapbc->pbc_kodecabang == '03') {
                                    $CKODE = '1';
                                } else if ($datapbc->pbc_kodecabang == '06') {
                                    $CKODE = '2';
                                } else if ($datapbc->pbc_kodecabang == '04') {
                                    $CKODE = '3';
                                } else if ($datapbc->pbc_kodecabang == '01') {
                                    $CKODE = '4';
                                } else if ($datapbc->pbc_kodecabang == '02') {
                                    $CKODE = '5';
                                } else {
                                    $CKODE = '6';
                                }

                                $temp = 0;
                                $recordtemp = DB::connection(Session::get('connection'))->select("SELECT COUNT(*)
                                INTO $temp
                                FROM TBTR_LISTPACKING
                                WHERE   PCL_RECORDID    IS NULL
                                AND     PCL_KODECABANG  = '$datapbc->pbc_kodecabang'
                                AND     PCL_NOREFERENSI = '$datapbc->pbc_nopbcabang'
                                AND     PCL_PRDCD       = '$data->trbo_prdcd'");

                                if ($temp == 0) {
                                    DB::connection(Session::get('connection'))->table('TBTR_LISTPACKING')->insert([
                                        "PCL_KODEIGR" => $kodeigr,
                                        "PCL_RECORDID" => null,
                                        "PCL_KODECABANG" => $datapbc->pbc_kodecabang,
                                        "PCL_NOREFERENSI" => $datapbc->pbc_nopbcabang,
                                        "PCL_NOREFERENSI1" => $data->trbo_nodoc,
                                        "PCL_PRDCD" => $data->trbo_prdcd
                                    ]);
                                }

                                if ($datapbc->pbc_recordid == '3') {
                                    $QTY_O = round((($datapbc->pbc_qtypb - $datapbc->pbc_qtybbp) / $data->prd_frac), 0);

                                    $QTY_OK = ($datapbc->pbc_qtypb - $datapbc->pbc_qtybbp) - (round(($datapbc->pbc_qtypb - $datapbc->pbc_qtybbp) / $data->prd_frac, 0)) * $data->prd_frac;
                                } else {
                                    $QTY_O = round($datapbc->pbc_qtypb / $data->prd_frac, 0);

                                    $QTY_OK = $datapbc->pbc_qtypb - round(($datapbc->pbc_qtypb / $data->prd_frac) * $data->prd_frac, 0);
                                }
                                DB::connection(Session::get('connection'))->table('TBTR_LISTPACKING')
                                    ->where('PCL_RECORDID', null)
                                    ->where('PCL_KODECABANG', $datapbc->pbc_kodecabang)
                                    ->where('PCL_NOREFERENSI', $datapbc->pbc_nopbcabang)
                                    ->where('PCL_PRDCD', $data->trbo_prdcd)
                                    ->update([
                                        'PCL_KODE' => $CKODE, 'PCL_TGLREFERENSI' => $datapbc->pbc_tglpbcabang,
                                        'PCL_NODOKUMEN' => $btb_no || $datapbc->pbc_kodecabang, 'PCL_TGLDOKUMEN' => date('d/m/Y'),
                                        'PCL_QTY_O' => $QTY_O, 'PCL_QTY_OK' => $QTY_OK,
                                        'PCL_QTYBONUS1' => $data->trbo_qtybonus1, 'PCL_QTYBONUS2' => $data->trbo_qtybonus2,
                                        'PCL_HRG' => $data->trbo_hrgsatuan, 'PCL_DISCPERSEN1' => $data->trbo_persendisc1,
                                        'PCL_DISCPERSEN2' => $data->trbo_persendisc2, 'PCL_DISCPERSEN3' => $data->trbo_persendisc3,
                                        'PCL_DISCPERSEN4' => $data->trbo_persendisc4, 'PCL_DISCRPH1' => $data->trbo_rphdisc1,
                                        'PCL_DISCRPH2' => $data->trbo_rphdisc2, 'PCL_DISCRPH3' => $data->trbo_rphdisc3,
                                        'PCL_DISCRPH4' => $data->trbo_rphdisc4, 'PCL_FLAGDISC1' => $data->trbo_flagdisc1,
                                        'PCL_FLAGDISC2' => $data->trbo_flagdisc2, 'PCL_FLAGDISC3' => $data->trbo_flagdisc3,
                                        'PCL_FLAGDISC4' => $data->trbo_flagdisc4, 'PCL_DIS4CP' => $data->trbo_dis4cp,
                                        'PCL_DIS4CR' => $data->trbo_dis4cr, 'PCL_DIS4RP' => $data->trbo_dis4rp,
                                        'PCL_DIS4RR' => $data->trbo_dis4rr, 'PCL_DIS4JP' => $data->trbo_dis4jp,
                                        'PCL_DIS4JR' => $data->trbo_dis4jr, 'PCL_NILAI' => $data->trbo_gross,
                                        'PCL_DISCRPH' => $data->rebo_discrph, 'PCL_PPNRPH' => $data->trbo_ppnrph,
                                        'PCL_PPNBMRPH' => $data->trbo_ppnbmrph, 'PCL_PPNBTLRPH' => $data->trbo_ppnbtlrph,
                                        'PCL_AVGCOST' => ($NACOSTX * $data->trbo_frac) / $sum, 'PCL_KETERANGAN' => 'PACKLIST OTOMATIS BPB GMS',
                                        'PCL_CREATE_DT' => date('d/m/Y'), 'PCL_CREATE_BY' => $userId,
                                        'PCL_FURGNT' => $data->trbo_furgnt
                                    ]);
                            }
                        }
                        $TRUET = true;
                        $pbcabg2 = DB::connection(Session::get('connection'))->select("SELECT *
                                FROM TBTR_PBCABANG_GUDANGPUSAT
                                WHERE   PBC_NOPBGUDANGPUSAT    = $data2->pbd_nopb
                                AND     PBC_PRDCD  = '$data2->pbd_prdcd'
                                AND     PBC_KODECABANG = '$kodeigr'");
                        foreach ($pbcabg2 as $datapbc2) {
                            if ($datapbc2->pbc_recordid == '3' && ($datapbc2->pbc_qtypb - $datapbc2->pbc_qtybbp == 0)) {
                                $TRUET = false;
                            }
                            if ($TRUET == true) {
                                $temp2 = 0;
                                DB::connection(Session::get('connection'))->select("SELECT COUNT(*)
                                INTO $temp2
                                FROM TBTR_LISTPACKING
                                WHERE   PCL_RECORDID IS NULL
                                AND     PCL_KODECABANG  = '$kodeigr'
                                AND     PCL_NOREFERENSI = '$datapbc2->pbc_nopbcabang'
                                AND     PCL_PRDCD = '$datapbc2->pbc_prdcd'");

                                if ($temp2 == 0) {
                                    $order1 = 0;
                                    $record3 = DB::connection(Session::get('connection'))->select("SELECT *
                                    FROM TBTR_PBCABANG_GUDANGPUSAT
                                    WHERE   PBC_NOPBGUDANGPUSAT = $data2->pbd_nopb
                                    AND     PBC_PRDCD  = '$data2->pbd_prdcd'");

                                    foreach ($record3 as $data3) {
                                        if ($datapbc2->pbc_recordid == '1' || $datapbc2->pbc_recordid == '3') {
                                            $order1 = $order1 + $datapbc2->pbc_qtypb;
                                        }
                                    }

                                    if ($order1 < $data->trbo_qty) {
                                        $CKODE = '6';
                                        $temp3 = 0;
                                        DB::connection(Session::get('connection'))->select("SELECT COUNT(*)
                                        INTO $temp3
                                    FROM TBTR_LISTPACKING
                                    WHERE   PCL_RECORDID IS NULL
                                    AND     PCL_KODECABANG  = '$kodeigr'
                                    AND     PCL_NOREFERENSI  = '$datapbc2->pbc_nopbcabang'
                                    AND     PCL_PRDCD  = '$datapbc2->pbc_prdcd'");
                                        if ($temp3 == 0) {
                                            DB::connection(Session::get('connection'))->table('TBTR_LISTPACKING')->insert([
                                                "PCL_KODEIGR" => $kodeigr,
                                                "PCL_RECORDID" => null,
                                                "PCL_KODECABANG" => $datapbc2->pbc_kodecabang,
                                                "PCL_NOREFERENSI" => $datapbc2->pbc_nopbcabang,
                                                "PCL_NOREFERENSI1" => $data->trbo_nodoc,
                                                "PCL_PRDCD" => $data->trbo_prdcd
                                            ]);

                                            DB::connection(Session::get('connection'))->table('TBTR_LISTPACKING')
                                                ->where('PCL_RECORDID', null)
                                                ->where('PCL_KODECABANG', $kodeigr)
                                                ->where('PCL_NOREFERENSI', $datapbc2->pbc_nopbcabang)
                                                ->where('PCL_PRDCD', $datapbc2->pbc_prdcd)
                                                ->update([
                                                    'PCL_KODE' => $CKODE, 'PCL_TGLREFERENSI' => $datapbc2->pbc_tglpbcabang,
                                                    'PCL_NODOKUMEN' => $btb_no || $datapbc2->pbc_kodecabang, 'PCL_TGLDOKUMEN' => date('d/m/Y'),
                                                    'PCL_QTY_O' => $QTY_O, 'PCL_QTY_OK' => $QTY_OK,
                                                    'PCL_QTYBONUS1' => $data->trbo_qtybonus1, 'PCL_QTYBONUS2' => $data->trbo_qtybonus2,
                                                    'PCL_HRG' => $data->trbo_hrgsatuan, 'PCL_DISCPERSEN1' => $data->trbo_persendisc1,
                                                    'PCL_DISCPERSEN2' => $data->trbo_persendisc2, 'PCL_DISCPERSEN3' => $data->trbo_persendisc3,
                                                    'PCL_DISCPERSEN4' => $data->trbo_persendisc4, 'PCL_DISCRPH1' => $data->trbo_rphdisc1,
                                                    'PCL_DISCRPH2' => $data->trbo_rphdisc2, 'PCL_DISCRPH3' => $data->trbo_rphdisc3,
                                                    'PCL_DISCRPH4' => $data->trbo_rphdisc4, 'PCL_FLAGDISC1' => $data->trbo_flagdisc1,
                                                    'PCL_FLAGDISC2' => $data->trbo_flagdisc2, 'PCL_FLAGDISC3' => $data->trbo_flagdisc3,
                                                    'PCL_FLAGDISC4' => $data->trbo_flagdisc4, 'PCL_DIS4CP' => $data->trbo_dis4cp,
                                                    'PCL_DIS4CR' => $data->trbo_dis4cr, 'PCL_DIS4RP' => $data->trbo_dis4rp,
                                                    'PCL_DIS4RR' => $data->trbo_dis4rr, 'PCL_DIS4JP' => $data->trbo_dis4jp,
                                                    'PCL_DIS4JR' => $data->trbo_dis4jr, 'PCL_NILAI' => $data->trbo_gross,
                                                    'PCL_DISCRPH' => $data->rebo_discrph, 'PCL_PPNRPH' => $data->trbo_ppnrph,
                                                    'PCL_PPNBMRPH' => $data->trbo_ppnbmrph, 'PCL_PPNBTLRPH' => $data->trbo_ppnbtlrph,
                                                    'PCL_AVGCOST' => ($NACOSTX * $data->trbo_frac) / $sum, 'PCL_KETERANGAN' => 'PACKLIST OTOMATIS BPB GMS',
                                                    'PCL_CREATE_DT' => date('d/m/Y'), 'PCL_CREATE_BY' => $userId,
                                                    'PCL_FURGNT' => $data->trbo_furgnt
                                                ]);
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        if ($NACOSTX != 0) {
            DB::connection(Session::get('connection'))->table('TBMASTER_STOCK')
                ->where('ST_PRDCD', $data->trbo_prdcd)
                ->where('ST_LOKASI', '01')
                ->where('ST_KODEIGR', $kodeigr)
                ->update([
                    'ST_AVGCOST' => $NACOSTX,
                    'ST_SALDOAKHIR' => ST_SALDOAKHIR + $data->trbo_qty + $data->trbo_qtybonus1,
                    'ST_TRFIN' => ST_TRFIN + $data->trbo_qty + $data->trbo_qtybonus1,
                    'ST_MODIFY_BY' => $userId,
                    'ST_MODIFY_DT' => date('d/m/Y')
                ]);

            $record2 = DB::connection(Session::get('connection'))->select("SELECT PRD_PRDCD, PRD_UNIT, PRD_FRAC
            FROM TBMASTER_PRODMAST,
            WHERE   SUBSTR (PRD_PRDCD, 1, 6) = SUBSTR ($data->trbo_prdcd, 1, 6)
            AND     PRD_KODEIGR  = '$kodeigr'");

            foreach ($record2 as $data2) {
                if (substr($data2->prd_prdcd, -1) == 1 || $data2->prd_unit == 'KG') {
                    DB::connection(Session::get('connection'))->table('TBMASTER_PRODMAST')
                        ->where('PRD_PRDCD', $data2->prd_prdcd)
                        ->where('PRD_KODEIGR', $kodeigr)
                        ->update([
                            'PRD_AVGCOST' => $NACOSTX,
                        ]);
                } else {
                    DB::connection(Session::get('connection'))->table('TBMASTER_PRODMAST')
                        ->where('PRD_PRDCD', $data2->prd_prdcd)
                        ->where('PRD_KODEIGR', $kodeigr)
                        ->update([
                            'PRD_AVGCOST' => $NACOST * $data2->prd_frac
                        ]);
                }
            }
        }

        $temp4 = 0;
        DB::connection(Session::get('connection'))->select("SELECT COUNT(*), 
            INTO $temp4
            FROM TBHISTORY_COST,
            WHERE   HCS_PRDCD = $data->trbo_prdcd
            AND     HCS_TGLBPB  = date('d/m/Y')
            AND     HCS_NODOCBPB = $btb_no");

        if ($temp4 == 0) {
            DB::connection(Session::get('connection'))->table('TBHISTORY_COST')->insert([
                "HCS_KODEIGR" => $kodeigr,
                "HCS_LOKASI" => $kodeigr,
                "HCS_TYPETRN" => $trnType,
                "HCS_PRDCD" => $data->trbo_prdcd,
                "HCS_TGLBPB" => date('d/m/Y'),
                "HCS_NODOCBPB" => $btb_no,
                "HCS_QTYBARU" => $data->trbo_qty + $data->trbo_qtybonus1,
                "HCS_QTYLAMA" => $data->st_saldoakhir,
                "HCS_AVGLAMA" => $NOLDACOSTX * $frac,
                "HCS_AVGBARU" => $NACOSTX * $frac,
                "HCS_LASTQTY" => $data->st_saldoakhir + $data->trbo_qty + $data->trbo_qtybonus1,
                "HCS_CREATE_BY" => $userId,
                "HCS_CREATE_DT" => date('d/m/Y')
            ]);
        }

        $NLCOST = ($data->trbo_gross - $data->trbo_discrph + $data->trbo_disc4r + $data->trbo_dis4jr + $data->trbo_dis4rr + $data->trbo_ppnbmrph + $data->trbo_ppnbtlrph) / ($data->trbo_qty + $data->trbo_qtybonus1);

        $NLCOST *= $sum;

        $x = 0;
        if ($data->prd_prdcd == '1' || $data->prd_unit == 'KG') {
            $x = 1;
        } else if ($data->trbo_nopo == 'AA1') {
            $x = $data->prd_frac;
        } else {
            $x = $data->tpod_isibeli;
        }
        DB::connection(Session::get('connection'))->table('TBHISTORY_COST')
            ->where('HCS_PRDCD', $data->trbo_prdcd)
            ->where('HCS_TGLBPB', date('d/m/Y'))
            ->where('HCS_NODOCBPB', $btb_no)
            ->update([
                'HCS_LASTCOSTBARU' => $NLCOST * $x,
                'HCS_LASTCOSTLAMA' => $data->prd_lastcost,
            ]);

        if ($NLCOST != 0) {
            DB::connection(Session::get('connection'))->table('TBMASTER_STOCK')
                ->where('ST_PRDCD', $data->trbo_prdcd)
                ->where('ST_KODEIGR', $kodeigr)
                ->update([
                    'ST_LASTCOST' => $NLCOST,
                    'HCS_LASTCOSTLAMA' => $data->prd_lastcost,
                ]);

            $record2 = DB::connection(Session::get('connection'))->select("SELECT PRD_PRDCD, PRD_UNIT, PRD_FRAC
            FROM TBMASTER_PRODMAST,
            WHERE   SUBSTR (PRD_PRDCD, 1, 6) = SUBSTR ($data->trbo_prdcd, 1, 6)
            AND     PRD_KODEIGR  = '$kodeigr'");

            foreach ($record2 as $data2) {
                if (substr($data2->prd_prdcd, -1) == 1 || $data2->prd_unit == 'KG') {
                    DB::connection(Session::get('connection'))->table('TBMASTER_PRODMAST')
                        ->where('PRD_PRDCD', $data2->prd_prdcd)
                        ->where('PRD_KODEIGR', $kodeigr)
                        ->update([
                            'PRD_LASTCOST' => $NLCOST,
                        ]);

                    if ($updplu == true) {
                        DB::connection(Session::get('connection'))->table('TBTR_UPDATE_PLU_MD')->insert([
                            "UPD_KODEIGR" => $kodeigr,
                            "UPD_PRDCD" => $data2->prd_prdcd,
                            "UPD_HARGA" => $NLCOST,
                            "UPD_ATRIBUTE1" => 'BPB',
                            "UPD_CREATE_BY" => $userId,
                            "UPD_CREATE_DT" => date("d/m/Y"),
                        ]);
                    }
                } else {
                    DB::connection(Session::get('connection'))->table('TBMASTER_PRODMAST')
                        ->where('PRD_PRDCD', $data2->prd_prdcd)
                        ->where('PRD_KODEIGR', $kodeigr)
                        ->update([
                            'PRD_LASTCOST' => $NLCOST * $data2->prd_frac
                        ]);
                    if ($updplu == true) {
                        DB::connection(Session::get('connection'))->table('TBTR_UPDATE_PLU_MD')->insert([
                            "UPD_KODEIGR" => $kodeigr,
                            "UPD_PRDCD" => $data2->prd_prdcd,
                            "UPD_HARGA" => $NLCOST * $data2->prd_frac,
                            "UPD_ATRIBUTE1" => 'BPB',
                            "UPD_CREATE_BY" => $userId,
                            "UPD_CREATE_DT" => date("d/m/Y"),
                        ]);
                    }
                }
            }
        }

        $temp5 = 0;
        $SUPCO = $data->sup_kodesupplier;
        $NOPO = $data->trbo_nopo;
        $NOFAKTUR = $data->trbo_nofaktur;
        $PKP = $data->sup_pkp;
        $TGLPO = $data->trbo_tglpo;
        $TGLFAKTUR = $data->trbo_tglfaktu;

        DB::connection(Session::get('connection'))->table('TBTR_BACKOFFICE')
                                    ->where('TRBO_NODOC', $data->trbo_nodoc)
                                    ->where('TRBO_PRDCD', $data->trbo_prdcd)
                                    ->update(['TRBO_NONOTA' => $btb_no, 'TRBO_TGLNOTA' => date('d/m/Y')]);
    END LOOP;

        // $exec = oci_parse($conn, "BEGIN sp_penerimaan_updatedata(:kodeigr, :userid, :tipe, :dummyvar, :result); END;");
        // oci_bind_by_name($exec, ':kodeigr', $kodeigr);
        // oci_bind_by_name($exec, ':userid', $userId);
        // oci_bind_by_name($exec, ':tipe', $type);
        // oci_bind_by_name($exec, ':dummyvar', $dummyvar);
        // oci_bind_by_name($exec, ':result', $result, 1000);
        // oci_execute($exec);

        // return ['kode' => 1, 'message' => "Success"];
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
