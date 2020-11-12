<?php

namespace App\Http\Controllers\BACKOFFICE\TRANSAKSI\PENGELUARAN;

use App\Http\Controllers\Connection;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;


class InputController extends Controller
{
    public function index()
    {
        return view('BACKOFFICE/TRANSAKSI/PENGELUARAN.input');
    }

    public function getDataLovTrn()
    {
        $data = DB::table('TBTR_BACKOFFICE')
            ->select('trbo_nodoc', DB::raw('TO_CHAR(TRBO_TGLDOC, \'DD/MM/YYYY\') TRBO_TGLDOC'), DB::raw('CASE
                                            WHEN TRBO_FLAGDOC=\'*\' THEN TRBO_NONOTA
                                            ELSE \'Belum Cetak Nota\' END NOTA'))
            ->where('TRBO_TYPETRN', '=', 'K')
            ->orderBy('TRBO_NODOC', 'desc')
            ->distinct()->get();

        return Datatables::of($data)->make(true);
    }

    public function getDataLovSupplier()
    {
        $data = DB::table('tbmaster_supplier')
            ->select('sup_namasupplier', 'sup_kodesupplier', 'sup_pkp')
            ->where('sup_kodeigr', '=', $_SESSION['kdigr'])
            ->orderBy('sup_namasupplier', 'asc')
            ->get();

        return Datatables::of($data)->make(true);
    }

    public function getNewNoTrn()
    {
        $message = '';
        $status = '';

        DB::Raw('delete from tbtr_usul_returlebih
					where not exists (select 1 from tbtr_backoffice where usl_trbo_nodoc = trbo_nodoc)
				and usl_status <> \'SUDAH CETAK NOTA\';');

        $count = DB::table('tbtr_usul_returlebih')
            ->where('usl_status', '!=', 'SUDAH CETAK NOTA')
            ->count();

        if ($count > 0) {
            $message = 'Masih ada usulan retur lebih yang belum diselesaikan, harap selesaikan dahulu atau hapus dokumen bersangkutan!';
            $status = 'error';
            return compact(['message', 'status']);
        } else {
            $status = 'success';

            $ip = $_SESSION['ip'];

            $pIP = str_replace('.', '0', SUBSTR($_SESSION['ip'], -3));

            $c = oci_connect('SIMSMG', 'SIMSMG', '192.168.237.193:1521/SIMSMG');
            $s = oci_parse($c, "BEGIN :ret := F_IGR_GET_NOMORSTADOC('" . $_SESSION['kdigr'] . "','RPB','Nomor Reff Pengeluaran Barang'," . $pIP . " || '2' , 6, FALSE); END;");
            oci_bind_by_name($s, ':ret', $no, 32);
            oci_execute($s);

            $model = "*TAMBAH*";

            DB::table('tbtr_tac')
                ->where('tac_kodeigr', $_SESSION['kdigr'])
                ->where('tac_nodoc', $no)
                ->delete();
        }

        return compact(['no', 'model', 'status', 'message']);
    }

