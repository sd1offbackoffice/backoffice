<?php

namespace App\Http\Controllers\FRONTOFFICE\LAPORANKASIR;

use App\Http\Controllers\Auth\loginController;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller; use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Mockery\Exception;
use PDF;
use Yajra\DataTables\DataTables;

class LaporanTransaksiBKPBTKPController extends Controller
{
    public function index(){
        return view('FRONTOFFICE.LAPORANKASIR.laporan-transaksi-bkp-btkp');
    }

    public function print(Request $request){
        $tgl1 = $request->tgl1;
        $tgl2 = $request->tgl2;

        $perusahaan = DB::connection(Session::get('connection'))
            ->table('tbmaster_perusahaan')
            ->first();

//        $data = DB::connection(Session::get('connection'))
        $data = DB::connection('simtgr')
            ->select("select trjd_division, dept, kat_kodekategori, kat_namakategori, sum(sbkp) sbkp, sum(rbkp) rbkp,
      sum(sexp) sexp, sum(rexp) rexp,sum(sokp) sokp, sum(rokp) rokp, sum(scki) scki, sum(rcki) rcki, sum(stkp) stkp,
      sum(rtkp) rtkp
from( SELECT trjd_division, SUBSTR(trjd_division,1,2) dept, kat_kodekategori, kat_namakategori,
    CASE WHEN trjd_transactiontype = 'S' THEN
       CASE WHEN tko_tipeomi = 'HR'  OR tko_tipeomi IS NULL THEN
          CASE WHEN (trjd_flagtax1 = 'Y' AND trjd_flagtax2 = 'Y') AND NVL(prd_kodetag,'9') <> 'Q'  AND tko_kodecustomer = trjd_cus_kodemember THEN
	 trjd_nominalamt * 1.1
          ELSE
                CASE WHEN (trjd_flagtax1 = 'Y' AND trjd_flagtax2 = 'Y') AND NVL(prd_kodetag,'9') <> 'Q' THEN
                       trjd_nominalamt
                END
          END
       ELSE
          CASE WHEN (trjd_flagtax1 = 'Y' AND trjd_flagtax2 = 'Y') AND NVL(prd_kodetag,'9') <> 'Q' THEN
                  trjd_nominalamt
          END
       END
    END sbkp,
    CASE WHEN trjd_transactiontype = 'R' THEN
       CASE WHEN tko_tipeomi = 'HR' OR tko_tipeomi IS NULL THEN
          CASE WHEN (trjd_flagtax1 = 'Y' AND trjd_flagtax2 = 'Y') AND NVL(prd_kodetag,'9') <> 'Q' AND tko_kodecustomer = trjd_cus_kodemember THEN
                 trjd_nominalamt * 1.1
          ELSE
                CASE WHEN (trjd_flagtax1 = 'Y' AND trjd_flagtax2 = 'Y') AND NVL(prd_kodetag,'9') <> 'Q' THEN
                     trjd_nominalamt
                END
          END
        ELSE
           CASE WHEN (trjd_flagtax1 = 'Y' AND trjd_flagtax2 = 'Y') AND NVL(prd_kodetag,'9') <> 'Q' THEN
                  trjd_nominalamt
           END
        END
    END rbkp,
    CASE WHEN trjd_transactiontype = 'S' THEN
       CASE WHEN (trjd_flagtax1 = 'Y' AND trjd_flagtax2 = 'Y') AND NVL(prd_kodetag,'9') = 'Q' AND NVL(cus_jenismember,'9') ='E' THEN
	   trjd_nominalamt
       END
    END sexp,
    CASE WHEN trjd_transactiontype = 'R' THEN
       CASE WHEN (trjd_flagtax1 = 'Y' AND trjd_flagtax2 = 'Y') AND NVL(prd_kodetag,'9') = 'Q' AND NVL(cus_jenismember,'9') ='E' THEN
                  trjd_nominalamt
       END
    END rexp,
    CASE WHEN trjd_transactiontype = 'S' THEN
       CASE WHEN (trjd_flagtax1 = 'Y' OR trjd_flagtax1 IS NULL) AND trjd_flagtax2 = 'P' THEN
 	  trjd_nominalamt
        END
    END sokp,
    CASE WHEN trjd_transactiontype = 'R' THEN
        CASE WHEN (trjd_flagtax1 = 'Y' OR trjd_flagtax1 IS NULL) AND trjd_flagtax2 = 'P' THEN
 	  trjd_nominalamt
        END
    END rokp,
    CASE WHEN trjd_transactiontype = 'S' THEN
        CASE WHEN (trjd_flagtax1 = 'Y' OR trjd_flagtax1 IS NULL) AND trjd_flagtax2 = 'C' THEN
  	  trjd_nominalamt
        END
    END scki,
    CASE WHEN trjd_transactiontype = 'R' THEN
        CASE WHEN (trjd_flagtax1 = 'Y' OR trjd_flagtax1 IS NULL) AND trjd_flagtax2 = 'C' THEN
 	  trjd_nominalamt
        END
    END rcki,
    CASE WHEN trjd_transactiontype = 'S' THEN
        CASE WHEN (trjd_flagtax1 <> 'Y' OR trjd_flagtax1 IS NULL) AND trjd_flagtax2 NOT IN('Y','C','P') THEN
 	  trjd_nominalamt
        END
    END stkp,
    CASE WHEN trjd_transactiontype = 'R' THEN
        CASE WHEN (trjd_flagtax1 <> 'Y' OR trjd_flagtax1 IS NULL) AND trjd_flagtax2 NOT IN('Y','C','P') THEN
 	  trjd_nominalamt
        END
    END rtkp
FROM TBTR_JUALDETAIL, TBMASTER_TOKOIGR, TBMASTER_PRODMAST, TBMASTER_CUSTOMER,
           TBMASTER_KATEGORI
--WHERE trjd_kodeigr = '".Session::get('kdigr')."'
WHERE trjd_kodeigr = '05'
AND TRUNC(trjd_transactiondate) BETWEEN TRUNC(TO_DATE('".$tgl1."','dd/mm/yyyy')) AND TRUNC(TO_DATE('".$tgl2."','dd/mm/yyyy'))
AND NVL(trjd_recordid,'9') <> '1'
AND SUBSTR(trjd_division,1,1) <> 'C'
AND tko_kodeigr(+) = trjd_kodeigr
AND tko_kodecustomer(+) = trjd_cus_kodemember
AND prd_kodeigr = trjd_kodeigr
AND prd_prdcd = trjd_prdcd
AND cus_kodemember(+) = trjd_cus_kodemember
AND kat_kodeigr = trjd_kodeigr
AND kat_kodedepartement = SUBSTR(trjd_division,1,2)
AND kat_kodekategori = SUBSTR(trjd_division,3,2))
GROUP BY trjd_division, dept, kat_kodekategori, kat_namakategori
ORDER BY dept, kat_kodekategori");

//        dd($data);

//        return view('FRONTOFFICE.LAPORANKASIR.laporan-transaksi-bkp-btkp-min-pdf',compact(['perusahaan','data','tgl1','tgl2']));

        return view('FRONTOFFICE.LAPORANKASIR.laporan-transaksi-bkp-btkp-pdf',compact(['perusahaan','data','tgl1','tgl2']));
    }
}
