<?php

namespace App\Http\Controllers\BACKOFFICE\CETAKDOKUMEN;

use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;
use PDF;
use Yajra\DataTables\DataTables;
use File;

class CetakDokumenController extends Controller
{
    public function index()
    {

        return view('BACKOFFICE.CETAKDOKUMEN.cetak-dokumen');
    }

    public function showData(Request $request)
    {
        $doc = $request->doc;
        $tipe = $request->tipe;
        $reprint = $request->reprint;
        $tgl1 = $request->tgl1;
        $tgl2 = $request->tgl2;
        if ($reprint == 'on') {
            $reprint = 1;
        } else {
            $reprint = 0;
        }
        $data = [];

        if ($doc == 'K') {
            if ($tipe == 'L') {
                $recs = DB::select("SELECT TRBO_NODOC,TRBO_TGLDOC
                           FROM TBTR_BACKOFFICE
                           WHERE(TRBO_TGLDOC BETWEEN to_date('" . $tgl1 . "','dd/mm/yyyy') and to_date('" . $tgl2 . "','dd/mm/yyyy')) and
                                        NVL(TRBO_RECORDID, '0') <> '1' and
                                        TRBO_TYPETRN = '" . $doc . "' and
                                        (NVL(TRBO_FLAGDOC, ' ') = '" . $reprint . "' or NVL(TRBO_FLAGDOC, ' ') = ' ')
                           GROUP BY TRBO_NODOC,TRBO_TGLDOC
                           ORDER BY TRBO_NODOC");
                if ($recs) {
                    foreach ($recs as $rec) {
                        $obj = (object)'';
                        $obj->nodoc = $rec->trbo_nodoc;
                        $obj->tgldoc = $rec->trbo_tgldoc;
                        array_push($data, $obj);
                    }
                }
            } else {
                if ($reprint == '0') {
                    $recs = DB::select("SELECT TRBO_NODOC,TRBO_TGLDOC
                               FROM TBTR_BACKOFFICE
                               WHERE(TRBO_TGLDOC BETWEEN to_date('" . $tgl1 . "','dd/mm/yyyy') and to_date('" . $tgl2 . "','dd/mm/yyyy')) and
                                          TRBO_TYPETRN = '" . $doc . "' and
                                          NVL(TRBO_RECORDID, '0') <> '1' and
                                          NVL(TRBO_FLAGDOC, ' ') <> '*'
                               GROUP BY TRBO_NODOC,TRBO_TGLDOC
                               ORDER BY TRBO_NODOC");
                    if ($recs) {
                        foreach ($recs as $rec) {
                            $obj = (object)'';
                            $obj->nodoc = $rec->trbo_nodoc;
                            $obj->tgldoc = $rec->trbo_tgldoc;
                            array_push($data, $obj);
                        }
                    }
                } else {
                    $recs = DB::select("SELECT MSTH_NODOC,MSTH_TGLDOC
                               FROM TBTR_MSTRAN_H
                               WHERE(MSTH_TGLDOC BETWEEN to_date('" . $tgl1 . "','dd/mm/yyyy') and to_date('" . $tgl2 . "','dd/mm/yyyy')) and
                                          MSTH_TYPETRN = '" . $doc . "' and
                                          NVL(MSTH_RECORDID, '0') <> '1' and
                                          NVL(MSTH_FLAGDOC, ' ') = '" . $reprint . "'
                               ORDER BY MSTH_NODOC");
                    if ($recs) {
                        foreach ($recs as $rec) {
                            $obj = (object)'';
                            $obj->nodoc = $rec->msth_nodoc;
                            $obj->tgldoc = $rec->msth_tgldoc;
                            array_push($data, $obj);
                        }
                    }
                }
            }
        } else {
            if ($tipe == 'L') {
                $recs = DB::select("SELECT TRBO_NODOC,TRBO_TGLDOC
			           FROM TBTR_BACKOFFICE
			           WHERE(TRBO_TGLDOC BETWEEN to_date('" . $tgl1 . "','dd/mm/yyyy') and to_date('" . $tgl2 . "','dd/mm/yyyy')) and
			           			  TRBO_TYPETRN = '" . $doc . "' and
                                  NVL(TRBO_RECORDID, '0') <> '1' and
                                  (NVL(TRBO_FLAGDOC, ' ') = '" . $reprint . "' or NVL(TRBO_FLAGDOC, ' ') = ' ')
			           GROUP BY TRBO_NODOC,TRBO_TGLDOC
			           ORDER BY TRBO_NODOC");
                if ($recs) {
                    foreach ($recs as $rec) {
                        $obj = (object)'';
                        $obj->nodoc = $rec->trbo_nodoc;
                        $obj->tgldoc = $rec->trbo_tgldoc;
                        array_push($data, $obj);
                    }
                }
            } else {
                if ($reprint == '0') {
                    $recs = DB::select("SELECT TRBO_NODOC,TRBO_TGLDOC
                               FROM TBTR_BACKOFFICE
                               WHERE(TRBO_TGLDOC BETWEEN to_date('" . $tgl1 . "','dd/mm/yyyy') and to_date('" . $tgl2 . "','dd/mm/yyyy')) and
                                          TRBO_TYPETRN = '" . $doc . "' and
                                          NVL(TRBO_RECORDID, '0') <> '1' and
                                          NVL(TRBO_FLAGDOC, ' ') <> '*'
                               GROUP BY TRBO_NODOC,TRBO_TGLDOC
                               ORDER BY TRBO_NODOC");
                    if ($recs) {
                        foreach ($recs as $rec) {
                            $obj = (object)'';
                            $obj->nodoc = $rec->trbo_nodoc;
                            $obj->tgldoc = $rec->trbo_tgldoc;
                            array_push($data, $obj);
                        }
                    }
                } else {
                    $recs = DB::select("SELECT MSTH_NODOC,MSTH_TGLDOC
                               FROM TBTR_MSTRAN_H
                               WHERE(MSTH_TGLDOC BETWEEN to_date('" . $tgl1 . "','dd/mm/yyyy') and to_date('" . $tgl2 . "','dd/mm/yyyy')) and
                                          MSTH_TYPETRN = '" . $doc . "' and
                                          NVL(MSTH_RECORDID, '0') <> '1' and
                                          NVL(MSTH_FLAGDOC, ' ') = '" . $reprint . "'
                               ORDER BY MSTH_NODOC");
                    if ($recs) {
                        foreach ($recs as $rec) {
                            $obj = (object)'';
                            $obj->nodoc = $rec->msth_nodoc;
                            $obj->tgldoc = $rec->msth_tgldoc;
                            array_push($data, $obj);
                        }
                    }
                }
            }
        }
        return Datatables::of($data)->addColumn('checkbox', static function ($data) {
            return '<input type="checkbox" id="'.$data->nodoc.'" value="'.$data->nodoc.'"/>';
        })->rawColumns(['checkbox'])->make(true);
    }


}
