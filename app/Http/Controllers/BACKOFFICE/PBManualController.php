<?php

namespace App\Http\Controllers\BACKOFFICE;

use App\Http\Controllers\Connection;
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
            $c = loginController::getConnectionProcedure();

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

                $pbd[$i]->total = $pbd[$i]->pbd_gross + $pbd[$i]->pbd_ppn + $pbd[$i]->pbd_ppnbm + $pbd[$i]->pbd_ppnbotol;

            }
        }
        return compact(['pb', 'MODEL', 'pbd', 'message', 'status']);

    }


    public
    function cek_plu(Request $request)
    {
        $message = '';
        $status = '';
        $plu = [];

        $v_oke = false;
        $PBD_PRDCD = $request->plu;
        $PBD_NOPB = $request->nopb;
        $PBD_KODEIGR = $_SESSION['kdigr'];
        $FLAG = $request->flag;
        $TGLPB = $request->tglpb;

        $c = loginController::getConnectionProcedure();


        $sql = "BEGIN sp_igr_bo_pb_cek_plu2('" . $PBD_KODEIGR . "','" . $PBD_PRDCD . "',to_date('" . $TGLPB . "','dd/mm/yyyy'),'" . $FLAG . "'," . ":DESKPDK, :DESKPJG, :UNIT, :FRAC, :BKP,:PBD_KODESUPPLIER, :SUPPLIER, :SUPPKP, :HG_JUAL, :ISI_BELI, :PBD_SALDOAKHIR, :MINOR, :PBD_PKMT, :PBD_PERSENDISC1, :PBD_RPHDISC1, :PBD_FLAGDISC1, :PBD_PERSENDISC2, :PBD_RPHDISC2, :PBD_FLAGDISC2, :PBD_TOP, :F_OMI, :F_IDM, :PBD_HRGSATUAN, :PBD_PPNBM,:PBD_PPNBOTOL, :v_oke, :v_message);END;";
//        dd($sql);
        $s = oci_parse($c, $sql);

        oci_bind_by_name($s, ':DESKPDK', $plu['deskpdk'], 100);
        oci_bind_by_name($s, ':DESKPJG', $plu['prd_deskripsipanjang'], 100);
        oci_bind_by_name($s, ':UNIT', $plu['prd_unit'], 100);
        oci_bind_by_name($s, ':FRAC', $plu['prd_frac'], 100);
        oci_bind_by_name($s, ':BKP', $plu['bkp'], 100);
        oci_bind_by_name($s, ':PBD_KODESUPPLIER', $plu['pbd_kodesupplier'], 100);
        oci_bind_by_name($s, ':SUPPLIER', $plu['sup_namasupplier'], 100);
        oci_bind_by_name($s, ':SUPPKP', $plu['suppkp'], 100);
        oci_bind_by_name($s, ':HG_JUAL', $plu['prd_hrgjual'], 100);
        oci_bind_by_name($s, ':ISI_BELI', $plu['isi_beli'], 100);
        oci_bind_by_name($s, ':PBD_SALDOAKHIR', $plu['st_saldoakhir'], 100);
        oci_bind_by_name($s, ':MINOR', $plu['minor'], 100);
        oci_bind_by_name($s, ':PBD_PKMT', $plu['pbd_pkmt'], 100);
        oci_bind_by_name($s, ':PBD_PERSENDISC1', $plu['pbd_persendisc1'], 100);
        oci_bind_by_name($s, ':PBD_RPHDISC1', $plu['pbd_rphdisc1'], 100);
        oci_bind_by_name($s, ':PBD_FLAGDISC1', $plu['pbd_flagdisc1'], 100);
        oci_bind_by_name($s, ':PBD_PERSENDISC2', $plu['pbd_persendisc2'], 100);
        oci_bind_by_name($s, ':PBD_RPHDISC2', $plu['pbd_rphdisc2'], 100);
        oci_bind_by_name($s, ':PBD_FLAGDISC2', $plu['pbd_flagdisc2'], 100);
        oci_bind_by_name($s, ':PBD_TOP', $plu['pbd_top'], 100);
        oci_bind_by_name($s, ':F_OMI', $plu['f_omi'], 100);
        oci_bind_by_name($s, ':F_IDM', $plu['f_idm'], 100);
        oci_bind_by_name($s, ':PBD_HRGSATUAN', $plu['pbd_hrgsatuan'], 100);
        oci_bind_by_name($s, ':PBD_PPNBM', $plu['pbd_ppnbm'], 100);
        oci_bind_by_name($s, ':PBD_PPNBOTOL', $plu['pbd_ppnbotol'], 100);
        oci_bind_by_name($s, ':v_oke', $v_oke, 100);
        oci_bind_by_name($s, ':v_message', $v_message, 100);
        oci_execute($s);

        $plu['pbd_prdcd'] = $PBD_PRDCD;
        if ($v_oke == "TRUE") {
            $plu['satuan'] = $plu['prd_unit'] . '/' . Self::ceknull($plu['prd_frac'], 1);
            $divdepkat = DB::table('tbmaster_prodmast')
                ->select('prd_kodedivisi', 'prd_kodedivisipo', 'prd_kodedepartement', 'prd_kodekategoribarang')
                ->where('prd_kodeigr', $_SESSION['kdigr'])
                ->where('prd_prdcd', $PBD_PRDCD)
                ->first();

            $plu['pbd_kodedivisi'] = $divdepkat->prd_kodedivisi;
            $plu['prd_kodedivisipo'] = $divdepkat->prd_kodedivisipo;
            $plu['prd_kodedepartement'] = $divdepkat->prd_kodedepartement;
            $plu['prd_kodekategoribarang'] = $divdepkat->prd_kodekategoribarang;

            $disc = DB::table('temp_go')
                ->select('isi_toko', 'per_awal_pdisc_go', 'per_akhir_pdisc_go')
                ->where('kodeigr', $_SESSION['kdigr'])
                ->first();

            if ($disc->isi_toko = 'Y' && (Carbon::now() >= $disc->per_awal_pdisc_go && Carbon::now() <= $disc->per_akhir_pdisc_go)) {
                $plu['pbd_fdxrev'] = 'T';
            } else {
                $plu['pbd_fdxrev'] = '';
            }
        } else {
            $message = $v_message;
            $status = 'error';
        }

        return compact(['plu', 'message', 'status']);
    }


    public function cek_bonus(Request $request)
    {
        $message = '';
        $status = '';
        $prd = [];
        $prd['qtypb'] = $request->qtypb;
        $c = loginController::getConnectionProcedure();


        $sql = "BEGIN sp_igr_bo_pb_cek_bonus2('" . $request->plu . "','" . $request->kdsup . "',to_date('" . $request->tgl . "','dd/mm/yyyy'),'" . $request->frac . "', :qtypb, :bonus1, :bonus2, :ppn, :ppnbm, :ppnbtl,:lok, :message);END;";

        $s = oci_parse($c, $sql);

        oci_bind_by_name($s, ':qtypb', $prd['qtypb'], 100);
        oci_bind_by_name($s, ':bonus1', $prd['bonus1'], 100);
        oci_bind_by_name($s, ':bonus2', $prd['bonus2'], 100);
        oci_bind_by_name($s, ':ppn', $prd['ppn'], 100);
        oci_bind_by_name($s, ':ppnbm', $prd['ppnbm'], 100);
        oci_bind_by_name($s, ':ppnbtl', $prd['ppnbtl'], 100);
        oci_bind_by_name($s, ':lok', $prd['v_oke'], 100);
        oci_bind_by_name($s, ':message', $v_message, 100);
        oci_execute($s);

        $message = $v_message;
        $status = 'error';
        return compact(['prd', 'message', 'status']);

    }

    public function save_data(Request $request)
    {
        $message = 'Data berhasil disimpan!';
        $status = 'success';
        $v_oke = '';
        $v_message = '';
        $gantiaku = 0;
        for ($i = 0; $i < sizeof($request->data['prdcd']); $i++) {
//            $request->data['gantiaku'][$i]="kosong";
            DB::table('tbtr_pb_d')
                ->insert(['PBD_KODEIGR' => $_SESSION['kdigr'],
                    'PBD_RECORDID' => '',
                    'PBD_NOPB' => $request->nopb,
                    'PBD_PRDCD' => $request->data['prdcd'][$i],
                    'PBD_KODEDIVISI' => $request->data['kodedivisi'][$i],
                    'PBD_KODEDIVISIPO' => $request->data['kodedivisipo'][$i],
                    'PBD_KODEDEPARTEMENT' => $request->data['kodedepartement'][$i],
                    'PBD_KODEKATEGORIBRG' => $request->data['kodekategoribrg'][$i],
                    'PBD_KODESUPPLIER' => $request->data['kodesupplier'][$i],
                    'PBD_NOURUT' => $request->data['nourut'][$i],
                    'PBD_QTYPB' => $request->data['qtypb'][$i],
                    'PBD_KODETAG' => '',
                    'PBD_QTYBPB' => $gantiaku,
                    'PBD_HRGSATUAN' => $request->data['hargasatuan'][$i],
                    'PBD_PERSENDISC1' => $request->data['persendisc1'][$i],
                    'PBD_RPHDISC1' => $request->data['rphdisc1'][$i],
                    'PBD_FLAGDISC1' => $request->data['flagdisc1'][$i],
                    'PBD_PERSENDISC2' => $request->data['persendisc2'][$i],
                    'PBD_RPHDISC2' => $request->data['rphdisc2'][$i],
                    'PBD_FLAGDISC2' => $request->data['flagdisc2'][$i],
                    'PBD_PERSENDISC2II' => '',
                    'PBD_RPHDISC2II' => '',
                    'PBD_PERSENDISC2III' => '',
                    'PBD_RPHDISC2III' => '',
                    'PBD_BONUSPO1' => Self::ceknull($request->data['bonuspo1'][$i], 0),
                    'PBD_BONUSPO2' => Self::ceknull($request->data['bonuspo2'][$i], 0),
                    'PBD_BONUSBPB1' => 0,
                    'PBD_BONUSBPB2' => 0,
                    'PBD_GROSS' => Self::ceknull($request->data['gross'][$i], 0),
                    'PBD_RPHTTLDISC' => 0,
                    'PBD_PPN' => $request->data['ppn'][$i],
                    'PBD_PPNBM' => $request->data['ppnbm'][$i],
                    'PBD_PPNBOTOL' => $request->data['ppnbotol'][$i],
                    'PBD_TOP' => $request->data['top'][$i],
                    'PBD_NOPO' => 0,
                    'PBD_OSTPB' => 0,
                    'PBD_OSTPO' => 0,
                    'PBD_PKMT' => $request->data['pkmt'][$i],
                    'PBD_SALDOAKHIR' => $request->data['saldoakhir'][$i],
                    'PBD_FDXREV' => $request->data['fdxrev'][$i],
                    'PBD_FLAGGUDANGPUSAT' => '',
                    'PBD_CREATE_BY' => $_SESSION['usid'],
                    'PBD_CREATE_DT' => DB::Raw('trunc(sysdate)'),
                    'PBD_MODIFY_BY' => $_SESSION['usid'],
                    'PBD_MODIFY_DT' => DB::Raw('trunc(sysdate)')]);
        }
        $pbh = DB::table('tbtr_pb_h')
            ->select('pbh_tglpb', 'pbh_tipepb', 'pbh_jenispb', 'pbh_flagdoc', 'pbh_keteranganpb', 'pbh_tgltransfer')
            ->where('pbh_kodeigr', $_SESSION['kdigr'])
            ->where('pbh_nopb', $request->nopb)
            ->first();

        $pbh_tgltransfer = '';
        $pbh_tipepb = '';
        if (!is_null($pbh)) {
            $pbh_tgltransfer = $pbh->pbh_tgltransfer;
            $pbh_tipepb = $pbh->pbh_tipepb;
        }
        if ($pbh_tgltransfer == '') {
            if ($pbh_tipepb == 'R') {
                $pbdsuppSub = DB::table('tbtr_pb_d')->join('tbmaster_supplier', 'pbd_kodesupplier', 'sup_kodesupplier')
                    ->selectRaw('pbd_nopb,
                                 pbd_kodesupplier,
                                 sup_minkarton,
                                 sup_minrph,
                                 SUM (pbd_qtypb) quantity,
                                 SUM (  pbd_gross + pbd_ppn + pbd_ppnbm + pbd_ppnbotol ) rupiah')
                    ->whereRaw('pbd_nopb =' .$request->nopb)
                    ->groupBy('pbd_nopb', 'pbd_kodesupplier', 'sup_minkarton', 'sup_minrph')
                    ->toSql();

                $pbdsupp = DB::table(DB::raw('(' . $pbdsuppSub . ') a'))
                    ->select('pbd_kodesupplier')
                    ->whereRaw('( a.quantity < a.sup_minkarton AND a.sup_minkarton <> 0 AND pbd_nopb = ' . $request->nopb . ' ) OR (a.rupiah < a.sup_minrph AND a.sup_minrph <> 0)')
                    ->toSql();
//                    ->first();

                $tolakanpb = DB::table('tbtr_tolakanpb')
                    ->select('tlk_prdcd')
                    ->whereRaw('TRUNC(tlk_tglpb) = TRUNC(to_date(\'' . $request->tglpb . '\',\'dd/mm/yyyy\'))')
                    ->toSql();

                $pbd = DB::table('tbtr_pb_d')
                    ->select('pbd_nopb',
                        'pbd_prdcd',
                        'pbd_kodedivisipo',
                        'pbd_kodedivisi',
                        'pbd_kodedepartement',
                        'pbd_kodekategoribrg',
                        'pbd_kodetag',
                        'pbd_qtypb',
                        'pbd_kodesupplier')
                    ->whereRaw('pbd_kodesupplier in('.$pbdsupp.')')
                    ->whereRaw('pbd_prdcd not in('.$tolakanpb.')')
                    ->whereRaw('pbd_nopb ='.$request->nopb)
                ->first();

                if(!is_null($pbd)) {
                    DB::table('tbtr_tolakanpb')
                        ->insert(['tlk_kodeigr' => $_SESSION['kdigr'],
                            'tlk_recordid' => '',
                            'tlk_nopb' => $pbd->pbd_nopb,
                            'tlk_tglpb' => $request->tglpb,
                            'tlk_prdcd' => $pbd->pbd_prdcd,
                            'tlk_kodedivisipo' => $pbd->pbd_kodedivisipo,
                            'tlk_kodedivisi' => $pbd->pbd_kodedivisi,
                            'tlk_kodedepartemen' => $pbd->pbd_kodedepartement,
                            'tlk_kodekategori' => $pbd->pbd_kodekategoribrg,
                            'tlk_kodetag' => $pbd->pbd_kodetag,
                            'tlk_qty' => $pbd->pbd_qtypb,
                            'tlk_kodesupplier' => $pbd->pbd_kodesupplier,
                            'tlk_keterangantolakan' => '< DARI MINOR CARTON/RP PER SUPPLIER',
                            'tlk_create_by' => $_SESSION['usid'],
                            'tlk_create_dt' => DB::raw('sysdate')]);
                }

//	  ----->>>> Detele PB Tolakan Item
                $deletein = DB::table('tbtr_tolakanpb')
                    ->select('tlk_prdcd')
                    ->whereRaw('tlk_nopb='. $request->nopb)
                    ->toSql();
                DB::table('TBTR_PB_D')
                    ->where('PBD_NOPB', '=', $request->nopb)
                    ->whereRaw('pbd_prdcd in('. $deletein . ')')
                    ->delete();
            }

            $pbcur = DB::table('TBTR_PB_H')
                ->select('PBH_NOPB')
                ->where('PBH_NOPB', '=', $request->nopb)
                ->first();

            if (!is_null($pbcur)) {
                DB::table('TBTR_PB_H')
                    ->where('PBH_NOPB', '=', $pbcur->pbh_nopb)
                    ->delete();
            }

//// ----->>>>> Save tbTr_PB_H <<<<<-------
            $pbd = DB::table('TBTR_PB_D')
                ->selectRaw('pbd_kodeigr,
                            pbd_recordid,
                            pbd_nopb,
                            SUM(NVL(pbd_qtypb,0)) pbd_qtypb,
                            SUM(NVL(pbd_qtybpb,0)) pbd_qtybpb,
                            SUM(NVL(pbd_bonuspo1,0)) pbd_bonuspo1,
                            SUM(NVL(pbd_bonuspo2,0)) pbd_bonuspo2,
                            SUM(NVL(pbd_bonusbpb1,0)) pbd_bonusbpb1,
                            SUM(NVL(pbd_bonusbpb2,0)) pbd_bonusbpb2,
                            SUM(NVL(pbd_gross,0)) pbd_gross,
                            SUM(NVL(pbd_rphttldisc,0)) pbd_rphttldisc,
                            SUM(NVL(pbd_ppn,0)) pbd_ppn,
                            SUM(NVL(pbd_ppnbm,0)) pbd_ppnbm,
                            SUM(NVL(pbd_ppnbotol,0)) pbd_ppnbotol')
                ->where('PBD_NOPB', '=', $request->nopb)
                ->groupBy('PBD_KODEIGR', 'PBD_RECORDID', 'PBD_NOPB')
                ->first();

            DB::table('tbtr_pb_h')
                ->insert(['PBH_KODEIGR' => $_SESSION['kdigr'],
                    'PBH_RECORDID' => '',
                    'PBH_NOPB' => $request->nopb,
                    'PBH_TGLPB' => DB::raw('to_date(\'' . $request->tglpb . '\',\'dd/mm/yyyy\')'),
                    'PBH_TIPEPB' => $request->typepb,
                    'PBH_JENISPB' => $request->flag,
                    'PBH_FLAGDOC' => '0',
                    'PBH_QTYPB' => $pbd->pbd_qtypb,
                    'PBH_QTYBPB' => $pbd->pbd_qtybpb,
                    'PBH_BONUSPO1' => $pbd->pbd_bonuspo1,
                    'PBH_BONUSPO2' => $pbd->pbd_bonuspo2,
                    'PBH_BONUSBPB1' => $pbd->pbd_bonusbpb1,
                    'PBH_BONUSBPB2' => $pbd->pbd_bonusbpb2,
                    'PBH_GROSS' => $pbd->pbd_gross,
                    'PBH_RPHTTLDISC' => $pbd->pbd_rphttldisc,
                    'PBH_PPN' => $pbd->pbd_ppn,
                    'PBH_PPNBM' => $pbd->pbd_ppnbm,
                    'PBH_PPNBOTOL' => $pbd->pbd_ppnbotol,
                    'PBH_KETERANGANPB' => $request->keterangan,
                    'PBH_TGLTRANSFER' => '',
                    'PBH_CREATE_BY' => $_SESSION['usid'],
                    'PBH_CREATE_DT' => DB::raw('trunc(sysdate)'),
                    'PBH_MODIFY_BY' => $_SESSION['usid'],
                    'PBH_MODIFY_DT' => DB::raw('trunc(sysdate)')]);
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
