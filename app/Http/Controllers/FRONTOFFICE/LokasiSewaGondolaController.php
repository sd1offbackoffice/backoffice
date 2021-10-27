<?php

namespace App\Http\Controllers\FRONTOFFICE;

use Dompdf\Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use PDF;
use DateTime;
use Yajra\DataTables\DataTables;

class LokasiSewaGondolaController extends Controller
{

    public function index()
    {
        return view('FRONTOFFICE.LOKASISEWAGONDOLA.lokasiSewaGondola');
    }

    public function lovNoPjSewa(Request $request)
    {
        $search = $request->value;
        $data = DB::select("SELECT distinct thn,
               CASE
                   WHEN bln = 'I'
                       THEN '01'
                   WHEN bln = 'II'
                       THEN '02'
                   WHEN bln = 'III'
                       THEN '03'
                   WHEN bln = 'IV'
                       THEN '04'
                   WHEN bln = 'V'
                       THEN '05'
                   WHEN bln = 'VI'
                       THEN '06'
                   WHEN bln = 'VII' OR bln = 'SRVII'
                       THEN '07'
                   WHEN bln = 'VIII'
                       THEN '08'
                   WHEN bln = 'IX'
                       THEN '09'
                   WHEN bln = 'X'
                       THEN '10'
                   WHEN bln = 'XI'
                       THEN '11'
                   WHEN bln = 'XII'
                       THEN '12'
               END bln, gdl_noperjanjiansewa, gdl_kodedisplay
          FROM (SELECT gdl_noperjanjiansewa, gdl_prdcd, gdl_kodedisplay, gdl_qty,
                       SUBSTR(gdl_noperjanjiansewa,
                              INSTR(gdl_noperjanjiansewa, '/', -1, 2) + 1,
                              INSTR(gdl_noperjanjiansewa, '/', -1, 1)
                              - INSTR(gdl_noperjanjiansewa, '/', -1, 2) - 1
                             ) bln,
                       SUBSTR(TRIM(gdl_noperjanjiansewa), -4, 4) thn
                  FROM tbtr_gondola)
Where gdl_noperjanjiansewa LIKE '%" . $search . "%'
                  order by thn desc, bln desc, gdl_kodedisplay");
        return DataTables::of($data)->make(true);
    }

    public function lovKodeRak(Request $request)
    {
        $search = $request->value;
        $data = DB::select("SELECT DISTINCT lks_koderak, lks_kodesubrak, lks_tiperak FROM TBMASTER_LOKASI
   WHERE lks_koderak LIKE 'X%'
   ORDER BY lks_koderak, lks_kodesubrak");
        return DataTables::of($data)->make(true);
    }

    public function lovLokasi(Request $request)
    {
        $search = $request->value;
        $data = DB::select("SELECT DISTINCT LKS_KODERAK, LKS_KODESUBRAK, LKS_TIPERAK, LKS_SHELVINGRAK, LKS_NOURUT,
                        LKS_KODERAK
                        || '.'
                        || LKS_KODESUBRAK
                        || '.'
                        || LKS_TIPERAK
                        || '.'
                        || LKS_SHELVINGRAK
                        || '.'
                        || LKS_NOURUT LOKASI
                        FROM TBMASTER_LOKASI
                        WHERE (SUBSTR (LKS_KODERAK, 1, 1) = 'X' OR LKS_TIPERAK = 'Z') AND LKS_PRDCD IS NULL
AND LKS_KODERAK
                        || '.'
                        || LKS_KODESUBRAK
                        || '.'
                        || LKS_TIPERAK
                        || '.'
                        || LKS_SHELVINGRAK
                        || '.'
                        || LKS_NOURUT LIKE '%" . $search . "%'
                        ORDER BY LOKASI");
        return DataTables::of($data)->make(true);
    }

    public function lovPLU(Request $request)
    {
        $search = $request->value;
        $data = DB::select("SELECT PRD_DESKRIPSIPANJANG,
                            PRD_PRDCD,PRD_UNIT||'/'||TO_CHAR(PRD_FRAC) SATUAN
                            FROM TBMASTER_PRODMAST
                            WHERE SUBSTR(PRD_PRDCD,7,1)='0'
                            and nvl(prd_recordid,'9')<>'1'
                            and prd_kodeigr='" . $_SESSION['kdigr'] . "'
                            and ( prd_prdcd LIKE '%" . $search . "%' or PRD_DESKRIPSIPANJANG LIKE '%" . $search . "%' )
                            ORDER BY PRD_DESKRIPSIPANJANG");
        return DataTables::of($data)->make(true);
    }

    public function lovKodeDisplay(Request $request)
    {
        $search = $request->value;
        $data = DB::select("select dis_kodedisplay, dis_namadisplay
                            from tbmaster_display
                            and ( dis_kodedisplay LIKE '%" . $search . "%' or dis_namadisplay LIKE '%" . $search . "%' )
                            ORDER BY dis_kodedisplay");
        return DataTables::of($data)->make(true);
    }


    public function getDataNoPjSewa(Request $request)
    {
        $nopjsewa = $request->nopjsewa;
        $model = '';
        $property = '';
        $data = '';
        $temp = DB::select("SELECT COUNT (1) count
      FROM TBTR_GONDOLA
     WHERE GDL_NOPERJANJIANSEWA = '" . $nopjsewa . "'")[0]->count;

        if ($temp == 0) {
            $property = true;
            $model = 'TAMBAH';
        } else {
            $data = DB::select("SELECT *
                  FROM TBTR_GONDOLA left join TBTR_GONDOLASEWA on GDL_NOPERJANJIANSEWA = GDS_NOPERJANJIANSEWA
                  AND GDL_PRDCD = GDS_PRDCD
                  AND trim(GDL_KODEPRINCIPAL) = GDS_KODEPRINCIPAL
                  AND trim(GDL_KODEDISPLAY) = GDS_KODEDISPLAY
                 WHERE GDL_NOPERJANJIANSEWA = '" . $nopjsewa . "'");
            if (strlen($nopjsewa) >= 18) {
                $property = true;
            } else {
                $property = false;
            }
        }

        return compact(['model', 'data', 'property']);
    }

    public function getDataLokasi(Request $request)
    {
        $plu = $request->plu;
        $recs = DB::select("SELECT *
            FROM TBMASTER_LOKASI
                 WHERE LKS_PRDCD = '" . $plu . "'
        AND LKS_KODERAK NOT LIKE 'D%'
        AND LKS_KODERAK NOT LIKE 'G%'
        AND LKS_KODERAK NOT LIKE 'X%'
        AND LKS_TIPERAK <> 'S'");

        return $recs;
    }

    public function simpanNoPerjanjianSewa(Request $request)
    {
        $data = $request->data;
        $model = $request->model;
        $nopjsewa = $request->nopjsewa;
        try {
            foreach ($data as $d) {

                if ($model == 'TAMBAH') {
                    DB::insert("INSERT INTO TBTR_GONDOLA
 (GDL_KODEIGR, GDL_NOPERJANJIANSEWA, GDL_PRDCD, GDL_QTY, GDL_KODECABANG,
                GDL_KODEDISPLAY, GDL_TGLAWAL, GDL_TGLAKHIR, GDL_KODEPRINCIPAL,
                GDL_CREATE_BY, GDL_CREATE_DT)
                 VALUES('" . $_SESSION['kdigr'] . "', '" . $nopjsewa . "', '" . $d['plu'] . "', '" . $d['qty'] . "', '" . $_SESSION['kdigr'] . "',
                         '" . $d['kodedisplay'] . "', to_date('" . $d['tglawal'] . "','dd/mm/yyyy'), to_date('" . $d['tglakhir'] . "','dd/mm/yyyy'), '" . $d['kodeprincipal'] . "',
                         '" . $_SESSION['usid'] . "', sysdate
                        )");
                }

                $temp = DB::select("SELECT COUNT(1) count
                          FROM TBTR_GONDOLASEWA
                         WHERE GDS_NOPERJANJIANSEWA = '" . $nopjsewa . "'
                    and GDS_PRDCD = '" . $d['plu'] . "'
                    and GDS_KODEDISPLAY = '" . $d['kodedisplay'] . "'")[0]->count;

                $temp = DB::select("select case when trunc(sysdate) between to_date('" . $d['tglawal'] . "','yyyy-mm-dd') and to_date('" . $d['tglakhir'] . "','yyyy-mm-dd') and '" . $d['lokasi'] . "' is not null then 1 else 0 end aa from tbmaster_perusahaan")[0]->aa;
//dd("select case when trunc(sysdate) between to_date('" . $d['tglawal'] . "','yyyy-mm-dd') and to_date('" . $d['tglakhir'] . "','yyyy-mm-dd') and '" . $d['lokasi'] . "' is not null then 1 else 0 end aa from tbmaster_perusahaan");
                if ($temp == 1) {

                    DB::insert("INSERT INTO TBTR_GONDOLASEWA
 (GDS_KODEIGR, GDS_NOPERJANJIANSEWA, GDS_PRDCD, GDS_QTY, GDS_KODECABANG,
                    GDS_KODEDISPLAY, GDS_TGLAWAL, GDS_TGLAKHIR, GDS_KODEPRINCIPAL,
                    GDS_LOKASI, GDS_CREATE_BY, GDS_CREATE_DT)
                 VALUES('" . $_SESSION['kdigr'] . "', '" . $nopjsewa . "', '" . $d['plu'] . "', '" . $d['qty'] . "', '" . $_SESSION['kdigr'] . "',
                         '" . $d['kodedisplay'] . "', to_date('" . $d['tglawal'] . "','yyyy/mm/dd'), to_date('" . $d['tglakhir'] . "','yyyy/mm/dd'), '" . $d['kodeprincipal'] . "', '" . $d['lokasi'] . "',
                         '" . $_SESSION['usid'] . "', sysdate
                        )");

                    DB::update("UPDATE TBMASTER_LOKASI
               SET LKS_MAXPLANO = LKS_MAXPLANO + " . $d['qty'] . ",
                   LKS_MODIFY_BY = '" . $_SESSION['usid'] . "',
                   LKS_MODIFY_DT = SYSDATE
             WHERE LKS_KODEIGR = '" . $_SESSION['kdigr'] . "'
                and LKS_PRDCD = '" . $d['plu'] . "'
                and LKS_KODERAK NOT LIKE 'D%'
                and LKS_KODERAK NOT LIKE 'G%'
                and LKS_TIPERAK <> 'S'");


                    DB::update("UPDATE TBMASTER_LOKASI
               SET LKS_PRDCD = '" . $d['plu'] . "',
               		 LKS_MODIFY_BY ='" . $_SESSION['usid'] . "',
                   LKS_MODIFY_DT = SYSDATE
             WHERE    LKS_KODERAK
                || '.'
                || LKS_KODESUBRAK
                || '.'
                || LKS_TIPERAK
                || '.'
                || LKS_SHELVINGRAK
                || '.'
                || LKS_NOURUT ='" . $d['lokasi'] . "'");

                }
            }
            $message = "Data Berhasil disimpan!";
            $status = "success";
            return compact(['message', 'status']);
        } catch (Exception $e) {
            $message = $e->getMessage();
            $status = "error";
            return compact(['message', 'status']);
        }
    }

    //==============================================================TAB LOKASI==================================================================
    public function getDataLokasi2(Request $request)
    {
        $rak = $request->rak;
        $subrak = $request->subrak;
        $tiperak = $request->tiperak;

        $recs = DB::select("SELECT *
            FROM TBMASTER_LOKASI
                 WHERE LKS_KODERAK = '" . $rak . "'
        AND LKS_KODESUBRAK = '" . $subrak . "'
        AND LKS_TIPERAK = '" . $tiperak . "'");
        return $recs;
    }

    public function lovPLUPrjSewa(Request $request)
    {
        $search = $request->value;
        $data = DB::select("SELECT DISTINCT GDL_NOPERJANJIANSEWA, GDL_PRDCD, THN,
                CASE
                    WHEN BLN = 'I'
                        THEN '01'
                    WHEN BLN = 'II'
                        THEN '02'
                    WHEN BLN = 'III'
                        THEN '03'
                    WHEN BLN = 'IV'
                        THEN '04'
                    WHEN BLN = 'V'
                        THEN '05'
                    WHEN BLN = 'VI'
                        THEN '06'
                    WHEN BLN = 'VII' OR BLN = 'SRVII'
                        THEN '07'
                    WHEN BLN = 'VIII'
                        THEN '08'
                    WHEN BLN = 'IX'
                        THEN '09'
                    WHEN BLN = 'X'
                        THEN '10'
                    WHEN BLN = 'XI'
                        THEN '11'
                    WHEN BLN = 'XII'
                        THEN '12'
                END BLN,
                GDL_KODEDISPLAY
           FROM (SELECT GDL_NOPERJANJIANSEWA, GDL_PRDCD, GDL_KODEDISPLAY, GDL_QTY,
                        SUBSTR (GDL_NOPERJANJIANSEWA,
                                INSTR (GDL_NOPERJANJIANSEWA, '/', -1, 2) + 1,
                                  INSTR (GDL_NOPERJANJIANSEWA, '/', -1, 1)
                                - INSTR (GDL_NOPERJANJIANSEWA, '/', -1, 2)
                                - 1
                               ) BLN,
                        SUBSTR (TRIM (GDL_NOPERJANJIANSEWA), -4, 4) THN
                   FROM TBTR_GONDOLA
                  WHERE TRUNC (SYSDATE) BETWEEN GDL_TGLAWAL AND GDL_TGLAKHIR)
          WHERE NOT EXISTS (
                         SELECT 1
                           FROM TBTR_GONDOLASEWA
                          WHERE GDS_NOPERJANJIANSEWA = GDL_NOPERJANJIANSEWA
                                AND GDS_PRDCD = GDL_PRDCD)
       ORDER BY THN DESC, BLN DESC, GDL_NOPERJANJIANSEWA, GDL_PRDCD");
        return DataTables::of($data)->make(true);
    }

    public function Simpan2(Request $request)
    {
        $kdrak = $request->rak;
        $subrak = $request->subrak;
        $tiperak = $request->tiperak;
        $shelving = $request->shelving;
        $nourut = $request->nourut;
        $plu = $request->plu;
        $noprjsewa = $request->noprjsewa;

        if (substr($kdrak, 0, 1) <> 'X') {
            $message = 'Kode Rak harus X';
            $status = "error";
            return compact(['message', 'status']);
        }

        $temp = DB::select("SELECT COUNT(1) count
              FROM TBMASTER_LOKASI
             WHERE LKS_KODERAK =  '" . $kdrak . "'
            and LKS_KODESUBRAK = '" . $subrak . "'
            and LKS_TIPERAK =  '" . $tiperak . "'
            and LKS_SHELVINGRAK =  '" . $shelving . "'
            and LKS_NOURUT =  '" . $nourut . "'")[0]->count;


        if ($temp == 0) {
            DB::insert("INSERT INTO TBMASTER_LOKASI (LKS_KODEIGR ,LKS_KODERAK, LKS_KODESUBRAK, LKS_TIPERAK, LKS_SHELVINGRAK, LKS_NOURUT)
             VALUES('" . $_SESSION['kdigr'] . "','" . $kdrak . "', '" . $subrak . "', '" . $tiperak . "', '" . $shelving . "', '" . $nourut . "')");

        }

        $temp = DB::select("SELECT COUNT(1) count
                  FROM TBTR_GONDOLASEWA
                 WHERE GDS_NOPERJANJIANSEWA = '" . $noprjsewa . "' and GDS_PRDCD = '" . $plu . "'")[0]->count;

        if ($temp > 0) {
            $message = 'PLU sudah terdaftar di Gondola aktif';
            $status = "error";
            return compact(['message', 'status']);
        } else {
            DB::insert("INSERT INTO TBTR_GONDOLASEWA
            (GDS_KODEIGR, GDS_NOPERJANJIANSEWA, GDS_PRDCD, GDS_QTY, GDS_KODECABANG,
                GDS_KODEDISPLAY, GDS_TGLAWAL, GDS_TGLAKHIR, GDS_KODEPRINCIPAL, GDS_LOKASI,
                GDS_CREATE_BY, GDS_CREATE_DT)
            SELECT GDL_KODEIGR, GDL_NOPERJANJIANSEWA, GDL_PRDCD, GDL_QTY, GDL_KODECABANG,
                   GDL_KODEDISPLAY, GDL_TGLAWAL, GDL_TGLAKHIR, GDL_KODEPRINCIPAL,
              '" . $kdrak . "'
            || '.'
            || '" . $subrak . "'
            || '.'
            || '" . $tiperak . "'
            || '.'
            || '" . $shelving . "'
            || '.'
            || '" . $nourut . "',
               '" . $_SESSION['usid'] . "', SYSDATE
              FROM TBTR_GONDOLA
             WHERE GDL_NOPERJANJIANSEWA = '" . $noprjsewa . "' and GDL_PRDCD = '" . $plu . "'");

            $gdlqty = DB::select("SELECT NVL(GDL_QTY, 0) qty
          FROM TBTR_GONDOLA
         WHERE GDL_NOPERJANJIANSEWA = '" . $noprjsewa . "' and GDL_PRDCD = '" . $plu . "'")[0]->qty;

            DB::update("UPDATE TBMASTER_LOKASI
           SET LKS_MAXPLANO = LKS_MAXPLANO + '" . $gdlqty . "',
               LKS_MODIFY_BY = '" . $_SESSION['usid'] . "',
               LKS_MODIFY_DT = SYSDATE
         WHERE LKS_KODEIGR = '" . $_SESSION['kdigr'] . "'
            and LKS_PRDCD = '" . $plu . "'
            and LKS_KODERAK NOT LIKE 'D%'
            and LKS_KODERAK NOT LIKE 'G%'
            and LKS_TIPERAK <> 'S'");


            DB::update("UPDATE TBMASTER_LOKASI
           SET LKS_PRDCD = '" . $plu . "',
               LKS_MODIFY_BY = '" . $_SESSION['usid'] . "',
               LKS_MODIFY_DT = SYSDATE
         WHERE LKS_KODERAK = '" . $kdrak . "'
            and LKS_KODESUBRAK = '" . $subrak . "'
            and LKS_TIPERAK = '" . $tiperak . "'
            and LKS_SHELVINGRAK = '" . $shelving . "'
            and LKS_NOURUT = '" . $nourut . "'");


            $message = 'Data berhasil di update';
            $status = "success";
            return compact(['message', 'status']);
        }
    }
}
