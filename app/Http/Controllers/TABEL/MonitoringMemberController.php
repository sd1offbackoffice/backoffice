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

class MonitoringMemberController extends Controller
{
    public function index(){
        return view('TABEL.monitoring-member');
    }

    public function getLovMonitoring(){
        $data = DB::connection($_SESSION['connection'])->table('tbtr_monitoringmember')
            ->selectRaw("mem_kodemonitoring kode, mem_namamonitoring nama")
            ->whereNotNull('mem_kodemonitoring')
            ->distinct()
            ->get();

        return DataTables::of($data)->make(true);
    }

    public function getMonitoring(Request $request){
        $data = DB::connection($_SESSION['connection'])
            ->table('tbtr_monitoringmember')
            ->where('mem_kodeigr','=',$_SESSION['kdigr'])
            ->where('mem_kodemonitoring','=',$request->kode)
            ->first();

        if(!$data){
            return response()->json([
                'message' => 'Kode monitoring tidak terdaftar!'
            ], 500);
        }
        else{
            return response()->json([
                'nama' => $data->mem_namamonitoring
            ], 200);
        }
    }

    public function getLOVMember(Request $request){
        $search = $request->plu;

        if($search == ''){
            $member = DB::connection($_SESSION['connection'])->table(DB::RAW("tbmaster_customer"))
                ->selectRaw("cus_kodemember,cus_namamember")
                ->where('cus_kodeigr','=',$_SESSION['kdigr'])
                ->orderBy('cus_kodemember')
                ->limit(100)
                ->get();
        }
        else if(is_numeric($search)){
            $member = DB::connection($_SESSION['connection'])->table(DB::RAW("tbmaster_customer"))
                ->selectRaw("cus_kodemember,cus_namamember")
                ->where('cus_kodeigr','=',$_SESSION['kdigr'])
                ->where('cus_kodemember','like',DB::RAW("'%".$search."%'"))
                ->orderBy('cus_kodemember')
                ->get();
        }
        else{
            $member = DB::connection($_SESSION['connection'])->table(DB::RAW("tbmaster_customer"))
                ->selectRaw("cus_kodemember,cus_namamember")
                ->where('cus_kodeigr','=',$_SESSION['kdigr'])
                ->Where('cus_namamember','like',DB::RAW("'%".$search."%'"))
                ->orderBy('cus_kodemember')
                ->get();
        }

        return DataTables::of($member)->make(true);
    }

