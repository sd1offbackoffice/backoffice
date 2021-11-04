<?php

namespace App\Http\Controllers\FRONTOFFICE\POINTREWARDMEMBERMERAH;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use PDF;
use DateTime;
use Yajra\DataTables\DataTables;

class RekapitulasiMutasiPointReward extends Controller
{

    public function index()
    {
        return view('FRONTOFFICE.POINTREWARDMEMBERMERAH.REKAPITULASIMUTASIPOINTREWARD.rekapitulasiMutasiPointReward');
    }

    public function lovMember(Request $request)
    {
        $search = $request->value;
        $data = DB::connection($_SESSION['connection'])->select("select kode, nama, rownum num
    from
    (
    select cus_kodemember kode,cus_namamember nama
    from tbmaster_customer
    where cus_kodeigr = 05
      and ( cus_kodemember LIKE '%" . $search . "%' or cus_namamember LIKE '%" . $search . "%' )
      and cus_kodemember in (select poc_kodemember from tbmaster_pointcustomer)
    order by cus_namamember
    )");
        return DataTables::of($data)->make(true);
    }

    public function urutkan(Request $request)
    {
        $bln = $request->bln;
        $thn = $request->thn;
        $sort = $request->sort;
        $member = isset($request->member) ? $request->member : '';

        $periode = $bln . '-' . $thn;

        $jumlahMember = DB::connection($_SESSION['connection'])->select("select nvl(count(poc_kodemember),0) count FROM TBmaster_POINtCUSTOMER
		where poc_kodemember in (select cus_kodemember from tbmaster_customer where cus_kodeigr = '" . $_SESSION['kdigr'] . "')")[0]->count;

        $dataTotal = DB::connection($_SESSION['connection'])->select("SELECT sum(saldo_awal_bulan) tot_saldoawal
			   , sum(NVL(perolehanpoint,0)) tot_perolehankasir
			   , sum(NVL(penukaranpoint,0)) tot_pembayaranpoin
			   , sum(NVL(redeempoint,0)) tot_redeempoin
			   , sum(saldo_awal_bulan+NVL(perolehanpoint,0)-(NVL(penukaranpoint,0)+NVL(redeempoint,0)) ) tot_saldoakhir
			   , 0 tot_transferkodelama, 0 tot_transferkodebaru
		FROM TBMASTER_CUSTOMER,
		  (
			SELECT poc_kodeigr kdigr, poc_kodemember kdmbr, saldo_awal, (NVL(saldo_awal,0)+NVL(perolehanpoint,0)-(NVL(penukaranpoint,0)+NVL(redeempoint,0))) saldo_awal_bulan
			FROM TBMASTER_POINTCUSTOMER,
				 ( SELECT hpc_kodemember S_kdmbr, hpc_saldoakhir saldo_awal FROM TBHISTORY_POINCUSTOMER
				   WHERE hpc_periodeblnmutasi = '20120930'
				 ),
				 ( SELECT P_kdmbr, SUM(perolehanpoint) perolehanpoint FROM
				   ( SELECT por_kodemember P_kdmbr, SUBSTR(por_kodetransaksi,1,6) P_periode, por_perolehanpoint perolehanpoint
					 FROM TBTR_PEROLEHANPOIN
				   )
				   WHERE P_periode < '" . $thn . "'||'" . $bln . "'
				   GROUP BY P_kdmbr
				 ),
				 ( SELECT T_kdmbr, SUM(penukaranpoint)penukaranpoint, SUM(redeempoint) redeempoint FROM
				   ( SELECT pot_kodemember T_kdmbr, SUBSTR(pot_kodetransaksi,1,6) T_periode, pot_penukaranpoint penukaranpoint, pot_redeempoint redeempoint
				     FROM TBTR_PENUKARANPOIN
				   )
				   WHERE T_periode < '" . $thn . "'||'" . $bln . "'
				   GROUP BY T_kdmbr
				 )
			WHERE poc_kodemember = S_kdmbr(+)
			  AND poc_kodemember = T_kdmbr(+)
			  AND poc_kodemember = P_kdmbr(+)
		  ),
		  ( SELECT P_kdmbr, SUM(perolehanpoint) perolehanpoint FROM
		   ( SELECT por_kodemember P_kdmbr, SUBSTR(por_kodetransaksi,1,6) P_periode, por_perolehanpoint perolehanpoint
			 FROM TBTR_PEROLEHANPOIN
		   )
		   WHERE P_periode = '" . $thn . "'||'" . $bln . "'
		   GROUP BY P_kdmbr
		 ),
		 ( SELECT T_kdmbr, SUM(penukaranpoint)penukaranpoint, SUM(redeempoint) redeempoint FROM
		   ( SELECT pot_kodemember T_kdmbr, SUBSTR(pot_kodetransaksi,1,6) T_periode, pot_penukaranpoint penukaranpoint, pot_redeempoint redeempoint
		     FROM TBTR_PENUKARANPOIN
		   )
		   WHERE T_periode = '" . $thn . "'||'" . $bln . "'
		   GROUP BY T_kdmbr
		 )
		WHERE kdmbr = T_kdmbr(+)
		  AND kdmbr = P_kdmbr(+)
		  AND kdmbr = cus_kodemember(+)
		  and kdmbr in (select cus_kodemember from tbmaster_customer where cus_kodeigr = '" . $_SESSION['kdigr'] . "')")[0];

        $data = DB::connection($_SESSION['connection'])->select("SELECT kdmbr, cus_namamember, saldo_awal_bulan
	   , NVL(perolehanpoint,0) perolehanpoint, NVL(penukaranpoint,0) penukaranpoint, NVL(redeempoint,0) redeempoint,
	   saldo_awal_bulan+NVL(perolehanpoint,0)-(NVL(penukaranpoint,0)+NVL(redeempoint,0)) saldo_akhir_bulan,
	   0 trf_kodelama, 0 trf_kodebaru
FROM TBMASTER_CUSTOMER,
  (
	SELECT poc_kodeigr kdigr, poc_kodemember kdmbr, saldo_awal, (NVL(saldo_awal,0)+NVL(perolehanpoint,0)-(NVL(penukaranpoint,0)+NVL(redeempoint,0))) saldo_awal_bulan
	FROM TBMASTER_POINTCUSTOMER,
		 ( SELECT hpc_kodemember S_kdmbr, hpc_saldoakhir saldo_awal FROM TBHISTORY_POINCUSTOMER
		   WHERE hpc_periodeblnmutasi = '20120930'
		 ),
		 ( SELECT P_kdmbr, SUM(perolehanpoint) perolehanpoint FROM
		   ( SELECT por_kodemember P_kdmbr, SUBSTR(por_kodetransaksi,1,6) P_periode, por_perolehanpoint perolehanpoint
			 FROM TBTR_PEROLEHANPOIN
		   )
		   WHERE P_periode < '" . $thn . "'||'" . $bln . "'
		   GROUP BY P_kdmbr
		 ),
		 ( SELECT T_kdmbr, SUM(penukaranpoint) penukaranpoint, SUM(redeempoint) redeempoint FROM
		   ( SELECT pot_kodemember T_kdmbr, SUBSTR(pot_kodetransaksi,1,6) T_periode, pot_penukaranpoint penukaranpoint, pot_redeempoint redeempoint
		     FROM TBTR_PENUKARANPOIN
		   )
		   WHERE T_periode < '" . $thn . "'||'" . $bln . "'
		   GROUP BY T_kdmbr
		 )
	WHERE poc_kodemember = S_kdmbr(+)
	  AND poc_kodemember = T_kdmbr(+)
	  AND poc_kodemember = P_kdmbr(+)
  ),
  ( SELECT P_kdmbr, SUM(perolehanpoint) perolehanpoint FROM
   ( SELECT por_kodemember P_kdmbr, SUBSTR(por_kodetransaksi,1,6) P_periode, por_perolehanpoint perolehanpoint
	 FROM TBTR_PEROLEHANPOIN
   )
   WHERE P_periode = '" . $thn . "'||'" . $bln . "'
   GROUP BY P_kdmbr
 ),
 ( SELECT T_kdmbr, SUM(penukaranpoint) penukaranpoint, SUM(redeempoint) redeempoint FROM
   ( SELECT pot_kodemember T_kdmbr, SUBSTR(pot_kodetransaksi,1,6) T_periode, pot_penukaranpoint penukaranpoint, pot_redeempoint redeempoint
     FROM TBTR_PENUKARANPOIN
   )
   WHERE T_periode = '" . $thn . "'||'" . $bln . "'
   GROUP BY T_kdmbr
 )
WHERE kdmbr = T_kdmbr(+)
  AND kdmbr = P_kdmbr(+)
  AND kdmbr = cus_kodemember(+)
  and kdmbr like '%" . $member . "%'");

        return compact(['data', 'dataTotal', 'jumlahMember', 'periode']);
    }

    public function cetak(Request $request)
    {
        $cw = 665;
        $ch = 35;
        $bln = $request->bln;
        $thn = $request->thn;
        $sort = $request->sort;
        $p_sort='';
        $periode = $thn.$bln;

        $filename = 'igr-fo-rwd-lpp';
        if($sort == 'kode'){
            $p_sort = 'order by kdmbr';
        }
        else{
            $p_sort = 'order by cus_namamember';
        }
        $tgl1 = '01-'.substr($periode,5,2).'-'.substr($periode,3,2);
        $tgl2 = substr($periode,7,2).'-'.substr($periode,5,2).'-'.substr($periode,3,2);

        $data = DB::connection($_SESSION['connection'])->select("SELECT prs_namaperusahaan, prs_namacabang, kdmbr, cus_namamember, saldo_awal_bulan
	   , NVL(perolehanpoint,0)perolehanpoint, NVL(penukaranpoint,0)penukaranpoint, NVL(redeempoint,0)redeempoint,
	   saldo_awal_bulan+NVL(perolehanpoint,0)-(NVL(penukaranpoint,0)+NVL(redeempoint,0)) saldo_akhir_bulan,
0 trf_kodelama, 0 trf_kodebaru
FROM TBMASTER_CUSTOMER, TBMASTER_PERUSAHAAN,
  (
	SELECT poc_kodeigr kdigr, poc_kodemember kdmbr, saldo_awal, (NVL(saldo_awal,0)+NVL(perolehanpoint,0)-(NVL(penukaranpoint,0)+NVL(redeempoint,0))) saldo_awal_bulan
	FROM TBMASTER_POINTCUSTOMER,
		 ( SELECT hpc_kodemember S_kdmbr, hpc_saldoakhir saldo_awal FROM TBHISTORY_POINCUSTOMER
		   WHERE hpc_periodeblnmutasi = '20120930'
		 ),
		 ( SELECT P_kdmbr, SUM(perolehanpoint) perolehanpoint FROM
		   ( SELECT por_kodemember P_kdmbr, SUBSTR(por_kodetransaksi,1,8) P_periode, por_perolehanpoint perolehanpoint
			 FROM TBTR_PEROLEHANPOIN
		   )
		   WHERE P_periode < substr('".$periode."',1,6)
		   GROUP BY P_kdmbr
		 ),
		 ( SELECT T_kdmbr, SUM(penukaranpoint) penukaranpoint, SUM(redeempoint) redeempoint FROM
		   ( SELECT pot_kodemember T_kdmbr, SUBSTR(pot_kodetransaksi,1,8) T_periode, pot_penukaranpoint penukaranpoint, pot_redeempoint redeempoint
		     FROM TBTR_PENUKARANPOIN
		   )
		   WHERE T_periode < substr('".$periode."',1,6)
		   GROUP BY T_kdmbr
		 )
	WHERE poc_kodemember = S_kdmbr(+)
	  AND poc_kodemember = T_kdmbr(+)
	  AND poc_kodemember = P_kdmbr(+)
  ),
  ( SELECT P_kdmbr, SUM(perolehanpoint) perolehanpoint FROM
   ( SELECT por_kodemember P_kdmbr, SUBSTR(por_kodetransaksi,1,6) P_periode, por_perolehanpoint perolehanpoint
	 FROM TBTR_PEROLEHANPOIN
   )
   WHERE P_periode = substr('".$periode."',1,6)
   GROUP BY P_kdmbr
 ),
 ( SELECT T_kdmbr, SUM(penukaranpoint)penukaranpoint, SUM(redeempoint) redeempoint FROM
   ( SELECT pot_kodemember T_kdmbr, SUBSTR(pot_kodetransaksi,1,6) T_periode, pot_penukaranpoint penukaranpoint, pot_redeempoint redeempoint
     FROM TBTR_PENUKARANPOIN
   )
   WHERE T_periode = substr('".$periode."',1,6)
   GROUP BY T_kdmbr
 )
WHERE kdmbr = T_kdmbr(+)
  AND kdmbr = P_kdmbr(+)
  AND cus_kodeigr = '".$_SESSION['kdigr']."'
  AND kdmbr = cus_kodemember(+)
  AND kdigr = '".$_SESSION['kdigr']."'
  AND kdigr = prs_kodeigr ".$p_sort);

        $perusahaan = DB::connection($_SESSION['connection'])->table('tbmaster_perusahaan')
            ->first();

        if (sizeof($data) != 0) {
            $data = [
                'perusahaan' => $perusahaan,
                'data' => $data,
                'tgl1' => $tgl1,
                'tgl2' => $tgl2,
            ];
            $dompdf = new PDF();

            $pdf = PDF::loadview('FRONTOFFICE.POINTREWARDMEMBERMERAH.REKAPITULASIMUTASIPOINTREWARD.' . $filename . '-pdf', $data);

            error_reporting(E_ALL ^ E_DEPRECATED);

            $pdf->output();
            $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);

            $canvas = $dompdf->get_canvas();
            $canvas->page_text($cw, $ch, "Hal : {PAGE_NUM} dari {PAGE_COUNT}", null, 7, array(0, 0, 0));

            $dompdf = $pdf;


            return $dompdf->stream($filename . '_' . $tgl1 . ' - ' . $tgl2 . '.pdf');
        } else {
            return 'Tidak Ada Data!';
        }
    }
}

