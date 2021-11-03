<?php

namespace App\Http\Controllers\BACKOFFICE;

use App\AllModel;
use Yajra\DataTables\DataTables;
use function foo\func;
use PDF;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class PBOtomatisController extends Controller
{
    public function index(){
        $mtrsup     = DB::table('TBTR_MONITORINGSUPPLIER')->select('MSU_KODEMONITORING', 'MSU_NAMAMONITORING')->orderBy('MSU_KODEMONITORING')->groupBy(['MSU_KODEMONITORING', 'MSU_NAMAMONITORING'])->get();
        $departemen = DB::table('TBMASTER_DEPARTEMENT')->select('DEP_KODEDEPARTEMENT', 'DEP_NAMADEPARTEMENT')->orderBy('DEP_KODEDEPARTEMENT')->get();

        return view('BACKOFFICE.PBOtomatis', compact('supplier', 'mtrsup', 'departemen'));
    }

    public function getDataModalSupplier(Request  $request) {
        $search = $request->value;

        $supplier = DB::table('TBMASTER_SUPPLIER')
            ->select('SUP_NAMASUPPLIER', 'SUP_KODESUPPLIER')
            ->where('sup_kodesupplier','LIKE', '%'.$search.'%')
            ->orWhere('sup_namasupplier','LIKE', '%'.$search.'%')
            ->orderBy('sup_namasupplier')
            ->limit(100)->get();

        return Datatables::of($supplier)->make(true);
    }

    public function getKategori(Request $request){
        $dep1   = $request->dept1;
        $dep2   = $request->dept2;

        $kategori = DB::table('TBMASTER_KATEGORI')->select('KAT_KODEDEPARTEMENT', 'KAT_KODEKATEGORI', 'KAT_NAMAKATEGORI')
            ->whereBetween('KAT_KODEDEPARTEMENT',[$dep1,$dep2])
            ->orderBy('KAT_KODEDEPARTEMENT')
            ->orderBy('KAT_KODEKATEGORI')
            ->get()->toArray();

        return Datatables::of($kategori)->make(true);
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
        oci_bind_by_name($exec, ':sup1', $sup1);
        oci_bind_by_name($exec, ':sup2', $sup2);
        oci_bind_by_name($exec, ':pnobp', $nomorPB);
        oci_bind_by_name($exec, ':sukses', $sukses,1000);
        oci_bind_by_name($exec, ':errtext', $errm,1000);
        oci_execute($exec);

        if ($sukses == 'TRUE'){
            $kode   = 1;
            $msg    = 'Proses PB otomatis berhasil! Nomor PB : '. $nomorPB;

            $temp1  = DB::table('temp_go')->select('isi_toko', 'per_awal_pdisc_go', 'per_akhir_pdisc_go')->where('kodeigr', $kodeigr)->get()->toArray();

            if ($temp1[0]->isi_toko == 'Y' && (date('Y-m-d', strtotime($date >= $temp1[0]->per_awal_pdisc_go)) && date('Y-m-d', strtotime($date >= $temp1[0]->per_akhir_pdisc_go)) )){
                DB::table('tbtr_pb_d')->where('pbd_nopb', $nomorPB)->update(['pbd_fdxrev' => 'T']);
            }

            $temp2  = DB::table('tbtr_tolakanpb')->whereRaw('TRUNC(tlk_create_dt) = TRUNC(SYSDATE)')->get()->toArray();

            if (sizeof($temp2) > 0){
                if ($sup1   == ' ') { $sup1    = 'null'; }
//                $this->cetakReport($kodeigr,$date,$date,$sup1,$sup2);
                $temp = [$kodeigr,$date,$date,$sup1,$sup2];
                return response()->json(['kode' => 2, 'msg' => $msg, 'param'=>$temp]);
            }
        } else {
            $kode   = 0;
            $msg    = 'Proses PB otomatis GAGAL! --> '. $errm;
            return response()->json(['kode' => $kode, 'msg' => $msg]);
        }

        return response()->json(['kode' => $kode, 'msg' => $msg]);
    }

//    public function cetakReport($kodeigr, $tgl1, $tgl2, $sup1, $sup2){
    public function cetakReport(Request $request){
//        $kodeigr = '22';
//        $tgl1 = '2020/03/01';
//        $tgl2 = '2020/03/18';
//        $sup1 = ' ';
//        $sup2 = 'ZZZZZ';

        $kodeigr    = $request->kodeigr;
        $tgl1       = $request->date1;
        $tgl2       = $request->date2;
        $sup1       = $request->sup1;
        $sup2       = $request->sup2;

        if ($sup1   == 'null') { $sup1    = ' '; }

        $datas  = DB::table('TBMASTER_PERUSAHAAN')
            ->selectRaw("PRS_KODEIGR, PRS_NAMAPERUSAHAAN, PRS_NAMACABANG, TRUNC (TLK_TGLPB) TGLPB, TLK_NOPB NOPB,
                                   PRD_KODEDIVISI DIV, DIV_NAMADIVISI DIVNAME, PRD_KODEDEPARTEMENT DEP,
                                   DEP_NAMADEPARTEMENT DEPNAME, PRD_KODEKATEGORIBARANG KAT, KAT_NAMAKATEGORI KATNAME,
                                   TLK_PRDCD PRDCD, PRD_DESKRIPSIPANJANG DESKRIPSI, PRD_UNIT || '/' || PRD_FRAC SATUAN,
                                   PRD_KODETAG TAG, TLK_KODESUPPLIER SUPCO, SUP_NAMASUPPLIER SUPNAME, PKM_PKMT PKMT,
                                   TLK_KETERANGANTOLAKAN")
            ->join('tbtr_tolakanpb',  'tlk_kodeigr','=', 'prs_kodeigr')
            ->join('TBMASTER_PRODMAST', function($join){
                $join->on('prd_prdcd', '=', 'tlk_prdcd')
                    ->on( 'prd_kodeigr', '=', 'tlk_kodeigr');
            })
            ->join('TBMASTER_DIVISI', function ($join){
                $join->on('prd_kodedivisi', '=', 'div_kodedivisi');

            })
            ->join('TBMASTER_DEPARTEMENT', function ($join){
                $join->on('prd_kodedepartement', '=', 'dep_kodedepartement')
                    ->on('prd_kodedivisi', '=', 'dep_kodedivisi')
                    ->on('prd_kodedepartement', '=', 'dep_kodedepartement');
            })
            ->join('TBMASTER_KATEGORI', function ($join){
                $join ->on('prd_kodedepartement', '=', 'kat_kodedepartement')
                    ->on('prd_kodekategoribarang', '=', 'kat_kodekategori');
            })
            ->join('TBMASTER_SUPPLIER', function ($join){
                $join->on('tlk_kodeigr', '=', 'sup_kodeigr')
                    ->on('tlk_kodesupplier', '=', 'sup_kodesupplier');
            })
            ->join('TBMASTER_KKPKM', function ($join){
                $join->on('prd_kodeigr', '=', 'pkm_kodeigr')
                    ->on('prd_kodedivisi', '=', 'pkm_kodedivisi')
                    ->on('prd_kodedepartement', '=', 'pkm_kodedepartement')
                    ->on('prd_kodekategoribarang', '=', 'pkm_kodekategoribarang')
                    ->on('prd_prdcd', '=', 'pkm_prdcd');
            })
            ->where('prs_kodeigr', $kodeigr)
            ->whereRaw("trunc (tlk_tglpb) between '$tgl1' and '$tgl2'")
            ->whereBetween('tlk_kodesupplier', [$sup1, $sup2])
            ->where('tlk_keterangantolakan', 'not like', 'STATUS%')
            ->where('tlk_keterangantolakan', 'not like', '%PKM')
            ->orderBy('prd_prdcd')
            ->get()->toArray();


        $pdf = PDF::loadview('BACKOFFICE.PBOtomatis-laporan', ['datas' => $datas, 'date1' => $tgl1, 'date2' => $tgl2]);
        $pdf->output();
        $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);

        $canvas = $dompdf ->get_canvas();
        $canvas->page_text(490, 10, "Page {PAGE_NUM} of {PAGE_COUNT}", null, 10, array(0, 0, 0));

        return $pdf->stream('PBOtomatis-laporan.pdf');

    }
}


