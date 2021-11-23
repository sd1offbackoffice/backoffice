<?php

namespace App\Http\Controllers\OMI\LAPORAN;

use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;
use PDF;
use Yajra\DataTables\DataTables;

class CetakFakturPajakController extends Controller
{
    public function index(){
        return view('OMI.LAPORAN.cetak-faktur-pajak');
    }

    public function getData(Request $request){
        $data = DB::connection($_SESSION['connection'])
            ->select("SELECT DISTINCT FKT_KODEMEMBER, TRUNC(FKT_TGL) FKT_TGL, TKO_KODEOMI,
    		                 TKO_NAMAOMI, CASE WHEN trjd_create_by = 'BKL' THEN 'BKL' ELSE trjd_create_by END kasir,
    		                 FKT_SIGN status
           FROM TBMASTER_FAKTUR, TBMASTER_TOKOIGR, TBTR_JUALDETAIL
           WHERE FKT_KODEIGR = '".$_SESSION['kdigr']."'
            AND TRUNC(FKT_TGL)= TRUNC(TO_DATE('".$request->tanggal."','dd/mm/yyyy'))
            AND FKT_KODEMEMBER  IN (SELECT tko_kodecustomer FROM TBMASTER_TOKOIGR)
            AND trjd_cus_kodemember = fkt_kodemember
            AND (trjd_noinvoice1 = fkt_nofaktur OR trjd_noinvoice2 = fkt_nofaktur)
            AND trunc(trjd_transactiondate) = TRUNC(fkt_tgl)
            AND (NVL(trjd_noinvoice1, 0) > 0 OR NVL(trjd_noinvoice2, 0) > 0)
            AND TKO_KODEIGR = FKT_KODEIGR
            AND TKO_KODECUSTOMER = FKT_KODEMEMBER
          ORDER BY TKO_KODEOMI");

        return DataTables::of($data)->make(true);
    }

    public function print(Request $request){
        $tanggal = $request->tanggal;
        $kodemember = $request->kodemember;
        $nama = $request->nama;
        $jabatan = $request->jabatan;

        $perusahaan = DB::connection($_SESSION['connection'])
            ->table("tbmaster_perusahaan")
            ->first();

        $data = DB::connection($_SESSION['connection'])
            ->select("SELECT JUDUL, CORET, NO_FP, fkt_sign, fkt_station, fkt_notransaksi, fkt_kasir,
         TGL_FP, NAMA_CUST, ALMT_C_1, ALMT_C_2,
         NPWP_CUST, NPPKP,  NAMA_BRG,
         SUM (KUANTITAS) KUANTITAS, SUM (HRG_SATUAN) HRG_SATUAN,
         SUM (DISCOUNT) DISCOUNT, SUM (JUMLAH) JUMLAH, SUM(PPN) PPN
  FROM (SELECT '                   ' JUDUL,
               '           XXXXXXXXXXXXXXXXXX' CORET,
               SUBSTR(fkt_noseri, 1, 19) no_fp, fkt_sign, fkt_station, fkt_notransaksi, fkt_kasir,
               TO_CHAR(fp.fkt_tglfaktur, 'DD ')
               || CASE
                   WHEN TO_CHAR(fp.fkt_tglfaktur, 'MON') = 'JAN'
                       THEN 'JANUARI'
                   WHEN TO_CHAR(fp.fkt_tglfaktur, 'MON') = 'FEB'
                       THEN 'FEBRUARI'
                   WHEN TO_CHAR(fp.fkt_tglfaktur, 'MON') = 'MAR'
                       THEN 'MARET'
                   WHEN TO_CHAR(fp.fkt_tglfaktur, 'MON') = 'APR'
                       THEN 'APRIL'
                   WHEN TO_CHAR(fp.fkt_tglfaktur, 'MON') = 'MAY'
                       THEN 'MEI'
                   WHEN TO_CHAR(fp.fkt_tglfaktur, 'MON') = 'JUN'
                       THEN 'JUNI'
                   WHEN TO_CHAR(fp.fkt_tglfaktur, 'MON') = 'JUL'
                       THEN 'JULI'
                   WHEN TO_CHAR(fp.fkt_tglfaktur, 'MON') = 'AUG'
                       THEN 'AGUSTUS'
                   WHEN TO_CHAR(fp.fkt_tglfaktur, 'MON') = 'SEP'
                       THEN 'SEPTEMBER'
                   WHEN TO_CHAR(fp.fkt_tglfaktur, 'MON') = 'OCT'
                       THEN 'OKTOBER'
                   WHEN TO_CHAR(fp.fkt_tglfaktur, 'MON') = 'NOV'
                       THEN 'NOPEMBER'
                   ELSE 'DESEMBER'
               END
               || TO_CHAR(fp.fkt_tglfaktur, ' YYYY') tgl_fp,
               hcasa.cus_namamember NAMA_CUST,
               CASE WHEN pwp_alamat IS NOT NULL THEN
                      pwp_alamat
               ELSE
                      hcasa.cus_alamatmember1
               END ALMT_C_1,
               CASE WHEN pwp_alamat IS NOT NULL THEN
                      pwp_kelurahan||' '||pwp_kota||' '||pwp_kodepos
               ELSE
                     hcasa.cus_alamatmember4||' '||hcasa.cus_alamatmember2||' '||hcasa.cus_alamatmember3
               END ALMT_C_2,
               hcasa.cus_npwp NPWP_CUST,
               hcasa.cus_npwp NPPKP,
               prd_deskripsipendek NAMA_BRG,
               NVL(trjd_quantity * prd_frac, 0) KUANTITAS,
               NVL(trjd_unitprice, 0) HRG_SATUAN,
               NVL(trjd_discount,0) DISCOUNT,
               (trjd_nominalamt + NVL(trjd_discount,0)) JUMLAH,
               (trjd_nominalamt * 0.1) PPN
          FROM TBMASTER_FAKTUR fp, TBTR_JUALDETAIL d, TBMASTER_PRODMAST pm,
               TBMASTER_CUSTOMER hcasa, TBMASTER_NPWP
         WHERE fp.fkt_kodeigr = d.trjd_kodeigr
           AND fp.fkt_tipe = d.trjd_transactiontype
           AND fp.fkt_kodemember = d.trjd_cus_kodemember
           AND TRUNC(fp.fkt_tgl) = TRUNC(d.trjd_transactiondate)
           AND (fp.fkt_nofaktur = trjd_noinvoice1 OR fp.fkt_nofaktur = trjd_noinvoice2)
           AND fp.FKT_KODEMEMBER  IN (SELECT tko_kodecustomer FROM TBMASTER_TOKOIGR )
           AND d.trjd_recordid IS NULL
           AND d.trjd_flagtax1 = 'Y'
           AND d.trjd_flagtax2 = 'Y'
           AND fp.fkt_kodeigr = pwp_kodeigr(+)
           AND fp.fkt_kodemember = pwp_kodemember(+)
           AND fp.fkt_kodeigr = hcasa.cus_kodeigr
           AND fp.fkt_kodemember = hcasa.cus_kodemember
           AND hcasa.cus_jenismember IN ('O', 'K', 'M', 'I')
           AND d.trjd_create_by = '".$request->kasir."'
           AND d.trjd_prdcd = pm.prd_prdcd
           AND d.trjd_kodeigr = pm.prd_kodeigr
           AND fp.fkt_kodemember = '".$request->kodemember."'
           AND fp.fkt_recordid IS NULL
           AND TRUNC(fp.fkt_tgl) = TRUNC(to_date('".$request->tanggal."','dd/mm/yyyy'))
           AND fp.fkt_kodeigr = '".$_SESSION['kdigr']."'
        UNION ALL
        SELECT '                   ' JUDUL,
               '           XXXXXXXXXXXXXXXXXX' CORET,
               SUBSTR(fkt_noseri, 1, 19) no_fp, fkt_sign, fkt_station, fkt_notransaksi, fkt_kasir,
               TO_CHAR(fkt_tglfaktur, 'DD ')
               || CASE
                   WHEN TO_CHAR(fkt_tglfaktur, 'MON') = 'JAN'
                       THEN 'JANUARI'
                   WHEN TO_CHAR(fkt_tglfaktur, 'MON') = 'FEB'
                       THEN 'FEBRUARI'
                   WHEN TO_CHAR(fkt_tglfaktur, 'MON') = 'MAR'
                       THEN 'MARET'
                   WHEN TO_CHAR(fkt_tglfaktur, 'MON') = 'APR'
                       THEN 'APRIL'
                   WHEN TO_CHAR(fkt_tglfaktur, 'MON') = 'MAY'
                       THEN 'MEI'
                   WHEN TO_CHAR(fkt_tglfaktur, 'MON') = 'JUN'
                       THEN 'JUNI'
                   WHEN TO_CHAR(fkt_tglfaktur, 'MON') = 'JUL'
                       THEN 'JULI'
                   WHEN TO_CHAR(fkt_tglfaktur, 'MON') = 'AUG'
                       THEN 'AGUSTUS'
                   WHEN TO_CHAR(fkt_tglfaktur, 'MON') = 'SEP'
                       THEN 'SEPTEMBER'
                   WHEN TO_CHAR(fkt_tglfaktur, 'MON') = 'OCT'
                       THEN 'OKTOBER'
                   WHEN TO_CHAR(fkt_tglfaktur, 'MON') = 'NOV'
                       THEN 'NOPEMBER'
                   ELSE 'DESEMBER'
               END
               || TO_CHAR(fkt_tglfaktur, ' YYYY') tgl_fp,
               cus_namamember NAMA_CUST,
               CASE WHEN pwp_alamat IS NOT NULL THEN
                      pwp_alamat
               ELSE
                      cus_alamatmember1
               END ALMT_C_1,
               CASE WHEN pwp_alamat IS NOT NULL THEN
                      pwp_kelurahan||' '||pwp_kota||' '||pwp_kodepos
               ELSE
                     cus_alamatmember4||' '||cus_alamatmember2||' '||cus_alamatmember3
               END ALMT_C_2,
               cus_npwp NPWP_CUST,
               cus_npwp NPPKP,
               'OMI DISTRIBUTIONS FEE 2%' NAMA_BRG,
               0 KUANTITAS,
               0 HRG_SATUAN,
               0 DISCOUNT,
               NVL(trjd_admfee,0) JUMLAH,
               (NVL(trjd_admfee,0)* 0.1) PPN
          FROM TBMASTER_FAKTUR , TBMASTER_CUSTOMER, TBTR_JUALDETAIL, TBMASTER_NPWP
          WHERE fkt_kodeigr = '".$_SESSION['kdigr']."'
           AND TRUNC(fkt_tgl) = TRUNC(to_date('".$request->tanggal."','dd/mm/yyyy'))
           AND fkt_kodemember = '".$request->kodemember."'
           AND fkt_recordid IS NULL
           AND cus_jenismember IN ('O', 'K', 'M')
           AND cus_kodemember = fkt_kodemember
           AND pwp_kodeigr(+) = fkt_kodeigr
           AND pwp_kodemember(+) = fkt_kodemember
           AND trjd_cus_kodemember = fkt_kodemember
           AND trjd_create_by = '".$request->kasir."'
           AND (trjd_noinvoice1 = fkt_nofaktur OR trjd_noinvoice2 = fkt_nofaktur)
           AND TRUNC(trjd_transactiondate) = TRUNC(fkt_tgl)
           AND (NVL(trjd_noinvoice1, 0) > 0 OR NVL(trjd_noinvoice2, 0) > 0))
GROUP BY JUDUL, CORET, NO_FP,fkt_sign, fkt_station, fkt_notransaksi, fkt_kasir, TGL_FP,
          NAMA_CUST, ALMT_C_1, ALMT_C_2, NPWP_CUST, NPPKP, NAMA_BRG
ORDER BY kuantitas DESC");

        return view('OMI.LAPORAN.cetak-faktur-pajak-pdf',compact(['perusahaan','data','tanggal','kodemember','nama','jabatan']));
    }
}
