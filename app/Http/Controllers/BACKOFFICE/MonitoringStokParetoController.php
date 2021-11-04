<?php

namespace App\Http\Controllers\BACKOFFICE;

use Carbon\Carbon;
use http\Env\Response;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;
use PDF;
use Yajra\DataTables\DataTables;

class MonitoringStokParetoController extends Controller
{
    public function index(){
        $periode = date_format(Carbon::now(), 'd/m/Y');

        if(date_format(Carbon::now(),'w') == 5){
            $pbtgl = date_format(Carbon::now()->addDays(3),'d/m/Y');
            $pbhari = $this->getHari(date_format(Carbon::now()->addDays(3),'w'));
        }
        else if(date_format(Carbon::now(),'w') == 6){
            $pbtgl = date_format(Carbon::now()->addDays(2),'d/m/Y');
            $pbhari = $this->getHari(date_format(Carbon::now()->addDays(2),'w'));
        }
        else{
            $pbtgl = date_format(Carbon::now()->addDays(1),'d/m/Y');
            $pbhari = $this->getHari(date_format(Carbon::now()->addDays(1),'w'));
        }

        return view('BACKOFFICE.MONITORINGSTOKPARETO.monitoring-stok-pareto')->with(compact(['periode','pbtgl','pbhari']));
    }

