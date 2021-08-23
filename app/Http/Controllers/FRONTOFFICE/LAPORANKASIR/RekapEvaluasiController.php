<?php

namespace App\Http\Controllers\FRONTOFFICE\LAPORANKASIR;

use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;
use PDF;
use Symfony\Component\VarDumper\Cloner\Data;
use Yajra\DataTables\DataTables;
use ZipArchive;
use File;

class RekapEvaluasiController extends Controller
{
    public function index(){
        $monitoring = DB::table('tbtr_monitoringmember')
            ->select('mem_kodemonitoring','mem_namamonitoring')
            ->where('mem_kodeigr','=',$_SESSION['kdigr'])
            ->orderBy('mem_kodemonitoring')
            ->distinct()
            ->get();

        return view('FRONTOFFICE.LAPORANKASIR.rekap-evaluasi')->with(compact(['monitoring']));
    }

    public function getLovLangganan(Request $request){
        $where = "(cus_kodemember like '%".$request->search."%' OR cus_namamember like '%".$request->search."%')";

        $data = DB::table('tbmaster_customer')
            ->select('cus_kodemember','cus_namamember')
            ->whereRaw("(cus_recordid IS NULL OR cus_recordid <> 1)")
            ->whereRaw($where)
            ->orderBy('cus_kodemember','asc')
            ->limit($request->search == '' ? 100 : 0)
            ->get();

        return DataTables::of($data)->make(true);
    }

    public function checkLangganan(Request $request){
        $data = DB::table('tbmaster_customer')
            ->where('cus_kodemember','=',$request->value)
            ->whereRaw("(cus_recordid IS NULL OR cus_recordid <> 1)")
            ->first();

        return $data ? 'valid' : 'invalid';
    }

    public function getLovOutlet(){
        $data = DB::table('tbmaster_outlet')
            ->select('out_kodeoutlet','out_namaoutlet')
            ->where('out_kodeigr','=',$_SESSION['kdigr'])
            ->orderBy('out_kodeoutlet')
            ->get();

        return DataTables::of($data)->make(true);
    }

    public function checkOutlet(Request $request){
        $data = DB::table('tbmaster_outlet')
            ->where('out_kodeoutlet','=',$request->value)
            ->where('out_kodeigr','=',$_SESSION['kdigr'])
            ->first();

        return $data ? 'valid' : 'invalid';
    }

    public function getLovSubOutlet(){
        $data = DB::table('tbmaster_suboutlet')
            ->select('sub_kodeoutlet','sub_kodesuboutlet','sub_namasuboutlet')
            ->where('sub_kodeigr','=',$_SESSION['kdigr'])
            ->orderBy('sub_kodesuboutlet')
            ->get();

        return DataTables::of($data)->make(true);
    }

    public function checkSubOutlet(Request $request){
        $data = DB::table('tbmaster_suboutlet')
            ->where('sub_kodesuboutlet','=',$request->value)
            ->where('sub_kodeigr','=',$_SESSION['kdigr'])
            ->first();

        return $data ? 'valid' : 'invalid';
    }

    public function getLovMonitoring(){
        $data = DB::table('tbtr_monitoringmember')
            ->select('mem_kodemonitoring','mem_namamonitoring')
            ->where('mem_kodeigr','=',$_SESSION['kdigr'])
            ->orderBy('mem_kodemonitoring')
            ->distinct()
            ->get();

        return DataTables::of($data)->make(true);
    }

