<?php

namespace App\Http\Controllers\OMI;

use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use PDF;
use Yajra\DataTables\DataTables;
use File;

class ReturController extends Controller
{
    public function index(){
        $efaktur = DB::table('tbmaster_cabang')
            ->selectRaw("NVL(cab_efaktur, 'N') cab_efaktur")
            ->where('cab_kodecabang','=',$_SESSION['kdigr'])
            ->first()->cab_efaktur;

        $recs = DB::select("SELECT DISTINCT ROM_NODOKUMEN
                               FROM TBTR_RETUROMI
                              WHERE ROM_KODEIGR = '".$_SESSION['kdigr']."'
                                AND NVL (ROM_STATUSTRF, '0') = '1'");

        $nomorEdit = '';

        foreach($recs as $rec){
            $nomorEdit .= $rec->rom_nodokumen;

            if(!array_key_last($rec))
                $nomorEdit .= ', ';
        }

        if($nomorEdit != '')
            $nomorEdit = 'Ada data transferan yang belum di edit, nomor : '.$nomorEdit;

        $recs = DB::select("SELECT DISTINCT ROM_NODOKUMEN,
                                    TO_CHAR(rom_tgldokumen,'dd/mm/yyyy') rom_tgldokumen,
                                    ROM_KODETOKO
                               FROM TBTR_RETUROMI
                              WHERE ROM_KODEIGR = '".$_SESSION['kdigr']."'
                                AND NVL (ROM_RECORDID, '0') NOT IN ('1', '2')
                                AND TO_CHAR (ROM_TGLDOKUMEN, 'YYYYMM') = TO_CHAR (SYSDATE, 'YYYYMM')");

        $nomorCek = '';

        foreach($recs as $idx => $rec){
            $nomorCek .= $rec->rom_nodokumen.' - '.$rec->rom_tgldokumen.' - '.$rec->rom_kodetoko;

            if($idx !== array_key_last($recs))
                $nomorCek .= ', ';
        }

        if($nomorCek != '')
            $nomorCek = 'Ada data transferan yang belum selesai cek dan cetak, nomor : '.$nomorCek;

        return view('OMI.RETUR.retur')->with(compact(
            [
                'nomorEdit',
                'nomorCek'
            ]
        ));
    }

    public function getNewNodoc(){
        $connect = oci_connect('SIMSMG', 'SIMSMG', '192.168.237.193:1521/SIMSMG');

        $query = oci_parse($connect, "BEGIN :nodoc := f_igr_get_nomor('" . $_SESSION['kdigr'] . "','RTO','Nomor Retur OMI','O'|| to_char(sysdate, 'yy'),4,true); END;");
        oci_bind_by_name($query, ':nodoc', $nodoc, 7);
        oci_execute($query);

        return response()->json(compact(['nodoc']));
    }

    public function checkMember(Request $request){
        $temp = DB::table('tbmaster_customer')
            ->where('cus_kodemember','=',$request->kodemember)
            ->first();

        if(!$temp){
            return response()->json([
                'message' => 'Member tidak terdaftar di Master Customer!'
            ], 500);
        }
        else{
            $temp = DB::table('tbmaster_tokoigr')
                ->select('tko_kodeomi')
                ->where('tko_kodeigr','=',$_SESSION['kdigr'])
                ->where('tko_kodecustomer','=',$request->kodemember)
                ->first();

            if(!$temp){
                return response()->json([
                    'message' => 'Member tidak terdaftar di Master Toko OMI!'
                ], 500);
            }
            else{
                return response()->json([
                    'kodetoko' => $temp->tko_kodeomi,
                    'pkp' => $this->checkPKP($request->kodemember)
                ], 200);
            }
        }
    }

    public function checkPKP($kodemember){
        $temp = DB::table('tbmaster_customer')
            ->select('cus_npwp')
            ->where('cus_kodemember','=',$kodemember)
            ->whereRaw("NVL(cus_flagpkp,'N') = 'Y'")
            ->first();

        if(!$temp){
            return 'N';
        }
        else{
            if(self::nvl($temp->cus_npwp, '0000') != '0000')
                return 'Y';
            else{
                $temp = DB::table('tbmaster_npwp')
                    ->where('pwp_kodeigr','=',$_SESSION['kdigr'])
                    ->where('pwp_kodemember','=',$kodemember)
                    ->first();

                if(!$temp)
                    return 'N';
                else return 'Y';
            }
        }
    }

    public function checkNRB(Request $request){
        $temp = DB::table('tbtr_returomi')
            ->where('rom_kodeigr','=',$_SESSION['kdigr'])
            ->where('rom_noreferensi','=',$request->nonrb)
            ->whereRaw("rom_tglreferensi = to_date('".$request->tglnrb."','dd/mm/yyyy')")
            ->where('rom_kodetoko','=',$request->kodetoko)
            ->first();

        if($temp){
            return response()->json([
                'message' => 'Retur OMI '.$request->nonrb.' sudah pernah diproses!'
            ], 500);
        }
        else{
            return response()->json([
                'message' => 'OK'
            ], 200);
        }
    }

    public function getLovNodoc(Request $request){
        $where = "rom_nodokumen like '%".$request->search."%'";

        $data = DB::table('tbtr_returomi')
            ->selectRaw("rom_nodokumen nodoc,to_char(rom_tgldokumen, 'dd/mm/yyyy') tgl, rom_tgldokumen")
            ->where('rom_kodeigr','=',$_SESSION['kdigr'])
            ->whereNotNull('rom_nodokumen')
            ->whereRaw("NVL(rom_recordid,'0') <> '1'")
            ->whereRaw($where)
            ->orderBy('rom_tgldokumen','desc')
            ->orderBy('rom_nodokumen','desc')
            ->distinct()
            ->limit($request->search == '' ? 100 : 0)
            ->get();

        return DataTables::of($data)->make(true);
    }

    public function getLovMember(Request $request){
        $data = DB::select("SELECT CUS_KODEMEMBER, TKO_KODEOMI, CUS_NAMAMEMBER
            FROM TBMASTER_CUSTOMER, TBMASTER_TOKOIGR
            WHERE CUS_KODEIGR = '".$_SESSION['kdigr']."'
            AND TKO_KODEIGR = CUS_KODEIGR AND
            TKO_KODECUSTOMER = CUS_KODEMEMBER
            ORDER BY TKO_KODEOMI ASC, CUS_KODEMEMBER ASC");

        return DataTables::of($data)->make(true);
    }

    public function getData(Request $request){
        $temp = DB::table('tbtr_returomi')
            ->where('rom_kodeigr','=',$_SESSION['kdigr'])
            ->where('rom_nodokumen','=',$request->nodokumen)
            ->first();

        if(!$temp){
            return response()->json([
                'message' => 'Dokumen tidak ditemukan!'
            ], 500);
        }
        else{
            $data = DB::table('tbtr_returomi')
                ->join('tbmaster_prodmast','prd_prdcd','=','rom_prdcd')
                ->leftJoin('tbhistory_hargastrukomi',function($join){
                    $join->on('hso_prdcd','=',DB::RAW("substr(rom_prdcd,1,6) || '1'"));
                    $join->on('hso_kodeigr','=','rom_kodeigr');
                    $join->on('hso_kodemember','=','rom_member');
                })
                ->selectRaw("to_char(rom_tgldokumen, 'dd/mm/yyyy') rom_tgldokumen, rom_prdcd, rom_hrg, rom_ttl, rom_qty, rom_qtyrealisasi, rom_qtyselisih,
                 rom_qtymlj, rom_qtytlj, rom_noreferensi, to_char(rom_tglreferensi,'dd/mm/yyyy') rom_tglreferensi,
                 rom_member, rom_kodetoko, rom_statusdata, prd_deskripsipanjang, rom_referensistruk, rom_namadrive,
                 rom_recordid, to_char(hso_tgldokumen1, 'dd/mm/yyyy') hso_tgldokumen1, to_char(hso_tgldokumen2, 'dd/mm/yyyy') hso_tgldokumen2,
                 to_char(hso_tgldokumen3, 'dd/mm/yyyy') hso_tgldokumen3, hso_qty1, hso_qty2, hso_qty3,
                 round(hso_hrgsatuan1) hso_hrgsatuan1, round(hso_hrgsatuan2) hso_hrgsatuan2, round(hso_hrgsatuan3) hso_hrgsatuan3,
                 rom_avgcost, rom_flagbkp, rom_flagbkp2")
                ->where('rom_nodokumen','=',$request->nodokumen)
                ->orderBy('rom_prdcd','asc')
                ->get();

            foreach($data as $d){
                if($d->rom_statusdata == '2' && $d->rom_qtyrealisasi == '0')
                    $d->rom_qtyrealisasi = $d->rom_qty;

                $d->rom_hrg = round($d->rom_hrg);
                $d->rom_ttl = round($d->rom_ttl);
            }

            return $data;
        }
    }

    public function getDataHistoryStrukOmi(Request $request){
        $data = DB::table('tbhistory_strukomi')
            ->where('hso_kodeigr','=',$_SESSION['kdigr'])
            ->where('hso_kodemember','=',$request->kodemember)
            ->where('hso_prdcd','=',$request->prdcd)
            ->get();

        dd($data);
    }

    public function deleteData(Request $request){
        try{
            DB::beginTransaction();

            $data = DB::table('tbtr_returomi')
                ->where('rom_kodeigr','=',$_SESSION['kdigr'])
                ->where('rom_nodokumen','=',$request->nodoc)
                ->get();

            foreach($data as $d){
                DB::update("UPDATE tbmaster_stock
               SET st_sales = NVL(st_sales, 0) + ".$d->rom_qty.",
                   st_saldoakhir = NVL(st_saldoakhir, 0) - ".$d->rom_qty."
             WHERE st_kodeigr = '".$_SESSION['kdigr']."'
               AND st_prdcd = SUBSTR('".$d->rom_prdcd."', 1, 6) || '0'
               AND st_lokasi = '01'");

//                $plu = DB::select("SELECT prd_prdcd
//              FROM (SELECT   *
//                        FROM tbmaster_prodmast
//                       WHERE SUBSTR(prd_prdcd, 1, 6) = SUBSTR('".$d->rom_prdcd."', 1, 6)
//                         AND SUBSTR(prd_prdcd, 7, 1) <> '0'
//                         AND NVL(prd_kodetag,'0') <> 'X'
//                    ORDER BY prd_prdcd)
//             WHERE ROWNUM = 1")[0]->prd_prdcd;
//
//                dd($plu);
            }

            $temp = DB::select("SELECT trpt_salesvalue
          FROM tbtr_piutang
         WHERE trpt_kodeigr = '".$_SESSION['kdigr']."'
           AND trpt_type = 'D'
           AND trpt_receivedate = to_date('".$request->tgldoc."','dd/mm/yyyy')
           AND trpt_cus_kodemember = '".$request->kodemember."'
           AND trpt_docno = '".$request->nodoc."'");

            if(count($temp) > 0){
                $rpretur = $temp[0]->trpt_salesvalue;

                DB::update("UPDATE tbmaster_piutang
                   SET ptg_amtar = NVL(ptg_amtar, 0) + ".$rpretur.",
                       ptg_modify_by = '".$_SESSION['usid']."',
                       ptg_modify_dt = SYSDATE
                 WHERE ptg_kodeigr = '".$_SESSION['kdigr']."'
                 AND ptg_kodemember = '".$request->kodemember."'");

                DB::update("UPDATE tbtr_piutang
                   SET trpt_recordid = '1'
                 WHERE trpt_kodeigr = '".$_SESSION['kdigr']."'
                   AND trpt_type = 'D'
                   AND trpt_receivedate = to_date('".$request->tgldoc."','dd/mm/yyyy')
                   AND trpt_cus_kodemember = '".$request->kodemember."'
                   AND trpt_docno = '".$request->nodoc."'");
            }

            DB::table('tbtr_returomi')
                ->where('rom_nodokumen','=',$request->nodoc)
                ->where('rom_kodeigr','=',$_SESSION['kdigr'])
                ->update([
                    'rom_recordid' => '1'
                ]);

            DB::commit();

            return response()->json([
                'message' => 'Data dengan nomor dokumen '.$request->nodoc.'berhasil dihapus!'
            ], 200);
        }
        catch (QueryException $e){
            DB::rollBack();

            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getPRDCD(Request $request){
        $prdcd = $request->prdcd;

        if(substr($prdcd,0,1) == '#'){
            $prdcd = substr($prdcd,1);
        }

        if(strlen($prdcd) < 7){
            $prdcd = substr('0000000'.$prdcd, -7);
        }

        $temp1 = DB::table('tbmaster_prodmast')
            ->where('prd_kodeigr','=',$_SESSION['kdigr'])
            ->where('prd_prdcd','=',$prdcd)
            ->first();

        $temp2 = DB::table('tbmaster_barcode')
            ->where('brc_barcode','=',$prdcd)
            ->first();

        if(!$temp1 && !$temp2){
            return response()->json([
                'message' => 'Kode PLU '.$prdcd.' tidak terdaftar di Master Barang!'
            ], 500);
        }

        if(substr($prdcd, -1) != '0'){
            $prdcd = substr($prdcd,0,6).'0';
        }

        //vrec

        $temp = DB::table('tbtr_returomi')
            ->select('rom_recordid')
            ->where('rom_kodeigr','=',$_SESSION['kdigr'])
            ->where('rom_nodokumen','=',$request->nodoc)
            ->whereRaw("rom_tgldokumen = to_date('".$request->tgldoc."','dd/mm/yyyy')")
            ->where('rom_prdcd','=',$prdcd)
            ->first();

        if($temp){
            $recid = $temp->rom_recordid;

            if($recid == '2'){
                return response()->json([
                    'message' => 'Dokumen ini telah diproses, tidak boleh diedit!'
                ], 500);
            }
        }

        $temp = DB::table('tbmaster_prodmast')
            ->where('prd_kodeigr','=',$_SESSION['kdigr'])
            ->where('prd_prdcd','=',$prdcd)
            ->first();

        if(!$temp){
            return response()->json([
                'message' => 'Kode PLU '.$prdcd.' tidak terdaftar di Master Barang!'
            ], 500);
        }

        $txt_prdcd = DB::selectOne("SELECT prd_prdcd
            FROM (SELECT   *
                    FROM TBMASTER_PRODMAST
                   WHERE SUBSTR (prd_prdcd, 1, 6) = SUBSTR ('".$prdcd."', 1, 6)
                     AND SUBSTR (prd_prdcd, 7, 1) <> '0'
                     AND NVL(prd_kodetag,'0') <> 'X'
                ORDER BY prd_prdcd)
            WHERE ROWNUM = 1");

        if($txt_prdcd)
            $txt_prdcd = $txt_prdcd->prd_prdcd;
        else $txt_prdcd = null;

        $temp = DB::selectOne("SELECT count(1) jml
                    FROM (SELECT   HSO_PRDCD_LAMA, MAX (HSO_CREATE_DT)
                    FROM TBHISTORY_PLUOMI
                    WHERE substr(HSO_PRDCD_BARU,1,6) = substr('".$txt_prdcd."',1,6)
                    GROUP BY HSO_PRDCD_LAMA)");

        if($temp->jml > 0){
            $tempsj = substr($txt_prdcd, -1);

            $tempplu = DB::selectOne("SELECT HSO_PRDCD_LAMA
                    FROM (SELECT   HSO_PRDCD_LAMA, MAX (HSO_CREATE_DT)
                    FROM TBHISTORY_PLUOMI
                    WHERE substr(HSO_PRDCD_BARU,1,6) = substr('".$txt_prdcd."',1,6)
                    GROUP BY HSO_PRDCD_LAMA)");

            $txt_prdcd = substr($tempplu, 0, 6).$tempsj;
        }

        $temp = DB::table('tbmaster_stock')
            ->where('st_kodeigr','=',$_SESSION['kdigr'])
            ->whereRaw("st_prdcd = substr('".$prdcd."',1,6) || '0'")
            ->where('st_lokasi','=','01')
            ->first();

        if(!$temp){
            return response()->json([
                'message' => 'Kode barang belum terdaftar di file Master Stock!'
            ], 500);
        }

        $data = DB::selectOne("SELECT prd_prdcd, prd_deskripsipanjang, prd_flagbkp1, prd_flagbkp2,
            st_avgcost, to_char(hso_tgldokumen1, 'dd/mm/yyyy') hso_tgldokumen1, to_char(hso_tgldokumen2, 'dd/mm/yyyy') hso_tgldokumen2,
            to_char(hso_tgldokumen3, 'dd/mm/yyyy') hso_tgldokumen3, hso_qty1, hso_qty2, hso_qty3,
            round(hso_hrgsatuan1) hso_hrgsatuan1, round(hso_hrgsatuan2) hso_hrgsatuan2, round(hso_hrgsatuan3) hso_hrgsatuan3
            FROM TBMASTER_PRODMAST
            join TBMASTER_STOCK on st_kodeigr = prd_kodeigr and st_prdcd = SUBSTR(prd_prdcd, 1, 6) || '0'
            and st_lokasi = '01'
            left join TBHISTORY_HARGASTRUKOMI on hso_kodeigr = prd_kodeigr
            AND hso_prdcd = SUBSTR(prd_prdcd, 1, 6) || '1' and hso_kodemember = '".$request->kodemember."'
            WHERE prd_kodeigr = '".$_SESSION['kdigr']."'
            AND prd_prdcd = '".$prdcd."'
            ");

        return response()->json($data, 200);
    }

    public function saveData(Request $request){
        try{
            DB::beginTransaction();

            if($request->hitungSelisih != 0 && $request->namadrive == ''){
                return response()->json([
                    'type' => 'DRIVER',
                    'title' => 'Ada selisih beban driver!',
                    'message' => 'Isi nama driver telebih dahulu!'
                ], 500);
            }

            if(count($request->newData) > $request->qty){
                return response()->json([
                    'type' => 'QTY',
                    'title' => 'Ada data yang belum lengkap!',
                    'message' => 'Silahkan dicek kembali!'
                ], 500);
            }

            $temp = DB::table('tbtr_returomi')
                ->select('rom_prdcd','rom_create_by','rom_create_dt')
                ->where('rom_kodeigr','=',$_SESSION['kdigr'])
                ->where('rom_nodokumen','=',$request->nodokumen)
                ->get();

            DB::table('tbtr_returomi')
                ->where('rom_kodeigr','=',$_SESSION['kdigr'])
                ->where('rom_nodokumen','=',$request->nodokumen)
                ->delete();

            foreach($request->newData as $d){
                $ins = [];

                $top = DB::table('tbmaster_customer')
                    ->select('cus_top')
                    ->where('cus_kodemember','=',$request->kodemember)
                    ->first()->cus_top;

                $new = true;

                foreach($temp as $t){
                    if($d['rom_prdcd'] == $t->rom_prdcd){
                        $new = false;
                        $create_by = $t->rom_create_by;
                        $create_dt = $t->rom_create_dt;
                        break;
                    }
                }

                if($new){
                    $ins['rom_create_by'] = $_SESSION['usid'];
                    $ins['rom_create_dt'] = DB::RAW("sysdate");
                }
                else{
                    $ins['rom_create_by'] = $create_by;
                    $ins['rom_create_dt'] = $create_dt;
                    $ins['rom_modify_by'] = $_SESSION['usid'];
                    $ins['rom_modify_dt'] = DB::RAW("sysdate");
                }

                if($request->typeRetur == 'M'){
                    $ins['rom_statusdata'] = '1';
                }
                else{
                    $ins['rom_statusdata'] = '2';
                    $ins['rom_statustrf'] = null;
                }

                if($d['rom_qtyselisih'] != 0){
                    $hrgjual = DB::selectOne("SELECT prd_hrgjual
                  FROM (SELECT   *
                            FROM tbmaster_prodmast
                           WHERE SUBSTR (prd_prdcd, 1, 6) = SUBSTR ('".$d['rom_prdcd']."', 1, 6)
                             AND SUBSTR (prd_prdcd, 7, 1) <> '0'
                             AND NVL(prd_kodetag,'0') <> 'X'
                        ORDER BY prd_prdcd)
                 WHERE ROWNUM = 1")->prd_hrgjual;

                    $ins['rom_hrgsatuan'] = $hrgjual;
                    $ins['rom_ttlnilai'] = $d['rom_qtyselisih'] * $hrgjual;
                }

                $ins['rom_ttlcost'] = $d['rom_avgcost'] * $d['rom_qtyrealisasi'];
                $ins['rom_ttl'] = $d['rom_qty'] * $d['rom_hrg'];
                $ins['rom_qtytlr'] = 0;
                $ins['rom_hrgsatuan'] = 0;
                $ins['rom_ttlnilai'] = 0;
                $ins['rom_kodeigr'] = $_SESSION['kdigr'];
                $ins['rom_nodokumen'] = $request->nodokumen;
                $ins['rom_tgldokumen'] = DB::RAW("to_date('".$request->tgldokumen."','dd/mm/yyyy')");
                $ins['rom_tgljatuhtempo'] = DB::RAW("to_date('".$request->tgldokumen."','dd/mm/yyyy') +".$top);
                $ins['rom_noreferensi'] = $request->noreferensi;
                $ins['rom_tglreferensi'] = DB::RAW("to_date('".$request->tglreferensi."','dd/mm/yyyy')");
                $ins['rom_kodetoko'] = $request->kodetoko;
                $ins['rom_member'] = $request->kodemember;
                $ins['rom_prdcd'] = $d['rom_prdcd'];
                $ins['rom_prdcd'] = $d['rom_prdcd'];
                $ins['rom_hrg'] = $d['rom_hrg'];
                $ins['rom_ttl'] = $d['rom_ttl'];
                $ins['rom_qty'] = $d['rom_qty'];
                $ins['rom_qtyrealisasi'] = $d['rom_qtyrealisasi'];
                $ins['rom_qtyselisih'] = $d['rom_qtyselisih'];
                $ins['rom_qtymlj'] = $d['rom_qtymlj'];
                $ins['rom_qtytlj'] = $d['rom_qtytlj'];
                $ins['rom_avgcost'] = $d['rom_avgcost'];
                $ins['rom_flagbkp'] = $d['rom_flagbkp'];
                $ins['rom_flagbkp2'] = $d['rom_flagbkp2'];

                DB::table('tbtr_returomi')
                    ->insert($ins);
            }

//            dd($insert);
//
//            DB::table('tbtr_returomi')
//                ->where('rom_kodeigr','=',$_SESSION['kdigr'])
//                ->where('rom_nodokumen','=',$request->nodokumen)
//                ->whereRaw("nvl(rom_qty,0) = 0")
//                ->delete();

            DB::commit();

            return response()->json([
                'message' => 'Data berhasil disimpan!'
            ], 200);
        }
        catch (QueryException $e){
            DB::rollBack();

            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function print(Request $request){
        try{
            DB::beginTransaction();

            $print = [];

            $noreset = null;

            //$this->checkPKP($request->kodemember);

            $cek_x = DB::select("SELECT nvl(prd_kodetag,'zzz') tag, rom_prdcd
                          FROM tbtr_returomi, tbmaster_prodmast
                         WHERE rom_kodeigr = '".$_SESSION['kdigr']."'
                           AND rom_nodokumen = '".$request->nodoc."'
                           AND rom_tgldokumen = TO_DATE('".$request->tgldoc."','dd/mm/yyyy')
                           AND prd_kodeigr = rom_kodeigr
                           AND prd_prdcd = rom_prdcd
                           and prd_kodetag = 'X'");

            foreach($cek_x as $c){
                if($c->tag == 'X'){
                    return response()->json([
                        'type' => 'TAGX',
                        'message' => 'PLU '.$c->rom_prdcd.' memiliki tag X!',
                    ], 500);
                }
            }

            if($request->hitungSelisih != 0 && $request->driver == ''){
                return response()->json([
                    'type' => 'DRIVER',
                    'title' => 'Ada selisih beban driver!',
                    'message' => 'Isi nama driver telebih dahulu!'
                ], 500);
            }
            else{
                $step = 1;

                $recid = DB::selectOne("SELECT DISTINCT NVL(rom_recordid, '0') recid
                       FROM tbtr_returomi
                       WHERE rom_kodeigr = '".$_SESSION['kdigr']."'
                       AND rom_nodokumen = '".$request->nodoc."'")->recid;

                $rpretur = 0;
                $ppnretur = 0;
                $lctkretur = false;
                $lctkrusak = false;
                $seqno = 0;

                if($recid != '2'){
                    if($request->paramTypeRetur == 'M'){
                        $recs = DB::table('tbtr_returomi')
                            ->where('rom_kodeigr','=',$_SESSION['kdigr'])
                            ->where('rom_nodokumen','=',$request->nodoc)
                            ->get();

                        foreach($recs as $rec){
                            $step = 2;

                            DB::update("UPDATE tbmaster_stock
                       SET st_sales = NVL(st_sales, 0) - ".$rec->rom_qty.",
                           st_saldoakhir = NVL(st_saldoakhir, 0) + ".$rec->rom_qty."
                     WHERE st_kodeigr = '".$_SESSION['kdigr']."'
                       AND st_prdcd = SUBSTR('".$rec->rom_prdcd."', 1, 6) || '0'
                       AND st_lokasi = '01'");
                        }
                    }
                    else{
                        if($request->hitungMlj != 0){
                            $step = 3;
                            $lambilrus = true;
                            $lambilret = true;
                            $dokrus = null;
                            $dokret = null;

                            $recs = DB::select("SELECT   tbtr_returomi.*,
                                         NVL(tbmaster_stock.st_avgcost, 0) st_avgcost,
                                         NVL(tbmaster_stock.st_saldoakhir, 0) st_saldoakhir,
                                         tbmaster_hargabeli.hgb_kodesupplier,
                                         tbmaster_hargabeli.hgb_statusbarang,
                                         tbmaster_supplier.sup_pkp
                                    FROM tbtr_returomi,
                                         tbmaster_hargabeli,
                                         tbmaster_supplier,
                                         tbmaster_stock
                                   WHERE rom_kodeigr = '".$_SESSION['kdigr']."'
                                     AND rom_nodokumen = '".$request->nodoc."'
                                     AND hgb_kodeigr = rom_kodeigr
                                     AND hgb_tipe = '2'
                                     AND SUBSTR(hgb_prdcd, 1, 6) = SUBSTR(rom_prdcd, 1, 6)
                                     AND sup_kodeigr = hgb_kodeigr
                                     AND sup_kodesupplier = hgb_kodesupplier
                                     AND st_kodeigr = rom_kodeigr
                                     AND st_prdcd = SUBSTR(rom_prdcd, 1, 6) || '0'
                                     AND st_lokasi = '01'
                                ORDER BY rom_prdcd");

                            foreach($recs as $rec){
                                $step = 4;
                                $cekplu = '1'.$rec->rom_prdcd;
                                $supplier = $rec->hgb_kodesupplier;
                                $nopo = $rec->rom_nodokumen;
                                $tglpo = $rec->rom_tgldokumen;
                                $noref = $rec->rom_noreferensi;
                                $tglref = $rec->rom_tglreferensi;
                                $pkp = $rec->sup_pkp;
                                $step = 5;

                                $temp = DB::selectOne("SELECT prd_unit,
                               prd_frac,
                               prd_kodedivisi,
                               prd_kodedepartement,
                               prd_kodekategoribarang,
                               prd_flagbkp1,
                               prd_flagbkp2,
                               prd_kodetag
                          FROM tbmaster_prodmast
                         WHERE prd_kodeigr = '".$_SESSION['kdigr']."' AND prd_prdcd = '".$rec->rom_prdcd."'");

                                $unit = $temp->prd_unit;
                                $frac = $temp->prd_frac;
                                $div = $temp->prd_kodedivisi;
                                $dept = $temp->prd_kodedepartement;
                                $katb = $temp->prd_kodekategoribarang;
                                $bkp1 = $temp->prd_flagbkp1;
                                $bkp2 = $temp->prd_flagbkp2;
                                $tag = $temp->prd_kodetag;

                                $qty = self::nvl($rec->rom_qtyrealisasi, 0);

                                $step = 6;

                                DB::update("UPDATE tbmaster_stock
                                    SET st_sales = NVL(st_sales, 0) - ".$qty.",
                                       st_saldoakhir = NVL(st_saldoakhir, 0) + ".$qty."
                                    WHERE st_kodeigr = '".$_SESSION['kdigr']."'
                                    AND st_prdcd = SUBSTR('".$rec->rom_prdcd."', 1, 6) || '0'
                                    AND st_lokasi = '01'");

                                if(self::nvl($request->hitungMlj,0) != 0 && self::nvl($rec->rom_qtytlj,0) > 0){
                                    $step = 7;
                                    $qty = $rec->rom_qtyrealisasi;
                                    $seqno += 1;

                                    if(self::nvl($rec->hgb_statusbarang,'AA') == 'RT' || self::nvl($rec->hgb_statusbarang,'AA') == 'TG'){
                                        $fdisc2 = 'T';
                                        $keter = 'Rubah status barang NRB ke Retur';
                                        $ketret = $keter;

                                        if(self::nvl($tag, '1') != 'O' && self::nvl($tag, '1') != 'N')
                                            $qty = $rec->rom_qtytlj;
                                    }

                                    if(self::nvl($rec->hgb_statusbarang,'AA') == 'PT'){
                                        $step = 8;
                                        $fdisc2 = 'R';
                                        $keter = 'Rubah status barang NRB ke Rusak';
                                        $ketrus = $keter;
                                        $qty = $rec->rom_qtytlj;
                                    }

                                    if($fdisc2 == 'T'){
                                        $lctkretur = true;

                                        if($lambilret){
                                            $step = 9;

                                            $connect = oci_connect('SIMSMG', 'SIMSMG', '192.168.237.193:1521/SIMSMG');

                                            $query = oci_parse($connect,
                                                "BEGIN :ret := f_igr_get_nomor('" . $_SESSION['kdigr'] . "',
                                                'BT','Nomor Barang Retur','9' || TO_CHAR(SYSDATE, 'yy') || 'T',4,TRUE); END;");
                                            oci_bind_by_name($query, ':ret', $dokret, 32);
                                            oci_execute($query);

                                            $lambilret = false;
                                        }

                                        $supret = $supplier;
                                        $dokumen = $dokret;
                                    }
                                    else if($fdisc2 == 'R'){
                                        $lctkrusak = true;

                                        if($lambilrus){
                                            $step = 10;

                                            $connect = oci_connect('SIMSMG', 'SIMSMG', '192.168.237.193:1521/SIMSMG');

                                            $query = oci_parse($connect,
                                                "BEGIN :ret := f_igr_get_nomor('" . $_SESSION['kdigr'] . "',
                                                'BR','Nomor Barang Rusak','9' || TO_CHAR(SYSDATE, 'yy') || 'R',4,TRUE); END;");
                                            oci_bind_by_name($query, ':ret', $dokrus, 32);
                                            oci_execute($query);

                                            $lambilrus = false;
                                        }

                                        $suprus = $supplier;
                                        $dokumen = $dokrus;
                                    }

                                    $step = 11;

                                    DB::insert("INSERT INTO tbtr_mstran_d
                                        (mstd_kodeigr,
                                         mstd_typetrn,
                                         mstd_nodoc,
                                         mstd_tgldoc,
                                         mstd_nopo,
                                         mstd_tglpo,
                                         mstd_nofaktur,
                                         mstd_tglfaktur,
                                         mstd_kodesupplier,
                                         mstd_pkp,
                                         mstd_seqno,
                                         mstd_prdcd,
                                         mstd_kodedivisi,
                                         mstd_kodedepartement,
                                         mstd_kodekategoribrg,
                                         mstd_bkp,
                                         mstd_fobkp,
                                         mstd_unit,
                                         mstd_frac,
                                         mstd_loc,
                                         mstd_qty,
                                         mstd_hrgsatuan,
                                         mstd_flagdisc1,
                                         mstd_flagdisc2,
                                         mstd_gross,
                                         mstd_avgcost,
                                         mstd_ocost,
                                         mstd_posqty,
                                         mstd_keterangan,
                                         mstd_create_dt,
                                         mstd_create_by,
                                         mstd_qtybonus1,
                                         mstd_qtybonus2,
                                         mstd_persendisc1,
                                         mstd_rphdisc1,
                                         mstd_persendisc2,
                                         mstd_rphdisc2,
                                         mstd_rphdisc2ii,
                                         mstd_rphdisc2iii,
                                         mstd_persendisc3,
                                         mstd_rphdisc3,
                                         mstd_persendisc4,
                                         mstd_rphdisc4,
                                         mstd_dis4cp,
                                         mstd_dis4cr,
                                         mstd_dis4rp,
                                         mstd_dis4rr,
                                         mstd_dis4jp,
                                         mstd_dis4jr,
                                         mstd_discrph,
                                         mstd_ppnrph,
                                         mstd_ppnbmrph,
                                         mstd_ppnbtlrph,
                                         mstd_persendisc2ii,
                                         mstd_persendisc2iii,
                                         mstd_cterm
                                        )
                            VALUES      ('".$_SESSION['kdigr']."',
                                         'Z',
                                         '".$dokumen."',
                                         SYSDATE,
                                         '".$rec->rom_nodokumen."',
                                         '".$rec->rom_tgldokumen."',
                                         '".$rec->rom_noreferensi."',
                                         '".$rec->rom_tglreferensi."',
                                         '".$supplier."',
                                         '".$pkp."',
                                         '".$seqno."',
                                         '".$rec->rom_prdcd."',
                                         '".$div."',
                                         '".$dept."',
                                         '".$katb."',
                                         '".$bkp1."',
                                         '".$bkp2."',
                                         '".$unit."',
                                         '".$frac."',
                                         '".$_SESSION['kdigr']."',
                                         ".$qty.",
                                         (".$rec->st_avgcost." * '".$frac."'),
                                         'B',
                                         fdisc2,
                                         (qty * ".$rec->st_avgcost."),
                                         (".$rec->st_avgcost."
                                          * CASE
                                              WHEN NVL('".$unit."', 'AA') = 'KG'
                                                  THEN 1
                                              ELSE '".$frac."'
                                          END
                                         ),
                                         (".$rec->st_avgcost."
                                          * CASE
                                              WHEN NVL('".$unit."', 'AA') = 'KG'
                                                  THEN 1
                                              ELSE '".$frac."'
                                          END
                                         ),
                                         NVL(".$rec->st_saldoakhir.", 0),
                                         '".$keter."',
                                         SYSDATE,
                                         '".$_SESSION['usid']."',
                                         0,
                                         0,
                                         0,
                                         0,
                                         0,
                                         0,
                                         0,
                                         0,
                                         0,
                                         0,
                                         0,
                                         0,
                                         0,
                                         0,
                                         0,
                                         0,
                                         0,
                                         0,
                                         0,
                                         0,
                                         0,
                                         0,
                                         0,
                                         0,
                                         0
                                        )");
                                }
                            }

                            if($lctkrusak){
                                $step = 12;

                                DB::insert("INSERT INTO tbtr_mstran_h
                                    (msth_kodeigr,
                                     msth_typetrn,
                                     msth_nodoc,
                                     msth_tgldoc,
                                     msth_nopo,
                                     msth_tglpo,
                                     msth_nofaktur,
                                     msth_tglfaktur,
                                     msth_kodesupplier,
                                     msth_pkp,
                                     msth_keterangan_header,
                                     msth_flagdoc,
                                     msth_create_by,
                                     msth_create_dt,
                                     msth_cterm
                                    )
                                 VALUES ('".$_SESSION['kdigr']."',
                                     'Z',
                                     '".$dokrus."',
                                     SYSDATE,
                                     '".$nopo."',
                                     '".$tglpo."',
                                     '".$noref."',
                                     '".$tglref."',
                                     '".$suprus."',
                                     '".$pkp."',
                                     '".$ketrus."',
                                     '1',
                                     '".$_SESSION['usid']."',
                                     SYSDATE,
                                     0
                                    )");
                            }

                            if($lctkretur){
                                $step = 13;

                                DB::insert("INSERT INTO tbtr_mstran_h
                                    (msth_kodeigr,
                                     msth_typetrn,
                                     msth_nodoc,
                                     msth_tgldoc,
                                     msth_nopo,
                                     msth_tglpo,
                                     msth_nofaktur,
                                     msth_tglfaktur,
                                     msth_kodesupplier,
                                     msth_pkp,
                                     msth_keterangan_header,
                                     msth_flagdoc,
                                     msth_create_by,
                                     msth_create_dt,
                                     msth_cterm
                                    )
                                 VALUES ('".$_SESSION['kdigr']."',
                                     'Z',
                                     '".$dokret."',
                                     SYSDATE,
                                     '".$nopo."',
                                     '".$tglpo."',
                                     '".$noref."',
                                     '".$tglref."',
                                     '".$supret."',
                                     '".$pkp."',
                                     '".$ketret."',
                                     '1',
                                     '".$_SESSION['usid']."',
                                     SYSDATE,
                                     0
                                    )");
                            }
                        }

                        if(self::nvl($request->hitungTlj,0) != 0){
                            $recs = DB::select("SELECT tbtr_returomi.*,
                                       tbmaster_hargabeli.hgb_statusbarang,
                                       tbmaster_prodmast.prd_prdcd,
                                       (tbmaster_prodmast.prd_avgcost
                                        / CASE
                                            WHEN prd_unit = 'KG'
                                                THEN 1
                                            ELSE prd_frac
                                        END
                                       ) avgcost,
                                       tbmaster_prodmast.prd_kodetag,
                                       tbmaster_prodmast.prd_unit,
                                       tbmaster_prodmast.prd_frac,
                                       tbmaster_prodmast.prd_flagbkp1
                                  FROM tbtr_returomi, tbmaster_hargabeli, tbmaster_prodmast
                                 WHERE rom_kodeigr = '".$_SESSION['kdigr']."'
                                   AND rom_nodokumen = '".$request->nodoc."'
                                   AND hgb_kodeigr = rom_kodeigr
                                   AND hgb_tipe = '2'
                                   AND hgb_prdcd = SUBSTR(rom_prdcd, 1, 6) || '0'
                                   AND prd_kodeigr = rom_kodeigr
                                   AND prd_prdcd = rom_prdcd");

                            foreach($recs as $rec){
                                $step = 14;

                                if(self::nvl($rec->rom_qtytlj,0) != 0){
                                    $qty = $rec->rom_qtytlj;

                                    if(self::nvl($rec->hgb_statusbarang,'AA') == 'PT')
                                        $lokasi = '03';
                                    else{
                                        $lokasi = '02';

                                        if(self::nvl($rec->prd_kodetag,'A') == 'O' || self::nvl($rec->prd_kodetag,'A') == 'N'){
                                            $qty = $rec->rom_qtyrealisasi;
                                        }
                                    }

                                    $qty = $qty;

                                    $temp = DB::table('tbmaster_stock')
                                        ->where('st_kodeigr','=',$_SESSION['kdigr'])
                                        ->where('st_lokasi','=','01')
                                        ->where('st_prdcd','=',substr($rec->rom_prdcd,0,6).'0')
                                        ->first();

                                    $lcostlama = 0;

                                    if(!$temp){
                                        $step = 15;

                                        DB::insert("INSERT INTO tbmaster_stock
                                                        (st_kodeigr,
                                                         st_lokasi,
                                                         st_prdcd,
                                                         st_trfout,
                                                         st_saldoakhir,
                                                         st_create_dt,
                                                         st_create_by,
                                                         st_saldoawal,
                                                         st_trfin,
                                                         st_sales,
                                                         st_retur,
                                                         st_adj,
                                                         st_intransit,
                                                         st_min,
                                                         st_max,
                                                         st_avgcostmonthend,
                                                         st_rpsaldoawal,
                                                         st_rpsaldoawal2
                                                        )
                                            VALUES      ('".$_SESSION['kdigr']."',
                                                         '01',
                                                         SUBSTR('".$rec->rom_prdcd."', 1, 6) || '0',
                                                         ".$qty.",
                                                         ".$qty." * -1,
                                                         SYSDATE,
                                                         '".$_SESSION['usid']."',
                                                         0,
                                                         0,
                                                         0,
                                                         0,
                                                         0,
                                                         0,
                                                         0,
                                                         0,
                                                         0,
                                                         0,
                                                         0
                                                        )");

                                        $cosbaik = 0;
                                        $qtybaik = 0;
                                    }
                                    else{
                                        $step = 16;

                                        $st = DB::selectOne("SELECT st_lastcost, st_avgcost,(st_saldoakhir - qty) qtybaik
                                          FROM tbmaster_stock
                                         WHERE st_kodeigr = '".$_SESSION['kdigr']."'
                                           AND st_lokasi = '01'
                                           AND st_prdcd = SUBSTR(rec.rom_prdcd, 1, 6) || '0'");

                                        $lcostlama = $st->st_lastcost;
                                        $cosbaik = $st->st_avgcost;
                                        $qtybaik = $st->qtybaik;

                                        $step = 17;

                                        DB::update("UPDATE tbmaster_stock
                                           SET st_trfout =(NVL(st_trfout, 0) + ".$qty."),
                                               st_saldoakhir =(NVL(st_saldoakhir, 0) - ".$qty.")
                                         WHERE st_kodeigr = '".$_SESSION['kdigr']."'
                                           AND st_lokasi = '01'
                                           AND st_prdcd = SUBSTR('".$rec->rom_prdcd."', 1, 6) || '0'");
                                    }

                                    $step = 18;

                                    $temp = DB::table('tbmaster_stock')
                                        ->where('st_kodeigr','=',$_SESSION['kdigr'])
                                        ->where('st_lokasi','=',$lokasi)
                                        ->where('st_prdcd','=',substr($rec->rom_prdcd,0,6).'0')
                                        ->first();

                                    if(!$temp){
                                        $step = 19;

                                        DB::insert("INSERT INTO tbmaster_stock
                                            (st_kodeigr,
                                             st_lokasi,
                                             st_prdcd,
                                             st_trfin,
                                             st_saldoakhir,
                                             st_create_dt,
                                             st_create_by,
                                             st_saldoawal,
                                             st_trfout,
                                             st_sales,
                                             st_retur,
                                             st_adj,
                                             st_intransit,
                                             st_min,
                                             st_max,
                                             st_avgcostmonthend,
                                             st_rpsaldoawal,
                                             st_rpsaldoawal2
                                            )
                                VALUES      ('".$_SESSION['kdigr']."',
                                             '".$lokasi."',
                                             SUBSTR('".$rec->rom_prdcd."', 1, 6) || '0',
                                             ".$qty.",
                                             ".$qty.",
                                             SYSDATE,
                                             '".$_SESSION['usid']."',
                                             0,
                                             0,
                                             0,
                                             0,
                                             0,
                                             0,
                                             0,
                                             0,
                                             0,
                                             0,
                                             0
                                            )");

                                        $cosret = 0;
                                        $qtyret = 0;
                                    }
                                    else{
                                        $step = 20;

                                        $st = DB::table('tbmaster_stock')
                                            ->select('st_avgcost','st_saldoakhir')
                                            ->where('st_kodeigr','=',$_SESSION['kdigr'])
                                            ->where('st_lokoasi','=','01')
                                            ->where('st_prdcd','=',substr($rec->rom_prdcd,0,6).'0')
                                            ->first();

                                        $cosret = $st->st_avgcost;
                                        $qtyret = $st->st_saldoakhir;

                                        $step = 21;

                                        DB::update("UPDATE tbmaster_stock
                                   SET st_trfin =(NVL(st_trfin, 0) + ".$qty."),
                                       st_saldoakhir =(NVL(st_saldoakhir, 0) + ".$qty.")
                                 WHERE st_kodeigr = '".$_SESSION['kdigr']."'
                                   AND st_lokasi = '".$lokasi."'
                                   AND st_prdcd = SUBSTR('".$rec->rom_prdcd."', 1, 6) || '0'");
                                    }

                                    $step = 22;

                                    if($qtyret > 0)
                                        $cosstk = (($qtyret * $cosret) + ($qty * $cosbaik) / ($qtyret + $qty));
                                    else $cosstk = (($qty * $cosbaik) / $qty);

                                    $step = 23;

                                    if(nvl($rec->prd_prdcd, '1234567') != '1234567'){
                                        $temp = DB::table('tbmhistory_cost')
                                            ->where('hcs_kodeigr','=',$_SESSION['kdigr'])
                                            ->where('hcs_prdcd','=',$rec->rom_prdcd)
                                            ->where('hcs_nodocbpb','=',$rec->rom_nodokumen)
                                            ->where('hcs_tglbpb','=',$rec->rom_tgldokumen)
                                            ->first();

                                        if(!$temp){
                                            $step = 24;

                                            DB::insert("INSERT INTO tbhistory_cost
                                                (hcs_kodeigr,
                                                 hcs_typetrn,
                                                 hcs_lokasi,
                                                 hcs_prdcd,
                                                 hcs_tglbpb,
                                                 hcs_nodocbpb,
                                                 hcs_avglama,
                                                 hcs_avgbaru,
                                                 hcs_qtybaru,
                                                 hcs_qtylama,
                                                 hcs_lastqty,
                                                 hcs_lastcostbaru,
                                                 hcs_lastcostlama,
                                                 hcs_create_by,
                                                 hcs_create_dt
                                                )
                                    VALUES      ('".$_SESSION['kdigr']."',
                                                 'Z',
                                                 '".$lokasi."',
                                                 '".$rec->rom_prdcd."',
                                                 '".$rec->rom_tgldokumen."',
                                                 '".$rec->rom_nodokumen."',
                                                 (".$cosret."
                                                  * CASE
                                                      WHEN    '".$rec->prd_unit."' = 'KG'
                                                           OR SUBSTR('".$rec->rom_prdcd."', 7, 1) = '1'
                                                          THEN 1
                                                      ELSE '".$rec->prd_frac."'
                                                  END
                                                 ),
                                                 (".$cosstk."
                                                  * CASE
                                                      WHEN    '".$rec->prd_unit."' = 'KG'
                                                           OR SUBSTR('".$rec->rom_prdcd."', 7, 1) = '1'
                                                          THEN 1
                                                      ELSE '".$rec->prd_frac."'
                                                  END
                                                 ),
                                                 ".$qty.",
                                                 ".$qtyret.",
                                                 (".$qty." + ".$qtyret."),
                                                 ".$cosbaik." * '".$rec->prd_frac."',
                                                 ".$lcostlama." * '".$rec->prd_frac."',
                                                 '".$_SESSION['usid']."',
                                                 SYSDATE
                                                )");
                                        }
                                    }

                                    $step = 25;

                                    DB::table('tbmaster_stock')
                                        ->where('st_kodeigr','=',$_SESSION['kdigr'])
                                        ->where('st_lokasi','=',$lokasi)
                                        ->where('st_prdcd','=',substr($rec->rom_prdcd,0,6).'0')
                                        ->update([
                                            'st_avgcost' => $cosstk,
                                            'st_lastcost' => $cosbaik
                                        ]);
                                }
                            }
                        }

                        if(self::nvl($request->hitungSelisih,0) != 0){
                            $step = 26;

                            $c = oci_connect('SIMSMG', 'SIMSMG', '192.168.237.193:1521/SIMSMG');
                            $s = oci_parse($c, "BEGIN :ret := F_IGR_GET_NOMOR('".$_SESSION['kdigr']."','RST','Nomor Reset Kasir','R' ||  TO_CHAR(SYSDATE, 'yy'),5,TRUE); END;");
                            oci_bind_by_name($s, ':ret', $noreset, 32);
                            oci_execute($s);

                            $c = oci_connect('SIMSMG', 'SIMSMG', '192.168.237.193:1521/SIMSMG');
                            $s = oci_parse($c, "BEGIN :ret := F_IGR_GET_NOMOR('".$_SESSION['kdigr']."','SOS','Nomor Struk Beban Driver','SOS',5,TRUE); END;");
                            oci_bind_by_name($s, ':ret', $dokdriver, 32);
                            oci_execute($s);

                            $dokdriver = substr($dokdriver, 3,5);
                            $nilai = 0;
                            $ppn = 0;
                            $seqno = 0;

                            $recs = DB::select("SELECT tbtr_returomi.*,
                                       tbmaster_stock.st_avgcost,
                                       tbmaster_prodmast.prd_flagbkp1,
                                       tbmaster_prodmast.prd_flagbkp2,
                                       tbmaster_prodmast.prd_hrgjual,
                                       tbmaster_prodmast.prd_kodedivisi,
                                       tbmaster_prodmast.prd_kodedepartement,
                                       tbmaster_prodmast.prd_kodekategoribarang,
                                       tbmaster_prodmast.prd_deskripsipendek
                                  FROM tbtr_returomi, tbmaster_stock, tbmaster_prodmast
                                 WHERE rom_kodeigr = '".$_SESSION['kdigr']."'
                                   AND rom_nodokumen = '".$request->nodoc."'
                                   AND prd_kodeigr = rom_kodeigr
                                   AND prd_prdcd = rom_prdcd
                                   AND st_kodeigr = rom_kodeigr
                                   AND st_prdcd = SUBSTR(rom_prdcd, 1, 6) || '0'
                                   AND st_lokasi = '01'");

                            foreach($recs as $rec){
                                $step = 28;

                                if(self::nvl($rec->rom_qtyselisih, 0) != 0){
                                    $plu = DB::selectOne("SELECT prd_prdcd, prd_hrgjual
                                          FROM (SELECT   *
                                                    FROM tbmaster_prodmast
                                                   WHERE SUBSTR(prd_prdcd, 1, 6) = SUBSTR('".$rec->rom_prdcd."', 1, 6)
                                                     AND SUBSTR(prd_prdcd, 7, 1) <> '0'
                                                     AND NVL(prd_kodetag, '0') <> 'X'
                                                ORDER BY prd_prdcd)
                                         WHERE ROWNUM = 1");

                                    $plujual = $plu->prd_prdcd;
                                    $hrgprd = $plu->prd_hrgjual;

                                    $seqno++;
                                    $step = 29;

                                    if(self::nvl($rec->prd_flagbkp1, 'N') != 'Y' ||
                                        (self::nvl($rec->prd_flagbkp2, 'N') != 'P' ||
                                        self::nvl($rec->prd_flagbkp2, 'N') != 'G' ||
                                        self::nvl($rec->prd_flagbkp2, 'N') != 'W')
                                    )
                                        $nilai = $nilai + ($hrgprd * $rec->rom_qtyselisih);
                                    else{
                                        $nilai = $nilai + ($hrgprd * $rec->rom_qtyselisih / 1.1);
                                        $ppn = $ppn + (($hrgprd * $rec->rom_qtyselisih) - (($hrgprd * $rec->rom_qtyselisih) / 1.1));
                                    }

                                    $step = 30;

                                    DB::insert("INSERT INTO tbtr_jualdetail
                                        (trjd_kodeigr,
                                         trjd_transactionno,
                                         trjd_cashierstation,
                                         trjd_transactiondate,
                                         trjd_transactiontype,
                                         trjd_seqno,
                                         trjd_prdcd,
                                         trjd_unitprice,
                                         trjd_quantity,
                                         trjd_nominalamt,
                                         trjd_divisioncode,
                                         trjd_division,
                                         trjd_prd_deskripsipendek,
                                         trjd_flagtax1,
                                         trjd_flagtax2,
                                         trjd_baseprice,
                                         trjd_cus_kodemember,
                                         trjd_create_by,
                                         trjd_create_dt,
                                         trjd_discount,
                                         trjd_admfee,
                                         trjd_noinvoice1,
                                         trjd_noinvoice2
                                        )
                            VALUES      ('".$_SESSION['kdigr']."',
                                         '".$dokdriver."',
                                         '99',
                                         SYSDATE,
                                         'S',
                                         ".$seqno.",
                                         '".$plujual."',
                                         '".$hrgprd."',
                                         ".$rec->rom_qtyselisih.",
                                         (".$rec->rom_qtyselisih." * ".$hrgprd."),
                                         '".$rec->prd_kodedivisi."',
                                         '".$rec->prd_kodedepartement."' || '".$rec->prd_kodekategoribarang."',
                                         '".$rec->prd_deskripsipendek."',
                                         '".$rec->prd_flagbkp1."',
                                         '".$rec->prd_flagbkp2."',
                                         ".$rec->st_avgcost.",
                                         '199999',
                                         'SOS',
                                         SYSDATE,
                                         0,
                                         0,
                                         0,
                                         0
                                        )");
                                }
                            }

                            $temp = DB::table('tbtr_jualheader')
                                ->where('jh_kodeigr','=',$_SESSION['kdigr'])
                                ->where('jh_transactionno','=',$dokdriver)
                                ->where('jh_cashierstation','=','99')
                                ->whereRaw("trunc(jh_transactiondate) = trunc(sysdate)")
                                ->where('jh_cashierid','=','SOS')
                                ->where('jh_transactiontype','=','S')
                                ->first();

                            if(!$temp){
                                $step = 31;

                                DB::insert("INSERT INTO tbtr_jualheader
                                    (jh_kodeigr,
                                     jh_transactionno,
                                     jh_cashierstation,
                                     jh_transactiondate,
                                     jh_cashierid,
                                     jh_transactiontype,
                                     jh_transactionamt,
                                     jh_transactioncashamt,
                                     jh_cus_kodemember,
                                     jh_create_dt,
                                     jh_create_by,
                                     jh_kmmamt,
                                     jh_discountpct,
                                     jh_discountamt,
                                     jh_transactioncreditamt,
                                     jh_ccamt1,
                                     jh_ccamt2,
                                     jh_debitcardamt,
                                     jh_voucheramt,
                                     jh_voucherqty,
                                     jh_membershipfee,
                                     jh_cashadvance,
                                     jh_chargeamt,
                                     jh_voucherremainamt,
                                     jh_ccadmfee1,
                                     jh_ccadmfee2
                                    )
                        VALUES      ('".$_SESSION['kdigr']."',
                                     '".$dokdriver."',
                                     '99',
                                     SYSDATE,
                                     'SOS',
                                     'S',
                                     (".$nilai." + ".$ppn."),
                                     (".$nilai." + ".$ppn."),
                                     '199999',
                                     SYSDATE,
                                     '".$_SESSION['usid']."',
                                     0,
                                     0,
                                     0,
                                     0,
                                     0,
                                     0,
                                     0,
                                     0,
                                     0,
                                     0,
                                     0,
                                     0,
                                     0,
                                     0,
                                     0
                                    )");
                            }
                            else{
                                $step = 32;

                                DB::update("UPDATE tbtr_jualheader
                                       SET jh_transactionamt = jh_transactionamt +(".$nilai." + ".$ppn."),
                                           jh_transactioncashamt = jh_transactioncashamt +(".$nilai." + ".$ppn.")
                                     WHERE jh_kodeigr = '".$_SESSION['kdigr']."'
                                       AND jh_transactionno = '".$dokdriver."'
                                       AND jh_cashierstation = '99'
                                       AND TRUNC(jh_transactiondate) = TRUNC(SYSDATE)
                                       AND jh_cashierid = 'SOS'
                                       AND jh_transactiontype = 'S'");
                            }

                            $temp = DB::table('tbtr_jualsummary')
                                ->where('js_kodeigr','=',$_SESSION['kdigr'])
                                ->where('js_cashierid','=','SOS')
                                ->where('js_cashierstation','=','99')
                                ->whereRaw("TRUNC(js_transactiondate) = TRUNC(SYSDATE)")
                                ->first();

                            if(!$temp){
                                $step = 33;

                                DB::insert("INSERT INTO tbtr_jualsummary
                                    (js_kodeigr,
                                     js_cashierid,
                                     js_cashierstation,
                                     js_transactiondate,
                                     js_cashstartamt,
                                     js_totsalesamt,
                                     js_totcashsalesamt,
                                     js_resetamt,
                                     js_create_by,
                                     js_create_dt,
                                     js_totkmmamt,
                                     js_totcreditsalesamt,
                                     js_totcc1amt,
                                     js_totcc2amt,
                                     js_totdebitamt,
                                     js_totvoucherqty,
                                     js_totvoucheramt,
                                     js_totrefundamt,
                                     js_totcashrefundamt,
                                     js_totcreditrefundamt,
                                     js_totccrefundamt,
                                     js_freqcashdrawl,
                                     js_freqcanceltransaction,
                                     js_cashdrawalamt,
                                     js_cashdraweropencnt,
                                     js_totcashadvanceamt,
                                     js_totchargeamt,
                                     js_totremainvouchervalue
                                    )
                        VALUES      ('".$_SESSION['kdigr']."',
                                     'SOS',
                                     '99',
                                     SYSDATE,
                                     150000,
                                     (".$nilai." + ".$ppn."),
                                     (".$nilai." + ".$ppn."),
                                     150000,
                                     '".$_SESSION['usid']."',
                                     SYSDATE,
                                     0,
                                     0,
                                     0,
                                     0,
                                     0,
                                     0,
                                     0,
                                     0,
                                     0,
                                     0,
                                     0,
                                     0,
                                     0,
                                     0,
                                     0,
                                     0,
                                     0,
                                     0
                                    )");
                            }
                            else{
                                $step = 34;

                                DB::update("UPDATE tbtr_jualsummary
                                   SET js_totsalesamt = js_totsalesamt +(".$nilai." + ".$ppn."),
                                       js_totcashsalesamt = js_totcashsalesamt +(".$nilai." + ".$ppn.")
                                 WHERE js_kodeigr = '".$_SESSION['kdigr']."'
                                   AND js_cashierid = 'SOS'
                                   AND js_cashierstation = '99'
                                   AND TRUNC(js_transactiondate) = TRUNC(SYSDATE)");
                            }

                            $step = 35;

                            DB::table('tbtr_returomi')
                                ->where('rom_kodeigr','=',$_SESSION['kdigr'])
                                ->where('rom_nodokumen','=',$request->nodoc)
                                ->whereRaw("nvl(rom_qtyselisih,0) <> 0")
                                ->update([
                                    'rom_kodekasir' => 'SOS',
                                    'rom_staton' => '99',
                                    'rom_jenistransaksi' => $dokdriver,
                                    'rom_tgltransaksi' => DB::RAW("SYSDATE")
                                ]);
                        }
                    }

                    $rpretur = 0;
                    $ppnretur = 0;

                    $recs = DB::select("SELECT tbtr_returomi.*,
                               tbmaster_prodmast.prd_flagbkp1,
                               tbmaster_prodmast.prd_flagbkp2
                          FROM tbtr_returomi, tbmaster_prodmast
                         WHERE rom_kodeigr = '".$_SESSION['kdigr']."'
                           AND rom_nodokumen = '".$request->nodoc."'
                           AND rom_tgldokumen = TO_DATE('".$request->tgldoc."','dd/mm/yyyy')
                           AND prd_kodeigr = rom_kodeigr
                           AND prd_prdcd = rom_prdcd");

                    foreach($recs as $rec){
                        $step = 36;
                        $rpretur = $rpretur + ($rec->rom_qty * $rec->rom_hrg);

                        if(self::nvl($rec->prd_flagbkp1, 'N') == 'Y'){
                            if(
                                self::nvl($rec->prd_flagbkp2,'N') != 'P' ||
                                self::nvl($rec->prd_flagbkp2,'N') != 'G' ||
                                self::nvl($rec->prd_flagbkp2,'N') != 'W'
                            ){
                                $ppnretur = $ppnretur + round((($rec->rom_hrg - ($rec->rom_hrg / 1.1)) * $rec->rom_qty),0);
                            }
                        }

                        $cekplu = '2'.$rec->rom_prdcd;

                        $plujual = DB::selectOne("SELECT prd_prdcd
                              FROM (SELECT   *
                                        FROM tbmaster_prodmast
                                       WHERE SUBSTR(prd_prdcd, 1, 6) = SUBSTR('".$rec->rom_prdcd."', 1, 6)
                                         AND SUBSTR(prd_prdcd, 7, 1) <> '0'
                                         AND NVL(prd_kodetag, '0') <> 'X'
                                    ORDER BY prd_prdcd)
                             WHERE ROWNUM = 1")->prd_prdcd;

                        $step = 37;
                    }

                    $step = 371;

                    if($request->paramTypeRetur == 'M'){
                        $step = 372;

                        $temp = DB::table('tbmaster_piutang')
                            ->where('ptg_kodeigr','=',$_SESSION['kdigr'])
                            ->where('ptg_kodemember','=',$request->kodemember)
                            ->first();

                        if(!$temp){
                            $step = 38;

                            DB::insert("INSERT INTO tbmaster_piutang
                                            (ptg_kodeigr,
                                             ptg_kodemember,
                                             ptg_amtar,
                                             ptg_create_by,
                                             ptg_create_dt,
                                             ptg_amtpayment
                                            )
                                    VALUES ('".$_SESSION['kdigr']."',
                                             '".$request->kodemember."',
                                             ".$rpretur." * -1,
                                             '".$_SESSION['usid']."',
                                             SYSDATE,
                                             0
                                            )");
                        }
                        else{
                            $step = 39;

                            DB::update("UPDATE tbmaster_piutang
                               SET ptg_amtar = NVL(ptg_amtar, 0) - ".$rpretur.",
                                   ptg_modify_by = '".$_SESSION['usid']."',
                                   ptg_modify_dt = SYSDATE
                             WHERE ptg_kodeigr = '".$_SESSION['kdigr']."'
                             AND ptg_kodemember = '".$request->kodemember."'");
                        }

                        $temp = DB::table('tbtr_piutang')
                            ->where('trpt_kodeigr','=',$_SESSION['kdigr'])
                            ->where('trpt_type','=','D')
                            ->whereRaw("trunc(trpt_receivedate) = trunc(sysdate)")
                            ->where('trpt_cus_kodemember','=',$request->kodemember)
                            ->where('trpt_docno','=',$request->nodoc)
                            ->first();

                        if(!$temp){
                            $step = 40;

                            $top = DB::table('tbmaster_customer')
                                ->select('cus_top')
                                ->where('cus_kodemember','=',$request->kodemember)
                                ->first()->cus_top;

                            $step = 41;

                            DB::insert("INSERT INTO tbtr_piutang
                                (trpt_kodeigr,
                                 trpt_type,
                                 trpt_salesinvoicedate,
                                 trpt_cus_kodemember,
                                 trpt_cashierid,
                                 trpt_invoicetaxno,
                                 trpt_invoicetaxdate,
                                 trpt_docno,
                                 trpt_receivedate,
                                 trpt_salesvalue,
                                 trpt_netsales,
                                 trpt_ppntaxvalue,
                                 trpt_salesduedate,
                                 trpt_create_by,
                                 trpt_create_dt,
                                 trpt_sph_amount,
                                 trpt_paymentvalue,
                                 trpt_distfee,
                                 trpt_ppnfeevalue
                                )
                        VALUES ('".$_SESSION['kdigr']."',
                                 'D',
                                 TRUNC(SYSDATE),
                                 '".$request->kodemember."',
                                 'SOS',
                                 '".$request->nonrb."',
                                 to_date('".$request->tglnrb."','dd/mm/yyyy'),
                                 '".$request->nodoc."',
                                 SYSDATE,
                                 ".$rpretur.",
                                 ".$rpretur." - ".$ppnretur.",
                                 ".$ppnretur.",
                                 ".DB::RAW("SYSDATE + ".intval($top)).",
                                 '".$_SESSION['usid']."',
                                 SYSDATE,
                                 0,
                                 0,
                                 0,
                                 0
                                )");
                        }
                    }

                    $step = 42;

                    DB::table('tbtr_returomi')
                        ->where('rom_kodeigr','=',$_SESSION['kdigr'])
                        ->where('rom_nodokumen','=',$request-> nodoc)
                        ->update([
                            'rom_flag' => 'P',
                            'rom_recordid' => '2',
                            'rom_noreset' => $noreset
                        ]);
                }
                else{
                    $step = 43;

                    DB::table('tbtr_returomi')
                        ->where('rom_kodeigr','=',$_SESSION['kdigr'])
                        ->where('rom_nodokumen','=',$request->nodoc)
                        ->update([
                            'rom_flag' => '*'
                        ]);

                    $step = 44;

                    $noreset = DB::table('tbtr_returomi')
                        ->select('rom_noreset')
                        ->where('rom_kodeigr','=',$_SESSION['kdigr'])
                        ->where('rom_nodokumen','=',$request->nodoc)
                        ->first()->rom_noreset;
                }

                if($request->paramTypeRetur == 'M'){
                    $print[] = 'listing-manual';
                    $print[] = 'bpb-manual';
                }
                else{
                    $print[] = 'listing';
                    $print[] = 'bpb';
                }

                $recs = DB::table('tbtr_mstran_d')
                    ->where('mstd_kodeigr','=',$_SESSION['kdigr'])
                    ->where('mstd_nopo','=',$request->nodoc)
                    ->whereRaw("mstd_tglpo = to_date('".$request->tgldoc."','dd/mm/yyyy')")
                    ->where('mstd_nofaktur','=',$request->nonrb)
                    ->whereRaw("mstd_tglfaktur = to_date('".$request->tglnrb."','dd/mm/yyyy')")
                    ->get();

                foreach($recs as $rec){
                    $step = 45;

                    if($rec->mstd_flagdisc2 == 'T')
                        $lctkretur = true;
                    else if($rec->mstd_flagdisc2 == 'R')
                        $lctkrusak = true;
                }

                if($lctkretur)
                    $print[] = 'nota-barang-retur';

                if($lctkrusak)
                    $print[] = 'nota-barang-rusak';

                if(self::nvl($request->hitungSelisih,0) != 0){
                    $print[] = 'selisih';
                    $print[] = 'struk';
                    $print[] = 'reset';
                }
            }

            return response()->json([
                'message' => 'Proses berhasil!',
                'print' => $print,
                'noreset' => $noreset
            ], 200);
        }
        catch (QueryException $e){
            DB::rollBack();

            dd($e->getMessage());

            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function printBPB(Request $request){
        $nodoc = $request->nodoc;
        $tgldoc = $request->tgldoc;

        $perusahaan = DB::table("tbmaster_perusahaan")->first();

        $data = DB::select("SELECT rom_nodokumen, TRUNC(rom_tgldokumen) tgldokumen, rom_noreferensi,
    rom_prdcd, prd_deskripsipanjang, prd_unit||'/'||prd_frac kemasan, prd_kodetag, hgb_statusbarang,
    rom_member, rom_kodetoko, rom_qty, rom_qtymlj, rom_qtytlj, rom_hrg, rom_ttl,
    rom_avgcost, rom_qtyselisih, nvl(rom_qtymlj,0) * nvl(rom_avgcost,0) ttlcostlayak,
    nvl(rom_qtytlj,0) * nvl(rom_avgcost,0) ttlcosttdklyk, tko_namaomi, tko_kodecustomer
FROM TBTR_RETUROMI, TBMASTER_PRODMAST, TBMASTER_HARGABELI,TBMASTER_TOKOIGR
WHERE rom_kodeigr = '".$_SESSION['kdigr']."'
              and rom_nodokumen = '".$nodoc."'
              and rom_tgldokumen = to_date('".$tgldoc."','dd/mm/yyyy')
              and prd_kodeigr(+) = rom_kodeigr
              and prd_prdcd(+) = rom_prdcd
              and hgb_kodeigr(+) = rom_kodeigr
              and hgb_tipe = '2'
              and SUBSTR(hgb_prdcd,1,6) = SUBSTR(rom_prdcd,1,6)
              and tko_kodeigr(+) = rom_kodeigr
              and tko_kodeomi(+) = rom_kodetoko
ORDER BY rom_nodokumen, rom_prdcd");

//        dd($data);

        $dompdf = new PDF();

        $pdf = PDF::loadview('OMI.RETUR.retur-bpb-pdf',compact(['perusahaan','data','nodoc','tgldoc']));

        error_reporting(E_ALL ^ E_DEPRECATED);

        $pdf->output();
        $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);

        $canvas = $dompdf ->get_canvas();
        $canvas->page_text(757, 75.50, "{PAGE_NUM} dari {PAGE_COUNT}", null, 7, array(0, 0, 0));

        $dompdf = $pdf;

        return $dompdf->stream('Bukti Penerimaan Barang.pdf');
    }

    public function printNotaBarangRetur(Request $request){
        $nodoc = $request->nodoc;
        $tgldoc = $request->tgldoc;

        $perusahaan = DB::table("tbmaster_perusahaan")->first();

        $data = DB::select("select  rom_nodokumen, TRUNC(rom_tgldokumen) tgldokumen, rom_noreferensi,
                       rom_kodetoko, rom_member, tko_namaomi, prd_kodetag,
                       mstd_prdcd plu, prd_deskripsipanjang, prd_unit||'/'||mstd_frac kemasan,
                       mstd_nodoc, TO_CHAR(mstd_tgldoc,'dd/mm/yyyy') tgldoc, nvl(mstd_hrgsatuan,0) hrg_satuan,
                       nvl(mstd_qty,0) mstd_qty, mstd_frac,
                       floor(mstd_qty/mstd_frac) qty, mod(mstd_qty,mstd_frac) qtyk,
                       nvl(mstd_avgcost,0) avgcost, nvl(mstd_gross,0) subtotal
            from tbtr_returomi, tbtr_mstran_d, tbmaster_prodmast, tbmaster_tokoigr
            where rom_kodeigr = '".$_SESSION['kdigr']."'
                    and rom_nodokumen = '".$nodoc."'
                    and rom_tgldokumen = TO_DATE('".$tgldoc."','dd/mm/yyyy')
                    and mstd_kodeigr(+) = rom_kodeigr
                    and mstd_nopo(+) = rom_nodokumen
                    and mstd_nofaktur(+) = rom_noreferensi
                    and mstd_prdcd(+) = rom_prdcd
                    and mstd_flagdisc2 = 'T'
                    and prd_prdcd(+) = rom_prdcd
                    and prd_kodeigr(+) = rom_kodeigr
                    and tko_kodeigr = rom_kodeigr
                    and tko_kodeomi = rom_kodetoko
                    and tko_kodecustomer = rom_member
            order by rom_nodokumen, rom_prdcd
                ");

//        dd($data);

        $dompdf = new PDF();

        $tipe = 'RETUR';

        $pdf = PDF::loadview('OMI.RETUR.retur-nota-pdf',compact(['perusahaan','data','nodoc','tgldoc','tipe']));

        error_reporting(E_ALL ^ E_DEPRECATED);

        $pdf->output();
        $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);

        $canvas = $dompdf ->get_canvas();
        $canvas->page_text(507, 75.50, "{PAGE_NUM} dari {PAGE_COUNT}", null, 7, array(0, 0, 0));

        $dompdf = $pdf;

        return $dompdf->stream('Nota Barang Retur.pdf');
    }

    public function printNotaBarangRusak(Request $request){
        $nodoc = $request->nodoc;
        $tgldoc = $request->tgldoc;

        $perusahaan = DB::table("tbmaster_perusahaan")->first();

        $data = DB::select("select  rom_nodokumen, TO_CHAR(rom_tgldokumen,'dd/mm/yyyy') tgldokumen, rom_noreferensi,
                           rom_kodetoko, rom_member, tko_namaomi, prd_kodetag,
                           mstd_prdcd plu, prd_deskripsipanjang, prd_unit||'/'||mstd_frac kemasan,
                           mstd_nodoc, to_char(mstd_tgldoc,'dd/mm/yyyy') tgldoc, nvl(mstd_hrgsatuan,0) hrg_satuan,
                           nvl(mstd_qty,0) mstd_qty, mstd_frac,
                           floor(mstd_qty/mstd_frac) qty, mod(mstd_qty,mstd_frac) qtyk,
                           nvl(mstd_avgcost,0) avgcost, nvl(mstd_gross,0) subtotal,
                           prs_namaperusahaan, prs_namacabang
                from tbtr_returomi, tbtr_mstran_d, tbmaster_prodmast, tbmaster_tokoigr,
                        tbmaster_perusahaan
                where rom_kodeigr = '".$_SESSION['kdigr']."'
                        and rom_nodokumen = '".$nodoc."'
                        and rom_tgldokumen = TO_DATE('".$tgldoc."','dd/mm/yyyy')
                        and mstd_kodeigr(+) = rom_kodeigr
                        and mstd_nopo(+) = rom_nodokumen
                        and mstd_nofaktur(+) = rom_noreferensi
                        and mstd_prdcd(+) = rom_prdcd
                        and mstd_flagdisc2 = 'R'
                        and prd_prdcd(+) = rom_prdcd
                        and prd_kodeigr(+) = rom_kodeigr
                        and tko_kodeigr = rom_kodeigr
                        and tko_kodeomi = rom_kodetoko
                        and tko_kodecustomer = rom_member
                        and prs_kodeigr = rom_kodeigr
                order by rom_nodokumen asc, rom_prdcd");

//        dd($data);

        $tipe = 'RUSAK';

        $dompdf = new PDF();

        $pdf = PDF::loadview('OMI.RETUR.retur-nota-pdf',compact(['perusahaan','data','nodoc','tgldoc','tipe']));

        error_reporting(E_ALL ^ E_DEPRECATED);

        $pdf->output();
        $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);

        $canvas = $dompdf->get_canvas();
        $canvas->page_text(507, 75.50, "{PAGE_NUM} dari {PAGE_COUNT}", null, 7, array(0, 0, 0));

        $dompdf = $pdf;

        return $dompdf->stream('Nota Barang Rusak.pdf');
    }

    public function printListing(Request $request){
        $nodoc = $request->nodoc;
        $tgldoc = $request->tgldoc;

        $perusahaan = DB::table("tbmaster_perusahaan")->first();

        $data = DB::select("SELECT rom_noreferensi, to_char(rom_tglreferensi, 'dd/mm/yyyy') rom_tglreferensi, rom_kodetoko,
                prc_pluomi, prd_deskripsipendek, prd_unit||'/'||prd_frac kemasan, rom_qty, rom_ttl, tko_namaomi,
                CASE WHEN prd_flagbkp2 = 'Y' THEN
                       rom_ttl / 1.1
                ELSE
                       rom_ttl
                END nilai
            FROM TBTR_RETUROMI, TBMASTER_PRODMAST, TBMASTER_PRODCRM,
                       TBMASTER_TOKOIGR
            WHERE rom_kodeigr = '".$_SESSION['kdigr']."'
            and rom_nodokumen = '".$nodoc."'
            and rom_tgldokumen = TO_DATE('".$tgldoc."','dd/mm/yyyy')
            and prc_kodeigr = rom_kodeigr
            and prc_pluigr = rom_prdcd
            and prc_group = 'O'
            and prd_kodeigr = rom_kodeigr
            and prd_prdcd = rom_prdcd
            and tko_kodeigr = rom_kodeigr
            and tko_kodesbu = 'O'
            and tko_kodeomi = rom_kodetoko
            ORDER BY rom_nodokumen, rom_tgldokumen, prc_pluomi");

//        dd($data);

        $kodetoko = count($data) > 0 ? $data[0]->rom_kodetoko : '';
        $namatoko = count($data) > 0 ? $data[0]->tko_namaomi : '';

        $dompdf = new PDF();

        $pdf = PDF::loadview('OMI.RETUR.retur-listing-pdf',compact(['perusahaan','data','nodoc','tgldoc','kodetoko','namatoko']));

        error_reporting(E_ALL ^ E_DEPRECATED);

        $pdf->output();
        $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);

        $canvas = $dompdf ->get_canvas();
        $canvas->page_text(507, 75.50, "{PAGE_NUM} dari {PAGE_COUNT}", null, 7, array(0, 0, 0));

        $dompdf = $pdf;

        return $dompdf->stream('Listing Bukti Barang Retur Dari OMI via DCP.pdf');
    }

    public function printListingManual(Request $request){
        $nodoc = $request->nodoc;
        $tgldoc = $request->tgldoc;

        $perusahaan = DB::table("tbmaster_perusahaan")->first();

        $data = DB::select("SELECT rom_nopo, rom_nodokumen, TRUNC(rom_tgldokumen) tgldok, rom_noreferensi, rom_tglreferensi,
                rom_member, to_char(rom_tgljatuhtempo,'dd/mm/yyyy') rom_tgljatuhtempo, rom_prdcd, prd_deskripsipanjang, prd_unit||'/'||prd_frac kemasan,
                rom_qty, rom_qtyrealisasi, rom_avgcost, rom_ttlcost, cus_namamember, cus_npwp
            FROM TBTR_RETUROMI, TBMASTER_PRODMAST, TBMASTER_CUSTOMER
            WHERE rom_kodeigr = '22'
            and rom_nodokumen = '".$request->nodoc."'
            and rom_tgldokumen = to_date('".$request->tgldoc."','dd/mm/yyyy')
            and prd_kodeigr = rom_kodeigr
            and prd_prdcd = rom_prdcd
            and cus_kodeigr = rom_kodeigr
            and cus_kodemember = rom_member
            ORDER BY rom_nodokumen, rom_tgldokumen, rom_member, rom_prdcd");

//        dd($data);

        $dompdf = new PDF();

        $pdf = PDF::loadview('OMI.RETUR.retur-listing-manual-pdf',compact(['perusahaan','data','nodoc','tgldoc']));

        error_reporting(E_ALL ^ E_DEPRECATED);

        $pdf->output();
        $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);

        $canvas = $dompdf ->get_canvas();
//        $canvas->page_text(505, 75.50, "{PAGE_NUM} dari {PAGE_COUNT}", null, 7, array(0, 0, 0));

        $dompdf = $pdf;

        return $dompdf->stream('Bukti Penerimaan Barang.pdf');
    }

    public function printBPBManual(Request $request){
        $nodoc = $request->nodoc;
        $tgldoc = $request->tgldoc;

        $perusahaan = DB::table("tbmaster_perusahaan")->first();

        $data = DB::select("SELECT rom_nodokumen, TRUNC(rom_tgldokumen) tgldok, rom_noreferensi, rom_tglreferensi, rom_nopo,
                rom_member, rom_tgljatuhtempo, rom_prdcd, prd_deskripsipanjang, prd_unit||'/'||prd_frac kemasan,
                rom_flagbkp, rom_flagbkp2, rom_qty, rom_qtyrealisasi, rom_hrg, rom_ttl,
                cus_namamember, cus_alamatmember1|| ' ' || cus_alamatmember2 alamat,
                CASE WHEN nvl(rom_flagbkp,'N') = 'Y' THEN
                       hso_hrgsatuan1 / 1.1
                ELSE
                       hso_hrgsatuan1 / 1
                END hrgsat1,
                CASE WHEN nvl(rom_flagbkp,'N') = 'Y' THEN
                       hso_hrgsatuan2 / 1.1
                ELSE
                       hso_hrgsatuan2 / 1
                END hrgsat2,
                CASE WHEN nvl(rom_flagbkp,'N') = 'Y' THEN
                       hso_hrgsatuan3 / 1.1
                ELSE
                       hso_hrgsatuan3 / 1
                END hrgsat3,
                hso_qty1, hso_qty2, hso_qty3,
                CASE WHEN prd_unit = 'KG' THEN
                       rom_hrg / 1000
                ELSE
                       rom_hrg
                END hrgsat
            FROM TBTR_RETUROMI, TBMASTER_PRODMAST, TBMASTER_CUSTOMER, TBHISTORY_HARGASTRUKOMI
            WHERE rom_kodeigr = '".$_SESSION['kdigr']."'
            and rom_nodokumen = '".$nodoc."'
            and rom_tgldokumen = TO_DATE('".$tgldoc."','dd/mm/yyyy')
            and rom_statusdata = '1'
            and prd_kodeigr = rom_kodeigr
            and prd_prdcd = rom_prdcd
            and cus_kodeigr = rom_kodeigr
            and cus_kodemember = rom_member
            and hso_kodeigr = rom_kodeigr
            and hso_kodemember = rom_member
            and SUBSTR(hso_prdcd,1,6) = SUBSTR(rom_prdcd,1,6)
            ORDER BY rom_nodokumen, rom_tgldokumen, rom_member, rom_prdcd");

//        dd($data);

        $dompdf = new PDF();

        $pdf = PDF::loadview('OMI.RETUR.retur-bpb-manual-pdf',compact(['perusahaan','data','nodoc','tgldoc']));

        error_reporting(E_ALL ^ E_DEPRECATED);

        $pdf->output();
        $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);

        $canvas = $dompdf ->get_canvas();
//        $canvas->page_text(505, 75.50, "{PAGE_NUM} dari {PAGE_COUNT}", null, 7, array(0, 0, 0));

        $dompdf = $pdf;

        return $dompdf->stream('Bukti Penerimaan Barang.pdf');
    }

    public function printSelisih(Request $request){
        $nodoc = $request->nodoc;
        $tgldoc = $request->tgldoc;

        $perusahaan = DB::table("tbmaster_perusahaan")->first();

        $data = DB::select("SELECT rom_nodokumen, TO_CHAR(rom_tgldokumen, 'dd/mm/yyyy') tgldokumen, rom_noreferensi, TO_CHAR(rom_tglreferensi, 'dd/mm/yyyy') rom_tglreferensi,
                rom_prdcd, prd_deskripsipanjang, prd_unit||'/'||prd_frac kemasan, prd_prdcd, prd_hrgjual,
                rom_member, rom_qty, rom_qtyrealisasi, rom_qtyselisih, rom_hrg, rom_ttl, cus_namamember
            FROM TBTR_RETUROMI, TBMASTER_PRODMAST, TBMASTER_CUSTOMER
            WHERE rom_kodeigr = '".$_SESSION['kdigr']."'
                          and rom_nodokumen = '".$nodoc."'
                          and rom_tgldokumen = to_date('".$request->tgldoc."','dd/mm/yyyy')
                          and prd_kodeigr = rom_kodeigr
                          and prd_prdcd = rom_prdcd
                          and cus_kodeigr = rom_kodeigr
                          and nvl(cus_recordid,'9') <> '1'
                          and cus_kodemember = rom_member
            ORDER BY rom_nodokumen, rom_tgldokumen, rom_prdcd");

//        dd($data);

        $dompdf = new PDF();

        $pdf = PDF::loadview('OMI.RETUR.retur-selisih-pdf',compact(['perusahaan','data','nodoc','tgldoc']));

        error_reporting(E_ALL ^ E_DEPRECATED);

        $pdf->output();
        $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);

        $canvas = $dompdf ->get_canvas();
        $canvas->page_text(507, 75.50, "{PAGE_NUM} dari {PAGE_COUNT}", null, 7, array(0, 0, 0));

        $dompdf = $pdf;

        return $dompdf->stream('Bukti Penerimaan Barang.pdf');
    }

    public function printStruk(Request $request){
        $nodoc = $request->nodoc;
        $tgldoc = $request->tgldoc;

        $perusahaan = DB::table("tbmaster_perusahaan")->first();

        $data = DB::select("SELECT DISTINCT rom_nodokumen, TO_CHAR(rom_tgldokumen, 'dd/mm/yyyy') tgldokumen, rom_noreferensi, TO_CHAR(rom_tglreferensi,'dd/mm/yyyy') rom_tglreferensi,
                rom_prdcd, prd_deskripsipanjang, prd_deskripsipendek, prd_unit||'/'||prd_frac kemasan, cus_kodemember,
                cus_namamember,  rom_namadrive, rom_kodekasir, rom_station, rom_jenistransaksi, rom_qty, rom_qtyselisih,
                rom_hrg, rom_ttl, trjd_discount, prd_prdcd, rom_flagbkp, rom_flagbkp2,
                CASE WHEN nvl(rom_flagbkp,'N') <> 'Y' OR nvl(rom_flagbkp2,'N') IN('P','G','W') THEN
                       rom_ttl
                ELSE
                       rom_ttl / 1.1
                END Total,
                CASE WHEN nvl(rom_flagbkp,'N') <> 'Y' OR nvl(rom_flagbkp2,'N') IN('P','G','W') THEN
                       0
                ELSE
                       rom_ttl - (rom_ttl / 1.1)
                END Ppn
            FROM TBTR_RETUROMI, TBMASTER_PRODMAST, TBTR_JUALDETAIL, TBMASTER_CUSTOMER
            WHERE rom_kodeigr = '".$_SESSION['kdigr']."'
            and rom_nodokumen = '".$nodoc."'
            and rom_tgldokumen = TO_DATE('".$tgldoc."','dd/mm/yyyy')
            and prd_kodeigr(+) = rom_kodeigr
            and prd_prdcd(+) = rom_prdcd
            and cus_kodeigr = rom_kodeigr
            and cus_kodemember = '199999'
            and trjd_kodeigr = rom_kodeigr
            and trjd_transactionno = rom_jenistransaksi
            and TRUNC(trjd_transactiondate) = TRUNC(rom_tgldokumen)
            and SUBSTR(trjd_prdcd,1,6) = SUBSTR(rom_prdcd,1,6)
            ORDER BY rom_nodokumen, rom_prdcd");

        foreach($data as $d){
            $temp = DB::table('tbmaster_prodmast')
                ->select('prd_prdcd','prd_hrgjual')
                ->whereRaw("substr(prd_prdcd,1,6) = substr('".$d->rom_prdcd."',1,6)")
                ->whereRaw("substr(prd_prdcd,7,1) <> '1'")
                ->first();

            $d->cp_plu = $temp->prd_prdcd;
            $d->cp_hsat = $temp->prd_hrgjual;
            $d->cp_total = $d->rom_qtyselisih * $d->cp_hsat - $d->trjd_discount;

            if(self::nvl($d->rom_flagbkp, 'N') != 'Y' || in_array(self::nvl($d->rom_flagbkp2,'N'), ['P','G','W'])){
                $d->cp_penjualan = $d->cp_total;
                $d->cp_ppn = 0;
            }
            else{
                $d->cp_penjualan = $d->cp_total / 1.1;
                $d->cp_ppn = $d->cp_total - ($d->cp_total / 1.1);
            }
        }

//        dd($data);

        $dompdf = new PDF();

        $pdf = PDF::loadview('OMI.RETUR.retur-struk-pdf',compact(['perusahaan','data','nodoc','tgldoc']));

        error_reporting(E_ALL ^ E_DEPRECATED);

        $pdf->output();
        $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);

        $canvas = $dompdf ->get_canvas();
//        $canvas->page_text(507, 75.50, "{PAGE_NUM} dari {PAGE_COUNT}", null, 7, array(0, 0, 0));

        $dompdf = $pdf;

        return $dompdf->stream('Bukti Penerimaan Barang.pdf');
    }

    public function printReset(Request $request){
        $noreset = $request->noreset;
        $tgldoc = $request->tgldoc;

        $perusahaan = DB::table("tbmaster_perusahaan")->first();

        $data = DB::select("SELECT rom_kodeigr, tgldoc, rom_kodekasir, rom_station, rom_jenistransaksi,
                  rom_noreset, tanggal, jam, js_create_by, js_totcreditsalesamt, js_totsalesamt,
                  SUM(item) notrx, SUM(rom_ttlnilai) penjualan
            FROM(
             SELECT rom_kodeigr, TRUNC(rom_tgltransaksi) tgldoc, rom_kodekasir, rom_station,
                     rom_jenistransaksi, rom_noreset, rom_ttlnilai, TO_CHAR(js_create_dt,'dd/mm/yyyy') tanggal,
                     TO_CHAR(js_create_dt,'hh24:mi:ss') jam, js_create_by, js_totcreditsalesamt,
                     js_totsalesamt, 1 item
             FROM TBTR_JUALSUMMARY, TBTR_RETUROMI
             WHERE rom_kodeigr = '".$_SESSION['kdigr']."'
             AND rom_noreset = '".$noreset."'
             AND rom_tgltransaksi = TO_DATE('".$tgldoc."','dd/mm/yyyy')
             AND rom_qtyselisih <> 0
             AND js_kodeigr = rom_kodeigr
             AND TRUNC(js_transactiondate) = TRUNC(rom_tgltransaksi)
             AND js_cashierid = rom_kodekasir
             AND js_cashierstation = rom_station)
             GROUP BY rom_kodeigr, tgldoc, rom_kodekasir, rom_station, rom_jenistransaksi,
             rom_noreset, tanggal, jam, js_create_by, js_totcreditsalesamt, js_totsalesamt");

//        dd($data);

        $dompdf = new PDF();

        $pdf = PDF::loadview('OMI.RETUR.retur-reset-pdf',compact(['perusahaan','data','noreset','tgldoc']));

        error_reporting(E_ALL ^ E_DEPRECATED);

        $pdf->output();
        $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);

        $canvas = $dompdf ->get_canvas();
        $canvas->page_text(507, 75.50, "{PAGE_NUM} dari {PAGE_COUNT}", null, 7, array(0, 0, 0));

        $dompdf = $pdf;

        return $dompdf->stream('Bukti Penerimaan Barang.pdf');
    }

    public function createFakturCheck(Request $request){
        try{
            $paramPKP = $this->checkPKP($request->kodemember);
            $paramVB = $request->paramVB;

            if($paramPKP != 'Y'){
                return response()->json([
                    'message' => 'Member '.$request->kodemember.' bukan member PKP!'
                ], 500);
            }
            else{
                if($paramVB != 'Y'){
                    return response()->json([
                        'message' => 'Toko OMI bukan VB!'
                    ], 500);
                }
                else{
                    return response()->json([
                        'message' => 'OK'
                    ], 200);
                }
            }
        }
        catch(QueryException $e){

        }
    }

    public function createFaktur(Request $request){
        $adaisi = false;
        $adadoc = false;

        $fname = '';
        $step = 0;
        $seq = 0;
        $v_file_counter = 0;

        $seq++;

        $fname = 'RK_'.$request->kodetoko.'_'.date_format(Carbon::now(),'Y-m-d').'_'.substr('00'.$seq, -2).'.csv';

        $data = DB::select("SELECT   RK, NPWP, NAMA, KD_JENIS_TRANSAKSI, FG_PENGGANTI, NOMOR_FAKTUR, TANGGAL_FAKTUR,
                          NOMOR_DOKUMEN_RETUR, TANGGAL_RETUR, MASA_PAJAK_RETUR, TAHUN_PAJAK_RETUR,
                          ROUND (SUM (NILAI_RETUR_DPP)) NILAI_RETUR_DPP,
                          ROUND (SUM (NILAI_RETUR_PPN)) NILAI_RETUR_PPN,
                          ROUND (SUM (NILAI_RETUR_PPNBM)) NILAI_RETUR_PPNBM
                     FROM (SELECT   'RK' RK, REPLACE (REPLACE (CUS_NPWP, '.', ''), '-', '') NPWP,
                                    CUS_NAMAMEMBER NAMA, '01' KD_JENIS_TRANSAKSI, '0' FG_PENGGANTI,
                                    SUBSTR (REPLACE (REPLACE (NOSERI, '-', ''), '.', ''),
                                            4,
                                            13
                                           ) NOMOR_FAKTUR,
                                    TO_CHAR (RPJ_REFERENSITGLFP, 'dd/MM/yyyy') TANGGAL_FAKTUR,
                                       ROM_KODETOKO
                                    || '.'
                                    || TO_CHAR (RPJ_TGLFP, 'yy')
                                    || '.'
                                    || LPAD (RPJ_NOFP1, 7, 0) NOMOR_DOKUMEN_RETUR,
                                    TO_CHAR (ROM_TGLREFERENSI, 'dd/MM/yyyy') TANGGAL_RETUR,
                                    TO_NUMBER (TO_CHAR (ROM_TGLREFERENSI, 'MM')) MASA_PAJAK_RETUR,
                                    TO_NUMBER (TO_CHAR (ROM_TGLREFERENSI, 'yyyy')) TAHUN_PAJAK_RETUR,
                                    (RPJ_NILAI / 1.1) NILAI_RETUR_DPP,
                                    ((RPJ_NILAI / 1.1) * 0.1) NILAI_RETUR_PPN, 0 NILAI_RETUR_PPNBM
                               FROM TBTR_RETUROMI,
                                    TBTR_RETUROMI_PAJAK,
                                    TBMASTER_CUSTOMER,
                                    (SELECT DISTINCT SUBSTR (FKT_NOSERI, 1, 19) NOSERI, FKT_KODEMEMBER,
                                                     TO_NUMBER
                                                         (SUBSTR (REPLACE (REPLACE (FKT_NOSERI, '-', ''),
                                                                           '.',
                                                                           ''
                                                                          ),
                                                                  4,
                                                                  13
                                                                 )
                                                         ) FKT_NOSERI
                                                FROM TBMASTER_FAKTUR)
                              WHERE ROM_KODEIGR = '".$_SESSION['kdigr']."'
                                AND ROM_NODOKUMEN = '".$request->nodoc."'
                                AND NVL(ROM_FLAGBKP, 'N') = 'Y'
                                AND ROM_TGLDOKUMEN = TO_DATE('".$request->tgldoc."','dd/mm/yyyy')
                                AND RPJ_NODOKUMEN = ROM_NODOKUMEN
                                AND TRUNC (RPJ_TGLDOKUMEN) = TRUNC (ROM_TGLDOKUMEN)
                                AND RPJ_PRDCD = ROM_PRDCD
                                AND CUS_KODEIGR = ROM_KODEIGR
                                AND CUS_KODEMEMBER = ROM_MEMBER
                                AND '".$request->kodemember."' = FKT_KODEMEMBER(+)
                                AND RPJ_REFERENSIFP = FKT_NOSERI(+)
                           ORDER BY ROM_NODOKUMEN, ROM_PRDCD)
                    GROUP BY RK,
                          NPWP,
                          NAMA,
                          KD_JENIS_TRANSAKSI,
                          FG_PENGGANTI,
                          NOMOR_FAKTUR,
                          TANGGAL_FAKTUR,
                          NOMOR_DOKUMEN_RETUR,
                          TANGGAL_RETUR,
                          MASA_PAJAK_RETUR,
                          TAHUN_PAJAK_RETUR");

//                    dd($data);

        $columnHeader = [
            'RK',
            'NPWP',
            'NAMA',
            'KD_JENIS_TRANSAKSI',
            'FG_PENGGANTI',
            'NOMOR_FAKTUR',
            'TANGGAL_FAKTUR',
            'IS_CREDITABLE',
            'NOMOR_DOKUMEN_RETUR',
            'TANGGAL_RETUR',
            'MASA_PAJAK_RETUR',
            'TAHUN_PAJAK_RETUR',
            'NILAI_RETUR_DPP',
            'NILAI_RETUR_PPN',
            'NILAI_RETUR_PPNBM',
        ];

        $rows = collect($data)->map(function ($x) {
            return (array)$x;
        })->toArray();

        $headers = [
            "Content-type" => "text/csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];
        $file = fopen($fname, 'w');
        fputcsv($file, $columnHeader, '|');
        foreach ($rows as $row) {
            fputcsv($file, $row, '|');
        }
        fclose($file);
        return response()->download($fname, $fname, $headers)->deleteFileAfterSend(true);
    }

    public static function nvl($value, $default){
        if($value == null || $value == '')
            return $default;
        else return $value;
    }
}
