<?php

namespace App\Http\Controllers\BACKOFFICE\TRANSAKSI\PENGELUARAN;

use App\Http\Controllers\Connection;
use Carbon\Carbon;
use Dompdf\Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Expr\Cast\Object_;
use Yajra\DataTables\DataTables;


class PembatalanController extends Controller
{
    public function index()
    {
        return view('BACKOFFICE/TRANSAKSI/PENGELUARAN.pembatalan');
    }

    public function getDataLovNPB()
    {
        $data = DB::table('tbtr_mstran_h')
            ->select('msth_nodoc', 'msth_tgldoc')
            ->where('msth_kodeigr', '=', $_SESSION['kdigr'])
            ->where('msth_typetrn', '=', 'K')
            ->where(DB::Raw("nvl(msth_recordid,'0')"), '<>', '1')
            ->orderBy('msth_nodoc', 'desc')
            ->limit(1000)
            ->get();

        return Datatables::of($data)->make(true);
    }

    public function getData(Request $request)
    {
        $noNPB = $request->no_npb;

        $supco = '0';
        $results = DB::table('tbtr_mstran_h')
            ->join('tbtr_mstran_d', 'msth_nodoc', '=', 'mstd_nodoc')
            ->join('tbmaster_prodmast', 'mstd_prdcd', '=', 'prd_prdcd')
            ->rightJoin('tbmaster_supplier', 'msth_kodesupplier', '=', 'sup_kodesupplier')
            ->selectRaw('mstd_prdcd, prd_deskripsipanjang barang, mstd_unit||\'/\'||mstd_frac satuan, mstd_kodesupplier,floor(mstd_qty/mstd_frac) qty, mod(mstd_qty, mstd_frac) qtyk, mstd_hrgsatuan, mstd_gross')
            ->where('msth_kodeigr', '=', $_SESSION['kdigr'])
            ->where('msth_typetrn', '=', 'K')
            ->where('msth_nodoc', '=', $noNPB)
            ->where(DB::Raw("nvl(msth_recordid,'0')"), '<>', '1')
            ->orderBy('msth_nodoc', 'desc')
            ->get();
        $datas = [];

        foreach ($results as $res) {
            $res->mstd_prdcd = $res->mstd_prdcd;
            $res->mstd_qty = $res->qty;
            $res->mstd_qtyk = $res->qtyk;
            $res->mstd_hrgsatuan = $res->mstd_hrgsatuan;
            $res->mstd_gross = $res->mstd_gross;
            $res->satuan = $res->satuan;
            $res->barang = $res->barang;
            $res->supco = $res->mstd_kodesupplier;
            array_push($datas, $res);
        }
        return Datatables::of($datas)
            ->make(true);
    }