    public function printDetail(Request $request){
        $tgl1 = $request->tgl1;
        $tgl2 = $request->tgl2;

        if($request->member1 != '' && $request->member2 != '')
            $where_member = "AND trjd_cus_kodemember BETWEEN '".$request->member1."' AND '".$request->member2."'";
        else if($request->member1 != '')
            $where_member = "AND trjd_cus_kodemember >= '".$request->member1."'";
        else if($request->member2 != '')
            $where_member = "AND trjd_cus_kodemember <= '".$request->member2."'";
        else $where_member = " and 1=1";

        if($request->outlet1 != '' && $request->outlet2 != '')
            $where_outlet = "AND (cus_kodeoutlet BETWEEN '".$request->outlet1."' AND '".$request->outlet2."' OR cus_kodeoutlet IS NULL)";
        else if($request->outlet1 != '')
            $where_outlet = "AND (cus_kodeoutlet >= '".$request->outlet1."' OR cus_kodeoutlet IS NULL)";
        else if($request->outlet2 != '')
            $where_outlet = "AND (cus_kodeoutlet <= '".$request->outlet2."' OR cus_kodeoutlet IS NULL)";
        else $where_outlet = " and 1=1";

        if($request->suboutlet1 != '' && $request->suboutlet2 != '')
            $where_suboutlet = " and subnumb between '".$request->suboutlet1."' and '".$request->suboutlet2."'";
        else if($request->suboutlet1 != '')
            $where_suboutlet = " and subnumb >= '".$request->suboutlet1."'";
        else if($request->suboutlet2 != '')
            $where_suboutlet = " and subnumb <= '".$request->suboutlet2."'";
        else $where_suboutlet = " and 1=1";

        if($request->jenis_customer == 'MERAH')
            $where_jenis_cus = " AND cus_flagmemberkhusus = 'Y'";
        else if($request->jenis_customer == 'BIRU')
            $where_jenis_cus = " AND cus_flagmemberkhusus <> 'Y'";
        else if($request->jenis_customer == 'ALL')
            $where_jenis_cus = " AND 1=1";
        else $where_jenis_cus = " AND cus_jenismember = '".$request->jenis_customer."'";

        if($request->monitoring == 'ALL')
            $where_monitoring = 'AND 1=1';
        else $where_monitoring = " AND exists (SELECT 1 FROM TBTR_MONITORINGMEMBER WHERE mem_kodemonitoring = '".$request->monitoring."' and trjd_cus_kodemember = mem_kodemember)";

        if($request->sort == '1')
            $order = ' order by fcusno';
        else $order = ' order by fwamt desc';

        $perusahaan = DB::table('tbmaster_perusahaan')
            ->first();

        $data = DB::select("SELECT out_namaoutlet, sub_namasuboutlet, cus_namamember fNama, subnumb,
		   cus_kodeoutlet AS fOutlt, upper(cus_kodesuboutlet) AS fsoutl, cusNo AS fCusNo, wFreq AS fwFreq, fwSlip, fbmemb, fwProd, wAmt AS fwAmt,lCost AS flCost, (wamt-lcost) AS fGrsMargn
	FROM TBMASTER_OUTLET, (SELECT sub_kodesuboutlet, rownum subnumb,  sub_namasuboutlet FROM TBMASTER_SUBOUTLET WHERE sub_kodeigr = '".$_SESSION['kdigr']."'),
	(	SELECT cusnoA no_cusno, COUNT(TRJD_TRANSACTIONNO) fwSlip, CASE WHEN COUNT(TRJD_TRANSACTIONNO) = 1 THEN 1 ELSE 0 END fbmemb
        FROM
        (	SELECT DISTINCT TRUNC(trjd_transactiondate) trjd_transactiondate, NVL(trjd_cus_kodemember,'0') cusnoA,
        		   TRJD_TRANSACTIONNO, TRJD_CREATE_BY
        	FROM TBTR_JUALDETAIL
        	WHERE TRUNC(trjd_transactiondate) BETWEEN to_date('".$tgl1."','dd/mm/yyyy') AND to_date('".$tgl2."','dd/mm/yyyy')
        	  AND trjd_recordid IS NULL
        )
		GROUP BY cusnoA
	),
	( 	SELECT cusnoA pr_cusno, COUNT(prdcd) fwProd
		FROM
		(	SELECT DISTINCT NVL(trjd_cus_kodemember,'0') cusnoA, (SUBSTR(trjd_prdcd,1,6)) prdcd
			FROM TBTR_JUALDETAIL
			WHERE TRUNC(trjd_transactiondate) BETWEEN to_date('".$tgl1."','dd/mm/yyyy') AND to_date('".$tgl2."','dd/mm/yyyy')
			  AND trjd_recordid IS NULL
		)
		GROUP BY cusnoA
	),
	(	SELECT kodeigr, cusNo, cus_namamember, SUM(fdnamt) wAmt, SUM(flcost) lcost, COUNT(fdtglt) wFreq, cus_kodeoutlet, cus_kodesuboutlet
		FROM
		(	SELECT kodeigr, cusnoA AS cusNo, cus_namamember, trjd_transactiondate AS fdtglt, cus_kodeoutlet, cus_kodesuboutlet,
				   SUM(CASE WHEN trjd_transactiontype ='R' THEN (nNet*-1) ELSE nNet END) fdnAmt,
				   SUM(CASE WHEN trjd_transactiontype ='R' THEN (nHpp*-1) ELSE nHpp END) flCost
			FROM
			(	SELECT trjd_kodeigr kodeigr, TRUNC(trjd_transactiondate) trjd_transactiondate, NVL(trjd_cus_kodemember,'0') cusnoA, trjd_transactiontype,
					   cus_kodeoutlet, cus_kodesuboutlet, cus_namamember,
					   CASE WHEN trjd_divisioncode = '5' AND SUBSTR(trjd_division,1, 2) = '39' THEN
					      CASE WHEN upper('".$request->counter."') = 'Y' THEN
						     trjd_nominalAmt
						  END
					   ELSE
					      CASE WHEN NVL(tko_kodesbu,'z') IN ('O','I') THEN
						     CASE WHEN tko_tipeOMI IN ('HE','HG') THEN
							    trjd_nominalAmt - ( CASE WHEN trjd_flagTax1 = 'Y' AND NVL(trjd_flagTax2,'z') IN ('Y','z') AND NVL(prd_kodetag,'zz') <> 'Q' THEN ( trjd_nominalAmt - (trjd_nominalAmt / 1.1) ) ELSE 0 END )
							 ELSE
							    trjd_nominalAmt
							 END
						  ELSE
						     trjd_nominalAmt - (CASE WHEN SUBSTR(trjd_create_By,1,2) = 'EX' THEN 0 ELSE CASE WHEN trjd_flagTax1 = 'Y' AND NVL(trjd_flagTax2,'z') IN ('Y','z') AND NVL(PRD_kodeTAG,'zz') <> 'Q' THEN ( trjd_nominalAmt - (trjd_nominalAmt / 1.1) ) ELSE 0 END END )
						  END
					   END nNet,
					   ------
					   CASE WHEN trjd_divisioncode = '5' AND SUBSTR(trjd_division,1,2) = '39' THEN
					      CASE WHEN upper('".$request->counter."') = 'Y' THEN
						     trjd_nominalAmt - ( CASE WHEN  PRD_markUpStandard IS NULL THEN (5 * trjd_nominalAmt) / 100 ELSE (prd_MarkUpStandard * trjd_nominalAmt) / 100 END )
						  END
					   ELSE
					      (trjd_quantity/ ( CASE WHEN prd_unit = 'KG' THEN 1000 ELSE 1 END)) * trjd_basePrice
					   END nHpp
						------
				FROM TBTR_JUALDETAIL, TBMASTER_CUSTOMER, TBMASTER_PRODMAST, TBMASTER_TOKOIGR
				WHERE trjd_cus_kodemember = cus_kodemember (+)
				  AND trjd_cus_kodemember = tko_kodecustomer (+)
				  AND trjd_prdcd = prd_prdcd (+)
				  AND trjd_recordid IS NULL
				  AND TRUNC(trjd_transactiondate) between to_date('".$tgl1."','dd/mm/yyyy') AND to_date('".$tgl2."','dd/mm/yyyy')
				  ".$where_outlet." --080213
				  ".$where_member."
				  ".$where_jenis_cus."
				  ".$where_monitoring."
			)
			GROUP BY kodeigr, cusnoA, cus_namamember, trjd_transactiondate, cus_kodeoutlet, cus_kodesuboutlet
		)
		WHERE FDNAMT <> 0
		GROUP BY kodeigr, cusNo, cus_namamember, cus_kodeoutlet, cus_kodesuboutlet
	)
	WHERE cusno = no_cusno
	  AND cusno = pr_cusno
	  AND cus_kodeoutlet = out_kodeoutlet  (+)
 	  AND sub_kodesuboutlet (+) = UPPER(cus_kodesuboutlet)
 	".$where_suboutlet."
	".$order);

//        dd($data);

        $dompdf = new PDF();

        $pdf = PDF::loadview('FRONTOFFICE.LAPORANKASIR.rekap-evaluasi-detail-pdf',compact(['perusahaan','data','tgl1','tgl2']));

        error_reporting(E_ALL ^ E_DEPRECATED);

        $pdf->output();
        $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);

        $canvas = $dompdf ->get_canvas();
        $canvas->page_text(507, 80.75, "{PAGE_NUM} dari {PAGE_COUNT}", null, 7, array(0, 0, 0));

        $dompdf = $pdf;

        return $dompdf->stream('Evaluasi per Member '.$tgl1.' - '.$tgl2.'.pdf');
    }

