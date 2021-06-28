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

class PluTimbanganController extends Controller
{
    public function index(){
        return view('TABEL.plutimbangan');
    }

    public function StartNew(){
        $jenistmb = DB::table('tbMaster_Perusahaan')
            ->selectRaw("nvl(PRS_JENISTIMBANGAN,'q') a")
            ->first();

        $persh_cur = DB::table('TBMASTER_PERUSAHAAN')
            ->selectRaw("PRS_IPSERVER, PRS_USERSERVER, PRS_PWDSERVER, nvl(PRS_JENISTIMBANGAN,'q') jenistmb")
            ->first();

        return response()->json($persh_cur);
    }

    public function LovPlu(Request $request){
        $search = $request->value;

        $datas   = DB::table('TBMASTER_PRODMAST')
            ->selectRaw("PRD_DESKRIPSIPANJANG,PRD_PRDCD, TO_CHAR(PRD_FRAC)||'/'||PRD_UNIT AS SATUAN, PRD_KODETAG, PRD_HRGJUAL, rownum num")

            ->where('prd_prdcd','LIKE', '%'.$search.'%')
            ->whereRaw("substr(prd_prdcd,7,1) = '1'")
            ->where('prd_kodeigr','=',$_SESSION['kdigr'])

            ->orWhere('prd_deskripsipanjang','LIKE', '%'.$search.'%')
            ->whereRaw("substr(prd_prdcd,7,1) = '1'")
            ->where('prd_kodeigr','=',$_SESSION['kdigr'])

            ->orderBy('PRD_DESKRIPSIPANJANG')
            ->limit(100)
            ->get();

        return Datatables::of($datas)->make(true);

//        return response()->json($data);
    }

    public function GetPlu(Request $request){
        $search = $request->plu;

        $data   = DB::table('TBMASTER_PRODMAST')
            ->selectRaw("PRD_DESKRIPSIPANJANG,PRD_PRDCD, TO_CHAR(PRD_FRAC)||'/'||PRD_UNIT AS SATUAN, PRD_KODETAG, PRD_HRGJUAL, rownum num")

            ->where('prd_prdcd','=', $search)
            ->whereRaw("substr(prd_prdcd,7,1) = '1'")
            ->where('prd_kodeigr','=',$_SESSION['kdigr'])

            ->orderBy('PRD_DESKRIPSIPANJANG')
            ->first();

        return response()->json($data);
    }

    public function Save(Request $request){
        try {
            $kode = $request->kode;
            $plu = $request->plu;
            $desk = $request->desk;

            $tempkd   = DB::table('tbtabel_plutimbangan')
                ->selectRaw("nvl(count(1),0) a")
                ->where('tmb_kode','=', $kode)
                ->first();

            $temppr = DB::table('tbtabel_plutimbangan')
                ->selectRaw("nvl(count(1),0) a")
                ->whereRaw("tmb_prdcd = substr('$plu',1,6)||'0'")
                ->first();

            if((int)($tempkd->a) > 0){
                //kode sudah ada
                return response()->json(1);
            }else if((int)($tempkd->a) == 0 && (int)($temppr->a) == 0){
                DB::beginTransaction();
                DB::table('tbtabel_plutimbangan')
                    ->insert([
                        'tmb_kodeigr' => $_SESSION['kdigr'],
                        'tmb_prdcd' => substr($plu,1,6).'0',
                        'tmb_kode' => $kode,
                        'tmb_deskripsi1' => $desk,
                        'tmb_create_by' => $_SESSION['usid'],
                        'tmb_create_dt' => DB::RAW("SYSDATE")
                    ]);
                DB::commit();
                return response()->json(2);
            }else if((int)($temppr->a) != 0){
                DB::beginTransaction();
                DB::table('tbtabel_plutimbangan')
                    ->where('tmb_prdcd', '=',substr($plu,1,6).'0')
                    ->update(['tmb_kode' => $kode, 'tmb_deskripsi1' => $desk, 'tmb_MODIFY_BY' => $_SESSION['usid'], 'tmb_MODIFY_DT' => DB::RAW("SYSDATE")]);
                DB::commit();
                return response()->json(3);
            }
        }catch (\Exception $e){
            return response()->json(0);
        }
    }

