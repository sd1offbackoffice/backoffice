<?php
/**
 * Created by PhpStorm.
 * User: ryan
 * Date: 4/11/2021
 * Time: 13:05 PM
 */

namespace App\Http\Controllers\BACKOFFICE;

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

class ListMasterController extends Controller
{

    public function index()
    {
        return view('BACKOFFICE.list-master');
    }

    public function getLovDivisi()
    {
        $kodeigr = Session::get('kdigr');

        $datas = DB::connection(Session::get('connection'))->table('tbmaster_divisi')
            ->selectRaw('div_namadivisi')
            ->selectRaw('trim(div_kodedivisi) div_kodedivisi')
            ->where('div_kodeigr','=',$kodeigr)
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
            ->where('dep_kodeigr','=',$kodeigr)
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
            ->where('kat_kodeigr','=',$kodeigr)
            ->orderByRaw("kat_kodedepartement, kat_kodekategori")
            ->get();

        return Datatables::of($datas)->make(true);
    }

    public function getLovSupplier()
    {
        $kodeigr = Session::get('kdigr');

        $datas = DB::connection(Session::get('connection'))->table('tbmaster_supplier')
            ->selectRaw('sup_namasupplier')
            ->selectRaw('sup_kodesupplier')
            ->where('sup_kodeigr','=',$kodeigr)
            ->orderByRaw("sup_kodesupplier")
            ->get();

        return Datatables::of($datas)->make(true);
    }

    public function getLovMember(Request $request)
    {
        $kodeigr = Session::get('kdigr');
        $search = $request->value;

        $datas = DB::connection(Session::get('connection'))->table('tbmaster_customer')
            ->selectRaw('cus_namamember')
            ->selectRaw('cus_kodemember')
            ->where("cus_namamember",'LIKE', '%'.$search.'%')
            ->where('cus_kodeigr','=',$kodeigr)

            ->orWhere("cus_kodemember",'LIKE', '%'.$search.'%')
            ->where('cus_kodeigr','=',$kodeigr)
            ->limit(1000)
            ->get();

        return Datatables::of($datas)->make(true);
    }
    public function checkMember(Request $request)
    {
        $kodeigr = Session::get('kdigr');
        $search = $request->value;

        $data = DB::connection(Session::get('connection'))->table('tbmaster_customer')
            ->selectRaw('cus_namamember')
            ->where("cus_kodemember",'=', $search)
            ->where('cus_kodeigr','=',$kodeigr)
            ->first();
        if($data){
            $result = $data->cus_namamember;
        }else{
            $result = "false";
        }

        return response()->json($result);
    }
    public function getLovMemberWithDate(Request $request)
    {
        $kodeigr = Session::get('kdigr');
        $dateA = $request->dateA;
        $dateB = $request->dateB;
        $sDate = DateTime::createFromFormat('d-m-Y', $dateA)->format('d-m-Y');
        $eDate = DateTime::createFromFormat('d-m-Y', $dateB)->format('d-m-Y');

        $datas = DB::connection(Session::get('connection'))->table('tbmaster_customer')
            ->selectRaw('cus_namamember')
            ->selectRaw('cus_kodemember')
            ->where('cus_kodeigr','=',$kodeigr)
            ->whereRaw("cus_tglregistrasi between TO_DATE('$sDate','DD-MM-YYYY') and TO_DATE('$eDate','DD-MM-YYYY')")
            ->orderBy("cus_namamember")
            ->get();

        return Datatables::of($datas)->make(true);
    }

    public function getLovOutlet()
    {
        $kodeigr = Session::get('kdigr');

        $datas = DB::connection(Session::get('connection'))->table('tbmaster_outlet')
            ->selectRaw('out_namaoutlet')
            ->selectRaw('out_kodeoutlet')
            ->where('out_kodeigr','=',$kodeigr)
            ->orderByRaw("out_kodeoutlet")
            ->get();

        return Datatables::of($datas)->make(true);
    }

    public function getLovSubOutlet()
    {
        $kodeigr = Session::get('kdigr');

        $datas = DB::connection(Session::get('connection'))->table('tbmaster_suboutlet')
            ->selectRaw('sub_namasuboutlet')
            ->selectRaw('sub_kodesuboutlet')
            ->selectRaw("sub_kodeoutlet")
            ->where('sub_kodeigr','=',$kodeigr)
            ->orderByRaw("sub_kodeoutlet, sub_kodesuboutlet")
            ->get();

        return Datatables::of($datas)->make(true);
    }

    public function getLovPlu(Request $request)
    {
        $kodeigr = Session::get('kdigr');
        $search = $request->value;

        $datas = DB::connection(Session::get('connection'))->table('tbmaster_prodmast')
            ->selectRaw('prd_deskripsipanjang')
            ->selectRaw('prd_prdcd')
            ->where("prd_deskripsipanjang",'LIKE', '%'.$search.'%')
            ->where('prd_kodeigr','=',$kodeigr)

            ->orWhere("prd_prdcd",'LIKE', '%'.$search.'%')
            ->where('prd_kodeigr','=',$kodeigr)
            ->limit(1000)
            ->get();

        return Datatables::of($datas)->make(true);
    }

    public function getLovPluCustom(Request $request)
    {
        $kodeigr = Session::get('kdigr');
        $div1 = $request->div1;
        $div2 = $request->div2;
        $whereDiv = "";

        $dep1 = $request->dep1;
        $dep2 = $request->dep2;
        $whereDep = "";

        $kat1 = $request->kat1;
        $kat2 = $request->kat2;
        $whereKat = "";

        if($div1 != ''){
            if($div2 != ''){
                $whereDiv = "prd_kodedivisi between ".$div1." and ".$div2;
            }else{
                $whereDiv = "prd_kodedivisi >= ".$div1;
            }
        }

        if($dep1 != ''){
            if($dep2 != ''){
                $whereDep = "prd_kodedepartement between ".$dep1." and ".$dep2;
            }else{
                $whereDiv = "prd_kodedepartement >= ".$div1;
            }
        }
        if($whereDiv != "" && $whereDep != ""){
            $whereDep = " and ".$whereDep;
        }

        if($kat1 != ''){
            if($kat2 != ''){
                $whereKat = "prd_kodekategoribarang between ".$kat1." and ".$kat2;
            }else{
                $whereKat = "prd_kodekategoribarang >= ".$kat1;
            }
        }
        if($whereDep != "" && $whereKat != ""){
            $whereKat = " and ".$whereKat;
        }

        $datas = DB::connection(Session::get('connection'))->table('tbmaster_prodmast')
            ->selectRaw('prd_deskripsipanjang')
            ->selectRaw('prd_prdcd')
            ->where('prd_kodeigr','=',$kodeigr)
            ->whereRaw($whereDiv.$whereDep.$whereKat)
            ->get();

        return Datatables::of($datas)->make(true);
    }

    public function checkPlu(Request $request)
    {
        $kodeigr = Session::get('kdigr');
        $search = $request->value;

        $data = DB::connection(Session::get('connection'))->table('tbmaster_prodmast')
            ->selectRaw('prd_deskripsipanjang')
            ->selectRaw("prd_kodedivisi, prd_kodedepartement, prd_kodekategoribarang")
            ->where("prd_prdcd",'=', $search)
            ->where('prd_kodeigr','=',$kodeigr)
            ->first();
        if($data){
            $result = $data;
        }else{
            $result = "false";
        }

        return response()->json($result);
    }

    public function getLovRak()
    {
        $kodeigr = Session::get('kdigr');

        $datas = DB::connection(Session::get('connection'))->table('tbmaster_lokasi')
            ->selectRaw('DISTINCT lks_koderak')
            ->selectRaw('lks_kodesubrak')
            ->selectRaw('lks_tiperak')
            ->selectRaw('lks_shelvingrak')
            ->where('lks_kodeigr','=',$kodeigr)
            ->orderBy("lks_koderak")
            ->get();

        return Datatables::of($datas)->make(true);
    }

