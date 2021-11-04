<?php

namespace App\Http\Controllers\MASTER;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\NotIn;
use phpDocumentor\Reflection\Types\Integer;
use Yajra\DataTables\DataTables;


class jenisItemController extends Controller
{
    public function index(){
        return view('MASTER.jenisItem');
    }

    public function getProdmast(Request  $request){
        $search = $request->value;

        $prodmast   = DB::connection($_SESSION['connection'])->table('tbmaster_prodmast')
            ->select('prd_prdcd','prd_deskripsipanjang')
            ->where('prd_prdcd','LIKE', '%'.$search.'%')
            ->orWhere('prd_deskripsipanjang','LIKE', '%'.$search.'%')
            ->where(DB::RAW('SUBSTR(prd_prdcd,7,1)'),'=','0')
            ->orderBy('prd_deskripsipanjang')
            ->limit(100)
            ->get();

        return Datatables::of($prodmast)->make(true);
    }

    public function lov_search(Request $request){
        if(is_numeric($request->value)){
            $result = DB::connection($_SESSION['connection'])->table('tbmaster_prodmast')
                ->select('prd_prdcd','prd_deskripsipanjang')
                ->where('prd_prdcd','like','%'.$request->value.'%')
                ->orderBy('prd_deskripsipanjang')
                ->get();
        }


        else{
            $result = DB::connection($_SESSION['connection'])->table('tbmaster_prodmast')
                ->select('prd_prdcd','prd_deskripsipanjang')
                ->where('prd_deskripsipanjang','like','%'.$request->value.'%')
                ->orderBy('prd_deskripsipanjang')
                ->get();
        }
        return $result;
    }

    public function ceknull(string $value,string $ret){
        if($value==""){
            return $ret;
        }
        return $value;
    }

