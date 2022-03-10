<?php

namespace App\Http\Controllers\BACKOFFICE\LAPORAN;

use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller; use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;
use PDF;
use Yajra\DataTables\DataTables;
use ZipArchive;
use File;

class PengirimanController extends Controller
{
    public function index(){
        return view('BACKOFFICE.LAPORAN.pengiriman');
    }

    public function getDataLovDiv(Request $request){
        if(is_null($request->div))
            $div = 1;
        else $div = $request->div;

        $data = DB::connection(Session::get('connection'))->table('tbmaster_divisi')
            ->select('div_kodedivisi','div_namadivisi')
            ->where('div_kodeigr','=',Session::get('kdigr'))
            ->whereRaw('div_kodedivisi >= '.$div)
            ->get();

        return DataTables::of($data)->make(true);
    }

    public function getDataLovDep(Request $request){
        $data = DB::connection(Session::get('connection'))->table('tbmaster_departement')
            ->select('dep_kodedepartement','dep_namadepartement','dep_kodedivisi')
            ->where('dep_kodeigr','=',Session::get('kdigr'))
            ->where('dep_kodedivisi','=',$request->div)
            ->get();

        return DataTables::of($data)->make(true);
    }

    public function getDataLovKat(Request $request){
        $data = DB::connection(Session::get('connection'))->table("tbmaster_kategori")
            ->join('tbmaster_departement','dep_kodedepartement','=','kat_kodedepartement')
            ->select('kat_namakategori','kat_kodekategori','kat_kodedepartement','dep_kodedivisi')
            ->where('kat_kodeigr','=',Session::get('kdigr'))
            ->where('kat_kodedepartement','=',$request->dep)
            ->where('dep_kodedivisi','=',$request->div)
            ->orderBy('kat_kodedepartement')
            ->orderBy('kat_kodekategori')
            ->get();

        return DataTables::of($data)->make(true);
    }

