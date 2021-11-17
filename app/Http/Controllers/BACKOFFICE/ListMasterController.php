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
}
