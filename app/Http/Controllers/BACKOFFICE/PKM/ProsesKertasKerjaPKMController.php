<?php

namespace App\Http\Controllers\BACKOFFICE\PKM;

use App\Http\Controllers\Auth\loginController;
use App\Http\Controllers\ExcelController;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller; use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;
use PDF;
use Yajra\DataTables\DataTables;
use ZipArchive;
use File;

class ProsesKertasKerjaPKMController extends Controller
{
    public function index(){
        return view('BACKOFFICE.PKM.proses-kertas-kerja');
    }

    public function getLovPrdcd(){
        $data = DB::connection(Session::get('connection'))
            ->table('tbmaster_prodmast')
            ->selectRaw("prd_deskripsipendek desk, prd_prdcd plu, prd_unit || '/' || prd_frac konversi, prd_hrgjual")
            ->where('prd_kodeigr','=',Session::get('kdigr'))
            ->whereRaw("substr(prd_Prdcd,7,1) = '0'")
            ->orderBy('prd_deskripsipendek')
            ->limit(100)
            ->get();

//        $data = DB::connection(Session::get('connection'))->select("select prd_deskripsipendek desk, prd_prdcd plu, prd_unit || '/' || prd_frac konversi, prd_hrgjual from tbmaster_prodmast
//            where prd_kodeigr = '".Session::get('kdigr')."'
//            and substr(prd_Prdcd,7,1) = '0'
//            order by prd_deskripsipendek");

        return DataTables::of($data)->make(true);
    }

    public function getHistory(Request $request){
        if($request->plu != '0000000' && $request->plu != '')
            $where = " and pkm_prdcd = '".$request->plu."'";
        else $where = "";

        $data = DB::connection(Session::get('connection'))->select("select * from (SELECT pkm_prdcd,
                   prd_deskripsipanjang,
                   pkm_mindisplay,
                   pkm_minorder,
                   prd_flaggudang,
                   pkm_koefisien,
                   pkm_leadtime,
                   pkm_pkmt,
                   pkm_pkm,
                   pkm_mpkm,
                   pkm_qtymplus,
                   pkm_qtyaverage avgqty,
                   SUBSTR(pkm_periode1, 1, 2) || '/' || SUBSTR(pkm_periode1, 3, 4) bln1,
                   pkm_qty1 qty1,
                   pkm_hari1 hari1,
                   SUBSTR(pkm_periode2, 1, 2) || '/' || SUBSTR(pkm_periode2, 3, 4) bln2,
                   pkm_qty2 qty2,
                   pkm_hari2 hari2,
                   SUBSTR(pkm_periode3, 1, 2) || '/' || SUBSTR(pkm_periode3, 3, 4) bln3,
                   pkm_qty3 qty3,
                   pkm_hari3 hari3,
                   pkm_kodesupplier,
                   sup_namasupplier,
                   TO_CHAR(TO_DATE('01' || pkm_periodeproses, 'ddMMyyyy'), 'MON yy') bulan,
                   CASE
                       WHEN pkm_modify_by IS NULL
                           THEN to_char(pkm_create_dt, 'dd/mm/yyyy') || ' - ' || pkm_create_by
                       ELSE to_char(pkm_modify_dt, 'dd/mm/yyyy') || ' - ' || pkm_modify_by
                   END proses,
                   CASE
                       WHEN pkm_adjust_by IS NOT NULL
                           THEN to_char(pkm_adjust_dt, 'dd/mm/yyyy') || ' - ' || pkm_adjust_by
                   END adjust
              FROM tbmaster_kkpkm, tbmaster_prodmast, tbmaster_supplier
             WHERE pkm_kodeigr = '".Session::get('kdigr')."'
                and pkm_prdcd in (select pkm_prdcd from tbmaster_kkpkm where pkm_periodeproses is not null AND exists (select 1 from tbmaster_prodmast where prd_prdcd = pkm_prdcd and prd_kodedivisi IN ('1', '2', '3')))
               AND prd_kodeigr(+) = pkm_kodeigr
               AND prd_prdcd(+) = pkm_prdcd
               AND sup_kodeigr(+) = pkm_kodeigr
               AND sup_kodesupplier(+) = pkm_kodesupplier
               AND pkm_periodeproses IS NOT NULL
               --and rownum <= 50
               ".$where."
               order by pkm_prdcd asc)");

        return DataTables::of($data)->make(true);
    }

