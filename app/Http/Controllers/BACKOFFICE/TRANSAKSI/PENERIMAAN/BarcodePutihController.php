<?php

namespace App\Http\Controllers\BACKOFFICE\TRANSAKSI\PENERIMAAN;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Mail\Email;
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
        // $data = DB::connection(Session::get('connection'))->table('TBTR_MSTRAN_D')
        //             ->where('MSTD_TYPETRN', '=', 'B')
        //             ->orderBy('MSTD_TGLDOC', 'DESC')
        //             ->limit(100)
        //             ->get();
        $data = DB::connection(Session::get('connection'))
                    ->select("SELECT DISTINCT MSTD_NOFAKTUR, TRUNC(MSTD_TGLDOC) MSTD_TGLDOC FROM TBTR_MSTRAN_D
                    WHERE MSTD_TYPETRN = 'B'
                    AND MSTD_KODEIGR = '".$kodeigr."'
                    AND MSTD_TGLDOC IS NOT NULL
                    AND ROWNUM <= 100
                    ORDER BY MSTD_TGLDOC DESC");
        // dd($data);

        return DataTables::of($data)->make(true);
    }

    // public function showData(Request $request){
    //     $data = $request->plu_datas;
    //     dd($data);
    //     return DataTables::of($data)->make(true);
    // }

    public function checkNoFaktur(Request $request) {
        $kodeigr = Session::get('kdigr');
        $noFaktur = $request->noFaktur;

        $data = DB::connection(Session::get('connection'))->table('TBTR_MSTRAN_D')
                ->select('prd_plumcg', 'mstd_prdcd', 'mstd_nofaktur', 'mstd_tgldoc', 'prd_deskripsipanjang', 'mstd_unit', 'mstd_frac', 'mstd_qty')
                ->join('TBMASTER_PRODMAST', 'MSTD_PRDCD', '=', 'PRD_PRDCD')
                ->where('MSTD_NOFAKTUR', '=', $noFaktur)
                ->where('MSTD_KODEIGR', '=', $kodeigr)
                ->get();

        // $plus = '';
        // for ($i=0; $i < sizeof($plu_datas) ; $i++) {
        //     if ($i == sizeof($plu_datas)-1) {
        //         $plus .= $plu_datas[$i]->mstd_prdcd;
        //     } else {
        //         $plus .= $plu_datas[$i]->mstd_prdcd . ',';
        //     }
        // }
        // $data_master_barcode = DB::connection(Session::get('connection'))->table('TBMASTER_PLUNONBARCODE')
        //                         ->whereIn('PNB_PLUMCG', $plus)
        //                         ->get();

        // $data_master_klaim_barcode = DB::connection(Session::get('connection'))->table('TBMASTER_CLAIMPLUNONBARCODE')
        //                         ->whereIn('CNB_PLUMCG', $plus)
        //                         ->get();

        // $existsInMasterBarcode = [];
        // $notExistsInMasterKlaim = [];
        // $existsInMasterKlaim = [];
        // foreach ($data as $data) {
        //     $data_master_barcode = DB::connection(Session::get('connection'))->table('TBMASTER_PLUNONBARCODE')
        //                         ->where('PNB_PLUMCG', '=', $data->mstd_prdcd)
        //                         ->first();
        //     $data_master_klaim_barcode = DB::connection(Session::get('connection'))->table('TBMASTER_CLAIMPLUNONBARCODE')
        //                                     ->where('CNB_PLUMCG', '=', $data->mstd_prdcd)
        //                                     ->first();
            
        //     switch ($data->mstd_unit) {
        //         case 'CTN':                    
        //             $qty = intval($data->mstd_qty / $data->mstd_frac);
        //             $totalPriceBarcode = ($qty * $this->priceCtnBarcode);
        //             break;
        //         case 'BOX':                   
        //             $qty = intval($data->mstd_qty / $data->mstd_frac);
        //             $totalPriceBarcode = 0;
        //             break;
        //         case 'PCS':                   
        //             $qty = $data->mstd_qty;
        //             $totalPriceBarcode = ($qty * $this->pricePcsBarcode);
        //             break;
        //         default:
        //             $qty = $data->mstd_qty;
        //             $totalPriceBarcode = 0;
        //             break;
        //     }
            
        //     if (isset($data_master_barcode)) {
        //         $obj = (object)'';

        //         $obj->mstd_prdcd = $data->mstd_prdcd;
        //         $obj->prd_deskripsipanjang = $data->prd_deskripsipanjang;
        //         $obj->mstd_unit = $data->mstd_unit;
        //         $obj->mstd_frac = $data->mstd_frac;
        //         $obj->mstd_qty = $qty;
        //         $obj->mstd_nofaktur = $data->mstd_nofaktur;
        //         $obj->mstd_tgldoc = $data->mstd_tgldoc;
        //         $obj->keterangan = 'TERDAPAT DI MASTER BARCODE';                

        //         array_push($existsInMasterBarcode, $obj);
        //     } else {
        //         if (isset($data_master_klaim_barcode)) {
        //             $obj = (object)'';

        //             $obj->mstd_prdcd = $data->mstd_prdcd;
        //             $obj->prd_deskripsipanjang = $data->prd_deskripsipanjang;
        //             $obj->mstd_unit = $data->mstd_unit;
        //             $obj->mstd_frac = $data->mstd_frac;
        //             $obj->mstd_qty = $qty;
        //             $obj->mstd_nofaktur = $data->mstd_nofaktur;
        //             $obj->mstd_tgldoc = $data->mstd_tgldoc;
        //             $obj->keterangan = 'TERDAPAT DI MASTER KLAIM BARCODE';

        //             array_push($existsInMasterKlaim, $obj);
        //         } else {
        //             $obj = (object)'';                

        //             $obj->mstd_prdcd = $data->mstd_prdcd;
        //             $obj->prd_deskripsipanjang = $data->prd_deskripsipanjang;
        //             $obj->mstd_unit = $data->mstd_unit;
        //             $obj->mstd_frac = $data->mstd_frac;
        //             $obj->mstd_qty = $qty;
        //             $obj->mstd_nofaktur = $data->mstd_nofaktur;
        //             $obj->mstd_tgldoc = $data->mstd_tgldoc;
        //             $obj->keterangan = 'TIDAK ADA DI MASTER KLAIM BARCODE';

        //             array_push($notExistsInMasterKlaim, $obj);
        //         }
        //     }
        // }


        // if (isset($data)) {
        //     return response()->json([
        //         'status' => 'SUCCESS',
        //         'message' => 'No Faktur found',
        //         'data' => [
        //             'plu_datas' => $data,
        //             'existsInMasterBarcode' => $existsInMasterBarcode,
        //             'existsInMasterKlaim' => $existsInMasterKlaim,
        //             'notExistsInMasterKlaim' => $notExistsInMasterKlaim
        //         ]
        //     ]);
        // } else {
        //     return response()->json([
        //         'status' => 'FAILED',
        //         'message' => 'No Faktur not found'
        //     ]);
        // }
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

    // public function checkPluBarcode(Request $request) {
    //     $data = $request->data;
    //     $plu = $data['prd_plumcg'];
    //     // $plu = $request->plu;

    //     // $data_master_barcode = DB::connection(Session::get('connection'))->table('TBMASTER_PLUNONBARCODE')
    //     //                         ->whereIn('PNB_PLUMCG', $plus)
    //     //                         ->get();

    //     // $data_master_klaim_barcode = DB::connection(Session::get('connection'))->table('TBMASTER_CLAIMPLUNONBARCODE')
    //     //                         ->whereIn('CNB_PLUMCG', $plus)
    //     //                         ->get();

    //     $data_master_barcode = DB::connection(Session::get('connection'))->table('TBMASTER_PLUNONBARCODE')
    //                             ->where('PNB_PLUMCG', '=', $plu)
    //                             ->first();
    //     $data_master_klaim_barcode = DB::connection(Session::get('connection'))->table('TBMASTER_CLAIMPLUNONBARCODE')
    //                                     ->where('CNB_PLUMCG', '=', $plu)
    //                                     ->first();

    //     if (isset($data_master_barcode)) {
    //         $keterangan = 'TERDAPAT DI MASTER BARCODE';
    //         $status = 'INFO MASTER';
    //         $message = 'Data PLU ' . $plu . ' sudah ada di Master Barcode';
    //     } else {
    //         if (isset($data_master_klaim_barcode)) {
    //             $keterangan = 'TERDAPAT DI MASTER KLAIM BARCODE';
    //             $status = 'SUCCESS';
    //             $message = 'Data PLU ' . $plu . ' sudah ada di Master Klaim Barcode';
    //         } else {
    //             $keterangan = 'TIDAK ADA DI MASTER KLAIM BARCODE';
    //             $status = 'INFO KLAIM';
    //             $message = 'Data PLU ' . $plu . ' tidak ada di Master Klaim Barcode';
    //         }
    //     }

    //     // $priceCtnBarcode = DB::connection(Session::get('connection'))->table('TBMASTER_BARCODE_PRICE')
    //     //                     ->where('B_UNIT', '=', 'CTN')
    //     //                     ->first();
    //     // $pricePcsBarcode = DB::connection(Session::get('connection'))->table('TBMASTER_BARCODE_PRICE')
    //     //                     ->where('B_UNIT', '=', 'PCS')
    //     //                     ->first();
    //     // dd($priceCtnBarcode, $pricePcsBarcode);
    //     switch ($data['mstd_unit']) {
    //         case 'CTN':
    //             $mstd_ctn = intval($data['mstd_qty'] / $data['mstd_frac']);
    //             $mstd_box = 0;
    //             $mstd_pcs = ($data['mstd_qty'] % $data['mstd_frac']);
    //             $totalPriceBarcode = ($mstd_ctn * $this->priceCtnBarcode) + ($mstd_ctn * $mstd_pcs * $this->pricePcsBarcode);
    //             break;
    //         case 'BOX':
    //             $mstd_ctn = 0;
    //             $mstd_box = intval($data['mstd_qty'] / $data['mstd_frac']);
    //             $mstd_pcs = ($data['mstd_qty'] % $data['mstd_frac']);
    //             $totalPriceBarcode = 0;
    //             break;
    //         case 'PCS':
    //             $mstd_ctn = 0;
    //             $mstd_box = 0;
    //             $mstd_pcs = $data['mstd_qty'];
    //             $totalPriceBarcode = ($mstd_pcs * $this->pricePcsBarcode);
    //             break;
    //         default:
    //             $mstd_ctn = 0;
    //             $mstd_box = 0;
    //             $mstd_pcs = ($data['mstd_qty'] / $data['mstd_frac']);
    //             $totalPriceBarcode = 0;
    //             break;
    //     }

    //     $datas = [
    //         'prd_plumcg' => $data['prd_plumcg'],
    //         'prd_deskripsipanjang' => $data['prd_deskripsipanjang'],
    //         'mstd_unit' => $data['mstd_unit'],
    //         'mstd_frac' => $data['mstd_frac'],
    //         'mstd_ctn' => $mstd_ctn,
    //         'mstd_box' => $mstd_box,
    //         'mstd_qty' => $mstd_pcs,
    //         'mstd_totalpricebarcode' => $totalPriceBarcode,
    //         'mstd_nofaktur' => $data['mstd_nofaktur'],
    //         'mstd_tgldoc' => $data['mstd_tgldoc'],
    //         'keterangan' => $keterangan
    //     ];

    //     return response()->json([
    //         'status' => $status,
    //         'message' => $message,
    //         'data' => $datas
    //     ]);
    // }
    public function checkPluBarcode(Request $request) {
        $data = $request->data;        
        // $plu = substr($data['mstd_prdcd'], -1);
        $prd_plumcg = $data['prd_plumcg'];       

        $data_master_barcode = DB::connection(Session::get('connection'))->table('TBMASTER_PLUNONBARCODE')                                
                                ->where('PNB_PLUMCG', '=', $prd_plumcg)                                
                                ->first();
                                // dd($data_master_barcode);
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

                $data_master_prodmast =  DB::connection(Session::get('connection'))->table('TBMASTER_PRODMAST')                                        
                                        ->where('PRD_PLUMCG', '=', $prd_plumcg)                                        
                                        ->get();
                $data_print = [];
                for ($i=0; $i < sizeof($data_master_prodmast); $i++) {                     
                    if (substr($data_master_prodmast[$i]->prd_prdcd, -1) == '0') {
                        $d = (object)'';
                        $d->nofaktur =  $data['mstd_nofaktur'];
                        $d->prd_plumcg = $data_master_prodmast[$i]->prd_plumcg;
                        $d->prd_prdcd = $data_master_prodmast[$i]->prd_prdcd;                            
                        $d->prd_deskripsipanjang = $data_master_prodmast[$i]->prd_deskripsipanjang;
                        $d->prd_unit = $data_master_prodmast[$i]->prd_unit;
                        $d->prd_frac = $data_master_prodmast[$i]->prd_frac;
                        $d->qty = $data['mstd_qty'] / $data_master_prodmast[$i]->prd_frac;
                        $d->total_price_barcode = $d->qty * $this->priceCtnBarcode;

                        array_push($data_print, $d);
                    }

                    if (substr($data_master_prodmast[$i]->prd_prdcd, -1) == '1') {
                        $d = (object)'';
                        $d->nofaktur =  $data['mstd_nofaktur'];
                        $d->prd_plumcg = $data_master_prodmast[$i]->prd_plumcg;
                        $d->prd_prdcd = $data_master_prodmast[$i]->prd_prdcd;                            
                        $d->prd_deskripsipanjang = $data_master_prodmast[$i]->prd_deskripsipanjang;
                        $d->prd_unit = $data_master_prodmast[$i]->prd_unit;
                        $d->prd_frac = $data_master_prodmast[$i]->prd_frac;
                        $d->qty = $data['mstd_qty'];
                        $d->total_price_barcode = $d->qty * $this->pricePcsBarcode;

                        array_push($data_print, $d);
                    }
                }
            } else {
                $keterangan = 'TIDAK ADA DI MASTER KLAIM BARCODE';
                $status = 'INFO KLAIM';
                $message = 'Data PLUMCG ' . $prd_plumcg . ' tidak ada di Master Klaim Barcode';
            }
        }

        $datas = [
            'prd_plumcg' => $data['prd_plumcg'],
            'mstd_prdcd' => $data['mstd_prdcd'],
            'prd_deskripsipanjang' => $data['prd_deskripsipanjang'],
            'mstd_unit' => $data['mstd_unit'],
            'mstd_frac' => $data['mstd_frac'],
            // 'mstd_ctn' => $mstd_ctn,
            // 'mstd_box' => $mstd_box,
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

        $receiver = 'cesartputra@indomaret.co.id';
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
                <link href="https://svc.webspellchecker.net/spellcheck31/lf/scayt3/ckscayt/css/wsc.css" rel="stylesheet" type="text/css" />
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
        // if (isset($notExistsInMasterKlaim)) {
        try {
            Mail::to($receiver)->send(new Email($demo));

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

        // }
    }

    public function printBarcode(Request $request) {
        $kodeigr = Session::get('kdigr');
        $plus = $request->plus;
        $noFaktur = $request->noFaktur;
        $arrPlus = explode(',', $plus);

        $perusahaan = DB::connection(Session::get('connection'))->table('tbmaster_perusahaan')
            ->select('prs_namaperusahaan', 'prs_namacabang')
            ->first();

        // $data = DB::connection(Session::get('connection'))->table('TBTR_MSTRAN_D')
        //         ->select('prd_plumcg', 'mstd_prdcd', 'mstd_nofaktur', 'mstd_tgldoc', 'prd_deskripsipanjang', 'mstd_unit', 'mstd_frac', 'mstd_qty')
        //         ->join('TBMASTER_PRODMAST', 'MSTD_PRDCD', '=', 'PRD_PRDCD')
        //         ->where('MSTD_NOFAKTUR', '=', $noFaktur)
        //         ->where('MSTD_KODEIGR', '=', $kodeigr)
        //         ->whereIn('mstd_prdcd', $arrPlus)
        //         ->get();
        $data_master = DB::connection(Session::get('connection'))->table('TBMASTER_PRODMAST')                                
                ->whereIn('prd_plumcg', $arrPlus)
                ->get();

        $temp_plumcg = '';
        $data = [];

        for ($i=0; $i < sizeof($data_master); $i++) { 
            if($data_master[$i]->prd_plumcg != $temp_plumcg){
                $temp_plumcg = $data_master[$i]->prd_plumcg;
            }

            if($data_master[$i]->prd_unit == 'CTN' || $data_master[$i]->prd_unit == 'PCS'){
                $d = (object)'';
                
            }
        }
        
        // foreach ($data as $d) {            
        //     switch ($data['mstd_unit']) {
        //         case 'CTN':
        //             $mstd_ctn = intval($data['mstd_qty'] / $data['mstd_frac']);
        //             $mstd_box = 0;
        //             $mstd_pcs = ($data['mstd_qty'] % $data['mstd_frac']);
        //             // $totalPriceBarcode = ($mstd_ctn * $this->priceCtnBarcode) + ($mstd_ctn * $mstd_pcs * $this->pricePcsBarcode);
        //             break;
        //         case 'BOX':
        //             $mstd_ctn = 0;
        //             $mstd_box = intval($data['mstd_qty'] / $data['mstd_frac']);
        //             $mstd_pcs = ($data['mstd_qty'] % $data['mstd_frac']);
        //             // $totalPriceBarcode = ($mstd_ctn * $this->priceCtnBarcode) + ($mstd_ctn * $mstd_pcs * $this->pricePcsBarcode);
        //             break;
        //         case 'PCS':
        //             $mstd_ctn = 0;
        //             $mstd_box = 0;
        //             $mstd_pcs = $data['mstd_qty'];
        //             // $totalPriceBarcode = ($mstd_pcs * $this->pricePcsBarcode);
        //             break;
        //     }
        // }
        
        return view('BACKOFFICE.TRANSAKSI.PENERIMAAN.barcode-putih-pdf', compact('data', 'perusahaan'));
    }

    public function saveBarcodePrint(Request $request) {
        $kodeigr = Session::get('kdigr');
        $data = $request->data;        
        
        $data_barcode_putih = DB::connection(Session::get('connection'))->table('TBTR_BARCODE_PUTIH')
                                ->where('BP_KODEIGR', '=', $kodeigr)
                                ->where('BP_NOFAKTUR', '=', $data[0]['nofaktur'])
                                ->get();
                                // dd($data_barcode_putih);
        if (sizeof($data_barcode_putih) > 0) {
            return response()->json([
                'status' => 'FAILED',
                'message' => 'Data Barcode Putih No Faktur '. $data[0]['nofaktur'] .' Sudah ada'
            ]);
        } else {
            foreach ($data as $d) {            

                DB::connection(Session::get('connection'))->table('TBTR_BARCODE_PUTIH')->insert([
                    'BP_KODEIGR' => $kodeigr,                                   
                    'BP_NOFAKTUR' => $d['nofaktur'],
                    'BP_PLUMCG' => $d['prd_plumcg'],
                    'BP_PRDCD' => $d['prd_prdcd'],
                    'BP_UNIT' => $d['prd_unit'],
                    'BP_UNIT_QTY' => $d['qty'],
                    'BP_TOTALPRICE' => $d['total_price_barcode']
                ]);
            }

            return response()->json([
                'status' => 'SUCCESS',
                'message' => 'Data Barcode Putih No Faktur '. $data[0]['nofaktur'] .' Berhasil Disimpan'
            ]);
        }                
    }
}


