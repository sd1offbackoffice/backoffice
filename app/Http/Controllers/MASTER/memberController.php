<?php

namespace App\Http\Controllers\MASTER;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;

class memberController extends Controller
{
    //

    public function index(){
//        $cus = DB::table(DB::RAW('tbmaster_customer_interface@igrcrm'))
//            ->where('cus_kodemember','789867')
//            ->first();
//        $crm = DB::table(DB::RAW('tbmaster_customercrm_interface@igrcrm'))
//            ->select('crm_recordid','crm_kodeigr','crm_kodemember','crm_jenisanggota','crm_jeniskelamin','crm_pic1','crm_nohppic1','crm_pic2','crm_nohppic2','crm_agama','crm_namapasangan','crm_tgllhrpasangan','crm_jmlanak','crm_pendidikanakhir','crm_nofax','crm_koordinat','crm_namabank','crm_jenisbangunan','crm_lamatmpt','crm_statusbangunan','crm_internet','crm_tipehp','crm_metodekirim','crm_kreditusaha','crm_bankkredit','crm_email','crm_group','crm_subgroup','crm_kategori','crm_subkategori','crm_pekerjaan','crm_tmptlahir','crm_alamatusaha1','crm_alamatusaha2','crm_alamatusaha3','crm_alamatusaha4','crm_idgroupkat','crm_idsegment','crm_motor','crm_mobil','crm_create_by','crm_create_dt','crm_modify_by','crm_modify_dt')
//            ->where('crm_kodemember','789867')
//            ->first();
//        dd(compact(['cus','crm']));

        $member = DB::table('tbmaster_customer')
            ->select('*')
            ->where(DB::RAW('ROWNUM'),'<=','100')
            ->orderBy('cus_namamember')
            ->limit(100)
            ->get();

        $hobby = DB::table('tbtabel_hobby')
            ->select('*')
            ->get();

        $kodepos = DB::table('tbmaster_kodepos')
            ->select('*')->limit(100)
            ->get();

        $fasilitasperbankan = DB::table('tbmaster_fasilitasperbankan')
            ->get();

        $jenismember = DB::table('tbmaster_jenismember')
            ->select('jm_kode','jm_keterangan')
            ->orderBy('jm_keterangan')
            ->get();

        $jenisoutlet = DB::table('tbmaster_outlet')
            ->select('out_kodeoutlet','out_namaoutlet')
            ->orderBy('out_kodeoutlet')
            ->get();

        $group = DB::table('tbtabel_groupkategori')
            ->select('grp_group','grp_subgroup','grp_kategori','grp_subkategori','grp_idgroupkat')
            ->orderBy('grp_group')
            ->get();

        return view('MASTER.member')->with(compact(['member','hobby','fasilitasperbankan','kodepos','jenismember','jenisoutlet','group']));
    }