    public function lov_select(Request $request)
    {
        $lokasi = DB::connection($_SESSION['connection'])->table('tbmaster_lokasi')
            ->select('lks_koderak',
                'lks_kodesubrak',
                'lks_tiperak',
                'lks_shelvingrak',
                'lks_nourut',
                'lks_jenisrak',
                'lks_qty',
                'lks_maxplano',
                'lks_maxdisplay')
            ->where('lks_prdcd', '=', $request->value)
            ->where('lks_kodeigr', '=', '22')
            ->orderby('lks_koderak')->orderby('lks_kodesubrak')->orderby('lks_tiperak')->orderby('lks_shelvingrak')->orderby('lks_nourut')
            ->get();



        $produk = DB::connection($_SESSION['connection'])->table('tbmaster_prodmast')
            ->select('*')
            ->where('prd_prdcd', '=', $request->value)
            ->first();

        $palet = DB::connection($_SESSION['connection'])->table('TBMASTER_MAXPALET')
            ->select('*')
            ->where('mpt_prdcd', '=', $request->value)
            ->first();

        $trendsales = DB::connection($_SESSION['connection'])->table('TBTR_SALESBULANAN')
            ->select('*')
            ->whereRaw("substr(sls_prdcd, 1, 6) = substr('".$request->value."',1,6)")
            ->first();

        $trendsales = (array)$trendsales;
        $blnberjalan = DB::connection($_SESSION['connection'])->table('TBMASTER_PERUSAHAAN')
            ->select('PRS_BULANBERJALAN')
            ->first();

        $VAVG = 0;
        $N = 0;
        $X = 0;
        $X1 = 0;

        $FMPBLNA = (int)$blnberjalan->prs_bulanberjalan;

        if ($FMPBLNA - 1 < 1) {
            $N = 12;
            $VAVG = $VAVG + (int)$trendsales['sls_qty_12'];
        } else {
            $N = $FMPBLNA - 1;
            if ($N < 10) {
                $N = '0' . $N;
            }
            $VAVG = $VAVG + (int)$trendsales['sls_qty_' . $N];
        }

        if ($N - 1 < 1) {
            $X = 12;
            $VAVG  = $VAVG + (int)$trendsales['sls_qty_12'];
        }
        else{
            $X = $N - 1;
            if ($X < 10) {
                $X = '0' . $X;
            }
            $VAVG = $VAVG + (int)$trendsales['sls_qty_' . $X];
        }

        if( $X - 1 < 1){
            $X1 = 12;
            $VAVG  = $VAVG + (int)$trendsales['sls_qty_12'];
        }
        else{
            $X1 = $X - 1;
            if ($X1 < 10) {
                $X1 = '0' . $X1;
            }
            $VAVG = $VAVG + (int)$trendsales['sls_qty_' . $X1];
        }

    $TEMP = date('m');
        $prodstock = DB::connection($_SESSION['connection'])->table('tbmaster_prodmast')->join('tbmaster_stock','prd_kodeigr','=','st_kodeigr')
            ->select('*')
            ->where('prd_prdcd', '=', $request->value)
            ->where('prd_kodeigr', '=', "22")
            ->whereRaw('substr (tbmaster_stock.st_prdcd, 1, 6) = substr (tbmaster_prodmast.prd_prdcd, 1, 6)')
            ->where('st_lokasi', '=', "01")
            ->first();

        if($prodstock->st_lokasi =='01'){
            $prodstock->st = 'BK';
        }
        else if($prodstock->st_lokasi ='02'){
            $prodstock->st = 'RT';
        }
        else{
            $prodstock->st = 'RS';
        }

        $VUNIT = $prodstock->prd_unit;
        $VSALES = $prodstock->st_sales;
        $VLASTCOST = $prodstock->st_avgcost;
        $VFRAC = 0;

        if( $VUNIT == 'KG'){
            $VFRAC = 1000;
        }
        else{
            $VFRAC = 1;
        }

        $trendsales['sls_qty_' . $TEMP] = $VSALES / $VFRAC;
        $trendsales['sls_rph_' . $TEMP] = $VLASTCOST * ($VSALES / $VFRAC);

        if (!isset($VAVG) or $VAVG==0 or is_null($VAVG) ){
            $VAVG = 0;
        }
        $AVGSALES = $VAVG / 3;

        $po = DB::connection($_SESSION['connection'])->table('tbtr_po_h')->join('tbtr_po_d','TPOH_NOPO','=','TPOD_NOPO')->leftJoin('TBTR_PB_D', function ($join) {
            $join->on('TPOD_NOPO', '=', 'PBD_NOPO')->On('TPOD_PRDCD', '=', 'PBD_PRDCD');
        })
            ->select('*')
            ->where('tpod_prdcd', '=', $request->value)
            ->where('tpod_kodeigr', '=', '22')
            ->whereRaw('NVL (TPOH_RECORDID, \'0\') NOT IN (\'2\', \'*\', \'1\')')
            ->whereRaw('trunc (tbtr_po_h.tpoh_tglpo + tbtr_po_h.tpoh_jwpb) >= trunc (to_date('.date("Ymd").',\'yyyymmdd\'))')
            ->orderby('tpoh_tglpo','desc')
            ->get();

        for($i=0;$i<sizeof($po);$i++){
            if($po[$i]->pbd_nopo == ''){
                $po[$i]->tpoh_nopo = $po[$i]->tpoh_nopo.' ( * )';
//                dd($po[0]->pbd_nopo);
            }
        }

        $supplier = DB::connection($_SESSION['connection'])->table('TBTR_MSTRAN_D')->leftJoin('TBMASTER_SUPPLIER','MSTD_KODESUPPLIER','=','SUP_KODESUPPLIER')
            ->select('*')
            ->whereRaw('substr(mstd_prdcd, 1, 6) = substr(\''.$request->value.'\', 1, 6)')
            ->where('mstd_kodeigr', '=', '22')
            ->whereIn('mstd_typetrn', ['L', 'I', 'B'])
            ->whereRaw('NVL (MSTD_RECORDID, \'9\') != 1')
            ->orderBy('mstd_prdcd')
            ->orderBy('mstd_tgldoc')
            ->get();

        for($i=0;$i<sizeof($supplier);$i++){
            $supplier[$i]->trm_qtybns =  $this->ceknull($supplier[$i]->mstd_qty,0);
            $supplier[$i]->trm_bonus = $this->ceknull($supplier[$i]->mstd_qtybonus1,0);
            $supplier[$i]->trm_bonus2 = $this->ceknull($supplier[$i]->mstd_qtybonus2,0);
            $supplier[$i]->trm_dokumen = $supplier[$i]->mstd_nodoc;
            $supplier[$i]->trm_tanggal = $supplier[$i]->mstd_tgldoc;
            $supplier[$i]->trm_supp = $supplier[$i]->sup_namasupplier;

            if( $supplier[$i]->mstd_typetrn == 'I'){
                $supplier[$i]->trm_top = 'Surat Jln';
            }
            elseif ($supplier[$i]->mstd_typetrn == 'L'){
                $supplier[$i]->trm_top = 'Lain2/Bns';
            }
            elseif ($supplier[$i]->mstd_typetrn == 'B'){
                $supplier[$i]->trm_top = 'BPB';
            }

            $supplier[$i]->trm_acost = $supplier[$i]->mstd_avgcost / $supplier[$i]->mstd_frac;

            if( $supplier[$i]->mstd_typetrn == 'L'){
                $supplier[$i]->trm_hpp = 0;
            }
            else{
                $supplier[$i]->trm_hpp = ($supplier[$i]->mstd_gross - ($supplier[$i]->mstd_discrph + $supplier[$i]->mstd_ppnbmrph + $supplier[$i]->mstd_ppnbtlrph)) /($supplier[$i]->mstd_qty / $supplier[$i]->mstd_frac) / $supplier[$i]->mstd_frac;
            }

        }

        return compact(['lokasi','produk','palet','prodstock','trendsales','AVGSALES','po','supplier']);
    }

