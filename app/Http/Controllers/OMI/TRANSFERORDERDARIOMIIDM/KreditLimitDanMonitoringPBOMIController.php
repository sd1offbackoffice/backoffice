<?php
/**
 * Created by PhpStorm.
 * User: ryan
 * Date: 08/09/2021
 * Time: 9:13 AM
 */

namespace App\Http\Controllers\OMI\TRANSFERORDERDARIOMIIDM;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
        $datas = DB::table("tbmaster_tokoigr")
            ->selectRaw("tko_kodeomi, tko_namaomi, tko_kodecustomer")
            ->whereRaw("tko_kodesbu  = 'O'")
            ->get();

        return Datatables::of($datas)->make(true);
    }

    public function getDataOMI(Request $request)
    {
        $value = $request->kodeomi;

        $data = DB::table("tbmaster_tokoigr")
            ->select("tko_kodeomi", "tko_namaomi", "tko_kodecustomer")
            ->where("tko_kodeomi", "=", $value)
            ->first();
        return compact(['data']);
    }

    public function getDataMasterKreditLimitOMI()
    {
        $datas = DB::table("tbmaster_clomi")->join("tbmaster_tokoigr", "tko_kodeomi", "=", "mcl_kodeomi")
            ->orderBy("mcl_kodeomi")
            ->get();
        return Datatables::of($datas)->make(true);
    }

    public function getMonitoringDataPBTolakan()
    {
        $datas = DB::table("tbmaster_clomi")
            ->whereRaw("nvl(mcl_recordid, '0') = '0'")
            ->orderBy("mcl_kodeomi")
            ->orderBy("mcl_kodeproxy")
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

        $temp = DB::table("tbmaster_tokoigr")
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
            if ($txt_top < 1 || $txt_top > 999) {
                $message = "Untuk Proxy Regular, tidak boleh <= 0 !!";
                $status = "error";
                return compact(['message', 'status']);
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
        } else {


            $temp = DB::table("tbmaster_clomi")
                ->where("mcl_kodeomi", "=", $txt_kdomi)
                ->where("mcl_kodeproxy", "=", $txt_proxy)
                ->count();

            if ($temp != 0) {
                DB::table('tbmaster_clomi')
                    ->where('mcl_kodeomi', '=', $txt_kdomi)
                    ->where('mcl_kodeproxy', '=', $txt_proxy)
                    ->update([
                        'mcl_maxnilaicl' => str_replace($txt_nilaicl, ',', ''),
                        'mcl_tgltop' => DB::raw("to_date('" . $txt_tgltop . "','dd/mm/yyyy')"),
                    ]);
            } else {
                DB::table('tbmaster_clomi')->insert([
                    'mcl_kodeproxy' => $txt_proxy,
                    'mcl_kodemember' => $txt_kdcus,
                    'mcl_kodeomi' => $txt_kdomi,
                    'mcl_maxnilaicl' => str_replace($txt_nilaicl, ',', ''),
                    'mcl_tgltop' => DB::raw("to_date('" . $txt_tgltop . "','dd/mm/yyyy')"),
                    'mcl_create_by' => $_SESSION['usid'],
                    'mcl_create_dt' => DB::raw('sysdate')
                ]);
            }
            DB::table('tbhistory_clomi')->insert([
                'hcl_kodeproxy' => $txt_proxy,
                'hcl_kodemember' => $txt_kdcus,
                'hcl_kodeomi' => $txt_kdomi,
                'hcl_maxnilaicl' => str_replace($txt_nilaicl, ',', ''),
                'hcl_tgl' => DB::raw('sysdate'),
                'hcl_tipetransaksi' => 'M',
                'hcl_nilaitransaksi' => str_replace($txt_nilaicl, ',', ''),
                'hcl_nilaicl' => str_replace($txt_nilaicl, ',', ''),
                'hcl_create_by' => $_SESSION['usid'],
                'hcl_create_dt' => DB::raw('sysdate'),
                'hcl_tgltop' => DB::raw("to_date('" . $txt_tgltop . "','dd/mm/yyyy')"),
            ]);

            if ($txt_proxy == '1') {
                DB::table('tbmaster_customer')
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

//	go_block('TBMASTER_CLOMI');
//	clear_block(no_validate);
//	go_block('TBMASTER_CLOMI');
//	EXECUTE_QUERY;
//
//	go_item('TXT_KDOMI');
    }

    public function getDataTop(Request $request)
    {
        $txt_kdomi = $request->kodeomi;
        $txt_proxy = $request->kodeproxy;

        $temp = DB::table("tbmaster_clomi")
            ->where('mcl_kodeomi', '=', $txt_kdomi)
            ->where("mcl_kodeproxy", "=", $txt_proxy)
            ->count();

        if ($temp <> 0) {
            $data = DB::table("tbmaster_clomi")
                ->select('mcl_maxnilaicl', 'mcl_tgltop')
                ->where('mcl_kodeomi', '=', $txt_kdomi)
                ->where("mcl_kodeproxy", "=", $txt_proxy)
                ->first();
            return compact(['data']);
        }
        return 'no data';
    }

}
