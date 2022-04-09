<?php

namespace App\Http\Controllers\BACKOFFICE;

use App\Http\Controllers\Auth\loginController;
use App\Http\Controllers\MASTER\departementController;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller; use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use PDF;

class ReorderPBGOController extends Controller
{
    //

    public function index(){
        return view('BACKOFFICE.ReorderPBGO');
    }

    public function proses_go(){
        $cek = DB::connection(Session::get('connection'))->table('temp_go')
            ->select('isi_toko','per_awal_reorder','per_akhir_reorder')
            ->where('kodeigr',Session::get('kdigr'))
            ->first();

        $now = Carbon::now('Asia/Jakarta');

        if($cek->isi_toko != 'Y' || ($cek->isi_toko == 'Y' && ($now < $cek->per_awal_reorder || $now > $cek->per_akhir_reorder))){
            $status = 'error';
            $title = 'Program tidak bisa dijalankan, sudah lewat masa GO!';
            $message = '';
            return compact(['status','title','message']);
        }

        $insert_temp_pbprint = [];
        $where = '';

        $prs = DB::connection(Session::get('connection'))->table('tbmaster_perusahaan')
            ->selectRaw('prs_periodeterakhir, prs_nilaippn')
            ->where('prs_kodeigr',Session::get('kdigr'))
            ->first();

        $TGLAKHIR = $prs->prs_periodeterakhir;

        if($prs->prs_nilaippn == 0){
            $NILAIPPN = 1.1;
        }
        else $NILAIPPN = $prs->prs_nilaippn;

        $c = loginController::getConnectionProcedure();
        $s = oci_parse($c, "BEGIN :ret := F_IGR_GET_NOMOR('".Session::get('kdigr')."','PB','Nomor Permintaan Barang',".Session::get('kdigr')." || TO_CHAR(SYSDATE, 'yyMM'),3,FALSE); END;");
        oci_bind_by_name($s, ':ret', $r, 32);
        oci_execute($s);

        $NOPB = $r;

        $oke = false;

        $pb = DB::connection(Session::get('connection'))->table('tbtr_po_d')
            ->join('tbmaster_prodmast','tpod_prdcd','prd_prdcd')
            ->join('tbtr_po_h','tpod_nopo','tpoh_nopo')
            ->join('tbtr_mstran_h','tpoh_nopo','msth_nopo')
            ->leftJoin('tbmaster_tag','prd_kodetag','tag_kodetag')
            ->join('tbmaster_hargabeli','hgb_prdcd','prd_prdcd')
            ->join('tbmaster_supplier','sup_kodesupplier','hgb_kodesupplier')
            ->join('tbmaster_stock',function($join){
                $join->on('st_prdcd',DB::connection(Session::get('connection'))->raw("SUBSTR(prd_prdcd,1,6) || '0'"));
                $join->where('st_lokasi','01');
            })
            ->where('tpod_kodeigr',Session::get('kdigr'))
            ->whereRaw("((NVL (TPOD_QTYPB, 0) = 0) OR ((NVL(TPOD_QTYPO, 0) - NVL(TPOD_QTYPB, 0)) <> 0))")
            ->whereRaw("NVL (TPOD_KODETAG, 'Z') <> '*'")
            ->whereRaw("NVL (PRD_FLAGBARANGORDERTOKO, 'Z') <> 'Y'")
            ->whereRaw("SUBSTR (PRD_KODEKATEGORIBARANG, 1, 1) <> 'C'")
            ->whereRaw("NVL(MSTH_RECORDID,'0') <> '1'")
            ->whereRaw("NVL (HGB_RECORDID, 'zzz') = 'zzz'")
                ->whereRaw("(nvl(tag_tidakbolehorder,'N') <> 'Y' or nvl(prd_kodetag,'1') = '1' or prd_kodetag = '' or prd_kodetag = ' ')")
            ->orderBy('tpod_prdcd')
            ->orderBy('tpoh_kodesupplier')
            ->get();

        $data['prdcd'] = '';

        $tambah = 0;

        if(count($pb) == 0){
            $status = 'error';
            $title = 'Gagal melakukan proses reorder GO!';
            $message = 'Data tidak ditemukan!';
            return compact(['status','title','message']);
        }

        foreach($pb as $b){
            $QTYA = Self::nvl($b->tpod_qtypo, 0) - Self::nvl($b->tpod_qtypb, 0);

            if($QTYA % $b->prd_isibeli != 0)
                $QTYA = ($b->prd_isibeli * round($QTYA / $b->prd_isibeli)) + $b->prd_isibeli;

            $V_FMJTOP = $b->hgb_top;
            $V_FMTIPE = $b->hgb_tipe;
            $V_FMQBL1 = $b->hgb_qtymulai1bonus01;
            $V_FMBTM2 = $b->hgb_tglmulaibonus02;
            $V_FMRCID = $b->hgb_recordid;
            $V_FMQBL2 = $b->hgb_qtymulai2bonus01;
            $V_FMBTA2 = $b->hgb_tglakhirbonus02;
            $V_FMKSUP = $b->hgb_kodesupplier;
            $V_FMQBL3 = $b->hgb_qtymulai3bonus01;
            $V_FMKLP2 = $b->hgb_flagkelipatanbonus02;
            $V_FMBELI = $b->hgb_hrgbeli;
            $V_FMQBL4 = $b->hgb_qtymulai4bonus01;
            $V_FMQPB1 = $b->hgb_qtymulai1bonus02;
            $V_FMDIRP = $b->hgb_persendisc01;
            $V_FMQBL5 = $b->hgb_qtymulai5bonus01;
            $V_FMQPB2 = $b->hgb_qtymulai2bonus02;
            $V_FMDIRR = $b->hgb_rphdisc01;
            $V_FMQBL6 = $b->hgb_qtymulai6bonus01;
            $V_FMQPB3 = $b->hgb_qtymulai3bonus02;
            $V_FMDIRS = $b->hgb_flagdisc01;
            $V_FMQBS1 = $b->hgb_qty1bonus01;
            $V_FMQBN1 = $b->hgb_qty1bonus02;
            $V_FMPPNB = $b->hgb_ppnbm;
            $V_FMQBS2 = $b->hgb_qty2bonus01;
            $V_FMQBN2 = $b->hgb_qty2bonus02;
            $V_FMNBTL = $b->hgb_ppnbotol;
            $V_FMQBS3 = $b->hgb_qty3bonus01;
            $V_FMQBN3 = $b->hgb_qty3bonus02;
            $V_FMBNTM = $b->hgb_tglmulaibonus01;
            $V_FMQBS4 = $b->hgb_qty4bonus01;
            $V_FMDITM = $b->hgb_tglmulaidisc02;
            $V_FMBNTA = $b->hgb_tglakhirbonus01;
            $V_FMQBS5 = $b->hgb_qty5bonus01;
            $V_FMDITA = $b->hgb_tglakhirdisc02;
            $V_FMKLPT = $b->hgb_flagkelipatanbonus01;
            $V_FMQBS6 = $b->hgb_qty6bonus01;
            $V_FMDITP = $b->hgb_persendisc02;
            $V_FMDITR = $b->hgb_rphdisc02;

            $V_FTOP = $b->sup_flagopentop;
            $V_KPKN = $b->sup_kondisipbykonsinyasi;
            $V_KPKR = $b->sup_kondisipbykredit;
            $V_PKP =  $b->sup_pkp;
            $V_MINR = $b->sup_minrph;
            $V_MINC = $b->sup_minkarton;

            if($b->prd_frac == 1000 && $b->prd_unit = 'KG')
                $FDHSATA = $V_FMBELI * 1;
            else $FDHSATA = $V_FMBELI * $b->prd_frac;

            if($V_FMDIRP != 0){
                $FDDIS1A = $V_FMDIRP;
                $FDDIR1A = 0;
                $FDFDI1A = null;
            }
            else{
                $FDDIS1A = 0;
                $FDDIR1A = $V_FMDIRR;
                $FDFDI1A = $V_FMDIRS;
            }

            if($b->prd_frac == 1000 && $b->prd_unit == 'KG'){
                $PPMA = $V_FMPPNB * 1;
                $BTLA = $V_FMNBTL * 1;
            }
            else{
                $PPMA = $V_FMPPNB * $b->prd_frac;
                $BTLA = $V_FMNBTL * $b->prd_frac;
            }

            $FDBNS1A = 0;
            $FDBNS2A = 0;


            $now = Carbon::now('Asia/Jakarta');
            if($V_FMBNTM <= $now &&  $V_FMBNTA >= $now && $V_FMBNTA != null){
                if($V_FMKLPT == 'Y'){
                    if(Self::nvl($QTYA, 0) >= Self::nvl($V_FMQBL1, 0)) {
                        $FDBNS1A = round(Self::nvl($QTYA, 0) / Self::nvl($V_FMQBL1, 0)) * Self::nvl($V_FMQBS1, 0);
                    }
                }
                else{
                    if($QTYA >= $V_FMQBL1 && $QTYA < $V_FMQBL2)
                        $FDBNS1A = Self::nvl($V_FMQBS1, 0);
                    else if($QTYA >= $V_FMQBL2 && $QTYA < $V_FMQBL3)
                        $FDBNS1A = Self::nvl($V_FMQBS2, 0);
                    else if($QTYA >= $V_FMQBL3 && $QTYA < $V_FMQBL4)
                        $FDBNS1A = Self::nvl($V_FMQBS3, 0);
                    else if($QTYA >= $V_FMQBL4 && $QTYA < $V_FMQBL5)
                        $FDBNS1A = Self::nvl($V_FMQBS4, 0);
                    else if($QTYA >= $V_FMQBL5 && $QTYA < $V_FMQBL6)
                        $FDBNS1A = Self::nvl($V_FMQBS5, 0);
                    else if($QTYA >= $V_FMQBL6)
                        $FDBNS1A = Self::nvl($V_FMQBS6, 0);
                }
            }

            if($V_FMBTM2 <= $now && $V_FMBTA2 >= $now && $V_FMBTA2 != null){
                if($V_FMKLP2 == 'Y'){
                    if($QTYA >= $V_FMQPB1){
                        $FDBNS2A = round(Self::nvl($QTYA,0) / Self::nvl($V_FMQPB1,0)) * Self::nvl($V_FMQBN1,0);
                    }
                }
                else{
                    if($QTYA >= $V_FMQPB1 && $QTYA < $V_FMQPB2)
                        $FDBNS2A = Self::nvl($V_FMQBN1,0);
                    else if($QTYA >= $V_FMQPB2 && $QTYA < $V_FMQPB3)
                        $FDBNS2A = Self::nvl($V_FMQBN2,0);
                    else if($QTYA >= $V_FMQPB3)
                        $FDBNS2A = Self::nvl($V_FMQBN3,0);
                }
            }

            if($V_FTOP == 'Y'){
                $FDJTOPA = Self::nvl($V_FMJTOP,0);
            }
            else{
                if($V_KPKN != null)
                    $FDJTOPA = Self::nvl($V_KPKN,0);
                else $FDJTOPA = Self::nvl($V_KPKR,0);
            }

            $FDDIS2A = 0;
            $FDDISRA = 0;

            if($TGLAKHIR >= $V_FMDITM && $TGLAKHIR <= $V_FMDITA){
                $FDDIS2A = Self::nvl($V_FMDITP,0);
                $FDDISRA= Self::nvl($V_FMDITR,0);
            }

            $FDQTYBA = round($QTYA / $b->prd_frac);
            $FDQTYKA = $QTYA % $b->prd_frac;

            $FDTNILA = (($FDQTYBA * $FDHSATA) + ($FDQTYKA / $b->prd_frac * $FDHSATA)) - ((($FDQTYBA * $FDHSATA) + ($FDQTYKA / $b->prd_frac * $FDHSATA)) * $FDDIS1A / 100);

            $FDTNILA = $FDTNILA - ($FDTNILA * ($FDDIS2A / 100));

            if($FDDIR1A != null){
                if($FDFDI1A == 'K')
                    $FDTNILA = $FDTNILA - ($FDDIR1A * (($FDQTYBA * $b->prd_frac) + $FDQTYKA));
                else $FDTNILA = $FDTNILA - ($FDDIR1A * $FDQTYBA);
            }

            if($FDDISRA != null){
                if($FDFDI1A == 'K')
                    $FDTNILA = $FDTNILA - ($FDDISRA * (($FDQTYBA * $b->prd_frac) + $FDQTYKA));
                else $FDTNILA = $FDTNILA - ($FDDISRA * $FDQTYBA);
            }

            if($b->prd_flagbkp1 == 'Y' && $V_PKP == 'Y')
                $FDTPPNA = $FDTNILA * $NILAIPPN - $FDTNILA;
            else $FDTPPNA = 0;

            $FDTPPMA = ($PPMA * $FDQTYBA) + ($FDQTYKA / $b->prd_frac * $PPMA);
            $FDTBTLA = ($BTLA * $FDQTYBA) + ($FDQTYKA / $b->prd_frac * $BTLA);


            $TEMP_RECID = null;

            if($b->prd_frac == 1000 && $b->prd_unit == 'KG')
                $TEMP_FRAC = 1;
            else $TEMP_FRAC = $b->prd_frac;

            $V_STQTY = $b->st_saldoakhir;

            if($data['prdcd'] == $b->tpod_prdcd){
                $data['recid'] = $TEMP_RECID;
                $data['qty'] += Self::nvl($QTYA, 0);
                $data['discr1'] += Self::nvl($FDDIR1A, 0);
                $data['discr2'] += Self::nvl($FDDISRA, 0);
                $data['bnspo1'] += Self::nvl($FDBNS1A, 0);
                $data['bnspo2'] += Self::nvl($FDBNS2A, 0);
                $data['gross'] += Self::nvl($FDTNILA, 0);
                $data['ppn'] += Self::nvl($FDTPPNA, 0);
                $data['ppnbm'] += Self::nvl($FDTPPMA, 0);
                $data['botol'] += Self::nvl($FDTBTLA, 0);
            }
            else{
                if($data['prdcd'] != ''){
                    array_push($insert_temp_pbprint, $data);
                }
                $data['recid'] = $TEMP_RECID;
                $data['docno'] = $NOPB;
                $data['tgl'] = $TGLAKHIR;
                $data['prdcd'] = $b->prd_prdcd;
                $data['dept'] = $b->prd_kodedepartement;
                $data['katb'] = $b->prd_kodekategoribarang;
                $data['div'] =     $b->prd_kodedivisi;
                $data['divpo'] = $b->prd_kodedivisipo;
                $data['qty'] = Self::nvl($QTYA, 0);
                $data['price'] = $FDHSATA;
                $data['discp1'] = $FDDIS1A;
                $data['discr1'] = $FDDIR1A;
                $data['fdisc1'] = $FDFDI1A;
                $data['discp2'] = $FDDIS2A;
                $data['discr2'] = $FDDISRA;
                $FDFDISA = null;
                $data['fdisc2'] = $FDFDISA;
                $data['bnspo1'] = $FDBNS1A;
                $data['bnspo2'] = $FDBNS2A;
                $data['gross'] = $FDTNILA;
                $data['cterm'] = $FDJTOPA;
                $data['ppn'] = $FDTPPNA;
                $data['ppnbm'] = $FDTPPMA;
                $data['botol'] = $FDTBTLA;
                $data['supco'] = $V_FMKSUP;
                $data['minr'] = $V_MINR;
                $data['minc'] = $V_MINC;
                $data['out_po'] = 0;
                $data['out_pb'] = 0;
                $data['fdqebt'] = $V_STQTY;
                $data['ptag'] = $b->prd_kodetag;
                $data['fdxrev'] = 'T';
            }

            $where .= "(tpod_nopo = '".$b->tpod_nopo."' and tpod_prdcd = '".$b->tpod_prdcd."') or ";
            $tambah++;
        }

        if(count($pb) == 1)
            array_push($insert_temp_pbprint, $data);

        $where = substr($where,0,-4);

        $xya = DB::connection(Session::get('connection'))->table('tbtr_po_d')
            ->where('tpod_kodeigr',Session::get('kdigr'))
            ->whereRaw("(NVL (TPOD_QTYPB, 0) = 0) OR ((NVL(TPOD_QTYPO, 0) - NVL(TPOD_QTYPB, 0)) <> 0)")
            ->whereRaw("NVL (TPOD_KODETAG, 'Z') <> '*'")
            ->orderBy('tpod_prdcd')
            ->limit(1000)
            ->get();

        try{
            DB::connection(Session::get('connection'))->beginTransaction();
            DB::connection(Session::get('connection'))->table('temp_pbprint')
                ->insert($insert_temp_pbprint);
        }
        catch (QueryException $e){
            DB::connection(Session::get('connection'))->rollBack();
            $title = 'Gagal melakukan proses reorder GO!';
            $status = 'error';
            $message = $e->getMessage();
            return compact(['status','title','message']);
        }

        try{
            DB::connection(Session::get('connection'))->table('tbtr_po_d')
                ->select('tpod_nopo','tpod_prdcd')
                ->whereRaw($where)
                ->update([
                    'tpod_kodetag' => '*',
                    'tpod_pdate' => Carbon::now()
                ]);
        }
        catch (QueryException $e){
            DB::connection(Session::get('connection'))->rollBack();
            $title = 'Gagal melakukan proses reorder GO!';
            $message = $e->getMessage();
            $status = 'error';
            return compact(['status','title','message']);
        }

        $pbprint = DB::connection(Session::get('connection'))->table('temp_pbprint')
            ->where('recid',null)
            ->whereRaw(DB::connection(Session::get('connection'))->raw("TRUNC(tgl) = TRUNC(to_date('".$TGLAKHIR."','YYYY-MM-DD  HH24:MI:SS'))"))
            ->where('docno',$NOPB)
            ->orderBy('supco')
            ->get();

        if(!$pbprint){
            $status = 'error';
            $message = 'Tidak ada yang dapat diproses!';
            return compact(['status','message']);
        }
        else{
            $c = loginController::getConnectionProcedure();
            $s = oci_parse($c, "BEGIN :ret := F_IGR_GET_NOMOR('".Session::get('kdigr')."','PB','Nomor Permintaan Barang',".Session::get('kdigr')." || TO_CHAR(SYSDATE, 'yyMM'),3,TRUE); END;");
            oci_bind_by_name($s, ':ret', $r, 32);
            oci_execute($s);

            $NOPB = $r;

            $oke = true;

            $supco = [];
            $prdcd = [];

            foreach($pbprint as $pb){
                $FDKSUPA = $pb->supco;
                $QTYMINB = $pb->minc;
                $RPHMINB = $pb->minr;

                $QTYMINA = 0;
                $RPHMINA = 0;

                if(($pb->qty < $pb->minc && $pb->minc != null) || ($pb->gross + $pb->ppn + $pb->ppnbm + $pb->botol < $pb->minr && $pb->minr != null)){
                    array_push($supco,$pb->supco);
                    array_push($prdcd,$pb->prdcd);
                }
            }

            $y = DB::connection(Session::get('connection'))->table('temp_pbprint')
                ->whereRaw(DB::connection(Session::get('connection'))->raw("TRUNC(tgl) = TRUNC(to_date('".$TGLAKHIR."','YYYY-MM-DD  HH24:MI:SS'))"))
                ->where('docno',$NOPB)
                ->whereIn('supco',$supco)
                ->whereIn('prdcd',$prdcd)
                ->update([
                    'recid' => '3'
                ]);
        }


        $pbmast = DB::connection(Session::get('connection'))->table('temp_pbprint')
            ->whereRaw("recid is null")
            ->whereRaw(DB::connection(Session::get('connection'))->raw("TRUNC(tgl) = TRUNC(to_date('".$TGLAKHIR."','YYYY-MM-DD  HH24:MI:SS'))"))
            ->where('docno',$NOPB)
            ->get();

        $insert_tbtr_pb_d = [];

        $nourut = 0;
        $insert_tbtr_pb_h['pbh_qtypb'] = 0;
        $insert_tbtr_pb_h['pbh_bonuspo1'] = 0;
        $insert_tbtr_pb_h['pbh_bonuspo2'] = 0;
        $insert_tbtr_pb_h['pbh_gross'] = 0;
        $insert_tbtr_pb_h['pbh_ppn'] = 0;
        $insert_tbtr_pb_h['pbh_ppnbm'] = 0;
        $insert_tbtr_pb_h['pbh_ppnbotol'] = 0;

        foreach($pbmast as $pbm){
            $nourut++;
            $data_tbtr_pb_d['pbd_kodeigr'] = Session::get('kdigr');
            $data_tbtr_pb_d['pbd_nopb'] = $NOPB;
            $data_tbtr_pb_d['pbd_prdcd'] = $pbm->prdcd;
            $data_tbtr_pb_d['pbd_kodedepartement'] = $pbm->dept;
            $data_tbtr_pb_d['pbd_kodekategoribrg'] = $pbm->katb;
            $data_tbtr_pb_d['pbd_kodedivisi'] = $pbm->div;
            $data_tbtr_pb_d['pbd_kodedivisipo'] = $pbm->divpo;
            $data_tbtr_pb_d['pbd_qtypb'] = $pbm->qty;
            $data_tbtr_pb_d['pbd_nourut'] = $nourut;
            $data_tbtr_pb_d['pbd_hrgsatuan'] = $pbm->price;
            $data_tbtr_pb_d['pbd_persendisc1'] = $pbm->discp1;
            $data_tbtr_pb_d['pbd_rphdisc1'] = $pbm->discr1;
            $data_tbtr_pb_d['pbd_flagdisc1'] = $pbm->fdisc1;
            $data_tbtr_pb_d['pbd_persendisc2'] = $pbm->discp2;
            $data_tbtr_pb_d['pbd_rphdisc2'] = $pbm->discr2;
            $data_tbtr_pb_d['pbd_flagdisc2'] = $pbm->fdisc2;
            $data_tbtr_pb_d['pbd_bonuspo1'] = $pbm->bnspo1;
            $data_tbtr_pb_d['pbd_bonuspo2'] = $pbm->bnspo2;
            $data_tbtr_pb_d['pbd_gross'] = $pbm->gross;
            $data_tbtr_pb_d['pbd_top'] = $pbm->cterm;
            $data_tbtr_pb_d['pbd_ppn'] = $pbm->ppn;
            $data_tbtr_pb_d['pbd_ppnbm'] = $pbm->ppnbm;
            $data_tbtr_pb_d['pbd_ppnbotol'] = $pbm->botol;
            $data_tbtr_pb_d['pbd_kodesupplier'] = $pbm->supco;
            $data_tbtr_pb_d['pbd_kodetag'] = $pbm->ptag;
            $data_tbtr_pb_d['pbd_ostpo'] = $pbm->out_po;
            $data_tbtr_pb_d['pbd_ostpb'] = $pbm->out_pb;
            $data_tbtr_pb_d['pbd_create_dt'] = Carbon::now();
            $data_tbtr_pb_d['pbd_create_by'] = Session::get('usid');
            $data_tbtr_pb_d['pbd_fdxrev'] = 'T';

            $insert_tbtr_pb_h['pbh_qtypb'] += $pbm->qty;
            $insert_tbtr_pb_h['pbh_bonuspo1'] += $pbm->bnspo1;
            $insert_tbtr_pb_h['pbh_bonuspo2'] += $pbm->bnspo2;
            $insert_tbtr_pb_h['pbh_gross'] += $pbm->gross;
            $insert_tbtr_pb_h['pbh_ppn'] += $pbm->ppn;
            $insert_tbtr_pb_h['pbh_ppnbm'] += $pbm->ppnbm;
            $insert_tbtr_pb_h['pbh_ppnbotol'] += $pbm->botol;

            array_push($insert_tbtr_pb_d,$data_tbtr_pb_d);
        }

        $insert_tbtr_pb_h['pbh_kodeigr'] = Session::get('kdigr');
        $insert_tbtr_pb_h['pbh_tipepb'] = 'R';
        $insert_tbtr_pb_h['pbh_nopb'] = $NOPB;
        $insert_tbtr_pb_h['pbh_tglpb'] = $TGLAKHIR;
        $insert_tbtr_pb_h['pbh_keteranganpb'] = 'PB REORDER';
        $insert_tbtr_pb_h['pbh_create_by'] = Session::get('usid');
        $insert_tbtr_pb_h['pbh_create_dt'] = Carbon::now();

        try{
            DB::connection(Session::get('connection'))->table('tbtr_pb_d')
                ->insert($insert_tbtr_pb_d);
            DB::connection(Session::get('connection'))->table('tbtr_pb_h')
                ->insert($insert_tbtr_pb_h);
        }
        catch(QueryException $e){
            DB::connection(Session::get('connection'))->rollBack();
            $title = 'Gagal melakukan proses reorder GO!';
            $status = 'error';
            $message = $e->getMessage();
            return compact(['status','title','message']);
        }

        $temp_tolak2 = DB::connection(Session::get('connection'))->table('temp_pbprint')
            ->where('recid','2')
            ->where('docno',$NOPB)
            ->get();

        $temp_tolak3 = DB::connection(Session::get('connection'))->table('temp_pbprint')
            ->where('recid','3')
            ->where('docno',$NOPB)
            ->get();

        if($oke == true){
            DB::connection(Session::get('connection'))->commit();
            $status = 'success';
            $title = 'Berhasil melakukan reorder GO!';
            $message = 'No. Dokumen ini adalah : '.$NOPB;

            if(count($temp_tolak2) > 0)
                $tolak2 = true;
            else $tolak2 = false;

            if(count($temp_tolak3) > 0)
                $tolak3 = true;
            else $tolak3 = false;

            return compact(['status','title','message','NOPB','tolak2','tolak3']);
        }
    }

