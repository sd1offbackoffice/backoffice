<?php

namespace App\Http\Controllers\OMI\LAPORAN;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use PDF;

class ReprintBKLController extends Controller
{
    public function index(){
        return view('OMI.LAPORAN.ReprintBKL');
    }

    public function checkKodeOmi(Request $request){
        $kodeomi = strtoupper($request->kodeomi);

        $cekKodeOmi = DB::connection($_SESSION['connection'])->table('tbmaster_tokoigr')->where('tko_kodeomi', $kodeomi)->get()->toArray();

        if (!$cekKodeOmi) {
            return response()->json(['kode' => 0, 'msg' => "Kode OMI tidak terdaftar", 'data' => $kodeomi]);
        }

        $temp = DB::connection($_SESSION['connection'])->table('TBHISTORY_BKL')->where('BKL_KODEOMI', $kodeomi)->get()->toArray();

        if (!$temp) {
            return response()->json(['kode' => 0, 'msg' => "Tidak ada History BKL untuk OMI $kodeomi", 'data' => $kodeomi]);
        } else {
            return response()->json(['kode' => 1, 'msg' => "History BKL Ditemukan", 'data' => $kodeomi]);
        }
    }

    public function getDataLov(Request $request) {
        $noBukti = strtoupper($request->noBukti);
        $kodeOmi = strtoupper($request->kodeomi);

        $datas = DB::connection($_SESSION['connection'])->table('TBHISTORY_BKL')
            ->where('BKL_KODEOMI', $kodeOmi)
            ->where('bkl_nobukti', 'like', "%$noBukti%")
            ->orderByDesc('BKL_TGLSTRUK')
            ->get()->toArray();

        return Datatables::of($datas)->make(true);
    }

    public function cekNomorBukti(Request $request) {
        $noBukti = strtoupper($request->noBukti);
        $kodeOmi = strtoupper($request->kodeomi);

        $data = DB::connection($_SESSION['connection'])->table('TBHISTORY_BKL')
            ->where('BKL_KODEOMI', $kodeOmi)
            ->where('bkl_nobukti', $noBukti)
            ->orderByDesc('BKL_TGLSTRUK')
            ->get()->toArray();

        if (!$data) {
            return response()->json(['kode' => 0, 'msg' => "Tidak ada History BKL untuk OMI $kodeOmi", 'data' => '']);
        } else {
            return response()->json(['kode' => 1, 'msg' => "History BKL Ditemukan", 'data' => $data]);
        }
    }

    public function cetakLaporan(Request  $request){
        $report_id  = $request->report_id;
        $noBukti    = strtoupper($request->nobukti);
        $kodeOmi    = strtoupper($request->kodeomi);
        $kodeigr    = $_SESSION['kdigr'];
        $bladeName  = '';
        $result     = '';
        $pdfName    = '';

        $data = DB::connection($_SESSION['connection'])->table('TBHISTORY_BKL')
                ->where('BKL_KODEOMI', $kodeOmi)
                ->where('bkl_nobukti', $noBukti)
                ->orderByDesc('BKL_TGLSTRUK')
                ->get()->toArray();

        if ($report_id == 1){
            $result     = $this->laporanBpb($kodeigr, $data[0]->bkl_nodoc ?? '00000');
            $bladeName  = "OMI.LAPORAN.ReprintBKL-bpb-pdf";
            $pdfName    = "ReprintBKL-bpb.pdf";
        } elseif ($report_id == 2){
            $noBukti = $data[0]->bkl_nobukti;
            $noDoc = $data[0]->bkl_nodoc;
            $supplier = $data[0]->bkl_kodesupplier;

            $temp = DB::connection($_SESSION['connection'])->select("select bkl_nostruk || bkl_kodestation as all_kasir, bkl_kodeomi
                                        from tbhistory_bkl
                                        where bkl_nodoc = '$noDoc'
                                        and bkl_nobukti = '$noBukti'
                                        and bkl_kodesupplier = '$supplier'");

            $result     = $this->laporanStruk($kodeigr, $temp[0]->all_kasir, $temp[0]->bkl_kodeomi);
            $bladeName  = "OMI.LAPORAN.ReprintBKL-struk-pdf";
            $pdfName    = "ReprintBKL-struk.pdf";
        }

        $pdf = PDF::loadview("$bladeName",[ 'result' => $result]);
        $pdf->setPaper('A4', 'potrait');
        $pdf->output();
        $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);

        return $pdf->stream("$pdfName");
    }