    public function getMember(Request $request){
        $temp = DB::connection($_SESSION['connection'])
            ->selectOne("select *
	from (
				SELECT cus_kodeigr kdigr, cus_kodemember kdmbr FROM TBMASTER_CUSTOMER WHERE cus_kodemember NOT IN (SELECT mem_kodemember FROM TBTR_MONITORINGMEMBER WHERE mem_kodemonitoring = '".$request->kodemonitoring."')
				UNION
				SELECT mem_kodeigr kdigr, to_char(mem_kodemember) kdmbr FROM TBTR_MONITORINGMEMBER where mem_kodemonitoring = '".$request->kodemonitoring."'
				)
	where kdmbr = '".$request->kodemember."'");

        if(!$temp){
            return response()->json([
                'message' => 'Kode member tidak terdaftar!'
            ], 500);
        }
        else{
            $temp = DB::connection($_SESSION['connection'])
                ->table('tbmaster_customer')
                ->where('cus_kodemember','=',$request->kodemember)
                ->where('cus_kodeigr','<>',$_SESSION['kdigr'])
                ->where('cus_flagmemberkhusus','=','Y')
                ->first();

            if($temp){
                return response()->json([
                    'message' => 'Kode member termasuk member khusus dari cabang lain!'
                ], 500);
            }
            else{
                $member = DB::connection($_SESSION['connection'])
                    ->selectOne("SELECT CUS_NAMAMEMBER, CUS_KODEOUTLET, OUT_NAMAOUTLET, CUS_FLAGPKP
			FROM  (
					  	SELECT cus_kodeigr kdigr, cus_kodemember kdmbr
							FROM TBMASTER_CUSTOMER
							WHERE cus_kodemember NOT IN
							(SELECT mem_kodemember FROM TBTR_MONITORINGMEMBER
							WHERE mem_kodemonitoring = '".$request->kodemonitoring."')
							UNION
							SELECT mem_kodeigr kdigr, TO_CHAR(mem_kodemember) kdmbr
							FROM TBTR_MONITORINGMEMBER
							WHERE mem_kodemonitoring = '".$request->kodemonitoring."'
					  ),
		        (
						 	SELECT cus_kodemember, cus_namamember, cus_flagpkp,
						 	cus_kodeoutlet, out_namaoutlet
							FROM TBMASTER_CUSTOMER, TBMASTER_OUTLET
							WHERE out_kodeoutlet(+) = cus_kodeoutlet
						)
			WHERE KDMBR = CUS_KODEMEMBER(+)
		  AND KDMBR = '".$request->kodemember."'");

                return response()->json($member);
            }
        }
    }

    public function getData(Request $request){
        $data = DB::connection($_SESSION['connection'])
            ->select("SELECT mem_kodemember, cus_namamember, cus_kodeoutlet, cus_flagpkp,out_namaoutlet
                FROM( SELECT mem_kodemember, cus_namamember, cus_kodeoutlet, cus_flagpkp,out_namaoutlet
                FROM TBTR_MONITORINGMEMBER,
                ( SELECT cus_kodemember, cus_namamember, cus_flagpkp, cus_kodeoutlet, out_namaoutlet
                FROM TBMASTER_CUSTOMER, TBMASTER_OUTLET
                WHERE out_kodeoutlet(+) = cus_kodeoutlet)
                WHERE cus_kodemember(+) = mem_kodemember
                AND mem_kodemonitoring = '".$request->kode."')
                order by mem_kodemember");

        return DataTables::of($data)->make(true);
    }

    public function addData(Request $request){
        try{
            $temp = DB::connection($_SESSION['connection'])
                ->selectOne("select *
	from (
				SELECT cus_kodeigr kdigr, cus_kodemember kdmbr FROM TBMASTER_CUSTOMER WHERE cus_kodemember NOT IN (SELECT mem_kodemember FROM TBTR_MONITORINGMEMBER WHERE mem_kodemonitoring = '".$request->kodemonitoring."')
				UNION
				SELECT mem_kodeigr kdigr, to_char(mem_kodemember) kdmbr FROM TBTR_MONITORINGMEMBER where mem_kodemonitoring = '".$request->kodemonitoring."'
				)
	where kdmbr = '".$request->kodemember."'");

            if(!$temp){
                return response()->json([
                    'message' => 'Kode member tidak terdaftar!'
                ], 500);
            }
            else{
                $temp = DB::connection($_SESSION['connection'])
                    ->table('tbmaster_customer')
                    ->where('cus_kodemember','=',$request->kodemember)
                    ->where('cus_kodeigr','<>',$_SESSION['kdigr'])
                    ->where('cus_flagmemberkhusus','=','Y')
                    ->first();

                if($temp){
                    return response()->json([
                        'message' => 'Kode member termasuk member khusus dari cabang lain!'
                    ], 500);
                }
                else{
                    $temp = DB::connection($_SESSION['connection'])
                        ->table('tbtr_monitoringmember')
                        ->where('mem_kodeigr','=',$_SESSION['kdigr'])
                        ->where('mem_kodemember','=',$request->kodemember)
                        ->first();

                    if($temp){
                        return response()->json([
                            'message' => 'Kode member sudah ada!'
                        ], 500);
                    }
                    else{
                        DB::connection($_SESSION['connection'])
                            ->table('tbtr_monitoringmember')
                            ->insert([
                                'mem_kodeigr' => $_SESSION['kdigr'],
                                'mem_kodemonitoring' => $request->kodemonitoring,
                                'mem_namamonitoring' => $request->namamonitoring,
                                'mem_kodemember' => $request->kodemember,
                                'mem_create_by' => $_SESSION['usid'],
                                'mem_create_dt' => Carbon::now()
                            ]);
                    }
                }
            }

            DB::connection($_SESSION['connection'])->commit();

            return response()->json([
                'message' => 'Kode member sudah masuk ke kode monitoring '.$request->mon_kode.' !'
            ], 200);
        }
        catch(\Exception $e){
            DB::connection($_SESSION['connection'])->rollBack();

            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function deleteData(Request $request){
        try{
            DB::connection($_SESSION['connection'])->beginTransaction();

            $temp = DB::connection($_SESSION['connection'])
                ->table('tbtr_monitoringmember')
                ->where('mem_kodeigr','=',$_SESSION['kdigr'])
                ->where('mem_kodemonitoring','=',$request->kodemonitoring)
                ->where('mem_namamonitoring','=',$request->namamonitoring)
                ->where('mem_kodemember','=',$request->kodemember)
                ->delete();

            DB::connection($_SESSION['connection'])->commit();

            if($temp == 0){
                return response()->json([
                    'message' => 'Kode member tidak ada dalam kode monitoring '.$request->kodemonitoring.' !'
                ], 500);
            }
            else{
                return response()->json([
                    'message' => 'Kode member '.$request->kodemember.' berhasil dihapus!'
                ], 200);
            }
        }
        catch(\Exception $e){
            DB::connection($_SESSION['connection'])->rollBack();

            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function print(Request $request){
        $perusahaan = DB::connection($_SESSION['connection'])
            ->table("tbmaster_perusahaan")
            ->first();

        $monitoring = DB::connection($_SESSION['connection'])
            ->table('tbtr_monitoringmember')
            ->selectRaw("mem_kodemonitoring kode, mem_namamonitoring nama")
            ->where('mem_kodemonitoring','=',$request->mon)
            ->first();

        $data = DB::connection($_SESSION['connection'])
            ->select("SELECT mem_kodemember, cus_namamember, cus_kodeoutlet, cus_flagpkp,out_namaoutlet
                FROM( SELECT mem_kodemember, cus_namamember, cus_kodeoutlet, cus_flagpkp,out_namaoutlet
                FROM TBTR_MONITORINGMEMBER,
                ( SELECT cus_kodemember, cus_namamember, cus_flagpkp, cus_kodeoutlet, out_namaoutlet
                FROM TBMASTER_CUSTOMER, TBMASTER_OUTLET
                WHERE out_kodeoutlet(+) = cus_kodeoutlet)
                WHERE cus_kodemember(+) = mem_kodemember
                AND mem_kodemonitoring = '".$request->mon."')
                order by mem_kodemember");

        return view('TABEL.monitoring-member-pdf',compact(['perusahaan','data','monitoring']));
    }
}
