<?php

namespace App\Http\Controllers\TABEL;

use Carbon\Carbon;
use DateTime;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller; use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;
use PDF;
use Yajra\DataTables\DataTables;

class PluTimbanganController extends Controller
{
    public function index(){
        return view('TABEL.plu-timbangan');
    }

    public function StartNew(){
        $jenistmb = DB::connection(Session::get('connection'))->table('tbMaster_Perusahaan')
            ->selectRaw("nvl(PRS_JENISTIMBANGAN,'q') a")
            ->first();

        $persh_cur = DB::connection(Session::get('connection'))->table('TBMASTER_PERUSAHAAN')
            ->selectRaw("PRS_IPSERVER, PRS_USERSERVER, PRS_PWDSERVER, nvl(PRS_JENISTIMBANGAN,'q') jenistmb")
            ->first();

        return response()->json($persh_cur);
    }

    public function LovPlu(Request $request){
        $search = $request->value;

        $datas   = DB::connection(Session::get('connection'))->table('TBMASTER_PRODMAST')
            ->selectRaw("PRD_DESKRIPSIPANJANG,PRD_PRDCD, TO_CHAR(PRD_FRAC)||'/'||PRD_UNIT AS SATUAN, PRD_KODETAG, PRD_HRGJUAL, rownum num")

            ->where('prd_prdcd','LIKE', '%'.$search.'%')
            ->whereRaw("substr(prd_prdcd,7,1) = '1'")
            ->where('prd_kodeigr','=',Session::get('kdigr'))

            ->orWhere('prd_deskripsipanjang','LIKE', '%'.$search.'%')
            ->whereRaw("substr(prd_prdcd,7,1) = '1'")
            ->where('prd_kodeigr','=',Session::get('kdigr'))

            ->orderBy('PRD_DESKRIPSIPANJANG')
            ->limit(100)
            ->get();

        return Datatables::of($datas)->make(true);

//        return response()->json($data);
    }

    public function GetPlu(Request $request){
        $search = $request->plu;

        $data   = DB::connection(Session::get('connection'))->table('TBMASTER_PRODMAST')
            ->selectRaw("PRD_DESKRIPSIPANJANG,PRD_PRDCD, TO_CHAR(PRD_FRAC)||'/'||PRD_UNIT AS SATUAN, PRD_KODETAG, PRD_HRGJUAL, rownum num")

            ->where('prd_prdcd','=', $search)
            ->whereRaw("substr(prd_prdcd,7,1) = '1'")
            ->where('prd_kodeigr','=',Session::get('kdigr'))

            ->orderBy('PRD_DESKRIPSIPANJANG')
            ->first();

        return response()->json($data);
    }

    public function Save(Request $request){
        try {
            $kode = $request->kode;
            $plu = $request->plu;
            $desk = $request->desk;

            $tempkd   = DB::connection(Session::get('connection'))->table('tbtabel_plutimbangan')
                ->selectRaw("nvl(count(1),0) a")
                ->where('tmb_kode','=', $kode)
                ->first();

            $temppr = DB::connection(Session::get('connection'))->table('tbtabel_plutimbangan')
                ->selectRaw("nvl(count(1),0) a")
                ->whereRaw("tmb_prdcd = substr('$plu',1,6)||'0'")
                ->first();

            if((int)($tempkd->a) > 0){
                //kode sudah ada
                return response()->json(1);
            }else if((int)($tempkd->a) == 0 && (int)($temppr->a) == 0){
                DB::connection(Session::get('connection'))->beginTransaction();
                DB::connection(Session::get('connection'))->table('tbtabel_plutimbangan')
                    ->insert([
                        'tmb_kodeigr' => Session::get('kdigr'),
                        'tmb_prdcd' => substr($plu,0,6).'0',
                        'tmb_kode' => $kode,
                        'tmb_deskripsi1' => $desk,
                        'tmb_create_by' => Session::get('usid'),
                        'tmb_create_dt' => Carbon::now()
                    ]);
                DB::connection(Session::get('connection'))->commit();
                return response()->json(2);
            }else if((int)($temppr->a) != 0){
                DB::connection(Session::get('connection'))->beginTransaction();
                DB::connection(Session::get('connection'))->table('tbtabel_plutimbangan')
                    ->where('tmb_prdcd', '=',substr($plu,0,6).'0')
                    ->update(['tmb_kode' => $kode, 'tmb_deskripsi1' => $desk, 'tmb_MODIFY_BY' => Session::get('usid'), 'tmb_MODIFY_DT' => Carbon::now()]);
                DB::connection(Session::get('connection'))->commit();
                return response()->json(3);
            }
        }catch (\Exception $e){
            return response()->json(0);
        }
    }

//    public function preHapus(Request $request){
//        $plu = $request->plu;
//        $temptmb = DB::connection(Session::get('connection'))->select("SELECT NVL (COUNT (1), 0) a
//      FROM TBMASTER_PRODMAST, tbtabel_plutimbangan
//     WHERE prd_prdcd = tmb_prdcd and tmb_PRDCD = substr('$plu',1,6)||'0'");
//
//        return response()->json($temptmb[0]->a);
//    }

