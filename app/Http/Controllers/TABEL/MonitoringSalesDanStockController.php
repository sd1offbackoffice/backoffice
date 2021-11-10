<?php

namespace App\Http\Controllers\TABEL;

use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;
use PDF;
use Yajra\DataTables\DataTables;

class MonitoringSalesDanStockController extends Controller
{
    public function index()
    {
        return view('TABEL.monitoring-sales-dan-stock');
    }

    public function getLovMonitoring()
    {
        $data = DB::connection($_SESSION['connection'])->table('tbtr_monitoringplu')
            ->selectRaw("mpl_kodemonitoring kode, mpl_namamonitoring nama")
            ->orderBy("mpl_kodemonitoring")
            ->distinct()
            ->get();
        return DataTables::of($data)->make(true);
    }

    public function getLovPLU(Request $request)
    {
        $kodeMonitoring = $request->kode;
        $namaMonitoring = $request->nama;

        $data = DB::connection($_SESSION['connection'])->table("tbmaster_prodmast")
            ->select("prd_prdcd", "prd_deskripsipanjang")
            ->whereRaw("substr(prd_prdcd,-1,1) = 0")
            ->whereRaw("prd_prdcd in ( select mpl_prdcd from tbtr_monitoringplu where mpl_kodemonitoring = '" . $kodeMonitoring . "' and mpl_namamonitoring = '" . $namaMonitoring . "' )")
            ->orderBy('prd_prdcd')
            ->get();

        return DataTables::of($data)->make(true);
    }

