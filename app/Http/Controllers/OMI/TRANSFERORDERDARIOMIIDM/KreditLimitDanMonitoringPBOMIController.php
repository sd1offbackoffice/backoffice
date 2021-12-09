<?php
/**
 * Created by PhpStorm.
 * User: ryan
 * Date: 08/09/2021
 * Time: 9:13 AM
 */

namespace App\Http\Controllers\OMI\TRANSFERORDERDARIOMIIDM;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Auth\loginController;
use Illuminate\Support\Facades\DB;
use PDF;
use DateTime;
use Yajra\DataTables\DataTables;

class KreditLimitDanMonitoringPBOMIController extends Controller
{

    public function index()
    {
        return view('OMI.TRANSFERORDERDARIOMIIDM.kredit-limit-dan-monitoring-pb-omi');
    }

    public function getLovKodeOMI()
    {
        $datas = DB::connection($_SESSION['connection'])->table("tbmaster_tokoigr")
            ->selectRaw("tko_kodeomi, tko_namaomi, tko_kodecustomer")
            ->whereRaw("tko_kodesbu  = 'O'")
            ->get();

        return Datatables::of($datas)->make(true);
    }

    public function getDataOMI(Request $request)
    {
        $value = $request->kodeomi;

        $data = DB::connection($_SESSION['connection'])->table("tbmaster_tokoigr")
            ->select("tko_kodeomi", "tko_namaomi", "tko_kodecustomer")
            ->where("tko_kodeomi", "=", $value)
            ->first();
        return compact(['data']);
    }

    public function getDataMasterKreditLimitOMI()
    {
        $datas = DB::connection($_SESSION['connection'])->table("tbmaster_clomi")->join("tbmaster_tokoigr", "tko_kodeomi", "=", "mcl_kodeomi")
            ->orderBy("mcl_kodeomi")
            ->get();
        return Datatables::of($datas)->make(true);
    }

    public function getMonitoringDataPBTolakan()
    {
        $datas = DB::connection($_SESSION['connection'])->table("omi_clapproval")
            ->whereRaw("nvl(cla_recordid, '0') = '0'")
            ->orderBy("cla_kodeomi")
            ->orderBy("cla_nopb")
            ->get();
        return Datatables::of($datas)->make(true);
    }

    public function simpan(Request $request)
    {
        $txt_kdomi = $request->kodeomi;
        $txt_proxy = $request->kodeproxy;
        $txt_nilaicl = $request->nilaikreditlimit;
        $txt_top = $request->top;
        $txt_nontop = $request->nontop;
        $txt_tgltop = $request->tgltop;
        $txt_kdcus = $request->kodecustomer;

        $temp = DB::connection($_SESSION['connection'])->table("tbmaster_tokoigr")
            ->where("tko_kodeomi", "=", $txt_kdomi)
            ->where("tko_kodesbu", "=", "O")
            ->count();

        if ($temp == 0) {
            $message = "Data Toko OMI Tidak Ada !!";
            $status = "error";
            return compact(['message', 'status']);
        }

        if ((int)$txt_proxy <= 1 && (int)$txt_proxy >= 2) {
            $message = "Salah Inputan Kode Proxy !!";
            $status = "error";
            return compact(['message', 'status']);
        }

        if (!isset($txt_nilaicl) || $txt_nilaicl == '' || $txt_nilaicl == 0) {
            $message = "Salah Inputan Nilai Kredit Limit !!";
            $status = "error";
            return compact(['message', 'status']);
        }

        if ($txt_proxy == '1') {
            if ($txt_top != '') {
                if ($txt_top < 1 || $txt_top > 999) {
                    $message = "Untuk Proxy Regular, tidak boleh <= 0 !!";
                    $status = "error";
                    return compact(['message', 'status']);
                }
            }
        } else {
            $txt_top = '';
        }

        if ($txt_proxy == '2') {
            if (!isset($txt_tgltop)) {
                $message = "Untuk Proxy Alokasi, Tgl TOP harus diinput !!";
                $status = "error";
                return compact(['message', 'status']);
            }
        } else {
            $txt_tgltop = '';
        }

        if ($txt_nontop == 'Y') {
            $txt_name_2 = '';
            $txt_pass_2 = '';

            $message = "log";
            $status = "action";
            return compact(['message', 'status']);

        } else {

            $temp = DB::connection($_SESSION['connection'])->table("tbmaster_clomi")
                ->where("mcl_kodeomi", "=", $txt_kdomi)
                ->where("mcl_kodeproxy", "=", $txt_proxy)
                ->count();

            if ($temp != 0) {
                DB::connection($_SESSION['connection'])->table('tbmaster_clomi')
                    ->where('mcl_kodeomi', '=', $txt_kdomi)
                    ->where('mcl_kodeproxy', '=', $txt_proxy)
                    ->update([
                        'mcl_maxnilaicl' => $txt_nilaicl,
                        'mcl_tgltop' => DB::raw("to_date('" . $txt_tgltop . "','dd/mm/yyyy')"),
                        'mcl_top' => $txt_top,
                        'mcl_nontop' => $txt_nontop,
                    ]);
            } else {
                DB::connection($_SESSION['connection'])->table('tbmaster_clomi')->insert([
                    'mcl_kodeproxy' => $txt_proxy,
                    'mcl_kodemember' => $txt_kdcus,
                    'mcl_kodeomi' => $txt_kdomi,
                    'mcl_maxnilaicl' => $txt_nilaicl,
                    'mcl_tgltop' => DB::raw("to_date('" . $txt_tgltop . "','dd/mm/yyyy')"),
                    'mcl_top' => $txt_top,
                    'mcl_nontop' => $txt_nontop,
                    'mcl_create_by' => $_SESSION['usid'],
                    'mcl_create_dt' => DB::raw('sysdate')
                ]);
            }
            DB::connection($_SESSION['connection'])->table('tbhistory_clomi')->insert([
                'hcl_kodeproxy' => $txt_proxy,
                'hcl_kodemember' => $txt_kdcus,
                'hcl_kodeomi' => $txt_kdomi,
                'hcl_maxnilaicl' => $txt_nilaicl,
                'hcl_tgl' => DB::raw('sysdate'),
                'hcl_tipetransaksi' => 'M',
                'hcl_nilaitransaksi' => $txt_nilaicl,
                'hcl_nilaicl' => $txt_nilaicl,
                'hcl_create_by' => $_SESSION['usid'],
                'hcl_create_dt' => DB::raw('sysdate'),
                'hcl_tgltop' => DB::raw("to_date('" . $txt_tgltop . "','dd/mm/yyyy')"),
                'hcl_top' => $txt_top,
                'hcl_nontop' => $txt_nontop,
                ]);

            if ($txt_proxy == '1') {
                DB::connection($_SESSION['connection'])->table('tbmaster_customer')
                    ->where('cus_kodemember', '=', $txt_kdcus)
                    ->update([
                        'cus_top' => $txt_top,
                        'cus_modify_by' => $_SESSION['usid'],
                        'cus_modify_dt' => DB::raw('sysdate')
                    ]);
            }
            $message = "Data sudah disimpan!";
            $status = "success";
            return compact(['message', 'status']);
        }

    }

