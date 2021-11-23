<?php
/**
 * Created by PhpStorm.
 * User: ryan
 * Date: 4/11/2021
 * Time: 13:05 PM
 */

namespace App\Http\Controllers\BACKOFFICE;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use PDF;
use DateTime;
use Yajra\DataTables\DataTables;

class ListMasterController extends Controller
{

    public function index()
    {
        return view('BACKOFFICE.list-master');
    }

    public function getLovDivisi()
    {
        $kodeigr = $_SESSION['kdigr'];

        $datas = DB::connection($_SESSION['connection'])->table('tbmaster_divisi')
            ->selectRaw('div_namadivisi')
            ->selectRaw('trim(div_kodedivisi) div_kodedivisi')
            ->where('div_kodeigr','=',$kodeigr)
            ->get();

        return Datatables::of($datas)->make(true);
    }

    public function getLovDepartemen()
    {
        $kodeigr = $_SESSION['kdigr'];

        $datas = DB::connection($_SESSION['connection'])->table('tbmaster_departement')
            ->selectRaw('dep_namadepartement')
            ->selectRaw('dep_kodedepartement')
            ->selectRaw('dep_kodedivisi')
            ->where('dep_kodeigr','=',$kodeigr)
            ->orderByRaw("dep_kodedivisi, dep_kodedepartement")
            ->get();

        return Datatables::of($datas)->make(true);
    }

    public function getLovKategori()
    {
        $kodeigr = $_SESSION['kdigr'];

        $datas = DB::connection($_SESSION['connection'])->table('tbmaster_kategori')
            ->selectRaw('kat_namakategori')
            ->selectRaw('kat_kodekategori')
            ->selectRaw('kat_kodedepartement')
            ->where('kat_kodeigr','=',$kodeigr)
            ->orderByRaw("kat_kodedepartement, kat_kodekategori")
            ->get();

        return Datatables::of($datas)->make(true);
    }

    public function getLovSupplier()
    {
        $kodeigr = $_SESSION['kdigr'];

        $datas = DB::connection($_SESSION['connection'])->table('tbmaster_supplier')
            ->selectRaw('sup_namasupplier')
            ->selectRaw('sup_kodesupplier')
            ->where('sup_kodeigr','=',$kodeigr)
            ->orderByRaw("sup_kodesupplier")
            ->get();

        return Datatables::of($datas)->make(true);
    }

    public function getLovMember(Request $request)
    {
        $kodeigr = $_SESSION['kdigr'];
        $search = $request->value;

        $datas = DB::connection($_SESSION['connection'])->table('tbmaster_customer')
            ->selectRaw('cus_namamember')
            ->selectRaw('cus_kodemember')
            ->where("cus_namamember",'LIKE', '%'.$search.'%')
            ->where('cus_kodeigr','=',$kodeigr)

            ->orWhere("cus_kodemember",'LIKE', '%'.$search.'%')
            ->where('cus_kodeigr','=',$kodeigr)
            ->limit(1000)
            ->get();

        return Datatables::of($datas)->make(true);
    }
    public function checkMember(Request $request)
    {
        $kodeigr = $_SESSION['kdigr'];
        $search = $request->value;

        $data = DB::connection($_SESSION['connection'])->table('tbmaster_customer')
            ->selectRaw('cus_namamember')
            ->where("cus_kodemember",'=', $search)
            ->where('cus_kodeigr','=',$kodeigr)
            ->first();
        if($data){
            $result = $data->cus_namamember;
        }else{
            $result = "false";
        }

        return response()->json($result);
    }
    public function getLovMemberWithDate(Request $request)
    {
        $kodeigr = $_SESSION['kdigr'];
        $dateA = $request->dateA;
        $dateB = $request->dateB;
        $sDate = DateTime::createFromFormat('d-m-Y', $dateA)->format('d-m-Y');
        $eDate = DateTime::createFromFormat('d-m-Y', $dateB)->format('d-m-Y');

        $datas = DB::connection($_SESSION['connection'])->table('tbmaster_customer')
            ->selectRaw('cus_namamember')
            ->selectRaw('cus_kodemember')
            ->where('cus_kodeigr','=',$kodeigr)
            ->whereRaw("cus_tglregistrasi between TO_DATE('$sDate','DD-MM-YYYY') and TO_DATE('$eDate','DD-MM-YYYY')")
            ->orderBy("cus_namamember")
            ->get();

        return Datatables::of($datas)->make(true);
    }

