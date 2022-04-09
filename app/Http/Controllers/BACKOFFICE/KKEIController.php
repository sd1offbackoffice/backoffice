<?php

namespace App\Http\Controllers\BACKOFFICE;

use App\Http\Controllers\Auth\loginController;
use Dompdf\Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller; use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use PDF;

class KKEIController extends Controller
{
    //

    public function index(){
        return view('BACKOFFICE.KKEI');
    }

    public function get_detail_produk(Request $request){
        $prdcd = $request->prdcd;
        $kodeigr = '22';
        $periode = $request->periode;

        $data = array();

        $produk = DB::connection(Session::get('connection'))->table('tbmaster_prodmast')
            ->select('prd_prdcd','prd_deskripsipanjang','prd_unit','prd_frac')
            ->where('prd_kodeigr',$kodeigr)
            ->where('prd_prdcd',$prdcd)
            ->whereNotIn('prd_kodetag',['A', 'R', 'N', 'O', 'T', 'H', 'X'])
            ->whereRaw("NVL(prd_flagbarangordertoko,'N') <> 'Y'")
            ->first();

        if($produk){
            $data['prd_prdcd'] = $produk->prd_prdcd;
            $data['deskripsi'] = $produk->prd_deskripsipanjang;
            $data['unit'] = $produk->prd_unit;
            $data['frac'] = $produk->prd_frac;

            if(substr($prdcd,7,1) != '0'){
                $cprdcd = DB::connection(Session::get('connection'))->table('tbmaster_prodmast')
                    ->select('prd_prdcd')
                    ->whereRaw("SUBSTR (PRD_PRDCD, 1, 6) = SUBSTR ('".$prdcd."', 1, 6)")
                    ->whereRaw("SUBSTR (PRD_PRDCD, 7, 1) <> '0'")
                    ->whereRaw("NVL (PRD_KODETAG, '9') NOT IN ('A', 'R', 'N', 'O', 'T', 'H', 'X')")
                    ->whereRaw("NVL (PRD_FLAGBARANGORDERTOKO, 'N') <> 'Y'")
                    ->orderBy('prd_prdcd')
                    ->first();

                $dimensi = DB::connection(Session::get('connection'))->table('tbmaster_prodmast')
                    ->select('prd_dimensipanjang', 'prd_dimensilebar', 'prd_dimensitinggi')
                    ->where('prd_kodeigr',$kodeigr)
                    ->where('prd_prdcd',$cprdcd->prd_prdcd)
                    ->first();

                $data['panjangproduk'] = $dimensi->prd_dimensipanjang;
                $data['lebarproduk'] = $dimensi->prd_dimensilebar;
                $data['tinggiproduk'] = $dimensi->prd_dimensitinggi;
            }

            $dimensikemasan = DB::connection(Session::get('connection'))->table('tbmaster_prodmast')
                ->select('prd_dimensipanjang', 'prd_dimensilebar', 'prd_dimensitinggi')
                ->where('prd_kodeigr',$kodeigr)
                ->where('prd_prdcd', substr($prdcd,0,6).'0')
                ->whereRaw("NVL (PRD_KODETAG, '9') NOT IN ('A', 'R', 'N', 'O', 'T', 'H', 'X')")
                ->whereRaw("NVL (PRD_FLAGBARANGORDERTOKO, 'N') <> 'Y'")
                ->first();

            if($dimensikemasan){
                $data['panjangkemasan'] = $dimensikemasan->prd_dimensipanjang;
                $data['lebarkemasan'] = $dimensikemasan->prd_dimensilebar;
                $data['tinggikemasan'] = $dimensikemasan->prd_dimensitinggi;
            }
            else{
                $data['panjangkemasan'] = 0;
                $data['lebarkemasan'] = 0;
                $data['tinggikemasan'] = 0;
            }

            $barang = DB::connection(Session::get('connection'))->table('tbmaster_barang')
                ->select('brg_brutopcs','brg_brutoctn')
                ->where('brg_kodeigr',$kodeigr)
                ->where('brg_prdcd',$prdcd)
                ->first();

            if($barang){
                $data['beratprod'] = $barang->brg_brutopcs / 1000;
                $data['beratkmsn'] = $barang->brg_brutoctn / 1000;
            }

            $data['kubikasiprod'] = ($data['panjangproduk'] * $data['lebarproduk'] * $data['tinggiproduk']) / 1000000;
            $data['kubikasikemasan'] = ($data['panjangkemasan'] * $data['lebarkemasan'] * $data['tinggikemasan']) / 1000000;

            $hgb = DB::connection(Session::get('connection'))->table('tbmaster_hargabeli')
                ->where('hgb_kodeigr',$kodeigr)
                ->where('hgb_tipe','2')
                ->where('hgb_prdcd',$prdcd)
                ->first();

            if($hgb){
                $diskon = 0;

                $data['hargabeli'] = $hgb->hgb_hrgbeli;

                $now = Carbon::now();

                if($hgb->hgb_tglmulaidisc01 < $now && $now < $hgb->hgb_tglakhirdisc01)
                    $diskon += $hgb->hgb_rphdisc01;
                if($hgb->hgb_tglmulaidisc02 < $now && $now < $hgb->hgb_tglakhirdisc02)
                    $diskon += $hgb->hgb_rphdisc02;
                if($hgb->hgb_tglmulaidisc02ii < $now && $now < $hgb->hgb_tglakhirdisc02ii)
                    $diskon += $hgb->hgb_rphdisc02ii;
                if($hgb->hgb_tglmulaidisc02iii < $now && $now < $hgb->hgb_tglakhirdisc02iii)
                    $diskon += $hgb->hgb_rphdisc02iii;
                if($hgb->hgb_tglmulaidisc03 < $now && $now < $hgb->hgb_tglakhirdisc03)
                    $diskon += $hgb->hgb_rphdisc03;
                if($hgb->hgb_tglmulaidisc04 < $now && $now < $hgb->hgb_tglakhirdisc04)
                    $diskon += $hgb->hgb_rphdisc04;
                if($hgb->hgb_tglmulaidisc05 < $now && $now < $hgb->hgb_tglakhirdisc05)
                    $diskon += $hgb->hgb_rphdisc05;
                if($hgb->hgb_tglmulaidisc06 < $now && $now < $hgb->hgb_tglakhirdisc06)
                    $diskon += $hgb->hgb_rphdisc06;

                $data['diskon'] = $diskon;

                if(substr($periode,3,2) == '01')
                    $n = '12';
                else $n = substr($periode,3,2) - 1;
                if($n < 10)
                    $n = '0'.$n;

                if(substr($periode,3,2) == '01')
                    $x1 = '11';
                else if(substr($periode,3,2) == '02')
                    $x1 = '12';
                else $x1 = substr($periode,3,2) - 2;
                if($x1 < 10)
                    $x1 = '0'.$x1;

                if(substr($periode,3,2) == '01')
                    $x2 = '10';
                else if(substr($periode,3,2) == '02')
                    $x2 = '11';
                else if(substr($periode,3,2) == '03')
                    $x2 = '12';
                else $x2 = substr($periode,3,2) - 3;
                if($x2 < 10)
                    $x2 = '0'.$x2;


                $connection = loginController::getConnectionProcedure();
                $exec = oci_parse($connection, "BEGIN  SP_SLTREND (:kodeigr, :x2, :x1, :n, :prdcd, :sales01, :sales02, :sales03); END;");
                oci_bind_by_name($exec, ':kodeigr',$kodeigr,100);
                oci_bind_by_name($exec, ':x2',$x2,100);
                oci_bind_by_name($exec, ':x1',$x1,100);
                oci_bind_by_name($exec, ':n',$n,100);
                oci_bind_by_name($exec, ':prdcd',$prdcd,100);
                oci_bind_by_name($exec, ':sales01',$sales01,100);
                oci_bind_by_name($exec, ':sales02',$sales02,100);
                oci_bind_by_name($exec, ':sales03',$sales03,100);
                oci_execute($exec);

                $data['sales1'] = $sales01;
                $data['sales2'] = $sales02;
                $data['sales3'] = $sales03;

                if($sales01 > 0 && $sales02 > 0 && $sales03 > 0){
                    $data['avgslsbln'] = ($sales01 + $sales02 + $sales03) / 3;
                    $data['avgslshari'] = $data['avgslsbln'] / 30;
                }
                else{
                    if(($sales01 > 0 && $sales02 > 0 && $sales03 == 0) || ($sales01 > 0 && $sales02 == 0 && $sales03 > 0) || ($sales01 == 0 && $sales02 > 0 && $sales03 > 0)){
                        $data['avgslsbln'] = ($sales01 + $sales02 + $sales03) / 2;
                        $data['avgslshari'] = $data['avgslsbln'] / 30;
                    }
                    else{
                        $data['avgslsbln'] = ($sales01 + $sales02 + $sales03) / 1;
                        $data['avgslshari'] = $data['avgslsbln'] / 30;
                    }
                }

                $stock = DB::connection(Session::get('connection'))->table('tbmaster_stock')
                    ->select('st_saldoakhir')
                    ->where('st_kodeigr',$kodeigr)
                    ->where('st_lokasi','01')
                    ->where('st_prdcd',$prdcd)
                    ->first();

                if($stock){
                    $data['saldoawal'] = $stock->st_saldoakhir;
                    $data['saldoakhir'] = $stock->st_saldoakhir;
                }

                $supplier = DB::connection(Session::get('connection'))->table('tbmaster_supplier')
                    ->select('sup_kodesupplier','sup_namasupplier')
                    ->where('sup_kodesupplier',$hgb->hgb_kodesupplier)
                    ->first();

                $data['kodesupplier'] = $supplier->sup_kodesupplier;
                $data['namasupplier'] = $supplier->sup_namasupplier;
            }

            $po = DB::connection(Session::get('connection'))->table('tbtr_po_d')
                ->select('tpod_qtypo')
                ->where('tpod_kodeigr',$kodeigr)
                ->where('tpod_recordid',null)
                ->where('tpod_prdcd',$prdcd)
                ->sum('tpod_qtypo');

            $kkei = DB::connection(Session::get('connection'))->table('temp_kkei')
                ->select(
                    'kke_estimasi',
                    'kke_breakpb01',
                    'kke_breakpb02',
                    'kke_breakpb03',
                    'kke_breakpb04',
                    'kke_breakpb05',
                    'kke_bufferlt',
                    'kke_bufferss',
                    'kke_saldoakhir',
                    'kke_tglkirim01',
                    'kke_tglkirim02',
                    'kke_tglkirim03',
                    'kke_tglkirim04',
                    'kke_tglkirim05',
                    'kke_kubik1',
                    'kke_kubik2',
                    'kke_kubik3',
                    'kke_kubik4',
                    'kke_kubik5'
                )
                ->where('kke_periode',str_replace(array('/'), '',$periode))
                ->where('kke_prdcd',$prdcd)
                ->first();

            $status = 'success';

//            dd(compact(['data','kkei']));
            return compact(['status','data','kkei','po']);
        }
        else{
            $status = 'not-found';
            $message = 'PLU tidak ada di Prodmast!';
            return compact(['status','message']);
        }
    }

