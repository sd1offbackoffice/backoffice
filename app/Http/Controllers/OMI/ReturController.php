<?php

namespace App\Http\Controllers\OMI;

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

        return view('OMI.retur')->with(compact(
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
            ->where('cus_kodemember','=',$kodemember)
            ->whereRaw("NVL(cus_flagpkp,'N') = 'Y'")
            ->first();

        if(!$temp){
            return 'Y';
        }
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
                    $join->on('hso_prdcd','=','rom_prdcd');
                    $join->on('hso_kodeigr','=','rom_kodeigr');
                })
                ->selectRaw("rom_prdcd, rom_hrg, rom_ttl, rom_qty, rom_qtyrealisasi, rom_qtyselisih,
                rom_qtymlj, rom_qtytlj, rom_noreferensi, to_char(rom_tglreferensi,'dd/mm/yyyy') rom_tglreferensi,
                 rom_member, rom_kodetoko, rom_statusdata, prd_deskripsipanjang, rom_referensistruk, rom_namadrive,
                 rom_recordid, hso_tgldokumen1, hso_tgldokumen2, hso_tgldokumen3, hso_qty1, hso_qty2, hso_qty3,
                 hso_hrgsatuan1, hso_hrgsatuan2, hso_hrgsatuan3, rom_avgcost, rom_flagbkp, rom_flagbkp2")
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

        $data = DB::selectOne("SELECT prd_prdcd, prd_deskripsipanjang, prd_flagbkp1, prd_flagbkp2, st_avgcost
            FROM TBMASTER_PRODMAST, TBMASTER_STOCK
            WHERE prd_kodeigr = '".$_SESSION['kdigr']."'
            AND prd_prdcd = '".$prdcd."'
            AND st_kodeigr = prd_kodeigr
            AND st_prdcd = SUBSTR ('".$prdcd."', 1, 6) || '0'
            AND st_lokasi = '01'");

        return response()->json($data, 200);
    }

    public function saveData(Request $request){
        DB::beginTransaction();

        $temp = DB::table('tbtr_returomi')
            ->select('rom_prdcd','rom_create_by','rom_create_dt')
            ->where('rom_kodeigr','=',$_SESSION['kdigr'])
            ->where('rom_nodokumen','=',$request->nodokumen)
            ->get();

        DB::table('tbtr_returomi')
            ->where('rom_kodeigr','=',$_SESSION['kdigr'])
            ->where('rom_nodokumen','=',$request->nodokumen)
            ->delete();

        try{
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
                 WHERE ROWNUM = 1");

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
}
