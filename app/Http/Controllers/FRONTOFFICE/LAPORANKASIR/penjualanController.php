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

    public function getToko(Request $request){
        //$search = $request->data;

        $datas = DB::table('TBMASTER_TOKOIGR')
            ->selectRaw("tko_kodeomi, tko_namaomi, tko_namasbu, tko_kodecustomer, tko_kodesbu")
            //->whereRaw("tko_kodesbu like ".$search)
            ->orderBy('tko_kodeomi')
            ->get();

        return Datatables::of($datas)->make(true);
    }

    public function getkat(Request $request){
        //$search1 = $request->data1;
        //$search2 = $request->data2;

        $datas   = DB::table('tbmaster_kategori')
            ->selectRaw("kat_kodekategori, kat_namakategori, kat_kodedepartement")
            //->whereRaw("kat_kodedepartement between ".$search1." and ".$search2)
            ->orderBy('kat_kodekategori')
            ->get();

        return Datatables::of($datas)->make(true);
    }

    public function getMon(Request $request){
        $dateA = $request->date1;
        $dateB = $request->date2;
        $sDate = DateTime::createFromFormat('d-m-Y', $dateA)->format('d-m-Y');
        $eDate = DateTime::createFromFormat('d-m-Y', $dateB)->format('d-m-Y');

        $datas   = DB::select("SELECT DISTINCT mpl_kodemonitoring, mpl_namamonitoring
	FROM TBTR_SUMSALES, TBTR_MONITORINGPLU,
	  (	SELECT sls_prdcd prdcd, 'T' cexp
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
	  AND sls_prdcd = mpl_prdcd
	  ");

        return Datatables::of($datas)->make(true);
    }

    public function printDocumentMenu1(Request $request){
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
        //$elek untuk menentukan apakah pilihan khusus elektronik atau tidak
        $elek = $request->elek;
        if($elek == 'Y'){
            $dept3 = $request->dept3;
            $dept4 = $request->dept4;
            $div3 = $request->div3;
        }

        if($dateA != $dateB){
            $periode = 'PERIODE: '.$dateA.' s/d '.$dateB;
        }else{
            $periode = 'TANGGAL: '.$dateA;
        }
        if($elek == 'Y'){
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
           SUM(sls_MarginOMI+sls_MarginIDM) fdfmgn,
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
  AND ( fdkdiv in ('$div1','$div2','$div3') OR fdkdep in('$dept1','$dept2','$dept3','$dept4') )
GROUP BY prs_namaperusahaan, prs_namacabang, fdkdiv, div_namadivisi, fdkdep, dep_namadepartement, fdkatb, kat_namakategori
ORDER BY fdkdiv, fdkdep, fdkatb");
        }else{
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
        }

        $cf_nmargin = [];
        $cs_tlQty = 0;
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
            $cs_tlQty = $cs_tlQty + $datas[$i]->ktqty;
        }

        //CALCULATE GRAND TOTAL
        if($elek == 'Y'){
            $rec = DB::select("SELECT prs_namaperusahaan, prs_namacabang,
	   fdkdiv, div_namadivisi, fdkdep, dep_namadepartement, fdkatb, kat_namakategori,
	   fdnamt,fdfnam,
     fdntax, fdftax,
     fdnnet, fdfnet,
     fdnhpp, fdfhpp,
     fdmrgn, fdfmgn,
     fdjqty, fdfbkp, cexp
FROM TBMASTER_PERUSAHAAN, /*TBMASTER_PRODMAST,*/ TBMASTER_DIVISI, TBMASTER_DEPARTEMENT, TBMASTER_KATEGORI,
(	SELECT sls_kodeigr kodeigr, sls_kodedivisi fdkdiv, sls_kodedepartement fdkdep, sls_kodekategoribrg fdkatb, sls_flagbkp fdfbkp,
		   SUM(sls_QtyNOMI) fdjqty, SUM(sls_NilaiNOMI) fdnamt, SUM(sls_TaxNOMI) fdntax, SUM(sls_NetNOMI) fdnnet, SUM(sls_HppNOMI) fdnhpp,
		   SUM(sls_MarginNOMI) fdmrgn, SUM(sls_NilaiOMI) fdfnam, SUM(sls_TaxOMI) fdftax, SUM(sls_NetOMI) fdfnet, SUM(sls_HppOMI) fdfhpp, SUM(sls_MarginOMI) fdfmgn,
		   NVL(cexp,'F') cexp
	FROM TBTR_SUMSALES,
	  (	SELECT sls_prdcd prdcd, 'T' cexp
		FROM TBTR_SUMSALES, TBMASTER_BARANGEXPORT, TBTR_JUALDETAIL, TBMASTER_CUSTOMER
		WHERE sls_prdcd = exp_prdcd
		  AND trjd_recordid IS NULL
		  AND trjd_prdcd = sls_prdcd
		  AND TRUNC(trjd_transactiondate) = TRUNC(sls_periode)
		  AND TRUNC(trjd_transactiondate) BETWEEN '1-oct-12' AND '10-oct-12'--:p_tgl1 and :p_tgl2 --
		  AND trjd_cus_kodemember = cus_kodemember (+)
	 	  AND cus_jenismember = 'E'
		)
	WHERE TRUNC(sls_periode) BETWEEN '1-oct-12' AND '10-oct-12'--:p_tgl1 and :p_tgl2 --'1-oct-12' AND '10-oct-12'
	  AND sls_prdcd = prdcd(+)
	GROUP BY sls_kodeigr, sls_kodedivisi, sls_kodedepartement, sls_kodekategoribrg,sls_flagbkp, NVL(cexp,'F')
	ORDER BY sls_kodedivisi, sls_kodedepartement, sls_kodekategoribrg
)
WHERE prs_kodeigr = '$kodeigr'
  AND kodeigr = prs_kodeigr
  AND fdkdiv = div_kodedivisi (+)
  AND fdkdep = dep_kodedepartement (+)
  AND fdkdiv = dep_kodedivisi (+)
  AND fdkdep = kat_kodedepartement (+)
  AND fdkatb = kat_kodekategori (+)
  AND ( fdkdiv in ('$div1','$div2','$div3') OR fdkdep in('$dept1','$dept2','$dept3','$dept4') )
ORDER BY fdkdiv, fdkdep, fdkatb");
        }else{
            $rec = DB::select("SELECT prs_namaperusahaan, prs_namacabang,
	   fdkdiv, div_namadivisi, fdkdep, dep_namadepartement, fdkatb, kat_namakategori, fdfbkp,
	   fdjqty, fdnamt, fdntax, fdnnet, fdnhpp, fdmrgn,
	   fdfqty, fdfnam, fdftax, fdfnet, fdfhpp, fdfmgn, cexp
FROM TBMASTER_PERUSAHAAN, /*TBMASTER_PRODMAST,*/ TBMASTER_DIVISI, TBMASTER_DEPARTEMENT, TBMASTER_KATEGORI,
(	SELECT sls_kodeigr kodeigr, sls_kodedivisi fdkdiv, sls_kodedepartement fdkdep, sls_kodekategoribrg fdkatb, sls_flagbkp fdfbkp,
		   SUM(sls_QtyNOMI) fdjqty, SUM(sls_NilaiNOMI) fdnamt, SUM(sls_TaxNOMI) fdntax, SUM(sls_NetNOMI) fdnnet, SUM(sls_HppNOMI) fdnhpp, SUM(sls_MarginNOMI) fdmrgn,
		   sum(sls_QtyOMI) fdfqty, SUM(sls_NilaiOMI) fdfnam, SUM(sls_TaxOMI) fdftax, SUM(sls_NetOMI) fdfnet, SUM(sls_HppOMI) fdfhpp, SUM(sls_MarginOMI) fdfmgn,
		   NVL(cexp,'F') cexp
	FROM TBTR_SUMSALES,
	  (	SELECT sls_prdcd prdcd, 'T' cexp
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
  AND fdkdiv = div_kodedivisi (+)
  AND fdkdep = dep_kodedepartement (+)
  AND fdkdiv = dep_kodedivisi (+)
  AND fdkdep = kat_kodedepartement (+)
  AND fdkatb = kat_kodekategori (+)
  AND ( ( fdkdep BETWEEN '$dept1' AND '$dept2' ) AND ( fdkdiv BETWEEN '$div1' AND '$div2' ) )
ORDER BY fdkdiv, fdkdep, fdkatb");
        }

        $gross['c'] = 0; $tax['c'] = 0; $net['c'] = 0; $hpp['c'] = 0; $margin['c'] = 0;
        $gross['f'] = 0; $tax['f'] = 0; $net['f'] = 0; $hpp['f'] = 0; $margin['f'] = 0;
        $gross['p'] = 0; $tax['p'] = 0; $net['p'] = 0; $hpp['p'] = 0; $margin['p'] = 0;
        $gross['x'] = 0; $tax['x'] = 0; $net['x'] = 0; $hpp['x'] = 0; $margin['x'] = 0;
        $gross['k'] = 0; $tax['k'] = 0; $net['k'] = 0; $hpp['k'] = 0; $margin['k'] = 0;
        $gross['b'] = 0; $tax['b'] = 0; $net['b'] = 0; $hpp['b'] = 0; $margin['b'] = 0;
        $gross['e'] = 0; $tax['e'] = 0; $net['e'] = 0; $hpp['e'] = 0; $margin['e'] = 0;
        $gross['g'] = 0; $tax['g'] = 0; $net['g'] = 0; $hpp['g'] = 0; $margin['g'] = 0;
        $gross['r'] = 0; $tax['r'] = 0; $net['r'] = 0; $hpp['r'] = 0; $margin['r'] = 0;
        $gross['d'] = 0; $tax['d'] = 0; $net['d'] = 0; $hpp['d'] = 0; $margin['d'] = 0;

        for($i=0;$i<sizeof($rec);$i++){
            if(($rec[$i]->fdkdiv) != '5' && (($rec[$i]->fdkdep != '39') && ($rec[$i]->fdkdep != '40') && ($rec[$i]->fdkdep != '43'))){
                if($rec[$i]->fdntax != 0 || $rec[$i]->fdftax != 0){
                    $gross['p'] = $gross['p'] + ($rec[$i]->fdnamt + $rec[$i]->fdfnam);
                    $tax['p'] = $tax['p'] + ($rec[$i]->fdntax + $rec[$i]->fdftax);
                    $net['p'] = $net['p'] + ($rec[$i]->fdnnet + $rec[$i]->fdfnet);
                    $hpp['p'] = $hpp['p'] + ($rec[$i]->fdnhpp + $rec[$i]->fdfhpp);
                    $margin['p'] = $margin['p'] + ($rec[$i]->fdmrgn + $rec[$i]->fdfmgn);
                }else{
                    if($rec[$i]->fdfbkp == 'C'){
                        $gross['k'] = $gross['k'] + ($rec[$i]->fdnamt + $rec[$i]->fdfnam);
                        $tax['k'] = $tax['k'] + ($rec[$i]->fdntax + $rec[$i]->fdftax);
                        $net['k'] = $net['k'] + ($rec[$i]->fdnnet + $rec[$i]->fdfnet);
                        $hpp['k'] = $hpp['k'] + ($rec[$i]->fdnhpp + $rec[$i]->fdfhpp);
                        $margin['k'] = $margin['k'] + ($rec[$i]->fdmrgn + $rec[$i]->fdfmgn);
                    }elseif($rec[$i]->fdfbkp == 'P'){
                        $gross['b'] = $gross['b'] + ($rec[$i]->fdnamt + $rec[$i]->fdfnam);
                        $tax['b'] = $tax['b'] + ($rec[$i]->fdntax + $rec[$i]->fdftax);
                        $net['b'] = $net['b'] + ($rec[$i]->fdnnet + $rec[$i]->fdfnet);
                        $hpp['b'] = $hpp['b'] + ($rec[$i]->fdnhpp + $rec[$i]->fdfhpp);
                        $margin['b'] = $margin['b'] + ($rec[$i]->fdmrgn + $rec[$i]->fdfmgn);
                    }elseif($rec[$i]->fdfbkp == 'G'){
                        $gross['g'] = $gross['g'] + ($rec[$i]->fdnamt + $rec[$i]->fdfnam);
                        $tax['g'] = $tax['g'] + ($rec[$i]->fdntax + $rec[$i]->fdftax);
                        $net['g'] = $net['g'] + ($rec[$i]->fdnnet + $rec[$i]->fdfnet);
                        $hpp['g'] = $hpp['g'] + ($rec[$i]->fdnhpp + $rec[$i]->fdfhpp);
                        $margin['g'] = $margin['g'] + ($rec[$i]->fdmrgn + $rec[$i]->fdfmgn);
                    }elseif($rec[$i]->fdfbkp == 'W'){
                        $gross['r'] = $gross['r'] + ($rec[$i]->fdnamt + $rec[$i]->fdfnam);
                        $tax['r'] = $tax['r'] + ($rec[$i]->fdntax + $rec[$i]->fdftax);
                        $net['r'] = $net['r'] + ($rec[$i]->fdnnet + $rec[$i]->fdfnet);
                        $hpp['r'] = $hpp['r'] + ($rec[$i]->fdnhpp + $rec[$i]->fdfhpp);
                        $margin['r'] = $margin['r'] + ($rec[$i]->fdmrgn + $rec[$i]->fdfmgn);
                    }else{
                        if($rec[$i]->cexp == 'Y'){
                            $gross['e'] = $gross['e'] + ($rec[$i]->fdnamt + $rec[$i]->fdfnam);
                            $tax['e'] = $tax['e'] + ($rec[$i]->fdntax + $rec[$i]->fdftax);
                            $net['e'] = $net['e'] + ($rec[$i]->fdnnet + $rec[$i]->fdfnet);
                            $hpp['e'] = $hpp['e'] + ($rec[$i]->fdnhpp + $rec[$i]->fdfhpp);
                            $margin['e'] = $margin['e'] + ($rec[$i]->fdmrgn + $rec[$i]->fdfmgn);
                        }else{
                            $gross['x'] = $gross['x'] + ($rec[$i]->fdnamt + $rec[$i]->fdfnam);
                            $tax['x'] = $tax['x'] + ($rec[$i]->fdntax + $rec[$i]->fdftax);
                            $net['x'] = $net['x'] + ($rec[$i]->fdnnet + $rec[$i]->fdfnet);
                            $hpp['x'] = $hpp['x'] + ($rec[$i]->fdnhpp + $rec[$i]->fdfhpp);
                            $margin['x'] = $margin['x'] + ($rec[$i]->fdmrgn + $rec[$i]->fdfmgn);
                        }
                    }
                }
            }elseif($rec[$i]->fdkdiv == '5' && $rec[$i]->fdkdep == '39'){
                $gross['c'] = $gross['c'] + ($rec[$i]->fdnamt + $rec[$i]->fdfnam);
                $tax['c'] = $tax['c'] + ($rec[$i]->fdntax + $rec[$i]->fdftax);
                $net['c'] = $net['c'] + ($rec[$i]->fdnnet + $rec[$i]->fdfnet);
                $hpp['c'] = $hpp['c'] + ($rec[$i]->fdnhpp + $rec[$i]->fdfhpp);
                $margin['c'] = $margin['c'] + ($rec[$i]->fdmrgn + $rec[$i]->fdfmgn);
            }elseif($rec[$i]->fdkdiv == '5' && $rec[$i]->fdkdep == '40'){
                $gross['d'] = $gross['d'] + ($rec[$i]->fdnamt + $rec[$i]->fdfnam);
                $tax['d'] = $tax['d'] + ($rec[$i]->fdntax + $rec[$i]->fdftax);
                $net['d'] = $net['d'] + ($rec[$i]->fdnnet + $rec[$i]->fdfnet);
                $hpp['d'] = $hpp['d'] + ($rec[$i]->fdnhpp + $rec[$i]->fdfhpp);
                $margin['d'] = $margin['d'] + ($rec[$i]->fdmrgn + $rec[$i]->fdfmgn);
            }
            elseif($rec[$i]->fdkdiv == '5' && $rec[$i]->fdkdep == '43'){
                $gross['f'] = $gross['f'] + ($rec[$i]->fdnamt + $rec[$i]->fdfnam);
                $tax['f'] = $tax['f'] + ($rec[$i]->fdntax + $rec[$i]->fdftax);
                $net['f'] = $net['f'] + ($rec[$i]->fdnnet + $rec[$i]->fdfnet);
                $hpp['f'] = $hpp['f'] + ($rec[$i]->fdnhpp + $rec[$i]->fdfhpp);
                $margin['f'] = $margin['f'] + ($rec[$i]->fdmrgn + $rec[$i]->fdfmgn);
            }
        }

        //persentase margin
        if($net['c'] != 0){
            $marginpersen['c'] = round(($margin['c'])*100/($net['c']), 2);
        }else{
            if(($margin['c']) != 0){
                $marginpersen['c']=100;
            }else{
                $marginpersen['c']=0;
            }
        }
        if($net['f'] != 0){
            $marginpersen['f'] = round(($margin['f'])*100/($net['f']), 2);
        }else{
            if(($margin['f']) != 0){
                $marginpersen['f']=100;
            }else{
                $marginpersen['f']=0;
            }
        }
        if($net['p'] != 0){
            $marginpersen['p'] = round(($margin['p'])*100/($net['p']), 2);
        }else{
            if(($margin['p']) != 0){
                $marginpersen['p']=100;
            }else{
                $marginpersen['p']=0;
            }
        }
        if($net['x'] != 0){
            $marginpersen['x'] = round(($margin['x'])*100/($net['x']), 2);
        }else{
            if(($margin['x']) != 0){
                $marginpersen['x']=100;
            }else{
                $marginpersen['x']=0;
            }
        }
        if($net['k'] != 0){
            $marginpersen['k'] = round(($margin['k'])*100/($net['k']), 2);
        }else{
            if(($margin['k']) != 0){
                $marginpersen['k']=100;
            }else{
                $marginpersen['k']=0;
            }
        }
        if($net['b'] != 0){
            $marginpersen['b'] = round(($margin['b'])*100/($net['b']), 2);
        }else{
            if(($margin['b']) != 0){
                $marginpersen['b']=100;
            }else{
                $marginpersen['b']=0;
            }
        }
        if($net['e'] != 0){
            $marginpersen['e'] = round(($margin['e'])*100/($net['e']), 2);
        }else{
            if(($margin['e']) != 0){
                $marginpersen['e']=100;
            }else{
                $marginpersen['e']=0;
            }
        }
        if($net['g'] != 0){
            $marginpersen['g'] = round(($margin['g'])*100/($net['g']), 2);
        }else{
            if(($margin['g']) != 0){
                $marginpersen['g']=100;
            }else{
                $marginpersen['g']=0;
            }
        }
        if($net['r'] != 0){
            $marginpersen['r'] = round(($margin['r'])*100/($net['r']), 2);
        }else{
            if(($margin['r']) != 0){
                $marginpersen['r']=100;
            }else{
                $marginpersen['r']=0;
            }
        }
        if($net['d'] != 0){
            $marginpersen['d'] = round(($margin['d'])*100/($net['d']), 2);
        }else{
            if(($margin['d']) != 0){
                $marginpersen['d']=100;
            }else{
                $marginpersen['d']=0;
            }
        }

        //ULTIMATE GRAND TOTAL
        $gross['total'] = 0; $tax['total'] = 0; $net['total'] = 0; $hpp['total'] = 0; $margin['total'] = 0; $qtyGrandTotal = 0;
        for($i=0;$i<sizeof($datas);$i++){
            $gross['total'] = $gross['total'] + $datas[$i]->ngross;
            $tax['total'] = $tax['total'] + $datas[$i]->ntax;
            $net['total'] = $net['total'] + $datas[$i]->nnet;
            $hpp['total'] = $hpp['total'] + $datas[$i]->nhpp;
            $margin['total'] = $margin['total'] + $datas[$i]->nmargin;
            $qtyGrandTotal = $qtyGrandTotal + $datas[$i]->ktqty;
        }
        $gross['total'] = round($gross['total'], 0);
        $tax['total'] = round($tax['total'], 0);
        $net['total'] = round($net['total'], 0);
        $hpp['total'] = round($hpp['total'], 0);
        $margin['total'] = round($margin['total'], 0);

        if($net['total'] != 0){
            $marginpersen['total'] = round(($margin['total'])*100/($net['total']), 2);
        }else{
            if(($margin['total']) != 0){
                $marginpersen['total']=100;
            }else{
                $marginpersen['total']=0;
            }
        }

        //PRINT
        $today = date('d-m-Y');
        $time = date('H:i:s');
        $pdf = PDF::loadview('FRONTOFFICE\LAPORANKASIR\LAPORANPENJUALAN\lap_jual_perkategory_t-pdf',
            ['kodeigr' => $kodeigr, 'date1' => $dateA, 'date2' => $dateB, 'datas' => $datas, 'today' => $today, 'time' => $time,
                'qty' => $qty, 'cf_nmargin' => $cf_nmargin, 'periode' => $periode,
                'gross' => $gross, 'tax' => $tax, 'net' => $net, 'hpp' => $hpp,'margin' => $margin, 'marginpersen' => $marginpersen, 'qtygrandtotal' => $qtyGrandTotal]);
        $pdf->setPaper('A4', 'potrait');
        $pdf->output();
        $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);

        $canvas = $dompdf ->get_canvas();
        $canvas->page_text(514, 24, "HAL : {PAGE_NUM} / {PAGE_COUNT}", null, 8, array(0, 0, 0));

        return $pdf->stream('FRONTOFFICE\LAPORANKASIR\LAPORANPENJUALAN\lap_jual_perkategory_t-pdf');
    }

    public function printDocumentMenu2(Request $request){
        $kodeigr = $_SESSION['kdigr'];
        $dateA = $request->date1;
        $dateB = $request->date2;
        $sDate = DateTime::createFromFormat('d-m-Y', $dateA)->format('d-m-Y');
        $eDate = DateTime::createFromFormat('d-m-Y', $dateB)->format('d-m-Y');
        $export = $request->export; //P_CKSRX
        $grosirA = $request->grosira;
        $lst_print = $request->lst_print;

        if($dateA != $dateB){
            $periode = 'PERIODE: '.$dateA.' s/d '.$dateB;
        }else{
            $periode = 'TANGGAL: '.$dateA;
        }
            $datas = DB::select("SELECT prs_namaperusahaan, prs_namacabang, cdiv, div_namadivisi, cdept, dep_namadepartement, fdfbkp, cexp,
       CASE WHEN '$export' = 'Y' THEN 'LAPORAN PENJUALAN (EXPORT)' ELSE 'LAPORAN PENJUALAN' END title,
       SUM(fdnamt + CASE WHEN '$grosirA'='T' THEN fdfnam ELSE 0 END) nGross, --fdnamt+fdfnam
       CASE WHEN '$export' <> 'Y' THEN SUM( CASE WHEN '$export' <> 'Y' THEN fdntax END + CASE WHEN '$grosirA'='T' THEN fdftax ELSE 0 END  ) END nTax, --fdntax+fdftax
       SUM(fdnnet + CASE WHEN '$grosirA'='T' THEN fdfnet ELSE 0 END) nNet, --fdnnet+fdfnet
       SUM(fdnhpp + CASE WHEN '$grosirA'='T' THEN fdfhpp ELSE 0 END) nHpp, --fdnhpp+fdfhpp
       SUM(fdmrgn + CASE WHEN '$grosirA'='T' THEN fdfmgn ELSE 0 END) nMargin --fdmrgn+fdfmgn
FROM TBMASTER_PERUSAHAAN, TBMASTER_DIVISI, TBMASTER_DEPARTEMENT,
(    SELECT sls_kodeigr, sls_kodedivisi cdiv, sls_kodedepartement cdept, sls_flagbkp fdfbkp,
           (sls_NilaiNOMI) fdnamt,
           (sls_TaxNOMI) fdntax,
           (sls_NetNOMI) fdnnet,
           (sls_HppNOMI) fdnhpp,
           (sls_MarginNOMI) fdmrgn,
           (sls_NilaiOMI+sls_NilaiIDM) fdfnam,
           (sls_TaxOMI+sls_TaxIDM) fdftax,
           (sls_NetOMI+sls_NetIDM) fdfnet,
           (sls_HppOMI+sls_HppIDM) fdfhpp,
           (sls_MarginOMI+sls_MarginIDM) fdfmgn,
           NVL(cexp,'F') cexp,
           CASE WHEN '$export' ='Y' THEN NVL(cStat,'F') ELSE NVL(cStat,'T') END cStat
    FROM TBTR_SUMSALES,
    (    SELECT sls_prdcd prdcd, 'T' cexp, 'T' cStat
        FROM TBTR_SUMSALES, TBMASTER_BARANGEXPORT, TBTR_JUALDETAIL, TBMASTER_CUSTOMER
        WHERE sls_prdcd = exp_prdcd
          AND trjd_recordid IS NULL
          AND trjd_prdcd = sls_prdcd
          AND TRUNC(trjd_transactiondate) = TRUNC(sls_periode)
          AND trjd_cus_kodemember = cus_kodemember (+)
           AND cus_jenismember = 'E'
        )
    WHERE TRUNC(sls_periode) BETWEEN TO_DATE('$sDate','DD-MM-YYYY') AND TO_DATE('$eDate', 'DD-MM-YYYY')
      AND sls_prdcd = prdcd(+)
)
WHERE prs_kodeigr = '$kodeigr'
  AND sls_kodeigr = prs_kodeigr
  AND cdiv = div_kodedivisi
  AND cdept = dep_kodedepartement
  AND cStat = 'T'
GROUP BY sls_kodeigr, prs_namaperusahaan, prs_namacabang, cdiv, div_namadivisi, cdept, dep_namadepartement, fdfbkp, cexp
ORDER BY cdiv,cdept");

        if(sizeof($datas) == 0){
            return "**DATA TIDAK ADA**";
        }

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

        //CALCULATE GRAND TOTAL

        $gross['k'] = 0; $tax['k'] = 0; $net['k'] = 0; $hpp['k'] = 0; $margin['k'] = 0;
        $gross['p'] = 0; $tax['p'] = 0; $net['p'] = 0; $hpp['p'] = 0; $margin['p'] = 0;
        $gross['b'] = 0; $tax['b'] = 0; $net['b'] = 0; $hpp['b'] = 0; $margin['b'] = 0;
        $gross['c'] = 0; $tax['c'] = 0; $net['c'] = 0; $hpp['c'] = 0; $margin['c'] = 0;
        $gross['g'] = 0; $tax['g'] = 0; $net['g'] = 0; $hpp['g'] = 0; $margin['g'] = 0;
        $gross['r'] = 0; $tax['r'] = 0; $net['r'] = 0; $hpp['r'] = 0; $margin['r'] = 0;
        $gross['x'] = 0; $tax['x'] = 0; $net['x'] = 0; $hpp['x'] = 0; $margin['x'] = 0;
        $gross['e'] = 0; $tax['e'] = 0; $net['e'] = 0; $hpp['e'] = 0; $margin['e'] = 0;
        $gross['d'] = 0; $tax['d'] = 0; $net['d'] = 0; $hpp['d'] = 0; $margin['d'] = 0;
        $gross['f'] = 0; $tax['f'] = 0; $net['f'] = 0; $hpp['f'] = 0; $margin['f'] = 0;

        for($i=0;$i<sizeof($datas);$i++) {
            if (($datas[$i]->cdiv) != '5' && (($datas[$i]->cdept != '39') && ($datas[$i]->cdept != '40') && ($datas[$i]->cdept != '43'))) {
                if ($datas[$i]->ntax != 0){
                    $gross['p'] = $gross['p'] + $datas[$i]->ngross;
                    $tax['p'] = $tax['p'] + $datas[$i]->ntax;
                    $net['p'] = $net['p'] + $datas[$i]->nnet;
                    $hpp['p'] = $hpp['p'] + $datas[$i]->nhpp;
                    $margin['p'] = $margin['p'] + $datas[$i]->nmargin;
                }else{
                    switch ($datas[$i]->fdfbkp){
                        case 'C' :
                            $gross['k'] = $gross['k'] + $datas[$i]->ngross;
                            $tax['k'] = $tax['k'] + $datas[$i]->ntax;
                            $net['k'] = $net['k'] + $datas[$i]->nnet;
                            $hpp['k'] = $hpp['k'] + $datas[$i]->nhpp;
                            $margin['k'] = $margin['k'] + $datas[$i]->nmargin;
                            break;
                        case 'P' :
                            $gross['b'] = $gross['b'] + $datas[$i]->ngross;
                            $tax['b'] = $tax['b'] + $datas[$i]->ntax;
                            $net['b'] = $net['b'] + $datas[$i]->nnet;
                            $hpp['b'] = $hpp['b'] + $datas[$i]->nhpp;
                            $margin['b'] = $margin['b'] + $datas[$i]->nmargin;
                            break;
                        case 'G' :
                            $gross['g'] = $gross['g'] + $datas[$i]->ngross;
                            $tax['g'] = $tax['g'] + $datas[$i]->ntax;
                            $net['g'] = $net['g'] + $datas[$i]->nnet;
                            $hpp['g'] = $hpp['g'] + $datas[$i]->nhpp;
                            $margin['g'] = $margin['g'] + $datas[$i]->nmargin;
                            break;
                        case 'W' :
                            $gross['r'] = $gross['r'] + $datas[$i]->ngross;
                            $tax['r'] = $tax['r'] + $datas[$i]->ntax;
                            $net['r'] = $net['r'] + $datas[$i]->nnet;
                            $hpp['r'] = $hpp['r'] + $datas[$i]->nhpp;
                            $margin['r'] = $margin['r'] + $datas[$i]->nmargin;
                            break;
                        default :
                            if($grosirA == 'T' && ($datas[$i]->cexp == 'T')){
                                $gross['e'] = $gross['e'] + $datas[$i]->ngross;
                                if($export != 'Y'){
                                    $tax['e'] = $tax['e'] + $datas[$i]->ntax;
                                }
                                $net['e'] = $net['e'] + $datas[$i]->nnet;
                                $hpp['e'] = $hpp['e'] + $datas[$i]->nhpp;
                                $margin['e'] = $margin['e'] + $datas[$i]->nmargin;
                            }else{
                                $gross['x'] = $gross['x'] + $datas[$i]->ngross;
                                if($export != 'Y'){
                                    $tax['x'] = $tax['x'] + $datas[$i]->ntax;
                                }
                                $net['x'] = $net['x'] + $datas[$i]->nnet;
                                $hpp['x'] = $hpp['x'] + $datas[$i]->nhpp;
                                $margin['x'] = $margin['x'] + $datas[$i]->nmargin;
                            }
                    }
                }
            }elseif(($datas[$i]->cdiv) == '5' && ($datas[$i]->cdept) == '39'){
                $gross['c'] = $gross['c'] + $datas[$i]->ngross;
                $tax['c'] = $tax['c'] + $datas[$i]->ntax;
                $net['c'] = $net['c'] + $datas[$i]->nnet;
                $hpp['c'] = $hpp['c'] + $datas[$i]->nhpp;
                $margin['c'] = $margin['c'] + $datas[$i]->nmargin;
            }elseif(($datas[$i]->cdiv) == '5' && ($datas[$i]->cdept) == '40'){
                $gross['d'] = $gross['d'] + $datas[$i]->ngross;
                $tax['d'] = $tax['d'] + $datas[$i]->ntax;
                $net['d'] = $net['d'] + $datas[$i]->nnet;
                $hpp['d'] = $hpp['d'] + $datas[$i]->nhpp;
                $margin['d'] = $margin['d'] + $datas[$i]->nmargin;
            }elseif(($datas[$i]->cdiv) == '5' && ($datas[$i]->cdept) == '43'){
                $gross['f'] = $gross['f'] + $datas[$i]->ngross;
                $tax['f'] = $tax['f'] + $datas[$i]->ntax;
                $net['f'] = $net['f'] + $datas[$i]->nnet;
                $hpp['f'] = $hpp['f'] + $datas[$i]->nhpp;
                $margin['f'] = $margin['f'] + $datas[$i]->nmargin;
            }
        }

        //persentase margin
        if($net['c'] != 0){
            $marginpersen['c'] = round(($margin['c'])*100/($net['c']), 2);
        }else{
            if(($margin['c']) != 0){
                $marginpersen['c']=100;
            }else{
                $marginpersen['c']=0;
            }
        }
        if($net['f'] != 0){
            $marginpersen['f'] = round(($margin['f'])*100/($net['f']), 2);
        }else{
            if(($margin['f']) != 0){
                $marginpersen['f']=100;
            }else{
                $marginpersen['f']=0;
            }
        }
        if($net['p'] != 0){
            $marginpersen['p'] = round(($margin['p'])*100/($net['p']), 2);
        }else{
            if(($margin['p']) != 0){
                $marginpersen['p']=100;
            }else{
                $marginpersen['p']=0;
            }
        }
        if($net['x'] != 0){
            $marginpersen['x'] = round(($margin['x'])*100/($net['x']), 2);
        }else{
            if(($margin['x']) != 0){
                $marginpersen['x']=100;
            }else{
                $marginpersen['x']=0;
            }
        }
        if($net['k'] != 0){
            $marginpersen['k'] = round(($margin['k'])*100/($net['k']), 2);
        }else{
            if(($margin['k']) != 0){
                $marginpersen['k']=100;
            }else{
                $marginpersen['k']=0;
            }
        }
        if($net['b'] != 0){
            $marginpersen['b'] = round(($margin['b'])*100/($net['b']), 2);
        }else{
            if(($margin['b']) != 0){
                $marginpersen['b']=100;
            }else{
                $marginpersen['b']=0;
            }
        }
        if($net['e'] != 0){
            $marginpersen['e'] = round(($margin['e'])*100/($net['e']), 2);
        }else{
            if(($margin['e']) != 0){
                $marginpersen['e']=100;
            }else{
                $marginpersen['e']=0;
            }
        }
        if($net['g'] != 0){
            $marginpersen['g'] = round(($margin['g'])*100/($net['g']), 2);
        }else{
            if(($margin['g']) != 0){
                $marginpersen['g']=100;
            }else{
                $marginpersen['g']=0;
            }
        }
        if($net['r'] != 0){
            $marginpersen['r'] = round(($margin['r'])*100/($net['r']), 2);
        }else{
            if(($margin['r']) != 0){
                $marginpersen['r']=100;
            }else{
                $marginpersen['r']=0;
            }
        }
        if($net['d'] != 0){
            $marginpersen['d'] = round(($margin['d'])*100/($net['d']), 2);
        }else{
            if(($margin['d']) != 0){
                $marginpersen['d']=100;
            }else{
                $marginpersen['d']=0;
            }
        }

        //ULTIMATE GRAND TOTAL
        $gross['total'] = 0; $tax['total'] = 0; $net['total'] = 0; $hpp['total'] = 0; $margin['total'] = 0;
        for($i=0;$i<sizeof($datas);$i++){
            $gross['total'] = $gross['total'] + $datas[$i]->ngross;
            $tax['total'] = $tax['total'] + $datas[$i]->ntax;
            $net['total'] = $net['total'] + $datas[$i]->nnet;
            $hpp['total'] = $hpp['total'] + $datas[$i]->nhpp;
            $margin['total'] = $margin['total'] + $datas[$i]->nmargin;
        }
        $gross['total'] = round($gross['total'], 0);
        $tax['total'] = round($tax['total'], 0);
        $net['total'] = round($net['total'], 0);
        $hpp['total'] = round($hpp['total'], 0);
        $margin['total'] = round($margin['total'], 0);

        if($net['total'] != 0){
            $marginpersen['total'] = round(($margin['total'])*100/($net['total']), 2);
        }else{
            if(($margin['total']) != 0){
                $marginpersen['total']=100;
            }else{
                $marginpersen['total']=0;
            }
        }

        if($net['total'] != 0){
            $marginpersen['total'] = round(($margin['total'])*100/($net['total']), 2);
        }else{
            if(($margin['total']) != 0){
                $marginpersen['total']=100;
            }else{
                $marginpersen['total']=0;
            }
        }

        if($net['total']-$net['d'] != 0){
            $marginpersen['tminp'] = round(($margin['total']-$margin['d'])*100/($net['total']-$net['d']), 2);
        }else{
            if(($margin['total']-$margin['d']) != 0){
                $marginpersen['tminp']=100;
            }else{
                $marginpersen['tminp']=0;
            }
        }

        //PRINT
        $today = date('d-m-Y');
        $time = date('H:i:s');
        $pdf = PDF::loadview('FRONTOFFICE\LAPORANKASIR\LAPORANPENJUALAN\lap_jual_perdept-pdf',
            ['kodeigr' => $kodeigr, 'date1' => $dateA, 'date2' => $dateB, 'datas' => $datas, 'today' => $today, 'time' => $time,
                'keterangan' => $lst_print, 'cf_nmargin' => $cf_nmargin, 'periode' => $periode,
                'gross' => $gross, 'tax' => $tax, 'net' => $net, 'hpp' => $hpp,'margin' => $margin, 'marginpersen' => $marginpersen]);
        $pdf->setPaper('A4', 'potrait');
        $pdf->output();
        $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);

        $canvas = $dompdf ->get_canvas();
        $canvas->page_text(514, 24, "HAL : {PAGE_NUM} / {PAGE_COUNT}", null, 8, array(0, 0, 0));

        return $pdf->stream('FRONTOFFICE\LAPORANKASIR\LAPORANPENJUALAN\lap_jual_perdept-pdf');
    }

    public function printDocumentDMenu2(Request $request){
        $kodeigr = $_SESSION['kdigr'];
        $dateA = $request->date1;
        $dateB = $request->date2;
        $sDate = DateTime::createFromFormat('d-m-Y', $dateA)->format('d-m-Y');
        $eDate = DateTime::createFromFormat('d-m-Y', $dateB)->format('d-m-Y');
        $p_sbu = '';
        $p_khusus = '';
        $p_omi = '';
        $lst_print = $request->lst_print;
        if($dateA != $dateB){
            $periode = 'PERIODE: '.$dateA.' s/d '.$dateB;
        }else{
            $periode = 'TANGGAL: '.$dateA;
        }
        if($request->p_sbu != 'z'){
            $p_sbu = 'AND tko_kodesbu = '.$request->p_sbu;
        }
        if($request->p_khusus != 'z'){
            $p_khusus = 'AND SUBSTR(tko_kodeomi,1,1) = '.$request->p_khusus;
        }
        if($request->p_omi != 'z'){
            $p_omi = 'AND tko_kodeomi = '.$request->p_omi;
        }

        $datas = DB::select("SELECT prs_namaperusahaan, prs_namacabang, omisbu, namasbu, omikod, namaomi, omidiv, div_namadivisi, dep_namadepartement, omidep,
	   SUM(CASE WHEN fdtipe='S' THEN nNet    ELSE nNet*-1    END) ominet,
	   SUM(CASE WHEN fdtipe='S' THEN nGross  ELSE nGross*-1  END) omiamt,
	   SUM(CASE WHEN fdtipe='S' THEN nTax    ELSE nTax  *-1  END) omitax,
	   SUM(CASE WHEN fdtipe='S' THEN nHpp    ELSE nHpp*-1    END) omihpp,
	   SUM(CASE WHEN fdtipe='S' THEN nMargin ELSE nMargin*-1 END) omimrg
FROM TBMASTER_PERUSAHAAN, TBMASTER_DIVISI, TBMASTER_DEPARTEMENT,
(	SELECT kodeigr, omikod, namaomi, omisbu, namasbu, omimem, fdkdiv omidiv, fddiv omidep, cBkp, mark_up, fdtipe,
		  CASE WHEN Fdkdiv = '5' AND fddiv = '39' THEN
	         0
	      ELSE
	         CASE WHEN omisbu = 'O' OR omisbu = 'I' THEN
	           CASE WHEN cBkp = 'Y' THEN ((fdnamt*1.1)-Fdnamt) ELSE 0 END
	         ELSE
	           CASE WHEN cBkp = 'Y' THEN (fdnamt-(Fdnamt/1.1)) ELSE 0 END
	         END
	      END nTax,
	      CASE WHEN Fdkdiv = '5' AND fddiv = '39' THEN
	         Fdnamt
	      ELSE
	         CASE WHEN  omisbu = 'O' OR omisbu = 'I' THEN
	            Fdnamt
	         ELSE
	            Fdnamt-(CASE WHEN cBkp = 'Y' THEN (fdnamt-(Fdnamt/1.1)) ELSE 0 END)
	         END
	      END nNet,
	      CASE WHEN Fdkdiv = '5' AND fddiv = '39' THEN
	         CASE WHEN Mark_up IS NULL THEN ((5*Fdnamt)/100) ELSE ((Mark_up*Fdnamt)/100) END
	      ELSE
	         (CASE WHEN  omisbu = 'O' OR omisbu = 'I' THEN Fdnamt ELSE Fdnamt-(CASE WHEN cBkp = 'Y' THEN (fdnamt-(Fdnamt/1.1)) ELSE 0 END) END) -
			 ( Fdjqty/(CASE WHEN unit='KG'THEN 1000 ELSE 1 END)*Fdcost)
	      END nMargin,
	      CASE WHEN Fdkdiv = '5' AND fddiv = '39' THEN
	         Fdnamt - (CASE WHEN Mark_up IS NULL THEN ((5*Fdnamt)/100) ELSE ((Mark_up*Fdnamt)/100) END)
	      ELSE
	         (Fdjqty/(CASE WHEN unit='KG'THEN 1000 ELSE 1 END)*Fdcost)
	      END nHpp,
	      CASE WHEN omisbu = 'O' OR omisbu = 'I' THEN
	         CASE WHEN cBkp = 'Y' THEN
	            fdnamt*1.1
	         ELSE
	            fdnamt
	         END
	      ELSE
	         fdnamt
	      END nGross
	FROM
	(	SELECT tko_kodeigr kodeigr, tko_kodeOMI omikod, tko_namaomi namaomi, tko_kodeSBU omisbu, tko_namasbu namasbu, trjd_cus_kodemember omimem, trjd_divisioncode fdkdiv, SUBSTR(trjd_division,1,2) fddiv,
			   trjd_nominalamt fdnamt, trjd_baseprice fdcost, trjd_quantity fdjqty, prd_unit unit, prd_markUpStandard mark_up,
			   trjd_transactiontype fdtipe, trjd_flagtax1 cBkp,
			   CASE WHEN trjd_cus_kodemember NOT IN (SELECT cus_kodemember FROM TBMASTER_CUSTOMER) THEN 'T' ELSE cus_flagPKP END pjkO
		FROM TBMASTER_TOKOIGR, TBTR_JUALDETAIL, TBMASTER_CUSTOMER, TBMASTER_PRODMAST
		WHERE trjd_cus_kodemember = tko_kodecustomer
		  AND trjd_cus_kodemember = cus_kodemember
		  AND trjd_prdcd = prd_prdcd and trjd_quantity > 0
		  ".$p_sbu." ".$p_khusus." ".$p_omi."
		  AND TRUNC(trjd_transactiondate) BETWEEN TO_DATE('$sDate','DD-MM-YYYY') AND TO_DATE('$eDate', 'DD-MM-YYYY')
		  AND tko_kodeOMI NOT IN (SELECT tko_kodeOMI FROM TBMASTER_TOKOIGR WHERE tko_tipeOMI IN ('HR','HG'))
	)
)
WHERE prs_kodeigr = '$kodeigr'
  AND kodeigr = prs_kodeigr
  AND omidiv = div_kodedivisi
  AND omidep = dep_kodedepartement
GROUP BY prs_namaperusahaan, prs_namacabang, omikod, namaomi, omisbu, namasbu, omidiv, div_namadivisi, omidep, dep_namadepartement
ORDER BY omikod");

        if(sizeof($datas) == 0){
            return "**DATA TIDAK ADA**";
        }


        $cf_nmargin = [];
        for($i=0;$i<sizeof($datas);$i++){
            if(($datas[$i]->ominet) != 0){
                $cf_nmargin[$i] = round(($datas[$i]->omimrg)*100/($datas[$i]->ominet), 2);
            }else{
                if(($datas[$i]->nmargin) != 0){
                    $cf_nmargin[$i]=100;
                }else{
                    $cf_nmargin[$i]=0;
                }
            }
        }

        //CALCULATE GRAND TOTAL

        $gross['i'] = 0; $tax['i'] = 0; $net['i'] = 0; $hpp['i'] = 0; $margin['i'] = 0;
        $gross['o'] = 0; $tax['o'] = 0; $net['o'] = 0; $hpp['o'] = 0; $margin['o'] = 0;
        $gross['total'] = 0; $tax['total'] = 0; $net['total'] = 0; $hpp['total'] = 0; $margin['total'] = 0;

        for($i=0;$i<sizeof($datas);$i++) {
            if($datas[$i]->omisbu == 'O'){
                $gross['o'] = $gross['o'] + $datas[$i]->omiamt;
                $tax['o'] = $tax['o'] + $datas[$i]->omitax;
                $net['o'] = $net['o'] + $datas[$i]->ominet;
                $hpp['o'] = $hpp['o'] + $datas[$i]->omihpp;
                $margin['o'] = $margin['o'] + $datas[$i]->omimrg;
            }else{
                $gross['i'] = $gross['i'] + $datas[$i]->omiamt;
                $tax['i'] = $tax['i'] + $datas[$i]->omitax;
                $net['i'] = $net['i'] + $datas[$i]->ominet;
                $hpp['i'] = $hpp['i'] + $datas[$i]->omihpp;
                $margin['i'] = $margin['i'] + $datas[$i]->omimrg;
            }
            $gross['total'] = $gross['total'] + $datas[$i]->omiamt;
            $tax['total'] = $tax['total'] + $datas[$i]->omitax;
            $net['total'] = $net['total'] + $datas[$i]->ominet;
            $hpp['total'] = $hpp['total'] + $datas[$i]->omihpp;
            $margin['total'] = $margin['total'] + $datas[$i]->omimrg;
        }

        //persentase margin
        if($net['i'] != 0){
            $marginpersen['i'] = round(($margin['i'])/($net['i'])*100, 2);
        }else{
            $marginpersen['i']=0;
        }
        if($net['o'] != 0){
            $marginpersen['o'] = round(($margin['o'])/($net['o'])*100, 2);
        }else{
            $marginpersen['o']=0;
        }
        if($net['total'] != 0){
            $marginpersen['total'] = round(($margin['total'])*100/($net['total']), 2);
        }else{
            if(($margin['total']) != 0){
                $marginpersen['total']=100;
            }else{
                $marginpersen['total']=0;
            }
        }

//        //PRINT
        $today = date('d-m-Y');
        $time = date('H:i:s');
//        $pdf = PDF::loadview('FRONTOFFICE\LAPORANKASIR\LAPORANPENJUALAN\lap_jual_perdept_cd-pdf',
//            ['kodeigr' => $kodeigr, 'date1' => $dateA, 'date2' => $dateB, 'datas' => $datas, 'today' => $today, 'time' => $time,
//                'keterangan' => $lst_print, 'cf_nmargin' => $cf_nmargin, 'periode' => $periode,
//                'gross' => $gross, 'tax' => $tax, 'net' => $net, 'hpp' => $hpp,'margin' => $margin, 'marginpersen' => $marginpersen]);
//        $pdf->setPaper('A4', 'potrait');
//        $pdf->output();
//        $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);
//
//        $canvas = $dompdf ->get_canvas();
//        $canvas->page_text(514, 24, "HAL : {PAGE_NUM} / {PAGE_COUNT}", null, 8, array(0, 0, 0));
//
//        return $pdf->stream('FRONTOFFICE\LAPORANKASIR\LAPORANPENJUALAN\lap_jual_perdept_cd-pdf');

        return view('FRONTOFFICE\LAPORANKASIR\LAPORANPENJUALAN\lap_jual_perdept_d-pdf',['kodeigr' => $kodeigr, 'date1' => $dateA, 'date2' => $dateB, 'datas' => $datas, 'today' => $today, 'time' => $time,
            'keterangan' => $lst_print, 'cf_nmargin' => $cf_nmargin, 'periode' => $periode,
            'gross' => $gross, 'tax' => $tax, 'net' => $net, 'hpp' => $hpp,'margin' => $margin, 'marginpersen' => $marginpersen]);
    }

    public function printDocumentCMenu2(Request $request){
        $kodeigr = $_SESSION['kdigr'];
        $dateA = $request->date1;
        $dateB = $request->date2;
        $sDate = DateTime::createFromFormat('d-m-Y', $dateA)->format('d-m-Y');
        $eDate = DateTime::createFromFormat('d-m-Y', $dateB)->format('d-m-Y');
        $p_sbu = '';
        $p_khusus = '';
        $p_omi = '';
        $lst_print = $request->lst_print;
        if($dateA != $dateB){
            $periode = 'PERIODE: '.$dateA.' s/d '.$dateB;
        }else{
            $periode = 'TANGGAL: '.$dateA;
        }
        if($request->p_sbu != 'z'){
            $p_sbu = 'AND tko_kodesbu = '.$request->p_sbu;
        }
        if($request->p_khusus != 'z'){
            $p_khusus = 'AND SUBSTR(tko_kodeomi,1,1) = '.$request->p_khusus;
        }
        if($request->p_omi != 'z'){
            $p_omi = 'AND tko_kodeomi = '.$request->p_omi;
        }

        $datas = DB::select("SELECT prs_namaperusahaan, prs_namacabang, div_namadivisi, dep_namadepartement, omisbu, namasbu, omidiv, omidep,
	   SUM(CASE WHEN fdtipe='S' THEN nNet    ELSE nNet*-1    END) ominet,
	   SUM(CASE WHEN fdtipe='S' THEN nGross  ELSE nGross*-1  END) omiamt,
	   SUM(CASE WHEN fdtipe='S' THEN nTax    ELSE nTax  *-1  END) omitax,
	   SUM(CASE WHEN fdtipe='S' THEN nHpp    ELSE nHpp*-1    END) omihpp,
	   SUM(CASE WHEN fdtipe='S' THEN nMargin ELSE nMargin*-1 END) omimrg
FROM TBMASTER_PERUSAHAAN, TBMASTER_DIVISI, TBMASTER_DEPARTEMENT,
(	SELECT kodeigr, omikod, omisbu, omimem, fdkdiv omidiv, fddiv omidep, cBkp, mark_up, fdtipe, namasbu,
		  CASE WHEN Fdkdiv = '5' AND fddiv = '39' THEN
	         0
	      ELSE
	         CASE WHEN omisbu = 'O' OR omisbu = 'I' THEN
	           CASE WHEN cBkp = 'Y' THEN ((fdnamt*1.1)-Fdnamt) ELSE 0 END
	         ELSE
	           CASE WHEN cBkp = 'Y' THEN (fdnamt-(Fdnamt/1.1)) ELSE 0 END
	         END
	      END nTax,
	      CASE WHEN Fdkdiv = '5' AND fddiv = '39' THEN
	         Fdnamt
	      ELSE
	         CASE WHEN  omisbu = 'O' OR omisbu = 'I' THEN
	            Fdnamt
	         ELSE
	            Fdnamt-(CASE WHEN cBkp = 'Y' THEN (fdnamt-(Fdnamt/1.1)) ELSE 0 END)
	         END
	      END nNet,
	      CASE WHEN Fdkdiv = '5' AND fddiv = '39' THEN
	         CASE WHEN Mark_up IS NULL THEN ((5*Fdnamt)/100) ELSE ((Mark_up*Fdnamt)/100) END
	      ELSE
	         (CASE WHEN  omisbu = 'O' OR omisbu = 'I' THEN Fdnamt ELSE Fdnamt-(CASE WHEN cBkp = 'Y' THEN (fdnamt-(Fdnamt/1.1)) ELSE 0 END) END) -
			 ( Fdjqty/(CASE WHEN unit='KG'THEN 1000 ELSE 1 END)*Fdcost)
	      END nMargin,
	      CASE WHEN Fdkdiv = '5' AND fddiv = '39' THEN
	         Fdnamt - (CASE WHEN Mark_up IS NULL THEN ((5*Fdnamt)/100) ELSE ((Mark_up*Fdnamt)/100) END)
	      ELSE
	         (Fdjqty/(CASE WHEN unit='KG'THEN 1000 ELSE 1 END)*Fdcost)
	      END nHpp,
	      CASE WHEN omisbu = 'O' OR omisbu = 'I' THEN
	         CASE WHEN cBkp = 'Y' THEN
	            fdnamt*1.1
	         ELSE
	            fdnamt
	         END
	      ELSE
	         fdnamt
	      END nGross
	FROM
	(	SELECT tko_kodeigr kodeigr, tko_kodeOMI omikod, tko_kodeSBU omisbu, tko_namasbu namasbu, trjd_cus_kodemember omimem, trjd_divisioncode fdkdiv, SUBSTR(trjd_division,1,2) fddiv,
			   trjd_nominalamt fdnamt, trjd_baseprice fdcost, trjd_quantity fdjqty, prd_unit unit, prd_markUpStandard mark_up,
			   trjd_transactiontype fdtipe, trjd_flagtax1 cBkp,
			   CASE WHEN trjd_cus_kodemember NOT IN (SELECT cus_kodemember FROM TBMASTER_CUSTOMER) THEN 'T' ELSE cus_flagPKP END pjkO
		FROM TBMASTER_TOKOIGR, TBTR_JUALDETAIL, TBMASTER_CUSTOMER, TBMASTER_PRODMAST
		WHERE trjd_cus_kodemember = tko_kodecustomer
		  AND trjd_cus_kodemember = cus_kodemember
		  AND trjd_prdcd = prd_prdcd
		  ".$p_sbu." ".$p_khusus." ".$p_omi."
		  AND TRUNC(trjd_transactiondate) BETWEEN TO_DATE('$sDate','DD-MM-YYYY') AND TO_DATE('$eDate', 'DD-MM-YYYY')
		  AND tko_kodeOMI NOT IN (SELECT tko_kodeOMI FROM TBMASTER_TOKOIGR WHERE tko_tipeOMI IN ('HR','HG'))
	)
)
WHERE prs_kodeigr = '$kodeigr'
  AND kodeigr = prs_kodeigr
  AND omidiv = div_kodedivisi
  AND omidep = dep_kodedepartement
GROUP BY prs_namaperusahaan, prs_namacabang, div_namadivisi, dep_namadepartement, omisbu, namasbu, omidiv, omidep
ORDER BY omidiv, omidep");


        $namaomi = DB::table('tbmaster_tokoigr')
            ->selectRaw("tko_namaomi")
            ->where('tko_kodeomi','=',$p_omi)
            ->first();

        if(sizeof($datas) == 0){
            return "**DATA TIDAK ADA**";
        }


        $cf_nmargin = [];
        for($i=0;$i<sizeof($datas);$i++){
            if(($datas[$i]->ominet) != 0){
                $cf_nmargin[$i] = round(($datas[$i]->omimrg)*100/($datas[$i]->ominet), 2);
            }else{
                if(($datas[$i]->nmargin) != 0){
                    $cf_nmargin[$i]=100;
                }else{
                    $cf_nmargin[$i]=0;
                }
            }
        }

        //CALCULATE GRAND TOTAL

        $gross['i'] = 0; $tax['i'] = 0; $net['i'] = 0; $hpp['i'] = 0; $margin['i'] = 0;
        $gross['o'] = 0; $tax['o'] = 0; $net['o'] = 0; $hpp['o'] = 0; $margin['o'] = 0;
        $gross['total'] = 0; $tax['total'] = 0; $net['total'] = 0; $hpp['total'] = 0; $margin['total'] = 0;

        for($i=0;$i<sizeof($datas);$i++) {
            if($datas[$i]->omisbu == 'O'){
                $gross['o'] = $gross['o'] + $datas[$i]->omiamt;
                $tax['o'] = $tax['o'] + $datas[$i]->omitax;
                $net['o'] = $net['o'] + $datas[$i]->ominet;
                $hpp['o'] = $hpp['o'] + $datas[$i]->omihpp;
                $margin['o'] = $margin['o'] + $datas[$i]->omimrg;
            }else{
                $gross['i'] = $gross['i'] + $datas[$i]->omiamt;
                $tax['i'] = $tax['i'] + $datas[$i]->omitax;
                $net['i'] = $net['i'] + $datas[$i]->ominet;
                $hpp['i'] = $hpp['i'] + $datas[$i]->omihpp;
                $margin['i'] = $margin['i'] + $datas[$i]->omimrg;
            }
            $gross['total'] = $gross['total'] + $datas[$i]->omiamt;
            $tax['total'] = $tax['total'] + $datas[$i]->omitax;
            $net['total'] = $net['total'] + $datas[$i]->ominet;
            $hpp['total'] = $hpp['total'] + $datas[$i]->omihpp;
            $margin['total'] = $margin['total'] + $datas[$i]->omimrg;
        }

        //persentase margin
        if($net['i'] != 0){
            $marginpersen['i'] = round(($margin['i'])/($net['i'])*100, 2);
        }else{
            $marginpersen['i']=0;
        }
        if($net['o'] != 0){
            $marginpersen['o'] = round(($margin['o'])/($net['o'])*100, 2);
        }else{
            $marginpersen['o']=0;
        }
        if($net['total'] != 0){
            $marginpersen['total'] = round(($margin['total'])*100/($net['total']), 2);
        }else{
            if(($margin['total']) != 0){
                $marginpersen['total']=100;
            }else{
                $marginpersen['total']=0;
            }
        }

//        //PRINT
        $today = date('d-m-Y');
        $time = date('H:i:s');
        $pdf = PDF::loadview('FRONTOFFICE\LAPORANKASIR\LAPORANPENJUALAN\lap_jual_perdept_c-pdf',
            ['kodeigr' => $kodeigr, 'date1' => $dateA, 'date2' => $dateB, 'datas' => $datas, 'today' => $today, 'time' => $time, 'namaomi' => $namaomi,
                'keterangan' => $lst_print, 'cf_nmargin' => $cf_nmargin, 'periode' => $periode,
                'gross' => $gross, 'tax' => $tax, 'net' => $net, 'hpp' => $hpp,'margin' => $margin, 'marginpersen' => $marginpersen]);
        $pdf->setPaper('A4', 'potrait');
        $pdf->output();
        $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);

        $canvas = $dompdf ->get_canvas();
        $canvas->page_text(534, 24, "HAL : {PAGE_NUM} / {PAGE_COUNT}", null, 8, array(0, 0, 0));

        return $pdf->stream('FRONTOFFICE\LAPORANKASIR\LAPORANPENJUALAN\lap_jual_perdept_c-pdf');

//        return view('FRONTOFFICE\LAPORANKASIR\LAPORANPENJUALAN\lap_jual_perdept_d-pdf',['kodeigr' => $kodeigr, 'date1' => $dateA, 'date2' => $dateB, 'datas' => $datas, 'today' => $today, 'time' => $time,
//            'keterangan' => $lst_print, 'cf_nmargin' => $cf_nmargin, 'periode' => $periode,
//            'gross' => $gross, 'tax' => $tax, 'net' => $net, 'hpp' => $hpp,'margin' => $margin, 'marginpersen' => $marginpersen]);
    }

    public function printDocumentMenu3(Request $request){
        $kodeigr = $_SESSION['kdigr'];
        $dateA = $request->date1;
        $dateB = $request->date2;
        $sDate = DateTime::createFromFormat('d-m-Y', $dateA)->format('d-m-Y');
        $eDate = DateTime::createFromFormat('d-m-Y', $dateB)->format('d-m-Y');
        $div = $request->div;
        $p_div =  '';
        if($div != 'SEMUA DIVISI'){
            $p_div = 'and fdkdiv = '.$div;
        }
        $dept = $request->dept;
        $p_dept =  '';
        if($dept != 'SEMUA DEPARTEMENT'){
            $p_dept = 'and fdkdep = '.$dept;
        }

        $kat = $request->kat;
        $p_kat =  '';
        if($kat != 'SEMUA KATEGORY'){
            $p_kat = 'and fdkatb = '.$kat;
        }

        $margin1 = (float)$request->margin1;
        $margin2 = (float)$request->margin2;
        $mon = $request->mon;
        $pluall = $request->pluall;

        if($pluall == 'Y'){
            $datas = DB::select("SELECT prs_namaperusahaan, prs_namacabang, prs_namawilayah,
	   fdkdiv, div_namadivisi, fdkdep, dep_namadepartement, fdkatb, kat_namakategori, fdkplu, prd_deskripsipanjang, fdksat||'/'||fdisis unit, fdfbkp,
	   fdsat0, fdnam0, fdntr0,
	   fdsat1, fdnam1, fdntr1,
	   fdsat2, fdnam2, fdntr2,
	   fdsat3, fdnam3, fdntr3,
	   fdjqty, fdfqty, fdntrn, fdnamt, fdntax, fdnnet, fdnhpp,
	   fdmrgn, fdfnam, fdftax, fdfnet, fdfhpp, fdfmgn, cexp,
	   CASE WHEN fdksat = 'KG' THEN fdfqty/1000 ELSE fdfqty END + CASE WHEN fdksat = 'KG' THEN fdjqty/1000 ELSE fdjqty  END tot1,
	   (fdnamt + fdfnam) tot2,
       (fdntax + fdftax) tot3,
       (fdnnet + fdfnet) tot4,
	   (fdnhpp + fdfhpp) tot5,
	   (fdmrgn + fdfmgn) tot6,
	   CASE WHEN (fdnnet+fdfnet) <> 0 THEN  (((fdmrgn+fdfmgn)*100)/(fdnnet+fdfnet)) ELSE
	      CASE WHEN (fdmrgn+fdfmgn) <> 0 THEN 100 ELSE 0 END END nMarginp,
	   PRD_KODETAG
FROM TBMASTER_PERUSAHAAN, TBMASTER_PRODMAST, TBMASTER_DIVISI, TBMASTER_DEPARTEMENT, TBMASTER_KATEGORI,
(	SELECT sls_kodeigr, sls_kodedivisi fdkdiv, sls_kodedepartement fdkdep, sls_kodekategoribrg fdkatb, sls_prdcd fdkplu, sls_kodesatuan fdksat, sls_isisatuan fdisis, sls_flagbkp fdfbkp,
		   SUM(sls_QtySat0) fdsat0, SUM(sls_NilaiSat0) fdnam0, SUM(sls_JmlSat0) fdntr0,
		   SUM(sls_QtySat1) fdsat1, SUM(sls_NilaiSat1) fdnam1, SUM(sls_JmlSat1) fdntr1,
		   SUM(sls_QtySat2) fdsat2, SUM(sls_NilaiSat2) fdnam2, SUM(sls_JmlSat2) fdntr2,
		   SUM(sls_QtySat3) fdsat3, SUM(sls_NilaiSat3) fdnam3, SUM(sls_jmlSat3) fdntr3,
		   SUM(sls_QtyNOMI) fdjqty, SUM(sls_QtyOMI+sls_QtyIDM) fdfqty, SUM(sls_NoTransaksi) fdntrn, SUM(sls_NilaiNOMI) fdnamt, SUM(sls_TaxNOMI) fdntax, SUM(sls_NetNOMI) fdnnet, SUM(sls_HppNOMI) fdnhpp,
		   SUM(sls_MarginNOMI) fdmrgn, SUM(sls_NilaiOMI+sls_NilaiIDM) fdfnam, SUM(sls_TaxOMI+sls_TaxIDM) fdftax, SUM(sls_NetOMI+sls_NetIDM) fdfnet, SUM(sls_HppOMI+sls_HppIDM) fdfhpp, SUM(sls_MarginOMI+sls_MarginIDM) fdfmgn,
		   NVL(cexp,'F') cexp
	FROM TBTR_SUMSALES,
	  (	SELECT sls_prdcd prdcd, 'T' cexp
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
	GROUP BY sls_kodeigr, sls_kodedivisi, sls_kodedepartement, sls_kodekategoribrg, sls_prdcd, sls_kodesatuan, sls_isisatuan, sls_flagbkp, NVL(cexp,'F')
)
WHERE prs_kodeigr = '$kodeigr'
  AND sls_kodeigr = prs_kodeigr
  AND fdkplu = prd_prdcd
  AND fdkdiv = div_kodedivisi (+)
  AND fdkdep = dep_kodedepartement (+)
  AND fdkdiv = dep_kodedivisi (+)
  AND fdkdep = kat_kodedepartement (+)
  AND fdkatb = kat_kodekategori (+)
  --AND fdkdiv in ('$div')
  ".$p_div." ".$p_dept." ".$p_kat."
  AND CASE WHEN (fdnnet+fdfnet) <> 0 THEN  (((fdmrgn+fdfmgn)*100)/(fdnnet+fdfnet)) ELSE
	      CASE WHEN (fdmrgn+fdfmgn) <> 0 THEN 100 ELSE 0 END END between ".$margin1." AND ".$margin2."
ORDER BY fdkdiv, fdkdep, fdkatb");
        }

        if(sizeof($datas) == 0){
            return "**DATA TIDAK ADA**";
        }

        //CALCULATE GRAND TOTAL
        //$arrayIndex = ['p','i','b','g','r','e','x','c','f','h','total-40','total'];
        $arrayIndex = ['c','p','x','i','b','e','g','r','h','total-40','total','f']; //tersusun, f merupakan departemen 40, hanya dipakai untuk mendapatkan total-40, tidak untuk ditampilkan

        foreach ($arrayIndex as $index){
            $gross[$index] = 0; $tax[$index] = 0; $net[$index] = 0; $hpp[$index] = 0; $margin[$index] = 0; $margp[$index] = 0;
        }

        $rec = DB::select("SELECT prs_namaperusahaan, prs_namacabang, prs_namawilayah,
	   fdkdiv, div_namadivisi, fdkdep, dep_namadepartement, fdkatb, kat_namakategori, fdkplu, prd_deskripsipanjang, fdksat||'/'||fdisis unit, fdfbkp,
	   fdsat0, fdnam0, fdntr0,
	   fdsat1, fdnam1, fdntr1,
	   fdsat2, fdnam2, fdntr2,
	   fdsat3, fdnam3, fdntr3,
	   fdjqty, fdfqty, fdntrn, fdnamt, fdntax, fdnnet, fdnhpp,
	   fdmrgn, fdfnam, fdftax, fdfnet, fdfhpp, fdfmgn, cexp,
	   CASE WHEN fdksat = 'KG' THEN fdfqty/1000 ELSE fdfqty END + CASE WHEN fdksat = 'KG' THEN fdjqty/1000 ELSE fdjqty  END tot1,
	   (fdnamt + fdfnam) tot2,
     (fdntax + fdftax) tot3,
     (fdnnet + fdfnet) tot4,
	   (fdnhpp + fdfhpp) tot5,
	   (fdmrgn + fdfmgn) tot6,
	   CASE WHEN (fdnnet+fdfnet) <> 0 THEN  (((fdmrgn+fdfmgn)*100)/(fdnnet+fdfnet)) ELSE
	      CASE WHEN (fdmrgn+fdfmgn) <> 0 THEN 100 ELSE 0 END END nMarginp,
	   PRD_KODETAG
FROM TBMASTER_PERUSAHAAN, TBMASTER_PRODMAST, TBMASTER_DIVISI, TBMASTER_DEPARTEMENT, TBMASTER_KATEGORI,
(	SELECT sls_kodeigr, sls_kodedivisi fdkdiv, sls_kodedepartement fdkdep, sls_kodekategoribrg fdkatb, sls_prdcd fdkplu, sls_kodesatuan fdksat, sls_isisatuan fdisis, sls_flagbkp fdfbkp,
		   SUM(sls_QtySat0) fdsat0, SUM(sls_NilaiSat0) fdnam0, SUM(sls_JmlSat0) fdntr0,
		   SUM(sls_QtySat1) fdsat1, SUM(sls_NilaiSat1) fdnam1, SUM(sls_JmlSat1) fdntr1,
		   SUM(sls_QtySat2) fdsat2, SUM(sls_NilaiSat2) fdnam2, SUM(sls_JmlSat2) fdntr2,
		   SUM(sls_QtySat3) fdsat3, SUM(sls_NilaiSat3) fdnam3, SUM(sls_jmlSat3) fdntr3,
		   SUM(sls_QtyNOMI) fdjqty, SUM(sls_QtyOMI) fdfqty, SUM(sls_NoTransaksi) fdntrn, SUM(sls_NilaiNOMI) fdnamt, SUM(sls_TaxNOMI) fdntax, SUM(sls_NetNOMI) fdnnet, SUM(sls_HppNOMI) fdnhpp,
		   SUM(sls_MarginNOMI) fdmrgn, SUM(sls_NilaiOMI) fdfnam, SUM(sls_TaxOMI) fdftax, SUM(sls_NetOMI) fdfnet, SUM(sls_HppOMI) fdfhpp, SUM(sls_MarginOMI) fdfmgn,
		   NVL(cexp,'F') cexp
	FROM TBTR_SUMSALES,
	  (	SELECT sls_prdcd prdcd, 'T' cexp
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
	GROUP BY sls_kodeigr, sls_kodedivisi, sls_kodedepartement, sls_kodekategoribrg, sls_prdcd, sls_kodesatuan, sls_isisatuan, sls_flagbkp, NVL(cexp,'F')
)
WHERE prs_kodeigr = '$kodeigr'
  AND sls_kodeigr = prs_kodeigr
  AND fdkplu = prd_prdcd
  AND fdkdiv = div_kodedivisi (+)
  AND fdkdep = dep_kodedepartement (+)
  AND fdkdiv = dep_kodedivisi (+)
  AND fdkdep = kat_kodedepartement (+)
  AND fdkatb = kat_kodekategori (+)
  AND CASE WHEN (fdnnet+fdfnet) <> 0 THEN  (((fdmrgn+fdfmgn)*100)/(fdnnet+fdfnet)) ELSE
	    CASE WHEN (fdmrgn+fdfmgn) <> 0 THEN 100 ELSE 0 END END between ".$margin1." AND ".$margin2."
ORDER BY fdkdiv, fdkdep, fdkatb");

        for($i=0;$i<sizeof($rec);$i++){
            if($rec[$i]->fdkdiv == $div || $div == 'SEMUA DIVISI'){
                if($rec[$i]->fdkdep == $dept || $dept == 'SEMUA DEPARTEMENT'){
                    if($rec[$i]->fdkatb == $kat || $kat == 'SEMUA KATEGORY'){
                        if($rec[$i]->fdkdiv != '5' && (($rec[$i]->fdkdep != '39') && ($rec[$i]->fdkdep != '40') && ($rec[$i]->fdkdep != '43'))){
                            if($rec[$i]->fdntax != 0 || $rec[$i]->fdftax != 0){
                                $gross['p'] = $gross['p'] + ($rec[$i]->fdnamt + $rec[$i]->fdfnam);
                                $tax['p'] = $tax['p'] + ($rec[$i]->fdntax + $rec[$i]->fdftax);
                                $net['p'] = $net['p'] + ($rec[$i]->fdnnet + $rec[$i]->fdfnet);
                                $hpp['p'] = $hpp['p'] + ($rec[$i]->fdnhpp + $rec[$i]->fdfhpp);
                                $margin['p'] = $margin['p'] + ($rec[$i]->fdmrgn + $rec[$i]->fdfmgn);
                            }else{
                                if($rec[$i]->fdfbkp == 'C'){
                                    $gross['i'] = $gross['i'] + ($rec[$i]->fdnamt + $rec[$i]->fdfnam);
                                    $tax['i'] = $tax['i'] + ($rec[$i]->fdntax + $rec[$i]->fdftax);
                                    $net['i'] = $net['i'] + ($rec[$i]->fdnnet + $rec[$i]->fdfnet);
                                    $hpp['i'] = $hpp['i'] + ($rec[$i]->fdnhpp + $rec[$i]->fdfhpp);
                                    $margin['i'] = $margin['i'] + ($rec[$i]->fdmrgn + $rec[$i]->fdfmgn);
                                }elseif($rec[$i]->fdfbkp == 'P'){
                                    $gross['b'] = $gross['b'] + ($rec[$i]->fdnamt + $rec[$i]->fdfnam);
                                    $tax['b'] = $tax['b'] + ($rec[$i]->fdntax + $rec[$i]->fdftax);
                                    $net['b'] = $net['b'] + ($rec[$i]->fdnnet + $rec[$i]->fdfnet);
                                    $hpp['b'] = $hpp['b'] + ($rec[$i]->fdnhpp + $rec[$i]->fdfhpp);
                                    $margin['b'] = $margin['b'] + ($rec[$i]->fdmrgn + $rec[$i]->fdfmgn);
                                }elseif($rec[$i]->fdfbkp == 'G'){
                                    $gross['g'] = $gross['g'] + ($rec[$i]->fdnamt + $rec[$i]->fdfnam);
                                    $tax['g'] = $tax['g'] + ($rec[$i]->fdntax + $rec[$i]->fdftax);
                                    $net['g'] = $net['g'] + ($rec[$i]->fdnnet + $rec[$i]->fdfnet);
                                    $hpp['g'] = $hpp['g'] + ($rec[$i]->fdnhpp + $rec[$i]->fdfhpp);
                                    $margin['g'] = $margin['g'] + ($rec[$i]->fdmrgn + $rec[$i]->fdfmgn);
                                }elseif($rec[$i]->fdfbkp == 'W'){
                                    $gross['r'] = $gross['r'] + ($rec[$i]->fdnamt + $rec[$i]->fdfnam);
                                    $tax['r'] = $tax['r'] + ($rec[$i]->fdntax + $rec[$i]->fdftax);
                                    $net['r'] = $net['r'] + ($rec[$i]->fdnnet + $rec[$i]->fdfnet);
                                    $hpp['r'] = $hpp['r'] + ($rec[$i]->fdnhpp + $rec[$i]->fdfhpp);
                                    $margin['r'] = $margin['r'] + ($rec[$i]->fdmrgn + $rec[$i]->fdfmgn);
                                }else{
                                    if($rec[$i]->cexp == 'Y'){
                                        $gross['e'] = $gross['e'] + ($rec[$i]->fdnamt + $rec[$i]->fdfnam);
                                        $tax['e'] = $tax['e'] + ($rec[$i]->fdntax + $rec[$i]->fdftax);
                                        $net['e'] = $net['e'] + ($rec[$i]->fdnnet + $rec[$i]->fdfnet);
                                        $hpp['e'] = $hpp['e'] + ($rec[$i]->fdnhpp + $rec[$i]->fdfhpp);
                                        $margin['e'] = $margin['e'] + ($rec[$i]->fdmrgn + $rec[$i]->fdfmgn);
                                    }else{
                                        $gross['x'] = $gross['x'] + ($rec[$i]->fdnamt + $rec[$i]->fdfnam);
                                        $tax['x'] = $tax['x'] + ($rec[$i]->fdntax + $rec[$i]->fdftax);
                                        $net['x'] = $net['x'] + ($rec[$i]->fdnnet + $rec[$i]->fdfnet);
                                        $hpp['x'] = $hpp['x'] + ($rec[$i]->fdnhpp + $rec[$i]->fdfhpp);
                                        $margin['x'] = $margin['x'] + ($rec[$i]->fdmrgn + $rec[$i]->fdfmgn);
                                    }
                                }
                            }
                        }elseif ($rec[$i]->fdkdiv == '5' && $rec[$i]->fdkdep == '39'){
                            $gross['c'] = $gross['c'] + ($rec[$i]->fdnamt + $rec[$i]->fdfnam);
                            $tax['c'] = $tax['c'] + ($rec[$i]->fdntax + $rec[$i]->fdftax);
                            $net['c'] = $net['c'] + ($rec[$i]->fdnnet + $rec[$i]->fdfnet);
                            $hpp['c'] = $hpp['c'] + ($rec[$i]->fdnhpp + $rec[$i]->fdfhpp);
                            $margin['c'] = $margin['c'] + ($rec[$i]->fdmrgn + $rec[$i]->fdfmgn);
                        }elseif ($rec[$i]->fdkdiv == '5' && $rec[$i]->fdkdep == '40'){
                            $gross['f'] = $gross['f'] + ($rec[$i]->fdnamt + $rec[$i]->fdfnam);
                            $tax['f'] = $tax['f'] + ($rec[$i]->fdntax + $rec[$i]->fdftax);
                            $net['f'] = $net['f'] + ($rec[$i]->fdnnet + $rec[$i]->fdfnet);
                            $hpp['f'] = $hpp['f'] + ($rec[$i]->fdnhpp + $rec[$i]->fdfhpp);
                            $margin['f'] = $margin['f'] + ($rec[$i]->fdmrgn + $rec[$i]->fdfmgn);
                        }elseif ($rec[$i]->fdkdiv == '5' && $rec[$i]->fdkdep == '43'){
                            $gross['h'] = $gross['h'] + ($rec[$i]->fdnamt + $rec[$i]->fdfnam);
                            $tax['h'] = $tax['h'] + ($rec[$i]->fdntax + $rec[$i]->fdftax);
                            $net['h'] = $net['h'] + ($rec[$i]->fdnnet + $rec[$i]->fdfnet);
                            $hpp['h'] = $hpp['h'] + ($rec[$i]->fdnhpp + $rec[$i]->fdfhpp);
                            $margin['h'] = $margin['h'] + ($rec[$i]->fdmrgn + $rec[$i]->fdfmgn);
                        }
                    }
                }
            }
        }
        for($i=0;$i<sizeof($datas);$i++){
            $gross['total'] = $gross['total'] + $datas[$i]->tot2;
            $tax['total'] = $tax['total'] + $datas[$i]->tot3;
            $net['total'] = $net['total'] + $datas[$i]->tot4;
            $hpp['total'] = $hpp['total'] + $datas[$i]->tot5;
            $margin['total'] = $margin['total'] + $datas[$i]->tot6;
        }
        $gross['total-40'] = $gross['total'] - $gross['f'];
        $tax['total-40'] = $tax['total'] - $tax['f'];
        $net['total-40'] = $net['total'] - $net['f'];
        $hpp['total-40'] = $hpp['total'] - $hpp['f'];
        $margin['total-40'] = $margin['total'] - $margin['f'];

        foreach ($arrayIndex as $index){
            if($net[$index] != 0){
                $margp[$index] = $margin[$index]*100/$net[$index];
            }else{
                if($margin[$index] != 0){
                    $margp[$index] = 100;
                }else{
                    $margp[$index] = 0;
                }
            }
        }

        //PRINT
        $today = date('d-m-Y');
        $time = date('H:i:s');
        if($pluall == 'Y'){
            return view('FRONTOFFICE\LAPORANKASIR\LAPORANPENJUALAN\lap_jual_perdiv_all-pdf',
                ['kodeigr' => $kodeigr, 'date1' => $dateA, 'date2' => $dateB, 'margin1' => $margin1,'margin2' => $margin2, 'datas' => $datas, 'today' => $today, 'time' => $time,
                'arrayIndex' => $arrayIndex, 'gross' => $gross, 'tax' => $tax, 'net' => $net, 'hpp' => $hpp,'margin' => $margin, 'margp' => $margp]);
        }
    }
}