    public function get_detail_kkei(Request $request){
        $data = DB::connection(Session::get('connection'))->table('temp_kkei')
            ->where('kke_periode',$request->periode)
            ->get();

        if(count($data) > 0){
            $status = 'success';
            $message = 'Data ditemukan!';
        }
        else{
            $status = 'new-data';
            $message = 'Buat data baru!';
        }

        return compact(['status','message','data']);
    }

    public function save(Request $request){
        $kodeigr = '22';
        $kkeis = array();
        $prdcd = array();

        DB::connection(Session::get('connection'))->beginTransaction();

        try{
            if(!empty($request->deleted)){
                DB::connection(Session::get('connection'))->table('temp_kkei')
                    ->where('kke_periode','=',$request->periode)
                    ->whereIn('kke_prdcd',$request->deleted)
                    ->delete();
                $status = 'success';
                $message = 'Berhasil menghapus data!';
            }

            if(!empty($request->kkei)){
                for($i=0;$i<count($request->kkei);$i++){
                    $kkei = $request->kkei[$i];
                    $kkei['kke_kodeigr'] = $kodeigr;

                    if($kkei['kke_tglkirim01'] != '' || $kkei['kke_tglkirim01'] != null)
                        $kkei['kke_tglkirim01'] = DB::connection(Session::get('connection'))->raw("to_date('".$kkei['kke_tglkirim01']."','dd/mm/yyyy')");
                    else $kkei['kke_tglkirim01'] = '';
                    if($kkei['kke_tglkirim02'] != '' || $kkei['kke_tglkirim02'] != null)
                        $kkei['kke_tglkirim02'] = DB::connection(Session::get('connection'))->raw("to_date('".$kkei['kke_tglkirim02']."','dd/mm/yyyy')");
                    else $kkei['kke_tglkirim02'] = '';
                    if($kkei['kke_tglkirim03'] != '' || $kkei['kke_tglkirim03'] != null)
                        $kkei['kke_tglkirim03'] = DB::connection(Session::get('connection'))->raw("to_date('".$kkei['kke_tglkirim03']."','dd/mm/yyyy')");
                    else $kkei['kke_tglkirim03'] = '';
                    if($kkei['kke_tglkirim04'] != '' || $kkei['kke_tglkirim04'] != null)
                        $kkei['kke_tglkirim04'] = DB::connection(Session::get('connection'))->raw("to_date('".$kkei['kke_tglkirim04']."','dd/mm/yyyy')");
                    else $kkei['kke_tglkirim04'] = '';
                    if($kkei['kke_tglkirim05'] != '' || $kkei['kke_tglkirim05'] != null)
                        $kkei['kke_tglkirim05'] = DB::connection(Session::get('connection'))->raw("to_date('".$kkei['kke_tglkirim05']."','dd/mm/yyyy')");
                    else $kkei['kke_tglkirim05'] = '';

                    array_push($prdcd, $kkei['kke_prdcd']);

                    $delete = DB::connection(Session::get('connection'))->table('temp_kkei')
                        ->where('kke_periode',$kkei['kke_periode'])
                        ->where('kke_prdcd',$kkei['kke_prdcd'])
                        ->delete();
                    $insert = DB::connection(Session::get('connection'))->table('temp_kkei')
                        ->insert($kkei);
                }

                if($insert){
                    $status = 'success';
                    $message = 'Berhasil menyimpan data!';
                }
                else{
                    $status = 'failed';
                    $message = 'Gagal menyimpan data!';
                }
            }

            DB::connection(Session::get('connection'))->commit();
        }
        catch (QueryException $e){
            $status = 'failed';
            $message = 'Gagal menyimpan data!';
            DB::connection(Session::get('connection'))->rollBack();
        }

        return compact(['status','message']);
    }

