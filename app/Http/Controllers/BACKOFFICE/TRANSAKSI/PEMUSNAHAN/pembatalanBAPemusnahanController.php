<?php

namespace App\Http\Controllers\BACKOFFICE\TRANSAKSI\PEMUSNAHAN;

use App\AllModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class pembatalanBAPemusnahanController extends Controller
{
    public function index(){
        $noDoc = DB::table('tbtr_mstran_d')->whereNull(['mstd_recordid'])->whereRaw("mstd_nodoc like '8%'")->orderByDesc('mstd_nodoc')->distinct()->limit(100)->get(['mstd_nodoc', 'mstd_tgldoc'])->toArray();

        return view('BACKOFFICE/TRANSAKSI/PEMUSNAHAN.pembatalanBAPemusnahan', compact('noDoc'));
    }

    public function searchDocument(Request $request){
        $search = $request->search;

        $noDoc= DB::table('tbtr_mstran_d')->whereNull(['mstd_recordid'])->whereRaw("mstd_nodoc like '8%$search%'")->orderByDesc('mstd_nodoc')->distinct()->limit(100)->get(['mstd_nodoc', 'mstd_tgldoc'])->toArray();

        return response()->json($noDoc);
    }

    public function getDetailDocument(Request $request){
        $noDoc  = $request->noDoc;

        $detail = DB::table('tbtr_mstran_d')
            ->leftJoin('tbmaster_prodmast', 'mstd_prdcd', 'prd_prdcd')
            ->where('mstd_nodoc', $noDoc)
            ->whereNull(['mstd_recordid'])
            ->get()->toArray();

        if ($detail) {
            return response()->json(['kode' => 1, 'data' => $detail]);
        } else {
            return response()->json(['kode' => 0, 'data' => 'Data tidak ada!!']);
        }

    }

    public function deleteDocument(Request $request){
        $doc    = $request->doc;
        $kodeigr= $_SESSION['kdigr'];
        $userid = $_SESSION['usid'];
        $model  = new AllModel();
        $date   = $model->getDate();
        $dateTime = $model->getDateTime();

//        ------------- Cek apakah sudah closing atau belum
        $tgltran = DB::select("SELECT to_char(msth_tgldoc,'YYYYMM') as data
                    FROM tbtr_mstran_h
                    WHERE msth_nodoc= '$doc'
                    AND msth_kodeigr = '$kodeigr'
                    AND msth_typetrn = 'F'
                    AND NVL (msth_recordid, '0') <> '1'");

        $periode = DB::select("SELECT prs_tahunberjalan || prs_bulanberjalan as data FROM tbmaster_perusahaan");

        if ($tgltran && $periode){
            if ($tgltran[0]->data != $periode[0]->data){
                return response()->json(['kode' => 0, 'msg' => "Transaksi tidak bisa dibatalkan, karena sudah Closing/Month End"]);
            }
        } else {
            return response()->json(['kode' => 0, 'msg' => "Data tidak ada"]);
        }

//        ------------- Cek apakah akan dilakukan lopping atau tidak
        $detail = DB::table('tbtr_mstran_d')
            ->leftJoin('tbmaster_prodmast', 'mstd_prdcd', 'prd_prdcd')
            ->where('mstd_nodoc', $doc)
            ->whereNull(['mstd_recordid'])
            ->first();

        if (!$detail){
            return response()->json(['kode' => 0, 'msg' => "Data tidak ada2"]);
        }

        $datas   = DB::select("SELECT mstd_prdcd, mstd_nodoc, mstd_tgldoc,
                                           prd_deskripsipanjang barang,
                                           mstd_unit || '/' || mstd_frac satuan,
                                           mstd_flagdisc1 fdisc1, mstd_hrgsatuan price,
                                           mstd_frac frac, mstd_unit unit,
                                           mstd_kodedivisi div, mstd_kodedepartement,
                                           mstd_kodekategoribrg kat,
                                           FLOOR (mstd_qty / mstd_frac) qty,
                                           MOD (mstd_qty, mstd_frac) qtyk,
                                           mstd_hrgsatuan, mstd_gross, prd_avgcost acost
                                      FROM tbtr_mstran_d, tbmaster_prodmast
                                     WHERE mstd_nodoc = '$doc'
                                       AND mstd_kodeigr = '$kodeigr'
                                       AND mstd_typetrn = 'F'
                                       AND NVL (mstd_recordid, '0') <> '1'
                                       AND prd_prdcd = mstd_prdcd
                                       AND prd_kodeigr = mstd_kodeigr");

        foreach ($datas as $data){
            $temp   = DB::select("SELECT NVL (COUNT (1), 0) as nvl
                                         FROM tbmaster_stock
                                        WHERE st_prdcd = SUBSTR ('$data->mstd_prdcd', 1, 6) || '0'
                                          AND st_lokasi = '03'
                                          AND st_kodeigr = '$kodeigr'");

            if ($temp[0]->nvl == 0){
                DB::table('tbmaster_stock')->insert(['st_prdcd' => $data->mstd_prdcd, 'st_lokasi' => '03']);
            }

            $temp   = DB::select("SELECT NVL (COUNT (1), 0) as nvl
                                         FROM tbtr_hapusplu
                                        WHERE del_nodokumen = '$doc'
                                          AND del_prdcd = '$data->mstd_prdcd'
                                          AND del_rtype = 'F'");

            $temp2  = DB::select("SELECT st_avgcost, st_saldoakhir, st_trfout
                                         FROM tbmaster_stock
                                        WHERE st_prdcd = '$data->mstd_prdcd'
                                          AND st_lokasi = '03'
                                          AND st_kodeigr = '$kodeigr'");

            $temp   = $temp[0]->nvl;
            $lcost  = $temp2[0]->st_avgcost;
            $qty    = $temp2[0]->st_saldoakhir;

            if ($temp == 0){
                DB::table('tbtr_hapusplu')->insert([
                    'del_kodeigr' => $kodeigr, 'del_rtype' => 'F', 'del_nodokumen' => $doc, 'del_tgldokumen' => $data->mstd_tgldoc, 'del_prdcd' => $data->mstd_prdcd,
                    'del_avgcostnew' => $lcost, 'del_stokqtyold' => $qty, 'del_create_dt' => $date, 'del_create_by' => $userid
                ]);
            }

            $nqtt   = abs(($data->qty * $data->frac) + $data->qtyk);
            $ncost  = ($data->unit =='KG') ? $data->price / 1 : $data->price / $data->frac;
            $nilai  = ($qty >= 0) ? (($qty * $lcost) + ($ncost * $nqtt)) / ($qty + $nqtt) : $ncost;

            $tempSaldoAKhir = (!$temp2[0]->st_saldoakhir) ? 0 : $temp2[0]->st_saldoakhir;
            $tempStTrfout   = (!$temp2[0]->st_trfout) ? 0 : $temp2[0]->st_trfout;

            DB::table('tbmaster_stock')
                ->where('st_prdcd', $data->mstd_prdcd)->where('st_lokasi', '03')->where('st_kodeigr', $kodeigr)
                ->update(['st_saldoakhir' => ($tempSaldoAKhir + ($data->qty * $data->frac + $data->qtyk)), 'st_avgcost' => $nilai, 'st_trfout' => ($tempStTrfout - ($data->qty * $data->frac + $data->qtyk)),
                    'st_modify_by' => $userid, 'st_modify_dt' => $date]);

            DB::table('tbhistory_cost')->insert([
                'hcs_kodeigr' => $kodeigr, 'hcs_typetrn' => "F", 'hcs_lokasi' => '03', 'hcs_prdcd' => $data->mstd_prdcd, 'hcs_tglbpb' => $data->mstd_tgldoc,
                'hcs_nodocbpb' => $data->mstd_nodoc, 'hcs_qtybaru' => $nqtt, 'hcs_qtylama' => $qty, 'hcs_avglama' => $lcost, 'hcs_avgbaru' => $nilai,
                'hcs_lastqty' => ($qty + $nqtt), 'hcs_create_by' => $userid, 'hcs_create_dt' => $dateTime
            ]);
        }


//        --------------------- Update tbTr_MSTRAN_H [ MSTH_RECORDID = '1'
        DB::table('tbtr_mstran_h')
            ->where('msth_nodoc', $doc)->where('msth_kodeigr', $kodeigr)->where('msth_typetrn', 'F')
            ->update(['msth_recordid' => '1']);

//        --------------------- Update tbTr_MSTRAN_D [ MSTD_RECORDID = '1'
        DB::table('tbtr_mstran_d')
            ->where('mstd_nodoc', $doc)->where('mstd_kodeigr', $kodeigr)->where('mstd_typetrn', 'F')
            ->update(['mstd_recordid' => '1']);

//        --------------------- Update tbTr_BPB_BARANGRUSAK [ MSTH_RECORDID = '1'
        DB::table('tbtr_bpb_barangrusak')
            ->where('brsk_nodoc', $doc)->where('brsk_kodeigr', $kodeigr)
            ->update(['brsk_recordid' => '1']);

        return response()->json(['kode' => 1, 'msg' => "Proses Pembatalan Berhasil"]);
    }




}
