<?php

namespace App\Http\Controllers\BACKOFFICE\PKM;

use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;
use PDF;
use Yajra\DataTables\DataTables;
use ZipArchive;
use File;

class EntryInqueryKertasKerjaPKMController extends Controller
{
    public function index(){
        return view('BACKOFFICE.PKM.entry-inquery');
    }

    public function getLovPrdcd(){
        $data = DB::connection($_SESSION['connection'])->select("select prd_deskripsipanjang desk, prd_prdcd plu, prd_unit || '/' || prd_frac konversi, prd_hrgjual from tbmaster_prodmast
            where prd_kodeigr = '".$_SESSION['kdigr']."'
            and substr(prd_Prdcd,7,1) = '0'
            order by prd_deskripsipanjang");

        return DataTables::of($data)->make(true);
    }

    public function getLovDivisi(){
        $data = DB::connection($_SESSION['connection'])->select("SELECT div_namadivisi, div_kodedivisi
                FROM TBMASTER_DIVISI
                WHERE div_kodeigr ='".$_SESSION['kdigr']."'
                order by div_kodedivisi");

        return DataTables::of($data)->make(true);
    }

    public function getLovDepartement(Request $request){
        $data = DB::connection($_SESSION['connection'])->select("SELECT distinct dep_namadepartement, dep_kodedepartement, dep_kodedivisi
                FROM TBMASTER_DEPARTEMENT
                WHERE dep_kodeigr ='".$_SESSION['kdigr']."'
                AND dep_kodedivisi = '".$request->kodedivisi."'
                order by dep_kodedepartement");

        return DataTables::of($data)->make(true);
    }

    public function getLovKategori(Request $request){
        $data = DB::connection($_SESSION['connection'])->select("SELECT distinct kat_namakategori, kat_kodekategori, kat_kodedepartement
                FROM TBMASTER_KATEGORI
                WHERE kat_kodeigr ='".$_SESSION['kdigr']."'
                AND kat_kodedepartement = '".$request->kodedepartement."'
                order by kat_kodekategori");

        return DataTables::of($data)->make(true);
    }

    public function getLovMonitoring(){
        $data = DB::connection($_SESSION['connection'])->select("SELECT DISTINCT mpl_namamonitoring, mpl_kodemonitoring
                FROM TBTR_MONITORINGPLU
                WHERE mpl_kodeigr = '".$_SESSION['kdigr']."'
                ORDER BY mpl_namamonitoring");

        return DataTables::of($data)->make(true);
    }

    public function getDetail(Request $request){
        if($request->has('prdcd')){
            $where = "AND pkm_prdcd = '".$request->prdcd."'";
        }
        else if($request->has('item')){
            if($request->item == '1'){
                $where = "AND prd_kodedivisi = '".$request->div."' AND prd_kodedepartement = '".$request->dep."' AND prd_kodekategoribarang = '".$request->kat."'";
            }
            else{
                $where = "AND prd_kodedivisi = '".$request->div."' AND prd_kodedepartement = '".$request->dep."' AND prd_kodekategoribarang = '".$request->kat."' AND exists (select prc_pluigr from tbmaster_prodcrm where prc_group=''O'' and prc_pluigr=prd_prdcd)";
            }
        }
        else{
            $where = "AND substr(prd_prdcd,-1,1)='0' and EXISTS (SELECT MPL_PRDCD FROM TBTR_MONITORINGPLU WHERE MPL_KODEMONITORING = '".$request->mon."' AND MPL_PRDCD=PRD_PRDCD)";
        }

        $fmprdta = DB::connection($_SESSION['connection'])->table('tbmaster_perusahaan')
            ->select('prs_periodeterakhir')
            ->first()->prs_periodeterakhir;

        $data = DB::connection($_SESSION['connection'])->select("SELECT pkm_prdcd,
                 pkm_periode1,
                 pkm_periode2,
                 pkm_periode3,
                 pkm_hari1,
                 pkm_hari2,
                 pkm_hari3,
                 pkm_qty1,
                 pkm_qty2,
                 pkm_qty3,
                 pkm_leadtime,
                 pkm_koefisien,
                 pkm_qtyaverage,
                 pkm_pkm,
                 pkm_mpkm,
                 pkm_pkmt,
                 sup_kodesupplier,
                 sup_namasupplier,
                 sup_jangkawaktukirimbarang,
                 sup_top,
                 prd_prdcd,
                 prd_deskripsipanjang,
                 prd_kodedivisi,
                 prd_kodedepartement,
                 prd_kodekategoribarang,
                 prd_kodetag,
                 prd_unit,
                 prd_frac,
                 prd_minorder,
                 prd_flaggudang,
                 prd_isibeli,
                 pkm_mindisplay,
                 prd_avgcost,
                 hgb_statusbarang,
                 hgb_top,
                 maxd,
                 mpt_maxqty,
                 nvl(SLV_SERVICELEVEL_QTY,0) SLV_SERVICELEVEL_QTY,
                 nvl(CASE WHEN SUBSTR (PKM_PERIODE3, 1, 2) = '01' THEN PSL_HARISALES_01
                    WHEN SUBSTR (PKM_PERIODE3, 1, 2) = '02' THEN PSL_HARISALES_02
                    WHEN SUBSTR (PKM_PERIODE3, 1, 2) = '03' THEN PSL_HARISALES_03
                    WHEN SUBSTR (PKM_PERIODE3, 1, 2) = '04' THEN PSL_HARISALES_04
                    WHEN SUBSTR (PKM_PERIODE3, 1, 2) = '05' THEN PSL_HARISALES_05
                    WHEN SUBSTR (PKM_PERIODE3, 1, 2) = '06' THEN PSL_HARISALES_06
                    WHEN SUBSTR (PKM_PERIODE3, 1, 2) = '07' THEN PSL_HARISALES_07
                    WHEN SUBSTR (PKM_PERIODE3, 1, 2) = '08' THEN PSL_HARISALES_08
                    WHEN SUBSTR (PKM_PERIODE3, 1, 2) = '09' THEN PSL_HARISALES_09
                    WHEN SUBSTR (PKM_PERIODE3, 1, 2) = '10' THEN PSL_HARISALES_10
                    WHEN SUBSTR (PKM_PERIODE3, 1, 2) = '11' THEN PSL_HARISALES_11
                    WHEN SUBSTR (PKM_PERIODE3, 1, 2) = '12' THEN PSL_HARISALES_12
                  END
                    +
                    CASE WHEN SUBSTR (PKM_PERIODE2, 1, 2) = '01' THEN PSL_HARISALES_01
                    WHEN SUBSTR (PKM_PERIODE2, 1, 2) = '02' THEN PSL_HARISALES_02
                    WHEN SUBSTR (PKM_PERIODE2, 1, 2) = '03' THEN PSL_HARISALES_03
                    WHEN SUBSTR (PKM_PERIODE2, 1, 2) = '04' THEN PSL_HARISALES_04
                    WHEN SUBSTR (PKM_PERIODE2, 1, 2) = '05' THEN PSL_HARISALES_05
                    WHEN SUBSTR (PKM_PERIODE2, 1, 2) = '06' THEN PSL_HARISALES_06
                    WHEN SUBSTR (PKM_PERIODE2, 1, 2) = '07' THEN PSL_HARISALES_07
                    WHEN SUBSTR (PKM_PERIODE2, 1, 2) = '08' THEN PSL_HARISALES_08
                    WHEN SUBSTR (PKM_PERIODE2, 1, 2) = '09' THEN PSL_HARISALES_09
                    WHEN SUBSTR (PKM_PERIODE2, 1, 2) = '10' THEN PSL_HARISALES_10
                    WHEN SUBSTR (PKM_PERIODE2, 1, 2) = '11' THEN PSL_HARISALES_11
                    WHEN SUBSTR (PKM_PERIODE2, 1, 2) = '12' THEN PSL_HARISALES_12
                    END
                    +
                    CASE WHEN SUBSTR (PKM_PERIODE1, 1, 2) = '01' THEN PSL_HARISALES_01
                    WHEN SUBSTR (PKM_PERIODE1, 1, 2) = '02' THEN PSL_HARISALES_02
                    WHEN SUBSTR (PKM_PERIODE1, 1, 2) = '03' THEN PSL_HARISALES_03
                    WHEN SUBSTR (PKM_PERIODE1, 1, 2) = '04' THEN PSL_HARISALES_04
                    WHEN SUBSTR (PKM_PERIODE1, 1, 2) = '05' THEN PSL_HARISALES_05
                    WHEN SUBSTR (PKM_PERIODE1, 1, 2) = '06' THEN PSL_HARISALES_06
                    WHEN SUBSTR (PKM_PERIODE1, 1, 2) = '07' THEN PSL_HARISALES_07
                    WHEN SUBSTR (PKM_PERIODE1, 1, 2) = '08' THEN PSL_HARISALES_08
                    WHEN SUBSTR (PKM_PERIODE1, 1, 2) = '09' THEN PSL_HARISALES_09
                    WHEN SUBSTR (PKM_PERIODE1, 1, 2) = '10' THEN PSL_HARISALES_10
                    WHEN SUBSTR (PKM_PERIODE1, 1, 2) = '11' THEN PSL_HARISALES_11
                    WHEN SUBSTR (PKM_PERIODE1, 1, 2) = '12' THEN PSL_HARISALES_12
                    END,0) HARI
            FROM tbmaster_kkpkm,
                 tbmaster_prodmast,
                 tbmaster_supplier,
                 tbtr_servicelevel,
                 tbtr_pkmsales,
                 (SELECT DISTINCT HGB_PRDCD,
                                  HGB_STATUSBARANG,
                                  HGB_KODESUPPLIER,
                                  HGB_TOP
                    FROM TBMASTER_HARGABELI
                   WHERE HGB_TIPE = '2'),
                 (  SELECT LKS_PRDCD,
                           SUM (
                                LKS_TIRKIRIKANAN
                              * LKS_TIRDEPANBELAKANG
                              * LKS_TIRATASBAWAH)
                              MIND_A,
                           SUM (LKS_MAXDISPLAY) MAXD
                      FROM TBMASTER_LOKASI
                     WHERE     (LKS_KODERAK LIKE 'R%' OR LKS_KODERAK LIKE 'O%')
                           AND LKS_JENISRAK IN ('D', 'N')
                  GROUP BY LKS_PRDCD),
                 (SELECT MPT_PRDCD, MPT_MAXQTY FROM TBMASTER_MAXPALET)
           WHERE     pkm_prdcd = prd_prdcd
                 AND pkm_prdcd = lks_prdcd(+)
                 AND pkm_PRDCD = HGB_PRDCD(+)
                 AND HGB_KODESUPPLIER = SUP_KODESUPPLIER(+)
                 AND pkm_PRDCD = MPT_PRDCD(+)
                 and pkm_prdcd = slv_prdcd(+)
                 and add_months(to_date(pkm_periodeproses,'mmyyyy'),-1) = to_date(slv_periode(+),'yyyymm')
                 and psl_prdcd = pkm_prdcd ".$where."
            ORDER BY pkm_prdcd");

        foreach($data as $d){
            $ftltima = $d->sup_jangkawaktukirimbarang;

            if($ftltima == 0 && ($d->prd_kodetag != 'N' || $d->prd_kodetag != 'H' || $d->prd_kodetag != 'X')){
                if($d->prd_flaggudang == 'Y' || $d->prd_flaggudang == 'P'){
                    $ftltima = 15;
                }
                else $ftltima = $d->sup_jangkawaktukirimbarang;
            }

            $cek = DB::connection($_SESSION['connection'])->table('tbtr_gondola')
                ->where('gdl_prdcd','=',$d->pkm_prdcd)
                ->whereRaw("TRUNC (SYSDATE) BETWEEN TRUNC (gdl_tglawal) AND TRUNC (gdl_tglakhir)")
                ->first();

            if($cek){
                $gdl_tglawal = $cek->gdl_tglawal;
                $gdl_tglakhir = $cek->gdl_tglakhir;
            }
            else{
                $gdl_tglawal = null;
                $gdl_tglakhir = null;
            }

            $temp = DB::connection($_SESSION['connection'])->table('tbtr_gondola')
                ->where('gdl_prdcd','=',$d->pkm_prdcd)
                ->first();

            $ftngdla = 0;

            if($temp){
                $flagmpa = false;

                $gdl = DB::connection($_SESSION['connection'])->select("(select sum(gdl_qty) gdl_qty, gdl_prdcd from
                (SELECT gdl_qty, gdl_prdcd
                FROM TBTR_GONDOLA, tbmaster_perusahaan
                WHERE GDL_PRDCD = '".$d->pkm_prdcd."'
                AND NVL (TRUNC (GDL_TGLAWAL),TO_DATE ('01-01-1990', 'dd-mm-yyyy')) - 3 <= prs_periodeterakhir
                AND NVL (TRUNC (GDL_TGLAKHIR),TO_DATE ('31-12-2100', 'dd-mm-yyyy')) - 7 >= prs_periodeterakhir)
                group by gdl_prdcd)");

                if($gdl){
                    $flagmpa = true;
                    $ftngdla = $gdl[0]->gdl_qty;
                }

                if($flagmpa){
                    $temp = DB::connection($_SESSION['connection'])->table('tbtr_pkmgondola')
                        ->where('pkmg_prdcd','=',$d->pkm_prdcd)
                        ->first();

                    if(!$temp){
                        DB::connection($_SESSION['connection'])->table('tbtr_pkmgondola')
                            ->insert([
                                'PKMG_KODEIGR' => $_SESSION['kdigr'],
                                'PKMG_KODEDIVISI' => $d->prd_kodedivisi,
                                'PKMG_KODEDEPARTEMENT' => $d->prd_kodedepartement,
                                'PKMG_KODEKATEGORIBRG' => $d->prd_kodekategoribarang,
                                'PKMG_PRDCD' => $d->pkm_prdcd,
                                'PKMG_NILAIPKMG' => $d->pkm_pkmt + $ftngdla,
                                'PKMG_NILAIPKMB' => $d->pkm_pkmt + $ftngdla,
                                'PKMG_NILAIMPKM' => $d->pkm_mpkm,
                                'PKMG_NILAIPKMT' => $d->pkm_pkmt,
                                'PKMG_CREATE_DT' => DB::RAW("SYSDATE"),
                                'PKMG_CREATE_BY' => $_SESSION['usid'],
                                'PKMG_NILAIGONDOLA' => $ftngdla,
                                'PKMG_TGLAWALPKM' => $gdl_tglawal,
                                'PKMG_TGLAKHIRPKM' => $gdl_tglakhir
                            ]);
                    }
                    else{
                        DB::connection($_SESSION['connection'])->table('tbtr_pkmgondola')
                            ->where('pkmg_prdcd','=',$d->pkm_prdcd)
                            ->where('pkmg_kodeigr','=',$_SESSION['kdigr'])
                            ->update([
                                'PKMG_NILAIPKMG' => $d->pkm_pkmt + $ftngdla,
                                'PKMG_NILAIPKMB' => $d->pkm_pkmt + $ftngdla,
                                'PKMG_NILAIMPKM' => $d->pkm_mpkm,
                                'PKMG_NILAIPKMT' => $d->pkm_pkmt,
                                'PKMG_MODIFY_DT' => DB::RAW("SYSDATE"),
                                'PKMG_MODIFY_BY' => $_SESSION['usid'],
                                'PKMG_NILAIGONDOLA' => $ftngdla,
                                'PKMG_TGLAWALPKM' => $gdl_tglawal,
                                'PKMG_TGLAKHIRPKM' => $gdl_tglakhir
                            ]);
                    }
                }
            }

            $d->nplus = $ftngdla;
            $d->pkmx = $d->pkm_pkmt + $ftngdla;

            $d->bln1 = $this->getNamaBulan(substr($d->pkm_periode1,0,2)).' '.substr($d->pkm_periode3,-4);
            $d->bln2 = $this->getNamaBulan(substr($d->pkm_periode2,0,2)).' '.substr($d->pkm_periode2,-4);
            $d->bln3 = $this->getNamaBulan(substr($d->pkm_periode3,0,2)).' '.substr($d->pkm_periode1,-4);

            $d->unit = $d->prd_frac.'/'.$d->prd_unit;

            if($d->hgb_top == 0){
                $d->jtopa = $d->sup_top;
            }
            else $d->jtopa = $d->hgb_top;

            $nminor = 0;

            if($d->prd_flaggudang == 'Y' || $d->prd_flaggudang == 'P'){
                if($d->prd_minorder == 0)
                    $nminor = $d->prd_isibeli;
                else $nminor = $d->prd_minorder;

                $minor = DB::connection($_SESSION['connection'])->select("SELECT MIN_PRDCD, MIN_MINORDER
                  FROM TBMASTER_MINIMUMORDER
                 WHERE SUBSTR (MIN_PRDCD, 1, 6) = SUBSTR('".$d->prd_prdcd."', 1, 6)");

                foreach($minor as $m){
                    $nminor = $m->min_minorder;
                }
            }
            else{
                if($d->prd_minorder == 0)
                    $nminor = $d->prd_isibeli;
                else $nminor = $d->prd_minorder;
            }

//            $d->min = $nminor;

            $temp = DB::connection($_SESSION['connection'])->table('tbmaster_barangbaru')
                ->where('pln_prdcd','=',$d->pkm_prdcd)
                ->first();

            if($temp){
                $d->ketnewplu = '** (PRODUK BARU) **';
            }
            else $d->ketnewplu = '';


            $txt_min = 0;
            $txt_min = $d->prd_minorder == 0 ? $d->prd_isibeli : $d->prd_minorder;

            $minor = DB::connection($_SESSION['connection'])->select("SELECT MIN_PRDCD, MIN_MINORDER
                  FROM TBMASTER_MINIMUMORDER
                 WHERE SUBSTR (MIN_PRDCD, 1, 6) = SUBSTR('".$d->prd_prdcd."', 1, 6)");

            foreach($minor as $m){
                $txt_min = $m->min_minorder;
            }

            $d->min = $txt_min;



            if($d->pkm_qtyaverage == 0){
                $d->dsi = $d->pkm_qtyaverage;
            }
            else $d->dsi = round(($d->pkm_pkmt + $ftngdla) / $d->pkm_qtyaverage);

            if(in_array($d->prd_kodetag, ['N','H','X','A','O','I','U','Q'])){
                $d->kettag = 'TAG INI TIDAK BISA DIEDIT !!';
            }
            else $d->kettag = '';

            $ms = DB::connection($_SESSION['connection'])->select("SELECT PKMP_QTYMINOR
                  FROM TBMASTER_PKMPLUS
                 WHERE PKMP_PRDCD = '".$d->prd_prdcd."'");

            $d->mplus = 0;
            foreach($ms as $m){
                $d->mplus = $m->pkmp_qtyminor;
            }

            if($request->item == '1' || $request->prdcd || $request->mon){
                $temp = DB::connection($_SESSION['connection'])->select("SELECT prc_kodetag
                        FROM TBMASTER_PRODCRM
                        WHERE PRC_PLUIGR = '".$d->prd_prdcd."'
                        AND NVL (PRC_KODETAG, 'z') NOT IN ('A','R','N','O','H','X')");

                if(count($temp) > 0){
                    $d->omi = 'Y';
                }
                else $d->omi = '';
            }
            else{
                $d->omi = '';
            }

            $d->maxpalet = $d->mpt_maxqty;
            $temp = $d->pkmx + ($d->min + 0.5);

            if($temp >= $d->maxd && $temp >= $d->maxpalet)
                $d->slp = 'S';
            else if($temp >= $d->maxd && $temp < $d->maxpalet)
                $d->slp = 'Sc';
            else if($temp < $d->maxd)
                $d->slp = 'N';
            else $d->slp = '';

            $d->pkm_qtyaverage = number_format($d->pkm_qtyaverage,3);
        }

        return DataTables::of($data)->make(true);
    }

    public function getNamaBulan($bln){
        switch ($bln){
            case '01' : return 'Januari';
            case '02' : return 'Februari';
            case '03' : return 'Maret';
            case '04' : return 'April';
            case '05' : return 'Mei';
            case '06' : return 'Juni';
            case '07' : return 'Juli';
            case '08' : return 'Agustus';
            case '09' : return 'September';
            case '10' : return 'Oktober';
            case '11' : return 'November';
            case '12' : return 'Desember';
        }
    }

    public function changePKM(Request $request){
        $prdcd = $request->prdcd;
        $pkm = $request->pkm;
        $pkmt = $request->pkmt;
        $mpkm = $request->mpkm;
        $usertype = $_SESSION['usertype'];
        $data = new \stdClass();

//        if($usertype == 'SM'){
//            if($pkm > $mpkm * 10){
//                return [
//                    'status' => 'error',
//                    'title' => 'Salah isian, PKM Toko tidak boleh lebih dari 10 x MPKM!'
//                ];
//            }
//        }
//        else if($usertype == 'SJM'){
//            if($pkm > $mpkm * 5){
//                return [
//                    'status' => 'error',
//                    'title' => 'Salah isian, PKM Toko tidak boleh lebih dari 5 x MPKM!'
//                ];
//            }
//        }
//        else{
//            return [
//                'status' => 'error',
//                'title' => 'Anda tidak berhak mengubah nilai PKM!'
//            ];
//        }

        $recs = DB::connection($_SESSION['connection'])->select("SELECT PRD_PRDCD,
                 PRD_KODEDIVISI,
                 PRD_KODEDEPARTEMENT,
                 PRD_KODEKATEGORIBARANG,
                 PRD_AVGCOST,
                 PRD_UNIT,
                 PRD_frac,
                 PKM_PRDCD,
                 PKM_PeriodeProses,
                 PKM_Periode1,
                 PKM_Periode2,
                 PKM_Periode3,
                 PKM_PKMT,
                 SLS_KodeSupplier
            FROM TBMASTER_PRODMAST,
                 TBTR_SALESBULANAN,
                 (SELECT PKM_PRDCD,
                         PKM_PERIODEPROSES,
                         PKM_PERIODE1,
                         PKM_PERIODE2,
                         PKM_PERIODE3,
                         PKM_MINDISPLAY,
                         PKM_QTYAVERAGE,
                         PKM_QTY1,
                         PKM_QTY2,
                         PKM_QTY3,
                         pkm_koefisien,
                         PKM_LEADTIME,
                         PKM_PKM,
                         PKM_MPKM,
                         PKM_PKMT
                    FROM TBMASTER_KKPKM
                   WHERE PKM_PRDCD || PKM_PERIODEPROSES IN (SELECT    PKM_PRDCD
                                                                   || PER
                                                              FROM (  SELECT PKM_PRDCD,
                                                                             MAX (
                                                                                PKM_PERIODEPROSES)
                                                                                PER
                                                                        FROM TBMASTER_KKPKM
                                                                    GROUP BY PKM_PRDCD)))
           WHERE     PRD_PRDCD = PKM_PRDCD(+)
                 AND PRD_PRDCD = SLS_PRDCD(+)
                 AND PRD_PRDCD = '".$prdcd."'");

        foreach($recs as $rec){
            if($rec->pkm_prdcd == null){
                DB::connection($_SESSION['connection'])->table('tbmaster_kkpkm')
                    ->insert([
                        'PKM_KODEIGR' => $_SESSION['kdigr'],
                        'PKM_PRDCD' => $prdcd,
                        'PKM_KODEDIVISI' => $rec->prd_kodedivisi,
                        'PKM_KODEDEPARTEMENT' => $rec->prd_kodedepartement,
                        'PKM_KODEKATEGORIBARANG' => $rec->prd_kodekategoribarang,
                        'PKM_CREATE_BY' => $_SESSION['usid'],
                        'PKM_CREATE_DT' => DB::RAW("SYSDATE")
                    ]);
            }

            $data->npkmt = ($pkmt - $rec->pkm_pkmt) * ($rec->prd_avgcost / ($rec->prd_unit == 'KG' ? 1 : $rec->prd_frac));

            DB::connection($_SESSION['connection'])->table('tbmaster_kkpkm')
                ->where('pkm_prdcd','=',$prdcd)
                ->update([
                    'pkm_pkm' => $pkm,
                    'pkm_pkmt' => $pkmt,
                    'pkm_adjust_by' => $_SESSION['usid'],
                    'pkm_adjust_dt' => DB::RAW("SYSDATE")
                ]);

            $temp = DB::connection($_SESSION['connection'])->table('tbtr_gondola')
                ->select('gdl_tglawal','gdl_tglakhir')
                ->where('gdl_prdcd','=',$prdcd)
                ->whereRaw("TRUNC (SYSDATE) BETWEEN TRUNC (gdl_tglawal) AND TRUNC (gdl_tglakhir)")
                ->first();

            if($temp){
                $gdl_tglawal = $temp->gdl_tglawal;
                $gdl_tglakhir = $temp->gdl_tglakhir;
            }
            else{
                $gdl_tglawal = null;
                $gdl_tglakhir = null;
            }

            $temp = DB::connection($_SESSION['connection'])->table('tbtr_gondola')
                ->where('gdl_prdcd','=',$prdcd)
                ->first();

            if($temp){
                $flagmpa = false;

                $gdl = DB::connection($_SESSION['connection'])->select("(select sum(gdl_qty) gdl_qty, gdl_prdcd from
                (SELECT gdl_qty, gdl_prdcd
                FROM TBTR_GONDOLA, tbmaster_perusahaan
                WHERE GDL_PRDCD = '".$prdcd."'
                AND NVL (TRUNC (GDL_TGLAWAL),TO_DATE ('01-01-1990', 'dd-mm-yyyy')) - 3 <= prs_periodeterakhir
                AND NVL (TRUNC (GDL_TGLAKHIR),TO_DATE ('31-12-2100', 'dd-mm-yyyy')) - 7 >= prs_periodeterakhir)
                group by gdl_prdcd)");

                if($gdl){
                    $flagmpa = true;
                    $ftngdla = $gdl[0]->gdl_qty;
                }

                if($flagmpa){
                    $temp = DB::connection($_SESSION['connection'])->table('tbtr_pkmgondola')
                        ->where('pkmg_prdcd','=',$prdcd)
                        ->first();

                    if(!$temp){
                        DB::connection($_SESSION['connection'])->table('tbtr_pkmgondola')
                            ->insert([
                                'PKMG_KODEIGR' => $_SESSION['kdigr'],
                                'PKMG_KODEDIVISI' => $rec->prd_kodedivisi,
                                'PKMG_KODEDEPARTEMENT' => $rec->prd_kodedepartement,
                                'PKMG_KODEKATEGORIBRG' => $rec->prd_kodekategoribarang,
                                'PKMG_PRDCD' => $rec->pkm_prdcd,
                                'PKMG_NILAIPKMG' => $pkmt + $ftngdla,
                                'PKMG_NILAIPKMB' => $pkmt + $ftngdla,
                                'PKMG_NILAIMPKM' => $mpkm,
                                'PKMG_NILAIPKMT' => $pkmt,
                                'PKMG_CREATE_DT' => DB::RAW("SYSDATE"),
                                'PKMG_CREATE_BY' => $_SESSION['usid'],
                                'PKMG_TGLAWALPKM' => $gdl_tglawal,
                                'PKMG_TGLAKHIRPKM' => $gdl_tglakhir
                            ]);
                    }
                    else{
                        DB::connection($_SESSION['connection'])->table('tbtr_pkmgondola')
                            ->where('pkmg_prdcd','=',$prdcd)
                            ->where('pkmg_kodeigr','=',$_SESSION['kdigr'])
                            ->update([
                                'PKMG_NILAIPKMG' => $pkmt + $ftngdla,
                                'PKMG_NILAIPKMB' => $pkmt + $ftngdla,
                                'PKMG_NILAIMPKM' => $mpkm,
                                'PKMG_NILAIPKMT' => $pkmt,
                                'PKMG_MODIFY_DT' => DB::RAW("SYSDATE"),
                                'PKMG_MODIFY_BY' => $_SESSION['usid'],
                                'PKMG_TGLAWALPKM' => $gdl_tglawal,
                                'PKMG_TGLAKHIRPKM' => $gdl_tglakhir
                            ]);
                    }
                }
            }
        }

        return [
            'status' => 'success',
            'title' => 'Nilai PKM berhasil diubah!',
            'data' => $data
        ];
    }
}