    public function printRekap(Request $request){
        $tgl1 = $request->tgl1;
        $tgl2 = $request->tgl2;

        if($request->member1 != '' && $request->member2 != '')
            $where_member = "AND trjd_cus_kodemember BETWEEN '".$request->member1."' AND '".$request->member2."'";
        else if($request->member1 != '')
            $where_member = "AND trjd_cus_kodemember >= '".$request->member1."'";
        else if($request->member2 != '')
            $where_member = "AND trjd_cus_kodemember <= '".$request->member2."'";
        else $where_member = " and 1=1";

        if($request->outlet1 != '' && $request->outlet2 != '')
            $where_outlet = "AND (cus_kodeoutlet BETWEEN '".$request->outlet1."' AND '".$request->outlet2."' OR cus_kodeoutlet IS NULL)";
        else if($request->outlet1 != '')
            $where_outlet = "AND (cus_kodeoutlet >= '".$request->outlet1."' OR cus_kodeoutlet IS NULL)";
        else if($request->outlet2 != '')
            $where_outlet = "AND (cus_kodeoutlet <= '".$request->outlet2."' OR cus_kodeoutlet IS NULL)";
        else $where_outlet = " and 1=1";

        if($request->suboutlet1 != '' && $request->suboutlet2 != '')
            $where_suboutlet = " and subnumb between '".$request->suboutlet1."' and '".$request->suboutlet2."'";
        else if($request->suboutlet1 != '')
            $where_suboutlet = " and subnumb >= '".$request->suboutlet1."'";
        else if($request->suboutlet2 != '')
            $where_suboutlet = " and subnumb <= '".$request->suboutlet2."'";
        else $where_suboutlet = " and 1=1";

        if($request->jenis_customer == 'MERAH')
            $where_jenis_cus = " AND cus_flagmemberkhusus = 'Y'";
        else if($request->jenis_customer == 'BIRU')
            $where_jenis_cus = " AND cus_flagmemberkhusus <> 'Y'";
        else if($request->jenis_customer == 'ALL')
            $where_jenis_cus = " AND 1=1";
        else $where_jenis_cus = " AND cus_jenismember = '".$request->jenis_customer."'";

        if($request->monitoring == 'ALL')
            $where_monitoring = 'AND 1=1';
        else $where_monitoring = " AND exists (SELECT 1 FROM TBTR_MONITORINGMEMBER WHERE mem_kodemonitoring = '".$request->monitoring."' and trjd_cus_kodemember = mem_kodemember)";

        if($request->jenis_customer == 'MERAH' || $request->jenis_customer == 'ALL')
            $poin = DB::select("SELECT nvl(sum(  POR_PEROLEHANPOINT * 1000), 0) nilai FROM TBTR_PEROLEHANPOIN, tbmaster_customer
		WHERE substr(POR_KODETRANSAKSI, 1, 8) >= to_char('".$tgl1."', 'yyyyMMdd') and substr(POR_KODETRANSAKSI, 1, 8) <= to_char('".$tgl2."', 'yyyyMMdd')
		AND POR_KODETRANSAKSI LIKE '%S' AND por_deskripsi LIKE 'RETAILER%' and por_kodeigr = '".$_SESSION['kdigr']."'
            and cus_kodemember = por_kodemember
            and nvl(cus_kodeoutlet, '0') between '".$request->outlet1."' and '".$request->outlet2."'
            and nvl(cus_kodesuboutlet, '00') between '".$request->suboutlet1."' and '".$request->suboutlet2."'")[0]->nilai;
        else $poin = 0;

        $perusahaan = DB::table('tbmaster_perusahaan')
            ->first();

        $data = DB::select("SELECT rpad(out_namaoutlet,11,' ') out_namaoutlet, sub_namasuboutlet,
		   cus_kodeoutlet AS fOutlt, cus_kodesuboutlet AS fsoutl,
		   SUM(CASE WHEN cus_kodeigr = '".$_SESSION['kdigr']."' THEN fwSlip END ) oTslip,
		   SUM(CASE WHEN cus_kodeigr = '".$_SESSION['kdigr']."' THEN fwProd END ) oTprod,
		   COUNT(CASE WHEN cus_kodeigr = '".$_SESSION['kdigr']."' THEN cusno END ) oTmemb,
		   SUM(CASE WHEN cus_kodeigr = '".$_SESSION['kdigr']."' THEN fwFreq END ) oTfreq,
		   SUM(CASE WHEN cus_kodeigr = '".$_SESSION['kdigr']."' THEN fwAmt END ) oTamt,
		   SUM(CASE WHEN cus_kodeigr = '".$_SESSION['kdigr']."' THEN flcost END ) oTcost,
		   SUM(CASE WHEN cus_kodeigr = '".$_SESSION['kdigr']."' THEN fbmemb END ) oTbmemb,
		   --
		   SUM(CASE WHEN nvl(cus_kodeigr,'_') <> '".$_SESSION['kdigr']."' THEN fwSlip END ) qTslip,
		   SUM(CASE WHEN nvl(cus_kodeigr,'_') <> '".$_SESSION['kdigr']."' THEN fwProd END ) qTprod,
		   CASE  WHEN COUNT(CASE WHEN nvl(cus_kodeigr,'_') <> '".$_SESSION['kdigr']."' THEN cusno END ) <>0 THEN
		   		 COUNT(CASE WHEN nvl(cus_kodeigr,'_') <> '".$_SESSION['kdigr']."' THEN cusno END ) END qTmemb,
		   SUM(CASE WHEN nvl(cus_kodeigr,'_') <> '".$_SESSION['kdigr']."' THEN fwFreq END ) qTfreq,
		   SUM(CASE WHEN nvl(cus_kodeigr,'_') <> '".$_SESSION['kdigr']."' THEN fwAmt END ) qTamt,
		   SUM(CASE WHEN nvl(cus_kodeigr,'_') <> '".$_SESSION['kdigr']."' THEN flcost END ) qTcost,
		   SUM(CASE WHEN nvl(cus_kodeigr,'_') <> '".$_SESSION['kdigr']."' THEN fbmemb END ) qTbmemb
	FROM TBMASTER_OUTLET, (SELECT sub_kodesuboutlet, ROWNUM subnumb,  sub_namasuboutlet FROM TBMASTER_SUBOUTLET WHERE sub_kodeigr = '".$_SESSION['kdigr']."'),
	(	SELECT cusnoA no_cusno, COUNT(TRJD_TRANSACTIONNO) fwSlip, CASE WHEN COUNT(TRJD_TRANSACTIONNO) = 1 THEN 1 ELSE 0 END fbmemb
        FROM
        (	SELECT DISTINCT TRUNC(trjd_transactiondate) trjd_transactiondate, NVL(trjd_cus_kodemember,'0') cusnoA,
        		   TRJD_TRANSACTIONNO, TRJD_CREATE_BY
        	FROM TBTR_JUALDETAIL
        	WHERE TRUNC(trjd_transactiondate) between to_date('".$tgl1."','dd/mm/yyyy') AND to_date('".$tgl2."','dd/mm/yyyy')
        	  AND trjd_recordid IS NULL
        )
		GROUP BY cusnoA
	),
	( 	SELECT cusnoA pr_cusno, COUNT(prdcd) fwProd
		FROM
		(	SELECT DISTINCT NVL(trjd_cus_kodemember,'0') cusnoA, (SUBSTR(trjd_prdcd,1,6)) prdcd
			FROM TBTR_JUALDETAIL
			WHERE TRUNC(trjd_transactiondate) between to_date('".$tgl1."','dd/mm/yyyy') AND to_date('".$tgl2."','dd/mm/yyyy')
			  AND trjd_recordid IS NULL
		)
		GROUP BY cusnoA
	),
	(	SELECT kodeigr, cus_kodeigr, cusNo, SUM(fdnamt) fwAmt, SUM(flcost) flcost, COUNT(fdtglt) fwFreq, cus_kodeoutlet, cus_kodesuboutlet
		FROM
		(	SELECT kodeigr, cus_kodeigr, cusnoA AS cusNo, trjd_transactiondate AS fdtglt, cus_kodeoutlet, cus_kodesuboutlet,
				   SUM(CASE WHEN trjd_transactiontype ='R' THEN (nNet*-1) ELSE nNet END) fdnAmt,
				   SUM(CASE WHEN trjd_transactiontype ='R' THEN (nHpp*-1) ELSE nHpp END) flCost
			FROM
			(	SELECT trjd_kodeigr kodeigr, TRUNC(trjd_transactiondate) trjd_transactiondate, NVL(trjd_cus_kodemember,'0') cusnoA, trjd_transactiontype,
					   cus_kodeigr, cus_kodeoutlet, UPPER(cus_kodesuboutlet) cus_kodesuboutlet,
					   CASE WHEN trjd_divisioncode = '5' AND SUBSTR(trjd_division,1, 2) = '39' THEN
					      CASE WHEN '".$request->counter."' = 'Y' THEN
						     trjd_nominalAmt
						  END
					   ELSE
					      CASE WHEN NVL(tko_kodesbu,'z') IN ('O','I') THEN
						     CASE WHEN NVL(tko_tipeOMI,'zz') IN ('HE','HG') THEN
							    trjd_nominalAmt - ( CASE WHEN trjd_flagTax1 = 'Y' AND NVL(trjd_flagTax2,'z') IN ('Y','z') AND NVL(prd_kodetag,'zz') <> 'Q' THEN ( trjd_nominalAmt - (trjd_nominalAmt / 1.1) ) ELSE 0 END )
							 ELSE
							    trjd_nominalAmt
							 END
						  ELSE
						     trjd_nominalAmt - (CASE WHEN SUBSTR(trjd_create_By,1,2) = 'EX' THEN 0 ELSE CASE WHEN trjd_flagTax1 = 'Y' AND NVL(trjd_flagTax2,'z') IN ('Y','z') AND NVL(PRD_kodeTAG,'zz') <> 'Q' THEN ( trjd_nominalAmt - (trjd_nominalAmt / 1.1) ) ELSE 0 END END )
						  END
					   END nNet,
					   CASE WHEN trjd_divisioncode = '5' AND SUBSTR(trjd_division,1,2) = '39' THEN
					      CASE WHEN '".$request->counter."' = 'Y' THEN
						     trjd_nominalAmt - ( CASE WHEN  PRD_markUpStandard IS NULL THEN (5 * trjd_nominalAmt) / 100 ELSE (prd_MarkUpStandard * trjd_nominalAmt) / 100 END )
						  END
					   ELSE
					      (trjd_quantity/ ( CASE WHEN prd_unit = 'KG' THEN 1000 ELSE 1 END)) * trjd_basePrice
					   END nHpp
				FROM TBTR_JUALDETAIL, TBMASTER_CUSTOMER, TBMASTER_PRODMAST, TBMASTER_TOKOIGR
				WHERE trjd_cus_kodemember = cus_kodemember (+)
				  AND trjd_cus_kodemember = tko_kodecustomer (+)
				  AND trjd_prdcd = prd_prdcd (+)
				  AND trjd_recordid IS NULL
				  AND TRUNC(trjd_transactiondate) between to_date('".$tgl1."','dd/mm/yyyy') AND to_date('".$tgl2."','dd/mm/yyyy')
                  ".$where_outlet."
				  ".$where_member."
				  ".$where_jenis_cus."
				  ".$where_monitoring."
			)
			GROUP BY cus_kodeigr, kodeigr, cusnoA, trjd_transactiondate, cus_kodeoutlet, cus_kodesuboutlet
		)
		WHERE FDNAMT <> 0
		GROUP BY cus_kodeigr, kodeigr, cusNo, cus_kodeoutlet, cus_kodesuboutlet
	)
	WHERE cusno = no_cusno
    AND cusno = pr_cusno
    AND cus_kodeoutlet = out_kodeoutlet  (+)
    AND cus_kodesuboutlet = sub_kodesuboutlet (+)
 	".$where_suboutlet."
	GROUP BY out_namaoutlet, sub_namasuboutlet, cus_kodeoutlet, cus_kodesuboutlet
	ORDER BY cus_kodeoutlet, cus_kodesuboutlet");

//        dd($data);

        $dompdf = new PDF();

        $pdf = PDF::loadview('FRONTOFFICE.LAPORANKASIR.rekap-evaluasi-rekap-pdf',compact(['perusahaan','data','tgl1','tgl2','poin']));

        error_reporting(E_ALL ^ E_DEPRECATED);

        $pdf->output();
        $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);

        $canvas = $dompdf ->get_canvas();
        $canvas->page_text(507, 80.75, "{PAGE_NUM} dari {PAGE_COUNT}", null, 7, array(0, 0, 0));

        $dompdf = $pdf;

        return $dompdf->stream('Evaluasi per Member '.$tgl1.' - '.$tgl2.'.pdf');
    }
}