    public function cetak_tolakan(){
        $recid = $_GET['recid'];
        $nopb = $_GET['nopb'];

        if($recid == 2){
            $title = '** DAFTAR TOLAKAN P.B. YANG DIBAWAH MINIMUM ORDER **';
        }
        else if($recid == 3){
            $title = '** DAFTAR TOLAKAN P.B. YANG DIBAWAH MINIMUM RUPIAH/CARTON **';
        }

        $perusahaan = DB::connection(Session::get('connection'))->table('tbmaster_perusahaan')
            ->where('prs_kodeigr',Session::get('kdigr'))
            ->first();

        $tolakan = DB::connection(Session::get('connection'))->table('temp_pbprint')
            ->join('tbmaster_prodmast','prdcd','prd_prdcd')
            ->selectRaw("prdcd,
            SUBSTR(PRD_DeskripsiPanjang,1,48) prd_desk,
            PRD_unit||'/'||PRD_frac prd_satuan,
            PRD_KodeTag,
            nvl(ROUND(fdqebt/PRD_Frac),'0') stok_qtyb,
            nvl(MOD(fdqebt, PRD_Frac),'0') stok_qtyk,
            nvl(ROUND(PRD_MinOrder/PRD_Frac),'0') minorder_qtyb,
            nvl(MOD(PRD_MinOrder, PRD_Frac),'0') minorder_qtyk,
            nvl(ROUND(fdmaxt/PRD_Frac),'0') max_qtyb,
            nvl(MOD(fdmaxt,PRD_Frac),'0') max_qtyk,
            nvl(ROUND(fdmint/PRD_Frac),'0') min_qtyb,
            nvl(MOD(fdmint, PRD_Frac),'0') min_qtyk,
            nvl(ROUND(out_po/PRD_Frac),'0') po_qtyb,
            nvl(MOD(out_po,PRD_Frac),'0') po_qtyk,
            nvl(ROUND(out_pb/PRD_Frac),'0') pb_qtyb,
            nvl(MOD(out_pb,PRD_Frac),'0') pb_qtyk")
            ->where('recid',$recid)
            ->where('docno',$nopb)
            ->get();
//        dd($tolakan);


        $data = [
            'title' => $title,
            'tolakan' => $tolakan,
            'perusahaan' => $perusahaan,
        ];

        $now = Carbon::now('Asia/Jakarta');
        $now = date_format($now, 'd-m-Y H-i-s');

        $dompdf = new PDF();

        $pdf = PDF::loadview('BACKOFFICE.ReorderPBGO-laporan-tolakan', $data);

        error_reporting(E_ALL ^ E_DEPRECATED);

        $pdf->output();
        $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);

        $canvas = $dompdf ->get_canvas();
        $canvas->page_text(509, 77.75, "Page {PAGE_NUM} dari {PAGE_COUNT}", null, 8, array(0, 0, 0));

        $dompdf = $pdf;

        // (Optional) Setup the paper size and orientation
        //        $dompdf->setPaper('a4', 'landscape');

        // Render the HTML as PDF

        return $dompdf->stream('Laporan Tolakan PB ' . $nopb . '.pdf');
    }

    public function nvl($value, $defaultvalue){
        if($value == null || $value == '')
            return $defaultvalue;
        else return $value;
    }

}