    public function cetak(Request $request){
        $tipe = $request->tipe;
        $tgl1 = $request->tgl1;
        $tgl2 = $request->tgl2;
        $div1 = $request->div1;
        $div2 = $request->div2;
        $dep1 = $request->dep1;
        $dep2 = $request->dep2;
        $kat1 = $request->kat1;
        $kat2 = $request->kat2;

        $perusahaan = DB::connection(Session::get('connection'))->table('tbmaster_perusahaan')
            ->select('prs_namaperusahaan','prs_namacabang')
            ->first();

        if($tipe === '1'){
            $data = DB::connection(Session::get('connection'))->select("select mstd_kodedivisi, div_namadivisi,
                    mstd_kodedepartement, dep_namadepartement,
                    mstd_kodekategoribrg, kat_namakategori,
                    sum(mstd_gross) gross, sum(mstd_pot) pot,
                    sum(mstd_ppn) ppn, sum(mstd_bm) bm, sum(mstd_btl) btl,
                    sum(total) total,
                    sum(GROSS_BKP) subgross, sum(GROSS_BTKP) bgross,
                    sum(POT_BKP) subpot, sum(POT_BTKP) bpot,
                    sum(PPN_BKP) subppn, sum(PPN_BTKP) bppn,
                    sum(BM_BKP) subbm, sum(BM_BTKP) bbm,
                    sum(BTL_BKP) subbtl, sum(BTL_BTKP) bbtl,
                    sum(TOTAL_BKP) subtotal, sum(TOTAL_BTKP)
            from (select mstd_kodedivisi, div_namadivisi,
                    mstd_kodedepartement, dep_namadepartement,
                    mstd_kodekategoribrg, kat_namakategori,
                    CASE WHEN mstd_bkp = 'Y' THEN
                            nvl(mstd_gross,0)
                    END GROSS_BKP,
                    CASE WHEN NVL(mstd_bkp,'N') = 'N' THEN
                            nvl(mstd_gross,0)
                    END GROSS_BTKP,
                    CASE WHEN mstd_bkp = 'Y' THEN
                            nvl(mstd_rphdisc1,0)+nvl(mstd_rphdisc2,0)+nvl(mstd_rphdisc3,0)+nvl(mstd_rphdisc4,0)
                    END POT_BKP,
                    CASE WHEN NVL(mstd_bkp,'N') = 'N' THEN
                            nvl(mstd_rphdisc1,0)+nvl(mstd_rphdisc2,0)+nvl(mstd_rphdisc3,0)+nvl(mstd_rphdisc4,0)
                    END POT_BTKP,
                    CASE WHEN mstd_bkp = 'Y' THEN
                            nvl(mstd_ppnrph,0)
                    END PPN_BKP,
                    CASE WHEN NVL(mstd_bkp,'N') = 'N' THEN
                            nvl(mstd_ppnrph,0)
                    END PPN_BTKP,
                    CASE WHEN mstd_bkp = 'Y' THEN
                            nvl(mstd_ppnbmrph,0)
                    END BM_BKP,
                    CASE WHEN NVL(mstd_bkp,'N') = 'N' THEN
                            nvl(mstd_ppnbmrph,0)
                    END BM_BTKP,
                    CASE WHEN mstd_bkp = 'Y' THEN
                            nvl(mstd_ppnbtlrph,0)
                    END BTL_BKP,
                    CASE WHEN NVL(mstd_bkp,'N') = 'N' THEN
                            nvl(mstd_ppnbtlrph,0)
                    END BTL_BTKP,
                    CASE WHEN mstd_bkp = 'Y' THEN
                            (nvl(mstd_gross,0 )+ nvl(mstd_ppnrph,0) + nvl(mstd_ppnbmrph,0) + nvl(mstd_ppnbtlrph,0)) -
                            (nvl(mstd_rphdisc1,0)+nvl(mstd_rphdisc2,0)+nvl(mstd_rphdisc3,0)+nvl(mstd_rphdisc4,0))
                    END TOTAL_BKP,
                    CASE WHEN NVL(mstd_bkp,'N') = 'N' THEN
                            (nvl(mstd_gross,0 )+ nvl(mstd_ppnrph,0) + nvl(mstd_ppnbmrph,0) + nvl(mstd_ppnbtlrph,0)) -
                            (nvl(mstd_rphdisc1,0)+nvl(mstd_rphdisc2,0)+nvl(mstd_rphdisc3,0)+nvl(mstd_rphdisc4,0))
                    END TOTAL_BTKP,
                    mstd_prdcd, prd_deskripsipanjang, mstd_gross,
                    nvl(mstd_rphdisc1,0)+nvl(mstd_rphdisc2,0)+nvl(mstd_rphdisc3,0)+nvl(mstd_rphdisc4,0) mstd_pot,
                    nvl(mstd_ppnrph,0) mstd_ppn, nvl(mstd_ppnbmrph,0) mstd_bm, nvl(mstd_ppnbtlrph,0) mstd_btl,
                    (nvl(mstd_gross,0 )+ nvl(mstd_ppnrph,0) + nvl(mstd_ppnbmrph,0) + nvl(mstd_ppnbtlrph,0)) -
                    (nvl(mstd_rphdisc1,0)+nvl(mstd_rphdisc2,0)+nvl(mstd_rphdisc3,0)+nvl(mstd_rphdisc4,0)) total
            from tbmaster_divisi, tbmaster_departement, tbmaster_kategori, tbmaster_prodmast,
                    tbtr_mstran_h, tbtr_mstran_d
            where msth_typetrn='O'
                    and nvl(msth_recordid,'0') <> '1'
                    and div_kodeigr(+) = '".Session::get('kdigr')."'
                    and dep_kodedivisi(+) = mstd_kodedivisi
                    and dep_kodeigr(+) = mstd_kodeigr
                    and kat_kodedepartement(+) = mstd_kodedepartement
                    and kat_kodeigr(+) = mstd_kodeigr
                    and div_kodedivisi(+) = mstd_kodedivisi
                    and dep_kodedepartement(+) = mstd_kodedepartement
                    and kat_kodekategori(+) = mstd_kodekategoribrg
                    and prd_kodeigr(+) = mstd_kodeigr
                    and msth_tgldoc between TO_DATE('".$tgl1."','DD/MM/YYYY') and TO_DATE('".$tgl2."','DD/MM/YYYY')
                    and msth_kodeigr(+) = prd_kodeigr
                    and mstd_nodoc = msth_nodoc
                    and mstd_prdcd = prd_prdcd
                    and mstd_kodeigr = msth_kodeigr
                    and mstd_kodedivisi||mstd_kodedepartement||mstd_kodekategoribrg
                    between '".$div1."'||'".$dep1."'||'".$kat1."' and '".$div2."'||'".$dep2."'||'".$kat2."'
                    order by div_kodedivisi, dep_kodedepartement, kat_kodekategori)
            group by mstd_kodedivisi, div_namadivisi,
                    mstd_kodedepartement, dep_namadepartement,
                    mstd_kodekategoribrg, kat_namakategori
            order by mstd_kodedivisi, mstd_kodedepartement, mstd_kodekategoribrg");

//            dd($data);

            return view('BACKOFFICE.LAPORAN.pengiriman-ringkasan-pdf',compact(['perusahaan','data','tgl1','tgl2']));
        }
        else{
            $data = DB::connection(Session::get('connection'))->select("select msth_nodoc, msth_tgldoc, plu, prd_deskripsipanjang, mstd_hrgsatuan, mstd_keterangan, acost, lcost,
                ctn, pcs, kemasan, prs_namaperusahaan, prs_namacabang,
                prs_namawilayah,
                mstd_kodedivisi, div_namadivisi,
                mstd_kodedepartement, dep_namadepartement,
                mstd_kodekategoribrg, kat_namakategori,
                sum(bonus) bonus, sum(gross) gross, sum(potongan) potongan,
                sum(bm) bm, sum(btl) btl, sum(ppn) ppn,
                sum(total) total,
                sum(GROSS_BKP) grossbkp, sum(GROSS_BTKP) grossbtkp,
                sum(POT_BKP) potbkp, sum(POT_BTKP) potbtkp,
                sum(PPN_BKP) ppnbkp, sum(PPN_BTKP) ppnbtkp,
                sum(BM_BKP) bmbkp, sum(BM_BTKP) bmbtkp,
                sum(BTL_BKP) btlbkp, sum(BTL_BTKP) btlbtkp,
                sum(TOTAL_BKP) totalbkp, sum(TOTAL_BTKP) totalbtkp
            from (
                select msth_nodoc, TO_CHAR(msth_tgldoc,'DD/MM/YYYY') msth_tgldoc, mstd_prdcd plu, prd_deskripsipanjang, mstd_hrgsatuan, mstd_keterangan, mstd_avgcost acost,
                    (((nvl(mstd_gross,0)-nvl(mstd_discrph,0)+nvl(mstd_ppnbmrph,0)+nvl(mstd_ppnbtlrph,0)) * nvl(mstd_frac,0)) /
                    (nvl(mstd_qty,0)+nvl(mstd_qtybonus1,0))) lcost,
                    floor(mstd_qty/prd_frac) ctn, mod(mstd_qty,prd_frac) pcs, prd_unit||'/'||prd_frac kemasan,
                    CASE WHEN mstd_bkp = 'Y' THEN
                            nvl(mstd_gross,0)
                    END GROSS_BKP,
                    CASE WHEN NVL(mstd_bkp,'N') = 'N' THEN
                            nvl(mstd_gross,0)
                    END GROSS_BTKP,
                    CASE WHEN mstd_bkp = 'Y' THEN
                            nvl(mstd_discrph,0)
                    END POT_BKP,
                    CASE WHEN NVL(mstd_bkp,'N') = 'N' THEN
                            nvl(mstd_discrph,0)
                    END POT_BTKP,
                    CASE WHEN mstd_bkp = 'Y' THEN
                            nvl(mstd_ppnrph,0)
                    END PPN_BKP,
                    CASE WHEN NVL(mstd_bkp,'N') = 'N' THEN
                            nvl(mstd_ppnrph,0)
                    END PPN_BTKP,
                    CASE WHEN mstd_bkp = 'Y' THEN
                            nvl(mstd_ppnbmrph,0)
                    END BM_BKP,
                    CASE WHEN NVL(mstd_bkp,'N') = 'N' THEN
                            nvl(mstd_ppnbmrph,0)
                    END BM_BTKP,
                    CASE WHEN mstd_bkp = 'Y' THEN
                            nvl(mstd_ppnbtlrph,0)
                    END BTL_BKP,
                    CASE WHEN NVL(mstd_bkp,'N') = 'N' THEN
                            nvl(mstd_ppnbtlrph,0)
                    END BTL_BTKP,
                    CASE WHEN mstd_bkp = 'Y' THEN
                            (nvl(mstd_gross,0 )+ nvl(mstd_ppnrph,0) + nvl(mstd_ppnbmrph,0) + nvl(mstd_ppnbtlrph,0)) - nvl(mstd_discrph,0)
                    END TOTAL_BKP,
                    CASE WHEN NVL(mstd_bkp,'N') = 'N' THEN
                            (nvl(mstd_gross,0 )+ nvl(mstd_ppnrph,0) + nvl(mstd_ppnbmrph,0) + nvl(mstd_ppnbtlrph,0)) - nvl(mstd_discrph,0)
                    END TOTAL_BTKP,
                    prs_namaperusahaan, prs_namacabang, prs_namawilayah,
                    mstd_kodedivisi, div_namadivisi,
                    mstd_kodedepartement, dep_namadepartement,
                    mstd_kodekategoribrg, kat_namakategori,
                    (nvl(mstd_qtybonus1,0)+nvl(mstd_qtybonus2,0)) bonus,
                    nvl(mstd_gross,0) gross,
                    nvl(mstd_discrph,0) potongan,
                    nvl(mstd_ppnbmrph,0) bm, nvl(mstd_ppnbtlrph,0) btl,
                    nvl(mstd_ppnrph,0) ppn,
                    (nvl(mstd_gross,0) + nvl(mstd_ppnbmrph,0) + nvl(mstd_ppnbtlrph,0)+nvl(mstd_ppnrph,0))-nvl(mstd_discrph,0) total
                from tbtr_mstran_h, tbtr_mstran_d, tbmaster_prodmast, tbmaster_perusahaan,
                tbmaster_divisi, tbmaster_departement, tbmaster_kategori
                where msth_typetrn='O'
                    and msth_kodeigr(+) = '".Session::get('kdigr')."'
                    and msth_tgldoc between TO_DATE('".$tgl1."','DD/MM/YYYY') and TO_DATE('".$tgl2."','DD/MM/YYYY')
                    and mstd_nodoc=msth_nodoc
                    and mstd_kodeigr=msth_kodeigr
                    and prd_prdcd=mstd_prdcd
                    and prd_kodeigr(+) = mstd_kodeigr
                    and prs_kodeigr(+) = mstd_kodeigr
                    and div_kodedivisi(+) = mstd_kodedivisi
                    and div_kodeigr(+) = mstd_kodeigr
                    and dep_kodedivisi(+) = mstd_kodedivisi
                    and dep_kodedepartement(+) = mstd_kodedepartement
                    and dep_kodeigr(+) = mstd_kodeigr
                    and kat_kodedepartement(+) = mstd_kodedepartement
                    and kat_kodekategori (+) = mstd_kodekategoribrg
                    and kat_kodeigr (+) = mstd_kodeigr
                    and mstd_kodedivisi||mstd_kodedepartement||mstd_kodekategoribrg
                    between '".$div1."'||'".$dep1."'||'".$kat1."' and '".$div2."'||'".$dep2."'||'".$kat2."'
            order by msth_nodoc, msth_tgldoc, plu)
            group by msth_nodoc, msth_tgldoc, plu, prd_deskripsipanjang, mstd_hrgsatuan, mstd_keterangan, acost, lcost,
                ctn, pcs, kemasan, prs_namaperusahaan, prs_namacabang, prs_namawilayah,
                mstd_kodedivisi, div_namadivisi,
                mstd_kodedepartement, dep_namadepartement,
                mstd_kodekategoribrg, kat_namakategori
            order by mstd_kodedivisi, mstd_kodedepartement, mstd_kodekategoribrg, msth_nodoc, msth_tgldoc, plu");

//            dd($data);

            return view('BACKOFFICE.LAPORAN.pengiriman-rincian-pdf',compact(['perusahaan','data','tgl1','tgl2']));
        }
    }
}
