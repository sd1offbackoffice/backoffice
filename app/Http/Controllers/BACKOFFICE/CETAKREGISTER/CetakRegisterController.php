<?php

namespace App\Http\Controllers\BACKOFFICE\CETAKREGISTER;

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

class CetakRegisterController extends Controller
{
    public function index(){
        $cabang = DB::connection(Session::get('connection'))->table('tbmaster_cabang')
            ->select('cab_kodecabang','cab_namacabang')
            ->where('cab_kodeigr','=',Session::get('kdigr'))
            ->where('cab_kodecabang','!=',Session::get('kdigr'))
            ->orderBy('cab_kodecabang')
            ->get();

        return view('BACKOFFICE.CETAKREGISTER.cetak-register')->with(compact(['cabang']));
    }

    public function print(Request $request){
        $register = $request->register;
        $tgl1 = $request->tgl1;
        $tgl2 = $request->tgl2;
        $cabang = $request->cabang;
        $ukuran = $request->ukuran;
        $jenis = $request->jenis;

        switch ($register){
            case 'B' : return $this->regterima($register, $tgl1, $tgl2);
            case 'K' : return $this->regkeluar($ukuran, $register, $tgl1, $tgl2);
            case 'O' : return $this->regsj($cabang, $tgl1, $tgl2);
            case 'P' : return $this->regpack($tgl1, $tgl2);
            case 'Z1' : return $this->regdbr($register, $tgl1, $tgl2);
            case 'Z2' : return $this->regdbr($register, $tgl1, $tgl2);
            case 'Z3' : return $this->regdbr($register, $tgl1, $tgl2);
            case 'X' : return $this->regnpp($ukuran, $tgl1, $tgl2);
            case 'F' : return $this->regbamusnah($tgl1, $tgl2);
            case 'H' : return $this->regnbh($tgl1, $tgl2);
            case 'H1' : return $this->regbtlnbh($tgl1, $tgl2);
            case 'F2' : return $this->regbtlbapb($tgl1, $tgl2);
            case 'L' : return $this->regterima($register, $tgl1, $tgl2);
            case 'B2' : return $this->regbtltrm($jenis, $tgl1, $tgl2);
            case 'K2' : return $this->regbtlnpb($tgl1, $tgl2);
            case 'X1' : return $this->regbtlmpp($ukuran, $tgl1, $tgl2);
            case 'I' : return $this->regtrfcab($cabang, $tgl1, $tgl2);
            case 'I2' : return $this->regtrfcabbtl($cabang, $tgl1, $tgl2);
            case 'O2' : return $this->regbtlsj($cabang, $tgl1, $tgl2);
            default : return $this->regbamusnah('','');
        }
    }

