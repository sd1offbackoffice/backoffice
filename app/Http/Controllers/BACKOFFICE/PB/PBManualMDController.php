<?php

namespace App\Http\Controllers\BACKOFFICE\PB;

use App\Http\Controllers\Auth\loginController;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller; use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Mockery\Exception;
use Symfony\Component\VarDumper\Cloner\Data;
use Yajra\DataTables\DataTables;

class PBManualMDController extends Controller
{
    public function index()
    {
        return view('BACKOFFICE.PB.pb-manual-md');
    }

    public function getProductList(Request $request){
        $search = $request->plu;

        if($search == ''){
            $produk = DB::connection(Session::get('connection'))->table(DB::connection(Session::get('connection'))->raw("tbmaster_prodmast"))
                ->select('prd_deskripsipanjang','prd_prdcd')
                ->where('prd_kodeigr',Session::get('kdigr'))
                ->whereRaw("substr(prd_prdcd,7,1) = '0'")
                ->orderBy('prd_prdcd')
                ->limit(100)
                ->get();
        }
        else if(is_numeric($search)){
            $produk = DB::connection(Session::get('connection'))->table(DB::connection(Session::get('connection'))->raw("tbmaster_prodmast"))
                ->select('prd_deskripsipanjang','prd_prdcd')
                ->where('prd_kodeigr',Session::get('kdigr'))
                ->whereRaw("substr(prd_prdcd,7,1) = '0'")
                ->where('prd_prdcd','like',DB::connection(Session::get('connection'))->raw("'%".$search."%'"))
                ->orderBy('prd_prdcd')
                ->get();
        }
        else{
            $produk = DB::connection(Session::get('connection'))->table(DB::connection(Session::get('connection'))->raw("tbmaster_prodmast"))
                ->select('prd_deskripsipanjang','prd_prdcd')
                ->where('prd_kodeigr',Session::get('kdigr'))
                ->whereRaw("substr(prd_prdcd,7,1) = '0'")
                ->where('prd_deskripsipanjang','like',DB::connection(Session::get('connection'))->raw("'%".$search."%'"))
                ->orderBy('prd_prdcd')
                ->get();
        }

        return DataTables::of($produk)->make(true);
    }

    public function getPBProduct(Request $request){
        $tgl1 = $request->tgl1;
        $tgl2 = $request->tgl2;

//        SELECT ppb_prdcd,
//                    prd_deskripsipanjang,
//                    prd_unit || '-' || TO_CHAR (prd_frac, '9999') unitfrac
//               FROM tbmaster_produk_pb, tbmaster_prodmast
//              WHERE     ppb_tglawal = :txt_periode1
//        AND ppb_tglakhir = :txt_periode2 and nvl(ppb_flag, '0') <> '1'
//        AND prd_prdcd = ppb_prdcd

        $data = DB::connection(Session::get('connection'))
            ->table('tbmaster_produk_pb')
            ->join('tbmaster_prodmast','ppb_prdcd','=','prd_prdcd')
            ->selectRaw("ppb_prdcd plu, prd_deskripsipanjang deskripsi, prd_unit || '/' || prd_frac satuan")
            ->whereDate('ppb_tglawal','=',Carbon::createFromFormat('d/m/Y',$tgl1))
            ->whereDate('ppb_tglakhir','=',Carbon::createFromFormat('d/m/Y',$tgl2))
            ->whereRaw("nvl(ppb_flag, '0') <> '1'")
            ->get();

//        return DataTables::of($data)->make(true);
        return response()->json($data, 200);
    }

