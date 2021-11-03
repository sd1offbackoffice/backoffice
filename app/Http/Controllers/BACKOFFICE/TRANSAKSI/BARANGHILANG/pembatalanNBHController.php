<?php

namespace App\Http\Controllers\BACKOFFICE\TRANSAKSI\BARANGHILANG;

use App\AllModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class pembatalanNBHController extends Controller
{
    public function index(){
        $kodeigr = $_SESSION['kdigr'];

        $result = DB::table('tbtr_mstran_h')
            ->select('msth_nodoc', 'msth_tgldoc')
            ->where('msth_kodeigr','=',$kodeigr)
            ->where('msth_typetrn','=','H')
            ->whereRaw("nvl(msth_recordid,9)<>1")
            ->orderBy('msth_nodoc')
            ->limit('100')
            ->get();

        return view('BACKOFFICE.TRANSAKSI.BARANGHILANG.pembatalanNBH', compact('result'));
    }

    public function lovNBH(Request $request){

        $search = $request->search;
        $kodeigr = $_SESSION['kdigr'];

        $result = DB::table('tbtr_mstran_h')
            ->select('msth_nodoc', 'msth_tgldoc')
            ->whereRaw("msth_nodoc LIKE '%".$search."%'")
            ->where('msth_kodeigr','=',$kodeigr)
            ->where('msth_typetrn','=','H')
            ->whereRaw("nvl(msth_recordid,9)<>1")
            ->orderBy('msth_nodoc')
            ->limit('100')
            ->get();

        return response()->json($result);
    }

    public function showData(Request $request){

        $nonbh = $request->nonbh;
        $kodeigr = $_SESSION['kdigr'];

        $result = DB::select(" select mstd_nodoc, mstd_prdcd, prd_deskripsipanjang, mstd_unit, mstd_frac,
											mstd_qty, mstd_hrgsatuan, mstd_gross
									from tbtr_mstran_d, tbmaster_prodmast
									where mstd_nodoc = '$nonbh'
											and mstd_kodeigr = '$kodeigr'
											and mstd_typetrn = 'H'
											and prd_prdcd = mstd_prdcd
											and prd_kodeigr = mstd_kodeigr ");

        return response()->json($result);
    }

    public function deleteData(Request $request){

        $kodeigr = $_SESSION['kdigr'];
        $userid = $_SESSION['usid'];
        $nonbh = $request->nonbh;
        $model  = new AllModel();
//        $date   = $model->getDate();
        $dateTime = $model->getDateTime();

        $temp = DB::table('tbtr_mstran_d')
            ->leftJoin('tbmaster_prodmast', 'mstd_prdcd', '=', 'prd_prdcd')
            ->where('mstd_nodoc', '=', $nonbh)
            ->first();

        if(!$temp->mstd_prdcd){
            return response()->json(['kode' => 0, 'msg' => "Data Tidak Ada"]);
        }

        $result = DB::select(" select mstd_prdcd, mstd_nodoc, mstd_tgldoc, prd_deskripsipanjang barang, mstd_unit||'/'||mstd_frac satuan,
                                      mstd_flagdisc1 fdisc1, mstd_hrgsatuan price, mstd_frac frac, mstd_unit unit, prd_frac, mstd_kodedivisi div,
                                      mstd_kodedepartement, mstd_kodekategoribrg kat, floor(mstd_qty/mstd_frac) qty, mod(mstd_qty,mstd_frac) qtyk,
                                      mstd_qty, mstd_hrgsatuan, mstd_gross, prd_avgcost acost,
                                      Case When nvl(st_saldoakhir,0)<=0 Then 0 Else st_saldoakhir End st_saldoakhir,
									  nvl(st_lastcost,0) st_lastcost, nvl(st_avgcost,0) st_avgcost
									  from tbtr_mstran_d, tbmaster_prodmast, tbmaster_stock
									  where mstd_nodoc = '$nonbh'
									  and mstd_kodeigr = '$kodeigr'
									  and mstd_typetrn = 'H'
									  and prd_prdcd = mstd_prdcd
									  and prd_kodeigr = mstd_kodeigr
									  and st_prdcd(+) = mstd_prdcd
  							          and st_kodeigr(+) = mstd_kodeigr
  							          and st_lokasi(+) = lpad(mstd_flagdisc1,2,'0') ");

        foreach ($result as $data){

            $nQtt = abs(($data->qty * $data->frac) + $data->qtyk);

            if($data->unit = 'KG'){
                $data->frac = 1;
            }

            $nCost = $data->price / $data->frac;
            $nAcostBaru = (($data->st_saldoakhir * $data->st_avgcost) + ($nCost * $nQtt)) /(($data->st_saldoakhir)+ $nQtt);

            if($data->fdisc1 = '1' && (($data->qty + $nQtt)!=0)) {

                $tempAvg = ($data->unit == 'KG') ? $nAcostBaru * 1 : ($data->frac <= 0) ? $nAcostBaru * 1 : $nAcostBaru * $data->frac;

                // Update Data tbMaster_prodmast

                DB::table('tbmaster_prodmast')
                    ->whereRaw("substr(prd_prdcd,1,6) = substr('$data->mstd_prdcd',1,6)")
                    ->where('prd_kodeigr', $kodeigr)
                    ->update(['prd_avgcost' => $tempAvg]);
            }

            // Simpan Data History Average Costs
            DB::table('tbhistory_cost')
                ->insert(['hcs_kodeigr' => $kodeigr, 'hcs_typetrn' => 'H', 'hcs_lokasi' => str_pad($data->fdisc1,2,0),
                    'hcs_prdcd' => $data->mstd_prdcd, 'hcs_tglbpb' => $data->mstd_tgldoc, 'hcs_nodocbpb' => $data->mstd_nodoc,
                    'hcs_qtybaru' => $data->mstd_qty, 'hcs_qtylama' => $data->st_saldoakhir, 'hcs_avglama' => ($data->st_avgcost * $data->frac),
                    'hcs_avgbaru' => ($nAcostBaru * $data->frac), 'hcs_lastqty' => ($data->st_saldoakhir + $data->mstd_qty),
                    'hcs_create_by' => $userid, 'hcs_create_dt' => $dateTime
                ]);

//            // Update Data tbMaster_Stock
//                $connect = loginController::getConnectionProcedure();
//
//                $query = oci_parse($connect, "sp_igr_update_stock_2 ('$kodeigr', lpad($data->fdisc1,2,'0'), $data->mstd_prdcd, '',
//						 													'TRFOUT', -1*$data->mstd_qty, $data->st_lastcost, $nAcostBaru,
//						 													$userid, v_lok, v_message); ");
//                oci_bind_by_name($query, ':v_lok', $v_lok,10);
//                oci_bind_by_name($query, ':v_message', $v_msg,100);
//                oci_execute($query);
        }

        //Simpan Data Yang Dihapus

        DB::raw(" INSERT INTO tbtr_hapusplu (DEL_KODEIGR,DEL_RTYPE,DEL_NODOKUMEN,DEL_TGLDOKUMEN,
            DEL_STOKQTYOLD, DEL_AVGCOSTOLD, DEL_CREATE_BY, DEL_CREATE_DT, DEL_PRDCD)
 					    SELECT mstd_kodeigr, mstd_typetrn, mstd_nodoc, mstd_tgldoc,
  							     mstd_qty, mstd_avgcost, '$userid', '$dateTime', mstd_prdcd
				      FROM tbTr_MSTRAN_D, tbMaster_Stock
				      WHERE mstd_nodoc = '$nonbh'
        and mstd_kodeigr = '$kodeigr'
        and st_prdcd = mstd_prdcd
        and st_kodeigr = mstd_kodeigr
        and st_lokasi = lpad(mstd_flagdisc1,2,'0'); ");

        // Update tbTr_MSTRAN_H [ MSTH_RECORDID = '1' : Status DELETE ]

        DB::table('tbTr_MSTRAN_H')
            ->where('msth_nodoc', '=', $nonbh)
            ->where('msth_kodeigr', '=', $kodeigr)
            ->where('msth_typetrn', '=', 'H')
            ->update(['msth_recordid' => '1']);

        // Update tbTr_MSTRAN_D [ MSTD_RECORDID = '1' : Status DELETE ]

        DB::table('tbTr_MSTRAN_D')
            ->where('mstd_nodoc','=', $nonbh)
            ->where('mstd_kodeigr', '=', $kodeigr)
            ->where('mstd_typetrn','=', 'H')
            ->update(['mstd_recordid' => '1']);

        return response()->json(['kode' => 1, 'msg' => "Proses Pembatalan Berhasil"]);
    }
}