    public function lov_member_select(Request $request){
        $member = DB::table('tbmaster_customer')
            ->leftJoin('tbmaster_customercrm','cus_kodemember','=','crm_kodemember')
            ->select('*')
            ->where('cus_kodemember',$request->value)
            ->first();

        if(!$member){
            return 'not-found';
        }

        if($member->cus_alamatmember4 != '' && $member->cus_alamatmember4 != null){
            $ktp = DB::table('tbmaster_kodepos')
                ->select('*')
                ->where('pos_kode','=',$member->cus_alamatmember3)
                ->where('pos_kelurahan','=',$member->cus_alamatmember4)
                ->first();
        }
        else if($member->cus_alamatmember3 != '' && $member->cus_alamatmember3 != null){
            $ktp = DB::table('tbmaster_kodepos')
                ->select('*')
                ->where('pos_kode','=',$member->cus_alamatmember3)
                ->first();
        }
        else $ktp = '';

        if($member->cus_alamatmember8 != '' && $member->cus_alamatmember8 != null) {
            $surat = DB::table('tbmaster_kodepos')
                ->select('*')
                ->where('pos_kode', '=', $member->cus_alamatmember7)
                ->where('pos_kelurahan', '=', $member->cus_alamatmember8)
                ->first();
        }
        else if($member->cus_alamatmember7 != '' && $member->cus_alamatmember7 != null){
            $surat = DB::table('tbmaster_kodepos')
                ->select('*')
                ->where('pos_kode', '=', $member->cus_alamatmember7)
                ->first();
        }
        else $surat = '';

        if($member->crm_kodemember != '' && $member->crm_alamatusaha3 != null && $member->crm_alamatusaha4 != null){
            $usaha = DB::table('tbmaster_kodepos')
                ->select('*')
                ->where('pos_kode','=',$member->crm_alamatusaha3)
                ->where('pos_kelurahan','=',$member->crm_alamatusaha4)
                ->first();
        }
        else{
            $usaha = '';
        }

        if($member->crm_idgroupkat != '' && $member->crm_idgroupkat != null){
            $group = DB::table('tbtabel_groupkategori')
                ->select('*')
                ->where('grp_idgroupkat','=',$member->crm_idgroupkat)
                ->first();
        }
        else{
            $group = '';
        }

        $jenismember = DB::table('tbmaster_jenismember')
            ->select('*')
            ->where('jm_kode','=',$member->cus_jenismember)
            ->first();

        $outlet = DB::table('tbmaster_outlet')
            ->select('*')
            ->where('out_kodeoutlet','=',$member->cus_kodeoutlet)
            ->first();

        $bank = DB::table('tbmaster_customerfasilitasbank')
            ->select('*')
            ->where('cub_kodemember','=',$request->value)
            ->get();

        $hobbymember = DB::table('tbtabel_hobbydetail')
            ->select('*')
            ->where('dhb_kodemember','=',$member->cus_kodemember)
            ->get();

        $creditlimit = DB::table('tbhistory_creditlimit')
            ->select('*')
            ->where('lmt_kodemember','=',$member->cus_kodemember)
            ->get();

        $npwp = DB::table('tbmaster_npwp')
            ->select('*')
            ->where('pwp_kodemember','=',$member->cus_kodemember)
            ->first();

//        dd(compact(['member','ktp','surat','usaha','jenismember','outlet','group','bank','hobbymember','creditlimit','npwp']));

        return compact(['member','ktp','surat','usaha','jenismember','outlet','group','bank','hobbymember','creditlimit','npwp']);
    }

    public function lov_kodepos_select(Request $request){
        if($request->kode == 'x' && $request->kecamatan == 'x' && $request->kabupaten == 'x'){
            $data = DB::table('tbmaster_kodepos')
                ->select('*')
                ->where('pos_kelurahan','=',$request->kelurahan)
                ->first();
        }
        else {
            $data = DB::table('tbmaster_kodepos')
                ->select('*')
                ->where('pos_kode','=',$request->kode)
                ->where('pos_kecamatan','=',$request->kecamatan)
                ->where('pos_kelurahan','=',$request->kelurahan)
                ->first();
        }

        if($data == null){
            $data = 'not-found';
        }

        return response()->json($data);
    }

    public function lov_member_search(Request $request){
        if(!ctype_alpha($request->value)){
            $result = DB::table('tbmaster_customer')
                ->select('cus_kodemember','cus_namamember')
                ->where('cus_kodemember',$request->value)
                ->get();
        }
        else{
            $result = DB::table('tbmaster_customer')
                ->select('cus_kodemember','cus_namamember')
                ->where('cus_namamember','like','%'.$request->value.'%')
                ->orderBy('cus_namamember')
                ->limit(100)
                ->get();
        }

        return response()->json($result);
    }

    public function lov_kodepos_search(Request $request){
        $data = DB::table('tbmaster_kodepos')
            ->select('*')
            ->where('pos_kelurahan','=',$request->value)
            ->orderBy('pos_kecamatan')
            ->get();

        return response()->json($data);
    }