    public function getDataTop(Request $request)
    {
        $txt_kdomi = $request->kodeomi;
        $txt_proxy = $request->kodeproxy;

        $temp = DB::connection($_SESSION['connection'])->table("tbmaster_clomi")
            ->where('mcl_kodeomi', '=', $txt_kdomi)
            ->where("mcl_kodeproxy", "=", $txt_proxy)
            ->count();

        if ($temp <> 0) {
            $data = DB::connection($_SESSION['connection'])->table("tbmaster_clomi")
                ->select('mcl_maxnilaicl', 'mcl_tgltop')
                ->where('mcl_kodeomi', '=', $txt_kdomi)
                ->where("mcl_kodeproxy", "=", $txt_proxy)
                ->first();
            return compact(['data']);
        }
        return 'no data';
    }

    public function submitLogNonTop(Request $request)
    {
        $txt_kdomi = $request->kodeomi;
        $txt_proxy = $request->kodeproxy;
        $txt_nilaicl = $request->nilaikreditlimit;
        $txt_top = $request->top;
        $txt_nontop = $request->nontop;
        $txt_tgltop = $request->tgltop;
        $txt_kdcus = $request->kodecustomer;
        $username = $request->username;
        $password = $request->password;

        $temp = DB::connection($_SESSION['connection'])->table("tbmaster_user")
            ->where('userid', '=', $username)
            ->where("userpassword", "=", $password)
            ->where("userlevel", "=", '1')
            ->count();

        if ($temp == 0) {
            $message = "Autorisasi Tidak Berhasil !!";
            $status = "error";
            return compact(['message', 'status']);
        }

        $temp = DB::connection($_SESSION['connection'])->table("tbmaster_clomi")
            ->where('mcl_kodeomi', '=', $txt_kdomi)
            ->where("mcl_kodeproxy", "=", $txt_proxy)
            ->count();
        if ($temp != 0) {
            DB::connection($_SESSION['connection'])->table('tbmaster_clomi')
                ->where('mcl_kodeomi', '=', $txt_kdomi)
                ->where('mcl_kodeproxy', '=', $txt_proxy)
                ->update([
                    'mcl_maxnilaicl' => $txt_nilaicl,
                    'mcl_tgltop' => DB::raw("to_date('" . $txt_tgltop . "','dd/mm/yyyy')"),
                    'mcl_top' => $txt_top,
                    'mcl_nontop' => $txt_nontop,
                ]);
        } else {
            DB::connection($_SESSION['connection'])->table('tbmaster_clomi')
                ->insert([
                    'mcl_kodeproxy' => $txt_proxy,
                    'mcl_kodemember' => $txt_kdcus,
                    'mcl_kodeomi' => $txt_kdomi,
                    'mcl_maxnilaicl' => $txt_nilaicl,
                    'mcl_tgltop' => DB::raw("to_date('" . $txt_tgltop . "','dd/mm/yyyy')"),
                    'mcl_top' => $txt_top,
                    'mcl_create_by' => $_SESSION['usid'],
                    'mcl_create_dt' => Carbon::now(),
                    'mcl_nontop' => $txt_nontop,
                ]);
        }

        DB::connection($_SESSION['connection'])->table('tbhistory_clomi')
            ->insert([
                'hcl_kodeproxy' => $txt_proxy,
                'hcl_kodemember' => $txt_kdcus,
                'hcl_kodeomi' => $txt_kdomi,
                'hcl_maxnilaicl' => $txt_nilaicl,
                'hcl_tgl' => Carbon::now(),
                'hcl_tipetransaksi' => "M",
                'hcl_nilaitransaksi' => $txt_nilaicl,
                'hcl_nilaicl' => $txt_nilaicl,
                'hcl_create_by' => $_SESSION['usid'],
                'hcl_create_dt' => Carbon::now(),
                'hcl_tgltop' => DB::raw("to_date('" . $txt_tgltop . "','dd/mm/yyyy')"),
                'hcl_top' => $txt_top,
                'hcl_nontop' => $txt_nontop,
            ]);

        if ($txt_proxy == '1') {
            DB::connection($_SESSION['connection'])->table('tbmaster_customer')
                ->where('cus_kodemember', '=', $txt_kdcus)
                ->update([
                    'cus_top' => $txt_top,
                    'cus_modify_by' => $_SESSION['usid'],
                    'cus_modify_dt' => Carbon::now(),
                ]);

        }


//	go_block('TBMASTER_CLOMI');
//	clear_block(no_validate);
//	go_block('TBMASTER_CLOMI');
//	EXECUTE_QUERY;
//
//	hide_window('window96');
//	go_item('TXT_KDOMI');

        $message = "Data Sudah Disimpan !!";
        $status = "success";
        return compact(['message', 'status']);
    }