    public function getProductDetail(Request $request){
        $tgl1 = $request->tgl1;
        $tgl2 = $request->tgl2;
        $plu = $request->plu;

        $data = DB::connection(Session::get('connection'))
            ->table('tbmaster_prodmast')
            ->selectRaw("prd_prdcd plu, prd_deskripsipanjang deskripsi, prd_unit || '/' || prd_frac satuan, prd_kodetag")
            ->where('prd_prdcd','=',$plu)
            ->first();

        if(!$data){
            return response()->json([
                'message' => 'Data Master Produk tidak ada!'
            ], 500);
        }

        if(in_array($data->prd_kodetag, ['H','A','G','I','B','Q','U','N','X','O','T'])){
            return response()->json([
                'message' => 'Tag '.$data->prd_kodetag.', tidak bisa order!'
            ], 500);
        }

        $pb = DB::connection(Session::get('connection'))
            ->table('tbmaster_produk_pb')
            ->whereDate('ppb_tglawal','=',Carbon::createFromFormat('d/m/Y',$tgl1))
            ->whereDate('ppb_tglakhir','=',Carbon::createFromFormat('d/m/Y',$tgl2))
            ->whereRaw("nvl(ppb_flag, '0') <> '1'")
            ->where('ppb_prdcd','=',$plu)
            ->first();

        if($pb){
            return response()->json([
                'message' => 'Data Master Produk PB sudah ada!'
            ], 500);
        }

        return response()->json($data, 200);
    }

