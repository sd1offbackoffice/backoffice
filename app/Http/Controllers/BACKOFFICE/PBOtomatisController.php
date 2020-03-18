<?php

namespace App\Http\Controllers\BACKOFFICE;

use App\AllModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class PBOtomatisController extends Controller
{
    public function index(){
        return view('BACKOFFICE.PBOtomatis', compact('supplier', 'mtrsup', 'departemen'));
    }

    public function getDataModal(){
        $supplier   = DB::table('TBMASTER_SUPPLIER')->select('SUP_NAMASUPPLIER', 'SUP_KODESUPPLIER')->orderBy('sup_namasupplier')->limit(100)->get();
        $mtrsup     = DB::table('TBTR_MONITORINGSUPPLIER')->select('MSU_KODEMONITORING', 'MSU_NAMAMONITORING')->orderBy('MSU_KODEMONITORING')->groupBy(['MSU_KODEMONITORING', 'MSU_NAMAMONITORING'])->get();
        $departemen = DB::table('TBMASTER_DEPARTEMENT')->select('DEP_KODEDEPARTEMENT', 'DEP_NAMADEPARTEMENT')->orderBy('DEP_KODEDEPARTEMENT')->get();

        return response()->json(['supplier' => $supplier, 'mtrsup' => $mtrsup, 'departemen' => $departemen]);
    }

    public function getSupplier(Request $request){
        $search = strtoupper($request->search);

        $supplier   = DB::table('TBMASTER_SUPPLIER')->select('SUP_NAMASUPPLIER', 'SUP_KODESUPPLIER')
            ->where('SUP_NAMASUPPLIER','LIKE', '%'.$search.'%')
            ->orWhere('SUP_KODESUPPLIER','LIKE', '%'.$search.'%')
            ->orderBy('sup_namasupplier')->get()->toArray();

        return response()->json($supplier);
    }

    public function getMtrSupplier(Request $request){
        $search = strtoupper($request->search);

        $mtrsup     = DB::table('TBTR_MONITORINGSUPPLIER')->select('MSU_KODEMONITORING', 'MSU_NAMAMONITORING')
            ->where('MSU_KODEMONITORING','LIKE', '%'.$search.'%')
            ->orWhere('MSU_NAMAMONITORING','LIKE', '%'.$search.'%')
            ->orderBy('MSU_KODEMONITORING')->groupBy(['MSU_KODEMONITORING', 'MSU_NAMAMONITORING'])->get()->toArray();

        return response()->json($mtrsup);
    }

    public function getDepartemen(Request $request){
        $search = strtoupper($request->search);

        $departemen = DB::table('TBMASTER_DEPARTEMENT')->select('DEP_KODEDEPARTEMENT', 'DEP_NAMADEPARTEMENT')
            ->where('DEP_KODEDEPARTEMENT','LIKE', '%'.$search.'%')
            ->orWhere('DEP_NAMADEPARTEMENT','LIKE', '%'.$search.'%')
            ->orderBy('DEP_KODEDEPARTEMENT')->get()->toArray();

        return response()->json($departemen);
    }

    public function getKategori(Request $request){
        $dep1   = $request->dept1;
        $dep2   = $request->dept2;

        $kategori = DB::table('TBMASTER_KATEGORI')->select('KAT_KODEDEPARTEMENT', 'KAT_KODEKATEGORI', 'KAT_NAMAKATEGORI')
            ->whereBetween('KAT_KODEDEPARTEMENT',[$dep1,$dep2])
            ->orderBy('KAT_KODEDEPARTEMENT')
            ->orderBy('KAT_KODEKATEGORI')
            ->get()->toArray();

        return response()->json($kategori);
    }

    public function searchKategori(Request $request){
        $dep1   = $request->dept1;
        $dep2   = $request->dept2;
        $search = strtoupper($request->search);

        $kategori = DB::table('TBMASTER_KATEGORI')->select('KAT_KODEDEPARTEMENT', 'KAT_KODEKATEGORI', 'KAT_NAMAKATEGORI')
            ->whereBetween('KAT_KODEDEPARTEMENT',[$dep1,$dep2])
            ->where('KAT_KODEKATEGORI','LIKE', '%'.$search.'%')
            ->orWhere('KAT_NAMAKATEGORI','LIKE', '%'.$search.'%')
            ->orderBy('KAT_KODEDEPARTEMENT')
            ->orderBy('KAT_KODEKATEGORI')
            ->get()->toArray();

        return response()->json($kategori);
    }

    public function prosesData(Request $request){
        $sup1   = $request->sup1;
        $sup2   = $request->sup2;
        $dept1  = $request->dept1;
        $dept2  = $request->dept2;
        $kat1   = $request->kat1;
        $kat2   = $request->kat2;
        $mtrSup = $request->mtrSup;
        $tipe   = $request->tipePB;
        $kodeigr= $_SESSION['kdigr'];
        $userid = $_SESSION['usid'];
        $sessid = $_SESSION['id'];
        $ppn    = $_SESSION['ppn'];
        $model  = new AllModel();
        $conn   = $model->connectionProcedure();
        $date   = date('d-M-y');

        if ($mtrSup == null) { $mtrSup  = ' '; }
        if ($dept1  == null) { $dept1   = ' '; }
        if ($dept2  == null) { $dept2   = 'ZZ'; }
        if ($kat1   == null) { $kat1    = ' '; }
        if ($kat2   == null) { $kat2    = 'ZZ'; }
        if ($sup1   == null) { $sup1    = ' '; }
        if ($sup2   == null) { $sup2    = 'ZZZZZ'; }

        $a = [$sup1,$sup2,$dept1,$dept2,$kat1,$kat2,$mtrSup,$tipe,$ppn,$date,$kodeigr,$userid,$sessid];

//        dd($a);

        $sup_cur    = DB::table('tbmaster_supplier')->select('sup_kodesupplier', 'sup_namasupplier')
            ->whereBetween('sup_kodesupplier', [$sup1,$sup2])
            ->whereNotIn('sup_flagdiscontinuesupplier', ['Y'])
            ->get()->toArray();

        //****Call Function****
        $p_nopb = oci_parse($conn, "BEGIN :ret := f_igr_get_nomor('$kodeigr','PB','Nomor Permintaan Barang','$kodeigr'
							|| TO_CHAR (SYSDATE, 'yyMM'),
							3,TRUE); END;");
        oci_bind_by_name($p_nopb, ':ret', $result, 32);
        oci_execute($p_nopb);
        $nomorPB    = $result;

        //****Call Procedure****
        $exec = oci_parse($conn, "BEGIN sp_create_pb_otomatis_by_sup2(:sessionid, :classigr, :date, :kodeigr, :tipe, :ppn, :userid, :mtrsup, :dept1, :dept2, :kat1, :kat2, :sup1, :sup2, :pnobp, :sukses,:errtext); END;");
        oci_bind_by_name($exec, ':sessionid',$sessid);
        oci_bind_by_name($exec, ':classigr',$kodeigr);
        oci_bind_by_name($exec, ':date',$date);
        oci_bind_by_name($exec, ':kodeigr',$kodeigr);
        oci_bind_by_name($exec, ':tipe',$tipe);
        oci_bind_by_name($exec, ':ppn', $ppn);
        oci_bind_by_name($exec, ':userid',$userid);
        oci_bind_by_name($exec, ':mtrsup',$mtrSup);
        oci_bind_by_name($exec, ':dept1', $dept1);
        oci_bind_by_name($exec, ':dept2', $dept2);
        oci_bind_by_name($exec, ':kat1', $kat1);
        oci_bind_by_name($exec, ':kat2', $kat2);
        oci_bind_by_name($exec, ':sup1', $sub1);
        oci_bind_by_name($exec, ':sup2', $sub2);
        oci_bind_by_name($exec, ':pnobp', $nomorPB);
        oci_bind_by_name($exec, ':sukses', $sukses,1000);
        oci_bind_by_name($exec, ':errtext', $errm,1000);
        oci_execute($exec);

        dd($sukses);

        if ($sukses == 'TRUE'){
            $kode   = 1;
            $msg    = 'Proses PB otomatis berhasil! Nomor PB : '. $nomorPB;

            $temp1  = DB::table('temp_go')->select('isi_toko', 'per_awal_pdisc_go', 'per_akhir_pdisc_go')->where('kodeigr', $kodeigr)->get()->toArray();

            if ($temp1[0]->isi_toko == 'Y' && (date('Y-m-d', strtotime($date >= $temp1[0]->per_awal_pdisc_go)) && date('Y-m-d', strtotime($date >= $temp1[0]->per_akhir_pdisc_go)) )){
                DB::table('tbtr_pb_d')->where('pbd_nopb', $nomorPB)->update(['pbd_fdxrev' => 'T']);
            }

            $temp2  = DB::table('tbtr_tolakanpb')->whereRaw('TRUNC(tlk_create_dt) = TRUNC(SYSDATE)')->get()->toArray();

//            if (sizeof($temp2) > 0){
//                cetak;
//            }
        } else {
            $kode   = 0;
            $msg    = 'Proses PB otomatis GAGAL! --> '. $errm;
        }


        return response()->json(['kode' => $kode, 'msg' => $msg]);
    }
}