    public function laporan(Request $request){
        $perusahaan = DB::connection(Session::get('connection'))->table('tbmaster_perusahaan')
            ->first();

        $data = DB::connection(Session::get('connection'))->table('temp_kkei')
            ->where('kke_periode',$request->periode)
            ->orderBy('kke_kdsup')
            ->get();

        $bulan = array(
            'Januari','Februri','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'
        );

        $periode = substr($request->periode,0,2).' '.$bulan[(int) substr($request->periode,2,2)].' '.substr($request->periode,4,4);

        return view('BACKOFFICE.KKEI-pdf',compact(['data','perusahaan','periode']));

        $data = [
            'data' => $data,
            'perusahaan' => $perusahaan,
            'periode' => $periode
        ];

        $now = Carbon::now('Asia/Jakarta');
        $now = date_format($now,'d-m-Y H-i-s');

        $dompdf = new PDF();

        $pdf = PDF::loadview('BACKOFFICE.KKEI-pdf',$data);

        error_reporting(E_ALL ^ E_DEPRECATED);

        $pdf->output();
        $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);

        $canvas = $dompdf ->get_canvas();
        $canvas->page_text(1000, 10, "Page {PAGE_NUM} of {PAGE_COUNT}", null, 8, array(0, 0, 0));

        $dompdf = $pdf;

        // (Optional) Setup the paper size and orientation
//        $dompdf->setPaper('a4', 'landscape');

        // Render the HTML as PDF

        return $dompdf->download('laporan-kkei '.$now.'.pdf');
    }
}
