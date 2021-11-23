<?php

namespace App\Http\Controllers\MASTER;

use App\Http\Controllers\Auth\loginController;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;
use Yajra\DataTables\DataTables;

class MemberController extends Controller
{
    //

    public function index(){
        $member = DB::connection($_SESSION['connection'])->table('tbmaster_customer')
            ->select('*')
            ->where(DB::RAW('ROWNUM'),'<=','100')
            ->orderBy('cus_namamember')
            ->limit(100)
            ->get();

        $hobby = DB::connection($_SESSION['connection'])->table('tbtabel_hobby')
            ->select('*')
            ->get();

        $kodepos = DB::connection($_SESSION['connection'])->table('tbmaster_kodepos')
            ->select('*')
            ->limit(100)
            ->get();

        $fasilitasperbankan = DB::connection($_SESSION['connection'])->table('tbmaster_fasilitasperbankan')
            ->get();

        $jenismember = DB::connection($_SESSION['connection'])->table('tbmaster_jenismember')
            ->select('jm_kode','jm_keterangan')
            ->orderBy('jm_keterangan')
            ->get();

        $jenisoutlet = DB::connection($_SESSION['connection'])->table('tbmaster_outlet')
            ->select('out_kodeoutlet','out_namaoutlet')
            ->orderBy('out_kodeoutlet')
            ->get();

        $group = DB::connection($_SESSION['connection'])->table('tbtabel_groupkategori')
            ->select('grp_group','grp_subgroup','grp_kategori','grp_subkategori','grp_idgroupkat')
            ->orderBy('grp_group')
            ->get();

        $produkmember = DB::connection($_SESSION['connection'])->table('tbtabel_produkmember')
            ->select('mpm_kodeprdcd','mpm_namaprdcd')
            ->orderBy('mpm_kodeprdcd')
            ->get();

        return view('MASTER.member')->with(compact(['member','hobby','fasilitasperbankan','kodepos','jenismember','jenisoutlet','group','produkmember']));
    }

    public function getLovMember(Request  $request){
        $search = $request->value;

        $member = DB::connection($_SESSION['connection'])->table('tbmaster_customer')
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

        $kodepos = DB::connection($_SESSION['connection'])->table('tbmaster_kodepos')
            ->select('*')
            ->where('pos_propinsi', 'like', '%'.$search.'%')
            ->orWhere('pos_kabupaten','LIKE', '%'.$search.'%')
            ->orWhere('pos_kecamatan','LIKE', '%'.$search.'%')
            ->orWhere('pos_kelurahan','LIKE', '%'.$search.'%')
            ->limit(100)
            ->get();

        return Datatables::of($kodepos)->make(true);
    }

    public function lovSuboutlet(Request $request){
        $data = DB::connection($_SESSION['connection'])->table('tbmaster_suboutlet')
            ->select('sub_kodesuboutlet','sub_namasuboutlet')
            ->where('sub_kodeoutlet','=',$request->outlet)
            ->orderBy('sub_kodesuboutlet')
            ->get();

        return response()->json($data);
    }

    public function lovMemberSelect(Request $request){
        $member = DB::connection($_SESSION['connection'])->table('tbmaster_customer')
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
            $ktp = DB::connection($_SESSION['connection'])->table('tbmaster_kodepos')
                ->select('*')
                ->where('pos_kode','=',$member->cus_alamatmember3)
                ->where('pos_kelurahan','=',$member->cus_alamatmember4)
                ->first();
        }
        else if($member->cus_alamatmember3 != '' && $member->cus_alamatmember3 != null){
            $ktp = DB::connection($_SESSION['connection'])->table('tbmaster_kodepos')
                ->select('*')
                ->where('pos_kode','=',$member->cus_alamatmember3)
                ->first();
        }
        else $ktp = '';

