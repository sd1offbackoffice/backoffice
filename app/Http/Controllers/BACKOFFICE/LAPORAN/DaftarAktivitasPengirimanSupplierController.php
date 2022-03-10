<?php

namespace App\Http\Controllers\BACKOFFICE\LAPORAN;

use App\Http\Controllers\Auth\loginController;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Mockery\Exception;
use PDF;
use Yajra\DataTables\DataTables;

class DaftarAktivitasPengirimanSupplierController extends Controller
{
    public function index()
    {
        return view('BACKOFFICE.LAPORAN.daftar-aktivitas-pengiriman-supplier');
    }

    public function getLovSupplier(Request $request)
    {
        $search = $request->search;
        $data = DB::connection(Session::get('connection'))->table('tbmaster_supplier')
            ->selectRaw("sup_kodesupplier,sup_namasupplier")
            ->whereRaw("sup_kodesupplier LIKE '%" . $search . "%' or sup_namasupplier LIKE '%" . $search . "%'")
            ->orderBy('sup_kodesupplier')
            ->limit(100)
            ->get();

        return DataTables::of($data)->make(true);
    }

    public function getLovMonitoring(Request $request)
    {
        $search = $request->search;
        $data = DB::connection(Session::get('connection'))->table('tbtr_monitoringsupplier')
            ->selectRaw("msu_kodemonitoring,msu_namamonitoring")
            ->whereRaw("msu_kodemonitoring LIKE '%" . $search . "%' or msu_namamonitoring LIKE '%" . $search . "%'")
            ->orderBy('msu_kodemonitoring')
            ->limit(100)
            ->get();

        return DataTables::of($data)->make(true);
    }

    public function cetak(Request $request)
    {
        $periode = str_replace('/', '-', $request->periode);
        $bln = explode('-', $periode)[0];
        $thn = explode('-', $periode)[1];
        $supplier1 = $request->supplier1;
        $supplier2 = $request->supplier2;
        $monitoring = $request->monitoring;
        $sort = $request->sort;

        $and_mon = '';
        $and_sup = '';
        $orderby = '';


        if (isset($monitoring) and $monitoring <> 'Z') {
            $and_mon = " and sup_kodesupplier in (select msu_kodesupplier from tbtr_monitoringsupplier
                    where msu_kodeigr = '" . Session::get('kdigr') . "' and TRIM(msu_kodemonitoring) = '" . $monitoring . "')";
        } else {
            $and_mon = '';
        }

        if ((isset($supplier1) && $supplier1 <> '00000') && (isset($supplier2) && $supplier2 <> 'ZZZZZ')) {
            $and_sup = " and sup_kodeigr = '" . Session::get('kdigr') . "' and sup_kodesupplier between '" . $supplier1 . "' and '" . $supplier2 . "'";
        } else {
            $and_sup = '';
        }

        if ($sort == '1') {
            $orderby = ' order by sup_kodesupplier';
        } else if ($sort == '2') {
            $orderby = ' order by namasup';
        }