    public function laporanBpb($kodeigr, $no_po){
        return DB::connection($_SESSION['connection'])->select("SELECT  msth_nodoc, msth_tgldoc, msth_nopo, msth_tglpo, msth_nofaktur, msth_tglfaktur, msth_cterm, msth_flagdoc, (TRUNC (mstd_tgldoc) + msth_cterm) tgljt,
                                           mstd_cterm, mstd_typetrn, prs_namaperusahaan, prs_namacabang, prs_npwp, prs_alamatfakturpajak1, prs_alamatfakturpajak2, prs_alamatfakturpajak3,
                                           sup_kodesupplier || ' ' || sup_namasupplier || '/' || sup_singkatansupplier supplier,
                                           sup_npwp,
                                           sup_alamatsupplier1 || '   ' || sup_alamatsupplier2 alamat_supplier,
                                           sup_telpsupplier,
                                           sup_contactperson contact_person,
                                           sup_kotasupplier3,
                                           mstd_prdcd || ' ' || prd_deskripsipanjang plu,
                                           mstd_unit || '/' || mstd_frac kemasan,
                                           FLOOR (mstd_qty / mstd_frac) qty,
                                           MOD (mstd_qty, mstd_frac) qtyk,
                                           mstd_hrgsatuan, mstd_ppnrph, mstd_ppnbmrph, mstd_ppnbtlrph,
                                           NVL (mstd_gross, 0) - NVL (mstd_discrph, 0) + NVL (mstd_dis4cr, 0) + NVL (mstd_dis4rr, 0) + NVL (mstd_dis4jr, 0) jumlah,
                                           ROUND (NVL (mstd_gross, 0) - NVL (mstd_discrph, 0) + NVL (mstd_dis4cr, 0) + NVL (mstd_dis4rr, 0) + NVL (mstd_dis4jr, 0)) JML,
                                           NVL (mstd_rphdisc1, 0) rphdisc1,
                                           (NVL (mstd_rphdisc2, 0) + NVL (mstd_rphdisc2ii, 0) + NVL (mstd_rphdisc2iii, 0)) disc2,
                                           NVL (mstd_rphdisc3, 0) rphdisc3,
                                           NVL (mstd_qtybonus1, 0) qtybonus1,
                                           NVL (mstd_qtybonus2, 0) qtybonus2,
                                           NVL (mstd_keterangan, 'OO') keterangan,
                                           (NVL (mstd_dis4cr, 0) + NVL (mstd_dis4rr, 0) + NVL (mstd_dis4jr, 0)) dis4,
                                           CASE
                                              WHEN NVL (mstd_kodesupplier, '11111') <> '11111' THEN '( PROFORMA)'
                                              ELSE '( LAIN - LAIN )'
                                           END
                                              judul
                                      FROM tbtr_mstran_h,
                                           tbmaster_perusahaan,
                                           tbmaster_supplier,
                                           tbtr_mstran_d,
                                           tbmaster_prodmast
                                     WHERE     msth_kodeigr = '$kodeigr'
                                           AND prs_kodeigr = msth_kodeigr
                                           AND sup_kodesupplier(+) = msth_kodesupplier
                                           AND sup_kodeigr(+) = msth_kodeigr
                                           AND mstd_nodoc = msth_nodoc
                                           AND mstd_kodeigr = msth_kodeigr
                                           AND prd_kodeigr = msth_kodeigr
                                           AND prd_prdcd = mstd_prdcd
                                           --&p_and
                                           AND msth_nodoc = '$no_po'");
    }

    public function laporanStruk($kodeigr, $kasir, $kodeomi){
        return DB::connection($_SESSION['connection'])->select("SELECT 'NPWP : ' || prs_npwp prs_npwp,  prs_namaperusahaan, prs_namacabang, prs_alamat1, prs_alamat2||' '||prs_alamat3 alamat, 'Telp : ' || prs_telepon PRS_TELEPON,
                                        trjd_create_by, trjd_cashierstation, trjd_transactionno, prd_deskripsipendek, '( ' || trjd_prdcd || ')' TRJD_PRDCD, trjd_quantity,
                                        trjd_baseprice, nvl(trjd_discount,0) trjd_discount, trjd_nominalamt,
                                        trjd_admfee, trjd_cus_kodemember, cus_namamember, SUBSTR(jh_kmmcode,1, INSTR(jh_kmmcode,' ')-1) nobukti, tko_namaomi,
                                        prs_kodemto || '.BKL.' || trjd_cashierstation || '.' || trjd_transactionno nomor,
                                        TO_CHAR(SYSDATE, 'dd-MM-yy hh:mm:ss') TANGGAL, round(tko_persendistributionfee) || ' %' fee
                                        FROM tbtr_jualdetail, tbtr_jualheader, tbmaster_prodmast, tbmaster_customer, tbmaster_tokoigr, tbmaster_perusahaan
                                        WHERE prs_kodeigr = '$kodeigr' and trjd_kodeigr = '$kodeigr'
                                        AND trjd_create_by = 'BKL'
                                        --AND TRUNC(trjd_transactiondate) = trunc(sysdate)
                                        AND jh_kodeigr = '$kodeigr'
                                        AND jh_cashierid = 'BKL'
                                        AND jh_transactionno = trjd_transactionno
                                        AND jh_cashierstation = trjd_cashierstation
                                        AND TRUNC(jh_transactiondate) = TRUNC(trjd_transactiondate)
                                        AND prd_kodeigr = '$kodeigr'  AND prd_prdcd = trjd_prdcd
                                        AND cus_kodeigr = '$kodeigr'
                                        AND cus_kodemember = trjd_cus_kodemember
                                        AND tko_kodeigr = '$kodeigr'
                                        AND tko_kodecustomer = trjd_cus_kodemember
                                        AND tko_kodeomi= '$kodeomi'
                                        AND trjd_transactionno || trjd_cashierstation IN (''||'$kasir'||'')");
    }

}