    public function set_status_member(Request $request){
        $data = DB::table('tbmaster_customer')
            ->where('cus_kodemember',$request->kode)
            ->update(['cus_recordid' => $request->status]);

        if($data)
            return 'success';
        else return 'failed';
    }

    public function check_password(Request $request){
        $data = DB::table('tbmaster_user')
            ->where('userid','=',$request->username)
            ->where('userpassword','=',$request->password)
            ->first();

        if($data != null){
            return 'ok';
        }
        else{
            return 'error';
        }
    }

    public function update_member(Request $request){
        $resultcus = false;
        $resultcrm = false;
        $insertHobby = false;
        $update_credit = false;
        $update_bank = false;

        $update_cus = [];
        $update_crm = [];
        $update_hobbydetail = [];
        $update_customerfasilitasbank = [];

        $kodemember = $request->customer['cus_kodemember'];
        $kodeigr = '22';

        $checkcus = DB::table('tbmaster_customer')
            ->where('cus_kodemember',$kodemember)
            ->first();

        if($checkcus){
            for($i=0;$i<sizeof($request->customer);$i++) {
                if (substr($request->keycustomer[$i], 0, 7) == 'cus_tgl')
                    $update_cus[$request->keycustomer[$i]] = DB::RAW("to_date('" . $request->customer[$request->keycustomer[$i]] . "','dd/mm/yyyy')");
                else $update_cus[$request->keycustomer[$i]] = $request->customer[$request->keycustomer[$i]];
            }
            $update_cus['cus_modify_by'] = 'LEO';
            $update_cus['cus_modify_dt'] = DB::raw('SYSDATE');

            for($i=0;$i<sizeof($request->customercrm);$i++){
                if(substr($request->keycustomercrm[$i],0,7) == 'crm_tgl')
                    $update_crm[$request->keycustomercrm[$i]] = DB::RAW("to_date('".$request->customercrm[$request->keycustomercrm[$i]]."','dd/mm/yyyy')");
                else $update_crm[$request->keycustomercrm[$i]] = $request->customercrm[$request->keycustomercrm[$i]];
            }
            $update_crm['crm_modify_by'] = 'LEO';
            $update_crm['crm_modify_dt'] = DB::raw('SYSDATE');

            if($request->hobby != null){
                for($i=0;$i<sizeof($request->hobby);$i++){
                    $update_hobbydetail[$i] = ['dhb_kodeigr' => $kodeigr, 'dhb_kodemember' => $kodemember, 'dhb_kodehobby' => $request->hobby[$i],'dhb_keterangan' => $request->hobby_ket[$i]];
                }
            }

            try{
                $resultcus = DB::table('tbmaster_customer')
                    ->where('cus_kodemember', '=',$kodemember)
                    ->update($update_cus);

                $checkcrm = DB::table('tbmaster_customercrm')
                    ->where('crm_kodemember','=',$kodemember)
                    ->first();

                if($checkcrm){
                    $resultcrm = DB::table('tbmaster_customercrm')
                        ->where('crm_kodemember', '=',$kodemember)
                        ->update($update_crm);
                }
                else{
                    $update_crm['crm_kodemember'] = $kodemember;
                    $resultcrm = DB::table('tbmaster_customercrm')
                        ->insert($update_crm);
                }

                $check = DB::table('tbhistory_creditlimit')
                    ->where('lmt_kodemember',$kodemember)
                    ->first();

                if($check){
                    $update_credit = DB::table('tbhistory_creditlimit')
                        ->where('lmt_kodemember',$kodemember)
                        ->update([
                            'lmt_nilai' => $request->customer['cus_creditlimit'],
                            'lmt_modify_by' => 'LEO',
                            'lmt_modify_dt' => DB::raw('SYSDATE')
                        ]);
                }
                else{
                    $update_credit = DB::table('tbhistory_creditlimit')
                        ->insert([
                            'lmt_kodeigr' => $kodeigr,
                            'lmt_kodemember' => $kodemember,
                            'lmt_nilai' => $request->customer['cus_creditlimit'],
                            'lmt_create_by' => 'LEO',
                            'lmt_create_dt' => DB::raw('SYSDATE')
                        ]);
                }

                DB::table('tbtabel_hobbydetail')
                    ->where('dhb_kodemember',$request->customer['cus_kodemember'])
                    ->delete();

                $insertHobby = DB::table('tbtabel_hobbydetail')
                    ->insert($update_hobbydetail);



                if(!empty($request->bank)){
                    if(sizeof($request->bank) == 1){
                        $update_customerfasilitasbank = ['cub_kodeigr' => $kodeigr, 'cub_kodemember' => $kodemember, 'cub_kodefasilitasbank' => $request->bank[0], 'cub_create_by' => 'LEO', 'cub_create_dt' => DB::RAW('SYSDATE')];

                    }
                    else{
                        for($i=0;$i<sizeof($request->bank);$i++){
                            $update_customerfasilitasbank[$i] = ['cub_kodeigr' => $kodeigr, 'cub_kodemember' => $kodemember, 'cub_kodefasilitasbank' => $request->bank[$i], 'cub_modify_by' => 'LEO', 'cub_modify_dt' => DB::RAW('SYSDATE')];
                        }
                    }
                }

                $checkbank = DB::table('tbmaster_customerfasilitasbank')
                    ->where('cub_kodemember',$kodemember)
                    ->first();

                if($checkbank){
                    $update_bank = DB::table('tbmaster_customerfasilitasbank')
                        ->where('cub_kodemember','=',$kodemember)
                        ->delete();
                }
                if(!empty($request->bank)) {
                    $update_bank = DB::table('tbmaster_customerfasilitasbank')
                        ->insert($update_customerfasilitasbank);
                }
                else{
                    $update_bank = true;
                }
            }
            catch (Exception $e){
                $status = 'failed';
                $message = 'Gagal menyimpan data member!';
            }
            if(!$resultcus || !$resultcrm || !$insertHobby || !$update_credit || !$update_bank){
                $status = 'failed';
                $message = 'Gagal menyimpan data member!';
            }
            else{
                $status = 'success';
                $message = 'Berhasil menyimpan data member!';
            }
        }
        else{
            $status = 'failed';
            $message = 'Data member tidak ditemukan!';
        }

        return compact(['status','message']);





//        return compact('resultcus','resultcrm','insertHobby','update_credit');

//
//
    }

