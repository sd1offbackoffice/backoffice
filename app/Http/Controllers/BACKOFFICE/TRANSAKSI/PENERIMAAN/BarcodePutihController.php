<?php

namespace App\Http\Controllers\BACKOFFICE\TRANSAKSI\PENERIMAAN;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Mail\Email;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\DataTables;

class BarcodePutihController extends Controller
{
    protected $priceCtnBarcode;
    protected $pricePcsBarcode;

    public function __construct()
    {
        $ctn = DB::connection(Session::get('connection'))->table('TBMASTER_BARCODE_PRICE')
                            ->where('B_UNIT', '=', 'CTN')
                            ->first();
        $pcs = DB::connection(Session::get('connection'))->table('TBMASTER_BARCODE_PRICE')
                            ->where('B_UNIT', '=', 'PCS')
                            ->first();
        $this->priceCtnBarcode = $ctn->b_price;
        $this->pricePcsBarcode = $pcs->b_price;
    }

    public function index() {
        return view('BACKOFFICE.TRANSAKSI.PENERIMAAN.barcode-putih');
    }

    public function showSJFData(Request $request) {
        $kodeigr = Session::get('kdigr');        
        
        $data = DB::connection(Session::get('connection'))
                    ->select("SELECT DISTINCT MSTD_NOFAKTUR, TRUNC(MSTD_TGLDOC) MSTD_TGLDOC FROM TBTR_MSTRAN_D
                    WHERE MSTD_TYPETRN = 'B'
                    AND MSTD_KODEIGR = '".$kodeigr."'
                    AND MSTD_TGLDOC IS NOT NULL
                    AND ROWNUM <= 100
                    ORDER BY MSTD_TGLDOC DESC");        

        return DataTables::of($data)->make(true);
    }

    public function checkNoFaktur(Request $request) {
        $kodeigr = Session::get('kdigr');
        $noFaktur = $request->noFaktur;

        $data = DB::connection(Session::get('connection'))->table('TBTR_MSTRAN_D')
                ->select('prd_plumcg', 'mstd_nodoc', 'mstd_nopo', 'mstd_prdcd', 'mstd_nofaktur', 'mstd_tgldoc', 'prd_deskripsipanjang', 'mstd_unit', 'mstd_frac', 'mstd_qty')
                ->join('TBMASTER_PRODMAST', 'MSTD_PRDCD', '=', 'PRD_PRDCD')
                ->where('MSTD_NOFAKTUR', '=', $noFaktur)
                ->where('MSTD_KODEIGR', '=', $kodeigr)
                ->where('MSTD_TYPETRN', '=', 'B')
                ->get();

        if (isset($data)) {
            return response()->json([
                'status' => 'SUCCESS',
                'message' => 'No Faktur found',
                'data' => $data
            ]);
        } else {
            return response()->json([
                'status' => 'FAILED',
                'message' => 'No Faktur not found'
            ]);
        }
    }

    public function checkPluBarcode(Request $request) {
        $data = $request->data;        
        
        $prd_plumcg = $data['prd_plumcg'];       

        $data_master_barcode = DB::connection(Session::get('connection'))->table('TBMASTER_PLUNONBARCODE')                                
                                ->where('PNB_PLUMCG', '=', $prd_plumcg)                                
                                ->first();
                                
        $data_master_klaim_barcode = DB::connection(Session::get('connection'))->table('TBMASTER_CLAIMPLUNONBARCODE')                                        
                                        ->where('CNB_PLUMCG', '=', $prd_plumcg)                                        
                                        ->first();

        if (isset($data_master_barcode)) {
            $keterangan = 'TERDAPAT DI MASTER BARCODE';
            $status = 'INFO MASTER';
            $message = 'Data PLUMCG ' . $prd_plumcg . ' sudah ada di Master Barcode';
        } else {
            if (isset($data_master_klaim_barcode)) {
                $keterangan = 'TERDAPAT DI MASTER KLAIM BARCODE';
                $status = 'SUCCESS';
                $message = 'Data PLUMCG ' . $prd_plumcg . ' sudah ada di Master Klaim Barcode';

                $data_master_prodmast = DB::connection(Session::get('connection'))->table('TBMASTER_PRODMAST')                                        
                                        ->where('PRD_PLUMCG', '=', $prd_plumcg)                                        
                                        ->get();
                $data_print = [];
                for ($i=0; $i < sizeof($data_master_prodmast); $i++) {                                                           
                    if($data['mstd_qty'] >= $data_master_prodmast[$i]->prd_frac){
                        switch ($data_master_prodmast[$i]->prd_unit) {
                            case 'CTN':
                                $d = (object)'';
                                $d->nofaktur =  $data['mstd_nofaktur'];
                                $d->nodoc = $data['mstd_nodoc'];
                                $d->no_po = $data['mstd_nopo'];
                                $d->prd_plumcg = $data_master_prodmast[$i]->prd_plumcg;
                                $d->prd_prdcd = $data_master_prodmast[$i]->prd_prdcd;                            
                                $d->prd_deskripsipanjang = $data_master_prodmast[$i]->prd_deskripsipanjang;
                                $d->prd_unit = $data_master_prodmast[$i]->prd_unit;
                                $d->prd_frac = $data_master_prodmast[$i]->prd_frac;
                                $d->qty = $data['mstd_qty'] / $data_master_prodmast[$i]->prd_frac;
                                $d->total_price_barcode = $d->qty * $this->priceCtnBarcode;

                                array_push($data_print, $d);
                                break;
                            case 'PCS':
                                if ($data_master_prodmast[$i]->prd_minjual == 1) {
                                    $d = (object)'';
                                    $d->nofaktur =  $data['mstd_nofaktur'];
                                    $d->nodoc = $data['mstd_nodoc'];
                                    $d->no_po = $data['mstd_nopo'];
                                    $d->prd_plumcg = $data_master_prodmast[$i]->prd_plumcg;
                                    $d->prd_prdcd = $data_master_prodmast[$i]->prd_prdcd;                            
                                    $d->prd_deskripsipanjang = $data_master_prodmast[$i]->prd_deskripsipanjang;
                                    $d->prd_unit = $data_master_prodmast[$i]->prd_unit;
                                    $d->prd_frac = $data_master_prodmast[$i]->prd_frac;
                                    $d->qty = $data['mstd_qty'] / $data_master_prodmast[$i]->prd_frac;
                                    $d->total_price_barcode = $d->qty * $this->pricePcsBarcode;

                                    array_push($data_print, $d);
                                }                                
                                break;                            
                            // default:
                            //     $d = (object)'';
                            //     $d->nofaktur =  $data['mstd_nofaktur'];
                            //     $d->nodoc = $data['mstd_nodoc'];
                            //     $d->no_po = $data['mstd_nopo'];
                            //     $d->prd_plumcg = $data_master_prodmast[$i]->prd_plumcg;
                            //     $d->prd_prdcd = $data_master_prodmast[$i]->prd_prdcd;                            
                            //     $d->prd_deskripsipanjang = $data_master_prodmast[$i]->prd_deskripsipanjang;
                            //     $d->prd_unit = $data_master_prodmast[$i]->prd_unit;
                            //     $d->prd_frac = $data_master_prodmast[$i]->prd_frac;
                            //     $d->qty = $data['mstd_qty'] / $data_master_prodmast[$i]->prd_frac;
                            //     // $d->total_price_barcode = $d->qty * $this->priceCtnBarcode;

                            //     array_push($data_print, $d);
                            //     break;
                        }
                    }
                }
            } else {
                $keterangan = 'TIDAK ADA DI MASTER KLAIM BARCODE';
                $status = 'INFO KLAIM';
                $message = 'Data PLUMCG ' . $prd_plumcg . ' tidak ada di Master Klaim Barcode';
            }
        }

        $datas = [
            'nodoc' => $data['mstd_nodoc'],
            'no_po' => $data['mstd_nopo'],
            'prd_plumcg' => $data['prd_plumcg'],
            'mstd_prdcd' => $data['mstd_prdcd'],
            'prd_deskripsipanjang' => $data['prd_deskripsipanjang'],
            'mstd_unit' => $data['mstd_unit'],
            'mstd_frac' => $data['mstd_frac'],            
            'mstd_qty' =>$data['mstd_qty'],            
            'mstd_nofaktur' => $data['mstd_nofaktur'],
            'mstd_tgldoc' => $data['mstd_tgldoc'],
            'keterangan' => $keterangan
        ];        

        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => [
                'datas' => $datas,
                'data_print' => $data_print
            ]
        ]);
    }

    public function sendEmail(Request $request) {
        $notExistsInMasterKlaim = $request->notExistsInMasterKlaim;

        $receivers = DB::connection(Session::get('connection'))->table('TBMASTER_EMAIL')                                        
                    ->where('EML_USER', '=', 'INVENTORY HO')                                        
                    ->get();

        $demo = (object)'';
        $demo->document = '';
        $demo->from = 'noreply.sd1@indomaret.co.id';
        $demo->subject = 'DATA MASTER KLAIM BARCODE PUTIH';

        $content = '';
        foreach ($notExistsInMasterKlaim as $data) {
            $content .= '<tr>
                <td>'.$data['mstd_prdcd'].'</td>
                <td>'.$data['prd_deskripsipanjang'].'</td>
                <td>XX</td>
            </tr>';
        }

        $text = '
        <html>
            <head>
                <title></title>
                <link href="https:
            </head>
            <body style="cursor: auto;">
                <p>No Faktur : '.$notExistsInMasterKlaim[0]['mstd_nofaktur'].'</p>
                <p>Tanggal Dokumen: '.$notExistsInMasterKlaim[0]['mstd_tgldoc'].'</p><br />
                &nbsp;
                <table border="1" cellpadding="1" cellspacing="1" style="width:100%">
                    <thead>
                        <tr>
                            <th scope="col">PLU</th>
                            <th scope="col">DESKRIPSI</th>
                            <th scope="col">STATUS BARCODE</th>
                        </tr>
                    </thead>
                    <tbody>
                    '.$content.'
                    </tbody>
                </table>
                <br />
                Data di atas tidak dapat diklaim ke Principal.
            </body>
        </html>';

        $demo->text = $text;
        
        try {
            // Mail::to($receiver)->send(new Email($demo));
            foreach ($receivers as $receiver) {
                Mail::to($receiver->eml_email)->send(new Email($demo));
            }

            return response()->json([
                'status' => 'SUCCESS',
                'message' => 'Email berhasil terkirim'
            ]);
        } catch (\Throwable $th) {

            return response()->json([
                'status' => 'FAILED',
                'message' => 'Email gagal dikirim'
            ]);
        }

        
    }

    // public function printBarcode(Request $request) {
    //     $kodeigr = Session::get('kdigr');
    //     $plus = $request->plus;
    //     $noFaktur = $request->noFaktur;
    //     $arrPlus = explode(',', $plus);

    //     $perusahaan = DB::connection(Session::get('connection'))->table('tbmaster_perusahaan')
    //         ->select('prs_namaperusahaan', 'prs_namacabang')
    //         ->first();

    //     $data_master = DB::connection(Session::get('connection'))->table('TBMASTER_PRODMAST')                                
    //             ->whereIn('prd_plumcg', $arrPlus)
    //             ->get();

    //     $temp_plumcg = '';
    //     $data = [];

    //     for ($i=0; $i < sizeof($data_master); $i++) { 
    //         if($data_master[$i]->prd_plumcg != $temp_plumcg){
    //             $temp_plumcg = $data_master[$i]->prd_plumcg;
    //         }

    //         if($data_master[$i]->prd_unit == 'CTN' || $data_master[$i]->prd_unit == 'PCS'){
    //             $d = (object)'';
                
    //         }
    //     }        
        
    //     return view('BACKOFFICE.TRANSAKSI.PENERIMAAN.barcode-putih-pdf', compact('data', 'perusahaan'));
    // }

    public function saveBarcodePrint(Request $request) {
        $kodeigr = Session::get('kdigr');        
        $bp_create_date = DB::connection(Session::get('connection'))->raw("to_date('".Carbon::now()->format('d/m/Y')."','dd/mm/yyyy')");
        $data = $request->data;        
        
        $data_barcode_putih = DB::connection(Session::get('connection'))->table('TBTR_BARCODE_PUTIH')
                                ->where('BP_KODEIGR', '=', $kodeigr)
                                ->where('BP_NOFAKTUR', '=', $data[0]['nofaktur'])
                                ->get();
                                
        if (sizeof($data_barcode_putih) > 0) {
            return response()->json([
                'status' => 'FAILED',
                'message' => 'Data Barcode Putih No Faktur '. $data[0]['nofaktur'] .' Sudah ada'
            ]);
        } else {
            foreach ($data as $d) {            
                
                DB::connection(Session::get('connection'))->table('TBTR_BARCODE_PUTIH')->insert([
                    'BP_KODEIGR' => $kodeigr,
                    'BP_NODOC' => $d['nodoc'],
                    'BP_NOPO' => $d['no_po'],
                    'BP_NOFAKTUR' => $d['nofaktur'],
                    'BP_PLUMCG' => $d['prd_plumcg'],
                    'BP_PRDCD' => $d['prd_prdcd'],
                    'BP_DESKRIPSIPANJANG' => $d['prd_deskripsipanjang'],
                    'BP_UNIT' => $d['prd_unit'],
                    'BP_FRAC' => $d['prd_frac'],
                    'BP_UNIT_QTY' => $d['qty'],
                    'BP_TOTALPRICE' => $d['total_price_barcode'],
                    'BP_CREATE_DATE' => $bp_create_date
                ]);
            }

            return response()->json([
                'status' => 'SUCCESS',
                'message' => 'Data Barcode Putih No Faktur '. $data[0]['nofaktur'] .' Berhasil Disimpan'
            ]);
        }                
    }
}