    public function getData(Request $request)
    {
        $bulan = $request->bulan;
        $kodemonitoring = $request->kodemonitoring;
        $periode1 = $request->periode1;
        $periode2 = $request->periode2;
        $plu1 = $request->plu1;
        $plu2 = $request->plu2;
        $rankby = $request->rankby;
        $sqlBulan = "";
        $orderBy = "";

        if ($rankby == '1') {
            $orderBy = ' order by avgsales desc';
        } else {
            $orderBy = ' order by mpl_prdcd';
        }
        $where = " and mpl_kodemonitoring = '" . $kodemonitoring . "'";
        switch ($bulan) {
            case '1' :
                $sqlBulan = 'SELECT DISTINCT mpl_kodemonitoring, mpl_namamonitoring, mpl_prdcd, nvl((sls_qty_11 + sls_qty_12 + sls_qty_01)/3,0) avgqty, nvl((sls_rph_11 + sls_rph_12 + sls_rph_01)/3,0) avgsales	FROM TBTR_MONITORINGPLU, TBTR_SALESBULANAN WHERE mpl_prdcd = sls_prdcd(+) ' . $where . $orderBy;
                break;
            case '2' :
                $sqlBulan = 'SELECT DISTINCT mpl_kodemonitoring, mpl_namamonitoring, mpl_prdcd, nvl((sls_qty_12 + sls_qty_01 + sls_qty_02)/3,0) avgqty, nvl((sls_rph_12 + sls_rph_01 + sls_rph_02)/3,0) avgsales	FROM TBTR_MONITORINGPLU, TBTR_SALESBULANAN WHERE mpl_prdcd = sls_prdcd(+) ' . $where . $orderBy;
                break;
            case '3' :
                $sqlBulan = 'SELECT DISTINCT mpl_kodemonitoring, mpl_namamonitoring, mpl_prdcd, nvl((sls_qty_01 + sls_qty_02 + sls_qty_03)/3,0) avgqty, nvl((sls_rph_01 + sls_rph_02 + sls_rph_03)/3,0) avgsales	FROM TBTR_MONITORINGPLU, TBTR_SALESBULANAN WHERE mpl_prdcd = sls_prdcd(+) ' . $where . $orderBy;
                break;
            case '4' :
                $sqlBulan = 'SELECT DISTINCT mpl_kodemonitoring, mpl_namamonitoring, mpl_prdcd, nvl((sls_qty_02 + sls_qty_03 + sls_qty_04)/3,0) avgqty, nvl((sls_rph_02 + sls_rph_03 + sls_rph_04)/3,0) avgsales	FROM TBTR_MONITORINGPLU, TBTR_SALESBULANAN WHERE mpl_prdcd = sls_prdcd(+) ' . $where . $orderBy;
                break;
            case '5' :
                $sqlBulan = 'SELECT DISTINCT mpl_kodemonitoring, mpl_namamonitoring, mpl_prdcd, nvl((sls_qty_03 + sls_qty_04 + sls_qty_05)/3,0) avgqty, nvl((sls_rph_03 + sls_rph_04 + sls_rph_05)/3,0) avgsales	FROM TBTR_MONITORINGPLU, TBTR_SALESBULANAN WHERE mpl_prdcd = sls_prdcd(+) ' . $where . $orderBy;
                break;
            case '6' :
                $sqlBulan = 'SELECT DISTINCT mpl_kodemonitoring, mpl_namamonitoring, mpl_prdcd, nvl((sls_qty_04 + sls_qty_05 + sls_qty_06)/3,0) avgqty, nvl((sls_rph_04 + sls_rph_05 + sls_rph_06)/3,0) avgsales	FROM TBTR_MONITORINGPLU, TBTR_SALESBULANAN WHERE mpl_prdcd = sls_prdcd(+) ' . $where . $orderBy;
                break;
            case '7' :
                $sqlBulan = 'SELECT DISTINCT mpl_kodemonitoring, mpl_namamonitoring, mpl_prdcd, nvl((sls_qty_05 + sls_qty_06 + sls_qty_07)/3,0) avgqty, nvl((sls_rph_05 + sls_rph_06 + sls_rph_07)/3,0) avgsales	FROM TBTR_MONITORINGPLU, TBTR_SALESBULANAN WHERE mpl_prdcd = sls_prdcd(+) ' . $where . $orderBy;
                break;
            case '8' :
                $sqlBulan = 'SELECT DISTINCT mpl_kodemonitoring, mpl_namamonitoring, mpl_prdcd, nvl((sls_qty_06 + sls_qty_07 + sls_qty_08)/3,0) avgqty, nvl((sls_rph_06 + sls_rph_07 + sls_rph_08)/3,0) avgsales	FROM TBTR_MONITORINGPLU, TBTR_SALESBULANAN WHERE mpl_prdcd = sls_prdcd(+) ' . $where . $orderBy;
                break;
            case '9' :
                $sqlBulan = 'SELECT DISTINCT mpl_kodemonitoring, mpl_namamonitoring, mpl_prdcd, nvl((sls_qty_07 + sls_qty_08 + sls_qty_09)/3,0) avgqty, nvl((sls_rph_07 + sls_rph_08 + sls_rph_09)/3,0) avgsales	FROM TBTR_MONITORINGPLU, TBTR_SALESBULANAN WHERE mpl_prdcd = sls_prdcd(+) ' . $where . $orderBy;
                break;
            case '10' :
                $sqlBulan = 'SELECT DISTINCT mpl_kodemonitoring, mpl_namamonitoring, mpl_prdcd, nvl((sls_qty_08 + sls_qty_09 + sls_qty_10)/3,0) avgqty, nvl((sls_rph_08 + sls_rph_09 + sls_rph_10)/3,0) avgsales	FROM TBTR_MONITORINGPLU, TBTR_SALESBULANAN WHERE mpl_prdcd = sls_prdcd(+) ' . $where . $orderBy;
                break;
            case '11' :
                $sqlBulan = 'SELECT DISTINCT mpl_kodemonitoring, mpl_namamonitoring, mpl_prdcd, nvl((sls_qty_09 + sls_qty_10 + sls_qty_11)/3,0) avgqty, nvl((sls_rph_09 + sls_rph_10 + sls_rph_11)/3,0) avgsales	FROM TBTR_MONITORINGPLU, TBTR_SALESBULANAN WHERE mpl_prdcd = sls_prdcd(+) ' . $where . $orderBy;
                break;
            case '12' :
                $sqlBulan = 'SELECT DISTINCT mpl_kodemonitoring, mpl_namamonitoring, mpl_prdcd, nvl((sls_qty_10 + sls_qty_11 + sls_qty_12)/3,0) avgqty, nvl((sls_rph_10 + sls_rph_11 + sls_rph_12)/3,0) avgsales	FROM TBTR_MONITORINGPLU, TBTR_SALESBULANAN WHERE mpl_prdcd = sls_prdcd(+) ' . $where . $orderBy;
                break;
        }

        $data = DB::connection($_SESSION['connection'])->select($sqlBulan);
        $temp = DB::connection($_SESSION['connection'])
            ->table("tbmaster_perusahaan")
            ->selectRaw("to_char(prs_periodeTerakhir, 'D') dow, prs_periodeTerakhir, to_date('13-dec-9999', 'dd-mm-yyyy') tglvv")
            ->first();

        $dow = $temp->dow;
        $lastPer = $temp->prs_periodeterakhir;
        $tglVV = $temp->tglvv;
        for ($k = 0; $k < sizeof($data); $k++) {
            $proses = DB::connection($_SESSION['connection'])->select("
            select prdcd, kemasan, sales_, margin, margin2, saldo, ftpkmt, keter, PB, PO, deskripsi
                    from tbtr_monitoringplu,
                    (	SELECT DISTINCT
                               mpl_prdcd PRDCD, prd_deskripsipendek, prd_deskripsipanjang||' - '|| prd_unit||'/'||prd_frac deskripsi, prd_unit||'/'||prd_frac kemasan, sup_harikunjungan hrkj, sup_jangkawaktukirimbarang jwpb,
                               nvl(st_sales,0) SALES_, NVL(mgrA,0) MARGIN, NVL(mgrB,0) MARGIN2, nvl(st_saldoakhir,0) SALDO, nvl(pkm_pkmt,0) FTPKMT,
                               CASE WHEN sup_harikunjungan IS NULL THEN 'Tidak Ada Kunjungan' END KETER, NVL(qtyC,0) PB, NVL(qtyB,0) PO
                        FROM TBTR_MONITORINGPLU, TBMASTER_PRODMAST, TBMASTER_STOCK, TBMASTER_SUPPLIER, TBMASTER_HARGABELI, TBMASTER_KKPKM, TBTR_SALESBULANAN,
                        (	 SELECT tpod_prdcd, SUM(qtyB) qtyB
                             FROM
                             (  SELECT DISTINCT tpod_prdcd, NVL((tpod_qtyPO),0) qtyB
                                    FROM TBTR_PO_H, TBTR_PO_D, TBTR_MONITORINGPLU
                                    WHERE tpoh_nopo = tpod_nopo
                    AND tpod_prdcd = SUBSTR(mpl_prdcd,1,6)||'0'
                    AND tpod_qtyPB IS NULL AND tpod_recordid IS NULL
                    AND TRUNC(SYSDATE) BETWEEN tpoh_tglPO AND (tpoh_tglPO + tpoh_jwpb)
                             )
                             GROUP BY tpod_prdcd
                        ),
                        (	 SELECT pbd_prdcd, SUM(qtyC) qtyC
                             FROM
                             (	SELECT DISTINCT pbd_prdcd, NVL((pbd_qtyPB),0) qtyC
                                    FROM TBTR_PB_H, TBTR_PB_D, TBTR_MONITORINGPLU
                                    WHERE pbh_nopb = pbd_nopb
                    AND pbd_prdcd = SUBSTR(mpl_prdcd,1,6)||'0'
                    AND pbd_recordid IS NULL AND pbd_qtybpb IS NULL
                    AND TRUNC(SYSDATE) BETWEEN pbh_tglPB AND (pbh_tglPB+2)
                             )
                             GROUP BY pbd_prdcd
                        ),
                        (	 SELECT sls_prdcd sum_prdcd, SUM(sls_marginNOMI) mgrA, SUM(sls_netNOMI) netA,
                             CASE WHEN SUM(sls_netNOMI) <> 0 THEN SUM(sls_marginNOMI)*100/SUM(sls_netNOMI) ELSE
                             CASE WHEN SUM(sls_marginNOMI) <> 0 THEN 100 ELSE 0 END END mgrB
                             FROM TBTR_SUMSALES
                             WHERE TRUNC(sls_periode) BETWEEN to_date('" . $periode1 . "','dd/mm/yyyy') AND to_date('" . $periode2 . "','dd/mm/yyyy')
                             GROUP BY sls_kodedivisi, sls_kodedepartement, sls_kodekategoribrg, sls_prdcd
                        )
                        WHERE mpl_kodeigr = '" . $_SESSION['kdigr'] . "'
                    AND mpl_prdcd = prd_prdcd (+)
                    AND mpl_prdcd = st_prdcd (+)
                    AND st_lokasi = '01'
                    AND mpl_prdcd = sls_prdcd (+)
                    AND sls_kodeSupplier = sup_kodesupplier(+)
                    AND mpl_prdcd = hgb_prdcd (+)
                    AND mpl_prdcd = sum_prdcd (+)
                    AND mpl_prdcd = pkm_prdcd (+)
                    AND mpl_prdcd = pbd_prdcd (+)
                    AND mpl_prdcd = tpod_prdcd (+)
                    AND hgb_tipe = '2'
                    AND mpl_kodemonitoring = '" . $kodemonitoring . "'
                    AND mpl_prdcd BETWEEN '0000000' AND 'zzzzzzz'
                    )
                    where mpl_prdcd = prdcd(+)
                    and mpl_prdcd = '" . $data[$k]->mpl_prdcd . "'
            ");


            $ltimeA = '';
            $yT = '';
            $yT = '';
            $tglY = '';
            $tglL = '';
            $keterangan = '';
            $tglPB = '';

            for ($j = 0; $j < sizeof($proses); $j++) {
                $data[$k]->sales = $proses[$j]->sales_;
                $data[$k]->margin = $proses[$j]->margin;
                $data[$k]->margin2 = $proses[$j]->margin2;
                $data[$k]->saldo = $proses[$j]->saldo;
                $data[$k]->deskripsi = $proses[$j]->deskripsi;

                $data[$k]->po = $proses[$j]->po;
                $data[$k]->pb = $proses[$j]->pb;
            }

            $pkm = DB::connection($_SESSION['connection'])
                ->select("SELECT mpl_prdcd, pkm_pkmt ftpkmt
                            FROM TBTR_MONITORINGPLU,TBMASTER_PRODMAST, TBMASTER_KKPKM
                            WHERE mpl_prdcd = prd_prdcd (+)
                            AND mpl_kodemonitoring = '" . $kodemonitoring . "'
                            AND prd_prdcd = pkm_prdcd(+)
                            and mpl_prdcd ='" . $data[$k]->mpl_prdcd . "'");
            for ($j = 0; $j < sizeof($pkm); $j++) {
                $data[$k]->ftpkmt = Self::nvl($pkm[$j]->ftpkmt, 0);
            }

            $supp = DB::connection($_SESSION['connection'])
                ->select("SELECT DISTINCT mpl_prdcd PRDCD, sup_harikunjungan hrkj, sup_jangkawaktukirimbarang jwpb
                    FROM TBTR_MONITORINGPLU, TBTR_SALESBULANAN, TBMASTER_SUPPLIER
                    WHERE mpl_prdcd = sls_prdcd
                    AND mpl_kodemonitoring = '" . $kodemonitoring . "'
                    AND sls_kodesupplier = sup_kodesupplier
                    and mpl_prdcd = '" . $data[$k]->mpl_prdcd . "'");
            for ($j = 0; $j < sizeof($supp); $j++) {


                if ($supp[$j]->jwpb == 0) {
                    $ltimeA = 4;
                } else if ($supp[$j]->jwpb > 5) {
                    $ltimeA = 6;
                } else {
                    $ltimeA = $supp[$j]->jwpb + 1;
                }

                if ($ltimeA > 7) {
                    $ltimeA = $ltimeA - 6;
                }

                for ($i = 2; $i <= 7; $i++) {
                    if (substr($supp[$j]->hrkj, $i, 1) == 'Y') {
                        $yT = abs($dow - $i);
                        if ($i < $dow) {
                            $tglL = $lastPer + 7 - $yT;

                            $tempHL = DB::connection($_SESSION['connection'])
                                ->table("tbmaster_harilibur")
                                ->where("lib_tgllibur", $tglL)
                                ->count();

                            if ($tempHL <> 0) {
                                $tglY = $tglL - $ltimeA - 1;
                            } else {
                                $tglY = $tglL - $ltimeA;
                            }
                        } else {
                            $tglL = $lastPer + $yT;
                            $tglY = $tglL - $ltimeA;

                            if ($lastPer > $tglY) {
                                $tglL = $lastPer + 7 + $yT;
                                $tglY = $tglL - $ltimeA;
                            }

                            $tempHL = DB::connection($_SESSION['connection'])
                                ->table("tbmaster_harilibur")
                                ->where("lib_tgllibur", $tglL)
                                ->count();

                            if ($tempHL <> 0) {
                                $tglY = $tglY - 1;
                            }

                        }

                        $tglpbV = $tglY;

                        if ($tglVV > $tglpbV) {
                            $tglVV = $tglpbV;
                        }
                    }

                }

                $tglPB = Self::nvl($tglVV, 'Tidak Ada');
                if (!isset($supp[$j]->hrkj)) {
                    $keterangan = 'Tidak Ada Kunjungan';
                }
            }

            $data[$k]->tglpb = $tglPB;
            $data[$k]->keterangan = $keterangan;
        }
        return DataTables::of($data)->make(true);
    }

    public function print(Request $request)
    {
        $bulan = $request->bulan;
        $kodemonitoring = $request->kodemonitoring;
        $namamonitoring = $request->namamonitoring;
        $periode1 = $request->periode1;
        $periode2 = $request->periode2;
        $plu1 = $request->plu1;
        $plu2 = $request->plu2;
        $rankby = $request->rankby;
        $margin = $request->margin;

        $data = '';
        $filename = '';
        $namabulan = '';
        $periode = '';

        switch ($bulan) {
            case 1 :
                $namabulan = 'JANUARI';
                break;
            case 2 :
                $namabulan = 'FEBRUARI';
                break;
            case 3 :
                $namabulan = 'MARET';
                break;
            case 4 :
                $namabulan = 'APRIL';
                break;
            case 5 :
                $namabulan = 'MEI';
                break;
            case 6 :
                $namabulan = 'JUNI';
                break;
            case 7 :
                $namabulan = 'JULI';
                break;
            case 8 :
                $namabulan = 'AGUSTUS';
                break;
            case 9 :
                $namabulan = 'SEPTEMBER';
                break;
            case 10:
                $namabulan = 'OKTOBER';
                break;
            case 11:
                $namabulan = 'NOVEMBER';
                break;
            case 12:
                $namabulan = 'DESEMBER';
                break;
        }
        if ($periode1 <> $periode1) {
            $periode = $periode1 . ' s/d ' . $periode2;
        } else {
            $periode = $periode1;
        }

        $perusahaan = DB::connection($_SESSION['connection'])
            ->table("tbmaster_perusahaan")
            ->first();

        if ($rankby == '1') {
            if ($margin == 'Y') {
                $filename = 'monitoring-sales-dan-stock-avg-margin-pdf';
                $data = DB::connection($_SESSION['connection'])
                    ->select("
                                SELECT DISTINCT
                                       prs_namaperusahaan, prs_namacabang, prs_namawilayah,
                                       mpl_kodemonitoring kode,
                                       mpl_prdcd prdcd, prd_deskripsipendek, prd_unit||'/'||prd_frac kemasan,
                                       nvl(CASE WHEN ".$bulan." = 1 THEN (sls_rph_11 + sls_rph_12 + sls_rph_01)/3
                                            WHEN ".$bulan." = 2 THEN (sls_rph_12 + sls_rph_01 + sls_rph_02)/3
                                            WHEN ".$bulan." = 3 THEN (sls_rph_01 + sls_rph_02 + sls_rph_03)/3
                                            WHEN ".$bulan." = 4 THEN (sls_rph_02 + sls_rph_03 + sls_rph_04)/3
                                            WHEN ".$bulan." = 5 THEN (sls_rph_03 + sls_rph_04 + sls_rph_05)/3
                                            WHEN ".$bulan." = 6 THEN (sls_rph_04 + sls_rph_05 + sls_rph_06)/3
                                            WHEN ".$bulan." = 7 THEN (sls_rph_05 + sls_rph_06 + sls_rph_07)/3
                                            WHEN ".$bulan." = 8 THEN (sls_rph_06 + sls_rph_07 + sls_rph_08)/3
                                            WHEN ".$bulan." = 9 THEN (sls_rph_07 + sls_rph_08 + sls_rph_09)/3
                                            WHEN ".$bulan." =10 THEN (sls_rph_08 + sls_rph_09 + sls_rph_10)/3
                                            WHEN ".$bulan." =11 THEN (sls_rph_09 + sls_rph_10 + sls_rph_11)/3
                                            WHEN ".$bulan." =12 THEN (sls_rph_10 + sls_rph_11 + sls_rph_12)/3
                                       END,0) avgSales,
                                       nvl(CASE WHEN ".$bulan." = 1 THEN (sls_qty_11 + sls_qty_12 + sls_qty_01)/3
                                            WHEN ".$bulan." = 2 THEN (sls_qty_12 + sls_qty_01 + sls_qty_02)/3
                                            WHEN ".$bulan." = 3 THEN (sls_qty_01 + sls_qty_02 + sls_qty_03)/3
                                            WHEN ".$bulan." = 4 THEN (sls_qty_02 + sls_qty_03 + sls_qty_04)/3
                                            WHEN ".$bulan." = 5 THEN (sls_qty_03 + sls_qty_04 + sls_qty_05)/3
                                            WHEN ".$bulan." = 6 THEN (sls_qty_04 + sls_qty_05 + sls_qty_06)/3
                                            WHEN ".$bulan." = 7 THEN (sls_qty_05 + sls_qty_06 + sls_qty_07)/3
                                            WHEN ".$bulan." = 8 THEN (sls_qty_06 + sls_qty_07 + sls_qty_08)/3
                                            WHEN ".$bulan." = 9 THEN (sls_qty_07 + sls_qty_08 + sls_qty_09)/3
                                            WHEN ".$bulan." =10 THEN (sls_qty_08 + sls_qty_09 + sls_qty_10)/3
                                            WHEN ".$bulan." =11 THEN (sls_qty_09 + sls_qty_10 + sls_qty_11)/3
                                            WHEN ".$bulan." =12 THEN (sls_qty_10 + sls_qty_11 + sls_qty_12)/3
                                       END,0) avgqty,
                                       NVL(st_sales,0) sales_, NVL(st_saldoakhir,0) saldo, NVL(mgrA,0) margin, NVL(mgrB,0) margin2, NVL(pkm_pkmt,0) ftpkmt,
                                       NVL(qtyB,0) PO, NVL(qtyC,0) PB, sup_harikunjungan hrkj, sup_jangkawaktukirimbarang jwpb
                                FROM TBMASTER_PERUSAHAAN, TBTR_MONITORINGPLU, TBMASTER_PRODMAST, TBTR_SALESBULANAN, TBMASTER_SUPPLIER, TBMASTER_HARGABELI, TBMASTER_KKPKM,
                                (   SELECT st_prdcd, st_sales, st_saldoakhir
                                    FROM TBMASTER_STOCK
                                    WHERE st_lokasi = '01'
                                ),
                                (	 SELECT sls_prdcd sum_prdcd, SUM(sls_marginNOMI) mgrA,
                                     CASE WHEN SUM(sls_netNOMI) <> 0 THEN SUM(sls_marginNOMI)*100/SUM(sls_netNOMI) ELSE
                                     CASE WHEN SUM(sls_marginNOMI) <> 0 THEN 100 ELSE 0 END END mgrB
                                     FROM TBTR_SUMSALES
                                     WHERE TRUNC(sls_periode) BETWEEN to_date('" . $periode1 . "','dd/mm/yyyy') AND to_date('" . $periode2 . "','dd/mm/yyyy')
                                     GROUP BY sls_kodedivisi, sls_kodedepartement, sls_kodekategoribrg, sls_prdcd
                                ),
                                ( 	 SELECT tpod_prdcd, SUM(qtyB) qtyB
                                     FROM
                                     (	 SELECT DISTINCT tpod_prdcd, NVL((tpod_qtyPO),0) qtyB
                                         FROM TBTR_PO_H, TBTR_PO_D, TBTR_MONITORINGPLU
                                         WHERE tpoh_nopo = tpod_nopo
                                           AND tpod_prdcd = SUBSTR(mpl_prdcd,1,6)||'0'
                                           AND tpod_qtyPB IS NULL AND tpod_recordid IS NULL
                                           AND TRUNC(SYSDATE) BETWEEN tpoh_tglPO AND (tpoh_tglPO + tpoh_jwpb)
                                     )
                                     GROUP BY tpod_prdcd
                                ),
                                (	 SELECT pbd_prdcd, SUM(qtyC) qtyC
                                     FROM
                                     (	 SELECT DISTINCT pbd_prdcd, NVL((pbd_qtyPB),0) qtyC
                                         FROM TBTR_PB_H, TBTR_PB_D, TBTR_MONITORINGPLU
                                         WHERE pbh_nopb = pbd_nopb
                                           AND pbd_prdcd = SUBSTR(mpl_prdcd,1,6)||'0'
                                           AND pbd_recordid IS NULL AND pbd_qtybpb IS NULL
                                           AND TRUNC(SYSDATE) BETWEEN pbh_tglPB AND (pbh_tglPB+2)
                                     )
                                     GROUP BY pbd_prdcd
                                )
                                WHERE mpl_kodeigr = prs_kodeigr
                                  AND prs_kodeigr = '" . $_SESSION['kdigr'] . "'
                                  AND mpl_prdcd = prd_prdcd (+)
                                  AND mpl_prdcd = st_prdcd (+)
                                  AND mpl_prdcd = sls_prdcd (+)
                                  AND sls_kodesupplier = sup_kodesupplier (+)
                                  AND mpl_prdcd = hgb_prdcd (+)
                                  AND prd_prdcd = pkm_prdcd (+)
                                  AND mpl_prdcd = pbd_prdcd (+)
                                  AND mpl_prdcd = tpod_prdcd (+)
                                  AND mpl_prdcd = sum_prdcd (+)
                                  AND hgb_tipe = '2'
                                  AND translate(mpl_kodemonitoring,' ','_') = '" . $kodemonitoring . "'
                                  AND length(mpl_namamonitoring) = '".$namamonitoring."'
                                ORDER BY avgsales DESC");
                for ($j = 0; $j < sizeof($data); $j++) {
                    $dow='';
                    $lastPer='';
                    if ($data[$j]->jwpb == 0) {
                        $ltimeA = 4;
                    } else if ($data[$j]->jwpb > 5) {
                        $ltimeA = 6;
                    } else {
                        $ltimeA = $data[$j]->jwpb + 1;
                    }

                    if ($ltimeA > 7) {
                        $ltimeA = $ltimeA - 6;
                    }

                    for ($i = 2; $i <= 7; $i++) {
                        if (substr($data[$j]->hrkj, $i, 1) == 'Y') {
                            $yT = abs($dow - $i);
                            if ($i < $dow) {
                                $tglL = $lastPer + 7 - $yT;

                                $tempHL = DB::connection($_SESSION['connection'])
                                    ->table("tbmaster_harilibur")
                                    ->where("lib_tgllibur", $tglL)
                                    ->count();

                                if ($tempHL <> 0) {
                                    $tglY = $tglL - $ltimeA - 1;
                                } else {
                                    $tglY = $tglL - $ltimeA;
                                }
                            } else {
                                $tglL = $lastPer + $yT;
                                $tglY = $tglL - $ltimeA;

                                if ($lastPer > $tglY) {
                                    $tglL = $lastPer + 7 + $yT;
                                    $tglY = $tglL - $ltimeA;
                                }

                                $tempHL = DB::connection($_SESSION['connection'])
                                    ->table("tbmaster_harilibur")
                                    ->where("lib_tgllibur", $tglL)
                                    ->count();

                                if ($tempHL <> 0) {
                                    $tglY = $tglY - 1;
                                }

                            }

                            $tglpbV = $tglY;

                            if ($tglVV > $tglpbV) {
                                $tglVV = $tglpbV;
                            }
                        }

                    }

                    $tglPB = Self::nvl($tglVV, 'Tidak Ada');
                    if (!isset($supp[$j]->hrkj)) {
                        $keterangan = 'Tidak Ada Kunjungan';
                    }
                    $data[$j]->cp_tglpb=$tglPB;
                }
            } else {
                $filename = 'monitoring-sales-dan-stock-avg-pdf';
                $data = DB::connection($_SESSION['connection'])
                    ->select("SELECT DISTINCT
                       prs_namaperusahaan, prs_namacabang, prs_namawilayah,
                       mpl_kodemonitoring kode,
                       mpl_prdcd prdcd, prd_deskripsipendek, prd_unit||'/'||prd_frac kemasan,
                       NVL(CASE WHEN ".$bulan." = 1 THEN (sls_rph_11 + sls_rph_12 + sls_rph_01)/3
                            WHEN ".$bulan." = 2 THEN (sls_rph_12 + sls_rph_01 + sls_rph_02)/3
                            WHEN ".$bulan." = 3 THEN (sls_rph_01 + sls_rph_02 + sls_rph_03)/3
                            WHEN ".$bulan." = 4 THEN (sls_rph_02 + sls_rph_03 + sls_rph_04)/3
                            WHEN ".$bulan." = 5 THEN (sls_rph_03 + sls_rph_04 + sls_rph_05)/3
                            WHEN ".$bulan." = 6 THEN (sls_rph_04 + sls_rph_05 + sls_rph_06)/3
                            WHEN ".$bulan." = 7 THEN (sls_rph_05 + sls_rph_06 + sls_rph_07)/3
                            WHEN ".$bulan." = 8 THEN (sls_rph_06 + sls_rph_07 + sls_rph_08)/3
                            WHEN ".$bulan." = 9 THEN (sls_rph_07 + sls_rph_08 + sls_rph_09)/3
                            WHEN ".$bulan." =10 THEN (sls_rph_08 + sls_rph_09 + sls_rph_10)/3
                            WHEN ".$bulan." =11 THEN (sls_rph_09 + sls_rph_10 + sls_rph_11)/3
                            WHEN ".$bulan." =12 THEN (sls_rph_10 + sls_rph_11 + sls_rph_12)/3
                       END,0) avgSales,
                       NVL(CASE WHEN ".$bulan." = 1 THEN (sls_qty_11 + sls_qty_12 + sls_qty_01)/3
                            WHEN ".$bulan." = 2 THEN (sls_qty_12 + sls_qty_01 + sls_qty_02)/3
                            WHEN ".$bulan." = 3 THEN (sls_qty_01 + sls_qty_02 + sls_qty_03)/3
                            WHEN ".$bulan." = 4 THEN (sls_qty_02 + sls_qty_03 + sls_qty_04)/3
                            WHEN ".$bulan." = 5 THEN (sls_qty_03 + sls_qty_04 + sls_qty_05)/3
                            WHEN ".$bulan." = 6 THEN (sls_qty_04 + sls_qty_05 + sls_qty_06)/3
                            WHEN ".$bulan." = 7 THEN (sls_qty_05 + sls_qty_06 + sls_qty_07)/3
                            WHEN ".$bulan." = 8 THEN (sls_qty_06 + sls_qty_07 + sls_qty_08)/3
                            WHEN ".$bulan." = 9 THEN (sls_qty_07 + sls_qty_08 + sls_qty_09)/3
                            WHEN ".$bulan." =10 THEN (sls_qty_08 + sls_qty_09 + sls_qty_10)/3
                            WHEN ".$bulan." =11 THEN (sls_qty_09 + sls_qty_10 + sls_qty_11)/3
                            WHEN ".$bulan." =12 THEN (sls_qty_10 + sls_qty_11 + sls_qty_12)/3
                       END,0) avgqty,
                       NVL(st_sales,0) sales_, NVL(st_saldoakhir,0) saldo, NVL(mgrA,0) margin, NVL(mgrB,0) margin2, NVL(pkm_pkmt,0) ftpkmt,
                       NVL(qtyB,0) PO, NVL(qtyC,0) PB, sup_harikunjungan hrkj, sup_jangkawaktukirimbarang jwpb
                FROM TBMASTER_PERUSAHAAN, TBTR_MONITORINGPLU, TBMASTER_PRODMAST, TBTR_SALESBULANAN, TBMASTER_SUPPLIER, TBMASTER_HARGABELI, TBMASTER_KKPKM,
                (   SELECT st_prdcd, st_sales, st_saldoakhir
                    FROM TBMASTER_STOCK
                    WHERE st_lokasi = '01'
                ),
                (	 SELECT sls_prdcd sum_prdcd, SUM(sls_marginNOMI) mgrA,
                     CASE WHEN SUM(sls_netNOMI) <> 0 THEN SUM(sls_marginNOMI)*100/SUM(sls_netNOMI) ELSE
                     CASE WHEN SUM(sls_marginNOMI) <> 0 THEN 100 ELSE 0 END END mgrB
                     FROM TBTR_SUMSALES
                     WHERE TRUNC(sls_periode) BETWEEN to_date('" . $periode1 . "','dd/mm/yyyy') AND to_date('" . $periode2 . "','dd/mm/yyyy')
                     GROUP BY sls_kodedivisi, sls_kodedepartement, sls_kodekategoribrg, sls_prdcd
                ),
                ( 	 SELECT tpod_prdcd, SUM(qtyB) qtyB
                     FROM
                     (	 SELECT DISTINCT tpod_prdcd, NVL((tpod_qtyPO),0) qtyB
                         FROM TBTR_PO_H, TBTR_PO_D, TBTR_MONITORINGPLU
                         WHERE tpoh_nopo = tpod_nopo
                                AND tpod_prdcd = SUBSTR(mpl_prdcd,1,6)||'0'
                                AND tpod_qtyPB IS NULL AND tpod_recordid IS NULL
                                AND TRUNC(SYSDATE) BETWEEN tpoh_tglPO AND (tpoh_tglPO + tpoh_jwpb)
                     )
                     GROUP BY tpod_prdcd
                ),
                (	 SELECT pbd_prdcd, SUM(qtyC) qtyC
                     FROM
                     (	 SELECT DISTINCT pbd_prdcd, NVL((pbd_qtyPB),0) qtyC
                         FROM TBTR_PB_H, TBTR_PB_D, TBTR_MONITORINGPLU
                         WHERE pbh_nopb = pbd_nopb
                                AND pbd_prdcd = SUBSTR(mpl_prdcd,1,6)||'0'
                                AND pbd_recordid IS NULL AND pbd_qtybpb IS NULL
                                AND TRUNC(SYSDATE) BETWEEN pbh_tglPB AND (pbh_tglPB+2)
                     )
                     GROUP BY pbd_prdcd
                )
                WHERE mpl_kodeigr = prs_kodeigr
                                AND prs_kodeigr = '" . $_SESSION['kdigr'] . "'
                                AND mpl_prdcd = prd_prdcd (+)
                                AND mpl_prdcd = st_prdcd (+)
                                AND mpl_prdcd = sls_prdcd (+)
                                AND sls_kodesupplier = sup_kodesupplier (+)
                                AND mpl_prdcd = hgb_prdcd (+)
                                AND prd_prdcd = pkm_prdcd (+)
                                AND mpl_prdcd = pbd_prdcd (+)
                                AND mpl_prdcd = tpod_prdcd (+)
                                AND mpl_prdcd = sum_prdcd (+)
                                AND hgb_tipe = '2'
                                AND TRANSLATE(mpl_kodemonitoring,' ','_') = '" . $kodemonitoring . "'
                ORDER BY avgsales DESC");
            }
        } else {
            if ($margin == 'Y') {
                $filename = 'monitoring-sales-dan-stock-margin-pdf';
                $data = DB::connection($_SESSION['connection'])
                    ->select("
                    SELECT DISTINCT
                           prs_namaperusahaan, prs_namacabang, prs_namawilayah,
                           mpl_kodemonitoring kode,
                           DIV, div_namadivisi, DEPT, dep_namadepartement, KATB, kat_namakategori,
                           mpl_prdcd prdcd, prd_deskripsipendek, prd_unit||'/'||prd_frac kemasan,
                           nvl(CASE WHEN ".$bulan." = 1 THEN (sls_rph_11 + sls_rph_12 + sls_rph_01)/3
                                WHEN ".$bulan." = 2 THEN (sls_rph_12 + sls_rph_01 + sls_rph_02)/3
                                WHEN ".$bulan." = 3 THEN (sls_rph_01 + sls_rph_02 + sls_rph_03)/3
                                WHEN ".$bulan." = 4 THEN (sls_rph_02 + sls_rph_03 + sls_rph_04)/3
                                WHEN ".$bulan." = 5 THEN (sls_rph_03 + sls_rph_04 + sls_rph_05)/3
                                WHEN ".$bulan." = 6 THEN (sls_rph_04 + sls_rph_05 + sls_rph_06)/3
                                WHEN ".$bulan." = 7 THEN (sls_rph_05 + sls_rph_06 + sls_rph_07)/3
                                WHEN ".$bulan." = 8 THEN (sls_rph_06 + sls_rph_07 + sls_rph_08)/3
                                WHEN ".$bulan." = 9 THEN (sls_rph_07 + sls_rph_08 + sls_rph_09)/3
                                WHEN ".$bulan." =10 THEN (sls_rph_08 + sls_rph_09 + sls_rph_10)/3
                                WHEN ".$bulan." =11 THEN (sls_rph_09 + sls_rph_10 + sls_rph_11)/3
                                WHEN ".$bulan." =12 THEN (sls_rph_10 + sls_rph_11 + sls_rph_12)/3
                           END,0) avgSales,
                           nvl(CASE WHEN ".$bulan." = 1 THEN (sls_qty_11 + sls_qty_12 + sls_qty_01)/3
                                WHEN ".$bulan." = 2 THEN (sls_qty_12 + sls_qty_01 + sls_qty_02)/3
                                WHEN ".$bulan." = 3 THEN (sls_qty_01 + sls_qty_02 + sls_qty_03)/3
                                WHEN ".$bulan." = 4 THEN (sls_qty_02 + sls_qty_03 + sls_qty_04)/3
                                WHEN ".$bulan." = 5 THEN (sls_qty_03 + sls_qty_04 + sls_qty_05)/3
                                WHEN ".$bulan." = 6 THEN (sls_qty_04 + sls_qty_05 + sls_qty_06)/3
                                WHEN ".$bulan." = 7 THEN (sls_qty_05 + sls_qty_06 + sls_qty_07)/3
                                WHEN ".$bulan." = 8 THEN (sls_qty_06 + sls_qty_07 + sls_qty_08)/3
                                WHEN ".$bulan." = 9 THEN (sls_qty_07 + sls_qty_08 + sls_qty_09)/3
                                WHEN ".$bulan." =10 THEN (sls_qty_08 + sls_qty_09 + sls_qty_10)/3
                                WHEN ".$bulan." =11 THEN (sls_qty_09 + sls_qty_10 + sls_qty_11)/3
                                WHEN ".$bulan." =12 THEN (sls_qty_10 + sls_qty_11 + sls_qty_12)/3
                           END,0) avgqty,
                           NVL(st_sales,0) sales_, NVL(st_saldoakhir,0) saldo, NVL(mgrA,0) margin, NVL(mgrB,0) margin2, NVL(pkm_pkmt,0) ftpkmt,
                           NVL(qtyB,0) PO, NVL(qtyC,0) PB, sup_harikunjungan hrkj, sup_jangkawaktukirimbarang jwpb
                    FROM TBMASTER_PERUSAHAAN, TBTR_MONITORINGPLU, TBTR_SALESBULANAN, TBMASTER_SUPPLIER, TBMASTER_HARGABELI, TBMASTER_KKPKM,
                    (	SELECT prd_prdcd, prd_kodedivisi DIV, div_namadivisi, prd_kodedepartement DEPT, dep_namadepartement, prd_kodekategoribarang KATB, kat_namakategori,
                               prd_deskripsipendek, prd_unit, prd_frac
                        FROM TBMASTER_PRODMAST, TBMASTER_DIVISI, TBMASTER_DEPARTEMENT, TBMASTER_KATEGORI
                        WHERE prd_kodedivisi = div_kodedivisi
                          AND prd_kodedepartement = dep_kodedepartement
                          AND prd_kodedepartement = kat_kodedepartement
                          AND prd_kodekategoribarang = kat_kodekategori
                    ),
                    (   SELECT st_prdcd, st_sales, st_saldoakhir
                        FROM TBMASTER_STOCK
                        WHERE st_lokasi = '01'
                    ),
                    (	 SELECT sls_prdcd sum_prdcd, SUM(sls_marginNOMI) mgrA,
                         CASE WHEN SUM(sls_netNOMI) <> 0 THEN SUM(sls_marginNOMI)*100/SUM(sls_netNOMI) ELSE
                         CASE WHEN SUM(sls_marginNOMI) <> 0 THEN 100 ELSE 0 END END mgrB
                         FROM TBTR_SUMSALES
                         WHERE TRUNC(sls_periode) BETWEEN to_date('" . $periode1 . "','dd/mm/yyyy') AND to_date('" . $periode2 . "','dd/mm/yyyy')
                         GROUP BY sls_kodedivisi, sls_kodedepartement, sls_kodekategoribrg, sls_prdcd
                    ),
                    ( 	 SELECT tpod_prdcd, SUM(qtyB) qtyB
                         FROM
                         (	 SELECT DISTINCT tpod_prdcd, NVL((tpod_qtyPO),0) qtyB
                             FROM TBTR_PO_H, TBTR_PO_D, TBTR_MONITORINGPLU
                             WHERE tpoh_nopo = tpod_nopo
                               AND tpod_prdcd = SUBSTR(mpl_prdcd,1,6)||'0'
                               AND tpod_qtyPB IS NULL AND tpod_recordid IS NULL
                               AND TRUNC(SYSDATE) BETWEEN tpoh_tglPO AND (tpoh_tglPO + tpoh_jwpb)
                         )
                         GROUP BY tpod_prdcd
                    ),
                    (	 SELECT pbd_prdcd, SUM(qtyC) qtyC
                         FROM
                         (	 SELECT DISTINCT pbd_prdcd, NVL((pbd_qtyPB),0) qtyC
                             FROM TBTR_PB_H, TBTR_PB_D, TBTR_MONITORINGPLU
                             WHERE pbh_nopb = pbd_nopb
                               AND pbd_prdcd = SUBSTR(mpl_prdcd,1,6)||'0'
                               AND pbd_recordid IS NULL AND pbd_qtybpb IS NULL
                               AND TRUNC(SYSDATE) BETWEEN pbh_tglPB AND (pbh_tglPB+2)
                         )
                         GROUP BY pbd_prdcd
                    )
                    WHERE mpl_kodeigr = prs_kodeigr
                      AND prs_kodeigr = '" . $_SESSION['kdigr'] . "'
                      AND mpl_prdcd = prd_prdcd (+)
                      AND mpl_prdcd = st_prdcd (+)
                      AND mpl_prdcd = sls_prdcd (+)
                      AND sls_kodesupplier = sup_kodesupplier (+)
                      AND mpl_prdcd = hgb_prdcd (+)
                      AND prd_prdcd = pkm_prdcd (+)
                      AND mpl_prdcd = pbd_prdcd (+)
                      AND mpl_prdcd = tpod_prdcd (+)
                      AND mpl_prdcd = sum_prdcd (+)
                      AND hgb_tipe = '2'
                      AND translate(mpl_kodemonitoring,' ','_') = '" . $kodemonitoring . "'
                      AND LENGTH(mpl_namamonitoring) = '".$namamonitoring."'
                    ORDER BY DIV, DEPT, KATB, mpl_prdcd ");
            } else {
                $filename = 'monitoring-sales-dan-stock-pdf';

                $data = DB::connection($_SESSION['connection'])
                    ->select("
                    SELECT DISTINCT
                           prs_namaperusahaan, prs_namacabang, prs_namawilayah,
                           mpl_kodemonitoring kode,
                           DIV, div_namadivisi, DEPT, dep_namadepartement, KATB, kat_namakategori,
                           mpl_prdcd prdcd, prd_deskripsipendek, prd_unit||'/'||prd_frac kemasan,
                           nvl(CASE WHEN ".$bulan." = 1 THEN (sls_rph_11 + sls_rph_12 + sls_rph_01)/3
                                WHEN ".$bulan." = 2 THEN (sls_rph_12 + sls_rph_01 + sls_rph_02)/3
                                WHEN ".$bulan." = 3 THEN (sls_rph_01 + sls_rph_02 + sls_rph_03)/3
                                WHEN ".$bulan." = 4 THEN (sls_rph_02 + sls_rph_03 + sls_rph_04)/3
                                WHEN ".$bulan." = 5 THEN (sls_rph_03 + sls_rph_04 + sls_rph_05)/3
                                WHEN ".$bulan." = 6 THEN (sls_rph_04 + sls_rph_05 + sls_rph_06)/3
                                WHEN ".$bulan." = 7 THEN (sls_rph_05 + sls_rph_06 + sls_rph_07)/3
                                WHEN ".$bulan." = 8 THEN (sls_rph_06 + sls_rph_07 + sls_rph_08)/3
                                WHEN ".$bulan." = 9 THEN (sls_rph_07 + sls_rph_08 + sls_rph_09)/3
                                WHEN ".$bulan." =10 THEN (sls_rph_08 + sls_rph_09 + sls_rph_10)/3
                                WHEN ".$bulan." =11 THEN (sls_rph_09 + sls_rph_10 + sls_rph_11)/3
                                WHEN ".$bulan." =12 THEN (sls_rph_10 + sls_rph_11 + sls_rph_12)/3
                           END,0) avgSales,
                           nvl(CASE WHEN ".$bulan." = 1 THEN (sls_qty_11 + sls_qty_12 + sls_qty_01)/3
                                WHEN ".$bulan." = 2 THEN (sls_qty_12 + sls_qty_01 + sls_qty_02)/3
                                WHEN ".$bulan." = 3 THEN (sls_qty_01 + sls_qty_02 + sls_qty_03)/3
                                WHEN ".$bulan." = 4 THEN (sls_qty_02 + sls_qty_03 + sls_qty_04)/3
                                WHEN ".$bulan." = 5 THEN (sls_qty_03 + sls_qty_04 + sls_qty_05)/3
                                WHEN ".$bulan." = 6 THEN (sls_qty_04 + sls_qty_05 + sls_qty_06)/3
                                WHEN ".$bulan." = 7 THEN (sls_qty_05 + sls_qty_06 + sls_qty_07)/3
                                WHEN ".$bulan." = 8 THEN (sls_qty_06 + sls_qty_07 + sls_qty_08)/3
                                WHEN ".$bulan." = 9 THEN (sls_qty_07 + sls_qty_08 + sls_qty_09)/3
                                WHEN ".$bulan." =10 THEN (sls_qty_08 + sls_qty_09 + sls_qty_10)/3
                                WHEN ".$bulan." =11 THEN (sls_qty_09 + sls_qty_10 + sls_qty_11)/3
                                WHEN ".$bulan." =12 THEN (sls_qty_10 + sls_qty_11 + sls_qty_12)/3
                           END,0) avgqty,
                           NVL(st_sales,0) sales_, NVL(st_saldoakhir,0) saldo, NVL(mgrA,0) margin, NVL(mgrB,0) margin2, NVL(pkm_pkmt,0) ftpkmt,
                           NVL(qtyB,0) PO, NVL(qtyC,0) PB, sup_harikunjungan hrkj, sup_jangkawaktukirimbarang jwpb
                    FROM TBMASTER_PERUSAHAAN, TBTR_MONITORINGPLU, TBTR_SALESBULANAN, TBMASTER_SUPPLIER, TBMASTER_HARGABELI, TBMASTER_KKPKM,
                    (	SELECT prd_prdcd, prd_kodedivisi DIV, div_namadivisi, prd_kodedepartement DEPT, dep_namadepartement, prd_kodekategoribarang KATB, kat_namakategori,
                               prd_deskripsipendek, prd_unit, prd_frac
                        FROM TBMASTER_PRODMAST, TBMASTER_DIVISI, TBMASTER_DEPARTEMENT, TBMASTER_KATEGORI
                        WHERE prd_kodedivisi = div_kodedivisi
                          AND prd_kodedepartement = dep_kodedepartement
                          AND prd_kodedepartement = kat_kodedepartement
                          AND prd_kodekategoribarang = kat_kodekategori
                    ),
                    (   SELECT st_prdcd, st_sales, st_saldoakhir
                        FROM TBMASTER_STOCK
                        WHERE st_lokasi = '01'
                    ),
                    (	 SELECT sls_prdcd sum_prdcd, SUM(sls_marginNOMI) mgrA,
                         CASE WHEN SUM(sls_netNOMI) <> 0 THEN SUM(sls_marginNOMI)*100/SUM(sls_netNOMI) ELSE
                         CASE WHEN SUM(sls_marginNOMI) <> 0 THEN 100 ELSE 0 END END mgrB
                         FROM TBTR_SUMSALES
                         WHERE TRUNC(sls_periode) BETWEEN to_date('" . $periode1 . "','dd/mm/yyyy') AND to_date('" . $periode2 . "','dd/mm/yyyy')
                         GROUP BY sls_kodedivisi, sls_kodedepartement, sls_kodekategoribrg, sls_prdcd
                    ),
                    ( 	 SELECT tpod_prdcd, SUM(qtyB) qtyB
                         FROM
                         (	 SELECT DISTINCT tpod_prdcd, NVL((tpod_qtyPO),0) qtyB
                             FROM TBTR_PO_H, TBTR_PO_D, TBTR_MONITORINGPLU
                             WHERE tpoh_nopo = tpod_nopo
                               AND tpod_prdcd = SUBSTR(mpl_prdcd,1,6)||'0'
                               AND tpod_qtyPB IS NULL AND tpod_recordid IS NULL
                               AND TRUNC(SYSDATE) BETWEEN tpoh_tglPO AND (tpoh_tglPO + tpoh_jwpb)
                         )
                         GROUP BY tpod_prdcd
                    ),
                    (	 SELECT pbd_prdcd, SUM(qtyC) qtyC
                         FROM
                         (	 SELECT DISTINCT pbd_prdcd, NVL((pbd_qtyPB),0) qtyC
                             FROM TBTR_PB_H, TBTR_PB_D, TBTR_MONITORINGPLU
                             WHERE pbh_nopb = pbd_nopb
                               AND pbd_prdcd = SUBSTR(mpl_prdcd,1,6)||'0'
                               AND pbd_recordid IS NULL AND pbd_qtybpb IS NULL
                               AND TRUNC(SYSDATE) BETWEEN pbh_tglPB AND (pbh_tglPB+2)
                         )
                         GROUP BY pbd_prdcd
                    )
                    WHERE mpl_kodeigr = prs_kodeigr
                      AND prs_kodeigr = '" . $_SESSION['kdigr'] . "'
                      AND mpl_prdcd = prd_prdcd (+)
                      AND mpl_prdcd = st_prdcd (+)
                      AND mpl_prdcd = sls_prdcd (+)
                      AND sls_kodesupplier = sup_kodesupplier (+)
                      AND mpl_prdcd = hgb_prdcd (+)
                      AND prd_prdcd = pkm_prdcd (+)
                      AND mpl_prdcd = pbd_prdcd (+)
                      AND mpl_prdcd = tpod_prdcd (+)
                      AND mpl_prdcd = sum_prdcd (+)
                      AND hgb_tipe = '2'
                      AND translate(mpl_kodemonitoring,' ','_') = '".$kodemonitoring."'
                      AND LENGTH(mpl_namamonitoring) = '".$namamonitoring."'
                    ORDER BY DIV, DEPT, KATB, mpl_prdcd ");
            }
        }


        return view('TABEL.' . $filename, compact(['perusahaan', 'data', 'periode', 'namaulan','kodemonitoring']));
    }

    public function nvl($value, $defaultvalue)
    {
        if ($value == null || $value == '')
            return $defaultvalue;
        else return $value;
    }
}

