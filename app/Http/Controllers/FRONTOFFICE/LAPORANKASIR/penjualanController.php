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
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use PDF;
use DateTime;
use Yajra\DataTables\DataTables;

class penjualanController extends Controller
{

    public function index()
    {
        return view('FRONTOFFICE.LAPORANKASIR.penjualan');
    }

    public function getNmr(Request $request)
    {
        $search = $request->val;
        $kodeigr = Session::get('kdigr');

        $datas = DB::connection(Session::get('connection'))->table('tbmaster_supplier')
            ->selectRaw('distinct sup_kodesupplier as sup_kodesupplier')
            ->selectRaw('sup_namasupplier')
            ->where('sup_kodesupplier', 'LIKE', '%' . $search . '%')
            ->where('sup_kodeigr', '=', $kodeigr)
            ->orderBy('sup_namasupplier')
            ->limit(100)
            ->get();

        return response()->json($datas);
    }

    public function getDiv()
    {
        $datas = DB::connection(Session::get('connection'))->table('tbmaster_divisi')
            ->selectRaw("div_kodedivisi, div_namadivisi")
            ->orderBy('div_kodedivisi')
            ->get();

        return Datatables::of($datas)->make(true);
    }

    public function getDept(Request $request)
    {
        //$search1 = $request->data1;
        //$search2 = $request->data2;

        $datas = DB::connection(Session::get('connection'))->table('tbmaster_departement')
            ->selectRaw("dep_kodedepartement, dep_namadepartement, dep_kodedivisi")
            //->whereRaw("dep_kodedivisi between ".$search1." and ".$search2)
            ->orderBy('dep_kodedepartement')
            ->get();

        return Datatables::of($datas)->make(true);
    }

    public function getToko(Request $request)
    {
        //$search = $request->data;

        $datas = DB::connection(Session::get('connection'))->table('TBMASTER_TOKOIGR')
            ->selectRaw("tko_kodeomi, tko_namaomi, tko_namasbu, tko_kodecustomer, tko_kodesbu")
            //->whereRaw("tko_kodesbu like ".$search)
            ->orderBy('tko_kodeomi')
            ->get();

        return Datatables::of($datas)->make(true);
    }

    public function getkat(Request $request)
    {
        //$search1 = $request->data1;
        //$search2 = $request->data2;

        $datas = DB::connection(Session::get('connection'))->table('tbmaster_kategori')
            ->selectRaw("kat_kodekategori, kat_namakategori, kat_kodedepartement")
            //->whereRaw("kat_kodedepartement between ".$search1." and ".$search2)
            ->orderBy('kat_kodekategori')
            ->get();

        return Datatables::of($datas)->make(true);
    }

