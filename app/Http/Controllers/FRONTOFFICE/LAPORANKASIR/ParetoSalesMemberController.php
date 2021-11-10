<?php

namespace App\Http\Controllers\FRONTOFFICE\LAPORANKASIR;

use PDF;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class ParetoSalesMemberController extends Controller
{

    public function index() {
        $kodeigr    = $_SESSION['kdigr'];

        $outlet = DB::connection($_SESSION['connection'])->table('tbmaster_outlet')->where('out_kodeigr', $kodeigr)->orderBy('out_kodeoutlet')->get();

        return view('FRONTOFFICE.LAPORANKASIR.laporan-pareto-sales-member', compact('outlet'));
    }

    public function getLovMember(Request  $request){
        $search = $request->search;
        $kodeigr    = $_SESSION['kdigr'];

        $member = DB::connection($_SESSION['connection'])->table('tbmaster_customer')->select('cus_kodemember' , 'cus_namamember', 'cus_recordid')
            ->where('cus_kodeigr', $kodeigr)
            ->whereRaw("(cus_namamember LIKE '%$search%' or cus_kodemember  LIKE '%$search%' ) and (cus_recordid IS NULL OR cus_recordid <> 1)")
            ->orderBy('cus_kodemember')
            ->limit(100)->get();

        return Datatables::of($member)->make(true);
    }

    public function cetakLaporan(Request $request){
        $kodeigr    = $_SESSION['kdigr'];
        $tgl_start  = $request->tgl_start;
        $tgl_end    = $request->tgl_end;
        $outlet_start = ($request->outlet_start) ? $request->outlet_start : '0';
        $outlet_end = ($request->outlet_end) ? $request->outlet_end : 'z';
        $member_start = ($request->member_start) ? $request->member_start : "000000";
        $member_end = ($request->member_end) ? $request->member_end : "zzzzzz";
        $limit      = $request->limit;
        $rank_member = ($request->rank_member) ? $request->rank_member : '9999999';
        $up_under   = $request->up_under;
        $rank_by    = $request->rank_by;
        $p_sort     = '';
        $p_where_pil = '';

        if ($rank_by == 1){
            $p_sort = 'order by fWamt desc';
        } elseif ($rank_by == 2){
            $p_sort = 'order by fGrsMargn desc';
        } else {
            $p_sort = 'order by fcusno';
        }

        if (!$limit){
            $p_where_pil = '';
        } else {
            if ($up_under == 'P'){
                $p_where_pil = ($rank_by == 1) ? 'AND wAmt > '.$limit : 'AND (wamt-lcost) > '.$limit;
            } elseif ($up_under == 'R'){
                $p_where_pil = ($rank_by == 1) ? 'AND wAmt < '.$limit : 'AND (wamt-lcost) < '.$limit;
            }
        }

        $perusahaan = DB::connection($_SESSION['connection'])->table('tbmaster_perusahaan')->first();

        $query = DB::connection($_SESSION['connection'])->select(" SELECT ROWNUM fnum, prs_namaperusahaan, prs_namacabang, out_namaoutlet, fNama,
                           fOutlt, fCusNo, fwFreq, fwSlip, fwProd, fwAmt, flCost, fGrsMargn
                    FROM
                    (    SELECT prs_namaperusahaan, prs_namacabang, out_namaoutlet, cus_namamember fNama,
                               cus_kodeoutlet AS fOutlt, cusNo AS fCusNo, wFreq AS fwFreq, fwSlip, fwProd, wAmt AS fwAmt,lCost AS flCost, (wamt-lcost) AS fGrsMargn
                        FROM TBMASTER_PERUSAHAAN, TBMASTER_OUTLET,
                        (    SELECT cusnoA no_cusno, COUNT(TRJD_TRANSACTIONNO) fwSlip
                            FROM
                            (    SELECT DISTINCT TRUNC(trjd_transactiondate) trjd_transactiondate, NVL(trjd_cus_kodemember,'0') cusnoA,
                                       TRJD_TRANSACTIONNO, TRJD_CREATE_BY
                                FROM TBTR_JUALDETAIL, TBMASTER_CUSTOMER
                                WHERE trjd_cus_kodemember = cus_kodemember (+)
                                  AND TRUNC(trjd_transactiondate) BETWEEN to_date('$tgl_start','dd/mm/yyyy') AND to_date('$tgl_end','dd/mm/yyyy')
                                  AND trjd_recordid IS NULL
                                  AND trjd_cus_kodemember BETWEEN '$member_start' AND '$member_end'
                                  AND cus_kodeoutlet BETWEEN '$outlet_start' AND '$outlet_end'
                            )
                            GROUP BY cusnoA
                        ),
                        (     SELECT cusnoA pr_cusno, COUNT(prdcd) fwProd
                            FROM
                            (    SELECT distinct NVL(trjd_cus_kodemember,'0') cusnoA, (SUBSTR(trjd_prdcd,1,6)) prdcd
                                FROM TBTR_JUALDETAIL, TBMASTER_CUSTOMER
                                WHERE trjd_cus_kodemember = cus_kodemember (+)
                                  AND TRUNC(trjd_transactiondate) BETWEEN to_date('$tgl_start','dd/mm/yyyy') AND to_date('$tgl_end','dd/mm/yyyy')
                                  AND trjd_recordid IS NULL
                                  AND trjd_cus_kodemember BETWEEN '$member_start' AND '$member_end'
                                  AND cus_kodeoutlet BETWEEN '$outlet_start' AND '$outlet_end'
                            )
                            GROUP BY cusnoA
                        ),
                        (    SELECT kodeigr, cusNo, cus_namamember, SUM(fdnamt) wAmt, SUM(flcost) lcost, COUNT(fdtglt) wFreq, cus_kodeoutlet
                            FROM
                            (    SELECT kodeigr, cusnoA AS cusNo, cus_namamember, trjd_transactiondate AS fdtglt, cus_kodeoutlet,
                                       SUM(CASE WHEN trjd_transactiontype ='R' THEN (nNet*-1) ELSE nNet END) fdnAmt,
                                       SUM(CASE WHEN trjd_transactiontype ='R' THEN (nHpp*-1) ELSE nHpp END) flCost
                                FROM
                                (    SELECT trjd_kodeigr kodeigr, TRUNC(trjd_transactiondate) trjd_transactiondate, NVL(trjd_cus_kodemember,'0') cusnoA, trjd_transactiontype,
                                           cus_kodeoutlet, cus_namamember,
                                           CASE WHEN trjd_divisioncode = '5' AND SUBSTR(trjd_division,1,2) IN ('39','40','50') THEN
                                                  trjd_nominalAmt
                                           ELSE
                                                  CASE WHEN tko_kodeSBU IN ('O','I') THEN
                                                   trjd_nominalAmt
                                               ELSE
                                                      trjd_nominalAmt - ( CASE WHEN SUBSTR(trjd_create_By,1,2) = 'EX' THEN 0
                                                                           ELSE
                                                                          CASE WHEN trjd_flagTax1 = 'Y' AND NVL(trjd_flagTax2,'zzz') <> 'P' AND NVL(prd_KodeTag,'zzz') <> 'Q' THEN ( trjd_nominalAmt - (trjd_nominalAmt / 1.1) )
                                                                           ELSE 0
                                                                         END
                                                                     END )
                                               END
                                            END nNet,
                                            ------
                                            CASE WHEN trjd_divisioncode = '5' AND SUBSTR(trjd_division,1,2) IN ('39','40','50') THEN
                                                trjd_nominalAmt -
                                                (CASE WHEN PRD_MarkUpStandard IS NULL THEN
                                                    (( 5 * trjd_nominalAmt) / 100)
                                                ELSE
                                                    ((PRD_MarkUpStandard * trjd_nominalAmt) / 100)
                                                END)
                                            ELSE
                                                trjd_quantity / ( CASE WHEN prd_unit='KG' THEN 1000 ELSE 1 END ) * trjd_basePrice
                                            END nHpp
                                            ------
                                    FROM TBTR_JUALDETAIL, TBMASTER_CUSTOMER, TBMASTER_PRODMAST, TBMASTER_TOKOIGR
                                    WHERE trjd_cus_kodemember = cus_kodemember (+)
                                      AND trjd_prdcd = prd_prdcd (+)
                                      AND trjd_cus_kodemember = tko_kodecustomer (+)
                                      AND TRUNC(trjd_transactiondate) BETWEEN to_date('$tgl_start','dd/mm/yyyy') AND to_date('$tgl_end','dd/mm/yyyy')
                                      AND trjd_recordid IS NULL
                                      AND trjd_cus_kodemember BETWEEN '$member_start' AND '$member_end'
                                      AND cus_kodeoutlet BETWEEN '$outlet_start' AND '$outlet_end'
                                )
                                GROUP BY kodeigr, cusnoA, cus_namamember, trjd_transactiondate, cus_kodeoutlet
                            )
                            GROUP BY kodeigr, cusNo, cus_namamember, cus_kodeoutlet
                        )
                        WHERE prs_kodeigr = '$kodeigr'
                          AND kodeigr = prs_kodeigr
                          AND cusno = no_cusno
                          AND cusno = pr_cusno
                          AND cus_kodeoutlet = out_kodeoutlet
                                    $p_where_pil
                        $p_sort
                    )
                    WHERE ROWNUM <= '$rank_member' ");



        $pdf = PDF::loadview('FRONTOFFICE.LAPORANKASIR.laporan-pareto-sales-member-pdf',['perusahaan' => $perusahaan, 'data' => $query, 'tgl_start' => $tgl_start, 'tgl_end' => $tgl_end]);
        $pdf->output();
        $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);

        $canvas = $dompdf ->get_canvas();
        $canvas->page_text(507, 77.75, "{PAGE_NUM} dari {PAGE_COUNT}", null, 7, array(0, 0, 0));


//        return $pdf->stream('laporan-pareto-sales-member-pdf');
        return $pdf->stream('laporanParetoSalesMember.pdf');
    }

}
