<?php

namespace App\Http\Controllers\MASTER;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;
use Yajra\DataTables\DataTables;

class memberController extends Controller
{
    //

    public function index(){
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
            ->select('*')
            ->limit(100)
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

        $produkmember = DB::table('tbtabel_produkmember')
            ->select('mpm_kodeprdcd','mpm_namaprdcd')
            ->orderBy('mpm_kodeprdcd')
            ->get();

        return view('MASTER.member')->with(compact(['member','hobby','fasilitasperbankan','kodepos','jenismember','jenisoutlet','group','produkmember']));
    }

    public function getLovMember(Request  $request){
        $search = $request->value;

        $member = DB::table('tbmaster_customer')
            ->select('cus_kodemember', 'cus_namamember')
            ->where('cus_kodemember','LIKE', '%'.$search.'%')
            ->orWhere('cus_namamember','LIKE', '%'.$search.'%')
            ->orderBy('cus_namamember')
            ->limit(100)
            ->get();

        return Datatables::of($member)->make(true);
    }

    public function getLovKodepos(Request $request){
        $search = $request->value;

        $kodepos = DB::table('tbmaster_kodepos')
            ->select('*')
            ->where('pos_propinsi', 'like', '%'.$search.'%')
            ->orWhere('pos_kabupaten','LIKE', '%'.$search.'%')
            ->orWhere('pos_kecamatan','LIKE', '%'.$search.'%')
            ->orWhere('pos_kelurahan','LIKE', '%'.$search.'%')
            ->limit(100)
            ->get();

        return Datatables::of($kodepos)->make(true);
    }

    public function lov_suboutlet(Request $request){
        $data = DB::table('tbmaster_suboutlet')
            ->select('sub_kodesuboutlet','sub_namasuboutlet')
            ->where('sub_kodeoutlet','=',$request->outlet)
            ->orderBy('sub_kodesuboutlet')
            ->get();

        return response()->json($data);
    }

