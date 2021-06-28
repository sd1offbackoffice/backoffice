<?php
/**
 * Created by PhpStorm.
 * User: ryan
 * Date: 1/12/2021
 * Time: 3:25 PM
 */

namespace App\Http\Controllers\BACKOFFICE\KERJASAMAIGRIDM;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use PDF;
use Yajra\DataTables\DataTables;

class StoutController extends Controller
{

    public function index()
    {
        return view('BACKOFFICE/KERJASAMAIGRIDM.igridm_stout');
    }

    public function GetDiv(Request $request){

        $datas = DB::table('tbmaster_divisi')
            ->selectRaw('distinct div_kodedivisi as div_kodedivisi')
            ->selectRaw('div_namadivisi')
            ->selectRaw('div_singkatannamadivisi')
            ->orderBy('div_kodedivisi')
            ->get();

        return response()->json($datas);
    }

    public function GetDept(Request $request){
        $div1 = $request->div1;
        $div2 = $request->div2;

        $datas = DB::table('tbmaster_departement')
            ->selectRaw('distinct dep_kodedepartement as dep_kodedepartement')
            ->selectRaw('dep_namadepartement')
            ->selectRaw('dep_kodedivisi')
            ->selectRaw('dep_singkatandepartement')
            ->whereRaw("dep_kodedivisi between '$div1' and '$div2'")
            ->orderBy('dep_kodedepartement')
            ->orderBy('dep_kodedivisi')
            ->get();

        return response()->json($datas);
    }

    public function GetKat(Request $request){
        $dept1 = $request->dept1;
        $dept2 = $request->dept2;

        $datas = DB::table('tbmaster_kategori')
            ->selectRaw('distinct kat_kodekategori as kat_kodekategori')
            ->selectRaw('kat_namakategori')
            ->selectRaw('kat_kodedepartement')
            ->selectRaw('kat_singkatan')
            ->whereRaw("kat_kodedepartement between '$dept1' and '$dept2'")
            ->orderBy('kat_kodekategori')
            ->orderBy('kat_kodedepartement')
            ->get();

        return response()->json($datas);
    }

