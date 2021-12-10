<?php

namespace App\Http\Controllers\BACKOFFICE\PKM;

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
        return view('BACKOFFICE.PKM.kertas-kerja');
    }

    public function getLovPrdcd(){
        $data = DB::connection(Session::get('connection'))->select("select prd_deskripsipendek desk, prd_prdcd plu, prd_unit || '/' || prd_frac konversi, prd_hrgjual from tbmaster_prodmast
            where prd_kodeigr = '".Session::get('kdigr')."'
            and substr(prd_Prdcd,7,1) = '0'
            order by prd_deskripsipendek");

        return DataTables::of($data)->make(true);
    }

    public function getHistory(){
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
                           THEN pkm_create_dt || ' - ' || pkm_create_by
                       ELSE pkm_modify_dt || ' - ' || pkm_modify_by
                   END proses,
                   CASE
                       WHEN pkm_adjust_by IS NOT NULL
                           THEN pkm_adjust_dt || ' - ' || pkm_adjust_by
                   END adjust
              FROM tbmaster_kkpkm, tbmaster_prodmast, tbmaster_supplier
             WHERE pkm_kodeigr = '".Session::get('kdigr')."'
                and pkm_prdcd in (select pkm_prdcd from tbmaster_kkpkm where pkm_periodeproses is not null AND exists (select 1 from tbmaster_prodmast where prd_prdcd = pkm_prdcd and prd_kodedivisi IN ('1', '2', '3')))
               AND prd_kodeigr(+) = pkm_kodeigr
               AND prd_prdcd(+) = pkm_prdcd
               AND sup_kodeigr(+) = pkm_kodeigr
               AND sup_kodesupplier(+) = pkm_kodesupplier
               AND pkm_periodeproses IS NOT NULL
               order by pkm_prdcd asc)");

        return DataTables::of($data)->make(true);
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
                'pkm_adjust_dt' => DB::RAW("SYSdATE")
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
                            'pkmg_create_dt' => DB::RAW("SYSDATE"),
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
                            'pkmg_modify_dt' => DB::RAW("SYSDATE"),
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
                 pkm_qtyaverage,
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
}
