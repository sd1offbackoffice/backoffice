<?php

namespace App\Http\Controllers\BACKOFFICE\PROSES;

use App\AllModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller; use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use PDF;

class settingPagiHariController extends Controller
{
    public function index(){

        return view('BACKOFFICE.PROSES.settingPagiHari');
    }

    public function tanggal(){

        $kodeigr = Session::get('kdigr');
        $model  = new AllModel();
        $dateTime = $model->getDateTime();

        $tgltrkmrn = DB::connection(Session::get('connection'))->table('tbmaster_perusahaan')
            ->select('prs_periodeterakhir')
            ->where('prd_kodeigr', '=', $kodeigr)
            ->get();

        if(!$tgltrkmrn){
            return response()->json([['kode' => 0, 'msg' => "Tanggal Transaksi Kemarin Tidak Terdefinisi !!"]]);
        } else {
            $tglsistem = $dateTime;
            $tgltrskrg = $dateTime;
        }
        return response()->json(['kode' => 1, 'tgltrkmrn' => $tgltrkmrn, 'tglsistem' => $tglsistem, 'tgltrskrg' => $tgltrskrg]);
    }

    public function cetak_perubahan_harga_jual(){

        $kodeigr = Session::get('kdigr');
        $ppn = '';
        $nActMargin = '';

        $perusahaan = DB::connection(Session::get('connection'))->table('tbmaster_perusahaan')
            ->select('prs_namaperusahaan', 'prs_namacabang')
            ->where('prs_kodeigr', '=', $kodeigr)
            ->first();

        if($ppn = 0){
            $ppn = 1.1;
        } else {
            $ppn = 1 + ($ppn/100);
        }

        $data = DB::connection(Session::get('connection'))->select("SELECT temp.prdcd as prdcd,
               --++ NVL BUAT DIV DEPT KAT, KEPUTUSAN SSA
               NVL(prd.prd_kodedivisi,' ') as PRD_KodeDivisi,
               NVL(div.DIV_NAMADIVISI,' ') as DIV_NamaDivisi,
               NVL(prd.prd_kodedepartement,' ') as PRD_KodeDepartement,
               NVL(dept.DEP_NAMADEPARTEMENT,' ') as DEP_NamaDepartement,
               NVL(prd.prd_kodekategoribarang,' ') as PRD_KodeKategoriBarang,
               NVL(kat.KAT_NAMAKATEGORI,' ') as KAT_NamaKategori,
               ---- NVL BUAT DIV DEPT KAT, KEPUTUSAN SSA
               prd.prd_flagbkp1,
               nvl(prd.prd_hrgjual,0) prd_hrgjual,
               nvl(prd.prd_hrgjual2,0) prd_hrgjual2,
               nvl(prd.prd_hrgjual3,0) prd_hrgjual3,
               prd.prd_unit as unit,
               nvl(prd.prd_frac,1) prd_frac,
               prd_minjual,
               nvl(prd.prd_lastcost,0) prd_lastcost,
               nvl(prd.prd_avgcost,0) prd_avgcost,
               prd.prd_tglhrgjual prd_tglhrgjual,
               prd.prd_tglhrgjual3,
               prd.prd_hrgjual prd_hrgjual,
               prd.prd_hrgjual2 prd_hrgjual2,
               prd.prd_kodetag as prd_kodetag,
               SUBSTR(prd.prd_deskripsipanjang,1,50) prd_deskripsipanjang,
               prmd.prmd_tglawal,
               prmd.prmd_tglakhir,
               prmd.prmd_jenisdisc,
               nvl(prmd.prmd_hrgjual,0) prmd_hrgjual,
               CASE WHEN trunc(prmd.PRMD_TGLAWAL) = trunc(sysdate) and nvl(prmd.PRMD_JENISDISC,'Z') = 'T' THEN 'Y' ELSE 'T' END as Awal,
               CASE WHEN trunc(prmd.PRMD_TGLAKHIR) + 1 = trunc(sysdate) and nvl(prmd.PRMD_JENISDISC,'Z') = 'T' THEN 'Y' ELSE 'T' END as Akhir
          FROM tbtemp_setting_pagi_hari temp,
               tbmaster_prodmast prd,
               tbtr_promomd prmd,
               tbmaster_divisi div,
               tbmaster_departement dept,
               tbmaster_kategori kat
         WHERE prd.prd_prdcd(+) = temp.prdcd
        AND prmd.prmd_prdcd(+) = temp.prdcd
        AND div.div_kodedivisi(+) = prd.prd_kodedivisi
        AND dept.dep_kodedepartement(+) = prd.prd_kodedepartement
        AND dept.dep_kodedivisi(+) = prd.prd_kodedivisi
        AND kat.kat_kodedepartement(+) = prd.prd_kodedepartement
        AND kat.kat_kodekategori(+) = prd.prd_kodekategoribarang
        order by prd_kodedivisi,prd_kodedepartement,prd_kodekategoribarang,temp.prdcd");

            if($data[0]->prd_flagbkp1 == 'Y')
            {
                if($data[0]->awal == 'Y'){
                    $nActMargin = ((($data[0]->prmd_hrgjual - ($ppn * $data[0]->prd_lastcost)) / $data[0]->prmd_hrgjual) * 100);
                }
                if($data[0]->akhir == 'Y'){
                    $nActMargin = ((($data[0]->prd_hrgjual2 - ($ppn * $data[0]->prd_lastcost)) / $data[0]->prd_hrgjual2) * 100);
                }
                if($data[0]->awal == 'T' && $data[0]->akhir == 'T') {
                    if ($data[0]->prd_hrgjual) {
                        $nActMargin = 100;
                    } else {
                        $nActMargin = ((($data[0]->prd_hrgjual - ($ppn * $data[0]->prd_lastcost)) / $data[0]->prd_hrgjual) * 100);
                    }
                }
            } else {
                if($data[0]->awal == 'Y'){
                    $nActMargin = ((($data[0]->prmd_hrgjual - $data[0]->prd_lastcost) / $data[0]->prmd_hrgjual) * 100);
                }
                if($data[0]->akhir == 'Y'){
                    $nActMargin = ((($data[0]->prd_hrgjual2 - $data[0]->prd_lastcost) / $data[0]->prd_hrgjual2) * 100);
                }
                if($data[0]->awal == 'T' && $data[0]->akhir == 'T'){
                    if($data[0]->prd_hrgjual3){
                        $nActMargin = 100;
                    } else {
                        $nActMargin = ((($data[0]->prd_hrgjual - $data[0]->prd_lastcost) / $data[0]->prd_hrgjual) * 100);
                    }
                }
            }

//            dd($data);

        $pdf = PDF::loadview('BACKOFFICE.PROSES.settingpagihari-cetak-hrgjual', compact(['perusahaan', 'data', 'nActMargin']));
        $pdf->output();
        $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);

        $canvas = $dompdf ->get_canvas();
        $canvas->page_text(514, 10, "Page {PAGE_NUM} of {PAGE_COUNT}", null, 10, array(0, 0, 0));

        return $pdf->stream('settingpagihari-cetak-hrgjual.pdf');

    }

