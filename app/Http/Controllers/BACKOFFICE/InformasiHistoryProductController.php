<?php

namespace App\Http\Controllers\BACKOFFICE;

use Carbon\Traits\Date;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\NotIn;
use phpDocumentor\Reflection\Types\Integer;
use Carbon\Carbon;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\File;
use Yajra\DataTables\DataTables;

class InformasiHistoryProductController extends Controller
{
    public function index()
    {

        return view('BACKOFFICE.informasi-history-product');
    }

    public function lovSearch(Request $request)
    {
        $search = $request->value;

        $data = DB::connection(Session::get('connection'))->table('tbmaster_prodmast')
            ->whereRaw("(prd_prdcd LIKE '%" . $search . "%' or prd_deskripsipanjang LIKE '%" . $search . "%')")
            ->whereRaw("SUBSTR (PRD_PRDCD, 7, 1) = '0'")
            ->orderBy('prd_prdcd')
            ->limit(100)
            ->get();

        return Datatables::of($data)->make(true);
    }

    public function lovSelect(Request $request)
    {
        $message = array();
        $lCek = 1;
        $cprdcd = $request->value;
        $hrgpromo = 0;
        $tglpromo = '';
        $jampromo = '';
        $showpromo = false;
        $dsi = 0;
        $to = 0;
        $plu = '';

        if (ord(substr($cprdcd, 1, 1)) < 48 or ord(substr($cprdcd, 1, 1)) > 57) {
            $lCek = 2;
        } else if (strlen(trim($cprdcd)) > 7) {
            $lCek = 3;
        }
        if ($lCek == 1) {
            $plu = DB::connection(Session::get('connection'))->table('tbmaster_barcode')->rightJoin('tbmaster_prodmast', 'brc_prdcd', '=', 'prd_prdcd')
                ->selectRaw('distinct prd_prdcd, prd_deskripsipendek, brc_barcode')
                ->where('prd_prdcd', '=', $request->value)
                ->first();
            if (is_null($plu)) {
                array_push($message,  __('Kode Tidak Terdaftar').'!!');
                return $message;
            }
        } else if ($lCek == 2) {
            $plu = DB::connection(Session::get('connection'))->table('tbmaster_barcode')->rightJoin('tbmaster_prodmast', 'brc_prdcd', '=', 'prd_prdcd')
                ->selectRaw('distinct prd_prdcd, prd_deskripsipendek, brc_barcode')
                ->whereRaw('lower(prd_deskripsipendek) = \'' . strtolower((string)$request->value) . '\'')
                ->first();
            if (is_null($plu)) {
                array_push($message, 'Deskripsi Tidak Terdaftar !!');
                return $message;
            }
        } else {
            $plu = DB::connection(Session::get('connection'))->table('tbmaster_barcode')
                ->join('tbmaster_prodmast', 'brc_prdcd', '=', 'prd_prdcd')
                ->selectRaw('distinct prd_prdcd, prd_deskripsipendek, brc_barcode')
                ->where('brc_barcode', '=', $request->value)
                ->first();

            if (is_null($plu)) {
                array_push($message, 'Barcode Tidak Terdaftar !!');
                return $message;
            }
        }
        $plu->prd_prdcd = substr($plu->prd_prdcd, 0, 6) . '0';
        $produk = DB::connection(Session::get('connection'))->table('TBMASTER_CABANG')->Join('TBMASTER_PRODMAST', function ($join) {
            $join->on('CAB_KODECABANG', '=', 'PRD_KODEIGR')->On('CAB_KODEIGR', '=', 'PRD_KODEIGR');
        })->leftJoin('TBMASTER_STOCK', function ($join) {
            $join->On(DB::connection(Session::get('connection'))->raw('SUBSTR (ST_PRDCD, 1, 6)'), '=', DB::connection(Session::get('connection'))->raw('SUBSTR (PRD_PRDCD, 1, 6)'))->On('ST_KODEIGR', '=', 'PRD_KODEIGR')->On('ST_LOKASI', '=', 01);
        })->Join('TBMASTER_DIVISI', function ($join) {
            $join->On('DIV_KODEDIVISI', '=', 'PRD_KODEDIVISI')->On('DIV_KODEIGR', '=', 'PRD_KODEIGR');
        })->Join('TBMASTER_DEPARTEMENT', function ($join) {
            $join->On('DEP_KODEDEPARTEMENT', '=', 'PRD_KODEDEPARTEMENT')->On('DEP_KODEIGR', '=', 'PRD_KODEIGR')->On('DEP_KODEDIVISI', '=', 'DIV_KODEDIVISI');
        })->Join('TBMASTER_KATEGORI', function ($join) {
            $join->On('KAT_KODEKATEGORI', '=', 'PRD_KODEKATEGORIBARANG')->On('KAT_KODEIGR', '=', 'PRD_KODEIGR')->On('KAT_KODEDEPARTEMENT', '=', 'DEP_KODEDEPARTEMENT');
        })->leftJoin('TBMASTER_MINIMUMORDER', function ($join) {
            $join->On(DB::connection(Session::get('connection'))->raw('SUBSTR (MIN_PRDCD, 1, 6)'), '=', DB::connection(Session::get('connection'))->raw('SUBSTR (PRD_PRDCD, 1, 6)'))->On('MIN_KODEIGR', '=', 'PRD_KODEIGR')->On('KAT_KODEDEPARTEMENT', '=', 'DEP_KODEDEPARTEMENT');
        })->leftJoin('TBTR_PROMOMD', function ($join) {
            $join->On('PRMD_PRDCD', '=', 'PRD_PRDCD')->On('PRMD_KODEIGR', '=', 'PRD_KODEIGR');
        })->leftJoin('TBMASTER_BARCODE', function ($join) {
            $join->On('BRC_PRDCD', '=', 'PRD_PRDCD')->whereNotNull('BRC_BARCODE');
        })->SelectRaw('PRD_PRDCD,
                   PRD_DESKRIPSIPANJANG,
                   PRD_KODETAG,
                   PRD_FLAGBKP1,
                   PRD_FLAGBANDROL,
                   PRD_UNIT,
                   PRD_FRAC,
                   PRD_FLAGGUDANG,
                   PRD_KODECABANG,
                   PRD_KATEGORITOKO,
                   PRD_KODEDIVISI,
                   DIV_NAMADIVISI,
                   PRD_KODEDEPARTEMENT,
                   DEP_NAMADEPARTEMENT,
                   PRD_KODEKATEGORIBARANG,
                   KAT_NAMAKATEGORI,
                   PRD_MINORDER,
                   PRD_ISIBELI,
                   PRD_CREATE_DT,
                   PRD_HRGJUAL,
                   CAB_NAMACABANG,
                   ST_AVGCOST,
                   MIN_MINORDER,
                   PRMD_PRDCD,
                   PRMD_HRGJUAL,
                   PRMD_POTONGANPERSEN,
                   PRMD_POTONGANRPH,
                   BRC_BARCODE,
                   MAX (PRMD_TGLAWAL) PRM_TGLMULAI,
                   MAX (PRMD_TGLAKHIR) PRM_TGLAKHIR,
                   MAX (PRMD_JAMAWAL) PRM_JAMMULAI,
                   MAX (PRMD_JAMAKHIR) PRM_JAMAKHIR,
                   NVL (PRD_FLAGOBI, \'N\') OBI,
                   NVL (PRD_FLAGNAS, \'N\') NAS,
                   NVL (PRD_FLAGBRD, \'N\') BRD,
                   NVL (PRD_FLAGOMI, \'N\') OMI,
                   NVL (PRD_FLAGIDM, \'N\') IDM,
                   NVL (PRD_FLAGIGR, \'N\') IGR')
            ->where('prd_prdcd', '=', $plu->prd_prdcd)
            ->groupBy(DB::connection(Session::get('connection'))->raw('PRD_PRDCD,
                   PRD_DESKRIPSIPANJANG,
                   PRD_KODETAG,
                   PRD_FLAGBKP1,
                   PRD_FLAGBANDROL,
                   PRD_UNIT,
                   PRD_FRAC,
                   PRD_FLAGGUDANG,
                   PRD_KODECABANG,
                   PRD_KATEGORITOKO,
                   PRD_KODEDIVISI,
                   DIV_NAMADIVISI,
                   PRD_KODEDEPARTEMENT,
                   DEP_NAMADEPARTEMENT,
                   PRD_KODEKATEGORIBARANG,
                   KAT_NAMAKATEGORI,
                   PRD_MINORDER,
                   PRD_ISIBELI,
                   PRD_CREATE_DT,
                   PRD_HRGJUAL,
                   CAB_NAMACABANG,
                   ST_AVGCOST,
                   MIN_MINORDER,
                   BRC_BARCODE,
                   PRMD_HRGJUAL,
                   PRMD_POTONGANPERSEN,
                   PRMD_POTONGANRPH,
                   PRMD_PRDCD,
                   NVL (PRD_FLAGOBI, \'N\'),
                   NVL (PRD_FLAGNAS, \'N\'),
                   NVL (PRD_FLAGBRD, \'N\'),
                   NVL (PRD_FLAGOMI, \'N\'),
                   NVL (PRD_FLAGIDM, \'N\'),
                   NVL (PRD_FLAGIGR, \'N\')'))
            ->first();

        $pri = DB::connection(Session::get('connection'))->table('tbmaster_prodcrm')
            ->select('*')
            ->where('prc_pluigr', '=', $produk->prd_prdcd)
            ->where('prc_group', '=', 'I')
            ->first();

        if (is_null($pri)) {
            $plu_idm = 'N';
            $tag_idm = null;
        } else {
            $plu_idm = 'Y';
            $tag_idm = $pri->prc_kodetag;
        }

        $pro = DB::connection(Session::get('connection'))->table('tbmaster_prodcrm')
            ->select('*')
            ->where('prc_pluigr', '=', $produk->prd_prdcd)
            ->where('prc_group', '=', 'O')
            ->first();

        if (is_null($pro)) {
            $plu_omi = 'N';
            $tag_omi = null;
        } else {
            $plu_omi = 'Y';
            $tag_omi = $pro->prc_kodetag;
        }
        $ITEM = '';
        if ($produk->idm == "Y" && $produk->omi == "N") {
            $ITEM = "ITEM IDM";
            if (in_array($tag_idm, ['A', 'R', 'N', 'O', 'H', 'X'])) {
                $ITEM = 'ITEM IDM' . ' [Tag : ' . $tag_idm . ' ]';
            }
        } else if ($produk->idm == "N" && $produk->omi == "Y") {
            $ITEM = "ITEM OMI";
            if (in_array($tag_omi, ['A', 'R', 'N', 'O', 'H', 'X'])) {
                $ITEM = 'ITEM OMI' . ' [Tag : ' . $tag_omi . ' ]';
            }
        } else if ($produk->idm == "Y" && $produk->omi == "Y") {
            $ITEM = 'ITEM OMI + ITEM IDM';
        }

        $ketkat = '';
        if ($produk->prd_kodedivisi == 3) {
            $ketkat = 'G.M.S';
        } else {
            $ketkat = $produk->div_namadivisi;
        }

        $KATBRG = $produk->prd_kodedivisi
            . ' '
            . $ketkat
            . ' '
            . $produk->prd_kodedepartement
            . ' '
            . $produk->dep_namadepartement
            . '   '
            . $produk->prd_kodekategoribarang
            . ' '
            . $produk->kat_namakategori;


        if (!isset($produk->cab_namacabang) && !isset($produk->prd_kategoritoko)) {
            array_push($message, 'PLU tsb sdh tidak aktif di Cabang ini,; kalau masih ada di rak harap ditarik');
        }
//        dd(Carbon::today(),Carbon::createFromFormat('Y-m-d',substr($produk->prm_tglakhir, 0, 10)),Carbon::today()->lte(Carbon::createFromFormat('Y-m-d',substr($produk->prm_tglakhir, 0, 10)) ) );
//        dd(Carbon::now()->lte(Carbon::now())  );

        if (isset($produk->prmd_prdcd) && isset($produk->prm_tglmulai) && isset($produk->prm_tglakhir)) {
            if (Carbon::today() >= Carbon::createFromFormat('Y-m-d', substr($produk->prm_tglmulai, 0, 10)) && Carbon::today() <= Carbon::createFromFormat('Y-m-d', substr($produk->prm_tglakhir, 0, 10))) {
                $showpromo = true;
                $tglpromo = date('d/m/y', strtotime(substr($produk->prm_tglmulai, 0, 10))) . ' s/d ' . date('d/m/y', strtotime(substr($produk->prm_tglakhir, 0, 10)));
                if (!is_null($produk->prm_jammulai)) {
                    $jampromo = $produk->prm_jammulai . ' s/d ' . $produk->prm_jamakhir;
                }
                if ($produk->prd_hrgjual != 0) {
                    $hrgpromo = $produk->prmd_hrgjual;
                } else if ($produk->prmd_potonganpersen != 0) {
                    $hrgpromo = $produk->prd_hrgjual - ($produk->prd_hrgjual * ($produk->prmd_potonganpersen / 100));
                } else {
                    $hrgpromo = ($produk->prd_hrgjual - $produk->prmd_potonganrph);
                }
            }

        }

        if (self::ceknull($produk->prd_minorder, 0) > 0) {
            $NMINOR = $produk->prd_minorder;
        } else {
            $NMINOR = $produk->prd_isibeli;
        }

        if ($produk->nas == 'Y') {
            $NAS = 'NASIONAL';
        } else {
            $NAS = '';
        }

        if ($produk->omi == 'Y') {
            $OMI = 'OMI';
        } else {
            $OMI = ' ';
        }

        if ($produk->brd == 'Y') {
            $BRD = 'MR BRD';
        } else {
            $BRD = '';
        }

        if ($produk->obi == 'Y') {
            $OBI = 'K.IGR';
        } else {
            $OBI = '';
        }

        if ($produk->igr == 'Y') {
            $IGR = 'IGR';
        } else {
            $IGR = ' ';
        }

        if ($produk->idm == 'Y') {
            $IDM = 'IDM';
        } else {
            $IDM = ' ';
        }
        $flag = [];
        $flag['NAS'] = $NAS;
        $flag['OMI'] = $OMI;
        $flag['BRD'] = $BRD;
        $flag['OBI'] = $OBI;
        $flag['IGR'] = $IGR;
        $flag['IDM'] = $IDM;
        $depo = DB::connection(Session::get('connection'))->table('DEPO_LIST_IDM')->join('TBMASTER_PRODMAST', 'PLUIDM', 'PRD_PLUMCG')
            ->select('*')
            ->where('PRD_PRDCD', '=', $produk->prd_prdcd)
            ->first();
        if (is_null($depo)) {
            $flagdepo = 'Y';
            $depo = 'DEPO';
        } else {
            $flagdepo = 'N';
            $depo = '';
        }

        $produk->katbrg = $KATBRG;
        $produk->hrgpromo = $hrgpromo;
        $produk->tglpromo = $tglpromo;
        $produk->jampromo = $jampromo;

        //satuan jual
        $sj = DB::connection(Session::get('connection'))->table('TBMASTER_PRODMAST')->leftJoin('TBTR_PROMOMD', function ($join) {
            $join->on('PRD_PRDCD', '=', 'PRMD_PRDCD')->On('PRD_KODEIGR', '=', 'PRMD_KODEIGR');
        })->leftJoin('TBMASTER_STOCK', function ($join) {
            $join->On(DB::connection(Session::get('connection'))->raw('SUBSTR (PRD_PRDCD, 1, 6)'), '=', DB::connection(Session::get('connection'))->raw('SUBSTR (ST_PRDCD, 1, 6)'))->On('PRD_KODEIGR', '=', 'ST_KODEIGR')->On('ST_LOKASI', '=', 01);
        })->SelectRaw('PRD_PRDCD,
                                PRD_PPN,
                                PRD_MINJUAL MINJ,
                                PRD_FLAGBKP1 PKP,
                                NVL (PRD_FLAGBKP2, \'xx\') PKP2,
                                PRD_HRGJUAL PRICE_A,
                                PRD_KODETAG PTAG,
                                NVL (PRD_LASTCOST, 0)
                                PRD_LCOST,
                                PRD_UNIT UNIT,
                                PRD_FRAC FRAC,
                                PRD_BARCODE BARC,
                                NVL (PRMD_PRDCD, \'xxx\') PRMD_PRDCD,
                                PRMD_HRGJUAL FMJUAL,
                                PRMD_POTONGANPERSEN FMPOTP,
                                PRMD_POTONGANRPH FMPOTR,
                                PRD_FLAGBARANGORDERTOKO,
                                NVL (ST_AVGCOST, 0) ST_LCOST,
                                NVL(ST_LASTCOST, 0) ST_LASTCOST,
                                MAX (PRMD_TGLAWAL) FMFRTG,
                                MAX (PRMD_TGLAKHIR) FMTOTG,
                                PRMD_JAMAWAL FMFRHR,
                                PRMD_JAMAKHIR FMTOHR ')
            ->whereRaw('SUBSTR (PRD_PRDCD, 1, 6) = SUBSTR (\'' . $plu->prd_prdcd . '\', 1, 6)')
            ->groupBy(DB::connection(Session::get('connection'))->raw('PRD_PRDCD,
                        PRD_PPN,
                        PRD_MINJUAL,
                        PRD_FLAGBKP1,
                        PRD_FLAGBKP2,
                        PRD_HRGJUAL,
                        PRD_BARCODE,
                        PRD_KODETAG,
                        PRD_LASTCOST,
                        PRD_FLAGBARANGORDERTOKO,
                        PRD_UNIT,
                        PRD_FRAC,
                        PRMD_PRDCD,
                        PRMD_HRGJUAL,
                        PRMD_POTONGANPERSEN,
                        PRMD_POTONGANRPH,
                        ST_AVGCOST,
                        ST_LASTCOST,
                        PRMD_JAMAWAL,
                        PRMD_JAMAKHIR'))
            ->orderBy('PRD_PRDCD')
            ->get();

        for ($i = 0; $i < sizeof($sj); $i++) {
            if ($sj[$i]->unit == 'KG') {
                $sj[$i]->frac = 1;
            }
            if ($sj[$i]->prmd_prdcd != 'xxx') {
//                $tglrtg = date('d/m/Y H:i:S', strtotime(substr($sj[$i]->fmfrtg, 0, 10) . self::ceknull($sj[$i]->fmfrhr . "", '00:00:00')));
//                $tglotg = date('d/m/Y H:i:S', strtotime(substr($sj[$i]->fmtotg, 0, 10) . self::ceknull($sj[$i]->fmtohr . "", '23:59:59')));
//                $tglnow = date('d/m/Y H:i:S');
                $tglrtg = $sj[$i]->fmfrtg;
                $tglotg = $sj[$i]->fmtotg;
                $tglnow = Carbon::now();
                if ($tglnow >= $tglrtg and $tglnow <= $tglotg) {
                    $cpromo = true;
                    if ($sj[$i]->pkp == 'Y' and !in_array($sj[$i]->pkp, ['P', 'W', 'G'])) {
                        if ($sj[$i]->fmjual != 0) {
                            $nfmjual = $sj[$i]->fmjual;
                        } else if ($sj[$i]->fmpotp != 0) {
                            $nfmjual = $sj[$i]->price_a - ($sj[$i]->price_a * ($sj[$i]->fmpotp / 100));
                        } else {
                            $nfmjual = $sj[$i]->price_a - $sj[$i]->fmpotr;
                        }

                        if ($sj[$i]->ptag == 'Q') {
                            $marlcost = (1 - (($sj[$i]->st_lastcost * $sj[$i]->frac) / $nfmjual)) * 100;
                            $maracost = (1 - (($sj[$i]->st_lcost * $sj[$i]->frac) / $nfmjual)) * 100;
                        } else {
                            $marlcost = (1 - (isset($sj[$i]->prd_ppn) ? (1 + ($sj[$i]->prd_ppn / 100)) : 1.1) * (($sj[$i]->st_lastcost * $sj[$i]->frac)) / $nfmjual) * 100;
                            $maracost = (1 - (isset($sj[$i]->prd_ppn) ? (1 + ($sj[$i]->prd_ppn / 100)) : 1.1) * (($sj[$i]->st_lcost * $sj[$i]->frac)) / $nfmjual) * 100;

                        }
                    } else {
                        if ($sj[$i]->fmjual != 0) {
                            $nfmjual = $sj[$i]->fmjual;
                        } else if ($sj[$i]->fmpotp != 0) {
                            $nfmjual = $sj[$i]->price_a - ($sj[$i]->price_a * ($sj[$i]->fmpotp / 100));
                        } else {
                            $nfmjual = $sj[$i]->price_a - $sj[$i]->fmpotr;
                        }
                        $marlcost = (1 - ($sj[$i]->st_lastcost * $sj[$i]->frac) / $nfmjual) * 100;
                        $maracost = (1 - ($sj[$i]->st_lcost * $sj[$i]->frac) / $nfmjual) * 100;

                    }
                } else {
                    $cpromo = false;
                    if ($sj[$i]->pkp == 'Y' and !in_array($sj[$i]->pkp, ['P', 'W', 'G'])) {
                        if ($sj[$i]->ptag == 'Q') {
                            $marlcost = (1 - ($sj[$i]->st_lastcost * $sj[$i]->frac) / $sj[$i]->price_a) * 100;
                            $maracost = (1 - ($sj[$i]->st_lcost * $sj[$i]->frac) / $sj[$i]->price_a) * 100;
                        } else {
                            $marlcost = (1 - (isset($sj[$i]->prd_ppn) ? (1 + ($sj[$i]->prd_ppn / 100)) : 1.1) * ($sj[$i]->st_lastcost * $sj[$i]->frac) / $sj[$i]->price_a) * 100;
                            $maracost = (1 - (isset($sj[$i]->prd_ppn) ? (1 + ($sj[$i]->prd_ppn / 100)) : 1.1) * ($sj[$i]->st_lcost * $sj[$i]->frac) / $sj[$i]->price_a) * 100;
                            //rumus ini

                        }
                    } else {
                        $marlcost = (1 - ($sj[$i]->st_lastcost * $sj[$i]->frac) / $sj[$i]->price_a) * 100;
                        $maracost = (1 - ($sj[$i]->st_lcost * $sj[$i]->frac) / $sj[$i]->price_a) * 100;
                    }
                }
            } else {
                $cpromo = false;
                if ($sj[$i]->price_a > 0) {
                    if ($sj[$i]->pkp == 'Y' and !in_array($sj[$i]->pkp, ['P', 'W', 'G'])) {
                        if ($sj[$i]->ptag == 'Q') {
                            $marlcost = (1 - ($sj[$i]->st_lastcost * $sj[$i]->frac) / $sj[$i]->price_a) * 100;
                            $maracost = (1 - ($sj[$i]->st_lcost * $sj[$i]->frac) / $sj[$i]->price_a) * 100;
                        } else {
                            $marlcost = (1 - (isset($sj[$i]->prd_ppn) ? (1 + ($sj[$i]->prd_ppn / 100)) : 1.1) * ($sj[$i]->st_lastcost * $sj[$i]->frac) / $sj[$i]->price_a) * 100;
                            $maracost = (1 - (isset($sj[$i]->prd_ppn) ? (1 + ($sj[$i]->prd_ppn / 100)) : 1.1) * ($sj[$i]->st_lcost * $sj[$i]->frac) / $sj[$i]->price_a) * 100;
                        }
                    } else {
                        $marlcost = (1 - ($sj[$i]->st_lastcost * $sj[$i]->frac) / $sj[$i]->price_a) * 100;
                        $maracost = (1 - ($sj[$i]->st_lcost * $sj[$i]->frac) / $sj[$i]->price_a) * 100;
                    }

                } else {
                    $marlcost = 0;
                    $maracost = 0;
                }
            }
            $sj[$i]->sj_sj = SUBSTR($sj[$i]->prd_prdcd, -1);
            $barcode = DB::connection(Session::get('connection'))->table('tbmaster_barcode')
                ->select('brc_barcode')
                ->where('brc_status', '=', 'BC')
                ->where('brc_prdcd', '=', $sj[$i]->prd_prdcd)
                ->get();
            $sj_barcode = "";
            $sj[$i]->sj_barcode = "";
            if (sizeof($barcode) != 0) {
                for ($j = 0; $j < sizeof($barcode); $j++) {
                    $sj_barcode = $sj_barcode . $barcode[$j]->brc_barcode . '-';
                }
                $sj_barcode = substr($sj_barcode, 0, strlen(trim($sj_barcode)) - 1);
                $sj[$i]->sj_barcode = $sj_barcode;
            }

            $sj[$i]->sj_sat = $sj[$i]->unit . '/' . $sj[$i]->frac;

            if ($cpromo == true) {
                $sj[$i]->sj_hgjual = $nfmjual;
            } else {
                $sj[$i]->sj_hgjual = $sj[$i]->price_a;
            }
            $sj[$i]->sj_lcost = $sj[$i]->st_lastcost * $sj[$i]->frac;
            $sj[$i]->sj_acost = $sj[$i]->st_lcost * $sj[$i]->frac;
            $sj[$i]->sj_mgna = $maracost;
            $sj[$i]->sj_mgnl = $marlcost;
            $sj[$i]->sj_minj = $sj[$i]->minj;
            $sj[$i]->sj_tag = $sj[$i]->ptag;
            $sj[$i]->sj_bkp = $sj[$i]->pkp;
            $sj[$i]->sj_bkl = $sj[$i]->prd_flagbarangordertoko;
        }

        //trendsales
        $trendsales = DB::connection(Session::get('connection'))->table('TBTR_SALESBULANAN')
            ->select('*')
            ->where('sls_prdcd', '=', $plu->prd_prdcd)
            ->first();
        $trendsales = (array)$trendsales;

        $blnberjalan = DB::connection(Session::get('connection'))->table('TBMASTER_PERUSAHAAN')
            ->select('PRS_BULANBERJALAN')
            ->first();

        $VAVG = 0;
        $N = 0;
        $X = 0;
        $X1 = 0;

        $FMPBLNA = (int)$blnberjalan->prs_bulanberjalan;

        if (sizeof($trendsales) > 0) {
            if ($FMPBLNA - 1 < 1) {
                $N = 12;
                $VAVG = $VAVG + (int)$trendsales['sls_qty_12'];
            } else {
                $N = $FMPBLNA - 1;
                if ($N < 10) {
                    $N = '0' . $N;
                }
                $VAVG = $VAVG + (int)$trendsales['sls_qty_' . $N];
            }

            if ($N - 1 < 1) {
                $X = 12;
                $VAVG = $VAVG + (int)$trendsales['sls_qty_12'];
            } else {
                $X = $N - 1;
                if ($X < 10) {
                    $X = '0' . $X;
                }
                $VAVG = $VAVG + (int)$trendsales['sls_qty_' . $X];
            }

            if ($X - 1 < 1) {
                $X1 = 12;
                $VAVG = $VAVG + (int)$trendsales['sls_qty_12'];
            } else {
                $X1 = $X - 1;
                if ($X1 < 10) {
                    $X1 = '0' . $X1;
                }
                $VAVG = $VAVG + (int)$trendsales['sls_qty_' . $X1];
            }
        }
        $TEMP = date('m');
        $VUNIT = '';
        $VSALES = '';
        $VLASTCOST = '';
        $VFRAC = '';
        $prodstock = DB::connection(Session::get('connection'))->table('tbmaster_prodmast')->join('tbmaster_stock', 'prd_kodeigr', '=', 'st_kodeigr')
            ->select('*')
            ->where('prd_prdcd', '=', $plu->prd_prdcd)
            ->where('prd_kodeigr', '=', Session::get('kdigr'))
            ->whereRaw('substr (tbmaster_stock.st_prdcd, 1, 6) = substr (tbmaster_prodmast.prd_prdcd, 1, 6)')
            ->where('st_lokasi', '=', "01")
            ->first();
        if ($prodstock) {
            if ($prodstock->st_lokasi == '01') {
                $prodstock->st = 'BK';
            } else if ($prodstock->st_lokasi == '02') {
                $prodstock->st = 'RT';
            } else {
                $prodstock->st = 'RS';
            }

            $VUNIT = $prodstock->prd_unit;
            $VSALES = $prodstock->st_sales;
            $VLASTCOST = $prodstock->st_avgcost;
            $VFRAC = 0;


            if ($VUNIT == 'KG') {
                $VFRAC = 1000;
            } else {
                $VFRAC = 1;
            }


            $trendsales['sls_qty_' . $TEMP] = $VSALES / $VFRAC;
            $trendsales['sls_rph_' . $TEMP] = $VLASTCOST * ($VSALES / $VFRAC);
        }
        if (!isset($VAVG) or $VAVG == 0 or is_null($VAVG)) {
            $VAVG = 0;
        }
        $AVGSALES = $VAVG / 3;

        $gdltemp = DB::connection(Session::get('connection'))->table('tbtr_gondola')
            ->select('*')
            ->whereRaw('substr(gdl_prdcd,1 ,6) = substr(\'' . $plu->prd_prdcd . '\', 1, 6)')
            ->whereRaw('gdl_tglawal <= trunc(sysdate)')
            ->whereRaw('trunc(sysdate) <= gdl_tglakhir')
            ->get();

        $gdl = 0;
        for ($i = 0; $i < sizeof($gdltemp); $i++) {
            $gdl = $gdltemp[$i]->gdl_qty;
            $prd_gdl = date('d/m/y', strtotime(substr($gdltemp[$i]->gdl_tglawal, 0, 10))) . ' s/d ' . date('d/m/y', strtotime(substr($gdltemp[$i]->gdl_tglakhir, 0, 10)));
            break;
        }

        //stok
        $stock = DB::connection(Session::get('connection'))->table('tbmaster_prodmast')->join('tbmaster_stock', 'prd_kodeigr', '=', 'st_kodeigr')
            ->select('*')
            ->where('prd_prdcd', '=', $plu->prd_prdcd)
            ->where('prd_kodeigr', '=', Session::get('kdigr'))
            ->whereRaw('substr (tbmaster_stock.st_prdcd, 1, 6) = substr (tbmaster_prodmast.prd_prdcd, 1, 6)')
            ->orderBy('st_lokasi')
            ->get();
        for ($i = 0; $i < sizeof($stock); $i++) {
            if ($stock[$i]->st_lokasi == '01') {
                $st = 'BK';
            } else if ($stock[$i]->st_lokasi == '02') {
                $st = 'RT';
            } else {
                $st = 'RS';
            }
            $st_awal = self::ceknull($stock[$i]->st_saldoawal, 0);
            $st_terima = self::ceknull($stock[$i]->st_trfin, 0);
            $st_keluar = self::ceknull($stock[$i]->st_trfout, 0);
            $st_sales = self::ceknull($stock[$i]->st_sales, 0);
            $st_retur = self::ceknull($stock[$i]->st_retur, 0);
            $st_adj = self::ceknull($stock[$i]->st_adj, 0);
            $st_so = self::ceknull($stock[$i]->st_so, 0);
            $st_instrst = self::ceknull($stock[$i]->st_intransit, 0);
            $st_selisih_so = self::ceknull($stock[$i]->st_selisih_so, 0);
            $st_akhir = self::ceknull($stock[$i]->st_saldoakhir, 0);

            $lso = true;
            $lsoic = true;


            $temp = DB::connection(Session::get('connection'))->table('TBMASTER_SETTING_SO')
                ->select('*')
                ->whereRaw('to_char(MSO_TGLSO, \'yyyy-MM\') =  to_char(sysdate,\'yyyy-MM\')')
                ->count('*');

            if (self::ceknull($temp, 0) != 0) {
                $freset = DB::connection(Session::get('connection'))->table('TBMASTER_SETTING_SO')
                    ->selectRaw('NVL(MSO_FLAGRESET, \'N\')')
                    ->whereRaw('to_char(MSO_TGLSO, \'yyyy-MM\') =  to_char(sysdate,\'yyyy-MM\')')
                    ->first();

                if ($freset != 'Y') {
                    $st_selisih_so = 0;
                    $st_akhir = self::ceknull($stock[$i]->st_saldoakhir, 0) - self::ceknull($stock[$i]->st_selisih_so, 0);
                }
            }

            if ($stock[$i]->st_lokasi == '01') {
                $qty_soic = DB::connection(Session::get('connection'))->table('tbtr_reset_soic')
                    ->selectRaw('sum(nvl(rso_qtyreset,0)) qty')
                    ->whereRaw('substr(rso_prdcd,1 ,6) = substr(\'' . $plu->prd_prdcd . '\', 1, 6)')
                    ->whereRaw('to_char(rso_tglso, \'yyyyMM\') = to_char(sysdate, \'yyyyMM\')')
                    ->where('rso_lokasi', '=', '01')
                    ->first();

                $st_selisih_so = $st_selisih_so + self::ceknull($qty_soic->qty, 0);
                $st_akhir = self::ceknull($stock[$i]->st_saldoakhir, 0) - self::ceknull($stock[$i]->st_selisih_soic, 0) + self::ceknull($qty_soic->qty, 0);

                if ($stock[$i]->st_sales > 0) {
                    $dsi = ((($stock[$i]->st_saldoawal + $stock[$i]->st_saldoakhir) / 2) / $stock[$i]->st_sales) * ((int)date('d'));
                    $to = ($stock[$i]->st_saldoakhir / $stock[$i]->st_sales) * ((int)date('d'));
                } else {
                    $dsi = 0;
                    $to = 0;
                }
            }
            if ($stock[$i]->st_saldoakhir <= 0) {
                if (in_array($stock[$i]->prd_kodetag, ['N', 'H'])) {
                    if ($stock[$i]->st_saldoakhir == 0 and $stock[$i]->prd_kodetag == 'H') {
                        array_push($message, 'STOCK BARANG ' . $stock[$i]->st_lokasi . ' NOL   (TAG H-> HABISKAN TOKO)');
                    } else {
                        array_push($message, 'STOCK BARANG ' . $stock[$i]->st_lokasi . ' MINUS (TAG H-> HABISKAN TOKO)');
                    }

                    if ($stock[$i]->st_saldoakhir == 0 and $stock[$i]->prd_kodetag == 'N') {
                        array_push($message, 'STOCK BARANG ' . $stock[$i]->st_lokasi . ' NOL   (TAG N-> DISCONTINUE)');
                    } else {
                        array_push($message, 'STOCK BARANG ' . $stock[$i]->st_lokasi . ' MINUS (TAG N-> DISCONTINUE)');
                    }
                    array_push($message, 'Buatkan MEMO BARANG ' . trim($stock[$i]->st_lokasi) . ' Perubahan Tag -> Tag X,;Informasikan ke Merchandising & EDP;Apakah ANDA sudah mencatatnya?');
                }

            }

            if ($stock[$i]->st_saldoakhir != 0 and $stock[$i]->prd_kodetag == 'X') {
                array_push($message, 'STOCK BARANG ' . trim($stock[$i]->st_lokasi) . ' TAG X HARUS 0 (NOL),;Cari PLU pengganti (bila ada ->MPP);Apakah ANDA sudah mencatatnya?');
            }
            if (self::ceknull($stock[$i]->st_saldoawal, 0) + self::ceknull($stock[$i]->st_trfin, 0) - self::ceknull($stock[$i]->st_trfout, 0) - self::ceknull($stock[$i]->st_sales, 0) + 0 + self::ceknull($stock[$i]->st_retur, 0) + self::ceknull($stock[$i]->st_intransit, 0) + self::ceknull($stock[$i]->st_adj, 0) != $stock[$i]->st_saldoakhir) {
                $deskripsi = 'PERHITUNGAN STOCK BARANG ' . trim($st) . ' SALAH,;Lakukan proses HITUNG ULANG STOCK;Apakah ANDA sudah mencatatnya?';
            }
            $stock[$i]->st = self::ceknull($st, 0);
            $stock[$i]->st_awal = self::ceknull($st_awal, 0);
            $stock[$i]->st_terima = self::ceknull($st_terima, 0);
            $stock[$i]->st_keluar = self::ceknull($st_keluar, 0);
            $stock[$i]->st_sales = self::ceknull($st_sales, 0);
            $stock[$i]->st_retur = self::ceknull($st_retur, 0);
            $stock[$i]->st_adj = self::ceknull($st_adj, 0);
            $stock[$i]->st_so = self::ceknull($st_so, 0);
            $stock[$i]->st_instrst = self::ceknull($st_instrst, 0);
            $stock[$i]->st_selisih_so = self::ceknull($st_selisih_so, 0);
            $stock[$i]->st_akhir = self::ceknull($st_akhir, 0);
        }

        $pkmt = DB::connection(Session::get('connection'))->table('tbmaster_hargabeli')
            ->join('tbmaster_supplier', 'hgb_kodesupplier', '=', 'sup_kodesupplier')
            ->join('tbmaster_prodmast', 'hgb_prdcd', '=', 'prd_prdcd')
            ->selectRaw('hgb_top, hgb_hrgbeli, sup_kodesupplier||\' - \'||sup_namasupplier sup,sup_top, prd_isibeli')
            ->whereRaw('substr(hgb_prdcd,1 ,6) = substr(\'' . $plu->prd_prdcd . '\', 1, 6)')
            ->where('hgb_tipe', '=', '2')
            ->first();

        if ($VUNIT == 'KG') {
            $pkmt->hgb_hrgbeli = $pkmt->hgb_hrgbeli * $VFRAC;
        } else {
            $pkmt->hgb_hrgbeli = $pkmt->hgb_hrgbeli * $pkmt->prd_isibeli;
        }

        $pkmt->dsi = round($dsi);
        $pkmt->to = round($to);

        if ($pkmt->hgb_top > 0) {
            $pkmt->top = $pkmt->hgb_top;
        } else {
            $pkmt->top = $pkmt->sup_top;
        }

        $kkpkm = DB::connection(Session::get('connection'))->table('tbmaster_kkpkm')
            ->leftJoin('tbmaster_pkmplus', 'pkmp_prdcd', '=', 'pkm_prdcd')
            ->leftJoin('tbmaster_minimumorder', 'min_prdcd', '=', 'pkm_prdcd')
            ->selectRaw('nvl(pkm_pkmt,0) vpkmt, nvl(pkm_mindisplay,0) vmindisplay, nvl(pkmp_qtyminor,0) vqtyminor, min_minorder vminor')
            ->where('pkm_prdcd', '=', $plu->prd_prdcd)
            ->first();

        $min_qty = $NMINOR;
        $pkm_qty = 0;
        $md_qty = 0;
        $pkm_to = 0;
        $min_to = 0;
        $md_to = 0;
        $mplus = 0;
        $minory = 0;
        if (isset($kkpkm)) {
            $pkm_qty = $kkpkm->vpkmt;
            $mplus = $kkpkm->vqtyminor;
            $minory = $kkpkm->vminor;
            $md_qty = $kkpkm->vmindisplay;
        }
        if (self::ceknull($AVGSALES, 0) > 0) {
            if (isset($kkpkm)) $pkm_to = ($kkpkm->vpkmt / self::ceknull($AVGSALES, 0)) * 30;
            $min_to = ($NMINOR / self::ceknull($AVGSALES, 0)) * 30;
            if (isset($kkpkm)) $md_to = ($kkpkm->vmindisplay / self::ceknull($AVGSALES, 0)) * 30;
        } else {
            if (isset($kkpkm)) $pkm_to = ($kkpkm->vpkmt / 1) * 30;
            $min_to = ($NMINOR / 1) * 30;
            if (isset($kkpkm)) $md_to = ($kkpkm->vmindisplay / 1) * 30;
        }


        $pkmt->pkm_qty = round($pkm_qty);
        $pkmt->min_qty = round($min_qty);
        $pkmt->md_qty = round($md_qty);
        $pkmt->pkm_to = round($pkm_to);
        $pkmt->min_to = round($min_to);
        $pkmt->md_to = round($md_to);
        $pkmt->mplus = round($mplus);
        $pkmt->minory = round($minory);

        return compact(['produk', 'sj', 'trendsales', 'prodstock', 'AVGSALES', 'FMPBLNA', 'stock', 'pkmt', 'ITEM', 'flag', 'gdl', 'showpromo', 'message']);
    }

    public function ceknull($value, $ret)
    {
        if ($value == "" or $value == null or $value == "null") {
            return $ret;
        }
        return $value;
    }

    public function cetakSo(Request $request)
    {
        $so = $request->cetakso['so'];
        $adjustso = $request->cetakso['adjustso'];
        $resetsoic = $request->cetakso['resetsoic'];

        $prs = DB::connection(Session::get('connection'))->table('TBMASTER_PERUSAHAAN')
            ->select('*')
            ->where('PRS_KODEIGR', '=', Session::get('kdigr'))
            ->first();

        $content = "";

        $content .= $prs->prs_namaperusahaan . "\t\t\t\t\t TANGGAL : " . substr(Carbon::now(), 0, 10) . "\t\tJAM : " . substr(Carbon::now(), 11, 19) . chr(13) . chr(10);
        $content .= $prs->prs_namacabang . chr(13) . chr(10) . chr(13) . chr(10);
        $content .= str_pad("STOCK OPNAME", 57, " ", STR_PAD_LEFT) . chr(13) . chr(10);
        $content .= "PLU    : " . $request->cetakso['plu'] . "   " . "Barcode : " . $request->cetakso['barcode'] . chr(13) . chr(10);
        $content .= '         ' . $request->cetakso['produk'] . chr(13) . chr(10);
        $content .= 'Periode SO : ' . date('d-M-y', strtotime($request->cetakso['sotgl'])) . chr(13) . chr(10);
        $content .= str_pad("=", 100, "=", STR_PAD_LEFT) . chr(13) . chr(10) . chr(13) . chr(10);

        $content .= '        Qty LPP         Qty SO        Selisih   Average Cost     -/+ Rupiah' . chr(13) . chr(10);

        for ($i = 0; $i < sizeof($so); $i++) {
            $content .= str_pad(number_format($so[$i]['sop_qtylpp']), 15, " ", STR_PAD_LEFT)
                . str_pad(number_format($so[$i]['sop_qtyso']), 15, " ", STR_PAD_LEFT)
                . str_pad($so[$i]['selisih'], 15, " ", STR_PAD_LEFT)
                . str_pad(number_format($so[$i]['sop_newavgcost'], 2, ".", ","), 15, " ", STR_PAD_LEFT)
                . str_pad(number_format($so[$i]['rupiah'], 2, ".", ","), 15, " ", STR_PAD_LEFT)
                . chr(13) . chr(10);
        }

        $content .= chr(13) . chr(10);
        $content .= chr(13) . chr(10);
        $content .= str_pad("ADJUSTMENT SO", 57, " ", STR_PAD_LEFT) . chr(13) . chr(10);
        $content .= '       Sequence        Qty ADJ        Keterangan                    Tgl Create     ' . chr(13) . chr(10);

        for ($i = 0; $i < sizeof($adjustso); $i++) {
            $content .= str_pad($adjustso[$i]['adj_seq'], 15, " ", STR_PAD_LEFT)
                . str_pad(number_format($adjustso[$i]['adj_qty']), 15, " ", STR_PAD_LEFT)
                . str_pad($adjustso[$i]['adj_keterangan'], 15, " ", STR_PAD_LEFT)
                . str_pad(date('d-M-y', strtotime($adjustso[$i]['adj_create_dt'])), 15, " ", STR_PAD_LEFT)
                . chr(13) . chr(10);
        }


        $fileName = "logs.txt";

        $headers = [
            'Content-type' => 'text/plain',
            'Content-Disposition' => sprintf('attachment; filename="%s"', $fileName),
            'Content-Length' => strlen($content)
        ];

        return Response::make($content, 200, $headers);

    }

    public function cetak(Request $request)
    {
//        dd($request->cetak['produk']['brc_barcode']);

        $prs = DB::connection(Session::get('connection'))->table('TBMASTER_PERUSAHAAN')
            ->select('*')
            ->where('PRS_KODEIGR', '=', Session::get('kdigr'))
            ->first();

        $content = "";

        $content .= $prs->prs_namaperusahaan . "\t\t\t\t\t TANGGAL : " . substr(Carbon::now(), 0, 10) . "\t\tJAM : " . substr(Carbon::now(), 11, 19) . chr(13) . chr(10);
        $content .= $prs->prs_namacabang . chr(13) . chr(10) . chr(13) . chr(10);
        $content .= str_pad("INFORMASI & HISTORY PRODUK", 57, " ", STR_PAD_LEFT) . chr(13) . chr(10);
        $content .= str_pad("=", 112, "=", STR_PAD_LEFT) . chr(13) . chr(10) . chr(13) . chr(10);
        $content .= "PLU    : " . $request->cetak['produk']['prd_prdcd'] . "   " . "Barcode : " . $request->cetak['produk']['brc_barcode'] . ' ' . $request->cetak['ITEM'] . ' ' . 'Flag Gudang : ' . $request->cetak['produk']['prd_flaggudang'] . ' ' . 'Kd.Cabang : ' . $prs->prs_namacabang . chr(13) . chr(10);
        $content .= 'Produk : ' . $request->cetak['produk']['prd_deskripsipanjang'] . ' ' . 'Kat.Toko : ' . $request->cetak['produk']['prd_kategoritoko'] . chr(13) . chr(10);
        $content .= 'Kat.Brg: ' . $request->cetak['produk']['katbrg'] . ' ' . 'Upd : ' . Date('d-M-y', strtotime($request->cetak['produk']['prd_create_dt'])) . chr(13) . chr(10) . chr(13) . chr(10);

        $content .= 'SJ Satuan/Frac       Hrg.Jual     LastCost      AvgCost  MGN-L  MGN-A  Tag  MinJ BKP' . chr(13) . chr(10);

        for ($i = 0; $i < sizeof($request->cetak['sj']); $i++) {
            $content .= str_pad($request->cetak['sj'][$i]['sj_sj'], 2, " ", STR_PAD_LEFT) . '   ' . str_pad($request->cetak['sj'][$i]['sj_sat'], 11, ' ') . ' ' . str_pad(number_format($request->cetak['sj'][$i]['sj_hgjual'], 1), 12, ' ', STR_PAD_LEFT) . ' ' .
                str_pad(number_format($request->cetak['sj'][$i]['sj_lcost'], 1), 12, ' ', STR_PAD_LEFT) . ' ' . str_pad(number_format($request->cetak['sj'][$i]['sj_acost'], 1), 12, ' ', STR_PAD_LEFT) . ' ' .
                str_pad(number_format($request->cetak['sj'][$i]['sj_mgnl'], 2), 6, ' ', STR_PAD_LEFT) . ' ' . str_pad(number_format($request->cetak['sj'][$i]['sj_mgna'], 2), 6, ' ', STR_PAD_LEFT) . '   ' . $request->cetak['sj'][$i]['sj_tag'] . ' ' . str_pad($request->cetak['sj'][$i]['sj_minj'], 5, ' ', STR_PAD_LEFT) . '   ' .
                $request->cetak['sj'][$i]['sj_bkp'] .
                chr(13) . chr(10);
        }

        $content .= chr(13) . chr(10);
        chr(13) . chr(10);
        $content .= '======== TREND SALES ========  ===================================== S T O K ====================================' . chr(13) . chr(10);
        chr(13) . chr(10);
        $content .= '        QTY            RUPIAH  LOK     AWAL    TERIMA    KELUAR     SALES     RETUR       ADJ  INTRNSIT     AKHIR' . chr(13) . chr(10);

        $month = ['JAN', 'FEB', 'MAR', 'APR', 'MEI', 'JUN', 'JUL', 'AGU', 'SEP', 'OKT', 'NOV', 'DES'];
        $jmldatastock = sizeof($request->cetak['stock']);
        for ($i = 0; $i < 12; $i++) {
            $j = $i + 1;
            if ($j < 10) {
                $j = '0' . $j;
            }
            if ($i >= $jmldatastock) {
                $content .= $month[$i] . str_pad(number_format($request->cetak['trendsales']['sls_qty_' . $j]), 9, ' ', STR_PAD_LEFT) . str_pad(number_format($request->cetak['trendsales']['sls_rph_' . $j]), 17, ' ', STR_PAD_LEFT) . ' '
                    . chr(13) . chr(10);
            } else {
//                dd($request->cetak['stock'][$i]);
                $content .= $month[$i] . str_pad(number_format($request->cetak['trendsales']['sls_qty_' . $j]), 9, ' ', STR_PAD_LEFT) . str_pad(number_format($request->cetak['trendsales']['sls_rph_' . $j], 2), 17, ' ', STR_PAD_LEFT) . ' ' .
                    str_pad(($request->cetak['stock'][$i]['st']), 3, ' ', STR_PAD_LEFT) . ' ' .
                    str_pad(number_format($request->cetak['stock'][$i]['st_awal']), 9, ' ', STR_PAD_LEFT) . ' ' .
                    str_pad(number_format($request->cetak['stock'][$i]['st_terima']), 9, ' ', STR_PAD_LEFT) . ' ' .
                    str_pad(number_format($request->cetak['stock'][$i]['st_keluar']), 9, ' ', STR_PAD_LEFT) . ' ' .
                    str_pad(number_format($request->cetak['stock'][$i]['st_sales']), 9, ' ', STR_PAD_LEFT) . ' ' .
                    str_pad(number_format($request->cetak['stock'][$i]['st_retur']), 9, ' ', STR_PAD_LEFT) . ' ' .
                    str_pad(number_format($request->cetak['stock'][$i]['st_adj']), 9, ' ', STR_PAD_LEFT) . ' ' .
                    str_pad(number_format($request->cetak['stock'][$i]['st_instrst']), 9, ' ', STR_PAD_LEFT) . ' ' .
                    str_pad(number_format($request->cetak['stock'][$i]['st_akhir']), 9, ' ', STR_PAD_LEFT) . ' ' .
                    chr(13) . chr(10);
            }
        }
        $content .= chr(13) . chr(10);
        $content .= '                        ===== PKMT =====  ==== MINOR === = MIN DISPLAY =' . chr(13) . chr(10);
        $content .= '     DSI      TO     TOP     QTY      TO     QTY      TO     QTY      TO' . chr(13) . chr(10);
        $content .= str_pad(number_format($request->cetak['pkmt']['dsi']), 8, ' ', STR_PAD_LEFT);
        $content .= str_pad(number_format($request->cetak['pkmt']['to']), 8, ' ', STR_PAD_LEFT);
        $content .= str_pad(number_format($request->cetak['pkmt']['top']), 8, ' ', STR_PAD_LEFT);
        $content .= str_pad(number_format($request->cetak['pkmt']['pkm_qty']), 8, ' ', STR_PAD_LEFT);
        $content .= str_pad(number_format($request->cetak['pkmt']['pkm_to']), 8, ' ', STR_PAD_LEFT);
        $content .= str_pad(number_format($request->cetak['pkmt']['min_qty']), 8, ' ', STR_PAD_LEFT);
        $content .= str_pad(number_format($request->cetak['pkmt']['min_to']), 8, ' ', STR_PAD_LEFT);
        $content .= str_pad(number_format($request->cetak['pkmt']['md_qty']), 8, ' ', STR_PAD_LEFT);
        $content .= str_pad(number_format($request->cetak['pkmt']['md_to']), 8, ' ', STR_PAD_LEFT);
        $content .= chr(13) . chr(10);

//        ----->>>>> Cetak Informasi Lainnya
        $content .= chr(13) . chr(10);
        $content .= 'MPLUS             : ' . str_pad(number_format($request->cetak['pkmt']['mplus'], 1), 8, ' ', STR_PAD_LEFT) . ' (PKMT Sudah Termasuk M+   Minor Y : ' . str_pad(number_format($request->cetak['pkmt']['minory']), 8, ' ', STR_PAD_LEFT) . chr(13) . chr(10);
        $content .= 'Supplier Terakhir : ' . str_pad($request->cetak['pkmt']['sup'], 8, ' ', STR_PAD_LEFT) . chr(13) . chr(10);
        $content .= 'Harga Beli        : ' . str_pad(number_format($request->cetak['pkmt']['hgb_hrgbeli'], 1), 8, ' ', STR_PAD_LEFT) . chr(13) . chr(10);
        $content .= 'Average Sales     : ' . str_pad(number_format($request->cetak['AVGSALES'], 1), 8, ' ', STR_PAD_LEFT) . chr(13) . chr(10);
        $content .= 'N+ Gondola        : ' . str_pad(number_format($request->cetak['gdl'], 1), 8, ' ', STR_PAD_LEFT) . chr(13) . chr(10);


        $fileName = "logs.txt";

        $headers = [
            'Content-type' => 'text/plain',
            'Content-Disposition' => sprintf('attachment; filename="%s"', $fileName),
            'Content-Length' => strlen($content)
        ];

        return Response::make($content, 200, $headers);

    }

    public function getNextPLU(Request $request)
    {
        $currentPLU = $request->plu;
        $max_plu = DB::connection(Session::get('connection'))->table('tbmaster_prodmast')
            ->count();

        $currentRow = DB::connection(Session::get('connection'))->select("SELECT COL
                                  FROM (SELECT ROWNUM COL, PRD_PRDCD PLU
                                          FROM (SELECT   PRD_PRDCD
                                                    FROM TBMASTER_PRODMAST
                                                    WHERE PRD_PRDCD LIKE '%0'
                                                ORDER BY PRD_DESKRIPSIPANJANG, PRD_PRDCD))
                                 WHERE PLU = substr('" . $currentPLU . "',1,6) || '0'")[0]->col;
        $nextRow = intval($currentRow) + 1;
        if ($nextRow != $max_plu) {
            $nextPLU = DB::connection(Session::get('connection'))->select("SELECT plu
            FROM (SELECT ROWNUM COL, PRD_PRDCD PLU
              FROM (SELECT   PRD_PRDCD
                        FROM TBMASTER_PRODMAST
                    WHERE PRD_PRDCD LIKE '%0'
                    ORDER BY PRD_DESKRIPSIPANJANG, PRD_PRDCD))
                    WHERE col= " . $nextRow)[0]->plu;
            return $nextPLU;
        } else {
            return $currentPLU;
        }
    }

    public function getPrevPLU(Request $request)
    {
        $currentPLU = $request->plu;

        $currentRow = DB::connection(Session::get('connection'))->select("SELECT COL
                                  FROM (SELECT ROWNUM COL, PRD_PRDCD PLU
                                          FROM (SELECT   PRD_PRDCD
                                                    FROM TBMASTER_PRODMAST
                                                    WHERE PRD_PRDCD LIKE '%0'
                                                ORDER BY PRD_DESKRIPSIPANJANG, PRD_PRDCD))
                                 WHERE PLU = substr('" . $currentPLU . "',1,6) || '0'")[0]->col;
        $nextRow = intval($currentRow) - 1;
        if (intval($currentRow) - 1 != 1) {

            $nextPLU = DB::connection(Session::get('connection'))->select("SELECT plu
      FROM (SELECT ROWNUM COL, PRD_PRDCD PLU
              FROM (SELECT   PRD_PRDCD
                        FROM TBMASTER_PRODMAST
                    WHERE PRD_PRDCD LIKE '%0'
                    ORDER BY PRD_DESKRIPSIPANJANG, PRD_PRDCD))
                    WHERE col= " . $nextRow)[0]->plu;
            return $nextPLU;
        } else {
            return $currentPLU;
        }

    }

    public function getDetailSales(Request $request)

    {
        $blnberjalan = DB::connection(Session::get('connection'))->table('TBMASTER_PERUSAHAAN')
            ->select('PRS_BULANBERJALAN')
            ->first();

        $FMPBLNA = (int)$blnberjalan->prs_bulanberjalan;

        $ds01 = DB::connection(Session::get('connection'))->table('tbtr_rekapsalesbulanan')
            ->selectRaw('nvl(rsl_qty_01, 0) qty_igr1, nvl(rsl_qty_02, 0) qty_igr2, nvl(rsl_qty_03, 0) qty_igr3 ,nvl(rsl_qty_04, 0) qty_igr4, nvl(rsl_qty_05, 0) qty_igr5, nvl(rsl_qty_06, 0) qty_igr6, nvl(rsl_qty_07, 0) qty_igr7, nvl(rsl_qty_08, 0) qty_igr8,nvl(rsl_qty_09, 0) qty_igr9,nvl(rsl_qty_10, 0) qty_igr10,nvl(rsl_qty_11, 0) qty_igr11,nvl(rsl_qty_12, 0) qty_igr12, nvl(rsl_rph_01, 0) rph_igr1, nvl(rsl_rph_02, 0) rph_igr2, nvl(rsl_rph_03, 0) rph_igr3, nvl(rsl_rph_04, 0) rph_igr4, nvl(rsl_rph_05, 0) rph_igr5, nvl(rsl_rph_06, 0) rph_igr6, nvl(rsl_rph_07, 0) rph_igr7, nvl(rsl_rph_08, 0) rph_igr8, nvl(rsl_rph_09, 0) rph_igr9, nvl(rsl_rph_10, 0) rph_igr10, nvl(rsl_rph_11, 0) rph_igr11, nvl(rsl_rph_12, 0) rph_igr12')
            ->whereRaw('substr(rsl_prdcd,1 ,6) = substr(\'' . $request->value . '\', 1, 6)')
            ->where('rsl_group', '=', '01')
            ->first();

        $ds02 = DB::connection(Session::get('connection'))->table('tbtr_rekapsalesbulanan')
            ->selectRaw('nvl(rsl_qty_01, 0) qty_omi1, nvl(rsl_qty_02, 0) qty_omi2, nvl(rsl_qty_03, 0) qty_omi3 ,nvl(rsl_qty_04, 0) qty_omi4, nvl(rsl_qty_05, 0) qty_omi5, nvl(rsl_qty_06, 0) qty_omi6,nvl(rsl_qty_07, 0) qty_omi7, nvl(rsl_qty_08, 0) qty_omi8,nvl(rsl_qty_09 , 0)qty_omi9,nvl(rsl_qty_10, 0) qty_omi10,nvl(rsl_qty_11, 0) qty_omi11,nvl(rsl_qty_12, 0) qty_omi12,nvl(rsl_rph_01, 0) rph_omi1, nvl(rsl_rph_02, 0) rph_omi2, nvl(rsl_rph_03, 0) rph_omi3, nvl(rsl_rph_04, 0) rph_omi4, nvl(rsl_rph_05, 0) rph_omi5, nvl(rsl_rph_06, 0) rph_omi6,nvl(rsl_rph_07, 0) rph_omi7, nvl(rsl_rph_08, 0) rph_omi8, nvl(rsl_rph_09, 0) rph_omi9, nvl(rsl_rph_10 , 0)rph_omi10, nvl(rsl_rph_11, 0) rph_omi11, nvl(rsl_rph_12, 0) rph_omi12')
            ->whereRaw('substr(rsl_prdcd,1 ,6) = substr(\'' . $request->value . '\', 1, 6)')
            ->where('rsl_group', '=', '02')
            ->first();

        $ds03 = DB::connection(Session::get('connection'))->table('tbtr_rekapsalesbulanan')
            ->selectRaw('nvl(rsl_qty_01, 0) qty_mrh1, nvl(rsl_qty_02, 0) qty_mrh2, nvl(rsl_qty_03, 0) qty_mrh3 ,nvl(rsl_qty_04, 0) qty_mrh4, nvl(rsl_qty_05, 0) qty_mrh5, nvl(rsl_qty_06, 0) qty_mrh6,nvl(rsl_qty_07, 0) qty_mrh7, nvl(rsl_qty_08, 0) qty_mrh8,nvl(rsl_qty_09, 0) qty_mrh9,nvl(rsl_qty_10, 0) qty_mrh10,nvl(rsl_qty_11, 0) qty_mrh11,nvl(rsl_qty_12, 0) qty_mrh12,nvl(rsl_rph_01, 0) rph_mrh1, nvl(rsl_rph_02, 0) rph_mrh2, nvl(rsl_rph_03, 0) rph_mrh3, nvl(rsl_rph_04, 0) rph_mrh4, nvl(rsl_rph_05, 0) rph_mrh5, nvl(rsl_rph_06, 0) rph_mrh6,nvl(rsl_rph_07, 0) rph_mrh7, nvl(rsl_rph_08, 0) rph_mrh8, nvl(rsl_rph_09 , 0)rph_mrh9, nvl(rsl_rph_10, 0) rph_mrh10, nvl(rsl_rph_11, 0) rph_mrh11, nvl(rsl_rph_12, 0) rph_mrh12')
            ->whereRaw('substr(rsl_prdcd,1 ,6) = substr(\'' . $request->value . '\', 1, 6)')
            ->where('rsl_group', '=', '03')
            ->first();

        $ds04 = DB::connection(Session::get('connection'))->table('tbtr_rekapsalesbulanan')
            ->selectRaw('nvl(rsl_qty_01, 0) qty_omi1, nvl(rsl_qty_02, 0) qty_omi2, nvl(rsl_qty_03, 0) qty_omi3 ,nvl(rsl_qty_04, 0) qty_omi4, nvl(rsl_qty_05, 0) qty_omi5, nvl(rsl_qty_06, 0) qty_omi6,nvl(rsl_qty_07, 0) qty_omi7, nvl(rsl_qty_08, 0) qty_omi8,nvl(rsl_qty_09, 0) qty_omi9,nvl(rsl_qty_10, 0) qty_omi10,nvl(rsl_qty_11, 0) qty_omi11,nvl(rsl_qty_12, 0) qty_omi12,nvl(rsl_rph_01, 0) rph_omi1, nvl(rsl_rph_02, 0) rph_omi2, nvl(rsl_rph_03, 0) rph_omi3, nvl(rsl_rph_04, 0) rph_omi4, nvl(rsl_rph_05, 0) rph_omi5, nvl(rsl_rph_06, 0) rph_omi6,nvl(rsl_rph_07, 0) rph_omi7, nvl(rsl_rph_08, 0) rph_omi8, nvl(rsl_rph_09, 0) rph_omi9, nvl(rsl_rph_10, 0) rph_omi10, nvl(rsl_rph_11, 0) rph_omi11, nvl(rsl_rph_12, 0) rph_omi12')
            ->whereRaw('substr(rsl_prdcd,1 ,6) = substr(\'' . $request->value . '\', 1, 6)')
            ->where('rsl_group', '=', '04')
            ->first();

        $ds01 = (array)$ds01;
        $ds02 = (array)$ds02;
        $ds03 = (array)$ds03;
        $ds04 = (array)$ds04;
        $avgigr = 0;
        $avgomi = 0;
        $avgmrh = 0;
        $avgidm = 0;
        if (sizeof($ds01) > 0) {

            $N = 0;
            $X = 0;
            $X1 = 0;
            if ($FMPBLNA - 1 < 1) {
                $N = 12;
                $avgigr = $avgigr + (int)$ds01['qty_igr12'];
            } else {
                $N = $FMPBLNA - 1;
                $avgigr = $avgigr + (int)$ds01['qty_igr' . $N];
            }

            if ($N - 1 < 1) {
                $X = 12;
                $avgigr = $avgigr + (int)$ds01['qty_igr12'];
            } else {
                $X = $N - 1;
                $avgigr = $avgigr + (int)$ds01['qty_igr' . $X];
            }

            if ($X - 1 < 1) {
                $X1 = 12;
                $avgigr = $avgigr + (int)$ds01['qty_igr12'];
            } else {
                $X1 = $X - 1;
                $avgigr = $avgigr + (int)$ds01['qty_igr' . $X1];
            }
        }
        if (sizeof($ds02) > 0) {
            $N = 0;
            $X = 0;
            $X1 = 0;
            if ($FMPBLNA - 1 < 1) {
                $N = 12;
                $avgomi = $avgomi + (int)$ds02['qty_omi12'];
            } else {
                $N = $FMPBLNA - 1;
                $avgomi = $avgomi + (int)$ds02['qty_omi' . $N];
            }

            if ($N - 1 < 1) {
                $X = 12;
                $avgomi = $avgomi + (int)$ds02['qty_omi12'];
            } else {
                $X = $N - 1;
                $avgomi = $avgomi + (int)$ds02['qty_omi' . $X];
            }

            if ($X - 1 < 1) {
                $X1 = 12;
                $avgomi = $avgomi + (int)$ds02['qty_omi12'];
            } else {
                $X1 = $X - 1;
                $avgomi = $avgomi + (int)$ds02['qty_omi' . $X1];
            }
        }
        if (sizeof($ds03) > 0) {
            $N = 0;
            $X = 0;
            $X1 = 0;
            if ($FMPBLNA - 1 < 1) {
                $N = 12;
                $avgmrh = $avgmrh + (int)$ds03['qty_mrh12'];
            } else {
                $N = $FMPBLNA - 1;
                $avgmrh = $avgmrh + (int)$ds03['qty_mrh' . $N];
            }

            if ($N - 1 < 1) {
                $X = 12;
                $avgmrh = $avgmrh + (int)$ds03['qty_mrh12'];
            } else {
                $X = $N - 1;
                $avgmrh = $avgmrh + (int)$ds03['qty_mrh' . $X];
            }

            if ($X - 1 < 1) {
                $X1 = 12;
                $avgmrh = $avgmrh + (int)$ds03['qty_mrh12'];
            } else {
                $X1 = $X - 1;
                $avgmrh = $avgmrh + (int)$ds03['qty_mrh' . $X1];
            }
        }
        if (sizeof($ds04) > 0) {
            $N = 0;
            $X = 0;
            $X1 = 0;
            if ($FMPBLNA - 1 < 1) {
                $N = 12;
                $avgidm = $avgidm + (int)$ds04['qty_omi12'];
            } else {
                $N = $FMPBLNA - 1;
                $avgidm = $avgidm + (int)$ds04['qty_omi' . $N];
            }

            if ($N - 1 < 1) {
                $X = 12;
                $avgidm = $avgidm + (int)$ds04['qty_omi12'];
            } else {
                $X = $N - 1;
                $avgidm = $avgidm + (int)$ds04['qty_omi' . $X];
            }

            if ($X - 1 < 1) {
                $X1 = 12;
                $avgidm = $avgidm + (int)$ds04['qty_omi12'];
            } else {
                $X1 = $X - 1;
                $avgidm = $avgidm + (int)$ds04['qty_omi' . $X1];
            }
        }
        $avgigr = round(self::ceknull(round($avgigr), 0) / 3);
        $avgomi = round(self::ceknull(round($avgomi), 0) / 3);
        $avgmrh = round(self::ceknull(round($avgmrh), 0) / 3);
        $avgidm = round(self::ceknull(round($avgidm), 0) / 3);
        $detailsales = [];
        $detailsales['igr'] = $ds01;
        $detailsales['omi'] = $ds02;
        $detailsales['mrh'] = $ds03;
        $detailsales['idm'] = $ds04;
        $detailsales['avgigr'] = $avgigr;
        $detailsales['avgomi'] = $avgomi;
        $detailsales['avgmrh'] = $avgmrh;
        $detailsales['avgidm'] = $avgidm;
        return compact(['detailsales']);
    }

    public function getPenerimaan(Request $request)

    {
        $supplier = DB::connection(Session::get('connection'))->table('TBTR_MSTRAN_D')
            ->leftJoin('TBMASTER_SUPPLIER', 'MSTD_KODESUPPLIER', '=', 'SUP_KODESUPPLIER')
            ->select('*')
            ->whereRaw('substr(mstd_prdcd, 1, 6) = substr(\'' . $request->value . '\', 1, 6)')
            ->where('mstd_kodeigr', '=', Session::get('kdigr'))
            ->whereIn('mstd_typetrn', ['L', 'I', 'B'])
            ->whereRaw('NVL (MSTD_RECORDID, \'9\') != 1')
            ->orderBy('mstd_prdcd')
            ->orderBy('mstd_tgldoc')
            ->get();

        for ($i = 0; $i < sizeof($supplier); $i++) {
            $supplier[$i]->trm_qtybns = $this->ceknull($supplier[$i]->mstd_qty, 0);
            $supplier[$i]->trm_bonus = $this->ceknull($supplier[$i]->mstd_qtybonus1, 0);
            $supplier[$i]->trm_bonus2 = $this->ceknull($supplier[$i]->mstd_qtybonus2, 0);
            $supplier[$i]->trm_dokumen = $supplier[$i]->mstd_nodoc;
            $supplier[$i]->trm_tanggal = $supplier[$i]->mstd_tgldoc;
            $supplier[$i]->trm_supp = $supplier[$i]->sup_namasupplier;

            if ($supplier[$i]->mstd_typetrn == 'I') {
                $supplier[$i]->trm_top = 'Surat Jln';
            } elseif ($supplier[$i]->mstd_typetrn == 'L') {
                $supplier[$i]->trm_top = 'Lain2/Bns';
            } elseif ($supplier[$i]->mstd_typetrn == 'B') {
                $supplier[$i]->trm_top = 'BPB';
            }

            $supplier[$i]->trm_acost = $supplier[$i]->mstd_avgcost / $supplier[$i]->mstd_frac;

            if ($supplier[$i]->mstd_typetrn == 'L') {
                $supplier[$i]->trm_hpp = 0;
            } else {
                $supplier[$i]->trm_hpp = ($supplier[$i]->mstd_gross - ($supplier[$i]->mstd_discrph + $supplier[$i]->mstd_ppnbmrph + $supplier[$i]->mstd_ppnbtlrph)) / ($supplier[$i]->mstd_qty / $supplier[$i]->mstd_frac) / $supplier[$i]->mstd_frac;
            }
        }
        return compact(['supplier']);
    }

    public function getPB(Request $request)

    {
        $ntotalpo = 0;
        $ntotalpb = 0;
        $temppo = 'A,';
        $temppb = 'A,';

        $permintaan = array();
        $pb = DB::connection(Session::get('connection'))->table('tbtr_po_d')
            ->join('tbtr_po_h', 'tpoh_nopo', '=', 'tpod_nopo')
            ->join('tbtr_pb_d', function ($join) {
                $join->On(DB::connection(Session::get('connection'))->raw('SUBSTR (pbd_prdcd, 1, 6)'), '=', DB::connection(Session::get('connection'))->raw('SUBSTR (tpod_prdcd, 1, 6)'))->On('pbd_nopo', '=', 'tpod_nopo');
            })->join('tbtr_pb_h', 'pbh_nopb', '=', 'pbd_nopb')
            ->selectRaw('DISTINCT NVL (tpod_recordid, \'9\') recid,
                                    tpod_prdcd,
                                    tpod_nopo,
                                    tpoh_tglpo,
                                    NVL (tpod_qtypb, 0) tpod_qtypb,
                                    tpoh_tglpo + tpoh_jwpb jwpb,
                                    pbh_keteranganpb,
                                    pbh_nopb,
                                    pbh_tglpb,
                                    NVL (pbh_qtypb, 0) pbh_qtypb,
                                    pbd_nopo,
                                    pbd_prdcd,
                                    pbd_qtypb')
            ->whereRaw('substr(tpod_prdcd, 1, 6) = substr(\'' . $request->value . '\', 1, 6)')
            ->orderBy('PBH_TGLPB')
            ->orderBy('PBH_NOPB')
            ->get();

        for ($i = 0; $i < sizeof($pb); $i++) {
            $pb_ketbpb = '';
            $pb_no = '';
            $pb_tgl = '';
            $pb_qty = '';
            $pb_ket = '';
            $pb_nopo = '';
            $pb_tglpo = '';
            $pb_ketbpb = '';
            $pb_qtybpb = '';
            $step = 1;
            $temppo = $temppo . $pb[$i]->tpod_nopo . ',';
            $temppb = $temppb . $pb[$i]->pbh_nopb . ',';
            $step = 2;
            $pb_no = $pb[$i]->pbh_nopb;
            $pb_tgl = $pb[$i]->pbh_tglpb;
            $pb_qty = $pb[$i]->pbd_qtypb;
            $pb_ket = $pb[$i]->pbh_keteranganpb;

            $step = 3;
            $pb_nopo = $pb[$i]->tpod_nopo;
            $pb_tglpo = $pb[$i]->tpoh_tglpo;

            $step = 4;
            $pb_qtybpb = $pb[$i]->tpod_qtypb;


            if (Self::ceknull($pb[$i]->tpod_qtypb, 0) == 0) {
                if ($pb[$i]->recid == '9') {
                    if ($pb[$i]->jwpb < Carbon::now()) {
                        $step = 5;
                        $pb_ketbpb = 'PO Mati/Kdlwarsa';
                    } else {
                        $step = 6;
                        $pb_ketbpb = 'Brg.blm dikirim';
                    }
                } else {
                    $step = 7;
                    $pb_ketbpb = 'Qty BPB 0 (null)';
                }
            }
            $step = 8;
            if (Self::ceknull($pb[$i]->tpod_nopo, '') != '' and Self::ceknull($pb[$i]->tpoh_tglpo, '') == '') {
                $step = 9;
                $pb_ketbpb = 'PO Mati/Kdlwarsa';
            }

            $step = 10;
            $ntotalpo = Self::ceknull($ntotalpo, 0) + Self::ceknull($pb[$i]->tpod_qtypb, 0);

            if (Self::ceknull($pb[$i]->tpod_nopo, '') == '') {
                if ($pb[$i]->pbh_tglpb < Carbon::now()->addDays(2)) {
                    $step = 11;
                    $pb_ketbpb = 'PB tdk.tRealiss';
                } else {
                    $step = 12;
                    $pb_ketbpb = 'Blm.Transfer PO';
                }
            }

            $dataPenerimaan["pb_no"] = $pb_no;
            $dataPenerimaan["pb_tgl"] = $pb_tgl;
            $dataPenerimaan["pb_qty"] = $pb_qty;
            $dataPenerimaan["pb_ket"] = $pb_ket;
            $dataPenerimaan["pb_nopo"] = $pb_nopo;
            $dataPenerimaan["pb_tglpo"] = $pb_tglpo;
            $dataPenerimaan["pb_ketbpb"] = $pb_ketbpb;
            $dataPenerimaan["pb_qtybpb"] = $pb_qtybpb;
            array_push($permintaan, $dataPenerimaan);
        }

        $step = 13;
        $pb2 = DB::connection(Session::get('connection'))->table('tbtr_pb_d')
            ->join('tbtr_pb_h', 'pbh_nopb', '=', 'pbd_nopb')
            ->selectRaw('DISTINCT pbh_keteranganpb,
                                     pbh_nopb,
                                     pbh_tglpb,
                                     NVL (pbh_qtypb, 0) pbh_qtypb,
                                     pbd_nopo,
                                     pbd_prdcd,
                                     pbd_qtypb')
            ->whereRaw('substr(pbd_prdcd, 1, 6) = substr(\'' . $request->value . '\', 1, 6)')
            ->orderBy('PBH_TGLPB')
            ->orderBy('PBH_NOPB')
            ->get();
        for ($i = 0; $i < sizeof($pb2); $i++) {
            if (strpos($temppb, $pb2[$i]->pbh_nopb) == 0) {
                $pb_ketbpb = '';
                $pb_no = '';
                $pb_tgl = '';
                $pb_qty = '';
                $pb_ket = '';
                $pb_nopo = '';
                $pb_tglpo = '';
                $pb_ketbpb = '';
                $pb_qtybpb = '';
                $step = 14;
                $pb_no = $pb2[$i]->pbh_nopb;
                $pb_tgl = $pb2[$i]->pbh_tglpb;
                $pb_ket = $pb2[$i]->pbh_keteranganpb;
                $pb_nopo = $pb2[$i]->pbd_nopo;
                $pb_qty = $pb2[$i]->pbd_qtypb;

                if (Self::ceknull($pb2[$i]->pbd_nopo, '') == '') {
                    if ($pb2[$i]->pbh_tglpb < Carbon::now()->addDays(2)) {
                        $step = 15;
                        $pb_ketbpb = 'PB tdk.tRealiss';
                    } else {
                        $step = 16;
                        $pb_ketbpb = 'Blm.Transfer PO';
                    }
                }
                //nextrecord
                $dataPenerimaan["pb_no"] = $pb_no;
                $dataPenerimaan["pb_tgl"] = $pb_tgl;
                $dataPenerimaan["pb_qty"] = $pb_qty;
                $dataPenerimaan["pb_ket"] = $pb_ket;
                $dataPenerimaan["pb_nopo"] = $pb_nopo;
                $dataPenerimaan["pb_tglpo"] = $pb_tglpo;
                $dataPenerimaan["pb_ketbpb"] = $pb_ketbpb;
                $dataPenerimaan["pb_qtybpb"] = $pb_qtybpb;
                array_push($permintaan, $dataPenerimaan);
            }
        }
        $po = DB::connection(Session::get('connection'))->table('tbtr_po_d')
            ->join('tbtr_po_h', 'tpoh_nopo', '=', 'tpod_nopo')
            ->selectRaw('DISTINCT NVL (tpod_recordid, \'9\') recid,
                                tpod_prdcd,
                                tpod_nopo,
                                tpoH_tglpo,
                                NVL (tpod_qtypb, 0) tpod_qtypb,
                                tpoh_tglpo + tpoh_jwpb jwpb')
            ->whereRaw('substr(tpod_prdcd, 1, 6) = substr(\'' . $request->value . '\', 1, 6)')
            ->orderBy('TPOH_TGLPO')
            ->orderBy('TPOD_NOPO')
            ->get();
        for ($i = 0; $i < sizeof($po); $i++) {
            if (strpos($temppo, $po[$i]->tpod_nopo) == 0) {
                $pb_ketbpb = '';
                $pb_no = '';
                $pb_tgl = '';
                $pb_qty = '';
                $pb_ket = '';
                $pb_nopo = '';
                $pb_tglpo = '';
                $pb_ketbpb = '';
                $pb_qtybpb = '';
                $step = 18;
                $pb_nopo = $po[$i]->tpod_nopo;
                $pb_tglpo = $po[$i]->tpoh_tglpo;
                $step = 19;
                $pb_qtybpb = $po[$i]->tpod_qtypb;
                if (Self::ceknull($po[$i]->tpod_qtypb, 0) == 0) {
                    if ($po[$i]->recid == '9') {
                        if ($po[$i]->jwpb < Carbon::now()) {
                            $step = 20;
                            $pb_ketbpb = 'PO Mati/Kdlwarsa';
                        } else {
                            $step = 21;
                            $pb_ketbpb = 'Brg.blm dikirim';
                        }
                    } else {
                        $step = 22;
                        $pb_ketbpb = 'Qty BPB 0 (nul)';
                    }
                }

                if (Self::ceknull($po[$i]->tpod_nopo, '') != '' and Self::ceknull($po[$i]->tpoh_tglpo, '') == '') {
                    $step = 23;
                    $pb_ketbpb = 'PO Mati/Kdlwarsa';
                }

                $step = 24;
                $ntotalpo = Self::ceknull($ntotalpo, 0) + Self::ceknull($po[$i]->tpod_qtypb, 0);

                $step = 25;
                $pb_ketbpb = 'PO Alokasi';
                if (Self::ceknull($pb_qtybpb, 0) == 0) {
                    $step = 26;
                    $pb_ketbpb = 'PO Alokasi/Mati';
                }
                $step = 27;
                if (Self::ceknull($pb_nopo, '') == '' and Self::ceknull($pb_tglpo, '') == '') {
                    $step = 28;
                    $pb_ketbpb = 'PO Mati/Kdlwarsa';
                }
//	        NEXT_RECORD;
                $dataPenerimaan["pb_no"] = $pb_no;
                $dataPenerimaan["pb_tgl"] = $pb_tgl;
                $dataPenerimaan["pb_qty"] = $pb_qty;
                $dataPenerimaan["pb_ket"] = $pb_ket;
                $dataPenerimaan["pb_nopo"] = $pb_nopo;
                $dataPenerimaan["pb_tglpo"] = $pb_tglpo;
                $dataPenerimaan["pb_ketbpb"] = $pb_ketbpb;
                $dataPenerimaan["pb_qtybpb"] = $pb_qtybpb;
                array_push($permintaan, $dataPenerimaan);
            }
        }
        return compact(['permintaan']);
    }

    public function getHargaBeli(Request $request)
    {
        $hargabeli = DB::connection(Session::get('connection'))->table('tbmaster_hargabeli')
            ->join('tbmaster_prodmast', 'prd_prdcd', '=', 'hgb_prdcd')
            ->join('tbmaster_supplier', 'sup_kodesupplier', '=', 'hgb_kodesupplier')
            ->leftJoin('tbmaster_tag', 'tag_kodetag', '=', 'prd_kodetag')
            ->selectRaw('hgb_prdcd,
                                         hgb_hrgbeli fmbeli,
                                         NVL(hgb_ppnbm, 0) fmppnb,
                                         NVL(hgb_ppnbotol, 0) fmnbtl,
                                         NVL(hgb_ppn, 0) fmppnn,
                                         hgb_tglmulaidisc01 fmd1tm,
                                         hgb_tglakhirdisc01 fmd1ta,
                                         hgb_flagdisc01 fmdirs,
                                         hgb_rphdisc01 fmdirr,
                                         hgb_tglmulaidisc02 fmditm,
                                         hgb_tglakhirdisc02 fmdita,
                                         hgb_rphdisc02 fmditr,
                                         hgb_tglmulaibonus01 fmbntm,
                                         hgb_tglakhirbonus01 fmbnta,
                                         hgb_qty1bonus01 fmqbs1,
                                         hgb_qtymulai1bonus01 fmqbl1,
                                         hgb_jenishrgbeli fmjnsh,
                                         hgb_jenisbonus fmfbns,
                                         hgb_rphdisc02ii,
                                         hgb_rphdisc02iii,
                                         hgb_persendisc02ii,
                                         hgb_persendisc02iii,
                                         hgb_tglmulaidisc02ii,
                                         hgb_tglakhirdisc02ii,
                                         hgb_tglmulaidisc02iii,
                                         hgb_tglakhirdisc02iii,
                                         hgb_tglberlaku01 fmtgbu,
                                         hgb_top fmjtop,
                                         hgb_statusbarang fmkdsb,
                                         hgb_persendisc01 fmdirp,
                                         hgb_persendisc02 fmditp,
                                         hgb_persendisc03 fmd3ps,
                                         hgb_rphdisc03 fmd3rp,
                                         hgb_persendisc06 fmd4p3,
                                         hgb_rphdisc06 fmd4r3,
                                         hgb_persendisc05 fmd4p2,
                                         hgb_rphdisc05 fmd4r2,
                                         hgb_persendisc04 fmd4p1,
                                         hgb_rphdisc04 fmd4r1,
                                         hgb_qtymulai2bonus01 fmqbl2,
                                         hgb_qtymulai3bonus01 fmqbl3,
                                         hgb_qty2bonus01 fmqbs2,
                                         hgb_qty3bonus01 fmqbs3,
                                         hgb_kodesupplier,
                                         hgb_flagkelipatanbonus01 fmklpt,
                                         hgb_tipe fmtipe,
                                         hgb_prdcd fmplu,
                                         prd_isibeli isib,
                                         prd_unit unit,
                                         prd_deskripsipanjang,
                                         prd_kodetag ptag,
                                         prd_satuanbeli satb,
                                         prd_flagbkp1 bkp,
                                         prd_flagbandrol,
                                         prd_frac frac,
                                         sup_namasupplier,
                                         sup_pkp,
                                         tag_kodetag,
                                         tag_keterangan ftketr,
                                         hgb_qtymulai1bonus02,
                                         hgb_qtymulai2bonus02,
                                         hgb_qtymulai3bonus02,
                                         hgb_qty1bonus02,
                                         hgb_qty2bonus02,
                                         hgb_qty3bonus02')
            ->whereRaw('substr(hgb_prdcd, 1, 6) = substr(\'' . $request->value . '\', 1, 6)')
            ->orderBy('hgb_tipe')
            ->orderBy('hgb_kodesupplier')
            ->get();

        for ($i = 0; $i < sizeof($hargabeli); $i++) {
            $hb_plu = $hargabeli[$i]->hgb_prdcd . ' - ' . $hargabeli[$i]->prd_deskripsipanjang;
            $hb_tglberlaku = $hargabeli[$i]->fmtgbu;
            $hb_supplier = $hargabeli[$i]->hgb_kodesupplier . ' - ' . $hargabeli[$i]->sup_namasupplier;
            $hb_statustag = $hargabeli[$i]->tag_kodetag . ' - ' . $hargabeli[$i]->ftketr;
            $hb_satuanbl = $hargabeli[$i]->satb . '/' . $hargabeli[$i]->isib;
            $hb_bkp = $hargabeli[$i]->bkp;
            $hb_flagbandrol = $hargabeli[$i]->prd_flagbandrol;
            $harga1 = Self::ceknull($hargabeli[$i]->fmbeli, 0) + Self::ceknull($hargabeli[$i]->fmppnb, 0) + Self::ceknull($hargabeli[$i]->fmnbtl, 0);

            if (($hargabeli[$i]->fmd1tm <= Carbon::now() and $hargabeli[$i]->fmd1ta >= Carbon::now() and $hargabeli[$i]->fmd1tm != Carbon::now()) or $hargabeli[$i]->fmd1tm = Carbon::now()) {
                if ($hargabeli[$i]->fmdirs == 'K') {
                    $harga1 = $harga1 - $hargabeli[$i]->fmdirr;
                } else {
                    $harga1 = $harga1 - $hargabeli[$i]->fmdirr / $hargabeli[$i]->isib;
                }
            }

            if ($hargabeli[$i]->fmditm <= Carbon::now() and $hargabeli[$i]->fmdita >= Carbon::now() and $hargabeli[$i]->fmditm != Carbon::now()) {
                if ($hargabeli[$i]->fmdirs == 'K') {
                    $harga1 = $harga1 - $hargabeli[$i]->fmditr;
                } else {
                    $harga1 = $harga1 - $hargabeli[$i]->fmditr / $hargabeli[$i]->isib;
                }
            }

            if ($hargabeli[$i]->hgb_tglmulaidisc02ii <= Carbon::now()
                and $hargabeli[$i]->hgb_tglakhirdisc02ii >= Carbon::now()
                and $hargabeli[$i]->hgb_tglmulaidisc02ii != Carbon::now()) {
                if ($hargabeli[$i]->fmdirs == 'K') {
                    $harga1 = $harga1 - $hargabeli[$i]->hgb_rphdisc02ii;
                } else {
                    $harga1 = $harga1 - $hargabeli[$i]->hgb_rphdisc02ii / $hargabeli[$i]->isib;
                }
            }

            if ($hargabeli[$i]->hgb_tglmulaidisc02iii <= Carbon::now()
                and $hargabeli[$i]->hgb_tglakhirdisc02iii >= Carbon::now()
                and $hargabeli[$i]->hgb_tglmulaidisc02iii != Carbon::now()) {
                if ($hargabeli[$i]->fmdirs == 'K') {
                    $harga1 = $harga1 - $hargabeli[$i]->hgb_rphdisc02iii;
                } else {
                    $harga1 = $harga1 - $hargabeli[$i]->hgb_rphdisc02iii / $hargabeli[$i]->isib;
                }
            }

            if ($hargabeli[$i]->fmbntm <= Carbon::now()
                and $hargabeli[$i]->fmbnta >= Carbon::now()
                and $hargabeli[$i]->fmbnta != Carbon::now()
                and $hargabeli[$i]->fmqbs1 + $hargabeli[$i]->fmqbl1 != 0
            ) {
                if ($hargabeli[$i]->fmfbns == 'K') {
                    $harga1 = (($harga1 * $hargabeli[$i]->fmqbl1) / ($hargabeli[$i]->fmqbs1 + $hargabeli[$i]->fmqbl1));

                    if ($hargabeli[$i]->unit == 'KG') {
                        $harga1 = $harga1 * 1000;
                    }

                } else {
                    $harga1 = (($harga1 * ($hargabeli[$i]->fmqbl1 * $hargabeli[$i]->isib))
                        / (($hargabeli[$i]->fmqbs1 * $hargabeli[$i]->isib) + ($hargabeli[$i]->fmqbl1 * $hargabeli[$i]->isib))
                    );
                    if ($hargabeli[$i]->unit == 'KG') {
                        $harga1 = $harga1 * 1000;
                    }
                }
            }

            $hb_hrgomi = $harga1;
            $hb_jnshg = $hargabeli[$i]->fmjnsh;
            $hb_top = $hargabeli[$i]->fmjtop;
            $hb_pkp = $hargabeli[$i]->sup_pkp;

            if ($hargabeli[$i]->unit == 'KG') {
                $vkl = 1;
            } else {
                $vkl = $hargabeli[$i]->isib;
            }

            $hb_hgbeli = $hargabeli[$i]->fmbeli * $vkl;
            $hb_kondisi = $hargabeli[$i]->fmkdsb;
            $hb_ppnbm = $hargabeli[$i]->fmppnb * $vkl;
            $hb_ppn = $hargabeli[$i]->fmppnn * $vkl;
            $hb_btl = $hargabeli[$i]->fmppnb * $vkl;
            $hb_total = $hb_hgbeli + $hb_ppnbm + $hb_ppn;
            $hb_persendisc1 = Self::ceknull($hargabeli[$i]->fmdirp, 0);
            $hb_rpdisc1 = Self::ceknull($hargabeli[$i]->fmdirr, 0);
            $hb_satuan = $hargabeli[$i]->fmdirs;
            $hb_persendisc2 = Self::ceknull($hargabeli[$i]->fmditp, 0);
            $hb_rpdisc2 = Self::ceknull($hargabeli[$i]->fmditr, 0);
            $hb_periode = "";
            if (Self::ceknull($hargabeli[$i]->fmditm, "") != "") {
                $hb_periode = Date('d-M-y', strtotime($hargabeli[$i]->fmditm)) . ' s/d ' . Date('d-M-y', strtotime($hargabeli[$i]->fmdita));
            }
            $hb_persendisc2ii = Self::ceknull($hargabeli[$i]->hgb_persendisc02ii, 0);
            $hb_rpdisc2ii = Self::ceknull($hargabeli[$i]->hgb_rphdisc02ii, 0);
            $hb_periodeii = "";
            if (Self::ceknull($hargabeli[$i]->hgb_tglmulaidisc02ii, "") != "") {
                $hb_periodeii = $hargabeli[$i]->hgb_tglmulaidisc02ii . ' s/d ' . $hargabeli[$i]->hgb_tglakhirdisc02ii;
            }

            $hb_persendisc2iii = Self::ceknull($hargabeli[$i]->hgb_persendisc02iii, 0);
            $hb_rpdisc2iii = Self::ceknull($hargabeli[$i]->hgb_rphdisc02iii, 0);
            $hb_periodeiii = "";
            if (Self::ceknull($hargabeli[$i]->hgb_tglmulaidisc02iii, "") != "") {
                $hb_periodeiii = $hargabeli[$i]->hgb_tglmulaidisc02iii . ' s/d ' . $hargabeli[$i]->hgb_tglakhirdisc02iii;
            }

            $hb_persendisc3 = Self::ceknull($hargabeli[$i]->fmd3ps, 0);
            $hb_rpdisc3 = Self::ceknull($hargabeli[$i]->fmd3rp, 0);
            $hb_persendisc4 = Self::ceknull($hargabeli[$i]->fmd4p3, 0);
            $hb_rpdisc4 = Self::ceknull($hargabeli[$i]->fmd4r3, 0);
            $hb_persencd = Self::ceknull($hargabeli[$i]->fmd4p2, 0);
            $hb_rpcd = $hargabeli[$i]->fmd4r2;
            $hb_persendf = Self::ceknull($hargabeli[$i]->fmd4p1, 0);
            $hb_rpdf = Self::ceknull($hargabeli[$i]->fmd4r1, 0);
            $hb_total2 = Self::ceknull($hargabeli[$i]->fmd4r1, 0) + Self::ceknull($hargabeli[$i]->fmd4r2, 0) + Self::ceknull($hargabeli[$i]->fmd4r3, 0);
            $hb_bnslipat = $hargabeli[$i]->fmklpt;
            $hb_periodbns = '';
            if (Self::ceknull($hargabeli[$i]->fmbntm, "") != "") {
                $hb_periodbns = date("d-M-Y", strtotime(substr($hargabeli[$i]->fmbntm, 0, 10))) . ' s/d ' . date("d-M-Y", strtotime(substr($hargabeli[$i]->fmbnta, 0, 10)));
            }

            $hb_qtybeli1 = 0;
            $hb_qtybeli2 = 0;
            $hb_qtybeli3 = 0;
            $hb_qtybns1 = 0;
            $hb_qtybns2 = 0;
            $hb_qtybns3 = 0;
            $hb_qty2beli1 = 0;
            $hb_qty2beli2 = 0;
            $hb_qty2beli3 = 0;
            $hb_qty2bns1 = 0;
            $hb_qty2bns2 = 0;
            $hb_qty2bns3 = 0;

            if ($hargabeli[$i]->fmfbns == 'B') {
                $hb_qtybeli1 = Self::ceknull($hargabeli[$i]->fmqbl1, 0) * $hargabeli[$i]->frac;
                $hb_qtybeli2 = Self::ceknull($hargabeli[$i]->fmqbl2, 0) * $hargabeli[$i]->frac;
                $hb_qtybeli3 = Self::ceknull($hargabeli[$i]->fmqbl3, 0) * $hargabeli[$i]->frac;
                $hb_qtybns1 = Self::ceknull($hargabeli[$i]->fmqbs1, 0) * $hargabeli[$i]->frac;
                $hb_qtybns2 = Self::ceknull($hargabeli[$i]->fmqbs2, 0) * $hargabeli[$i]->frac;
                $hb_qtybns3 = Self::ceknull($hargabeli[$i]->fmqbs3, 0) * $hargabeli[$i]->frac;

                $hb_qty2beli1 = Self::ceknull($hargabeli[$i]->hgb_qtymulai1bonus02, 0) * $hargabeli[$i]->frac;
                $hb_qty2beli2 = Self::ceknull($hargabeli[$i]->hgb_qtymulai2bonus02, 0) * $hargabeli[$i]->frac;
                $hb_qty2beli3 = Self::ceknull($hargabeli[$i]->hgb_qtymulai3bonus02, 0) * $hargabeli[$i]->frac;
                $hb_qty2bns1 = Self::ceknull($hargabeli[$i]->hgb_qty1bonus02, 0) * $hargabeli[$i]->frac;
                $hb_qty2bns2 = Self::ceknull($hargabeli[$i]->hgb_qty2bonus02, 0) * $hargabeli[$i]->frac;
                $hb_qty2bns3 = Self::ceknull($hargabeli[$i]->hgb_qty3bonus02, 0) * $hargabeli[$i]->frac;
            } else {
                $hb_qtybeli1 = Self::ceknull($hargabeli[$i]->fmqbl1, 0);
                $hb_qtybeli2 = Self::ceknull($hargabeli[$i]->fmqbl2, 0);
                $hb_qtybeli3 = Self::ceknull($hargabeli[$i]->fmqbl3, 0);
                $hb_qtybns1 = Self::ceknull($hargabeli[$i]->fmqbs1, 0);
                $hb_qtybns2 = Self::ceknull($hargabeli[$i]->fmqbs2, 0);
                $hb_qtybns3 = Self::ceknull($hargabeli[$i]->fmqbs3, 0);

                $hb_qty2beli1 = Self::ceknull($hargabeli[$i]->hgb_qtymulai1bonus02, 0);
                $hb_qty2beli2 = Self::ceknull($hargabeli[$i]->hgb_qtymulai2bonus02, 0);
                $hb_qty2beli3 = Self::ceknull($hargabeli[$i]->hgb_qtymulai3bonus02, 0);
                $hb_qty2bns1 = Self::ceknull($hargabeli[$i]->hgb_qty1bonus02, 0);
                $hb_qty2bns2 = Self::ceknull($hargabeli[$i]->hgb_qty2bonus02, 0);
                $hb_qty2bns3 = Self::ceknull($hargabeli[$i]->hgb_qty3bonus02, 0);

            }

//            $hb_qtybeli1 = Self::ceknull($hargabeli[$i]->fmqbl1, 0) * $hargabeli[$i]->frac;
//            $hb_qtybeli2 = Self::ceknull($hargabeli[$i]->fmqbl2, 0) * $hargabeli[$i]->frac;
//            $hb_qtybeli3 = Self::ceknull($hargabeli[$i]->fmqbl3, 0) * $hargabeli[$i]->frac;
//            $hb_qtybns1 = Self::ceknull($hargabeli[$i]->fmqbs1, 0) * $hargabeli[$i]->frac;
//            $hb_qtybns2 = Self::ceknull($hargabeli[$i]->fmqbs2, 0) * $hargabeli[$i]->frac;
//            $hb_qtybns3 = Self::ceknull($hargabeli[$i]->fmqbs3, 0) * $hargabeli[$i]->frac;

            $hargabeli[$i]->hb_plu = $hb_plu;
            $hargabeli[$i]->hb_tglberlaku = $hb_tglberlaku;
            $hargabeli[$i]->hb_supplier = $hb_supplier;
            $hargabeli[$i]->hb_statustag = $hb_statustag;
            $hargabeli[$i]->hb_satuanbl = $hb_satuanbl;
            $hargabeli[$i]->hb_bkp = $hb_bkp;
            $hargabeli[$i]->hb_flagbandrol = $hb_flagbandrol;
            $hargabeli[$i]->harga1 = $harga1;
            $hargabeli[$i]->hb_hrgomi = $hb_hrgomi;
            $hargabeli[$i]->hb_jnshg = $hb_jnshg;
            $hargabeli[$i]->hb_top = $hb_top;
            $hargabeli[$i]->hb_pkp = $hb_pkp;

            $hargabeli[$i]->hb_hgbeli = $hb_hgbeli;
            $hargabeli[$i]->hb_kondisi = $hb_kondisi;
            $hargabeli[$i]->hb_ppnbm = $hb_ppnbm;
            $hargabeli[$i]->hb_ppn = $hb_ppn;
            $hargabeli[$i]->hb_btl = $hb_btl;
            $hargabeli[$i]->hb_total = $hb_total;
            $hargabeli[$i]->hb_persendisc1 = $hb_persendisc1;
            $hargabeli[$i]->hb_rpdisc1 = $hb_rpdisc1;
            $hargabeli[$i]->hb_satuan = $hb_satuan;
            $hargabeli[$i]->hb_persendisc2 = $hb_persendisc2;
            $hargabeli[$i]->hb_rpdisc2 = $hb_rpdisc2;
            $hargabeli[$i]->hb_periode = $hb_periode;

            $hargabeli[$i]->hb_persendisc2ii = $hb_persendisc2ii;
            $hargabeli[$i]->hb_rpdisc2ii = $hb_rpdisc2ii;
            $hargabeli[$i]->hb_periodeii = $hb_periodeii;

            $hargabeli[$i]->hb_persendisc2iii = $hb_persendisc2iii;
            $hargabeli[$i]->hb_rpdisc2iii = $hb_rpdisc2iii;
            $hargabeli[$i]->hb_periodeiii = $hb_periodeiii;

            $hargabeli[$i]->hb_persendisc3 = $hb_persendisc3;
            $hargabeli[$i]->hb_rpdisc3 = $hb_rpdisc3;
            $hargabeli[$i]->hb_persendisc4 = $hb_persendisc4;
            $hargabeli[$i]->hb_rpdisc4 = $hb_rpdisc4;
            $hargabeli[$i]->hb_persencd = $hb_persencd;
            $hargabeli[$i]->hb_rpcd = $hb_rpcd;
            $hargabeli[$i]->hb_persendf = $hb_persendf;
            $hargabeli[$i]->hb_rpdf = $hb_rpdf;
            $hargabeli[$i]->hb_total2 = $hb_total2;
            $hargabeli[$i]->hb_bnslipat = $hb_bnslipat;
            $hargabeli[$i]->hb_periodbns = $hb_periodbns;

            $hargabeli[$i]->hb_qtybeli1 = $hb_qtybeli1;
            $hargabeli[$i]->hb_qtybeli2 = $hb_qtybeli2;
            $hargabeli[$i]->hb_qtybeli3 = $hb_qtybeli3;
            $hargabeli[$i]->hb_qtybns1 = $hb_qtybns1;
            $hargabeli[$i]->hb_qtybns2 = $hb_qtybns2;
            $hargabeli[$i]->hb_qtybns3 = $hb_qtybns3;

            $hargabeli[$i]->hb_qty2beli1 = $hb_qty2beli1;
            $hargabeli[$i]->hb_qty2beli2 = $hb_qty2beli2;
            $hargabeli[$i]->hb_qty2beli3 = $hb_qty2beli3;
            $hargabeli[$i]->hb_qty2bns1 = $hb_qty2bns1;
            $hargabeli[$i]->hb_qty2bns2 = $hb_qty2bns2;
            $hargabeli[$i]->hb_qty2bns3 = $hb_qty2bns3;
        }
        return compact(['hargabeli']);

    }

    public function getStockCarton(Request $request)
    {
        //STOCK CARTON
        $flagreset = DB::connection(Session::get('connection'))->table('tbmaster_setting_so')
            ->selectRaw('nvl(mso_flagreset, \'N\') fr')
            ->whereRaw('to_char(mso_tglso, \'yyyy-MM\') = TO_CHAR (SYSDATE , \'yyyy-MM\')')
            ->first();

        if (is_null($flagreset) || !isset($flagreset) || $flagreset == null) {
            $flagreset = 'Y';
        } else {
            $flagreset = $flagreset->fr;
        }

        $qty_soic = DB::connection(Session::get('connection'))->table('tbtr_reset_soic')
            ->selectRaw('sum(nvl(rso_qtyreset,0)) qty')
            ->whereRaw('substr(rso_prdcd, 1, 6) = substr(\'' . $request->value . '\', 1, 6)')
            ->whereRaw('to_char(rso_tglso, \'yyyyMM\') = to_char(sysdate, \'yyyyMM\')')
            ->where('rso_lokasi', '=', '01')
            ->first();
        $qty_soic = $qty_soic->qty;
        $stockcarton = DB::connection(Session::get('connection'))->table('tbmaster_prodmast')
            ->join('tbmaster_stock', function ($join) {
                $join->On(DB::connection(Session::get('connection'))->raw('substr(st_prdcd, 1, 6)'), '=', DB::connection(Session::get('connection'))->raw('substr(prd_prdcd, 1, 6)'));
            })
            ->selectRaw("prd_frac frac, st_lokasi,
                                    CASE WHEN  '" . $flagreset . "' <> 'Y' THEN (st_saldoakhir - st_selisih_so) ELSE st_saldoakhir END st_saldoakhir,
                                    st_selisih_soic")
            ->where('prd_prdcd', '=', $request->value)
            ->get();
        $title = "";
        $qb_baik = "";
        $qc_baik = "";
        $qb_ret = "";
        $qc_ret = "";
        $qb_rus = "";
        $qc_rus = "";
        for ($i = 0; $i < sizeof($stockcarton); $i++) {
            $title = 'Stok Akhir Satuan CARTON (' . $stockcarton[$i]->frac . ')';
            $saldoakhir = $stockcarton[$i]->st_saldoakhir;
            if ($stockcarton[$i]->st_lokasi == '01') {
                $saldoakhir = $stockcarton[$i]->st_saldoakhir - Self::ceknull($stockcarton[$i]->st_selisih_soic, 0) + Self::ceknull($qty_soic, 0);
            }

            if ($stockcarton[$i]->st_lokasi == '01') {
                if ($saldoakhir <= $stockcarton[$i]->frac) {
                    $qc_baik = $saldoakhir;
                    $qb_baik = 0;

                    if ($saldoakhir == $stockcarton[$i]->frac) {
                        $qc_baik = 0;
                        $qb_baik = 1;
                    }
                } else {
                    $qc_baik = fmod($saldoakhir, (int)$stockcarton[$i]->frac);
                    $qb_baik = ($saldoakhir - $qc_baik) / $stockcarton[$i]->frac;
                }
            }


            if ($stockcarton[$i]->st_lokasi == '02') {
                if ($saldoakhir <= $stockcarton[$i]->frac) {
                    $qc_ret = $saldoakhir;
                    $qb_ret = 0;
                    if ($saldoakhir == $stockcarton[$i]->frac) {
                        $qc_ret = 0;
                        $qb_ret = 1;
                    }
                } else {
                    $qc_ret = fmod($saldoakhir, (int)$stockcarton[$i]->frac);
                    $qb_ret = ($saldoakhir - $qc_ret) / $stockcarton[$i]->frac;
                }
            }

            if ($stockcarton[$i]->st_lokasi == '03') {
                if ($saldoakhir <= $stockcarton[$i]->frac) {
                    $qc_rus = $saldoakhir;
                    $qb_rus = 0;
                    if ($saldoakhir == $stockcarton[$i]->frac) {
                        $qc_rus = 0;
                        $qb_rus = 1;
                    }
                } else {
                    $qc_rus = fmod($saldoakhir, (int)$stockcarton[$i]->frac);
                    $qb_rus = ($saldoakhir - $qc_rus) / $stockcarton[$i]->frac;
                }
            }
        }

        $stockcarton = [];
        $stockcarton['STC_TITLE'] = $title;
        $stockcarton['STC_baik'] = 'Baik';
        $stockcarton['STC_CT1'] = $qb_baik;
        $stockcarton['STC_PCS1'] = $qc_baik;
        $stockcarton['STC_retur'] = 'Retur';
        $stockcarton['STC_CT2'] = $qb_ret;
        $stockcarton['STC_PCS2'] = $qc_ret;
        $stockcarton['STC_rsk'] = 'Rusak';
        $stockcarton['STC_CT3'] = $qb_rus;
        $stockcarton['STC_PCS3'] = $qc_rus;
        return compact(['stockcarton']);

    }

    public function getSO(Request $request)
    {
        $temp = DB::connection(Session::get('connection'))->table('tbtr_ba_stockopname')
            ->selectRaw('distinct sop_tglso')
            ->where('sop_kodeigr', '=', Session::get('kdigr'))
            ->orderBy('sop_tglso', 'desc')
            ->get();

        if (sizeof($temp) != 0) {
            for ($i = 0; $i < sizeof($temp); $i++) {
                $so_tgl = date('Y-m-d', strtotime(substr($temp[$i]->sop_tglso, 0, 10)));
                break;
            }
        } else {
            $so_tgl = date('Y-m-d');
        }

        $tempadjustso = DB::connection(Session::get('connection'))->raw('(Select ADJ_KODEIGR,
                                ADJ_TGLSO,
                                ADJ_PRDCD,
                                ADJ_LOKASI,
                                SUM (NVL (ADJ_QTY, 0)) QTY_ADJ
                                from TBTR_ADJUSTSO
                                Group by ADJ_KODEIGR,
                                    ADJ_TGLSO,
                                    ADJ_PRDCD,
                                    ADJ_LOKASI) B');

        $so = DB::connection(Session::get('connection'))->table('TBTR_BA_STOCKOPNAME')
            ->join('TBMASTER_PRODMAST', 'PRD_PRDCD', '=', 'SOP_PRDCD')
            ->leftJoin($tempadjustso, function ($join) {
                $join->On(DB::connection(Session::get('connection'))->raw('SUBSTR (B.ADJ_PRDCD, 1, 6)'), '=', DB::connection(Session::get('connection'))->raw('SUBSTR (SOP_PRDCD, 1, 6)'))->On(DB::connection(Session::get('connection'))->raw('trunc(B.ADJ_TGLSO)'), '=', DB::connection(Session::get('connection'))->raw('trunc(SOP_TGLSO)'))->On('B.ADJ_LOKASI', '=', 'SOP_LOKASI');
            })
            ->selectRaw('SOP_QTYSO,
                        SOP_QTYLPP,
                        NVL (B.QTY_ADJ, 0) QTY_ADJ,
                        SOP_QTYSO - SOP_QTYLPP + NVL (B.QTY_ADJ, 0) SELISIH,
                        SOP_NEWAVGCOST,
                        CASE
                           WHEN PRD_UNIT = \'KG\'
                               THEN ((SOP_QTYSO - SOP_QTYLPP + NVL (B.QTY_ADJ, 0)) * SOP_NEWAVGCOST) / 1000
                           ELSE (SOP_QTYSO - SOP_QTYLPP + NVL (B.QTY_ADJ, 0)) * SOP_NEWAVGCOST
                        END RUPIAH,
                        PRD_UNIT')
            ->whereRaw('substr(SOP_PRDCD, 1, 6) = substr(\'' . $request->value . '\', 1, 6)')
            ->where('SOP_LOKASI', '=', '01')
            ->whereRaw('SOP_TGLSO = to_date(\'' . $so_tgl . '\',\'yyyy-mm-dd\')')
            ->get();

        $adjustso = DB::connection(Session::get('connection'))->table('TBTR_ADJUSTSO')
            ->select('*')
            ->where('adj_kodeigr', '=', Session::get('kdigr'))
            ->where('adj_lokasi', '=', '01')
            ->whereRaw('substr(adj_prdcd, 1, 6) = substr(\'' . $request->value . '\', 1, 6)')
            ->whereRaw('adj_tglso = to_date(\'' . $so_tgl . '\',\'yyyy-mm-dd\')')
            ->orderBy('adj_create_dt')
            ->get();

        $resetsoic = DB::connection(Session::get('connection'))->table('TBTR_RESET_SOIC')
            ->select('*')
            ->where('rso_kodeigr', '=', Session::get('kdigr'))
            ->where('rso_lokasi', '=', '01')
            ->whereRaw('substr(rso_prdcd, 1, 6) = substr(\'' . $request->value . '\', 1, 6)')
            ->whereRaw('to_char(rso_tglso, \'yyyyMM\') = to_char(sysdate, \'yyyyMM\')')
            ->orderBy('rso_tglso')
            ->orderBy('rso_kodeso')
            ->get();
        return compact(['so_tgl', 'so', 'adjustso', 'resetsoic']);

    }

}
