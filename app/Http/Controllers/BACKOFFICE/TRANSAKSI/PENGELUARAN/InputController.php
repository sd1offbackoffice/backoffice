<?php

namespace App\Http\Controllers\BACKOFFICE\TRANSAKSI\PENGELUARAN;

use App\Http\Controllers\Auth\loginController;
use App\Http\Controllers\Connection;
use Carbon\Carbon;
use Dompdf\Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller; use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;


class InputController extends Controller
{
    // public function index()
    // {
    //     return view('BACKOFFICE.TRANSAKSI.PENGELUARAN.input-new');
    // }
    public function index()
    {
        return view('BACKOFFICE.TRANSAKSI.PENGELUARAN.input');
    }

    public function getDataLovTrn()
    {
        $data = DB::connection(Session::get('connection'))->table('TBTR_BACKOFFICE')
            ->selectRaw('trbo_nodoc, TO_CHAR(TRBO_TGLDOC, \'DD/MM/YYYY\') TRBO_TGLDOC, CASE
                                            WHEN TRBO_FLAGDOC=\'*\' THEN TRBO_NONOTA
                                            ELSE \'Belum Cetak Nota\' END NOTA')
            ->where('TRBO_TYPETRN', '=', 'K')
            ->orderBy('TRBO_NODOC', 'desc')
            ->distinct()->get();

        return Datatables::of($data)->make(true);
    }

