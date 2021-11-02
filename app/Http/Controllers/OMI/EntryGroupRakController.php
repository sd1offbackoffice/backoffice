<?php

namespace App\Http\Controllers\OMI;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use PDF;
use Yajra\DataTables\DataTables;
use File;

class EntryGroupRakController extends Controller
{
    public function index()
    {
        return view('OMI.entrygrouprak');
    }

    public function getDataHeader(Request $request)
    {
        $data = DB::table('tbmaster_grouprak')->select('grr_grouprak', 'grr_namagroup', 'grr_flagcetakan')
            ->distinct()
            ->get();
        return DataTables::of($data)->make(true);
    }

    public function getDataDetail(Request $request)
    {
        $search = $request->search;
        $data = DB::table('tbmaster_grouprak')->select('grr_koderak', 'grr_subrak')
            ->where('grr_grouprak', '=', $search)
            ->get();
        return DataTables::of($data)->make(true);
    }

    public function simpanHeader(Request $request)
    {
        $grouprak = $request->data['grouprak'];
        $namarak = $request->data['namarak'];
        $flag = $request->data['flag'];

        $jum = DB::select("Select NVL(COUNT(1), 0) count
		  From TBMaster_GroupRak
		 Where GRR_KodeIGR = '" . $_SESSION['kdigr'] . "'
            and GRR_GroupRak = '" . $grouprak . "'")[0]->count;
        if ($jum == 0) {
            DB::insert("INSERT INTO TBMASTER_GROUPRAK
			(
				GRR_KodeIGR,
				GRR_GroupRak,
				GRR_NamaGroup,
				GRR_FlagCetakan,
				GRR_Create_By,
				GRR_Create_Dt
			)
			VALUES
			(
				'" . $_SESSION['kdigr'] . "',
				'" . $grouprak . "',
				'" . $namarak . "',
				'" . $flag . "',
				'" . $_SESSION['usid'] . "',
				sysdate
			)");

            $message = 'Group Rak Berhasil Di Simpan!';
            $status = 'success';
            return compact(['message', 'status']);
        } else {
            DB::update("UPDATE TBMASTER_GROUPRAK
			   SET GRR_NamaGroup = '" . $namarak . "',
			       GRR_FlagCetakan = '" . $flag . "',
			       GRR_Modify_BY = '" . $_SESSION['usid'] . "',
			       GRR_Modify_Dt = sysdate
			 Where GRR_KodeIGR = '" . $_SESSION['kdigr'] . "'
		     And GRR_GROUPRak = '" . $grouprak . "'");

            $message = 'Group Rak ' . $grouprak . ' Berhasil Diupdate!';
            $status = 'success';
            return compact(['message', 'status']);
        }
    }

    public function simpanDetail(Request $request)
    {
        $grouprak = $request->data['grouprak'];
        $namarak = $request->data['namarak'];
        $koderak = $request->data['koderak'];
        $subrak = $request->data['subrak'];
        $flag = $request->data['flag'];

        $jum = DB::select("Select NVL(COUNT(1), 0) count
		  From tbmaster_lokasi
		 Where lks_kodeigr = '" . $_SESSION['kdigr'] . "'
            and lks_koderak = '" . $koderak . "'
            and lks_kodesubrak = '" . $subrak . "'")[0]->count;

        if ($jum > 0) {

            $jum = DB::select("Select NVL(COUNT(1), 0) count
                  From tbmaster_grouprak
                 Where grr_kodeigr = '" . $_SESSION['kdigr'] . "'
                    and grr_grouprak = '" . $grouprak . "'
                    and grr_koderak is null
                    and grr_subrak is null")[0]->count;

            if ($jum > 0) {
                DB::update("update tbmaster_grouprak
				   set grr_koderak = '" . $koderak . "',
				       grr_subrak = '" . $subrak . "',
				       grr_nourut = '1',
				       grr_modify_by = '" . $_SESSION['usid'] . "',
				       grr_modify_dt = sysdate
				 where grr_kodeigr = '" . $_SESSION['kdigr'] . "'
                and grr_grouprak = '" . $grouprak . "'
                and grr_koderak is null
                and grr_subrak is null");
                $message = 'Data Detail Berhasil disimpan!';
                $status = 'success';
                return compact(['message', 'status']);

            } else {
                $jum = DB::select("Select NVL(COUNT(1), 0) count
                  From tbmaster_grouprak
                 Where grr_kodeigr = '" . $_SESSION['kdigr'] . "'
                    and grr_grouprak = '" . $grouprak . "'
                    and grr_koderak = '" . $koderak . "'
                    and grr_subrak = '" . $subrak . "'")[0]->count;

                if ($jum == 0) {
                    $nour = DB::select("select nvl(max(grr_nourut), 0) count
					  from tbmaster_grouprak
				   where grr_kodeigr = '" . $_SESSION['kdigr'] . "'
                    and grr_grouprak = '" . $grouprak . "'
                    and grr_koderak = '" . $koderak . "'")[0]->count;

                    $nour = $nour + 1;

                    DB::insert("insert into tbmaster_grouprak
                    (
                        grr_kodeigr,
                        grr_grouprak,
                        grr_namagroup,
                        grr_koderak,
                        grr_subrak,
                        grr_flagcetakan,
                        grr_nourut,
                        grr_create_by,
                        grr_create_dt
                    )
					values
                    (
						'" . $_SESSION['kdigr'] . "',
						'" . $grouprak . "',
						'" . $namarak . "',
						'" . $koderak . "',
						'" . $subrak . "',
						'" . $flag . "',
						'" . $nour . "',
						'" . $_SESSION['usid'] . "',
						sysdate
					)");

                    $message = 'Data Detail Berhasil disimpan!';
                    $status = 'success';
                    return compact(['message', 'status']);
                } else {
                    $message = 'kode rak dan sub rak sudah terdaftar!';
                    $status = 'warning';
                    return compact(['message', 'status']);
                }
            }
        } else {
            $message = 'kode rak dan sub rak tidak terdaftar di master lokasi!';
            $status = 'warning';
            return compact(['message', 'status']);
        }
    }

    public function hapusDetail(Request $request)
    {
        $jum = 0;
        $d_grouprak = $request->data['grouprak'];
        $d_koderak = $request->data['koderak'];
        $d_subrak = $request->data['subrak'];

        $jum = DB::select("Select NVL(COUNT(1), 0) count
		  From TBMaster_GroupRak
		 Where GRR_KodeIGR = '" . $_SESSION['kdigr'] . "'
            and GRR_GroupRak = '" . $d_grouprak . "'
            and GRR_KodeRak = '" . $d_koderak . "'
            and GRR_Subrak = '" . $d_subrak . "'")[0]->count;

        if ($jum > 0) {
            DB::delete("delete From TBMaster_GroupRak
		 Where GRR_KodeIGR = '" . $_SESSION['kdigr'] . "'
            and GRR_GroupRak = '" . $d_grouprak . "'
            and GRR_KodeRak = '" . $d_koderak . "'
            and GRR_Subrak = '" . $d_subrak . "'");

            $message = 'KODE RAK DAN SUB RAK BERHASIL DIHAPUS!';
            $status = 'success';
            return compact(['message', 'status']);
        } else {
            $message = 'KODE RAK DAN SUB RAK TIDAK DITEMUKAN!';
            $status = 'warning';
            return compact(['message', 'status']);
        }
    }
}