    public function savePBData(Request $request){
        $tgl1 = $request->tgl1;
        $tgl2 = $request->tgl2;
        $plu = $request->plu;

        try{
            DB::connection(Session::get('connection'))->beginTransaction();

            foreach($plu as $p){
                $temp = DB::connection(Session::get('connection'))
                    ->table('tbmaster_prodmast')
                    ->select('prd_kodetag')
                    ->where('prd_prdcd','=',$p)
                    ->first();

                if(!$temp){
                    return response()->json([
                        'message' => 'Data Master Produk '.$p.' tidak ada!'
                    ], 500);
                }

                if(in_array($temp->prd_kodetag, ['H','A','G','I','B','Q','U','N','X','O','T'])){
                    return response()->json([
                        'message' => 'Tag '.$temp->prd_kodetag.', tidak bisa order!'
                    ], 500);
                }
            }

            DB::connection(Session::get('connection'))
                ->table('tbmaster_produk_pb')
                ->whereDate('ppb_tglawal','=',Carbon::createFromFormat('d/m/Y',$tgl1))
                ->whereDate('ppb_tglakhir','=',Carbon::createFromFormat('d/m/Y',$tgl2))
                ->update([
                    'ppb_flag' => '1'
                ]);

            foreach($plu as $p){
                DB::connection(Session::get('connection'))
                    ->table('tbmaster_produk_pb')
                    ->insert([
                        'ppb_kodeigr' => Session::get('kdigr'),
                        'ppb_tglawal' => Carbon::createFromFormat('d/m/Y',$tgl1)->format('Y/m/d'),
                        'ppb_tglakhir' => Carbon::createFromFormat('d/m/Y',$tgl2)->format('Y/m/d'),
                        'ppb_prdcd' => $p,
                        'ppb_create_by' => Session::get('usid'),
                        'ppb_create_dt' => Carbon::now()
                    ]);
            }

            DB::connection(Session::get('connection'))->commit();

            return response()->json([
                'message' => 'Data PLU sudah disimpan!'
            ], 200);
        }
        catch (\Exception $e){
            DB::connection(Session::get('connection'))->rollBack();

            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function printItem(Request $request){
        $tgl1 = $request->tgl1;
        $tgl2 = $request->tgl2;

        $perusahaan = DB::connection(Session::get('connection'))
            ->table('tbmaster_perusahaan')
            ->first();

        $data = DB::connection(Session::get('connection'))
            ->table('tbmaster_produk_pb')
            ->join('tbmaster_prodmast','ppb_prdcd','=','prd_prdcd')
            ->selectRaw("ppb_prdcd plu, prd_deskripsipanjang deskripsi, to_char(ppb_tglawal,'dd/mm/yyyy') tglawal,
            to_char(ppb_tglakhir,'dd/mm/yyyy') tglakhir, to_char(ppb_create_dt,'dd/mm/yyyy') ppb_create_dt, ppb_create_by")
            ->whereDate('ppb_tglawal','=',Carbon::createFromFormat('d/m/Y',$tgl1))
            ->whereDate('ppb_tglakhir','=',Carbon::createFromFormat('d/m/Y',$tgl2))
            ->whereRaw("nvl(ppb_flag, '0') <> '1'")
            ->get();

        return view('BACKOFFICE.PB.pb-list-pdf',compact(['perusahaan','data','tgl1','tgl2']));
    }

    public function printProses(Request $request){
        $tgl1 = $request->tgl1;
        $tgl2 = $request->tgl2;

        $perusahaan = DB::connection(Session::get('connection'))
            ->table('tbmaster_perusahaan')
            ->first();

//        SELECT prs_namaperusahaan, prs_namacabang, pdm_kodedivisi,
//       pdm_kodedepartement,
//       pdm_kodekategoribrg,
//       pdm_prdcd,
//       prd_deskripsipanjang,
//       pdm_kodesupplier,
//       sup_namasupplier,
//       prd_frac,
//       pdm_pkmt,
//       pdm_saldoakhir,
//       pdm_nodraft,
//       pdm_create_dt,
//       (pdm_qtypb + pdm_saldoakhir) qty_input,
//       pdm_qtypb,
//       pdm_create_by,
//       phm_nopb,
//       phm_tglpb,
//       phm_approval
//  FROM tbmaster_perusahaan,
//       tbtr_pbm_h,
//       tbtr_pbm_d,
//       tbmaster_supplier,
//       tbmaster_prodmast
// WHERE     NVL (phm_recordid, '0') = '2' and to_char(phm_create_dt, 'yyyyMMdd') >= :p_periode1 and to_char(phm_create_dt, 'yyyyMMdd') <= :p_periode2
//        AND prs_kodeigr = :p_kodeigr
//        AND phm_kodeigr = :p_kodeigr
//        AND pdm_nodraft = phm_nodraft
//        AND sup_kodesupplier = pdm_kodesupplier
//        AND prd_prdcd = pdm_prdcd
//order by pdm_kodedivisi,
//       pdm_kodedepartement,
//       pdm_kodekategoribrg, pdm_prdcd, pdm_kodesupplier, pdm_nodraft, phm_nopb

        $data = DB::connection(Session::get('connection'))
            ->table('tbtr_pbm_h')
            ->join('tbtr_pbm_d','phm_nodraft','=','pdm_nodraft')
            ->join('tbmaster_prodmast','prd_prdcd','=','pdm_prdcd')
            ->join('tbmaster_supplier','sup_kodesupplier','=','pdm_kodesupplier')
            ->selectRaw("pdm_kodedivisi,
               pdm_kodedepartement,
               pdm_kodekategoribrg,
               pdm_prdcd,
               prd_deskripsipanjang,
               pdm_kodesupplier,
               sup_namasupplier,
               prd_frac,
               pdm_pkmt,
               pdm_saldoakhir,
               pdm_nodraft,
               pdm_create_dt,
               (pdm_qtypb + pdm_saldoakhir) qty_input,
               pdm_qtypb,
               pdm_create_by,
               phm_nopb,
               phm_tglpb,
               phm_approval")
            ->whereDate('phm_create_dt','>=',Carbon::createFromFormat('d/m/Y',$tgl1))
            ->whereDate('phm_create_dt','<=',Carbon::createFromFormat('d/m/Y',$tgl2))
            ->whereRaw("nvl(phm_recordid, '0') = '2'")
            ->get();

//        dd($data);

        return view('BACKOFFICE.PB.pb-proses-pdf',compact(['perusahaan','data','tgl1','tgl2']));
    }

    public function getPBDraftList(){
        $data = DB::connection(Session::get('connection'))
            ->table('tbtr_pbm_h')
            ->selectRaw("phm_nodraft, phm_tgldraft, to_char(phm_tgldraft,'dd/mm/yyyy') tgldraft, phm_keteranganpb, phm_nopb, to_char(phm_tglpb,'dd/mm/yyyy') phm_tglpb, phm_approval")
            ->where('phm_kodeigr','=',Session::get('kdigr'))
            ->whereRaw("nvl(phm_recordid,'0') <> '1'")
            ->orderBy('phm_tgldraft','desc')
            ->orderBy('phm_nodraft','desc')
            ->get();

        return DataTables::of($data)->make(true);
    }

    public function getPBDraftDetail(Request $request){
        $no = $request->no;

        $header = DB::connection(Session::get('connection'))
            ->table('tbtr_pbm_h')
//            ->join('tbtr_pbm_d','phm_nodraft','=','pdm_nodraft')
            ->selectRaw("phm_nodraft, to_char(phm_tgldraft,'dd/mm/yyyy') phm_tgldraft,
                phm_keteranganpb, phm_nopb, phm_approval, nvl(phm_recordid,0) phm_recordid")
            ->whereRaw("nvl(phm_flagdoc,'0') <> '1'")
            ->where('phm_nodraft','=',$no)
            ->first();

        $detail = DB::connection(Session::get('connection'))
            ->table('tbtr_pbm_d')
            ->join('tbmaster_prodmast','prd_prdcd','=','pdm_prdcd')
            ->join('tbmaster_supplier','sup_kodesupplier','=','pdm_kodesupplier')
            ->leftJoin('tbmaster_maxpalet','mpt_prdcd','=','pdm_prdcd')
            ->join('tbmaster_hargabeli','hgb_prdcd','=','pdm_prdcd')
            ->selectRaw("
                pdm_prdcd,
                prd_minorder,
                prd_isibeli,
                prd_frac,
                sup_minrph,
                mpt_maxqty,
                pdm_qtypb,
                pdm_hrgsatuan,
                pdm_rphdisc1,
                pdm_persendisc1,
                pdm_rphdisc2,
                pdm_persendisc2,
                pdm_bonuspo1,
                pdm_bonuspo2,
                pdm_gross,
                pdm_ppn,
                pdm_ppnbm,
                pdm_ppnbotol,
                prd_deskripsipanjang,
                prd_unit,
                prd_frac,
                sup_kodesupplier,
                sup_namasupplier,
                prd_hrgjual,
                pdm_pkmt,
                pdm_saldoakhir,
                hgb_flagkelipatanbonus01,
                hgb_flagkelipatanbonus02,
                hgb_tglmulaibonus01,
                hgb_tglakhirbonus01,
                hgb_tglmulaibonus02,
                hgb_tglakhirbonus01,
                hgb_qtymulai1bonus01,
                hgb_qtymulai2bonus01,
                hgb_qtymulai3bonus01,
                hgb_qtymulai4bonus01,
                hgb_qtymulai5bonus01,
                hgb_qtymulai6bonus01,
                hgb_qtymulai1bonus02,
                hgb_qtymulai2bonus02,
                hgb_qtymulai3bonus02,
                hgb_qty1bonus01,
                hgb_qty2bonus01,
                hgb_qty3bonus01,
                hgb_qty4bonus01,
                hgb_qty5bonus01,
                hgb_qty6bonus01,
                hgb_qty1bonus02,
                hgb_qty2bonus02,
                hgb_qty3bonus02,
                hgb_jenisbonus
            ")
            ->where('pdm_nodraft','=',$no)
            ->where('hgb_tipe','=','2')
            ->whereNull('hgb_recordid')
//            ->where('pdm_prdcd','=','1323810')
            ->get();

        foreach($detail as $d){
            $d->omi = 'N';
            $d->idm = 'N';

            $omi = DB::connection(Session::get('connection'))
                ->table('tbmaster_prodcrm')
                ->where('prc_kodeigr','=',Session::get('kdigr'))
                ->where('prc_pluigr','=',$d->pdm_prdcd)
                ->whereIn('prc_group',['O','I'])
                ->get();

            foreach($omi as $o){
                if($o->prc_group == 'O')
                    $d->omi = 'Y';
                if($o->prc_group == 'I')
                    $d->idm = 'Y';
            }
        }

        return response()->json(compact(['header','detail']), 200);
    }

    public function deletePBDraft(Request $request){
        try{
            $no = $request->no;

            DB::connection(Session::get('connection'))->beginTransaction();

            $temp = DB::connection(Session::get('connection'))
                ->table('tbtr_pbm_h')
                ->select('phm_flagdoc','phm_recordid')
                ->where('phm_nodraft','=',$no)
                ->first();

            if($temp){
                if($temp->phm_flagdoc == '2'){
                    return response()->json([
                        'message' => 'Nomor Draft PB sudah menjadi PB Manual, Data tidak dapat dihapus!'
                    ], 500);
                }

                if($temp->phm_recordid == 1){
                    return response()->json([
                        'message' => 'Nomor Draft PB sudah dihapus!'
                    ], 500);
                }

                DB::connection(Session::get('connection'))
                    ->table('tbtr_pbm_h')
                    ->where('phm_nodraft','=',$no)
                    ->update([
                        'phm_recordid' => '1'
                    ]);

                DB::connection(Session::get('connection'))
                    ->table('tbtr_pbm_d')
                    ->where('pdm_nodraft','=',$no)
                    ->update([
                        'pdm_recordid' => '1'
                    ]);

                DB::connection(Session::get('connection'))->commit();

                return response()->json([
                    'message' => 'Nomor Draft PB berhasil dihapus!'
                ], 200);
            }
            else{
                return response()->json([
                    'message' => 'Nomor Draft PB tidak ada!'
                ], 500);
            }
        }
        catch (\Exception $e){
            DB::connection(Session::get('connection'))->rollBack();

            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function newPBDraft(){
        try{
            $connect = loginController::getConnectionProcedure();

            $query = oci_parse($connect, "BEGIN :ret := f_igr_get_nomor('" . Session::get('kdigr') . "','PBM','Nomor Permintaan Barang Manual','P' || to_char(sysdate,'yyMM'),4,false); END;");
            oci_bind_by_name($query, ':ret', $no, 32);
            oci_execute($query);

            return response()->json([
                'draftNo' => $no,
                'draftDate' => Carbon::now()->format('d/m/Y')
            ], 200);
        }
        catch(\Exception $e){
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getDraftProductDetail(Request $request){
        $plu = $request->plu;

        if($plu == '0000000'){
            return response()->json([
                'message' => 'Salah inputan PLU!'
            ], 500);
        }

        $v_oke = false;

        $temp = DB::connection(Session::get('connection'))
            ->table('tbmaster_produk_pb')
            ->where('ppb_prdcd','=',$plu)
            ->whereDate('ppb_tglawal','<=',Carbon::now())
            ->whereDate('ppb_tglakhir','>=',Carbon::now())
            ->first();

        if(!$temp){
            return response()->json([
                'message' => 'Data PLU '.$plu.' tidak sesuai dengan periode aktif!'
            ], 500);
        }
        else{
            $connect = loginController::getConnectionProcedure();

            $query = oci_parse($connect, "BEGIN sp_igr_bo_pbm_cek_plu_migrasi(
                         '".Session::get('kdigr')."',
                         '".$plu."',
                         trunc (sysdate),
                         :deskripsi,
                         :unit,
                         :frac,
                         :bkp,
                         :kode_supp,
                         :nama_supp,
                         :suppkp,
                         :hrg_jual,
                         :isi_beli,
                         :pdm_saldoakhir,
                         :v_minor,
                         :pdm_pkmt,
                         :pdm_persendisc1,
                         :pdm_rphdisc1,
                         :pdm_flagdisc1,
                         :pdm_persendisc2,
                         :pdm_rphdisc2,
                         :pdm_flagdisc2,
                         :pdm_top,
                         :f_omi,
                         :f_idm,
                         :pdm_hrgsatuan,
                         :pdm_ppnbm,
                         :pdm_ppnbotol,
                         :v_oke,
                         :v_message
                    ); END;");

            $data = new \stdClass();

            $data->pdm_prdcd = $plu;

            oci_bind_by_name($query, ':deskripsi',$data->prd_deskripsipanjang,255);
            oci_bind_by_name($query, ':unit',$data->prd_unit,255);
            oci_bind_by_name($query, ':frac',$data->prd_frac,255);
            oci_bind_by_name($query, ':bkp',$data->bkp,255);
            oci_bind_by_name($query, ':kode_supp',$data->sup_kodesupplier,255);
            oci_bind_by_name($query, ':nama_supp',$data->sup_namasupplier,255);
            oci_bind_by_name($query, ':suppkp',$data->suppkp,255);
            oci_bind_by_name($query, ':hrg_jual',$data->prd_hrgjual,255);
            oci_bind_by_name($query, ':isi_beli',$data->isi_beli,255);
            oci_bind_by_name($query, ':pdm_saldoakhir',$data->pdm_saldoakhir,255);
            oci_bind_by_name($query, ':v_minor',$data->v_minor,255);
            oci_bind_by_name($query, ':pdm_pkmt',$data->pdm_pkmt,255);
            oci_bind_by_name($query, ':pdm_persendisc1',$data->pdm_persendisc1,255);
            oci_bind_by_name($query, ':pdm_rphdisc1',$data->pdm_rphdisc1,255);
            oci_bind_by_name($query, ':pdm_flagdisc1',$data->pdm_flagdisc1,255);
            oci_bind_by_name($query, ':pdm_persendisc2',$data->pdm_persendisc2,255);
            oci_bind_by_name($query, ':pdm_rphdisc2',$data->pdm_rphdisc2,255);
            oci_bind_by_name($query, ':pdm_flagdisc2',$data->pdm_flagdisc2,255);
            oci_bind_by_name($query, ':pdm_top',$data->pdm_top,255);
            oci_bind_by_name($query, ':f_omi',$data->omi,255);
            oci_bind_by_name($query, ':f_idm',$data->idm,255);
            oci_bind_by_name($query, ':pdm_hrgsatuan',$data->pdm_hrgsatuan,255);
            oci_bind_by_name($query, ':pdm_ppnbm',$data->pdm_ppnbm,255);
            oci_bind_by_name($query, ':pdm_ppnbotol',$data->pdm_ppnbotol,255);
            oci_bind_by_name($query, ':v_oke',$data->v_oke,255);
            oci_bind_by_name($query, ':v_message',$data->v_message,255);

            oci_execute($query);

            if($data->v_oke == 'TRUE'){
                $temp = DB::connection(Session::get('connection'))
                    ->table('tbmaster_prodmast')
                    ->leftJoin('tbmaster_maxpalet','mpt_prdcd','=','prd_prdcd')
                    ->select(
                        'prd_kodedivisi',
                        'prd_kodedivisipo',
                        'prd_kodedepartement',
                        'prd_kodekategoribarang',
                        'prd_ppn',
                        'mpt_maxqty'
                    )
                    ->where('prd_kodeigr','=',Session::get('kdigr'))
                    ->where('prd_prdcd','=',$plu)
                    ->first();

                $data->pdm_kodedivisi = $temp->prd_kodedivisi;
                $data->pdm_kodedivisipo = $temp->prd_kodedivisipo;
                $data->pdm_kodedepartement = $temp->prd_kodedepartement;
                $data->pdm_kodekategoribarang = $temp->prd_kodekategoribarang;
                $data->maxpalet = $temp->mpt_maxqty;
                $data->prd_ppn = $temp->prd_ppn;

                $cek = DB::connection(Session::get('connection'))
                    ->table('tbmaster_supplier')
                    ->join('tbmaster_hargabeli','hgb_kodesupplier','=','sup_kodesupplier')
                    ->whereNull('hgb_recordid')
                    ->where('hgb_tipe','=','2')
                    ->where('hgb_prdcd','=',$plu)
                    ->first();

                if($cek){
                    $data->sup_minrph = $cek->sup_minrph;
                    $data->hgb_flagkelipatanbonus01 = $cek->hgb_flagkelipatanbonus01;
                    $data->hgb_flagkelipatanbonus02 = $cek->hgb_flagkelipatanbonus02;
                    $data->hgb_tglmulaibonus01 = $cek->hgb_tglmulaibonus01;
                    $data->hgb_tglakhirbonus01 = $cek->hgb_tglakhirbonus01;
                    $data->hgb_tglmulaibonus02 = $cek->hgb_tglmulaibonus02;
                    $data->hgb_tglakhirbonus01 = $cek->hgb_tglakhirbonus01;
                    $data->hgb_qtymulai1bonus01 = $cek->hgb_qtymulai1bonus01;
                    $data->hgb_qtymulai2bonus01 = $cek->hgb_qtymulai2bonus01;
                    $data->hgb_qtymulai3bonus01 = $cek->hgb_qtymulai3bonus01;
                    $data->hgb_qtymulai4bonus01 = $cek->hgb_qtymulai4bonus01;
                    $data->hgb_qtymulai5bonus01 = $cek->hgb_qtymulai5bonus01;
                    $data->hgb_qtymulai6bonus01 = $cek->hgb_qtymulai6bonus01;
                    $data->hgb_qtymulai1bonus02 = $cek->hgb_qtymulai1bonus02;
                    $data->hgb_qtymulai2bonus02 = $cek->hgb_qtymulai2bonus02;
                    $data->hgb_qtymulai3bonus02 = $cek->hgb_qtymulai3bonus02;
                    $data->hgb_qty1bonus01 = $cek->hgb_qty1bonus01;
                    $data->hgb_qty2bonus01 = $cek->hgb_qty2bonus01;
                    $data->hgb_qty3bonus01 = $cek->hgb_qty3bonus01;
                    $data->hgb_qty4bonus01 = $cek->hgb_qty4bonus01;
                    $data->hgb_qty5bonus01 = $cek->hgb_qty5bonus01;
                    $data->hgb_qty6bonus01 = $cek->hgb_qty6bonus01;
                    $data->hgb_qty1bonus02 = $cek->hgb_qty1bonus02;
                    $data->hgb_qty2bonus02 = $cek->hgb_qty2bonus02;
                    $data->hgb_qty3bonus02 = $cek->hgb_qty3bonus02;
                    $data->hgb_jenisbonus = $cek->hgb_jenisbonus;
                }
                else{
                    $data->sup_minrph = 0;
                    $data->hgb_flagkelipatanbonus01 = null;
                    $data->hgb_flagkelipatanbonus02 = null;
                    $data->hgb_tglmulaibonus01 = null;
                    $data->hgb_tglakhirbonus01 = null;
                    $data->hgb_tglmulaibonus02 = null;
                    $data->hgb_tglakhirbonus01 = null;
                    $data->hgb_qtymulai1bonus01 = null;
                    $data->hgb_qtymulai2bonus01 = null;
                    $data->hgb_qtymulai3bonus01 = null;
                    $data->hgb_qtymulai4bonus01 = null;
                    $data->hgb_qtymulai5bonus01 = null;
                    $data->hgb_qtymulai6bonus01 = null;
                    $data->hgb_qtymulai1bonus02 = null;
                    $data->hgb_qtymulai2bonus02 = null;
                    $data->hgb_qtymulai3bonus02 = null;
                    $data->hgb_qty1bonus01 = null;
                    $data->hgb_qty2bonus01 = null;
                    $data->hgb_qty3bonus01 = null;
                    $data->hgb_qty4bonus01 = null;
                    $data->hgb_qty5bonus01 = null;
                    $data->hgb_qty6bonus01 = null;
                    $data->hgb_qty1bonus02 = null;
                    $data->hgb_qty2bonus02 = null;
                    $data->hgb_qty3bonus02 = null;
                    $data->hgb_jenisbonus = null;
                }

                $temp = DB::connection(Session::get('connection'))
                    ->table('temp_go')
                    ->selectRaw("isi_toko isi, to_char(per_awal_pdisc_go,'dd/mm/yyyy') awal, to_char(per_akhir_pdisc_go,'dd/mm/yyyy') akhir")
                    ->where('kodeigr','=',Session::get('kdigr'))
                    ->first();

                if($temp->isi == 'Y'
                    && Carbon::createFromFormat('d/m/Y',$temp->awal) <= Carbon::now()
                    && Carbon::createFromFormat('d/m/Y',$temp->akhir) >= Carbon::now()){
                    $data->pdm_fdxrev = 'T';
                }
                else $data->pdm_fdxrev = null;

                return response()->json($data,200);
            }
            else{
                $data->pdm_prdcd = '';
                $data->prd_hrgjual = '';
                $data->isi_beli = '';
                $data->pdm_saldoakhir = '';
                $data->omi = '';
                $data->pdm_hrgsatuan = '';

                return response()->json([
                    'message' => $data->v_message
                ], 500);
            }
        }
    }
}
