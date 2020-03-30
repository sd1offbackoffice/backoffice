<?php

namespace App\Http\Controllers\BACKOFFICE;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class PBManualController extends Controller
{
    public function index()
    {
        $produk = DB::table('tbmaster_prodmast')
            ->select('prd_prdcd', 'prd_deskripsipanjang')
            ->where(DB::RAW('SUBSTR(prd_prdcd,7,1)'), '=', '0')
            ->orderBy('prd_deskripsipanjang')
            ->get();
        $pb = DB::table('tbTr_PB_H')
            ->select('*')
            ->where('PBH_KodeIGR', '=', $_SESSION['kdigr'])
            ->limit(20)
            ->orderBy('pbh_nopb', 'desc')
            ->get()->toArray();
        return view('BACKOFFICE.PBManual')->with(compact(['pb', 'produk']));
    }

    public function lov_search(Request $request)
    {
        $pb = DB::table('tbTr_PB_H')
            ->select('*')
            ->where('PBH_KodeIGR', '=', $_SESSION['kdigr'])
            ->where('PBH_NOPB', 'like', '%' . $request->value . '%')
            ->orderBy('pbh_nopb', 'desc')
            ->get();
        return $pb;
    }

    public function lov_search_plu(Request $request)
    {
        if (is_numeric($request->value)) {
            $result = DB::table('tbmaster_prodmast')
                ->select('prd_prdcd', 'prd_deskripsipanjang')
                ->where('prd_prdcd', 'like', '%' . $request->value . '%')
                ->orderBy('prd_deskripsipanjang')
                ->get();
        } else {
            $result = DB::table('tbmaster_prodmast')
                ->select('prd_prdcd', 'prd_deskripsipanjang')
                ->where('prd_deskripsipanjang', 'like', '%' . $request->value . '%')
                ->orderBy('prd_deskripsipanjang')
                ->get();
        }
        return $result;
    }

    public function hapusDokumen(Request $request)
    {
        $pb = DB::table('tbTr_PB_H')
            ->select('*')
            ->where('PBH_NOPB', '=', $request->value)
            ->first();
        if (is_null($pb)) {
            $message = 'Nomor Dokumen Tidak Ditemukan!';
            $status = 'error';
            return compact(['message', 'status']);
        } else {
            DB::table('tbTr_PB_H')->where('PBH_NOPB', '=', $request->value)->delete();
            DB::table('tbTr_PB_D')->where('PBD_NOPB', '=', $request->value)->delete();

            $message = 'Dokumen berhasil dihapus!';
            $status = 'success';
            return compact(['message', 'status']);
        }
    }