    // ### FUNGSI-FUNGSI PRINT/CETAK ###
    public function printDaftarProduk(Request $request)
    {
        $kodeigr = Session::get('kdigr');
        $div1 = $request->div1;
        if($div1 == ''){
            $temp = DB::connection(Session::get('connection'))->table("tbmaster_divisi")
                ->selectRaw("min(div_kodedivisi) as result")
                ->where("div_kodeigr",'=',$kodeigr)
                ->first();
            $div1 = $temp->result;
        }
        $div2 = $request->div2;
        if($div2 == ''){
            $temp = DB::connection(Session::get('connection'))->table("tbmaster_divisi")
                ->selectRaw("max(div_kodedivisi) as result")
                ->where("div_kodeigr",'=',$kodeigr)
                ->first();
            $div2 = $temp->result;
        }
        $dep1 = $request->dep1;
        if($dep1 == ''){
            $temp = DB::connection(Session::get('connection'))->table("tbmaster_departement")
                ->selectRaw("min(dep_kodedepartement) as result")
                ->where("dep_kodeigr",'=',$kodeigr)
                ->where("dep_kodedivisi",'=',$div1)
                ->first();
            $dep1 = $temp->result;
        }
        $dep2 = $request->dep2;
        if($dep2 == ''){
            $temp = DB::connection(Session::get('connection'))->table("tbmaster_departement")
                ->selectRaw("max(dep_kodedepartement) as result")
                ->where("dep_kodeigr",'=',$kodeigr)
                ->where("dep_kodedivisi",'=',$div2)
                ->first();
            $dep2 = $temp->result;
        }
        $kat1 = $request->kat1;
        if($kat1 == ''){
            $temp = DB::connection(Session::get('connection'))->table("tbmaster_kategori")
                ->selectRaw("min(kat_kodekategori) as result")
                ->where("kat_kodeigr",'=',$kodeigr)
                ->where("kat_kodedepartement",'=',$dep1)
                ->first();
            $kat1 = $temp->result;
        }
        $kat2 = $request->kat2;
        if($kat2 == ''){
            $temp = DB::connection(Session::get('connection'))->table("tbmaster_kategori")
                ->selectRaw("max(kat_kodekategori) as result")
                ->where("kat_kodeigr",'=',$kodeigr)
                ->where("kat_kodedepartement",'=',$dep2)
                ->first();
            $kat2 = $temp->result;
        }
        $ptag = $request->ptag;
        $p_tagq = "";
        if($ptag != ''){
            $p_tagq = "and NVL(prd_kodetag,'b') in (".$ptag.")";
        }
        $produkbaru = $request->produkbaru;
        $chp = $request->chp;
        $sort = $request->sort;
        $date = $request->date;
        $date = DateTime::createFromFormat('d-m-Y', $date)->format('d-M-Y');
        if((int)$produkbaru == 1){
            $judul = " ** DAFTAR PRODUK BARU ** ";
            $temp = DB::connection(Session::get('connection'))->table("dual")
                ->selectRaw("nvl(TO_DATE('$date','DD-MON-YYYY'),sysdate)-91 as result")
                ->first();
            $tgla = $temp->result;
            $tgla = DateTime::createFromFormat('Y-m-d H:i:s', $tgla)->format('d-M-Y');
            $p_periodtgl = " and prd_tglaktif >= to_date('$tgla','dd-MON-yy') ";
        }else{
            $judul = " ** DAFTAR PRODUK ** ";
            $p_periodtgl = '';
        }
        if((int)$sort == 1){
            $p_urut = "URUT: DIV+DEPT+KATEGORI+KODE";
            $p_orderby = " order by prd_kodedivisi, prd_kodedepartement, prd_kodekategoribarang, prd_prdcd";
        }elseif ((int)$sort == 2){
            $p_urut = "URUT: DIV+DEPT+KATEGORI+NAMA";
            $p_orderby = " order by prd_kodedivisi, prd_kodedepartement, prd_kodekategoribarang, prd_deskripsipanjang";
        }else{
           $p_urut = "URUT: NAMA" ;
           $p_orderby = " order by prd_deskripsipanjang";
        }

        $datas = DB::connection(Session::get('connection'))->select("select prd_prdcd prd, prd_deskripsipanjang desc2, prd_unit||'/'||prd_frac satuan,
case when substr(prd_prdcd,-1) = 1 then 1 else prd_minjual end minjl,
prd_lastcost, prd_avgcost, prd_hrgjual, prd_flagbkp1, prd_flagbkp2,
prd_unit, prd_frac, prd_tglaktif, prd_kodetag, prd_minorder,
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
".$p_tagq."
and prs_kodeigr = prd_kodeigr
and prd_kodedivisi||prd_kodedepartement||prd_kodekategoribarang between '$div1'||'$dep1'||'$kat1' and '$div2'||'$dep2'||'$kat2'
--and kat_kodekategori between :p_kat1 and :p_kat2
".$p_periodtgl."

and pkm_prdcd(+) = prd_prdcd
and pkm_kodeigr(+) = prd_kodeigr
and prs_kodeigr(+) = prd_kodeigr
".$p_orderby);

        $cf_nmargin = [];
        for($i=0;$i<sizeof($datas);$i++){
            if($datas[$i]->prd_unit == 'KG'){
                $multiplier = 1;
            }else{
                $multiplier = (int)$datas[$i]->prd_frac;
            }
            $nAcost = (float)$datas[$i]->st_avgcost * $multiplier;
            if($nAcost > 0){
                if($datas[$i]->prd_flagbkp1 == 'Y' && $datas[$i]->prd_flagbkp2 != 'P'){
                    $cf_nmargin[$i] = round((($datas[$i]->prd_hrgjual)/(1.1 * $nAcost)-1)*100, 2);
                }else{
                    $cf_nmargin[$i] = round((($datas[$i]->prd_hrgjual)/$nAcost-1)*100, 2);
                }
            }else{
                $cf_nmargin[$i]=0;
            }
        }

        //PRINT
        $perusahaan = DB::table("tbmaster_perusahaan")->first();
        if((int)$sort < 3){
            //CETAK_DAFTARPRODUK (IGR_BO_DAFTARPRODUK.jsp)
            return view('BACKOFFICE.LISTMASTERASSET.LAPORAN.daftar-produk-pdf',
                ['kodeigr' => $kodeigr, 'data' => $datas, 'perusahaan' => $perusahaan,
                    'judul' => $judul, 'urut' => $p_urut, 'p_hpp' => $chp,
                    'cf_nmargin' => $cf_nmargin]);
        }else{
            //CETAK_DAFTARPRDNAMA (IGR_BO_DAFTARPRDNM.jsp)
            return view('BACKOFFICE.LISTMASTERASSET.LAPORAN.daftar-produk-nama-pdf',
                ['kodeigr' => $kodeigr, 'data' => $datas, 'perusahaan' => $perusahaan,
                    'judul' => $judul, 'urut' => $p_urut, 'p_hpp' => $chp,
                    'cf_nmargin' => $cf_nmargin]);
        }
    }

    public function printDaftarPerubahanHargaJual(Request $request)
    {
        $kodeigr = Session::get('kdigr');
        $div1 = $request->div1;
        if($div1 == ''){
            $temp = DB::connection(Session::get('connection'))->table("tbmaster_divisi")
                ->selectRaw("min(div_kodedivisi) as result")
                ->where("div_kodeigr",'=',$kodeigr)
                ->first();
            $div1 = $temp->result;
        }
        $div2 = $request->div2;
        if($div2 == ''){
            $temp = DB::connection(Session::get('connection'))->table("tbmaster_divisi")
                ->selectRaw("max(div_kodedivisi) as result")
                ->where("div_kodeigr",'=',$kodeigr)
                ->first();
            $div2 = $temp->result;
        }
        $dep1 = $request->dep1;
        if($dep1 == ''){
            $temp = DB::connection(Session::get('connection'))->table("tbmaster_departement")
                ->selectRaw("min(dep_kodedepartement) as result")
                ->where("dep_kodeigr",'=',$kodeigr)
                ->where("dep_kodedivisi",'=',$div1)
                ->first();
            $dep1 = $temp->result;
        }
        $dep2 = $request->dep2;
        if($dep2 == ''){
            $temp = DB::connection(Session::get('connection'))->table("tbmaster_departement")
                ->selectRaw("max(dep_kodedepartement) as result")
                ->where("dep_kodeigr",'=',$kodeigr)
                ->where("dep_kodedivisi",'=',$div2)
                ->first();
            $dep2 = $temp->result;
        }
        $kat1 = $request->kat1;
        if($kat1 == ''){
            $temp = DB::connection(Session::get('connection'))->table("tbmaster_kategori")
                ->selectRaw("min(kat_kodekategori) as result")
                ->where("kat_kodeigr",'=',$kodeigr)
                ->where("kat_kodedepartement",'=',$dep1)
                ->first();
            $kat1 = $temp->result;
        }
        $kat2 = $request->kat2;
        if($kat2 == ''){
            $temp = DB::connection(Session::get('connection'))->table("tbmaster_kategori")
                ->selectRaw("max(kat_kodekategori) as result")
                ->where("kat_kodeigr",'=',$kodeigr)
                ->where("kat_kodedepartement",'=',$dep2)
                ->first();
            $kat2 = $temp->result;
        }
        $check = $request->check;
        $sort = $request->sort;
        $tag1 = $request->tag1;
        $tag2 = $request->tag2;
        $sDate = $request->date1;
        $eDate = $request->date2;
        $sDate = DateTime::createFromFormat('d-m-Y', $sDate)->format('d-M-Y');
        $eDate = DateTime::createFromFormat('d-m-Y', $eDate)->format('d-M-Y');

        if($sort == '1'){
            $urut = "URUT  : DIV+DEPT+KATEGORI+KODE";
            $p_orderby = " order by prd_kodedivisi, prd_kodedepartement, prd_kodekategoribarang, prd_prdcd";
        }elseif($sort == '2'){
            $urut = "URUT  : DIV+DEPT+KATEGORI+NAMA";
            $p_orderby = " order by prd_kodedivisi, prd_kodedepartement, prd_kodekategoribarang, prd_deskripsipanjang";
        }else{
            $urut = "URUT  : NAMA";
            $p_orderby = " order by prd_deskripsipanjang";
        }

        if($tag1 != '' && $tag2 != ''){
            $and_tag = " and NVL(prd_kodetag,'b') between '".$tag1."' and '".$tag2."'";
        }else{
            $and_tag = " ";
        }
        if($check == '1'){
            $and_diskon = " and NVL(prd_kodetag,'b') not in ('Z','N','X','H')";
        }else{
            $and_diskon = " ";
        }
        $datas = DB::connection(Session::get('connection'))->select("select prd_prdcd, prd_flagbkp1 pkp, prd_flagbkp2 pkp2, prd_deskripsipanjang desc2,prd_tglhrgjual,
        prd_unit||'/'||prd_frac as satuan, prd_unit unit, prd_frac frac, case when substr(prd_prdcd,-1) = '0' then 1 else 0 end jml_prod,
        prd_minjual, prd_lastcost, prd_avgcost, prd_hrgjual2 price_b, prd_hrgjual price_a,
        prd_tglaktif, prd_kodetag tag,
        st_avgcost st_lastcost, st_prdcd,
        prd_kodedivisi, prd_kodedepartement, prd_kodekategoribarang,
        prm_tglmulai, prm_tglakhir,
        div_kodedivisi||' - '||div_namadivisi divisi,
        dep_kodedepartement||' - '|| dep_namadepartement dept,
        kat_kodekategori||' - '|| kat_namakategori kategori,
        prs_namaperusahaan, prs_namacabang
from tbmaster_prodmast, tbmaster_stock, tbmaster_promo,
    tbmaster_divisi, tbmaster_departement, tbmaster_kategori,
    tbmaster_perusahaan
where prd_kodeigr = '$kodeigr'
    and nvl(prd_recordid,'9')<>'1'
    and prd_hrgjual <>0
    and prd_tglhrgjual between TO_DATE('$sDate','DD-MM-YYYY') AND TO_DATE('$eDate', 'DD-MM-YYYY')
    ".$and_tag."
    and st_prdcd(+)=substr(prd_prdcd,0,6)||'0'
    and st_kodeigr(+)=prd_kodeigr
    and st_lokasi(+)='01'
    ".$and_diskon."
    and prm_prdcd(+) = prd_prdcd
    and prm_kodeigr(+)=prd_kodeigr
    and prd_tglaktif >= prm_tglmulai(+) AND prd_tglaktif <= prm_tglakhir(+)
    and div_kodedivisi = prd_kodedivisi
    and div_kodeigr=prd_kodeigr
   -- &and_div
    and dep_kodedepartement = prd_kodedepartement
    and dep_kodedivisi = div_kodedivisi
    and dep_kodeigr = prd_kodeigr
   -- &and_dept
    and kat_kodekategori = prd_kodekategoribarang
    and kat_kodedepartement = dep_kodedepartement
    and kat_kodeigr= prd_kodeigr
   -- &and_kat
and prd_kodedivisi||prd_kodedepartement||prd_kodekategoribarang between '$div1'||'$dep1'||'$kat1' and '$div2'||'$dep2'||'$kat2'
    and prs_kodeigr = prd_kodeigr
".$p_orderby);

        $cf_nmargin = [];
        for($i=0;$i<sizeof($datas);$i++){
            if($datas[$i]->unit == 'KG'){
                $multiplier = 1;
            }else{
                $multiplier = (int)$datas[$i]->frac;
            }
            $nAcost = (float)$datas[$i]->st_lastcost * $multiplier;
            if($nAcost > 0){
                if($datas[$i]->pkp == 'Y' && $datas[$i]->pkp2 != 'P'){
                    $cf_nmargin[$i] = round((($datas[$i]->price_a - (1.1*$nAcost)) / $datas[$i]->price_a)*100, 2);
                }else{
                    $cf_nmargin[$i] = round((($datas[$i]->price_a - $nAcost) / $datas[$i]->price_a)*100, 2);
                }
            }else{
                $cf_nmargin[$i]=0;
            }
        }
        //PRINT
        $perusahaan = DB::table("tbmaster_perusahaan")->first();
        if((int)$sort < 3){
            //CETAK_DAFTARPRODUK (IGR_BO_DAFTARPRODUK.jsp)
            return view('BACKOFFICE.LISTMASTERASSET.LAPORAN.daftar-perubahan-harga-jual-pdf',
                ['kodeigr' => $kodeigr, 'data' => $datas, 'perusahaan' => $perusahaan,
                    'date1' => $sDate, 'date2' => $eDate, 'urut' => $urut, 'cf_nmargin' => $cf_nmargin]);
        }else{
            //CETAK_DAFTARPRDNAMA (IGR_BO_DAFTARPRDNM.jsp)
            return view('BACKOFFICE.LISTMASTERASSET.LAPORAN.daftar-perubahan-harga-jual-nama-pdf',
                ['kodeigr' => $kodeigr, 'data' => $datas, 'perusahaan' => $perusahaan,
                    'date1' => $sDate, 'date2' => $eDate, 'urut' => $urut, 'cf_nmargin' => $cf_nmargin]);
        }
    }

    public function printDaftarMarginNegatif(Request $request)
    {
        set_time_limit(0);
        $kodeigr = Session::get('kdigr');
        $div1 = $request->div1;
        if($div1 == ''){
            $temp = DB::connection(Session::get('connection'))->table("tbmaster_divisi")
                ->selectRaw("min(div_kodedivisi) as result")
                ->where("div_kodeigr",'=',$kodeigr)
                ->first();
            $div1 = $temp->result;
        }
        $div2 = $request->div2;
        if($div2 == ''){
            $temp = DB::connection(Session::get('connection'))->table("tbmaster_divisi")
                ->selectRaw("max(div_kodedivisi) as result")
                ->where("div_kodeigr",'=',$kodeigr)
                ->first();
            $div2 = $temp->result;
        }
        $dep1 = $request->dep1;
        if($dep1 == ''){
            $temp = DB::connection(Session::get('connection'))->table("tbmaster_departement")
                ->selectRaw("min(dep_kodedepartement) as result")
                ->where("dep_kodeigr",'=',$kodeigr)
                ->where("dep_kodedivisi",'=',$div1)
                ->first();
            $dep1 = $temp->result;
        }
        $dep2 = $request->dep2;
        if($dep2 == ''){
            $temp = DB::connection(Session::get('connection'))->table("tbmaster_departement")
                ->selectRaw("max(dep_kodedepartement) as result")
                ->where("dep_kodeigr",'=',$kodeigr)
                ->where("dep_kodedivisi",'=',$div2)
                ->first();
            $dep2 = $temp->result;
        }
        $kat1 = $request->kat1;
        if($kat1 == ''){
            $temp = DB::connection(Session::get('connection'))->table("tbmaster_kategori")
                ->selectRaw("min(kat_kodekategori) as result")
                ->where("kat_kodeigr",'=',$kodeigr)
                ->where("kat_kodedepartement",'=',$dep1)
                ->first();
            $kat1 = $temp->result;
        }
        $kat2 = $request->kat2;
        if($kat2 == ''){
            $temp = DB::connection(Session::get('connection'))->table("tbmaster_kategori")
                ->selectRaw("max(kat_kodekategori) as result")
                ->where("kat_kodeigr",'=',$kodeigr)
                ->where("kat_kodedepartement",'=',$dep2)
                ->first();
            $kat2 = $temp->result;
        }
        $ptag = $request->ptag;
        $p_tagq = "";
        if($ptag != ''){
            $p_tagq = "and NVL(prd_kodetag,'b') in (".$ptag.")";
        }
        $sort = $request->sort;
        if((int)$sort == 1){
            $p_urut = "URUT: DIV+DEPT+KATEGORI+KODE";
            $p_orderby = " order by prd_kodedivisi, prd_kodedepartement, prd_kodekategoribarang, prd_prdcd";
        }elseif ((int)$sort == 2){
            $p_urut = "URUT: DIV+DEPT+KATEGORI+NAMA";
            $p_orderby = " order by prd_kodedivisi, prd_kodedepartement, prd_kodekategoribarang, prd_deskripsipanjang";
        }else{
            $p_urut = "URUT: NAMA" ;
            $p_orderby = " order by prd_deskripsipanjang";
        }

        $datas = DB::connection(Session::get('connection'))->select("select /*+ ORDERED */ prd_prdcd, prd_flagbkp1 pkp, prd_flagbkp2 pkp2, prd_deskripsipanjang desc2, prd_lastcost, prd_avgcost,
      prd_hrgjual price_a, prd_kodetag tag, prd_lastcost, prd_unit unit, prd_frac frac,
      prd_unit||'/'|| case when substr(prd_prdcd,-1) = '0' then prd_frac else 1 end satuan,
      st_prdcd, nvl(st_avgcost,0) * case when prd_unit = 'KG' then 1 else prd_frac end avgcost, case when sls_prdcd <> '' then call igr_bo_daftar_margin_negatif(sysdate, prd_prdcd, '$kodeigr', @val as val)  else '0' end avgsls,
      nvl(st_avgcost,0) st_acost, st_saldoakhir qty,
nvl(PRMD_HRGJUAL, 0) FMJUAL,
                         nvl(PRMD_POTONGANPERSEN, 0) FMPOTP, nvl(PRMD_POTONGANRPH, 0) FMPOTR, prmd_prdcd,
      div_kodedivisi||' - '||div_namadivisi divisi,
      dep_kodedepartement||' - '|| dep_namadepartement dept,
      kat_kodekategori||' - '|| kat_namakategori kategori,
      prs_namaperusahaan, prs_namacabang,
      hgb_hrgbeli Fmbeli, hgb_persendisc01 Fmdirp, hgb_rphdisc01 Fmdirr,
      hgb_flagdisc01 Fmdirs, hgb_flagdisc02 Fmdirs2, hgb_persendisc02 Fmditp, hgb_rphdisc02 Fmditr,
      spot_prdcd, sls_prdcd
from tbmaster_prodmast, tbmaster_stock, tbtr_promomd,
     tbmaster_divisi, tbmaster_departement, tbmaster_kategori,
     tbmaster_perusahaan, tbmaster_hargabeli, tbtr_hadiahkejutan, tbtr_salesbulanan
where prd_kodeigr = '$kodeigr'
     and nvl(prd_recordid,'9')<>'1'
     and nvl(prd_kodetag,'b') <> 'Z'
     and st_prdcd(+)=substr(prd_prdcd,0,6)||'0'
     and st_kodeigr(+)=prd_kodeigr
     and st_lokasi(+)='01'
     and prmd_prdcd(+)=prd_prdcd
     and prmd_kodeigr(+)=prd_kodeigr
     and prmd_tglawal(+) <= sysdate AND prmd_tglakhir(+) >= sysdate
     and div_kodedivisi = prd_kodedivisi
     and div_kodeigr=prd_kodeigr
--&AND_DIV
     and dep_kodedepartement = prd_kodedepartement
     and dep_kodedivisi = div_kodedivisi
     and dep_kodeigr = prd_kodeigr
--&AND_DEP
     and kat_kodekategori = prd_kodekategoribarang
     and kat_kodedepartement = dep_kodedepartement
     and kat_kodeigr= prd_kodeigr
--&AND_KAT
     and prd_kodedivisi||prd_kodedepartement||prd_kodekategoribarang between '$div1'||'$dep1'||'$kat1' and '$div2'||'$dep2'||'$kat2'
".$p_tagq."
     and prs_kodeigr = prd_kodeigr
     and hgb_prdcd(+)= substr(prd_prdcd,0,6)||'0'
     and hgb_kodeigr(+)= prd_kodeigr
     and hgb_kodeigr(+) = prd_kodeigr
     and spot_prdcd(+) = substr(prd_prdcd,0,6)||'0'
     and spot_kodeigr(+) =prd_kodeigr
     and spot_periodeawal(+) <= sysdate AND spot_periodeakhir(+) >= sysdate
     and sls_prdcd(+) = substr(prd_prdcd,0,6)||'0'
     and sls_kodeigr(+)= prd_kodeigr
".$p_orderby);
        dd($datas);

        $ac_margin = [];
        $lc_margin = [];
        $CF_mPrice = [];
        $CP_nJual = [];
        $cp_nHbMargin = [];
        $cp_nLcMargin = [];
        $cp_nAcMargin = [];
        $avgsls = [];

        for($i=0;$i<sizeof($datas);$i++){
            //### AC_MARGIN ###
            if($datas[$i]->unit == 'KG'){
                $multiplier = 1;
            }else{
                $multiplier = (int)$datas[$i]->frac;
            }
            if((float)$datas[$i]->price_a > 0){
                if($datas[$i]->pkp == 'Y' && ($datas[$i]->pkp2 != 'P' && $datas[$i]->pkp2 != 'W' && $datas[$i]->pkp2 != 'G')){
                    if($datas[$i]->prmd_prdcd != ''){
                        if($datas[$i]->fmjual != 0){
                            $nFmjual = (float)$datas[$i]->fmjual;
                        }elseif($datas[$i]->fmpotp != 0){
                            $nFmjual = (float)$datas[$i]->price_a - ((float)$datas[$i]->price_a * ((float)$datas[$i]->fmpotp/100));
                        }else{
                            $nFmjual = (float)$datas[$i]->price_a - (float)$datas[$i]->fmpotr;
                        }
                        if($nFmjual == 0){
                            $divisor = 1;
                        }else{
                            $divisor = $nFmjual;
                        }
                        if($datas[$i]->tag == 'Q'){
                            $nMargin = (1 - (((float)$datas[$i]->st_acost * $multiplier)) / $divisor ) * 100;
                        }else{
                            $nMargin = (1 - (((float)$datas[$i]->st_acost * $multiplier) / ($divisor / 1.1))) * 100;
                        }
                    }else{
                        if($datas[$i]->price_a == 0){
                            $divisor = 1;
                        }else{
                            $divisor = (float)$datas[$i]->price_a;
                        }
                        if($datas[$i]->tag == 'Q'){
                            $nMargin = (1 - (((float)$datas[$i]->st_acost * $multiplier)) / $divisor ) * 100;
                        }else{
                            $nMargin = (1 - (((float)$datas[$i]->st_acost * $multiplier) / ($divisor / 1.1))) * 100;
                        }
                    }
                }else{
                    if($datas[$i]->prmd_prdcd != ''){
                        if($datas[$i]->fmjual != 0){
                            $nFmjual = (float)$datas[$i]->fmjual;
                        }elseif($datas[$i]->fmpotp != 0){
                            $nFmjual = (float)$datas[$i]->price_a - ((float)$datas[$i]->price_a * ((float)$datas[$i]->fmpotp/100));
                        }else{
                            $nFmjual = (float)$datas[$i]->price_a - (float)$datas[$i]->fmpotr;
                        }
                        if($nFmjual == 0){
                            $divisor = 1;
                        }else{
                            $divisor = $nFmjual;
                        }
                        $nMargin = (1 - (((float)$datas[$i]->st_acost * $multiplier)) / $divisor ) * 100;
                    }else{
                        if($datas[$i]->price_a == 0){
                            $divisor = 1;
                        }else{
                            $divisor = (float)$datas[$i]->price_a;
                        }
                        $nMargin = (1 - (((float)$datas[$i]->st_acost * $multiplier)) / $divisor ) * 100;
                    }
                }
                $ac_margin[$i] = $nMargin;
            }else{
                $ac_margin[$i] = 0;
            }

//            //### LC_MARGIN ###
//            if($datas[$i]->unit == 'KG'){
//                $multiplier = 1;
//            }else{
//                $multiplier = (int)$datas[$i]->frac;
//            }
//            if((float)$datas[$i]->price_a > 0){
//                if($datas[$i]->pkp == 'Y' && ($datas[$i]->pkp2 != 'P' && $datas[$i]->pkp2 != 'W' && $datas[$i]->pkp2 != 'G')){
//                    if($datas[$i]->prmd_prdcd != ''){
//                        if($datas[$i]->fmjual != 0){
//                            $nFmjual = (float)$datas[$i]->fmjual;
//                        }elseif($datas[$i]->fmpotp != 0){
//                            $nFmjual = (float)$datas[$i]->price_a - ((float)$datas[$i]->price_a * ((float)$datas[$i]->fmpotp/100));
//                        }else{
//                            $nFmjual = (float)$datas[$i]->price_a - (float)$datas[$i]->fmpotr;
//                        }
//                        if($nFmjual == 0){
//                            $divisor = 1;
//                        }else{
//                            $divisor = $nFmjual;
//                        }
//                        if($datas[$i]->tag == 'Q'){
//                            $nMargin = (1 - (((float)$datas[$i]->prd_lastcost * $multiplier)) / $divisor ) * 100;
//                        }else{
//                            $nMargin = (1 - (((float)$datas[$i]->prd_lastcost * $multiplier) / ($divisor / 1.1))) * 100;
//                        }
//                    }else{
//                        if($datas[$i]->price_a == 0){
//                            $divisor = 1;
//                        }else{
//                            $divisor = (float)$datas[$i]->price_a;
//                        }
//                        if($datas[$i]->tag == 'Q'){
//                            $nMargin = (1 - (((float)$datas[$i]->prd_lastcost * $multiplier)) / $divisor ) * 100;
//                        }else{
//                            $nMargin = (1 - (((float)$datas[$i]->prd_lastcost * $multiplier) / ($divisor / 1.1))) * 100;
//                        }
//                    }
//                }else{
//                    if($datas[$i]->prmd_prdcd != ''){
//                        if($datas[$i]->fmjual != 0){
//                            $nFmjual = (float)$datas[$i]->fmjual;
//                        }elseif($datas[$i]->fmpotp != 0){
//                            $nFmjual = (float)$datas[$i]->price_a - ((float)$datas[$i]->price_a * ((float)$datas[$i]->fmpotp/100));
//                        }else{
//                            $nFmjual = (float)$datas[$i]->price_a - (float)$datas[$i]->fmpotr;
//                        }
//                        if($nFmjual == 0){
//                            $divisor = 1;
//                        }else{
//                            $divisor = $nFmjual;
//                        }
//                        $nMargin = (1 - (((float)$datas[$i]->prd_lastcost * $multiplier)) / $divisor ) * 100;
//                    }else{
//                        if($datas[$i]->price_a == 0){
//                            $divisor = 1;
//                        }else{
//                            $divisor = (float)$datas[$i]->price_a;
//                        }
//                        $nMargin = (1 - (((float)$datas[$i]->prd_lastcost * $multiplier)) / $divisor ) * 100;
//                    }
//                }
//                $lc_margin[$i] = $nMargin;
//            }else{
//                $lc_margin[$i] = 0;
//            }

            //### $CF_mPrice ###
            $nDisc1 = 0;
            $nDisc2 = 0;
            $mPrice = 0;
            $nQty = 1;
            if($datas[$i]->unit == 'KG'){
                $divisor = 1000;
            }else{
                $divisor = 1;
            }
            $nPrice = (float)$datas[$i]->fmbeli * (int)$datas[$i]->frac/$divisor;

            $nDiscp1 = $datas[$i]->fmdirp;
            $nDiscr1 = $datas[$i]->fmdirr;
            $cFdisc1 = $datas[$i]->fmdirs;
            $cFdisc2 = $datas[$i]->fmdirs2;

            $nDiscp2 = $datas[$i]->fmditp;
            $nDiscr2 = $datas[$i]->fmditr;
            if($nDiscp1 != 0){
                $nDiscr1 = 0;
                $cFdisc1 = ' ';
                $nDisc1  = (float)$nDiscp1 * $nPrice / 100;
            }else{
                if($cFdisc1 == 'B'){
                    $nDisc1 = $nQty * (float)$nDiscr1;
                }else{
                    if($datas[$i]->unit != 'KG'){
                        $nDisc1 = ($nQty * (int)$datas[$i]->frac ) * (float)$nDiscr1;
                    }else{
                        $nDisc1 = $nQty * (float)$nDiscr1 / (int)$datas[$i]->frac;
                    }
                }
            }

            if($nDiscp2 != 0){
                $nDiscr2 = 0;
                $cFdisc2 = ' ';
                $nDisc2 = (float)$nDiscp2 * ($nPrice - $nDisc1 ) / 100;
            }else{
               if($cFdisc2 == 'B'){
                   $nDisc2 = $nQty * (float)$nDiscr2;
               }else{
                   if($datas[$i]->unit != 'KG'){
                       $nDisc2 = ($nQty * (int)$datas[$i]->frac ) * (float)$nDiscr2;
                   }else{
                       $nDisc2 = $nQty * (float)$nDiscr2 / (int)$datas[$i]->frac;
                   }
               }
            }

            $nDiscrp = $nDisc1 + $nDisc2;
            $mPrice  = $nPrice - $nDiscrp;

            $CF_mPrice[$i]=$mPrice;

            //### nJual ###
            $nJual = 0;
            if($datas[$i]->unit == 'KG'){
                $multiplier = 1;
            }else{
                $multiplier = (int)$datas[$i]->frac;
            }
            if($datas[$i]->pkp == 'Y' && $datas[$i]->pkp != 'P'){
                if($datas[$i]->prmd_prdcd != ''){
                    if($datas[$i]->fmjual != 0){
                        $nJual = (float)$datas[$i]->fmjual;
                    }elseif($datas[$i]->fmpotp != 0){
                        $nJual = (float)$datas[$i]->price_a - ((float)$datas[$i]->price_a * ((float)$datas[$i]->fmptop / 100));
                    }else{
                        $nJual = (float)$datas[$i]->price_a - (float)$datas[$i]->fmpotr;
                    }

                    if($nJual == 0){
                        $divisor = 1;
                    }else{
                        $divisor = $nJual;
                    }
                    if($datas[$i]->tag == 'Q'){
                        $nLcMargin = (1-((float)$datas[$i]->prd_lastcost / $divisor)) * 100;
                        $nAcMargin = (1-(((float)$datas[$i]->st_acost * $multiplier)/$divisor))*100;
                        $nHbMargin = (1-($CF_mPrice[$i]/$divisor)) * 100;
                    }else{
                        $nLcMargin = (1- ((float)$datas[$i]->prd_lastcost / ($divisor / 1.1))) * 100;
                        $nAcMargin = (1 - (((float)$datas[$i]->st_acost * $multiplier)/($divisor / 1.1))) * 100;
                        $nHbMargin = (1 - ($CF_mPrice[$i] / ($divisor / 1.1))) *100;
                    }
                }else{
                    if($datas[$i]->price_a == 0){
                        $divisor = 1;
                    }else{
                        $divisor = (float)$datas[$i]->price_a;
                    }
                    if($datas[$i]->tag == 'Q'){
                        $nLcMargin = (1-((float)$datas[$i]->prd_lastcost / $divisor)) * 100;
                        $nAcMargin = (1-(((float)$datas[$i]->st_acost * $multiplier)/$divisor))*100;
                        $nHbMargin = (1-($CF_mPrice[$i]/$divisor)) * 100;
                    }else{
                        $nLcMargin = (1- ((float)$datas[$i]->prd_lastcost / ($divisor / 1.1))) * 100;
                        $nAcMargin = (1 - (((float)$datas[$i]->st_acost * $multiplier)/($divisor / 1.1))) * 100;
                        $nHbMargin = (1 - ($CF_mPrice[$i] / ($divisor / 1.1))) *100;
                    }
                }
            }else{
                if($datas[$i]->prmd_prdcd != ''){
                    if($datas[$i]->fmjual != 0){
                        $nJual = (float)$datas[$i]->fmjual;
                    }elseif($datas[$i]->fmpotp != 0){
                        $nJual = (float)$datas[$i]->price_a - ((float)$datas[$i]->price_a * ((float)$datas[$i]->fmptop / 100));
                    }else{
                        $nJual = (float)$datas[$i]->price_a - (float)$datas[$i]->fmpotr;
                    }
                    if($nJual == 0){
                        $divisor = 1;
                    }else{
                        $divisor = $nJual;
                    }
                    $nLcMargin = (1-((float)$datas[$i]->prd_lastcost / $divisor)) * 100;
                    $nAcMargin = (1-(((float)$datas[$i]->st_acost * $multiplier)/$divisor))*100;
                    $nHbMargin = (1-($CF_mPrice[$i]/$divisor)) * 100;
                }else{
                    if($datas[$i]->price_a == 0){
                        $divisor = 1;
                    }else{
                        $divisor = (float)$datas[$i]->price_a;
                    }
                    $nLcMargin = (1-((float)$datas[$i]->prd_lastcost / $divisor)) * 100;
                    $nAcMargin = (1-(((float)$datas[$i]->st_acost * $multiplier)/$divisor))*100;
                    $nHbMargin = (1-($CF_mPrice[$i]/$divisor)) * 100;
                }
            }
            $CP_nJual[$i] = $nJual;
            $cp_nHbMargin[$i] = $nHbMargin;
            $cp_nLcMargin[$i] = $nLcMargin;
            $cp_nAcMargin[$i] = $nAcMargin;

            //CF_AVGSLS

            if($datas[$i]->sls_prdcd != ''){
                $prdcd = $datas[$i]->prd_prdcd;
                $holder = '';
                $connect = loginController::getConnectionProcedure();
                $query = oci_parse($connect, "BEGIN igr_bo_daftar_margin_negatif(sysdate, '$prdcd', '$kodeigr', :temp); END;");
                oci_bind_by_name($query, ':temp', $holder, 9999999);
                oci_execute($query);
                $avgsls[$i] = $holder;
            }else{
                $avgsls[$i] = 0;
            }
        }

        //PRINT
        $perusahaan = DB::table("tbmaster_perusahaan")->first();
        if((int)$sort < 3){
            //CETAK_MARGINNEGATIF
            return view('BACKOFFICE.LISTMASTERASSET.LAPORAN.daftar-margin-negatif-pdf',
                ['kodeigr' => $kodeigr, 'data' => $datas, 'perusahaan' => $perusahaan,
                    'urut' => $p_urut, 'tag' => $ptag, 'ac_margin' => $ac_margin,'cf_mprice' => $CF_mPrice,
                    'cp_njual' => $CP_nJual, 'cp_nhbmargin' => $cp_nHbMargin, 'cp_nlcmargin' => $cp_nLcMargin, 'cp_nacmargin' => $cp_nAcMargin, 'avgsls' => $avgsls]);
        }else{
            //CETAK_MARGINNEGATIFNAMA
            return view('BACKOFFICE.LISTMASTERASSET.LAPORAN.daftar-margin-negatif-nama-pdf',
                ['kodeigr' => $kodeigr, 'data' => $datas, 'perusahaan' => $perusahaan,
                    'urut' => $p_urut, 'tag' => $ptag, 'ac_margin' => $ac_margin,'cf_mprice' => $CF_mPrice,
                    'cp_njual' => $CP_nJual, 'cp_nhbmargin' => $cp_nHbMargin, 'cp_nlcmargin' => $cp_nLcMargin, 'cp_nacmargin' => $cp_nAcMargin, 'avgsls' => $avgsls]);
        }
    }

    public function printDaftarSupplier(Request $request)
    {
        $kodeigr = Session::get('kdigr');

        $sup1 = $request->sup1;
        if ($sup1 == '') {
            $temp = DB::connection(Session::get('connection'))->table("tbmaster_supplier")
                ->selectRaw("min(sup_kodesupplier) as result")
                ->where("sup_kodeigr", '=', $kodeigr)
                ->first();
            $sup1 = $temp->result;
        }
        $sup2 = $request->sup2;
        if ($sup2 == '') {
            $temp = DB::connection(Session::get('connection'))->table("tbmaster_supplier")
                ->selectRaw("max(sup_kodesupplier) as result")
                ->where("sup_kodeigr", '=', $kodeigr)
                ->first();
            $sup2 = $temp->result;
        }

        $datas = $datas = DB::connection(Session::get('connection'))->table("tbmaster_supplier")
            ->selectRaw("sup_kodesupplier")
            ->selectRaw("sup_namasupplier")
            ->selectRaw("sup_npwp")
            ->selectRaw("sup_nosk")
            ->selectRaw("sup_tglsk")
            ->selectRaw("sup_alamatsupplier1||' '||sup_kotasupplier3||' Telp : '||sup_telpsupplier alamat")
            ->selectRaw("sup_top")
            ->selectRaw("sup_contactperson")
            ->where("sup_kodeigr",'=',$kodeigr)
            ->whereRaw("sup_kodesupplier between '$sup1' and '$sup2'")
            ->orderBy("sup_kodesupplier")
            ->get();

        //CETAK_DAFTARSUPPLIER(IGR_BO_DAFTARSUPPLIER.jsp)
        $perusahaan = DB::table("tbmaster_perusahaan")->first();
        return view('BACKOFFICE.LISTMASTERASSET.LAPORAN.daftar-supplier-pdf',
            ['kodeigr' => $kodeigr, 'data' => $datas, 'perusahaan' => $perusahaan]);
    }

    public function printDaftarMember(Request $request)
    {
        $kodeigr = Session::get('kdigr');
        $outlet = $request->outlet;
        $mem1 = $request->mem1;
        if ($mem1 == '') {
            $temp = DB::connection(Session::get('connection'))->table("tbmaster_customer")
                ->selectRaw("min(cus_kodemember) as result")
                ->where("cus_kodeigr", '=', $kodeigr)
                ->whereRaw("nvl(cus_recordid,'9')<>'1'")
                ->first();
            $mem1 = $temp->result;
        }
        $mem2 = $request->mem2;
        if ($mem2 == '') {
            $temp = DB::connection(Session::get('connection'))->table("tbmaster_customer")
                ->selectRaw("max(cus_kodemember) as result")
                ->where("cus_kodeigr", '=', $kodeigr)
                ->whereRaw("nvl(cus_recordid,'9')<>'1'")
                ->first();
            $mem2 = $temp->result;
        }

        $sort = $request->sort;
        if($sort == 1){
            $urut = "URUT: OUTLET+AREA+KODE";
            $and_orderby = " ORDER BY CUS_KODEOUTLET, cus_kodesuboutlet, CUS_KODEAREA, CUS_KODEMEMBER";
        }elseif($sort == 2){
            $urut = "URUT: OUTLET+AREA+NAMA";
            $and_orderby = " ORDER BY CUS_KODEOUTLET, cus_KODEAREA, CUS_NAMAMEMBER";
        }elseif($sort == 3){
            $urut = "URUT: OUTLET+KODE";
            $and_orderby = " ORDER BY CUS_KODEOUTLET, cus_kodesuboutlet, CUS_KODEMEMBER";
        }elseif($sort == 4){
            $urut = "URUT: OUTLET+NAMA";
            $and_orderby = " ORDER BY CUS_KODEOUTLET, cus_kodesuboutlet, CUS_NAMAMEMBER";
        }elseif($sort == 5){
            $urut = "URUT: AREA+KODE";
            $and_orderby = " ORDER BY CUS_KODEAREA, CUS_KODEMEMBER";
        }elseif($sort == 6){
            $urut = "URUT: AREA+NAMA";
            $and_orderby = " ORDER BY CUS_KODEAREA, CUS_NAMAMEMBER";
        }elseif($sort == 7){
            $urut = "URUT: KODE";
            $and_orderby = " ORDER BY CUS_KODEMEMBER";
        }elseif($sort == 8){
            $urut = "URUT: NAMA";
            $and_orderby = " ORDER BY CUS_NAMAMEMBER";
        }else{
            $urut = "URUT: KODE";
            $and_orderby = " ORDER BY CUS_KODEMEMBER";
        }

        $pilihan = $request->pilihan;
        if($pilihan == 3){
            $and_pilih = " and add_months(nvl(cus_tglregistrasi,sysdate),12) <= trunc(sysdate) ";
            $and_recid = " and nvl(cus_recordid,'9')<>'1' ";
        }elseif($pilihan == 2){
            $and_pilih = " and add_months(nvl(cus_tglregistrasi,sysdate),12) > trunc(sysdate) ";
            $and_recid = " and nvl(cus_recordid,'9')<>'1'";
            //$mbr_expired = " "; //tak tau fungsi mbr ini, di program lama hanya ada di pilihan 2 seperti ini
        }else{
            $and_pilih = " ";
            $and_recid = " ";
        }

        $sub1 = $request->suboutlet1;
        $sub2 = $request->suboutlet2;
        if($sub1 != '' && $sub2 != ''){
            $and_sub = " and CUS_KODESUBOUTLET(+) BETWEEN ".$sub1." AND ".$sub2;
        }else{
            $and_sub = " ";
        }

        $datas = $datas = DB::connection(Session::get('connection'))->select("select lpad(cus_kodemember,6,'0') kd, cus_nokartumember kartu, cus_namamember,
cus_alamatmember1||' '||cus_alamatmember2 alamat, cus_tlpmember telp, nvl(cus_flagpkp,'T') pkp,
cus_npwp, cus_creditlimit, cus_top top, cus_kodearea area1, cus_kodeoutlet kodeoutlet,
cus_jenismember,out_kodeoutlet||'-'||out_namaoutlet outlet, sub_kodesuboutlet||'-'||sub_namasuboutlet suboutlet,
prs_namaperusahaan, prs_namacabang, cus_kodearea area2
from tbmaster_customer, tbmaster_perusahaan, tbmaster_outlet, tbmaster_suboutlet
where cus_kodeigr='$kodeigr'
".$and_recid."
and cus_kodemember between '$mem1' and '$mem2'
and nvl(CUS_KODEOUTLET,0) = '$outlet'
".$and_sub."
and prs_kodeigr=cus_kodeigr
--&mbr_expired
and out_kodeoutlet = cus_kodeoutlet
and out_kodeigr=cus_kodeigr
and sub_kodeoutlet(+)=cus_kodeoutlet
and sub_kodeigr(+)=cus_kodeigr
and sub_kodesuboutlet(+) = cus_kodesuboutlet".
$and_pilih.
$and_orderby);

        //PROCEDURE IGR_BO_CONTS (:P_KODEIGR, 'AA', :AREA2, TEMP);
        $area = [];
        for($i=0;$i<sizeof($datas);$i++){
            try{
                $tipearea = 'AA'.$datas[$i]->area2;
                $temp = DB::connection(Session::get('connection'))->table("tbmaster_const")
                    ->selectRaw("consT_name")
                    ->where("const_kodeigr",'=',$kodeigr)
                    ->where("const_branch",'=',$tipearea)
                    ->first();
                if($temp){
                    $area[$i] = $temp->const_name;
                }else{
                    $area[$i] = " ";
                }
            }catch (\Exception $e){
                $area[$i] = " ";
            }

        }

        //CETAK_DAFTARSUPPLIER(IGR_BO_DAFTARSUPPLIER.jsp)
        $perusahaan = DB::table("tbmaster_perusahaan")->first();

        return view('BACKOFFICE.LISTMASTERASSET.LAPORAN.daftar-anggota-or-member-pdf',
            ['kodeigr' => $kodeigr, 'data' => $datas, 'perusahaan' => $perusahaan,
                'urut' => $urut, 'p_area' => $area, 'sort' => $sort]);
    }

    public function printDaftarMemberTypeOutlet(Request $request)
    {
        $kodeigr = Session::get('kdigr');
        $outlet1 = $request->outlet1;
        $outlet2 = $request->outlet2;
        $member1 = $request->member1;
        $member2 = $request->member2;

        if ($outlet1 == '') {
            $temp = DB::connection(Session::get('connection'))->table("tbmaster_outlet")
                ->selectRaw("min(out_kodeoutlet) as result")
                ->where("out_kodeigr", '=', $kodeigr)
                ->first();
            $outlet1 = $temp->result;
        }
        if ($outlet2 == '') {
            $temp = DB::connection(Session::get('connection'))->table("tbmaster_outlet")
                ->selectRaw("max(out_kodeoutlet) as result")
                ->where("out_kodeigr", '=', $kodeigr)
                ->first();
            $outlet2 = $temp->result;
        }
        if ($member1 == '') {
            $temp = DB::connection(Session::get('connection'))->table("tbmaster_customer")
                ->selectRaw("min(cus_kodemember) as result")
                ->where("cus_kodeigr", '=', $kodeigr)
                ->first();
            $member1 = $temp->result;
        }
        if ($member2 == '') {
            $temp = DB::connection(Session::get('connection'))->table("tbmaster_customer")
                ->selectRaw("max(cus_kodemember) as result")
                ->where("cus_kodeigr", '=', $kodeigr)
                ->first();
            $member2 = $temp->result;
        }

        $datas = DB::select("select lpad(cus_kodemember,6,'0') kd, cus_nokartumember, cus_namamember,
cus_alamatmember1||' '||cus_alamatmember2 alamat, cus_tlpmember, cus_flagpkp, cus_npwp, cus_creditlimit,
cus_top, cus_kodearea, cus_kodeoutlet,
prs_namaperusahaan, prs_namacabang,
out_kodeoutlet||'-'||out_namaoutlet outlet
from tbmaster_customer, tbmaster_perusahaan, tbmaster_outlet
where cus_kodeigr = '$kodeigr'
and cus_kodeoutlet between '$outlet1' and '$outlet2'
and nvl(cus_recordid,'9')<>'1'
and lpad(cus_kodemember,6,'0') between lpad('$member1',6,'0') and lpad('$member2',6,'0')
and add_months(cus_tglregistrasi,12) <= trunc(sysdate)
and prs_kodeigr=cus_kodeigr
and out_kodeigr = cus_kodeigr
and out_kodeoutlet= cus_kodeoutlet
order by CUS_KODEOUTLET, cus_kodemember");

        //CETAK_DAFTARSUPPLIER(IGR_BO_DAFTARSUPPLIER.jsp)
        $perusahaan = DB::table("tbmaster_perusahaan")->first();

        return view('BACKOFFICE.LISTMASTERASSET.LAPORAN.daftar-anggota-or-type-outlet-pdf',
            ['kodeigr' => $kodeigr, 'data' => $datas, 'perusahaan' => $perusahaan]);
    }

    public function printDaftarMemberBaru(Request $request)
    {
        $kodeigr = Session::get('kdigr');
        $member1 = $request->member1;
        $member2 = $request->member2;
        $sort = $request->sort;
        $sDate = $request->date1;
        $eDate = $request->date2;
        $sDate = DateTime::createFromFormat('d-m-Y', $sDate)->format('d-M-Y');
        $eDate = DateTime::createFromFormat('d-m-Y', $eDate)->format('d-M-Y');

        if ($member1 == '') {
            $temp = DB::connection(Session::get('connection'))->table("tbmaster_customer")
                ->selectRaw("min(cus_kodemember) as result")
                ->where("cus_kodeigr", '=', $kodeigr)
                ->first();
            $member1 = $temp->result;
        }
        if ($member2 == '') {
            $temp = DB::connection(Session::get('connection'))->table("tbmaster_customer")
                ->selectRaw("max(cus_kodemember) as result")
                ->where("cus_kodeigr", '=', $kodeigr)
                ->first();
            $member2 = $temp->result;
        }

        if($sort == 1){
            $urut = "URUT: OUTLET+AREA+KODE";
            $and_orderby = " ORDER BY CUS_KODEOUTLET, cus_kodesuboutlet, CUS_KODEAREA, CUS_KODEMEMBER";
        }elseif($sort == 2){
            $urut = "URUT: OUTLET+AREA+NAMA";
            $and_orderby = " ORDER BY CUS_KODEOUTLET, cus_KODEAREA, CUS_NAMAMEMBER";
        }elseif($sort == 3){
            $urut = "URUT: OUTLET+KODE";
            $and_orderby = " ORDER BY CUS_KODEOUTLET, cus_kodesuboutlet, CUS_KODEMEMBER";
        }elseif($sort == 4){
            $urut = "URUT: OUTLET+NAMA";
            $and_orderby = " ORDER BY CUS_KODEOUTLET, cus_kodesuboutlet, CUS_NAMAMEMBER";
        }elseif($sort == 5){
            $urut = "URUT: AREA+KODE";
            $and_orderby = " ORDER BY CUS_KODEAREA, CUS_KODEMEMBER";
        }elseif($sort == 6){
            $urut = "URUT: AREA+NAMA";
            $and_orderby = " ORDER BY CUS_KODEAREA, CUS_NAMAMEMBER";
        }elseif($sort == 7){
            $urut = "URUT: KODE";
            $and_orderby = " ORDER BY CUS_KODEMEMBER";
        }elseif($sort == 8){
            $urut = "URUT: NAMA";
            $and_orderby = " ORDER BY CUS_NAMAMEMBER";
        }else{
            $urut = "URUT: KODE";
            $and_orderby = " ORDER BY CUS_KODEMEMBER";
        }

        $datas = DB::connection(Session::get('connection'))->select("select lpad(cus_kodemember,6,'0') kd, cus_nokartumember, cus_namamember,
cus_alamatmember1||' '||cus_alamatmember2||case when cus_tlpmember is null then ' ' else  ' Telp.'||cus_tlpmember end alamat,
cus_tlpmember, cus_flagpkp, cus_npwp, cus_creditlimit,
cus_top, cus_kodearea area1, cus_kodearea area2, cus_kodeoutlet,
prs_namaperusahaan, prs_namacabang,
out_kodeoutlet||'-'||out_namaoutlet outlet
from tbmaster_customer, tbmaster_perusahaan, tbmaster_outlet
where cus_kodeigr = '$kodeigr'
--and cus_tglregistrasi = cus_tglmulai
and cus_kodemember between '$member1' and '$member2'
and cus_tglregistrasi between TO_DATE('$sDate','DD-MM-YYYY') and TO_DATE('$eDate','DD-MM-YYYY')
and nvl(cus_recordid,'9')<>'1'
and prs_kodeigr=cus_kodeigr
and out_kodeigr(+) = cus_kodeigr
and out_kodeoutlet(+)= cus_kodeoutlet
".$and_orderby);

        //PROCEDURE IGR_BO_CONTS (:P_KODEIGR, 'AA', :AREA2, TEMP);
        $area = [];
        for($i=0;$i<sizeof($datas);$i++){
            try{
                $tipearea = 'AA'.$datas[$i]->area1;
                $temp = DB::connection(Session::get('connection'))->table("tbmaster_const")
                    ->selectRaw("consT_name")
                    ->where("const_kodeigr",'=',$kodeigr)
                    ->where("const_branch",'=',$tipearea)
                    ->first();
                if($temp){
                    $area[$i] = $temp->const_name;
                }else{
                    $area[$i] = " ";
                }
            }catch (\Exception $e){
                $area[$i] = " ";
            }
        }

        //PRINT
        $perusahaan = DB::table("tbmaster_perusahaan")->first();

        return view('BACKOFFICE.LISTMASTERASSET.LAPORAN.daftar-anggota-or-member-baru-pdf',
            ['kodeigr' => $kodeigr, 'data' => $datas, 'perusahaan' => $perusahaan,
                'urut' => $urut, 'p_area' => $area, 'sort' => $sort, 'date1' => $sDate, 'date2' => $eDate]);
    }

    public function printDaftarMemberJatuhTempo(Request $request)
    {
        $kodeigr = Session::get('kdigr');
        $member1 = $request->member1;
        $member2 = $request->member2;
        $sort = $request->sort;
        $sDate = $request->date1;
        $eDate = $request->date2;
        $sDate = DateTime::createFromFormat('d-m-Y', $sDate)->format('d-M-Y');
        $eDate = DateTime::createFromFormat('d-m-Y', $eDate)->format('d-M-Y');

        if ($member1 == '') {
            $temp = DB::connection(Session::get('connection'))->table("tbmaster_customer")
                ->selectRaw("min(cus_kodemember) as result")
                ->where("cus_kodeigr", '=', $kodeigr)
                ->first();
            $member1 = $temp->result;
        }
        if ($member2 == '') {
            $temp = DB::connection(Session::get('connection'))->table("tbmaster_customer")
                ->selectRaw("max(cus_kodemember) as result")
                ->where("cus_kodeigr", '=', $kodeigr)
                ->first();
            $member2 = $temp->result;
        }

        if($sort == 1){
            $urut = "URUT: OUTLET+AREA+KODE";
            $and_orderby = " ORDER BY CUS_KODEOUTLET, cus_kodesuboutlet, CUS_KODEAREA, CUS_KODEMEMBER";
        }elseif($sort == 2){
            $urut = "URUT: OUTLET+AREA+NAMA";
            $and_orderby = " ORDER BY CUS_KODEOUTLET, cus_KODEAREA, CUS_NAMAMEMBER";
        }elseif($sort == 3){
            $urut = "URUT: OUTLET+KODE";
            $and_orderby = " ORDER BY CUS_KODEOUTLET, cus_kodesuboutlet, CUS_KODEMEMBER";
        }elseif($sort == 4){
            $urut = "URUT: OUTLET+NAMA";
            $and_orderby = " ORDER BY CUS_KODEOUTLET, cus_kodesuboutlet, CUS_NAMAMEMBER";
        }elseif($sort == 5){
            $urut = "URUT: AREA+KODE";
            $and_orderby = " ORDER BY CUS_KODEAREA, CUS_KODEMEMBER";
        }elseif($sort == 6){
            $urut = "URUT: AREA+NAMA";
            $and_orderby = " ORDER BY CUS_KODEAREA, CUS_NAMAMEMBER";
        }elseif($sort == 7){
            $urut = "URUT: KODE";
            $and_orderby = " ORDER BY CUS_KODEMEMBER";
        }elseif($sort == 8){
            $urut = "URUT: NAMA";
            $and_orderby = " ORDER BY CUS_NAMAMEMBER";
        }else{
            $urut = "URUT: KODE";
            $and_orderby = " ORDER BY CUS_KODEMEMBER";
        }

        $datas = DB::connection(Session::get('connection'))->select("select lpad(cus_kodemember,6,'0') kd, cus_nokartumember, cus_namamember,
cus_alamatmember1||' '||cus_alamatmember2||case when cus_tlpmember is null then ' ' else  ' Telp.'||cus_tlpmember end alamat,
cus_tlpmember, cus_flagpkp, cus_npwp, cus_creditlimit,
cus_top, cus_kodearea area1, cus_kodearea area2, cus_kodeoutlet,
prs_namaperusahaan, prs_namacabang,
out_kodeoutlet||'-'||out_namaoutlet outlet, cus_tglregistrasi
from tbmaster_customer, tbmaster_perusahaan, tbmaster_outlet
where cus_kodeigr = '$kodeigr'
--and cus_tglregistrasi = cus_tglmulai
and cus_kodemember between '$member1' and '$member2'
and cus_tglregistrasi between TO_DATE('$sDate','DD-MM-YYYY') and TO_DATE('$eDate','DD-MM-YYYY')
and nvl(cus_recordid,'9')<>'1'
and prs_kodeigr=cus_kodeigr
and out_kodeigr(+) = cus_kodeigr
and out_kodeoutlet(+)= cus_kodeoutlet
".$and_orderby);

        //PROCEDURE IGR_BO_CONTS (:P_KODEIGR, 'AA', :AREA2, TEMP);
        $area = [];
        for($i=0;$i<sizeof($datas);$i++){
            try{
                $tipearea = 'AA'.$datas[$i]->area1;
                $temp = DB::connection(Session::get('connection'))->table("tbmaster_const")
                    ->selectRaw("consT_name")
                    ->where("const_kodeigr",'=',$kodeigr)
                    ->where("const_branch",'=',$tipearea)
                    ->first();
                if($temp){
                    $area[$i] = $temp->const_name;
                }else{
                    $area[$i] = " ";
                }
            }catch (\Exception $e){
                $area[$i] = " ";
            }
        }

        //PRINT
        $perusahaan = DB::table("tbmaster_perusahaan")->first();

        return view('BACKOFFICE.LISTMASTERASSET.LAPORAN.daftar-anggota-or-member-jatuh-tempo-pdf',
            ['kodeigr' => $kodeigr, 'data' => $datas, 'perusahaan' => $perusahaan,
                'urut' => $urut, 'p_area' => $area, 'sort' => $sort, 'date1' => $sDate, 'date2' => $eDate]);
    }

    public function printDaftarMemberExpired(Request $request)
    {
        set_time_limit(0);
        $kodeigr = Session::get('kdigr');
        $member1 = $request->member1;
        $member2 = $request->member2;
        $sort = $request->sort;

        if ($member1 == '') {
            $temp = DB::connection(Session::get('connection'))->table("tbmaster_customer")
                ->selectRaw("min(cus_kodemember) as result")
                ->where("cus_kodeigr", '=', $kodeigr)
                ->first();
            $member1 = $temp->result;
        }
        if ($member2 == '') {
            $temp = DB::connection(Session::get('connection'))->table("tbmaster_customer")
                ->selectRaw("max(cus_kodemember) as result")
                ->where("cus_kodeigr", '=', $kodeigr)
                ->first();
            $member2 = $temp->result;
        }

        if($sort == 1){
            $urut = "URUT: OUTLET+AREA+KODE";
            $and_orderby = " ORDER BY CUS_KODEOUTLET, cus_kodesuboutlet, CUS_KODEAREA, CUS_KODEMEMBER";
        }elseif($sort == 2){
            $urut = "URUT: OUTLET+AREA+NAMA";
            $and_orderby = " ORDER BY CUS_KODEOUTLET, cus_KODEAREA, CUS_NAMAMEMBER";
        }elseif($sort == 3){
            $urut = "URUT: OUTLET+KODE";
            $and_orderby = " ORDER BY CUS_KODEOUTLET, cus_kodesuboutlet, CUS_KODEMEMBER";
        }elseif($sort == 4){
            $urut = "URUT: OUTLET+NAMA";
            $and_orderby = " ORDER BY CUS_KODEOUTLET, cus_kodesuboutlet, CUS_NAMAMEMBER";
        }elseif($sort == 5){
            $urut = "URUT: AREA+KODE";
            $and_orderby = " ORDER BY CUS_KODEAREA, CUS_KODEMEMBER";
        }elseif($sort == 6){
            $urut = "URUT: AREA+NAMA";
            $and_orderby = " ORDER BY CUS_KODEAREA, CUS_NAMAMEMBER";
        }elseif($sort == 7){
            $urut = "URUT: KODE";
            $and_orderby = " ORDER BY CUS_KODEMEMBER";
        }elseif($sort == 8){
            $urut = "URUT: NAMA";
            $and_orderby = " ORDER BY CUS_NAMAMEMBER";
        }else{
            $urut = "URUT: KODE";
            $and_orderby = " ORDER BY CUS_KODEMEMBER";
        }

        $datas = DB::connection(Session::get('connection'))->select("select lpad(cus_kodemember,6,'0') kd, cus_nokartumember, cus_namamember,
cus_alamatmember1||' '||cus_alamatmember2 alamat, cus_tlpmember, cus_flagpkp, cus_npwp, cus_creditlimit,
cus_top, cus_kodearea area1, cus_kodearea area2, cus_kodeoutlet, cus_tglregistrasi,
prs_namaperusahaan, prs_namacabang,
out_kodeoutlet||'-'||out_namaoutlet outlet
from tbmaster_customer, tbmaster_perusahaan, tbmaster_outlet
where cus_kodeigr = '$kodeigr'
and nvl(cus_recordid,'9')='1'
and cus_kodemember between '$member1' and '$member2'
and prs_kodeigr=cus_kodeigr
and out_kodeigr = cus_kodeigr
and out_kodeoutlet= cus_kodeoutlet
".$and_orderby);
        //PROCEDURE IGR_BO_CONTS (:P_KODEIGR, 'AA', :AREA2, TEMP);
        $area = [];
        for($i=0;$i<sizeof($datas);$i++){
            try{
                $tipearea = 'AA'.$datas[$i]->area1;
                $temp = DB::connection(Session::get('connection'))->table("tbmaster_const")
                    ->selectRaw("consT_name")
                    ->where("const_kodeigr",'=',$kodeigr)
                    ->where("const_branch",'=',$tipearea)
                    ->first();
                if($temp){
                    $area[$i] = $temp->const_name;
                }else{
                    $area[$i] = " ";
                }
            }catch (\Exception $e){
                $area[$i] = " ";
            }
        }

        //PRINT
        $perusahaan = DB::table("tbmaster_perusahaan")->first();

        return view('BACKOFFICE.LISTMASTERASSET.LAPORAN.daftar-anggota-or-member-expired-pdf',
            ['kodeigr' => $kodeigr, 'data' => $datas, 'perusahaan' => $perusahaan,
                'urut' => $urut, 'p_area' => $area, 'sort' => $sort]);
    }
    public function printDaftarHargaJualBaru(Request $request)
    {
        $kodeigr = Session::get('kdigr');
        $div1 = $request->div1;
        if($div1 == ''){
            $temp = DB::connection(Session::get('connection'))->table("tbmaster_divisi")
                ->selectRaw("min(div_kodedivisi) as result")
                ->where("div_kodeigr",'=',$kodeigr)
                ->first();
            $div1 = $temp->result;
        }
        $div2 = $request->div2;
        if($div2 == ''){
            $temp = DB::connection(Session::get('connection'))->table("tbmaster_divisi")
                ->selectRaw("max(div_kodedivisi) as result")
                ->where("div_kodeigr",'=',$kodeigr)
                ->first();
            $div2 = $temp->result;
        }
        $dep1 = $request->dep1;
        if($dep1 == ''){
            $temp = DB::connection(Session::get('connection'))->table("tbmaster_departement")
                ->selectRaw("min(dep_kodedepartement) as result")
                ->where("dep_kodeigr",'=',$kodeigr)
                ->where("dep_kodedivisi",'=',$div1)
                ->first();
            $dep1 = $temp->result;
        }
        $dep2 = $request->dep2;
        if($dep2 == ''){
            $temp = DB::connection(Session::get('connection'))->table("tbmaster_departement")
                ->selectRaw("max(dep_kodedepartement) as result")
                ->where("dep_kodeigr",'=',$kodeigr)
                ->where("dep_kodedivisi",'=',$div2)
                ->first();
            $dep2 = $temp->result;
        }
        $kat1 = $request->kat1;
        if($kat1 == ''){
            $temp = DB::connection(Session::get('connection'))->table("tbmaster_kategori")
                ->selectRaw("min(kat_kodekategori) as result")
                ->where("kat_kodeigr",'=',$kodeigr)
                ->where("kat_kodedepartement",'=',$dep1)
                ->first();
            $kat1 = $temp->result;
        }
        $kat2 = $request->kat2;
        if($kat2 == ''){
            $temp = DB::connection(Session::get('connection'))->table("tbmaster_kategori")
                ->selectRaw("max(kat_kodekategori) as result")
                ->where("kat_kodeigr",'=',$kodeigr)
                ->where("kat_kodedepartement",'=',$dep2)
                ->first();
            $kat2 = $temp->result;
        }
        $check = $request->check;
        $sort = $request->sort;
        $tag1 = $request->tag1;
        $tag2 = $request->tag2;
        $sDate = $request->date1;
        $eDate = $request->date2;
        $sDate = DateTime::createFromFormat('d-m-Y', $sDate)->format('d-M-Y');
        $eDate = DateTime::createFromFormat('d-m-Y', $eDate)->format('d-M-Y');

        if($sort == '1'){
            $urut = "URUT  : DIV+DEPT+KATEGORI+KODE";
            $p_orderby = " order by prd_kodedivisi, prd_kodedepartement, prd_kodekategoribarang, prd_prdcd";
        }elseif($sort == '2'){
            $urut = "URUT  : DIV+DEPT+KATEGORI+NAMA";
            $p_orderby = " order by prd_kodedivisi, prd_kodedepartement, prd_kodekategoribarang, prd_deskripsipanjang";
        }else{
            $urut = "URUT  : NAMA";
            $p_orderby = " order by prd_deskripsipanjang";
        }

        if($tag1 != '' && $tag2 != ''){
            $and_tag = " and prd_kodetag between '".$tag1."' and '".$tag2."'";
        }else{
            $and_tag = " ";
        }
        if($check == '1'){
            $and_diskon = " and NVL(prd_kodetag,'0') not in ('N','X','H')";
        }else{
            $and_diskon = " ";
        }
        $datas = DB::connection(Session::get('connection'))->select("select prd_prdcd, prd_deskripsipanjang, prd_unit,  prd_frac,
case when substr(prd_prdcd,-1) = '0' then 1 else 0 end jml_prod,
prd_lastcost, prd_avgcost, prd_hrgjual2, prd_hrgjual, prd_tglhrgjual, prd_minjual,
st_avgcost, st_prdcd, prd_kodetag, prd_flagbkp1 pkp, prd_flagbkp2 pkp2,
prd_kodedivisi, prd_kodedepartement, prd_kodekategoribarang,
div_kodedivisi||' - '||div_namadivisi divisi,
dep_kodedepartement||' - '|| dep_namadepartement dept,
kat_kodekategori||' - '|| kat_namakategori kategori,
prs_namaperusahaan, prs_namacabang
from tbmaster_prodmast, tbmaster_stock, tbmaster_divisi, tbmaster_departement, tbmaster_kategori,
    tbmaster_perusahaan
where prd_kodeigr='$kodeigr'
and nvl(prd_recordid,'9')<> 1
and prd_tglhrgjual3 between TO_DATE('$sDate','DD-MM-YYYY') and TO_DATE('$eDate','DD-MM-YYYY')
".$and_tag."
and st_kodeigr(+)=prd_kodeigr
and st_prdcd(+) = substr(prd_prdcd,0,6)||'0'
and st_lokasi(+) ='01'
".$and_diskon."
and div_kodedivisi = prd_kodedivisi
and div_kodeigr=prd_kodeigr
--&AND_DIV
and dep_kodedepartement = prd_kodedepartement
and dep_kodedivisi = div_kodedivisi
and dep_kodeigr = prd_kodeigr
--&AND_DEPT
and kat_kodekategori = prd_kodekategoribarang
and kat_kodedepartement = dep_kodedepartement
and kat_kodeigr= prd_kodeigr
--&AND_KAT
and prd_kodedivisi||prd_kodedepartement||prd_kodekategoribarang between '$div1'||'$dep1'||'$kat1' and '$div2'||'$dep2'||'$kat2'
and prs_kodeigr = prd_kodeigr"
            .$p_orderby);

        $cf_nmargin = [];
        for($i=0;$i<sizeof($datas);$i++){
            if($datas[$i]->prd_unit == 'KG'){
                $multiplier = 1;
            }else{
                $multiplier = (int)$datas[$i]->prd_frac;
            }
            if($datas[$i]->st_avgcost == ''){
                $avgcost = 0;
            }else{
                $avgcost = $datas[$i]->st_avgcost;
            }
            if($datas[$i]->prd_hrgjual == ''){
                $hrgjual = 0;
            }else{
                $hrgjual = $datas[$i]->prd_hrgjual;
            }
            if($datas[$i]->prd_hrgjual == '' || $datas[$i]->prd_hrgjual == 0){
                $divisor = 1;
            }else{
                $divisor = 1;
            }
            $nAcost = (float)$datas[$i]->st_avgcost * $multiplier;
            if($nAcost > 0){
                if($datas[$i]->pkp == 'Y' && $datas[$i]->pkp2 != 'P'){
                    $cf_nmargin[$i] = round((($hrgjual - (1.1*$nAcost)) / $divisor)*100, 2);
                }else{
                    $cf_nmargin[$i] = round((($hrgjual - $nAcost) / $divisor)*100, 2);
                }
            }else{
                $cf_nmargin[$i]=0;
            }
        }
        //PRINT
        $perusahaan = DB::table("tbmaster_perusahaan")->first();
        //CETAK_DAFTARHRGBARU & CETAK_DAFTARHRGBARUNAMA (CETAK_DAFTARHRGBARU.jsp && CETAK_DAFTARHRGBARUNAMA.jsp)
        return view('BACKOFFICE.LISTMASTERASSET.LAPORAN.daftar-harga-jual-baru-pdf',
            ['kodeigr' => $kodeigr, 'data' => $datas, 'perusahaan' => $perusahaan,
                'date1' => $sDate, 'date2' => $eDate, 'urut' => $urut, 'cf_nmargin' => $cf_nmargin, 'sort' => $sort]);

    }

    public function printDaftarPerpanjanganMember(Request $request){
        $kodeigr = Session::get('kdigr');
        $member1 = $request->member1;
        $member2 = $request->member2;
        $sort = $request->sort;
        $sDate = $request->date1;
        $eDate = $request->date2;
        $sDate = DateTime::createFromFormat('d-m-Y', $sDate)->format('d-M-Y');
        $eDate = DateTime::createFromFormat('d-m-Y', $eDate)->format('d-M-Y');

        if ($member1 == '') {
            $temp = DB::connection(Session::get('connection'))->table("tbmaster_customer")
                ->selectRaw("min(cus_kodemember) as result")
                ->where("cus_kodeigr", '=', $kodeigr)
                ->first();
            $member1 = $temp->result;
        }
        if ($member2 == '') {
            $temp = DB::connection(Session::get('connection'))->table("tbmaster_customer")
                ->selectRaw("max(cus_kodemember) as result")
                ->where("cus_kodeigr", '=', $kodeigr)
                ->first();
            $member2 = $temp->result;
        }

        if($sort == 1){
            $urut = "URUT: OUTLET+AREA+KODE";
            $and_orderby = " ORDER BY CUS_KODEOUTLET, cus_kodesuboutlet, CUS_KODEAREA, CUS_KODEMEMBER";
        }elseif($sort == 2){
            $urut = "URUT: OUTLET+AREA+NAMA";
            $and_orderby = " ORDER BY CUS_KODEOUTLET, cus_KODEAREA, CUS_NAMAMEMBER";
        }elseif($sort == 3){
            $urut = "URUT: OUTLET+KODE";
            $and_orderby = " ORDER BY CUS_KODEOUTLET, cus_kodesuboutlet, CUS_KODEMEMBER";
        }elseif($sort == 4){
            $urut = "URUT: OUTLET+NAMA";
            $and_orderby = " ORDER BY CUS_KODEOUTLET, cus_kodesuboutlet, CUS_NAMAMEMBER";
        }elseif($sort == 5){
            $urut = "URUT: AREA+KODE";
            $and_orderby = " ORDER BY CUS_KODEAREA, CUS_KODEMEMBER";
        }elseif($sort == 6){
            $urut = "URUT: AREA+NAMA";
            $and_orderby = " ORDER BY CUS_KODEAREA, CUS_NAMAMEMBER";
        }elseif($sort == 7){
            $urut = "URUT: KODE";
            $and_orderby = " ORDER BY CUS_KODEMEMBER";
        }elseif($sort == 8){
            $urut = "URUT: NAMA";
            $and_orderby = " ORDER BY CUS_NAMAMEMBER";
        }else{
            $urut = "URUT: KODE";
            $and_orderby = " ORDER BY CUS_KODEMEMBER";
        }

        $datas = DB::connection(Session::get('connection'))->select("select lpad(cus_kodemember,6,'0') kd, cus_nokartumember, cus_namamember,
substr(cus_alamatmember1,0,38)||' '||cus_alamatmember2 alamat, cus_tlpmember, cus_flagpkp, cus_npwp, cus_creditlimit,
cus_top, cus_kodearea area1, cus_kodearea area2, cus_kodeoutlet, cus_tglregistrasi, cus_create_by,
to_char(cus_create_dt,'dd-mm-yy') tglupd,
to_char(cus_create_dt,'hh24:mi:ss') jamupd,
prs_namaperusahaan, prs_namacabang,
out_kodeoutlet||'-'||out_namaoutlet outlet
from tbmaster_customer, tbmaster_perusahaan, tbmaster_outlet
where cus_tglregistrasi between TO_DATE('$sDate','DD-MM-YYYY') and TO_DATE('$eDate','DD-MM-YYYY')
and cus_kodeigr='$kodeigr'
and nvl(cus_recordid,'9')<>'1'
and cus_kodemember between '$member1' and '$member2'
and prs_kodeigr=cus_kodeigr
and out_kodeigr (+)= cus_kodeigr
and out_kodeoutlet(+)= cus_kodeoutlet
".$and_orderby);

        //PROCEDURE IGR_BO_CONTS (:P_KODEIGR, 'AA', :AREA2, TEMP);
        $area = [];
        for($i=0;$i<sizeof($datas);$i++){
            try{
                $tipearea = 'AA'.$datas[$i]->area1;
                $temp = DB::connection(Session::get('connection'))->table("tbmaster_const")
                    ->selectRaw("consT_name")
                    ->where("const_kodeigr",'=',$kodeigr)
                    ->where("const_branch",'=',$tipearea)
                    ->first();
                if($temp){
                    $area[$i] = $temp->const_name;
                }else{
                    $area[$i] = " ";
                }
            }catch (\Exception $e){
                $area[$i] = " ";
            }
        }

        //PRINT
        $perusahaan = DB::table("tbmaster_perusahaan")->first();

        return view('BACKOFFICE.LISTMASTERASSET.LAPORAN.daftar-perpanjangan-anggota-or-member-pdf',
            ['kodeigr' => $kodeigr, 'data' => $datas, 'perusahaan' => $perusahaan,
                'urut' => $urut, 'p_area' => $area, 'sort' => $sort, 'date1' => $sDate, 'date2' => $eDate]);
    }

    public function printDaftarStatusTagBar(Request $request){
        $kodeigr = Session::get('kdigr');
        $dep1 = $request->dep1;
        if($dep1 == ''){
            $temp = DB::connection(Session::get('connection'))->table("tbmaster_departement")
                ->selectRaw("min(dep_kodedepartement) as result")
                ->where("dep_kodeigr",'=',$kodeigr)
                ->first();
            $dep1 = $temp->result;
        }
        $dep2 = $request->dep2;
        if($dep2 == ''){
            $temp = DB::connection(Session::get('connection'))->table("tbmaster_departement")
                ->selectRaw("max(dep_kodedepartement) as result")
                ->where("dep_kodeigr",'=',$kodeigr)
                ->first();
            $dep2 = $temp->result;
        }
        $kat1 = $request->kat1;
        if($kat1 == ''){
            $temp = DB::connection(Session::get('connection'))->table("tbmaster_kategori")
                ->selectRaw("min(kat_kodekategori) as result")
                ->where("kat_kodeigr",'=',$kodeigr)
                ->where("kat_kodedepartement",'=',$dep1)
                ->first();
            $kat1 = $temp->result;
        }
        $kat2 = $request->kat2;
        if($kat2 == ''){
            $temp = DB::connection(Session::get('connection'))->table("tbmaster_kategori")
                ->selectRaw("max(kat_kodekategori) as result")
                ->where("kat_kodeigr",'=',$kodeigr)
                ->where("kat_kodedepartement",'=',$dep2)
                ->first();
            $kat2 = $temp->result;
        }

        $plu1 = $request->plu1;
        $plu2 = $request->plu2;
        if($plu1 != '' && $plu2 != ''){
            $and_plu = " and prd_prdcd between '".$plu1."' and '".$plu2."'";
        }else{
            $and_plu = " ";
        }

        $status = $request->status;
        if($status != ''){
            if($status == "1"){
                $and_status = " and prd_flagbarcode1 = 'BN'";
            }elseif($status == '2'){
                $and_status = " and prd_flagbarcode1 = 'BC'";
            }elseif($status == '3'){
                $and_status = " and prd_flagbarcode1 = 'BD'";
            }else{
                $and_status = " and prd_flagbarcode1 = 'BC'";
            }
        }else{
            $and_status = " ";
        }
        $datas = DB::connection(Session::get('connection'))->select("select prd_prdcd, prd_deskripsipanjang, prd_unit||'/'||prd_frac, prd_flagbarcode1,
dep_kodedepartement||'-'||dep_namadepartement dep,
kat_kodekategori||'-'||kat_namakategori kat,
prs_namaperusahaan, prs_namacabang
from tbmaster_prodmast, tbmaster_departement, tbmaster_kategori, tbmaster_perusahaan
where prd_kodeigr='$kodeigr'
".$and_plu."
and dep_kodeigr=prd_kodeigr
and dep_kodedepartement = prd_kodedepartement
--&and_dep
and kat_kodeigr=prd_kodeigr
and kat_kodekategori = prd_kodekategoribarang
and kat_kodedepartement=dep_kodedepartement
--&and_kat
".$and_plu."
and prd_kodedepartement||prd_kodekategoribarang between '$dep1'||'$kat1' and '$dep2'||'$kat2'
and prs_kodeigr=prd_kodeigr
".$and_status."
order by dep_kodedepartement, dep_kodedepartement, prd_prdcd");

        //PRINT
        $perusahaan = DB::table("tbmaster_perusahaan")->first();

        return view('BACKOFFICE.LISTMASTERASSET.LAPORAN.daftar-status-tag-bar-pdf',
            ['kodeigr' => $kodeigr, 'data' => $datas, 'perusahaan' => $perusahaan]);
    }

    public function printMasterDisplay(Request $request){
        $kodeigr = Session::get('kdigr');
        $rak1 = $request->rak1;
        $rak2 = $request->rak2;
        $subrak1 = $request->subrak1;
        $subrak2 = $request->subrak2;
        $tiperak1 = $request->tiperak1;
        $tiperak2 = $request->tiperak2;
        $shelving1 = $request->shelving1;
        $shelving2 = $request->shelving2;
        $omi = $request->omi;

        if($rak1 == ''){
            $rak1 = "0000000";
        }
        if($subrak1 == ''){
            $subrak1 = "000";
        }
        if($tiperak1 == ''){
            $tiperak1 = "000";
        }
        if($shelving1 == ''){
            $shelving1 = "00";
        }
        if($rak2 == ''){
            $rak2 = "zzzzzzz";
        }
        if($subrak2 == ''){
            $subrak2 = "zzz";
        }
        if($tiperak2 == ''){
            $tiperak2 = "zzz";
        }
        if($shelving2 == ''){
            $shelving2 = "zz";
        }
        if($omi == 1){
            $title = "LISTING DISPLAY BARANG ITEM OMI";
            $and_omi = " and prc_group = 'O'".
                       " AND nvl(prc_kodetag (+), 'ccc') <> 'R'".
                       " AND nvl(prc_kodetag (+), 'ccc') <> 'N'".
                       " AND nvl(prc_kodetag (+), 'ccc') <> 'O'".
                       " AND nvl(prc_kodetag (+), 'ccc') <> 'H'".
                       " AND nvl(prc_kodetag (+), 'ccc') <> 'G'".
                       " AND nvl(prc_kodetag (+), 'ccc') <> 'T'".
                       " AND nvl(prc_kodetag (+), 'ccc') <> 'X'".
                       " AND nvl(prc_kodetag (+), 'ccc') <> 'Z'".
                       " and prc_kodeigr=prd_kodeigr and prc_pluomi=prd_prdcd";
        }else{
            $title = "LISTING DISPLAY BARANG";
            $and_omi = " and prc_group(+) = 'O'".
                " AND nvl(prc_kodetag (+), 'ccc') <> 'R'".
                " AND nvl(prc_kodetag (+), 'ccc') <> 'N'".
                " AND nvl(prc_kodetag (+), 'ccc') <> 'O'".
                " AND nvl(prc_kodetag (+), 'ccc') <> 'H'".
                " AND nvl(prc_kodetag (+), 'ccc') <> 'G'".
                " AND nvl(prc_kodetag (+), 'ccc') <> 'T'".
                " AND nvl(prc_kodetag (+), 'ccc') <> 'X'".
                " AND nvl(prc_kodetag (+), 'ccc') <> 'Z'".
                " and prc_kodeigr(+)=prd_kodeigr and prc_pluomi(+)=prd_prdcd";
        }

        $datas = DB::connection(Session::get('connection'))->select("select /*+ USE_NL(TBMASTER_PERUSAHAAN,TBMASTER_PRODCRM) */  lks_koderak fmkrak, lks_kodesubrak fmsrak, lks_tiperak fmtipe, lks_shelvingrak fmselv,
lks_nourut fmnour, lks_depanbelakang fmdpbl, lks_atasbawah fmatba,
lks_tirkirikanan fmface, lks_tirdepanbelakang fmtrdb,
lks_tiratasbawah fmtrab, lks_tirkirikanan * lks_tiratasbawah * lks_tirdepanbelakang kapasitas,
lks_maxdisplay fmtotl, lks_noid Fmnoid, lks_maxplano,
prd_kodedivisi, prd_prdcd, substr(prd_deskripsipanjang,0,50) desc2, prd_avgcost,
pkm_pkmt, st_saldoakhir, prc_pluomi, prc_group, prc_kodetag,
prs_namaperusahaan, prs_namacabang, prs_namawilayah
from tbmaster_lokasi, tbmaster_prodmast, tbmaster_kkpkm,
tbmaster_stock, tbmaster_prodcrm, tbmaster_perusahaan
where lks_kodeigr(+) = '$kodeigr'
and lks_koderak(+) between '$rak1' and '$rak2'
and lks_kodesubrak(+) between '$subrak1' and '$subrak2'
and lks_tiperak(+) between '$tiperak1' and '$tiperak2'
and lks_shelvingrak(+) between '$shelving1' and '$shelving2'
and prd_prdcd = lks_prdcd
and prd_kodeigr=lks_kodeigr
and pkm_prdcd(+)=prd_prdcd
and pkm_kodeigr(+)=prd_kodeigr
and st_prdcd (+)= prd_prdcd
and st_kodeigr(+)=prd_kodeigr
and st_lokasi(+)='01'
".$and_omi."
and prs_kodeigr=lks_kodeigr
order by lks_koderak, lks_kodesubrak, lks_tiperak, lks_shelvingrak, lks_nourut ");

        $forbidden_tag = ['A','R','N','O','H','G','T','X','Z'];
        //PRINT
        $perusahaan = DB::table("tbmaster_perusahaan")->first();

        return view('BACKOFFICE.LISTMASTERASSET.LAPORAN.master-display-pdf',
            ['kodeigr' => $kodeigr, 'data' => $datas, 'perusahaan' => $perusahaan, 'title' => $title, 'p_omi' => $omi, 'forbidden_tag' => $forbidden_tag]);
    }

    public function printMasterDisplayDDK(Request $request){
        $kodeigr = Session::get('kdigr');
        $div1 = $request->div1;
        $div2 = $request->div2;
        $dep1 = $request->dep1;
        $dep2 = $request->dep2;
        $kat1 = $request->kat1;
        $kat2 = $request->kat2;

        $plu1 = $request->plu1;
        $plu2 = $request->plu2;

        $p_omi = $request->omi;

        if($div1 == ''){
            $temp = DB::connection(Session::get('connection'))->table("tbmaster_divisi")
                ->selectRaw("min(div_kodedivisi) as result")
                ->where("div_kodeigr",'=',$kodeigr)
                ->first();
            $div1 = $temp->result;
        }

        if($div2 == ''){
            $temp = DB::connection(Session::get('connection'))->table("tbmaster_divisi")
                ->selectRaw("max(div_kodedivisi) as result")
                ->where("div_kodeigr",'=',$kodeigr)
                ->first();
            $div2 = $temp->result;
        }

        if($dep1 == ''){
            $temp = DB::connection(Session::get('connection'))->table("tbmaster_departement")
                ->selectRaw("min(dep_kodedepartement) as result")
                ->where("dep_kodeigr",'=',$kodeigr)
                ->where("dep_kodedivisi",'=',$div1)
                ->first();
            $dep1 = $temp->result;
        }

        if($dep2 == ''){
            $temp = DB::connection(Session::get('connection'))->table("tbmaster_departement")
                ->selectRaw("max(dep_kodedepartement) as result")
                ->where("dep_kodeigr",'=',$kodeigr)
                ->where("dep_kodedivisi",'=',$div2)
                ->first();
            $dep2 = $temp->result;
        }

        if($kat1 == ''){
            $temp = DB::connection(Session::get('connection'))->table("tbmaster_kategori")
                ->selectRaw("min(kat_kodekategori) as result")
                ->where("kat_kodeigr",'=',$kodeigr)
                ->where("kat_kodedepartement",'=',$dep1)
                ->first();
            $kat1 = $temp->result;
        }

        if($kat2 == ''){
            $temp = DB::connection(Session::get('connection'))->table("tbmaster_kategori")
                ->selectRaw("max(kat_kodekategori) as result")
                ->where("kat_kodeigr",'=',$kodeigr)
                ->where("kat_kodedepartement",'=',$dep2)
                ->first();
            $kat2 = $temp->result;
        }

        if($plu1 == ''){
            $plu1 = "0000000";
        }
        if($plu2 == ''){
            $plu2 = "ZZZZZZZ";
        }

        if($p_omi == 1){
            $and_omi = " and prc_group = 'O' and nvl(prc_kodetag,'ccc') not in ('A','R','N', 'O', 'H', 'G', 'T','X','Z') ".
                " and prc_kodeigr=prd_kodeigr and prc_pluomi=prd_prdcd";
        }else{
            $and_omi = " and prc_group(+) = 'O' and nvl(prc_kodetag(+),'ccc') not in ('A','R','N', 'O', 'H', 'G', 'T','X','Z') ".
                " and prc_kodeigr(+)=prd_kodeigr and prc_pluomi(+)=prd_prdcd";
        }

        $datas = DB::connection(Session::get('connection'))->select("select prd_prdcd, prd_deskripsipanjang,
prd_unit||'/'||prd_frac satuan,
lks_prdcd, lks_koderak fmkrak, lks_kodesubrak fmsrak,
lks_shelvingrak fmselv, lks_nourut fmnour,
lks_tirkirikanan fmface, lks_noid fmnoid,
div_kodedivisi||'-'||div_namadivisi div,
dep_kodedepartement||'-'||dep_namadepartement dep,
kat_kodekategori||'-'||kat_namakategori kat,
prs_namaperusahaan, prs_namacabang, prs_namawilayah,
prc_group, prc_pluomi, prc_kodetag
from tbmaster_prodmast, tbmaster_lokasi,
tbmaster_divisi, tbmaster_departement, tbmaster_kategori,
tbmaster_perusahaan, tbmaster_prodcrm
where prd_kodeigr='$kodeigr'
".$and_omi."
and lks_kodeigr=prd_kodeigr
and lks_prdcd = prd_prdcd
and div_kodedivisi = prd_kodedivisi
and div_kodeigr=prd_kodeigr
and prd_prdcd between '$plu1' and '$plu2'
--&and_plu
--and div_kodedivisi between :p_div1 and :p_div2
and dep_kodedepartement = prd_kodedepartement
and dep_kodedivisi = div_kodedivisi
and dep_kodeigr = prd_kodeigr
--and dep_kodedepartement between :p_dep1 and :p_dep2
and kat_kodekategori = prd_kodekategoribarang
and kat_kodedepartement = dep_kodedepartement
and kat_kodeigr= prd_kodeigr
and prd_kodedivisi||prd_kodedepartement||prd_kodekategoribarang between '$div1'||'$dep1'||'$kat1' and '$div2'||'$dep2'||'$kat2'
--and kat_kodekategori between :p_kat1 and :p_kat2
and prs_kodeigr = prs_kodeigr
ORDER BY div_kodedivisi, dep_kodedepartement, kat_kodekategori, prd_prdcd, lks_nourut ");


        if($p_omi == 1){
            $title = "** LIST MASTER DISPLAY /DIV/DEPT/KATB (ITEM OMI) **";
        }else{
            $title = "** LIST MASTER DISPLAY /DIV/DEPT/KATB **";
        }
        $forbidden_tag = ['A','R','N','O','H','G','T','X','Z'];
        //PRINT
        $perusahaan = DB::table("tbmaster_perusahaan")->first();

        return view('BACKOFFICE.LISTMASTERASSET.LAPORAN.master-display-div-dep-kat-pdf',
            ['kodeigr' => $kodeigr, 'data' => $datas, 'perusahaan' => $perusahaan,
                'title' => $title, 'p_omi' => $p_omi, 'forbidden_tag' => $forbidden_tag]);
    }
    public function printDaftarMarginNegatifvsMCG(Request $request){
        $kodeigr = Session::get('kdigr');
        $div1 = $request->div1;
        if($div1 == ''){
            $temp = DB::connection(Session::get('connection'))->table("tbmaster_divisi")
                ->selectRaw("min(div_kodedivisi) as result")
                ->where("div_kodeigr",'=',$kodeigr)
                ->first();
            $div1 = $temp->result;
        }
        $div2 = $request->div2;
        if($div2 == ''){
            $temp = DB::connection(Session::get('connection'))->table("tbmaster_divisi")
                ->selectRaw("max(div_kodedivisi) as result")
                ->where("div_kodeigr",'=',$kodeigr)
                ->first();
            $div2 = $temp->result;
        }
        $dep1 = $request->dep1;
        if($dep1 == ''){
            $temp = DB::connection(Session::get('connection'))->table("tbmaster_departement")
                ->selectRaw("min(dep_kodedepartement) as result")
                ->where("dep_kodeigr",'=',$kodeigr)
                ->where("dep_kodedivisi",'=',$div1)
                ->first();
            $dep1 = $temp->result;
        }
        $dep2 = $request->dep2;
        if($dep2 == ''){
            $temp = DB::connection(Session::get('connection'))->table("tbmaster_departement")
                ->selectRaw("max(dep_kodedepartement) as result")
                ->where("dep_kodeigr",'=',$kodeigr)
                ->where("dep_kodedivisi",'=',$div2)
                ->first();
            $dep2 = $temp->result;
        }
        $kat1 = $request->kat1;
        if($kat1 == ''){
            $temp = DB::connection(Session::get('connection'))->table("tbmaster_kategori")
                ->selectRaw("min(kat_kodekategori) as result")
                ->where("kat_kodeigr",'=',$kodeigr)
                ->where("kat_kodedepartement",'=',$dep1)
                ->first();
            $kat1 = $temp->result;
        }
        $kat2 = $request->kat2;
        if($kat2 == ''){
            $temp = DB::connection(Session::get('connection'))->table("tbmaster_kategori")
                ->selectRaw("max(kat_kodekategori) as result")
                ->where("kat_kodeigr",'=',$kodeigr)
                ->where("kat_kodedepartement",'=',$dep2)
                ->first();
            $kat2 = $temp->result;
        }
        $ptag = $request->ptag;
        $p_tagq = "";
        if($ptag != ''){
            $p_tagq = "and NVL(prd_kodetag,'b') in (".$ptag.")";
        }
        $sort = $request->sort;
        if((int)$sort == 1){
            $p_urut = "URUT: DIV+DEPT+KATEGORI+KODE";
            $p_orderby = " order by prd_kodedivisi, prd_kodedepartement, prd_kodekategoribarang, prd_prdcd";
        }elseif ((int)$sort == 2){
            $p_urut = "URUT: DIV+DEPT+KATEGORI+NAMA";
            $p_orderby = " order by prd_kodedivisi, prd_kodedepartement, prd_kodekategoribarang, prd_deskripsipanjang";
        }else{
            $p_urut = "URUT: NAMA" ;
            $p_orderby = " order by prd_deskripsipanjang";
        }
        $datas = DB::connection(Session::get('connection'))->select("select prd_prdcd, prd_flagbkp1 pkp, prd_flagbkp2 pkp2, prd_deskripsipanjang desc2, prd_lastcost, prd_avgcost,
prd_hrgjual price_a, prd_kodetag tag, prd_lastcost, prd_unit unit, prd_frac frac,
prd_unit, case when substr(prd_prdcd,-1) = '0' then prd_frac else 1 end frac, prd_minjual,
prd_kodedivisi, prd_kodedepartement, prd_kodekategoribarang,
st_prdcd, nvl(st_avgcost,0) * case when prd_unit = 'KG' then 1 else prd_frac end avgcost,
nvl(st_avgcost,0) st_acost, st_saldoakhir qty,
nvl(prm_hrgjual,0) Fmjual, nvl(prm_persentasepotongan,0) Fmpotp,
nvl(prm_rphpotongan,0) Fmpotr, prm_prdcd,
div_kodedivisi||' - '||div_namadivisi divisi,
dep_kodedepartement||' - '|| dep_namadepartement dept,
kat_kodekategori||' - '|| kat_namakategori kategori,
prs_namaperusahaan, prs_namacabang,
hgb_hrgbeli Fmbeli, hgb_persendisc01 Fmdirp, hgb_rphdisc01 Fmdirr,
hgb_flagdisc01 Fmdirs, hgb_persendisc02 Fmditp, hgb_rphdisc02 Fmditr,
spot_prdcd, sls_prdcd, mcg_lastcost,
((prd_hrgjual- prd_lastcost) / case when nvl(prd_hrgjual,0)=0 then 1 else prd_hrgjual end) * 100  lcmargin,
((prd_hrgjual - (nvl(st_avgcost,0) * case when prd_unit = 'KG' then 1 else prd_frac end))/ (case when nvl(prd_hrgjual,0)=0 then 1 else prd_hrgjual end)) * 100 acmargin

from tbmaster_prodmast, tbmaster_stock, tbmaster_promo,
     tbmaster_divisi, tbmaster_departement, tbmaster_kategori,
     tbmaster_perusahaan, tbmaster_hargabeli, tbtr_hadiahkejutan, tbtr_salesbulanan,
     tbtr_mdlastcost
where prd_kodeigr = '$kodeigr'
and nvl(prd_recordid,'9')<>'1'
and nvl(prd_kodetag,'b') <> 'Z'
and st_prdcd(+)=substr(prd_prdcd,0,6)||'0'
and st_kodeigr(+)=prd_kodeigr
and st_lokasi(+)='01'
and prm_prdcd(+)=prd_prdcd
and prm_kodeigr(+)=prd_kodeigr
and prm_hrgjual(+) <> 0
and prm_persentasepotongan(+) <> 0
and div_kodedivisi = prd_kodedivisi
and div_kodeigr=prd_kodeigr
--and div_kodedivisi between :p_div1 and :p_div2
and dep_kodedepartement = prd_kodedepartement
and dep_kodedivisi = div_kodedivisi
and dep_kodeigr = prd_kodeigr
--and dep_kodedepartement between :p_dep1 and :p_dep2
and kat_kodekategori = prd_kodekategoribarang
and kat_kodedepartement = dep_kodedepartement
and kat_kodeigr= prd_kodeigr
--and kat_kodekategori between :p_kat1 and :p_kat2
and prd_kodedivisi||prd_kodedepartement||prd_kodekategoribarang between '$div1'||'$dep1'||'$kat1' and '$div2'||'$dep2'||'$kat2'
".$p_tagq."
and prs_kodeigr = prd_kodeigr
and hgb_prdcd(+)= substr(prd_prdcd,0,6)||'0'
and hgb_kodeigr(+)= prd_kodeigr
and mcg_kode(+)=substr(prd_prdcd,0,6)||'0'
and mcg_kodeigr(+)=prd_prdcd
and hgb_kodeigr(+) = prd_kodeigr
and spot_prdcd(+) = substr(prd_prdcd,0,6)||'0'
and spot_kodeigr(+) =prd_kodeigr
and spot_periodeawal(+) <= sysdate AND spot_periodeakhir(+) >= sysdate
and sls_prdcd(+) = substr(prd_prdcd,0,6)||'0'
and sls_kodeigr(+)= prd_kodeigr
and (((prd_hrgjual- prd_lastcost) / case when nvl(prd_hrgjual,0)=0 then 1 else prd_hrgjual end) * 100 <0
or ((prd_hrgjual - (nvl(st_avgcost,0) * case when prd_unit = 'KG' then 1 else prd_frac end))/ (case when nvl(prd_hrgjual,0)=0 then 1 else prd_hrgjual end)) * 100 < 0)
".$p_orderby);



        //PRINT
        $perusahaan = DB::table("tbmaster_perusahaan")->first();
        return view('BACKOFFICE.LISTMASTERASSET.LAPORAN.daftar-margin-negatif-vs-mcg-pdf',
            ['kodeigr' => $kodeigr, 'data' => $datas, 'perusahaan' => $perusahaan,
                'urut' => $p_urut, 'tag' => $ptag, 'sort' => $sort]);
    }

    public function printDaftarSupplierByHari(Request $request)
    {
        $kodeigr = Session::get('kdigr');

        $sup1 = $request->sup1;
        if ($sup1 == '') {
            $temp = DB::connection(Session::get('connection'))->table("tbmaster_supplier")
                ->selectRaw("min(sup_kodesupplier) as result")
                ->where("sup_kodeigr", '=', $kodeigr)
                ->first();
            $sup1 = $temp->result;
        }
        $sup2 = $request->sup2;
        if ($sup2 == '') {
            $temp = DB::connection(Session::get('connection'))->table("tbmaster_supplier")
                ->selectRaw("max(sup_kodesupplier) as result")
                ->where("sup_kodeigr", '=', $kodeigr)
                ->first();
            $sup2 = $temp->result;
        }
        $phari = $request->phari;
        if($phari != ''){
            $and_hari = " and hari in (".$phari.") ";
        }else{
            $and_hari = "";
        }


        $datas = $datas = DB::connection(Session::get('connection'))->select("select aa.sk, aa.hari, aa.urut,
sup_kodesupplier, sup_namasupplier, sup_harikunjungan,
sup_flagpenangananproduk, sup_jangkawaktukirimbarang,
sup_flagdiscontinuesupplier, sup_minrph, sup_minkarton,
sup_pkp,
prs_namaperusahaan, prs_namacabang
from (
    select sup_kodesupplier sk, 'MINGGU' hari, 1 urut
    from tbmaster_supplier
    where substr(sup_harikunjungan,1,1)='Y'
    and sup_kodesupplier between '$sup1' and '$sup2'
    and sup_kodeigr='$kodeigr'
    union all
    select sup_kodesupplier sk, 'SENIN' hari, 2 urut
    from tbmaster_supplier
    where substr(sup_harikunjungan,2,1)='Y'
    and sup_kodesupplier between '$sup1' and '$sup2'
    and sup_kodeigr='$kodeigr'
    union all
    select sup_kodesupplier sk, 'SELASA' hari, 3 urut
    from tbmaster_supplier
    where substr(sup_harikunjungan,3,1)='Y'
    and sup_kodesupplier between '$sup1' and '$sup2'
    and sup_kodeigr='$kodeigr'
    union all
    select sup_kodesupplier sk, 'RABU' hari, 4 urut
    from tbmaster_supplier
    where substr(sup_harikunjungan,4,1)='Y'
    and sup_kodesupplier between '$sup1' and '$sup2'
    and sup_kodeigr='$kodeigr'
    union all
    select sup_kodesupplier sk, 'KAMIS' hari,  5 urut
    from tbmaster_supplier
    where substr(sup_harikunjungan,5,1)='Y'
    and sup_kodesupplier between '$sup1' and '$sup2'
    and sup_kodeigr='$kodeigr'
    union all
    select sup_kodesupplier sk, 'JUMAT' hari, 6 urut
    from tbmaster_supplier
    where substr(sup_harikunjungan,6,1)='Y'
    and sup_kodesupplier between '$sup1' and '$sup2'
    and sup_kodeigr='$kodeigr'
    union all
    select sup_kodesupplier sk, 'SABTU' hari, 7 urut
    from tbmaster_supplier
    where substr(sup_harikunjungan,7,1)='Y'
    and sup_kodesupplier between '$sup1' and '$sup2'
    --and sup_kodeigr='01'
    and sup_kodeigr='$kodeigr'
    ) aa, tbmaster_supplier bb, tbmaster_perusahaan
where bb.sup_kodesupplier = aa.sk
and aa.sk between '$sup1' and '$sup2'
and bb.sup_kodeigr='$kodeigr'
".$and_hari."
and prs_kodeigr=sup_kodeigr
order by urut, sk");

        //CETAK_DAFTARSUPPLIER(IGR_BO_DAFTARSUPPLIER.jsp)
        $perusahaan = DB::table("tbmaster_perusahaan")->first();
        return view('BACKOFFICE.LISTMASTERASSET.LAPORAN.daftar-supplier-by-hari-pdf',
            ['kodeigr' => $kodeigr, 'data' => $datas, 'perusahaan' => $perusahaan]);
    }
}