    public function getPLUDetail(Request $request){
        $plu = $request->plu;

        $data = DB::connection(Session::get('connection'))
            ->table('tbmaster_prodmast')
            ->select('prd_deskripsipanjang')
            ->where('prd_kodeigr','=',Session::get('kdigr'))
            ->where('prd_prdcd','=',$plu)
            ->first();

        if($data){
            return response()->json($data, 200);
        }
        else{
            return response()->json([
                'message' => 'Kode PLU '.$plu.' - '.Session::get('kdigr').' tidak terdaftar di Master Barang!'
            ], 500);
        }
    }

    public function changePKM(Request $request){
        $usertype = 'XXX';
        $prdcd = $request->prdcd;
        $pkm = $request->pkm;
        $mpkm = $request->mpkm;
        $qtymplus = $request->qtymplus;
        $pkmt = $request->pkmt;

        if(Session::get('userlevel') != '1'){
            $usertype = 'XX';
        }
        else if(substr(Session::get('eml'),0,2) == 'SM'){
            $usertype = 'SM';
        }
        else if(substr(Session::get('eml'),0,3) == 'SJM'){
            $usertype = 'SJM';
        }

        if($usertype == 'SM'){
            if($pkm > $mpkm * 10){
                return [
                    'status' => 'error',
                    'title' => 'Salah isian, PKM Toko tidak boleh lebih dari 10 x MPKM!'
                ];
            }
        }
        else if($usertype == 'SJM'){
            if($pkm > $mpkm * 5){
                return [
                    'status' => 'error',
                    'title' => 'Salah isian, PKM Toko tidak boleh lebih dari 5 x MPKM!'
                ];
            }
        }
        else{
            return [
                'status' => 'error',
                'title' => 'Anda tidak berhak mengubah nilai PKM!'
            ];
        }

        DB::connection(Session::get('connection'))->table('tbmaster_kkpkm')
            ->where('pkm_kodeigr','=',Session::get('kdigr'))
            ->where('pkm_prdcd','=',$prdcd)
            ->update([
                'pkm_pkm' => $pkm,
                'pkm_pkmt' => $pkm + $qtymplus,
                'pkm_adjust_by' => Session::get('usid'),
                'pkm_adjust_dt' => Carbon::now()
            ]);

        $temp = DB::connection(Session::get('connection'))->table('tbtr_gondola')
            ->where('gdl_prdcd','=',$prdcd)
            ->count();

        if($temp > 0){
            $flagmpa = false;

            $gdl = DB::connection(Session::get('connection'))->select("SELECT GDL_QTY FROM TBTR_GONDOLA
                    WHERE GDL_PRDCD = '".$prdcd."'
                    AND NVL (TRUNC (GDL_TGLAWAL), TO_DATE ('01-01-1990', 'dd-mm-yyyy')) - 3 <= TRUNC (SYSDATE)
                    AND NVL (TRUNC (GDL_TGLAK HIR), TO_DATE ('31-12-2100', 'dd-mm-yyyy')) - 7 >= TRUNC (SYSDATE)
                    ORDER BY gdl_prdcd,
                    NVL (GDL_TGLAWAL, TO_DATE ('01-01-1990', 'dd-mm-yyyy')) DESC,
                    NVL (GDL_TGLAKHIR, TO_DATE ('31-12-2100', 'dd-mm-yyyy')) DESC");

            if(count($gdl) > 0){
                $flagmpa = true;
                $ftngdla = $gdl[0]->gdl_qty;
            }

            if($flagmpa){
                $data = DB::connection(Session::get('connection'))->table('tbmaster_prodmast')
                    ->select('prd_kodedivisi','prd_kodedepartement','prd_kodekategoribarang')
                    ->where('prd_prdcd','=',$prdcd)
                    ->first();

                $kddiv = $data->prd_kodedivisi;
                $kddep = $data->prd_kodedepartement;
                $kdkat = $data->prd_kodekategoribarang;

                $temp = DB::connection(Session::get('connection'))->table('tbtr_pkmgondola')
                    ->where('pkmg_prdcd','=',$prdcd)
                    ->where('pkm_kodeigr','=',Session::get('kdigr'))
                    ->first();

                if(!$temp){
                    DB::connection(Session::get('connection'))->table('tbtr_pkmgondola')
                        ->insert([
                            'pkmg_kodeigr' => Session::get('kdigr'),
                            'pkmg_kodedivisi' => $kddiv,
                            'pkmg_kodedepartement' => $kddep,
                            'pkmg_kodekategoribrg' => $kdkat,
                            'pkmg_prdcd' => $prdcd,
                            'pkmg_nilaipkmg' => $pkmt + $ftngdla,
                            'pkmg_nilaipkmb' => $pkmt + $ftngdla,
                            'pkmg_nilaimpkm' => $mpkm,
                            'pkmg_nilaipkmt' => $pkmt,
                            'pkmg_create_dt' => Carbon::now(),
                            'pkmg_create_by' => Session::get('usid'),
                        ]);
                }
                else{
                    DB::connection(Session::get('connection'))->table('tbtr_pkmgondola')
                        ->where('pkm_prdcd','=',$prdcd)
                        ->where('pkm_kodeigr','=',Session::get('kdigr'))
                        ->update([
                            'pkmg_nilaipkmg' => $ftngdla + $pkmt,
                            'pkmg_nilaipkmb' => $ftngdla + $pkmt,
                            'pkmg_nilaimpkm' => $mpkm,
                            'pkmg_nilaipkmt' => $pkmt,
                            'pkmg_modify_dt' => Carbon::now(),
                            'pkmg_modify_by' => Session::get('usid')
                        ]);
                }
            }
        }

        return [
            'status' => 'success',
            'title' => 'Berhasil mengubah nilai PKM!'
        ];
    }

    public function cetakStatusStorage(){
        $datas = DB::connection(Session::get('connection'))->select("SELECT
                 pkm_prdcd,
                 pkm_mindisplay,
                 pkm_minorder,
                 round(pkm_qtyaverage,2) pkm_qtyaverage,
                 SUBSTR (pkm_periode1, 1, 2) || '-' || SUBSTR (pkm_periode1, 3, 4)
                    pkm_periode1,
                 pkM_qty1,
                 pkm_hari1,
                 SUBSTR (pkm_periode2, 1, 2) || '-' || SUBSTR (pkm_periode2, 3, 4)
                    pkm_periode2,
                 pkM_qty2,
                 pkm_hari2,
                 SUBSTR (pkm_periode3, 1, 2) || '-' || SUBSTR (pkm_periode3, 3, 4)
                    pkm_periode3,
                 pkM_qty3,
                 pkm_hari3,
                 pkm_pkmt,
                 pkm_kodesupplier,
                 to_char(pkm_koefisien) pkm_koefisien,
                 to_char(to_date(pkm_periodeproses,'mmyyyy'),'MON-YY') pkm_periodeproses,
                 to_char(NVL (NVL (pkm_adjust_dt, pkm_modify_dt), pkm_create_dt),'dd-MON-yy') || ' - '||
                 NVL (NVL (pkm_adjust_by, pkm_modify_by), pkm_create_by) pkm_edit, pkm_last_pkm, pkm_adjust_by,
                 NVL (lks_maxdisplay, 0) maxdisplay,
                 NVL (mpt_maxqty * prd_frac, 0) maxpallet,
                 pkm_mpkm, nvl(pkm_qtymplus,0) pkm_qtyminor
            FROM tbmaster_perusahaan,
                 tbmaster_kkpkm,
                 tbmaster_prodmast,
                 tbmaster_maxpalet,
                 (SELECT lks_prdcd, lks_maxdisplay
                    FROM tbmaster_lokasi
                   WHERE     LKS_MAXDISPLAY IS NOT NULL
                        AND LKS_JENISRAK IN ('D', 'N')
                        AND (   (LKS_KODERAK LIKE 'R%' OR LKS_KODERAK LIKE 'O%')
                        OR (    LKS_KODERAK LIKE 'D%'
                        AND EXISTS
                        (SELECT 1 FROM TBMASTER_PRODMAST, TBMASTER_PRODCRM
                         WHERE PRD_PRDCD = PRC_PLUIGR
                         AND PRD_FLAGIDM = 'Y'
                         AND LKS_PRDCD = PRD_PRDCD))))
           WHERE     prs_kodeigr = '".Session::get('kdigr')."'
                 AND prs_kodeigr = pkm_kodeigr
                 AND pkm_prdcd = prd_prdcd
                 AND prd_kodedivisi IN ('1', '2', '3')   -- khusus dry product
                 AND pkm_prdcd = mpt_prdcd(+)
                 AND pkm_prdcd = lks_prdcd(+)
                 AND pkm_periodeproses = (select pkm_periodeproses
            from (
            select count(1) cnt, pkm_periodeproses
            from tbmaster_kkpkm
            group by pkm_periodeproses
            order by cnt desc
            )
            where rownum=1)
        ORDER BY pkm_prdcd");

        $p_rowsk = 80;
        $p_rowsb = 130;

        $v_prsnsk = round((($p_rowsk / $p_rowsb) * 50));

        foreach($datas as $data){
            $v_qtysk = round($data->maxpallet * $v_prsnsk / 100);

            $v_pkmt50minor = $data->pkm_last_pkm + $data->pkm_qtyminor + round($data->pkm_minorder * 50 / 100);

            if($v_pkmt50minor > $v_qtysk)
                $data->cp_laststatus = 'S';
            else if($v_pkmt50minor > $data->maxdisplay && $v_pkmt50minor < $v_qtysk)
                $data->cp_laststatus = 'SK';
            else if($v_pkmt50minor <= $data->maxdisplay)
                $data->cp_laststatus = 'NS';
            else $data->cp_laststatus = '';

            $v_pkmt50minor = ($data->pkm_mpkm + $data->pkm_qtyminor) + round($data->pkm_minorder * 50 / 100);

            if($v_pkmt50minor > $v_qtysk)
                $data->cp_status = 'S';
            else if($v_pkmt50minor > $data->maxdisplay && $v_pkmt50minor < $v_qtysk)
                $data->cp_status = 'SK';
            else if($v_pkmt50minor <= $data->maxdisplay)
                $data->cp_status = 'NS';
            else $data->cp_status = '';

            $data->cp_adjstatus = '';
            if($data->pkm_adjust_by){
                $v_pkmt50minor = $data->pkm_pkmt + round($data->pkm_minorder * 50 / 100);

                if($v_pkmt50minor > $v_qtysk)
                    $data->cp_adjstatus = 'S';
                else if($v_pkmt50minor > $data->maxdisplay && $v_pkmt50minor < $v_qtysk)
                    $data->cp_adjstatus = 'SK';
                else if($v_pkmt50minor <= $data->maxdisplay)
                    $data->cp_adjstatus = 'NS';
            }

            unset($data->pkm_last_pkm);
            unset($data->pkm_adjust_by);
            unset($data->maxdisplay);
            unset($data->maxpallet);
            unset($data->pkm_mpkm);
            unset($data->pkm_qtyminor);
        }

//        dd($datas);

        $columnHeader = [
            'PLU',
            'Qty Min Disp',
            'Qty Min Ord',
            'Avg Sales 3 bulan',
            'Bulan 1',
            'Sales (qty)',
            'Hari',
            'Bulan 2',
            'Sales (qty)',
            'Hari',
            'Bulan 3',
            'Sales (qty)',
            'Hari',
            'PKM',
            'Kode Supplier',
            'N',
            'Periode proses',
            'Tgl edit PKM',
            'Sebelum Proses PKM',
            'Usulan (by program)',
            'Adjust (by user)'
        ];

        $rows = collect($datas)->map(function ($x) {
            return (array)$x;
        })->toArray();

        $filename = 'Laporan Perubahan Status Storage Hasil Pemrosesan PKM Periode '.$rows[0]['pkm_periodeproses'].'.csv';

//        dd($rows);

        $headers = [
            "Content-type" => "text/csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];
        $file = fopen($filename, 'w');
        fputcsv($file, $columnHeader, '|');
        foreach ($rows as $row) {
            fputcsv($file, $row, '|');
        }
        fclose($file);
        return response()->download($filename, $filename, $headers)->deleteFileAfterSend(true);
    }

    public function printStatusStorage(){
        $perusahaan = DB::connection(Session::get('connection'))
            ->table('tbmaster_perusahaan')
            ->first();

        $datas = DB::connection(Session::get('connection'))->select("SELECT
                 pkm_prdcd,
                 pkm_mindisplay,
                 pkm_minorder,
                 round(pkm_qtyaverage,2) pkm_qtyaverage,
                 SUBSTR (pkm_periode1, 1, 2) || '-' || SUBSTR (pkm_periode1, 3, 4)
                    pkm_periode1,
                 pkM_qty1,
                 pkm_hari1,
                 SUBSTR (pkm_periode2, 1, 2) || '-' || SUBSTR (pkm_periode2, 3, 4)
                    pkm_periode2,
                 pkM_qty2,
                 pkm_hari2,
                 SUBSTR (pkm_periode3, 1, 2) || '-' || SUBSTR (pkm_periode3, 3, 4)
                    pkm_periode3,
                 pkM_qty3,
                 pkm_hari3,
                 pkm_pkmt,
                 pkm_kodesupplier,
                 to_char(pkm_koefisien) pkm_koefisien,
                 to_char(to_date(pkm_periodeproses,'mmyyyy'),'MON-YY') pkm_periodeproses,
                 to_char(NVL (NVL (pkm_adjust_dt, pkm_modify_dt), pkm_create_dt),'dd-MON-yy') || ' - '||
                 NVL (NVL (pkm_adjust_by, pkm_modify_by), pkm_create_by) pkm_edit, pkm_last_pkm, pkm_adjust_by,
                 NVL (lks_maxdisplay, 0) maxdisplay,
                 NVL (mpt_maxqty * prd_frac, 0) maxpallet,
                 pkm_mpkm, nvl(pkm_qtymplus,0) pkm_qtyminor
            FROM tbmaster_perusahaan,
                 tbmaster_kkpkm,
                 tbmaster_prodmast,
                 tbmaster_maxpalet,
                 (SELECT lks_prdcd, lks_maxdisplay
                    FROM tbmaster_lokasi
                   WHERE     LKS_MAXDISPLAY IS NOT NULL
                        AND LKS_JENISRAK IN ('D', 'N')
                        AND (   (LKS_KODERAK LIKE 'R%' OR LKS_KODERAK LIKE 'O%')
                        OR (    LKS_KODERAK LIKE 'D%'
                        AND EXISTS
                        (SELECT 1 FROM TBMASTER_PRODMAST, TBMASTER_PRODCRM
                         WHERE PRD_PRDCD = PRC_PLUIGR
                         AND PRD_FLAGIDM = 'Y'
                         AND LKS_PRDCD = PRD_PRDCD))))
           WHERE     prs_kodeigr = '".Session::get('kdigr')."'
                 AND prs_kodeigr = pkm_kodeigr
                 AND pkm_prdcd = prd_prdcd
                 AND prd_kodedivisi IN ('1', '2', '3')   -- khusus dry product
                 AND pkm_prdcd = mpt_prdcd(+)
                 AND pkm_prdcd = lks_prdcd(+)
                 AND pkm_periodeproses = (select pkm_periodeproses
            from (
            select count(1) cnt, pkm_periodeproses
            from tbmaster_kkpkm
            group by pkm_periodeproses
            order by cnt desc
            )
            where rownum=1)
            --and rownum <= 10
        ORDER BY pkm_prdcd");

        $p_rowsk = 80;
        $p_rowsb = 130;

        $v_prsnsk = round((($p_rowsk / $p_rowsb) * 50));

        foreach($datas as $data){
            $v_qtysk = round($data->maxpallet * $v_prsnsk / 100);

            $v_pkmt50minor = $data->pkm_last_pkm + $data->pkm_qtyminor + round($data->pkm_minorder * 50 / 100);

            if($v_pkmt50minor > $v_qtysk)
                $data->cp_laststatus = 'S';
            else if($v_pkmt50minor > $data->maxdisplay && $v_pkmt50minor < $v_qtysk)
                $data->cp_laststatus = 'SK';
            else if($v_pkmt50minor <= $data->maxdisplay)
                $data->cp_laststatus = 'NS';
            else $data->cp_laststatus = '';

            $v_pkmt50minor = ($data->pkm_mpkm + $data->pkm_qtyminor) + round($data->pkm_minorder * 50 / 100);

            if($v_pkmt50minor > $v_qtysk)
                $data->cp_status = 'S';
            else if($v_pkmt50minor > $data->maxdisplay && $v_pkmt50minor < $v_qtysk)
                $data->cp_status = 'SK';
            else if($v_pkmt50minor <= $data->maxdisplay)
                $data->cp_status = 'NS';
            else $data->cp_status = '';

            $data->cp_adjstatus = '';
            if($data->pkm_adjust_by){
                $v_pkmt50minor = $data->pkm_pkmt + round($data->pkm_minorder * 50 / 100);

                if($v_pkmt50minor > $v_qtysk)
                    $data->cp_adjstatus = 'S';
                else if($v_pkmt50minor > $data->maxdisplay && $v_pkmt50minor < $v_qtysk)
                    $data->cp_adjstatus = 'SK';
                else if($v_pkmt50minor <= $data->maxdisplay)
                    $data->cp_adjstatus = 'NS';
            }

            unset($data->pkm_last_pkm);
            unset($data->pkm_adjust_by);
            unset($data->maxdisplay);
            unset($data->maxpallet);
            unset($data->pkm_mpkm);
            unset($data->pkm_qtyminor);
        }

//        dd($datas);

//        $columnHeader = [
//            'PLU',
//            'Qty Min Disp',
//            'Qty Min Ord',
//            'Avg Sales 3 bulan',
//            'Bulan 1',
//            'Sales (qty)',
//            'Hari',
//            'Bulan 2',
//            'Sales (qty)',
//            'Hari',
//            'Bulan 3',
//            'Sales (qty)',
//            'Hari',
//            'PKM',
//            'Kode Supplier',
//            'N',
//            'Periode proses',
//            'Tgl edit PKM',
//            'Sebelum Proses PKM',
//            'Usulan (by program)',
//            'Adjust (by user)'
//        ];
//
//        $rows = collect($datas)->map(function ($x) {
//            return (array)$x;
//        })->toArray();

//        dd($rows);
//        return view('BACKOFFICE.PKM.status-storage-xlsx', compact(['perusahaan', 'datas']));

        $title = 'Laporan Perubahan Status Storage Hasil Pemrosesan PKM';
        $subtitle = 'Periode : '.$datas[0]->pkm_periodeproses;
        $keterangan = '';
        $filename = str_replace('/','',$title).'_'.Carbon::now()->format('dmY_His').'.xlsx';
        $view = view('BACKOFFICE.PKM.status-storage-xlsx', compact(['perusahaan', 'datas']))->render();
        ExcelController::create($view,$filename,$title,$subtitle,$keterangan);
        return response()->download(storage_path($filename))->deleteFileAfterSend(true);
    }

    public function process(Request $request){
        set_time_limit(0);

        $periode = $request->periode;
        $plu = $request->plu;
        $periode1 = $request->periode1;
        $periode2 = $request->periode2;
        $periode3 = $request->periode3;
        $hitungulang = $request->hitungulang;

        if($hitungulang == 'Y'){
            $calculate = self::reCalculate($periode1);

            if($calculate['error'])
                return response()->json($calculate,500);

            $calculate = self::reCalculate($periode2);

            if($calculate['error'])
                return response()->json($calculate,500);

            $calculate = self::reCalculate($periode3);

            if($calculate['error'])
                return response()->json($calculate,500);
        }

        if($plu == '0000000'){
            $plu = 'ALL';
        }

        $connection = loginController::getConnectionProcedure();

        $exec = oci_parse($connection, "BEGIN sp_proses_pkm (
                  '".Session::get('kdigr')."',
                  '".$plu."',
                  '".Session::get('usid')."',
                  to_date('".$periode."','mm/yyyy'),
                  to_date('".$periode1."','mm/yyyy'),
                  to_date('".$periode2."','mm/yyyy'),
                  to_date('".$periode3."','mm/yyyy'),
                  null,
                  null,
                  null,
                  null,
                  null,
                  null,
                  null,
                  null,
                  'T',
                  :v_result); END;");
        oci_bind_by_name($exec, ':v_result', $v_result,1000);
        oci_execute($exec);

        if($v_result){
            return response()->json([
                'message' => 'Proses Hitung PKM gagal!',
                'error' => v_result
            ], 500);
        }
        else{
            return response()->json([
                'message' => 'Data PKM selesai diproses!',
                'error' => ''
            ], 200);
        }
    }

    static function reCalculate($periode){
        $connection = loginController::getConnectionProcedure();

        $exec = oci_parse($connection, "BEGIN sp_hitung_pkmsales(to_date('".$periode."','mm/yyyy'), '".Session::get('usid')."', :v_message); END;");
        oci_bind_by_name($exec, ':v_message', $v_message,1000);
        oci_execute($exec);

        if($v_message){
            return [
                'message' => 'Hitung ulang '.$periode.' gagal!',
                'error' => $v_message
            ];
        }
        else{
            return [
                'message' => 'Hitung ulang '.$periode.' sukses!',
                'error' => ''
            ];
        }
    }

    public function printRPSI(Request $request){
        $perusahaan = DB::connection(Session::get('connection'))
            ->table('tbmaster_perusahaan')
            ->first();

        $data = DB::connection(Session::get('connection'))
            ->select("SELECT distinct pkm_prdcd,
                   prd_deskripsipanjang,
                   CASE
                      WHEN NVL (prc_pluigr, '1234567') = '1234567' THEN 'N'
                      ELSE 'Y'
                   END
                      idmomi,
                   prd_kodetag,
                   prd_frac,
                   prd_minorder,
                   pkm_qtyaverage,
                   pkm_pkmt,
                   (pkm_pkmt + (pkm_minorder / 2)) pkmtmin,
                   (mpt_maxqty * prd_frac) mpt_maxqty,
                   lks_maxdisplay,
                   CASE WHEN NVL (pln_jenisrak, 'A') = 'N' THEN 'NS' ELSE 'S' END status,
                   CASE
                      WHEN pkm_pkmt <= lks_maxdisplay
                      THEN
                         'NS'
                      ELSE
                         CASE
                            WHEN (pkm_pkmt - lks_maxdisplay) BETWEEN   (  (  mpt_maxqty
                                                                           * prd_frac)
                                                                        / 4)
                                                                     + 1
                                                                 AND (  (  mpt_maxqty
                                                                         * prd_frac)
                                                                      / 2)
                            THEN
                               'SK'
                            ELSE
                               CASE
                                  WHEN (pkm_pkmt - lks_maxdisplay) BETWEEN 0
                                                                       AND (  (  mpt_maxqty
                                                                               * prd_frac)
                                                                            / 4)
                                  THEN
                                     'SKC'
                                  ELSE
                                     CASE
                                        WHEN (pkm_pkmt - lks_maxdisplay) >
                                                ( (mpt_maxqty * prd_frac) / 2)
                                        THEN
                                           'S'
                                        ELSE
                                           'A'
                                     END
                               END
                         END
                   END
                      rekomendasi
              FROM tbmaster_kkpkm,
                   tbmaster_prodmast,
                   tbmaster_prodcrm,
                   tbmaster_lokasi,
                   tbmaster_maxpalet,
                   tbmaster_pluplano
             WHERE pkm_periodeproses = '".str_replace('/','',$request->periode)."'
                   AND prd_prdcd = pkm_prdcd
                   AND prc_pluigr = prd_prdcd
                   AND lks_prdcd = prd_prdcd
                   AND SUBSTR (lks_koderak, 1, 1) IN ('R', 'O')
                   AND lks_jenisrak IN ('D', 'N')
                   AND mpt_Prdcd = prd_prdcd
                   AND pln_prdcd = prd_prdcd");

        $periode = '01/'.$request->periode;

        return view('BACKOFFICE.PKM.proses-kertas-kerja-rpsi-pdf')->with(compact([
            'perusahaan','data','periode',
        ]));
    }
}
