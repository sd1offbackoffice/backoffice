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

        $model = "*TAMBAH*";
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
            $model = "*TAMBAH*";
            $status = 'success';

            $ip = $_SESSION['ip'];

            $pIP = str_replace('.', '0', SUBSTR($_SESSION['ip'], -3));

            $c = oci_connect('SIMSMG', 'SIMSMG', '192.168.237.193:1521/SIMSMG');
            $s = oci_parse($c, "BEGIN :ret := F_IGR_GET_NOMORSTADOC('" . $_SESSION['kdigr'] . "','RPB','Nomor Reff Pengeluaran Barang'," . $pIP . " || '2' , 6, FALSE); END;");
            oci_bind_by_name($s, ':ret', $no, 32);
            oci_execute($s);


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
        } else {
            $errm = '';
            DB::CONNECTION('simsmg')
                ->SELECT(
                    "call SP_FILLTEMPRETUR_164('" . $supplier . "','" . $pkp . "','9999999','" . $errm . "');"
                );

//    -->>> alert untuk PLu BKP yg belum keluar tax3 nya <<<--
            $cek = DB::table('TBTR_MSTRAN_BTB ')
                ->join('TBMASTER_PRODMAST', 'BTB_PRDCD', 'PRD_PRDCD')
                ->where('PRD_FLAGBKP1', '=', 'Y')
                ->where('BTB_KODESUPPLIER', '=', $supplier)
                ->whereRaw('NOT EXISTS(SELECT 1 FROM TEMP_URUT_RETUR WHERE BTB_PRDCD = PRDCD)');

            if ($cek->count(1) > 0) {
                $p = '';
                $cek = $cek->distinct()->get();
                foreach ($cek as $c) {
                    $p = $p . ' - ' . $c->plu . ' (No.Doc:' . $c->nodoc . ')';
                }
                $p = SUBSTR($p, 4);
                $message = 'Info, Belum ada data tax3 untuk PLU ' . $p;
                $status = 'info';
            }

            $cek2 = DB::table('TEMP_URUT_RETUR ')->count();

            if ($cek2 == 0) {
                $message = 'Tidak ada data history penerimaan untuk Supplier ' . $supplier;
                $status = 'error';
                return compact(['message', 'status']);
            }

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
            $data->discper = ($d->trbo_discrph / $d->trbo_gross) * 100;
            $data->discrp = $d->trbo_discrph;
            $data->ppn = $d->trbo_ppnrph;
            $data->faktur = $d->trbo_istype;
            $data->pajakno = $d->trbo_invno;
            $data->tglfp = $d->trbo_tglinv;
            $data->noreffbtb = $d->trbo_noreff;
            $data->keterangan = $d->trbo_keterangan;
            $data->pkp = $d->sup_pkp;
            $data->frac = $d->prd_frac;
            $data->unit = $d->prd_unit;

            if (trim($data->unit)) {
                $data->frac = 1;
            }

            if ($d->trbo_istype != null && $data->bkp != null && $data->pkp == 'Y') {
                $data->ppn = 10;
            } else {
                $data->ppn = 0;
            }
            array_push($datas_detail, $data);
        }
        return compact(['datas_header', 'datas_detail', 'model', 'tgldoc', 'supplier', 'nmsupplier', 'pkp', 'message', 'status']);
    }

    public function getDataSupplier(Request $request)
    {
        $nodoc='';
        if ($request->kdsup == '') {
            $message = 'Kode Supplier Tidak Boleh Kosong';
            $status = 'error';
            return compact(['message', 'status']);
        }
        $temp = DB::table('tbtr_backoffice')
            ->select('sup_namasupplier', 'sup_kodesupplier', 'sup_pkp')
            ->where('trbo_kodeigr', '=', $_SESSION['kdigr'])
            ->where('trbo_kodesupplier', '=', $request->kdsup)
            ->where('trbo_typetrn', '=', 'K')
            ->whereRaw('trunc(trbo_tgldoc) = trunc(sysdate)')
            ->whereNull('trbo_recordid')
            ->count();
        if ($temp > 0) {
            $message = 'Masih ada inputan Retur Supplier ' . $request->kdsup . ', yang belum cetak nota.';
            $status = 'info';

        }


        $result = DB::table('tbmaster_supplier')
            ->select('sup_namasupplier', 'sup_kodesupplier', 'sup_pkp')
            ->where('sup_kodeigr', '=', $_SESSION['kdigr'])
            ->where('sup_kodesupplier', '=', $request->kdsup)
            ->first();

        if (!isset($result)) {
            $message = 'Kode Supplier Tidak Terdaftar!';
            $status = 'error';
            return compact(['message', 'status']);
        }
        $errm='';

        $connect = oci_connect($_SESSION['conUser'], $_SESSION['conPassword'], $_SESSION['conString']);

        $exec = oci_parse($connect, "BEGIN  SP_FILLTEMPRETUR_164(:kodesup,:pkp,'9999999',:errm); END;"); //Procedure asli diganti ke varchar
        oci_bind_by_name($exec, ':kodesup',$result->sup_kodesupplier);
        oci_bind_by_name($exec, ':pkp',$result->sup_pkp);
        oci_bind_by_name($exec, ':errm',$errm,200);
        oci_execute($exec);

    //    -->>> alert untuk PLu BKP yg belum keluar tax3 nya <<<--
        $cek = DB::table('TBTR_MSTRAN_BTB ')
            ->join('TBMASTER_PRODMAST', 'BTB_PRDCD', 'PRD_PRDCD')
            ->where('PRD_FLAGBKP1', '=', 'Y')
            ->where('BTB_KODESUPPLIER', '=', $result->sup_kodesupplier)
            ->whereRaw('NOT EXISTS(SELECT 1 FROM TEMP_URUT_RETUR WHERE BTB_PRDCD = PRDCD)');

        if ($cek->count(1) > 0) {
            $p = '';
            $cek = $cek->distinct()->get();
            foreach ($cek as $c) {
                $p = $p . ' - ' . $c->plu . ' (No.Doc:' . $c->nodoc . ')';
            }
            $p = SUBSTR($p, 4);
            $message = 'Info, Belum ada data tax3 untuk PLU ' . $p;
            $status = 'info';
        }

        $cek2 = DB::table('TEMP_URUT_RETUR ')->count();

        if ($cek2 == 0) {
            $message = 'Tidak ada data history penerimaan untuk Supplier ' . $result->sup_kodesupplier;
            $status = 'error';
            return compact(['message', 'status']);
        }

        return compact(['result']);
    }

    public function getDataLovPLU(Request $request)
    {
        $search = strtoupper($request->search);

        $result = DB::table('tbmaster_prodmast')
            ->select('prd_prdcd', 'prd_deskripsipanjang')
            ->whereRaw("SUBSTR(PRD_PRDCD,7,1)='0'")
            ->whereRaw("nvl(prd_recordid,'9')<>'1'")
            ->orderBy('prd_prdcd')
            ->get();

        return Datatables::of($result)->make(true);
    }

    public function getDataPLU(Request $request)
    {
        $message = '';
        $status = '';

        $plu = $request->plu;
        $kdsup = $request->kdsup;
        if (!isset($plu)) {
            $message = 'PLU tidak Boleh kosong';
            $status = 'error';
            return compact(['message', 'status']);
        }

        $result = DB::table('TBMASTER_PRODMAST')
            ->leftJoin('TBMASTER_STOCK', function ($join) {
                $join->on('TBMASTER_STOCK.ST_PRDCD', '=', 'TBMASTER_PRODMAST.PRD_PRDCD')
                    ->on('TBMASTER_STOCK.ST_LOKASI', '=', DB::raw('02'));
            })
            ->join('TEMP_URUT_RETUR', 'PRD_PRDCD', '=', 'PRDCD')
            ->selectRaw("PRD_DESKRIPSIPANJANG, PRD_DESKRIPSIPENDEK, PRD_FRAC, PRD_UNIT, PRD_FLAGBKP1,
               PRD_AVGCOST, ST_AVGCOST, NVL (ST_PRDCD, 'XXXXXXX') ST_PRDCD, NVL (ST_SALDOAKHIR, 0) ST_SALDOAKHIR, QTYPB")
            ->where('PRD_PRDCD', '=', $plu)
            ->where('KSUP', '=', $kdsup)
            ->get();

        if (sizeof($result) == 0) {
            $message = 'Kode Produk [' . $plu . '] tidak terdaftar untuk Supplier ' . $kdsup . ' / Penerimaan terakhir sudah lewat 1 tahun';
            $status = 'error';
            return compact(['message', 'status']);
        }

        $result = $result[0];
        if ($result->st_prdcd == 'XXXXXXX') {
            $message = 'PLU [' . $plu . ']  ini belum melakukan perubahan status';
            $status = 'error';
            return compact(['message', 'status']);
        } else {
            if ($result->st_prdcd <= 0) {
                $message = 'Stock Barang Rusak PLU [' . $plu . '] <= 0';
                $status = 'error';
            }
            $result->satuan = $result->prd_unit . '/' . $result->prd_frac;
        }

        $cekRetur = DB::table('tbmaster_prodmast')
            ->join('tbhistory_retursupplier', 'PRD_PRDCD', '=', 'hsr_prdcd')
            ->where('prd_kodedivisi', '=', '3')
            ->where('prd_kodedepartement', '=', '29')
            ->where('prd_kodekategoribarang', '=', '06')
            ->where('prd_prdcd', '=', $plu)
            ->count();
        if ($cekRetur > 0) {
            $message = 'PLU [' . $plu . ']  sudah pernah diretur';
            $status = 'error';
        }
        return compact(['result', 'message', 'status']);;
    }

    public function ceknull(string $value, string $ret)
    {
        if ($value == "") {
            return $ret;
        }
        return $value;
    }
}
