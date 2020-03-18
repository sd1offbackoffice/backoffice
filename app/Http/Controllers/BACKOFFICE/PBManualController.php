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
        $pb = DB::table('tbTr_PB_H')
            ->select('*')
            ->where('PBH_KodeIGR', '=', $_SESSION['kdigr'])
            ->limit(20)
            ->orderBy('pbh_nopb', 'desc')
            ->get()->toArray();
        return view('BACKOFFICE.PBManual')->with(compact('pb'));
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

    public function getDataPB(Request $request)
    {

        $MODEL = '';
        $pb = [];
        $pbd = [];
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

            $TGLPB = $pb->pbh_tglpb;
            $TIPE = $pb->pbh_tipepb;
            $FLAG = $pb->pbh_jenispb;
            $STATUS = $pb->pbh_flagdoc;
            $KET = $pb->pbh_keteranganpb;
            $TGLTRF = $pb->pbh_tgltransfer;

            if (!is_null($FLAG) OR !is_null($TGLTRF)) {
                $MODEL = 'PB SUDAH DICETAK / TRANSFER';
            } else {
                $MODEL = 'KOREKSI';
            }

            $pbd = DB::table('TBTR_PB_D')
                ->select('pbd_nopb', 'pbd_prdcd')
                ->where('pbd_kodeigr', $_SESSION['kdigr'])
                ->where('pbd_nopb', $request->value)
                ->orderBy('pbd_nourut', 'desc')
                ->get();

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
                ->selectRaw('DISTINCT pbd_nourut, PBD_PRDCD,PRD_DESKRIPSIPANJANG,PRD_DESKRIPSIPENDEK, PRD_KODEDIVISI, PRD_KODEDIVISIPO, PRD_KODEDEPARTEMENT, PRD_KODEKATEGORIBARANG, PRD_FRAC, PRD_UNIT,PRD_KODETAG,SUM(PBD_QTYPB) PBD_QTYPB,ST_SALDOAKHIR,PRD_FLAGBKP1,SUP_NAMASUPPLIER, 
                CASE WHEN NVL(PLUOMI,\' \')=\' \' THEN \'N\' ELSE \'Y\' END F_OMI, 
                CASE WHEN NVL(PLUIDM,\' \')=\' \' THEN \'N\' ELSE \'Y\' END F_IDM,
                NVL(MIN_MINORDER,0) vMinOrderMin,
                NVL(PRD_MINORDER,0) vMinOrderPrd,
                NVL(PRD_ISIBELI,1) vPrdisiBeli,
                PBD_FDXREV,PBD_HRGSATUAN,PBD_RPHDISC1,PBD_PERSENDISC1,PBD_RPHDISC2,PBD_PERSENDISC2,PBD_BONUSPO1,PBD_BONUSPO2,PBD_GROSS,PBD_PPN,PBD_PPNBM,PBD_PPN,PBD_PPNBOTOL')
                ->where('PBD_NOPB', '222003077')
                ->groupBy(DB::raw('pbd_nourut,PBD_PRDCD,PRD_DESKRIPSIPANJANG,PRD_DESKRIPSIPENDEK,PRD_KODEDIVISI, PRD_KODEDIVISIPO, PRD_KODEDEPARTEMENT, PRD_KODEKATEGORIBARANG, PRD_FRAC,PRD_UNIT,
                    PRD_KODETAG,ST_SALDOAKHIR,PRD_FLAGBKP1,SUP_NAMASUPPLIER,
                    CASE WHEN NVL(PLUOMI,\' \')=\' \' THEN \'N\' ELSE \'Y\' END,
                    CASE WHEN NVL(PLUIDM,\' \')=\' \' THEN \'N\' ELSE \'Y\' END,
                  NVL(MIN_MINORDER,0),NVL(PRD_MINORDER,0),NVL(PRD_ISIBELI,1),PBD_FDXREV,PBD_HRGSATUAN,PBD_RPHDISC1,PBD_PERSENDISC1,PBD_RPHDISC2,PBD_PERSENDISC2,PBD_BONUSPO1,PBD_BONUSPO2,PBD_GROSS,PBD_PPN,PBD_PPNBM,PBD_PPN,PBD_PPNBOTOL'))
                ->orderBy('pbd_nourut')
                ->get();
            for($i=0; $i<sizeof($pbd);$i++){
                if($pbd[$i]->vminordermin == 0){
                    if($pbd[$i]->vminorderprd == 0){
                        $pbd[$i]->minor = $pbd[$i]->vprdisibeli;
                    }
                    else{
                        $pbd[$i]->minor = $pbd[$i]->vminorderprd;
                    }
                }
                else{
                    $pbd[$i]->minor = $pbd[$i]->vminordermin;
                }
                $pbd[$i]->satuan = $pbd[$i]->prd_unit.'/'.$pbd[$i]->prd_frac;
                $pbd[$i]->qtyctn = round($pbd[$i]->pbd_qtypb/ $pbd[$i]->prd_frac);
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
        return compact(['pb', 'MODEL', 'pbd']);

    }
}