    public function preHapus(Request $request){
        $plu = $request->plu;
        $temptmb = DB::select("SELECT NVL (COUNT (1), 0) a
      FROM TBMASTER_PRODMAST, tbtabel_plutimbangan
     WHERE prd_prdcd = tmb_prdcd and tmb_PRDCD = substr('$plu',1,6)||'0'");

        return response()->json($temptmb[0]->a);
    }

    public function Hapus(Request $request)
    {
        $plu = $request->plu;
        $kode = $request->kode;
        $jenis_tmb = $request->jenis_tmb;
        $lnew1 = $request->lnew1;
        $lnew2 = $request->lnew2;
        $kodeigr = $_SESSION['kdigr'];

        $dir1 = "S:\LREMOTE\HAPUS.txt";
        $dir2 = "S:\LREMOTE\ISHIDA\HAPUS.txt";
        $dir3 = "S:\LREMOTE\BIZERBA\HAPUS.txt";
        $judul = '';
        $isi = '';

        DB::beginTransaction();
        $temptmb = DB::select("SELECT NVL (COUNT (1), 0) a
      FROM TBMASTER_PRODMAST, tbtabel_plutimbangan
     WHERE prd_prdcd = tmb_prdcd and tmb_PRDCD = substr('$plu',1,6)||'0'");
        if($temptmb[0]->a != 0){
            $tempPrd = DB::select("SELECT PRD_KODETAG, PRD_UNIT, PRD_HRGJUAL, PRD_DESKRIPSIPENDEK,
               SUBSTR (PRD_PRDCD, 6) || '1' AS PRD_PRDCD
          FROM TBMASTER_PRODMAST
         WHERE PRD_KODEIGR = '$kodeigr' AND PRD_PRDCD = SUBSTR ('$plu', 1, 6) || '1'");

            $tempPrmd = DB::select("SELECT NVL (COUNT (1), 0) AS FPROMO
          FROM tbtr_promomd
         WHERE PRMd_PRDCD = '$plu' AND TRUNC (SYSDATE) BETWEEN PRMd_TGLawal AND PRMd_TGLAKHIR");

            if(($tempPrmd[0]->fpromo) > 0){
                $hrgpromo = DB::table('tbtr_promomd')
                    ->selectRaw('PRMd_HRGJUAL')
                    ->where('PRMd_PRDCD','=',$plu)
                    ->first();
            }
            if($jenis_tmb != '3'){
//                if(file_exists("S:/LREMOTE/")){
//                    //do nothing
//                    null;
//                }else{
//                    mkdir("S:/LREMOTE/");
//                }
//                if(file_exists("S:/LREMOTE/ISHIDA/")){
//                    //do nothing
//                    null;
//                }else{
//                    mkdir("S:/LREMOTE/ISHIDA/");
//                }
//                if(file_exists("S:/LREMOTE/BIZERBA/")){
//                    //do nothing
//                    null;
//                }else{
//                    mkdir("S:/LREMOTE/BIZERBA/");
//                }

                //-- HAPUS TRUS BIKIN BARU --
                if(file_exists($dir1)){
                    if($lnew1){
                        unlink($dir1);
                        if($jenis_tmb != '2'){
                            $judul = "Plu_No,LabelFormat,BestBefore,UnitPrice,PosCode,Font1,Desc1";
                        }
                        if(($tempPrmd[0]->fpromo) > 0){
                            if($jenis_tmb != '2'){
                                $isi = $kode.",0,0,".($hrgpromo->prmd_hrgjual).',"'.($tempPrd[0]->prd_prdcd).'",1,"'.($tempPrd[0]->prd_deskripsipendek).'"';
                            }else{
                                $isi = $kode.",0,0,".(string)(round((float)$tempPrd[0]->prd_hrgjual)).',"'.($tempPrd[0]->prd_prdcd).'",1,"'.($tempPrd[0]->prd_deskripsipendek).'"';
                            }
                        }else{
                            if($jenis_tmb != '2'){
                                $isi = $kode.",0,0,".($tempPrd[0]->prd_hrgjual).',"'.($tempPrd[0]->prd_prdcd).'",1,"'.($tempPrd[0]->prd_deskripsipendek).'"';
                            }else{
                                $isi = $kode.",0,0,".(string)(round((float)$tempPrd[0]->prd_hrgjual)).',"'.($tempPrd[0]->prd_prdcd).'",1,"'.($tempPrd[0]->prd_deskripsipendek).'"';
                            }
                        }
                        $out_file = fopen($dir1, "w") or die("Unable to open file!");
                        $vnum = 1; //what is dis for?
                        if($judul != ''){
                            fwrite($out_file, $judul.chr(13).chr(10));
                        }
                        fwrite($out_file, $isi);
                        fclose($out_file);
                        DB::table("TBTABEL_PLUTIMBANGAN")
                            ->where('TMB_KODEIGR','=',$kodeigr)
                            ->whereRaw("TMB_PRDCD = substr('$plu',1,6)||'0'")
                            ->where('TMB_KODE','=',$kode)
                            ->delete();
                    }else{
                        // GABUNGAN
                        $in_file = fopen($dir1, "r") or die("Unable to open file!");
                        $index = 0;
                        $sub_isi_txt=[];
                        //menampung data perbaris
                        while(! feof($in_file))
                        {
                            $sub_isi_txt[$index] = fgets($in_file);
                            $index++;
                        }
                        fclose($in_file);

                        //delete file txt
                        unlink($dir1);
                        if(($tempPrmd[0]->fpromo) > 0){
                            if($jenis_tmb != '2'){
                                $isi = $kode.",0,0,".($hrgpromo->prmd_hrgjual).',"'.($tempPrd[0]->prd_prdcd).'",1,"'.($tempPrd[0]->prd_deskripsipendek).'"';
                            }else{
                                $isi = $kode.",0,0,".(string)(round((float)$tempPrd[0]->prd_hrgjual)).',"'.($tempPrd[0]->prd_prdcd).'",1,"'.($tempPrd[0]->prd_deskripsipendek).'"';
                            }
                        }else{
                            if($jenis_tmb != '2'){
                                $isi = $kode.",0,0,".($tempPrd[0]->prd_hrgjual).',"'.($tempPrd[0]->prd_prdcd).'",1,"'.($tempPrd[0]->prd_deskripsipendek).'"';
                            }else{
                                $isi = $kode.",0,0,".(string)(round((float)$tempPrd[0]->prd_hrgjual)).',"'.($tempPrd[0]->prd_prdcd).'",1,"'.($tempPrd[0]->prd_deskripsipendek).'"';
                            }
                        }
                        $out_file = fopen($dir1, "w") or die("Unable to open file!");
                        for($i=0;$i<$index;$i++){
                            fwrite($out_file, $sub_isi_txt[$i].chr(13).chr(10));
                        }
                        if($judul!=''){ //pasti kosong isi nilai judul :v
                            fwrite($out_file, $judul.chr(13).chr(10));
                        }
                        fwrite($out_file, $isi);
                        fclose($out_file);
                    }
                }else{
                    if($jenis_tmb != '2'){
                        $judul = "Plu_No,LabelFormat,BestBefore,UnitPrice,PosCode,Font1,Desc1";
                    }
                    if(($tempPrmd[0]->fpromo) > 0){
                        if($jenis_tmb != '2'){
                            $isi = $kode.",0,0,".($hrgpromo->prmd_hrgjual).',"'.($tempPrd[0]->prd_prdcd).'",1,"'.($tempPrd[0]->prd_deskripsipendek).'"';
                        }else{
                            $isi = $kode.",0,0,".(string)(round((float)$tempPrd[0]->prd_hrgjual)).',"'.($tempPrd[0]->prd_prdcd).'",1,"'.($tempPrd[0]->prd_deskripsipendek).'"';
                        }
                    }else{
                        if($jenis_tmb != '2'){
                            $isi = $kode.",0,0,".($tempPrd[0]->prd_hrgjual).',"'.($tempPrd[0]->prd_prdcd).'",1,"'.($tempPrd[0]->prd_deskripsipendek).'"';
                        }else{
                            $isi = $kode.",0,0,".(string)(round((float)$tempPrd[0]->prd_hrgjual)).',"'.($tempPrd[0]->prd_prdcd).'",1,"'.($tempPrd[0]->prd_deskripsipendek).'"';
                        }
                    }
                    $out_file = fopen($dir1, "w") or die("Unable to open file!");
                    if($judul!=''){ //pasti ada isinya:v
                        fwrite($out_file, $judul.chr(13).chr(10));
                    }
                    fwrite($out_file, $isi);
                    fclose($out_file);
                }
            }else{
                //-- HAPUS TRUS BIKIN BARU --
                if(file_exists($dir2)){
                    if($lnew2){
                        unlink($dir2);
                        $judul = "Plu_No,LabelFormat,BestBefore,UnitPrice,PosCode,Font1,Desc1";
                        if(($tempPrmd[0]->fpromo) > 0){
                            if($jenis_tmb != '2'){
                                $isi = $kode.",0,0,".($hrgpromo->prmd_hrgjual).',"'.($tempPrd[0]->prd_prdcd).'",1,"'.($tempPrd[0]->prd_deskripsipendek).'"';
                            }else{
                                $isi = $kode.",0,0,".(string)(round((float)$tempPrd[0]->prd_hrgjual)).',"'.($tempPrd[0]->prd_prdcd).'",1,"'.($tempPrd[0]->prd_deskripsipendek).'"';
                            }
                        }else{
                            if($jenis_tmb != '2'){
                                $isi = $kode.",0,0,".($tempPrd[0]->prd_hrgjual).',"'.($tempPrd[0]->prd_prdcd).'",1,"'.($tempPrd[0]->prd_deskripsipendek).'"';
                            }else{
                                $isi = $kode.",0,0,".(string)(round((float)$tempPrd[0]->prd_hrgjual)).',"'.($tempPrd[0]->prd_prdcd).'",1,"'.($tempPrd[0]->prd_deskripsipendek).'"';
                            }
                        }
                        $out_file = fopen($dir2, "w") or die("Unable to open file!");
                        fwrite($out_file, $judul.chr(13).chr(10));
                        fwrite($out_file, $isi);
                        fclose($out_file);
                    }else{
                        // GABUNGAN
                        $in_file = fopen($dir2, "r") or die("Unable to open file!");
                        $index = 0;
                        $sub_isi_txt=[];
                        //menampung data perbaris
                        while(! feof($in_file))
                        {
                            $sub_isi_txt[$index] = fgets($in_file);
                            $index++;
                        }
                        fclose($in_file);

                        //delete file txt
                        unlink($dir2);
                        if(($tempPrmd[0]->fpromo) > 0){
                            if($jenis_tmb != '2'){
                                $isi = $kode.",0,0,".($hrgpromo->prmd_hrgjual).',"'.($tempPrd[0]->prd_prdcd).'",1,"'.($tempPrd[0]->prd_deskripsipendek).'"';
                            }else{
                                $isi = $kode.",0,0,".(string)(round((float)$tempPrd[0]->prd_hrgjual)).',"'.($tempPrd[0]->prd_prdcd).'",1,"'.($tempPrd[0]->prd_deskripsipendek).'"';
                            }
                        }else{
                            if($jenis_tmb != '2'){
                                $isi = $kode.",0,0,".($tempPrd[0]->prd_hrgjual).',"'.($tempPrd[0]->prd_prdcd).'",1,"'.($tempPrd[0]->prd_deskripsipendek).'"';
                            }else{
                                $isi = $kode.",0,0,".(string)(round((float)$tempPrd[0]->prd_hrgjual)).',"'.($tempPrd[0]->prd_prdcd).'",1,"'.($tempPrd[0]->prd_deskripsipendek).'"';
                            }
                        }
                        $out_file = fopen($dir2, "w") or die("Unable to open file!");
                        for($i=0;$i<$index;$i++){
                            fwrite($out_file, $sub_isi_txt[$i].chr(13).chr(10));
                        }
                        fwrite($out_file, $isi);
                        fclose($out_file);
                    }
                }else{
                    $judul = "Plu_No,LabelFormat,BestBefore,UnitPrice,PosCode,Font1,Desc1";
                    if(($tempPrmd[0]->fpromo) > 0){
                        if($jenis_tmb != '2'){
                            $isi = $kode.",0,0,".($hrgpromo->prmd_hrgjual).',"'.($tempPrd[0]->prd_prdcd).'",1,"'.($tempPrd[0]->prd_deskripsipendek).'"';
                        }else{
                            $isi = $kode.",0,0,".(string)(round((float)$tempPrd[0]->prd_hrgjual)).',"'.($tempPrd[0]->prd_prdcd).'",1,"'.($tempPrd[0]->prd_deskripsipendek).'"';
                        }
                    }else{
                        if($jenis_tmb != '2'){
                            $isi = $kode.",0,0,".($tempPrd[0]->prd_hrgjual).',"'.($tempPrd[0]->prd_prdcd).'",1,"'.($tempPrd[0]->prd_deskripsipendek).'"';
                        }else{
                            $isi = $kode.",0,0,".(string)(round((float)$tempPrd[0]->prd_hrgjual)).',"'.($tempPrd[0]->prd_prdcd).'",1,"'.($tempPrd[0]->prd_deskripsipendek).'"';
                        }
                    }
                    $out_file = fopen($dir2, "w") or die("Unable to open file!");
                    fwrite($out_file, $judul.chr(13).chr(10));
                    fwrite($out_file, $isi);
                    fclose($out_file);

                }
                if(($tempPrmd[0]->fpromo) > 0){
                    if($jenis_tmb != '2'){
                        $isi = $kode.",0,0,".($hrgpromo->prmd_hrgjual).',"'.($tempPrd[0]->prd_prdcd).'",1,"'.($tempPrd[0]->prd_deskripsipendek).'"';
                    }else{
                        $isi = $kode.",0,0,".(string)(round((float)$tempPrd[0]->prd_hrgjual)).',"'.($tempPrd[0]->prd_prdcd).'",1,"'.($tempPrd[0]->prd_deskripsipendek).'"';
                    }
                }else{
                    if($jenis_tmb != '2'){
                        $isi = $kode.",0,0,".($tempPrd[0]->prd_hrgjual).',"'.($tempPrd[0]->prd_prdcd).'",1,"'.($tempPrd[0]->prd_deskripsipendek).'"';
                    }else{
                        $isi = $kode.",0,0,".(string)(round((float)$tempPrd[0]->prd_hrgjual)).',"'.($tempPrd[0]->prd_prdcd).'",1,"'.($tempPrd[0]->prd_deskripsipendek).'"';
                    }
                }
                $out_file = fopen($dir3, "w") or die("Unable to open file!");
                fwrite($out_file, $judul.chr(13).chr(10));
                fwrite($out_file, $isi);
                fclose($out_file);
            }
        }
        DB::table("tbtabel_plutimbangan")
            ->where('tmb_kodeigr','=',$kodeigr)
            ->where('tmb_prdcd','=',$plu)
            ->where('tmb_kode','=',$kode)
            ->delete();
        DB::commit();
    }

    public function shareDir(){
        $ip = $ip = $_SESSION['ip'];
        //$dir = "S:\\";
//        system('net use S:  /delete');//tidak perlu delete, karena bila drive S: sudah di mapping, maka meski di mapping kembali tidak masalah
        system('net use S: "\\\\'.$ip.'\share"  /persistent:no>nul 2>&1');
//        if(file_exists($dir)){
//            return response()->json(false); //mengembalikan false bila file ada
//        }else{
//            return response()->json(true); //mengembalikan true bila file tidak ada agar memicu trigger if
//        }

        if(file_exists("S:/LREMOTE/")){
            //do nothing
            null;
        }else{
            mkdir("S:/LREMOTE/");
        }
        if(file_exists("S:/LREMOTE/ISHIDA/")){
            //do nothing
            null;
        }else{
            mkdir("S:/LREMOTE/ISHIDA/");
        }
        if(file_exists("S:/LREMOTE/BIZERBA/")){
            //do nothing
            null;
        }else{
            mkdir("S:/LREMOTE/BIZERBA/");
        }
    }

    public function CheckDir(Request $request){
        $path = $request->path;
        $ip = $_SESSION['ip'];
        $dir = "S:".$path;
        if(file_exists($dir)){
            return response()->json(true);
        }else{
            return response()->json(false);
        }
    }


    public function Transfer(Request $request)
    {
        $kodeigr = $_SESSION['kdigr'];
        $date1 = $request->date1; //YYYY-MM-DD <-ubahlah jadi
        $date2 = $request->date2;
        $jenis_tmb = $request->jenis_tmb;
        $alert_button1_1 = $request->alert_button1_1;
        $alert_button1_2 = $request->alert_button1_2;
        $alert_button1_3 = $request->alert_button1_3;
        $alert_button1_4 = $request->alert_button1_4;

        $dir1 = "S:\LREMOTE\UPDATE.txt";
        $dir1csv = "S:\LREMOTE\UPDATE.csv";
        $dir2 = "S:\LREMOTE\ISHIDA\UPDATE.txt";
        $dir2csv = "S:\LREMOTE\ISHIDA\UPDATE.csv";
        $dir3 = "S:\LREMOTE\BIZERBA\UPDATE.txt";
        $dir3csv = "S:\LREMOTE\BIZERBA\UPDATE.csv";

        $judul = '';
        $isi = '';

//        if(file_exists("S:/LREMOTE/")){
//            //do nothing
//            null;
//        }else{
//            mkdir("S:/LREMOTE/");
//        }
//        if(file_exists("S:/LREMOTE/ISHIDA/")){
//            //do nothing
//            null;
//        }else{
//            mkdir("S:/LREMOTE/ISHIDA/");
//        }
//        if(file_exists("S:/LREMOTE/BIZERBA/")){
//            //do nothing
//            null;
//        }else{
//            mkdir("S:/LREMOTE/BIZERBA/");
//        }
        //step 1
        if($jenis_tmb != '3'){
            if(file_exists($dir1)){
                //step 2 //alert button('update')
                if($alert_button1_1){
                    if($jenis_tmb != '2'){
                        $judul = 'Plu_No,SalesMode,LabelFormat,BestBefore,UnitPrice,PosCode,Font1,Desc1';
                    }
                    //step 3
                    $out_file = fopen($dir1, "w") or die("Unable to open file!");
                    fwrite($out_file, $judul.chr(13).chr(10));

                    $rec = DB::select("SELECT   TMB_PRDCD, RPAD(TMB_KODE,4,' ') TMB_KODE, SUBSTR (PRD_PRDCD, 1, 6) || '1' AS PRD_PRDCD,
                              PRD_UNIT, to_char(PRD_HRGJUAL,'9999999999.99') PRD_HRGJUAL, --add 2 koma (kmy gak bisa proses)
                              PRD_DESKRIPSIPENDEK, to_char(PRMd_HRGJUAL,'9999999999.99') PRMd_HRGJUAL, --add 2 koma (kmy gak bisa proses)
                              PRMd_JENISDISC
                         FROM TBTABEL_PLUTIMBANGAN, TBMASTER_PRODMAST, tbtr_promomd
                        WHERE CASE
                                  WHEN TMB_MODIFY_DT IS NOT NULL
                                      THEN TO_CHAR (TMB_MODIFY_DT, 'YYYY-MM-DD')
                                  ELSE TO_CHAR (TMB_CREATE_DT, 'YYYY-MM-DD')
                              END BETWEEN TO_CHAR ('$date1', 'YYYY-MM-DD')
                                      AND TO_CHAR ('$date2', 'YYYY-MM-DD')
                          AND TO_CHAR (PRD_PRDCD) = SUBSTR (TMB_PRDCD, 1, 6) || '1'
                          AND PRMd_PRDCD(+) = PRD_PRDCD
                          AND nvl(PRD_KODETAG,'q') NOT IN ('N', 'X')
                          AND TRUNC (SYSDATE) BETWEEN PRMd_TGLawal(+) AND PRMd_TGLAKHIR(+)
                          AND TMB_KODEIGR = '$kodeigr'
                     ORDER BY TMB_KODE");

                    for($i=0;$i<sizeof($rec);$i++){
                        if($rec[$i]->prmd_hrgjual > 0){
                            if($rec[$i]->prmd_jenisdisc == 'T'){
                                //step 4
                                $isi = $rec[$i]->tmb_kode;
                                if($rec[$i]->prd_unit == 'KG'){
                                    $isi = $isi.',0,';
                                }else{
                                    $isi = $isi.',1,';
                                }
                                $isi = $isi.'0,0,'.($rec[$i]->prmd_hrgjual).',"'.($rec[$i]->prd_prdcd).'",1,"'.rtrim($rec[$i]->prd_deskripsipendek).'"';
                            }else{
                                //step 5
                                $isi = $rec[$i]->tmb_kode;
                                if($rec[$i]->prd_unit == 'KG'){
                                    $isi = $isi.',0,';
                                }else{
                                    $isi = $isi.',1,';
                                }
                                $isi = $isi.'0,0,'.($rec[$i]->prd_hrgjual).',"'.($rec[$i]->prd_prdcd).'",1,"'.rtrim($rec[$i]->prd_deskripsipendek).'"';
                            }
                        }else{
                            //step 6
                            $isi = $rec[$i]->tmb_kode;
                            if($rec[$i]->prd_unit == 'KG'){
                                $isi = $isi.',0,';
                            }else{
                                $isi = $isi.',1,';
                            }
                            $isi = $isi.'0,0,'.($rec[$i]->prd_hrgjual).',"'.($rec[$i]->prd_prdcd).'",1,"'.rtrim($rec[$i]->prd_deskripsipendek).'"';
                        }
                        if($jenis_tmb == '2'){
                            $isi = $rec[$i]->tmb_kode;
                            //step 7
                            if($rec[$i]->prd_unit == 'KG'){
                                $isi = $isi.',0,';
                            }else{
                                $isi = $isi.',1,';
                            }
                            $isi = $isi.'0,0,'.($rec[$i]->prd_hrgjual).',"'.($rec[$i]->prd_prdcd).'",1,"'.rtrim($rec[$i]->prd_deskripsipendek).'"';
                        }
                        fwrite($out_file, $isi.chr(13).chr(10));
                    }
                    fclose($out_file);

                    //Apa fungsinya nih!?
                    copy( $dir1, $dir1csv );
                    //client_host('cmd /c copy '|| dir1 || ' ' || substr(dir1, 1,length(dir1)-3) ||'csv', no_screen);
                    //TRANSFER BERHASIL
                }
            }else{
                //step 61
                if($jenis_tmb != '2'){
                    $judul = 'Plu_No,SalesMode,LabelFormat,BestBefore,UnitPrice,PosCode,Font1,Desc1';
                }
                //step 8
                $out_file = fopen($dir1, "w") or die("Unable to open file!");
                fwrite($out_file, $judul.chr(13).chr(10));

                //step 81
                $rec = DB::select("SELECT   TMB_PRDCD, RPAD(TMB_KODE,4,' ') TMB_KODE, SUBSTR (PRD_PRDCD, 1, 6) || '1' AS PRD_PRDCD,
                          PRD_UNIT, to_char(PRD_HRGJUAL,'9999999999.99') PRD_HRGJUAL, --add 2 koma (kmy gak bisa proses)
                          PRD_DESKRIPSIPENDEK, to_char(PRMd_HRGJUAL,'9999999999.99') PRMd_HRGJUAL, --add 2 koma (kmy gak bisa proses)
                          PRMd_JENISDISC
                     FROM TBTABEL_PLUTIMBANGAN, TBMASTER_PRODMAST, tbtr_promomd
                    WHERE CASE
                              WHEN TMB_MODIFY_DT IS NOT NULL
                                  THEN TO_CHAR (TMB_MODIFY_DT, 'YYYY-MM-DD')
                              ELSE TO_CHAR (TMB_CREATE_DT, 'YYYY-MM-DD')
                          END BETWEEN TO_CHAR ('$date1', 'YYYY-MM-DD')
                                  AND TO_CHAR ('$date2', 'YYYY-MM-DD')
                      AND TO_CHAR (PRD_PRDCD) = SUBSTR (TMB_PRDCD, 1, 6) || '1'
                      AND PRMd_PRDCD(+) = PRD_PRDCD
                      AND nvl(PRD_KODETAG,'q') NOT IN ('N', 'X')
                      AND TRUNC (SYSDATE) BETWEEN PRMd_TGLawal(+) AND PRMd_TGLAKHIR(+)
                      AND TMB_KODEIGR = '$kodeigr'
                 ORDER BY TMB_KODE");
                for($i=0;$i<sizeof($rec);$i++){
                    if($rec[$i]->prmd_hrgjual > 0){
                        if($rec[$i]->prmd_jenisdisc == 'T'){
                            $isi = $rec[$i]->tmb_kode;
                            if($rec[$i]->prd_unit == 'KG'){
                                $isi = $isi.',0,';
                            }else{
                                $isi = $isi.',1,';
                            }
                            $isi = $isi.'0,0,'.($rec[$i]->prmd_hrgjual).',"'.($rec[$i]->prd_prdcd).'",1,"'.rtrim($rec[$i]->prd_deskripsipendek).'"';
                        }else{
                            $isi = $rec[$i]->tmb_kode;
                            if($rec[$i]->prd_unit == 'KG'){
                                $isi = $isi.',0,';
                            }else{
                                $isi = $isi.',1,';
                            }
                            $isi = $isi.'0,0,'.($rec[$i]->prd_hrgjual).',"'.($rec[$i]->prd_prdcd).'",1,"'.rtrim($rec[$i]->prd_deskripsipendek).'"';
                        }
                    }else{
                        $isi = $rec[$i]->tmb_kode;
                        if($rec[$i]->prd_unit == 'KG'){
                            $isi = $isi.',0,';
                        }else{
                            $isi = $isi.',1,';
                        }
                        $isi = $isi.'0,0,'.($rec[$i]->prd_hrgjual).',"'.($rec[$i]->prd_prdcd).'",1,"'.rtrim($rec[$i]->prd_deskripsipendek).'"';
                    }
                    if($jenis_tmb == '2'){
                        $isi = $rec[$i]->tmb_kode;
                        //step 7
                        if($rec[$i]->prd_unit == 'KG'){
                            $isi = $isi.',0,';
                        }else{
                            $isi = $isi.',1,';
                        }
                        $isi = $isi.'0,0,'.($rec[$i]->prd_hrgjual).',"'.($rec[$i]->prd_prdcd).'",1,"'.rtrim($rec[$i]->prd_deskripsipendek).'"';
                    }
                    fwrite($out_file, $isi.chr(13).chr(10));
                }
                fclose($out_file);

                //Apa nih fungsi nya?
                //client_host('cmd /c copy '|| dir1 || ' ' || substr(dir1, 1,length(dir1)-3) ||'csv', no_screen);
                //TRANSFER BERHASIL
            }
        }else{
            //step 100
            if(file_exists($dir2)){
                //step 101
                if($alert_button1_2){
                    //step102
                    unlink($dir2);
                    // 	--+ BIZERBA +--
                    if(file_exists($dir3)){
                        //step 103
                        //step 104
                        if($alert_button1_3){
                            unlink($dir3);
                            //--+ PROSES ISHIDA +--
                            //step 105
                            $judul = 'Plu_No,SalesMode,LabelFormat,BestBefore,UnitPrice,PosCode,Font1,Desc1';
                            $out_file = fopen($dir2, "w") or die("Unable to open file!");
                            fwrite($out_file, $judul.chr(13).chr(10));
                            //step 106

                            $rec = DB::select("SELECT   TMB_PRDCD, RPAD(TMB_KODE,4,' ') TMB_KODE,
                                      SUBSTR (PRD_PRDCD, 1, 6) || '1' AS PRD_PRDCD, PRD_UNIT,
                                      to_char(PRD_HRGJUAL,'9999999999.99') PRD_HRGJUAL, --add 2 koma (kmy gak bisa proses)
                                      PRD_DESKRIPSIPENDEK, to_char(PRMd_HRGJUAL,'9999999999.99') PRMd_HRGJUAL, --add 2 koma (kmy gak bisa proses)
                                      PRMd_JENISDISC
                                 FROM TBTABEL_PLUTIMBANGAN, TBMASTER_PRODMAST, tbtr_promomd
                                WHERE CASE
                                          WHEN TMB_MODIFY_DT IS NOT NULL
                                              THEN TO_CHAR (TMB_MODIFY_DT, 'YYYY-MM-DD')
                                          ELSE TO_CHAR (TMB_CREATE_DT, 'YYYY-MM-DD')
                                      END BETWEEN TO_CHAR ('$date1', 'YYYY-MM-DD')
                                              AND TO_CHAR ('$date2', 'YYYY-MM-DD')
                                  AND TO_CHAR (PRD_PRDCD) = SUBSTR (TMB_PRDCD, 1, 6) || '1'
                                  AND PRMd_PRDCD(+) = PRD_PRDCD
                                  AND nvl(PRD_KODETAG,'q') NOT IN ('N', 'X')
                                  AND TRUNC (SYSDATE) BETWEEN PRMd_TGLawal(+) AND PRMd_TGLAKHIR(+)
                                  AND TMB_KODEIGR = '$kodeigr'
                             ORDER BY TMB_KODE");

                            for($i=0;$i<sizeof($rec);$i++){
                                if($rec[$i]->prmd_hrgjual > 0){
                                    if($rec[$i]->prmd_jenisdisc == 'T'){
                                        $isi = $rec[$i]->tmb_kode;
                                        if($rec[$i]->prd_unit == 'KG'){
                                            $isi = $isi.',0,';
                                        }else{
                                            $isi = $isi.',1,';
                                        }
                                        $isi = $isi.'0,0,'.($rec[$i]->prmd_hrgjual).',"'.($rec[$i]->prd_prdcd).'",1,"'.rtrim($rec[$i]->prd_deskripsipendek).'"';
                                    }else{
                                        $isi = $rec[$i]->tmb_kode;
                                        if($rec[$i]->prd_unit == 'KG'){
                                            $isi = $isi.',0,';
                                        }else{
                                            $isi = $isi.',1,';
                                        }
                                        $isi = $isi.'0,0,'.($rec[$i]->prd_hrgjual).',"'.($rec[$i]->prd_prdcd).'",1,"'.rtrim($rec[$i]->prd_deskripsipendek).'"';
                                    }
                                }else{
                                    $isi = $rec[$i]->tmb_kode;
                                    if($rec[$i]->prd_unit == 'KG'){
                                        $isi = $isi.',0,';
                                    }else{
                                        $isi = $isi.',1,';
                                    }
                                    $isi = $isi.'0,0,'.($rec[$i]->prd_hrgjual).',"'.($rec[$i]->prd_prdcd).'",1,"'.rtrim($rec[$i]->prd_deskripsipendek).'"';
                                }
                                fwrite($out_file, $isi.chr(13).chr(10));
                            }
                            fclose($out_file);

                            //Apa fungsinya nih!?
                            copy( $dir2, $dir2csv );
                            //client_host('cmd /c copy '|| dir2 || ' ' || substr(dir2, 1,length(dir2)-3) ||'csv', no_screen);
            //--- PROSES ISHIDA ---
            //--+ PROSES BIZERBA +--
                            //step 107
                            $out_file = fopen($dir3, "w") or die("Unable to open file!");
                            fwrite($out_file, chr(13).chr(10));
                            // step 1071

                            $rec = DB::select("SELECT   TMB_PRDCD, RPAD(TMB_KODE,4,' ') TMB_KODE,
                                      SUBSTR (PRD_PRDCD, 1, 6) || '1' AS PRD_PRDCD, PRD_UNIT,
                                      to_char(PRD_HRGJUAL,'9999999999.99') PRD_HRGJUAL, --add 2 koma (kmy gak bisa proses)
                                      PRD_DESKRIPSIPENDEK, to_char(PRMd_HRGJUAL,'9999999999.99') PRMd_HRGJUAL, --add 2 koma (kmy gak bisa proses)
                                      PRMd_JENISDISC
                                 FROM TBTABEL_PLUTIMBANGAN, TBMASTER_PRODMAST, tbtr_promomd
                                WHERE CASE
                                          WHEN TMB_MODIFY_DT IS NOT NULL
                                              THEN TO_CHAR (TMB_MODIFY_DT, 'YYYY-MM-DD')
                                          ELSE TO_CHAR (TMB_CREATE_DT, 'YYYY-MM-DD')
                                      END BETWEEN TO_CHAR ('$date1', 'YYYY-MM-DD')
                                              AND TO_CHAR ('$date2', 'YYYY-MM-DD')
                                  AND TO_CHAR (PRD_PRDCD) = SUBSTR (TMB_PRDCD, 1, 6) || '1'
                                  AND PRMd_PRDCD(+) = PRD_PRDCD
                                  AND nvl(PRD_KODETAG,'q') NOT IN ('N', 'X')
                                  AND TRUNC (SYSDATE) BETWEEN PRMd_TGLawal(+) AND PRMd_TGLAKHIR(+)
                                  AND TMB_KODEIGR = '$kodeigr'
                             ORDER BY TMB_KODE");

                            for($i=0;$i<sizeof($rec);$i++){
                                if($rec[$i]->prmd_hrgjual > 0){
                                    if($rec[$i]->prmd_jenisdisc == 'T'){
                                        $isi = $rec[$i]->tmb_kode;
                                        if($rec[$i]->prd_unit == 'KG'){
                                            $isi = $isi.',0,';
                                        }else{
                                            $isi = $isi.',1,';
                                        }
                                        $isi = $isi.'0,0,'.($rec[$i]->prmd_hrgjual).',"'.($rec[$i]->prd_prdcd).'",1,"'.rtrim($rec[$i]->prd_deskripsipendek).'"';
                                    }else{
                                        $isi = $rec[$i]->tmb_kode;
                                        if($rec[$i]->prd_unit == 'KG'){
                                            $isi = $isi.',0,';
                                        }else{
                                            $isi = $isi.',1,';
                                        }
                                        $isi = $isi.'0,0,'.($rec[$i]->prd_hrgjual).',"'.($rec[$i]->prd_prdcd).'",1,"'.rtrim($rec[$i]->prd_deskripsipendek).'"';
                                    }
                                }else{
                                    $isi = $rec[$i]->tmb_kode;
                                    if($rec[$i]->prd_unit == 'KG'){
                                        $isi = $isi.',0,';
                                    }else{
                                        $isi = $isi.',1,';
                                    }
                                    $isi = $isi.'0,0,'.($rec[$i]->prd_hrgjual).',"'.($rec[$i]->prd_prdcd).'",1,"'.rtrim($rec[$i]->prd_deskripsipendek).'"';
                                }
                                fwrite($out_file, $isi.chr(13).chr(10));
                            }
                            fclose($out_file);

                            //Apa fungsinya nih!?
                            copy( $dir3, $dir3csv );
                            //client_host('cmd /c copy '|| dir3 || ' ' || substr(dir3, 1,length(dir3)-3) ||'csv', no_screen);
                            //TRANSFER BERHASIL
                        //--- PROSES BIZERBA ---
                        }else{
                            // --+ PROSES ISHIDA +--
                            //step 108

                            $judul = 'Plu_No,SalesMode,LabelFormat,BestBefore,UnitPrice,PosCode,Font1,Desc1';
                            $out_file = fopen($dir2, "w") or die("Unable to open file!");
                            fwrite($out_file, $judul.chr(13).chr(10));
                            //step 1081
                            $rec = DB::select("SELECT   TMB_PRDCD, RPAD(TMB_KODE,4,' ') TMB_KODE, SUBSTR (PRD_PRDCD, 1, 6) || '1'
                                                                                      AS PRD_PRDCD,
                                  PRD_UNIT, to_char(PRD_HRGJUAL,'9999999999.99') PRD_HRGJUAL, --add 2 koma (kmy gak bisa proses)
                                  PRD_DESKRIPSIPENDEK, to_char(PRMd_HRGJUAL,'9999999999.99') PRMd_HRGJUAL, --add 2 koma (kmy gak bisa proses)
                                  PRMd_JENISDISC
                             FROM TBTABEL_PLUTIMBANGAN, TBMASTER_PRODMAST, tbtr_promomd
                            WHERE CASE
                                      WHEN TMB_MODIFY_DT IS NOT NULL
                                          THEN TO_CHAR (TMB_MODIFY_DT, 'YYYY-MM-DD')
                                      ELSE TO_CHAR (TMB_CREATE_DT, 'YYYY-MM-DD')
                                  END BETWEEN TO_CHAR ('$date1', 'YYYY-MM-DD')
                                          AND TO_CHAR ('$date2', 'YYYY-MM-DD')
                              AND TO_CHAR (PRD_PRDCD) = SUBSTR (TMB_PRDCD, 1, 6) || '1'
                              AND PRMd_PRDCD(+) = PRD_PRDCD
                              AND nvl(PRD_KODETAG,'q') NOT IN ('N', 'X')
                              AND TRUNC (SYSDATE) BETWEEN PRMd_TGLawal(+) AND PRMd_TGLAKHIR(+)
                              AND TMB_KODEIGR = '$kodeigr'
                         ORDER BY TMB_KODE");

                            for($i=0;$i<sizeof($rec);$i++){
                                if($rec[$i]->prmd_hrgjual > 0){
                                    if($rec[$i]->prmd_jenisdisc == 'T'){
                                        $isi = $rec[$i]->tmb_kode;
                                        if($rec[$i]->prd_unit == 'KG'){
                                            $isi = $isi.',0,';
                                        }else{
                                            $isi = $isi.',1,';
                                        }
                                        $isi = $isi.'0,0,'.($rec[$i]->prmd_hrgjual).',"'.($rec[$i]->prd_prdcd).'",1,"'.rtrim($rec[$i]->prd_deskripsipendek).'"';
                                    }else{
                                        $isi = $rec[$i]->tmb_kode;
                                        if($rec[$i]->prd_unit == 'KG'){
                                            $isi = $isi.',0,';
                                        }else{
                                            $isi = $isi.',1,';
                                        }
                                        $isi = $isi.'0,0,'.($rec[$i]->prd_hrgjual).',"'.($rec[$i]->prd_prdcd).'",1,"'.rtrim($rec[$i]->prd_deskripsipendek).'"';
                                    }
                                }else{
                                    $isi = $rec[$i]->tmb_kode;
                                    if($rec[$i]->prd_unit == 'KG'){
                                        $isi = $isi.',0,';
                                    }else{
                                        $isi = $isi.',1,';
                                    }
                                    $isi = $isi.'0,0,'.($rec[$i]->prd_hrgjual).',"'.($rec[$i]->prd_prdcd).'",1,"'.rtrim($rec[$i]->prd_deskripsipendek).'"';
                                }
                                fwrite($out_file, $isi.chr(13).chr(10));
                            }
                            //step 1082
                            fclose($out_file);

                            //Apa fungsinya nih!?
                            copy( $dir2, $dir2csv );
                            //client_host('cmd /c copy '|| dir2 || ' ' || substr(dir2, 1,length(dir2)-3) ||'csv', no_screen);

                            //--- PROSES ISHIDA ---
                            //--+ PROSES BIZERBA +--

                            //step 109
                            $out_file = fopen($dir3, "w") or die("Unable to open file!");
                            fwrite($out_file, chr(13).chr(10));
                            $rec = DB::select("SELECT   TMB_PRDCD, RPAD(TMB_KODE,4,' ') TMB_KODE, SUBSTR (PRD_PRDCD, 1, 6) || '1' AS PRD_PRDCD,
                                  PRD_UNIT, to_char(PRD_HRGJUAL,'9999999999.99') PRD_HRGJUAL, --add 2 koma (kmy gak bisa proses)
                                  PRD_DESKRIPSIPENDEK, to_char(PRMd_HRGJUAL,'9999999999.99') PRMd_HRGJUAL, --add 2 koma (kmy gak bisa proses)
                                  PRMd_JENISDISC
                             FROM TBTABEL_PLUTIMBANGAN, TBMASTER_PRODMAST, tbtr_promomd
                            WHERE CASE
                                      WHEN TMB_MODIFY_DT IS NOT NULL
                                          THEN TO_CHAR (TMB_MODIFY_DT, 'YYYY-MM-DD')
                                      ELSE TO_CHAR (TMB_CREATE_DT, 'YYYY-MM-DD')
                                  END BETWEEN TO_CHAR (:TXT_TGL1, 'YYYY-MM-DD')
                                          AND TO_CHAR (:TXT_TGL2, 'YYYY-MM-DD')
                              AND TO_CHAR (PRD_PRDCD) = SUBSTR (TMB_PRDCD, 1, 6) || '1'
                              AND PRMd_PRDCD(+) = PRD_PRDCD
                              AND nvl(PRD_KODETAG,'q') NOT IN ('N', 'X')
                              AND TRUNC (SYSDATE) BETWEEN PRMd_TGLawal(+) AND PRMd_TGLAKHIR(+)
                              AND TMB_KODEIGR = :GLOBAL.KDIGR
                         ORDER BY TMB_KODE");
                            for($i=0;$i<sizeof($rec);$i++){
                                if($rec[$i]->prmd_hrgjual > 0){
                                    if($rec[$i]->prmd_jenisdisc == 'T'){
                                        $isi = $rec[$i]->tmb_kode;
                                        if($rec[$i]->prd_unit == 'KG'){
                                            $isi = $isi.',0,';
                                        }else{
                                            $isi = $isi.',1,';
                                        }
                                        $isi = $isi.'0,0,'.($rec[$i]->prmd_hrgjual).',"'.($rec[$i]->prd_prdcd).'",1,"'.rtrim($rec[$i]->prd_deskripsipendek).'"';
                                    }else{
                                        $isi = $rec[$i]->tmb_kode;
                                        if($rec[$i]->prd_unit == 'KG'){
                                            $isi = $isi.',0,';
                                        }else{
                                            $isi = $isi.',1,';
                                        }
                                        $isi = $isi.'0,0,'.($rec[$i]->prd_hrgjual).',"'.($rec[$i]->prd_prdcd).'",1,"'.rtrim($rec[$i]->prd_deskripsipendek).'"';
                                    }
                                }else{
                                    $isi = $rec[$i]->tmb_kode;
                                    if($rec[$i]->prd_unit == 'KG'){
                                        $isi = $isi.',0,';
                                    }else{
                                        $isi = $isi.',1,';
                                    }
                                    $isi = $isi.'0,0,'.($rec[$i]->prd_hrgjual).',"'.($rec[$i]->prd_prdcd).'",1,"'.rtrim($rec[$i]->prd_deskripsipendek).'"';
                                }
                                fwrite($out_file, $isi.chr(13).chr(10));
                            }
                            fclose($out_file);

                            //Apa fungsinya nih!?
                            copy( $dir3, $dir3csv );
                            //client_host('cmd /c copy '|| dir3 || ' ' || substr(dir3, 1,length(dir3)-3) ||'csv', no_screen);
                            //--- PROSES BIZERBA ---
                        }
                    }
                    //--- BIZERBA ---
                }else{
                    //--+ ISHIDA ELSE +--
                    //step 110
                    if(file_exists($dir3)){
                        if($alert_button1_4){
                            //step 111
                            unlink($dir3);
                            //step 112
                            //--+ PROSES ISHIDA +--
                            $judul = 'Plu_No,SalesMode,LabelFormat,BestBefore,UnitPrice,PosCode,Font1,Desc1';
                            $out_file = fopen($dir2, "w") or die("Unable to open file!");
                            fwrite($out_file, $judul.chr(13).chr(10));
                            //step 113
                            $rec = DB::select("SELECT   TMB_PRDCD, RPAD(TMB_KODE,4,' ') TMB_KODE, SUBSTR (PRD_PRDCD, 1, 6) || '1'
                                                                                      AS PRD_PRDCD,
                                  PRD_UNIT, to_char(PRD_HRGJUAL,'9999999999.99') PRD_HRGJUAL, --add 2 koma (kmy gak bisa proses)
                                  PRD_DESKRIPSIPENDEK, to_char(PRMd_HRGJUAL,'9999999999.99') PRMd_HRGJUAL, --add 2 koma (kmy gak bisa proses)
                                  PRMd_JENISDISC
                             FROM TBTABEL_PLUTIMBANGAN, TBMASTER_PRODMAST, tbtr_promomd
                            WHERE CASE
                                      WHEN TMB_MODIFY_DT IS NOT NULL
                                          THEN TO_CHAR (TMB_MODIFY_DT, 'YYYY-MM-DD')
                                      ELSE TO_CHAR (TMB_CREATE_DT, 'YYYY-MM-DD')
                                  END BETWEEN TO_CHAR ('$date1', 'YYYY-MM-DD')
                                          AND TO_CHAR ('$date2', 'YYYY-MM-DD')
                              AND TO_CHAR (PRD_PRDCD) = SUBSTR (TMB_PRDCD, 1, 6) || '1'
                              AND PRMd_PRDCD(+) = PRD_PRDCD
                              AND nvl(PRD_KODETAG,'q') NOT IN ('N', 'X')
                              AND TRUNC (SYSDATE) BETWEEN PRMd_TGLawal(+) AND PRMd_TGLAKHIR(+)
                              AND TMB_KODEIGR = '$kodeigr'
                         ORDER BY TMB_KODE");
                            for($i=0;$i<sizeof($rec);$i++){
                                if($rec[$i]->prmd_hrgjual > 0){
                                    if($rec[$i]->prmd_jenisdisc == 'T'){
                                        $isi = $rec[$i]->tmb_kode;
                                        if($rec[$i]->prd_unit == 'KG'){
                                            $isi = $isi.',0,';
                                        }else{
                                            $isi = $isi.',1,';
                                        }
                                        $isi = $isi.'0,0,'.($rec[$i]->prmd_hrgjual).',"'.($rec[$i]->prd_prdcd).'",1,"'.rtrim($rec[$i]->prd_deskripsipendek).'"';
                                    }else{
                                        $isi = $rec[$i]->tmb_kode;
                                        if($rec[$i]->prd_unit == 'KG'){
                                            $isi = $isi.',0,';
                                        }else{
                                            $isi = $isi.',1,';
                                        }
                                        $isi = $isi.'0,0,'.($rec[$i]->prd_hrgjual).',"'.($rec[$i]->prd_prdcd).'",1,"'.rtrim($rec[$i]->prd_deskripsipendek).'"';
                                    }
                                }else{
                                    $isi = $rec[$i]->tmb_kode;
                                    if($rec[$i]->prd_unit == 'KG'){
                                        $isi = $isi.',0,';
                                    }else{
                                        $isi = $isi.',1,';
                                    }
                                    $isi = $isi.'0,0,'.($rec[$i]->prd_hrgjual).',"'.($rec[$i]->prd_prdcd).'",1,"'.rtrim($rec[$i]->prd_deskripsipendek).'"';
                                }
                                fwrite($out_file, $isi.chr(13).chr(10));
                            }
                            fclose($out_file);

                            //Apa fungsinya nih!?
                            copy( $dir2, $dir2csv );
                            //client_host('cmd /c copy '|| dir2 || ' ' || substr(dir2, 1,length(dir2)-3) ||'csv', no_screen);
                            //--- PROSES ISHIDA ---

                            //--+ PROSES BIZERBA +--
                            $out_file = fopen($dir3, "w") or die("Unable to open file!");
                            fwrite($out_file, chr(13).chr(10));
                            //step 114
                            $rec = DB::select("SELECT   TMB_PRDCD, RPAD(TMB_KODE,4,' ') TMB_KODE, SUBSTR (PRD_PRDCD, 1, 6) || '1' AS PRD_PRDCD,
                                  PRD_UNIT, to_char(PRD_HRGJUAL,'9999999999.99') PRD_HRGJUAL, --add 2 koma (kmy gak bisa proses)
                                  PRD_DESKRIPSIPENDEK, to_char(PRMd_HRGJUAL,'9999999999.99') PRMd_HRGJUAL, --add 2 koma (kmy gak bisa proses)
                                  PRMd_JENISDISC
                             FROM TBTABEL_PLUTIMBANGAN, TBMASTER_PRODMAST, tbtr_promomd
                            WHERE CASE
                                      WHEN TMB_MODIFY_DT IS NOT NULL
                                          THEN TO_CHAR (TMB_MODIFY_DT, 'YYYY-MM-DD')
                                      ELSE TO_CHAR (TMB_CREATE_DT, 'YYYY-MM-DD')
                                  END BETWEEN TO_CHAR ('$date1', 'YYYY-MM-DD')
                                          AND TO_CHAR ('$date2', 'YYYY-MM-DD')
                              AND TO_CHAR (PRD_PRDCD) = SUBSTR (TMB_PRDCD, 1, 6) || '1'
                              AND PRMd_PRDCD(+) = PRD_PRDCD
                              AND nvl(PRD_KODETAG,'q') NOT IN ('N', 'X')
                              AND TRUNC (SYSDATE) BETWEEN PRMd_TGLawal(+) AND PRMd_TGLAKHIR(+)
                              AND TMB_KODEIGR = '$kodeigr'
                         ORDER BY TMB_KODE");
                            for($i=0;$i<sizeof($rec);$i++){
                                if($rec[$i]->prmd_hrgjual > 0){
                                    if($rec[$i]->prmd_jenisdisc == 'T'){
                                        $isi = $rec[$i]->tmb_kode;
                                        if($rec[$i]->prd_unit == 'KG'){
                                            $isi = $isi.',0,';
                                        }else{
                                            $isi = $isi.',1,';
                                        }
                                        $isi = $isi.'0,0,'.($rec[$i]->prmd_hrgjual).',"'.($rec[$i]->prd_prdcd).'",1,"'.rtrim($rec[$i]->prd_deskripsipendek).'"';
                                    }else{
                                        $isi = $rec[$i]->tmb_kode;
                                        if($rec[$i]->prd_unit == 'KG'){
                                            $isi = $isi.',0,';
                                        }else{
                                            $isi = $isi.',1,';
                                        }
                                        $isi = $isi.'0,0,'.($rec[$i]->prd_hrgjual).',"'.($rec[$i]->prd_prdcd).'",1,"'.rtrim($rec[$i]->prd_deskripsipendek).'"';
                                    }
                                }else{
                                    $isi = $rec[$i]->tmb_kode;
                                    if($rec[$i]->prd_unit == 'KG'){
                                        $isi = $isi.',0,';
                                    }else{
                                        $isi = $isi.',1,';
                                    }
                                    $isi = $isi.'0,0,'.($rec[$i]->prd_hrgjual).',"'.($rec[$i]->prd_prdcd).'",1,"'.rtrim($rec[$i]->prd_deskripsipendek).'"';
                                }
                                fwrite($out_file, $isi.chr(13).chr(10));
                            }
                            fclose($out_file);

                            //Apa fungsinya nih!?
                            copy( $dir3, $dir3csv );
                            //client_host('cmd /c copy '|| dir3 || ' ' || substr(dir3, 1,length(dir3)-3) ||'csv', no_screen);
                            //TRANSFER BERHASIL
                            //--- PROSES BIZERBA ---
                        }else{
                            //--+ PROSES ISHIDA +--
                            //step 115
                            $judul = 'Plu_No,SalesMode,LabelFormat,BestBefore,UnitPrice,PosCode,Font1,Desc1';
                            //step 1151
                            //step 1152
                            $out_file = fopen($dir2, "w") or die("Unable to open file!");
                            //step 1153
                            fwrite($out_file, $judul.chr(13).chr(10));
                            //step 116
                            $rec = DB::select("SELECT   TMB_PRDCD, RPAD(TMB_KODE,4,' ') TMB_KODE, SUBSTR (PRD_PRDCD, 1, 6) || '1' AS PRD_PRDCD,
                              PRD_UNIT, to_char(PRD_HRGJUAL,'9999999999.99') PRD_HRGJUAL, --add 2 koma (kmy gak bisa proses)
                              PRD_DESKRIPSIPENDEK, to_char(PRMd_HRGJUAL,'9999999999.99') PRMd_HRGJUAL, --add 2 koma (kmy gak bisa proses)
                              PRMd_JENISDISC
                         FROM TBTABEL_PLUTIMBANGAN, TBMASTER_PRODMAST, tbtr_promomd
                        WHERE CASE
                                  WHEN TMB_MODIFY_DT IS NOT NULL
                                      THEN TO_CHAR (TMB_MODIFY_DT, 'YYYY-MM-DD')
                                  ELSE TO_CHAR (TMB_CREATE_DT, 'YYYY-MM-DD')
                              END BETWEEN TO_CHAR ('$date1', 'YYYY-MM-DD')
                                      AND TO_CHAR ('$date2', 'YYYY-MM-DD')
                          AND TO_CHAR (PRD_PRDCD) = SUBSTR (TMB_PRDCD, 1, 6) || '1'
                          AND PRMd_PRDCD(+) = PRD_PRDCD
                          AND nvl(PRD_KODETAG,'q') NOT IN ('N', 'X')
                          AND TRUNC (SYSDATE) BETWEEN PRMd_TGLawal(+) AND PRMd_TGLAKHIR(+)
                          AND TMB_KODEIGR = '$kodeigr'
                     ORDER BY TMB_KODE");
                            for($i=0;$i<sizeof($rec);$i++){
                                if($rec[$i]->prmd_hrgjual > 0){
                                    if($rec[$i]->prmd_jenisdisc == 'T'){
                                        $isi = $rec[$i]->tmb_kode;
                                        if($rec[$i]->prd_unit == 'KG'){
                                            $isi = $isi.',0,';
                                        }else{
                                            $isi = $isi.',1,';
                                        }
                                        $isi = $isi.'0,0,'.($rec[$i]->prmd_hrgjual).',"'.($rec[$i]->prd_prdcd).'",1,"'.rtrim($rec[$i]->prd_deskripsipendek).'"';
                                    }else{
                                        $isi = $rec[$i]->tmb_kode;
                                        if($rec[$i]->prd_unit == 'KG'){
                                            $isi = $isi.',0,';
                                        }else{
                                            $isi = $isi.',1,';
                                        }
                                        $isi = $isi.'0,0,'.($rec[$i]->prd_hrgjual).',"'.($rec[$i]->prd_prdcd).'",1,"'.rtrim($rec[$i]->prd_deskripsipendek).'"';
                                    }
                                }else{
                                    $isi = $rec[$i]->tmb_kode;
                                    if($rec[$i]->prd_unit == 'KG'){
                                        $isi = $isi.',0,';
                                    }else{
                                        $isi = $isi.',1,';
                                    }
                                    $isi = $isi.'0,0,'.($rec[$i]->prd_hrgjual).',"'.($rec[$i]->prd_prdcd).'",1,"'.rtrim($rec[$i]->prd_deskripsipendek).'"';
                                }
                                fwrite($out_file, $isi.chr(13).chr(10));
                            }
                            fclose($out_file);

                            //Apa fungsinya nih!?
                            copy( $dir2, $dir2csv );
                            //client_host('cmd /c copy '|| dir2 || ' ' || substr(dir2, 1,length(dir2)-3) ||'csv', no_screen);
                            //--- PROSES ISHIDA ---
                            //--+ PROSES BIZERBA +--
                            $out_file = fopen($dir3, "w") or die("Unable to open file!");
                            fwrite($out_file, chr(13).chr(10));
                            //step 117
                            $rec = DB::select("SELECT   TMB_PRDCD, RPAD(TMB_KODE,4,' ') TMB_KODE, SUBSTR (PRD_PRDCD, 1, 6) || '1' AS PRD_PRDCD,
                              PRD_UNIT, to_char(PRD_HRGJUAL,'9999999999.99') PRD_HRGJUAL, --add 2 koma (kmy gak bisa proses)
                              PRD_DESKRIPSIPENDEK, to_char(PRMd_HRGJUAL,'9999999999.99') PRMd_HRGJUAL, --add 2 koma (kmy gak bisa proses)
                              PRMd_JENISDISC
                         FROM TBTABEL_PLUTIMBANGAN, TBMASTER_PRODMAST, tbtr_promomd
                        WHERE CASE
                                  WHEN TMB_MODIFY_DT IS NOT NULL
                                      THEN TO_CHAR (TMB_MODIFY_DT, 'YYYY-MM-DD')
                                  ELSE TO_CHAR (TMB_CREATE_DT, 'YYYY-MM-DD')
                              END BETWEEN TO_CHAR ('$date1', 'YYYY-MM-DD')
                                      AND TO_CHAR ('$date2', 'YYYY-MM-DD')
                          AND TO_CHAR (PRD_PRDCD) = SUBSTR (TMB_PRDCD, 1, 6) || '1'
                          AND PRMd_PRDCD(+) = PRD_PRDCD
                          AND nvl(PRD_KODETAG,'q') NOT IN ('N', 'X')
                          AND TRUNC (SYSDATE) BETWEEN PRMd_TGLawal(+) AND PRMd_TGLAKHIR(+)
                          AND TMB_KODEIGR = '$kodeigr'
                     ORDER BY TMB_KODE");
                            for($i=0;$i<sizeof($rec);$i++){
                                if($rec[$i]->prmd_hrgjual > 0){
                                    if($rec[$i]->prmd_jenisdisc == 'T'){
                                        $isi = $rec[$i]->tmb_kode;
                                        if($rec[$i]->prd_unit == 'KG'){
                                            $isi = $isi.',0,';
                                        }else{
                                            $isi = $isi.',1,';
                                        }
                                        $isi = $isi.'0,0,'.($rec[$i]->prmd_hrgjual).',"'.($rec[$i]->prd_prdcd).'",1,"'.rtrim($rec[$i]->prd_deskripsipendek).'"';
                                    }else{
                                        $isi = $rec[$i]->tmb_kode;
                                        if($rec[$i]->prd_unit == 'KG'){
                                            $isi = $isi.',0,';
                                        }else{
                                            $isi = $isi.',1,';
                                        }
                                        $isi = $isi.'0,0,'.($rec[$i]->prd_hrgjual).',"'.($rec[$i]->prd_prdcd).'",1,"'.rtrim($rec[$i]->prd_deskripsipendek).'"';
                                    }
                                }else{
                                    $isi = $rec[$i]->tmb_kode;
                                    if($rec[$i]->prd_unit == 'KG'){
                                        $isi = $isi.',0,';
                                    }else{
                                        $isi = $isi.',1,';
                                    }
                                    $isi = $isi.'0,0,'.($rec[$i]->prd_hrgjual).',"'.($rec[$i]->prd_prdcd).'",1,"'.rtrim($rec[$i]->prd_deskripsipendek).'"';
                                }
                                fwrite($out_file, $isi.chr(13).chr(10));
                            }
                            fclose($out_file);

                            //Apa fungsinya nih!?
                            copy( $dir3, $dir3csv );
                            //client_host('cmd /c copy '|| dir3 || ' ' || substr(dir3, 1,length(dir3)-3) ||'csv', no_screen);
                            //TRANSFER BERHASIL
                            //--- PROSES BIZERBA ---
                        }
                    }
                }
            }
        }

        //EXCEPTION untuk meminta mapping ke directory S:
    }

    public function Print(Request $request){
        $kodeigr = $_SESSION['kdigr'];
        $val1 = $request->val1;
        $val2 = $request->val2;
        $p_pil = $request->p_pil;

        $today = date('d-m-Y');
        $time = date('H:i:s');
        if($p_pil == 1){
            $p_order = 'order by prd_prdcd';
            if($val1 != '' && $val2 == ''){
                $p_val = " AND TMB_PRDCD = '".$val1."'";
            }elseif ($val1 != '' && $val2 != ''){
                $p_val = " AND TMB_PRDCD BETWEEN '".$val1."' AND '".$val2."'";
            }else{
                $p_val = "";
            }
        }else{
            $p_order = 'order by tmb_kode';
            if($val1 != '' && $val2 == ''){
                $p_val = " AND TMB_KODE = '".$val1."'";
            }elseif ($val1 != '' && $val2 != ''){
                $p_val = " AND TMB_KODE BETWEEN '".$val1."' AND '".$val2."'";
            }else{
                $p_val = "";
            }
        }

        $datas = DB::select("SELECT PRS_NAMAPERUSAHAAN, PRS_NAMACABANG, PRS_NAMAWILAYAH, SUBSTR(TMB_PRDCD,1,6)||'1' PLU, PRD_PRDCD, PRD_DESC, PRD_SATUAN, PRD_KODETAG, HRG_JUAL, TMB_KODE
FROM TBMASTER_PERUSAHAAN, TBTABEL_PLUTIMBANGAN,
(	 SELECT PRD_PRDCD, PRD_DESKRIPSIPENDEK PRD_DESC, PRD_UNIT||'/'||PRD_FRAC PRD_SATUAN, PRD_KODETAG,
	 		CASE WHEN ( TRUNC(SYSDATE)>= TRUNC(PRMD_TGLAWAL) AND TRUNC(SYSDATE)<= TRUNC(PRMD_TGLAKHIR) ) AND PRMD_JENISDISC = 'T' THEN PRMD_HRGJUAL ELSE PRD_HRGJUAL END HRG_JUAL
	 FROM TBMASTER_PRODMAST,
	 ( 	  SELECT 'T' PROMO, PRMD_PRDCD, PRMD_JENISDISC, PRMD_TGLAWAL, PRMD_TGLAKHIR, PRMD_HRGJUAL
		  FROM TBTR_PROMOMD, TBMASTER_PRODMAST
		  WHERE PRMD_PRDCD = PRD_PRDCD
	 )
	 WHERE PRMD_PRDCD(+) = PRD_PRDCD
)
WHERE PRS_KODEIGR = '$kodeigr'
  AND PRS_KODEIGR = TMB_KODEIGR
  AND SUBSTR(TMB_PRDCD,1,6)||'1' = PRD_PRDCD
$p_val
$p_order");

        //-------------------------PRINT-----------------------------
        $pdf = PDF::loadview('TABEL.plutimbangan-pdf', ['datas' => $datas, 'today' => $today, 'time' => $time]);
        $pdf->output();
        $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);

        $canvas = $dompdf ->get_canvas();
        $canvas->page_text(514, 17, "Hal {PAGE_NUM} of {PAGE_COUNT}", null, 10, array(0, 0, 0));

        return $pdf->stream('TABEL.plutimbangan-pdf');
    }

    public function LovKode(Request $request){
        $kodeigr = $_SESSION['kdigr'];
        $search = $request->value;

        $datas   = DB::table('TBTABEL_PLUTIMBANGAN')
            ->selectRaw("TMB_DESKRIPSI1, TMB_KODE, PRD_FRAC, PRD_HRGJUAL")
//            ->leftJoin("TBMASTER_PRODMAST","TBTABEL_PLUTIMBANGAN.TMB_PRDCD",'=','TBMASTER_PRODMAST.PRD_PRDCD ')
            ->LeftJoin('TBMASTER_PRODMAST',function($join){
                $join->on('TMB_PRDCD','PRD_PRDCD');
            })
            ->where('TMB_DESKRIPSI1','LIKE', '%'.$search.'%')
            ->where('prd_kodeigr','=',$_SESSION['kdigr'])

            ->orWhere('TMB_KODE','LIKE', '%'.$search.'%')
            ->where('prd_kodeigr','=',$_SESSION['kdigr'])

            ->orWhere('PRD_FRAC','LIKE', '%'.$search.'%')
            ->where('prd_kodeigr','=',$_SESSION['kdigr'])

            ->orWhere('PRD_HRGJUAL','LIKE', '%'.$search.'%')
            ->where('prd_kodeigr','=',$_SESSION['kdigr'])

            ->orderBy('TMB_KODE')
            ->limit(100)
            ->get();

//        $datas = DB::select("Select TMB_DESKRIPSI1, TMB_KODE, PRD_FRAC, PRD_HRGJUAL
//FROM   TBTABEL_PLUTIMBANGAN, TBMASTER_PRODMAST
//WHERE
//    TMB_PRDCD = PRD_PRDCD AND PRD_KODEIGR = '$kodeigr'
//ORDER BY TMB_KODE");

        return Datatables::of($datas)->make(true);

//        return response()->json($data);
    }

    public function GetKode(Request $request){
        $kodeigr = $_SESSION['kdigr'];
        $search = $request->kode;

        $datas   = DB::table('TBTABEL_PLUTIMBANGAN')
            ->selectRaw("TMB_DESKRIPSI1, TMB_KODE, PRD_FRAC, PRD_HRGJUAL")
//            ->leftJoin("TBMASTER_PRODMAST","TBTABEL_PLUTIMBANGAN.TMB_PRDCD",'=','TBMASTER_PRODMAST.PRD_PRDCD ')
            ->LeftJoin('TBMASTER_PRODMAST',function($join){
                $join->on('TMB_PRDCD','PRD_PRDCD');
            })
            ->where('TMB_KODE','=', $search)
            ->where('prd_kodeigr','=',$_SESSION['kdigr'])

            ->first();

        return response()->json($datas);
    }

    public function getData(){
        $data = DB::table('tbmaster_plucharge')
            ->leftJoin('tbmaster_prodmast','prd_prdcd','=','non_prdcd')
            ->selectRaw("non_prdcd plu, nvl(prd_deskripsipanjang, 'PLU TIDAK TERDAFTAR DI MASTER BARANG') desk, case when prd_unit is null then ' ' else prd_unit || '/' || prd_frac end satuan")
            ->where('non_kodeigr','=',$_SESSION['kdigr'])
            ->orderBy('non_prdcd')
            ->get();

        return $data;
    }

}
