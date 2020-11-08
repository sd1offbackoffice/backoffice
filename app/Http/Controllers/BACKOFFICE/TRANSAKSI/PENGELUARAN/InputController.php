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
        $MODEL = '';
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
            ->get();
        foreach ($datas as $p) {
            $model = '* KOREKSI *';
            $tgldoc = date("d-M-Y", strtotime($p->trbo_tgldoc));
            $supplier = $p->trbo_kodesupplier;
            $nmsupplier = $p->sup_namasupplier;
            $nofps = $p->trbo_istype;
            $nourutfps = $p->trbo_invno;
            $tglfps = date("d-M-Y", strtotime($p->trbo_tglinv));
            $trbo_flagdoc = $p->trbo_flagdoc;
            $nodoc = $p->trbo_nodoc;
        }

        $datas2 = DB::select("SELECT TRBO_PRDCD, PRD_DESKRIPSIPENDEK, PRD_UNIT || '/' || PRD_FRAC SATUAN,
                             PRD_FLAGBKP1, TRBO_POSQTY, PRD_FRAC, SUM (TRBO_QTY) QTY,
                             TRBO_KETERANGAN
                        FROM TBTR_BACKOFFICE, TBMASTER_PRODMAST, TBMASTER_SUPPLIER
                       WHERE TRBO_KODEIGR = PRD_KODEIGR(+)
                         AND TRBO_PRDCD = PRD_PRDCD(+)
                         AND TRBO_KODEIGR = SUP_KODEIGR(+)
                         AND TRBO_KODESUPPLIER = SUP_KODESUPPLIER(+)
                         AND TRBO_KODEIGR = " . $_SESSION['kdigr'] . "
                         AND TRBO_NODOC = " . $notrn . "
                         AND TRBO_TYPETRN = 'K'
                    GROUP BY TRBO_PRDCD,
                             PRD_DESKRIPSIPENDEK,
                             PRD_UNIT || '/' || PRD_FRAC,
                             PRD_FLAGBKP1,
                             TRBO_POSQTY,
                             PRD_FRAC,
                             TRBO_KETERANGAN
                    ORDER BY trbo_prdcd");

        $datas = [];
        foreach ($datas2 as $d) {
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

            array_push($datas, $data);
        }
        return compact(['datas', 'model', 'message', 'status']);

//        --dc_alert.ok(:MODEL);
//        IF :MODEL = '* KOREKSI *'
//        THEN
//            GO_BLOCK ('DETAIL');
//            CLEAR_BLOCK (NO_VALIDATE);
//            EXECUTE_QUERY;
//            LAST_RECORD;
//
//            IF NVL (:TRBO_FLAGDOC, '0') = '*'
//            THEN
//                SET_ENABLED (FALSE);
//                :MODEL := '* NOTA SUDAH DICETAK *';
//                SET_BLOCK_PROPERTY ('HEADER2', INSERT_ALLOWED, PROPERTY_FALSE);
//                SET_BLOCK_PROPERTY ('HEADER2', UPDATE_ALLOWED, PROPERTY_FALSE);
//                SET_BLOCK_PROPERTY ('DETAIL', INSERT_ALLOWED, PROPERTY_FALSE);
//                SET_BLOCK_PROPERTY ('DETAIL', UPDATE_ALLOWED, PROPERTY_FALSE);
//            ELSE
//                SET_ENABLED (TRUE);
//                SET_BLOCK_PROPERTY ('HEADER2', INSERT_ALLOWED, PROPERTY_TRUE);
//                SET_BLOCK_PROPERTY ('HEADER2', UPDATE_ALLOWED, PROPERTY_TRUE);
//                SET_BLOCK_PROPERTY ('DETAIL', INSERT_ALLOWED, PROPERTY_TRUE);
//                SET_BLOCK_PROPERTY ('DETAIL', UPDATE_ALLOWED, PROPERTY_FALSE);
//                SET_ITEM_PROPERTY ('H_PLU', UPDATE_ALLOWED, PROPERTY_TRUE);
//                --clear_form (NO_VALIDATE, FULL_ROLLBACK);
//                ISI_TEMP;
//                END IF;
//            ELSE
//                GO_BLOCK ('DETAIL');
//            CLEAR_BLOCK (NO_VALIDATE);
//            EXECUTE_QUERY;
//            LAST_RECORD;
//            SET_ENABLED (TRUE);
//            SET_BLOCK_PROPERTY ('DETAIL', INSERT_ALLOWED, PROPERTY_TRUE);
//            SET_BLOCK_PROPERTY ('DETAIL', UPDATE_ALLOWED, PROPERTY_FALSE);
//            SET_ITEM_PROPERTY ('TRBO_PRDCD', UPDATE_ALLOWED, PROPERTY_TRUE);
//        END IF;
//
//        GO_BLOCK ('HEADER2');
//        FIRST_RECORD;
//        :SYSTEM.MESSAGE_LEVEL := 0;
//        :PARAMETER.FSTAT := 0;
//==============================
//        if ($kdsup == '') {
//            $message = 'Kode Supplier Harus Diisi';
//            $status = 'error';
//            return compact(['message', 'status']);
//        }
//
//        $temp = DB::table('TBTR_BACKOFFICE ')
//            ->where('TRBO_KODEIGR', '=', $_SESSION['kdigr'])
//            ->where('TRBO_KODESUPPLIER', '=', $kdsup)
//            ->whereRaw('TRUNC(TRBO_TGLDOC) = TRUNC(SYSDATE)')
//            ->where('TRBO_TYPETRN', '=', 'K')
//            ->whereNull('TRBO_RECORDID')
//            ->count();
//        if ($temp > 0) {
//            $message = 'Masih ada inputan Retur Supplier ' . $kdsup . ', yang belum cetak nota.';
//            $status = 'error';
//
//            $NODOC = DB::table('TBTR_BACKOFFICE ')
//                ->selectRaw('A.*, B.SUP_NAMASUPPLIER')
//                ->where('TRBO_KODEIGR', '=', $_SESSION['kdigr'])
//                ->where('TRBO_KODESUPPLIER', '=', $kdsup)
//                ->whereRaw('TRUNC(TRBO_TGLDOC) = TRUNC(SYSDATE)')
//                ->whereRaw('ROWNUM = 1')
//                ->distinct()
//                ->first();
//
//            $pengeluaran = DB::table('TBTR_BACKOFFICE ')
//                ->leftjoin('TBMASTER_SUPPLIER', 'TRBO_KODESUPPLIER', 'SUP_KODESUPPLIER')
//                ->selectRaw('A.*, B.SUP_NAMASUPPLIER')
//                ->where('TRBO_KODEIGR', '=', $_SESSION['kdigr'])
//                ->where('TRBO_NODOC', '=', $notrn->value)
//                ->where('TRBO_TYPETRN', '=', 'K')
//                ->orderBy('TRBO_SEQNO')
//                ->get();

//            foreach ($pengeluaran as $p) {
//                $model = '* KOREKSI *';
//                $tgldoc = TO_CHAR($p->TRBO_TGLDOC, 'DD-MM-YYYY');
//                $supplier = $p->TRBO_KODESUPPLIER;
//                $nmsupplier = $p->SUP_NAMASUPPLIER;
//                $nofps = $p->TRBO_ISTYPE;
//                $nourutfps = $p->TRBO_INVNO;
//                $tglfps = TO_CHAR($p->TRBO_TGLINV, 'DD-MM-YYYY');
//                $trbo_flagdoc = $p->TRBO_FLAGDOC;
////                :
////                PARAMETER . NOURUT = $p->TRBO_SEQNO + 1;
//                $nodoc = $p->TRBO_NODOC;
//            }
//        }

        return compact(['pengeluaran', 'model', 'message', 'status']);

    }

}