    public function cetak_daftar_plu_tag(){

        $kodeigr = Session::get('kdigr');

        $perusahaan = DB::connection(Session::get('connection'))->table('tbmaster_perusahaan')
            ->select('prs_namaperusahaan', 'prs_namacabang')
            ->where('prs_kodeigr', '=', $kodeigr)
            ->first();

        $data = DB::connection(Session::get('connection'))->select("SELECT prd_prdcd,
		       prd_kodedivisi,
		       div_namadivisi,
		       prd_kodedepartement,
		       dep_namadepartement,
		       prd_kodekategoribarang,
		       kat_namakategori,
		       prd_deskripsipendek,
		       replace(prd_deskripsipanjang,'''','`') AS PRD_DESKRIPSIPANJANG,
		       prd_frac,
		       prd_kodetag,
		       st_saldoakhir,
		       CASE
		           WHEN prc_pluigr IS NOT NULL
		               THEN '*'
		           ELSE ''
		       END omi,
		       lks_koderak
		  FROM tbmaster_prodmast,
		       tbmaster_stock,
		       tbmaster_prodcrm,
		       tbmaster_lokasi,
		       tbmaster_divisi,
		       tbmaster_departement,
		       tbmaster_kategori
		 WHERE prd_kodeigr = '$kodeigr'
		   AND SUBSTR(prd_prdcd, -1, 1) = '0'
		   AND prd_kodetag IN('N', 'X')
		   AND st_prdcd = prd_prdcd
		   AND st_kodeigr = prd_kodeigr
		   AND NVL(st_saldoakhir, 0) <> 0
		   AND st_lokasi = '01'
		   AND prc_kodeigr(+) = prd_kodeigr
		   AND prc_pluigr(+) = prd_prdcd
		   AND lks_kodeigr(+) = prd_kodeigr
		   AND lks_prdcd(+) = prd_prdcd
		   AND div_kodedivisi(+) = prd_kodedivisi
		   AND dep_kodedivisi(+) = prd_kodedivisi
		   AND dep_kodedepartement(+) = prd_kodedepartement
		   AND kat_kodedepartement(+) = prd_kodedepartement
		   AND kat_kodekategori(+) = prd_kodekategoribarang
		 ORDER BY PRD_KODEDIVISI,PRD_KODEDEPARTEMENT,PRD_KODEKATEGORIBARANG,PRD_PRDCD");

        $pdf = PDF::loadview('BACKOFFICE.PROSES.settingpagihari-cetak-daftar-plu-tag', compact(['data', 'perusahaan']));
        $pdf->output();
        $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);

        $canvas = $dompdf ->get_canvas();
        $canvas->page_text(514, 10, "Page {PAGE_NUM} of {PAGE_COUNT}", null, 10, array(0, 0, 0));

        return $pdf->stream('settingpagihari-cetak-daftar-plu-tag.pdf');

    }
}
