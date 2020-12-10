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
            ->limit(100)
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
            $c = oci_connect('SIMSMG', 'SIMSMG', '192.168.237.193:1521/SIMSMG');
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
//        $connect = oci_connect($_SESSION['conUser'], $_SESSION['conPassword'], $_SESSION['conString']);
//
//        $exec = oci_parse($connect, "BEGIN  SP_FILLTEMPRETUR_164(:kodesup,:pkp,'9999999',:errm); END;"); //Procedure asli diganti ke varchar
//        oci_bind_by_name($exec, ':kodesup', $result->sup_kodesupplier);
//        oci_bind_by_name($exec, ':pkp', $result->sup_pkp);
//        oci_bind_by_name($exec, ':errm', $errm, 200);
//        oci_execute($exec);
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
            $trbo_discrph = $trbo->trbo_discrph;

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
                if ($pkp == 'y' && $bkp == 'y') {
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

            $ke = $ke + 1;
            $trbo_discper = ($trbo_discrph / $trbo->trbo_gross) * 100;

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
                $data->trbo_gross = $trbo->trbo_gross;
                $data->discper = $trbo_discper;
                $data->trbo_discrph = $trbo_discrph;
                $data->trbo_ppnrph = $trbo->trbo_ppnrph;
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
        DB::table('tbTr_BackOffice')
            ->where('TRBO_NODOC', '=', $nodoc)
            ->where('TRBO_TYPETRN', '=', 'K')
            ->delete();
        $message = 'Nodoc ' . $nodoc . ' Berhasil di hapus';
        $status = 'warning';
        return compact(['message', 'status']);
    }

