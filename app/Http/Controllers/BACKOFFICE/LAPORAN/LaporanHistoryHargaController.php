<?php

namespace App\Http\Controllers\BACKOFFICE\LAPORAN;

use App\Http\Controllers\Auth\loginController;
use App\Http\Controllers\ExcelController;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller; use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Mockery\Exception;
use PDF;
use Yajra\DataTables\DataTables;

class LaporanHistoryHargaController extends Controller
{
    public function index(){
        return view('BACKOFFICE.LAPORAN.laporan-history-harga');
    }

    public function getLovPLU(Request $request){
        $search = $request->plu;

        if($search == ''){
            $produk = DB::connection(Session::get('connection'))->table('tbmaster_prodmast')
                ->selectRaw("prd_prdcd,prd_deskripsipanjang, prd_unit || '/' || prd_frac satuan")
                ->where('prd_kodeigr',Session::get('kdigr'))
                ->whereRaw("substr(prd_prdcd,-1) = '0'")
                ->orderBy('prd_prdcd')
                ->limit(100)
                ->get();
        }
        else if(is_numeric($search)){
            $produk = DB::connection(Session::get('connection'))->table('tbmaster_prodmast')
                ->selectRaw("prd_prdcd,prd_deskripsipanjang, prd_unit || '/' || prd_frac satuan")
                ->where('prd_kodeigr',Session::get('kdigr'))
                ->where('prd_prdcd','like',DB::connection(Session::get('connection'))->raw("'%".$search."%'"))
                ->whereRaw("substr(prd_prdcd,-1) = '0'")
                ->orderBy('prd_prdcd')
                ->get();
        }
        else{
            $produk = DB::connection(Session::get('connection'))->table('tbmaster_prodmast')
                ->selectRaw("prd_prdcd,prd_deskripsipanjang, prd_unit || '/' || prd_frac satuan")
                ->where('prd_kodeigr',Session::get('kdigr'))
                ->where('prd_deskripsipanjang','like',DB::connection(Session::get('connection'))->raw("'%".$search."%'"))
                ->whereRaw("substr(prd_prdcd,-1) = '0'")
                ->orderBy('prd_prdcd')
                ->get();
        }

        return DataTables::of($produk)->make(true);
    }

    public function getDataPLU(Request $request){
        $data = DB::connection(Session::get('connection'))->table('tbmaster_prodmast')
            ->selectRaw("prd_prdcd,prd_deskripsipanjang")
            ->where('prd_kodeigr',Session::get('kdigr'))
            ->where('prd_prdcd','=',$request->plu)
            ->whereRaw("substr(prd_prdcd,-1) = '0'")
            ->first();

        if(!$data){
            return response()->json([
                'message' => 'PLU '.$request->plu.' tidak ditemukan!'
            ], 500);
        }
        else return response()->json($data);
    }

