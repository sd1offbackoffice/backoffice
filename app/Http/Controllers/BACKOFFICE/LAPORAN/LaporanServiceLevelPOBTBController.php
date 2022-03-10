<?php

namespace App\Http\Controllers\BACKOFFICE\LAPORAN;

use App\Http\Controllers\Auth\loginController;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Mockery\Exception;
use PDF;
use Yajra\DataTables\DataTables;

class LaporanServiceLevelPOBTBController extends Controller
{
    public function index()
    {
        return view('BACKOFFICE.LAPORAN.laporan-service-level-po-btb');
    }

    public function getLovSupplier(Request $request)
    {
        $search = $request->search;

        $data = DB::connection(Session::get('connection'))->table('tbmaster_supplier')
            ->selectRaw("sup_kodesupplier,sup_namasupplier")
            ->whereRaw("sup_kodesupplier LIKE '%".$search."%' or sup_namasupplier LIKE '%".$search."%'")
            ->orderBy('sup_kodesupplier')
            ->limit(100)
            ->get();

        return DataTables::of($data)->make(true);
    }
    public function getLovMonitoring(Request $request)
    {
        $search = $request->search;

        $data = DB::connection(Session::get('connection'))->table('TBTR_MONITORINGSUPPLIER')
            ->selectRaw("msu_kodemonitoring,msu_namamonitoring")
            ->whereRaw("msu_kodemonitoring LIKE '%".$search."%' or msu_namamonitoring LIKE '%".$search."%'")
            ->orderBy('msu_kodemonitoring')
            ->limit(100)
            ->get();

        return DataTables::of($data)->make(true);
    }