    public function getLovOutlet()
    {
        $kodeigr = $_SESSION['kdigr'];

        $datas = DB::connection($_SESSION['connection'])->table('tbmaster_outlet')
            ->selectRaw('out_namaoutlet')
            ->selectRaw('out_kodeoutlet')
            ->where('out_kodeigr','=',$kodeigr)
            ->orderByRaw("out_kodeoutlet")
            ->get();

        return Datatables::of($datas)->make(true);
    }

    public function getLovSubOutlet()
    {
        $kodeigr = $_SESSION['kdigr'];

        $datas = DB::connection($_SESSION['connection'])->table('tbmaster_suboutlet')
            ->selectRaw('sub_namasuboutlet')
            ->selectRaw('sub_kodesuboutlet')
            ->selectRaw("sub_kodeoutlet")
            ->where('sub_kodeigr','=',$kodeigr)
            ->orderByRaw("sub_kodeoutlet, sub_kodesuboutlet")
            ->get();

        return Datatables::of($datas)->make(true);
    }

    public function getLovPlu(Request $request)
    {
        $kodeigr = $_SESSION['kdigr'];
        $search = $request->value;

        $datas = DB::connection($_SESSION['connection'])->table('tbmaster_prodmast')
            ->selectRaw('prd_deskripsipanjang')
            ->selectRaw('prd_prdcd')
            ->where("prd_deskripsipanjang",'LIKE', '%'.$search.'%')
            ->where('prd_kodeigr','=',$kodeigr)

            ->orWhere("prd_prdcd",'LIKE', '%'.$search.'%')
            ->where('prd_kodeigr','=',$kodeigr)
            ->limit(1000)
            ->get();

        return Datatables::of($datas)->make(true);
    }

    public function getLovPluCustom(Request $request)
    {
        $kodeigr = $_SESSION['kdigr'];
        $div1 = $request->div1;
        $div2 = $request->div2;
        $whereDiv = "";

        $dep1 = $request->dep1;
        $dep2 = $request->dep2;
        $whereDep = "";

        $kat1 = $request->kat1;
        $kat2 = $request->kat2;
        $whereKat = "";

        if($div1 != ''){
            if($div2 != ''){
                $whereDiv = "prd_kodedivisi between ".$div1." and ".$div2;
            }else{
                $whereDiv = "prd_kodedivisi >= ".$div1;
            }
        }

        if($dep1 != ''){
            if($dep2 != ''){
                $whereDep = "prd_kodedepartement between ".$dep1." and ".$dep2;
            }else{
                $whereDiv = "prd_kodedepartement >= ".$div1;
            }
        }
        if($whereDiv != "" && $whereDep != ""){
            $whereDep = " and ".$whereDep;
        }

        if($kat1 != ''){
            if($kat2 != ''){
                $whereKat = "prd_kodekategoribarang between ".$kat1." and ".$kat2;
            }else{
                $whereKat = "prd_kodekategoribarang >= ".$kat1;
            }
        }
        if($whereDep != "" && $whereKat != ""){
            $whereKat = " and ".$whereKat;
        }

        $datas = DB::connection($_SESSION['connection'])->table('tbmaster_prodmast')
            ->selectRaw('prd_deskripsipanjang')
            ->selectRaw('prd_prdcd')
            ->where('prd_kodeigr','=',$kodeigr)
            ->whereRaw($whereDiv.$whereDep.$whereKat)
            ->get();

        return Datatables::of($datas)->make(true);
    }

    public function checkPlu(Request $request)
    {
        $kodeigr = $_SESSION['kdigr'];
        $search = $request->value;

        $data = DB::connection($_SESSION['connection'])->table('tbmaster_prodmast')
            ->selectRaw('prd_deskripsipanjang')
            ->selectRaw("prd_kodedivisi, prd_kodedepartement, prd_kodekategoribarang")
            ->where("prd_prdcd",'=', $search)
            ->where('prd_kodeigr','=',$kodeigr)
            ->first();
        if($data){
            $result = $data;
        }else{
            $result = "false";
        }

        return response()->json($result);
    }

    public function getLovRak()
    {
        $kodeigr = $_SESSION['kdigr'];

        $datas = DB::connection($_SESSION['connection'])->table('tbmaster_lokasi')
            ->selectRaw('DISTINCT lks_koderak')
            ->selectRaw('lks_tiperak')
            ->selectRaw('lks_kodesubrak')
            ->selectRaw('lks_shelvingrak')
            ->where('lks_kodeigr','=',$kodeigr)
            ->orderBy("lks_koderak")
            ->get();

        return Datatables::of($datas)->make(true);
    }

    // ### FUNGSI-FUNGSI PRINT/CETAK ###

}
