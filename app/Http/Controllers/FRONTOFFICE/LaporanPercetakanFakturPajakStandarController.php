<?php

namespace App\Http\Controllers\FRONTOFFICE;

use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller; use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;
use PDF;
use Yajra\DataTables\DataTables;
use File;

class LaporanPercetakanFakturPajakStandarController extends Controller
{
    public function index()
    {
        return view('FRONTOFFICE.LAPORANPERCETAKANFAKTURPAJAKSTANDAR.laporan-percetakan-faktur-pajak-standar');
    }

    public function cetakPKP(Request $request)
    {
        $tgl1 = $request->tgl1;
        $tgl2 = $request->tgl2;
        $w = 545;
        $h = 50.75;

        $data = DB::connection(Session::get('connection'))->select("SELECT prs_namaperusahaan,
         prs_namacabang,
         tgl_struk,
         customer,
         station,
         kasir,
         struk_no,
         no_seri_fp,
         tgl_fp,
         NVL (
              total_dpp
            + +CASE
                  WHEN NVL (OBI_ATTRIBUTE2, 'N') IN ('KlikIGR', 'Corp')
                  THEN
                     ROUND (OBI_EKSPEDISI / 1.1)
                  ELSE
                     0
               END,
            dpp)
            dpp,
         NVL (
              total_ppn
            + +CASE
                  WHEN NVL (OBI_ATTRIBUTE2, 'N') IN ('KlikIGR', 'Corp')
                  THEN
                     (OBI_EKSPEDISI - ROUND (OBI_EKSPEDISI / 1.1))
                  ELSE
                     0
               END,
            ppn)
            ppn
    FROM (  SELECT tgl_struk,
                   customer,
                   station,
                   kasir,
                   struk_no,
                   no_seri_fp,
                   tgl_fp,
                   TRUNC (SUM (DPP + DF + TTL_REFUND)) dpp,
                   TRUNC (SUM (dpp + DF + TTL_REFUND) * 0.1) ppn
              FROM (  SELECT a.*, NVL (b.nominal, 0) TTL_REFUND
                        FROM (  SELECT TRUNC (fkt_tglfaktur) tgl_struk,
                                       cus_kodemember || ' - ' || cus_namamember
                                          customer,
                                       FKT_STATION station,
                                          trjd_create_by
                                       || ' - '
                                       || CASE
                                             WHEN trjd_create_by LIKE 'OM_'
                                             THEN
                                                'KSR.OMI'
                                             WHEN trjd_create_by LIKE 'ID_'
                                             THEN
                                                'KSR.IDM'
                                             ELSE
                                                CASE
                                                   WHEN trjd_create_by = 'ONL'
                                                   THEN
                                                      'KSR.ONL'
                                                   ELSE
                                                      'KSR.REG'
                                                END
                                          END
                                          kasir,
                                       FKT_NOTRANSAKSI struk_no,
                                       REPLACE (fkt_noseri, 'Y', '') no_seri_fp,
                                       FKT_TGLFAKTUR TGL_FP,
                                       CASE
                                          WHEN    trjd_create_by LIKE 'OM%'
                                               OR trjd_create_by = 'BKL'
                                               OR trjd_create_by LIKE 'ID%'
                                          THEN
                                             CASE
                                                WHEN TRJD_FLAGTAX1 = 'Y'
                                                THEN
                                                   FLOOR (
                                                      SUM (NVL (TRJD_NOMINALAMT, 0)))
                                                ELSE
                                                   0
                                             END
                                          ELSE
                                             FLOOR (
                                                SUM (NVL (TRJD_NOMINALAMT / 1.1, 0)))
                                       END
                                          DPP,
                                       CASE
                                          WHEN    trjd_create_by LIKE 'OM%'
                                               OR trjd_create_by = 'BKL'
                                               OR trjd_create_by LIKE 'ID%'
                                          THEN
                                             FLOOR (
                                                  SUM (
                                                       NVL (TRJD_NOMINALAMT, 0)
                                                     + NVL (TRJD_ADMFEE, 0))
                                                * 0.1)
                                          ELSE
                                             FLOOR (
                                                  SUM (
                                                       NVL (TRJD_NOMINALAMT / 1.1, 0)
                                                     + NVL (TRJD_ADMFEE, 0))
                                                * 0.1)
                                       END
                                          PPN,
                                       CASE
                                          WHEN TRJD_FLAGTAX1 = 'Y'
                                          THEN
                                             TRUNC (SUM (TRJD_ADMFEE))
                                          ELSE
                                             TRUNC (SUM (TRJD_ADMFEE))
                                       END
                                          DF,
                                       FKT_KODEMEMBER,
                                       FKT_NOFAKTUR,
                                       FKT_TGL
                                  FROM tbmaster_faktur,
                                       tbtr_jualdetail,
                                       tbmaster_customer,
                                       tbmaster_tokoigr,
                                       tbmaster_npwp
                                 WHERE     (   fkt_nofaktur = trjd_noinvoice1
                                            OR fkt_nofaktur = trjd_noinvoice2)
                                       AND trjd_cus_kodemember = cus_kodemember
                                       AND trjd_cus_kodemember = cus_kodemember
                                       AND fkt_kodemember = trjd_cus_kodemember
                                       AND trjd_cus_kodemember = pwp_kodemember(+)
                                       AND trjd_cus_kodemember = tko_kodecustomer(+)
                                       AND (   NVL (TRJD_FLAGTAX1, 'N') = 'Y'
                                            OR TRJD_ADMFEE > 0)
                                       AND cus_flagpkp = 'Y'
                                       AND trjd_transactiontype = 'S'
                                       AND TRUNC (trjd_transactiondate) BETWEEN to_date('" . $tgl1 . "','dd/mm/yyyy')
                                                                            AND to_date('" . $tgl2 . "','dd/mm/yyyy')
                              GROUP BY fkt_tglfaktur,
                                       cus_kodemember,
                                       CUS_NAMAMEMBER,
                                       FKT_STATION,
                                       fkt_noseri,
                                       FKT_TGLFAKTUR,
                                       FKT_NOTRANSAKSI,
                                       FKT_KODEMEMBER,
                                       FKT_NOFAKTUR,
                                       FKT_TGL,
                                       TRJD_CREATE_BY,
                                       TRJD_FLAGTAX1) a
                             FULL JOIN
                             (  SELECT kdmember,
                                       nofaktur,
                                       SUM (nominal) nominal,
                                       tgltrans
                                  FROM (SELECT DISTINCT
                                               CUS_KODEMEMBER kdmember,
                                               TRJD_NOINVOICE1 nofaktur,
                                                 CASE
                                                    WHEN jh_transactiontype = 'S'
                                                    THEN
                                                       1
                                                    ELSE
                                                       -1
                                                 END
                                               * CASE
                                                    WHEN    JH_CASHIERID LIKE 'OM%'
                                                         OR JH_CASHIERID = 'BKL'
                                                         OR JH_CASHIERID LIKE 'ID%'
                                                    THEN
                                                       TRJD_NOMINALAMT
                                                    ELSE
                                                       FLOOR (TRJD_NOMINALAMT / 1.1)
                                                 END
                                                  nominal,
                                               TRUNC (jh_referencedate) tgltrans
                                          FROM tbtr_jualheader,
                                               tbmaster_customer,
                                               tbtr_jualdetail
                                         WHERE     jh_transactiontype = 'R'
                                               AND cus_flagpkp = 'Y'
                                               AND (   NVL (TRJD_FLAGTAX1, 'N') = 'Y'
                                                    OR TRJD_ADMFEE > 0)
                                               AND (   trjd_noinvoice1 <> '0'
                                                    OR trjd_noinvoice2 <> '0')
                                               AND TRJD_NOMINALAMT > 0
                                               AND TRUNC (jh_referencedate) BETWEEN to_date('" . $tgl1 . "','dd/mm/yyyy')
                                                                                AND to_date('" . $tgl2 . "','dd/mm/yyyy')
                                               AND JH_CUS_KODEMEMBER = CUS_KODEMEMBER
                                               AND JH_CUS_KODEMEMBER =
                                                      TRJD_CUS_KODEMEMBER
                                               AND JH_TRANSACTIONNO =
                                                      TRJD_TRANSACTIONNO
                                               AND TRUNC (JH_TRANSACTIONDATE) =
                                                      TRUNC (TRJD_TRANSACTIONDATE)
                                               AND JH_CASHIERSTATION =
                                                      TRJD_CASHIERSTATION
                                               AND JH_CASHIERID = TRJD_CREATE_BY) BB
                              GROUP BY kdmember, nofaktur, tgltrans) B
                                ON     a.FKT_KODEMEMBER = b.kdmember
                                   AND TRUNC (a.fkt_tgl) = TRUNC (b.tgltrans)
                                   AND a.fkt_nofaktur = b.nofaktur
                    ORDER BY tgl_struk, no_seri_fp) c
             WHERE FKT_KODEMEMBER IS NOT NULL AND FKT_NOFAKTUR IS NOT NULL
          GROUP BY tgl_struk,
                   customer,
                   station,
                   kasir,
                   struk_no,
                   no_seri_fp,
                   tgl_fp) x,
         tbmaster_perusahaan,
         TBTR_FAKTUR_HDR,
         tbtr_obi_h
   WHERE     no_seri_fp = nomor_faktur(+)
         AND TRUNC (transactiondate) = TRUNC (obi_tglstruk(+))
         AND transactionno = obi_nostruk(+)
         AND cashierstation = obi_kdstation(+)
         AND kodemember = obi_kdmember(+)
         AND cashierid = obi_cashierid(+)
ORDER BY tgl_struk, no_seri_fp");
        $filename = 'igr-fo-cetak-fpstd';

        $perusahaan = DB::connection(Session::get('connection'))->table('tbmaster_perusahaan')
            ->first();

        $date = Carbon::now();
        $dompdf = new PDF();

        $pdf = PDF::loadview('FRONTOFFICE.LAPORANPERCETAKANFAKTURPAJAKSTANDAR.' . $filename . '-pdf', compact(['perusahaan', 'data', 'tgl1', 'tgl2']));

        error_reporting(E_ALL ^ E_DEPRECATED);

        $pdf->output();
        $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);

        $canvas = $dompdf->get_canvas();
        $canvas->page_text(507, 77.75, "{PAGE_NUM} dari {PAGE_COUNT}", null, 7, array(0, 0, 0));

        $dompdf = $pdf;

        return $dompdf->stream($filename . ' - ' . $date . '.pdf');
    }