    public function export_crm(Request $request){
        $resultcus = false;
        $resultcrm = false;

        $kodemember = $request->kodemember;
        $kodeigr = '22';

        $checkigr = DB::table('tbmaster_customer')
            ->select('cus_kodeigr')
            ->where('cus_kodemember',$kodemember)
            ->first();

        if($checkigr->cus_kodeigr == $kodeigr){
//            $checkcus = DB::table(DB::RAW('tbmaster_customer_interface@igrcrm'))
//                ->where('cus_kodemember',$kodemember)
//                ->first();
//            if($checkcus){
//                DB::table(DB::RAW('tbmaster_customer_interface@igrcrm'))
//                    ->where('cus_kodemember',$kodemember)
//                    ->delete();
//            }

//            $checkcrm = DB::table(DB::RAW('tbmaster_customercrm_interface@igrcrm'))
//                ->where('crm_kodemember',$kodemember)
//                ->first();
//            if($checkcrm){
//                DB::table(DB::RAW('tbmaster_customercrm_interface@igrcrm'))
//                    ->where('crm_kodemember',$kodemember)
//                    ->delete();
//            }

//            $exportcus = DB::table('tbmaster_customer')
//                ->where('cus_kodemember',$kodemember)
//                ->first();
//
//
//
//            if($exportcus){
//                $arrexportcus = (array) $exportcus;
//                $resultcus = DB::table(DB::RAW('tbmaster_customer_interface@igrcrm'))
//                    ->insert($arrexportcus);
//            }
//
//            $exportcrm = DB::table('tbmaster_customercrm')
//                ->where('crm_kodemember',$kodemember)
//                ->first();
//
//            if($exportcrm){
//                $arrexportcrm = (array) $exportcrm;
//                $resultcrm = DB::table(DB::RAW('tbmaster_customercrm_interface@igrcrm'))
//                    ->insert($arrexportcrm);
//            }

            $resultcus = true;
            $resultcrm = true;

            if($resultcus && $resultcrm){
                $status = 'success';
                $message = 'Berhasil export ke CRM!';
            }
            else{
                $status = 'failed';
                $message = 'Gagal export ke CRM!';
            }
        }
        else{
            $status = 'failed';
            $message = 'Member tidak sesuai dengan cabang anda!';
        }

        return compact(['status','message']);
    }

