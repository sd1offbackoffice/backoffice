<?php
/**
 * Created by PhpStorm.
 * User: ryan
 * Date: 20/09/2021
 * Time: 14:58 AM
 */

namespace App\Http\Controllers\OMI\LAPORAN;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use PDF;
use DateTime;
use Yajra\DataTables\DataTables;

class laprincislvpbController extends Controller
{

    public function index()
    {
        return view('OMI\LAPORAN.laprincislvpb');
    }

    public function tagModal(Request $request){
        $kodeigr = $_SESSION['kdigr'];
        $datas = DB::table("tbmaster_tag")
            ->selectRaw("tag_kodetag, tag_keterangan")
            ->where('tag_kodeigr','=',$kodeigr)
            ->get();

        return Datatables::of($datas)->make(true);
    }

    public function cetak(Request $request){
        $kodeigr = $_SESSION['kdigr'];

        $cab1 = $request->cab1;
        $cab2 = $request->cab2;
        $div1 = $request->div1;
        $div2 = $request->div2;
        $dep1 = $request->dep1;
        $dep2 = $request->dep2;
        $kat1 = $request->kat1;
        $kat2 = $request->kat2;
        $rel1 = $request->rel1;
        $rel2 = $request->rel2;
        $tag1 = $request->tag1;
        $tag2 = $request->tag2;
        $tag3 = $request->tag3;
        $tag4 = $request->tag4;
        $tag5 = $request->tag5;

        if($tag1 == '' && $tag2 == '' && $tag3 == '' && $tag4 == '' && $tag5 == ''){
            $p_tag = '';
        }else{
            if($tag1 != ''){
                $p_tag = "'".$tag1."'";
            }else{
                $p_tag = "'b'";
            }
            if($tag1 != ''){
                $p_tag = "'".$tag1."'";
            }else{
                $p_tag = "'b'";
            }
            if($tag2 != ''){
                $p_tag = $p_tag.",'".$tag2."'";
            }else{
                $p_tag = $p_tag."'b'";
            }
            if($tag3 != ''){
                $p_tag = $p_tag.",'".$tag3."'";
            }else{
                $p_tag = $p_tag."'b'";
            }
            if($tag4 != ''){
                $p_tag = $p_tag.",'".$tag4."'";
            }else{
                $p_tag = $p_tag."'b'";
            }
            if($tag5 != ''){
                $p_tag = $p_tag.",'".$tag5."'";
            }else{
                $p_tag = $p_tag."'b'";
            }
        }

        $p_prog = 'LAP223';

        $dateA = $request->date1;
        $dateB = $request->date2;
        $sDate = DateTime::createFromFormat('d-m-Y', $dateA)->format('d-m-Y');
        $eDate = DateTime::createFromFormat('d-m-Y', $dateB)->format('d-m-Y');

        $and_cab = '';
        $and_div = '';
        $and_dep = '';
        $and_kat = '';
        $and_tag = '';
        if($cab1 != '' && $cab2 != ''){
            $and_cab = " and pbo_kodeomi between '".$cab1."' and '".$cab2."'";
        }
        if($div1 != '' && $div2 != ''){
            $and_div = " and pbo_kodedivisi between '".$div1."' and '".$div2."'";
        }
        if($dep1 != '' && $dep2 != ''){
            $and_dep = " and pbo_kodedepartemen between '".$dep1."' and '".$dep2."'";
        }
        if($kat1 != '' && $kat2 != ''){
            $and_kat = " and pbo_kodekategoribrg between '".$kat1."' and '".$kat2."'";
        }
        if($p_tag != ''){
            $and_tag = " and NVL(prd_kodetag,'b') in (".$p_tag.")";
        }

        $datas  = DB::select("SELECT pbo_kodeomi, pbo_kodemember, pbo_pluigr,
     pbo_kodedivisi, pbo_kodedepartemen, pbo_kodekategoribrg,
     SUM(pbo_qtyorder) qtyo, SUM(pbo_nilaiorder) nilaio,
     SUM(pbo_ppnorder) ppno, SUM(qtyr) qtyr,
     SUM(nilair) nilair, tko_namaomi, cus_namamember,
     prd_deskripsipanjang, kemasan, prd_kodetag,
     div_namadivisi, dep_namadepartement, kat_namakategori,
     prs_namaperusahaan, prs_namacabang, prs_namawilayah
FROM
(    SELECT pbo_pluigr, pbo_kodeomi, pbo_kodemember,
          pbo_qtyorder, pbo_nilaiorder, pbo_ppnorder,
          CASE WHEN pbo_recordid IN('4','5') THEN
                 pbo_qtyrealisasi
          ELSE
                 0
          END qtyr,
          CASE WHEN pbo_recordid IN('4','5') THEN
                 pbo_ttlnilai
          ELSE
                 0
          END nilair,
          pbo_kodedivisi, div_namadivisi, pbo_kodedepartemen,
          dep_namadepartement, pbo_kodekategoribrg,
          kat_namakategori, tko_namaomi, prd_kodetag,
          prd_deskripsipanjang, prd_unit||'/'||prd_frac kemasan, cus_namamember,
          prs_namaperusahaan, prs_namacabang, prs_namawilayah
    FROM TBMASTER_PBOMI, TBMASTER_TOKOIGR, TBMASTER_PRODMAST,
          tbmaster_divisi, tbmaster_departement, tbmaster_kategori,
          TBMASTER_CUSTOMER, TBMASTER_PERUSAHAAN
    WHERE pbo_kodeigr = '$kodeigr'
    AND TRUNC(pbo_tglpb) BETWEEN TO_DATE('$sDate','DD-MM-YYYY') AND TO_DATE('$eDate', 'DD-MM-YYYY')
    AND SUBSTR(pbo_pluigr,1,6) NOT IN ('074828', '074829')
    AND case when pbo_qtyorder <> 0 then ((pbo_qtyrealisasi / pbo_qtyorder) * 100) else -100 end BETWEEN '$rel1' and '$rel2'
    --AND ((pbo_qtyrealisasi / pbo_qtyorder) * 100) BETWEEN '$rel1' and '$rel2' --bila pbo qty_order 0 maka akan error karena divisor tidak boleh 0, hasilnya infitiy
    ".$and_cab."
    ".$and_div."
    ".$and_dep."
    ".$and_kat."
    AND (SUBSTR(pbo_nostruk,-3,3) <> 'BKL'  OR pbo_nostruk IS NULL)
    --AND tko_kodeigr = pbo_kodeigr
    AND tko_kodeomi = pbo_kodeomi
    AND prd_prdcd(+) = pbo_pluigr
    AND prd_kodeigr(+) = pbo_kodeigr
    ".$and_tag."
    AND div_kodeigr(+) = pbo_kodeigr
    AND div_kodedivisi(+) = pbo_kodedivisi
    AND dep_kodeigr(+) = pbo_kodeigr
    AND dep_kodedivisi(+) = pbo_kodedivisi
    AND dep_kodedepartement(+) = pbo_kodedepartemen
    AND kat_kodeigr(+) = pbo_kodeigr
    AND kat_kodedepartement(+) = pbo_kodedepartemen
    AND kat_kodekategori(+) = pbo_kodekategoribrg
    --AND cus_kodeigr(+) = pbo_kodeigr
    AND cus_kodemember(+) = pbo_kodemember
    AND prs_kodeigr = pbo_kodeigr
    --AND pbo_kodedivisi||pbo_kodedepartemen||pbo_kodekategoribrg between :p_div1||:p_dep1||:p_kat1 and :p_div2||:p_dep2||:p_kat2
)
GROUP BY pbo_kodeomi, pbo_pluigr, pbo_kodemember,
                    pbo_kodedivisi, pbo_kodedepartemen, pbo_kodekategoribrg,
                    prd_deskripsipanjang, kemasan, prd_kodetag, tko_namaomi,
                    div_namadivisi, dep_namadepartement, kat_namakategori, cus_namamember,
                    prs_namaperusahaan, prs_namacabang, prs_namawilayah
ORDER BY pbo_kodeomi, pbo_pluigr");
dd("hello");
        if(sizeof($datas) == 0){
            return "**DATA TIDAK ADA**";
        }



        //PRINT
        $today = date('d-m-Y');
        $time = date('H:i:s');

        return view('OMI\LAPORAN\laprincislvpb-pdf',
            ['kodeigr' => $kodeigr, 'date1' => $dateA, 'date2' => $dateB, 'datas' => $datas, 'today' => $today, 'time' => $time]);
    }
}