    public function getDataPengeluaran(Request $request)
    {
        $retur = [];
        $returHeader = [];
        $returDetail = [];

        $model = '';
        $tgldoc = '';
        $supplier = '';
        $nmsupplier = '';
        $pkp = '';
        $flagdoc = '';

        $message = '';
        $status = '';
        $notrn = $request->notrn;
        $kdsup = $request->kdsup;

        $datas = DB::table('TBTR_BACKOFFICE ')
            ->leftJoin('TBMASTER_SUPPLIER', 'TRBO_KODESUPPLIER', 'SUP_KODESUPPLIER')
            ->where('TRBO_KODEIGR', '=', $_SESSION['kdigr'])
            ->where('TRBO_NODOC', '=', $notrn)
            ->where('TRBO_TYPETRN', '=', 'K')
            ->orderBy('TRBO_SEQNO')
            ->distinct()
            ->get();

        foreach ($datas as $p) {
            $model = '* KOREKSI *';
            $tgldoc = date("d/m/Y", strtotime($p->trbo_tgldoc));
            $supplier = $p->trbo_kodesupplier;
            $nmsupplier = $p->sup_namasupplier;
            $pkp = $p->sup_pkp;

            $nofps = $p->trbo_istype;
            $nourutfps = $p->trbo_invno;
            $tglfps = date("d/m/Y", strtotime($p->trbo_tglinv));
            $flagdoc = $p->trbo_flagdoc;
            $nodoc = $p->trbo_nodoc;

        }

        if (Self::ceknull($flagdoc, '0') == '*') {
            $model = '* NOTA SUDAH DICETAK *';
        }

        $dh = DB::table("TBTR_BACKOFFICE")
            ->leftJoin('TBMASTER_PRODMAST', function ($join) {
                $join->on('TBMASTER_PRODMAST.PRD_KODEIGR', '=', 'TBTR_BACKOFFICE.TRBO_KODEIGR')
                    ->on('TBMASTER_PRODMAST.PRD_PRDCD', '=', 'TBTR_BACKOFFICE.TRBO_PRDCD');
            })
            ->leftJoin('TBMASTER_SUPPLIER', function ($join) {
                $join->on('TBMASTER_SUPPLIER.SUP_KODEIGR', '=', 'TBTR_BACKOFFICE.TRBO_KODEIGR')
                    ->on('TBMASTER_SUPPLIER.SUP_KODESUPPLIER', '=', 'TBTR_BACKOFFICE.TRBO_KODESUPPLIER');
            })
            ->select('TRBO_PRDCD',
                'PRD_DESKRIPSIPENDEK',
                DB::Raw("PRD_UNIT || '/' || PRD_FRAC SATUAN"),
                'PRD_FLAGBKP1',
                'TRBO_POSQTY',
                'PRD_FRAC',
                DB::Raw('SUM(TRBO_QTY) QTY'),
                'TRBO_KETERANGAN',
                'PRD_DESKRIPSIPANJANG',
                'PRD_UNIT',
                'SUP_PKP',
                'TRBO_DISCRPH',
                'TRBO_GROSS',
                'TRBO_ISTYPE',
                'TRBO_PPNRPH',
                'TRBO_HRGSATUAN',
                'TRBO_GROSS',
                'TRBO_PPNRPH',
                'TRBO_ISTYPE',
                'TRBO_INVNO',
                'TRBO_TGLINV',
                'TRBO_NOREFF',
                'TRBO_KETERANGAN'
            )
            ->where(
                [
                    'TRBO_KODEIGR' => $_SESSION['kdigr'],
                    'TRBO_NODOC' => $notrn,
                    'TRBO_TYPETRN' => 'K'
                ]
            )
            ->groupBy(
                [
                    'TRBO_PRDCD',
                    'PRD_DESKRIPSIPENDEK',
                    DB::Raw("PRD_UNIT || '/' || PRD_FRAC"),
                    'PRD_FLAGBKP1',
                    'TRBO_POSQTY',
                    'PRD_FRAC',
                    'TRBO_KETERANGAN',
                    'PRD_DESKRIPSIPANJANG',
                    'PRD_UNIT',
                    'SUP_PKP',
                    'TRBO_DISCRPH',
                    'TRBO_GROSS',
                    'TRBO_ISTYPE',
                    'TRBO_PPNRPH',
                    'TRBO_HRGSATUAN',
                    'TRBO_GROSS',
                    'TRBO_PPNRPH',
                    'TRBO_ISTYPE',
                    'TRBO_INVNO',
                    'TRBO_TGLINV',
                    'TRBO_NOREFF',
                    'TRBO_KETERANGAN'
                ]
            )
            ->orderBy('trbo_prdcd')
            ->distinct()
            ->get();

        //        $dh = DB::select("SELECT TRBO_PRDCD, PRD_DESKRIPSIPENDEK, PRD_UNIT || '/' || PRD_FRAC SATUAN,
//                             PRD_FLAGBKP1, TRBO_POSQTY, PRD_FRAC, SUM (TRBO_QTY) QTY,
//                             TRBO_KETERANGAN
//                        FROM TBTR_BACKOFFICE, TBMASTER_PRODMAST, TBMASTER_SUPPLIER
//                       WHERE TRBO_KODEIGR = PRD_KODEIGR(+)
//                         AND TRBO_PRDCD = PRD_PRDCD(+)
//                         AND TRBO_KODEIGR = SUP_KODEIGR(+)
//                         AND TRBO_KODESUPPLIER = SUP_KODESUPPLIER(+)
//                         AND TRBO_KODEIGR = " . $_SESSION['kdigr'] . "
//                         AND TRBO_NODOC = " . $notrn . "
//                         AND TRBO_TYPETRN = 'K'
//                    GROUP BY TRBO_PRDCD,
//                             PRD_DESKRIPSIPENDEK,
//                             PRD_UNIT || '/' || PRD_FRAC,
//                             PRD_FLAGBKP1,
//                             TRBO_POSQTY,
//                             PRD_FRAC,
//                             TRBO_KETERANGAN
//                    ORDER BY trbo_prdcd");

        $datas_header = [];
        foreach ($dh as $d) {
            $data = (object)'';

            $data->h_plu = $d->trbo_prdcd;
            $data->h_deskripsi = $d->prd_deskripsipendek;
            $data->h_satuan = $d->satuan;
            $data->h_bkp = $d->prd_flagbkp1;
            $data->h_stock = $d->trbo_posqty;
            $data->h_ctn = round($d->qty / $d->prd_frac);
            $data->h_pcs = $d->qty % $d->prd_frac;
            $data->h_frac = $d->prd_frac;
            $data->h_ket = $d->trbo_keterangan;

            array_push($datas_header, $data);
        }

        $datas_detail = [];
        foreach ($dh as $d) {
            $data = (object)'';

            $data->plu = $d->trbo_prdcd;
            $data->deskripsi = $d->prd_deskripsipanjang;
            $data->desk = $d->prd_deskripsipendek;
            $data->satuan = $d->satuan;
            $data->bkp = $d->prd_flagbkp1;
            $data->stok = $d->trbo_posqty;
            $data->hrgsatuan = $d->trbo_hrgsatuan;
            $data->ctn = round($d->qty / $d->prd_frac);
            $data->pcs = $d->qty % $d->prd_frac;
            $data->gross = $d->trbo_gross;
            $data->discper = ($d->trbo_discrph / $d->trbo_gross)*100;
            $data->discrp = $d->trbo_discrph;
            $data->ppn = $d->trbo_ppnrph;
            $data->faktur = $d->trbo_istype;
            $data->pajakno = $d->trbo_invno;
            $data->tglfp= $d->trbo_tglinv;
            $data->noreffbtb= $d->trbo_noreff;
            $data->keterangan= $d->trbo_keterangan;
            $data->pkp = $d->sup_pkp;
            $data->frac = $d->prd_frac;
            $data->unit = $d->prd_unit;

            if (trim($data->unit)) {
                $data->frac = 1;
            }

            if ($d->trbo_istype != null && $data->bkp != null && $data->pkp == 'Y') {
                $data->ppn = 10;
            }
            else{
                $data->ppn = 0;
            }
            array_push($datas_detail, $data);
        }
        return compact(['datas_header','datas_detail', 'model', 'tgldoc', 'supplier', 'nmsupplier', 'pkp', 'message', 'status']);
    }

    public function ceknull(string $value, string $ret)
    {
        if ($value == "") {
            return $ret;
        }
        return $value;
    }
}