    public function submitLog(Request $request)
    {
        $username = $request->username;
        $password = $request->password;

        $temp = DB::connection($_SESSION['connection'])->table("tbmaster_user")
            ->where('userid', '=', $username)
            ->where("userpassword", "=", $password)
            ->where("userlevel", "=", '1')
            ->count();

        if ($temp == 0) {
            $message = "Autorisasi Tidak Berhasil !!";
            $status = "error";
            return compact(['message', 'status']);
        } else {
            $message = "Autorisasi Berhasil !!";
            $status = "success";
            return compact(['message', 'status']);
        }
    }

    public function prosesTolakan(Request $request)
    {
        $value = $request->value;
        $cla_kodeomi = $request->cla_kodeomi;
        $cla_nopb = $request->cla_nopb;
        $cla_tglpb = $request->cla_tglpb;
        $cla_sisacl = $request->cla_sisacl;
        $cla_nilaipb = $request->cla_nilaipb;

        if ($value == 1) {
            DB::connection($_SESSION['connection'])->table('omi_clapproval')
                ->where([
                    'cla_kodeomi' => $cla_kodeomi,
                    'cla_nopb' => $cla_nopb,
                    'cla_tglpb' => $cla_tglpb,
                ])
                ->update([
                    'cla_recordid' => '4',
                    'cla_nilaiapproval' => 0,
                    'cla_tglapproval' => Carbon::now()
                ]);

        } else if ($value == 2) {
            DB::connection($_SESSION['connection'])->table('omi_clapproval')
                ->where([
                    'cla_kodeomi' => $cla_kodeomi,
                    'cla_nopb' => $cla_nopb,
                    'cla_tglpb' => $cla_tglpb,
                ])
                ->update([
                    'cla_recordid' => '3',
                    'cla_nilaiapproval' => $cla_sisacl,
                    'cla_tglapproval' => Carbon::now()
                ]);
        } else if ($value == 3) {
            $c = loginController::getConnectionProcedure();
            $s = oci_parse($c, "BEGIN :ret := F_IGR_GET_NOMOR('" . $_SESSION['kdigr'] . "','BA','Nomor Berita Acara PB','BAP'||" . DB::raw("TO_CHAR (SYSDATE, 'yy') || SUBSTR ('ABCDEFGHIJKL', TO_CHAR (SYSDATE, 'MM'), 1)") . ",6,TRUE); END;");
            oci_bind_by_name($s, ':ret', $noba,32);
            oci_execute($s);

            DB::connection($_SESSION['connection'])->table('omi_clapproval')
                ->where([
                    'cla_kodeomi' => $cla_kodeomi,
                    'cla_nopb' => $cla_nopb,
                    'cla_tglpb' => $cla_tglpb,
                ])
                ->update([
                    'cla_recordid' => '2',
                    'cla_nilaiapproval' => $cla_nilaipb,
                    'cla_tglapproval' => Carbon::now(),
                    'cla_noba' => $noba
                ]);
        }

        $message = "Data PB Sudah Di Proses !!";
        $status = "success";
        return compact(['message', 'status']);
    }

}