    public function getMon(Request $request)
    {
        $dateA = $request->date1;
        $dateB = $request->date2;
        $sDate = DateTime::createFromFormat('d-m-Y', $dateA)->format('d-m-Y');
        $eDate = DateTime::createFromFormat('d-m-Y', $dateB)->format('d-m-Y');

        $datas = DB::connection(Session::get('connection'))->select("SELECT DISTINCT mpl_kodemonitoring, mpl_namamonitoring
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

    public function printDocumentMenu1(Request $request)
    {
        $kodeigr = Session::get('kdigr');
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
        if ($elek == 'Y') {
            $dept3 = $request->dept3;
            $dept4 = $request->dept4;
            $div3 = $request->div3;
        }

        if ($dateA != $dateB) {
            $periode = 'PERIODE: ' . $dateA . ' s/d ' . $dateB;
        } else {
            $periode = 'TANGGAL: ' . $dateA;
        }
        if ($elek == 'Y') {
            $datas = DB::connection(Session::get('connection'))->select("SELECT prs_namaperusahaan, prs_namacabang,
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
        } else {
            $datas = DB::connection(Session::get('connection'))->select("SELECT prs_namaperusahaan, prs_namacabang,
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
        for ($i = 0; $i < sizeof($datas); $i++) {
            if (($datas[$i]->nnet) != 0) {
                $cf_nmargin[$i] = round(($datas[$i]->nmargin) * 100 / ($datas[$i]->nnet), 2);
            } else {
                if (($datas[$i]->nmargin) != 0) {
                    $cf_nmargin[$i] = 100;
                } else {
                    $cf_nmargin[$i] = 0;
                }
            }
            $cs_tlQty = $cs_tlQty + $datas[$i]->ktqty;
        }

        //CALCULATE GRAND TOTAL
        if ($elek == 'Y') {
            $rec = DB::connection(Session::get('connection'))->select("SELECT prs_namaperusahaan, prs_namacabang,
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
        } else {
            $rec = DB::connection(Session::get('connection'))->select("SELECT prs_namaperusahaan, prs_namacabang,
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

        $gross['c'] = 0;
        $tax['c'] = 0;
        $net['c'] = 0;
        $hpp['c'] = 0;
        $margin['c'] = 0;
        $gross['f'] = 0;
        $tax['f'] = 0;
        $net['f'] = 0;
        $hpp['f'] = 0;
        $margin['f'] = 0;
        $gross['p'] = 0;
        $tax['p'] = 0;
        $net['p'] = 0;
        $hpp['p'] = 0;
        $margin['p'] = 0;
        $gross['x'] = 0;
        $tax['x'] = 0;
        $net['x'] = 0;
        $hpp['x'] = 0;
        $margin['x'] = 0;
        $gross['k'] = 0;
        $tax['k'] = 0;
        $net['k'] = 0;
        $hpp['k'] = 0;
        $margin['k'] = 0;
        $gross['b'] = 0;
        $tax['b'] = 0;
        $net['b'] = 0;
        $hpp['b'] = 0;
        $margin['b'] = 0;
        $gross['e'] = 0;
        $tax['e'] = 0;
        $net['e'] = 0;
        $hpp['e'] = 0;
        $margin['e'] = 0;
        $gross['g'] = 0;
        $tax['g'] = 0;
        $net['g'] = 0;
        $hpp['g'] = 0;
        $margin['g'] = 0;
        $gross['r'] = 0;
        $tax['r'] = 0;
        $net['r'] = 0;
        $hpp['r'] = 0;
        $margin['r'] = 0;
        $gross['d'] = 0;
        $tax['d'] = 0;
        $net['d'] = 0;
        $hpp['d'] = 0;
        $margin['d'] = 0;

        for ($i = 0; $i < sizeof($rec); $i++) {
            if (($rec[$i]->fdkdiv) != '5' && (($rec[$i]->fdkdep != '39') && ($rec[$i]->fdkdep != '40') && ($rec[$i]->fdkdep != '43'))) {
                if ($rec[$i]->fdntax != 0 || $rec[$i]->fdftax != 0) {
                    $gross['p'] = $gross['p'] + ($rec[$i]->fdnamt + $rec[$i]->fdfnam);
                    $tax['p'] = $tax['p'] + ($rec[$i]->fdntax + $rec[$i]->fdftax);
                    $net['p'] = $net['p'] + ($rec[$i]->fdnnet + $rec[$i]->fdfnet);
                    $hpp['p'] = $hpp['p'] + ($rec[$i]->fdnhpp + $rec[$i]->fdfhpp);
                    $margin['p'] = $margin['p'] + ($rec[$i]->fdmrgn + $rec[$i]->fdfmgn);
                } else {
                    if ($rec[$i]->fdfbkp == 'C') {
                        $gross['k'] = $gross['k'] + ($rec[$i]->fdnamt + $rec[$i]->fdfnam);
                        $tax['k'] = $tax['k'] + ($rec[$i]->fdntax + $rec[$i]->fdftax);
                        $net['k'] = $net['k'] + ($rec[$i]->fdnnet + $rec[$i]->fdfnet);
                        $hpp['k'] = $hpp['k'] + ($rec[$i]->fdnhpp + $rec[$i]->fdfhpp);
                        $margin['k'] = $margin['k'] + ($rec[$i]->fdmrgn + $rec[$i]->fdfmgn);
                    } elseif ($rec[$i]->fdfbkp == 'P') {
                        $gross['b'] = $gross['b'] + ($rec[$i]->fdnamt + $rec[$i]->fdfnam);
                        $tax['b'] = $tax['b'] + ($rec[$i]->fdntax + $rec[$i]->fdftax);
                        $net['b'] = $net['b'] + ($rec[$i]->fdnnet + $rec[$i]->fdfnet);
                        $hpp['b'] = $hpp['b'] + ($rec[$i]->fdnhpp + $rec[$i]->fdfhpp);
                        $margin['b'] = $margin['b'] + ($rec[$i]->fdmrgn + $rec[$i]->fdfmgn);
                    } elseif ($rec[$i]->fdfbkp == 'G') {
                        $gross['g'] = $gross['g'] + ($rec[$i]->fdnamt + $rec[$i]->fdfnam);
                        $tax['g'] = $tax['g'] + ($rec[$i]->fdntax + $rec[$i]->fdftax);
                        $net['g'] = $net['g'] + ($rec[$i]->fdnnet + $rec[$i]->fdfnet);
                        $hpp['g'] = $hpp['g'] + ($rec[$i]->fdnhpp + $rec[$i]->fdfhpp);
                        $margin['g'] = $margin['g'] + ($rec[$i]->fdmrgn + $rec[$i]->fdfmgn);
                    } elseif ($rec[$i]->fdfbkp == 'W') {
                        $gross['r'] = $gross['r'] + ($rec[$i]->fdnamt + $rec[$i]->fdfnam);
                        $tax['r'] = $tax['r'] + ($rec[$i]->fdntax + $rec[$i]->fdftax);
                        $net['r'] = $net['r'] + ($rec[$i]->fdnnet + $rec[$i]->fdfnet);
                        $hpp['r'] = $hpp['r'] + ($rec[$i]->fdnhpp + $rec[$i]->fdfhpp);
                        $margin['r'] = $margin['r'] + ($rec[$i]->fdmrgn + $rec[$i]->fdfmgn);
                    } else {
                        if ($rec[$i]->cexp == 'Y') {
                            $gross['e'] = $gross['e'] + ($rec[$i]->fdnamt + $rec[$i]->fdfnam);
                            $tax['e'] = $tax['e'] + ($rec[$i]->fdntax + $rec[$i]->fdftax);
                            $net['e'] = $net['e'] + ($rec[$i]->fdnnet + $rec[$i]->fdfnet);
                            $hpp['e'] = $hpp['e'] + ($rec[$i]->fdnhpp + $rec[$i]->fdfhpp);
                            $margin['e'] = $margin['e'] + ($rec[$i]->fdmrgn + $rec[$i]->fdfmgn);
                        } else {
                            $gross['x'] = $gross['x'] + ($rec[$i]->fdnamt + $rec[$i]->fdfnam);
                            $tax['x'] = $tax['x'] + ($rec[$i]->fdntax + $rec[$i]->fdftax);
                            $net['x'] = $net['x'] + ($rec[$i]->fdnnet + $rec[$i]->fdfnet);
                            $hpp['x'] = $hpp['x'] + ($rec[$i]->fdnhpp + $rec[$i]->fdfhpp);
                            $margin['x'] = $margin['x'] + ($rec[$i]->fdmrgn + $rec[$i]->fdfmgn);
                        }
                    }
                }
            } elseif ($rec[$i]->fdkdiv == '5' && $rec[$i]->fdkdep == '39') {
                $gross['c'] = $gross['c'] + ($rec[$i]->fdnamt + $rec[$i]->fdfnam);
                $tax['c'] = $tax['c'] + ($rec[$i]->fdntax + $rec[$i]->fdftax);
                $net['c'] = $net['c'] + ($rec[$i]->fdnnet + $rec[$i]->fdfnet);
                $hpp['c'] = $hpp['c'] + ($rec[$i]->fdnhpp + $rec[$i]->fdfhpp);
                $margin['c'] = $margin['c'] + ($rec[$i]->fdmrgn + $rec[$i]->fdfmgn);
            } elseif ($rec[$i]->fdkdiv == '5' && $rec[$i]->fdkdep == '40') {
                $gross['d'] = $gross['d'] + ($rec[$i]->fdnamt + $rec[$i]->fdfnam);
                $tax['d'] = $tax['d'] + ($rec[$i]->fdntax + $rec[$i]->fdftax);
                $net['d'] = $net['d'] + ($rec[$i]->fdnnet + $rec[$i]->fdfnet);
                $hpp['d'] = $hpp['d'] + ($rec[$i]->fdnhpp + $rec[$i]->fdfhpp);
                $margin['d'] = $margin['d'] + ($rec[$i]->fdmrgn + $rec[$i]->fdfmgn);
            } elseif ($rec[$i]->fdkdiv == '5' && $rec[$i]->fdkdep == '43') {
                $gross['f'] = $gross['f'] + ($rec[$i]->fdnamt + $rec[$i]->fdfnam);
                $tax['f'] = $tax['f'] + ($rec[$i]->fdntax + $rec[$i]->fdftax);
                $net['f'] = $net['f'] + ($rec[$i]->fdnnet + $rec[$i]->fdfnet);
                $hpp['f'] = $hpp['f'] + ($rec[$i]->fdnhpp + $rec[$i]->fdfhpp);
                $margin['f'] = $margin['f'] + ($rec[$i]->fdmrgn + $rec[$i]->fdfmgn);
            }
        }

        //persentase margin
        if ($net['c'] != 0) {
            $marginpersen['c'] = round(($margin['c']) * 100 / ($net['c']), 2);
        } else {
            if (($margin['c']) != 0) {
                $marginpersen['c'] = 100;
            } else {
                $marginpersen['c'] = 0;
            }
        }
        if ($net['f'] != 0) {
            $marginpersen['f'] = round(($margin['f']) * 100 / ($net['f']), 2);
        } else {
            if (($margin['f']) != 0) {
                $marginpersen['f'] = 100;
            } else {
                $marginpersen['f'] = 0;
            }
        }
        if ($net['p'] != 0) {
            $marginpersen['p'] = round(($margin['p']) * 100 / ($net['p']), 2);
        } else {
            if (($margin['p']) != 0) {
                $marginpersen['p'] = 100;
            } else {
                $marginpersen['p'] = 0;
            }
        }
        if ($net['x'] != 0) {
            $marginpersen['x'] = round(($margin['x']) * 100 / ($net['x']), 2);
        } else {
            if (($margin['x']) != 0) {
                $marginpersen['x'] = 100;
            } else {
                $marginpersen['x'] = 0;
            }
        }
        if ($net['k'] != 0) {
            $marginpersen['k'] = round(($margin['k']) * 100 / ($net['k']), 2);
        } else {
            if (($margin['k']) != 0) {
                $marginpersen['k'] = 100;
            } else {
                $marginpersen['k'] = 0;
            }
        }
        if ($net['b'] != 0) {
            $marginpersen['b'] = round(($margin['b']) * 100 / ($net['b']), 2);
        } else {
            if (($margin['b']) != 0) {
                $marginpersen['b'] = 100;
            } else {
                $marginpersen['b'] = 0;
            }
        }
        if ($net['e'] != 0) {
            $marginpersen['e'] = round(($margin['e']) * 100 / ($net['e']), 2);
        } else {
            if (($margin['e']) != 0) {
                $marginpersen['e'] = 100;
            } else {
                $marginpersen['e'] = 0;
            }
        }
        if ($net['g'] != 0) {
            $marginpersen['g'] = round(($margin['g']) * 100 / ($net['g']), 2);
        } else {
            if (($margin['g']) != 0) {
                $marginpersen['g'] = 100;
            } else {
                $marginpersen['g'] = 0;
            }
        }
        if ($net['r'] != 0) {
            $marginpersen['r'] = round(($margin['r']) * 100 / ($net['r']), 2);
        } else {
            if (($margin['r']) != 0) {
                $marginpersen['r'] = 100;
            } else {
                $marginpersen['r'] = 0;
            }
        }
        if ($net['d'] != 0) {
            $marginpersen['d'] = round(($margin['d']) * 100 / ($net['d']), 2);
        } else {
            if (($margin['d']) != 0) {
                $marginpersen['d'] = 100;
            } else {
                $marginpersen['d'] = 0;
            }
        }

        //ULTIMATE GRAND TOTAL
        $gross['total'] = 0;
        $tax['total'] = 0;
        $net['total'] = 0;
        $hpp['total'] = 0;
        $margin['total'] = 0;
        $qtyGrandTotal = 0;
        for ($i = 0; $i < sizeof($datas); $i++) {
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

        if ($net['total'] != 0) {
            $marginpersen['total'] = round(($margin['total']) * 100 / ($net['total']), 2);
        } else {
            if (($margin['total']) != 0) {
                $marginpersen['total'] = 100;
            } else {
                $marginpersen['total'] = 0;
            }
        }

        //PRINT
        $perusahaan = DB::connection(Session::get('connection'))->table("tbmaster_perusahaan")->first();
        $today = date('d-m-Y');
        $time = date('H:i:s');
        $pdf = PDF::loadview('FRONTOFFICE.LAPORANKASIR.LAPORANPENJUALAN.lap_jual_perkategory_t-pdf',
            ['kodeigr' => $kodeigr, 'date1' => $dateA, 'date2' => $dateB, 'data' => $datas, 'today' => $today, 'time' => $time, 'perusahaan' => $perusahaan,
                'qty' => $qty, 'cf_nmargin' => $cf_nmargin, 'periode' => $periode,
                'gross' => $gross, 'tax' => $tax, 'net' => $net, 'hpp' => $hpp, 'margin' => $margin, 'marginpersen' => $marginpersen, 'qtygrandtotal' => $qtyGrandTotal]);
        $pdf->setPaper('A4', 'potrait');
        $pdf->output();
        $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);

        $canvas = $dompdf->get_canvas();
        $canvas->page_text(511, 78, "{PAGE_NUM} / {PAGE_COUNT}", null, 7, array(0, 0, 0));

        return $pdf->stream('lap_jual_perkategory_t.pdf');
    }

    public function printDocumentMenu2(Request $request)
    {
        $kodeigr = Session::get('kdigr');
        $dateA = $request->date1;
        $dateB = $request->date2;
        $sDate = DateTime::createFromFormat('d-m-Y', $dateA)->format('d-m-Y');
        $eDate = DateTime::createFromFormat('d-m-Y', $dateB)->format('d-m-Y');
        $export = $request->export; //P_CKSRX
        $grosirA = $request->grosira;
        $lst_print = $request->lst_print;
        if ($lst_print == "INDOGROSIR ALL [IGR   (OMI/IDM)]") {
            $lst_print = "INDOGROSIR ALL [IGR + (OMI/IDM)]";
        }

        if ($dateA != $dateB) {
            $periode = 'PERIODE: ' . $dateA . ' s/d ' . $dateB;
        } else {
            $periode = 'TANGGAL: ' . $dateA;
        }
        $datas = DB::connection(Session::get('connection'))->select("SELECT prs_namaperusahaan, prs_namacabang, cdiv, div_namadivisi, cdept, dep_namadepartement, fdfbkp, cexp,
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

//        if(sizeof($datas) == 0){
//            return "**DATA TIDAK ADA**";
//        }


        //CALCULATE GRAND TOTAL

        $gross['k'] = 0;
        $tax['k'] = 0;
        $net['k'] = 0;
        $hpp['k'] = 0;
        $margin['k'] = 0;
        $gross['p'] = 0;
        $tax['p'] = 0;
        $net['p'] = 0;
        $hpp['p'] = 0;
        $margin['p'] = 0;
        $gross['b'] = 0;
        $tax['b'] = 0;
        $net['b'] = 0;
        $hpp['b'] = 0;
        $margin['b'] = 0;
        $gross['c'] = 0;
        $tax['c'] = 0;
        $net['c'] = 0;
        $hpp['c'] = 0;
        $margin['c'] = 0;
        $gross['g'] = 0;
        $tax['g'] = 0;
        $net['g'] = 0;
        $hpp['g'] = 0;
        $margin['g'] = 0;
        $gross['r'] = 0;
        $tax['r'] = 0;
        $net['r'] = 0;
        $hpp['r'] = 0;
        $margin['r'] = 0;
        $gross['x'] = 0;
        $tax['x'] = 0;
        $net['x'] = 0;
        $hpp['x'] = 0;
        $margin['x'] = 0;
        $gross['e'] = 0;
        $tax['e'] = 0;
        $net['e'] = 0;
        $hpp['e'] = 0;
        $margin['e'] = 0;
        $gross['d'] = 0;
        $tax['d'] = 0;
        $net['d'] = 0;
        $hpp['d'] = 0;
        $margin['d'] = 0;
        $gross['f'] = 0;
        $tax['f'] = 0;
        $net['f'] = 0;
        $hpp['f'] = 0;
        $margin['f'] = 0;

        for ($i = 0; $i < sizeof($datas); $i++) {
            if (($datas[$i]->cdiv) != '5' && (($datas[$i]->cdept != '39') && ($datas[$i]->cdept != '40') && ($datas[$i]->cdept != '43'))) {
                if ($datas[$i]->ntax != 0) {
                    $gross['p'] = $gross['p'] + $datas[$i]->ngross;
                    $tax['p'] = $tax['p'] + $datas[$i]->ntax;
                    $net['p'] = $net['p'] + $datas[$i]->nnet;
                    $hpp['p'] = $hpp['p'] + $datas[$i]->nhpp;
                    $margin['p'] = $margin['p'] + $datas[$i]->nmargin;
                } else {
                    switch ($datas[$i]->fdfbkp) {
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
                            if ($grosirA == 'T' && ($datas[$i]->cexp == 'T')) {
                                $gross['e'] = $gross['e'] + $datas[$i]->ngross;
                                if ($export != 'Y') {
                                    $tax['e'] = $tax['e'] + $datas[$i]->ntax;
                                }
                                $net['e'] = $net['e'] + $datas[$i]->nnet;
                                $hpp['e'] = $hpp['e'] + $datas[$i]->nhpp;
                                $margin['e'] = $margin['e'] + $datas[$i]->nmargin;
                            } else {
                                $gross['x'] = $gross['x'] + $datas[$i]->ngross;
                                if ($export != 'Y') {
                                    $tax['x'] = $tax['x'] + $datas[$i]->ntax;
                                }
                                $net['x'] = $net['x'] + $datas[$i]->nnet;
                                $hpp['x'] = $hpp['x'] + $datas[$i]->nhpp;
                                $margin['x'] = $margin['x'] + $datas[$i]->nmargin;
                            }
                    }
                }
            } elseif (($datas[$i]->cdiv) == '5' && ($datas[$i]->cdept) == '39') {
                $gross['c'] = $gross['c'] + $datas[$i]->ngross;
                $tax['c'] = $tax['c'] + $datas[$i]->ntax;
                $net['c'] = $net['c'] + $datas[$i]->nnet;
                $hpp['c'] = $hpp['c'] + $datas[$i]->nhpp;
                $margin['c'] = $margin['c'] + $datas[$i]->nmargin;
            } elseif (($datas[$i]->cdiv) == '5' && ($datas[$i]->cdept) == '40') {
                $gross['d'] = $gross['d'] + $datas[$i]->ngross;
                $tax['d'] = $tax['d'] + $datas[$i]->ntax;
                $net['d'] = $net['d'] + $datas[$i]->nnet;
                $hpp['d'] = $hpp['d'] + $datas[$i]->nhpp;
                $margin['d'] = $margin['d'] + $datas[$i]->nmargin;
            } elseif (($datas[$i]->cdiv) == '5' && ($datas[$i]->cdept) == '43') {
                $gross['f'] = $gross['f'] + $datas[$i]->ngross;
                $tax['f'] = $tax['f'] + $datas[$i]->ntax;
                $net['f'] = $net['f'] + $datas[$i]->nnet;
                $hpp['f'] = $hpp['f'] + $datas[$i]->nhpp;
                $margin['f'] = $margin['f'] + $datas[$i]->nmargin;
            }
        }

        //persentase margin
        if ($net['c'] != 0) {
            $marginpersen['c'] = round(($margin['c']) * 100 / ($net['c']), 2);
        } else {
            if (($margin['c']) != 0) {
                $marginpersen['c'] = 100;
            } else {
                $marginpersen['c'] = 0;
            }
        }
        if ($net['f'] != 0) {
            $marginpersen['f'] = round(($margin['f']) * 100 / ($net['f']), 2);
        } else {
            if (($margin['f']) != 0) {
                $marginpersen['f'] = 100;
            } else {
                $marginpersen['f'] = 0;
            }
        }
        if ($net['p'] != 0) {
            $marginpersen['p'] = round(($margin['p']) * 100 / ($net['p']), 2);
        } else {
            if (($margin['p']) != 0) {
                $marginpersen['p'] = 100;
            } else {
                $marginpersen['p'] = 0;
            }
        }
        if ($net['x'] != 0) {
            $marginpersen['x'] = round(($margin['x']) * 100 / ($net['x']), 2);
        } else {
            if (($margin['x']) != 0) {
                $marginpersen['x'] = 100;
            } else {
                $marginpersen['x'] = 0;
            }
        }
        if ($net['k'] != 0) {
            $marginpersen['k'] = round(($margin['k']) * 100 / ($net['k']), 2);
        } else {
            if (($margin['k']) != 0) {
                $marginpersen['k'] = 100;
            } else {
                $marginpersen['k'] = 0;
            }
        }
        if ($net['b'] != 0) {
            $marginpersen['b'] = round(($margin['b']) * 100 / ($net['b']), 2);
        } else {
            if (($margin['b']) != 0) {
                $marginpersen['b'] = 100;
            } else {
                $marginpersen['b'] = 0;
            }
        }
        if ($net['e'] != 0) {
            $marginpersen['e'] = round(($margin['e']) * 100 / ($net['e']), 2);
        } else {
            if (($margin['e']) != 0) {
                $marginpersen['e'] = 100;
            } else {
                $marginpersen['e'] = 0;
            }
        }
        if ($net['g'] != 0) {
            $marginpersen['g'] = round(($margin['g']) * 100 / ($net['g']), 2);
        } else {
            if (($margin['g']) != 0) {
                $marginpersen['g'] = 100;
            } else {
                $marginpersen['g'] = 0;
            }
        }
        if ($net['r'] != 0) {
            $marginpersen['r'] = round(($margin['r']) * 100 / ($net['r']), 2);
        } else {
            if (($margin['r']) != 0) {
                $marginpersen['r'] = 100;
            } else {
                $marginpersen['r'] = 0;
            }
        }
        if ($net['d'] != 0) {
            $marginpersen['d'] = round(($margin['d']) * 100 / ($net['d']), 2);
        } else {
            if (($margin['d']) != 0) {
                $marginpersen['d'] = 100;
            } else {
                $marginpersen['d'] = 0;
            }
        }

        //ULTIMATE GRAND TOTAL
        $gross['total'] = 0;
        $tax['total'] = 0;
        $net['total'] = 0;
        $hpp['total'] = 0;
        $margin['total'] = 0;
        for ($i = 0; $i < sizeof($datas); $i++) {
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

        if ($net['total'] != 0) {
            $marginpersen['total'] = round(($margin['total']) * 100 / ($net['total']), 2);
        } else {
            if (($margin['total']) != 0) {
                $marginpersen['total'] = 100;
            } else {
                $marginpersen['total'] = 0;
            }
        }

        if ($net['total'] != 0) {
            $marginpersen['total'] = round(($margin['total']) * 100 / ($net['total']), 2);
        } else {
            if (($margin['total']) != 0) {
                $marginpersen['total'] = 100;
            } else {
                $marginpersen['total'] = 0;
            }
        }

        if ($net['total'] - $net['d'] != 0) {
            $marginpersen['tminp'] = round(($margin['total'] - $margin['d']) * 100 / ($net['total'] - $net['d']), 2);
        } else {
            if (($margin['total'] - $margin['d']) != 0) {
                $marginpersen['tminp'] = 100;
            } else {
                $marginpersen['tminp'] = 0;
            }
        }

        //MENGAMBIL ULANG DATA TANPA FDFBKP agar tidak group by fdfbkp yang menyebabkan nilai menjadi double,
        //fdfbkp sebelumnya diperlukan untuk menghitung total
        $datas = DB::connection(Session::get('connection'))->select("SELECT prs_namaperusahaan, prs_namacabang, cdiv, div_namadivisi, cdept, dep_namadepartement, cexp,
       CASE WHEN '$export' = 'Y' THEN 'LAPORAN PENJUALAN (EXPORT)' ELSE 'LAPORAN PENJUALAN' END title,
       SUM(fdnamt + CASE WHEN '$grosirA'='T' THEN fdfnam ELSE 0 END) nGross, --fdnamt+fdfnam
       CASE WHEN '$export' <> 'Y' THEN SUM( CASE WHEN '$export' <> 'Y' THEN fdntax END + CASE WHEN '$grosirA'='T' THEN fdftax ELSE 0 END  ) END nTax, --fdntax+fdftax
       SUM(fdnnet + CASE WHEN '$grosirA'='T' THEN fdfnet ELSE 0 END) nNet, --fdnnet+fdfnet
       SUM(fdnhpp + CASE WHEN '$grosirA'='T' THEN fdfhpp ELSE 0 END) nHpp, --fdnhpp+fdfhpp
       SUM(fdmrgn + CASE WHEN '$grosirA'='T' THEN fdfmgn ELSE 0 END) nMargin --fdmrgn+fdfmgn
FROM TBMASTER_PERUSAHAAN, TBMASTER_DIVISI, TBMASTER_DEPARTEMENT,
(    SELECT sls_kodeigr, sls_kodedivisi cdiv, sls_kodedepartement cdept,
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
GROUP BY sls_kodeigr, prs_namaperusahaan, prs_namacabang, cdiv, div_namadivisi, cdept, dep_namadepartement, cexp
ORDER BY cdiv,cdept");

        $cf_nmargin = [];
        for ($i = 0; $i < sizeof($datas); $i++) {
            if (($datas[$i]->nnet) != 0) {
                $cf_nmargin[$i] = round(($datas[$i]->nmargin) * 100 / ($datas[$i]->nnet), 2);
            } else {
                if (($datas[$i]->nmargin) != 0) {
                    $cf_nmargin[$i] = 100;
                } else {
                    $cf_nmargin[$i] = 0;
                }
            }
        }

        //PRINT
        $perusahaan = DB::connection(Session::get('connection'))->table("tbmaster_perusahaan")->first();
        $today = date('d-m-Y');
        $time = date('H:i:s');
        $pdf = PDF::loadview('FRONTOFFICE.LAPORANKASIR.LAPORANPENJUALAN.lap_jual_perdept-pdf',
            ['kodeigr' => $kodeigr, 'date1' => $dateA, 'date2' => $dateB, 'data' => $datas, 'today' => $today, 'time' => $time, 'perusahaan' => $perusahaan,
                'keterangan' => $lst_print, 'cf_nmargin' => $cf_nmargin, 'periode' => $periode,
                'gross' => $gross, 'tax' => $tax, 'net' => $net, 'hpp' => $hpp, 'margin' => $margin, 'marginpersen' => $marginpersen]);
        $pdf->setPaper('A4', 'potrait');
        $pdf->output();
        $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);

        $canvas = $dompdf->get_canvas();
        $canvas->page_text(511, 78, "{PAGE_NUM} / {PAGE_COUNT}", null, 7, array(0, 0, 0));

        return $pdf->stream('lap_jual_perdept.pdf');
    }

    public function printDocumentDMenu2(Request $request)
    {
        $kodeigr = Session::get('kdigr');
        $dateA = $request->date1;
        $dateB = $request->date2;
        $sDate = DateTime::createFromFormat('d-m-Y', $dateA)->format('d-m-Y');
        $eDate = DateTime::createFromFormat('d-m-Y', $dateB)->format('d-m-Y');
        $p_sbu = '';
        $p_khusus = '';
        $p_omi = '';
        $lst_print = $request->lst_print;
        if ($dateA != $dateB) {
            $periode = 'PERIODE: ' . $dateA . ' s/d ' . $dateB;
        } else {
            $periode = 'TANGGAL: ' . $dateA;
        }
        if ($request->p_sbu != 'z') {
            $p_sbu = "AND tko_kodesbu = '" . $request->p_sbu . "'";
        }
        if ($request->p_khusus != 'z') {
//            $p_khusus = "AND SUBSTR(tko_kodeomi,1,1) = '".$request->p_khusus."'";
            $p_khusus = "AND SUBSTR(tko_kodeomi,1,1) = 'O'";
            $p_sbu = "";
        }
        if ($request->p_omi != 'z') {
            $p_omi = "AND tko_kodeomi = '" . $request->p_omi . "'";
        }

        $datas = DB::connection(Session::get('connection'))->select("SELECT prs_namaperusahaan, prs_namacabang, omisbu, namasbu, omikod, namaomi, omidiv, div_namadivisi, dep_namadepartement, omidep,
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
	           CASE WHEN cBkp = 'Y' THEN ((fdnamt*(1+(nvl(prd_ppn,10)/100)))-Fdnamt) ELSE 0 END
	         ELSE
	           CASE WHEN cBkp = 'Y' THEN (fdnamt-(Fdnamt/(1+(nvl(prd_ppn,10)/100)))) ELSE 0 END
	         END
	      END nTax,
	      CASE WHEN Fdkdiv = '5' AND fddiv = '39' THEN
	         Fdnamt
	      ELSE
	         CASE WHEN  omisbu = 'O' OR omisbu = 'I' THEN
	            Fdnamt
	         ELSE
	            Fdnamt-(CASE WHEN cBkp = 'Y' THEN (fdnamt-(Fdnamt/(1+(nvl(prd_ppn,10)/100)))) ELSE 0 END)
	         END
	      END nNet,
	      CASE WHEN Fdkdiv = '5' AND fddiv = '39' THEN
	         CASE WHEN Mark_up IS NULL THEN ((5*Fdnamt)/100) ELSE ((Mark_up*Fdnamt)/100) END
	      ELSE
	         (CASE WHEN  omisbu = 'O' OR omisbu = 'I' THEN Fdnamt ELSE Fdnamt-(CASE WHEN cBkp = 'Y' THEN (fdnamt-(Fdnamt/(1+(nvl(prd_ppn,10)/100)))) ELSE 0 END) END) -
			 ( Fdjqty/(CASE WHEN unit='KG'THEN 1000 ELSE 1 END)*Fdcost)
	      END nMargin,
	      CASE WHEN Fdkdiv = '5' AND fddiv = '39' THEN
	         Fdnamt - (CASE WHEN Mark_up IS NULL THEN ((5*Fdnamt)/100) ELSE ((Mark_up*Fdnamt)/100) END)
	      ELSE
	         (Fdjqty/(CASE WHEN unit='KG'THEN 1000 ELSE 1 END)*Fdcost)
	      END nHpp,
	      CASE WHEN omisbu = 'O' OR omisbu = 'I' THEN
	         CASE WHEN cBkp = 'Y' THEN
	            fdnamt*(1+(nvl(prd_ppn,10)/100))
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
			   CASE WHEN trjd_cus_kodemember NOT IN (SELECT cus_kodemember FROM TBMASTER_CUSTOMER) THEN 'T' ELSE cus_flagPKP END pjkO,
			   prd_ppn
		FROM TBMASTER_TOKOIGR, TBTR_JUALDETAIL, TBMASTER_CUSTOMER, TBMASTER_PRODMAST
		WHERE trjd_cus_kodemember = tko_kodecustomer
		  AND trjd_cus_kodemember = cus_kodemember
		  AND trjd_prdcd = prd_prdcd and trjd_quantity > 0
		  " . $p_sbu . " " . $p_khusus . " " . $p_omi . "
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

//        if(sizeof($datas) == 0){
//            return "**DATA TIDAK ADA**";
//        }


        $cf_nmargin = [];
        for ($i = 0; $i < sizeof($datas); $i++) {
            if (($datas[$i]->ominet) != 0) {
                $cf_nmargin[$i] = round(($datas[$i]->omimrg) * 100 / ($datas[$i]->ominet), 2);
            } else {
                if (($datas[$i]->nmargin) != 0) {
                    $cf_nmargin[$i] = 100;
                } else {
                    $cf_nmargin[$i] = 0;
                }
            }
        }

        //CALCULATE GRAND TOTAL

        $gross['i'] = 0;
        $tax['i'] = 0;
        $net['i'] = 0;
        $hpp['i'] = 0;
        $margin['i'] = 0;
        $gross['o'] = 0;
        $tax['o'] = 0;
        $net['o'] = 0;
        $hpp['o'] = 0;
        $margin['o'] = 0;
        $gross['total'] = 0;
        $tax['total'] = 0;
        $net['total'] = 0;
        $hpp['total'] = 0;
        $margin['total'] = 0;

        for ($i = 0; $i < sizeof($datas); $i++) {
            if ($datas[$i]->omisbu == 'O') {
                $gross['o'] = $gross['o'] + $datas[$i]->omiamt;
                $tax['o'] = $tax['o'] + $datas[$i]->omitax;
                $net['o'] = $net['o'] + $datas[$i]->ominet;
                $hpp['o'] = $hpp['o'] + $datas[$i]->omihpp;
                $margin['o'] = $margin['o'] + $datas[$i]->omimrg;
            } else {
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
        if ($net['i'] != 0) {
            $marginpersen['i'] = round(($margin['i']) / ($net['i']) * 100, 2);
        } else {
            $marginpersen['i'] = 0;
        }
        if ($net['o'] != 0) {
            $marginpersen['o'] = round(($margin['o']) / ($net['o']) * 100, 2);
        } else {
            $marginpersen['o'] = 0;
        }
        if ($net['total'] != 0) {
            $marginpersen['total'] = round(($margin['total']) * 100 / ($net['total']), 2);
        } else {
            if (($margin['total']) != 0) {
                $marginpersen['total'] = 100;
            } else {
                $marginpersen['total'] = 0;
            }
        }

//        //PRINT
        $perusahaan = DB::connection(Session::get('connection'))->table("tbmaster_perusahaan")->first();
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

        return view('FRONTOFFICE.LAPORANKASIR.LAPORANPENJUALAN.lap_jual_perdept_d-pdf', ['kodeigr' => $kodeigr, 'date1' => $dateA, 'date2' => $dateB, 'data' => $datas, 'today' => $today, 'time' => $time, 'perusahaan' => $perusahaan,
            'keterangan' => $lst_print, 'cf_nmargin' => $cf_nmargin, 'periode' => $periode,
            'gross' => $gross, 'tax' => $tax, 'net' => $net, 'hpp' => $hpp, 'margin' => $margin, 'marginpersen' => $marginpersen]);
    }

    public function printDocumentCMenu2(Request $request)
    {
        $kodeigr = Session::get('kdigr');
        $dateA = $request->date1;
        $dateB = $request->date2;
        $sDate = DateTime::createFromFormat('d-m-Y', $dateA)->format('d-m-Y');
        $eDate = DateTime::createFromFormat('d-m-Y', $dateB)->format('d-m-Y');
        $p_sbu = '';
        $p_khusus = '';
        $p_omi = '';
        $lst_print = $request->lst_print;
        if ($dateA != $dateB) {
            $periode = 'PERIODE: ' . $dateA . ' s/d ' . $dateB;
        } else {
            $periode = 'TANGGAL: ' . $dateA;
        }
        if ($request->p_sbu != 'z') {
            $p_sbu = "AND tko_kodesbu = '" . $request->p_sbu . "'";
        }
        if ($request->p_khusus != 'z') {
//            $p_khusus = "AND SUBSTR(tko_kodeomi,1,1) = '".$request->p_khusus."'";
            $p_khusus = "AND SUBSTR(tko_kodeomi,1,1) = 'O'";
            $p_sbu = "";
        }
        if ($request->p_omi != 'z') {
            $p_omi = "AND tko_kodeomi = '" . $request->p_omi . "'";
        }
        $datas = DB::connection(Session::get('connection'))->select("SELECT prs_namaperusahaan, prs_namacabang, div_namadivisi, dep_namadepartement, omisbu, namasbu, omidiv, omidep,
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
	           CASE WHEN cBkp = 'Y' THEN ((fdnamt*(1+(nvl(prd_ppn,10)/100)))-Fdnamt) ELSE 0 END
	         ELSE
	           CASE WHEN cBkp = 'Y' THEN (fdnamt-(Fdnamt/(1+(nvl(prd_ppn,10)/100)))) ELSE 0 END
	         END
	      END nTax,
	      CASE WHEN Fdkdiv = '5' AND fddiv = '39' THEN
	         Fdnamt
	      ELSE
	         CASE WHEN  omisbu = 'O' OR omisbu = 'I' THEN
	            Fdnamt
	         ELSE
	            Fdnamt-(CASE WHEN cBkp = 'Y' THEN (fdnamt-(Fdnamt/(1+(nvl(prd_ppn,10)/100)))) ELSE 0 END)
	         END
	      END nNet,
	      CASE WHEN Fdkdiv = '5' AND fddiv = '39' THEN
	         CASE WHEN Mark_up IS NULL THEN ((5*Fdnamt)/100) ELSE ((Mark_up*Fdnamt)/100) END
	      ELSE
	         (CASE WHEN  omisbu = 'O' OR omisbu = 'I' THEN Fdnamt ELSE Fdnamt-(CASE WHEN cBkp = 'Y' THEN (fdnamt-(Fdnamt/(1+(nvl(prd_ppn,10)/100)))) ELSE 0 END) END) -
			 ( Fdjqty/(CASE WHEN unit='KG'THEN 1000 ELSE 1 END)*Fdcost)
	      END nMargin,
	      CASE WHEN Fdkdiv = '5' AND fddiv = '39' THEN
	         Fdnamt - (CASE WHEN Mark_up IS NULL THEN ((5*Fdnamt)/100) ELSE ((Mark_up*Fdnamt)/100) END)
	      ELSE
	         (Fdjqty/(CASE WHEN unit='KG'THEN 1000 ELSE 1 END)*Fdcost)
	      END nHpp,
	      CASE WHEN omisbu = 'O' OR omisbu = 'I' THEN
	         CASE WHEN cBkp = 'Y' THEN
	            fdnamt*(1+(nvl(prd_ppn,10)/100))
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
			   CASE WHEN trjd_cus_kodemember NOT IN (SELECT cus_kodemember FROM TBMASTER_CUSTOMER) THEN 'T' ELSE cus_flagPKP END pjkO,
			   prd_ppn
		FROM TBMASTER_TOKOIGR, TBTR_JUALDETAIL, TBMASTER_CUSTOMER, TBMASTER_PRODMAST
		WHERE trjd_cus_kodemember = tko_kodecustomer
		  AND trjd_cus_kodemember = cus_kodemember
		  AND trjd_prdcd = prd_prdcd
		  " . $p_sbu . " " . $p_khusus . " " . $p_omi . "
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


        $namaomi = DB::connection(Session::get('connection'))->table('tbmaster_tokoigr')
            ->selectRaw("tko_namaomi")
            ->where('tko_kodeomi', '=', $p_omi)
            ->first();

//        if(sizeof($datas) == 0){
//            return "**DATA TIDAK ADA**";
//        }

        //CALCULATE GRAND TOTAL

        $gross['i'] = 0;
        $tax['i'] = 0;
        $net['i'] = 0;
        $hpp['i'] = 0;
        $margin['i'] = 0;
        $gross['o'] = 0;
        $tax['o'] = 0;
        $net['o'] = 0;
        $hpp['o'] = 0;
        $margin['o'] = 0;
        $gross['total'] = 0;
        $tax['total'] = 0;
        $net['total'] = 0;
        $hpp['total'] = 0;
        $margin['total'] = 0;

        for ($i = 0; $i < sizeof($datas); $i++) {
            if ($datas[$i]->omisbu == 'O') {
                $gross['o'] = $gross['o'] + $datas[$i]->omiamt;
                $tax['o'] = $tax['o'] + $datas[$i]->omitax;
                $net['o'] = $net['o'] + $datas[$i]->ominet;
                $hpp['o'] = $hpp['o'] + $datas[$i]->omihpp;
                $margin['o'] = $margin['o'] + $datas[$i]->omimrg;
            } else {
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
        if ($net['i'] != 0) {
            $marginpersen['i'] = round(($margin['i']) / ($net['i']) * 100, 2);
        } else {
            $marginpersen['i'] = 0;
        }
        if ($net['o'] != 0) {
            $marginpersen['o'] = round(($margin['o']) / ($net['o']) * 100, 2);
        } else {
            $marginpersen['o'] = 0;
        }
        if ($net['total'] != 0) {
            $marginpersen['total'] = round(($margin['total']) * 100 / ($net['total']), 2);
        } else {
            if (($margin['total']) != 0) {
                $marginpersen['total'] = 100;
            } else {
                $marginpersen['total'] = 0;
            }
        }

        if ($p_sbu == '') {
            $datas = DB::connection(Session::get('connection'))->select("SELECT prs_namaperusahaan, prs_namacabang, div_namadivisi, dep_namadepartement, omidiv, omidep,
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
	           CASE WHEN cBkp = 'Y' THEN ((fdnamt*(1+(nvl(prd_ppn,10)/100)))-Fdnamt) ELSE 0 END
	         ELSE
	           CASE WHEN cBkp = 'Y' THEN (fdnamt-(Fdnamt/(1+(nvl(prd_ppn,10)/100)))) ELSE 0 END
	         END
	      END nTax,
	      CASE WHEN Fdkdiv = '5' AND fddiv = '39' THEN
	         Fdnamt
	      ELSE
	         CASE WHEN  omisbu = 'O' OR omisbu = 'I' THEN
	            Fdnamt
	         ELSE
	            Fdnamt-(CASE WHEN cBkp = 'Y' THEN (fdnamt-(Fdnamt/(1+(nvl(prd_ppn,10)/100)))) ELSE 0 END)
	         END
	      END nNet,
	      CASE WHEN Fdkdiv = '5' AND fddiv = '39' THEN
	         CASE WHEN Mark_up IS NULL THEN ((5*Fdnamt)/100) ELSE ((Mark_up*Fdnamt)/100) END
	      ELSE
	         (CASE WHEN  omisbu = 'O' OR omisbu = 'I' THEN Fdnamt ELSE Fdnamt-(CASE WHEN cBkp = 'Y' THEN (fdnamt-(Fdnamt/(1+(nvl(prd_ppn,10)/100)))) ELSE 0 END) END) -
			 ( Fdjqty/(CASE WHEN unit='KG'THEN 1000 ELSE 1 END)*Fdcost)
	      END nMargin,
	      CASE WHEN Fdkdiv = '5' AND fddiv = '39' THEN
	         Fdnamt - (CASE WHEN Mark_up IS NULL THEN ((5*Fdnamt)/100) ELSE ((Mark_up*Fdnamt)/100) END)
	      ELSE
	         (Fdjqty/(CASE WHEN unit='KG'THEN 1000 ELSE 1 END)*Fdcost)
	      END nHpp,
	      CASE WHEN omisbu = 'O' OR omisbu = 'I' THEN
	         CASE WHEN cBkp = 'Y' THEN
	            fdnamt*(1+(nvl(prd_ppn,10)/100))
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
			   CASE WHEN trjd_cus_kodemember NOT IN (SELECT cus_kodemember FROM TBMASTER_CUSTOMER) THEN 'T' ELSE cus_flagPKP END pjkO,
			   prd_ppn
		FROM TBMASTER_TOKOIGR, TBTR_JUALDETAIL, TBMASTER_CUSTOMER, TBMASTER_PRODMAST
		WHERE trjd_cus_kodemember = tko_kodecustomer
		  AND trjd_cus_kodemember = cus_kodemember
		  AND trjd_prdcd = prd_prdcd
		  " . $p_sbu . " " . $p_khusus . " " . $p_omi . "
		  AND TRUNC(trjd_transactiondate) BETWEEN TO_DATE('$sDate','DD-MM-YYYY') AND TO_DATE('$eDate', 'DD-MM-YYYY')
		  AND tko_kodeOMI NOT IN (SELECT tko_kodeOMI FROM TBMASTER_TOKOIGR WHERE tko_tipeOMI IN ('HR','HG'))
	)
)
WHERE prs_kodeigr = '$kodeigr'
  AND kodeigr = prs_kodeigr
  AND omidiv = div_kodedivisi
  AND omidep = dep_kodedepartement
GROUP BY prs_namaperusahaan, prs_namacabang, div_namadivisi, dep_namadepartement, omidiv, omidep
ORDER BY omidiv, omidep");
        }

        $cf_nmargin = [];
        for ($i = 0; $i < sizeof($datas); $i++) {
            if (($datas[$i]->ominet) != 0) {
                $cf_nmargin[$i] = round(($datas[$i]->omimrg) * 100 / ($datas[$i]->ominet), 2);
            } else {
                if (($datas[$i]->nmargin) != 0) {
                    $cf_nmargin[$i] = 100;
                } else {
                    $cf_nmargin[$i] = 0;
                }
            }
        }
//        //PRINT
        $perusahaan = DB::connection(Session::get('connection'))->table("tbmaster_perusahaan")->first();
        $today = date('d-m-Y');
        $time = date('H:i:s');
        $pdf = PDF::loadview('FRONTOFFICE.LAPORANKASIR.LAPORANPENJUALAN.lap_jual_perdept_c-pdf',
            ['kodeigr' => $kodeigr, 'date1' => $dateA, 'date2' => $dateB, 'data' => $datas, 'today' => $today, 'time' => $time, 'namaomi' => $namaomi, 'perusahaan' => $perusahaan,
                'keterangan' => $lst_print, 'cf_nmargin' => $cf_nmargin, 'periode' => $periode,
                'gross' => $gross, 'tax' => $tax, 'net' => $net, 'hpp' => $hpp, 'margin' => $margin, 'marginpersen' => $marginpersen]);
        $pdf->setPaper('A4', 'potrait');
        $pdf->output();
        $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);

        $canvas = $dompdf->get_canvas();
        $canvas->page_text(511, 78, "{PAGE_NUM} / {PAGE_COUNT}", null, 8, array(0, 0, 0));

        return $pdf->stream('lap_jual_perdept_c.pdf');

//        return view('FRONTOFFICE\LAPORANKASIR\LAPORANPENJUALAN\lap_jual_perdept_d-pdf',['kodeigr' => $kodeigr, 'date1' => $dateA, 'date2' => $dateB, 'datas' => $datas, 'today' => $today, 'time' => $time,
//            'keterangan' => $lst_print, 'cf_nmargin' => $cf_nmargin, 'periode' => $periode,
//            'gross' => $gross, 'tax' => $tax, 'net' => $net, 'hpp' => $hpp,'margin' => $margin, 'marginpersen' => $marginpersen]);
    }

    public function printDocumentMenu3(Request $request)
    {
        $kodeigr = Session::get('kdigr');
        $dateA = $request->date1;
        $dateB = $request->date2;
        $sDate = DateTime::createFromFormat('d-m-Y', $dateA)->format('d-m-Y');
        $eDate = DateTime::createFromFormat('d-m-Y', $dateB)->format('d-m-Y');
        $div = $request->div;
        $p_div = '';
        if ($div != 'SEMUA DIVISI') {
            $p_div = 'and fdkdiv = ' . $div;
        }
        $dept = $request->dept;
        $p_dept = '';
        if ($dept != 'SEMUA DEPARTEMENT') {
            $p_dept = 'and fdkdep = ' . $dept;
        }

        $kat = $request->kat;
        $p_kat = '';
        if ($kat != 'SEMUA KATEGORY') {
            $p_kat = 'and fdkatb = ' . $kat;
        }

        $margin1 = (float)$request->margin1;
        $margin2 = (float)$request->margin2;
        $mon = $request->mon;
        $pluall = $request->pluall;

        if ($pluall == 'N') {
            $datas = DB::connection(Session::get('connection'))->select("SELECT prs_namaperusahaan, prs_namacabang, prs_namawilayah,
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
	  AND translate(mpl_kodemonitoring,' ','_') = '$mon'
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
  --AND fdkdiv in ('" . $div . "')
  " . $p_div . " " . $p_dept . " " . $p_kat . "
  AND CASE WHEN (fdnnet+fdfnet) <> 0 THEN  (((fdmrgn+fdfmgn)*100)/(fdnnet+fdfnet)) ELSE
	      CASE WHEN (fdmrgn+fdfmgn) <> 0 THEN 100 ELSE 0 END END between " . $margin1 . " AND " . $margin2 . "
ORDER BY fdkdiv, fdkdep, fdkatb");
        } else { //jika pluall == Y maka masuk else
            $datas = DB::connection(Session::get('connection'))->select("SELECT prs_namaperusahaan, prs_namacabang, prs_namawilayah,
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
  --AND fdkdiv in ('" . $div . "')
  " . $p_div . " " . $p_dept . " " . $p_kat . "
  AND CASE WHEN (fdnnet+fdfnet) <> 0 THEN  (((fdmrgn+fdfmgn)*100)/(fdnnet+fdfnet)) ELSE
	      CASE WHEN (fdmrgn+fdfmgn) <> 0 THEN 100 ELSE 0 END END between " . $margin1 . " AND " . $margin2 . "
ORDER BY fdkdiv, fdkdep, fdkatb");
        }

//        if(sizeof($datas) == 0){
//            return "**DATA TIDAK ADA**";
//        }

        //CALCULATE GRAND TOTAL
        //$arrayIndex = ['p','i','b','g','r','e','x','c','f','h','total-40','total'];
        $arrayIndex = ['c', 'p', 'x', 'i', 'b', 'e', 'g', 'r', 'h', 'total-40', 'total', 'f']; //tersusun, f merupakan departemen 40, hanya dipakai untuk mendapatkan total-40, tidak untuk ditampilkan

        foreach ($arrayIndex as $index) {
            $gross[$index] = 0;
            $tax[$index] = 0;
            $net[$index] = 0;
            $hpp[$index] = 0;
            $margin[$index] = 0;
            $margp[$index] = 0;
        }

        if ($pluall == 'N') {
            $rec = DB::connection(Session::get('connection'))->select("SELECT prs_namaperusahaan, prs_namacabang, prs_namawilayah,
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
	  AND mpl_kodemonitoring = '$mon'
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
	    CASE WHEN (fdmrgn+fdfmgn) <> 0 THEN 100 ELSE 0 END END between " . $margin1 . " AND " . $margin2 . "
ORDER BY fdkdiv, fdkdep, fdkatb");
        } else {
            $rec = DB::connection(Session::get('connection'))->select("SELECT prs_namaperusahaan, prs_namacabang, prs_namawilayah,
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
	    CASE WHEN (fdmrgn+fdfmgn) <> 0 THEN 100 ELSE 0 END END between " . $margin1 . " AND " . $margin2 . "
ORDER BY fdkdiv, fdkdep, fdkatb");
        }

        for ($i = 0; $i < sizeof($rec); $i++) {
            if ($rec[$i]->fdkdiv == $div || $div == 'SEMUA DIVISI') {
                if ($rec[$i]->fdkdep == $dept || $dept == 'SEMUA DEPARTEMENT') {
                    if ($rec[$i]->fdkatb == $kat || $kat == 'SEMUA KATEGORY') {
                        if ($rec[$i]->fdkdiv != '5' && (($rec[$i]->fdkdep != '39') && ($rec[$i]->fdkdep != '40') && ($rec[$i]->fdkdep != '43'))) {
                            if ($rec[$i]->fdntax != 0 || $rec[$i]->fdftax != 0) {
                                $gross['p'] = $gross['p'] + ($rec[$i]->fdnamt + $rec[$i]->fdfnam);
                                $tax['p'] = $tax['p'] + ($rec[$i]->fdntax + $rec[$i]->fdftax);
                                $net['p'] = $net['p'] + ($rec[$i]->fdnnet + $rec[$i]->fdfnet);
                                $hpp['p'] = $hpp['p'] + ($rec[$i]->fdnhpp + $rec[$i]->fdfhpp);
                                $margin['p'] = $margin['p'] + ($rec[$i]->fdmrgn + $rec[$i]->fdfmgn);
                            } else {
                                if ($rec[$i]->fdfbkp == 'C') {
                                    $gross['i'] = $gross['i'] + ($rec[$i]->fdnamt + $rec[$i]->fdfnam);
                                    $tax['i'] = $tax['i'] + ($rec[$i]->fdntax + $rec[$i]->fdftax);
                                    $net['i'] = $net['i'] + ($rec[$i]->fdnnet + $rec[$i]->fdfnet);
                                    $hpp['i'] = $hpp['i'] + ($rec[$i]->fdnhpp + $rec[$i]->fdfhpp);
                                    $margin['i'] = $margin['i'] + ($rec[$i]->fdmrgn + $rec[$i]->fdfmgn);
                                } elseif ($rec[$i]->fdfbkp == 'P') {
                                    $gross['b'] = $gross['b'] + ($rec[$i]->fdnamt + $rec[$i]->fdfnam);
                                    $tax['b'] = $tax['b'] + ($rec[$i]->fdntax + $rec[$i]->fdftax);
                                    $net['b'] = $net['b'] + ($rec[$i]->fdnnet + $rec[$i]->fdfnet);
                                    $hpp['b'] = $hpp['b'] + ($rec[$i]->fdnhpp + $rec[$i]->fdfhpp);
                                    $margin['b'] = $margin['b'] + ($rec[$i]->fdmrgn + $rec[$i]->fdfmgn);
                                } elseif ($rec[$i]->fdfbkp == 'G') {
                                    $gross['g'] = $gross['g'] + ($rec[$i]->fdnamt + $rec[$i]->fdfnam);
                                    $tax['g'] = $tax['g'] + ($rec[$i]->fdntax + $rec[$i]->fdftax);
                                    $net['g'] = $net['g'] + ($rec[$i]->fdnnet + $rec[$i]->fdfnet);
                                    $hpp['g'] = $hpp['g'] + ($rec[$i]->fdnhpp + $rec[$i]->fdfhpp);
                                    $margin['g'] = $margin['g'] + ($rec[$i]->fdmrgn + $rec[$i]->fdfmgn);
                                } elseif ($rec[$i]->fdfbkp == 'W') {
                                    $gross['r'] = $gross['r'] + ($rec[$i]->fdnamt + $rec[$i]->fdfnam);
                                    $tax['r'] = $tax['r'] + ($rec[$i]->fdntax + $rec[$i]->fdftax);
                                    $net['r'] = $net['r'] + ($rec[$i]->fdnnet + $rec[$i]->fdfnet);
                                    $hpp['r'] = $hpp['r'] + ($rec[$i]->fdnhpp + $rec[$i]->fdfhpp);
                                    $margin['r'] = $margin['r'] + ($rec[$i]->fdmrgn + $rec[$i]->fdfmgn);
                                } else {
                                    if ($rec[$i]->cexp == 'Y') {
                                        $gross['e'] = $gross['e'] + ($rec[$i]->fdnamt + $rec[$i]->fdfnam);
                                        $tax['e'] = $tax['e'] + ($rec[$i]->fdntax + $rec[$i]->fdftax);
                                        $net['e'] = $net['e'] + ($rec[$i]->fdnnet + $rec[$i]->fdfnet);
                                        $hpp['e'] = $hpp['e'] + ($rec[$i]->fdnhpp + $rec[$i]->fdfhpp);
                                        $margin['e'] = $margin['e'] + ($rec[$i]->fdmrgn + $rec[$i]->fdfmgn);
                                    } else {
                                        $gross['x'] = $gross['x'] + ($rec[$i]->fdnamt + $rec[$i]->fdfnam);
                                        $tax['x'] = $tax['x'] + ($rec[$i]->fdntax + $rec[$i]->fdftax);
                                        $net['x'] = $net['x'] + ($rec[$i]->fdnnet + $rec[$i]->fdfnet);
                                        $hpp['x'] = $hpp['x'] + ($rec[$i]->fdnhpp + $rec[$i]->fdfhpp);
                                        $margin['x'] = $margin['x'] + ($rec[$i]->fdmrgn + $rec[$i]->fdfmgn);
                                    }
                                }
                            }
                        } elseif ($rec[$i]->fdkdiv == '5' && $rec[$i]->fdkdep == '39') {
                            $gross['c'] = $gross['c'] + ($rec[$i]->fdnamt + $rec[$i]->fdfnam);
                            $tax['c'] = $tax['c'] + ($rec[$i]->fdntax + $rec[$i]->fdftax);
                            $net['c'] = $net['c'] + ($rec[$i]->fdnnet + $rec[$i]->fdfnet);
                            $hpp['c'] = $hpp['c'] + ($rec[$i]->fdnhpp + $rec[$i]->fdfhpp);
                            $margin['c'] = $margin['c'] + ($rec[$i]->fdmrgn + $rec[$i]->fdfmgn);
                        } elseif ($rec[$i]->fdkdiv == '5' && $rec[$i]->fdkdep == '40') {
                            $gross['f'] = $gross['f'] + ($rec[$i]->fdnamt + $rec[$i]->fdfnam);
                            $tax['f'] = $tax['f'] + ($rec[$i]->fdntax + $rec[$i]->fdftax);
                            $net['f'] = $net['f'] + ($rec[$i]->fdnnet + $rec[$i]->fdfnet);
                            $hpp['f'] = $hpp['f'] + ($rec[$i]->fdnhpp + $rec[$i]->fdfhpp);
                            $margin['f'] = $margin['f'] + ($rec[$i]->fdmrgn + $rec[$i]->fdfmgn);
                        } elseif ($rec[$i]->fdkdiv == '5' && $rec[$i]->fdkdep == '43') {
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
        for ($i = 0; $i < sizeof($datas); $i++) {
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

        foreach ($arrayIndex as $index) {
            if ($net[$index] != 0) {
                $margp[$index] = $margin[$index] * 100 / $net[$index];
            } else {
                if ($margin[$index] != 0) {
                    $margp[$index] = 100;
                } else {
                    $margp[$index] = 0;
                }
            }
        }

        //PRINT
        $perusahaan = DB::connection(Session::get('connection'))->table("tbmaster_perusahaan")->first();
        $today = date('d-m-Y');
        $time = date('H:i:s');
        if ($pluall == 'N') {
            $pdf = PDF::loadview('FRONTOFFICE.LAPORANKASIR.LAPORANPENJUALAN.lap_jual_perdiv-pdf',
                ['kodeigr' => $kodeigr, 'date1' => $dateA, 'date2' => $dateB, 'mon' => $mon, 'margin1' => $margin1, 'margin2' => $margin2, 'data' => $datas, 'today' => $today, 'time' => $time, 'perusahaan' => $perusahaan,
                    'arrayIndex' => $arrayIndex, 'gross' => $gross, 'tax' => $tax, 'net' => $net, 'hpp' => $hpp, 'margin' => $margin, 'margp' => $margp]);
            $pdf->setPaper('A4', 'landscape');
            $pdf->output();
            $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);

            $canvas = $dompdf->get_canvas();
            $canvas->page_text(759, 78, "{PAGE_NUM}/{PAGE_COUNT}", null, 7, array(0, 0, 0));

            return $pdf->stream('lap_jual_perdiv.pdf');
        } else {
            return view('FRONTOFFICE.LAPORANKASIR.LAPORANPENJUALAN.lap_jual_perdiv_all-pdf',
                ['kodeigr' => $kodeigr, 'date1' => $dateA, 'date2' => $dateB, 'margin1' => $margin1, 'margin2' => $margin2, 'data' => $datas, 'today' => $today, 'time' => $time, 'perusahaan' => $perusahaan,
                    'arrayIndex' => $arrayIndex, 'gross' => $gross, 'tax' => $tax, 'net' => $net, 'hpp' => $hpp, 'margin' => $margin, 'margp' => $margp]);
        }
    }

    public function printDocumentMenu4(Request $request)
    {
        $kodeigr = Session::get('kdigr');
        $dateA = $request->date1;
        $dateB = $request->date2;
        $sDate = DateTime::createFromFormat('d-m-Y', $dateA)->format('d-m-Y');
        $eDate = DateTime::createFromFormat('d-m-Y', $dateB)->format('d-m-Y');
        if ($dateA != $dateB) {
            $periode = 'PERIODE: ' . $dateA . ' s/d ' . $dateB;
        } else {
            $periode = 'TANGGAL: ' . $dateA;
        }

        $ekspor = $request->ekspor;

        $datas = DB::connection(Session::get('connection'))->select("SELECT prs_namaperusahaan, prs_namacabang,
	   CASE WHEN '$ekspor' = 'Y' THEN 'LAPORAN PENJUALAN (EXPORT)' ELSE 'LAPORAN PENJUALAN' END title,
	   sls_periode, hari,
	   sls_nilai, sls_tax, sls_net, sls_hpp, sls_margin,
	   CASE WHEN  sls_net <> 0 THEN  sls_margin * 100 / sls_net ELSE 100 END p_margin
FROM TBMASTER_PERUSAHAAN,
(	 SELECT sls_kodeigr, sls_periode,
		   CASE WHEN TO_CHAR(sls_periode,'DY') = 'SUN' THEN 'MINGGU' ELSE
		   CASE WHEN TO_CHAR(sls_periode,'DY') = 'MON' THEN 'SENIN'  ELSE
		   CASE WHEN TO_CHAR(sls_periode,'DY') = 'TUE' THEN 'SELASA' ELSE
		   CASE WHEN TO_CHAR(sls_periode,'DY') = 'WED' THEN 'RABU'	 ELSE
		   CASE WHEN TO_CHAR(sls_periode,'DY') = 'THU' THEN 'KAMIS'  ELSE
		   CASE WHEN TO_CHAR(sls_periode,'DY') = 'FRI' THEN 'JUMAT'  ELSE
		   'SABTU' END END END END END END hari,
		   SUM(sls_nilainomi+sls_nilaiomi+sls_nilaiidm) sls_nilai,
		   SUM(sls_taxnomi+sls_taxomi+sls_taxidm) sls_tax,
		   SUM(sls_netnomi+sls_netomi+sls_netidm) sls_net,
		   SUM(sls_hppnomi+sls_hppomi+sls_hppidm) sls_hpp,
		   SUM(sls_marginnomi+sls_marginomi+sls_marginidm) sls_margin, NVL(cexp,'T') cexp
	FROM TBTR_SUMSALES, TBMASTER_PERUSAHAAN,
	( 	 SELECT sls_prdcd prdcd, 'Y' cexp
		 FROM TBTR_SUMSALES, TBMASTER_BARANGEXPORT, TBTR_JUALDETAIL, TBMASTER_CUSTOMER
		 WHERE sls_prdcd = exp_prdcd
		   AND trjd_recordid IS NULL
		   AND trjd_prdcd = sls_prdcd
		   AND TRUNC(trjd_transactiondate) = TRUNC(sls_periode)
		   AND TRUNC(sls_periode) BETWEEN TO_DATE('$sDate','DD-MM-YYYY') AND TO_DATE('$eDate', 'DD-MM-YYYY')
		   AND trjd_cus_kodemember = cus_kodemember (+)
	 	   AND cus_jenismember = 'E'
	)
	WHERE sls_prdcd = prdcd(+)
	   AND TRUNC(sls_periode) BETWEEN TO_DATE('$sDate','DD-MM-YYYY') AND TO_DATE('$eDate', 'DD-MM-YYYY')
	GROUP BY sls_kodeigr,sls_periode,cexp
	)
WHERE prs_kodeigr = '$kodeigr'
  AND sls_kodeigr = prs_kodeigr
  AND cexp = '$ekspor'
ORDER BY sls_periode");
//        if(sizeof($datas) == 0){
//            return "**DATA TIDAK ADA**";
//        }

        $val['gross'] = 0;
        $val['tax'] = 0;
        $val['net'] = 0;
        $val['hpp'] = 0;
        $val['margin'] = 0;
        $val['margp'] = 0;

        for ($i = 0; $i < sizeof($datas); $i++) {
            $val['gross'] = $val['gross'] + $datas[$i]->sls_nilai;
            $val['tax'] = $val['tax'] + $datas[$i]->sls_tax;
            $val['net'] = $val['net'] + $datas[$i]->sls_net;
            $val['hpp'] = $val['hpp'] + $datas[$i]->sls_hpp;
            $val['margin'] = $val['margin'] + $datas[$i]->sls_margin;
        }
        if ($val['net'] != 0) {
            $val['margp'] = $val['margin'] * 100 / $val['net'];
        } else {
            if ($val['margin'] != 0) {
                $val['margp'] = 100;
            } else {
                $val['margp'] = 0;
            }
        }

        //PRINT
        $perusahaan = DB::connection(Session::get('connection'))->table("tbmaster_perusahaan")->first();
        $today = date('d-m-Y');
        $time = date('H:i:s');
        $pdf = PDF::loadview('FRONTOFFICE.LAPORANKASIR.LAPORANPENJUALAN.lap_jual_perhari-pdf',
            ['kodeigr' => $kodeigr, 'date1' => $dateA, 'date2' => $dateB, 'data' => $datas, 'perusahaan' => $perusahaan,
                'val' => $val, 'today' => $today, 'time' => $time, 'periode' => $periode]);
        $pdf->setPaper('A4', 'potrait');
        $pdf->output();
        $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);

        $canvas = $dompdf->get_canvas();
        $canvas->page_text(511, 78, "{PAGE_NUM} / {PAGE_COUNT}", null, 7, array(0, 0, 0));

        return $pdf->stream('lap_jual_perhari.pdf');
    }

    public function printDocumentMenu5(Request $request)
    {
        $kodeigr = Session::get('kdigr');
        $dateA = $request->date1;
        $dateB = $request->date2;
        $sDate = DateTime::createFromFormat('d-m-Y', $dateA)->format('d-m-Y');
        $eDate = DateTime::createFromFormat('d-m-Y', $dateB)->format('d-m-Y');
        $kasir = $request->kasir;
        $station = $request->station;
        if ($dateA != $dateB) {
            $periode = 'PERIODE: ' . $dateA . ' s/d ' . $dateB;
        } else {
            $periode = 'TANGGAL: ' . $dateA;
        }

        $datas = DB::connection(Session::get('connection'))->select("SELECT prs_namaperusahaan, prs_namacabang, KASIR, STAT,
       KDIV fdkdiv, div_namadivisi, SUBSTR(DIV,1,2) FDKDEP, dep_namadepartement, SUBSTR(DIV,-2,2) FDKATB, kat_namakategori, FLAGTAX2 Fdfbkp,
       CASE WHEN cEXP = 'T' THEN 'Y' ELSE 'N' END fexpor,
       SUM ( CASE WHEN recordid IS NULL AND tipe = 'S' THEN
                     CASE WHEN admfee > 0 THEN
                 CASE WHEN cBkp = 'Y' AND cObkp = 'Y' THEN
                   fdnamt * (1+(nvl(prd_ppn,10)/100)) ELSE fdnamt
                 END
               ELSE fdnamt
               END
             ELSE
               CASE WHEN recordid IS NULL AND tipe = 'R' THEN
                       CASE WHEN admfee > 0 THEN
                   CASE WHEN cBkp = 'Y' AND cObkp = 'Y' THEN
                     fdnamt * (1+(nvl(prd_ppn,10)/100)) * (0-1) ELSE fdnamt * (0-1)
                   END
                 ELSE fdnamt * (0-1)
                 END
               END
             END
           ) fdnAmt,
       SUM ( CASE WHEN recordid IS NULL AND tipe = 'S' THEN sTax
                   ELSE CASE WHEN recordid IS NULL AND tipe = 'R' THEN sTax*(0-1) END
             END
           ) fdnTax,
       SUM ( CASE WHEN recordid IS NULL AND tipe = 'S' THEN sNet
                   ELSE CASE WHEN recordid IS NULL AND tipe = 'R' THEN sNet*(0-1) END
             END
           ) fdnNet,
       SUM ( CASE WHEN recordid IS NULL AND tipe = 'S' THEN sMargin
                   ELSE CASE WHEN recordid IS NULL AND tipe = 'R' THEN sMargin*(0-1) END
             END
           ) fdnMrgn,
       SUM ( CASE WHEN recordid IS NULL AND tipe = 'S' THEN sHpp
                   ELSE CASE WHEN recordid IS NULL AND tipe = 'R' THEN sHpp*(0-1) END
             END
           ) fdnHpp
FROM TBMASTER_PERUSAHAAN, TBMASTER_DIVISI, TBMASTER_DEPARTEMENT, TBMASTER_KATEGORI,
(    SELECT KDIGR, TGLTRANS, KASIR, STAT, PRDCD, KDIV, DIV, QUANTITY, BASEPRICE, KDMBR, ADMFEE, FLAGTAX2 ,NOMINALAMT FDNAMT, RECORDID, TIPE, PJKO, CEXP, CBKP, COBKP, MARKUP, UNIT, STAX, SNET,
           CASE WHEN KDIV = '5' AND SUBSTR(DIV,1,2) = '39' THEN
             SNet - (CASE WHEN MarkUp IS NULL THEN (5*sNet)/100 ELSE (MarkUp*sNet)/100 END )
           ELSE
             (QUANTITY / (CASE WHEN UNIT = 'KG' THEN 1000 ELSE 1 END) ) * BASEPRICE
           END SHPP,
           CASE WHEN KDIV = '5' AND SUBSTR(DIV,1,2) = '39' THEN
             CASE WHEN MarkUp IS NULL THEN (5 * sNet)/100 ELSE (MarkUp * sNet) / 100 END
           ELSE
             sNet - (QUANTITY / (CASE WHEN UNIT = 'KG' THEN 1000 ELSE 1 END) * BASEPRICE )
           END SMARGIN, prd_ppn
    FROM
    (    SELECT KDIGR, TGLTRANS, KASIR, STAT, /*TRANSNO, SEQNO,*/ PRDCD, KDIV, DIV, QUANTITY, BASEPRICE,
               KDMBR, ADMFEE, FLAGTAX2, NOMINALAMT, PJKO, CEXP, CBKP, COBKP, MARKUP, UNIT, STAX,RECORDID, TIPE,
               CASE WHEN KDIV = '5' AND SUBSTR(DIV,1,2) = '39' THEN
                 NOMINALAMT
               ELSE
                 CASE WHEN ADMFEE <> 0 THEN
                   CASE WHEN KASIR = 'BKL' THEN
                     CASE WHEN pjkO = 'Y' AND cBkp = 'Y' THEN
                       NOMINALAMT
                      ELSE
                       NOMINALAMT - STAX
                     END
                   ELSE
                      NOMINALAMT
                    END
                  ELSE
                       CASE WHEN KASIR = 'BKL' THEN
                     CASE WHEN pjkO = 'Y' AND cBkp = 'Y'THEN
                       NOMINALAMT
                     ELSE
                       NOMINALAMT - STAX
                     END
                   ELSE
                      NOMINALAMT - STAX
                   END
                 END
               END SNET,
               prd_ppn
        FROM
        (    SELECT KDIGR, TGLTRANS, KASIR, STAT, /*TRANSNO, SEQNO,*/ PRDCD, KDIV, DIV, QUANTITY, BASEPRICE, KDMBR, ADMFEE, FLAGTAX2, NOMINALAMT, PJKO, CEXP, CBKP, COBKP,
                   PRD_MARKUPSTANDARD MARKUP, PRD_UNIT UNIT, RECORDID, TIPE,
                   CASE WHEN KDIV = '5' AND SUBSTR(DIV,1,2) = '39' THEN
                     0
                   ELSE
                     CASE WHEN ADMFEE <> 0 THEN
                       CASE WHEN KASIR = 'BKL' THEN
                         CASE WHEN (pjkO = 'Y' AND cBkp = 'Y' ) THEN
                           CASE WHEN cEXP = 'F' THEN CASE WHEN (cBkp = 'Y' AND cObkp = 'Y') THEN (NOMINALAMT * (1+(nvl(prd_ppn,10)/100))) - NOMINALAMT ELSE 0 END ELSE 0 END
                         ELSE
                           CASE WHEN cEXP = 'F' THEN CASE WHEN (cBkp = 'Y' AND cObkp = 'Y') THEN NOMINALAMT - (NOMINALAMT / (1+(nvl(prd_ppn,10)/100))) ELSE 0 END ELSE 0 END
                         END
                        ELSE
                         CASE WHEN cEXP = 'F' THEN CASE WHEN cBkp = 'Y' AND cObkp = 'Y' THEN (NOMINALAMT * (1+(nvl(prd_ppn,10)/100))) - NOMINALAMT ELSE 0 END ELSE 0 END
                       END
                      ELSE
                           CASE WHEN KASIR = 'BKL' THEN
                         CASE WHEN (pjkO = 'Y' AND cBkp = 'Y') THEN
                           CASE WHEN cEXP = 'F' THEN CASE WHEN cBkp = 'Y' AND cObkp = 'Y' THEN (NOMINALAMT * (1+(nvl(prd_ppn,10)/100))) - NOMINALAMT ELSE 0 END ELSE 0 END
                          ELSE
                            CASE WHEN cEXP = 'F' THEN CASE WHEN cBkp = 'Y' AND cObkp = 'Y' THEN (NOMINALAMT - (NOMINALAMT / (1+(nvl(prd_ppn,10)/100)))) ELSE 0 END ELSE 0 END
                          END
                        ELSE
                          CASE WHEN cEXP = 'F' THEN CASE WHEN cBkp = 'Y' AND cObkp = 'Y' THEN (NOMINALAMT - (NOMINALAMT / (1+(nvl(prd_ppn,10)/100)))) ELSE 0 END ELSE 0 END
                        END
                      END
                    END STAX,
                    prd_ppn
            FROM TBMASTER_PRODMAST,
            (    SELECT TRJD_KODEIGR KDIGR, TRJD_TRANSACTIONDATE TGLTRANS, TRJD_CREATE_BY KASIR, TRJD_CASHIERSTATION STAT,/* TRJD_TRANSACTIONNO TRANSNO,
                       TRJD_SEQNO SEQNO,*/ TRJD_PRDCD PRDCD, TRJD_DIVISIONCODE KDIV, TRJD_DIVISION DIV, TRJD_QUANTITY QUANTITY, TRJD_BASEPRICE BASEPRICE,
                       TRJD_NOMINALAMT NOMINALAMT, TRJD_CUS_KODEMEMBER KDMBR, TRJD_ADMFEE ADMFEE, TRJD_FLAGTAX2 FLAGTAX2, TRJD_RECORDID RECORDID, TRJD_TRANSACTIONTYPE TIPE,
                       CASE WHEN cus_kodemember IS NOT NULL THEN CUS_FLAGPKP ELSE 'T' END PJKO,
                       CASE WHEN SUBSTR(TRJD_PRDCD,1,6)||'0' IN (SELECT EXP_PRDCD FROM TBMASTER_BARANGEXPORT) THEN
                          CASE WHEN TRJD_CUS_KODEMEMBER IN (SELECT CUS_KODEMEMBER FROM TBMASTER_CUSTOMER WHERE CUS_JENISMEMBER='E') THEN 'T' END ELSE 'F' END CEXP,
                       CASE WHEN (TRJD_DIVISIONCODE = '5' AND SUBSTR(TRJD_DIVISION,1,2) = '39') THEN 'T' ELSE TRJD_FLAGTAX1 END cBkp,
                       CASE WHEN TRJD_DIVISIONCODE = '5' AND SUBSTR(TRJD_DIVISION,1,2) = '39' THEN ' 'ELSE TRJD_FLAGTAX2 END cObkp
                FROM TBTR_JUALDETAIL, TBMASTER_CUSTOMER
                WHERE trunc( trjd_transactiondate ) BETWEEN TO_DATE('$sDate','DD-MM-YYYY') AND TO_DATE('$eDate', 'DD-MM-YYYY')
                  AND trjd_create_by = '$kasir'
                  AND trjd_cashierstation = '$station'
                  AND trjd_cus_kodemember = cus_kodemember(+)
            )
            WHERE PRDCD = PRD_PRDCD
        )
    )
)
WHERE PRS_KODEIGR = '$kodeigr'
  AND KDIGR = PRS_KODEIGR
  AND KDIV = DIV_KODEDIVISI
  AND SUBSTR(DIV,1,2) = DEP_KODEDEPARTEMENT
  AND SUBSTR(DIV,1,2) = KAT_KODEDEPARTEMENT
  AND SUBSTR(DIV,-2,2) = KAT_KODEKATEGORI
GROUP BY prs_namaperusahaan, prs_namacabang, KASIR, STAT, KDIV, div_namadivisi, SUBSTR(DIV,1,2), dep_namadepartement, SUBSTR(DIV,-2,2), kat_namakategori, FLAGTAX2, CASE WHEN cEXP = 'T' THEN 'Y' ELSE 'N' END
ORDER BY FDKDIV, FDKDEP");
        if (sizeof($datas) == 0) {
            return "**DATA TIDAK ADA**";
        }

        //CALCULATE GRAND TOTAL
        $arrayIndex = ['c', 'p', 'x', 'b', 'e', 'g', 'r', 'h', 'total-40', 'total', 'f', 'd']; //tersusun, f merupakan departemen 40, hanya dipakai untuk mendapatkan total-40, tidak untuk ditampilkan
        //sedangkan d, ga tau kenapa muncul padahal ga dipakai di laporan, jadi tidak ditampilkan juga

        foreach ($arrayIndex as $index) {
            $gross[$index] = 0;
            $tax[$index] = 0;
            $net[$index] = 0;
            $hpp[$index] = 0;
            $margin[$index] = 0;
            $margp[$index] = 0;
        }
        $rec = DB::connection(Session::get('connection'))->select("SELECT prs_namaperusahaan, prs_namacabang, KASIR, STAT,
       KDIV fdkdiv, div_namadivisi, SUBSTR(DIV,1,2) FDKDEP, dep_namadepartement, SUBSTR(DIV,-2,2) FDKATB, kat_namakategori, FLAGTAX2 Fdfbkp,
       CASE WHEN cEXP = 'T' THEN 'Y' ELSE 'N' END fexpor,
       SUM ( CASE WHEN recordid IS NULL AND tipe = 'S' THEN
                     CASE WHEN admfee > 0 THEN
                 CASE WHEN cBkp = 'Y' AND cObkp = 'Y' THEN
                   fdnamt * (1+(nvl(prd_ppn,10)/100)) ELSE fdnamt
                 END
               ELSE fdnamt
               END
             ELSE
               CASE WHEN recordid IS NULL AND tipe = 'R' THEN
                       CASE WHEN admfee > 0 THEN
                   CASE WHEN cBkp = 'Y' AND cObkp = 'Y' THEN
                     fdnamt * (1+(nvl(prd_ppn,10)/100)) * (0-1) ELSE fdnamt * (0-1)
                   END
                 ELSE fdnamt * (0-1)
                 END
               END
             END
           ) fdnAmt,
       SUM ( CASE WHEN recordid IS NULL AND tipe = 'S' THEN sTax
                   ELSE CASE WHEN recordid IS NULL AND tipe = 'R' THEN sTax*(0-1) END
             END
           ) fdnTax,
       SUM ( CASE WHEN recordid IS NULL AND tipe = 'S' THEN sNet
                   ELSE CASE WHEN recordid IS NULL AND tipe = 'R' THEN sNet*(0-1) END
             END
           ) fdnNet,
       SUM ( CASE WHEN recordid IS NULL AND tipe = 'S' THEN sMargin
                   ELSE CASE WHEN recordid IS NULL AND tipe = 'R' THEN sMargin*(0-1) END
             END
           ) fdnMrgn,
       SUM ( CASE WHEN recordid IS NULL AND tipe = 'S' THEN sHpp
                   ELSE CASE WHEN recordid IS NULL AND tipe = 'R' THEN sHpp*(0-1) END
             END
           ) fdnHpp
FROM TBMASTER_PERUSAHAAN, TBMASTER_DIVISI, TBMASTER_DEPARTEMENT, TBMASTER_KATEGORI,
(    SELECT KDIGR, TGLTRANS, KASIR, STAT, PRDCD, KDIV, DIV, QUANTITY, BASEPRICE, KDMBR, ADMFEE, FLAGTAX2 ,NOMINALAMT FDNAMT, RECORDID, TIPE, PJKO, CEXP, CBKP, COBKP, MARKUP, UNIT, STAX, SNET,
           CASE WHEN KDIV = '5' AND SUBSTR(DIV,1,2) = '39' THEN
             SNet - (CASE WHEN MarkUp IS NULL THEN (5*sNet)/100 ELSE (MarkUp*sNet)/100 END )
           ELSE
             (QUANTITY / (CASE WHEN UNIT = 'KG' THEN 1000 ELSE 1 END) ) * BASEPRICE
           END SHPP,
           CASE WHEN KDIV = '5' AND SUBSTR(DIV,1,2) = '39' THEN
             CASE WHEN MarkUp IS NULL THEN (5 * sNet)/100 ELSE (MarkUp * sNet) / 100 END
           ELSE
             sNet - (QUANTITY / (CASE WHEN UNIT = 'KG' THEN 1000 ELSE 1 END) * BASEPRICE )
           END SMARGIN,
           prd_ppn
    FROM
    (    SELECT KDIGR, TGLTRANS, KASIR, STAT, /*TRANSNO, SEQNO,*/ PRDCD, KDIV, DIV, QUANTITY, BASEPRICE,
               KDMBR, ADMFEE, FLAGTAX2, NOMINALAMT, PJKO, CEXP, CBKP, COBKP, MARKUP, UNIT, STAX,RECORDID, TIPE,
               CASE WHEN KDIV = '5' AND SUBSTR(DIV,1,2) = '39' THEN
                 NOMINALAMT
               ELSE
                 CASE WHEN ADMFEE <> 0 THEN
                   CASE WHEN KASIR = 'BKL' THEN
                     CASE WHEN pjkO = 'Y' AND cBkp = 'Y' THEN
                       NOMINALAMT
                      ELSE
                       NOMINALAMT - STAX
                     END
                   ELSE
                      NOMINALAMT
                    END
                  ELSE
                       CASE WHEN KASIR = 'BKL' THEN
                     CASE WHEN pjkO = 'Y' AND cBkp = 'Y'THEN
                       NOMINALAMT
                     ELSE
                       NOMINALAMT - STAX
                     END
                   ELSE
                      NOMINALAMT - STAX
                   END
                 END
               END SNET,
               prd_ppn
        FROM
        (    SELECT KDIGR, TGLTRANS, KASIR, STAT, /*TRANSNO, SEQNO,*/ PRDCD, KDIV, DIV, QUANTITY, BASEPRICE, KDMBR, ADMFEE, FLAGTAX2, NOMINALAMT, PJKO, CEXP, CBKP, COBKP,
                   PRD_MARKUPSTANDARD MARKUP, PRD_UNIT UNIT, RECORDID, TIPE,
                   CASE WHEN KDIV = '5' AND SUBSTR(DIV,1,2) = '39' THEN
                     0
                   ELSE
                     CASE WHEN ADMFEE <> 0 THEN
                       CASE WHEN KASIR = 'BKL' THEN
                         CASE WHEN (pjkO = 'Y' AND cBkp = 'Y' ) THEN
                           CASE WHEN cEXP = 'F' THEN CASE WHEN (cBkp = 'Y' AND cObkp = 'Y') THEN (NOMINALAMT * (1+(nvl(prd_ppn,10)/100))) - NOMINALAMT ELSE 0 END ELSE 0 END
                         ELSE
                           CASE WHEN cEXP = 'F' THEN CASE WHEN (cBkp = 'Y' AND cObkp = 'Y') THEN NOMINALAMT - (NOMINALAMT / (1+(nvl(prd_ppn,10)/100))) ELSE 0 END ELSE 0 END
                         END
                        ELSE
                         CASE WHEN cEXP = 'F' THEN CASE WHEN cBkp = 'Y' AND cObkp = 'Y' THEN (NOMINALAMT * (1+(nvl(prd_ppn,10)/100))) - NOMINALAMT ELSE 0 END ELSE 0 END
                       END
                      ELSE
                           CASE WHEN KASIR = 'BKL' THEN
                         CASE WHEN (pjkO = 'Y' AND cBkp = 'Y') THEN
                           CASE WHEN cEXP = 'F' THEN CASE WHEN cBkp = 'Y' AND cObkp = 'Y' THEN (NOMINALAMT * (1+(nvl(prd_ppn,10)/100))) - NOMINALAMT ELSE 0 END ELSE 0 END
                          ELSE
                            CASE WHEN cEXP = 'F' THEN CASE WHEN cBkp = 'Y' AND cObkp = 'Y' THEN (NOMINALAMT - (NOMINALAMT / (1+(nvl(prd_ppn,10)/100)))) ELSE 0 END ELSE 0 END
                          END
                        ELSE
                          CASE WHEN cEXP = 'F' THEN CASE WHEN cBkp = 'Y' AND cObkp = 'Y' THEN (NOMINALAMT - (NOMINALAMT / (1+(nvl(prd_ppn,10)/100)))) ELSE 0 END ELSE 0 END
                        END
                      END
                    END STAX,
                    prd_ppn
            FROM TBMASTER_PRODMAST,
            (    SELECT TRJD_KODEIGR KDIGR, TRJD_TRANSACTIONDATE TGLTRANS, TRJD_CREATE_BY KASIR, TRJD_CASHIERSTATION STAT,/* TRJD_TRANSACTIONNO TRANSNO,
                       TRJD_SEQNO SEQNO,*/ TRJD_PRDCD PRDCD, TRJD_DIVISIONCODE KDIV, TRJD_DIVISION DIV, TRJD_QUANTITY QUANTITY, TRJD_BASEPRICE BASEPRICE,
                       TRJD_NOMINALAMT NOMINALAMT, TRJD_CUS_KODEMEMBER KDMBR, TRJD_ADMFEE ADMFEE, TRJD_FLAGTAX2 FLAGTAX2, TRJD_RECORDID RECORDID, TRJD_TRANSACTIONTYPE TIPE,
                       CASE WHEN cus_kodemember IS NOT NULL THEN CUS_FLAGPKP ELSE 'T' END PJKO,
                       CASE WHEN SUBSTR(TRJD_PRDCD,1,6)||'0' IN (SELECT EXP_PRDCD FROM TBMASTER_BARANGEXPORT) THEN
                          CASE WHEN TRJD_CUS_KODEMEMBER IN (SELECT CUS_KODEMEMBER FROM TBMASTER_CUSTOMER WHERE CUS_JENISMEMBER='E') THEN 'T' END ELSE 'F' END CEXP,
                       CASE WHEN (TRJD_DIVISIONCODE = '5' AND SUBSTR(TRJD_DIVISION,1,2) = '39') THEN 'T' ELSE TRJD_FLAGTAX1 END cBkp,
                       CASE WHEN TRJD_DIVISIONCODE = '5' AND SUBSTR(TRJD_DIVISION,1,2) = '39' THEN ' 'ELSE TRJD_FLAGTAX2 END cObkp
                FROM TBTR_JUALDETAIL, TBMASTER_CUSTOMER
                WHERE trunc( trjd_transactiondate ) BETWEEN TO_DATE('$sDate','DD-MM-YYYY') AND TO_DATE('$eDate', 'DD-MM-YYYY')
                  AND trjd_create_by = '$kasir'
                  AND trjd_cashierstation = '$station'
                  AND trjd_cus_kodemember = cus_kodemember(+)
            )
            WHERE PRDCD = PRD_PRDCD
        )
    )
)
WHERE PRS_KODEIGR = '$kodeigr'
  AND KDIGR = PRS_KODEIGR
  AND KDIV = DIV_KODEDIVISI
  AND SUBSTR(DIV,1,2) = DEP_KODEDEPARTEMENT
  AND SUBSTR(DIV,1,2) = KAT_KODEDEPARTEMENT
  AND SUBSTR(DIV,-2,2) = KAT_KODEKATEGORI
GROUP BY prs_namaperusahaan, prs_namacabang, KASIR, STAT, KDIV, div_namadivisi, SUBSTR(DIV,1,2), dep_namadepartement, SUBSTR(DIV,-2,2), kat_namakategori, FLAGTAX2, CASE WHEN cEXP = 'T' THEN 'Y' ELSE 'N' END
ORDER BY FDKDIV, FDKDEP");

        for ($i = 0; $i < sizeof($rec); $i++) {
            if ($rec[$i]->fdkdiv && ($rec[$i]->fdkdep != '39' && $rec[$i]->fdkdep != '40' && $rec[$i]->fdkdep != '43')) {
                if ($rec[$i]->fdntax != 0) {
                    $gross['p'] = $gross['p'] + $rec[$i]->fdnamt;
                    $tax['p'] = $tax['p'] + $rec[$i]->fdntax;
                    $net['p'] = $net['p'] + $rec[$i]->fdnnet;
                    $hpp['p'] = $hpp['p'] + $rec[$i]->fdnhpp;
                    $margin['p'] = $margin['p'] + $rec[$i]->fdnmrgn;
                } else {
                    if ($rec[$i]->fdfbkp == 'P') {
                        $gross['b'] = $gross['b'] + $rec[$i]->fdnamt;
                        $tax['b'] = $tax['b'] + $rec[$i]->fdntax;
                        $net['b'] = $net['b'] + $rec[$i]->fdnnet;
                        $hpp['b'] = $hpp['b'] + $rec[$i]->fdnhpp;
                        $margin['b'] = $margin['b'] + $rec[$i]->fdnmrgn;
                    } elseif ($rec[$i]->fdfbkp == 'C') {
                        $gross['d'] = $gross['d'] + $rec[$i]->fdnamt;
                        $tax['d'] = $tax['d'] + $rec[$i]->fdntax;
                        $net['d'] = $net['d'] + $rec[$i]->fdnnet;
                        $hpp['d'] = $hpp['d'] + $rec[$i]->fdnhpp;
                        $margin['d'] = $margin['d'] + $rec[$i]->fdnmrgn;
                    } elseif ($rec[$i]->fdfbkp == 'G') {
                        $gross['g'] = $gross['g'] + $rec[$i]->fdnamt;
                        $tax['g'] = $tax['g'] + $rec[$i]->fdntax;
                        $net['g'] = $net['g'] + $rec[$i]->fdnnet;
                        $hpp['g'] = $hpp['g'] + $rec[$i]->fdnhpp;
                        $margin['g'] = $margin['g'] + $rec[$i]->fdnmrgn;
                    } elseif ($rec[$i]->fdfbkp == 'W') {
                        $gross['r'] = $gross['r'] + $rec[$i]->fdnamt;
                        $tax['r'] = $tax['r'] + $rec[$i]->fdntax;
                        $net['r'] = $net['r'] + $rec[$i]->fdnnet;
                        $hpp['r'] = $hpp['r'] + $rec[$i]->fdnhpp;
                        $margin['r'] = $margin['r'] + $rec[$i]->fdnmrgn;
                    } else {
                        if ($rec[$i]->fexpor == 'Y') {
                            $gross['e'] = $gross['e'] + $rec[$i]->fdnamt;
                            $tax['e'] = $tax['e'] + $rec[$i]->fdntax;
                            $net['e'] = $net['e'] + $rec[$i]->fdnnet;
                            $hpp['e'] = $hpp['e'] + $rec[$i]->fdnhpp;
                            $margin['e'] = $margin['e'] + $rec[$i]->fdnmrgn;
                        } else {
                            $gross['x'] = $gross['x'] + $rec[$i]->fdnamt;
                            $tax['x'] = $tax['x'] + $rec[$i]->fdntax;
                            $net['x'] = $net['x'] + $rec[$i]->fdnnet;
                            $hpp['x'] = $hpp['x'] + $rec[$i]->fdnhpp;
                            $margin['x'] = $margin['x'] + $rec[$i]->fdnmrgn;
                        }
                    }
                }
            } elseif ($rec[$i]->fdkdiv == '5' && $rec[$i]->fdkdiv == '39') {
                $gross['c'] = $gross['c'] + $rec[$i]->fdnamt;
                $tax['c'] = $tax['c'] + $rec[$i]->fdntax;
                $net['c'] = $net['c'] + $rec[$i]->fdnnet;
                $hpp['c'] = $hpp['c'] + $rec[$i]->fdnhpp;
                $margin['c'] = $margin['c'] + $rec[$i]->fdnmrgn;
            } elseif ($rec[$i]->fdkdiv == '5' && $rec[$i]->fdkdiv == '40') {
                $gross['f'] = $gross['f'] + $rec[$i]->fdnamt;
                $tax['f'] = $tax['f'] + $rec[$i]->fdntax;
                $net['f'] = $net['f'] + $rec[$i]->fdnnet;
                $hpp['f'] = $hpp['f'] + $rec[$i]->fdnhpp;
                $margin['f'] = $margin['f'] + $rec[$i]->fdnmrgn;
            } elseif ($rec[$i]->fdkdiv == '5' && $rec[$i]->fdkdiv == '43') {
                $gross['h'] = $gross['h'] + $rec[$i]->fdnamt;
                $tax['h'] = $tax['h'] + $rec[$i]->fdntax;
                $net['h'] = $net['h'] + $rec[$i]->fdnnet;
                $hpp['h'] = $hpp['h'] + $rec[$i]->fdnhpp;
                $margin['h'] = $margin['h'] + $rec[$i]->fdnmrgn;
            }
        }
        for ($i = 0; $i < sizeof($datas); $i++) {
            $gross['total'] = $gross['total'] + $datas[$i]->fdnamt;
            $tax['total'] = $tax['total'] + $datas[$i]->fdntax;
            $net['total'] = $net['total'] + $datas[$i]->fdnnet;
            $hpp['total'] = $hpp['total'] + $datas[$i]->fdnhpp;
            $margin['total'] = $margin['total'] + $datas[$i]->fdnmrgn;
        }
        $gross['total-40'] = $gross['total'] - $gross['f'];
        $tax['total-40'] = $tax['total'] - $tax['f'];
        $net['total-40'] = $net['total'] - $net['f'];
        $hpp['total-40'] = $hpp['total'] - $hpp['f'];
        $margin['total-40'] = $margin['total'] - $margin['f'];


        foreach ($arrayIndex as $index) {
            if ($net[$index] != 0) {
                $margp[$index] = $margin[$index] * 100 / $net[$index];
            } else {
                if ($margin[$index] != 0) {
                    $margp[$index] = 100;
                } else {
                    $margp[$index] = 0;
                }
            }
        }

        $nmarginp = [];
        for ($i = 0; $i < sizeof($datas); $i++) {
            if ($datas[$i]->fdnnet != 0) {
                $nmarginp[$i] = ($datas[$i]->fdnmrgn) * 100 / ($datas[$i]->fdnnet);
            } else {
                if (($datas[$i]->fdnmrgn) != 0) {
                    $nmarginp[$i] = 100;
                } else {
                    $nmarginp[$i] = 0;
                }
            }
        }

        //PRINT
        $perusahaan = DB::connection(Session::get('connection'))->table("tbmaster_perusahaan")->first();
//        $today = date('d-m-Y');
//        $time = date('H:i:s');
        $pdf = PDF::loadview('FRONTOFFICE.LAPORANKASIR.LAPORANPENJUALAN.lap_jual_perkasir-pdf',
            ['kodeigr' => $kodeigr, 'date1' => $dateA, 'date2' => $dateB, 'data' => $datas, 'nmarginp' => $nmarginp, 'kasir' => $kasir, 'station' => $station, 'perusahaan' => $perusahaan,
                'periode' => $periode, 'arrayIndex' => $arrayIndex, 'gross' => $gross, 'tax' => $tax, 'net' => $net, 'hpp' => $hpp, 'margin' => $margin, 'margp' => $margp]);
        $pdf->setPaper('A4', 'potrait');
        $pdf->output();
        $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);

        $canvas = $dompdf->get_canvas();
        $canvas->page_text(511, 78, "{PAGE_NUM} / {PAGE_COUNT}", null, 7, array(0, 0, 0));

        return $pdf->stream('lap_jual_perkasir.pdf');
    }

    public function printDocumentMenu6(Request $request)
    {
        $kodeigr = Session::get('kdigr');
        $dateA = $request->date1;
        $dateB = $request->date2;
        $sDate = DateTime::createFromFormat('d-m-Y', $dateA)->format('d-m-Y');
        $eDate = DateTime::createFromFormat('d-m-Y', $dateB)->format('d-m-Y');
        $nlist = $request->cetak;
        $keterangan = '';
        if ($dateA != $dateB) {
            $periode = 'PERIODE : ' . $dateA . ' s/d ' . $dateB;
        } else {
            $periode = 'TANGGAL : ' . $dateA;
        }

        if ($nlist == 1) {
            $keterangan = 'INDOGROSIR ALL  [ IGR + (OMI/IDM) ]';
        } else if ($nlist == 2) {
            $keterangan = 'INDOGROSIR ONLY [ TANPA (OMI/IDM) ]';
        } else if ($nlist == 3) {
            $keterangan = 'OMI/IDM ONLY';
        }
        $data = DB::connection(Session::get('connection'))
            ->select("select  prs_namaperusahaan, prs_namacabang, trim(lph_kodedivisi) cdiv, div_namadivisi,
                        trim(lph_kodedepartement) cdept, dep_namadepartement, lph_flagbkp fdfbkp, lph_prdcd prdcd,
                         case when '" . $nlist . "' = '1' then lph_gross_igr+lph_gross_omi+lph_gross_idm
                              when '" . $nlist . "' = '2' then lph_gross_igr
                              when '" . $nlist . "' = '3' then lph_gross_omi+lph_gross_idm
                         end nGross,
                         case when '" . $nlist . "' = '1' then lph_csb_igr+lph_csb_omi+lph_csb_idm
                              when '" . $nlist . "' = '2' then lph_csb_igr
                              when '" . $nlist . "' = '3' then lph_csb_omi+lph_csb_idm
                         end nCsb,
                         case when '" . $nlist . "' = '1' then lph_net_igr+lph_net_omi+lph_net_idm
                              when '" . $nlist . "' = '2' then lph_net_igr
                              when '" . $nlist . "' = '3' then lph_net_omi+lph_net_idm
                         end nNet,
                         case when '" . $nlist . "' = '1' then lph_tax_igr+lph_tax_omi+lph_tax_idm
                              when '" . $nlist . "' = '2' then lph_tax_igr
                              when '" . $nlist . "' = '3' then lph_tax_omi+lph_tax_idm
                         end nTax
                        from tbtr_lpt_hdr, TBMASTER_PERUSAHAAN, TBMASTER_DIVISI, TBMASTER_DEPARTEMENT
                        where lph_periode BETWEEN TO_DATE('" . $sDate . "','dd-mm-yyyy') AND TO_DATE('" . $eDate . "','dd-mm-yyyy')
                        and lph_kodeigr = prs_kodeigr
                        and prs_kodeigr = '" . Session::get('kdigr') . "'
                        and trim(lph_kodedivisi)=div_kodedivisi
                        and trim(lph_kodedepartement)=dep_kodedepartement
                        order by  cdiv,cdept");

        $cp_nkgross = 0;
        $cp_nktax = 0;
        $cp_nknet = 0;
        $cp_nkcsb = 0;
        $cp_npgross = 0;
        $cp_nptax = 0;
        $cp_npnet = 0;
        $cp_npcsb = 0;
        $cp_nbgross = 0;
        $cp_nbtax = 0;
        $cp_nbnet = 0;
        $cp_nbcsb = 0;
        $cp_ncgross = 0;
        $cp_nctax = 0;
        $cp_ncnet = 0;
        $cp_nccsb = 0;
        $cp_nggross = 0;
        $cp_ngtax = 0;
        $cp_ngnet = 0;
        $cp_ngcsb = 0;
        $cp_nrgross = 0;
        $cp_nrtax = 0;
        $cp_nrnet = 0;
        $cp_nrcsb = 0;
        $cp_nxgross = 0;
        $cp_nxtax = 0;
        $cp_nxnet = 0;
        $cp_nxcsb = 0;
        $cp_negross = 0;
        $cp_netax = 0;
        $cp_nenet = 0;
        $cp_necsb = 0;
        $cp_ndgross = 0;
        $cp_ndtax = 0;
        $cp_ndnet = 0;
        $cp_ndcsb = 0;
        $cp_nfgross = 0;
        $cp_nftax = 0;
        $cp_nfnet = 0;
        $cp_nfcsb = 0;
        for ($i = 0; $i < sizeof($data); $i++) {


            if ($data[$i]->cdiv <> '5' && !in_array($data[$i]->cdept, ['39', '40', '43'])) {

                if ($data[$i]->fdfbkp == 'Y') {

                    $cp_npgross += $data[$i]->ngross;
                    $cp_npcsb += $data[$i]->ncsb;
                    $cp_npnet += $data[$i]->nnet;
                    $cp_nptax += $data[$i]->ntax;
                } else {
                    switch ($data[$i]->fdfbkp) {
                        case 'C':
                            $cp_nkgross += $data[$i]->ngross;
                            $cp_nkcsb += $data[$i]->ncsb;
                            $cp_nknet += $data[$i]->nnet;
                            $cp_nktax += $data[$i]->ntax;
                            break;
                        case 'P':
                            $cp_nbgross += $data[$i]->ngross;
                            $cp_nbcsb += $data[$i]->ncsb;
                            $cp_nbnet += $data[$i]->nnet;
                            $cp_nbtax += $data[$i]->ntax;
                            break;
                        case 'G':
                            $cp_nggross += $data[$i]->ngross;
                            $cp_ngcsb += $data[$i]->ncsb;
                            $cp_ngnet += $data[$i]->nnet;
                            $cp_ngtax += $data[$i]->ntax;
                            break;
                        case 'W':
                            $cp_nrgross += $data[$i]->ngross;
                            $cp_nrcsb += $data[$i]->ncsb;
                            $cp_nrnet += $data[$i]->nnet;
                            $cp_nrtax += $data[$i]->ntax;
                            break;
                        default:
                            $cp_nxgross += $data[$i]->ngross;
                            $cp_nxcsb += $data[$i]->ncsb;
                            $cp_nxnet += $data[$i]->nnet;
                            $cp_nxtax += $data[$i]->ntax;

                            $cp_negross += 0;
                            $cp_netax += 0;
                            $cp_nenet += 0;
                            $cp_necsb += 0;
                            break;

                    }
                }
            } else if ($data[$i]->cdiv == '5' and $data[$i]->cdept == '39') {
                $cp_ncgross += $data[$i]->ngross;
                $cp_nccsb += $data[$i]->ncsb;
                $cp_ncnet += $data[$i]->nnet;
                $cp_nctax += $data[$i]->ntax;
            } else if ($data[$i]->cdiv == '5' and $data[$i]->cdept == '40') {
                $cp_ndgross += $data[$i]->ngross;
                $cp_ndcsb += $data[$i]->ncsb;
                $cp_ndnet += $data[$i]->nnet;
                $cp_ndtax += $data[$i]->ntax;
            } else if ($data[$i]->cdiv == '5' and $data[$i]->cdept == '43') {
                $cp_nfgross += $data[$i]->ngross;
                $cp_nfcsb += $data[$i]->ncsb;
                $cp_nfnet += $data[$i]->nnet;
                $cp_nftax += $data[$i]->ntax;
            };
        }
        //PRINT
        $perusahaan = DB::connection(Session::get('connection'))->table("tbmaster_perusahaan")->first();
        return view('FRONTOFFICE.LAPORANKASIR.LAPORANPENJUALAN.lap_jual_perdept_cb-pdf', compact(['perusahaan', 'data', 'periode','keterangan',
            'cp_nkgross','cp_nktax','cp_nknet','cp_nkcsb','cp_npgross','cp_nptax','cp_npnet','cp_npcsb','cp_nbgross','cp_nbtax','cp_nbnet','cp_nbcsb','cp_ncgross','cp_nctax','cp_ncnet','cp_nccsb','cp_nggross','cp_ngtax','cp_ngnet','cp_ngcsb','cp_nrgross','cp_nrtax',
            'cp_nrnet','cp_nrcsb','cp_nxgross','cp_nxtax','cp_nxnet','cp_nxcsb','cp_negross','cp_netax','cp_nenet','cp_necsb','cp_ndgross','cp_ndtax','cp_ndnet','cp_ndcsb','cp_nfgross','cp_nftax','cp_nfnet','cp_nfcsb']));

    }

}
