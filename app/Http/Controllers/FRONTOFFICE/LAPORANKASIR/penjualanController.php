<?php
/**
 * Created by PhpStorm.
 * User: ryan
 * Date: 1/12/2021
 * Time: 3:25 PM
 */

namespace App\Http\Controllers\FRONTOFFICE\LAPORANKASIR;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use PDF;
use DateTime;
use Yajra\DataTables\DataTables;

class penjualanController extends Controller
{

    public function index()
    {
        return view('FRONTOFFICE\LAPORANKASIR.penjualan');
    }

    public function getNmr(Request $request)
    {
        $search = $request->val;
        $kodeigr = $_SESSION['kdigr'];

        $datas = DB::table('tbmaster_supplier')
            ->selectRaw('distinct sup_kodesupplier as sup_kodesupplier')
            ->selectRaw('sup_namasupplier')
            ->where('sup_kodesupplier','LIKE', '%'.$search.'%')
            ->where('sup_kodeigr','=',$kodeigr)
            ->orderBy('sup_namasupplier')
            ->limit(100)
            ->get();

        return response()->json($datas);
    }

    public function getDiv(){
        $datas   = DB::table('tbmaster_divisi')
            ->selectRaw("div_kodedivisi, div_namadivisi")
            ->orderBy('div_kodedivisi')
            ->get();

        return Datatables::of($datas)->make(true);
    }

    public function getDept(Request $request){
        //$search1 = $request->data1;
        //$search2 = $request->data2;

        $datas   = DB::table('tbmaster_departement')
            ->selectRaw("dep_kodedepartement, dep_namadepartement, dep_kodedivisi")
            //->whereRaw("dep_kodedivisi between ".$search1." and ".$search2)
            ->orderBy('dep_kodedepartement')
            ->get();

        return Datatables::of($datas)->make(true);
    }

    public function printDocumentT(Request $request){
        $kodeigr = $_SESSION['kdigr'];
        $dateA = $request->date1;
        $dateB = $request->date2;
        $sDate = DateTime::createFromFormat('d-m-Y', $dateA)->format('d-m-Y');
        $eDate = DateTime::createFromFormat('d-m-Y', $dateB)->format('d-m-Y');
        $qty = $request->qty;
        $dept1 = $request->dept1;
        $dept2 = $request->dept2;
        $div1 = $request->div1;
        $div2 = $request->div2;

        $datas = DB::select("SELECT prs_namaperusahaan, prs_namacabang,
       fdkdiv, div_namadivisi, fdkdep, dep_namadepartement, fdkatb, kat_namakategori,
       SUM(fdnamt + fdfnam) nGross,
       SUM(fdntax + fdftax) nTax,
       SUM(fdnnet + fdfnet) nNet,
       SUM(fdnhpp + fdfhpp) nHpp,
       SUM(fdmrgn + fdfmgn) nMargin,
       SUM(fdjqty + fdfqty) ktQty
FROM TBMASTER_PERUSAHAAN, /*TBMASTER_PRODMAST,*/ TBMASTER_DIVISI, TBMASTER_DEPARTEMENT, TBMASTER_KATEGORI,
(    SELECT sls_kodeigr kodeigr, sls_kodedivisi fdkdiv, sls_kodedepartement fdkdep, sls_kodekategoribrg fdkatb, sls_flagbkp fdfbkp,
           SUM(sls_QtyNOMI) fdjqty, SUM(sls_QtyOMI+sls_QtyIDM) fdfqty,
           SUM(sls_NilaiNOMI) fdnamt, SUM(sls_TaxNOMI) fdntax, SUM(sls_NetNOMI) fdnnet, SUM(sls_HppNOMI) fdnhpp, SUM(sls_MarginNOMI) fdmrgn,
           SUM(sls_NilaiOMI+sls_NilaiIDM) fdfnam,
           SUM(sls_TaxOMI+sls_TaxIDM) fdftax,
           SUM(sls_NetOMI+sls_NetIDM) fdfnet,
           SUM(sls_HppOMI+sls_HppIDM) fdfhpp,
           SUM(sls_MarginOMI+sls_MarginOMI) fdfmgn,
           NVL(cexp,'F') cexp
    FROM TBTR_SUMSALES,
      (    SELECT sls_prdcd prdcd, 'T' cexp
        FROM TBTR_SUMSALES, TBMASTER_BARANGEXPORT, TBTR_JUALDETAIL, TBMASTER_CUSTOMER
        WHERE sls_prdcd = exp_prdcd
          AND trjd_recordid IS NULL
          AND trjd_prdcd = sls_prdcd
          AND TRUNC(trjd_transactiondate) = TRUNC(sls_periode)
          AND TRUNC(trjd_transactiondate) BETWEEN TO_DATE('$sDate','DD-MM-YYYY') AND TO_DATE('$eDate', 'DD-MM-YYYY')
          AND trjd_cus_kodemember = cus_kodemember (+)
           AND cus_jenismember = 'E'
        )
    WHERE TRUNC(sls_periode) BETWEEN TO_DATE('$sDate','DD-MM-YYYY') AND TO_DATE('$eDate', 'DD-MM-YYYY')
      AND sls_prdcd = prdcd(+)
    GROUP BY sls_kodeigr, sls_kodedivisi, sls_kodedepartement, sls_kodekategoribrg,sls_flagbkp, NVL(cexp,'F')
    ORDER BY sls_kodedivisi, sls_kodedepartement, sls_kodekategoribrg
)
WHERE prs_kodeigr = '$kodeigr'
  AND kodeigr = prs_kodeigr
  --AND fdkplu = prd_prdcd
  AND fdkdiv = div_kodedivisi (+)
  AND fdkdep = dep_kodedepartement (+)
  AND fdkdiv = dep_kodedivisi (+)
  AND fdkdep = kat_kodedepartement (+)
  AND fdkatb = kat_kodekategori (+)
  AND ( ( fdkdep BETWEEN '$dept1' AND '$dept2' ) AND ( fdkdiv BETWEEN '$div1' AND '$div2' ) )
GROUP BY prs_namaperusahaan, prs_namacabang, fdkdiv, div_namadivisi, fdkdep, dep_namadepartement, fdkatb, kat_namakategori
ORDER BY fdkdiv, fdkdep, fdkatb");

        $cf_nmargin = [];
        for($i=0;$i<sizeof($datas);$i++){
            if(($datas[$i]->nnet) != 0){
                $cf_nmargin[$i] = round(($datas[$i]->nmargin)*100/($datas[$i]->nnet), 2);
            }else{
                if(($datas[$i]->nmargin) != 0){
                    $cf_nmargin[$i]=100;
                }else{
                    $cf_nmargin[$i]=0;
                }
            }
        }
        //PRINT
        $today = date('d-m-Y');
        $time = date('H:i:s');
        $pdf = PDF::loadview('FRONTOFFICE\LAPORANKASIR\LAPORANPENJUALAN\lap_jual_perkategory_t-pdf',
            ['kodeigr' => $kodeigr, 'date1' => $dateA, 'date2' => $dateB, 'datas' => $datas, 'today' => $today, 'time' => $time, 'qty' => $qty, 'cf_nmargin' => $cf_nmargin]);
        $pdf->setPaper('A4', 'potrait');
        $pdf->output();
        $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);

        $canvas = $dompdf ->get_canvas();
        $canvas->page_text(514, 24, "HAL : {PAGE_NUM} / {PAGE_COUNT}", null, 8, array(0, 0, 0));

        return $pdf->stream('FRONTOFFICE\LAPORANKASIR\LAPORANPENJUALAN\lap_jual_perkategory_t-pdf');
    }
}