    public function cetakMMNonPKP(Request $request)
    {
        $periode = $request->tgl;
        $w = 545;
        $h = 50.75;

        $data = DB::connection(Session::get('connection'))->select(" select prs_namaperusahaan,
         prs_namacabang, customer,
         nomor_faktur,
         tgl_faktur,
          dpp,
         ppn from (
select  kodemember || ' - ' || nama customer,
         nomor_faktur,
         tgl_faktur,
         sum(total_dpp) dpp,
         sum(total_ppn) ppn
from tbtr_faktur_nonpkp_hdr where tgl_faktur= last_day( to_date('" . $periode . "','mm/yyyy'))
group by kodemember, nama,
         nomor_faktur,
         tgl_faktur), tbmaster_perusahaan
order by customer");
        $filename = 'igr-fo-cetak-fpstd-nonpkp';

        $perusahaan = DB::connection(Session::get('connection'))->table('tbmaster_perusahaan')
            ->first();

//        $date = Carbon::now();
//        $dompdf = new PDF();
//
//        $pdf = PDF::loadview('FRONTOFFICE.LAPORANPERCETAKANFAKTURPAJAKSTANDAR.' . $filename . '-pdf', compact(['perusahaan', 'data', 'periode']));
//
//        error_reporting(E_ALL ^ E_DEPRECATED);
//
//        $pdf->output();
//        $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);
//
//        $canvas = $dompdf->get_canvas();
//        $canvas->page_text(507, 77.75, "{PAGE_NUM} dari {PAGE_COUNT}", null, 7, array(0, 0, 0));
//
//        $dompdf = $pdf;
//
//        return $dompdf->stream($filename . ' - ' . $date . '.pdf');
        return view('FRONTOFFICE.LAPORANPERCETAKANFAKTURPAJAKSTANDAR.' . $filename.'-pdf', compact(['perusahaan', 'data', 'periode']));

    }

    public function cetakTMINonPKP(Request $request)
    {
        $tgl1 = $request->tgl1;
        $tgl2 = $request->tgl2;
        $w = 545;
        $h = 50.75;

        $data = DB::connection(Session::get('connection'))->select("SELECT prs_namaperusahaan,
         prs_namacabang,
         transactiondate tgl_struk,
         kodemember || ' ' || perusahaan customer,
         cashierstation station,
         cashierid kasir,
         transactionno struk_no,
         nomor_faktur no_seri_fp,
         tgl_faktur tgl_fp,
         total_dpp dpp,
         total_ppn ppn
    FROM tbtr_faktur_hdr, tbmaster_perusahaan
   WHERE     TRUNC (transactiondate) BETWEEN to_date('" . $tgl1 . "','dd/mm/yyyy') AND to_date('" . $tgl2 . "','dd/mm/yyyy')
         AND EXISTS
                (SELECT 1
                   FROM tbmaster_customer
                  WHERE     cus_kodeigr = '" . Session::get('kdigr') . "'
                        AND cus_jenismember = 'T'
                        AND cus_kodemember = kodemember
                        AND NVL (cus_flagpkp, 'N') <> 'Y')
         AND EXISTS
                (SELECT 1
                   FROM tbtr_obi_h
                  WHERE obi_nopb LIKE '%TMI%' AND obi_kdmember = kodemember)
ORDER BY transactiondate, nomor_faktur");
        $filename = 'igr-fo-cetak-fpstd-tminonpkp';

        $perusahaan = DB::connection(Session::get('connection'))->table('tbmaster_perusahaan')
            ->first();

        $date = Carbon::now();
        $dompdf = new PDF();

        $pdf = PDF::loadview('FRONTOFFICE.LAPORANPERCETAKANFAKTURPAJAKSTANDAR.' . $filename . '-pdf', compact(['perusahaan', 'data', 'tgl1', 'tgl2']));

        error_reporting(E_ALL ^ E_DEPRECATED);

        $pdf->output();
        $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);

        $canvas = $dompdf->get_canvas();
        $canvas->page_text(507, 77.75, "{PAGE_NUM} dari {PAGE_COUNT}", null, 7, array(0, 0, 0));

        $dompdf = $pdf;

        return $dompdf->stream($filename . ' - ' . $date . '.pdf');
    }

    public function cetakOMINonPKP(Request $request)
    {
        $tgl1 = $request->tgl1;
        $tgl2 = $request->tgl2;
        $w = 545;
        $h = 50.75;

        $data = DB::connection(Session::get('connection'))->select("SELECT prs_namaperusahaan,
         prs_namacabang,
         trjd_transactiondate tgl_struk,
         FKT_kodemember || ' - ' || nama customer,
         fkt_station station,
         fkt_kasir kasir,
         fkt_notransaksi struk_no,
         nofak no_seri_fp,
         FKT_TGL tgl_fp,
         dpp,
         ppn
    FROM (  SELECT NOFAK,
                   TGLFAK,
                   NPWP,
                   NAMA,
                   ALAMAT,
                   TRUNC (SUM (DPP + DF + TTL_REFUND)) DPP,
                   TRUNC (SUM (DPP + DF + TTL_REFUND) * 0.1) PPN,
                   PPNBM,
                   KET,
                   FG_UM,
                   DPP_UM,
                   PPN_UM,
                   PPNBM_UM,
                   FKT_KASIR,
                   FKT_STATION,
                   FKT_NOTRANSAKSI,
                   FKT_KODEMEMBER,
                   FKT_NOFAKTUR,
                   FKT_TGL,
                   TRJD_CREATE_BY,
                   trjd_transactiondate
              FROM (SELECT A.*, NVL (B.NOMINAL, 0) TTL_REFUND
                      FROM (  SELECT REPLACE (FKT_NOSERI, 'Y', '') NOFAK,
                                     FKT_TGLFAKTUR TGLFAK,
                                     NVL (CUS_NPWP, '00.000.000.0-000.000') NPWP,
                                     NVL (CUS_NAMAMEMBER, 0) NAMA,
                                     CASE
                                        WHEN PWP_ALAMAT IS NOT NULL
                                        THEN
                                              NVL (PWP_ALAMAT, ' ')
                                           || ' '
                                           || NVL (PWP_KELURAHAN, ' ')
                                           || ' '
                                           || NVL (PWP_KOTA, ' ')
                                           || ' '
                                           || NVL (PWP_KODEPOS, ' ')
                                        ELSE
                                              NVL (CUS_ALAMATMEMBER1, ' ')
                                           || ' '
                                           || NVL (CUS_ALAMATMEMBER4, ' ')
                                           || ' '
                                           || NVL (CUS_ALAMATMEMBER2, ' ')
                                           || ' '
                                           || NVL (CUS_ALAMATMEMBER3, ' ')
                                     END
                                        ALAMAT,
                                     CASE
                                        WHEN    TRJD_CREATE_BY LIKE 'OM%'
                                             OR TRJD_CREATE_BY = 'BKL'
                                             OR TRJD_CREATE_BY LIKE 'ID%'
                                        THEN
                                           CASE
                                              WHEN TRJD_FLAGTAX1 = 'Y'
                                              THEN
                                                 FLOOR (
                                                    SUM (NVL (TRJD_NOMINALAMT, 0)))
                                              ELSE
                                                 0
                                           END
                                        ELSE
                                           FLOOR (
                                              SUM (NVL (TRJD_NOMINALAMT / 1.1, 0)))
                                     END
                                        DPP,
                                     CASE
                                        WHEN    TRJD_CREATE_BY LIKE 'OM%'
                                             OR TRJD_CREATE_BY = 'BKL'
                                             OR TRJD_CREATE_BY LIKE 'ID%'
                                        THEN
                                           FLOOR (
                                                SUM (
                                                     NVL (TRJD_NOMINALAMT, 0)
                                                   + NVL (TRJD_ADMFEE, 0))
                                              * 0.1)
                                        ELSE
                                           FLOOR (
                                                SUM (
                                                     NVL (TRJD_NOMINALAMT / 1.1, 0)
                                                   + NVL (TRJD_ADMFEE, 0))
                                              * 0.1)
                                     END
                                        PPN,
                                     CASE
                                        WHEN TRJD_FLAGTAX1 = 'Y'
                                        THEN
                                           TRUNC (SUM (TRJD_ADMFEE))
                                        ELSE
                                           TRUNC (SUM (TRJD_ADMFEE))
                                     END
                                        DF,
                                     0 PPNBM,
                                     NULL KET,
                                     0 FG_UM,
                                     0 DPP_UM,
                                     0 PPN_UM,
                                     0 PPNBM_UM,
                                     FKT_KASIR,
                                     FKT_STATION,
                                     FKT_NOTRANSAKSI,
                                     FKT_KODEMEMBER,
                                     FKT_NOFAKTUR,
                                     FKT_TGL,
                                     TRJD_CREATE_BY,
                                     TRUNC (trjd_transactiondate)
                                        trjd_transactiondate
                                FROM TBMASTER_FAKTUR,
                                     TBTR_JUALDETAIL,
                                     TBMASTER_CUSTOMER,
                                     TBMASTER_TOKOIGR,
                                     TBMASTER_NPWP
                               WHERE     (   FKT_NOFAKTUR = TRJD_NOINVOICE1
                                          OR FKT_NOFAKTUR = TRJD_NOINVOICE2)
                                     AND TRJD_CUS_KODEMEMBER = CUS_KODEMEMBER
                                     AND TRJD_CUS_KODEMEMBER = CUS_KODEMEMBER
                                     AND FKT_KODEMEMBER = TRJD_CUS_KODEMEMBER
                                     AND TRJD_CUS_KODEMEMBER = PWP_KODEMEMBER(+)
                                     AND TRJD_CUS_KODEMEMBER = TKO_KODECUSTOMER(+)
                                     AND (   NVL (TRJD_FLAGTAX1, 'N') = 'Y'
                                          OR TRJD_ADMFEE > 0)
                                     AND TRJD_TRANSACTIONTYPE = 'S'
                                     AND (   NVL (TKO_KODESBU, 'N') = 'I'
                                          OR TRJD_CREATE_BY = 'BKL'
                                          OR NVL (TKO_KODESBU, 'N') = 'O')
AND NVL(CUS_flagPKP,'N')  <> 'Y'
                                     AND NOT EXISTS
                                                (SELECT *
                                                   FROM TBTR_OBI_H
                                                  WHERE     OBI_NOSTRUK IS NOT NULL
                                                        AND OBI_NOSTRUK =
                                                               TRJD_TRANSACTIONNO
                                                        AND OBI_KDSTATION =
                                                               TRJD_CASHIERSTATION
                                                        AND OBI_KDMEMBER =
                                                               TRJD_CUS_KODEMEMBER
                                                        AND TRUNC (OBI_TGLSTRUK) =
                                                               TRUNC (
                                                                  TRJD_TRANSACTIONDATE)
                                                        AND TRUNC (OBI_TGLSTRUK) BETWEEN to_date('" . $tgl1 . "','dd/mm/yyyy')
                                                                      AND to_date('" . $tgl2 . "','dd/mm/yyyy'))
                                     AND TRUNC (TRJD_TRANSACTIONDATE) BETWEEN to_date('" . $tgl1 . "','dd/mm/yyyy')
                                                                      AND to_date('" . $tgl2 . "','dd/mm/yyyy')
                            GROUP BY FKT_NOSERI,
                                     FKT_TGLFAKTUR,
                                     CUS_NPWP,
                                     CUS_NAMAMEMBER,
                                     PWP_ALAMAT,
                                     CUS_ALAMATMEMBER1,
                                     PWP_KELURAHAN,
                                     CUS_ALAMATMEMBER2,
                                     PWP_KOTA,
                                     CUS_ALAMATMEMBER3,
                                     PWP_KODEPOS,
                                     CUS_ALAMATMEMBER4,
                                     FKT_KASIR,
                                     FKT_STATION,
                                     FKT_NOTRANSAKSI,
                                     FKT_KODEMEMBER,
                                     FKT_NOFAKTUR,
                                     FKT_TGL,
                                     TRJD_CREATE_BY,
                                     CUS_FLAGPKP,
                                     CUS_NOKTP,
                                     TRJD_FLAGTAX1,
                                     TRUNC (trjd_transactiondate)) A
                           FULL JOIN
                           (  SELECT DISTINCT
                                     CUS_KODEMEMBER KDMEMBER,
                                     TRJD_NOINVOICE1 NOFAKTUR,
                                       CASE
                                          WHEN JH_TRANSACTIONTYPE = 'S' THEN 1
                                          ELSE -1
                                       END
                                     * SUM (
                                          CASE
                                             WHEN    JH_CASHIERID LIKE 'OM%'
                                                  OR JH_CASHIERID = 'BKL'
                                                  OR JH_CASHIERID LIKE 'ID%'
                                             THEN
                                                TRJD_NOMINALAMT
                                             ELSE
                                                FLOOR (TRJD_NOMINALAMT / 1.1)
                                          END)
                                        NOMINAL,
                                     JH_REFERENCEDATE TGLTRANS,
                                     JH_REFERENCECASHIERID REF_CASHIERID,
                                     JH_REFERENCEDATE REF_TGLTRANS,
                                     JH_REFERENCECASHIERSTATION REF_CASHIER_STATION
                                FROM TBTR_JUALHEADER,
                                     TBMASTER_CUSTOMER,
                                     TBTR_JUALDETAIL
                               WHERE     JH_TRANSACTIONTYPE = 'R'
                                     AND (   NVL (TRJD_FLAGTAX1, 'N') = 'Y'
                                          OR TRJD_ADMFEE > 0)
                                     AND (   TRJD_NOINVOICE1 <> '0'
                                          OR TRJD_NOINVOICE2 <> '0')
                                     AND TRJD_NOMINALAMT > 0
                                     AND TRUNC (JH_REFERENCEDATE) BETWEEN to_date('" . $tgl1 . "','dd/mm/yyyy')
                                                                      AND to_date('" . $tgl2 . "','dd/mm/yyyy')
                                     AND JH_CUS_KODEMEMBER = CUS_KODEMEMBER
                                     AND JH_CUS_KODEMEMBER = TRJD_CUS_KODEMEMBER
                                     AND JH_TRANSACTIONNO = TRJD_TRANSACTIONNO
                                     AND TRUNC (JH_TRANSACTIONDATE) = TRUNC (TRJD_TRANSACTIONDATE)
                                     AND JH_CASHIERSTATION = TRJD_CASHIERSTATION
                                     AND JH_CASHIERID = TRJD_CREATE_BY
AND NVL(CUS_flagPKP,'N')  <> 'Y'
                            GROUP BY CUS_KODEMEMBER,
                                     TRJD_NOINVOICE1,
                                     JH_TRANSACTIONTYPE,
                                     JH_REFERENCEDATE,
                                     JH_REFERENCECASHIERID,
                                     TRUNC (JH_REFERENCEDATE),
                                     JH_REFERENCECASHIERSTATION) B
                              ON     A.FKT_KODEMEMBER = B.KDMEMBER
                                 AND TRUNC (A.FKT_TGL) = TRUNC (B.TGLTRANS)
                                 AND A.FKT_NOFAKTUR = B.NOFAKTUR) C
             WHERE FKT_KODEMEMBER IS NOT NULL AND FKT_NOFAKTUR IS NOT NULL
          GROUP BY NOFAK,
                   TGLFAK,
                   NPWP,
                   NAMA,
                   ALAMAT,
                   PPNBM,
                   KET,
                   FG_UM,
                   DPP_UM,
                   PPN_UM,
                   PPNBM_UM,
                   FKT_KASIR,
                   FKT_STATION,
                   FKT_NOTRANSAKSI,
                   FKT_KODEMEMBER,
                   FKT_NOFAKTUR,
                   FKT_TGL,
                   TRJD_CREATE_BY,
                   trjd_transactiondate) d,
         tbmaster_perusahaan
   WHERE prs_kodeigr = '" . Session::get('kdigr') . "'
ORDER BY trjd_transactiondate, nofak");
        $filename = 'igr-fo-cetak-fpstd-ominonpkp';

        $perusahaan = DB::connection(Session::get('connection'))->table('tbmaster_perusahaan')
            ->first();

        $date = Carbon::now();
        $dompdf = new PDF();

        $pdf = PDF::loadview('FRONTOFFICE.LAPORANPERCETAKANFAKTURPAJAKSTANDAR.' . $filename . '-pdf', compact(['perusahaan', 'data', 'tgl1', 'tgl2']));

        error_reporting(E_ALL ^ E_DEPRECATED);

        $pdf->output();
        $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);

        $canvas = $dompdf->get_canvas();
        $canvas->page_text(507, 77.75, "{PAGE_NUM} dari {PAGE_COUNT}", null, 7, array(0, 0, 0));

        $dompdf = $pdf;

        return $dompdf->stream($filename . ' - ' . $date . '.pdf');
    }

    public function cetakFreepassKlikIgr(Request $request)
    {
        $tgl1 = $request->tgl1;
        $tgl2 = $request->tgl2;
        $w = 545;
        $h = 50.75;

        $data = DB::connection(Session::get('connection'))->select("SELECT prs_namaperusahaan,
         prs_namacabang,
         TRUNC (transactiondate) tgl_struk,
         perusahaan customer,
         npwp,
         cashierstation station,
         cashierid kasir,
         transactionno struk_no,
         nomor_faktur no_seri_fp,
         tgl_faktur tgl_fp,
         NVL (
              total_dpp
            + +CASE
                  WHEN NVL (OBI_ATTRIBUTE2, 'N') IN ('KlikIGR', 'Corp')
                  THEN
                     ROUND (OBI_EKSPEDISI / 1.1)
                  ELSE
                     0
               END,
            0)
            dpp,
         NVL (
              total_ppn
            + +CASE
                  WHEN NVL (OBI_ATTRIBUTE2, 'N') IN ('KlikIGR', 'Corp')
                  THEN
                     (OBI_EKSPEDISI - ROUND (OBI_EKSPEDISI / 1.1))
                  ELSE
                     0
               END,
            0)
            ppn
    FROM tbmaster_perusahaan, TBTR_FAKTUR_HDR fkt, tbtr_obi_h obi
   WHERE     kodemember = '280676'
         AND TRUNC (transactiondate) = TRUNC (obi_tglstruk(+))
         AND transactionno = obi_nostruk(+)
         AND cashierstation = obi_kdstation(+)
         AND kodemember = obi_kdmember(+)
         AND cashierid = obi_cashierid(+)
         AND TRUNC (transactiondate) BETWEEN to_date('" . $tgl1 . "','dd/mm/yyyy') AND to_date('" . $tgl2 . "','dd/mm/yyyy')
ORDER BY tgl_struk, no_seri_fp");
        $filename = 'igr-fo-cetak-fpstd-freepassklik';

        $perusahaan = DB::connection(Session::get('connection'))->table('tbmaster_perusahaan')
            ->first();

        $date = Carbon::now();
        $dompdf = new PDF();

        $pdf = PDF::loadview('FRONTOFFICE.LAPORANPERCETAKANFAKTURPAJAKSTANDAR.' . $filename . '-pdf', compact(['perusahaan', 'data', 'tgl1', 'tgl2']));

        error_reporting(E_ALL ^ E_DEPRECATED);

        $pdf->output();
        $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);

        $canvas = $dompdf->get_canvas();
        $canvas->page_text(507, 77.75, "{PAGE_NUM} dari {PAGE_COUNT}", null, 7, array(0, 0, 0));

        $dompdf = $pdf;

        return $dompdf->stream($filename . ' - ' . $date . '.pdf');
    }
}
