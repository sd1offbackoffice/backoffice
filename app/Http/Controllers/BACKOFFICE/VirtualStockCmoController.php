<?php
/**
 * Created by Visual Studio Code.
 * User: Steven Leo Candra
 * Date: 13/02/2022
 * Time: 18:46 PM
 */

namespace App\Http\Controllers\BACKOFFICE;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use PDF;
use Yajra\DataTables\DataTables;

class VirtualStockCmoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('BACKOFFICE.virtual_stock_cmo');
    }

    
    public function GetDiv(Request $request){

        $datas = DB::connection(Session::get('connection'))->table('tbmaster_divisi')
            ->selectRaw('distinct div_kodedivisi as div_kodedivisi')
            ->selectRaw('div_namadivisi')
            ->selectRaw('div_singkatannamadivisi')
            ->orderBy('div_kodedivisi')
            ->get();

        return response()->json($datas);
    }

    public function GetDept(Request $request){
        $div1 = $request->div1;
        $div2 = $request->div2;

        $datas = DB::connection(Session::get('connection'))->table('tbmaster_departement')
            ->selectRaw('distinct dep_kodedepartement as dep_kodedepartement')
            ->selectRaw('dep_namadepartement')
            ->selectRaw('dep_kodedivisi')
            ->selectRaw('dep_singkatandepartement')
            ->whereRaw("dep_kodedivisi between '$div1' and '$div2'")
            ->orderBy('dep_kodedepartement')
            ->orderBy('dep_kodedivisi')
            ->get();

        return response()->json($datas);
    }

    public function GetKat(Request $request){
        $dept1 = $request->dept1;
        $dept2 = $request->dept2;

        $datas = DB::connection(Session::get('connection'))->table('tbmaster_kategori')
            ->selectRaw('distinct kat_kodekategori as kat_kodekategori')
            ->selectRaw('kat_namakategori')
            ->selectRaw('kat_kodedepartement')
            ->selectRaw('kat_singkatan')
            ->whereRaw("kat_kodedepartement between '$dept1' and '$dept2'")
            ->orderBy('kat_kodekategori')
            ->orderBy('kat_kodedepartement')
            ->get();

        return response()->json($datas);
    }

    public function getSupplier()
    {
        $datas = DB::connection(Session::get('connection'))->table('tbmaster_supplier')
            ->selectRaw("sup_kodesupplier,sup_kodesuppliermcg,sup_namasupplier")
            ->orderBy('sup_kodesupplier')
            ->limit(100)
            ->get();

        return Datatables::of($datas)->make(true);
    }

    public function getDataSupplier(Request $request)
    {
        $value = $request->kodesupplier;

        $datas = DB::connection(Session::get('connection'))->table('tbmaster_supplier')
            ->selectRaw("sup_kodesupplier,sup_kodesuppliermcg,sup_namasupplier")
            ->orderBy('sup_kodesupplier')
            ->limit(100)
            ->get();

        return compact(['datas']);
    }


    public function getSupp(Request $request)
    {
        $search = $request->search;
        $datas = DB::connection(Session::get('connection'))->table('tbmaster_supplier')
            ->selectRaw("sup_kodesupplier,sup_kodesuppliermcg,sup_namasupplier")
            ->whereRaw("sup_kodesupplier LIKE '%" . $search . "%' or sup_namasupplier LIKE '%" . $search . "%'")
            ->orderBy('sup_kodesupplier')
            ->limit(100)
            ->get();

        return response()->json($datas);
    }

    public function printPDF(Request $request)
    {
        
        $tipevcmo = $request->tipevcmo;
        $div1 = $request->div1;
        $div2 = $request->div2;
        $dept1 = $request->dept1;
        $dept2 = $request->dept2;
        $kat1 = $request->kat1;
        $kat2 = $request->kat2;
        $kodesupplier = $request->kodesupplier;
        $kodemcg = $request->kodemcg;
        $namasupplier = $request->namasupplier;
        $periode1 = $request->periode1;
        $periode2 = $request->periode2;

        $and_div = '';
        $and_dept = '';
        $and_kat = '';
        $and_ksupp = '';
        $and_ksuppmcg = '';
        $and_namasupp = '';
        
        if (isset($div1) && isset($div2)) {
            $and_div = " and prd_kodedivisi between '" . $div1 . "' and '" . $div2 . "'";
        }
        if (isset($dept1) && isset($dept2)) {
            $and_dept = " and prd_kodedepartement between '" . $dept1 . "' and '" . $dept2 . "'";
        }
        if (isset($kat1) && isset($kat1)) {
            $and_kat = " and prd_kodekategoribarang between '" . $kat1 . "' and '" . $kat2 . "'";
        }
        if (isset($kodesupplier) && isset($kodemcg) && isset($namasupplier)) {
            $and_ksupp = " and sup_kodesupplier like '" . $kodesupplier . "' ";
            $and_ksuppmcg = " and sup_kodesuppliermcg like '" . $kodemcg . "' ";
            $and_namasupp = " and sup_namasupplier like '" . $namasupplier . "' ";
        }
        
        // rekap 
        if($tipevcmo == 'r1')
        {
            $data = DB::connection(Session::get('connection'))
            ->select("SELECT prs_namaperusahaan,
                            prs_namacabang,
                            lpp.*,
                            sta_saldoawal,
                            sta_saldoakhir,
                            prc_pluidm,
                            prd_deskripsipanjang,
                            supp || ' - ' || nvl(sup_kodesuppliermcg, '') kodesupp
                        FROM ( SELECT '".$kodesupplier. "' supp, pluigr,
                                        SUM (NVL (bpb_qty, 0)) bpb_qty,
                                        SUM (NVL (idm_qty, 0)) idm_qty,
                                        SUM (NVL (mpp_qty, 0)) mpp_qty,
                                        SUM (NVL (dspb_qty, 0)) dspb_qty,
                                        SUM (NVL (mpn_qty, 0)) mpn_qty,
                                        SUM (NVL (intp_qty, 0)) intp_qty,
                                        SUM (NVL (intn_qty, 0)) intn_qty
                                FROM temp_lpp_cmo
                                GROUP BY pluigr) lpp,
                                        tbmaster_stock_cab_anak,
                                        tbmaster_prodcrm,
                                        tbmaster_prodmast,
                                        tbmaster_perusahaan,
                                        tbmaster_supplier
                                WHERE sta_prdcd = pluigr
                                AND sta_lokasi = '01'
                                AND prc_pluigr = pluigr
                                AND prc_group = 'I'
                                AND prd_prdcd = pluigr
                                AND sup_kodesupplier(+) = supp
                                " . $and_div . "
                                " . $and_dept . "
                                " . $and_kat . "
                                " . $and_ksupp . "
                                " . $and_ksuppmcg . "
                                " . $and_namasupp . "
                                ORDER BY pluigr, prd_kodedivisi, prd_kodedepartement, prd_kodekategoribarang");

            $perusahaan = DB::connection(Session::get('connection'))->table('tbmaster_perusahaan')->first();
            
            return view('BACKOFFICE.virtual-stock-cmo-pdf-2',
            ['data' => $data, 'perusahaan' => $perusahaan, 'tipevcmo' => $tipevcmo, 'div1' => $div1, 
            'div2' => $div2, 'dept1' => $dept1, 'dept2' => $dept2, 'kat1' => $kat1, 'kat2' => $kat2, 
            'kodesupplier' => $kodesupplier,'kodemcg' => $kodemcg,'namasupplier' => $namasupplier, 
            'periode1' => $periode1, 'periode2' => $periode2]);
        
            $pdf = PDF::loadview('BACKOFFICE.virtual-stock-cmo-pdf-2',
            ['data' => $data, 'perusahaan' => $perusahaan, 'tipevcmo' => $tipevcmo, 'div1' => $div1, 
            'div2' => $div2, 'dept1' => $dept1, 'dept2' => $dept2, 'kat1' => $kat1, 'kat2' => $kat2, 
            'kodesupplier' => $kodesupplier,'kodemcg' => $kodemcg,'namasupplier' => $namasupplier, 
            'periode1' => $periode1, 'periode2' => $periode2]);
            $pdf->setPaper('A4', 'potrait');
            $pdf->output();
            $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);

            $canvas = $dompdf->get_canvas();
            $canvas->page_text(1450, 800, "{PAGE_NUM} / {PAGE_COUNT}", null, 7, array(0, 0, 0));

            return $pdf->stream('virtual-stock-cmo-pdf-2.pdf');

        }
        else if($tipevcmo == 'r2')
        {
            $data = DB::connection(Session::get('connection'))
            ->select("SELECT prs_namaperusahaan,
                            prs_namacabang,
                            lpp.*,
                            prc_pluidm,
                            prd_deskripsipanjang,
                            sup_kodesuppliermcg || '-' || sup_namasupplier AS sup_namasupplier,
                            idm_toko || '-' || idm.tko_namaomi AS namaidm,
                            dspb_toko || '-' || dspb.tko_namaomi AS namadspb
                    FROM temp_lpp_cmo lpp,
                            tbmaster_prodcrm,
                            tbmaster_prodmast,
                            tbmaster_supplier,
                            tbmaster_tokoigr idm,
                            tbmaster_tokoigr dspb,
                            tbmaster_perusahaan
                    WHERE prc_pluigr = pluigr
                    AND prc_group = 'I'
                    AND prd_prdcd = pluigr
                    AND sup_kodesupplier(+) = bpb_supp
                    AND idm.tko_kodeomi(+) = idm_toko
                    AND dspb.tko_kodeomi(+) = dspb_toko
                    " . $and_div . "
                    " . $and_dept . "
                    " . $and_kat . "
                    " . $and_ksupp . "
                    " . $and_ksuppmcg . "
                    " . $and_namasupp . "
                    ORDER BY pluigr, row_id, prd_kodedivisi, prd_kodedepartement, prd_kodekategoribarang ");
            
   
            $perusahaan = DB::connection(Session::get('connection'))->table('tbmaster_perusahaan')->first();

            return view('BACKOFFICE.virtual-stock-cmo-pdf-2',
            ['data' => $data, 'perusahaan' => $perusahaan, 'tipevcmo' => $tipevcmo, 'div1' => $div1, 'div2' => $div2, 
            'dept1' => $dept1, 'dept2' => $dept2, 'kat1' => $kat1, 'kat2' => $kat2, 'kodesupplier' => $kodesupplier,
            'kodemcg' => $kodemcg,'namasupplier' => $namasupplier, 'periode1' => $periode1, 'periode2' => $periode2]);
            
            $pdf = PDF::loadview('BACKOFFICE.virtual-stock-cmo-pdf-2',
            ['data' => $data, 'perusahaan' => $perusahaan, 'tipevcmo' => $tipevcmo, 'div1' => $div1, 'div2' => $div2, 
            'dept1' => $dept1, 'dept2' => $dept2, 'kat1' => $kat1, 'kat2' => $kat2, 'kodesupplier' => $kodesupplier,
            'kodemcg' => $kodemcg,'namasupplier' => $namasupplier, 'periode1' => $periode1, 'periode2' => $periode2]);
            $pdf->setPaper('A4', 'potrait');
            $pdf->output();
            $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);

            $canvas = $dompdf->get_canvas();
            $canvas->page_text(1450, 800, "{PAGE_NUM} / {PAGE_COUNT}", null, 7, array(0, 0, 0));

            return $pdf->stream('virtual-stock-cmo-pdf-2.pdf');
        }

    }

    public function printCSV(Request $request)
    {
        
        $tipevcmo = $request->tipevcmo;
        $div1 = $request->div1;
        $div2 = $request->div2;
        $dept1 = $request->dept1;
        $dept2 = $request->dept2;
        $kat1 = $request->kat1;
        $kat2 = $request->kat2;
        $kodesupplier = $request->kodesupplier;
        $kodemcg = $request->kodemcg;
        $namasupplier = $request->namasupplier;
        $periode1 = $request->periode1;
        $periode2 = $request->periode2;

        $and_div = '';
        $and_dept = '';
        $and_kat = '';
        $and_ksupp = '';
        $and_ksuppmcg = '';
        $and_namasupp = '';

        if (isset($div1) && isset($div2)) {
            $and_div = " and prd_kodedivisi between '" . $div1 . "' and '" . $div2 . "'";
        }
        if (isset($dept1) && isset($dept2)) {
            $and_dept = " and prd_kodedepartement between '" . $dept1 . "' and '" . $dept2 . "'";
        }
        if (isset($kat1) && isset($kat1)) {
            $and_kat = " and prd_kodekategoribarang between '" . $kat1 . "' and '" . $kat2 . "'";
        }
        if (isset($kodesupplier) && isset($kodemcg) && isset($namasupplier)) {
            $and_ksupp = " and sup_kodesupplier like '" . $kodesupplier . "' ";
            $and_ksuppmcg = " and sup_kodesuppliermcg like '" . $kodemcg . "' ";
            $and_namasupp = " and sup_namasupplier like '" . $namasupplier . "' ";
        }
        
    
        if($tipevcmo == 'r1')
        {
            $data = DB::connection(Session::get('connection'))
            ->select("SELECT prs_namaperusahaan,
                            prs_namacabang,
                            lpp.*,
                            sta_saldoawal,
                            sta_saldoakhir,
                            prc_pluidm,
                            prd_deskripsipanjang,
                            supp || ' - ' || nvl(sup_kodesuppliermcg, '') kodesupp
                        FROM ( SELECT '".$kodesupplier. "' supp, pluigr,
                                        SUM (NVL (bpb_qty, 0)) bpb_qty,
                                        SUM (NVL (idm_qty, 0)) idm_qty,
                                        SUM (NVL (mpp_qty, 0)) mpp_qty,
                                        SUM (NVL (dspb_qty, 0)) dspb_qty,
                                        SUM (NVL (mpn_qty, 0)) mpn_qty,
                                        SUM (NVL (intp_qty, 0)) intp_qty,
                                        SUM (NVL (intn_qty, 0)) intn_qty
                                FROM temp_lpp_cmo
                                GROUP BY pluigr) lpp,
                                        tbmaster_stock_cab_anak,
                                        tbmaster_prodcrm,
                                        tbmaster_prodmast,
                                        tbmaster_perusahaan,
                                        tbmaster_supplier
                                WHERE sta_prdcd = pluigr
                                AND sta_lokasi = '01'
                                AND prc_pluigr = pluigr
                                AND prc_group = 'I'
                                AND prd_prdcd = pluigr
                                AND sup_kodesupplier(+) = supp
                                " . $and_div . "
                                " . $and_dept . "
                                " . $and_kat . "
                                " . $and_ksupp . "
                                " . $and_ksuppmcg . "
                                " . $and_namasupp . "
                                ORDER BY pluigr, prd_kodedivisi, prd_kodedepartement, prd_kodekategoribarang");

            $perusahaan = DB::connection(Session::get('connection'))->table('tbmaster_perusahaan')->first();

            $today = Carbon::now()->format('Ymd');
            $filename = 'LPPCMO_RKP_'.$today.'.csv';
            // $filename = 'laporan-virtual-stock-cmo-rekap.csv';
            // $columnHeader = [
            //     'NO',
            //     'PLU IDM',
            //     'PLU IGR',
            //     'SALDO AWAL',
            //     'BPB',
            //     'BPBR',
            //     'MPP (+)',
            //     'ADJ (+)',
            //     'DSPB',
            //     'MPP (-)',
            //     'ADJ (-)',
            //     'SALDO AKHIR',
            // ];
            $columnHeader = [
                'PLUIDM',
                'PLUIGR',
                'DESKRIPSI',
                'SALDO AWAL',
                'BPB_QTY',
                'BPBR_QTY',
                'MPP_QTY',
                'ADJP_QTY',
                'DSPB_QTY',
                'MPN_QTY',
                'ADJM_QTY',
                'SALDO AKHIR',
            ];

            $i =1;

            $linebuffs = array();
            foreach ($data as $d) {
                $tempdata = [
                    $d->prc_pluidm, 
                    $d->pluigr,
                    $d->prd_deskripsipanjang,
                    $d->sta_saldoawal,
                    $d->bpb_qty,
                    $d->idm_qty,
                    $d->mpp_qty,
                    $d->intp_qty,
                    $d->dspb_qty,
                    $d->mpn_qty,
                    $d->intn_qty,
                    $d->sta_saldoakhir,
                ];
                array_push($linebuffs, $tempdata);
            }

            $headers = [
                "Content-type" => "text/csv",
                "Pragma" => "no-cache",
                "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
                "Expires" => "0"
            ];
            $file = fopen(storage_path($filename), 'w');

            fputcsv($file, $columnHeader, '|');
            foreach ($linebuffs as $linebuff) {
                fputcsv($file, $linebuff, '|');
            }
            fclose($file);

            return response()->download(storage_path($filename))->deleteFileAfterSend(true);
        }
        else if($tipevcmo == 'r2')
        {
            $data = DB::connection(Session::get('connection'))
            ->select("SELECT prs_namaperusahaan,
                            prs_namacabang,
                            lpp.*,
                            prc_pluidm,
                            prd_deskripsipanjang,
                            sup_kodesuppliermcg || '-' || sup_namasupplier AS sup_namasupplier,
                            sup_kodesuppliermcg,
                            sup_kodesupplier,
                            idm_toko || '-' || idm.tko_namaomi AS namaidm,
                            dspb_toko || '-' || dspb.tko_namaomi AS namadspb
                    FROM temp_lpp_cmo lpp,
                            tbmaster_prodcrm,
                            tbmaster_prodmast,
                            tbmaster_supplier,
                            tbmaster_tokoigr idm,
                            tbmaster_tokoigr dspb,
                            tbmaster_perusahaan
                    WHERE prc_pluigr = pluigr
                    AND prc_group = 'I'
                    AND prd_prdcd = pluigr
                    AND sup_kodesupplier(+) = bpb_supp
                    AND idm.tko_kodeomi(+) = idm_toko
                    AND dspb.tko_kodeomi(+) = dspb_toko
                    " . $and_div . "
                    " . $and_dept . "
                    " . $and_kat . "
                    " . $and_ksupp . "
                    " . $and_ksuppmcg . "
                    " . $and_namasupp . "
                    ORDER BY pluigr, row_id ");
            
            // dd($data);
   
            $perusahaan = DB::connection(Session::get('connection'))->table('tbmaster_perusahaan')->first();

            $today = Carbon::now()->format('Ymd');
            $filename = 'LPPCMO_DET_'.$today.'.csv';
            // $filename = 'laporan-virtual-stock-cmo-detail.csv';
            $columnHeader = [
                'PLUIDM',
                'PLUIGR',
                'DESKRIPSI',
                'SALDO_AWAL',

                'KODE_SUPP',
                'SUPP_MCG',
                'NAMA_SUPP',

                'BPB_NOPO',
                'BPB_TANGGAL',
                'BPB_NO',
                'BPB_QTY', // TYPO BTB QTY DI EXCEL

                'BPBR_TOKO',
                'BPBR_NAMATOKO',
                'BPBR_TANGGAL',
                'BPBR_NO',
                'BPBR_NRB',
                'BPBR_QTY',

                'MPP_NO',
                'MPP_TANGGAL',
                'MPP_QTY',

                'ADJP_NO',
                'ADJP_TANGGAL',
                'ADJP_QTY',

                'DSPB_TOKO',
                'DSPB_NAMA',
                'DSPB_NO',
                'DSPB_TANGGAL',
                'DSPB_QTY',
                
                'MPN_NO',
                'MPN_TANGGAL',
                'MPN_QTY',
                
                'ADJM_NO',
                'ADJM_TANGGAL',
                'ADJM_QTY',
                
                'SALDO_AKHIR'
            ];

            $i = 0;

            $linebuffs = array();
            foreach ($data as $d) {
                $tempdata = [
                    $d->prc_pluidm, // PLUIDM
                    $d->pluigr, // PLUIGR
                    $d->prd_deskripsipanjang, // DESKRIPSI 
                    $d->awal, // SALDO AWAL
                    
                    $d->sup_kodesupplier,// KODE SUPP
                    $d->sup_kodesuppliermcg,// SUPP_MCG
                    $d->sup_namasupplier, // NAMA SUPP

                    $d->bpb_nopo, // BPB_NOPO
                    $d->bpb_tanggal, // BPB_TANGGAL
                    $d->bpb_no, // BPB_NO
                    $d->bpb_qty, // BPB_QTY
                    
                    $d->idm_toko,// BPBR_TOKO
                    $d->namaidm, // BPBR_NAMATOKO
                    $d->idm_tanggal, // BPBR_TANGGAL
                    $d->idm_no, // BPBR_NO
                    $d->idm_nrb, // BPBR_NRB
                    $d->idm_qty,  // BPBR_QTY

                    $d->mpp_no, // MPP_NO
                    $d->mpp_tanggal, // MPP_TANGGAL
                    $d->mpp_qty, // MPP_QTY

                    $d->intp_no,  // 'ADJP_NO',
                    $d->intp_tanggal, // ADJP_TANGGAL
                    $d->intp_qty, // ADJP_QTY

                    $d->dspb_toko,// DSPB_TOKO
                    $d->namadspb, // DSPB_NAMA
                    $d->dspb_no, // DSPB_NO
                    $d->dspb_tanggal, // DSPB_TANGGAL
                    $d->dspb_qty, // DSPB_QTY

                    $d->mpn_no,   // MPN_NO
                    $d->mpn_tanggal, // MPN_TANGGAL
                    $d->mpn_qty, // MPN_QTY

                    $d->intn_no,  // ADJM_NO
                    $d->intn_tanggal, // ADJM_TANGGAL
                    $d->intn_qty, // ADJM_QTY


                    $d->akhir, // SALDO_AKHIR
                ];
                array_push($linebuffs, $tempdata);
            }

            // $columnHeader = [
            //     'NO',
            //     'PLU IDM',
            //     'PLU IGR',
            //     'SALDO AWAL',

            //     'KODE - NAMA',
            //     'NO. PO',
            //     'TGL BPB',
            //     'NO. BPB',
            //     'QTY',

            //     'KODE - NAMA',
            //     'TGL BPBR',
            //     'NO. BPBR',
            //     'NO. NBR',
            //     'QTY',

            //     'TGL MPP',
            //     'NO. MPP',
            //     'QTY',

            //     'TGL ADJ',
            //     'NO. BA',
            //     'QTY',

            //     'KODE - NAMA',
            //     'TGL DSPB',
            //     'NO. DSPB',
            //     'QTY',

            //     'TGL. MPP',
            //     'NO. MPP',
            //     'QTY',

            //     'TGL ADJ',
            //     'NO. BA',
            //     'QTY',
            //     'SALDO AKHIR',
            // ];

            // $i = 0;

            // $linebuffs = array();
            // foreach ($data as $d) {
            //     $tempdata = [
            //         $i++,
            //         $d->prc_pluidm, 
            //         $d->pluigr,
            //         $d->awal,

            //         $d->sup_namasupplier,
            //         $d->bpb_nopo,
            //         $d->bpb_tanggal,
            //         $d->bpb_no,
            //         $d->bpb_qty,

            //         $d->namaidm,
            //         $d->idm_tanggal,
            //         $d->idm_no,
            //         $d->idm_nrb,
            //         $d->idm_qty,

            //         $d->mpp_tanggal,
            //         $d->mpp_no,
            //         $d->mpp_qty,

            //         $d->intp_tanggal,
            //         $d->intp_no,
            //         $d->intp_qty,

            //         $d->namadspb,
            //         $d->dspb_tanggal,
            //         $d->dspb_no,
            //         $d->dspb_qty,

            //         $d->mpn_tanggal,
            //         $d->mpn_no,
            //         $d->mpn_qty,

            //         $d->intn_tanggal,
            //         $d->intn_no,
            //         $d->intn_qty,

            //         $d->akhir,
            //     ];
            //     array_push($linebuffs, $tempdata);
            // }

            $headers = [
                "Content-type" => "text/csv",
                "Pragma" => "no-cache",
                "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
                "Expires" => "0"
            ];
            $file = fopen(storage_path($filename), 'w');

            fputcsv($file, $columnHeader, '|');
            foreach ($linebuffs as $linebuff) {
                fputcsv($file, $linebuff, '|');
            }
            fclose($file);

            return response()->download(storage_path($filename))->deleteFileAfterSend(true);
        }

    }

}