    public function print(Request $request){
        $tgl1 = $request->tgl1;
        $tgl2 = $request->tgl2;
        $plu1 = $request->plu1;
        $plu2 = $request->plu2;

        set_time_limit(0);


        $perusahaan = DB::connection(Session::get('connection'))
            ->table('tbmaster_perusahaan')
            ->first();

        $data = DB::connection(Session::get('connection'))
            ->select("select hcs_prdcd, prd_deskripsipanjang, to_char(hcs_tglbpb, 'dd/mm/yyyy') hcs_tglbpb,
                hcs_nodocbpb, hcs_avglama, hcs_avgbaru, hcs_lastqty,
                 hcs_lastcostlama,hcs_lastcostbaru,
                 to_char(nvl(hcs_modify_dt, hcs_create_dt),'dd/mm/yyyy') tgl_upd,
                 to_char(nvl(hcs_modify_dt, hcs_create_dt),'hh24:mi:ss') jam_upd,
                 nvl(hcs_modify_by,hcs_create_by) usr
            from tbhistory_cost, tbmaster_prodmast
            where hcs_tglbpb between to_date('".$tgl1."','dd/mm/yyyy') and to_date('".$tgl2."','dd/mm/yyyy')
            and hcs_prdcd between '".$plu1."' and '".$plu2."'
            and prd_prdcd=hcs_prdcd
            and prd_kodeigr=hcs_kodeigr
            and hcs_kodeigr='".Session::get('kdigr')."'
            order by hcs_prdcd,hcs_tglbpb,hcs_nodocbpb");

//        return view('BACKOFFICE.LAPORAN.laporan-history-harga-pdf',compact(['perusahaan','data','plu1','plu2','tgl1','tgl2']));
//        ExcelController::create($view,$filename,$title,$subtitle,$keterangan,8);
//        $view = view('BACKOFFICE.LAPORAN.laporan-history-harga-xlxs', compact(['perusahaan','data','plu1','plu2','tgl1','tgl2']))->render();
            return $this->excel_LaporanHistoryHarga($data,$plu1,$plu2,$tgl1,$tgl2);
        }

    public function excel_LaporanHistoryHarga($data,$plu1,$plu2,$tgl1,$tgl2){

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $fontBold = [
            'font' => [
                'bold' => true,
            ]
        ];
        $border = [
            'font' => [
                'bold' => true,
            ],
            'borders' => [
                'top' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
                'bottom' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];

        $sheet->setCellValue('A1', "TANGGAL");
        $sheet->setCellValue('B1', "NO. BPB");
        $sheet->setCellValue('C1', "COST LAMA");
        $sheet->setCellValue('D1', "COST BARU");
        $sheet->setCellValue('E1', "SISA STOK");
        $sheet->setCellValue('F1', "L.COST LAMA");
        $sheet->setCellValue('G1', "L.COST BARU");
        $sheet->setCellValue('H1', "TGL UPDATE");
        $sheet->setCellValue('I1', "JAM UPDATE");
        $sheet->setCellValue('J1', "USER");
        $sheet->getStyle('A1:J1')->applyFromArray($border);
        $plu = '';
        $row = 2 ;

        for ($i=0;$i<sizeof($data);$i++){
            if($plu != $data[$i]->hcs_prdcd){
                $plu = $data[$i]->hcs_prdcd;
                $sheet->setCellValue('A'.$row, $data[$i]->hcs_prdcd." ".$data[$i]->prd_deskripsipanjang);
                $sheet->getStyle('A'.$row)->applyFromArray($fontBold);
                $sheet->mergeCells('A'.$row.':J' .$row);
                $row++;
            }

            $sheet->setCellValue('A'.$row, $data[$i]->hcs_tglbpb);
            $sheet->setCellValue('B'.$row, $data[$i]->hcs_nodocbpb);
            $sheet->setCellValue('C'.$row, number_format($data[$i]->hcs_avglama, 2));
            $sheet->setCellValue('D'.$row, number_format($data[$i]->hcs_avgbaru, 2));
            $sheet->setCellValue('E'.$row, number_format($data[$i]->hcs_lastqty, 2));
            $sheet->setCellValue('F'.$row, number_format($data[$i]->hcs_lastcostlama, 2));
            $sheet->setCellValue('G'.$row, number_format($data[$i]->hcs_lastcostbaru, 2));
            $sheet->setCellValue('H'.$row, $data[$i]->tgl_upd);
            $sheet->setCellValue('I'.$row, $data[$i]->jam_upd);
            $sheet->setCellValue('J'.$row, $data[$i]->usr);
            $row++;
        }

        $title = 'LAPORAN HISTORY HARGA';
        $subtitle = "Kode PLU : ". $plu1 ." s/d ". $plu2 ." Dari Tgl. ". $tgl1 ." s/d ". $tgl2 ;
        $keterangan = '';
        $filename = str_replace('/','',$title).'_'.Carbon::now()->format('dmY_His').'.xlsx';

        ExcelController::createFromData($spreadsheet,$data,$filename,$title,$subtitle,$keterangan,8);
        return response()->download(storage_path($filename))->deleteFileAfterSend(true);

    }
}