    public function lov_member_select(Request $request){
        $member = DB::table('tbmaster_customer')
            ->leftJoin('tbmaster_customercrm','crm_kodemember','=','cus_kodemember')
            ->selectRaw("cus_kodeigr, cus_recordid, cus_kodemember, cus_namamember, cus_alamatmember1, cus_alamatmember2, cus_alamatmember3, cus_alamatmember4,
                cus_tlpmember, cus_alamatmember5, cus_alamatmember6, cus_alamatmember7, cus_alamatmember8, cus_jenismember, cus_flagmemberkhusus, cus_jarak,
                cus_cfk, cus_kodeoutlet, cus_kodesuboutlet, cus_kodearea, cus_tglmulai, cus_tglregistrasi, cus_npwp, cus_flagpkp, cus_creditlimit, cus_top,
                cus_keterangan, cus_tglpajak, cus_nosalesman, cus_flaggantikartu, cus_nokartumember, cus_flagkredit, cus_flagblockingpengiriman, cus_flagbebasiuran,
                cus_tgllahir, cus_costcenter, cus_noaccount, cus_alamatemail, cus_hpmember, cus_flaginstitusipemerintah, cus_create_by, cus_create_dt, cus_modify_by,
                to_char(cus_modify_dt, 'dd/mm/yyyy hh24:mi:ss') cus_modify_dt, cus_getpoint, cus_flagkirimsms, cus_flag_uptodate, cus_nonaktif_dt, cus_flag_ina, cus_tglmulai_va, cus_noacc_va, cus_noktp,
                cus_flag_verifikasi, cus_flag_mypoin, cus_flag_isaku, cus_mypoin_dt, cus_isaku_dt, crm_recordid, crm_kodeigr, crm_kodemember, crm_jenisanggota,
                crm_jeniskelamin, crm_pic1, crm_nohppic1, crm_pic2, crm_nohppic2, crm_agama, crm_namapasangan, crm_tgllhrpasangan, crm_jmlanak, crm_pendidikanakhir,
                crm_nofax, crm_koordinat, crm_namabank, crm_jenisbangunan, crm_lamatmpt, crm_statusbangunan, crm_internet, crm_tipehp, crm_metodekirim,
                crm_kreditusaha, crm_bankkredit, crm_email, crm_group, crm_subgroup, crm_kategori, crm_subkategori, crm_pekerjaan, crm_tmptlahir,
                crm_alamatusaha1, crm_alamatusaha2, crm_alamatusaha3, crm_alamatusaha4, crm_idgroupkat, crm_idsegment, crm_motor, crm_mobil,
                crm_create_by, crm_create_dt, crm_modify_by, crm_modify_dt")
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

        if($outlet){
            $arrsuboutlet = DB::table('tbmaster_suboutlet')
                ->select('sub_kodesuboutlet','sub_namasuboutlet')
                ->where('sub_kodeoutlet','=',$outlet->out_kodeoutlet)
                ->orderBy('sub_kodesuboutlet')
                ->get();
        }
        else $arrsuboutlet = [];

        $suboutlet = DB::table('tbmaster_suboutlet')
            ->select('*')
            ->where('sub_kodesuboutlet','=',$member->cus_kodesuboutlet)
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

        $quisioner = '';
//        if($member->cus_flagmemberkhusus == 'Y' && $member->cus_recordid != null){
            $quisioner = DB::table('tbtabel_flagprodukmember')
                ->select('fpm_kodeprdcd','fpm_flagjual','fpm_flagbeliigr','fpm_flagbelilain')
                ->where('fpm_kodemember',$member->cus_kodemember)
//                    ->where('fpm_kodemember','578229')
                ->orderBy('fpm_kodeprdcd')
                ->get();
//        }

//        dd(compact(['member','ktp','surat','usaha','jenismember','outlet','group','bank','hobbymember','creditlimit','npwp','quisioner']));

        return compact(['member','ktp','surat','usaha','jenismember','outlet','arrsuboutlet','suboutlet','group','bank','hobbymember','creditlimit','npwp','quisioner']);
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
        try{
            DB::beginTransaction();
            $data = DB::table('tbmaster_customer')
                ->where('cus_kodemember',$request->kode)
                ->update(['cus_recordid' => $request->status]);

            DB::commit();
            return 'success';
        }
        catch (QueryException $e){
            DB::rollBack();
            return 'failed';
        }
    }

    public function check_password(Request $request){
        $data = DB::table('tbmaster_user')
            ->select('userlevel')
            ->where('userid','=',$request->username)
            ->where('userpassword','=',$request->password)
            ->first();

        if($data != null){
            if($data->userlevel == '1')
                return 'ok';
            else return 'userlevel';
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
        $userId = $_SESSION['usid'];

        $update_cus = [];
        $update_crm = [];
        $update_hobbydetail = [];
        $update_customerfasilitasbank = [];

        $kodemember = $request->customer['cus_kodemember'];
        $kodeigr = $_SESSION['kdigr'];

        $checkcus = DB::table('tbmaster_customer')
            ->where('cus_kodemember',$kodemember)
            ->first();

        if($checkcus){
            for($i=0;$i<sizeof($request->customer);$i++) {
                if (substr($request->keycustomer[$i], 0, 7) == 'cus_tgl')
                    $update_cus[$request->keycustomer[$i]] = DB::RAW("to_date('" . $request->customer[$request->keycustomer[$i]] . "','dd/mm/yyyy')");
                else $update_cus[$request->keycustomer[$i]] = $request->customer[$request->keycustomer[$i]];
            }
            $update_cus['cus_modify_by'] = $_SESSION['usid'];
            $update_cus['cus_modify_dt'] = DB::raw('SYSDATE');

            for($i=0;$i<sizeof($request->customercrm);$i++){
                if(substr($request->keycustomercrm[$i],0,7) == 'crm_tgl')
                    $update_crm[$request->keycustomercrm[$i]] = DB::RAW("to_date('".$request->customercrm[$request->keycustomercrm[$i]]."','dd/mm/yyyy')");
                else $update_crm[$request->keycustomercrm[$i]] = $request->customercrm[$request->keycustomercrm[$i]];
            }
            $update_crm['crm_modify_by'] = $_SESSION['usid'];
            $update_crm['crm_modify_dt'] = DB::raw('SYSDATE');

            if($request->hobby != null){
                for($i=0;$i<sizeof($request->hobby);$i++){
                    $update_hobbydetail[$i] = ['dhb_kodeigr' => $kodeigr, 'dhb_kodemember' => $kodemember, 'dhb_kodehobby' => $request->hobby[$i],'dhb_keterangan' => $request->hobby_ket[$i]];
                }
            }

            try{
                DB::beginTransaction();

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
                            'lmt_modify_by' => $userId,
                            'lmt_modify_dt' => DB::raw('SYSDATE')
                        ]);
                }
                else{
                    $update_credit = DB::table('tbhistory_creditlimit')
                        ->insert([
                            'lmt_kodeigr' => $kodeigr,
                            'lmt_kodemember' => $kodemember,
                            'lmt_nilai' => $request->customer['cus_creditlimit'],
                            'lmt_create_by' => $userId,
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
                        $update_customerfasilitasbank = ['cub_kodeigr' => $kodeigr, 'cub_kodemember' => $kodemember, 'cub_kodefasilitasbank' => $request->bank[0], 'cub_create_by' => $userId, 'cub_create_dt' => DB::RAW('SYSDATE')];

                    }
                    else{
                        for($i=0;$i<sizeof($request->bank);$i++){
                            $update_customerfasilitasbank[$i] = ['cub_kodeigr' => $kodeigr, 'cub_kodemember' => $kodemember, 'cub_kodefasilitasbank' => $request->bank[$i], 'cub_modify_by' => $userId, 'cub_modify_dt' => DB::RAW('SYSDATE')];
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

                $group = DB::table('tbtabel_groupkategori')->select('*')
                    ->where('grp_idgroupkat', $request->customercrm['crm_idgroupkat'])
                    ->first();

                if ($group){
                    DB::table('tbmaster_customercrm')->where('crm_kodemember', $kodemember)->where('crm_kodeigr', $kodeigr)
                        ->update(['crm_group' => $group->grp_group, 'crm_subgroup' => $group->grp_subgroup, 'crm_kategori' => $group->grp_kategori, 'crm_subkategori' => $group->grp_subkategori]);
                }

                $status = 'success';
                $message = 'Berhasil menyimpan data member!';
                DB::commit();
            }
            catch (QueryException $e){
                $status = 'failed';
                $message = 'Gagal menyimpan data member!';
                DB::rollBack();
            }
        }
        else{
            $status = 'failed';
            $message = 'Data member tidak ditemukan!';
        }

        return compact(['status','message']);
    }

    public function export_crm(Request $request){
        $resultcus = false;
        $resultcrm = false;

        $kodemember = $request->kodemember;
        $kodeigr = $_SESSION['kdigr'];

        $checkigr = DB::table('tbmaster_customer')
            ->select('cus_kodeigr')
            ->where('cus_kodemember',$kodemember)
            ->first();

        if($checkigr->cus_kodeigr != $kodeigr){
            $status = 'failed';
            $message = 'Member tidak sesuai dengan cabang anda!';
        }
        else {
//            sleep(3); // Dikoemen dlu karena langsung merubah table production igrcrm
            try {
                DB::beginTransaction();
//                $checkcus = DB::table(DB::RAW('tbmaster_customer_interface@igrcrm'))
                $checkcus = DB::connection('igrcrm')->table(DB::RAW('tbmaster_customer_testias'))
                    ->where('cus_kodemember', $kodemember)
                    ->first();
                if ($checkcus) {
//                    DB::table(DB::RAW('tbmaster_customer_interface@igrcrm'))
                    DB::connection('igrcrm')->table(DB::RAW('tbmaster_customer_testias'))
                        ->where('cus_kodemember', $kodemember)
                        ->delete();
                }

//                $checkcrm = DB::table(DB::RAW('tbmaster_customercrm_interface@igrcrm'))
                $checkcrm = DB::connection('igrcrm')->table(DB::RAW('tbmaster_customercrm_testias'))
                    ->where('crm_kodemember', $kodemember)
                    ->get()->toArray();

//                dd($checkcrm);
                if ($checkcrm) {
//                    DB::table(DB::RAW('tbmaster_customercrm_interface@igrcrm'))
                    DB::connection('igrcrm')->table(DB::RAW('tbmaster_customercrm_testias'))
                        ->where('crm_kodemember', $kodemember)
                        ->delete();
                }

                $exportcus = DB::table('tbmaster_customer')
                    ->where('cus_kodemember', $kodemember)
                    ->first();

                if ($exportcus) {
                    $arrexportcus = (array)$exportcus;
//                    $resultcus = DB::table(DB::RAW('tbmaster_customer_interface@igrcrm'))
                    $resultcus = DB::connection('igrcrm')->table(DB::RAW('tbmaster_customer_testias'))
                        ->insert($arrexportcus);
                }

                $exportcrm = DB::table('tbmaster_customercrm')
                    ->where('crm_kodemember', $kodemember)
                    ->first();

                if ($exportcrm) {
                    $arrexportcrm = (array)$exportcrm;
//                    $resultcrm = DB::table(DB::RAW('tbmaster_customercrm_interface@igrcrm'))
                    $resultcrm = DB::connection('igrcrm')->table(DB::RAW('tbmaster_customercrm_testias'))
                        ->insert($arrexportcrm);
                }

                if ($resultcus && $resultcrm) {
                    $status = 'success';
                    $message = 'Berhasil export ke CRM!';
                    DB::commit();
                } else {
                    $status = 'failed';
                    $message = 'Gagal export ke CRM!';

                }
            }
            catch (QueryException $e) {
                DB::rollBack();
                $status = 'failed';
                $message = $e->getMessage();
            }
        }

        return compact(['status','message']);
    }

    public function save_quisioner(Request $request){
        $arrquisioner = [];
        $quisioner = '';
        $kodemember = $request->arrdata[0]['fpm_kodemember'];

        $oldQuisioner = DB::table('tbtabel_flagprodukmember')
            ->where('fpm_kodemember',$kodemember)
            ->orderBy('fpm_kodeprdcd')
            ->get();

        try{
            DB::beginTransaction();

            DB::table('tbtabel_flagprodukmember')
                ->where('fpm_kodemember', $kodemember)
                ->delete();

            if(sizeof($oldQuisioner)){
                if(sizeof($oldQuisioner) == sizeof($request->arrdata)){
                    for($i=0;$i<sizeof($request->arrdata);$i++){
                        $quisioner = array(
                            'fpm_kodeigr' => '22',
                            'fpm_kodemember' => $request->arrdata[$i]['fpm_kodemember'],
                            'fpm_kodeprdcd' => $request->arrdata[$i]['fpm_kodeprdcd'],
                            'fpm_flagjual' => $request->arrdata[$i]['fpm_flagjual'],
                            'fpm_flagbeliigr' => $request->arrdata[$i]['fpm_flagbeliigr'],
                            'fpm_flagbelilain' => $request->arrdata[$i]['fpm_flagbelilain'],
                            'fpm_create_by' => $oldQuisioner[$i]->fpm_create_by,
                            'fpm_create_dt' => $oldQuisioner[$i]->fpm_create_dt,
                            'fpm_modify_by' => $_SESSION['usid'],
                            'fpm_modify_dt' => DB::RAW('sysdate')
                        );
                        $arrquisioner[] = $quisioner;

                        $insert = DB::table('tbtabel_flagprodukmember')
                            ->insert($quisioner);
                    }
                }
                else{
                    $j = 0;
                    for($i=0;$i<sizeof($request->arrdata);$i++){
                        if($request->arrdata[$i]['fpm_kodeprdcd'] == $oldQuisioner[$j]->fpm_kodeprdcd){
                            $quisioner = array(
                                'fpm_kodeigr' => '22',
                                'fpm_kodemember' => $request->arrdata[$i]['fpm_kodemember'],
                                'fpm_kodeprdcd' => $request->arrdata[$i]['fpm_kodeprdcd'],
                                'fpm_flagjual' => $request->arrdata[$i]['fpm_flagjual'],
                                'fpm_flagbeliigr' => $request->arrdata[$i]['fpm_flagbeliigr'],
                                'fpm_flagbelilain' => $request->arrdata[$i]['fpm_flagbelilain'],
                                'fpm_create_by' => $oldQuisioner[$i]->fpm_create_by,
                                'fpm_create_dt' => $oldQuisioner[$i]->fpm_create_dt,
                                'fpm_modify_by' => $_SESSION['usid'],
                                'fpm_modify_dt' => DB::RAW('sysdate')
                            );
                            if($j < sizeof($oldQuisioner) - 1)
                                $j++;
                        }
                        else{
                            $quisioner = array(
                                'fpm_kodeigr' => '22',
                                'fpm_kodemember' => $request->arrdata[$i]['fpm_kodemember'],
                                'fpm_kodeprdcd' => $request->arrdata[$i]['fpm_kodeprdcd'],
                                'fpm_flagjual' => $request->arrdata[$i]['fpm_flagjual'],
                                'fpm_flagbeliigr' => $request->arrdata[$i]['fpm_flagbeliigr'],
                                'fpm_flagbelilain' => $request->arrdata[$i]['fpm_flagbelilain'],
                                'fpm_create_by' => $_SESSION['usid'],
                                'fpm_create_dt' => DB::RAW('sysdate'),
                                'fpm_modify_by' => '',
                                'fpm_modify_dt' => ''
                            );
                        }
                        $arrquisioner[] = $quisioner;

                        $insert = DB::table('tbtabel_flagprodukmember')
                            ->insert($quisioner);
                    }
                }
            }
            else{
                for($i=0;$i<sizeof($request->arrdata);$i++){
                    $quisioner = array(
                        'fpm_kodeigr' => '22',
                        'fpm_kodemember' => $request->arrdata[$i]['fpm_kodemember'],
                        'fpm_kodeprdcd' => $request->arrdata[$i]['fpm_kodeprdcd'],
                        'fpm_flagjual' => $request->arrdata[$i]['fpm_flagjual'],
                        'fpm_flagbeliigr' => $request->arrdata[$i]['fpm_flagbeliigr'],
                        'fpm_flagbelilain' => $request->arrdata[$i]['fpm_flagbelilain'],
                        'fpm_create_by' => $_SESSION['usid'],
                        'fpm_create_dt' => DB::RAW('sysdate'),
                        'fpm_modify_by' => '',
                        'fpm_modify_dt' => ''
                    );
                    $arrquisioner[] = $quisioner;

                    $insert = DB::table('tbtabel_flagprodukmember')
                        ->insert($quisioner);
                }
            }

//            dd($arrquisioner);

//            $insert = DB::table('tbtabel_flagprodukmember')
//                ->insert($arrquisioner);

            DB::commit();
            $status = 'success';
            $message = 'Berhasil menyimpan data quisioner!';
        }
        catch (QueryException $e){
            dd($e->getMessage());
            DB::rollBack();
            $status = 'failed';
            $message = 'Gagal menyimpan data quisioner!';
        }

        return compact(['status','message']);
    }

    public function hapus_member(Request $request){
        $kodemember = $request->kodemember;

        $cus = DB::table('tbmaster_customer')
            ->select(
                'CUS_KODEIGR',
                'CUS_RECORDID',
                'CUS_KODEMEMBER',
                'CUS_NAMAMEMBER',
                'CUS_ALAMATMEMBER1',
                'CUS_ALAMATMEMBER2',
                'CUS_ALAMATMEMBER3',
                'CUS_ALAMATMEMBER4',
                'CUS_TLPMEMBER',
                'CUS_ALAMATMEMBER5',
                'CUS_ALAMATMEMBER6',
                'CUS_ALAMATMEMBER7',
                'CUS_ALAMATMEMBER8',
                'CUS_JENISMEMBER',
                'CUS_FLAGMEMBERKHUSUS',
                'CUS_JARAK',
                'CUS_CFK',
                'CUS_KODEOUTLET',
                'CUS_KODESUBOUTLET',
                'CUS_KODEAREA',
                'CUS_TGLMULAI',
                'CUS_TGLREGISTRASI',
                'CUS_NPWP',
                'CUS_FLAGPKP',
                'CUS_CREDITLIMIT',
                'CUS_TOP',
                'CUS_KETERANGAN',
                'CUS_TGLPAJAK',
                'CUS_NOSALESMAN',
                'CUS_FLAGGANTIKARTU',
                'CUS_NOKARTUMEMBER',
                'CUS_FLAGKREDIT',
                'CUS_FLAGBLOCKINGPENGIRIMAN',
                'CUS_FLAGBEBASIURAN',
                'CUS_TGLLAHIR',
                'CUS_COSTCENTER',
                'CUS_NOACCOUNT',
                'CUS_ALAMATEMAIL',
                'CUS_HPMEMBER',
                'CUS_FLAGINSTITUSIPEMERINTAH',
                'CUS_MODIFY_BY',
                'CUS_MODIFY_DT',
                'CUS_GETPOINT'
            )
            ->where('cus_kodemember',$kodemember)
            ->first();

        $cus = (array) $cus;
        $cus['cus_create_by'] = 'LEO';
        $cus['cus_create_dt'] = DB::RAW('sysdate');

        try{
            DB::beginTransaction();

            $insert = DB::table('tbhistory_deletecustomer')
                ->insert($cus);

            if($insert){
                $deletecus = DB::table('tbmaster_customer')
                    ->where('cus_kodemember',$kodemember)
                    ->delete();

                $deletecrm = DB::table('tbmaster_customercrm')
                    ->where('crm_kodemember',$kodemember)
                    ->delete();

                $deletecub = DB::table('tbmaster_customerfasilitasbank')
                    ->where('cub_kodemember',$kodemember)
                    ->delete();
            }

            DB::commit();
            $status = 'success';
            $message = 'Berhasil menghapus data member!';
        }
        catch (QueryException $e){
            DB::rollBack();
            $status = 'success';
            $message = 'Berhasil menghapus data member!';
        }

        return compact(['status','message']);
    }

    public function download_mktho(Request $request){
        $connection = oci_connect('simsmg', 'simsmg','(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST=192.168.237.193)(PORT=1521)) (CONNECT_DATA=(SERVER=DEDICATED) (SERVICE_NAME = simsmg)))');

        $exec = oci_parse($connection, "BEGIN  sp_download_customer_mktho_web(:sukses,:errm); END;"); //Diganti karna proc yg asli pakai boolean
        oci_bind_by_name($exec, ':sukses',$sukses,100);
        oci_bind_by_name($exec, ':errm', $errm,1000);
        oci_execute($exec);

        if (!$sukses){
            return response()->json(['kode' => 0, 'msg' => "Download Data Gagal", 'data' => '']);
        }

        return response()->json(['kode' => 1, "msg" => "Download Data Berhasil", 'data' =>'']);
    }

    public function check_registrasi(Request $request){
        $kodeMember = $request->kodemember;
        date_default_timezone_set('Asia/Jakarta');
        $date   = date('Y-m-d H:i:s');

        try{
            $temp = DB::table('tbmaster_customer')
                ->where('cus_kodemember', $kodeMember)
                ->whereNotIn('cus_namamember', ['NEW'])
                ->whereNotNull('cus_tglregistrasi')
                ->get();

            $tglmulai = DB::table('tbmaster_customer')
                ->select('cus_tglmulai')
                ->where('cus_kodemember', $kodeMember)
                ->first();

            $tglmulai = (!$tglmulai->cus_tglmulai) ? $date : $tglmulai->cus_tglmulai;

            if ($temp){
                return response()->json(['kode' => 1, "msg" => "Tgl registrasi sudah terisi", 'data' =>'']);
            } else {
                DB::table('tbmaster_customer')
                    ->where('cus_kodemember', $kodeMember)
                    ->update(['cus_tglregistrasi' => $tglmulai]);
            }

            return response()->json(['kode' => 1, 'msg' => "Tgl registrasi berhasil diisi", 'data' =>'']);
        }catch (\Exception $e){
            return response()->json(['kode' => 0, 'msg' => "Gagal update : ".$e->getMessage() , 'data' =>'']);
        }
    }
}