    public function Hapus2(Request $request){
        try {
            $plu = $request->plu;
            $kode = $request->kode;
            $jenis_tmb = $request->jenis_tmb;
            $kodeigr = Session::get('kdigr');

            $dir1 = storage_path("HAPUS.txt");
            $dir2 = storage_path("HAPUS (ISHIDA).txt");
            $dir3 = storage_path("HAPUS (BIZERBA).txt");
            $judul = '';
            $isi = '';

            DB::connection(Session::get('connection'))->beginTransaction();
            $temptmb = DB::connection(Session::get('connection'))->select("SELECT NVL (COUNT (1), 0) a
      FROM TBMASTER_PRODMAST, tbtabel_plutimbangan
     WHERE prd_prdcd = tmb_prdcd and tmb_PRDCD = substr('$plu',1,6)||'0'");
            if($temptmb[0]->a != 0){
                $tempPrd = DB::connection(Session::get('connection'))->select("SELECT PRD_KODETAG, PRD_UNIT, PRD_HRGJUAL, PRD_DESKRIPSIPENDEK,
               SUBSTR (PRD_PRDCD, 6) || '1' AS PRD_PRDCD
          FROM TBMASTER_PRODMAST
         WHERE PRD_KODEIGR = '$kodeigr' AND PRD_PRDCD = SUBSTR ('$plu', 1, 6) || '1'");

                $tempPrmd = DB::connection(Session::get('connection'))->select("SELECT NVL (COUNT (1), 0) AS FPROMO
          FROM tbtr_promomd
         WHERE PRMd_PRDCD = '$plu' AND TRUNC (SYSDATE) BETWEEN PRMd_TGLawal AND PRMd_TGLAKHIR");

                if(($tempPrmd[0]->fpromo) > 0){
                    $hrgpromo = DB::connection(Session::get('connection'))->table('tbtr_promomd')
                        ->selectRaw('PRMd_HRGJUAL')
                        ->where('PRMd_PRDCD','=',$plu)
                        ->first();
                }
                if($jenis_tmb != '3'){
                    if($jenis_tmb != '2'){
                        $judul = "Plu_No,LabelFormat,BestBefore,UnitPrice,PosCode,Font1,Desc1";
                    }else{
                        $judul = '';
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
                    if($judul != ''){
                        fwrite($out_file, $judul.chr(13).chr(10));
                    }
                    fwrite($out_file, $isi);
                    fclose($out_file);
                    //dipindah ke bagian paling bawah
//                    DB::connection(Session::get('connection'))->table("TBTABEL_PLUTIMBANGAN")
//                        ->where('TMB_KODEIGR','=',$kodeigr)
//                        ->whereRaw("TMB_PRDCD = substr('$plu',1,6)||'0'")
//                        ->where('TMB_KODE','=',$kode)
//                        ->delete();
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
            }else{
                return response()->json(['msgNoData' => "Tidak ada yang dihapus"]);
            }
            DB::connection(Session::get('connection'))->table("TBTABEL_PLUTIMBANGAN")
                ->where('TMB_KODEIGR','=',$kodeigr)
                ->whereRaw("TMB_PRDCD = substr('$plu',1,6)||'0'")
                ->where('TMB_KODE','=',$kode)
                ->delete();
            DB::connection(Session::get('connection'))->table("tbtabel_plutimbangan")
                ->where('tmb_kodeigr','=',$kodeigr)
                ->where('tmb_prdcd','=',$plu)
                ->where('tmb_kode','=',$kode)
                ->delete();
            DB::connection(Session::get('connection'))->commit();
        }catch (QueryException $e){
            DB::connection(Session::get('connection'))->rollBack();
            return response()->json(['msgError' => $e->getMessage()]);
        }
    }

    public function HapusDir1Txt(Request $request){
        $dir1 = storage_path("HAPUS.txt");
        $jenis_tmb = $request->jenis_tmb;

        if($jenis_tmb != '3'){
            return response()->download($dir1)->deleteFileAfterSend(true);
        }
    }

    public function HapusDir2Txt(Request $request){
        $dir2 = storage_path("HAPUS (ISHIDA).txt");
        $jenis_tmb = $request->jenis_tmb;

        return response()->download($dir2)->deleteFileAfterSend(true);
    }

    public function HapusDir3Txt(Request $request){
        $dir3 = storage_path("HAPUS (BIZERBA).txt");
        $jenis_tmb = $request->jenis_tmb;

        return response()->download($dir3)->deleteFileAfterSend(true);
    }

//    public function Hapus(Request $request)
//    {
//        $perusahaan = DB::connection(Session::get('connection'))->table("tbmaster_perusahaan")->selectRaw("PRS_IPSERVER")->first();
//        $path = $perusahaan->prs_ipserver;
//
//        $plu = $request->plu;
//        $kode = $request->kode;
//        $jenis_tmb = $request->jenis_tmb;
//        $lnew1 = $request->lnew1;
//        $lnew2 = $request->lnew2;
//        $kodeigr = Session::get('kdigr');
//
//        $dir1 = $path."\LREMOTE\HAPUS.txt";
//        $dir2 = $path."\LREMOTE\ISHIDA\HAPUS.txt";
//        $dir3 = $path."\LREMOTE\BIZERBA\HAPUS.txt";
//        $judul = '';
//        $isi = '';
//
//        DB::connection(Session::get('connection'))->beginTransaction();
//        $temptmb = DB::connection(Session::get('connection'))->select("SELECT NVL (COUNT (1), 0) a
//      FROM TBMASTER_PRODMAST, tbtabel_plutimbangan
//     WHERE prd_prdcd = tmb_prdcd and tmb_PRDCD = substr('$plu',1,6)||'0'");
//        if($temptmb[0]->a != 0){
//            $tempPrd = DB::connection(Session::get('connection'))->select("SELECT PRD_KODETAG, PRD_UNIT, PRD_HRGJUAL, PRD_DESKRIPSIPENDEK,
//               SUBSTR (PRD_PRDCD, 6) || '1' AS PRD_PRDCD
//          FROM TBMASTER_PRODMAST
//         WHERE PRD_KODEIGR = '$kodeigr' AND PRD_PRDCD = SUBSTR ('$plu', 1, 6) || '1'");
//
//            $tempPrmd = DB::connection(Session::get('connection'))->select("SELECT NVL (COUNT (1), 0) AS FPROMO
//          FROM tbtr_promomd
//         WHERE PRMd_PRDCD = '$plu' AND TRUNC (SYSDATE) BETWEEN PRMd_TGLawal AND PRMd_TGLAKHIR");
//
//            if(($tempPrmd[0]->fpromo) > 0){
//                $hrgpromo = DB::connection(Session::get('connection'))->table('tbtr_promomd')
//                    ->selectRaw('PRMd_HRGJUAL')
//                    ->where('PRMd_PRDCD','=',$plu)
//                    ->first();
//            }
//            if($jenis_tmb != '3'){
////                if(file_exists("S:/LREMOTE/")){
////                    //do nothing
////                    null;
////                }else{
////                    mkdir("S:/LREMOTE/");
////                }
////                if(file_exists("S:/LREMOTE/ISHIDA/")){
////                    //do nothing
////                    null;
////                }else{
////                    mkdir("S:/LREMOTE/ISHIDA/");
////                }
////                if(file_exists("S:/LREMOTE/BIZERBA/")){
////                    //do nothing
////                    null;
////                }else{
////                    mkdir("S:/LREMOTE/BIZERBA/");
////                }
//
//                //-- HAPUS TRUS BIKIN BARU --
//                if(file_exists($dir1)){
//                    if($lnew1){
//                        unlink($dir1);
//                        if($jenis_tmb != '2'){
//                            $judul = "Plu_No,LabelFormat,BestBefore,UnitPrice,PosCode,Font1,Desc1";
//                        }
//                        if(($tempPrmd[0]->fpromo) > 0){
//                            if($jenis_tmb != '2'){
//                                $isi = $kode.",0,0,".($hrgpromo->prmd_hrgjual).',"'.($tempPrd[0]->prd_prdcd).'",1,"'.($tempPrd[0]->prd_deskripsipendek).'"';
//                            }else{
//                                $isi = $kode.",0,0,".(string)(round((float)$tempPrd[0]->prd_hrgjual)).',"'.($tempPrd[0]->prd_prdcd).'",1,"'.($tempPrd[0]->prd_deskripsipendek).'"';
//                            }
//                        }else{
//                            if($jenis_tmb != '2'){
//                                $isi = $kode.",0,0,".($tempPrd[0]->prd_hrgjual).',"'.($tempPrd[0]->prd_prdcd).'",1,"'.($tempPrd[0]->prd_deskripsipendek).'"';
//                            }else{
//                                $isi = $kode.",0,0,".(string)(round((float)$tempPrd[0]->prd_hrgjual)).',"'.($tempPrd[0]->prd_prdcd).'",1,"'.($tempPrd[0]->prd_deskripsipendek).'"';
//                            }
//                        }
//                        $out_file = fopen($dir1, "w") or die("Unable to open file!");
//                        $vnum = 1; //what is dis for?
//                        if($judul != ''){
//                            fwrite($out_file, $judul.chr(13).chr(10));
//                        }
//                        fwrite($out_file, $isi);
//                        fclose($out_file);
//                        DB::connection(Session::get('connection'))->table("TBTABEL_PLUTIMBANGAN")
//                            ->where('TMB_KODEIGR','=',$kodeigr)
//                            ->whereRaw("TMB_PRDCD = substr('$plu',1,6)||'0'")
//                            ->where('TMB_KODE','=',$kode)
//                            ->delete();
//                    }else{
//                        // GABUNGAN
//                        $in_file = fopen($dir1, "r") or die("Unable to open file!");
//                        $index = 0;
//                        $sub_isi_txt=[];
//                        //menampung data perbaris
//                        while(! feof($in_file))
//                        {
//                            $sub_isi_txt[$index] = fgets($in_file);
//                            $index++;
//                        }
//                        fclose($in_file);
//
//                        //delete file txt
//                        unlink($dir1);
//                        if(($tempPrmd[0]->fpromo) > 0){
//                            if($jenis_tmb != '2'){
//                                $isi = $kode.",0,0,".($hrgpromo->prmd_hrgjual).',"'.($tempPrd[0]->prd_prdcd).'",1,"'.($tempPrd[0]->prd_deskripsipendek).'"';
//                            }else{
//                                $isi = $kode.",0,0,".(string)(round((float)$tempPrd[0]->prd_hrgjual)).',"'.($tempPrd[0]->prd_prdcd).'",1,"'.($tempPrd[0]->prd_deskripsipendek).'"';
//                            }
//                        }else{
//                            if($jenis_tmb != '2'){
//                                $isi = $kode.",0,0,".($tempPrd[0]->prd_hrgjual).',"'.($tempPrd[0]->prd_prdcd).'",1,"'.($tempPrd[0]->prd_deskripsipendek).'"';
//                            }else{
//                                $isi = $kode.",0,0,".(string)(round((float)$tempPrd[0]->prd_hrgjual)).',"'.($tempPrd[0]->prd_prdcd).'",1,"'.($tempPrd[0]->prd_deskripsipendek).'"';
//                            }
//                        }
//                        $out_file = fopen($dir1, "w") or die("Unable to open file!");
//                        for($i=0;$i<$index;$i++){
//                            fwrite($out_file, $sub_isi_txt[$i].chr(13).chr(10));
//                        }
//                        if($judul!=''){ //pasti kosong isi nilai judul :v
//                            fwrite($out_file, $judul.chr(13).chr(10));
//                        }
//                        fwrite($out_file, $isi);
//                        fclose($out_file);
//                    }
//                }else{
//                    if($jenis_tmb != '2'){
//                        $judul = "Plu_No,LabelFormat,BestBefore,UnitPrice,PosCode,Font1,Desc1";
//                    }
//                    if(($tempPrmd[0]->fpromo) > 0){
//                        if($jenis_tmb != '2'){
//                            $isi = $kode.",0,0,".($hrgpromo->prmd_hrgjual).',"'.($tempPrd[0]->prd_prdcd).'",1,"'.($tempPrd[0]->prd_deskripsipendek).'"';
//                        }else{
//                            $isi = $kode.",0,0,".(string)(round((float)$tempPrd[0]->prd_hrgjual)).',"'.($tempPrd[0]->prd_prdcd).'",1,"'.($tempPrd[0]->prd_deskripsipendek).'"';
//                        }
//                    }else{
//                        if($jenis_tmb != '2'){
//                            $isi = $kode.",0,0,".($tempPrd[0]->prd_hrgjual).',"'.($tempPrd[0]->prd_prdcd).'",1,"'.($tempPrd[0]->prd_deskripsipendek).'"';
//                        }else{
//                            $isi = $kode.",0,0,".(string)(round((float)$tempPrd[0]->prd_hrgjual)).',"'.($tempPrd[0]->prd_prdcd).'",1,"'.($tempPrd[0]->prd_deskripsipendek).'"';
//                        }
//                    }
//                    $out_file = fopen($dir1, "w") or die("Unable to open file!");
//                    if($judul!=''){ //pasti ada isinya:v
//                        fwrite($out_file, $judul.chr(13).chr(10));
//                    }
//                    fwrite($out_file, $isi);
//                    fclose($out_file);
//                }
//            }else{
//                //-- HAPUS TRUS BIKIN BARU --
//                if(file_exists($dir2)){
//                    if($lnew2){
//                        unlink($dir2);
//                        $judul = "Plu_No,LabelFormat,BestBefore,UnitPrice,PosCode,Font1,Desc1";
//                        if(($tempPrmd[0]->fpromo) > 0){
//                            if($jenis_tmb != '2'){
//                                $isi = $kode.",0,0,".($hrgpromo->prmd_hrgjual).',"'.($tempPrd[0]->prd_prdcd).'",1,"'.($tempPrd[0]->prd_deskripsipendek).'"';
//                            }else{
//                                $isi = $kode.",0,0,".(string)(round((float)$tempPrd[0]->prd_hrgjual)).',"'.($tempPrd[0]->prd_prdcd).'",1,"'.($tempPrd[0]->prd_deskripsipendek).'"';
//                            }
//                        }else{
//                            if($jenis_tmb != '2'){
//                                $isi = $kode.",0,0,".($tempPrd[0]->prd_hrgjual).',"'.($tempPrd[0]->prd_prdcd).'",1,"'.($tempPrd[0]->prd_deskripsipendek).'"';
//                            }else{
//                                $isi = $kode.",0,0,".(string)(round((float)$tempPrd[0]->prd_hrgjual)).',"'.($tempPrd[0]->prd_prdcd).'",1,"'.($tempPrd[0]->prd_deskripsipendek).'"';
//                            }
//                        }
//                        $out_file = fopen($dir2, "w") or die("Unable to open file!");
//                        fwrite($out_file, $judul.chr(13).chr(10));
//                        fwrite($out_file, $isi);
//                        fclose($out_file);
//                    }else{
//                        // GABUNGAN
//                        $in_file = fopen($dir2, "r") or die("Unable to open file!");
//                        $index = 0;
//                        $sub_isi_txt=[];
//                        //menampung data perbaris
//                        while(! feof($in_file))
//                        {
//                            $sub_isi_txt[$index] = fgets($in_file);
//                            $index++;
//                        }
//                        fclose($in_file);
//
//                        //delete file txt
//                        unlink($dir2);
//                        if(($tempPrmd[0]->fpromo) > 0){
//                            if($jenis_tmb != '2'){
//                                $isi = $kode.",0,0,".($hrgpromo->prmd_hrgjual).',"'.($tempPrd[0]->prd_prdcd).'",1,"'.($tempPrd[0]->prd_deskripsipendek).'"';
//                            }else{
//                                $isi = $kode.",0,0,".(string)(round((float)$tempPrd[0]->prd_hrgjual)).',"'.($tempPrd[0]->prd_prdcd).'",1,"'.($tempPrd[0]->prd_deskripsipendek).'"';
//                            }
//                        }else{
//                            if($jenis_tmb != '2'){
//                                $isi = $kode.",0,0,".($tempPrd[0]->prd_hrgjual).',"'.($tempPrd[0]->prd_prdcd).'",1,"'.($tempPrd[0]->prd_deskripsipendek).'"';
//                            }else{
//                                $isi = $kode.",0,0,".(string)(round((float)$tempPrd[0]->prd_hrgjual)).',"'.($tempPrd[0]->prd_prdcd).'",1,"'.($tempPrd[0]->prd_deskripsipendek).'"';
//                            }
//                        }
//                        $out_file = fopen($dir2, "w") or die("Unable to open file!");
//                        for($i=0;$i<$index;$i++){
//                            fwrite($out_file, $sub_isi_txt[$i].chr(13).chr(10));
//                        }
//                        fwrite($out_file, $isi);
//                        fclose($out_file);
//                    }
//                }else{
//                    $judul = "Plu_No,LabelFormat,BestBefore,UnitPrice,PosCode,Font1,Desc1";
//                    if(($tempPrmd[0]->fpromo) > 0){
//                        if($jenis_tmb != '2'){
//                            $isi = $kode.",0,0,".($hrgpromo->prmd_hrgjual).',"'.($tempPrd[0]->prd_prdcd).'",1,"'.($tempPrd[0]->prd_deskripsipendek).'"';
//                        }else{
//                            $isi = $kode.",0,0,".(string)(round((float)$tempPrd[0]->prd_hrgjual)).',"'.($tempPrd[0]->prd_prdcd).'",1,"'.($tempPrd[0]->prd_deskripsipendek).'"';
//                        }
//                    }else{
//                        if($jenis_tmb != '2'){
//                            $isi = $kode.",0,0,".($tempPrd[0]->prd_hrgjual).',"'.($tempPrd[0]->prd_prdcd).'",1,"'.($tempPrd[0]->prd_deskripsipendek).'"';
//                        }else{
//                            $isi = $kode.",0,0,".(string)(round((float)$tempPrd[0]->prd_hrgjual)).',"'.($tempPrd[0]->prd_prdcd).'",1,"'.($tempPrd[0]->prd_deskripsipendek).'"';
//                        }
//                    }
//                    $out_file = fopen($dir2, "w") or die("Unable to open file!");
//                    fwrite($out_file, $judul.chr(13).chr(10));
//                    fwrite($out_file, $isi);
//                    fclose($out_file);
//
//                }
//                if(($tempPrmd[0]->fpromo) > 0){
//                    if($jenis_tmb != '2'){
//                        $isi = $kode.",0,0,".($hrgpromo->prmd_hrgjual).',"'.($tempPrd[0]->prd_prdcd).'",1,"'.($tempPrd[0]->prd_deskripsipendek).'"';
//                    }else{
//                        $isi = $kode.",0,0,".(string)(round((float)$tempPrd[0]->prd_hrgjual)).',"'.($tempPrd[0]->prd_prdcd).'",1,"'.($tempPrd[0]->prd_deskripsipendek).'"';
//                    }
//                }else{
//                    if($jenis_tmb != '2'){
//                        $isi = $kode.",0,0,".($tempPrd[0]->prd_hrgjual).',"'.($tempPrd[0]->prd_prdcd).'",1,"'.($tempPrd[0]->prd_deskripsipendek).'"';
//                    }else{
//                        $isi = $kode.",0,0,".(string)(round((float)$tempPrd[0]->prd_hrgjual)).',"'.($tempPrd[0]->prd_prdcd).'",1,"'.($tempPrd[0]->prd_deskripsipendek).'"';
//                    }
//                }
//                $out_file = fopen($dir3, "w") or die("Unable to open file!");
//                fwrite($out_file, $judul.chr(13).chr(10));
//                fwrite($out_file, $isi);
//                fclose($out_file);
//            }
//        }
//        DB::connection(Session::get('connection'))->table("tbtabel_plutimbangan")
//            ->where('tmb_kodeigr','=',$kodeigr)
//            ->where('tmb_prdcd','=',$plu)
//            ->where('tmb_kode','=',$kode)
//            ->delete();
//        DB::connection(Session::get('connection'))->commit();
//    }

//    public function shareDir(){
//        //$ip = Session::get('ip');
//        $perusahaan = DB::connection(Session::get('connection'))->table("tbmaster_perusahaan")->selectRaw("PRS_IPSERVER")->first();
//        $path = $perusahaan->prs_ipserver;
//
//        //system('net use S: "'.$path.'"  /persistent:no>nul 2>&1');
//        if(file_exists($path."/LREMOTE/")){
//            //do nothing
//            null;
//        }else{
//            mkdir($path."/LREMOTE/");
//        }
//        if(file_exists($path."/LREMOTE/ISHIDA/")){
//            //do nothing
//            null;
//        }else{
//            mkdir($path."/LREMOTE/ISHIDA/");
//        }
//        if(file_exists($path."/LREMOTE/BIZERBA/")){
//            //do nothing
//            null;
//        }else{
//            mkdir($path."/LREMOTE/BIZERBA/");
//        }
//    }

//    public function CheckDir(Request $request){
//        $perusahaan = DB::connection(Session::get('connection'))->table("tbmaster_perusahaan")->selectRaw("PRS_IPSERVER")->first();
//        $path = $perusahaan->prs_ipserver;
//
//        $path2 = $request->path;
////        $ip = Session::get('ip');
//        $dir = $path.$path2;
//        if(file_exists($dir)){
//            return response()->json(true);
//        }else{
//            return response()->json(false);
//        }
//    }


//    public function Transfer(Request $request) //Ganti Metode, jadi TransferDir1,2, dan 3 lalu didownload, hehe
//    {
//        $perusahaan = DB::connection(Session::get('connection'))->table("tbmaster_perusahaan")->selectRaw("PRS_IPSERVER")->first();
//        $path = $perusahaan->prs_ipserver;
//
//        $kodeigr = Session::get('kdigr');
//        $date1 = $request->date1; //YYYY-MM-DD <-ubahlah jadi
//        $date2 = $request->date2;
////        $date1 = DateTime::createFromFormat('Y-m-d', $date1)->format('d-m-Y');
////        $date2 = DateTime::createFromFormat('Y-m-d', $date2)->format('d-m-Y');
//        $jenis_tmb = $request->jenis_tmb;
//        $alert_button1_1 = $request->alert_button1_1;
//        if($alert_button1_1 === "true"){
//            $alert_button1_1 = true;
//        }else{
//            $alert_button1_1 = false;
//        }
//
//        $alert_button1_2 = $request->alert_button1_2;
//        if($alert_button1_2 === "true"){
//            $alert_button1_2 = true;
//        }else{
//            $alert_button1_2 = false;
//        }
//
//        $alert_button1_3 = $request->alert_button1_3;
//        if($alert_button1_3 === "true"){
//            $alert_button1_3 = true;
//        }else{
//            $alert_button1_3 = false;
//        }
//
//        $alert_button1_4 = $request->alert_button1_4;
//        if($alert_button1_4 === "true"){
//            $alert_button1_4 = true;
//        }else{
//            $alert_button1_4 = false;
//        }
//
//        $dir1 = $path."\LREMOTE\UPDATE.txt";
//        $dir1csv = $path."\LREMOTE\UPDATE.csv";
//        $dir2 = $path."\LREMOTE\ISHIDA\UPDATE.txt";
//        $dir2csv = $path."\LREMOTE\ISHIDA\UPDATE.csv";
//        $dir3 = $path."\LREMOTE\BIZERBA\UPDATE.txt";
//        $dir3csv = $path."\LREMOTE\BIZERBA\UPDATE.csv";
//
//        $judul = '';
//        $isi = '';
//
////        if(file_exists("S:/LREMOTE/")){
////            //do nothing
////            null;
////        }else{
////            mkdir("S:/LREMOTE/");
////        }
////        if(file_exists("S:/LREMOTE/ISHIDA/")){
////            //do nothing
////            null;
////        }else{
////            mkdir("S:/LREMOTE/ISHIDA/");
////        }
////        if(file_exists("S:/LREMOTE/BIZERBA/")){
////            //do nothing
////            null;
////        }else{
////            mkdir("S:/LREMOTE/BIZERBA/");
////        }
//        //step 1
//        if($jenis_tmb != '3'){
//            if(file_exists($dir1)){
//                //step 2 //alert button('update')
//                if($alert_button1_1){
//                    if($jenis_tmb != '2'){
//                        $judul = 'Plu_No,SalesMode,LabelFormat,BestBefore,UnitPrice,PosCode,Font1,Desc1';
//                    }
//                    //step 3
//                    $out_file = fopen($dir1, "w") or die("Unable to open file!");
//                    fwrite($out_file, $judul.chr(13).chr(10));
//
//                    $rec = DB::connection(Session::get('connection'))->select("SELECT   TMB_PRDCD, RPAD(TMB_KODE,4,' ') TMB_KODE, SUBSTR (PRD_PRDCD, 1, 6) || '1' AS PRD_PRDCD,
//                              PRD_UNIT, to_char(PRD_HRGJUAL,'9999999999.99') PRD_HRGJUAL, --add 2 koma (kmy gak bisa proses)
//                              PRD_DESKRIPSIPENDEK, to_char(PRMd_HRGJUAL,'9999999999.99') PRMd_HRGJUAL, --add 2 koma (kmy gak bisa proses)
//                              PRMd_JENISDISC
//                         FROM TBTABEL_PLUTIMBANGAN, TBMASTER_PRODMAST, tbtr_promomd
//                        WHERE CASE
//                                  WHEN TMB_MODIFY_DT IS NOT NULL
//                                      THEN TO_CHAR (TMB_MODIFY_DT, 'YYYY-MM-DD')
//                                  ELSE TO_CHAR (TMB_CREATE_DT, 'YYYY-MM-DD')
//                              END BETWEEN '$date1'
//                                      AND '$date2'
//                          AND TO_CHAR (PRD_PRDCD) = SUBSTR (TMB_PRDCD, 1, 6) || '1'
//                          AND PRMd_PRDCD(+) = PRD_PRDCD
//                          AND nvl(PRD_KODETAG,'q') NOT IN ('N', 'X')
//                          AND TRUNC (SYSDATE) BETWEEN PRMd_TGLawal(+) AND PRMd_TGLAKHIR(+)
//                          AND TMB_KODEIGR = '$kodeigr'
//                     ORDER BY TMB_KODE");
//
//                    for($i=0;$i<sizeof($rec);$i++){
//                        if($rec[$i]->prmd_hrgjual > 0){
//                            if($rec[$i]->prmd_jenisdisc == 'T'){
//                                //step 4
//                                $isi = $rec[$i]->tmb_kode;
//                                if($rec[$i]->prd_unit == 'KG'){
//                                    $isi = $isi.',0,';
//                                }else{
//                                    $isi = $isi.',1,';
//                                }
//                                $isi = $isi.'0,0,'.($rec[$i]->prmd_hrgjual).',"'.($rec[$i]->prd_prdcd).'",1,"'.rtrim($rec[$i]->prd_deskripsipendek).'"';
//                            }else{
//                                //step 5
//                                $isi = $rec[$i]->tmb_kode;
//                                if($rec[$i]->prd_unit == 'KG'){
//                                    $isi = $isi.',0,';
//                                }else{
//                                    $isi = $isi.',1,';
//                                }
//                                $isi = $isi.'0,0,'.($rec[$i]->prd_hrgjual).',"'.($rec[$i]->prd_prdcd).'",1,"'.rtrim($rec[$i]->prd_deskripsipendek).'"';
//                            }
//                        }else{
//                            //step 6
//                            $isi = $rec[$i]->tmb_kode;
//                            if($rec[$i]->prd_unit == 'KG'){
//                                $isi = $isi.',0,';
//                            }else{
//                                $isi = $isi.',1,';
//                            }
//                            $isi = $isi.'0,0,'.($rec[$i]->prd_hrgjual).',"'.($rec[$i]->prd_prdcd).'",1,"'.rtrim($rec[$i]->prd_deskripsipendek).'"';
//                        }
//                        if($jenis_tmb == '2'){
//                            $isi = $rec[$i]->tmb_kode;
//                            //step 7
//                            if($rec[$i]->prd_unit == 'KG'){
//                                $isi = $isi.',0,';
//                            }else{
//                                $isi = $isi.',1,';
//                            }
//                            $isi = $isi.'0,0,'.($rec[$i]->prd_hrgjual).',"'.($rec[$i]->prd_prdcd).'",1,"'.rtrim($rec[$i]->prd_deskripsipendek).'"';
//                        }
//                        fwrite($out_file, $isi.chr(13).chr(10));
//                    }
//                    fclose($out_file);
//
//                    //Apa fungsinya nih!?
//                    copy( $dir1, $dir1csv );
//                    //client_host('cmd /c copy '|| dir1 || ' ' || substr(dir1, 1,length(dir1)-3) ||'csv', no_screen);
//                    //TRANSFER BERHASIL
//                }
//            }else{
//                //step 61
//                if($jenis_tmb != '2'){
//                    $judul = 'Plu_No,SalesMode,LabelFormat,BestBefore,UnitPrice,PosCode,Font1,Desc1';
//                }
//                //step 8
//                $out_file = fopen($dir1, "w") or die("Unable to open file!");
//                fwrite($out_file, $judul.chr(13).chr(10));
//
//                //step 81
//                $rec = DB::connection(Session::get('connection'))->select("SELECT   TMB_PRDCD, RPAD(TMB_KODE,4,' ') TMB_KODE, SUBSTR (PRD_PRDCD, 1, 6) || '1' AS PRD_PRDCD,
//                          PRD_UNIT, to_char(PRD_HRGJUAL,'9999999999.99') PRD_HRGJUAL, --add 2 koma (kmy gak bisa proses)
//                          PRD_DESKRIPSIPENDEK, to_char(PRMd_HRGJUAL,'9999999999.99') PRMd_HRGJUAL, --add 2 koma (kmy gak bisa proses)
//                          PRMd_JENISDISC
//                     FROM TBTABEL_PLUTIMBANGAN, TBMASTER_PRODMAST, tbtr_promomd
//                    WHERE CASE
//                              WHEN TMB_MODIFY_DT IS NOT NULL
//                                  THEN TO_CHAR (TMB_MODIFY_DT, 'YYYY-MM-DD')
//                              ELSE TO_CHAR (TMB_CREATE_DT, 'YYYY-MM-DD')
//                          END BETWEEN '$date1'
//                                  AND '$date2'
//                      AND TO_CHAR (PRD_PRDCD) = SUBSTR (TMB_PRDCD, 1, 6) || '1'
//                      AND PRMd_PRDCD(+) = PRD_PRDCD
//                      AND nvl(PRD_KODETAG,'q') NOT IN ('N', 'X')
//                      AND TRUNC (SYSDATE) BETWEEN PRMd_TGLawal(+) AND PRMd_TGLAKHIR(+)
//                      AND TMB_KODEIGR = '$kodeigr'
//                 ORDER BY TMB_KODE");
//                for($i=0;$i<sizeof($rec);$i++){
//                    if($rec[$i]->prmd_hrgjual > 0){
//                        if($rec[$i]->prmd_jenisdisc == 'T'){
//                            $isi = $rec[$i]->tmb_kode;
//                            if($rec[$i]->prd_unit == 'KG'){
//                                $isi = $isi.',0,';
//                            }else{
//                                $isi = $isi.',1,';
//                            }
//                            $isi = $isi.'0,0,'.($rec[$i]->prmd_hrgjual).',"'.($rec[$i]->prd_prdcd).'",1,"'.rtrim($rec[$i]->prd_deskripsipendek).'"';
//                        }else{
//                            $isi = $rec[$i]->tmb_kode;
//                            if($rec[$i]->prd_unit == 'KG'){
//                                $isi = $isi.',0,';
//                            }else{
//                                $isi = $isi.',1,';
//                            }
//                            $isi = $isi.'0,0,'.($rec[$i]->prd_hrgjual).',"'.($rec[$i]->prd_prdcd).'",1,"'.rtrim($rec[$i]->prd_deskripsipendek).'"';
//                        }
//                    }else{
//                        $isi = $rec[$i]->tmb_kode;
//                        if($rec[$i]->prd_unit == 'KG'){
//                            $isi = $isi.',0,';
//                        }else{
//                            $isi = $isi.',1,';
//                        }
//                        $isi = $isi.'0,0,'.($rec[$i]->prd_hrgjual).',"'.($rec[$i]->prd_prdcd).'",1,"'.rtrim($rec[$i]->prd_deskripsipendek).'"';
//                    }
//                    if($jenis_tmb == '2'){
//                        $isi = $rec[$i]->tmb_kode;
//                        //step 7
//                        if($rec[$i]->prd_unit == 'KG'){
//                            $isi = $isi.',0,';
//                        }else{
//                            $isi = $isi.',1,';
//                        }
//                        $isi = $isi.'0,0,'.($rec[$i]->prd_hrgjual).',"'.($rec[$i]->prd_prdcd).'",1,"'.rtrim($rec[$i]->prd_deskripsipendek).'"';
//                    }
//                    fwrite($out_file, $isi.chr(13).chr(10));
//                }
//                fclose($out_file);
//
//                //Apa nih fungsi nya?
//                //client_host('cmd /c copy '|| dir1 || ' ' || substr(dir1, 1,length(dir1)-3) ||'csv', no_screen);
//                //TRANSFER BERHASIL
//            }
//        }else{
//            //step 100
//            if(file_exists($dir2)){
//                //step 101
//                if($alert_button1_2){
//                    //step102
//                    unlink($dir2);
//                    // 	--+ BIZERBA +--
//                    if(file_exists($dir3)){
//                        //step 103
//                        //step 104
//                        if($alert_button1_3){
//                            unlink($dir3);
//                            //--+ PROSES ISHIDA +--
//                            //step 105
//                            $judul = 'Plu_No,SalesMode,LabelFormat,BestBefore,UnitPrice,PosCode,Font1,Desc1';
//                            $out_file = fopen($dir2, "w") or die("Unable to open file!");
//                            fwrite($out_file, $judul.chr(13).chr(10));
//                            //step 106
//                            $rec = DB::connection(Session::get('connection'))->select("SELECT   TMB_PRDCD, RPAD(TMB_KODE,4,' ') TMB_KODE,
//                                      SUBSTR (PRD_PRDCD, 1, 6) || '1' AS PRD_PRDCD, PRD_UNIT,
//                                      to_char(PRD_HRGJUAL,'9999999999.99') PRD_HRGJUAL, --add 2 koma (kmy gak bisa proses)
//                                      PRD_DESKRIPSIPENDEK, to_char(PRMd_HRGJUAL,'9999999999.99') PRMd_HRGJUAL, --add 2 koma (kmy gak bisa proses)
//                                      PRMd_JENISDISC
//                                 FROM TBTABEL_PLUTIMBANGAN, TBMASTER_PRODMAST, tbtr_promomd
//                                WHERE CASE
//                                          WHEN TMB_MODIFY_DT IS NOT NULL
//                                              THEN TO_CHAR (TMB_MODIFY_DT, 'YYYY-MM-DD')
//                                          ELSE TO_CHAR (TMB_CREATE_DT, 'YYYY-MM-DD')
//                                      END BETWEEN '$date1'
//                                              AND '$date2'
//                                  AND TO_CHAR (PRD_PRDCD) = SUBSTR (TMB_PRDCD, 1, 6) || '1'
//                                  AND PRMd_PRDCD(+) = PRD_PRDCD
//                                  AND nvl(PRD_KODETAG,'q') NOT IN ('N', 'X')
//                                  AND TRUNC (SYSDATE) BETWEEN PRMd_TGLawal(+) AND PRMd_TGLAKHIR(+)
//                                  AND TMB_KODEIGR = '$kodeigr'
//                             ORDER BY TMB_KODE");
//
//                            for($i=0;$i<sizeof($rec);$i++){
//                                if($rec[$i]->prmd_hrgjual > 0){
//                                    if($rec[$i]->prmd_jenisdisc == 'T'){
//                                        $isi = $rec[$i]->tmb_kode;
//                                        if($rec[$i]->prd_unit == 'KG'){
//                                            $isi = $isi.',0,';
//                                        }else{
//                                            $isi = $isi.',1,';
//                                        }
//                                        $isi = $isi.'0,0,'.($rec[$i]->prmd_hrgjual).',"'.($rec[$i]->prd_prdcd).'",1,"'.rtrim($rec[$i]->prd_deskripsipendek).'"';
//                                    }else{
//                                        $isi = $rec[$i]->tmb_kode;
//                                        if($rec[$i]->prd_unit == 'KG'){
//                                            $isi = $isi.',0,';
//                                        }else{
//                                            $isi = $isi.',1,';
//                                        }
//                                        $isi = $isi.'0,0,'.($rec[$i]->prd_hrgjual).',"'.($rec[$i]->prd_prdcd).'",1,"'.rtrim($rec[$i]->prd_deskripsipendek).'"';
//                                    }
//                                }else{
//                                    $isi = $rec[$i]->tmb_kode;
//                                    if($rec[$i]->prd_unit == 'KG'){
//                                        $isi = $isi.',0,';
//                                    }else{
//                                        $isi = $isi.',1,';
//                                    }
//                                    $isi = $isi.'0,0,'.($rec[$i]->prd_hrgjual).',"'.($rec[$i]->prd_prdcd).'",1,"'.rtrim($rec[$i]->prd_deskripsipendek).'"';
//                                }
//                                fwrite($out_file, $isi.chr(13).chr(10));
//                            }
//                            fclose($out_file);
//
//                            //Apa fungsinya nih!?
//                            copy( $dir2, $dir2csv );
//                            //client_host('cmd /c copy '|| dir2 || ' ' || substr(dir2, 1,length(dir2)-3) ||'csv', no_screen);
//            //--- PROSES ISHIDA ---
//            //--+ PROSES BIZERBA +--
//                            //step 107
//                            $out_file = fopen($dir3, "w") or die("Unable to open file!");
//                            fwrite($out_file, chr(13).chr(10));
//                            // step 1071
//
//                            $rec = DB::connection(Session::get('connection'))->select("SELECT   TMB_PRDCD, RPAD(TMB_KODE,4,' ') TMB_KODE,
//                                      SUBSTR (PRD_PRDCD, 1, 6) || '1' AS PRD_PRDCD, PRD_UNIT,
//                                      to_char(PRD_HRGJUAL,'9999999999.99') PRD_HRGJUAL, --add 2 koma (kmy gak bisa proses)
//                                      PRD_DESKRIPSIPENDEK, to_char(PRMd_HRGJUAL,'9999999999.99') PRMd_HRGJUAL, --add 2 koma (kmy gak bisa proses)
//                                      PRMd_JENISDISC
//                                 FROM TBTABEL_PLUTIMBANGAN, TBMASTER_PRODMAST, tbtr_promomd
//                                WHERE CASE
//                                          WHEN TMB_MODIFY_DT IS NOT NULL
//                                              THEN TO_CHAR (TMB_MODIFY_DT, 'YYYY-MM-DD')
//                                          ELSE TO_CHAR (TMB_CREATE_DT, 'YYYY-MM-DD')
//                                      END BETWEEN '$date1'
//                                              AND '$date2'
//                                  AND TO_CHAR (PRD_PRDCD) = SUBSTR (TMB_PRDCD, 1, 6) || '1'
//                                  AND PRMd_PRDCD(+) = PRD_PRDCD
//                                  AND nvl(PRD_KODETAG,'q') NOT IN ('N', 'X')
//                                  AND TRUNC (SYSDATE) BETWEEN PRMd_TGLawal(+) AND PRMd_TGLAKHIR(+)
//                                  AND TMB_KODEIGR = '$kodeigr'
//                             ORDER BY TMB_KODE");
//
//                            for($i=0;$i<sizeof($rec);$i++){
//                                if($rec[$i]->prmd_hrgjual > 0){
//                                    if($rec[$i]->prmd_jenisdisc == 'T'){
//                                        $isi = $rec[$i]->tmb_kode;
//                                        if($rec[$i]->prd_unit == 'KG'){
//                                            $isi = $isi.',0,';
//                                        }else{
//                                            $isi = $isi.',1,';
//                                        }
//                                        $isi = $isi.'0,0,'.($rec[$i]->prmd_hrgjual).',"'.($rec[$i]->prd_prdcd).'",1,"'.rtrim($rec[$i]->prd_deskripsipendek).'"';
//                                    }else{
//                                        $isi = $rec[$i]->tmb_kode;
//                                        if($rec[$i]->prd_unit == 'KG'){
//                                            $isi = $isi.',0,';
//                                        }else{
//                                            $isi = $isi.',1,';
//                                        }
//                                        $isi = $isi.'0,0,'.($rec[$i]->prd_hrgjual).',"'.($rec[$i]->prd_prdcd).'",1,"'.rtrim($rec[$i]->prd_deskripsipendek).'"';
//                                    }
//                                }else{
//                                    $isi = $rec[$i]->tmb_kode;
//                                    if($rec[$i]->prd_unit == 'KG'){
//                                        $isi = $isi.',0,';
//                                    }else{
//                                        $isi = $isi.',1,';
//                                    }
//                                    $isi = $isi.'0,0,'.($rec[$i]->prd_hrgjual).',"'.($rec[$i]->prd_prdcd).'",1,"'.rtrim($rec[$i]->prd_deskripsipendek).'"';
//                                }
//                                fwrite($out_file, $isi.chr(13).chr(10));
//                            }
//                            fclose($out_file);
//
//                            //Apa fungsinya nih!?
//                            copy( $dir3, $dir3csv );
//                            //client_host('cmd /c copy '|| dir3 || ' ' || substr(dir3, 1,length(dir3)-3) ||'csv', no_screen);
//                            //TRANSFER BERHASIL
//                        //--- PROSES BIZERBA ---
//                        }else{
//                            // --+ PROSES ISHIDA +--
//                            //step 108
//
//                            $judul = 'Plu_No,SalesMode,LabelFormat,BestBefore,UnitPrice,PosCode,Font1,Desc1';
//                            $out_file = fopen($dir2, "w") or die("Unable to open file!");
//                            fwrite($out_file, $judul.chr(13).chr(10));
//                            //step 1081
//                            $rec = DB::connection(Session::get('connection'))->select("SELECT   TMB_PRDCD, RPAD(TMB_KODE,4,' ') TMB_KODE, SUBSTR (PRD_PRDCD, 1, 6) || '1'
//                                                                                      AS PRD_PRDCD,
//                                  PRD_UNIT, to_char(PRD_HRGJUAL,'9999999999.99') PRD_HRGJUAL, --add 2 koma (kmy gak bisa proses)
//                                  PRD_DESKRIPSIPENDEK, to_char(PRMd_HRGJUAL,'9999999999.99') PRMd_HRGJUAL, --add 2 koma (kmy gak bisa proses)
//                                  PRMd_JENISDISC
//                             FROM TBTABEL_PLUTIMBANGAN, TBMASTER_PRODMAST, tbtr_promomd
//                            WHERE CASE
//                                      WHEN TMB_MODIFY_DT IS NOT NULL
//                                          THEN TO_CHAR (TMB_MODIFY_DT, 'YYYY-MM-DD')
//                                      ELSE TO_CHAR (TMB_CREATE_DT, 'YYYY-MM-DD')
//                                  END BETWEEN '$date1'
//                                          AND '$date2'
//                              AND TO_CHAR (PRD_PRDCD) = SUBSTR (TMB_PRDCD, 1, 6) || '1'
//                              AND PRMd_PRDCD(+) = PRD_PRDCD
//                              AND nvl(PRD_KODETAG,'q') NOT IN ('N', 'X')
//                              AND TRUNC (SYSDATE) BETWEEN PRMd_TGLawal(+) AND PRMd_TGLAKHIR(+)
//                              AND TMB_KODEIGR = '$kodeigr'
//                         ORDER BY TMB_KODE");
//
//                            for($i=0;$i<sizeof($rec);$i++){
//                                if($rec[$i]->prmd_hrgjual > 0){
//                                    if($rec[$i]->prmd_jenisdisc == 'T'){
//                                        $isi = $rec[$i]->tmb_kode;
//                                        if($rec[$i]->prd_unit == 'KG'){
//                                            $isi = $isi.',0,';
//                                        }else{
//                                            $isi = $isi.',1,';
//                                        }
//                                        $isi = $isi.'0,0,'.($rec[$i]->prmd_hrgjual).',"'.($rec[$i]->prd_prdcd).'",1,"'.rtrim($rec[$i]->prd_deskripsipendek).'"';
//                                    }else{
//                                        $isi = $rec[$i]->tmb_kode;
//                                        if($rec[$i]->prd_unit == 'KG'){
//                                            $isi = $isi.',0,';
//                                        }else{
//                                            $isi = $isi.',1,';
//                                        }
//                                        $isi = $isi.'0,0,'.($rec[$i]->prd_hrgjual).',"'.($rec[$i]->prd_prdcd).'",1,"'.rtrim($rec[$i]->prd_deskripsipendek).'"';
//                                    }
//                                }else{
//                                    $isi = $rec[$i]->tmb_kode;
//                                    if($rec[$i]->prd_unit == 'KG'){
//                                        $isi = $isi.',0,';
//                                    }else{
//                                        $isi = $isi.',1,';
//                                    }
//                                    $isi = $isi.'0,0,'.($rec[$i]->prd_hrgjual).',"'.($rec[$i]->prd_prdcd).'",1,"'.rtrim($rec[$i]->prd_deskripsipendek).'"';
//                                }
//                                fwrite($out_file, $isi.chr(13).chr(10));
//                            }
//                            //step 1082
//                            fclose($out_file);
//
//                            //Apa fungsinya nih!?
//                            copy( $dir2, $dir2csv );
//                            //client_host('cmd /c copy '|| dir2 || ' ' || substr(dir2, 1,length(dir2)-3) ||'csv', no_screen);
//
//                            //--- PROSES ISHIDA ---
//                            //--+ PROSES BIZERBA +--
//
//                            //step 109
//                            $out_file = fopen($dir3, "w") or die("Unable to open file!");
//                            fwrite($out_file, chr(13).chr(10));
//                            $rec = DB::connection(Session::get('connection'))->select("SELECT   TMB_PRDCD, RPAD(TMB_KODE,4,' ') TMB_KODE, SUBSTR (PRD_PRDCD, 1, 6) || '1' AS PRD_PRDCD,
//                                  PRD_UNIT, to_char(PRD_HRGJUAL,'9999999999.99') PRD_HRGJUAL, --add 2 koma (kmy gak bisa proses)
//                                  PRD_DESKRIPSIPENDEK, to_char(PRMd_HRGJUAL,'9999999999.99') PRMd_HRGJUAL, --add 2 koma (kmy gak bisa proses)
//                                  PRMd_JENISDISC
//                             FROM TBTABEL_PLUTIMBANGAN, TBMASTER_PRODMAST, tbtr_promomd
//                            WHERE CASE
//                                      WHEN TMB_MODIFY_DT IS NOT NULL
//                                          THEN TO_CHAR (TMB_MODIFY_DT, 'YYYY-MM-DD')
//                                      ELSE TO_CHAR (TMB_CREATE_DT, 'YYYY-MM-DD')
//                                  END BETWEEN TO_CHAR (:TXT_TGL1, 'YYYY-MM-DD')
//                                          AND TO_CHAR (:TXT_TGL2, 'YYYY-MM-DD')
//                              AND TO_CHAR (PRD_PRDCD) = SUBSTR (TMB_PRDCD, 1, 6) || '1'
//                              AND PRMd_PRDCD(+) = PRD_PRDCD
//                              AND nvl(PRD_KODETAG,'q') NOT IN ('N', 'X')
//                              AND TRUNC (SYSDATE) BETWEEN PRMd_TGLawal(+) AND PRMd_TGLAKHIR(+)
//                              AND TMB_KODEIGR = :GLOBAL.KDIGR
//                         ORDER BY TMB_KODE");
//                            for($i=0;$i<sizeof($rec);$i++){
//                                if($rec[$i]->prmd_hrgjual > 0){
//                                    if($rec[$i]->prmd_jenisdisc == 'T'){
//                                        $isi = $rec[$i]->tmb_kode;
//                                        if($rec[$i]->prd_unit == 'KG'){
//                                            $isi = $isi.',0,';
//                                        }else{
//                                            $isi = $isi.',1,';
//                                        }
//                                        $isi = $isi.'0,0,'.($rec[$i]->prmd_hrgjual).',"'.($rec[$i]->prd_prdcd).'",1,"'.rtrim($rec[$i]->prd_deskripsipendek).'"';
//                                    }else{
//                                        $isi = $rec[$i]->tmb_kode;
//                                        if($rec[$i]->prd_unit == 'KG'){
//                                            $isi = $isi.',0,';
//                                        }else{
//                                            $isi = $isi.',1,';
//                                        }
//                                        $isi = $isi.'0,0,'.($rec[$i]->prd_hrgjual).',"'.($rec[$i]->prd_prdcd).'",1,"'.rtrim($rec[$i]->prd_deskripsipendek).'"';
//                                    }
//                                }else{
//                                    $isi = $rec[$i]->tmb_kode;
//                                    if($rec[$i]->prd_unit == 'KG'){
//                                        $isi = $isi.',0,';
//                                    }else{
//                                        $isi = $isi.',1,';
//                                    }
//                                    $isi = $isi.'0,0,'.($rec[$i]->prd_hrgjual).',"'.($rec[$i]->prd_prdcd).'",1,"'.rtrim($rec[$i]->prd_deskripsipendek).'"';
//                                }
//                                fwrite($out_file, $isi.chr(13).chr(10));
//                            }
//                            fclose($out_file);
//
//                            //Apa fungsinya nih!?
//                            copy( $dir3, $dir3csv );
//                            //client_host('cmd /c copy '|| dir3 || ' ' || substr(dir3, 1,length(dir3)-3) ||'csv', no_screen);
//                            //--- PROSES BIZERBA ---
//                        }
//                    }
//                    //--- BIZERBA ---
//                }
//            }else{
//                //--+ ISHIDA ELSE +--
//                //step 110
//                if(file_exists($dir3)){
//                    if($alert_button1_4){
//                        //step 111
//                        unlink($dir3);
//                        //step 112
//                        //--+ PROSES ISHIDA +--
//                        $judul = 'Plu_No,SalesMode,LabelFormat,BestBefore,UnitPrice,PosCode,Font1,Desc1';
//                        $out_file = fopen($dir2, "w") or die("Unable to open file!");
//                        fwrite($out_file, $judul.chr(13).chr(10));
//                        //step 113
//                        $rec = DB::connection(Session::get('connection'))->select("SELECT   TMB_PRDCD, RPAD(TMB_KODE,4,' ') TMB_KODE, SUBSTR (PRD_PRDCD, 1, 6) || '1'
//                                                                                      AS PRD_PRDCD,
//                                  PRD_UNIT, to_char(PRD_HRGJUAL,'9999999999.99') PRD_HRGJUAL, --add 2 koma (kmy gak bisa proses)
//                                  PRD_DESKRIPSIPENDEK, to_char(PRMd_HRGJUAL,'9999999999.99') PRMd_HRGJUAL, --add 2 koma (kmy gak bisa proses)
//                                  PRMd_JENISDISC
//                             FROM TBTABEL_PLUTIMBANGAN, TBMASTER_PRODMAST, tbtr_promomd
//                            WHERE CASE
//                                      WHEN TMB_MODIFY_DT IS NOT NULL
//                                          THEN TO_CHAR (TMB_MODIFY_DT, 'YYYY-MM-DD')
//                                      ELSE TO_CHAR (TMB_CREATE_DT, 'YYYY-MM-DD')
//                                  END BETWEEN '$date1'
//                                          AND '$date2'
//                              AND TO_CHAR (PRD_PRDCD) = SUBSTR (TMB_PRDCD, 1, 6) || '1'
//                              AND PRMd_PRDCD(+) = PRD_PRDCD
//                              AND nvl(PRD_KODETAG,'q') NOT IN ('N', 'X')
//                              AND TRUNC (SYSDATE) BETWEEN PRMd_TGLawal(+) AND PRMd_TGLAKHIR(+)
//                              AND TMB_KODEIGR = '$kodeigr'
//                         ORDER BY TMB_KODE");
//                        for($i=0;$i<sizeof($rec);$i++){
//                            if($rec[$i]->prmd_hrgjual > 0){
//                                if($rec[$i]->prmd_jenisdisc == 'T'){
//                                    $isi = $rec[$i]->tmb_kode;
//                                    if($rec[$i]->prd_unit == 'KG'){
//                                        $isi = $isi.',0,';
//                                    }else{
//                                        $isi = $isi.',1,';
//                                    }
//                                    $isi = $isi.'0,0,'.($rec[$i]->prmd_hrgjual).',"'.($rec[$i]->prd_prdcd).'",1,"'.rtrim($rec[$i]->prd_deskripsipendek).'"';
//                                }else{
//                                    $isi = $rec[$i]->tmb_kode;
//                                    if($rec[$i]->prd_unit == 'KG'){
//                                        $isi = $isi.',0,';
//                                    }else{
//                                        $isi = $isi.',1,';
//                                    }
//                                    $isi = $isi.'0,0,'.($rec[$i]->prd_hrgjual).',"'.($rec[$i]->prd_prdcd).'",1,"'.rtrim($rec[$i]->prd_deskripsipendek).'"';
//                                }
//                            }else{
//                                $isi = $rec[$i]->tmb_kode;
//                                if($rec[$i]->prd_unit == 'KG'){
//                                    $isi = $isi.',0,';
//                                }else{
//                                    $isi = $isi.',1,';
//                                }
//                                $isi = $isi.'0,0,'.($rec[$i]->prd_hrgjual).',"'.($rec[$i]->prd_prdcd).'",1,"'.rtrim($rec[$i]->prd_deskripsipendek).'"';
//                            }
//                            fwrite($out_file, $isi.chr(13).chr(10));
//                        }
//                        fclose($out_file);
//
//                        //Apa fungsinya nih!?
//                        copy( $dir2, $dir2csv );
//                        //client_host('cmd /c copy '|| dir2 || ' ' || substr(dir2, 1,length(dir2)-3) ||'csv', no_screen);
//                        //--- PROSES ISHIDA ---
//
//                        //--+ PROSES BIZERBA +--
//                        $out_file = fopen($dir3, "w") or die("Unable to open file!");
//                        fwrite($out_file, chr(13).chr(10));
//                        //step 114
//                        $rec = DB::connection(Session::get('connection'))->select("SELECT   TMB_PRDCD, RPAD(TMB_KODE,4,' ') TMB_KODE, SUBSTR (PRD_PRDCD, 1, 6) || '1' AS PRD_PRDCD,
//                                  PRD_UNIT, to_char(PRD_HRGJUAL,'9999999999.99') PRD_HRGJUAL, --add 2 koma (kmy gak bisa proses)
//                                  PRD_DESKRIPSIPENDEK, to_char(PRMd_HRGJUAL,'9999999999.99') PRMd_HRGJUAL, --add 2 koma (kmy gak bisa proses)
//                                  PRMd_JENISDISC
//                             FROM TBTABEL_PLUTIMBANGAN, TBMASTER_PRODMAST, tbtr_promomd
//                            WHERE CASE
//                                      WHEN TMB_MODIFY_DT IS NOT NULL
//                                          THEN TO_CHAR (TMB_MODIFY_DT, 'YYYY-MM-DD')
//                                      ELSE TO_CHAR (TMB_CREATE_DT, 'YYYY-MM-DD')
//                                  END BETWEEN '$date1'
//                                          AND '$date2'
//                              AND TO_CHAR (PRD_PRDCD) = SUBSTR (TMB_PRDCD, 1, 6) || '1'
//                              AND PRMd_PRDCD(+) = PRD_PRDCD
//                              AND nvl(PRD_KODETAG,'q') NOT IN ('N', 'X')
//                              AND TRUNC (SYSDATE) BETWEEN PRMd_TGLawal(+) AND PRMd_TGLAKHIR(+)
//                              AND TMB_KODEIGR = '$kodeigr'
//                         ORDER BY TMB_KODE");
//                        for($i=0;$i<sizeof($rec);$i++){
//                            if($rec[$i]->prmd_hrgjual > 0){
//                                if($rec[$i]->prmd_jenisdisc == 'T'){
//                                    $isi = $rec[$i]->tmb_kode;
//                                    if($rec[$i]->prd_unit == 'KG'){
//                                        $isi = $isi.',0,';
//                                    }else{
//                                        $isi = $isi.',1,';
//                                    }
//                                    $isi = $isi.'0,0,'.($rec[$i]->prmd_hrgjual).',"'.($rec[$i]->prd_prdcd).'",1,"'.rtrim($rec[$i]->prd_deskripsipendek).'"';
//                                }else{
//                                    $isi = $rec[$i]->tmb_kode;
//                                    if($rec[$i]->prd_unit == 'KG'){
//                                        $isi = $isi.',0,';
//                                    }else{
//                                        $isi = $isi.',1,';
//                                    }
//                                    $isi = $isi.'0,0,'.($rec[$i]->prd_hrgjual).',"'.($rec[$i]->prd_prdcd).'",1,"'.rtrim($rec[$i]->prd_deskripsipendek).'"';
//                                }
//                            }else{
//                                $isi = $rec[$i]->tmb_kode;
//                                if($rec[$i]->prd_unit == 'KG'){
//                                    $isi = $isi.',0,';
//                                }else{
//                                    $isi = $isi.',1,';
//                                }
//                                $isi = $isi.'0,0,'.($rec[$i]->prd_hrgjual).',"'.($rec[$i]->prd_prdcd).'",1,"'.rtrim($rec[$i]->prd_deskripsipendek).'"';
//                            }
//                            fwrite($out_file, $isi.chr(13).chr(10));
//                        }
//                        fclose($out_file);
//
//                        //Apa fungsinya nih!?
//                        copy( $dir3, $dir3csv );
//                        //client_host('cmd /c copy '|| dir3 || ' ' || substr(dir3, 1,length(dir3)-3) ||'csv', no_screen);
//                        //TRANSFER BERHASIL
//                        //--- PROSES BIZERBA ---
//                    }else{
//                        //--+ PROSES ISHIDA +--
//                        //step 115
//                        $judul = 'Plu_No,SalesMode,LabelFormat,BestBefore,UnitPrice,PosCode,Font1,Desc1';
//                        //step 1151
//                        //step 1152
//                        $out_file = fopen($dir2, "w") or die("Unable to open file!");
//                        //step 1153
//                        fwrite($out_file, $judul.chr(13).chr(10));
//                        //step 116
//                        $rec = DB::connection(Session::get('connection'))->select("SELECT   TMB_PRDCD, RPAD(TMB_KODE,4,' ') TMB_KODE, SUBSTR (PRD_PRDCD, 1, 6) || '1' AS PRD_PRDCD,
//                              PRD_UNIT, to_char(PRD_HRGJUAL,'9999999999.99') PRD_HRGJUAL, --add 2 koma (kmy gak bisa proses)
//                              PRD_DESKRIPSIPENDEK, to_char(PRMd_HRGJUAL,'9999999999.99') PRMd_HRGJUAL, --add 2 koma (kmy gak bisa proses)
//                              PRMd_JENISDISC
//                         FROM TBTABEL_PLUTIMBANGAN, TBMASTER_PRODMAST, tbtr_promomd
//                        WHERE CASE
//                                  WHEN TMB_MODIFY_DT IS NOT NULL
//                                      THEN TO_CHAR (TMB_MODIFY_DT, 'YYYY-MM-DD')
//                                  ELSE TO_CHAR (TMB_CREATE_DT, 'YYYY-MM-DD')
//                              END BETWEEN '$date1'
//                                      AND '$date2'
//                          AND TO_CHAR (PRD_PRDCD) = SUBSTR (TMB_PRDCD, 1, 6) || '1'
//                          AND PRMd_PRDCD(+) = PRD_PRDCD
//                          AND nvl(PRD_KODETAG,'q') NOT IN ('N', 'X')
//                          AND TRUNC (SYSDATE) BETWEEN PRMd_TGLawal(+) AND PRMd_TGLAKHIR(+)
//                          AND TMB_KODEIGR = '$kodeigr'
//                     ORDER BY TMB_KODE");
//                        for($i=0;$i<sizeof($rec);$i++){
//                            if($rec[$i]->prmd_hrgjual > 0){
//                                if($rec[$i]->prmd_jenisdisc == 'T'){
//                                    $isi = $rec[$i]->tmb_kode;
//                                    if($rec[$i]->prd_unit == 'KG'){
//                                        $isi = $isi.',0,';
//                                    }else{
//                                        $isi = $isi.',1,';
//                                    }
//                                    $isi = $isi.'0,0,'.($rec[$i]->prmd_hrgjual).',"'.($rec[$i]->prd_prdcd).'",1,"'.rtrim($rec[$i]->prd_deskripsipendek).'"';
//                                }else{
//                                    $isi = $rec[$i]->tmb_kode;
//                                    if($rec[$i]->prd_unit == 'KG'){
//                                        $isi = $isi.',0,';
//                                    }else{
//                                        $isi = $isi.',1,';
//                                    }
//                                    $isi = $isi.'0,0,'.($rec[$i]->prd_hrgjual).',"'.($rec[$i]->prd_prdcd).'",1,"'.rtrim($rec[$i]->prd_deskripsipendek).'"';
//                                }
//                            }else{
//                                $isi = $rec[$i]->tmb_kode;
//                                if($rec[$i]->prd_unit == 'KG'){
//                                    $isi = $isi.',0,';
//                                }else{
//                                    $isi = $isi.',1,';
//                                }
//                                $isi = $isi.'0,0,'.($rec[$i]->prd_hrgjual).',"'.($rec[$i]->prd_prdcd).'",1,"'.rtrim($rec[$i]->prd_deskripsipendek).'"';
//                            }
//                            fwrite($out_file, $isi.chr(13).chr(10));
//                        }
//                        fclose($out_file);
//
//                        //Apa fungsinya nih!?
//                        copy( $dir2, $dir2csv );
//                        //client_host('cmd /c copy '|| dir2 || ' ' || substr(dir2, 1,length(dir2)-3) ||'csv', no_screen);
//                        //--- PROSES ISHIDA ---
//                        //--+ PROSES BIZERBA +--
//                        $out_file = fopen($dir3, "w") or die("Unable to open file!");
//                        fwrite($out_file, chr(13).chr(10));
//                        //step 117
//                        $rec = DB::connection(Session::get('connection'))->select("SELECT   TMB_PRDCD, RPAD(TMB_KODE,4,' ') TMB_KODE, SUBSTR (PRD_PRDCD, 1, 6) || '1' AS PRD_PRDCD,
//                              PRD_UNIT, to_char(PRD_HRGJUAL,'9999999999.99') PRD_HRGJUAL, --add 2 koma (kmy gak bisa proses)
//                              PRD_DESKRIPSIPENDEK, to_char(PRMd_HRGJUAL,'9999999999.99') PRMd_HRGJUAL, --add 2 koma (kmy gak bisa proses)
//                              PRMd_JENISDISC
//                         FROM TBTABEL_PLUTIMBANGAN, TBMASTER_PRODMAST, tbtr_promomd
//                        WHERE CASE
//                                  WHEN TMB_MODIFY_DT IS NOT NULL
//                                      THEN TO_CHAR (TMB_MODIFY_DT, 'YYYY-MM-DD')
//                                  ELSE TO_CHAR (TMB_CREATE_DT, 'YYYY-MM-DD')
//                              END BETWEEN '$date1'
//                                      AND '$date2'
//                          AND TO_CHAR (PRD_PRDCD) = SUBSTR (TMB_PRDCD, 1, 6) || '1'
//                          AND PRMd_PRDCD(+) = PRD_PRDCD
//                          AND nvl(PRD_KODETAG,'q') NOT IN ('N', 'X')
//                          AND TRUNC (SYSDATE) BETWEEN PRMd_TGLawal(+) AND PRMd_TGLAKHIR(+)
//                          AND TMB_KODEIGR = '$kodeigr'
//                     ORDER BY TMB_KODE");
//                        for($i=0;$i<sizeof($rec);$i++){
//                            if($rec[$i]->prmd_hrgjual > 0){
//                                if($rec[$i]->prmd_jenisdisc == 'T'){
//                                    $isi = $rec[$i]->tmb_kode;
//                                    if($rec[$i]->prd_unit == 'KG'){
//                                        $isi = $isi.',0,';
//                                    }else{
//                                        $isi = $isi.',1,';
//                                    }
//                                    $isi = $isi.'0,0,'.($rec[$i]->prmd_hrgjual).',"'.($rec[$i]->prd_prdcd).'",1,"'.rtrim($rec[$i]->prd_deskripsipendek).'"';
//                                }else{
//                                    $isi = $rec[$i]->tmb_kode;
//                                    if($rec[$i]->prd_unit == 'KG'){
//                                        $isi = $isi.',0,';
//                                    }else{
//                                        $isi = $isi.',1,';
//                                    }
//                                    $isi = $isi.'0,0,'.($rec[$i]->prd_hrgjual).',"'.($rec[$i]->prd_prdcd).'",1,"'.rtrim($rec[$i]->prd_deskripsipendek).'"';
//                                }
//                            }else{
//                                $isi = $rec[$i]->tmb_kode;
//                                if($rec[$i]->prd_unit == 'KG'){
//                                    $isi = $isi.',0,';
//                                }else{
//                                    $isi = $isi.',1,';
//                                }
//                                $isi = $isi.'0,0,'.($rec[$i]->prd_hrgjual).',"'.($rec[$i]->prd_prdcd).'",1,"'.rtrim($rec[$i]->prd_deskripsipendek).'"';
//                            }
//                            fwrite($out_file, $isi.chr(13).chr(10));
//                        }
//                        fclose($out_file);
//
//                        //Apa fungsinya nih!?
//                        copy( $dir3, $dir3csv );
//                        //client_host('cmd /c copy '|| dir3 || ' ' || substr(dir3, 1,length(dir3)-3) ||'csv', no_screen);
//                        //TRANSFER BERHASIL
//                        //--- PROSES BIZERBA ---
//                    }
//                }
//            }
//        }
//
//        //EXCEPTION untuk meminta mapping ke directory S:
//    }

    public function Print(Request $request){
        $kodeigr = Session::get('kdigr');
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

        $datas = DB::connection(Session::get('connection'))->select("SELECT PRS_NAMAPERUSAHAAN, PRS_NAMACABANG, PRS_NAMAWILAYAH, SUBSTR(TMB_PRDCD,1,6)||'1' PLU, PRD_PRDCD, PRD_DESC, PRD_SATUAN, PRD_KODETAG, HRG_JUAL, TMB_KODE
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
".$p_val."
".$p_order);

        //-------------------------PRINT-----------------------------
        $perusahaan = DB::table("tbmaster_perusahaan")->first();
//        $pdf = PDF::loadview('TABEL.plu-timbangan-pdf', ['data' => $datas, 'today' => $today, 'time' => $time, 'perusahaan' => $perusahaan]);
//        $pdf->output();
//        $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);
//
//        $canvas = $dompdf ->get_canvas();
//        $canvas->page_text(511, 78, "{PAGE_NUM} / {PAGE_COUNT}", null, 7, array(0, 0, 0));
//
//        return $pdf->stream('Plu-Timbangan.pdf');
        return view('TABEL.plu-timbangan-pdf', ['data' => $datas, 'today' => $today, 'time' => $time, 'perusahaan' => $perusahaan]);
    }

    public function LovKode(Request $request){
        $kodeigr = Session::get('kdigr');
        $search = $request->value;

        $datas   = DB::connection(Session::get('connection'))->table('TBTABEL_PLUTIMBANGAN')
            ->selectRaw("TMB_DESKRIPSI1, TMB_KODE, PRD_FRAC, PRD_HRGJUAL")
//            ->leftJoin("TBMASTER_PRODMAST","TBTABEL_PLUTIMBANGAN.TMB_PRDCD",'=','TBMASTER_PRODMAST.PRD_PRDCD ')
            ->LeftJoin('TBMASTER_PRODMAST',function($join){
                $join->on('TMB_PRDCD','PRD_PRDCD');
            })
            ->where('TMB_DESKRIPSI1','LIKE', '%'.$search.'%')
            ->where('prd_kodeigr','=',Session::get('kdigr'))

            ->orWhere('TMB_KODE','LIKE', '%'.$search.'%')
            ->where('prd_kodeigr','=',Session::get('kdigr'))

            ->orWhere('PRD_FRAC','LIKE', '%'.$search.'%')
            ->where('prd_kodeigr','=',Session::get('kdigr'))

            ->orWhere('PRD_HRGJUAL','LIKE', '%'.$search.'%')
            ->where('prd_kodeigr','=',Session::get('kdigr'))

            ->orderBy('TMB_KODE')
            ->limit(100)
            ->get();

//        $datas = DB::connection(Session::get('connection'))->select("Select TMB_DESKRIPSI1, TMB_KODE, PRD_FRAC, PRD_HRGJUAL
//FROM   TBTABEL_PLUTIMBANGAN, TBMASTER_PRODMAST
//WHERE
//    TMB_PRDCD = PRD_PRDCD AND PRD_KODEIGR = '$kodeigr'
//ORDER BY TMB_KODE");

        return Datatables::of($datas)->make(true);

//        return response()->json($data);
    }

    public function GetKode(Request $request){
        $kodeigr = Session::get('kdigr');
        $search = $request->kode;

        $datas   = DB::connection(Session::get('connection'))->table('TBTABEL_PLUTIMBANGAN')
            ->selectRaw("TMB_DESKRIPSI1, TMB_KODE")

            ->where('TMB_PRDCD','=', substr($search,0,6).'0')
            ->where('tmb_kodeigr','=',Session::get('kdigr'))

            ->first();

        return response()->json($datas);
    }

    public function getData(){
        $data = DB::connection(Session::get('connection'))->table('tbmaster_plucharge')
            ->leftJoin('tbmaster_prodmast','prd_prdcd','=','non_prdcd')
            ->selectRaw("non_prdcd plu, nvl(prd_deskripsipanjang, 'PLU TIDAK TERDAFTAR DI MASTER BARANG') desk, case when prd_unit is null then ' ' else prd_unit || '/' || prd_frac end satuan")
            ->where('non_kodeigr','=',Session::get('kdigr'))
            ->orderBy('non_prdcd')
            ->get();

        return $data;
    }

    //ALTERNATIF Transfer() : DOWNLOAD SAJA TRUS PINDAHIN MANUAL
//    public function cetakcsv(Request $request)
//    {
//
//        $data = DB::connection(Session::get('connection'))
//            ->select("");
//
//        $filename = 'laporan-sales-per-divisi-departemen';
//
//            $filename = $filename . '.csv';
//            $columnHeader = [
//                'DIVISI',
//                'DEPARTEMENT',
//                'QTY',
//                'SALES',
//                'MARGIN',
//                'MARGIN %',
//                'CONST. SLS',
//                'CONST. MRG',
//                'JUMLAH MEMBER',
//            ];
//            $linebuffs = array();
//            foreach ($data as $d) {
//                $tempdata = [
//                    $d->kodedivisi . '-' . $d->namadivisi,
//                    $d->kodedepartement . '-' . $d->namadepartement,
//                    $d->qty,
//                    $d->sales,
//                    $d->margin,
//                    $d->marginpersen,
//                    $d->constsales,
//                    $d->constmargin,
//                    $d->jumlahmember,
//                ];
//                array_push($linebuffs, $tempdata);
//            }
//
//            $headers = [
//                "Content-type" => "text/csv",
//                "Pragma" => "no-cache",
//                "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
//                "Expires" => "0"
//            ];
//            $file = fopen(storage_path($filename), 'w');
//
//            fputcsv($file, $columnHeader, '|');
//            foreach ($linebuffs as $linebuff) {
//                fputcsv($file, $linebuff, '|');
//            }
//            fclose($file);
//
//            return response()->download(storage_path($filename))->deleteFileAfterSend(true);
//        }

    public function TransferDir1(Request $request){
        $kodeigr = Session::get('kdigr');
        $date1 = $request->date1; //YYYY-MM-DD <-ubahlah jadi
        $date2 = $request->date2;
        $dir1 = storage_path("UPDATE.txt");
        $dir1csv = storage_path("UPDATE.csv");
        $jenis_tmb = $request->jenis_tmb;

        $judul = '';
        if($jenis_tmb != '3'){
            if($jenis_tmb != '2'){
                $judul = 'Plu_No,SalesMode,LabelFormat,BestBefore,UnitPrice,PosCode,Font1,Desc1';
            }
            //step 3
            $out_file = fopen($dir1, "w") or die("Unable to open file!");
            fwrite($out_file, $judul.chr(13).chr(10));

            $rec = DB::connection(Session::get('connection'))->select("SELECT   TMB_PRDCD, RPAD(TMB_KODE,4,' ') TMB_KODE, SUBSTR (PRD_PRDCD, 1, 6) || '1' AS PRD_PRDCD,
                      PRD_UNIT, to_char(PRD_HRGJUAL,'9999999999.99') PRD_HRGJUAL, --add 2 koma (kmy gak bisa proses)
                      PRD_DESKRIPSIPENDEK, to_char(PRMd_HRGJUAL,'9999999999.99') PRMd_HRGJUAL, --add 2 koma (kmy gak bisa proses)
                      PRMd_JENISDISC
                 FROM TBTABEL_PLUTIMBANGAN, TBMASTER_PRODMAST, tbtr_promomd
                WHERE CASE
                          WHEN TMB_MODIFY_DT IS NOT NULL
                              THEN TO_CHAR (TMB_MODIFY_DT, 'YYYY-MM-DD')
                          ELSE TO_CHAR (TMB_CREATE_DT, 'YYYY-MM-DD')
                      END BETWEEN '$date1'
                              AND '$date2'
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
            //return response()->download($dir1)->deleteFileAfterSend(true);
        }
    }

    public function TransferDir2(Request $request){
        $kodeigr = Session::get('kdigr');
        $date1 = $request->date1; //YYYY-MM-DD <-ubahlah jadi
        $date2 = $request->date2;
        $dir2 = storage_path("UPDATE (ISHIDA).txt");
        $dir2csv = storage_path("UPDATE (ISHIDA).csv");
        $jenis_tmb = $request->jenis_tmb;

        $judul = '';

        $judul = 'Plu_No,SalesMode,LabelFormat,BestBefore,UnitPrice,PosCode,Font1,Desc1';
        $out_file = fopen($dir2, "w") or die("Unable to open file!");
        fwrite($out_file, $judul.chr(13).chr(10));

        $rec = DB::connection(Session::get('connection'))->select("SELECT   TMB_PRDCD, RPAD(TMB_KODE,4,' ') TMB_KODE,
                                      SUBSTR (PRD_PRDCD, 1, 6) || '1' AS PRD_PRDCD, PRD_UNIT,
                                      to_char(PRD_HRGJUAL,'9999999999.99') PRD_HRGJUAL, --add 2 koma (kmy gak bisa proses)
                                      PRD_DESKRIPSIPENDEK, to_char(PRMd_HRGJUAL,'9999999999.99') PRMd_HRGJUAL, --add 2 koma (kmy gak bisa proses)
                                      PRMd_JENISDISC
                                 FROM TBTABEL_PLUTIMBANGAN, TBMASTER_PRODMAST, tbtr_promomd
                                WHERE CASE
                                          WHEN TMB_MODIFY_DT IS NOT NULL
                                              THEN TO_CHAR (TMB_MODIFY_DT, 'YYYY-MM-DD')
                                          ELSE TO_CHAR (TMB_CREATE_DT, 'YYYY-MM-DD')
                                      END BETWEEN '$date1'
                                              AND '$date2'
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

        copy( $dir2, $dir2csv );
    }

    public function TransferDir3(Request $request){
        $kodeigr = Session::get('kdigr');
        $date1 = $request->date1; //YYYY-MM-DD <-ubahlah jadi
        $date2 = $request->date2;
        $dir3 = storage_path("UPDATE (BIZERBA).txt");
        $dir3csv = storage_path("UPDATE (BIZERBA).csv");
        $jenis_tmb = $request->jenis_tmb;

        $out_file = fopen($dir3, "w") or die("Unable to open file!");

        fwrite($out_file, chr(13).chr(10));
        //step 114
        $rec = DB::connection(Session::get('connection'))->select("SELECT   TMB_PRDCD, RPAD(TMB_KODE,4,' ') TMB_KODE, SUBSTR (PRD_PRDCD, 1, 6) || '1' AS PRD_PRDCD,
                                  PRD_UNIT, to_char(PRD_HRGJUAL,'9999999999.99') PRD_HRGJUAL, --add 2 koma (kmy gak bisa proses)
                                  PRD_DESKRIPSIPENDEK, to_char(PRMd_HRGJUAL,'9999999999.99') PRMd_HRGJUAL, --add 2 koma (kmy gak bisa proses)
                                  PRMd_JENISDISC
                             FROM TBTABEL_PLUTIMBANGAN, TBMASTER_PRODMAST, tbtr_promomd
                            WHERE CASE
                                      WHEN TMB_MODIFY_DT IS NOT NULL
                                          THEN TO_CHAR (TMB_MODIFY_DT, 'YYYY-MM-DD')
                                      ELSE TO_CHAR (TMB_CREATE_DT, 'YYYY-MM-DD')
                                  END BETWEEN '$date1'
                                          AND '$date2'
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
    }

    public function TransferDir1Txt(Request $request){
        $dir1 = storage_path("UPDATE.txt");
        $jenis_tmb = $request->jenis_tmb;

        if($jenis_tmb != '3'){
            return response()->download($dir1)->deleteFileAfterSend(true);
        }
    }

    public function TransferDir1Csv(Request $request){
        $dir1csv = storage_path("UPDATE.csv");
        $jenis_tmb = $request->jenis_tmb;

        if($jenis_tmb != '3'){
            return response()->download($dir1csv)->deleteFileAfterSend(true);
        }
    }

    public function TransferDir2Txt(Request $request){
        $dir2 = storage_path("UPDATE (ISHIDA).txt");
        $jenis_tmb = $request->jenis_tmb;

        return response()->download($dir2)->deleteFileAfterSend(true);
    }

    public function TransferDir2Csv(Request $request){
        $dir2csv = storage_path("UPDATE (ISHIDA).csv");
        $jenis_tmb = $request->jenis_tmb;

        return response()->download($dir2csv)->deleteFileAfterSend(true);
    }
    public function TransferDir3Txt(Request $request){
        $dir3 = storage_path("UPDATE (BIZERBA).txt");
        $jenis_tmb = $request->jenis_tmb;

        return response()->download($dir3)->deleteFileAfterSend(true);
    }

    public function TransferDir3Csv(Request $request){
        $dir3csv = storage_path("UPDATE (BIZERBA).csv");
        $jenis_tmb = $request->jenis_tmb;

        return response()->download($dir3csv)->deleteFileAfterSend(true);
    }
}
