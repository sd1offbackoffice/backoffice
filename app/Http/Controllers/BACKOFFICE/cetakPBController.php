<?php

namespace App\Http\Controllers\BACKOFFICE;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller; use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use PDF;
use Yajra\DataTables\DataTables;

class cetakPBController extends Controller
{
    public function index(){
        $divisi     = DB::connection(Session::get('connection'))->table('TBMASTER_DIVISI')->select('div_kodedivisi', 'div_namadivisi')->orderBy('div_kodedivisi')->limit(100)->get();
        return view('BACKOFFICE.cetakPB', compact('divisi'));
    }

    public function getDocument(Request $request){
        $tgl1   = $request->tgl1;
        $tgl2   = $request->tgl2;

        $document = DB::connection(Session::get('connection'))->table('tbtr_pb_h')
            ->select('pbh_nopb', 'pbh_tglpb')
            ->whereNull('pbh_recordid')
            ->whereBetween('pbh_tglpb', [$tgl1,$tgl2])
            ->orderBy('pbh_nopb')->get();


        return Datatables::of($document)->make(true);
//        return response()->json($document);
    }

    public function searchDocument(Request $request){
        $search = $request->search;
        $tgl1   = $request->tgl1;
        $tgl2   = $request->tgl2;

        $document = DB::connection(Session::get('connection'))->table('tbtr_pb_h')->select('pbh_nopb', 'pbh_keteranganpb')
            ->where('pbh_nopb','LIKE', '%'.$search.'%')
            ->orWhere('pbh_keteranganpb','LIKE', '%'.$search.'%')
            ->whereBetween('pbh_create_dt', [$tgl1,$tgl2])
            ->orderBy('pbh_nopb')->get();

        return response()->json($document);
    }

    public function getDivisi(){
        $divisi     = DB::connection(Session::get('connection'))->table('TBMASTER_DIVISI')->select('div_kodedivisi', 'div_namadivisi')->orderBy('div_kodedivisi')->limit(100)->get();

        return response()->json($divisi);
    }

    public function searchDivisi(Request $request){
        $search = $request->search;

        $divisi = DB::connection(Session::get('connection'))->table('TBMASTER_DIVISI')->select('div_kodedivisi', 'div_namadivisi')
            ->where('div_kodedivisi','LIKE', '%'.$search.'%')
            ->orWhere('div_namadivisi','LIKE', '%'.$search.'%')
            ->orderBy('div_kodedivisi')
            ->get();

        return response()->json($divisi);
    }

    public function getDepartement(Request $request){
        $div1   = $request->div1;
        $div2   = $request->div2;

        $departemen = DB::connection(Session::get('connection'))->table('TBMASTER_DEPARTEMENT')->select('DEP_KODEDEPARTEMENT', 'DEP_NAMADEPARTEMENT')
            ->whereBetween('dep_kodedivisi', [$div1,$div2])
            ->orderBy('DEP_KODEDEPARTEMENT')->get();

        return Datatables::of($departemen)->make(true);
//        return response()->json($departemen);
    }

    public function searchDepartement(Request $request){
        $search = $request->search;
        $div1   = $request->div1;
        $div2   = $request->div2;

        $departemen = DB::connection(Session::get('connection'))->table('TBMASTER_DEPARTEMENT')->select('DEP_KODEDEPARTEMENT', 'DEP_NAMADEPARTEMENT')
            ->where('DEP_KODEDEPARTEMENT','LIKE', '%'.$search.'%')
            ->orWhere('DEP_NAMADEPARTEMENT','LIKE', '%'.$search.'%')
            ->whereBetween('dep_kodedivisi', [$div1,$div2])
            ->orderBy('DEP_KODEDEPARTEMENT')
            ->get();

        return response()->json($departemen);
    }

    public function getKategori(Request $request){
        $dep1   = $request->dept1;
        $dep2   = $request->dept2;

        $kategori = DB::connection(Session::get('connection'))->table('TBMASTER_KATEGORI')->select('KAT_KODEDEPARTEMENT', 'KAT_KODEKATEGORI', 'KAT_NAMAKATEGORI')
            ->whereBetween('KAT_KODEDEPARTEMENT',[$dep1,$dep2])
            ->orderBy('KAT_KODEDEPARTEMENT')
            ->orderBy('KAT_KODEKATEGORI')
            ->get()->toArray();

        return Datatables::of($kategori)->make(true);
    }

