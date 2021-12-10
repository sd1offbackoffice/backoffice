<?php
/**
 * Created by PhpStorm.
 * User: ryan
 * Date: 08/09/2021
 * Time: 9:13 AM
 */

namespace App\Http\Controllers\OMI\LAPORAN;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller; use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use PDF;
use DateTime;
use Yajra\DataTables\DataTables;

class laplvlpbController extends Controller
{

    public function index()
    {
        return view('OMI.LAPORAN.laplvlpb');
    }

    public function pbModal(Request $request){
        $value = $request->value; //nilai pb1
        if($value == ''){
            $value = '0';
        }
        $datas = DB::connection(Session::get('connection'))->table("tbmaster_pbomi")
            ->selectRaw("pbo_nokoli, pbo_nopb, pbo_kodeomi")
            //->orderByRaw("pbo_nokoli, pbo_nopb, pbo_kodeomi") //orderby membuat load data menjadi lambat
            ->whereRaw("pbo_nopb >= '$value'");
//            ->whereRaw("trunc(PBO_TGLPB) >= SYSDATE-365")
//            ->limit(5000)
//            ->get();

//        $datas = DB::connection(Session::get('connection'))->table("tbmaster_prodmast")
//            ->selectRaw("prd_prdcd as pbo_nokoli, prd_kodekategoribarang as pbo_nopb, prd_kodetag as pbo_kodeomi");

        return Datatables::of($datas)->make(true);
    }