    public function getDataLovSupplier()
    {
        $data = DB::connection(Session::get('connection'))->table('tbmaster_supplier')
            ->select('sup_namasupplier', 'sup_kodesupplier', 'sup_pkp')
            ->where('sup_kodeigr', '=', Session::get('kdigr'))
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
//        DB::connection(Session::get('connection'))->select("delete from tbtr_usul_returlebih where usl_status <> 'SUDAH CETAK NOTA' and not exists (select 1 from tbtr_backoffice where usl_trbo_nodoc = trbo_nodoc) ");
        DB::connection(Session::get('connection'))->table('tbtr_usul_returlebih')
            ->whereRaw('usl_status <> \'SUDAH CETAK NOTA\' and not exists (select 1 from tbtr_backoffice where usl_trbo_nodoc = trbo_nodoc)')
            ->delete();
        $count = DB::connection(Session::get('connection'))->table('tbtr_usul_returlebih')
            ->where('usl_status', '!=', 'SUDAH CETAK NOTA')
            ->count();

        if ($count > 0) {
            $message = 'Masih ada usulan retur lebih yang belum diselesaikan, harap selesaikan dahulu atau hapus dokumen bersangkutan!';
            $status = 'error';
            // return compact(['message', 'status']);
            return response()->json([
                'status' => $status,
                'message' => $message
            ]);
        } else {
            $model = "*TAMBAH*";
            $status = 'success';

            $ip = Session::get('ip');

            $pIP = str_replace('.', '0', SUBSTR(Session::get('ip'), -3));
            // dd($pIP);

            $c = loginController::getConnectionProcedure();
            $s = oci_parse($c, "BEGIN :ret := F_IGR_GET_NOMORSTADOC('" . Session::get('kdigr') . "','RPB','Nomor Reff Pengeluaran Barang'," . $pIP . " || '2' , 7, FALSE); END;");
            oci_bind_by_name($s, ':ret', $no, 32);
            oci_execute($s);

            $checkNoDoc = DB::connection(Session::get('connection'))->table('TBTR_BACKOFFICE')
                ->where('trbo_nodoc', '=', $no)
                ->where('trbo_kodeigr', '=', Session::get('kdigr'))
                ->first();
            if ($checkNoDoc) {
                $no = $no + 1;
            }
            // dd($no);
            DB::connection(Session::get('connection'))->table('tbtr_tac')
                ->where('tac_kodeigr', Session::get('kdigr'))
                ->where('tac_nodoc', $no)
                ->delete();
        }

        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => [
                'model' => $model,
                'no' => $no
            ]
        ]);
        // return compact(['no', 'model', 'status', 'message']);
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

        $kdigr = Session::get('kdigr');

        $datas = DB::connection(Session::get('connection'))->table('TBTR_BACKOFFICE')
            ->leftJoin('TBMASTER_SUPPLIER', 'TRBO_KODESUPPLIER', 'SUP_KODESUPPLIER')
            ->where('TRBO_KODEIGR', '=', Session::get('kdigr'))
            ->where('TRBO_NODOC', '=', $notrn)
            ->where('TRBO_TYPETRN', '=', 'K')
            ->orderBy('TRBO_SEQNO')
            ->distinct()
            ->get();
            // dd($datas);

        foreach ($datas as $p) {
            $model = '* KOREKSI *';
            // $tgldoc = $p->trbo_tgldoc;
            $tgldoc = date("d/m/Y", strtotime($p->trbo_tgldoc));
            $supplier = $p->trbo_kodesupplier;
            $nmsupplier = $p->sup_namasupplier;
            $pkp = $p->sup_pkp;

            $nofps = $p->trbo_istype;
            $nourutfps = $p->trbo_invno;
            // $tglfps = $p->trbo_tglinv;
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

            $cek = DB::connection(Session::get('connection'))->select("SELECT DISTINCT BTB_PRDCD PLU, BTB_NODOC NODOC
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

            $cek2 = DB::connection(Session::get('connection'))->table('TEMP_URUT_RETUR ')->count();
            // dd($cek2);
            if ($cek2 == 0) {
                $message = 'Tidak ada data history penerimaan untuk Supplier ' . $supplier;
                $status = 'error';
                return response()->json([
                    'status' => $status,
                    'message' => $message
                ]);
                // return compact(['message', 'status']);
            }

        }

        $dh = DB::connection(Session::get('connection'))->table("TBTR_BACKOFFICE")
            ->leftJoin('TBMASTER_PRODMAST', function ($join) {
                $join->on('TBMASTER_PRODMAST.PRD_KODEIGR', '=', 'TBTR_BACKOFFICE.TRBO_KODEIGR')
                    ->on('TBMASTER_PRODMAST.PRD_PRDCD', '=', 'TBTR_BACKOFFICE.TRBO_PRDCD');
            })
            ->leftJoin('TBMASTER_SUPPLIER', function ($join) {
                $join->on('TBMASTER_SUPPLIER.SUP_KODEIGR', '=', 'TBTR_BACKOFFICE.TRBO_KODEIGR')
                    ->on('TBMASTER_SUPPLIER.SUP_KODESUPPLIER', '=', 'TBTR_BACKOFFICE.TRBO_KODESUPPLIER');
            })
            ->select(
                'TRBO_PRDCD',
                'PRD_DESKRIPSIPENDEK',
                DB::connection(Session::get('connection'))->raw("PRD_UNIT || '/' || PRD_FRAC SATUAN"),
                'PRD_FLAGBKP1',
                'TRBO_POSQTY',
                'PRD_FRAC',
                DB::connection(Session::get('connection'))->raw('SUM(TRBO_QTY) QTY'),
                'TRBO_KETERANGAN'
            )
            ->where(
                [
                    'TRBO_KODEIGR' => Session::get('kdigr'),
                    'TRBO_NODOC' => $notrn,
                    'TRBO_TYPETRN' => 'K'
                ]
            )
            ->groupBy(
                [
                    'TRBO_PRDCD',
                    'PRD_DESKRIPSIPENDEK',
                    DB::connection(Session::get('connection'))->raw("PRD_UNIT || '/' || PRD_FRAC"),
                    'PRD_FLAGBKP1',
                    'TRBO_POSQTY',
                    'PRD_FRAC',
                    'TRBO_KETERANGAN',
                ]
            )
            ->orderBy('TRBO_PRDCD')
            ->get();
            // dd($dh);


        $datas_header = [];
        foreach ($dh as $d) {
            $data = (object)'';

            $data->h_plu = $d->trbo_prdcd;
            $data->h_deskripsi = $d->prd_deskripsipendek;
            $data->h_satuan = $d->satuan;
            $data->h_bkp = $d->prd_flagbkp1;
            $data->h_stock = $d->trbo_posqty;
            $data->h_ctn = floor($d->qty / $d->prd_frac);
            $data->h_pcs = $d->qty % $d->prd_frac;
            $data->h_frac = $d->prd_frac;
            $data->h_ket = $d->trbo_keterangan;

            array_push($datas_header, $data);
        }

        $dd = DB::connection(Session::get('connection'))->table("TBTR_BACKOFFICE")
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
                DB::connection(Session::get('connection'))->raw("PRD_UNIT || '/' || PRD_FRAC SATUAN"),
                'PRD_FLAGBKP1',
                'TRBO_POSQTY',
                'PRD_FRAC',
                DB::connection(Session::get('connection'))->raw('SUM(TRBO_QTY) QTY'),
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
                'TRBO_PERSENPPN',
                'TRBO_PPNRPH',
                'TRBO_ISTYPE',
                'TRBO_INVNO',
                'TRBO_TGLINV',
                // DB::connection(Session::get('connection'))->raw("to_char(TRBO_TGLINV,'dd/mm/yyyy') TRBO_TGLINV"),
                'TRBO_NOREFF',
                'TRBO_KETERANGAN',
            )
            ->where(
                [
                    'TRBO_KODEIGR' => Session::get('kdigr'),
                    'TRBO_NODOC' => $notrn,
                    'TRBO_TYPETRN' => 'K'
                ]
            )
            ->groupBy(
                [
                    'TRBO_PRDCD',
                    'PRD_DESKRIPSIPENDEK',
                    DB::connection(Session::get('connection'))->raw("PRD_UNIT || '/' || PRD_FRAC"),
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
                    'TRBO_PERSENPPN',
                    'TRBO_PPNRPH',
                    'TRBO_ISTYPE',
                    'TRBO_INVNO',
                    'TRBO_TGLINV',
                    'TRBO_NOREFF',
                    'TRBO_KETERANGAN'
                ]
            )
            ->orderBy('TRBO_PRDCD')
            ->distinct()
            ->get();
        $datas_detail = [];
        foreach ($dd as $d) {
            $data = (object)'';

            $data->trbo_prdcd = $d->trbo_prdcd;
            $data->desk = $d->prd_deskripsipendek;
            $data->deskripsi = $d->prd_deskripsipanjang;
            $data->satuan = $d->satuan;
            $data->bkp = $d->prd_flagbkp1;
            $data->trbo_posqty = $d->trbo_posqty;
            $data->trbo_hrgsatuan = number_format((float)$d->trbo_hrgsatuan, 2, '.', '');
            // $data->trbo_hrgsatuan = $d->trbo_hrgsatuan;
            $data->qtyctn = floor($d->qty / $d->prd_frac);
            $data->qtypcs = $d->qty % $d->prd_frac;
            $data->trbo_gross = number_format((float)$d->trbo_gross, 2, '.', '');
            // $data->trbo_gross = $d->trbo_gross;
            $data->discper = number_format((float)(($d->trbo_discrph / $d->trbo_gross) * 100), 2, '.', '');
            // $data->discper = round(($d->trbo_discrph / $d->trbo_gross) * 100);
            $data->trbo_discrph = $d->trbo_discrph;
            $data->trbo_persenppn = $d->trbo_persenppn;
            $data->trbo_ppnrph =number_format((float)$d->trbo_ppnrph, 2, '.', '');
            // $data->trbo_ppnrph = $d->trbo_ppnrph;
            $data->trbo_istype = $d->trbo_istype;
            $data->trbo_inv = $d->trbo_invno;
            $data->trbo_tgl = date('d/m/Y', strtotime($d->trbo_tglinv));
            $data->trbo_noreff = $d->trbo_noreff;
            $data->keterangan = $d->trbo_keterangan;
            $data->pkp = $d->sup_pkp;
            $data->frac = $d->prd_frac;
            $data->unit = $d->prd_unit;
            // dd($datas_detail);

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
        $message = '';
        $status = '';
        if ($request->kdsup == '') {
            $message = 'Kode Supplier Tidak Boleh Kosong';
            $status = 'error';
            return compact(['message', 'status']);
        }
        $temp = DB::connection(Session::get('connection'))->table('tbtr_backoffice')
            ->select('sup_namasupplier', 'sup_kodesupplier', 'sup_pkp')
            ->where('trbo_kodeigr', '=', Session::get('kdigr'))
            ->where('trbo_kodesupplier', '=', $request->kdsup)
            ->where('trbo_typetrn', '=', 'K')
            ->whereRaw('trunc(trbo_tgldoc) = trunc(sysdate)')
            ->whereNull('trbo_recordid')
            ->count();
        if ($temp > 0) {
            $message = 'Masih ada inputan Retur Supplier ' . $request->kdsup . ', yang belum cetak nota.';
            $status = 'info';
        }


        $result = DB::connection(Session::get('connection'))->table('tbmaster_supplier')
            ->select('sup_namasupplier', 'sup_kodesupplier', 'sup_pkp')
            ->where('sup_kodeigr', '=', Session::get('kdigr'))
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
        // dd($exec);


        //    -->>> alert untuk PLu BKP yg belum keluar tax3 nya <<<--
        $cek = DB::connection(Session::get('connection'))->select("SELECT DISTINCT BTB_PRDCD PLU, BTB_NODOC NODOC
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

        $cek2 = DB::connection(Session::get('connection'))->table('TEMP_URUT_RETUR ')
                ->where('KSUP', '=', $request->kdsup)
                ->count();
        // $test = DB::connection(Session::get('connection'))->table('TEMP_URUT_RETUR ')
        //         ->where('KSUP', '=', $request->kdsup)
        //         ->get();
        // dd($test);

        if ($cek2 == 0) {
            $message = 'Tidak ada data history penerimaan untuk Supplier ' . $result->sup_kodesupplier;
            $status = 'error';
            return compact(['message', 'status']);
        }

        if ($message == '') {
            $messasge = 'Successfully get Kode Supplier';       
        }
        if ($status == '') {
            $status = 'SUCCESS';
        }
        return compact(['result', 'message', 'status']);
    }

    public function getDataLovPLU()
    {       
        $result = DB::connection(Session::get('connection'))->table('TBMASTER_PRODMAST')
                    ->select('PRD_DESKRIPSIPANJANG', 'PRD_PRDCD')
                    ->join('TEMP_URUT_RETUR', 'PRD_PRDCD', '=', 'PRDCD')
                    ->orderBy('PRD_DESKRIPSIPANJANG')
                    ->distinct()         
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

        $result = DB::connection(Session::get('connection'))->table('TBMASTER_PRODMAST')
            ->leftJoin('TBMASTER_STOCK', function ($join) {
                $join->on('TBMASTER_STOCK.ST_PRDCD', '=', 'TBMASTER_PRODMAST.PRD_PRDCD')
                    ->on('TBMASTER_STOCK.ST_LOKASI', '=', DB::connection(Session::get('connection'))->raw('02'));
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

        $cekRetur = DB::connection(Session::get('connection'))->table('tbmaster_prodmast')
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
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $result
        ]);
        // return compact(['result', 'message', 'status']);
    }


    public function cekPCS1(Request $request)
    {
        $plu = $request->plu;
        $kdsup = $request->kdsup;

        try {
            $qtypb = DB::connection(Session::get('connection'))->table('TEMP_URUT_RETUR')
                ->selectRaw('SUM (qtypb - (qtyretur + qtyhistretur)) AS qtypb')
                ->where('prdcd', '=', $plu)
                ->first();

            $qtypb = (int)$qtypb->qtypb;

            $qtyretur = DB::connection(Session::get('connection'))->table('TEMP_URUT_RETUR')
                ->selectRaw('SUM (qtypb - qtyhistretur) AS qtyretur')
                ->where('prdcd', '=', $plu)
                ->first();

            $qtyretur = (int)$qtyretur->qtyretur;


            $qtybpb = DB::connection(Session::get('connection'))->table('tbtr_mstran_btb')
                ->whereNotNull('btb_istype')
                ->whereNotNull('btb_invno')
                ->where('btb_kodesupplier', '=', $kdsup)
                ->where('btb_prdcd', '=', $plu)
                ->sum('btb_qty');
            $qtybpb = (int)$qtybpb;

            $qtyhretur = DB::connection(Session::get('connection'))->table('tbhistory_retursupplier')
                ->selectRaw('nvl(sum (case when hsr_qtyretur > hsr_qtypb then hsr_qtypb else hsr_qtyretur end),0) qtyhretur')
                ->where('hsr_kodesupplier', '=', $kdsup)
                ->where('hsr_prdcd', '=', $plu)
                ->first();
            $qtyhretur = (int)$qtyhretur->qtyhretur;

            $qtysisa = $qtybpb - $qtyhretur;

            return response()->json([
                'status' => 'SUCCESS',
                'message' => 'Data PCS 1 Ditemukan',
                'data' => [
                    'qtypb' => $qtypb,
                    'qtyretur' => $qtyretur,
                    'qtysisa' => $qtysisa
                ]
            ]);
            // return compact(['qtypb', 'qtyretur', 'qtysisa']);

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
        $nowDate = Carbon::now()->format('d/m/Y');

        try {
            $temp = DB::connection(Session::get('connection'))->table('tbtr_usul_returlebih')
                ->where('usl_kodeigr', '=', Session::get('kdigr'))
                ->where('usl_trbo_nodoc', '=', $nodoc)
                ->where('usl_prdcd', '=', $plu)
                ->count();
            if ($temp == 0) {
                DB::connection(Session::get('connection'))->table('tbtr_usul_returlebih')
                ->insert([
                    'usl_kodeigr' => Session::get('kdigr'),
                    'usl_trbo_nodoc' => $nodoc,
                    'usl_trbo_tgldoc' => DB::connection(Session::get('connection'))->raw("to_date('".$tgldoc."','dd/mm/yyyy')"),
                    // 'usl_trbo_tgldoc' => $tgldoc,
                    'usl_kodesupplier' => $kdsup,
                    'usl_prdcd' => $plu,
                    'usl_flagbkp' => $bkp,
                    'usl_qty_retur' => $inputan,
                    'usl_qty_sisaretur' => $qtyretur,
                    'usl_status' => 'USULAN',
                    'usl_create_by' => Session::get('usid'),
                    'usl_create_dt' => DB::connection(Session::get('connection'))->raw("to_date('".$nowDate."','dd/mm/yyyy')")
                ]);
            } else {
                DB::connection(Session::get('connection'))->table('tbtr_usul_returlebih')->where(['usl_kodeigr' => Session::get('kdigr'), 'usl_trbo_nodoc' => $nodoc, 'usl_trbo_tgldoc' => $tgldoc, 'usl_prdcd' => $plu])
                    ->update([
                        'usl_qty_retur' => $inputan,
                        'usl_qty_sisaretur' => $qtyretur,
                        'usl_modify_by' => Session::get('usid'),
                        'usl_modify_dt' => DB::connection(Session::get('connection'))->raw("to_date('".$nowDate."','dd/mm/yyyy')")
                    ]);
            }
            return response()->json([
                'status' => 'SUCCESS',
                'message' => 'Cek PCS 2 OK'
            ]);

            // return 'Cek PCS 2 OK';

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

        $temp = DB::connection(Session::get('connection'))->table('tbtr_usul_returlebih')
            ->where('usl_kodeigr', '=', Session::get('kdigr'))
            ->where('usl_trbo_nodoc', '=', $nodoc)
            ->where('usl_prdcd', '=', $plu)
            ->count();

        if ($temp > 0) {
            $status = 'question';
        } else {
            $status = 'SUCCESS';
            $message = 'Cek PCS 3 OK';
        }

        return response()->json([
            'status' => $status,
            'message' => $message
        ]);
        // return compact(['message', 'status']);
    }

    public function cekPCS4(Request $request)
    {
        $message = '';
        $status = '';

        $plu = $request->plu;
        $nodoc = $request->nodoc;

        try {
            DB::connection(Session::get('connection'))->table('tbtr_usul_returlebih')
                ->where('usl_kodeigr', '=', Session::get('kdigr'))
                ->where('usl_trbo_nodoc', '=', $nodoc)
                ->where('usl_prdcd', '=', $plu)
                ->delete();
            $message = 'Usulan retur berhasil dihapus!';
            $status = 'success';
        } catch (\Exception $e) {
            return $e;
        }
        return response()->json([
            'status' => $status,
            'message' => $message
        ]);
        // return compact(['message', 'status']);
    }

    public function proses(Request $request)
    {

        $qty = $request->qtyretur;
        $plu = $request->p_prdcd;
        $nodoc = $request->nodoc;
        $pkp = $request->pkp;
        $keterangan = $request->keterangan;

        $no_bpb = '';
        $mintrn = '';
        $maxtrn = '';
        $trbo_discrph = '';
        $datas = [];

        $frac = 0;
        $ppn = 0;
        $trbo_prdcd = '';
        $desk = '';
        $deskripsi = '';
        $satuan = '';
        $bkp = '';
        $trbo_posqty = '';
        $trbo_hrgsatuan = 0;
        $qtyctn = 0;
        $qtypcs = 0;
        $trbo_discrph = 0;
        $trbo_istype = '';
        $trbo_invno = '';
        $trbo_tglinv = '';
        $trbo_noreff = '';

        try {
            $temp = DB::connection(Session::get('connection'))->table('temp_urut_retur')
                ->where('prdcd', '=', $plu)
                ->count(1);

            if ($temp > 0) {
                $minmax = DB::connection(Session::get('connection'))->table('temp_urut_retur')
                    ->selectRaw('MIN (TRN) min, MAX (TRN) max')
                    ->where('prdcd', '=', $plu)
                    ->first();

                $mintrn = $minmax->min;
                $maxtrn = $minmax->max;
            }
            $ke = $mintrn;
            DB::connection(Session::get('connection'))->table('temp_urut_retur')->where(['NODOC_BPB' => $no_bpb])
                ->update(['nodoc_bo' => $nodoc]);

            for ($i = $mintrn; $i <= $maxtrn; $i++) {
                // $trbo = DB::connection(Session::get('connection'))->table('tbtr_backoffice')
                //     ->where('trbo_prdcd', '=', $plu)
                //     ->where('trbo_typetrn', '=', 'K')
                //     ->first();
                    // dd($trbo);

                // $trbo_discrph = 0;
                // if ($trbo) {
                //     $trbo_discrph = $trbo->trbo_discrph;
                // }

                $res = DB::connection(Session::get('connection'))->table('temp_urut_retur')
                    ->selectRaw("QTYPB, QTYHISTRETUR, NVL (NODOC_BPB, 'zz') NO_BPB, TGLINV, HRGSATUAN, NODOC_BO")
                    ->where('PRDCD', '=', $plu)
                    ->where('trn', '=', $ke)
                    ->first();
                    // dd($res);
                $qty_pb = $res->qtypb;
                $qty_histretur = $res->qtyhistretur;
                $no_bpb = $res->no_bpb;
                $tgl_fps = $res->tglinv;
                $hrg_satuan = $res->hrgsatuan;
                $no_doc = $res->nodoc_bo;
                if ($qty_pb > $qty_histretur || $ke == $maxtrn) {

                    DB::connection(Session::get('connection'))
                        ->update('update temp_urut_retur set qtyretur = case when '.$qty.' > ('.$qty_pb.' - '.$qty_histretur.') and '.$ke.' <> '.$maxtrn.' then('.$qty_pb.' - '.$qty_histretur.') else '.$qty.' end where prdcd = ' . $plu . ' and trn = ' . $ke . ' and nodoc_bpb = ' . $no_bpb);

                    $trbo_prdcd = $plu;
                    $res2 = DB::connection(Session::get('connection'))->select("select prd_deskripsipanjang, prd_deskripsipendek, frac, prd_flagbkp1,
                                prd_avgcost, st_avgcost, nvl(st_saldoakhir, 0) st_saldoakhir, hrgsatuan, qtypb, prd_ppn, persenppn
                            from tbmaster_prodmast, tbmaster_stock, temp_urut_retur
                            where prd_prdcd = st_prdcd(+)
                                and '02' =  st_lokasi(+)
                                and prd_prdcd = " . $plu . "
                                and prd_prdcd = prdcd
                                and nvl(nodoc_bpb, 'zz') = " . $no_bpb);
                    // return dd($res2);
            //         DB::Connection('simsmg')->raw('update temp_urut_retur set qtyretur = case when qty > (qty_pb - qty_histretur) and ke <> maxtrn then(qty_pb - qty_histretur) else qty end where prdcd = ' . $plu . ' and trn = ' . $ke . ' and nodoc_bpb = ' . $no_bpb);

            //         $trbo_prdcd = $plu;
            //         $res2 = DB::Connection('simsmg')->select("select prd_deskripsipanjang, prd_deskripsipendek, frac, prd_flagbkp1,
            //        prd_avgcost, st_avgcost, nvl(st_saldoakhir, 0) st_saldoakhir, hrgsatuan, qtypb
            //   from tbmaster_prodmast, tbmaster_stock, temp_urut_retur
            //   where prd_prdcd = st_prdcd(+)
            //     and '02' =  st_lokasi(+)
            //     and prd_prdcd = " . $plu . "
            //     and prd_prdcd = prdcd
            //     and nvl(nodoc_bpb, 'zz') = " . $no_bpb);

                    $res2 = $res2[0];
                    $deskripsi = $res2->prd_deskripsipanjang;
                    $desk = $res2->prd_deskripsipendek;
                    $frac = $res2->frac;
                    $bkp = $res2->prd_flagbkp1;
                    $acostprd = $res2->prd_avgcost;
                    $acostst = $res2->st_avgcost;
                    $trbo_posqty = $res2->st_saldoakhir;
                    $trbo_hrgsatuan = $res2->hrgsatuan;
                    $max_qty = $res2->qtypb;

//                --++get unit from mstran btb
                    $temp2 = DB::connection(Session::get('connection'))->table('tbtr_mstran_btb')
                        ->where('btb_prdcd', '=', $plu)
                        ->where('btb_nodoc', '=', $no_bpb)
                        ->count(1);
                        // dd($temp2);

                    if ($temp2 > 0) {
                        $unit = DB::connection(Session::get('connection'))->table('tbtr_mstran_btb')
                            ->select('btb_unit')
                            ->where('btb_prdcd', '=', $plu)
                            ->where('btb_nodoc', '=', $no_bpb)
                            ->first();
                            // dd($unit);
                        $unit = $unit->btb_unit;
                    }
                    $satuan = $unit . '/' . $frac;

                    // $trbo_qty = DB::connection(Session::get('connection'))->table('TEMP_URUT_RETUR')
                    // ->selectRaw('(qtypb - qtyhistretur) AS qtyretur')
                    // ->where('prdcd', '=', $plu)
                    // ->where('trn', '=', $ke)
                    // ->first();
                    $trbo_qty = DB::connection(Session::get('connection'))->table('temp_urut_retur')
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
                        $ppn = $res2->persenppn;                        
                    } else {
                        $ppn = 0;
                    }

                    $temp3 = DB::connection(Session::get('connection'))->table('temp_urut_retur')
                        ->selectRaw('istype, invno, tglinv, qtypb, hrgsatuan, nodoc_bpb, nodoc_bo')
                        ->where('prdcd', '=', $plu)
                        ->where('trn', '=', $ke)
                        ->first();

                    $trbo_istype = $temp3->istype;
                    $trbo_invno = $temp3->invno;
                    $trbo_tglinv = date('d/m/Y', strtotime($temp3->tglinv));
                    $max_qty = $temp3->qtypb;
                    $trbo_hrgsatuan = $temp3->hrgsatuan;
                    $trbo_noreff = $temp3->nodoc_bpb;
                    $trbo_nodo = $temp3->nodoc_bo;

                    if ($trbo_invno == '' && $trbo_noreff != '') {
                        $message = 'no.faktur pajak untuk btb ' . $trbo_noreff . ' tidak ditemukan';
                        $status = 'warning';
                        return compact(['message', 'status']);
                    }

                    $trbo_discrph = DB::connection(Session::get('connection'))->table('temp_urut_retur')
                        ->selectRaw('(discrphperpcs) * ((' . $qtyctn . ' * ' . $frac . ') + ' . $qtypcs . ') discrph')
                        ->where('prdcd', '=', $plu)
                        ->whereRaw("nvl(nodoc_bpb, 'zz') = nvl(" . $trbo_noreff . ", 'zz')")
                        ->first();

                    $trbo_discrph = $trbo_discrph->discrph;
                    
                }                

                // $temp1 = 0;
                // if ($ke == $maxtrn) {
                //     $temp1 = $qty;
                // } else {
                //     if (($qty_pb - $qty_histretur) < 0) {
                //         $temp1 = 0;
                //     } else {
                //         $temp1 = ($qty_pb - $qty_histretur);
                //     }
                // }
                // $qty = $qty - $temp1;

//            VALIDATE_ITEM                                
                $trbo_qty = ($qtyctn * $frac) + $qtypcs;
                $qtyctn = intval($trbo_qty / $frac);
                $qtypcs = $trbo_qty % $frac;
                // if ($qtyctn != 0) {
                //     $qtypcs = 0;
                // } else {
                //     $qtypcs = $trbo_qty % $frac;
                // }
//
                $trbo_gross = ($qtyctn * $trbo_hrgsatuan) + (($trbo_hrgsatuan / $frac) * $qtypcs);
                // dd($qtypcs);

                $trbo_discper = ($trbo_discrph / $trbo_gross) * 100;
                // $trbo_discper = round(($trbo_discrph / $trbo_gross) * 100);
                // dd($trbo_discper);

                if ($trbo_discper > 0) {
                    $trbo_discrph = ($trbo_gross * $trbo_discper) / 100;
                }

                $trbo_ppnrph = (($trbo_gross - $trbo_discrph) * $ppn) / 100;
                // dd($trbo_ppnrph);

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
//            $trbo_discper = ($trbo_discrph / $trbo->trbo_gross) * 100;

                if ($qty_pb > $qty_histretur) {
                    $data = (object)'';

                    $data->trbo_prdcd = $plu;
                    // $data->trbo_prdcd = $trbo->trbo_prdcd;
                    $data->desk = $desk;
                    $data->deskripsi = $deskripsi;
                    $data->satuan = $satuan;
                    $data->bkp = $bkp;
                    $data->trbo_posqty = $trbo_posqty;
                    $data->trbo_hrgsatuan = number_format((float)$trbo_hrgsatuan, 2, '.', '');
                    // $data->trbo_hrgsatuan = $trbo_hrgsatuan;
                    $data->qtyctn = $qtyctn;
                    $data->qtypcs = $qtypcs;
                    $data->trbo_gross = number_format((float)$trbo_gross, 2, '.', '');
                    // $data->trbo_gross = number_format((float)round($trbo_gross, 2), 2, '.', '');
                    // $data->trbo_gross = $trbo_gross;
                    $data->discper = number_format((float)$trbo_discper, 2, '.', '');
                    // $data->discper = number_format((float)round($trbo_discper), 2, '.', '');
                    // $data->discper = $trbo_discper;
                    $data->trbo_discrph = number_format((float)$trbo_discrph, 2, '.', '');
                    // $data->trbo_discrph = number_format((float)round($trbo_discrph, 1), 2, '.', '');
                    // $data->trbo_discrph = $trbo_discrph;
                    $data->persen_ppn = $res2->persenppn;
                    $data->trbo_ppnrph = number_format((float)$trbo_ppnrph, 2, '.', '');
                    // $data->trbo_ppnrph = number_format((float)round($trbo_ppnrph, 4), 2, '.', '');
                    // $data->trbo_ppnrph = $trbo_ppnrph;
                    $data->trbo_istype = $trbo_istype;
                    $data->trbo_inv = $trbo_invno;
                    $data->trbo_tgl = $trbo_tglinv;
                    $data->trbo_noreff = $trbo_noreff;
                   
                    if ($keterangan == null) {
                        $data->trbo_keterangan = '';
                        // $data->trbo_keterangan = $trbo['trbo_keterangan'];
                    } else {
                        $data->trbo_keterangan = $keterangan;
                    }                   
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
        DB::connection(Session::get('connection'))
            ->table('TBTR_BACKOFFICE')
            ->where('TRBO_NODOC', $nodoc)
            ->where('TRBO_TYPETRN', '=', 'K')
            ->delete();

        return response()->json([
            'kode' => 1,
            'title' => "Dokumen Berhasil dihapus",
            'status' => 'success'
        ]);

    }


    public function save(Request $request)
    {

        $trbo_kodeigr = Session::get('kdigr');
        $trbo_typetrn = 'K';
        $trbo_flagdoc = 0;
        $trbo_create_by = Session::get('usid');
        $trbo_create_dt = Carbon::now()->format('d/m/Y');
        $model = $request->model;
        $nodoc = $request->nodoc;
        $tgldoc = $request->tgldoc;
        $kdsup = $request->kdsup;
        $datas_detail = $request->datas_detail;
        // dd($datas_detail);

        DB::connection(Session::get('connection'))->beginTransaction();
        if ($model = '* KOREKSI *') {
            DB::connection(Session::get('connection'))->table('TBTR_BACKOFFICE')
                ->where([
                    'trbo_kodeigr' => $trbo_kodeigr,
                    'trbo_nodoc' => $nodoc,
                ])
                ->delete();
        }
        $index = 1;
        foreach ($datas_detail as $data) {
            $data['tgldoc'] = DB::connection(Session::get('connection'))->raw("to_date('".$tgldoc."','dd/mm/yyyy')");
            $data['trbo_tgl'] = DB::connection(Session::get('connection'))->raw("to_date('".$data['trbo_tgl']."','dd/mm/yyyy')");
            $data['trbo_create_dt'] = DB::connection(Session::get('connection'))->raw("to_date('".$trbo_create_dt."','dd/mm/yyyy')");

            $tempFrac = explode("/", $data['satuan']);
            $data['frac'] = $tempFrac[1];

            $temp = DB::connection(Session::get('connection'))->table('TBTR_BACKOFFICE')
                ->where([
                    'trbo_kodeigr' => $trbo_kodeigr,
                    'trbo_nodoc' => $nodoc,
                    'trbo_prdcd' => $data['trbo_prdcd'],
                    'trbo_noreff' => $data['trbo_noreff']
                ])
                ->count(1);
            $avg_cost = DB::connection(Session::get('connection'))->table('tbmaster_prodmast')
                ->select('prd_avgcost')
                ->where('prd_prdcd', '=', $data['trbo_prdcd'])
                ->first();
    //        dd( Carbon::parse($data['tgldoc']));
            $avg_cost = $avg_cost->prd_avgcost;
            if ($temp > 0) {
                DB::connection(Session::get('connection'))->table('TBTR_BACKOFFICE')
                    ->where([
                        'trbo_kodeigr' => $trbo_kodeigr,
                        'trbo_nodoc' => $nodoc,
                        'trbo_prdcd' => $data['trbo_prdcd']
                    ])
                    ->update([
                        'trbo_typetrn' => $trbo_typetrn,
                        'trbo_tgldoc' => $data['tgldoc'],
                        'trbo_noreff' => $data['trbo_noreff'],
                        'trbo_istype' => $data['trbo_istype'],
                        'trbo_invno' => $data['trbo_inv'],
                        'trbo_tglinv' => $data['trbo_tgl'],
                        'trbo_kodesupplier' => $kdsup,
                        'trbo_qty' => ($data['qtyctn'] * $data['frac']) + $data['qtypcs'],
                        'trbo_hrgsatuan' => $data['trbo_hrgsatuan'],
                        'trbo_persendisc1' => $data['discper'],
                        'trbo_gross' => $data['trbo_gross'],
                        'trbo_discrph' => $data['trbo_discrph'],
                        'trbo_ppnrph' => $data['trbo_ppnrph'],
                        'trbo_averagecost' => $avg_cost,
                        'trbo_posqty' => $data['trbo_posqty'],
                        'trbo_flagdoc' => $trbo_flagdoc,
                        'trbo_keterangan' => $data['trbo_keterangan'],
                        'trbo_create_by' => $trbo_create_by,
                        'trbo_create_dt' => $data['trbo_create_dt']
                    ]);
            } else {
                DB::connection(Session::get('connection'))->table('TBTR_BACKOFFICE')->insert([
                    'trbo_kodeigr' => $trbo_kodeigr,
                    'trbo_seqno' => $index,
                    'trbo_nodoc' => $nodoc,
                    'trbo_prdcd' => $data['trbo_prdcd'],
                    'trbo_typetrn' => $trbo_typetrn,
                    'trbo_tgldoc' => $data['tgldoc'],
                    'trbo_noreff' => $data['trbo_noreff'],
                    'trbo_istype' => $data['trbo_istype'],
                    'trbo_invno' => $data['trbo_inv'],
                    'trbo_tglinv' => $data['trbo_tgl'],
                    'trbo_kodesupplier' => $kdsup,
                    'trbo_qty' => ($data['qtyctn'] * $data['frac']) + $data['qtypcs'],
                    'trbo_hrgsatuan' => $data['trbo_hrgsatuan'],
                    'trbo_persendisc1' => $data['discper'],
                    'trbo_gross' => $data['trbo_gross'],
                    'trbo_discrph' => $data['trbo_discrph'],
                    'trbo_persenppn' => $data['persen_ppn'],
                    'trbo_ppnrph' => $data['trbo_ppnrph'],
                    'trbo_averagecost' => $avg_cost,
                    'trbo_posqty' => $data['trbo_posqty'],
                    'trbo_flagdoc' => $trbo_flagdoc,
                    'trbo_keterangan' => $data['trbo_keterangan'],
                    'trbo_create_by' => $trbo_create_by,
                    'trbo_create_dt' => $data['trbo_create_dt']
                ]);
            }

            $index++;
        }
        DB::connection(Session::get('connection'))->commit();

        $message = 'Nodoc ' . $nodoc . ' Berhasil di simpan';
        $status = 'success';
        return compact(['message', 'status']);
    }

    public function getDataUsulan(Request $request)
    {
        $nodoc = $request->nodoc;
        $kdsup = $request->kdsup;

        $temp = DB::connection(Session::get('connection'))->table('tbtr_usul_returlebih')
            ->where('usl_trbo_nodoc', '=', $nodoc)
            ->where('usl_kodesupplier', '=', $kdsup)
            ->count();

        if ($temp == 0) {
            $message = 'Tidak ada usulan retur lebih untuk dokumen ' . $nodoc;
            $status = 'info';
            return compact(['message', 'status']);
        }

        $dataUsulan = DB::connection(Session::get('connection'))->table('tbtr_usul_returlebih')
            ->join('tbmaster_prodmast', 'usl_prdcd', '=', 'prd_prdcd')
            ->selectRaw('usl_kodeigr, usl_trbo_nodoc, usl_kodesupplier, usl_prdcd, prd_deskripsipanjang,
                        usl_qty_retur, usl_qty_sisaretur, usl_status')
            ->where('usl_trbo_nodoc', '=', $nodoc)
            ->where('usl_kodesupplier', '=', $kdsup)
            ->get();
            // dd($dataUsulan);
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

        $userid = Session::get('usid');

//	OTP_FIN;
        $ip = (int)(substr($request->nodoc, 1, 3));
        $doc = (int)(substr($request->nodoc, 5));
        $nodoc = $doc;
        $kdigr = (int)(Session::get('kdigr'));
        $select = DB::connection(Session::get('connection'))->select("Select TO_NUMBER ( TRANSLATE ('" . $request->kdsup . "','0123456789' || TRANSLATE ( '" . $request->kdsup . "', 'x123456789', 'x'),'0123456789')) ret from dual");
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
        // dd($userid);
        $nodoc = $request->nodoc;
        $kdsup = $request->kdsup;
        $tgldoc = $request->tgldoc;
//        $tgldoc = date('Y-m-d', strtotime($request->tgldoc));
        $kdigr = Session::get('kdigr');
        $errm = '';

        $c = loginController::getConnectionProcedure();
        $s = oci_parse($c, "BEGIN sp_usulanretur(:kodeigr,:nodoc,to_date('".$tgldoc."','dd/mm/yyyy'),:supplier,:otp,:userid,:errm); END;");
        oci_bind_by_name($s, ':kodeigr', $kdigr);
        oci_bind_by_name($s, ':nodoc', $nodoc);
//        oci_bind_by_name($s, ':tgldoc', $tgldoc);
        oci_bind_by_name($s, ':supplier', $kdsup);
        oci_bind_by_name($s, ':otp', $otp);
        oci_bind_by_name($s, ':userid', $userid);
        oci_bind_by_name($s, ':errm', $errm, 2000);

        oci_execute($s);

        if ($errm != '') {
            $message = $errm;
            $status = 'error';
            return compact(['message', 'status']);
        } else {
            $message = 'Usulan retur sudah dikirm ke email finance';
            $status = 'info';
        }

        $status_usul = DB::connection(Session::get('connection'))->table('tbtr_usul_returlebih')
            ->join('tbmaster_prodmast', 'usl_prdcd', '=', 'prd_prdcd')
            ->select('usl_status')
            ->where('usl_trbo_nodoc', '=', $nodoc)
            ->where('usl_kodesupplier', '=', $kdsup)
            ->distinct()
            ->first();
        // dd($status_usul);

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

    public function checkUsulLebih(Request $request){
        $plu = $request->plu;
        $nodoc = $request->nodoc;

        $usul_lebih = DB::connection(Session::get('connection'))->table('tbtr_usul_returlebih')
                        ->where('usl_trbo_nodoc', '=', $nodoc)
                        ->where('usl_prdcd', '=', $plu)
                        ->get();
        if ($usul_lebih) {
            DB::connection(Session::get('connection'))->table('tbtr_usul_returlebih')
                ->where('usl_trbo_nodoc', '=', $nodoc)
                ->where('usl_prdcd', '=', $plu)
                ->delete();

            return response()->json([
                'status' => 'SUCCESS',
                'message' => 'Data PLU' . $plu . ' di table tbtr_usul_returlebih berhasil dihapus'
            ]);
        } else {
            return response()->json([
                'status' => 'FAILED',
                'message' => 'Tidak ada data PLU ' . $plu . ' tidak ada dalam table tbtr_usul_returlebih'
            ]);
        }        
    }

    public function cekOTP(Request $request)
    {
        $datas = $request->datas;
        $datah = $request->datah;
        $datad = $request->datad;

        // $trbo_kodeigr = Session::get('kdigr');
        // $trbo_typetrn = 'K';
        // $trbo_flagdoc = 0;
        // $trbo_create_dt = Carbon::now()->format('d/m/Y');
        // $trbo_create_by = Session::get('usid');
        // $datas_detail = $request->datas_detail;
        // dd($datas_detail);

        $ip = (int)(substr($request->nodoc, 1, 3));
        $doc = (int)(substr($request->nodoc, 5));
        $nodoc = $doc;
        $kdigr = (int)(Session::get('kdigr'));
        $select = DB::connection(Session::get('connection'))->select("Select TO_NUMBER ( TRANSLATE ('" . $request->kdsup . "','0123456789' || TRANSLATE ( '" . $request->kdsup . "', 'x123456789', 'x'),'0123456789')) ret from dual");
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
            $usuls = DB::connection(Session::get('connection'))->table('tbtr_usul_returlebih')
                ->join('tbmaster_prodmast', 'usl_prdcd', '=', 'prd_prdcd')
                ->selectRaw('usl_prdcd, usl_qty_retur')
                ->where('usl_trbo_nodoc', '=', $request->nodoc)
                ->get();

            $datahke = 0;
            $i = 0;
            foreach ($usuls as $usul) {
//                [[proses usulan]]
                while (1) {
                    if ($datah[$datahke]['plu'] == $usul->usl_prdcd){
                        $datah[$datahke]['ctn'] = floor($usul->usl_qty_retur / $datah[$datahke]['frac']);
                        $datah[$datahke]['pcs'] = $usul->usl_qty_retur % $datah[$datahke]['frac'];
                    }
                    if ($datah[$datahke]['plu'] == $usul->usl_prdcd) {
                        break;
                    }
                    $datahke++;
                }

//    [HAPUS]
                // $lastrecord = 0;
                // if (isset($datad)) {
                //     $lastrecord = sizeof($datad) - 1;
                // }

//                $j = 0;
//                for ($i = 0; $i < sizeof($datad) ; $i++) {
//                    for ($j = 0; $j < sizeof($datad) ; $j++) {
//                        if ($datad[$j]['plu'] == $datah[$datahke]['plu']) {
//                            array_splice($datad, $j, 1);
//                        }
//                        $datahke++;
//                    }
//                }

                // DB::connection(Session::get('connection'))->update('update temp_urut_retur set qtyretur = 0 where prdcd = ' . $datah[$i]->plu . ' or pluold = ' . $datah[$i]->plu . ' or exists (select 1 from tbtr_konversiplu where kvp_pluold = prdcd and kvp_plunew= ' . $datah[$i]->plu . ')');

                //====

                $PLU = $usul->usl_prdcd;

                $data_usuls = DB::connection(Session::get('connection'))->table('temp_usul_retur')
                    ->where('prdcd', '=', $PLU)
                    ->orderBy('trn')
                    ->get();
                    // dd($data_usuls);

                foreach ($data_usuls as $data_usul) {
                    $data = (object)'';

                    if ($data_usul->nodoc_bpb != null) {
                        $NO_BPB = $data_usul->nodoc_bpb;
                    } else {
                        $NO_BPB = 'zz';
                    }

                    $data->prdcd = $PLU;

                    $res = DB::connection(Session::get('connection'))->table('TBMASTER_PRODMAST')
                        ->join('TBMASTER_STOCK', 'PRD_PRDCD', '=', 'ST_PRDCD')
                        ->join('TEMP_USUL_RETUR', 'PRD_PRDCD', '=', 'PRDCD')
                        ->select(
                            'PRD_DESKRIPSIPANJANG',
                            'PRD_DESKRIPSIPENDEK',
                            'FRAC',
                            'PRD_FLAGBKP1',
                            'PRD_AVGCOST',
                            'PRD_PPN',
                            'ST_AVGCOST',
                            'ST_SALDOAKHIR',
                            'HRGSATUAN',
                            'QTYBPB'
                        )
                        ->where('ST_LOKASI', '=', '02')
                        ->where('PRD_PRDCD', '=', $PLU)
                        ->where('NODOC_BPB', '=', $NO_BPB)
                        ->get();
                        // dd($res);
                    // $res = DB::connection(Session::get('connection'))
                    //     ->select("select prd_deskripsipanjang, prd_deskripsipendek, frac, prd_flagbkp1,prd_avgcost, prd_ppn, st_avgcost, nvl(st_saldoakhir, 0) st_saldoakhir, hrgsatuan, qtypb from tbmaster_prodmast, tbmaster_stock, temp_urut_retur where prd_prdcd = st_prdcd(+) and '02' =  st_lokasi(+) and prd_prdcd = " . $PLU . " and prd_prdcd = prdcd and nvl(nodoc_bpb, 'zz') = " . $NO_BPB);

                    $data->deskripsi = $res[0]->prd_deskripsipanjang;
                    $data->desk = $res[0]->prd_deskripsipendek;
                    $data->frac = $res[0]->frac;
                    $data->bkp = $res[0]->prd_flagbkp1;
                    $data->acostprd = $res[0]->prd_avgcost;
                    $data->acostst = $res[0]->st_avgcost;
                    if ($res[0]->st_saldoakhir != null) {
                        $data->trbo_posqty = $res[0]->st_saldoakhir;
                    } else {
                        $data->trbo_posqty = 0;
                    }
                    $data->trbo_hrgsatuan = $res[0]->hrgsatuan;
                    $data->max_qty = $res[0]->qtybpb;
//            --++Get Unit From mstran BTB
                    $temp = DB::connection(Session::get('connection'))->table('tbtr_mstran_btb')
                        ->select('btb_unit')
                        ->where('btb_prdcd', '=', $PLU)
                        ->where('btb_nodoc', '=', $NO_BPB)
                        ->count(1);

                    if ($temp > 0) {
                        $unit = DB::connection(Session::get('connection'))->table('tbtr_mstran_btb')
                            ->select('btb_unit')
                            ->where('btb_prdcd', '=', $PLU)
                            ->where('btb_nodoc', '=', $NO_BPB)
                            ->first();
                        $data->unit = $unit->btb_unit;
                    }


//            ----Get Unit From mstran BTB

                    $data->satuan = $data->unit . '/' . $data->frac;
                    $data->trbo_qty = $data_usul->qtyretur;
                    $data->qtyctn = floor($data->trbo_qty / $data->frac);
                    $data->qtypcs = $data->trbo_qty % $data->frac;

                    if ($data->acostst == '' || !isset($data->acostst) || $data->acostst == 0) {
                        $data->trbo_averagecost = $data->acostprd;
                    } else {
                        $data->trbo_averagecost = $data->acostst * $data->frac;
                    }

//            ---** Hitung PPN ** ---
                    if ($request->pkp == 'Y' AND $data->bkp == 'Y') {
                        $data->ppn = $res[0]->prd_ppn;
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

                $index = 1;

                DB::connection(Session::get('connection'))->beginTransaction();
                // foreach ($datas_detail as $data_detail) {
                //     $avg_cost = DB::connection(Session::get('connection'))->table('tbmaster_prodmast')
                //             ->select('prd_avgcost')
                //             ->where('prd_prdcd', '=', $data_detail['trbo_prdcd'])
                //             ->first();
                //     $data_detail['tgldoc'] = DB::connection(Session::get('connection'))->raw("to_date('".$request->tgldoc."','dd/mm/yyyy')");
                //     $data_detail['trbo_tgl'] = DB::connection(Session::get('connection'))->raw("to_date('".$data_detail['trbo_tgl']."','dd/mm/yyyy')");
                //     $data_detail['trbo_create_dt'] = DB::connection(Session::get('connection'))->raw("to_date('".$trbo_create_dt."','dd/mm/yyyy')");

                //     $tempFrac = explode("/", $data_detail['satuan']);
                //     $data_detail['frac'] = $tempFrac[1];

                //     DB::connection(Session::get('connection'))->table('TBTR_BACKOFFICE')->insert([
                //         'trbo_kodeigr' => $trbo_kodeigr,
                //         'trbo_seqno' => $index,
                //         'trbo_nodoc' => $request->$nodoc,
                //         'trbo_prdcd' => $data_detail['trbo_prdcd'],
                //         'trbo_typetrn' => $trbo_typetrn,
                //         'trbo_tgldoc' => $data_detail['tgldoc'],
                //         'trbo_noreff' => $data_detail['trbo_noreff'],
                //         'trbo_istype' => $data_detail['trbo_istype'],
                //         'trbo_invno' => $data_detail['trbo_inv'],
                //         'trbo_tglinv' => $data_detail['trbo_tgl'],
                //         'trbo_kodesupplier' => $request->$kdsup,
                //         'trbo_qty' => ($data_detail['qtyctn'] * $data_detail['frac']) + $data_detail['qtypcs'],
                //         'trbo_hrgsatuan' => $data_detail['trbo_hrgsatuan'],
                //         'trbo_persendisc1' => $data_detail['discper'],
                //         'trbo_gross' => $data_detail['trbo_gross'],
                //         'trbo_discrph' => $data_detail['trbo_discrph'],
                //         'trbo_ppnrph' => $data_detail['trbo_ppnrph'],
                //         'trbo_averagecost' => $avg_cost,
                //         'trbo_posqty' => $data_detail['trbo_posqty'],
                //         'trbo_flagdoc' => $trbo_flagdoc,
                //         'trbo_create_by' => $trbo_create_by,
                //         'trbo_create_dt' => $data_detail['trbo_create_dt']
                //     ]);

                //     $index++;
                // }

                DB::connection(Session::get('connection'))->table('tbtr_usul_returlebih')
                    ->where('usl_kodeigr', '=', Session::get('kdigr'))
                    ->where('usl_trbo_nodoc', '=', $request->nodoc)
                    ->update(['usl_status' => 'USULAN DISETUJUI']);
                DB::connection(Session::get('connection'))->commit();

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
