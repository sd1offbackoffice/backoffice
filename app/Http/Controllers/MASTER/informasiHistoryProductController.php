<?php

namespace App\Http\Controllers\MASTER;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\NotIn;
use phpDocumentor\Reflection\Types\Integer;
use Carbon\Carbon;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\File;

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
        $message = array();
        $lCek = 1;
        $cprdcd = $request->value;
        if (ord(substr($cprdcd,1,1)) < 48 OR ord(substr($cprdcd,1,1)) >57) {
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
                array_push($message,'Kode Tidak Terdaftar !!');
                return $message;
            }
        }
        else if ($lCek == 2){
            $plu = DB::table('tbmaster_barcode')->rightJoin('tbmaster_prodmast','brc_prdcd','=','prd_prdcd')
                ->selectRaw('distinct prd_prdcd, prd_deskripsipendek, brc_barcode')
                ->whereRaw('lower(prd_deskripsipendek) = \''.strtolower((string)$request->value).'\'')
                ->first();
            if (is_null($plu)){
                array_push($message,'Deskripsi Tidak Terdaftar !!');
                return $message;
            }
        }
        else{
            $plu = DB::table('tbmaster_barcode')->join('tbmaster_prodmast','brc_prdcd','=','prd_prdcd')
                ->selectRaw('distinct prd_prdcd, prd_deskripsipendek, brc_barcode')
                ->where('brc_barcode','=',$request->value)
                ->first();
            if (is_null($plu)){
                array_push($message,'Barcode Tidak Terdaftar !!');
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
        if($produk->prd_kodedivisi==3){
            $ketkat='G.M.S';
        }
        else{
            $ketkat=$produk->div_namadivisi;
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
            array_push($message,'PLU tsb sdh tidak aktif di Cabang ini,; kalau masih ada di rak harap ditarik');
        }
        if(!is_null($produk->prmd_prdcd)){
            if(Carbon::now() >= $produk->prm_tglmulai AND Carbon::now() <= $produk->prm_tglakhir){
                $tglpromo  = Carbon::now().' s/d '.$produk->prm_tglakhir;
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

        if (self::ceknull ($produk->prd_minorder, 0) > 0){
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
        $flag= [];
        $flag['NAS'] = $NAS;
        $flag['OMI'] = $OMI;
        $flag['BRD'] = $BRD;
        $flag['OBI'] = $OBI;
        $flag['IGR'] = $IGR;
        $flag['IDM'] = $IDM;
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

        $produk->katbrg =$KATBRG;

        //satuan jual
        $sj = DB::table('TBMASTER_PRODMAST')->leftJoin('TBTR_PROMOMD', function ($join) {
            $join->on('PRD_PRDCD', '=', 'PRMD_PRDCD')->On('PRD_KODEIGR', '=', 'PRMD_KODEIGR');
        })->leftJoin('TBMASTER_STOCK', function ($join) {
            $join->On(DB::raw('SUBSTR (PRD_PRDCD, 1, 6)'),'=',DB::raw('SUBSTR (ST_PRDCD, 1, 6)'))->On('PRD_KODEIGR', '=', 'ST_KODEIGR')->On('ST_LOKASI', '=', 01);
        })->SelectRaw('PRD_PRDCD, 
                                PRD_MINJUAL MINJ, 
                                PRD_FLAGBKP1 PKP,
                                NVL (PRD_FLAGBKP2, \'xx\') PKP2, 
                                PRD_HRGJUAL PRICE_A, 
                                PRD_KODETAG PTAG,
                                NVL (PRD_LASTCOST, 0) 
                                PRD_LCOST, 
                                PRD_UNIT UNIT, 
                                PRD_FRAC FRAC,
                                PRD_BARCODE BARC, 
                                NVL (PRMD_PRDCD, \'xxx\') PRMD_PRDCD, 
                                PRMD_HRGJUAL FMJUAL,
                                PRMD_POTONGANPERSEN FMPOTP, 
                                PRMD_POTONGANRPH FMPOTR, 
                                PRD_FLAGBARANGORDERTOKO,
                                NVL (ST_AVGCOST, 0) ST_LCOST, 
                                NVL(ST_LASTCOST, 0) ST_LASTCOST, 
                                MAX (PRMD_TGLAWAL) FMFRTG,
                                MAX (PRMD_TGLAKHIR) FMTOTG,
                                PRMD_JAMAWAL FMFRHR, 
                                PRMD_JAMAKHIR FMTOHR ')
            ->whereRaw('SUBSTR (PRD_PRDCD, 1, 6) = SUBSTR (\''.$request->value.'\', 1, 6)')
            ->groupBy(DB::raw('PRD_PRDCD,
                         PRD_MINJUAL,
                         PRD_FLAGBKP1,
                         PRD_FLAGBKP2,
                         PRD_HRGJUAL,
                         PRD_BARCODE,
                         PRD_KODETAG,
                         PRD_LASTCOST,
                         PRD_FLAGBARANGORDERTOKO,
                         PRD_UNIT,
                         PRD_FRAC,
                         PRMD_PRDCD,
                         PRMD_HRGJUAL,
                         PRMD_POTONGANPERSEN,
                         PRMD_POTONGANRPH,
                         ST_AVGCOST,
                         ST_LASTCOST,
                         PRMD_JAMAWAL, 
                         PRMD_JAMAKHIR'))
            ->orderBy('PRD_PRDCD')
            ->get();
        for($i=0;$i<sizeof($sj);$i++){
            if ($sj[$i]->unit == 'KG'){
                $sj[$i]->frac = 1;
            }
            if($sj[$i]->prmd_prdcd != 'xxx'){
                $tglrtg = date('d/m/Y H:i:S',strtotime(substr($sj[$i]->fmfrtg,0,10).self::ceknull($sj[$i]->fmfrhr."",'00:00:00')));
                $tglotg = date('d/m/Y H:i:S',strtotime(substr($sj[$i]->fmtotg,0,10).self::ceknull($sj[$i]->fmtohr."",'23:59:59')));
                $tglnow = date('d/m/Y H:i:S');
                if($tglnow >= $tglrtg AND $tglnow <= $tglotg){
                    $cpromo = true;
                    if($sj[$i]->pkp == 'Y' and !in_array($sj[$i]->pkp,['P','W','G'])){
                        if ($sj[$i]->fmjual != 0) {
                            $nfmjual = $sj[$i]->fmjual;
                        }
                        else if($sj[$i]->fmpotp != 0){
                            $nfmjual = $sj[$i]->price_a - ($sj[$i]->price_a * ($sj[$i]->fmpotp / 100));
                        }
                        else{
                            $nfmjual = $sj[$i]->price_a - $sj[$i]->fmpotr;
                        }

                        if ($sj[$i]->ptag == 'Q'){
                            $marlcost = (1 - (($sj[$i]->st_lastcost * $sj[$i]->frac) / $nfmjual)) * 100;
                            $maracost = (1 - (($sj[$i]->st_lcost * $sj[$i]->frac) / $nfmjual)) * 100;
                        }
                        else{
                            $marlcost = (1 - 1.1 * (($sj[$i]->st_lastcost * $sj[$i]->frac)) / $nfmjual) * 100;
                            $maracost = (1 - 1.1 * (($sj[$i]->st_lcost * $sj[$i]->frac)) / $nfmjual) * 100;
                        }
                    }
                    else{
                        if ($sj[$i]->fmjual != 0){
                            $nfmjual = $sj[$i]->fmjual;
                        }
                        else if($sj[$i]->fmpotp != 0){
                            $nfmjual = $sj[$i]->price_a - ($sj[$i]->price_a * ($sj[$i]->fmpotp / 100));
                        }
                        else{
                            $nfmjual = $sj[$i]->price_a - $sj[$i]->fmpotr;
                        }
                        $marlcost = (1 - ($sj[$i]->st_lastcost * $sj[$i]->frac) / $nfmjual) * 100;
                        $maracost = (1 - ($sj[$i]->st_lcost * $sj[$i]->frac) / $nfmjual) * 100;
                    }
                }
                else{
                    $cpromo = false;
                    if($sj[$i]->pkp == 'Y' and !in_array($sj[$i]->pkp,['P','W','G'])) {
                        if ($sj[$i]->ptag == 'Q') {
                            $marlcost = (1 - ($sj[$i]->st_lastcost * $sj[$i]->frac) / $sj[$i]->price_a) * 100;
                            $maracost = (1 - ($sj[$i]->st_lcost * $sj[$i]->frac) / $sj[$i]->price_a) * 100;
                        }
                        else {
                            $marlcost = (1 - 1.1 * ($sj[$i]->st_lastcost * $sj[$i]->frac) / $sj[$i]->price_a) * 100;
                            $maracost = (1 - 1.1 * ($sj[$i]->st_lcost * $sj[$i]->frac) / $sj[$i]->price_a) * 100;
                        }
                    }
                    else {
                        $marlcost = (1 - ($sj[$i]->st_lastcost * $sj[$i]->frac) / $sj[$i]->price_a) * 100;
                        $maracost = (1 - ($sj[$i]->st_lcost * $sj[$i]->frac) / $sj[$i]->price_a) * 100;
                    }
                }
            }
            else{
                $cpromo = false;
                if($sj[$i]->price_a > 0) {
                    if($sj[$i]->pkp == 'Y' and !in_array($sj[$i]->pkp,['P','W','G'])) {
                        if ($sj[$i]->ptag == 'Q') {
                            $marlcost = (1 - ($sj[$i]->st_lastcost * $sj[$i]->frac) / $sj[$i]->price_a) * 100;
                            $maracost = (1 - ($sj[$i]->st_lcost * $sj[$i]->frac) / $sj[$i]->price_a) * 100;
                        } else {
                            $marlcost = (1 - 1.1 * ($sj[$i]->st_lastcost * $sj[$i]->frac) / $sj[$i]->price_a) * 100;
                            $maracost = (1 - 1.1 * ($sj[$i]->st_lcost * $sj[$i]->frac) / $sj[$i]->price_a) * 100;
                        }
                    }
                    else{
                        $marlcost = (1 - ($sj[$i]->st_lastcost * $sj[$i]->frac) / $sj[$i]->price_a) * 100;
                        $maracost = (1 - ($sj[$i]->st_lcost * $sj[$i]->frac) / $sj[$i]->price_a) * 100;
                    }

                }
                else{
                    $marlcost = 0;
                    $maracost = 0;
                }
            }
            $sj[$i]->sj_sj = SUBSTR ($sj[$i]->prd_prdcd, -1);
            $barcode = DB::table('tbmaster_barcode')
                ->select('brc_barcode')
                ->where('brc_status','=','BC')
                ->where('brc_prdcd','=', $sj[$i]->prd_prdcd)
                ->get();
            $sj_barcode="";
            $sj[$i]->sj_barcode="";
            if(sizeof($barcode)!=0){
                for($j=0;$j<sizeof($barcode);$j++) {
                    $sj_barcode = $sj_barcode.$barcode[$j]->brc_barcode.'-' ;
                }
                $sj_barcode = substr($sj_barcode,0,strlen(trim($sj_barcode)) - 1);
                $sj[$i]->sj_barcode = $sj_barcode;
            }

            $sj[$i]->sj_sat = $sj[$i]->unit.'/'.$sj[$i]->frac;

            if($cpromo == true){
                $sj[$i]->sj_hgjual = $nfmjual;
            }
            else{
                $sj[$i]->sj_hgjual = $sj[$i]->price_a;
            }
            $sj[$i]->sj_lcost = $sj[$i]->st_lastcost * $sj[$i]->frac;
            $sj[$i]->sj_acost = $sj[$i]->st_lcost * $sj[$i]->frac;
            $sj[$i]->sj_mgna = $maracost;
            $sj[$i]->sj_mgnl = $marlcost;
            $sj[$i]->sj_minj = $sj[$i]->minj;
            $sj[$i]->sj_tag = $sj[$i]->ptag;
            $sj[$i]->sj_bkp = $sj[$i]->pkp;
            $sj[$i]->sj_bkl = $sj[$i]->prd_flagbarangordertoko;
        }

        $trendsales = DB::table('TBTR_SALESBULANAN')
            ->select('*')
            ->where('sls_prdcd', '=', $request->value)
            ->first();
        $trendsales = (array)$trendsales;

        $blnberjalan = DB::table('TBMASTER_PERUSAHAAN')
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
        $prodstock = db::table('tbmaster_prodmast')->join('tbmaster_stock','prd_kodeigr','=','st_kodeigr')
            ->select('*')
            ->where('prd_prdcd', '=', $request->value)
            ->where('prd_kodeigr', '=', "22")
            ->whereRaw('substr (tbmaster_stock.st_prdcd, 1, 6) = substr (tbmaster_prodmast.prd_prdcd, 1, 6)')
            ->where('st_lokasi', '=', "01")
            ->first();

        if($prodstock->st_lokasi =='01'){
            $prodstock->st = 'BK';
        }
        else if($prodstock->st_lokasi =='02'){
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

        //stok
        $stock =  db::table('tbmaster_prodmast')->join('tbmaster_stock','prd_kodeigr','=','st_kodeigr')
            ->select('*')
            ->where('prd_prdcd', '=', $request->value)
            ->where('prd_kodeigr', '=', "22")
            ->whereRaw('substr (tbmaster_stock.st_prdcd, 1, 6) = substr (tbmaster_prodmast.prd_prdcd, 1, 6)')
            ->orderBy('st_lokasi')
            ->get();
        for($i=0;$i<sizeof($stock);$i++) {
            if($stock[$i]->st_lokasi == '01'){
                $st = 'BK';
            }
            else if($stock[$i]->st_lokasi == '02'){
                $st = 'RT';
            }
            else{
                $st = 'RS';
            }
            $st_awal=self::ceknull($stock[$i]->st_saldoawal,0);
            $st_terima=self::ceknull($stock[$i]->st_trfin,0);
            $st_keluar=self::ceknull($stock[$i]->st_trfout,0);
            $st_sales=self::ceknull($stock[$i]->st_sales,0);
            $st_retur=self::ceknull($stock[$i]->st_retur,0);
            $st_adj=self::ceknull($stock[$i]->st_adj,0);
            $st_so=self::ceknull($stock[$i]->st_so,0);
            $st_instrst=self::ceknull($stock[$i]->st_intransit,0);
            $st_selisih_so=self::ceknull($stock[$i]->st_selisih_so,0);
            $st_akhir=self::ceknull($stock[$i]->st_saldoakhir,0);

            $lso = true;
            $lsoic = true;


             $temp = db::table('TBMASTER_SETTING_SO')
                 ->select('*')
                 ->whereRaw('to_char(MSO_TGLSO, \'yyyy-MM\') =  to_char(sysdate,\'yyyy-MM\')')
                 ->count('*');

             if(self::ceknull($temp,0)!=0){
                 $freset = db::table('TBMASTER_SETTING_SO')
                     ->selectRaw('NVL(MSO_FLAGRESET, \'N\')')
                     ->whereRaw('to_char(MSO_TGLSO, \'yyyy-MM\') =  to_char(sysdate,\'yyyy-MM\')')
                     ->first();

                 if($freset!= 'Y'){
                     $st_selisih_so=0;
                     $st_akhir=self::ceknull($stock[$i]->st_saldoakhir,0)-self::ceknull($stock[$i]->st_selisih_so,0);
                 }
             }

             if($stock[$i]->st_lokasi=='01'){
                 $qty_soic = db::table('tbtr_reset_soic')
                     ->selectRaw('sum(nvl(rso_qtyreset,0)) qty')
                     ->whereRaw('substr(rso_prdcd,1 ,6) = substr(\''.$request->value.'\', 1, 6)')
                     ->whereRaw('to_char(rso_tglso, \'yyyyMM\') = to_char(sysdate, \'yyyyMM\')')
                     ->where('rso_lokasi','=','01')
                     ->first();

                 $st_selisih_so = $st_selisih_so + self::ceknull($qty_soic->qty,0);
                $st_akhir = self::ceknull($stock[$i]->st_saldoakhir,0) - self::ceknull($stock[$i]->st_selisih_soic,0) + self::ceknull($qty_soic->qty, 0);

                 if($stock[$i]->st_sales > 0) {
                     $dsi = ((($stock[$i]->st_saldoawal + $stock[$i]->st_saldoakhir) / 2) / $stock[$i]->st_sales) * ((int) date('d'));
                     $to = ($stock[$i]->st_saldoakhir / $stock[$i]->st_sales) * ((int) date('d'));
                 }
                 else {
                     $dsi = 0;
                     $to = 0;
                 }
             }
            if($stock[$i]->st_saldoakhir <= 0) {
		    		if (in_array($stock[$i]->prd_kodetag ,['N', 'H'])){
		    			 if ($stock[$i]->st_saldoakhir == 0 and $stock[$i]->prd_kodetag == 'H') {
                             array_push($message,'STOCK BARANG ' . $stock[$i]->st_lokasi . ' NOL   (TAG H-> HABISKAN TOKO)');
                         }
		    			 else {
                             array_push($message,'STOCK BARANG ' . $stock[$i]->st_lokasi . ' MINUS (TAG H-> HABISKAN TOKO)');
                         }
		    			 
		    			 if ($stock[$i]->st_saldoakhir == 0 and $stock[$i]->prd_kodetag == 'N') {
                             array_push($message,'STOCK BARANG ' . $stock[$i]->st_lokasi . ' NOL   (TAG N-> DISCONTINUE)');
                         }
		    			 else {
                             array_push($message,'STOCK BARANG ' . $stock[$i]->st_lokasi . ' MINUS (TAG N-> DISCONTINUE)');
                         }
                        array_push($message, 'Buatkan MEMO BARANG ' . trim($stock[$i]->st_lokasi). ' Perubahan Tag -> Tag X,;Informasikan ke Merchandising & EDP;Apakah ANDA sudah mencatatnya?');
		    		}

            }
		    
            if($stock[$i]->st_saldoakhir != 0 and $stock[$i]->prd_kodetag =='X') {
                array_push($message, 'STOCK BARANG ' . trim($stock[$i]->st_lokasi) . ' TAG X HARUS 0 (NOL),;Cari PLU pengganti (bila ada ->MPP);Apakah ANDA sudah mencatatnya?');
            }
            if (self::ceknull($stock[$i]->st_saldoawal,0)+self::ceknull($stock[$i]->st_trfin,0)-self::ceknull($stock[$i]->st_trfout,0)-self::ceknull($stock[$i]->st_sales,0)+ 0 + self::ceknull($stock[$i]->st_retur,0)+ self::ceknull($stock[$i]->st_intransit,0)+self::ceknull($stock[$i]->st_adj,0) != $stock[$i]->st_saldoakhir) {
                $deskripsi = 'PERHITUNGAN STOCK BARANG ' . trim($st).' SALAH,;Lakukan proses HITUNG ULANG STOCK;Apakah ANDA sudah mencatatnya?';
            }
            $stock[$i]->st=self::ceknull($st,0);
            $stock[$i]->st_awal=self::ceknull($st_awal,0);
            $stock[$i]->st_terima=self::ceknull($st_terima,0);
            $stock[$i]->st_keluar=self::ceknull($st_keluar,0);
            $stock[$i]->st_sales=self::ceknull($st_sales,0);
            $stock[$i]->st_retur=self::ceknull($st_retur,0);
            $stock[$i]->st_adj=self::ceknull($st_adj,0);
            $stock[$i]->st_so=self::ceknull($st_so,0);
            $stock[$i]->st_instrst=self::ceknull($st_instrst,0);
            $stock[$i]->st_selisih_so=self::ceknull($st_selisih_so,0);
            $stock[$i]->st_akhir=self::ceknull($st_akhir,0);
        }

        $pkmt = db::table('tbmaster_hargabeli')
            ->join('tbmaster_supplier','hgb_kodesupplier','=','sup_kodesupplier')
            ->join('tbmaster_prodmast','hgb_prdcd','=','prd_prdcd')
            ->selectRaw('hgb_top, hgb_hrgbeli, sup_kodesupplier||\' - \'||sup_namasupplier sup,sup_top, prd_isibeli')
            ->whereRaw('substr(hgb_prdcd,1 ,6) = substr(\''.$request->value.'\', 1, 6)')
            ->where('hgb_tipe','=','2')
            ->first();

        if ($VUNIT=='KG'){
            $pkmt->hgb_hrgbeli = $pkmt->hgb_hrgbeli*$VFRAC;
        }
        else{
            $pkmt->hgb_hrgbeli = $pkmt->hgb_hrgbeli*$pkmt->prd_isibeli;
        }

        $pkmt->dsi = round($dsi);
        $pkmt->to = round($to);
        if($pkmt->hgb_top>0){
            $pkmt->top = $pkmt->hgb_top;
        }
        else{
            $pkmt->top = $pkmt->sup_top;
        }

        $kkpkm = db::table('tbmaster_kkpkm')
            ->leftJoin('tbmaster_pkmplus','pkmp_prdcd','=','pkm_prdcd')
            ->leftJoin('tbmaster_minimumorder','min_prdcd','=','pkm_prdcd')
            ->selectRaw('nvl(pkm_pkmt,0) vpkmt, nvl(pkm_mindisplay,0) vmindisplay, nvl(pkmp_qtyminor,0) vqtyminor, min_minorder vminor')
            ->where('pkm_prdcd','=',$request->value)
            ->first();

        $pkm_qty = $kkpkm->vpkmt;
        $min_qty = $NMINOR;
        $md_qty = $kkpkm->vmindisplay;
        if (self::ceknull($AVGSALES,0) > 0) {
            $pkm_to = ($kkpkm->vpkmt / self::ceknull($AVGSALES, 0)) * 30;
            $min_to = ($NMINOR / self::ceknull($AVGSALES, 0)) * 30;
            $md_to = ($kkpkm->vmindisplay / self::ceknull($AVGSALES, 0)) * 30;
        }
        else {
            $pkm_to = ($kkpkm->vpkmt / 1) * 30;
            $min_to = ($NMINOR / 1) * 30;
            $md_to = ($kkpkm->vmindisplay / 1) * 30;
        }
        $mplus = $kkpkm->vqtyminor;
        $minory = $kkpkm->vminor;

        $pkmt->pkm_qty = round($pkm_qty);
        $pkmt->min_qty = round($min_qty);
        $pkmt->md_qty = round($md_qty);
        $pkmt->pkm_to = round($pkm_to);
        $pkmt->min_to = round($min_to);
        $pkmt->md_to = round($md_to);
        $pkmt->mplus = round($mplus);
        $pkmt->minory = round($minory);

//        DETAIL SALES
        $ds01 = db::table('tbtr_rekapsalesbulanan')
            ->selectRaw('nvl(rsl_qty_01, 0) qty_igr1, nvl(rsl_qty_02, 0) qty_igr2, nvl(rsl_qty_03, 0) qty_igr3 ,nvl(rsl_qty_04, 0) qty_igr4, nvl(rsl_qty_05, 0) qty_igr5, nvl(rsl_qty_06, 0) qty_igr6, nvl(rsl_qty_07, 0) qty_igr7, nvl(rsl_qty_08, 0) qty_igr8,nvl(rsl_qty_09, 0) qty_igr9,nvl(rsl_qty_10, 0) qty_igr10,nvl(rsl_qty_11, 0) qty_igr11,nvl(rsl_qty_12, 0) qty_igr12, nvl(rsl_rph_01, 0) rph_igr1, nvl(rsl_rph_02, 0) rph_igr2, nvl(rsl_rph_03, 0) rph_igr3, nvl(rsl_rph_04, 0) rph_igr4, nvl(rsl_rph_05, 0) rph_igr5, nvl(rsl_rph_06, 0) rph_igr6, nvl(rsl_rph_07, 0) rph_igr7, nvl(rsl_rph_08, 0) rph_igr8, nvl(rsl_rph_09, 0) rph_igr9, nvl(rsl_rph_10, 0) rph_igr10, nvl(rsl_rph_11, 0) rph_igr11, nvl(rsl_rph_12, 0) rph_igr12')
            ->whereRaw('substr(rsl_prdcd,1 ,6) = substr(\''.$request->value.'\', 1, 6)')
            ->where('rsl_group','=','01')
            ->first();

        $ds02 = db::table('tbtr_rekapsalesbulanan')
            ->selectRaw('nvl(rsl_qty_01, 0) qty_omi1, nvl(rsl_qty_02, 0) qty_omi2, nvl(rsl_qty_03, 0) qty_omi3 ,nvl(rsl_qty_04, 0) qty_omi4, nvl(rsl_qty_05, 0) qty_omi5, nvl(rsl_qty_06, 0) qty_omi6,nvl(rsl_qty_07, 0) qty_omi7, nvl(rsl_qty_08, 0) qty_omi8,nvl(rsl_qty_09 , 0)qty_omi9,nvl(rsl_qty_10, 0) qty_omi10,nvl(rsl_qty_11, 0) qty_omi11,nvl(rsl_qty_12, 0) qty_omi12,nvl(rsl_rph_01, 0) rph_omi1, nvl(rsl_rph_02, 0) rph_omi2, nvl(rsl_rph_03, 0) rph_omi3, nvl(rsl_rph_04, 0) rph_omi4, nvl(rsl_rph_05, 0) rph_omi5, nvl(rsl_rph_06, 0) rph_omi6,nvl(rsl_rph_07, 0) rph_omi7, nvl(rsl_rph_08, 0) rph_omi8, nvl(rsl_rph_09, 0) rph_omi9, nvl(rsl_rph_10 , 0)rph_omi10, nvl(rsl_rph_11, 0) rph_omi11, nvl(rsl_rph_12, 0) rph_omi12')
            ->whereRaw('substr(rsl_prdcd,1 ,6) = substr(\''.$request->value.'\', 1, 6)')
            ->where('rsl_group','=','02')
            ->first();

        $ds03 = db::table('tbtr_rekapsalesbulanan')
            ->selectRaw('nvl(rsl_qty_01, 0) qty_mrh1, nvl(rsl_qty_02, 0) qty_mrh2, nvl(rsl_qty_03, 0) qty_mrh3 ,nvl(rsl_qty_04, 0) qty_mrh4, nvl(rsl_qty_05, 0) qty_mrh5, nvl(rsl_qty_06, 0) qty_mrh6,nvl(rsl_qty_07, 0) qty_mrh7, nvl(rsl_qty_08, 0) qty_mrh8,nvl(rsl_qty_09, 0) qty_mrh9,nvl(rsl_qty_10, 0) qty_mrh10,nvl(rsl_qty_11, 0) qty_mrh11,nvl(rsl_qty_12, 0) qty_mrh12,nvl(rsl_rph_01, 0) rph_mrh1, nvl(rsl_rph_02, 0) rph_mrh2, nvl(rsl_rph_03, 0) rph_mrh3, nvl(rsl_rph_04, 0) rph_mrh4, nvl(rsl_rph_05, 0) rph_mrh5, nvl(rsl_rph_06, 0) rph_mrh6,nvl(rsl_rph_07, 0) rph_mrh7, nvl(rsl_rph_08, 0) rph_mrh8, nvl(rsl_rph_09 , 0)rph_mrh9, nvl(rsl_rph_10, 0) rph_mrh10, nvl(rsl_rph_11, 0) rph_mrh11, nvl(rsl_rph_12, 0) rph_mrh12')
            ->whereRaw('substr(rsl_prdcd,1 ,6) = substr(\''.$request->value.'\', 1, 6)')
            ->where('rsl_group','=','03')
            ->first();

        $ds04 = db::table('tbtr_rekapsalesbulanan')
            ->selectRaw('nvl(rsl_qty_01, 0) qty_omi1, nvl(rsl_qty_02, 0) qty_omi2, nvl(rsl_qty_03, 0) qty_omi3 ,nvl(rsl_qty_04, 0) qty_omi4, nvl(rsl_qty_05, 0) qty_omi5, nvl(rsl_qty_06, 0) qty_omi6,nvl(rsl_qty_07, 0) qty_omi7, nvl(rsl_qty_08, 0) qty_omi8,nvl(rsl_qty_09, 0) qty_omi9,nvl(rsl_qty_10, 0) qty_omi10,nvl(rsl_qty_11, 0) qty_omi11,nvl(rsl_qty_12, 0) qty_omi12,nvl(rsl_rph_01, 0) rph_omi1, nvl(rsl_rph_02, 0) rph_omi2, nvl(rsl_rph_03, 0) rph_omi3, nvl(rsl_rph_04, 0) rph_omi4, nvl(rsl_rph_05, 0) rph_omi5, nvl(rsl_rph_06, 0) rph_omi6,nvl(rsl_rph_07, 0) rph_omi7, nvl(rsl_rph_08, 0) rph_omi8, nvl(rsl_rph_09, 0) rph_omi9, nvl(rsl_rph_10, 0) rph_omi10, nvl(rsl_rph_11, 0) rph_omi11, nvl(rsl_rph_12, 0) rph_omi12')
            ->whereRaw('substr(rsl_prdcd,1 ,6) = substr(\''.$request->value.'\', 1, 6)')
            ->where('rsl_group','=','04')
            ->first();

        $ds01=(array)$ds01;
        $ds02=(array)$ds02;
        $ds03=(array)$ds03;
        $ds04=(array)$ds04;
        $avgigr = 0;
        $avgomi = 0;
        $avgmrh = 0;
        $avgidm = 0;
        if (sizeof($ds01)>0){

            $N = 0;
            $X = 0;
            $X1 = 0;
            if ($FMPBLNA - 1 < 1) {
                $N = 12;
                $avgigr = $avgigr + (int)$ds01['qty_igr12'];
            } else {
                $N = $FMPBLNA - 1;
                $avgigr = $avgigr + (int)$ds01['qty_igr' . $N];
            }

            if ($N - 1 < 1) {
                $X = 12;
                $avgigr = $avgigr + (int)$ds01['qty_igr12'];
            } else {
                $X = $N - 1;
                $avgigr = $avgigr + (int)$ds01['qty_igr' . $X];
            }

            if ($X - 1 < 1) {
                $X1 = 12;
                $avgigr = $avgigr + (int)$ds01['qty_igr12'];
            } else {
                $X1 = $X - 1;
                $avgigr = $avgigr + (int)$ds01['qty_igr' . $X1];
            }
        }
        if (sizeof($ds02)>0) {
            $N = 0;
            $X = 0;
            $X1 = 0;
            if ($FMPBLNA - 1 < 1) {
                $N = 12;
                $avgomi = $avgomi + (int)$ds02['qty_omi12'];
            } else {
                $N = $FMPBLNA - 1;
                $avgomi = $avgomi + (int)$ds02['qty_omi' . $N];
            }

            if ($N - 1 < 1) {
                $X = 12;
                $avgomi = $avgomi + (int)$ds02['qty_omi12'];
            } else {
                $X = $N - 1;
                $avgomi = $avgomi + (int)$ds02['qty_omi' . $X];
            }

            if ($X - 1 < 1) {
                $X1 = 12;
                $avgomi = $avgomi + (int)$ds02['qty_omi12'];
            } else {
                $X1 = $X - 1;
                $avgomi = $avgomi + (int)$ds02['qty_omi' . $X1];
            }
        }
        if (sizeof($ds03)>0) {
            $N = 0;
            $X = 0;
            $X1 = 0;
            if ($FMPBLNA - 1 < 1) {
                $N = 12;
                $avgmrh = $avgmrh + (int)$ds03['qty_mrh12'];
            } else {
                $N = $FMPBLNA - 1;
                $avgmrh = $avgmrh + (int)$ds03['qty_mrh' . $N];
            }

            if ($N - 1 < 1) {
                $X = 12;
                $avgmrh = $avgmrh + (int)$ds03['qty_mrh12'];
            } else {
                $X = $N - 1;
                $avgmrh = $avgmrh + (int)$ds03['qty_mrh' . $X];
            }

            if ($X - 1 < 1) {
                $X1 = 12;
                $avgmrh = $avgmrh + (int)$ds03['qty_mrh12'];
            } else {
                $X1 = $X - 1;
                $avgmrh = $avgmrh + (int)$ds03['qty_mrh' . $X1];
            }
        }
        if (sizeof($ds04)>0) {
            $N = 0;
            $X = 0;
            $X1 = 0;
            if ($FMPBLNA - 1 < 1) {
                $N = 12;
                $avgidm = $avgidm + (int)$ds04['qty_omi12'];
            } else {
                $N = $FMPBLNA - 1;
                $avgidm = $avgidm + (int)$ds04['qty_omi' . $N];
            }

            if ($N - 1 < 1) {
                $X = 12;
                $avgidm = $avgidm + (int)$ds04['qty_omi12'];
            } else {
                $X = $N - 1;
                $avgidm = $avgidm + (int)$ds04['qty_omi' . $X];
            }

            if ($X - 1 < 1) {
                $X1 = 12;
                $avgidm = $avgidm + (int)$ds04['qty_omi12'];
            } else {
                $X1 = $X - 1;
                $avgidm = $avgidm + (int)$ds04['qty_omi' . $X1];
            }
        }
            $avgigr = round(self::ceknull(round($avgigr), 0) / 3);
            $avgomi = round(self::ceknull(round($avgomi), 0) / 3);
            $avgmrh = round(self::ceknull(round($avgmrh), 0) / 3);
            $avgidm = round(self::ceknull(round($avgidm), 0) / 3);
            $detailsales = [];
            $detailsales['igr'] = $ds01;
            $detailsales['omi'] = $ds02;
            $detailsales['mrh'] = $ds03;
            $detailsales['idm'] = $ds04;
            $detailsales['avgigr'] = $avgigr;
            $detailsales['avgomi'] = $avgomi;
            $detailsales['avgmrh'] = $avgmrh;
            $detailsales['avgidm'] = $avgidm;

        /*PENERIMAAN*/
        $supplier = DB::table('TBTR_MSTRAN_D')->leftJoin('TBMASTER_SUPPLIER','MSTD_KODESUPPLIER','=','SUP_KODESUPPLIER')
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

        $ntotalpo = 0;
        $ntotalpb = 0;
        $temppo = 'A,';
        $temppb = 'A,';

        $permintaan = array();
        $pb = DB::table('tbtr_po_d')
            ->join('tbtr_po_h','tpoh_nopo','=','tpod_nopo')
            ->join('tbtr_pb_d', function ($join) {
                $join->On(DB::raw('SUBSTR (pbd_prdcd, 1, 6)'),'=',DB::raw('SUBSTR (tpod_prdcd, 1, 6)'))->On('pbd_nopo', '=', 'tpod_nopo');
            })->join('tbtr_pb_h','pbh_nopb','=','pbd_nopb')
            ->selectRaw('DISTINCT NVL (tpod_recordid, \'9\') recid,
                                    tpod_prdcd,
                                    tpod_nopo,
                                    tpoh_tglpo,
                                    NVL (tpod_qtypb, 0) tpod_qtypb, 
                                    tpoh_tglpo + tpoh_jwpb jwpb,
                                    pbh_keteranganpb, 
                                    pbh_nopb, 
                                    pbh_tglpb, 
                                    NVL (pbh_qtypb, 0) pbh_qtypb,
                                    pbd_nopo, 
                                    pbd_prdcd, 
                                    pbd_qtypb')
            ->whereRaw('substr(tpod_prdcd, 1, 6) = substr(\''.$request->value.'\', 1, 6)')
            ->orderBy('PBH_TGLPB')
            ->orderBy('PBH_NOPB')
            ->get();

        for($i=0;$i<sizeof($pb);$i++) {
            $pb_ketbpb ='';
            $pb_no = '';
            $pb_tgl = '';
            $pb_qty = '';
            $pb_ket = '';
            $pb_nopo = '';
            $pb_tglpo = '';
            $pb_ketbpb = '';
            $pb_qtybpb = '';
            $step= 1;
            $temppo = $temppo . $pb[$i]->tpod_nopo . ',';
            $temppb = $temppb . $pb[$i]->pbh_nopb . ',';
            $step = 2;
            $pb_no = $pb[$i]->pbh_nopb;
            $pb_tgl = $pb[$i]->pbh_tglpb;
            $pb_qty = $pb[$i]->pbd_qtypb;
            $pb_ket = $pb[$i]->pbh_keteranganpb;

            $step = 3;
            $pb_nopo = $pb[$i]->tpod_nopo;
            $pb_tglpo = $pb[$i]->tpoh_tglpo;

            $step = 4;
            $pb_qtybpb = $pb[$i]->tpod_qtypb;



            if(Self::ceknull($pb[$i]->tpod_qtypb, 0) == 0) {
                if ($pb[$i]->recid == '9') {
                    if ($pb[$i]->jwpb < Carbon::now()){
                        $step = 5;
                        $pb_ketbpb = 'PO Mati/Kdlwarsa';
                    }
                    else{
                        $step = 6;
                        $pb_ketbpb = 'Brg.blm dikirim';
                    }
                }
                else{
                    $step = 7;
                    $pb_ketbpb = 'Qty BPB 0 (null)';
                }
            }
            $step = 8;
            if(Self::ceknull($pb[$i]->tpod_nopo,'')!='' AND Self::ceknull($pb[$i]->tpoh_tglpo,'')==''){
        		$step = 9;
                $pb_ketbpb = 'PO Mati/Kdlwarsa';
            }

            $step = 10;
            $ntotalpo = Self::ceknull ($ntotalpo, 0) + Self::ceknull ($pb[$i]->tpod_qtypb, 0);
            
            if (Self::ceknull($pb[$i]->tpod_nopo,'')=='') {
                if ($pb[$i]->pbh_tglpb < Carbon::now() + 2){
                    $step = 11;
                    $pb_ketbpb = 'PB tdk.tRealiss';
                }
                else{
                    $step = 12;
                    $pb_ketbpb = 'Blm.Transfer PO';
                }
            }

//            if($pb[$i]->pbh_nopb=='221404027'){
//                dd($pb[$i]->tpod_qtypb.'-'.$pb[$i]->tpod_nopo.'-'.$pb[$i]->tpoh_tglpo.'-'.$pb[$i]->tpod_qtypb.'-'.$step);
//            }
            $dataPenerimaan["pb_no"] =$pb_no;
            $dataPenerimaan["pb_tgl"] =$pb_tgl;
            $dataPenerimaan["pb_qty"] =$pb_qty;
            $dataPenerimaan["pb_ket"] =$pb_ket;
            $dataPenerimaan["pb_nopo"] =$pb_nopo;
            $dataPenerimaan["pb_tglpo"] =$pb_tglpo;
            $dataPenerimaan["pb_ketbpb"] =$pb_ketbpb;
            $dataPenerimaan["pb_qtybpb"] =$pb_qtybpb;
            array_push($permintaan,$dataPenerimaan);
        }

        $step = 13;
        $pb2 = DB::table('tbtr_pb_d')
            ->join('tbtr_pb_h','pbh_nopb','=','pbd_nopb')
            ->selectRaw('DISTINCT pbh_keteranganpb,
                                     pbh_nopb, 
                                     pbh_tglpb, 
                                     NVL (pbh_qtypb, 0) pbh_qtypb,                       
                                     pbd_nopo, 
                                     pbd_prdcd, 
                                     pbd_qtypb')
            ->whereRaw('substr(pbd_prdcd, 1, 6) = substr(\''.$request->value.'\', 1, 6)')
            ->orderBy('PBH_TGLPB')
            ->orderBy('PBH_NOPB')
            ->get();
        for($i=0;$i<sizeof($pb2);$i++) {
            if(strpos($temppb, $pb2[$i]->pbh_nopb)==0){
                $pb_ketbpb ='';
                $pb_no = '';
                $pb_tgl = '';
                $pb_qty = '';
                $pb_ket = '';
                $pb_nopo = '';
                $pb_tglpo = '';
                $pb_ketbpb = '';
                $pb_qtybpb = '';
                $step = 14;
                $pb_no = $pb2[$i]->pbh_nopb;
                $pb_tgl = $pb2[$i]->pbh_tglpb;
                $pb_ket = $pb2[$i]->pbh_keteranganpb;
                $pb_nopo = $pb2[$i]->pbd_nopo;
                $pb_qty = $pb2[$i]->pbd_qtypb;

                if(Self::ceknull($pb2[$i]->pbd_nopo,'')==''){
	        		if ($pb2[$i]->pbh_tglpb < Carbon::now() + 2) {
                        $step = 15;
                        $pb_ketbpb = 'PB tdk.tRealiss';
                    }
	        		else {
                        $step = 16;
                        $pb_ketbpb = 'Blm.Transfer PO';
                    }
	            }
	            //nextrecord
                $dataPenerimaan["pb_no"] =$pb_no;
                $dataPenerimaan["pb_tgl"] =$pb_tgl;
                $dataPenerimaan["pb_qty"] =$pb_qty;
                $dataPenerimaan["pb_ket"] =$pb_ket;
                $dataPenerimaan["pb_nopo"] =$pb_nopo;
                $dataPenerimaan["pb_tglpo"] =$pb_tglpo;
                $dataPenerimaan["pb_ketbpb"] =$pb_ketbpb;
                $dataPenerimaan["pb_qtybpb"] =$pb_qtybpb;
                array_push($permintaan,$dataPenerimaan);
            }
        }
       $step = 17;
        $po = DB::table('tbtr_po_d')
            ->join('tbtr_po_h','tpoh_nopo','=','tpod_nopo')
            ->selectRaw('DISTINCT NVL (tpod_recordid, \'9\') recid, 
                                tpod_prdcd, 
                                tpod_nopo, 
                                tpoH_tglpo,
                                NVL (tpod_qtypb, 0) tpod_qtypb, 
                                tpoh_tglpo + tpoh_jwpb jwpb')
            ->whereRaw('substr(tpod_prdcd, 1, 6) = substr(\''.$request->value.'\', 1, 6)')
            ->orderBy('TPOH_TGLPO')
            ->orderBy('TPOD_NOPO')
            ->get();
        for($i=0;$i<sizeof($po);$i++) {
            if (strpos($temppo, $po[$i]->tpod_nopo) == 0) {
                $pb_ketbpb ='';
                $pb_no = '';
                $pb_tgl = '';
                $pb_qty = '';
                $pb_ket = '';
                $pb_nopo = '';
                $pb_tglpo = '';
                $pb_ketbpb = '';
                $pb_qtybpb = '';
                $step = 18;
                $pb_nopo = $po[$i]->tpod_nopo;
                $pb_tglpo = $po[$i]->tpoh_tglpo;
                $step = 19;
                $pb_qtybpb = $po[$i]->tpod_qtypb;
                if(Self::ceknull($po[$i]->tpod_qtypb, 0) == 0) {
                    if($po[$i]->recid == '9') {
                        if ($po[$i]->jwpb < Carbon::now()) {
                            $step = 20;
                            $pb_ketbpb = 'PO Mati/Kdlwarsa';
                        }
                        else {
                            $step = 21;
                            $pb_ketbpb = 'Brg.blm dikirim';
                        }
                    }
                    else{
                            $step = 22;
                            $pb_ketbpb = 'Qty BPB 0 (nul)';
                    }
                }

	        if(Self::ceknull($po[$i]->tpod_nopo,'')!='' AND Self::ceknull($po[$i]->tpoh_tglpo,'')==''){
                $step = 23;
	            $pb_ketbpb = 'PO Mati/Kdlwarsa';
	        }
	
            $step = 24;
	        $ntotalpo = Self::ceknull($ntotalpo, 0) + Self::ceknull($po[$i]->tpod_qtypb, 0);
	        
	        $step = 25;
	        $pb_ketbpb = 'PO Alokasi';
	        if(Self::ceknull($pb_qtybpb,0) == 0 ) {
                $step = 26;
                $pb_ketbpb = 'PO Alokasi/Mati';
            }
	        $step = 27;
	        if(Self::ceknull($pb_nopo,'') == '' AND Self::ceknull($pb_tglpo,'') == '') {
                $step = 28;
                $pb_ketbpb = 'PO Mati/Kdlwarsa';
            }
//	        NEXT_RECORD;
            $dataPenerimaan["pb_no"] =$pb_no;
            $dataPenerimaan["pb_tgl"] =$pb_tgl;
            $dataPenerimaan["pb_qty"] =$pb_qty;
            $dataPenerimaan["pb_ket"] =$pb_ket;
            $dataPenerimaan["pb_nopo"] =$pb_nopo;
            $dataPenerimaan["pb_tglpo"] =$pb_tglpo;
            $dataPenerimaan["pb_ketbpb"] =$pb_ketbpb;
            $dataPenerimaan["pb_qtybpb"] =$pb_qtybpb;
            array_push($permintaan,$dataPenerimaan);
	      }
        }
        $step = 29;

        $temp = DB::table('tbtr_ba_stockopname')
            ->selectRaw('distinct sop_tglso')
            ->where('sop_kodeigr','=','22')
            ->orderBy('sop_tglso','desc')
            ->get();

        if (sizeof($temp) != 0) {
                for($i=0;$i<sizeof($temp);$i++) {
                    $so_tgl = date('Y-m-d',strtotime(substr($temp[$i]->sop_tglso,0,10)));
                    break;
                }
        }
        else {
            $so_tgl = date('Y-m-d');
        }

        $tempadjustso = DB::Raw('(Select ADJ_KODEIGR,
                                ADJ_TGLSO,
                                ADJ_PRDCD,
                                ADJ_LOKASI,
                                SUM (NVL (ADJ_QTY, 0)) QTY_ADJ
                                from TBTR_ADJUSTSO
                                Group by ADJ_KODEIGR,
                            ADJ_TGLSO,
                            ADJ_PRDCD,
                            ADJ_LOKASI) B');

        $so = DB::table('TBTR_BA_STOCKOPNAME')
            ->join('TBMASTER_PRODMAST','PRD_PRDCD','=','SOP_PRDCD')
            ->leftJoin($tempadjustso ,function ($join) {
                $join->On(DB::raw('SUBSTR (B.ADJ_PRDCD, 1, 6)'), '=', DB::raw('SUBSTR (SOP_PRDCD, 1, 6)'))->On(DB::raw('trunc(B.ADJ_TGLSO)'), '=', DB::raw('trunc(SOP_TGLSO)'))->On('B.ADJ_LOKASI', '=', 'SOP_LOKASI');
            })
            ->selectRaw('SOP_QTYSO,
                        SOP_QTYLPP,
                        NVL (B.QTY_ADJ, 0) QTY_ADJ,
                        SOP_QTYSO - SOP_QTYLPP + NVL (B.QTY_ADJ, 0) SELISIH, 
                        SOP_NEWAVGCOST,
                        CASE
                           WHEN PRD_UNIT = \'KG\'
                               THEN ((SOP_QTYSO - SOP_QTYLPP + NVL (B.QTY_ADJ, 0)) * SOP_NEWAVGCOST) / 1000
                           ELSE (SOP_QTYSO - SOP_QTYLPP + NVL (B.QTY_ADJ, 0)) * SOP_NEWAVGCOST
                        END RUPIAH,
                        PRD_UNIT')
            ->whereRaw('substr(SOP_PRDCD, 1, 6) = substr(\''.$request->value.'\', 1, 6)')
            ->where('SOP_LOKASI','=','01')
            ->whereRaw('SOP_TGLSO = to_date(\''.$so_tgl.'\',\'yyyy-mm-dd\')')
            ->get();

        $adjustso = DB::table('TBTR_ADJUSTSO')
            ->select('*')
            ->where('adj_kodeigr','=','22')
            ->where('adj_lokasi','=','01')
            ->whereRaw('substr(adj_prdcd, 1, 6) = substr(\''.$request->value.'\', 1, 6)')
            ->whereRaw('adj_tglso = to_date(\''.$so_tgl.'\',\'yyyy-mm-dd\')')
            ->orderBy('adj_create_dt')
            ->get();

        $resetsoic = DB::table('TBTR_RESET_SOIC')
            ->select('*')
            ->where('rso_kodeigr','=','22')
            ->where('rso_lokasi','=','01')
            ->whereRaw('substr(rso_prdcd, 1, 6) = substr(\''.$request->value.'\', 1, 6)')
            ->whereRaw('to_char(rso_tglso, \'yyyyMM\') = to_char(sysdate, \'yyyyMM\')')
            ->orderBy('rso_tglso')
            ->orderBy('rso_kodeso')
            ->get();

        return compact(['produk','sj','trendsales','prodstock','AVGSALES','stock','pkmt','ITEM','flag','detailsales','supplier','permintaan','so_tgl','so','adjustso','resetsoic','message']);
    }

    public function ceknull($value,$ret){
        if($value=="" OR $value==null OR $value=="null" ){
            return $ret;
        }
        return $value;
    }

    public function cetak()
    {
//        $so=$request->value['so'];
//        $adjustso=$request->value['adjustso'];
//        $resetsoic=$request->value['resetsoic'];
        $so= ['a','b','c'];
        $content = "Logs \n";
        foreach ($so as $data) {
            $content .= $data;
            $content .= "\n";
        }

        // file name that will be used in the download
        $fileName = "logs.txt";

        // use headers in order to generate the download
        $headers = [
            'Content-type' => 'text/plain',
            'Content-Disposition' => sprintf('attachment; filename="%s"', $fileName),
            'Content-Length' => strlen($content)
        ];

        // make a response, with the content, a 200 response code and the headers
        return Response::make($content, 200, $headers);

    }

//    public function cetak(Request $request)
//    {
//        $so=$request->value['so'];
////        $adjustso=$request->value['adjustso'];
////        $resetsoic=$request->value['resetsoic'];
//
//        $content = "Logs \n";
//        foreach ($so as $data) {
//            $content .= $data['sop_qtyso'];
//            $content .= "\n";
//        }
//
//        // file name that will be used in the download
//        $fileName = "cetakso.txt";
//
//        // use headers in order to generate the download
//        $headers = [
//            'Content-type' => 'text/plain',
//            'Content-Disposition' => sprintf('attachment; filename="%s"', $fileName),
//            'Content-Length' => strlen($content)
//        ];
//
//        // make a response, with the content, a 200 response code and the headers
////        return Response::download($content, 200, $headers);
//        return Response::make($fileName, 200, $headers);
//
//    }
}
