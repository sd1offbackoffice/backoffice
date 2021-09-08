<?php

namespace App\Http\Controllers\OMI;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use XBase\TableReader;
use ZipArchive;
use File;

class ProsesBKLDalamKotaController extends Controller
{
    public function index(){
        return view('OMI.prosesBKLDalamKota');
    }

    public function prosesFile(Request  $request){
        $userId     = $_SESSION['usid'];
        $kodeigr    = $_SESSION['kdigr'];
        $ip         = $_SESSION['ip'];
        $file       = $request->file('file');
        $filename   = '';
        $list = [];
        $sesiproc = '999999';


//        DB::table('temp_cetak_tolakanbkldalamkota')->delete();
//        DB::table('temp_list_bkldalamkota')->delete();

        $stat = DB::table('tbmaster_computer')->where('ip', $ip)->where('kodeigr', $kodeigr)->get();

        if (strtolower($file->getClientOriginalExtension()) == 'zip'){
            $zip = new ZipArchive;

            if ($zip->open($file) === TRUE) {
                for ($i = 0; $i < $zip->numFiles; $i++) {
                    $entry = $zip->getNameIndex($i);
                    $list[] = $entry;
                }

                $filename = substr($file->getClientOriginalName(), 0, strpos($file->getClientOriginalName(),'.'));
                $filename = $filename.'.DBF';

                $zip->extractTo(public_path('DBF'));
                $zip->close();
            } else {
                $status = 'error';
                $alert = 'Terjadi kesalahan!';
                $message = 'Mohon pastikan file zip berasal dari program Transfer SJ - IAS!';

                return compact(['status', 'alert', 'message']);
            }
        } else {
            $filename = $file->getClientOriginalName();

            $file->move(public_path("/DBF"), $filename);
        }

//        $temp = File::files(public_path('DBF'."/".$filename)); dd($temp);

        $table = new TableReader(public_path('/DBF/'.$filename));

        while ($record = $table->nextRecord()) {
            DB::table('temp_bkl_dalamkota')->insert([ 'recid' => 5, 'gudang' => $record->get('gudang'),
                    'id' => $record->get('id'), 'lokasi' => $record->get('lokasi'), 'rtype' => $record->get('rtype'),
                    'bukti_no' => $record->get('bukti_no'), 'bukti_tgl' => $record->get('bukti_tgl'), 'supco' => $record->get('supco'),
                    'cr_term' => $record->get('cr_term'), 'prdcd' => $record->get('prdcd'), 'qty' => $record->get('qty'),
                    'bonus' => $record->get('bonus'), 'price' => $record->get('price'), 'gross' => $record->get('gross'),
                    'ppn' => $record->get('ppn'), 'fmdfee' => $record->get('fmdfee'), 'ppnfee' => $record->get('ppnfee'),
                    'ppnbm' => $record->get('ppnbm'), 'hrg_botol' => $record->get('hrg_botol'), 'disc1' => $record->get('disc1'),
                    'disc2' => $record->get('disc2'), 'disc3' => $record->get('disc3'), 'disc4cr' => $record->get('disc4cr'),
                    'disc4rr' => $record->get('disc4rr'), 'disc4jr' => $record->get('disc4jr'), 'invno' => $record->get('invno'),
                    'inv_date' => $record->get('inv_date'), 'po_no' => $record->get('po_no'), 'po_date' => $record->get('po_date'),
                    'istype' => $record->get('istype'), 'bkl' => $record->get('bkl'), 'jam' => $record->get('jam'),
                    'keter' => $record->get('keter'), 'nosph' => $record->get('nosph') ?? ' ',
                    'sessid' => $sesiproc, 'namafile' => $filename,
                ]);
        }

        $moveData = DB::insert("INSERT INTO temp_bkl_dalamkota_full
                  (SELECT bkl.*, SYSDATE
                     FROM temp_bkl_dalamkota bkl
                    WHERE sessid = $sesiproc AND namafile = '$filename')");

        $prosesData = $this->prosesData($filename, $kodeigr, $sesiproc);

        dd($prosesData);

        return response()->json($prosesData);
    }

    public function prosesData($filename, $kodeigr, $sesiproc){
        $BULAN_NO = '123456789ABC';
        $TAHUN_NO = '123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';

        $temp = DB::select("  SELECT NVL (COUNT (1), 0) as temp
                                    FROM TEMP_BKL_DALAMKOTA
                                    WHERE TRIM (SESSID) = $sesiproc
                                        AND TRIM (NAMAFILE) = NAMAFILE
                                        AND KETER IS NOT NULL
                                        AND EXISTS ( SELECT MSTH_NOREF3
                                                     FROM TBTR_MSTRAN_H
                                                    WHERE MSTH_KODEIGR = $kodeigr AND MSTH_NOREF3 = KETER)");

        if($temp[0]->temp != 0){
            return ["kode" => 2, "msg" => "Data BKL Sudah Pernah Diproses !!", "data" => ""];
        }

        $temp = DB::select("SELECT NVL (COUNT (1), 0) as temp
                                  FROM (SELECT DISTINCT BUKTI_NO, GUDANG, BUKTI_TGL
                                                   FROM TEMP_BKL_DALAMKOTA, TBTR_MSTRAN_H
                                                  WHERE TRIM (SESSID) = $sesiproc
                                                    AND TRIM (NAMAFILE) = NAMAFILE
                                                    AND MSTH_KODEIGR = $kodeigr
                                                    AND TRIM (MSTH_NOFAKTUR) = TRIM (GUDANG || BUKTI_NO)
                                                    AND MSTH_TGLFAKTUR = BUKTI_TGL) A");

        $temp2 = DB::select("SELECT NVL (COUNT (1), 0) as temp2
                                    FROM (SELECT DISTINCT BUKTI_NO, GUDANG, BUKTI_TGL
                                                       FROM TEMP_BKL_DALAMKOTA
                                                      WHERE SESSID = $sesiproc AND NAMAFILE = NAMAFILE) A");

        //-- cek data ada di mstran apa ngak
        if($temp[0]->temp == $temp2[0]->temp2){
            return ["kode" => 2, "msg" => "Semua Record di File BKL $filename Sudah Pernah Diproses !!", "data" => ""];
        } else {
            //-- kondisi ada data yg sudah di proses dan belum di proses file nya ditolak atau bagaimana?
            //-- delete data temporary yg sudah ada di mstran, biar ngak ke proses masuk lg
        }

        dd([$temp, $temp2]);



        return ["kode" => 1, "msg" => "Data BKL Sukses !!", "data" => ""];
    }





}