        if($member->cus_alamatmember8 != '' && $member->cus_alamatmember8 != null) {
            $surat = DB::connection($_SESSION['connection'])->table('tbmaster_kodepos')
                ->select('*')
                ->where('pos_kode', '=', $member->cus_alamatmember7)
                ->where('pos_kelurahan', '=', $member->cus_alamatmember8)
                ->first();
        }
        else if($member->cus_alamatmember7 != '' && $member->cus_alamatmember7 != null){
            $surat = DB::connection($_SESSION['connection'])->table('tbmaster_kodepos')
                ->select('*')
                ->where('pos_kode', '=', $member->cus_alamatmember7)
                ->first();
        }
        else $surat = '';

        if($member->crm_kodemember != '' && $member->crm_alamatusaha3 != null && $member->crm_alamatusaha4 != null){
            $usaha = DB::connection($_SESSION['connection'])->table('tbmaster_kodepos')
                ->select('*')
                ->where('pos_kode','=',$member->crm_alamatusaha3)
                ->where('pos_kelurahan','=',$member->crm_alamatusaha4)
                ->first();
        }
        else{
            $usaha = '';
        }

        if($member->crm_idgroupkat != '' && $member->crm_idgroupkat != null){
            $group = DB::connection($_SESSION['connection'])->table('tbtabel_groupkategori')
                ->select('*')
                ->where('grp_idgroupkat','=',$member->crm_idgroupkat)
                ->first();
        }
        else{
            $group = '';
        }

        $jenismember = DB::connection($_SESSION['connection'])->table('tbmaster_jenismember')
            ->select('*')
            ->where('jm_kode','=',$member->cus_jenismember)
            ->first();

        $outlet = DB::connection($_SESSION['connection'])->table('tbmaster_outlet')
            ->select('*')
            ->where('out_kodeoutlet','=',$member->cus_kodeoutlet)
            ->first();

        if($outlet){
            $arrsuboutlet = DB::connection($_SESSION['connection'])->table('tbmaster_suboutlet')
                ->select('sub_kodesuboutlet','sub_namasuboutlet')
                ->where('sub_kodeoutlet','=',$outlet->out_kodeoutlet)
                ->orderBy('sub_kodesuboutlet')
                ->get();
        }
        else $arrsuboutlet = [];

        $suboutlet = DB::connection($_SESSION['connection'])->table('tbmaster_suboutlet')
            ->select('*')
            ->where('sub_kodesuboutlet','=',$member->cus_kodesuboutlet)
            ->first();

        $bank = DB::connection($_SESSION['connection'])->table('tbmaster_customerfasilitasbank')
            ->select('*')
            ->where('cub_kodemember','=',$request->value)
            ->get();

        $hobbymember = DB::connection($_SESSION['connection'])->table('tbtabel_hobbydetail')
            ->select('*')
            ->where('dhb_kodemember','=',$member->cus_kodemember)
            ->get();

        $creditlimit = DB::connection($_SESSION['connection'])->table('tbhistory_creditlimit')
            ->select('*')
            ->where('lmt_kodemember','=',$member->cus_kodemember)
            ->get();

        $npwp = DB::connection($_SESSION['connection'])->table('tbmaster_npwp')
            ->select('*')
            ->where('pwp_kodemember','=',$member->cus_kodemember)
            ->first();

        $quisioner = '';
//        if($member->cus_flagmemberkhusus == 'Y' && $member->cus_recordid != null){
            $quisioner = DB::connection($_SESSION['connection'])->table('tbtabel_flagprodukmember')
                ->select('fpm_kodeprdcd','fpm_flagjual','fpm_flagbeliigr','fpm_flagbelilain')
                ->where('fpm_kodemember',$member->cus_kodemember)
//                    ->where('fpm_kodemember','578229')
                ->orderBy('fpm_kodeprdcd')
                ->get();
//        }

//        dd(compact(['member','ktp','surat','usaha','jenismember','outlet','group','bank','hobbymember','creditlimit','npwp','quisioner']));

