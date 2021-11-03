<?php

namespace App\Http\Controllers\BACKOFFICE\TRANSAKSI\PENGELUARAN;

use App\Http\Controllers\Auth\loginController;
use App\Http\Controllers\Connection;
use Carbon\Carbon;
use Dompdf\Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;


class InputController extends Controller
{
    public function index()
    {
        return view('BACKOFFICE.TRANSAKSI.PENGELUARAN.input');
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
            ->limit(100)
            ->get();

        return Datatables::of($data)->make(true);
    }

    public function getNewNoTrn()
    {
        $message = '';
        $status = '';

        $model = "*TAMBAH*";
//        DB::select("delete from tbtr_usul_returlebih where usl_status <> 'SUDAH CETAK NOTA' and not exists (select 1 from tbtr_backoffice where usl_trbo_nodoc = trbo_nodoc) ");
        DB::table('tbtr_usul_returlebih')
            ->whereRaw('usl_status <> \'SUDAH CETAK NOTA\' and not exists (select 1 from tbtr_backoffice where usl_trbo_nodoc = trbo_nodoc)')
            ->delete();
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

            $c = loginController::getConnectionProcedure();
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
//
            $c = loginController::getConnectionProcedure();
            $s = oci_parse($c, "BEGIN SP_FILLTEMPRETUR_164(:sup,:pkp,'9999999',:errm); END;");
            oci_bind_by_name($s, ':sup', $supplier);
            oci_bind_by_name($s, ':pkp', $pkp);
            oci_bind_by_name($s, ':errm', $errm, 200);
            oci_execute($s);

//    -->>> alert untuk PLu BKP yg belum keluar tax3 nya <<<--

            $cek = DB::Select("SELECT DISTINCT BTB_PRDCD PLU, BTB_NODOC NODOC
                      FROM TBTR_MSTRAN_BTB, TBMASTER_PRODMAST
                     WHERE BTB_PRDCD = PRD_PRDCD
                       AND PRD_FLAGBKP1 = 'Y'
                       AND BTB_KODESUPPLIER = '" . $supplier . "'
                       AND NOT EXISTS (SELECT 1
                                         FROM TEMP_URUT_RETUR
                                        WHERE BTB_PRDCD = PRDCD)");

            if (sizeof($cek) > 0) {
                $p = '';
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

//            if ($d->trbo_istype != null && $data->bkp != null && $data->pkp == 'Y') {
//                $data->ppn = 10;
//            } else {
//                $data->ppn = 0;
//            }
            array_push($datas_detail, $data);
        }
        return compact(['datas_header', 'datas_detail', 'model', 'tgldoc', 'supplier', 'nmsupplier', 'pkp', 'message', 'status']);
    }

    public function getDataSupplier(Request $request)
    {
        $nodoc = '';
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
        $errm = '';
        $connect = loginController::getConnectionProcedure();

        $exec = oci_parse($connect, "BEGIN  SP_FILLTEMPRETUR_164(:kodesup,:pkp,'9999999',:errm); END;"); //Procedure asli diganti ke varchar
        oci_bind_by_name($exec, ':kodesup', $result->sup_kodesupplier);
        oci_bind_by_name($exec, ':pkp', $result->sup_pkp);
        oci_bind_by_name($exec, ':errm', $errm, 200);
        oci_execute($exec);
//        dd($errm);

        //    -->>> alert untuk PLu BKP yg belum keluar tax3 nya <<<--
        $cek = DB::Select("SELECT DISTINCT BTB_PRDCD PLU, BTB_NODOC NODOC
                      FROM TBTR_MSTRAN_BTB, TBMASTER_PRODMAST
                     WHERE BTB_PRDCD = PRD_PRDCD
                       AND PRD_FLAGBKP1 = 'Y'
                       AND BTB_KODESUPPLIER = '" . $result->sup_kodesupplier . "'
                       AND NOT EXISTS (SELECT 1
                                         FROM TEMP_URUT_RETUR
                                        WHERE BTB_PRDCD = PRDCD)");

        if (sizeof($cek) > 0) {
            $p = '';
//            $cek = $cek->distinct()->get();
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

    public function getDataLovPLU()
    {
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


    public function cekPCS1(Request $request)
    {
        $plu = $request->plu;
        $kdsup = $request->kdsup;

        try {
            $qtypb = DB::table('TEMP_URUT_RETUR')
                ->selectRaw('SUM (qtypb - (qtyretur + qtyhistretur)) AS qtypb')
                ->where('prdcd', '=', $plu)
                ->first();

            $qtypb = (int)$qtypb->qtypb;

            $qtyretur = DB::table('TEMP_URUT_RETUR')
                ->selectRaw('SUM (qtypb - qtyhistretur) AS qtyretur')
                ->where('prdcd', '=', $plu)
                ->first();

            $qtyretur = (int)$qtyretur->qtyretur;


            $qtybpb = DB::table('tbtr_mstran_btb')
                ->whereNotNull('btb_istype')
                ->whereNotNull('btb_invno')
                ->where('btb_kodesupplier', '=', $kdsup)
                ->where('btb_prdcd', '=', $plu)
                ->sum('btb_qty');
            $qtybpb = (int)$qtybpb;

            $qtyhretur = DB::table('tbhistory_retursupplier')
                ->selectRaw('nvl(sum (case when hsr_qtyretur > hsr_qtypb then hsr_qtypb else hsr_qtyretur end),0) qtyhretur')
                ->where('hsr_kodesupplier', '=', $kdsup)
                ->where('hsr_prdcd', '=', $plu)
                ->first();
            $qtyhretur = (int)$qtyhretur->qtyhretur;

            $qtysisa = $qtybpb - $qtyhretur;

            return compact(['qtypb', 'qtyretur', 'qtysisa']);

        } catch (\Exception $e) {
            return $e;
        }
    }

    public function cekPCS2(Request $request)
    {
        $message = '';
        $status = '';

        $plu = $request->plu;
        $kdsup = $request->kdsup;
        $nodoc = $request->nodoc;
        $tgldoc = $request->tgldoc;
        $bkp = $request->bkp;
        $inputan = $request->inputan;
        $qtyretur = $request->qtyretur;

        try {
            $temp = DB::table('tbtr_usul_returlebih')
                ->where('usl_kodeigr', '=', $_SESSION['kdigr'])
                ->where('usl_trbo_nodoc', '=', $nodoc)
                ->where('usl_prdcd', '=', $plu)
                ->count();
            if ($temp == 0) {
                DB::table('tbtr_usul_returlebih')->insert(['usl_kodeigr' => $_SESSION['kdigr'], 'usl_trbo_nodoc' => $nodoc, 'usl_trbo_tgldoc' => $tgldoc, 'usl_kodesupplier' => $kdsup, 'usl_prdcd' => $plu, 'usl_flagbkp' => $bkp, 'usl_qty_retur' => $inputan, 'usl_qty_sisaretur' => $qtyretur, 'usl_status' => 'USULAN', 'usl_create_by' => $_SESSION['usid'], 'usl_create_dt' => Carbon::now()]);
            } else {
                DB::table('tbtr_usul_returlebih')->where(['usl_kodeigr' => $_SESSION['kdigr'], 'usl_trbo_nodoc' => $nodoc, 'usl_trbo_tgldoc' => $tgldoc, 'usl_prdcd' => $plu])
                    ->update(['usl_qty_retur' => $inputan, 'usl_qty_sisaretur' => $qtyretur, 'usl_modify_by' => $_SESSION['usid'], 'usl_modify_dt' => Carbon::now()]);
            }
            return 'Cek PCS 2 OK';

        } catch (\Exception $e) {
            return $e;
        }

    }

    public function cekPCS3(Request $request)
    {
        $message = '';
        $status = '';

        $plu = $request->plu;
        $nodoc = $request->nodoc;

        $temp = DB::table('tbtr_usul_returlebih')
            ->where('usl_kodeigr', '=', $_SESSION['kdigr'])
            ->where('usl_trbo_nodoc', '=', $nodoc)
            ->where('usl_prdcd', '=', $plu)
            ->count();
        if ($temp > 0) {
            $status = 'question';
        }

        return compact(['message', 'status']);
    }

    public function cekPCS4(Request $request)
    {
        $message = '';
        $status = '';

        $plu = $request->plu;
        $nodoc = $request->nodoc;

        try {
            DB::table('tbtr_usul_returlebih')
                ->where('usl_kodeigr', '=', $_SESSION['kdigr'])
                ->where('usl_trbo_nodoc', '=', $nodoc)
                ->where('usl_prdcd', '=', $plu)
                ->delete();
            $message = 'Usulan retur berhasil dihapus!';
            $status = 'success';
        } catch (\Exception $e) {
            return $e;
        }
        return compact(['message', 'status']);
    }

    public function proses(Request $request)
    {

        $qty = $request->qtyretur;
        $plu = $request->p_prdcd;
        $nodoc = $request->nodoc;
        $pkp = $request->pkp;

        $no_bpb = '';
        $mintrn = '';
        $maxtrn = '';
        $trbo_discrph = '';
        $datas = [];

        $ppn = 0;
        $trbo_prdcd = '';
        $desk = '';
        $satuan = '';
        $bkp = '';
        $trbo_posqty = '';
        $trbo_hrgsatuan = '';
        $qtyctn = '';
        $qtypcs = '';
        $trbo_discrph = '';
        $trbo_istype = '';
        $trbo_invno = '';
        $trbo_tglinv = '';
        $trbo_noreff = '';

        try {
            $temp = DB::table('temp_urut_retur')
                ->where('prdcd', '=', $plu)
                ->count(1);

            if ($temp > 0) {
                $minmax = DB::table('temp_urut_retur')
                    ->selectRaw('MIN (TRN) min, MAX (TRN) max')
                    ->where('prdcd', '=', $plu)
                    ->first();

                $mintrn = $minmax->min;
                $maxtrn = $minmax->max;
            }
            $ke = $mintrn;
//        DB::table('temp_urut_retur')->where(['NODOC_BPB' => $no_bpb])
//            ->update(['nodoc_bo' => $nodoc]);

            for ($i = $mintrn; $i < $maxtrn; $i++) {
                $trbo = DB::table('tbtr_backoffice')
                    ->where('trbo_prdcd', '=', $plu)
                    ->where('trbo_typetrn', '=', 'K')
                    ->first();

                $trbo_discrph = 0;
                if ($trbo) {
                    $trbo_discrph = $trbo->trbo_discrph;
                }

                $res = DB::table('temp_urut_retur')
                    ->selectRaw("QTYPB, QTYHISTRETUR, NVL (NODOC_BPB, 'zz') NO_BPB, TGLINV, HRGSATUAN, NODOC_BO")
                    ->where('PRDCD', '=', $plu)
                    ->where('trn', '=', $ke)
                    ->first();
                $qty_pb = $res->qtypb;
                $qty_histretur = $res->qtyhistretur;
                $no_bpb = $res->no_bpb;
                $tgl_fps = $res->tglinv;
                $hrg_satuan = $res->hrgsatuan;
                $no_doc = $res->nodoc_bo;
                if ($qty_pb > $qty_histretur || $ke == $maxtrn) {

                    DB::Connection('simsmg')->raw('update temp_urut_retur set qtyretur = case when qty > (qty_pb - qty_histretur) and ke <> maxtrn then(qty_pb - qty_histretur) else qty end where prdcd = ' . $plu . ' and trn = ' . $ke . ' and nodoc_bpb = ' . $no_bpb);

                    $trbo_prdcd = $plu;
                    $res = DB::Connection('simsmg')->select("select prd_deskripsipanjang, prd_deskripsipendek, frac, prd_flagbkp1,
                   prd_avgcost, st_avgcost, nvl(st_saldoakhir, 0) st_saldoakhir, hrgsatuan, qtypb
              from tbmaster_prodmast, tbmaster_stock, temp_urut_retur
              where prd_prdcd = st_prdcd(+)
                and '02' =  st_lokasi(+)
                and prd_prdcd = " . $plu . "
                and prd_prdcd = prdcd
                and nvl(nodoc_bpb, 'zz') = " . $no_bpb);

                    $res = $res[0];
                    $deskripsi = $res->prd_deskripsipanjang;
                    $desk = $res->prd_deskripsipendek;
                    $frac = $res->frac;
                    $bkp = $res->prd_flagbkp1;
                    $acostprd = $res->prd_avgcost;
                    $acostst = $res->st_avgcost;
                    $trbo_posqty = $res->st_saldoakhir;
                    $trbo_hrgsatuan = $res->hrgsatuan;
                    $max_qty = $res->qtypb;

//                --++get unit from mstran btb
                    $temp = DB::table('tbtr_mstran_btb')
                        ->where('btb_prdcd', '=', $plu)
                        ->where('btb_nodoc', '=', $no_bpb)
                        ->count(1);

                    if ($temp > 0) {
                        $unit = DB::table('tbtr_mstran_btb')
                            ->select('btb_unit')
                            ->where('btb_prdcd', '=', $plu)
                            ->where('btb_nodoc', '=', $no_bpb)
                            ->first();
                        $unit = $unit->btb_unit;
                    }
                    $satuan = $unit . '/' . $frac;

                    $trbo_qty = db::table('temp_urut_retur')
                        ->select('qtyretur')
                        ->where('prdcd', '=', $plu)
                        ->where('trn', '=', $ke)
                        ->first();
                    $trbo_qty = $trbo_qty->qtyretur;
                    if ($unit == 'KG') {
                        $frac = 1;
                    }
                    $qtyctn = intval($trbo_qty / $frac);
                    $qtypcs = $trbo_qty % $frac;


                    if ($acostst == '' || $acostst == 0) {
                        $trbo_averagecost = $acostprd;
                    } else {
                        $trbo_averagecost = $acostst * $frac;
                    }

//            ---** hitung ppn ** ---
                    if ($pkp == 'Y' && $bkp == 'Y') {
                        $ppn = 10;
                    } else {
                        $ppn = 0;
                    }

                    $temp = DB::table('temp_urut_retur')
                        ->selectRaw('istype, invno, tglinv, qtypb, hrgsatuan, nodoc_bpb, nodoc_bo')
                        ->where('prdcd', '=', $plu)
                        ->where('trn', '=', $ke)
                        ->first();

                    $trbo_istype = $temp->istype;
                    $trbo_invno = $temp->invno;
                    $trbo_tglinv = $temp->tglinv;
                    $max_qty = $temp->qtypb;
                    $trbo_hrgsatuan = $temp->hrgsatuan;
                    $trbo_noreff = $temp->nodoc_bpb;
                    $trbo_nodo = $temp->nodoc_bo;

                    if ($trbo_invno == '' && $trbo_noreff != '') {
                        $message = 'no.faktur pajak untuk btb ' . $trbo_noreff . ' tidak ditemukan';
                        $status = 'warning';
                        return compact(['message', 'status']);
                    }

                    $trbo_discrph = DB::table('temp_urut_retur')
                        ->selectRaw('(discrphperpcs) * ((' . $qtyctn . ' * ' . $frac . ') + ' . $qtypcs . ') discrph')
                        ->where('prdcd', '=', $plu)
                        ->whereRaw("nvl(nodoc_bpb, 'zz') = nvl(" . $trbo_noreff . ", 'zz')")
                        ->first();

                    $trbo_discrph = $trbo_discrph->discrph;

                }

                $temp1 = 0;
                if ($ke == $maxtrn) {
                    $temp1 = $qty;
                } else {
                    if (($qty_pb - $qty_histretur) < 0) {
                        $temp1 = 0;
                    } else {
                        $temp1 = ($qty_pb - $qty_histretur);
                    }
                }
                $qty = $qty - $temp1;

//            VALIDATE_ITEM

                $trbo_gross = ($qtyctn * $trbo_hrgsatuan) + (($trbo_hrgsatuan / $frac) * $qtypcs);

                $trbo_discper = ($trbo_discrph / $trbo_gross) * 100;

                if ($trbo_discper > 0) {
                    $trbo_discrph = ($trbo_gross * $trbo_discper) / 100;
                }

                $trbo_ppnrph = (($trbo_gross - $trbo_discrph) * $ppn) / 100;


                $ke = $ke + 1;
//            $trbo_discper = ($trbo_discrph / $trbo->trbo_gross) * 100;

                if ($qty_pb > $qty_histretur) {
                    $data = (object)'';

                    $data->trbo_prdcd = $trbo->trbo_prdcd;
                    $data->desk = $desk;
                    $data->deskripsi = $deskripsi;
                    $data->satuan = $satuan;
                    $data->bkp = $bkp;
                    $data->trbo_posqty = $trbo_posqty;
                    $data->trbo_hrgsatuan = $trbo_hrgsatuan;
                    $data->qtyctn = $qtyctn;
                    $data->qtypcs = $qtypcs;
                    $data->trbo_gross = $trbo_gross;
                    $data->discper = $trbo_discper;
                    $data->trbo_discrph = $trbo_discrph;
                    $data->trbo_ppnrph = $trbo_ppnrph;
                    $data->trbo_istype = $trbo_istype;
                    $data->trbo_inv = $trbo_invno;
                    $data->trbo_tgl = $trbo_tglinv;
                    $data->trbo_noreff = $trbo_noreff;
                    $data->trbo_keterangan = $trbo->trbo_keterangan;
                    array_push($datas, $data);
                }
                if ($qty <= 0) {
                    break;
                }
            }
        } catch (Exception $exception) {
            return $exception;
        }
        return compact(['datas']);
    }


    public function ceknull(string $value, string $ret)
    {
        if ($value == "") {
            return $ret;
        }
        return $value;
    }

    public function delete(Request $request)
    {
        $nodoc = $request->nodoc;
        DB::table('TBTR_BACKOFFICE')
            ->where('TRBO_NODOC', '=', $nodoc)
            ->where('TRBO_TYPETRN', '=', 'K')
            ->delete();
        $message = 'Nodoc ' . $nodoc . ' Berhasil di hapus';
        $status = 'warning';
        return compact(['message', 'status']);
    }

    public function save(Request $request)
    {

        $trbo_kodeigr = $_SESSION['kdigr'];
        $trbo_typetrn = 'K';
        $trbo_flagdoc = 0;
        $trbo_create_by = $_SESSION['usid'];
        $trbo_create_dt = Carbon::now()->format('Y-m-d');
        DB::beginTransaction();
        foreach ($request->datas as $data)
            $temp = DB::table('TBTR_BACKOFFICE')
                ->where([
                    'trbo_kodeigr' => $trbo_kodeigr,
                    'trbo_nodoc' => $data['nodoc'],
                    'trbo_prdcd' => $data['plu']
                ])
                ->count();
        $avg_cost = DB::table('tbmaster_prodmast')
            ->select('prd_avgcost')
            ->where('prd_prdcd', '=', $data['plu'])
            ->first();
//        dd( Carbon::parse($data['tgldoc']));
        $avg_cost = $avg_cost->prd_avgcost;
        if ($temp > 0) {
            DB::table('TBTR_BACKOFFICE')
                ->where([
                    'trbo_kodeigr' => $trbo_kodeigr,
                    'trbo_nodoc' => $data['nodoc'],
                    'trbo_prdcd' => $data['plu']
                ])
                ->update([
                    'trbo_typetrn' => $trbo_typetrn,
                    'trbo_tgldoc' => Carbon::parse($data['tgldoc']),
                    'trbo_noreff' => $data['noreff'],
                    'trbo_istype' => $data['istype'],
                    'trbo_invno' => $data['invno'],
                    'trbo_tglinv' => $data['tglinv'],
                    'trbo_kodesupplier' => $data['kdsup'],
                    'trbo_qty' => $data['qty'],
                    'trbo_hrgsatuan' => $data['hargasatuan'],
                    'trbo_persendisc1' => $data['persendisc'],
                    'trbo_gross' => $data['gross'],
                    'trbo_discrph' => $data['discrph'],
                    'trbo_ppnrph' => $data['ppnrph'],
                    'trbo_averagecost' => $avg_cost,
                    'trbo_posqty' => $data['posqty'],
                    'trbo_flagdoc' => $trbo_flagdoc,
                    'trbo_create_by' => $trbo_create_by,
                    'trbo_create_dt' => $trbo_create_dt
                ]);
        } else {
            DB::table('TBTR_BACKOFFICE')->insert([
                'trbo_kodeigr' => $trbo_kodeigr,
                'trbo_nodoc' => $data['nodoc'],
                'trbo_prdcd' => $data['plu'],
                'trbo_typetrn' => $trbo_typetrn,
                'trbo_tgldoc' => Carbon::parse($data['tgldoc']),
                'trbo_noreff' => $data['noreff'],
                'trbo_istype' => $data['istype'],
                'trbo_invno' => $data['invno'],
                'trbo_tglinv' => $data['tglinv'],
                'trbo_kodesupplier' => $data['kdsup'],
                'trbo_qty' => $data['qty'],
                'trbo_hrgsatuan' => $data['hargasatuan'],
                'trbo_persendisc1' => $data['persendisc'],
                'trbo_gross' => $data['gross'],
                'trbo_discrph' => $data['discrph'],
                'trbo_ppnrph' => $data['ppnrph'],
                'trbo_averagecost' => $avg_cost,
                'trbo_posqty' => $data['posqty'],
                'trbo_flagdoc' => $trbo_flagdoc,
                'trbo_create_by' => $trbo_create_by,
                'trbo_create_dt' => $trbo_create_dt
            ]);
        }
        DB::commit();

        $message = 'Nodoc ' . $request->datas[0]['nodoc'] . ' Berhasil di simpan';
        $status = 'success';
        return compact(['message', 'status']);
    }

    public function getDataUsulan(Request $request)
    {
        $nodoc = $request->nodoc;
        $kdsup = $request->kdsup;

        $temp = DB::table('tbtr_usul_returlebih')
            ->where('usl_trbo_nodoc', '=', $nodoc)
            ->where('usl_kodesupplier', '=', $kdsup)
            ->count();

        if ($temp == 0) {
            $message = 'Tidak ada usulan retur lebih untuk dokumen ' . $nodoc;
            $status = 'info';
            return compact(['message', 'status']);
        }

        $dataUsulan = DB::table('tbtr_usul_returlebih')
            ->join('tbmaster_prodmast', 'usl_prdcd', '=', 'prd_prdcd')
            ->selectRaw('usl_kodeigr, usl_trbo_nodoc, usl_kodesupplier, usl_prdcd, prd_deskripsipanjang,
                        usl_qty_retur, usl_qty_sisaretur, usl_status')
            ->where('usl_trbo_nodoc', '=', $nodoc)
            ->where('usl_kodesupplier', '=', $kdsup)
            ->get();
        $usul_status = $dataUsulan[0]->usl_status;

        if ($usul_status == 'USULAN' || $usul_status == 'MENUNGGU KONFIRMASI') {
            $set_btn_send = 1;
        } else {
            $set_btn_send = 0;
        }

        if ($usul_status == 'MENUNGGU KONFIRMASI') {
            $set_input_text = 1;
        } else {
            $set_input_text = 1;
        }

        return compact(['dataUsulan']);
    }

    public function sendUsulan(Request $request)
    {

//	OTP_FIN;
        $ip = (int)(substr($request->nodoc, 1, 3));
        $doc = (int)(substr($request->nodoc, 5));
        $nodoc = $doc;
        $kdigr = (int)($_SESSION['kdigr']);
        $select = DB::Select("Select TO_NUMBER ( TRANSLATE ('" . $request->kdsup . "','0123456789' || TRANSLATE ( '" . $request->kdsup . "', 'x123456789', 'x'),'0123456789')) ret from dual");
        $kdsup = (int)$select[0]->ret;
        $splitted_tgldoc = explode('/', $request->tgldoc);
        $dd = (int)$splitted_tgldoc[0];
        $mm = (int)$splitted_tgldoc[1];

        $message = '';
        $status = '';

//        --DIGIT1
        $digit1 = $kdigr * $ip * $dd * $kdsup;
        $digit1 = floor(sqrt($digit1));
        $digit1 = Self::f_sum_digits($digit1);
        $digit1 = substr(($digit1), -1, 1);

//   --DIGIT2
        $digit2 = $kdigr * $doc * $mm * $kdsup;
        $digit2 = floor(sqrt($digit2));
        $digit2 = Self::f_sum_digits($digit2);
        $digit2 = substr(($digit2), -1, 1);

//        --digit3
        $digit3 = $kdigr * $kdsup * ($dd + $mm);
        $digit3 = floor(sqrt($digit3));
        $digit3 = Self::f_sum_digits($digit3);
        $digit3 = substr(($digit3), -1, 1);

//   --digit4
        $digit4 = $kdigr * $ip * $doc * $kdsup;
        $digit4 = floor(sqrt($digit4));
        $digit4 = Self::f_sum_digits($digit4);
        $digit4 = substr(($digit4), -1, 1);

//   --digit5
        $digit5 = $kdigr * $doc * $kdsup;
        $digit5 = floor(sqrt($digit5));
        $digit5 = Self::f_sum_digits($digit5);
        $digit5 = substr(($digit5), -1, 1);

//   --digit6
        $digit6 = $kdigr * $ip * $kdsup;
        $digit6 = floor(sqrt($digit6));
        $digit6 = Self::f_sum_digits($digit6);
        $digit6 = substr(($digit6), -1, 1);

//   --otp
        $otp = $digit1 . $digit2 . $digit3 . $digit4 . $digit5 . $digit6;

        $nodoc = $request->nodoc;
        $kdsup = $request->kdsup;
//        $tgldoc = date("m/d/Y", strtotime($request->tgldoc));
        $tgldoc = $request->tgldoc;
        $kdigr = $_SESSION['kdigr'];
        $errm = '';
        $c = loginController::getConnectionProcedure();
        $s = oci_parse($c, "BEGIN sp_usulanretur(:kodeigr,:nodoc,to_date('" . $tgldoc . "','dd/mm/yyyy'),:supplier,:otp,:userid,:errm); END;");
        oci_bind_by_name($s, ':kodeigr', $kdigr);
        oci_bind_by_name($s, ':nodoc', $nodoc);
//        oci_bind_by_name($s, ':tgldoc', $tgldoc);
        oci_bind_by_name($s, ':supplier', $kdsup);
        oci_bind_by_name($s, ':otp', $otp);
        oci_bind_by_name($s, ':userid', $_SESSION['usid']);
        oci_bind_by_name($s, ':errm', $errm, 200);

        oci_execute($s);

        if ($errm != '') {
            $message = $errm;
            $status = 'error';
            return compact(['message', 'status']);
        } else {
            $message = 'usulan retur sudah dikirm ke email finance';
            $status = 'info';
        }

        $status_usul = DB::table('tbtr_usul_returlebih')
            ->join('tbmaster_prodmast', 'usl_prdcd', '=', 'prd_prdcd')
            ->select('usl_status')
            ->where('usl_trbo_nodoc', '=', $nodoc)
            ->where('usl_kodesupplier', '=', $kdsup)
            ->distinct()
            ->first();

        $status_usul = $status_usul->usl_status;
        return compact(['message', 'status', 'status_usul']);
    }

    public function f_sum_digits($num)
    {
        $sum = 0;
        $rem = 0;
        for ($i = 0; $i <= strlen($num); $i++) {
            $rem = $num % 10;
            $sum = $sum + $rem;
            $num = $num / 10;
        }
        return $sum;
    }

    public function cekOTP(Request $request)
    {
        $datas = $request->datas;
        $datah = $request->datah;
        $datad = $request->datad;

        $ip = (int)(substr($request->nodoc, 1, 3));
        $doc = (int)(substr($request->nodoc, 5));
        $nodoc = $doc;
        $kdigr = (int)($_SESSION['kdigr']);
        $select = DB::Select("Select TO_NUMBER ( TRANSLATE ('" . $request->kdsup . "','0123456789' || TRANSLATE ( '" . $request->kdsup . "', 'x123456789', 'x'),'0123456789')) ret from dual");
        $kdsup = (int)$select[0]->ret;
        $splitted_tgldoc = explode('/', $request->tgldoc);
        $dd = (int)$splitted_tgldoc[0];
        $mm = (int)$splitted_tgldoc[1];

        $message = '';
        $status = '';

//        --DIGIT1
        $digit1 = $kdigr * $ip * $dd * $kdsup;
        $digit1 = floor(sqrt($digit1));
        $digit1 = Self::f_sum_digits($digit1);
        $digit1 = substr(($digit1), -1, 1);

//   --DIGIT2
        $digit2 = $kdigr * $doc * $mm * $kdsup;
        $digit2 = floor(sqrt($digit2));
        $digit2 = Self::f_sum_digits($digit2);
        $digit2 = substr(($digit2), -1, 1);

//        --digit3
        $digit3 = $kdigr * $kdsup * ($dd + $mm);
        $digit3 = floor(sqrt($digit3));
        $digit3 = Self::f_sum_digits($digit3);
        $digit3 = substr(($digit3), -1, 1);

//   --digit4
        $digit4 = $kdigr * $ip * $doc * $kdsup;
        $digit4 = floor(sqrt($digit4));
        $digit4 = Self::f_sum_digits($digit4);
        $digit4 = substr(($digit4), -1, 1);

//   --digit5
        $digit5 = $kdigr * $doc * $kdsup;
        $digit5 = floor(sqrt($digit5));
        $digit5 = Self::f_sum_digits($digit5);
        $digit5 = substr(($digit5), -1, 1);

//   --digit6
        $digit6 = $kdigr * $ip * $kdsup;
        $digit6 = floor(sqrt($digit6));
        $digit6 = Self::f_sum_digits($digit6);
        $digit6 = substr(($digit6), -1, 1);

//   --otp
        $otp = $digit1 . $digit2 . $digit3 . $digit4 . $digit5 . $digit6;
        if ($request->otp == $otp) {
            $usuls = DB::table('tbtr_usul_returlebih')
                ->join('tbmaster_prodmast', 'usl_prdcd', '=', 'prd_prdcd')
                ->selectRaw('usl_prdcd, usl_qty_retur')
                ->where('usl_trbo_nodoc', '=', $request->nodoc)
                ->get();

            $datahke = 0;
            foreach ($usuls as $usul) {
//                [[proses usulan]]
                while (1) {
                    if ($datah[$datahke]['plu'] == $usul->usl_prdcd)
                        $datah[$datahke]['ctn'] = round($usul->usl_qty_retur / $datah[$datahke]['frac']);
                    $datah[$datahke]['pcs'] = $usul->usl_qty_retur % $datah[$datahke]['frac'];

                    if ($datah[$datahke]['plu'] == $usul->usl_prdcd) {
                        break;
                    }
                    $datahke++;
                }

//    [HAPUS]
                $lastrecord = 0;
                if (isset($datad)) {
                    $lastrecord = sizeof($datad) - 1;
                }

                $j = 0;
                for ($i = 1; $i < $lastrecord; $i++) {
                    for ($j = 1; $j < $lastrecord; $j++) {
                        if ($datad[$j]->plu == $datah[$datahke]['plu']) {
                            array_splice($datad, $j, 1);
                        }
                    }
                }

                DB::Select('update temp_urut_retur set qtyretur = 0 where prdcd = ' . $datah[$i]->plu . ' or pluold = ' . $datah[$i]->plu . ' or exists (select 1 from tbtr_konversiplu where kvp_pluold = prdcd and kvp_plunew= ' . $datah[$i]->plu . ')');

                //====

                $PLU = $usul->usl_prdcd;

                $data_usuls = DB::table('temp_usul_retur')
                    ->where('prdcd', '=', $PLU)
                    ->orderBy('trn')
                    ->get();

                foreach ($data_usuls as $data_usul) {
                    $data = (object)'';

                    $NO_BPB = $data_usul->nodoc_bpb;
                    $data->prdcd = $PLU;

                    $res = DB::select("select prd_deskripsipanjang, prd_deskripsipendek, frac, prd_flagbkp1,prd_avgcost, st_avgcost, nvl(st_saldoakhir, 0) st_saldoakhir, hrgsatuan, qtypb from tbmaster_prodmast, tbmaster_stock, temp_urut_retur where prd_prdcd = st_prdcd(+) and '02' =  st_lokasi(+) and prd_prdcd = " . $PLU . " and prd_prdcd = prdcd and nvl(nodoc_bpb, 'zz') = " . $NO_BPB);

                    $data->deskripsi = $res[0]->prd_deskripsipanjang;
                    $data->desk = $res[0]->prd_deskripsipendek;
                    $data->frac = $res[0]->frac;
                    $data->bkp = $res[0]->prd_flagbkp1;
                    $data->acostprd = $res[0]->prd_avgcost;
                    $data->acostst = $res[0]->st_avgcost;
                    $data->trbo_posqty = $res[0]->st_saldoakhir;
                    $data->trbo_hrgsatuan = $res[0]->hrgsatuan;
                    $data->max_qty = $res[0]->qtypb;
//            --++Get Unit From mstran BTB
                    $temp = DB::table('tbtr_mstran_btb')
                        ->select('btb_unit')
                        ->where('btb_prdcd', '=', $PLU)
                        ->where('btb_nodoc', '=', $NO_BPB)
                        ->count();

                    if ($temp > 0) {
                        $unit = DB::table('tbtr_mstran_btb')
                            ->select('btb_unit')
                            ->where('btb_prdcd', '=', $PLU)
                            ->where('btb_nodoc', '=', $NO_BPB)
                            ->first();
                        $data->unit = $unit->btb_unit;
                    }


//            ----Get Unit From mstran BTB

                    $data->satuan = $data->unit . '/' . TO_CHAR($data->frac);
                    $data->trbo_qty = $data_usul->qtyretur;
                    $data->qtyctn = round($data->trbo_qty / $data->frac);
                    $data->qtypcs = $data->trbo_qty % $data->frac;

                    if ($data->acostst == '' || !isset($data->acostst) || $data->acostst == 0) {
                        $data->trbo_averagecost = $data->acostprd;
                    } else {
                        $data->trbo_averagecost = $data->acostst * $data->frac;
                    }

//            ---** Hitung PPN ** ---
                    if ($request->pkp == 'Y' AND $data->bkp == 'Y') {
                        $data->ppn = 10;
                    } else {
                        $data->ppn = 0;
                    }

                    $data->trbo_istype = $data_usul->istype;
                    $data->trbo_invno = $data_usul->invno;
                    $data->trbo_tglinv = $data_usul->tglinv;
                    $data->max_qty = $data_usul->qtybpb;
                    $data->trbo_hrgsatuan = $data_usul->hrgsatuan;
                    $data->trbo_noreff = $data_usul->nodoc_bpb;
                    $data->trbo_nodoc = $data_usul->nodoc_bo;


                    if (!isset($data->trbo_invno) && isset($data->trbo_noreff)) {
                        $message = 'No.Faktur Pajak Untuk BTB ' . $data->trbo_noreff . ' tidak ditemukan';
                        $status = 'error';
                    }


                    $data->trbo_discrph = ($data_usul->disrphperpcs) * (($data->qtyctn * $data->frac) + $data->qtypcs);

                    array_push($datad, $data);
                }


                DB::table('tbtr_usul_returlebih')
                    ->where('usl_kodeigr', '=', $_SESSION['kdigr'])
                    ->where('usl_trbo_nodoc', '=', $request->nodoc)
                    ->update(['usl_status' => 'USULAN DISETUJUI']);

                $message = 'Kode OTP yang dimasukkan berhasil.';
                $status = 'success';
                return compact(['message', 'status', 'datah', 'datad']);
            }
        } else {
            $message = 'Kode OTP yang dimasukkan salah, silahkan hubungi kembali finance HO';
            $status = 'error';
            return compact(['message', 'status']);
        }
    }

}