    public function delete(Request $request)
    {
        $no_npb = $request->no_npb;

        $periode = '';
        $tgltran = DB::table('tbtr_mstran_h')
            ->selectRaw('to_char(msth_tgldoc,\'yyyymm\') tgl')
            ->where('msth_kodeigr', '=', $_SESSION['kdigr'])
            ->where('msth_typetrn', '=', 'K')
            ->where('msth_nodoc', '=', $no_npb)
            ->where(DB::Raw("nvl(msth_recordid,'0')"), '<>', '1')
            ->orderBy('msth_nodoc', 'desc')
            ->first();
        $tgltran = $tgltran->tgl;

        $periode = DB::table('tbmaster_perusahaan')
            ->selectRaw('prs_tahunberjalan || prs_bulanberjalan periode')
            ->first();
        $periode = $periode->periode;

        if ($periode <> $tgltran) {
            $message = 'Transaksi tidak bisa dibatalkan, karena sudah closing/month end!';
            $status = 'error';
            return compact(['message', 'status']);
        } else {
            DB::beginTransaction();
            $datas = DB::table('tbtr_mstran_h')
                ->join('tbtr_mstran_d', function ($join) {
                    $join->on('msth_nodoc', 'mstd_nodoc');
                    $join->on('msth_kodeigr', 'mstd_kodeigr');
                })
                ->join('tbmaster_prodmast', function ($join) {
                    $join->on('prd_prdcd', 'mstd_prdcd');
                    $join->on('prd_kodeigr', 'mstd_kodeigr');
                })
                ->join('tbmaster_stock', function ($join) {
                    $join->on('st_kodeigr', 'prd_kodeigr');
                    $join->on('st_prdcd', DB::Raw('substr(prd_prdcd,1,6)||\'0\''));
                })
                ->selectRaw('msth_kodeigr,msth_nodoc,msth_tgldoc,mstd_prdcd,mstd_qty,mstd_unit, mstd_frac,mstd_avgcost, mstd_kodesupplier,case when trim(prd_unit) = \'KG\' then 1 else prd_frac end prd_frac,st_avgcost, st_saldoakhir')
                ->where('msth_nodoc', '=', $no_npb)
                ->where('msth_typetrn', '=', 'K')
                ->where('st_lokasi', '=', '02')
                ->get();
            foreach ($datas as $data) {
                $temp = DB::table('tbmaster_stock')
                    ->where('st_prdcd', '=', DB::Raw('substr(' . $data->mstd_prdcd . ',1,6)||\'0\''))
                    ->where('st_kodeigr', '=', $data->msth_kodeigr)
                    ->where('st_lokasi', '=', '02')
                    ->count();

                if ($temp == 0) {
                    DB::table('tbmaster_stock')->insert([
                        'st_kodeigr' => $data->msth_kodeigr,
                        'st_prdcd' => DB::Raw('substr(' . $data->mstd_prdcd . ', 1, 6) || \'0\''),
                        'st_lokasi' => '02'
                    ]);
                }

                $temp = 0;
                $temp = DB::table('tbtr_hapusplu')
                    ->where('del_rtype', '=', 'K')
                    ->where('del_nodokumen', '=', $no_npb)
                    ->where('del_prdcd', '=', $data->mstd_prdcd)
                    ->count();

                if ($temp == 0) {
                    DB::table('tbtr_hapusplu')->insert([
                        'del_kodeigr' => $data->msth_kodeigr,
                        'del_rtype' => 'K',
                        'del_nodokumen' => $data->msth_nodoc,
                        'del_tgldokumen' => $data->msth_tgldoc,
                        'del_prdcd' => $data->mstd_prdcd,
                        'del_avgcostnew' => $data->st_avgcost,
                        'del_stokqtyold' => $data->st_saldoakhir,
                        'del_create_dt' => Carbon::now(),
                        'del_create_by' => $_SESSION['usid'],
                    ]);
                }


                $nqtt = $data->mstd_qty;
                $ncost = 0;
                $nnilai = 0;
                if ($data->mstd_unit == 'kg') {
                    $ncost = $data->mstd_avgcost / 1;
                } else {
                    $ncost = $data->mstd_avgcost / $data->mstd_frac;
                }
                if ($data->st_saldoakhir >= 0) {
                    $nnilai = (($data->st_saldoakhir * $data->st_avgcost) + ($ncost * $nqtt)) / ($data->st_saldoakhir + $nqtt);
                } else {
                    $nnilai = $ncost;
                };

                DB::table('tbmaster_stock')
                    ->where('st_prdcd', $data->mstd_prdcd)
                    ->where('st_lokasi', '02')
                    ->where('st_kodeigr', $data->msth_kodeigr)
                    ->update(
                        [
                            'st_avgcost' => $nnilai,
                            'st_saldoakhir' => DB::Raw('nvl(st_saldoakhir, 0) + ' . $data->mstd_qty),
                            'st_trfout' => DB::Raw('nvl(st_trfout, 0) - ' . $data->mstd_qty),
                            'st_modify_by' => $_SESSION['usid'],
                            'st_modify_dt' => DB::Raw('trunc(sysdate)')
                        ]
                    );

                DB::table('tbhistory_cost')->insert([
                    'hcs_kodeigr' => $data->msth_kodeigr,
                    'hcs_typetrn' => 'K',
                    'hcs_lokasi' => '02',
                    'hcs_prdcd' => $data->mstd_prdcd,
                    'hcs_tglbpb' => $data->msth_tgldoc,
                    'hcs_nodocbpb' => $data->msth_nodoc,
                    'hcs_qtybaru' => $data->mstd_qty,
                    'hcs_qtylama' => $data->st_saldoakhir,
                    'hcs_avglama' => $data->st_avgcost * $data->prd_frac,
                    'hcs_avgbaru' => $nnilai * $data->prd_frac,
                    'hcs_lastqty' => $data->st_saldoakhir * $data->mstd_qty,
                    'hcs_create_by' => $_SESSION['usid'],
                    'hcs_create_dt' => Carbon::now()
                ]);
            }

            DB::table('tbtr_mstran_h')
                ->where('msth_nodoc', $no_npb)
                ->where('msth_kodeigr', $_SESSION['kdigr'])
                ->where('msth_typetrn', 'K')
                ->update(
                    [
                        'msth_recordid' => 1,
                        'msth_modify_by' => $_SESSION['usid'],
                        'msth_modify_dt' => Carbon::now()
                    ]
                );

            DB::table('tbtr_mstran_d')
                ->where('mstd_nodoc', $no_npb)
                ->where('mstd_kodeigr', $_SESSION['kdigr'])
                ->update(
                    [
                        'mstd_recordid' => 1,
                        'mstd_modify_by' => $_SESSION['usid'],
                        'mstd_modify_dt' => Carbon::now()
                    ]
                );

            DB::table('tbtr_hutang')
                ->where('htg_nodokumen', $no_npb)
                ->where('htg_kodeigr', $_SESSION['kdigr'])
                ->where('htg_type', 'D')
                ->update(
                    [
                        'htg_recordid' => '1',
                        'htg_modifyby' => $_SESSION['usid'],
                        'htg_modifydt' => Carbon::now()
                    ]
                );
            DB::table('tbtr_backoffice')
                ->where('trbo_nodoc', $no_npb)
                ->where('trbo_kodeigr', $_SESSION['kdigr'])
                ->update(
                    [
                        'trbo_recordid' => 1,
                    ]
                );

//	 --++update qty history retur++--
            DB::table('TBHISTORY_RETURSUPPLIER')
                ->where('HSR_NODOC', $no_npb)
                ->where('HSR_KODEIGR', $_SESSION['kdigr'])
                ->update(
                    [
                        'HSR_QTYRETUR' => 0,
                        'HSR_MODIFY_BY' => $_SESSION['usid'],
                        'HSR_MODIFY_DT' => Carbon::now()
                    ]
                );
//   ----update qty history retur----
            DB::commit();
        }

        $message = 'Proses Penghapusan Berhasil';
        $status = 'success';
        return compact(['message', 'status']);

    }


}