    public function getLovMonitoring(){
        $data = DB::connection($_SESSION['connection'])->select("select distinct mpl_kodemonitoring kode_mon, mpl_namamonitoring nama_mon
            from tbtr_monitoringplu
            where mpl_kodemonitoring in('SM', 'SJMF', 'SJMNF', 'SPVF', 'SPVNF', 'SPVGMS','F1','F2','NF1','NF2','G','O')
            order by mpl_kodemonitoring");

        return DataTables::of($data)->make(true);
    }

    public function getHari($hari){
        switch ($hari){
            case 0 : return 'MINGGU';
            case 1 : return 'SENIN';
            case 2 : return 'SELASA';
            case 3 : return 'RABU';
            case 4 : return 'KAMIS';
            case 5 : return 'JUMAT';
            case 6 : return 'SABTU';
        }
    }

    public function printKKH(Request $request){
        $kodemon = $request->kodemon;

        if(date_format(Carbon::now(),'w') == 5){
            $hrkj = date_format(Carbon::now()->addDays(4),'w');
        }
        else if(date_format(Carbon::now(),'w') == 6){
            $hrkj = date_format(Carbon::now()->addDays(3),'w');
        }
        else{
            $hrkj = date_format(Carbon::now()->addDays(2),'w');
        }

        $hrkj++;

        $perusahaan = DB::connection($_SESSION['connection'])->table("tbmaster_perusahaan")->first();

        $data = [];

        $data = DB::connection($_SESSION['connection'])->select("SELECT   HGB_KODESUPPLIER KDSUP, SUP_NAMASUPPLIER NMSUP,
         PRD_PRDCD PLU, PRD_DESKRIPSIPANJANG DESKRIPSI, PRD_UNIT UNIT, PRD_UNIT || ' / ' || PRD_FRAC SATUAN_JUAL,
         PRD_SATUANBELI || ' / ' || PRD_ISIBELI SATUAN_BELI, ST_SALDOAWAL SALDOAWAL,
         ST_SALDOAKHIR SALDOAKHIR, OUTPO, OUTQTY, SUP_JANGKAWAKTUKIRIMBARANG LT,
         PRD_MINORDER MINQTY, SUP_MINRPH MINRPH, NVL (PRD_FLAGKELIPATANORDER, 'N') MINKLPTN,
         PKM_PKMT PKMT, MPT_MAXQTY max_ctn, (mpt_maxqty * prd_frac) max_pcs
    FROM TBMASTER_PRODMAST,
         TBMASTER_STOCK,
         TBMASTER_SUPPLIER,
         TBMASTER_KKPKM,
         TBMASTER_MAXPALET,
         (SELECT HGB_KODEIGR, HGB_PRDCD, HGB_KODESUPPLIER, HGB_HRGBELI,
                 HGB_ISISATUANBELI
            FROM TBMASTER_HARGABELI
           WHERE HGB_TIPE = 2),
         (SELECT   TPOD_PRDCD, COUNT (TPOH_NOPO) OUTPO, SUM (QTYOUT) OUTQTY
              FROM (SELECT TPOD_PRDCD, TPOH_NOPO, (TPOD_QTYPO) QTYOUT
                      FROM TBTR_PO_H, TBTR_PO_D, TBTR_MSTRAN_D
                     WHERE NVL (TPOH_RECORDID, '0') NOT IN ('1', '2')
                       AND TPOH_TGLPO + TPOH_JWPB > SYSDATE
                       AND TPOD_NOPO = TPOH_NOPO
                       AND MSTD_NOPO(+) = TPOD_NOPO
                       AND MSTD_PRDCD(+) = TPOD_PRDCD
                       AND NVL (MSTD_RECORDID(+), '0') <> '1')
          GROUP BY TPOD_PRDCD)
   WHERE PRD_KODEIGR = '".$_SESSION['kdigr']."'
     AND PRD_PRDCD LIKE '%0'
     AND PRD_KODEIGR = HGB_KODEIGR(+)
     AND PRD_PRDCD = HGB_PRDCD(+)
     AND PRD_KODEIGR = ST_KODEIGR(+)
     AND ST_LOKASI(+) = '01'
     AND MPT_PRDCD(+) = PRD_PRDCD
     AND PRD_PRDCD = ST_PRDCD(+)
     AND PRD_PRDCD = TPOD_PRDCD(+)
     AND HGB_KODESUPPLIER = SUP_KODESUPPLIER(+)
     AND SUBSTR (SUP_HARIKUNJUNGAN, '".$hrkj."', 1) = 'Y'
     AND PRD_PRDCD = PKM_PRDCD(+)
     AND EXISTS (
             SELECT 1
               FROM TBTR_MONITORINGPLU
              WHERE MPL_PRDCD = PRD_PRDCD
                AND TRANSLATE (MPL_KODEMONITORING, ' ', '_') = '".$kodemon."')
    ORDER BY kdsup, PRD_PRDCD");

        $c = loginController::getConnectionProcedure();

        foreach($data as $d){
            $temp = DB::connection($_SESSION['connection'])->table('tbtr_konversiplu')
                ->select('kvp_pluold')
                ->where('kvp_kodetipe','=','M')
                ->where('kvp_plunew','=',$d->plu)
                ->first();

            $qtyb1 = 0;
            $qtyb2 = 0;
            $qtyb3 = 0;
            $harib1 = 0;
            $harib2 = 0;
            $harib3 = 0;

            if($temp){
                $v_pluold = $temp->kvp_pluold;

                $sql = "BEGIN SP_PKM_SALES ('".$_SESSION['kdigr']."',
                      ".DB::RAW("ADD_MONTHS(TRUNC(SYSDATE),-1)").",
                      ".DB::RAW("ADD_MONTHS(TRUNC(SYSDATE),-2)").",
                      ".DB::RAW("ADD_MONTHS(TRUNC(SYSDATE),-3)").",
                      '".$v_pluold."',
                      'Y',
                      :QTYB1,
                      :QTYB2,
                      :QTYB3,
                      :HARIB1,
                      :HARIB2,
                      :HARIB3,
                      :ERRM
                     ); END;";
                $s = oci_parse($c, $sql);

                oci_bind_by_name($s, ':QTYB1', $qtyb1,100);
                oci_bind_by_name($s, ':QTYB2', $qtyb2,100);
                oci_bind_by_name($s, ':QTYB3', $qtyb3,100);
                oci_bind_by_name($s, ':HARIB1', $harib1,100);
                oci_bind_by_name($s, ':HARIB2', $harib2,100);
                oci_bind_by_name($s, ':HARIB3', $harib3,100);
                oci_bind_by_name($s, ':ERRM', $errm,100);
                oci_execute($s);
            }

            $sql = "BEGIN SP_PKM_SALES ('".$_SESSION['kdigr']."',
                      ".DB::RAW("ADD_MONTHS(TRUNC(SYSDATE),-1)").",
                      ".DB::RAW("ADD_MONTHS(TRUNC(SYSDATE),-2)").",
                      ".DB::RAW("ADD_MONTHS(TRUNC(SYSDATE),-3)").",
                      '".$d->plu."',
                      'Y',
                      :QTY1,
                      :QTY2,
                      :QTY3,
                      :HARI1,
                      :HARI2,
                      :HARI3,
                      :ERRM
                     ); END;";
            $s = oci_parse($c, $sql);

            oci_bind_by_name($s, ':QTY1', $qty1,100);
            oci_bind_by_name($s, ':QTY2', $qty2,100);
            oci_bind_by_name($s, ':QTY3', $qty3,100);
            oci_bind_by_name($s, ':HARI1', $hari1,100);
            oci_bind_by_name($s, ':HARI2', $hari2,100);
            oci_bind_by_name($s, ':HARI3', $hari3,100);
            oci_bind_by_name($s, ':ERRM', $errm,100);
            oci_execute($s);

            $d->qty1 = $qty1 + $qtyb1;
            $d->qty2 = $qty2 + $qtyb2;
            $d->qty3 = $qty3 + $qtyb3;
            $d->hari1 = $hari1 + $harib1;
            $d->hari2 = $hari2 + $harib2;
            $d->hari3 = $hari3 + $harib3;

            $d->cp_sales1 = $d->qty3 / ($d->unit == 'KG' ? 1000 : 1);
            $d->cp_sales2 = $d->qty2 / ($d->unit == 'KG' ? 1000 : 1);
            $d->cp_sales3 = $d->qty1 / ($d->unit == 'KG' ? 1000 : 1);
            $d->cp_hari = $hari1 + $hari2 + $hari3;

            $d->cp_avgbulan = round(round(($qty1 + $qty2 + $qty3) / 3) / ($d->unit == 'KG' ? 100 : 1));

            if($d->cp_hari == 0)
                $d->cp_avghari = 0;
            else $d->cp_avghari = round(round(($qty1 + $qty2 + $qty3) / $d->cp_hari) / ($d->unit == 'KG' ? 1000 : 1));

            $d->cp_qtypb = '';

//            dd($d);
        }

        $dompdf = new PDF();

        $pdf = PDF::loadview('BACKOFFICE.MONITORINGSTOKPARETO.kkhpb-pdf',compact(['perusahaan','data']));

        error_reporting(E_ALL ^ E_DEPRECATED);

        $pdf->output();
        $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);

