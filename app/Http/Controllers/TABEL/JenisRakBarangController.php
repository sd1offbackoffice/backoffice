<?php

namespace App\Http\Controllers\TABEL;

use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;
use PDF;
use Yajra\DataTables\DataTables;

class JenisRakBarangController extends Controller
{
    public function index()
    {
        return view('TABEL.jenis-rak-barang');
    }

    public function getData(Request $request)
    {
        $koderak = $request->koderak;
        $data = '';
        if ($koderak == '') {
            $data = DB::connection($_SESSION['connection'])
                ->table("tbtabel_jenisrak")
                ->select('jrak_kodejenisrak', 'jrak_namajenisrak', 'jrak_mindisplay')
                ->orderBy('jrak_kodejenisrak')
                ->first();
        }else{
            $data = DB::connection($_SESSION['connection'])
                ->table("tbtabel_jenisrak")
                ->select('jrak_kodejenisrak', 'jrak_namajenisrak','jrak_mindisplay')
                ->where('jrak_kodejenisrak','=',$koderak)
                ->orderBy('jrak_kodejenisrak')
                ->first();
        }
        return compact(['data']);
    }

    public function getLov(Request $request)
    {
        $search = $request->koderak;

        $data = DB::connection($_SESSION['connection'])
            ->table("tbtabel_jenisrak")
            ->select('jrak_kodejenisrak', 'jrak_namajenisrak')
            ->whereRaw("(jrak_kodejenisrak like '%" . $search . "%' and jrak_namajenisrak like '%" . $search . "%')")
            ->orderBy('jrak_kodejenisrak')
            ->get();

        return DataTables::of($data)->make(true);
    }

    public function hapus(Request $request)
    {
        $koderak = $request->koderak;

        try {
            DB::connection($_SESSION['connection'])->beginTransaction();

            DB::connection($_SESSION['connection'])->table('tbtabel_jenisrak')
                ->where('jrak_kodejenisrak', '=', $koderak)
                ->delete();

            DB::connection($_SESSION['connection'])->commit();

            return response()->json([
                'message' => "Berhasil menghapus data!",
            ], 200);
        } catch (QueryException $e) {
            DB::connection($_SESSION['connection'])->rollBack();

            return response()->json([
                'message' => "Gagal menghapus data!",
            ], 500);
        }
    }

    public function getPrevKodeRak(Request $request)
    {
        $currentKodeRak = $request->koderak;
        $currentRow = DB::connection($_SESSION['connection'])->select("SELECT col
                                  FROM (SELECT rownum col, jrak_kodejenisrak
                                          FROM (SELECT   jrak_kodejenisrak
                                                    FROM tbtabel_jenisrak
                                                ORDER BY jrak_kodejenisrak))
                                 WHERE jrak_kodejenisrak = '" . $currentKodeRak . "'")[0]->col;
        $nextRow = intval($currentRow) - 1;

        if ($nextRow != 0) {
            $data = DB::connection($_SESSION['connection'])->select("SELECT jrak_kodejenisrak, jrak_namajenisrak, jrak_mindisplay
                                          FROM (SELECT rownum col, jrak_kodejenisrak, jrak_namajenisrak, jrak_mindisplay
                                                    FROM tbtabel_jenisrak
                                                ORDER BY jrak_kodejenisrak)
                                                WHERE col= " . $nextRow)[0];
            return compact(['data']);
        }

    }

    public function getNextKodeRak(Request $request)
    {
        $currentKodeRak = $request->koderak;
        $currentRow = DB::connection($_SESSION['connection'])->select("SELECT col
                                  FROM (SELECT rownum col, jrak_kodejenisrak
                                          FROM (SELECT   jrak_kodejenisrak
                                                    FROM tbtabel_jenisrak
                                                ORDER BY jrak_kodejenisrak))
                                 WHERE jrak_kodejenisrak = '" . $currentKodeRak . "'")[0]->col;
        $nextRow = intval($currentRow) + 1;
        $length = DB::connection($_SESSION['connection'])->table("tbtabel_jenisrak")->count();

        if (intval($currentRow) != $length) {
            $data = DB::connection($_SESSION['connection'])->select("SELECT jrak_kodejenisrak, jrak_namajenisrak, jrak_mindisplay
                                          FROM (SELECT rownum col, jrak_kodejenisrak, jrak_namajenisrak, jrak_mindisplay
                                                    FROM tbtabel_jenisrak
                                                ORDER BY jrak_kodejenisrak)
                                                WHERE col= " . $nextRow)[0];
            return compact(['data']);
        }

    }

    public function simpan(Request $request)
    {
        $koderak = $request->koderak;
        $namarak = $request->namarak;
        $mindisplay = $request->mindisplay;
$message = '';
        try {
            DB::connection($_SESSION['connection'])->beginTransaction();
            $temp = DB::connection($_SESSION['connection'])
                ->table('tbtabel_jenisrak')
                ->where('jrak_kodejenisrak',$koderak)
                ->count();
            if ($temp>0){
                DB::connection($_SESSION['connection'])
                    ->table('tbtabel_jenisrak')
                    ->where('jrak_kodejenisrak',$koderak)
                    ->update([
                        'jrak_namajenisrak' => $namarak,
                        'jrak_mindisplay' => $mindisplay,
                        'jrak_modify_by' => $_SESSION['usid'],
                        'jrak_modify_dt' => Carbon::now()
                    ]);
                $message = 'Berhasil mengupdate data!';
            }
            else{
                DB::connection($_SESSION['connection'])
                    ->table('tbtabel_jenisrak')
                    ->insert([
                        'jrak_kodejenisrak' => $koderak,
                        'jrak_namajenisrak' => $namarak,
                        'jrak_mindisplay' => $mindisplay,
                        'jrak_create_by' => $_SESSION['usid'],
                        'jrak_create_dt' => Carbon::now()
                    ]);
                $message = 'Berhasil menyimpan data!';
            }

            DB::connection($_SESSION['connection'])->commit();

            return response()->json([
                'message' => $message,
            ], 200);
        } catch (QueryException $e) {
            DB::connection($_SESSION['connection'])->rollBack();
            return response()->json([
                'message' => "Gagal menyimpan data!",
            ], 500);
        }
    }
}