        $data = DB::connection(Session::get('connection'))
            ->select("select distinct sup_kodesupplier, namasup, sup_harikunjungan, jwpb, SUM (MNG) MNG, SUM (SNN) SNN,
                     SUM (SLS) SLS, SUM (RBU) RBU, SUM (KMS) KMS, SUM (JMT) JMT, SUM (SBT) SBT,
                     SUM (TGL01) TGL01, SUM (TGL02) TGL02, SUM (TGL03) TGL03, SUM (TGL04) TGL04,
                     SUM (TGL05) TGL05, SUM (TGL06) TGL06, SUM (TGL07) TGL07, SUM (TGL08) TGL08,
                     SUM (TGL09) TGL09, SUM (TGL10) TGL10, SUM (TGL11) TGL11, SUM (TGL12) TGL12,
                     SUM (TGL13) TGL13, SUM (TGL14) TGL14, SUM (TGL15) TGL15, SUM (TGL16) TGL16,
                     SUM (TGL17) TGL17, SUM (TGL18) TGL18, SUM (TGL19) TGL19, SUM (TGL20) TGL20,
                     SUM (TGL21) TGL21, SUM (TGL22) TGL22, SUM (TGL23) TGL23, SUM (TGL24) TGL24,
                     SUM (TGL25) TGL25, SUM (TGL26) TGL26, SUM (TGL27) TGL27, SUM (TGL28) TGL28,
                     SUM (TGL29) TGL29, SUM (TGL30) TGL30, SUM (TGL31) TGL31,
                     SUM(item) item, prs_namaperusahaan, prs_namacabang, prs_namawilayah
            from (select distinct sup_kodesupplier, sup_namasupplier||' '||sup_singkatansupplier namasup,
                         sup_harikunjungan, sup_jangkawaktukirimbarang jwpb,
                         CASE  WHEN TO_CHAR (MSTH_TGLDOC, 'Dy') = 'Sun'
                                              THEN 1
                                          ELSE 0
                                      END MNG,
                                      CASE
                                          WHEN TO_CHAR (MSTH_TGLDOC, 'Dy') = 'Mon'
                                              THEN 1
                                          ELSE 0
                                      END SNN,
                                      CASE
                                          WHEN TO_CHAR (MSTH_TGLDOC, 'Dy') = 'Tue'
                                              THEN 1
                                          ELSE 0
                                      END SLS,
                                      CASE
                                          WHEN TO_CHAR (MSTH_TGLDOC, 'Dy') = 'Wed'
                                              THEN 1
                                          ELSE 0
                                      END RBU,
                                      CASE
                                          WHEN TO_CHAR (MSTH_TGLDOC, 'Dy') = 'Thu'
                                              THEN 1
                                          ELSE 0
                                      END KMS,
                                      CASE
                                          WHEN TO_CHAR (MSTH_TGLDOC, 'Dy') = 'Fri'
                                              THEN 1
                                          ELSE 0
                                      END JMT,
                                      CASE
                                          WHEN TO_CHAR (MSTH_TGLDOC, 'Dy') = 'Sat'
                                              THEN 1
                                          ELSE 0
                                      END SBT,
                                      CASE
                                          WHEN SUBSTR (TO_CHAR (MSTH_TGLDOC, 'dd-mm-yyyy'), 1, 2) = '01'
                                              THEN 1
                                          ELSE 0
                                      END TGL01,
                                      CASE
                                          WHEN SUBSTR (TO_CHAR (MSTH_TGLDOC, 'dd-mm-yyyy'), 1, 2) = '02'
                                              THEN 1
                                          ELSE 0
                                      END TGL02,
                                      CASE
                                          WHEN SUBSTR (TO_CHAR (MSTH_TGLDOC, 'dd-mm-yyyy'), 1, 2) = '03'
                                              THEN 1
                                          ELSE 0
                                      END TGL03,
                                      CASE
                                          WHEN SUBSTR (TO_CHAR (MSTH_TGLDOC, 'dd-mm-yyyy'), 1, 2) = '04'
                                              THEN 1
                                          ELSE 0
                                      END TGL04,
                                      CASE
                                          WHEN SUBSTR (TO_CHAR (MSTH_TGLDOC, 'dd-mm-yyyy'), 1, 2) = '05'
                                              THEN 1
                                          ELSE 0
                                      END TGL05,
                                      CASE
                                          WHEN SUBSTR (TO_CHAR (MSTH_TGLDOC, 'dd-mm-yyyy'), 1, 2) = '06'
                                              THEN 1
                                          ELSE 0
                                      END TGL06,
                                      CASE
                                          WHEN SUBSTR (TO_CHAR (MSTH_TGLDOC, 'dd-mm-yyyy'), 1, 2) = '07'
                                              THEN 1
                                          ELSE 0
                                      END TGL07,
                                      CASE
                                          WHEN SUBSTR (TO_CHAR (MSTH_TGLDOC, 'dd-mm-yyyy'), 1, 2) = '08'
                                              THEN 1
                                          ELSE 0
                                      END TGL08,
                                      CASE
                                          WHEN SUBSTR (TO_CHAR (MSTH_TGLDOC, 'dd-mm-yyyy'), 1, 2) = '09'
                                              THEN 1
                                          ELSE 0
                                      END TGL09,
                                      CASE
                                          WHEN SUBSTR (TO_CHAR (MSTH_TGLDOC, 'dd-mm-yyyy'), 1, 2) = '10'
                                              THEN 1
                                          ELSE 0
                                      END TGL10,
                                      CASE
                                          WHEN SUBSTR (TO_CHAR (MSTH_TGLDOC, 'dd-mm-yyyy'), 1, 2) = '11'
                                              THEN 1
                                          ELSE 0
                                      END TGL11,
                                      CASE
                                          WHEN SUBSTR (TO_CHAR (MSTH_TGLDOC, 'dd-mm-yyyy'), 1, 2) = '12'
                                              THEN 1
                                          ELSE 0
                                      END TGL12,
                                      CASE
                                          WHEN SUBSTR (TO_CHAR (MSTH_TGLDOC, 'dd-mm-yyyy'), 1, 2) = '13'
                                              THEN 1
                                          ELSE 0
                                      END TGL13,
                                      CASE
                                          WHEN SUBSTR (TO_CHAR (MSTH_TGLDOC, 'dd-mm-yyyy'), 1, 2) = '14'
                                              THEN 1
                                          ELSE 0
                                      END TGL14,
                                      CASE
                                          WHEN SUBSTR (TO_CHAR (MSTH_TGLDOC, 'dd-mm-yyyy'), 1, 2) = '15'
                                              THEN 1
                                          ELSE 0
                                      END TGL15,
                                      CASE
                                          WHEN SUBSTR (TO_CHAR (MSTH_TGLDOC, 'dd-mm-yyyy'), 1, 2) = '16'
                                              THEN 1
                                          ELSE 0
                                      END TGL16,
                                      CASE
                                          WHEN SUBSTR (TO_CHAR (MSTH_TGLDOC, 'dd-mm-yyyy'), 1, 2) = '17'
                                              THEN 1
                                          ELSE 0
                                      END TGL17,
                                      CASE
                                          WHEN SUBSTR (TO_CHAR (MSTH_TGLDOC, 'dd-mm-yyyy'), 1, 2) = '18'
                                              THEN 1
                                          ELSE 0
                                      END TGL18,
                                      CASE
                                          WHEN SUBSTR (TO_CHAR (MSTH_TGLDOC, 'dd-mm-yyyy'), 1, 2) = '19'
                                              THEN 1
                                          ELSE 0
                                      END TGL19,
                                      CASE
                                          WHEN SUBSTR (TO_CHAR (MSTH_TGLDOC, 'dd-mm-yyyy'), 1, 2) = '20'
                                              THEN 1
                                          ELSE 0
                                      END TGL20,
                                      CASE
                                          WHEN SUBSTR (TO_CHAR (MSTH_TGLDOC, 'dd-mm-yyyy'), 1, 2) = '21'
                                              THEN 1
                                          ELSE 0
                                      END TGL21,
                                      CASE
                                          WHEN SUBSTR (TO_CHAR (MSTH_TGLDOC, 'dd-mm-yyyy'), 1, 2) = '22'
                                              THEN 1
                                          ELSE 0
                                      END TGL22,
                                      CASE
                                          WHEN SUBSTR (TO_CHAR (MSTH_TGLDOC, 'dd-mm-yyyy'), 1, 2) = '23'
                                              THEN 1
                                          ELSE 0
                                      END TGL23,
                                      CASE
                                          WHEN SUBSTR (TO_CHAR (MSTH_TGLDOC, 'dd-mm-yyyy'), 1, 2) = '24'
                                              THEN 1
                                          ELSE 0
                                      END TGL24,
                                      CASE
                                          WHEN SUBSTR (TO_CHAR (MSTH_TGLDOC, 'dd-mm-yyyy'), 1, 2) = '25'
                                              THEN 1
                                          ELSE 0
                                      END TGL25,
                                      CASE
                                          WHEN SUBSTR (TO_CHAR (MSTH_TGLDOC, 'dd-mm-yyyy'), 1, 2) = '26'
                                              THEN 1
                                          ELSE 0
                                      END TGL26,
                                      CASE
                                          WHEN SUBSTR (TO_CHAR (MSTH_TGLDOC, 'dd-mm-yyyy'), 1, 2) = '27'
                                              THEN 1
                                          ELSE 0
                                      END TGL27,
                                      CASE
                                          WHEN SUBSTR (TO_CHAR (MSTH_TGLDOC, 'dd-mm-yyyy'), 1, 2) = '28'
                                              THEN 1
                                          ELSE 0
                                      END TGL28,
                                      CASE
                                          WHEN SUBSTR (TO_CHAR (MSTH_TGLDOC, 'dd-mm-yyyy'), 1, 2) = '29'
                                              THEN 1
                                          ELSE 0
                                      END TGL29,
                                      CASE
                                          WHEN SUBSTR (TO_CHAR (MSTH_TGLDOC, 'dd-mm-yyyy'), 1, 2) = '30'
                                              THEN 1
                                          ELSE 0
                                      END TGL30,
                                      CASE
                                          WHEN SUBSTR (TO_CHAR (MSTH_TGLDOC, 'dd-mm-yyyy'), 1, 2) = '31'
                                              THEN 1
                                          ELSE 0
                                      END TGL31,
                         1 item, prs_namaperusahaan, prs_namacabang, prs_namawilayah
                    from tbtr_mstran_h, tbmaster_supplier, tbmaster_perusahaan
                    where sup_kodeigr = '" . Session::get('kdigr') . "' " . $and_sup . "
                      and msth_typetrn = 'B'
                      and msth_kodeigr= sup_kodeigr
                      and nvl(msth_recordid, '9') <> '1'
                      and msth_kodesupplier = sup_kodesupplier
                      and to_char(msth_tgldoc, 'mm-yyyy') = '" . $periode . "'
                      and (msth_tgldoc IS NOT NULL or msth_tglpo IS NOT NULL) " . $and_mon . "
                      and prs_kodeigr = sup_kodeigr)
            group by sup_kodesupplier, namasup, sup_harikunjungan, jwpb,
                      prs_namaperusahaan, prs_namacabang, prs_namawilayah
            " . $orderby);
        $perusahaan = DB::connection(Session::get('connection'))->table('tbmaster_perusahaan')->first();

        $chari = [];
        $chari[0] = Carbon::parse('01-' . $periode)->dayOfWeek;
        $chari[1] = Carbon::parse('01-' . $periode)->dayOfWeek;
        $chari[2] = Carbon::parse('02-' . $periode)->dayOfWeek;
        $chari[3] = Carbon::parse('03-' . $periode)->dayOfWeek;
        $chari[4] = Carbon::parse('04-' . $periode)->dayOfWeek;
        $chari[5] = Carbon::parse('05-' . $periode)->dayOfWeek;
        $chari[6] = Carbon::parse('06-' . $periode)->dayOfWeek;
        $chari[7] = Carbon::parse('07-' . $periode)->dayOfWeek;
        $chari[8] = Carbon::parse('08-' . $periode)->dayOfWeek;
        $chari[9] = Carbon::parse('09-' . $periode)->dayOfWeek;
        $chari[10] = Carbon::parse('10-' . $periode)->dayOfWeek;
        $chari[11] = Carbon::parse('11-' . $periode)->dayOfWeek;
        $chari[12] = Carbon::parse('12-' . $periode)->dayOfWeek;
        $chari[13] = Carbon::parse('13-' . $periode)->dayOfWeek;
        $chari[14] = Carbon::parse('14-' . $periode)->dayOfWeek;
        $chari[15] = Carbon::parse('15-' . $periode)->dayOfWeek;
        $chari[16] = Carbon::parse('16-' . $periode)->dayOfWeek;
        $chari[17] = Carbon::parse('17-' . $periode)->dayOfWeek;
        $chari[18] = Carbon::parse('18-' . $periode)->dayOfWeek;
        $chari[19] = Carbon::parse('19-' . $periode)->dayOfWeek;
        $chari[20] = Carbon::parse('20-' . $periode)->dayOfWeek;
        $chari[21] = Carbon::parse('21-' . $periode)->dayOfWeek;
        $chari[22] = Carbon::parse('22-' . $periode)->dayOfWeek;
        $chari[23] = Carbon::parse('23-' . $periode)->dayOfWeek;
        $chari[24] = Carbon::parse('24-' . $periode)->dayOfWeek;
        $chari[25] = Carbon::parse('25-' . $periode)->dayOfWeek;
        $chari[26] = Carbon::parse('26-' . $periode)->dayOfWeek;
        $chari[27] = Carbon::parse('27-' . $periode)->dayOfWeek;
        $chari[28] = Carbon::parse('28-' . $periode)->dayOfWeek;

        if (Carbon::parse('01-' . $periode)->format('m') == '02') {
            if (Carbon::parse('01-' . $periode)->endOfMonth()->format('d') == '29') {
                $chari[29] = Carbon::parse('29-' . $periode)->dayOfWeek;
            } else {
                $chari[29] = '';
            }
            $chari[30] = '';
            $chari[31] = '';
        } else {
            $chari[29] = Carbon::parse('29-' . $periode)->dayOfWeek;
            $chari[30] = Carbon::parse('30-' . $periode)->dayOfWeek;

            if (Carbon::parse('01-' . $periode)->endOfMonth()->format('d') == '31') {

                $chari[31] = Carbon::parse('31-' . $periode)->dayOfWeek;
            } else {
                $chari[31] = '';
            }
        }
        for ($i = 0; $i < sizeof($chari); $i++) {
            if ($chari[$i] == '0') {
                $chari[$i] = 'Mng';
            } else if ($chari[$i] == '1') {
                $chari[$i] = 'Snn';
            } else if ($chari[$i] == '2') {
                $chari[$i] = 'Sls';
            } else if ($chari[$i] == '3') {
                $chari[$i] = 'Rbu';
            } else if ($chari[$i] == '4') {
                $chari[$i] = 'Kms';
            } else if ($chari[$i] == '5') {
                $chari[$i] = 'Jmt';
            } else if ($chari[$i] == '6') {
                $chari[$i] = 'Sbt';
            } else {
                $chari[$i] = '';
            }
        }

        return view('BACKOFFICE.LAPORAN.daftar-aktivitas-pengiriman-supplier-pdf', compact(['perusahaan', 'data', 'periode','chari']));
    }
}