    public function regterima($register, $tgl1, $tgl2){
        $t1 = $this->formatDate($tgl1);
        $t2 = $this->formatDate($tgl2);

        $perusahaan = DB::connection(Session::get('connection'))->table('tbmaster_perusahaan')
            ->first();

        $data = DB::connection(Session::get('connection'))->select("select prd_flagbkp1, prd_flagbkp2, msth_nodoc, to_char(msth_tgldoc,'dd/mm/yyyy') msth_tgldoc, msth_cterm , msth_typetrn,to_char(msth_top,'dd/mm/yyyy') msth_top, status, sup_pkp,
                    supplier,trunc(mstd_tgldoc) mstd_tgldoc,
                    sum(mstd_gross) gross, sum(discount) discount,
                    sum(ppn) mstd_ppnrph, sum(ppnbm) mstd_ppnbmrph, sum(btl) mstd_ppnbtlrph,
                    sum(total) total
                from
                (
                select prd_flagbkp1, prd_flagbkp2, msth_nodoc, msth_tgldoc, msth_cterm , msth_typetrn, msth_tgldoc+msth_cterm msth_top,
                case when msth_recordid = 1 then
                    'BATAL'
                else
                    ''
                end status,
                mstd_tgldoc, sup_pkp,
                sup_kodesupplier || ' - ' || sup_namasupplier supplier,
                nvl(mstd_gross,0) mstd_gross,nvl(mstd_discrph,0) discount,
                nvl(mstd_ppnrph,0) ppn, nvl(mstd_ppnbmrph,0) ppnbm, nvl(mstd_ppnbtlrph,0) btl,
                nvl(mstd_gross,0)-nvl(mstd_discrph,0)+(nvl(mstd_ppnrph,0)+nvl(mstd_ppnbmrph,0)+nvl(mstd_ppnbtlrph,0)) total
                from tbtr_mstran_h, tbtr_mstran_d, tbmaster_supplier, tbmaster_prodmast
                where msth_kodeigr='".Session::get('kdigr')."'
                    and prd_prdcd(+)=mstd_prdcd
                    and msth_typetrn = '".$register."'
                    and nvl(msth_recordid,'9') <> '1'
                    and mstd_kodeigr = msth_kodeigr
                    and nvl(mstd_recordid,'9') <> '1'
                    and mstd_nodoc=msth_nodoc
                    and sup_kodesupplier(+)=msth_kodesupplier
                    and sup_kodeigr(+)=msth_kodeigr
                    and to_char(msth_tgldoc, 'yyyymmdd') between '".$t1."' and '".$t2."'
                order by msth_nodoc, msth_tgldoc)
                group by prd_flagbkp1, prd_flagbkp2, msth_nodoc, msth_tgldoc, msth_cterm , msth_typetrn, msth_top,status, sup_pkp,
                    supplier,trunc(mstd_tgldoc)
                order by msth_nodoc, msth_tgldoc");

//        dd($data[count($data) - 1]);

        $pkp = new \stdClass();
        $pkp->gross = 0;
        $pkp->potongan = 0;
        $pkp->ppn = 0;
        $pkp->ppn_bebas = 0;
        $pkp->ppn_dtp = 0;                
        $pkp->total = 0;

        $npkp = new \stdClass();
        $npkp->gross = 0;
        $npkp->potongan = 0;
        $npkp->ppn = 0;   
        $npkp->ppn_bebas = 0;
        $npkp->ppn_dtp = 0;             
        $npkp->total = 0;

        $pembelian  = new \stdClass();
        $pembelian->gross = 0;
        $pembelian->potongan = 0;
        $pembelian->ppn = 0;
        $pembelian->ppn_bebas = 0;
        $pembelian->ppn_dtp = 0;                
        $pembelian->total = 0;

        $lain = new \stdClass();
        $lain->gross = 0;
        $lain->potongan = 0;
        $lain->ppn = 0;
        $lain->ppn_bebas = 0;
        $lain->ppn_dtp = 0;                
        $lain->total = 0;

        $total = new \stdClass();
        $total->gross = 0;
        $total->potongan = 0;
        $total->ppn = 0;
        $total->ppn_bebas = 0;
        $total->ppn_dtp = 0;                
        $total->total = 0;

        foreach($data as $d){
            if($d->sup_pkp == 'Y'){
                $pkp->gross += $d->gross;
                $pkp->potongan += $d->discount;
                $ppn_rph = 0;
                // $pkp->ppn += $d->mstd_ppnrph;
                // if ($d->prd_flagbkp1 == 'Y' && $d->prd_flagbkp2 == 'Y') {
                //     $pkp->ppn += $d->mstd_ppnrph;
                // }
                // if ($d->prd_flagbkp1 == 'Y' && $d->prd_flagbkp2 == 'P') {                    
                //     $pkp->ppn_bebas += $d->mstd_ppnrph;
                // }
                // if ($d->prd_flagbkp1 == 'Y' && ($d->prd_flagbkp2 == 'W' || $d->prd_flagbkp2 == 'G')) {
                //     $pkp->ppn_dtp += $d->mstd_ppnrph;
                // }
                switch ($d->prd_flagbkp1) {
                    case 'Y':
                        switch ($d->prd_flagbkp2) {
                            case 'Y':
                                $pkp->ppn += $d->mstd_ppnrph;
                                $ppn_rph = $d->mstd_ppnrph;
                                break;
                            case 'P':
                                $pkp->ppn_bebas += $d->mstd_ppnrph;
                                break;
                            case 'W' || 'G':
                                $pkp->ppn_dtp += $d->mstd_ppnrph;
                                break;                            
                            default:
                                # code...
                                break;
                        }
                        break;                    
                    default:
                        # code...
                        break;
                }                        
                $pkp->total += ($d->gross - $d->discount + $ppn_rph);
                // $pkp->total += $d->total;
            }
            else{
                $npkp->gross += $d->gross;
                $npkp->potongan += $d->discount;
                $ppn_rph = 0;
                // $npkp->ppn += $d->mstd_ppnrph;
                // if ($d->prd_flagbkp1 == 'Y' && $d->prd_flagbkp2 == 'Y') {
                //     $npkp->ppn += $d->mstd_ppnrph;
                // }
                // if ($d->prd_flagbkp1 == 'Y' && $d->prd_flagbkp2 == 'P') {                    
                //     $npkp->ppn_bebas += $d->mstd_ppnrph;
                // }
                // if ($d->prd_flagbkp1 == 'Y' && ($d->prd_flagbkp2 == 'W' || $d->prd_flagbkp2 == 'G')) {
                //     $npkp->ppn_dtp += $d->mstd_ppnrph;
                // }     
                switch ($d->prd_flagbkp1) {
                    case 'Y':
                        switch ($d->prd_flagbkp2) {
                            case 'Y':
                                $npkp->ppn += $d->mstd_ppnrph;
                                $ppn_rph = $d->mstd_ppnrph;
                                break;
                            case 'P':
                                $npkp->ppn_bebas += $d->mstd_ppnrph;
                                break;
                            case 'W' || 'G':
                                $npkp->ppn_dtp += $d->mstd_ppnrph;
                                break;                            
                            default:
                                # code...
                                break;
                        }
                        break;                    
                    default:
                        # code...
                        break;
                }                                      
                $npkp->total += ($d->gross - $d->discount + $ppn_rph);
            }
        }

        $total->gross = $pkp->gross + $npkp->gross;
        $total->potongan = $pkp->potongan + $npkp->potongan;
        $total->ppn = $pkp->ppn + $npkp->ppn;
        $total->ppn_bebas = $pkp->ppn_bebas + $npkp->ppn_bebas;
        $total->ppn_dtp = $pkp->ppn_dtp + $npkp->ppn_dtp;
        $total->total = $pkp->total + $npkp->total;

        if($register == 'B'){
            $pembelian = $total;
        }
        else{
            $lain = $total;
        }

        $title = 'Register Bukti Penerimaan Barang';

//        return view('BACKOFFICE.CETAKREGISTER.regterima-pdf',compact(['perusahaan','data','pkp','npkp','pembelian','lain','total','tgl1','tgl2']));
        set_time_limit(0);

        //excel
        $subtitle = '';
        $keterangan = $tgl1.'  -  '.$tgl2;
        $filename = $title.'_'.Carbon::now()->format('dmY_His').'.xlsx';
        $view = view('BACKOFFICE.CETAKREGISTER.regterima-xlxs', compact(['perusahaan','data','pkp','npkp','pembelian','lain','total','tgl1','tgl2']))->render();
        ExcelController::create($view,$filename,$title,$subtitle,$keterangan);
        return response()->download(storage_path($filename))->deleteFileAfterSend(true);
    }

    public function regkeluar($ukuran, $register, $tgl1, $tgl2){
        $t1 = $this->formatDate($tgl1);
        $t2 = $this->formatDate($tgl2);

        $perusahaan = DB::connection(Session::get('connection'))->table('tbmaster_perusahaan')
            ->first();

        $data = DB::connection(Session::get('connection'))->select("select prd_flagbkp1, prd_flagbkp2, msth_nodoc, to_char(msth_tgldoc,'dd/mm/yyyy') msth_tgldoc, msth_cterm, msth_top,status, msth_nofaktur, to_char(msth_tglfaktur,'dd/mm/yyyy') msth_tglfaktur,supplier, sum(nvl(mstd_gross,0)) gross, mstd_pkp, mstd_typetrn,sum(nvl(discount,0)) discount, sum(nvl(ppn,0)) mstd_ppnrph, sum(nvl(ppnbm,0)) mstd_ppnbmrph, sum(nvl(btl,0)) mstd_ppnbtlrph, sum(nvl(total,0)) total
        from
        (
        select prd_flagbkp1, prd_flagbkp2, msth_nodoc, msth_tgldoc, msth_cterm, msth_tgldoc+msth_cterm msth_top,
        case when msth_recordid = 1 then
            'BATAL'
        else
            ''
        end status,
         mstd_tgldoc,
        sup_kodesupplier||'-'||sup_namasupplier supplier, msth_nofaktur, msth_tglfaktur,
        mstd_gross, mstd_pkp, mstd_typetrn,nvl(mstd_discrph,0) discount,
        nvl(mstd_ppnrph,0) ppn, nvl(mstd_ppnbmrph,0) ppnbm, nvl(mstd_ppnbtlrph,0) btl,
        nvl(mstd_gross,0)-(nvl(mstd_discrph,0))+nvl(mstd_ppnrph,0) total

        from tbtr_mstran_h, tbtr_mstran_d,tbmaster_supplier, tbmaster_prodmast
        where msth_typetrn ='K'
        and prd_prdcd(+)=mstd_prdcd
        and msth_kodeigr='".Session::get('kdigr')."'
        and mstd_nodoc=msth_nodoc
        and sup_kodesupplier(+)=msth_kodesupplier
        and sup_kodeigr(+)=msth_kodeigr
        and to_char(msth_tgldoc, 'yyyymmdd') between '".$t1."' and '".$t2."'
        order by msth_nodoc, msth_tgldoc
        )
        group by prd_flagbkp1, prd_flagbkp2, msth_nodoc, msth_tgldoc, msth_cterm, msth_top,status,msth_nofaktur, msth_tglfaktur,
            supplier,mstd_tgldoc, mstd_pkp, mstd_typetrn
        order by msth_nodoc, msth_tgldoc");  
        // dd($data);

        $pkp = new \stdClass();
        $pkp->gross = 0;
        $pkp->potongan = 0;
        $pkp->ppn = 0;
        $pkp->ppn_bebas = 0;
        $pkp->ppn_dtp = 0;                
        $pkp->total = 0;

        $npkp = new \stdClass();
        $npkp->gross = 0;
        $npkp->potongan = 0;
        $npkp->ppn = 0;
        $npkp->ppn_bebas = 0;
        $npkp->ppn_dtp = 0;                
        $npkp->total = 0;

        $pembelian  = new \stdClass();
        $pembelian->gross = 0;
        $pembelian->potongan = 0;
        $pembelian->ppn = 0;
        $pembelian->ppn_bebas = 0;
        $pembelian->ppn_dtp = 0;                
        $pembelian->total = 0;

        $lain = new \stdClass();
        $lain->gross = 0;
        $lain->potongan = 0;
        $lain->ppn = 0;
        $lain->ppn_bebas = 0;
        $lain->ppn_dtp = 0;                
        $lain->total = 0;

        $total = new \stdClass();
        $total->gross = 0;
        $total->potongan = 0;
        $total->ppn = 0;
        $total->ppn_bebas = 0;
        $total->ppn_dtp = 0;                
        $total->total = 0;

        foreach($data as $d){            
            if($d->mstd_pkp == 'Y'){
                $pkp->gross += $d->gross;
                $pkp->potongan += $d->discount;
                // $pkp->ppn += $d->mstd_ppnrph;
                $ppn_rph = 0;
                
                // if ($d->prd_flagbkp1 == 'Y' && $d->prd_flagbkp2 == 'Y') {
                //     $pkp->ppn += $d->mstd_ppnrph;
                //     $ppn_rph = $d->mstd_ppnrph;
                // } 
                // if ($d->prd_flagbkp1 == 'Y' && $d->prd_flagbkp2 == 'P') {                    
                //     $pkp->ppn_bebas += $d->mstd_ppnrph;                    
                // }
                // if ($d->prd_flagbkp1 == 'Y' && ($d->prd_flagbkp2 == 'W' || $d->prd_flagbkp2 == 'G')) {
                //     $pkp->ppn_dtp += $d->mstd_ppnrph;                
                // }
                switch ($d->prd_flagbkp1) {
                    case 'Y':
                        switch ($d->prd_flagbkp2) {
                            case 'Y':
                                $pkp->ppn += $d->mstd_ppnrph;
                                $ppn_rph = $d->mstd_ppnrph;
                                break;
                            case 'P':
                                $pkp->ppn_bebas += $d->mstd_ppnrph;
                                break;
                            case 'W' || 'G':
                                $pkp->ppn_dtp += $d->mstd_ppnrph;
                                break;                            
                            default:
                                # code...
                                break;
                        }
                        break;                    
                    default:
                        # code...
                        break;
                }                                 
                $pkp->total += ($d->gross - $d->discount + $ppn_rph);
                // $pkp->total += $d->total;
            }
            else{
                $npkp->gross += $d->gross;
                $npkp->potongan += $d->discount;
                // $npkp->ppn += $d->mstd_ppnrph;
                $ppn_rph = 0;
                // if ($d->prd_flagbkp1 == 'Y' && $d->prd_flagbkp2 == 'Y') {
                //     $npkp->ppn += $d->mstd_ppnrph;
                //     $ppn_rph = $d->mstd_ppnrph;
                // }
                // if ($d->prd_flagbkp1 == 'Y' && $d->prd_flagbkp2 == 'P') {                    
                //     $npkp->ppn_bebas += $d->mstd_ppnrph;                   
                // }
                // if ($d->prd_flagbkp1 == 'Y' && ($d->prd_flagbkp2 == 'W' || $d->prd_flagbkp2 == 'G')) {
                //     $npkp->ppn_dtp += $d->mstd_ppnrph;                   
                // }
                switch ($d->prd_flagbkp1) {
                    case 'Y':
                        switch ($d->prd_flagbkp2) {
                            case 'Y':
                                $npkp->ppn += $d->mstd_ppnrph;
                                $ppn_rph = $d->mstd_ppnrph;
                                break;
                            case 'P':
                                $npkp->ppn_bebas += $d->mstd_ppnrph;
                                break;
                            case 'W' || 'G':
                                $npkp->ppn_dtp += $d->mstd_ppnrph;
                                break;                            
                            default:
                                # code...
                                break;
                        }
                        break;                    
                    default:
                        # code...
                        break;
                }                                 
                $npkp->total += ($d->gross - $d->discount + $ppn_rph);
                // $npkp->total += $d->total;
            }
        }

        $total->gross = $pkp->gross + $npkp->gross;
        $total->potongan = $pkp->potongan + $npkp->potongan;
        $total->ppn = $pkp->ppn + $npkp->ppn;
        $total->ppn_bebas = $pkp->ppn_bebas + $npkp->ppn_bebas;
        $total->ppn_dtp = $pkp->ppn_dtp + $npkp->ppn_dtp;                
        $total->total = $pkp->total + $npkp->total;

        $pembelian = $total;

        return view('BACKOFFICE.CETAKREGISTER.regkeluar-pdf',compact(['perusahaan','data','pkp','npkp','pembelian','lain','total','tgl1','tgl2','ukuran']));
    }

    public function regsj($cabang, $tgl1, $tgl2){
        $t1 = $this->formatDate($tgl1);
        $t2 = $this->formatDate($tgl2);

        $perusahaan = DB::connection(Session::get('connection'))->table('tbmaster_perusahaan')
            ->first();

        if($cabang == 'ALL'){
            $whereCabang = '';
        }
        else $whereCabang = "and (msth_loc2 ='".$cabang."'  or nvl('".$cabang."',' ')=' ')";

        $data = DB::connection(Session::get('connection'))
            ->select("SELECT msth_nodoc, to_char(msth_tgldoc,'dd/mm/yyyy') msth_tgldoc, status, msth_noref3, to_char(msth_tgref3,'dd/mm/yyyy') msth_tgref3,msth_loc, msth_loc2, mstd_flagdisc1,mstd_ppnrph,sum(total) total
        FROM
        (
            SELECT msth_nodoc, msth_tgldoc,
            case when nvl(msth_recordid,'0') = '1' then 'BATAL' else '' end status,
            msth_noref3, msth_tgref3, mstd_tgldoc,msth_loc, msth_loc2,
            msth_invno, mstd_date3,
            mstd_flagdisc1, nvl(mstd_ppnrph,0) mstd_ppnrph,
            nvl(mstd_gross,0) total
            FROM tbtr_mstran_h, tbtr_mstran_d
            WHERE msth_typetrn ='O'
            and msth_kodeigr='".Session::get('kdigr')."'
            ".$whereCabang."
            and mstd_nodoc=msth_nodoc
            and to_char(msth_tgldoc, 'yyyymmdd') between '".$t1."' and '".$t2."'
        )
        GROUP BY msth_nodoc, msth_tgldoc,status,msth_invno, mstd_date3,msth_noref3, msth_tgref3,
        mstd_flagdisc1,mstd_ppnrph,mstd_tgldoc,msth_loc, msth_loc2
        order by msth_tgldoc desc, msth_nodoc asc");

        return view('BACKOFFICE.CETAKREGISTER.regsj-pdf',compact(['perusahaan','data','tgl1','tgl2']));
    }

    public function regpack($tgl1, $tgl2){
        $t1 = $this->formatDate($tgl1);
        $t2 = $this->formatDate($tgl2);

        $perusahaan = DB::connection(Session::get('connection'))->table('tbmaster_perusahaan')
            ->first();

        $data = DB::connection(Session::get('connection'))->select("SELECT   MSTH_NODOC, to_char(MSTH_TGLDOC, 'dd/mm/yyyy') MSTH_TGLDOC, STATUS, MSTH_NOREF3, to_char(MSTH_TGREF3, 'dd/mm/yyyy') MSTH_TGREF3, MSTD_PPNRPH, PRS_NAMAPERUSAHAAN, PRS_NAMACABANG,
         CASE SUBSTR (MSTH_NOPO, 4, 2)
             WHEN 'RP'
                 THEN SUM (PREPACK)
             ELSE MAX (PREPACK)
         END PREPACK, CASE SUBSTR (MSTH_NOPO, 4, 2)
             WHEN 'RP'
                 THEN SUM (GROSS)
             ELSE MAX (GROSS)
         END GROSS, CASE SUBSTR (MSTH_NOPO, 4, 2)
             WHEN 'RP'
                 THEN SUM (PPN)
             ELSE MAX (PPN)
         END PPN, CASE SUBSTR (MSTH_NOPO, 4, 2)
             WHEN 'RP'
                 THEN SUM (PPNBM)
             ELSE MAX (PPNBM)
         END PPNBM, CASE SUBSTR (MSTH_NOPO, 4, 2)
             WHEN 'RP'
                 THEN SUM (BOTOL)
             ELSE MAX (BOTOL)
         END BOTOL, CASE SUBSTR (MSTH_NOPO, 4, 2)
             WHEN 'RP'
                 THEN SUM (TOTAL)
             ELSE MAX (TOTAL)
         END TOTAL, CASE SUBSTR (MSTH_NOPO, 4, 2)
             WHEN 'RP'
                 THEN 1
             ELSE SUM (PREPACK)
         END REPACK
    FROM (SELECT   MSTH_NODOC, MSTH_TGLDOC, MSTH_NOPO, STATUS, MSTH_NOREF3, MSTH_TGREF3,
                   MSTD_TGLDOC, PRS_NAMAPERUSAHAAN, PRS_NAMACABANG, MSTH_INVNO, MSTH_TGLINV,
                   MSTD_FLAGDISC1, SUM (MSTD_PPNRPH) MSTD_PPNRPH, SUM (PREPACK) PREPACK,
                   SUM (GROSS) GROSS, SUM (MSTD_PPNRPH) PPN, SUM (PPNBM) PPNBM, SUM (BOTOL) BOTOL,
                   SUM (TOTAL) TOTAL
              FROM (SELECT MSTH_NODOC, MSTH_TGLDOC, MSTH_NOPO,
                           CASE
                               WHEN MSTH_RECORDID = 1
                                   THEN 'BATAL'
                               ELSE ''
                           END STATUS, MSTH_NOREF3, MSTH_TGREF3, MSTD_TGLDOC, PRS_NAMAPERUSAHAAN,
                           PRS_NAMACABANG, MSTH_INVNO, MSTH_TGLINV, MSTD_FLAGDISC1,
                           NVL (MSTD_PPNRPH, 0) MSTD_PPNRPH, 1 PREPACK, NVL (MSTD_GROSS, 0) GROSS,
                           NVL (MSTD_PPNRPH, 0) PPN, NVL (MSTD_PPNBMRPH, 0) PPNBM,
                           NVL (MSTD_PPNBTLRPH, 0) BOTOL,
                             NVL (MSTD_GROSS, 0)
                           + NVL (MSTD_PPNRPH, 0)
                           + NVL (MSTD_PPNBMRPH, 0)
                           + NVL (MSTD_PPNBTLRPH, 0) TOTAL
                      FROM TBTR_MSTRAN_H, TBTR_MSTRAN_D, TBMASTER_PERUSAHAAN
                     WHERE MSTH_KODEIGR = MSTD_KODEIGR
                       AND MSTH_NODOC = MSTD_NODOC
                       AND MSTH_KODEIGR = '".Session::get('kdigr')."'
                       AND MSTH_TYPETRN = 'P'
                       AND MSTD_FLAGDISC1 = 'P'
                       and to_char(msth_tgldoc, 'yyyymmdd') between '".$t1."' and '".$t2."') A
          GROUP BY MSTH_NODOC,
                   MSTH_TGLDOC,
                   MSTH_NOPO,
                   STATUS,
                   MSTH_NOREF3,
                   MSTH_TGREF3,
                   MSTD_TGLDOC,
                   PRS_NAMAPERUSAHAAN,
                   PRS_NAMACABANG,
                   MSTH_INVNO,
                   MSTH_TGLINV,
                   MSTD_FLAGDISC1) AA,
         (SELECT   DOC2, TGL2, SUM (REPACK) REPACK
              FROM (SELECT MSTH_NODOC DOC2, MSTH_TGLDOC TGL2, 1 REPACK
                      FROM TBTR_MSTRAN_H, TBTR_MSTRAN_D
                     WHERE MSTH_KODEIGR = MSTD_KODEIGR
                       AND MSTH_NODOC = MSTD_NODOC
                       AND MSTH_KODEIGR = '".Session::get('kdigr')."'
                       AND MSTH_TYPETRN = 'P'
                       AND MSTD_FLAGDISC1 = 'R'
                       and to_char(msth_tgldoc, 'yyyymmdd') between '".$t1."' and '".$t2."') B
          GROUP BY DOC2, TGL2) BB
   WHERE DOC2 = MSTH_NODOC
GROUP BY MSTH_NODOC,
         MSTH_TGLDOC,
         MSTH_NOPO,
         STATUS,
         MSTH_INVNO,
         MSTH_TGLINV,
         MSTH_NOREF3,
         MSTH_TGREF3,
         MSTD_PPNRPH,
         PRS_NAMAPERUSAHAAN,
         PRS_NAMACABANG,
         MSTD_TGLDOC
ORDER BY MSTH_NODOC");

//        dd($data);

        return view('BACKOFFICE.CETAKREGISTER.regpack-pdf',compact(['perusahaan','data','tgl1','tgl2']));
    }

    public function regdbr($register, $tgl1, $tgl2){
        $t1 = $this->formatDate($tgl1);
        $t2 = $this->formatDate($tgl2);

        $perusahaan = DB::connection(Session::get('connection'))->table('tbmaster_perusahaan')
            ->first();

        if($register == 'Z1'){
            $title = '** REGISTER DAFTAR BARANG BAIK KE RETUR **';
            $name = 'Register Daftar Barang Baik ke Retur';
            $header = 'DBR';
            $where = " and mstd_flagdisc1 = 'B' and mstd_flagdisc2 = 'T' ";
        }
        else if($register == 'Z2'){
            $title = '** REGISTER DAFTAR BARANG BAIK KE RUSAK **';
            $name = 'Register Daftar Barang Baik ke Rusak';
            $header = 'NBR';
            $where = " and mstd_flagdisc1 = 'B' and mstd_flagdisc2 = 'R' ";
        }
        else{
            $title = '** REGISTER BUKTI PERUBAHAN STATUS **';
            $name = 'Register Bukti Perubahan Status';
            $header = 'BPS';
            $where = " and mstd_flagdisc1 <> 'B' ";
        }

        $data = DB::connection(Session::get('connection'))->select("select msth_nodoc, to_char(msth_tgldoc, 'dd/mm/yyyy') msth_tgldoc, status, msth_nofaktur, to_char(msth_tglfaktur, 'dd/mm/yyyy') msth_tglfaktur,mstd_flagdisc1,mstd_ppnrph,sum(total) total
            from
            (
                    select msth_nodoc, msth_tgldoc,
                    case when msth_recordid = 1 then
                        'BATAL'
                    else
                        ''
                    end status,msth_nofaktur, msth_tglfaktur, mstd_tgldoc,
                     msth_invno,mstd_flagdisc1, nvl(mstd_ppnrph,0) mstd_ppnrph,
                    nvl(mstd_gross,0) total
                    from tbtr_mstran_h, tbtr_mstran_d
                    where msth_typetrn ='Z'
                    and msth_kodeigr='".Session::get('kdigr')."'
                    and mstd_nodoc=msth_nodoc
                    ".$where."
                    and to_char(msth_tgldoc, 'yyyymmdd') between '".$t1."' and '".$t2."'
            )
            group by msth_nodoc, msth_tgldoc,status,msth_invno, msth_nofaktur, msth_tglfaktur,
            mstd_flagdisc1,mstd_ppnrph,mstd_tgldoc
            order by msth_tgldoc,msth_nodoc");

//        dd($data);

        return view('BACKOFFICE.CETAKREGISTER.regdbr-pdf',compact(['perusahaan','data','tgl1','tgl2','title','header', 'name']));
    }

    public function regnpp($ukuran, $tgl1, $tgl2){
        $t1 = $this->formatDate($tgl1);
        $t2 = $this->formatDate($tgl2);

        $perusahaan = DB::connection(Session::get('connection'))->table('tbmaster_perusahaan')
            ->first();

        $data = DB::connection(Session::get('connection'))->select("SELECT
            msth_nodoc, TO_CHAR(msth_tgldoc, 'dd/mm/yyyy') msth_tgldoc, status, msth_noref3, to_char(msth_tgref3, 'dd/mm/yyyy') msth_tgref3, mstd_flagdisc1,mstd_ppnrph,sbrg, keterangan, mstd_flagdisc1, mstd_flagdisc2,
            sum(total) total, NVL(sum(NILAI_BB),0) as TOTBB, NVL(sum(NILAI_BR),0) as TOTBR, NVL(sum(NILAI_BS),0) as TOTBS
        FROM
        (
            SELECT
                msth_nodoc, msth_tgldoc,
                CASE WHEN msth_recordid = 1 THEN
                    'BATAL'
                ELSE
                    ''
                END status,
                msth_noref3, msth_tgref3, mstd_tgldoc,msth_invno,
                mstd_flagdisc1, mstd_flagdisc2, nvl(mstd_ppnrph,0) mstd_ppnrph,
                case
                    when mstd_flagdisc2 = '1' then
                             'BAIK'
                    when mstd_flagdisc2 = '2' then
                             'RETUR'
                    else
                             'RUSAK'
                end SBRG,
                case
                    when mstd_flagdisc1= '1' then
                         'SELISIH SO'
                    when mstd_flagdisc1 = '2' then
                         'TERTUKAR JENIS'
                    else
                         'GANTI PLU'
                end KETERANGAN,
                nvl(mstd_gross,0) total,
                case when mstd_flagdisc2= '1' then nvl(mstd_gross,0) ELSE 0 END NILAI_BB,
                case when mstd_flagdisc2= '2' then nvl(mstd_gross,0) ELSE 0 END NILAI_BR,
                case when mstd_flagdisc2= '3' then nvl(mstd_gross,0) ELSE 0 END NILAI_BS

            from tbtr_mstran_h, tbtr_mstran_d
            where msth_typetrn ='X'
            and msth_kodeigr='".Session::get('kdigr')."'
            and mstd_nodoc=msth_nodoc
            and to_char(msth_tgldoc, 'yyyymmdd') between '".$t1."' and '".$t2."'
        )
        group by
            msth_tgldoc, msth_nodoc, status,msth_invno,
            msth_noref3, msth_tgref3,
            mstd_flagdisc1, mstd_flagdisc2, mstd_ppnrph,
            sbrg, keterangan, mstd_tgldoc
        Order by msth_tgldoc, msth_nodoc");

//        dd($data);

        return view('BACKOFFICE.CETAKREGISTER.regnpp-pdf',compact(['perusahaan','data','tgl1','tgl2','ukuran']));
    }

    public function regbamusnah($tgl1, $tgl2){
        $t1 = $this->formatDate($tgl1);
        $t2 = $this->formatDate($tgl2);

        $perusahaan = DB::connection(Session::get('connection'))->table('tbmaster_perusahaan')
            ->first();

        $data = DB::connection(Session::get('connection'))->select("select msth_nodoc, to_char(msth_tgldoc, 'dd/mm/yyyy') msth_tgldoc, status, msth_nopo, to_char(msth_tglpo, 'dd/mm/yyyy') msth_tglpo,
                    mstd_flagdisc1,mstd_ppnrph,sum(total) total
                    from
                    (
                        select msth_nodoc, msth_tgldoc,
                        case when msth_recordid = 1 then 'BATAL'  else   ''    end status,
                        msth_nopo, msth_tglpo, mstd_tgldoc,
                        msth_invno, msth_tglinv,
                        mstd_flagdisc1, nvl(mstd_ppnrph,0) mstd_ppnrph,
                        nvl(mstd_gross,0) total
                        from tbtr_mstran_h, tbtr_mstran_d
                        where msth_typetrn ='F'
                        and msth_kodeigr='".Session::get('kdigr')."'
                        and mstd_nodoc=msth_nodoc
                        and to_char(msth_tgldoc, 'yyyymmdd') between '".$t1."' and '".$t2."'
                    )
                    group by msth_nodoc, msth_tgldoc,status,msth_invno, msth_tglinv,msth_nopo, msth_tglpo,
                                   mstd_flagdisc1,mstd_ppnrph,mstd_tgldoc
                    order by msth_nodoc, msth_tgldoc");

//        dd($data);

        return view('BACKOFFICE.CETAKREGISTER.regbamusnah-pdf',compact(['perusahaan','data','tgl1','tgl2']));
    }

    public function regnbh($tgl1, $tgl2){
        $t1 = $this->formatDate($tgl1);
        $t2 = $this->formatDate($tgl2);

        $title = '** REGISTER NOTA NBH **';
        $filename = 'Register Nota NBH';

        $perusahaan = DB::connection(Session::get('connection'))->table('tbmaster_perusahaan')
            ->first();

        $data = DB::connection(Session::get('connection'))->select("SELECT  to_char(msth_tgldoc, 'dd/mm/yyyy') msth_tgldoc, mstd_nodoc,
            mstd_nopo, to_char(mstd_tglpo, 'dd/mm/yyyy') mstd_tglpo, cket1, status,
            sum(mstd_gross) total
            FROM
            (
                select msth_tgldoc, mstd_nodoc, mstd_tgldoc,
                mstd_nopo, mstd_tglpo, mstd_gross,
                case when mstd_flagdisc1 = 1 then 'BARANG BAIK'
                     when mstd_flagdisc1 = 2 then 'BARANG RETUR'
                     when mstd_flagdisc1 = 3 then 'BARANG RUSAK'
                end cket1,
                case when mstd_recordid = 1 then 'BATAL' ELSE '' end status
                from tbtr_mstran_h, tbtr_mstran_d
                where to_char(msth_tgldoc, 'yyyymmdd') between '".$t1."' and '".$t2."'
                and msth_kodeigr = '".Session::get('kdigr')."'
                and msth_typetrn='H'
                and mstd_nodoc = msth_nodoc
                and mstd_kodeigr=msth_kodeigr
            )
            group by msth_tgldoc, mstd_nodoc, mstd_tgldoc,
            mstd_nopo, mstd_tglpo,  cket1, status
            order by mstd_nodoc");

//        dd($data);

        return view('BACKOFFICE.CETAKREGISTER.regnbh-pdf',compact(['perusahaan','data','tgl1','tgl2','title','filename']));
    }

    public function regbtlnbh($tgl1, $tgl2){
        $t1 = $this->formatDate($tgl1);
        $t2 = $this->formatDate($tgl2);

        $title = '** REGISTER PEMBATALAN NOTA NBH **';
        $filename = 'Register Pembatalan Nota NBH';

        $perusahaan = DB::connection(Session::get('connection'))->table('tbmaster_perusahaan')
            ->first();

        $data = DB::connection(Session::get('connection'))->select("SELECT  to_char(msth_tgldoc,'dd/mm/yyyy') msth_tgldoc, mstd_nodoc, mstd_tgldoc,
            mstd_nopo, to_char(mstd_tglpo, 'dd/mm/yyyy') mstd_tglpo, cket1, status,
            sum(mstd_gross) total
            FROM
            (
                select  msth_tgldoc, mstd_nodoc, mstd_tgldoc,
                mstd_nopo, mstd_tglpo, mstd_gross,
                case when mstd_flagdisc1 = 1 then 'BARANG BAIK'
                     when mstd_flagdisc1 = 2 then 'BARANG RETUR'
                     when mstd_flagdisc1 = 3 then 'BARANG RUSAK'
                end cket1,
                case when mstd_recordid = 1 then 'BATAL' ELSE '' end status
                from tbtr_mstran_h, tbtr_mstran_d
                where to_char(msth_tgldoc, 'yyyymmdd') between '".$t1."' and '".$t2."'
                and msth_kodeigr = '".Session::get('kdigr')."'
                and msth_typetrn='H'
                and nvl(msth_recordid,9)=1
                and mstd_nodoc = msth_nodoc
                and mstd_kodeigr=msth_kodeigr
            )
            group by msth_tgldoc, mstd_nodoc, mstd_tgldoc,
            mstd_nopo, mstd_tglpo,  cket1, status");

//        dd($data);

        return view('BACKOFFICE.CETAKREGISTER.regnbh-pdf',compact(['perusahaan','data','tgl1','tgl2','title','filename']));
    }

    public function regbtlbapb($tgl1, $tgl2){
        $t1 = $this->formatDate($tgl1);
        $t2 = $this->formatDate($tgl2);

        $perusahaan = DB::connection(Session::get('connection'))->table('tbmaster_perusahaan')
            ->first();

            $data = DB::connection(Session::get('connection'))->select("SELECT  to_char(msth_tgldoc, 'dd/mm/yyyy') msth_tgldoc, mstd_nodoc, to_char(mstd_tgldoc,'dd/mm/yyyy') mstd_tgldoc,
                        mstd_nopo, to_char(mstd_tglpo, 'dd/mm/yyyy') mstd_tglpo, status,msth_noref3, to_char(msth_tgref3,'dd/mm/yyyy') msth_tgref3,
                        sum(mstd_gross) mstd_gross
                        FROM
                        (
                            select  msth_tgldoc, mstd_nodoc, mstd_tgldoc,
                               mstd_nopo, mstd_tglpo, mstd_gross,  msth_noref3, msth_tgref3,
                               case when mstd_recordid = 1 then 'BATAL' ELSE '' end status
                            from tbtr_mstran_h, tbtr_mstran_d
                            where msth_tgldoc between to_date('".$tgl1."','dd/mm/yyyy') and to_date('".$tgl2."','dd/mm/yyyy')
                            and msth_kodeigr = '".Session::get('kdigr')."'
                            and msth_typetrn='F'
                            and nvl(msth_recordid,9)=1
                            and mstd_nodoc = msth_nodoc
                            and mstd_kodeigr=msth_kodeigr
                        )
                        group by msth_tgldoc, mstd_nodoc, mstd_tgldoc,
                        mstd_nopo, mstd_tglpo,  status,msth_noref3, msth_tgref3
                        order by mstd_nodoc asc");

//        dd($data);

        return view('BACKOFFICE.CETAKREGISTER.regbtlbapb-pdf',compact(['perusahaan','data','tgl1','tgl2']));
    }

    public function regbtltrm($jenis, $tgl1, $tgl2){
        $t1 = $this->formatDate($tgl1);
        $t2 = $this->formatDate($tgl2);

        $perusahaan = DB::connection(Session::get('connection'))->table('tbmaster_perusahaan')
            ->first();

        $data = DB::connection(Session::get('connection'))->select("select to_char(mstd_tgldoc, 'dd/mm/yyyy') msth_tgldoc, mstd_nodoc, to_char(mstd_tgldoc, 'dd/mm/yyyy') mstd_tgldoc, mstd_cterm, to_char(jtempo, 'dd/mm/yyyy') jtempo,
        status, supplier,
        sum(gross) gross, sum(potongan) potongan, sum(ppn) ppn,
        sum(bm) bm, sum(btl) btl, sum(total) total, sum(gross_bkp) grossbkp,
        sum(gross_btkp) grossbtkp, sum(pot_bkp) potbkp, sum(pot_btkp) potbtkp,
        sum(ppn_bkp) ppnbkp, sum(ppn_btkp) ppnbtkp, sum(bm_bkp) bmbkp,
        sum(bm_btkp) bmbtkp, sum(btl_bkp) btlbkp, sum(btl_btkp) btlbtkp,
        sum(total_bkp) totalbkp, sum(total_btkp) totalbtkp, sum(beli_gross) beligross,
        sum(lain_gross) laingross, sum(beli_ppn) belippn, sum(lain_ppn) lainppn,
        sum(beli_pot) belipot, sum(lain_pot) lainpot, sum(beli_bm) belibm,
        sum(lain_bm) lainbm, sum(beli_btl) belibtl, sum(lain_btl) lainbtl,
        sum(beli_total) belitotal, sum(lain_total) laintotal
        from
            (select msth_tgldoc, mstd_nodoc, mstd_tgldoc, mstd_cterm,  mstd_tgldoc + mstd_cterm jtempo,
            case when nvl(msth_recordid,9) = 1 then 'BATAL' ELSE '' END status,
            CASE WHEN mstd_bkp = 'Y' THEN mstd_gross END gross_bkp,
            CASE WHEN mstd_bkp = 'Y' THEN 0 ELSE mstd_gross END gross_btkp,
            CASE WHEN mstd_bkp = 'Y' THEN mstd_discrph END pot_bkp,
            CASE WHEN mstd_bkp = 'Y' THEN 0 ELSE mstd_discrph END pot_btkp,
            CASE WHEN mstd_bkp = 'Y' THEN mstd_ppnrph END ppn_bkp,
            CASE WHEN mstd_bkp = 'Y' THEN 0 ELSE mstd_ppnrph END ppn_btkp,
            CASE WHEN mstd_bkp = 'Y' THEN mstd_ppnbmrph END bm_bkp,
            CASE WHEN mstd_bkp = 'Y' THEN 0 ELSE mstd_ppnbmrph END bm_btkp,
            CASE WHEN mstd_bkp = 'Y' THEN mstd_ppnbtlrph END btl_bkp,
            CASE WHEN mstd_bkp = 'Y' THEN 0 ELSE mstd_ppnbtlrph END btl_btkp,
            CASE WHEN mstd_bkp = 'Y' THEN (mstd_gross - mstd_discrph + mstd_ppnrph  + mstd_ppnbmrph + mstd_ppnbtlrph) END total_bkp,
            CASE WHEN mstd_bkp = 'Y' THEN 0 ELSE (mstd_gross - mstd_discrph + mstd_ppnrph  + mstd_ppnbmrph + mstd_ppnbtlrph) END total_btkp,
            CASE WHEN mstd_typetrn = 'B' THEN mstd_gross ELSE 0 END beli_gross,
            CASE WHEN mstd_typetrn = 'B' THEN 0 ELSE mstd_gross END lain_gross,
            CASE WHEN mstd_typetrn = 'B' THEN mstd_discrph ELSE 0 END beli_pot,
            CASE WHEN mstd_typetrn = 'B' THEN 0 ELSE mstd_discrph END lain_pot,
            CASE WHEN mstd_typetrn = 'B' THEN mstd_ppnrph ELSE 0 END beli_ppn,
            CASE WHEN mstd_typetrn = 'B' THEN 0 ELSE mstd_ppnrph END lain_ppn,
            CASE WHEN mstd_typetrn = 'B' THEN mstd_ppnbmrph ELSE 0 END beli_bm,
            CASE WHEN mstd_typetrn = 'B' THEN 0 ELSE mstd_ppnbmrph END lain_bm,
            CASE WHEN mstd_typetrn = 'B' THEN mstd_ppnbtlrph ELSE 0 END beli_btl,
            CASE WHEN mstd_typetrn = 'B' THEN 0 ELSE mstd_ppnbtlrph END lain_btl,
            CASE WHEN mstd_typetrn = 'B' THEN (mstd_gross - mstd_discrph + mstd_ppnrph  + mstd_ppnbmrph + mstd_ppnbtlrph) ELSE 0 END beli_total,
            CASE WHEN mstd_typetrn = 'B' THEN 0 ELSE (mstd_gross - mstd_discrph + mstd_ppnrph  + mstd_ppnbmrph + mstd_ppnbtlrph) END lain_total,
            mstd_gross gross, mstd_discrph potongan, mstd_ppnrph ppn,
            mstd_ppnbmrph bm, mstd_ppnbtlrph btl,
            mstd_gross - mstd_discrph + mstd_ppnrph  + mstd_ppnbmrph + mstd_ppnbtlrph total,
            sup_kodesupplier||'-'||sup_namasupplier supplier
            from tbtr_mstran_h, tbtr_mstran_d, tbmaster_supplier
            where msth_kodeigr = '".Session::get('kdigr')."'
            and msth_typetrn = '".$jenis."'
            and nvl(msth_recordid,'9') = '1'
            and to_char(msth_tgldoc, 'yyyymmdd') between '".$t1."' and '".$t2."'
            and mstd_nodoc = msth_nodoc
            and mstd_kodeigr = msth_kodeigr
            and mstd_typetrn = msth_typetrn
            and sup_kodesupplier(+) = msth_kodesupplier
            and sup_kodeigr(+) = msth_kodeigr)
        group by msth_tgldoc, mstd_nodoc, mstd_tgldoc, mstd_cterm, jtempo,
                status, supplier
        order by mstd_nodoc asc");

//        dd($data);

        $pkp = new \stdClass();
        $pkp->gross = 0;
        $pkp->potongan = 0;
        $pkp->ppn = 0;
        $pkp->ppnbm = 0;
        $pkp->botol = 0;
        $pkp->total = 0;

        $npkp = new \stdClass();
        $npkp->gross = 0;
        $npkp->potongan = 0;
        $npkp->ppn = 0;
        $npkp->ppnbm = 0;
        $npkp->botol = 0;
        $npkp->total = 0;

        $pembelian  = new \stdClass();
        $pembelian->gross = 0;
        $pembelian->potongan = 0;
        $pembelian->ppn = 0;
        $pembelian->ppnbm = 0;
        $pembelian->botol = 0;
        $pembelian->total = 0;

        $lain = new \stdClass();
        $lain->gross = 0;
        $lain->potongan = 0;
        $lain->ppn = 0;
        $lain->ppnbm = 0;
        $lain->botol = 0;
        $lain->total = 0;

        $total = new \stdClass();
        $total->gross = 0;
        $total->potongan = 0;
        $total->ppn = 0;
        $total->ppnbm = 0;
        $total->botol = 0;
        $total->total = 0;

        foreach($data as $d){
            $pkp->gross += $d->grossbkp;
            $pkp->potongan += $d->potbkp;
            $pkp->ppn += $d->ppnbkp;
            $pkp->ppnbm += $d->bmbkp;
            $pkp->botol += $d->btlbkp;
            $pkp->total += $d->totalbkp;

            $npkp->gross += $d->grossbtkp;
            $npkp->potongan += $d->potbtkp;
            $npkp->ppn += $d->ppnbtkp;
            $npkp->ppnbm += $d->bmbtkp;
            $npkp->botol += $d->btlbtkp;
            $npkp->total += $d->totalbtkp;

            $pembelian->gross += $d->beligross;
            $pembelian->potongan += $d->belipot;
            $pembelian->ppn += $d->belippn;
            $pembelian->ppnbm += $d->belibm;
            $pembelian->botol += $d->belibtl;
            $pembelian->total += $d->belitotal;

            $lain->gross += $d->laingross;
            $lain->potongan += $d->lainpot;
            $lain->ppn += $d->lainppn;
            $lain->ppnbm += $d->lainbm;
            $lain->botol += $d->lainbtl;
            $lain->total += $d->laintotal;
        }

        $total->gross = $pkp->gross + $npkp->gross;
        $total->potongan = $pkp->potongan + $npkp->potongan;
        $total->ppn = $pkp->ppn + $npkp->ppn;
        $total->ppnbm = $pkp->ppnbm + $npkp->ppnbm;
        $total->botol = $pkp->botol + $npkp->botol;
        $total->total = $pkp->total + $npkp->total;

        return view('BACKOFFICE.CETAKREGISTER.regbtltrm-pdf',compact(['perusahaan','data','tgl1','tgl2','pkp','npkp','pembelian','lain','total']));
    }

    public function regbtlnpb($tgl1, $tgl2){
        $t1 = $this->formatDate($tgl1);
        $t2 = $this->formatDate($tgl2);

        $perusahaan = DB::connection(Session::get('connection'))->table('tbmaster_perusahaan')
            ->first();

        $data = DB::connection(Session::get('connection'))->select("select msth_nodoc, to_char(msth_tgldoc, 'dd/mm/yyyy') msth_tgldoc,supplier, mstd_docno2, to_char(mstd_date2, 'dd/mm/yyyy') mstd_date2, msth_nopo, msth_tglpo,mstd_tgldoc,status, prs_namaperusahaan, prs_namacabang, sup_pkp,
        SUM(mstd_gross) mstd_gross, SUM(mstd_ppnrph) mstd_ppnrph, SUM(mstd_discrph) mstd_discrph
        from (select msth_nodoc, msth_tgldoc, msth_kodesupplier||'-'||sup_namasupplier SUPPLIER,
                case when mstd_docno2 is null then '' else prs_kodemto||'.0'||mstd_docno2 end  mstd_docno2, mstd_date2, mstd_gross, mstd_ppnrph,   mstd_discrph, mstd_tgldoc, msth_nopo, msth_tglpo,
                case when nvl(mstd_recordid,'9') = '1' then 'BATAL' else '' end status,
                prs_namaperusahaan, prs_namacabang, nvl(sup_pkp,'N') sup_pkp
                from tbtr_mstran_h, tbtr_mstran_d, tbmaster_supplier, tbmaster_perusahaan
                where msth_kodeigr='".Session::get('kdigr')."'
                and msth_typetrn='K'
                and NVL(msth_recordid,'0') = '1'
                and to_char(msth_tgldoc, 'yyyymmdd') between '".$t1."' and '".$t2."'
                and mstd_nodoc=msth_nodoc
                and mstd_kodeigr=msth_kodeigr
                and sup_kodesupplier = msth_kodesupplier
                and sup_kodeigr=msth_kodeigr
                and prs_kodeigr=msth_kodeigr)
        group by msth_nodoc, msth_tgldoc,supplier, mstd_docno2, mstd_date2,msth_nopo, msth_tglpo,
        mstd_tgldoc,status, prs_namaperusahaan, prs_namacabang, sup_pkp
        order by msth_nodoc");


//        dd($data);

        $pkp = new \stdClass();
        $pkp->gross = 0;
        $pkp->potongan = 0;
        $pkp->ppn = 0;
        $pkp->total = 0;

        $npkp = new \stdClass();
        $npkp->gross = 0;
        $npkp->potongan = 0;
        $npkp->ppn = 0;
        $npkp->total = 0;

        $pembelian  = new \stdClass();
        $pembelian->gross = 0;
        $pembelian->potongan = 0;
        $pembelian->ppn = 0;
        $pembelian->total = 0;

        $lain = new \stdClass();
        $lain->gross = 0;
        $lain->potongan = 0;
        $lain->ppn = 0;
        $lain->total = 0;

        $total = new \stdClass();
        $total->gross = 0;
        $total->potongan = 0;
        $total->ppn = 0;
        $total->total = 0;

        foreach($data as $d){
            if($d->sup_pkp == 'Y'){
                $pkp->gross += $d->mstd_gross;
                $pkp->potongan += $d->mstd_discrph;
                $pkp->ppn += $d->mstd_ppnrph;
                $pkp->total += $d->mstd_gross + $d->mstd_ppnrph - $d->mstd_discrph;
            }
            else{
                $npkp->gross += $d->mstd_gross;
                $npkp->potongan += $d->mstd_discrph;
                $npkp->ppn += $d->mstd_ppnrph;
                $npkp->total += $d->mstd_gross + $d->mstd_ppnrph - $d->mstd_discrph;
            }
        }

        $total->gross = $pkp->gross + $npkp->gross;
        $total->potongan = $pkp->potongan + $npkp->potongan;
        $total->ppn = $pkp->ppn + $npkp->ppn;
        $total->total = $pkp->total + $npkp->total;

        $pembelian = $total;

        return view('BACKOFFICE.CETAKREGISTER.regbtlnpb-pdf',compact(['perusahaan','data','tgl1','tgl2','pkp','npkp','pembelian','lain','total']));
    }

    public function regbtlmpp($ukuran, $tgl1, $tgl2){
        $t1 = $this->formatDate($tgl1);
        $t2 = $this->formatDate($tgl2);

        $perusahaan = DB::connection(Session::get('connection'))->table('tbmaster_perusahaan')
            ->first();

        $data = DB::connection(Session::get('connection'))->select("select msth_nodoc, to_char(msth_tgldoc, 'dd/mm/yyyy') msth_tgldoc,
                    status, msth_nopo, to_char(msth_tglpo, 'dd/mm/yyyy') msth_tglpo,
                    mstd_tgldoc, mstd_flagdisc1,mstd_ppnrph,
                    sbrg, keterangan, mstd_flagdisc1,
                    sum(total) total
                    from
                    (
                        select msth_nodoc, msth_tgldoc,
                        case when msth_recordid = 1 then
                            'BATAL'
                        else
                            ''
                        end status,msth_nopo, msth_tglpo, mstd_tgldoc,
                         msth_invno, mstd_flagdisc1, nvl(mstd_ppnrph,0) mstd_ppnrph,
                         case when mstd_flagdisc2 = '1' then
                                 'BAIK'
                             when mstd_flagdisc2 = '2' then
                                 'RETUR'
                         else
                                 'RUSAK'
                         end SBRG,
                         case when mstd_flagdisc1= '1' then
                                 'SELISIH STOK OPNAME'
                             when mstd_flagdisc1 = '2' then
                                 'TERTUKAR JENIS'
                         else
                                 'GANTI PLU'
                         end KETERANGAN,
                        nvl(mstd_gross,0) total
                        from tbtr_mstran_h, tbtr_mstran_d
                        where msth_typetrn ='X'
                        and msth_recordid = '1'
                        and msth_kodeigr='".Session::get('kdigr')."'
                        and mstd_nodoc=msth_nodoc
                        and to_char(msth_tgldoc, 'yyyymmdd') between '".$t1."' and '".$t2."'
                    )
                    group by msth_nodoc, msth_tgldoc,status,msth_invno, msth_nopo, msth_tglpo,
                     mstd_flagdisc1,mstd_ppnrph, sbrg, keterangan, mstd_tgldoc
                    order by msth_nodoc");

//        dd($data);

        return view('BACKOFFICE.CETAKREGISTER.regbtlmpp-pdf',compact(['perusahaan','data','tgl1','tgl2','ukuran']));
    }

    public function regtrfcab($cabang, $tgl1, $tgl2){
        $t1 = $this->formatDate($tgl1);
        $t2 = $this->formatDate($tgl2);

        $title = 'Register Transfer Antar Cabang';

        $perusahaan = DB::connection(Session::get('connection'))->table('tbmaster_perusahaan')
            ->first();

        if($cabang == 'ALL')
            $whereCabang = '';
        else $whereCabang = "and nvl(mstd_loc2,'999')  = nvl('".$cabang."',mstd_loc2)";

        $data = DB::connection(Session::get('connection'))->select("select msth_nodoc, to_char(msth_tgldoc, 'dd/mm/yyyy') msth_tgldoc,
                status, msth_noref3, to_char(msth_tgref3, 'dd/mm/yyyy') msth_tgref3,
                mstd_tgldoc, mstd_loc2, mstd_flagdisc1,mstd_ppnrph,prs_namaperusahaan, prs_namacabang,
                title, sum(total) total
                from
                (
                        select msth_nodoc, msth_tgldoc,
                        case when msth_recordid = 1 then
                            'BATAL'
                        else
                            ''
                        end status, msth_nopo msth_noref3, msth_tglpo msth_tgref3, mstd_tgldoc,
                         prs_namaperusahaan, prs_namacabang, msth_invno,  mstd_loc2,
                         mstd_flagdisc1, nvl(mstd_ppnrph,0) mstd_ppnrph,
                         case when mstd_flagdisc1 = 'B' and mstd_flagdisc1 = 'T' then
                                 '** REGISTER DAFTAR BARANG BAIK KE RETUR **'
                             when mstd_flagdisc1 = 'B' and mstd_flagdisc1 = 'R' then
                                 '** REGISTER DAFTAR BARANG BAIK KE RUSAK **'
                         else
                                  '** REGISTER BUKTI PERUBAHAN STATUS **'
                         end title,
                        nvl(mstd_gross,0) total
                        from tbtr_mstran_h, tbtr_mstran_d,tbmaster_perusahaan
                        where msth_typetrn ='I'
                        and msth_kodeigr= '".Session::get('kdigr')."'
                        and mstd_nodoc=msth_nodoc
                        and prs_kodeigr=msth_kodeigr
                       ".$whereCabang."
                        and to_char(msth_tgldoc, 'yyyymmdd') between '".$t1."' and '".$t2."'
                )
                group by msth_nodoc, msth_tgldoc,status,msth_invno, msth_noref3, msth_tgref3, mstd_loc2,
                     mstd_flagdisc1,mstd_ppnrph,prs_namaperusahaan, prs_namacabang, title, mstd_tgldoc
                ORDER BY MSTH_TGLDOC, MSTH_NODOC");

//        dd($data);

        return view('BACKOFFICE.CETAKREGISTER.regtrfcab-pdf',compact(['perusahaan','data','tgl1','tgl2','title']));
    }

    public function regtrfcabbtl($cabang, $tgl1, $tgl2){
        $t1 = $this->formatDate($tgl1);
        $t2 = $this->formatDate($tgl2);

        $title = 'Register Pembatalan Transfer Antar Cabang';

        $perusahaan = DB::connection(Session::get('connection'))->table('tbmaster_perusahaan')
            ->first();

        if($cabang == 'ALL')
            $whereCabang = '';
        else $whereCabang = "and nvl(mstd_loc2,'999') = nvl('".$cabang."',mstd_loc2)";

        $data = DB::connection(Session::get('connection'))->select("select msth_nodoc, to_char(msth_tgldoc, 'dd/mm/yyyy') msth_tgldoc, status, msth_noref3, to_char(msth_tgref3, 'dd/mm/yyyy') msth_tgref3, mstd_tgldoc, mstd_loc2, mstd_flagdisc1,mstd_ppnrph, title, sum(total) total
        from
        (
                select msth_nodoc, msth_tgldoc,
                case when msth_recordid = 1 then
                    'BATAL'
                else
                    ''
                end status, msth_nopo msth_noref3, msth_tglpo msth_tgref3, mstd_tgldoc,
                 msth_invno,  mstd_loc2,
                 mstd_flagdisc1, nvl(mstd_ppnrph,0) mstd_ppnrph,
                 case when mstd_flagdisc1 = 'B' and mstd_flagdisc1 = 'T' then
                         '** REGISTER DAFTAR BARANG BAIK KE RETUR **'
                     when mstd_flagdisc1 = 'B' and mstd_flagdisc1 = 'R' then
                         '** REGISTER DAFTAR BARANG BAIK KE RUSAK **'
                 else
                          '** REGISTER BUKTI PERUBAHAN STATUS **'
                 end title,
                nvl(mstd_gross,0) total
                from tbtr_mstran_h, tbtr_mstran_d
                where msth_typetrn ='I'
                and nvl(mstd_recordid,'9')='1'
                and msth_kodeigr= '".Session::get('kdigr')."'
                and mstd_nodoc=msth_nodoc
               ".$whereCabang."
               and to_char(msth_tgldoc, 'yyyymmdd') between '".$t1."' and '".$t2."'
        )
        group by msth_nodoc, msth_tgldoc,status,msth_invno, msth_noref3, msth_tgref3, mstd_loc2,
             mstd_flagdisc1,mstd_ppnrph,title, mstd_tgldoc
        ORDER BY MSTH_TGLDOC, MSTH_NODOC");

//        dd($data);

        return view('BACKOFFICE.CETAKREGISTER.regtrfcab-pdf',compact(['perusahaan','data','tgl1','tgl2','title']));
    }

    public function regbtlsj($cabang, $tgl1, $tgl2){
        $t1 = $this->formatDate($tgl1);
        $t2 = $this->formatDate($tgl2);

        $perusahaan = DB::connection(Session::get('connection'))->table('tbmaster_perusahaan')
            ->first();

        if($cabang == 'ALL')
            $whereCabang = '';
        else $whereCabang = "and (msth_loc2 ='".$cabang."'  or nvl('".$cabang."',' ')=' ')";

        $data = DB::connection(Session::get('connection'))->select("select msth_nodoc, to_char(msth_tgldoc, 'dd/mm/yyyy') msth_tgldoc, status, msth_noref3, to_char(msth_tgref3, 'dd/mm/yyyy') msth_tgref3,
        mstd_tgldoc,msth_loc2, mstd_flagdisc1,mstd_ppnrph,
        sum(total) total
        from
        (
            select msth_nodoc, msth_tgldoc, msth_loc2,
            case when msth_recordid = '1' then
                'BATAL'
            else
                ''
            end status,msth_noref3, msth_tgref3, mstd_tgldoc,
             msth_invno, mstd_date3,
             mstd_flagdisc1, nvl(mstd_ppnrph,0) mstd_ppnrph,
            nvl(mstd_gross,0) total
            from tbtr_mstran_h, tbtr_mstran_d
            where msth_typetrn ='O'
            and msth_kodeigr='".Session::get('kdigr')."'
            and mstd_nodoc=msth_nodoc
            ".$whereCabang."
            and nvl(msth_recordid,'0')='1'
          and to_char(msth_tgldoc, 'yyyymmdd') between '".$t1."' and '".$t2."'
        )
        group by msth_nodoc, msth_tgldoc,status,msth_invno, mstd_date3,msth_noref3, msth_tgref3,msth_loc2,
         mstd_flagdisc1,mstd_ppnrph,mstd_tgldoc
         order by msth_nodoc");

//        dd($data);

        return view('BACKOFFICE.CETAKREGISTER.regbtlsj-pdf',compact(['perusahaan','data','tgl1','tgl2']));
    }

    function formatDate($date){
        return substr($date,-4).substr($date,3,2).substr($date,0,2);
    }
}