    public function mmm(){
        //        select distinct mstd_prdcd, prd_deskripsipendek, st_sales, st_saldoakhir, pkm_pkmt, prd_lastcost, prd_kodetag,
//          mstd_kodesupplier, sup_namasupplier
//		from tbtr_mstran_d, tbmaster_supplier, tbmaster_prodmast, tbmaster_stock, tbmaster_kkpkm,
//    	   tbtr_gondola, tbtr_pkmgondola
//		where mstd_kodeigr = :parameter.kodeigr
//        and mstd_kodesupplier = :kodesup
//        and sup_kodeigr = mstd_kodeigr
//        and sup_kodesupplier = mstd_kodesupplier
//        and prd_kodeigr = mstd_kodeigr
//        and prd_prdcd = mstd_prdcd
//        and st_kodeigr = mstd_kodeigr
//        and st_prdcd = mstd_prdcd
//        and st_lokasi = '01'
//        and pkm_kodeigr = mstd_kodeigr
//        and pkm_prdcd = mstd_prdcd
//        and gdl_kodeigr(+) = mstd_kodeigr
//        and gdl_prdcd(+) = mstd_prdcd
//        and pkmg_kodeigr(+) = mstd_kodeigr
//        and pkmg_prdcd(+) = mstd_prdcd
//   	order by mstd_prdcd


//        $data = DB::table('tbtr_mstran_d')
//            ->join('tbmaster_supplier',function($join){
//                $join->on('sup_kodeigr', '=', 'mstd_kodeigr')
//                    ->on('sup_kodesupplier', '=', 'mstd_kodesupplier');
//            })
//            ->join('tbmaster_prodmast',function($join){
//                $join->on('prd_kodeigr', '=', 'mstd_kodeigr')
//                    ->on('prd_prdcd', '=', 'mstd_prdcd');
//            })
//            ->join('tbmaster_stock',function($join){
//                $join->on('st_kodeigr', '=', 'mstd_kodeigr')
//                    ->on('st_prdcd', '=', 'mstd_prdcd');
//            })
//            ->join('tbmaster_kkpkm',function($join){
//                $join->on('pkm_kodeigr', '=', 'mstd_kodeigr')
//                    ->on('pkm_prdcd', '=', 'mstd_prdcd');
//            })
//            ->leftJoin('tbtr_gondola',function($join){
//                $join->on('gdl_kodeigr', '=', 'mstd_kodeigr')
//                    ->on('gdl_prdcd', '=', 'mstd_prdcd');
//            })
//            ->leftJoin('tbtr_pkmgondola',function($join){
//                $join->on('pkmg_prdcd', '=', 'mstd_prdcd')
//                    ->on('pkmg_kodeigr', '=', 'mstd_kodeigr');
//            })
//            ->SELECT("mstd_prdcd", "prd_deskripsipendek", "st_sales", "st_saldoakhir", "pkm_pkmt", "prd_lastcost", "prd_kodetag")
//            ->where('mstd_kodeigr','=','22')
//            ->where('mstd_kodesupplier','=','B0470')
//            ->where('st_lokasi','=','01')
//            ->distinct()
//            ->get();
//
//        dd($d);
    }
}
