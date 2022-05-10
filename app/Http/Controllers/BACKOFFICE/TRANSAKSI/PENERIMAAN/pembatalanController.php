<?php

namespace App\Http\Controllers\BACKOFFICE\TRANSAKSI\PENERIMAAN;

use App\AllModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use PHPUnit\Exception;
use Yajra\DataTables\DataTables;

class pembatalanController extends Controller
{
    public function index()
    {
        return view('BACKOFFICE.TRANSAKSI.PENERIMAAN.pembatalan');
    }

    public function viewBTB(Request $request)
    {
        $kodeigr = Session::get('kdigr');
        $typeTrn    = $request->typeTrn;

        $data = DB::connection(Session::get('connection'))->select("SELECT msth_nodoc, trunc(msth_tgldoc) as msth_tgldoc
                                    FROM tbtr_mstran_h
                                   WHERE     msth_kodeigr = '$kodeigr'
                                         AND msth_typetrn = '$typeTrn'
                                         AND nvl(msth_recordid,' ')<>'1'
                                         and trunc(msth_tgldoc) between trunc(sysdate-5) and trunc(sysdate)
                                ORDER BY msth_tgldoc DESC");

        return DataTables::of($data)->make(true);
    }

    public function viewData(Request $request)
    {
        $noDoc = $request->noDoc;
        $kodeigr = Session::get('kdigr');
        $typeTrn    = $request->typeTrn;

        $data = DB::connection(Session::get('connection'))->select("select mstd_nodoc, mstd_tgldoc, mstd_prdcd, mstd_nofaktur, mstd_tglfaktur,
			              mstd_cterm, mstd_discrph, mstd_dis4cr, mstd_ppnbmrph, mstd_ppnbtlrph, mstd_ppnrph,
			              prd_deskripsipanjang barang, mstd_unit||'/'||mstd_frac satuan, prd_frac,
										(nvl(mstd_qty,0) + nvl(mstd_qtybonus1,0)) qty,  mstd_hrgsatuan, mstd_gross, mstd_nopo, mstd_tglpo,
										sup_kodesupplier||' - '||sup_namasupplier || '/' || sup_singkatansupplier supplier, sup_pkp, sup_top,
										(((mstd_gross - nvl(mstd_discrph,0) +  nvl(mstd_ppnrph,0) + nvl(mstd_ppnbmrph,0) + nvl(mstd_ppnbtlrph,0)) * prd_frac)  / (nvl(mstd_qty,0) + nvl(mstd_qtybonus1,0)) ) as hpp,
										(mstd_gross - nvl(mstd_discrph,0) +  nvl(mstd_ppnrph,0) + nvl(mstd_ppnbmrph,0) + nvl(mstd_ppnbtlrph,0)) as ppntot
									from tbtr_mstran_d, tbmaster_prodmast, tbmaster_supplier
									where mstd_nodoc='$noDoc'
											and mstd_kodeigr= '$kodeigr'
											and mstd_typetrn = '$typeTrn'
											and prd_prdcd=mstd_prdcd
											and prd_kodeigr=mstd_kodeigr
											and sup_kodesupplier(+) = mstd_kodesupplier
											and sup_kodeigr(+)=mstd_kodeigr");

        return response()->json($data);
    }

    public function batalBPB(Request $request)
    {
        $noDoc = $request->noDoc;
        $kodeigr = Session::get('kdigr');
        $userId = Session::get('usid');
        $typeTrn    = $request->typeTrn;
        $supplier   = $request->supplier;

        $help       = new AllModel();
        $date       = $help->getDate();
        $dateTime   = $help->getDateTime();

        $temp       = 0;
        $ndisc1     = 0;
        $ndisc4     = 0;
        $nnilai     = 0;
        $nnilai2    = 0;
        $nqty       = 0;


        $berjalan = DB::connection(Session::get('connection'))->select("SELECT PRS_TAHUNBERJALAN || PRS_BULANBERJALAN as berjalan FROM TBMASTER_PERUSAHAAN WHERE PRS_KODEIGR = '$kodeigr'");

        if (!$noDoc) {
            return response()->json(['kode' => 0, 'msg' => "Nomor BPB Tidak Boleh Kosong !!", 'data' => '']);
        } else {
            $detailBPB = DB::connection(Session::get('connection'))->select("SELECT msth_nodoc, trunc(msth_tgldoc) as msth_tgldoc
                                            FROM tbtr_mstran_h
                                           WHERE     msth_kodeigr = '$kodeigr'
                                                 AND msth_typetrn = '$typeTrn'
                                                 AND nvl(msth_recordid,' ')<>'1'
                                                 and msth_nodoc = '$noDoc'
                                        ORDER BY msth_tgldoc DESC");

            $tempDate = date('Ym', strtotime($detailBPB[0]->msth_tgldoc));

            if ($berjalan[0]->berjalan != $tempDate) {
                return response()->json(['kode' => 0, 'msg' => "Transaksi Tidak Bisa Dibatalkan karena sudah closing/monthend", 'data' => '']);
            } else {
                //                Start from line 43

                $temp   = DB::connection(Session::get('connection'))->select("SELECT NVL (COUNT (1), 0) as temp FROM TBTR_HUTANG WHERE HTG_NODOKUMEN = '$noDoc' AND HTG_TYPE = 'J' AND NVL (HTG_RECORDID, 9) = 2");

                if ($temp[0]->temp > 0) {
                    return response()->json(['kode' => 0, 'msg' => "BPB sudah ditutup", 'data' => '']);
                }

                $temp = 0;

                $loop1 = DB::connection(Session::get('connection'))->select("SELECT MSTD_NODOC, MSTD_TGLDOC, MSTD_PRDCD, MSTD_NOPO, MSTD_FRAC FRAC,
                                                   MSTD_UNIT UNIT, MSTD_TYPETRN, MSTD_DISCRPH, MSTD_PPNBMRPH,
                                                   MSTD_PPNBTLRPH, MSTD_QTYBONUS1, MSTD_GROSS, MSTD_QTY,
                                                   FLOOR (MSTD_QTY / MSTD_FRAC) QTY, MOD (MSTD_QTY, MSTD_FRAC) QTYK,
                                                   MSTD_PERSENDISC1, MSTD_FLAGDISC1, MSTD_RPHDISC1,
                                                   MSTD_PERSENDISC4, MSTD_FLAGDISC4, MSTD_RPHDISC4,PRD_FRAC,
                                                   PRD_LASTCOST, PRD_AVGCOST, PRD_UNIT, ST_SALDOAKHIR, ST_AVGCOST,
                                                   mstd_dis4cr, mstd_dis4rr, mstd_dis4jr
                                              FROM TBTR_MSTRAN_D, TBMASTER_PRODMAST, TBMASTER_STOCK
                                             WHERE MSTD_NODOC = '$noDoc'
                                               AND MSTD_KODEIGR = '$kodeigr'
                                               AND MSTD_TYPETRN = '$typeTrn'
                                               AND PRD_PRDCD = MSTD_PRDCD
                                               AND PRD_KODEIGR = MSTD_KODEIGR
                                               AND SUBSTR (ST_PRDCD, 1, 6) = SUBSTR (MSTD_PRDCD, 1, 6)
                                               AND NVL (PRD_RECORDID, '9') <> '1'
                                               AND ST_KODEIGR = MSTD_KODEIGR
                                               AND ST_LOKASI = '01'
                                               AND NVL (ST_RECORDID, '9') <> '1'");

                foreach ($loop1 as $data) {
                    //                    if ($data->mstd_typetrn == 'B') {
                    $temp = DB::connection(Session::get('connection'))->select("SELECT NVL (COUNT (1), 0) as temp
                                                  FROM TBMASTER_STOCK
                                                 WHERE ST_PRDCD = '$data->mstd_prdcd'
                                                   AND ST_KODEIGR = '$kodeigr'
                                                   AND ST_LOKASI = '01'");

                    if ($temp[0]->temp == 0) {
                        DB::connection(Session::get('connection'))->table('tbmaster_stock')->insert(['st_prdcd' => substr($data->mstd_prdcd, 0, 6) . '0', 'st_lokasi' => '01']);
                    }

                    $temp = DB::connection(Session::get('connection'))->select("SELECT NVL (COUNT (1), 0) as temp
                                                  FROM TBTR_PO_D
                                                 WHERE TPOD_NOPO = '$data->mstd_nopo'
                                                   AND TPOD_PRDCD = '$data->mstd_prdcd'
                                                   AND TPOD_KODEIGR = '$kodeigr'");

                    if ($temp[0]->temp > 0) {
                        DB::connection(Session::get('connection'))->table('TBTR_PO_D')
                            ->where('tpod_nopo', $data->mstd_nopo)
                            ->where('tpod_prdcd', $data->mstd_prdcd)
                            ->where('tpod_kodeigr', $kodeigr)
                            ->update(['tpod_recordid' => null, 'tpod_qtypb' => 0, 'tpod_bonusbpb1' => 0, 'tpod_bonusbpb2' => 0]);

                        DB::connection(Session::get('connection'))->table('TBTR_PO_H')
                            ->where('tpoh_nopo', $data->mstd_nopo)
                            ->where('tpoh_kodeigr', $kodeigr)
                            ->update(['tpoh_recordid' => null]);
                    }

                    //                        ----------- Hitung Discount 1------

                    if ($data->mstd_persendisc1 != 0) {
                        $ndisc1 = ($data->mstd_persendisc1 * $data->mstd_gross) / 100;
                    } else {
                        if ($data->mstd_flagdisc1 == 'B') {
                            $ndisc1 = ($data->qty * $data->mstd_rphdisc1);
                        } else {
                            if ($data->unit != 'KG') {
                                $ndisc1 = (($data->qty * $data->frac + $data->qtyk) * $data->mstd_rphdisc1);
                            } else {
                                $ndisc1 = $data->qty * $data->mstd_rphdisc1 + $data->qtyk * $data->mstd_rphdisc1 / $data->frac;
                            }
                        }
                    }

                    if ($data->mstd_persendisc4 != 0) {
                        $ndisc4 = ($data->mstd_persendisc4 * ($data->mstd_gross - $ndisc1)) / 100;
                    } else {
                        if ($data->mstd_flagdisc4 == 'B') {
                            $ndisc4 = ($data->qty * $data->mstd_rphdisc4);
                        } else {
                            if ($data->unit != 'KG') {
                                $ndisc4 = (($data->qty * $data->frac + $data->qtyk) * $data->mstd_rphdisc4);
                            } else {
                                $ndisc4 = $data->qty * $data->mstd_rphdisc4 + $data->qtyk * $data->mstd_rphdisc4 / $data->frac;
                            }
                        }
                    }

                    $ndisc4     = $data->mstd_dis4cr + $data->mstd_dis4rr + $data->mstd_dis4jr;
                    $nnilai     = ($data->st_saldoakhir / (($data->prd_unit == 'KG') ? 1000 : 1)) - ($data->mstd_gross - $data->mstd_discrph + $ndisc4 + $data->mstd_ppnbmrph + $data->mstd_ppnbtlrph);
                    $nnilai2    = ($data->st_saldoakhir / (($data->prd_unit == 'KG') ? 1000 : 1) * ($data->prd_avgcost / (($data->prd_unit == 'KG') ? 1 : $data->prd_frac))) - ($data->mstd_gross - $data->mstd_discrph + $ndisc4 + $data->mstd_ppnbmrph + $data->mstd_ppnbtlrph);
                    $nqty       = ($data->st_saldoakhir - ($data->qty * $data->frac + $data->qtyk + $data->mstd_qtybonus1)) / (($data->prd_unit == 'KG') ? 1000 : 1);
                    //
                    if (!$nqty) {
                        $nqty = 1;
                    }

                    $temp = DB::connection(Session::get('connection'))->select("SELECT NVL (COUNT (1), 0) as temp
                                                  FROM TBTR_HAPUSPLU
                                                 WHERE DEL_NODOKUMEN = '$noDoc'
                                                   AND DEL_PRDCD = $data->mstd_prdcd
                                                   AND DEL_RTYPE = '$typeTrn'");

                    if ($temp[0]->temp == 0) {
                        DB::connection(Session::get('connection'))->table('tbtr_hapusplu')->insert([
                            'DEL_KODEIGR' => $kodeigr, 'DEL_RTYPE' => $typeTrn,
                            'DEL_NODOKUMEN' => $data->mstd_nodoc, 'DEL_TGLDOKUMEN' => $data->mstd_tgldoc, 'DEL_PRDCD' => $data->mstd_prdcd, 'DEL_AVGCOSTNEW' => ($nnilai / $nqty),
                            'DEL_AVGCOSTOLD' => $data->st_avgcost, 'DEL_STOKQTYOLD' => $data->st_saldoakhir,
                            'DEL_CREATE_DT' => $date, 'DEL_CREATE_BY' => $userId
                        ]);
                    } // Line 253

                    DB::connection(Session::get('connection'))->statement("UPDATE TBMASTER_STOCK
                                               SET ST_AVGCOST = '$nnilai' / '$nqty',
                                                   ST_SALDOAKHIR = ST_SALDOAKHIR - ('$data->qty' * '$data->frac' + '$data->qtyk' + '$data->mstd_qtybonus1'),
                                                   ST_TRFIN = ST_TRFIN - ('$data->qty' * '$data->frac' + '$data->qtyk' + '$data->mstd_qtybonus1'),
                                                   ST_MODIFY_BY = '$userId', ST_MODIFY_DT = '$dateTime'
                                             WHERE SUBSTR (ST_PRDCD, 1, 6) = SUBSTR ('$data->mstd_prdcd', 1, 6)
                                               AND ST_KODEIGR = '$kodeigr'
                                               AND ST_LOKASI = '01'");

                    //                        ----------------------------- Line 268 -- 24/02/2021

                    DB::connection(Session::get('connection'))->table('tbtr_mstran_d')
                        ->where('mstd_kodeigr', $kodeigr)->where('mstd_prdcd', $data->mstd_prdcd)->where('mstd_nodoc', $data->mstd_nodoc)->where('mstd_typetrn', $typeTrn)
                        ->update(['mstd_recordid' => 1, 'mstd_modify_dt' => $dateTime, 'mstd_modify_by' => $userId]);


                    DB::connection(Session::get('connection'))->table('tbtr_mstran_h')
                        ->where('msth_kodeigr', $kodeigr)->where('msth_nodoc', $data->mstd_nodoc)->where('msth_typetrn', $typeTrn)
                        ->update(['msth_recordid' => 1, 'msth_modify_dt' => $dateTime, 'msth_modify_by' => $userId]);


                    DB::connection(Session::get('connection'))->table('tbtr_backoffice')
                        ->where('trbo_kodeigr', $kodeigr)->where('trbo_nonota', $data->mstd_nodoc)
                        ->update(['trbo_recordid' => 1]);

                    $nfmlclm = 0;

                    $fmlclmTemp = DB::connection(Session::get('connection'))->table('TBHISTORY_COST')->selectRaw("NVL (HCS_LASTCOSTLAMA, 0) as lastcostlama")
                        ->where('hcs_prdcd', $data->mstd_prdcd)->where('hcs_nodocbpb', $data->mstd_nodoc)->where('hcs_tglbpb', $data->mstd_tgldoc)->get()->toArray();

                    $fmlclm = (!$fmlclmTemp) ? 0 : $fmlclmTemp[0]->lastcostlama;

                    if ($fmlclm != 0) {
                        $nfmlclm = $fmlclm / (($data->prd_unit == 'KG') ? 1 : $data->prd_frac);
                    }

                    DB::connection(Session::get('connection'))->statement("UPDATE TBMASTER_STOCK
                                               SET ST_LASTCOST = '$nfmlclm'
                                             WHERE SUBSTR (ST_PRDCD, 1, 6) = SUBSTR ('$data->mstd_prdcd', 1, 6)
                                               AND ST_KODEIGR = '$kodeigr'");

                    $loop2 = DB::connection(Session::get('connection'))->select("SELECT PRD_PRDCD, PRD_UNIT, PRD_FRAC
                                                FROM TBMASTER_PRODMAST
                                             WHERE SUBSTR (PRD_PRDCD, 1, 6) = SUBSTR ('$data->mstd_prdcd', 1, 6)
                                               AND PRD_KODEIGR = '$kodeigr'");

                    foreach ($loop2 as $data2) {
                        if ($data2->prd_unit == 'KG') {
                            DB::connection(Session::get('connection'))->table('tbmaster_prodmast')
                                ->where('prd_prdcd', $data2->prd_prdcd)->where('prd_kodeigr', $kodeigr)
                                ->update(['prd_avgcost' => ($nnilai2 / $nqty), 'prd_lastcost' => $nfmlclm, 'prd_modify_by' => $userId, 'prd_modify_dt' => $dateTime]);
                        } else {
                            DB::connection(Session::get('connection'))->table('tbmaster_prodmast')
                                ->where('prd_prdcd', $data2->prd_prdcd)->where('prd_kodeigr', $kodeigr)
                                ->update(['prd_avgcost' => (($nnilai2 / $nqty) * $data2->prd_frac), 'prd_lastcost' => ($nfmlclm  * $data2->prd_frac), 'prd_modify_by' => $userId, 'prd_modify_dt' => $dateTime]);
                        }
                    }

                    DB::connection(Session::get('connection'))->table('tbhistory_cost')
                        ->insert([
                            'HCS_KODEIGR' => $kodeigr, 'HCS_LOKASI' => $kodeigr, 'HCS_TYPETRN' => $data->mstd_typetrn,
                            'HCS_PRDCD' => $data->mstd_prdcd, 'HCS_TGLBPB' => $data->mstd_tgldoc, 'HCS_NODOCBPB' => $data->mstd_nodoc,
                            'HCS_QTYBARU' => (((!$data->mstd_qty) ? 0 : $data->mstd_qty) + ((!$data->mstd_qtybonus1) ? 0 : $data->mstd_qtybonus1)),
                            'HCS_QTYLAMA' => (!$data->st_saldoakhir) ? 0 : $data->st_saldoakhir, 'HCS_AVGLAMA' => $data->prd_avgcost,
                            'HCS_AVGBARU' => (($nnilai2 / $nqty) * ($data->prd_unit == 'KG') ? 1 : $data->prd_frac),
                            'HCS_LASTCOSTLAMA' => $data->prd_lastcost,
                            'HCS_LASTCOSTBARU' => ($nfmlclm * ($data->prd_unit == 'KG') ? 1 : $data->prd_frac),
                            'HCS_LASTQTY' => (!$data->st_saldoakhir ? 0 : ($data->st_saldoakhir - (!$data->mstd_qty) ? 0 : $data->mstd_qty + (!$data->mstd_qtybonus1))) ? 0 : $data->mstd_qtybonus1,
                            'HCS_CREATE_BY' => $userId, 'HCS_CREATE_DT' => $dateTime
                        ]);
                    //                    } elseif ($data->mstd_typetrn == 'L') {
                    //
                    //
                    //                    }

                    if ($supplier) {
                        DB::connection(Session::get('connection'))->table('tbtr_hutang')
                            ->where('htg_nodokumen', $data->mstd_nodoc)->where('htg_type', 'J')
                            ->update(['htg_recordid' => 1, 'htg_modifydt' => $dateTime, 'htg_modifyby' => $userId]);
                    }
                }

                return response()->json(['kode' => 1, 'msg' => "Proses Pembatalan Berhasil !!", 'data' => '']);
            }
        }
    }
}
