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

    public function getDraftProductList(Request $request){
        $search = $request->plu;

        if($search == ''){
            $produk = DB::connection(Session::get('connection'))->table("tbmaster_prodmast")
                ->join('tbmaster_produk_pb','ppb_prdcd','=','prd_prdcd')
                ->select('prd_deskripsipanjang','prd_prdcd')
                ->where('prd_kodeigr',Session::get('kdigr'))
                ->whereRaw("substr(prd_prdcd,7,1) = '0'")
                ->whereDate('ppb_tglawal','=',Carbon::now())
                ->whereDate('ppb_tglakhir','=',Carbon::now())
                ->whereRaw("nvl(ppb_flag, '0') <> '1'")
                ->orderBy('prd_prdcd')
                ->limit(100)
                ->get();
        }
        else if(is_numeric($search)){
            $produk = DB::connection(Session::get('connection'))->table("tbmaster_prodmast")
                ->join('tbmaster_produk_pb','ppb_prdcd','=','prd_prdcd')
                ->select('prd_deskripsipanjang','prd_prdcd')
                ->where('prd_kodeigr',Session::get('kdigr'))
                ->whereRaw("substr(prd_prdcd,7,1) = '0'")
                ->whereDate('ppb_tglawal','=',Carbon::now())
                ->whereDate('ppb_tglakhir','=',Carbon::now())
                ->whereRaw("nvl(ppb_flag, '0') <> '1'")
                ->where('prd_prdcd','like',"'%".$search."%'")
                ->orderBy('prd_prdcd')
                ->get();
        }
        else{
            $produk = DB::connection(Session::get('connection'))->table("tbmaster_prodmast")
                ->join('tbmaster_produk_pb','ppb_prdcd','=','prd_prdcd')
                ->select('prd_deskripsipanjang','prd_prdcd')
                ->where('prd_kodeigr',Session::get('kdigr'))
                ->whereRaw("substr(prd_prdcd,7,1) = '0'")
                ->whereDate('ppb_tglawal','=',Carbon::now())
                ->whereDate('ppb_tglakhir','=',Carbon::now())
                ->whereRaw("nvl(ppb_flag, '0') <> '1'")
                ->where('prd_prdcd','like',"'%".$search."%'")
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
                'message' => (__('Data Master Produk tidak ada!'))
            ], 500);
        }

        if(in_array($data->prd_kodetag, ['H','A','G','I','B','Q','U','N','X','O','T'])){
            return response()->json([
                'message' => (__('Tag ')).$data->prd_kodetag.(__(', tidak bisa order!'))
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
                'message' => (__('Data Master Produk PB sudah ada!'))
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
                        'message' => (__('Data Master Produk ')).$p.(__(' tidak ada!'))
                    ], 500);
                }

                if(in_array($temp->prd_kodetag, ['H','A','G','I','B','Q','U','N','X','O','T'])){
                    return response()->json([
                        'message' => (__('Tag ')).$temp->prd_kodetag.(__(', tidak bisa order!'))
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
                'message' => (__('Data PLU sudah disimpan!'))
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
            ->orderBy('ppb_prdcd')
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
               to_char(pdm_create_dt,'dd/mm/yyyy') pdm_create_dt,
               (pdm_qtypb + pdm_saldoakhir) qty_input,
               pdm_qtypb,
               pdm_create_by,
               phm_nopb,
               to_char(phm_tglpb,'dd/mm/yyyy') phm_tglpb,
               phm_approval")
            ->whereDate('phm_create_dt','>=',Carbon::createFromFormat('d/m/Y',$tgl1))
            ->whereDate('phm_create_dt','<=',Carbon::createFromFormat('d/m/Y',$tgl2))
            ->whereRaw("nvl(phm_recordid, '0') = '2'")
            ->orderBy('pdm_prdcd')
            ->orderBy('pdm_nodraft')
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
            ->leftJoin('tbmaster_prodcrm',function($join){
                $join->on('prc_pluigr','=','pdm_prdcd');
            })
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
                to_char(hgb_tglmulaibonus01,'dd/mm/yyyy') hgb_tglmulaibonus01,
                to_char(hgb_tglakhirbonus01,'dd/mm/yyyy') hgb_tglakhirbonus01,
                to_char(hgb_tglmulaibonus02,'dd/mm/yyyy') hgb_tglmulaibonus02,
                to_char(hgb_tglakhirbonus01,'dd/mm/yyyy') hgb_tglakhirbonus01,
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
                hgb_jenisbonus,
                prc_group,
                prd_flagbkp1 bkp,
                pdm_kodetag,
                pdm_kodedivisi,
                pdm_kodedivisipo,
                pdm_kodedepartement,
                pdm_kodekategoribrg,
                pdm_kodesupplier,
                pdm_nourut,
                pdm_qtypb,
                pdm_kodetag,
                pdm_qtybpb,
                hgb_hrgbeli * case when prd_unit = 'KG' then 1 else prd_frac end pdm_hrgsatuan,
                pdm_persendisc1,
                pdm_rphdisc1,
                pdm_flagdisc1,
                pdm_persendisc2,
                pdm_rphdisc2,
                pdm_flagdisc2,
                pdm_bonuspo1,
                pdm_bonuspo2,
                pdm_bonusbpb1,
                pdm_bonusbpb2,
                pdm_gross,
                pdm_rphttldisc,
                pdm_ppn,
                pdm_ppnbm,
                pdm_ppnbotol,
                pdm_top,
                pdm_ostpb,
                pdm_ostpo,
                pdm_pkmt,
                pdm_saldoakhir")
            ->where('prd_kodeigr','=',Session::get('kdigr'))
            ->where('pdm_nodraft','=',$no)
            ->where('hgb_tipe','=','2')
            ->whereNull('hgb_recordid')
//            ->whereIn('prc_group',['O','I'])
//            ->where('pdm_prdcd','=','1323810')
            ->orderBy('pdm_prdcd')
            ->orderBy('prc_group')
            ->get();

//        dd($detail);

        $result = [];

        $plu = null;
        $temp = new \stdClass();
        foreach($detail as $d){

            if($plu != $d->pdm_prdcd){
                if($plu != null)
                    $result[] = $temp;
                $plu = $d->pdm_prdcd;
                $temp = $d;
                $temp->idm = 'N';
                $temp->omi = 'N';

                if($d->prc_group == 'I')
                    $temp->idm = 'Y';
                if($d->prc_group == 'O')
                    $temp->omi = 'Y';
            }
            else{
                if($d->prc_group == 'I')
                    $temp->idm = 'Y';
                if($d->prc_group == 'O')
                    $temp->omi = 'Y';
            }
        }
        $result[] = $temp;

        $detail = $result;

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
                        'message' => (__('Nomor Draft PB sudah menjadi PB Manual, Data tidak dapat dihapus!'))
                    ], 500);
                }

                if($temp->phm_recordid == 1){
                    return response()->json([
                        'message' => (__('Nomor Draft PB sudah dihapus!'))
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
                    'message' => (__('Nomor Draft PB berhasil dihapus!'))
                ], 200);
            }
            else{
                return response()->json([
                    'message' => (__('Nomor Draft PB tidak ada!'))
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
                'message' => (__('Salah inputan PLU!'))
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
                'message' => (__('Data PLU ')).$plu.(__(' tidak sesuai dengan periode aktif!'))
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
            oci_bind_by_name($query, ':isi_beli',$data->prd_isibeli,255);
            oci_bind_by_name($query, ':pdm_saldoakhir',$data->pdm_saldoakhir,255);
            oci_bind_by_name($query, ':v_minor',$data->prd_minorder,255);
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
                        'mpt_maxqty',
                        'prd_kodetag'
                    )
                    ->where('prd_kodeigr','=',Session::get('kdigr'))
                    ->where('prd_prdcd','=',$plu)
                    ->first();

                $data->pdm_kodedivisi = $temp->prd_kodedivisi;
                $data->pdm_kodedivisipo = $temp->prd_kodedivisipo;
                $data->pdm_kodedepartement = $temp->prd_kodedepartement;
                $data->pdm_kodekategoribrg = $temp->prd_kodekategoribarang;
                $data->mpt_maxqty = $temp->mpt_maxqty;
                $data->prd_ppn = $temp->prd_ppn;
                $data->pdm_kodetag = $temp->prd_kodetag;

                $cek = DB::connection(Session::get('connection'))
                    ->table('tbmaster_supplier')
                    ->join('tbmaster_hargabeli','hgb_kodesupplier','=','sup_kodesupplier')
                    ->whereNull('hgb_recordid')
                    ->where('hgb_tipe','=','2')
                    ->where('hgb_prdcd','=',$plu)
                    ->first();

//                dd($cek);

                if($cek){
                    $data->sup_minrph = $cek->sup_minrph;
                    $data->hgb_flagkelipatanbonus01 = $cek->hgb_flagkelipatanbonus01;
                    $data->hgb_flagkelipatanbonus02 = $cek->hgb_flagkelipatanbonus02;
                    $data->hgb_tglmulaibonus01 = $cek->hgb_tglmulaibonus01 ? Carbon::createFromFormat('Y-m-d h:i:s',$cek->hgb_tglmulaibonus01)->format('d/m/Y') : null;
                    $data->hgb_tglakhirbonus01 = $cek->hgb_tglakhirbonus01 ? Carbon::createFromFormat('Y-m-d h:i:s',$cek->hgb_tglakhirbonus01)->format('d/m/Y') : null;
                    $data->hgb_tglmulaibonus02 = $cek->hgb_tglmulaibonus02 ? Carbon::createFromFormat('Y-m-d h:i:s',$cek->hgb_tglmulaibonus02)->format('d/m/Y') : null;
                    $data->hgb_tglakhirbonus02 = $cek->hgb_tglakhirbonus02 ? Carbon::createFromFormat('Y-m-d h:i:s',$cek->hgb_tglakhirbonus02)->format('d/m/Y') : null;
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
                    ->whereNotNull('per_awal_pdisc_go')
                    ->whereNotNull('per_akhir_pdisc_go')
                    ->first();

                $data->pdm_fdxrev = null;

                if($temp){
                    if($temp->isi == 'Y'
                        && Carbon::createFromFormat('d/m/Y',$temp->awal) <= Carbon::now()
                        && Carbon::createFromFormat('d/m/Y',$temp->akhir) >= Carbon::now()){
                        $data->pdm_fdxrev = 'T';
                    }
                }

                return response()->json($data,200);
            }
            else{
                $data->pdm_prdcd = '';
                $data->prd_hrgjual = '';
                $data->prd_isibeli = '';
                $data->pdm_saldoakhir = '';
                $data->omi = '';
                $data->idm = '';
                $data->pdm_hrgsatuan = '';

                return response()->json([
                    'message' => $data->v_message
                ], 500);
            }
        }
    }

    public function bonusCheck(Request $request){
        $prdcd = $request->plu;
        $kodesupplier = $request->kodesupplier;
        $frac = $request->frac;


        $data = new \stdClass();

        $data->pdm_qtypb = $request->qtypb;

        $connect = loginController::getConnectionProcedure();

        $query = oci_parse($connect, "BEGIN sp_igr_bo_pb_cek_bonus_migrasi(
                            '".$prdcd."',
                            '".$kodesupplier."',
                            trunc (sysdate),
                            ".$frac.",
                            :pdm_qtypb,
                            :pdm_bonuspo1,
                            :pdm_bonuspo2,
                            :pdm_ppn,
                            :pdm_ppnbm,
                            :pdm_ppnbotol,
                            :v_oke,
                            :v_message); END;");

        oci_bind_by_name($query, ':pdm_qtypb',$data->pdm_qtypb,255);
        oci_bind_by_name($query, ':pdm_bonuspo1',$data->pdm_bonuspo1,255);
        oci_bind_by_name($query, ':pdm_bonuspo2',$data->pdm_bonuspo2,255);
        oci_bind_by_name($query, ':pdm_ppn',$data->pdm_ppn,255);
        oci_bind_by_name($query, ':pdm_ppnbm',$data->pdm_ppnbm,255);
        oci_bind_by_name($query, ':pdm_ppnbotol',$data->pdm_ppnbotol,255);
        oci_bind_by_name($query, ':v_oke',$data->v_oke,255);
        oci_bind_by_name($query, ':v_message',$data->v_message,255);

        oci_execute($query);

        return response()->json($data, 200);
    }

    public function saveDraft(Request $request){
        try{
            DB::connection(Session::get('connection'))->beginTransaction();

            $isNewDraft = $request->isNewDraft;
            $draftNo = $request->draftNo;
            $draftDate = $request->draftDate;
            $draftInfo = $request->draftInfo;
            $draftDetail = $request->draftDetail;

            if($isNewDraft == 'true'){
                $connect = loginController::getConnectionProcedure();

                $query = oci_parse($connect, "BEGIN :ret := f_igr_get_nomor('" . Session::get('kdigr') . "','PBM','Nomor Permintaan Barang Manual','P' || to_char(sysdate,'yyMM'),4,true); END;");
                oci_bind_by_name($query, ':ret', $draftNo, 32);
                oci_execute($query);
            }
            else{
                DB::connection(Session::get('connection'))
                    ->table('tbtr_pbm_h')
                    ->where('phm_kodeigr','=',Session::get('kdigr'))
                    ->where('phm_nodraft','=',$draftNo)
                    ->delete();

                DB::connection(Session::get('connection'))
                    ->table('tbtr_pbm_d')
                    ->where('pdm_kodeigr','=',Session::get('kdigr'))
                    ->where('pdm_nodraft','=',$draftNo)
                    ->delete();
            }

            $total = new \stdClass();
            $total->qtypb = 0;
            $total->gross = 0;
            $total->ppn = 0;
            $total->ppnbm = 0;
            $total->ppnbmbotol = 0;
            $total->pdm_bonuspo1 = 0;
            $total->pdm_bonuspo2 = 0;

            foreach($draftDetail as $index => $d){
                $total->qtypb += $d['pdm_qtypb'];
                $total->gross += $d['pdm_gross'];
                $total->ppn += $d['pdm_ppn'];
                $total->ppnbm += $d['pdm_ppnbm'];
                $total->ppnbmbotol += $d['pdm_ppnbotol'];
                $total->pdm_bonuspo1 += $d['pdm_bonuspo1'];
                $total->pdm_bonuspo2 += $d['pdm_bonuspo2'];

                DB::connection(Session::get('connection'))
                    ->table('tbtr_pbm_d')
                    ->insert([
                        'pdm_kodeigr' => Session::get('kdigr'),
                        'pdm_nodraft' => $draftNo,
                        'pdm_prdcd' => $d['pdm_prdcd'],
                        'pdm_kodedivisi' => $d['pdm_kodedivisi'],
                        'pdm_kodedivisipo' => $d['pdm_kodedivisipo'],
                        'pdm_kodedepartement' => $d['pdm_kodedepartement'],
                        'pdm_kodekategoribrg' => $d['pdm_kodekategoribrg'],
                        'pdm_kodesupplier' => $d['sup_kodesupplier'],
                        'pdm_nourut' => $index + 1,
                        'pdm_qtypb' => $d['pdm_qtypb'],
                        'pdm_kodetag' => $d['pdm_kodetag'],
                        'pdm_qtybpb' => 0,
                        'pdm_hrgsatuan' => $d['pdm_hrgsatuan'],
                        'pdm_persendisc1' => $d['pdm_persendisc1'],
                        'pdm_rphdisc1' => $d['pdm_rphdisc1'],
                        'pdm_flagdisc1' => $d['pdm_flagdisc1'],
                        'pdm_persendisc2' => $d['pdm_persendisc2'],
                        'pdm_rphdisc2' => $d['pdm_rphdisc2'],
                        'pdm_flagdisc2' => $d['pdm_flagdisc2'],
                        'pdm_bonuspo1' => $d['pdm_bonuspo1'] ? $d['pdm_bonuspo1'] : 0,
                        'pdm_bonuspo2' => $d['pdm_bonuspo2'] ? $d['pdm_bonuspo2'] : 0,
                        'pdm_bonusbpb1' => 0,
                        'pdm_bonusbpb2' => 0,
                        'pdm_gross' => round($d['pdm_gross'],2),
                        'pdm_rphttldisc' => 0,
                        'pdm_ppn' => round($d['pdm_ppn'],2),
                        'pdm_ppnbm' => $d['pdm_ppnbm'],
                        'pdm_ppnbotol' => $d['pdm_ppnbotol'],
                        'pdm_top' => $d['pdm_top'],
                        'pdm_ostpb' => 0,
                        'pdm_ostpo' => 0,
                        'pdm_pkmt' => $d['pdm_pkmt'],
                        'pdm_saldoakhir' => $d['pdm_saldoakhir'],
                        'pdm_create_by' => Session::get('usid'),
                        'pdm_create_dt' => Carbon::now()->format('Y-m-d'),
                        'pdm_modify_by' => Session::get('usid'),
                        'pdm_modify_dt' => Carbon::now()->format('Y-m-d')
                    ]);
            }

            DB::connection(Session::get('connection'))
                ->table('tbtr_pbm_h')
                ->insert([
                    'phm_kodeigr' => Session::get('kdigr'),
                    'phm_recordid' => '',
                    'phm_nodraft' => $draftNo,
                    'phm_tgldraft' => Carbon::now()->format('Y/m/d'),
                    'phm_flagdoc' => '0',
                    'phm_qtypb' => $total->qtypb,
                    'phm_qtybpb' => 0,
                    'phm_bonuspo1' => $total->pdm_bonuspo1,
                    'phm_bonuspo2' => $total->pdm_bonuspo2,
                    'phm_bonusbpb1' => 0,
                    'phm_bonusbpb2' => 0,
                    'phm_gross' => $total->gross,
                    'phm_rphttldisc' => 0,
                    'phm_ppn' => $total->ppn,
                    'phm_ppnbm' => $total->ppnbm,
                    'phm_ppnbotol' => $total->ppnbmbotol,
                    'phm_keteranganpb' => $draftInfo,
                    'phm_tgltransfer' => null,
                    'phm_create_by' => Session::get('usid'),
                    'phm_create_dt' => Carbon::now(),
                    'phm_modify_by' => Session::get('usid'),
                    'phm_modify_dt' => Carbon::now()
                ]);

            DB::connection(Session::get('connection'))->commit();

            return response()->json([
                'message' => (__('Draft dengan nomor ')).$draftNo.(__(' berhasil disimpan!'))
            ], 200);
        }
        catch (\Exception $e){
            DB::connection(Session::get('connection'))->rollBack();

            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function checkProcessDraft(Request $request){
        $draftNo = $request->draftNo;

        $temp = DB::connection(Session::get('connection'))
            ->table('tbtr_pbm_h')
            ->select(
                'phm_flagdoc',
                'phm_recordid'
            )
            ->where('phm_nodraft','=',$draftNo)
            ->first();

        if($temp){
            if($temp->phm_flagdoc == '2'){
                return response()->json([
                    'message' => (__('Nomor Draft PB sudah menjadi PB Manual!'))
                ], 500);
            }

            if($temp->phm_recordid == '1'){
                return response()->json([
                    'message' => (__('Nomor Draft PB sudah dihapus!'))
                ], 500);
            }

            return response()->json([
                'message' => (__('OK'))
            ], 200);
        }
    }

    public function sendOTP(Request $request){
        try{
            $auth = $request->auth;
            $paramCekPKM = $request->paramCekPKM;
            $draftNo = $request->draftNo;
            $draftDate = $request->draftDate;

//            dd($paramCekPKM);

            $temp = DB::connection(Session::get('connection'))
                ->table('tbmaster_user')
                ->whereRaw("nvl(recordid,'0') <> '1'")
                ->whereRaw("NVL (TO_NUMBER (SUBSTR (jabatan, 1, 1)), 0) = ".$paramCekPKM)
                ->first();

            if(!$temp){
                return response()->json([
                    'message' => (__('User dengan ')).$auth.(__(' tidak terdaftar!'))
                ], 500);
            }

            $temp = DB::connection(Session::get('connection'))
                ->table('tbmaster_user')
                ->whereRaw("nvl(recordid,'0') <> '1'")
                ->whereRaw("NVL (TO_NUMBER (SUBSTR (jabatan, 1, 1)), 0) = ".$paramCekPKM)
                ->whereNotNull('email')
                ->first();

            if(!$temp){
                return response()->json([
                    'message' => (__('User dengan ')).$auth.(__(' belum didaftarkan emailnya!'))
                ], 500);
            }

            $temp = DB::connection(Session::get('connection'))
                ->table('tbmaster_user')
                ->select('email')
                ->where('kodeigr','=',Session::get('kdigr'))
                ->whereRaw("nvl(recordid,'0') <> '1'")
                ->where('userid','=',Session::get('usid'))
                ->first();

            if($temp){
                if(in_array($temp->email,['',' ',null])){
                    return response()->json([
                        'message' => (__('User pembuat belum didaftarkan emailnya!'))
                    ], 500);
                }
                else{
                    $connect = loginController::getConnectionProcedure();

                    $query = oci_parse($connect, "BEGIN sp_pbmanual_kirim_otp_migrasi(
                                '".$draftNo."',
                                '".$draftDate."',
                                '".$paramCekPKM."',
                                :lok,
                                :v_message); END;");
                    oci_bind_by_name($query, ':lok', $lok, 32);
                    oci_bind_by_name($query, ':v_message', $v_message, 32);
                    oci_execute($query);

                    if($lok == 'FALSE'){
                        return response()->json([
                            'message' => (__('OTP dan data Draft PB tidak dapat di email - ')).$v_message
                        ], 500);
                    }
                    else{
                        return response()->json([
                            'message' => (__('OTP dan data Draft PB sudah di email ke user terkait!'))
                        ], 200);
                    }
                }
            }
            else{
                return response()->json([
                    'message' => (__('User pembuat tidak ada!'))
                ], 500);
            }
        }
        catch(\Exception $e){
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function processDraft(Request $request){
        try{
            $draftNo = $request->draftNo;
            $draftDate = $request->draftDate;
            $otp = $request->otp;
            $paramCekPKM = $request->paramCekPKM;
            $userauth = strtoupper(substr($otp,-3));

            DB::connection(Session::get('connection'))->beginTransaction();

            $connect = loginController::getConnectionProcedure();

            $query = oci_parse($connect, "BEGIN sp_pbmanual_cek_otp_migrasi(
                                '".$draftNo."',
                                '".$draftDate."',
                                '".$otp."',
                                :lok,
                                :v_message); END;");
            oci_bind_by_name($query, ':lok', $lok, 32);
            oci_bind_by_name($query, ':v_message', $v_message, 32);
            oci_execute($query);

            if($lok == 'TRUE'){
                $temp = DB::connection(Session::get('connection'))
                    ->table('tbmaster_user')
                    ->where('userid','=',$userauth)
                    ->whereRaw("NVL (TO_NUMBER (SUBSTR (jabatan, 1, 1)), 0) = ".$paramCekPKM)
                    ->first();

                if(!$temp){
                    return response()->json([
                        'message' => (__('User approval tidak sesuai / tidak ditemukan!'))
                    ], 500);
                }
                else{
                    $query = oci_parse($connect, "BEGIN :ret := f_igr_get_nomor(
                        '" . Session::get('kdigr') . "',
                        'PB',
                        'Nomor Permintaan Barang',
                        '" . Session::get('kdigr') . "' || to_char(sysdate,'yyMM'),
                        3,TRUE); END;");
                    oci_bind_by_name($query, ':ret', $noPB, 32);
                    oci_execute($query);

                    DB::connection(Session::get('connection'))
                        ->table('tbtr_pbm_h')
                        ->where('phm_nodraft','=',$draftNo)
                        ->update([
                            'phm_flagdoc' => '2',
                            'phm_recordid' => '2',
                            'phm_nopb' => $noPB,
                            'phm_tglpb' => Carbon::now(),
                            'phm_tgltransfer' => Carbon::now(),
                            'phm_approval' => $userauth,
                            'phm_modify_by' => Session::get('usid'),
                            'phm_modify_dt' => Carbon::now()
                        ]);

                    DB::connection(Session::get('connection'))
                        ->table('tbtr_pbm_d')
                        ->where('pdm_nodraft','=',$draftNo)
                        ->update([
                            'pdm_recordid' => '2',
                            'pdm_modify_by' => Session::get('usid'),
                            'pdm_modify_dt' => Carbon::now()
                        ]);

                    $header = DB::connection(Session::get('connection'))
                        ->table('tbtr_pbm_h')
                        ->where('phm_nodraft','=',$draftNo)
                        ->first();

                    DB::connection(Session::get('connection'))
                        ->table('tbtr_pb_h')
                        ->insert([
                            'PBH_KODEIGR' => $header->phm_kodeigr,
                            'PBH_NOPB' => $noPB,
                            'PBH_TGLPB' => Carbon::now(),
                            'PBH_TIPEPB' => 'R',
                            'PBH_JENISPB' => null,
                            'PBH_FLAGDOC' => '0',
                            'PBH_QTYPB' => $header->phm_qtypb,
                            'PBH_QTYBPB' => $header->phm_qtybpb,
                            'PBH_BONUSPO1' => $header->phm_bonuspo1,
                            'PBH_BONUSPO2' => $header->phm_bonuspo2,
                            'PBH_BONUSBPB1' => $header->phm_bonusbpb1,
                            'PBH_BONUSBPB2' => $header->phm_bonusbpb2,
                            'PBH_GROSS' => $header->phm_gross,
                            'PBH_RPHTTLDISC' => $header->phm_rphttldisc,
                            'PBH_PPN' => $header->phm_ppn,
                            'PBH_PPNBM' => $header->phm_ppnbm,
                            'PBH_PPNBOTOL' => $header->phm_ppnbotol,
                            'PBH_KETERANGANPB' => $header->phm_keteranganpb,
                            'PBH_CREATE_BY' => Session::get('usid'),
                            'PBH_CREATE_DT' => Carbon::now(),
                    ]);

                    $detail = DB::connection(Session::get('connection'))
                        ->table('tbtr_pbm_d')
                        ->join('tbmaster_prodmast','prd_prdcd','=','pdm_prdcd')
                        ->where('pdm_nodraft','=',$draftNo)
                        ->get();

                    foreach($detail as $d){
                        DB::connection(Session::get('connection'))
                            ->table('tbtr_pb_d')
                            ->insert([
                                'pbd_kodeigr' => $d->pdm_kodeigr,
                                'pbd_nopb' => $noPB,
                                'pbd_prdcd' => $d->pdm_prdcd,
                                'pbd_kodedivisi' => $d->pdm_kodedivisi,
                                'pbd_kodedivisipo' => $d->pdm_kodedivisipo,
                                'pbd_kodedepartement' => $d->pdm_kodedepartement,
                                'pbd_kodekategoribrg' => $d->pdm_kodekategoribrg,
                                'pbd_kodesupplier' => $d->pdm_kodesupplier,
                                'pbd_nourut' => $d->pdm_nourut,
                                'pbd_qtypb' => $d->pdm_qtypb,
                                'pbd_kodetag' => $d->pdm_kodetag,
                                'pbd_qtybpb' => $d->pdm_qtybpb,
                                'pbd_hrgsatuan' => $d->pdm_hrgsatuan,
                                'pbd_persendisc1' => $d->pdm_persendisc1,
                                'pbd_rphdisc1' => $d->pdm_rphdisc1,
                                'pbd_flagdisc1' => $d->pdm_flagdisc1,
                                'pbd_persendisc2' => $d->pdm_persendisc2,
                                'pbd_rphdisc2' => $d->pdm_rphdisc2,
                                'pbd_flagdisc2' => $d->pdm_flagdisc2,
                                'pbd_persendisc2ii' => $d->pdm_persendisc2ii,
                                'pbd_rphdisc2ii' => $d->pdm_rphdisc2ii,
                                'pbd_persendisc2iii' => $d->pdm_persendisc2iii,
                                'pbd_rphdisc2iii' => $d->pdm_rphdisc2iii,
                                'pbd_bonuspo1' => $d->pdm_bonuspo1,
                                'pbd_bonuspo2' => $d->pdm_bonuspo2,
                                'pbd_bonusbpb1' => $d->pdm_bonusbpb1,
                                'pbd_bonusbpb2' => $d->pdm_bonusbpb2,
                                'pbd_gross' => $d->pdm_gross,
                                'pbd_rphttldisc' => $d->pdm_rphttldisc,
                                'pbd_ppn' => $d->pdm_ppn,
                                'pbd_ppnbm' => $d->pdm_ppnbm,
                                'pbd_ppnbotol' => $d->pdm_ppnbotol,
                                'pbd_top' => $d->pdm_top,
                                'pbd_nopo' => $d->pdm_nopo,
                                'pbd_ostpb' => $d->pdm_ostpb,
                                'pbd_ostpo' => $d->pdm_ostpo,
                                'pbd_pkmt' => $d->pdm_pkmt,
                                'pbd_saldoakhir' => $d->pdm_saldoakhir,
                                'pbd_fdxrev' => $d->pdm_fdxrev,
                                'pbd_flaggudangpusat' => $d->pdm_flaggudangpusat,
                                'pbd_create_by' => Session::get('usid'),
                                'pbd_create_dt' => Carbon::now(),
                                'pbd_persenppn' => $d->prd_ppn
                            ]);
                    }

                    DB::connection(Session::get('connection'))->commit();

                    $responses = [];
                    $responses[] = [
                        'message' => (__('Draft PB sudah menjadi PB Manual nomor ')).$noPB,
                        'status' => 'success'
                    ];

                    $query = oci_parse($connect, "BEGIN sp_kirimdatapb_migrasi('".$draftNo."',:lok,:v_message); END;");
                    oci_bind_by_name($query, ':lok', $lok, 32);
                    oci_bind_by_name($query, ':v_message', $v_message, 255);
                    oci_execute($query);

                    if($lok == 'FALSE'){
                        $responses[] = [
                            'message' => (__('Data Draft PB tidak dapat di email - ')).$v_message,
                            'status' => 'error'
                        ];
                    }
                    else{
                        $responses[] = [
                            'message' => (__('Data Draft PB sudah di email!')),
                            'status' => 'success'
                        ];
                    }

                    return response()->json($responses, 200);
                }
            }
            else{
                return response()->json([
                    'message' => $v_message
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
}