    public function savedata(Request $request){
        date_default_timezone_set('Asia/Jakarta');
        $date       = date('Y-m-d H:i:s');

        if ($request->jenisrak == 'N') {

            $TEMP = DB::connection($_SESSION['connection'])->table('TBMASTER_LOKASI')
                ->select('*')
                ->where('LKS_KODEIGR', '=', '22')
                ->where('LKS_PRDCD', '=', $request->prdcd)
                ->where('LKS_JENISRAK', '=', 'S')
                ->count();

            if ($this->ceknull($TEMP, 0) == 0) {
                DB::connection($_SESSION['connection'])->table('TBMASTER_LOKASI')
                    ->where('LKS_KODEIGR', '22')
                    ->where('LKS_PRDCD', $request->prdcd)
                    ->whereRaw('NVL(LKS_JENISRAK, \'A\') IN(\'A\', \'D\', \'N\')')
                    ->update(['LKS_JENISRAK' => $request->jenisrak]);

                $TEMP = DB::connection($_SESSION['connection'])->table('TBMASTER_PLUPLANO')
                    ->select('*')
                    ->where('PLN_PRDCD', '=', $request->prdcd)
                    ->count();

                if ($this->ceknull($TEMP, 0) == 0) {

                    DB::connection($_SESSION['connection'])->table('TBMASTER_PLUPLANO')->insert(
                        ['PLN_KODEIGR' => '22', 'PLN_PRDCD' => $request->prdcd, 'PLN_JENISRAK' => $request->jenisrak, 'PLN_CREATE_BY' => 'WEB', 'PLN_CREATE_DT' => $date]
                    );
                    $message = 'Data Berhasil Tersimpan!';
                    $status = 'success';
                    return compact(['message','status']);
                }
                else {
                    DB::connection($_SESSION['connection'])->table('TBMASTER_PLUPLANO')
                        ->where('PLN_PRDCD', $request->prdcd)
                        ->update(['PLN_JENISRAK' => $request->jenisrak,'PLN_MODIFY_BY' => 'WEB','PLN_MODIFY_DT' => $date]);
                    $message = 'Data Berhasil Terupdate!';
                    $status = 'success';
                    return compact(['message','status']);
                }
            } else {
                $message = 'Masih Ada Storage Untuk PLU ini, SO Terlebih Dahulu !!';
                $status = 'warning';
                return compact(['message','status']);
            }
        }
        else{
            DB::connection($_SESSION['connection'])->table('TBMASTER_LOKASI')
                ->where('LKS_KODEIGR', '22')
                ->where('LKS_PRDCD', $request->prdcd)
                ->whereRaw('NVL(LKS_JENISRAK, \'A\') IN(\'A\', \'D\', \'N\')')
                ->update(['LKS_JENISRAK' => $request->jenisrak]);

            $TEMP = DB::connection($_SESSION['connection'])->table('TBMASTER_PLUPLANO')
                ->select('*')
                ->where('PLN_PRDCD', '=', $request->prdcd)
                ->count();

            if ($this->ceknull($TEMP, 0) == 0 ) {

                DB::connection($_SESSION['connection'])->table('TBMASTER_PLUPLANO')->insert(
                    ['PLN_KODEIGR' => '22', 'PLN_PRDCD' => $request->prdcd, 'PLN_JENISRAK' => $request->jenisrak, 'PLN_CREATE_BY' => 'WEB', 'PLN_CREATE_DT' => $date]
                );
                $message = 'Data Berhasil Tersimpan!';
                $status = 'success';
                return compact(['message','status']);
            }
            else {
                DB::connection($_SESSION['connection'])->table('TBMASTER_PLUPLANO')
                    ->where('PLN_PRDCD', $request->prdcd)
                    ->update(['PLN_JENISRAK' => $request->jenisrak,'PLN_MODIFY_BY' => 'WEB','PLN_MODIFY_DT' => $date]);
                $message = 'Data Berhasil Terupdate!';
                $status = 'success';
                return compact(['message','status']);
            }
        }
    }
}
