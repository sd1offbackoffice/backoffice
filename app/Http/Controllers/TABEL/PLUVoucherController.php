<?php

namespace App\Http\Controllers\TABEL;

use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller; use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;
use PDF;
use Yajra\DataTables\DataTables;

class PLUVoucherController extends Controller
{
    public function index(){
        return view('TABEL.plu-voucher');
    }

    public function getData(Request $request){
        if(substr($request->kode,0,3) == 'IGR'){
            return response()->json([
                'message' => 'Voucher Supplier salah!'
            ], 500);
        }
        else{
            $temp = DB::connection(Session::get('connection'))->selectOne("SELECT VCS_JOINPROMO
                    FROM TBTABEL_VOUCHERSUPPLIER
                    WHERE VCS_KODEIGR = '".Session::get('kdigr')."'
                    AND TRIM(VCS_NAMASUPPLIER) = TRIM('".$request->kode."')");

            if(!$temp){
                return response()->json([
                    'message' => 'Kode Voucher tidak ada!'
                ], 500);
            }
            else{
                if($temp->vcs_joinpromo != 'Y'){
                    return response()->json([
                        'message' => 'Bukan Voucher kerja sama External;Indogrosir, Supplier, dan Pihak ke-3!'
                    ], 500);
                }
                else{
                    $header = DB::connection(Session::get('connection'))->selectOne("SELECT vcs_namasupplier, 'Voucher @Rp.' || TO_CHAR(vcs_nilaivoucher,'9,999,999') nilai,
                    vcs_keterangan, to_char(vcs_tglmulai, 'dd/mm/yyyy') vcs_tglmulai, to_char(vcs_tglakhir,'dd/mm/yyyy') vcs_tglakhir
                    FROM tbtabel_vouchersupplier
                    where vcs_kodeigr = '".Session::get('kdigr')."'
                    and vcs_namasupplier = trim('".$request->kode."')");

                    $detail = DB::connection(Session::get('connection'))->table('tbtabel_produkvoucher')
                        ->join('tbmaster_hargabeli',function($join){
                            $join->on('hgb_kodeigr','=','pvc_kodeigr');
                            $join->on('hgb_prdcd','=','pvc_prdcd');
                        })
                        ->join('tbmaster_supplier',function($join){
                            $join->on('sup_kodeigr','=','pvc_kodeigr');
                            $join->on('sup_kodesupplier','=','hgb_kodesupplier');
                        })
                        ->join('tbmaster_prodmast',function($join){
                            $join->on('prd_kodeigr','=','pvc_kodeigr');
                            $join->on('prd_prdcd','=','pvc_prdcd');
                        })
                        ->selectRaw("pvc_prdcd prdcd, prd_deskripsipanjang desk, sup_kodesupplier kodesupplier, sup_namasupplier namasupplier")
                        ->where('pvc_kodeigr','=',Session::get('kdigr'))
                        ->whereRaw("trim(pvc_idvoucher) = trim('".$request->kode."')")
                        ->orderBy('pvc_nourut','asc')
                        ->get();
                }
            }

            return response()->json(compact(['header','detail']), 200);
        }
    }


    public function getLovVoucher(){
        $data = DB::connection(Session::get('connection'))->select("SELECT vcs_namasupplier, 'Voucher @Rp.' || TO_CHAR(vcs_nilaivoucher,'9,999,999') nilai,
            vcs_keterangan, to_char(vcs_tglmulai, 'dd/mm/yyyy') vcs_tglmulai, to_char(vcs_tglakhir,'dd/mm/yyyy') vcs_tglakhir
            FROM tbtabel_vouchersupplier");

        return DataTables::of($data)->make(true);
    }

    public function getLovSupplier(){
        $data = DB::connection(Session::get('connection'))->table('tbmaster_supplier')
            ->selectRaw('sup_kodesupplier kode, sup_namasupplier nama')
            ->where('sup_kodeigr','=',Session::get('kdigr'))
            ->get();

        return DataTables::of($data)->make(true);
    }

    public function getSupplier(Request $request){
        $data = DB::connection(Session::get('connection'))->table('tbmaster_supplier')
            ->selectRaw('sup_kodesupplier kode, sup_namasupplier nama')
            ->where('sup_kodeigr','=',Session::get('kdigr'))
            ->where('sup_kodesupplier','=',$request->kodesupplier)
            ->first();

        if($data){
            return response()->json($data, 200);
        }
        else{
            return response()->json([
                'message' => 'Supplier tidak ditemukan!'
            ], 500);
        }
    }

    public function getDataPLUSupplier(Request $request){
        $data = DB::connection(Session::get('connection'))->table('tbmaster_hargabeli')
            ->join('tbmaster_prodmast',function($join){
                $join->on('prd_kodeigr','=','hgb_kodeigr');
                $join->on('prd_prdcd','=','hgb_prdcd');
            })
            ->selectRaw('hgb_prdcd prdcd, prd_deskripsipanjang desk, prd_kodetag tag')
            ->where('hgb_kodeigr','=',Session::get('kdigr'))
            ->where('hgb_kodesupplier','=',$request->supplier)
            ->orderBy('hgb_prdcd','asc')
            ->get();

        return DataTables::of($data)->make(true);
    }

    public function getPLU(Request $request){
        $plu = $request->plu;

        if(substr($plu,0,1) == '#')
            $plu = substr($plu,1);

        $plu = substr('0000000'.$plu, -7);

        if(substr($plu, -1) != '0'){
            return response()->json([
                'message' => 'PLU harus satuan jual 0!'
            ], 500);
        }

        $temp = DB::connection(Session::get('connection'))->selectOne("SELECT prd_prdcd, prd_deskripsipanjang
          FROM TBMASTER_PRODMAST, TBMASTER_BARCODE
         WHERE prd_kodeigr = '".Session::get('kdigr')."'
           AND prd_prdcd = brc_prdcd(+)
           AND (prd_prdcd = TRIM ('".$plu."') OR brc_barcode = TRIM ('".$plu."'))");

        if(!$temp){
            return response()->json([
                'message' => 'Kode PLU '.$plu.' - '.Session::get('kdigr').' tidak terdaftar di Master Barang!'
            ], 500);
        }

        $data = [
            'prdcd' => $temp->prd_prdcd,
            'desk' => $temp->prd_deskripsipanjang
        ];

        $temp = DB::connection(Session::get('connection'))->selectOne("SELECT HGB_KODESUPPLIER, SUP_NAMASUPPLIER
			FROM TBMASTER_HARGABELI, TBMASTER_SUPPLIER
			WHERE HGB_KODEIGR = '".Session::get('kdigr')."'
			AND HGB_TIPE = '2'
			AND HGB_PRDCD = '".$plu."'
			AND SUP_KODEIGR = HGB_KODEIGR
			AND SUP_KODESUPPLIER = HGB_KODESUPPLIER");

        if($temp){
            $data['kodesupplier'] = $temp->hgb_kodesupplier;
            $data['namasupplier'] = $temp->sup_namasupplier;
        }

        return response()->json($data, 200);
    }

    public function saveData(Request $request){
        try{
            DB::connection(Session::get('connection'))->beginTransaction();

            $insert = [];
            $nourut = 1;

            foreach($request->dataPLU as $r){
                if($r['prdcd'] != null){
                    $insert[] = [
                        'pvc_kodeigr' => Session::get('kdigr'),
                        'pvc_idvoucher' => $request->kodevoucher,
                        'pvc_nourut' => $nourut,
                        'pvc_kodesupplier' => $r['kodesupplier'],
                        'pvc_prdcd' => $r['prdcd'],
                        'pvc_nilai1' => 0,
                        'pvc_nilai2' => 0,
                        'pvc_keterangan' => ''
                    ];

                    $nourut++;
                }
            }

            $old = DB::connection(Session::get('connection'))->table('tbtabel_produkvoucher')
                ->where('pvc_kodeigr','=',Session::get('kdigr'))
                ->whereRaw("trim(pvc_idvoucher) = trim('".$request->kodevoucher."')")
                ->orderBy('pvc_nourut','asc')
                ->get();

            DB::connection(Session::get('connection'))->table('tbtabel_produkvoucher')
                ->where('pvc_kodeigr','=',Session::get('kdigr'))
                ->whereRaw("trim(pvc_idvoucher) = trim('".$request->kodevoucher."')")
                ->delete();

            $i = 0;
            for($i=0;$i<count($insert);$i++){
                if($i < count($old)){
                    $insert[$i]['pvc_create_by'] = $old[$i]->pvc_create_by;
                    $insert[$i]['pvc_create_dt'] = $old[$i]->pvc_create_dt;
                    $insert[$i]['pvc_modify_by'] = Session::get('usid');
                    $insert[$i]['pvc_modify_dt'] = Carbon::now();
                }
                else{
                    $insert[$i]['pvc_create_by'] = Session::get('usid');
                    $insert[$i]['pvc_create_dt'] = Carbon::now();
                }

                DB::connection(Session::get('connection'))->table('tbtabel_produkvoucher')
                    ->insert($insert[$i]);
            }

            DB::connection(Session::get('connection'))->commit();

            return response()->json([
                'message' => 'Berhasil menyimpan data!'
            ], 200);
        }
        catch (\Exception $e){
            DB::connection(Session::get('connection'))->rollBack();

            return response()->json([
                'messsage' => 'Gagal menyimpan data!',
                'detail' => $e->getMessage()
            ], 500);
        }
    }

    public function getListSupplier(Request $request){
        $dataSupplier = DB::connection(Session::get('connection'))->table('tbtabel_produkvoucher')
            ->join('tbmaster_supplier',function($join){
                $join->on('sup_kodeigr','=','pvc_kodeigr');
                $join->on('sup_kodesupplier','=','pvc_kodesupplier');
            })
            ->selectRaw("pvc_kodesupplier kodesupplier, sup_namasupplier namasupplier")
            ->where('pvc_idvoucher','=',$request->kodevoucher)
            ->orderBy('sup_namasupplier')
            ->groupBy(['pvc_kodesupplier','sup_namasupplier'])
            ->get();

        return DataTables::of($dataSupplier)->make(true);
    }
}