    public function cetak(Request $request){
        $kodeigr = Session::get('kdigr');

        $jenis = $request->jenis;
        $pb1 = $request->pb1;
        $pb2 = $request->pb2;

        $and_pb = "";
        if($pb1 != '' & $pb2 != ''){
            $and_pb = " and TRIM(pbo_nopb) between '".$pb1."' and '".$pb2."'";
        }

        $dateA = $request->date1;
        $dateB = $request->date2;
        $sDate = DateTime::createFromFormat('d-m-Y', $dateA)->format('d-m-Y');
        $eDate = DateTime::createFromFormat('d-m-Y', $dateB)->format('d-m-Y');

        if($jenis == '1'){
            $title = "** SERVICE LEVEL PB YG TIDAK DICHECK **";
            $datas = DB::connection(Session::get('connection'))->select("select nopb, tglpb, pbo_pluigr, pb,
SUM(pbo_qtyorder) qtyo, SUM(pbo_nilaiorder) nilo, SUM(pbo_ppnorder) ppno,
prd_deskripsipanjang, kemasan,
prs_namaperusahaan, prs_namacabang, prs_namawilayah
from
(
    select TRIM(pbo_nopb) nopb, TRUNC(pbo_tglpb) tglpb, pbo_pluigr,
    substr(trim(pbo_nopb),2,6) pb, pbo_qtyorder, pbo_nilaiorder, pbo_ppnorder,
    prd_deskripsipanjang, prd_unit||'/'||prd_frac kemasan,
    prs_namaperusahaan, prs_namacabang, prs_namawilayah
    from tbmaster_pbomi, tbmaster_tokoigr, tbmaster_prodmast, tbmaster_Perusahaan
    where pbo_kodeigr = '$kodeigr'
    and TRUNC(pbo_tglstruk) between TO_DATE('$sDate','DD-MM-YYYY') AND TO_DATE('$eDate', 'DD-MM-YYYY')
    ".$and_pb."
    and ((nvl(pbo_recordid,'9') not in('2','5','9') AND pbo_recordid IS NOT NULL) OR (pbo_recordid = '4' and pbo_qtyrealisasi = 0))
    and nvl(substr(pbo_nostruk,-3),'XXX') <> 'BKL'
    and tko_kodeomi = pbo_kodeomi
    and tko_kodeigr = pbo_kodeigr
    and tko_tglgo is not null
    and substr(pbo_nopb,2,6) =  case when substr(to_char(tko_tglgo,'yyyy/mm/dd'),1,1) = '0' then
            SUBStr (to_char(tko_tglgo,'yyyy/mm/dd'),2,1)
      else
            substr(to_char(tko_tglgo,'yyyymmdd'), 1,2)
      end||substr(to_char(tko_tglgo,'yyyymmdd'),5,2)|| substr(to_char(tko_tglgo,'yyyymmdd'), -2)
    and prd_prdcd = pbo_pluigr
    and prd_kodeigr = pbo_kodeigr
    and prs_kodeigr = pbo_kodeigr
    and substr(pbo_nopb,1,1) = '1'
)
GROUP BY nopb, tglpb, pbo_pluigr, pb,
              prd_deskripsipanjang, kemasan,
              prs_namaperusahaan, prs_namacabang, prs_namawilayah

union

select nopb, tglpb, pbo_pluigr, pb,
SUM(pbo_qtyorder) qtyo, SUM(pbo_nilaiorder) nilo, SUM(pbo_ppnorder) ppno,
prd_deskripsipanjang,  kemasan,
prs_namaperusahaan, prs_namacabang, prs_namawilayah
from
(
    select TRIM(pbo_nopb) nopb, TRUNC(pbo_tglpb) tglpb, pbo_pluigr,
    substr(trim(pbo_nopb),2,6) pb, pbo_qtyorder, pbo_nilaiorder, pbo_ppnorder,
    prd_deskripsipanjang, prd_unit||'/'||prd_frac kemasan,
    prs_namaperusahaan, prs_namacabang, prs_namawilayah
    from tbmaster_pbomi, tbmaster_tokoigr, tbmaster_prodmast, tbmaster_Perusahaan
    where pbo_kodeigr = '$kodeigr'
    and TRUNC(pbo_tglstruk) between TO_DATE('$sDate','DD-MM-YYYY') AND TO_DATE('$eDate', 'DD-MM-YYYY')
    ".$and_pb."
    and ((nvl(pbo_recordid,'9') not in('2' ,'5','9') AND pbo_recordid IS NOT NULL) OR (pbo_recordid = '4' and pbo_qtyrealisasi = 0))
    and nvl(substr(pbo_nostruk,-3),'XXX') <> 'BKL'
    and tko_kodeomi = pbo_kodeomi
    and tko_kodeigr = pbo_kodeigr
    and tko_tglgo is not null
    and substr(pbo_nopb,2,6) <>  case when substr(to_char(tko_tglgo,'yyyy/mm/dd'),1,1) = '0' then
            SUBStr (to_char(tko_tglgo,'yyyy/mm/dd'),2,1)
      else
            substr(to_char(tko_tglgo,'yyyymmdd'), 1,2)
      end||substr(to_char(tko_tglgo,'yyyymmdd'),5,2)|| substr(to_char(tko_tglgo,'yyyymmdd'), -2)
    and prd_prdcd = pbo_pluigr
    and prd_kodeigr = pbo_kodeigr
    and prs_kodeigr = pbo_kodeigr
)
GROUP BY nopb, tglpb, pbo_pluigr, pb,
              prd_deskripsipanjang, kemasan,
              prs_namaperusahaan, prs_namacabang, prs_namawilayah
order by nopb, tglpb, pbo_pluigr");
        }else{
            $title = "** SERVICE LEVEL PB YG TIDAK TERPICKING **";
            $datas = DB::connection(Session::get('connection'))->select("select nopb, tglpb, pbo_pluigr, pb,
     SUM(pbo_qtyorder) qtyo, SUM(pbo_nilaiorder) nilo,
     SUM(pbo_ppnorder) ppno, prd_deskripsipanjang, kemasan,
     prs_namaperusahaan, prs_namacabang, prs_namawilayah
from
(
    select  TRIM(pbo_nopb) nopb, TRUNC(pbo_tglpb) tglpb,
         trim(substr(pbo_nopb,2,6)) pb, pbo_qtyorder,  pbo_pluigr, pbo_nilaiorder, pbo_ppnorder,
         prd_deskripsipanjang, prd_unit||'/'||prd_frac kemasan,
         prs_namaperusahaan, prs_namacabang, prs_namawilayah
    from tbmaster_pbomi, tbmaster_tokoigr , tbmaster_prodmast, tbmaster_Perusahaan
    where pbo_kodeigr = '$kodeigr'
       and TRUNC(pbo_tglstruk) between TO_DATE('$sDate','DD-MM-YYYY') AND TO_DATE('$eDate', 'DD-MM-YYYY')
       ".$and_pb."
       and (nvl(pbo_recordid,'9') not in( '4','5') OR (pbo_recordid = '3' AND  nvl(pbo_qtyrealisasi,0) = 0))
       and nvl(substr(pbo_nostruk,-3),'XXX') <> 'BKL'
       and tko_kodeomi = pbo_kodeomi
       and tko_kodeigr=pbo_kodeigr
       and tko_tglgo is not null
       and substr(pbo_nopb,2,6) =  case when substr(to_char(tko_tglgo,'yyyy/mm/dd'),1,1) = '0' then
           substr (to_char(tko_tglgo,'yyyy/mm/dd'),2,1)
       else
           substr(to_char(tko_tglgo,'yyyymmdd'), 1,2)
      end||substr(to_char(tko_tglgo,'yyyymmdd'),4,2)|| substr(to_char(tko_tglgo,'yyyymmdd'), -2)
      and prd_prdcd = pbo_pluigr
      and prd_kodeigr=pbo_kodeigr
      and prs_kodeigr = pbo_kodeigr
      and substr(pbo_nopb,1,1)='1'
)
GROUP BY nopb, tglpb, pbo_pluigr, pb, prd_deskripsipanjang, kemasan,
                   prs_namaperusahaan, prs_namacabang, prs_namawilayah

union

select nopb, tglpb, pbo_pluigr, pb,
     SUM(pbo_qtyorder) qtyo, SUM(pbo_nilaiorder) nilo,
     SUM(pbo_ppnorder) ppno, prd_deskripsipanjang, kemasan,
     prs_namaperusahaan, prs_namacabang, prs_namawilayah
from
(
    select TRIM(pbo_nopb) nopb, TRUNC(pbo_tglpb) tglpb,
         trim(substr(pbo_nopb,2,6)) pb, pbo_qtyorder,  pbo_pluigr, pbo_nilaiorder, pbo_ppnorder,
         prd_deskripsipanjang, prd_unit||'/'||prd_frac kemasan,
         prs_namaperusahaan, prs_namacabang, prs_namawilayah
    from tbmaster_pbomi, tbmaster_tokoigr , tbmaster_prodmast, tbmaster_Perusahaan
    where pbo_kodeigr = '$kodeigr'
       and TRUNC(pbo_tglstruk) between TO_DATE('$sDate','DD-MM-YYYY') AND TO_DATE('$eDate', 'DD-MM-YYYY')
       ".$and_pb."
       and (nvl(pbo_recordid,'9') not in( '4' ,'5') OR (pbo_recordid = '3' and nvl(pbo_qtyrealisasi,0) = 0))
       and nvl(substr(pbo_nostruk,-3),'XXX') <> 'BKL'
       and tko_kodeomi = pbo_kodeomi
       and tko_kodeigr=pbo_kodeigr
       and tko_tglgo is not null
       and substr(pbo_nopb,2,6) <> case when substr(to_char(tko_tglgo,'yyyy/mm/dd'),1,1) = '0' then
           Substr (to_char(tko_tglgo,'yyyy/mm/dd'),2,1)
       else
           substr(to_char(tko_tglgo,'yyyymmdd'), 1,2)
       end||substr(to_char(tko_tglgo,'yyyymmdd'),4,2)|| substr(to_char(tko_tglgo,'yyyymmdd'), -2)
       and prd_prdcd = pbo_pluigr
       and prd_kodeigr=pbo_kodeigr
       and prs_kodeigr = pbo_kodeigr
)
GROUP BY nopb, tglpb, pbo_pluigr, pb, prd_deskripsipanjang, kemasan,
                   prs_namaperusahaan, prs_namacabang, prs_namawilayah
ORDER BY nopb, tglpb, pbo_pluigr");
        }
        if(sizeof($datas) == 0){
            return "**DATA TIDAK ADA**";
        }

        //PRINT
        $today = date('d-m-Y');
        $time = date('H:i:s');

        return view('OMI.LAPORAN.laplvlpb-pdf',
            ['title' => $title, 'kodeigr' => $kodeigr, 'date1' => $dateA, 'date2' => $dateB, 'datas' => $datas, 'today' => $today, 'time' => $time]);
    }
}