    public function CheckData(Request $request){
        $kodeigr = $_SESSION['kdigr'];
        $div1 = $request->div1;
        $div2 = $request->div2;
        $dept1 = $request->dept1;
        $dept2 = $request->dept2;
        $kat1 = $request->kat1;
        $kat2 = $request->kat2;
        $choice = $request->choice;
        if($choice == 'r1'){
            $cursor = DB::select("SELECT prs_namacabang, prs_namaperusahaan, prs_namawilayah,
prd_prdcd, prc_pluidm, prd_deskripsipanjang, prd_kodedivisi, div_namadivisi, prd_kodedepartement, dep_namadepartement, prd_kodekategoribarang, kat_namakategori,
prd_kodedivisi || '-' || div_namadivisi || ' . ' || prd_kodedepartement || '-' || dep_namadepartement || ' . ' || prd_kodekategoribarang || '-' || kat_namakategori divdeptkat,  st_saldoakhir, ( ksl_mean  * 3 ) ksl_mean, PKM_PKMT
FROM tbmaster_prodmast, tbmaster_prodcrm, tbmaster_stock, TBMASTER_KKPKM, tbmaster_kph, tbmaster_perusahaan, tbmaster_divisi, tbmaster_departement, tbmaster_kategori
WHERE prd_kodeigr = '$kodeigr'
AND prd_kodedivisi BETWEEN '$div1' and '$div2'
AND prd_kodedepartement BETWEEN '$dept1' and '$dept2'
AND prd_kodekategoribarang BETWEEN '$kat1' and '$kat2'
AND prc_pluigr = prd_prdcd
AND st_prdcd = prc_pluigr AND st_lokasi = '01'
AND prc_pluidm IS NOT NULL
AND prdcd = prc_pluidm
AND prs_kodeigr = prd_kodeigr
AND st_saldoakhir < (ksl_mean * 3)
and div_kodedivisi = prd_kodedivisi
and dep_kodedepartement = prd_kodedepartement
and dep_kodedivisi = prd_kodedivisi
and kat_kodekategori = prd_kodekategoribarang
and kat_kodedepartement = prd_kodedepartement
AND PKM_PRDCD(+) = PRD_PRDCD
AND EXISTS (
                       SELECT 1
                         FROM (SELECT MAX (   SUBSTR (PID, -4, 4)
                                           || LPAD (SUBSTR (PID, 1, LENGTH (PID) - 4), 2, '0')
                                          ) MAXPID
                                 FROM TBMASTER_KPH)
                        WHERE MAXPID =
                                     SUBSTR (PID, -4, 4)
                                  || LPAD (SUBSTR (PID, 1, LENGTH (PID) - 4), 2, '0'))
ORDER BY prd_kodedivisi, prd_kodedepartement, prd_kodekategoribarang, prc_pluidm");
        }elseif ($choice == 'r2'){
            $cursor = DB::select("SELECT   PRS_NAMACABANG, PRS_NAMAPERUSAHAAN, PRS_NAMAWILAYAH, PRD_PRDCD, PRC_PLUIDM,
         PRD_DESKRIPSIPANJANG, ST_SALDOAKHIR, (KSL_MEAN * 3) KSL_MEAN, PRD_KODEDIVISI,
         PRD_KODEDEPARTEMENT, PRD_KODEKATEGORIBARANG,
            PRD_KODEDIVISI
         || '-'
         || DIV_NAMADIVISI
         || ' . '
         || PRD_KODEDEPARTEMENT
         || '-'
         || DEP_NAMADEPARTEMENT
         || ' . '
         || PRD_KODEKATEGORIBARANG
         || '-'
         || KAT_NAMAKATEGORI DIVDEPTKAT,
         PKM_PKMT
    FROM TBMASTER_PRODMAST,
         TBMASTER_PRODCRM,
         TBMASTER_STOCK,
         TBMASTER_KPH,
         TBMASTER_KKPKM,
         TBMASTER_PERUSAHAAN,
         TBMASTER_DIVISI,
         TBMASTER_DEPARTEMENT,
         TBMASTER_KATEGORI,
(
             SELECT TPOD_PRDCD
               FROM (SELECT   TPOD_PRDCD, SUM (BTB) BTB
                         FROM (SELECT *
                                 FROM (SELECT ROW_NUMBER () OVER (PARTITION BY TPOD_PRDCD ORDER BY TPOD_TGLPO DESC)
                                                                                              AS RN,
                                              TPOD_PRDCD, TPOD_NOPO, TPOD_TGLPO, MSTD_PRDCD,
                                              MSTD_NOPO,
                                              CASE
                                                  WHEN MSTD_PRDCD IS NOT NULL
                                                   OR TRUNC (TPOH_TGLPO + TPOH_JWPB) >=
                                                                                     TRUNC (SYSDATE)
                                                      THEN 1
                                                  ELSE 0
                                              END BTB
                                         FROM TBTR_PO_D, TBTR_PO_H, TBTR_MSTRAN_D
                                        WHERE NVL (TPOD_RECORDID, '0') <> '1'
                                          AND TPOH_NOPO = TPOD_NOPO
                                          AND MSTD_PRDCD(+) = TPOD_PRDCD
                                          AND MSTD_NOPO(+) = TPOD_NOPO
                                          AND MSTD_TYPETRN(+) = 'B')
                                WHERE RN <= 2) AAA
                     GROUP BY TPOD_PRDCD) BBB
              WHERE NVL (BTB, 0) = 0)
   WHERE PRD_KODEIGR = '$kodeigr'
     AND PRD_PRDCD = TPOD_PRDCD
     AND PRD_KODEDIVISI BETWEEN '$div1' AND '$div2'
     AND PRD_KODEDEPARTEMENT BETWEEN '$dept1' AND '$dept2'
     AND PRD_KODEKATEGORIBARANG BETWEEN '$kat1' AND '$kat2'
     AND PRC_PLUIGR = PRD_PRDCD
     AND ST_PRDCD = PRC_PLUIGR
     AND ST_LOKASI = '01'
     AND PRC_PLUIDM IS NOT NULL
     AND PRDCD = PRC_PLUIDM
     AND PRS_KODEIGR = PRD_KODEIGR
     AND ST_SALDOAKHIR < (KSL_MEAN * 3)
     AND PKM_PRDCD(+) = PRD_PRDCD
     AND DIV_KODEDIVISI = PRD_KODEDIVISI
     AND DEP_KODEDEPARTEMENT = PRD_KODEDEPARTEMENT
     AND KAT_KODEDEPARTEMENT = PRD_KODEDEPARTEMENT
     AND KAT_KODEKATEGORI = PRD_KODEKATEGORIBARANG
     AND EXISTS (
             SELECT 1
               FROM (SELECT MAX (   SUBSTR (PID, -4, 4)
                                 || LPAD (SUBSTR (PID, 1, LENGTH (PID) - 4), 2, '0')
                                ) MAXPID
                       FROM TBMASTER_KPH)
              WHERE MAXPID = SUBSTR (PID, -4, 4) || LPAD (SUBSTR (PID, 1, LENGTH (PID) - 4), 2, '0'))
ORDER BY PRD_KODEDIVISI, PRD_KODEDEPARTEMENT, PRD_KODEKATEGORIBARANG, PRC_PLUIDM");
        }
        if(!$cursor){
            return response()->json(['kode' => 1]);
        }else{
            return response()->json(['kode' => 0]);
        }
    }
    public function printDocument(Request $request){
        $kodeigr = $_SESSION['kdigr'];
        $today  = date('Y-m-d H:i:s');
        $div1 = $request->div1;
        $div2 = $request->div2;
        $dept1 = $request->dept1;
        $dept2 = $request->dept2;
        $kat1 = $request->kat1;
        $kat2 = $request->kat2;
        $choice = $request->choice;
        if($choice == 'r1'){
            $datas = DB::select("SELECT prs_namacabang, prs_namaperusahaan, prs_namawilayah,
prd_prdcd, prc_pluidm, prd_deskripsipanjang, prd_kodedivisi, div_namadivisi, prd_kodedepartement, dep_namadepartement, prd_kodekategoribarang, kat_namakategori,
prd_kodedivisi || '-' || div_namadivisi || ' . ' || prd_kodedepartement || '-' || dep_namadepartement || ' . ' || prd_kodekategoribarang || '-' || kat_namakategori divdeptkat,  st_saldoakhir, ( ksl_mean  * 3 ) ksl_mean, PKM_PKMT
FROM tbmaster_prodmast, tbmaster_prodcrm, tbmaster_stock, TBMASTER_KKPKM, tbmaster_kph, tbmaster_perusahaan, tbmaster_divisi, tbmaster_departement, tbmaster_kategori
WHERE prd_kodeigr = '$kodeigr'
AND prd_kodedivisi BETWEEN '$div1' and '$div2'
AND prd_kodedepartement BETWEEN '$dept1' and '$dept2'
AND prd_kodekategoribarang BETWEEN '$kat1' and '$kat2'
AND prc_pluigr = prd_prdcd
AND st_prdcd = prc_pluigr AND st_lokasi = '01'
AND prc_pluidm IS NOT NULL
AND prdcd = prc_pluidm
AND prs_kodeigr = prd_kodeigr
AND st_saldoakhir < (ksl_mean * 3)
and div_kodedivisi = prd_kodedivisi
and dep_kodedepartement = prd_kodedepartement
and dep_kodedivisi = prd_kodedivisi
and kat_kodekategori = prd_kodekategoribarang
and kat_kodedepartement = prd_kodedepartement
AND PKM_PRDCD(+) = PRD_PRDCD
AND EXISTS (
                       SELECT 1
                         FROM (SELECT MAX (   SUBSTR (PID, -4, 4)
                                           || LPAD (SUBSTR (PID, 1, LENGTH (PID) - 4), 2, '0')
                                          ) MAXPID
                                 FROM TBMASTER_KPH)
                        WHERE MAXPID =
                                     SUBSTR (PID, -4, 4)
                                  || LPAD (SUBSTR (PID, 1, LENGTH (PID) - 4), 2, '0'))
ORDER BY prd_kodedivisi, prd_kodedepartement, prd_kodekategoribarang, prc_pluidm");
        }elseif ($choice == 'r2'){
            $datas = DB::select("SELECT   PRS_NAMACABANG, PRS_NAMAPERUSAHAAN, PRS_NAMAWILAYAH, PRD_PRDCD, PRC_PLUIDM,
         PRD_DESKRIPSIPANJANG, ST_SALDOAKHIR, (KSL_MEAN * 3) KSL_MEAN, PRD_KODEDIVISI,
         PRD_KODEDEPARTEMENT, PRD_KODEKATEGORIBARANG,
            PRD_KODEDIVISI
         || '-'
         || DIV_NAMADIVISI
         || ' . '
         || PRD_KODEDEPARTEMENT
         || '-'
         || DEP_NAMADEPARTEMENT
         || ' . '
         || PRD_KODEKATEGORIBARANG
         || '-'
         || KAT_NAMAKATEGORI DIVDEPTKAT,
         PKM_PKMT
    FROM TBMASTER_PRODMAST,
         TBMASTER_PRODCRM,
         TBMASTER_STOCK,
         TBMASTER_KPH,
         TBMASTER_KKPKM,
         TBMASTER_PERUSAHAAN,
         TBMASTER_DIVISI,
         TBMASTER_DEPARTEMENT,
         TBMASTER_KATEGORI,
(
             SELECT TPOD_PRDCD
               FROM (SELECT   TPOD_PRDCD, SUM (BTB) BTB
                         FROM (SELECT *
                                 FROM (SELECT ROW_NUMBER () OVER (PARTITION BY TPOD_PRDCD ORDER BY TPOD_TGLPO DESC)
                                                                                              AS RN,
                                              TPOD_PRDCD, TPOD_NOPO, TPOD_TGLPO, MSTD_PRDCD,
                                              MSTD_NOPO,
                                              CASE
                                                  WHEN MSTD_PRDCD IS NOT NULL
                                                   OR TRUNC (TPOH_TGLPO + TPOH_JWPB) >=
                                                                                     TRUNC (SYSDATE)
                                                      THEN 1
                                                  ELSE 0
                                              END BTB
                                         FROM TBTR_PO_D, TBTR_PO_H, TBTR_MSTRAN_D
                                        WHERE NVL (TPOD_RECORDID, '0') <> '1'
                                          AND TPOH_NOPO = TPOD_NOPO
                                          AND MSTD_PRDCD(+) = TPOD_PRDCD
                                          AND MSTD_NOPO(+) = TPOD_NOPO
                                          AND MSTD_TYPETRN(+) = 'B')
                                WHERE RN <= 2) AAA
                     GROUP BY TPOD_PRDCD) BBB
              WHERE NVL (BTB, 0) = 0)
   WHERE PRD_KODEIGR = '$kodeigr'
     AND PRD_PRDCD = TPOD_PRDCD
     AND PRD_KODEDIVISI BETWEEN '$div1' AND '$div2'
     AND PRD_KODEDEPARTEMENT BETWEEN '$dept1' AND '$dept2'
     AND PRD_KODEKATEGORIBARANG BETWEEN '$kat1' AND '$kat2'
     AND PRC_PLUIGR = PRD_PRDCD
     AND ST_PRDCD = PRC_PLUIGR
     AND ST_LOKASI = '01'
     AND PRC_PLUIDM IS NOT NULL
     AND PRDCD = PRC_PLUIDM
     AND PRS_KODEIGR = PRD_KODEIGR
     AND ST_SALDOAKHIR < (KSL_MEAN * 3)
     AND PKM_PRDCD(+) = PRD_PRDCD
     AND DIV_KODEDIVISI = PRD_KODEDIVISI
     AND DEP_KODEDEPARTEMENT = PRD_KODEDEPARTEMENT
     AND KAT_KODEDEPARTEMENT = PRD_KODEDEPARTEMENT
     AND KAT_KODEKATEGORI = PRD_KODEKATEGORIBARANG
     AND EXISTS (
             SELECT 1
               FROM (SELECT MAX (   SUBSTR (PID, -4, 4)
                                 || LPAD (SUBSTR (PID, 1, LENGTH (PID) - 4), 2, '0')
                                ) MAXPID
                       FROM TBMASTER_KPH)
              WHERE MAXPID = SUBSTR (PID, -4, 4) || LPAD (SUBSTR (PID, 1, LENGTH (PID) - 4), 2, '0'))
ORDER BY PRD_KODEDIVISI, PRD_KODEDEPARTEMENT, PRD_KODEKATEGORIBARANG, PRC_PLUIDM");
        }

        //PRINT
        if($choice == 'r1'){
            $path = 'BACKOFFICE\KERJASAMAIGRIDM.igridm_stout-pdf';
        }elseif ($choice == 'r2'){
            $path = 'BACKOFFICE\KERJASAMAIGRIDM.igridm_stout2-pdf';
        }
        $pdf = PDF::loadview($path,
            ['kodeigr' => $kodeigr, 'datas' => $datas, 'today' => $today]);
        $pdf->setPaper('A4', 'potrait');
        $pdf->output();
        $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);

        $canvas = $dompdf ->get_canvas();
        $canvas->page_text(514, 10, "Hal {PAGE_NUM} / {PAGE_COUNT}", null, 8, array(0, 0, 0));

        return $pdf->stream($path);


        //return view("BACKOFFICE\KERJASAMAIGRIDM.LapBedaTag-pdf", ['kodeigr' => $kodeigr, 'tag' => $tag, 'datas' => $datas, 'today' => $today, 'time' => $time]);
    }
}
