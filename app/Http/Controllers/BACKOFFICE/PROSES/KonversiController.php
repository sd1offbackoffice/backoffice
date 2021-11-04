<?php

namespace App\Http\Controllers\BACKOFFICE\PROSES;

use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;
use PDF;
use Yajra\DataTables\DataTables;
use ZipArchive;
use File;

class KonversiController extends Controller
{
    public function index(){
        return view('BACKOFFICE.PROSES.konversi');
    }

    public function getDataLovPluUtuh(){
        $lov = DB::connection($_SESSION['connection'])->select("select trim(prd1.prd_deskripsipanjang) || '-' || prd1.prd_unit || '-' || to_char(prd1.prd_frac, '9999') utuh_desk,
            prd1.prd_prdcd utuh_prdcd,
            trim(prd2.prd_deskripsipanjang) || '-' || prd2.prd_unit || '-' || to_char(prd2.prd_frac, '9999') olah_desk,
            prd2.prd_prdcd olah_prdcd, was_persen
            from tbmaster_prodmast prd1, tbtr_mix_waste, tbmaster_prodmast prd2
            where was_prdcd_konv = prd2.prd_prdcd and was_prdcd= prd1.prd_prdcd and was_kodeigr = '".$_SESSION['kdigr']."'");

        return DataTables::of($lov)->make(true);
    }

    public function getDataLovPluMix(){
        $lov = DB::connection($_SESSION['connection'])->select("select distinct prd_deskripsipanjang mix_desk, prd_prdcd mix_prdcd
            from tbmaster_prodmast, tbtr_mix_plukonversi
            where prd_kodeigr='".$_SESSION['kdigr']."'
            and knv_prdcd= prd_prdcd and knv_kodeigr = prd_kodeigr
            order by prd_deskripsipanjang");

        return DataTables::of($lov)->make(true);
    }

    public function getDataLovNodoc(){
        $lov = DB::connection($_SESSION['connection'])->select("select msth_nodoc, TO_CHAR(msth_tgldoc,'DD/MM/YYYY') msth_tgldoc from tbtr_mstran_h
            where msth_typetrn = 'A'
            order by msth_tgldoc desc, msth_nodoc desc");

        return DataTables::of($lov)->make(true);
    }

    public function getDataPluOlahan(Request $request){
        $data = DB::connection($_SESSION['connection'])->select("SELECT knv_prdcd,
                   knv_prdcd_konv,
                      trim(prd_deskripsipanjang) || '-' || prd_unit || '-' || to_char(prd_frac, '9999')
                      deskripsi
              FROM tbtr_mix_plukonversi, tbmaster_prodmast
             WHERE knv_prdcd = '".$request->plu."' AND prd_prdcd = knv_prdcd_konv
          ORDER BY knv_prdcd_konv");

        return $data;
    }

    public function konversiUtuhOlahan(Request $request){
        $utuh_prdcd = $request->utuhprdcd;
        $utuh_qty = $request->utuhqty;
        $olah_prdcd = $request->olahprdcd;
        $olah_qty = $request->olahqty;

        $avgcost = 0;

        $temp = DB::connection($_SESSION['connection'])->table('tbtr_mix_waste')
            ->where('was_prdcd','=',$utuh_prdcd)
            ->where('was_prdcd_konv','=',$olah_prdcd)
            ->count();

        if($temp == 0)
            return (['status' => 'error', 'alert' => 'Data Konversi tidak ada!']);

        $temp = DB::connection($_SESSION['connection'])->table('tbmaster_prodmast')
            ->where('prd_prdcd','=',$utuh_prdcd)
            ->count();

        if($temp == 0)
            return (['status' => 'error', 'alert' => 'Data Master Produk tidak ada!']);

        $temp = DB::connection($_SESSION['connection'])->table('tbmaster_prodmast')
            ->where('prd_prdcd','=',$olah_prdcd)
            ->count();

        if($temp == 0)
            return (['status' => 'error', 'alert' => 'Data Master Produk Konversi tidak ada!']);

        $temp = DB::connection($_SESSION['connection'])->table('tbmaster_stock')
            ->select('st_saldoakhir')
            ->where('st_lokasi','=','01')
            ->where('st_prdcd','=',$utuh_prdcd)
            ->first();

        if(!$temp)
            return (['status' => 'error', 'alert' => 'Data Stock tidak ada!']);

        $stock = $temp->st_saldoakhir;

        if($stock < $utuh_qty)
            return (['status' => 'error', 'alert' => 'Qty Stock tidak cukup!']);

        if(true){
            $c = loginController::getConnectionProcedure();
            $s = oci_parse($c, "BEGIN :ret := F_IGR_GET_NOMOR('".$_SESSION['kdigr']."','KNV','Nomor Konversi','B'||TO_CHAR(SYSDATE,'yy'),5,TRUE); END;");
            oci_bind_by_name($s, ':ret', $no_knv, 32);
            oci_execute($s);

            $temp = DB::connection($_SESSION['connection'])->table('tbmaster_stock')
                ->where('st_lokasi','=','01')
                ->where('st_prdcd','=',$utuh_prdcd)
                ->first();

            if(!$temp){
                DB::connection($_SESSION['connection'])->table('tbmaster_stock')
                    ->insert([
                        'st_kodeigr' => $_SESSION['kdigr'],
                        'st_prdcd' => $utuh_prdcd,
                        'st_lokasi' => '01',
                        'st_create_by' => $_SESSION['usid'],
                        'st_create_dt' => DB::RAW("SYSDATE")
                    ]);
            }

            $temp = DB::connection($_SESSION['connection'])->table('tbmaster_stock')
                ->where('st_lokasi','=','01')
                ->where('st_prdcd','=',$olah_prdcd)
                ->first();

            if(!$temp){
                DB::connection($_SESSION['connection'])->table('tbmaster_stock')
                    ->insert([
                        'st_kodeigr' => $_SESSION['kdigr'],
                        'st_prdcd' => $olah_prdcd,
                        'st_lokasi' => '01',
                        'st_create_by' => $_SESSION['usid'],
                        'st_create_dt' => DB::RAW("SYSDATE")
                    ]);
            }

            $data = DB::connection($_SESSION['connection'])->table('tbmaster_prodmast')
                ->select('prd_kodedivisi','prd_kodedepartement','prd_kodekategoribarang','prd_flagbkp1','prd_flagbkp2','prd_unit','prd_frac','prd_lastcost')
                ->where('prd_prdcd','=',$utuh_prdcd)
                ->first();

            $divisi = $data->prd_kodedivisi;
            $dept = $data->prd_kodedepartement;
            $kat = $data->prd_kodekategoribarang;
            $bkp1 = $data->prd_flagbkp1;
            $bkp2 = $data->prd_flagbkp2;
            $unit = $data->prd_unit;
            $frac = $data->prd_frac;
            $harga = $data->prd_lastcost;

            $data = DB::connection($_SESSION['connection'])->table('tbmaster_stock')
                ->selectRaw("nvl(st_avgcost,0) oldacost, nvl(st_lastcost,0) oldlcost, case when st_saldoakhir < 0 then  0 else nvl(st_saldoakhir,0) end oldstock")
                ->where('st_prdcd','=',$utuh_prdcd)
                ->where('st_lokasi','=','01')
                ->first();

            $oldacost = $data->oldacost;
            $oldlcost = $data->oldlcost;
            $oldstock = $data->oldstock;

            $harga = $oldacost;

            DB::connection($_SESSION['connection'])->table('tbtr_mstran_d')
                ->insert([
                    'mstd_kodeigr' => $_SESSION['kdigr'],
                    'mstd_typetrn' => 'A',
                    'mstd_nodoc' => $no_knv,
                    'mstd_tgldoc' => DB::RAW("TRUNC(SYSDATE)"),
                    'mstd_seqno' => 1,
                    'mstd_prdcd' => $utuh_prdcd,
                    'mstd_kodedivisi' => $divisi,
                    'mstd_kodedepartement' => $dept,
                    'mstd_kodekategoribrg' => $kat,
                    'mstd_bkp' => $bkp1,
                    'mstd_fobkp' => $bkp2,
                    'mstd_unit' => $unit,
                    'mstd_frac' => $frac,
                    'mstd_qty' => $utuh_qty,
                    'mstd_hrgsatuan' => $harga,
                    'mstd_gross' => $utuh_qty * ($harga / 1000),
                    'mstd_avgcost' => $avgcost,
                    'mstd_ocost' => $oldacost,
                    'mstd_posqty' => $oldstock,
                    'mstd_flagdisc1' => 'U',
                    'mstd_create_by' => $_SESSION['usid'],
                    'mstd_create_dt' => DB::RAW("SYSDATE")
                ]);

            $avgcost = (100 / (100 - ( ( ($utuh_qty - $olah_qty) / $utuh_qty) * 100))) * $harga;

            $newlcost = $avgcost;

            DB::connection($_SESSION['connection'])->update("UPDATE TBMASTER_STOCK
                SET ST_SALDOAKHIR = NVL (ST_SALDOAKHIR, 0) - NVL (".$utuh_qty.", 0),
                     ST_TRFOUT = NVL (ST_TRFOUT, 0) + NVL ( ".$utuh_qty.", 0),
                     ST_MODIFY_BY = '".$_SESSION['usid']."',
                     ST_MODIFY_DT = TRUNC (SYSDATE)
                WHERE     ST_PRDCD = '".$utuh_prdcd."'
                AND ST_LOKASI = '01'
                AND ST_KODEIGR = '".$_SESSION['kdigr']."'");

            $data = DB::connection($_SESSION['connection'])->table('tbmaster_prodmast')
                ->select('prd_kodedivisi','prd_kodedepartement','prd_kodekategoribarang','prd_flagbkp1','prd_flagbkp2','prd_unit','prd_frac')
                ->where('prd_prdcd','=',$olah_prdcd)
                ->first();

            $divisi = $data->prd_kodedivisi;
            $dept = $data->prd_kodedepartement;
            $kat = $data->prd_kodekategoribarang;
            $bkp1 = $data->prd_flagbkp1;
            $bkp2 = $data->prd_flagbkp2;
            $unit = $data->prd_unit;
            $frac = $data->prd_frac;

            $data = DB::connection($_SESSION['connection'])->table('tbmaster_stock')
                ->selectRaw("nvl(st_avgcost,0) oldacost, nvl(st_lastcost,0) oldlcost, case when st_saldoakhir < 0 then  0 else nvl(st_saldoakhir,0) end oldstock")
                ->where('st_prdcd','=',$olah_prdcd)
                ->where('st_lokasi','=','01')
                ->first();

            $oldacost = $data->oldacost;
            $oldlcost = $data->oldlcost;
            $oldstock = $data->oldstock;

            $newqty = $oldstock + $olah_qty;
            $harga_konv = $avgcost;

            $avgcost = ((( $oldstock * ($oldacost / 1000)) + ($olah_qty * ($harga_konv / 1000))) / ($oldstock + $olah_qty)) * 1000;

            DB::connection($_SESSION['connection'])->table('tbtr_mstran_d')
                ->insert([
                    'mstd_kodeigr' => $_SESSION['kdigr'],
                    'mstd_typetrn' => 'A',
                    'mstd_nodoc' => $no_knv,
                    'mstd_tgldoc' => DB::RAW("TRUNC(SYSDATE)"),
                    'mstd_seqno' => 2,
                    'mstd_prdcd' => $olah_prdcd,
                    'mstd_kodedivisi' => $divisi,
                    'mstd_kodedepartement' => $dept,
                    'mstd_kodekategoribrg' => $kat,
                    'mstd_bkp' => $bkp1,
                    'mstd_fobkp' => $bkp2,
                    'mstd_unit' => $unit,
                    'mstd_frac' => $frac,
                    'mstd_qty' => $olah_qty,
                    'mstd_hrgsatuan' => $harga_konv,
                    'mstd_gross' => $olah_qty * ($harga_konv / 1000),
                    'mstd_avgcost' => $avgcost,
                    'mstd_ocost' => $oldacost,
                    'mstd_posqty' => $oldstock,
                    'mstd_flagdisc1' => 'O',
                    'mstd_flagdisc2' => 'I',
                    'mstd_create_by' => $_SESSION['usid'],
                    'mstd_create_dt' => DB::RAW("SYSDATE")
                ]);

            DB::connection($_SESSION['connection'])->update("UPDATE TBMASTER_STOCK
                SET ST_AVGCOST = ".$avgcost.",
                     ST_SALDOAKHIR = NVL (ST_SALDOAKHIR, 0) - NVL (".$olah_qty.", 0),
                     ST_TRFIN = NVL (ST_TRFIN, 0) + NVL ( ".$olah_qty.", 0),
                     ST_TGLAVGCOST = TRUNC(SYSDATE),
                     ST_MODIFY_BY = '".$_SESSION['usid']."',
                     ST_MODIFY_DT = TRUNC (SYSDATE)
                WHERE     ST_PRDCD = '".$olah_prdcd."'
                AND ST_LOKASI = '01'
                AND ST_KODEIGR = '".$_SESSION['kdigr']."'");

            $rec2s = DB::connection($_SESSION['connection'])->select("SELECT PRD_PRDCD, PRD_UNIT, PRD_FRAC
               FROM TBMASTER_PRODMAST
              WHERE     SUBSTR (PRD_PRDCD, 1, 6) =
                           SUBSTR ( '".$olah_prdcd."', 1, 6)
                    AND PRD_KODEIGR = '".$_SESSION['kdigr']."'");

            foreach($rec2s as $rec2){
                if(substr($rec2->prd_prdcd,-1) == '1' || $rec2->prd_unit == 'KG'){
                    DB::connection($_SESSION['connection'])->table('tbmaster_prodmast')
                        ->where('prd_prdcd','=',$rec2->prd_prdcd)
                        ->where('prd_kodeigr','=',$_SESSION['kdigr'])
                        ->update([
                            'prd_avgcost' => $avgcost
                        ]);
                }
                else{
                    DB::connection($_SESSION['connection'])->table('tbmaster_prodmast')
                        ->where('prd_prdcd','=',$rec2->prd_prdcd)
                        ->where('prd_kodeigr','=',$_SESSION['kdigr'])
                        ->update([
                            'prd_avgcost' => $avgcost * $frac
                        ]);
                }
            }

            $temp = DB::connection($_SESSION['connection'])->table('tbhistory_cost')
                ->where('hcs_prdcd','=',$olah_prdcd)
                ->where('hcs_tglbpb','=',DB::RAW("TRUNC(SYSDATE)"))
                ->where('hcs_nodocbpb','=',$no_knv)
                ->count();

            if($temp == 0){
                DB::connection($_SESSION['connection'])->table('tbhistory_cost')
                    ->insert([
                        'hcs_kodeigr' => $_SESSION['kdigr'],
                        'hcs_lokasi' => $_SESSION['kdigr'],
                        'hcs_typetrn' => 'A',
                        'hcs_prdcd' => $olah_prdcd,
                        'hcs_tglbpb' => DB::RAW("TRUNC(SYSDATE)"),
                        'hcs_nodocbpb' => $no_knv,
                        'hcs_qtybaru' => $olah_qty,
                        'hcs_qtylama' => $oldstock,
                        'hcs_avglama' => $oldacost,
                        'hcs_avgbaru' => $avgcost,
                        'hcs_lastqty' => $newqty,
                        'hcs_create_by' => $_SESSION['usid'],
                        'hcs_create_dt' => DB::RAW("SYSDATE")
                    ]);
            }

            DB::connection($_SESSION['connection'])->table('tbhistory_cost')
                ->where('hcs_prdcd','=',$olah_prdcd)
                ->where('hcs_tglbpb','=',DB::RAW("TRUNC(SYSDATE)"))
                ->where('hcs_nodocbpb','=',$no_knv)
                ->update([
                    'hcs_lastcostbaru' => $newlcost,
                    'hcs_lastcostlama' => $oldlcost
                ]);

            DB::connection($_SESSION['connection'])->table('tbmaster_stock')
                ->where('st_prdcd','=',$olah_prdcd)
                ->where('st_kodeigr','=',$_SESSION['kdigr'])
                ->update([
                    'st_lastcost' => $newlcost
                ]);

            DB::connection($_SESSION['connection'])->update("UPDATE TBMASTER_PRODMAST
                 SET PRD_LASTCOST =
                        ".$newlcost." * CASE WHEN prd_unit = 'KG' THEN 1 ELSE prd_frac END
               WHERE     SUBSTR (PRD_PRDCD, 1, 6) =
                            SUBSTR ('".$olah_prdcd."', 1, 6)
                     AND PRD_KODEIGR = '".$_SESSION['kdigr']."'");

            DB::connection($_SESSION['connection'])->table('tbtr_mstran_h')
                ->insert([
                    'msth_kodeigr' => $_SESSION['kdigr'],
                    'msth_typetrn' => 'A',
                    'msth_nodoc' => $no_knv,
                    'msth_tgldoc' => DB::RAW("TRUNC(SYSDATE)"),
                    'msth_flagdoc' => '1',
                    'msth_create_by' => $_SESSION['usid'],
                    'msth_create_dt' => DB::RAW("TRUNC(SYSDATE)"),
                ]);

            return ([
                'status' => 'success',
                'alert' => 'Data sudah selesai dikonversi!',
                'nodoc' => $no_knv
            ]);
        }
    }

    public function konversiOlahanMix(Request $request){
        $mix_plu = $request->mix_plu;
        $mix_qty = $request->mix_qty;
        $olahan = $request->olahan;

        $cekqty = 0;

        try{
            DB::beginTransaction();

            foreach($olahan as $o){
                $temp = DB::connection($_SESSION['connection'])->table('tbtr_mix_plukonversi')
                    ->where('knv_prdcd','=',$mix_plu)
                    ->where('knv_prdcd_konv','=',$o['plu'])
                    ->first();

                if(!$temp)
                    return ['status' => 'error', 'alert' => 'Data Konversi '.$mix_plu.' tidak ada!'];

                $temp = DB::connection($_SESSION['connection'])->table('tbmaster_prodmast')
                    ->where('prd_prdcd','=',$o['plu'])
                    ->first();

                if(!$temp)
                    return ['status' => 'error', 'alert' => 'Data Master Produk Konversi '.$o['plu'].' tidak ada!'];

                $temp = DB::connection($_SESSION['connection'])->table('tbmaster_stock')
                    ->select('st_saldoakhir')
                    ->where('st_lokasi','=','01')
                    ->where('st_prdcd','=',$o['plu'])
                    ->first();

                if(!$temp)
                    return ['status' => 'error', 'alert' => 'Data Stock tidak ada!'];

                $stock = $temp->st_saldoakhir;

                if($stock < $o['qty'])
                    return ['status' => 'error', 'alert' => 'Qty Stock PLU '.$o['plu'].' tidak cukup!'];

                $cekqty += $o['qty'];
            }

            if(!($mix_qty >= ($cekqty * 0.95) && $mix_qty <= $cekqty)){
                return ['status' => 'error', 'alert' => 'Qty Olahan dengan Qty Konversi tidak sesuai dengan batas toleransi 5%!'];
            }

            if(true){
                foreach($olahan as $o){
                    $temp = DB::connection($_SESSION['connection'])->table('tbmaster_stock')
                        ->select('st_saldoakhir')
                        ->where('st_lokasi','=','01')
                        ->where('st_prdcd','=',$o['plu'])
                        ->first();

                    if(!$temp){
                        DB::connection($_SESSION['connection'])->table('tbmaster_stock')
                            ->insert([
                                'st_kodeigr' => $_SESSION['kdigr'],
                                'st_prdcd' => $o['plu'],
                                'st_lokasi' => '01',
                                'st_create_by' => $_SESSION['usid'],
                                'st_create_dt' => DB::RAW("SYSDATE")
                            ]);
                    }
                }

                $c = loginController::getConnectionProcedure();
                $s = oci_parse($c, "BEGIN :ret := F_IGR_GET_NOMOR('".$_SESSION['kdigr']."','KNV','Nomor Konversi','B'||TO_CHAR(SYSDATE,'yy'),5,TRUE); END;");
                oci_bind_by_name($s, ':ret', $no_knv, 32);
                oci_execute($s);

                $seqno = 0;
                $itemall = 0;
                $beratall = 0;

                foreach($olahan as $o){
                    $seqno++;

                    $data = DB::connection($_SESSION['connection'])->table('tbmaster_prodmast')
                        ->select('prd_kodedivisi','prd_kodedepartement','prd_kodekategoribarang','prd_flagbkp1','prd_flagbkp2','prd_unit','prd_frac')
                        ->where('prd_prdcd','=',$o['plu'])
                        ->first();

                    $divisi = $data->prd_kodedivisi;
                    $dept = $data->prd_kodedepartement;
                    $kat = $data->prd_kodekategoribarang;
                    $bkp1 = $data->prd_flagbkp1;
                    $bkp2 = $data->prd_flagbkp2;
                    $unit = $data->prd_unit;
                    $frac = $data->prd_frac;

                    $data = DB::connection($_SESSION['connection'])->select("SELECT NVL (st_avgcost, 0) oldacost,
                        NVL (st_lastcost, 0) oldlcost,
                        case when st_saldoakhir < 0 then 0 else NVL (st_saldoakhir, 0) end oldstock
                   FROM tbmaster_stock
                  WHERE st_prdcd = '".$o['plu']."' AND st_lokasi = '01'");

                    $oldacost = $data[0]->oldacost;
                    $oldlcost = $data[0]->oldlcost;
                    $oldstock = $data[0]->oldstock;

                    $newqty = $oldstock + $o['qty'];
                    $harga_konv = $o['qty'] * ($oldacost / 1000);
                    $itemall += $harga_konv;
                    $beratall += $o['qty'];

                    DB::connection($_SESSION['connection'])->table('tbtr_mstran_d')
                        ->insert([
                            'mstd_kodeigr' => $_SESSION['kdigr'],
                            'mstd_typetrn' => 'A',
                            'mstd_nodoc' => $no_knv,
                            'mstd_tgldoc' => DB::RAW("TRUNC(SYSDATE)"),
                            'mstd_seqno' => $seqno,
                            'mstd_prdcd' => $o['plu'],
                            'mstd_kodedivisi' => $divisi,
                            'mstd_kodedepartement' => $dept,
                            'mstd_kodekategoribrg' => $kat,
                            'mstd_bkp' => $bkp1,
                            'mstd_fobkp' => $bkp2,
                            'mstd_unit' => $unit,
                            'mstd_frac' => $frac,
                            'mstd_qty' => $o['qty'],
                            'mstd_hrgsatuan' => $oldacost,
                            'mstd_gross' => $harga_konv,
                            'mstd_avgcost' => $oldacost,
                            'mstd_ocost' => $oldacost,
                            'mstd_posqty' => $oldacost,
                            'mstd_flagdisc1' => 'O',
                            'mstd_flagdisc2' => 'O',
                            'mstd_create_by' => $_SESSION['usid'],
                            'mstd_create_dt' => DB::RAW("SYSDATE"),
                        ]);

                    DB::connection($_SESSION['connection'])->update("UPDATE TBMASTER_STOCK
                        SET ST_SALDOAKHIR =
                               NVL (ST_SALDOAKHIR, 0) - NVL ( ".$o['qty'].", 0),
                            ST_TRFOUT = NVL (ST_TRFOUT, 0) + NVL ( ".$o['qty'].", 0),
                            ST_MODIFY_BY = '".$_SESSION['usid']."',
                            ST_MODIFY_DT = TRUNC (SYSDATE)
                      WHERE     ST_PRDCD = '".$o['plu']."'
                            AND ST_LOKASI = '01'
                            AND ST_KODEIGR = '".$_SESSION['kdigr']."'");
                }

                $temp = DB::connection($_SESSION['connection'])->table('tbmaster_stock')
                    ->where('st_lokasi','=','01')
                    ->where('st_prdcd','=',$mix_plu)
                    ->first();

                if(!$temp){
                    DB::connection($_SESSION['connection'])->table('tbmaster_stock')
                        ->insert([
                            'st_kodeigr' => $_SESSION['kdigr'],
                            'st_prdcd' => $mix_plu,
                            'st_lokasi' => '01'
                        ]);
                }

                $data = DB::connection($_SESSION['connection'])->table('tbmaster_prodmast')
                    ->select('prd_kodedivisi','prd_kodedepartement','prd_kodekategoribarang','prd_flagbkp1','prd_flagbkp2','prd_unit','prd_frac')
                    ->where('prd_prdcd','=',$mix_plu)
                    ->first();

                $divisi = $data->prd_kodedivisi;
                $dept = $data->prd_kodedepartement;
                $kat = $data->prd_kodekategoribarang;
                $bkp1 = $data->prd_flagbkp1;
                $bkp2 = $data->prd_flagbkp2;
                $unit = $data->prd_unit;
                $frac = $data->prd_frac;

                $data = DB::connection($_SESSION['connection'])->select("SELECT NVL (st_avgcost, 0) oldacost,
                        NVL (st_lastcost, 0) oldlcost,
                        case when st_saldoakhir < 0 then 0 else NVL (st_saldoakhir, 0) end oldstock
                   FROM tbmaster_stock
                  WHERE st_prdcd = '".$mix_plu."' AND st_lokasi = '01'");

                $oldacost = $data[0]->oldacost;
                $oldlcost = $data[0]->oldlcost;
                $oldstock = $data[0]->oldstock;

                $avgcost = ($itemall / $beratall) * 1000;
                $newlcost = $avgcost;
                $avgcostgram = $newlcost / 1000;

                $avgcost = ((($oldstock * ($oldacost / 1000)) + $itemall) / ($oldstock + $beratall)) * 1000;

                DB::connection($_SESSION['connection'])->table('tbtr_mstran_d')
                    ->insert([
                        'mstd_kodeigr' => $_SESSION['kdigr'],
                        'mstd_typetrn' => 'A',
                        'mstd_nodoc' => $no_knv,
                        'mstd_tgldoc' => DB::RAW("TRUNC(SYSDATE)"),
                        'mstd_seqno' => $seqno + 1,
                        'mstd_prdcd' => $mix_plu,
                        'mstd_kodedivisi' => $divisi,
                        'mstd_kodedepartement' => $dept,
                        'mstd_kodekategoribrg' => $kat,
                        'mstd_bkp' => $bkp1,
                        'mstd_fobkp' => $bkp2,
                        'mstd_unit' => $unit,
                        'mstd_frac' => $frac,
                        'mstd_qty' => $mix_qty,
                        'mstd_hrgsatuan' => $newlcost,
                        'mstd_gross' => $mix_qty * ($newlcost / 1000),
                        'mstd_avgcost' => $avgcost,
                        'mstd_ocost' => $oldacost,
                        'mstd_posqty' => $oldstock,
                        'mstd_flagdisc1' => 'M',
                        'mstd_create_by' => $_SESSION['usid'],
                        'mstd_create_dt' => DB::RAW("SYSDATE"),
                    ]);

                DB::connection($_SESSION['connection'])->update("UPDATE TBMASTER_STOCK
                 SET ST_AVGCOST = ".$avgcost.",
                     ST_SALDOAKHIR = NVL (ST_SALDOAKHIR, 0) + NVL ( ".$mix_qty.", 0),
                     ST_TRFIN = NVL (ST_TRFIN, 0) + NVL ( ".$mix_qty.", 0),
                     st_tglavgcost = TRUNC (SYSDATE),
                     ST_MODIFY_BY = '".$_SESSION['usid']."',
                     ST_MODIFY_DT = TRUNC (SYSDATE)
               WHERE     ST_PRDCD = '".$mix_plu."'
                     AND ST_LOKASI = '01'
                     AND ST_KODEIGR = '".$_SESSION['kdigr']."'");

                $rec2s = DB::connection($_SESSION['connection'])->select("SELECT PRD_PRDCD, PRD_UNIT, PRD_FRAC
               FROM TBMASTER_PRODMAST
              WHERE     SUBSTR (PRD_PRDCD, 1, 6) =
                           SUBSTR ( '".$mix_plu."', 1, 6)
                    AND PRD_KODEIGR = '".$_SESSION['kdigr']."'");

                foreach($rec2s as $rec2){
                    if(substr($rec2->prd_prdcd,-1) == '1' || $rec2->prd_unit == 'KG'){
                        DB::connection($_SESSION['connection'])->table('tbmaster_prodmast')
                            ->where('prd_prdcd','=',$rec2->prd_prdcd)
                            ->where('prd_kodeigr','=',$_SESSION['kdigr'])
                            ->update([
                                'prd_avgcost' => $avgcost
                            ]);
                    }
                    else{
                        DB::connection($_SESSION['connection'])->table('tbmaster_prodmast')
                            ->where('prd_prdcd','=',$rec2->prd_prdcd)
                            ->where('prd_kodeigr','=',$_SESSION['kdigr'])
                            ->update([
                                'prd_avgcost' => $avgcost * $frac
                            ]);
                    }
                }

                $temp = DB::connection($_SESSION['connection'])->table('tbhistory_cost')
                    ->where('hcs_prdcd','=',$mix_plu)
                    ->where('hcs_tglbpb','=',DB::RAW("TRUNC(SYSDATE)"))
                    ->where('hcs_nodocbpb','=',$no_knv)
                    ->first();

                if(!$temp){
                    DB::connection($_SESSION['connection'])->table('tbhistory_cost')
                        ->insert([
                            'HCS_KODEIGR' => $_SESSION['kdigr'],
                            'HCS_LOKASI' => $_SESSION['kdigr'],
                            'HCS_TYPETRN' => 'A',
                            'HCS_PRDCD' => $mix_plu,
                            'HCS_TGLBPB' => DB::RAW("TRUNC(SYSDATE)"),
                            'HCS_NODOCBPB' => $no_knv,
                            'HCS_QTYBARU' => $mix_qty,
                            'HCS_QTYLAMA' => $oldstock,
                            'HCS_AVGLAMA' => $oldacost,
                            'HCS_AVGBARU' => $avgcost,
                            'HCS_LASTQTY' => $newqty,
                            'HCS_CREATE_BY' => $_SESSION['usid'],
                            'HCS_CREATE_DT' => DB::RAW("SYSDATE"),
                        ]);
                }

                DB::connection($_SESSION['connection'])->table('tbhistory_cost')
                    ->where('hcs_prdcd','=',$mix_plu)
                    ->where('hcs_tglbpb','=',DB::RAW("TRUNC(SYSDATE)"))
                    ->where('hcs_nodocbpb','=',$no_knv)
                    ->update([
                        'hcs_lastcostbaru' => $newlcost,
                        'hcs_lastcostlama' => $oldlcost
                    ]);

                DB::connection($_SESSION['connection'])->table('tbmaster_stock')
                    ->where('st_prdcd','=',$mix_plu)
                    ->where('st_kodeigr','=',$_SESSION['kdigr'])
                    ->update([
                        'st_lastcost' => $newlcost
                    ]);

                DB::connection($_SESSION['connection'])->update("UPDATE TBMASTER_PRODMAST
                 SET PRD_LASTCOST =
                        ".$newlcost." * CASE WHEN prd_unit = 'KG' THEN 1 ELSE prd_frac END
               WHERE     SUBSTR (PRD_PRDCD, 1, 6) = SUBSTR ( '".$mix_plu."', 1, 6)
                     AND PRD_KODEIGR = '".$_SESSION['kdigr']."'");

                DB::connection($_SESSION['connection'])->table('tbtr_mstran_h')
                    ->insert([
                        'msth_kodeigr' => $_SESSION['kdigr'],
                        'msth_typetrn' => 'A',
                        'msth_nodoc' => $no_knv,
                        'msth_tgldoc' => DB::RAW("TRUNC(SYSDATE)"),
                        'msth_flagdoc' => '1',
                        'msth_create_by' => $_SESSION['usid'],
                        'msth_create_dt' => DB::RAW("SYSDATE")
                    ]);
            }

            DB::commit();
            return ['status' => 'success', 'alert' => 'Proses Konversi Berhasil dilakukan!', 'nodoc' => $no_knv];
        }
        catch(QueryException $e){
            DB::rollBack();

            return ['status' => 'error', 'alert' => 'Proses Konversi Gagal dilakukan!'];
        }
    }

    public function printBukti(Request $request){
        if(isset($request->reprint))
            $reprint = $request->reprint;
        else $reprint = 0;

        if(isset($request->nodoc))
            $where = "AND msth_nodoc = '".$request->nodoc."'";
        else
            $where = "AND msth_tgldoc between TO_DATE('".$request->periode1."','DD/MM/YYYY') AND TO_DATE('".$request->periode2."','DD/MM/YYYY')";

        $rec = DB::connection($_SESSION['connection'])->select("Select
            msth_recordid, msth_nodoc, TO_CHAR(msth_tgldoc,'DD/MM/YYYY') msth_tgldoc, msth_nopo, msth_tglpo,
            msth_nofaktur, msth_tglfaktur, msth_cterm, msth_flagdoc,
            msth_loc||' '||cab_namacabang cabang,mstd_prdcd, prd_deskripsipanjang,
            prd_unit||'/'||prd_frac kemasan, mstd_qty, mstd_frac,
                        mstd_seqno,
            mstd_hrgsatuan, mstd_ppnrph, mstd_ppnbmrph, mstd_ppnbtlrph,
            case when nvl(mstd_flagdisc1, 'A') = 'U' or (nvl(mstd_flagdisc1, 'A') = 'O' and nvl(mstd_flagdisc2, 'A') = 'O') then mstd_qty else 0 end qty_out,
            case when nvl(mstd_flagdisc1, 'A') = 'M' or (nvl(mstd_flagdisc1, 'A') = 'O' and nvl(mstd_flagdisc2, 'A') = 'I') then mstd_qty else 0 end qty_in,
            case when nvl(mstd_flagdisc1, 'A') = 'U' or (nvl(mstd_flagdisc1, 'A') = 'O' and nvl(mstd_flagdisc2, 'A') = 'O') then mstd_gross else 0 end gross_out,
            case when nvl(mstd_flagdisc1, 'A') = 'M' or (nvl(mstd_flagdisc1, 'A') = 'O' and nvl(mstd_flagdisc2, 'A') = 'I') then mstd_gross else 0 end gross_in,
            nvl(mstd_rphdisc1,0), nvl(mstd_rphdisc2,0),nvl(mstd_rphdisc3,0),
            nvl(mstd_qtybonus1,0), nvl(mstd_qtybonus2,0),  mstd_keterangan
        From
            tbtr_mstran_h,
            tbtr_mstran_d,
            tbmaster_prodmast,
            tbmaster_cabang
        Where
            msth_kodeigr='22'
            and msth_typetrn = 'A'
            and mstd_nodoc=msth_nodoc
            and mstd_kodeigr=msth_kodeigr
            and prd_kodeigr=msth_kodeigr
            and prd_prdcd = mstd_prdcd
            and cab_kodecabang(+)=msth_loc
            and cab_kodeigr(+)=msth_kodeigr
            ".$where."
        ORDER BY
           msth_nodoc, MSTD_SEQNO");

        if(count($rec) == 0)
            return 'Data tidak ditemukan!';
        else{
            $datas = [];
            $x = [];
            $no = '';
            foreach($rec as $r){
                if($no != $r->msth_nodoc){
                    $no = $r->msth_nodoc;
                    if(count($x) > 0)
                        $datas[] = $x;
                    $x = [];
                }
                $x[] = $r;
            }
            $datas[] = $x;
        }

        $perusahaan = DB::connection($_SESSION['connection'])->table('tbmaster_perusahaan')
            ->select('prs_namaperusahaan','prs_namacabang')
            ->first();

        $dompdf = new PDF();

        $pdf = PDF::loadview('BACKOFFICE.PROSES.konversi-bukti',compact(['perusahaan','datas','reprint']));

        error_reporting(E_ALL ^ E_DEPRECATED);

        $pdf->output();
        $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);

        $canvas = $dompdf ->get_canvas();
        $canvas->page_text(507, 80.75, "{PAGE_NUM} dari {PAGE_COUNT}", null, 7, array(0, 0, 0));

        $dompdf = $pdf;

        return $dompdf->stream('Memo Penyesuaian Persediaan Konversi Perishable.pdf');
    }

    public function printLaporanRekap(Request $request){
        $where = " AND mstd_tgldoc between TO_DATE('".$request->periode1."','DD/MM/YYYY') AND TO_DATE('".$request->periode2."','DD/MM/YYYY') ";

        $data = DB::connection($_SESSION['connection'])->select("SELECT prd_kodedivisi,
         div_namadivisi,
         prd_kodedepartement,
         dep_namadepartement,
         prd_kodekategoribarang,
         kat_namakategori,
         SUM (mstd_gross * case when nvl(mstd_flagdisc1, 'A') = 'U' or (nvl(mstd_flagdisc1, 'A') = 'O' and nvl(mstd_flagdisc2, 'A') = 'O') then -1 else 1 end) total,
         mstd_tgldoc
    FROM (  SELECT prd_kodedivisi,
                   div_namadivisi,
                   prd_kodedepartement,
                   dep_namadepartement,
                   prd_kodekategoribarang,
                   kat_namakategori,
                   mstd_prdcd,
                   mstd_flagdisc1,
                   mstd_flagdisc2,
                   mstd_gross,
                   NVL (mstd_discrph * case when nvl(mstd_flagdisc1, 'A') = 'U' or (nvl(mstd_flagdisc1, 'A') = 'O' and nvl(mstd_flagdisc2, 'A') = 'O') then -1 else 1 end, 0) mstd_pot,
                   NVL (mstd_ppnrph * case when nvl(mstd_flagdisc1, 'A') = 'U' or (nvl(mstd_flagdisc1, 'A') = 'O' and nvl(mstd_flagdisc2, 'A') = 'O') then -1 else 1 end, 0) mstd_ppn,
                   NVL (mstd_ppnbmrph * case when nvl(mstd_flagdisc1, 'A') = 'U' or (nvl(mstd_flagdisc1, 'A') = 'O' and nvl(mstd_flagdisc2, 'A') = 'O') then -1 else 1 end, 0) mstd_bm,
                   NVL (mstd_ppnbtlrph * case when nvl(mstd_flagdisc1, 'A') = 'U' or (nvl(mstd_flagdisc1, 'A') = 'O' and nvl(mstd_flagdisc2, 'A') = 'O') then -1 else 1 end, 0) mstd_btl,
                   NVL (mstd_gross * case when nvl(mstd_flagdisc1, 'A') = 'U' or (nvl(mstd_flagdisc1, 'A') = 'O' and nvl(mstd_flagdisc2, 'A') = 'O') then -1 else 1 end, 0) total,
                   TO_CHAR(mstd_tgldoc,'DD/MM/YYYY') mstd_tgldoc
              FROM tbmaster_divisi,
                   tbmaster_departement,
                   tbmaster_kategori,
                   tbtr_mstran_h,
                   tbtr_mstran_d,
                   tbmaster_prodmast
             WHERE     msth_kodeigr = '".$_SESSION['kdigr']."'
                   AND NVL (msth_recordid, '0') <> '1'
                   AND NVL (mstd_recordid, '0') <> '1'
                   ".$where."
                   AND mstd_nodoc = msth_nodoc
                   AND msth_typetrn = 'A'
                   AND div_kodeigr(+) = '".$_SESSION['kdigr']."'
                   AND dep_kodeigr(+) = '".$_SESSION['kdigr']."'
                   AND kat_kodeigr(+) = '".$_SESSION['kdigr']."'
                   AND prd_prdcd = mstd_prdcd
                   AND div_kodedivisi(+) = prd_kodedivisi
                   AND dep_kodedepartement(+) = prd_kodedepartement
                   AND dep_kodedivisi(+) = prd_kodedivisi
                   AND kat_kodekategori(+) = prd_kodekategoribarang
                   AND kat_kodedepartement(+) = prd_kodedepartement
          ORDER BY prd_kodedivisi, prd_kodedepartement, prd_kodekategoribarang)
GROUP BY prd_kodedivisi,
         div_namadivisi,
         prd_kodedepartement,
         dep_namadepartement,
         prd_kodekategoribarang,
         kat_namakategori,
         mstd_tgldoc
ORDER BY prd_kodedivisi, prd_kodedepartement, prd_kodekategoribarang");

        if(count($data) == 0)
            return 'Data tidak ditemukan!';

        $perusahaan = DB::connection($_SESSION['connection'])->table('tbmaster_perusahaan')
            ->select('prs_namaperusahaan','prs_namacabang')
            ->first();

        $dompdf = new PDF();

        $pdf = PDF::loadview('BACKOFFICE.PROSES.konversi-laporan-rekap',compact(['perusahaan','data']));

        error_reporting(E_ALL ^ E_DEPRECATED);

        $pdf->output();
        $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);

        $canvas = $dompdf ->get_canvas();
        $canvas->page_text(507, 80.75, "{PAGE_NUM} dari {PAGE_COUNT}", null, 7, array(0, 0, 0));

        $dompdf = $pdf;

        return $dompdf->stream('Memo Penyesuaian Persediaan Konversi Perishable.pdf');
    }

    public function printLaporanDetail(Request $request){
        $where = " AND mstd_tgldoc between TO_DATE('".$request->periode1."','DD/MM/YYYY') AND TO_DATE('".$request->periode2."','DD/MM/YYYY') ";

        $data = DB::connection($_SESSION['connection'])->select("SELECT msth_nodoc,
                     TO_CHAR(msth_tgldoc, 'DD/MM/YYYY') msth_tgldoc,
                     kemasan,
                     keterangan,
                     plu,
                     barang,
                     mstd_qty qty,
                     harga,
                     total,
                     prd_kodedivisi,
                     div_namadivisi,
                     prd_kodedepartement,
                     dep_namadepartement,
                     prd_kodekategoribarang,
                     kat_namakategori
                FROM (  SELECT msth_nodoc,
                               msth_tgldoc,
                               mstd_prdcd plu,
                               mstd_keterangan keterangan,
                               prd_deskripsipanjang barang,
                               prd_unit || '/' || prd_frac kemasan,
                               mstd_hrgsatuan harga,
                               NVL (mstd_GROSS  * case when nvl(mstd_flagdisc1, 'A') = 'U' or (nvl(mstd_flagdisc1, 'A') = 'O' and nvl(mstd_flagdisc2, 'A') = 'O') then -1 else 1 end, 0) total,
                               NVL (mstd_qty  * case when nvl(mstd_flagdisc1, 'A') = 'U' or (nvl(mstd_flagdisc1, 'A') = 'O' and nvl(mstd_flagdisc2, 'A') = 'O') then -1 else 1 end, 0) mstd_qty,
                               prd_kodedivisi,
                               div_namadivisi,
                               prd_kodedepartement,
                               dep_namadepartement,
                               prd_kodekategoribarang,
                               kat_namakategori,
                               mstd_prdcd,
                               prd_deskripsipanjang,
                               mstd_gross
                          FROM tbmaster_divisi,
                               tbmaster_departement,
                               tbmaster_kategori,
                               tbmaster_prodmast,
                               tbtr_mstran_h,
                               tbtr_mstran_d
                         WHERE     msth_kodeigr = '".$_SESSION['kdigr']."'
                               AND mstd_recordid IS NULL
                               ".$where."
                               AND mstd_nodoc = msth_nodoc
                               AND mstd_kodeigr = '".$_SESSION['kdigr']."'
                               AND msth_typetrn = 'A'
                               AND prd_kodeigr(+) = '".$_SESSION['kdigr']."'
                               AND div_kodeigr(+) = '".$_SESSION['kdigr']."'
                               AND dep_kodeigr(+) = '".$_SESSION['kdigr']."'
                               AND prd_prdcd(+) = mstd_prdcd
                               AND kat_kodeigr(+) = '".$_SESSION['kdigr']."'
                               AND div_kodedivisi(+) = prd_kodedivisi
                               AND dep_kodedepartement(+) = prd_kodedepartement
                               AND dep_kodedivisi(+) = prd_kodedivisi
                               AND kat_kodekategori(+) = prd_kodekategoribarang
                               AND kat_kodedepartement(+) = prd_kodedepartement
                      ORDER BY prd_kodedivisi,
                               prd_kodedepartement,
                               prd_kodekategoribarang,
                               plu)
            GROUP BY msth_nodoc,
                     msth_tgldoc,
                     kemasan,
                     keterangan,
                     plu,
                     barang,
                     harga,
                     mstd_qty,
                     total,
                     prd_kodedivisi,
                     div_namadivisi,
                     prd_kodedepartement,
                     dep_namadepartement,
                     prd_kodekategoribarang,
                     kat_namakategori
            ORDER BY prd_kodedivisi,
                     prd_kodedepartement,
                     prd_kodekategoribarang,
                     msth_nodoc,
                     plu");

//        dd($data);

        if(count($data) == 0)
            return 'Data tidak ditemukan!';

        $perusahaan = DB::connection($_SESSION['connection'])->table('tbmaster_perusahaan')
            ->select('prs_namaperusahaan','prs_namacabang')
            ->first();

        $dompdf = new PDF();

        $pdf = PDF::loadview('BACKOFFICE.PROSES.konversi-laporan-detail',compact(['perusahaan','data']));

        error_reporting(E_ALL ^ E_DEPRECATED);

        $pdf->output();
        $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);

        $canvas = $dompdf ->get_canvas();
        $canvas->page_text(757, 80.75, "{PAGE_NUM} dari {PAGE_COUNT}", null, 7, array(0, 0, 0));

        $dompdf = $pdf;

        return $dompdf->stream('Memo Penyesuaian Persediaan Konversi Perishable.pdf');
    }
}