        $canvas = $dompdf ->get_canvas();
        $canvas->page_text(755, 80.75, "{PAGE_NUM} dari {PAGE_COUNT}", null, 7, array(0, 0, 0));

        $dompdf = $pdf;

        return $dompdf->stream('Kertas Kerja Harian PB Manual.pdf');
    }

    public function printMontok(Request $request){
        $kodemon = $request->kodemon;

        $perusahaan = DB::connection($_SESSION['connection'])->table("tbmaster_perusahaan")->first();

        $data = [];

        $data = DB::connection($_SESSION['connection'])->select("SELECT   MPL_PRDCD PLU, PRD_DESKRIPSIPENDEK DESKRIPSI,
             PRD_UNIT || '/' || PRD_FRAC SATUAN, PRD_UNIT UNIT, ST_SALDOAKHIR SALDOAKHIR, OUTPO, OUTQTY,
             PRD_MINORDER MINQTY, PKM_PKMT PKMT, PRD_KODEDIVISI DIV, PRD_KODEDEPARTEMENT DEP,
             PRD_KODEKATEGORIBARANG KAT, DIV_NAMADIVISI NMDIV, DEP_NAMADEPARTEMENT NMDEP,
             KAT_NAMAKATEGORI NMKAT
        FROM TBTR_MONITORINGPLU,
             TBMASTER_PRODMAST,
             TBMASTER_STOCK,
             TBMASTER_KKPKM,
             (SELECT   TPOD_PRDCD, COUNT (TPOH_NOPO) OUTPO, SUM (QTYOUT) OUTQTY
                  FROM (SELECT TPOD_PRDCD, TPOH_NOPO, (TPOD_QTYPO) QTYOUT
                          FROM TBTR_PO_H, TBTR_PO_D, TBTR_MSTRAN_D
                         WHERE NVL (TPOH_RECORDID, '0') NOT IN ('1', '2')
                           AND TPOH_TGLPO + TPOH_JWPB >= trunc(SYSDATE)
                           AND TPOD_NOPO = TPOH_NOPO
                           AND MSTD_NOPO(+) = TPOD_NOPO
                           AND MSTD_PRDCD(+) = TPOD_PRDCD
                           AND NVL (MSTD_RECORDID(+), '0') <> '1')
              GROUP BY TPOD_PRDCD),
             TBMASTER_DIVISI,
             TBMASTER_DEPARTEMENT,
             TBMASTER_KATEGORI
       WHERE MPL_KODEIGR = '".$_SESSION['kdigr']."'
         AND MPL_PRDCD = PRD_PRDCD(+)
         AND MPL_KODEIGR = ST_KODEIGR(+)
         AND ST_LOKASI(+) = '01'
         AND MPL_PRDCD = ST_PRDCD(+)
         AND MPL_PRDCD = TPOD_PRDCD(+)
         AND MPL_PRDCD = PKM_PRDCD(+)
         AND PRD_KODEIGR = DIV_KODEIGR(+)
         AND PRD_KODEDIVISI = DIV_KODEDIVISI(+)
         AND PRD_KODEIGR = DEP_KODEIGR(+)
         AND PRD_KODEDIVISI = DEP_KODEDIVISI(+)
         AND PRD_KODEDEPARTEMENT = DEP_KODEDEPARTEMENT(+)
         AND PRD_KODEIGR = KAT_KODEIGR(+)
         AND PRD_KODEDEPARTEMENT = KAT_KODEDEPARTEMENT(+)
         AND PRD_KODEKATEGORIBARANG = KAT_KODEKATEGORI(+)
         AND TRANSLATE (MPL_KODEMONITORING, ' ', '_') = '".$kodemon."'
    ORDER BY PRD_KODEDIVISI, PRD_KODEDEPARTEMENT, PRD_KODEKATEGORIBARANG, PRD_DESKRIPSIPENDEK, MPL_PRDCD");

        $c = loginController::getConnectionProcedure();

        foreach($data as $d){
            $temp = DB::connection($_SESSION['connection'])->table('tbtr_konversiplu')
                ->select('kvp_pluold')
                ->where('kvp_kodetipe','=','M')
                ->where('kvp_plunew','=',$d->plu)
                ->first();

            $qtyb1 = 0;
            $qtyb2 = 0;
            $qtyb3 = 0;
            $harib1 = 0;
            $harib2 = 0;
            $harib3 = 0;

            if($temp){
                $v_pluold = $temp->kvp_pluold;

                $sql = "BEGIN SP_PKM_SALES ('".$_SESSION['kdigr']."',
                      ".DB::RAW("ADD_MONTHS(TRUNC(SYSDATE),-1)").",
                      ".DB::RAW("ADD_MONTHS(TRUNC(SYSDATE),-2)").",
                      ".DB::RAW("ADD_MONTHS(TRUNC(SYSDATE),-3)").",
                      '".$v_pluold."',
                      'Y',
                      :QTYB1,
                      :QTYB2,
                      :QTYB3,
                      :HARIB1,
                      :HARIB2,
                      :HARIB3,
                      :ERRM
                     ); END;";
                $s = oci_parse($c, $sql);

                oci_bind_by_name($s, ':QTYB1', $qtyb1,100);
                oci_bind_by_name($s, ':QTYB2', $qtyb2,100);
                oci_bind_by_name($s, ':QTYB3', $qtyb3,100);
                oci_bind_by_name($s, ':HARIB1', $harib1,100);
                oci_bind_by_name($s, ':HARIB2', $harib2,100);
                oci_bind_by_name($s, ':HARIB3', $harib3,100);
                oci_bind_by_name($s, ':ERRM', $errm,100);
                oci_execute($s);
            }

            $sql = "BEGIN SP_PKM_SALES ('".$_SESSION['kdigr']."',
                      ".DB::RAW("ADD_MONTHS(TRUNC(SYSDATE),-1)").",
                      ".DB::RAW("ADD_MONTHS(TRUNC(SYSDATE),-2)").",
                      ".DB::RAW("ADD_MONTHS(TRUNC(SYSDATE),-3)").",
                      '".$d->plu."',
                      'Y',
                      :QTY1,
                      :QTY2,
                      :QTY3,
                      :HARI1,
                      :HARI2,
                      :HARI3,
                      :ERRM
                     ); END;";
            $s = oci_parse($c, $sql);

            oci_bind_by_name($s, ':QTY1', $qty1,100);
            oci_bind_by_name($s, ':QTY2', $qty2,100);
            oci_bind_by_name($s, ':QTY3', $qty3,100);
            oci_bind_by_name($s, ':HARI1', $hari1,100);
            oci_bind_by_name($s, ':HARI2', $hari2,100);
            oci_bind_by_name($s, ':HARI3', $hari3,100);
            oci_bind_by_name($s, ':ERRM', $errm,100);
            oci_execute($s);

            $d->qty1 = $qty1 + $qtyb1;
            $d->qty2 = $qty2 + $qtyb2;
            $d->qty3 = $qty3 + $qtyb3;
            $d->hari1 = $hari1 + $harib1;
            $d->hari2 = $hari2 + $harib2;
            $d->hari3 = $hari3 + $harib3;

            $d->cp_sales1 = $d->qty3 / ($d->unit == 'KG' ? 1000 : 1);
            $d->cp_sales2 = $d->qty2 / ($d->unit == 'KG' ? 1000 : 1);
            $d->cp_sales3 = $d->qty1 / ($d->unit == 'KG' ? 1000 : 1);
            $d->cp_hari = $hari1 + $hari2 + $hari3;

            $d->cp_avgbulan = round(round(($qty1 + $qty2 + $qty3) / 3) / ($d->unit == 'KG' ? 100 : 1));

            if($d->cp_hari == 0)
                $d->cp_avghari = 0;
            else $d->cp_avghari = round(round(($qty1 + $qty2 + $qty3) / $d->cp_hari) / ($d->unit == 'KG' ? 1000 : 1));

//            dd($d);
        }

//        dd($data);

        $dompdf = new PDF();

        $pdf = PDF::loadview('BACKOFFICE.MONITORINGSTOKPARETO.montok-pdf',compact(['perusahaan','data']));

        error_reporting(E_ALL ^ E_DEPRECATED);

        $pdf->output();
        $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);

        $canvas = $dompdf ->get_canvas();
        $canvas->page_text(507, 80.75, "{PAGE_NUM} dari {PAGE_COUNT}", null, 7, array(0, 0, 0));

        $dompdf = $pdf;

        return $dompdf->stream('Monitoring Stok Item Pareto.pdf');
    }
}
