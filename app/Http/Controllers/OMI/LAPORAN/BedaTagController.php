<?php


namespace App\Http\Controllers\OMI\LAPORAN;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use mysql_xdevapi\Exception;
use PDF;
use DateTime;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;
use App\Http\Controllers\Auth\loginController;

class BedaTagController extends Controller
{

    public function index()
    {
        return view('BACKOFFICE.bedatagomi');
    }

    public function getLovDivisi()
    {
        $kodeigr = Session::get('kdigr');

        $datas = DB::connection(Session::get('connection'))->table('tbmaster_divisi')
            ->selectRaw('div_namadivisi')
            ->selectRaw('trim(div_kodedivisi) div_kodedivisi')
            ->where('div_kodeigr', '=', $kodeigr)
            ->get();

        return Datatables::of($datas)->make(true);
    }

    public function getLovDepartemen()
    {
        $kodeigr = Session::get('kdigr');

        $datas = DB::connection(Session::get('connection'))->table('tbmaster_departement')
            ->selectRaw('dep_namadepartement')
            ->selectRaw('dep_kodedepartement')
            ->selectRaw('dep_kodedivisi')
            ->where('dep_kodeigr', '=', $kodeigr)
            ->orderByRaw("dep_kodedivisi, dep_kodedepartement")
            ->get();

        return Datatables::of($datas)->make(true);
    }

    public function getLovKategori()
    {
        $kodeigr = Session::get('kdigr');

        $datas = DB::connection(Session::get('connection'))->table('tbmaster_kategori')
            ->selectRaw('kat_namakategori')
            ->selectRaw('kat_kodekategori')
            ->selectRaw('kat_kodedepartement')
            ->where('kat_kodeigr', '=', $kodeigr)
            ->orderByRaw("kat_kodedepartement, kat_kodekategori")
            ->get();

        return Datatables::of($datas)->make(true);
    }