    public function getDataPB(Request $request)
    {

        $MODEL = '';
        $pb = [];
        $pbd = [];
        $message = '';
        $status = '';
        if (is_null($request->value)) {
            $MODEL = 'TAMBAH';
            $c = oci_connect('SIMSMG', 'SIMSMG', '192.168.237.193:1521/SIMSMG');

            $s = oci_parse($c, "BEGIN :ret := F_IGR_GET_NOMOR('" . $_SESSION['kdigr'] . "','PB','Nomor Permintaan Barang'," . $_SESSION['kdigr'] . " || TO_CHAR (SYSDATE, 'yyMM'),3,TRUE); END;");
            oci_bind_by_name($s, ':ret', $r, 32);
            oci_execute($s);

            $TGLPB = Carbon::now();
            $pb['pbh_nopb'] = $r;
            $pb['pbh_tglpb'] = $TGLPB;
        } else {
            $pb = DB::table('tbTr_PB_H')
                ->select('pbh_nopb', 'pbh_tglpb', 'pbh_tipepb', 'pbh_jenispb', 'pbh_flagdoc', 'pbh_keteranganpb', 'pbh_tgltransfer')
                ->where('PBH_KodeIGR', '=', $_SESSION['kdigr'])
                ->where('PBH_NOPB', '=', $request->value)
                ->first();

            if (is_null($pb)) {
                $message = 'Nomor PB tidak ditemukan!';
                $status = 'error';
                return compact(['message', 'status']);
            }
            $TGLPB = $pb->pbh_tglpb;
            $TIPE = $pb->pbh_tipepb;
            $FLAG = $pb->pbh_jenispb;
            $STATUS = $pb->pbh_flagdoc;
            $KET = $pb->pbh_keteranganpb;
            $TGLTRF = $pb->pbh_tgltransfer;

            if (($FLAG == '*') OR !is_null($TGLTRF)) {
                $MODEL = 'PB SUDAH DICETAK / TRANSFER';
            } else {
                $MODEL = 'KOREKSI';
            }

            $pluomi = DB::table('tbmaster_prodcrm')
                ->selectRaw('prc_pluigr pluomi')
                ->whereRaw('prc_kodeigr =  ' . $_SESSION['kdigr'])
                ->whereRaw('prc_group = \'O\'')
                ->toSql();
            $pluidm = DB::table('tbmaster_prodcrm')
                ->selectRaw('NVL(prc_pluigr,\'0\') pluidm')
                ->whereRaw('prc_kodeigr =  ' . $_SESSION['kdigr'])
                ->whereRaw('prc_group = \'I\'')
                ->toSql();

            $pbd = DB::table('tbtr_pb_d')
                ->join('tbmaster_prodmast', 'PBD_PRDCD', 'PRD_PRDCD')
                ->leftJoin('tbmaster_stock', function ($join) {
                    $join->on('pbd_prdcd', 'st_prdcd')->On('st_lokasi', DB::RAW('01'));
                })
                ->join('tbmaster_supplier', 'pbd_kodesupplier', 'sup_kodesupplier')
                ->leftJoin(DB::RAW('(' . $pluomi . ')'), 'pbd_prdcd', 'pluomi')
                ->leftJoin(DB::RAW('(' . $pluidm . ')'), 'pbd_prdcd', 'pluidm')
                ->leftJoin('tbmaster_minimumorder', 'prd_prdcd', 'min_prdcd')
                ->selectRaw('DISTINCT pbd_nourut, PBD_PRDCD,PRD_DESKRIPSIPANJANG,PRD_DESKRIPSIPENDEK, PRD_KODEDIVISI, PRD_KODEDIVISIPO, PRD_KODEDEPARTEMENT, PRD_KODEKATEGORIBARANG, PRD_FRAC, PRD_UNIT,PRD_KODETAG,SUM(PBD_QTYPB) PBD_QTYPB,ST_SALDOAKHIR,PRD_FLAGBKP1,PBD_KODESUPPLIER,SUP_NAMASUPPLIER, 
                CASE WHEN NVL(PLUOMI,\' \')=\' \' THEN \'N\' ELSE \'Y\' END F_OMI, 
                CASE WHEN NVL(PLUIDM,\' \')=\' \' THEN \'N\' ELSE \'Y\' END F_IDM,
                NVL(MIN_MINORDER,0) vMinOrderMin,
                NVL(PRD_MINORDER,0) vMinOrderPrd,
                NVL(PRD_ISIBELI,1) vPrdisiBeli,
                PBD_FDXREV,PBD_HRGSATUAN,PBD_RPHDISC1,PBD_PERSENDISC1,PBD_RPHDISC2,PBD_PERSENDISC2,PBD_BONUSPO1,PBD_BONUSPO2,PBD_GROSS,PBD_PPN,PBD_PPNBM,PBD_PPN,PBD_PPNBOTOL,PRD_HRGJUAL,PBD_PKMT,PBD_SALDOAKHIR')
                ->where('PBD_NOPB', $request->value)
                ->groupBy(DB::raw('pbd_nourut,PBD_PRDCD,PRD_DESKRIPSIPANJANG,PRD_DESKRIPSIPENDEK,PRD_KODEDIVISI, PRD_KODEDIVISIPO, PRD_KODEDEPARTEMENT, PRD_KODEKATEGORIBARANG, PRD_FRAC,PRD_UNIT,
                    PRD_KODETAG,ST_SALDOAKHIR,PRD_FLAGBKP1,PBD_KODESUPPLIER,SUP_NAMASUPPLIER,
                    CASE WHEN NVL(PLUOMI,\' \')=\' \' THEN \'N\' ELSE \'Y\' END,
                    CASE WHEN NVL(PLUIDM,\' \')=\' \' THEN \'N\' ELSE \'Y\' END,
                  NVL(MIN_MINORDER,0),NVL(PRD_MINORDER,0),NVL(PRD_ISIBELI,1),PBD_FDXREV,PBD_HRGSATUAN,PBD_RPHDISC1,PBD_PERSENDISC1,PBD_RPHDISC2,PBD_PERSENDISC2,PBD_BONUSPO1,PBD_BONUSPO2,PBD_GROSS,PBD_PPN,PBD_PPNBM,PBD_PPN,PBD_PPNBOTOL,PRD_HRGJUAL,PBD_PKMT,PBD_SALDOAKHIR'))
                ->orderBy('pbd_nourut')
                ->get();
//            dd($pbd);
            for ($i = 0; $i < sizeof($pbd); $i++) {
                if ($pbd[$i]->vminordermin == 0) {
                    if ($pbd[$i]->vminorderprd == 0) {
                        $pbd[$i]->minor = $pbd[$i]->vprdisibeli;
                    } else {
                        $pbd[$i]->minor = $pbd[$i]->vminorderprd;
                    }
                } else {
                    $pbd[$i]->minor = $pbd[$i]->vminordermin;
                }
                $pbd[$i]->satuan = $pbd[$i]->prd_unit . '/' . $pbd[$i]->prd_frac;
                $pbd[$i]->qtyctn = round($pbd[$i]->pbd_qtypb / $pbd[$i]->prd_frac);
                $pbd[$i]->qtypcs = fmod($pbd[$i]->pbd_qtypb, $pbd[$i]->prd_frac);

//                $hrgbeli = ($pbd[$i]->qtyctn*$pbd[$i]->pbd_hrgsatuan)+($pbd[$i]->qtypcs*($pbd[$i]->pbd_hrgsatuan/$pbd[$i]->prd_frac));
//                $pbd[$i]->pbd_gross = $hrgbeli-($hrgbeli*$pbd[$i]->pbd_persendisc1/100);
//                $hrgbeli = $pbd[$i]->pbd_gross;
//                $pbd[$i]->pbd_gross = $hrgbeli-($hrgbeli*$pbd[$i]->pbd_persendisc2/100);
//                $pbd[$i]->pbd_ppn = ($pbd[$i]->pbd_gross*$pbd[$i]->pbd_ppn)/100;
//                $pbd[$i]->pbd_ppnbm = $pbd[$i]->pbd_ppnbm * $pbd[$i]->pbd_qtypb;
//                $pbd[$i]->pbd_ppnbotol = $pbd[$i]->pbd_ppnbotol * $pbd[$i]->pbd_qtypb;
                $pbd[$i]->total = $pbd[$i]->pbd_gross + $pbd[$i]->pbd_ppn + $pbd[$i]->pbd_ppnbm + $pbd[$i]->pbd_ppnbotol;

            }
        }
        return compact(['pb', 'MODEL', 'pbd', 'message', 'status']);

    }


    public
    function cek_plu(Request $request)
    {
        v_oke := false;
        :PBD_PRDCD := LPAD(RPAD(SUBSTR(:PBD_PRDCD,0,LENGTH(:PBD_PRDCD)-1),LENGTH(:PBD_PRDCD),'0'),7,'0');
//	validate_rec(temp);
        :PBD_NOPB    := :NOPB;
        :PBD_KODEIGR := :parameter.KODEIGR;

		sp_igr_bo_pb_cek_plu(
			:parameter.KODEIGR,
			:PBD_PRDCD,
			:TGLPB,
			:FLAG,
			:DESKPDK,
			:DESKPJG,
			:UNIT,
   		:FRAC,
			:BKP,
			:PBD_KODESUPPLIER,
			:SUPPLIER,
			:SUPPKP,
			:HG_JUAL,
			:ISI_BELI,
			:PBD_SALDOAKHIR, --STOCK,
			:MINOR,
			:PBD_PKMT,
			:PBD_PERSENDISC1,
			:PBD_RPHDISC1,
			:PBD_FLAGDISC1,
			:PBD_PERSENDISC2,
			:PBD_RPHDISC2,
			:PBD_FLAGDISC2,
			:PBD_TOP,
			:F_OMI,
			:F_IDM,
			:PBD_HRGSATUAN,
			:PBD_PPNBM,
			:PBD_PPNBOTOL,
			v_oke,
			v_message);


    If v_oke Then
    :SATUAN   := :UNIT||'/'||TO_CHAR(Nvl(:FRAC,1));
			select prd_kodedivisi, prd_kodedivisipo, prd_kodedepartement, prd_kodekategoribarang
			into :pbd_kodedivisi, :pbd_kodedivisipo, :pbd_kodedepartement, :pbd_kodekategoribrg
			from tbmaster_prodmast
			where prd_kodeigr = :parameter.kodeigr and prd_prdcd = :pbd_prdcd;

        $c = oci_connect('SIMSMG', 'SIMSMG', '192.168.237.193:1521/SIMSMG');

        $s = oci_parse($c, "BEGIN sp_igr_bo_pb_cek_bonus('" .
            $request->PBD_PRDCD . "," .
            $request->PBD_KODESUPPLIER . "," .
            $request->TGLPB . "," .
            $request->FRAC . "," .
            $request->PBD_QTYPB . "," .
            $request->PBD_BONUSPO1 . "," .
            $request->PBD_BONUSPO2 . "," .
            $request->PBD_PPN . "," .
            $request->PBD_PPNBM . "," .
            $request->PBD_PPNBOTOL . "," .
            ":v_oke," .
            ":v_message);END;");
        oci_bind_by_name($s, ':v_oke', $v_oke, 32);
        oci_bind_by_name($s, ':v_message', $v_message, 32);
        oci_execute($s);
//        $VLPLU = FALSE;
//        $PPLU = $request->plu;
//        $TGLPB = $request->tglpb;
//        $FLAG = $request->flag;
//
//        if (is_null($PPLU) || $PPLU == "") {
//            $message = 'PLU tidak boleh kosong!!';
//            $status = 'error';
//            return compact(['message', 'status']);
//        }
//
//
//        $pluomi = DB::table('tbmaster_prodcrm')
//            ->selectRaw('prc_pluigr pluomi')
//            ->whereRaw('prc_pluigr =  ' . $PPLU)
//            ->whereRaw('prc_group = \'O\'')
//            ->toSql();
//        $pluidm = DB::table('tbmaster_prodcrm')
//            ->selectRaw('NVL(prc_pluigr,\'0\') pluidm')
//            ->whereRaw('prc_pluigr =  ' . $PPLU)
//            ->whereRaw('prc_group = \'I\'')
//            ->toSql();
//
//        $promo = DB::table('TBMASTER_PROMOSI_HDR')->join('TBMASTER_PROMOSI_DTL', 'HPRO_DOCNO', 'DPRO_DOCNO')
//            ->selectRaw('SUBSTR (DPRO_PLU, 1, 6) || \'0\' PRDCD')
//            ->selectRaw('MAX (HPRO_TGLMULAI) TGLAWAL')
//            ->selectRaw('MAX (HPRO_TGLAKHIR) TGLAKHIR')
//            ->GroupBy(DB::raw('SUBSTR (DPRO_PLU, 1, 6) || \'0\''))
//            ->toSql();
//
//        $gnd = DB::table('TBTR_GONDOLA')
//            ->selectRaw('DISTINCT(GDL_PRDCD) GDL_PRDCD')
//            ->whereRaw('GDL_TGLAWAL-3 <= to_date(\'' . $TGLPB . '\',\'dd/mm/yyyy\')')
//            ->whereRaw('GDL_TGLAWAL-7 >= to_date(\'' . $TGLPB . '\',\'dd/mm/yyyy\')')
//            ->toSql();
//
//        $plu = DB::table('tbmaster_prodmast')
//            ->leftJoin(DB::RAW('(' . $pluomi . ')'), 'prd_prdcd', 'pluomi')
//            ->leftJoin(DB::RAW('(' . $pluidm . ')'), 'prd_prdcd', 'pluidm')
//            ->leftJoin('TBMASTER_TAG', 'PRD_KODETAG', 'TAG_KODETAG')
//            ->leftJoin(DB::RAW('(' . $promo . ')'), 'PRD_PRDCD', 'PRDCD')
//            ->leftJoin('TBMASTER_KATEGORITOKO', 'PRD_KATEGORITOKO', 'KTK_KODEKATEGORITOKO')
//            ->leftJoin('TBMASTER_KKPKM', 'PRD_PRDCD', 'PKM_PRDCD')
//            ->leftJoin(DB::RAW('(' . $gnd . ')'), 'PRD_PRDCD', 'GDL_PRDCD')
//            ->leftJoin('TBTR_PKMGONDOLA', 'PRD_PRDCD', 'PKMG_PRDCD')
//            ->leftJoin('TBMASTER_SUPPLIER', 'PRD_KODESUPPLIER', 'SUP_KODESUPPLIER')
//            ->leftJoin('TBMASTER_MINIMUMORDER', 'PRD_PRDCD', 'MIN_PRDCD')
//            ->leftJoin('tbmaster_stock', function ($join) {
//                $join->on('prd_prdcd', 'st_prdcd')->On('st_lokasi', DB::RAW('01'));
//            })
//            ->leftJoin('TBMASTER_HARGABELI', function ($join) {
//                $join->on('prd_prdcd', 'HGB_PRDCD')->On('HGB_TIPE', DB::RAW('2'));
//            })
//            ->selectRaw('*')
//            ->where('PRD_PRDCD', $PPLU)
//            ->first();
//
//        if (!is_null($plu)) {
//            $VLPLU = TRUE;
//
//            if ($plu->prd_recordid == '1') {
//                $message = 'PLU [' . $PPLU . '] tidak boleh ORDER ' . ' PRD_RECORDID = 1';
//                $status = 'error';
//                return compact(['message', 'status']);
//            }
//            if (!is_null($plu->prd_kodetag) && Trim($plu->tag_tidakbolehorder) == 'Y') {
//                $message = 'PLU [' . $PPLU . '] TAG tidak boleh ORDER ' . 'PRD_KODETAG= Tidak Boleh Order';
//                $status = 'error';
//                return compact(['message', 'status']);
//            }
//
//            if ($plu->prd_kodekategoribarang == 'C') {
//                $message = 'PLU [' . $PPLU . '] TAG tidak boleh ORDER ' . 'PRD_KODETAG= Tidak Boleh Order';
//                $status = 'error';
//                return compact(['message', 'status']);
//            }
//
//            if (in_array($plu->prd_flaggudang, ['Y', 'P']) && $FLAG <> '2') {
//                $message = 'PLU [' . $PPLU . '] Pusat tidak boleh ORDER';
//                $status = 'error';
//                return compact(['message', 'status']);
//            }
//
//            if (!in_array($plu->prd_flaggudang, ['Y', 'P']) && $FLAG == '2') {
//                $message = 'PLU [' . $PPLU . '] tidak boleh ORDER';
//                $status = 'error';
//                return compact(['message', 'status']);
//            }
//
////            --->>>> Cek Kategori Toko <<<<---
//            if (is_null($plu->prd_kategoritoko) && is_null($plu->prd_kodecabang)) {
//                $message = 'PLU [' . $PPLU . '] tidak boleh ORDER';
//                $status = 'error';
//                return compact(['message', 'status']);
//            }
//            if (!is_null($plu->prd_kategoritoko)) {
//                if (is_null($plu->ktk_kodekategoritoko)) {
//                    $message = 'PLU [' . $PPLU . '] Kategori Barang tidak terdaftar';
//                    $status = 'error';
//                    return compact(['message', 'status']);
//                }
//
//                if (strpos($plu->ktk_classkodeigr, $_SESSION['kdigr']) == 0) {
//                    $message = 'PLU [' . $PPLU . '] Kategori Barang tidak sesuai';
//                    $status = 'error';
//                    return compact(['message', 'status']);
//                }
//            }
////
//////            --->>> ------------------ <<<----
//            if ($plu->prd_flagbarangordertoko == 'Y') {
//                $message = 'PLU [' . $PPLU . '] tidak boleh Order';
//                $status = 'error';
//                return compact(['message', 'status']);
//            }
//
//            if (is_null($plu->pkm_prdcd)) {
//                $message = 'PLU [' . $PPLU . '] tidak terdaftar di Table PKM';
//                $status = 'error';
//                return compact(['message', 'status']);
//            }
//
//            $deskpdk = $plu->prd_deskripsipendek;
//            $plu->satuan = $plu->prd_unit . '/' . Self::ceknull($plu->prd_frac, 1);
//            $plu->pbd_frac = $plu->prd_frac;
//            $plu->pbd_unit = $plu->prd_unit;
//            $plu->pbd_kodesupplier = $plu->hgb_kodesupplier;
//            $isi_beli = $plu->prd_isibeli;
//            $pkp = $plu->prd_flagbkp1;
//            $suppkp = $plu->sup_pkp;
//
//            //            ---->>> Kotak Kanan Atas <<<----
//            $HG_JUAL = Self::ceknull($plu->prd_hrgjual, 0);
//            $PBD_SALDOAKHIR = Self::ceknull($plu->st_saldoakhir, 0);
//
//            if (is_null($plu->min_minorder)) {
//                if (Self::ceknull($plu->prd_minorder, 0) == 0) {
//                    $plu->minor = $plu->prd_isibeli;
//                } else {
//                    $plu->minor = $plu->prd_minorder;
//
//                }
//            } else {
//                $plu->minor = $plu->min_minorder;
//            }
////            --->>> Cek Data PKM Gondola
//            if (!is_null($plu->pkm_prdcd)) {
//                if (!is_null($plu->gdl_prdcd)) {
//                    if (!is_null($plu->pkmg_prdcd)) {
//                        $plu->pbd_pkmt = $plu->pkmg_nilaipkmg;
//                    } else {
//                        $plu->pbd_pkmt = $plu->pkm_pkmt;
//                    }
//                } else {
//                    $plu->pbd_pkmt = $plu->pkm_pkmt;
//                }
//            }
//
//
//            if (Self::ceknull($plu->pluomi, '') == '') {
//                $plu->f_omi = 'N';
//            } else {
//                $plu->f_omi = 'Y';
//            }
//
//            if (Self::ceknull($plu->pluidm, '') == '') {
//                $plu->f_idm = 'N';
//            } else {
//                $plu->f_idm = 'Y';
//            }
//            $plu->pbd_hrgsatuan = $plu->hgb_hrgbeli * $plu->prd_frac;
//
////        --->>> Hitung Data Discount <<<---
//            if (Self::ceknull($plu->hgb_persendisc01, 0) <> 0) {
//                $plu->pbd_persendisc1 = $plu->hgb_persendisc01;
//                $plu->pbd_rphdisc1 = 0;
//                $plu->pbd_flagdisc1 = ' ';
//            } else {
//                $plu->pbd_persendisc1 = 0;
//                $plu->pbd_rphdisc1 = $plu->hgb_rphdisc01;
//                $plu->pbd_flagdisc1 = $plu->hgb_flagdisc01;
//            }
//
//            $plu->pbd_ppnbm = $plu->hgb_ppnbm * $plu->prd_frac;
//            $plu->pbd_ppnbotol = $plu->hgb_ppnbotol * $plu->prd_frac;
//            $plu->pbd_bonuspo1 = 0;
//
//            $plu->pbd_bonuspo2 = 0;
//            $plu->pbd_qtybpb = 0;
//            $plu->pbd_bonusbpb1 = 0;
//            $plu->pbd_bonusbpb2 = 0;
//            $plu->pbd_rphttldisc = 0;
//            $plu->pbd_ostpb = 0;
//            $plu->pbd_ostpo = 0;
//
//            if ($plu->sup_flagopentop == 'Y') {
//                $plu->pbd_top = $plu->hgb_top;
//            } else {
//                if (!is_null($plu->sup_kondisipbykonsinyasi)) {
//                    $plu->pbd_top = $plu->sup_kondisipbykonsinyasi;
//                } else {
//                    $plu->pbd_top = $plu->sup_kondisipbykredit;
//                }
//            }
//
//            if (Carbon::now() >= $plu->hgb_tglmulaidisc02 && Carbon::now() <= $plu->hgb_tglakhirdisc02) {
//                $plu->pbd_persendisc2 = Self::ceknull($plu->hgb_persendisc02, 0);
//                $plu->pbd_rphdisc2 = Self::ceknull($plu->hgb_rphdisc02, 0);
//            }
//        }
//
//        if ($VLPLU == FALSE) {
//            $message = 'PLU [' . $PPLU . '] tidak terdaftar di Master Barang';
//            $status = 'error';
//            return compact(['message', 'status']);
//        }

        return compact(['plu', 'message', 'status']);
    }

    public function nextvalidate(Request $request)
    {
        $message = '';
        $status = '';
        $v_oke = '';
        $v_message = '';
        if (Self::ceknull($request->PBD_recordid, 9) <> 2) {
            $request->QTYPCS = Self::ceknull($request->QTYPCS, 0);
            $request->PBD_QTYPB = ($request->QTYCTN * $request->FRAC) + $request->QTYPCS;
            $request->QTYCTN = TRUNC(($request->PBD_QTYPB) / $request->FRAC);
            $request->QTYPCS = $request->PBD_QTYPB % $request->FRAC;
            $request->PBD_GROSS = ($request->QTYCTN * $request->PBD_HRGSATUAN) + (($request->PBD_HRGSATUAN / $request->FRAC) * $request->QTYPCS);
            if (Self::ceknull($request->PBD_PERSENDISC1, 0) > 0) {
                $request->PBD_GROSS = $request->PBD_GROSS - (($request->PBD_GROSS * $request->PBD_PERSENDISC1) / 100);
            }
            if ($request->BKP == 'Y') {
                $request->PBD_PPN = ($request->PBD_GROSS * 10) / 100;
            } else {
                $request->PBD_PPN = 0;
            }

            if (($request->QTYCTN * $request->FRAC) + $request->QTYPCS < $request->MINOR) {
                $message = 'QTYB + QTYK < MINOR';
                $status = 'info';
                $request->QTYCTN = ($request->MINOR / $request->FRAC);
                $request->QTYPCS = $request->MINOR % $request->FRAC;
            }

            if (($request->QTYCTN * $request->FRAC) + $request->QTYPCS <= 0) {
                $message = 'QTYB + QTYK <= 0';
                $status = 'info';
            } else {
                $c = oci_connect('SIMSMG', 'SIMSMG', '192.168.237.193:1521/SIMSMG');

                $s = oci_parse($c, "BEGIN sp_igr_bo_pb_cek_bonus('" .
                    $request->PBD_PRDCD . "," .
                    $request->PBD_KODESUPPLIER . "," .
                    $request->TGLPB . "," .
                    $request->FRAC . "," .
                    $request->PBD_QTYPB . "," .
                    $request->PBD_BONUSPO1 . "," .
                    $request->PBD_BONUSPO2 . "," .
                    $request->PBD_PPN . "," .
                    $request->PBD_PPNBM . "," .
                    $request->PBD_PPNBOTOL . "," .
                    ":v_oke," .
                    ":v_message);END;");
                oci_bind_by_name($s, ':v_oke', $v_oke, 32);
                oci_bind_by_name($s, ':v_message', $v_message, 32);
                oci_execute($s);

//                sp_igr_bo_pb_cek_bonus(
//                    $request->PBD_PRDCD,
//                    $request->PBD_KODESUPPLIER,
//                    $request->TGLPB,
//                    $request->FRAC,
//                    $request->PBD_QTYPB,
//                    $request->PBD_BONUSPO1,
//                    $request->PBD_BONUSPO2,
//                    $request->PBD_PPN,
//                    $request->PBD_PPNBM,
//                    $request->PBD_PPNBOTOL,
//                    $v_oke,
//                    $v_message);

                if ($v_oke) {
                    $hrgbeli = ($request->qtyctn * $request->pbd_hrgsatuan) + ($request->qtypcs * ($request->pbd_hrgsatuan / $request->prd_frac));
                    $request->pbd_gross = $hrgbeli - ($hrgbeli * $request->pbd_persendisc1 / 100);
                    $hrgbeli = $request->pbd_gross;
                    $request->pbd_gross = $hrgbeli - ($hrgbeli * $request->pbd_persendisc2 / 100);
                    $request->pbd_ppn = ($request->pbd_gross * $request->pbd_ppn) / 100;
                    $request->pbd_ppnbm = $request->pbd_ppnbm * $request->pbd_qtypb;
                    $request->pbd_ppnbotol = $request->pbd_ppnbotol * $request->pbd_qtypb;
                    $request->total = $request->pbd_gross + $request->pbd_ppn + $request->pbd_ppnbm + $request->pbd_ppnbotol;
                } else {
                    $message = $v_message;
                    $status = 'info';
                }
            }
        }
        return compact(['message', 'status']);

    }

    public function ceknull($value, $ret)
    {
        if ($value == "" || $value == null || is_null($value)) {
            return $ret;
        }
        return $value;
    }
}