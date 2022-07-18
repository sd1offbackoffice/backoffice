<?php

namespace App\Http\Controllers\BACKOFFICE\TRANSAKSI\KIRIMCABANG;

use App\Http\Controllers\Auth\loginController;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;
use PDF;
use XBase\Enum\FieldType;
use XBase\Enum\TableType;
use XBase\Header\Column;
use XBase\Header\HeaderFactory;
use XBase\TableCreator;
use XBase\TableEditor;
use XBase\TableReader;
use Yajra\DataTables\DataTables;
use ZipArchive;
use File;

class TransferSJController extends Controller
{
    public function index()
    {
        return view('BACKOFFICE.TRANSAKSI.KIRIMCABANG.transfer-sj');
    }

    public function getData(Request $request)
    {
        $data = DB::connection(Session::get('connection'))->select("select distinct msth_loc2, cab_namacabang, msth_nodoc
                    from tbtr_mstran_h, tbtr_mstran_d, tbmaster_cabang
                    where nvl(msth_recordid,0) <> '1'
                    and msth_kodeigr = '" . Session::get('kdigr') . "'
                    and msth_typetrn = 'O'
                    and mstd_kodeigr = msth_kodeigr
                    and mstd_nodoc = msth_nodoc
                    and trunc(mstd_tgldoc) =TO_DATE('" . $request->tgl . "','DD/MM/YYYY')
                    and cab_kodecabang = msth_loc2
                    and cab_kodeigr = msth_kodeigr
                    and nvl(msth_flagdoc,' ') <> '*'
                    order by msth_loc2");

        if (count($data) == 0)
            return $data;

        $temp = null;
        $datas = [];
        $x = [];
        foreach ($data as $d) {
            if ($temp != $d->msth_loc2) {
                $temp = $d->msth_loc2;
                if (count($x) > 0) {
                    $datas[] = $x;
                    $x = [];
                }
            }
            $x[] = $d;
        }
        $datas[] = $x;

        $result = [];
        foreach ($datas as $data) {
            $temp = new \stdClass();
            $temp->cabang = $data[0]->msth_loc2 . ' - ' . $data[0]->cab_namacabang;
            $temp->nodoc = '';
            foreach ($data as $d) {
                $temp->nodoc .= $d->msth_nodoc . ', ';
            }
            $temp->nodoc = substr($temp->nodoc, 0, strlen($temp->nodoc) - 2);
            $result[] = $temp;
        }

        return $result;
    }

    public function transfer(Request $request)
    {
        $arr = explode(', ', $request->nodoc);

        $nodoc = '(';
        foreach ($arr as $n) {
            $nodoc .= "'" . $n . "',";
        }
        $nodoc = substr($nodoc, 0, -1) . ')';

        DB::connection(Session::get('connection'))->statement("truncate table temp_sj");
        DB::connection(Session::get('connection'))->statement("truncate table temp_titip");

        try {
            DB::connection(Session::get('connection'))->beginTransaction();

            $data = DB::connection(Session::get('connection'))->insert(
                "INSERT INTO temp_sj 
                SELECT mstd_recordid recid , mstd_typetrn rtype, mstd_nodoc docno, to_char(mstd_tgldoc,'yyyymmdd') DATEO, mstd_noref3 noref1, mstd_tgref3 tgref1,mstd_docno2 noref2, mstd_date2 tgref2, mstd_docno2 docno2, mstd_date2  date2, mstd_istype istype,  mstd_invno invno, mstd_date3 date3, mstd_nott nott,  mstd_tgltt date4, mstd_kodesupplier supco, mstd_pkp pkp, mstd_cterm cterm,  mstd_seqno seqno, mstd_prdcd prdcd, substr(prd_deskripsipanjang,1,45) desc2, mstd_kodedivisi div, mstd_kodedepartement dept, mstd_kodekategoribrg katb, mstd_bkp bkp, mstd_fobkp fobkp, mstd_unit unit, mstd_frac frac, msth_loc loc, msth_loc2 loc2, floor(to_number((mstd_qty/CASE WHEN mstd_unit='KG' THEN 1000 ELSE mstd_frac END))) qty_ctn, CASE WHEN mstd_unit='KG' THEN 0 ELSE nvl(mod(nvl(mstd_qty,0),nvl(mstd_frac,0)),0) END qty_pcs, nvl(mstd_qtybonus1,0) qbns1, nvl(mstd_qtybonus2,0) qbns2, mstd_hrgsatuan price, nvl(mstd_persendisc1,0) discp1, nvl(mstd_rphdisc1,0) discr1, null, nvl(mstd_persendisc2,0) discp2, nvl(mstd_rphdisc2,0) discr2, NULL, nvl(mstd_gross,0) gross, nvl(mstd_discrph,0) discrp, nvl(mstd_ppnrph,0) ppnrp, nvl(mstd_ppnbmrph,0) bmrp, nvl(mstd_ppnbtlrph,0) btlrp, nvl(mstd_avgcost,0) acost, mstd_keterangan keter, 'T' doc, 'F' doc2, 'F' fk, NULL , mstd_kodetag mtag, mstd_gdg	gdg, trunc(sysdate) tglupd, to_char(sysdate,'hh24:mi:ss') jamupd,'" . Session::get('usid') . "'	USERO
				FROM tbtr_mstran_h, tbtr_mstran_d, tbmaster_prodmast
				WHERE msth_nodoc in " . $nodoc . "
						AND msth_kodeigr='" . Session::get('kdigr') . "'
						AND mstd_nodoc=msth_nodoc
						AND mstd_kodeigr=msth_kodeigr
						AND prd_prdcd=mstd_prdcd
						AND prd_kodeigr=mstd_kodeigr"
            );

            DB::connection(Session::get('connection'))->insert(
                "INSERT INTO temp_titip 
                SELECT  titip_nodoc nodoc,
                        titip_nonota nonota,
                        titip_kode kode,
                        titip_kode_ekspedisi kode_x,
                        titip_nama_barang nama,
                        titip_frac frac,
                        titip_qty qty,
                        titip_m3 m3,
                        titip_ton ton,
                        titip_keterangan_titipan ket,
                        titip_nosj nosj,
                        titip_tgletd tgletd,
                        titip_tgleta tgleta,
                        titip_kodecabangtitip kode_cab,
                        titip_namacabangtitip nama_cab,
                        titip_ekspedisi eks,
                        titip_seal seal,
                        titip_nomobil nomobil,
                        titip_durasi durasi,
                        titip_tarif tarif,
                        titip_koli koli,
                        titip_alamat alamat,
                        titip_container cont,
                        titip_kapal kapal,
                        trunc(sysdate) crt_dt,
                        trunc(sysdate) mod_dt,
                        '" . Session::get('usid') . "' crt_by
				FROM tbtr_titip
				WHERE titip_nonota in " . $nodoc . ""
            );

            DB::connection(Session::get('connection'))->update("update tbtr_mstran_h
                            set msth_flagdoc = '*'
                            where msth_nodoc in " . $nodoc . " and msth_typetrn='O'");

            DB::connection(Session::get('connection'))->commit();

            return 'success';
        } catch (QueryException $e) {
            DB::connection(Session::get('connection'))->rollBack();
            return $e;
        }
    }

    public function download()
    {
        $data = DB::connection(Session::get('connection'))
            ->table('temp_sj')
            ->orderBy('docno')
            ->distinct()
            ->get();
        // dd($data);

        $docno = $data[0]->docno;
        $data = json_decode(json_encode($data), true);

        $data_titip = DB::connection(Session::get('connection'))
            ->table('temp_titip')
            ->where('nonota', $docno)
            ->orderBy('nonota')
            ->get();

        $data_titip = json_decode(json_encode($data_titip), true);
        DB::connection(Session::get('connection'))->statement("truncate table temp_sj");
        DB::connection(Session::get('connection'))->statement("truncate table temp_titip");

        //INPUT
        $temp = '';
        $datas = [];
        $x = [];
        foreach ($data as $d) {
            if ($temp != $d['docno']) {
                $temp = $d['docno'];
                if (count($x) > 0) {
                    $datas[] = $x;
                    $x = [];
                }
            }
            $x[] = $d;
        }
        $datas[] = $x;

        // dd($datas);

        $column = DB::connection(Session::get('connection'))
            ->select("select column_name, data_type FROM USER_TAB_COLUMNS WHERE table_name = 'TEMP_SJ' order by column_id");

        foreach ($datas as $data) {
            $filepath = self::cleanupFiles(storage_path('TRFSJ/' . $data[0]['docno'] . '.dbf'));
            //        chmod($filepath, 755);
            if (file_exists($filepath)) {
                unlink($filepath);
            }
            $header = HeaderFactory::create(TableType::DBASE_III_PLUS_NOMEMO);

            $tableCreator = new TableCreator($filepath, $header);

            foreach ($column as $c) {
                if ($c->data_type == 'VARCHAR2') {
                    $tableCreator
                        ->addColumn(new Column([
                            'name'   => $c->column_name,
                            'type'   => FieldType::CHAR,
                            'length' => 254

                        ]));
                } else if ($c->data_type == 'DATE') {
                    $tableCreator
                        ->addColumn(new Column([
                            'name'   => $c->column_name,
                            'type'   => FieldType::CHAR,
                            'length' => 254
                        ]));
                } else {
                    $tableCreator
                        ->addColumn(new Column([
                            'name'   => $c->column_name,
                            'type'   => FieldType::NUMERIC,
                            'length' => 20,
                            'decimalCount' => 2,
                        ]));
                }
            }

            $tableCreator->save();
            $table = new TableEditor($filepath);
            foreach ($data as $d) {
                $record = $table->appendRecord();
                foreach ($column as $c) {
                    $record->set($c->column_name, $d[strtolower($c->column_name)]);
                }
                $table->writeRecord($record);
            }
            $table->save()->close();
        }

        // TITIP
        $temp = '';
        $datas_titip = [];
        $x = [];
        foreach ($data_titip as $d) {
            if ($temp != $d['nonota']) {
                $temp = $d['nonota'];
                if (count($x) > 0) {
                    $datas_titip[] = $x;
                    $x = [];
                }
            }
            $x[] = $d;
        }
        $datas_titip[] = $x;

        $column_titip = DB::connection(Session::get('connection'))
            ->select("select column_name, data_type FROM USER_TAB_COLUMNS WHERE table_name = 'TEMP_TITIP' order by column_id");

        foreach ($datas_titip as $data) {
            $filepath = self::cleanupFiles(storage_path('TRFSJ/' . $data[0]['nonota'] . '_titipan.dbf'));
            //        chmod($filepath, 755);
            if (file_exists($filepath)) {
                unlink($filepath);
            }
            $header = HeaderFactory::create(TableType::DBASE_III_PLUS_NOMEMO);

            $tableCreator = new TableCreator($filepath, $header);

            foreach ($column_titip as $ct) {
                if ($ct->data_type == 'VARCHAR2') {
                    $tableCreator
                        ->addColumn(new Column([
                            'name'   => $ct->column_name,
                            'type'   => FieldType::CHAR,
                            'length' => 254

                        ]));
                } else if ($ct->data_type == 'DATE') {
                    $tableCreator
                        ->addColumn(new Column([
                            'name'   => $ct->column_name,
                            'type'   => FieldType::CHAR,
                            'length' => 254
                        ]));
                } else {
                    $tableCreator
                        ->addColumn(new Column([
                            'name'   => $ct->column_name,
                            'type'   => FieldType::NUMERIC,
                            'length' => 20,
                            'decimalCount' => 2,
                        ]));
                }
            }

            $tableCreator->save();
            $table = new TableEditor($filepath);
            foreach ($data_titip as $d) {
                $record = $table->appendRecord();
                foreach ($column_titip as $c) {
                    $record->set($c->column_name, $d[strtolower($c->column_name)]);
                }
                $table->writeRecord($record);
            }
            $table->save()->close();
        }

        //        return response()->download($filepath)->deleteFileAfterSend(false);

        //        $columnHeader = [];
        //        foreach($column as $c){
        //            $columnHeader[] = $c->column_name;
        //        }

        //        foreach($datas as $data){
        //            $rows = collect($data)->map(function ($x) {
        //                return (array)$x;
        //            })->toArray();
        //
        //           $filename = $data[0]->docno.'.csv';
        //
        //            $headers = [
        //                "Content-type" => "text/csv",
        //                "Pragma" => "no-cache",
        //                "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
        //                "Expires" => "0"
        //            ];
        //            $file = fopen('TRFSJ/'.$filename, 'w');
        //            fputcsv($file, $columnHeader, '|');
        //            foreach ($rows as $row) {
        //                fputcsv($file, $row, '|');
        //            }
        //            fclose($file);
        //        }

        $zip = new ZipArchive;
        $tgl = date('m-d', strtotime($datas[0][0]['dateo']));
        $filename = 'TO' . $datas[0][0]['loc2'] . $tgl . '.zip';
        if ($zip->open(storage_path($filename), ZipArchive::CREATE) === TRUE) {
            $files = File::files(storage_path('TRFSJ'));

            foreach ($files as $key => $value) {
                $relativeNameInZipFile = basename($value);
                $zip->addFile($value, $relativeNameInZipFile);
            }

            $zip->close();
        }

        File::delete($files);

        return response()->download(storage_path($filename))->deleteFileAfterSend(true);
    }

    public function open()
    {
        $dataFileDBF = new TableReader(storage_path('TO220421.DBF'));

        //        dd($dataFileDBF->getRecordCount());
        while ($recs = $dataFileDBF->nextRecord()) {
            dd($recs);
        }
    }

    public function cleanupFiles($filepath)
    {
        if (file_exists($filepath)) {
            unlink($filepath);
        }

        $memoExts = ['dbt', 'fpt'];
        $fileInfo = pathinfo($filepath);
        foreach ($memoExts as $memoExt) {
            $memoFilepath = $fileInfo['dirname'] . DIRECTORY_SEPARATOR . $fileInfo['filename'] . $memoExt;
            if (file_exists($memoFilepath)) {
                unlink($memoFilepath);
            }
        }

        return $filepath;
    }
}