    public function searchKategori(Request $request){
        $dep1   = $request->dept1;
        $dep2   = $request->dept2;
        $search = strtoupper($request->search);

        $kategori = DB::connection(Session::get('connection'))->table('TBMASTER_KATEGORI')->select('KAT_KODEDEPARTEMENT', 'KAT_KODEKATEGORI', 'KAT_NAMAKATEGORI')
            ->where('KAT_KODEKATEGORI','LIKE', '%'.$search.'%')
            ->orWhere('KAT_NAMAKATEGORI','LIKE', '%'.$search.'%')
            ->whereBetween('KAT_KODEDEPARTEMENT',[$dep1,$dep2])
            ->orderBy('KAT_KODEDEPARTEMENT')
            ->orderBy('KAT_KODEKATEGORI')
            ->get()->toArray();

        return response()->json($kategori);
    }

    public function cetakReport(Request $request){
        $tgl1 = $request->tgl1;
        $tgl2 = $request->tgl2;
        $doc1 = $request->doc1;
        $doc2 = $request->doc2;
        $div1 = $request->div1;
        $div2 = $request->div2;
        $dept1 = $request->dept1;
        $dept2 = $request->dept2;
        $kat1 = $request->kat1;
        $kat2 = $request->kat2;
        $tipePB = $request->tipePB;
        $kodeigr= Session::get('kdigr');

        if ($doc1   == null) { $doc1    = ' '; }
        if ($doc2   == null) { $doc2    = 'ZZZZZZZZZZ'; }
        if ($div1   == null) { $div1    = ' '; }
        if ($div2   == null) { $div2    = 'ZZ'; }
        if ($dept1  == null) { $dept1   = ' '; }
        if ($dept2  == null) { $dept2   = 'ZZ'; }
        if ($kat1   == null) { $kat1    = ' '; }
        if ($kat2   == null) { $kat2    = 'ZZ'; }


        $data = DB::connection(Session::get('connection'))->select("SELECT pbh_nopb,
         tglpb pbh_tglpb,
         pbh_flagdoc,
         pbh_gross,
         hrg,
         prdcd pbd_prdcd,
         prd_deskripsipanjang,
         prd_frac,
         qty,
         qtyk,
         satuan,
         Gross,
         prd_minorder,
         pbd_ostpo,
         pbd_ostpb,
         tag,
         departement,
         pbd_kodedepartement,
         kategori,
         pbd_kodekategoribrg,
         pkmg_prdcd,
         pkmg_nilaipkmg,
         CASE
            WHEN pkmg_prdcd IS NOT NULL THEN FLOOR (pkmg_nilaipkmg / prd_frac)
            ELSE pkm_qty
         END
            pkm_qty,
         CASE
            WHEN pkmg_prdcd IS NOT NULL THEN MOD (pkmg_nilaipkmg, prd_frac)
            ELSE pkm_qtyk
         END
            pkm_qtyk,
         pkm_minorder,
         stock_qty,
         stock_qtyk,
         prs_namaperusahaan,
         prs_namacabang,
         prs_namawilayah,
         supplier,
         omi,
         idm,
         min_minorder
    FROM (SELECT pbh_nopb,
                 pbh_tglpb tglpb,
                 CASE NVL (pbh_flagdoc, ' ')
                    WHEN '1' THEN 'Re-Print'
                    ELSE ' '
                 END
                    pbh_flagdoc,
                 pbh_gross,
                 pbd_gross hrg,
                 pbd_prdcd prdcd,
                 prd_deskripsipanjang,
                 prd_frac,
                 TRUNC (pbd_qtypb / prd_frac) qty,
                 MOD (pbd_qtypb, prd_frac) qtyk,
                 prd_unit || '/' || prd_frac satuan,
                 NVL (pbd_gross, 0) + NVL (pbd_ppn, 0) Gross,
                 prd_minorder,
                 NVL (pbd_ostpo, 0) pbd_ostpo,
                 NVL (pbd_ostpb, 0) pbd_ostpb,
                 pbd_kodetag tag,
                 pbd_kodedepartement || ' ' || dep_namadepartement departement,
                 pbd_kodedepartement,
                 pbd_kodekategoribrg || ' ' || kat_namakategori kategori,
                 pbd_kodekategoribrg,
                 FLOOR (pkm_pkmt / prd_frac) pkm_qty,
                 MOD (pkm_pkmt, prd_frac) pkm_qtyk,
                 pkm_minorder,
                 TRUNC (st_saldoakhir / prd_frac) stock_qty,
                 MOD (st_saldoakhir, prd_frac) stock_qtyk,
                 prs_namaperusahaan,
                 prs_namacabang,
                 prs_namawilayah,
                 pbd_kodesupplier || ' ' || sup_namasupplier supplier,
                 NVL (crma.PRC_PLUOMI, 0) omi,
                 NVL (crmb.PRC_PLUIDM, 0) idm,
                 min_minorder
            FROM tbtr_pb_h,
                 tbtr_pb_d,
                 tbmaster_prodmast,
                 tbmaster_departement,
                 tbmaster_kategori,
                 tbmaster_kkpkm,
                 tbmaster_stock,
                 tbmaster_perusahaan,
                 tbmaster_supplier,
                 tbmaster_prodcrm crma,
                 tbmaster_prodcrm crmb,
                 tbmaster_minimumorder
           WHERE     (TRUNC (pbh_tglpb) BETWEEN '$tgl1'
                                            AND '$tgl2')
                 and pbh_tipepb = '$tipePB'
                 AND pbd_nopb = pbh_nopb
                 AND pbd_kodeigr = pbh_kodeigr
                 AND prd_prdcd = pbd_prdcd
                 AND prd_kodeigr = pbd_kodeigr
                 AND dep_kodedivisi = prd_kodedivisi
                 AND dep_kodedepartement = prd_kodedepartement
                 AND dep_kodeigr = prd_kodeigr
                 AND kat_kodekategori = prd_kodekategoribarang
                 AND kat_kodedepartement = dep_kodedepartement
                 AND kat_kodeigr = dep_kodeigr
                 AND KAT_KODEIGR = DEP_KODEIGR
                 AND PBH_NOPB BETWEEN '$doc1' AND '$doc2'
                 AND PBD_KODEDIVISI BETWEEN '$div1' AND '$div2'
                 AND PBD_KODEDEPARTEMENT BETWEEN '$dept1' AND '$dept2'
                 AND PBD_KODEKATEGORIBRG BETWEEN '$kat1' AND '$kat2'
                 AND pkm_prdcd(+) = prd_prdcd
                 AND pkm_kodeigr(+) = prd_kodeigr
                 AND st_prdcd(+) = prd_prdcd
                 AND st_kodeigr(+) = prd_kodeigr
                 AND st_lokasi(+) = '01'
                 AND prs_kodeigr(+) = prd_kodeigr
                 AND sup_kodesupplier(+) = pbd_kodesupplier
                 AND sup_kodeigr(+) = pbd_kodeigr
                 AND crma.prc_pluigr(+) = prd_prdcd
                 AND crma.prc_kodeigr(+) = prd_kodeigr
                 AND crma.prc_group(+) <> 'I'
                 AND crmb.prc_pluigr(+) = prd_prdcd
                 AND crmb.prc_kodeigr(+) = prd_kodeigr
                 AND crmb.prc_group(+) = 'I'
                 AND min_kodeigr(+) = prd_kodeigr
                 AND min_prdcd(+) = prd_prdcd) a,
         TBTR_PKMGONDOLA
   WHERE     PKMG_PRDCD(+) = a.prdcd
         AND PKMG_TGLAWALPKM(+) - 3 <= a.tglpb
         AND a.tglpb <= PKMG_TGLAKHIRPKM(+) - 7
ORDER BY pbh_nopb,supplier, departement, kategori asc
");

        $perusahaan = DB::connection(Session::get('connection'))->table('tbmaster_perusahaan')->first();

        $pdf = PDF::loadview('BACKOFFICE.cetakPB-laporan', ['perusahaan' => $perusahaan, 'data' => $data, 'tgl_start' => $tgl1, 'tgl_end' => $tgl2, 'tipepb' => $tipePB, 'kategori' => 0, 'totalkategori' => 0, 'totalsupplier' => 0]);
        $pdf->output();
        $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);

        $canvas = $dompdf ->get_canvas();
        $canvas->page_text(507, 77.75, "{PAGE_NUM} dari {PAGE_COUNT}", null, 7, array(0, 0, 0));

        DB::connection(Session::get('connection'))->table('tbtr_pb_h')
            ->whereRaw("trunc (pbh_tglpb) between '$tgl1' and '$tgl2'")
            ->whereBetween('pbh_nopb', [$doc1,$doc2])
            ->whereRaw("nvl(pbh_flagdoc,' ')=' '")
            ->update(["pbh_flagdoc" => 1]);

        return $pdf->stream((__('PBOtomatis-laporan.pdf')));
    }

}