    public function validateTag(Request $request){
        
        $errflag = 0;
        $kodeigr = Session::get('kdigr');
        $tag = $request->tag;

        $temp = DB::connection(Session::get('connection'))
        ->select("SELECT COUNT(1) into temp
                    FROM tbmaster_tag
                    WHERE tag_kodetag = $tag");
        
        if($temp[0]->temp == 0){
            return response()->json(['message' => 'Kode Tag tidak terdaftar', 'errflag' => $errflag, 'status' => 'error']);
        }

    }


    // ### FUNGSI-FUNGSI PRINT/CETAK ###
    public function printLaporan(Request $request)
    {
        $kodeigr = Session::get('kdigr');
        $div1 = $request->div1;
        if ($div1 == '') {
            $temp = DB::connection(Session::get('connection'))->table("tbmaster_divisi")
                ->selectRaw("min(div_kodedivisi) as result")
                ->where("div_kodeigr", '=', $kodeigr)
                ->first();
            $div1 = $temp->result;
        }
        $div2 = $request->div2;
        if ($div2 == '') {
            $temp = DB::connection(Session::get('connection'))->table("tbmaster_divisi")
                ->selectRaw("max(div_kodedivisi) as result")
                ->where("div_kodeigr", '=', $kodeigr)
                ->first();
            $div2 = $temp->result;
        }
        $dep1 = $request->dep1;
        if ($dep1 == '') {
            $temp = DB::connection(Session::get('connection'))->table("tbmaster_departement")
                ->selectRaw("min(dep_kodedepartement) as result")
                ->where("dep_kodeigr", '=', $kodeigr)
                ->where("dep_kodedivisi", '=', $div1)
                ->first();
            $dep1 = $temp->result;
        }
        $dep2 = $request->dep2;
        if ($dep2 == '') {
            $temp = DB::connection(Session::get('connection'))->table("tbmaster_departement")
                ->selectRaw("max(dep_kodedepartement) as result")
                ->where("dep_kodeigr", '=', $kodeigr)
                ->where("dep_kodedivisi", '=', $div2)
                ->first();
            $dep2 = $temp->result;
        }
        $kat1 = $request->kat1;
        if ($kat1 == '') {
            $temp = DB::connection(Session::get('connection'))->table("tbmaster_kategori")
                ->selectRaw("min(kat_kodekategori) as result")
                ->where("kat_kodeigr", '=', $kodeigr)
                ->where("kat_kodedepartement", '=', $dep1)
                ->first();
            $kat1 = $temp->result;
        }
        $kat2 = $request->kat2;
        if ($kat2 == '') {
            $temp = DB::connection(Session::get('connection'))->table("tbmaster_kategori")
                ->selectRaw("max(kat_kodekategori) as result")
                ->where("kat_kodeigr", '=', $kodeigr)
                ->where("kat_kodedepartement", '=', $dep2)
                ->first();
            $kat2 = $temp->result;
        }
        $ptag = $request->ptag;
        $p_tagq = "";
        if ($ptag != '') {
            $p_tagq = "and NVL(prd_kodetag,'b') in (" . $ptag . ")";
        }
        $produkbaru = $request->produkbaru;
        $chp = $request->chp;
        $sort = $request->sort;
        $date = $request->date;
        $date = DateTime::createFromFormat('d-m-Y', $date)->format('d-M-Y');
        if ((int)$produkbaru == 1) {
            $judul = " ** DAFTAR PRODUK BARU ** ";
            $temp = DB::connection(Session::get('connection'))->table("dual")
                ->selectRaw("nvl(TO_DATE('$date','DD-MON-YYYY'),sysdate)-91 as result")
                ->first();
            $tgla = $temp->result;
            $tgla = DateTime::createFromFormat('Y-m-d H:i:s', $tgla)->format('d-M-Y');
            $p_periodtgl = " and prd_tglaktif >= to_date('$tgla','dd-MON-yy') ";
        } else {
            $judul = " ** DAFTAR PRODUK ** ";
            $p_periodtgl = '';
        }
        // if ((int)$sort == 1) {
        //     $p_urut = "URUT: DIV+DEPT+KATEGORI+KODE";
        //     $p_orderby = " order by prd_kodedivisi, prd_kodedepartement, prd_kodekategoribarang, prd_prdcd";
        // } elseif ((int)$sort == 2) {
        //     $p_urut = "URUT: DIV+DEPT+KATEGORI+NAMA";
        //     $p_orderby = " order by prd_kodedivisi, prd_kodedepartement, prd_kodekategoribarang, prd_deskripsipanjang";
        // } else {
        //     $p_urut = "URUT: NAMA";
        //     $p_orderby = " order by prd_deskripsipanjang";
        // }

        $datas = DB::connection(Session::get('connection'))->select("select prd_prdcd prd, prd_deskripsipanjang desc2, prd_unit||'/'||prd_frac satuan,
case when substr(prd_prdcd,-1) = 1 then 1 else prd_minjual end minjl,
prd_lastcost, prd_avgcost, prd_hrgjual, prd_flagbkp1, prd_flagbkp2,
prd_unit, prd_frac, prd_tglaktif, prd_kodetag, prd_minorder, prd_ppn,
prd_kodedivisi, prd_kodedepartement, prd_kodekategoribarang,
st_prdcd, st_avgcost,case when substr(prd_prdcd,-1) = '0' then 1 else 0 end produk,
sls_kodesupplier||'-'||substr(sup_namasupplier,1,8) SUPPLIER,
hgb_top, sup_top,
div_kodedivisi||' - '||div_namadivisi divisi,
dep_kodedepartement||' - '|| dep_namadepartement dept,
kat_kodekategori||' - '|| kat_namakategori kategori,
pkm_prdcd,
prs_namaperusahaan, prs_namacabang
from tbmaster_prodmast, tbmaster_stock, tbtr_salesbulanan, tbmaster_supplier,
     tbmaster_hargabeli, tbmaster_divisi, tbmaster_departement, tbmaster_kategori,
     tbmaster_kkpkm, tbmaster_perusahaan
where prd_kodeigr = '$kodeigr'
and nvl(prd_recordid,'9')!='1'
and st_prdcd (+) = substr(prd_prdcd,0,6)||'0'
and st_kodeigr(+)=prd_kodeigr
and st_lokasi(+)='01'
and sls_kodesupplier(+) = prd_kodesupplier
and sls_prdcd(+)=substr(prd_prdcd,0,6)||'0'
and sls_kodeigr(+)=prd_kodeigr
and sup_kodesupplier(+)=sls_kodesupplier
and sup_kodeigr(+)=sls_kodeigr
and hgb_prdcd(+)=prd_prdcd
and hgb_kodesupplier(+)=prd_kodesupplier
and hgb_kodeigr(+)=prd_kodeigr
and div_kodedivisi = prd_kodedivisi
and div_kodeigr=prd_kodeigr
--and div_kodedivisi between  :p_div1 and  :p_div2
and dep_kodedepartement = prd_kodedepartement
and dep_kodedivisi = div_kodedivisi
and dep_kodeigr = prd_kodeigr
--and dep_kodedepartement between :p_dep1 and :p_dep2
and kat_kodekategori = prd_kodekategoribarang
and kat_kodedepartement = dep_kodedepartement
and kat_kodeigr= prd_kodeigr
" . $p_tagq . "
and prs_kodeigr = prd_kodeigr
and prd_kodedivisi||prd_kodedepartement||prd_kodekategoribarang between '$div1'||'$dep1'||'$kat1' and '$div2'||'$dep2'||'$kat2'
--and kat_kodekategori between :p_kat1 and :p_kat2
" . $p_periodtgl . "
and pkm_prdcd(+) = prd_prdcd
and pkm_kodeigr(+) = prd_kodeigr
and prs_kodeigr(+) = prd_kodeigr
" );

        $cf_nmargin = [];
        for ($i = 0; $i < sizeof($datas); $i++) {
            $ppn = isset($datas[$i]->prd_ppn) ? 1 + ($datas[$i]->prd_ppn / 100) : 1.1;
            if ($datas[$i]->prd_unit == 'KG') {
                $multiplier = 1;
            } else {
                $multiplier = (int)$datas[$i]->prd_frac;
            }
            $nAcost = (float)$datas[$i]->st_avgcost * $multiplier;

            if ($nAcost > 0) {
                if ($datas[$i]->prd_flagbkp1 == 'Y' && $datas[$i]->prd_flagbkp2 != 'P') {
                    $cf_nmargin[$i] = isset($datas[$i]->prd_hrgjual) ? round((1 - $ppn * $nAcost / $datas[$i]->prd_hrgjual) * 100,2): 0;

                    //rumus disamaain dengan informasihistoryproduct berdasarkan UAT 22-03-2022 By Remus,Denni
//                    $cf_nmargin[$i] = round((($datas[$i]->prd_hrgjual) / ($ppn * $nAcost) - 1) * 100, 2);
                    //sini
                } else {
                    $cf_nmargin[$i] = isset($datas[$i]->prd_hrgjual) ? round((1 - $nAcost / $datas[$i]->prd_hrgjual) * 100,2):0;
                    //rumus disamaain dengan informasihistoryproduct berdasarkan UAT 22-03-2022 By Remus,Denni
//                    $cf_nmargin[$i] = round((($datas[$i]->prd_hrgjual) / $nAcost - 1) * 100, 2);
                }
            } else {
                $cf_nmargin[$i] = 0;
            }
        }



        //PRINT
        $perusahaan = DB::connection(Session::get('connection'))->table("tbmaster_perusahaan")->first();
        if ((int)$sort < 3) {
            //CETAK_DAFTARPRODUK (IGR_BO_DAFTARPRODUK.jsp)
            return view('BACKOFFICE.LISTMASTERASSET.LAPORAN.daftar-produk-pdf',
                ['kodeigr' => $kodeigr, 'data' => $datas, 'perusahaan' => $perusahaan,
                    'judul' => $judul, 'urut' => $p_urut, 'p_hpp' => $chp,
                    'cf_nmargin' => $cf_nmargin]);
        } else {
            //CETAK_DAFTARPRDNAMA (IGR_BO_DAFTARPRDNM.jsp)
            return view('BACKOFFICE.LISTMASTERASSET.LAPORAN.daftar-produk-nama-pdf',
                ['kodeigr' => $kodeigr, 'data' => $datas, 'perusahaan' => $perusahaan,
                    'judul' => $judul, 'urut' => $p_urut, 'p_hpp' => $chp,
                    'cf_nmargin' => $cf_nmargin]);
        }
    }

}