    public function cetak(Request $request)
    {
        $tgl1 = $request->tanggal1;
        $tgl2 = $request->tanggal2;
        $supplier1 = $request->supplier1;
        $supplier2 = $request->supplier2;
        $mtr = $request->mtr;
        $namamtr = $request->namamtr;
        $rank = $request->rank;
        $menu = $request->menu;

        if($menu == 'rekap') {
            $p_and = '';
            $p_order = '';
            $subjudul_sort = '';

            if ($rank == '1') {
                $subjudul_sort = 'Ranking By Service Level Item';
                $p_order = ' Order By SLItem';
            } else if ($rank == '2') {
                $subjudul_sort = 'Ranking By Service Level Kuantum';
                $p_order = ' Order By SLQty';
            } else if ($rank == '3') {
                $subjudul_sort = 'Ranking By Service Level Nilai';
                $p_order = ' Order By SLNilai';
            } else if ($rank == '4') {
                $subjudul_sort = 'Ranking By Service Level Item Descending';
                $p_order = ' Order By SLItem Desc';
            } else if ($rank == '5') {
                $subjudul_sort = 'Ranking By Service Level Kuantum Descending';
                $p_order = ' Order By SLQty Desc';
            } else if ($rank == '6') {
                $subjudul_sort = 'Ranking By Service Level Nilai Descending';
                $p_order = ' Order By SLNilai Desc';
            }


            if ($supplier1 == '') {
                $supplier1 = '00000';
                $supplier2 = 'ZZZZZ';
            }
            $subjudul_mtrsup = 'Kode Supplier : ' . $supplier1 . ' - ' . $supplier2;
            $p_and = " AND TPOH_KODESUPPLIER BETWEEN '" . $supplier1 . "' AND '" . $supplier2 . "'";


            $data = DB::connection(Session::get('connection'))
                ->select("SELECT ROWNUM NOMOR, HASIL.*
  FROM (SELECT   PRS_NAMAPERUSAHAAN, PRS_NAMACABANG, PRS_NAMAWILAYAH, TPOH_KODESUPPLIER,
                 SUP_NAMASUPPLIER, ITEMPO, QTYPO, NILAIPO, ITEMBPBAK, ITEMBPBNA, QTYBPB, NILAIBPB,
                 NVL(ITEMOUT,0) ITEMOUT, NVL(QTYOUT,0) QTYOUT, NVL(NILAIOUT,0) NILAIOUT,  case when (ITEMPO - NVL(ITEMOUT,0) )  = 0 then 0 else ((ITEMBPBAK + ITEMBPBNA) / (ITEMPO - NVL(ITEMOUT,0) )) * 100 end SLITEM,
                 case when  (QTYPO - NVL(QTYOUT,0) )  = 0 then 0 else (QTYBPB / (QTYPO - NVL(QTYOUT,0) )) * 100 end SLQTY, case when (NILAIPO - NVL(NILAIOUT,0) )  = 0 then 0 else (NILAIBPB / (NILAIPO - NVL(NILAIOUT,0) )) * 100 end SLNILAI
            FROM (SELECT TPOH_KODESUPPLIER, ITEMPO, QTYPO, NILAIPO, ITEMBPBAK, ITEMBPBNA, QTYBPB,
                         NILAIBPB
                    FROM (SELECT   TPOH_KODESUPPLIER, SUM (ITEMPO) ITEMPO, SUM (TPOD_QTYPO) QTYPO,
                                   SUM (NILAIPO) NILAIPO, SUM (ITEMBPBAK) ITEMBPBAK,
                                   SUM (ITEMBPBNA) ITEMBPBNA, SUM (NVL (QTYBPB, 0)) QTYBPB,
                                   SUM (NVL (NILAIBPB, 0)) NILAIBPB
                              FROM (SELECT TPOH_KODESUPPLIER, 1 ITEMPO, (tpod_qtypo + nvl(tpod_bonuspo1, 0) + nvl(tpod_bonuspo2, 0))  TPOD_QTYPO,
                                           (TPOD_GROSS + TPOD_PPN + TPOD_PPNBM + TPOD_PPNBOTOL) NILAIPO,
                                           MSTD_KODESUPPLIER, PRD_KODETAG,
                                           CASE
                                               WHEN NVL (PRD_KODETAG, '9') NOT IN
                                                                         ('X', 'N', 'H')
                                                   THEN CASE
                                                           WHEN MSTD_KODESUPPLIER IS NOT NULL
                                                               THEN 1
                                                           ELSE 0
                                                       END
                                               ELSE 0
                                           END ITEMBPBAK,
                                           CASE
                                               WHEN NVL (PRD_KODETAG, '9') NOT IN
                                                                         ('X', 'N', 'H')
                                                   THEN 0
                                               ELSE CASE
                                               WHEN MSTD_KODESUPPLIER IS NOT NULL
                                                   THEN 1
                                               ELSE 0
                                           END
                                           END ITEMBPBNA,
                                           (MSTD_QTY + MSTD_QTYBONUS1 + MSTD_QTYBONUS2) QTYBPB,
                                           (MSTD_GROSS - MSTD_DISCRPH + MSTD_PPNBMRPH + MSTD_PPNBTLRPH + MSTD_PPNRPH
                                           ) NILAIBPB
                                      FROM TBTR_PO_H, TBTR_PO_D, TBMASTER_PRODMAST, TBTR_MSTRAN_D
                                     WHERE TRUNC (TPOH_TGLPO) BETWEEN to_date('" . $tgl1 . "','dd/mm/yyyy') AND to_date('" . $tgl2 . "','dd/mm/yyyy')
                                       " . $p_and . "
                                       AND NVL (TPOH_RECORDID, '0') <> '1'
                                       AND TPOD_NOPO = TPOH_NOPO
                                       AND PRD_PRDCD(+) = TPOD_PRDCD
                                       AND MSTD_NOPO(+) = TPOD_NOPO
                                       AND MSTD_PRDCD(+) = TPOD_PRDCD
                                       AND MSTD_TGLDOC(+) <= trunc(sysdate)
                                       AND MSTD_TYPETRN(+) = 'B'
                                       AND NVL(MSTD_RECORDID(+),'0') <> '1'
                                       ) A
                          GROUP BY TPOH_KODESUPPLIER) B) C,
                 (SELECT   TPOH_KODESUPPLIER SUPOUT, SUM (ITEMOUT) ITEMOUT, SUM (QTYOUT) QTYOUT,
                           SUM (NILAIOUT) NILAIOUT
                      FROM (SELECT TPOH_KODESUPPLIER, NVL(ITEMOUT,0) ITEMOUT, NVL(QTYOUT,0) QTYOUT, NVL(NILAIOUT,0) NILAIOUT
                              FROM (SELECT TPOH_KODESUPPLIER, MSTD_PRDCD, MSTD_TGLDOC, 1 ITEMOUT,
                                           (TPOD_QTYPO) QTYOUT,
                                           (TPOD_GROSS + TPOD_PPN + TPOD_PPNBM + TPOD_PPNBOTOL) NILAIOUT
                                      FROM TBTR_PO_H, TBTR_PO_D, TBTR_MSTRAN_D
                                     WHERE TRUNC (TPOH_TGLPO) BETWEEN to_date('" . $tgl1 . "','dd/mm/yyyy') AND to_date('" . $tgl2 . "','dd/mm/yyyy')
                                       " . $p_and . "
                                       AND NVL (TPOH_RECORDID, '0') NOT IN  ('1', '2')
                                       AND TPOH_TGLPO + TPOH_JWPB > sysdate
                                       AND TPOD_NOPO = TPOH_NOPO
                                       AND MSTD_NOPO(+) = TPOD_NOPO
                                       AND MSTD_PRDCD(+) = TPOD_PRDCD
                                       AND NVL(MSTD_RECORDID(+),'0') <> '1'  ) L
                             WHERE MSTD_PRDCD IS NULL OR MSTD_TGLDOC > sysdate) F
                  GROUP BY TPOH_KODESUPPLIER) G,
                 TBMASTER_SUPPLIER,
                 TBMASTER_PERUSAHAAN
           WHERE TPOH_KODESUPPLIER = SUPOUT(+)
             AND SUP_KODESUPPLIER = TPOH_KODESUPPLIER
             AND PRS_KODEIGR = '" . Session::get('kdigr') . "'
        " . $p_order . " ) HASIL");
        }
        else{
            $p_and = '';
            $p_order = '';
            $subjudul_sort = '';

            if ($rank == '1') {
                $subjudul_sort = 'Ranking By Service Level Item';
                $p_order = ' Order By SLItem';
            } else if ($rank == '2') {
                $subjudul_sort = 'Ranking By Service Level Kuantum';
                $p_order = ' Order By SLQty';
            } else if ($rank == '3') {
                $subjudul_sort = 'Ranking By Service Level Nilai';
                $p_order = ' Order By SLNilai';
            } else if ($rank == '4') {
                $subjudul_sort = 'Ranking By Service Level Item Descending';
                $p_order = ' Order By SLItem Desc';
            } else if ($rank == '5') {
                $subjudul_sort = 'Ranking By Service Level Kuantum Descending';
                $p_order = ' Order By SLQty Desc';
            } else if ($rank == '6') {
                $subjudul_sort = 'Ranking By Service Level Nilai Descending';
                $p_order = ' Order By SLNilai Desc';
            }


            if ($supplier1 == '') {
                $supplier1 = '00000';
                $supplier2 = 'ZZZZZ';
            }
            $subjudul_mtrsup = 'Kode Supplier : ' . $supplier1 . ' - ' . $supplier2;
            $p_and = " AND TPOH_KODESUPPLIER BETWEEN '" . $supplier1 . "' AND '" . $supplier2 . "'";


            $data = DB::connection(Session::get('connection'))
                ->select("SELECT ROWNUM NOMOR, HASIL.*
  FROM (SELECT   PRS_NAMAPERUSAHAAN, PRS_NAMACABANG, PRS_NAMAWILAYAH, TPOH_KODESUPPLIER,
                 SUP_NAMASUPPLIER || CASE WHEN NVL(SUP_SINGKATANSUPPLIER, 'AA') <> 'AA' THEN SUP_SINGKATANSUPPLIER ELSE '' END NAMASUP, TPOH_NOPO, TPOH_TGLPO,
                 ITEMPO, QTYPO, NILAIPO, ITEMBPBAK, ITEMBPBNA, QTYBPB, NILAIBPB,
                 NVL(ITEMOUT,0) ITEMOUT, NVL(QTYOUT,0) QTYOUT, NVL(NILAIOUT,0) NILAIOUT, case when (ITEMPO - NVL(ITEMOUT,0) ) = 0 then 0 else  ((ITEMBPBAK + ITEMBPBNA) / (ITEMPO - NVL(ITEMOUT,0) ))* 100 end SLITEM,
                 case when (QTYPO - NVL(QTYOUT,0) ) = 0 then 0 else (QTYBPB / (QTYPO - NVL(QTYOUT,0) ))* 100 end SLQTY,  case when (NILAIPO - NVL(NILAIOUT,0) ) = 0 then 0 else (NILAIBPB / (NILAIPO - NVL(NILAIOUT,0) ))* 100 end SLNILAI
            FROM (SELECT TPOH_KODESUPPLIER, TPOH_NOPO, TPOH_TGLPO, ITEMPO, QTYPO, NILAIPO, ITEMBPBAK, ITEMBPBNA, QTYBPB,
                         NILAIBPB
                    FROM (SELECT   TPOH_KODESUPPLIER, TPOH_NOPO, TPOH_TGLPO, SUM (ITEMPO) ITEMPO, SUM (TPOD_QTYPO) QTYPO,
                                   SUM (NILAIPO) NILAIPO, SUM (ITEMBPBAK) ITEMBPBAK,
                                   SUM (ITEMBPBNA) ITEMBPBNA, SUM (NVL (QTYBPB, 0)) QTYBPB,
                                   SUM (NVL (NILAIBPB, 0)) NILAIBPB
                              FROM (SELECT TPOH_KODESUPPLIER, TPOH_NOPO, TPOH_TGLPO, 1 ITEMPO, (tpod_qtypo + nvl(tpod_bonuspo1, 0) + nvl(tpod_bonuspo2, 0))  TPOD_QTYPO,
                                           (TPOD_GROSS + TPOD_PPN + TPOD_PPNBM + TPOD_PPNBOTOL) NILAIPO,
                                           MSTD_KODESUPPLIER, PRD_KODETAG,
                                           CASE
                                               WHEN NVL (PRD_KODETAG, '9') NOT IN
                                                                         ('X', 'N', 'H')
                                                   THEN CASE
                                                           WHEN MSTD_KODESUPPLIER IS NOT NULL
                                                               THEN 1
                                                           ELSE 0
                                                       END
                                               ELSE 0
                                           END ITEMBPBAK,
                                           CASE
                                               WHEN NVL (PRD_KODETAG, '9') NOT IN
                                                                         ('X', 'N', 'H')
                                                   THEN 0
                                               ELSE CASE
                                               WHEN MSTD_KODESUPPLIER IS NOT NULL
                                                   THEN 1
                                               ELSE 0
                                           END
                                           END ITEMBPBNA,
                                           (MSTD_QTY + MSTD_QTYBONUS1 + MSTD_QTYBONUS2) QTYBPB,
                                           (MSTD_GROSS - MSTD_DISCRPH + MSTD_PPNBMRPH + MSTD_PPNBTLRPH + MSTD_PPNRPH
                                           ) NILAIBPB
                                      FROM TBTR_PO_H, TBTR_PO_D, TBMASTER_PRODMAST, TBTR_MSTRAN_D
                                     WHERE TRUNC (TPOH_TGLPO) BETWEEN to_date('" . $tgl1 . "','dd/mm/yyyy') AND to_date('" . $tgl2 . "','dd/mm/yyyy')
                                       " . $p_and . "
                                       AND NVL (TPOH_RECORDID, '0') <> '1'
                                       AND TPOD_NOPO = TPOH_NOPO
                                       AND PRD_PRDCD(+) = TPOD_PRDCD
                                       AND MSTD_NOPO(+) = TPOD_NOPO
                                       AND MSTD_PRDCD(+) = TPOD_PRDCD
                                       AND MSTD_TGLDOC(+) <= trunc(sysdate)
                                       AND MSTD_TYPETRN(+) = 'B'
                                       AND NVL(MSTD_RECORDID(+),'0') <> '1'
                                       ) A
                          GROUP BY TPOH_KODESUPPLIER, TPOH_NOPO, TPOH_TGLPO) B) C,
                 (SELECT   TPOH_KODESUPPLIER SUPOUT, TPOH_NOPO NOPOOUT, TPOH_TGLPO TGLPOOUT, SUM (ITEMOUT) ITEMOUT, SUM (QTYOUT) QTYOUT,
                           SUM (NILAIOUT) NILAIOUT
                      FROM (SELECT TPOH_KODESUPPLIER, TPOH_NOPO, TPOH_TGLPO, NVL(ITEMOUT,0) ITEMOUT, NVL(QTYOUT,0) QTYOUT, NVL(NILAIOUT,0) NILAIOUT
                              FROM (SELECT TPOH_KODESUPPLIER, TPOH_NOPO, TRUNC(TPOH_TGLPO) TPOH_TGLPO, MSTD_PRDCD, MSTD_TGLDOC, 1 ITEMOUT,
                                           (TPOD_QTYPO) QTYOUT,
                                           (TPOD_GROSS + TPOD_PPN + TPOD_PPNBM + TPOD_PPNBOTOL) NILAIOUT
                                      FROM TBTR_PO_H, TBTR_PO_D, TBTR_MSTRAN_D
                                     WHERE TRUNC (TPOH_TGLPO) BETWEEN to_date('" . $tgl1 . "','dd/mm/yyyy') AND to_date('" . $tgl2 . "','dd/mm/yyyy')
                                       " . $p_and . "
                                       AND NVL (TPOH_RECORDID, '0') NOT IN ('1', '2')
                                       AND TPOH_TGLPO + TPOH_JWPB > sysdate
                                       AND TPOD_NOPO = TPOH_NOPO
                                       AND MSTD_NOPO(+) = TPOD_NOPO
                                       AND MSTD_PRDCD(+) = TPOD_PRDCD
                                       AND NVL(MSTD_RECORDID(+),'0') <> '1'  ) L
                             WHERE MSTD_PRDCD IS NULL OR MSTD_TGLDOC > sysdate) F
                  GROUP BY TPOH_KODESUPPLIER, TPOH_NOPO, TPOH_TGLPO) G,
                 TBMASTER_PERUSAHAAN, TBMASTER_SUPPLIER
           WHERE TPOH_KODESUPPLIER = SUPOUT(+)
             AND TPOH_NOPO = NOPOOUT(+)
             AND TPOH_TGLPO = TGLPOOUT(+)
             AND PRS_KODEIGR = '" . Session::get('kdigr') . "'
             AND SUP_KODESUPPLIER = TPOH_KODESUPPLIER
        Order by TPOH_KODESUPPLIER, TPOH_TGLPO, TPOH_NOPO) HASIL");
        }
        $perusahaan = DB::connection(Session::get('connection'))->table('tbmaster_perusahaan')->first();

        return view('BACKOFFICE.LAPORAN.laporan-service-level-po-btb-'.$menu.'-pdf', compact(['perusahaan', 'data', 'tgl1', 'tgl2','subjudul_sort','subjudul_mtrsup']));
    }
}
