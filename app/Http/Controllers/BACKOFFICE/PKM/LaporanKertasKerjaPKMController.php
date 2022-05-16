<?php

namespace App\Http\Controllers\BACKOFFICE\PKM;

use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;
use PDF;
use Yajra\DataTables\DataTables;
use ZipArchive;
use File;

class LaporanKertasKerjaPKMController extends Controller
{
    public function index()
    {
        return view('BACKOFFICE.PKM.laporan-kertas-kerja-pkm');
    }

    public function getLovPLU(Request $request)
    {
        $plu = $request->plu;
        $and_plu = '';
        if($plu != ''){
            $and_plu = " and prd_prdcd >= '".$plu."'";
        }
        $data = DB::connection(Session::get('connection'))
            ->select("select prd_deskripsipanjang desk, prd_prdcd plu, prd_unit || '/' || prd_frac konversi, prd_hrgjual from tbmaster_prodmast
            where prd_kodeigr = '" . Session::get('kdigr') . "'
            ".$and_plu."
            and substr(prd_Prdcd,7,1) = '0'
            order by prd_prdcd,prd_deskripsipanjang");

        return DataTables::of($data)->make(true);
    }

    public function getLovDivisi(Request $request)
    {
        $value = $request->div ;
        $and_div = '';
        if($value != ''){
            $and_div = " and div_kodedivisi >= '".$value."'";
        }
        $data = DB::connection(Session::get('connection'))->select("SELECT div_namadivisi, div_kodedivisi
                FROM TBMASTER_DIVISI
                WHERE div_kodeigr ='" . Session::get('kdigr') . "'
                ".$and_div."
                order by div_kodedivisi");

        return DataTables::of($data)->make(true);
    }

    public function getLovDepartement(Request $request)
    {
        $dep = $request->dep ;
        $div1 = $request->div1;
        $div2 = $request->div2;
        $and_dep = '';
        $and_div = '';
        if($dep != ''){
            $and_dep = " and dep_kodedepartement >= '".$dep."'";
        }
        if($div1 != ''){
            $and_div = " and dep_kodedivisi >= '".$div1."' and dep_kodedivisi <= '".$div2."'" ;
        }
        $data = DB::connection(Session::get('connection'))->select("SELECT distinct dep_namadepartement, dep_kodedepartement, dep_kodedivisi
                FROM TBMASTER_DEPARTEMENT
                WHERE dep_kodeigr ='" . Session::get('kdigr') . "'
                ".$and_dep."
                ".$and_div."
                order by dep_kodedepartement");

        return DataTables::of($data)->make(true);
    }

    public function getLovKategori(Request $request)
    {
        $kat = $request->kat;
        $dep1 = $request->dep1;
        $dep2 = $request->dep2;
        $and_dep = '';
        $and_kat = '';
        if($kat != ''){
            $and_kat = " and kat_kodekategori >= '".$kat."'";
        }
        if($dep1 != ''){
            $and_dep = " and kat_kodedepartement >= '".$dep1 ."' and kat_kodedepartement <= '".$dep2."'" ;
        }
        $data = DB::connection(Session::get('connection'))->select("SELECT distinct kat_namakategori, kat_kodekategori, kat_kodedepartement
                FROM TBMASTER_KATEGORI
                WHERE kat_kodeigr ='" . Session::get('kdigr') . "'
                ".$and_kat."
                ".$and_dep."
                order by kat_kodedepartement,kat_kodekategori");

        return DataTables::of($data)->make(true);
    }

    public function getLovMonitoring()
    {
        $data = DB::connection(Session::get('connection'))->select("SELECT DISTINCT mpl_namamonitoring, mpl_kodemonitoring
                FROM TBTR_MONITORINGPLU
                WHERE mpl_kodeigr = '" . Session::get('kdigr') . "'
                ORDER BY mpl_namamonitoring");

        return DataTables::of($data)->make(true);
    }

    public function getLovSupplier(Request $request)
    {
        $sup = $request->sup;
        $and_sup='';
        if($sup != ''){
            $and_sup = " and SUP_KODESUPPLIER >= '".$sup ."'";
        }
        $data = DB::connection(Session::get('connection'))->select("SELECT SUP_KODESUPPLIER KODE, SUP_NAMASUPPLIER
                FROM TBMASTER_SUPPLIER
                WHERE SUP_KODEIGR = '" . Session::get('kdigr') . "'
                ".$and_sup."
                ORDER BY SUP_KODESUPPLIER");

        return DataTables::of($data)->make(true);
    }

    public function getLovTag()
    {
        $data = DB::connection(Session::get('connection'))->select("SELECT TAG_KODETAG TAG, TAG_KETERANGAN KETERANGAN, TAG_TIDAKBOLEHORDER TIDAK_ORDER,
         TAG_TIDAKBOLEHJUAL TIDAK_JUAL
            FROM TBMASTER_TAG
        ORDER BY TAG_KODETAG");

        return DataTables::of($data)->make(true);
    }

    public function cetak(Request $request)
    {
        $div1 = $request->div1;
        $dep1 = $request->dep1;
        $kat1 = $request->kat1;
        $plu1 = $request->plu1;
        $sup1 = $request->sup1;
        $div2 = $request->div2;
        $dep2 = $request->dep2;
        $kat2 = $request->kat2;
        $plu2 = $request->plu2;
        $sup2 = $request->sup2;
        $mtr = $request->mtr;
        $nmmtr = $request->nmmtr;
        $tag = $request->tag;
        $tag1 = $request->tag1;
        $tag2 = $request->tag2;
        $tag3 = $request->tag3;
        $tag4 = $request->tag4;
        $tag5 = $request->tag5;
        $urut = $request->urut;
        $item = $request->item;

        $ket_monitoring = '';
        $monitoringplu = '';
        $pilih = '';
        $jenispkm = '';
        $filename = '';
        $ket_jenispkm = '';

        if ($mtr <> '') {
            $monitoringplu = "AND mpl_kodemonitoring = '" . $mtr . "' AND mpl_namamonitoring = '" . $nmmtr . "'";
            $ket_monitoring = "Kode Monitoring PLU : " . $mtr . " - " . $nmmtr;
        } else {
            $ket_monitoring = '';
        }


        $supplier = " AND pkm_kodesupplier BETWEEN NVL ('" . $sup1 . "', '0000000') AND NVL ('" . $sup2 . "', 'ZZZZZZ') ";

        if ($tag == 'P') {
            $pilih = " AND prd_kodetag in ('" . $tag1 . "','" . $tag2 . "','" . $tag3 . "','" . $tag4 . "','" . $tag5 . "')";
        }

        if ($item == '1') {
            $jenispkm = 'AND exists (select prc_pluigr from tbmaster_prodcrm where prc_pluigr=pkm_prdcd)';
            $ket_jenispkm = 'PKM item OMI/IDM';
        } else {
            $ket_jenispkm = 'PKM item Nasional';
        }

        $P_FMPRDT = DB::connection(Session::get('connection'))
            ->table("TBMASTER_PERUSAHAAN")
            ->selectRaw("to_char(PRS_PERIODETERAKHIR,'dd/mm/yyyy') prs_periodeterakhir")->pluck('prs_periodeterakhir')->first();
        if ($urut == '1') {
            $filename = 'div';
            $data = DB::connection(Session::get('connection'))
                ->select("SELECT DISTINCT PRS_NAMAPERUSAHAAN, PRS_NAMACABANG, PRS_NAMAWILAYAH, PKM_KODEDIVISI FTKDIV,
                PKM_KODEDEPARTEMENT FTDEPT,
                SUBSTR (PKM_PERIODEPROSES, 3, 4) || SUBSTR (PKM_PERIODEPROSES, 1, 2) FTPRDE,
                PKM_KODEKATEGORIBARANG FTKATB, PKM_PRDCD FTKPLU, PKM_KODESUPPLIER FTKSUP,
                PKM_MINDISPLAY FTMIND, PKM_PERIODE1 FTPR01, PKM_PERIODE2 FTPR02,
                PKM_PERIODE3 FTPR03, PKM_QTY1 FTNL01, PKM_QTY2 FTNL02, PKM_QTY3 FTNL03,
                CASE
                    WHEN PRD_MINORDER = 0
                        THEN PRD_ISIBELI
                    ELSE PRD_MINORDER
                END MORD, ROUND (PKM_QTYAVERAGE, 1) FTAVGS,
                NVL (SUP_JANGKAWAKTUKIRIMBARANG, PKM_LEADTIME) FTLTIM, PKM_KOEFISIEN KOEF,
                NVL (SUP_JANGKAWAKTUKIRIMBARANG, PKM_LEADTIME) * PKM_KOEFISIEN HS, PKM_STOCK FTSSTK,
                PKM_LEADTIME + PKM_STOCK LTSS, PKM_PKM FTPKMM, PKM_MPKM FTMPKM, PKM_PKMT FTPKMT,
                PKM_PKMB FTPKMB, CASE
                    WHEN OK = 'OK'
                        THEN GDL_QTY                                    /*PKMG_NILAIGONDOLA*/
                    ELSE 0
                END NPLUS,
                PKM_PKMT + CASE
                    WHEN OK = 'OK'
                        THEN GDL_QTY                                 /*PKMG_NILAIGONDOLA*/
                    ELSE 0
                END PKMEXIST,

                -------
                CASE
                    WHEN ROUND (PKM_QTYAVERAGE, 1) = 0
                        THEN PKM_PKMT + CASE
                                 WHEN OK = 'OK'
                                     THEN GDL_QTY                         /*PKMG_NILAIGONDOLA*/
                                 ELSE 0
                             END
                    ELSE ROUND (  (PKM_PKMT
                                   + CASE
                                       WHEN OK = 'OK'
                                           THEN GDL_QTY                        /*PKMG_NILAIGONDOLA*/
                                       ELSE 0
                                   END
                                  )
                                / ROUND (PKM_QTYAVERAGE, 1),
                                0
                               )
                END DSI,
                CASE
                    WHEN HGB_TOP = 0
                        THEN SUP_TOP
                    ELSE HGB_TOP
                END TOP, PRD_DESKRIPSIPANJANG, PRD_UNIT || '/'
                                               || LPAD (PRD_FRAC, 4, ' ') PRD_SATUAN, PRD_KODETAG,
                DIV_NAMADIVISI, DEP_NAMADEPARTEMENT, KAT_NAMAKATEGORI,
                CASE
                    WHEN PKM_PRDCD IN (SELECT PRC_PLUIGR
                                         FROM TBMASTER_PRODCRM)
                        THEN '*'
                END OMI, SL
           FROM TBMASTER_KKPKM,
                TBMASTER_PRODMAST,
                TBMASTER_PERUSAHAAN,
                TBMASTER_DIVISI,
                TBMASTER_DEPARTEMENT,
                TBMASTER_KATEGORI,
                TBMASTER_SUPPLIER,
                TBTR_MONITORINGPLU,
                TBTR_SALESBULANAN,
                (SELECT HGB_PRDCD, HGB_KODESUPPLIER, HGB_TOP
                   FROM TBMASTER_HARGABELI
                  WHERE HGB_TIPE = '2'),
                (SELECT PKMG_PRDCD, PKMG_NILAIGONDOLA
                   FROM TBTR_PKMGONDOLA
                  WHERE PKMG_PRDCD || TO_CHAR (PKMG_CREATE_DT, 'ddmmyy') IN (
                                               SELECT PLU || TO_CHAR (TGL, 'ddmmyy')
                                                 FROM (SELECT   PKMG_PRDCD PLU,
                                                                MAX (PKMG_CREATE_DT) TGL
                                                           FROM TBTR_PKMGONDOLA
                                                       GROUP BY PKMG_PRDCD))),
                (SELECT DISTINCT GDL_PRDCD, 'OK' OK, GDL_QTY
                            FROM TBTR_GONDOLA
                           WHERE to_date('" . $P_FMPRDT . "','dd/mm/yyyy') >= GDL_TGLAWAL - 2 AND to_date('" . $P_FMPRDT . "','dd/mm/yyyy') <= GDL_TGLAKHIR + 2),
                (SELECT TPOD_PRDCD,
                        CASE
                            WHEN QTYPO <> 0 AND KUANB <> 0
                                THEN ROUND (KUANB / QTYPO * 100)
                            ELSE 0
                        END SL
                   FROM (SELECT   TPOD_PRDCD, SUM (TPOD_QTYPO) QTYPO, SUM (KUANB) KUANB,
                                  SUM (KUANA) KUANA
                             FROM (SELECT TPOD_PRDCD, TPOD_QTYPO,
                                          (  NVL (MSTD_QTY, 0)
                                           + NVL (MSTD_QTYBONUS1, 0)
                                           + NVL (MSTD_QTYBONUS2, 0)
                                          ) KUANB,
                                          NVL (MSTD_QTY, 0) KUANA
                                     FROM TBTR_PO_D, TBTR_MSTRAN_D, TBMASTER_PRODMAST
                                    WHERE TPOD_KODEIGR =  '" . Session::get('kdigr') . "'
                                      AND NVL (TPOD_RECORDID, '9') <> '1'
                                      AND TRUNC (TPOD_TGLPO) BETWEEN TRUNC (ADD_MONTHS (SYSDATE, -3),
                                                                            'MM'
                                                                           )
                                                                 AND LAST_DAY
                                                                        (TRUNC (ADD_MONTHS (SYSDATE,
                                                                                            -1
                                                                                           )
                                                                               )
                                                                        )
                                      AND MSTD_TYPETRN(+) = 'B'
                                      AND MSTD_KODEIGR(+) = TPOD_KODEIGR
                                      AND NVL (MSTD_RECORDID(+), '9') <> '1'
                                      AND MSTD_PRDCD(+) = TPOD_PRDCD
                                      AND MSTD_NOPO(+) = TPOD_NOPO
                                      AND MSTD_TGLPO(+) = TPOD_TGLPO
                                      AND PRD_KODEIGR(+) = TPOD_KODEIGR
                                      AND NVL (PRD_RECORDID(+), '9') <> '1'
                                      AND PRD_PRDCD(+) = TPOD_PRDCD)
                         GROUP BY TPOD_PRDCD))
          WHERE PKM_KODEIGR = PRS_KODEIGR
            AND PRS_KODEIGR = '" . Session::get('kdigr') . "'
            AND PKM_KODEIGR = PRD_KODEIGR(+)
            AND PKM_PRDCD = PRD_PRDCD(+)
            AND PKM_KODEDIVISI = DIV_KODEDIVISI(+)
            AND PKM_KODEDEPARTEMENT = DEP_KODEDEPARTEMENT(+)
            AND PKM_KODEDIVISI = DEP_KODEDIVISI(+)
            AND PKM_KODEKATEGORIBARANG = KAT_KODEKATEGORI(+)
            AND PKM_KODEDEPARTEMENT = KAT_KODEDEPARTEMENT(+)
            AND HGB_KODESUPPLIER = SUP_KODESUPPLIER(+)
            AND PKM_PRDCD = MPL_PRDCD(+)
            AND PKM_KODEIGR = MPL_KODEIGR(+)
            AND PRD_PRDCD = SLS_PRDCD(+)
            AND SLS_PRDCD = HGB_PRDCD(+)
            AND PKM_PRDCD = PKMG_PRDCD(+)
            AND PKM_PRDCD = GDL_PRDCD(+)
            AND PKM_PRDCD = TPOD_PRDCD(+)
            AND PKM_KODEDIVISI BETWEEN NVL ('" . $div1 . "', '0') AND NVL ('" . $div2 . "', 'Z')
            AND PKM_KODEDEPARTEMENT BETWEEN NVL ('" . $dep1 . "', '00') AND NVL ('" . $dep2 . "', 'ZZ')
            AND PKM_KODEKATEGORIBARANG BETWEEN NVL ('" . $kat1 . "', '00') AND NVL ('" . $kat2 . "', 'ZZ')
            AND PKM_PRDCD BETWEEN NVL ('" . $plu1 . "', '0000000') AND NVL ('" . $plu2 . "', 'ZZZZZZZ')
            " . $monitoringplu . "
            " . $supplier . "
            " . $pilih . "
            " . $jenispkm . "
ORDER BY        FTPRDE,FTKDIV, FTDEPT, FTKATB");


        }
        else if ($urut == '2') {
            $filename = 'plu';
            $data = DB::connection(Session::get('connection'))
                ->select("SELECT DISTINCT PRS_NAMAPERUSAHAAN, PRS_NAMACABANG, PRS_NAMAWILAYAH, PKM_KODEDIVISI FTKDIV,
                                PKM_KODEDEPARTEMENT FTDEPT,
                                SUBSTR (PKM_PERIODEPROSES, 3, 4) || SUBSTR (PKM_PERIODEPROSES, 1, 2) FTPRDE,
                                PKM_KODEKATEGORIBARANG FTKATB, PKM_PRDCD FTKPLU, PKM_KODESUPPLIER FTKSUP,
                                PKM_MINDISPLAY FTMIND, PKM_PERIODE1 FTPR01, PKM_PERIODE2 FTPR02,
                                PKM_PERIODE3 FTPR03, PKM_QTY1 FTNL01, PKM_QTY2 FTNL02, PKM_QTY3 FTNL03,
                                CASE
                                    WHEN PRD_MINORDER = 0
                                        THEN PRD_ISIBELI
                                    ELSE PRD_MINORDER
                                END MORD, ROUND (PKM_QTYAVERAGE, 1) FTAVGS,
                                NVL (SUP_JANGKAWAKTUKIRIMBARANG, PKM_LEADTIME) FTLTIM, PKM_KOEFISIEN KOEF,
                                NVL (SUP_JANGKAWAKTUKIRIMBARANG, PKM_LEADTIME) * PKM_KOEFISIEN HS, PKM_STOCK FTSSTK,
                                PKM_LEADTIME + PKM_STOCK LTSS, PKM_PKM FTPKMM, PKM_MPKM FTMPKM, PKM_PKMT FTPKMT,
                                PKM_PKMB FTPKMB, CASE
                                    WHEN OK = 'OK'
                                        THEN GDL_QTY                                    /*PKMG_NILAIGONDOLA*/
                                    ELSE 0
                                END NPLUS,
                                PKM_PKMT + CASE
                                    WHEN OK = 'OK'
                                        THEN GDL_QTY                                 /*PKMG_NILAIGONDOLA*/
                                    ELSE 0
                                END PKMEXIST,
                                CASE
                                    WHEN ROUND (PKM_QTYAVERAGE, 1) = 0
                                        THEN PKM_PKMT + CASE
                                                 WHEN OK = 'OK'
                                                     THEN GDL_QTY                         /*PKMG_NILAIGONDOLA*/
                                                 ELSE 0
                                             END
                                    ELSE ROUND (  (PKM_PKMT
                                                   + CASE
                                                       WHEN OK = 'OK'
                                                           THEN GDL_QTY                        /*PKMG_NILAIGONDOLA*/
                                                       ELSE 0
                                                   END
                                                  )
                                                / ROUND (PKM_QTYAVERAGE, 1),
                                                0
                                               )
                                END DSI,
                                CASE
                                    WHEN HGB_TOP = 0
                                        THEN SUP_TOP
                                    ELSE HGB_TOP
                                END TOP, PRD_DESKRIPSIPANJANG, PRD_UNIT || '/'
                                                               || LPAD (PRD_FRAC, 4, ' ') PRD_SATUAN, PRD_KODETAG,
                                DIV_NAMADIVISI, DEP_NAMADEPARTEMENT, KAT_NAMAKATEGORI,
                                CASE
                                    WHEN PKM_PRDCD IN (SELECT PRC_PLUIGR
                                                         FROM TBMASTER_PRODCRM)
                                        THEN '*'
                                END OMI, SL
                           FROM TBMASTER_KKPKM,
                                TBMASTER_PRODMAST,
                                TBMASTER_PERUSAHAAN,
                                TBMASTER_DIVISI,
                                TBMASTER_DEPARTEMENT,
                                TBMASTER_KATEGORI,
                                TBMASTER_SUPPLIER,
                                TBTR_MONITORINGPLU,
                                TBTR_SALESBULANAN,
                                (SELECT HGB_PRDCD, HGB_KODESUPPLIER, HGB_TOP
                                   FROM TBMASTER_HARGABELI
                                  WHERE HGB_TIPE = '2'),
                                (SELECT PKMG_PRDCD, PKMG_NILAIGONDOLA
                                   FROM TBTR_PKMGONDOLA
                                  WHERE PKMG_PRDCD || TO_CHAR (PKMG_CREATE_DT, 'ddmmyy') IN (
                                                               SELECT PLU || TO_CHAR (TGL, 'ddmmyy')
                                                                 FROM (SELECT   PKMG_PRDCD PLU,
                                                                                MAX (PKMG_CREATE_DT) TGL
                                                                           FROM TBTR_PKMGONDOLA
                                                                       GROUP BY PKMG_PRDCD))),
                                (SELECT DISTINCT GDL_PRDCD, 'OK' OK, GDL_QTY
                                            FROM TBTR_GONDOLA
                                           WHERE to_date('" . $P_FMPRDT . "','dd/mm/yyyy') >= GDL_TGLAWAL - 2 AND to_date('" . $P_FMPRDT . "','dd/mm/yyyy') <= GDL_TGLAKHIR + 2),
                                (SELECT TPOD_PRDCD,
                                        CASE
                                            WHEN QTYPO <> 0 AND KUANB <> 0
                                                THEN ROUND (KUANB / QTYPO * 100)
                                            ELSE 0
                                        END SL
                                   FROM (SELECT   TPOD_PRDCD, SUM (TPOD_QTYPO) QTYPO, SUM (KUANB) KUANB,
                                                  SUM (KUANA) KUANA
                                             FROM (SELECT TPOD_PRDCD, TPOD_QTYPO,
                                                          (  NVL (MSTD_QTY, 0)
                                                           + NVL (MSTD_QTYBONUS1, 0)
                                                           + NVL (MSTD_QTYBONUS2, 0)
                                                          ) KUANB,
                                                          NVL (MSTD_QTY, 0) KUANA
                                                     FROM TBTR_PO_D, TBTR_MSTRAN_D, TBMASTER_PRODMAST
                                                    WHERE TPOD_KODEIGR = '" . Session::get('kdigr') . "'
                                                      AND NVL (TPOD_RECORDID, '9') <> '1'
                                                      AND TRUNC (TPOD_TGLPO) BETWEEN TRUNC (ADD_MONTHS (SYSDATE, -3),
                                                                                            'MM'
                                                                                           )
                                                                                 AND LAST_DAY
                                                                                        (TRUNC (ADD_MONTHS (SYSDATE,
                                                                                                            -1
                                                                                                           )
                                                                                               )
                                                                                        )
                                                      AND MSTD_TYPETRN(+) = 'B'
                                                      AND MSTD_KODEIGR(+) = TPOD_KODEIGR
                                                      AND NVL (MSTD_RECORDID(+), '9') <> '1'
                                                      AND MSTD_PRDCD(+) = TPOD_PRDCD
                                                      AND MSTD_NOPO(+) = TPOD_NOPO
                                                      AND MSTD_TGLPO(+) = TPOD_TGLPO
                                                      AND PRD_KODEIGR(+) = TPOD_KODEIGR
                                                      AND NVL (PRD_RECORDID(+), '9') <> '1'
                                                      AND PRD_PRDCD(+) = TPOD_PRDCD)
                                         GROUP BY TPOD_PRDCD))
                          WHERE PKM_KODEIGR = PRS_KODEIGR
                            AND PRS_KODEIGR = '" . Session::get('kdigr') . "'
                            AND PKM_KODEIGR = PRD_KODEIGR(+)
                            AND PKM_PRDCD = PRD_PRDCD(+)
                            AND PKM_KODEDIVISI = DIV_KODEDIVISI(+)
                            AND PKM_KODEDEPARTEMENT = DEP_KODEDEPARTEMENT(+)
                            AND PKM_KODEDIVISI = DEP_KODEDIVISI(+)
                            AND PKM_KODEKATEGORIBARANG = KAT_KODEKATEGORI(+)
                            AND PKM_KODEDEPARTEMENT = KAT_KODEDEPARTEMENT(+)
                            AND HGB_KODESUPPLIER = SUP_KODESUPPLIER(+)
                            AND PKM_PRDCD = MPL_PRDCD(+)
                            AND PKM_KODEIGR = MPL_KODEIGR(+)
                            AND PRD_PRDCD = SLS_PRDCD(+)
                            AND SLS_PRDCD = HGB_PRDCD(+)
                            AND PKM_PRDCD = PKMG_PRDCD(+)
                            AND PKM_PRDCD = GDL_PRDCD(+)
                            AND PKM_PRDCD = TPOD_PRDCD(+)
                            AND PKM_KODEDIVISI BETWEEN NVL ('" . $div1 . "', '0') AND NVL ('" . $div2 . "', 'Z')
                            AND PKM_KODEDEPARTEMENT BETWEEN NVL ('" . $dep1 . "', '00') AND NVL ('" . $dep2 . "', 'ZZ')
                            AND PKM_KODEKATEGORIBARANG BETWEEN NVL ('" . $kat1 . "', '00') AND NVL ('" . $kat2 . "', 'ZZ')
                            AND PKM_PRDCD BETWEEN NVL ('" . $plu1 . "', '0000000') AND NVL ('" . $plu2 . "', 'ZZZZZZZ')
                            " . $monitoringplu . "
                            " . $supplier . "
                            " . $pilih . "
                            " . $jenispkm . "
                ORDER BY        FTPRDE,PKM_PRDCD");

        }
        else if ($urut == '3') {
            $filename = 'sup';
            $data = DB::connection(Session::get('connection'))
                ->select("SELECT DISTINCT PRS_NAMAPERUSAHAAN, PRS_NAMACABANG, PRS_NAMAWILAYAH, PKM_KODEDIVISI FTKDIV,
                PKM_KODEDEPARTEMENT FTDEPT,
                SUBSTR (PKM_PERIODEPROSES, 3, 4) || SUBSTR (PKM_PERIODEPROSES, 1, 2) FTPRDE,
                PKM_KODEKATEGORIBARANG FTKATB, PKM_PRDCD FTKPLU, PKM_KODESUPPLIER FTKSUP,
                PKM_MINDISPLAY FTMIND, PKM_PERIODE1 FTPR01, PKM_PERIODE2 FTPR02,
                PKM_PERIODE3 FTPR03, PKM_QTY1 FTNL01, PKM_QTY2 FTNL02, PKM_QTY3 FTNL03,
                CASE
                    WHEN PRD_MINORDER = 0
                        THEN PRD_ISIBELI
                    ELSE PRD_MINORDER
                END MORD, ROUND (PKM_QTYAVERAGE, 1) FTAVGS,
                NVL (SUP_JANGKAWAKTUKIRIMBARANG, PKM_LEADTIME) FTLTIM, PKM_KOEFISIEN KOEF,
                NVL (SUP_JANGKAWAKTUKIRIMBARANG, PKM_LEADTIME) * PKM_KOEFISIEN HS, PKM_STOCK FTSSTK,
                PKM_LEADTIME + PKM_STOCK LTSS, PKM_PKM FTPKMM, PKM_MPKM FTMPKM, PKM_PKMT FTPKMT,
                PKM_PKMB FTPKMB, CASE
                    WHEN OK = 'OK'
                        THEN GDL_QTY                                    /*PKMG_NILAIGONDOLA*/
                    ELSE 0
                END NPLUS,
                PKM_PKMT + CASE
                    WHEN OK = 'OK'
                        THEN GDL_QTY                                 /*PKMG_NILAIGONDOLA*/
                    ELSE 0
                END PKMEXIST,
                CASE
                    WHEN ROUND (PKM_QTYAVERAGE, 1) = 0
                        THEN PKM_PKMT + CASE
                                 WHEN OK = 'OK'
                                     THEN GDL_QTY                         /*PKMG_NILAIGONDOLA*/
                                 ELSE 0
                             END
                    ELSE ROUND (  (PKM_PKMT
                                   + CASE
                                       WHEN OK = 'OK'
                                           THEN GDL_QTY                        /*PKMG_NILAIGONDOLA*/
                                       ELSE 0
                                   END
                                  )
                                / ROUND (PKM_QTYAVERAGE, 1),
                                0
                               )
                END DSI,
                CASE
                    WHEN HGB_TOP = 0
                        THEN SUP_TOP
                    ELSE HGB_TOP
                END TOP, PRD_DESKRIPSIPANJANG, PRD_UNIT || '/'
                                               || LPAD (PRD_FRAC, 4, ' ') PRD_SATUAN, PRD_KODETAG,
                DIV_NAMADIVISI, DEP_NAMADEPARTEMENT, KAT_NAMAKATEGORI,
                CASE
                    WHEN PKM_PRDCD IN (SELECT PRC_PLUIGR
                                         FROM TBMASTER_PRODCRM)
                        THEN '*'
                END OMI, SL, SUP_NAMASUPPLIER, SUP_SINGKATANSUPPLIER
           FROM TBMASTER_KKPKM,
                TBMASTER_PRODMAST,
                TBMASTER_PERUSAHAAN,
                TBMASTER_DIVISI,
                TBMASTER_DEPARTEMENT,
                TBMASTER_KATEGORI,
                TBMASTER_SUPPLIER,
                TBTR_MONITORINGPLU,
                TBTR_SALESBULANAN,
                (SELECT HGB_PRDCD, HGB_KODESUPPLIER, HGB_TOP
                   FROM TBMASTER_HARGABELI
                  WHERE HGB_TIPE = '2'),
                (SELECT PKMG_PRDCD, PKMG_NILAIGONDOLA
                   FROM TBTR_PKMGONDOLA
                  WHERE PKMG_PRDCD || TO_CHAR (PKMG_CREATE_DT, 'ddmmyy') IN (
                                               SELECT PLU || TO_CHAR (TGL, 'ddmmyy')
                                                 FROM (SELECT   PKMG_PRDCD PLU,
                                                                MAX (PKMG_CREATE_DT) TGL
                                                           FROM TBTR_PKMGONDOLA
                                                       GROUP BY PKMG_PRDCD))),
                (SELECT DISTINCT GDL_PRDCD, 'OK' OK, GDL_QTY
                            FROM TBTR_GONDOLA
                           WHERE to_date('" . $P_FMPRDT . "','dd/mm/yyyy') >= GDL_TGLAWAL - 2 AND to_date('" . $P_FMPRDT . "','dd/mm/yyyy') <= GDL_TGLAKHIR + 2),
                (SELECT TPOD_PRDCD,
                        CASE
                            WHEN QTYPO <> 0 AND KUANB <> 0
                                THEN ROUND (KUANB / QTYPO * 100)
                            ELSE 0
                        END SL
                   FROM (SELECT   TPOD_PRDCD, SUM (TPOD_QTYPO) QTYPO, SUM (KUANB) KUANB,
                                  SUM (KUANA) KUANA
                             FROM (SELECT TPOD_PRDCD, TPOD_QTYPO,
                                          (  NVL (MSTD_QTY, 0)
                                           + NVL (MSTD_QTYBONUS1, 0)
                                           + NVL (MSTD_QTYBONUS2, 0)
                                          ) KUANB,
                                          NVL (MSTD_QTY, 0) KUANA
                                     FROM TBTR_PO_D, TBTR_MSTRAN_D, TBMASTER_PRODMAST
                                    WHERE TPOD_KODEIGR = '" . Session::get('kdigr') . "'
                                      AND NVL (TPOD_RECORDID, '9') <> '1'
                                      AND TRUNC (TPOD_TGLPO) BETWEEN TRUNC (ADD_MONTHS (SYSDATE, -3),
                                                                            'MM'
                                                                           )
                                                                 AND LAST_DAY
                                                                        (TRUNC (ADD_MONTHS (SYSDATE,
                                                                                            -1
                                                                                           )
                                                                               )
                                                                        )
                                      AND MSTD_TYPETRN(+) = 'B'
                                      AND MSTD_KODEIGR(+) = TPOD_KODEIGR
                                      AND NVL (MSTD_RECORDID(+), '9') <> '1'
                                      AND MSTD_PRDCD(+) = TPOD_PRDCD
                                      AND MSTD_NOPO(+) = TPOD_NOPO
                                      AND MSTD_TGLPO(+) = TPOD_TGLPO
                                      AND PRD_KODEIGR(+) = TPOD_KODEIGR
                                      AND NVL (PRD_RECORDID(+), '9') <> '1'
                                      AND PRD_PRDCD(+) = TPOD_PRDCD)
                         GROUP BY TPOD_PRDCD))
          WHERE PKM_KODEIGR = PRS_KODEIGR
            AND PRS_KODEIGR = '" . Session::get('kdigr') . "'
            AND PKM_KODEIGR = PRD_KODEIGR(+)
            AND PKM_PRDCD = PRD_PRDCD(+)
            AND PKM_KODEDIVISI = DIV_KODEDIVISI(+)
            AND PKM_KODEDEPARTEMENT = DEP_KODEDEPARTEMENT(+)
            AND PKM_KODEDIVISI = DEP_KODEDIVISI(+)
            AND PKM_KODEKATEGORIBARANG = KAT_KODEKATEGORI(+)
            AND PKM_KODEDEPARTEMENT = KAT_KODEDEPARTEMENT(+)
            AND HGB_KODESUPPLIER = SUP_KODESUPPLIER(+)
            AND PKM_PRDCD = MPL_PRDCD(+)
            AND PKM_KODEIGR = MPL_KODEIGR(+)
            AND PRD_PRDCD = SLS_PRDCD(+)
            AND SLS_PRDCD = HGB_PRDCD(+)
            AND PKM_PRDCD = PKMG_PRDCD(+)
            AND PKM_PRDCD = GDL_PRDCD(+)
            AND PKM_PRDCD = TPOD_PRDCD(+)
            AND PKM_KODEDIVISI BETWEEN NVL ('" . $div1 . "', '0') AND NVL ('" . $div2 . "', 'Z')
            AND PKM_KODEDEPARTEMENT BETWEEN NVL ('" . $dep1 . "', '00') AND NVL ('" . $dep2 . "', 'ZZ')
            AND PKM_KODEKATEGORIBARANG BETWEEN NVL ('" . $kat1 . "', '00') AND NVL ('" . $kat2 . "', 'ZZ')
            AND PKM_PRDCD BETWEEN NVL ('" . $plu1 . "', '0000000') AND NVL ('" . $plu2 . "', 'ZZZZZZZ')
            " . $monitoringplu . "
            " . $supplier . "
            " . $pilih . "
            " . $jenispkm . "
ORDER BY FTPRDE, FTKSUP, PKM_PRDCD");
        }
        for ($i = 0; $i < sizeof($data); $i++) {
            $data[$i]->cp_periode = '';
            switch (substr($data[$i]->ftprde, 4, 2)) {
                case '01':
                    $data[$i]->cp_periode = "  JANUARI";
                    break;
                case '02':
                    $data[$i]->cp_periode = "  FEBRUARI";
                    break;
                case '03':
                    $data[$i]->cp_periode = "  M A R E T";
                    break;
                case '04':
                    $data[$i]->cp_periode = 'A P R I L';
                    break;
                case '05':
                    $data[$i]->cp_periode = 'M E I';
                    break;
                case '06':
                    $data[$i]->cp_periode = 'J U N I';
                    break;
                case '07':
                    $data[$i]->cp_periode = 'J U L I';
                    break;
                case '08':
                    $data[$i]->cp_periode = 'AGUSTUS';
                    break;
                case '09':
                    $data[$i]->cp_periode = 'SEPTEMBER';
                    break;
                case '10':
                    $data[$i]->cp_periode = 'OKTOBER';
                    break;
                case '11':
                    $data[$i]->cp_periode = 'NOVEMBER';
                    break;
                case '12':
                    $data[$i]->cp_periode = 'DESEMBER';
                    break;
            }
            $data[$i]->cp_periode .= " - " . substr($data[$i]->ftprde, 0, 4);

            $data[$i]->cp_per1 = '';
            switch (substr($data[$i]->ftpr01, 0, 2)) {
                case '01':
                    $data[$i]->cp_per1 = "JANU";
                    break;
                case '02':
                    $data[$i]->cp_per1 = "FEBR";
                    break;
                case '03':
                    $data[$i]->cp_per1 = "MART";
                    break;
                case '04':
                    $data[$i]->cp_per1 = 'APRIL';
                    break;
                case '05':
                    $data[$i]->cp_per1 = 'MEI';
                    break;
                case '06':
                    $data[$i]->cp_per1 = 'JUNI';
                    break;
                case '07':
                    $data[$i]->cp_per1 = 'JULI';
                    break;
                case '08':
                    $data[$i]->cp_per1 = 'AGUS';
                    break;
                case '09':
                    $data[$i]->cp_per1 = 'SEPT';
                    break;
                case '10':
                    $data[$i]->cp_per1 = 'OKTB';
                    break;
                case '11':
                    $data[$i]->cp_per1 = 'NOVB';
                    break;
                case '12':
                    $data[$i]->cp_per1 = 'DESB';
                    break;
            }
            $data[$i]->cp_per1 .= "'" . substr($data[$i]->ftpr01, 4, 2);

            $data[$i]->cp_per2 = '';
            switch (substr($data[$i]->ftpr02, 0, 2)) {
                case '01':
                    $data[$i]->cp_per2 = "JANU";
                    break;
                case '02':
                    $data[$i]->cp_per2 = "FEBR";
                    break;
                case '03':
                    $data[$i]->cp_per2 = "MART";
                    break;
                case '04':
                    $data[$i]->cp_per2 = 'APRIL';
                    break;
                case '05':
                    $data[$i]->cp_per2 = 'MEI';
                    break;
                case '06':
                    $data[$i]->cp_per2 = 'JUNI';
                    break;
                case '07':
                    $data[$i]->cp_per2 = 'JULI';
                    break;
                case '08':
                    $data[$i]->cp_per2 = 'AGUS';
                    break;
                case '09':
                    $data[$i]->cp_per2 = 'SEPT';
                    break;
                case '10':
                    $data[$i]->cp_per2 = 'OKTB';
                    break;
                case '11':
                    $data[$i]->cp_per2 = 'NOVB';
                    break;
                case '12':
                    $data[$i]->cp_per2 = 'DESB';
                    break;
            }
            $data[$i]->cp_per2 .= "'" . substr($data[$i]->ftpr02, 4, 2);

            $data[$i]->cp_per3 = "";
            switch (substr($data[$i]->ftpr03, 0, 2)) {
                case '01':
                    $data[$i]->cp_per3 = "JANU";
                    break;
                case '02':
                    $data[$i]->cp_per3 = "FEBR";
                    break;
                case '03':
                    $data[$i]->cp_per3 = "MART";
                    break;
                case '04':
                    $data[$i]->cp_per3 = 'APRIL';
                    break;
                case '05':
                    $data[$i]->cp_per3 = 'MEI';
                    break;
                case '06':
                    $data[$i]->cp_per3 = 'JUNI';
                    break;
                case '07':
                    $data[$i]->cp_per3 = 'JULI';
                    break;
                case '08':
                    $data[$i]->cp_per3 = 'AGUS';
                    break;
                case '09':
                    $data[$i]->cp_per3 = 'SEPT';
                    break;
                case '10':
                    $data[$i]->cp_per3 = 'OKTB';
                    break;
                case '11':
                    $data[$i]->cp_per3 = 'NOVB';
                    break;
                case '12':
                    $data[$i]->cp_per3 = 'DESB';
                    break;
            }
            $data[$i]->cp_per3 .= "'" . substr($data[$i]->ftpr03, 4, 2);
        }
        $perusahaan = DB::connection(Session::get('connection'))->table('tbmaster_perusahaan')
            ->select('PRS_NAMAPERUSAHAAN', 'PRS_NAMACABANG')
            ->where('PRS_KODEIGR', Session::get('kdigr'))
            ->first();
        return view('BACKOFFICE.PKM.laporan-kertas-kerja-pkm-' . $filename . '-pdf', compact(['perusahaan', 'data', 'ket_jenispkm', 'ket_monitoring']));
    }

}