        return compact(['member','ktp','surat','usaha','jenismember','outlet','arrsuboutlet','suboutlet','group','bank','hobbymember','creditlimit','npwp','quisioner']);
    }

    public function lovKodeposSelect(Request $request){
        if($request->kode == 'x' && $request->kecamatan == 'x' && $request->kabupaten == 'x'){
            $data = DB::connection($_SESSION['connection'])->table('tbmaster_kodepos')
                ->select('*')
                ->where('pos_kelurahan','=',$request->kelurahan)
                ->first();
        }
        else {
            $data = DB::connection($_SESSION['connection'])->table('tbmaster_kodepos')
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

    public function lovMemberSearch(Request $request){
        if(!ctype_alpha($request->value)){
            $result = DB::connection($_SESSION['connection'])->table('tbmaster_customer')
                ->select('cus_kodemember','cus_namamember')
                ->where('cus_kodemember',$request->value)
                ->get();
        }
        else{
            $result = DB::connection($_SESSION['connection'])->table('tbmaster_customer')
                ->select('cus_kodemember','cus_namamember')
                ->where('cus_namamember','like','%'.$request->value.'%')
                ->orderBy('cus_namamember')
                ->limit(100)
                ->get();
        }

        return response()->json($result);
    }

    public function lovKodeposSearch(Request $request){
        $data = DB::connection($_SESSION['connection'])->table('tbmaster_kodepos')
            ->select('*')
            ->where('pos_kelurahan','=',$request->value)
            ->orderBy('pos_kecamatan')
            ->get();

        return response()->json($data);
    }

    public function setStatusMember(Request $request){
        try{
            DB::connection($_SESSION['connection'])->beginTransaction();
            $data = DB::connection($_SESSION['connection'])->table('tbmaster_customer')
                ->where('cus_kodemember',$request->kode)
                ->update(['cus_recordid' => $request->status]);

            DB::connection($_SESSION['connection'])->commit();
            return 'success';
        }
        catch (QueryException $e){
            DB::connection($_SESSION['connection'])->rollBack();
            return 'failed';
        }
    }

    public function checkPassword(Request $request){
        sleep(1);
        $data = DB::connection($_SESSION['connection'])->table('tbmaster_user')
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

    public function updateMember(Request $request){
        sleep(1);
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

        $checkcus = DB::connection($_SESSION['connection'])->table('tbmaster_customer')
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
            $update_crm['crm_kodeigr'] = $_SESSION['kdigr'];

            if($request->hobby != null){
                for($i=0;$i<sizeof($request->hobby);$i++){
                    $update_hobbydetail[$i] = ['dhb_kodeigr' => $kodeigr, 'dhb_kodemember' => $kodemember, 'dhb_kodehobby' => $request->hobby[$i],'dhb_keterangan' => $request->hobby_ket[$i]];
                }
            }

            try{
                DB::connection($_SESSION['connection'])->beginTransaction();

                $resultcus = DB::connection($_SESSION['connection'])->table('tbmaster_customer')
                    ->where('cus_kodemember', '=',$kodemember)
                    ->update($update_cus);

                $checkcrm = DB::connection($_SESSION['connection'])->table('tbmaster_customercrm')
                    ->where('crm_kodemember','=',$kodemember)
                    ->first();

                if($checkcrm){
                    $resultcrm = DB::connection($_SESSION['connection'])->table('tbmaster_customercrm')
                        ->where('crm_kodemember', '=',$kodemember)
                        ->update($update_crm);
                }
                else{
                    $update_crm['crm_kodemember'] = $kodemember;
                    $resultcrm = DB::connection($_SESSION['connection'])->table('tbmaster_customercrm')
                        ->insert($update_crm);
                }

                $check = DB::connection($_SESSION['connection'])->table('tbhistory_creditlimit')
                    ->where('lmt_kodemember',$kodemember)
                    ->first();

                if($check){
                    $update_credit = DB::connection($_SESSION['connection'])->table('tbhistory_creditlimit')
                        ->where('lmt_kodemember',$kodemember)
                        ->update([
                            'lmt_nilai' => $request->customer['cus_creditlimit'],
                            'lmt_modify_by' => $userId,
                            'lmt_modify_dt' => DB::raw('SYSDATE')
                        ]);
                }
                else{
                    $update_credit = DB::connection($_SESSION['connection'])->table('tbhistory_creditlimit')
                        ->insert([
                            'lmt_kodeigr' => $kodeigr,
                            'lmt_kodemember' => $kodemember,
                            'lmt_nilai' => $request->customer['cus_creditlimit'],
                            'lmt_create_by' => $userId,
                            'lmt_create_dt' => DB::raw('SYSDATE')
                        ]);
                }

                DB::connection($_SESSION['connection'])->table('tbtabel_hobbydetail')
                    ->where('dhb_kodemember',$request->customer['cus_kodemember'])
                    ->delete();

                $insertHobby = DB::connection($_SESSION['connection'])->table('tbtabel_hobbydetail')
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

                $checkbank = DB::connection($_SESSION['connection'])->table('tbmaster_customerfasilitasbank')
                    ->where('cub_kodemember',$kodemember)
                    ->first();

                if($checkbank){
                    $update_bank = DB::connection($_SESSION['connection'])->table('tbmaster_customerfasilitasbank')
                        ->where('cub_kodemember','=',$kodemember)
                        ->delete();
                }
                if(!empty($request->bank)) {
                    $update_bank = DB::connection($_SESSION['connection'])->table('tbmaster_customerfasilitasbank')
                        ->insert($update_customerfasilitasbank);
                }
                else{
                    $update_bank = true;
                }

                $group = DB::connection($_SESSION['connection'])->table('tbtabel_groupkategori')->select('*')
                    ->where('grp_idgroupkat', $request->customercrm['crm_idgroupkat'])
                    ->first();

                if ($group){
                    DB::connection($_SESSION['connection'])->table('tbmaster_customercrm')->where('crm_kodemember', $kodemember)->where('crm_kodeigr', $kodeigr)
                        ->update(['crm_group' => $group->grp_group, 'crm_subgroup' => $group->grp_subgroup, 'crm_kategori' => $group->grp_kategori, 'crm_subkategori' => $group->grp_subkategori]);
                }

                $status = 'success';
                $message = 'Berhasil menyimpan data member!';
                DB::connection($_SESSION['connection'])->commit();
            }
            catch (QueryException $e){
                $status = 'failed';
                $message = 'Gagal menyimpan data member!';
                DB::connection($_SESSION['connection'])->rollBack();
            }
        }
        else{
            $status = 'failed';
            $message = 'Data member tidak ditemukan!';
        }

        return compact(['status','message']);
    }

    public function exportCRM(Request $request){
        try{
            $kodemember = $request->kodemember;

            DB::connection('igrcrm')->beginTransaction();

            DB::connection('igrcrm')
                ->table('tbmaster_customer_interface')
                ->where('cus_kodemember','=',$kodemember)
                ->delete();

            DB::connection('igrcrm')
                ->table('tbmaster_customercrm_interface')
                ->where('crm_kodemember','=',$kodemember)
                ->delete();

            $cus = DB::connection($_SESSION['connection'])
                ->table('tbmaster_customer')
                ->where('cus_kodemember','=',$kodemember)
                ->first();

            $tbmaster_customer = DB::connection('igrcrm')
                ->table('tbmaster_customer_interface')
                ->insert([
                    'cus_kodeigr' => $cus->cus_kodeigr,
                    'cus_recordid' => $cus->cus_recordid,
                    'cus_kodemember' => $cus->cus_kodemember,
                    'cus_namamember' => $cus->cus_namamember,
                    'cus_alamatmember1' => $cus->cus_alamatmember1,
                    'cus_alamatmember2' => $cus->cus_alamatmember2,
                    'cus_alamatmember3' => $cus->cus_alamatmember3,
                    'cus_alamatmember4' => $cus->cus_alamatmember4,
                    'cus_tlpmember' => $cus->cus_tlpmember,
                    'cus_alamatmember5' => $cus->cus_alamatmember5,
                    'cus_alamatmember6' => $cus->cus_alamatmember6,
                    'cus_alamatmember7' => $cus->cus_alamatmember7,
                    'cus_alamatmember8' => $cus->cus_alamatmember8,
                    'cus_jenismember' => $cus->cus_jenismember,
                    'cus_flagmemberkhusus' => $cus->cus_flagmemberkhusus,
                    'cus_jarak' => $cus->cus_jarak,
                    'cus_cfk' => $cus->cus_cfk,
                    'cus_kodeoutlet' => $cus->cus_kodeoutlet,
                    'cus_kodesuboutlet' => $cus->cus_kodesuboutlet,
                    'cus_kodearea' => $cus->cus_kodearea,
                    'cus_tglmulai' => $cus->cus_tglmulai,
                    'cus_tglregistrasi' => $cus->cus_tglregistrasi,
                    'cus_npwp' => $cus->cus_npwp,
                    'cus_flagpkp' => $cus->cus_flagpkp,
                    'cus_creditlimit' => $cus->cus_creditlimit,
                    'cus_top' => $cus->cus_top,
                    'cus_keterangan' => $cus->cus_keterangan,
                    'cus_tglpajak' => $cus->cus_tglpajak,
                    'cus_nosalesman' => $cus->cus_nosalesman,
                    'cus_flaggantikartu' => $cus->cus_flaggantikartu,
                    'cus_nokartumember' => $cus->cus_nokartumember,
                    'cus_flagkredit' => $cus->cus_flagkredit,
                    'cus_flagblockingpengiriman' => $cus->cus_flagblockingpengiriman,
                    'cus_flagbebasiuran' => $cus->cus_flagbebasiuran,
                    'cus_tgllahir' => $cus->cus_tgllahir,
                    'cus_costcenter' => $cus->cus_costcenter,
                    'cus_noaccount' => $cus->cus_noaccount,
                    'cus_alamatemail' => $cus->cus_alamatemail,
                    'cus_hpmember' => $cus->cus_hpmember,
                    'cus_flaginstitusipemerintah' => $cus->cus_flaginstitusipemerintah,
                    'cus_create_by' => $cus->cus_create_by,
                    'cus_create_dt' => $cus->cus_create_dt,
                    'cus_modify_by' => $cus->cus_modify_by,
                    'cus_modify_dt' => $cus->cus_modify_dt,
                    'cus_getpoint' => $cus->cus_getpoint,
                    'cus_flagkirimsms' => $cus->cus_flagkirimsms,
                    'cus_source' => 'manual',
                    'cus_tgl_upload' => carbon::now(),
                    'cus_user_upload' => $_SESSION['usid'],
                    'cus_flag_uptodate' => $cus->cus_flag_uptodate,
                    'cus_nonaktif_dt' => $cus->cus_nonaktif_dt,
                    'cus_flag_ina' => $cus->cus_flag_ina,
                    'cus_tglmulai_va' => $cus->cus_tglmulai_va,
                    'cus_noacc_va' => $cus->cus_noacc_va,
                    'cus_noktp' => $cus->cus_noktp,
                    'cus_flag_verifikasi' => $cus->cus_flag_verifikasi,
                    'cus_flag_mypoin' => $cus->cus_flag_mypoin,
                    'cus_flag_isaku' => $cus->cus_flag_isaku
                ]);

            $crm = DB::connection($_SESSION['connection'])
                ->table('tbmaster_customercrm')
                ->where('crm_kodemember','=',$kodemember)
                ->first();

            $tbmaster_customercrm = DB::connection('igrcrm')
                ->table('tbmaster_customercrm_interface')
                ->insert([
                    'crm_recordid' => $crm->crm_recordid,
                    'crm_kodeigr' => $crm->crm_kodeigr,
                    'crm_kodemember' => $crm->crm_kodemember,
                    'crm_jenisanggota' => $crm->crm_jenisanggota,
                    'crm_jeniskelamin' => $crm->crm_jeniskelamin,
                    'crm_pic1' => $crm->crm_pic1,
                    'crm_nohppic1' => $crm->crm_nohppic1,
                    'crm_pic2' => $crm->crm_pic2,
                    'crm_nohppic2' => $crm->crm_nohppic2,
                    'crm_agama' => $crm->crm_agama,
                    'crm_namapasangan' => $crm->crm_namapasangan,
                    'crm_tgllhrpasangan' => $crm->crm_tgllhrpasangan,
                    'crm_jmlanak' => $crm->crm_jmlanak,
                    'crm_pendidikanakhir' => $crm->crm_pendidikanakhir,
                    'crm_nofax' => $crm->crm_nofax,
                    'crm_koordinat' => $crm->crm_koordinat,
                    'crm_namabank' => $crm->crm_namabank,
                    'crm_jenisbangunan' => $crm->crm_jenisbangunan,
                    'crm_lamatmpt' => $crm->crm_lamatmpt,
                    'crm_statusbangunan' => $crm->crm_statusbangunan,
                    'crm_internet' => $crm->crm_internet,
                    'crm_tipehp' => $crm->crm_tipehp,
                    'crm_metodekirim' => $crm->crm_metodekirim,
                    'crm_kreditusaha' => $crm->crm_kreditusaha,
                    'crm_bankkredit' => $crm->crm_bankkredit,
                    'crm_email' => $crm->crm_email,
                    'crm_group' => $crm->crm_group,
                    'crm_subgroup' => $crm->crm_subgroup,
                    'crm_kategori' => $crm->crm_kategori,
                    'crm_subkategori' => $crm->crm_subkategori,
                    'crm_pekerjaan' => $crm->crm_pekerjaan,
                    'crm_tmptlahir' => $crm->crm_tmptlahir,
                    'crm_alamatusaha1' => $crm->crm_alamatusaha1,
                    'crm_alamatusaha2' => $crm->crm_alamatusaha2,
                    'crm_alamatusaha3' => $crm->crm_alamatusaha3,
                    'crm_alamatusaha4' => $crm->crm_alamatusaha4,
                    'crm_create_by' => $crm->crm_create_by,
                    'crm_create_dt' => $crm->crm_create_dt,
                    'crm_modify_by' => $crm->crm_modify_by,
                    'crm_modify_dt' => $crm->crm_modify_dt,
                    'crm_idgroupkat' => $crm->crm_idgroupkat,
                    'crm_idsegment' => $crm->crm_idsegment,
                    'crm_source' => 'MANUAL',
                    'crm_tgl_upload' => Carbon::now(),
                    'crm_user_upload' => $_SESSION['usid']
                ]);

            if($tbmaster_customer && $tbmaster_customercrm){
                DB::connection('igrcrm')->commit();

                return response()->json([
                    'status' => 'success',
                    'message' => 'Berhasil export ke CRM!'
                ], 200);
            }
            else{
                DB::connection('igrcrm')->rollBack();

                return response()->json([
                    'status' => 'failed',
                    'message' => 'Gagal export ke CRM!'
                ], 200);
            }
        }
        catch(\Exception $e){
            DB::connection('igrcrm')->rollBack();

            return response()->json([
                'status' => 'failed',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function exportCRMOld(Request $request){
        $resultcus = false;
        $resultcrm = false;

        $kodemember = $request->kodemember;
        $kodeigr = $_SESSION['kdigr'];

        $checkigr = DB::connection($_SESSION['connection'])->table('tbmaster_customer')
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
                DB::connection('igrcrm')->beginTransaction();
//                $checkcus = DB::connection($_SESSION['connection'])->table(DB::RAW('tbmaster_customer_interface@igrcrm'))
                $checkcus = DB::connection('igrcrm')
                    ->table(DB::RAW('tbmaster_customer_testias'))
                    ->where('cus_kodemember', $kodemember)
                    ->first();
                if ($checkcus) {
//                    DB::connection($_SESSION['connection'])->table(DB::RAW('tbmaster_customer_interface@igrcrm'))
                    DB::connection('igrcrm')
                        ->table(DB::RAW('tbmaster_customer_testias'))
                        ->where('cus_kodemember', $kodemember)
                        ->delete();
                }

//                $checkcrm = DB::connection($_SESSION['connection'])->table(DB::RAW('tbmaster_customercrm_interface@igrcrm'))
                $checkcrm = DB::connection('igrcrm')
                    ->table(DB::RAW('tbmaster_customercrm_testias'))
                    ->where('crm_kodemember', $kodemember)
                    ->get()->toArray();

//                dd($checkcrm);
                if ($checkcrm) {
//                    DB::connection($_SESSION['connection'])->table(DB::RAW('tbmaster_customercrm_interface@igrcrm'))
                    DB::connection('igrcrm')
                        ->table(DB::RAW('tbmaster_customercrm_testias'))
                        ->where('crm_kodemember', $kodemember)
                        ->delete();
                }

                $exportcus = DB::connection($_SESSION['connection'])
                    ->table('tbmaster_customer')
                    ->where('cus_kodemember', $kodemember)
                    ->first();

                if ($exportcus) {
                    $arrexportcus = (array)$exportcus;
//                    $resultcus = DB::connection($_SESSION['connection'])->table(DB::RAW('tbmaster_customer_interface@igrcrm'))
                    $resultcus = DB::connection('igrcrm')
                        ->table(DB::RAW('tbmaster_customer_testias'))
                        ->insert($arrexportcus);
                }

                $exportcrm = DB::connection($_SESSION['connection'])
                    ->table('tbmaster_customercrm')
                    ->where('crm_kodemember', $kodemember)
                    ->first();

                if ($exportcrm) {
                    $arrexportcrm = (array)$exportcrm;
//                    $resultcrm = DB::connection($_SESSION['connection'])->table(DB::RAW('tbmaster_customercrm_interface@igrcrm'))
                    $resultcrm = DB::connection('igrcrm')
                        ->table(DB::RAW('tbmaster_customercrm_testias'))
                        ->insert($arrexportcrm);
                }

                if ($resultcus && $resultcrm) {
                    $status = 'success';
                    $message = 'Berhasil export ke CRM!';
//                    DB::connection('igrcrm')->commit();
                } else {
                    $status = 'failed';
                    $message = 'Gagal export ke CRM!';

                }
            }
            catch (QueryException $e) {
                DB::connection('igrcrm')->rollBack();
                $status = 'failed';
                $message = $e->getMessage();
            }
        }

        return compact(['status','message']);
    }

    public function saveQuisioner(Request $request){
        $arrquisioner = [];
        $quisioner = '';
        $kodemember = $request->arrdata[0]['fpm_kodemember'];

        $oldQuisioner = DB::connection($_SESSION['connection'])->table('tbtabel_flagprodukmember')
            ->where('fpm_kodemember',$kodemember)
            ->orderBy('fpm_kodeprdcd')
            ->get();

        try{
            DB::connection($_SESSION['connection'])->beginTransaction();

            DB::connection($_SESSION['connection'])->table('tbtabel_flagprodukmember')
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

                        $insert = DB::connection($_SESSION['connection'])->table('tbtabel_flagprodukmember')
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

                        $insert = DB::connection($_SESSION['connection'])->table('tbtabel_flagprodukmember')
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

                    $insert = DB::connection($_SESSION['connection'])->table('tbtabel_flagprodukmember')
                        ->insert($quisioner);
                }
            }

//            dd($arrquisioner);

//            $insert = DB::connection($_SESSION['connection'])->table('tbtabel_flagprodukmember')
//                ->insert($arrquisioner);

            DB::connection($_SESSION['connection'])->commit();
            $status = 'success';
            $message = 'Berhasil menyimpan data quisioner!';
        }
        catch (QueryException $e){
            dd($e->getMessage());
            DB::connection($_SESSION['connection'])->rollBack();
            $status = 'failed';
            $message = 'Gagal menyimpan data quisioner!';
        }

        return compact(['status','message']);
    }

    public function deleteMember(Request $request){
        $kodemember = $request->kodemember;

        $cus = DB::connection($_SESSION['connection'])->table('tbmaster_customer')
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
            DB::connection($_SESSION['connection'])->beginTransaction();

            $insert = DB::connection($_SESSION['connection'])->table('tbhistory_deletecustomer')
                ->insert($cus);

            if($insert){
                $deletecus = DB::connection($_SESSION['connection'])->table('tbmaster_customer')
                    ->where('cus_kodemember',$kodemember)
                    ->delete();

                $deletecrm = DB::connection($_SESSION['connection'])->table('tbmaster_customercrm')
                    ->where('crm_kodemember',$kodemember)
                    ->delete();

                $deletecub = DB::connection($_SESSION['connection'])->table('tbmaster_customerfasilitasbank')
                    ->where('cub_kodemember',$kodemember)
                    ->delete();
            }

            DB::connection($_SESSION['connection'])->commit();
            $status = 'success';
            $message = 'Berhasil menghapus data member!';
        }
        catch (QueryException $e){
            DB::connection($_SESSION['connection'])->rollBack();
            $status = 'success';
            $message = 'Berhasil menghapus data member!';
        }

        return compact(['status','message']);
    }

    public function downloadMktho(Request $request){
        $connection = loginController::getConnectionProcedure();

        $exec = oci_parse($connection, "BEGIN  sp_download_customer_mktho_web(:sukses,:errm); END;"); //Diganti karna proc yg asli pakai boolean
        oci_bind_by_name($exec, ':sukses',$sukses,100);
        oci_bind_by_name($exec, ':errm', $errm,1000);
        oci_execute($exec);

        if (!$sukses){
            return response()->json(['kode' => 0, 'msg' => "Download Data Gagal", 'data' => '']);
        }

        return response()->json(['kode' => 1, "msg" => "Download Data Berhasil", 'data' =>'']);
    }

    public function checkRegistrasi(Request $request){
        $kodeMember = $request->kodemember;
        date_default_timezone_set('Asia/Jakarta');
        $date   = date('Y-m-d H:i:s');

        try{
            $temp = DB::connection($_SESSION['connection'])
                ->table('tbmaster_customer')
                ->where('cus_kodemember','=',$kodeMember)
                ->where('cus_namamember', '<>','NEW')
                ->whereNotNull('cus_tglregistrasi')
                ->first();

            $tglmulai = DB::connection($_SESSION['connection'])->table('tbmaster_customer')
                ->select('cus_tglmulai')
                ->where('cus_kodemember', $kodeMember)
                ->first();

            $tglmulai = (!$tglmulai->cus_tglmulai) ? $date : $tglmulai->cus_tglmulai;

            if ($temp){
                return response()->json(['kode' => 1, "msg" => "Tgl registrasi sudah terisi", 'data' =>'']);
            } else {
                DB::connection($_SESSION['connection'])
                    ->table('tbmaster_customer')
                    ->where('cus_kodemember', $kodeMember)
                    ->update(['cus_tglregistrasi' => $tglmulai]);
            }

            return response()->json(['kode' => 1, 'msg' => "Tgl registrasi berhasil diisi", 'data' =>'']);
        }catch (\Exception $e){
            return response()->json(['kode' => 0, 'msg' => "Gagal update : ".$e->getMessage() , 'data' =>'']);
        }
    }
}
