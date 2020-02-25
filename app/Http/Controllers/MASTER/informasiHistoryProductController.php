<?php

namespace App\Http\Controllers\MASTER;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\NotIn;
use phpDocumentor\Reflection\Types\Integer;


class informasiHistoryProductController extends Controller
{
    public function index(){
        $produk = DB::table('tbmaster_prodmast')
            ->select('prd_prdcd','prd_deskripsipanjang')
            ->where(DB::RAW('SUBSTR(prd_prdcd,7,1)'),'=','0')
            ->orderBy('prd_deskripsipanjang')
            ->limit(1000)
            ->get();
        return view('MASTER.informasiHistoryProduct')->with('produk',$produk);
    }
    public function lov_search(Request $request){
        if(is_numeric($request->value)){
            $result = DB::table('tbmaster_prodmast')
                ->select('prd_prdcd','prd_deskripsipanjang')
                ->where('prd_prdcd','like','%'.$request->value.'%')
                ->orderBy('prd_deskripsipanjang')
                ->get();
        }


        else{
            $result = DB::table('tbmaster_prodmast')
                ->select('prd_prdcd','prd_deskripsipanjang')
                ->where('prd_deskripsipanjang','like','%'.$request->value.'%')
                ->orderBy('prd_deskripsipanjang')
                ->get();
        }
        return $result;
    }
    public function lov_select(Request $request)
    {
        $message = '';
        $lCek = 1;
        $cprdcd = $request->value;
        if (ord(substr($cprdcd,1,1)) < 48 || ord(substr($cprdcd,1,1)) >57) {
          $lCek = 2;
        }
        else if(strlen(trim($cprdcd)) > 7 ) {
            $lCek = 3;
        }

        if($lCek == 1){
            $plu = DB::table('tbmaster_barcode')->rightJoin('tbmaster_prodmast','brc_prdcd','=','prd_prdcd')
                ->selectRaw('distinct prd_prdcd, prd_deskripsipendek, brc_barcode')
                ->where('prd_prdcd','=',$request->value)
                ->first();
            if (is_null($plu)){
                $message = 'Kode Tidak Terdaftar !!';
                return $message;
            }
        }
        else if ($lCek == 2){
            $plu = DB::table('tbmaster_barcode')->rightJoin('tbmaster_prodmast','brc_prdcd','=','prd_prdcd')
                ->selectRaw('distinct prd_prdcd, prd_deskripsipendek, brc_barcode')
                ->whereRaw('lower(prd_deskripsipendek) = \''.strtolower($request->value).'\'')
                ->first();
            if (is_null($plu)){
                $message = 'Deskripsi Tidak Terdaftar !!';
                return $message;
            }
        }
        else{
            $plu = DB::table('tbmaster_barcode')->join('tbmaster_prodmast','brc_prdcd','=','prd_prdcd')
                ->selectRaw('distinct prd_prdcd, prd_deskripsipendek, brc_barcode')
                ->where('brc_barcode','=',$request->value)
                ->first();
            if (is_null($plu)){
                $message = 'Barcode Tidak Terdaftar !!';
                return $message;
            }
        }

        $produk = DB::table('TBMASTER_CABANG')->Join('TBMASTER_PRODMAST', function ($join) {
            $join->on('CAB_KODECABANG', '=', 'PRD_KODEIGR')->On('CAB_KODEIGR', '=', 'PRD_KODEIGR');
        })->leftJoin('TBMASTER_STOCK', function ($join) {
            $join->On(DB::raw('SUBSTR (ST_PRDCD, 1, 6)'),'=',DB::raw('SUBSTR (PRD_PRDCD, 1, 6)'))->On('ST_KODEIGR', '=', 'PRD_KODEIGR')->On('ST_LOKASI', '=', 01);
        })->Join('TBMASTER_DIVISI', function ($join) {
            $join->On('DIV_KODEDIVISI', '=', 'PRD_KODEDIVISI')->On('DIV_KODEIGR', '=', 'PRD_KODEIGR');
        })->Join('TBMASTER_DEPARTEMENT', function ($join) {
            $join->On('DEP_KODEDEPARTEMENT', '=', 'PRD_KODEDEPARTEMENT')->On('DEP_KODEIGR', '=', 'PRD_KODEIGR')->On('DEP_KODEDIVISI', '=', 'DIV_KODEDIVISI');
        })->Join('TBMASTER_KATEGORI', function ($join) {
            $join->On('KAT_KODEKATEGORI', '=', 'PRD_KODEKATEGORIBARANG')->On('KAT_KODEIGR', '=', 'PRD_KODEIGR')->On('KAT_KODEDEPARTEMENT', '=', 'DEP_KODEDEPARTEMENT');
        })->leftJoin('TBMASTER_MINIMUMORDER', function ($join) {
            $join->On(DB::raw('SUBSTR (MIN_PRDCD, 1, 6)'),'=',DB::raw('SUBSTR (PRD_PRDCD, 1, 6)'))->On('MIN_KODEIGR', '=', 'PRD_KODEIGR')->On('KAT_KODEDEPARTEMENT', '=', 'DEP_KODEDEPARTEMENT');
        })->leftJoin('TBTR_PROMOMD', function ($join) {
            $join->On('PRMD_PRDCD', '=', 'PRD_PRDCD')->On('PRMD_KODEIGR', '=', 'PRD_KODEIGR');
        })->leftJoin('TBMASTER_BARCODE', function ($join) {
            $join->On('BRC_PRDCD', '=', 'PRD_PRDCD')->whereNotNull('BRC_BARCODE');
        })->SelectRaw('PRD_PRDCD,
                   PRD_DESKRIPSIPANJANG,
                   PRD_KODETAG,
                   PRD_FLAGBKP1,
                   PRD_FLAGBANDROL,
                   PRD_UNIT,
                   PRD_FRAC,
                   PRD_FLAGGUDANG,
                   PRD_KODECABANG,
                   PRD_KATEGORITOKO,
                   PRD_KODEDIVISI,
                   DIV_NAMADIVISI,
                   PRD_KODEDEPARTEMENT,
                   DEP_NAMADEPARTEMENT,
                   PRD_KODEKATEGORIBARANG,
                   KAT_NAMAKATEGORI,
                   PRD_MINORDER,
                   PRD_ISIBELI,
                   PRD_CREATE_DT,
                   PRD_HRGJUAL,
                   CAB_NAMACABANG,
                   ST_AVGCOST,
                   MIN_MINORDER,
                   PRMD_PRDCD,
                   PRMD_HRGJUAL,
                   PRMD_POTONGANPERSEN,
                   PRMD_POTONGANRPH,
                   BRC_BARCODE,
                   MAX (PRMD_TGLAWAL) PRM_TGLMULAI,
                   MAX (PRMD_TGLAKHIR) PRM_TGLAKHIR,
                   MAX (PRMD_JAMAWAL) PRM_JAMMULAI,
                   MAX (PRMD_JAMAKHIR) PRM_JAMAKHIR,
                   NVL (PRD_FLAGOBI, \'N\') OBI,
                   NVL (PRD_FLAGNAS, \'N\') NAS,
                   NVL (PRD_FLAGBRD, \'N\') BRD,
                   NVL (PRD_FLAGOMI, \'N\') OMI,
                   NVL (PRD_FLAGIDM, \'N\') IDM,
                   NVL (PRD_FLAGIGR, \'N\') IGR')
            ->where('prd_prdcd','=',$request->value)
            ->groupBy(DB::raw('PRD_PRDCD,
                   PRD_DESKRIPSIPANJANG,
                   PRD_KODETAG,
                   PRD_FLAGBKP1,
                   PRD_FLAGBANDROL,
                   PRD_UNIT,
                   PRD_FRAC,
                   PRD_FLAGGUDANG,
                   PRD_KODECABANG,
                   PRD_KATEGORITOKO,
                   PRD_KODEDIVISI,
                   DIV_NAMADIVISI,
                   PRD_KODEDEPARTEMENT,
                   DEP_NAMADEPARTEMENT,
                   PRD_KODEKATEGORIBARANG,
                   KAT_NAMAKATEGORI,
                   PRD_MINORDER,
                   PRD_ISIBELI,
                   PRD_CREATE_DT,
                   PRD_HRGJUAL,
                   CAB_NAMACABANG,
                   ST_AVGCOST,
                   MIN_MINORDER,
                   BRC_BARCODE,
                   PRMD_HRGJUAL,
                   PRMD_POTONGANPERSEN,
                   PRMD_POTONGANRPH,
                   PRMD_PRDCD,
                   NVL (PRD_FLAGOBI, \'N\'),
                   NVL (PRD_FLAGNAS, \'N\'),
                   NVL (PRD_FLAGBRD, \'N\'),
                   NVL (PRD_FLAGOMI, \'N\'),
                   NVL (PRD_FLAGIDM, \'N\'),
                   NVL (PRD_FLAGIGR, \'N\')'))
        ->first();

        $pri = DB::table('tbmaster_prodcrm')
            ->select('*')
            ->where('prc_pluigr','=',$produk->prd_prdcd)
            ->where('prc_group','=','I')
            ->first();

        if(is_null($pri)){
            $plu_idm='N';
            $tag_idm=null;
        }
        else{
            $plu_idm='Y';
            $tag_idm=$pri->prc_kodetag;
        }

        $pro = DB::table('tbmaster_prodcrm')
            ->select('*')
            ->where('prc_pluigr','=',$produk->prd_prdcd)
            ->where('prc_group','=','O')
            ->first();

        if(is_null($pro)){
            $plu_omi='N';
            $tag_omi=null;
        }
        else{
            $plu_omi='Y';
            $tag_omi=$pro->prc_kodetag;
        }

        if($produk->idm=="Y" && $produk->omi=="N"){
            $ITEM = "ITEM IDM";
            if (in_array($tag_idm,['A','R','N','O','H','X'])){
                $ITEM = 'ITEM IDM' . ' [Tag : ' . $tag_idm . ' ]';
            }
        }
        else if($produk->idm=="N" && $produk->omi=="Y"){
            $ITEM = "ITEM OMI";
            if (in_array($tag_omi,['A','R','N','O','H','X'])){
                $ITEM = 'ITEM OMI' . ' [Tag : ' . $tag_omi . ' ]';
            }
        }
        else if($produk->idm=="Y" && $produk->omi=="Y"){
            $ITEM = 'ITEM OMI + ITEM IDM';
        }

        $ketkat ='';
        if($produk->prd_kodedivisi){
            $ketkat='G.M.S';
        }
        else{
            $ketkat=$produk->DIV_NAMADIVISI;
        }

        $KATBRG = $produk->prd_kodedivisi
            .' '
            .$ketkat
            .' '
            .$produk->prd_kodedepartement
            .' '
            .$produk->dep_namadepartement
            .'   '
            .$produk->prd_kodekategoribarang
            .' '
            .$produk->kat_namakategori;


        if( is_null($produk->cab_namacabang) AND is_null($produk->prd_kategoritoko)){
            $message = 'PLU tsb sdh tidak aktif di Cabang ini,; kalau masih ada di rak harap ditarik';
        }
        if(!is_null($produk->prmd_prdcd)){
            $tglmulai = date('d/m/Y',strtotime(substr($produk->prm_tglmulai,0,10)));
            $tglakhir = date('d/m/Y',strtotime(substr($produk->prm_tglakhir,0,10)));
            $tglnow = date('d/m/Y');
            if($tglnow >= $tglmulai AND $tglnow <= $tglakhir){
                $tglpromo  = $tglmulai.' s/d '.$tglakhir;
            }

            if (!is_null($produk->prm_jammulai)){
                $jampromo = $produk->prm_jammulai.' s/d '.$produk->prm_jamakhir;
            }

            if ($produk->prd_hrgjual!=0){
                $hrgpromo = $produk->prmd_hrgjual;
            }
            else if ($produk->prmd_potonganpersen!=0){
                $hrgpromo = $produk->prd_hrgjual - ($produk->prd_hrgjual * ($produk->prmd_potonganpersen / 100));
            }
            else{
                $hrgpromo = ($produk->prd_hrgjual - $produk->prmd_potonganrph);
            }
        }

        if ($this->ceknull ($produk->prd_minorder, 0) > 0){
            $NMINOR = $produk->prd_minorder;
        }
        else{
            $NMINOR = $produk->prd_isibeli;
        }

        if ($produk->nas == 'Y')
        {
            $NAS = 'NASIONAL';
        }
        else{
            $NAS = '';
        }

        if($produk->omi == 'Y'){
            $OMI = 'OMI';
        }
        else{
            $OMI = ' ';
        }

        if ($produk->brd == 'Y'){
            $BRD = 'MR BRD';
        }
        else{
            $BRD = '';
        }

        if ($produk->obi == 'Y'){
            $OBI = 'K.IGR';
        }
        else {
            $OBI = '';
        }

        if ($produk->igr == 'Y'){
            $IGR = 'IGR';
        }
        else{
            $IGR = ' ';
        }

        if($produk->idm == 'Y'){
            $IDM = 'IDM';
        }
        else{
            $IDM = ' ';
        }

        $depo = DB::table('DEPO_LIST_IDM')->join('TBMASTER_PRODMAST','PLUIDM','PRD_PLUMCG')
            ->select('*')
            ->where('PRD_PRDCD','=',$produk->prd_prdcd)
            ->first();
        if(is_null($depo)){
            $flagdepo = 'Y';
            $depo = 'DEPO';
        }
        else{
            $flagdepo = 'N';
            $depo = '';
        }
        return compact(['produk']);
    }

    public function ceknull(string $value,string $ret){
        if($value==""){
            return $ret;
        }
        return $value;
    }
}
