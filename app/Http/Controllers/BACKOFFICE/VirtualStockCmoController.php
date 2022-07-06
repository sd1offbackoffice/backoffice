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

            return view('BACKOFFICE.virtual_stock_cmo-pdf', compact(['perusahaan','tipevcmo','data','div1','div2','dept1','dept2','kat1','kat2','kodesupplier','kodemcg','namasupplier','periode1', 'periode2']));
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

            return view('BACKOFFICE.virtual_stock_cmo-pdf', compact(['perusahaan','tipevcmo','data','div1','div2','dept1','dept2','kat1','kat2','kodesupplier','kodemcg','namasupplier','periode1', 'periode2']));
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

            $filename = 'laporan-virtual-stock-cmo-rekap.csv';
            $columnHeader = [
                'NO',
                'PLU IDM',
                'PLU IGR',
                'SALDO AWAL',
                'BPB',
                'BPBR',
                'MPP (+)',
                'ADJ (+)',
                'DSPB',
                'MPP (-)',
                'ADJ (-)',
                'SALDO AKHIR',
            ];

            $i =1;

            $linebuffs = array();
            foreach ($data as $d) {
                $tempdata = [
                    $i++,
                    $d->prc_pluidm, 
                    $d->pluigr,
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
            
   
            $perusahaan = DB::connection(Session::get('connection'))->table('tbmaster_perusahaan')->first();

            $filename = 'laporan-virtual-stock-cmo-detail.csv';
            $columnHeader = [
                'NO',
                'PLU IDM',
                'PLU IGR',
                'SALDO AWAL',

                'KODE - NAMA',
                'NO. PO',
                'TGL BPB',
                'NO. BPB',
                'QTY',

                'KODE - NAMA',
                'TGL BPBR',
                'NO. BPBR',
                'NO. NBR',
                'QTY',

                'TGL MPP',
                'NO. MPP',
                'QTY',

                'TGL ADJ',
                'NO. BA',
                'QTY',

                'KODE - NAMA',
                'TGL DSPB',
                'NO. DSPB',
                'QTY',

                'TGL. MPP',
                'NO. MPP',
                'QTY',

                'TGL ADJ',
                'NO. BA',
                'QTY',
                'SALDO AKHIR',
            ];

            $i = 0;

            $linebuffs = array();
            foreach ($data as $d) {
                $tempdata = [
                    $i++,
                    $d->prc_pluidm, 
                    $d->pluigr,
                    $d->awal,

                    $d->sup_namasupplier,
                    $d->bpb_nopo,
                    $d->bpb_tanggal,
                    $d->bpb_no,
                    $d->bpb_qty,

                    $d->namaidm,
                    $d->idm_tanggal,
                    $d->idm_no,
                    $d->idm_nrb,
                    $d->idm_qty,

                    $d->mpp_tanggal,
                    $d->mpp_no,
                    $d->mpp_qty,

                    $d->intp_tanggal,
                    $d->intp_no,
                    $d->intp_qty,

                    $d->namadspb,
                    $d->dspb_tanggal,
                    $d->dspb_no,
                    $d->dspb_qty,

                    $d->mpn_tanggal,
                    $d->mpn_no,
                    $d->mpn_qty,

                    $d->intn_tanggal,
                    $d->intn_no,
                    $d->intn_qty,

                    $d->akhir,
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

    }

}
