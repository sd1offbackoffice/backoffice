<?php

namespace App\Http\Controllers\BACKOFFICE\TRANSAKSI\PENGELUARAN;

use App\Http\Controllers\Connection;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class inputController extends Controller
{
    public function index()
    {

        $nodoc = DB::table('TBTR_BACKOFFICE')
            ->select('trbo_nodoc','trbo_tgldoc',DB::raw('CASE
                                            WHEN TRBO_FLAGDOC=\'*\' THEN TRBO_NONOTA
                                            ELSE \'Belum Cetak Nota\' END NOTA'))
            ->where('TRBO_TYPETRN', '=', 'K')
            ->limit(100)
            ->orderBy('TRBO_NODOC', 'desc')
            ->distinct()->get()->toArray();

        $kdSup = DB::table('tbmaster_supplier')
            ->select('sup_namasupplier','sup_kodesupplier','sup_pkp')
            ->where('sup_kodeigr', '=', $_SESSION['kdigr'])
            //->limit(100)
            ->orderBy('sup_namasupplier', 'asc')
            ->get()->toArray();

       return view('BACKOFFICE/TRANSAKSI/PENGELUARAN.input')->with(compact(['nodoc','kdSup']));
    }

    public function getDataRetur(Request $pNodDoc)
    {
        $retur = [];
        $returHeader = [];
        $returDetail = [];
        $MODEL = '';
        $message = '';
        $status = '';

        $pIP = str_replace('.','0', SUBSTR($_SESSION['ip'],-3));

        if (is_null($pNodDoc->value)) {
            $MODEL = 'TAMBAH';

            $c = oci_connect($_SESSION['conUser'], $_SESSION['conPassword'], $_SESSION['conString']);

            $s = oci_parse($c, "BEGIN :ret := F_IGR_GET_NOMORSTADOC('" . $_SESSION['kdigr'] . "','RPB','Nomor Reff Pengeluaran Barang'," . $pIP . " || '2' , 6, FALSE); END;");
            oci_bind_by_name($s, ':ret', $r, 32);
            oci_execute($s);

            $retur['nodoc'] = $r;
            $retur['tgldoc'] = Carbon::now();

        } else {
            $retur = DB::table('TBTR_BACKOFFICE ')
                ->leftjoin('TBMASTER_SUPPLIER', 'TRBO_KODESUPPLIER', 'SUP_KODESUPPLIER')
                ->selectRaw('TRBO_NODOC as nodoc, TRBO_TGLDOC as tgldoc, TRBO_KODESUPPLIER as kdsup, SUP_NAMASUPPLIER as nmsup, SUP_PKP as pkp, NVL(TRBO_FLAGDOC, \'0\') as flagdoc')
                ->where('TRBO_KODEIGR', '=', $_SESSION['kdigr'])
                ->where('TRBO_NODOC', '=', $pNodDoc->value)
                ->where('TRBO_TYPETRN', '=', 'K')
                ->first();

            if (is_null($retur)) {
                $message = 'Nomor Dokumen Retur tidak ditemukan!';
                $status = 'error';
                return compact(['message', 'status']);
            }

            $FLAG = $retur->flagdoc;

            if ($FLAG == '*') {
                $MODEL = '* NOTA SUDAH DICETAK *';
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
                ->where('PBD_NOPB', $pNodDoc->value)
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
        //return compact(['pb', 'MODEL', 'pbd', 'message', 'status']);
        return compact(['retur','MODEL','message', 'status']);








    }

}
