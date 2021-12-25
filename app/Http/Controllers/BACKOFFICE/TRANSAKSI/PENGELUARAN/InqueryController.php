<?php

namespace App\Http\Controllers\BACKOFFICE\TRANSAKSI\PENGELUARAN;

use App\Http\Controllers\Connection;
use Carbon\Carbon;
use Dompdf\Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller; use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Expr\Cast\Object_;
use Yajra\DataTables\DataTables;


class InqueryController extends Controller
{
    public function index()
    {
        return view('BACKOFFICE.TRANSAKSI.PENGELUARAN.inquery');
    }

    public function getDataLovNPB()
    {
        $data = DB::connection(Session::get('connection'))->table('tbtr_mstran_h')
            ->select('msth_nodoc', 'msth_tgldoc')
            ->where('msth_kodeigr', '=', Session::get('kdigr'))
            ->where('msth_typetrn', '=', 'K')
            ->where(DB::connection(Session::get('connection'))->raw("nvl(msth_recordid,'0')"), '<>', '1')
            ->orderBy('msth_nodoc', 'desc')
            ->limit(1000)
            ->get();
        return Datatables::of($data)->make(true);
    }

    public function getDataNPB(Request $request)
    {
        $noNPB = $request->no_npb;

        $results = DB::connection(Session::get('connection'))->table('tbtr_mstran_h')
            ->join('tbtr_mstran_d', 'msth_nodoc', '=', 'mstd_nodoc')
            ->join('tbmaster_prodmast', 'mstd_prdcd', '=', 'prd_prdcd')
            ->rightJoin('tbmaster_supplier', 'msth_kodesupplier', '=', 'sup_kodesupplier')
            ->selectRaw('msth_nodoc, msth_tgldoc, msth_istype, msth_invno, msth_tglinv, mstd_unit||\'/\'||mstd_frac satuan,
									mstd_prdcd, mstd_noref3, floor(mstd_qty/mstd_frac) mstd_qty, mod(mstd_qty,mstd_frac) mstd_qtyk, mstd_gross, mstd_ppnrph, mstd_discrph,
									((mstd_gross - mstd_discrph) * mstd_frac) / (floor(mstd_qty/mstd_frac) * mstd_frac + mod(mstd_qty,mstd_frac))nPrice,
									mstd_gross - mstd_discrph nAmt,
									prd_deskripsipanjang,
									sup_kodesupplier||\'-\'||sup_namasupplier supp, sup_pkp')
            ->where('msth_kodeigr', '=', Session::get('kdigr'))
            ->where('msth_typetrn', '=', 'K')
            ->where('msth_nodoc', '=', $noNPB)
            ->where(DB::connection(Session::get('connection'))->raw("nvl(msth_recordid,'0')"), '<>', '1')
            ->orderBy('msth_nodoc', 'desc')
            ->get();
        $datas = [];

        foreach ($results as $res) {
            $res->totalall = $res->mstd_gross - $res->mstd_discrph + $res->mstd_ppnrph;
            array_push($datas, $res);
        }
        return Datatables::of($datas)
            ->addColumn('detail', function ($datas) {
                $data = '<button class="btn btn-primary btn-detail" plu="' . $datas->mstd_prdcd . '">Detail<i class="fa fa-search" aria-hidden="true"></i></button> <br>';
                return $data;
            })->rawColumns(['detail'])
            ->make(true);
    }

    public function getDataDetail(Request $request)
    {
        $no_npb = $request->no_npb;
        $plu = $request->plu;
        $noref3 = $request->noref3;

        $data = DB::connection(Session::get('connection'))->table('tbtr_mstran_d')
            ->join('tbmaster_prodmast', function ($join) {
                $join->on('prd_prdcd', 'mstd_prdcd');
                $join->on('prd_kodeigr', 'mstd_kodeigr');
            })
            ->leftJoin('tbmaster_stock', function ($join) {
                $join->on('st_kodeigr', 'prd_kodeigr');
                $join->on('st_prdcd', 'prd_prdcd');
                $join->on('st_lokasi', DB::connection(Session::get('connection'))->raw('02'));
            })
            ->selectRaw('mstd_prdcd plu, prd_deskripsipanjang barang, mstd_unit||\'/\'||mstd_frac kemasan, prd_kodetag tag, prd_flagbandrol bandrol, mstd_bkp bkp, prd_frac, case when st_lastcost is null or st_lastcost =0 then  prd_lastcost else st_lastcost * case when prd_unit=\'KG\' then 1 else prd_frac end end lastcost, st_avgcost * case when prd_unit =\'KG\' then 1 else prd_frac end avgcost, mstd_hrgsatuan hrgsat, floor(mstd_qty/prd_frac) qty, prd_unit unit, mod(mstd_qty,prd_frac) qtyk,
             mstd_gross gross, mstd_discrph discrph, mstd_ppnrph ppnrph, mstd_keterangan ket, st_saldoakhir')
            ->where('mstd_nodoc', '=', $no_npb)
            ->where('mstd_prdcd', '=', $plu)
//            ->where('mstd_noref3', '=', $noref3)
            ->where('mstd_kodeigr', '=', Session::get('kdigr'))
            ->first();

        $data->ndiscp = ((float)$data->discrph * 100 / (float)$data->gross);
        $data->ndpp = ($data->gross - $data->discrph);
        $data->nppnp = ($data->ppnrph * 100 / $data->ndpp);
        $data->namt = ($data->ndpp + $data->ppnrph);
        $data->dplu = $data->plu . '-' . $data->barang;
        $data->dsatuan = $data->kemasan;
        $data->dtag = $data->tag;
        $data->dbandrol = $data->bandrol;
        $data->bkp = $data->bkp;
        $data->dlcost = $data->lastcost;
        $data->dacost = $data->avgcost;
        $data->dhrgsat = $data->hrgsat;
        $data->dqty = $data->qty;
        $data->dunit = $data->unit;
        $data->dqtyk = $data->qtyk;
        $data->drp1 = $data->gross;
        $data->dpersen1 = $data->ndiscp;
        $data->drp2 = $data->discrph;
        $data->drp3 = $data->ndpp;
        $data->dpersen2 = $data->nppnp;
        $data->drp4 = $data->ppnrph;
        $data->drp5 = $data->namt;
        $data->dket = $data->ket;
        $data->dstok = $data->st_saldoakhir / $data->prd_frac;
        $data->dstok2 = $data->st_saldoakhir % $data->prd_frac;

        return compact('data');

    }


}