//    public function cekPCS(Request $request)
//    {
//        $message = '';
//        $status = '';
//
//        $plu = $request->plu;
//        $kdsup = $request->kdsup;
//        $model = $request->model;
//        $pcs = $request->pcs;
//        $ctn = $request->ctn;
//        $frac = $request->frac;
//        $stock = $request->stock;
//        $nodoc = $request->nodoc;
//        $tgldoc = $request->tgldoc;
//        $bkp = $request->bkp;
//        $pkp = $request->pkp;
//
//        //UI
//        if ($model == 'KOREKSI') {
//            return;
//        }
//
//        //UI
//        if (($ctn * $frac) + $pcs <= 0) {
//            $message = 'QTYB + QTYK <= 0';
//            $status = 'error';
//            return compact(['message', 'status']);
//        } else {
//            if ($stock < ($ctn * $frac) + $pcs) {
//                $inputan = ($ctn * $frac) + $pcs;
//                $message = 'Stock Barang Retur (' . $stock . ') < INPUTAN (' . $inputan . ') [set ctn pcs 0]';
//                $status = 'error';
//                return compact(['message', 'status']);
//            }
////            get from db step 1
//            $qtypb = DB::table('TEMP_URUT_RETUR')
//                ->selectRaw('SUM (qtypb - (qtyretur + qtyhistretur)) AS qtypb')
//                ->where('prdcd', '=', $plu)
//                ->first();
//
//            $qtypb = $qtypb->qtypb;
//
//            $qtyretur = DB::table('TEMP_URUT_RETUR')
//                ->selectRaw('SUM (qtypb - qtyhistretur) AS qtytretur')
//                ->where('prdcd', '=', $plu)
//                ->first();
//
//            $qtyretur = $qtyretur->qtyretur;
//
//            $qtysisa = DB::CONNECTION('simsmg')
//                ->selectRaw('SELECT qtybpb-qtyhretur qtysisa
//			  FROM (SELECT nvl(SUM (btb_qty),0) qtybpb
//			          FROM TBTR_MSTRAN_BTB
//			         WHERE BTB_ISTYPE || BTB_INVNO IS NOT NULL
//                        AND BTB_KODESUPPLIER = :supplier
//                        AND btb_prdcd = ' . $plu . '),
//			       (SELECT nvl(SUM (
//			                  CASE
//			                     WHEN hsr_qtyretur > hsr_qtypb THEN hsr_qtypb
//			                     ELSE hsr_qtyretur
//			                  END),0)
//			                  qtyhretur
//			          FROM tbhistory_retursupplier
//			         WHERE hsr_KODESUPPLIER = ' . $kdsup . ' AND hsr_prdcd = ' . $plu . ')');
////            end of step 1
//
//            // UI
//            $inputan = ($ctn * $frac) + $pcs;
//            if ($inputan > $qtyretur && $qtysisa > $qtyretur) {
//                if ($inputan > $qtysisa) {
//                    $message = 'qty PLU yang bisa diretur hanya ' . $qtysisa . ' [set ctn pcs 0]';
//                    $status = 'info';
//                    return compact(['message', 'status']);
//                }
//
//                $message = 'Qty yang diretur ('
//                    . $inputan
//                    . ') tidak boleh lebih dari '
//                    . $qtyretur
//                    . ', untuk sisanya silahkan buat Struk Penjualan atau minta otorisasi Finance.'
//                    . 'Proses untuk otorisasi Finance?';
//                $status = 'question';
//
//                $confirm = 'OK';
//                if ($confirm == 'OK') {
//                    if ($inputan > $qtysisa) {
//                        $inputan = $qtysisa;
//                        $message = 'Qty yang bisa diretur hanya '
//                            . $qtysisa;
//                        $status = 'warning';
//                    }
////                    get data from db step 2
//                    $temp = DB::table('tbtr_usul_returlebih')
//                        ->where('usl_kodeigr', '=', $_SESSION['kdigr'])
//                        ->where('usl_trbo_nodoc', '=', $nodoc)
//                        ->where('usl_prdcd', '=', $plu)
//                        ->count();
//                    if ($temp == 0) {
//                        DB::table('tbtr_usul_returlebih')->insert(['usl_kodeigr' => $_SESSION['kdigr'], 'usl_trbo_nodoc' => $nodoc, 'usl_trbo_tgldoc' => $tgldoc, 'usl_kodesupplier' => $kdsup, 'usl_prdcd' => $plu, 'usl_flagbkp' => $bkp, 'usl_qty_retur' => $inputan, 'usl_qty_sisaretur' => $qtyretur, 'usl_status' => 'USULAN', 'usl_create_by' => $_SESSION['usid'], 'usl_create_dt' => Carbon::now()]);
//                    } else {
//                        DB::table('tbtr_usul_returlebih')->where(['usl_kodeigr' => $_SESSION['kdigr'], 'usl_trbo_nodoc' => $nodoc, 'usl_trbo_tgldoc' => $tgldoc, 'usl_prdcd' => $plu])
//                            ->update(['usl_qty_retur' => $inputan, 'usl_qty_sisaretur' => $qtyretur, 'usl_modify_by' => $_SESSION['usid'], 'usl_modify_dt' => Carbon::now()]);
//                    }
////                    end of step 2
//                    $ctn = 0;
//                    $pcs = $qtyretur;
//                    $message = 'PLU masuk usulan retur, qty yang ditampilkan, hanya qty yang bisa diretur. Bila ingin retur melebihi batas, masuk ke menu USULAN RETUR';
//                    $status = 'info';
//                } else {
//                    $pcs = 0;
//                    $ctn = 0;
//                    return compact(['message', 'status']);
//                }
//            } else {
////                step 3
//                $temp = DB::table('tbtr_usul_returlebih')
//                    ->where('usl_kodeigr', '=', $_SESSION['kdigr'])
//                    ->where('usl_trbo_nodoc', '=', $nodoc)
//                    ->where('usl_prdcd', '=', $plu)
//                    ->count();
////                end of step 3
//                if ($temp > 0) {
//                    $message = 'Hapus usulan retur lebih?';
//                    $status = 'question';
//                    $confirm = 'OK';
//                    if ($confirm == 'OK') {
////                        step4
//                        DB::table('tbtr_usul_returlebih')
//                            ->where('usl_kodeigr', '=', $_SESSION['kdigr'])
//                            ->where('usl_trbo_nodoc', '=', $nodoc)
//                            ->where('usl_prdcd', '=', $plu)
//                            ->delete();
////                        end of step 4
//                    }
//
//                }
//            }
//            if ($inputan > $qtyretur && $qtysisa == $qtyretur) {
//                $ctn = 0;
//                $pcs = $qtyretur;
//                $message = 'qty plu yang bisa diretur hanya ' . $qtyretur;
//                $status = 'info';
//                return compact(['message', 'status']);
//            }
//            if ($model == '* tambah *' || $model == '* koreksi *') {
//                Self::proses($plu, ($ctn * $frac) + $pcs);
//            }
//
//        }
//
//
//        return compact(['result', 'message', 'status']);
//    }

}
